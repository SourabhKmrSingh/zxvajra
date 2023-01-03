<?php
$headerwishlistResult = $db->view('wishlistid', 'rb_wishlist', 'wishlistid', "and regid = '$regid' and status = 'active'");
$headercartResult = $db->view('cartid', 'rb_cart', 'cartid', "and regid = '$regid' and status = 'active'");
?>
<header class="header-section">
	<!--<div class="header-top">
		<div class="container-fluid">
			<div class="ht-right">
				<a href="#" class="login-panel"><i class="fa fa-user"></i>Login / Signup</a>
			</div>
		</div>
	</div>-->
	<div class="container-fluid">
		<div class="inner-header">
			<div class="row">
				<div class="col-lg-2 col-md-2 order-1 order-sm-1">
					<div class="logo pt-2">
						<?php if($configRow['logo'] != "") { ?>
							<a href="<?php echo BASE_URL; ?>">
								<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($configRow['logo']); ?>" alt="<?php echo $validation->db_field_validate($configRow['meta_title']); ?>" />
							</a>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 order-3 order-sm-2 mb-3 mb-sm-0">
					<form action="<?php echo BASE_URL."products".SUFFIX; ?>" method="get">
						<div class="advanced-search">
							<select name="cat" class="category-btn">
								<option value="">Categories</option>
								<?php
								$searchcategoryResult = $db->view("*", "rb_categories", "categoryid", "and status='active'", "order_custom desc", "25");
								if($searchcategoryResult['num_rows'] >= 1)
								{
									foreach($searchcategoryResult['result'] as $searchcategoryRow)
									{
								?>
									<option value="<?php echo $validation->db_field_validate($searchcategoryRow['title_id']); ?>" <?php if($searchcategoryRow['title_id'] == $cat) echo "selected"; ?>><?php echo $validation->db_field_validate($searchcategoryRow['title']); ?></option>
								<?php
									}
								}
								?>
							</select>
							<div class="input-group">
								<input type="text" name="q" value="<?php echo $q; ?>" placeholder="What do you need?" />
								<button type="submit"><i class="ti-search"></i></button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-4 text-right col-md-3 order-2 order-sm-3">
					<ul class="nav-right">
						<?php if($_SESSION['mobile'] != "" and $_SESSION['regid'] != "") { ?>
							<li class="heart-icon">
								<a href="<?php echo BASE_URL.'home'.SUFFIX; ?>">
									<i class="fa fa-user"></i>
								</a>
								<a href="<?php echo BASE_URL.'home'.SUFFIX; ?>"><p class="header_text">Hi <?php echo $_SESSION['first_name']; ?>!</p></a>
							</li>
							<li class="cart-icon logout_header">
								<a href="<?php echo BASE_URL.'logout'.SUFFIX; ?>" title="Logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
								<a href="<?php echo BASE_URL.'logout'.SUFFIX; ?>"><p class="header_text">Logout</p></a>
							</li>
						<?php } else { ?>
							<li class="heart-icon">
								<a href="<?php echo BASE_URL.'login'.SUFFIX; ?>">
									<i class="fa fa-user"></i>
								</a>
								<a href="<?php echo BASE_URL.'login'.SUFFIX; ?>"><p class="header_text">Sign in</p></a>
								<a href="<?php echo BASE_URL.'register'.SUFFIX; ?>"><p class="header_text">/ Sign up</p></a>
							</li>
						<?php } ?>
						<li class="heart-icon">
							<a href="<?php echo BASE_URL.'wishlist'.SUFFIX; ?>">
								<i class="icon_heart_alt"></i>
								<span><?php echo $headerwishlistResult['num_rows']; ?></span>
							</a>
							<a href="<?php echo BASE_URL.'wishlist'.SUFFIX; ?>"><p class="header_text">Wishlist</p></a>
						</li>
						<li class="cart-icon">
							<a href="<?php echo BASE_URL.'cart'.SUFFIX; ?>">
								<i class="fa fa-shopping-cart" aria-hidden="true"></i>
								<span><?php echo $headercartResult['num_rows']; ?></span>
							</a>
							<a href="<?php echo BASE_URL.'cart'.SUFFIX; ?>"><p class="header_text">Cart</p></a>
						</li>
					</ul>
					<div id="mobile-menu-wrap"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="nav-item">
		<div class="container-fluid">
			<div class="nav-depart">
				<div class="depart-btn">
					<i class="ti-menu"></i>
					<span>All Categories</span>
					<ul class="depart-hover">
						<?php
						$menucategoryResult = $db->view("*", "rb_categories", "categoryid", "and status='active'", "order_custom desc", "15");
						if($menucategoryResult['num_rows'] >= 1)
						{
							foreach($menucategoryResult['result'] as $menucategoryRow)
							{
								if($menucategoryRow['url'] == "#")
								{
									$menucategory_url = "#";
									$menucategory_url_target = "";
								}
								else if($menucategoryRow['url'] != "http://www." and $menucategoryRow['url'] != "https://www." and $menucategoryRow['url'] != "")
								{
									if(substr($menucategoryRow['url'], 0, 7) == 'http://' || substr($menucategoryRow['url'], 0, 8) == 'https://')
									{
										$menucategory_url = $validation->db_field_validate($menucategoryRow['url']);
										$menucategory_url_target = $validation->db_field_validate($menucategoryRow['url_target']);
									}
									else
									{
										$menucategory_url = BASE_URL."".$validation->db_field_validate($menucategoryRow['url']);
										$menucategory_url_target = $validation->db_field_validate($menucategoryRow['url_target']);
									}
								}
								else
								{
									$menucategory_url = BASE_URL.'products/?cat='.$validation->db_field_validate($menucategoryRow['title_id'])."";
									$menucategory_url_target = "";
								}
								
								$menucategoryid = $validation->db_field_validate($menucategoryRow['categoryid']);
								$menusubcategoryResult = $db->view('*', 'rb_subcategories', 'subcategoryid', "and categoryid = '$menucategoryid' and status='active'", "order_custom desc", "15");
						?>
							<li><a href="<?php echo $menucategory_url; ?>" target="<?php echo $menucategory_url_target; ?>"><?php echo $validation->db_field_validate($menucategoryRow['title']); ?></a>
								<?php
								if($menusubcategoryResult['num_rows'] >= 1)
								{
									echo '<ul class="depart-dropdown">';
									foreach($menusubcategoryResult['result'] as $menusubcategoryRow)
									{
										if($menusubcategoryRow['url'] == "#")
										{
											$menusubcategory_url = "#";
											$menusubcategory_url_target = "";
										}
										else if($menusubcategoryRow['url'] != "http://www." and $menusubcategoryRow['url'] != "https://www." and $menusubcategoryRow['url'] != "")
										{
											if(substr($menusubcategoryRow['url'], 0, 7) == 'http://' || substr($menusubcategoryRow['url'], 0, 8) == 'https://')
											{
												$menusubcategory_url = $validation->db_field_validate($menusubcategoryRow['url']);
												$menusubcategory_url_target = $validation->db_field_validate($menusubcategoryRow['url_target']);
											}
											else
											{
												$menusubcategory_url = BASE_URL."".$validation->db_field_validate($menusubcategoryRow['url']);
												$menusubcategory_url_target = $validation->db_field_validate($menusubcategoryRow['url_target']);
											}
										}
										else
										{
											$menusubcategory_url = BASE_URL.'products/?cat='.$validation->db_field_validate($menucategoryRow['title_id']).'&subcat='.$validation->db_field_validate($menusubcategoryRow['title_id']);
											$menusubcategory_url_target = "";
										}
								?>
									<li><a href="<?php echo $menusubcategory_url; ?>" target="<?php echo $menusubcategory_url_target; ?>" <?php if($menusubcategory_url_target == "_blank") echo "rel='noopener noreferrer'"; ?>><?php echo $validation->db_field_validate($menusubcategoryRow['title']); ?></a></li>
								<?php
									}
									echo '</ul>';
								}
								?>
							</li>
						<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
			<div class="float-right d-sm-none d-md-none d-lg-none d-block pt-2">
				<?php if($_SESSION['mobile'] != "" and $_SESSION['regid'] != "") { ?>
					<a href="<?php echo BASE_URL.'home'.SUFFIX; ?>" style="color:#000000;"><i class="fa fa-user"></i> Hi <?php echo $_SESSION['first_name']; ?>!</a>
				<?php } else { ?>
					<a href="<?php echo BASE_URL.'login'.SUFFIX; ?>" style="color:#000000;"><i class="fa fa-user"></i> Sign in</a>
				<?php } ?>
			</div>
			<nav class="nav-menu mobile-menu">
				<ul>
					<?php
					$menuResult = $db->view('pageid,title,title_id,url,url_target', 'rb_pages', 'pageid', "and main_menu='0' and sub_menu='0' and order_custom!='0' and status='active'", 'order_custom asc', '8');
					if($menuResult['num_rows'] >= 1)
					{
						foreach($menuResult['result'] as $menuRow)
						{
							if($menuRow['url'] == "#")
							{
								$menu_url = "#";
								$menu_url_target = "";
							}
							else if($menuRow['url'] != "http://www." and $menuRow['url'] != "https://www." and $menuRow['url'] != "")
							{
								if(substr($menuRow['url'], 0, 7) == 'http://' || substr($menuRow['url'], 0, 8) == 'https://')
								{
									$menu_url = $validation->db_field_validate($menuRow['url']);
									$menu_url_target = $validation->db_field_validate($menuRow['url_target']);
								}
								else
								{
									$menu_url = BASE_URL."".$validation->db_field_validate($menuRow['url']);
									$menu_url_target = $validation->db_field_validate($menuRow['url_target']);
								}
							}
							else
							{
								$menu_url = BASE_URL."page/".$validation->db_field_validate($menuRow['title_id'])."/";
								$menu_url_target = $validation->db_field_validate($menuRow['url_target']);
							}
							
							$menuid = $validation->db_field_validate($menuRow['pageid']);
							$submenuResult = $db->view('pageid,title,title_id,url,url_target', 'rb_pages', 'pageid', "and main_menu='$menuid' and sub_menu='0' and order_custom!='0' and status='active'", 'order_custom asc', '8');
					?>
						<li class="<?php if($menuRow['title_id'] == "mlm-login") echo "active"; ?>">
							<a href="<?php echo $menu_url; ?>" target="<?php echo $menu_url_target; ?>" <?php if($menu_url_target == "_blank") echo "rel='noopener noreferrer'"; ?>><?php echo $validation->db_field_validate($menuRow['title']); ?></a>
							<?php
							if($submenuResult['num_rows'] >= 1)
							{
								echo '<ul class="dropdown">';
								foreach($submenuResult['result'] as $submenuRow)
								{
									if($submenuRow['url'] == "#")
									{
										$menu_url = "#";
										$menu_url_target = "";
									}
									else if($submenuRow['url'] != "http://www." and $submenuRow['url'] != "https://www." and $submenuRow['url'] != "")
									{
										if(substr($submenuRow['url'], 0, 7) == 'http://' || substr($submenuRow['url'], 0, 8) == 'https://')
										{
											$menu_url = $validation->db_field_validate($submenuRow['url']);
											$menu_url_target = $validation->db_field_validate($submenuRow['url_target']);
										}
										else
										{
											$menu_url = BASE_URL."".$validation->db_field_validate($submenuRow['url']);
											$menu_url_target = $validation->db_field_validate($submenuRow['url_target']);
										}
									}
									else
									{
										$menu_url = BASE_URL."page/".$validation->db_field_validate($submenuRow['title_id'])."/";
										$menu_url_target = $validation->db_field_validate($submenuRow['url_target']);
									}
							?>
								<li><a href="<?php echo $menu_url; ?>" target="<?php echo $menu_url_target; ?>" <?php if($menu_url_target == "_blank") echo "rel='noopener noreferrer'"; ?>><?php echo $validation->db_field_validate($submenuRow['title']); ?></a></li>
							<?php
								}
								echo '</ul>';
							}
							?>
						</li>
					<?php
						}
					}
					?>
					<!--<?php if($_SESSION['mlm_email'] != "" and $_SESSION['mlm_regid'] != "") { ?>
						<li class="mlm-login">
							<a href="<?php echo BASE_URL; ?>mlm/" target="_blank">Cashback Portal</a>
						</li>
					<?php } ?>-->
				</ul>
			</nav>
			<div class="clearfx"></div>
		</div>
	</div>
</header>