<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

if(isset($_POST['submit']))
{
	/*echo '<pre>'; print_r($_POST); echo '</pre>'; exit;*/
	$description 		= escapeInputValue($_POST['description']);
	
	if($description == "")
	{
		$error = "Please enter about us";
	}
	
	if($error == "")
	{
		$query_2 = "UPDATE `app_info` SET `about_us` = '$description' WHERE app_id = $app_id";

		$result_2 = mysqli_query( $link, $query_2 );

		if($result_2)
		{
			$success = "Details has been updated successfully";
			unset($_POST);
		}
		else
		{
			$error = $sww;
		}
	}
}

$result = mysqli_query( $link, "SELECT about_us FROM app_info WHERE app_id = $app_id" );

if ( $result )
{
	if(mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_assoc( $result );
		$description = $row['about_us'];
	}
	else
	{
		$query_ins = "INSERT INTO `app_info`(`app_id`) VALUES ($app_id)";
		$res_ins = mysqli_query($link, $query_ins);

		$description = "";
	}
}
else
{
	echo $error_500 = 500;
	exit;
}

$page_title = "About Us";

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
	<link rel="stylesheet" href="assets/css/summernote/summernote.css" >
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
							<a href="index.php"><span class="glyphicon glyphicon-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
			</header>

			<div id="content" class="animated fadeIn">
				<div class="row">
					<div class="col-md-12">
						<?php require_once "message-block.php"; ?>
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title"><span class="fa fa-info"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post">
									<div class="form-group">
										<label class="col-sm-3 control-label">Description</label>
										<div class="col-lg-7">
											<textarea name="description" id="summernote1"><?php if(isset($_POST['description'])) { echo $description; } else { echo $description; } ?></textarea >
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-7">
											<button type="submit" name="submit" class="btn btn-success">Save</button>
											<a href="" class="btn btn-warning">Cancel</a>
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
	<script src="assets/js/summernote.min.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function () {
			"use strict";
			// Init Theme Core
			Core.init();
			// Init Demo JS
			Demo.init();
		} );
		
		$(function($) {
			$('#summernote1').summernote({
				height: 500,                 // set editor height
				minHeight: null,             // set minimum height of editor
				maxHeight: null,             // set maximum height of editor
				//focus: true                  // set focus to editable area after initializing summernote
			});
		});
	</script>
</body>
</html>