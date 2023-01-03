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
	if(isset($_GET['regid']))
	{
		$regid = $validation->urlstring_validate($_GET['regid']);
		if($_SESSION['search_filter'] != "")
		{
			$search_filter = "?".$_SESSION['search_filter'];
		}
	}
	else
	{
		$_SESSION['error_msg'] = "There is a problem. Please Try Again!";
		header("Location: register_view.php");
		exit();
	}
}

$old_membership_id = $validation->input_validate($_POST['old_membership_id']);
$old_membership_id_value = $validation->input_validate($_POST['old_membership_id_value']);
$member_check = $validation->input_validate($_POST['member_check']);
$sponsor_id = $validation->input_validate($_POST['sponsor_id']);
$planid = $validation->input_validate($_POST['planid']);
if($planid=='')
{
	$planid = 0;
}
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
$remarks = $validation->input_validate($_POST['remarks']);
$status = $validation->input_validate($_POST['status']);
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
		header("Location: register_view.php");
		exit();
	}
}

$dupresult = $db->check_duplicates('mlm_registrations', 'regid', $regid, 'email', strtolower($email), $mode);
if($dupresult >= 1)
{
	$_SESSION['error_msg'] = "Email-ID already exists!";
	header("Location: register_view.php");
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
			header("Location: register_view.php");
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
			header("Location: register_view.php");
			exit();
		}
		
		$handle-> clean();
	}
	else
	{
		$_SESSION['error_msg'] = $handle->error.'!';
		header("Location: register_view.php");
		exit();
    }
	
	if($mode == "edit")
	{
		$delresult = $media->filedeletion('mlm_registrations', 'regid', $regid, 'imgName', IMG_MAIN_LOC, IMG_THUMB_LOC);
	}
}

if($old_membership_id == "")
{
	$membership_id = "";
	$current_year = date('Y');
	$current_month = date('m');
	$refResult = $db->view("MAX(membership_id_value) as membership_id_value", "mlm_registrations", "regid", "");
	$refRow = $refResult['result'][0];
	$membership_id_value = $refRow['membership_id_value'];
	$membership_id_value = $membership_id_value+1;
	$membership_id = sprintf("%03d", $membership_id_value);
	//$membership_id = "BT".$current_year."".$current_month."".$membership_id;
	$membership_id = "BT".$membership_id;
}
else
{
	$membership_id = $old_membership_id;
	$membership_id_value = $old_membership_id_value;
}

if($_POST['password'] == "")
{
	$password = $old_password;
}
if($imgName == "")
{
	$imgName = $old_imgName;
}

$fields = array('membership_id'=>$membership_id, 'membership_id_value'=>$membership_id_value, 'sponsor_id'=>$sponsor_id, 'first_name'=>$first_name, 'last_name'=>$last_name, 'username'=>$username, 'email'=>$email, 'password'=>$password, 'mobile'=>$mobile, 'mobile_alter'=>$mobile_alter, 'pincode'=>$pincode, 'bank_name'=>$bank_name, 'account_number'=>$account_number, 'ifsc_code'=>$ifsc_code, 'account_name'=>$account_name, 'document'=>$document, 'document_number'=>$document_number, 'imgName'=>$imgName, 'remarks'=>$remarks, 'status'=>$status, 'user_ip'=>$user_ip);

if($mode == "insert")
{
	$fields['userid'] = $userid;
	$fields['createtime'] = $createtime;
	$fields['createdate'] = $createdate;
	
	$registerQueryResult = $db->insert("mlm_registrations", $fields);
	if(!$registerQueryResult)
	{
		echo mysqli_error($connect);
		exit();
	}
	
	$_SESSION['success_msg'] = "Record Added!";
}
else if($mode == "edit")
{
	if($member_check == "0" and $status == "active")
	{
		$fields['member_check'] = "1";
	}
	$fields['userid_updt'] = $userid;
	$fields['modifytime'] = $createtime;
	$fields['modifydate'] = $createdate;
	
	$registerQueryResult = $db->update("mlm_registrations", $fields, array('regid'=>$regid));
	if(!$registerQueryResult)
	{
		echo mysqli_error($connect);
		exit();
	}
	
	$_SESSION['success_msg'] = "Record Updated!";
}

$purchaseQueryResult = $db->view('tracking_status,final_price,price,shipping,coupon_discount,taxamount', 'rb_purchases', 'purchaseid', "and membership_id = '$membership_id'", "purchaseid desc");
$purchaseRow = $purchaseQueryResult['result'][0];
//and $purchaseRow['tracking_status'] == "delivered"

$total_amount = $validation->db_field_validate($purchaseRow['price']+$purchaseRow['shipping']-$purchaseRow['coupon_discount']+$purchaseRow['taxamount']);
$discounted_amount = $validation->calculate_discounted_price('1', $total_amount);

if($member_check == "0" and $status == "active")
{
	
}

header("Location: register_view.php$search_filter");
exit();
?>