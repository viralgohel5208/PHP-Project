<?php

/*
*	Checkout order

URL: http://localhost/ecom/ws/v1/checkout-order.php?app_id=1&customer_id=2&auth_token=0zNDDm15v5b70F8n16wk&store_id=1&address_id=1&payment_mode=1&payment_sub=0&latitude=22.2911109&longitude=70.7998965&delivery_charge=50.00&transaction_id=GSHDGSY1516943602&payment_status=0&payment_date=2018-01-27 12:00:11

*
*	Payment Mode : 0 - Online Payment, 1 = Cash on delivery
*	Payment Sub : Cash on delivery : 0 - By Cash, 1 = By Paytm, 2 = By Card swipe
*	Payment Status : 0 = Pending, 1 = Paid, 2 = Cancelled
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";
require_once "../../functions-mail.php";

$checkUserAuthentication = checkUserAuthentication(isset($_REQUEST[ 'app_id' ])?$_REQUEST[ 'app_id' ]:FALSE, isset($_REQUEST[ 'customer_id' ])?$_REQUEST[ 'customer_id' ]:FALSE, isset($_REQUEST[ 'auth_token' ])?$_REQUEST[ 'auth_token' ]:FALSE);

if($checkUserAuthentication['error_code'] != 0)
{
	$error_code = $checkUserAuthentication['error_code'];
	$error_string = $checkUserAuthentication['error_string'];
}
else if(!isset($_REQUEST['customer_id']) || !isset($_REQUEST['address_id']) || !isset($_REQUEST['store_id']) || !isset($_REQUEST['payment_mode']) || !isset($_REQUEST['payment_sub']) || !isset($_REQUEST['latitude']) || !isset($_REQUEST['longitude']) || !isset($_REQUEST['delivery_charge']) || !isset($_REQUEST['transaction_id']) || !isset($_REQUEST['payment_status']) || !isset($_REQUEST['payment_date']))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 			= escapeInputValue($_REQUEST['app_id']);
	$customer_id 		= escapeInputValue($_REQUEST['customer_id']);
	$address_id 		= escapeInputValue($_REQUEST['address_id']);
	$store_id 			= escapeInputValue($_REQUEST['store_id']);
	$payment_mode 		= escapeInputValue($_REQUEST['payment_mode']);
	$payment_sub 		= escapeInputValue($_REQUEST['payment_sub']);
	$latitude 			= escapeInputValue($_REQUEST['latitude']);
	$longitude 			= escapeInputValue($_REQUEST['longitude']);
	$delivery_charge 	= escapeInputValue($_REQUEST['delivery_charge']);
	$transaction_id 	= escapeInputValue($_REQUEST['transaction_id']);
	$payment_status 	= escapeInputValue($_REQUEST['payment_status']);
	$payment_date 		= escapeInputValue($_REQUEST['payment_date']);
	
	if( $customer_id == "" || $address_id == ""  || $store_id == "" || $payment_mode == ""|| $payment_sub == "" || $delivery_charge == ""  || $payment_status == ""  || $payment_date == "" )
	{
		$error_code = 2; $error_string = 'Please enter all details';
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
	
	$query = "INSERT INTO `orders`(`app_id`, `store_id`, `customer_id`, `order_number`, `payment_mode`, `payment_sub`, `address_id`, `latitude`, `longitude`, `transaction_id`, `payment_status`, `payment_date`, `created_at`, `status`) VALUES ($app_id, $store_id, $customer_id, '$order_number', '$payment_mode', '$payment_sub', '$address_id', '$latitude', '$longitude', '$transaction_id', '$payment_status', '$payment_date', '$current_datetime', 0)";
	
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
					$query5 = "INSERT INTO `order_details`(`app_id`, `order_id`, `product_id`, `variant_id`, `quantity`, `offer_reference`, `price_raw`, `price_gst`, `price_finale`, `price_discounted`, `price_total`, `status`) VALUES ('$app_id', '$order_id', '$product_id', '$variant_id', '$quantity', '', '$price_raw', '$price_gst', '$price_finale', '$price_discounted', '$price_total', '0')";
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
	$sql = "SELECT id, user_name, first_name, last_name, email, mobile FROM customers WHERE app_id = $app_id AND id = $customer_id";
	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		 $error_code = 2; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 3; $error_string = 'User does not exists';
	}
	else
	{
		$row_user = mysqli_fetch_assoc($result);

		$email = $row_user['email'];
		$mobile = $row_user['mobile'];

		if($email != "" || $mobile != "")
		{
			// Mail type = 1 = Order Receipt
			$parameters = ['app_id' => $app_id, 'store_id' => $store_id, 'to_email' => $email, 'to_mobile' => $mobile, 'order_id' => $order_id, 'order_number' => $order_number, 'ord_price_total' => $ord_price_total, 'user_data' => $row_user];

			// Send mail and sms notiifcation
			$mail_verify = mailCustomerOrderReceipt($parameters);

			if($mail_verify == false)
			{
				//$error_code = 6; 
				//$error_string = 'Email send error, Please retry';
			}
			else
			{
				//$data = 'Mail sent successfully';
			}
		}
	}
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
	$data = $order_number;
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>