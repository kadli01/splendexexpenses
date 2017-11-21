<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Splendex Expenses</title>

	<link rel="stylesheet" href="../../public/assets/css/bootstrap.css">
	<link rel="stylesheet" href="../../public/assets/css/shards.css">
	<link rel="stylesheet" href="../../public/assets/css/style.css">
</head>
<body>
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
							<?php include('../functions/login.php'); ?>
						</div>
						<div class="item__form">
							<form  method="post">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" name="email" class="form-control">
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
								session_start();
								echo '<p style="color: red">' . $_SESSION['error_message'] . "</p>";
								unset($_SESSION['error_message']);
							?>
						</div>
						<div class="item__form">
							<form action="../functions/registration.php" method="post">
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



	
	<script src="../../public/assets/js/jquery-1.12.4.js"></script>
	<script src="../../public/assets/js/popper.min.js"></script>
	<script src="../../public/assets/js/bootstrap.js"></script>
	<script src="../../public/assets/js/shards.js"></script>
</body>
</html>