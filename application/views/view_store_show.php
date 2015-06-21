<div class="row">
	<div class="span12">
		<h2>Remaining Ingredients</h2>
		<table class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<th>Ingredient Name</th>
				<th>Ingredient Stock</th>
				<th>Ingredient Unit</th>
			</tr>
			<?php
			foreach($stocks as $i) {
				echo "<tr>";
				echo "<td>{$i['ingredient_name']}</td>";
				echo "<td>{$i['ingredient_stock']}</td>";
				echo "<td>{$i['ingredient_unit']}</td>";
				echo "</tr>";
			}
			?>
		</table>
	</div>
</div>

