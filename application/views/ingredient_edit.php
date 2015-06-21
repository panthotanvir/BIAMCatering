<div class="row">
	<div class="span6 offset3 well">
		<h2>Edit Ingredient</h2>
		<form method="POST">
			<input type="hidden" name="ingredient_id" id="ingredient_id" value="<?php echo $ingredient_id; ?>">
			
			<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
			<label for="ingredient_name">Ingredient Name:</label> 
			<input type="text" name="ingredient_name" id="ingredient_name" value="<?php echo $ingredient_data['ingredient_name']; ?>">
			<br/>
			
			<label for="ingredient_price">Ingredient Price:</label> 
			<input type="text" name="ingredient_price" id="ingredient_price" value="<?php echo $ingredient_data['ingredient_price']; ?>">
			<br/>
			
			<label for="ingredient_unit">Ingredient Unit:</label>
			<input type="text" name="ingredient_unit" id="ingredient_unit" value="<?php echo $ingredient_data['ingredient_unit']; ?>">
			<br/>
			
			<label for="ingredient_category">Ingredient Category:</label>
			<input type="text" name="ingredient_category" id="ingredient_category" value="<?php echo $ingredient_data['ingredient_category']; ?>">
			<br/>
			
			<input class="btn btn-primary" type="submit" name="submit">
		</form>
	</div>
</div>
