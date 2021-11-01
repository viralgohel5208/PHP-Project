<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";

if(isset($_POST['save_settings']))
{
    $username      	= $_POST['username'];
    $email          = $_POST['email'];

    if($username != "" && $email != "")
    {
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$error = "'$email' is not a valid email address";
		} else {
			$query = "UPDATE admin SET username = '".$username."', email = '".$email."'";
			$result = mysqli_query($link, $query);

			if($result)
			{
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
				$success = "Admin details updated successfully";
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

if(isset($_POST['save_password']))
{
    $c_password = $_POST['c_password'];
    $n_password = $_POST['n_password'];
    $r_password = $_POST['r_password'];

    if($c_password == "" || $n_password == "" || $r_password == "")
	{
		$error = "Please enter all details";
	}
	else
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
            $result_check = mysqli_query($link, "SELECT id FROM admin WHERE username = '".$_SESSION['username']."' and password = '".md5($c_password)."'");

            if(!$result_check)
			{
				$error = $sww;
			}
			else
            {
                if(mysqli_num_rows($result_check) == 0)
				{
					$error = "Enter current password correctly";
				}
				else
                {
                    $result = mysqli_query($link, "UPDATE admin SET password = '".md5($n_password)."' WHERE username = '".$_SESSION['username']."'");

                    if(!$result)
					{
						$error = $sww;
					}
					else
                    {
                        $success = "Password updated successfully";
                    }
                }
            }
        }
    }
}

$result = mysqli_query($link, "SELECT * FROM admin WHERE id = 1");
if($result)
{
    $row = mysqli_fetch_assoc($result);
}
else
{
    echo $error_500 = 500;
	exit;
}

$page_title = "Admin";

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
						<a href="admin.php">Admin</a>
					</li>
					<li class="crumb-icon">
						<a href="index.php"><span class="fa fa-home"></span></a>
					</li>
					<li class="crumb-link">
						<a href="index.php">Home</a>
					</li>
					<li class="crumb-trail">Admin</li>
				</ol>
			</div>
		</header>

		<div id="content" class="animated fadeIn">
			<div class="row">
				<div class="col-md-12">
					
					<?php if($error != "" || $success != "") {
					if($error != "") { $class = 'danger'; } else if($success != "") { $class = 'success'; }
					?>
					<div class="alert alert-micro alert-border-left alert-<?php echo $class; ?> alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="fa fa-info pr10"></i>
						<strong><?php if(isset($_POST['save_settings'])) { echo 'Admin Details'; } else if(isset($_POST['save_password'])) { echo 'Admin Password'; } ?> :</strong> 
						<?php echo $error.$success; ?>
					</div>
					<?php } ?>

					<div class="panel <?php echo $panel_style; ?>">
						<div class="panel-heading">
							<span class="panel-title"><span class="glyphicon glyphicon-user"></span>Admin</span>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" role="form" method="post">
								<div class="form-group">
									<label class="col-lg-3 control-label">User Name</label>
									<div class="col-lg-8">
										<input type="text" class="form-control" name="username" value="<?php if(isset($_POST['username'])) { echo $_POST['username'];} else {echo $row['username']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Email</label>
									<div class="col-lg-8">
										<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email'];} else { echo $row['email']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-8">
										<button type="submit" name="save_settings" class="btn btn-success">Save</button>
										<a href="admin.php" class="btn btn-warning">Cancel</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					<div class="panel <?php echo $panel_style; ?>">
						<div class="panel-heading">
							<span class="panel-title"><span class="glyphicon glyphicon-lock"></span> Change Password</span>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" role="form" method="post" action="" autocomplete="off">
								<div class="form-group">
									<label class="col-lg-3 control-label">Current Password</label>
									<div class="col-lg-8">
										<input type="password" class="form-control" name="c_password" placeholder="Enter Current Password">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">New Password</label>
									<div class="col-lg-8">
										<input type="password" class="form-control" name="n_password" placeholder="Enter New Password">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Re-type Password</label>
									<div class="col-lg-8">
										<input type="password" class="form-control" name="r_password" placeholder="Re-type Your New Password">
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-8">
										<button type="submit" name="save_password" class="btn btn-success">Save</button>
										<a href="admin.php" class="btn btn-warning">Cancel</a>
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