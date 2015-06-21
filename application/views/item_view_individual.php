<div class="row">
	<div class="span12">
		<h2><?php echo $item_data["item_name"]; ?></h2>
		<?php
		for( $i = 0; $i < count($ingredients); ) {
			$people = $ingredients[$i]['people'];
		?>
			<h3>Ingredient List for <?php echo $people; ?> people</h3>
			<table class="table table-bordered table-striped" width="100%">
				<tr>
					<th>Ingredient Name</th>
					<th>Ingredient Amount</th>
				</tr>
				<?php
				for( $j = $i; $j < count($ingredients); $j++ ) {
					if( $ingredients[$j]['people'] != $people ){
						break;
					}
					echo "<tr>";
					echo "<td>{$ingredients[$j]['ingredient_name']}</td>";
					echo "<td>{$ingredients[$j]['quantity']} {$ingredients[$j]['ingredient_unit']}</td>";
					echo "</tr>";
				}
				$i = $j;
				?>
			</table>
		<?php } ?>
	</div>
</div>
