<div class="row">
	<div class="span12">
	<h2>View Package</h2>
	<table class="table table-bordered">
		<tr>
			<td>প্যাকেজের নাম:</td>
			<td><?php echo $package_data['package_name'] ?></td>
		</tr>
		<tr>
			<td>দাম:</td>
			<td><?php echo $package_data['package_price'] ?></td>
		</tr>
		<tr>
			<td>মেন্যু:</td>
			<td>
				<?php 
					for($i=0; $i<count($package_item_data); $i++){
						if( $i > 0 ) echo ", ";
						echo "{$package_item_data[$i]['item_name']}";
					}
				?>
			</td>
		</tr>
	</table>
</div>
</div>

