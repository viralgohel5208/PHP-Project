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
							<li class="home"> <a title="Go to Home Page" href="index.php">Home</a><span>&raquo;</span>
							</li>
							<li class="category13"><strong>Login or Create an Account</strong>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->

		<!-- Main Container -->
		<section class="main-container col1-layout">
			<div class="main container">
				<div class="account-login">
					<div class="page-title">
						<h2>Login or Create an Account</h2>
					</div>
					<div class="page-content">
						<div class="row">
							<div class="col-sm-6">
								<div class="box-authentication">
									<h3>Create an account</h3>
									<p>Please enter your email address to create an account.</p>
									<label for="emmail_register">Email address</label>
									<input id="emmail_register" type="text" class="form-control">
									<label for="password_login">Password</label>
									<input id="password_login" type="password" class="form-control">
									<label for="password_login">Confirm Password</label>
									<input id="password_login" type="password" class="form-control">
									<button class="button"><i class="fa fa-user"></i>&nbsp; <span>Create an account</span></button>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="box-authentication">
									<h3>Already registered?</h3>
									<label for="emmail_login">Email address</label>
									<input id="emmail_login" type="text" class="form-control">
									<label for="password_login">Password</label>
									<input id="password_login" type="password" class="form-control">
									<p class="forgot-pass"><a href="#">Forgot your password?</a>
									</p>
									<button class="button"><i class="fa fa-lock"></i>&nbsp; <span>Sign in</span></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
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
</body>
</html>