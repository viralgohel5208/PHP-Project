<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$page_title = "Admin Update";

if(isset($_POST['save']))
{
	$item_id 				= escapeInputValue( $_GET[ 'id' ] );
	$app_id 				= escapeInputValue( $_POST[ 'app_id' ] );
	$se_id 					= escapeInputValue( $_POST[ 'se_id' ] );
	$package_id				= escapeInputValue( $_POST[ 'package_id' ] );
	$package_price_raw		= escapeInputValue( $_POST[ 'package_price_raw' ] );
	$package_price_gst 		= escapeInputValue( $_POST[ 'package_price_gst' ] );
	$package_price 			= escapeInputValue( $_POST[ 'package_price' ] );
	$status 				= escapeInputValue( $_POST[ 'status' ] );
	
	$starting_date			= escapeInputValue($_POST['starting_date']);
	$starting_date_1 		= date_create($starting_date);
	$starting_date_2		= date_format($starting_date_1, 'Y-m-d');
	
	$expiry_date			= escapeInputValue($_POST['expiry_date']);
	$expiry_date_1 			= date_create($expiry_date);
	$expiry_date_2			= date_format($expiry_date_1, 'Y-m-d');
	
	mysqli_autocommit($link, FALSE);
	
	if ($package_id == "" || $package_price_raw == "" || $package_price_gst == "" || $starting_date == "" || $expiry_date == "" ) {
		$error = "Please enter all details";
	}
	else if ($package_price_raw != "" && !preg_match( "/^([1-9][0-9]*|0)(\.[0-9]{2})?$/", $package_price_raw ) ) {
		$error = 'Please enter valid package price';
	}
	else if ($package_price_gst != "" && !preg_match( "/^([1-9][0-9]*|0)(\.[0-9]{2})?$/", $package_price_gst ) ) {
		$error = 'Please enter valid package price';
	}
	else if ($package_price != "" && !preg_match( "/^([1-9][0-9]*|0)(\.[0-9]{2})?$/", $package_price ) ) {
		$error = 'Please enter valid package price';
	}
	else if ($starting_date_2 > $expiry_date_2 )
	{
		$error = 'Please enter valid starting date and expiry date';
	}
	
	if($error == "")
	{
		$q_11 = "SELECT id FROM subscription_details WHERE id = $item_id";
		$r_11 = mysqli_query( $link, $q_11 );

		if ( !$r_11 )
		{
			$error = $sww;
		}
		else if ( mysqli_num_rows( $r_11 ) == 0 )
		{
			$error = "Subscription does not exists";
		}
	}
	
	if($error == "")
	{
		$up_query = "UPDATE `subscription_details` SET `package_id` = '$package_id', `package_price_raw` = '$package_price_raw', `package_price_gst` = '$package_price_gst', `package_price` = '$package_price', `starting_date` = '$starting_date_2', `expiry_date` = '$expiry_date_2', `updated_at` = '$current_datetime', `status` = '$status' WHERE id = $item_id";

		$result5 = mysqli_query($link, $up_query);
		if(!$result5)
		{
			$error = $sww;
		}
		else
		{
			/*mysqli_autocommit($link, TRUE);
			$_SESSION['msg_success'] = "Admin details has been updated successfully";
			header("location:stores-admin-update.php?id=$item_id");
			exit;*/
		}
	}
	
	if ( $error == "" )
	{
		$sql_ins = "INSERT INTO `subscription_history`(`app_id`, `se_id`, `package_id`, `package_price_raw`, `package_price_gst`, `package_price`, `starting_date`, `expiry_date`, `created_at`, `status`) VALUES ('$app_id', ";
		if($se_id == "") {
			$sql_ins .= "NULL, ";
		} else {
			$sql_ins .= "'$se_id', ";
		}
		$sql_ins .= " $package_id, '$package_price_raw', '$package_price_gst', '$package_price', '$starting_date_2', '$expiry_date_2', '$current_datetime', '$status')";

		$result = mysqli_query( $link, $sql_ins );

		if (!$result )
		{
			$error = $sww;
		}
		else
		{
			/*$_SESSION['msg_success'] = "Admin has been added successfully.";
			header("location:client-subscriptions-add.php");
			exit;*/
		}
	}
	
	if($error == "")
	{
		mysqli_autocommit($link, TRUE);
		$_SESSION['msg_success'] = "Subscription has been updated successfully.";
		header("location:client-subscriptions.php");
		exit;
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT S.*, A.first_name, A.last_name FROM `subscription_details` AS S INNER JOIN admin AS A ON A.app_id = S.app_id AND role_id = 2 WHERE S.id = '" . $item_id . "'" ;
	//exit;
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			$_SESSION['msg_error'] = "Subscription details does't found"; header("Location:client-subscriptions.php"); exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww; header("Location:client-subscriptions.php"); exit;
	}
}
else
{
	header( "Location:client-subscriptions.php" ); exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $page_title.' - '.$application_name; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
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
							<a href="index.php"><span class="glyphicon glyphicon-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-link">
							<a href="client-subscriptions.php">Client Subscriptions</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="stores-admin.php" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>				
			</header>

            <div id="content">

                <div class="row">
                    <div class="col-md-12">
						
						<?php require_once "message-block.php"; ?>
                        
						<div class="panel panel-visible panel-dark">
                            <div class="panel-heading panel-visible">
                                <span class="panel-title"><span class="fa fa-pencil"></span><?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
								<form class="form-horizontal" role="form" method="post" action="">
									
									<input type="hidden" name="app_id" value="<?php echo $row_3['app_id']; ?>">
									<input type="hidden" name="se_id" value="<?php echo $row_3['se_id']; ?>">
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Admin</label>
										<div class="col-lg-7">
											<p class="form-control-static text-muted"><?php echo $row_3['first_name'].' '.$row_3['last_name']; ?></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Sales Executive</label>
										<div class="col-lg-7">
											<p class="form-control-static text-muted">
												<?php 
												if($row_3['se_id'] != "") {
												$se_query = "SELECT first_name, last_name FROM sales_executives WHERE id = ".$row_3['se_id']; $se_res = mysqli_query($link, $se_query);
												$se_row = mysqli_fetch_assoc($se_res);
												echo $se_row['first_name'].' '.$se_row['last_name'];
												}
												?>
											</p>
										</div>
									</div>
									<?php 
									$result1 = mysqli_query($link, "SELECT id, package_name, package_price FROM packages WHERE status = 1 ORDER BY package_price ASC");
									if($result1)
									{ 
									?>
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Package*</label>
                                        <div class="col-lg-7">
											<select name="package_id" class="form-control" onChange="getPackagePrice(this.value);">
												<option value="">Select Package</option>
												<?php while($row1 = mysqli_fetch_assoc($result1)) {
												   	echo '<option value="'.$row1['id'].'"';
													if(isset($_POST['package_id']))
													{
														if($_POST['package_id'] == $row1['id'])
														{
															echo ' selected="selected"';
														}
													}
													else if($row_3['package_id'] == $row1['id'])
													{
														echo ' selected="selected"';
													}
													echo '>'.$row1['package_name'].' ( Rs. '.$row1['package_price'].' )</option>';
												} ?>
											</select>
										</div>
                                    </div>
									<?php } ?>
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Raw Price*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="package_price_raw" id="package_price_raw" value="<?php if(isset($_POST['package_price_raw'])) { echo $_POST['package_price_raw']; } else { echo $row_3['package_price_raw']; } ?>" placeholder="Enter raw price">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">GST Price*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="package_price_gst" id="package_price_gst" value="<?php if(isset($_POST['package_price_gst'])) { echo $_POST['package_price_gst']; } else { echo $row_3['package_price_gst']; } ?>" placeholder="Enter gst price">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Finle Price</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="package_price" id="package_price" value="<?php if(isset($_POST['package_price'])) { echo $_POST['package_price']; } else { echo $row_3['package_price']; } ?>" placeholder="Enter finle price">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Starting Date*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" id="datetimepicker1" name="starting_date" value="<?php if(isset($_POST['starting_date'])) { echo $_POST['starting_date']; } ?>" placeholder="Enter subscription starting date">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Expiry Date*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" id="datetimepicker2" name="expiry_date" value="<?php if(isset($_POST['expiry_date'])) { echo $_POST['expiry_date']; } ?>" placeholder="Enter subscription ending date">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Status</label>
										<div class="col-sm-7">
											<select name="status" class="form-control">
												<?php foreach(setClientSubscriptionState() as $key=>$value) { 
												echo '<option value="'.$key.'" ';
												if(isset($_POST['status']) && $_POST['status'] == $key ) { echo 'selected="selected"'; }
												else if($row_3['status'] == $key ) { echo 'selected="selected"'; }
												echo '>'.$value.'</option>';
												} ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="save" class="btn btn-success">Save</button>
											<a href="stores-admin.php" class="btn btn-warning">Cancel</a>
										</div>
									</div>
								</form>
                            </div>
                         </div>
                    </div>
                 </div>
            </div>
		</section>
    </div>
    <!-- End: Main -->

    <script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="vendor/plugins/moment/moment.min.js"></script>

	<script src="vendor/plugins/datepicker/js/bootstrap-datetimepicker.js"></script>
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
			
			$('#datetimepicker1').datetimepicker({
				pickTime: false,
				//minDate: '<?php echo date("d-m-Y"); ?>',
				format: 'DD-MM-YYYY',
				defaultDate: '<?php if(isset($_POST['starting_date'])) { echo $_POST['starting_date']; } else { $st = explode("-", $row_3['starting_date']); echo $st[2].'-'.$st[1].'-'.$st[0]; } ?>',
			});
			$('#datetimepicker2').datetimepicker({
				pickTime: false,
				//minDate: '<?php echo date("d-m-Y"); ?>',
				format: 'DD-MM-YYYY',
				defaultDate: '<?php if(isset($_POST['expiry_date'])) { echo $_POST['expiry_date']; } else { $st = explode("-", $row_3['expiry_date']); echo $st[2].'-'.$st[1].'-'.$st[0]; } ?>',
			});
        });
    </script>
</body>
</html>