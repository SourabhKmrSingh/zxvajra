<?php

include_once("inc_config.php");



if($_SESSION['regid'] == "")

{

	$_SESSION['error_msg_fe'] = "Login to continue!";

	header("Location: {$base_url}login{$suffix}?url={$full_url}");

	exit();

}



$pageid = "user-home";

$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');

if($pageResult['num_rows'] == 0)

{

	header("Location: {$base_url}error{$suffix}");

	exit();

}

$pageRow = $pageResult['result'][0];



// $walletResult = $db->view("SUM(amount) as total_wallet_amount", "mlm_ewallet", "regid", "and type='credit' and regid='{$regid}'");

// $walletRow = $walletResult['result'][0];

// $total_wallet_amount = $walletRow['total_wallet_amount'];



// $walletrequestsResult = $db->view("SUM(amount) as total_requests_amount", "mlm_ewallet_requests", "regid", "and status != 'declined' and regid='{$regid}'");

// $walletrequestsRow = $walletrequestsResult['result'][0];

// $total_requests_amount = $walletrequestsRow['total_requests_amount'];



$totalwalletResult = $db->view('wallet_total,wallet_money,membership_id', 'mlm_registrations', 'regid', "and regid = '$regid' and status='active'");

$totalwalletRow = $totalwalletResult['result'][0];

$wallet_money = $totalwalletRow['wallet_money'];

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



<section class="blog-details spad pt-4">

	<div class="container-fluid">

		<div class="row">

			<div class="col-lg-12">

				<div class="blog-details-inner">

					<div class="blog-detail-title mb-5">

						<h2>Hi, <?php echo $_SESSION['first_name'].' '.$_SESSION['last_name']; ?></h2>

						<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>

					</div>

					<div class="blog-large-pic">

						<?php if($pageRow['imgName'] != "") { ?>

							<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($pageRow['imgName']); ?>" title="<?php echo $validation->db_field_validate($pageRow['title']); ?>" alt="<?php echo $validation->db_field_validate($pageRow['title']); ?>" class="img-fluid" /><br>

						<?php } ?>

					</div>

					

					<div class="blog_details">

						<?php echo $validation->db_field_validate($pageRow['description']); ?>

						

						<div class="text-center mb-4">

							<h6>Referral Link: <span class="anchor-tag"><?php echo BASE_URL.'register'.SUFFIX.'?id='.$validation->db_field_validate($totalwalletResult['membership_id']); ?></span></h6>

							<h6 class="mt-2">Your E-Wallet Balance is <strong>&#8377;<?php echo $validation->price_format($wallet_money); ?></strong></h6>

						</div>

						

						<div class="row">

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'orders'.SUFFIX; ?>" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/your-orders.png"; ?>" alt="Your Orders" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">Your Orders</h2>

											<p class="box-description">Track, history or buy things again</p>

										</div>

									</div>

								</a>

							</div>

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'mlm'.SUFFIX; ?>" target="_blank" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/cashback-portal.png"; ?>" alt="Profile & Address" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">Cashback Portal</h2>

											<p class="box-description">Check your downlines, cashback history etc.</p>

										</div>

									</div>

								</a>

							</div>

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'profile'.SUFFIX; ?>" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/profile-address.png"; ?>" alt="Profile & Address" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">Profile & Address</h2>

											<p class="box-description">Edit login name, mobile number or address</p>

										</div>

									</div>

								</a>

							</div>

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'change-password'.SUFFIX; ?>" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/password.png"; ?>" alt="Change Password" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">Change Password</h2>

											<p class="box-description">Secure your account</p>

										</div>

									</div>

								</a>

							</div>

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'wishlist'.SUFFIX; ?>" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/wishlist.png"; ?>" alt="My Wishlist" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">My Wishlist</h2>

											<p class="box-description">Check your wishlist</p>

										</div>

									</div>

								</a>

							</div>

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'coupons'.SUFFIX; ?>" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/coupons.png"; ?>" alt="My Coupons" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">My Coupons</h2>

											<p class="box-description">Your Promotional Codes</p>

										</div>

									</div>

								</a>

							</div>

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'cart'.SUFFIX; ?>" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/cart.png"; ?>" alt="Shopping Cart" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">Shopping Cart</h2>

											<p class="box-description">Check items in your cart</p>

										</div>

									</div>

								</a>

							</div>

							<div class="col-sm-4">

								<a href="<?php echo BASE_URL.'logout'.SUFFIX; ?>" class="home-box-link">

									<div class="home-box">

										<div class="box-column-1">

											<img src="<?php echo BASE_URL."images/logout.png"; ?>" alt="Logout" />

										</div>

										<div class="box-column-2">

											<h2 class="box-title">Logout</h2>

											<p class="box-description">Close all sessions</p>

										</div>

									</div>

								</a>

							</div>

						</div>

						

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