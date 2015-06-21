<div class="row-fluid">
	<div class="span6 offset3 well">
		<h2 class="text-center">Log In</h2>
		<?php echo validation_errors('<div class="alert alert-error">', '</div>'); ?>
		<form method="post" class="form-horizontal">
			<div class="control-group">
				<label for="user_name" class="control-label">User Name</label>
				<div class="controls">
					<input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name">
				</div>
			</div>
			<div class="control-group">
				<label for="password" class="control-label">Password</label>
				<div class="controls">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
				<input type="submit" name="submit" value="Log In" class="btn btn-primary" />
				</div>
			</div>
		</form>
	</div>
</div>
