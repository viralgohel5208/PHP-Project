<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "login-required.php";
require_once "app-details-include.php";

$page_title = "Reset Password";


if(isset($_POST['save_password']))
{
	if(isset($_SESSION['cu_customer_id']))
	{	
		$item_id = $_SESSION['cu_customer_id'];
		$result2 = mysqli_query($link,"select * from customers where id = '$item_id' AND app_id = '$app_id'");
		if(mysqli_num_rows($result2) > 0)
		{
			
			$row2 = mysqli_fetch_assoc($result2);
			$c_password = $_POST['c_password'];
			$n_password = $_POST['n_password'];
			$r_password = $_POST['r_password'];

			if($row2['password'] != passwordEncyption($c_password, 'e'))
			{
				$error = "Current Password is wrong";
			}
			if($n_password == "" || $r_password == "")
			{
				$error = "Please enter password";
			}
			else if(strlen($n_password) < 6)
			{
				$error = "Password must be 6 character long";
			}
			else if($n_password != $r_password)
			{
				$error = "Enter new password correctly two times";
			}
			else if($error == "")
			{

				$passwordEncyption = passwordEncyption($n_password, 'e');
				$query_4 =  "UPDATE customers SET password = '".$passwordEncyption."' WHERE id = '".$item_id."' AND app_id = '$app_id'";
				$result = mysqli_query($link, $query_4);

				if(!$result)
				{
					$error = $sww;
				}
				else
				{
					$success = "Password updated successfully";
				}
			}
		}
		else
		{
			$error = $sww;
		}
	}
	else
	{
		header( "Location:login.php" );
		exit;
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

<body class="wishlist_page">
	
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
							<li class="home"> <a title="My Account" href="my-account.php">My Account</a><span>&raquo;</span></li>
							<li class="category13"><strong>Reset Password</strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->
		
		<!-- Main Container -->
		<section class="main-container col2-right-layout">
			<div class="main container">
				<div class="row">
					<aside class="left sidebar col-sm-3 col-xs-12">
						<?php require_once "include/account-sidebar.php"; ?>
					</aside>
					<div class="col-main col-sm-9">
						<div class="my-account checkout-page">
							<div class="page-title">
								<h2>Reset Password</h2>
							</div>
							<?php require_once "message-block.php"; ?>
							<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
							<div class="box-border">
								
								<ul>
									
									<li class="row">
										<div class="col-sm-6">
											<label for="first_name" class="required">Current Password</label>
											<input type="password" class="input form-control" name="c_password" id="c_password" >
										</div>
										
									</li>
									
									<li class="row">
										<div class="col-sm-6">
											<label for="first_name" class="required">New Password</label>
											<input type="password" class="input form-control" name="n_password"  >
										</div>
									</li>
									
									<li class="row">
										<div class="col-sm-6">
											<label for="first_name" class="required">Re-type Password</label>
											<input type="password" class="input form-control" name="r_password"  >
										</div>
									</li>
									
									
									<li>
										<button class="button" name="save_password"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Save</span></button>
									</li>
								</ul>
							</div>
							</form>	
						</div>
					</div>
					
				</div>
			</div>
		</section>

		
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