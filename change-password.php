<?php
include_once("inc_config.php");

if($_SESSION['regid'] == "")
{
	$_SESSION['error_msg_fe'] = "Login to continue!";
	header("Location: {$base_url}login{$suffix}?url={$full_url}");
	exit();
}

$pageid = "change-password";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

$registerResult = $db->view("*", "rb_registrations", "regid", "and regid='{$regid}'");
$registerRow = $registerResult['result'][0];

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

<div class="register-login-section spad pt-0">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<div class="login-form">
					<div class="mb-5">
						<h2><?php echo $validation->db_field_validate($pageRow['title']); ?></h2>
						<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>
					</div>
					
					<?php if($pageRow['description'] != "") { ?>
						<div class="row mb-4">
							<div class="col-12">
								<?php echo $validation->db_field_validate($pageRow['description']); ?>
							</div>
						</div>
					<?php } ?>
					
					<form action="<?php echo BASE_URL; ?>change-password_inter.php" method="post" class="form-box">
						<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />
						<input type="hidden" name="user_ip" value="<?php echo $validation->db_field_validate($registerRow['user_ip']); ?>" />
						<div class="col-md-12 form-group">
							<h2 class="form-heading">Update your Password</h2>
							<hr class="form-heading-line" />
						</div>
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
						
						<div class="row">
							<div class="col-md-12 group-input">
								<label for="old_password">Old Password</label>
								<input class="form-control" name="old_password" id="old_password" type="password" required />
							</div>
							<div class="col-md-6 group-input">
								<label for="password">New Password</label>
								<input class="form-control" name="password" id="password" type="password" autocomplete="new-password" required />
							</div>
							<div class="col-md-6 group-input">
								<label for="confirm_password">Confirm New Password</label>
								<input class="form-control" name="confirm_password" id="confirm_password" type="password" autocomplete="new-password" required />
							</div>
						</div>
						
						<button type="submit" class="site-btn login-btn">Update</button>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
</body>
</html>