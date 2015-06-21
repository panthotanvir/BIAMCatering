<script>
var items;

function make_row(x){
	if( typeof x == undefined ) x = null;
	var start = '\
		<tr>\
		<td ><input type="checkbox" name="chk[]"/></td>\
		<td><select id="item" name="item[]">';
	var ret = document.getElementById('num_person').value;
	var end = '\
		</select></td>\
		<td ><input type="text" name="quantity[]" value="1" class="input-mini" /></td>\
		<td ><input type="text" name="people[]" value="' + ret + '" class="input-mini" /></td>\
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
	var packageurl = "<?php echo base_url(); ?>index.php/api/get/package";
	var packages = ajaxRequest(packageurl);
	var packagebox = document.getElementById("package_id");
	for(var i=0; i<packages.length; i++){
		packagebox.innerHTML += "<option value='" + packages[i].package_id + "' >"  + packages[i].package_name + "</option>";
	}

	//on package change
	document.getElementById("package_id").onchange=function(){
		//empty table
		var table = document.getElementById('dataTable');
		while( table.rows.length > 0 ) table.deleteRow(0);
		
		var packagebox = document.getElementById("package_id");
		if(packagebox.selectedIndex == 0) return;
		
		var str = packagebox.options[packagebox.selectedIndex].value;
		var url = "<?php echo base_url(); ?>index.php/api/get/package/"+str;
		var obj = ajaxRequest(url);
		
		var packagebox = document.getElementById("package_id");
		var table = document.getElementById('dataTable');
		
		//repopulate table
		for(var i=0; i<obj.length; i++){
			addRow('dataTable', obj[i].item_id);
		}
		
		document.getElementById('menu_price').value = packages[packagebox.selectedIndex-1].package_price;
		
	};


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
			<label for="party_name">প্রতিষ্ঠান/কোর্সের নাম:</label> 
			<input type="text" name="party_name" id="party_name">
			<br/>
			
			<label for="datepicker">তারিখ:</label> 
			<input type="text" name="event_date" id="datepicker">
			<br/>
			
			<label for="event_time">সময়:</label>
			<select id="event_time" name="event_time">
				<option value="সকালের নাস্তা">সকালের নাস্তা</option>
				<option value="চা বিরতি ১">চা বিরতি ১</option>
				<option value="দুপুরের খাবার">দুপুরের খাবার</option>
				<option value="চা বিরতি ২">চা বিরতি ২</option>
				<option value="রাতের খাবার">রাতের খাবার</option>
			</select>
			<br/>
			
			<label for="num_person">অতিথি সংখ্যা:</label> 
			<input type="text" name="num_person" id="num_person">
			<br/>
			
			<label for="package_id">প্যাকেজসমূহ:</label>
			<select name="package_id" id="package_id">
				<option></option>
			</select>
			<br/>
			
			<label for="menu_price">দাম (জনপ্রতি):</label>
			<input type="text" name="menu_price" id="menu_price">
			<br/>
			
			<input class="btn btn-primary" type="submit" name="submit">
		</div>
		<div class="span6">
			<p> 
				<input type="button" value="Add Item" onClick="addRow('dataTable')" class="btn" /> 
				<input type="button" value="Remove Selected Item(s)" onClick="deleteRow('dataTable')" class="btn" /> 
			</p>

			<table id="dataTable" class="table table-bordered table-striped table-condensed">
				<tr>
					<th></th>
					<th>Item</th>
					<th>Quantity</th>
					<th>Number of People</th>
					<th>Action</th>
				</tr>
			</table>
		</div>
	</form>
</div>
