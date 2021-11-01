<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "About Us";

$query 		= "SELECT * FROM app_info WHERE app_id = $app_id";
$result_row = mysqli_fetch_assoc(mysqli_query($link, $query));

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

<link rel="stylesheet" type="text/css" href="css/shortcodes/shortcodes.css" media="all">
</head>

<body class="about_us_page">
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
            <li class="category13"><strong>About Us</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
  
  <!-- Main Container -->
  
  <div class="main container">
    <div class="row">
      <div class="about-page">
        <div class="col-xs-12 col-sm-12">
          <div class="page-title">
            <h2>About Us</h2>
          </div>
          <!--<h1>Welcome to <span class="text_color">NewLook</span></h1>-->
          <p><?php echo $result_row['about_us']; ?></p>
          
        </div>
        
      </div>
    </div>
  </div>
  
  
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