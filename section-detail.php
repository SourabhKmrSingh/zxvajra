<?php
include_once("inc_config.php");

@$pageid = $validation->urlstring_validate($_GET['pageid']);
if($pageid == "")
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageResult = $db->view('*', 'rb_dynamic_pages', 'pageid', "and title_id='$pageid' and status='active'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];
$pageid = $pageRow['pageid'];

@$title_id = $validation->urlstring_validate($_GET['id']);
if($title_id == "")
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$sectionResult = $db->view('*', 'rb_dynamic_records', 'recordid', "and pageid='$pageid' and title_id='$title_id' and status='active'", '', '1');
if($sectionResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$sectionRow = $sectionResult['result'][0];
$recordid = $sectionRow['recordid'];
$section_img = explode(" | ", $sectionRow['imgName']);

$prevrecordResult = $db->view('*', 'rb_dynamic_records', 'recordid', "and pageid='$pageid' and recordid = (select max(recordid) from rb_dynamic_records where recordid < $recordid) and status='active'", '', '1');
$prevrecordRow = $prevrecordResult['result'][0];

$nextrecordResult = $db->view('*', 'rb_dynamic_records', 'recordid', "and pageid='$pageid' and recordid = (select min(recordid) from rb_dynamic_records where recordid > $recordid) and status='active'", '', '1');
$nextrecordRow = $nextrecordResult['result'][0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php if($sectionRow['meta_title'] != "") { ?>
<title><?php echo $validation->db_field_validate($sectionRow['meta_title']); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($sectionRow['meta_keywords']); ?>" />
<meta name="description" content="<?php echo $validation->db_field_validate($sectionRow['meta_description']); ?>" />
<?php } else { ?>
<title><?php echo $validation->db_field_validate($sectionRow['title'])." - ".$validation->db_field_validate($pageRow['title'])." | "; include_once("inc_title.php"); ?></title>
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
					<a href="<?php echo BASE_URL.'section/'.$pageRow['title_id'].'/'; ?>"><?php echo $validation->db_field_validate($pageRow['title']); ?></a>
					<span><?php echo $validation->db_field_validate($sectionRow['title']); ?></span>
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
				</div>
				<div class="blog-details-inner box mt-5 p-4">
					<div class="blog-detail-title">
						<h2><?php echo $validation->db_field_validate($sectionRow['title']); ?></h2>
						<h5><?php echo $validation->db_field_validate($sectionRow['tagline']); ?></h5>
						<p><span>- <?php echo $validation->date_format_custom($sectionRow['createdate']); ?> (<?php echo $validation->timecount("{$sectionRow['createdate']} {$sectionRow['createtime']}"); ?>)</span></p>
					</div>
					<!--<div class="blog-large-pic text-center">
						<?php if($section_img[0] != "" and file_exists(IMG_MAIN_LOC.$section_img[0])) { ?>
							<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$section_img[0]; ?>" title="<?php echo $validation->db_field_validate($sectionRow['title']); ?>" alt="<?php echo $validation->db_field_validate($sectionRow['title']); ?>" class="w-75" /><br>
						<?php } ?>
					</div>-->
					<div class="blog-detail-desc mt-4 mb-4">
						<?php echo $validation->db_field_validate($sectionRow['description']); ?>
					</div>
					<div class="tag-share">
						<div class="blog-share">
							<span>Share:</span>
							<div class="social-links">
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $full_url; ?>&title=<?php echo $validation->db_field_validate($sectionRow['title']); ?>" title="Facebook" target="_blank"><i class="ti-facebook"></i></a>
								<a href="http://twitter.com/share?text=<?php echo $validation->db_field_validate($postRow['title']); ?>&url=<?php echo $full_url; ?>" title="Twitter" target="_blank"><i class="ti-twitter-alt"></i></a>
								<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $full_url; ?>" title="Linkedin" target="_blank"><i class="ti-linkedin"></i></a>
								<a href="http://pinterest.com/pin/create/button/?url=<?php echo $full_url; ?>&media=<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($sectionRow['imgName']); ?>" title="Pinterest" target="_blank"><i class="ti-pinterest"></i></a>
								<a href="mailto:?subject=<?php echo $validation->db_field_validate($postRow['title']); ?>&body=Check out this site <?php echo $full_url; ?>" title="E-mail" target="_blank"><i class="ti-email"></i></a>
							</div>
						</div>
					</div>
					<div class="blog-post">
						<div class="row">
							<div class="col-lg-5 col-md-6">
								<?php if($prevrecordResult['num_rows'] >= 1) { ?>
									<a href="<?php echo BASE_URL.'section/'.$pageRow['title_id'].'/'.$validation->db_field_validate($prevrecordRow['title_id'])."/"; ?>" class="prev-blog">
										<div class="pb-pic">
											<i class="ti-arrow-left"></i>
											<img src="<?php echo BASE_URL.IMG_THUMB_LOC.$validation->db_field_validate($prevrecordRow['imgName']); ?>" alt="<?php echo $validation->db_field_validate($prevrecordRow['title']); ?>" />
										</div>
										<div class="pb-text">
											<span>Previous Post:</span>
											<h5><?php echo $validation->db_field_validate($prevrecordRow['title']); ?></h5>
										</div>
									</a>
								<?php } ?>
							</div>
							<div class="col-lg-5 offset-lg-2 col-md-6">
								<?php if($nextrecordResult['num_rows'] >= 1) { ?>
									<a href="<?php echo BASE_URL.'section/'.$pageRow['title_id'].'/'.$validation->db_field_validate($nextrecordRow['title_id'])."/"; ?>" class="next-blog">
										<div class="nb-pic">
											<img src="<?php echo BASE_URL.IMG_THUMB_LOC.$validation->db_field_validate($nextrecordRow['imgName']); ?>" alt="<?php echo $validation->db_field_validate($nextrecordRow['title']); ?>" />
											<i class="ti-arrow-right"></i>
										</div>
										<div class="nb-text">
											<span>Next Post:</span>
											<h5><?php echo $validation->db_field_validate($nextrecordRow['title']); ?></h5>
										</div>
									</a>
								<?php } ?>
							</div>
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
</html>