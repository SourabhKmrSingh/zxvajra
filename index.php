<?php
include_once("inc_config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>
		<?php include_once("inc_title.php"); ?>
	</title>
	<meta name="keywords" content="<?php echo $validation->db_field_validate($configRow['meta_keywords']); ?>" />
	<meta name="description" content="<?php echo $validation->db_field_validate($configRow['meta_description']); ?>" />
	<?php include_once("inc_files.php"); ?>
	<style>
		#image_bac {
			background-image: url('./images/yellow.jpg');
			background-repeat: no-repeat;
			position: relative;
			background-size: cover;
			background-position: bottom;
			box-shadow: -13px -7px 5px 0px #bebdb754;
			margin-bottom: 40px;
		}

		#image_bac::before {
			content: "";
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			background-color: #d3d3d373;
		}


		#best_zx_back {
			background-image: url(./images/abc.jpg);
			position: relative;
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			padding-bottom: 54px;

		}

		#best_zx_back::before {
			content: "";
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			background-color: #222222b5;
		}
		
	</style>
</head>

<body>
	<div id="preloder">
		<div class="loader"></div>
	</div>
	<?php include_once("inc_header.php"); ?>
	<?php include_once("inc_slider.php"); ?>

	<?php
	$memberResult = $db->view('imgName,first_name,last_name,wallet_total', 'mlm_registrations', 'regid', "and status = 'active' and wallet_total != '0.00' and membership_id != 'GM001'", 'wallet_total desc', '5');
	if ($memberResult['num_rows'] >= 1) {
		?>
		<section>
			<div class="container">
				<div class="row mt-lg-5 mt-md-5 mt-sm-4">
					<div class="col-lg-6 col-md-6">
						<img src="./images/zxvajra_pro.png">
					</div>
					<div class="col-lg-6 col-md-6 p-lg-5 p-sm-4">
						<p class="block_p pt-lg-5">Wellivo Wellness has been working in the Wellness and
							FMCG domain since 2019. We have a stated 2 separate Brands I.e.
							Aayumantra and ZX Vajra. ZX Vajra tackles the overall Men’s Wellness
							problem with our Standout products ZX Vajra Capsules, ZX Vajra Oil, Dhatu
							Stambhak Churan, and Weight Grow.</p>
						<button type="button" class="btn btn-dark mt-md-4 ml-sm-2 mt-sm-2">Contact us</button>
					</div>

				</div>


			</div>
		</section>

		<?php
	}
	?>
	<div class="ing">
		<h4>Ingredients</h4>
		<?php
		$homebannerResult = $db->view("*", "rb_dynamic_records", "recordid", "and pageid='2' and status='active'", "order_custom desc", "8");
		if ($homebannerResult['num_rows'] >= 1) {
			?>
			<section class="mb-5">
				<div class="container-fluid">
					<div class="row">
						<?php
						foreach ($homebannerResult['result'] as $homebannerRow) {
							if ($homebannerRow['url'] == "#") {
								$homebanner_url = "#";
								$homebanner_url_target = "";
							} else if ($homebannerRow['url'] != "http://www." and $homebannerRow['url'] != "https://www." and $homebannerRow['url'] != "") {
								if (substr($homebannerRow['url'], 0, 7) == 'http://' || substr($homebannerRow['url'], 0, 8) == 'https://') {
									$homebanner_url = $validation->db_field_validate($homebannerRow['url']);
									$homebanner_url_target = $validation->db_field_validate($homebannerRow['url_target']);
								} else {
									$homebanner_url = BASE_URL . "" . $validation->db_field_validate($homebannerRow['url']);
									$homebanner_url_target = $validation->db_field_validate($homebannerRow['url_target']);
								}
							} else {
								//$homebanner_url = BASE_URL.'section/'.$rightpageRow['title_id'].'/'.$validation->db_field_validate($homebannerRow['title_id'])."/";
								$homebanner_url = "#";
								$homebanner_url_target = $validation->db_field_validate($homebannerRow['url_target']);
							}

							$section_img = explode(" | ", $homebannerRow['imgName']);
							?>
							<div class="col-lg-3 col-md-3 col-sm-6 col-6 mb-4">
								<div class="home-banner-box home_para">
									<h5 class="font-weight-bold font_title mb-2">
										<?php echo $validation->db_field_validate($homebannerRow['title']); ?>
										</h4>
										<a href="<?php echo $homebanner_url; ?>" target="<?php echo $homebanner_url_target; ?>">
											<div class="img-area d-flex align-items-center">
												<?php if ($section_img[0] != "" and file_exists(IMG_THUMB_LOC . $section_img[0])) { ?>
													<img src="<?php echo BASE_URL . IMG_THUMB_LOC . $section_img[0]; ?>"
														alt="<?php echo $validation->db_field_validate($homebannerRow['title']); ?>"
														title="<?php echo $validation->db_field_validate($homebannerRow['title']); ?>"
														class="img-responsive mb-2" />
													<?php } else { ?>
													<img src="<?php echo BASE_URL; ?>images/noimage.jpg"
														title="<?php echo $validation->db_field_validate($homebannerRow['title']); ?>"
														class="img-responsive mb-2" />
													<?php } ?>
											</div>
											<p class="heading"><?php echo $validation->db_field_validate($homebannerRow['tagline']); ?></p>
										</a>
										<?php if ($homebannerRow['price'] != "" && $homebannerRow['price'] != "0") { ?>
											<p class="price"><i class="fa fa-inr" aria-hidden="true"></i>
												<?php echo $validation->db_field_validate($homebannerRow['price']); ?>
											</p>
											<?php } ?>

										<?= $validation->db_field_validate($homebannerRow['description']); ?>
										<div class="clearfix"></div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</section>
			<?php
		}
		?>

		

		<?php
		$maincategoryResult = $db->view("*", "rb_categories", "categoryid", "and home_priority='1' and status='active'", "order_custom desc", "6");
		if ($maincategoryResult['num_rows'] >= 1) {
			?>
			<div class="heading">
				<h1>Our Product</h1>
			</div>
			<div class="banner-section spad" id="image_bac">
				<div class="container-fluid">
					<h2 class="font-weight-bold mb-5 mt-md-3 block2_design">Our Products</h2>
					<div class="row">
						<?php
						foreach ($maincategoryResult['result'] as $maincategoryRow) {
							if ($maincategoryRow['url'] == "#") {
								$maincategory_url = "#";
								$maincategory_url_target = "";
							} else if ($maincategoryRow['url'] != "http://www." and $maincategoryRow['url'] != "https://www." and $maincategoryRow['url'] != "") {
								if (substr($maincategoryRow['url'], 0, 7) == 'http://' || substr($maincategoryRow['url'], 0, 8) == 'https://') {
									$maincategory_url = $validation->db_field_validate($maincategoryRow['url']);
									$maincategory_url_target = $validation->db_field_validate($maincategoryRow['url_target']);
								} else {
									$maincategory_url = BASE_URL . "" . $validation->db_field_validate($maincategoryRow['url']);
									$maincategory_url_target = $validation->db_field_validate($maincategoryRow['url_target']);
								}
							} else {
								$maincategory_url = BASE_URL . 'products/?cat=' . $validation->db_field_validate($maincategoryRow['title_id']) . "";
								$maincategory_url_target = "";
							}
							?>
							<div class="col-lg-2 col-md-2 col-sm-6 col-6">
								<div class="single-banner">
									<a href="<?php echo $maincategory_url; ?>" target="<?php echo $maincategory_url_target; ?>">
										<?php if ($maincategoryRow['imgName'] != "" and file_exists(IMG_THUMB_LOC . $maincategoryRow['imgName'])) { ?>
											<img src="<?php echo BASE_URL . IMG_THUMB_LOC . $maincategoryRow['imgName']; ?>"
												alt="<?php echo $validation->db_field_validate($maincategoryRow['title']); ?>"
												title="<?php echo $validation->db_field_validate($maincategoryRow['title']); ?>" />
											<?php } else { ?>
											<img src="<?php echo BASE_URL; ?>images/noimage.jpg"
												title="<?php echo $validation->db_field_validate($maincategoryRow['title']); ?>" />
											<?php } ?>
										<div class="inner-text">
											<h4>
												<?php echo $validation->db_field_validate($maincategoryRow['title']); ?>
											</h4>
										</div>
									</a>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
		?>

		<?php
		$categoryResult = $db->view("*", "rb_categories", "categoryid", "and priority='1' and status='active'", "order_custom desc", "4");
		if ($categoryResult['num_rows'] >= 1) {
			$slr = 1;
			foreach ($categoryResult['result'] as $categoryRow) {
				if ($categoryRow['url'] == "#") {
					$category_url = "#";
					$category_url_target = "";
				} else if ($categoryRow['url'] != "http://www." and $categoryRow['url'] != "https://www." and $categoryRow['url'] != "") {
					if (substr($categoryRow['url'], 0, 7) == 'http://' || substr($categoryRow['url'], 0, 8) == 'https://') {
						$category_url = $validation->db_field_validate($categoryRow['url']);
						$category_url_target = $validation->db_field_validate($categoryRow['url_target']);
					} else {
						$category_url = BASE_URL . "" . $validation->db_field_validate($categoryRow['url']);
						$category_url_target = $validation->db_field_validate($categoryRow['url_target']);
					}
				} else {
					$category_url = BASE_URL . 'products/?cat=' . $validation->db_field_validate($categoryRow['title_id']) . "";
					$category_url_target = "";
				}

				$categoryid = $validation->db_field_validate($categoryRow['categoryid']);
				?>
				<section class="women-banner spad">
					<div class="container-fluid">
						<h2 class="font-weight-bold mb-2 mb-lg-5 block2_design">
							<?php echo $validation->db_field_validate($categoryRow['title']); ?>
						</h2>
						<a href="<?php echo $category_url; ?>" target="<?php echo $category_url_target; ?>"
							class="view_btn float-right">View All</a>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-lg-12">
								<div class="product-slider owl-carousel">
									<?php
									$productResult = $db->view('*', 'rb_products', 'productid', "and priority='1' and categoryid='$categoryid' and status='active'", 'order_custom desc', '10');
									if ($productResult['num_rows'] >= 1) {
										foreach ($productResult['result'] as $productRow) {
											$productid = $productRow['productid'];

											$categoryid = $productRow['categoryid'];
											$categoryQueryResult = $db->view("title,title_id", "rb_categories", "categoryid", "and categoryid='{$categoryid}'");
											$categoryRow = $categoryQueryResult['result'][0];

											$subcategoryid = $productRow['subcategoryid'];
											$subcategoryQueryResult = $db->view("title,title_id", "rb_subcategories", "subcategoryid", "and subcategoryid='{$subcategoryid}'");
											$subcategoryRow = $subcategoryQueryResult['result'][0];

											if ($productRow['url'] == "#") {
												$product_url = "#";
												$product_url_target = "";
											} else if ($productRow['url'] != "http://www." and $productRow['url'] != "https://www." and $productRow['url'] != "") {
												if (substr($productRow['url'], 0, 7) == 'http://' || substr($productRow['url'], 0, 8) == 'https://') {
													$product_url = $validation->db_field_validate($productRow['url']);
													$product_url_target = $validation->db_field_validate($productRow['url_target']);
												} else {
													$product_url = BASE_URL . "" . $validation->db_field_validate($productRow['url']);
													$product_url_target = $validation->db_field_validate($productRow['url_target']);
												}
											} else {
												$product_url = BASE_URL . 'products/' . $validation->db_field_validate($productRow['title_id']) . "/";
												$product_url_target = $validation->db_field_validate($productRow['url_target']);
											}

											$product_img = explode(" | ", $productRow['imgName']);

											$wishlistResult = $db->view('wishlistid', 'rb_wishlist', 'wishlistid', "and regid = '$regid' and productid = '$productid' and status = 'active'");

											$checkvariantResult = $db->view('variantid,stock_quantity', 'rb_products_variants', 'variantid', "and productid = '$productid'", 'variantid asc');
											$checkvariantRow = $checkvariantResult['result'][0];
											$product_variantid = $validation->db_field_validate($checkvariantRow['variantid']);

											$cartResult = $db->view('cartid', 'rb_cart', 'cartid', "and regid = '$regid' and productid = '$productid' and variantid='$product_variantid' and status = 'active'");

											$pincode = $_SESSION['pincode'];
											if ($pincode != "") {
												$pincodeResult = $db->view('pincodeid,pincode', 'rb_pincodes', 'pincodeid', "and pincode = '$pincode' and status = 'active'");
											}
											?>
											<div class="product-item h-100">
												<div class="pi-pic product-list d-flex align-items-center">
													<?php if ($product_img[0] != "" and file_exists(IMG_THUMB_LOC . $product_img[0])) { ?>
														<img src="<?php echo BASE_URL . IMG_THUMB_LOC . $product_img[0]; ?>"
															alt="<?php echo $validation->db_field_validate($productRow['title']); ?>"
															title="<?php echo $validation->db_field_validate($productRow['title']); ?>"
															class="mx-auto d-block" />
														<?php } else { ?>
														<img src="<?php echo BASE_URL; ?>images/noimage.jpg"
															title="<?php echo $validation->db_field_validate($productRow['title']); ?>"
															class="mx-auto d-block" />
														<?php } ?>
													<?php if ($productRow['sale'] == 1) { ?>
														<div class="sale pp-sale">Sale</div>
														<?php } ?>
													<div class="icon">
														<?php if ($wishlistResult['num_rows'] >= 1) { ?>
															<a class="product-list-heart"
																href="<?php echo BASE_URL . 'wishlist_delete.php?id=' . $productid; ?>"
																title="Remove from wishlist"><i class="fa fa-heart"></i></a>
															<?php } else { ?>
															<a class="product-list-heart"
																href="<?php echo BASE_URL . 'wishlist_inter.php?id=' . $productid . '&q=' . $full_url; ?>"
																title="Add to wishlist"><i class="fa fa-heart-o"></i></a>
															<?php } ?>
													</div>
													<form id="product-list-cart<?php echo $slr; ?>"
														action="<?php echo BASE_URL; ?>product-detail_inter.php?q=cart" method="post">
														<ul>
															<?php if ($checkvariantRow['stock_quantity'] >= 1 and ($pincode != '' ? $pincodeResult['num_rows'] >= 1 : $productid != "")) { ?>
																<input type="hidden" name="id" value="<?php echo $productid; ?>" />
																<input type="hidden" name="redirect_url" value="<?php echo $full_url; ?>" />
																<input type="hidden" name="price"
																	value="<?php echo $productRow['price']; ?>" />
																<input type="hidden" name="variantid"
																	value="<?php echo $product_variantid; ?>" />
																<input type="hidden" name="quantity" value="1" />
																<?php if ($cartResult['num_rows'] >= 1) { ?>
																	<li class="w-icon active"><a href="<?php echo BASE_URL . "cart" . SUFFIX; ?>">Go
																			to Cart</a></li>
																	<?php } else { ?>
																	<li class="w-icon active"><a href="javascript:void(0);"
																			onClick="cart_add('<?php echo $slr; ?>');"><i
																				class="fa fa-cart-plus"></i> Add to Cart</a></li>
																	<?php } ?>
																<?php } else { ?>
																<li class="w-icon active"><a class="outofstock">Out of Stock <?php if ($pincodeResult['num_rows'] == 0 and $pincode != "")
																echo "for " . $pincode; ?></a></li>
																<?php } ?>
															<li class="quick-view"><a href="<?php echo $product_url; ?>"
																	target="<?php echo $product_url_target; ?>">+ View</a></li>
														</ul>
													</form>
												</div>
												<div class="pi-text">
													<div class="catagory-name">
														<?php echo $validation->db_field_validate($categoryRow['title']); ?>
													</div>
													<a href="<?php echo $product_url; ?>" target="<?php echo $product_url_target; ?>">
														<h5>
															<?php echo $validation->getplaintext($productRow['title'], 48); ?>
														</h5>
													</a>
													<div class="product-price">
														<?php if ($productRow['price'] != '0') { ?>
															<?php if ($productRow['currency_code'] == 'INR')
															echo '<i class="fa fa-inr" style="font-size:17.5px;" aria-hidden="true"></i>';
														else
															$validation->db_field_validate($productRow['currency_code']); ?>
															<?php echo $validation->db_field_validate($validation->price_format($productRow['price'])); ?>
															<?php } ?>
														<?php if ($productRow['mrp'] != '0') { ?>
															<span>
																<?php if ($productRow['currency_code'] == 'INR')
																echo '&#8377;';
															else
																$validation->db_field_validate($productRow['currency_code']); ?>
																<?php echo $validation->db_field_validate($validation->price_format($productRow['mrp'])); ?>
															</span>
															<?php } ?>
													</div>
													<!--<?php if ($configRow['expected_delivery'] != "") { ?>
														<p class="text-center mt-2 mb-0 fs-13"><?php echo $validation->db_field_validate($configRow['expected_delivery']); ?></p>
													<?php } ?>-->
												</div>
											</div>
											<?php
											$slr++;
										}
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			}
		}
		?>


		<div class="how_work mb-5">
			<div class="container">
				<h2 class="work">How It Works</h2>
				<div class=" row step">
					<div class="col step_one"><span class="step_one_digit">01</span>
						<div class="step_content">
							<h4>Health Assessment</h4>
							<p>Let us to get to know you by asking a few questions. We will lay out actionable step for
								you to achieve your wellness goals</p>
						</div>
					</div>

					<div class="col step_sec"><span class="step_one_digit">02</span>
						<div class="step_content">
							<h4>Health Assessment</h4>
							<p>Let us to get to know you by asking a few questions. We will lay out actionable step for
								you to achieve your wellness goals</p>
						</div>
					</div>

					<div class="col step_third">
						<span class="step_one_digit">03</span>
						<div class="step_content">
							<h4>Health Assessment</h4>
							<p>Let us to get to know you by asking a few questions. We will lay out actionable step for
								you to achieve your wellness goals</p>
						</div>

					</div>

				</div>
			</div>
		</div>



		<section>


			<div class="best_zx_vajra" id="best_zx_back">
				<div class="container">
					<h3>How to use ZX Vajra in the Best</h3>
					<div class=best_content>
						<div class="row">

							<div class="col-2 offset-1"><img src=""></div>
							<div class="col-7">
								<h2>1. How to Use</h2>
								<p>ZX Vajra is a combination of 16 herbs used in Men’s wellness. The supplement was
									curated keeping multiple benefits in mind like Sexual Wellness, Physical wellness,
									etc. ZX Vajra is made from Natural herbs Like Shilajeet, Gokhru, etc, which means it
									is from any side effects. </p>
							</div>
						</div>

						<div class="row">
							<div class="col-7 offset-3">
								<h2>2. Who is it for</h2>
								<p>ZX Vajra is a combination of 16 herbs used in Men’s wellness. The supplement was
									curated keeping multiple benefits in mind like Sexual Wellness, Physical wellness,
									etc. ZX Vajra is made from Natural herbs Like Shilajeet, Gokhru, etc, which means it
									is from any side effects. </p>
							</div>
							<div class="col-2"><img src=""></div>
						</div>

					</div>
				</div>
			</div>
			<div data-scrollsection="reviews" class="Reviewsstyles__StyledReviews-sc-ceilpp-0 bmCYsk padding_style">
				<div class="container">
			<div data-scrollsection="customerReview"
				class="CustomerReviewsstyles__CustomerReviewsContainer-sc-lozmx4-0 jcvrkN">
				<div class="Sectionstyles__SectionContainer-sc-du16ub-0 bRrbEl section ">
					<div class="HeadingComponentWrapperstyles__HeadingComponentWrapper-sc-1aze4vx-0 bxdQOJ">
						<h2 class="customer_love">Our customers love us</h2>
					</div>
					<div class="subtitle-container">
						<div class="subtitle">Here are some stories</div>
					</div>
				</div>
				<div class="styles__StyledContainer-sc-a6duty-0 ivBYog">
					<p></p>
					<div class="styles__StyledCardsContainer-sc-a6duty-1 jpNeMm">
						<div class="carousel-wrapper">
							<div class="carousel-list owl-carousel event_cra owl-theme" role="list">
								<div class="styles__StyledCardsWrapper-sc-a6duty-2 fDcKOQ customer-review-card__wrapper"
									data-category="hair" data-product-category="hair">
									<div class="styles__StyledCard-sc-a6duty-3 iNrJFA customer-review-card__top">
										<div class="customer-review-card__image-container">
											<div class="customer-review-card__image"><img
													src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1658999525/Man%20Matters/Hair%20Gummies/0_Dark%20Blue/1605.png"
													alt="Biotin Gummies" loading="lazy"></div>
											<div class="customer-review-card__product">My Upchar</div>
										</div>
										<div class="customer-review-card__review">
											<div class="customer-review-card__star">
												<div style="width: 100%;">
													<div class="star-ratings" title="5 Stars"
														style="position: relative; box-sizing: border-box; display: inline-block;">
														<svg class="star-grad"
															style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
															<defs>
																<linearGradient id="starGrad039696315875263" x1="0%"
																	y1="0%" x2="100%" y2="0%">
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																	<stop offset="100%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																</linearGradient>
															</defs>
														</svg>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
													</div>
												</div>
											</div>
											<div class="customer-review-card__review-title">Highly Effective</div>
											<div class="customer-review-card__review-text">Gummies give me a wonderful
												results and i will buy more for my family members. Man matters really
												creating a space for every man to solve their mental physical or
												emotional problems. Thankyou</div>
											<div class="customer-review-card__reviewer"><span>Ayush </span></div>
										</div>
									</div>
								</div>
								<div class="styles__StyledCardsWrapper-sc-a6duty-2 fDcKOQ customer-review-card__wrapper"
									data-category="nutrition" data-product-category="hair">
									<div class="styles__StyledCard-sc-a6duty-3 iNrJFA customer-review-card__top">
										<div class="customer-review-card__image-container">
											<div class="customer-review-card__image"><img
													src="https://ik.manmatters.com/media/misc/pdp/6923914/vegain_500g_6x6_copy_HeW6XnVxN.png?tr=w-600"
													alt="Vegain Plant Protein Powder" loading="lazy"></div>
											<div class="customer-review-card__product">Snapdeal</div>
										</div>
										<div class="customer-review-card__review">
											<div class="customer-review-card__star">
												<div style="width: 100%;">
													<div class="star-ratings" title="5 Stars"
														style="position: relative; box-sizing: border-box; display: inline-block;">
														<svg class="star-grad"
															style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
															<defs>
																<linearGradient id="starGrad253243822531994" x1="0%"
																	y1="0%" x2="100%" y2="0%">
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																	<stop offset="100%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																</linearGradient>
															</defs>
														</svg>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
													</div>
												</div>
											</div>
											<div class="customer-review-card__review-title">Best vegan supplement</div>
											<div class="customer-review-card__review-text">I was using whey protein as I
												am a vegetarian and wanted to switch to Vegan options. I felt I got good
												results from this. It has multivitamins also to enhance absorption of
												protein better and herbs like Ashwagandha also keeps energy High. </div>
											<div class="customer-review-card__reviewer"><span>Hemanthkumar M</span>
											</div>
										</div>
									</div>
								</div>
								<div class="styles__StyledCardsWrapper-sc-a6duty-2 fDcKOQ customer-review-card__wrapper"
									data-category="hair" data-product-category="hair">
									<div class="styles__StyledCard-sc-a6duty-3 iNrJFA customer-review-card__top">
										<div class="customer-review-card__image-container">
											<div class="customer-review-card__image"><img
													src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1642744155/Man%20Matters/New%20Pdps/ADS%20100%20%2B%20Massager/Anti-Dandruff-Shampoo-100ml-_-Scalp-Massager-with-Ingredients.png"
													alt="Scalp Revitalising Kit" loading="lazy"></div>
											<div class="customer-review-card__product">Indiamart</div>
										</div>
										<div class="customer-review-card__review">
											<div class="customer-review-card__star">
												<div style="width: 100%;">
													<div class="star-ratings" title="5 Stars"
														style="position: relative; box-sizing: border-box; display: inline-block;">
														<svg class="star-grad"
															style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
															<defs>
																<linearGradient id="starGrad747615451747175" x1="0%"
																	y1="0%" x2="100%" y2="0%">
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																	<stop offset="100%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																</linearGradient>
															</defs>
														</svg>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
													</div>
												</div>
											</div>
											<div class="customer-review-card__review-title">Highly recommend these!
											</div>
											<div class="customer-review-card__review-text">This Scalp Revitalising Kit
												is best for dandruff and hair fall problems. Simple for use and full
												satisfied product.</div>
											<div class="customer-review-card__reviewer"><span>Chetan R</span></div>
										</div>
									</div>
								</div>
								<div class="styles__StyledCardsWrapper-sc-a6duty-2 fDcKOQ customer-review-card__wrapper"
									data-category="beard" data-product-category="hair">
									<div class="styles__StyledCard-sc-a6duty-3 iNrJFA customer-review-card__top">
										<div class="customer-review-card__image-container">
											<div class="customer-review-card__image"><img
													src="https://ik.manmatters.com/media/misc/pdp/11954287/Beardmax_-_Mahesh1__2__uXniqDQ8h.png?tr=w-600"
													alt="BeardMax 5% Minoxidil for Patchy Beard" loading="lazy"></div>
											<div class="customer-review-card__product">BeardMax 5% Minoxidil for Patchy
												Beard</div>
										</div>
										<div class="customer-review-card__review">
											<div class="customer-review-card__star">
												<div style="width: 100%;">
													<div class="star-ratings" title="5 Stars"
														style="position: relative; box-sizing: border-box; display: inline-block;">
														<svg class="star-grad"
															style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
															<defs>
																<linearGradient id="starGrad497316301289738" x1="0%"
																	y1="0%" x2="100%" y2="0%">
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																	<stop offset="100%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																</linearGradient>
															</defs>
														</svg>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
													</div>
												</div>
											</div>
											<div class="customer-review-card__review-title">Perfect</div>
											<div class="customer-review-card__review-text">My experience was great all
												thanks to Dr. Raj from man matters. I was not getting the results I
												expected in 1st month but I was firm that I will get result as I always
												took followup appointment with Dr. Raj.</div>
											<div class="customer-review-card__reviewer"><span>Prateet S. </span></div>
										</div>
									</div>
								</div>
								<div class="styles__StyledCardsWrapper-sc-a6duty-2 fDcKOQ customer-review-card__wrapper"
									data-category="hair" data-product-category="hair">
									<div class="styles__StyledCard-sc-a6duty-3 iNrJFA customer-review-card__top">
										<div class="customer-review-card__image-container">
											<div class="customer-review-card__image"><img
													src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1658995057/New%20hero%20images/1613.png"
													alt="GrowMax 5% Minoxidil" loading="lazy"></div>
											<div class="customer-review-card__product">GrowMax 5% Minoxidil</div>
										</div>
										<div class="customer-review-card__review">
											<div class="customer-review-card__star">
												<div style="width: 100%;">
													<div class="star-ratings" title="5 Stars"
														style="position: relative; box-sizing: border-box; display: inline-block;">
														<svg class="star-grad"
															style="position: absolute; z-index: 0; width: 0px; height: 0px; visibility: hidden;">
															<defs>
																<linearGradient id="starGrad774920585716166" x1="0%"
																	y1="0%" x2="100%" y2="0%">
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-first"
																		style="stop-color: rgb(228, 174, 44); stop-opacity: 1;">
																	</stop>
																	<stop offset="0%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																	<stop offset="100%" class="stop-color-final"
																		style="stop-color: rgb(203, 211, 227); stop-opacity: 1;">
																	</stop>
																</linearGradient>
															</defs>
														</svg>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px; padding-right: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
														<div class="star-container"
															style="position: relative; display: inline-block; vertical-align: middle; padding-left: 1px;">
															<svg viewBox="0 0 28 27" class="widget-svg"
																style="width: 25px; height: 25px; transition: transform 0.2s ease-in-out 0s;">
																<path class="star"
																	d="M14 2L17.8206 9.74139L26.3637 10.9828L20.1819 17.0086L21.6412 25.5172L14 21.5L6.35879 25.5172L7.81813 17.0086L1.63627 10.9828L10.1794 9.74139L14 2Z"
																	style="fill: rgb(228, 174, 44); transition: fill 0.2s ease-in-out 0s;">
																</path>
															</svg></div>
													</div>
												</div>
											</div>
											<div class="customer-review-card__review-title">Satisfied</div>
											<div class="customer-review-card__review-text">I started finding positive
												results from the sixth month onwards</div>
											<div class="customer-review-card__reviewer"><span>Deepu </span></div>
										</div>
									</div>
								</div>
							</div>
							<button class="carousel-nav-button carousel-nav-button-next span_icon"
								aria-label="click to move forward"
								style="padding: 4px; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 20px; height: 60px; width: 60px; font-weight: bold; stroke-width: 50px;"><svg
									width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
									aria-hidden="true" focusable="false">
									<path fill=""
										d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z">
									</path>
								</svg>
							</button>
							<div class="carousel-scrollbar-overlay"></div>
						</div>
					</div>
				</div>
			</div>
	</div>
	
		</div>

		<div class="how_work_blog mb-5">
			<div class="container">
				<h2 class="blog_work">Info Matters</h2>
				<div class=" row step ">
					<div class="col step_one blog_common"><span class="blog_work_img"><img src="./images/as.jpg"></span>
						<div class="step_content_blog">
							<h4>What is Lorem Ipsum?</h4>
							<p>Let us to get to know you by asking a few questions. We will lay out actionable step for
								you to achieve your wellness goals</p>
						</div>
					</div>

					<div class="col step_sec blog_common"><span class="blog_work_img"><img src="./images/blogimg.jpeg"></span>
						<div class="step_content_blog">
							<h4>Why do we use it?</h4>
							<p>Let us to get to know you by asking a few questions. We will lay out actionable step for
								you to achieve your wellness goals</p>
						</div>
					</div>

					<div class="col step_third blog_common">
						<span class="blog_work_img"><img src="./images/protein.png"></span>
						<div class="step_content_blog">
							<h4>Where does it come from?</h4>
							<p>Let us to get to know you by asking a few questions. We will lay out actionable step for
								you to achieve your wellness goals</p>
						</div>

					</div>

				</div>
			</div>
		</div>
		

				<section class="latest-blog spad pt-3 pb-3">
					<div class="container-fluid">
						<div class="benefit-items">
							<div class="row">
								<div class="col-sm-3">
									<div class="single-benefit">
										<div class="sb-icon">
											<img src="images/icon-1.png" alt="">
										</div>
										<div class="sb-text">
											<h6>Free Shipping</h6>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="single-benefit">
										<div class="sb-icon">
											<img src="images/icon-2.png" alt="">
										</div>
										<div class="sb-text">
											<h6>Delivery On Time</h6>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="single-benefit">
										<div class="sb-icon">
											<img src="images/icon-3.png" alt="">
										</div>
										<div class="sb-text">
											<h6>Secure Payment</h6>
											<p>100% secure payment</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="single-benefit">
										<div class="sb-icon">
											<img src="images/icon-4.png" alt="">
										</div>
										<div class="sb-text">
											<h6>Cash on Delivery</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<?php include_once("inc_footer.php"); ?>
				<?php include_once("inc_files_bottom.php"); ?>
</body>
<script>
	 $(document).ready(function() {
    $('.event_cra').owlCarousel({
      nav: true,
      loop: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 3
        },
        1000: {
          items: 3
        }
      }
    })
  })
</script>
</html>