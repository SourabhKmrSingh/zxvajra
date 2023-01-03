<?php
include_once("inc_config.php");

$pageid = "faq";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

$where_query = "";
$where_query .= "and status='active'";
$orderby_final = "order_custom desc";

$table = "rb_faqs";
$id = "faqid";
$url_parameters = "";

$data = $pagination2->main($table, $url_parameters, $where_query, $id, $orderby_final);
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

<div class="faq-section blog-details spad">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="faq-accordin box">
					<div class="accordion" id="accordionExample">
						<?php
						$slr = 1;
						if($data['num_rows'] >= 1)
						{
							foreach($data['result'] as $faqRow)
							{
						?>
							<div class="card">
								<div class="card-heading <?php if($slr == 1) echo "active"; ?>">
									<a class="<?php if($slr == 1) echo "active"; ?>" data-toggle="collapse" data-target="#collapse<?php echo $slr; ?>">
										<?php echo $validation->db_field_validate($faqRow['title']); ?>
									</a>
								</div>
								<div id="collapse<?php echo $slr; ?>" class="collapse <?php if($slr == 1) echo "show"; ?>" data-parent="#accordionExample">
									<div class="card-body">
										<?php echo $validation->db_field_validate($faqRow['description']); ?>
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
							<h4 class="text-center mt-0 w-100">No Record Found!</h4>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
</body>
</html>