<?php
include_once("inc_config.php");

@$title_id = $validation->urlstring_validate($_GET['id']);
if($title_id == "")
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageResult = $db->view('*', 'rb_dynamic_pages', 'pageid', "and title_id='$title_id' and status='active'", '', '1');
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

$pageid = $pageRow['pageid'];

$where_query = "";
if($pageid != "")
{
	$where_query .= " and pageid = '$pageid'";
}
$where_query .= " and status='active'";

$table = "rb_dynamic_records";
$id = "recordid";
$orderby = "order_custom desc";
//$url_parameters = "&id=$title_id";
$url = BASE_URL."section/{$title_id}/20/";

$data = $pagination3->main($table, $url_parameters, $where_query, $id, $orderby, $url);
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

<section class="blog-section spad pt-0">
	<div class="container-fluid">
		<div class="row">
			
			<div class="col-lg-12">
				<div class="blog-details-inner">
					<div class="blog-detail-title mb-5">
						<h2><?php echo $validation->db_field_validate($pageRow['title']); ?></h2>
						<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>
						<?php if($pageRow['description'] != "") { ?>
							<div class="row mb-4">
								<?php echo $validation->db_field_validate($pageRow['description']); ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
			<div class="col-lg-9 order-1 order-lg-1">
				<div class="row">
					<?php
					if($data['num_rows'] >= 1)
					{
						foreach($data['result'] as $sectionRow)
						{
							if($sectionRow['url'] == "#")
							{
								$section_url = "#";
								$section_url_target = "";
							}
							else if($sectionRow['url'] != "http://www." and $sectionRow['url'] != "https://www." and $sectionRow['url'] != "")
							{
								if(substr($sectionRow['url'], 0, 7) == 'http://' || substr($sectionRow['url'], 0, 8) == 'https://')
								{
									$section_url = $validation->db_field_validate($sectionRow['url']);
									$section_url_target = $validation->db_field_validate($sectionRow['url_target']);
								}
								else
								{
									$section_url = BASE_URL."".$validation->db_field_validate($sectionRow['url']);
									$section_url_target = $validation->db_field_validate($sectionRow['url_target']);
								}
							}
							else
							{
								$section_url = BASE_URL.'section/'.$title_id.'/'.$validation->db_field_validate($sectionRow['title_id'])."/";
								$section_url_target = $validation->db_field_validate($sectionRow['url_target']);
							}
							
							$section_date = date('d', strtotime($sectionRow['createdate']));
							$section_month = date('M', strtotime($sectionRow['createdate']));
							
							$section_img = explode(" | ", $sectionRow['imgName']);
					?>
						<div class="col-lg-6 col-sm-6">
							<div class="blog-item box">
								<div class="bi-pic">
									<?php if($section_img[0] != "" and file_exists(IMG_MAIN_LOC.$section_img[0])) { ?>
										<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$section_img[0]; ?>" alt="<?php echo $validation->db_field_validate($sectionRow['title']); ?>" title="<?php echo $validation->db_field_validate($sectionRow['title']); ?>" />
									<?php } ?>
								</div>
								<div class="bi-text">
									<a href="<?php echo $section_url; ?>" target="<?php echo $section_url_target; ?>" title="<?php echo $validation->db_field_validate($sectionRow['title']); ?>">
										<h4><?php echo $validation->db_field_validate($sectionRow['title']); ?></h4>
									</a>
									<p><span>- <?php echo $validation->date_format_custom($sectionRow['createdate']); ?></span></p>
								</div>
							</div>
						</div>
					<?php
						}
					}
					?>
					
					<div class="col-lg-12">
						<div class="d-flex justify-content-center">
							<?php echo $data['pagination']; ?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-2">
				<?php include_once("inc_right.php"); ?>
			</div>
			
		</div>
	</div>
</section>

<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
</body>
</html>