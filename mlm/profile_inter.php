<?php
include_once("inc_config.php");
include_once("login_user_check.php");

$_SESSION['active_menu'] = "profile";

$first_name = $validation->input_validate($_POST['first_name']);
$last_name = $validation->input_validate($_POST['last_name']);
$username = $validation->input_validate($_POST['username']);
$email = $validation->input_validate($_POST['email']);
$password = $validation->input_validate(sha1($_POST['password']));
$confirm_password = $validation->input_validate(sha1($_POST['confirm_password']));
$old_password = $validation->input_validate($_POST['old_password']);
$mobile = $validation->input_validate($_POST['mobile']);
$mobile_alter = $validation->input_validate($_POST['mobile_alter']);
$pincode = $validation->input_validate($_POST['pincode']);
if($pincode=='')
{
	$pincode = 0;
}
$bank_name = $validation->input_validate($_POST['bank_name']);
$account_number = $validation->input_validate($_POST['account_number']);
$ifsc_code = $validation->input_validate($_POST['ifsc_code']);
$account_name = $validation->input_validate($_POST['account_name']);
$document = $validation->input_validate($_POST['document']);
$document_number = $validation->input_validate($_POST['document_number']);
$old_imgName = $validation->input_validate($_POST['old_imgName']);

$user_ip_array = ($_POST['user_ip']!='') ? explode(", ", $validation->input_validate($_POST['user_ip'])) : array();
array_push($user_ip_array, $user_ip);
$user_ip_array = array_unique($user_ip_array);
$user_ip = implode(", ", $user_ip_array);

if($_POST['password'] != "")
{
	if($password != $confirm_password)
	{
		$_SESSION['error_msg'] = "Password and Confirm Password should be Same!";
		header("Location: profile.php");
		exit();
	}
}

$dupresult = $db->check_duplicates('mlm_registrations', 'regid', $regid, 'email', strtolower($email), "edit");
if($dupresult >= 1)
{
	$_SESSION['error_msg'] = "Email-ID already exists!";
	header("Location: profile.php");
	exit();
}
$dupresult = $db->check_duplicates('mlm_registrations', 'regid', $regid, 'mobile', strtolower($mobile), "edit");
if($dupresult >= 1)
{
	$_SESSION['error_msg'] = "Mobile No. already exists!";
	header("Location: profile.php");
	exit();
}

$imgTName = $_FILES['imgName']['name'];
if($imgTName != "")
{
	$handle = new Upload($_FILES['imgName']);
    if($handle->uploaded)
	{
		$handle->file_force_extension = true;
		$handle->file_max_size = $validation->db_field_validate($configRow['image_maxsize']);
		$handle->allowed = array('image/*');
		if($configRow['large_width'] != "0" and $configRow['large_height'] != "0")
		{
			$handle->image_resize = true;
			$handle->image_x = $validation->db_field_validate($configRow['large_width']);
			$handle->image_y = $validation->db_field_validate($configRow['large_height']);
			$handle->image_no_enlarging = ($configRow['large_ratio'] === "false") ? false : true;
			$handle->image_ratio = ($configRow['large_ratio'] === "false") ? false : true;
		}
		
		$handle->process(IMG_MAIN_LOC);
		if($handle->processed)
		{
			$imgName = $handle->file_dst_name;
		}
		else
		{
			$_SESSION['error_msg'] = $handle->error.'!';
			header("Location: profile.php");
			exit();
		}
		
		// Thumbnail Image
		$handle->file_force_extension = true;
		$handle->file_max_size = $validation->db_field_validate($configRow['image_maxsize']);
		$handle->allowed = array('image/*');
		if($configRow['thumb_width'] != "0" and $configRow['thumb_height'] != "0")
		{
			$handle->image_resize = true;
			$handle->image_x = $validation->db_field_validate($configRow['thumb_width']);
			$handle->image_y = $validation->db_field_validate($configRow['thumb_height']);
			$handle->image_no_enlarging = ($configRow['thumb_ratio'] === "false") ? false : true;
			$handle->image_ratio = ($configRow['thumb_ratio'] === "false") ? false : true;
		}
		
		$handle->process(IMG_THUMB_LOC);
		if($handle->processed)
		{
		}
		else
		{
			$_SESSION['error_msg'] = $handle->error.'!';
			header("Location: profile.php");
			exit();
		}
		
		$handle-> clean();
	}
	else
	{
		$_SESSION['error_msg'] = $handle->error.'!';
		header("Location: profile.php");
		exit();
    }
	
	if($mode == "edit")
	{
		$delresult = $media->filedeletion('mlm_registrations', 'regid', $regid, 'imgName', IMG_MAIN_LOC, IMG_THUMB_LOC);
	}
}

if($_POST['password'] == "")
{
	$password = $old_password;
}
if($imgName == "")
{
	$imgName = $old_imgName;
}

$fields = array('first_name'=>$first_name, 'last_name'=>$last_name, 'username'=>$username, 'email'=>$email, 'password'=>$password, 'mobile'=>$mobile, 'mobile_alter'=>$mobile_alter, 'pincode'=>$pincode, 'bank_name'=>$bank_name, 'account_number'=>$account_number, 'ifsc_code'=>$ifsc_code, 'account_name'=>$account_name, 'document'=>$document, 'document_number'=>$document_number, 'imgName'=>$imgName, 'user_ip'=>$user_ip);
$fields['modifytime'] = $createtime;
$fields['modifydate'] = $createdate;

$registerQueryResult = $db->update("mlm_registrations", $fields, array('regid'=>$regid));
if(!$registerQueryResult)
{
	echo mysqli_error($connect);
	exit();
}

$_SESSION['mlm_first_name'] = $first_name;
$_SESSION['mlm_last_name'] = $last_name;
$_SESSION['mlm_email'] = $email;
$_SESSION['mlm_mobile'] = $mobile;
$_SESSION['mlm_imgName'] = $imgName;
$_SESSION['mlm_account_number'] = $account_number;
$_SESSION['mlm_document'] = $document;

$_SESSION['success_msg'] = "Profile Updated!";
header("Location: profile.php");
exit();
?>