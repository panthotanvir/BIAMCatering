<div class="row">
	<div class="span12">
	<form class="form-inline" method="post">
	<label for="event_date">তারিখ:</label> 
	<input type="text" id="datepicker" name="event_date" value="<?php echo $date; ?>" />
	<input type="submit" name="submit" value="View" class="btn btn-primary" />
	</form>
	
	<?php
		if( $this->models->is_there_any_menu($date) == FALSE ){
			echo '<div class="alert">';
			echo "There is no bazar list. Because there is no menu on {$date}";
			echo '</div>';
			goto end;
		}
		else if( $this->models->is_all_menu_estimated($date) == FALSE ){
			echo '<div class="alert">';
			echo "You haven't estimated the required amounts of ingredients for all menus on {$date}. Please estimate the menus first.";
			echo '</div>';
			goto end;
		}
		else if( $this->models->is_price_set($date) == FALSE ){
			echo '<div class="alert">';
			echo "You haven't set the price of ingredients for menus on {$date}. Please set the prices first.";
			echo '</div>';
			goto end;
		}
	?>
	
	<table class="table table-bordered table-striped" width="100%">
		<tr>
			<th>No</th>
			<th>Ingredient Name</th>
			<th>Amount</th>
			<th>Price</th>
			<th>Sub Total</th>
		</tr>
		
		<?php $total = 0; $idx = 0 ?>
		
		<?php for($i=0; $i<count($market); $i++) { ?>
		<tr>
			<td><?php echo ++$idx; ?></td>
			<td><?php echo $market[$i]['ingredient_name']; ?></td>
			<td><?php echo number_format($market[$i]['quantity'], 3)  . " " . $market[$i]['ingredient_unit']; ?></td>
			<td><?php echo round($market[$i]['probable_price'], 0); ?></td>
			<td><?php echo round($market[$i]['probable_price'] * $market[$i]['quantity'], 0) ; ?></td>
		</tr>
		<?php $total += $market[$i]['probable_price'] * $market[$i]['quantity']; ?>
		<?php } ?>
		
		<tr>
			<td colspan="5">Miscellaneous</td>
		</tr>
		
		<?php for($i=0; $i<count($extra); $i++) { ?>
		<tr>
			<td><?php echo ++$idx; ?></td>
			<td><?php echo $extra[$i]['ingredient_name']; ?></td>
			<td><?php echo number_format($extra[$i]['quantity'], 3)  . " " . $extra[$i]['ingredient_unit']; ?></td>
			<td><?php echo round($extra[$i]['probable_price'], 0); ?></td>
			<td><?php echo round($extra[$i]['probable_price'] * $extra[$i]['quantity'], 0) ; ?></td>
		</tr>
		<?php $total += $extra[$i]['probable_price'] * $extra[$i]['quantity']; ?>
		<?php } ?>
		
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td><strong>Total</strong></td>
			<td><strong><?php echo round($total, 0); ?></strong></td>
		</tr>
	</table>
	
	<?php end: ?>
</div>
</div>
