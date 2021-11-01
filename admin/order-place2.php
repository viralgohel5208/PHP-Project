<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$page_title = "Order Invoice";

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
	<link rel='stylesheet' href='order/css/style2.css'>
	<link rel='stylesheet' href='order/css/print2.css' media="print">
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
							<a href="orders.php?id=<?php echo $row_order['store_id']; ?>">Orders</a>
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
						<div class="widget-menu pull-right mr10">
							<div class="btn-group">
								<button class="btn btn-xs btn-default" onClick="printOrder(<?php echo $order_id;?>)">
									<span class="fa fa-print fa fw"></span> Print This Order
								</button>
							</div>
						</div>
					</div>
                    
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
                                            Customer Name
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-alt">
                                    <div class="panel-heading">
                                        <span class="panel-title"> <i class="fa fa-location-arrow"></i> Address:</span>
                                        <div class="panel-btns pull-right ml10">
                                            <!--<span class="panel-title-sm"> Edit</span>-->
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <address>
											Address                                        
                                        </address>
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
                        <div>
                        <div class="row" id="invoice-table">
                            <div class="col-md-12">
								
<table id="" class="table">
	<thead>
		<tr class="primary">
			<th>#</th>
			<th>Product Name</th>
			<th>Variation</th>
			<th style="width: 100px;">Price</th>
			<th>Discounted Price</th>
			<th>Quantity</th>
			<th class="text-right pr10">Total Price</th>
		</tr>
	</thead>

		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		  
		  <tr class="item-row">
			  <td><div class="delete-wpr"><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="item-name"><input class="form-control" name="" value="Web Updates" /></td>
		      <td class="description"><input class="form-control" name="" value="Monthly web updates" /></td>
		      <td>₹650.00</td>
		      <td><input class="cost form-control" name="" value="500" /></td>
		      <td><input class="qty form-control" name="" value="1" /></td>
		      <td><span class="price">$650.00</span></td>
		  </tr>
		  
		  <tr id="hiderow">
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr>
		  
		  <tr>
		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">$875.00</div></td>
		  </tr>
		  <tr>

		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">$875.00</div></td>
		  </tr>
		  <tr>
		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>
		      <td class="total-value"><input class="form-control input-sm" id="paid" value="$0.00" style="width: 100px" /></td>
		  </tr>
		  <tr>
		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due">$875.00</div></td>
		  </tr>
		
		</table>
								
                                <table class="table ">
                                    <thead>
                                        <tr class="primary">
                                            <th >#</th>
                                            <th id="brand_name">Brand Name</th>
                                            <th>Product Name</th>
                                            <th style="width: 100px;">Variation</th>
											<th>Quantity</th>
                                            <th style="width: 100px;">Price</th>
                                            <th >Discounted Price</th>
											<th class="text-right pr10">Total Price</th>
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
                            </div>
                        </div>
					</div>
                    </div>
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
	<script src='order/js/jquery-1.3.2.min.js'></script>
	<script src='order/js/example2.js'></script>
	<script>
	
jQuery(document).ready(function() {

  $('input').click(function(){
    $(this).select();
  });

  $("#paid").blur(update_balance);
   
  $("#addrow").click(function(){
	$(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><input class="form-control" name="" value="" placeholder="Item name" /><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="description"><input class="form-control" name="" value="" placeholder="Description" /></td><td>₹ 00.00</td><td><input class="cost form-control" name="" value="0" /></td><td><input class="qty form-control" name="" value="1" /></td><td><span class="price">₹00.00</span></td></tr>');
	  
    /*$(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><textarea>Item Name</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="description"><textarea>Description</textarea></td><td><textarea class="cost">$0</textarea></td><td><textarea class="qty">0</textarea></td><td><span class="price">$0</span></td></tr>');*/
    if ($(".delete").length > 0) $(".delete").show();
    bind();
  });
  
  bind();
  
  $(".delete").live('click',function(){
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 2) $(".delete").hide();
  });
  
  $("#cancel-logo").click(function(){
    $("#logo").removeClass('edit');
  });
  $("#delete-logo").click(function(){
    $("#logo").remove();
  });
  $("#change-logo").click(function(){
    $("#logo").addClass('edit');
    $("#imageloc").val($("#image").attr('src'));
    $("#image").select();
  });
  $("#save-logo").click(function(){
    $("#image").attr('src',$("#imageloc").val());
    $("#logo").removeClass('edit');
  });
  
  $("#date").val(print_today());
  
});
	</script>
</body>
</html>