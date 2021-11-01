<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
//require_once "login-required.php";

$page_title = "Categories";

if(!isset($_GET['cat']))
{
	header("Location:categories.php");
	exit;
}
else
{
	$category_id = safe_decode($_GET['cat']);
	$category_details = getAppCategoriesDetails($app_id, $category_id);
	if(!$category_details)
	{
		echo 'Not found'; exit;
	}
	else
	{
		$main_categories_list = getAppMainCategories($app_id);
		$categories_list = getAppSubCategories($app_id, $category_id);
		$page_title = $category_details['category_name']. " - Sub Categories";
	}
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

	<!-- animate CSS  -->
	<link rel="stylesheet" type="text/css" href="css/animate.css" media="all">

	<!-- jquery-ui.min CSS  -->
	<link rel="stylesheet" href="css/jquery-ui.css">

	<!-- main CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css" media="all">

	<!-- style CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
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
							<li class=""> <a title="Go to Home Page" href="shop_grid.html">Women</a><span>&raquo;</span></li>
							<li class="category13"><strong>Women Collections </strong></li>
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
								<li class="cat-item current-cat cat-parent"><a href="shop_grid.html">Women</a>
									<ul class="children">
										<li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Accessories</a>
											<ul class="children">
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Dresses</a>
												</li>
												<li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Handbags</a>
													<ul style="display: none;" class="children">
														<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Beaded Handbags</a>
														</li>
														<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Sling bag</a>
														</li>
													</ul>
												</li>
											</ul>
										</li>
										<li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Handbags</a>
											<ul class="children">
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; backpack</a>
												</li>
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Beaded Handbags</a>
												</li>
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Fabric Handbags</a>
												</li>
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Sling bag</a>
												</li>
											</ul>
										</li>
										<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Jewellery</a> </li>
										<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Swimwear</a> </li>
									</ul>
								</li>
								<li class="cat-item cat-parent"><a href="shop_grid.html">Men</a>
									<ul class="children">
										<li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Dresses</a>
											<ul class="children">
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Casual</a>
												</li>
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Designer</a>
												</li>
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Evening</a>
												</li>
												<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Hoodies</a>
												</li>
											</ul>
										</li>
										<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Jackets</a> </li>
										<li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Shoes</a> </li>
									</ul>
								</li>
								<li class="cat-item"><a href="shop_grid.html">Electronics</a>
								</li>
								<li class="cat-item"><a href="shop_grid.html">Furniture</a>
								</li>
								<li class="cat-item"><a href="shop_grid.html">KItchen</a>
								</li>
							</ul>
						</div>
						<div class="product-price-range wow fadeInUp">
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
						</div>
						
						<div class="single-img-add sidebar-add-slider wow fadeInUp">
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
						</div>
						
					</aside>
					<div class="col-main col-sm-9">
						<div class="page-title">
							<h2>Women Collections</h2>
						</div>
						<div class="category-description std">
							<div class="slider-items-products">
								<div id="category-desc-slider" class="product-flexslider hidden-buttons">
									<div class="slider-items slider-width-col1 owl-carousel owl-theme">

										<!-- Item -->
										<div class="item"> <a href="#x"><img alt="" src="images/cat-slider-img1.jpg"></a>
											<div class="inner-info">
												<div class="cat-img-title"> <span>Fashion Current Sale Item</span>
													<h2 class="cat-heading"><strong>UP TO 50% OFF</strong></h2>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
													<a class="info" href="#">shop Now</a> </div>
											</div>
										</div>
										<!-- End Item -->

										<!-- Item -->
										<div class="item"> <a href="#x"><img alt="" src="images/cat-slider-img2.jpg"></a> </div>

										<!-- End Item -->

									</div>
								</div>
							</div>
						</div>
						<div class="toolbar">
							<div class="view-mode">
								<ul>
									<li class="active"> <a href="shop_grid.html"> <i class="fa fa-th-large"></i> </a> </li>
									<li> <a href="shop_list.html"> <i class="fa fa-th-list"></i> </a> </li>
								</ul>
							</div>
							<div class="sorter">
								<div class="short-by">
									<label>Sort By:</label>
									<select>
										<option selected="selected">Position</option>
										<option>Name</option>
										<option>Price</option>
										<option>Size</option>
									</select>
								</div>
								<div class="short-by page">
									<label>Show:</label>
									<select>
										<option selected="selected">8</option>
										<option>12</option>
										<option>16</option>
										<option>30</option>
									</select>
								</div>
							</div>
						</div>
						<div class="product-grid-area">
							<ul class="products-grid">
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="icon-sale-label sale-left">Sale</div>
												<div class="icon-new-label new-right">New</div>
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img01.jpg" alt=""> <img class="hover-img" src="images/products/img01.jpg" alt="">
													</figure>
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
								</li>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img02.jpg" alt=""> <img class="hover-img" src="images/products/img02.jpg" alt="">
													</figure>
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
														<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
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
								</li>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img03.jpg" alt=""> <img class="hover-img" src="images/products/img03.jpg" alt="">
													</figure>
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
								</li>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="icon-sale-label sale-left">Sale</div>
											<div class="icon-new-label new-right">New</div>
											<div class="product-thumbnail">
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img04.jpg" alt=""> <img class="hover-img" src="images/products/img04.jpg" alt="">
													</figure>
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
														<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="icon-new-label new-left">New</div>
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img05.jpg" alt=""> <img class="hover-img" src="images/products/img05.jpg" alt="">
													</figure>
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
								</li>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img20.jpg" alt=""> <img class="hover-img" src="images/products/img20.jpg" alt="">
													</figure>
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
															<div class="price-box"> <span class="regular-price"> <span class="price">$89.99</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<!-- .a2 -->

								<!-- b2 -->
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img15.jpg" alt=""> <img class="hover-img" src="images/products/img15.jpg" alt="">
													</figure>
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
															<div class="price-box"> <span class="regular-price"> <span class="price">$125.99</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<!-- .b2 -->

								<!-- c2 -->
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img19.jpg" alt=""> <img class="hover-img" src="images/products/img19.jpg" alt="">
													</figure>
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
															<div class="price-box"> <span class="regular-price"> <span class="price">$225.88</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="icon-new-label new-right">New</div>
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img07.jpg" alt=""> <img class="hover-img" src="images/products/img07.jpg" alt="">
													</figure>
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
															<div class="price-box"> <span class="regular-price"> <span class="price">$55.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<!-- .a1 -->

								<!-- b1 -->
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="icon-sale-label sale-left">Sale</div>
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img20.jpg" alt=""> <img class="hover-img" src="images/products/img20.jpg" alt="">
													</figure>
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
															<div class="price-box"> <span class="regular-price"> <span class="price">$59.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<!-- .b1 -->

								<!-- c1 -->
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="icon-new-label new-right">New</div>
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img16.jpg" alt=""> <img class="hover-img" src="images/products/img16.jpg" alt="">
													</figure>
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
														<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$120.99</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 wow fadeInUp">
									<div class="product-item">
										<div class="item-inner">
											<div class="product-thumbnail">
												<div class="icon-new-label new-right">New</div>
												<div class="pr-img-area">
													<figure> <img class="first-img" src="images/products/img12.jpg" alt=""> <img class="hover-img" src="images/products/img12.jpg" alt="">
													</figure>
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
														<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
														<div class="item-price">
															<div class="price-box"> <span class="regular-price"> <span class="price">$99.00</span> </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="pagination-area wow fadeInUp">
							<ul>
								<li><a class="active" href="#">1</a>
								</li>
								<li><a href="#">2</a>
								</li>
								<li><a href="#">3</a>
								</li>
								<li><a href="#"><i class="fa fa-angle-right"></i></a>
								</li>
							</ul>
						</div>
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
	<script type="text/javascript" src="js/slider.html"></script>

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
</body>
</html>