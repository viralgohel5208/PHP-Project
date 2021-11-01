<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Update Variant and Offer";

if(isset($_REQUEST['cid']) && isset($_REQUEST['id']))
{
	$category_id_main 	= $_REQUEST['cid'];
	$variant_id_main 	= $_REQUEST['id'];
	
	$result_2 = mysqli_query($link, "SELECT * FROM products_variant WHERE app_id = $app_id AND id = $variant_id_main");
	if(!$result_2)
	{
		header("Location:products.php"); exit;
	}
	else
	{
		if(mysqli_num_rows($result_2) == 0)
		{
			header("Location:products.php"); exit;
		}
		else
		{
			$row_3 = mysqli_fetch_assoc($result_2);
			
			$product_id_main 	= $row_3['product_id'];
			$measure_type 		= $row_3['measure_type'];
			$net_measure     	= $row_3['net_measure'];
			$price_raw     		= $row_3['price_raw'];
			$gst_percentage		= $row_3['gst_percentage'];
			$price_gst 			= $row_3['price_gst'];
			$price_finale 		= $row_3['price_finale'];

			$offer_type 		= $row_3['offer_type'];
			$offer_value 		= $row_3['offer_value'];
			$expires_at 		= $row_3['expires_at'];
			$offer_price 		= $row_3['offer_price'];
			$stock_amount 		= $row_3['stock_amount'];
			
			$category_id = 0;
			$product_id = 0;
			$variant_id = 0;
			
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

					//$offer_type = 0; $offer_value = ""; $expires_at = NULL;
				}
			}

		}
	}
}
else
{
	header("Location:products.php"); exit;
}

if(isset($_POST['submit']))
{
	//echo '<pre>'; print_r($_POST); exit;
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
		else if($offer_type == 2)
		{
			$offer_value = $product_id.','.$variant_id;
		}
		else
		{
			$offer_value = "";
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
		
		$query1 = "UPDATE `products_variant` SET `measure_type` = '$measure_type', `net_measure` = '$net_measure', `price_raw` = '$price_raw', `gst_percentage` = '$gst_percentage', `price_gst` = '$gst_price_2', `price_finale` = '$price', `offer_type` = '$offer_type', `offer_value` = '$offer_value', ";
		
		if($expires_at != "") {
			$query1 .= "`expires_at` = '$expires_at_2', ";
		} else {
			$query1 .= "`expires_at` = 'NULL', ";
		}
		
		$query1 .= "`offer_price` = '$offer_price', `stock_amount` = '$stock_amount', `updated_at` = '$current_datetime', `status` = '1' WHERE app_id = $app_id AND product_id = '$product_id_main' AND id = '$variant_id_main'";

		$result1 = mysqli_query($link, $query1);	

		if($result1)
		{
			$_SESSION['msg_success'] = "Details has been updated successfully";
			header("Location:products-variants.php?cid=$category_id_main&id=$product_id_main");
			exit;
		}
		else
		{
			$error = $sww;
		}
	}
}

if(isset($_POST['p_id']) && isset($_POST['v_id']))
{
	$id 	= escapeInputValue($_POST['p_id']);
	$id1 	= escapeInputValue($_POST['v_id']);
	
	$q = "delete from offers where product_id = '$id' and variation_id = '$id1'";

	$resul1 = mysqli_query($link, $q);
	if(!$resul1)
	{
		$_SESSION['msg']['error'] = $sww;
		header("location:products-update.php?product_id=$product_id&variation_id=$variation_id");
		exit;	
	}
	else
	{
		$_SESSION['msg']['success'] = 'Offer Has Been Deleted Successfully';
		header("location:products-update.php?product_id=$product_id&variation_id=$variation_id");
		exit;
	}
}

if(isset($_POST['delete_offer']))
{
	//echo 'here'; exit;
	$query8 = "UPDATE products_variant SET offer_type = 0, offer_value = '', expires_at = NULL WHERE id = '$variant_id_main' AND app_id = '$app_id'";

	$resul1 = mysqli_query($link, $query8);
	
	if(!$resul1) {
		$error = $sww;
	} else {
		$_SESSION['msg_success'] = 'Offer has been removed successfully';
		header("location:products-variants-update.php?cid=$category_id_main&id=$variant_id_main");
		exit;
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

            <!-- Begin: Content -->
            <section id="content">
                <div class="row">
                    <div class="col-sm-12">
						<?php require_once "message-block.php"; ?>
						
                        <div class="panel panel-dark">
                            <div class="panel-heading">
                                <span class="panel-title">Product Details</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post" action="">
									<div class="form-group" >
										<label class="col-lg-3 control-label">Row Price*</label>
										<div class="col-lg-7">
											<input type="text"  class="form-control" id="price_raw" name="price_raw" value="<?php if(isset($_POST['price_raw'])){ echo $_POST['price_raw']; } else { echo $price_raw; } ?>" onKeyUp="updatePriceGST(1)" onBlur="updatePriceGST(1)">
										</div>
									</div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">GST Percentage*</label>
                                        <div class="col-lg-7">
                                            <select class="form-control" id="gst_percentage" name="gst_percentage" onChange="updatePriceGST(2)" onBlur="updatePriceGST(2)">
												<?php $res_gst = mysqli_query($link, "SELECT * FROM gst_slabs ORDER BY id ASC");
												while($row_gst = mysqli_fetch_assoc($res_gst))
												{
													echo '<option value='.$row_gst['gst_percentage'];
													if(isset($_POST['gst_percentage']))
													{
														if($_POST['gst_percentage'] == $row_gst['gst_percentage'])
														{
															echo ' selected="selected"';
														}
													}
													else
													{
														if($gst_percentage == $row_gst['gst_percentage'])
														{
															echo ' selected="selected"';
														}
													}
													echo ' >';
													echo $row_gst['gst_percentage'].' %</option>';
												}
												?>
											</select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">GST Applied*</label>
                                        <div class="col-lg-7">
                                            <input type="text"  class="form-control" id="gst_price" name="gst_price" value="<?php if(isset($_POST['gst_price_2'])){ echo $_POST['gst_price_2']; } else { echo $price_gst; } ?>" disabled="disabled" onKeyUp="updatePriceGST(3)" onBlur="updatePriceGST(3)">
											<input type="hidden" id="gst_price_2" name="gst_price_2" value="<?php if(isset($_POST['gst_price_2'])){ echo $_POST['gst_price_2']; } else { echo $price_gst; } ?>">
                                        </div>
                                    </div>
                                    <div class="form-group" >
										<label class="col-lg-3 control-label">Price*</label>
										<div class="col-lg-7">
											<input type="text"  class="form-control" id="price" name="price" value="<?php if(isset($_POST['price'])){ echo $_POST['price']; } else { echo $price_finale; } ?>" onKeyUp="updatePriceGST(3)" onBlur="updatePriceGST(3)">
										</div>
									</div>
                                    
									<div class="form-group" id="net_measure">
										<label class="col-lg-3 control-label">Measure Type</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="measure_type" value="<?php if(isset($_POST['measure_type'])){ echo $_POST['measure_type']; } else { echo $measure_type; } ?>">
										</div>
									</div>

									<div class="form-group" id="net_measure">
										<label class="col-lg-3 control-label">Net Measure/Nos</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="net_measure" value="<?php if(isset($_POST['net_measure'])){ echo $_POST['net_measure']; } else { echo $net_measure; } ?>">
										</div>
									</div>

									<div class="form-group" id="approx">
										<label class="col-lg-3 control-label">In Stock Items</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="stock_amount" value="<?php if(isset($_POST['stock_amount'])){ echo $_POST['stock_amount']; } else { echo $stock_amount; } ?>">
										</div>
									</div>
									
									<!-- Product Variant Offer ------>
									<div  class="form-group">
										<label class="col-lg-3 control-label">
										<h4>Add Variant Offer (If Available)</h4>
										</label>
									</div>
									
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
												<option value="0">Select Category ...</option>
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
											<option value="">Select Products ...</option>
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
											<option value="">Select Variation ...</option>
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
											<input type="text" id="datetimepicker1" name="expires_at" class="form-control" placeholder="Select Expiry Date" value="">
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<?php if($offer_type != 0 ) { echo '<a onclick="delete_func('.$variant_id_main.')" class="btn btn-danger next-btn"> Remove Offer</a>'; } ?>
											<a href="products-update.php?id=<?php echo $item_id; ?>" class="btn btn-warning">Cancel</a>
										</div>
									</div>
								<!-------------- Product Variant Offers ------------------------>
                                </form>
                            </div>
                        </div>
                    </div>
				</div>
            </section>

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
			if(isset($_POST['expires_at'])) { echo "defaultDate: '".$_POST['expires_at']."',"; } else if($expires_at !=  NULL && $expires_at != "0000-00-00 00:00:00") { $ex_expires_at = explode(" ", $expires_at); $date_ex = explode("-", $ex_expires_at[0]); echo "defaultDate: '".$date_ex[2]."-".$date_ex[1]."-".$date_ex[0]."',"; } ?>
		});
	});
	</script>
</body>
</html>