<?php

/*
*	Settings
* 	URL: http://localhost/ecom/ws/v1/settings.php?app_id=1
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-list.php";
require_once "../../functions-mysql.php";
require_once "../../functions-notification.php";

$data['application_details'] 	= [];
$data['app_settings'] 			= [];

if(!isset($_REQUEST['app_id']))
{
	$error_code = 1; $error_string = "Application id is not set";
}
else
{
	$app_id 			= escapeInputValue($_REQUEST['app_id']);
	
	if($app_id == "")
	{
		$error_code = 1; $error_string = "Application id cannot be empty";
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM app_details WHERE app_id = $app_id";
	$result = mysqli_query($link, $query);
	if( !$result )
	{
		$error_code = 3; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 4; $error_string = "Application details does not found";
	}
	else
	{
		$row = mysqli_fetch_assoc( $result );
		$data['application_details'] = $row;
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM app_settings WHERE app_id = $app_id";
	$result = mysqli_query($link, $query);
	if( !$result )
	{
		$error_code = 5; $error_string = $sww;
	}
	else if(mysqli_num_rows($result) == 0)
	{
		$error_code = 6; $error_string = "Application settings does not found";
	}
	else
	{
		$row = mysqli_fetch_assoc( $result );
		
		$available_payment_mode = $row['available_payment_mode'];
		$available_payment_sub = $row['available_payment_sub'];
		$ex_available_payment_mode = explode(",", $available_payment_mode);
		$ex_available_payment_sub = explode(",", $available_payment_sub);
		
		sort($ex_available_payment_mode);
		sort($ex_available_payment_sub);
		//print_r($ex_available_payment_mode);
		//exit;
		$pay_modes = [];
		
		foreach($ex_available_payment_mode as $item)
		{
			if($item == 0)
			{
				$pay_modes[] = ["key" => $item, "value" => getPaymentMode($item), 'sub' => []];
			}
			else
			{
				$list_payment = [];
				//$list_payment_arr = listPaymentSub();
				//print_r($list_payment_arr);
				foreach($ex_available_payment_sub as $item_2)
				{
					$list_payment[] = ["key" => "$item_2", "value" => getPaymentSub($item_2)];
				}
				$pay_modes[] = ["key" => $item, "value" => getPaymentMode($item), 'sub' => $list_payment];
			}
		}
		$row['available_payment_mode_arr'] = $pay_modes;
		$data['app_settings'] = $row;
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;

?>