<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

if(isset($_GET['id']))
{
	$item_id = escapeInputValue($_GET['id']);

	$query_3 = "SELECT id, city_id, store_name FROM `stores` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
			$city_id = $row_3['city_id'];
		}
		else
		{
			$_SESSION['msg_error'] = "Store does't found";
			header( "Location:stores.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:stores.php" );
		exit;
	}
}
else
{
	header( "Location:stores.php" );
	exit;
}

if(isset($_POST['submit']))
{
	$store_id			= $item_id;
	$store_area 		= escapeInputValue($_POST['store_area']);
	$delivery_charge 	= escapeInputValue($_POST['delivery_charge']);
	$status 			= escapeInputValue($_REQUEST['status']);
	
	if(!is_numeric($delivery_charge))
	{
		$delivery_charge = 0;
	}
	
	$current_datetime 	= currentTime();
	
	if($store_area == "")
	{
		$error = "Please enter area name";
	}
	
	if($error == "")
	{
		$query_1 = "SELECT id FROM stores_localities WHERE store_id = $store_id AND app_id = $app_id AND store_area = '$store_area'";
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = $sww;
		}
		else if (mysqli_num_rows($result_1) > 0)
		{
			$error = "Area name already exists";
		}
	}
	
	if($error == "")
	{
		$query_2 = "INSERT INTO `stores_localities` (`app_id`, `store_id`, `city_id`, `store_area`, `delivery_charge`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$store_id', '$city_id', '$store_area', '$delivery_charge', '$current_datetime', '$current_datetime', '$status')";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = $sww;
		}
		else
		{
			$success = "Locality has been added.";
			unset($_POST);
		}
	}
}

$page_title = "Add Localities";

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
							<a href="stores.php">Stores</a>
						</li>
						<li class="crumb-link">
							<a href="stores-localities.php?id=<?php echo $row_3['id']; ?>"><?php echo $row_3['store_name']; ?></a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="stores-localities.php?id=<?php echo $row_3['id']; ?>" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>
				
			</header>

			<div id="content">
				<div class="row">
					<div class="col-md-12">
						
						<?php require_once "message-block.php"; ?>

						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title"><span class="fa fa-plus"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post">
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Area Name</label>
										<div class="col-lg-7">
											<input type="text" id="" class="form-control" name="store_area" value="<?php if(isset($_POST['store_area'])) { echo $_POST['store_area']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Delivery Charge</label>
										<div class="col-lg-7">
											<input type="text" id="" class="form-control" name="delivery_charge" value="<?php if(isset($_POST['delivery_charge'])) { echo $_POST['delivery_charge']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Status</label>
										<div class="col-sm-7">
											<select name="status" class="form-control">
												<option value="1" <?php if(isset($_POST['status']) && $_POST['status'] == 1 ) { echo 'selected="selected"'; } ?>>Active</option>
												<option value="0" <?php if(isset($_POST['status']) && $_POST['status'] == 0 ) { echo 'selected="selected"'; } ?>>Inactive</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="stores-localities.php?id=<?php echo $row_3['id']; ?>" class="btn btn-warning">Cancel</a>
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

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>

	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
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