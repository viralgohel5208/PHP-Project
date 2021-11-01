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
	<style>.panel-controls{display: none;}</style>
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
												{
													echo '<option value="'.$row3['id'].'"';
													if(isset($_POST['store_id']) && $_POST['store_id'] ==$row3['id'] ) { echo ' selected="selected"';}
													echo '>'.$row3['store_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Filter Type</label>
										<div class="col-lg-7" style="margin-top: 9px">
											<div class="radio-custom mb5">
												<input type="radio" id="radioExample3" name="filter_type" value="1" <?php if(isset($_POST['filter_type'])) { if($_POST['filter_type'] == 1) { echo 'checked="checked"'; } } else { echo 'checked="checked"'; } ?> >
												<label for="radioExample3">Day Wise</label>
											</div>
											<div class="radio-custom mb5">
												<input type="radio" id="radioExample4" name="filter_type" value="2" <?php if(isset($_POST['filter_type'])) { if($_POST['filter_type'] == 2) { echo 'checked="checked"'; } } ?> >
												<label for="radioExample4">Month Wise</label>
											</div>
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
						
						<?php 
						//echo '<pre>'; print_r($_POST); echo '</pre>';

						//if(isset($_POST['date_from']) && isset($_POST['date_to']))

						if(isset($_POST['filter_type']))
						{
							$filter_type = $_POST['filter_type'];
						}
						else
						{
							$filter_type = 1;
						}

							$report_data = [];
							$store_ids = [];
						
							if(isset($_POST['store_id']))
							{
								$store_id = $_POST['store_id'];
							}
							else
							{
								$store_id = 0;
							}

							if(!isset($_POST['date_from']) || !isset($_POST['date_to']) || $_POST['date_from'] == "" || $_POST['date_to'] == "")
							{
								$date_from 	= date("Y-m-01 00:00:00");
								$date_to 	= date("Y-m-d 23:59:59");
							}
							else
							{
								$date_from 	= date("Y-m-d", strtotime($_POST["date_from"]))." 00:00:00";
								$date_to 	= date("Y-m-d", strtotime($_POST["date_to"]))." 23:59:59";
							}

							//echo $date_from. ' ::::: to ::::: '.$date_to; echo '<br />';
							if($filter_type == 1) // daywise Reports
							{
								//echo 'Daywise Report';
								//$get_range = [date("Y-m-d", strtotime($date_from))];
								$get_range = [];
								$next_date_range = date("Y-m", strtotime($date_from));

								$datetime1 = new DateTime($date_from);
								$datetime2 = new DateTime($date_to);
								$interval = $datetime1->diff($datetime2);
								$day_diff = $interval->days;
								$x = 0;
								while($x <= $day_diff)
								{
									$get_range[] = date("Y-m-d", strtotime("$x days", strtotime($date_from)));
									$x++;
								}
								//echo '<pre>'; print_r($get_range);echo '</pre>';
							}
							else if($filter_type == 2)
							{
								//echo 'Monthwise Report';
								$start    = (new DateTime($date_from))->modify('first day of this month');
								$end      = (new DateTime($date_to))->modify('first day of next month');
								$interval = DateInterval::createFromDateString('1 month');
								$period   = new DatePeriod($start, $interval, $end);

								$end_date_year = date("Y", strtotime($date_to));
								$end_date_month = date("m", strtotime($date_to));

								foreach ($period as $dt) {
									$next_y = $dt->format("Y");
									$next_m = $dt->format("m");
									//echo '<br />';
									//print_r($dt);
									if($end_date_year >= $next_y && $end_date_month >= $next_m )
									{
										$get_range[] = $dt->format("Y-m");
									}
									//echo $dt->format("Y-m") . "<br>\n";
								}
								//echo '<pre>'; print_r($get_range);echo '</pre>';
							}

							//echo '<pre>'; print_r($get_range);echo '</pre>';

							if($filter_type == 1)
							{
								$query_1 = "SELECT SUM(`price_total`) as total, DATE(`created_at`) as filter_by, store_id FROM `orders` WHERE app_id = $app_id";
								if($store_id != 0)
								{
									$query_1 .= " AND store_id = $store_id ";
								}
								$query_1 .= " AND created_at >= '$date_from' AND created_at <= '$date_to' GROUP BY store_id, DATE(`created_at`) ORDER BY created_at";

								$result_1 = mysqli_query($link, $query_1);

								while($row_1 = mysqli_fetch_assoc($result_1))
								{
									$report_data[] = $row_1;
									$store_ids[] = $row_1['store_id'];
								}
							}
							else 
							{
								$query_1 = "SELECT SUM(`price_total`) as total, CONCAT(YEAR(`created_at`),'-',MONTH(`created_at`)) as filter_by, store_id FROM `orders` WHERE app_id = $app_id";
								if($store_id != 0)
								{
									$query_1 .= " AND store_id = $store_id ";
								}
								$query_1 .= " AND created_at >= '$date_from' AND created_at <= '$date_to' GROUP BY store_id, MONTH(`created_at`), YEAR(`created_at`) ORDER BY created_at";

								$result_1 = mysqli_query($link, $query_1);

								while($row_1 = mysqli_fetch_assoc($result_1))
								{
									$ex_filter_by = explode("-", $row_1['filter_by']);
									$num_padded = sprintf("%02d", $ex_filter_by[1]);
									$row_1['filter_by'] = $ex_filter_by[0]."-".$num_padded;
									$report_data[] = $row_1;
									$store_ids[] = $row_1['store_id'];
								}
							}
						
							if(empty($store_ids))
							{
								$error = "No store found";
							}
							else
							{
								/***** Fetch Store Details Start ********/
								$store_ids = array_unique($store_ids);
								asort($store_ids, SORT_REGULAR );

								//echo '<pre>'; print_r($store_ids); echo '</pre>';
								$str_store_ids = implode(",", $store_ids);
								$query_2 = "SELECT id, store_name FROM stores WHERE id in ($str_store_ids) AND app_id = $app_id";
								$result_2 = mysqli_query($link, $query_2);
								if(!$result_2)
								{
									$error = "#01 - ".$sww;
								}
								else
								{
									$store_details = [];
									while($row_2 = mysqli_fetch_assoc($result_2))
									{
										$store_details[$row_2['id']] = $row_2;
									}		
								}
							}

							if($error == "")
							{
								if(count($store_ids) != count($store_details))
								{
									$error = "Store details count does not match";
								}
							}
							/***** Fetch Store Details End ********/

							//echo '<pre>'; print_r($report_data); echo '</pre>';

							if($error == "")
							{
								$report_data_store_wise = [];

								foreach($report_data as $data)
								{
									$report_data_store_wise[$data['store_id']][$data['filter_by']] = $data;
								}

								//echo '<pre>'; print_r($report_data_store_wise); echo '</pre>';
								$report_data_filter_range = [];

								foreach($store_ids as $sid)
								{
									foreach($get_range as $gr)
									{
										if(isset($report_data_store_wise[$sid][$gr]))
										{
											$report_data_filter_range[$sid][$gr] = $report_data_store_wise[$sid][$gr];
										}
										else
										{
											$empty_data = ['total' => 0, 'filter_by' => $gr, 'store_id' => $sid];
											$report_data_filter_range[$sid][$gr] = $empty_data;
										}
									}
								}
								//echo '<pre>'; print_r($report_data_filter_range); echo '</pre>';
							}
//echo $error;
						?>
                    </div>
                </div>
				
				<div class="admin-panels fade-onload">
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="panel panel-system">
								<div class="panel-heading">
									<span class="panel-title">Reports</span>
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
		} );
	</script>
	
	<script type="text/javascript">
		jQuery( document ).ready( function () {
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
		'use strict';
		var demoHighCharts = function () {
			var highColors = [bgWarning, bgPrimary, bgInfo, bgAlert, bgDanger, bgSuccess, bgSystem, bgDark];
			var demoHighCharts = function () {
				<?php if(isset($report_data_filter_range) && !empty($report_data_filter_range)) { ?>
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
								//categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
								categories: [<?php foreach($get_range as $item) { echo "'".$item."',"; } ?>],
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
							series: [
							/*{
								name: 'Yahoo',
								data: [7.0, 6, 9, 14, 18, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
							}, {
								name: 'CNN',
								data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
							},*/
							<?php 
							foreach($report_data_filter_range as $key=>$value)
							{
								echo "{ ";
								echo "name : '".$store_details[$key]['store_name']."',";
								echo "data:[";
								foreach($value as $item) {
									echo $item['total'].",";
								}
								echo "]";
								echo "},";
							}
							?>
							]
						});
					}
				}
				demoHighLines();
				<?php } ?>
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