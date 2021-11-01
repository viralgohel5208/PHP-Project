<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Admin Update";

if(isset($_POST['save']))
{
	$item_id 		= escapeInputValue($_GET[ 'id' ]);
	$first_name 	= escapeInputValue($_REQUEST['first_name']);
	$last_name 		= escapeInputValue($_REQUEST['last_name']);
    $email   		= escapeInputValue($_REQUEST['email']);
    $mobile  		= escapeInputValue($_REQUEST['mobile']);
    $status 		= escapeInputValue($_REQUEST['status']);
	
	if($first_name =="" || $last_name == "" || $mobile == "")
	{
		$error = "Please enter all details";
	}
	else if ($email != "" && !preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email ) ) {
		$error = 'Please enter valid email address';
	}
	else if (!preg_match( "/^[0-9]+$/", $mobile ) )
	{
		$error = 'Please enter valid mobile number';
	}
	
	if($error == "")
	{
		$q_11 = "SELECT id, email, mobile FROM admin WHERE app_id = $app_id AND id != $item_id AND ( email = '$email' OR mobile = '$mobile' )";
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
	
	if($error == "")
	{
		$up_query = "UPDATE admin SET first_name = '$first_name', last_name = '$last_name', email = '$email', mobile = '$mobile', updated_at = '$current_datetime', status = $status WHERE id = '$item_id' AND app_id = $app_id";

		//echo $up_query;
		$result5 = mysqli_query($link, $up_query);
		if(!$result5)
		{
			$error = $sww;
		}
		else
		{
			mysqli_autocommit($link, TRUE);
			$_SESSION['msg_success'] = "Admin details has been updated successfully";
			header("location:stores-admin-update.php?id=$item_id");
			exit;
		}
	}
}

if ( isset( $_POST[ 'save_password' ] ) )
{
	$item_id 		= escapeInputValue($_GET[ 'id' ]);
	
	$n_password 	= $_POST[ 'n_password' ];
	$r_password 	= $_POST[ 'r_password' ];

	if ( $n_password == "" || $r_password == "" )
	{
		$error = "Please enter all details";
	}
	else if ( $n_password != $r_password )
	{
		$error = "Enter new password correctly two times";
	}
	else
	{
		$password = passwordEncyption( $n_password, "e" );
		
		$query_1 = "UPDATE admin SET password = '" . $password  . "', updated_at = '$current_datetime' WHERE id = '" . $item_id . "' AND app_id = $app_id ";
		$result = mysqli_query( $link, $query_1 );
		if(!$result)
		{
			$error = $sww;
		}
		else
		{
			$success = "Password updated successfully.";
		}
	}
	//header("location:users-view.php?id=".$user_id);
	//exit;  	
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT * FROM `admin` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			$_SESSION['msg_error'] = "Admin does't found";
			header( "Location:stores-admin.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:stores-admin.php" );
		exit;
	}
}
else
{
	header( "Location:stores-admin.php" );
	exit;
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
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
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
                                <span class="panel-title"><span class="fa fa-pencil"></span><?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
								<form class="form-horizontal" role="form" method="post" action="">
									<div class="form-group">
										<label class="col-lg-3 control-label">First Name</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name']; } else { echo $row_3['first_name']; } ?>" placeholder="Enter first name">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Last Name</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name']; } else { echo $row_3['last_name']; } ?>" placeholder="Enter last name">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Email</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } else { echo $row_3['email']; } ?>" placeholder="Enter email">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Mobile</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile" value="<?php if(isset($_POST['mobile'])) { echo $_POST['mobile']; } else { echo $row_3['mobile']; } ?>" placeholder="Enter mobile">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label">Status</label>
										<div class="col-sm-7">
											<select name="status" class="form-control">
												<option value="1" <?php if(isset($_POST['status']) && $_POST['status'] == 1 ) { echo 'selected="selected"'; } else if($row_3['status'] == 1) { echo 'selected="selected"'; } ?>>Active</option>
												<option value="0" <?php if(isset($_POST['status']) && $_POST['status'] == 0 ) { echo 'selected="selected"'; } else if($row_3['status'] == 0) { echo 'selected="selected"'; } ?>>Inactive</option>
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
						
						<div class="panel panel-dark">
                            <div class="panel-heading">
                                <span class="panel-title"><span class="fa fa-lock"></span> Change Password</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post" action="" autocomplete="off">
                                    
                                    <div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">New Password</label>
                                        <div class="col-lg-8">
                                            <input type="password" class="form-control" name="n_password" placeholder="Enter New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">Re-type Password</label>
                                        <div class="col-lg-8">
                                            <input type="password" class="form-control" name="r_password" placeholder="Re-type Your New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-8">
                                            <button type="submit" name="save_password" class="btn btn-success">Save</button>
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