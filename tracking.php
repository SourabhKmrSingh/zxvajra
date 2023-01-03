<?php
include_once("inc_config.php");

$pageid = "track-your-order";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

@$refno = $validation->urlstring_validate($_GET['order']);

if($refno != "")
{
	$purchaseResult = $db->view("*", "rb_purchases", "purchaseid", "and refno='{$refno}' and regid='{$regid}' and status='active'", "purchaseid desc");
	if($purchaseResult['num_rows'] == 0)
	{
		$msg = "No order placed with the given order id yet!";
	}
	$purchaseRow = $purchaseResult['result'][0];
	
	foreach($tracking_msgs as $key => $value)
	{
		if($purchaseRow['tracking_status'] == $key)
		{
			$url = BASE_URL.'order-detail'.SUFFIX.'?ref='.$purchaseRow['refno'];
			$msg = $value.'<br /><p class="mt-3" style="font-size:18px;"><a href="'.$url.'">click here</a> to check your order details</p>';
			break;
		}
	}
}
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
			<div class="col-lg-10 offset-lg-1">
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
					
					<form action="" method="get" class="form-box">
						<div class="col-md-12 form-group">
							<h2 class="form-heading">Check status of your order</h2>
							<hr class="form-heading-line" />
							<?php if($refno == "") { ?>
								<p class="text-left mb-4">To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
							<?php } ?>
						</div>
						<?php if($refno != "") { ?>
							<h4 class="text-center font-weight-bold mt-5">
								<?php echo @$msg; ?>
							</h4>
						<?php } else { ?>
							<div class="group-input">
								<label for="username">Order ID *</label>
								<input type="text" id="order" name="order" />
							</div>
							<button type="submit" class="site-btn login-btn">Track Order</button>
						<?php } ?>
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