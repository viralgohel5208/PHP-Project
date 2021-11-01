<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

if(!isset($_REQUEST['e']))
{
	$error = $sww;
}
else
{
	$email 			= $_REQUEST['e'];
	
	if($email == "") 
	{
		$error = "Please enter email";	
	}
	else if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email))
	{
      	$error = "Please enter valid email address";	
	}
}

if($error == "")
{
	$query_1 = "SELECT id, first_name, last_name, otp_code, otp_expiry_time, status FROM admin WHERE email = '$email' ";

	$res_1 = mysqli_query($link, $query_1);

	if(!$res_1)
	{
		$error = $sww;
	}
	else if(mysqli_num_rows($res_1) == 0)
	{
		$error = "Email address not found";
	}
	else
	{
		$row_1 = mysqli_fetch_assoc($res_1);
		
		$user_id			= $row_1['id'];
		$user_name			= $row_1['first_name'].' '.$row_1['last_name'];
		$otp_code 			= $row_1['otp_code'];
		$otp_expiry_time 	= $row_1['otp_expiry_time'];
		$status 			= $row_1['status'];
		
		if($status != 1)
		{
			$error = "Your account has been deactivated, Kindly contact Administrator";
		}
		else if($otp_code == "" || $otp_code == NULL || $otp_expiry_time == NULL || $otp_expiry_time < $current_datetime )
		{
			//$otp_code			= rand(100000,999999);
			$otp_code 			= generateRandomString(30);
			$otp_expiry_time    = date('Y-m-d H:i:s', strtotime("+2 hours"));

			$sql_up_otp = "UPDATE admin SET otp_code = '$otp_code', otp_expiry_time = '$otp_expiry_time' WHERE id = '$user_id'";

			if(!mysqli_query($link, $sql_up_otp))
			{
				$error = '1'.$sww;
			}
		}
	}
}

if($error == "")
{
	$admin_email = 'shirishm.makwana@gmail.com';
	$to 		= $email;

	$subject 	= $application_name." - Forgot Password";

	$message 	= '
	<!doctype html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>Verify Account</title>
	</head>

	<body>
	<table dir="ltr">
	<tbody>
	<tr>
	<td style="padding:0;font-family:\'Segoe UI Light\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:41px;color:#F44336">'.$application_name.'</td>
	</tr>
	<tr>
	<td style="padding:0;font-family:\'Segoe UI Semibold\',\'Segoe UI Bold\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:17px;color:#795548; margin-top:20px">Forgot password</td>
	</tr>
	<tr>
	<td style="padding:0;padding-top:25px;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Please use this link to reset your password at '.$application_name.' account .</td>
	</tr>
	<tr>
	<td style="padding:0;padding-top:25px;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Here is your link: <span style="font-family:\'Segoe UI Bold\',\'Segoe UI Semibold\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:14px;font-weight:bold;color:#2a2a2a"><a dir="ltr" style="color:#2672ec;text-decoration:none" href="'.$website_url.'/forgot-password.php?verif=1&email='.$email.'&code='.$otp_code.'" target="_blank">'.$website_url.'/forgot-password.php?verif=1&email='.$email.'&code='.$otp_code.'</a></span></td>
	</tr>
	<tr>
	<td style="padding:0;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Please note that this link will expire in 2 hour.</td>
	</tr>
	<tr>
	<td style="padding:0;padding-top:25px;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Thanks,</td>
	</tr>
	<tr>
	<td style="padding:0;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">The '.$application_name.' team</td>
	</tr>
	</tbody>
	</table>
	</body>
	</html>

	';
	//echo $message;
	//exit;
	/*$header 	= "From:".$admin_email." \r\n";
	$header 	.= "MIME-Version: 1.0\r\n";
	$header 	.= "Content-type: text/html\r\n";

	$sentmail = mail ($to, $subject, $message, $header);

	$error = 1;*/
}

if($error == "")
{
	//Import the PHPMailer class into the global namespace
	

	require '../vendor/autoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	// Set PHPMailer to use the sendmail transport
	$mail->isSendmail();
	//Set who the message is to be sent from
	$mail->setFrom($admin_email, $admin_user);
	//Set who the message is to be sent to
	$mail->addAddress($to, $user_name);
	//Set the subject line
	$mail->Subject = $subject;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($message);
	//Replace the plain text body with one created manually
	//$mail->AltBody = 'This is a plain-text message body';
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');

	//send the message, check for errors
	if (!$mail->send())
	{
		$error = 'Mailer error'; //echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
		$error = 1; //echo "Message sent!";
	}
}

echo $error;
exit;