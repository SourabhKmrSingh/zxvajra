<?php
include_once("inc_config.php");
include_once("login_user_check.php");

$_SESSION['active_menu'] = "challenge";

$q = $validation->urlstring_validate($_GET['q']);
if($q == "del")
{
	echo $validation->delete_permission();
	
	$challengeid = $validation->urlstring_validate($_GET['challengeid']);
	
	$delresult = $media->filedeletion('mlm_challenges', 'challengeid', $challengeid, 'imgName', IMG_MAIN_LOC, IMG_THUMB_LOC);
	$delresult2 = $media->filedeletion('mlm_challenges', 'challengeid', $challengeid, 'fileName', FILE_LOC);

	$challengeQueryResult = $db->delete("mlm_challenges", array('challengeid'=>$challengeid));
	if(!$challengeQueryResult)
	{
		$_SESSION['error_msg'] = "Error Occurred. Please try again!!!";
		header("Location: challenge_view.php");
		exit();
	}

	$_SESSION['success_msg'] = "{$challengeQueryResult} Record Deleted!";
	header("Location: challenge_view.php");
	exit();
}

if(isset($_POST['bulk_actions']) and $_POST['bulk_actions'] != "")
{
	$bulk_actions = $validation->urlstring_validate($_POST['bulk_actions']);
	$del_items = $_POST['del_items'];
	$challengeids = array();
	if(empty($del_items))
	{
		$_SESSION['error_msg'] = "Please select atleast one row to perform action!";
		header("Location: challenge_view.php");
		exit();
	}
	if(isset($del_items) and $del_items != "")
	{
		foreach($del_items as $id)
		{
			if($bulk_actions == "delete")
			{
				array_push($challengeids, "$id");
				
				$delresult = $media->filedeletion('mlm_challenges', 'challengeid', $id, 'imgName', IMG_MAIN_LOC, IMG_THUMB_LOC);
				$delresult2 = $media->filedeletion('mlm_challenges', 'challengeid', $id, 'fileName', FILE_LOC);
			}
			else if($bulk_actions == "active" || $bulk_actions == "inactive")
			{
				array_push($challengeids, "$id");
			}
		}
		
		$challengeids = implode(',', $challengeids);
		
		if($bulk_actions == "delete")
		{
			$challengeQueryResult = $db->custom("DELETE from mlm_challenges where FIND_IN_SET(`challengeid`, '$challengeids')");
			if(!$challengeQueryResult)
			{
				$_SESSION['error_msg'] = "Error Occurred. Please try again!!!";
				header("Location: challenge_view.php");
				exit();
			}
			$affected_rows = $connect->affected_rows;
			
			$_SESSION['success_msg'] = "{$affected_rows} Record(s) Deleted!";
			header("Location: challenge_view.php");
			exit();
		}
		else if($bulk_actions == "active" || $bulk_actions == "inactive")
		{
			$challengeQueryResult = $db->custom("UPDATE mlm_challenges SET status='$bulk_actions' where FIND_IN_SET(`challengeid`, '$challengeids')");
			if(!$challengeQueryResult)
			{
				echo mysqli_error($connect);
				exit();
			}
			$affected_rows = $connect->affected_rows;
			
			$_SESSION['success_msg'] = "{$affected_rows} Record(s) Updated!";
			header("Location: challenge_view.php");
			exit();
		}
	}
}
else
{
	$fields = $_POST;
	
	foreach($fields as $key=>$value)
	{
		$fields_string .= $key.'='.$value.'&';
	}
	rtrim($fields_string, '&');
	$fields_string = str_replace("bulk_actions=&", "", $fields_string);
	$fields_string = substr($fields_string, 0, -1);
	
	header("Location: challenge_view.php?$fields_string");
	exit();
}
?>