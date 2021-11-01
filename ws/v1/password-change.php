<?php
/*
 *
 *	Change Password of User Account
 * 	URL: http://localhost/ecom/ws/v1/password-change.php?app_id=1&user_id=1&auth_token=hdfsfuy&c_password=shirish&n_password=shirish&r_password=shirish
 *
*/

header( "Content-type: text/plain" ); //Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

$checkUserAuthentication = checkUserAuthentication(isset($_REQUEST[ 'app_id' ])?$_REQUEST[ 'app_id' ]:FALSE, isset($_REQUEST[ 'user_id' ])?$_REQUEST[ 'user_id' ]:FALSE, isset($_REQUEST[ 'auth_token' ])?$_REQUEST[ 'auth_token' ]:FALSE);

if($checkUserAuthentication['error_code'] != 0)
{
	$error_code = $checkUserAuthentication['error_code'];
	$error_string = $checkUserAuthentication['error_string'];
}
else if(!isset( $_REQUEST[ 'c_password' ] ) || !isset( $_REQUEST[ 'n_password' ] ) || !isset( $_REQUEST[ 'r_password' ] ))
{
	$error_code = 1;
	$error_string = 'Variables not set';
}
else
{
	$user_id 	= escapeInputValue( $_REQUEST[ 'user_id' ]);
	
	$c_password = $_REQUEST['c_password'];
	$n_password = $_REQUEST['n_password'];
	$r_password = $_REQUEST['r_password'];

	if ( $c_password == "" || $n_password == "" || $r_password == "" )
	{
		$error_code = 2;
		$error_string = 'Please insert all details';
	}
	else if ( strlen( $c_password ) < 6 )
	{
		$error_code = 3;
		$error_string = 'Password must be greater than 5 character';
	}
	else if ( strlen( $n_password ) < 6 )
	{
		$error_code = 4;
		$error_string = 'Password must be greater than 5 character';
	}
	else if ( $n_password != $r_password )
	{
		$error_code = 5;
		$error_string = 'Enter new password correctly two times';
	}
}

if($error_code == 0)
{
	$query = "SELECT id, password FROM customers WHERE id = '" . $user_id . "'";

	$result_check = mysqli_query( $link, $query );

	if ( !$result_check )
	{
		$error_code = 6;
		$error_string = $sww;
	}
	else if ( mysqli_num_rows( $result_check ) == 0 )
	{
		$error_code = 7;
		$error_string = 'User does not found';
	}
	else
	{
		$row = mysqli_fetch_assoc( $result_check );
		
		$c_password = passwordEncyption($c_password, 'e');
			
		if ( $row[ 'password' ] != $c_password )
		{
			$error_code = 8;
			$error_string = 'Incorrect current password';
		}
	}
}

if($error_code == 0)
{
	$n_password = passwordEncyption($n_password, 'e');
		
	$query_1 = "UPDATE customers SET password = '" . $n_password . "', `updated_at` = '$current_datetime' WHERE id = '" . $user_id . "'";
	
	$result = mysqli_query( $link, $query_1 );

	if ( !$result )
	{
		$error_code = 9;
		$error_string = $sww;
	}
	else
	{
		$data = 'Password updated successfully';
	}
}

$return = [ "error_code" => $error_code, "error_string" => $error_string, "data" => $data ];
print_r( json_encode( $return ) );
exit;
?>