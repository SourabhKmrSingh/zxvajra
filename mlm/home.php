<?php
include_once("inc_config.php");
include_once("login_user_check.php");

$_SESSION['active_menu'] = "dashboard";
$membership_id = $_SESSION['mlm_membership_id'];

$registerResult = $db->view('regid,members,wallet_total,total_debit', 'mlm_registrations', 'regid', " and regid = '$regid'");
$registerRow = $registerResult['result'][0];

$creditResult = $db->view("SUM(amount) as total_credit_amount", "mlm_ewallet", "ewalletid", "and type='credit' and regid = '$regid'");
$creditRow = $creditResult['result'][0];

$debitResult = $db->view("SUM(amount) as total_debit_amount", "mlm_ewallet", "ewalletid", "and type='debit' and regid = '$regid'");
$debitRow = $debitResult['result'][0];

$enquiryResult = $db->view('enquiryid', 'mlm_enquiries', 'enquiryid');
$enquiryCount = $enquiryResult['num_rows'];
?>
<!DOCTYPE html>
<html LANG="en">
<head>
<?php include_once("inc_title.php"); ?>
<?php include_once("inc_files.php"); ?>
</head>
<body>
<div ID="wrapper">
<?php include_once("inc_header.php"); ?>
<div ID="page-wrapper">
<div CLASS="container-fluid">
	<div CLASS="row">
		<div CLASS="col-lg-12">
			<h1 CLASS="page-header">Dashboard</h1>
		</div>
	</div>
	<br>
	
	<?php if($_SESSION['mlm_account_number'] == "" || $_SESSION['mlm_document'] == "") { ?>
		<div CLASS="row mb-3">
			<div CLASS="col-12 text-center">
				<p class="font-weight-bold"><font color="red"><?php if($_SESSION['mlm_account_number'] == "") echo "Bank Details,"; if($_SESSION['mlm_document'] == "") echo " KYC Details"; ?> are mandatory otherwise you will not get any amount in your account. Please complete your profile from <a href="profile.php">here</a></font></p>
			</div>
		</div>
	<?php } ?>
	
	<div CLASS="row">
		<div CLASS="col-lg-4 col-md-6 mb-3 mb-md-0">
			<div CLASS="card card-blue">
				<div CLASS="card-heading">
					<div CLASS="row">
						<div CLASS="col-3">
							<i CLASS="fa fa-network-wired fa-5x"></i>
						</div>
						<div CLASS="col-9 text-right">
							<div CLASS="huge"><?php echo $validation->db_field_validate($registerRow['members']); ?></div>
							<div>Downline Members!</div>
						</div> 	
					</div>
				</div>
				<a HREF="genealogy.php">
					<div CLASS="card-footer">
						<span CLASS="float-left">View All</span>
						<span CLASS="float-right"><i CLASS="fa fa-arrow-circle-right"></i></span>
						<div CLASS="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div CLASS="col-lg-4 col-md-6 mb-4">
			<div CLASS="card card-green">
				<div CLASS="card-heading">
					<div CLASS="row">
						<div CLASS="col-3">
							<i CLASS="fas fa-wallet fa-5x"></i>
						</div>
						<div CLASS="col-9 text-right">
							<div CLASS="huge">&#8377;<?php echo $validation->price_format($registerRow['wallet_total']); ?></div>
							<div>Total Cashback Earned!</div>
						</div>
					</div>
				</div>
				<a HREF="ewallet_view.php?type=credit">
					<div CLASS="card-footer">
						<span CLASS="float-left">View All</span>
						<span CLASS="float-right"><i CLASS="fa fa-arrow-circle-right"></i></span>
						<div CLASS="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<!--<div CLASS="col-lg-3 col-md-6 mb-4">
			<div CLASS="card card-yellow">
				<div CLASS="card-heading">
					<div CLASS="row">
						<div CLASS="col-3">
							<i CLASS="fas fa-wallet fa-5x"></i>
						</div>
						<div CLASS="col-9 text-right">
							<div CLASS="huge">&#8377;<?php echo $validation->price_format($registerRow['total_debit']); ?></div>
							<div>Total Debit!</div>
						</div>
					</div>
				</div>
				<a HREF="ewallet_view.php?type=debit">
					<div CLASS="card-footer">
						<span CLASS="float-left">View All</span>
						<span CLASS="float-right"><i CLASS="fa fa-arrow-circle-right"></i></span>
						<div CLASS="clearfix"></div>
					</div>
				</a>
			</div>
		</div>-->
		<div CLASS="col-lg-4 col-md-6 mb-3 mb-md-0">
			<div CLASS="card card-red">
				<div CLASS="card-heading">
					<div CLASS="row">
						<div CLASS="col-3">
							<i CLASS="fa fa-envelope fa-5x"></i>
						</div>
						<div CLASS="col-9 text-right">
							<div CLASS="huge"><?php echo $enquiryCount; ?></div>
							<div>Enquiries/Tickets!</div>
						</div>
					</div>
				</div>
				<a HREF="enquiry_view.php">
					<div CLASS="card-footer">
						<span CLASS="float-left">View All</span>
						<span CLASS="float-right"><i CLASS="fa fa-arrow-circle-right"></i></span>
						<div CLASS="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</body>
</html>