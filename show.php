<?php 
include('resources/include/head.php');
include('resources/functions/functions.php'); 
isLoggedIn();

if(isset($_SESSION['successMessage'])) {
	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success alert-dismissable">' . $_SESSION['successMessage'] . '<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';	
	unset($_SESSION['successMessage']);
}
include('resources/include/header.php');
$expenses = getExpenses($_GET['accountId']);
$details = getAccounts(/*$_GET['accountId']*/);
$members = getMembers($_GET['accountId']);
$currency = getCurrency();	
$accId = $_GET['accountId'];
$dir ="public/uploads/"; 
$wow = whoOwesWhat();
if (!array_key_exists($accId, $details)) {
	header("location: " . $config->app_url . "/account.php");
}
if(isset($_GET['accountId'])) $members = getMembers($_GET['accountId']);
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
							<br>
							<?php 
							$isMember = false;
							foreach ($members as $member) {
								if ($member['user_id'] == $_SESSION['user_id']) {
									$isMember = true;
									echo '<a href="edit-account.php?accountId=' . $_GET['accountId'] . '" class="edit_account">Edit Account</a>';
								}
							} 
							 ?>
							<h3><?php echo $details[$accId]['account_name'];?></h3>
							<span><?php 
								if ($details[$accId]['currency'] === 'USD') {
									if ($details[$accId]['SUM(e.amount)']) {
										echo "$" . $details[$accId]['SUM(e.amount)'];
									} else {
										echo "$0";
									}
								} else {
									if ($details[$accId]['SUM(e.amount)']) {
										echo $details[$accId]['SUM(e.amount)'] . " Ft";
									} else {
										echo "0 Ft";
									}
								}

							?></span>	
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
													//echo "Unknown - " . $member['email'];
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
										<?php 
										if(!empty($wow)){
											foreach ($wow as $i => $w):
											//	var_dump($w);
											?>
											<div class="d-flex">
												<div class="item"?>
												<?php 
													echo '<a href=""><p>' . $w['user_name'] .  '</p></a>'; 			
													echo '<span>Owes ' . $w['pb_name'] . '</span>'; 
												?>
											</div>
											<div class="item">
													<?php 
														if($currency[0] == 'HUF'){
															echo '<p>' . $w['sum(pf.debt)'] . ' Ft' . '</p>';
														}else{
															echo '<p>' . ' $' . $w['sum(pf.debt)'] . '</p>';
														}
													?>
												</div>
											<div class="item">
												<form action="" method="post">
													<input type="hidden" name="paidFor" value="<?php echo $w['paid_for']; ?>">
													<input type="hidden" name="paidBy" value="<?php echo $w['paid_by']; ?>">
													<input type="hidden" name="debt" value="<?php echo $w['sum(pf.debt)']; ?>">
													<input type="hidden" name="expense_id" value="<?php echo $w['expense_id']; ?>">
													<?php foreach ($members as $member): ?>
														<?php if ($_SESSION['user_id'] == $member['user_id']): ?>
															<button type="button" name="settle" data-toggle="modal" data-target="#exampleModal<?php echo $i; ?>" class="btn btn-primary">Settle</button>
														<?php endif; ?>
													<?php endforeach; ?>

														<div class="modal fade" id="exampleModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
																			echo '<p>Are you sure you\'d like to settle ' . $w["user_name"] . '\'s debt of $' . $w['sum(pf.debt)'] . '?</p>';
																		}
																	?>
																</div>
																<div class="modal-footer">
																	<button type="button" data-dismiss="modal" class="btn btn-primary">No</a>
																	<button type="submit" name="settleYesBtn" class="btn btn-primary">Yes</a>
																</div>
																</div>
															</div>
														</div>
													</form>
												</div>
											</div>

											<?php endforeach; }?>
											<?php $isMember = false;
											foreach ($members as $member) {
												if ($_SESSION['user_id'] == $member['user_id']) {
													$isMember = true;
												}
											}
											if(!$wow){
												if (!$expenses) {
													if ($isMember) {
														echo '<p>There are no expenses in this account yet. Please <a href="new-expense.php?accountId=' . $_GET['accountId'] . '">click here</a> to add one!</p><br>';
													}else{
														echo '<p>There are no expenses in this account yet. You dont have permission to add one.</p><br>';
													}
												} else {
													echo '<p>Woohoo! Every expense is settled in this account.</p>';
												}
											}
											 ?>
											
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
												if ($expenses{$i}["user_name"]) {
													echo '<span>' . $expenses{$i}["user_name"] . ' paid for it</span>';
												} else {
													echo '<span>' . 'Unknown' . ' paid for it</span>';
												}
												echo '<span class="d-block">' . $expenses{$i}['expense_date'] .  '</span>';
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
										<?php foreach ($members as $member): ?>
											<?php if ($_SESSION['user_id'] == $member['user_id']): ?>
												<a href="new-expense.php?accountId=<?php echo $_GET['accountId']; ?>"class="btn btn-primary">Add New</a>
											<?php endif ?>
										<?php endforeach ?>
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