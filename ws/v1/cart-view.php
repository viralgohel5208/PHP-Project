<?php
/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/cart-view.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

$checkUserAuthentication = checkUserAuthentication(isset($_REQUEST[ 'app_id' ])?$_REQUEST[ 'app_id' ]:FALSE, isset($_REQUEST[ 'customer_id' ])?$_REQUEST[ 'customer_id' ]:FALSE, isset($_REQUEST[ 'auth_token' ])?$_REQUEST[ 'auth_token' ]:FALSE);

if($checkUserAuthentication['error_code'] != 0)
{
	$error_code = $checkUserAuthentication['error_code'];
	$error_string = $checkUserAuthentication['error_string'];
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
}

if($error_code == 0)
{
	$pro_query = "SELECT C.variant_id, C.product_id, P.*, V.* FROM customers_cart AS C INNER JOIN products AS P ON P.id = C.product_id INNER JOIN products_variant AS V ON V.id = C.variant_id WHERE C.app_id = '$app_id' AND customer_id = '$customer_id'";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 1; $error_string = $sww;
	}
	else
	{
		while($row_2 = mysqli_fetch_assoc($result))
		{
			$product_id = $row_2['product_id'];
			$variant_id = $row_2['variant_id'];

			$cart = checkCustomerCart($app_id, $customer_id, $product_id, $variant_id);
			$row_2['cart_quantity'] = $cart;

			$file_name_array = $row_2['file_name'];
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

			$row_2['file_name'] = $images;

			$data[] = $row_2;
		}
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>