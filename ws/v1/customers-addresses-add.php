<?php
/*
*	Products Listing
* 	URL: http://localhost/ecom/ws/v1/customers-addresses-add.php?app_id=1&customer_id=1&auth_token=e8XNj9qQYs7TJgpI4Jyn&address_name=Office Address&first_name=Shirish&last_name=Makwana&email=shirishm.makwana@gmail.com&mobile=9924400799&address=Royal Complex&city_id=1&state_id=1&country_id=99&landmark=Bhutkhana&pincode=360002&latitude=&longitude=
*/

header("Content-type: text/plain");		//	Convert to plain text

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
else if(!isset($_REQUEST['address_name']) || !isset($_REQUEST['first_name']) || !isset($_REQUEST['last_name']) || !isset($_REQUEST['email']) || !isset($_REQUEST['mobile']) || !isset($_REQUEST['address']) || !isset($_REQUEST['city_id']) || !isset($_REQUEST['state_id']) || !isset($_REQUEST['country_id']) || !isset($_REQUEST['landmark']) || !isset($_REQUEST['pincode']) || !isset($_REQUEST['latitude']) || !isset($_REQUEST['longitude']))
{
	$error_code = 1; $error_string = "Variable is missing";
}
else
{
	$app_id 		= escapeInputValue($_REQUEST['app_id']);
	$customer_id 	= escapeInputValue($_REQUEST['customer_id']);
	$address_name 	= escapeInputValue($_REQUEST['address_name']);
	$first_name 	= escapeInputValue($_REQUEST['first_name']);
	$last_name 		= escapeInputValue($_REQUEST['last_name']);
	$email 			= strtolower(escapeInputValue($_REQUEST['email']));
	$mobile 		= escapeInputValue($_REQUEST['mobile']);
	$address 		= escapeInputValue($_REQUEST['address']);
	$city_id 		= escapeInputValue($_REQUEST['city_id']);
	$state_id 		= escapeInputValue($_REQUEST['state_id']);
	$country_id 	= escapeInputValue($_REQUEST['country_id']);
	$landmark 		= escapeInputValue($_REQUEST['landmark']);
	$pincode 		= escapeInputValue($_REQUEST['pincode']);
	$latitude 		= escapeInputValue($_REQUEST['latitude']);
	$longitude 		= escapeInputValue($_REQUEST['longitude']);
	
	if($address_name =="" || $first_name == "" || $last_name == "" || $mobile == "" || $address == "")
	{
		$error_code = 1; $error_string = "Please enter all the mandatory details";
	}
	else if($email != "" && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email))
	{
		$error_code = 1; $error_string = "Invalid email address";
	}
	else if ($mobile != "" && !preg_match("/^[0-9]*$/", $mobile))
	{
		$error_code = 1; $error_string = "Mobile no is invalid";
	}
}

if($error_code == 0)
{
	$pro_query = "SELECT id FROM customers_address WHERE app_id = '$app_id' AND customer_id = $customer_id  AND address_name = '$address_name' LIMIT 1";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 2; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) > 0)
	{
		$error_code = 3; $error_string = "Please use different address name";
	}
	else
	{
		//$row = mysqli_fetch_assoc($result);
	}
}

if($error_code == 0)
{
	if($error == "")
	{
		$q_11 = "SELECT A.id as city_id, A.city_name, A.state_id, B.state_name, A.country_id, C.nicename as country_name FROM `cities_list` AS A INNER JOIN states AS B ON B.id = A.state_id INNER JOIN countries as C ON C.id = A.country_id WHERE A.id = $city_id LIMIT 1";
		
		$r_11 = mysqli_query( $link, $q_11 );

		if ( !$r_11 )
		{
			$error_code = 3; $error_string = $sww;
		}
		else
		{
			if ( mysqli_num_rows( $r_11 ) == 0 )
			{
				$error_code = 3; $error_string = "Invalid city details";
			}
			else
			{
				$row_c = mysqli_fetch_assoc($r_11);
				$city_id = $row_c['city_id'];
				$city_name = $row_c['city_name'];
				$state_id = $row_c['state_id'];
				$state_name = $row_c['state_name'];
				$country_id = $row_c['country_id'];
				$country_name = $row_c['country_name'];
			}
		}
	}
}

if($error_code == 0)
{
	$query_1 = "INSERT INTO `customers_address`(`app_id`, `customer_id`, `address_name`, `first_name`, `last_name`, `email`, `mobile`, `address`, `city_id`, `city_name`, `state_id`, `state_name`, `country_id`, `country_name`, `landmark`, `pincode`, `latitude`, `longitude`, `created_at`, `updated_date`, `status`) VALUES ($app_id, $customer_id, '$address_name', '$first_name', '$last_name', '$email', '$mobile', '$address', '$city_id', '$city_name', '$state_id', '$state_name', '$country_id', '$country_name', '$landmark', '$pincode', '$latitude', '$longitude', '$current_datetime', '$current_datetime', 1)";

	$result_1 = mysqli_query($link, $query_1);

	if(!$result_1)
	{
		$error_code = 4; $error_string = $sww;
	}
	else
	{
		$data = TRUE;
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>