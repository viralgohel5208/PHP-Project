<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

if(!isset($_GET['id']))
{
	header("Location:orders.php"); exit;
}
else
{
    $order_id = escapeInputValue($_GET['id']);
    
    $res_order = mysqli_query($link, "SELECT * FROM `orders` WHERE app_id = $app_id AND id = '".$order_id."' LIMIT 1");
    if(!$res_order)
	{
		$_SESSION['msg_error'] = $sww; header("Location:orders.php"); exit;
	}
	else
    {
        if(mysqli_num_rows($res_order) > 0)
        {
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
            //$sql_pro = "SELECT O.*, P.product_name, P.images FROM order_details AS O INNER JOIN `shirts` AS P ON P.id = O.product_id WHERE order_id = '$order_id'";
			
			$sql_pro = "SELECT * FROM order_details WHERE order_id = ".$row_order['id']."";
			
		
            $result_pro = mysqli_query($link, $sql_pro);
		
            if(!$result_pro)
            {
                $_SESSION['msg_error'] = $sww.'s2'; header("Location:orders.php"); exit;
            }
            else
            {	
                if(mysqli_num_rows($result_pro) == 0)
                {
                    $_SESSION['msg_error'] = "Order does not exist"; header("Location:orders.php"); exit;
                }
                else
                {
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
                }
            }
            /************* order details end *************/
        }
        else
        {
            $_SESSION['msg_error'] = "Order doesn't found";
            header("Location:orders.php");
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Orders Invoice -
		<?php echo $application_name; ?>
	</title>
	<meta name="keywords" content=""/>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="assets/custom-1.css">
	<!-- Font CSS (Via CDN) -->
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/custom.css">
	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/img/favicon.ico">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
        <script src="assets/js/html5shiv.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	<style type="text/css" media="print">
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
<body class="invoice-page">
	<div id="main">
		<div class="panel invoice-panel panel-dark" id="print1">
			<div class="panel-body p20" id="invoice-item">
				<div class="row mb30">
					<div class="col-md-6">
						<div class="pull-left">
							<h1 class="lh10 mt10"> <?php echo $application_name; ?> </h1>
							<br />
							<h5 class="mn"> Status: <b class="text-success"><?php if($row_order['status'] == 0) { echo '<span style="color:rgb(43, 115, 102);">'; } else if($row_order['status'] == 1) { echo '<span style="color:#00dd00;">'; } else if($row_order['status'] == 2) { echo '<span style="color:#ff0000;">'; } echo getDeliveryStatus($row_order['status']); ?></span></b> </h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="pull-right text-right">
							<h2 class="invoice-logo-text lh10">INVOICE</h2>
						</div>
					</div>
				</div>
				<div class="row" id="invoice-info">
					<div class="col-md-3" style="width: 25%; float: left">
						<div class="panel panel-alt">
							<div class="panel-heading">
								<span class="panel-title"> <i class="fa fa-user"></i> Bill To: </span>
								<div class="panel-btns pull-right ml10">
									<!--<span class="panel-title-sm"> Edit</span>-->
								</div>
							</div>
							<div class="panel-body">
								<address>
									<strong><?php echo $row_user['first_name'].' '.$row_user['last_name']; ?></strong>
									<br> <?php echo $row_user['mobile']; ?>
									<br> <?php echo $row_user['email']; ?>
									<br>
									<abbr>Reg Date:</abbr> <?php echo formatDate($row_user['created_at']); ?>
								</address>
							</div>
						</div>
					</div>
					<div class="col-md-3" style="width: 25%; float: left">
						<?php if($order_from == 1) { echo ''; } else { ?>
						<div class="panel panel-alt">
							<div class="panel-heading">
								<span class="panel-title"> <i class="fa fa-location-arrow"></i> Address:</span>
								<div class="panel-btns pull-right ml10">
									<!--<span class="panel-title-sm"> Edit</span>-->
								</div>
							</div>
							<div class="panel-body">
								<address>
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

								</address>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-3" style="width: 25%; float: left">
						<div class="panel panel-alt">
							<div class="panel-heading">
								<span class="panel-title"> <i class="fa fa-map"></i> Store:</span>
								<div class="panel-btns pull-right ml10">
								</div>
							</div>
							<div class="panel-body">

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
					</div>
					<div class="col-md-3" style="width: 25%; float: left">
						<div class="panel panel-alt">
							<div class="panel-heading">
								<span class="panel-title"> <i class="fa fa-info"></i> Invoice Details: </span>
								<div class="panel-btns pull-right ml10"> </div>
							</div>
							<div class="panel-body">
								<address>
									<b>Order #: </b>
									<?php echo $row_order['order_number']; ?>
									<br />
									<b>Order Date: </b>
									<?php echo formatDate($row_order['created_at']); ?>
									<br />
									<b>Payment Mode: </b>
									<?php echo getPaymentMode($row_order['payment_mode']); if($row_order['payment_mode'] == 1) { echo ' - '.getPaymentSub($row_order['payment_sub']); } ?>
									<?php if($row_order['payment_mode'] == 2) { ?>
									<br />
									<b>Transaction #: </b>
									<?php echo $row_order['transaction_id']; ?>
									<?php } ?>
									<?php if($row_order['payment_date'] != NULL) { ?>
									<br />
									<b>Payment Date #: </b>
									<?php echo formatDate($row_order['payment_date']); ?>
									<?php } ?>
								</address>
							</div>
						</div>
					</div>
				</div>
				<div <?php /*?>style="overflow: auto;"<?php */?>>
				<div class="row" id="invoice-table">
					<div class="col-md-12">
						<table class="table ">
							<thead>
								<tr class="primary">
									<th>#</th>
									<th id="brand_name">Brand Name</th>
									<th>Product Name</th>
									<th>Variation</th>
									<th>Quantity</th>
									<th style="width: 100px;">Price</th>
									<th style="width: 100px;">Discounted Price</th>
									<th style="width: 100px;" class="text-right pr10">Total Price</th>
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
						<?php 
						/*echo "<pre>";
						print_r($order_details);
						echo "<pre>";*/
						?>
					</div>
				</div>

				<div class="row" id="invoice-footer">
					<div class="col-md-12">
						<div class="pull-left mt20 fs15 text-primary"> <br /><br /><br /><br />Thank you for your business.</div>
						<div class="pull-right" style="width: 40%">
							<table class="table" id="invoice-summary">
								<thead>
									<tr>
										<th style="border-top: 2px solid #eee;"><b>Sub Total:</b></th>
										<th style="border-top: 2px solid #eee;text-align: right">₹ <?php echo ($row_order['price_raw']); ?></th>
									</tr>
									<tr>
										<th style="border-top: 2px solid #eee;"><b>GST Included:</b></th>
										<th style="border-top: 2px solid #eee;text-align: right">₹ <?php echo $row_order['price_gst']; ?></th>
									</tr>
									<tr>
										<th style="border-top: 2px solid #eee;"><b>Delivery Charges:</b></th>
										<th style="border-top: 2px solid #eee;text-align: right">₹ <?php echo $row_order['price_delivery_charge']; ?></th>
									</tr>
									<tr>
										<th style="border-top: 2px solid #eee;"><b>Balance Due:</b></th>
										<th style="border-top: 2px solid #eee;text-align: right">₹ <?php echo $row_order['price_total']; ?></th>
									</tr>
								</thead>
							</table>
						</div>

						<?php /*?><div class="invoice-buttons">
							<a href="javascript:window.print()" class="btn btn-default mr10"><i class="fa fa-print pr5"></i> Print Invoice</a>
							<!--<button class="btn bg-primary bg-gradient" type="button"><i class="fa fa-floppy-o pr5"></i> Save Invoice</button>-->
						</div><?php */?>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	<script> window.print(); </script>
</body>
</html>