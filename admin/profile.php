<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Admin Profile";
$user_id = $_SESSION['user_id'];

if(isset($_POST['save']))
{
	$item_id 		= $user_id;
	
	$first_name 	= escapeInputValue($_REQUEST['first_name']);
	$last_name 		= escapeInputValue($_REQUEST['last_name']);
    $email   		= escapeInputValue($_REQUEST['email']);
    $mobile  		= escapeInputValue($_REQUEST['mobile']);
    $status 		= escapeInputValue($_POST['status']);
	
	$current = date('Y-m-d H:i:s');
	
	if($first_name =="" || $last_name == "" || $email == "" || $mobile == "")
	{
		$error = "Please enter all details";
	}
	
	if($error == "")
	{
		$q_11 = "SELECT id, email, mobile FROM admin WHERE (email = '$email' OR mobile = '$mobile') AND id != $item_id";
		
		$r_11 = mysqli_query( $link, $q_11 );

		if ( !$r_11 )
		{
			$error = $sww;
		}
		else
		{
			if ( mysqli_num_rows( $r_11 ) > 0 )
			{
				$error = "Email address or mobile number is already exist";
			}
		}
	}
	
	if($error == "")
	{
		$up_query = "UPDATE admin SET first_name = '$first_name', last_name = '$last_name', email = '$email', mobile = '$mobile', status = $status WHERE id = '$item_id'";

		//echo $up_query;
		$result5 = mysqli_query($link, $up_query);
		if($result5)
		{
			mysqli_autocommit($link, TRUE);
			$_SESSION['msg_success'] = "Admin details has been updated successfully";
			header("location:profile.php");
			exit;
		}
		else
		{
			$error = $sww;
		}
	}
}

if(isset($_POST['save_password']))
{
    
    $c_password = passwordEncyption($_POST['c_password'], 'e');
    $n_password = $_POST['n_password'];
    $r_password = $_POST['r_password'];

    if($c_password != "" && $n_password != "" && $r_password != "")
    {

        if(strlen($n_password) < 5)
        {
            $error = "Password must be 5 character long";
        }
        else if($n_password != $r_password)
        {
            $error = "Enter new password correctly two times";
        }
        else
        {
            
            $result_check = mysqli_query($link, "SELECT id FROM admin WHERE id = '".$user_id."' and password = '".$c_password."'");

            if($result_check)
            {
                if(mysqli_num_rows($result_check) > 0)
                {   
                    $final_n_password = passwordEncyption($n_password, 'e');
                    $result = mysqli_query($link, "UPDATE admin SET password = '".$final_n_password."' WHERE id = '".$user_id."'");

                    if($result)
                    {
                        $success = "Password updated successfully";
                    }
                    else
                    {
                        $error = $sww;
                    }
                }
                else
                {
                    $error = "Enter current password correctly";	
                }
            }
            else
            {
                $error = $sww;
            }
        }
    }
    else
    {
		$error = "Please enter all details";
    }	
}

$query = "SELECT * FROM admin WHERE id = ".$user_id;
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
                                <span class="panel-title"><span class="fa fa-user"></span> Admin</span>
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
										<div class="col-lg-offset-3 col-lg-7">
											<button type="submit" name="save" class="btn btn-success">Save</button>
											<a href="profile.php" class="btn btn-warning">Cancel</a>
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
                                        <label for="inputStandard" class="col-lg-3 control-label">Current Password</label>
                                        <div class="col-lg-7">
                                            <input type="password" class="form-control" name="c_password" placeholder="Enter Current Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">New Password</label>
                                        <div class="col-lg-7">
                                            <input type="password" class="form-control" name="n_password" placeholder="Enter New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">Re-type Password</label>
                                        <div class="col-lg-7">
                                            <input type="password" class="form-control" name="r_password" placeholder="Re-type Your New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-7">
                                            <button type="submit" name="save_password" class="btn btn-success">Save</button>
                                            <a href="profile.php" class="btn btn-warning">Cancel</a>
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