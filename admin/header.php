<header class="navbar navbar-fixed-top bg-primary">
	<div class="navbar-branding">
		<a class="navbar-brand" href="index.php">
			<?php /*?><strong><?php echo $application_name; ?></strong><?php */?>
			<img src="../assets/images/logo-black.png" title="<?php echo $application_name; ?>" alt="<?php echo $application_name; ?>" class="center-block img-responsive" style="max-width: 77px;
    padding-top: 5px;">
		</a>
		<span id="toggle_sidemenu_l" class="ad ad-lines"></span>
	</div>
	<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
				<img src="assets/img/admin.png" alt="avatar" class="mw30 br64 mr15">
				Admin
				<span class="caret caret-tp hidden-xs"></span>
			</a>

			<ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
				<li class="list-group-item">
					<a href="<?php /*?>admin.php<?php */?>profile.php" class="animated animated-short fadeInUp">
						<span class="fa fa-gear"></span> <?php /*?>Account Settings<?php */?>Profile
					</a>
				</li>
				<li class="list-group-item">
					<a href="logout.php" class="animated animated-short fadeInUp">
						<span class="fa fa-power-off"></span> Logout
					</a>
				</li>
			</ul>
		</li>
	</ul>
</header>