<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asheron's Call Server</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<?php

	if (isset($jscript2)) {
		echo '<script type="text/javascript" src="js/script2.js"></script>';
	}
	elseif (isset($jscript3)) {
		echo '<script type="text/javascript" src="js/script3.js"></script>';
	}
	else {
		echo '<script type="text/javascript" src="js/script.js"></script>';
	}

?>

</head>
<body>

	<nav class="navbar navbar-default">
		<ul class="nav navbar-nav">
			<li id="set_width" class="<?php if ($active_page=="register") {echo "active"; }?>"><a href="index.php">Register Account</a></li>
			<li id="set_width" class="<?php if ($active_page=="reset") {echo "active"; }?>"><a href="forgot_password.php">Reset Password</a></li>
		</ul>
	</nav>