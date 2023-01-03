<?php
include_once("inc_config.php");

if(isset($_POST['mobile']))
{
	$mobile = $validation->input_validate($_POST['mobile']);
	if(preg_match('/^\d{10}$/',$mobile))
	{
		$mobile = $mobile;
	}
	else
	{
		echo "Failed";
	}
	$rand_no = rand(10000, 99999);
	
	$dupresult2 = $db->check_duplicates('rb_registrations', 'regid', $regid, 'mobile', strtolower($mobile), "insert");
	if($dupresult2 >= 1)
	{
		echo "existed";
		exit();
	}
	
	$recipient_no = $mobile;
	$message = "$rand_no is your OTP and it is valid for the next 10 minutes. Please do not share this OTP with anyone. Thank You, Grocery Master.";
	$send = $api->sendSMS('GROMAS', $recipient_no, $message,'1007161787364887137');
	if($send)
	{
		echo "Done";
	}
	else
	{
		echo "Failed";
	}
	$_SESSION['verification_code'] = $rand_no;
	$_SESSION['mobile'] = $mobile;
	exit();
}
?>