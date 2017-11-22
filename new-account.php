
<?php include('resources/functions/functions.php'); isLoggedIn(); ?>
<?php include('resources/include/head.php'); ?>

<?php include('resources/include/header.php'); ?>
<?php $peoples = getPeoples(); ?>
	<section class="create form">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<form action="resources/functions/newAccount.php" method="post">
						<div class="form-group">
							<label for="">Account Name</label>
							<input type="text" class="form-control" name="name">
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
								<?php foreach ($peoples as $people): 
								if ($people['user_name']) { ?>
								<div>
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description"><?php echo $people['user_name'] ?></span>
									</label>
								</div>
								<?php } endforeach ?>


								<!-- <div>
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description">Péter Varga</span>
									</label>
								</div>
								<div>
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description">Dániel Petres</span>
									</label>
								</div>
								<div>
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description">André Timár</span>
									</label>
								</div> -->
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