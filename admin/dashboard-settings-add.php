<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Add Dashboard Item";

if(isset($_POST['submit']))
{
	//echo '<pre>'; print_r($_POST); exit;
	$main_id 			= escapeInputValue($_GET[ 'id' ]);
	$type_id 			= escapeInputValue($_GET[ 'tid' ]);
	
	$category_id		= escapeInputValue($_POST['category_id']);
	$subcategory_id		= escapeInputValue($_POST['subcategory_id']);
	
	if($type_id == 1 || $type_id == 2 || $type_id == 3 ) {
		$item_id			= escapeInputValue($_POST['item_id']);
	} else {
		$item_id			= $subcategory_id;
	}
	
	if($main_id == "" || $type_id == "" || $category_id == "" || $subcategory_id == "" || $item_id == "")
	{
		$error = "Please select all fields";
	}
	
	// Check category validation
	if($error == "")
	{
		$query_1 = "SELECT id, parent_id FROM categories WHERE app_id = $app_id AND id = '$category_id' OR id = '$subcategory_id'";
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = '1.'.$sww;
		}
		else if (mysqli_num_rows($result_1) == 0)
		{
			$error = "Please select category";
		}
		else
		{
			while($row = mysqli_fetch_assoc($result_1))
			{
				if($row['id'] == $category_id)
				{
					$parent_id = $row['parent_id'];
					if($parent_id != NULL && $subcategory_id == "")
					{
						$error = "Please select subcategory";
					}
				}
				if($row['id'] == $subcategory_id)
				{
					$parent_id = $row['parent_id'];
					if($parent_id != $category_id)
					{
						$error = "Please select proper category";
					}
				}
			}
		}
	}
	
	// Check if already existsor not
	if($error == "" && $main_id != 0)
	{
		$query_1 = "SELECT id, display_value FROM dashboard_settings WHERE app_id = $app_id AND display_type = $type_id AND id = $main_id LIMIT 1";
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = '2.'.$sww;
		}
		else if (mysqli_num_rows($result_1) > 0)
		{
			$row = mysqli_fetch_assoc($result_1);
			$display_value = $row['display_value'];
			
			if($type_id == 1 || $type_id == 3)
			{
				$ex_display_value = explode(",", $display_value);
				if(in_array($item_id, $ex_display_value))
				{
					$error = "Item already exists";
				}
			}
			else
			{
				$ex_display_value = explode(",", $display_value);
				
				foreach($ex_display_value as $ex2)
				{
					$ex_2_display_value = explode(":", $ex2);
					if(in_array($item_id, $ex_2_display_value))
					{
						$error = "Item already exists";
					}
				}
			}
		}
	}
	
	// Upload file 
	if($error == "" && ($type_id == 2 || $type_id == 4 ))
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
			$error = "Please select image";
		}
	}
	
	if($error == "" && $main_id == 0)
	{
		if($type_id == 1 || $type_id == 3) {
			$display_value = $item_id;
		} else if($type_id == 2 || $type_id == 4) {
			$display_value = $file_name.":".$item_id;
		}
		
		$query_2 = "INSERT INTO `dashboard_settings`(`app_id`, `display_type`, `display_value`, `display_order`) VALUES ('$app_id', '$type_id', '$display_value', 0)";
		
		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = '3.'.$sww;
		}
	}
	
	if($error == "" && $main_id != 0)
	{
		if($type_id == 1 || $type_id == 3) {
			$ex_display_value[] = $item_id;
			$imp_display_value = implode(",", $ex_display_value);

			$imp_display_value = ltrim($imp_display_value, ",");
			$imp_display_value = rtrim($imp_display_value, ",");
		} else {
			$ex_display_value[] = $file_name.":".$item_id;
			$imp_display_value = implode(",", $ex_display_value);

			$imp_display_value = ltrim($imp_display_value, ",");
			$imp_display_value = rtrim($imp_display_value, ",");
		}
		
		$query_3 = "UPDATE dashboard_settings SET display_value = '$imp_display_value' WHERE app_id = $app_id AND display_type = $type_id AND id = $main_id";
		$res_3 = mysqli_query($link, $query_3);
		
		if(!$res_3)
		{
			$error = '3.'.$sww;
		}
	}
	
	if($error == "")
	{
		if($type_id == 2 || $type_id == 4 )
		{
			if($file_name != "")
			{
				move_uploaded_file($image_tmp_name, "../uploads/store-".$app_id."/banners/" . $file_name);
			}
		}
		
		$success = "Product has been added";
		unset($_POST);
	}
}

if(!isset($_GET[ 'id' ] ) || !isset($_GET[ 'tid' ]) )
{
	$_SESSION['msg_error'] = "1". $sww; header( "Location:dashboard-settings.php" ); exit;
}
else
{
	$main_id 			= escapeInputValue($_GET[ 'id' ]);
	$type_id 			= escapeInputValue($_GET[ 'tid' ]);
		
	if($type_id < 1 || $type_id > 4)
	{
		$_SESSION['msg_error'] = "2". $sww; header( "Location:dashboard-settings.php" ); exit;
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
							<a href="index.php"><span class="fa fa-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-link">
							<a href="dashboard-settings.php">Dashboard Settings</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="dashboard-settings.php" class="pl5 btn btn-default btn-sm">
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
									
									<?php //echo '<pre>'; print_r($_POST); echo '</pre>'; ?>
									<div class="form-group">
										<label class="col-lg-3 control-label">Main Category*</label>
										<div class="col-lg-7">
											<select name="category_id" class="form-control" onChange="loadSubcategory(this.value)">
												<option value="0">Select Category</option>
												<?php 
												$query_cat = "SELECT id, category_name FROM categories WHERE app_id = $app_id AND (parent_id IS NULL OR parent_id = 0) ORDER BY category_name";
												$res_cat = mysqli_query($link, $query_cat);
												while($row_cat = mysqli_fetch_assoc($res_cat))
												{
													echo '<option value="'.$row_cat['id'].'"';
													if(isset($_POST['category_id']) && $_POST['category_id'] == $row_cat['id']) {
														echo ' selected="selected"';
													}
													echo '>'.$row_cat['category_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Sub Category</label>
										<div class="col-lg-7">
											<select name="subcategory_id" id="subcategory_id" class="form-control" onChange="getProducts(this.value)">
												<option value="">Select Sub Category</option>
												<?php if(isset($_REQUEST['subcategory_id'])) { 
												$subcategory_id = $_REQUEST['subcategory_id'];
												$query_cat = "SELECT id, category_name FROM categories WHERE app_id = $app_id AND parent_id = $category_id ORDER BY category_name";
												$res_cat = mysqli_query($link, $query_cat);
												while($row_cat = mysqli_fetch_assoc($res_cat)) {
													echo '<option value="'.$row_cat['id'].'"';
													if(isset($_POST['subcategory_id']) && $_POST['subcategory_id'] == $row_cat['id']) {
														echo ' selected="selected"';
													}
													echo '>'.$row_cat['category_name'].'</option>';
												} }
												?>
											</select>
										</div>
									</div>
									
									<?php if($type_id == 1 || $type_id == 2 || $type_id == 3) { ?>
									<div class="form-group">
										<label class="col-lg-3 control-label">Product Name*</label>
										<div class="col-lg-7">
											<select name="item_id" id="product-list" class="form-control" >
												<option value="">Select Product</option>
												<?php if(isset($_REQUEST['item_id'])) { 
												$item_id = $_REQUEST['item_id'];
												$query_cat = "SELECT id, product_name FROM products WHERE app_id = $app_id AND category_id = $subcategory_id ORDER BY product_name";
												$res_cat = mysqli_query($link, $query_cat);
												while($row_cat = mysqli_fetch_assoc($res_cat)) {
													echo '<option value="'.$row_cat['id'].'"';
													if(isset($_POST['item_id']) && $_POST['item_id'] == $row_cat['id']) {
														echo ' selected="selected"';
													}
													echo '>'.$row_cat['product_name'].'</option>';
												} }
												?>
											</select>
										</div>
									</div>
									<?php } ?>
									
									<?php if($type_id == 2 || $type_id == 4 ) { ?>
									<div class="form-group">
										<label class="col-lg-3 control-label">Select Banner Image</label>
										<div class="col-lg-7">
											<input type="file" class="form-control" name="file_name">
											<span class="help-block mt5"><i class="fa fa-bell"></i> Recommended image resolution: 600x800; allowed formats: jpg, jpeg, png; max size: 2MB</span>
										</div>
									</div>
									<?php } ?>
									
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="" class="btn btn-warning">Cancel</a>
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
	<script src="assets/js/custom.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function () {
			"use strict";
			// Init Theme Core
			Core.init();
			// Init Demo JS
			Demo.init();
		});
	</script>
</body>
</html>