<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "Checkout Complete";

$order_number = "HGD6757";
$cart_total = "₹ 500.55";

if(isset($_SESSION['ck_order_complete']))
{
	$order_number 	= $_SESSION['ck_order_number'];
	$cart_total 	= $_SESSION['cart_total'];
	
	unset($_SESSION['ck_order_complete']);
	unset($_SESSION['ck_order_id']);
	unset($_SESSION['ck_order_number']);
	
	unset($_SESSION['cust_cart']);
	unset($_SESSION['cart_total']);
	unset($_SESSION['ck_city_id']);
	unset($_SESSION['ck_store_id']);
	unset($_SESSION['ck_area_id']);
	unset($_SESSION['ck_delivery_charge']);
}
else
{
	//header("Location:my-orders.php");
	//exit;
}

?>
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

	<!-- shortcodes -->
	<link rel="stylesheet" media="screen" href="css/shortcodes/shortcodes.css" type="text/css"/>

	<!-- accordion -->
	<link rel="stylesheet" type="text/css" href="js/accordion/accordion.css"/>
</head>

<body class="buttons_page">
	
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
							<li class="home"><a title="Go to Home Page" href="index.php">Home</a><span>&raquo;</span></li>
							<li class="category13"><strong>Checkout Complete</strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->
		
		<!-- Main Container -->
		<section class="our-clients">
			<div class="container">
				<div class="slider-items-products">
					<div id="our-clients-slider" class="product-flexslider hidden-buttons">
						<!-- Begin page header-->
						<div class="page-header-wrapper">
							<div class="container">
								<div class="page-header text-center wow fadeInUp">
									<h2>Order <span class="text-main">Placed</span></h2>
									<div class="divider divider-icon divider-md">&#x268A;&#x268A; &#x2756; &#x268A;&#x268A;</div>
									<p class="lead text-gray"> <br /> Your Order has been placed. Order number is <?php echo $order_number;  ?><br /><br />Thank you!!</p>
									
									<button onclick="window.location = 'my-orders.php'" class="button" style="padding: 6px 20px;"><i class="fa fa-shopping-cart"></i>&nbsp; <span>My Orders</span></button>
									
								</div>
							</div>
						</div>
						<!-- End page header-->
					</div>
				</div>
			</div>
		</section>
		<!-- Main Container End -->
		
		<!-- home contact -->
		<?php require "include/contact-us-home.php"; ?>
		<!-- end home contact -->
		
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

	<!--jquery-ui.min js -->
	<script src="js/jquery-ui.js"></script>

	<!-- main js -->
	<script type="text/javascript" src="js/main.js"></script>

	<!-- jquery.waypoints js -->
	<script type="text/javascript" src="js/waypoints.js"></script>
	<script type="text/javascript" src="js/accordion/jquery.accordion.js"></script>
</body>
</html>