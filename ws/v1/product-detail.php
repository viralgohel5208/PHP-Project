<?php

/*
*	Get all the details of product
* 	URL: http://localhost/ecom/ws/v1/product-detail.php?app_id=1&customer_id=1&product_id=1
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['customer_id']) || !isset($_REQUEST['product_id']))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$product_id 	= escapeInputValue($_REQUEST['product_id']);
	
	if($app_id == "" || $product_id == "")
	{
		$error_code = 2; $error_string = 'Please enter all details';
	}
}

if($error_code == 0)
{
	$query_1 = "SELECT * FROM products WHERE id = '$product_id'";
	$result = mysqli_query($link, $query_1);

	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 4; $error_string = 'Product does not found';
	}
	else
	{
		$row = mysqli_fetch_assoc($result);
		
		$row['file_name'] = getFileImageArray($app_id, 2, $row['file_name']);
	}
}

if($error_code == 0)
{
	/*$query_2 = "SELECT * FROM products_variant WHERE product_id = '$product_id'";
	$result_2 = mysqli_query($link, $query_2);

	$variants = [];

	while($row_2 = mysqli_fetch_assoc($result_2))
	{
		$variant_id = $row_2['id'];
		
		$row_2['has_offer'] = FALSE;
		
		//Check in the Wish list
		if($customer_id != "")
		{
			$wishlist = checkCustomerWishlist($app_id, $customer_id, $product_id, $variant_id);
			$row_2['wishlist'] = $wishlist;
		}

		// Check if in the the customer cart
		if($customer_id != "")
		{
			$cart = checkCustomerCart($app_id, $customer_id, $product_id, $variant_id);
			$row_2['cart_quantity'] = $cart;
		}
		$variants[] = $row_2;
	}*/
	
	$variants = getProductVariants($app_id, $product_id, $customer_id);

	$row['variants'] = $variants;
	
	// Fetch 2 comments/reviews for product
	/*$reviews = [];
	$pro_query = "SELECT R.*, C.first_name, C.last_name FROM products_reviews AS R INNER JOIN customers AS C ON C.id = R.customer_id WHERE R.app_id = '$app_id' AND R.product_id = '$product_id' ORDER BY id DESC LIMIT 3";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 5; $error_string = $sww;
	}
	else
	{
		while($row_5 = mysqli_fetch_assoc($result))
		{
			$reviews[] = $row_5;
		}
	}*/
	$reviews = getProductReviews($app_id, $product_id, $limit = 3);
	$row['reviews'] = $reviews;
	
	$data = $row;
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>