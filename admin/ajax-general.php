<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

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
		
		echo '<option value="0">Select State ...</option>';
		
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
	
	// Fetch Customer Details on ORDER PLACE
	if($type == 9 && isset($_POST['id']))
	{
		$customer_id = escapeInputValue($_POST['id']);
		
		$query = "SELECT id, first_name, last_name, email, mobile FROM customers WHERE id = $customer_id LIMIT 1";
		
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
			
			/*$query_add = "SELECT id FROM customers_address WHERE app_id = $app_id AND customer_id = $customer_id LIMIT 1";
			$res_add = mysqli_query($link, $query_add);
			if(mysqli_num_rows($res_add) > 0)
			{
				$row_add = mysqli_fetch_assoc($res_add);
				$address_id = $row_add['id'];
			}
			else
			{
				$address_id = 0;
			}*/
			
			$row = mysqli_fetch_assoc($result);
			//echo $row['first_name']. ' '.$row['last_name'];
			echo '<br />Email : '.$row['email'];
			echo '<br />Mobile : '.$row['mobile'];
			//echo '<input type="text" name="address_id" value="'.$address_id.'" />';
		}
	}
	
	// Fetch Product Price and Discount etc
	if($type == 10 && isset($_POST['id']))
	{
		$variant_id = escapeInputValue($_POST['id']);
		
		$query = "SELECT * FROM products_variant WHERE app_id = $app_id AND id = $variant_id LIMIT 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);
		
		$offer_type 	= $row['offer_type'];
		$offer_value 	= $row['offer_value'];
		$expires_at 	= $row['expires_at'];
		
		$offer_str = "";

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
					
					$offer_str = "Free - ".$free_product['product_name'];
				}
				else
				{
					$offer_type 	= 0;
				}
			}
		}
		else if($offer_type == 1 && $offer_value != "")
		{
			if($expires_at == "" || $expires_at == "0000-00-00 00:00:00" || $expires_at > $current_datetime)
			{
				$offer_str = $offer_value."% Discount";
			}
		}
		
		//echo '$("#price_finale").html('.$row['price_finale'].')';
		if($offer_str != "")
		{
			echo "$(x).parents('tr').find('.variant_offer').html('<p style=\"margin: 5px 0 0 0; color: #1f57a1;\">".$offer_str."</p>');";
		}
		echo "$(x).parents('tr').find('.finale_price').html('₹".$row['price_finale']."');";
		echo "$(x).parents('tr').find('.discounted_price').val('₹".$row['offer_price']."');";
		echo "$(x).parents('tr').find('.qty').val(1);";
		echo "$(x).parents('tr').find('.price').html('₹".$row['offer_price']."');";
		echo "update_total();";
		//echo '$(this).parents("tr").find('input[name="arrondi_devis_ht"]').val(new_prix_ht);';
		//print_r($row);
	}
	
	// Fetch Store Details on ORDER PLACE
	if($type == 11 && isset($_POST['id']))
	{
		$store_id = escapeInputValue($_POST['id']);
		
		$query = "SELECT id, email, mobile_1, address FROM stores WHERE id = $store_id LIMIT 1";
		
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
			//echo $row['first_name']. ' '.$row['last_name'];
			echo '<br />Email : '.$row['email'];
			echo '<br />Mobile : '.$row['mobile_1'];
			echo '<br />Address : '.$row['address'];
		}
	}
		
}