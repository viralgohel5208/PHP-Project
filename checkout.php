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

$page_title = "Checkout";

if(!isset($_SESSION['cust_cart']) || !isset($_SESSION['cust_cart']))
{
	header("Location:categories.php");
	exit;
}

if(!isset($_SESSION['ck_city_id']))
{
	$_SESSION['ck_city_id'] 	= 0;
	$_SESSION['ck_store_id'] 	= 0;
	$_SESSION['ck_area_id'] 	= 0;
	$_SESSION['ck_delivery_charge'] = 0;
}

if(isset($_POST['ck_store_id']) && isset($_POST['ck_address_id']) && isset($_POST['ck_payment_mode']) && isset($_POST['ck_payment_sub']) )
{
	//echo '<pre>'; print_r($_POST); exit;
	{
		$address_id 		= escapeInputValue($_POST['ck_address_id']);
		$payment_mode 		= escapeInputValue($_POST['ck_payment_mode']);
		$payment_sub 		= escapeInputValue($_POST['ck_payment_sub']);
		$transaction_id 	= escapeInputValue($_POST['ck_transaction_id']);
		
		$payment_status 	= 0; //escapeInputValue($_REQUEST['payment_status']);
		$payment_date 		= ''; //escapeInputValue($_REQUEST['payment_date']);
		$latitude 			= "0.00"; //escapeInputValue(_POST['latitude']);
		$longitude 			= "0.00"; //escapeInputValue(_POST['longitude']);
		
		$store_id 			= escapeInputValue($_SESSION['ck_store_id']);
		$delivery_charge 	= escapeInputValue($_SESSION['ck_delivery_charge']);

		if( $customer_id == "" )
		{
			$error_string = "2.1 Something went wrong, Please logout and login again.";
		}
		else if($store_id == "")
		{
			$error_string = 'Please select your store';
		}
		else if($address_id == "")
		{
			$error_string = 'Please select your shipping address';
		}
		else if($payment_mode == "")
		{
			$error_string = 'Please select your payment method';
		}
		else if($payment_mode == 1 && $payment_sub == "")
		{
			$error_string = "Please select payment by option";
		}
		else if($delivery_charge == "")
		{
			$error_string = "2.2 Something went wrong, Please logout and login again.";
		}
	}

	if($error_code == 0)
	{
		$order_number = 'ORD-'.time();
		mysqli_autocommit($link, FALSE);

		$ord_price_raw 			= 0;
		$ord_price_gst 			= 0;
		$ord_price_finale 		= 0;
		$ord_price_discounted 	= 0;
		$ord_price_total 		= 0;
	}
	
	// main Order table entry
	if($error_code == 0)	
	{
		//ord_price_total is included with delivery_charge
		//ord_price_total = ord_price_discounted + $delivery_charge;

		$query = "INSERT INTO `orders`(`app_id`, `store_id`, `customer_id`, `order_number`, `payment_mode`, `payment_sub`, `address_id`, `latitude`, `longitude`, `transaction_id`, `payment_status`, `payment_date`, `created_at`, `status`) VALUES ($app_id, $store_id, $customer_id, '$order_number', '$payment_mode', '$payment_sub', '$address_id', '$latitude', '$longitude', '$transaction_id', '$payment_status', NULL, '$current_datetime', 0)";
		
		$result6 = mysqli_query($link, $query);
		if(!$result6)
		{
			$error_code = 3; $error_string = $sww;
		}
		else
		{
			$order_id = mysqli_insert_id($link);
		}
	}

	// Order details table entry
	if($error_code == 0)
	{
		$pro_query = "SELECT C.variant_id, C.product_id, C.quantity, P.*, V.* FROM customers_cart AS C INNER JOIN products AS P ON P.id = C.product_id INNER JOIN products_variant AS V ON V.id = C.variant_id WHERE C.app_id = '$app_id' AND customer_id = '$customer_id'";

		$result2 = mysqli_query($link, $pro_query);

		if(!$result2)
		{
			$error_code = 4; $error_string = $sww;
		}
		else if(mysqli_num_rows($result2) == 0)
		{
			$error_code = 5; $error_string = "Order does not found";
		}
		else
		{
			while($row_2 = mysqli_fetch_assoc($result2))
			{
				$product_id 	= $row_2['product_id'];
				$variant_id 	= $row_2['variant_id'];
				$gst_percentage	= $row_2['gst_percentage'];
				$price_raw 		= $row_2['price_raw'];
				$price_gst 		= $row_2['price_gst'];
				$price_finale 	= $row_2['price_finale'];
				$offer_type 	= $row_2['offer_type'];
				$offer_value 	= $row_2['offer_value'];
				$expires_at 	= $row_2['expires_at'];
				$offer_price 	= $row_2['offer_price'];
				$quantity 		= $row_2['quantity'];
				$stock_amount 	= $row_2['stock_amount'];

				//$pro_q_total_price = $sale_price * $quantity;

				if($stock_amount > 0 && $stock_amount > $quantity)
				{
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

					if($customer_offer == 1)
					{
						$discount 			= ($sale_price * $offer_value) / 100;
						$price_discounted 	= $price_finale - $discount;
						$price_total 		= $quantity * $price_discounted;

						// Count GST amount and Raw price
						$price_gst 			= ($price_discounted * $gst_percentage) / 100;
						$price_raw 			= $price_discounted - $price_gst;

						// Need to multiply quantity at finle to gst price and row price
						
						$offer_value = "1:".$customer_offer.":".$offer_value;
					}
					else if($customer_offer == 2)
					{
						$price_discounted 	= $price_finale;
						$price_total 		= $quantity * $price_discounted;
						$exp_offer_value 	= explode(',', $offer_value);
						$product_id_free 	= $exp_offer_value[0];
						$variant_id_free 	= $exp_offer_value[1];
						
						$offer_value = "1:".$customer_offer.":".$offer_value;
					}
					else
					{
						$price_discounted 	= $price_finale;
						$price_total 		= $quantity * $price_discounted;
					}

					//
					/*if($customer_offer == 0 || $customer_offer == 1)
					{
						$query5 = "INSERT INTO `order_details`(`app_id`, `order_id`, `product_id`, `variant_id`, `quantity`, `offer_reference`, `price_raw`, `price_gst`, `price_finale`, `price_discounted`, `price_total`, `status`) VALUES ('$app_id', '$order_id', '$product_id', '$variant_id', '$quantity', '', '$price_raw', '$price_gst', '$price_finale', '$price_discounted', '$price_total', 0)";
					}
					else if($customer_offer == 2)*/
					{
						// Add Main Product
						// plus add free product
						$query5 = "INSERT INTO `order_details`(`app_id`, `order_id`, `product_id`, `variant_id`, `quantity`, `offer_reference`, `price_raw`, `price_gst`, `price_finale`, `price_discounted`, `price_total`, `status`) VALUES ('$app_id', '$order_id', '$product_id', '$variant_id', '$quantity', '$offer_value', '$price_raw', '$price_gst', '$price_finale', '$price_discounted', '$price_total', '0')";
						//$query5 .= ", ('$app_id', '$order_id', '$product_id', '$variant_id', '$quantity', '', '0', '0', '0', '0', '0', '0')";
					}

					//echo $query5; echo '<br/>';

					//if(isset($query5))
					{
						$result5 = mysqli_query($link, $query5);
						if(!$result5)
						{
							$error_code = 6; $error_string = $sww;
							break;
						}
					}

					// Need to multiply quantity at finle to gst price and row price
					$ord_price_raw 			+= ($price_raw * $quantity);
					$ord_price_gst 			+= ($price_gst * $quantity);
					$ord_price_finale 		+= ($price_finale * $quantity);
					$ord_price_discounted 	+= ($price_discounted * $quantity);
					$ord_price_total 		+= $price_total;
				}
			}
		}
	}

	if($error_code == 0)	
	{
		//ord_price_total is included with delivery_charge
		$ord_price_total = $ord_price_total + $delivery_charge;

		$query6 = "UPDATE `orders` SET `price_raw` = '$ord_price_raw', `price_gst` = '$ord_price_gst', `price_finale` = '$ord_price_finale', `price_discounted` = '$ord_price_discounted', `price_delivery_charge` = '$delivery_charge', `price_total` = '$ord_price_total' WHERE id = $order_id";

		//echo $query6; echo '<br/>';

		$result6 = mysqli_query($link, $query6);
		if(!$result6)
		{
			$error_code = 7; $error_string = $sww;
		}
		else
		{
			//$order_id = mysqli_insert_id($link);
		}
	}

	if($error_code == 0)
	{
		$query7 = "DELETE FROM customers_cart WHERE app_id = $app_id AND customer_id = '$customer_id'";

		$result7 = mysqli_query($link, $query7);

		if(!$result7)
		{
			$error_code = 8; $error_string = $sww;
		}
	}

	// Send SMS notification
	if($error_code == 0)
	{
		/*$query8 = "SELECT mobile_no FROM users where id = '$customer_id'";

		$result8 = mysqli_query($link, $query8);
		$row8 = mysqli_fetch_assoc($result8);
		$mobile_no = $row8['mobile_no'];*/

		//$file = file_get_contents("http://mobicomm.dove-sms.com/mobicomm//submitsms.jsp?user=OnlineG&key=e910335f3eXX&mobile=+91".$mobile_no."&message=Dear+Customer+%2C+your+order+".$order_number."+is+Confirmed.+Amount+to+be+paid+RS.".$total_amount."+you+will+receive+a+delivery+confirmation+notification+once+the+order+is+delivered.+Thanks%2C+".$application_name."&senderid=Mfresh&accusage=1");
	}

	if($error_code == 0)
	{
		/*$query9 = "SELECT * FROM delivery_boy WHERE store_id = '$store_id'";
		$result9 = mysqli_query($link, $query9);

		if(!$result9)
		{
			$error_code = 8;
			$error_string = $sww;
		}
		else if(mysqli_num_rows($result9) > 0)
		{
			while($row9 = mysqli_fetch_assoc($result9))
			{
				$customer_id_array[] = $row9['id'];
			}
			$delv_message = 'New order has been placed';
			sendNotif($link, $customer_id_array, 1, 1, $delv_message);
		}*/
	}

	if($error_code == 0)
	{
		mysqli_autocommit($link, TRUE);
		$_SESSION['ck_order_complete'] = TRUE;
		$_SESSION['ck_order_id'] = $order_id;
		$_SESSION['cart_total'] = $ord_price_total;
		$_SESSION['ck_order_number'] = $order_number;
		header("Location:checkout-complete.php");
		exit;
	}
	else
	{
		$error = $error_code;
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
							<li class="home"> <a title="Shopping Cart" href="shopping-cart.php">Shopping Cart</a><span>&raquo;</span></li>
							<li class="category13"><strong>Checkout</strong></li>
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
					<div class="col-main col-sm-9">
						<div class="page-title">
							<h2>Checkout</h2>
						</div>
						<?php require_once "message-block.php"; ?>						
						<div class="page-content checkout-page">
							<h4 class="checkout-sep">1. Select Store</h4>
							<div class="errormes" id="error_block_1" style="display: none">
								<div class="message-box-wrap"> <i class="fa fa-exclamation-circle fa-lg"></i> <span id="error_string_1"></span> </div>
							</div>
							<div class="box-border">
								<div class="row">
									<div class="col-sm-12">
										<h4>Please select your nearest store</h4>
										<label>Select City</label>
										<select name="city_id" id="cities-list" class="form-control" onChange="getCityStores(this.value)">
											<option value="0">Select Store City ...</option>
											<?php 
											$query = "SELECT id, city_name FROM `cities` WHERE app_id = $app_id AND status = 1 ORDER BY city_name";
											$result = mysqli_query($link, $query);
											while($row = mysqli_fetch_assoc($result))
											{
												echo '<option value="'.$row['id'].'" ';
												if(isset($_SESSION['ck_city_id']) && $_SESSION['ck_city_id'] == $row['id']){
													echo 'selected="selected"';
												}
												echo '>'.$row['city_name'].'</option>';
											}
											?>
										</select>
										
										<label>Select Store</label>
										<select name="store_id" id="stores-list" class="form-control" onChange="getStoreAreas(this.value);">
											<option value="0">Select Store ...</option>
											<?php
											if($_SESSION['ck_city_id'] != 0)
											{
												$city_id = $_SESSION['ck_city_id'];
												$query = "SELECT id, store_name FROM `stores` WHERE app_id = $app_id AND city_id = $city_id AND status = 1 ORDER BY store_name";
												$result = mysqli_query($link, $query);
												while($row = mysqli_fetch_assoc($result))
												{
													echo '<option value="'.$row['id'].'" ';
													if($_SESSION['ck_store_id'] == $row['id']){
														echo 'selected="selected"';
													}
													echo '>'.$row['store_name'].'</option>';
												}
											}
											?>
										</select>
										<label>Select Area</label>
										<select name="area_id" id="areas-list" class="form-control" onChange="setStoreArea(this.value)">
											<option value="0">Select Area ...</option>
											<?php 
											if($_SESSION['ck_city_id'] != 0 && $_SESSION['ck_store_id'] != 0)
											{
												$city_id = $_SESSION['ck_city_id'];
												$store_id = $_SESSION['ck_store_id'];
												$query = "SELECT id, store_area FROM `stores_localities` WHERE app_id = $app_id AND city_id = ".$city_id." AND store_id = ".$store_id." ORDER BY store_area";
												$result = mysqli_query($link, $query);
												while($row = mysqli_fetch_assoc($result))
												{
													echo '<option value="'.$row['id'].'" ';
													if($_SESSION['ck_area_id'] == $row['id']){
														echo 'selected="selected"';
													}
													echo '>'.$row['store_area'].'</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<h4 class="checkout-sep">2. Shipping Address</h4>
							<div class="errormes" id="error_block_2" style="display: none">
								<div class="message-box-wrap"> <i class="fa fa-exclamation-circle fa-lg"></i> <span id="error_string_2"></span> </div>
							</div>
							<div class="box-border">
								<div class="row">
									<?php
									$result = mysqli_query($link, "SELECT * FROM customers_address where customer_id = '$customer_id' AND app_id = '$app_id'");
									if(!$result)
									{
										echo '<div class="col-md-12" style="margin-bottom: 15px;"><h5>No existing addresses found. Please add new <a href="address-book-add.php" style="color:#0fb7a4">Click Here!</a></h5></div>';
									}
									else if(mysqli_num_rows($result) == 0)
									{
										$address_count = 0;
										echo '<div class="col-md-12" style="margin-bottom: 15px;"><h5>No existing addresses found. Please add new <a href="address-book-add.php" style="color:#0fb7a4">Click Here!</a></h5></div>';
									}
									else
									{
										$_SESSION['prev_page'] = $full_url;
										echo '<div class="col-md-12" style="margin-bottom: 15px;"><h5>Select from existing address or add new <a href="address-book-add.php" style="color:#0fb7a4">Click Here!</a></h5></div>';
										while($row = mysqli_fetch_array($result))
										{
									?>
									<div class="col-md-4">
										<div class="box-border">
											<h5>
												<label>
												<input type="radio" name="cust_address" value="<?php echo $row['id']; ?>" <?php if(isset($_SESSION['ck_address_id']) && $_SESSION['ck_address_id'] == $row['id']) { echo 'checked="checked"'; } ?>>
												<?php if($row['address_name'] != "") { echo $row['address_name']; } else { echo 'No Name'; } ?>
												</label>
											</h5>
												
											<address>
											<?php echo $row['first_name'].' '.$row['last_name']; ?><br>
											<span class="wrapping-text"><?php echo $row['address']; ?></span><br>
											<?php $add = printAddressDetails($row['city_name'], $row['state_name'], $row['country_name'], $row['pincode']); if($add != "") { echo $add. '<br />'; } ?>
											Landmark: <?php echo $row['landmark']; ?><br>
											<?php if($row['email'] != "") { echo '<span class="wrapping-text">E: '.$row['email'].'</span>'; } ?>
											<?php if ($row['email'] != "" && $row['mobile'] != "") { echo '<br>'; } ?>
											<?php if($row['mobile'] != "") { echo 'M: '.$row['mobile']; } ?>
											</address>
										</div>
									</div>
									<?php } } ?>
								</div>
							</div>
							<h4 class="checkout-sep">3. Payment Information</h4>
							<div class="errormes" id="error_block_3" style="display: none">
								<div class="message-box-wrap"> <i class="fa fa-exclamation-circle fa-lg"></i> <span id="error_string_3"></span> </div>
							</div>
							<div class="box-border">
								<div class="row">
									<div class="col-md-6">
										<h5>Type of Payment</h5>
										<ul>
											<?php 
											$available_payment_mode = $_SESSION['available_payment_mode']; 
											$ex_available_payment_mode = explode(",", $available_payment_mode);
											foreach($ex_available_payment_mode as $item)
											{
												echo '<li>';
												echo '<label>';
												echo '<input type="radio" name="payment_mode" value="'.$item.'">';
												echo getPaymentMode($item);
												echo '</label>';
												echo '</li>';
											}
											?>
										</ul>
									</div>
									<div class="col-md-6" id="payment_sub_div" style="display: none">
										<h5>Payment By</h5>
										<ul>
											<?php 
											$listPaymentSub = listPaymentSub();
											foreach($listPaymentSub as $key=>$item)
											{
												echo '<li>';
												echo '<label>';
												echo '<input type="radio" name="payment_sub" value="'.$key.'">';
												echo $item;
												echo '</label>';
												echo '</li>';
											}
											?>
										</ul>
									</div>
								</div>
							</div>
							<h4 class="checkout-sep">4. Order Review</h4>
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

$pro_query = "SELECT C.variant_id, C.product_id, C.quantity, P.*, V.* FROM customers_cart AS C INNER JOIN products AS P ON P.id = C.product_id INNER JOIN products_variant AS V ON V.id = C.variant_id WHERE C.app_id = '$app_id' AND customer_id = '$customer_id'";

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

$_SESSION['cart_total'] = $cart_total;

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
												<td colspan="1" id="delivery_charge">₹ <?php echo $_SESSION['ck_delivery_charge']; ?></td>
											</tr>
											<tr>
												<td colspan="2"><strong>Total</strong></td>
												<td colspan="1"><strong id="cart_grand_total">₹ <?php echo customNumberFormat($cart_total + $_SESSION['ck_delivery_charge']); ?></strong></td>
											</tr>
										</tfoot>
									</table>
								</div>
								
								<div class="page-order">
									<div class="cart_navigation" style="margin-bottom: 0">
										<a class="continue-btn" href="shopping-cart.php"><i class="fa fa-arrow-left"> </i>&nbsp; Update Shopping Cart</a>
										<a class="checkout-btn" onClick="checkoutOrder()" style="cursor: pointer"><i class="fa fa-check"></i> Place Order</a>
									</div>
								</div>			
							</div>
						</div>
					</div>
					<?php /*?><aside class="right sidebar col-sm-3 col-xs-12">
						<div class="sidebar-checkout">
							<div class="sidebar-bar-title">
								<h3>Your Checkout</h3>
							</div>
							<div class="block-content">
								<dl>
									<dt class="complete"> Billing Address <span class="separator">|</span> <a href="#">Change</a> </dt>
									<dd class="complete">
										<address>
                  Deo Jone<br>
                  Company Name<br>
                  7064 Lorem <br>
                  Ipsum <br>
                  Vestibulum 0 666/13<br>
                  United States<br>
                  T: 12345678 <br>
                  F: 987654
                  </address>
									
									</dd>
									<dt class="complete"> Shipping Address <span class="separator">|</span> <a href="#">Change</a> </dt>
									<dd class="complete">
										<address>
                  Deo Jone<br>
                  Company Name<br>
                  7064 Lorem <br>
                  Ipsum <br>
                  Vestibulum 0 666/13<br>
                  United States<br>
                  T: 12345678 <br>
                  F: 987654
                  </address>
									
									</dd>
									<dt class="complete"> Shipping Method <span class="separator">|</span> <a href="#">Change</a> </dt>
									<dd class="complete"> Flat Rate - Fixed <br>
										<span class="price">$15.00</span> </dd>
									<dt> Payment Method </dt>
									<dd class="complete"></dd>

								</dl>

							</div>
						</div>
					</aside><?php */?>
				</div>
			</div>
		</section>
		<!-- Main Container End -->

		<!-- Footer -->
		<?php require_once "include/footer-main.php"; ?>		
		<!-- end Footer -->
		
		<a href="#" class="totop"> </a> </div>
	
	<form id="submit_cart_form" action="" method="post" style="display: hidden">
		<input type="hidden" id="ck_store_id" name="ck_store_id" value="">
		<input type="hidden" id="ck_address_id" name="ck_address_id" value="">
		<input type="hidden" id="ck_payment_mode" name="ck_payment_mode" value="">
		<input type="hidden" id="ck_payment_sub" name="ck_payment_sub" value="">
		<input type="hidden" id="ck_transaction_id" name="ck_transaction_id" value="">
	</form>

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
	$(document).ready(function() {
		$('input[type=radio][name=payment_mode]').change(function() {
			//alert(this.value);
			if (this.value == 1) {
				//alert('g');
				$("#payment_sub_div").show();
			}
			else {
				$("#payment_sub_div").hide();
			}
		});
	});

	function getCityStores(x)
	{
		$.ajax({
			type: "POST",
			url: "functions-ajax-general.php",
			data: 'type=9&city_id='+x,
			success: function(data){
				$("#stores-list").html(data);
				$("#areas-list").html('<option value="">Select Area ...</option>');
			}
		});
	}

	function getStoreAreas(x)
	{
		$.ajax({
			type: "POST",
			url: "functions-ajax-general.php",
			data: 'type=10&store_id='+x,
			success: function(data){
				$("#areas-list").html(data);
			}
		});
	}

	function setStoreArea(x)
	{
		$.ajax({
			type: "POST",
			url: "functions-ajax-general.php",
			data: 'type=11&area_id='+x,
			success: function(data){
				//$("#areas-list").html(data);
				eval(data);
			}
		});
	}
		
	function checkoutOrder()
	{
		var city_id = $("#cities-list").val();
		var store_id = $("#stores-list").val();
		var area_id = $("#areas-list").val();
		var address_id = $('input[name=cust_address]:checked').val();
		var payment_mode = $('input[name=payment_mode]:checked').val();
		var payment_sub = $('input[name=payment_sub]:checked').val();
		
		if(city_id == "0")
		{
			var error = "Please select your city";
			$('[id^="error_block_"]').css('display', 'none');
			$('#error_block_1').css('display', 'block');
			$('#error_string_1').html(error);
			alert(error);
		}
		else if(store_id == "0")
		{
			var error = "Please select store";
			$('[id^="error_block_"]').css('display', 'none');
			$('#error_block_1').css('display', 'block');
			$('#error_string_1').html(error);
			alert(error);
		}
		else if(area_id == "0")
		{
			var error = "Please select your area";
			$('[id^="error_block_"]').css('display', 'none');
			$('#error_block_1').css('display', 'block');
			$('#error_string_1').html(error);
			alert(error);
		}
		else if(typeof address_id == "undefined")
		{
			<?php if(isset($address_count)) { ?>
			var error = "Please add new address";
			<?php } else { ?>
			var error = "Please select shipping address";
			<?php } ?>
			$('[id^="error_block_"]').css('display', 'none');
			$('#error_block_2').css('display', 'block');
			$('#error_string_2').html(error);
			alert(error);
		}
		else if(typeof payment_mode == "undefined")
		{
			var error = "Please select payment mode";
			$('[id^="error_block_"]').css('display', 'none');
			$('#error_block_3').css('display', 'block');
			$('#error_string_3').html(error);
			alert(error);
		}
		else if(payment_mode == 1 && typeof payment_sub == "undefined")
		{
			var error = "Please select payment by option";
			$('[id^="error_block_"]').css('display', 'none');
			$('#error_block_3').css('display', 'block');
			$('#error_string_3').html(error);
			alert(error);
		}
		else
		{
			$('[id^="error_block_"]').css('display', 'none');
			//alert("OK");
			
			$("#ck_store_id").val(store_id);
			$("#ck_address_id").val(address_id);
			$("#ck_payment_mode").val(payment_mode);
			$("#ck_payment_sub").val(payment_sub);
			$("#submit_cart_form").submit();
		}
	}
		
	</script>
</body>
</html>