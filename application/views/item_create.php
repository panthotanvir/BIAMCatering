<script>
var ingredients;

function make_row(x, y, z){
	if( typeof x == undefined ) x = null;
	if( typeof y == undefined ) y = null;
	if( typeof z == undefined ) z = null;
	
	if(y == null) y = 0;
	
	var start = '\
		<tr>\
		<td ><input type="checkbox" name="chk[]"/></td>\
		<td><select id="ingredient" name="ingredient[]">';
	var end = '\
		</select>\
		<td><input type="text" name="quantity[]" value="'+ y +'"/></td>\
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
	var ingredienturl = "<?php echo base_url(); ?>index.php/api/get/ingredient";
	ingredients = ajaxRequest(ingredienturl);
	
	//load item information
	var itemurl = "<?php echo base_url(); ?>index.php/api/get/item";
	var items = ajaxRequest(itemurl);
	var itembox = document.getElementById("copy_item");
	for(var i=0; i<items.length; i++){
		itembox.innerHTML += "<option value='" + items[i].item_id + "' >"  + items[i].item_name + "</option>";
	}
	
	//on copy item change
	document.getElementById("copy_item").onchange = function(){
		//empty table
		var table = document.getElementById('dataTable');
		while( table.rows.length > 0 ) table.deleteRow(0);
		
		var copyitembox = document.getElementById("copy_item");
		if(copyitembox.selectedIndex == 0) return;
		
		var str = copyitembox.options[copyitembox.selectedIndex].value;
		//load ingredients for item
		var ingredienturl = "<?php echo base_url() . "index.php/api/get/item_ingredient/";?>" + str;
		item_ingredients = ajaxRequest(ingredienturl);
		
		for(var i=0; i<item_ingredients.length; i++){
			addRow('dataTable', item_ingredients[i].ingredient_id, item_ingredients[i].quantity);
		}
	}
};

function ajaxRequest(url){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", url, false);
	xmlhttp.send();
	var str = xmlhttp.responseText;
	var obj = JSON.parse(str);
	return obj;
}

function addRow(tableID, x, y, z) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	row.innerHTML = make_row(x, y, z);
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
	<div class="span6 offset3 well">
		<h2>New Item</h2>
		<form method="POST">
			<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
			<label for="item_name">Item Name:</label> 
			<input type="text" name="item_name" id="item_name">
			<br/>
			<label for="people">Number of People:</label> 
			<input type="text" name="people" id="people">
			<br/>
			<label for="copy_item">Copy From:</label> 
			<select name="copy_item" id="copy_item">
				<option></option>
			</select>
			<br/>
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
	</div>
</div>

