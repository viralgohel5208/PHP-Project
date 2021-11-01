<?php

function currentTime() {
	return date( "Y-m-d H:i:s" );
}

function formatDateTime( $date ) {
	if ( $date != "" && $date != NULL && $date != "0000-00-00 00:00:00" ) {
		return date( 'd-m-Y g:i a', strtotime( $date ) );
	} else {
		return "-";
	}
}

function formatDate( $date ) {
	if ( $date != "" && $date != NULL && $date != "0000-00-00 00:00:00"  && $date != "0000-00-00" ) {
		return date( 'd-m-Y', strtotime( $date ) );
	} else {
		return "-";
	}
}

function formatDate2( $date ) {
	if ( $date != "" && $date != NULL && $date != "0000-00-00 00:00:00"  && $date != "0000-00-00" ) {
		return date( 'd M', strtotime( $date ) );
	} else {
		return "-";
	}
}

function formatTime( $date ) {
	if ( $date != "" && $date != NULL && $date != "0000-00-00 00:00:00"  && $date != "00:00:00" ) {
		return date( 'g:i a', strtotime( $date ) );
	} else {
		return "-";
	}
}

function getYesOrNo( $value ) {
	if ( $value == 1 ) {
		return "Yes";
	} else {
		return "No";
	}
}

function generateRandomString( $length = 10 ) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen( $characters );
	$randomString = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
	}
	return $randomString;
}

function verifCodeGen( $length = 6 ) {
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen( $characters );
	$randomString = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
	}
	return $randomString;
}

function image_validation( $image, $image_type, $image_size, $image_error, $image_tmp_name )
{
	$img_type_allowed = array( "image/jpeg", "image/jpg", "image/png" );
	$img_max_size_allowed = 2 * 1024 * 1024; // Max allowed image upload size is 2 MB
	
	$extension = pathinfo($image, PATHINFO_EXTENSION);

	$error = "";

	if ( $image_error != 0 ) {
		$error = "There is some problem with image, Please try again.";
	} else {
		$img_property = @getimagesize( $image_tmp_name );
		if ( is_array( $img_property ) ) {
			$type = $img_property[ 'mime' ];

			if ( !in_array( $type, $img_type_allowed ) ) {
				$error = "Image format invalid. Allowed formats are: JPG, JPEG, PNG";
			} else if ( $image_size > $img_max_size_allowed ) {
				$error = "Max allowed image upload size is 2 Mb";
			} else {
				$image = time() . "-" . rand(1111, 9999) . "." . $extension;
			}
		} else {
			$error = "Image format invalid. Allowed formats are: JPG, JPEG, PNG";
		}
	}
	return array( 'error' => $error, 'image' => $image );
}

function customNumberFormat( $price ) {
	return number_format( ( float )$price, 2, '.', '' );
}

function ordinal_suffix( $num ) {
	$num = $num % 100; // protect against large numbers
	if ( $num < 11 || $num > 13 ) {
		switch ( $num % 10 ) {
			case 1:
				return 'st';
			case 2:
				return 'nd';
			case 3:
				return 'rd';
		}
	}
	return 'th';
}

/* CREATE THE PAGINATION */
function printPagination_main ($adjacents, $limit, $targetpage, $page, $counter, $prev, $next, $lastpage, $lpm1){
$pagination = "";
if($lastpage > 1)
{ 
	$pagination .= '<div style="padding: 15px; "> <ul class="pagination">';
	
	if ($page > $counter+1)
	{
		$pagination.= '<li><a href="'.$targetpage.''.$prev.'">prev</a></li>';
	}

	if ($lastpage < 7 + ($adjacents * 2)) 
	{ 
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page)
				$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
			else
				$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
	{
		//close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2)) 
		{
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
				else
					$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
			}
			$pagination.= "<li>...</li>";
			$pagination.= '<li><a href="'.$targetpage.''.$lpm1.'">'.$lpm1.'</a></li>';
			$pagination.= '<li><a href="'.$targetpage.''.$lastpage.'">'.$lastpage.'</a></li>';
		}
		//in middle; hide some front and some back
		elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
			$pagination.= '<li><a href="'.$targetpage.'1">1</a></li>';
			$pagination.= '<li><a href="'.$targetpage.'2">2</a></li>';
			$pagination.= "<li>...</li>";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
				else
					$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
			}
			$pagination.= "<li>...</li>";
			$pagination.= '<li><a href="'.$targetpage.''.$lpm1.'">'.$lpm1.'</a></li>';
			$pagination.= '<li><a href="'.$targetpage.''.$lastpage.'">'.$lastpage.'</a></li>';
		}
		//close to end; only hide early pages
		else
		{
			$pagination.= '<li><a href="'.$targetpage.'1">1</a></li>';
			$pagination.= '<li><a href="'.$targetpage.'2">2</a></li>';
			$pagination.= "<li>...</li>";
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
				else
					$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
			}
		}
	}
	
	//next button
	if ($page < $counter - 1)
	{
		$pagination.= '<li><a href="'.$targetpage.''.$next.'">next</a></li>';
	}
	else
	{
		$pagination.= "";
	}
		
	$pagination.= "</ul></div>\n"; 
}
	return $pagination;
}

function printPagination ($adjacents, $limit, $targetpage, $page, $counter, $prev, $next, $lastpage, $lpm1){
$pagination = "";
if($lastpage > 1)
{ 
	$pagination .= '<div class="pagination-area wow fadeInUp"> <ul>';
	
	if ($page > $counter+1)
	{
		$pagination.= '<li><a href="'.$targetpage.''.$prev.'"><i class="fa fa-angle-left"></i></a></li>';
	}

	if ($lastpage < 7 + ($adjacents * 2)) 
	{ 
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page)
				$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
			else
				$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
	{
		//close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2)) 
		{
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
				else
					$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
			}
			$pagination.= "<li>...</li>";
			$pagination.= '<li><a href="'.$targetpage.''.$lpm1.'">'.$lpm1.'</a></li>';
			$pagination.= '<li><a href="'.$targetpage.''.$lastpage.'">'.$lastpage.'</a></li>';
		}
		//in middle; hide some front and some back
		elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
			$pagination.= '<li><a href="'.$targetpage.'1">1</a></li>';
			$pagination.= '<li><a href="'.$targetpage.'2">2</a></li>';
			$pagination.= "<li>...</li>";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
				else
					$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
			}
			$pagination.= "<li>...</li>";
			$pagination.= '<li><a href="'.$targetpage.''.$lpm1.'">'.$lpm1.'</a></li>';
			$pagination.= '<li><a href="'.$targetpage.''.$lastpage.'">'.$lastpage.'</a></li>';
		}
		//close to end; only hide early pages
		else
		{
			$pagination.= '<li><a href="'.$targetpage.'1">1</a></li>';
			$pagination.= '<li><a href="'.$targetpage.'2">2</a></li>';
			$pagination.= "<li>...</li>";
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
				else
					$pagination.= '<li><a href="'.$targetpage.''.$counter.'">'.$counter.'</a></li>';
			}
		}
	}
	
	//next button
	if ($page < $counter - 1)
	{
		$pagination.= '<li><a href="'.$targetpage.''.$next.'"><i class="fa fa-angle-right"></i></a></li>';
	}
	else
	{
		$pagination.= "";
	}
		
	$pagination.= "</ul></div>\n"; 
}
	return $pagination;
}

function genValidHtmlFormat($string)
{
	$string = str_replace('src="//www.', 'src="http://www.', $string);
	return $string;
}

function stringCut($string, $str_len = 300)
{
	$string = strip_tags($string);
	if (strlen($string) > $str_len) {

		// truncate string
		$stringCut = substr($string, 0, $str_len);

		// make sure it ends in a word so assassinate doesn't become ass...
		//$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="/this/story">Read More</a>'; 
		$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	}
	return $string;
}

function passwordEncyption( $string, $action = 'e' )
{
    // you may change these values to your own
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}

function categoryListing($items, $id)
{
	$output = array();
	foreach($items as $item)
	{
		if($item['parent_id'] == $id)
		{
			$item['sub_menu'] = categoryListing($items, $item['id']);
			$output[] = $item;
		}
		//$output[] = $item;
	}
	return $output;
}

function listCategoryDropdown($categories, $selected)
{
	//echo $selected; exit;
	$dropdown = "";
	foreach($categories as $category)
	{
		if(empty($category['sub_menu']))
		{
			$dropdown .= '<option value="'.$category['id'].'" ';
			if($selected == $category['id']) { $dropdown .= 'selected="selected"'; } 
			$dropdown .= '>'. $category['category_name'] .'</option>';
		}
		else
		{
			$dropdown .= '<optgroup label="'. $category['category_name'] .'">';
			$dropdown .= listCategoryDropdown($category['sub_menu'], $selected);

			/*foreach($category as $c)
			{
				echo '<option value="'.$c['id'].'"';
				//if(isset($_REQUEST['id']) && $_REQUEST['id'] == c['id']) { echo 'selected="selected"'; } 
				echo '>'. $c['category_name'] .'</option>';
			}*/


			$dropdown .= '</optgroup>';
		}
	}
	return $dropdown;
}

function decimalNumberFormat($number)
{
	return number_format((float)$number, 2, '.', '');
}

function getFileImageArray($app_id, $type, $file_name_str)
{
	global $website_url, $current_url;
	
	//echo $website_url;
	//exit;
	
	$ex_current_url = explode("/", $current_url);
	
	if(in_array('ws', $ex_current_url))
	{
		$display_type = "ws";
	}
	else
	{
		$display_type = "web";
	}
	
	//echo $display_type;
	
	$output = [];
		
	if($file_name_str == "")
	{
		if($display_type == "ws")
		{
			if($type == 1) // Category
			{
				$output = [$website_url.'/assets/images/default/default.png'];
			}
			else if($type == 2) // Products
			{
				$output = [$website_url.'/assets/images/default/default.png'];
			}
		}
		else
		{
			if($type == 1) // Category
			{
				$output = [$website_url.'/images/default/category-default.png'];
			}
			else if($type == 2) // Products
			{
				$output = [$website_url.'/images/default/category-default.png'];
			}
		}
	}
	else
	{
		$ex_file_name = explode(",", $file_name_str);
		foreach($ex_file_name as $fn)
		{
			if($display_type == "ws")
			{
				if($type == 1)
				{
					if($fn != "" && file_exists("../../uploads/store-".$app_id."/categories/".$fn))
					{
						$output[] = $website_url."/uploads/store-".$app_id."/categories/".$fn;
					}
				}
				if($type == 2)
				{
					if($fn != "" && file_exists("../../uploads/store-".$app_id."/products/".$fn))
					{
						$output[] = $website_url."/uploads/store-".$app_id."/products/".$fn;
					}
				}
			}
			else
			{
				if($type == 1)
				{
					if($fn != "" && file_exists("uploads/store-".$app_id."/categories/".$fn))
					{
						$output[] = $website_url."/uploads/store-".$app_id."/categories/".$fn;
					}
				}
				if($type == 2)
				{
					//echo "uploads/store-".$app_id."/products/".$fn;
					if($fn != "" && file_exists("uploads/store-".$app_id."/products/".$fn))
					{
						$output[] = $website_url."/uploads/store-".$app_id."/products/".$fn;
					}
				}
			}
		}

		if(empty($output))
		{
			if($display_type == "ws")
			{
				if($type == 1) // Category
				{
					$output = [$website_url.'/assets/images/default/default.png'];
				}
				else
				{
					$output = [$website_url.'/assets/images/default/default.png'];
				}
			}
			else
			{
				if($type == 1) // Category
				{
					$output = [$website_url.'/images/default/category-default.png'];
				}
				else
				{
					$output = [$website_url.'/images/default/category-default.png'];
				}
			}
		}
	}

	return $output;
}

function displayStarRating($total_star_count, $total_star_customers)
{
	$output = "";
	$stars_rate_fill = 0;
	$stars_rate_nill = 5;
	if($total_star_count != 0 && $total_star_customers != 0)
	{
		$stars_rate_fill = $total_star_count / $total_star_customers;
		$stars_rate_nill = 5 - $stars_rate_fill;
	}
	
	$output .= '<div class="rating">';
	for($i= 0; $i < $stars_rate_fill; $i++ ) {	
		$output .= '<i class="fa fa-star"></i>';
	}
	for($i= 0; $i < $stars_rate_nill; $i++ ) {	
		$output .= '<i class="fa fa-star-o"></i>';
	}
		/*<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>*/
	$output .= '</div>';
	
	return $output;
}

function printAddressDetails($city_name, $state_name, $country_name, $pincode)
{
	$return = "";
	if($city_name != "") {
		$return .= $city_name.', ';
	}
	if($state_name != "") {
		$return .= $state_name.', ';
	}
	if($country_name != "") {
		$return .= $country_name.', ';
	}
	if($pincode != "") {
		if($return != "") { 
			$return .= '<br />';
		}
		$return .= 'Pincode: '.$pincode;
	}
	
	return $return;
}

function getGSTPercentageString($value)
{
	$value = strtoupper($value);
	$value = str_replace("GST", "", $value);
	$value = str_replace(" ", "", $value);
	$value = str_replace("%", "", $value);
	
	return $value;
}

function checkValidUserNameString($string)
{
	if(!preg_match("/^[a-zA-Z]+[a-zA-Z0-9_]*$/i", $string))
	{
		//echo 1;
		return false;
	}
	else
	{
		//echo 0;
		return true;
	}
}

function checkValidNameString($string)
{
	if(!preg_match("/^[a-zA-Z]+[a-zA-Z0-9_\s]*$/i", $string))
	{
		//echo 1;
		return false;
	}
	else
	{
		//echo 0;
		return true;
	}
}

/*
* function to encode string
* accepts a string
* returns encoded string
*/
function safe_encode($string) {
    //return strtr(base64_encode($string), '+/=', '-_-');
    return $string;
}
 
/*
* function to decode the encoded string
* accepts encoded string
* returns the original string
*/
function safe_decode($string) {
    //return base64_decode(strtr($string, '-_-', '+/='));
    return $string;
}