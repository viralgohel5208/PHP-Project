<section id="contact" class="gray">
	<div class="container">

		<!-- Begin page header-->
		<div class="page-header-wrapper">
			<div class="container">
				<div class="page-header text-center wow fadeInUp">
					<h2>Contact <span class="text-main">Us</span></h2>
					<div class="divider divider-icon divider-md">&#x268A;&#x268A; &#x2756; &#x268A;&#x268A;</div>
					<!--<p class="lead text-gray"> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. sed diam nonummy nibh euismod tincidunt.</p>-->
				</div>
			</div>
		</div>
		<!-- End page header-->
		
		<?php 
		$get_admin_contact_footer = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM app_details WHERE app_id = $app_id"));
		?>

		<div class="row">
			<div class="col-sm-4 adress-element wow zoomIn"> <i class="fa fa-home fa-2x"></i>
				<h3>Our Address</h3>
				<span class="font-l"><?php echo $get_admin_contact_footer["address"]; ?></span> </div>
			<div class="col-sm-4 adress-element wow zoomIn"> <i class="fa fa-comment fa-2x"></i>
				<h3>Our mail</h3>
				<span class="font-l"><a href="mailto:<?php echo $get_admin_contact_footer["email_1"]; ?>"><?php echo $get_admin_contact_footer["email_1"]; ?></a></span> </div>
			<div class="col-sm-4 adress-element wow zoomIn"> <i class="fa fa-phone fa-2x"></i>
				<h3>Our phone</h3>
				<span class="font-l"><?php echo $get_admin_contact_footer["mobile_1"]; ?></span> </div>
		</div>
	</div>
</section>