<?php $current_file = basename("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>
<?php function getActiveUrl($filearray) { global $current_file; if(in_array($current_file, $filearray)) { echo 'class="current"'; } } ?>

<div class="sidebar-account">
	<div class="sidebar-bar-title">
		<h3>My Account</h3>
	</div>
	<div class="block-content">
		<ul>
			<li <?php getActiveUrl(["my-account.php"]); ?>><a href="my-account.php">Update Profile</a></li>
			<li <?php getActiveUrl(["address-book.php", "address-book-add.php", "address-book-update.php"]); ?>><a href="address-book.php">Address Book</a></li>
			<li <?php getActiveUrl(["my-orders.php", "my-orders-view.php"]); ?>><a href="my-orders.php">My Orders</a></li>
			<li <?php getActiveUrl(["wishlist.php"]); ?>><a href="wishlist.php">My Wishlist</a></li>
			<li <?php getActiveUrl(["reset-password.php"]); ?>><a href="reset-password.php">Reset Password</a></li>
			<li class="last"><a href="logout.php">Logout</a></li>
		</ul>
	</div>
</div>