<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Add New Admin";

if ( isset( $_POST[ 'save' ] ) )
{
	$store_id 		= escapeInputValue( $_POST[ 'store_id' ] );
	$first_name		= escapeInputValue( $_POST[ 'first_name' ] );
	$last_name 		= escapeInputValue( $_POST[ 'last_name' ] );
	$email 			= escapeInputValue( $_POST[ 'email' ] );
	$mobile 		= escapeInputValue( $_POST[ 'mobile' ] );
	$status 		= escapeInputValue( $_POST[ 'status' ] );

	$n_password 	= $_POST[ 'n_password' ];
	$r_password 	= $_POST[ 'r_password' ];

	if ($first_name == "" || $last_name == "" || $mobile == "" || $n_password == "" || $r_password == "" ) {
		$error = "Please enter all details";
	}
	else if ($email != "" && !preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email ) ) {
		$error = 'Please enter valid email address';
	}
	else if (!preg_match( "/^[0-9]+$/", $mobile ) )
	{
		$error = 'Please enter valid mobile number';
	}
	else if ( $n_password != $r_password )
	{
		$error = "Enter password correctly two times";
	}
	
	if($error == "")
	{
		$q_11 = "SELECT id, email, mobile FROM admin WHERE app_id = $app_id AND ( email = '$email' OR mobile = '$mobile' )";
		$r_11 = mysqli_query( $link, $q_11 );

		if ( !$r_11 )
		{
			$error = $sww;
		}
		else if ( mysqli_num_rows( $r_11 ) > 0 )
		{
			$row_11 = mysqli_fetch_assoc($r_11);
			if($row_11['email'] == $email && $email != "")
			{
				$error = "Email address already exists";
			}
			else if($row_11['mobile'] == $mobile)
			{
				$error = "Mobile number already exists";
			}
		}
	}
	
	if ( $error == "" )
	{
		$password = passwordEncyption( $n_password, "e" );

		$sql_ins = "INSERT INTO `admin` (`app_id`, `role_id`, `first_name`, `last_name`, `email`, `mobile`, `password`, `created_at`, `updated_at`, `status`) VALUES ($app_id, 3, '$first_name', '$last_name', '$email', '$mobile', '$password', '$current_datetime', '$current_datetime', '$status' )";

		$result = mysqli_query( $link, $sql_ins );

		if (!$result )
		{
			$error = $sww;
		}
		else
		{
			$_SESSION['msg_success'] = "Admin has been added successfully.";
			header("location:stores-admin-add.php");
			exit;
		}
	}
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
    <!-- Font CSS (Via CDN) -->
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/datatables_addons.min.css">
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- Start: Main -->
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
							<a href="stores-admin.php">Stores Admin</a>
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
                                <span class="panel-title"><span class="fa fa-plus"></span><?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
								<form class="form-horizontal" role="form" method="post" action="" >
									
									<div class="form-group">
										<label class="col-lg-3 control-label">First Name*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name']; } ?>" placeholder="Enter first name">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Last Name*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name']; } ?>" placeholder="Enter last name">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Email</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" placeholder="Enter email">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Mobile*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile" value="<?php if(isset($_POST['mobile'])) { echo $_POST['mobile']; } ?>" placeholder="Enter mobile">
										</div>
									</div>
									
									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Password*</label>
										<div class="col-lg-7">
											<input type="password" class="form-control" name="n_password" placeholder="Enter new password">
										</div>
									</div>
									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Re-type Password*</label>
										<div class="col-lg-7">
											<input type="password" class="form-control" name="r_password" placeholder="Re-type your new password">
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
										<div class="col-lg-offset-3 col-lg-8 mt20">
											<button type="submit" name="save" class="btn btn-success">Save</button>
											<a href="settings.php" class="btn btn-warning">Cancel</a>
											<?php if(isset($error) && $error != ""){ echo "<code>".$error."</code>"; }?>
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
	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
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