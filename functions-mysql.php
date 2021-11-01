<?php

function escapeInputValue($value)
{
	global $link;
	
	$value = mysqli_real_escape_string( $link, $value);
	$value = ltrim($value);
	$value = rtrim($value);
	return $value;
}

function registerCustomerDevice($device_id, $notif_id, $device_type, $action, $app_id, $customer_id)
{
	global $link, $sww, $current_datetime, $error_code, $error_string, $data;
	$status	= 1;
	$data = FALSE;
	
	if($action == "login")
	{
		$query_1 = "SELECT * FROM devices_customer WHERE app_id = $app_id AND device_id = '$device_id' AND device_type  = '$device_type'";

		$check_device = mysqli_query($link, $query_1);

		if(!$check_device)
		{
			$error_code = 1;
			$error_string = $sww;
		}
		else
		{
			if(mysqli_num_rows($check_device) > 0)
			{
				$fetch = mysqli_fetch_assoc($check_device);

				$reg_id	= $fetch['id'];

				if($fetch['notif_id'] != $notif_id)
				{
					$query_2 = "UPDATE devices_customer SET notif_id = '$notif_id', `updated_at` = '$current_datetime' WHERE id = $reg_id";
					$up_device = mysqli_query($link, $query_2);

					if(!$up_device)
					{
						$error_code = 2;
						$error_string = $sww;
					}
				}
			}
			else
			{
				$sql = "INSERT INTO `devices_customer`(`app_id`, `customer_id`, `device_id`, `notif_id`, `device_type`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$customer_id', '$device_id', '$notif_id', '$device_type', '$current_datetime', '$current_datetime', '$status')";

				if(!mysqli_query($link, $sql))
				{
					$error_code = 3;
					$error_string = $sww;
				}
			}
		}
	}
	else if($action == "logout")
	{
		$query_sel = "SELECT id FROM devices_customer WHERE app_id = $app_id AND customer_id = $customer_id AND device_id = '$device_id' AND notif_id = '$notif_id' AND device_type = '$device_type'";

		$check_device = mysqli_query($link, $query_sel);

		if(!$check_device)
		{
			$error_code = 4;
			$error_string = $sww;
		}
		else
		{
			if(mysqli_num_rows($check_device) == 0)
			{
				$error_string = 5;
				$error_string = $sww;
			}
			else
			{
				$fetch = mysqli_fetch_assoc($check_device);
				$reg_id = $fetch['id'];

				$up_device = mysqli_query($link, "DELETE FROM `devices_customer` WHERE id = $reg_id");
				if(!$up_device)
				{
					$error_code = 6;
					$error_string = $sww;
				}
			}
		}
	}
	
	if($error_code == 0)
	{
		$data = TRUE;
	}

	$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
	return $return;
}

function checkUserAuthentication($app_id, $user_id, $auth_token)
{
	global $link, $sww, $error_code, $error_string;
	
	if($app_id === FALSE || $user_id === FALSE || $auth_token === FALSE)
	{
		$error_code = 101; $error_string = 'User is not authorized';
	}
	else
	{
		$app_id 	= escapeInputValue( $app_id );
		$user_id 	= escapeInputValue( $user_id );
		$auth_token	= escapeInputValue( $auth_token );
		
		$query = "SELECT id FROM customers WHERE app_id = $app_id AND id = $user_id AND auth_token = '$auth_token'";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			$error_code = 102; $error_string = $sww;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			$error_code = 103; $error_string = 'User is not authorized';
		}
	}
	
	return ['error_code' => $error_code, 'error_string' => $error_string];
}

function checkCustomerCart($app_id, $customer_id, $product_id, $variant_id)
{
	global $link, $sww;
	
	$quantity = 0;
	
	$query = "SELECT quantity FROM customers_cart WHERE app_id = $app_id AND customer_id = '$customer_id' AND product_id = '$product_id' AND variant_id = '$variant_id'";
	
	$result = mysqli_query($link, $query);
	
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			
			$quantity = $row['quantity'];
		}
	}

	return (int)$quantity;
}

function checkCustomerWishlist($app_id, $customer_id, $product_id, $variant_id)
{
	global $link, $sww;
	
	$wishlist = FALSE;
	
	$query = "SELECT id FROM customers_wishlist WHERE app_id = $app_id AND customer_id = $customer_id AND product_id = $product_id AND variant_id = $variant_id";
	
	$result = mysqli_query($link, $query);
	
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			$wishlist = TRUE;
		}
	}
	
	return $wishlist;
}

function getAppCategories($app_id)
{
	global $link;
	$items = [];
	$data = [];

	$query_cat = "SELECT id, parent_id, category_name, file_name, status FROM categories WHERE app_id = $app_id ORDER BY category_name";
	$res_cat = mysqli_query($link, $query_cat);
	while($row_cat = mysqli_fetch_assoc($res_cat))
	{
		$items[] = $row_cat;
	}

	$id = '';

	foreach($items as $item)
	{
		if($item['parent_id'] == 0)
		{
			$id = $item['id'];
			$item['sub_menu'] = categoryListing($items, $id);
			$data[] = $item;
		}
	}
	
	return $data;
}

function getAppMainCategories($app_id)
{
	global $link;
	$records = [];

	$query_cat = "SELECT id, parent_id, category_name, file_name, status FROM categories WHERE app_id = $app_id AND (parent_id IS NULL OR parent_id = 0) AND status = 1 ORDER BY category_name";
	$res_cat = mysqli_query($link, $query_cat);
	
	if($res_cat)
	{
		while($row_cat = mysqli_fetch_assoc($res_cat))
		{
			$records[] = $row_cat;
		}
	}

	return $records;
}

function getAppSubCategories($app_id, $category_id)
{
	global $link;
	$records = [];

	$query_cat = "SELECT id, parent_id, category_name, file_name, status FROM categories WHERE app_id = $app_id AND parent_id = $category_id AND status = 1 ORDER BY category_name";
	$res_cat = mysqli_query($link, $query_cat);
	
	if($res_cat)
	{
		while($row_cat = mysqli_fetch_assoc($res_cat))
		{
			$records[] = $row_cat;
		}
	}

	return $records;
}

function getAppCategoriesDetails($app_id, $category_id)
{
	global $link;
	$records = [];

	$query_cat = "SELECT * FROM categories WHERE app_id = $app_id AND id = $category_id LIMIT 1";
	$res_cat = mysqli_query($link, $query_cat);
	
	if($res_cat)
	{
		if(mysqli_num_rows($res_cat) > 0)
		{
			$row_cat = mysqli_fetch_assoc($res_cat);
			$records = $row_cat;
		}
	}

	return $records;
}

// Fetch Variants Details
function getProductVariants($app_id, $product_id, $customer_id = 0)
{
	global $link, $current_datetime;
	
	$variants = [];
	$query = "SELECT * FROM products_variant WHERE app_id = $app_id AND product_id = $product_id ORDER BY price_finale";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result))
	{
		$variant_id = $row['id'];
		
		$offer_type 	= $row['offer_type'];
		$offer_value 	= $row['offer_value'];
		$expires_at 	= $row['expires_at'];
		
		if($offer_type == 2 && $offer_value != "")
		{
			if($expires_at == "" || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime)
			{
				$exp_offer_value = explode(",", $offer_value);
				if(count($exp_offer_value) == 2)
				{
					$f_product_id = $exp_offer_value[0];
					$f_variant_id = $exp_offer_value[1];
					
					$free_product = getFreeProductDetail($app_id, $f_product_id, $f_variant_id);
					$row['free_product'] = $free_product;
				}
				else
				{
					$offer_type 	= 0;
				}
			}
		}

		//Check in the Wish list
		if($customer_id != 0)
		{
			$wishlist = checkCustomerWishlist($app_id, $customer_id, $product_id, $variant_id);
			$row['wishlist'] = $wishlist;
		}

		// Check if in the the customer cart
		if($customer_id != 0)
		{
			$cart = checkCustomerCart($app_id, $customer_id, $product_id, $variant_id);
			$row['cart_quantity'] = $cart;
		}

		$variants[] = $row;
	}
	
	return $variants;
}

function getFreeProductDetail($app_id, $product_id, $variant_id)
{
	global $link;
	
	$free_product = [];
	
	$query = "SELECT P.id, P.product_name, P.sku_number, P.brand_name, C.category_name, P.file_name FROM products as P INNER JOIN categories AS C ON C.id = P.category_id WHERE P.id = $product_id AND P.app_id = $app_id AND P.status = 1 LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result)
	{
		$free_product = mysqli_fetch_assoc($result);
		
		$free_product['file_name'] = getFileImageArray($app_id, 2, $free_product['file_name']);
		
	}
	
	return $free_product;
}

function getProductReviews($app_id, $product_id, $limit = 10)
{
	global $link;
	$records = [];
	
	$pro_query = "SELECT R.*, C.first_name, C.last_name FROM products_reviews AS R INNER JOIN customers AS C ON C.id = R.customer_id WHERE R.app_id = '$app_id' AND R.product_id = '$product_id' ORDER BY id DESC LIMIT $limit";

	$result = mysqli_query($link, $pro_query);

	if($result)
	{
		while($row_5 = mysqli_fetch_assoc($result))
		{
			$records[] = $row_5;
		}
	}
	
	return $records;
}

function checkMaintenance($app_id)
{
	global $link, $current_datetime;
	
	$maintenance = [];
	
	$query ="SELECT * FROM app_maintenance WHERE app_id = $app_id";
	$result = mysqli_query($link, $query);
	
	if(mysqli_num_rows($result) == 0)
	{
		$query_ins = "INSERT INTO `app_maintenance`(`app_id`, `website`, `web_updated_at`, `application`, `app_updated_at`, `admin_panel`, `admin_updated_at`) VALUES ('$app_id', '1', '$current_datetime', '1', '$current_datetime', '1', '$current_datetime')";
		
		$res_ins = mysqli_query($link, $query_ins);
		
		$query ="SELECT * FROM app_maintenance WHERE app_id = $app_id";
		$result = mysqli_query($link, $query);
	}
	
	$row = mysqli_fetch_assoc($result);
	
	
	$maintenance['Website'] = [$row['website'], $row['web_updated_at']];
	$maintenance['Application'] = [$row['application'], $row['app_updated_at']];
	//$maintenance[] = $row['admin_panel'];
	
	return $maintenance;
}

function getSubscriptionsHistory($app_id)
{
	global $link;
	$records = [];
	
	//$pro_query = "SELECT * FROM `subscription_history` WHERE app_id = $app_id";
	$pro_query = "SELECT SH.id, P.package_name, CONCAT(A.first_name, ' ', A.last_name) as client_name, A.email, A.mobile, CONCAT(SE.first_name, ' ', SE.last_name) as sales_exec, SH.starting_date, SH.expiry_date, SH.status, A.app_id, SH.package_price_raw, SH.package_price_gst, SH.package_price, SH.created_at FROM `subscription_history` AS SH INNER JOIN admin AS A ON A.app_id = SH.app_id AND A.role_id = 2 INNER JOIN packages AS P ON P.id = SH.package_id LEFT JOIN sales_executives AS SE ON SE.id = SH.se_id WHERE SH.app_id = $app_id";
	
	$result = mysqli_query($link, $pro_query);

	if($result)
	{
		while($row_5 = mysqli_fetch_assoc($result))
		{
			$records[] = $row_5;
		}
	}
	
	return $records;
}

//////////////////////// --- Viral Function -- ////////////////

function getTestimonials( $app_id )
{
	global $link;

	$records = [];

	$query = "SELECT * FROM testimonials WHERE app_id = $app_id";

	$res_query = mysqli_query( $link, $query );

	if ( $res_query ) {
		if ( mysqli_num_rows( $res_query ) > 0 ) {
			while ( $row = mysqli_fetch_assoc( $res_query ) ) {
				$records[] = $row;
			}
		}
	}
	return $records;
}

function getBanners( $app_id )
{
	global $link;
	
	$records = [];

	$query = "SELECT * FROM banners WHERE app_id = $app_id";

	$res_query = mysqli_query( $link, $query );

	if ( $res_query ) {
		if ( mysqli_num_rows( $res_query ) > 0 ) {
			while ( $row = mysqli_fetch_assoc( $res_query ) ) {
				$records[] = $row;
			}
		}
	}
	return $records;
}

function getAppDetails( $app_id )
{
	global $link;
	
	$records = [];

	$query = "SELECT id, app_id, logo_top, logo_center, logo_bottom, logo_favicon, facebook_url, twitter_url, google_plus, instagram_url FROM app_details WHERE app_id = $app_id";
	
	$result = mysqli_query( $link, $query );

	if ( $result ) {
		$row = mysqli_fetch_assoc( $result );
		$records = $row;
	}
	return $records;
}

function getCategoriesFooter( $app_id )
{
	global $link;
	
	$records = [];

	$query = "SELECT * FROM categories WHERE app_id = $app_id AND status = 1 ORDER BY RAND() LIMIT 6";

	$res_query = mysqli_query( $link, $query );

	if ( $res_query ) {
		if ( mysqli_num_rows( $res_query ) > 0 ) {
			while ( $row = mysqli_fetch_assoc( $res_query ) ) {
				$records[] = $row;
			}
		}
	}
	return $records;
}

//////////////////////// --- Shirish Functions New -- ////////////////

function getAppSettings($app_id)
{
	global $link;
	
	$records = [];

	$query = "SELECT * FROM app_settings WHERE app_id = $app_id";
	
	$result = mysqli_query( $link, $query );

	if ( $result ) {
		$row = mysqli_fetch_assoc( $result );
		$records = $row;
	}
	return $records;
}

function getCustomerCartCount($app_id, $customer_id)
{
	global $link; 
	$cart_count = 0;
	
	$query = "SELECT count(id) as cart_count FROM customers_cart WHERE app_id = $app_id AND customer_id = $customer_id";
	
	$res_query = mysqli_query($link, $query);
	
	if($res_query)
	{
		$row = mysqli_fetch_assoc($res_query);
		$cart_count = $row['cart_count'];
	}
	
	return $cart_count;
}

function addToCustomerCart($app_id, $customer_id, $product_id, $variant_id, $quantity, $current_datetime)
{
	global $link;
	
	$data = FALSE;
	
	$pro_query = "SELECT id FROM customers_cart WHERE app_id = '$app_id' AND customer_id = '$customer_id' AND variant_id = $variant_id AND product_id = $product_id";

	$result = mysqli_query($link, $pro_query);

	if($result)
	{
		if(mysqli_num_rows($result) == 0)
		{
			$action = "ADD";
		}
		else
		{
			$row = mysqli_fetch_assoc($result);
			$cart_id = $row['id'];
			$action = "UPDATE";
		}
	}
	
	if($action == "ADD")
	{
		$query = "INSERT INTO `customers_cart`(`app_id`, `customer_id`, `product_id`, `variant_id`, `quantity`, `created_at`) VALUES ($app_id, $customer_id, $product_id, $variant_id, '$quantity', '$current_datetime')";

		$result = mysqli_query($link, $query);

		if(!$result)
		{
			$data = FALSE;
		}
		else
		{
			$data = TRUE;
		}
	}
	
	if($action == "UPDATE")
	{
		$query = "UPDATE `customers_cart` SET `quantity` = $quantity WHERE id = $cart_id";

		$result = mysqli_query($link, $query);

		if(!$result)
		{
			$data = FALSE;
		}
		else
		{
			$data = TRUE;
		}
	}
	
	return $data;
}

function removeFromCustomerCart($app_id, $customer_id, $product_id, $variant_id)
{
	global $link;
	
	$query = "DELETE FROM `customers_cart` WHERE `app_id` = $app_id AND `customer_id` = $customer_id AND `product_id` = $product_id AND `variant_id` = $variant_id";

	//$query_1 = "DELETE FROM `customers_cart` WHERE id = $cart_id";

	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$data = FALSE;
	}
	else
	{
		$data = TRUE;
	}
	
	return $data;
}

function addToCustomerWishlist($app_id, $customer_id, $product_id, $variant_id, $current_datetime)
{
	global $link;
	
	$query = "INSERT INTO `customers_wishlist`(`app_id`, `customer_id`, `product_id`, `variant_id`, `offer_id`, `created_at`) VALUES ($app_id, $customer_id, $product_id, $variant_id, NULL, '$current_datetime')";

	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$data = FALSE;
	}
	else
	{
		$data = TRUE;
	}
	
	return $data;
}

function removeFromCustomerWishlist($app_id, $customer_id, $product_id, $variant_id)
{
	global $link;
	
	$query = "DELETE FROM `customers_wishlist` WHERE `app_id` = $app_id AND `customer_id` = $customer_id AND `product_id` = $product_id AND `variant_id` = $variant_id";

	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$data = FALSE;
	}
	else
	{
		$data = TRUE;
	}
	
	return $data;
}

function getRelatedProducts($app_id, $customer_id = 0, $subcategory_id = 0, $limit = 10)
{
	global $link, $sww;
	
	$records = [];
	
	if($subcategory_id > 0)
	{
		$pro_query = "SELECT DISTINCT(p.id), p.category_id, p.sku_number, p.brand_name, p.product_name, p.file_name, v3.measure_type, v3.net_measure, v3.price_raw, v3.gst_percentage, v3.price_gst, v3.price_finale, p.total_star_count, p.total_star_customers, p.created_at FROM products p JOIN (SELECT v2.product_id, v2.measure_type, v2.net_measure, v2.price_raw, v2.gst_percentage, v2.price_gst, v2.price_finale FROM products_variant v2 JOIN (SELECT product_id, MIN(price_finale) as price_finale FROM products_variant GROUP BY product_id ) v1 USING (product_id, price_finale) ) v3 ON p.id = v3.product_id WHERE p.category_id = '$subcategory_id' AND p.app_id = $app_id";
		
		$pro_query .= " ORDER BY price_finale ASC";
		
		$pro_query .= " LIMIT $limit";

		$result = mysqli_query($link, $pro_query);

		if($result)
		{
			if(mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$product_id = $row['id'];
					$row['file_name'] = getFileImageArray($app_id, 2, $row['file_name']);
					// Fetch Variants Details
					$variants = getProductVariants($app_id, $product_id, $customer_id);
					$row['variants'] = $variants;
					$records[] = $row;
				}
			}
		}
	}
	
	$count_records_1 = count($records);
	
	if($count_records_1 < $limit)
	{
		$new_limit = $limit - $count_records_1;
		
		$pro_query = "SELECT DISTINCT(p.id), p.category_id, p.sku_number, p.brand_name, p.product_name, p.file_name, v3.measure_type, v3.net_measure, v3.price_raw, v3.gst_percentage, v3.price_gst, v3.price_finale, p.total_star_count, p.total_star_customers, p.created_at FROM products p JOIN (SELECT v2.product_id, v2.measure_type, v2.net_measure, v2.price_raw, v2.gst_percentage, v2.price_gst, v2.price_finale FROM products_variant v2 JOIN (SELECT product_id, MIN(price_finale) as price_finale FROM products_variant GROUP BY product_id ) v1 USING (product_id, price_finale) ) v3 ON p.id = v3.product_id WHERE p.app_id = $app_id";
		
		$pro_query .= " ORDER BY price_finale ASC, RAND()";
		
		$pro_query .= " LIMIT $new_limit";

		$result = mysqli_query($link, $pro_query);

		if($result)
		{
			if(mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$product_id = $row['id'];
					$row['file_name'] = getFileImageArray($app_id, 2, $row['file_name']);
					// Fetch Variants Details
					$variants = getProductVariants($app_id, $product_id, $customer_id);
					$row['variants'] = $variants;
					$records[] = $row;
				}
			}
		}
	}
	
	return $records;
}

function getCustomerCartGrandTotal($app_id, $customer_id)
{
	global $link, $sww, $current_datetime;
		
	$cart_total = 0; 
	
	$pro_query = "SELECT V.price_finale, V.offer_type, V.offer_value, V.expires_at, V.offer_price, V.stock_amount, C.quantity FROM customers_cart AS C INNER JOIN products_variant AS V ON V.id = C.variant_id WHERE C.app_id = '$app_id' AND C.customer_id = '$customer_id'";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		echo $sww; exit;
	}
	else
	{
		while($row_2 = mysqli_fetch_assoc($result))
		{
			$price_finale 	= $row_2['price_finale'];
			$offer_type 	= $row_2['offer_type'];
			$offer_value 	= $row_2['offer_value'];
			$expires_at 	= $row_2['expires_at'];
			$offer_price 	= $row_2['offer_price'];
			$quantity 		= $row_2['quantity'];
			$stock_amount 	= $row_2['stock_amount'];
			
			if($offer_type == 1 && ($expires_at == NULL || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime))
			{
				$sale_price = $offer_price;
				$old_price = $price_finale;
			}
			else
			{
				$sale_price = $old_price = $price_finale;
			}
			$pro_q_total_price = $sale_price * $quantity;

			if($stock_amount > 0 && $stock_amount > $quantity)
			{
				$cart_total = $cart_total + $pro_q_total_price;
			}
		}
	}
	
	return $cart_total;
}

function getWebsiteMenu($app_id)
{
	global $link, $sww;
	
	$categories = [];
	
	$categorie_menu = "";
	
	$query_3 = "SELECT id, categories_menu FROM `app_display_options` WHERE app_id = '" . $app_id . "' LIMIT 1" ;

	$result_3 = mysqli_query( $link, $query_3);

	if(!$result_3)
	{
		$error = $sww;
	}
	else
	{
		if ( mysqli_num_rows( $result_3 ) == 0 )
		{
			$query_1 = "INSERT INTO `app_display_options`(`app_id`, `categories_menu`, `updated_at`) VALUES ('$app_id', '', '$current_datetime')";

			$result_1 = mysqli_query($link, $query_1);

			if( !$result_1 )
			{
				$error = $sww;
			}
		}
		else
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );

			$categorie_menu = $row_3['categories_menu'];
		}
	}
	
	//echo $categorie_menu; 
	$categorie_menu = "";
	if($categorie_menu == "")
	{
		$query = "SELECT id, category_name FROM categories WHERE app_id = $app_id AND parent_id IS NULL AND status = 1 ORDER BY RAND() LIMIT 7";
	}
	else
	{
		$query = "SELECT id, category_name FROM categories WHERE app_id = $app_id AND parent_id IS NULL AND id IN ($categorie_menu) AND status = 1 ORDER BY RAND() LIMIT 7";
	}
	//echo $query;
	$result = mysqli_query($link, $query);
	
	if(!$result)
	{
		$error = $sww;
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$categories[] = $row;
		}
	}
	//print_r($categories); 
	return $categories;
}