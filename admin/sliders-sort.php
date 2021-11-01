<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$page_title = "Sort Slider Sequence";

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
	<link rel="stylesheet" href="assets/css/nestable.css" media="screen">
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
							<a href="sliders.php">Sliders</a>
						</li>
						<li class="crumb-trail"><?php echo $page_title; ?></li>
					</ol>
				</div>
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="sliders.php" class="pl5 btn btn-default btn-sm">
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
								<span class="panel-title"><span class="fa fa-signal"></span><?php echo $page_title; ?> - Drag and drop the section you want to re-arrange. Changes will be saved instantly.</span>
							</div>
						</div>
					</div>
					<div id="msg-block" style="display:none">
						<div class="col-md-12">
							<div class="alert alert-success" role="alert"> <strong>Success!</strong> Sequence have been updated. </div>
						</div>
					</div>
					<div class="col-md-12">
						<?php 
						$query_4 = "SELECT * FROM sliders ORDER BY display_order";
						$result_4 = mysqli_query($link , $query_4);
						if(!$result_4)
						{
							echo 'Something went wrong, Please try again';
						}
						else
						{
							echo '<div class="dd" id="nestable"><ol class="dd-list">';

							while($row_4 = mysqli_fetch_assoc($result_4))
							{
								echo '<li class="dd-item" data-id="'.$row_4['id'].'">';
								echo '<div class="dd-handle panel-body">';
								//echo $row_4['slider_name'];
								echo '<img src="../uploads/store-'.$app_id.'/sliders/'.$row_4['file_name'].'" class="img-responsive" title="'.$row_4['slider_name'].'" style="width:200px">';
								echo '</div>';
								echo '</li>';
							}
							echo '</ol></div>';
						}
						?>
						<!-- /.col-md-6 -->

						<textarea id="nestable-output" style="display: none"></textarea>
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
	<script src="assets/js/jquery.nestable.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function () {
			"use strict";
			// Init Theme Core
			Core.init();
			// Init Demo JS
			Demo.init();
		} );		
		$(document).ready(function()
		{
			var i = 0;
			var updateOutput = function(e)
			{
				var list   = e.length ? e : $(e.target),
					output = list.data('output');
				if (window.JSON) {
					var serialize = window.JSON.stringify(list.nestable('serialize'));
					//alert(serialize);
					output.val(serialize);//, null, 2));

					$.ajax({
						type: "POST",
						url: "include/sortable-sliders.php",
						data: "serialize="+serialize,
						//success: function(data) {if(i != 0) { $("#msg-block").css("display", "block"); } },
						/*success: function(result){
							$("#div1").html(result);
						},
						error: alert(21)*/

					});
					i = i+1;

				} else {
					output.val('JSON browser support required for this demo.');
				}
			};

			// activate Nestable for list 1
			$('#nestable').nestable({
				group: 1,
				maxDepth: 1
			})
			.on('change', updateOutput);

			// output initial serialised data
			updateOutput(
				$('#nestable').data('output', $('#nestable-output'))
			);

			$('#nestable-menu').on('click', function(e)
			{
				var target = $(e.target),
					action = target.data('action');
				if (action === 'expand-all') {
					$('.dd').nestable('expandAll');
				}
				if (action === 'collapse-all') {
					$('.dd').nestable('collapseAll');
				}
			});
		});
	</script>
</body>
</html>