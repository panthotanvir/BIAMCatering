<div class="row">
	<div class="span12">
		<h2 class="text-center">
			List of User(s)
			<br/>
			<?php
				$urlcreate = base_url() . "index.php/user/create";
				echo '<a href="'.$urlcreate.'" class="btn btn-primary">Add New User</a>';
			?>
		</h2>
		<table class="table table-bordered table-striped" width="100%">
			<tr>
				<th>Serial Number</th>
				<th>User ID</th>
				<th>User Name</th>
				<th>Password</th>
				<th>User Type</th>
				<th>Action</th>
			</tr>
			
			<?php
				for($i = 0; $i<count($users); $i++){
					echo "<tr>";
					echo "<td>" . ($i+1) . "</td>";
					echo "<td>{$users[$i]['user_id']}</td>";
					echo "<td>{$users[$i]['user_name']}</td>";
					if( $this->models->is_admin() ) echo "<td>{$users[$i]['password']}</td>";
					else echo "<td>********</td>";
					
					echo "<td>{$users[$i]['type']}</td>";
					
					$urledit = base_url() . "index.php/user/edit/{$users[$i]['user_id']}";
					$urldelete = base_url() . "index.php/user/delete/{$users[$i]['user_id']}";
					
					echo "<td>";
					if( $this->models->is_admin() ){
						echo '<a href="'.$urledit.'" class="btn btn-small">Edit</a>';
						echo '<a href="'.$urldelete.'" class="btn btn-small">Delete</a>';
					}
					echo "</td>";
					
					echo "</tr>";
				}
			?>

		</table>
	</div>
</div>
