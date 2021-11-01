<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "Register";

if(isset($_POST['first_name']))	
{

	$user_name	 	= escapeInputValue($_POST['user_name']);
	$first_name 	= escapeInputValue($_POST['first_name']);
	$last_name 		= escapeInputValue($_POST['last_name']);
	$email 			= strtolower(escapeInputValue($_POST['email']));
	$mobile 		= escapeInputValue($_POST['mobile']);
	$n_password 	= escapeInputValue($_POST['n_password']);
	$r_password 	= escapeInputValue($_POST['r_password']);
	
	if ( $user_name == "" || $first_name == "" || $n_password == "" || $r_password == "" || $mobile == "" )
	{
		$error = "Please enter all details";
	}
	else if (!preg_match("/^[a-zA-Z]*$/", $user_name))
	{
		$error = "User name is invalid";
	}
	else if (!preg_match("/^[a-zA-Z]*$/", $first_name))
	{
		$error = "First name is invalid";
	}
	else if (!preg_match("/^[a-zA-Z]*$/", $last_name))
	{
		$error = "Last name is invalid";
	}
	else if($email != "" && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email))
	{
		$error = "Invalid email address";
	}
	else if (!preg_match("/^[0-9]*$/", $mobile))
	{
		$error = "Mobile no is invalid";
	}
	else if ( $n_password != $r_password )
	{
		$error = "Enter password correctly two times";
	}
	else if(strlen($n_password) < 6)
	{
		$error = "Password must be minimum 6 character long";
	}
	
	if($error == "")
	{
		$query_1 = "SELECT id, email, mobile FROM customers WHERE email = '$email' OR mobile = '$mobile'";
		
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = $sww;
		}
		else if (mysqli_num_rows($result_1) > 0)
		{
			$row_1 = mysqli_fetch_assoc($result_1);
			$email_db = $row_1['email'];
			$mobile_db = $row_1['mobile'];
			if($email_db == $email)
			{
				$error = "Customer email already exists";
			}
			else
			{
				$error = "Customer mobile no already exists";
			}
		}
	}

	if($error == "")
	{
		//$password 	= md5( $n_password );
		$password	= passwordEncyption($n_password, 'e');

		$query_2 = "INSERT INTO `customers`(`app_id`, `user_name`, `first_name`, `last_name`, `email`, `mobile`, `password`, `otp_code`, `otp_expiry_time`, `created_at`, `status`) VALUES ( '$app_id', '$user_name', '$first_name', '$last_name', '$email', '$mobile', '$password', NULL, NULL, '$current_datetime', 1)";

		$result_2 = mysqli_query( $link, $query_2 );
		if($result_2)
		{

			$user_id = mysqli_insert_id($link);
			$_SESSION["cu_user_name"] 	= $user_name;
			$_SESSION["cu_customer_id"]	= $user_id;
			$_SESSION["cu_login"] 		= "YES";

			$success = "Customers has been registered successfully";
			unset($_POST);
			header("Location:index.php");
			exit;

		}
		else
		{
			$error = $sww;
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
							<li class="category13"><strong>Create an Account</strong>
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
									<h2>Create an Account</h2>
								</div>
								<?php require_once "message-block.php"; ?>
								<form class="login-form" method="post">
								<div class="box-authentication">
									<h3>Register</h3>
									<?php //if($error != "") { echo '<p style="color:#f27c66">'.$error.'</p>'; } ?>
									
									<label for="emmail_register">User Name*</label>
									<input type="text" class="form-control" name="user_name" value="<?php if(isset($_POST['user_name'])) { echo $_POST['user_name']; } ?>">
									
									<label for="emmail_register">First Name*</label>
									<input type="text" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name']; } ?>">
									
									<label for="emmail_register">Last Name*</label>
									<input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name']; } ?>">
									
									<label for="emmail_register">Email </label>
									<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
									
									<label for="emmail_register">Mobile*</label>
									<input type="text" class="form-control" name="mobile" value="<?php if(isset($_POST['mobile'])) { echo $_POST['mobile']; } ?>">
									
									<label for="emmail_register">Password*</label>
									<input type="password" class="form-control" name="n_password" value="<?php if(isset($_POST['n_password'])) { echo $_POST['n_password']; } ?>">
									
									<label for="emmail_register">Confirm password*</label>
									<input type="password" class="form-control" name="r_password" value="<?php if(isset($_POST['r_password'])) { echo $_POST['r_password']; } ?>">
									
									<p class="forgot-pass"><a href="login.php">Already registered?</a></p>
									<button class="button"><i class="fa fa-user"></i>&nbsp; <span>Create an account</span></button>
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