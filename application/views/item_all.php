<div class="row">
	<div class="span12">
		<h2><?php echo $item_data["item_name"]; ?></h2>
		<?php $people = $ingredients[0]['people']; ?>
		<table class="table table-bordered table-striped" width="100%" border="1px solid">
			<tr>
				<th>Ingredient Name</th>
				
				<th>For <?php echo $people; ?> (Input)</th>
			</tr>
			<?php
			for( $j = 0; $j < count($ingredients); $j++ ) {
				echo "<tr>";
				echo "<td>{$ingredients[$j]['ingredient_name']}</td>";
				echo "<td>{$ingredients[$j]['quantity']} {$ingredients[$j]['ingredient_unit']}</td>";
				
				echo "</tr>";
			}
			?>
		</table>
	</div>
</div>
