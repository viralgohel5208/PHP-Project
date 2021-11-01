<?php

/*
*	Dashboard V1
* 	URL: http://localhost/ecom/ws/v1/dashboard-v1.php?app_id=1&customer_id=1
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-list.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['app_id']))
{
	$error_code = 1; $error_string = "Application id is not set";
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	
	if($app_id == "")
	{
		$error_code = 2; $error_string = "Application id cannot be empty";
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM banners WHERE app_id = $app_id AND status = 1 ORDER BY display_order ASC";
	
	$res_query = mysqli_query($link, $query);

	if($res_query)
	{
		$records = [];

		while($row = mysqli_fetch_assoc($res_query))
		{
			if($row['file_name'] != "" && file_exists("../../uploads/store-".$app_id."/banners/".$row['file_name']))
			{
				$row['file_name'] = $website_url."/uploads/store-".$app_id."/banners/".$row['file_name'];
				$records[] = $row;
			}
		}
		
		$result[] = [
			'display_type' => "91",
			'display_str' => "Banners",
			'display_data' => $records,
		];
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM categories WHERE app_id = $app_id AND status = 1 ORDER BY category_name ASC";
	
	$res_query = mysqli_query($link, $query);

	if($res_query)
	{
		$records = [];
		$data = [];

		while($row = mysqli_fetch_assoc($res_query))
		{
			/*if($row['file_name'] != "" && file_exists("../../uploads/categories/".$row['file_name']))
			{
				$row['file_name'] = $website_url."/uploads/categories/".$row['file_name'];
			}
			else
			{
				$row['file_name'] = $website_url."/assets/images/default/default.png";
			}*/
			$row['file_name'] = getFileImageArray($app_id, 1, $row['file_name'])[0];
			$records[] = $row;
		}

		$id = '';

		foreach($records as $item)
		{
			if($item['parent_id'] == 0)
			{
				$id = $item['id'];
				$item['sub_menu'] = categoryListing($records, $id);
				$data[] = $item;
			}
		}
		
		$result[] = [
			'display_type' => "92",
			'display_str' => "Categories",
			'display_data' => $data,
		];
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM dashboard_settings WHERE app_id = $app_id AND display_value != '' ORDER BY display_order ASC";
	
	$res_query = mysqli_query($link, $query);

	if(!$res_query)
	{
		$error_code = 3; $error_string = $sww;
	}
	else if(mysqli_num_rows($res_query) == 0)
	{
		$error_code = 4; $error_string = "No records found";
	}
	else
	{
		$d_settings = [];
		while($row = mysqli_fetch_assoc($res_query))
		{
			$d_settings[] = $row;
		}
	}
}


if($error_code == 0)
{
	foreach($d_settings as $ds)
	{
		$records = [];
		
		$display_type = $ds['display_type'];
		
		$display_value = $ds['display_value'];
		
		// 1/2 Products List
		if($display_type == 1)
		{
			$query = "SELECT * FROM products WHERE app_id = $app_id AND id IN (".$display_value.") AND status = 1";

			$res_query = mysqli_query($link, $query);

			if(!$res_query)
			{
				$error_code = 5; $error_string = $sww;
			}
			else if(mysqli_num_rows($res_query) == 0)
			{
				//$error_code = 6; $error_string = "";
			}
			else
			{
				while($row = mysqli_fetch_assoc($res_query))
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
					$query_2 = "SELECT * FROM products_variant WHERE app_id = $app_id AND product_id = $product_id";
					$result_2 = mysqli_query($link, $query_2);
					while($row_2 = mysqli_fetch_assoc($result_2))
					{
						$variant_id = $row_2['id'];

						//Check in the Wish list
						if($customer_id != "" && $customer_id != 0)
						{
							$wishlist = checkCustomerWishlist($app_id, $customer_id, $product_id, $variant_id);
							$row_2['wishlist'] = $wishlist;
						}

						// Check if in the the customer cart
						if($customer_id != "" && $customer_id != 0)
						{
							$cart = checkCustomerCart($app_id, $customer_id, $product_id, $variant_id);
							$row_2['cart_quantity'] = $cart;
						}

						$variants[] = $row_2;
					}
					$row['variants'] = $variants;

					$records[] = $row;
				}
			}
		}
		
		// Banner Products - Feat Products - Max 3
		if($display_type == 2)
		{
			//echo $display_value;
			$ex_display_value = explode(",", $display_value);
			
			$row = [];
			foreach($ex_display_value as $ex)
			{
				$ex_file_name = explode(":", $ex);
				
				$image_name = $ex_file_name[0];
				$product_id = $ex_file_name[1];
			
				//echo $website_url."/uploads/store-".$app_id."/banners/".$image_name;
				
				if($image_name != "" && file_exists("../../uploads/store-".$app_id."/banners/".$image_name))
				{
					$row['banner'] = $website_url."/uploads/store-".$app_id."/banners/".$image_name;
					$row['product_id'] = $product_id;
					
					$records[] = $row;
				}
			}
		}
		
		// 4x4 Trending Offers
		if($display_type == 3)
		{
			$query = "SELECT * FROM products WHERE app_id = $app_id AND id IN (".$display_value.") AND status = 1";

			$res_query = mysqli_query($link, $query);

			if(!$res_query)
			{
				$error_code = 7; $error_string = $sww;
			}
			else if(mysqli_num_rows($res_query) == 0)
			{
				//$error_code = 8; $error_string = "";
			}
			else
			{
				while($row = mysqli_fetch_assoc($res_query))
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
					$query_2 = "SELECT * FROM products_variant WHERE app_id = $app_id AND product_id = $product_id";
					$result_2 = mysqli_query($link, $query_2);
					while($row_2 = mysqli_fetch_assoc($result_2))
					{
						$variant_id = $row_2['id'];

						//Check in the Wish list
						if($customer_id != "" && $customer_id != 0)
						{
							$wishlist = checkCustomerWishlist($app_id, $customer_id, $product_id, $variant_id);
							$row_2['wishlist'] = $wishlist;
						}

						// Check if in the the customer cart
						if($customer_id != "" && $customer_id != 0)
						{
							$cart = checkCustomerCart($app_id, $customer_id, $product_id, $variant_id);
							$row_2['cart_quantity'] = $cart;
						}

						$variants[] = $row_2;
					}
					$row['variants'] = $variants;

					$records[] = $row;
				}
			}
		}
		
		// Promotional Banners Featured Category Id
		if($display_type == 4)
		{
			//echo $display_value;
			//echo $display_value;
			$ex_display_value = explode(",", $display_value);
			
			$row = [];
			foreach($ex_display_value as $ex)
			{
				$ex_file_name = explode(":", $ex);
				
				$image_name = $ex_file_name[0];
				$category_id = $ex_file_name[1];
			
				//echo $website_url."/uploads/store-".$app_id."/banners/".$image_name;
				
				if($image_name != "" && file_exists("../../uploads/store-".$app_id."/banners/".$image_name))
				{
					$row['banner'] = $website_url."/uploads/store-".$app_id."/banners/".$image_name;
					$row['category_id'] = $category_id;
					
					$records[] = $row;
				}
			}
		}
		
		$result[] = [
			'display_type' => $display_type,
			'display_str' => getDashboardType($ds['display_type']),
			'display_data' => $records,
		];
	}
}

$return = [ 'error_code' => $error_code, 'error_string' => $error_string, 'data' => $result ];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;