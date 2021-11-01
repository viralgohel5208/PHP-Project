<?php
/*
 *     Send Password Forgot Email
 *     URL: http://localhost/ecom/ws/v1/password-forgot.php?app_id=1&step=1&user_name=shirishm.makwana@gmail.com
 * 
 *	   Update Password
 * 	   URL: http://localhost/ecom/ws/v1/password-forgot.php?app_id=1&step=2&user_name=shirishm.makwana@gmail.com&verif_code=3933&n_password=shirish&c_password=shirish
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";
require_once "../../functions-mail.php";

if(!isset($_REQUEST["app_id"]) || !isset($_REQUEST["step"]) || !isset($_REQUEST["user_name"]))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
    $app_id 		= escapeInputValue($_REQUEST['app_id']);
    $step 			= escapeInputValue($_REQUEST['step']);
    $user_name 		= escapeInputValue($_REQUEST['user_name']);
	
	if($app_id == "" && $step == "" && $user_name == "")
    {
        $error_code = 2; $error_string = 'Please enter all details';
    }
	else if($step != 1 && $step != 2)
	{
		$error_code = 3; $error_string = 'Invalid step';
	}
	else if($step == 2 && (!isset($_REQUEST["verif_code"]) || !isset($_REQUEST["n_password"]) || !isset($_REQUEST["c_password"])))
	{
		$error_code = 4; $error_string = 'Variables not set';
	}
	else if($step == 2)
	{
		$verif_code 	= escapeInputValue($_REQUEST['verif_code']);
		$n_password 	= escapeInputValue($_REQUEST['n_password']);
		$c_password 	= escapeInputValue($_REQUEST['c_password']);
	}
}

if($error_code == 0 && $step == 1)
{
	$sql = "SELECT id, user_name, first_name, last_name, email, mobile, otp_code, otp_expiry_time FROM customers WHERE app_id = $app_id AND (user_name = '$user_name' OR email = '$user_name' OR mobile = '$user_name' ) ";
	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		 $error_code = 5; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 6; $error_string = 'User does not exists';
	}
	
	if($error_code == 0)
	{
		$row_user = mysqli_fetch_assoc($result);

		$customer_id		= $row_user['id'];
		$email 				= $row_user['email'];
		$mobile				= $row_user['mobile'];
		$otp_code 			= $row_user['otp_code'];
		$otp_expiry_time 	= $row_user['otp_expiry_time'];
	}
	
	if($error_code == 0)
	{
		if($otp_code == "" || $otp_code == NULL || $otp_expiry_time == NULL || $otp_expiry_time < $current_datetime)
		{
			$otp_code					= rand(1000,9999);
			$otp_expiry_time     		= date('Y-m-d H:i:s', strtotime("+2 hours"));

			$sql_up_otp = "UPDATE customers SET otp_code = '$otp_code', otp_expiry_time = '$otp_expiry_time', updated_at = '$current_datetime' WHERE id = '$customer_id'";

			if(!mysqli_query($link, $sql_up_otp))
			{
				$error_code = 7; $error_string = $sww;
			}
			else
			{
				//echo 'success';
				$row_user['otp_code'] = $otp_code;
				$row_user['otp_expiry_time'] = $otp_expiry_time;
			}
		}
		else
		{
			//echo 'nooo2';
		}
	}
	else
	{
		//echo 'nooo';
	}
	//echo 'Shirish';

	if($error_code == 0 && $mobile != "")
	{
		//verif_type = 1 = SMS verification
		//verif_type = 2 = Email verification
		
		//verif_type_sub = 2 = Forgot pass notifi
		
		$parameters = ['app_id' => $app_id, 'verif_type' => 1, 'verif_type_sub' => 2, 'user_data' => $row_user];
		$customerVerifyAccount = customerVerifyAccount($parameters);
		$data = ['otp_code' => $otp_code];
		
		//print_r($parameters);
	}
	
	/*
	if($error_code == 0 && $email != "")
	{
		$res_email = mysqli_query($link, "SELECT email_1 from app_details WHERE app_id = $app_id");
		$row_user_email = mysqli_fetch_assoc($res_email);
		$admin_email = $row_user_email['email_1'];

		// mail type = 1 = Account Verify
		// mail type = 2 = Forgot Password
		$parameters = ['to' => $email, 'admin_email' => $admin_email, 'user_data' => $row_user, 'otp_code' => $otp_code, 'otp_expiry_time' => $otp_expiry_time, 'mail_type' => 2];

		$mail_verify = mailVerifyAccount($parameters);

		if($mail_verify == false)
		{
			$error_code = 8; $error_string = 'Email send error, Please retry';
		}
		else
		{
			$data = TRUE;
		}
	}*/
}

if($error_code == 0 && $step == 2)
{
    if($verif_code == "" || $n_password == "" || $c_password == "")
    {
		$error_code = 9; $error_string = 'Please insert all details';
    }
	else if ( strlen( $n_password ) < 6 || strlen( $c_password ) < 6 )
	{
		$error_code = 10; $error_string = 'Minimum 6 char required in password';
	}
	else if ( $n_password != $c_password )
	{
		$error_code = 11; $error_string = 'Password does not match';
	}
    
	if($error_code == 0)
    {
        $sql = "SELECT * FROM customers WHERE app_id = $app_id AND (user_name = '$user_name' OR email = '$user_name' OR mobile = '$user_name' )";
		
        $result = mysqli_query($link, $sql);
		
        if(mysqli_num_rows($result) == 0)
		{
			$error_code = 12; $error_string = 'User does not exist';
		}
		else
        {
            $row_user = mysqli_fetch_assoc($result);
			
            $customer_id 		= $row_user['id'];
            $otp_code 			= $row_user['otp_code'];
			$otp_expiry_time	= $row_user['otp_expiry_time'];
			
			if($otp_expiry_time < $current_datetime)
            {
				$error_code = 13; $error_string = 'Verif code has been expired';
			}
			else if($verif_code != $otp_code)
			{
				$error_code = 14; $error_string = 'Verif code does not match';
			}
		}
	}
	
	if($error_code == 0)
	{
		$n_password = passwordEncyption($n_password, 'e');
		
		$sql_up_user ="UPDATE customers SET password = '$n_password', otp_code = NULL, otp_expiry_time = NULL, updated_at = '$current_datetime' WHERE id = '$customer_id'";

		$res_up_user = mysqli_query($link, $sql_up_user);

		if(!$res_up_user)
		{
			$error_code = 15; $error_string = $sww;
		}
		else
		{
			$data = TRUE;
		}
    } 	
}

$return = ['error_code' => $error_code, 'error_string' => $error_string, 'data' => $data];
print_r(json_encode($return));
exit;