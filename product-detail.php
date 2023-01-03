<?php
include_once("inc_config.php");

$pageid = "our-products";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

$title_id = $validation->urlstring_validate($_GET['id']);
$productResult = $db->view("*", "rb_products", "productid", "and title_id='{$title_id}' and status='active'");
$productRow = $productResult['result'][0];
$productid = $productRow['productid'];

if($productRow['url'] != "http://www." and $productRow['url'] != "https://www." and $productRow['url'] != "" and $_SESSION['full_url'] != $full_url)
{
	if(substr($productRow['url'], 0, 7) == 'http://' || substr($productRow['url'], 0, 8) == 'https://')
	{
		$page_url = $validation->db_field_validate($productRow['url']);
		$page_url_target = $validation->db_field_validate($productRow['url_target']);
	}
	else
	{
		$page_url = BASE_URL."".$validation->db_field_validate($productRow['url']);
		$page_url_target = $validation->db_field_validate($productRow['url_target']);
	}
	
	$_SESSION['full_url'] = $full_url;
	header("Location: {$page_url}");
	exit();
}
$_SESSION['full_url'] = "";

$variantid = $validation->urlstring_validate($_GET['id2']);
if($variantid != "")
{
	$checkvariantResult = $db->view('*', 'rb_products_variants', 'variantid', "and productid = '$productid' and variantid='$variantid'", 'variantid asc');
	if($checkvariantResult['num_rows'] >= 1)
	{
		$checkvariantRow = $checkvariantResult['result'][0];
		$product_variantid = $validation->db_field_validate($checkvariantRow['variantid']);
		$product_variant = $validation->db_field_validate($checkvariantRow['variant']);
		$product_sku = $validation->db_field_validate($checkvariantRow['sku']);
		$product_price = $validation->db_field_validate($checkvariantRow['price']);
		$product_mrp = $validation->db_field_validate($checkvariantRow['mrp']);
		$product_stock_quantity = $validation->db_field_validate($checkvariantRow['stock_quantity']);
	}
	else
	{
		$_SESSION['success_msg_fe'] = "No Variant exists!";
		header("Location: {$full_url}");
		exit();
	}
}
else
{
	$checkvariantResult = $db->view('*', 'rb_products_variants', 'variantid', "and productid = '$productid'", 'variantid asc');
	$checkvariantRow = $checkvariantResult['result'][0];
	
	$product_variantid = $validation->db_field_validate($checkvariantRow['variantid']);
	$product_variant = $validation->db_field_validate($checkvariantRow['variant']);
	$product_sku = $validation->db_field_validate($checkvariantRow['sku']);
	$product_price = $validation->db_field_validate($checkvariantRow['price']);
	$product_mrp = $validation->db_field_validate($checkvariantRow['mrp']);
	$product_stock_quantity = $validation->db_field_validate($checkvariantRow['stock_quantity']);
}

$categoryid = $productRow['categoryid'];
$categoryQueryResult = $db->view("title,title_id", "rb_categories", "categoryid", "and categoryid='{$categoryid}'");
$categoryRow = $categoryQueryResult['result'][0];

$subcategoryid = $productRow['subcategoryid'];
$subcategoryQueryResult = $db->view("title,title_id", "rb_subcategories", "subcategoryid", "and subcategoryid='{$subcategoryid}'");
$subcategoryRow = $subcategoryQueryResult['result'][0];

$db->unique_visitors('rb_products_views', 'rb_products', 'productid', $productid, $user_ip, $regid);
$visitorsResult = $db->view("views", "rb_products", "productid", "and title_id='{$title_id}' and status='active'");
$visitorsRow = $visitorsResult['result'][0];
$visitorsCount = $visitorsRow['views'];

$wishlistResult = $db->view('*', 'rb_wishlist', 'wishlistid', "and regid = '$regid' and productid = '$productid' and status = 'active'");

$cartResult = $db->view('*', 'rb_cart', 'cartid', "and regid = '$regid' and productid = '$productid' and variantid='$product_variantid' and status = 'active'");

$reviewResult = $db->view('*', 'rb_products_reviews', 'reviewid', "and productid = '$productid' and status = 'active'");
$reviewCount = $reviewResult['num_rows'];
$reviewmainRow = $reviewResult['result'][0];

$userreviewResult = $db->view('reviewid', 'rb_products_reviews', 'reviewid', "and regid = '$regid' and productid = '$productid' and status = 'active'");
$userreviewCount = $userreviewResult['num_rows'];

$userpurchaseResult = $db->view('purchaseid', 'rb_purchases', 'purchaseid', "and regid = '$regid' and productid = '$productid' and tracking_status = 'delivered' and status = 'active'");
$userpurchaseCount = $userpurchaseResult['num_rows'];

$reviewsumResult = $db->view('SUM(ratings) as reviews_sum', 'rb_products_reviews', 'reviewid', "and productid = '$productid' and status = 'active'");
$reviewsumRow = $reviewsumResult['result'][0];
$product_ratings = ceil($reviewsumRow['reviews_sum'] / $reviewCount);

$final_price = $product_price+$productRow['shipping'];
$final_total_price = $final_price + $validation->calculate_discounted_price($productRow['tax'], $final_price);

$pincode = $_SESSION['pincode'];
$pincodeResult = $db->view('pincodeid,pincode', 'rb_pincodes', 'pincodeid', "and pincode = '$pincode' and status = 'active'");
$pincodeRow = $pincodeResult['result'][0];

$_SESSION['csrf_token'] = substr(sha1(rand(1, 99999)),0,32);
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
<?php if($productRow['meta_title'] != "") { ?>
<title><?php echo $validation->db_field_validate($productRow['meta_title']); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($productRow['meta_keywords']); ?>" />
<meta name="description" content="<?php echo $validation->db_field_validate($productRow['meta_description']); ?>" />
<?php } else { ?>
<title><?php echo $validation->db_field_validate($productRow['title'])." | "; include_once("inc_title.php"); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($productRow['title']); ?>" />
<meta name="description" content="<?php echo $validation->getplaintext($productRow['description'], 200); ?>" />
<?php } ?>
<meta property="og:title" content="<?php echo $validation->db_field_validate($productRow['title']); ?>" />
<meta property="og:type" content="<?php echo $validation->db_field_validate($categoryRow['title']); ?>" />
<meta property="og:image" content="<?php echo BASE_URL.IMG_THUMB_LOC.$validation->db_field_validate($productRow['imgName']); ?>" />
<meta property="og:url" content="<?php echo $full_url; ?>" />
<meta property="og:description" content="<?php echo $validation->getplaintext($productRow['description'], 200); ?>" />
<?php include_once("inc_files.php"); ?>
</head>
<body>
<div id="preloder">
	<div class="loader"></div>
</div>
<?php include_once("inc_header.php"); ?>

<div class="breacrumb-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb-text">
					<a href="<?php echo BASE_URL; ?>"><i class="fa fa-home"></i> Home</a>
					<a href="<?php echo BASE_URL.'products'.SUFFIX; ?>"><?php echo $validation->db_field_validate($pageRow['title']); ?></a>
					<?php if($categoryRow['title'] != "") { ?>
						<a href="<?php echo BASE_URL.'products'.SUFFIX.'?cat='.$validation->db_field_validate($categoryRow['title_id']); ?>"><?php echo $validation->db_field_validate($categoryRow['title']); ?></a>
					<?php } ?>
					<?php if($subcategoryRow['title'] != "") { ?>
						<a href="<?php echo BASE_URL.'products'.SUFFIX.'?cat='.$validation->db_field_validate($categoryRow['title_id']).'&subcat='.$validation->db_field_validate($subcategoryRow['title_id']); ?>"><?php echo $validation->db_field_validate($subcategoryRow['title']); ?></a>
					<?php } ?>
					<span><?php echo $validation->getplaintext($productRow['title'], 80); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="product-shop spad page-details pt-2">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<?php if($_SESSION['success_msg_fe'] != "") { ?>
					<div class="alert alert-success text-center mt-0 mb-4">
						<?php
						echo @$_SESSION['success_msg_fe'];
						@$_SESSION['success_msg_fe'] = "";
						?>
					</div>
				<?php } if($_SESSION['error_msg_fe'] != "") { ?>
					<div class="alert alert-danger text-center mt-0 mb-4">
						<?php
						echo @$_SESSION['error_msg_fe'];
						@$_SESSION['error_msg_fe'] = "";
						?>
					</div>
				<?php } ?>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-5">
						<div class="box h-100">
							<div class="product-pic-zoom">
								<?php
								$product_img = explode(" | ", $productRow['imgName']);
								$slr = 0;
								if($product_img[0] != "")
								{
								?>
									<img class="product-big-img" src="<?php echo BASE_URL.IMG_MAIN_LOC.$product_img[0]; ?>" alt="<?php echo $validation->db_field_validate($productRow['title']); ?>" />
								<?php
								}
								?>
								<!--<div class="zoom-icon">
									<i class="fa fa-search-plus"></i>
								</div>-->
							</div>
							<div class="product-thumbs">
								<div class="product-thumbs-track ps-slider owl-carousel">
									<?php
									$slr = 1;
									if($product_img[0] != "")
									{
										foreach($product_img as $img)
										{
										?>
											<div class="pt <?php if($slr == 1) echo "active"; ?>" data-imgbigurl="<?php echo BASE_URL.IMG_MAIN_LOC.$img; ?>"><img src="<?php echo BASE_URL.IMG_THUMB_LOC.$img; ?>" alt="<?php echo $validation->db_field_validate($productRow['title']); ?>"></div>
										<?php
											$slr++;
										}
									}
									else
									{
									?>
										<div class="pt active" data-imgbigurl="<?php echo BASE_URL.IMG_MAIN_LOC.$img; ?>"><img src="<?php echo BASE_URL; ?>images/noimage.jpg" alt="" /></div>
									<?php	
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="product-details box h-100">
							<div class="pd-title">
								<span>
									<?php
									if($categoryRow['title'] != "")
									{
										echo $validation->db_field_validate($categoryRow['title']);
									}
									if($subcategoryRow['title'] != "")
									{
										echo "&nbsp;<i class='fa fa-caret-right'></i> ".$validation->db_field_validate($subcategoryRow['title']);
									}
									?>
								</span>
								<h3><?php echo $validation->db_field_validate($productRow['title']); ?></h3>
								<?php if($wishlistResult['num_rows'] >= 1) { ?>
									<a class="heart-icon" href="<?php echo BASE_URL.'wishlist_delete.php?id='.$productid; ?>" title="Remove from wishlist"><i class="fa fa-heart"></i></a>
								<?php } else { ?>
									<a class="heart-icon" href="<?php echo BASE_URL.'wishlist_inter.php?id='.$productid.'&q='.$full_url; ?>" title="Add to wishlist"><i class="fa fa-heart-o"></i></a>
								<?php } ?>
							</div>
							<div class="pd-rating">
								<i class="<?php if($product_ratings >= 1) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
								<i class="<?php if($product_ratings >= 2) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
								<i class="<?php if($product_ratings >= 3) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
								<i class="<?php if($product_ratings >= 4) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
								<i class="<?php if($product_ratings >= 5) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
								<span>(<?php echo $reviewCount; ?>)</span>
							</div>
							<div class="pd-desc">
								<h4>
									<?php if($product_price != "" and $product_price != "0" and $product_price != "0.00") { ?>
										<span class="offer_price mr-2"><?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" style="font-size:21.5px;" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?><?php echo $validation->price_format($product_price); ?></span>
									<?php } ?>
									<?php if($product_mrp != "" and $product_mrp != "0" and $product_mrp != "0.00") { ?>
										<del class="mrp_price"><?php if($productRow['currency_code'] == 'INR') echo '&#8377;'; else $validation->db_field_validate($productRow['currency_code']); ?><?php echo $validation->price_format($product_mrp); ?></del>
										<span class="discount_price ml-2"><?php echo $validation->calculate_discount($product_mrp, $product_price); ?> off</span>
									<?php } ?>
									<span class="tax_info ml-2"><?php if($productRow['tax_information'] == "included") echo '(Inclusive of all taxes)'; if($productRow['tax_information'] == "excluded") echo '(Exclusive of all taxes)'; ?></span>
									<!--<span class="tax_info ml-2"><?php if($productRow['tax_information'] != "") echo '('.ucfirst($validation->db_field_validate($productRow['tax_information'])).' '.$validation->db_field_validate($productRow['tax_type']).' of '.$validation->db_field_validate($productRow['tax']).'%)'; ?></span>-->
								</h4>
							</div>
							<div class="pd-color">
								<h6 class="stock-font mb-1"><?php if($product_stock_quantity >= 1) echo "<span class='stock-green'>In Stock</span>"; else echo "<span class='stock-red'>Out of Stock</span>"; ?> <?php if($product_stock_quantity <= 5 and $product_stock_quantity != 0) echo "<span class='stock-alert-text'>Hurry, Only {$product_stock_quantity} left</span>"; else if($product_stock_quantity <= 5 and $product_stock_quantity != 0) echo "<span class='stock-alert-text'>Hurry, Only few left</span>"; ?></h6>
							</div>
							<div class="clearfix"></div>
							<div class="filter-widget mt-4 mb-1">
								<div class="fw-size-choose">
									<?php
									$slr = 1;
									$variantResult = $db->view('*', 'rb_products_variants', 'variantid', "and productid = '$productid' and variant != ''", 'variantid asc');
									if($variantResult['num_rows'] >= 1)
									{
										foreach($variantResult['result'] as $variantRow)
										{
									?>
										<div class="sc-item">
											<a href="<?php echo BASE_URL.'products/'.$title_id.'/'.$variantRow['variantid'].'/'; ?>"><label for="s-size" class="<?php if($variantid != "") { if($variantid == $variantRow['variantid']) echo 'active'; } else { if($slr == 1) echo 'active'; } ?>"><?php echo $validation->db_field_validate($variantRow['variant']); ?><br /><span><?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?><?php echo $validation->price_format($variantRow['price']); ?></span></label></a>
										</div>
									<?php
											$slr++;
										}
									}
									?>
								</div>
							</div>
							<div class="bullets post-detail">
								<ul>
									<?php if($productRow['cod'] == "yes") { ?><li>COD Available</li><?php } ?>
									<li>Bank Transfer Available</li>
									<?php if($productRow['shipping'] == "0" || $productRow['shipping'] == "0.00") { ?>
										<li>Free Shipping</li>
									<?php } ?>
									<?php if($configRow['expected_delivery'] != "") { ?>
										<li><?php echo $validation->db_field_validate($configRow['expected_delivery']); ?></li>
									<?php } ?>
								</ul>
							</div>
							<div class="quantity mt-0">
								<form action="<?php echo BASE_URL; ?>product-detail_inter.php" method="post">
									<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />
									<input type="hidden" name="id" value="<?php echo $productid; ?>" />
									<input type="hidden" name="redirect_url" value="<?php echo $full_url; ?>" />
									<input type="hidden" name="variantid" value="<?php echo $product_variantid; ?>" />
									<input type="hidden" name="price" value="<?php echo $product_price; ?>" />
									<input type="hidden" name="shipping" value="<?php echo $productRow['shipping']; ?>" />
									<input type="hidden" name="tax" value="<?php echo $productRow['tax']; ?>" />
									<input type="hidden" name="taxamount" value="<?php echo $validation->calculate_discounted_price($productRow['tax'], $product_price); ?>" />
									<input type="hidden" name="final_price" value="<?php echo $final_total_price; ?>" />
									<?php if($product_stock_quantity >= 1) { ?>
										<div class="d-inline-block align-middle pt-2">
											<label for="quantity">Quantity:</label>&nbsp;
										</div>
										<div class="d-inline-block align-middle">
											<select name="quantity" id="quantity" class="form-control" onChange="get_quantity_product();">
												<?php
												$max_quantity = ($product_stock_quantity >= 9 ? '9' : $product_stock_quantity);
												for($i=1;$i<=$max_quantity;$i++)
												{
												?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												<?php
												}
												if($product_stock_quantity >= 10)
												{
												?>
													<option value="10+" <?php if("10+" == $quantity) echo "selected"; ?>>10+</option>
												<?php
												}
												?>
											</select>
											<input type="number" name="quantity_custom" id="quantity_custom" min="1" class="form-control mw-80 mr-1" style="display:none;" />
										</div>
									<?php } ?>
									<div class="clearfix"></div>
									<?php if($pincodeResult['num_rows'] == 0 and $pincode != "") { ?><p class="mt-3 stock-red"><?php echo "Currently Out of Stock for <strong>".$pincode."</strong>"; ?></p><?php } ?>
									<div class="card_area mt-4">
										<?php if($product_stock_quantity >= 1  and ($pincode != '' ? $pincodeResult['num_rows'] >= 1 : $productid != "")) { ?>
											<?php if($cartResult['num_rows'] >= 1) { ?>
												<a href="<?php echo BASE_URL."cart".SUFFIX; ?>" class="cart_btn">Go to Cart</a>
											<?php } else { ?>
												<button type="submit" name="add_to_cart" class="cart_btn" value="cart">Add to Cart</button>
											<?php } ?>
											<button type="submit" name="buy_now" class="cart_btn" value="buy">Buy Now</button>
										<?php } else { ?>
											<a href="javascript:void(0);" class="cart_btn">Coming Soon</a>
										<?php } ?>
									</div>
									<div class="clearfix"></div>
								</form>
							</div>
							<ul class="pd-tags">
								<li>
									<span>CATEGORIES</span>: 
									<?php
									if($categoryRow['title'] != "")
									{
										echo $validation->db_field_validate($categoryRow['title']);
									}
									if($subcategoryRow['title'] != "")
									{
										echo ", ".$validation->db_field_validate($subcategoryRow['title']);
									}
									?>
								</li>
							</ul>
							<div class="pd-share">
								<?php if($product_sku != "") { ?>
									<div class="p-code">Sku : <?php echo $product_sku; ?></div>
								<?php } ?>
								<div class="pd-social">
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $full_url; ?>&title=<?php echo $validation->db_field_validate($sectionRow['title']); ?>" title="Facebook" target="_blank"><i class="ti-facebook"></i></a>
									<a href="http://twitter.com/share?text=<?php echo $validation->db_field_validate($postRow['title']); ?>&url=<?php echo $full_url; ?>" title="Twitter" target="_blank"><i class="ti-twitter-alt"></i></a>
									<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $full_url; ?>" title="Linkedin" target="_blank"><i class="ti-linkedin"></i></a>
									<a href="http://pinterest.com/pin/create/button/?url=<?php echo $full_url; ?>&media=<?php echo BASE_URL.IMG_THUMB_LOC.$validation->db_field_validate($sectionRow['imgName']); ?>" title="Pinterest" target="_blank"><i class="ti-pinterest"></i></a>
									<a href="mailto:?subject=<?php echo $validation->db_field_validate($postRow['title']); ?>&body=Check out this site <?php echo $full_url; ?>" title="E-mail" target="_blank"><i class="ti-email"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<a name="review"></a>
				<div class="product-tab box mt-4">
					<div class="tab-item">
						<ul class="nav" role="tablist">
							<li>
								<a class="active" data-toggle="tab" href="#tab-1" role="tab">DESCRIPTION</a>
							</li>
							<!--<li>
								<a data-toggle="tab" href="#tab-2" role="tab">SPECIFICATIONS</a>
							</li>-->
							<li>
								<a data-toggle="tab" href="#tab-3" id="reviews" role="tab">Customer Reviews (<?php echo $reviewCount; ?>)</a>
							</li>
						</ul>
					</div>
					<div class="tab-item-content">
						<div class="tab-content">
							<div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
								<div class="product-content">
									<div class="row">
										<div class="col-lg-12">
											<div class="post-detail"><?php echo $validation->db_field_validate($productRow['description']); ?></div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="tab-2" role="tabpanel">
								<div class="specification-table">
									<table>
										<tr>
											<td class="p-catagory">Price</td>
											<td>
												<div class="p-price"><?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?><?php echo $validation->price_format($product_price); ?></div>
											</td>
										</tr>
										<tr>
											<td class="p-catagory">Availability</td>
											<td>
												<div class="p-stock"><?php echo $validation->db_field_validate($product_stock_quantity); ?> in stock</div>
											</td>
										</tr>
										<?php if($product_sku != "") { ?>
											<tr>
												<td class="p-catagory">Sku</td>
												<td>
													<div class="p-code"><?php echo $product_sku; ?></div>
												</td>
											</tr>
										<?php } ?>
									</table>
									<div class="post-detail"><?php echo $validation->db_field_validate($productRow['specification']); ?></div>
								</div>
							</div>
							<div class="tab-pane fade" id="tab-3" role="tabpanel">
								<div class="customer-review-option pt-0">
									<?php if($userreviewCount == 0 and $userpurchaseCount >= 1) { ?>
										<div class="leave-comment pt-4">
											<h4>Write your Review</h4>
											<form action="<?php echo BASE_URL; ?>product_review_inter.php" method="post" class="comment-form">
												<input type="hidden" name="redirect_url" value="<?php echo $full_url; ?>" />
												<input type="hidden" name="productid" value="<?php echo $productid; ?>" />
												<fieldset CLASS="rating mb-2">
													<input CLASS="stars" TYPE="radio" ID="star5" NAME="ratings" VALUE="5" checked="checked" />
													<label class="full" FOR="star5" TITLE="5 stars"></label>
													<input CLASS="stars" TYPE="radio" ID="star4" NAME="ratings" VALUE="4" />
													<label class="full" FOR="star4" TITLE="4 stars"></label>
													<input CLASS="stars" TYPE="radio" ID="star3" NAME="ratings" VALUE="3" />
													<label class="full" FOR="star3" TITLE="3 stars"></label>
													<input CLASS="stars" TYPE="radio" ID="star2" NAME="ratings" VALUE="2" />
													<label class="full" FOR="star2" TITLE="2 stars"></label>
													<input CLASS="stars" TYPE="radio" ID="star1" NAME="ratings" VALUE="1" />
													<label class="full" FOR="star1" TITLE="1 star"></label>
												</fieldset>
												<div class="clearfix"></div>
												<div class="row">
													<div class="col-lg-4">
														<input type="text" name="name" placeholder="Name" class="mb-3" required />
													</div>
													<div class="col-lg-4">
														<input type="email" name="email" placeholder="Email" class="mb-3" required />
													</div>
													<div class="col-lg-8">
														<textarea name="message" placeholder="Message" class="mb-3"></textarea>
														<button type="submit" class="site-btn">Send message</button>
													</div>
												</div>
											</form>
										</div>
									<?php } ?>
									<div class="clearfix mb-5"></div>
									<h4><?php echo $reviewCount; ?> Review(s)</h4>
									<div class="comment-option">
										<?php
										foreach($reviewResult['result'] as $reviewRow)
										{
											$regid = $reviewRow['regid'];
											$registerQueryResult = $db->view("regid,first_name,last_name", "rb_registrations", "regid", "and regid='{$regid}'");
											$registerRow = $registerQueryResult['result'][0];
										?>
											<div class="co-item mb-5">
												<div class="avatar-pic">
													<?php if($registerRow['imgName'] != "") { ?>
														<img src="<?php echo IMG_THUMB_LOC; echo $validation->db_field_validate($registerRow['imgName']); ?>" alt="<?php echo $validation->db_field_validate($reviewRow['name']); ?>" />
													<?php } else { ?>
														<img src="<?php echo BASE_URL.'images/user_icon.png'; ?>" alt="<?php echo $validation->db_field_validate($reviewRow['name']); ?>" />
													<?php } ?>
												</div>
												<div class="avatar-text">
													<div class="at-rating">
														<i class="<?php if($reviewRow['ratings'] >= 1) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
														<i class="<?php if($reviewRow['ratings'] >= 2) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
														<i class="<?php if($reviewRow['ratings'] >= 3) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
														<i class="<?php if($reviewRow['ratings'] >= 4) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
														<i class="<?php if($reviewRow['ratings'] >= 5) echo "fa fa-star"; else echo "fa fa-star-o"; ?>"></i>
													</div>
													<h5><?php echo $validation->db_field_validate($reviewRow['name']); ?> <span><?php echo $validation->date_format_custom($reviewRow['createdate']); ?></span></h5>
													<div class="at-reply"><?php echo $validation->db_field_validate($reviewRow['message']); ?></div>
												</div>
											</div>
										<?php
										}
										?>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if($subcategoryid != "" and $subcategoryid != "0")
{
	$where_query .= " and subcategoryid = '$subcategoryid'";
}
else if($categoryid != "" and $categoryid != "0")
{
	$where_query .= " and categoryid = '$categoryid'";
}
$relatedproductsResult = $db->view('*', 'rb_products', 'productid', "{$where_query} and productid != '$productid' and status='active'", 'order_custom desc', '20');
$slr = 1;
if($relatedproductsResult['num_rows'] >= 1)
{
?>
<div class="related-products spad">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="section-title">
					<h2>Related Products</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="product-slider owl-carousel">
					<?php
					foreach($relatedproductsResult['result'] as $relatedproductsRow)
					{
						$productid = $relatedproductsRow['productid'];
						
						$categoryid = $relatedproductsRow['categoryid'];
						$categoryQueryResult = $db->view("title,title_id", "rb_categories", "categoryid", "and categoryid='{$categoryid}'");
						$categoryRow = $categoryQueryResult['result'][0];
						
						$subcategoryid = $relatedproductsRow['subcategoryid'];
						$subcategoryQueryResult = $db->view("title,title_id", "rb_subcategories", "subcategoryid", "and subcategoryid='{$subcategoryid}'");
						$subcategoryRow = $subcategoryQueryResult['result'][0];
						
						if($relatedproductsRow['url'] == "#")
						{
							$product_url = "#";
							$product_url_target = "";
						}
						else if($relatedproductsRow['url'] != "http://www." and $relatedproductsRow['url'] != "https://www." and $relatedproductsRow['url'] != "")
						{
							if(substr($relatedproductsRow['url'], 0, 7) == 'http://' || substr($relatedproductsRow['url'], 0, 8) == 'https://')
							{
								$product_url = $validation->db_field_validate($relatedproductsRow['url']);
								$product_url_target = $validation->db_field_validate($relatedproductsRow['url_target']);
							}
							else
							{
								$product_url = BASE_URL."".$validation->db_field_validate($relatedproductsRow['url']);
								$product_url_target = $validation->db_field_validate($relatedproductsRow['url_target']);
							}
						}
						else
						{
							$product_url = BASE_URL.'products/'.$validation->db_field_validate($relatedproductsRow['title_id'])."/";
							$product_url_target = $validation->db_field_validate($relatedproductsRow['url_target']);
						}
						
						$relatedproduct_img = explode(" | ", $relatedproductsRow['imgName']);
						
						$wishlistResult = $db->view('*', 'rb_wishlist', 'wishlistid', "and regid = '$regid' and productid = '$productid' and status = 'active'");
						
						$checkvariantResult = $db->view('variantid,stock_quantity', 'rb_products_variants', 'variantid', "and productid = '$productid'", 'variantid asc');
						$checkvariantRow = $checkvariantResult['result'][0];
						$product_variantid = $validation->db_field_validate($checkvariantRow['variantid']);
						
						$cartResult2 = $db->view('cartid', 'rb_cart', 'cartid', "and regid = '$regid' and productid = '$productid' and variantid='$product_variantid' and status = 'active'");
						
						$pincode2 = $_SESSION['pincode'];
						$pincodeResult2 = $db->view('pincodeid,pincode', 'rb_pincodes', 'pincodeid', "and pincode = '$pincode2' and status = 'active'");
					?>
						<div class="product-item h-100">
							<div class="pi-pic d-flex align-items-center">
								<?php if($relatedproduct_img[0] != "" and file_exists(IMG_THUMB_LOC.$relatedproduct_img[0])) { ?>
									<img src="<?php echo BASE_URL.IMG_THUMB_LOC.$relatedproduct_img[0]; ?>" alt="<?php echo $validation->db_field_validate($relatedproductsRow['title']); ?>" title="<?php echo $validation->db_field_validate($relatedproductsRow['title']); ?>" class="mx-auto d-block" />
								<?php } else { ?>
									<img src="<?php echo BASE_URL; ?>images/noimage.jpg" title="<?php echo $validation->db_field_validate($relatedproductsRow['title']); ?>" class="mx-auto d-block" />
								<?php } ?>
								<?php if($relatedproductsRow['sale'] == 1) { ?>
									<div class="sale">Sale</div>
								<?php } ?>
								<div class="icon">
									<?php if($wishlistResult['num_rows'] >= 1) { ?>
										<a class="product-list-heart" href="<?php echo BASE_URL.'wishlist_delete.php?id='.$productid; ?>" title="Remove from wishlist"><i class="fa fa-heart"></i></a>
									<?php } else { ?>
										<a class="product-list-heart" href="<?php echo BASE_URL.'wishlist_inter.php?id='.$productid.'&q='.$full_url; ?>" title="Add to wishlist"><i class="fa fa-heart-o"></i></a>
									<?php } ?>
								</div>
								<form id="product-list-cart<?php echo $slr; ?>" action="<?php echo BASE_URL; ?>product-detail_inter.php?q=cart" method="post">
									<ul>
										<?php if($checkvariantRow['stock_quantity'] >= 1  and ($pincode != '' ? $pincodeResult2['num_rows'] >= 1 : $productid != "")) { ?>
											<input type="hidden" name="id" value="<?php echo $productid; ?>" />
											<input type="hidden" name="redirect_url" value="<?php echo $full_url; ?>" />
											<input type="hidden" name="price" value="<?php echo $productRow['price']; ?>" />
											<input type="hidden" name="variantid" value="<?php echo $product_variantid; ?>" />
											<input type="hidden" name="quantity" value="1" />
											<?php if($cartResult2['num_rows'] >= 1) { ?>
												<li class="w-icon active"><a href="<?php echo BASE_URL."cart".SUFFIX; ?>">Go to Cart</a></li>
											<?php } else { ?>
												<li class="w-icon active"><a href="javascript:void(0);" onClick="cart_add('<?php echo $slr; ?>');"><i class="fa fa-cart-plus"></i> Add to Cart</a></li>
											<?php } ?>
										<?php } else { ?>
											<li class="w-icon active"><a class="outofstock">Out of Stock <?php if($pincodeResult2['num_rows'] == 0 and $pincode2 != "") echo "for ".$pincode; ?></a></li>
										<?php } ?>
										
										<li class="quick-view"><a href="<?php echo $product_url; ?>" target="<?php echo $product_url_target; ?>">+ View</a></li>
									</ul>
								</form>
							</div>
							<div class="pi-text">
								<div class="catagory-name"><?php echo $validation->db_field_validate($categoryRow['title']); ?></div>
								<a href="<?php echo $product_url; ?>" target="<?php echo $product_url_target; ?>">
									<h5><?php echo $validation->getplaintext($relatedproductsRow['title'], 40); ?></h5>
								</a>
								<div class="product-price">
									<?php if($relatedproductsRow['price'] != '0') { ?>
										<?php if($relatedproductsRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" style="font-size:17.5px;" aria-hidden="true"></i>'; else $validation->db_field_validate($relatedproductsRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($relatedproductsRow['price'])); ?>
									<?php } ?>
									<?php if($relatedproductsRow['mrp'] != '0') { ?>
										<span><?php if($relatedproductsRow['currency_code'] == 'INR') echo '&#8377;'; else $validation->db_field_validate($relatedproductsRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($relatedproductsRow['mrp'])); ?></span>
									<?php } ?>
								</div>
								<!--<?php if($configRow['expected_delivery'] != "") { ?>
									<p class="text-center mt-2 mb-0 fs-13"><?php echo $validation->db_field_validate($configRow['expected_delivery']); ?></p>
								<?php } ?>-->
							</div>
						</div>
					<?php
						$slr++;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<div class="detail_section">
	<div class="container">

	<h3> How does it do it </h3>
		<div class="CustomSliderstyles__CustomSliderContainer-sc-j0mspw-0 gFlYlA key-ingredients-slider"><div class="slick-slider slick-initialized" dir="ltr"><svg width="100" height="100" viewBox="0 0 100 100" fill="none" style="display:block" class="CustomSliderstyles__CustomArrowContainer-sc-j0mspw-1 iZQErh slick-arrow slick-prev slick-disabled"><g filter="url(#filter0_d_5463_6339)"><circle cx="50" cy="40" r="30" transform="rotate(-180 50 40)" fill="white"></circle></g><path d="M54.5 31L45.5 40L54.5 49" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path><defs><filter id="filter0_d_5463_6339" x="0" y="0" width="100" height="100" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="10"></feOffset><feGaussianBlur stdDeviation="10"></feGaussianBlur><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"></feColorMatrix><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5463_6339"></feBlend><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5463_6339" result="shape"></feBlend></filter></defs></svg><div class="slick-list"><div class="slick-track" style="width:166.66666666666669%;left:0%"><div data-index="0" class="slick-slide slick-active slick-current" tabindex="-1" aria-hidden="false" style="outline:none;width:20%"><div><div class="IngredientCardstyles__IngredientCardContainer-sc-1xwidol-0 kiQcIg"><img src="https://ik.bebodywise.com/media/bebodywise/rcl-pdp/quarter_circle_9f-1Njo-1.png" alt="Quad Circle Image" class="ingredient-card__quarter-circle-image"/><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872662/Man%20Matters/Tostero%20120/ingredients/Shilajit.png" alt="icon image" class="ingredient-card__icon" loading="lazy"/><div class="ingredient-card__data-container"><div class="ingredient-card__title">Shudh Shilajit (200mg)</div><div class="ingredient-card__description">Shilajit is an ancient Ayurvedic medicine sourced from the higher altitudes of the Himalayan mountains</div><button class="ingredient-card__button">Learn More</button></div></div></div></div><div data-index="1" class="slick-slide slick-active" tabindex="-1" aria-hidden="false" style="outline:none;width:20%"><div><div class="IngredientCardstyles__IngredientCardContainer-sc-1xwidol-0 kiQcIg"><img src="https://ik.bebodywise.com/media/bebodywise/rcl-pdp/quarter_circle_9f-1Njo-1.png" alt="Quad Circle Image" class="ingredient-card__quarter-circle-image"/><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1640175372/Man%20Matters/Indulge%20Chocolate%20New/Claim%20icons/Natural_Caffeine.png" alt="icon image" class="ingredient-card__icon" loading="lazy"/><div class="ingredient-card__data-container"><div class="ingredient-card__title">Kaunchbeej (50mg)</div><div class="ingredient-card__description">A known aphrodisiac, regular consumption of Kaunchbeej helps raise sperm count and quality</div><button class="ingredient-card__button">Learn More</button></div></div></div></div><div data-index="2" class="slick-slide slick-active" tabindex="-1" aria-hidden="false" style="outline:none;width:20%"><div><div class="IngredientCardstyles__IngredientCardContainer-sc-1xwidol-0 kiQcIg"><img src="https://ik.bebodywise.com/media/bebodywise/rcl-pdp/quarter_circle_9f-1Njo-1.png" alt="Quad Circle Image" class="ingredient-card__quarter-circle-image"/><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872662/Man%20Matters/Tostero%20120/ingredients/Safed_Musli.png" alt="icon image" class="ingredient-card__icon" loading="lazy"/><div class="ingredient-card__data-container"><div class="ingredient-card__title">Safed Musli (50mg)</div><div class="ingredient-card__description">Safed Musli is better known as &#x27;divya aushadhi&#x27; or white gold</div><button class="ingredient-card__button">Learn More</button></div></div></div></div><div data-index="3" class="slick-slide" tabindex="-1" aria-hidden="true" style="outline:none;width:20%"><div><div class="IngredientCardstyles__IngredientCardContainer-sc-1xwidol-0 kiQcIg"><img src="https://ik.bebodywise.com/media/bebodywise/rcl-pdp/quarter_circle_9f-1Njo-1.png" alt="Quad Circle Image" class="ingredient-card__quarter-circle-image"/><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872662/Man%20Matters/Tostero%20120/ingredients/Gokshura.png" alt="icon image" class="ingredient-card__icon" loading="lazy"/><div class="ingredient-card__data-container"><div class="ingredient-card__title">Gokshura (50mg)</div><div class="ingredient-card__description">Gokshura is an effective testosterone booster for men</div><button class="ingredient-card__button">Learn More</button></div></div></div></div><div data-index="4" class="slick-slide" tabindex="-1" aria-hidden="true" style="outline:none;width:20%"><div><div class="IngredientCardstyles__IngredientCardContainer-sc-1xwidol-0 kiQcIg"><img src="https://ik.bebodywise.com/media/bebodywise/rcl-pdp/quarter_circle_9f-1Njo-1.png" alt="Quad Circle Image" class="ingredient-card__quarter-circle-image"/><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872662/Man%20Matters/Tostero%20120/ingredients/Ashwagandha.png" alt="icon image" class="ingredient-card__icon" loading="lazy"/><div class="ingredient-card__data-container"><div class="ingredient-card__title">Ashwagandha (50mg)</div><div class="ingredient-card__description">Ashwagandha is an ancient Indian herb often known as Indian ginseng</div><button class="ingredient-card__button">Learn More</button></div></div></div></div></div></div><svg width="100" height="100" viewBox="0 0 100 100" fill="none" style="display:block" class="CustomSliderstyles__CustomArrowContainer-sc-j0mspw-1 iZQErh slick-arrow slick-next"><g filter="url(#filter0_d_5459_6213)"><circle cx="50" cy="40" r="30" fill="white"></circle></g><path d="M45.5 49L54.5 40L45.5 31" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path><defs><filter id="filter0_d_5459_6213" x="0" y="0" width="100" height="100" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix><feOffset dy="10"></feOffset><feGaussianBlur stdDeviation="10"></feGaussianBlur><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"></feColorMatrix><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5459_6213"></feBlend><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5459_6213" result="shape"></feBlend></filter></defs></svg></div></div></path></svg>
<div class="accordion">
  <div class="accordion-tab">
    <input type="checkbox" id="toggle1" class="accordion-toggle" name="toggle">
		<label for="toggle1">How to use</label>
		<div class="accordion-content">
			<p>nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ?? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ??</p>
			<p>nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ?? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ?? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ??</p>
		</div>
   </div>

   <div class="accordion-tab">
    <input type="checkbox" id="toggle2" class="accordion-toggle" name="toggle">
		<label for="toggle2">Full List of Ingrdients</label>
		<div class="accordion-content">
			<p>nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ?? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ??</p>
			<p>nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ?? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ?? nfewbf jbduwegs jbduiadg jbdwuahdf bdiuwqgad jbdiuwqgas78i ??</p>
		</div>
   </div>
</div>
		</div>
</div>

</section>

<section>

<div class="safe-and-effective__content">
<h3> Safe & Effective</h3>	
<div class="safe-and-effective__card_container container-display">

	<div class="SafeAndEffectiveCardstyles__SafeAndEffectiveCardContainer-sc-jf8g5x-0 cRnXmG">
		<span class="safe-and-effective-card__icon">
		<img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872641/Man%20Matters/Tostero%20120/Claims/Ayurvedic_Proprietary_Medicine.png" alt="Ayurvedic Proprietary Medicine" loading="lazy"/></span>
		<h3 class="HeadingComponentWrapperstyles__HeadingComponentWrapper-sc-1aze4vx-0 bxdQOJ safe-and-effective-card__description">Ayurvedic Medicine</h3>
	</div>

	<div class="SafeAndEffectiveCardstyles__SafeAndEffectiveCardContainer-sc-jf8g5x-0 cRnXmG"><span class="safe-and-effective-card__icon"><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872641/Man%20Matters/Tostero%20120/Claims/No_Side_Effects.png" alt="No Side Effects" loading="lazy"/></span><h3 class="HeadingComponentWrapperstyles__HeadingComponentWrapper-sc-1aze4vx-0 bxdQOJ safe-and-effective-card__description">No Side Effects</h3></div><div class="SafeAndEffectiveCardstyles__SafeAndEffectiveCardContainer-sc-jf8g5x-0 cRnXmG"><span class="safe-and-effective-card__icon"><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872640/Man%20Matters/Tostero%20120/Claims/100__Natural.png" alt="100% Natural" loading="lazy"/></span><h3 class="HeadingComponentWrapperstyles__HeadingComponentWrapper-sc-1aze4vx-0 bxdQOJ safe-and-effective-card__description">100% Natural</h3></div><div class="SafeAndEffectiveCardstyles__SafeAndEffectiveCardContainer-sc-jf8g5x-0 cRnXmG"><span class="safe-and-effective-card__icon"><img src="https://ik.manmatters.com/mosaic-wellness/image/upload/f_auto,w_800,c_limit/v1626872641/Man%20Matters/Tostero%20120/Claims/Vegetarian.png" alt="Vegetarian" loading="lazy"/></span><h3 class="HeadingComponentWrapperstyles__HeadingComponentWrapper-sc-1aze4vx-0 bxdQOJ safe-and-effective-card__description">Vegetarian</h3></div></div></div>

</section>




<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
</body>
</html>