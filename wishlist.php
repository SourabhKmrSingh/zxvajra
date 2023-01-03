<?php
include_once("inc_config.php");

if($_SESSION['regid'] == "")
{
	$_SESSION['error_msg_fe'] = "Login to continue!";
	header("Location: {$base_url}login{$suffix}?url={$full_url}");
	exit();
}

$page_name = "wishlist";
$pageid = "wishlist";
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
@$min = $validation->urlstring_validate($_GET['min']);
@$max = $validation->urlstring_validate($_GET['max']);
@$orderby = $validation->input_validate($_GET['orderby']);
@$order = $validation->input_validate($_GET['order']);

$where_query = "";
$where_query_price = "";
if($q != "")
{
	$where_query .= " and LOWER(title) LIKE '%$q%'";
	$where_query_price .= " and LOWER(title) LIKE '%$q%'";
}
if($min != "" and $max != "")
{
	$where_query .= " and price between '$min' and '$max'";
}
$where_query .= " and productid IN (select productid from rb_wishlist where regid='$regid') and status='active'";
$where_query_price .= " and productid IN (select productid from rb_wishlist where regid='$regid') and status='active'";

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
$url_parameters = "&q=$q&min=$min&max=$max&orderby=$orderby&order=$order";
$url_parameters_order = "&q=$q&min=$min&max=$max";
$url_parameters_price = "&q=$q&orderby=$orderby&order=$order";

$data = $pagination2->main($table, $url_parameters, $where_query, $id, $orderby_final);

$maxpriceResult = $db->view("MAX(price) as max_price", $table, $id, $where_query_price, $orderby_final);
$maxpriceRow = $maxpriceResult['result'][0];
$max_price = $maxpriceRow['max_price'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php if($pageRow['meta_title'] != "") { ?>
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

<section class="blog-details spad p-0 pt-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-details-inner">
					<div class="blog-detail-title">
						<h2><?php echo $validation->db_field_validate($pageRow['title']); ?></h2>
						<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="product-shop spad pt-5">
	<div class="container-fluid">
		<div class="row">
			<!--<div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
				<?php include_once("inc_right_product.php"); ?>
			</div>-->
			<div class="col-lg-12 order-1 order-lg-2">
				<div class="product-show-option">
					<div class="row">
						<div class="col-lg-4 col-md-5 col-sm-12 col-12">
							<div class="select-option">
								<select class="sorting" onChange="gotoURL(this.value);">
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX; ?>">Default Sorting</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=title&order=asc'.$url_parameters_order; ?>" <?php if($orderby == "title" and $order == "asc") echo "selected"; ?>>A-Z</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=title&order=desc'.$url_parameters_order; ?>" <?php if($orderby == "title" and $order == "desc") echo "selected"; ?>>Z-A</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=price&order=asc'.$url_parameters_order; ?>" <?php if($orderby == "price" and $order == "asc") echo "selected"; ?>>Price - Low to High</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=price&order=desc'.$url_parameters_order; ?>" <?php if($orderby == "price" and $order == "desc") echo "selected"; ?>>Price - High to Low</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=createdate&order=desc'.$url_parameters_order; ?>" <?php if($orderby == "createdate" and $order == "desc") echo "selected"; ?>>Newest First</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=views&order=desc'.$url_parameters_order; ?>" <?php if($orderby == "views" and $order == "desc") echo "selected"; ?>>Popularity</option>
								</select>
								<select class="p-show" onChange="gotoURL(this.value);">
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX."?pagesize=24".$url_parameters_pagesize; ?>" <?php if($pagesize == "24") echo "selected"; ?>>Display: 24 per page</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX."?pagesize=36".$url_parameters_pagesize; ?>" <?php if($pagesize == "36") echo "selected"; ?>>Display: 36 per page</option>
									<option value="<?php echo BASE_URL.''.$page_name.''.SUFFIX."?pagesize=48".$url_parameters_pagesize; ?>" <?php if($pagesize == "48") echo "selected"; ?>>Display: 48 per page</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-12 col-6 mt-md-0 mt-3">
							<div class="filter_con filter-widget">
								<div class="filter-range-wrap">
									<div class="drag_value">
										<div class="min_value"><span class="">₹</span> <span class="min_value_class"><?php if($min != "") echo number_format($min); else echo "0"; ?></span></div>
										<div class="max_value"><span class="">₹</span> <span class="max_value_class"><?php if($max != "") echo number_format($max); else echo number_format($max_price); ?></span></div>
									</div>
									<div class="dragable">
										<div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="0" data-max="<?php echo $max_price; ?>">
											<div class="ui-slider-range ui-corner-all ui-widget-header"></div>
											<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
											<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-3 col-sm-12 col-6 text-right pt-sm-0 pt-3">
							<p><?php echo $data['content']; ?></p>
						</div>
					</div>
				</div>
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
								
								$wishlistResult = $db->view('*', 'rb_wishlist', 'wishlistid', "and regid = '$regid' and productid = '$productid' and status = 'active'");
						?>
							<div class="col-lg-3 col-sm-6">
								<div class="product-item">
									<div class="pi-pic product-list d-flex align-items-center">
										<?php if($product_img[0] != "" and file_exists(IMG_MAIN_LOC.$product_img[0])) { ?>
											<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$product_img[0]; ?>" alt="<?php echo $validation->db_field_validate($productRow['title']); ?>" title="<?php echo $validation->db_field_validate($productRow['title']); ?>" />
										<?php } else { ?>
											<img src="<?php echo BASE_URL; ?>images/noimage.jpg" title="<?php echo $validation->db_field_validate($productRow['title']); ?>" />
										<?php } ?>
										<?php if($productRow['sale'] == 1) { ?>
											<div class="sale pp-sale">Sale</div>
										<?php } ?>
										<div class="icon">
											<?php if($wishlistResult['num_rows'] >= 1) { ?>
												<a class="product-list-heart" href="<?php echo BASE_URL.'wishlist_delete.php?id='.$productid; ?>" title="Remove from wishlist"><i class="fa fa-heart"></i></a>
											<?php } else { ?>
												<a class="product-list-heart" href="<?php echo BASE_URL.'wishlist_inter.php?id='.$productid; ?>" title="Add to wishlist"><i class="fa fa-heart-o"></i></a>
											<?php } ?>
										</div>
										<!--<ul>
											<li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
											<li class="quick-view"><a href="#">+ Quick View</a></li>
											<li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
										</ul>-->
									</div>
									<div class="pi-text">
										<div class="catagory-name"><?php echo $validation->db_field_validate($categoryRow['title']); ?></div>
										<a href="<?php echo $product_url; ?>" target="<?php echo $product_url_target; ?>">
											<h5><?php echo $validation->db_field_validate($productRow['title']); ?></h5>
										</a>
										<div class="product-price">
											<?php if($productRow['price'] != '0') { ?>
												<?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" style="font-size:17.5px;" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($productRow['price'])); ?>
											<?php } ?>
											<?php if($productRow['mrp'] != '0') { ?>
												<span><?php if($productRow['currency_code'] == 'INR') echo '&#8377;'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($productRow['mrp'])); ?></span>
											<?php } ?>
										</div>
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