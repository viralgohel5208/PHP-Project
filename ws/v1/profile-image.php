<?php	

/*	Update user profile picture
* 	URL: http://localhost/ecom/ws/v1/profile-image.php?app_id=1&user_id=1&auth_token=O2VpoUJqTkwBJWYn3QqF&rm_image=0
*/

header("Content-type: text/plain");	// Convert to plain text

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
else if ( !isset( $_REQUEST[ 'rm_image' ] ) )
{
	$error_code = 1; $error_string = "Variables not set";
}
else
{
	$app_id 		= escapeInputValue( $_REQUEST['app_id'] );
	$user_id 		= escapeInputValue( $_REQUEST['user_id'] );
	$rm_image 		= escapeInputValue( $_REQUEST[ 'rm_image' ] );
	
	$folder_location = "../../uploads/store-".$app_id."/customer-profile/";
}

if ( $error_code == 0 )
{
	$query_user = "SELECT id, file_name FROM customers WHERE id = '$user_id'";
	$check_user = mysqli_query( $link, $query_user );
	
	if ( !$check_user )
	{
		$error_code = 2; $error_string = $sww;
	}
	else if ( mysqli_num_rows( $check_user ) == 0 )
	{
		$error_code = 3; $error_string = 'User does not exist';
	}
	else
	{
		$row_user = mysqli_fetch_assoc( $check_user );
		
		$old_file_name 	= $row_user[ 'file_name' ];
		$file_name 		= $row_user[ 'file_name' ];
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
	 $sql = "UPDATE `customers` SET `file_name` = '$file_name', `updated_at` = '$current_datetime' WHERE app_id = $app_id AND id = '$user_id'";

	if ( !mysqli_query( $link, $sql ) )
	{
		$error_code = 4; $error_string = $sww;
	}
	else
	{
		if ( $file_name != "" && $file_name != $old_file_name )
		{
			if ( $old_file_name != "" && file_exists( $folder_location . $old_file_name ) )
			{
				unlink( $folder_location . $old_file_name );
			}

			move_uploaded_file( $image_tmp_name, $folder_location . $file_name );
			/*if ( $image_type == 'image/jpeg' ) {
				compressImage( $folder_location . $file_name, $folder_location . $file_name, 20 );
			} else {
				compressImage( $folder_location . $file_name, $folder_location . $file_name, 60 );
			}*/
		}

		if ( $rm_image == 1 && $old_file_name != "" && file_exists( $folder_location . $old_file_name ) )
		{
			unlink( $folder_location . $old_file_name );
		}
	}
}

if ( $error_code == 0 )
{
	$query = "SELECT * FROM customers WHERE id = " . $user_id;
	
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

$return = [ 'error_code' => $error_code, 'error_string' => $error_string, 'data' => $data ];
print_r( json_encode( $return ) );
exit;

?>