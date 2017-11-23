
<?php include('resources/include/head.php'); ?>
<?php include('resources/functions/functions.php'); isLoggedIn(); 
//phpinfo();
$accounts = getAccounts();
$dir ="public/uploads/"; ?>
<?php 
				if (!empty($_SESSION['createError'])) {
					echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success">' . $_SESSION['createError'] . '</div>';	
					unset($_SESSION['createError']);
			} ?>

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
				<?php foreach ($accounts as $account): ?>
				<div class="col-3">

					<a href="show.php?accountId=<?php echo $account['account_id'] ?>">

						<div class="accounts__card" style="margin-bottom: 15px">
							<div class="card__content">
								<img src="<?php 
									if(isset($account['image'])){
										echo $dir . $account['image'];	
									} else {
										echo "http://via.placeholder.com/100x100";
									}?> " class="img-fluid">
								<p><?php echo $account['account_name']; ?></p>
								<span><?php 
									if($account['currency'] === "USD"){
										if(isset($account['SUM(e.amount)'])) {
											echo '$' . $account['SUM(e.amount)'];
										} else { echo '$0'; }
									} elseif ($account['currency'] === "HUF") {
										if(isset($account['SUM(e.amount)'])) {
											echo $account['SUM(e.amount)'] . ' Ft';
										} else { echo '0 Ft'; }
									}
									?></span>
								<div class="content__icons">
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
									<i class="fa fa-user"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<?php endforeach ?>
				<!--<div class="col-3">
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
				</div>-->
			</div>
		</div>
	</section>

	
	<?php include('resources/include/scripts.php'); ?>