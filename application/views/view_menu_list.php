<div class="row">
	<div class="span12">
	<form class="form-inline" method="post">
	<label for="event_date">তারিখ:</label> 
	<input type="text" id="datepicker" name="event_date" value="<?php echo $date; ?>" />
	<input type="submit" name="submit" value="View" class="btn btn-primary" />
	</form>
	
	<table class="table table-bordered table-striped" width="100%">
		<tr>
			<th>প্রতিষ্ঠান/কোর্সের নাম</th>
			<th>সময়</th>
			<th>অতিথি সংখ্যা</th>
			<th>দাম (জনপ্রতি)</th>
			<th>মেন্যু</th>
			<th>অনুমান</th>
			<th>Action</th>
		</tr>
		<?php
		$done = true;
		foreach($menus as $m) {
			echo "<tr>";
			
			echo "<td>{$m['party_name']}</td>";
			echo "<td>{$m['event_time']}</td>";
			echo "<td>{$m['num_person']}</td>";
			echo "<td>{$m['menu_price']}</td>";
			
			echo '<td>';
			$menu_item_data = $this->models->get_menu_item($m['menu_id']);
			for($i=0; $i<count($menu_item_data); $i++){
				if( $i > 0 ) echo ", ";
				echo "{$menu_item_data[$i]['item_name']}";
				if($menu_item_data[$i]['quantity'] > 1) echo " ({$menu_item_data[$i]['quantity']} টি)";
				if($menu_item_data[$i]['people'] != $m['num_person'] ) echo " ({$menu_item_data[$i]['people']} জন)";
			}
			echo '</td>';
			
			echo '<td>';
			if( $m['estimated'] ){
				echo "আছে";
			}
			else{
				echo "নেই";
			}
			echo '</td>';
			
			
			echo '<td>';
			if( !$m['estimated'] ){
				$url = base_url() . "index.php/menu/estimate/{$m['menu_id']}";
				echo '<a href="'.$url.'" class="btn">Estimate</a>';
			}

			$url = base_url() . "index.php/menu/view/{$m['menu_id']}";
			echo '<a href="'.$url.'" class="btn">View</a>';
			
			$url = base_url() . "index.php/menu/edit/{$m['menu_id']}";
			echo '<a href="'.$url.'" class="btn">Edit</a>';
			
			$url = base_url() . "index.php/menu/delete/{$m['menu_id']}";
			echo '<a href="'.$url.'" class="btn">Delete</a>';
			
			echo '</td>';
			
			echo "</tr>";
		}
		?>
	</table>
	</div>
</div>
