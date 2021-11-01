<div id="mobile-menu">
		<ul>
			<li><a href="index.php" class="home1">Home</a></li>
			<?php
			$website_menu = $_SESSION['website_menu'];
			foreach($website_menu as $item)
			{
				/*echo '<li class="mt-root demo_custom_link_cms">
						<div class="mt-root-item">
							<a href="categories.php?cat='.safe_encode($item['id']).'">
								<div class="title title_font"><span class="title-text">'.$item['category_name'].'</span>
								</div>
							</a>
						</div>
					</li>';*/
				echo '<li><a href="categories.php?cat='.safe_encode($item['id']).'">'.$item['category_name'].'</a></li>';
			}
			?>
			<li><a href="categories.php" class="home1">All Categories</a></li>
		</ul>
	</div>