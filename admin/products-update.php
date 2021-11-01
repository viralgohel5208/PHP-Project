<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Update Product Details";

$app_id = $_SESSION['app_id'];

if(isset($_POST['submit']))
{
	$item_id 			= escapeInputValue($_GET['id']);
	$category_id 		= escapeInputValue($_POST['category_id']);
	$subcategory_id		= escapeInputValue($_POST['subcategory_id']);
	$product_name 		= escapeInputValue($_POST['product_name']);
	$sku_number			= escapeInputValue($_POST['sku_number']);
	$brand_id			= escapeInputValue($_POST['brand_id']);
	$product_description= escapeInputValue($_POST['product_description']);
	$status 			= escapeInputValue($_POST['status']);
	//$old_file_name 		= escapeInputValue($_POST['old_file_name']);
	
	if(isset($_REQUEST['privacy_type'])) {
		$privacy_type		= $_REQUEST['privacy_type'];
	} else {
		$privacy_type		= 0;		
	}
	
	if (isset($_POST['rm_file_name'])) {
		$rm_file_name = 1;
	} else {
		$rm_file_name = 0;
	}
	
	if($product_name == "")
	{
		$error = "Please enter product name";
	}
	
	if($error == "")
	{
		$old_image_1    = mysqli_real_escape_string($link, $_POST['old_image_1']);
		$old_image_2    = mysqli_real_escape_string($link, $_POST['old_image_2']);
		$old_image_3    = mysqli_real_escape_string($link, $_POST['old_image_3']);
        $old_image_4    = mysqli_real_escape_string($link, $_POST['old_image_4']);
		$old_image_5    = mysqli_real_escape_string($link, $_POST['old_image_5']);
		$old_image_6    = mysqli_real_escape_string($link, $_POST['old_image_6']);
		
		$rm_image_1 = 0; $rm_image_2 = 0; $rm_image_3 = 0; $rm_image_4 = 0; $rm_image_5 = 0; $rm_image_6 = 0;
		
		if(isset($_POST['rm_image_1']))
		{
			$rm_image_1 = 1;
		}
		if(isset($_POST['rm_image_2']))
		{
			$rm_image_2 = 1;
		}
		if(isset($_POST['rm_image_3']))
		{
			$rm_image_3 = 1;
		}
		if(isset($_POST['rm_image_4']))
		{
			$rm_image_4 = 1;
		}
		if(isset($_POST['rm_image_5']))
		{
			$rm_image_5 = 1;
		}
		if(isset($_POST['rm_image_6']))
		{
			$rm_image_6 = 1;
		}
	}
	
	/*if ( $error == "" && $_FILES[ 'file_name' ][ 'error' ] != 4 )
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
	}*/
	
	for($i = 1; $i< 7; $i++)
	{
		if($error == "" && $_FILES['image_'.$i]['error'] != 4)
		{
			$image          = $_FILES['image_'.$i]['name'];
			$image_type     = $_FILES['image_'.$i]['type'];
			$image_size     = $_FILES['image_'.$i]['size'];
			$image_error    = $_FILES['image_'.$i]['error'];
			$image_tmp_name = $_FILES['image_'.$i]['tmp_name'];

			$image_val = image_validation($image, $image_type, $image_size, $image_error, $image_tmp_name);

			if($image_val['error'] == "")
			{
				//$var  = "image_".$i;
				${"image_".$i} = $image_val['image'];
			}
			else
			{
				$error = $image_val['error'];
			}
		}
		else if(${"rm_image_".$i} == 1){
			${"image_".$i} = "";
		}
		else{
			${"image_".$i} = ${"old_image_".$i};
		}
	}

	if($image_1 == "" && $image_2 == "" && $image_3 == "" && $image_4 == "" && $image_5 == "" && $image_6 == "" && $error == "")
	{
		$error = "Atleast one image is compulsory.";
	}
	
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
	
	if($error == "")
	{
		$query_1 = "SELECT id, sku_number, product_name FROM products WHERE app_id = $app_id AND (product_name = '$product_name' OR sku_number = '$sku_number') AND id != $item_id";
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = '2.'.$sww;
		}
		else if (mysqli_num_rows($result_1) > 0)
		{
			$row = mysqli_fetch_assoc($result_1);
			if($row['product_name'] == $product_name)
			{
				$error = "Product name already exists";
			}
			else if($row['sku_number'] == $sku_number)
			{
				$error = "SKU number already exists";
			}			
		}
	}
	
	if($error == "")
	{
		if($brand_id != "")
		{
			$quer_brand = "SELECT id, brand_name FROM brands WHERE id = $brand_id LIMIT 1";
			$res_brand = mysqli_query($link, $quer_brand);
			
			if($res_brand)
			{
				if(mysqli_num_rows($res_brand) > 0)
				{
					$row_brand = mysqli_fetch_assoc($res_brand);
					$brand_id = $row_brand['id'];
					$brand_name = $row_brand['brand_name'];
				}
			}
		}
		
		if(!isset($brand_name))
		{
			$quer_brand = "SELECT id, brand_name FROM brands WHERE brand_name = '-' LIMIT 1";
			$res_brand = mysqli_query($link, $quer_brand);
			
			if($res_brand)
			{
				if(mysqli_num_rows($res_brand) > 0)
				{
					$row_brand = mysqli_fetch_assoc($res_brand);
					$brand_id = $row_brand['id'];
					$brand_name = $row_brand['brand_name'];
				}
				else
				{
					$brand_name = '-';
					$quer_brand_2 = "INSERT INTO `brands`(`app_id`, `brand_name`, `file_name`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$brand_name', '', '$current_datetime', '$current_datetime', '1')";
					$res_brand_2 = mysqli_query($link, $quer_brand_2);
					$brand_id = mysqli_insert_id($link);
				}
			}
		}
	}
	
	if($error == "")
	{
		if($subcategory_id != "") { $category_id = $subcategory_id; }
		
		$img_array = [];
		for($i = 1; $i<7; $i++){
			if(${"image_".$i} != ""){
				$img_array[] =  ${"image_".$i};
			}
		}
		$file_name = implode(",", $img_array);

		$query_2 = "UPDATE `products` SET `privacy_type` = '$privacy_type', `category_id` = '$subcategory_id', `sku_number` = '$sku_number', `product_name` = '$product_name', `brand_id` = '$brand_id', `brand_name` = '$brand_name', `product_description` = '$product_description', `file_name` = '$file_name', `updated_at` = '$current_datetime', `status` = '$status' WHERE id = $item_id";
		
		//$query_2 .= "`product_name` = '$product_name', `file_name` = '$file_name', `status` = '$status', `updated_at` = '$current_datetime' WHERE id = $item_id AND app_id = $app_id";

		$result_2 = mysqli_query( $link, $query_2 );

		if($result_2)
		{
			/*if($file_name != "" && $file_name != $old_file_name)
			{
				if($old_file_name != "" && file_exists("../uploads/store-".$app_id."/products/" . $old_file_name))
				{
					unlink("../uploads/store-".$app_id."/products/" . $old_file_name);
				}
				//else { echo $old_file_name; exit; }
				move_uploaded_file($image_tmp_name, "../uploads/store-".$app_id."/products/" . $file_name);
			}

			if($rm_file_name == 1 && $old_file_name != "" && file_exists("../uploads/store-".$app_id."/products/".$old_file_name))
			{
				unlink( "../uploads/store-".$app_id."/products/".$old_file_name );
			}*/
			
			for($i = 1; $i<7; $i++)
			{
				if(${"image_".$i} != "" && ${"image_".$i} != ${"old_image_".$i})
				{
					if(${"old_image_".$i} != "" && file_exists("../uploads/store-".$app_id."/products/".${"old_image_".$i}))
					{
						unlink("../uploads/store-".$app_id."/products/".${"old_image_".$i});
					}
					move_uploaded_file($_FILES['image_'.$i]['tmp_name'], "../uploads/store-".$app_id."/products/".${"image_".$i});
				}
				if(${"rm_image_".$i} == 1 && ${"old_image_".$i} != "" && file_exists("../uploads/store-".$app_id."/products/".${"old_image_".$i}))
				{
					unlink("../uploads/store-".$app_id."/products/".${"old_image_".$i});
				}
			}

			$success = "Product details has been updated successfully";
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

	$query_3 = "SELECT * FROM `products` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
			
			$file_name = $row_3['file_name'];
			
			$images_exp = explode(",", $file_name);
            
            if(isset($images_exp[0])) {
                $image_1 = $images_exp[0];
            } else {
                $image_1 = "";
            }
            if(isset($images_exp[1])) {
                $image_2 = $images_exp[1];
            } else {
                $image_2 = "";
            }
            if(isset($images_exp[2])) {
                $image_3 = $images_exp[2];
            } else {
                $image_3 = "";
            }
            if(isset($images_exp[3])) {
                $image_4 = $images_exp[3];
            } else {
                $image_4 = "";
            }
            if(isset($images_exp[4])) {
                $image_5 = $images_exp[4];
            } else {
                $image_5 = "";
            }
            if(isset($images_exp[5])) {
                $image_6 = $images_exp[5];
            } else {
                $image_6 = "";
            }
			
			$cat_query = "SELECT id, parent_id FROM categories WHERE app_id = $app_id AND id = ".$row_3['category_id'];
			$cat_res = mysqli_query($link, $cat_query);
			$cat_row = mysqli_fetch_assoc($cat_res);
			$category_id = $cat_row['parent_id'];
		}
		else
		{
			$_SESSION['msg_error'] = "Product details does't found";
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
							<a href="products.php?id=<?php echo $row_3['category_id']; ?>">Products</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="products.php?id=<?php echo $row_3['category_id']; ?>" class="pl5 btn btn-default btn-sm">
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
											<select name="category_id" class="form-control" onChange="loadSubcategory(this.value)">
												<option value="0">Select Category</option>
												<?php 
												$query_cat = "SELECT id, category_name, parent_id FROM categories WHERE app_id = $app_id AND (parent_id IS NULL OR parent_id = 0) ORDER BY category_name";
												$res_cat = mysqli_query($link, $query_cat);
												while($row_cat = mysqli_fetch_assoc($res_cat))
												{
													echo '<option value="'.$row_cat['id'].'"';
													if(isset($_POST['category_id'])) {
														if($_POST['category_id'] == $row_cat['id']) {
															echo ' selected="selected"';
														}
													} else {
														//echo ' selected="selected"';
														if($category_id == $row_cat['id']) {
															echo ' selected="selected"';
														}
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
											<select name="subcategory_id" id="subcategory_id" class="form-control">
												<option value="0">Select Sub Category</option>
												<?php 
												$query_cat = "SELECT id, category_name, parent_id FROM categories WHERE app_id = $app_id AND parent_id = ".$category_id." ORDER BY category_name";
												$res_cat = mysqli_query($link, $query_cat);
												while($row_cat = mysqli_fetch_assoc($res_cat))
												{
													echo '<option value="'.$row_cat['id'].'"';
													if(isset($_POST['category_id'])) {
														if($_POST['category_id'] == $row_cat['id']) {
															echo ' selected="selected"';
														}
													} else {
														//echo ' selected="selected"';
														if($row_3['category_id'] == $row_cat['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row_cat['category_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Product Name*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="product_name" value="<?php if(isset($_POST['product_name'])) { echo $_POST['product_name'];} else { echo $row_3['product_name']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">SKU Number*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="sku_number" value="<?php if(isset($_POST['sku_number'])) { echo $_POST['sku_number'];} else { echo $row_3['sku_number']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Brand Name</label>
										<div class="col-lg-7">
											<select name="brand_id" id="brand_id" class="form-control">
												<option value="">Select Brand ...</option>
												<?php 
												$query_cat = "SELECT id, brand_name FROM brands WHERE app_id = $app_id ORDER BY brand_name";
												$res_cat = mysqli_query($link, $query_cat);
												while($row_cat = mysqli_fetch_assoc($res_cat)) {
													echo '<option value="'.$row_cat['id'].'"';
													if(isset($_POST['brand_id']) && $_POST['brand_id'] == $row_cat['id']) {
														echo ' selected="selected"';
													} else {
														//echo ' selected="selected"';
														if($row_3['brand_id'] == $row_cat['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row_cat['brand_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									
									<?php /*?><?php if($row_3['file_name'] != "" && file_exists("../uploads/store-".$app_id."/products/".$row_3['file_name'])){ ?>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-7">
											<img src="../uploads/store-<?php echo $app_id; ?>/products/<?php echo $row_3['file_name']; ?>" width="100px" class=""/>
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
									</div><?php */?>
									
									<?php 
                                    for($i = 1; $i< 7; $i++)
                                    {
                                        if(${"image_".$i} != "" && file_exists("../uploads/store-".$app_id."/products/".${"image_".$i})){
                                        ?>
                                        <div class="form-group">
                                            <div class="col-lg-offset-3 col-lg-7">
                                                <img src="../uploads/store-<?php echo $app_id; ?>/products/<?php echo ${"image_".$i}; ?>" width="100px" class=""/>
                                                <label class="checkbox-inline ml10 mr20 mt20">
                                                    <input type="checkbox" name="rm_image_<?php echo $i; ?>" value="1">Remove Image <?php echo $i; ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="inputStandard" class="col-lg-3 control-label">Image <?php echo $i; ?><?php if($i == 1) { echo "*";} ?></label>
                                            <div class="col-lg-7">
                                                <input type="file" class="form-control" name="image_<?php echo $i; ?>">
                                                <input type="hidden" name="old_image_<?php echo $i; ?>" value="<?php echo ${"image_".$i}; ?>">
                                                <span class="help-block mt5"><i class="fa fa-bell"></i> Recommended image resolution: 600x800; allowed formats: jpg, jpeg, png; max size: 2MB</span>
                                            </div>
                                        </div>
                                    
                                    <?php } ?>
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Description</label>
										<div class="col-lg-7">
											<textarea class="form-control" name="product_description" rows="10"><?php if(isset($_POST['product_description'])) { echo $_POST['product_description'];} else { echo $row_3['product_description']; } ?></textarea>
										</div>
									</div>
									<?php if($_SESSION['premium_normal_customer'] == 1) { ?>
									<div class="form-group">
										<label class="col-sm-3 control-label">Privacy Type</label>
										<div class="col-sm-7">
											<select name="privacy_type" class="form-control">
												<option value="0" <?php if(isset($_POST['privacy_type']) && $_POST['privacy_type'] == 0 ) { echo 'selected="selected"'; } else if($row_3['privacy_type'] == 0) { echo 'selected="selected"'; } ?>>Normal</option>
												<option value="1" <?php if(isset($_POST['privacy_type']) && $_POST['privacy_type'] == 1 ) { echo 'selected="selected"'; } else if($row_3['privacy_type'] == 1) { echo 'selected="selected"'; } ?>>Premium</option>
											</select>
										</div>
									</div>
									<?php } ?>
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
											<a href="products.php?id=<?php echo $row_3['category_id']; ?>" class="btn btn-warning">Cancel</a>
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
		
		function loadSubcategory(x)
		{
			$.ajax({
				url: 'ajax-general.php',
				data: 'type=2&main_cat='+x,
				type: 'POST',
				success: function(d){
					if(d == "1")
					{
						$("#subcategory_id").prop('disable', 'true');
					}
					else
					{
						$("#subcategory_id").prop('disable', 'false');
						$("#subcategory_id").html(d);
					}
				},
				error: function(){
					$("#subcategory_id").html('Something went wrong in selecting category');
				}	
			});
		}
	</script>
</body>
</html>