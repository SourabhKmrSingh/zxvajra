<?php

include_once("inc_config.php");



$pageid = "reset-your-password";

$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');

if($pageResult['num_rows'] == 0)

{

	header("Location: {$base_url}error{$suffix}");

	exit();

}

$pageRow = $pageResult['result'][0];



$redirect_url = $validation->urlstring_validate($_GET['url']);



$mobile = $validation->input_validate($_GET['mobile']);

$regid_custom = $validation->input_validate($_GET['q']);



$nowdatetime =  date('Y-m-d H:i:s');

$checkResult = $db->view("regid", "rb_registrations", "regid", "and regid_custom='{$regid_custom}' and mobile='{$mobile}' and expirydatetime >= '{$nowdatetime}' and status='active'");

if($checkResult['num_rows'] == 0)

{

	$_SESSION['error_msg_fe'] = "The link has expired. Please generate a new link!";

	header("Location: {$base_url}forgot-password{$suffix}");

	exit();

}



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

					

					<form action="<?php echo BASE_URL; ?>forgot-password-complete_inter.php" method="post" class="form-box">

						<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />

						<input type="hidden" name="mobile" value="<?php echo $mobile; ?>" />

						<input type="hidden" name="regid_custom" value="<?php echo $regid_custom; ?>" />

						<input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>" />

						<div class="col-md-12 form-group">

							<h2 class="form-heading">Create a new Password</h2>

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

								<input name="password" id="password" type="password" placeholder="Enter Password" autocomplete="new-password" required />

							</div>

							<div class="col-md-12 group-input">

								<input name="confirm_password" id="confirm_password" type="password" placeholder="Confirm Password" autocomplete="new-password" required />

							</div>

						</div>

						

						<button type="submit" class="site-btn login-btn">Reset Password</button>

						

						<div class="switch-login">

							Remember your password? <a href="<?php echo BASE_URL."login".SUFFIX; ?>" class="or-login">Login</a>

						</div>

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