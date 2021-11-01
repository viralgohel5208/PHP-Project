<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
//require_once "login-required.php";

$page_title = "Categories";

if(isset($_GET['cat']))
{
	$type = "sub";
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
else
{
	$type = "main";
	$categories_list = getAppMainCategories($app_id);
	$page_title = "Categories";
}

?>
<!DOCTYPE html>
<html lang="en"><head>
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

	<!-- portfolio -->
	<link rel="stylesheet" type="text/css" href="js/portfolio/portfolio.min.css">

	<!-- main CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css" media="all">

	<!-- style CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/custom.css" media="all">
</head>

<body class="portfolio3_page">
	
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

		<div class="portfolio-page">
			<div class="portfolio-slid">
				<div class="container">
					<div class="breadcrumbs">
						<ul>
							<li class="home"> <a title="Go to Home Page" href="index.php">Home</a><span>&raquo;</span></li>
							<?php if($type == "main") { ?>
							<li class="category13"><strong>All Categories</strong></li>
							<?php } else { ?>
							<li class="home"> <a title="" href="categories.php">Categories</a><span>&raquo;</span></li>
							<li class="category13"><strong><?php echo $category_details['category_name']; ?></strong></li>
							<?php } ?>
						</ul>
					</div>
					<div class="portfolio-slid-info">
						<?php if($type == "main") { ?>
						<h1>All Categories</h1>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
						<?php } else { ?>
						<h1><a title="All Categories" href="categories.php" class="white_color">All Categories</a> <span>&raquo;</span> <?php echo $category_details['category_name']; ?></h1>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="container">

				<!-- end page title -->

				<div class="row">
					<div class="col-lg-12">
						<div id="filters-container" class="portfolio-filters-button">
							<a href="categories.php">
								<div class="mt-filter-item-active mt-filter-item">
									All Categories
									<div class="mt-filter-counter"></div>
								</div>
							</a>
							<a href="categories.php?id=2">
								<div class="mt-filter-item"> Cat 1
									<div class="mt-filter-counter"></div>
								</div>
							</a>
							<div data-filter=".accessories" class="mt-filter-item"> Accessories
								<div class="mt-filter-counter"></div>
							</div>
							<div data-filter=".food" class="mt-filter-item"> Food
								<div class="mt-filter-counter"></div>
							</div>
							<div data-filter=".other" class="mt-filter-item"> Other
								<div class="mt-filter-counter"></div>
							</div>
						</div>
						<div id="grid-container">
							<div class="mt-item clothing other">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-1.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Augue lorem lacinia</a></h3>
										<p>Lorem ipsum dolor sit amet, exerci tation adipiscing elit.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>
							<!-- end item -->
							<div class="mt-item accessories">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-3.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Fusce justo purus</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>
							<!-- end item -->
							<div class="mt-item clothing">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-2.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Pellentesque pharetra pulvinar</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>
							<!-- end item -->
							<div class="mt-item accessories">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-4.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Mauris at hendrerit odio</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->
							<div class="mt-item food">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-8.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Donec imperdiet blandit gravida</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->

							<div class="mt-item">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-5.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Cum sociis natoque penatibus</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>
							<!-- end item -->
							<div class="mt-item food accessories">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-6.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Pellentesque posuere posuere</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->
							<div class="mt-item other">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-8.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Maecenas tempus risus</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->
							<div class="mt-item accessories">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-10.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Vestibulum gravida</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->

							<div class="mt-item food">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-7.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Vel pharetra</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>
							<!-- end item -->
							<div class="mt-item accessories">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-11.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Ultricies dapibus</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->
							<div class="mt-item food">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-12.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Integer vestibulum</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->
							<div class="mt-item clothing">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-9.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Cras luctus</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->
							<div class="mt-item clothing">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="images/portfolio/projects-11.jpg" alt=""> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="portfolio-post.html"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="#">Look Book</a></h3>
										<p>Vestibulum eget leo eu turpis luctus interdum sit amet.</p>
										<a href="portfolio-post.html" class="learn-more">Learn More</a> </div>
								</div>
							</div>

							<!-- end item -->

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End portfolio page-->
		
		<!-- home contact -->
		<section id="contact" class="gray">
			<div class="container">

				<!-- Begin page header-->
				<div class="page-header-wrapper">
					<div class="container">
						<div class="page-header text-center wow fadeInUp">
							<h2>Contact <span class="text-main">Us</span></h2>
							<div class="divider divider-icon divider-md">&#x268A;&#x268A; &#x2756; &#x268A;&#x268A;</div>
							<p class="lead text-gray"> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. sed diam nonummy nibh euismod tincidunt.</p>
						</div>
					</div>
				</div>
				<!-- End page header-->

				<div class="row">
					<div class="col-sm-4 adress-element wow zoomIn"> <i class="fa fa-home fa-2x"></i>
						<h3>Our Address</h3>
						<span class="font-l">7064 Lorem Ipsum Vestibulum 666/13</span> </div>
					<div class="col-sm-4 adress-element wow zoomIn"> <i class="fa fa-comment fa-2x"></i>
						<h3>Our mail</h3>
						<span class="font-l"><a href="mailto:support@justtheme.com">support@justtheme.com</a></span> </div>
					<div class="col-sm-4 adress-element wow zoomIn"> <i class="fa fa-phone fa-2x"></i>
						<h3>Our phone</h3>
						<span class="font-l">+012 315 678 1234</span> </div>
				</div>
			</div>
		</section>
		
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

	<!--jquery-ui.min js -->
	<script src="js/jquery-ui.js"></script>

	<!-- main js -->
	<script type="text/javascript" src="js/main.js"></script>

	<!-- jquery.waypoints js -->
	<script type="text/javascript" src="js/waypoints.js"></script>
	<script type="text/javascript" src="js/portfolio/jquery.portfolio.min.js"></script>
	<script type="text/javascript" src="js/portfolio/portfolio-3.js"></script>
</body>
</html>