<?php

$website_url 			= "http://ez-ecommerce.co.in/demo";


$application_name 		= "eCommerce Application";
$current_url 			= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$full_url 				= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$sww 					= "Something went wrong, Please try again later.";
$error 					= "";
$success 				= "";

$theme_style 			= "primary";
$panel_style 			= "panel-$theme_style";
$color_style_array 		= ["default", "primary", "success", "info", "warning", "danger", "alert", "system", "dark"];

$error_code 			= 0;
$error_string 			= "";
$data 					= [];

// For pagination
$adjacents 				= 3;
$limit = $record_limit 	= 20; //how many items to show per page

$current_datetime		= date("Y-m-d H:i:s");
$days_5_date 			= date("Y-m-d H:i:s", strtotime("-5 days"));

// Email related configuration

$admin_email			= 'shirishm.makwana@gmail.com';
$admin_user				= 'Shirish Makwana';

$img_max_size_allowed 	= 5*1024*1024;   // Max allowed image upload size is 5 Mb
$img_type_allowed 		= array("image/jpeg", "image/jpg", "image/png");

if(isset($_SESSION['app_id'])) { $app_id = $_SESSION['app_id']; } else { $app_id = 0; }
if(isset($_SESSION['role_id'])) { $role_id = $_SESSION['role_id']; } else { $role_id = 0; }
if(isset($_SESSION['cu_customer_id'])) { $customer_id = $_SESSION['cu_customer_id']; } else { $customer_id = 0; }

if($app_id > 0)
{
	$result_11 = mysqli_query($link, "SELECT app_name FROM app_details where app_id = '$app_id' LIMIT 1");
	if(mysqli_num_rows($result_11) > 0)
	{
		$row_11 = mysqli_fetch_assoc($result_11);
		$application_name = $row_11['app_name'];
	}
}