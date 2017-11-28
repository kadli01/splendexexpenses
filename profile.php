<?php 
include('resources/include/head.php');
include('resources/functions/functions.php');
isLoggedIn();
include('resources/include/header.php');
?>

	<section class="form">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<form action="" method="POST">
						<div class="top">
							<h4>Basic Info</h4>
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control" value="<?php echo returnName(); ?>">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" class="form-control" value="<?php echo returnEmail(); ?>">
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
<?php include('resources/include/scripts.php'); ?>