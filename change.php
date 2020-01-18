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
			$user_email = $_POST['user_email'];
			
			# Email validation check
			if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				echo "Invalid email format";
			}
			else {
				try {
					
					# PDO queries
					if ($emulator == "ACE") {
						$stmt = $db_con->prepare("SELECT * FROM account WHERE email_Address = :email");
					}
					else {
						$stmt = $db_con->prepare("SELECT * FROM accounts WHERE email = :email");
					}
					$stmt->execute(array(":email"=>$user_email));
					$emailCount = $stmt->rowCount();
					
					if ($emailCount > 0) {
						$token = bin2hex(random_bytes(128));
						$hashedToken = hash('sha512', $token.$user_email);

						if ($emulator == "ACE") {
							$stmt2 = $db_con->prepare("UPDATE account SET auth_Token = :token WHERE email_Address = :email");
						}
						else {
							$stmt2 = $db_con->prepare("UPDATE accounts SET auth_token = :token WHERE email = :email");
						}
						$stmt2->bindParam(":email",$user_email);
						$stmt2->bindParam(":token",$hashedToken);
						
						if ($stmt2->execute()) {
							$dir = basename(dirname(__FILE__));
							$url = "https://$_SERVER[HTTP_HOST]/$dir/"."reset_password.php?id=";
							$mail = new PHPMailer(TRUE);

							try {

							   $mail->setFrom($admin_email, $admin_name);
							   $mail->addAddress($user_email, 'AC Player');
							   $mail->Subject = 'Account Password Reset';
							   $mail->isHTML(TRUE);
							   $mail->Body = '<html>Reset your password by clicking the below link.<br><br>'.$url.$hashedToken.'</html>';
							   
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
							echo "resetpw"; // Success response
						}
						else {
							echo "Password reset error";
						}
					}
					else {
						echo "Email address not found";
					}
				}
				catch(PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
	}
?>