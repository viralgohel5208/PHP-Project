<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

if(isset($_POST['submit']))
{
	//echo '<pre>'; print_r($_POST); exit;
	$language 			= escapeInputValue($_POST['language']);
	if($language == 0) {
		$msg_head 			= escapeInputValue($_POST['msg_head']);
		$msg_body 			= escapeInputValue($_POST['msg_body']);
	} else {
		$msg_head 			= escapeInputValue($_POST['msg_head_ar']);
		$msg_body 			= escapeInputValue($_POST['msg_body_ar']);
	}
	$notification_date  = escapeInputValue($_POST['notification_date']);
	
	$current_datetime 	= currentTime();
	
	if($msg_head == "")
	{
		$error = "Please enter notification title";
	}
	
	if($error == "")
	{
		if(isset($_POST['future_date']))
		{
			$notification_flag = 0;
			if($notification_date == "")
			{
				$error = "Please select notification date";
			}
			else
			{
				$exp_notification_date = explode(" ", $notification_date);
				$exp_notification_date_2 = explode("-", $exp_notification_date[0]);
				$notification_date = $exp_notification_date_2[2]."-".$exp_notification_date_2[1]."-".$exp_notification_date_2[0]." ".$exp_notification_date[1];
			}
		}
		else
		{
			$notification_flag 	= 1;
			$notification_date 	= date("Y-m-d H:i:s");
		}
	}
	
	/*if($error == "")
	{
		$query_1 = "SELECT id FROM notifications WHERE msg_head = '$msg_head'";
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = $sww;
		}
		else if (mysqli_num_rows($result_1) > 0)
		{
			$error = "Notificaiton title already exists";
		}
	}*/
	
	if($error == "")
	{
		$query_2 = "INSERT INTO `notifications`(`language`, `msg_head`, `msg_body`, `notification_date`, `notification_flag`, `created_at`, `updated_at`) VALUES ('$language', '$msg_head', '$msg_body', '$notification_date', '$notification_flag', '$current_datetime', '$current_datetime')";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = $sww;
		}
		else
		{
			$item_id = mysqli_insert_id($link);
			if($notification_flag == 1)
			{
				require_once "functions-notification.php";
				sendNotifications($item_id, $msg_head, $msg_body, $language);
			}
			$success = "Notification has been created";
			unset($_POST);
		}
	}
}

$page_title = "Send Notification";

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
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
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
							<a href="index.php"><span class="fa fa-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-link">
							<a href="notifications.php">Notifications History</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="notifications.php" class="pl5 btn btn-default btn-sm">
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
								<form class="form-horizontal" role="form" method="post">
									
									<div class="form-group">
										<label class="col-sm-3 control-label">Language</label>
										<div class="col-sm-7">
											<select name="language" class="form-control" onChange="selectedLang(this.value)">
												<option value="0" <?php if(isset($_POST['language']) && $_POST['language'] == 0 ) { echo 'selected="selected"'; } ?>>English</option>
												<option value="1" <?php if(isset($_POST['language']) && $_POST['language'] == 1 ) { echo 'selected="selected"'; } ?>>Arabic</option>
											</select>
										</div>
									</div>
									<div id="content_en">
										<div class="form-group">
											<label class="col-lg-3 control-label">Title</label>
											<div class="col-lg-7">
												<input type="text" class="form-control" name="msg_head" value="<?php if(isset($_POST['msg_head'])) { echo $_POST['msg_head']; } ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 control-label">Body</label>
											<div class="col-lg-7">
												<textarea class="form-control" name="msg_body" rows="5"><?php if(isset($_POST['msg_body'])) { echo $_POST['msg_body']; } ?></textarea>
											</div>
										</div>
									</div>
									<div id="content_ar" style="display: none">
										<div class="form-group">
											<label class="col-lg-3 control-label">Title</label>
											<div class="col-lg-7">
												<input type="text" class="form-control" name="msg_head_ar" value="<?php if(isset($_POST['msg_head_ar'])) { echo $_POST['msg_head_ar'];} ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 control-label">Body</label>
											<div class="col-lg-7">
												<textarea class="form-control" name="msg_body_ar" rows="5" ><?php if(isset($_POST['msg_body_ar'])) { echo $_POST['msg_body_ar'];} ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group mb25">
										<label class="col-md-3 control-label"></label>
										<div class="col-md-9">
											<label class="checkbox-inline mr10">
											<input type="checkbox" id="future_date" name="future_date" value="1" onChange="future_date_fu()" <?php if(isset($_POST['future_date'])) { echo 'checked="checked"'; } ?>>Future Date ?</label>
										</div>
									</div>
									<div class="form-group" id="future_date_div" <?php if(!isset($_POST['future_date'])) { echo 'style="display: none"'; } ?>>
										<label for="inputStandard" class="col-lg-3 control-label"> Date*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control datepicker1" name="notification_date" id="datetimepicker1">
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="notifications.php" class="btn btn-warning">Cancel</a>
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
	
	<script src="vendor/plugins/moment/moment.min.js"></script>
	<script src="vendor/plugins/datepicker/js/bootstrap-datetimepicker.js"></script>
	
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
		
		$('#datetimepicker1').datetimepicker({
			pickTime: true,
			minDate: '<?php echo date("d-m-Y H:i:s"); ?>',
			format: 'DD-MM-YYYY H:m:00',
			stepping: 5,
			<?php if(isset($_POST['future_date'])) { echo "defaultDate: '".$_POST['notification_date']."',"; }?>
		});
		
		function future_date_fu()
		{
			if(document.getElementById("future_date").checked)
			{
				document.getElementById("future_date_div").style.display = "block";
			}
			else
			{
				document.getElementById("future_date_div").style.display = "none";
			}
		}
		
		function selectedLang(x)
		{
			if(x == 0)
			{
				$("#content_en").css('display', 'block');
				$("#content_ar").css('display', 'none');
			}
			else if(x == 1)
			{
				$("#content_en").css('display', 'none');
				$("#content_ar").css('display', 'block');
			}
		}
		
		<?php if(isset($_POST['language']) && $_POST['language'] == 1) { ?>
		selectedLang(1);
		<?php } ?>
		
	</script>
</body>
</html>