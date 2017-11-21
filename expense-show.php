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

	<?php include('resources/include/header.php'); ?>
	
	<section class="create">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<h4>Expense Description</h4>
					<form action="">
						<div class="top">
							<div class="form-group">
								<label for="">Expense Name</label>
								<input type="text" class="form-control" value="Main Course" disabled>
							</div>
							<div class="form-group">
								<label for="">Currency</label>
								<select name="" id="" class="form-control" disabled>
									<option value="">HUF (Ft)</option>
								</select>
							</div>
							<div class="form-group">
								<label for="">Amount</label>
								<input type="text" class="form-control" value="235" disabled="">
							</div>
							<div class="form-group">
								<label for="">Date</label>
								<input type="text" class="form-control" value="2017/11/14" disabled="">
							</div>
							<div class="form-group">
								<label for="">Paid by</label>
								<select name="" id="" class="form-control" disabled="">
									<option value="">Péter Varga</option>
								</select>
							</div>
						</div>
						<div class="bottom">
							<h4>Paid For:</h4>
							<div class="d-flex">
								<div class="item">
									<p>Péter Varga</p>
								</div>
								<div class="item">
									<div class="input-group">
										<input type="text" class="form-control" value="70" disabled="">
										<span class="input-group-addon" id="basic-addon1">HUF</span>
									</div>
								</div>
							</div>
							<div class="d-flex">
								<div class="item">
									<p>Dániel Petres</p>
								</div>
								<div class="item">
									<div class="input-group">
										<input type="text" class="form-control" value="65" disabled="">
										<span class="input-group-addon" id="basic-addon1">HUF</span>
									</div>
								</div>
							</div>
							<div class="d-flex">
								<div class="item">
									<p>André Timár</p>
								</div>
								<div class="item">
									<div class="input-group">
										<input type="text" class="form-control" value="100" disabled="">
										<span class="input-group-addon" id="basic-addon1">HUF</span>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	
	<?php include('resources/include/scripts.php'); ?>
</body>
</html>