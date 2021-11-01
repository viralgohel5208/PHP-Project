<?php

use PHPMailer\PHPMailer\PHPMailer;

// mail_type = 1 => For Account Verification
// mail_type = 2 => For Forgot Password

require 'vendor/autoload.php';

function mailVerifyAccount($parameters)
{
	global $application_name;
	
	$to 				= $parameters['to'];
	$admin_email		= $parameters['admin_email'];
	$user_data 			= $parameters['user_data'];
	$otp_code 			= $parameters['otp_code'];
	$otp_expiry_time 	= $parameters['otp_expiry_time'];
	$mail_type 			= $parameters['mail_type'];
	
	if($mail_type == 1)
	{
		$subject 	= $application_name." - Verify your account";
		$mail_title = "Account verification code";
	}
	else if($mail_type == 2)
	{
		$subject 	= $application_name." - Forgot Password";
		$mail_title = "Forgot pasword otp";
	}	

	$message 	= '
	<!doctype html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>'.$subject.'</title>
	</head>
	<body>
		<table dir="ltr">
			<tbody>
				<tr>
					<td style="padding:0;font-family:\'Segoe UI Semibold\',\'Segoe UI Bold\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:17px;color:#68b04d">'.$application_name.'</td>
				</tr>
				<tr>
					<td style="padding:0;font-family:\'Segoe UI Light\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:41px;color:#68b04d">'.$mail_title.'</td>
				</tr>
				<tr>
					<td style="padding:0;padding-top:25px;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Hi, '.$user_data['first_name'].' '.$user_data['last_name'].'</a>.</td>
				</tr>
				<tr>
					<td style="padding:0;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Please use this code to verify your email at '.$application_name.' account: <a dir="ltr" style="color:#2672ec;text-decoration:none" href="mailto:'.$to.'" target="_blank">'.$to.'</a>.</td>
				</tr>
				<tr>
					<td style="padding:0;padding-top:25px;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Here is your code: <span style="font-family:\'Segoe UI Bold\',\'Segoe UI Semibold\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:14px;font-weight:bold;color:#2a2a2a">'.$otp_code.'</span></td>
				</tr>
				<tr>
					<td style="padding:0;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">This code will expire in 2 hours.</td>
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
	</html>';
	
	//echo $message;
	//exit;
	
	$mail = new PHPMailer();
	
	//$mail->IsSMTP();  // telling the class to use SMTP
	//$mail->Host     = "smtp.example.com"; // SMTP server

	//$mail->From     = "shirishm.makwana3@gmail.com";
	//$mail->From     = $admin_email;
	$mail->SetFrom($admin_email, 'info');
	
	//$mail->AddAddress("shirishm.makwana@gmail.com");
	$mail->AddAddress($to);

	$mail->Subject  = $subject;
	$mail->IsHTML(true);
	$mail->Body     = $message;
	//$mail->WordWrap = 50;

	/*$header 	= "From:".$admin_email." \r\n";
	$header 	.= "MIME-Version: 1.0\r\n";
	$header 	.= "Content-type: text/html\r\n";*/
	
	//if(mail($to, $subject, $message, $header))
	if($mail->Send())
	{
		return true;
	}
	else
	{
		return false;
		//return true;
	}
}

function customerVerifyAccount($parameters)
{
	global $link, $application_name;
	
	//app_id' => $app_id, 'verif_type' => 1, 'user_data
	
	//echo '<pre>'; print_r($parameters);
	
	$app_id 			= $parameters['app_id'];
	$verif_type			= $parameters['verif_type'];
	$verif_type_sub		= $parameters['verif_type_sub'];
	$user_data 			= $parameters['user_data'];
	
	// User data
	$email 				= $user_data['email'];
	$mobile 			= $user_data['mobile'];
	$otp_code 			= $user_data['otp_code'];
	$otp_expiry_time 	= $user_data['otp_expiry_time'];
	
	if($verif_type == 1)
	{
		$query_sms = "SELECT sms_username, sms_password, sms_sender_id from admin_settings LIMIT 1";
		$res_sms = mysqli_query($link, $query_sms);
		$row_sms = mysqli_fetch_assoc($res_sms);
		
		$sms_username = $row_sms["sms_username"];
		$sms_password = $row_sms["sms_password"];
		$sms_senderid = $row_sms["sms_sender_id"];
		
		$application_name = str_replace(" ", "%20", $application_name);
		
		if($verif_type_sub == 1)
		{
			$message = "Welcome%20to%20".$application_name.".%20Your%20account%20verification%20code%20is%20".$otp_code;
		}
		else if($verif_type_sub == 2)
		{
			$message = "Welcome%20to%20".$application_name.".%20Your%20verification%20code%20for%20reset%20password%20is%20".$otp_code;
		}
		
		$url = "http://panel.adcomsolution.in/http-api.php?username=".$sms_username."&password=".$sms_password."&senderid=".$sms_senderid."&route=1&number=+91".$mobile."&message=".$message;
		
		$file = file_get_contents($url);
	}
	else if($mail_type == 2)
	{
		$res_email = mysqli_query($link, "SELECT email_1 from app_details WHERE app_id = $app_id");
		$row_user_email = mysqli_fetch_assoc($res_email);
		
		$admin_email = $row_user_email['email_1'];
		
		if($verif_type_sub == 1)
		{
			$subject 	= $application_name." - Verify your account";
			$mail_title = "Account verification code";
		}
		else
		{
			$subject 	= $application_name." - Forgot Password";
			$mail_title = "Forgot pasword otp";
		}

		$message 	= '
		<!doctype html>
		<html>
		<head>
		<meta charset="utf-8">
		<title>'.$subject.'</title>
		</head>
		<body>
			<table dir="ltr">
				<tbody>
					<tr>
						<td style="padding:0;font-family:\'Segoe UI Semibold\',\'Segoe UI Bold\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:17px;color:#68b04d">'.$application_name.'</td>
					</tr>
					<tr>
						<td style="padding:0;font-family:\'Segoe UI Light\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:41px;color:#68b04d">'.$mail_title.'</td>
					</tr>
					<tr>
						<td style="padding:0;padding-top:25px;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Hi, '.$user_data['first_name'].' '.$user_data['last_name'].'</a>.</td>
					</tr>
					<tr>
						<td style="padding:0;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Please use this code to verify your email at '.$application_name.' account: <a dir="ltr" style="color:#2672ec;text-decoration:none" href="mailto:'.$to.'" target="_blank">'.$to.'</a>.</td>
					</tr>
					<tr>
						<td style="padding:0;padding-top:25px;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">Here is your code: <span style="font-family:\'Segoe UI Bold\',\'Segoe UI Semibold\',\'Segoe UI\',\'Helvetica Neue Medium\',Arial,sans-serif;font-size:14px;font-weight:bold;color:#2a2a2a">'.$otp_code.'</span></td>
					</tr>
					<tr>
						<td style="padding:0;font-family:\'Segoe UI\',Tahoma,Verdana,Arial,sans-serif;font-size:14px;color:#2a2a2a">This code will expire in 2 hours.</td>
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
		</html>';

		//echo $message;
		//exit;

		$mail = new PHPMailer();

		//$mail->IsSMTP();  // telling the class to use SMTP
		//$mail->Host     = "smtp.example.com"; // SMTP server

		//$mail->From     = "shirishm.makwana3@gmail.com";
		//$mail->From     = $admin_email;
		$mail->SetFrom($admin_email, 'info');

		//$mail->AddAddress("shirishm.makwana@gmail.com");
		$mail->AddAddress($to);

		$mail->Subject  = $subject;
		$mail->IsHTML(true);
		$mail->Body     = $message;
		//$mail->WordWrap = 50;

		/*$header 	= "From:".$admin_email." \r\n";
		$header 	.= "MIME-Version: 1.0\r\n";
		$header 	.= "Content-type: text/html\r\n";*/

		//if(mail($to, $subject, $message, $header))
		if($mail->Send())
		{
			return true;
		}
		else
		{
			return false;
			//return true;
		}
	}
}

function mailCustomerOrderReceipt($parameters)
{
	global $link, $application_name;
	
	//app_id' => $app_id, 'verif_type' => 1, 'user_data
	
	//echo '<pre>'; print_r($parameters);
	//'app_id' => $app_id, 'store_id' => $store_id, 'to_email' => $email, 'to_mobile' => $mobile, 'order_id' => $order_id, 'ord_price_total' => $ord_price_total
	
	$app_id 			= $parameters['app_id'];
	$store_id 			= $parameters['store_id'];
	$to_email 			= $parameters['to_email'];
	$to_mobile 			= $parameters['to_mobile'];
	$order_id 			= $parameters['order_id'];
	$order_number		= $parameters['order_number'];
	$ord_price_total	= $parameters['ord_price_total'];
	$user_data 			= $parameters['user_data'];
	
	// User data
	$email 				= $user_data['email'];
	$mobile 			= $user_data['mobile'];
	
	$query_1 = "SELECT id, store_name FROM stores WHERE app_id = $app_id AND id = $store_id";
	$res_1 = mysqli_query($link, $query_1);
	$row_1 = mysqli_fetch_assoc($res_1);
	$store_name = $row_1['store_name'];

	$res_email = mysqli_query($link, "SELECT email_1 from app_details WHERE app_id = $app_id");
	$row_user_email = mysqli_fetch_assoc($res_email);
	$admin_email = $row_user_email['email_1'];

	if($to_mobile != "")
	{
		$query_sms = "SELECT sms_username, sms_password, sms_sender_id from admin_settings LIMIT 1";
		$res_sms = mysqli_query($link, $query_sms);
		$row_sms = mysqli_fetch_assoc($res_sms);
		
		$sms_username = $row_sms["sms_username"];
		$sms_password = $row_sms["sms_password"];
		$sms_senderid = $row_sms["sms_sender_id"];
		
		$store_name = str_replace(" ", "%20", $store_name);
		
		$ord_price_total = customNumberFormat($ord_price_total);
			
		$message = "Welcome%20to%20".$store_name.".%20Your%20order%20has%20been%20placed.%20Total%20payable%20amount%20is%20".$ord_price_total;
		
		$url = "http://panel.adcomsolution.in/http-api.php?username=".$sms_username."&password=".$sms_password."&senderid=".$sms_senderid."&route=1&number=+91".$mobile."&message=".$message;
		
		$file = file_get_contents($url);
	}
	
	if($to_email != "" && $admin_email != "")
	{
		ob_start();
		
		require_once "db.php";
		require_once "universal.php";
		require_once "define.php";
		//require_once "login-required.php";
		require_once "functions.php";
		require_once "functions-list.php";
		require_once "functions-mysql.php";
		
		$store_name = str_replace("%20", " ", $store_name);
		$subject 	= $store_name." - Order has been received";
		$mail_title = "Order Placed with Order number - ".$order_number;

$res_order = mysqli_query($link, "SELECT * FROM `orders` WHERE app_id = $app_id AND id = '".$order_id."' LIMIT 1");

$row_order = mysqli_fetch_assoc ($res_order);
$order_from = $row_order['order_from'];

if($order_from == 1)
{
	$query_user = "SELECT C.id as u_id, C.* FROM customers AS C WHERE C.id = ".$row_order['customer_id']."";
}
else
{
	$query_user = "SELECT C.id as u_id, C.first_name,C.last_name, C.mobile, C.email, C.created_at, A.* FROM customers AS C LEFT JOIN customers_address AS A ON C.id = A.customer_id WHERE A.id = ".$row_order['address_id']."";
}
$res_user = mysqli_query($link, $query_user);
$row_user = mysqli_fetch_assoc($res_user);

/********** Order Details ************/
$order_details = [];
$sql_pro = "SELECT * FROM order_details WHERE order_id = ".$row_order['id']."";
$result_pro = mysqli_query($link, $sql_pro);

$a = [];
while($row = mysqli_fetch_assoc($result_pro))
{
	$query_od = "SELECT P.*, V.product_id, V.price_finale, V.measure_type, V.net_measure FROM products AS P INNER JOIN products_variant AS V ON P.id = V.product_id WHERE V.id = ".$row['variant_id']."";

	$result1 = mysqli_query($link, $query_od);
	$row1 = mysqli_fetch_assoc($result1);

	$row1['quantity'] 			= $row['quantity'];
	$row1['price_finale'] 		= $row['price_finale'];
	$row1['price_discounted'] 	= $row['price_discounted'];
	$row1['price_total'] 		= $row['price_total'];
	$a[] = $row1;

}
$test = [];
foreach($a as $i)
{
	$test[] = $i;
}
$order_details  = $test;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Orders Invoice - <?php echo $store_name; ?></title>
	<style type="text/css">
		body { font-family: verdana; }
		@page { size: auto; /* auto is the initial value */ margin: 0mm; /* this affects the margin in the printer settings */ }
		.print-heading { visibility: hidden; }
		@media print { 
			body * { visibility: hidden; }
			/*body { margin: 0; padding: 0; }*/
			/*	@page { size: A4; margin: 0; }*/ 
			/*	#print1 { padding-top: 0; margin-top: 0; }*/
			.panel-title * { visibility: visible; }
			#invoice-item * { visibility: visible; margin: 0px; }
			/*#invoice-item{ top: 0; }*/
			.print-heading { visibility: hidden; }
			.panel-body { text-align: left; }
			.col-md-4 { top: 0; }
			#invoice-table th, td:first-child {	width: 50px; }
			#invoice-footer th { text-align: right; /*width: 50px;*/ }
			.product_n { width: 20%; }
		}
	</style>
</head>
<body>
	<table width="100%">
		<tr>
			<td>
				<div style="width: 100%">
					<div style="width: 50%; float: left">
						<div>
							<h1 style="margin-bottom: 0; padding-bottom: 0"> <?php echo $store_name; ?> </h1>
							<h5> Status: <b class="text-success"><?php if($row_order['status'] == 0) { echo '<span style="color:rgb(43, 115, 102);">'; } else if($row_order['status'] == 1) { echo '<span style="color:#00dd00;">'; } else if($row_order['status'] == 2) { echo '<span style="color:#ff0000;">'; } echo getDeliveryStatus($row_order['status']); ?></span></b> </h5>
						</div>
					</div>
					<div style="width: 50%; float: left">
						<div style="text-align: right">
							<h2 class="invoice-logo-text lh10">INVOICE</h2>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<div style="width: 25%; float: left">
						<div class="panel panel-alt">
							<div class="panel-heading">
								<span class="panel-title"> <i class="fa fa-user"></i> Bill To: </span>
							</div>
							<div class="panel-body">
								<strong><?php echo $row_user['first_name'].' '.$row_user['last_name']; ?></strong>
								<br> <?php echo $row_user['mobile']; ?>
								<br> <?php echo $row_user['email']; ?>
								<br>
								<abbr>Reg Date:</abbr> <?php echo formatDate($row_user['created_at']); ?>
							</div>
						</div>
					</div>
					<div class="col-md-3" style="width: 25%; float: left">
						&nbsp;
						<?php if($order_from == 1) { echo ''; } else { ?>
						<div class="panel panel-alt">
							<div class="panel-heading">
								<span class="panel-title"> <i class="fa fa-location-arrow"></i> Address:</span>
								<div class="panel-btns pull-right ml10">
									<!--<span class="panel-title-sm"> Edit</span>-->
								</div>
							</div>
							<div class="panel-body">
								<?php if($row_user['address_name'] != ''){?>
								<strong><?php echo $row_user['address_name'];?></strong><br>
								<?php } if($row_user['first_name'] != '' || $row_user['first_name'] != ''){ ?>
								<?php echo $row_user['first_name'].' '.$row_user['last_name'];?><br>
								<?php } if($row_user['mobile'] != ''){?>
								<?php echo $row_user['mobile'];?><br>
								<?php } ?>
								<?php echo $row_user['address']; ?>
								<br> <?php echo $row_user['landmark'].','.$row_user['city_name']; ?>
								<br> <?php echo $row_user['state_name']; ?>
								<br> <?php echo $row_user['pincode']; ?>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-3" style="width: 25%; float: left">
						<div class="panel panel-alt">
							<strong>Store:</strong> <br />
								<?php 
								$store_id = $row_order['store_id'];
								$query_1 = mysqli_query($link, "SELECT id, store_name, email, mobile_1, address FROM stores WHERE id = $store_id AND app_id = $app_id ORDER BY store_name");
								$i = 1;
								$res_1 = mysqli_fetch_assoc($query_1);

								echo '<strong>'.$res_1['store_name'].'</strong>';
								$email = $res_1['email']; $mobile_1 = $res_1['mobile_1']; $address = $res_1['address'];
								echo '<br />Email : '.$email;
								echo '<br />Mobile : '.$mobile_1;
								echo '<br />Address : '.$address;
								?>
						</div>
					</div>
					<div class="col-md-3" style="width: 25%; float: left">
						<div class="panel panel-alt">
							<strong>Invoice Details:</strong>
							<br />
							
								Order #: 
								<?php echo $row_order['order_number']; ?>
								<br />
								Order Date: 
								<?php echo formatDate($row_order['created_at']); ?>
								<br />
								Payment Mode: 
								<?php echo getPaymentMode($row_order['payment_mode']); if($row_order['payment_mode'] == 1) { echo ' - '.getPaymentSub($row_order['payment_sub']); } ?>
								<?php if($row_order['payment_mode'] == 2) { ?>
								<br />
								Transaction #: 
								<?php echo $row_order['transaction_id']; ?>
								<?php } ?>
								<?php if($row_order['payment_date'] != NULL) { ?>
								<br />
								Payment Date #: 
								<?php echo formatDate($row_order['payment_date']); ?>
								<?php } ?>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="row" id="invoice-table">
					<div class="col-md-12" style="margin-top: 20px;">
						<table class="table" width="100%" border="1" cellpadding="4">
							<thead>
								<tr class="primary" style="text-align: left">
									<th>#</th>
									<th id="brand_name">Brand Name</th>
									<th>Product Name</th>
									<th>Variation</th>
									<th>Quantity</th>
									<th style="width: 200px;">Price</th>
									<th style="width: 200px;">Discounted Price</th>
									<th style="width: 200px;" class="text-right pr10">Total Price</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								 $j = 0;
								foreach($order_details as $od) 
								{
									$product_name = $od['product_name'];
									$brand_name = $od['brand_name'];
									$varaition = $od['net_measure'].' '.$od['measure_type'];
									$quantity = $od['quantity'];
									$price_finale = $od['price_finale'];
									$price_discounted = $od['price_discounted'];
									$price_total = $od['price_total'];
									echo '<tr>';

									if($j == 0)
									{
										echo '<td><b>'.$i.'</b></td>';
										echo '<td class="product_n">'.$brand_name.'</td>';
										echo '<td>'.$product_name.'</td>';
										echo '<td><b>'.$varaition.'</b> </td>';
									}
									else
									{
										echo '<td style="border-top:none; border-bottom:none"></td>';
										echo '<td style="border-top:none; border-bottom:none"></td>';
										echo '<td style="border-top:none; border-bottom:none"></td>';
									}

									echo '<td>'.$quantity.'</td>';
									//echo '<td>'.$odv['items_in_set'].'</td>';
									echo '<td>₹ '.$price_finale.'</td>';
									echo '<td>₹ '.$price_discounted.'</td>';
									echo '<td class="text-right pr10"o>₹ '.$price_total.'</td></tr>';

									$i++;

								}
								$j++;
							?>
							</tbody>
						</table>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td style="text-align: left">
							<div class="pull-left mt20 fs15 text-primary"> <br /><br /><br /><br /><strong>Thank you for your business.</strong></div>
						</td>
						<td style="width: 50%; text-align: left">
							<table width="100%">
							<tr>
								<td colspan="5">&nbsp;</td>
								<td colspan="2"></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td colspan="2" style="text-align: right"><b>Sub Total:</b></td>
								<td style="text-align: right">₹ <?php echo ($row_order['price_raw']); ?></td>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td colspan="2" style="text-align: right"><b>GST Included:</b></td>
								<td style="text-align: right">₹ <?php echo $row_order['price_gst']; ?></ttdh>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td colspan="2" style="text-align: right"><b>Delivery Charges:</b></td>
								<td style="text-align: right">₹ <?php echo $row_order['price_delivery_charge']; ?></td>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td colspan="2" style="text-align: right"><b>Balance Due:</b></td>
								<td style="text-align: right">₹ <?php echo $row_order['price_total']; ?></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
<?php 

//exit;

$message = ob_get_contents();
ob_end_clean();
		
		$mail = new PHPMailer();

		//$mail->IsSMTP();  // telling the class to use SMTP
		//$mail->Host     = "smtp.example.com"; // SMTP server

		//$mail->From     = "shirishm.makwana3@gmail.com";
		//$mail->From     = $admin_email;
		$mail->SetFrom($admin_email, 'info');

		//$mail->AddAddress("shirishm.makwana@gmail.com");
		$mail->AddAddress($to_email);
		$mail->AddAddress($admin_email);

		$mail->Subject  = $subject;
		$mail->IsHTML(true);
		$mail->Body     = $message;
		//$mail->WordWrap = 50;

		/*$header 	= "From:".$admin_email." \r\n";
		$header 	.= "MIME-Version: 1.0\r\n";
		$header 	.= "Content-type: text/html\r\n";*/

		//if(mail($to, $subject, $message, $header))
		if($mail->Send())
		{
			//echo 'mail sent';
			return true;
		}
		else
		{
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			//echo 'mail send error';
			return false;
			//return true;
		}
	}
}
