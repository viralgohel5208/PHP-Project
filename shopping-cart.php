<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";
require_once "login-required.php";
require_once "app-details-include.php";

$page_title = "Shopping Cart";


if(isset($_POST['product_id']) && isset($_POST['product_id']))
{
	$product_id = escapeInputValue($_POST['product_id']);
	$variant_id = escapeInputValue($_POST['variant_id']);
	
	$query_1 = "DELETE FROM `customers_cart` WHERE app_id = $app_id AND customer_id = $customer_id AND product_id = $product_id AND variant_id = $variant_id";

	$result_1 = mysqli_query($link, $query_1);

	if(!$result_1)
	{
		$error = $sww;
	}
	else
	{
		if(isset($_SESSION['cust_cart'][$product_id.'_'.$variant_id]))
		{
			unset($_SESSION['cust_cart'][$product_id.'_'.$variant_id]);
		}
	}
	
	if($error == "")
	{
		$success = "Product has been removed from cart";
	}
}

$cart_items = [];

$pro_query = "SELECT C.variant_id, C.product_id, C.quantity, P.*, V.* FROM customers_cart AS C INNER JOIN products AS P ON P.id = C.product_id INNER JOIN products_variant AS V ON V.id = C.variant_id WHERE C.app_id = '$app_id' AND customer_id = '$customer_id'";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		echo $sww; exit;
	}
	else
	{
		while($row_2 = mysqli_fetch_assoc($result))
		{
			$product_id = $row_2['product_id'];
			$variant_id = $row_2['variant_id'];

			//$cart = checkCustomerCart($app_id, $customer_id, $product_id, $variant_id);
			//$row_2['cart_quantity'] = $cart;

			$file_name_str = $row_2['file_name'];
			$images = getFileImageArray($app_id, 2, $file_name_str);
			$row_2['file_name'] = $images;

			$cart_items[] = $row_2;
		}
	}

//echo '<pre>'; print_r(cart_items); echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo $page_title." - ".$application_name; ?></title>
	<meta name="description" content="">
	<meta name="keywords" content=""/>

	<!-- Mobile specific metas  -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php require_once "include/general-css.php"; ?>

	<!-- owl.carousel CSS -->
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="css/owl.theme.css">

	<!-- animate CSS  -->
	<link rel="stylesheet" type="text/css" href="css/animate.css" media="all">

	<!-- jquery-ui.min CSS  -->
	<link rel="stylesheet" href="css/jquery-ui.css">

	<!-- main CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css" media="all">

	<!-- style CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/shortcodes/shortcodes.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/custom.css" media="all">
</head>
<body class="shopping_cart_page">
	
	<!-- mobile menu -->
	<?php require_once "include/header-mobile-menu.php"; ?>
	<!-- end mobile menu -->
	
	<div id="page">
		
		<!-- Header -->
		<?php require_once "include/header-top.php"; ?>
		<!-- end header -->

		<!-- Navbar -->
		<?php require_once "include/header-navbar.php"; ?>
		<!-- end nav -->
		
		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<ul>
							<li class="home"> <a title="Go to Home Page" href="index.php">Home</a><span>&raquo;</span></li>
							<li class="category13"><strong>Shopping Cart</strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->

		<!-- Main Container -->
		<section class="main-container col1-layout wow animated" style="margin-bottom: 100px;">
			<div class="main container">
				<div class="col-main">
					<div class="cart">
						<div class="page-title">
							<h2>Shopping Cart</h2>
						</div>
						
						<?php if(empty($cart_items)) { ?>
						
						<h4 style="margin-top: 100px;">Your cart is empty. Add Something!!</h4>
						
						<div class="page-order"><div class="cart_navigation"> <a class="continue-btn" href="categories.php"><i class="fa fa-arrow-left"> </i>&nbsp; Continue shopping</a></div></div>
						
						<?php } else { ?>
						<div class="page-content page-order">
							<?php /*?>	<ul class="step">
							<li class="current-step"><span>01. Summary</span>
								</li>
								<li><span>02. Sign in</span>
								</li>
								<li><span>03. Address</span>
								</li>
								<li><span>04. Shipping</span>
								</li>
								<li><span>05. Payment</span>
								</li>
							</ul><?php */?>
							
							<?php require_once "message-block.php"; ?>
							
							<div class="heading-counter warning">Your shopping cart contains: <span><?php echo count($cart_items); ?> Product(s)</span> </div>
							<div class="order-detail-content">
								<div class="table-responsive">
									<table class="table table-bordered cart_summary">
										<thead>
											<tr>
												<th class="cart_product">Product</th>
												<th>Description</th>
												<th>Avail.</th>
												<th>Unit price</th>
												<th>Qty</th>
												<th>Total</th>
												<th class="action"><i class="fa fa-trash-o"></i>
												</th>
											</tr>
										</thead>
										<tbody>
<?php $cart_total = 0; foreach($cart_items as $item) {
	
$product_id 	= $item['product_id'];
$variant_id 	= $item['variant_id'];
$price_finale 	= $item['price_finale'];
$offer_type 	= $item['offer_type'];
$offer_value 	= $item['offer_value'];
$expires_at 	= $item['expires_at'];
$offer_price 	= $item['offer_price'];
$cart_quantity 	= $item['quantity'];
$stock_amount 	= $item['stock_amount']; //echo $i;

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

$pro_q_total_price = $sale_price * $cart_quantity;

if($stock_amount > 0 && $stock_amount > $cart_quantity)
{
	$cart_total = $cart_total + $pro_q_total_price;
}
	
echo '<tr>';
echo '<td class="cart_product"><a href="products-details.php?pro='.safe_encode($product_id).'"><img src="'.$item['file_name'][0].'" alt="'.$item['product_name'].'"></a></td>';
echo '<td class="cart_description">';
echo '<p class="product-name"><a href="products-details.php?pro='.safe_encode($product_id).'">'.$item['product_name'].'</a></p>';
echo '<small><a href="products-details.php?pro='.safe_encode($product_id).'">'.$item['net_measure'].' '.$item['measure_type'].' </a></small>';
echo '<br />';

if($customer_offer > 0){
	
	if($customer_offer == 1 && $offer_value != "")
	{
		echo '<br />';
		echo '<a href="#">Get '.$offer_value.'% Discount</a>';
	}
	
	if($customer_offer == 2 && $offer_value != "")
	{
		$exp_offer_value 	= explode(',', $offer_value);
		$product_id_free 	= $exp_offer_value[0];
		$variant_id_free 	= $exp_offer_value[1];

		$getFreeProductDetail = getFreeProductDetail($app_id, $product_id_free, $variant_id_free);
		echo '<br />';
		echo 'Free: <a href="products-details.php?pro='.safe_encode($getFreeProductDetail['id']).'">'.$getFreeProductDetail['product_name'].' '.$item['measure_type'].' </a>';
	}
	
}
echo '</td>';

if($stock_amount > 0)
{
	echo '<td class="availability in-stock"><span class="label">In stock</span></td>';
}
else
{
	echo '<td class="availability in-stock"><span class="label" style="background-color:#f44336;">Out Of stock</span></td>';
}
echo '<td class="price"><span>₹ '.customNumberFormat($sale_price).'</span></td>';
echo '<td class="qty"><input class="form-control input-sm" type="text" value="'.$cart_quantity.'" onBlur="changed_qty(this, \''.$product_id.'\', \''.$variant_id.'\')" id="quantity_'.$product_id.'_'.$variant_id.'"></td>';
echo '<td class="price"><span id="pro_qty_price_'.$product_id.'_'.$variant_id.'">₹ '.customNumberFormat($pro_q_total_price).'</span></td>';
echo '<td class="action"><a style="cursor:pointer" onClick="deleteCartItem('.$product_id.','.$variant_id.')"><i class="icon-close"></i></a></td>';
echo '</tr>';
} 

$_SESSION['cart_total'] = $cart_total;

?>
										</tbody>
										<tfoot>
											<?php /*?><tr>
												<td colspan="2" rowspan="2"></td>
												<td colspan="3">Total products (tax incl.)</td>
												<td colspan="2">$237.88 </td>
											</tr><?php */?>
											<tr>
												<td colspan="2" rowspan="2"></td>
												<td colspan="3"><strong>Total</strong></td>
												<td colspan="2"><strong id="cart_grand_total">₹ <?php echo customNumberFormat($cart_total); ?></strong></td>
											</tr>
										</tfoot>
									</table>
								</div>
								<div class="cart_navigation"> <a class="continue-btn" href="categories.php"><i class="fa fa-arrow-left"> </i>&nbsp; Continue shopping</a> <a class="checkout-btn" href="checkout.php"><i class="fa fa-check"></i> Proceed to checkout</a> </div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</section>
		<!-- our clients Slider -->
		
		<!-- Footer -->
		<?php require_once "include/footer-main.php"; ?>		
		<!-- end Footer -->
		
		<a href="#" class="totop"> </a> </div>

	<form id="delete_form" action="" method="post" style="display: hidden">
		<input type="hidden" id="product_id" name="product_id" value="">
		<input type="hidden" id="variant_id" name="variant_id" value="">
	</form>
	
	<!-- End Footer -->
	<!-- JS -->

	<!-- jquery js -->
	<script type="text/javascript" src="js/jquery.min.js"></script>

	<!-- bootstrap js -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<!-- owl.carousel.min js -->
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>

	<!-- bxslider js -->
	<script type="text/javascript" src="js/jquery.bxslider.js"></script>

	<!--jquery-slider js -->
	<script type="text/javascript" src="js/slider.html"></script>

	<!-- megamenu js -->
	<script type="text/javascript" src="js/megamenu.js"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
		var mega_menu = '0';

		/* ]]> */
	</script>

	<!-- jquery.mobile-menu js -->
	<script type="text/javascript" src="js/mobile-menu.js"></script>

	<!--jquery-ui.min js -->
	<script src="js/jquery-ui.js"></script>

	<!-- main js -->
	<script type="text/javascript" src="js/main.js"></script>

	<!-- jquery.waypoints js -->
	<script type="text/javascript" src="js/waypoints.js"></script>
	
	<script>
	
	function changed_qty(x, product_id, variant_id)
	{
		var quantity = x.value;
		$.ajax({
			url : 'functions-ajax-cart.php',
			type:'POST',
			data: 'type='+3+'&quantity='+quantity+'&product_id='+product_id+'&variant_id='+variant_id,
			success: function(data)
			{
				eval(data);
			},
			error: function(){
				alert("Something went wrong, Please try again");
			}
		});
	}
	
	function deleteCartItem2(product_id, variant_id)
	{
		$.ajax({
			url: 'functions-ajax-cart.php',
			type:'POST',
			data: 'type='+4+'&product_id='+product_id+'&variant_id='+variant_id,
			success: function(data)
			{
				eval(data);
			},
			error: function(){
				alert("Something went wrong, Please try again");
			}
		});
	}
		
	function deleteCartItem(product_id, variant_id)
	{
		if (confirm("Are you sure you want to delete this item?"))
		{
			$("#product_id").val(product_id);
			$("#variant_id").val(variant_id);
			$("#delete_form").submit();
		}
	}
	</script>
</body>
</html>