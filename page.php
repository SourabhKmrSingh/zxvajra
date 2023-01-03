<?php
include_once("inc_config.php");

$pageid = $validation->urlstring_validate($_GET['id']);
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

if($pageRow['url'] != "http://www." and $pageRow['url'] != "https://www." and $pageRow['url'] != "" and $_SESSION['full_url'] != $full_url)
{
	if(substr($pageRow['url'], 0, 7) == 'http://' || substr($pageRow['url'], 0, 8) == 'https://')
	{
		$page_url = $validation->db_field_validate($pageRow['url']);
		$page_url_target = $validation->db_field_validate($pageRow['url_target']);
	}
	else
	{
		$page_url = BASE_URL."".$validation->db_field_validate($pageRow['url']);
		$page_url_target = $validation->db_field_validate($pageRow['url_target']);
	}
	
	$_SESSION['full_url'] = $full_url;
	header("Location: {$page_url}");
	exit();
}
$_SESSION['full_url'] = "";
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

<div class="breacrumb-section pt-1 pb-0">
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
							<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($pageRow['imgName']); ?>" title="<?php echo $validation->db_field_validate($pageRow['title']); ?>" alt="<?php echo $validation->db_field_validate($pageRow['title']); ?>" /><br>
						<?php } ?>
					</div>
					<div class="blog-detail-desc">
						<?php echo $validation->db_field_validate($pageRow['description']); ?>
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