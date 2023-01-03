<?php
include_once("inc_config.php");

@$q = strtolower($validation->urlstring_validate($_GET['q']));

if($q == "collaborate")
{
	$pageid = "want-to-collaborate";
}
else
{
	$pageid = "contact";
}
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

$_SESSION['csrf_token'] = substr(sha1(rand(1, 99999)),0,32);
$csrf_token = $_SESSION['csrf_token'];
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

<section class="contact-section spad pt-0">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-details-inner mb-5">
					<div class="blog-detail-title">
						<h2><?php echo $validation->db_field_validate($pageRow['title']); ?></h2>
						<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>
						<div><?php echo $validation->db_field_validate($pageRow['description']); ?></div>
					</div>
				</div>
			</div>
			<?php if($q == "") { ?>
			<div class="col-lg-5">
				<div class="contact-title">
					<h4><?php echo $validation->db_field_validate($pageRow['title']); ?></h4>
					<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>
				</div>
				<div class="contact-widget">
					<!--<div class="cw-item">
						<div class="ci-icon">
							<i class="ti-location-pin"></i>
						</div>
						<div class="ci-text">
							<span>Address:</span>
							<p>1st Floor, 32/43, street no. 9, bhikam singh colony, vishwas nagar, Delhi - 110032</p>
						</div>
					</div>-->
					<div class="cw-item">
						<div class="ci-icon">
							<i class="ti-mobile"></i>
						</div>
						<div class="ci-text">
							<span>Phone:</span>
							<p>+91-9711122119</p>
						</div>
					</div>
					<div class="cw-item">
						<div class="ci-icon">
							<i class="ti-email"></i>
						</div>
						<div class="ci-text">
							<span>Email:</span>
							<p>info@zxvanjra.com</p>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="col-lg-6 offset-lg-1">
				<div class="contact-form">
					<div class="leave-comment">
						<h4>Leave a Message</h4>
						<p>Our staff will call back later and answer your questions.</p>
						<?php if($_SESSION['success_msg_fe'] != "" || $_SESSION['error_msg_fe'] != "") { ?>
							<div class="text-center w-100 mb-3 font-weight-normal">
								<font color="green">
									<?php
									echo @$_SESSION['success_msg_fe'];
									@$_SESSION['success_msg_fe'] = "";
									?>
								</font>
								<font color="red">
									<?php
									echo @$_SESSION['error_msg_fe'];
									@$_SESSION['error_msg_fe'] = "";
									?>
								</font>
								<br /><br />
							</div>
						<?php } ?>
						<form action="<?php echo BASE_URL; ?>contact_inter.php" method="post" class="comment-form">
							<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />
							<div class="row">
								<?php if($q == "collaborate") { ?>
									<div class="col-sm-12">
										<input name="company" id="company" type="text" placeholder="Enter Company Name">
									</div>
								<?php } ?>
								<div class="col-sm-6">
									<input name="first_name" id="first_name" type="text" placeholder="Enter your First Name">
								</div>
								<div class="col-sm-6">
									<input name="last_name" id="last_name" type="text" placeholder="Enter your Last Name">
								</div>
								<div class="col-sm-12">
									<input name="email" id="email" type="email" placeholder="Enter Email Address">
								</div>
								<div class="col-sm-12">
									<input name="mobile" id="mobile" type="text" placeholder="Enter Mobile No.">
								</div>
								<div class="col-12">
									<input name="subject" id="subject" type="text" placeholder="Enter Subject">
								</div>
								<div class="col-lg-12">
									<textarea name="message" id="message" placeholder="Your message"></textarea>
									<button type="submit" class="site-btn">Send message</button>
								</div>
							</div>
						</form>
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