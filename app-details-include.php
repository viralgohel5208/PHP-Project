<?php

if(!isset($_SESSION['logo_top']))
{
	$getAppDetails 				= getAppDetails($app_id);
	$_SESSION['logo_top'] 		= $getAppDetails['logo_top'];
	$_SESSION['logo_center'] 	= $getAppDetails['logo_center'];
	$_SESSION['logo_bottom'] 	= $getAppDetails['logo_bottom'];
	$_SESSION['logo_favicon'] 	= $getAppDetails['logo_favicon'];
	$_SESSION['facebook_url'] 	= $getAppDetails['facebook_url'];
	$_SESSION['twitter_url'] 	= $getAppDetails['twitter_url'];
	$_SESSION['google_plus'] 	= $getAppDetails['google_plus'];
	$_SESSION['instagram_url'] 	= $getAppDetails['instagram_url'];
}

if(!isset($_SESSION['customer_account_verification']))
{
	$getAppSettings 							= getAppSettings($app_id);
	$_SESSION['customer_account_verification'] 	= $getAppSettings['customer_account_verification'];
	$_SESSION['order_tracking'] 				= $getAppSettings['order_tracking'];
	$_SESSION['inhouse_delivery_tracking'] 		= $getAppSettings['inhouse_delivery_tracking'];
	$_SESSION['available_payment_mode'] 		= $getAppSettings['available_payment_mode'];
	$_SESSION['sms_username'] 					= $getAppSettings['sms_username'];
	$_SESSION['sms_password'] 					= $getAppSettings['sms_password'];
}

//if(!isset($_SESSION['website_menu']))
{
	//echo $app_id;
	$website_menu 							= getWebsiteMenu($app_id);
	
	//echo '<pre>'; print_r($website_menu); exit;
	$_SESSION['website_menu'] 	= $website_menu;
}


?>