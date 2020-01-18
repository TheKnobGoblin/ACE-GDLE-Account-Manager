<?php $active_page = "reset"; ?>
<?php $jscript2 = ""; include( "inc/header.php" ); ?>

<div class="signin-form">

	<div class="container">

		<form class="form-signin" method="post" id="register-form">

			<h2 class="form-signin-heading">- Reset Password -</h2>

			<hr />

			<div id="error"><!-- error messages --></div>

			<div class="form-group">
				<div class="inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" class="form-control" placeholder="Email address" name="user_email" id="user_email" />
						<span id="check-e"></span>
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
				<button type="submit" class="btn btn-default" name="btn-save" id="btn-submit"><span class="glyphicon glyphicon-log-in"></span> &nbsp; Reset Password</button> 
			</div>

		</form>

    </div>

</div>

<?php include( "inc/footer.php" ); ?>