<div class="row-fluid">
	<div class="span6 offset3 well">
		<h2 class="text-center">Edit User</h2>
		<?php echo validation_errors('<div class="alert alert-error">', '</div>'); ?>
		<form method="post" class="form-horizontal">
			<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
			<div class="control-group">
				<label for="user_name" class="control-label">User Name</label>
				<div class="controls">
					<input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user_name; ?>">
				</div>
			</div>
			<div class="control-group">
				<label for="password" class="control-label">Password</label>
				<div class="controls">
					<input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
				</div>
			</div>
			<div class="control-group">
				<label for="type" class="control-label">User Type</label>
				<div class="controls">
					<select id="type" name="type">
						<option <?php if ($type=='admin') echo "selected"; ?> >
							admin</option>
						<option <?php if ($type=='data_entry_operator') echo "selected"; ?> >
							data_entry_operator</option>
						<option <?php if ($type=='user') echo "selected"; ?> >
							user</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
				<input type="submit" name="submit" value="Create" class="btn btn-primary" />
				</div>
			</div>
		</form>
	</div>
</div>
