<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Splendex Expenses</title>

	<link rel="stylesheet" href="../../public/assets/css/bootstrap.css">
	<link rel="stylesheet" href="../../public/assets/css/shards.css">
	<link rel="stylesheet" href="../../public/assets/css/font-awesome.css">

	<link rel="stylesheet" href="../../public/assets/css/style.css">
</head>
<?php 
session_start();
if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
	header('location: index.php');
	exit();
}
?>
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

	<section class="accounts">
		<div class="container">
			<div class="row">
				<div class="col-3">
					<a href="new-account.html">
						<div class="accounts__card first text-center">
							<div class="card__content">
								<i class="fa fa-plus"></i>
								<p>Add New</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-3">
					<a href="show.html">
						<div class="accounts__card">
							<div class="card__content">
								<img src="http://via.placeholder.com/100x100" class="img-fluid">
								<p>Dinner</p>
								<span>$235</span>
								<div class="content__icons">
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-3">
					<a href="show.html">
						<div class="accounts__card">
							<div class="card__content">
								<img src="http://via.placeholder.com/100x100" class="img-fluid">
								<p>Gas</p>
								<span>$235</span>
								<div class="content__icons">
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-3">
					<a href="show.html">
						<div class="accounts__card">
							<div class="card__content">
								<img src="http://via.placeholder.com/100x100" class="img-fluid">
								<p>Hotel</p>
								<span>$235</span>
								<div class="content__icons">
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
								</div>
							</div>
						</div>
					</a>
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