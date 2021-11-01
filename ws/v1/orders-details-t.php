<?php
/*
*	Login User to Application
* 	URL: http://localhost/ecom/ws/v1/orders-details.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn&order_id=1
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-list.php";
require_once "../../functions-mysql.php";

$addresses = [];
$store_details = [];

$checkUserAuthentication = checkUserAuthentication(isset($_REQUEST[ 'app_id' ])?$_REQUEST[ 'app_id' ]:FALSE, isset($_REQUEST[ 'customer_id' ])?$_REQUEST[ 'customer_id' ]:FALSE, isset($_REQUEST[ 'auth_token' ])?$_REQUEST[ 'auth_token' ]:FALSE);

if($checkUserAuthentication['error_code'] != 0)
{
	$error_code = $checkUserAuthentication['error_code'];
	$error_string = $checkUserAuthentication['error_string'];
}
else if(!isset($_REQUEST['order_id']))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$order_id 		= escapeInputValue($_REQUEST['order_id']);
	
	if($order_id == "")
	{
		$error_code = 2; $error_string = "Order id can't be empty";
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM orders WHERE id = '$order_id' AND customer_id = $customer_id";
	
	$result = mysqli_query($link, $query);
	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$order_main = [];
	}
	else
	{
		$order_main = mysqli_fetch_assoc($result);
		//print_r($order_main);
		
		$address_id 	= $order_main['address_id'];
		$store_id 		= $order_main['store_id'];
		$order_main['status'] = getOrderStatus($order_main['status']);
		
		$query_2 = "SELECT * FROM order_details WHERE order_id = '$order_id'";
		
		$result_2 = mysqli_query($link, $query_2);
		
		if(!$result_2)
		{
			$error_code = 4; $error_string = $sww;
		}
		else
		{
			$order_details = [];
			while($row_2 = mysqli_fetch_assoc($result_2))
			{
				$row_2['product'] 			= [];
				$row_2['offer_discount'] 	= [];
					
				$product_id 	= $row_2['product_id'];
				$variant_id 	= $row_2['variant_id'];
				
				$query_3 = "SELECT products.id AS product_id, products.brand_name, products.product_name, products.file_name, V.id AS variant_id, V.measure_type, V.net_measure FROM products INNER JOIN products_variant AS V ON products.id = V.product_id WHERE V.id = '$variant_id'";
				
				$result_3 = mysqli_query($link, $query_3);
				
				if(!$result_3)
				{
					$error_code = 5; $error_string = $sww;
				}
				else
				{
					$row_3 = mysqli_fetch_assoc($result_3);
					
					$row_2['product'] = $row_3;
				}
				
				if($error_code == 0)
				{
					if($row_2['offer_reference'] == '')
					{
						$offer_discount['offer_type'] = '1';
						$offer_discount['offer_details'] = [];
					}
					else
					{
						$ex_offer_reference = explode(':', $row_2['offer_reference']);
						$offer_on 		= $ex_offer_reference[0];
						$offer_type 	= $ex_offer_reference[1];
						$offer_value 	= $ex_offer_reference[2];
						
						if($offer_type == 1)
						{
							$offer_discount['offer_type'] 		= '1';
							$offer_discount['offer_details'] 	= ['offer_percent' => $offer_value];
						}
						else if($offer_type == 2)
						{
							$ex_offer_value = explode(',', $offer_value);
							$product_id_free 		= $ex_offer_value[0];
							$variant_id_free 		= $ex_offer_value[1];

							$query4 = "SELECT P.id AS product_id, P.brand_name, P.product_name, P.file_name, V.id AS variant_id, V.measure_type, V.net_measure FROM products AS P INNER JOIN products_variant AS V ON P.id = V.product_id WHERE V.id = '$variant_id_free' AND V.product_id = '$product_id_free'";

							$result4 = mysqli_query($link, $query4);

							if(!$result4)
							{
								$error_code = 6; $error_string = $sww;
							}
							else
							{
								$row4 = mysqli_fetch_assoc($result4);
								$row4['file_name'] = getFileImageArray($app_id, 2, $row4['file_name']);
								$offer_discount['offer_type'] 		= '2';
								$offer_discount['offer_details'] 	= $row4;
								
							}
						}

					}
					$row_2['offer_discount'] = $offer_discount;
				}

				$order_details[] = $row_2;
			}
		}
		
		$order_main['order_details'] = $order_details;
	}
}

if($error_code == 0 && $address_id != 0 && $address_id != NULL)
{
	$query = "SELECT * FROM customers_address WHERE id = '$address_id'";
	
	$result = mysqli_query($link, $query);
	
	if(!$result)
	{
		$error_code = 7; $error_string = $sww;
	}
	
	$addresses = mysqli_fetch_assoc($result);
}

if($error_code == 0)
{
	$query = "SELECT * FROM stores WHERE id = '$store_id'";
	
	$result = mysqli_query($link, $query);
	if(!$result)
	{
		$error_code = 8; $error_string = $sww;
	}
	else
	{
		$store_details = mysqli_fetch_assoc($result);
	}
}

if($error_code == 0 && !empty($order_main))
{
	$data = ['order_details' => $order_main, 'address' => $addresses, 'store_details' => $store_details ];
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>