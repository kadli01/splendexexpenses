<?php 
include('resources/include/head.php'); 
include('resources/functions/functions.php'); isLoggedIn();
$accounts = getAccounts();
$currency = getCurrency();
if(isset($_GET['accountId'])) $members = getMembers($_GET['accountId']);
?>
	<?php include('resources/include/header.php'); ?>
	
	<section class="create">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<h4>Expense Description</h4>
					<form action="" method="POST">
						<div class="top">
							<div class="form-group">
								<label for="expenseName">Expense Name</label>
								<input type="text" name="expenseName" class="form-control">
							</div>
							<div class="form-group">
								<label for="expenseCurrency">Currency</label>
								<select name="expenseCurrency" id="" class="form-control">
									<?php echo '<option value="">' . $currency[0] . '</option>'; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="">Amount</label>
								<input name="amount" type="text" class="form-control">
							</div>
							<div class="form-group">
								<label for="date">Date</label>
								<input name="date" type="text" class="form-control" id="datepicker" value="">
							</div>
							<div class="form-group">
								<label for="">Paid by</label>
								<select name="paidBy" id="" class="form-control">
									<?php foreach ($members as $member): ?>
									<?php echo '<option value="' . $member['user_id'] . '">' . $member["user_name"] . '</option>'; ?>
									<?php endforeach ?>
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
										<input type="text" class="form-control">
										<span class="input-group-addon" id="basic-addon1"><?php echo $currency[0] ?></span>
									</div>
								</div>
							</div>
							<div class="d-flex">
								<div class="item">
									<p>Dániel Petres</p>
								</div>
								<div class="item">
									<div class="input-group">
										<input type="text" class="form-control">
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
										<input type="text" class="form-control">
										<span class="input-group-addon" id="basic-addon1">HUF</span>
									</div>
								</div>
							</div>
							<a href="show.php?accountId=<?php echo $_GET["accountId"] ?>" name="createExpenseBtn" class="btn btn-primary">Create</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	
	<?php include('resources/include/scripts.php'); ?>
	<script>
	$(function(){
    	$("#datepicker").datepicker({
			calendarWeeks: true,
	    	autoclose: true,
    		todayHighlight: true,
    		dateFormat: 'yy/mm/dd',
    	}).datepicker("setDate", new Date());
	});
	</script>