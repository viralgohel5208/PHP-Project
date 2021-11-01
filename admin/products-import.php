<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Import Products";

// Download Sample CSV
if(isset($_GET['sample-csv']))
{
	//$list = ['Sr No., Contact Name, Contact Number, Status', '1, ABC XYZ, 9999999999, 1'];
	$list = ['SKU NUMBER, PRODUCT NAME, CATEGORY NAME, SUB CATEGORY, BRAND NAME, PACK SIZE, MEASURE UNIT, IN STOCK (UNIT), SALE RATE, MRP, GST%, FILE NAME, DESCRIPTION'];
	$filename = 'products-import-csv-sample.csv';
	$path = ''; // '/uplods/'
	$file = fopen($path.$filename, "w");
	foreach ($list as $line) {
		fputcsv($file,explode(',',$line));
	}
	fclose($file);
	$download_file =  $path.$filename;
	
	// Check file is exists on given path.
	if(file_exists($download_file))
	{
		$extension = explode('.', $filename);
		$extension = $extension[count($extension)-1]; 
		// For Gecko browsers
		header('Content-Transfer-Encoding: binary');  
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
		// Supports for download resume
		header('Accept-Ranges: bytes');  
		// Calculate File size
		header('Content-Length: ' . filesize($download_file));  
		header('Content-Encoding: none');
		// Change the mime type if the file is not PDF
		header('Content-Type: application/'.$extension);  
		// Make the browser display the Save As dialog
		header('Content-Disposition: attachment; filename=' . $filename);  
		readfile($download_file); 
		unlink($filename);
		exit;
	}
}

if(isset($_POST['import_csv']))
{
	if(!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] == 4)
	{
		$error = "Please select file to import";
	}
	else
	{
		$file_name = $_FILES['csv_file']['name'];
		
		$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		
		if($extension != "csv")
		{
			$error = "Only csv file are allowed. You can easily convert your excel file to csv format";
		}
		else
		{
			$handle = fopen($_FILES['csv_file']['tmp_name'], "r");

			$i = 0;
			$full_error = "";
			/*echo '<pre>'; 
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				print_r($data);
			}		
			exit;
			*/
			$inserted_products 	= 0;
			$updated_products 	= 0;

			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				/*if($error != "")
				{
					break;
				}
				else*/
				{
				// Get Item values
				if($i == 0) {} 
				else
				{
					{
						$sku_number 		= escapeInputValue($data[0]);
						$product_name 		= escapeInputValue($data[1]);
						$category_name 		= escapeInputValue($data[2]);
						$subcategory_name	= escapeInputValue($data[3]);
						$brand_name			= escapeInputValue($data[4]);
						$pack_size 			= escapeInputValue($data[5]);
						$uom 				= escapeInputValue($data[6]);
						$stock_amount 		= escapeInputValue($data[7]);
						$sale_rate 			= escapeInputValue($data[8]);
						$mrp 				= escapeInputValue($data[9]);
						$gst_percentage 	= escapeInputValue($data[10]);
						
						// Product photo 	= 11
						$product_description = escapeInputValue($data[12]);

						if(isset($data[11]) && $data[11] != "")
						{
							$file_name_file		= escapeInputValue($data[11]);
							//$file_name_save = escapeInputValue($data[11]);
							//$file_name 	= preg_replace('/\s+/', ' ', $file_name);
							//$file_name 	= str_replace(' ','',$file_name);
							
							$ext = pathinfo($file_name_file, PATHINFO_EXTENSION);
                			$file_name = time()."-".rand(1000,9999).'.'.$ext;
						}
						else
						{
							$file_name_file = "";
							$file_name 	= "";
						}

						if($sku_number == "" || $product_name == "" || $category_name == "" || $subcategory_name == "" || $mrp == "" )
						{
							$error = "Please enter all mandatory fields";
						}
						else if(!is_numeric($mrp))
						{
							$error = "Please enter valid mrp";
						}
						
						if(!is_numeric($sale_rate))
						{
							$sale_rate = 0;
						}
					}

					// Check Main Category
					if($error == "")
					{
						$query_1 = "SELECT id FROM categories WHERE app_id = '$app_id' AND category_name = '$category_name' LIMIT 1";

						$result_1 = mysqli_query($link, $query_1);

						if(!$result_1)
						{
							$error = $sww;
						}
						else if(mysqli_num_rows($result_1) == 0)
						{
							//$error = "Please enter category first";
							$query_11 = "INSERT INTO `categories`(`app_id`, `category_name`, `file_name`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$category_name', '', '$current_datetime', '$current_datetime', 1)";

							$result_11 = mysqli_query( $link, $query_11);

							if(!$result_11)
							{
								$error = "E1 - ".$sww;
							}
							else
							{
								$category_id = mysqli_insert_id($link);
								//$success = "Category has been added";
							}
						}
						else
						{
							$row_1 = mysqli_fetch_assoc($result_1);

							$category_id = $row_1['id'];
							//echo "11".'<br />';
						}
					}

					// Check Sub Category
					if($error == "")
					{
						//echo "2".'<br />';
						$query_2 = "SELECT id FROM categories WHERE app_id = '$app_id' AND parent_id = '$category_id' AND category_name = '$subcategory_name' LIMIT 1";

						$result_2 = mysqli_query($link, $query_2);

						if(!$result_2)
						{
							$error = "E2 - ".$sww;
						}
						else if(mysqli_num_rows($result_2) == 0)
						{
							//$error = "Please enter sub category first";
							$query_21 = "INSERT INTO `categories` (`app_id`, `parent_id`, `category_name`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$category_id', '$subcategory_name', '$current_datetime','$current_datetime', 1)";

							$result_21 = mysqli_query( $link, $query_21);

							if(!$result_21)
							{
								$error = "E3 - ".$sww;
							}
							else
							{
								$subcategory_id = mysqli_insert_id($link);
								//$success = "Sub category has been added";
							}
						}
						else
						{
							$row_2 = mysqli_fetch_assoc($result_2);

							$subcategory_id = $row_2['id'];
						}
					}
					
					//Check product BRAND
					if($error == "")
					{
						if($brand_name != "")
						{
							$quer_brand = "SELECT id, brand_name FROM brands WHERE app_id = $app_id AND brand_name = '$brand_name' LIMIT 1";
							$res_brand = mysqli_query($link, $quer_brand);
							if(!$res_brand)
							{
								$error = "E4 - "."Error while adding brand name";
							}
							else
							{
								if(mysqli_num_rows($res_brand) > 0)
								{
									$row_brand = mysqli_fetch_assoc($res_brand);
									$brand_id = $row_brand['id'];
									$brand_name = $row_brand['brand_name'];
								}
								else
								{
									$quer_brand_2 = "INSERT INTO `brands`(`app_id`, `brand_name`, `file_name`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$brand_name', '', '$current_datetime', '$current_datetime', '1')";
									$res_brand_2 = mysqli_query($link, $quer_brand_2);
									$brand_id = mysqli_insert_id($link);
								}
							}
						}

						if($error == "" && $brand_name == "")
						{
							$quer_brand = "SELECT id, brand_name FROM brands WHERE brand_name = '-' LIMIT 1";
							$res_brand = mysqli_query($link, $quer_brand);

							if(!$res_brand)
							{
								$error = "E5 - "."Error while adding brand name";
							}
							else
							{
								if(mysqli_num_rows($res_brand) > 0)
								{
									$row_brand = mysqli_fetch_assoc($res_brand);
									$brand_id = $row_brand['id'];
									$brand_name = $row_brand['brand_name'];
								}
								else
								{
									$brand_name = '-';
									$quer_brand_2 = "INSERT INTO `brands`(`app_id`, `brand_name`, `file_name`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$brand_name', '', '$current_datetime', '$current_datetime', '1')";
									$res_brand_2 = mysqli_query($link, $quer_brand_2);
									$brand_id = mysqli_insert_id($link);
								}
							}
						}
					}

					// Check Product Already exist or not using SKU Number
					if($error == "")
					{
						//echo "3".'<br />';
						$query_3 = "SELECT id FROM products WHERE app_id = $app_id AND category_id = $subcategory_id AND sku_number = '$sku_number' LIMIT 1";

						$result_3 = mysqli_query($link, $query_3);

						if(!$result_3)
						{
							$error = "E6 - ".$sww;
						}
						else if(mysqli_num_rows($result_3) == 0)
						{
							//echo 'new';
							$new_product = TRUE;
						}
						else
						{
							//echo 'old';
							$row_3 = mysqli_fetch_assoc($result_3);

							$product_id = $row_3['id'];

							$new_product = FALSE;
						}
					}

					// Add Products
					if($error == "")
					{
						//echo "4".'<br />';
						if($new_product == TRUE)
						{
							$query_4 = "INSERT INTO `products`(`app_id`, `sku_number`, `category_id`, `brand_id`, `brand_name`, `product_name`, `file_name`, `product_description`, `created_at`, `updated_at`, `status`) VALUES ($app_id, '$sku_number', '$subcategory_id', '$brand_id', '$brand_name', '$product_name', '$file_name', '$product_description', '$current_datetime', '$current_datetime', 1)";

							$result_4 = mysqli_query( $link, $query_4);

							if(!$result_4)
							{
								$error = "E7 - ".$sww;
							}
							else
							{
								$product_id = mysqli_insert_id($link);
								//$success = "Product has been added";
								$inserted_products++;
							}
						}
						else
						{
							
							$query_5 = "UPDATE `products` SET `category_id` = '$subcategory_id', `brand_id` = '$brand_id', `brand_name` = '$brand_name', `product_name` = '$product_name', ";
							
							if($file_name_file != "" && file_exists("uploads/products-photos/".$file_name_file))
							{
								$query_5 .= "`file_name` = '$file_name', ";
							}
							
							$query_5 .= "`product_description` = '$product_description', `updated_at` = '$current_datetime' WHERE id = $product_id AND app_id = $app_id";

							$result_5 = mysqli_query( $link, $query_5);

							if(!$result_5)
							{
								$error = "E8 - ".$sww;
							}
							else
							{
								//$success = "Product has been updated";
								$updated_products++;
							}
						}
					}

					// Uploads product image
					if($error == "")
					{
						if($file_name_file != "" && file_exists("uploads/products-photos/".$file_name_file))
						{
							rename('uploads/products-photos/'.$file_name_file, '../uploads/store-'.$app_id.'/products/'.$file_name);
							//move_uploaded_file($image_tmp_name, "../uploads/store-".$app_id."/products/" . $file_name);
							//@unlink("uploads/products-photos/".$file_name);
							$query13 = "DELETE FROM products_photos WHERE file_name = '".$file_name_file."'";

							if(mysqli_query($link, $query13))
							{
								//$success = "Item has been deleted successfully";
							}
						}
					}

					// Calculate GST prices and Raw Prices and Dsicount
					if($error == "")
					{
						//echo "5".'<br />';
						if($sale_rate != $mrp)
						{
							$discount_applied = TRUE;
							$offer_type = 1;	// Always 1 via CSV Import
							$offer_value = (($sale_rate * 100) / $mrp);
							$offer_value = 100 - $offer_value;
							$offer_value = decimalNumberFormat($offer_value);
						}
						else
						{
							$discount_applied = FALSE;
						}

						$price = $mrp;
						$gst_percentage = getGSTPercentageString($gst_percentage);

						if($gst_percentage == 0)
						{
							$price_raw = $price;
							$price_gst = 0;
						}
						else
						{
							$price_raw = (($price * $gst_percentage) / 100);
							$price_gst = $price - $price_raw;
						}

						/*echo 'Raw Price - '.$price_raw.'<br/>';
						echo 'gst_percentage - '.$gst_percentage.'<br/>';
						echo 'price_gst - '.$price_gst.'<br/>';
						echo 'price - '.$price.'<br/><br/>';*/

						$price_raw 		= decimalNumberFormat($price_raw);
						$gst_percentage = decimalNumberFormat($gst_percentage);
						$price_gst 		= decimalNumberFormat($price_gst);
						$price 			= decimalNumberFormat($price);

						/*echo 'Raw Price - '.$price_raw.'<br/>';
						echo 'gst_percentage - '.$gst_percentage.'<br/>';
						echo 'price_gst - '.$price_gst.'<br/>';
						echo 'price - '.$price.'<br/>';
						exit;*/
						
						if($discount_applied == TRUE)
						{
							$discount_amount 	= (($price * $offer_value) / 100);
							$offer_price 		= $price - $discount_amount;
						}
						else
						{
							$offer_price = $price;
						}

						$measure_type		= $uom;
						$approx_quantity 	= '';
						$net_measure		= $pack_size;
					}

					// Update Product Price Checking
					if($error == "")
					{
						//echo "6".'<br />';
						if($new_product == TRUE)
						{
							$new_variant = TRUE;
						}
						else
						{
							$query_7 = "SELECT id, measure_type, net_measure FROM products_variant WHERE app_id = $app_id AND product_id = $product_id";

							$result_7 = mysqli_query($link, $query_7);

							if(!$result_7)
							{
								$error = "E9 - ".$sww;
							}
							else if(mysqli_num_rows($result_7) == 0)
							{
								$new_variant = TRUE;
							}
							else
							{
								$new_variant = FALSE;

								if(mysqli_num_rows($result_7) == 1)
								{
									$row_7 = mysqli_fetch_assoc($result_7);

									$variant_id = $row_7['id'];
								}
								else
								{
									$price_found = FALSE;
									while($row_7 = mysqli_fetch_assoc($result_7))
									{
										$measure_type 		= $row_7['measure_type'];
										$net_measure 		= $row_7['net_measure'];

										if($measure_type == $uom && $net_measure = $pack_size)
										{
											$price_found = TRUE;
											$variant_id 	= $row_7['id'];
										}

										$spec_case_price_id = $row_7['id'];
									}

									if($price_found == FALSE)
									{
										$variant_id 	= $spec_case_price_id;
									}
								}
							}
						}
					}

					// Add or Update Product Price
					if($error == "")
					{
						
						
						//echo "7".'<br />';
						if($new_variant == TRUE)
						{
							$query_8 = "INSERT INTO `products_variant`(`app_id`, `product_id`, `measure_type`, `net_measure`, `price_raw`, `gst_percentage`, `price_gst`, `price_finale`, `offer_type`, `offer_value`, `expires_at`, `offer_price`, `stock_amount`, `created_at`, `updated_at`, `status`) VALUES ('$app_id', '$product_id', '$measure_type', '$net_measure', '$price_raw', '$gst_percentage', '$price_gst', '$price', ";
							
							if($discount_applied == TRUE)
							{
								$query_8 .= " '$offer_type', '$offer_value', NULL, '$offer_price', ";
							}
							else
							{
								$query_8 .= " '0', '0', NULL, '$price', ";
							}
							
							$query_8 .= "'$stock_amount', '$current_datetime', '$current_datetime', 1)";

							//echo $query_8."----";
							$result_8 = mysqli_query( $link, $query_8);

							if(!$result_8)
							{
								$error = "E10 - ".$sww;
							}
							else
							{
								$variant_id = mysqli_insert_id($link);
								//$success = "Product price been added";
							}
						}
						else
						{
							$query_9 = "UPDATE `products_variant` SET `measure_type` = '$measure_type', `net_measure` = '$net_measure', `price_raw` = '$price_raw', `gst_percentage` = '$gst_percentage', `price_gst` = '$price_gst', `price_finale` = '$price', ";
							
							if($discount_applied == TRUE)
							{
								$query_9 .= "`offer_type` = '$offer_type', `offer_value` = '$offer_value', `expires_at` = NULL, `offer_price` = '$offer_price'";
							}
							else
							{
								$query_9 .= "`offer_type` = '0', `offer_value` = '0', `expires_at` = NULL, `offer_price` = '$price'";
							}
							$query_9 .= " WHERE app_id = $app_id AND id = $variant_id AND product_id = $product_id";

							$result_9 = mysqli_query( $link, $query_9);

							if(!$result_9)
							{
								$error = "E11 - ".$sww;
							}
							else
							{
								//$success = "Product price been updated";
							}
						}
					}
				}
				}
				$i++;
				if($error != "")
				{
					$full_error .= "Error on line ".$i." - ".$error."<br />";
					$error = "";
				}
			}

			if($full_error == "")
			{
				$full_success = "Products has been updated";
				//$full_success .= "<br />Inseted Products: ".$inserted_products;
				//$full_success .= "<br />Updated Products: ".$updated_products;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title.' - '.$application_name; ?></title>
	<meta name="keywords" content=""/>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="vendor/plugins/magnific/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="main">
		<?php require_once "header.php"; ?>
		<?php require_once "sidebar.php"; ?>
        
		<section id="content_wrapper">

			<header id="topbar">
				<div class="topbar-left">
					<ol class="breadcrumb">
						<li class="crumb-active">
							<a href=""><?php echo $page_title; ?></a>
						</li>
						<li class="crumb-icon">
							<a href="index.php"><span class="fa fa-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="products-add.php" class="pl5 btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add New Product
						</a>
						<?php /*?><a href="products-sort.php" class="pl5 btn btn-default btn-sm" style="margin-left: 20px;">
							<i class="fa fa-signal"></i> Sort Order
						</a><?php */?>
					</div>
				</div>
			</header>

			<div id="content">
				<div class="row">
					<div class="col-md-12">						
						<div class="panel panel-visible panel-dark">
							<div class="panel-heading panel-visible">
								<span class="panel-title"><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Upload File </label>
										<div class="col-lg-7">
											<input type="file" class="form-control" name="csv_file">
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8 mt20">
											<button type="submit" name="import_csv" class="btn btn-success">Import</button>
											<a href="products-import.php?sample-csv=1" class="btn btn-info">Download Sample CSV</a>
											<a href="products-import.php" class="btn btn-warning">Cancel</a>
											<?php if(isset($error) && $error != ""){ echo "<br /><br /><code>".$error."</code>"; }?>
										</div>
									</div>
								</form>
							</div>
						</div>
						
						<?php if(isset($full_error) && $full_error == "") { ?>
						<div class="alert alert-micro alert-border-left alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-check pr10"></i>
							<strong>Success!</strong> <?php echo $full_success; ?>
						</div>
						<?php } ?>
						
						<?php if(isset($inserted_products) && isset($updated_products)) { ?>
						<div class="alert alert-micro alert-border-left alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Inseted Products: <?php echo $inserted_products; ?>
							<br />Updated Products: <?php echo $updated_products; ?>
						</div>	
						<?php } ?>
						
						<?php if(isset($full_error) && $full_error != "") { ?>
						<div class="alert alert-sm alert-border-left alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-info pr10"></i>
							<strong>Oh snap!</strong> You need to Change a few things up and try again.
							<br /><br /><?php echo $full_error; ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<script src="vendor/jquery/jquery-1.11.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="vendor/plugins/mixitup/jquery.mixitup.min.js"></script>
	<script src="vendor/plugins/magnific/jquery.magnific-popup.js"></script>
	<script src="vendor/plugins/fileupload/fileupload.js"></script>
	<script src="vendor/plugins/holder/holder.min.js"></script>
	<script src="assets/js/dropzone.js"></script>
	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/custom.js"></script>
	
    <script type="text/javascript">
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core    
            Core.init();
            // Init Demo JS   
            Demo.init();
        });
    </script>
	<?php require "footer-js.php"; ?>
</body>
</html>