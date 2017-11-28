
<?php 
include('resources/functions/functions.php'); isLoggedIn();
include('resources/include/head.php');
include('resources/include/header.php');
$details = getExpenseDetails($_GET['expenseId']); 
$currency = getCurrency();
$expenseId = $_GET['expenseId'];
$paidForDetails = getPaidFor($expenseId);
?>
	
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
								<input type="text" class="form-control" value="<?php  $time = strtotime($details['created_at']);
									 echo (date('Y/m/d',$time));
								 ?>" disabled="">
							</div>
							<div class="form-group">
								<label for="">Paid by</label>
								<select name="" id="" class="form-control" disabled="">
									<option value="">
										<?php 	
										$select = $db->prepare("SELECT user_name, email FROM users WHERE user_id = ?");
    									$select->execute([$details['paid_by']]); 
    									$paidBy = $select->fetch(PDO::FETCH_ASSOC);
    										
    										if ($paidBy['user_name']) {
    											echo ($paidBy['user_name']);
    										} else {
    											echo "Unknown - " . $paidBy['email'];
    										}
    									?>	
    								</option>
								</select>
							</div>
						</div>
						<div class="bottom">
							<h4>Paid For:</h4>
							<?php foreach ($paidForDetails as $paidForDetail):
								echo '<div class="d-flex">';
								echo '<div class="item">';
								if ($paidForDetail['user_name']) {
									echo '<p>' . $paidForDetail['user_name'] . '</p>';
								} else {
									echo '<p>Unknown - ' . $paidForDetail['email'] . '</p>';
								}
								echo '</div>';
								echo '<div class="item">';
								echo '<div class="input-group">';
								echo '<input type="text" class="form-control" value="' . $paidForDetail['debt'] . '" disabled="">';
								echo '<span class="input-group-addon" id="basic-addon1"><?php echo $currency[0] ?>' . $currency[0] . '</span>';
								echo '</div>';
								echo '</div>';
								echo '</div>';
							endforeach; ?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	
	<?php include('resources/include/scripts.php'); ?>