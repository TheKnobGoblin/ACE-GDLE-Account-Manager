<?php $active_page = "register"; ?>
<?php include( "inc/header.php" ); ?>

<div class="signin-form">

	<div class="container">

		<form class="form-signin" method="post" id="register-form">

			<h2 class="form-signin-heading">- Account Registration -</h2>

			<hr />

			<div id="error"><!-- error messages --></div>

			<div class="form-group">
				<div class="inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" placeholder="Username" name="user_name" id="user_name" />
					</div>
				</div>
			</div>

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
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" class="form-control" placeholder="Confirm email address" name="confirm_email" id="confirm_email" />
						<span id="check-e"></span>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" placeholder="Password" name="password" id="password" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" id="cpassword" />
					</div>
				</div>
			</div>

			<hr />

			<div class="form-group">
				<div class="checkbox">
				  <label>
					<input type="checkbox" name="terms" value="1" id="terms" aria-checked='false'><strong>I agree to the <a href='#' class="terms">Terms of Use</a></strong>
				  </label>
				</div>
			</div>

			<!-- Google Recaptcha -->
			<div class="text-center">
				<div class="" data-sitekey="ENTER YOUR RECAPTCHA SITE KEY HERE"></div>
			</div>
			<br />

			<div class="form-group">
				<button type="submit" class="btn btn-default" name="btn-save" id="btn-submit"><span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account</button> 
			</div>

		</form>

    </div>

</div>

<div id="rules">
Please take a moment to review these rules:

We are not responsible for any actions caused by any players on our server.

We do not vouch for or warrant the accuracy, completeness or usefulness of any chat message, and are not responsible for the contents of any chat channel.

A verification email is sent after a successful account registration. If you don't receive the verification email then make sure to add our domain name to your email white list, check your spam folder, or use an entirely different email provider altogether.

Proxy/VPN connections are not permitted and will be automatically rejected if you try to register an account behind one.

By accepting these terms you agree to not cause any harm to the server which includes but not limited to game-breaking exploits from server bugs, blatant chat channel spamming, real life threats to other players, and selling in-game items for real money.
</div>

<?php include( "inc/footer.php" ); ?>