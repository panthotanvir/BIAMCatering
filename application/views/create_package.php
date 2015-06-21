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

	//load item information
	console.log("loading item information");
	var itemurl = "<?php echo base_url(); ?>index.php/api/get/item";
	items = ajaxRequest(itemurl);
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
</script>

<div class="row">
	<div class="span6 offset3 well">
		<h2>নতুন প্যাকেজ</h2>
		<form method="POST">
			<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
			<label for="package_name">প্যাকেজের নাম:</label> 
			<input type="text" name="package_name" id="package_name">
			<br/>
			
			<label for="package_price">দাম (জনপ্রতি):</label>
			<input type="text" name="package_price" id="package_price">
			<br/>

			<p>
				<input type="button" value="Add Item" onClick="addRow('dataTable')" class="btn" /> 
				<input type="button" value="Remove Item" onClick="deleteRow('dataTable')" class="btn" /> 
			</p>

			<table id="dataTable" class="table table-bordered table-striped table-condensed" width="100%">
			</table>
			
			<input class="btn btn-primary" type="submit" name="submit">
		</form>
	</div>
</div>
