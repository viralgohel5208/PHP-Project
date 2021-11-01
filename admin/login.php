<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

if(isset($_SESSION["login"]) && $_SESSION["login"] == 'YES')
{
	header("Location:index.php");
	exit;
}

if(isset($_POST['submit']))
{
	//echo '<pre>'; print_r($_POST); echo '<pre>';
	$username 	= escapeInputValue($_POST['username']);
	$password 	= escapeInputValue($_POST['password']);

	if($username == "" || $password == "")
	{	
		$error = "Please enter username & password";
	}
	else
	{
		$q = "SELECT id, role_id, app_id, first_name, last_name, email, mobile, password FROM admin WHERE email = '$username' OR mobile = '$username'";
		
		$res_query = mysqli_query($link, $q);
		
		if(!$res_query)
		{
			$error = $sww;
		}
		else
		{
			if(mysqli_num_rows($res_query) == 0)
			{
				$error = "Incorrect username and Password";
			}
			else
			{
				$row = mysqli_fetch_array($res_query);
				
				if ($row["password"] != passwordEncyption($password, 'e'))
				{
					$error = "Please enter correct password";
				}
				else
				{
					$role_id = $row['role_id'];
					$app_id = $row['app_id'];
					

					/****** Fetch App Settings *****/
					if($role_id == 2)
					{
						$query_1 = "SELECT * FROM app_settings WHERE app_id = $app_id LIMIT 1";
						$result_1 = mysqli_query($link, $query_1);
						if(!$result_1)
						{
							$error = $sww;
						}
						else if (mysqli_num_rows($result_1) == 0)
						{
							$can_create_customer_backend = 0;
						}
						else
						{
							$row_1 = mysqli_fetch_assoc($result_1);
							//$can_create_customer_backend = $row_1['can_create_customer_backend'];
							//$premium_normal_customer = $row_1['premium_normal_customer'];
							
							$_SESSION["can_create_customer_backend"] = $row_1['can_create_customer_backend'];
							$_SESSION["premium_normal_customer"] = $row_1['premium_normal_customer'];
						}
					}
					
					if($error == "")
					{
						$_SESSION["user_id"]		= $row['id'];
						$_SESSION["role_id"]		= $role_id;
						$_SESSION["app_id"]			= $app_id;
						$_SESSION["first_name"] 	= $row['first_name'].' '.$row['last_name'];
						$_SESSION["email"] 			= $row['email'];
						$_SESSION["mobile"]			= $row['mobile'];
						$_SESSION["login"] 			= "YES";
												
						header("location:index.php"); 	// Redirecting To Other Page
						exit;
					}
				}
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login - <?php echo $application_name; ?></title>
	<meta name="keywords" content=""/>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="external-page external-alt sb-l-c sb-r-c">
	<div id="main" class="animated fadeIn">
		<section id="content_wrapper">
			<section id="content">
				<div class="admin-form theme-info mw500" id="login">
					<div class="row table-layout">
						<a href="login.php" title="Return to Dashboard">
							<img src="../assets/images/logo-black.png" title="<?php echo $application_name; ?>" alt="<?php echo $application_name; ?>" class="center-block img-responsive" style="max-width: 150px;">
						</a>
					</div>
					<div class="panel mt30 mb25">
						<form method="post" action="" id="contact">
							<div class="panel-body bg-light p25 pb15">
								<div class="section">
									<label for="username" class="field-label text-muted fs18 mb10">Username</label>
									<label for="username" class="field prepend-icon">
										<input type="text" name="username" id="username" class="gui-input" placeholder="Enter email or mobile number" value="">
										<label for="username" class="field-icon">
											<i class="fa fa-user"></i>
										</label>								
									</label>
								</div>

								<div class="section">
									<label for="username" class="field-label text-muted fs18 mb10">Password</label>
									<label for="password" class="field prepend-icon">
										<input type="password" name="password" id="password" class="gui-input" placeholder="Enter password" value="">
										<label for="password" class="field-icon">
											<i class="fa fa-lock"></i>
										</label>								
									</label>
								</div>
							</div>
							<div class="panel-footer clearfix">
								<button type="submit" name="submit" class="button btn-primary mr10 pull-right">Login</button>
								<?php /*?><label class="switch ib switch-primary mt10">
									<input type="checkbox" name="remember" id="remember" checked>
									<label for="remember" data-on="YES" data-off="NO"></label><span>Remember me</span>
								</label><?php */?>
								<?php if(isset($error) && $error != "") { echo '<div style="padding-left: 10px;" class="text-danger mn">'.$error.'</div>'; } ?>
							</div>
						</form>
					</div>

					<div class="login-links">
						<p>
							<a href="forgot-password.php" class="active" title="Sign In">Forgot Password?</a>
						</p>
						<p><?php echo $application_name; ?></p>
					</div>
				</div>
			</section>
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