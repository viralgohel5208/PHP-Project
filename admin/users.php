<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Users";

if(isset($_POST['delete_id']))
{
	$id = escapeInputValue($_POST['delete_id']);
	
	$query_3 = "SELECT id FROM `customers` WHERE id = '" . $id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
			
			/*$result = "DELETE FROM customers WHERE id = '" . $id . "'";

			if(mysqli_query($link, $result))
			{
				$_SESSION['msg_success'] = "Item has been deleted successfully";
			}
			else
			{
				$_SESSION['msg_error'] = $sww;
			}*/
			
			/*$file_name = $row_3['file_name'];
			
			$result = "DELETE FROM admin_workshops WHERE admin_id = '" . $id . "'";
	
			if(!mysqli_query($link, $result))
			{
				$_SESSION['msg_error'] = $sww;
			}
			else
			{
				$result = "DELETE FROM admin WHERE id = '" . $id . "'";

				if(mysqli_query($link, $result))
				{
					$_SESSION['msg_success'] = "Item has been deleted successfully";
				}
				else
				{
					$_SESSION['msg_error'] = $sww;
				}
			}*/
		}
	}
	header("Location:users.php");
	exit;
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
							<a href="users.php"><?php echo $page_title; ?></a>
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
				<?php if($_SESSION['can_create_customer_backend'] == 1) { ?>
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="users-add.php" class="pl5 btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add New
						</a>
						<?php /*?><a href="users-sort.php" class="pl5 btn btn-default btn-sm" style="margin-left: 20px;">
							<i class="fa fa-signal"></i> Sort Order
						</a><?php */?>
					</div>
				</div>
				<?php } ?>
			</header>

			<section id="content">
				<div class="row">
					<div class="col-md-12">
						
						<?php require_once "message-block.php"; ?>
						
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title">
									<span class="fa fa-user"></span><?php echo $page_title; ?>
								</span>
								<?php if($_SESSION['can_create_customer_backend'] == 1) { ?><div class="pull-right hidden-xs">
									<a href="users-add.php" class="btn btn-xs btn-default btn-block mr20" style="margin-top: 8px;">Add New</a>
								</div>
								<?php } ?>
							</div>
							<div class="panel-body pn">
								<table id="datatable_grid" class="display table table-striped table-bordered">
									<thead>
										<tr>
											<th style="width: 40px;">Sr. No</th>
											<th style="">User Name</th>
											<th style="">First Name</th>
											<th style="">Last Name</th>
											<th style="width: 105px;">Email</th>
											<th style="width: 105px;">Mobile</th>
											<th style="width: 40px;">Status</th>
											<th style="width: 60px;">Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Sr. No</th>
											<th>User Name</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>						
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
					url :"users-datatable.php", // json datasource
					type: "post",  // type of method  ,GET/POST/DELETE
					error: function(){
						$("#datatable_grid_processing").css("display","none");
					}
				}
			});
		});

		function changeDisplayOrder(pri_id)
		{
			var display_order = $('#display_order_'+pri_id).val();
			$.ajax({
				type: "POST",
				url: "ajax-general.php",
				data:'type=1&id='+pri_id+'&display_order='+display_order,
				success: function(data){
					eval(data);
					//$("#display_order").val(data);
					//gritterMsg(1, '', 'Minimum Amount Updated Successfully');
				}
			});
		}
	</script>
</body>
</html>