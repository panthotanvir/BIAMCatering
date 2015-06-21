<div class="row">
	<div class="span12">
		<h2>Ingredient List</h2>
		<table class="table table-bordered table-striped" width="100%">
			<tr>
				<th>Serial Number</th>
				<th>Ingredient Name</th>
				<th>Ingredient Unit</th>
				<th>Ingredient Price</th>
				<th>Ingredient Type</th>
				<th>Action</th>
			</tr>
			<?php
			for($i=0; $i<count($ingredients); $i++){
				echo "<tr>";
				echo "<td>".($i+1)."</td>";
				echo "<td>{$ingredients[$i]['ingredient_name']}</td>";
				echo "<td>{$ingredients[$i]['ingredient_unit']}</td>";
				echo "<td>{$ingredients[$i]['ingredient_price']} টাকা / {$ingredients[$i]['ingredient_unit']}</td>";
				echo "<td>{$ingredients[$i]['ingredient_category']}</td>";
				$urldelete = base_url() . "index.php/ingredient/delete/{$ingredients[$i]['ingredient_id']}";
				$urledit = base_url() . "index.php/ingredient/edit/{$ingredients[$i]['ingredient_id']}";
				echo '<td>';
				echo '<a href="'.$urledit.'" class="btn btn-small">Edit</a>';
				echo '<a href="'.$urldelete.'" class="btn btn-small">Delete</a>';
				echo '</td>';
				echo "</tr>";
			}
			?>
		</table>
	</div>
</div>
