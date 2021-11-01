<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
//require_once "login-required.php";

$page_title = "Products";

if(isset($_GET['pro']))
{
	$product_id = safe_decode($_GET['pro']);
	
	$query = "SELECT * FROM products WHERE app_id = $app_id AND id = $product_id LIMIT 1";
	
	$result = mysqli_query($link, $query);
	
	if(!$result)
	{
		header("Location:categories.php"); exit;
	}
	else
	{
		if(mysqli_num_rows($result) == 0)
		{
			header("Location:categories.php"); exit;
		}
		else
		{
			$row = mysqli_fetch_assoc($result);
			$sub_category_id = $row['category_id'];
			$sub_category_details = getAppCategoriesDetails($app_id, $sub_category_id);
			$main_category_id = $sub_category_details['parent_id'];
			$main_category_details = getAppCategoriesDetails($app_id, $main_category_id);
			//echo $customer_id;
			$variants = getProductVariants($app_id, $product_id, $customer_id);
			
			$product_name 	= $row['product_name'];
			$file_name_str 		= $row['file_name'];
			$total_star_count 		= $row['total_star_count'];
			$total_star_customers 	= $row['total_star_customers'];
			$created_at 	= $row['created_at'];
			
			$file_name_arr = getFileImageArray($app_id, 2, $file_name_str);
		}
	}
	$page_title = $row['product_name'];
}
else
{
	header("Location:categories.php"); exit;
}

//echo '<pre>'; print_r($row); print_r($variants); exit;

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo $page_title." - ".$application_name; ?></title>
	<meta name="description" content="">
	<meta name="keywords" content=""/>

	<!-- Mobile specific metas  -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php require_once "include/general-css.php"; ?>

	<!-- owl.carousel CSS -->
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="css/owl.theme.css">

	<!-- flexslider CSS -->
	<link rel="stylesheet" type="text/css" href="css/flexslider.css">

	<!-- animate CSS  -->
	<link rel="stylesheet" type="text/css" href="css/animate.css" media="all">

	<!-- jquery-ui.min CSS  -->
	<link rel="stylesheet" href="css/jquery-ui.css">

	<!-- main CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css" media="all">

	<!-- style CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/custom.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/css-stars.css" >
</head>

<body class="product-page">
	
	<!-- mobile menu -->
	<?php require_once "include/header-mobile-menu.php"; ?>
	<!-- end mobile menu -->
	
	<div id="page">
		
		<!-- Header -->
		<?php require_once "include/header-top.php"; ?>
		<!-- end header -->

		<!-- Navbar -->
		<?php require_once "include/header-navbar.php"; ?>
		<!-- end nav -->
		
		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<ul>
							<li class="home"> <a title="Go to Home Page" href="index.php">Home</a><span>&raquo;</span></li>
							<li class=""> <a title="<?php echo $main_category_details['category_name']; ?>" href="categories.php">Categories</a><span>&raquo;</span></li>
							<li class=""> <a title="<?php echo $main_category_details['category_name']; ?>" href="categories.php?cat=<?php echo $main_category_id; ?>"><?php echo $main_category_details['category_name']; ?></a><span>&raquo;</span></li>
							<li class=""> <a title="<?php echo $sub_category_details['category_name']; ?>" href="products-list.php?cat=<?php echo $sub_category_id; ?>"><?php echo $sub_category_details['category_name']; ?></a><span>&raquo;</span></li>
							<li class="category13"><strong><?php echo $row['product_name']; ?></strong>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->
		
		<!-- Main Container -->
		<div class="main-container col1-layout">
			<div class="container">
				<div class="row">
					<div class="col-main">
						<div class="product-view-area">
							<div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
								<?php $i = 0; foreach($variants as $item) {
								if($item['offer_type'] > 0 && $item['expires_at'] > $current_datetime) { echo '<div class="icon-sale-label sale-left" id="offer_string_'.$product_id.'_'.$item['id'].'"';
								if($i > 0) { echo 'style="display:none"'; }
								echo '>Offer</div>'; }
								$i++; }
								//<div class="icon-sale-label sale-left">Sale</div>
								?>
								
								<div class="large-image"> <a href="<?php echo $file_name_arr[0]; ?>" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="zoom-img" src="<?php echo $file_name_arr[0]; ?>" alt="<?php echo $row['product_name']; ?>"> </a> </div>
								<div class="flexslider flexslider-thumb">
									<ul class="previews-list slides">
										<?php 
										foreach($file_name_arr as $item)
										{
											echo '<li><a href=\''.$item.'\' class=\'cloud-zoom-gallery\' rel="useZoom: \'zoom1\', smallImage: \''.$item.'\' "><img src="'.$item.'" alt = "Thumbnail 2"/></a></li>';
										}
										?>
									</ul>
								</div>
								<!-- end: more-images -->
							</div>
							<div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
								<div class="product-details-area">
									<div class="product-name">
										<h1><?php echo $row['product_name']; ?></h1>
									</div>
									<div class="price-box">
										<?php /*$i =0; foreach($variants as $item) {
										$variant_id = $item['id'];
										echo '<p class="special-price"> <span class="price" id="price_'.$product_id.'_'.$variant_id.'"';
										if($i > 0) { echo 'style="display:none"'; }
										echo '>₹ '.$item['price_finale'].'</span> </p>';
										$i++;
										}*/
										?>
										<?php $i =0; foreach($variants as $item) {
										$variant_id = $item['id'];
										$price_finale = $item['price_finale'];
										$offer_type = $item['offer_type'];
										$expires_at = $item['expires_at'];
										$offer_price = $item['offer_price'];
	
	if($offer_type == 1 && ($expires_at == NULL || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime))
	{
		$sale_price = $offer_price;
		$old_price = $price_finale;
	}
	else
	{
		$sale_price = $old_price = $price_finale;
	}

	echo '<div id="price_'.$product_id.'_'.$variant_id.'" ';
	if($i > 0) { echo 'style="display:none"'; }
	echo '>';
	echo '<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> ₹ '.$sale_price.' </span> </p>';
	if($sale_price != $old_price) {
	echo '<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> ₹ '.$old_price.' </span> </p>';
	}
	echo '</div>';
										$i++;
										}
										?>
									</div>
									<div class="ratings">
										<?php /*?><div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div><?php */?>
										
										<?php echo displayStarRating($total_star_count, $total_star_customers); ?>
										
										<p class="rating-links"> <a href="#"><?php echo $total_star_customers; ?> Review(s)</a> <span class="separator">|</span> <a href="#">Add Your Review</a> </p>
										<?php $i = 0; foreach($variants as $item) {
										$variant_id = $item['id'];
										$stock_amount = $item['stock_amount']; //echo $i;
if($stock_amount > 0)
{
	echo '<p class="availability in-stock pull-right" id="stock_string_'.$product_id.'_'.$variant_id.'"';
	if($i > 0) { echo ' style="display:none;"'; }
	echo '>Availability: <span>In Stock</span></p>';
}
else
{
	echo '<p class="availability in-stock pull-right" id="stock_string_'.$product_id.'_'.$variant_id.'"';
	if($i > 0) { echo ' style="display:none;"'; }
	echo '>Availability: <span style="background-color:#f44336;">Out Of Stock</span></p>';
}
										$i++; }
										?>
									</div>
									<div class="short-description">
										<h2>Quick Overview</h2>
										<p><?php echo stringCut($row['product_description']); ?></p>

									</div>
									<div class="product-color-size-area">
										<div class="color-area">
											<h2 class="saider-bar-title">Select Variant</h2>
											<div class="color">
												<select class="cust_select_box_2" onChange="dispVarPrice(<?php echo $product_id; ?>, this.value)">
													<?php foreach($variants as $item) {
														echo '<option value="'.$item['id'].'" ';
														//echo 'selected="selected"';
														echo ' id="var_'.$product_id.'_'.$item['id'].'"';
														echo ' ';
														echo '>'.$item['net_measure'].' '.$item['measure_type'].'</option>';
													} ?>
												</select>
											</div>
										</div>
										
										<?php /*?><div class="color-area">
											<h2 class="saider-bar-title">Color</h2>
											<div class="color">
												<ul>
													<li><a href="#"></a>
													</li>
													<li><a href="#"></a>
													</li>
													<li><a href="#"></a>
													</li>
													<li><a href="#"></a>
													</li>
													<li><a href="#"></a>
													</li>
													<li><a href="#"></a>
													</li>
												</ul>
											</div>
										</div>
										<div class="size-area">
											<h2 class="saider-bar-title">Size</h2>
											<div class="size">
												<ul>
													<li><a href="#">S</a>
													</li>
													<li><a href="#">L</a>
													</li>
													<li><a href="#">M</a>
													</li>
													<li><a href="#">XL</a>
													</li>
													<li><a href="#">XXL</a>
													</li>
												</ul>
											</div>
										</div><?php */?>
										
									</div>
									<div class="product-variation">
										<form action="#" method="post">
											<div class="cart-plus-minus">
												<label for="qty">Quantity:</label>
												
													
<?php $i =0; foreach($variants as $item) { $variant_id = $item['id'];
										  
if(isset($item['cart_quantity']) && $item['cart_quantity'] > 0) {
	$cart_quantity = $item['cart_quantity'];
} else {
	$cart_quantity = 1;
}
echo '<div class="numbers-row" id="quantity_div_'.$product_id.'_'.$variant_id.'"';
if($i > 0) { echo 'style="display:none"'; }
echo '>';
echo '<div class="dec qtybutton sub_qty"><i class="fa fa-minus">&nbsp;</i>
													</div>';
echo '<input type="text" class="qty" title="Qunatity" value="'.$cart_quantity.'" maxlength="10" id="quantity_'.$variant_id.'" name="quantity" onBlur="checkQty(this)" ';
echo '>';
										  
echo '<div class="inc qtybutton add_qty"><i class="fa fa-plus">&nbsp;</i>
													</div>';
										  echo '</div>';
$i++; } ?>
											</div>
										</form>
									</div>
									<div class="product-cart-option">
										<?php $i =0; foreach($variants as $item) {
$variant_id 	= $item['id'];
$stock_amount 	= $item['stock_amount'];
	
if(isset($item['cart_quantity']) && $item['cart_quantity'] > 0)
{
	$cart_string = "Remove from Cart";
	$cart_quantity = $item['cart_quantity'];
	$flag = 0; // Remove from cart
}
else
{
	$cart_string = "Add to Cart";
	$cart_quantity = 1;
	$flag = 1; // Add cart
}

$disabled = ""; $style = ""; if($stock_amount == 0) { $disabled = ' disabled="disabled"'; $style = ' background:#9E9E9E; border: 2px solid #667372; cursor: no-drop;'; }
	
if(isset($item['wishlist']) && $item['wishlist'] == FALSE) { $wishlist_flag = "1"; $heart_string = "Add to Wishlist"; }
else { $wishlist_flag = "0"; $heart_string = "Remove from Wishlist"; }

//echo '<input type="hidden" id="quantity_'.$variant_id.'" value="'.$cart_quantity.'" />';
echo '<input type="hidden" id="flag_'.$variant_id.'" value="'.$flag.'" />';
echo '<input type="hidden" id="wishlist_flag_'.$variant_id.'" value="'.$wishlist_flag.'" />';

echo '<button class="button pro-add-to-cart" onClick="customerCart('.$product_id.', '.$variant_id.')" type="button" id="cart_link_'.$product_id.'_'.$variant_id.'" '.$disabled.' style="';
if($i > 0) { echo 'display:none;'; }

echo $style.'">
	<span><i class="fa fa-shopping-cart"></i><span id="cart_string_'.$product_id.'_'.$item['id'].'"> '.$cart_string.'</span>
</button>';
	
echo '<button class="button pro-add-to-cart" onClick="customerWishlist('.$product_id.', '.$variant_id.')" type="button" id="wishlist_icon2_'.$product_id.'_'.$variant_id.'" style="margin-left:20px; ';
if($i > 0) { echo 'display:none'; }
echo '">
	<span><i class="fa fa-heart"></i><span id="wish_str_'.$product_id.'_'.$variant_id.'"> '.$heart_string.'</span>
</button>';

$i++;
}
										?>
										<?php /*?><button class="button pro-add-to-cart" title="Add to Cart" type="button"><span><i class="fa fa-shopping-cart"></i> Add to Cart</span></button>
										<button class="button pro-add-to-cart" title="Add to Wishlist" type="button"><span><i class="fa fa-heart"></i> Add to Wishlist</span></button><?php */?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="product-overview-tab wow fadeInUp">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<ul id="product-detail-tab" class="nav nav-tabs product-tabs">
										<li class="active"> <a href="#description" data-toggle="tab"> Description </a></li>
										<li> <a href="#reviews" data-toggle="tab">Reviews</a></li>
									</ul>
									<div id="productTabContent" class="tab-content">
										<div class="tab-pane fade in active" id="description">
											<div class="std">
												<p><?php echo $row['product_description']; ?></p>
											</div>
										</div>

										<div id="reviews" class="tab-pane fade">
											<div class="col-md-12">
												<h4>Customer Reviews</h4>
												<ul class="comments" id="display_review" style="height: 250px; overflow-y: scroll">
													<?php $reviews = getProductReviews($app_id, $product_id, 20);
													foreach($reviews as $item) { 
													?>
													<li>
														<div class="clearfix">
															<p class="pull-left"><strong><a href="javascript:void(0);"><?php echo $item['first_name'].' '.$item['last_name']; ?></a></strong></p>
															<div class="pull-right rating-box clearfix" style="margin-right: 20px;">
																<?php echo displayStarRating($item['star_rating'], 1); ?>
															</div>
															<br />
														</div>
														<p><?php if($item['comment_details'] != "") { echo $item['comment_details']; } else { echo "No Comments"; } echo " - ".$item['updated_at']; ?></p>
													</li>
													<?php  } ?>
												</ul>
												<hr>
											</div>
											
											<div class="col-md-12 col-lg-12 col-md-12" id="review_div">
												<div class="reviews-content-right">
													<h2>Write Your Own Review</h2>
													<?php if(!isset($_SESSION['cu_login'])) {
													$_SESSION['prev_page'] = $full_url;
													echo '<h3 style="margin-bottom:10px;">Please login to review</h3>';
													echo '<a href="login.php" style=" text-decoration:underline; color:red"> LOGIN</a>';
													} else { ?>
													<form id="review_form" onSubmit="SubmitReview();return false;">
														<div class="form-area">
															<div class="form-element">
																<label>Your Rating <em>*</em></label>
																<div class="pull-left rating-box clearfix">
																	<select id="example-css" name="rating">
																		<option value="1">1</option>
																		<option value="2">2</option>
																		<option value="3">3</option>
																		<option value="4">4</option>
																		<option value="5">5</option>
																	</select>
																	<input type="hidden" name="review_star" id="review_star" value="5">
																	<input type="hidden" name="pd" id="" value="<?php echo $product_id; ?>">
																</div>
																<div class="clearfix"></div>
															</div>
															<div class="form-element">
																<label>Review <em>*</em></label>
																<textarea name="comment_details" id="comment_details" style="width: 100%"></textarea>
															</div>
															<div class="buttons-set">
																<button class="button submit" title="Submit Review" type="submit"><span><i class="fa fa-thumbs-up"></i> &nbsp;Submit Your Review</span></button>
															</div>
														</div>
													</form>
													<?php  } ?>
												</div>
											</div>
											
											<div class="col-md-12 col-lg-12 col-md-12" id="thank_review" style="display:none">
												<div class="reviews-content-right">
													<h2>Your Review</h2>
													<p id="thank_p"></p>
													<div class="clearfix">
														<label class="pull-left rating-box-label">Your Rating:</label>
														<div class="pull-left rating-box clearfix" id="thank_rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Main Container End -->

		<!-- Upsell Product Slider -->
		<section class="upsell-product-area">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-header-wrapper">
							<div class="container">
								<div class="page-header text-center wow fadeInUp">
									<h2>UpSell <span class="text-main">Products</span></h2>
									<div class="divider divider-icon divider-md">&#x268A;&#x268A; &#x2756; &#x268A;&#x268A;</div>

								</div>
							</div>
						</div>

						<div class="slider-items-products">
							<div id="upsell-product-slider" class="product-flexslider hidden-buttons">
								<div class="slider-items slider-width-col4">
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="icon-sale-label sale-left">Sale</div>
												<div class="icon-new-label new-right">New</div>
												<div class="pr-img-area"> <img class="first-img" src="images/products/img01.jpg" alt=""> <img class="hover-img" src="images/products/img01.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img02.jpg" alt=""> <img class="hover-img" src="images/products/img02.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box">
																<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $456.00 </span> </p>
																<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $567.00 </span> </p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img03.jpg" alt=""> <img class="hover-img" src="images/products/img03.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box">
																<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $456.00 </span> </p>
																<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $567.00 </span> </p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="icon-sale-label sale-left">Sale</div>
											<div class="icon-new-label new-right">New</div>
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img04.jpg" alt=""> <img class="hover-img" src="images/products/img04.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="icon-new-label new-left">New</div>
												<div class="pr-img-area"> <img class="first-img" src="images/products/img05.jpg" alt=""> <img class="hover-img" src="images/products/img05.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box">
																<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $456.00 </span> </p>
																<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $567.00 </span> </p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img06.jpg" alt=""> <img class="hover-img" src="images/products/img06.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<!-- Upsell Product Slider End -->

		<!-- Related Product Slider -->
		<section class="related-product-area">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-header-wrapper">
							<div class="container">
								<div class="page-header text-center wow fadeInUp">
									<h2>Related <span class="text-main">Products</span></h2>
									<div class="divider divider-icon divider-md">&#x268A;&#x268A; &#x2756; &#x268A;&#x268A;</div>

								</div>
							</div>
						</div>

						<div class="slider-items-products">
							<div id="related-product-slider" class="product-flexslider hidden-buttons">
								<div class="slider-items slider-width-col4 fadeInUp">
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="icon-sale-label sale-left">Sale</div>
												<div class="icon-new-label new-right">New</div>
												<div class="pr-img-area"> <img class="first-img" src="images/products/img19.jpg" alt=""> <img class="hover-img" src="images/products/img19.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="icon-sale-label sale-left">Sale</div>
												<div class="pr-img-area"> <img class="first-img" src="images/products/img20.jpg" alt=""> <img class="hover-img" src="images/products/img20.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box">
																<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $456.00 </span> </p>
																<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $567.00 </span> </p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img03.jpg" alt=""> <img class="hover-img" src="images/products/img03.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box">
																<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $456.00 </span> </p>
																<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $567.00 </span> </p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img04.jpg" alt=""> <img class="hover-img" src="images/products/img04.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>

											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img05.jpg" alt=""> <img class="hover-img" src="images/products/img05.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box">
																<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $456.00 </span> </p>
																<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $567.00 </span> </p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product-item">
										<div class="item-inner fadeInUp">
											<div class="product-thumbnail">
												<div class="pr-img-area"> <img class="first-img" src="images/products/img06.jpg" alt=""> <img class="hover-img" src="images/products/img06.jpg" alt="">
													<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
												</div>
												<div class="pr-info-area">
													<div class="pr-button">
														<div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
														<div class="mt-button add_to_compare"> <a href="compare.html"> <i class="fa fa-signal"></i> </a> </div>
														<div class="mt-button quick-view"> <a href="quick_view.html"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="Ipsums Dolors Untra" href="products-details.php">Ipsums Dolors Untra </a> </div>
													<div class="item-content">
														<div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<!-- Related Product Slider End -->
		
		<!-- Footer -->
		<?php require_once "include/footer-main.php"; ?>		
		<!-- end Footer -->
		
		<a href="#" class="totop"> </a>
	</div>

	<!-- End Footer -->
	<!-- JS -->

	<!-- jquery js -->
	<script type="text/javascript" src="js/jquery.min.js"></script>

	<!-- bootstrap js -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<!-- owl.carousel.min js -->
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>

	<!-- bxslider js -->
	<script type="text/javascript" src="js/jquery.bxslider.js"></script>

	<!-- flexslider js -->
	<script type="text/javascript" src="js/jquery.flexslider.js"></script>

	<!--jquery-slider js -->
	<?php /*?><script type="text/javascript" src="js/slider.html"></script><?php */?>

	<!--cloud-zoom js -->
	<script type="text/javascript" src="js/cloud-zoom.js"></script>

	<!-- megamenu js -->
	<script type="text/javascript" src="js/megamenu.js"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
		var mega_menu = '0';

		/* ]]> */
	</script>

	<!-- jquery.mobile-menu js -->
	<script type="text/javascript" src="js/mobile-menu.js"></script>

	<!-- jquery.waypoints js -->
	<script type="text/javascript" src="js/waypoints.js"></script>

	<!--jquery-ui.min js -->
	<script src="js/jquery-ui.js"></script>

	<!-- main js -->
	<script type="text/javascript" src="js/main.js"></script>
	
	<script>
		
	function dispVarPrice(product_id, var_id)
	{
		//alert('price_'+product_id+'_'+var_id+'');
		$('[id^="price_'+product_id+'"]').css('display', 'none');
		$('#price_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="cart_link_'+product_id+'"]').css('display', 'none');
		$('#cart_link_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="wishlist_icon2_'+product_id+'"]').css('display', 'none');
		$('#wishlist_icon2_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="offer_string_'+product_id+'"]').css('display', 'none');
		$('#offer_string_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="stock_string_'+product_id+'"]').css('display', 'none');
		$('#stock_string_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="quantity_div_'+product_id+'"]').css('display', 'none');
		$('#quantity_div_'+product_id+'_'+var_id+'').css('display', 'block');
	}
		
	function customerCart(product_id, variant_id)
	{
		<?php if(!isset($_SESSION['cu_customer_id'])) { $_SESSION['prev_page'] = $full_url; echo 'window.location.href="login.php";'; } ?>
		
		//var product_id = parseInt($('#product_id').val());
		//var variant_id = parseInt($('#variant_id').val());
		var quantity = parseInt($('#quantity_'+variant_id).val());
		var flag = parseInt($('#flag_'+variant_id).val());
		
		//alert(product_id+' - '+variant_id+' - '+quantity+' - '+flag);
		$.ajax({
			type: "POST",
			url: "functions-ajax-cart.php",
			data:'type=1&product_id='+product_id+'&variant_id='+variant_id+'&quantity='+quantity+'&flag='+flag,
			success: function(data){
				//alert(data);
				eval(data);
			},
			error: function(){
				alert("sww");
			}
		});
	}
		
	function customerWishlist(product_id, variant_id)
	{
		<?php if(!isset($_SESSION['cu_customer_id'])) { $_SESSION['prev_page'] = $full_url; echo 'window.location.href="login.php";'; } ?>
		
		var flag = parseInt($('#wishlist_flag_'+variant_id).val());
		
		//alert(product_id+' - '+variant_id+' - '+quantity+' - '+flag);
		$.ajax({
			type: "POST",
			url: "functions-ajax-cart.php",
			data:'type=2&product_id='+product_id+'&variant_id='+variant_id+'&flag='+flag,
			success: function(data){
				//alert(data);
				eval(data);
			},
			error: function(){
				alert("sww");
			}
		});
	}

	function checkQty(x)
	{
		val_x = x.value;
		val_x = parseInt(val_x);
		if(val_x < 1) { x.value = 1; }
	}
		
	$('.add_qty').click(function () {
		if ($(this).prev().val() < 10) {
		$(this).prev().val(+$(this).prev().val() + 1);
		}
	});
	$('.sub_qty').click(function () {
		if ($(this).next().val() > 1) {
		if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
		}
	});

	</script>
	
	<script src="js/jquery.barrating.js"></script>
	<script type="text/javascript">
	
	$(function () {
        $('#example-css').barrating({
            theme: 'css-stars',
            initialRating: 5,
            readonly:false,
            onSelect: function (value, text) {
                starRatting(value, text);
            }
        });
    });
    function starRatting(value, text)
    {
        //alert('Selected rating: ' + value + ' :' + text);
        $("#review_star").val(value);
    }
		
	function SubmitReview()
	{
		var value_text = $("#comment_details").val();
		
		if(value_text == "")
		{
			alert("Please enter review comments");
		}
		else
		{
			$.ajax({
				type:'POST',
				data:$("#review_form").serialize(),
				url:"ajax-submit-review.php",
				success: function(data){
					if(data == 1){
						alert("Thank you for your valuable review");
						$("#review_div").css("display", "none");
						$("#thank_p").html($("#comment_details").val());
						var rating = $("#review_star").val();
						var pr = "";
						for(var i = 1; i<6; i++)
						{
							if(rating >= i)
							{
								pr += '<i class="fa fa-star"></i>';	
							}
							else
							{
								pr += '<i class="fa fa-star-o"></i>';
							}
						}
						$("#thank_rating").html(pr);
						$("#thank_review").css("display", "block");
					}
					else
					{
						alert(data);
					}
				},
				error: function(){
					alert("Something went wrong, Please try again later");
				}

			});
		}
	}
</script>
	
</body>
</html>