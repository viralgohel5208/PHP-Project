<?php
/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/products-list.php?app_id=1&customer_id=1&category_id=4&page=1
*/

header("Content-type: text/plain");		// Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['customer_id'])  || !isset($_REQUEST['category_id']) || !isset($_REQUEST['page']))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$category_id 	= escapeInputValue($_REQUEST['category_id']);
	$page 			= escapeInputValue($_REQUEST['page']);
	
	if($page <= 1) {
		$start = 0;
	} else {
		$start = ($page - 1) * $limit;
	}
	
	$start = ($page - 1) * $limit;
	
	if($app_id == "" || $category_id == "")
	{
		$error_code = 2; $error_string = 'Please enter all details';
	}
}

if($error_code == 0)
{
	$pro_query = "SELECT * FROM products WHERE app_id = '$app_id' AND category_id = '$category_id' LIMIT $start, $limit";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else
	{
		if(mysqli_num_rows($result) == 0)
		{
			$error_code = 4; $error_string = 'No products found';
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$product_id = $row['id'];
				
				$file_name_array = $row['file_name'];
				if($file_name_array == "")
				{
					$images = [$website_url.'/assets/images/default/default.png'];
				}
				else
				{
					$images = [];
					$ex_file_name = explode(",", $file_name_array);
					foreach($ex_file_name as $fn)
					{
						if($fn != "" && file_exists("../../uploads/store-".$app_id."/products/".$fn))
						{
							$images[] = $website_url."/uploads/store-".$app_id."/products/".$fn;
						}
					}
					
					if(empty($images))
					{
						$images = [$website_url.'/assets/images/default/default.png'];
					}
				}
				
				$row['file_name'] = $images;
				
				// Fetch Variants Details
				$variants = [];
				//$variants = getProductVariants($app_id, $product_id, $customer_id = 0);
				$query_2 = "SELECT * FROM products_variant WHERE app_id = $app_id AND product_id = $product_id";
				$result_2 = mysqli_query($link, $query_2);
				while($row_2 = mysqli_fetch_assoc($result_2))
				{
					$variant_id = $row_2['id'];
					
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
				}
				$row['variants'] = $variants;
				
				$data[] = $row;
			}
		}
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>