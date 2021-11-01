<?php

/*
* 	Customer Login
*	URL : http://localhost/ecom/ws/v1/login.php?app_id=1&user_name=shirishm.makwana@gmail.com&password=shirish
*/
header("Content-type: text/plain");

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-list.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST["app_id"]) || !isset($_REQUEST["user_name"]) || !isset($_REQUEST["password"]))
{
	$error_code = 1;
	$error_string = 'Variables is not set';
}
else
{
	$app_id		= escapeInputValue($_REQUEST['app_id']);
	$user_name 	= escapeInputValue($_REQUEST['user_name']);
	$password 	= escapeInputValue($_REQUEST['password']);
	
	if($app_id == '' || $user_name == '' || $password == '')
	{
		$error_code = 2;
		$error_string = 'Please insert all details';
	}
	else
	{
		$password = passwordEncyption($password, 'e');
	}
}

if($error_code == 0)
{
	$sql_user_fetch = "SELECT * FROM customers WHERE app_id = $app_id AND (`user_name` = '$user_name' OR `email` = '$user_name' OR `mobile` = '$user_name')";

	$res_user_fetch = mysqli_query($link, $sql_user_fetch);

	if(!$res_user_fetch)
	{
		$error_code = 3;
		$error_string = $sww;
	}
	else if(mysqli_num_rows($res_user_fetch) == 0)
	{
		$error_code = 4;
		$error_string = 'Please enter correct username';
	}
	else
	{
		$row_user_fetch = mysqli_fetch_assoc($res_user_fetch);
		
		$customer_id = $row_user_fetch['id'];
	}
}

if($error_code == 0)
{
	if($row_user_fetch['password'] != $password)
	{
		$error_code = 5;
		$error_string = 'Please enter correct password';
	}
	else if($row_user_fetch['status'] != 1)
	{
		$error_code = 6;
		$error_string = 'Your account is deactivated, Please contact administrator';
	}
}

if($error_code == 0)
{
	$auth_token = generateRandomString(20);
		
	$up_query = "UPDATE customers SET auth_token = '$auth_token' WHERE id = $customer_id";
	
	$res_query = mysqli_query($link, $up_query);
	
	if(!$res_query)
	{
		$error_code = 7;
		$error_string = $sww;
	}
	else
	{
		$row_user_fetch['auth_token'] = $auth_token;
		
		$row_user_fetch['gender_name'] = getCustGender($row_user_fetch['gender']);
		
		if($row_user_fetch['file_name'] == "")
		{
			$row_user_fetch['file_name'] = $website_url.'/assets/images/default/user-avatar.png';
		}
		else
		{
			$row_user_fetch['file_name'] = $website_url.'/uploads/store-'.$app_id.'/customer-profile/'.$row_user_fetch['file_name'];
		}

		$data = $row_user_fetch;
	}
}

$return = ["error_code" => $error_code,"error_string" => $error_string,"data" => $data];
print_r(json_encode($return));
exit;
?>