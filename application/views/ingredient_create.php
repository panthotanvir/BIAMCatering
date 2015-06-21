<div class="row">
	<div class="span6 offset3 well">
		<h2>New Ingredient</h2>
		<form method="POST">
			<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
			<label for="ingredient_name">Ingredient Name:</label> 
			<input type="text" name="ingredient_name" id="ingredient_name">
			<br/>
			
			<label for="ingredient_price">Ingredient Price:</label> 
			<input type="text" name="ingredient_price" id="ingredient_price">
			<br/>
			
			<label for="ingredient_unit">Ingredient Unit:</label>
			<select id="ingredient_unit" name="ingredient_unit">
				<option>কেজি</option>
				<option>গ্রাম</option>
				<option>টুকরা</option>
				<option>পিস</option>
				<option>লিটার</option>
				<option>মিলিলিটার</option>	
				<option>প্যাকেট</option>
				<option>পাটা</option>
				<option>বস্তা</option>
				<option>কৌটা</option>
			</select>
			<br/>
			
			<label for="ingredient_category">Ingredient Category:</label>
			<select id="ingredient_category" name="ingredient_category">
				<option>কাঁচামাল</option>
				<option>Miscellaneous</option>
			</select>
			<br/>
			
			<input class="btn btn-primary" type="submit" name="submit">
		</form>
	</div>
</div>
