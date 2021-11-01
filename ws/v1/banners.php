<?php

/*
*	Banners
* 	URL: http://localhost/ecom/ws/v1/banners.php?app_id=1
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']))
{
	$error_code = 1; $error_string = "Application id is not set";
}
else
{
	$app_id = escapeInputValue($_REQUEST['app_id']);
	
	if($app_id == "")
	{
		$error_code = 2; $error_string = "Application id cannot be empty";
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM banners WHERE app_id = $app_id AND status = 1 ORDER BY display_order ASC";
	
	$res_query = mysqli_query($link, $query);

	if(!$res_query)
	{
		$error_code = 3; $error_string = $sww;
	}
}

if($error_code == 0)
{
	$result = [];

	while($row = mysqli_fetch_assoc($res_query))
	{
		if($row['file_name'] != "" && file_exists("../../uploads/store-".$app_id."/banners/".$row['file_name']))
		{
			$row['file_name'] = $website_url."/uploads/store-".$app_id."/banners/".$row['file_name'];
			$result[] = $row;
		}
	}
}

$return = [ 'error_code' => $error_code, 'error_string' => $error_string, 'data' => $result ];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;