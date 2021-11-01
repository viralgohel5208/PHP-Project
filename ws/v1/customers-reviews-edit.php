<?php
/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/customers-reviews-edit.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn&product_id=1&star_rating=1&comment_details=Comment
*/

header("Content-type: text/plain");		//	Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

$checkUserAuthentication = checkUserAuthentication(isset($_REQUEST[ 'app_id' ])?$_REQUEST[ 'app_id' ]:FALSE, isset($_REQUEST[ 'customer_id' ])?$_REQUEST[ 'customer_id' ]:FALSE, isset($_REQUEST[ 'auth_token' ])?$_REQUEST[ 'auth_token' ]:FALSE);

if($checkUserAuthentication['error_code'] != 0)
{
	$error_code = $checkUserAuthentication['error_code'];
	$error_string = $checkUserAuthentication['error_string'];
}
else if(!isset($_REQUEST['product_id']) || !isset($_REQUEST['star_rating']) || !isset($_REQUEST['comment_details']))
{
	$error_code = 1; $error_string = "Variable is missing";
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$product_id 	= escapeInputValue($_REQUEST['product_id']);
	$star_rating 	= escapeInputValue($_REQUEST['star_rating']);
	$comment_details= escapeInputValue($_REQUEST['comment_details']);
}

if($error_code == 0)
{
	$pro_query = "SELECT id, total_star_count, total_star_customers FROM products WHERE app_id = '$app_id' AND id = $product_id LIMIT 1";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 1; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 2; $error_string = 'Product does not found';
	}
	else
	{
		$row = mysqli_fetch_assoc($result);
		
		$total_star_count 		= $row['total_star_count'];
	}
}

if($error_code == 0)
{
	$pro_query = "SELECT id, star_rating FROM products_reviews WHERE app_id = '$app_id' AND customer_id = '$customer_id' AND product_id = $product_id";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 4; $error_string = 'Review does not found';
	}
	else
	{
		$row = mysqli_fetch_assoc($result);
		
		$review_id 		= $row['id'];
		$star_rating_db = $row['star_rating'];
	}
}

if($error_code == 0)
{
	$query_1 = "UPDATE `products_reviews` SET `star_rating` = $star_rating, `comment_details` = '$comment_details' WHERE id = $review_id";

	$result_1 = mysqli_query($link, $query_1);

	if(!$result_1)
	{
		$error_code = 5; $error_string = $sww;
	}
	else
	{
		// Review Updated
	}
}

if($error_code == 0)
{
	$total_star_count = $total_star_count + $star_rating - $star_rating_db;
	
	$query_1 = "UPDATE `products` SET `total_star_count` = $total_star_count WHERE id = $product_id AND app_id = $app_id";

	$result_1 = mysqli_query($link, $query_1);

	if(!$result_1)
	{
		$error_code = 6; $error_string = $sww;
	}
	else
	{
		$data = TRUE;
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>