<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$user_id = $_SESSION['user_id'];
$item_id = escapeInputValue($_GET['id']);
	
if(isset($_POST['submit']))
{
	$first_name 		= escapeInputValue($_POST['first_name']);
	$last_name 			= escapeInputValue($_POST['last_name']);
	$email 				= escapeInputValue($_POST['email']);
	$mobile 			= escapeInputValue($_POST['mobile']);
	$status 			= escapeInputValue($_REQUEST['status']);
	
	mysqli_autocommit($link, FALSE);

	if($first_name == ""  || $last_name == "" || $email == "" || $mobile == "")
	{
		$error = "Please enter all details";
	}
	else if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email))
	{
		$error = "Please enter valid email address";
	}
	else
	{
		
	}
	
	if($error == "")
	{
		$query_1 = "SELECT id, email, mobile FROM admin WHERE (email = '$email' OR mobile = '$mobile') AND id != $item_id";
		
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
				$error = "User email already exists";
			}
			else
			{
				$error = "User mobile number already exists";
			}
		}
	}
	
	if($error == "")
	{
		$query_2 = "UPDATE `admin` SET `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$email', `mobile` = '$mobile', `updated_by` = '$user_id', `updated_at` = '$current_datetime', `status` = '$status' WHERE id = $item_id";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = $sww;
		}
	}
	
	if($error == "")
	{
		mysqli_autocommit($link, TRUE);
		$success = "User details has been updated successfully";
		unset($_POST);
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT app_id FROM `admin` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
			$app_id = $row_3['app_id'];
			
			$subscriptionsHistory = getSubscriptionsHistory($app_id);

			//echo '<pre>'; print_r($subscriptionsHistory); exit;			
		}
		else
		{
			$_SESSION['msg_error'] = "User does't found";
			header( "Location:index.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:index.php" );
		exit;
	}
}
else
{
	header( "Location:index.php" );
	exit;
}

$page_title = "Subscription History";
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
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
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
							<a href="client-subscriptions.php">Client subscriptions</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="users.php" class="pl5 btn btn-default btn-sm">
							<i class="glyphicon glyphicon-backward"></i> Go Back
						</a>
					</div>
				</div>				
			</header>

			<div id="content" class="animated fadeIn">
				<div class="row">
					<div class="col-md-12">
						<?php require_once "message-block.php"; ?>

						<div class="tray tray-center va-t posr">
							<div class="panel panel-border top">
								<div class="panel-heading">
									<span class="panel-title">
										<span class="glyphicon glyphicon-backward"></span> <?php echo $page_title; ?>
									</span>
								</div>
								<?php if(empty($subscriptionsHistory)){ ?>
								<div class="panel-body">
									<h4>No history to display.</h4>
								</div>
								<?php } ?>
							</div>

							<?php

							if(!empty($subscriptionsHistory))
							{
								$i = 1;
								$j = 1;
								echo '<div class="row" id="spy1">';
								//while($row = mysqli_fetch_array($result))
								foreach($subscriptionsHistory as $row)
								{
							?>
							<div class="col-md-4">
								<div class="panel">
									<div class="panel-body pn">
										<table class="table">
											<thead>
												<tr class="<?php echo $color_style_array[$i]; ?>">
													<th colspan="2">
														<?php echo $i.'. '.formatDate($row['created_at']); ?>
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td style="width: 200px;">Package</td>
													<td><?php echo $row['package_name']; ?></td>
												</tr>
												<tr>
													<td>Client Name</td>
													<td><?php echo $row['client_name']; ?></td>
												</tr>
												<tr>
													<td>Sales executive</td>
													<td><?php echo $row['sales_exec']; ?></td>
												</tr>
												<tr>
													<td>Package price (raw)</td>
													<td>₹ <?php echo $row['package_price_raw']; ?></td>
												</tr>
												<tr>
													<td>GST price</td>
													<td>₹ <?php echo $row['package_price_gst']; ?></td>
												</tr>
												<tr>
													<td>Package finle price</td>
													<td>₹ <?php echo $row['package_price']; ?></td>
												</tr>
												<tr>
													<td>Starting date</td>
													<td><?php echo $row['starting_date']; ?></td>
												</tr>
												<tr>
													<td>Expiry date</td>
													<td><?php echo $row['expiry_date']; ?></td>
												</tr>
												<tr>
													<td>Status</td>
													<td><?php echo getSubscriptionStatus($row['status']); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php
								$i++;
								$j++;
								if($i >= count($color_style_array))
								{
									$i = 0;
								}

								}
								echo '</div>';
							}
							?>

						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<form id="delete_form" action="users.php" method="post" style="display: hidden">
		<input type="hidden" id="delete_id" name="delete_id" value="">
	</form>
	
	<form id="d_user_add" action="" method="post" style="display: hidden">
		<input type="hidden" id="del-id" name="del-id" value="">            
	</form>   

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	
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
		} );
		
		function del_user_add(x)
		{
			if(confirm("Are You sure you want to delete address ?"))
			{
				$("#del-id").val(x);
				$("#d_user_add").submit();
			}        
		}

	</script>
</body>
</html>