
<?php include('resources/functions/functions.php'); isLoggedIn(); ?>
<?php include('resources/include/head.php'); ?>
<?php include('resources/include/header.php'); ?>
<?php $details = getExpenseDetails($_GET['expenseId']); ?>	
<?php include('resources/functions/connection.php'); ?>
	
	<section class="create">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<h4>Expense Description</h4>
					<form action="">
						<div class="top">
							<div class="form-group">
								<label for="">Expense Name</label>
								<input type="text" class="form-control" value="<?php echo $details['expense_name']; ?>" disabled>
							</div>
							<div class="form-group">
								<label for="">Currency</label>
								<select name="" id="" class="form-control" disabled>
									<option value="">HUF (Ft)</option>
								</select>
							</div>
							<div class="form-group">
								<label for="">Amount</label>
								<input type="text" class="form-control" value="<?php  echo $details['amount'] ?>" disabled="">
							</div>
							<div class="form-group">
								<label for="">Date</label>
								<input type="text" class="form-control" value="<?php  $time =strtotime($details['created_at']);
									 echo ( date('Y/m/d',$time));
								 ?>" disabled="">
							</div>
							<div class="form-group">
								<label for="">Paid by</label>
								<select name="" id="" class="form-control" disabled="">
									<option value="">
										<?php 	
										$select = $db->prepare("SELECT user_name FROM users WHERE user_id = ?");
    									$select->execute([$details['paid_by']]); 
    									$paidBy = $select->fetch(PDO::FETCH_ASSOC);
    									echo ( $paidBy['user_name']);
    									?>	
    								</option>
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