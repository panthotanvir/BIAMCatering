<div class="row">
	<div class="span12">
	<form class="form-inline" method="post">
	<label for="event_date">তারিখ:</label> 
	<input type="text" id="datepicker" name="event_date" value="<?php echo $date; ?>" />
	<input type="submit" name="submitdate" value="View" class="btn btn-primary" />
	</form>
	
	<?php
		if( $this->models->is_there_any_menu($date) == FALSE ){
			echo "<p class=\"alert\">You don't need to set price. Because there is no menu on {$date}.</p>";
			goto end;
		}
		else if( $this->models->is_all_menu_estimated($date) == FALSE ){
			echo "<p class=\"alert\">You haven't estimated the required amounts of ingredients for all menus on {$date}. Please estimate the menus first.</p>";
			goto end;
		}
		else if( $this->models->is_extra_set($date) == FALSE ){
			echo "<p class=\"alert\">You haven't enetered misc items.</p>";
			goto end;
		}
		else if( $this->models->is_price_set($date) == TRUE ){
			$reseturl = base_url() . "index.php/market/reset_price/{$date}";
			echo "<p class=\"alert\">
				Market Price already set for {$date}. No need to enter again.
				<a href=\"{$reseturl}\" class=\"btn\">Reset market price.</a>
				</p>";
			goto end;
		}
	?>	
	
	<form method="post">
		<?php echo validation_errors(); ?>
		<table class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<th>Ingredient Name</th>
				<th>Probable Price</th>
			</tr>
			<?php
				foreach($data as $d){
					echo "<tr>";
						echo "<td>{$d['ingredient_name']}</td>";
						echo '<td>
							<input type="hidden" name="ingredient[]" value="' . $d['ingredient_id'] . '"/>
							<input type="text" name="price[]" value="'.$d['ingredient_price'].'"/> / '.$d['ingredient_unit'].'
							</td>';
					echo "</tr>";
				}
			?>
		</table>
		<p> <input type="submit" name="submit" class="btn btn-primary"/> </p>
	</form>
	
	<?php end: ?>
	
	</div>
</div>
