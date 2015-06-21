
<script>
function ajaxRequest(url){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", url, false);
	xmlhttp.send();
	var str = xmlhttp.responseText;
	var obj = JSON.parse(str);
	return obj;
}

window.onload = function(){
	var url = "<?php echo base_url(); ?>index.php/api/get/ingredient";
	var obj = ajaxRequest(url);
	var dddd = document.getElementById("str_id");
	for(var i=0; i<obj.length; i++){
		dddd.innerHTML += "<option value='" + obj[i].ingredient_id + "' >"  + obj[i].ingredient_name + "</option>";
	}
}
</script>



<div class="row">
	<div class="span12">
	<form class="form-inline" method="post">
	<label for="event_date">তারিখ:</label> 
	<input type="text" id="datepicker" name="event_date"  />
	<label for="str_id">Ingredient </label>
			<select name="str_id" id="str_id">
				<option value="all">সকল উপাদান</option>
			</select>
	<label for="type">টাইপ</label>
			<select name="type" id="type">
				<option value="1">Stock</option>
				<option value="2">Requisition</option>
			</select>		
	<input type="submit" name="submit" value="View" class="btn btn-primary" />
	</form>
	<table class="table table-bordered table-striped table-condensed" width="100%">
			<tr>
				<th>Ingredient Name</th>
				<th>Quantity</th>
				<th>Unit</th>
				<th>Type</th>
				<th>Date</th>
				<th>By Person</th>
			</tr>
			<?php
			$de = null;
				foreach($store as $d){
					if($d['type'] == "1"){
						$de = "stock";}
					else if($d['type'] == "2"){
						$de = "Requisition";}	
					echo "<tr>";
						echo "<td>{$d['ingredient_name']}</td>";
						echo "<td>{$d['quantity']}</td>";
						echo "<td>{$d['ingredient_unit']}</td>";
						echo "<td>{$de}</td>";
						echo "<td>{$d['date']}</td>";
						echo "<td>{$d['person_name']}</td>";
						
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>	
