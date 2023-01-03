<?php
include_once("inc_config.php");
include_once("login_user_check.php");

$_SESSION['active_menu'] = "register";

if(isset($_GET['mode']))
{
	$mode = $validation->urlstring_validate($_GET['mode']);
}
else
{
	$_SESSION['error_msg'] = "There is a problem. Please Try Again!";
	header("Location: register_view.php");
	exit();
}

if($mode == "edit")
{
	echo $validation->update_permission();
}
else
{
	echo $validation->write_permission();
}

if($mode == "edit")
{
	$regid = $validation->urlstring_validate($_GET['regid']);
	$registerQueryResult = $db->view('*', 'mlm_registrations', 'regid', "and regid = '$regid'");
	$registerRow = $registerQueryResult['result'][0];
	
	$userid = $registerRow['userid'];
	$userQueryResult = $db->view("display_name", "mlm_users", "userid", "and userid='{$userid}'");
	$userRow = $userQueryResult['result'][0];
	
	$userid_updt = $registerRow['userid_updt'];
	$userupdtQueryResult = $db->view("display_name", "mlm_users", "userid", "and userid='{$userid_updt}'");
	$userupdtRow = $userupdtQueryResult['result'][0];
}

if(isset($_GET['q']))
{
	$q = $validation->urlstring_validate($_GET['q']);
	if($q == "imgdel")
	{
		$delresult = $media->filedeletion('mlm_registrations', 'regid', $regid, 'imgName', IMG_MAIN_LOC, IMG_THUMB_LOC);
		if($delresult)
		{
			$_SESSION['success_msg'] = "Image has been deleted Successfully!!!";
			header("Location: register_form.php?mode=edit&regid=$regid");
			exit();
		}
		else
		{
			$_SESSION['error_msg'] = "Error Occurred. Please try again!!!";
			header("Location: register_form.php?mode=edit&regid=$regid");
			exit();
		}
	}
}
?>
<!DOCTYPE html>
<html LANG="en">
<head>
<?php include_once("inc_title.php"); ?>
<?php include_once("inc_files.php"); ?>
<script>
function passwordmatch()
{
	if($("#password").val() != $("#confirm_password").val())
	{
		alert("Password and Confirm Password should be Same!");
		$("#password").val("");
		$("#confirm_password").val("");
	}
}
</script>
</head>
<body>
<div ID="wrapper">
<?php include_once("inc_header.php"); ?>
<div ID="page-wrapper">
<div CLASS="container-fluid">
<div CLASS="row">
	<div CLASS="col-lg-12">
		<h1 CLASS="page-header"><?php if($mode == "insert") echo "Add New"; else echo "Update"; ?> Member</h1>
	</div>
</div>

<form name="dataform" method="post" class="form-group" action="<?php 
												switch($mode)
												{
													case "insert" : echo "register_form_inter.php?mode=$mode";
													break;
													
													case "edit" : echo "register_form_inter.php?mode=$mode&regid=$regid";
													break;
													
													default : echo "register_form_inter.php";
												}
												?>" enctype="multipart/form-data">

<input type="hidden" name="old_membership_id" id="old_membership_id" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['membership_id']); ?>" />
<input type="hidden" name="old_membership_id_value" id="old_membership_id_value" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['membership_id_value']); ?>" />
<input type="hidden" name="member_check" id="member_check" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['member_check']); ?>" />
<div class="form-rows-custom mt-3">
	<?php if($mode == 'edit') { ?>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Membership ID</label>
			</div>
			<div class="col-sm-9">
				<p class="text"><?php echo $validation->db_field_validate($registerRow['membership_id']); ?></p>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Downline Members</label>
			</div>
			<div class="col-sm-9">
				<p class="text"><?php echo $validation->db_field_validate($registerRow['members']); ?></p>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Stage</label>
			</div>
			<div class="col-sm-9">
				<p class="text">
					<?php
					$rewardid = $registerRow['rewardid'];
					$rewardQueryResult = $db->view('rewardid,title', 'mlm_rewards', 'rewardid', "and rewardid='$rewardid' and status='active'", 'title asc');
					$rewardRow = $rewardQueryResult['result'][0];
					echo $validation->db_field_validate($rewardRow['title']);
					?>
				</p>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Sponsor's ID</label>
			</div>
			<div class="col-sm-9">
				<p class="text"><?php echo $validation->db_field_validate($registerRow['sponsor_id']); ?></p>
				<input type="hidden" name="sponsor_id" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['sponsor_id']); ?>" />
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Sponsor's Name</label>
			</div>
			<div class="col-sm-9">
				<p class="text"><?php echo $validation->db_field_validate($registerRow['sponsor_name']); ?></p>
			</div>
		</div>
		
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Wallet Balance</label>
			</div>
			<div class="col-sm-9">
				<p class="text">&#8377;<?php echo $validation->price_format($registerRow['wallet_money']); ?></p>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Total Credits</label>
			</div>
			<div class="col-sm-9">
				<p class="text">&#8377;<?php echo $validation->price_format($registerRow['wallet_total']); ?></p>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Total Debits</label>
			</div>
			<div class="col-sm-9">
				<p class="text">&#8377;<?php echo $validation->price_format($registerRow['total_debit']); ?></p>
			</div>
		</div>
		
		<!--<div class="row mb-3">
			<div class="col-sm-3">
				<label>Plan</label>
			</div>
			<div class="col-sm-9">
				<?php if($registerRow['members'] == 0) { ?>
					<select NAME="planid" CLASS="form-control" ID="planid" required >
						<option VALUE="">--select--</option>
						<?php
						$planQueryResult = $db->view('planid,title', 'mlm_plans', 'planid', "and status='active'", 'title asc');
						foreach($planQueryResult['result'] as $planRow)
						{
						?>
							<option VALUE="<?php echo $validation->db_field_validate($planRow['planid']); ?>" <?php if($mode == 'edit') { if($planRow['planid'] == $registerRow['planid']) echo "selected"; } ?>><?php echo $validation->db_field_validate($planRow['title']); ?></option>
						<?php
						}
						?>
					</select>
				<?php } else { ?>
					<p class="text">
						<?php
						$planid = $registerRow['planid'];
						$planQueryResult = $db->view('planid,title', 'mlm_plans', 'planid', "and planid='$planid' and status='active'", 'title asc');
						$planRow = $planQueryResult['result'][0];
						echo $validation->db_field_validate($planRow['title']);
						?>
					</p>
					<input type="hidden" name="planid" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['planid']); ?>" />
				<?php } ?>
			</div>
		</div>-->
	<?php } else { ?>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label for="sponsor_id">Sponsor's ID *</label>
			</div>
			<div class="col-sm-9">
				<input type="text" name="sponsor_id" id="sponsor_id" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['sponsor_id']); ?>" required />
			</div>
		</div>
		<!--<div class="row mb-3">
			<div class="col-sm-3">
				<label for="planid">Plan *</label>
			</div>
			<div class="col-sm-9">
				<select NAME="planid" CLASS="form-control" ID="planid" required >
					<option VALUE="">--select--</option>
					<?php
					$planQueryResult = $db->view('planid,title', 'mlm_plans', 'planid', "and status='active'", 'title asc');
					foreach($planQueryResult['result'] as $planRow)
					{
					?>
						<option VALUE="<?php echo $validation->db_field_validate($planRow['planid']); ?>" <?php if($mode == 'edit') { if($planRow['planid'] == $registerRow['planid']) echo "selected"; } ?>><?php echo $validation->db_field_validate($planRow['title']); ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>-->
	<?php } ?>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="first_name">First Name *</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="first_name" id="first_name" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['first_name']); ?>" required />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="last_name">Last Name</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="last_name" id="last_name" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['last_name']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="username">Username</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="username" id="username" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['username']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="email">Email</label>
		</div>
		<div class="col-sm-9">
			<input type="email" name="email" id="email" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['email']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="password">Password *</label>
		</div>
		<div class="col-sm-9">
			<input type="password" name="password" id="password" class="form-control" autocomplete="new-password" />
			<input type="hidden" name="old_password" id="old_password" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['password']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="confirm_password">Confirm Password *</label>
		</div>
		<div class="col-sm-9">
			<input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="new-password" onBlur="passwordmatch();" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="mobile">Mobile No.</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="mobile" id="mobile" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['mobile']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="mobile_alter">Mobile No. (Alternative)</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="mobile_alter" id="mobile_alter" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['mobile_alter']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="pincode">Pincode</label>
		</div>
		<div class="col-sm-9">
			<input type="number" name="pincode" id="pincode" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['pincode']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="bank_name">Bank Name</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="bank_name" id="bank_name" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['bank_name']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="account_number">Account Number</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="account_number" id="account_number" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['account_number']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="ifsc_code">Bank Swift/IFSC Code</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="ifsc_code" id="ifsc_code" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['ifsc_code']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="account_name">Account Name</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="account_name" id="account_name" class="form-control" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['account_name']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="document">KYC Document</label>
		</div>
		<div class="col-sm-9">
			<select class="form-control" name="document" id="document" >
				<option value="" <?php if($registerRow['document'] == "") echo "selected"; ?>>--select--</option>
				<option value="Passport" <?php if($registerRow['document'] == "Passport") echo "selected"; ?>>Passport</option>
				<option value="Voter's Identity Card" <?php if($registerRow['document'] == "Voter's Identity Card") echo "selected"; ?>>Voter's Identity Card</option>
				<option value="Driving Licence" <?php if($registerRow['document'] == "Driving Licence") echo "selected"; ?>>Driving Licence</option>
				<option value="Aadhaar Card" <?php if($registerRow['document'] == "Aadhaar Card") echo "selected"; ?>>Aadhaar Card</option>
				<option value="NREGA Card" <?php if($registerRow['document'] == "NREGA Card") echo "selected"; ?>>NREGA Card</option>
				<option value="PAN Card" <?php if($registerRow['document'] == "PAN Card") echo "selected"; ?>>PAN Card</option>
			</select>
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="document_number">KYC Document Number</label>
		</div>
		<div class="col-sm-9">
			<input type="text" name="document_number" id="document_number" class="form-control" value="<?php echo $validation->db_field_validate($registerRow['document_number']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="imgName">Profile Picture</label>
		</div>
		<div class="col-sm-9">
			<input type="file" name="imgName" id="imgName">
			<input type="hidden" name="old_imgName" id="old_imgName" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['imgName']); ?>" />
			<?php if($mode == 'edit' and $registerRow['imgName'] != "") { ?>
				<div class="mt-2 links">
					<img src="<?php echo IMG_THUMB_LOC; echo $validation->db_field_validate($registerRow['imgName']); ?>" title="<?php echo $validation->db_field_validate($registerRow['imgName']); ?>" class="img-responsive mh-51" /><br>
					<a href="<?php echo IMG_MAIN_LOC; echo $validation->db_field_validate($registerRow['imgName']); ?>" target="_blank">Click to Download</a> | <a href="register_form.php?mode=edit&regid=<?php echo $regid; ?>&q=imgdel" onClick="return del();">Delete</a>
				</div>
			<?php } ?>
			<em class="d-block mt-1">File should be Image and size under <?php echo $validation->convertToReadableSize($configRow['image_maxsize']); ?><br>Image extension should be .jpg, .jpeg, .png, .gif</em>
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="remarks">Remarks</label>
		</div>
		<div class="col-sm-9">
			<textarea name="remarks" id="remarks" class="form-control"><?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['remarks']); ?></textarea>
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label for="status">Status *</label>
		</div>
		<div class="col-sm-9">
			<select name="status" id="status" class="form-control" required >
				<option value="active" <?php if($mode == 'edit') { if($validation->db_field_validate($registerRow['status']) == "active") echo "selected"; } ?>>Active</option>
				<option value="inactive" <?php if($mode == 'edit') { if($validation->db_field_validate($registerRow['status']) == "inactive") echo "selected"; } ?>>Inactive</option>
			</select>
		</div>
	</div>
	
	<?php if($mode == 'edit') { ?>
	<?php if($registerRow['userid'] != "" and $registerRow['userid'] != "0") { ?>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Author</label>
			</div>
			<div class="col-sm-9">
				<p class="text"><a href="register_view.php?userid=<?php echo $userid; ?>"><?php echo $validation->db_field_validate($userRow['display_name']); ?></a></p>
			</div>
		</div>
	<?php } ?>
	
	<?php if($registerRow['userid_updt'] != "" and $registerRow['userid_updt'] != "0") { ?>
		<div class="row mb-3">
			<div class="col-sm-3">
				<label>Author (Modified By)</label>
			</div>
			<div class="col-sm-9">
				<p class="text"><a href="register_view.php?userid=<?php echo $userid_updt; ?>"><?php echo $validation->db_field_validate($userupdtRow['display_name']); ?></a></p>
			</div>
		</div>
	<?php } ?>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label>User's IP Address</label>
		</div>
		<div class="col-sm-9">
			<p class="text"><?php echo $validation->db_field_validate($registerRow['user_ip']); ?></p>
			<input type="hidden" name="user_ip" value="<?php if($mode == 'edit') echo $validation->db_field_validate($registerRow['user_ip']); ?>" />
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label>Modification Date & Time</label>
		</div>
		<div class="col-sm-9">
			<?php if($registerRow['modifydate'] != "") { ?>
				<p class="text"><?php echo $validation->date_format_custom($registerRow['modifydate'])." at ".$validation->time_format_custom($registerRow['modifytime']); ?></p>
			<?php } ?>
		</div>
	</div>
	
	<div class="row mb-3">
		<div class="col-sm-3">
			<label>Creation Date & Time</label>
		</div>
		<div class="col-sm-9">
			<?php if($registerRow['createdate'] != "") { ?>
				<p class="text"><?php echo $validation->date_format_custom($registerRow['createdate'])." at ".$validation->time_format_custom($registerRow['createtime']); ?></p>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
	
	<div class="row mt-4 mb-4">
		<div class="col-sm-12">
			<?php
			if($mode == "insert")
			{
			?>
				<button type="submit" class="btn btn-default btn-sm mr-2 btn_submit"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;Add</button>
				<button type="reset" class="btn btn-default btn-sm btn_delete"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp;Reset</button>
			<?php
			}
			elseif($mode == "edit")
			{
			?>
				<button type="submit" name="submit" class="btn btn-default btn-sm mr-2 btn_submit"><i class="fas fa-save"></i>&nbsp;&nbsp;Update</button>
				<?php if($_SESSION['per_delete'] == "1") { ?>
					<a HREF="register_actions.php?q=del&regid=<?php echo $registerRow['regid']; ?>" class="btn btn-default btn-sm btn_delete" onClick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a>
				<?php } ?>
			<?php
			}
			?>
		</div>
	</div>
</div>
</form>
</div>
</div>
</div>

</body>
</html>