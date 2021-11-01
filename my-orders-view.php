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

$page_title = "Order Details";

if(!isset($_REQUEST['order']))
{
	$error_code = 1; $error_string = 'Order does not found';
	$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
}
else
{
	//$app_id 		= $_SESSION['app_id'];
	//$customer_id 	= $_SESSION['customer_id'];
	$order_number 		= safe_decode(escapeInputValue($_REQUEST['order']));
	
	if($order_number == "")
	{
		$error_code = 2; $error_string = 'Order does not found';
		$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM orders WHERE app_id = $app_id AND customer_id = $customer_id AND order_number = '$order_number'";
	//exit;
	$result = mysqli_query($link, $query);
	if(!$result)
	{
		$error_code = 33; $error_string = $sww;
		$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 2; $error_string = 'Order does not found';
		$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
	}
	else
	{
		$order_main = mysqli_fetch_assoc($result);
		//print_r($order_main);
		
		$order_id 		= $order_main['id'];
		$address_id 	= $order_main['address_id'];
		$store_id 		= $order_main['store_id'];
		
		/*$query_2 = "SELECT * FROM order_details WHERE order_id = '$order_id'";
		
		$result_2 = mysqli_query($link, $query_2);
		
		if(!$result_2)
		{
			$error_code = 4; $error_string = $sww;
			$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
		}
		else
		{
			$order_details = [];
			while($row_2 = mysqli_fetch_assoc($result_2))
			{
				$row_2['product'] 			= [];
				$row_2['offer_discount'] 	= [];
					
				$product_id 	= $row_2['product_id'];
				$variant_id 	= $row_2['variant_id'];
				
				$query_3 = "SELECT products.id AS product_id, products.brand_name, products.product_name, products.file_name, V.id AS variant_id, V.measure_type, V.net_measure FROM products INNER JOIN products_variant AS V ON products.id = V.product_id WHERE V.id = '$variant_id'";
				
				$result_3 = mysqli_query($link, $query_3);
				
				if(!$result_3)
				{
					$error_code = 5; $error_string = $sww;
					$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
				}
				else
				{
					$row_3 = mysqli_fetch_assoc($result_3);
					
					$row_2['product'] = $row_3;
				}
				
				if($error_code == 0)
				{
					if($row_2['offer_reference'] == '')
					{
						$offer_discount['offer_type'] = '1';
						$offer_discount['offer_details'] = [];
					}
					else
					{
						$ex_offer_reference = explode(':', $row_2['offer_reference']);
						$offer_on 		= $ex_offer_reference[0];
						$offer_type 	= $ex_offer_reference[1];
						$offer_value 	= $ex_offer_reference[2];
						
						if($offer_type == 1)
						{
							$offer_discount['offer_type'] 		= '1';
							$offer_discount['offer_details'] 	= ['offer_percent' => $offer_value];
						}
						else if($offer_type == 2)
						{
							$ex_offer_value = explode(',', $offer_value);
							$product_id_free 		= $ex_offer_value[0];
							$variant_id_free 		= $ex_offer_value[1];

							$query4 = "SELECT P.id AS product_id, P.brand_name, P.product_name, P.file_name, V.id AS variant_id, V.measure_type, V.net_measure FROM products AS P INNER JOIN products_variant AS V ON P.id = V.product_id WHERE V.id = '$variant_id_free' AND V.product_id = '$product_id_free'";

							$result4 = mysqli_query($link, $query4);

							if(!$result4)
							{
								$error_code = 6; $error_string = $sww;
								$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
							}
							else
							{
								$row4 = mysqli_fetch_assoc($result4);

								$offer_discount['offer_type'] 		= '2';
								$offer_discount['offer_details'] 	= $row4;
							}
						}

					}
					$row_2['offer_discount'] = $offer_discount;
				}

				$order_details[] = $row_2;
			}
		}
		
		$order_main['order_details'] = $order_details;
		*/
	}
}

if($error_code == 0 && $address_id != 0 && $address_id != NULL)
{
	$query = "SELECT * FROM customers_address WHERE id = '$address_id'";
	
	$result = mysqli_query($link, $query);
	
	if(!$result)
	{
		$error_code = 7; $error_string = $sww;
		$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
	}
	
	$addresses = mysqli_fetch_assoc($result);
}

if($error_code == 0)
{
	$query = "SELECT * FROM stores WHERE id = '$store_id'";
	
	$result = mysqli_query($link, $query);
	if(!$result)
	{
		$error_code = 8; $error_string = $sww;
		$_SESSION['msg_error_fr'] = $error_code.". ".$error_string; header("Location:my-orders.php"); exit;
	}
	else
	{
		$store_details = mysqli_fetch_assoc($result);
	}
}

if($error_code == 0 && !empty($order_main))
{
	//$data = ['order_details' => $order_main, 'address' => $addresses, 'store_details' => $store_details ];
}

//echo '<pre>'; print_r($data); exit;

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

<body class="checkout_page">
	
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
							<li class="home"> <a title="My Orders" href="my-orders.php">My Orders</a><span>&raquo;</span></li>
							<li class="category13"><strong>Order - <?php echo $order_number; ?></strong></li>
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
						<div class="page-title">
							<button onclick="window.location = 'my-orders.php'" class="button" style="float: right; padding: 4px 10px; margin-top: 0"><i class="glyphicon glyphicon-backward"></i>&nbsp; <span>My Orders</span></button>
							<h2>Order (<?php echo $order_number; ?>)</h2>							
							<h5>
								Ordered Date: <?php echo formatDateTime($order_main['created_at']); ?> <br />
								Status: <?php echo getOrderStatus($order_main['status']); ?>
							</h5>
						</div>
						<div class="page-content checkout-page">
							<h4 class="checkout-sep">1. Shipping Address</h4>
							<div class="box-border">
								<h5>
									<label>
										<?php if($addresses['address_name'] != "") { echo $addresses['address_name']; } else { echo 'No Name'; } ?>
									</label>
								</h5>

								<address>
								<?php echo $addresses['first_name'].' '.$addresses['last_name']; ?><br>
								<span class="wrapping-text"><?php echo $addresses['address']; ?></span><br>
								<?php $add = printAddressDetails($addresses['city_name'], $addresses['state_name'], $addresses['country_name'], $addresses['pincode']); if($add != "") { echo $add. '<br />'; } ?>
								Landmark: <?php echo $addresses['landmark']; ?><br>
								<?php if($addresses['email'] != "") { echo '<span class="wrapping-text">E: '.$addresses['email'].'</span>'; } ?>
								<?php if ($addresses['email'] != "" && $addresses['mobile'] != "") { echo '<br>'; } ?>
								<?php if($addresses['mobile'] != "") { echo 'M: '.$addresses['mobile']; } ?>
								</address>
							</div>

							<h4 class="checkout-sep">2. Payment Mode</h4>
							<div class="box-border">
								<h5><?php echo getPaymentMode($order_main['payment_mode']); ?>
								<?php if($order_main['payment_mode'] == 1) { echo '<br />'.getPaymentSub($order_main['payment_sub']); } ?></h5>
							</div>
							<h4 class="checkout-sep">3. Order Review</h4>
							<div class="box-border">
								
								<div class="table-responsive">
									<table class="table table-bordered cart_summary">
										<thead>
											<tr>
												<th class="cart_product">Product</th>
												<th>Description</th>
												<th>Unit price</th>
												<th>Qty</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
<?php 

$cart_items = [];

$pro_query = "SELECT OD.variant_id, OD.product_id, OD.quantity, P.*, V.* FROM order_details AS OD INNER JOIN products AS P ON P.id = OD.product_id INNER JOIN products_variant AS V ON V.id = OD.variant_id WHERE OD.app_id = '$app_id' AND OD.order_id = '$order_id'";

$result = mysqli_query($link, $pro_query);

if(!$result)
{
	echo $sww; exit;
}
else
{
	while($row_2 = mysqli_fetch_assoc($result))
	{
		$product_id = $row_2['product_id'];
		$variant_id = $row_2['variant_id'];

		$cart = checkCustomerCart($app_id, $customer_id, $product_id, $variant_id);
		$row_2['cart_quantity'] = $cart;

		$file_name_str = $row_2['file_name'];
		$images = getFileImageArray($app_id, 2, $file_name_str);

		$row_2['file_name'] = $images;

		$cart_items[] = $row_2;
	}
}
											
$cart_total = 0; foreach($cart_items as $item) {
	
$product_id 	= $item['product_id'];
$variant_id 	= $item['variant_id'];
$price_finale 	= $item['price_finale'];
$offer_type 	= $item['offer_type'];
$offer_value 	= $item['offer_value'];
$expires_at 	= $item['expires_at'];
$offer_price 	= $item['offer_price'];
$cart_quantity 	= $item['quantity'];
$stock_amount 	= $item['stock_amount']; //echo $i;

$customer_offer = 0;
						
if($offer_type == 1 && ($expires_at == NULL || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime))
{
	$customer_offer = 1;
	$sale_price = $offer_price;
	$old_price = $price_finale;
}
else if($offer_type == 2 && ($expires_at == NULL || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime))
{
	$customer_offer = 2;
	$sale_price = $old_price = $price_finale;
}
else
{
	$sale_price = $old_price = $price_finale;
}

$pro_q_total_price = $sale_price * $cart_quantity;

if($stock_amount > 0 && $stock_amount > $cart_quantity)
{
	$cart_total = $cart_total + $pro_q_total_price;

	
echo '<tr>';
/*echo '<td class="cart_product"><a href="products-details.php?pro='.safe_encode($product_id).'"><img src="'.$item['file_name'][0].'" alt="'.$item['product_name'].'"></a></td>
	<td class="cart_description">
		<p class="product-name"><a href="products-details.php?pro='.safe_encode($product_id).'">'.$item['product_name'].'</a>
		</p>
		<small><a href="products-details.php?pro='.safe_encode($product_id).'">'.$item['net_measure'].' '.$item['measure_type'].' </a></small><br>
	</td>';*/
echo '<tr>';
echo '<td class="cart_product"><a href="products-details.php?pro='.safe_encode($product_id).'"><img src="'.$item['file_name'][0].'" alt="'.$item['product_name'].'"></a></td>';
echo '<td class="cart_description">';
echo '<p class="product-name"><a href="products-details.php?pro='.safe_encode($product_id).'">'.$item['product_name'].'</a></p>';
echo '<small><a href="products-details.php?pro='.safe_encode($product_id).'">'.$item['net_measure'].' '.$item['measure_type'].' </a></small>';
echo '<br />';

if($customer_offer > 0){
	
	if($customer_offer == 1 && $offer_value != "")
	{
		echo '<br />';
		echo '<a href="#">Get '.$offer_value.'% Discount</a>';
	}
	
	if($customer_offer == 2 && $offer_value != "")
	{
		$exp_offer_value 	= explode(',', $offer_value);
		$product_id_free 	= $exp_offer_value[0];
		$variant_id_free 	= $exp_offer_value[1];

		$getFreeProductDetail = getFreeProductDetail($app_id, $product_id_free, $variant_id_free);
		echo '<br />';
		echo 'Free: <a href="products-details.php?pro='.safe_encode($getFreeProductDetail['id']).'">'.$getFreeProductDetail['product_name'].' '.$item['measure_type'].' </a>';
	}
	
}
echo '</td>';

echo '<td class="price"><span>₹ '.customNumberFormat($sale_price).'</span></td>';
echo '<td class="qty"><span>'.$cart_quantity.'</span></td>';
echo '<td class="price"><span id="pro_qty_price_'.$product_id.'_'.$variant_id.'">₹ '.customNumberFormat($pro_q_total_price).'</span></td>';
echo '</tr>';
}
}

//$_SESSION['cart_total'] = $cart_total;

?>
										</tbody>										
										<tfoot>
											<tr>
												<td colspan="2" rowspan="3"></td>
												<td colspan="2">Cart Total</td>
												<td colspan="1">₹ <?php echo customNumberFormat($cart_total); ?></td>
											</tr>
											<tr>
												<td colspan="2">Delivery Charge</td>
												<td colspan="1" id="delivery_charge">₹ <?php echo customNumberFormat($order_main['price_delivery_charge']); ?></td>
											</tr>
											<tr>
												<td colspan="2"><strong>Total</strong></td>
												<td colspan="1"><strong id="cart_grand_total">₹ <?php echo customNumberFormat($order_main['price_total']); ?></strong></td>
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
		<!-- Main Container End -->

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