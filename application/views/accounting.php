<div class="row">
	<div class="span12">
		<form class="form-inline" method="post">
		<label>তারিখ:</label> 
		<input type="text" class="datepicker" name="dateStart" value="<?php echo $dateStart; ?>" />
		<span>থেকে</span>
		<input type="text" class="datepicker" name="dateEnd" value="<?php echo $dateEnd; ?>" />
		<input type="submit" name="submitdate" value="View" class="btn" />
		</form>
		
		<?php
			if( $error != NULL ){
				echo '<div class="alert alert-danger"><strong>ERROR! </strong>'.$error.'</div>';
				goto end;
			}
		?>
		
		<h2>Summary</h2>
		<table class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<td>Number of Orders</td>
				<td><p class="text-right"><?php echo $data["numberOfMenus"] ?></p></td>
			</tr>
			<tr>
				<td>Income</td>
				<td><p class="text-right">+<?php echo round($data["totalIncome"], 2); ?></p></td>
			</tr>
			<tr>
				<td>Ingredient Cost</td>
				<td><p class="text-right">-<?php echo round($data["totalCost"], 2); ?></p></td>
			</tr>
			<tr>
				<td>Misc cost</td>
				<td><p class="text-right">-<?php echo round($data["misc"], 2); ?></p></td>
			</tr>
			<tr>
				<td>Administrative Charge (10%)</td>
				<td><p class="text-right">-<?php echo round($data["admin_overhead"], 2); ?></p></td>
			</tr>
			<tr>
				<td>Utility Charge (5%)</td>
				<td><p class="text-right">-<?php echo round($data["utility_overhead"], 2); ?></p></td>
			</tr>
			<tr>
				<td>Profit</td>
				<td><p class="text-right"><?php echo round($data["profit"], 2); ?></p></td>
			</tr>
		</table>
		
		<h2>List of Orders</h2>
		<table class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<th>Date</th>
				<th>Institution/Course Name</th>
				<th>Time</th>
				<th>Number of Guests</th>
				<th>Price/Person</th>
				<th>Income</th>
				<th>Cost</th>
				<th>Profit</th>
				<th>Action</th>
			</tr>
			<?php foreach($data["menus"] as $m) { ?>
			<tr>
				<td><?php echo $m["event_date"]; ?></td>
				<td><?php echo $m["party_name"]; ?></td>
				<td><?php echo $m["event_time"]; ?></td>
				<td><?php echo $m["num_person"]; ?></td>
				<td><?php echo round($m["menu_price"], 0); ?></td>
				<td><?php echo round($m["income"], 0); ?></td>
				<td><?php echo round($m["cost"], 0); ?></td>
				<td><?php echo round($m["profit"], 0); ?></td>
				<td><a href="<?php echo base_url()."index.php/menu/view/{$m["menu_id"]}" ?>" class="btn">View</a></td>
			</tr>
			<?php } ?>
		</table>

		
		<?php end: ?>
	</div>
</div>
