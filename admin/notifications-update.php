<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

if(isset($_POST['submit']))
{
	$item_id 			= escapeInputValue($_GET['id']);
	$msg_head 			= escapeInputValue($_POST['msg_head']);
	$msg_head_ar 		= escapeInputValue($_POST['msg_head_ar']);
	$msg_body 			= escapeInputValue($_POST['msg_body']);
	$msg_body_ar		= escapeInputValue($_POST['msg_body_ar']);
	$notification_date  = escapeInputValue($_POST['notification_date']);
	
	$current_datetime 	= currentTime();
	
	if($msg_head == "" || $msg_head_ar == "")
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
		$query_1 = "SELECT id FROM notifications WHERE msg_head = '$msg_head' AND id != $item_id";
		$result_1 = mysqli_query($link, $query_1);		
		if (mysqli_num_rows($result_1) > 0) {
			$error = "Notification title already exists";
		}
	}*/
	
	if($error == "")
	{
		$query_2 = "UPDATE `notifications` SET `msg_head` = '$msg_head', `msg_head_ar` = '$msg_head_ar', `msg_body` = '$msg_body', `msg_body_ar` = '$msg_body_ar', `notification_date` = '$notification_date', `notification_flag` = '$notification_flag', `updated_at` = '$current_datetime' WHERE id = $item_id";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = $sww;
		}
		else
		{
			
			if($notification_flag == 1)
			{
				require_once "functions-notification.php";
				sendNotifications($msg_head, $msg_body);
			}
			$success = "Notification details has been updated.";
			unset($_POST);
		}
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT * FROM `notifications` WHERE id = '" . $item_id . "' AND notification_flag = 0" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
			$notification_date = $row_3['notification_date'];
			$ex_nd = explode(" ", $notification_date);
			$ex_nd_2 = explode("-", $ex_nd[0]);
			$row_3['notification_date'] = $ex_nd_2[2]."-".$ex_nd_2[1]."-".$ex_nd_2[0]." ".$ex_nd[1];
		}
		else
		{
			$_SESSION['msg_error'] = "Notification does't found";
			header( "Location:notifications.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:notifications.php" );
		exit;
	}
}
else
{
	header( "Location:notifications.php" );
	exit;
}

$page_title = "Update Notification";

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
								<span class="panel-title"><span class="fa fa-pencil"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post">
									<div class="form-group">
										<label class="col-lg-3 control-label">Title</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="msg_head" value="<?php if(isset($_POST['msg_head'])) { echo $_POST['msg_head']; } else { echo $row_3['msg_head']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Title</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="msg_head_ar" value="<?php if(isset($_POST['msg_head_ar'])) { echo $_POST['msg_head_ar']; } else { echo $row_3['msg_head_ar']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Description</label>
										<div class="col-lg-7">
											<textarea class="form-control" name="msg_body" rows="5"><?php if(isset($_POST['msg_body'])) { echo $_POST['msg_body']; } else { echo $row_3['msg_body']; } ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Description</label>
										<div class="col-lg-7">
											<textarea class="form-control" name="msg_body_ar" rows="5" ><?php if(isset($_POST['msg_body_ar'])) { echo $_POST['msg_body_ar']; } else { echo $row_3['msg_body_ar']; } ?></textarea>
										</div>
									</div>
									<div class="form-group mb25">
										<label class="col-md-3 control-label"></label>
										<div class="col-md-9">
											<label class="checkbox-inline mr10">
											<input type="checkbox" id="future_date" name="future_date" value="1" onChange="future_date_fu()" <?php if(!empty($_POST)) { if(isset($_POST['future_date'])) { echo 'checked="checked"'; } } else if ($row_3['notification_flag'] == 0) { echo 'checked="checked"'; } ?>>Future Date ?</label>
										</div>
									</div>
									<div class="form-group" id="future_date_div" <?php if(!empty($_POST)) { if(!isset($_POST['future_date'])) { echo 'style="display: none"'; } } else if($row_3['notification_flag'] == 1) { echo 'style="display: none"'; } ?>>
										<label for="inputStandard" class="col-lg-3 control-label"> Date*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control datepicker1" name="notification_date" id="datetimepicker1" value="<?php if(isset($_POST['notification_date'])) { echo $_POST['notification_date']; } else { echo $row_3['notification_date']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="notifications.php" class="btn btn-warning">Cancel</a>
											<a onclick="delete_func('<?php echo $item_id; ?>')" class="btn btn-danger">Delete</a>
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
	
	<form id="delete_form" action="notifications.php" method="post" style="display: hidden">
		<input type="hidden" id="delete_id" name="delete_id" value="">
	</form>

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	
	<script src="vendor/plugins/moment/moment.min.js"></script>
	<script src="vendor/plugins/datepicker/js/bootstrap-datetimepicker.js"></script>

	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/custom.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function () {
			"use strict";
			// Init Theme Core
			Core.init();
			// Init Demo JS
			Demo.init();
		});
		
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
	</script>
</body>
</html>