<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Splendex Expenses</title>

	<link rel="stylesheet" href="public/assets/css/bootstrap.css">
	<link rel="stylesheet" href="public/assets/css/shards.css">
	<link rel="stylesheet" href="public/assets/css/font-awesome.css">

	<link rel="stylesheet" href="public/assets/css/style.css">
</head>
<?php include('resources/functions/functions.php'); isLoggedIn(); ?>
<body>

	<header>
		<nav class="navbar navbar-expand-lg bg-dark">
		<div class="container">
			<a class="navbar-brand" href="account.php">
				Splendex Expenses
			</a>
			<button class="navbar-toggler" id="nav-icon" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-icon-bar"></span>
				<span class="navbar-icon-bar"></span>
				<span class="navbar-icon-bar"></span>
				<span class="navbar-icon-bar"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link" href="account.php">Accounts</a>
					<a class="nav-item nav-link" href="profile.php">My Profile</a>
					<a class="nav-item nav-link" href="index.php">Logout</a>
				</div>
			</div>
		</div>
	</nav>
	</header>
	
	<section class="form">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<form action="">
						<div class="top">
							<h4>Basic Info</h4>
							<div class="form-group">
								<label for="">Name</label>
								<input type="text" class="form-control">
							</div>
							<div class="form-group">
								<label for="">Email</label>
								<input type="email" class="form-control">
							</div>
							<button class="btn btn-primary">Change</button>
						</div>
						<div class="bottom">
							<h4>Change Password</h4>
							<div class="form-group">
								<label for="">Old Password</label>
								<input type="password" class="form-control">
							</div>
							<div class="form-group">
								<label for="">New password</label>
								<input type="password" class="form-control">
							</div>
							<div class="form-group">
								<label for="">New password again</label>
								<input type="password" class="form-control">
							</div>
							<button class="btn btn-primary">Change</button>
						</div>
					</form>
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