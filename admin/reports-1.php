<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "../functions.php";
require_once "login-required.php";

$page_title = "Reports";

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
	<link rel="shortcut icon" href="../assets/images/favicon.png">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600'>
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
	
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="dashboard-page sb-l-o sb-r-c">
	<div id="main">
		
		<?php require_once "header.php"; ?>
		<?php require_once "sidebar.php"; ?>
		
		<section id="content_wrapper">

			<header id="topbar">
				<div class="topbar-left">
					<ol class="breadcrumb">
						<li class="crumb-active">
							<a href="">Reports</a>
						</li>
						<li class="crumb-icon">
							<a href="index.php"><span class="fa fa-home"></span></a>
						</li>
						<li class="crumb-link">
							<a href="index.php">Home</a>
						</li>
						<li class="crumb-trail">Reports</li>
					</ol>
				</div>				
			</header>

			<section id="content" class="animated fadeIn">
				
				<div class="row">
                    <div class="col-md-12">
						<?php require_once "message-block.php"; ?>
                        <div class="panel panel-visible panel-dark">
                            <div class="panel-heading panel-visible">
                                <span class="panel-title"><span class="fa fa-plus"></span><?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
								<form class="form-horizontal" role="form" method="post" action="" >
									
									<div class="form-group">
										<label class="col-lg-3 control-label">From Date*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control pull-right" name="date_from" id="date_from" value="<?php if(isset($_POST['date_from'])) { echo $_POST['date_from']; } ?>" placeholder="Enter from date">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">To Date*</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" id="date_to" name="date_to" value="<?php if(isset($_POST['date_to'])) { echo $_POST['date_to']; } ?>" placeholder="Enter to date">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Select Stores</label>
										<div class="col-lg-7">
											<select class="form-control" name="store_id" id="store_selector">
												<option value="0" >All Store</option>
												<?php 
												$result3 = mysqli_query($link,"SELECT id, store_name FROM stores WHERE app_id = $app_id ORDER BY store_name");	
												while($row3 = mysqli_fetch_assoc($result3))
												{?>
												<option value="<?php echo $row3['id']; ?>" ><?php echo $row3['store_name']?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8 mt20">
											<button type="submit" name="save" class="btn btn-success">Generate Report</button>
										</div>
									</div>
								</form>
                            </div>
                         </div>
						
						<?php /*?><div class="panel panel-visible panel-dark">
                            <div class="panel-heading panel-visible">
                                <span class="panel-title"><span class="fa fa-plus"></span><?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
								<?php 
								echo '<pre>';
								print_r($_POST);
								echo '</pre>';
								?>
							</div>
						</div><?php */?>
                    </div>
                 </div>
				
				<div class="admin-panels fade-onload">
					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-info">
								<div class="panel-heading">
									<span class="panel-title">Data Panel Widget</span>
								</div>
								<div class="panel-body mnw700 of-a">
									<div id="high-column2" class="highchart-wrapper" style="width: 100%; height: 255px; margin: 0 auto"></div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="panel panel-system">
								<div class="panel-heading">
									<span class="panel-title">Area Graph</span>
								</div>
								<div class="panel-body pn">
									<div id="high-line3" class="highchart-wrapper" style="width: 100%; height: 210px; margin: 0 auto"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php //require_once "include/footer.php"; ?>
		</section>
	</div>

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_migrate/jquery-migrate-3.0.0.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="vendor/plugins/moment/moment.min.js"></script>
	<script src="vendor/plugins/highcharts/highcharts.js"></script>
	<script src="vendor/plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="vendor/plugins/circles/circles.js"></script>
	<script src="vendor/plugins/jvectormap/jquery.jvectormap.min.js"></script>
	<script src="vendor/plugins/jvectormap/assets/jquery-jvectormap-us-lcc-en.js"></script>
	<script src="vendor/plugins/daterange/daterangepicker.js"></script>
	<script src="vendor/plugins/datepicker/js/bootstrap-datetimepicker.js"></script> 
	<script src="assets/js/utility/utility.js"></script>
	<script src="assets/js/demo/demo.js"></script>
	<script src="assets/js/main.js"></script>

	<?php /*?><script src="assets/js/demo/widgets.js"></script><?php */?>
	<script type="text/javascript">
		jQuery( document ).ready( function () {

			"use strict";

			// Init Theme Core      
			Core.init();

			// Init Demo JS
			Demo.init();
			
			// Init DateRange plugin
			$('#date_from').datetimepicker({
				pickTime: false,
				format: 'DD-MM-YYYY',
			});

			// Init DateRange plugin
			$('#date_to').datetimepicker({
				pickTime: false,
				format: 'DD-MM-YYYY',
			});
			
			// Init Admin Panels on widgets inside the ".admin-panels" container
			$( '.admin-panels' ).adminpanel( {
				grid: '.admin-grid',
				draggable: true,
				preserveGrid: true,
				mobile: false,
				onStart: function () {
					// Do something before AdminPanels runs
				},
				onFinish: function () {
					$( '.admin-panels' ).addClass( 'animated fadeIn' ).removeClass( 'fade-onload' );
					// Init the rest of the plugins now that the panels
					// have had a chance to be moved and organized.
					// It's less taxing to organize empty panels
					setTimeout( function () {
						demoHighCharts.init();
					}, 300 )

				},
				onSave: function () {
					$( window ).trigger( 'resize' );
				}
			} );
		} );
	</script>
	
	<script type="text/javascript">
		'use strict';
		var demoHighCharts = function () {
			var highColors = [bgWarning, bgPrimary, bgInfo, bgAlert, bgDanger, bgSuccess, bgSystem, bgDark];
			var demoHighCharts = function () {
				var demoHighColumns = function () {

					var column2 = $('#high-column2');
					if (column2.length) {
						$('#high-column2').highcharts({
							credits: false,
							colors: [bgPrimary, bgPrimary, bgWarning, bgWarning, bgInfo, bgInfo],
							chart: {
								padding: 0,
								marginTop: 25,
								marginLeft: 15,
								marginRight: 5,
								marginBottom: 30,
								type: 'column',
							},
							legend: {
								enabled: false
							},
							title: {
								text: null,
							},
							xAxis: {
								lineWidth: 0,
								tickLength: 6,
								title: {
									text: null
								},
								labels: {
									enabled: true
								}
							},
							yAxis: {
								max: 20,
								lineWidth: 0,
								gridLineWidth: 0,
								lineColor: '#EEE',
								gridLineColor: '#EEE',
								title: {
									text: null
								},
								labels: {
									enabled: false,
									style: {
										fontWeight: '400'
									}
								}
							},
							tooltip: {
								headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
								pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
								footerFormat: '</table>',
								shared: true,
								useHTML: true
							},
							plotOptions: {
								column: {
									colorByPoint: true,
								}
							},
							series: [{
								name: 'Tokyo',
								data: [12, 14, 20, 19, 8, 12, 14, 20, 5, 16, 8, 12, 14, 20, 19, 5, 16, 8, 12, 14, 20, 19, 5, 16, 8]
							}]
						});
					}
				}
				var demoHighLines = function () {
					var line3 = $('#high-line3');
					if (line3.length) {
						$('#high-line3').highcharts({
							credits: false,
							colors: highColors,
							chart: {
								backgroundColor: '#f9f9f9',
								className: 'br-r',
								type: 'line',
								zoomType: 'x',
								panning: true,
								panKey: 'shift',
								marginTop: 25,
								marginRight: 1,
							},
							title: {
								text: null
							},
							xAxis: {
								gridLineColor: '#EEE',
								lineColor: '#EEE',
								tickColor: '#EEE',
								categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
							},
							yAxis: {
								min: 0,
								tickInterval: 5,
								gridLineColor: '#EEE',
								title: {
									text: null,
								}
							},
							plotOptions: {
								spline: {
									lineWidth: 3,
								},
								area: {
									fillOpacity: 0.2
								}
							},
							legend: {
								enabled: false,
							},
							series: [{
								name: 'Yahoo',
								data: [7.0, 6, 9, 14, 18, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
							}, {
								name: 'CNN',
								data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
							}, {
								visible: false,
								name: 'Yahoo',
								data: [1, 5, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
							}, {
								visible: false,
								name: 'Facebook',
								data: [3, 1, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
							}, {
								visible: false,
								name: 'Facebook',
								data: [7.0, 6, 9, 14, 18, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
							}, {
								visible: false,
								name: 'CNN',
								data: [1, 5, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
							}]
						});
					}
				}
				demoHighColumns();
				demoHighLines();
			}
			return {
				init: function () {
					demoHighCharts();
				}
			}
}();
	</script>	
</body>
</html>