<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	if($_POST) {
		
		require 'phpmailer/Exception.php';
		require 'phpmailer/PHPMailer.php';
		require 'phpmailer/SMTP.php';
		
		include("inc/db.php");
		include("config.php");
		include("inc/funcs.php");

		# Call the function post_captcha
		$res = post_captcha($_POST['g-recaptcha-response']);

		if (!$res['success']) {
			# What happens when the CAPTCHA wasn't checked
			echo "Please make sure you check the security CAPTCHA box";
		}
		else {
			# CAPTCHA successfully completed
			$remoteIP = "";
			if (isset($_SERVER["REMOTE_ADDR"])) {
				$remoteIP = $_SERVER["REMOTE_ADDR"];
			}
			$ip_bin = inet_pton($remoteIP);
			$user_name = $_POST['user_name'];
			$user_email = $_POST['user_email'];
			$user_cemail = $_POST['confirm_email'];
			$user_password = $_POST['password'];
			$user_cpassword = $_POST['cpassword'];
			$domain = explode("@", $user_email);
			$domain = $domain[(count($domain)-1)];
		  
			try {

				if ($emulator == "ACE") {
					# PDO queries
					$stmt = $db_con->prepare("SELECT * FROM account WHERE accountName = :uname");
					$stmt->execute(array(":uname"=>$user_name));
					$userCount = $stmt->rowCount();
					
					$stmt2 = $db_con->prepare("SELECT * FROM account WHERE email_Address = :email");
					$stmt2->execute(array(":email"=>$user_email));
					$emailCount = $stmt2->rowCount();
					
					$stmt3 = $db_con->prepare("SELECT * FROM account WHERE create_I_P_ntoa = :ip");
					$stmt3->execute(array(":ip"=>$remoteIP));
					$ipCount = $stmt3->rowCount();
				}
				else {
					$stmt = $db_con->prepare("SELECT * FROM accounts WHERE username = :uname");
					$stmt->execute(array(":uname"=>$user_name));
					$userCount = $stmt->rowCount();
					
					$stmt2 = $db_con->prepare("SELECT * FROM accounts WHERE email = :email");
					$stmt2->execute(array(":email"=>$user_email));
					$emailCount = $stmt2->rowCount();
					
					$stmt3 = $db_con->prepare("SELECT * FROM accounts WHERE created_ip_address = :ip");
					$stmt3->execute(array(":ip"=>$remoteIP));
					$ipCount = $stmt3->rowCount();
				}

				# Authentication checks
				if (isset($proxy_protection)) {
					$key = $ipqualityscore_key;
					$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_CLIENT_IP'];
					$strictness = 1;
					$result = json_decode(file_get_contents(sprintf('https://ipqualityscore.com/api/json/ip/%s/%s?strictness=%s', $key, $ip, $strictness)), true);
					if($result !== null){
						if(isset($result['proxy']) && $result['proxy'] == true){
							echo "Please disable your proxy/vpn connection";
							exit();            
						}
					}
				}
				if (!preg_match('/^[A-Za-z][A-Za-z0-9-_]{3,24}$/', $user_name)) {
					echo "Invalid username format";
				}
				elseif ($userCount > 0) {
					echo "Username already exists";
				}
				elseif ($emailCount > 0) {
					echo "1"; //  Failure response
				}
				elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
					echo "Invalid email format";
				}
				elseif (in_array($domain, $blacklist)) {
					echo "Email provider not allowed";
				}
				elseif ($user_email !== $user_cemail) {
					echo "Email address does not match with confirm";
				}
				elseif (!preg_match('/^\S+$/', $user_password)) {
					echo "Invalid password format - no spaces allowed";
				}
				elseif(strlen($user_password) < 8) {
					echo "Password must be at least 8 characters";
				}
				elseif ($user_password !== $user_cpassword) {
					echo "Password does not match with confirm";
				}
				elseif ($ipCount >= $ipLimit) {
					echo "Account limit reached for IP address ".$ipaddress;
				}
				elseif (!isset($_POST['terms']) || empty($_POST['terms'])) {
					echo "Please indicate that you agree to the Terms";
				}
				else {
					# Authentication checks passed
					$token = bin2hex(random_bytes(128));
					$hashedToken = hash('sha512', $token.$user_email);
					
					if ($use_BCRYPT) {
						$salt = "use bcrypt";
						$hashedPW2 = password_hash($user_password, PASSWORD_BCRYPT);
					}
					else {
						$salt = bin2hex(random_bytes(8));
						$hashedPW = hash('sha512', $user_password.$salt);
						$hashedPW2 = substr($hashedPW, 0, 64);
					}
					
					if ($emulator == "ACE") {
						$stmt = $db_con->prepare("INSERT INTO account(accountName,passwordHash,passwordSalt,auth_Token,accessLevel,email_Address,create_I_P) VALUES(:uname, :pass, :salt, :token, 0, :email, :ntoa)");
						$stmt->bindParam(":uname",$user_name);
						$stmt->bindParam(":pass",$hashedPW2);
						$stmt->bindParam(":salt",$salt);
						$stmt->bindParam(":token",$hashedToken);
						$stmt->bindParam(":email",$user_email);
						$stmt->bindParam(":ntoa",$ip_bin);
					}
					else {
						$stmt = $db_con->prepare("INSERT INTO accounts(username,password,password_salt,auth_token,date_created,access,created_ip_address,email,emailsetused,banned) VALUES(:uname, :pass, :salt, :token, ('".time()."'), 0, :ip, :email, 0, 0)");
						$stmt->bindParam(":uname",$user_name);
						$stmt->bindParam(":pass",$hashedPW2);
						$stmt->bindParam(":salt",$salt);
						$stmt->bindParam(":token",$hashedToken);
						$stmt->bindParam(":ip",$remoteIP);
						$stmt->bindParam(":email",$user_email);
					}

					if($stmt->execute()) {
						$dir = basename(dirname(__FILE__));
						$url = "https://$_SERVER[HTTP_HOST]/$dir/"."verify.php?id=";
						$mail = new PHPMailer(TRUE);

						try {
						   $mail->setFrom($admin_email, $admin_email);
						   $mail->addAddress($user_email, $user_name);
						   $mail->Subject = 'Account Verification';
						   $mail->isHTML(TRUE);
						   $mail->Body = '<html>Hello '.$user_name.',<br><br> Please verify your email by clicking the below link.<br><br>' .$url . $hashedToken.'</html>';
						   
						   /* SMTP parameters. */
						   $mail->isSMTP();
						   $mail->Host = $email_host;
						   $mail->SMTPAuth = TRUE;
						   $mail->SMTPSecure = 'tls';
						   $mail->Username = $admin_email;
						   $mail->Password = $email_password;
						   $mail->Port = $email_port;
						   
						   $mail->send();
						}
						catch (Exception $e) {
						   echo $e->errorMessage();
						}
						catch (\Exception $e) {
						   echo $e->getMessage();
						}
						echo "registered"; // Success response
					}
					else {
						echo "Query could not execute";
					}
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

?>