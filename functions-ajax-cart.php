<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";

if(!isset($_POST['type']))
{
	echo 'alert("Something went wrong.")';
}
else
{
	$return = TRUE;
	$type = escapeInputValue($_POST['type']);
	
	// Add to Cart / Remove from cart
	if($type == 1 && isset($_POST['variant_id']) && isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['flag']))
	{
		//echo 'in';
		$product_id = escapeInputValue($_POST['product_id']);
		$variant_id = escapeInputValue($_POST['variant_id']);
		$quantity 	= escapeInputValue($_POST['quantity']);
		$flag 		= escapeInputValue($_POST['flag']);
		
		if(isset($_SESSION['cu_customer_id'])) {
			$customer_id = $_SESSION['cu_customer_id'];
		} else {
			$customer_id = 0;
		}
		
		if(!preg_match("/^[0-9]+$/",$quantity))
		{
			$quantity = 1;
		}
		
		if($flag == 0)
		{
			//echo 'remove';
			$result = removeFromCustomerCart($app_id, $customer_id, $product_id, $variant_id);
			if($result) {
				if(isset($_SESSION['cust_cart'][$product_id."_".$variant_id])) {
					unset($_SESSION['cust_cart'][$product_id.'_'.$variant_id]);
				}
			} else {
				$return = FALSE;
			}
		}
		
		if($flag == 1)
		{
			//echo 'add';
			$result = addToCustomerCart($app_id, $customer_id, $product_id, $variant_id, $quantity, $current_datetime);
			if($result) {
				$_SESSION['cust_cart'][$product_id.'_'.$variant_id] = array(
					'product_id' 	=> $product_id,
					'variant_id' 	=> $variant_id,
					'quantity' 		=> $quantity,
				);
				
				$result_w = removeFromCustomerWishlist($app_id, $customer_id, $product_id, $variant_id);
				if($result_w) {
					if(isset($_SESSION['cust_wishlist'][$product_id."_".$variant_id])) {
						unset($_SESSION['cust_wishlist'][$product_id.'_'.$variant_id]);
					}
				}
			} else {
				$return = FALSE;
			}
		}
		
		if($return == FALSE)
		{
			echo 'alert("Something went wrong.")';
		}
		else
		{
			if(isset($_SESSION['cust_cart'])) { $shop_items = count($_SESSION['cust_cart']); } else { $shop_items = 0; }

			//echo "1111";
			if($flag == 0)
			{
				//if($shop_items > 0) { $shop_items = $shop_items - 1; } else { $shop_items = 0; }
				echo 'document.getElementById("cart_string_'.$product_id.'_'.$variant_id.'").innerHTML = " Add to Cart";';
				echo 'document.getElementById("flag_'.$variant_id.'").value = "1";';
			}
			else
			{
				//$shop_items = $shop_items + 1;
				echo 'document.getElementById("cart_string_'.$product_id.'_'.$variant_id.'").innerHTML = " Remove from Cart";';
				echo 'document.getElementById("flag_'.$variant_id.'").value = "0";';
			}
			echo 'document.getElementById("shop_items").innerHTML = "'.$shop_items.'";';

		}
	}
	
	// Add to Wishlist / Remove from Wishlist
	else if($type == 2 && isset($_POST['variant_id']) && isset($_POST['product_id']) && isset($_POST['flag']))
	{
		//echo 'in';
		$product_id = escapeInputValue($_POST['product_id']);
		$variant_id = escapeInputValue($_POST['variant_id']);
		$flag 		= escapeInputValue($_POST['flag']);
		
		if(isset($_SESSION['cu_customer_id'])) {
			$customer_id = $_SESSION['cu_customer_id'];
		} else {
			$customer_id = 0;
		}
		
		if($flag == 0)
		{
			//echo 'remove';
			$result = removeFromCustomerWishlist($app_id, $customer_id, $product_id, $variant_id);
			if($result) {
				if(isset($_SESSION['cust_wishlist'][$product_id."_".$variant_id])) {
					unset($_SESSION['cust_wishlist'][$product_id.'_'.$variant_id]);
				}
			} else {
				$return = FALSE;
			}
		}
		
		if($flag == 1)
		{
			//echo 'add';
			$result = addToCustomerWishlist($app_id, $customer_id, $product_id, $variant_id, $current_datetime);
			if($result) {
				$_SESSION['cust_wishlist'][$product_id.'_'.$variant_id] = array(
					'product_id' 	=> $product_id,
					'variant_id' 	=> $variant_id,
				);
			} else {
				$return = FALSE;
			}
		}
		
		if($return == FALSE)
		{
			echo 'alert("Something went wrong.")';
		}
		else
		{
			//echo "1111";
			if($flag == 0)
			{
				//if($shop_items > 0) { $shop_items = $shop_items - 1; } else { $shop_items = 0; }
				echo 'if(document.getElementById("wishlist_icon_'.$product_id.'_'.$variant_id.'") !== null) { document.getElementById("wishlist_icon_'.$product_id.'_'.$variant_id.'").innerHTML = \'<i class="fa fa-heart-o"></i>\'; }';
				echo 'if(document.getElementById("wish_str_'.$product_id.'_'.$variant_id.'") !== null) { document.getElementById("wish_str_'.$product_id.'_'.$variant_id.'").innerHTML = "Add to Wishlist"; } ';
				echo 'document.getElementById("wishlist_flag_'.$variant_id.'").value = "1";';
			}
			else
			{
				//$shop_items = $shop_items + 1;
				echo 'if(document.getElementById("wishlist_icon_'.$product_id.'_'.$variant_id.'") !== null) { document.getElementById("wishlist_icon_'.$product_id.'_'.$variant_id.'").innerHTML = \'<i class="fa fa-heart"></i>\'; }';
				echo 'if(document.getElementById("wish_str_'.$product_id.'_'.$variant_id.'") !== null) { document.getElementById("wish_str_'.$product_id.'_'.$variant_id.'").innerHTML = "Remove from Wishlist"; } ';
				echo 'document.getElementById("wishlist_flag_'.$variant_id.'").value = "0";';
			}
		}
	}
	// Update Cart Quantity
	else if($type == 3 && isset($_POST['variant_id']) && isset($_POST['product_id']) && isset($_POST['quantity']))
	{
		//echo 'in';
		$product_id = escapeInputValue($_POST['product_id']);
		$variant_id = escapeInputValue($_POST['variant_id']);
		$quantity	= escapeInputValue($_POST['quantity']);
		
		$pro_query = "SELECT V.price_finale, V.offer_type, V.offer_value, V.expires_at, V.offer_price, V.stock_amount FROM products_variant AS V INNER JOIN products AS P ON P.id = V.product_id WHERE V.app_id = '$app_id' AND V.id = '$variant_id' AND V.product_id = '$product_id' LIMIT 1";

		$result = mysqli_query($link, $pro_query);

		if(!$result)
		{
			echo 'alert("Something went wrong.")'; exit;
		}
		else
		{
			$row_2 = mysqli_fetch_assoc($result);
			
			$price_finale 	= $row_2['price_finale'];
			$offer_type 	= $row_2['offer_type'];
			$offer_value 	= $row_2['offer_value'];
			$expires_at 	= $row_2['expires_at'];
			$offer_price 	= $row_2['offer_price'];
			$stock_amount 	= $row_2['stock_amount'];
			
			if($offer_type == 1 && ($expires_at == NULL || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime))
			{
				$sale_price = $offer_price;
				$old_price = $price_finale;
			}
			else
			{
				$sale_price = $old_price = $price_finale;
			}
			$pro_q_total_price = $sale_price * $quantity;
			
		}
		
		if(isset($_SESSION['cu_customer_id'])) {
			$customer_id = $_SESSION['cu_customer_id'];
		} else {
			$customer_id = 0;
		}
		
		if(!preg_match("/^[0-9]+$/", $quantity))
		{
			$quantity = 1;
		}
		
		if($stock_amount < $quantity)
		{
			echo 'document.getElementById("quantity_'.$product_id.'_'.$variant_id.'").value = "'.$stock_amount.'";';
			echo 'alert("Product is out of stock. Max '.$stock_amount.' items available");'; 
			$quantity = $stock_amount;
			$pro_q_total_price = $quantity * $sale_price;
			//exit;
		}
		
		{
			//echo 'add';
			$result = addToCustomerCart($app_id, $customer_id, $product_id, $variant_id, $quantity, $current_datetime);
			if($result) {
				$_SESSION['cust_cart'][$product_id.'_'.$variant_id] = array(
					'product_id' 	=> $product_id,
					'variant_id' 	=> $variant_id,
					'quantity' 		=> $quantity,
				);
				
				$cart_total = getCustomerCartGrandTotal($app_id, $customer_id);
				$cart_total = customNumberFormat($cart_total);
				$_SESSION['cart_total'] = $cart_total;
					
			} else {
				$return = FALSE;
			}

			if($return == FALSE)
			{
				echo 'alert("Something went wrong.")';
			}
			else
			{
				$pro_q_total_price = customNumberFormat($pro_q_total_price);
				echo 'document.getElementById("pro_qty_price_'.$product_id.'_'.$variant_id.'").innerHTML = "₹ '.$pro_q_total_price.'";';
				echo 'document.getElementById("cart_grand_total").innerHTML = "₹ '.$cart_total.'";';
				//echo 'document.getElementById("shop_items").innerHTML = "'.$shop_items.'";';
			}
		}
	}
	else 
	{
		echo 'alert("5xx. Something went wrong.")';
	}

	echo $return;
}