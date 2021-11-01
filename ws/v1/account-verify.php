<?php
/*
 *     Send Verify Account Email
 *     URL: http://localhost/ecom/ws/v1/account-verify.php?app_id=1&user_name=shirishm.makwana@gmail.com&send_token=1
 * 
 *	   Verify Account
 * 	   URL: http://localhost/ecom/ws/v1/account-verify.php?app_id=1&user_name=shirishm.makwana@gmail.com&verif_code=WIFX2Y
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";
require_once "../../functions-mail.php";

if(isset($_REQUEST["app_id"]) && isset($_REQUEST["user_name"]) && isset($_REQUEST["send_token"]) && $_REQUEST["send_token"] == 1)
{
    $app_id 		= escapeInputValue($_REQUEST['app_id']);
    $user_name 		= escapeInputValue($_REQUEST['user_name']);
	
    if($app_id == "" && $user_name == "")
    {
        $error_code = 1; $error_string = 'Please enter all details';
    }
    else
    {
        $sql = "SELECT id, user_name, first_name, last_name, email, mobile, otp_code, otp_expiry_time, account_verified FROM customers WHERE app_id = $app_id AND (user_name = '$user_name' OR email = '$user_name' OR mobile = '$user_name' ) ";
        $result = mysqli_query($link, $sql);
		
		if(!$result)
		{
			 $error_code = 2; $error_string = $sww;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			$error_code = 3; $error_string = 'User does not exists';
		}
	}
	
	if($error_code == 0)
	{
		$row_user = mysqli_fetch_assoc($result);

		$customer_id		= $row_user['id'];
		$email 				= $row_user['email'];
		$mobile				= $row_user['mobile'];
		$otp_code 			= $row_user['otp_code'];
		$otp_expiry_time 	= $row_user['otp_expiry_time'];
		$account_verified	= $row_user['account_verified'];

		if($account_verified == 1)
		{
			$error_code = 4; $error_string = 'Account already verified';
		}
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
				$error_code = 5; $error_string = $sww;
			}
		}
	}
	
	if($error_code == 0)
	{
		if($error_code == 0 && $mobile != "")
		{
			//verif_type = 1 = SMS verification
			//verif_type = 2 = Email verification
			
			$parameters = ['app_id' => $app_id, 'verif_type' => 1, 'verif_type_sub' => 1, 'user_data' => $row_user];
			$customerVerifyAccount = customerVerifyAccount($parameters);
			
			$data = 'Sms sent successfully';
		}

		/*if($error_code == 0 && $email != "")
		{
			$res_email = mysqli_query($link, "SELECT email_1 from app_details WHERE app_id = $app_id");
			$row_user_email = mysqli_fetch_assoc($res_email);
			$admin_email = $row_user_email['email_1'];

			// mail type = 1 = Account Verify
			// mail type = 2 = Forgot Password
			$parameters = ['to' => $email, 'admin_email' => $admin_email, 'user_data' => $row_user, 'otp_code' => $otp_code, 'otp_expiry_time' => $otp_expiry_time, 'mail_type' => 1];

			$mail_verify = mailVerifyAccount($parameters);

			if($mail_verify == false)
			{
				$error_code = 6; $error_string = 'Email send error, Please retry';
			}
			else
			{
				$data[] = 'Mail sent successfully';
			}
		}*/
	}
}

else if(isset($_REQUEST["user_name"]) && isset($_REQUEST["verif_code"]))
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
    $user_name      = escapeInputValue($_REQUEST['user_name']);
    $verif_code    	= escapeInputValue($_REQUEST['verif_code']);
	
    if($user_name == "" || $verif_code == "")
    {
		$error_code = 11; $error_string = 'Please insert all details';
    }
    else
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
			$account_verified 	= $row_user['account_verified'];
                        
			if($account_verified == 1)
            {
				$error_code = 13; $error_string = 'User is already verified';
            }
            else if($otp_expiry_time < $current_datetime)
            {
				$error_code = 14; $error_string = 'Verif code has been expired';
			}
			else if($verif_code != $otp_code)
			{
				$error_code = 15; $error_string = 'Verif code does not match';
			}
		}
	}
	
	if($error_code == 0)
	{
		$sql_up_user ="UPDATE customers SET account_verified = 1, otp_code = NULL, otp_expiry_time = NULL, updated_at = '$current_datetime' WHERE id = '$customer_id'";

		$res_up_user = mysqli_query($link, $sql_up_user);

		if(!$res_up_user)
		{
			$error_code = 16; $error_string = $sww;
		}
		else
		{
			$error_code = 0;
			$error_string = "Account has been verified";
			$data = $row_user;
		}
    } 	
}
else
{
    $error_code = 21; $error_string = 'Variables not set';
}

$return = ['error_code' => $error_code, 'error_string' => $error_string, 'data' => $data];
print_r(json_encode($return));
exit;