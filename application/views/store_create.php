<script>
var ingredients;

function get_id(get_obj)
	{
		var i=get_obj.parentNode.parentNode.rowIndex;
		var table = document.getElementById('dataTable');
		var str = $(table.rows[i].cells[1]).find('option:selected').val();
		var url = "<?php echo base_url(); ?>index.php/api/get/ingredient/"+str;
		var obj = ajaxRequest(url);
		var stk = obj.ingredient_stock;
		var unit = obj.ingredient_unit;
		$(table.rows[i].cells[2]).html ("<input type=\"text\" value=\"" + stk +" "+ unit + "\" disabled/> ");
	}

function make_row(x){
	if( typeof x == undefined ) x = null;
	var frst_stk = ingredients[0].ingredient_stock;
	var frst_unit = ingredients[0].ingredient_unit;
	var start = '\
		<tr>\
		<td ><input type="checkbox" name="chk[]"/></td>\
		<td><select id="ingredient" name="ingredient[]" onchange="get_id(this)">';
	var end = '\
		</select>\
		<td><input id="stock" value="' + frst_stk + " " + frst_unit + '" type="text" name="stock[]" disabled/></td>\
		<td><input type="text" name="quantity[]" /></td>\
		</td>\
		</tr>';
	var options = "";
	//options += "<option>" + "</option>";	
	for(var i=0; i<ingredients.length; i++){
		if( ingredients[i].ingredient_id == x ){ options += "<option value='" + ingredients[i].ingredient_id + "' selected>"  + ingredients[i].ingredient_name + "</option>";
		}
		else{
			options += "<option value='" + ingredients[i].ingredient_id + "'>"  + ingredients[i].ingredient_name + "</option>";
		}
	}
	return start + options + end;
}

window.onload = function(){
	//load ingredient information
	console.log("loading ingredient information");
	var ingredienturl = "<?php echo base_url(); ?>index.php/api/get/ingredient";
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
	<div class="span8 offset3 well">
		<h2>New Item</h2>
		<form method="POST">
			<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
			<label for="datepicker">তারিখ:</label> 
			<input type="text" name="event_date" id="datepicker">
			<br/>
			<label for="person_name">বাজারকারীর নাম:</label> 
			<input type="text" name="person_name" id="person_name">
			<br/>
			<label for="type">Type:</label>
			<select id="type" name="type">
				<option value="1">Stock</option>
				<option value="2">Requisition</option>
				
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
					<th>Ingredients Stock</th>
					<th>Ingredients Amount</th>
				</tr>
			</table>
			<input class="btn btn-primary" type="submit" name="submit">
		</form>
	</div>
</div>
