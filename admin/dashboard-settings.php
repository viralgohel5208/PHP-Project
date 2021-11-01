<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$page_title = "Dashboard Settings";

if(isset($_POST['main_id']))
{
	$type_id 	= escapeInputValue($_POST['type_id']);
	$item_id 	= escapeInputValue($_POST['item_id']);
	$main_id 	= escapeInputValue($_POST['main_id']);
	
	//echo '<pre>'; print_r($_POST); exit;
	$query_3 = "SELECT display_value FROM `dashboard_settings` WHERE id = '" . $main_id . "' AND app_id = $app_id LIMIT 1";
	
	$result_3 = mysqli_query( $link, $query_3);

	if(!$result_3)
	{
		$_SESSION['msg_error'] = $sww;
	}
	else
	{
		if ( mysqli_num_rows( $result_3 ) == 0 )
		{
			$_SESSION['msg_error'] = "No records found";
		}
		else
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );

			$display_value = $row_3['display_value'];
			$ex_display_value = explode(",", $display_value);
			
			//echo $type_id; exit;

			if($type_id == 1 || $type_id == 3)
			{
				if($item_id != 0)
				{
					if (($key = array_search($item_id, $ex_display_value)) !== false) {
						unset($ex_display_value[$key]);
					}
					$imp_display_value = implode(",", $ex_display_value);
				}
			}
			if($type_id == 2 || $type_id == 4)
			{
				//echo $item_id;
				if($item_id != 0)
				{
					$new_disp_val = [];
					foreach($ex_display_value as $ed)
					{
						$ex_2_display_value = explode(":", $ed);
						$file_name = $ex_2_display_value[0];

						if($item_id == $ex_2_display_value[1])
						{
							@unlink("../uploads/store-".$app_id."/banners/".$file_name);
						}
						else
						{
							$new_disp_val[] = $ed;
						}
					}

					$imp_display_value = implode(",", $new_disp_val);
				}
				else
				{
					//echo "ok";
					foreach($ex_display_value as $ed)
					{
						//echo "ok2";
						$ex_2_display_value = explode(":", $ed);
						$file_name = $ex_2_display_value[0];
						//echo "ok3";
						@unlink("../uploads/store-".$app_id."/banners/".$file_name);
					}
				}
			}
			//print_r($new_str); exit;

			if($error == "")
			{
				if($item_id != 0)
				{
					$sql_up = "UPDATE dashboard_settings SET display_value = '$imp_display_value' WHERE id = $main_id";
				}
				else
				{
					$sql_up = "DELETE FROM `dashboard_settings` WHERE id = $main_id";
				}
				$res_query = mysqli_query($link, $sql_up);

				if(!$res_query)
				{
					$_SESSION['msg_error'] = $sww;
				}
				else
				{
					$_SESSION['msg_success'] = "Item has been deleted successfully";
				}
			}
			else
			{
				$_SESSION['msg_error'] = $error;
			}
		}
	}
	
	header("Location:dashboard-settings.php");
	exit;
}

$d_settings = [];

$query = "SELECT * FROM dashboard_settings WHERE app_id = $app_id ORDER BY display_order ASC";
	
$res_query = mysqli_query($link, $query);

if(!$res_query)
{
	$error_code = 3; $error_string = $sww;
}
else if(mysqli_num_rows($res_query) == 0)
{
	$error_code = 3; $error_string = "No records found";
}
else
{
	$d_settings = [];
	while($row = mysqli_fetch_assoc($res_query))
	{
		$d_settings[] = $row;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $page_title.' - '.$application_name; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	<style>div#content { padding: 20px 20px 0 20px; }</style>
</head>
<body class="tables-datatables-page">
    <div id="main">
        <?php require_once "header.php"; ?>
        <?php require_once "sidebar.php"; ?>
        <section id="content_wrapper">
			<header id="topbar">
				<div class="topbar-left">
					<ol class="breadcrumb">
						<li class="crumb-active">
							<a href=""><?php echo $page_title; ?></a>
						</li>
						<li class="crumb-icon">
							<a href="index.php"><span class="glyphicon glyphicon-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="index.php" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>				
			</header>
            
            <div id="content">
				<div class="row" style="margin: 0">
					<?php require_once "message-block.php"; ?>
				</div>
				
				<div class="row text-center" style="margin-bottom: 10px">
					<?php foreach(listDashboardType() as $key=>$value)
					{
						echo '<div class="col-xs-3"><a href="dashboard-settings-add.php?tid='.$key.'&id=0" class="btn btn-hover btn-dark btn-block">'.$value.'</a></div>';
					}
					?>
				</div>
				<?php 
				foreach($d_settings as $ds)
				{
					$records = [];
					$main_id = $ds['id'];
					$display_type = $ds['display_type'];
					$display_value = $ds['display_value'];
					// 1/2 Products List
				?>
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-visible panel-dark">
							<div class="panel-heading panel-visible">
								<span class="panel-title">
									<span class="fa fa-bars"></span><?php echo getDashboardType($ds['display_type']);?>
								</span>
								<div class="pull-right hidden-xs">
									<a href="dashboard-settings-add.php?tid=<?php echo $display_type; ?>&id=<?php echo $main_id; ?>" class="btn btn-xs btn-danger mr20" >Add New </a>
									<a onclick="delete_func_2(<?php echo $display_type; ?>, 0, <?php echo $main_id; ?>)" class="btn btn-xs btn-danger mr20" >Remove </a>
								</div>
							</div>
							<div class="panel-body">
								<?php if($display_value == "") { echo 'No records found'; } else { ?>
								<?php if($display_type == 1) { ?>
								<table class="table">
									<thead>
										<tr class="primary">
											<th>#</th>
											<th>Category Name</th>
											<th>Product Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$query = "SELECT P.id, P.product_name, C.category_name FROM products AS P INNER JOIN categories AS C ON C.id = P.category_id WHERE P.app_id = $app_id AND P.id IN (".$display_value.")";

										$res_query = mysqli_query($link, $query);

										if(!$res_query)
										{
											//$error_code = 3; $error_string = $sww;
										}
										else if(mysqli_num_rows($res_query) == 0)
										{
											//$error_code = 3; $error_string = "";
										}
										else
										{
											$i = 1;
											while($row = mysqli_fetch_assoc($res_query))
											{
										?>
										<tr>
											<td><?= $i ?></td>
											<td><?php echo $row['category_name']; ?></td>
											<td><?php echo $row['product_name']; ?></td>
											<td><a onclick="delete_func_2(<?php echo $display_type; ?>, <?php echo $row['id']; ?>, <?php echo $main_id; ?>)" class="btn btn-danger btn-xs"> &nbsp;<i class="fa fa-trash"></i></a></td>
										</tr>
										<?php $i++; } } ?>
									</tbody>
								</table>
								<?php } else if($display_type == 2) { ?>
								<div>
									<?php //echo $display_value;
									$ex_display_value = explode(",", $display_value);

									$row = [];
									foreach($ex_display_value as $ex)
									{
										$ex_file_name = explode(":", $ex);

										$image_name = $ex_file_name[0];
										$item_id = $ex_file_name[1];
										
										$query_pro = "SELECT id, product_name, created_at FROM products WHERE id = $item_id ";
										$res_pro = mysqli_query($link, $query_pro);
										$row_pro = mysqli_fetch_assoc($res_pro);
									?>
									<div class="col-md-3">
									<div style="height: 250px; display:table-cell; vertical-align:middle; text-align:center">
									<img src="../uploads/store-<?= $app_id; ?>/banners/<?php echo $image_name; ?>" class="img-responsive" title="<?php echo $row_pro['product_name']; ?>">
									</div>

									<h6>
										<?php echo $row_pro['product_name']; ?>
										<a onclick="delete_func_2(<?php echo $display_type; ?>, <?php echo $item_id; ?>, <?php echo $main_id; ?>)" style="cursor: pointer" title="Delete"><span class="fa fa-trash fs12 text-danger"></span></a>
									</h6>
									</div>
									<?php } ?>
								</div>
								<?php } if($display_type == 3) { ?>
								<table class="table">
									<thead>
										<tr class="primary">
											<th>#</th>
											<th>Category Name</th>
											<th>Product Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$query = "SELECT P.id, P.product_name, C.category_name FROM products AS P INNER JOIN categories AS C ON C.id = P.category_id WHERE P.app_id = $app_id AND P.id IN (".$display_value.")";

										$res_query = mysqli_query($link, $query);

										if(!$res_query)
										{
											//$error_code = 3; $error_string = $sww;
										}
										else if(mysqli_num_rows($res_query) == 0)
										{
											//$error_code = 3; $error_string = "";
										}
										else
										{
											$i = 1;
											while($row = mysqli_fetch_assoc($res_query))
											{
												$item_id = $row['id'];
										?>
										<tr>
											<td><?= $i ?></td>
											<td><?php echo $row['category_name']; ?></td>
											<td><?php echo $row['product_name']; ?></td>
											<td><a onclick="delete_func_2(<?php echo $display_type; ?>, <?php echo $item_id; ?>, <?php echo $main_id; ?>)" class="btn btn-danger btn-xs"> &nbsp;<i class="fa fa-trash"></i></a></td>
										</tr>
										<?php $i++; } } ?>
									</tbody>
								</table>
								<?php } else if($display_type == 4) { ?>
								<div id="mix-container2">
									<?php //echo $display_value;
									$ex_display_value = explode(",", $display_value);

									$row = [];
									foreach($ex_display_value as $ex)
									{
										$ex_file_name = explode(":", $ex);

										$image_name = $ex_file_name[0];
										$item_id = $ex_file_name[1];
										
										$query_pro = "SELECT id, category_name, created_at FROM categories WHERE id = $item_id ";
										$res_pro = mysqli_query($link, $query_pro);
										$row_pro = mysqli_fetch_assoc($res_pro);
									?>
									<div class="col-md-3">
										<div style="height: 250px; display:table-cell; vertical-align:middle; text-align:center">
											<img src="../uploads/store-<?= $app_id; ?>/banners/<?php echo $image_name; ?>" class="img-responsive" title="<?php echo $row_pro['category_name']; ?>">
										</div>
										<h6>
											<?php echo $row_pro['category_name']; ?>
											<a onclick="delete_func_2(<?php echo $display_type; ?>, <?php echo $item_id; ?>, <?php echo $main_id; ?>)" style="cursor: pointer" title="Delete" ><span class="fa fa-trash fs12 text-danger"></span></a>
										</h6>
									</div>
									<?php if($i%4 == 0) { echo ''; } $i++; } ?>
								</div>
								<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
        </section>
		
        <form id="delete_form" action="" method="post" style="display: hidden">
			<input type="hidden" id="type_id" name="type_id">
			<input type="hidden" id="item_id" name="item_id">
			<input type="hidden" id="main_id" name="main_id">
		</form>
    </div>
	
	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
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
	</script>
</body>
</html>