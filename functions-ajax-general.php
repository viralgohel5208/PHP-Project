<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
require_once "app-specific-include/define-app.php";
require_once "functions.php";
require_once "functions-mysql.php";
require_once "functions-list.php";

if(!isset($_POST['type']))
{
	echo 'alert("Something went wrong.")';
}
else
{
	$type = escapeInputValue($_POST['type']);
	
	if($type == 1 && isset($_POST['id']) && isset($_POST['display_order']))
	{
		$id 			= escapeInputValue($_POST['id']);
		$display_order 	= escapeInputValue($_POST['display_order']);

		if($id == "" || $display_order == "")
		{
			echo 'alert("Something went wrong1.")';
		}
		else
		{
			$query = "UPDATE agenda SET display_order = '$display_order' WHERE id = $id";
			$results = mysqli_query($link, $query);

			if($results)
			{
				//echo $display_order;
				//echo 'document.getElementById("display_order_'.$id.'").value = "'.$display_order.'";';
				echo 'alert("Display order has been updated.")';
			}
			else
			{
				echo 'alert("Something went wrong, Please try again.")';
			}
		}
	}

	// Fetch Sub Categories
	if($type == 2 && isset($_POST['main_cat']))
	{
		$main_cat = escapeInputValue($_POST['main_cat']);
		
		echo '<option value="0">Select Category ...</option>';
		
		$query = "SELECT id, category_name FROM categories WHERE app_id = $app_id AND parent_id = $main_cat ORDER BY category_name";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<option value="'.$row['id'].'">'.$row['category_name'].'</option>';
			}
		}
	}
	
	// Fetch Products
	if($type == 3 && isset($_POST['sub_cat']))
	{
		$sub_cat = escapeInputValue($_POST['sub_cat']);
		
		echo '<option value="0">Select Product ...</option>';
		
		$query = "SELECT id, product_name FROM products WHERE app_id = $app_id AND category_id = $sub_cat ORDER BY product_name ";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<option value="'.$row['id'].'">'.$row['product_name'].'</option>';
			}
		}
	}
	
	// Fetch Variants
	if($type == 4 && isset($_POST['product_id']))
	{
		$product_id = escapeInputValue($_POST['product_id']);
		
		echo '<option value="0">Select Product ...</option>';
		
		$query = "SELECT id, measure_type, net_measure, price_finale FROM products_variant WHERE app_id = $app_id AND product_id = $product_id ORDER BY measure_type, net_measure, price_finale";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<option value="'.$row['id'].'">'.$row['net_measure'].' '.$row['measure_type'].' (Rs. '.$row['price_finale'].')</option>';
			}
		}
	}
	
	// Fetch Package Price
	if($type == 5 && isset($_POST['package_id']))
	{
		$package_id = escapeInputValue($_POST['package_id']);
		
		$query = "SELECT id, package_price_raw, package_price_gst, package_price FROM packages WHERE id = $package_id LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			$row = mysqli_fetch_assoc($result);
			
			$package_price_raw 	= decimalNumberFormat($row['package_price_raw']);
			$package_price_gst 	= decimalNumberFormat($row['package_price_gst']);
			$package_price 		= decimalNumberFormat($row['package_price']);
			
			$str = '$("#package_price_raw").val("'.$package_price_raw.'");';
			$str .= '$("#package_price_gst").val("'.$package_price_gst.'");';
			$str .= '$("#package_price").val("'.$package_price.'");';
			
			echo $str;
		}
	}
	
	// Fetch States
	if($type == 6 && isset($_POST['country_id']))
	{
		$country_id = escapeInputValue($_POST['country_id']);
		
		echo '<option value="0">Select State ...</option>';
		
		$query = "SELECT id, state_name FROM states WHERE country_id = $country_id ORDER BY state_name ";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<option value="'.$row['id'].'">'.$row['state_name'].'</option>';
			}
		}
	}
	
	// Fetch Cities
	if($type == 7 && isset($_POST['state_id']))
	{
		$state_id = escapeInputValue($_POST['state_id']);
		
		echo '<option value="0">Select City ...</option>';
		
		$query = "SELECT id, city_name FROM cities_list WHERE state_id = $state_id ORDER BY city_name ";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<option value="'.$row['id'].'">'.$row['city_name'].'</option>';
			}
		}
	}
	
	// Maintenance Mode AJAX - settings.php
	if($type == 8 && isset($_POST["disable_type"]) && isset($_POST["value"]))
	{
		$disable_type 	= escapeInputValue($_POST['disable_type']);
		$value 			= escapeInputValue($_POST['value']);
		
		$query = "UPDATE app_maintenance SET ";
		if($disable_type == 1)
		{
			$query .= "`website` = '$value', `web_updated_at` = '$current_datetime'";
		}
		else if($disable_type == 2)
		{
			$query .= "`application` = '$value', `app_updated_at` = '$current_datetime'";
		}
		else if($disable_type == 3)
		{
			$query .= "`admin_panel` = '$value', `admin_updated_at` = '$current_datetime'";
		}
		
		$query .= "WHERE app_id = '$app_id'";
		
		$results = mysqli_query($link, $query);
		echo $current_datetime;
	}
	
	// Fetch Stores
	if($type == 9 && isset($_POST['city_id']))
	{
		$city_id = escapeInputValue($_POST['city_id']);
		
		$_SESSION['ck_city_id'] 	= $city_id;
		$_SESSION['ck_store_id'] 	= 0;
		$_SESSION['ck_area_id'] 	= 0;
		$_SESSION['ck_delivery_charge'] = 0;
			
		echo '<option value="0">Select Store ...</option>';
		
		$query = "SELECT id, store_name FROM `stores` WHERE app_id = $app_id AND city_id = $city_id AND status = 1 ORDER BY store_name";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<option value="'.$row['id'].'">'.$row['store_name'].'</option>';
			}
		}
	}
	
	// Fetch Areas
	if($type == 10 && isset($_POST['store_id']))
	{
		$store_id 	= escapeInputValue($_POST['store_id']);
		$city_id 	= $_SESSION['ck_city_id'];
		
		$_SESSION['ck_store_id'] 	= $store_id;
		$_SESSION['ck_area_id'] 	= 0;
		$_SESSION['ck_delivery_charge'] = 0;
		
		echo '<option value="0">Select Area ...</option>';

		$query = "SELECT id, store_area FROM `stores_localities` WHERE app_id = $app_id AND city_id = ".$city_id." AND store_id = ".$store_id." ORDER BY store_area";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<option value="'.$row['id'].'">'.$row['store_area'].'</option>';
			}
		}
	}
	
	// Set Areas to check session
	if($type == 11 && isset($_POST['area_id']))
	{
		$area_id 	= escapeInputValue($_POST['area_id']);
		$city_id 	= $_SESSION['ck_city_id'];
		$store_id 	= $_SESSION['ck_store_id'];
		
		$_SESSION['ck_area_id'] = $area_id;
		
		$query = "SELECT id, store_area, delivery_charge FROM `stores_localities` WHERE app_id = $app_id AND city_id = ".$city_id." AND store_id = ".$store_id." AND id = $area_id LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		if(!$result)
		{
			echo 1;
		}
		else if(mysqli_num_rows($result) == 0)
		{
			echo 1;
		}
		else
		{
			$row = mysqli_fetch_assoc($result);
			$delivery_charge = customNumberFormat($row['delivery_charge']);
			
			$_SESSION['ck_delivery_charge'] = $delivery_charge;
			
			$cart_total = $_SESSION['cart_total'] + $delivery_charge;
			$delivery_charge = customNumberFormat($delivery_charge);
			$cart_total = customNumberFormat($cart_total);
			
			//$pro_q_total_price = customNumberFormat($pro_q_total_price);
			echo 'document.getElementById("delivery_charge").innerHTML = "₹ '.$delivery_charge.'";';
			echo 'document.getElementById("cart_grand_total").innerHTML = "₹ '.$cart_total.'";';
		}
	}
}