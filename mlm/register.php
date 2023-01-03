<?php
include_once("inc_config.php");

if($_SESSION['mlm_regid'] != '')
{
	$_SESSION['success_msg'] = "You're Logged In!";
	header("Location: home.php");
	exit();
}

$id = $validation->urlstring_validate($_GET['id']);

$_SESSION['csrf_token'] = substr(sha1(rand(1, 99999)),0,32);
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html>
<head>
<?php include_once("inc_title.php"); ?>
<?php include_once("inc_files.php"); ?>
<link rel="stylesheet" href="admin/assets/css/index_style.css">
<script>
$(window).bind("load", function(){
	$.notify("<?php echo @$_SESSION['success_msg']; ?>", { className: 'success', autoHide: true, autoHideDelay: 8000 });
	$.notify("<?php echo @$_SESSION['error_msg']; ?>", { className: 'error', autoHide: true, autoHideDelay: 8000 });
});
</script>
<?php
@$_SESSION['success_msg'] = "";
@$_SESSION['error_msg'] = "";
?>

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

/*function get_sponsor_details()
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>fetch_sponsor_details.php',
		data:
		{
			sponsor_id: $("#sponsor_id").val()
		},
		success: function (response)
		{
			$(".success_cls").html(response);
		}
	});
}*/

$(document).ready(function(){
	get_sponsor();
	get_sponsor_details();
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
				$("#verification_code").attr("style","border:1px solid red; color:red;");
			}
		}
	});
}
</script>
</head>
<body>
<div class="login-page">
	<br />
	<div class="row">
	<div class="col-md-6 offset-md-3">
	<div class="w-100">
		<form class="row form-box" action="<?php echo BASE_URL; ?>register_inter.php" method="post">
			<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />
			
			<div class="col-md-6 form-group">
				<h2 class="form-heading">Registration form</h2>
				<hr class="form-heading-line" />
			</div>
			<div class="col-md-6 form-group">
				<div class="logo d-flex justify-content-end"><?php if($configRow['logo'] != "") { ?><a href="<?php echo BASE_URL; ?>"><img src="<?php echo FILE_LOC."".$validation->db_field_validate($configRow['logo']); ?>" class="img-responsive mb-3" /></a><?php } ?></div>
			</div>
			
			<div class="col-md-6 form-group">
				<label for="sponsor_id">Sponsor's ID *</label>
				<input class="form-control" name="sponsor_id" id="sponsor_id" type="text" value="<?php echo $id; ?>" onBlur="get_sponsor(); get_sponsor_details();" />
				<p style="display:none;" class="mt-1 mb-0 error_cls text-left"><font color="red">Please enter a valid Sponsor ID</font></p>
				<div style="color:green;" class="mt-1 mb-0 success_cls text-left"></div>
				
			</div>
			<div class="col-md-6 form-group">
				<label for="sponsor_name">Sponsor's Name *</label>
				<input class="form-control" name="sponsor_name" id="sponsor_name" type="text" readonly />
			</div>
			<div class="col-md-6 form-group">
				<label for="first_name">First Name *</label>
				<input class="form-control" name="first_name" id="first_name" type="text" value="<?php echo $_SESSION['first_name']; ?>" required />
			</div>
			<div class="col-md-6 form-group">
				<label for="last_name">Last Name</label>
				<input class="form-control" name="last_name" id="last_name" type="text" value="<?php echo $_SESSION['last_name']; ?>" />
			</div>
			<div class="col-md-6 form-group">
				<label for="username">Username *</label>
				<input class="form-control" name="username" id="username" type="text" required />
			</div>
			<div class="col-md-6 form-group">
				<label for="email">Email-ID *</label>
				<input class="form-control" name="email" id="email" type="email" value="<?php echo $_SESSION['email']; ?>" <?php if($_SESSION['email'] != "") echo "readonly"; ?> required />
			</div>
			<div class="col-md-6 form-group">
				<label for="password">Password *</label>
				<input class="form-control" name="password" id="password" type="password" autocomplete="new-password" required />
			</div>
			<div class="col-md-6 form-group">
				<label for="confirm_password">Confirm Password *</label>
				<input class="form-control" name="confirm_password" id="confirm_password" type="password" autocomplete="new-password" required />
			</div>
			<div class="col-md-6 form-group text-left">
				<label for="mobile">Mobile No. *</label>
				<div class="input-group mb-1">
					<span class="input-group-text" id="basic-addon1" style="height: 31px;">+91</span>
					<input class="form-control" name="mobile" id="mobile" type="text" placeholder="Enter 10 Digit Mobile No." aria-describedby="basic-addon1" onkeypress="return isNumberKey(event)" minlength="10" maxlength="10" value="<?php echo $_SESSION['mobile']; ?>" <?php if($_SESSION['mobile'] != "") echo "readonly"; ?> required />
					<?php if($_SESSION['mobile'] == "") { ?>
						<button type="button" id="otp" onclick="return sms_send();" class="btn btn-primary btn-block w-auto btn_custom">Send OTP</button>
					<?php } ?>
				</div>
				<span class="otp_success" style="color:green;display:none;"><i class="fa fa-check"></i> OTP Sent Successfully!</span>
				<span class="otp_failure" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter a valid number!</span>
				<span class="mobile_existed" style="color:red;display:none;"><i class="fa fa-times"></i> Mobile No. is already registered with us.</span>
				
				<?php if($_SESSION['mobile'] == "") { ?>
					<div class="verification_code_area mt-3" style="display:none;">
						<label for="verification_code">Verification Code</label>
						<div class="input-group">
							<input class="form-control" name="verification_code" id="verification_code" type="text" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" class="w-50" required />
							<button type="button" id="otp_verify" onclick="return sms_otpverify();" class="btn btn-primary btn-block w-auto btn_custom">Verify</button>
						</div>
						<span class="otp_verified" style="color:green;display:none;"><i class="fa fa-check"></i> Verified!</span>
						<span class="otp_verification_failed" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter correct OTP!</span>
					</div>
				<?php } ?>
			</div>
			<div class="col-md-6 form-group">
				<label for="pincode">Pincode *</label>
				<input class="form-control" name="pincode" id="pincode" type="number" value="<?php echo $_SESSION['pincode']; ?>" required />
			</div>
			
			<div class="col-md-12 form-group">
				<fieldset class="scheduler-border">
					<legend class="scheduler-border">Bank Details</legend>
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="bank_name">Bank Name</label>
							<input class="form-control" name="bank_name" id="bank_name" type="text" />
						</div>
						<div class="col-md-6 form-group">
							<label for="account_number">Account Number</label>
							<input class="form-control" name="account_number" id="account_number" type="text" />
						</div>
						<div class="col-md-6 form-group">
							<label for="ifsc_code">Bank Swift/IFSC Code</label>
							<input class="form-control" name="ifsc_code" id="ifsc_code" type="text" />
						</div>
						<div class="col-md-6 form-group">
							<label for="account_name">Account Name</label>
							<input class="form-control" name="account_name" id="account_name" type="text" />
						</div>
					</div>
				</fieldset>
			</div>
			
			<div class="col-md-12 form-group">
				<fieldset class="scheduler-border">
					<legend class="scheduler-border">KYC Details</legend>
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="pan_card">Document *</label>
							<select name="document" id="document" class="form-control" required >
								<option value="">--select--</option>
								<option value="Passport">Passport</option>
								<option value="Voter's Identity Card">Voter's Identity Card</option>
								<option value="Driving Licence">Driving Licence</option>
								<option value="Aadhaar Card">Aadhaar Card</option>
								<option value="NREGA Card">NREGA Card</option>
								<option value="PAN Card">PAN Card</option>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label for="document_number">Document Number *</label>
							<input class="form-control" name="document_number" id="document_number" type="text" required />
						</div>
					</div>
				</fieldset>
			</div>
			
			<div class="col-md-12 form-group mt-0">
				<button type="submit" id="btnSubmit" class="btn btn-primary btn-block w-25 btn_submit" <?php if($_SESSION['mobile'] == "") echo "disabled"; ?> ><i class="fas fa-user-plus"></i>&nbsp;&nbsp;Register</button>
			</div>
			<div class="col-md-12 form-group mt-3 text-center">
				Already have an account? <a href="<?php echo BASE_URL; ?>">Log in</a>
			</div>
			<br>
			<div class="col-md-12">
				<div class="float-right"><img src="admin/images/logo.png" height="50" /></div>
			</div>
		</form>
	</div>
	</div>
	</div>
	<br />
</div>
</body>
</html>