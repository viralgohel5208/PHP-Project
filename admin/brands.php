<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$page_title = "Brands";

if(isset($_POST['delete_id']))
{
	$id = escapeInputValue($_POST['delete_id']);
	
	$query_3 = "SELECT id, app_id, file_name FROM `brands` WHERE id = '" . $id . "'" ;
	
	$result_3 = mysqli_query( $link, $query_3);
	
	if($result_3)
	{
		if ( mysqli_num_rows( $result_3 ) > 0 )
		{
			$row_3 = mysqli_fetch_assoc( $result_3 );
			
			$app_id_db = $row_3['app_id'];
			$file_name = $row_3['file_name'];
			
			if($app_id != $app_id_db)
			{
				$_SESSION['msg_error'] = "Banner does't found";
			}
			else
			{
				if($file_name != "" && file_exists("../uploads/store-".$app_id."/brands/" . $file_name))
				{
					@unlink("../uploads/store-".$app_id."/brands/".$file_name);
				}

				$result = "DELETE FROM brands WHERE id = '" . $id . "'";

				if(mysqli_query($link, $result))
				{
					$_SESSION['msg_success'] = "Item has been deleted successfully";
				}
				else
				{
					$_SESSION['msg_error'] = $sww;
				}
			}
		}
	}
	header("Location:brands.php");
	exit;
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
	<link rel="stylesheet" type="text/css" href="vendor/plugins/magnific/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
	<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	<style>
	body.gallery-page #mix-container{ text-align:inherit; }
	.mix.label1.folder1 { padding: 3px; }
	</style>
		
</head>
<body class="gallery-page">
	<div id="main">
		<?php require_once "header.php"; ?>
		<?php require_once "sidebar.php"; ?>

		<section id="content_wrapper">
			<header id="topbar">
				<div class="topbar-left">
					<ol class="breadcrumb">
						<li class="crumb-active">
							<a href="brands.php"><?php echo $page_title; ?></a>
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
				
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<a href="brands-add.php" class="pl5 btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add New
						</a>
						<?php /*?><a href="brands-sort.php" class="pl5 btn btn-default btn-sm" style="margin-left: 20px;">
							<i class="fa fa-signal"></i> Sort Order
						</a><?php */?>
					</div>
				</div>
			</header>

			<section id="content">
				<div class="row">
					<div class="col-md-12">
						
						<?php require_once "message-block.php"; ?>
						
						<div class="panel <?php echo $panel_style; ?>">
							<div class="panel-heading">
								<span class="panel-title">
									<span class="fa fa-toggle-right"></span><?php echo $page_title; ?>
								</span>
								<div class="pull-right hidden-xs">
									<a href="brands-add.php" class="btn btn-xs btn-default btn-block mr20" style="margin-top: 8px;">Add New</a>
								</div>
							</div>
						</div>						
					</div>					
				</div>
				
				<?php

					if(isset($_REQUEST['image']) && $_REQUEST['image'] != "")
					{
						$search_str = $_REQUEST['image'];
						$sql = mysqli_query($link, "SELECT * FROM brands WHERE app_id = $app_id AND (brand_name LIKE '%$search_str%' OR brand_name LIKE '%$search_str%')");
						$targetpage = "brands.php?image=".$_REQUEST['image']."&page="; //your file name
					}
					else
					{
						$sql = mysqli_query($link, "SELECT * FROM brands WHERE app_id = $app_id");
						$targetpage = "brands.php?page="; //your file name
					}
					$total = mysqli_num_rows($sql);
					
					if(isset($_GET['page']))
					{ 
						$page = $_GET['page'];
						$start = ($page - 1) * $limit; //first item to display on this page
					}
					else
					{
						$start = 0;
						$page = 0;
					}
					$counter = 0;
					/* Setup page vars for display. */
					if ($page == 0) $page = 1; //if no page var is given, default to 1.
					$prev = $page - 1; //previous page is current page - 1
					$next = $page + 1; //next page is current page + 1
					$lastpage = ceil($total/$limit); //lastpage.
					$lpm1 = $lastpage - 1; //last page minus 1
			
					if(isset($_REQUEST['image']) && $_REQUEST['image'] != "")
					{
						$search_str = $_REQUEST['image'];
						$query_photos = "SELECT * FROM brands WHERE app_id = $app_id AND (brand_name LIKE '%$search_str%') ORDER BY brand_name ASC LIMIT $start ,$limit";
						$res_photos = mysqli_query($link, $query_photos);
					}
					else
					{
						$res_photos = mysqli_query($link, "SELECT * FROM brands WHERE app_id = $app_id ORDER BY brand_name ASC LIMIT $start ,$limit");
					}
					
					if(mysqli_num_rows($res_photos) == 0)
					{
						echo '<div class="text-danger" style="color: #e9573f; margin-left: 25px; font-size: 16px; margin-top: 50px;">No records found</div>';
					}
					else
					{
					if(isset($_REQUEST['image']) && $_REQUEST['image'] != "")
					{
						echo '<div class="text-default" style="margin-left: 25px; font-size: 16px; margin-top: 20px;">Search results for: '.$search_str.'</div>';
					}
					$i = 1;
					echo '<div id="mix-container">';
					while($row_photos = mysqli_fetch_assoc($res_photos)) { echo $fn = $row_photos['file_name'];
					?>

						<div class="mix label1 folder1">
							<div class="panel p6 pbn">
								<div class="of-h">
									<div style="height: 250px; display:table-cell; vertical-align:middle; text-align:center">
									<?php if($fn != "" && file_exists("../uploads/store-".$app_id."/brands/".$fn)) { ?>
										<img src="../uploads/store-<?= $app_id; ?>/brands/<?php echo $fn; ?>" class="img-responsive" title="<?php echo $row_photos['brand_name']; ?>">
									<?php } else { ?>
										<img src="assets/img/no-brand.png" class="img-responsive" title="<?php echo $row_photos['brand_name']; ?>">
									<?php } ?>
									</div>
									<div class="row table-layout">
										<div class="col-xs-8 va-m pln">
											<h6>
												<?php echo $row_photos['brand_name']; ?> <br/><br/>
												<?php echo formatDateTime($row_photos['created_at']); ?>
											</h6>
										</div>
										<div class="col-xs-4 text-right va-m prn">
											<a href="brands-update.php?id=<?php echo $row_photos['id']; ?>" style="cursor: pointer; margin-right: 10px;" title="Edit" ><span class="fa fa-pencil fs12 text-info"></span></a>
											<a onclick="delete_func('<?php echo $row_photos['id']; ?>')" style="cursor: pointer" title="Delete" ><span class="fa fa-trash fs12 text-danger"></span></a>
											<span class="fa fa-circle fs10 <?php if($row_photos['status'] == 1) { echo 'text-success'; } else { echo 'text-danger'; } ?> ml10" title="Active/Inactive"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if($i%4 == 0) { echo ''; } $i++; } echo '</div>'; } ?>
					
						<?php echo printPagination($adjacents, $limit, $targetpage, $page, $counter, $prev, $next, $lastpage, $lpm1); 
						?>
						<div class="gap"></div>
						<div class="gap"></div>
						<div class="gap"></div>
						<div class="gap"></div>
				
			</section>
		</section>
	</div>
	
	<form id="delete_form" action="" method="post" style="display: hidden">
		<input type="hidden" id="delete_id" name="delete_id" value="">
	</form>

	<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	
	<script src="vendor/plugins/mixitup/jquery.mixitup.min.js"></script>
	<script src="vendor/plugins/magnific/jquery.magnific-popup.js"></script>
	<script src="vendor/plugins/holder/holder.min.js"></script>
	
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
			
			var $container = $( '#mix-container' ), // mixitup container
				$toList = $( '.to-list' ), // list view button
				$toGrid = $( '.to-grid' ); // list view button

			// Instantiate MixItUp
			$container.mixItUp( {
				controls: {
					enable: false // we won't be needing these
				},
				animation: {
					duration: 400,
					effects: 'fade translateZ(-360px) stagger(45ms)',
					easing: 'ease'
				},
				callbacks: {
					onMixFail: function () {}
				}
			} );

			$toList.on( 'click', function () {
				if ( $container.hasClass( 'list' ) ) {
					return
				}
				$container.mixItUp( 'changeLayout', {
					display: 'block',
					containerClass: 'list'
				}, function ( state ) {
					// callback function
				} );
			} );
			$toGrid.on( 'click', function () {
				if ( $container.hasClass( 'grid' ) ) {
					return
				}
				$container.mixItUp( 'changeLayout', {
					display: 'inline-block',
					containerClass: 'grid'
				}, function ( state ) {
					// callback function
				} );
			} );

			// Add Gallery Item to Lightbox
			$( '.mix img' ).magnificPopup( {
				type: 'image',
				callbacks: {
					beforeOpen: function ( e ) {
						// we add a class to body to indicate overlay is active
						// We can use this to alter any elements such as form popups
						// that need a higher z-index to properly display in overlays
						$( 'body' ).addClass( 'mfp-bg-open' );

						// Set Magnific Animation
						this.st.mainClass = 'mfp-zoomIn';

						// Inform content container there is an animation
						this.contentContainer.addClass( 'mfp-with-anim' );
					},
					afterClose: function ( e ) {

						setTimeout( function () {
							$( 'body' ).removeClass( 'mfp-bg-open' );
							$( window ).trigger( 'resize' );
						}, 1000 )

					},
					elementParse: function ( item ) {
						// Function will fire for each target element
						// "item.el" is a target DOM element (if present)
						// "item.src" is a source that you may modify
						item.src = item.el.attr( 'src' );
					},
				},
				overflowY: 'scroll',
				removalDelay: 200, //delay removal by X to allow out-animation
				prependTo: $( '#content_wrapper' )
			} );
			
		} );
		
		function checkSubmit() {
			if ( document.getElementById( "search" ).value == "" ) {
				return false;
			} else {
				return true;
			}
		}
	</script>
</body>
</html>