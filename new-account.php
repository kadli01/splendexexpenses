
<?php include('resources/functions/functions.php'); isLoggedIn(); ?>
<?php include('resources/include/head.php'); ?>

	<?php include('resources/include/header.php'); ?>

	<section class="create form">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<form action="">
						<div class="form-group">
							<label for="account_name">Account Name</label>
							<input type="text" name="account_name" class="form-control">
						</div>
						<div class="form-group">
							<label for="currency">Currency</label>
							<select name="currency" id="" class="form-control">
								<option value="">HUF (Ft)</option>
								<option value="">USD ($)</option>
							</select>
						</div>
						<div class="form-group">
							<label for="">People</label>
							<div class="create__checkbox">
								<div>
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
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="">Upload Cover Image</label>
							<input type="file" name="pic" accept="image/*">
						</div>
						<a href="account.html" class="btn btn-primary">Create</a>
					</form>
				</div>
			</div>
		</div>
	</section>

	
<?php include('resources/include/scripts.php'); ?>