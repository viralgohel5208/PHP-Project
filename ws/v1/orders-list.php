<?php
/*
*	Login User to Application
* 	URL: http://localhost/ecom/ws/v1/orders-list.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn&page=1
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
else if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['customer_id'])  || !isset($_REQUEST['page']))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$page 			= escapeInputValue($_REQUEST['page']);
	
	if($page <= 1) { $start = 0; } else { $start = ($page - 1) * $limit; }
	$start = ($page - 1) * $limit;
	
	if($app_id == "" || $customer_id == "")
	{
		$error_code = 2; $error_string = 'Please enter all details';
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM orders WHERE app_id = '$app_id' AND customer_id = $customer_id LIMIT $start, $limit";
	
	$result = mysqli_query($link, $query);
	
	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$data = [];
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