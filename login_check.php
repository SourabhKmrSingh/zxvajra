<?php
include_once("inc_config.php");

if($_SESSION['regid'] != "")
{
	header("Location: {$base_url}home{$suffix}");
	exit();
}

if(isset($_POST['token']) && $_POST['token'] === $_SESSION['csrf_token'])
{
	$redirect_url = $_POST['redirect_url'];
	$q = $_POST['q'];
	$membership_id = $validation->input_validate($_POST['membership_id']);
	$password = $validation->input_validate(sha1($_POST['password']));

	if($membership_id == "" || $password == "")
	{
		$_SESSION['error_msg_fe'] = "Please fill all required fields!";
		header("Location: {$base_url}login{$suffix}?url={$full_url}");
		exit();
	}
	
	$loginResult = $db->view('*', 'rb_registrations', 'regid', "and membership_id = '$membership_id' and password = '$password' and status = 'active'");
	if(!$loginResult)
	{
		$_SESSION['error_msg_fe'] = "Error Occurred! Please try again!";
		header("Location: {$base_url}login{$suffix}?url={$full_url}");
		exit();
	}
	
	$loginResult2 = $db->view('*', 'rb_registrations', 'regid', "and membership_id = '$membership_id' and password = '$password' and status = 'inactive'");
	if(!$loginResult2)
	{
		$_SESSION['error_msg_fe'] = "Error Occurred! Please try again!";
		header("Location: {$base_url}login{$suffix}?url={$full_url}");
		exit();
	}
	
	$loginResult3 = $db->view('*', 'rb_registrations', 'regid', "and membership_id = '$membership_id' and password != '$password' and status = 'active'");
	if(!$loginResult3)
	{
		$_SESSION['error_msg_fe'] = "Error Occurred! Please try again!";
		header("Location: {$base_url}login{$suffix}?url={$full_url}");
		exit();
	}
	
	if($loginResult3['num_rows'] >= 1)
	{
		$_SESSION['error_msg_fe'] = "Please enter correct password!";
		header("Location: {$base_url}login{$suffix}?url={$full_url}");
		exit();
	}
	else if($loginResult['num_rows'] >= 1)
	{
		$loginRow = $loginResult['result'][0];
		
		$_SESSION['email'] = $loginRow['email'];
		$_SESSION['regid'] = $loginRow['regid'];
		$_SESSION['first_name'] = $loginRow['first_name'];
		$_SESSION['last_name'] = $loginRow['last_name'];
		$_SESSION['mobile'] = $loginRow['mobile'];
		$_SESSION['pincode'] = $loginRow['pincode'];
		
		$fields = array('regid'=>$loginRow['regid'], 'email'=>$loginRow['email'], 'status'=>'active', 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
		$logResult = $db->insert("rb_logdetail_frontend", $fields);
		if(!$logResult)
		{
			$_SESSION['error_msg_fe'] = "Error Occurred! Please try again!";
			header("Location: {$base_url}login{$suffix}?url={$full_url}");
			exit();
		}
		
		$userQueryResult = $db->view('*', 'mlm_registrations', 'regid', "and membership_id = '$membership_id' and password = '$password' and status = 'active'");
		if(!$userQueryResult)
		{
			echo mysqli_error($connect);
			exit();
		}
		if($userQueryResult['num_rows'] >= 1)
		{
			$usersRow = $userQueryResult['result'][0];
			
			$_SESSION['mlm_regid'] = $usersRow['regid'];
			$_SESSION['mlm_username'] = $usersRow['username'];
			$_SESSION['mlm_membership_id'] = $usersRow['membership_id'];
			$_SESSION['mlm_status'] = $usersRow['status'];
			$_SESSION['mlm_first_name'] = $usersRow['first_name'];
			$_SESSION['mlm_last_name'] = $usersRow['last_name'];
			$_SESSION['mlm_email'] = $usersRow['email'];
			$_SESSION['mlm_mobile'] = $usersRow['mobile'];
			$_SESSION['mlm_imgName'] = $usersRow['imgName'];
			$_SESSION['mlm_account_number'] = $usersRow['account_number'];
			$_SESSION['mlm_document'] = $usersRow['document'];
			
			$regid = $usersRow['regid'];
			$username = $usersRow['username'];
			$status = $usersRow['status'];
			
			$fields = array('regid'=>$regid, 'username'=>$username, 'membership_id'=>$membership_id, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
			$logQueryResult = $db->insert("mlm_logdetail_frontend", $fields);
			if(!$logQueryResult)
			{
				$_SESSION['error_msg'] = "Error while creating your log. Please try again!";
				header("Location: index.php");
				exit();
			}
		}
		
		if($q == "wishlist")
		{
			$_SESSION['success_msg_fe'] = "";
			header("Location: {$base_url}wishlist_inter.php");
			exit();
		}
		else if($q == "cart")
		{
			$_SESSION['success_msg_fe'] = "";
			header("Location: {$base_url}product-detail_inter.php?q=$q");
			exit();
		}
		else if($q == "buy")
		{
			$_SESSION['success_msg_fe'] = "";
			header("Location: {$base_url}product-detail_inter.php?q=$q");
			exit();
		}
		else if($redirect_url != "")
		{
			$_SESSION['success_msg_fe'] = "";
			header("Location: {$redirect_url}");
			exit();
		}
		else
		{
			if($loginRow['address'] == "")
			{
				$_SESSION['success_msg_fe'] = "Complete your profile before proceeding!";
				header("Location: {$base_url}profile{$suffix}");
				exit();
			}
			else
			{
				header("Location: {$base_url}");
				exit();
			}
		}
	}
	// else if($loginResult2['num_rows'] >= 1)
	// {
		// $loginRow = $loginResult2['result'][0];
		// $regid_custom = $loginRow['regid_custom'];
		
		// $_SESSION['error_msg_fe'] = "You have not approved your account yet. Kindly confirm your email or if you have not received any confirmation email then <u><a href='{$base_url}login_resend_mail{$suffix}?mode=7Rklwdfj13IO8234jksdfjsfjdsf89243jkslfjsdksdfhk29384u&email={$email}&md=7Rklwdfj13IO8234jksdfjsfjdsf89243jkslfjsdkffsdkjsdfhk29384u&q={$regid_custom}&mode2=jsus75shs64s02yhs762shuw8'>click here to resend</a></u> the email.";
		// header("Location: {$base_url}login{$suffix}?url={$full_url}");
		// exit();
	// }
	else
	{
		$_SESSION['error_msg_fe'] = "We're not able to recognize your account. Please use right login credentials!";
		header("Location: {$base_url}login{$suffix}?q={$q}&url={$full_url}");
		exit();
	}
}
else
{
	$_SESSION['error_msg_fe'] = "Error Occurred! Please try again.";
	header("Location: {$base_url}login{$suffix}?q={$q}&url={$full_url}");
	exit();
}
?>