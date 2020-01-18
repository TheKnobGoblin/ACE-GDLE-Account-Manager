<?php

	$jscript3 = "";
	include( "inc/header.php" );

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

?>

<div class="signin-form">

	<div class="container">

		<form class="form-signin" method="post" id="register-form">

			<h2 class="form-signin-heading">- Reset Password -</h2>

			<hr />

			<div id="error"><!-- Error messages --></div>

			<div class="form-group">
				<div class="inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" class="form-control" placeholder="Email address" name="user_email" id="user_email" />
						<span id="check-e"></span>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" placeholder="New Password" name="password" id="password" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" placeholder="Confirm New Password" name="cpassword" id="cpassword" />
					</div>
				</div>
			</div>

			<hr />

			<!-- Google Recaptcha -->
			<div class="text-center">
				<div class="" data-sitekey="ENTER YOUR RECAPTCHA SITE KEY HERE"></div>
			</div>
			<br />

			<div class="form-group">
				<input type="hidden" name="id" value="<?php if (isset($_GET["id"])) { echo $_GET["id"]; } ?>" />
				<button type="submit" class="btn btn-default" name="btn-save" id="btn-submit"><span class="glyphicon glyphicon-log-in"></span> &nbsp; Reset Password</button> 
			</div>

		</form>

    </div>

</div>

<?php include( "inc/footer.php" ); ?>