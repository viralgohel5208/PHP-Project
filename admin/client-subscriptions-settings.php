<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

if ( isset( $_POST[ 'save_settings' ] ) )
{
	//echo '<pre>'; print_r($_REQUEST); exit;
	
	$item_id = escapeInputValue($_GET[ 'id' ]);
	
	if(isset($_POST['customer_account_verification'])) {
		$customer_account_verification = 1; 
	} else {
		$customer_account_verification = 0;
	}
	
	if(isset($_POST['order_tracking'])) {
		$order_tracking = 1; 
	} else {
		$order_tracking = 0;
	}

	if(isset($_POST['inhouse_delivery_tracking'])) {
		$inhouse_delivery_tracking = 1; 
	} else {
		$inhouse_delivery_tracking = 0;
	}

	if(isset($_POST['can_create_customer_backend'])) {
		$can_create_customer_backend = 1; 
	} else {
		$can_create_customer_backend = 0;
	}

	if(isset($_POST['premium_normal_customer'])) {
		$premium_normal_customer = 1; 
	} else {
		$premium_normal_customer = 0;
	}
	
	if(isset($_POST['payment_mode'])) {
		$payment_mode = $_POST['payment_mode'];
	} else {
		$payment_mode = [];
	}
	
	if(isset($_POST['payment_sub']) && in_array(1, $payment_mode)) {
		$payment_sub = $_POST['payment_sub'];
	} else {
		$payment_sub = [];
	}
	
	if(empty($payment_mode))
	{
		$error = "Please select payment mode.";
	}
	else
	{
		$payment_mode_str = implode(",", $payment_mode);
	}

	if($error == "")
	{
		if(!empty($payment_mode) && in_array(1, $payment_mode) && empty($payment_sub))
		{
			$error = "Please select payment sub.";
		}
		$payment_sub_str = implode(",", $payment_sub);
	}
	
	if($error == "")
	{
		$query = "UPDATE app_settings SET customer_account_verification = '" . $customer_account_verification . "', order_tracking = '" . $order_tracking . "', inhouse_delivery_tracking = '" . $inhouse_delivery_tracking . "', can_create_customer_backend = '". $can_create_customer_backend ."', premium_normal_customer = '". $premium_normal_customer ."', available_payment_mode = '" . $payment_mode_str . "', available_payment_sub = '" . $payment_sub_str . "', updated_at = '" . $current_datetime . "' WHERE app_id = $item_id";

		$result = mysqli_query( $link, $query );

		if ( !$result )
		{
			$error = $sww;
		}
		else
		{
			$success = "Details has been updated successfully";
		}
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query = "SELECT * FROM app_settings WHERE app_id = $item_id";
	$result = mysqli_query( $link, $query);
	if ( !$result )
	{
		echo $error_500 = 500;
		exit;
	}
	else
	{
		if(mysqli_num_rows($result) > 0 )
		{
			$row = mysqli_fetch_assoc( $result );
		}
		else
		{
			$query_ins = "INSERT INTO `app_settings`(`app_id`) VALUES ($item_id)";
			$res_ins = mysqli_query($link, $query_ins);

			$query = "SELECT * FROM app_settings WHERE app_id = ".$item_id;
			$result = mysqli_query($link, $query);
			if(!$result)
			{
				$error_500 = 500;
			}
			else
			{
				if(mysqli_num_rows($result) > 0)
				{
					$row = mysqli_fetch_assoc($result);
				}
			}
		}
		
		if($row['available_payment_mode'] == "")
		{
			$available_payment_mode = [];
		}
		else
		{
			$available_payment_mode = explode(",", $row['available_payment_mode']);
		}

		if($row['available_payment_sub'] == "")
		{
			$available_payment_sub = [];
		}
		else
		{
			$available_payment_sub = explode(",", $row['available_payment_sub']);
		}

		//$available_payment_sub = explode(",", $row['available_payment_sub']);
		//echo '<pre>'; print_r($available_payment_sub);

	}
}

$page_title = "Client Subscriptions Settings";

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title><?php echo $page_title.' - '.$application_name; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="form-inputs-page">
	<div id="main">
		<?php require_once "header.php"; ?>
		<?php require_once "sidebar.php"; ?>
		<section id="content_wrapper">
			<header id="topbar">
				<div class="topbar-left">
					<ol class="breadcrumb">
						<li class="crumb-active">
							<a href=""><?php echo $page_title; ?></a>
						</li>
						<li class="crumb-icon">
							<a href="index.php"><span class="glyphicon glyphicon-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-link">
							<a href="client-subscriptions.php">Subscription Settings</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
			</header>
			<div id="content" class="animated fadeIn">
				<div class="row">
					<div class="col-md-12">
						<?php require_once "message-block.php"; ?>
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title"><span class="glyphicon glyphicon-cog"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post">
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Customer Account Verification</label>
                                        <div class="col-lg-7 admin-form">
                                            <label class="switch block mn mt5">
                                                <input type="checkbox" name="customer_account_verification" id="t1" value="1" 
                                                <?php if($row['customer_account_verification'] == 1){echo 'checked="checked"'; } ?> >
                                                <label for="t1" data-on="YES" data-off="NO"></label>
												<span class="help-block" style="font-size: 13px;">(Display todays agendas list in application by default)</span>
                                            </label>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Order Tracking</label>
                                        <div class="col-lg-7 admin-form">
                                            <label class="switch block mn mt5">
                                                <input type="checkbox" name="order_tracking" id="t2" value="1" 
                                                <?php if($row['order_tracking'] == 1){echo 'checked="checked"'; } ?> >
                                                <label for="t2" data-on="YES" data-off="NO"></label>
												<span class="help-block" style="font-size: 13px;">(Display todays workshop list in application by default)</span>
                                            </label>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Inhouse Delivery Tracking</label>
                                        <div class="col-lg-7 admin-form">
                                            <label class="switch block mn mt5">
                                                <input type="checkbox" name="inhouse_delivery_tracking" id="t3" value="1" 
                                                <?php if($row['inhouse_delivery_tracking'] == 1){echo 'checked="checked"'; } ?> >
                                                <label for="t3" data-on="YES" data-off="NO"></label>
												<span class="help-block" style="font-size: 13px;">(Display todays workshop list in application by default)</span>
                                            </label>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Create Customers From Backend</label>
                                        <div class="col-lg-7 admin-form">
                                            <label class="switch block mn mt5">
                                                <input type="checkbox" name="can_create_customer_backend" id="t4" value="1" 
                                                <?php if($row['can_create_customer_backend'] == 1){echo 'checked="checked"'; } ?> >
                                                <label for="t4" data-on="YES" data-off="NO"></label>
												<span class="help-block" style="font-size: 13px;">(Display create customer button in the client backend panel)</span>
                                            </label>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Normal/Premium Customer Type</label>
                                        <div class="col-lg-7 admin-form">
                                            <label class="switch block mn mt5">
                                                <input type="checkbox" name="premium_normal_customer" id="t5" value="1" 
                                                <?php if($row['premium_normal_customer'] == 1){echo 'checked="checked"'; } ?> >
                                                <label for="t5" data-on="YES" data-off="NO"></label>
												<span class="help-block" style="font-size: 13px;">(Allow Normal/Premium Type Customer Functionality)</span>
                                            </label>
                                        </div>
                                    </div>
									
									<?php /*?><div class="form-group">
                                        <label class="col-lg-3 control-label">Available Payment Mode</label>
										<div class="col-md-7">
											<?php 
											$listpaymentmode = listPaymentMode();
											foreach($listpaymentmode as $key=>$value)
											{
												echo '<label class="checkbox-inline mr10">';
												echo '<input type="checkbox" name="payment_mode[]" value="'.$key.'" ';
												if(in_array($key, $available_payment_mode)) {
													echo ' checked="checked"';
												}
												echo '>'.$value;
												echo '</label>';
											}
											?>
										</div>
                                    </div><?php */?>
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Available Payment Mode</label>
										<div class="col-md-7">
											<?php 
											$listpaymentmode = listPaymentMode();
											$i = 0;
											foreach($listpaymentmode as $key=>$value)
											{
												echo '<div class="checkbox-custom checkbox-inline mr10" style="padding-left:0">';
												echo '<input type="checkbox" id="checkboxDefault'.$i.'" name="payment_mode[]" value="'.$key.'" ';
												if(in_array($key, $available_payment_mode)) {
													echo ' checked="checked"';
												}
												echo '>';
												echo '<label for="checkboxDefault'.$i.'">'.$value.'</label>';
												echo '</div>';
												$i++;
											}
											?>
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Payment Sub (Cash on Delivery Only)</label>
										<div class="col-md-7">
											<?php 
											$listpaymentsub = listPaymentSub();
											foreach($listpaymentsub as $key=>$value)
											{
												echo '<div class="checkbox-custom checkbox-inline mr10" style="padding-left:0">';
												echo '<input type="checkbox" id="checkboxDefault'.$i.'" name="payment_sub[]" value="'.$key.'" ';
												if(in_array($key, $available_payment_sub)) {
													echo ' checked="checked"';
												}
												echo '>';
												echo '<label for="checkboxDefault'.$i.'">'.$value.'</label>';
												echo '</div>';
												$i++;
											}
											?>
										</div>
                                    </div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="save_settings" class="btn btn-success">Save</button>
											<a href="" class="btn btn-warning">Cancel</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function () {
			"use strict";
			// Init Theme Core
			Core.init();
			// Init Demo JS
			Demo.init();
		} );
	</script>
</body>
</html>