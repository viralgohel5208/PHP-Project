<?php
/*
 *
 *	Update User Profile
 * 	URL: http://localhost/ecom/ws/v1/profile-update.php?app_id=1&user_id=1&auth_token=O2VpoUJqTkwBJWYn3QqF&first_name=Shirish&last_name=Makwana&email=shirishm.makwana@gmail.com&gender=1
 *
 *	Gender: 0 = Not added, 1 = Male, 2 = Female, 3 = Other
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
else if(!isset( $_REQUEST[ "first_name" ] ) || !isset( $_REQUEST[ "last_name" ] ) || !isset( $_REQUEST[ "email" ] ) || !isset( $_REQUEST[ "gender" ] ))
{
	$error_code = 1; $error_string = 'Variables not set';
}
else
{
	$app_id 		= escapeInputValue( $_REQUEST['app_id'] );
	$user_id 		= escapeInputValue( $_REQUEST['user_id'] );
	$first_name 	= escapeInputValue( $_REQUEST['first_name'] );
	$last_name 		= escapeInputValue( $_REQUEST['last_name'] );
	$email 			= escapeInputValue( $_REQUEST['email'] );
	$gender			= escapeInputValue( $_REQUEST['gender'] );

	if ( $first_name == "" || $last_name == "" )
	{
		$error_code = 2; $error_string = 'Please insert all details';
	}
	else if ( !preg_match( "/^[A-Z a-z]+$/", $first_name ) )
	{
		$error_code = 3;
		$error_string = 'First name is invalid, contains only alphabets';
	}
	else if ( !preg_match( "/^[A-Z a-z]+$/", $last_name ) )
	{
		$error_code = 4; $error_string = 'Last name is invalid, contains only alphabets';
	}
	else if ($email != "" && !preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email ) ) {
		$error_code = 4;
		$error_string = 'Please enter valid email address';
	}
}

if($error_code == 0)
{
	$query = "SELECT id FROM customers WHERE id = '" . $user_id . "'";

	$result_check = mysqli_query( $link, $query );

	if ( !$result_check )
	{
		$error_code = 5; $error_string = $sww;
	}
	else if ( mysqli_num_rows( $result_check ) == 0 )
	{
		$error_code = 6; $error_string = 'User does not found';
	}
}

if($error_code == 0 && $email != "")
{
	$sql_check_user = "SELECT email FROM customers WHERE email = '$email' AND id != $user_id AND app_id = $app_id";
	$res_check_user = mysqli_query($link, $sql_check_user);

	if(!$res_check_user)
	{
		$error_code = 9;
		$error_string = $sww;
	}
	else if(mysqli_num_rows($res_check_user) > 0)
	{
		$error_code = 10; $error_string = 'Email address already exist';
	}
}

if($error_code == 0)
{
	$query_1 = "UPDATE customers SET first_name = '".$first_name."', last_name = '".$last_name."', email = '".$email."', gender = '".$gender."', `updated_at` = '$current_datetime' WHERE id = '" . $user_id . "'";
	
	$result = mysqli_query( $link, $query_1 );

	if ( !$result )
	{
		$error_code = 7; $error_string = $sww;
	}
	else
	{
		$data = 'Profile updated successfully';
	}
}

$return = [ "error_code" => $error_code, "error_string" => $error_string, "data" => $data ];
print_r( json_encode( $return ) );
exit;
?>