﻿<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "Login";

if(isset($_SESSION["cu_login"]) && $_SESSION["cu_login"] == 'YES')
{
	if(isset($_SESSION['prev_page']) && $_SESSION['prev_page'] != "")
	{
		header("Location:".$_SESSION['prev_page']);
	}
	else
	{
		header("Location:index.php");
	}
	exit;
}


if(isset($_POST['username']))
{
	$username 	= escapeInputValue($_POST['username']);
	$password 	= escapeInputValue($_POST['password']);

	if($username == "" || $password == "")
	{	
		$error = "Please enter username & password";
	}
	else
	{
		$q = "select id, app_id, user_name, mobile, password from customers where user_name = '$username' OR mobile = '$username' AND app_id = '$app_id'";
		$res_query = mysqli_query($link, $q);

		if(!$res_query)
		{
			$error = $sww;
		}
		else
		{
			if(mysqli_num_rows($res_query) > 0)
			{
				$row = mysqli_fetch_array($res_query);
				if ($row["password"] == passwordEncyption($password, 'e'))
				{
					$_SESSION["cu_user_name"] 	= $row["user_name"];
					$_SESSION["cu_customer_id"]	= $row["id"];
					$_SESSION["cu_login"] 		= "YES";
					
					/*********** Get Customer Cart start  *****************/
					 $sql_cart = "SELECT * FROM customers_cart WHERE app_id = $app_id AND customer_id = ". $row["id"];
					 $res_cart = mysqli_query($link, $sql_cart);
					 if($res_cart)
					 {
					  while($row_cart = mysqli_fetch_assoc($res_cart))
					  {
					   $product_id = $row_cart['product_id'];
					   $variant_id = $row_cart['variant_id'];
					   $quantity  = $row_cart['quantity'];

					   $_SESSION['cust_cart'][$product_id.'_'.$variant_id] = array(
						'product_id'  => $product_id,
						'variant_id'  => $variant_id,
						'quantity'   => $quantity,
					   );
					  }
					 }
					 /*********** Get Customer Cart end  *****************/
					
					/************ Get Wishlist start  ******************/
					$sql_cart = "SELECT * FROM customers_wishlist WHERE app_id = $app_id AND customer_id = ". $row["id"];
					$res_cart = mysqli_query($link, $sql_cart);
					if($res_cart)
					{
						while($row_cart = mysqli_fetch_assoc($res_cart))
						{
							$product_id = $row_cart['product_id'];
							$variant_id = $row_cart['variant_id'];
							
							$_SESSION['cust_wishlist'][$product_id.'_'.$variant_id] = array(
								'product_id' 	=> $product_id,
								'variant_id' 	=> $variant_id,
							);
						}
					}
					/************ Get Wishlist end  ******************/
					
					if(isset($_SESSION['prev_page']) && $_SESSION['prev_page'] != "")
					{
						header("Location:".$_SESSION['prev_page']); 	// Redirecting To Other Page
					}
					else
					{
						header("Location:index.php"); 	// Redirecting To Other Page
					}
					exit;
				}
				else
				{
					$error = "Please enter correct password";
				}
			}
			else
			{
				$error = "Incorrect username and Password";
			}
		}
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
	<link rel="stylesheet" type="text/css" href="css/shortcodes/shortcodes.css" media="all">
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
							<li class="category13"><strong>Login</strong>
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
					<div class="page-content">
						<div class="row">
							<div class="col-md-offset-3 col-md-6 col-sm-12">
								<div class="page-title">
									<h2>Login</h2>
								</div>
								<?php require_once "message-block.php"; ?>
								<form class="login-form" method="post">
								<div class="box-authentication">
									<h3>Already registered?</h3>
									<?php //if($error != "") { echo '<p style="color:#f27c66">'.$error.'</p>'; } ?>
									
									<label for="emmail_login">User Name / Mobile</label>
									<input id="emmail_login" name="username" type="text" class="form-control">
									<label for="password_login">Password</label>
									<input id="password_login" name="password" type="password" class="form-control">
									<p class="forgot-pass"><a href="forgot-password.php">Forgot your password?</a></p>
									<p class="forgot-pass"><a href="register.php">Create and account</a></p>
									<button class="button"><i class="fa fa-lock"></i>&nbsp; <span>Sign in</span></button>
								</div>
								</form>
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