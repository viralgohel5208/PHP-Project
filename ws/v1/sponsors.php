<?php

/*
*	Sponsors List
* 	URL: http://localhost/peak/ws/sponsors.php?lang=en
*/

header("Content-type: text/plain");	//Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['lang']))
{
	$error_code = 1; $error_string = "Variables not set";
}
else
{
	$lang 		= escapeInputValue($_REQUEST['lang']);
	
	if($lang == "")
	{
		$error_code = 2; $error_string = "Variables can not be empty";
	}
}

if($error_code == 0)
{
	$query = "SELECT * FROM sponsors WHERE status = 1 ORDER BY display_order ASC";

	$res_query = mysqli_query($link, $query);

	if( !$res_query )
	{
		$error_code = 3; $error_string = $sww;
	}
	else
	{
		$data = [];
		while($row_query = mysqli_fetch_assoc( $res_query ))
		{
			if($lang == "ar")
			{
				$row_query['sponsor_name'] = $row_query['sponsor_name_ar'];
			}
			unset($row_query['sponsor_name_ar']);

			/*if($row_query['file_name'] != "") {
				$row_query['file_name'] = $website_url."/uploads/sponsors/".$row_query['file_name'];
			}
			$data[] = $row_query;*/
			
			if($row_query['file_name'] != "" && file_exists("../uploads/sponsors/".$row_query['file_name']))
			{
				$row_query['file_name'] = $website_url."/uploads/sponsors/".$row_query['file_name'];
			}
			else
			{
				$row_query['file_name'] = "";
			}
			$data[] = $row_query;
		}

		$result = $data;	// Returns user details array
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;

?>