<?php
include_once("inc_config.php");

$redirect_url = $_POST['redirect_url'];
$email = $validation->input_validate($_POST['email']);
if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$_SESSION['error_msg_fe'] = "Please enter a valid Email-ID!";
	header("Location: {$redirect_url}");
	exit();
}
$status = "active";
if($regid == "")
{
	$regid = 0;
}

if($email == "")
{
	$_SESSION['error_msg_fe'] = "Please fill all required fields!";
	header("Location: {$redirect_url}");
	exit();
}

$dupresult = $db->check_duplicates('rb_newsletters', 'newsletterid', $newsletterid, 'email', strtolower($email), "insert");
if($dupresult >= 1)
{
	$_SESSION['success_msg_fe'] = "Email-ID is already registered with us.";
	header("Location: {$base_url}thank-you{$suffix}");
	exit();
}

$fields = array('regid'=>$regid, 'email'=>$email, 'status'=>$status, 'user_ip'=>$user_ip);
$fields['createtime'] = $createtime;
$fields['createdate'] = $createdate;

$newsletterQueryResult = $db->insert("rb_newsletters", $fields);
if(!$newsletterQueryResult)
{
	echo mysqli_error($connect);
	exit();
}

$_SESSION['success_msg_fe'] = "You have successfully subscribed to our Newsletters.";
header("Location: {$base_url}thank-you{$suffix}");
exit();
?>