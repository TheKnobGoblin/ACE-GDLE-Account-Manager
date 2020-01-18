<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asheron's Call Server</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript">
$('document').ready(function()
{ 
	$("#back").click(function(){
		window.location.href = "index.php";
	});
});
</script>

</head>

<?php

	include ("inc/db.php");
	include("config.php");
	
	if (!isset($_GET['id'])) {
		echo "	<div class='container'>
				<div class='alert alert-danger'>
				<span class='glyphicon glyphicon-info-sign'></span>&nbsp;
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Error!</strong> Invalid data format.</div>
				<button class='btn btn-primary' id='back'>
				<span class='glyphicon glyphicon-backward'></span> &nbsp; back to main page
				</button></div>";
		exit;
	}

	$confirm_key = $_GET["id"];
	$key_length = strlen($confirm_key);

	if ($key_length !== 128) {
		echo "	<div class='container'>
				<div class='alert alert-danger'>
				<span class='glyphicon glyphicon-info-sign'></span>&nbsp;
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Error!</strong> Invalid data format.</div>
				<button class='btn btn-primary' id='back'>
				<span class='glyphicon glyphicon-backward'></span> &nbsp; back to main page
				</button></div>";
		exit;
	}
	
	$msg = "";
	
	try {
		
		if ($emulator == "ACE") {
			$stmt = $db_con->prepare("SELECT email_Address FROM account WHERE auth_Token = :key");
		}
		else {
			$stmt = $db_con->prepare("SELECT email FROM accounts WHERE auth_token = :key");
		}
		$stmt->execute(array(":key"=>$confirm_key));
		//$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$result = $stmt->fetchColumn();
		
		if ($result) {
			
			if ($emulator == "ACE") {
				$query = $db_con->prepare("UPDATE account SET accessLevel = :access WHERE email_Address = :email");
			}
			else {
				$query = $db_con->prepare("UPDATE accounts SET access = :access WHERE email = :email");
			}
			$query->bindParam(":access",$access_level);
			$query->bindParam(":email",$result);
			
			if ($query->execute()) {
				
				if ($emulator == "ACE") {
					$del = $db_con->prepare("UPDATE account SET auth_Token = '' WHERE auth_Token = :key");
				}
				else {
					$del = $db_con->prepare("UPDATE accounts SET auth_token = '' WHERE auth_token = :key");
				}
				$del->bindParam(":key",$confirm_key);
				
				if ($del->execute()) {
					$msg = "<div class='alert alert-success'>
							<span class='glyphicon glyphicon-info-sign'></span>&nbsp;
							<button class='close' data-dismiss='alert'>&times;</button>
							<strong>Success!</strong>  Thank you. Your account has been successfully activated. You can now login with your account information.</div>";
				}
			}
		}
		else {
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span>&nbsp;
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Verification failed!</strong> Invalid confirmation code <strong>(or)</strong> email address already activated.</div>";
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

?>

<body>

<div class="container">

    <div><?php echo $msg;?></div>
    
    <button class="btn btn-primary" id="back">
		<span class="glyphicon glyphicon-backward"></span> &nbsp; back to main page
    </button>
    
</div>

</body>
</html>