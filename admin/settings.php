<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Settings";

if(isset($_POST['save']))
{
	//echo '<pre>'; print_r($_POST); exit;
	$item_id 		= $app_id;
	
	$sms_username 		= escapeInputValue($_REQUEST['sms_username']);
	$sms_password 		= escapeInputValue($_REQUEST['sms_password']);
	
	if($sms_username =="" || $sms_password == "")
	{
		$error = "Please enter mandatory(*) fields";
	}
	
	if($error == "")
	{
		$up_query = "UPDATE `admin_settings` SET `sms_username` = '".$sms_username."', `sms_password` = '".$sms_password."', `updated_at` = '".$current_datetime."' WHERE id = 1";

		$result5 = mysqli_query($link, $up_query);
		if($result5)
		{
			$_SESSION['msg_success'] = "Settings has been updated successfully";
			header("location:settings.php");
			exit;
		}
		else
		{
			$error = $sww;
		}
	}
}

$query = "SELECT sms_username, sms_password FROM admin_settings WHERE id = 1";
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
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <style>
		div#content { padding: 20px 20px 0 20px; }
	</style>
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
            
			<div id="content">
				<div class="row">
					<div class="col-md-12">
						
						<?php require_once "message-block.php"; ?>
						
						<?php if($role_id != 1 && $app_id != "") { ?>
						<div class="panel panel-visible panel-dark">
							<div class="panel-heading panel-visible">
								<span class="panel-title">
									<span class="fa fa-ban"s></span>Application Maintenance
								</span>
							</div>
							<table class="table table-striped"  cellspacing="0" width="100%" >
								<thead>
								   <tr>
										<th style="width:100px !important">Sr No.</th>
										<th>Type</th>
										<th>Updated At</th>
										<th style="width: 200px;">In Maintenance ?</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									
									$maintenance = checkMaintenance($app_id);
									
									$i = 1;	
									foreach($maintenance as $key => $value)
									{
										if($i == 1) { } else {
									?>
									<tr>
										<td style="text-align: center"><?php echo $i; ?></td>
										<td><?php echo $key; ?></td>
										<td id="update_at_<?php echo $i; ?>"><?php echo $value[1]; ?></td>
										<td>
											<div class="col-lg-7 admin-form">
												<label class="switch block switch-info mn mt5" >
													<input type="checkbox" name="status" id="t1_<?php echo $i; ?>" value="<?php echo $value[0]; ?>" onClick="disable_website(<?php echo $i; ?>)" 
													<?php if( $value[0] == 1){echo 'checked="checked"'; } ?> >
													<label for="t1_<?php echo $i; ?>" data-on="YES" data-off="NO" ></label>
												</label>
											</div>
										</td>
									</tr>
									<?php } $i++; } ?>
								</tbody>
							</table>
						</div>
						
						<?php  } else if($role_id == 1) { ?>
						
						<div class="panel panel-dark">
                            <div class="panel-heading">
                                <span class="panel-title"><span class="fa fa-cog"></span> <?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post" action="">
									<div class="form-group">
										<label class="col-lg-3 control-label">SMS Pack Username*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="sms_username" value="<?php if(isset($_POST['sms_username'])) { echo $_POST['sms_username']; } else { echo $row_3['sms_username']; } ?>" placeholder="Enter sms pack username">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">SMS Pack Password*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="sms_password" value="<?php if(isset($_POST['sms_password'])) { echo $_POST['sms_password']; } else { echo $row_3['sms_password']; } ?>" placeholder="Enter sms pack password">
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
						<?php  } ?>
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
	<script src="assets/js/custom.js"></script>
    
    <script type="text/javascript">
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core     
            Core.init();
            // Init Demo JS
            Demo.init();
        });
		function disable_website(type)
		{
			var z = 2;
			if($("#t1_"+type).prop('checked') == true)
			{
				z =1;
			}
			else
			{
				z =0;
			}
			if(z != 2)
			{
				$.ajax({
					type: "POST",
					url: "ajax-general.php",
					data:'type=8&disable_type='+type+'&value='+z,
					success: function(data){
						$("#update_at_"+type).html(data);
					},
					error: function(){
						alert("Something Went Wrong!");
					}
				});
			}
		}
    </script>
</body>
</html>