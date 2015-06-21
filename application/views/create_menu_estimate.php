<script>
var ingredients;
var inTable = new Array();
var inSelect = new Array();

function make_row(x){
	if( typeof x == undefined ) x = null;
	if( x == null ) return;
	var str ="<tr>"
		+ "<td>"
		+ ingredients[x].ingredient_name
		+ "</td>"
		+ "<td>" 
		+ "<input type=\"hidden\" name=\"ingredient_id[]\" value=\""
		+ ingredients[x].ingredient_id
		+ "\" />"
		+ "<input type=\"text\" name=\"amount[]\" value=\"" + ingredients[x].amount + "\"/> "
		+ ingredients[x].ingredient_unit
		+ "</td>"
		+ "<td>" 
		+ "<input type=\"button\" onclick=\"removeFromTable("+x+")\" value=\"Remove\" class=\"btn\""
		+ "</td>"
		+ "</tr>";
	return str;
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
	//load ingredient information
	console.log("loading ingredient information");
	var ingredienturl = "<?php echo base_url(); ?>index.php/api/get/ingredient";
	ingredients = ajaxRequest(ingredienturl);
	
	//load menu ingredient information
	console.log("loading menu ingredient information");
	var menuingredienturl = "<?php echo base_url(); ?>index.php/api/get/menu_ingredient/<?php echo $menu_id?>";
	menuingredients = ajaxRequest(menuingredienturl);
	
	
	var gotcha = new Array();
	for(var i=0; i<menuingredients.length; i++){
		gotcha.push(false);
	}
	
	//check for used ingredients in menu
	for(var i=0; i<ingredients.length; i++){
		var found = false;
		for(var j=0; j<menuingredients.length; j++){
			if(gotcha[j]) continue;
			if( JSON.stringify(ingredients[i]) === JSON.stringify(menuingredients[j]) ){
				found = true;
				gotcha[j] = true;
				break;
			}
		}
		if(found) inTable.push(i);
		else inSelect.push(i);
		
		//get amount for ingredient
		ingredients[i].amount = 0;
		if(found){
			var url = "<?php echo base_url(); ?>index.php/api/get/menu_ingredient_amount/<?php echo $menu_id?>/" + ingredients[i].ingredient_id;
			var amount = ajaxRequest(url);
			ingredients[i].amount = amount;
		}
	}
	
	//populate table from data
	populateTable("dataTable");
	
	//populate selection box
	populateSelection("selectionBox");
};

function addToTable(selectID){
	var box = document.getElementById(selectID);
	if(box.selectedIndex < 0) return;
	var idx = box.options[box.selectedIndex].value;
	
	//add to table
	inTable.push(idx);
	
	//remove from select
	for(var i=0; i<inSelect.length; i++){
		if( inSelect[i] == idx ){
			inSelect.splice(i, 1);
			break;
		} 
	}
	
	//populate table from data
	populateTable("dataTable");
	
	//populate selection box
	populateSelection("selectionBox");
}

function removeFromTable(x){
	//add to select
	inSelect.push(x);
	
	//remove from table
	for(var i=0; i<inTable.length; i++){
		if( inTable[i] == x ){
			inTable.splice(i, 1);
			break;
		}
	}
	
	//populate table from data
	populateTable("dataTable");
	
	//populate selection box
	populateSelection("selectionBox");
}

function populateSelection(selectID){
	var box = document.getElementById(selectID);
	box.innerHTML = "";
	for(var i=0; i<inSelect.length; i++){
		var idx = inSelect[i];
		box.innerHTML += "<option value=\"" + inSelect[i] + "\">" + ingredients[idx].ingredient_name + "</option>";
	}
}

function populateTable(tableID){
	console.log("populating table...");
	
	//empty table first
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	console.log(rowCount);
	for(var i = rowCount - 1; i > 0; i--) table.deleteRow(i);
	
	for(var i=0; i<inTable.length; i++){
		var idx = inTable[i];
		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);
		row.innerHTML = make_row(idx);
	}
}

</script>

<div class="row">
	<div class="span12">
		<h2>View Menu Estimation</h2>
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
				<td>মেন্যু:</td>
				<td>
					<?php 
						for($i=0; $i<count($menu_item_data); $i++){
							if( $i > 0 ) echo ", ";
							echo "{$menu_item_data[$i]['item_name']}";
							if($menu_item_data[$i]['quantity'] > 1) echo "({$menu_item_data[$i]['quantity']} টি)";
							if($menu_item_data[$i]['people'] != $menu_data['num_person'] ) echo "({$menu_item_data[$i]['people']} জন)";
						}
					?>
				</td>
			</tr>
		</table>
		<h3>Ingredients Estimation</h3>
		<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
		<form method="post">
			<div>
				<select id="selectionBox">
					<option></option>
				</select>
				<input type="button" value="Add" onclick="addToTable('selectionBox')" class="btn" />
			</div>
			<table id="dataTable" class="table table-bordered table-striped table-condensed" width="100%">
				<tr>
					<th>Ingredient</th>
					<th>Required Amount</th>
					<th>Action</th>
				</tr>
			</table>
			<input class="btn btn-primary" type="submit" name="submit" />
		</form>
	</div>
</div>
