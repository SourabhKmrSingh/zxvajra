<?php
include_once("inc_config.php");

if($_SESSION['regid'] != "")
{
	header("Location: {$base_url}home{$suffix}");
	exit();
}

$pageid = "register";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

$redirect_url = $validation->urlstring_validate($_GET['url']);
$q = $validation->urlstring_validate($_GET['q']);
$id = $validation->urlstring_validate($_GET['id']);

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
			<div class="col-lg-8 offset-lg-2">
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
					
					<form action="<?php echo BASE_URL; ?>register_inter.php" method="post" class="form-box">
						<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />
						<div class="col-md-12 group-input">
							<h2 class="form-heading">Registration form</h2>
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
							<div class="col-md-6 group-input">
								<label for="sponsor_id">Referral ID *</label>
								<input name="sponsor_id" id="sponsor_id" type="text" value="<?php echo $id; ?>" onKeyPress="uppercase('sponsor_id');" onKeyUp ="uppercase('sponsor_id');" onKeyDown="uppercase('sponsor_id');" onBlur="get_sponsor(); get_sponsor_details();" />
								<p style="display:none;" class="mt-1 mb-0 error_cls text-left"><font color="red">Please enter a valid Sponsor ID</font></p>
								<div style="color:green;" class="mt-1 mb-0 success_cls text-left"></div>
							</div>
							<div class="col-md-6 group-input">
								<label for="sponsor_name">Referral Name *</label>
								<input name="sponsor_name" id="sponsor_name" type="text" readonly />
							</div>
							<div class="col-sm-6 group-input">
								<label for="first_name">First Name *</label>
								<input name="first_name" id="first_name" type="text" required />
							</div>
							<div class="col-sm-6 group-input">
								<label for="last_name">Last Name</label>
								<input name="last_name" id="last_name" type="text" />
							</div>
							<!--<div class="col-md-6 group-input">
								<label for="username">Username *</label>
								<input name="username" id="username" type="text" required />
							</div>-->
							<div class="col-sm-12 group-input">
								<label for="email">Email-ID</label>
								<input name="email" id="email" type="email" />
							</div>
							<div class="col-sm-6 group-input">
								<label for="password">Password *</label>
								<input name="password" id="password" type="password" autocomplete="new-password" required />
							</div>
							<div class="col-sm-6 group-input">
								<label for="confirm_password">Confirm Password *</label>
								<input name="confirm_password" id="confirm_password" type="password" autocomplete="new-password" required />
							</div>
							<div class="col-sm-12 group-input">
								<label for="mobile">Mobile No. *</label>
								<div class="input-group">
									<span class="input-group-text" id="basic-addon1">+91</span>
									<input name="mobile" id="mobile" type="text" placeholder="Enter 10 Digit Mobile No." aria-describedby="basic-addon1" class="w-75" onkeypress="return isNumberKey(event)" minlength="10" maxlength="10" required />
									<button type="button" id="otp" onclick="return sms_send();" class="btn btn-custom">Send OTP</button>
								</div>
								<span class="otp_success" style="color:green;display:none;"><i class="fa fa-check"></i> OTP Sent Successfully!</span>
								<span class="otp_failure" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter a valid number!</span>
								<span class="mobile_existed" style="color:red;display:none;"><i class="fa fa-times"></i> Mobile No. is already registered with us.</span>
							</div>
							<div class="col-sm-12 group-input verification_code_area" style="display:none;">
								<label for="verification_code">Verification Code *</label>
								<div class="input-group">
									<input name="verification_code" id="verification_code" type="text" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" class="w-50" required />
									<button type="button" id="otp_verify" onclick="return sms_otpverify();" class="btn btn-custom">Verify</button>
								</div>
								<span class="otp_verified" style="color:green;display:none;"><i class="fa fa-check"></i> Verified!</span>
								<span class="otp_verification_failed" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter correct OTP!</span>
							</div>
							<div class="col-md-12 group-input">
								<label for="address">Address *</label>
								<textarea class="form-control" name="address" id="address" required ><?php echo $validation->db_field_validate($registerRow['address']); ?></textarea>
							</div>
							<div class="col-md-12 group-input">
								<label for="landmark">Landmark</label>
								<input name="landmark" id="landmark" type="text" value="<?php echo $validation->db_field_validate($registerRow['landmark']); ?>" />
							</div>
							<div class="col-md-6 group-input">
								<label for="pincode">Pincode *</label>
								<input name="pincode" id="pincode" type="number" value="<?php echo $validation->db_field_validate($registerRow['pincode']); ?>" onBlur="fetch_pincode();" required />
								<span class="pincode_success" style="color:green;display:none;"><i class="fa fa-check"></i> Verified!</span>
								<span class="pincode_failure" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter a valid Pincode!</span>
							</div>
							<div class="col-md-6 group-input">
								<label for="city">City *</label>
								<input name="city" id="city" type="text" value="<?php echo $validation->db_field_validate($registerRow['city']); ?>" required />
							</div>
							<div class="col-md-6 group-input">
								<label for="state">State *</label>
								<input name="state" id="state" type="text" value="<?php echo $validation->db_field_validate($registerRow['state']); ?>" required />
							</div>
							<div class="col-md-6 group-input">
								<label for="country">Country *</label>
								<input name="country" id="country" type="text" value="<?php echo $validation->db_field_validate($registerRow['country']); ?>" required />
							</div>
							
							<!--<div class="col-md-12 group-input">
								<fieldset class="scheduler-border">
									<legend class="scheduler-border">Bank Details</legend>
									<div class="row">
										<div class="col-md-6 group-input">
											<label for="bank_name">Bank Name</label>
											<input name="bank_name" id="bank_name" type="text" />
										</div>
										<div class="col-md-6 group-input">
											<label for="account_number">Account Number</label>
											<input name="account_number" id="account_number" type="text" />
										</div>
										<div class="col-md-6 group-input">
											<label for="ifsc_code">Bank Swift/IFSC Code</label>
											<input name="ifsc_code" id="ifsc_code" type="text" />
										</div>
										<div class="col-md-6 group-input">
											<label for="account_name">Account Name</label>
											<input name="account_name" id="account_name" type="text" />
										</div>
									</div>
								</fieldset>
							</div>
							
							<div class="col-md-12 group-input">
								<fieldset class="scheduler-border">
									<legend class="scheduler-border">KYC Details</legend>
									<div class="row">
										<div class="col-md-6 group-input">
											<label for="pan_card">Document</label>
											<select class="form-control" name="document" id="document" >
												<option value="">--select--</option>
												<option value="Passport">Passport</option>
												<option value="Voter's Identity Card">Voter's Identity Card</option>
												<option value="Driving Licence">Driving Licence</option>
												<option value="Aadhaar Card">Aadhaar Card</option>
												<option value="NREGA Card">NREGA Card</option>
												<option value="PAN Card">PAN Card</option>
											</select>
										</div>
										<div class="col-md-6 group-input">
											<label for="document_number">Document Number</label>
											<input name="document_number" id="document_number" type="text" />
										</div>
									</div>
								</fieldset>
							</div>-->
						</div>
						
						<button type="submit" id="btnSubmit" disabled class="site-btn login-btn">Register</button>
						
						<div class="switch-login">
							<a href="<?php echo BASE_URL."login".SUFFIX; ?>" class="or-login">Or Log In</a>
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
function get_sponsor()
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>fetch_sponsor.php',
		data:
		{
			sponsor_id: $("#sponsor_id").val()
		},
		success: function (response)
		{
			if(response == "no")
			{
				$(".error_cls").show();
				$("#sponsor_id").val("");
				$("#sponsor_name").val("");
			}
			else
			{
				$("#sponsor_name").val(response);
				$(".error_cls").hide();
			}
		}
	});
}

function uppercase(input)
{
	var str = $("#"+input).val();
	var res = str.toUpperCase();
	$("#"+input).val(res);
}

$(document).ready(function(){
	get_sponsor();
	
	// $("#btnSubmit").click(function(){
		// if($("#verification_code").val() == "")
		// {
			// alert("Please verify your Mobile No.");
			// return false;
		// }
	// });
});

function sms_send()
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>sms_send.php',
		data:
		{
			mobile: $("#mobile").val()
		},
		success: function (response)
		{
			if(response == "existed")
			{
				$(".otp_success").hide();
				$(".otp_success").hide();
				$(".mobile_existed").show();
				$("#mobile").attr("style","border:1px solid red; color:red;");
				$("#btnSubmit").prop('disabled', true);
			}
			else if(response == "Done")
			{
				$(".otp_failure").hide();
				$(".mobile_existed").hide();
				$(".otp_success").show();
				$("#otp").html("Resend");
				$("#mobile").attr("style","border:1px solid green; color:green;");
				$(".verification_code_area").show();
				$("#btnSubmit").prop('disabled', true);
			}
			else
			{
				$(".otp_success").hide();
				$(".mobile_existed").hide();
				$(".otp_failure").show();
				$("#mobile").attr("style","border:1px solid red; color:red;");
				$("#btnSubmit").prop('disabled', true);
			}
		}
	});
}

function sms_otpverify()
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>sms_otpverify.php',
		data:
		{
			mobile: $("#mobile").val(),
			verification_code: $("#verification_code").val()
		},
		success: function (response)
		{
			if(response == "Done")
			{
				$(".otp_verification_failed").hide();
				$(".otp_verified").show();
				$("#otp").hide();
				$("#otp_verify").hide();
				$(".otp_success").hide();
				$(".otp_failure").hide();
				$("#mobile").attr("readonly", "readonly");
				$("#verification_code").attr("readonly", "readonly");
				$("#btnSubmit").prop('disabled', false);
				$("#verification_code").attr("style","border:1px solid green; color:green;");
			}
			else
			{
				$(".otp_verified").hide();
				$(".otp_verification_failed").show();
				$("#btnSubmit").prop('disabled', true);
				$("#verification_code").attr("style","border:1px solid red; color:red;");
			}
		}
	});
}

function fetch_pincode()
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>fetch_pincode.php',
		data:
		{
			pincode: $("#pincode").val()
		},
		success: function (response)
		{
			if(response == "no")
			{
				$(".pincode_failure").show();
				$(".pincode_success").hide();
				$("#pincode").attr("style","border:1px solid red; color:red;");
				$("#btnSubmit").prop('disabled', true);
			}
			else
			{
				var result = $.parseJSON(response);
				$("#city").val(result[0]);
				$("#state").val(result[1]);
				$("#country").val(result[2]);
				//$(".pincode_success").show();
				$(".pincode_failure").hide();
				$("#pincode").attr("style","border:1px solid green; color:green;");
				// if($("#verification_code").val() != "")
				// {
					// $("#btnSubmit").prop('disabled', false);
				// }
			}
		}
	});
}
</script>
</body>
</html>