
<?php include('resources/include/head.php'); ?>
<?php include('resources/functions/functions.php'); isLoggedIn(); 
$accounts = getAccounts(); ?>



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
				<?php foreach ($accounts as $account) {
					
				
				echo '<div class="col-3">';
					echo '<a href="show.php">';
						echo '<div class="accounts__card">';
							echo '<div class="card__content">';

								echo '<img src="http://via.placeholder.com/100x100" class="img-fluid">';
								echo '<p>' . $account['account_name'] . '</p>';
								echo '<span>' . $account['total'] . '</span>';
								echo '<div class="content__icons">';
									echo '<i class="fa fa-user"></i>';
									echo '<i class="fa fa-user"></i>';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</a>';
				echo '</div>';
				} ?>
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