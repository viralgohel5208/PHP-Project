<?php
/*
*	States Listing
* 	URL: http://localhost/ecom/ws/v1/list-states.php?country_id=99
*/

header("Content-type: text/plain");	// Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['country_id']))
{
	$error_code = 1; $error_string = 'Country id is not set';
}
else
{
	$country_id 		= escapeInputValue($_REQUEST['country_id']);
		
	if($country_id == "")
	{
		$error_code = 2; $error_string = 'Application id cannot be empty';
	}
}

if($error_code == 0)
{
	$pro_query = "SELECT * FROM states WHERE country_id = '$country_id' ORDER BY state_name ASC";

	$result = mysqli_query($link, $pro_query);

	if(!$result)
	{
		$error_code = 3; $error_string = $sww;
	}
	else
	{
		if(mysqli_num_rows($result) == 0)
		{
			$error_code = 4; $error_string = 'No states found';
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$data[] = $row;
			}
		}
	}
}

$return = ["error_code" => $error_code, "error_string" => $error_string, "data" => $data];
print_r(json_encode($return));
exit;

?>