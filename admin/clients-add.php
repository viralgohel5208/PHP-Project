<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$user_id = $_SESSION['user_id'];

if(isset($_POST['submit']))
{
	$first_name 		= escapeInputValue($_POST['first_name']);
	$last_name 			= escapeInputValue($_POST['last_name']);
	$email 				= escapeInputValue($_POST['email']);
	$mobile 			= escapeInputValue($_POST['mobile']);
	$password 			= escapeInputValue($_POST['password']);
	$re_password 		= escapeInputValue($_POST['re_password']);
	$status 			= escapeInputValue($_REQUEST['status']);
	
	mysqli_autocommit($link, FALSE);
	
	if($first_name == ""  || $last_name == "" || $email == "" || $mobile == "" || $password == "" || $re_password == "")
	{
		$error = "Please enter user details";
	}
	else if(checkValidNameString($first_name) == FALSE)
	{
		$error = "First name contains invalid characters";
	}
	else if(checkValidNameString($last_name) == FALSE)
	{
		$error = "Last name contains invalid characters";
	}
	else if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email))
	{
		$error = "Please enter valid email address format";
	}
	else if (!preg_match( "/^[0-9]+$/", $mobile ) )
	{
		$error = 'Please enter valid mobile number';
	}
	else if(strlen($password) < 6)
	{
		$error = "Password must be greater than 5 characters";
	}
	else if($password != $re_password)
	{
		$error = "Password does not match.";
	}
	
	if($error == "")
	{
		$query_1 = "SELECT id, email, mobile FROM admin WHERE email = '$email' OR mobile = '$mobile'";
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = $sww;
		}
		else if (mysqli_num_rows($result_1) > 0)
		{
			$row_1 = mysqli_fetch_assoc($result_1);
			$email_db = $row_1['email'];
			$mobile_db = $row_1['mobile'];
			if($email_db == $email)
			{
				$error = "Client email already exists";
			}
			else
			{
				$error = "Client mobile number already exists";
			}
		}
	}
	
	if($error == "")
	{
		$query_app = "SELECT MAX(app_id) as client_app_id FROM admin";
		$res_app = mysqli_query($link, $query_app);
		$row_app = mysqli_fetch_assoc($res_app);
		$client_app_id = $row_app['client_app_id'];
		if( $client_app_id == NULL ) { $client_app_id = 1; } else { $client_app_id = $client_app_id + 1;}
	}
	
	if($error == "")
	{
		$first_name = ucfirst($first_name);
		$last_name 	= ucfirst($last_name);
		
		$passwordEncyption = passwordEncyption($password, 'e');
		$role_id = 2;
		
		$query_2 = "INSERT INTO `admin`(`app_id`, `role_id`, `first_name`, `last_name`, `email`, `mobile`, `password`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES ('$client_app_id', '$role_id', '$first_name', '$last_name', '$email', '$mobile', '$passwordEncyption', '$user_id', '$user_id', '$current_datetime', '$current_datetime', '$status')";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = $sww;
		}
		else
		{
			if (!file_exists('../uploads/store-'.$client_app_id.'/banners')) {
				mkdir('../uploads/store-'.$client_app_id.'/banners', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/brands')) {
				mkdir('../uploads/store-'.$client_app_id.'/brands', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/categories')) {
				mkdir('../uploads/store-'.$client_app_id.'/categories', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/customer-profile')) {
				mkdir('../uploads/store-'.$client_app_id.'/customer-profile', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/logo')) {
				mkdir('../uploads/store-'.$client_app_id.'/logo', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/product-photos')) {
				mkdir('../uploads/store-'.$client_app_id.'/product-photos', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/products')) {
				mkdir('../uploads/store-'.$client_app_id.'/products', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/sliders')) {
				mkdir('../uploads/store-'.$client_app_id.'/sliders', 0777, true);
			}
			if (!file_exists('../uploads/store-'.$client_app_id.'/testimonials')) {
				mkdir('../uploads/store-'.$client_app_id.'/testimonials', 0777, true);
			}
		}
	}
	
	if($error == "")
	{
		mysqli_autocommit($link, TRUE);
		$success = "Client details has been added successfully";
		unset($_POST);
	}
}

$page_title = "Add Client";

$role_id = $_SESSION['role_id'];
	
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
<body class="form-inputs-page">
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
						<li class="crumb-link">
							<a href="clients.php">Clients</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="clients.php" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>
				
			</header>

			<div id="content" class="animated fadeIn">
				<div class="row">
					<div class="col-md-12">

						<?php require_once "message-block.php"; ?>
						
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title"><span class="fa fa-plus"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" id="demoform" role="form" method="post">
									<div class="form-group">
										<label class="col-lg-3 control-label">First name*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Last name*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name'];} ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Email*</label>
										<div class="col-lg-7">
											<input type="text"class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Mobile*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile" value="<?php if(isset($_POST['mobile'])) { echo $_POST['mobile'];} ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Password*</label>
										<div class="col-lg-7">
											<input type="password" class="form-control" name="password" value="<?php if(isset($_POST['password'])) { echo $_POST['password'];} ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Re-enter Password*</label>
										<div class="col-lg-7">
											<input type="password" class="form-control" name="re_password" value="<?php if(isset($_POST['re_password'])) { echo $_POST['re_password'];} ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label">Status</label>
										<div class="col-sm-7">
											<select name="status" class="form-control">
												<option value="1" <?php if(isset($_POST['status']) && $_POST['status'] == 1 ) { echo 'selected="selected"'; } ?>>Active</option>
												<option value="0" <?php if(isset($_POST['status']) && $_POST['status'] == 0 ) { echo 'selected="selected"'; } ?>>Inactive</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="clients.php" class="btn btn-warning">Cancel</a>
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

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	
	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function () {

			"use strict";

			// Init Theme Core    
			Core.init();

			// Init Demo JS    
			Demo.init();
		} );
	</script>
</body>
</html>