<?php
/*
 *	User Registration
 *
 URL: http://localhost/ecom/ws/v1/register.php?app_id=1&first_name=Shirish&last_name=Makwana&email=shirishm.makwana@gmail.com&mobile=9924400799&password=shirish&re_password=shirish
 *
 */
header( "Content-type: text/plain" );
require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";
require_once "../../functions-mail.php";

if ( !isset( $_REQUEST[ "app_id" ] ) || !isset( $_REQUEST[ "first_name" ] ) || !isset( $_REQUEST[ "last_name" ] ) || !isset( $_REQUEST[ "email" ] ) || !isset( $_REQUEST[ "mobile" ] ) || !isset( $_REQUEST[ "password" ] ) || !isset( $_REQUEST[ "re_password" ] ) )
{
	$error_code = 1;
	$error_string = 'Variables not set';
}
else
{
	$app_id			= escapeInputValue($_REQUEST['app_id']);
	$first_name		= escapeInputValue($_REQUEST['first_name']);
	$last_name		= escapeInputValue($_REQUEST['last_name']);
	$email 			= escapeInputValue($_REQUEST['email']);
	$mobile 		= escapeInputValue($_REQUEST['mobile']);
	
	$password 		= $_REQUEST['password'];
	$re_password 	= $_REQUEST['re_password'];
	
	if($app_id == "" || $first_name == "" || $last_name == ""  || $mobile == "" || $password == "" || $re_password == "" )
	{
		$error_code = 2;
		$error_string = 'Please insert all details';
	}
	else if ( !preg_match( "/^[A-Z a-z]+$/", $first_name ) )
	{
		$error_code = 3;
		$error_string = 'Firstname is invalid, contains only alphabets';
	}
	else if ( !preg_match( "/^[A-Z a-z]+$/", $last_name ) )
	{
		$error_code = 4;
		$error_string = 'Lastname is invalid, contains only alphabets';
	}
	else if ( strlen( $password ) < 6 || strlen( $re_password ) < 6 )
	{
		$error_code = 5;
		$error_string = 'Minimum 6 char required in password';
	}
	else if ( $password != $re_password )
	{
		$error_code = 6;
		$error_string = 'Password does not match';
	}
	else if ($email != "" && !preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email ) ) {
		$error_code = 7;
		$error_string = 'Please enter valid email address';
	}
	else if ( !preg_match( "/^[0-9]+$/", $mobile ) )
	{
		$error_code = 8;
		$error_string = 'Please enter valid mobile number';
	}
}

if($error_code == 0)
{
	$sql_check_user = "SELECT email, mobile FROM customers WHERE  app_id = $app_id AND (email = '$email' OR mobile = '$mobile' )";
	$res_check_user = mysqli_query($link, $sql_check_user);

	if(!$res_check_user)
	{
		$error_code = 9;
		$error_string = $sww;
	}
	else if(mysqli_num_rows($res_check_user) > 0)
	{
		$row_check_user = mysqli_fetch_assoc($res_check_user);

		$r_email = $row_check_user['email'];
		$r_mobile = $row_check_user['mobile'];

		if($r_email == $email)
		{
			$error_code = 10;
			$error_string = 'Email address already exist';
		}
		else if($r_mobile == $mobile)
		{
			$error_code = 11;
			$error_string = 'Mobile number already exist';
		}
	}
}

if($error_code == 0)
{
	$user_name 			= $mobile;
	$password 			= passwordEncyption( $password, 'e' );
	$auth_token 		= generateRandomString(20);
	$otp_code			= rand(1000,9999);
	$otp_expiry_time    = date('Y-m-d H:i:s', strtotime("+2 hours"));
	$account_verified	= 0;
	$status				= 1;

	$sql_ins_user = "INSERT INTO `customers`(`app_id`, `user_name`, `first_name`, `last_name`, `email`, `mobile`, `password`, `auth_token`, `account_verified`, `otp_code`, `otp_expiry_time`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$user_name', '$first_name', '$last_name', '$email', '$mobile', '$password', '$auth_token', '$account_verified', '$otp_code', '$otp_expiry_time', '$current_datetime', '$current_datetime', '$status')";

	$res_ins_user = mysqli_query($link, $sql_ins_user);

	if(!$res_ins_user)
	{
		$error_code = 12;
		$error_string = $sww;
	}
	else
	{
		$user_id = mysqli_insert_id($link);

		$sql_user = "SELECT * FROM customers WHERE id = '$user_id' ";
		$result = mysqli_query($link, $sql_user);
		$row_user = mysqli_fetch_assoc($result);
	}
}

if($error_code == 0)
{
	$res_email = mysqli_query($link, "SELECT customer_account_verification from app_settings WHERE app_id = $app_id");
	$row_user_email = mysqli_fetch_assoc($res_email);
	$cust_ac_verification = $row_user_email['customer_account_verification'];
}

if($error_code == 0 && $email != "")
{
	$res_email = mysqli_query($link, "SELECT email_1 from app_details WHERE app_id = $app_id");
	$row_user_email = mysqli_fetch_assoc($res_email);
	$admin_email = $row_user_email['email_1'];

	if($mobile != "")
	{
		//verif_type = 1 = SMS verification
		//verif_type = 2 = Email verification
		$parameters = ['app_id' => $app_id, 'verif_type' => 1, 'verif_type_sub' => 1, 'user_data' => $row_user];
		$customerVerifyAccount = customerVerifyAccount($parameters);
	}
	/*
	// mail type = 1 = Account Verify
	// mail type = 2 = Forgot Password
	$parameters = ['to' => $email, 'admin_email' => $admin_email, 'user_data' => $row_user, 'otp_code' => $otp_code, 'otp_expiry_time' => $otp_expiry_time, 'mail_type' => 1];

	$mail_verify = mailVerifyAccount($parameters);

	/*if($mail_verify == false)
	{
		$error_code = 13;
		$error_string = 'Email send error, Please retry';
	}
	else*/
	{
		$row_user['file_name'] = $website_url.'/assets/images/default/user-avatar.png';
		$data = $row_user;
	}
}

$return = [ "error_code" => $error_code, "error_string" => $error_string, "data" => $data ];
print_r( json_encode( $return ) );
exit;
?>