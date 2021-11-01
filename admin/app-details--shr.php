<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "App Details";

if(isset($_POST['save']))
{
	//echo '<pre>'; print_r($_POST); exit;
	$item_id 		= $app_id;
	
	$app_name 		= escapeInputValue($_REQUEST['app_name']);
	$mobile_1 		= escapeInputValue($_REQUEST['mobile_1']);
    $mobile_2  		= escapeInputValue($_REQUEST['mobile_2']);
	$email_1   		= escapeInputValue($_REQUEST['email_1']);
    $email_2   		= escapeInputValue($_REQUEST['email_2']);
    $website_url   	= escapeInputValue($_REQUEST['website_url']);
    $address   		= escapeInputValue($_REQUEST['address']);
    $city_id   		= escapeInputValue($_REQUEST['city_id']);
    $state_id   	= escapeInputValue($_REQUEST['state_id']);
    $country_id   	= escapeInputValue($_REQUEST['country_id']);
    $pincode   		= escapeInputValue($_REQUEST['pincode']);
    
    $status 		= escapeInputValue($_POST['status']);
	
	if($app_name =="" || $mobile_1 == "" || $address == "" || $city_id == "" || $city_id == "0" || $state_id == "" || $state_id == "0" || $country_id == "" || $country_id == "0" || $pincode == "")
	{
		$error = "Please enter mandatory(*) fields";
	}
	
	if($error == "")
	{
		$q_11 = "SELECT A.id as city_id, A.city_name, A.state_id, B.state_name, A.country_id, C.nicename as country_name FROM `cities_list` AS A INNER JOIN states AS B ON B.id = A.state_id INNER JOIN countries as C ON C.id = A.country_id WHERE A.id = $city_id LIMIT 1";
		
		$r_11 = mysqli_query( $link, $q_11 );

		if ( !$r_11 )
		{
			$error = "1".$sww;
		}
		else
		{
			if ( mysqli_num_rows( $r_11 ) > 0 )
			{
				$row_c = mysqli_fetch_assoc($r_11);
				$city_id = $row_c['city_id'];
				$city_name = $row_c['city_name'];
				$state_id = $row_c['state_id'];
				$state_name = $row_c['state_name'];
				$country_id = $row_c['country_id'];
				$country_name = $row_c['country_name'];
			}
		}
	}
	
	if($error == "")
	{
		$up_query = "UPDATE `app_details` SET `app_name` = '".$app_name."', `mobile_1` = '".$mobile_1."', `mobile_2` = '".$mobile_2."', `email_1` = '".$email_1."', `email_2` = '".$email_2."', `website_url` = '".$website_url."', `address` = '".$address."', `city_id` = ".$city_id.", `city_name` = '".$city_name."', `state_id` = ".$state_id.", `state_name` = '".$state_name."', `country_id` = ".$country_id.", `country_name` = '".$country_name."', `pincode` = '".$pincode."', `updated_at` = '".$current_datetime."', `status` = '".$status."' WHERE app_id = $app_id";

		//echo $up_query;
		$result5 = mysqli_query($link, $up_query);
		if($result5)
		{
			$_SESSION['msg_success'] = "Admin details has been updated successfully";
			header("location:app-details.php");
			exit;
		}
		else
		{
			$error = "2".$sww;
		}
	}
}

$query = "SELECT * FROM app_details WHERE app_id = ".$app_id;
$result = mysqli_query($link, $query);
if($result)
{
    $row_3 = mysqli_fetch_assoc($result);
}
else
{
    $error_500 = 500;
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
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="<?php if(isset($error_500)) { echo 'error-page sb-l-o sb-r-c'; } else { echo 'form-input-page'; } ?>">
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
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="index.php" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>				
			</header>
            
            <?php if(isset($error_500) && $error_500 == 500) { ?>
            
            <section id="content" class="pn">
                <div class="center-block mt50 mw800 animated fadeIn">
                    <h1 class="error-title"> 500! </h1>
                    <h2 class="error-subtitle">Internal Server Error.</h2>
                </div>
            </section>
            
            <?php } else { ?>
            
            <div id="content">
                <div class="row">
                    <div class="col-md-12">
						
						<?php require_once "message-block.php"; ?>
						
                        <div class="panel panel-dark">
                            <div class="panel-heading">
                                <span class="panel-title"><span class="fa fa-cog"></span> <?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post" action="">
									<div class="form-group">
										<label class="col-lg-3 control-label">Application Name*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="app_name" value="<?php if(isset($_POST['app_name'])) { echo $_POST['app_name']; } else { echo $row_3['app_name']; } ?>" placeholder="Enter application name">
										</div>
									</div>
									<?php /*?><div class="form-group">
										<label class="col-lg-3 control-label">app_tagline</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="app_tagline" value="<?php if(isset($_POST['app_tagline'])) { echo $_POST['app_tagline']; } else { echo $row_3['app_tagline']; } ?>" placeholder="Enter last name">
										</div>
									</div><?php */?>
									<div class="form-group">
										<label class="col-lg-3 control-label">Email 1</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="email_1" value="<?php if(isset($_POST['email_1'])) { echo $_POST['email_1']; } else { echo $row_3['email_1']; } ?>" placeholder="Enter email 1">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Email 2</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="email_2" value="<?php if(isset($_POST['email_2'])) { echo $_POST['email_2']; } else { echo $row_3['email_2']; } ?>" placeholder="Enter email 2">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Mobile 1*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile_1" value="<?php if(isset($_POST['mobile_1'])) { echo $_POST['mobile_1']; } else { echo $row_3['mobile_1']; } ?>" placeholder="Enter mobile 1">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Mobile 2</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile_2" value="<?php if(isset($_POST['mobile_2'])) { echo $_POST['mobile_2']; } else { echo $row_3['mobile_2']; } ?>" placeholder="Enter mobile 2">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Website Url</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="website_url" value="<?php if(isset($_POST['website_url'])) { echo $_POST['website_url']; } else { echo $row_3['website_url']; } ?>" placeholder="Enter website url">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Address*</label>
										<div class="col-lg-7">
											<textarea class="form-control" name="address" rows="3" placeholder="Enter address"><?php if(isset($_POST['address'])) { echo $_POST['address']; } else { echo $row_3['address']; } ?></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Country*</label>
										<div class="col-lg-7">
											<select name="country_id" id="country_id" class="form-control" onChange="getStatesList(this.value)">
												<option value="0">Select Country ...</option>
												<?php 
												$query = "SELECT id, nicename, iso3 FROM countries ORDER BY nicename";
												$result = mysqli_query($link, $query);
												while($row = mysqli_fetch_assoc($result))
												{
													echo '<option value="'.$row['id'].'"';
													if(isset($_POST['country_id'])) {
														if($_POST['country_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													} else {
														//echo ' selected="selected"';
														if($row_3['country_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row['nicename'].' ('.$row['iso3'].')</option>';
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-3 control-label">State*</label>
										<div class="col-lg-7">
											<select name="state_id" id="states-list" class="form-control" onChange="getCitiesList(this.value);">
												<option value="0">Select State ...</option>
												<?php 
												$query = "SELECT id, state_name FROM states WHERE country_id = ".$row_3['country_id']." ORDER BY state_name";
												$result = mysqli_query($link, $query);
												while($row = mysqli_fetch_assoc($result))
												{
													echo '<option value="'.$row['id'].'"';
													if(isset($_POST['category_id'])) {
														if($_POST['category_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													} else {
														if($row_3['state_id'] == $row['id']) {
															echo ' selected="selected"';
														}
													}
													echo '>'.$row['state_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
                         
									<div class="form-group">
										<label class="col-lg-3 control-label">City*</label>
										<div class="col-lg-7">
											<select name="city_id" id="cities-list" class="form-control">
											<option value="">Select City ...</option>
											<?php 
											$query = "SELECT id, city_name FROM cities_list WHERE state_id = ".$row_3['state_id']." ORDER BY city_name";
											$result = mysqli_query($link, $query);
											while($row = mysqli_fetch_assoc($result))
											{
												echo '<option value="'.$row['id'].'"';
												if(isset($_POST['city_id'])) {
													if($_POST['city_id'] == $row['id']) {
														echo ' selected="selected"';
													}
												} else {
													if($row_3['city_id'] == $row['id']) {
														echo ' selected="selected"';
													}
												}
												echo '>'.$row['city_name'].'</option>';
											}
											?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Pincode*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="pincode" value="<?php if(isset($_POST['pincode'])) { echo $_POST['pincode']; } else { echo $row_3['pincode']; } ?>" placeholder="Enter pincode">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label">Status*</label>
										<div class="col-sm-7">
											<select name="status" class="form-control">
												<option value="0" <?php if(isset($_POST['status']) && $_POST['status'] == 0 ) { echo 'selected="selected"'; } else if($row_3['status'] == 0) { echo 'selected="selected"'; } ?>>Inactive</option>
												<option value="1" <?php if(isset($_POST['status']) && $_POST['status'] == 1 ) { echo 'selected="selected"'; } else if($row_3['status'] == 1) { echo 'selected="selected"'; } ?>>Active</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-7">
											<button type="submit" name="save" class="btn btn-success">Save</button>
											<a href="app-details.php" class="btn btn-warning">Cancel</a>
										</div>
									</div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </section>
    </div>

    <script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
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
</body>
</html>