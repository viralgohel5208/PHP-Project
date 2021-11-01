<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$app_id 	= $_SESSION['app_id'];
$item_id 	= escapeInputValue($_GET[ 'id' ]);

if(isset($_POST['submit']))
{
	$offer_type 		= escapeInputValue($_POST['offer_type']);
	$discount 			= escapeInputValue($_POST['discount']);
	$category_id 		= escapeInputValue($_POST['category_id']);
	$subcategory_id		= escapeInputValue($_POST['subcategory_id']);
	$product_id 		= escapeInputValue($_POST['product_id']);
	$variant_id 		= escapeInputValue($_POST['variant_id']);
	$expires_at			= escapeInputValue($_POST['expires_at']);
	
	$expires_at_1 		= date_create($expires_at);
	$expires_at_2		= date_format($expires_at_1, 'Y-m-d H:i:s');
	
	if($offer_type == 0)
	{
		$error = "Please select all fields";
	}
	else if($offer_type == 1)
	{
		if($discount == "" || $discount == 0)
		{
			$error = "Please enter valid discount percentage";
		}
		else if(!is_numeric($discount))
		{
			$error = "Please enter valid discount percentage";
		}
	}
	else if($offer_type == 2)
	{
		if($category_id == '' || $subcategory_id == '' || $product_id == '' || $variant_id == "")
		{
			$error = "Please select all fields";
		}
	}
	
	if($error == "")
	{
		if($offer_type == 1)
		{
			$offer_value = $discount;
		}
		else
		{
			$offer_value = $product_id.','.$variant_id;
		}
		
		$query8 = "UPDATE products SET offer_type = $offer_type, offer_value = '$offer_value', ";
		
		if($expires_at != "") {
			$query8 .= "expires_at = '$expires_at_2'";
		} else {
			$query8 .= "expires_at = NULL";
		}
		
		$query8 .= " WHERE id = '$item_id' AND app_id = '$app_id'";
		
		$result8 = mysqli_query($link, $query8);

		if(!$result8)
		{
			$error = "1. ".$sww;
		}
		else
		{
			$_SESSION['msg_success'] = "Offer has been updated successfully";
			header("location:products-offers.php?id=$item_id");
			exit;
		}
		
	}
}

//echo '<pre>'; print_r($_POST); exit;
if(isset($_POST['delete_offer']))
{
	//echo 'here'; exit;
	$query8 = "UPDATE products SET offer_type = 0, offer_value = '', expires_at = NULL WHERE id = '$item_id' AND app_id = '$app_id'";

	$resul1 = mysqli_query($link, $query8);
	
	if(!$resul1) {
		$error = $sww;
	} else {
		$_SESSION['msg_success'] = 'Offer has been removed successfully';
		header("location:products-offers.php?id=$item_id");
		exit;
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT id, category_id, product_name, offer_type, offer_value, expires_at FROM `products` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
			
			$product_name = $row_3['product_name'];
			$pro_category_id = $row_3['category_id'];
			
			/*$cat_query = "SELECT id, parent_id FROM categories WHERE app_id = $app_id AND id = ".$row_3['category_id'];
			$cat_res = mysqli_query($link, $cat_query);
			$cat_row = mysqli_fetch_assoc($cat_res);
			$category_id = $cat_row['parent_id'];*/
			$category_id = 0;
			$product_id = 0;
			$variant_id = 0;
			
			$offer_type 	= $row_3['offer_type'];
			$offer_value 	= $row_3['offer_value'];
			$expires_at 	= $row_3['expires_at'];
			
			if($offer_type == 2)
			{
				$ex_offer_value = explode(",", $offer_value);
				$product_id = $ex_offer_value[0];
				$variant_id = $ex_offer_value[1];
				
				$pro_query = "SELECT id, category_id FROM products WHERE app_id = $app_id AND id = ".$product_id;
				$pro_res = mysqli_query($link, $pro_query);
				$pro_row = mysqli_fetch_assoc($pro_res);
				$subcategory_id = $pro_row['category_id'];
				
				$cat_query = "SELECT id, parent_id FROM categories WHERE app_id = $app_id AND id = ".$subcategory_id;
				$cat_res = mysqli_query($link, $cat_query);
				$cat_row = mysqli_fetch_assoc($cat_res);
				$category_id = $cat_row['parent_id'];
			}
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

$page_title = "Product Offers - ".$product_name;

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
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
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
							<a href="products.php?id=<?php echo $pro_category_id; ?>">Products</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				
				<div class="topbar-right">
					<div class="ml15 ib va-m">
						<a href="products-update.php?id=<?php echo $row_3['id']; ?>" class="pl5 btn btn-default btn-sm">
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
								<form class="form-horizontal" role="form" method="post">
									<div  class="form-group">
										<label class="col-lg-3 control-label">Choose Offer Type</label>
										<div class="col-lg-7">
											<select name="offer_type" class="form-control" id="offer_type" onChange="setDiscountOfferType(this.value);">
												<option value="0">Select</option>
												<option value="1" <?php if($offer_type == 1) { echo 'selected'; } ?>>Off Percentage</option>
												<option value="2" <?php if($offer_type == 2) { echo 'selected'; } ?>>Free Product</option>
											</select>
										</div>
									</div>

									<div class="form-group" id="discount3" style="<?php if($offer_type == '2' || $offer_type == '0') { echo 'display:none'; } ?>">
										<label class="col-lg-3 control-label">Discount ( % )</label>
										<div class="col-lg-7">
											<input type="text" name="discount" class="form-control" value="<?php echo $offer_value;?>">
										</div>
									</div>
									
									<div class="form-group" id="categorylist3" style="<?php if($offer_type == '1' || $offer_type == '0') { echo 'display:none'; } ?>">
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
									
									<div class="form-group" id="subcategorylist3" style="<?php if($offer_type == '1' || $offer_type == '0') { echo 'display:none'; } ?>">
										<label class="col-lg-3 control-label">Sub Category</label>
										<div class="col-lg-7">
											<select name="subcategory_id" id="subcategory_id" class="form-control" onChange="getProducts(this.value);">
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
														if($subcategory_id == $row_cat['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row_cat['category_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
                         
									<div class="form-group" id="product_list3" style="<?php if($offer_type == '1' || $offer_type == '0') { echo 'display:none'; } ?>">
										<label class="col-lg-3 control-label">Choose Product</label>
										<div class="col-lg-7">
											<select name="product_id" id="product-list" class="form-control" onChange="getVariants(this.value);">
											<option value="">Select Products</option>
											<?php 
											$query_cat = "SELECT id, product_name FROM products WHERE app_id = $app_id AND category_id = $subcategory_id ORDER BY product_name";
											$res_cat = mysqli_query($link, $query_cat);
											while($row_cat = mysqli_fetch_assoc($res_cat))
											{
												echo '<option value="'.$row_cat['id'].'"';
												if(isset($_POST['product_id'])) {
													if($_POST['product_id'] == $row_cat['id']) {
														echo ' selected="selected"';
													}
												} else {
													if($product_id == $row_cat['id']) {
														echo ' selected="selected"';
													}
												}
												echo '>'.$row_cat['product_name'].'</option>';
											}
											?>
											</select>
										</div>
									</div>
                          
									<div class="form-group" id="variant-list3" style="<?php if($offer_type == '1' || $offer_type == '0') { echo 'display:none'; }?>">
										<label class="col-lg-3 control-label">Choose Variation</label>
										<div class="col-lg-7">
											<select name="variant_id" id="variant-list" class="form-control">
											<option value="">Select Variation</option>
											<?php 
											$query_cat = "SELECT id, measure_type, net_measure, price_finale FROM products_variant WHERE app_id = $app_id AND product_id = $product_id ORDER BY measure_type, net_measure, price_finale";
											$res_cat = mysqli_query($link, $query_cat);
											while($row_cat = mysqli_fetch_assoc($res_cat))
											{
												echo '<option value="'.$row_cat['id'].'"';
												if(isset($_POST['variant_id'])) {
													if($_POST['variant_id'] == $row_cat['id']) {
														echo ' selected="selected"';
													}
												} else {
													if($variant_id == $row_cat['id']) {
														echo ' selected="selected"';
													}
												}
												echo '>'.$row_cat['net_measure'].' '.$row_cat['measure_type'].' (Rs. '.$row_cat['price_finale'].')</option>';
											}
											?>
											</select>
										</div>
									</div>
                         
									<div class="form-group">
										<label class="col-lg-3 control-label">Choose Expiry Date</label>
										<div class="col-lg-7">
											<input type="text" id="datetimepicker1" name="expires_at" class="form-control" placeholder="Select Expiry Date" value="<?php if($expires_at != '') { echo $expires_at; } else { echo ''; } ?>">
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<?php if($offer_type != 0 ) { echo '<a onclick="delete_func('.$item_id.')" class="btn btn-danger next-btn"> Remove Offer</a>'; } ?>
											<a href="products-update.php?id=<?php echo $item_id; ?>" class="btn btn-warning">Cancel</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<form id="delete_form" action="" method="post" style="display: hidden">
			<input type="hidden" id="delete_offer" name="delete_offer" value="">
		</form>

	</div>

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="vendor/plugins/moment/moment.min.js"></script>

	<script src="vendor/plugins/datepicker/js/bootstrap-datetimepicker.js"></script>
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
			
			$('#datetimepicker1').datetimepicker({
				pickTime: false,
				//minDate: '<?php echo date("d-m-Y"); ?>',
				format: 'DD-MM-YYYY',
				<?php //	if(isset($_POST['expires_at'])) { echo "defaultDate: new Date()"; }
				if(isset($_POST['expires_at'])) { echo "defaultDate: '".$_POST['expires_at']."',"; }?>
			});
		});
	</script>
</body>
</html>