<div class="row">
	<div class="span12">
		<h2 class="text-center">List Items</h2>
		<table class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<th>Serial Number</th>
				<th>Item Name</th>
				<th>Action</th>
			</tr>
			<?php
			//foreach($items as $i) {
			for($i = 0; $i < count($items); $i++){
				echo "<tr>";
				echo "<td>".($i+1)."</td>";
				echo "<td>{$items[$i]['item_name']}</td>";
				$urlview = base_url() . "index.php/item/individual/{$items[$i]['item_id']}";
				$urldelete = base_url() . "index.php/item/delete/{$items[$i]['item_id']}";
				$urledit = base_url() . "index.php/item/edit/{$items[$i]['item_id']}";
				echo '<td>';
				echo '<a href="'.$urlview.'" class="btn btn-small">View</a>';
				echo '<a href="'.$urledit.'" class="btn btn-small">Edit</a>';
				echo '<a href="'.$urldelete.'" class="btn btn-small">Delete</a>';
				echo '</td>';
				echo "</tr>";
			}
			?>
		</table>
	</div>
</div>
