<?php
include_once("inc_config.php");

$page_name = "products";
$pageid = "our-products";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

// if($pageRow['url'] != "http://www." and $pageRow['url'] != "https://www." and $pageRow['url'] != "" and $_SESSION['full_url'] != $full_url)
// {
	// if(substr($pageRow['url'], 0, 7) == 'http://' || substr($pageRow['url'], 0, 8) == 'https://')
	// {
		// $page_url = $validation->db_field_validate($pageRow['url']);
		// $page_url_target = $validation->db_field_validate($pageRow['url_target']);
	// }
	// else
	// {
		// $page_url = BASE_URL."".$validation->db_field_validate($pageRow['url']);
		// $page_url_target = $validation->db_field_validate($pageRow['url_target']);
	// }
	
	// $_SESSION['full_url'] = $full_url;
	// header("Location: {$page_url}");
	// exit();
// }
// $_SESSION['full_url'] = "";

@$q = strtolower($validation->urlstring_validate($_GET['q']));
@$cat = $validation->urlstring_validate($_GET['cat']);
@$subcat = $validation->urlstring_validate($_GET['subcat']);
@$min = $validation->urlstring_validate($_GET['min']);
@$max = $validation->urlstring_validate($_GET['max']);
@$orderby = $validation->input_validate($_GET['orderby']);
@$order = $validation->input_validate($_GET['order']);
@$pagesize = $validation->input_validate($_GET['pagesize']);

$where_query = "";
$where_query_price = "";
if($q != "")
{
	$keys = explode(" ",$q);
	// $where_query .= " and (LOWER(title) LIKE '%$q%'";
	// $where_query_price .= " and (LOWER(title) LIKE '%$q%'";
	$where_query .= " and (";
	$where_query_price .= " and (";
	$slr = 1;
	foreach($keys as $k)
	{
		if($slr > 1)
		{
			$or_opr = "OR";
		}
		$where_query .= " $or_opr LOWER(title) LIKE '%$k%'";
		$where_query_price .= " $or_opr LOWER(title) LIKE '%$k%'";
		
		$slr++;
	}
	$where_query .= ")";
	$where_query_price .= ")";
}
// if($q != "")
// {
	// $where_query .= " and (LOWER(title) LIKE '%$q%')";
	// $where_query_price .= " and (LOWER(title) LIKE '%$q%')";
// }
if($cat != "")
{
	$where_query .= " and categoryid IN (select categoryid from rb_categories where title_id='$cat')";
	$where_query_price .= " and categoryid IN (select categoryid from rb_categories where title_id='$cat')";
}
if($subcat != "")
{
	$where_query .= " and subcategoryid IN (select subcategoryid from rb_subcategories where title_id='$subcat')";
	$where_query_price .= " and subcategoryid IN (select subcategoryid from rb_subcategories where title_id='$subcat')";
}
if($min != "" and $max != "")
{
	$where_query .= " and price between '$min' and '$max'";
}
$where_query .= " and status='active'";
$where_query_price .= " and status='active'";

if($orderby != "" and $order != "")
{
	$orderby_final = "{$orderby} {$order}";
	if($orderby == "createdate")
	{
		$orderby_final .= ", createtime {$order}";
	}
}
else
{
	$orderby_final = "order_custom desc";
}

$table = "rb_products";
$id = "productid";
$url_parameters = "&q=$q&cat=$cat&subcat=$subcat&min=$min&max=$max&orderby=$orderby&order=$order&pagesize=$pagesize";
$url_parameters_order = "&q=$q&cat=$cat&subcat=$subcat&min=$min&max=$max&pagesize=$pagesize";
$url_parameters_price = "&q=$q&cat=$cat&subcat=$subcat&orderby=$orderby&order=$order&pagesize=$pagesize";
$url_parameters_pagesize = "&q=$q&cat=$cat&subcat=$subcat&min=$min&max=$max&orderby=$orderby&order=$order";

$data = $pagination2->main($table, $url_parameters, $where_query, $id, $orderby_final);

if($cat != "")
{
	$maincategoryQueryResult = $db->view("title,title_id,meta_title,meta_keywords,meta_description,description", "rb_categories", "categoryid", "and title_id='{$cat}'");
	$maincategoryRow = $maincategoryQueryResult['result'][0];
}
if($subcat != "")
{
	$mainsubcategoryQueryResult = $db->view("title,title_id,meta_title,meta_keywords,meta_description,description", "rb_subcategories", "subcategoryid", "and title_id='{$subcat}'");
	$mainsubcategoryRow = $mainsubcategoryQueryResult['result'][0];
}

if($mainsubcategoryRow['title'] != "")
{
	$page_title = $validation->db_field_validate($mainsubcategoryRow['title']);
	$page_description = $validation->db_field_validate($mainsubcategoryRow['description']);
	$page_tagline = $validation->db_field_validate($mainsubcategoryRow['tagline']);
}
else if($maincategoryRow['title'] != "")
{
	$page_title = $validation->db_field_validate($maincategoryRow['title']);
	$page_description = $validation->db_field_validate($maincategoryRow['description']);
	$page_tagline = $validation->db_field_validate($maincategoryRow['tagline']);
}
else
{
	$page_title = $validation->db_field_validate($pageRow['title']);
	$page_description = $validation->db_field_validate($pageRow['description']);
	$page_tagline = $validation->db_field_validate($pageRow['tagline']);
}

$maxpriceResult = $db->view("MAX(price) as max_price", $table, $id, $where_query_price, $orderby_final);
$maxpriceRow = $maxpriceResult['result'][0];
$max_price = $maxpriceRow['max_price'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php if($mainsubcategoryRow['meta_title'] != "") { ?>
<title><?php echo $validation->db_field_validate($mainsubcategoryRow['meta_title']); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($mainsubcategoryRow['meta_keywords']); ?>" />
<meta name="description" content="<?php echo $validation->db_field_validate($mainsubcategoryRow['meta_description']); ?>" />
<?php } else if($maincategoryRow['meta_title'] != "") { ?>
<title><?php echo $validation->db_field_validate($maincategoryRow['meta_title']); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($maincategoryRow['meta_keywords']); ?>" />
<meta name="description" content="<?php echo $validation->db_field_validate($maincategoryRow['meta_description']); ?>" />
<?php } else if($pageRow['meta_title'] != "") { ?>
<title><?php echo $validation->db_field_validate($pageRow['meta_title']); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($pageRow['meta_keywords']); ?>" />
<meta name="description" content="<?php echo $validation->db_field_validate($pageRow['meta_description']); ?>" />
<?php } else { ?>
<title><?php echo $validation->db_field_validate($pageRow['title'])." | "; include_once("inc_title.php"); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($pageRow['title']); ?>" />
<?php } ?>
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
					<?php if($maincategoryRow['title'] != "") { ?>
						<a href="<?php echo BASE_URL.'products'.SUFFIX.'?cat='.$validation->db_field_validate($maincategoryRow['title_id']); ?>"><?php echo $validation->db_field_validate($maincategoryRow['title']); ?></a>
					<?php } ?>
					<?php if($mainsubcategoryRow['title'] != "") { ?>
						<a href="<?php echo BASE_URL.'products'.SUFFIX.'?cat='.$validation->db_field_validate($maincategoryRow['title_id']).'&subcat='.$validation->db_field_validate($mainsubcategoryRow['title_id']); ?>"><?php echo $validation->db_field_validate($mainsubcategoryRow['title']); ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="blog-details spad p-0 pt-1 pb-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-details-inner">
					<div class="blog-detail-title mb-0 pb-0">
						<h2 class="mb-0 pb-0"><?php echo $page_title; ?></h2>
						<h5 class="mb-0 pb-0"><?php echo $page_tagline; ?></h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="product-shop spad pt-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
				<?php include_once("inc_right_product.php"); ?>
			</div>
			<div class="col-lg-9 order-1 order-lg-2">
				<div><?php echo $page_description; ?></div>
				<div class="product-show-option">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-6">
							<div class="select-option">
								<select class="p-show" onChange="gotoURL(this.value);">
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX."?pagesize=24".$url_parameters_pagesize; ?>" <?php if($pagesize == "24") echo "selected"; ?>>Display: 24 per page</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX."?pagesize=36".$url_parameters_pagesize; ?>" <?php if($pagesize == "36") echo "selected"; ?>>Display: 36 per page</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX."?pagesize=48".$url_parameters_pagesize; ?>" <?php if($pagesize == "48") echo "selected"; ?>>Display: 48 per page</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-6 d-none d-sm-inline text-right">
							<p><?php echo $data['content']; ?></p>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="product-list col-nopadding">
					<div class="row">
						<?php
						$slr = 1;
						if($data['num_rows'] >= 1)
						{
							foreach($data['result'] as $productRow)
							{
								$productid = $productRow['productid'];
								
								$categoryid = $productRow['categoryid'];
								$categoryQueryResult = $db->view("title,title_id", "rb_categories", "categoryid", "and categoryid='{$categoryid}'");
								$categoryRow = $categoryQueryResult['result'][0];
								
								$subcategoryid = $productRow['subcategoryid'];
								$subcategoryQueryResult = $db->view("title,title_id", "rb_subcategories", "subcategoryid", "and subcategoryid='{$subcategoryid}'");
								$subcategoryRow = $subcategoryQueryResult['result'][0];
								
								if($productRow['url'] == "#")
								{
									$product_url = "#";
									$product_url_target = "";
								}
								else if($productRow['url'] != "http://www." and $productRow['url'] != "https://www." and $productRow['url'] != "")
								{
									if(substr($productRow['url'], 0, 7) == 'http://' || substr($productRow['url'], 0, 8) == 'https://')
									{
										$product_url = $validation->db_field_validate($productRow['url']);
										$product_url_target = $validation->db_field_validate($productRow['url_target']);
									}
									else
									{
										$product_url = BASE_URL."".$validation->db_field_validate($productRow['url']);
										$product_url_target = $validation->db_field_validate($productRow['url_target']);
									}
								}
								else
								{
									$product_url = BASE_URL.'products/'.$validation->db_field_validate($productRow['title_id'])."/";
									$product_url_target = $validation->db_field_validate($productRow['url_target']);
								}
								
								$product_img = explode(" | ", $productRow['imgName']);
								
								$wishlistResult = $db->view('wishlistid', 'rb_wishlist', 'wishlistid', "and regid = '$regid' and productid = '$productid' and status = 'active'");
								
								$checkvariantResult = $db->view('variantid,stock_quantity', 'rb_products_variants', 'variantid', "and productid = '$productid'", 'variantid asc');
								$checkvariantRow = $checkvariantResult['result'][0];
								$product_variantid = $validation->db_field_validate($checkvariantRow['variantid']);
								
								$cartResult = $db->view('cartid', 'rb_cart', 'cartid', "and regid = '$regid' and productid = '$productid' and variantid='$product_variantid' and status = 'active'");
								
								$pincode = $_SESSION['pincode'];
								$pincodeResult = $db->view('pincodeid,pincode', 'rb_pincodes', 'pincodeid', "and pincode = '$pincode' and status = 'active'");
						?>
							<div class="col-lg-3 col-sm-6 col-6 nopadding_custom">
								<div class="product-item h-100">
									<div class="pi-pic product-list d-flex align-items-center">
										<?php if($product_img[0] != "" and file_exists(IMG_THUMB_LOC.$product_img[0])) { ?>
											<img src="<?php echo BASE_URL.IMG_THUMB_LOC.$product_img[0]; ?>" alt="<?php echo $validation->db_field_validate($productRow['title']); ?>" title="<?php echo $validation->db_field_validate($productRow['title']); ?>" class="mx-auto d-block" />
										<?php } else { ?>
											<img src="<?php echo BASE_URL; ?>images/noimage.jpg" title="<?php echo $validation->db_field_validate($productRow['title']); ?>" class="mx-auto d-block" />
										<?php } ?>
										<?php if($productRow['sale'] == 1) { ?>
											<div class="sale pp-sale">Sale</div>
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
												<?php if($checkvariantRow['stock_quantity'] >= 1  and ($pincode != '' ? $pincodeResult['num_rows'] >= 1 : $productid != "")) { ?>
													<input type="hidden" name="id" value="<?php echo $productid; ?>" />
													<input type="hidden" name="redirect_url" value="<?php echo $full_url; ?>" />
													<input type="hidden" name="price" value="<?php echo $productRow['price']; ?>" />
													<input type="hidden" name="variantid" value="<?php echo $product_variantid; ?>" />
													<input type="hidden" name="quantity" value="1" />
													<?php if($cartResult['num_rows'] >= 1) { ?>
														<li class="w-icon active"><a href="<?php echo BASE_URL."cart".SUFFIX; ?>">Go to Cart</a></li>
													<?php } else { ?>
														<li class="w-icon active"><a href="javascript:void(0);" onClick="cart_add('<?php echo $slr; ?>');"><i class="fa fa-cart-plus"></i> Add to Cart</a></li>
													<?php } ?>
												<?php } else { ?>
													<li class="w-icon active"><a class="outofstock">Out of Stock <?php if($pincodeResult['num_rows'] == 0 and $pincode != "") echo "for ".$pincode; ?></a></li>
												<?php } ?>
												<li class="quick-view"><a href="<?php echo $product_url; ?>" target="<?php echo $product_url_target; ?>">+ View</a></li>
											</ul>
										</form>
									</div>
									<div class="pi-text mh_auto">
										<div class="catagory-name"><?php echo $validation->db_field_validate($categoryRow['title']); ?></div>
										<a href="<?php echo $product_url; ?>" target="<?php echo $product_url_target; ?>">
											<h5><?php echo $validation->getplaintext($productRow['title'], 40); ?></h5>
										</a>
										<div class="product-price">
											<?php if($productRow['price'] != '0') { ?>
												<?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" style="font-size:17.5px;" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($productRow['price'])); ?>
											<?php } ?>
											<?php if($productRow['mrp'] != '0') { ?>
												<span><?php if($productRow['currency_code'] == 'INR') echo '&#8377;'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($productRow['mrp'])); ?></span>
											<?php } ?>
										</div>
										<!--<?php if($configRow['expected_delivery'] != "") { ?>
											<p class="text-center mt-2 mb-0 fs-13"><?php echo $validation->db_field_validate($configRow['expected_delivery']); ?></p>
										<?php } ?>-->
									</div>
								</div>
							</div>
						<?php
								$slr++;
							}
						}
						else
						{
						?>
							<h4 class="text-center mt-5 w-100">No Product Found!</h4>
						<?php
						}
						?>
					</div>
				</div>
				<div class="d-flex justify-content-center">
					<?php echo $data['pagination']; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="clearfix"></div>

<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
<script>
$(document).ready(function(){
	var rangeSlider = $(".price-range"),
	minamount = $("#minamount"),
	maxamount = $("#maxamount"),
	minPrice = rangeSlider.data('min'),
	maxPrice = rangeSlider.data('max');
	rangeSlider.slider({
		range: true,
		min: 0,
		max: <?php echo $max_price; ?>,
		values: [ <?php if($min != "") echo $min; else echo "0"; ?>, <?php if($max != "") echo $max; else echo $max_price; ?> ],
		slide: function (event, ui) {
			$(".min_value_class").html(ui.values[0]);
			$(".max_value_class").html(ui.values[1]);
			//$(".min_value_class").html(number_format($(".min_value_class").html()));
			//$(".max_value_class").html(number_format($(".max_value_class").html()));
		},
		change : function (event, ui)
		{
			location.replace("<?php echo BASE_URL.''.$page_name.''.SUFFIX; ?>?min=" + ui.values[0] + "&max=" + ui.values[1] + "<?php echo $url_parameters_price; ?>");
		}
	});
	minamount.val(rangeSlider.slider("values", 0));
    maxamount.val(rangeSlider.slider("values", 1));
});
</script>
</body>
</html>