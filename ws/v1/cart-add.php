<?php
/*
*	Add/Update Cart
* 	URL: http://localhost/ecom/ws/v1/cart-add.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn&product_id=1&variant_id=1&quantity=10
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

$checkUserAuthentication = checkUserAuthentication(isset($_REQUEST[ 'app_id' ])?$_REQUEST[ 'app_id' ]:FALSE, isset($_REQUEST[ 'customer_id' ])?$_REQUEST[ 'customer_id' ]:FALSE, isset($_REQUEST[ 'auth_token' ])?$_REQUEST[ 'auth_token' ]:FALSE);

if($checkUserAuthentication['error_code'] != 0)
{
	$error_code = $checkUserAuthentication['error_code'];
	$error_string = $checkUserAuthentication['error_string'];
}
else if(!isset($_REQUEST['product_id']) || !isset($_REQUEST['variant_id']) || !isset($_REQUEST['quantity']))
{
	$error_code = 1; $error_string = "Variable is missing";
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$product_id 	= escapeInputValue($_REQUEST['product_id']);
	$variant_id 	= escapeInputValue($_REQUEST['variant_id']);
	$quantity 		= escapeInputValue($_REQUEST['quantity']);
}

if($error_code == 0)
{
	$pro_query = "SELECT id FROM customers_cart WHERE app_id = '$app_id' AND customer_id = '$customer_id' AND variant_id = $variant_id AND product_id = $product_id";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 2; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$action = "ADD";
	}
	else
	{
		$row = mysqli_fetch_assoc($result);
		$cart_id = $row['id'];
		$action = "UPDATE";
	}
}

if($error_code == 0 && $action == "ADD")
{
	$query = "INSERT INTO `customers_cart`(`app_id`, `customer_id`, `product_id`, `variant_id`, `quantity`, `created_at`) VALUES ($app_id, $customer_id, $product_id, $variant_id, '$quantity', '$current_datetime')";

	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else
	{
		$data = TRUE;
	}
}

if($error_code == 0)
{
	$query_1 = "DELETE FROM `customers_wishlist` WHERE `app_id` = $app_id AND `customer_id` = $customer_id AND `product_id` = $product_id AND `variant_id` = $variant_id";

	$result_1 = mysqli_query($link, $query_1);

	if(!$result_1)
	{
		$error_code = 3; $error_string = $sww;
	}
}

if($error_code == 0 && $action == "UPDATE")
{
	$query = "UPDATE `customers_cart` SET `quantity` = $quantity WHERE id = $cart_id";

	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$error_code = 4; $error_string = $sww;
	}
	else
	{
		$data = TRUE;
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>