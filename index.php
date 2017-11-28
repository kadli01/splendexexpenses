<?php 
session_start();
include('resources/include/head.php');
include('resources/functions/login.php');
if(isset($_SESSION['user_id'])){
	include('resources/functions/config.php');
    header('location:' . $config->app_url . '/account.php');
    exit();
    }
?>
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
							<?php 
								if(isset($_SESSION['loginError'])){
									echo '<p style="color: red">' . $_SESSION['loginError'] . "</p>";
									unset($_SESSION['loginError']);
								} 
							?>
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
								if(isset($_SESSION['errorMessage']))
								{
									echo '<p style="color: red">' . $_SESSION['errorMessage'] . "</p>";
									unset($_SESSION['errorMessage']);
								}
							?>
						</div>
						<div class="item__form">
							<form action="resources/functions/registration.php" method="post">
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" class="form-control" name="regEmail" value="<?php if(isset($_POST['regEmail'])) echo $_POST['regEmail']; ?>">
								</div>
								<div class="form-group">
									<label for="">Password</label>
									<input type="password" class="form-control" name="regPassword">
								</div>
								<div class="form-group">
									<label for="">Password again</label>
									<input type="password" class="form-control" name="regPasswordAgain">
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

