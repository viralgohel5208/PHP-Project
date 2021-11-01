<?php

require_once "config.php";
require_once "universal.php";
require_once "login-required.php";
require_once "define.php";
require_once "functions.php";

$page_title = "Store Headquarter";

$result6 = mysqli_query($link,"select * from store_office");
$row6 = mysqli_fetch_assoc($result6);

if(isset($_POST['save']))
{
	
	$store_city = mysqli_real_escape_string($link, $_REQUEST['store_city']);
	
    $store_address   = mysqli_real_escape_string($link, $_REQUEST['store_address']);
	 $store_state   = mysqli_real_escape_string($link, $_REQUEST['store_state']);
	 $store_country   = mysqli_real_escape_string($link, $_REQUEST['store_country']);
	 $mobile_no_1   = mysqli_real_escape_string($link, $_REQUEST['mobile_no_1']);
	 $mobile_no_2   = mysqli_real_escape_string($link, $_REQUEST['mobile_no_2']);
	
	
	if($store_city == "" || $store_state =="" || $store_address == "" || $store_country == "" || $mobile_no_1 == "" || $mobile_no_2 == "")
	{
            $error = "Please enter all details";
	}
	else
	{
		
		
		if($error == "")
		{
			
				$result3 = mysqli_query($link,"update store_office set address = '$store_address',city = '$store_city', state = '$store_state', country = '$store_country', mobile_no_1 = '$mobile_no_1', mobile_no_2 = '$mobile_no_2'");
				
				
                header("location: store-headquarter.php");
				$_SESSION['msg']['success'] = "Store Information has been updated successfully";
				exit;
							
		}
		else
        {
            $error = $sww;
        }
	}
	
}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?php echo $page_title.' - '.$application_name; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="assets/custom-1.css">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">

    <!-- Required Plugin CSS -->
    <link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/js/utility/highlight/styles/googlecode.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
    
    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    
    <link rel="stylesheet" type="text/css" href="assets/custom.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="tables-datatables-page">

    <!-- Start: Main -->
    <div id="main">

        <!-- Start: Header -->
        <?php require_once "header-main.php"; ?>
        <!-- End: Header -->

        <!-- Start: Sidebar -->
        <?php require_once "sidebar-left.php"; ?>
        <!-- End: Sidebar -->

        <!-- Start: Content -->
        <section id="content_wrapper">

            <!-- Start: Topbar -->
            <?php $breadcrumb = array('bk1' => 'Store Settings', 'bk1_url' => 'store-settings.php', 'bk2' => $page_title, 'bk2_url' => ''); ?>
            <?php require_once "topbar-breadcrumb.php"; ?>
            <!-- End: Topbar -->

            <div id="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible panel-dark">
                            <div class="panel-heading panel-visible">
                                <span class="panel-title"><?php echo $page_title; ?></span>
                            </div>
                            <div class="panel-body">
                               <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                     
                                 
                                   <div class="form-group">
									<label for="inputStandard" class="col-lg-3 control-label">Address</label>
									<div class="col-lg-7">

										<input type="text" class="form-control" name="store_address" value="<?php echo $row6['address'];?>">
									</div>
									</div>
                                 
                                  <div class="form-group">
									<label for="inputStandard" class="col-lg-3 control-label">City</label>
									<div class="col-lg-7">

										<input type="text" class="form-control" name="store_city" value="<?php echo $row6['city'];?>">
									</div>
									</div>
                                  <div class="form-group">
									<label for="inputStandard" class="col-lg-3 control-label">State</label>
									<div class="col-lg-7">

										<input type="text" class="form-control" name="store_state" value="<?php echo $row6['state'];?>">
									</div>
									</div>
                                  <div class="form-group">
									<label for="inputStandard" class="col-lg-3 control-label">Country</label>
									<div class="col-lg-7">

										<input type="text" class="form-control" name="store_country" value="<?php echo $row6['country'];?>">
									</div>
									</div>
                                  <div class="form-group">
									<label for="inputStandard" class="col-lg-3 control-label">Mobile No 1</label>
									<div class="col-lg-7">

										<input type="text" class="form-control" name="mobile_no_1" value="<?php echo $row6['mobile_no_1'];?>">
									</div>
									</div>
                                  <div class="form-group">
									<label for="inputStandard" class="col-lg-3 control-label">Mobile No 2</label>
									<div class="col-lg-7">

										<input type="text" class="form-control" name="mobile_no_2" value="<?php echo $row6['mobile_no_2'];?>">
									</div>
									</div>
                                   
                                  
                                  
                                  
                                   
									
                                   	
                                   	
									<div class="form-group">
										<div class="col-lg-offset-3 col-lg-8 mt20">
											<button type="submit" name="save" class="btn btn-success">Save</button>
											<a href="settings.php" class="btn btn-warning">Cancel</a>
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
    
        
        <!-- End: Content -->
        <form id="d_category" action="" method="post" style="display: hidden">
            <input type="hidden" id="del-id" name="del-id" value="">            
        </form>

    </div>
    <!-- End: Main -->

    <!-- jQuery -->
    
    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function getCategory(val) {
	$.ajax({
	type: "POST",
	url: "get_sub.php",
	data:'category_id='+val,
	success: function(data){
		
		$("#subcategory-list").html(data);
	}
	});
}
function getCity(val) {

	$.ajax({
	type: "POST",
	url: "get_sub.php",
	data:'city_id='+val,
	success: function(data){
	
		$("#store-list").val(data);
	}
	});
}

function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>
    <script type="text/javascript" src="vendor/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="vendor/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="vendor/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="vendor/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js">
    </script>

    <!-- Page Plugins -->
    <script type="text/javascript" src="vendor/editors/xeditable/js/bootstrap-editable.js"></script>

    <!-- Theme Javascript -->
    <script type="text/javascript" src="assets/js/utility/utility.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
    <script type="text/javascript" src="assets/js/demo.js"></script>
    <script type="text/javascript" src="assets/js/my-functions.js"></script>
     
    <script type="text/javascript">
        jQuery(document).ready(function() {

            "use strict";

            // Init Theme Core    
            Core.init();

            // Init Demo JS   
            Demo.init();

            // Init Highlight.js Plugin
            $('pre code').each(function(i, block) {
                hljs.highlightBlock(block);
            });

            // Select all text in CSS Generate Modal
            $('#modal-close').click(function(e) {
                e.preventDefault();
                $('.datatables-demo-modal').modal('toggle');
            });

            $('.datatables-demo-code').on('click', function() {
                var modalContent = $(this).prev();
                var modalContainer = $('.datatables-demo-modal').find('.modal-body')

                // Empty Modal of Existing Content
                modalContainer.empty();

                // Clone Content and Place in Modal
                modalContent.clone(modalContent).appendTo(modalContainer);

                // Toggle Modal
                $('.datatables-demo-modal').modal({
                    backdrop: 'static'
                })
            });

            // Init Datatables with Tabletools Addon    
            

            $('#datatable2').dataTable({
                <?php /*?>"oSearch": {"sSearch": "<?php if(isset($_SESSION['set_filter']['itches_search'])) { echo $_SESSION['set_filter']['itches_search']; } ?>"},
				"order": [
                    [<?php if(isset($_SESSION['set_filter']['itches'])) { echo $_SESSION['set_filter']['itches']; } else { echo 0; } ?>, 'asc']
                ],<?php */?>
				"aoColumnDefs": [
				{
                    'bSortable': false,
                    'aTargets': [-1]
                },
				/*{ "bVisible": false, 'aTargets': [9] },
				{ "iDataSort": 9, "aTargets": [ 8 ] },*/
				],
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "",
                        "sNext": ""
                    }
                },
                "iDisplayLength": 10,
                "aLengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
                "oTableTools": {
                    "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                }
            });

            function bin(data) {
                var letter, bins = {};
                for (var i = 0, ien = data.length; i < ien; i++) {
                    letter = data[i].charAt(0).toUpperCase();

                    if (bins[letter]) {
                        bins[letter] ++;
                    } else {
                        bins[letter] = 1;
                    }
                }
                return bins;
            }

            // MISC DATATABLE HELPER FUNCTIONS
            // Add Placeholder text to datatables filter bar
            $('.dataTables_filter input').attr("placeholder", "Enter Filter Terms Here....");

            // Manually Init Chosen on Datatables Filters
            // $("select[name='datatable2_length']").chosen();
            // $("select[name='datatable3_length']").chosen();
            // $("select[name='datatable4_length']").chosen();

            // Init Xeditable Plugin
            $.fn.editable.defaults.mode = 'popup';
            $('.xedit').editable();

        });
    
	<?php if(isset($_SESSION['msg']['error']) && $_SESSION['msg']['error'] != ""){ ?> 
    gritterMsg(0, '', '<?php echo addslashes($_SESSION['msg']['error']); ?>');
    <?php unset($_SESSION['msg']['error']); } ?>
	
	<?php if(isset($_SESSION['msg']['success']) && $_SESSION['msg']['success'] != ""){ ?> 
    gritterMsg(1, '', '<?php echo addslashes($_SESSION['msg']['success']); ?>');
    <?php unset($_SESSION['msg']['success']); } ?>
	    
    function del_shirt(x)
    {
        if(confirm("Are You sure you want to delete this Shirt"))
        {
            $("#del-id").val(x);
            $("#d_category").submit();
        }        
    }
	
	$('#datatable2').on('search.dt', function() {
		var value = $('.dataTables_filter input').val();
		if(value != "") {
			$('.dataTables_filter input').css('border', '2px solid #ff0000');
			$('.dataTables_filter input').css('color', '#ff0000');
			$('.dataTables_filter input').focus();
		} else {
			$('.dataTables_filter input').css('border', '1px solid #dddddd');
			$('.dataTables_filter input').css('color', '#555555');
		}
		//console.log(value); // <-- the value
		
	});
    </script>
</body>
</html>
