<?php
/*
 *
 *	Update User Profile
 * 	URL: http://localhost/ecom/ws/v1/profile-update-full.php?app_id=1&customer_id=1&auth_token=O2VpoUJqTkwBJWYn3QqF&first_name=Shirish&last_name=Makwana&email=shirishm.makwana@gmail.com&gender=1&rm_image=0
 *
 *	Gender: 0 = Not added, 1 = Male, 2 = Female, 3 = Other
*/

header( "Content-type: text/plain" ); //Convert to plain text

require_once "../../db.php";
require_once "../../define.php";
require_once "../../functions.php";
require_once "../../functions-mysql.php";

$checkUserAuthentication = checkUserAuthentication(isset($_REQUEST[ 'app_id' ])?$_REQUEST[ 'app_id' ]:FALSE, isset($_REQUEST[ 'customer_id' ])?$_REQUEST[ 'customer_id' ]:FALSE, isset($_REQUEST[ 'auth_token' ])?$_REQUEST[ 'auth_token' ]:FALSE);

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
	$customer_id 	= escapeInputValue( $_REQUEST['customer_id'] );
	$first_name 	= escapeInputValue( $_REQUEST['first_name'] );
	$last_name 		= escapeInputValue( $_REQUEST['last_name'] );
	$email 			= strtolower( escapeInputValue( $_REQUEST['email'] ));
	$gender			= escapeInputValue( $_REQUEST['gender'] );
	
	if(isset($_REQUEST[ 'rm_image' ]))
	{
		$rm_image 	= escapeInputValue( $_REQUEST[ 'rm_image' ] );
	}
	else
	{
		$rm_image 	= 0;
	}

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
		$error_code = 5;
		$error_string = 'Please enter valid email address';
	}
}

if($error_code == 0)
{
	$query = "SELECT id, file_name FROM customers WHERE id = '" . $customer_id . "'";

	$result_check = mysqli_query( $link, $query );

	if ( !$result_check )
	{
		$error_code = 6; $error_string = $sww;
	}
	else if ( mysqli_num_rows( $result_check ) == 0 )
	{
		$error_code = 7; $error_string = 'User does not found';
	}
	else
	{
		$row_user = mysqli_fetch_assoc( $result_check );
		
		$old_file_name 	= $row_user[ 'file_name' ];
		$file_name 		= $row_user[ 'file_name' ];
	}
}

if($error_code == 0 && $email != "")
{
	$sql_check_user = "SELECT email FROM customers WHERE email = '$email' AND id != $customer_id AND app_id = $app_id";
	$res_check_user = mysqli_query($link, $sql_check_user);

	if(!$res_check_user)
	{
		$error_code = 8;
		$error_string = $sww;
	}
	else if(mysqli_num_rows($res_check_user) > 0)
	{
		$error_code = 9; $error_string = 'Email address already exist';
	}
}

if ( $error_code == 0 )
{
	if ( isset( $_FILES[ 'file_name' ][ 'error' ] ) && $_FILES[ 'file_name' ][ 'error' ] != 4 )
	{
		$image 			= $_FILES[ 'file_name' ][ 'name' ];
		$image_type 	= $_FILES[ 'file_name' ][ 'type' ];
		$image_size 	= $_FILES[ 'file_name' ][ 'size' ];
		$image_error 	= $_FILES[ 'file_name' ][ 'error' ];
		$image_tmp_name = $_FILES[ 'file_name' ][ 'tmp_name' ];
		
		$image_val = image_validation( $image, $image_type, $image_size, $image_error, $image_tmp_name );
		if ( $image_val[ 'error' ] == "" )
		{
			$file_name = $image_val[ 'image' ];
		}
		else
		{
			$error_code = 10; $error_string = $image_val[ 'error' ];
		}
	}
	else if ( $rm_image == 1 )
	{
		$file_name = "";
	}
	else
	{
		$file_name = $old_file_name;
	}
}

if($error_code == 0)
{
	$query_1 = "UPDATE customers SET first_name = '".$first_name."', last_name = '".$last_name."', email = '".$email."', gender = '".$gender."', `file_name` = '$file_name', `updated_at` = '$current_datetime' WHERE id = '" . $customer_id . "'";
	
	$result = mysqli_query( $link, $query_1 );

	if ( !$result )
	{
		$error_code = 11; $error_string = $sww;
	}
	else
	{
		$folder_location = "../../uploads/store-".$app_id."/customer-profile/";
		
		if ( $file_name != "" && $file_name != $old_file_name )
		{
			if ( $old_file_name != "" && file_exists( $folder_location . $old_file_name ) )
			{
				unlink( $folder_location . $old_file_name );
			}

			move_uploaded_file( $image_tmp_name, $folder_location . $file_name );
		}

		if ( $rm_image == 1 && $old_file_name != "" && file_exists( $folder_location . $old_file_name ) )
		{
			unlink( $folder_location . $old_file_name );
		}
		
		$data = 'Profile updated successfully';
	}
}

if ( $error_code == 0 )
{
	$query = "SELECT * FROM customers WHERE id = " . $customer_id ." AND app_id = ".$app_id;
	
	$result = mysqli_query( $link, $query );
	
	$data = mysqli_fetch_assoc( $result );
	
	if($data['file_name'] == "")
	{
		$data['file_name'] = $website_url.'/assets/images/default/user-avatar.png';
	}
	else
	{
		$data['file_name'] = $website_url.'/uploads/store-'.$app_id.'/customer-profile/'.$data['file_name'];
	}
}

$return = [ "error_code" => $error_code, "error_string" => $error_string, "data" => $data ];
print_r( json_encode( $return ) );
exit;
?>