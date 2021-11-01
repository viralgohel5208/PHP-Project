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
	$pro_query = "SELECT DISTINCT(p.id), p.app_id, p.privacy_type, p.category_id, p.sku_number, p.brand_name, p.product_name, p.brand_id, p.brand_name, p.product_description, p.file_name, p.offer_type, p.offer_value, p.expires_at, p.total_star_count, p.total_star_customers, p.created_at, p.updated_at, p.status";
	//$pro_query .= ", v3.measure_type, v3.net_measure, v3.price_raw, v3.gst_percentage, v3.price_gst, v3.price_finale, p.total_star_count, p.total_star_customers";
	$pro_query .= " FROM products p JOIN (SELECT v2.product_id, v2.measure_type, v2.net_measure, v2.price_raw, v2.gst_percentage, v2.price_gst, v2.price_finale FROM products_variant v2 JOIN (SELECT product_id, MIN(price_finale) as price_finale FROM products_variant GROUP BY product_id ) v1 USING (product_id, price_finale) ) v3 ON p.id = v3.product_id WHERE p.app_id = '$app_id' AND p.category_id = '$category_id'";
	
	if($customer_type == 0)
	{
		//$pro_query .= " AND P.privacy_type = 0";
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
			$error_code = 4; $error_string = 'No products found';
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
				}
				
				$row['file_name'] = $images;*/
				$row['file_name'] = getFileImageArray($app_id, 2, $row['file_name']);
				
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