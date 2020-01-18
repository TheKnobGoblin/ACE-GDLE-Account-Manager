<?php

	try {
		include ('../inc/db.php');
		include ('../config.php');
		
		if ($emulator == "ACE") {
			$stmt = $db_con->prepare("USE ace_auth;");
			$stmt->execute();
			$stmt = $db_con->prepare("ALTER TABLE account ADD COLUMN auth_Token VARCHAR(128) NOT NULL AFTER passwordSalt;");
			if ($stmt->execute()) {
				echo "Successfuly updated account table.";
			}
			else {
				echo "Query failed.";
			}
		}
		else {
			$stmt = $db_con->prepare("USE gdle;");
			$stmt->execute();
			$stmt = $db_con->prepare("ALTER TABLE accounts ADD COLUMN auth_token VARCHAR(128) NOT NULL AFTER password_salt;");
			if ($stmt->execute()) {
				echo "Successfuly updated accounts table.";
			}
			else {
				echo "Query failed.";
			}
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

?>