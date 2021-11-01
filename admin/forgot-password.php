<?php 

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$cur_date = currentTime();

if(isset($_SESSION["login"]) && $_SESSION["login"] == 'YES')
{
	header("Location:index.php");
	exit;
}

if(isset($_GET['verif']) && $_GET['verif'] == 1 && isset($_GET['email']) && isset($_GET['code']) )
{
	$email 		= escapeInputValue($_GET['email']);
	$code 		= escapeInputValue($_GET['code']);

	$result = mysqli_query($link, "SELECT id, otp_code, otp_expiry_time FROM admin WHERE email = '".$email."' AND otp_code = '".$code."'");
	
	if(mysqli_num_rows($result) > 0)
	{
		$row_user = mysqli_fetch_assoc($result);
		
		$otp_code 			= $row_user['otp_code'];
		$otp_expiry_time 	= $row_user['otp_expiry_time'];
		
		if($otp_code == "" || $otp_code == NULL || $otp_expiry_time == NULL || $otp_expiry_time == "" || $otp_expiry_time < $current_datetime)
		{
			$error = "Verification link is expired";
		}
		else
		{
			$change_pass = 1;
		}
	}
	else
	{
		$error = "Invalid verification link";
	}
}

if(isset($_POST['submit']) && $error == "")
{
	
	$n_password = $_POST['n_password'];
	$r_password = $_POST['r_password'];

	if($n_password == "" || $r_password == "")
	{
		$error = "Please enter password";
	}
	else if(strlen($n_password) < 5)
	{
		$error = "Password must be 5 character long";
	}
	else if($n_password != $r_password)
	{
		$error = "Enter new password correctly two times";
	}
	else
	{
		$e_password = passwordEncyption($n_password, 'e');
		$result = mysqli_query($link, "UPDATE admin SET password = '".$e_password."', `otp_code` = NULL, `otp_expiry_time` = NULL WHERE email = '".$email."'");
	
		if($result)
		{
			$success = "Password has been changed successfully";
		}
		else
		{
			$error = $sww;
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Forgot Password - <?php echo $application_name; ?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body class="external-page external-alt sb-l-c sb-r-c">
	<div id="main" class="animated fadeIn">
		<section id="content_wrapper">
			<div id="canvas-wrapper">
				<canvas id="demo-canvas"></canvas>
			</div>

			<section id="content" class="animated fadeIn">

				<div class="admin-form theme-info mw500" style="margin-top: 6%;" id="login">
					<div class="row mb15 table-layout">
						<div class="col-xs-6 pln">
							<a href="login.php" title="Return to Dashboard" style="text-decoration: none; color: #606e7d; font-weight: bold; font-size: 30px;">
								<?php //echo $application_name; ?>
								<img src="../assets/images/logo-black.png" title="<?php echo $application_name; ?>" alt="<?php echo $application_name; ?>" class="img-responsive" style="max-width: 120px;">
							</a>
						</div>
						<div class="col-xs-6 va-b">
							<div class="login-links text-right">
								<a href="#" class="" title="Rest Password">Password Reset</a>
							</div>
						</div>
					</div>

					<?php if(!isset($change_pass)) { ?>

					<div class="panel">

						<form method="post" action="" id="contact" onSubmit="return false;">
							<div class="panel-body p15" id="fp-msg">
								<?php if($error == "") { ?>
									<div class="alert alert-micro alert-border-left alert-info pastel alert-dismissable mn">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
										<i class="fa fa-info pr10"></i> Enter your
										<b>Email</b> and instructions will be sent to you!
									</div>
									<?php } else { ?>
									<div class="alert alert-micro alert-border-left alert-danger pastel alert-dismissable mn">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
										<i class="fa fa-info pr10"></i> <?php echo $error; ?>
									</div>
								<?php } ?>
							</div>

							<div class="panel-footer p25 pv15">
								<div class="section mn">
									<div class="smart-widget sm-right smr-80">
										<label for="email" class="field prepend-icon">
											<input type="text" name="email" id="email" class="gui-input" placeholder="Your Email Address">
											<label for="email" class="field-icon">
											<i class="fa fa-envelope-o"></i>
											</label>
										</label>
										<label for="email" class="button" onClick="forgot_pass()">Reset</label>
									</div>
								</div>
							</div>
						</form>
					</div>

					<?php } else { ?>

					<?php if($error == "" && $success == "") { ?>
						<div class="alert alert-micro alert-border-left alert-info pastel alert-dismissable mn">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-info pr10"></i> Please type your new password!
						</div>
					<?php } else if($error != "") { ?>
						<div class="alert alert-micro alert-border-left alert-danger pastel alert-dismissable mn">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-info pr10"></i> <?php echo $error; ?>
						</div>
					<?php } else if($success != "") { ?>
						<div class="alert alert-micro alert-border-left alert-success pastel alert-dismissable mn">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-info pr10"></i> <?php echo $success; ?>
						</div>
					<?php } ?>

					<div class="panel">
						<form method="post" action="" >
							<div class="panel-body bg-light p25 pb15">
								<div class="section">
									<label for="n_password" class="field-label text-muted fs18 mb10">New Password</label>
									<label for="n_password" class="field prepend-icon">
										<input type="password" name="n_password" id="n_password" class="gui-input" placeholder="Enter new password">
										<label for="n_password" class="field-icon">
											<i class="fa fa-lock"></i>
										</label>
									</label>
								</div>
								<div class="section">
									<label for="r_password" class="field-label text-muted fs18 mb10">Re-type Password</label>
									<label for="r_password" class="field prepend-icon">
										<input type="password" name="r_password" id="r_password" class="gui-input" placeholder="Enter password">
										<label for="r_password" class="field-icon">
											<i class="fa fa-lock"></i>
										</label>
									</label>
								</div>
							</div>
							<div class="panel-footer clearfix">
								<button type="submit" name="submit" class="button btn-primary mr10 pull-right">Reset Password</button>
							</div>
						</form>
					</div>
					<?php } ?>
					
					<div class="login-links">
						<p><a href="login.php" class="active" title="Sign In">Back to Login</a></p>
						<p><?php echo $application_name; ?></p>
					</div>
				</div>
			</section>
		</section>
	</div>
	
	<script src="vendor/jquery/jquery-1.11.1.min.js"></script>
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
    function forgot_pass()
	{
		var e = $("#email").val();
		if(e == "")
		{
			return $("#fp-msg").html('<div class="alert alert-micro alert-border-left alert-danger pastel alert-dismissable mn"> \
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> \
                  <i class="fa fa-info pr10"></i> Please enter email address \
                </div>');
		}
		$.ajax({
			url: 'ajax-forgot-pass.php',
			data: 'e='+e,
			type: 'POST',
			success: function(d){
				if(d == "1")
				{
					$("#fp-msg").html('<div class="alert alert-micro alert-border-left alert-success pastel alert-dismissable mn"> \
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> \
					  <i class="fa fa-info pr10"></i> Email has been sent to this email \
					</div>');
				}
				else
				{
					$("#fp-msg").html('<div class="alert alert-micro alert-border-left alert-danger pastel alert-dismissable mn"> \
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> \
					  <i class="fa fa-info pr10"></i> '+d+' \
					</div>');
				}
			},
			error: function(){
				$("#fp-msg").html('<div class="alert alert-micro alert-border-left alert-danger pastel alert-dismissable mn"> \
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> \
					  <i class="fa fa-info pr10"></i> Something went wrong, Please try later \
					</div>');
			}	
		});
    }
   </script>
</body>
</html>
