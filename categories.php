<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "Categories";

if(isset($_GET['cat']))
{
	$type = "sub";
	$category_id = safe_decode($_GET['cat']);
	$category_details = getAppCategoriesDetails($app_id, $category_id);
	if(!$category_details)
	{
		//echo 'Not found'; exit;
		header("Location:categories.php");
		exit;
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
	<link rel="stylesheet" type="text/css" href="css/shortcodes/shortcodes.css" media="all">
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
						<?php if($type == "sub") { ?>
						<div id="filters-container" class="portfolio-filters-button">
							<a href="categories.php">
								<div class="mt-filter-item">
									All Categories
								</div>
							</a>
							<?php foreach($main_categories_list as $item) { ?>
								<?php if($category_id == $item['id']) { ?>
									<a href="#">
								<?php } else { ?>
									<a href="categories.php?cat=<?php echo safe_encode($item['id']); ?>">
								<?php } ?>
								<div class="mt-filter-item <?php if($category_id == $item['id']) { echo "mt-filter-item-active"; } ?> "> <?php echo $item['category_name']; ?>
								</div>
							</a>
							<?php } ?>
						</div>
						<?php } ?>
						
						<?php if(empty($categories_list)) { echo '<h4 style="margin:100px 0">No records found.</h4>'; }?>
							
						<div id="grid-container">
							
							<?php foreach($categories_list as $item) {
	
								$item_name = $item['category_name'];
								$file_name = $item['file_name'];

								if($type == "main")
								{
									$go_to_url = "categories.php?cat=".safe_encode($item['id']);
									$more_btn = "View Sub Categories";
								}
								else
								{
									$go_to_url = "products-list.php?cat=".safe_encode($item['id']);
									$more_btn = "View Products";
								}

								if($file_name != "" && file_exists("uploads/store-".$app_id."/categories/" . $file_name))
								{
									$file_name = "uploads/store-".$app_id."/categories/".$file_name;
								}
								else
								{
									$file_name = "images/default/category-default.png";
								}
							?>
							
							<!-- start item -->
							<div class="mt-item clothing other">
								<div class="mt-caption">
									<div class="mt-caption-defaultWrap"> <img src="<?php echo $file_name; ?>" alt="<?php echo $item_name; ?>"> </div>
									<div class="mt-caption-activeWrap">
										<div class="mt-search"> <a href="<?php echo $go_to_url; ?>"> <i class="fa fa-search"></i> </a> </div>
									</div>
								</div>
								<div class="portfolio-caption-alignCenter">
									<div class="portfolio-caption-body">
										<h3><a href="<?php echo $go_to_url; ?>"><?php echo $item_name; ?></a></h3>
										<?php /*?><p>Lorem ipsum dolor sit amet, exerci tation adipiscing elit.</p><?php */?>
										<a href="<?php echo $go_to_url; ?>" class="learn-more"><?php echo $more_btn; ?></a> </div>
								</div>
							</div>
							<!-- end item -->
							<?php } ?>
							
							<?php /*?><div class="mt-item clothing other">
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
							<!-- end item --><?php */?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End portfolio page-->
		
		<div style="margin-bottom: 50px">&nbsp;</div>
			
		<!-- home contact -->
		<?php require "include/contact-us-home.php"; ?>
		<!-- end home contact -->
		
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