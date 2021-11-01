<?php

/*
*	Settings
* 	URL: http://localhost/ecom/ws/v1/app-info.php?app_id=1
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";
require_once "../../functions-notification.php";

if(!isset($_REQUEST['app_id']))
{
	$error_code = 1; $error_string = "Application id is not set";
}
else
{
	$app_id 			= escapeInputValue($_REQUEST['app_id']);
	
	if($app_id == "")
	{
		$error_code = 2; $error_string = "Application id cannot be empty";
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM app_info WHERE app_id = $app_id";
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
		$data = mysqli_fetch_assoc($result);
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;

?>