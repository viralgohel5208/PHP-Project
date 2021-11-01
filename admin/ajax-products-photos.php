<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$target_dir = "uploads/products-photos/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$added_date = date("Y-m-d H:i:s");

/*if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$_FILES['file']['name']))
{
	$status = 1;
}*/

if(isset($_FILES['file']))
{
	$image          = $_FILES['file']['name'];
	$image_type     = $_FILES['file']['type'];
	$image_size     = $_FILES['file']['size'];
	$image_error    = $_FILES['file']['error'];
	$image_tmp_name = $_FILES['file']['tmp_name'];

	if($image_error == 4)
	{
		$status = 0;
	}
	else if($image_error != 0)
	{
		$status = 0;
	}
	else
	{
		$img_property = @getimagesize($image_tmp_name);
		if(!is_array($img_property))
		{
			$status = 0;
		}
		else
		{
			$type = $img_property['mime'];
			if(!in_array($type, $img_type_allowed))
			{
				$status = 0;
			}
			else
			{
				$ext = pathinfo($image, PATHINFO_EXTENSION);
                //$image = time()."-".rand(1000,9999).'.'.$ext;
			
				$sql = "INSERT INTO `products_photos`(`app_id`, `title`, `file_name`, `added_date`) VALUES ('$app_id', '$image', '$image', '$added_date')";

				$result = mysqli_query($link, $sql);

				if(!$result)
				{
					$status = 0;
				}
				else
				{
					@move_uploaded_file($image_tmp_name, $target_dir.$image);
					$status = 1;
				}
			}
		}
	}
}
echo $status;