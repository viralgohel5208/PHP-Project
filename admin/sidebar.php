<?php $current_file = basename("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>
<?php function getActiveUrl($filearray) { global $current_file; if(in_array($current_file, $filearray)) { echo 'class="active"'; } } ?>

<aside id="sidebar_left" class="nano nano-primary affix">
	<div class="sidebar-left-content nano-content">
		<ul class="nav sidebar-menu">
			<li class="sidebar-label pt20">Menu</li>
			
			<li <?php getActiveUrl(["index.php"]); ?>>
				<a href="index.php">
					<span class="fa fa-home"></span>
					<span class="sidebar-title">Dashboard</span>
				</a>
			</li>
			<?php if($role_id == 1) { ?>
			<li <?php getActiveUrl(["clients.php", "clients-add.php", "clients-update.php" ]); ?>>
				<a href="clients.php">
					<span class="fa fa-group"></span>
					<span class="sidebar-title">Clients</span>
				</a>
			</li>
			<li <?php getActiveUrl(["client-subscriptions.php", "client-subscriptions-add.php", "client-subscriptions-update.php", "subscription-history.php", "client-subscriptions-settings.php" ]); ?>>
				<a href="client-subscriptions.php">
					<span class="fa fa-check-square-o"></span>
					<span class="sidebar-title">Client Subscriptions</span>
				</a>
			</li>
			<li <?php getActiveUrl(["packages.php", "packages-add.php", "packages-update.php" ]); ?>>
				<a href="packages.php">
					<span class="fa fa-folder-open"></span>
					<span class="sidebar-title">Packages</span>
				</a>
			</li>
			<li <?php getActiveUrl(["sales-executives.php", "sales-executives-add.php", "sales-executives-update.php" ]); ?>>
				<a href="sales-executives.php">
					<span class="fa fa-dot-circle-o"></span>
					<span class="sidebar-title">Sales Executives</span>
				</a>
			</li>
			<li class="sidebar-label pt20">Settings & Details</li>
			<li <?php getActiveUrl(["settings.php", 'store-headquarter.php']); ?>>
				<a href="settings.php">
					<span class="fa fa-gear"></span>
					<span class="sidebar-title">Settings</span>
				</a>					
			</li>
			<?php } else if($role_id == 2) { ?>
			<?php if($app_id == 1) { ?>
			<li <?php getActiveUrl(["order-place.php",]); ?>>
				<a href="order-place.php">
					<span class="fa fa-shopping-cart"></span>
					<span class="sidebar-title">Add Order</span>
				</a>
			</li>
			<?php } ?>
			<li <?php getActiveUrl(["orders.php", "orders-invoice.php"]); ?>>
				<a href="orders.php">
					<span class="fa fa-shopping-cart"></span>
					<span class="sidebar-title">View Orders</span>
				</a>					
			</li>
			<li <?php getActiveUrl(["reports.php"]); ?>>
				<a href="reports.php">
					<span class="fa fa-bar-chart-o"></span>
					<span class="sidebar-title">Reports</span>
				</a>					
			</li>
			<li class="sidebar-label pt20">Customers</li>
			<li <?php getActiveUrl(["users.php", "users-add.php", "users-update.php" ]); ?>>
				<a href="users.php">
					<span class="fa fa-user"></span>
					<span class="sidebar-title">Users</span>
				</a>
			</li>
			<?php /*?><li <?php getActiveUrl(["broadcast-sms.php" ]); ?>>
				<a href="broadcast-sms.php">
					<span class="fa fa-mobile"></span>
					<span class="sidebar-title">Broadcast Sms</span>
				</a>     
			</li>
			<li <?php getActiveUrl(["newsletter.php", "newsletter-add.php", "newsletter-update.php" ]); ?>>
				<a href="newsletter.php">
					<span class="fa fa-rss"></span>
					<span class="sidebar-title">Newsletter</span>
				</a>
			</li><?php */?>
			<li class="sidebar-label pt20">Branches</li>
			<li <?php getActiveUrl(["stores.php", 'stores-add.php', 'stores-update.php', "stores-localities-add.php", "stores-localities-add.php" ]); ?>>
				<a href="stores.php">
					<span class="fa fa-map"></span>
					<span class="sidebar-title">Stores</span>
				</a>					
			</li>
			<li <?php getActiveUrl(["stores-admin.php", 'stores-admin-add.php', 'stores-admin-update.php']); ?>>
				<a href="stores-admin.php">
					<span class="fa fa-tasks"></span>
					<span class="sidebar-title">Add Store Admin</span>
				</a>					
			</li>
			<li <?php getActiveUrl(["stores-admin-assign.php", 'stores-admin-assign-add.php', 'stores-admin-assign-update.php']); ?>>
				<a href="stores-admin-assign.php">
					<span class="fa fa-certificate"></span>
					<span class="sidebar-title">Assign Store Admin</span>
				</a>					
			</li>
			<li class="sidebar-label pt20">Products</li>
			<li <?php getActiveUrl(["categories.php", "categories-add.php", "categories-update.php" ]); ?>>
				<a href="categories.php">
					<span class="fa fa-tags"></span>
					<span class="sidebar-title">Categories</span>
				</a>
			</li>
			<li <?php getActiveUrl(["products.php", "products-add.php", "products-update.php", "products-offers.php", "products-variants.php", "products-variants-add.php", "products-variants-update.php" ]); ?>>
				<a href="products.php">
					<span class="fa fa-tags"></span>
					<span class="sidebar-title">Products</span>
				</a>
			</li>
			<li <?php getActiveUrl(["brands.php", 'brands-add.php', 'brands-update.php']); ?>>
				<a href="brands.php">
					<span class="fa fa-toggle-right"></span>
					<span class="sidebar-title">Brands</span>
				</a>					
			</li>
			<li>
				<a class="accordion-toggle <?php if($current_file == "products-import.php" || $current_file == "products-photos.php") { echo 'menu-open'; } ?>" href="#">
					<span class="fa fa-file-text"></span>
					<span class="sidebar-title">Import Products</span>
					<span class="caret"></span>
				</a>
				<ul class="nav sub-nav">
					<li <?php getActiveUrl(["products-import.php"]); ?>>
						<a href="products-import.php">
						<span class="glyphicon glyphicon-book"></span> Import CSV </a>
					</li>
					<li <?php getActiveUrl(["products-photos.php"]); ?>>
						<a href="products-photos.php">
						<span class="glyphicon glyphicon-picture"></span> Products Photos </a>
					</li>
				</ul>
			</li>
			
			<li class="sidebar-label pt20">Settings & Details</li>
			<li>
				<a class="accordion-toggle <?php if($current_file == "app-details.php" || $current_file == "info-about.php" || $current_file == "info-terms-conditions.php" || $current_file == "info-privacy-policy.php" || $current_file == "banners.php" || $current_file == "banners-add.php" || $current_file == "banners-update.php" || $current_file == "testimonials.php" || $current_file == "testimonials-add.php" || $current_file == "testimonials-update.php") { echo 'menu-open'; } ?>" href="#">
					<span class="fa fa-pencil-square"></span>
					<span class="sidebar-title">Other Details</span>
					<span class="caret"></span>
				</a>
				<ul class="nav sub-nav">
					<li <?php getActiveUrl(["app-details.php" ]); ?>>
						<a href="app-details.php">
							<span class="fa fa-square-o"></span>
							<span class="sidebar-title">App Details</span>
						</a>
					</li>
					<li <?php getActiveUrl(["sliders.php", 'sliders-add.php', 'sliders-update.php']); ?>>
						<a href="sliders.php">
							<span class="fa fa-square-o"></span>
							<span class="sidebar-title">Website Sliders</span>
						</a>					
					</li>
					<li <?php getActiveUrl(["banners.php", 'banners-add.php', 'banners-update.php']); ?>>
						<a href="banners.php">
							<span class="fa fa-square-o"></span>
							<span class="sidebar-title">App Banners</span>
						</a>					
					</li>
					<li <?php getActiveUrl(["testimonials.php", 'testimonials-add.php', 'testimonials-update.php']); ?>>
						<a href="testimonials.php">
							<span class="fa fa-square-o"></span>
							<span class="sidebar-title">Testimonials</span>
						</a>					
					</li>
					<li <?php getActiveUrl(["info-about.php"]); ?>>
						<a href="info-about.php">
						<span class="fa fa-square-o"></span> About Us </a>
					</li>
					<li <?php getActiveUrl(["info-terms-conditions.php"]); ?>>
						<a href="info-terms-conditions.php">
						<span class="fa fa-square-o"></span> Terms Conditions</a>
					</li>
					<li <?php getActiveUrl(["info-privacy-policy.php"]); ?>>
						<a href="info-privacy-policy.php">
						<span class="fa fa-square-o"></span> Privacy Policy</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="accordion-toggle <?php if($current_file == "dashboard-settings.php" || $current_file == "settings.php" || $current_file == "store-headquarter.php" || $current_file == "cities.php" || $current_file == "cities-add.php" || $current_file == "cities-update.php") { echo 'menu-open'; } ?>" href="#">
					<span class="fa fa-cog"></span>
					<span class="sidebar-title">Settings</span>
					<span class="caret"></span>
				</a>
				<ul class="nav sub-nav">
					<li <?php getActiveUrl(["dashboard-settings.php"]); ?>>
						<a href="dashboard-settings.php">
							<span class="fa fa-square-o"></span>
							<span class="sidebar-title">Dashboard Settings</span>
						</a>
					</li>
					<li <?php getActiveUrl(["cities.php", "cities-add.php", "cities-update.php"]); ?>>
						<a href="cities.php">
							<span class="fa fa-location-arrow"></span>
							<span class="sidebar-title">Cities</span>
						</a>					
					</li>
					<li <?php getActiveUrl(["settings.php", "store-headquarter.php"]); ?>>
						<a href="settings.php">
							<span class="fa fa-square-o"></span>
							<span class="sidebar-title">Settings</span>
						</a>					
					</li>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<div class="sidebar-toggle-mini">
			<a href="#"><span class="fa fa-sign-out"></span></a>				
		</div>
	</div>
</aside>