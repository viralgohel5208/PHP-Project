<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$page_title = "Product Photos";

// For pagination
$adjacents = 3;
$limit = 20; //how many items to show per page

if(isset($_POST['delete_id']))
{
	$id = escapeInputValue($_POST['delete_id']);
	
	if($id == "all")
	{
		$query_3 = "DELETE FROM `products_photos` WHERE app_id = $app_id" ;

		$result_3 = mysqli_query( $link, $query_3);

		if($result_3)
		{
			$directory = "uploads/products-photos/";
			foreach(glob("{$directory}/*") as $file)
			{
				unlink($file);
			}
			//rmdir($directory);

			$success = "Item has been deleted successfully";
		}
		else
		{
			$error = $sww;
		}
	}
	else
	{
		$query_3 = "SELECT id, file_name FROM `products_photos` WHERE id = '" . $id . "' AND app_id = $app_id" ;

		$result_3 = mysqli_query( $link, $query_3);

		if($result_3)
		{
			if ( mysqli_num_rows( $result_3 ) > 0 )
			{
				$row_3 = mysqli_fetch_assoc( $result_3 );

				$file_name = $row_3['file_name'];

				if($file_name != "" && file_exists("uploads/products-photos/" . $file_name))
				{
					@unlink("uploads/products-photos/".$file_name);
				}

				$result = "DELETE FROM products_photos WHERE id = '" . $id . "'";

				if(mysqli_query($link, $result))
				{
					$success = "Item has been deleted successfully";
				}
				else
				{
					$error = $sww;
				}
			}
		}
	}
	header("Location:products-photos.php");
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
	<link rel="stylesheet" type="text/css" href="assets/css/dropzone.css">
	<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	<style>
	body.gallery-page #mix-container{ text-align:inherit; }
	.mix.label1.folder1 { padding: 3px; }
	body.gallery-page #mix-container .mix { width: 10%; }
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
				<div class="topbar-right">
					<div class="ml15 ib va-m" id="">
						<?php /*?><a href="products-add.php" class="pl5 btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add New
						</a>
						<a href="products-sort.php" class="pl5 btn btn-default btn-sm" style="margin-left: 20px;">
							<i class="fa fa-signal"></i> Sort Order
						</a><?php */?>
						<a href="products-photos.php" class="pl5 btn btn-default btn-sm" style="margin-left: 20px;">
							<i class="fa fa-exchange"></i> Refresh
						</a>
					</div>
				</div>
			</header>

			<section id="content" class="table-layout animated fadeIn">

				<div class="">
					<div class="pv15 br-b br-light">
						<div class="row">
							<div class="col-xs-12">
								
								<div class="panel panel-primary">
									<div class="panel-body">
										<form action="ajax-products-photos.php" class="dropzone" id="my-awesome-dropzone">
										<div class="dz-message needsclick" style="font-size: 18px;">
										Drop files here or click to upload.<br>
										</div>
										</form>
									</div>
								</div>
								
								<?php /*?><div class="mix-controls">
									<form class="controls" id="select-filters" method="get" onSubmit="return checkSubmit()" autocomplete="off"
									>
										<div class="form-group has-primary">

											<div class="col-lg-7">
												<span class="append-icon right">
												<i class="fa fa-search"></i>
												</span>
											
												<input type="text" name="image" class="form-control" id="search"value="<?php if(isset($_REQUEST['image']) && $_REQUEST['image'] != "") { echo $_REQUEST['image']; } ?>">
											</div>
											<div class="col-lg-1">
												<button type="submit" name="search" class="btn btn-hover btn-block btn-primary">Search</button>
											</div>
										</div>
									</form>

								</div><?php */?>

							</div>

						</div>

					</div>
					
					<?php

					if(isset($_REQUEST['image']) && $_REQUEST['image'] != "")
					{
						$search_str = $_REQUEST['image'];
						$sql = mysqli_query($link, "SELECT * FROM products_photos WHERE app_id = $app_id AND (title LIKE '%$search_str%' OR name LIKE '%$search_str%' OR description LIKE '%$search_str%')");
						$targetpage = "photos.php?image=".$_REQUEST['image']."&page="; //your file name
					}
					else
					{
						$query = "SELECT * FROM products_photos WHERE app_id = $app_id";
						$sql = mysqli_query($link, $query);
						$targetpage = "products-photos.php?page="; //your file name
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
						$query_photos = "SELECT * FROM products_photos WHERE app_id = $app_id AND (title LIKE '%$search_str%' OR name LIKE '%$search_str%' OR description LIKE '%$search_str%') ORDER BY id DESC LIMIT $start ,$limit";
						$res_photos = mysqli_query($link, $query_photos);
					}
					else
					{
						$res_photos = mysqli_query($link, "SELECT * FROM products_photos WHERE app_id = $app_id ORDER BY id DESC LIMIT $start ,$limit");
					}
					
					if(mysqli_num_rows($res_photos) == 0)
					{
						echo '<div class="text-danger" style="color: #e9573f; margin-left: 25px; font-size: 16px; margin-top: 50px;">No records found</div>';
					}
					else
					{
						
						echo '<a onclick="delete_func(\'all\')" class="btn btn-sm btn-danger" style="float: right; margin: 10px 20px 10px 0; padding: 5px 30px;">Delete All Images</a>';
					echo '<div class="clearfix"></div>';
					if(isset($_REQUEST['image']) && $_REQUEST['image'] != "")
					{
						echo '<div class="text-default" style="margin-left: 25px; font-size: 16px; margin-top: 20px;">Search results for: '.$search_str.'</div>';
					}
					$i = 1;
					echo '<div id="mix-container">';
					while($row_photos = mysqli_fetch_assoc($res_photos)) {  
					?>

						<div class="mix label1 folder1">
							<div class="panel p6 pbn">
								<div class="of-h">
									<img src="uploads/products-photos/<?php echo $row_photos['file_name']; ?>" class="img-responsive" title="<?php echo $row_photos['title']; ?>" style="">
									<div class="row table-layout">
										<div class="col-xs-8 va-m pln">
											<h6>
												<?php echo $row_photos['file_name']; ?> <br/><br/>
												<?php echo formatDate($row_photos['added_date']); ?>
											</h6>
										</div>
										<div class="col-xs-4 text-right va-m prn">
											<a onclick="delete_func('<?php echo $row_photos['id']; ?>')" style="cursor: pointer" title="Delete" ><span class="fa fa-trash fs12 text-danger"></span></a>
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
				</div>
			</section>
		</section>
	</div>
	
	<form id="delete_form" action="" method="post" style="display: hidden">
		<input type="hidden" id="delete_id" name="delete_id" value="">
	</form>

	<script src="vendor/jquery/jquery-1.11.1.min.js"></script>
	<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script src="vendor/plugins/mixitup/jquery.mixitup.min.js"></script>
	<script src="vendor/plugins/magnific/jquery.magnific-popup.js"></script>
	<script src="vendor/plugins/fileupload/fileupload.js"></script>
	<script src="vendor/plugins/holder/holder.min.js"></script>
	<script src="assets/js/dropzone.js"></script>
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
		
		function delete_func(x)
		{
			if (confirm("Are you sure you want to delete?"))
			{
				$("#delete_id").val(x);
				$("#delete_form").submit();
			}
		}
	</script>
</body>
</html>