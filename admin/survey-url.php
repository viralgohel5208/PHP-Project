<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";

if ( isset( $_POST[ 'save_settings' ] ) )
{
	$survey_url 			= $_POST[ 'survey_url' ];
	$survey_url_ar 			= $_POST[ 'survey_url_ar' ];

	$query = "UPDATE settings SET survey_url = '" . $survey_url . "', survey_url_ar = '" . $survey_url_ar . "'";

	$result = mysqli_query( $link, $query );

	if ( !$result )
	{
		$error = $sww;
	}
	else
	{
		$success = "Details has been updated successfully";
	}
}

$result = mysqli_query( $link, "SELECT * FROM settings WHERE id = 1" );
if ( $result )
{
	$row = mysqli_fetch_assoc( $result );
}
else
{
	echo $error_500 = 500;
	exit;
}

$page_title = "Survey Url";

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
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
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
								<span class="panel-title"><span class="fa fa-flash"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post">
									
									<div class="form-group">
										<label class="col-lg-3 control-label">Survey url</label>
										<div class="col-lg-8">
											<input type="text" class="form-control" name="survey_url" value="<?php if(isset($_POST['survey_url'])) { echo $_POST['survey_url'];} else { echo $row['survey_url']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Survey url</label>
										<div class="col-lg-8">
											<input type="text" class="form-control" name="survey_url_ar" value="<?php if(isset($_POST['survey_url_ar'])) { echo $_POST['survey_url_ar'];} else { echo $row['survey_url_ar']; } ?>">
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8">
											<button type="submit" name="save_settings" class="btn btn-success">Save</button>
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