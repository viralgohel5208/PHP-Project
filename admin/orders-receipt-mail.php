<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";


$order_id = 10;

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
						<td style="width: 50%; text-align: left">
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