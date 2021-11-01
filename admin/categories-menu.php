<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

if ( isset( $_POST[ 'save_settings' ] ) )
{
	//echo '<pre>'; print_r($_REQUEST); exit;
	
	if(isset($_POST['categories'])) {
		$categories = $_POST['categories'];
	} else {
		$categories = [];
	}
	
	if(empty($categories))
	{
		$error = "Please select categories to display in menu.";
	}
	else
	{
		$categories = array_slice($categories, 0, 7);
		$categories_str = implode(",", $categories);
	}
	
	if($error == "")
	{
		$query = "UPDATE `app_display_options` SET `categories_menu` = '$categories_str', `updated_at` = '$current_datetime' WHERE app_id = $app_id";

		$result = mysqli_query( $link, $query );

		if ( !$result )
		{
			$error = $sww."4";
		}
		else
		{
			$success = "Details has been updated successfully (Maximum 7 categories can be added).";
		}
	}
}

$query_3 = "SELECT id, categories_menu FROM `app_display_options` WHERE app_id = '" . $app_id . "' LIMIT 1" ;

$result_3 = mysqli_query( $link, $query_3);
	
if(!$result_3)
{
	$error = $sww;
}
else
{
	if ( mysqli_num_rows( $result_3 ) == 0 )
	{
		$query_1 = "INSERT INTO `app_display_options`(`app_id`, `categories_menu`, `updated_at`) VALUES ('$app_id', '', '$current_datetime')";
		
		$result_1 = mysqli_query($link, $query_1);
		
		if(!$result_1)
		{
			$error = $sww.'2';
		}
		else
		{
			$categorie_menu = "";
		}
	}
	else
	{
		$row_3 = mysqli_fetch_assoc( $result_3 );
		
		$categorie_menu = $row_3['categories_menu'];
	}
}

$ex_categories_menu = explode(",", $categorie_menu);

$page_title = "Select Menu";

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
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
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
						<li class="crumb-link">
							<a href="client-subscriptions.php">Subscription Settings</a>
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
								<span class="panel-title"><span class="glyphicon glyphicon-cog"></span><?php echo $page_title; ?></span>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="post">
									
									<div class="form-group">
                                        <label class="col-lg-3 control-label">Select Categories to display in Menu</label>
										<div class="col-md-7">
											<p style="margin-top: 10px; font-weight: bold;">Maximum 7 categories can be added.</p>
											<?php 
											$i = 0;
											
											$getAppMainCategories = getAppMainCategories($app_id);
											
											foreach($getAppMainCategories as $value)
											{
												echo '<div class="checkbox-custom mr10" style="padding-left:0">';
												echo '<input type="checkbox" id="checkboxDefault'.$i.'" name="categories[]" value="'.$value['id'].'" ';
												if(in_array($value['id'], $ex_categories_menu)) {
													echo ' checked="checked"';
												}
												echo '>';
												echo '<label for="checkboxDefault'.$i.'">'.$value['category_name'].'</label>';
												echo '</div>';
												$i++;
											}
											?>
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