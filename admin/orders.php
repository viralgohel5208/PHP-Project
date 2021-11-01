<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Orders";

$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

if($role_id != 1 && $role_id != 2)
{
	$store_id = $_SESSION['store_id'];
}
else
{
	$store_id = 0;
	if(isset($_GET['id']))
	{
		$store_id = $_GET['id'];
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title.' - '.$application_name; ?></title>
	<meta name="keywords" content=""/>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/datatables_addons.min.css">
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="tables-basic-page">
	<div id="main">
		<?php require_once "header.php"; ?>
		<?php require_once "sidebar.php"; ?>

		<section id="content_wrapper">
			<header id="topbar">
				<div class="topbar-left">
					<ol class="breadcrumb">
						<li class="crumb-active">
							<a href="orders.php"><?php echo $page_title; ?></a>
						</li>
						<li class="crumb-icon">
							<a href="index.php"><span class="fa fa-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				<div class="topbar-right">
					<div class="ml15 ib va-m">
						<?php /*?><a href="orders-add.php" class="pl5 btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add New
						</a>
						<a href="orders-sort.php" class="pl5 btn btn-default btn-sm" style="margin-left: 20px;">
							<i class="fa fa-signal"></i> Sort Order
						</a><?php */?>
					</div>
				</div>
			</header>

			<section id="content">
				<div class="row">
					<div class="col-md-12">
						<?php require_once "message-block.php"; ?>
						<?php if($role_id == 2) { ?>
						<div class="panel panel-visible panel-dark">
                            <div class="panel-heading panel-visible">
                                <span class="panel-title">
                                    <span class="fa fa-map-pin"></span> Select Store
                                </span>
                            </div>
							<?php 
							$result3 = mysqli_query($link, "SELECT * FROM stores WHERE app_id = $app_id ORDER BY store_name");
							?>
							 <div style="padding: 10px; ">
								<label class="col-lg-3 control-label" style="margin-top: 15px;">Choose Store</label>
								<select name="store_id" style="padding: 10px;border: #F0F0F0 3px solid;border-radius: 4px;background-color: #FFF;width: 50%;" onChange="getStore(this.value);" >
									<option value="">Select Store</option>
									<?php foreach($result3 as $store) { ?>
									<option value="<?php echo $store["id"]; ?>" <?php if($store["id"] == $store_id){ echo 'selected=selected';} ?>><?php echo $store["store_name"]?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<?php } ?>
						<?php if($store_id != 0) { ?>
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title">
									<span class="fa fa-shopping-cart"></span><?php echo $page_title; ?>
								</span>
								<?php /*?><div class="pull-right hidden-xs">
									<a href="orders-add.php" class="btn btn-xs btn-default btn-block mr20" style="margin-top: 8px;">Add New</a>
								</div><?php */?>
							</div>
							<div class="panel-body pn">
								<table id="datatable_grid" class="display table table-striped table-bordered">
									<thead>
										<tr>
											<th style="width: 30px;">Sr. No</th>
											<th>Customer Name</th>
											<th>Order Number</th>
											<th>Total</th>
											<th style="width: 120px;">Added Date</th>
											<th style="width: 50px;">Payment</th>
											<th style="width: 50px;">Status</th>
											<th style="width: 70px;">Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Sr. No</th>
											<th>Customer Name</th>
											<th>Order Number</th>
											<th>Total</th>
											<th>Added Date</th>
											<th>Payment</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<?php } ?>
					</div>					
				</div>
			</section>
		</section>
	</div>
	
	<form id="delete_form" action="" method="post" style="display: hidden">
		<input type="hidden" id="delete_id" name="delete_id" value="">
	</form>

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="vendor/plugins/datatables/media/js/datatables.min.js"></script>
	<script src="vendor/plugins/datatables/media/js/datatables_addons.min.js"></script>
	<script src="vendor/plugins/datatables/media/js/datatables_editor.min.js"></script>
	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/custom.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function () {
			"use strict";
			// Init Theme Core    
			Core.init();
			// Init Demo JS  
			Demo.init();
		} );
		
		$(document).ready(function () {
			// Init DataTables
			$('#datatable_grid').DataTable({
				"aoColumnDefs": [ {
					'bSortable': false,
					'aTargets': [ -1 ]
				} ],
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
					url :"orders-datatable.php?id=<?php echo $store_id; ?>", // json datasource
					type: "post",  // type of method  ,GET/POST/DELETE
					error: function(){
						$("#datatable_grid_processing").css("display","none");
					}
				}
			});
		});
		
		function getStore(val)
		{
			window.location='orders.php?id='+val;
		}
	</script>
</body>
</html>