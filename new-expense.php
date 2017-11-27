<?php 
include('resources/include/head.php'); 
include('resources/functions/functions.php'); 
isLoggedIn();
$accounts = getAccounts();
$currency = getCurrency();
if(isset($_GET['accountId'])) $members = getMembers($_GET['accountId']);
if(!empty($_SESSION['expenseError'])){
	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">' . $_SESSION['expenseError'] . '</div>';	
		unset($_SESSION['expenseError']);
}

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
								<input type="text" name="expenseName" maxlength="30" class="form-control" value="<?php if(isset($_POST['expenseName'])) echo $_POST['expenseName'] ?>">
							</div>
							<div class="form-group">
								<label for="expenseCurrency">Currency</label>
								<select name="expenseCurrency" id="" class="form-control">
									<?php echo '<option value="">' . $currency[0] . '</option>'; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="amount">Amount</label>
								<input name="amount" step="0.5" type="number" class="form-control" value="<?php if(isset($_POST['amount'])) echo $_POST['amount']; ?>">
							</div>
							<div class="form-group">
								<label for="date">Date</label>
								<input name="date" type="text" class="form-control" id="datepicker" value="">
							</div>
							<div class="form-group">
								<label for="">Paid by</label>
								<select name="paidBy" id="" class="form-control">
									<?php foreach ($members as $member):
										echo '<option value="' . $member['user_id'] . '">' . $member["user_name"] . '</option>';
									endforeach ?>
								</select>
							</div>
						</div>
						<div class="bottom">
							<h4>Paid For:</h4>
							<?php foreach($members as $member):
							echo '<div class="d-flex">';
							echo '<div class="item">';
							echo '<p>' . $member['user_name'] . '</p>';
							echo '</div>';
							echo '<div class="item">';
							echo '<div class="input-group">';
							if(isset($_POST["paidFor"])){
								echo '<input name="paidFor[' . $member['user_id'] . ']" value=' . $_POST['paidFor'][$member['user_id']] . ' step="0.5" type="number" class="form-control">';
							}else{
								echo '<input name="paidFor[' . $member['user_id'] . ']" value="0" step="0.5" type="number" class="form-control">';
							}
							echo '<span class="input-group-addon" id="basic-addon1">' . $currency[0] . '</span>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
							endforeach ?>
							<input type="submit" name="createExpenseBtn" class="btn btn-primary" value="Create">
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