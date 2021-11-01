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
			
			$variants = getProductVariants($app_id, $product_id, $customer_id = 0);
		}
	}
	$page_title = $row['product_name'];
}
else
{
	header("Location:categories.php"); exit;
}
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
								<div class="icon-sale-label sale-left">Sale</div>
								<div class="large-image"> <a href="images/products/img01.jpg" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="zoom-img" src="images/products/img01.jpg" alt="products"> </a> </div>
								<div class="flexslider flexslider-thumb">
									<ul class="previews-list slides">
										<li><a href='images/products/img01.jpg' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: 'images/products/img01.jpg' "><img src="images/products/img01.jpg" alt = "Thumbnail 2"/></a>
										</li>
										<li><a href='images/products/img07.jpg' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: 'images/products/img07.jpg' "><img src="images/products/img07.jpg" alt = "Thumbnail 1"/></a>
										</li>
										<li><a href='images/products/img02.jpg' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: 'images/products/img02.jpg' "><img src="images/products/img02.jpg" alt = "Thumbnail 1"/></a>
										</li>
										<li><a href='images/products/img03.jpg' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: 'images/products/img03.jpg' "><img src="images/products/img03.jpg" alt = "Thumbnail 2"/></a>
										</li>
										<li><a href='images/products/img04.jpg' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: 'images/products/img04.jpg' "><img src="images/products/img04.jpg" alt = "Thumbnail 2"/></a>
										</li>
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
										<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $329.99 </span> </p>
										<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $359.99 </span> </p>
									</div>
									<div class="ratings">
										<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
										<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Your Review</a> </p>
										<p class="availability in-stock pull-right">Availability: <span id="stock_string">In Stock</span>
										</p>
									</div>
									<div class="short-description">
										<h2>Quick Overview</h2>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum.
											<p> Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer enim purus, posuere at ultricies eu, placerat a felis. Suspendisse aliquet urna pretium eros convallis interdum. Quisque in arcu id dui vulputate mollis eget non arcu. Aenean et nulla purus. Mauris vel tellus non nunc mattis lobortis.</p>

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
												<div class="numbers-row">
													<div onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i>
													</div>
													<input type="text" class="qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
													<div onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i>
													</div>
												</div>
											</div>
										</form>
									</div>
									<div class="product-cart-option">
										
<div class="col-lg-2">
<div class="input-group">
<span class="input-group-btn" style="width: 0%;">
<button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="" id="minus" onClick="clicksub(<?php echo $product_id;?>)">
<span class="glyphicon glyphicon-minus"></span>
</button>
</span>
<?php 
$result12 = mysqli_query($link,"select id from product_price where product_id = '$product_id' limit 1");
$row12 = mysqli_fetch_assoc($result12);

$v_id = $row12['id'];
if(!empty($_SESSION['cart'][$product_id.'-'.$v_id]))
{
$quantity = $_SESSION['cart'][$product_id.'-'.$v_id]['quantity'];
?>
<!--<input type="text" id="quantity<?php //echo $products['id'];?>" name="quantity" class="form-control input-number" value="<?php //echo $quantity;?>" min="0" max="100">-->
<p name="quantity" id="quantity" class="form-control" style="margin:0;"><?php echo $quantity;?></p>

<?php }else if(!empty($_SESSION['logged_in']) && !empty($_SESSION['user_id'])){ 


$result13 = mysqli_query($link,"select quantity from cart where product_id = '$product_id' and variation_id = '$v_id'");
if(mysqli_num_rows($result13) > 0)
{ ?>
<p name="quantity" id="quantity" class="form-control" style="margin:0;"><?php echo $quantity;?></p>
<?php } else {
$row13 = mysqli_fetch_assoc($result13);
$quantity = $row13['quantity'];
?>
<p name="quantity" id="quantity" class="form-control" style="margin:0;">0</p>
<?php } ?>


<?php }	else{
?>
<!-- <input type="text" id="quantity<?php //echo $products['id'];?>" name="quantity" class="form-control input-number" value="0" min="0" max="100">-->
<p name="quantity" id="quantity" class="form-control" style="margin:0;">0</p>

<?php } ?>
<span class="input-group-btn" style="width: 0%;">
<button type="button" class="quantity-right-plus btn btn-danger btn-number" data-type="plus" data-field="" id="plus" onClick="clickadd(<?php echo $product_id;?>)">
<span class="glyphicon glyphicon-plus"></span>
</button>
</span>
</div>
</div>

										<button class="button pro-add-to-cart" title="Add to Cart" type="button"><span><i class="fa fa-shopping-cart"></i> Add to Cart</span></button>
										<button class="button pro-add-to-cart" title="Add to Wishlist" type="button"><span><i class="fa fa-heart"></i> Add to Wishlist</span></button>
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
												<p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt.</p>
												<p> Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer enim purus, posuere at ultricies eu, placerat a felis. Suspendisse aliquet urna pretium eros convallis interdum. Quisque in arcu id dui vulputate mollis eget non arcu. Aenean et nulla purus. Mauris vel tellus non nunc mattis lobortis.</p>
												<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat vestibulum, metus nisi posuere nisl, in accumsan elit odio quis mi. Cras neque metus, consequat et blandit et, luctus a nunc. Etiam gravida vehicula tellus, in imperdiet ligula euismod eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>
											</div>
										</div>

										<div id="reviews" class="tab-pane fade">
											<div class="col-sm-5 col-lg-5 col-md-5">
												<div class="reviews-content-left">
													<h2>Customer Reviews</h2>
													<div class="review-ratting">
														<p><a href="#">Amazing</a> Review by Company</p>
														<table>
															<tbody>
																<tr>
																	<th>Price</th>
																	<td>
																		<div class="rating">
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>Value</th>
																	<td>
																		<div class="rating">
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>Quality</th>
																	<td>
																		<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
																	</td>
																</tr>
															</tbody>
														</table>
														<p class="author">
															Angela Mack<small> (Posted on 16/12/2015)</small>
														</p>
													</div>


													<div class="review-ratting">
														<p><a href="#">Good!!!!!</a> Review by Company</p>
														<table>
															<tbody>
																<tr>
																	<th>Price</th>
																	<td>
																		<div class="rating">
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>Value</th>
																	<td>
																		<div class="rating">
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>Quality</th>
																	<td>
																		<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
																	</td>
																</tr>
															</tbody>
														</table>
														<p class="author">
															Lifestyle<small> (Posted on 20/12/2015)</small>
														</p>
													</div>


													<div class="review-ratting">
														<p><a href="#">Excellent</a> Review by Company</p>
														<table>
															<tbody>
																<tr>
																	<th>Price</th>
																	<td>
																		<div class="rating">
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>Value</th>
																	<td>
																		<div class="rating">
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star"></i>
																			<i class="fa fa-star-o"></i>
																			<i class="fa fa-star-o"></i>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>Quality</th>
																	<td>
																		<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
																	</td>
																</tr>
															</tbody>
														</table>
														<p class="author">
															Jone Deo<small> (Posted on 25/12/2015)</small>
														</p>
													</div>

												</div>
											</div>
											<div class="col-sm-7 col-lg-7 col-md-7">
												<div class="reviews-content-right">
													<h2>Write Your Own Review</h2>
													<form>
														<div class="form-area">
															<div class="form-element">
																<label>Nickname <em>*</em></label>
																<input type="text">
															</div>
															<div class="form-element">
																<label>Summary of Your Review <em>*</em></label>
																<input type="text">
															</div>
															<div class="form-element">
																<label>Review <em>*</em></label>
																<textarea></textarea>
															</div>
															<div class="buttons-set">
																<button class="button submit" title="Submit Review" type="submit"><span><i class="fa fa-thumbs-up"></i> &nbsp;Review</span></button>
															</div>
														</div>
													</form>
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
	function clickadd(val)
	{
   				
	var val1 = $("#variation").val();
				var quantity = parseInt($('#quantity').text());
		var bag = parseInt($('#bag').val());
		
		
				if(bag == 0)
					{
						var bag = 1;
						var bag = bag+' '+'Items';
					}
		else
			{
				var bag = bag + 1;
				var bag = bag+' '+'Items';
			}
				
				

		
		
		
		$('#bag').val(bag);
     			var val2 = quantity + 1;
		 		
			
		$('#quantity').html(val2);
	
	$.ajax({
	type: "POST",
	url: "add_cart.php",
	data:'product_id='+val+'&variation_id='+val1+'&quantity='+val2,
	success: function(data){
		
		
	},
		error: function(){
			alert("sdfsdfsdf");
		}
	});
		
	


        
    
	}
		
		function clicksub(val){

   
   
		
		var val1 = $("#variation").val();
				var quantity = parseInt($('#quantity').text());
		var bag = parseInt($('#bag').val());
		
				if(quantity > 0 && bag > 0)
				
					{
						var bag = bag - 1;
				var bag = bag+' '+'Items';
					}
		else
			{
				var bag = bag+' '+'Items';
			}
		
		
				

		
		
		
		$('#bag').val(bag);
		if(quantity > 0)
			{
				var val2 = quantity - 1;
				
				$('#quantity').html(val2);
	
	$.ajax({
	type: "POST",
	url: "add_cart.php",
	data:'product_id='+val+'&variation_id='+val1+'&quantity='+val2,
	success: function(data){
		
		
	},
		error: function(){
			alert("sdfsdfsdf");
		}
	});
		
			}
     			
		 		
			
		
		
    
	}
	</script>
</body>
</html>