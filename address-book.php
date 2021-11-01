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

$page_title 	= "Address Book";
$item_id	 	= $_SESSION['cu_customer_id'];

if(isset($_POST['delete_id']))
{
    $id = $_POST['delete_id'];
	$result = "DELETE FROM customers_address WHERE id = '".$id."'";
	if(mysqli_query($link, $result))
	{
		$success = "User Addresses been deleted successfully";
	} 
	else
	{
		$error = $sww;
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
							<li class="category13"><strong>Address Book</strong>
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
								<h2>Address Book 
									<button class="button" onclick="window.location='address-book-add.php'" style="float: right"><i class="fa fa-plus"></i>&nbsp; <span>Add New Address</span></button>
								</h2>
							</div>
							<?php require_once "message-block.php"; ?>
							<div class="">
								<div class="row">
									<?php 
									$result = mysqli_query($link, "SELECT * FROM customers_address where customer_id = '$item_id' AND app_id = '$app_id'"); 
									?>
									<?php if(mysqli_num_rows($result) == 0){ ?>
									<div class="panel-body">
											<h4>No addresses found.</h4>
									</div>
									<?php } ?>
									<?php
									if(mysqli_num_rows($result) > 0)
									{
										$i = 1;
										$j = 1;
										while($row = mysqli_fetch_array($result))
										{
									?>
										<div class="col-lg-6 box-border">
										<button class="button" onclick="window.location='address-book-update.php?id=<?php echo $row['id']; ?>'" style="float: right; padding: 4px 10px; margin-top: 0"><i class="fa fa-pencil"></i>&nbsp; <span>Edit Address</span></button>
										<h4><?php if($row['address_name'] != "") { echo $row['address_name']; } else { echo 'No Name'; } ?></h4>
										<table class="table">
											<thead>
												<tr>
													<th colspan="2">
														<div class="widget-menu pull-right">
															<button class="button" onClick="del_user_add('<?php echo $row['id']; ?>')"  style="float: right; padding: 4px 10px; margin-top: 0"><i class="fa fa-trash"></i>&nbsp; <span>Delete</span></button>
															
														</div>
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>First Name</td>
													<td><?php echo $row['first_name']; ?></td>
												</tr>
												<tr>
													<td>Last Name</td>
													<td><?php echo $row['last_name']; ?></td>
												</tr>
												<tr>
													<td>Email</td>
													<td><?php echo $row['email']; ?></td>
												</tr>
												<tr>
													<td>Mobile</td>
													<td><?php echo $row['mobile']; ?></td>
												</tr>
												<tr>
													<td>Address</td>
													<td><span class="wrapping-text"><?php echo $row['address']; ?></span></td>
												</tr>
												<tr>
													<td>City</td>
													<td><?php echo $row['city_name']; ?></td>
												</tr>
												<tr>
													<td>State</td>
													<td><?php echo $row['state_name']; ?></td>
												</tr>
												<tr>
													<td>Country</td>
													<td><?php echo $row['country_name']; ?></td>
												</tr>
												<tr>
													<td>Landmark</td>
													<td><?php echo $row['landmark']; ?></td>
												</tr>
												<tr>
													<td>Pincode</td>
													<td><?php echo $row['pincode']; ?></td>
												</tr>
												<tr>
													<td style="width: 130px;">Added Date</td>
													<td><?php echo formatDate($row['created_at']); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
									<?php
									$i++;
									$j++;
									}
								}
								?>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</section>
		<form id="delete_form" action="address-book.php" method="post" style="display: hidden">
		<input type="hidden" id="delete_id" name="delete_id" value="">
	</form>
		
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
	<script type="text/javascript">
		
		function del_user_add(x)
		{
			if(confirm("Are You sure you want to delete address ?"))
			{
				$("#delete_id").val(x);
				$("#delete_form").submit();
			}        
		}

	</script>
</body>
</html>