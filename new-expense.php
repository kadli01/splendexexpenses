<?php include('resources/include/head.php'); ?>
<?php include('resources/functions/functions.php'); isLoggedIn(); ?>


	<?php include('resources/include/header.php'); ?>
	
	<section class="create">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<h4>Expense Description</h4>
					<form action="">
						<div class="top">
							<div class="form-group">
								<label for="">Expense Name</label>
								<input type="text" name="expenseName" class="form-control">
							</div>
							<div class="form-group">
								<label for="">Currency</label>
								<select name="" id="" class="form-control">
									<option value="">HUF (Ft)</option>
								</select>
							</div>
							<div class="form-group">
								<label for="">Amount</label>
								<input type="text" class="form-control">
							</div>
							<div class="form-group">
								<label for="">Date</label>
								<input type="text" class="form-control" id="datepicker-example">
							</div>
							<div class="form-group">
								<label for="">Paid by</label>
								<select name="" id="" class="form-control">
									<option value="">Péter Varga</option>
									<option value="">Petres Dániel</option>
									<option value="">André Timár</option>
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
							<a href="show.html" class="btn btn-primary">Create</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	
	<script>
	  $('#datepicker-example').datepicker({
	      calendarWeeks: true,
	      autoclose: true,
	      todayHighlight: true
	  });
	</script>
	<?php include('resources/include/scripts.php'); ?>