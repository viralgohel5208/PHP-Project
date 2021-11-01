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

$page_title = "Address Book Update";

if(isset($_POST['address_book_update']))	
{
	$address_id		= escapeInputValue($_GET['id']);
	$customer_id 	= $_SESSION['cu_customer_id'];
	$address_name	= escapeInputValue($_POST['address_name']);
	$first_name 	= escapeInputValue($_POST['first_name']);
	$last_name 		= escapeInputValue($_POST['last_name']);
	$email 			= strtolower(escapeInputValue($_POST['email']));
	$mobile 		= escapeInputValue($_POST['mobile']);
	$address	 	= escapeInputValue($_POST['address']);
	$country_id 	= escapeInputValue($_POST['country_id']);
	$state_id	 	= escapeInputValue($_POST['state_id']);
	$city_id	 	= escapeInputValue($_POST['city_id']);
	$landmark	 	= escapeInputValue($_POST['landmark']);
	$pincode	 	= escapeInputValue($_POST['pincode']);
	

	if ( $address_id == "" || $customer_id == "" || $address_name == "" || $first_name == "" || $address == "" || $country_id == "" ||  $state_id == "" ||  $city_id == "" ||  $mobile == "" )
	{
		$error = "Please enter all details";
	}
	else if($email != "" && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email))
	{
		$error = "Invalid email address";
	}
	else if (!preg_match("/^[0-9]*$/", $mobile))
	{
		$error = "Mobile no is invalid";
	}
	
	if($error == "")
	{
		$pro_query = "SELECT id FROM customers_address WHERE app_id = '$app_id' AND customer_id = '$customer_id' AND id = '$address_id' LIMIT 1";
		$result = mysqli_query($link, $pro_query);
		if(!$result)
		{
			$error = $sww;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			$error = 'Address details does not found';
		}
		else
		{
			//$row = mysqli_fetch_assoc($result);
		}
	}
	
	if($error == "")
	{
		$pro_query = "SELECT id FROM customers_address WHERE app_id = '$app_id' AND customer_id = $customer_id  AND address_name = '$address_name' AND id != $address_id LIMIT 1";

		$result = mysqli_query($link, $pro_query);
		if(!$result)
		{
			$error = $sww;
		}
		else if(mysqli_num_rows($result) > 0)
		{
			$error = '2Please use different address name';;
		}
	}
	
	if($error == "")
	{
		$q_11 = "SELECT A.id as city_id, A.city_name, A.state_id, B.state_name, A.country_id, C.nicename as country_name FROM `cities_list` AS A INNER JOIN states AS B ON B.id = A.state_id INNER JOIN countries as C ON C.id = A.country_id WHERE A.id = $city_id LIMIT 1";
		
		$r_11 = mysqli_query( $link, $q_11 );

		if ( !$r_11 )
		{
			$error = $sww;
		}
		else
		{
			if ( mysqli_num_rows( $r_11 ) == 0 )
			{
				$error = "Invalid city details";
			}
			else
			{
				$row_c = mysqli_fetch_assoc($r_11);
				$city_id = $row_c['city_id'];
				$city_name = $row_c['city_name'];
				$state_id = $row_c['state_id'];
				$state_name = $row_c['state_name'];
				$country_id = $row_c['country_id'];
				$country_name = $row_c['country_name'];
			}
		}
	}

	if($error == "")
	{
		$query_1 = "UPDATE `customers_address` SET `address_name` = '$address_name', `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$email', `mobile` = '$mobile', `address` = '$address', `city_id` = '$city_id', `city_name` = '$city_name', `state_id` = '$state_id', `state_name` = '$state_name', `country_id` = '$country_id', `country_name` = '$country_name', `landmark` = '$landmark', `pincode` = '$pincode',  `updated_date` = '$current_datetime' WHERE id = $address_id AND app_id = $app_id";

		$result_2 = mysqli_query( $link, $query_1 );
		if($result_2)
		{
			unset($_POST);
			$success = "Customer address has been update successfully";
		}
		else
		{
			$error = $sww;
		}
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);
	$query_3 = "SELECT * FROM `customers_address` WHERE id = '$item_id' AND app_id = '$app_id'" ;
	$result_3 = mysqli_query( $link, $query_3);

	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			header( "Location:address-book.php" );
			exit;
		}
	}
	else
	{
		header( "Location:address-book.php" );
		exit;
	}
}
else
{
	header( "Location:address-book.php" );
	exit;
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
							<li class="home"> <a title="My Account" href="address-book.php">Address Book</a><span>&raquo;</span></li>
							<li class="category13"><strong>Update</strong></li>
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
								<h2>Address Book Update</h2>
							</div>
							<?php require_once "message-block.php"; ?>
							<form class="login-form" method="post">
							<div class="box-border">
								<ul>
									<li class="row">
										<div class="col-sm-12">
											<label for="emmail_register">Address Name*</label>
											<input type="text" class="form-control" name="address_name" value="<?php if(isset($_POST['address_name'])) { echo $_POST['address_name']; } else { echo $row_3['address_name']; } ?>">
										</div>
									</li>
									
									<li class="row">
										<div class="col-sm-6">
											<label for="emmail_register">First Name*</label>
											<input type="text" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name']; } else { echo $row_3['first_name']; } ?>">
										</div>
										<!--/ [col] -->
										<div class="col-sm-6">
											<label for="emmail_register">Last Name*</label>
											<input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name']; } else { echo $row_3['last_name']; } ?>">
										</div>
										<!--/ [col] -->
									</li>
									<!--/ .row -->
									<li class="row">
										<div class="col-sm-6">
											<label for="emmail_register">Email*</label>
											<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } else { echo $row_3['email']; } ?>">
										</div>	
										<!--/ [col] -->
										<div class="col-sm-6">
											<label for="emmail_register">Mobile*</label>
											<input type="text" class="form-control" name="mobile" value="<?php if(isset($_POST['mobile'])) { echo $_POST['mobile']; } else { echo $row_3['mobile']; } ?>">
										</div>
										<!--/ [col] -->
									</li>
									<!--/ .row -->
									<li class="row">
										<div class="col-xs-12">
											<label for="address" class="required">Address*</label>
											<textarea class="input form-control" name="address" rows="3" ><?php if(isset($_POST['address'])) { echo $_POST['address']; } else { echo $row_3['address']; } ?></textarea>
											
										</div>
										<!--/ [col] -->

									</li>
									<!-- / .row -->

									<li class="row">
										<div class="col-sm-6">
											<label class="required">Country*</label>
											<select name="country_id" id="country_id" class="form-control" onChange="getStatesList(this.value)">
												<option value="0">Select Country ...</option>
												<?php 
												$query = "SELECT id, nicename, iso3 FROM countries ORDER BY nicename";
												$result = mysqli_query($link, $query);
												while($row = mysqli_fetch_assoc($result))
												{
													echo '<option value="'.$row['id'].'"';
													if(isset($_POST['country_id'])) {
														if($_POST['country_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													} else {
														//echo ' selected="selected"';
														if($row_3['country_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row['nicename'].' ('.$row['iso3'].')</option>';
												}
												?>
											</select>
										</div>
										<!--/ [col] -->
										<div class="col-sm-6">
											<label class="required">State*</label>
											<select name="state_id" id="states-list" class="form-control" onChange="getCitiesList(this.value);">
												<option value="0">Select State ...</option>
												<?php 
												$query = "SELECT id, state_name FROM states WHERE country_id = ".$row_3['country_id']." ORDER BY state_name";
												$result = mysqli_query($link, $query);
												while($row = mysqli_fetch_assoc($result))
												{
													echo '<option value="'.$row['id'].'"';
													if(isset($_POST['category_id'])) {
														if($_POST['category_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													} else {
														if($row_3['state_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row['state_name'].'</option>';
												}
												?>
											</select>
										</div>
										<!--/ [col] -->
									</li>
									<!--/ .row -->

									<li class="row">
										<div class="col-sm-6">
											<label class="required">City*</label>
											<select name="city_id" id="cities-list" class="form-control">
											<option value="">Select City ...</option>
											<?php 
											$query = "SELECT id, city_name FROM cities_list WHERE state_id = ".$row_3['state_id']." ORDER BY city_name";
											$result = mysqli_query($link, $query);
											while($row = mysqli_fetch_assoc($result))
											{
												echo '<option value="'.$row['id'].'"';
												if(isset($_POST['city_id'])) {
													if($_POST['city_id'] == $row['id']) {
														echo ' selected="selected"';
													}
												} else {
													if($row_3['city_id'] == $row['id']) {
														echo ' selected="selected"';
													}
												}
												echo '>'.$row['city_name'].'</option>';
											}
											?>
											</select>
										</div>
										<!--/ [col] -->

										<div class="col-sm-6">
											<label for="telephone" class="required">Landmark*</label>
											<input class="input form-control" type="text" name="landmark" value="<?php if(isset($_POST['landmark'])) { echo $_POST['landmark']; } else { echo $row_3['landmark']; } ?>" id="landmark">
										</div>
										<!--/ [col] -->
									</li>
									<!--/ .row -->
									<li class="row">
										<div class="col-sm-6">
											<label for="telephone" class="required">Pincode*</label>
											<input class="input form-control" type="text" name="pincode" value="<?php if(isset($_POST['pincode'])) { echo $_POST['pincode']; } else { echo $row_3['pincode']; } ?>" id="pincode">
											
										</div>
										<!--/ [col] -->
									</li>
									<li>
										<button class="button" name="address_book_update"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Save</span></button>
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
	<script>
	function getStatesList(x)
	{
		$.ajax({
			type: "POST",
			url: "functions-ajax-general.php",
			data: 'type=6&country_id='+x,
			success: function(data){
				$("#states-list").html(data);
				$("#cities-list").html('<option value="">Select City ...</option>');
			}
		});
	}

	function getCitiesList(x)
	{
		$.ajax({
			type: "POST",
			url: "functions-ajax-general.php",
			data: 'type=7&state_id='+x,
			success: function(data){
				$("#cities-list").html(data);
			}
		});
	}
	</script>
	
</body>
</html>