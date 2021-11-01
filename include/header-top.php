<header>
	<div class="header-container">
		<div class="header-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 language-currency-wrapper">
						<!-- Default Welcome Message -->
						<?php if(isset($_SESSION["cu_user_name"])) { ?>
						<div class="hidden-xs">Welcome <?php echo $_SESSION["cu_user_name"]; ?> </div>
						<?php } ?>
						<!-- End Default Welcome Message -->
					</div>
					<!-- top links -->
					<div class="headerlinkmenu col-lg-8 col-md-7 col-sm-7 col-xs-6">
						<div class="links">
							<?php if(!isset($_SESSION["cu_user_name"])) { ?>
							<div class="login">
								<a href="login.php"><i class="fa fa-unlock-alt"></i><span class="hidden-xs">Log In</span></a>
							</div>
							<div class="login">
								<a href="register.php"><i class="fa fa-user-plus"></i><span class="hidden-xs">Register</span></a>
							</div>
							<?php }else{ ?>
							<div class="myaccount">
								<a title="My Account" href="my-account.php"><i class="fa fa-user"></i><span class="hidden-xs">My Account</span></a>
							</div>
							<div class="wishlist">
								<a title="My Wishlist" href="wishlist.php"><i class="fa fa-heart"></i><span class="hidden-xs">Wishlist</span></a>
							</div>
							<div class="login">
								<a href="logout.php"><i class="fa fa-unlock-alt"></i><span class="hidden-xs">Logout</span></a>
							</div>
							<?php } ?>
						</div>
						<!-- Search -->
						<div class="top-search">
							<div class="block-icon pull-right"> <a data-target=".bs-example-modal-lg" data-toggle="modal" class="search-focus dropdown-toggle links"> <i class="fa fa-search"></i> </a>
								<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
												<h4 id="gridSystemModalLabel" class="modal-title">Search Products</h4>
											</div>
											<div class="modal-body">
												<form class="navbar-form" action="products-search.php">
													<div id="search">
														<div class="input-group">
															<input name="product-name" placeholder="Search" class="form-control" type="text">
															<button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- End Search -->
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<!-- Header Logo -->
					<div class="logo">
						<a href="index.php" class="logo-color">
							<?php if(isset($_SESSION['logo_top'])) { ?>
								<img src="uploads/store-<?= $app_id ?>/logo/<?php echo $_SESSION['logo_top']; ?>">
							<?php }else{ echo $application_name; } ?>
						</a>
					</div>
					<!-- End Header Logo -->
				</div>
				<!--support client-->
				<div class="col-xs-8 col-sm-5 col-md-6 hidden-xs">
					<?php /*?><div class="support-client">
						<div class="row">
							<div class="col-md-6 col-sm-10">
								<div class="box-container free-shipping">
									<div class="box-inner">
										<h2>Free shipping</h2>
										<p>On order over $199</p>
									</div>
								</div>
							</div>
							<div class="col-sm-6 hidden-sm">
								<div class="box-container money-back">
									<div class="box-inner">
										<h2>Money back 100%</h2>
										<p>Within 30 Days after delivery</p>
									</div>
								</div>
							</div>
						</div>
					</div><?php */?>
				</div>
				<!-- top cart -->

				<div class="col-lg-3 col-xs-12 top-cart">
					<div class="mm-toggle-wrap">
						<div class="mm-toggle"> <i class="fa fa-align-justify"></i><span class="mm-label">Menu</span> </div>
					</div>
					<div class="top-cart-contain">
						<div class="mini-cart">
							<?php if(isset($_SESSION['cust_cart'])) { $shop_items = count($_SESSION['cust_cart']); } else { $shop_items = 0; } ?>
							<div class="basket"> <a href="shopping-cart.php"><i class="fa fa-shopping-cart"></i><span class="cart-title">Shopping Cart (<span id="shop_items"><?php echo $shop_items; ?></span>)</span></a>
							</div>
						</div>
						
						<?php /*?><div class="mini-cart">
							<div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle"> <a href="#"><i class="fa fa-shopping-cart"></i><span class="cart-title">Shopping Cart (4)</span></a>
							</div>
							<div>
								<div class="top-cart-content">
									<div class="block-subtitle">Recently added item(s)</div>
									<ul id="cart-sidebar" class="mini-products-list">
										<li class="item odd"> <a href="#" title="Ipsums Dolors Untra" class="product-image"><img src="images/products/img07.jpg" alt="Lorem ipsum dolor" width="65"></a>
											<div class="product-details"> <a href="#" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
												<p class="product-name"><a href="#">Lorem ipsum dolor sit amet Consectetur</a> </p>
												<strong>1</strong> x <span class="price">$20.00</span> </div>
										</li>
										<li class="item even"> <a href="#" title="Ipsums Dolors Untra" class="product-image"><img src="images/products/img18.jpg" alt="Lorem ipsum dolor" width="65"></a>
											<div class="product-details"> <a href="#" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
												<p class="product-name"><a href="#">Consectetur utes anet adipisicing elit</a> </p>
												<strong>1</strong> x <span class="price">$230.00</span> </div>
										</li>
										<li class="item last odd"> <a href="#" title="Ipsums Dolors Untra" class="product-image"><img src="images/products/img10.jpg" alt="Lorem ipsum dolor" width="65"></a>
											<div class="product-details"> <a href="#" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
												<p class="product-name"><a href="#">Sed do eiusmod tempor incidist</a> </p>
												<strong>2</strong> x <span class="price">$420.00</span> </div>
										</li>
									</ul>
									<div class="top-subtotal">Subtotal: <span class="price">$520.00</span>
									</div>
									<div class="actions">
										<button class="btn-checkout" type="button"><i class="fa fa-check"></i><span>Checkout</span></button>
										<button class="view-cart" type="button"><i class="fa fa-shopping-cart"></i> <span>View Cart</span></button>
									</div>
								</div>
							</div>
						</div><?php */?>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>