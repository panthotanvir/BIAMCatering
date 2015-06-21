<?php
	$idx = 0;
	$success = 0;
	$failure = 0;
	
	//menu check
	if( $this->models->is_there_any_menu($date) )
	{
		$success++;
		$okay[$idx] = true;
		$message[$idx] = "There are menu(s).";
	}
	else{
		$failure++;
		$okay[$idx] = false;
		$message[$idx] = "There is no menu.";
	}
	$url[$idx] = base_url() . "index.php/menu/create";
	$urltext[$idx] = "Add New Menu";
	$idx++;
	
	//estimated?
	if( $okay[$idx-1] AND $this->models->is_all_menu_estimated($date) )
	{
		$success++;
		$okay[$idx] = true;
		$message[$idx] = "All menu(s) are estimated.";
	}
	else{
		$failure++;
		$okay[$idx] = false;
		$message[$idx] = "Estimation not done yet.";
	}
	$url[$idx] = base_url() . "index.php/menu/view_by_date/{$date}";
	$urltext[$idx] = "Estimate Menu(s)";
	$idx++;
	
	//misc added?
	if( $okay[$idx-1] AND $this->models->is_extra_set($date) )
	{
		$success++;
		$okay[$idx] = true;
		$message[$idx] = "Misc items added.";
	}
	else{
		$failure++;
		$okay[$idx] = false;
		$message[$idx] = "Misc not added yet.";
	}
	$url[$idx] = base_url() . "index.php/market/extra/{$date}";
	$urltext[$idx] = "Add Misc Item(s)";
	$idx++;
	
	//price set?
	if( $okay[$idx-1] AND $this->models->is_price_set($date) )
	{
		$success++;
		$okay[$idx] = true;
		$message[$idx] = "Price set.";
	}
	else{
		$failure++;
		$okay[$idx] = false;
		$message[$idx] = "Price not set yet.";
	}
	$url[$idx] = base_url() . "index.php/market/set_price/{$date}";
	$urltext[$idx] = "Set Price";
	$idx++;
?>

<div class="row">
	<div class="span6 offset3">
		<form class="form-inline" method="post">
			<label for="event_date">তারিখ:</label> 
			<input type="text" id="datepicker" name="event_date" value="<?php echo $date; ?>" />
			<input type="submit" name="submitdate" value="View" class="btn btn-primary" />
		</form>
		
		<h2 class="text-center">Status</h2>
		
		<p class="text-center alert alert-info">Completed: <?php echo $success; ?>/<?php echo $success+$failure; ?></p>
		
		<div class="progress">
			<div class="bar" style="width: <?php echo 100 * $success / ($success + $failure) ?>%;"></div>
		</div>
		
		<?php for($i = 0; $i < count($okay); $i++) { ?>
			<div class="alert <?php echo ($okay[$i]?"alert-success":"alert-danger");?>">
				<strong>Step <?php echo $i+1; ?>:</strong>
				<?php echo $message[$i]; ?>
				<?php if($i == 0 OR $okay[$i-1] ) { ?>
					<a href="<?php echo $url[$i]?>" class="btn"><?php echo $urltext[$i]; ?></a>
				<?php } ?>
			</div>
		<?php } ?>
		
		<?php if($failure == 0) {
			$bazarurl = base_url() . "index.php/market/bazar/{$date}";
			$accountingurl = base_url() . "index.php/market/accounting/{$date}/{$date}";
		?>
			<p class="text-center"><a href="<?php echo $bazarurl; ?>" class="btn btn-large">See Bazar List</a></p>
			<p class="text-center"><a href="<?php echo $accountingurl; ?>" class="btn btn-large">See Accounting</a></p>
		<?php } ?>
		
	</div>
</div>
