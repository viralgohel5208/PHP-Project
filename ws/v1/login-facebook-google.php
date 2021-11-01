<?php
/*
 *	User Login With Facebook and Google
 *
 URL: http://localhost/ecom/ws/v1/login-facebook-google.php?app_id=1&user_name=shirishmakwana&first_name=Shirish&last_name=Makwana&email=shirishm.makwana@gmail.com&login_flag=f&gender=1
 *
 *	login flag = f : Facebook, g : Google
 *	Gender: 0 = Not added, 1 = Male, 2 = Female, 3 = Other
 *
*/

header( "Content-type: text/plain" );

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";
//require_once "../../functions-mail.php";

if ( !isset( $_REQUEST[ "app_id" ] ) || !isset( $_REQUEST[ "user_name" ] ) || !isset( $_REQUEST[ "first_name" ] ) || !isset( $_REQUEST[ "last_name" ] ) || !isset( $_REQUEST[ "email" ] )  || !isset( $_REQUEST[ "login_flag" ] )  || !isset( $_REQUEST[ "gender" ] ) )
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id			= escapeInputValue($_REQUEST['app_id']);
	$user_name		= escapeInputValue($_REQUEST['user_name']);
	$first_name		= escapeInputValue($_REQUEST['first_name']);
	$last_name		= escapeInputValue($_REQUEST['last_name']);
	$email 			= escapeInputValue($_REQUEST['email']);
	$login_flag		= escapeInputValue($_REQUEST['login_flag']);
	$gender			= escapeInputValue($_REQUEST['gender']);
	$mobile			= "";
	
	if($app_id == "" || $user_name == "" || $first_name == "" || $email == "" || $login_flag == "")
	{
		$error_code = 2; $error_string = 'Please insert all details';
	}
	else if ($email != "" && !preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email ) )
	{
		$error_code = 3; $error_string = 'Please enter valid email address';
	} else if($login_flag != "f" && $login_flag != "g")
	{
		$error_code = 3; $error_string = "Invalid login flag";
	}
	else
	{
		if($login_flag == "f") { $fb_g_column = 'fb_login'; } else if($login_flag == "g") { $fb_g_column = "google_login"; }
			
	}
}

if($error_code == 0)
{
	$sql_check_user = "SELECT id FROM customers WHERE app_id = $app_id AND ( email = '$email' OR user_name = '$user_name' )";
	$res_check_user = mysqli_query($link, $sql_check_user);

	if(!$res_check_user)
	{
		$error_code = 4; $error_string = $sww;
	}
	else if(mysqli_num_rows($res_check_user) > 0)
	{
		$action = 'update';
		$row_check_user = mysqli_fetch_assoc($res_check_user);
		$user_id = $row_check_user['id'];
	}
	else
	{
		$action = 'add';
	}
}

if($error_code == 0 && isset($action) && $action == 'add')
{
	$mobile 			= '';
	$password			= passwordEncyption($user_name);
	$auth_token 		= generateRandomString(20);
	$account_verified	= 1;
	$status				= 1;

	$sql_ins_user = "INSERT INTO `customers`(`app_id`, `user_name`, `first_name`, `last_name`, `email`, `mobile`, `gender`, `password`, `".$fb_g_column."`, `auth_token`, `account_verified`, `otp_code`, `otp_expiry_time`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$user_name', '$first_name', '$last_name', '$email', '$mobile', '$gender', '$password', '1', '$auth_token', '$account_verified', NULL, NULL, '$current_datetime', '$current_datetime', '$status')";

	$res_ins_user = mysqli_query($link, $sql_ins_user);

	if(!$res_ins_user)
	{
		$error_code = 5;
		$error_string = $sww;
	}
	else
	{
		$user_id = mysqli_insert_id($link);
	}
}

if($error_code == 0 && isset($action) && $action == 'update')
{
	$password		= passwordEncyption($user_name);
	$auth_token 	= generateRandomString(20);
	
	$sql_update_user = "UPDATE `customers` SET `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$email', `mobile` = '$mobile', `gender` = '".$gender."', `".$fb_g_column."` = '1', `auth_token` = '$auth_token', `updated_at` = '$current_datetime' WHERE id = $user_id AND app_id = $app_id";

	$res_update_user = mysqli_query($link, $sql_update_user);

	if(!$res_update_user)
	{
		$error_code = 6; $error_string = $sww;
	}
}

if($error_code == 0)
{
	$sql_user = "SELECT * FROM customers WHERE id = '$user_id' ";
	$result = mysqli_query($link, $sql_user);
	if(!$result)
	{	
		$error_code = 7; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 8; $error_string = 'User does not found';
	}
	else
	{
		$row_user = mysqli_fetch_assoc($result);
		//print_r($row_user);
		$data = $row_user;
		//print_r(json_encode($data)); exit;
	}
}

$return = [ "error_code" => $error_code, "error_string" => $error_string, "data" => $data ];
print_r( json_encode( $return ) );
exit;

?>