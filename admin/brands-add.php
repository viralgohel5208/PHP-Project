<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$page_title = "Add Brand";

if(isset($_POST['submit']))
{
	$brand_name 		= escapeInputValue($_POST['brand_name']);
	$status 			= escapeInputValue($_POST['status']);
		
	/*if($brand_name == "")
	{
		$error = "Please enter brand name";
	}*/
	
	if($error == "")
	{
		if( $_FILES['file_name']['error'] != 4 )
		{
			$image 			= $_FILES['file_name']['name'];
			$image_type 	= $_FILES['file_name']['type'];
			$image_size 	= $_FILES['file_name']['size'];
			$image_error 	= $_FILES['file_name']['error'];
			$image_tmp_name = $_FILES['file_name']['tmp_name'];

			$image_val = image_validation( $image, $image_type, $image_size, $image_error, $image_tmp_name) ;

			if( $image_val['error'] == "" )
			{
				$file_name = $image_val['image'];
			}
			else
			{
				$error = $image_val['error'];
			}
		}
		else
		{
			//$file_name = "";
			$error = "Please select brand image";
		}
	}
	
	/*if($error == "")
	{
		$query_1 = "SELECT id FROM brands WHERE brand_name = '$brand_name'";
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = $sww;
		}
		else if (mysqli_num_rows($result_1) > 0)
		{
			$error = "Brand name already exists";
		}
	}*/
	
	if($error == "")
	{
		$query_2 = "INSERT INTO `brands`(`app_id`, `brand_name`, `file_name`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$brand_name', '$file_name', '$current_datetime', '$current_datetime', '$status')";

		$result_2 = mysqli_query( $link, $query_2 );

		if($result_2)
		{
			if($file_name != "")
			{
				move_uploaded_file($image_tmp_name, "../uploads/store-".$app_id."/brands/" . $file_name);
			}
			$success = "Brand details has been added successfully";
			unset($_POST);
		}
		else
		{
			$error = $sww;
		}
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
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
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
							<a href="brands.php">Brands</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="brands.php" class="pl5 btn btn-default btn-sm">
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
								<span class="panel-title"><span class="fa fa-plus"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-lg-3 control-label">Brand Name</label>
										<div class="col-lg-7">
											<input type="text" id="" class="form-control" name="brand_name" value="<?php if(isset($_POST['brand_name'])) { echo $_POST['brand_name']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Image</label>
										<div class="col-lg-7">
											<input type="file" class="form-control" name="file_name">
											<span class="help-block mt5"><i class="fa fa-bell"></i> Recommended image resolution: a X b; allowed formats: jpg, jpeg, png; max size: 2MB</span>
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
											<a href="brands.php" class="btn btn-warning">Cancel</a>
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