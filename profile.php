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
<?php include('resources/functions/functions.php'); isLoggedIn();?>
<body>

<?php include('resources/include/header.php'); ?>
	
	<section class="form">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<form action="" method="POST">
						<div class="top">
							<h4>Basic Info</h4>
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control" value="<?php returnName(); ?>">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" class="form-control" value="<?php returnEmail(); ?>">
							</div>
							<input type="submit" name="updateBasicBtn" class="btn btn-primary" value="Change">
						</div>
					</form>
					<form action="" method="POST">
						<div class="bottom">
							<h4>Change Password</h4>
							<div class="form-group">
								<label for="">Old Password</label>
								<input type="password" name="oldPwd" class="form-control">
							</div>
							<div class="form-group">
								<label for="">New password</label>
								<input type="password" name="newPwd" class="form-control">
							</div>
							<div class="form-group">
								<label for="">New password again</label>
								<input type="password" name="newPwdAgain" class="form-control">
							</div>
							<input type="submit" name="updatePwdBtn" class="btn btn-primary" value="Change">
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