<?php if( $this->models->is_logged_in() == FALSE ) redirect("user/login") ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
	<title>BIAM Catering Management System</title>
	
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
	
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	
	<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" media="screen">
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
	
	<script src="<?php echo base_url(); ?>assets/js/parsley.min.js"></script>
	
	<script>
		$(function() {
			$( "#datepicker" ).datepicker( {dateFormat: "yy-mm-dd"} );
		});
		$(function() {
			$( ".datepicker" ).datepicker( {dateFormat: "yy-mm-dd"} );
		});
		function custom_print()
		{
			console.log("printing...");
			var display_setting="toolbar=no,location=no, menubar=no,";
			display_setting += "scrollbars=yes, width=900px"; 
			
			var content_value = document.getElementById("content").innerHTML;
			
			var docprint=window.open( "", "", display_setting); 
			
			var str = "<b>document.onload = window.print();</b>";
			str = str.replace("b", "script");
			str = str.replace("b", "script");
			
			docprint.document.open(); 
			docprint.document.write('<html><head><title>BIAM Catering Management System</title>');
			docprint.document.write('<style>table, td, th, tr{border:1px solid;} table{width:100%;}</style>');
			docprint.document.write('</head><body onLoad="self.print()"><center><h1>BIAM Catering Management System</h1>');          
			docprint.document.write(content_value); 
			docprint.document.write(str); 
			docprint.document.write('</center></body></html>'); 
			docprint.document.close();
			
			docprint.focus(); 
		}
	</script>
</head>

<body>
	<div class="container">
		
    	<div class="page-header">
			<h1 class="text-center">BIAM Catering Management System</h1>
			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<ul class="nav">
						<li><a href="<?php echo base_url(); ?>">Home</a></li>
						
						<li><a href="<?php echo base_url() . "index.php/market/status"; ?>">Status</a></li>
						
						<li><a href="<?php echo base_url() . "index.php/market/accounting"; ?>">Accounting</a></li>
						
						<li><a href="<?php echo base_url() . "index.php/market/bazar"; ?>">Bazar</a></li>
						<li><a href="<?php echo base_url() . "index.php/market/set_price"; ?>">Set Price</a></li>
						<li><a href="<?php echo base_url() . "index.php/market/extra"; ?>">Miscellaneous</a></li>
						
						<li><a href="<?php echo base_url() . "index.php/menu/view_by_date"; ?>">List Menus</a></li>
						
						<li><a href="<?php echo base_url() . "index.php/menu/create"; ?>">New Menu</a></li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">List<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url() . "index.php/package/all"; ?>">List Packages</a></li>
								<li><a href="<?php echo base_url() . "index.php/item/view"; ?>">List Items</a></li>
								<li><a href="<?php echo base_url() . "index.php/ingredient/view"; ?>">List Ingredients</a></li>
								
								<li><a href="<?php echo base_url() . "index.php/user/view"; ?>">List Users</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">New<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url() . "index.php/package/create"; ?>">New Package</a></li>
								<li><a href="<?php echo base_url() . "index.php/item/create"; ?>">New Item</a></li>
								<li><a href="<?php echo base_url() . "index.php/ingredient/create"; ?>">New Ingredient</a></li>
							</ul>
						</li>
						
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Store<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url() . "index.php/store/create"; ?>">New Entry</a></li>
								<li><a href="<?php echo base_url() . "index.php/store/view_stock"; ?>">View Store</a></li>
								<li><a href="<?php echo base_url() . "index.php/store/stock"; ?>">View Transaction</a></li>

							</ul>
						</li>
						

					</ul>

					<div class="pull-right">
						<a onclick="custom_print()" class="btn"><i class="icon-print"></i> Print</a>
						<a href="<?php echo base_url() . "index.php/user/logout"; ?>" class="btn"><i class="icon-off"></i> Log Out</a>
					</div>

				</div>
			</div>
		</div>
		
		<div id="content">
		
