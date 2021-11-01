<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Update Category Details";

$app_id = $_SESSION['app_id'];

if(isset($_POST['submit']))
{
	//echo '<pre>'; print_r($_POST); exit;
	$item_id 			= escapeInputValue($_GET['id']);
	$parent_id 			= escapeInputValue($_POST['parent_id']);
	$category_name 		= escapeInputValue($_POST['category_name']);
	$status 			= escapeInputValue($_REQUEST['status']);
	$old_file_name 		= escapeInputValue($_POST['old_file_name']);
	
	if (isset($_POST['rm_file_name'])) {
		$rm_file_name = 1;
	} else {
		$rm_file_name = 0;
	}
	
	if($category_name == "")
	{
		$error = "Please enter category name";
	}
	
	if ( $error == "" && $_FILES[ 'file_name' ][ 'error' ] != 4 )
	{
		$image 				= $_FILES[ 'file_name' ][ 'name' ];
		$image_type 		= $_FILES[ 'file_name' ][ 'type' ];
		$image_size 		= $_FILES[ 'file_name' ][ 'size' ];
		$image_error 		= $_FILES[ 'file_name' ][ 'error' ];
		$image_tmp_name 	= $_FILES[ 'file_name' ][ 'tmp_name' ];

		$image_val = image_validation( $image, $image_type, $image_size, $image_error, $image_tmp_name );

		if ( $image_val[ 'error' ] == "" ) {
			$file_name = $image_val[ 'image' ];
		} else {
			$error = $image_val[ 'error' ];
		}
	}
	else if ( $rm_file_name == 1 )
	{
		$file_name = "";
		//$error = "Please select category image";
	}
	else
	{
		$file_name = $old_file_name;
	}
	
	if($error == "")
	{
		$query_1 = "SELECT id FROM categories WHERE app_id = $app_id AND category_name = '$category_name' AND id != $item_id";
		
		if($parent_id != 0)
		{
			$query_1 .= " AND parent_id = $parent_id";
		}
		else
		{
			$query_1 .= " AND (parent_id = 0 OR parent_id IS NULL) ";
		}
		//echo $query_1;
		$result_1 = mysqli_query($link, $query_1);
		
		if (mysqli_num_rows($result_1) > 0)
		{
			$error = "Category name already exists";
		}
	}
	
	if($error == "")
	{
		$query_2 = "UPDATE `categories` SET ";
		if($parent_id != "") {
			$query_2 .= "`parent_id` = '$parent_id', ";
		} else {
			$query_2 .= "`parent_id` = NULL, ";
		}
		
		$query_2 .= "`category_name` = '$category_name', `file_name` = '$file_name', `status` = '$status', `updated_at` = '$current_datetime' WHERE id = $item_id AND app_id = $app_id";

		$result_2 = mysqli_query( $link, $query_2 );

		if($result_2)
		{
			if($file_name != "" && $file_name != $old_file_name)
			{
				if($old_file_name != "" && file_exists("../uploads/store-".$app_id."/categories/" . $old_file_name))
				{
					unlink("../uploads/store-".$app_id."/categories/" . $old_file_name);
				}
				//else { echo $old_file_name; exit; }
				move_uploaded_file($image_tmp_name, "../uploads/store-".$app_id."/categories/" . $file_name);
			}

			if($rm_file_name == 1 && $old_file_name != "" && file_exists("../uploads/store-".$app_id."/categories/".$old_file_name))
			{
				unlink( "../uploads/store-".$app_id."/categories/".$old_file_name );
			}

			$success = "Category details has been updated successfully";
			unset($_POST);
			unset($_FILES);
		}
		else
		{
			$error = $sww;
		}
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT * FROM `categories` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			$_SESSION['msg_error'] = "Category details does't found";
			header( "Location:categories.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:categories.php" );
		exit;
	}
}
else
{
	header( "Location:categories.php" );
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
							<a href="index.php"><span class="fa fa-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-link">
							<a href="categories.php">Categories</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="categories.php" class="pl5 btn btn-default btn-sm">
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
										<label class="col-lg-3 control-label">Main Category</label>
										<div class="col-lg-7">
											<select name="parent_id" class="form-control" disabled>
												<option value="">-</option>
												<?php 
												$query_cat = "SELECT id, category_name FROM categories WHERE app_id = $app_id AND (parent_id IS NULL OR parent_id = 0) ORDER BY category_name";
												$res_cat = mysqli_query($link, $query_cat);
												while($row_cat = mysqli_fetch_assoc($res_cat))
												{
													echo '<option value="'.$row_cat['id'].'"';
													if(isset($_POST['parent_id'])) {
														if($_POST['parent_id'] == $row_cat['id']) {
															echo ' selected="selected"';
														}
													} else {
														if($row_3['parent_id'] == $row_cat['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row_cat['category_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									<input type="hidden" class="" name="parent_id" value="<?php if(isset($_POST['parent_id'])) { echo $_POST['parent_id'];} else { echo $row_3['parent_id']; } ?>">
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Category Name*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="category_name" value="<?php if(isset($_POST['category_name'])) { echo $_POST['category_name'];} else { echo $row_3['category_name']; } ?>">
										</div>
									</div>
									<?php if($row_3['file_name'] != "" && file_exists("../uploads/store-".$app_id."/categories/".$row_3['file_name'])){ ?>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-7">
											<img src="../uploads/store-<?php echo $app_id; ?>/categories/<?php echo $row_3['file_name']; ?>" width="100px" class=""/>
											<label class="checkbox-inline ml10 mr20 mt20">
											<input type="checkbox" name="rm_file_name" value="1">Remove image
										</label>
										</div>
									</div>
									<?php } ?>
									<div class="form-group">
										<label class="col-lg-3 control-label">Select Image</label>
										<div class="col-lg-7">
											<input type="file" class="form-control" name="file_name">
											<input type="hidden" name="old_file_name" value="<?php echo $row_3['file_name']; ?>">
											<span class="help-block mt5"><i class="fa fa-bell"></i> Recommended image resolution: 600x800; allowed formats: jpg, jpeg, png; max size: 2MB</span>
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
											<a href="categories.php" class="btn btn-warning">Cancel</a>
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
	
	<form id="delete_form" action="categories.php" method="post" style="display: hidden">
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