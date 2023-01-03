<?php
include_once("inc_config.php");

$pageid = "coupons";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

$where_query = "";
$where_query .= " and expiry_date > '$createdate' and status='active'";

$table = "rb_coupons";
$id = "couponid";
$orderby = "order_custom desc";
$url_parameters = "";

$data = $pagination2->main($table, $url_parameters, $where_query, $id, $orderby);
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
					<span><?php echo $validation->db_field_validate($pageRow['title']); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="blog-details spad pt-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-details-inner">
					<div class="blog-detail-title">
						<h2><?php echo $validation->db_field_validate($pageRow['title']); ?></h2>
						<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>
					</div>
					<div class="blog-large-pic">
						<?php if($pageRow['imgName'] != "") { ?>
							<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($pageRow['imgName']); ?>" title="<?php echo $validation->db_field_validate($pageRow['title']); ?>" alt="<?php echo $validation->db_field_validate($pageRow['title']); ?>" class="img-fluid" /><br>
						<?php } ?>
					</div>
					
					<div class="blog_details">
						<?php echo $validation->db_field_validate($pageRow['description']); ?>
						
						<?php
						if($data['num_rows'] >= 1)
						{
							foreach($data['result'] as $couponRow)
							{
						?>
							<div class="home-box">
								<div class="box-column d-block">
									<h2 class="box-title">Coupon Code: <strong><?php echo $validation->db_field_validate($couponRow['coupon_code']); ?></strong></h2>
									<p class="box-description mt-3 mb-0 fs-15">Discount: <strong><?php echo $validation->db_field_validate($couponRow['discount'].'%'); ?></strong></p>
									<p class="box-description mt-2 mb-0 fs-15">Maximum Discount: <strong><?php if($couponRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" style="font-size:14px;" aria-hidden="true"></i>'; else $validation->db_field_validate($couponRow['currency_code']); ?><?php echo $validation->db_field_validate($couponRow['max_discount']); ?></strong></p>
									<p class="box-description mt-2 mb-0 fs-15">Minimum Price: <strong><?php if($couponRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" style="font-size:14px;" aria-hidden="true"></i>'; else $validation->db_field_validate($couponRow['currency_code']); ?><?php echo $validation->db_field_validate($couponRow['min_price']); ?></strong></p>
									<?php if($couponRow['description'] != "") { ?>
										<div class="box-description mt-3 mb-1 fs-15">Terms & Conditions:-<br /><?php echo $validation->db_field_validate($couponRow['description']); ?></div>
									<?php } ?>
								</div>
							</div>
						<?php
							}
						?>
							<nav class="blog-pagination justify-content-center d-flex">
								<?php echo $data['pagination']; ?>
							</nav>
						<?php
						}
						else
						{
						?>
							<h4 class="text-center font-weight-bold mt-5">No Coupon Found!</h4>
						<?php
						}
						?>
						
						<?php if($pageRow['fileName'] != "") { ?>
							<br /><a href="<?php echo BASE_URL.FILE_LOC.$validation->db_field_validate($pageRow['fileName']); ?>" target="_blank" class="main_btn rounded-0 w-25">Download File</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
</body>
</html>