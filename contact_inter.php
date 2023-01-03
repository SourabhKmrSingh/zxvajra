<?php
include_once("inc_config.php");

if(isset($_POST['token']) && $_POST['token'] === $_SESSION['csrf_token'])
{
	$company = $validation->input_validate($_POST['company']);
	$first_name = $validation->input_validate($_POST['first_name']);
	$last_name = $validation->input_validate($_POST['last_name']);
	$email = $validation->input_validate($_POST['email']);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$_SESSION['error_msg_fe'] = "Please enter a valid Email-ID!";
		header("Location: {$base_url}contact{$suffix}");
		exit();
	}
	$mobile = $validation->input_validate($_POST['mobile']);
	$subject = $validation->input_validate($_POST['subject']);
	$message = $validation->input_validate($_POST['message']);
	$status = "active";
	if($regid == "")
	{
		$regid = 0;
	}

	if($first_name == "" || $last_name == "" || $email == "" || $mobile == "" || $subject == "" || $message == "")
	{
		$_SESSION['error_msg_fe'] = "Please fill all required fields!";
		header("Location: {$base_url}contact{$suffix}");
		exit();
	}

	$fields = array('regid'=>$regid, 'company'=>$company, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'mobile'=>$mobile, 'subject'=>$subject, 'message'=>$message, 'status'=>$status, 'user_ip'=>$user_ip);
	$fields['createtime'] = $createtime;
	$fields['createdate'] = $createdate;

	$enquiryQueryResult = $db->insert("rb_enquiries", $fields);
	if(!$enquiryQueryResult)
	{
		echo mysqli_error($connect);
		exit();
	}

	$_SESSION['success_msg_fe'] = "Your Query has been sent. We'll contact you soon!";
	header("Location: {$base_url}thank-you{$suffix}");
	exit();
}
else
{
	$_SESSION['error_msg_fe'] = "Error Occurred! Please try again.";
	header("Location: {$base_url}contact{$suffix}");
	exit();
}
?>