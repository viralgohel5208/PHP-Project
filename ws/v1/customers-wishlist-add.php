<?php
/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/customers-wishlist-add.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn&variant_id=1&product_id=1
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
else if(!isset($_REQUEST['variant_id']) || !isset($_REQUEST['product_id']))
{
	$error_code = 1; $error_string = "Variable is missing";
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$variant_id 	= escapeInputValue($_REQUEST['variant_id']);
	$product_id 	= escapeInputValue($_REQUEST['product_id']);
}

if($error_code == 0)
{
	$pro_query = "SELECT id FROM customers_wishlist WHERE app_id = '$app_id' AND customer_id = '$customer_id' AND variant_id = $variant_id AND product_id = $product_id";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 1; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) > 0)
	{
		$error_code = 2; $error_string = 'Already in wishlist';
	}
}

if($error_code == 0)
{
	$query_1 = "INSERT INTO `customers_wishlist`(`app_id`, `customer_id`, `product_id`, `variant_id`, `offer_id`, `created_at`) VALUES ($app_id, $customer_id, $product_id, $variant_id, NULL, '$current_datetime')";

	$result_1 = mysqli_query($link, $query_1);

	if(!$result_1)
	{
		$error_code = 3; $error_string = $sww;
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