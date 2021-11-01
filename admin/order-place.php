<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";
require_once "../functions-mail.php";

$page_title = "Order Invoice";

if(isset($_POST['submit']))
{
	//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
	if(!isset($_REQUEST['customer_id']))
	{
		$error_code = 1; $error_string = "Please select customer";
	}
	else if (!isset($_REQUEST['store_id']))
	{
		$error_code = 1; $error_string = "Please select store";
	}
	else
	{
		$order_from			= 1;
		$customer_id 		= escapeInputValue($_REQUEST['customer_id']);
		$address_id 		= 0; //escapeInputValue($_REQUEST['address_id']);
		$store_id 			= escapeInputValue($_REQUEST['store_id']);
		$payment_mode 		= 1; //escapeInputValue($_REQUEST['payment_mode']);
		$payment_sub 		= 0; //escapeInputValue($_REQUEST['payment_sub']);
		$latitude 			= 0; //escapeInputValue($_REQUEST['latitude']);
		$longitude 			= 0; //escapeInputValue($_REQUEST['longitude']);
		$delivery_charge 	= 0; //escapeInputValue($_REQUEST['delivery_charge']);
		$transaction_id 	= ""; //escapeInputValue($_REQUEST['transaction_id']);
		$payment_status 	= 1; //escapeInputValue($_REQUEST['payment_status']);
		$payment_date 		= date("Y-m-d H:i:s");
	}
	
	if($error_code == 0)
	{
		$order_number = 'ORD-'.time();
		mysqli_autocommit($link, FALSE);

		$ord_price_raw 			= 0;
		$ord_price_gst 			= 0;
		$ord_price_finale 		= 0;
		$ord_price_discounted 	= 0;
		$ord_price_total 		= 0;
	}
	
	if(isset($_POST['category_id']))
	{
		$category_id_array = $_POST['category_id'];
		$count_pro = count($category_id_array);
		if($count_pro > 0 && $category_id_array[0] == "")
		{
			$error_code = 1; $error_string = "Please add products";
		}
		else
		{
			$product_id_array 	= $_POST['product_id'];
			$variant_id_array 	= $_POST['variant_id'];
			$quantity_array 	= $_POST['quantity'];
		}
	}
	else
	{
		$error_code = 1; $error_string = "Please add products";
	}
	
	// main Order table entry
	if($error_code == 0)	
	{
		//ord_price_total is included with delivery_charge
		//ord_price_total = ord_price_discounted + $delivery_charge;

		$query = "INSERT INTO `orders`(`order_from`, `app_id`, `store_id`, `customer_id`, `order_number`, `payment_mode`, `payment_sub`, `address_id`, `latitude`, `longitude`, `transaction_id`, `payment_status`, `payment_date`, `created_at`, `status`) VALUES ( $order_from, $app_id, $store_id, $customer_id, '$order_number', '$payment_mode', '$payment_sub', '$address_id', '$latitude', '$longitude', '$transaction_id', '$payment_status', '$payment_date', '$current_datetime', 0)";

		$result6 = mysqli_query($link, $query);
		if(!$result6)
		{
			$error_code = 3; $error_string = $sww;
		}
		else
		{
			$order_id = mysqli_insert_id($link);
		}
	}
	
	if($error_code == 0)
	{
		// Order details table entry
		//if($error_code == 0)
		$i = 0;
		foreach($product_id_array as $pid)
		{
			$product_id = $pid;
			$variant_id = $variant_id_array[$i];
			$quantity 	= $quantity_array[$i];
			
			if($product_id == 0 || $product_id == "")
			{
				$error_code = 4; $error_string = "Please select product id";
			}
			else if($variant_id == 0 || $variant_id == "")
			{
				$error_code = 4; $error_string = "Please select variant id";
			}
			else if($quantity == 0 || $quantity == "")
			{
				$error_code = 4; $error_string = "Product quantity can not be zero";
			}
			else
			{
				$pro_query = "SELECT P.*, V.* FROM products_variant AS V INNER JOIN products AS P ON V.product_id = P.id WHERE V.app_id = '$app_id' AND V.id = '$variant_id' AND P.id = $product_id LIMIT 1";

				$result2 = mysqli_query($link, $pro_query);

				if(!$result2)
				{
					$error_code = 4; $error_string = $sww;
				}
				else if(mysqli_num_rows($result2) == 0)
				{
					$error_code = 5; $error_string = "Order does not found";
				}
				else
				{
					//while($row_2 = mysqli_fetch_assoc($result2))
					$row_2 = mysqli_fetch_assoc($result2);
					{
						//$product_id 	= $row_2['product_id'];
						//$variant_id 	= $row_2['variant_id'];
						$gst_percentage	= $row_2['gst_percentage'];
						$price_raw 		= $row_2['price_raw'];
						$price_gst 		= $row_2['price_gst'];
						$price_finale 	= $row_2['price_finale'];
						$offer_type 	= $row_2['offer_type'];
						$offer_value 	= $row_2['offer_value'];
						$expires_at 	= $row_2['expires_at'];
						$offer_price 	= $row_2['offer_price'];
						//$quantity 		= $row_2['quantity'];
						$stock_amount 	= $row_2['stock_amount'];

						//$pro_q_total_price = $sale_price * $quantity;

						if($stock_amount > 0 && $stock_amount > $quantity)
						{
							$customer_offer = 0;

							if($offer_type == 1 && ($expires_at == NULL || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime))
							{
								$customer_offer = 1;
								$sale_price = $offer_price;
								$old_price = $price_finale;
							}
							else if($offer_type == 2 && ($expires_at == NULL || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime))
							{
								$customer_offer = 2;
								$sale_price = $old_price = $price_finale;
							}
							else
							{
								$sale_price = $old_price = $price_finale;
							}

							if($customer_offer == 1)
							{
								$discount 			= ($sale_price * $offer_value) / 100;
								$price_discounted 	= $price_finale - $discount;
								$price_total 		= $quantity * $price_discounted;

								// Count GST amount and Raw price
								$price_gst 			= ($price_discounted * $gst_percentage) / 100;
								$price_raw 			= $price_discounted - $price_gst;

								// Need to multiply quantity at finle to gst price and row price

								$offer_value = "1:".$customer_offer.":".$offer_value;
							}
							else if($customer_offer == 2)
							{
								$price_discounted 	= $price_finale;
								$price_total 		= $quantity * $price_discounted;
								$exp_offer_value 	= explode(',', $offer_value);
								$product_id_free 	= $exp_offer_value[0];
								$variant_id_free 	= $exp_offer_value[1];

								$offer_value = "1:".$customer_offer.":".$offer_value;
							}
							else
							{
								$price_discounted 	= $price_finale;
								$price_total 		= $quantity * $price_discounted;
							}

							// Add Main Product
							// plus add free product
							$query5 = "INSERT INTO `order_details`(`app_id`, `order_id`, `product_id`, `variant_id`, `quantity`, `offer_reference`, `price_raw`, `price_gst`, `price_finale`, `price_discounted`, `price_total`, `status`) VALUES ('$app_id', '$order_id', '$product_id', '$variant_id', '$quantity', '$offer_value', '$price_raw', '$price_gst', '$price_finale', '$price_discounted', '$price_total', '0')";

							$result5 = mysqli_query($link, $query5);
							if(!$result5)
							{
								$error_code = 6; $error_string = $sww;
								break;
							}

							// Need to multiply quantity at finle to gst price and row price
							$ord_price_raw 			+= ($price_raw * $quantity);
							$ord_price_gst 			+= ($price_gst * $quantity);
							$ord_price_finale 		+= ($price_finale * $quantity);
							$ord_price_discounted 	+= ($price_discounted * $quantity);
							$ord_price_total 		+= $price_total;
						}
					}
				}
			}
			$i++;
		}
	}
	
	if($error_code == 0)
	{
		//ord_price_total is included with delivery_charge
		$ord_price_total = $ord_price_total + $delivery_charge;

		$query6 = "UPDATE `orders` SET `price_raw` = '$ord_price_raw', `price_gst` = '$ord_price_gst', `price_finale` = '$ord_price_finale', `price_discounted` = '$ord_price_discounted', `price_delivery_charge` = '$delivery_charge', `price_total` = '$ord_price_total' WHERE id = $order_id";

		$result6 = mysqli_query($link, $query6);
		if(!$result6)
		{
			$error_code = 7; $error_string = $sww;
		}
		else
		{
			//$order_id = mysqli_insert_id($link);
		}
	}
	
	if($error_code == 0)
	{
		mysqli_autocommit($link, TRUE);
		$data = $order_number;
	}
	
	if($error_code == 0)
	{
		$sql = "SELECT id, user_name, first_name, last_name, email, mobile FROM customers WHERE app_id = $app_id AND id = $customer_id";
        $result = mysqli_query($link, $sql);
		
		if(!$result)
		{
			 $error_code = 2; $error_string = $sww;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			$error_code = 3; $error_string = 'User does not exists';
		}
		else
		{
			$row_user = mysqli_fetch_assoc($result);
			
			$email = $row_user['email'];
			$mobile = $row_user['mobile'];
			
			if($email != "" || $mobile != "")
			{
				// Mail type = 1 = Order Receipt
				$parameters = ['app_id' => $app_id, 'store_id' => $store_id, 'to_email' => $email, 'to_mobile' => $mobile, 'order_id' => $order_id, 'order_number' => $order_number, 'ord_price_total' => $ord_price_total, 'user_data' => $row_user];
				
				// Send mail and sms notiifcation
				$mail_verify = mailCustomerOrderReceipt($parameters);

				if($mail_verify == false)
				{
					//$error_code = 6; 
					//$error_string = 'Email send error, Please retry';
				}
				else
				{
					//$data = 'Mail sent successfully';
				}
			}
		}
	}

	if($error_code != 0)
	{
		$error = $error_code.' - '.$error_string;
	}
	else
	{
		$success = "Order has been placed with order number - ".$order_number;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title.' - '.$application_name; ?></title>
	<meta name="keywords" content=""/>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	<style>
		.delete-wpr { position: relative; }
		.delete { 
			display: block; 
			color: #F44336; 
			text-decoration: none; 
			position: absolute; 
			font-weight: bold; 
			padding: 0px 3px; 
			border: 1px solid; 
			top: 0; 
			left: -22px; 
			font-family: Verdana; 
			font-size: 12px;
		}
		.orders-place-table tbody tr td {
		vertical-align: text-top !important;	
		}
	</style>
</head>

<body class="invoice-page">
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
							<a href="orders.php">Orders</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="orders.php?id=<?php echo $row_order['store_id']; ?>" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>
			</header>
            <section id="content" class="">
				<?php require_once "message-block.php"; ?>
                <div class="panel invoice-panel panel-dark" id="print1">
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-file-text-o"></i> Invoice</span>
					</div>
                    <form method="post" action="">
                    <div class="panel-body p20" id="invoice-item">
                        <div class="row mb30">
                            <div class="col-md-6">
                                <div class="pull-left">
                                    <h1 class="lh10 mt10"> <?php echo $application_name; ?> </h1>
                                    <br />
                                    <h5 class="mn"> Status: <b class="text-danger">Pending</b> </h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pull-right text-right">
                                    <h2 class="invoice-logo-text lh10">INVOICE</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="invoice-info">
                            <div class="col-md-4">
                                <div class="panel panel-alt">
                                    <div class="panel-heading">
                                        <span class="panel-title"> <i class="fa fa-user"></i> Bill To: </span>
                                        <div class="panel-btns pull-right ml10">
                                            <!--<span class="panel-title-sm"> Edit</span>-->
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <address>
                                            <select name="customer_id" class="form-control" onChange="selectCustomer(this.value)">
												<option value="0">Select Customer</option>
												<?php 
												$query_1 = mysqli_query($link, "SELECT id, first_name, last_name FROM customers WHERE app_id = $app_id ORDER BY first_name, last_name");
												while($res_1 = mysqli_fetch_assoc($query_1))
												{
													echo '<option value="'.$res_1['id'].'">'.$res_1['first_name'].' '.$res_1['last_name'].'</option>';
												}
												?>
											</select>
											<div id="customer_details" ></div>
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-alt">
                                    <div class="panel-heading">
                                        <span class="panel-title"> <i class="fa fa-location-arrow"></i> Store:</span>
                                        <div class="panel-btns pull-right ml10">
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <select name="store_id" class="form-control" onChange="selectStores(this.value)">
											<?php 
											$query_1 = mysqli_query($link, "SELECT id, store_name, email, mobile_1, address FROM stores WHERE app_id = $app_id ORDER BY store_name");
											$i = 1;
											while($res_1 = mysqli_fetch_assoc($query_1))
											{
												echo '<option value="'.$res_1['id'].'">'.$res_1['store_name'].'</option>';
												if($i == 1){ $email = $res_1['email']; $mobile_1 = $res_1['mobile_1']; $address = $res_1['address']; }
											}
											?>
										</select>
										<div id="store_details" ><?php 
										echo '<br />Email : '.$email;
										echo '<br />Mobile : '.$mobile_1;
										echo '<br />Address : '.$address;
										?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-alt">
                                    <div class="panel-heading">
                                        <span class="panel-title"> <i class="fa fa-info"></i> Invoice Details: </span>
                                        <div class="panel-btns pull-right ml10"> </div>
                                    </div>
                                    <div class="panel-body">
										<address>
											<b>Order Date: </b>
											<?php echo formatDate(date("y-m-d")); ?>
											<br />
											<b>Payment Mode: </b>
											Cash
											<br />
										</address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="invoice-table">
                            <div class="col-md-12">

<?php $categories = getAppCategories($app_id); ?>
<table id="" class="table orders-place-table">
	<thead>
		<tr class="primary">
			<th style="width: 300px">Category</th>
			<th style="width: 300px">Product</th>
			<th style="width: 300px">Variation</th>
			<th style="width: 100px;">Price</th>
			<th>Discounted Price</th>
			<th style="width: 100px;">Quantity</th>
			<th style="width: 100px; text-align: right" class="text-right pr10">Total Price</th>
		</tr>
	</thead>
	<tbody>
		<tr class="item-row">
			<td class="item-name">
				<div class="delete-wpr">
					<select class="form-control" name="category_id[]" onChange="loadProducts(this)">
						<option value="">Select Category</option>
						<?php echo listCategoryDropdown($categories, isset($_REQUEST['id'])?$_REQUEST['id']:0); ?>
					</select>
					<a class="delete" href="javascript:;" title="" style="display: none;">X</a>
				</div>
			</td>
			<td class="item-name">
				<select name="product_id[]" class="products_dd form-control" onChange="loadVariant(this)">
					<option value="">Select Product</option>
				</select>
			</td>
			<td class="description">
				<select name="variant_id[]" class="variants_dd form-control" onChange="selectedVariant(this)">
					<option value="">Select Variant</option>
				</select>
				<div class="variant_offer"></div>
			</td>
			<td class="finale_price">₹0.00</td>
			<td>
				<input class="cost form-control discounted_price" name="" value="" placeholder="₹0.00" />
			</td>
			<td>
				<input class="qty form-control" name="quantity[]" value="1" />
			</td>
			<td style="text-align: right">
				<span class="price">₹0.00</span>
			</td>
		</tr>
		  <tr id="hiderow">
		    <td colspan="7"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr>
		  <!--<tr>
		      <td colspan="4" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value text-right "><div id="subtotal">₹0.00</div></td>
		  </tr>-->
		  <tr>

		      <td colspan="4" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value text-right"><div id="total">₹0.00</div></td>
		  </tr>
		  <!--<tr>
		      <td colspan="4" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>
		      <td class="total-value text-right"><input class="form-control input-sm" id="paid" value="₹0.00" style="width: 100px; border: none; text-align: right;" /></td>
		  </tr>
		  <tr>
		      <td colspan="4" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance text-right"><div class="due">₹0.00</div></td>
		  </tr>-->
	</tbody>
</table>
								
                                
                            </div>
                        </div>
                    </div>
					<div class="clearfix"></div>
					<div class="invoice-buttons" style="margin-left: 5px;">
						<?php /*?><a href="javascript:window.print()" class="btn btn-default mr10"> <i class="fa fa-print pr5"></i> Print Invoice</a><?php */?>
						<button class="btn btn-primary btn-gradient" type="submit" name="submit"> <i class="fa fa-floppy-o pr5"></i> Submit Order</button>
					</div>
					</form>					
                </div>
            </section>
        </section>
	</div>

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	
	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/custom.js"></script>
	<script type="text/javascript">
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core
            Core.init();
            // Init Demo JS
            Demo.init();
        });
		function printOrder(val) {
			var iframe = document.createElement('iframe');
			iframe.src = '<?php echo $website_url; ?>/print-page.php?id='+val;
			document.body.appendChild(iframe);
		}
    </script>
	<script src='assets/js/order-js-jquery-1.3.2.min.js'></script>
	<script src='assets/js/order-js-example.js'></script>
	<script>
	jQuery(document).ready(function() {

		$('input').click(function(){
			$(this).select();
		});

		$("#paid").blur(update_balance);

		$("#addrow").click(function(){
			/*$(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><input class="form-control" name="" value="" placeholder="Category name" /><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="item-name"><input class="form-control" name="" placeholder="Product Name" value="" /></td><td class="description"><input class="form-control" name="" value="" placeholder="Description" /></td><td>₹ 0.00</td><td><input class="cost form-control" name="" value="0" /></td><td><input class="qty form-control" name="" value="1" /></td><td style="text-align: right"><span class="price">₹0.00</span></td></tr>');*/
			
			$(".item-row:last").after('<tr class="item-row"> \
				<td class="item-name"> \
					<div class="delete-wpr"> \
						<select class="form-control" name="category_id[]" onChange="loadProducts(this)"> \
							<option value="">Select Category</option> \
							<?php echo listCategoryDropdown($categories, isset($_REQUEST['id'])?$_REQUEST['id']:0); ?> \
						</select> \
						<a class="delete" href="javascript:;" title="" style="display: none;">X</a> \
					</div> \
				</td> \
				<td class="item-name"> \
					<select name="product_id[]" class="products_dd form-control" onChange="loadVariant(this)"> \
						<option value="">Select Product</option> \
					</select> \
				</td> \
				<td class="description"> \
					<select name="variant_id[]" class="variants_dd form-control" onChange="selectedVariant(this)"> \
						<option value="">Select Variant</option> \
					</select> \
					<div class="variant_offer"></div> \
				</td> \
				<td class="finale_price">₹0.00</td> \
				<td> \
					<input class="cost form-control discounted_price" name="" value="" placeholder="₹0.00" /> \
				</td> \
				<td> \
					<input class="qty form-control" name="" value="1" /> \
				</td> \
				<td style="text-align: right"> \
					<span class="price">₹0.00</span> \
				</td> \
			</tr>');
			
			if ($(".delete").length > 0) $(".delete").show();
			bind();
		});

		bind();

		$(".delete").live('click',function(){
			$(this).parents('.item-row').remove();
			update_total();
			if ($(".delete").length < 2) $(".delete").hide();
		});
	});
	
	function selectCustomer(x)
	{
		if(x == 0)
		{
			$("#customer_details").html("");
		}
		else
		{
			$.ajax({
				url: 'ajax-general.php',
				data: 'type=9&id='+x,
				type: 'POST',
				success: function(d){
					$("#customer_details").html(d);
				},
				error: function(){
					alert('Something went wrong in selecting category');
				}	
			});
		}
	}
		
	function selectStores(x)
	{
		if(x == 0)
		{
			$("#store_details").html("");
		}
		else
		{
			$.ajax({
				url: 'ajax-general.php',
				data: 'type=11&id='+x,
				type: 'POST',
				success: function(d){
					$("#store_details").html(d);
				},
				error: function(){
					alert('Something went wrong in selecting category');
				}	
			});
		}
	}
		
	function loadProducts(x)
	{
		var y = x.value
		if(y == 0)
		{
			$(x).parents('tr').find('.products_dd').html('<option value="0">Select Product</option>');
			$(x).parents('tr').find('.variants_dd').html('<option value="0">Select Variant</option>');
			$(x).parents('tr').find('.finale_price').html('₹0.00');
			$(x).parents('tr').find('.discounted_price').val('₹0.00');
			$(x).parents('tr').find('.qty').val(1);
			$(x).parents('tr').find('.price').html('₹0.00');
			update_total();
		}
		else
		{
			$.ajax({
				url: 'ajax-general.php',
				data: 'type=3&sub_cat='+y,
				type: 'POST',
				success: function(d){
					//$("#product_id").html(d);
					//$(x).parents('tr').find('.products_dd').val(d);
					$(x).parents('tr').find('.products_dd').html(d);
				},
				error: function(){
					alert('Something went wrong in selecting category');
				}	
			});
		}
	}
		
	function loadVariant(x)
	{
		var y = x.value
		if(y == 0)
		{
			$(x).parents('tr').find('.variants_dd').html('<option value="0">Select Variant</option>');
			$(x).parents('tr').find('.finale_price').html('₹0.00');
			$(x).parents('tr').find('.discounted_price').val('₹0.00');
			$(x).parents('tr').find('.qty').val(1);
			$(x).parents('tr').find('.price').html('₹0.00');
			update_total();
		}
		else
		{
			$.ajax({
				url: 'ajax-general.php',
				data: 'type=4&product_id='+y,
				type: 'POST',
				success: function(d){
					//$("#variant_id").html(d);
					$(x).parents('tr').find('.variants_dd').html(d);
				},
				error: function(){
					alert('Something went wrong in selecting category');
				}	
			});
		}
	}
		
	function selectedVariant(x)
	{
		//alert(x);
		var y = x.value
		if(y == 0)
		{
			$(x).parents('tr').find('.finale_price').html('₹0.00');
			$(x).parents('tr').find('.discounted_price').val('₹0.00');
			$(x).parents('tr').find('.qty').val(1);
			$(x).parents('tr').find('.price').html('₹0.00');
			update_total();
		}
		else
		{
			$.ajax({
				url: 'ajax-general.php',
				data: 'type=10&id='+y,
				type: 'POST',
				success: function(d) {
					eval(d);					
				},
				error: function(){
					alert('Something went wrong in selecting category');
				}	
			});
		}
	}
	</script>
</body>
</html>