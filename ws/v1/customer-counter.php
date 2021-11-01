<?php

/*
*	Banners
* 	URL: http://localhost/ecom/ws/v1/customer-counter.php?app_id=1&customer_id=3
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['customer_id']))
{
	$error_code = 1; $error_string = "Application id is not set";
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	
	if($app_id == "" || $customer_id == "")
	{
		$error_code = 2; $error_string = "Variables can't be empty";
	}
}

if($error_code == 0)
{
	$cart_count = getCustomerCartCount($app_id, $customer_id);
	
	$result = ['cart_count' => $cart_count];
}

$return = [ 'error_code' => $error_code, 'error_string' => $error_string, 'data' => $result ];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;