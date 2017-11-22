<?php include('resources/include/head.php'); ?>
<?php include('resources/functions/functions.php'); isLoggedIn(); ?>


<?php include('resources/include/header.php'); ?>
	
	<section class="account-show">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<div class="show__wrapper">
						<div class="show__top">
							<img src="http://via.placeholder.com/100x100">
							<h3>Dinner</h3>
							<span>$235</span>
						</div>
						<div class="show__nav">
							<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Balance Summary</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="owe-tab" data-toggle="tab" href="#owe" role="tab" aria-controls="owe" aria-selected="false">Who Owes What</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="expenses" aria-selected="false">Expenses</a>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
									<div class="tab__wrapper text-center">
										<h4>Balance Summary</h4>
										<div class="d-flex">
											<div class="item">
												<p>André</p>
												<span>Last Paid: Main Course</span>
											</div>
											<div class="item">
												<p>+$45</p>
											</div>
										</div>
										<div class="d-flex">
											<div class="item">
												<p>Péter</p>
												<span>Last Paid: Cocktails</span>
											</div>
											<div class="item">
												<p>-$15</p>
											</div>
										</div>
										<div class="d-flex">
											<div class="item">
												<p>Dániel</p>
												<span>Last Paid: Apperitives</span>
											</div>
											<div class="item">
												<p>-$185</p>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="owe" role="tabpanel" aria-labelledby="owe-tab">
									<div class="tab__wrapper text-center">
										<h4>Who Owes What</h4>
										<div class="d-flex">
											<div class="item">
												<a href="" data-toggle="modal" data-target="#exampleModal"><p>Péter</p></a>
												<span>Owes André</span>
											</div>
											<div class="item">
												<p>$15</p>
											</div>
										</div>
										<div class="d-flex">
											<div class="item">
												<a href="" data-toggle="modal" data-target="#exampleModal"><p>Dániel</p></a>
												<span>Owes André</span>
											</div>
											<div class="item">
												<p>$185</p>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="expenses-tab">
									<div class="tab__wrapper text-center">
										<h4>Expenses</h4>
										<div class="d-flex">
											<div class="item">
												<a href="expense-show.php"><p>Main Course</p></a>
												<span>André paid for all</span>
												<span class="d-block">2017/11/21</span>
											</div>
											<div class="item">
												<p>$234</p>
											</div>
										</div>
										<div class="d-flex">
											<div class="item">
												<a href="expense-show.php"><p>Cocktails</p></a>
												<span>Péter paid for all</span>
												<span class="d-block">2017/11/21</span>
											</div>
											<div class="item">
												<p>$123</p>
											</div>
										</div>
										<div class="d-flex">
											<div class="item">
												<a href="expense-show.php"><p>Apperetizers</p></a>
												<span>Dani paid for André</span>
												<span class="d-block">2017/11/21</span>
											</div>
											<div class="item">
												<p>$80</p>
											</div>
										</div>
										<a href="new-expense.php" class="btn btn-primary">Add New</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<h5 class="modal-title text-center" id="exampleModalLabel">Alert</h5>
					<p>Are you sure you'd like to settle Péter's debt of $15?</p>
				</div>
				<div class="modal-footer">
					<a href="" class="btn btn-light">No</a>
					<a href="" class="btn btn-primary">Yes</a>
				</div>
			</div>
		</div>
	</div>
	
<?php include('resources/include/scripts.php'); ?>