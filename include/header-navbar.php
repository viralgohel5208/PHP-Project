<nav>
	<div class="stick-logo"><a title="e-commerce" href="index.php">
		<?php if(isset($_SESSION['logo_center'])) { ?>
			<img alt="logo" src="uploads/store-<?= $app_id ?>/logo/<?php echo $_SESSION['logo_center']; ?>">
		<?php }else{ echo $application_name; } ?>
		</a> </div>
	<div class="container">
		<div class="row">
			<div class="mtmegamenu">
				<ul>
					<li class="mt-root demo_custom_link_cms">
						<div class="mt-root-item">
							<a href="index.php">
								<div class="title title_font"><span class="title-text">Home</span>
								</div>
							</a>
						</div>
					</li>
					<?php
					$website_menu = $_SESSION['website_menu'];
					foreach($website_menu as $item)
					{
						echo '<li class="mt-root demo_custom_link_cms">
								<div class="mt-root-item">
									<a href="categories.php?cat='.safe_encode($item['id']).'">
										<div class="title title_font"><span class="title-text">'.$item['category_name'].'</span>
										</div>
									</a>
								</div>
							</li>';
					}
					?>
					
					<li class="mt-root demo_custom_link_cms">
						<div class="mt-root-item">
							<a href="categories.php">
								<div class="title title_font"><span class="title-text">All Categories</span>
								</div>
							</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>