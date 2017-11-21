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
<?php 
session_start();
if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
	header('location: index.php');
	exit();
}
?>
<body>

	<?php include('resources/include/header.php'); ?>
	
	<section class="accounts">
		<div class="container">
			<div class="row">
				<div class="col-3">
					<a href="new-account.php">
						<div class="accounts__card first text-center">
							<div class="card__content">
								<i class="fa fa-plus"></i>
								<p>Add New</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-3">
					<a href="show.php">
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
					<a href="show.php">
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
					<a href="show.php">
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

	
	<?php include('resources/include/scripts.php'); ?>
</body>
</html>