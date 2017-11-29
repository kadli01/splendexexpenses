<?php 
include('resources/functions/functions.php');
include('resources/include/head.php');
if(isset($_SESSION['accUpdatePeopleError'])) {
	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">' . $_SESSION['accUpdatePeopleError'] . '<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';	
	unset($_SESSION['accUpdatePeopleError']);
}elseif(isset($_SESSION['accUpdateNameError'])){
	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">' . $_SESSION['accUpdateNameError'] . '<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';	
	unset($_SESSION['accUpdateNameError']);
}
include('resources/include/header.php');
$peoples = getPeoples();
$currency = getCurrency();
$account = getAccountforUpdate();
$orignalMembers = getAccountMembersForUpdate();
if(isset($_GET['accountId'])) $members = getMembers($_GET['accountId']);

$isMember = false;
foreach ($members as $member) {
	if ($member['user_id'] == $_SESSION['user_id']) {
		$isMember = true;
	}
}
if (!$isMember) {
	header("location: " . $config->app_url . "/account.php");
}

?>

<section class="create form">
		<div class="container">

			<div class="row">
				<div class="col-4">
					<form action="" method="post" enctype = "multipart/form-data">
						<div class="form-group">
							<label for="">Account Name</label>
							<?php if(isset($account)){
									echo '<input type="text" class="form-control" name="name" maxlength="30" value="' . $account['account_name'] . '">';
								} ?>
						</div>
						<div class="form-group">
							<label for="">Currency</label>
							<select name="currency" id="currency" class="form-control">
								<?php

								if($currency['currency'] == 'HUF'){
									echo '<option value="HUF" selected>HUF (Ft)</option>';
									echo '<option value="USD">USD ($)</option>';
								}else{
									echo '<option value="HUF">HUF (Ft)</option>';
									echo '<option value="USD" selected>USD ($)</option>';
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="">People</label>
							<div class="create__checkbox">
								<?php $i=0; ?>
								<?php foreach ($peoples as $people): ?>
								<div>
									<label class="custom-control custom-checkbox">				
										<?php 
										if (in_array($people, $orignalMembers)) {		
											echo '<input type="checkbox" class="custom-control-input" name="people[]" value="' . $people['user_id'] . '" checked>';
											echo '<span class="custom-control-indicator"></span>';
											if ($people['user_name']){
														echo '<span class="custom-control-description">' . $people["user_name"];
											}else{ 
												echo "Unknown - " . $people['email']; }
												echo '</span>';
										}else {
											echo '<input type="checkbox" class="custom-control-input" name="people[]" value="' . $people['user_id'] . '">';
											echo '<span class="custom-control-indicator"></span>';
											if ($people['user_name']){
												echo '<span class="custom-control-description">' . $people["user_name"];
											}else{ echo "Unknown - " . $people['email']; }
											echo '</span>';
												} ?>
									</label>
								</div>
								<?php $i++; ?>
								<?php endforeach; ?>

							</div>
						</div>
						<div class="form-group">
							<label for="">Upload Cover Image</label>
							<input type="file" name="image" accept="image/*">
						</div>

						<input type="submit" name="updateAccBtn" value="Update" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
	</section>

<?php include('resources/include/scripts.php'); ?>