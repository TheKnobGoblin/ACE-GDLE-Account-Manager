<?php

	if($_POST) {

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
			$user_password = $_POST['password'];
			$user_cpassword = $_POST['cpassword'];
			$confirm_key = $_POST["id"];
			
			if(strlen($user_password) < 8) {
				echo "Password must be at least 8 characters";
			}
			if ($user_password !== $user_cpassword) {
				echo "Your password's do not match";
			}

			try {
				
				if ($emulator == "ACE") {
					$stmt = $db_con->prepare("SELECT email_Address FROM account WHERE auth_Token = :key");
				}
				else {
					$stmt = $db_con->prepare("SELECT email FROM accounts WHERE auth_token = :key");
				}
				$stmt->execute(array(":key"=>$confirm_key));
				$result = $stmt->fetchColumn();

				if ($result) {
					
					if ($emulator == "ACE") {
						$stmt2 = $db_con->prepare("SELECT * FROM account WHERE email_Address = :email AND auth_Token = :key");
					}
					else {
						$stmt2 = $db_con->prepare("SELECT * FROM accounts WHERE email = :email AND auth_token = :key");
					}
					$stmt2->execute(array(":email"=>$user_email, ":key"=>$confirm_key));
					$emailCount = $stmt2->rowCount();

					if ($emailCount > 0) {
						
						if ($use_BCRYPT) {
							$salt = "bcrypt";
							$hashedPW2 = password_hash($user_password, PASSWORD_BCRYPT);
						}
						else {
							$salt = bin2hex(random_bytes(8));
							$hashedPW = hash('sha512', $user_password.$salt);
							$hashedPW2 = substr($hashedPW, 0, 64);
						}
						
						if ($emulator == "ACE") {
							$stmt3 = $db_con->prepare("UPDATE account SET passwordHash = :pass WHERE email_Address = :email");
						}
						else {
							$stmt3 = $db_con->prepare("UPDATE accounts SET password = :pass WHERE email = :email");
						}
						$stmt3->bindParam(":pass",$hashedPW2);
						$stmt3->bindParam(":email",$user_email);
						
						if($stmt3->execute()) {
						
							if ($emulator == "ACE") {
								$stmt4 = $db_con->prepare("UPDATE account SET passwordSalt = :salt WHERE email_Address = :email");
							}
							else {
								$stmt4 = $db_con->prepare("UPDATE accounts SET password_salt = :salt WHERE email = :email");
							}
							$stmt4->bindParam(":salt",$salt);
							$stmt4->bindParam(":email",$user_email);

							if($stmt4->execute()) {
								
								if ($emulator == "ACE") {
									$stmt5 = $db_con->prepare("UPDATE account SET auth_Token = '' WHERE auth_Token = :key");
								}
								else {
									$stmt5 = $db_con->prepare("UPDATE accounts SET auth_token = '' WHERE auth_token = :key");
								}
								$stmt5->bindParam(":key",$confirm_key);

								if($stmt5->execute()) {
									echo "resetpw"; // Success response
								}
							}
						}
					}
					else {
						echo "Email address and confirmation code do not match";
					}
				}
				else {
					echo "Invalid confirmation code";
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

?>