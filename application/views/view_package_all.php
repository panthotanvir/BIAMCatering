<div class="row">
	<div class="span12">
		<h2>View All Package</h2>
		
		<table class="table table-bordered table-striped" width="100%">
			<tr>
				<th>প্যাকেজের নাম</th>
				<th>দাম</th>
				<th>Action</th>
			</tr>
			<?php
			$done = true;
			foreach($packages as $p) {
				echo "<tr>";
				
				echo "<td>{$p['package_name']}</td>";
				echo "<td>{$p['package_price']}</td>";
				echo '<td>';
				$url = base_url() . "index.php/package/view/{$p['package_id']}";
				echo '<a href="'.$url.'" class="btn">View</a>';
				echo '</td>';
				
				echo "</tr>";
			}
			?>
		</table>
	</div>
</div>
