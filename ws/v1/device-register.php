<?php

/*
*	Register User Device
*	URL: http://localhost/ecom/ws/v1/device-register.php?app_id=1&customer_id=1&device_id=AjksUhfdYEwsd1SD2KsMS&notif_id=213465fgsfkhsgdhG&device_type=1&action=logout

Device Type: 
	1. iOs
	2. Android

Action:
	1. login
	2. logout
*
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

$device_id 		= escapeInputValue($_REQUEST['device_id']);
$notif_id 		= escapeInputValue($_REQUEST['notif_id']);
$device_type  	= escapeInputValue($_REQUEST['device_type']);
$action  		= escapeInputValue($_REQUEST['action']);
$app_id			= escapeInputValue($_REQUEST['app_id']);
$customer_id	= escapeInputValue($_REQUEST['customer_id']);

$registerCustomerDevice = registerCustomerDevice($device_id, $notif_id, $device_type, $action, $app_id, $customer_id);

$error_code 	= $registerCustomerDevice['error_code'];
$error_string 	= $registerCustomerDevice['error_string'];
$data 			= $registerCustomerDevice['data'];

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;

?>