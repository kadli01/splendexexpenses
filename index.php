<?php include('resources/include/head.php'); ?>
	<?php session_start(); include('resources/functions/login.php');?>
	<section class="auth">
		<div class="container">
			<h1>Splendex Expenses</h1>
			<div class="auth__wrapper">
				<div class="d-flex">
					<div class="auth__item">
						<div class="item__title">
							<h4>Sign In</h4>
						</div>
						<div class="item__text">
							<p>Use your existing account to sign in.</p>
						</div>
						<div class="item__form">
							<form  method="post">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" name="email" class="form-control" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} ?>">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" class="form-control">
								</div>
								<input type="submit" name="bttLogin" class="btn btn-primary float-right" value="Login">
							</form>
						</div>
					</div>
					<div class="auth__item">
						<div class="item__title">
							<h4>Register</h4>
						</div>
						<div class="item__text">
							<p>Create a new account now!</p>
							<?php
								if(isset($_SESSION['error_message']))
								{
									session_start();
									echo '<p style="color: red">' . $_SESSION['error_message'] . "</p>";
									unset($_SESSION['error_message']);
								}
							?>
						</div>
						<div class="item__form">
							<form action="resources/functions/registration.php" method="post">
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" class="form-control" name="reg_email">
								</div>
								<div class="form-group">
									<label for="">Password</label>
									<input type="password" class="form-control" name="reg_password">
								</div>
								<div class="form-group">
									<label for="">Password again</label>
									<input type="password" class="form-control" name="reg_password_again">
								</div>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" checked name="terms">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">I accept the Terms & Conditions</span>
								</label>
								<input type="submit" class="btn btn-primary" name="signup" value="Sign Up">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



	
<?php include('resources/include/scripts.php'); ?>

