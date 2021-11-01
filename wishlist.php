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

$page_title 	= "Wishlist";
$customer_id 	= $_SESSION['cu_customer_id'];

if(isset($_POST['product_id']) && isset($_POST['product_id']))
{
	$product_id = escapeInputValue($_POST['product_id']);
	$variant_id = escapeInputValue($_POST['variant_id']);
	
//if(isset($_POST['delete_id']))
//{
    //$id = $_POST['delete_id'];
	
	$result = "DELETE FROM customers_wishlist WHERE app_id = $app_id AND product_id = '".$product_id."' AND variant_id = '".$variant_id."' ";
	
	if(!mysqli_query($link, $result))
	{
		$error = $sww;
	} 
	else
	{
		unset($_SESSION['cust_wishlist'][$product_id.'_'.$variant_id]);
		$success = "Wishlist has been deleted successfully";
	}
}

$cart_items = [];

$pro_query = "SELECT C.id AS wishlist_id, C.variant_id, C.product_id, P.*, V.* FROM customers_wishlist AS C INNER JOIN products AS P ON P.id = C.product_id INNER JOIN products_variant AS V ON V.id = C.variant_id WHERE C.app_id = '$app_id' AND customer_id = '$customer_id'";

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
							<li class="home"> <a title="My Account" href="my-account.php">My Account</a><span>&raquo;</span></li>
							<li class="category13"><strong>Wishlist</strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs End -->

		<!-- Main Container -->
		<section class="main-container col2-right-layout">
			<div class="main container">
				<div class="row">
					<aside class="left sidebar col-sm-3 col-xs-12">
						<?php require_once "include/account-sidebar.php"; ?>
					</aside>
					<div class="col-main col-sm-9">
						<div class="my-account checkout-page">
							<div class="page-title">
								<h2>Wishlist</h2>
							</div>
							<?php require_once "message-block.php"; ?>
							<div class="box-border">
								<div class="<?php /*?>page-content<?php */?> page-order">
									<div class="heading-counter warning" style="margin: 0 0 20px 0">Your wishlist contains: <span><?php if(isset($_SESSION['cust_wishlist'])) { echo count($_SESSION['cust_wishlist']); } else { echo 0; } ?> Product(s)</span> </div>
									<div class="order-detail-content">
										<div class="table-responsive">
											<table class="table table-bordered cart_summary">
												<thead>
													<tr>
														<th class="cart_product">Product</th>
														<th>Description</th>
														<th>Avail.</th>
														<th>Price</th>
														<th>Add to Cart</th>
														<th class="action"><i class="fa fa-trash-o"></i></th>
													</tr>
												</thead>
												<tbody>
		<?php foreach($cart_items as $item) {

		$product_id 	= $item['product_id'];
		$variant_id 	= $item['variant_id'];
		$price_finale 	= $item['price_finale'];
		$offer_type 	= $item['offer_type'];
		$offer_value 	= $item['offer_value'];
		$expires_at 	= $item['expires_at'];
		$offer_price 	= $item['offer_price'];
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
		echo '<td class="price"><a style="cursor:pointer" onClick="customerCart('.$product_id.','.$variant_id.')"><i class="fa fa-shopping-cart"></i> <span id="cart_string_'.$product_id.'_'.$variant_id.'"> Add to Cart </span></a></td>';

echo '<input type="hidden" id="quantity_'.$variant_id.'" value="1" />';
echo '<input type="hidden" id="flag_'.$variant_id.'" value="1" />';
	
		echo '<td class="action"><a style="cursor:pointer" onClick="deleteWishlist('.$product_id.','.$variant_id.')"><i class="icon-close"></i></a></td>';
		echo '</tr>';
		} 


		?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</form>	
						</div>
					</div>
				</div>
				<form id="delete_form" action="wishlist.php" method="post" style="display: hidden">
					<input type="hidden" id="product_id" name="product_id" value="">
					<input type="hidden" id="variant_id" name="variant_id" value="">
				</form>
			</div>
		</section>
		<!-- our clients Slider -->
		
		<!-- Footer -->
		<?php require_once "include/footer-main.php"; ?>		
		<!-- end Footer -->
		
		<a href="#" class="totop"> </a> </div>

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
	<script type="text/javascript">
	
	function customerCart(product_id, variant_id)
	{
		<?php if(!isset($_SESSION['cu_customer_id'])) { $_SESSION['prev_page'] = $full_url; echo 'window.location.href="login.php";'; } ?>
		
		//var product_id = parseInt($('#product_id').val());
		//var variant_id = parseInt($('#variant_id').val());
		var quantity = parseInt($('#quantity_'+variant_id).val());
		var flag = parseInt($('#flag_'+variant_id).val());
		
		//alert(product_id+' - '+variant_id+' - '+quantity+' - '+flag);
		$.ajax({
			type: "POST",
			url: "functions-ajax-cart.php",
			data:'type=1&product_id='+product_id+'&variant_id='+variant_id+'&quantity='+quantity+'&flag='+flag,
			success: function(data){
				//alert(data);
				eval(data);
			},
			error: function(){
				alert("sww");
			}
		});
	}
		
	function deleteWishlist(x, y)
	{
		if(confirm("Are You sure you want to delete this item ?"))
		{
			$("#product_id").val(x);
			$("#variant_id").val(y);
			$("#delete_form").submit();
		}        
	}
	</script>
</body>
</html>