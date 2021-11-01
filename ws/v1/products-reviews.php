<?php
/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/products-reviews.php?app_id=1&customer_id=1&product_id=4&page=1
*/

header("Content-type: text/plain");	// Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['customer_id'])  || !isset($_REQUEST['product_id']) || !isset($_REQUEST['page']))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$product_id 	= escapeInputValue($_REQUEST['product_id']);
	$page 			= escapeInputValue($_REQUEST['page']);
	
	if($page <= 1) {
		$start = 0;
	} else {
		$start = ($page - 1) * $limit;
	}
	
	$start = ($page - 1) * $limit;
	
	if($app_id == "" || $product_id == "")
	{
		$error_code = 1; $error_string = 'Please enter all details';
	}
}

if($error_code == 0)
{
	$query = "SELECT id FROM products WHERE id = $product_id AND app_id = $app_id LIMIT 1";
	
	$result = mysqli_query($link, $query);
	
	if(!$result)
	{
		$error_code = 2; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 3; $error_string = "Product does not found";;
	}
}

if($error_code == 0)
{
	$my_reviews = [];
	
	if($customer_id != "")
	{
		$pro_query = "SELECT R.*, C.first_name, C.last_name FROM products_reviews AS R INNER JOIN customers AS C ON C.id = R.customer_id WHERE R.app_id = '$app_id' AND R.product_id = '$product_id' AND R.customer_id = $customer_id";

		$result = mysqli_query($link, $pro_query);

		if(!$result)
		{
			$error_code = 4; $error_string = $sww;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$my_reviews[] = $row;
			}
		}
	}
}

if($error_code == 0)
{
	$other_reviews = [];
	
	$pro_query = "SELECT R.*, C.first_name, C.last_name FROM products_reviews AS R INNER JOIN customers AS C ON C.id = R.customer_id WHERE R.app_id = '$app_id' AND R.product_id = '$product_id' AND R.customer_id != $customer_id LIMIT $start, $limit";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 5; $error_string = $sww;
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$other_reviews[] = $row;
		}
	}
}

if($error_code == 0)
{
	$data = ['my_reviews' => $my_reviews, 'other_reviews' => $other_reviews ];
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>