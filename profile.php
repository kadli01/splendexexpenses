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
<body>

	<?php include('resources/include/header.php'); ?>
	
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
	
	<?php include('resources/include/scripts.php'); ?>
</body>
</html>