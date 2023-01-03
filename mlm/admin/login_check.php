<?php
include_once("inc_config.php");

$type = $validation->input_validate($_POST['type']);
$username = $validation->input_validate($_POST['username']);
$password = $validation->input_validate(sha1($_POST['password']));

$userQueryResult = $db->view('*', 'mlm_users', 'userid', "and type='$type' and username = '$username' and password = '$password'");
if(!$userQueryResult)
{
	echo mysqli_error($connect);
	exit();
}
if($userQueryResult['num_rows'] >= 1)
{
	$usersRow = $userQueryResult['result'][0];
	
	$_SESSION['mlm_be_userid'] = $usersRow['userid'];
	$_SESSION['mlm_be_username'] = $usersRow['username'];
	$_SESSION['mlm_be_type'] = $usersRow['type'];
	$_SESSION['per_read'] = $usersRow['per_read'];
	$_SESSION['per_write'] = $usersRow['per_write'];
	$_SESSION['per_update'] = $usersRow['per_update'];
	$_SESSION['per_delete'] = $usersRow['per_delete'];
	$_SESSION['per_ewallet'] = $usersRow['per_ewallet'];
	$_SESSION['mlm_be_status'] = $usersRow['status'];
	$_SESSION['mlm_be_display_name'] = $usersRow['display_name'];
	$_SESSION['mlm_be_imgName'] = $usersRow['imgName'];
	
	$userid = $usersRow['userid'];
	$username = $usersRow['username'];
	$status = $usersRow['status'];
	
	$fields = array('userid'=>$userid, 'username'=>$username, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
	
	$logQueryResult = $db->insert("mlm_logdetail", $fields);
	if(!$logQueryResult)
	{
		$_SESSION['error_msg'] = "Error while creating your log. Please try again!";
		header("Location: index.php");
		exit();
	}
	
	if($_SESSION['mlm_be_status'] == 'inactive')
	{
		$_SESSION['error_msg'] = "Your Account is Inactive. Please contact Administrator!";
		$_SESSION['mlm_be_userid'] = "";
		$_SESSION['mlm_be_username'] = "";
		$_SESSION['mlm_be_status'] = "";
		
		header("Location: index.php");
		exit();
	}
	
	$_SESSION['success_msg'] = "You're Logged In!";
	if($_SESSION['redirect_url'] != "")
	{
		header("Location: {$_SESSION['redirect_url']}");
		exit();
	}
	else
	{
		header("Location: home.php");
		exit();
	}
}
else
{
	$_SESSION['error_msg'] = "Invalid login details!";
	header("Location: index.php");
}
?>