<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
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
	
	if(isset($_REQUEST['customer_type'])) {
		$customer_type		= $_REQUEST['customer_type'];
	} else {
		$customer_type		= 0;		
	}
	
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
		$query_1 = "SELECT id, email, mobile FROM customers WHERE (email = '$email' OR mobile = '$mobile') AND id != $item_id";
		
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
		$query_2 = "UPDATE `customers` SET `customer_type` = '$customer_type', `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$email', `mobile` = '$mobile', `updated_at` = '$current_datetime', `status` = '$status' WHERE id = $item_id";

		$result_2 = mysqli_query( $link, $query_2 );

		if(!$result_2)
		{
			$error = "1".$sww;
		}
	}
	
	if($error == "")
	{
		mysqli_autocommit($link, TRUE);
		$success = "User details has been updated successfully";
		unset($_POST);
	}
}

if(isset($_POST['save_password']))
{
    $n_password = $_POST['n_password'];
    $r_password = $_POST['r_password'];

    if($n_password == "" || $r_password == "")
	{
		$error = "Please enter all details";
	}
	else if(strlen($n_password) < 6)
	{
		$error = "Password must be minimum 6 character long";
	}
	else if($n_password != $r_password)
	{
		$error = "Password does not match";
	}
	else
	{
		$passwordEncyption = passwordEncyption($n_password, 'e');
		$query_4 =  "UPDATE customers SET password = '".$passwordEncyption."' WHERE id = '".$item_id."'";
		$result = mysqli_query($link, $query_4);

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

if(isset($_POST['del-id']))
{
    $id = $_POST['del-id'];
	
	if($id == "all")
	{
		$result = "DELETE FROM customers_address WHERE customer_id = '".$item_id."'";		
	}
	else
	{
		$result = "DELETE FROM customers_address WHERE id = '".$id."'";
	}
	if(mysqli_query($link, $result))
	{
		$_SESSION['msg_success'] = "User Addresses been deleted successfully";
	} 
	else
	{
		$_SESSION['msg_error'] = $sww;
	}
	header("location:users-update.php?id=".$item_id);
	exit;
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT * FROM `customers` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			$_SESSION['msg_error'] = "User does't found";
			header( "Location:users.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:users.php" );
		exit;
	}
}
else
{
	header( "Location:users.php" );
	exit;
}

$page_title = "Update User Details";

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
							<a href="users.php">Users</a>
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
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title"><span class="fa fa-pencil"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" id="demoform" method="post">
									<div class="form-group">
										<label class="col-lg-3 control-label">First name</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name'];} else { echo $row_3['first_name']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Last name</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name'];} else { echo $row_3['last_name']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Email*</label>
										<div class="col-lg-7">
											<input type="text"class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } else { echo $row_3['email']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Mobile*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile" value="<?php if(isset($_POST['mobile'])) { echo $_POST['mobile'];} else { echo $row_3['mobile']; } ?>">
										</div>
									</div>
									<?php if($_SESSION['premium_normal_customer'] == 1) { ?>
									<div class="form-group">
										<label class="col-sm-3 control-label">Customer Type</label>
										<div class="col-sm-7">
											<select name="customer_type" class="form-control">
												<option value="0" <?php if(isset($_POST['customer_type']) && $_POST['customer_type'] == 0 ) { echo 'selected="selected"'; } else if($row_3['customer_type'] == 0) { echo 'selected="selected"'; } ?>>Normal User</option>
												<option value="1" <?php if(isset($_POST['customer_type']) && $_POST['customer_type'] == 1 ) { echo 'selected="selected"'; } else if($row_3['customer_type'] == 1) { echo 'selected="selected"'; } ?>>Premium User</option>
											</select>
										</div>
									</div>
									<?php } ?>
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
										<label class="col-sm-3 control-label">OTP Code</label>
										<div class="col-sm-7">
											<p class="form-control-static text-muted"><?php echo $row_3['otp_code']; ?></p>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="users.php" class="btn btn-warning">Cancel</a>
											<a onclick="delete_func('<?php echo $item_id; ?>')" class="btn btn-danger">Delete</a>
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
											<a href="" class="btn btn-warning">Cancel</a>
										</div>
									</div>                                    
								</form>
							</div>
						</div>
					</div>
				
					<div class="col-md-12">
						
						<?php /*?><div class="tray tray-center va-t posr">
							<div class="panel panel-border top panel-alert">
								<div class="panel-heading">
									<span class="panel-title">
										<span class="glyphicons glyphicons-paperclip"></span> User Liked Scratches
									</span>
									<div class="widget-menu pull-right">
										<a href="user-scratch-like.php?id=<?php echo $user_id; ?>" title="User Liked Scratches">
											<span class="glyphicons glyphicons-check"></span> View
										</a>
									</div>
								</div>
							</div>
						</div>

						<div class="tray tray-center va-t posr">
							<div class="panel panel-border top panel-danger">
								<div class="panel-heading">
									<span class="panel-title">
										<span class="glyphicons glyphicons-iphone"></span> Registered Devices
									</span>
									<div class="widget-menu pull-right">
										<a href="user-devices.php?id=<?php echo $user_id; ?>" title="User Devices">
											<span class="glyphicons glyphicons-check"></span> View
										</a>
									</div>
								</div>
							</div>
						</div><?php */?>

						<?php $result = mysqli_query($link, "SELECT * FROM customers_address where customer_id = '".$item_id."'"); ?>
						<div class="tray tray-center va-t posr">
							<div class="panel panel-border top">
								<div class="panel-heading">
									<span class="panel-title">
										<span class="glyphicons glyphicons-table"></span>User Addresses Details
									</span>
									<?php if(mysqli_num_rows($result) > 0){ ?>
									<div class="widget-menu pull-right">
										<a onClick="del_user_add('all')" title="Delete all address" style="cursor: pointer">
											<span class="fa fa-trash-o"></span> Delete All
										</a>
									</div>
									<?php } ?>
								</div>
								<?php if(mysqli_num_rows($result) == 0){ ?>
								<div class="panel-body">
										<h4>No addresses found.</h4>
								</div>
								<?php } ?>
							</div>

							<?php

							if(mysqli_num_rows($result) > 0)
							{
								$i = 1;
								$j = 1;
								echo '<div class="row" id="spy1">';
								while($row = mysqli_fetch_array($result))
								{
							?>
							<div class="col-sm-4">
								<div class="panel">
									<div class="panel-body pn">
										<table class="table">
											<thead>
												<tr class="<?php echo $color_style_array[$i]; ?>">
													<th colspan="2">
														<?php if($row['address_name'] != "") { echo $row['address_name']; } else { echo 'No Name'; } ?>
														<div class="widget-menu pull-right">
															<a onClick="del_user_add('<?php echo $row['id']; ?>')" title="Delete Address" style="cursor: pointer">
																<span class="fa fa-trash-o"></span> Delete
															</a>
														</div>
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>First Name</td>
													<td><?php echo $row['first_name']; ?></td>
												</tr>
												<tr>
													<td>Last Name</td>
													<td><?php echo $row['last_name']; ?></td>
												</tr>
												<tr>
													<td>Email</td>
													<td><?php echo $row['email']; ?></td>
												</tr>
												<tr>
													<td>Mobile</td>
													<td><?php echo $row['mobile']; ?></td>
												</tr>
												<tr>
													<td>Address</td>
													<td><span class="wrapping-text"><?php echo $row['address']; ?></span></td>
												</tr>
												<tr>
													<td>City</td>
													<td><?php echo $row['city_name']; ?></td>
												</tr>
												<tr>
													<td>State</td>
													<td><?php echo $row['state_name']; ?></td>
												</tr>
												<tr>
													<td>Country</td>
													<td><?php echo $row['country_name']; ?></td>
												</tr>
												<tr>
													<td>Landmark</td>
													<td><?php echo $row['landmark']; ?></td>
												</tr>
												<tr>
													<td>Pincode</td>
													<td><?php echo $row['pincode']; ?></td>
												</tr>
												<tr>
													<td style="width: 130px;">Added Date</td>
													<td><?php echo formatDate($row['created_at']); ?></td>
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