<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$page_title = "Broadcast SMS";

$sms_credentials = [];
$disabled = "disabled";

$query_sms = "SELECT sms_username, sms_password, sms_sender_id FROM admin_settings WHERE id = 1";
$res_sms = mysqli_query($link, $query_sms);

if($res_sms)
{
	if(mysqli_num_rows($res_sms) > 0)
	{
		$row_sms = mysqli_fetch_assoc($res_sms);
		$sms_username = $row_sms['sms_username'];
		$sms_password = $row_sms['sms_password'];
		$sms_sender_id = $row_sms['sms_sender_id'];
		
		if($sms_username != "" && $sms_password != "" && $sms_sender_id != "")
		{
			$sms_credentials['sms_username'] = $sms_username;
			$sms_credentials['sms_password'] = $sms_password;
			
			$disabled = "";
		}
	}
}

// Download Sample CSV
if(isset($_GET['sample-csv']))
{
	//$list = ['Sr No., Contact Name, Contact Number, Status', '1, ABC XYZ, 9999999999, 1'];
	$list = ['Mobile Number'];
	
	$filename = 'users-mobile-import-csv-sample.csv';
	$path = ''; // '/uplods/'
	$file = fopen($path.$filename, "w");
	foreach ($list as $line) {
		fputcsv($file,explode(',',$line));
	}
	fclose($file);
	$download_file =  $path.$filename;
	
	// Check file is exists on given path.
	if(file_exists($download_file))
	{
		$extension = explode('.', $filename);
		$extension = $extension[count($extension)-1]; 
		// For Gecko browsers
		header('Content-Transfer-Encoding: binary');  
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
		// Supports for download resume
		header('Accept-Ranges: bytes');  
		// Calculate File size
		header('Content-Length: ' . filesize($download_file));  
		header('Content-Encoding: none');
		// Change the mime type if the file is not PDF
		header('Content-Type: application/'.$extension);  
		// Make the browser display the Save As dialog
		header('Content-Disposition: attachment; filename=' . $filename);  
		readfile($download_file); 
		unlink($filename);
		exit;
	}
}

if(isset($_POST['import_csv']))
{
	if(!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] == 4)
	{
		$_SESSION['msg_error'] = "Please select file to import";
	}
	else
	{
		$notif_message 		= mysqli_real_escape_string($link, $_POST['message']);
		$new_message 		= str_replace(' ', '%20', $notif_message);
		$new_message 		= urlencode ($new_message);
		
		$file_name = $_FILES['csv_file']['name'];
		
		$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		
		if($extension != "csv")
		{
			$_SESSION['msg_error'] = "Only csv format file is allowed. You can easily convert your excel file to csv format";
		}
		else
		{
			$handle = fopen($_FILES['csv_file']['tmp_name'], "r");

			$i = 0;
			$full_error = "";
			/*echo '<pre>'; 
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				print_r($data);
			}		
			exit;
			*/
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				/*if($error != "")
				{
					break;
				}
				else*/
				{
				// Get Item values
				if($i == 0) {} 
				else
				{
					{
						$mobile_number 		= escapeInputValue($data[0]);
												
						if($new_message == "" || $mobile_number == "" )
						{
							$_SESSION['msg_error'] = "Please enter all mandatory fields";
						}
					}

					// Check Product Already exist or not using SKU Number
					if($_SESSION['msg_error'] == "")
					{
						$url = "http://panel.adcomsolution.in/http-api.php?username=".$sms_username."&password=".$sms_password."&senderid=".$sms_senderid."&route=1&number=+91".$mobile_number."&message=".$new_message;
						$file = file_get_contents($url);
					}
					}
				}
				$i++;
				
				if($_SESSION['msg_error'] != "")
				{
					$full_error .= "Error on line ".$i." - ".$error."<br />";
					$_SESSION['msg_error'] = "";
				}
			}

			if($_SESSION['msg_error'] == "")
			{
				$_SESSION['msg_success'] = "Sent sms has been successfully";
				
			}
		}
	}
}

if(!isset($_POST['save']))
{
	$_SESSION['selected_users'] = [];
	$_SESSION['de_selected_users'] = [];
}

if(isset($_POST['save']))
{
	//echo '<pre>'; print_r($_POST);exit;
    $selected_users 		= mysqli_real_escape_string($link, $_POST['selected_users']);
    $de_selected_users		= mysqli_real_escape_string($link, $_POST['de_selected_users']);
	$notif_message 			= mysqli_real_escape_string($link, $_POST['notif_message']);
	$new_message 			= str_replace(' ', '%20', $notif_message);
	
	$selected_users = trim($selected_users, ",");
	$selected_users = preg_replace("/,+/", ",", $selected_users);
	
	//echo $selected_users; echo "--";
	if($new_message == "")
	{
		$error = "Please enter all detail";
	}
	else if($selected_users == "")
	{
		//$user_ids = true;
		$error = "Please select customers to send SMS";
	}
	else
	{
		$selected_users = explode(",", $selected_users);
		$selected_users = array_unique($selected_users);

		$de_selected_users = trim($de_selected_users, ",");
		$de_selected_users = preg_replace("/,+/", ",", $de_selected_users);
		$de_selected_users = explode(",", $de_selected_users);
		$de_selected_users = array_filter(array_unique($de_selected_users));
		
		$selected_users 	= array_filter(array_unique($selected_users));
	}
	
	//echo "<pre>"; print_r($selected_users); print_r($de_selected_users); exit;
	
	if($error == "")
	{
		if(in_array(0, $selected_users))
		{
			if(empty($de_selected_users))
			{
				$user_ids = 0;
			}
			else
			{
				$user_ids = [];
				$user_res = mysqli_query($link, "SELECT id FROM customers WHERE app_id = $app_id");
				while($row_user = mysqli_fetch_assoc($user_res))
				{
					if(!in_array($row_user['id'], $de_selected_users))
					{
						$user_ids[] = $row_user['id'];
					}
				}
				$user_ids = implode(",", $user_ids);
			}
		}
		else
		{
			$user_ids = implode(",", $selected_users);		
		}

		//print_r($user_ids);
		//exit;
	}

	/*if(isset($_POST['user_ids']))
	{
		$user_ids = $_POST['user_ids'];
		$user_ids = implode(",", $user_ids);
	}
	else
	{
		$user_ids = 0;
	}*/
	
	if($error == "")
	{
		if($new_message == "" || $user_ids === "")
		{
			$_SESSION['msg_error'] = "Please enter all detail";
		}
		else
		{
			$query = "SELECT mobile FROM customers WHERE app_id = $app_id AND id IN ($user_ids) AND status = 1 AND account_verified = 1";
			$res_devices = mysqli_query($link, $query);
			
			while($row_device = mysqli_fetch_assoc($res_devices))
			{
				
				$mobile = $row_device['mobile'];
				$file = file_get_contents("http://bulksms.smsadz.com/http-api.php?username=".$sms_username."&password=".$sms_password."&senderid=GSMART&route=1&number=+91".$mobile."&message=".$new_message."");
			}
			$_SESSION['msg_success'] = "SMS has been sent successfully";
		}
	}
}

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
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/datatables_addons.min.css">
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="tables-basic-page">
	<div id="main">
		<?php require_once "header.php"; ?>
		<?php require_once "sidebar.php"; ?>
		<section id="content_wrapper">
			<header id="topbar">
				<div class="topbar-left">
					<ol class="breadcrumb">
						<li class="crumb-active">
							<a href="broadcast-sms.php"><?php echo $page_title; ?></a>
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

			<section id="content">
				<div class="row">
					<div class="col-md-12">
						
						<?php require_once "message-block.php"; ?>
						<?php if(empty($sms_credentials)) { ?>
						<div class="alert alert-sm alert-border-left alert-danger alert-dismissable">
							<i class="fa fa-check pr10"></i>
							<strong>Heads up!</strong> SMS Pack details is not added. It is required to send SMS to customers. Please contact administrator.
						</div>
						<?php } ?>
						
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title">
									<span class="fa fa-users"></span><?php echo $page_title; ?>
								</span>
							</div>
							<div class="panel-body pn">
								<div>
									<label class="checkbox-inline mr10" style=" padding: 20px; margin-left:9px;">
									<input type="checkbox" id="ckbCheckAll" <?php if(isset($_POST['save']) && isset($user_ids)) { if($user_ids == 0) { echo 'checked="checked"'; } } ?>>Select All Users</label>
								</div>
								
								<table id="datatable_grid" class="display table table-striped table-bordered">
									<thead>
										<tr>
											<th style="width: 50px;">#</th>
											<th style="width: 50px;">Sr. No</th>
											<th>First name</th>
											<th>Last name</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Status</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>#</th>	
											<th>Sr. No</th>
											<th>First name</th>
											<th>Last name</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Status</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						
                        <div class="panel panel-dark">
                            <div class="panel-heading">
                                <span class="panel-title">Selected Users</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post" action="" >
                                	<input type="hidden" class="" id="selected_users" name="selected_users" value="<?php if(isset($_POST['save'])  && isset($user_ids)) { if($user_ids == 0) { echo 0; } else { echo $user_ids; } } ?>">
                                	<input type="hidden" class="" id="de_selected_users" name="de_selected_users" value="">
                                  	<div class="form-group">
                                        <label class="col-lg-3 control-label">Message*</label>
                                        <div class="col-lg-7">
											<textarea name="notif_message" class="form-control" rows="3" ><?php if(isset($_POST['notif_message'])){ echo $_POST['notif_message']; } ?></textarea>
                                   		</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-8 mt20">
                                            <button type="submit" name="save" class="btn btn-success" <?php echo $disabled; ?>>Send</button>
                                            <a href="broadcast-sms.php" class="btn btn-warning" <?php echo $disabled; ?>>Cancel</a>
                                        </div>
                                    </div>                                    
                                </form>
                            </div>
                        </div>

                        <div class="panel panel-dark">
                            <div class="panel-heading">
                                <span class="panel-title">Upload CSV / Export</span>
                            </div>
                            <div class="panel-body">
								<div id="upload-csv" class="content" style="margin-top: 20px">
									<form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
										<div class="form-group">
											<label class="col-lg-3 control-label">Message*</label>
											<div class="col-lg-7">
												<textarea name="message" class="form-control" rows="3" ><?php if(isset($_POST['message'])){ echo $_POST['message']; } ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 control-label">Upload File </label>
											<div class="col-lg-7">
												<input type="file" class="form-control" name="csv_file">
											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-offset-3 col-lg-8 mt20">
												<button type="submit" name="import_csv" class="btn btn-success" <?php echo $disabled; ?>>Import</button>
												<a <?php if(!empty($sms_credentials)) { echo 'href="broadcast-sms.php?sample-csv=1"'; } ?> class="btn btn-info" <?php echo $disabled; ?>>Download Sample CSV</a>
												<a href="broadcast-sms.php" class="btn btn-warning" <?php echo $disabled; ?>>Cancel</a>
											</div>
										</div>
									</form>
								</div>
                            </div>
                        </div>
                    </div>
				</div>
			</section>
		</section>
	</div>
	
	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="vendor/plugins/datatables/media/js/datatables.min.js"></script>
	<script src="vendor/plugins/datatables/media/js/datatables_addons.min.js"></script>
	<script src="vendor/plugins/datatables/media/js/datatables_editor.min.js"></script>
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
		
		$(document).ready(function () {
			// Init DataTables
			$('#datatable_grid').DataTable({
				"aoColumnDefs": [ {
					'bSortable': false,
					'aTargets': [ -1 ]
				} ],
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
					url :"broadcast-sms-datatable.php", // json datasource
					type: "post",  // type of method  ,GET/POST/DELETE
					error: function(){
						$("#datatable_grid_processing").css("display","none");
					}
				}
			});
			
			$("#ckbCheckAll").click(function () {
				$(".checkBoxClass").prop('checked', $(this).prop('checked'));
				if (!$("#ckbCheckAll").prop("checked")){
					//alert(1);
					updateSelUser(1, 0, 0)
				} else {
					//alert(2);
					updateSelUser(1, 1, 0)
				}
			});
			
		});
		
		function changeCheckBx(x)
		{
			//alert(x.checked);
			var item_val = x.value;
			if (x.checked == false){
				$("#ckbCheckAll").prop("checked",false);
				updateSelUser(2, 0, item_val);
			}
			else
			{
				//alert(4);
				updateSelUser(2, 1, item_val);
			}
		}
		
		function updateSelUser(x, y, z)
		{
			//alert(x+" - "+ y+" - "+ z);
			// var x = X is for check all select box button or Individual select box button
			// var Y = 1 is for check box selected or 0 is for unchecked
			// var Z = id value of the individual check box
			
			var selected_users = $("#selected_users").val();
			selected_users = selected_users.replace(/^,|,$/g,'');
			selected_users = selected_users.replace(/^[, ]+|[, ]+$|[, ]+/g, ",").trim();
			selected_users = ","+selected_users+",";
			
			var de_selected_users = $("#de_selected_users").val();
			de_selected_users = de_selected_users.replace(/^,|,$/g,'');
			de_selected_users = de_selected_users.replace(/^[, ]+|[, ]+$|[, ]+/g, ",").trim();
			de_selected_users = ","+de_selected_users+",";
			
			//alert(selected_users+ " - "+ de_selected_users);
			
			if(x == 1 && y == 1)
			{
				//$("#selected_users").val("0");
				//$("#de_selected_users").val("");
				selected_users = 0;
				de_selected_users = "";
			}
			else if(x == 1 && y == 0)
			{
				//$("#selected_users").val("");
				//$("#de_selected_users").val("");
				selected_users = "";
				de_selected_users = "";
			}
			else if(x == 2 && y == 1)
			{
				if($("#selected_users").val() != 0 || $("#selected_users").val() == "")
				{
					selected_users = selected_users+","+z+",";
				}
				de_selected_users = de_selected_users.replace(","+z+",", ",");
			}
			else if(x == 2 && y == 0)
			{
				if($("#selected_users").val() != 0)
				{
					selected_users = selected_users.replace(","+z+",", ",");
				}
				de_selected_users = de_selected_users+","+z+",";
			}
			
			//alert(selected_users);
			if(selected_users != 0)
			{
				//alert("in");
				var n = selected_users.indexOf(",0,");
				//alert("n = "+n)

				if(n >= 0)
				{
					var ccc = de_selected_users;
					//alert(ccc);
					if(ccc == ",,")
					{
						//alert("set 0");
						de_selected_users = "";
						selected_users = "0";
						$("#ckbCheckAll").prop("checked", true);
					}
				}
			}
			
			$("#selected_users").val(selected_users);
			$("#de_selected_users").val(de_selected_users);
			
			$.ajax({
				url: "ajax-notification.php",
				method: 'POST',
				data: "s="+selected_users+"&d="+de_selected_users,
				success: function(result){
					//$("#div1").html(result);
				}
			});

			//alert(selected_users+ " - "+ de_selected_users);
		}
		
		function importCsv(x)
		{
			$("#imp_campaign_id").val(x);
			$("#upload-csv").css('display', 'block');
		}
	</script>
</body>
</html>