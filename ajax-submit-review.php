<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "login-required.php";

if(isset($_POST))
{
	//echo '<pre>'; print_r($_POST); exit;
	//$app_id, $customer_id;	
	$product_id 		= escapeInputValue($_POST['pd']);
	$star_rating 		= escapeInputValue($_POST['review_star']);
	$comment_details	= escapeInputValue($_POST['comment_details']);
	
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
			$total_star_customers 	= $row['total_star_customers'];
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
		else if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
		
			$review_id 		= $row['id'];
			$star_rating_db = $row['star_rating'];

			$query_1 = "UPDATE `products_reviews` SET `star_rating` = $star_rating, `comment_details` = '$comment_details' WHERE id = $review_id";

			$result_1 = mysqli_query($link, $query_1);

			if(!$result_1)
			{
				$error_code = 5; $error_string = $sww;
			}
			else
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
		}
		else 
		{
			$query_1 = "INSERT INTO `products_reviews`(`app_id`, `customer_id`, `product_id`, `star_rating`, `comment_details`, `created_at`, `updated_at`) VALUES ($app_id, $customer_id, $product_id, $star_rating, '$comment_details', '$current_datetime', '$current_datetime')";

			$result_1 = mysqli_query($link, $query_1);

			if(!$result_1)
			{
				$error_code = 5; $error_string = $sww;
			}
			else
			{
				$total_star_count = $total_star_count + $star_rating;
				$total_star_customers = $total_star_customers + 1;

				$query_1 = "UPDATE `products` SET `total_star_count` = $total_star_count, `total_star_customers` = $total_star_customers WHERE id = $product_id";

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
		}
	}
	
	if($error_code == 0)
	{
		echo 1;
	}
	else
	{
		echo $error_code;
	}
}
?>
