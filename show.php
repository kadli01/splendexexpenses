<?php include('resources/include/head.php'); ?>
<?php include('resources/functions/functions.php'); isLoggedIn(); ?>
<?php $expenses = getExpenses($_GET['accountId']); ?>
<?php include('resources/include/header.php'); ?>

<?php $details = getAccounts($_GET['accountId']);
$members = getMembers($_GET['accountId']);
$currency = getCurrency();	
$accId = $_GET['accountId'];
$dir ="public/uploads/"; 
$wow = whoOwesWhat();
?>
	<section class="account-show">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<div class="show__wrapper">
						<div class="show__top">
							<img src="<?php if($details[$accId]['image']){
								echo $dir.$details[$accId]['image']; 
							} else {
								echo "http://via.placeholder.com/100x100";
							}?>">
							<h3><?php echo $details[$accId]['account_name'];?></h3>
							<span><?php 
								if ($details[$accId]['currency'] === 'USD') {
									echo "$";
								}
								echo $details[$accId]['SUM(e.amount)'];
								if($details[$accId]['currency'] === 'HUF'){
									echo " Ft";
							}?></span>
									
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
										<?php foreach ($members as $member): ?>
										<div class="d-flex">
											<div class="item">
												<p>
												<?php if($member['user_name']){
												 	echo $member['user_name'];
												 } else {
													echo "Unknown - " . $member['email'];
												}?>
												</p>
												<span>
												<?php if (getLastPaid($member['user_id'], $accId)): ?>
												Last Paid: <?php echo(getLastPaid($member['user_id'],$accId)['expense_name']); ?>
												
											<?php else :{
												echo "Did not pay for anything.";
											} ?><?php endif ?>
											 </span>
											</div>
											<div class="item">
												<p><?php 
												$balance = getBalance($member['user_id']);
												if(isset($balance[0])){
													$x = $balance['paid'] - $balance[0]['sum(p.debt)'];
													if ($currency[0] === 'HUF') {
														if ($x >= 0) {
															echo "+" . $x . " Ft";
														} else {
															echo $x . " Ft";
														}
													} else {
														if ($x >= 0){
															echo "+$" . $x;
														}
														else{
															echo "-$" . ($x*-1);
														}
													}
												}elseif ($currency[0] === 'HUF'){
													if (!$balance['paid']) {
														echo "0 Ft";
													} else {
														echo $balance['paid'] . ' Ft';
													}
												} else {
													if (!$balance['paid']) {
														echo "$0";
													} else {
														echo "$" . $balance['paid'];
													}
												}
												?></p>
											</div>
										</div>
										<?php endforeach ?>
									</div>
								</div>
								<div class="tab-pane fade" id="owe" role="tabpanel" aria-labelledby="owe-tab">
									<div class="tab__wrapper text-center">
										<h4>Who Owes What</h4>
										<?php foreach ($wow as $w): ?>
										<div class="d-flex">
											<div class="item"?>
												<?php echo '<a href=""><p>' . $w['user_name'] .  '</p></a>'; ?>
												<?php echo '<span>Owes ' . $w[0]['user_name'] . '</span>'; ?>
											</div>
											<div class="item">
												<p><?php 
												if($currency[0] == 'HUF'){
													echo '<p>' . $w['sum(pf.debt)'] . ' Ft' . '</p>';
												}else{
													echo '<p>' . ' $' . $w['sum(pf.debt)'] . '</p>';
												}  ?></p>
											</div>
											<div class="item">
												<form action="" method="post">
													<input type="hidden" name="paidFor" value="<?php echo $w['paid_for']; ?>">
													<input type="hidden" name="paidBy" value="<?php echo $w['paid_by']; ?>">
													<input type="hidden" name="debt" value="<?php echo $w['sum(pf.debt)']; ?>">
													<input type="hidden" name="expense_id" value="<?php echo $w['expense_id']; ?>">
													<button type="button" name="settle" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">Settle</button>

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
																<?php 
																if($currency[0] == 'HUF'){
																	echo '<p>Are you sure you\'d like to settle ' . $w["user_name"] . '\'s debt of ' . $w['sum(pf.debt)'] . ' Ft?</p>';
																}else {
																	echo '<p>Are you sure you\'d like to settle Péter\'s debt of $15?</p>';
																} ?>
																
															</div>
															<div class="modal-footer">
																<button type="button" data-dismiss="modal" name="noBtn" class="btn btn-primary">No</a>
																<button type="submit" name="settleYesBtn" class="btn btn-primary">Yes</a>
															</div>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
										<?php endforeach ?>
									</div>
								</div>

								<div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="expenses-tab">
									<div class="tab__wrapper text-center">
										<h4>Expenses</h4>
										<?php if(!empty($expenses)) {
											foreach($expenses as $i => $expense):
												echo '<div class="d-flex">';
												echo '<div class="item">';
												echo '<a href="expense-show.php?accountId=' . $_GET["accountId"] . '&' . 'expenseId='.$expenses{$i}["expense_id"] . '"><p>' . $expenses{$i}["expense_name"] . '</p></a>';
												echo '<span>' . $expenses{$i}["user_name"] . ' paid for it</span>';
												echo '<span class="d-block">' . $expenses{$i}['created_at'] .  '</span>';
												echo '</div>';
												echo '<div class="item">';
												if($currency[0] == 'HUF'){
													echo '<p>' . $expenses{$i}['amount'] . ' Ft' . '</p>';
												}else{
													echo '<p>' . ' $' . $expenses{$i}['amount'] . '</p>';
												}
												echo '</div>';
												echo '</div>';
											endforeach;
										}else { echo 'There are no Expenses for this account!<br><br>';} ?>
										<a href="new-expense.php?accountId=<?php echo $_GET['accountId']; ?>"class="btn btn-primary">Add New</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include('resources/include/scripts.php'); ?>