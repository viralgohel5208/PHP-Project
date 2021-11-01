<?php
/*ob_start();
session_start();*/
require_once "universal.php";
require_once "db.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title 	= "Home";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php /*?><meta charset="utf-8"><?php */?>
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

	<!-- flexslider CSS -->
	<link rel="stylesheet" type="text/css" href="css/flexslider.css">

	<!-- style CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">

	<!-- shortcodes -->
	<link rel="stylesheet" media="screen" href="css/shortcodes/shortcodes.css" type="text/css"/>

	<!-- accordion -->
	<link rel="stylesheet" type="text/css" href="js/accordion/accordion.css"/>

	<!-- tooltips -->
	<link rel="stylesheet" href="js/tooltips/tooltip.css"/>

	<!-- progressbar -->
	<link rel="stylesheet" href="js/progressbar/ui.progress-bar.css">

	<!-- popup newsletter css -->
	<link rel="stylesheet" href="css/popup-newsletter.css">

	<!-- main CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css" media="all">

	<!-- slider CSS  -->
	<link rel="stylesheet" type="text/css" href="css/revolution-slider.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/custom.css" media="all">
	
	<style>
	/*** Image Center Align Start ****/
	.single-collection {
		/*position: absolute;*/
		height:300px;
		width:100%;
		/*border: 5px solid red;*/
		display:table-cell;
		vertical-align:middle;
		text-align:center;
	}
	.single-collection img.img-thumbnail {
		display: block;
		margin-left: auto;
		margin-right: auto;
		max-height: 300px;
	}
	/*** Image Center Align End ****/
	</style>
</head>

<body class="cms-index-index cms-home-page home-1">
	
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
		
		<!-- slideshow fullwidth -->
		<?php require_once "include/slideshow-main.php"; ?>
		<!-- end slideshow fullwidth -->

		<!-- COLLECTION-AREA-START -->
		<section class="collestion-area">
			<div class="container">
				<div class="page-header text-center wow fadeInUp">
					<h2>Featured<span class="text-main"> Categories</span></h2>
					<div class="divider divider-icon divider-md">&#x268A;&#x268A; &#x2756; &#x268A;&#x268A;</div>
				</div>
				<div class="collection-content">
					<div class="row">
						<?php 
						$query_1 = "SELECT id, category_name, file_name FROM categories WHERE `app_id` = $app_id ORDER BY RAND() LIMIT 4";
						$result_1 = mysqli_query($link, $query_1);
						while($row_1 = mysqli_fetch_assoc($result_1))
						{
							$file_name = $row_1['file_name'];
							
							if($file_name != "" && file_exists("uploads/store-".$app_id."/categories/" . $file_name))
							{
								$file_name = "uploads/store-".$app_id."/categories/".$file_name;
							}
							else
							{
								$file_name = "images/default/category-default.png";
							}
						echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="wow bounceInUp" data-wow-delay="0.2s">
								<div class="single-collection"> 
									<a href="categories.php?cat='.$row_1['id'].'"> 
										<img src="'.$file_name.'" alt="" class="img-thumbnail">
									</a>
									<div class="collections-link"> <a href="categories.php?cat='.$row_1['id'].'">'.$row_1['category_name'].'</a> </div>
								</div>
							</div>
						</div>';
						}
						?>
					</div>
				</div>
			</div>
		</section>

		<!-- main container -->
		<div class="main-container col1-layout">
			<div class="container">
				<div class="row">
					<!-- Home Tabs  -->
					<div class="home-tab col-xs-12 wow fadeInUp">
						<ul class="nav home-nav-tabs home-product-tabs">
							<li class="active"><a href="#new-arrivals" data-toggle="tab" aria-expanded="false">New Arrivals</a></li>
						</ul>
						<div id="productTabContent" class="tab-content">
							<div class="tab-pane active in" id="new-arrivals">
								<?php 
								$products = getRelatedProducts($app_id, $customer_id, 0, 6);
								/* echo '<pre>'; print_r($products); echo '</pre>';*/
								?>
								<div class="new-arrivals-pro">
									<div class="slider-items-products">
										<div id="new-arrivals-slider" class="product-flexslider hidden-buttons">
											<div class="slider-items slider-width-col4">
												
												<?php foreach($products as $item) {
	$product_id 	= $item['id'];
								$product_name 	= $item['product_name'];
								$file_name 		= $item['file_name'][0];
	$price_finale 	= $item['price_finale'];
	$total_star_count 		= $item['total_star_count'];
								$total_star_customers 	= $item['total_star_customers'];
	
												echo '<div class="product-item">
													<div class="item-inner fadeInUp">
														<div class="product-thumbnail">
															<div class="pr-img-area">
																<a href="products-details.php?pro='.safe_encode($product_id).'">
																<figure> <img class="first-img" src="'.$file_name.'" alt="">';
	//echo '<img class="hover-img" src="'.$file_name.'" alt="">';
																echo '</figure>
																<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> View Details</span> </button>
																</a>
															</div>
														</div>
														<div class="item-info">
															<div class="info-inner">
																<div class="item-title"> <a title="'.$product_name.'" href="products-details.php?pro='.safe_encode($product_id).'">'.$product_name.'</a> </div>
																<div class="item-content">
																	'.displayStarRating($total_star_count, $total_star_customers).'
																	<div class="item-price">
																		<div class="price-box"> <span class="regular-price"> <span class="price">₹ '.$price_finale.'</span> </span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>';
}
												?>
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
		<!-- end main container -->

		<!-- Begin Deal this Week section -->
		<section id="about-section" style="padding: 30px 0">
			<div class="page-header-wrapper">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="home-top-banner" style="margin-bottom: 10px">
								<div class="banner_left wow zoomIn" style="margin-bottom: 0">
									<div class="banner-inner">
										<div class="img"><a href="my-account.php"><img src="images/my-account.jpg" alt=""></a>
										</div>
										<div class="banner_left_content">
											<h2 style="font-family: consolas"></h2>
											<h3 style="font-family: consolas; color:#eaeaea">My Account</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="home-top-banner" style="margin-bottom: 10px">
								<div class="banner_left wow zoomIn" style="margin-bottom: 0">
									<div class="banner-inner">
										<div class="img"><a href="wishlist.php"><img src="images/wishlist.jpg" alt=""></a>
										</div>
										<div class="banner_left_content">
											<h2 style="font-family: consolas"></h2>
											<h3 style="font-family: consolas; color:#eaeaea">Wishlist</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="home-top-banner" style="margin-bottom: 10px">
								<div class="banner_left wow zoomIn" style="margin-bottom: 0">
									<div class="banner-inner">
										<div class="img"><a href="shopping-cart.php"><img src="images/my-cart.jpg" alt=""></a>
										</div>
										<div class="banner_left_content">
											<h2></h2>
											<h3 style="font-family: consolas; color:#eaeaea">My Cart</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- featured slider -->
		<section class="featured_slider">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 wow zoomInRight">
						<div class="featured-products wow slideInDown">
							<div class="box-featured-product">
								<h2>Featured Products</h2>
							</div>
						</div>
						<div class="featured-product-slider">
							<div id="featured-products-carousel" class="carousel slide">
								<div class="carousel-inner">
									<div class="">
										<div class="row">
											
											<?php 
								$products = getRelatedProducts($app_id, $customer_id, 0, 4);
								/* echo '<pre>'; print_r($products); echo '</pre>';*/
								foreach($products as $item) {
	$product_id 	= $item['id'];
								$product_name 	= $item['product_name'];
								$file_name 		= $item['file_name'][0];
	$price_finale 	= $item['price_finale'];
	$total_star_count 		= $item['total_star_count'];
								$total_star_customers 	= $item['total_star_customers'];
	echo '<div class="col-md-3 col-sm-3">';
												echo '<div class="product-item">
													<div class="item-inner fadeInUp">
														<div class="product-thumbnail">
															<div class="pr-img-area">
																<a href="products-details.php?pro='.safe_encode($product_id).'">
																<figure> <img class="first-img" src="'.$file_name.'" alt="">';
									//echo '<img class="hover-img" src="'.$file_name.'" alt="">';
																echo '</figure>
																<button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> View Details</span> </button>
																</a>
															</div>
														</div>
														<div class="item-info">
															<div class="info-inner">
																<div class="item-title"> <a title="'.$product_name.'" href="products-details.php?pro='.safe_encode($product_id).'">'.$product_name.'</a> </div>
																<div class="item-content">
																	'.displayStarRating($total_star_count, $total_star_customers).'
																	<div class="item-price">
																		<div class="price-box"> <span class="regular-price"> <span class="price">₹ '.$price_finale.'</span> </span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>';
	echo '</div>';
}
												?>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end featured slider -->
		
		<?php $query_2 = "SELECT * FROM testimonials WHERE status = 1 AND app_id = '$app_id' ORDER BY id DESC";
		$result_2 = mysqli_query($link, $query_2);
		if($result_2) {
		?>
		
		<!-- Testimonials Box -->
		<section class="testimonials">
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<div class="page-header text-center">
								<h2>Testimonials</h2>
							</div>
							<div class="slider-items-products">
								<div id="testimonials-slider" class="product-flexslider hidden-buttons home-testimonials">
									<div class="slider-items slider-width-col4 fadeInUp">
										<?php 
										while($row_2 = mysqli_fetch_assoc($result_2))
										{
											if($row_2['file_name'] != "" && file_exists("uploads/store-".$app_id."/testimonials/".$row_2['file_name']))
											{ 
												$testim_image = "uploads/store-".$app_id."/testimonials/".$row_2['file_name'];
											}
											else
											{
												$testim_image = "images/default/user-avatar.png";
											}
										echo '<div class="holder">
											<div class="thumb"> <img src="'.$testim_image.'" alt="testimonials img"> </div>
											<p>'.$row_2['description'].'</p>
											<strong class="name">'.$row_2['name'].'</strong> <strong class="designation">'.$row_2['position'].', '.$row_2['company'].'</strong> 
										</div>';
										} ?>
										
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2"></div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Testimonials Box -->
		
		<?php } ?>
		
		<!-- news start-->
		<?php /*?><section id="latest-news" class="news">
			<div class="container">
				<div class="row">
					<div class="slider-items-products">
						<div id="latest-news-slider" class="product-flexslider hidden-buttons">
							<!-- Begin page header-->
							<div class="page-header-wrapper wow fadeInUp">
								<div class="container">
									<div class="page-header text-center">
										<h2>Latest <span class="text-main">News</span></h2>
										<div class="divider divider-icon divider-md">&#x268A;&#x268A; &#x2756; &#x268A;&#x268A;</div>
									</div>
								</div>
							</div>
							<!-- End page header-->
							<div class="slider-items slider-width-col6">

								<!-- Item -->
								<div class="item wow zoomIn">
									<div class="post-wrapper">
										<div class="thumbnail-content">
											<a class="post-thumbnail" href="#">
												<figure><img class="img-responsive" src="images/news1.jpg" alt="Post Thumbnail"/>
												</figure>
											</a>
										</div>
										<div class="content-meta">
											<h3><a href="#">Lorem Ipsum Dolor sit Amet!</a></h3>
											<ul class="post-info">
												<li><i class="fa fa-calendar"></i>December 02, 2015</li>
												<li><a href="#"><i class="fa fa-comments"></i>10 comments</a>
												</li>
											</ul>
											<p class="excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque tempus ac eget diam et laoreet phasellus. </p>
											<a class="readMore" href="#">Read More <i class="fa fa-angle-right"></i></a> </div>
									</div>
								</div>
								<!-- End Item -->
								<div class="item wow zoomIn">
									<div class="post-wrapper">
										<div class="thumbnail-content">
											<a class="post-thumbnail" href="#">
												<figure><img class="img-responsive" src="images/news2.jpg" alt="Post Thumbnail"/>
												</figure>
											</a>
										</div>
										<div class="content-meta">
											<h3><a href="#">Lorem Ipsum Dolor sit Amet!</a></h3>
											<ul class="post-info">
												<li><i class="fa fa-calendar"></i>December 05, 2015</li>
												<li><a href="#"><i class="fa fa-comments"></i>03 comments</a>
												</li>
											</ul>
											<p class="excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque tempus ac eget diam et laoreet phasellus. </p>
											<a class="readMore" href="#">Read More <i class="fa fa-angle-right"></i></a> </div>
									</div>
								</div>
								<!-- Item -->
								<div class="item wow zoomIn">
									<div class="post-wrapper">
										<div class="thumbnail-content">
											<a class="post-thumbnail" href="#">
												<figure><img class="img-responsive" src="images/news3.jpg" alt="Post Thumbnail"/>
												</figure>
											</a>
										</div>
										<div class="content-meta">
											<h3><a href="#">Lorem Ipsum Dolor sit Amet!</a></h3>
											<ul class="post-info">
												<li><i class="fa fa-calendar"></i>December 10, 2015</li>
												<li><a href="#"><i class="fa fa-comments"></i>14 comments</a>
												</li>
											</ul>
											<p class="excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque tempus ac eget diam et laoreet phasellus. </p>
											<a class="readMore" href="#">Read More <i class="fa fa-angle-right"></i></a> </div>
									</div>
								</div>
								<!-- End Item -->

								<!-- Item -->
								<div class="item wow zoomIn">
									<div class="post-wrapper">
										<div class="thumbnail-content">
											<a class="post-thumbnail" href="#">
												<figure><img class="img-responsive" src="images/news4.jpg" alt="Post Thumbnail"/>
												</figure>
											</a>
										</div>
										<div class="content-meta">
											<h3><a href="#">Lorem Ipsum Dolor sit Amet!</a></h3>
											<ul class="post-info">
												<li><i class="fa fa-calendar"></i>December 18, 2015</li>
												<li><a href="#"><i class="fa fa-comments"></i>20 comments</a>
												</li>
											</ul>
											<p class="excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque tempus ac eget diam et laoreet phasellus. </p>
											<a class="readMore" href="#">Read More <i class="fa fa-angle-right"></i></a> </div>
									</div>
								</div>
								<!-- End Item -->

								<!-- Item -->
								<div class="item wow zoomIn">
									<div class="post-wrapper">
										<div class="thumbnail-content">
											<a class="post-thumbnail" href="#">
												<figure><img class="img-responsive" src="images/news5.jpg" alt="Post Thumbnail"/>
												</figure>
											</a>
										</div>
										<div class="content-meta">
											<h3><a href="#">Lorem Ipsum Dolor sit Amet!</a></h3>
											<ul class="post-info">
												<li><i class="fa fa-calendar"></i>December 20, 2015</li>
												<li><a href="#"><i class="fa fa-comments"></i>11 comments</a>
												</li>
											</ul>
											<p class="excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque tempus ac eget diam et laoreet phasellus. </p>
											<a class="readMore" href="#">Read More <i class="fa fa-angle-right"></i></a> </div>
									</div>
								</div>
								<!-- End Item -->

								<!-- Item -->
								<div class="item wow zoomIn">
									<div class="post-wrapper">
										<div class="thumbnail-content">
											<a class="post-thumbnail" href="#">
												<figure><img class="img-responsive" src="images/news6.jpg" alt="Post Thumbnail"/>
												</figure>
											</a>
										</div>
										<div class="content-meta">
											<h3><a href="#">Lorem Ipsum Dolor sit Amet!</a></h3>
											<ul class="post-info">
												<li><i class="fa fa-calendar"></i>December 22, 2015</li>
												<li><a href="#"><i class="fa fa-comments"></i>08 comments</a>
												</li>
											</ul>
											<p class="excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque tempus ac eget diam et laoreet phasellus. </p>
											<a class="readMore" href="#">Read More <i class="fa fa-angle-right"></i></a> </div>
									</div>
								</div>
								<!-- End Item -->

							</div>
						</div>
					</div>
				</div>
			</div>
		</section><?php */?>
		<!-- end news start-->

		<!-- our clients Slider -->
		<?php // require_once "include/client-display-1.php"; ?>
		<!-- end our clients Slider -->
		
		<!-- home contact -->
		<?php require "include/contact-us-home.php"; ?>
		<!-- end home contact -->
		
		<!-- Footer -->
		<?php require_once "include/footer-main.php"; ?>		
		<!-- end Footer -->
		
		<a href="#" class="totop"> </a> </div>
	
	<!-- newsletter popup -->
	<?php // require_once "include/newsletter-popup.php"; ?>
	<!-- end newsletter popup -->
	<!-- JS -->

	<!-- cookies js -->
	<script type="text/javascript" src="js/cookies.js"></script>

	<!-- jquery js -->
	<script type="text/javascript" src="js/jquery.min.js"></script>

	<!-- bootstrap js -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<!-- Slider Js -->
	<script type="text/javascript" src="js/revolution-slider.js"></script>
	<script type="text/javascript" src="js/revolution-extension.js"></script>

	<!-- owl.carousel.min js -->
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>

	<!-- bxslider js -->
	<script type="text/javascript" src="js/jquery.bxslider.js"></script>

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

	<!-- infographic js -->
	<script type="text/javascript" src="js/infographic.js"></script>

	<!-- tooltips js -->
	<script src="js/tooltips/jquery.tooltip.js"></script>

	<!-- progress js -->
	<script src="js/progressbar/progress.js" type="text/javascript" charset="utf-8"></script>

	<!-- jquery.waypoints js -->
	<script type="text/javascript" src="js/waypoints.js"></script>

	<!-- animate number js -->
	<script src="js/aninum/jquery.animateNumber.min.js"></script>

	<!-- popup newsletter js -->
	<script type="text/javascript" src="js/popup-newsletter.js"></script>

	<!-- countdown js -->
	<script type="text/javascript" src="js/countdown.js"></script>
</body>
</html>