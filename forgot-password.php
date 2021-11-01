<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "Forgot Password";

$current_datetime 	= date("Y-m-d H:i:s");

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


if(isset($_POST['mobile_no']))
{

	$mobile_no 				= escapeInputValue($_POST['mobile_no']);
	
	if($mobile_no == "" )
	{
		$error = "Please enter Mobile no";
	}
	elseif(!preg_match("/^[0-9]*$/", $mobile_no))
	{
		$error = 'Mobile no is invalid';
	}
	else
	{			
		$result = mysqli_query($link, "select * from customers where mobile = '$mobile_no' AND app_id = '$app_id'");
		if(mysqli_num_rows($result) > 0 )
		{
			$verif_code 	= rand(1000,9999);
			$exp_time    	= date('Y-m-d H:i:s', strtotime("+2 hours"));

			$sql = mysqli_query($link, "UPDATE customers SET otp_code ='$verif_code',otp_expiry_time = '$exp_time' WHERE mobile = '$mobile_no' AND app_id = '$app_id'");
			if($sql)
			{
				
				$application_name = str_replace(' ', '_', $application_name);
				$file = file_get_contents("http://panel.adcomsolution.in/http-api.php?username=varun&password=varun123&senderid=LIECOM&route=1&number=+91".$mobile_no."&message=Welcome%20To%20".$application_name.",Your%20Registration%20Confirmation%20OTP%20is%20".$verif_code."%20");
				$mobile_no_decode 	= safe_decode($mobile_no);
				$verif_code_decode 	= safe_decode($verif_code);
				header("Location: forgot-password.php?verif=1&mobile_no=$mobile_no_decode&otp=$verif_code_decode");
				exit;
			}
			else
			{
				$error = $sww;
			}
		}
		else
		{
			$error =  "Please enter correct Mobile no";
		}
	}
}

//// second step

if(isset($_POST['reset']))
{
	$mobile_no 	= safe_encode($_GET['mobile_no']);
	$otp		= escapeInputValue($_POST['otp']);
	$n_password = escapeInputValue($_POST['n_password']);
	$r_password = escapeInputValue($_POST['r_password']);

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
	else
	{	
		$result2 	= mysqli_query($link,"select * from customers where mobile = '$mobile_no' AND app_id = '$app_id'");
		$row2 		= mysqli_fetch_assoc($result2);
		$current 	= date('Y-m-d H:i:s');
		if($otp == $row2['otp_code'])
		{
			if($current < $row2['otp_expiry_time'])
			{
				//$password = md5($n_password);
				$password	= passwordEncyption($n_password, 'e');
				$result = mysqli_query($link, "UPDATE customers SET password = '$password',otp_code = '',otp_expiry_time = '' WHERE mobile = '$mobile_no' AND app_id = '$app_id'");
				if($result)
				{
					header("Location: login.php");
				}
				else
				{
					$error =  "Query Error. PLease try later";
				}
			}
			else
			{
				$error =  "Your Otp Is Expired";
			}
		}
		else
		{
			$error = "Please Enter Correct OTP";
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
							<li class="category13"><strong>Forgot Password</strong>
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
									<h2>Forgot Password</h2>
								</div>
								<?php require_once "message-block.php"; ?>
								<form class="login-form" method="post">
								<?php if(isset($_GET['verif']) && $_GET['verif'] == 1 && isset($_GET['mobile_no']) && isset($_GET['otp']) )
								{ ?>
								<div class="box-authentication">
									<h3>Reset Your Password</h3>
									<?php // if($error != "") { echo '<p style="color:#f27c66">'.$error.'</p>'; } ?>
										
									<label for="emmail_register">OTP</label>
									<input id="emmail_register" type="text" name="otp" class="form-control">	
									
									<label for="emmail_register">New Password</label>
									<input id="emmail_register" type="password" name="n_password" class="form-control">
									
									<label for="emmail_register">Confirm Password</label>
									<input id="emmail_register" type="password" name="r_password" class="form-control">	
										
									<p class="forgot-pass"><a href="login.php">Already Registered?</a></p>
									<button class="button" name="reset"><i class="fa fa-envelope"></i>&nbsp; <span>Send</span></button>
								</div>	
									
								<?php } else { ?>
									<div class="box-authentication">
									<h3>Reset Your Password</h3>
									<?php // if($error != "") { echo '<p style="color:#f27c66">'.$error.'</p>'; } ?>
									<p>Please enter your Mobile no. An Mobile no will be sent to you if your Mobile no is found with any account.</p>
									<label for="emmail_register">Mobile no</label>
									<input id="emmail_register" type="text" name="mobile_no" class="form-control">
									<p class="forgot-pass"><a href="login.php">Already Registered?</a></p>
									<button class="button"><i class="fa fa-envelope"></i>&nbsp; <span>Send</span></button>
								</div>
								<?php } ?>
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