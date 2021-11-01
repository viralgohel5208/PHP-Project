<?php

/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/products-filter.php?app_id=1&customer_id=1&category_id=&product_name=&brand_name=&min_price=&max_price=&sort=&page=1
*
*	Sort = 1 : Price Lowest to high, 2 : Price highest to low
*/

header("Content-type: text/plain");	// Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['customer_id'])  || !isset($_REQUEST['category_id']) || !isset($_REQUEST['product_name'])  || !isset($_REQUEST['brand_name']) || !isset($_REQUEST['min_price'])  || !isset($_REQUEST['max_price']) || !isset($_REQUEST['sort']) || !isset($_REQUEST['page']))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$category_id 	= escapeInputValue($_REQUEST['category_id']);
	$product_name 	= escapeInputValue($_REQUEST['product_name']);
	$brand_name 	= escapeInputValue($_REQUEST['brand_name']);
	$min_price 		= escapeInputValue($_REQUEST['min_price']);
	$max_price 		= escapeInputValue($_REQUEST['max_price']);
	$sort 			= escapeInputValue($_REQUEST['sort']);
	$page 			= escapeInputValue($_REQUEST['page']);
	
	if($page <= 1) {
		$start = 0;
	} else {
		$start = ($page - 1) * $limit;
	}
	
	$start = ($page - 1) * $limit;
	
	if($app_id == "")
	{
		$error_code = 2; $error_string = 'Please enter all details';
	}
}

if($error_code == 0)
{
	$premium_normal_customer = 0;
	$customer_type = 0;
	
	if($customer_id != "" && $customer_id != 0)
	{
		$res_query = mysqli_query($link, "SELECT premium_normal_customer FROM app_settings WHERE app_id = $app_id");
		if($res_query)
		{
			$row_query = mysqli_fetch_assoc($res_query);
			$premium_normal_customer = $row_query['premium_normal_customer'];
		}

		if($premium_normal_customer == 1)
		{
			$res_query = mysqli_query($link, "SELECT customer_type FROM customers WHERE app_id = $app_id AND id = $customer_id");
			if($res_query)
			{
				$row_query = mysqli_fetch_assoc($res_query);

				$customer_type = $row_query['customer_type'];
			}
		}
	}
}

if($error_code == 0)
{
	$sql_where_str = "";
	
	$sql_array = ["p.app_id = $app_id"];

	if($product_name != "" || $category_id != "" || $brand_name != "" || $min_price != "" || $max_price != "")
	{
		if($product_name != "")
		{
			$sql_array[] = " p.product_name LIKE '%$product_name%' ";
		}
		if($category_id != "")
		{
			$sql_array[] = " p.category_id = '$category_id' ";
		}
		if($brand_name != "")
		{
			$sql_array[] = " p.brand_name = '%$brand_name%' ";
		}
		if($min_price != "")
		{
			$sql_array[] = " p.price_finale >= '$min_price' ";
		}
		if($max_price != "")
		{
			$sql_array[] = " p.price_finale <= '$max_price' ";
		}
	}
	
	$sql_str = implode(" AND ", $sql_array);
	
	if($sql_str != "")
	{
		$sql_where_str = " WHERE ".$sql_str;
	}
	
	if($sql_where_str == "")
	{
		if($customer_type == 0)
		{
			$sql_where_str .= " WHERE P.privacy_type = 0";
		}
	}
	else
	{
		if($customer_type == 0)
		{
			$sql_where_str .= " AND p.privacy_type = 0";
		}
	}
}

if($error_code == 0)
{
	$pro_query = "SELECT DISTINCT(p.id), p.privacy_type, p.category_id, p.sku_number, p.brand_name, p.product_name, p.file_name, v3.measure_type, v3.net_measure, v3.price_raw, v3.gst_percentage, v3.price_gst, v3.price_finale, p.total_star_count, p.total_star_customers FROM products p JOIN (SELECT v2.product_id, v2.measure_type, v2.net_measure, v2.price_raw, v2.gst_percentage, v2.price_gst, v2.price_finale FROM products_variant v2 JOIN (SELECT product_id, MIN(price_finale) as price_finale FROM products_variant GROUP BY product_id ) v1 USING (product_id, price_finale) ) v3 ON p.id = v3.product_id $sql_where_str";
	if($sort == 1) {
		$pro_query .= " ORDER BY price_finale ASC";
	} else if($sort == 2) {
		$pro_query .= " ORDER BY price_finale DESC";
	}
	$pro_query .= " LIMIT $start, $limit";
	
	//echo $customer_type.'========'; echo $pro_query; exit;
	
	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else
	{
		if(mysqli_num_rows($result) == 0)
		{
			//$error_code = 4; $error_string = 'No products found';
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$product_id = $row['id'];
				
				/*$file_name_array = $row['file_name'];
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
				}*/
				
				$row['file_name'] = getFileImageArray($app_id, 2, $row['file_name']);
				
				//$row['file_name'] = $images;
				
				// Fetch Variants Details
				/*$variants = [];
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
				$row['variants'] = $variants;*/
				// Fetch Variants Details
				$variants = getProductVariants($app_id, $product_id, $customer_id);
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