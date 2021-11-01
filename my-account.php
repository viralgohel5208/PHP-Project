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

$page_title = "My Account";

if(isset($_POST['submit']))
{
	$item_id 			= $_SESSION['cu_customer_id'];
	$user_name 			= escapeInputValue($_POST['user_name']);
	$first_name 		= escapeInputValue($_POST['first_name']);
	$last_name 			= escapeInputValue($_POST['last_name']);
	$email 				= escapeInputValue($_POST['email']);
	$mobile 			= escapeInputValue($_POST['mobile']);
	$gender 			= escapeInputValue($_POST['gender']);
	$old_file_name 		= escapeInputValue($_POST['old_file_name']);
	
	if (isset($_POST['rm_file_name']))
	{
		$rm_file_name = 1;
	}
	else
	{
		$rm_file_name = 0;
	}

	
	mysqli_autocommit($link, FALSE);

	if($user_name == ""  || $first_name == ""  || $last_name == "" || $email == "" || $mobile == "")
	{
		$error = "Please enter all details";
	}
	else if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email))
	{
		$error = "Please enter valid email address";
	}
	else if (!preg_match("/^[0-9]*$/", $mobile))
	{
		$error = "Mobile no is invalid";
	}
	if($error == "")
	{
		if ( $error == "" && $_FILES[ 'file_name' ][ 'error' ] != 4 )
		{
			$image 				= $_FILES[ 'file_name' ][ 'name' ];
			$image_type 		= $_FILES[ 'file_name' ][ 'type' ];
			$image_size 		= $_FILES[ 'file_name' ][ 'size' ];
			$image_error 		= $_FILES[ 'file_name' ][ 'error' ];
			$image_tmp_name 	= $_FILES[ 'file_name' ][ 'tmp_name' ];

			$image_val = image_validation( $image, $image_type, $image_size, $image_error, $image_tmp_name );

			if ( $image_val[ 'error' ] == "" ) {
				$file_name = $image_val[ 'image' ];
			} else {
				$error = $image_val[ 'error' ];
			}
		}
		else if ( $rm_file_name == 1 )
		{
			$file_name = "";
		}
		else
		{
			$file_name = $old_file_name;
		}
	}
	
	if($error == "")
	{
		$query_1 = "SELECT id, email, mobile FROM customers WHERE (email = '$email' OR mobile = '$mobile') AND id != $item_id";
		
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
		$query_2 = "UPDATE `customers` SET `user_name` = '$user_name', `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$email', `mobile` = '$mobile', `gender` = '$gender', `file_name` = '$file_name', `updated_at` = '$current_datetime'  WHERE id = '$item_id' AND app_id = '$app_id'";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = $sww;
		}
	}
	
	if($error == "")
	{
		if($file_name != "" && $file_name != $old_file_name)
		{
			if($old_file_name != "" && file_exists("uploads/store-$app_id/customer-profile/" . $old_file_name))
			{
				unlink("uploads/store-$app_id/customer-profile/" . $old_file_name);
			}
			move_uploaded_file($image_tmp_name, "uploads/store-$app_id/customer-profile/" . $file_name);
		}
		if($rm_file_name == 1 && $old_file_name != "" && file_exists("uploads/store-$app_id/customer-profile/".$old_file_name))
		{
			unlink( "uploads/store-$app_id/customer-profile/".$old_file_name );
		}

		mysqli_autocommit($link, TRUE);
		$success = "Customer details has been updated successfully";
		unset($_POST);
	}
}


if(isset($_SESSION['cu_customer_id']))
{
	$item_id = $_SESSION['cu_customer_id'];
	$query_3 = "SELECT * FROM `customers` WHERE id = '$item_id' AND app_id = '$app_id'" ;
	$result_3 = mysqli_query( $link, $query_3);

	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			header( "Location:login.php" );
			exit;
		}
	}
	else
	{
		header( "Location:login.php" );
		exit;
	}
}
else
{
	header( "Location:login.php" );
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
							<li class="home"> <a title="Go to Home Page" href="index.php">Home</a><span>&raquo;</span>
							</li>
							<li class="category13"><strong>My Account</strong>
							</li>
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
								<h2>Update Profile</h2>
							</div>
							<?php require_once "message-block.php"; ?>
							<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
							<div class="box-border">
								
								<ul>
									
									<li class="row">
										<div class="col-sm-12">
											<label for="first_name" class="required">User Name</label>
											<input type="text" class="input form-control" name="user_name" value="<?php echo $row_3['user_name']; ?>" id="user_name">
										</div>
										<!--/ [col] -->
										
										<!--/ [col] -->
									</li>
									<li class="row">
										<div class="col-sm-6">
											<label for="first_name" class="required">First Name</label>
											<input type="text" class="input form-control" name="first_name" value="<?php echo $row_3['first_name']; ?>"id="first_name">
										</div>
										<!--/ [col] -->
										<div class="col-sm-6">
											<label for="last_name" class="required">Last Name</label>
											<input type="text" name="last_name" value="<?php echo $row_3['last_name']; ?>" class="input form-control" id="last_name">
										</div>
										<!--/ [col] -->
									</li>
									<!--/ .row -->
									<li class="row">
										
										<!--/ [col] -->
										<div class="col-sm-6">
											<label for="email_address" class="required">Email Address</label>
											<input type="text" class="input form-control" name="email" value="<?php echo $row_3['email']; ?>"id="email_address">
										</div>
										
										<div class="col-sm-6">
											<label for="company_name">Mobile no</label>
											<input type="text" name="mobile" value="<?php echo $row_3['mobile']; ?>" class="input form-control" id="mobile">
										</div>
										<!--/ [col] -->
									</li>
									<!--/ .row -->
									
									<li class="row">
										<!--/ [col] -->
										<div class="col-sm-6">
											<label class="required">Gender</label>
											<select class="input form-control" name="gender" id="gender">
												<?php 
												$setCustGender = setCustGender();
												foreach($setCustGender as $key => $value)
												{
													echo '<option value="'.$key.'"';
													if($key == $row_3['gender'])
													{
														echo ' selected="selected"';
													}
													echo '>'.$value.'</option>';
												}
												 ?>
												<!--<option value="0">Select Gender</option>
												<option value="1">Male</option>
												<option value="2">Female</option>
												<option value="3">Other</option>-->
											</select>
										</div>
										<!--/ [col] -->
										
										<div class="col-sm-6">
											<label for="postal_code" class="required">Created at</label><br />
											<?php echo $row_3['created_at']; ?>
										</div>
									</li>
									
									<li class="row">
										<!--/ [col] -->
										
										
										
										<div class="col-sm-6">
											<?php if($row_3['file_name'] != "" && file_exists("uploads/store-$app_id/customer-profile/".$row_3['file_name']))
											{ 
											?>

											<img src="uploads/store-<?php echo $app_id; ?>/customer-profile/<?php echo $row_3['file_name']; ?>" width="80px" class="img-circle"/>

											<label class="checkbox-inline ml10 mr20 mt20">
											<input type="checkbox" name="rm_file_name" value="1">Remove image
											</label>
											<br />
											<?php }else{ ?>
											<img src="images/default/user-avatar.png" width="80px" class="img-circle"/>
											<br />
											<?php } ?>
											
											<label for="company_name">Profile Picture</label>
											<input type="file" name="file_name" class="input form-control">
											<input type="hidden" name="old_file_name" value="<?php echo $row_3['file_name']; ?>">
										</div>
										<!--/ [col] -->
										
										
									</li>
									
									<!--/ .row -->

									<li>
										<button class="button" name="submit"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Save</span></button>
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