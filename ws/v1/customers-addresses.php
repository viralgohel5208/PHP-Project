<?php
/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/customers-addresses.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn
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
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
}

if($error_code == 0)
{
	$pro_query = "SELECT * FROM customers_address WHERE app_id = '$app_id' AND customer_id = '$customer_id'";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 1; $error_string = $sww;
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{				
			$data[] = $row;
		}
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>