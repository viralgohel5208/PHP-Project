<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "Products";

/*if(isset($_REQUEST['search']))
{
	echo '<pre>';
	print_r($_REQUEST);
	exit;
}*/

if(isset($_GET['cat']))
{
	$type = "sub";
	$category_id = safe_decode($_GET['cat']);
	$category_details = getAppCategoriesDetails($app_id, $category_id);
	$main_category_id = $category_details['parent_id'];
	$main_category_details = getAppCategoriesDetails($app_id, $main_category_id);
	
	if(!$category_details)
	{
		//echo 'Not found'; exit;
		header("Location:categories.php");
		exit;
	}
	else
	{
		$limit = 18;
		
		$products = [];
		
		$page_title = $category_details['category_name']. " - Products";
		
		if(isset($_SESSION['cu_customer_id'])) {
			$customer_id 	= $_SESSION['cu_customer_id'];
		} else {
			$customer_id = 0;
		}
		
		if(isset($_REQUEST['product_name'])) {
			$product_name 	= escapeInputValue($_REQUEST['product_name']);
		} else {
			$product_name = "";
		}
		
		if(isset($_REQUEST['brand_name'])) {
			$brand_name 	= escapeInputValue($_REQUEST['brand_name']);
		} else {
			$brand_name = "";
		}
		
		if(isset($_REQUEST['min_price'])) {
			$min_price 	= escapeInputValue($_REQUEST['min_price']);
		} else {
			$min_price = 0;
		}
		
		if(isset($_REQUEST['max_price'])) {
			$max_price 	= escapeInputValue($_REQUEST['max_price']);
		} else {
			$max_price = 0;
		}
		
		//Sort = 1 : Price Lowest to high, 2 : Price highest to low
		if(isset($_REQUEST['sort'])) {
			$sort 	= escapeInputValue($_REQUEST['sort']);
		} else {
			$sort = 1;
		}
		
		$sql_where_str = "";

		$sql_array = ["p.app_id = $app_id"];
		$sql_array[] = " p.category_id = '$category_id' ";
		
		if($product_name != "")
		{
			$sql_array[] = " p.product_name LIKE '$product_name%' ";
		}
		if($brand_name != "")
		{
			$sql_array[] = " p.brand_name = '$brand_name' ";
		}
		if($min_price != "" && $min_price != 0)
		{
			$sql_array[] = " p.price_finale >= '$min_price' ";
		}
		if($max_price != "" && $max_price != 0)
		{
			$sql_array[] = " p.price_finale <= '$max_price' ";
		}

		$sql_str = implode(" AND ", $sql_array);

		if($sql_str != "")
		{
			$sql_where_str = " WHERE ".$sql_str;
		}		
		
		//*** 	Pagination Satrt  **********//
		
		$sql_p = mysqli_query($link, "SELECT p.id as pid FROM products p JOIN (SELECT v2.product_id, v2.measure_type, v2.net_measure, v2.price_raw, v2.gst_percentage, v2.price_gst, v2.price_finale FROM products_variant v2 JOIN (SELECT product_id, MIN(price_finale) as price_finale FROM products_variant GROUP BY product_id ) v1 USING (product_id, price_finale) ) v3 ON p.id = v3.product_id $sql_where_str");
		
		
		//$limit = 1;
		//echo '<pre>'; print_r($_GET); echo '</pre>';
		$get_vars = $_GET;
		if(isset($get_vars['page'])) { unset($get_vars['page']); }

		$query_string = [];
		foreach ($get_vars as $key => $value) {
			$query_string[] = $key.'='.$value;
		}

		$query_string = implode("&", $query_string);
		//echo '<pre>'; print_r($get_vars); echo '</pre>';
		$targetpage = $current_url."?".$query_string."&page=";
		//echo targetpage;
		//exit;
		//$targetpage = "photos.php?page="; //your file name
		
		$total = mysqli_num_rows($sql_p);

		if(isset($_GET['page']))
		{ 
			$page = $_GET['page'];
			$start = ($page - 1) * $limit; //first item to display on this page
		}
		else
		{
			$start = 0;
			$page = 0;
		}
		$counter = 0;
		/* Setup page vars for display. */
		if ($page == 0) $page = 1; //if no page var is given, default to 1.
		$prev = $page - 1; //previous page is current page - 1
		$next = $page + 1; //next page is current page + 1
		$lastpage = ceil($total/$limit); //lastpage.
		$lpm1 = $lastpage - 1; //last page minus 1

		//*** 	Pagination End  **********//
		
		$pro_query = "SELECT DISTINCT(p.id), p.category_id, p.sku_number, p.brand_name, p.product_name, p.file_name, v3.measure_type, v3.net_measure, v3.price_raw, v3.gst_percentage, v3.price_gst, v3.price_finale, p.total_star_count, p.total_star_customers, p.created_at FROM products p JOIN (SELECT v2.product_id, v2.measure_type, v2.net_measure, v2.price_raw, v2.gst_percentage, v2.price_gst, v2.price_finale FROM products_variant v2 JOIN (SELECT product_id, MIN(price_finale) as price_finale FROM products_variant GROUP BY product_id ) v1 USING (product_id, price_finale) ) v3 ON p.id = v3.product_id $sql_where_str";
		
		if($sort == 1) {
			$pro_query .= " ORDER BY price_finale ASC";
		} else if($sort == 2) {
			$pro_query .= " ORDER BY price_finale DESC";
		}
		$pro_query .= " LIMIT $start, $limit";

		//echo $pro_query;

		$result = mysqli_query($link, $pro_query);

		if(!$result)
		{
			//$error_code = 3; $error_string = $sww;
			echo 'Something went wrong. Please try again later.';
			exit;
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
				//$error_code = 4; $error_string = 'No products found';
			}
			else
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$product_id = $row['id'];

					$file_name_array = $row['file_name'];
					if($file_name_array == "")
					{
						$images = [$website_url.'/assets/images/default/default.png'];
					}
					else
					{
						$images = [];
						$ex_file_name = explode(",", $file_name_array);
						foreach($ex_file_name as $fn)
						{
							if($fn != "" && file_exists("uploads/store-".$app_id."/products/".$fn))
							{
								$images[] = $website_url."/uploads/store-".$app_id."/products/".$fn;
							}
						}

						if(empty($images))
						{
							$images = [$website_url.'/assets/images/default/default.png'];
						}
					}

					//$row['file_name'] = getFileImageArray($app_id, 2, $row['file_name']);

					$row['file_name'] = $images;

					// Fetch Variants Details
					$variants = getProductVariants($app_id, $product_id, $customer_id);
					$row['variants'] = $variants;

					$products[] = $row;
				}
			}
		}
	}
}
else
{
	header("Location:categories.php");
	exit;
}

//echo '<pre>'; print_r($products); exit;

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

	<!-- animate CSS  -->
	<link rel="stylesheet" type="text/css" href="css/animate.css" media="all">

	<!-- jquery-ui.min CSS  -->
	<link rel="stylesheet" href="css/jquery-ui.css">

	<!-- main CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css" media="all">

	<!-- style CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/custom.css" media="all">
	
	<style>
		
	</style>
</head>

<body class="shop_grid_page">
	
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
							<li class=""> <a title="Categories" href="categories.php">Categories</a><span>&raquo;</span></li>
							<li class=""> <a title="Sub Categories" href="categories.php?cat=<?php echo $main_category_details['id']; ?>"><?php echo $main_category_details['category_name']; ?> </a><span>&raquo;</span></li>
							<li class="category13"><strong><?php echo $category_details['category_name']; ?></strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->
		
		<!-- Main Container -->
		<div class="main-container col2-left-layout">
			<div class="container">
				<div class="row">
					<aside class="left sidebar col-sm-3 col-xs-12">
						<div class="category-sidebar">
							<div class="sidebar-title">
								<h3>Categories</h3>
							</div>
							<ul class="product-categories">
								<?php 
								$categories = getAppCategories($app_id); 
								foreach($categories as $key => $item) { 
									
								// Check current category products
								$cat_ids = [$item['id']];
								foreach($item['sub_menu'] as $sub_item) { $cat_ids[] = $sub_item['id']; }
									
								?>
								<li class="cat-item <?php if(in_array($category_id, $cat_ids)) { echo 'current-cat'; } ?> cat-parent"><a href="#products-list.php?cat=<?php echo $item['id'] ?>"><?php echo $item['category_name']; ?></a>
									<?php foreach($item['sub_menu'] as $sub_item) { ?>
									<ul class="children">
										<li class="cat-item"><a href="products-list.php?cat=<?php echo $sub_item['id'] ?>"><i class="fa fa-angle-right"></i>&nbsp; <?php echo $sub_item['category_name']; ?></a> </li>
									</ul>
									<?php } ?>
								</li>
								<?php } ?>
							</ul>
						</div>
						
						<?php /*?><div class="product-price-range wow fadeInUp">
							<div class="sidebar-bar-title">
								<h3>Price</h3>
							</div>
							<div class="block-content">
								<div class="slider-range">
									<div data-label-reasult="Range:" data-min="0" data-max="500" data-unit="$" class="slider-range-price" data-value-min="50" data-value-max="350"></div>
									<div class="amount-range-price">Range: $10 - $550</div>
									<ul class="check-box-list">
										<li>
											<input type="checkbox" id="p1" name="cc"/>
											<label for="p1"> <span class="button"></span> $20 - $50<span class="count">(0)</span> </label>
										</li>
										<li>
											<input type="checkbox" id="p2" name="cc"/>
											<label for="p2"> <span class="button"></span> $50 - $100<span class="count">(0)</span> </label>
										</li>
										<li>
											<input type="checkbox" id="p3" name="cc"/>
											<label for="p3"> <span class="button"></span> $100 - $250<span class="count">(0)</span> </label>
										</li>
									</ul>
								</div>
							</div>
						</div><?php */?>
						
						<?php /*?><div class="single-img-add sidebar-add-slider wow fadeInUp">
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<!-- Indicators -->
								<ol class="carousel-indicators">
									<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
									<li data-target="#carousel-example-generic" data-slide-to="1"></li>
									<li data-target="#carousel-example-generic" data-slide-to="2"></li>
								</ol>

								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox">
									<div class="item active"> <img src="images/add-slide1.jpg" alt="slide1">
										<div class="carousel-caption">
											<h3><a href="products-details.php" title=" Sample Product">Sale Up to 50% off</a></h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
											<a href="#" class="info">shopping Now</a> </div>
									</div>
									<div class="item"> <img src="images/add-slide2.jpg" alt="slide2">
										<div class="carousel-caption">
											<h3><a href="products-details.php" title=" Sample Product">Smartwatch Collection</a></h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
											<a href="#" class="info">All Collection</a> </div>
									</div>
									<div class="item"> <img src="images/add-slide3.jpg" alt="slide3">
										<div class="carousel-caption">
											<h3><a href="products-details.php" title=" Sample Product">Summer Sale</a></h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
										</div>
									</div>
								</div>

								<!-- Controls -->
								<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
						</div><?php */?>
						
					</aside>
					<div class="col-main col-sm-9">
						<div class="page-title">
							<h2><?php echo $category_details['category_name']; ?></h2>
						</div>
						<?php /*?><div class="category-description std">
							<div class="slider-items-products">
								<div id="category-desc-slider" class="product-flexslider hidden-buttons">
									<div class="slider-items slider-width-col1 owl-carousel owl-theme">
										<!-- Item -->
										<div class="item"> <a href="#x"><img alt="" src="images/cat-slider-img1.jpg"></a>
											<div class="inner-info">
												<div class="cat-img-title">
													<span>Fashion Current Sale Item</span>
													<h2 class="cat-heading"><strong>UP TO 50% OFF</strong></h2>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
													<a class="info" href="#">shop Now</a>
												</div>
											</div>
										</div>
										<!-- End Item -->

										<!-- Item -->
										<div class="item"> <a href="#x"><img alt="" src="images/cat-slider-img2.jpg"></a> </div>

										<!-- End Item -->

									</div>
								</div>
							</div>
						</div><?php */?>
						<div class="toolbar">
							<?php /*?><div class="view-mode">
								<ul>
									<li class="active"> <a href="shop_grid.html"> <i class="fa fa-th-large"></i> </a> </li>
									<li> <a href="shop_list.html"> <i class="fa fa-th-list"></i> </a> </li>
								</ul>
							</div><?php */?>
							<div class="sorter">
								<div class="short-by">
									<label>Sort By:</label>
									<select name="sort" style="width: auto;" onChange="sortByType(this.value);" >
										<option <?php if($sort == 1) { echo 'selected="selected"'; } ?> value="1">Price - Low to High</option>
										<option <?php if($sort == 2) { echo 'selected="selected"'; } ?> value="2">Price - High to Low</option>
									</select>
								</div>
								<?php /*?><div class="short-by page">
									<label>Show:</label>
									<select>
										<option selected="selected">8</option>
										<option>12</option>
										<option>16</option>
										<option>30</option>
									</select>
								</div><?php */?>
							</div>
						</div>
						<div class="product-grid-area">
							<?php $count_products = count($products); if($count_products == 0) { 
echo '<h3 style="margin-top:150px; text-align:center">No products found</h3>';
} else { ?>
							<ul class="products-grid">
								<!--------- Products List Start ------------>
								<?php $i = 1; 
								foreach($products as $item) { 
								$product_id 	= $item['id'];
								$product_name 	= $item['product_name'];
								$file_name 		= $item['file_name'][0];
								$measure_type 	= $item['measure_type'];
								$measure_type 	= $item['measure_type'];
								$price_finale 	= $item['price_finale'];
								$regular_price = $price_finale;
								//$offer_price 	= $item['offer_price'];
	
								/*if($offer_price != 0 && $offer_price < $price_finale)
								{
									$has_offer = TRUE;
									$regular_price = $offer_price;
									$old_price = $price_finale;
								}
								else
								{
									$has_offer = FALSE;
									$old_price = $regular_price = $price_finale;
								}*/
	
								$total_star_count 		= $item['total_star_count'];
								$total_star_customers 	= $item['total_star_customers'];
								$created_at 	= $item['created_at'];
	
								$variants 		= $item['variants'];
								$variants_count = count($variants);
								?>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<?php $i = 0; foreach($variants as $item) {
												if($item['offer_type'] > 0 && $item['expires_at'] > $current_datetime) { echo '<div class="icon-sale-label sale-left" id="offer_string_'.$product_id.'_'.$item['id'].'"';
												if($i > 0) { echo 'style="display:none"'; }
												echo '>Offer</div>'; }
												$i++; }
												?>
												<?php if($created_at >= $days_5_date) { ?><div class="icon-new-label new-right">New</div><?php } ?>
												<div class="pr-img-area">
													<a href="products-details.php?pro=<?php echo safe_encode($product_id); ?>">
														<figure>
															<img class="first-img" src="<?php echo $file_name; ?>" alt="">
															<?php /*?><img class="hover-img" src="<?php echo $file_name; ?>" alt=""><?php */?>
														</figure>
														<?php $i = 0; foreach($variants as $item) {
														if(isset($item['cart_quantity']) && $item['cart_quantity'] > 0) { $cart_string = "Remove from Cart"; }
									else { $cart_string = "Add to Cart"; }
														echo '<a onClick="customerCart('.$product_id.', '.$item['id'].')" type="button" class="add-to-cart-mt cursor_pointer" id="cart_link_'.$product_id.'_'.$item['id'].'"';
														if($i > 0) { echo 'style="display:none"'; }
														echo '>
															<i class="fa fa-shopping-cart"></i><span id="cart_string_'.$product_id.'_'.$item['id'].'"> '.$cart_string.'</span>
														</a>'; $i++;
														} ?>
													</a>
												</div>
												<div class="pr-info-area">
													<div class="pr-button" style="left: 60%">
														<div class="mt-button">
														<?php $i = 0; foreach($variants as $item) {
														if(isset($item['wishlist']) && $item['wishlist'] == 1) { $heart_string = "fa-heart"; }
									else { $heart_string = "fa-heart-o"; }
														echo '<a class="cursor_pointer" onClick="customerWishlist('.$product_id.', '.$item['id'].')" id="wishlist_icon_'.$product_id.'_'.$item['id'].'"';
														if($i > 0) { echo ' style="display:none"'; }
														echo ' > <i class="fa '.$heart_string.'"></i> </a>';
														$i++; }
														?>
														</div>
														<div class="mt-button"> <a href="products-details.php?pro=<?php echo safe_encode($product_id); ?>"> <i class="fa fa-search"></i> </a> </div>
													</div>
												</div>
											</div>
											<div class="item-info">
												<div class="info-inner">
													<div class="item-title"> <a title="<?php echo $product_name; ?>" href="products-details.php?pro=<?php echo safe_encode($product_id); ?>"><?php echo $product_name; ?> </a> </div>
													<div class="item-content">
														<?php echo displayStarRating($total_star_count, $total_star_customers); ?>
														<?php 
														if($variants_count == 1) {									
														echo '<div class="mt5">'.$variants[0]['net_measure'].' '.$variants[0]['measure_type'].'</div>';									
														} else { ?>
														<div>
															<select class="cust_select_box_1" onChange="dispVarPrice(<?php echo $product_id; ?>, this.value)">
																<?php foreach($variants as $item) {
																	echo '<option value="'.$item['id'].'" ';
																	//echo 'selected="selected"';
																	echo ' id="var_'.$product_id.'_'.$item['id'].'"';
																	echo ' ';
																	echo '>'.$item['net_measure'].' '.$item['measure_type'].'</option>';
																} ?>
															</select>
														</div>
														<?php } ?>
														<div class="item-price">
															<div class="price-box">
																<span class="regular-price">
																	<?php $i =0; foreach($variants as $item) {
																	if(isset($item['cart_quantity']) && $item['cart_quantity'] > 0) {
																		$cart_quantity = $item['cart_quantity'];
																		$flag = 0; // Remove from cart
																	} else {
																		$cart_quantity = 1;
																		$flag = 1; // Add cart
																	}
															
																	if(isset($item['wishlist']) && $item['wishlist'] == TRUE) { $wishlist_flag = "0"; }
																	else { $wishlist_flag = "1"; }
															
																	$variant_id = $item['id'];
																	echo '<span class="price" id="price_'.$product_id.'_'.$variant_id.'"';
																	if($i > 0) { echo 'style="display:none"'; }
																	echo '>₹ '.$item['price_finale'].'</span>';
																	$i++;

//echo '<input type="hidden" id="product_id_'.$product_id.'_'.$variant_id.'" value="'.$product_id.'" />';
//echo '<input type="hidden" id="variant_id_'.$product_id.'_'.$variant_id.'" value="'.$variant_id.'" />';
echo '<input type="hidden" id="quantity_'.$variant_id.'" value="'.$cart_quantity.'" />';
echo '<input type="hidden" id="flag_'.$variant_id.'" value="'.$flag.'" />';
echo '<input type="hidden" id="wishlist_flag_'.$variant_id.'" value="'.$wishlist_flag.'" />';
																	}
																	?>
																</span>
																<?php /* if($has_offer == TRUE) { ?>
																<p class="old-price">
																	<span class="price">₹ <?php echo $old_price; ?></span>
																</p>
																<?php } */ ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<?php } ?>
								<!--------- Products List End ------------>
							</ul>
							<?php } ?>
						</div>
						
						<?php echo printPagination($adjacents, $limit, $targetpage, $page, $counter, $prev, $next, $lastpage, $lpm1); ?>					
					</div>
				</div>
			</div>
		</div>
		<!-- Main Container End -->
		
		<!-- Footer -->
		<?php require_once "include/footer-main.php"; ?>		
		<!-- end Footer -->
		
		<a href="#" class="totop"> </a> </div>

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

	<!--jquery-slider js -->
	<?php /*?><script type="text/javascript" src="js/slider.html"></script><?php */?>

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
	
	<?php require_once "js-custom.php"; ?>
	<script>
	function sortByType(x)
	{
		<?php //echo '<pre>'; print_r($_GET); echo '</pre>';
		$get_vars = $_GET;
		if(isset($get_vars['sort'])) { unset($get_vars['sort']); }

		$query_string = [];
		foreach ($get_vars as $key => $value) {
			$query_string[] = $key.'='.$value;
		}

		$query_string = implode("&", $query_string);
		//echo '<pre>'; print_r($get_vars); echo '</pre>';
		$targetpage = $current_url."?".$query_string."&sort=";
		//echo targetpage;
		//exit;
		
		?>
		window.location.href = '<?php echo $targetpage; ?>'+x;
	}
		
	function dispVarPrice(product_id, var_id)
	{
		//alert('price_'+product_id+'_'+var_id+'');
		$('[id^="price_'+product_id+'"]').css('display', 'none');
		$('#price_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="cart_link_'+product_id+'"]').css('display', 'none');
		$('#cart_link_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="wishlist_icon_'+product_id+'"]').css('display', 'none');
		$('#wishlist_icon_'+product_id+'_'+var_id+'').css('display', 'block');
		
		$('[id^="offer_string_'+product_id+'"]').css('display', 'none');
		$('#offer_string_'+product_id+'_'+var_id+'').css('display', 'block');
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
	</script>
</body>
</html>