<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Store Update";

if(isset($_POST['save']))
{
	$item_id 		= escapeInputValue($_GET[ 'id' ]);
	
	$city_id 		= escapeInputValue($_REQUEST['city_id']);
	$store_name 	= escapeInputValue($_REQUEST['store_name']);
    $address   		= escapeInputValue($_REQUEST['address']);
    $email   		= escapeInputValue($_REQUEST['email']);
    $mobile_1  		= escapeInputValue($_REQUEST['mobile_1']);
    $mobile_2  		= escapeInputValue($_REQUEST['mobile_2']);
	$status 		= escapeInputValue($_REQUEST['status']);
	
	$delivery_charges = 0;
	
	if($city_id == "" || $store_name =="" || $address == "")
	{
		$error = "Please enter all details";
	}
	else
	{
		$up_query = "UPDATE stores SET city_id = '$city_id', store_name = '$store_name', address = '$address', email = '$email', mobile_1 = '$mobile_1', mobile_2 = '$mobile_2', status = $status WHERE id = '$item_id'";

		$result5 = mysqli_query($link, $up_query);
		if($result5)
		{
			$_SESSION['msg_success'] = "Store details has been updated";
			header("location:stores-update.php?id=$item_id");
			exit;				
		}
		else
		{
			$error = $sww;
		}
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT * FROM `stores` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			$_SESSION['msg_error'] = "Store does't found";
			header( "Location:stores.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:stores.php" );
		exit;
	}
}
else
{
	header( "Location:stores.php" );
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
		
        <!-- Start: Content -->
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
							<a href="stores.php">Stores</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="stores.php" class="pl5 btn btn-default btn-sm">
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
									<?php 
									$result1 = mysqli_query($link,"select * from cities ORDER BY city_name");
									if($result1)
									{ 
									?>
									<div class="form-group">
                                        <label for="inputStandard" class="col-lg-3 control-label">City</label>
                                        <div class="col-lg-7">
											<select name="city_id" class="form-control">
												<?php while($row1 = mysqli_fetch_assoc($result1)) {
												   	echo '<option value="'.$row1['id'].'"';
													if(isset($_POST['city_id']))
													{
														if($_POST['city_id'] == $row1['id'])
														{
															echo ' selected="selected"';
														}
													}
													else
													{
														if($row_3['city_id'] == $row1['id'])
														{
															echo ' selected="selected"';
														}
													}
													echo '>'.$row1['city_name'].'</option>';
												} ?>
											</select>
										</div>
                                    </div>
									<?php } ?>

									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Store Name</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="store_name" value="<?php if(isset($_POST['store_name'])) { echo $_POST['store_name'];} else { echo $row_3['store_name']; } ?>">
										</div>
									</div>

									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Address</label>
										<div class="col-lg-7">
											<textarea class="form-control" name="address"><?php if(isset($_POST['address'])) { echo $_POST['address'];} else { echo $row_3['address']; } ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Email</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email'];} else { echo $row_3['email']; } ?>">
										</div>
									</div>

									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Mobile 1</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile_1" value="<?php if(isset($_POST['mobile_1'])) { echo $_POST['mobile_1'];} else { echo $row_3['mobile_1']; } ?>">
										</div>
									</div>

									<div class="form-group">
										<label for="inputStandard" class="col-lg-3 control-label">Mobile 2</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="mobile_2" value="<?php if(isset($_POST['mobile_2'])) { echo $_POST['mobile_2'];} else { echo $row_3['mobile_2']; } ?>">
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
											<a href="stores.php" class="btn btn-warning">Cancel</a>
											<?php if(isset($error) && $error != ""){ echo "<code>".$error."</code>"; }?>
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
