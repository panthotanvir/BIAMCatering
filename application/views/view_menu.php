<div class="row">
	<div class="span12">
	<h2>View Menu</h2>
	<h3>Menu</h3>
	<table class="table table-bordered">
		<tr>
			<td>প্রতিষ্ঠান/কোর্সের নাম:</td>
			<td><?php echo $menu_data['party_name'] ?></td>
		</tr>
		<tr>
			<td>তারিখ:</td>
			<td><?php echo $menu_data['event_date'] ?></td>
		</tr>
		<tr>
			<td>সময়:</td>
			<td><?php echo $menu_data['event_time'] ?></td>
		</tr>
		<tr>
			<td>অতিথি সংখ্যা:</td>
			<td><?php echo $menu_data['num_person'] ?></td>
		</tr>
		<tr>
			<td>দাম (জনপ্রতি):</td>
			<td><?php echo $menu_data['menu_price'] ?></td>
		</tr>
		<tr>
			<td>মেন্যু:</td>
			<td>
				<?php 
					for($i=0; $i<count($menu_item_data); $i++){
						if( $i > 0 ) echo ", ";
						echo "{$menu_item_data[$i]['item_name']}";
						if($menu_item_data[$i]['quantity'] > 1) echo " ({$menu_item_data[$i]['quantity']} টি)";
						if($menu_item_data[$i]['people'] != $menu_data['num_person'] ) echo " ({$menu_item_data[$i]['people']} জন)";
					}
				?>
			</td>
		</tr>
	</table>
	
	<?php if( $this->models->is_all_menu_estimated($menu_data['event_date']) == TRUE AND $this->models->is_price_set($menu_data['event_date']) == TRUE ) { ?>
	
	<h3>Profit</h3>
	<table class="table table-bordered">
		<tr>
			<td>আয়</td>
			<td><?php echo number_format($menu_data['menu_price'] * $menu_data['num_person'], 2); ?></td>
		</tr>
		<tr>
			<td>ব্যয়</td>
			<td><?php echo number_format($menu_cost, 2); ?></td>
		</tr>
		<tr>
			<td>লাভ</td>
			<td><?php echo number_format(($menu_data['menu_price'] * $menu_data['num_person']) - $menu_cost, 2); ?></td>
		</tr>
	</table>
	
	<?php } ?>
	
	<?php if($menu_data['estimated']) { ?>
	
	<h3>Ingredients Estimation</h3>
	<table class="table table-bordered table-striped" width="100%">
		<tr>
			<th>Ingredient</th>
			<th>Required Amount</th>
		</tr>
		<?php foreach($menu_estimation_data as $ing){ ?>
		<tr>
			<td><?php echo $ing['ingredient_name'] ?></td>
			<td><?php echo number_format($ing['amount'], 3 ) . " " . $ing['ingredient_unit'] ?></td>
		</tr>
		<?php } ?>
	</table>
	
	<?php } ?>
</div>
</div>

