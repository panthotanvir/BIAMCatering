<script>
var items;

function make_row(x){
	if( typeof x == undefined ) x = null;
	var start = '\
		<tr>\
		<td ><input type="checkbox" name="chk[]"/></td>\
		<td><select id="item" name="item[]">';
	var end = '\
		</select></td>\
		<td><input type="button" value="Remove" onClick="deleteIndividualRow(this)" class="btn" /></td>\
		</tr>';
	var options = "";
	//options += "<option>" + "</option>";
	for(var i=0; i<items.length; i++){
		if( items[i].item_id == x ) options += "<option value='" + items[i].item_id + "' selected>"  + items[i].item_name + "</option>";
		else options += "<option value='" + items[i].item_id + "' >"  + items[i].item_name + "</option>";
	}
	return start + options + end;
}

function ajaxRequest(url){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", url, false);
	xmlhttp.send();
	var str = xmlhttp.responseText;
	var obj = JSON.parse(str);
	return obj;
}

window.onload = function(){
	//load package information
	var ingredienturl = "<?php echo base_url(); ?>index.php/api/get/ingredient";
	var ingredients = ajaxRequest(ingredienturl);
	var ingredientbox = document.getElementById("ingredient_id");
	for(var i=0; i<ingredients.length; i++){
		ingredient.innerHTML += "<option value='" + ingredients[i].ingredient_id + "' >"  + ingredients[i].ingredient_name + "</option>";
	}

	//on package change
	document.getElementById("ingredient_id").onchange=function(){
		//empty table
		var table = document.getElementById('dataTable');
		while( table.rows.length > 0 ) table.deleteRow(0);
		
		var packagebox = document.getElementById("ingredient_id");
		if(packagebox.selectedIndex == 0) return;
		
		var str = packagebox.options[packagebox.selectedIndex].value;
		var url = "<?php echo base_url(); ?>index.php/api/get/ingredient/"+str;
		var obj = ajaxRequest(url);
		
		var packagebox = document.getElementById("ingredient_id");
		var table = document.getElementById('dataTable');
		
		//repopulate table
		for(var i=0; i<obj.length; i++){
			addRow('dataTable', obj[i].item_id);
		}
		
		//document.getElementById('menu_price').value = ingredients[ingredientbox.selectedIndex-1].ingredient_price;
		
	};


	//load item information
	/*console.log("loading item information");
	var itemurl = "<?php echo base_url(); ?>index.php/api/get/item";
	items = ajaxRequest(itemurl);*/
};



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

function deleteIndividualRow(r)
{
	var i=r.parentNode.parentNode.rowIndex;
	document.getElementById('dataTable').deleteRow(i);
}

</script>

<div class="row-fluid">
	<form method="POST">
		<div class="span6">
			<h2>নতুন</h2>
			<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
			
			
			<label for="datepicker">তারিখ:</label> 
			<input type="text" name="event_date" id="datepicker">
			<br/>
			
			
			<label for="person_name">অতিথি সংখ্যা:</label> 
			<input type="text" name="person_name" id="person_name">
			<br/>
			
			<label for="ingredient_id">প্যাকেজসমূহ:</label>
			<select name="ingredient_id" id="ingredient_id">
				<option></option>
			</select>
			<br/>
			
			
			<input class="btn btn-primary" type="submit" name="submit">
		</div>
		<div class="span6">
			<p> 
				<input type="button" value="Add Item" onClick="addRow('dataTable')" class="btn" /> 
				<input type="button" value="Remove Selected Item(s)" onClick="deleteRow('dataTable')" class="btn" /> 
			</p>

			<table id="dataTable" class="table table-bordered table-striped table-condensed" width="100%">
			</table>
		</div>
	</form>
</div>
