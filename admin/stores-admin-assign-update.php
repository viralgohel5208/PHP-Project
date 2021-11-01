<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Update Assigned Admin";

if(isset($_POST['save']))
{
	$item_id 		= escapeInputValue($_GET[ 'id' ]);
	
	$store_id 		= escapeInputValue($_REQUEST['store_id']);
	$admin_id 		= escapeInputValue($_REQUEST['admin_id']);
	
	if($store_id == "" || $admin_id =="")
	{
		$error = "Please enter all details";
	}
	
	if( $error == "" )
	{
		$q_11 = "SELECT id FROM stores_admin WHERE app_id = $app_id AND store_id = '$store_id' AND admin_id = '$admin_id' AND id != $item_id";
		
		$r_11 = mysqli_query( $link, $q_11 );

		if ( !$r_11 )
		{
			$error = $sww;
		}
		else if ( mysqli_num_rows( $r_11 ) > 0 )
		{
			$error = "Admin already assigned to store";
		}
	}
	
	if($error == "")
	{
		$up_query = "UPDATE stores_admin SET store_id = '$store_id', admin_id = '$admin_id' WHERE id = '$item_id' AND app_id = $app_id";
		//echo $up_query;
		$result5 = mysqli_query($link, $up_query);
		if(!$result5)
		{
			$error = $sww;
		}
		else
		{
			mysqli_autocommit($link, TRUE);
			$_SESSION['msg_success'] = "Admin details has been updated successfully";
			header("location:stores-admin-assign-update.php?id=$item_id");
			exit;
		}
	}
}

if(isset($_GET[ 'id' ] ) )
{
	$item_id = escapeInputValue($_GET[ 'id' ]);

	$query_3 = "SELECT * FROM `stores_admin` WHERE id = '" . $item_id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
		}
		else
		{
			$_SESSION['msg_error'] = "Admin does't found";
			header( "Location:stores-admin-assign.php" );
			exit;
		}
	}
	else
	{
		$_SESSION['msg_error'] = $sww;
		header( "Location:stores-admin-assign.php" );
		exit;
	}
}
else
{
	header( "Location:stores-admin-assign.php" );
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
							<a href="stores-admin-assign.php">Assign Stores Admin</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="stores-admin-assign.php" class="pl5 btn btn-default btn-sm">
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
									$result1 = mysqli_query($link, "SELECT id, store_name FROM stores ORDER BY store_name");
									if($result1)
									{ 
									?>
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Select Store</label>
                                        <div class="col-lg-7">
											<select name="store_id" class="form-control">
												<?php while($row1 = mysqli_fetch_assoc($result1)) {
												   	echo '<option value="'.$row1['id'].'"';
													if(isset($_POST['store_id']))
													{
														if($_POST['store_id'] == $row1['id'])
														{
															echo ' selected="selected"';
														}
													}
													else
													{
														if($row_3['store_id'] == $row1['id'])
														{
															echo ' selected="selected"';
														}
													}
													echo '>'.$row1['store_name'].'</option>';
												} ?>
											</select>
										</div>
                                    </div>
									<?php } ?>
									
									<?php 
									$result1 = mysqli_query($link, "SELECT id, first_name, last_name FROM admin WHERE app_id = $app_id ORDER BY first_name, last_name ASC");
									if($result1)
									{ 
									?>
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Select Admin User*</label>
                                        <div class="col-lg-7">
											<select name="admin_id" class="form-control">
												<?php while($row1 = mysqli_fetch_assoc($result1)) {
												   	echo '<option value="'.$row1['id'].'"';
													if(isset($_POST['admin_id']))
													{
														if($_POST['admin_id'] == $row1['id'])
														{
															echo ' selected="selected"';
														}
													}
													else
													{
														if($row_3['admin_id'] == $row1['id'])
														{
															echo ' selected="selected"';
														}
													}
													echo '>'.$row1['first_name'].' '.$row1['last_name'].'</option>';
												} ?>
											</select>
										</div>
                                    </div>
									<?php } ?>

									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="save" class="btn btn-success">Save</button>
											<a href="stores-admin-assign.php" class="btn btn-warning">Cancel</a>
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