<?php
/*
 *
 *	View User Profile
 * 	URL: http://localhost/ecom/ws/v1/profile-view.php?app_id=1&user_id=1
 *
*/

header( "Content-type: text/plain" ); //Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-list.php";
require_once "../../functions-mysql.php";

if(!isset($_REQUEST['app_id']) || !isset($_REQUEST['user_id']))
{
	$error_code = 1; $error_string = "Variable is missing";
}
else
{
	$app_id 		= escapeInputValue( $_REQUEST['app_id'] );
	$user_id 		= escapeInputValue( $_REQUEST['user_id'] );
}

if($error_code == 0)
{
	$sql_user_fetch = "SELECT * FROM customers WHERE app_id = $app_id AND id = '" . $user_id . "'";

	$res_user_fetch = mysqli_query( $link, $sql_user_fetch );

	if ( !$res_user_fetch )
	{
		$error_code = 1; $error_string = $sww;
	}
	else if ( mysqli_num_rows( $res_user_fetch ) == 0 )
	{
		$error_code = 2; $error_string = 'User does not found';
	}
	else
	{
		$row_user_fetch = mysqli_fetch_assoc($res_user_fetch);
		
		$row_user_fetch['gender_name'] = getCustGender($row_user_fetch['gender']);
		
		if($row_user_fetch['file_name'] == "")
		{
			$row_user_fetch['file_name'] = $website_url.'/assets/images/default/user-avatar.png';
		}
		else
		{
			$row_user_fetch['file_name'] = $website_url.'/uploads/store-'.$app_id.'/customer-profile/'.$row_user_fetch['file_name'];
		}

		$data = $row_user_fetch;
	}
}

$return = [ "error_code" => $error_code, "error_string" => $error_string, "data" => $data ];
print_r( json_encode( $return ) );
exit;
?>