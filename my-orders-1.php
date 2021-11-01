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

$page_title = "My Orders";

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
							<li class="category13"><strong>My Orders</strong></li>
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
								<h2>My Orders</h2>
							</div>
							<div class="box-border">
								<div class="table-responsive">
									<h4>Order Number: #123231 <button onclick="window.location = 'my-orders-view.php?id='" class="button" style="float: right; padding: 4px 10px; margin-top: 0"><i class="fa fa-pencil"></i>&nbsp; <span>View Details</span></button></h4>
									<table class="table table-bordered cart_summary">
										<thead>
											<tr>
												<th class="cart_product">Product</th>
												<th>Description</th>
												<th>Avail.</th>
												<th>Unit price</th>
												<th>Qty</th>
												<th>Total</th>
												<th class="action"><i class="fa fa-trash-o"></i>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="cart_product"><a href="#"><img src="images/products/img02.jpg" alt="Product"></a>
												</td>
												<td class="cart_description">
													<p class="product-name"><a href="#">Frederique Constant </a>
													</p>
													<small><a href="#">Color : Beige</a></small><br>
													<small><a href="#">Size : S</a></small>
												</td>
												<td class="cart_avail"><span class="label label-success">In stock</span>
												</td>
												<td class="price"><span>$60.99 </span>
												</td>
												<td class="qty"><input class="form-control input-sm" type="text" value="1">
												</td>
												<td class="price"><span>$60.99 </span>
												</td>
												<td class="action"><a href="#"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
											<tr>
												<td class="cart_product"><a href="#"><img src="images/products/img01.jpg" alt="Product"></a>
												</td>
												<td class="cart_description">
													<p class="product-name"><a href="#">Frederique Constant </a>
													</p>
													<small><a href="#">Color : Beige</a></small><br>
													<small><a href="#">Size : S</a></small>
												</td>
												<td class="cart_avail"><span class="label label-success">In stock</span>
												</td>
												<td class="price"><span>$99.19 </span>
												</td>
												<td class="qty"><input class="form-control input-sm" type="text" value="1">
												</td>
												<td class="price"><span>$99.19 </span>
												</td>
												<td class="action"><a href="#"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="2" rowspan="2"></td>
												<td colspan="3">Total products (tax incl.)</td>
												<td colspan="2">$160.88 </td>
											</tr>
											<tr>
												<td colspan="3"><strong>Total</strong>
												</td>
												<td colspan="2"><strong>$160.88 </strong>
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
								
								<div class="table-responsive">
									<h4>Order Number: #123231 <button onclick="window.location = 'my-orders-view.php?id='" class="button" style="float: right; padding: 4px 10px; margin-top: 0"><i class="fa fa-pencil"></i>&nbsp; <span>View Details</span></button></h4>
									<table class="table table-bordered cart_summary">
										<thead>
											<tr>
												<th class="cart_product">Product</th>
												<th>Description</th>
												<th>Avail.</th>
												<th>Unit price</th>
												<th>Qty</th>
												<th>Total</th>
												<th class="action"><i class="fa fa-trash-o"></i>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="cart_product"><a href="#"><img src="images/products/img02.jpg" alt="Product"></a>
												</td>
												<td class="cart_description">
													<p class="product-name"><a href="#">Frederique Constant </a>
													</p>
													<small><a href="#">Color : Beige</a></small><br>
													<small><a href="#">Size : S</a></small>
												</td>
												<td class="cart_avail"><span class="label label-success">In stock</span>
												</td>
												<td class="price"><span>$60.99 </span>
												</td>
												<td class="qty"><input class="form-control input-sm" type="text" value="1">
												</td>
												<td class="price"><span>$60.99 </span>
												</td>
												<td class="action"><a href="#"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
											<tr>
												<td class="cart_product"><a href="#"><img src="images/products/img01.jpg" alt="Product"></a>
												</td>
												<td class="cart_description">
													<p class="product-name"><a href="#">Frederique Constant </a>
													</p>
													<small><a href="#">Color : Beige</a></small><br>
													<small><a href="#">Size : S</a></small>
												</td>
												<td class="cart_avail"><span class="label label-success">In stock</span>
												</td>
												<td class="price"><span>$99.19 </span>
												</td>
												<td class="qty"><input class="form-control input-sm" type="text" value="1">
												</td>
												<td class="price"><span>$99.19 </span>
												</td>
												<td class="action"><a href="#"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="2" rowspan="2"></td>
												<td colspan="3">Total products (tax incl.)</td>
												<td colspan="2">$160.88 </td>
											</tr>
											<tr>
												<td colspan="3"><strong>Total</strong>
												</td>
												<td colspan="2"><strong>$160.88 </strong>
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
								
							</div>
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