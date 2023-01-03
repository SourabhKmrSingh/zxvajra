<?php
include_once("inc_config.php");

if($_SESSION['regid'] != "")
{
	header("Location: {$base_url}home{$suffix}");
	exit();
}

$pageid = "login";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

$redirect_url = $validation->urlstring_validate($_GET['url']);
$q = $validation->urlstring_validate($_GET['q']);

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
					
					<form action="<?php echo BASE_URL; ?>login_check.php" method="post" class="form-box">
						<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />
						<input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>" />
						<input type="hidden" name="q" value="<?php echo $q; ?>" />
						<div class="col-md-12 form-group">
							<h2 class="form-heading">Login Here</h2>
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
						<div class="group-input">
							<label for="username">Membership ID *</label>
							<input name="membership_id" id="membership_id" type="text" autocomplete="new-password" onKeyPress="uppercase('membership_id');" onKeyUp ="uppercase('membership_id');" onKeyDown="uppercase('membership_id');" required />
						</div>
						<div class="group-input">
							<label for="pass">Password *</label>
							<input name="password" id="password" type="password" autocomplete="new-password" required />
						</div>
						<div class="group-input gi-check">
							<div class="gi-more">
								<a href="<?php echo BASE_URL; ?>forgot-password<?php echo SUFFIX; ?>" class="forget-pass">Forgot your Password?</a>
							</div>
						</div>
						<button type="submit" class="site-btn login-btn">Sign In</button>
						
						<div class="switch-login">
							<a href="<?php echo BASE_URL."register".SUFFIX; ?>" class="or-login">Or Create An Account</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
<script>
function uppercase(input)
{
	var str = $("#"+input).val();
	var res = str.toUpperCase();
	$("#"+input).val(res);
}
</script>
</body>
</html>