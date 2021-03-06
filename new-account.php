<?php 
include('resources/functions/functions.php');
include('resources/include/head.php');
isLoggedIn();
$peoples = getPeoples();
if (!empty($_SESSION['createError'])) {
	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">' . $_SESSION['createError'] . '<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';	
	unset($_SESSION['createError']);
} 
include('resources/include/header.php'); 
?>
	<section class="create form">
		<div class="container">

			<div class="row">
				<div class="col-4">
					<form action="resources/functions/create-account.php" method="post" enctype = "multipart/form-data">
						<div class="form-group">
							<label for="">Account Name</label>
							<input type="text" class="form-control" name="name" maxlength="30">
						</div>
						<div class="form-group">
							<label for="">Currency</label>
							<select name="currency" id="currency" class="form-control">
								<option value="HUF">HUF (Ft)</option>
								<option value="USD">USD ($)</option>
							</select>
						</div>
						<div class="form-group">
							<label for="">People</label>
							<div class="create__checkbox">
								<?php foreach ($peoples as $people): ?>
								<div>
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" name="people[]" value="<?php echo $people['user_id']; ?>">
										<span class="custom-control-indicator"></span>
										<?php if ($people['user_name']):  ?>
										<span class="custom-control-description"><?php echo $people['user_name']; ?>

											<?php else: echo "Unknown - " . $people['email']; ?>
											<?php endif; ?>
										</span>
									</label>
								</div>
								
								<?php endforeach; ?>
							</div>
						</div>
						<div class="form-group">
							<label for="">Upload Cover Image</label>
							<input type="file" name="image" accept="image/*">
						</div>
						<input type="submit" name="create" value="Create" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
	</section>

	
<?php include('resources/include/scripts.php'); ?>