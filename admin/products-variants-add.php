<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Add Variant and Offer";

if(isset($_REQUEST['cid']) && isset($_REQUEST['id']))
{
	$category_id_main = $_REQUEST['cid'];
	$product_id_main = $_REQUEST['id'];
	
	$res = mysqli_query($link, "SELECT category_id, product_name FROM products WHERE app_id = $app_id AND category_id = $category_id_main AND id = $product_id_main");
	if(!$res)
	{
		header("Location:products.php"); exit;
	}
	else
	{
		if(mysqli_num_rows($res) == 0)
		{
			header("Location:products.php"); exit;
		}
		else
		{
			$row = mysqli_fetch_assoc($res);
			$category_id_main = $row['category_id'];
			$product_name = $row['product_name'];
			
			$offer_type = 0; $offer_value = ""; $expires_at = NULL;
		}
	}
}
else
{
	header("Location:products.php"); exit;
}

if(isset($_POST['save']))
{
    $price_raw			= escapeInputValue($_POST['price_raw']);
    $gst_percentage		= escapeInputValue($_POST['gst_percentage']);
    $gst_price_2		= escapeInputValue($_POST['gst_price_2']);
    $price 				= escapeInputValue($_POST['price']);
	$measure_type 		= escapeInputValue($_POST['measure_type']);
	$net_measure 		= escapeInputValue($_POST['net_measure']);
	$stock_amount 		= escapeInputValue($_POST['stock_amount']);
	
	$offer_type 		= escapeInputValue($_POST['offer_type']);
	$discount 			= escapeInputValue($_POST['discount']);
	$category_id 		= escapeInputValue($_POST['category_id']);
	$subcategory_id		= escapeInputValue($_POST['subcategory_id']);
	$product_id 		= escapeInputValue($_POST['product_id']);
	$variant_id 		= escapeInputValue($_POST['variant_id']);
	$expires_at			= escapeInputValue($_POST['expires_at']);
	
	$expires_at_1 		= date_create($expires_at);
	$expires_at_2		= date_format($expires_at_1, 'Y-m-d H:i:s');
	
	if($price_raw == "" || $gst_percentage == "" || $gst_price_2 == "" || $price == "")
	{
		$error = "Please enter mandatory details";
	}
	if(!is_numeric($price_raw))
	{
		$error = "Please enter valid row price";
	}
	else if(!is_numeric($gst_percentage))
	{
		$error = "Please enter valid GST percentage";
	}
	else if(!is_numeric($gst_price_2))
	{
		$error = "Please enter valid GST price";
	}
	else if(!is_numeric($price))
	{
		$error = "Please enter valid finale price";
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
	}
	
	if($error == "")
	{
		$price_raw 		= decimalNumberFormat($price_raw);
		$gst_percentage = decimalNumberFormat($gst_percentage);
		$gst_price_2 	= decimalNumberFormat($gst_price_2);
		$price 			= decimalNumberFormat($price);
		// echo $error; exit;
		
		$offer_price = $price;
		
		if($offer_type == 1 && $offer_value != 0)
		{
			if($expires_at_2 == "" || $expires_at_2 == "0000-00-00 00:00:00" || $expires_at_2 > $current_datetime)
			{
				$discount_amount = (($price * $offer_value) / 100);
				$offer_price = $price - $discount_amount;
			}
		}
		
		$query1 = "INSERT INTO `products_variant`(`app_id`, `product_id`, `measure_type`, `net_measure`, `price_raw`, `gst_percentage`, `price_gst`, `price_finale`, `offer_type`, `offer_value`, `expires_at`, `offer_price`, `stock_amount`, `created_at`, `updated_at`, `status`) VALUES ( $app_id, $product_id_main, '$measure_type', '$net_measure', '$price_raw', '$gst_percentage', '$gst_price_2', '$price', '$offer_type', '$offer_value', ";
		
		if($expires_at != "") {
			$query1 .= "'$expires_at_2', ";
		} else {
			$query1 .= "NULL, ";
		}
		
		$query1 .= "'$offer_price', '$stock_amount', '$current_datetime', '$current_datetime', 1)";

		$result1 = mysqli_query($link, $query1);	

		if(!$result1)
		{
			$error = "1. ".$sww;
		}
		else
		{
			$_SESSION['msg_success'] = "Variants has been added successfully";
			header("Location:products-variants.php?cid=$category_id_main&id=$product_id_main"); exit;
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
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
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
						<li class="crumb-link">
							<a href="products.php?id=<?php echo $category_id_main; ?>">Products</a>
						</li>
						<li class="crumb-link">
							<a href="products-variants.php?cid=<?php echo $category_id_main; ?>&id=<?php echo $product_id_main; ?>">Variants</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="products-variants.php?cid=<?php echo $category_id_main; ?>&id=<?php echo $product_id_main; ?>" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>
			</header>

            <section id="content">
                <div class="row">
                    <div class="col-sm-12">
						<?php require_once "message-block.php"; ?>
                        <div class="panel <?php echo $panel_style; ?>">
                            <div class="panel-heading">
                                <span class="panel-title"><span class="fa fa-plus"></span><?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post" action="">
                                    
									<div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">Row Price*</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" id="price_raw" name="price_raw" value="" onKeyUp="updatePriceGST(1)" onBlur="updatePriceGST(1)">
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">GST Percentage*</label>
                                        <div class="col-lg-7">
                                            <select class="form-control" id="gst_percentage" name="gst_percentage" onChange="updatePriceGST(2)" onBlur="updatePriceGST(2)">
												<?php $res_gst = mysqli_query($link, "SELECT * FROM gst_slabs ORDER BY id ASC");
												while($row_gst = mysqli_fetch_assoc($res_gst))
												{
													echo '<option value='.$row_gst['gst_percentage'].'>'.$row_gst['gst_percentage'].' %</option>';
												}
												?>
											</select>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">GST Applied*</label>
                                        <div class="col-lg-7">
                                            <input type="text"  class="form-control" id="gst_price" name="gst_price" value="0" disabled="disabled" onKeyUp="updatePriceGST(3)" onBlur="updatePriceGST(3)">
											<input type="hidden" id="gst_price_2" name="gst_price_2" value="0">
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">Price*</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" id="price" name="price" value="" autocomplete="off" onKeyUp="updatePriceGST(4)" onBlur="updatePriceGST(4)">
                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                		<label for="inputStandard" class="col-lg-3 control-label">Measure Type</label>
                                		<div class="col-lg-7">
                                			<input type="text" class="form-control" name="measure_type" value="" autocomplete="off">
										</div>
									</div>
                              
                              		<div class="form-group">
                                		<label for="inputStandard" class="col-lg-3 control-label">Net Measure/Nos</label>
                                		<div class="col-lg-7">
                                			<input type="text" class="form-control" name="net_measure" value="" autocomplete="off">
										</div>
									</div>
                              
                              		<div class="form-group">
                                		<label for="inputStandard" class="col-lg-3 control-label">In Stock Items</label>
                                		<div class="col-lg-7">
                                			<input type="text" class="form-control" name="stock_amount" value="">
										</div>
									</div>
									
									<div  class="form-group">
										<label class="col-lg-3 control-label">
										<h4>Add Variant Offer (If Available)</h4>
										</label>
									</div>
									<div  class="form-group">
										<label class="col-lg-3 control-label">Choose Offer Type</label>
										<div class="col-lg-7">
											<select name="offer_type" class="form-control" id="offer_type" onChange="setDiscountOfferType(this.value);">
												<option value="0">Select Type ...</option>
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
												<option value="0">Select Category  ...</option>
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
													} /*else {
														//echo ' selected="selected"';
														if($category_id == $row_cat['id']) {
															echo ' selected="selected"';
														}
													}*/
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
												<option value="0">Select Sub Category ...</option>
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
													}/* else {
														if($subcategory_id == $row_cat['id']) {
															echo ' selected="selected"';
														}
													}*/
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
											<option value="">Select Product ...</option>
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
										<label class="col-lg-3 control-label">Choose Variant</label>
										<div class="col-lg-7">
											<select name="variant_id" id="variant-list" class="form-control">
											<option value="">Select Variant ...</option>
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
                                        <div class="col-lg-offset-3 col-lg-8 mt20">
                                            <button type="submit" name="save" class="btn btn-success">Save</button>
                                            <a href="products-variants.php?cid=<?php echo $category_id_main;?>&id=<?php echo $product_id_main;?>" class="btn btn-warning">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>        
            </section>
        </section>
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
        jQuery(document).ready(function() {
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