<script>
var ingredients;

function make_row(x){
	if( typeof x == undefined ) x = null;
	var start = '\
		<tr>\
		<td ><input type="checkbox" name="chk[]"/></td>\
		<td><select id="ingredient" name="ingredient[]">';
	var end = '\
		</select>\
		<td><input type="text" name="amount[]" /></td>\
		</td>\
		</tr>';
	var options = "";
	//options += "<option>" + "</option>";
	for(var i=0; i<ingredients.length; i++){
		if( ingredients[i].ingredient_id == x ) options += "<option value='" + ingredients[i].ingredient_id + "' selected>"  + ingredients[i].ingredient_name + "</option>";
		else options += "<option value='" + ingredients[i].ingredient_id + "' >"  + ingredients[i].ingredient_name + "</option>";
	}
	return start + options + end;
}

window.onload = function(){
	//load ingredient information
	console.log("loading ingredient information");
	var ingredienturl = "<?php echo base_url(); ?>index.php/api/get/ingredient_category/Miscellaneous";
	ingredients = ajaxRequest(ingredienturl);
};

function ajaxRequest(url){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", url, false);
	xmlhttp.send();
	var str = xmlhttp.responseText;
	var obj = JSON.parse(str);
	return obj;
}

function addRow(tableID, x) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	row.innerHTML = make_row(x);
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	}
}
</script>

<div class="row">
	<div class="span12">
	<form class="form-inline" method="post">
	<label for="event_date">তারিখ:</label> 
	<input type="text" id="datepicker" name="event_date" value="<?php echo $date; ?>" />
	<input type="submit" name="submitdate" value="View" class="btn btn-primary" />
	</form>
	
	<?php
		echo validation_errors('<div class="alert alert-danger">', '</div>');
		if( $this->models->is_there_any_menu($date) == FALSE ){
			echo "<p class=\"alert\">You don't need to enter. Because there is no menu on {$date}.</p>";
			goto end;
		}
		else if( $this->models->is_all_menu_estimated($date) == FALSE ){
			echo "<p class=\"alert\">You haven't estimated the required amounts of ingredients for all menus on {$date}. Please estimate the menus first.</p>";
			goto end;
		}
		else if( $this->models->is_extra_set($date) == TRUE ){
			$reseturl = base_url() . "index.php/market/reset_extra/{$date}";
			echo "<p class=\"alert\">
				Misc item already set for {$date}. No need to enter again.
				<a href=\"{$reseturl}\" class=\"btn\">Reset Miscellaneous Ingredient(s)</a>
				</p>";
			goto end;
		}
	?>
	
	
	
		<table class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<th>Time</th>
				<th>Number of People</th>
				<th>Required Tableboy</th>
			</tr>
			<?php
				foreach($people as $p) {
					echo "<tr>";
					echo "<td>{$p['event_time']}</td>";
					echo "<td>{$p['num_person']}</td>";
					$req = round($p['num_person'] / 25, 0);
					echo "<td>{$req}</td>";
					echo "</tr>";
				}
			?>
		</table>
	
	<form method="post">
		<p> 
			<input type="button" value="Add Ingredient" onClick="addRow('dataTable')" class="btn" /> 
			<input type="button" value="Remove Ingredient" onClick="deleteRow('dataTable')" class="btn" /> 
		</p>
		<table id="dataTable" class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<th></th>
				<th>Ingredients Name</th>
				<th>Ingredients Amount</th>
			</tr>
		</table>
		<input class="btn btn-primary" type="submit" name="submit">
		
	</form>
	
	<?php end: ?>
	
	</div>
</div>
