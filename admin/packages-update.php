<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Update Package Details";

if(isset($_POST['submit']))
{
	$item_id 			= escapeInputValue($_GET['id']);
	$package_name 		= escapeInputValue($_POST['package_name']);
	$package_price_raw 	= escapeInputValue($_POST['package_price_raw']);
	$package_details 	= escapeInputValue($_POST['package_details']);
	$package_price_gst 	= escapeInputValue($_POST['package_price_gst']);
	$package_price 		= escapeInputValue($_POST['package_price']);
	$status 			= escapeInputValue($_POST['status']);
	
	$current_datetime 	= currentTime();

	if($package_name == "" || $package_price == "")
	{
		$error = "Please enter package name and price";
	}
	
	if($error == "")
	{
		$query_1 = "SELECT id FROM packages WHERE package_name = '$package_name' AND id != $item_id";
		
		$result_1 = mysqli_query($link, $query_1);
		
		if (mysqli_num_rows($result_1) > 0)
		{
			$error = "Package name already exists";
		}
	}
	
	if($error == "")
	{
		$query_2 = "UPDATE `packages` SET `package_name` = '$package_name', `package_details` = '$package_details', `package_price_raw` = '$package_price_raw', `package_price_gst` = '$package_price_gst', `package_price` = '$package_price', `updated_at` = '$current_datetime', `status` = '$status' WHERE id = $item_id";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = $sww;
		}
		else
		{
			$success = "Package details has been updated successfully";
			unset($_POST);
		}
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT * FROM `packages` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			$_SESSION['msg_error'] = "Package does't found";
			header( "Location:packages.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:packages.php" );
		exit;
	}
}
else
{
	header( "Location:packages.php" );
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
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="form-inputs-page">
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
						<li class="crumb-link">
							<a href="packages.php">Packages</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="packages.php" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>				
			</header>

			<div id="content" class="animated fadeIn">
				<div class="row">
					<div class="col-md-12">

						<?php require_once "message-block.php"; ?>

						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title"><span class="fa fa-pencil"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-lg-3 control-label">Package Name</label>
										<div class="col-lg-7">
											<input type="text" id="" class="form-control" name="package_name" value="<?php if(isset($_POST['package_name'])) { echo $_POST['package_name'];} else { echo $row_3['package_name']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Description (En)</label>
										<div class="col-lg-7">
											<textarea class="form-control" name="package_details" rows="5"><?php if(isset($_POST['package_details'])) { echo $_POST['package_details'];} else { echo $row_3['package_details']; } ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Price Raw</label>
										<div class="col-lg-7">
											<input type="text" id="" class="form-control" name="package_price_raw" value="<?php if(isset($_POST['package_price_raw'])) { echo $_POST['package_price_raw'];} else { echo $row_3['package_price_raw']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Price Gst</label>
										<div class="col-lg-7">
											<input type="text" id="" class="form-control" name="package_price_gst" value="<?php if(isset($_POST['package_price_gst'])) { echo $_POST['package_price_gst']; } else { echo $row_3['package_price_gst']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Package Price</label>
										<div class="col-lg-7">
											<input type="text" id="" class="form-control" name="package_price" value="<?php if(isset($_POST['package_price'])) { echo $_POST['package_price'];} else { echo $row_3['package_price']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Status</label>
										<div class="col-sm-7">
											<select name="status" class="form-control">
												<option value="1" <?php if(isset($_POST['status']) && $_POST['status'] == 1 ) { echo 'selected="selected"'; } else if($row_3['status'] == 1) { echo 'selected="selected"'; } ?>>Active</option>
												<option value="0" <?php if(isset($_POST['status']) && $_POST['status'] == 0 ) { echo 'selected="selected"'; } else if($row_3['status'] == 0) { echo 'selected="selected"'; } ?>>Inactive</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="packages.php" class="btn btn-warning">Cancel</a>
											<a onclick="delete_func('<?php echo $item_id; ?>')" class="btn btn-danger">Delete</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<form id="delete_form" action="packages.php" method="post" style="display: hidden">
		<input type="hidden" id="delete_id" name="delete_id" value="">
	</form>

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