<footer style="padding-top: 0">
	<?php /*?><div class="container footer-menu">
		<div class="row">
			<div class="col-sm-12 col-xs-12 col-lg-4">
				<div class="footer-logo"><a href="index.php">
					<?php if(isset($_SESSION['logo_bottom'])) { ?>
					<img alt="logo" src="uploads/store-<?= $app_id ?>/logo/<?php echo $_SESSION['logo_bottom']; ?>">
					<?php }else{ echo $application_name; } ?>
					</a>
				</div>
				<?php
				$q_footer = mysqli_query($link,"select * from `app_info` WHERE `app_id` = '$app_id'");
				if(mysqli_num_rows($q_footer) > 0){
					$row = mysqli_fetch_assoc($q_footer);
				}
				?>
				<p>
				<?php 
				if(strlen(strip_tags($row['about_us']))>280) 
				{	
					echo substr(strip_tags($row['about_us']),0,strpos(strip_tags($row['about_us'])," ",280))."..."; 
				}
				else
				{
					echo $row['about_us'];
				}
				?>		
				<a href="about-us.php">Read more</a>
				</p>
			</div>
			<div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
				<div class="footer-links">
					<h3 class="links-title">Information<a class="expander visible-xs" href="#TabBlock-1">+</a></h3>
					<div class="tabBlock" id="TabBlock-1">
						<ul class="list-links list-unstyled">
							<li><a href="#s">Delivery Information</a>
							</li>
							<li><a href="#">Discount</a>
							</li>
							<li><a href="sitemap.html">Sitemap</a>
							</li>
							<li><a href="#">Privacy Policy</a>
							</li>
							<li><a href="faq.html">FAQs</a>
							</li>
							<li><a href="#">Terms &amp; Condition</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
				<div class="footer-links">
					<h3 class="links-title">Categories<a class="expander visible-xs" href="#TabBlock-2">+</a></h3>
					<div class="tabBlock" id="TabBlock-2">
						<ul class="list-links list-unstyled">
							<li><a href="#">Women</a>
							</li>
							<li><a href="#">Men</a>
							</li>
							<li><a href="#">Electronics</a>
							</li>
							<li><a href="#">Clothing</a>
							</li>
							<li><a href="#">Lookbook</a>
							</li>
							<li><a href="#">Accessories </a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
				<div class="footer-links">
					<h3 class="links-title">Insider<a class="expander visible-xs" href="#TabBlock-3">+</a></h3>
					<div class="tabBlock" id="TabBlock-3">
						<ul class="list-links list-unstyled">
							<li> <a href="blog.html">Blog</a> </li>
							<li> <a href="#">News</a> </li>
							<li> <a href="#">Trends</a> </li>
							<li> <a href="about_us.html">About Us</a> </li>
							<li> <a href="contact_us.html">Contact Us</a> </li>
							<li> <a href="#">My Orders</a> </li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
				<div class="footer-links">
					<h3 class="links-title">Information<a class="expander visible-xs" href="#TabBlock-4">+</a></h3>
					<div class="tabBlock" id="TabBlock-4">
						<ul class="list-links list-unstyled">
							<li><a href="about-us.php">About Us</a></li>
							<li><a href="privacy-policy.php">Privacy Policy</a></li>
							<li><a href="terms-condition.php">Terms &amp; Condition</a>
							<li><a href="contact-us.php">Contact Us</a>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div><?php */?>
	
	<?php //require_once "footer-newsletter.php"; ?>
	<?php /*?><div style="margin: 50px 0;"></div><?php */?>
	<div class="footer-newsletter" style="padding: 30px; margin-top: 0">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a style="margin: 0 20px" title="About Us" href="about-us.php">About Us</a>
					<a style="margin: 0 20px" title="Privacy Policy" href="privacy-policy.php">Privacy Policy</a>
					<a style="margin: 0 20px" title="Terms &amp; Condition" href="terms-condition.php">Terms &amp; Condition</a>
					<a style="margin: 0 20px" title="Contact Us" href="contact-us.php">Contact Us</a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="footer-coppyright">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-xs-12 coppyright"> Copyright © <?php echo date("Y");?> <a href="#"> <?php echo $application_name; ?> </a>. All Rights Reserved. </div>
				<div class="social col-sm-6 col-xs-12">
					<ul class="inline-mode">
						<?php if(isset($_SESSION['facebook_url'])) { ?>
						<li class="social-network fb"><a title="Connect us on Facebook" target="_blank" href="<?php echo $_SESSION['facebook_url']; ?>"><i class="fa fa-facebook"></i></a>
						</li>
						<?php } if(isset($_SESSION['google_plus'])) { ?>
						<li class="social-network googleplus"><a title="Connect us on Google+" target="_blank" href="<?php echo $_SESSION['google_plus']; ?>"><i class="fa fa-google-plus"></i></a>
						</li>
						<?php } if(isset($_SESSION['twitter_url'])) { ?>
						<li class="social-network tw"><a title="Connect us on Twitter" target="_blank" href="<?php echo $_SESSION['twitter_url']; ?>"><i class="fa fa-twitter"></i></a>
						</li>
						<?php } if(isset($_SESSION['instagram_url'])) { ?>
						<li class="social-network rss"><a title="Connect us on Instagram" target="_blank" href="<?php echo $_SESSION['instagram_url']; ?>"><i class="fa fa-instagram"></i></a>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>