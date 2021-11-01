<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "app-details-include.php";

$page_title = "Contact Us";

if(isset($_POST['submit']))	
{

	$name 		    = escapeInputValue($_POST['name']);
	$email_id 		= escapeInputValue($_POST['email_id']);
	$phone	 		= escapeInputValue($_POST['phone']);
	$message 		= escapeInputValue($_POST['message']);
	
	if ( $name == "" || $email_id == "" || $phone == "" || $message == "")
	{
		$error = "Please enter all details";
	}
	else if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email_id))
	{
		$error = "Invalid email address";
	}
	else if (!preg_match("/^[0-9]*$/", $phone))
	{
		$error = "Phone is invalid";
	}
	
	if($error == "")
	{
		$res_email 		= mysqli_query($link, "SELECT * FROM app_details WHERE app_id = $app_id");
		$row_email 		= mysqli_fetch_assoc($res_email);
		$admin_email 	= $row_email['email_1'];
		$to 			= $admin_email;
		$subject 		= $application_name." Contact us";
		$email_message 	= "Name: ".$name."<br> \n";
		$email_message .= "Email: ".$email_id."<br> \n";
		$email_message .= "Phone: ".$phone."<br> \n";
		$email_message .= "Message: ".$message."<br> \n";
		$header 		= "From:".$email_id." \r\n";
		$header 		.= "MIME-Version: 1.0\r\n";
		$header 		.= "Content-type: text/html\r\n";
		if(mail ($to, $subject, $email_message, $header))
		{
			$success = "Your message Sent Successfully";
			unset($_POST);
		}
		else
		{
			$error = "Message Send Error, Please Try Again";
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

<body class="contact_us_page">
	
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
							<li class="category13"><strong>Contact Us</strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->

		<!-- Main Container -->
		<div class="main-container col1-layout" style="margin-bottom: 50px">
			<div class="main container">
				<div class="row">
					<section class="col-main col-sm-12">
						<div class="page-title">
							<h2>Contact Us</h2>
						</div>
						<div id="contact1" class="page-content page-contact">
							<!--<div id="message-box-conact">We're available for new projects</div>-->
							<div class="row">
								<div class="col-xs-12 col-sm-6" id="contact_form_map">
									<h3 class="page-subheading">Let's get in touch</h3>
									<!--<p>Lorem ipsum dolor sit amet onsectetuer adipiscing elit. Mauris fermentum dictum magna. Sed laoreet aliquam leo. Ut tellus dolor dapibus eget. Mauris tincidunt aliquam lectus sed vestibulum. Vestibulum bibendum suscipit mattis.</p>
									<br/>
									<ul>
										<li>Praesent nec tincidunt turpis.</li>
										<li>Aliquam et nisi risus.&nbsp;Cras ut varius ante.</li>
										<li>Ut congue gravida dolor, vitae viverra dolor.</li>
									</ul>-->
									<br/>
									<?php 
									$get_admin_contact_us = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM app_details WHERE app_id = $app_id"));
									?>
									<ul class="store_info">
										<li><i class="fa fa-home"></i><?php echo $get_admin_contact_us["address"]; ?></li>
										<li><i class="fa fa-phone"></i><span><?php echo $get_admin_contact_us["mobile_1"]; ?></span>
										</li>
										<!--<li><i class="fa fa-fax"></i><span>+39 0035 356 765</span>
										</li>-->
										<li><i class="fa fa-envelope"></i>Email: <span><a href="mailto:<?php echo $get_admin_contact_us["email_1"]; ?>"><?php echo $get_admin_contact_us["email_1"]; ?></a></span>
										</li>
									</ul>
								</div>
								<div class="col-sm-6">
									<form class="th-formgetintouch"  method="post" style="background-color: none;">
									<h3 class="page-subheading">Make an enquiry</h3>
									<?php require_once "message-block.php"; ?>	
									<div class="contact-form-box">
										<div class="form-selector">
											<label>Name</label>
											<input type="text" class="form-control input-sm" id="name" name="name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; } ?>" />
										</div>
										<div class="form-selector">
											<label>Email</label>
											<input type="text" class="form-control input-sm" id="email_id" name="email_id" value="<?php if(isset($_POST['email_id'])) { echo $_POST['email_id']; } ?>" />
										</div>
										<div class="form-selector">
											<label>Phone</label>
											<input type="text" class="form-control input-sm" id="phone" name="phone" value="<?php if(isset($_POST['phone'])) { echo $_POST['phone']; } ?>" />
										</div>
										<div class="form-selector">
											<label>Message</label>
											<textarea class="form-control input-sm" rows="10" id="message" name="message" ><?php if(isset($_POST['message'])) { echo $_POST['message']; } ?></textarea>
										</div>
										<div class="form-selector">
											<br />
											<button class="button" name="submit" id="submit"><i class="fa fa-send"></i>&nbsp; <span>Send Message</span></button> &nbsp; <!--<a href="#" class="button">Clear</a>--> </div>
										
									</div>
									</form>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
		<!-- Main Container End -->
		
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