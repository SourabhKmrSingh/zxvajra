<?php
include_once("inc_config.php");

if($_SESSION['mlm_regid'] != '')
{
	$_SESSION['success_msg'] = "You're Logged In!";
	header("Location: {$base_url}home{$suffix}");
	exit();
}

if(isset($_POST['token']) && $_POST['token'] === $_SESSION['csrf_token'])
{
	$sponsor_id = $validation->input_validate($_POST['sponsor_id']);
	$sponsor_name = $validation->input_validate($_POST['sponsor_name']);
	$first_name = $validation->input_validate($_POST['first_name']);
	$last_name = $validation->input_validate($_POST['last_name']);
	$username = $validation->input_validate($_POST['username']);
	$email = $validation->input_validate($_POST['email']);
	$password = $validation->input_validate(sha1($_POST['password']));
	$confirm_password = $validation->input_validate(sha1($_POST['confirm_password']));
	$mobile = $validation->input_validate($_POST['mobile']);
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
	$rewardid = "0";
	$status = "active";
	
	$registerplanResult = $db->view('regid,planid', 'mlm_registrations', 'regid', "and membership_id='$sponsor_id' and status='active'", 'regid desc');
	if($registerplanResult['num_rows'] >= 1)
	{
		$registerplanRow = $registerplanResult['result'][0];
		$planid = $registerplanRow['planid'];
	}
	
	if($sponsor_id == "" || $sponsor_name == "" || $first_name == "" || $username == "" || $email == "" || $password == "" || $confirm_password == "" || $mobile == "" || $pincode == "")
	{
		$_SESSION['error_msg'] = "Please fill all required fields!";
		header("Location: {$base_url}register{$suffix}");
		exit();
	}
	if($password != $confirm_password)
	{
		$_SESSION['error_msg'] = "Password and Confirm Password should be same!";
		header("Location: {$base_url}register{$suffix}");
		exit();
	}
	
	// $userlimitResult = $db->check_duplicates('mlm_registrations', 'regid', $regid, 'sponsor_id', strtolower($sponsor_id), "insert");
	// if($userlimitResult >= 3)
	// {
		// $_SESSION['error_msg'] = "You can only add only 3 members in your downline. Please motivate your team members so that you'll get their benefits";
		// header("Location: {$base_url}register{$suffix}");
		// exit();
	// }
	$dupresult = $db->check_duplicates('mlm_registrations', 'regid', $regid, 'email', strtolower($email), "insert");
	if($dupresult >= 1)
	{
		$_SESSION['error_msg'] = "Email-ID is already in use. Please take another one!";
		header("Location: {$base_url}register{$suffix}");
		exit();
	}
	if($account_number != "")
	{
		$dupresult2 = $db->check_duplicates('mlm_registrations', 'regid', $regid, 'account_number', strtolower($account_number), "insert");
		if($dupresult2 >= 2)
		{
			$_SESSION['error_msg'] = "Bank Account Number is already in use. Please take another one!";
			header("Location: {$base_url}register{$suffix}");
			exit();
		}
	}
	$dupresult3 = $db->view('regid', 'mlm_registrations', 'regid', "and mobile='$mobile' and planid='$planid'");
	if($dupresult3['num_rows'] >= 1)
	{
		$_SESSION['error_msg'] = "Mobile No. is already in use. Please take another one!";
		header("Location: {$base_url}register{$suffix}");
		exit();
	}
	if($document != "" and $document_number != "")
	{
		$dupresult4 = $db->view('regid', 'mlm_registrations', 'regid', "and document='$document' and document_number='$document_number'");
		if($dupresult4['num_rows'] >= 1)
		{
			$_SESSION['error_msg'] = "KYC Document is already in use. Please take another one!";
			header("Location: {$base_url}register{$suffix}");
			exit();
		}
	}
	
	$membership_id = "";
	$current_year = date('Y');
	$current_month = date('m');
	$refResult = $db->view("MAX(membership_id_value) as membership_id_value", "mlm_registrations", "regid", "");
	$refRow = $refResult['result'][0];
	$membership_id_value = $refRow['membership_id_value'];
	$membership_id_value = $membership_id_value+1;
	$membership_id = sprintf("%03d", $membership_id_value);
	//$membership_id = "BT".$current_year."".$current_month."".$membership_id;
	$membership_id = "GM".$membership_id;
	
	$fields = array('membership_id'=>$membership_id, 'membership_id_value'=>$membership_id_value, 'rewardid'=>$rewardid, 'sponsor_id'=>$sponsor_id, 'sponsor_name'=>$sponsor_name, 'planid'=>$planid, 'first_name'=>$first_name, 'last_name'=>$last_name, 'username'=>$username, 'email'=>$email, 'password'=>$password, 'mobile'=>$mobile, 'mobile_alter'=>$mobile_alter, 'pincode'=>$pincode, 'bank_name'=>$bank_name, 'account_number'=>$account_number, 'ifsc_code'=>$ifsc_code, 'account_name'=>$account_name, 'document'=>$document, 'document_number'=>$document_number, 'status'=>$status, 'user_ip'=>$user_ip);
	$fields['createtime'] = $createtime;
	$fields['createdate'] = $createdate;

	$registerResult = $db->insert("mlm_registrations", $fields);
	if(!$registerResult)
	{
		echo mysqli_error($connect);
		exit();
	}

	// if($email != "")
	// {
		// $subject = "Complete your registration with Grocery Master";
		// $message = "Dear $first_name,<br><br>
					// Your Account has almost been created. You are just one step away to log in to your panel. Please click on the given link to confirm your email and activate your account.<br>
					// <a href='{$base_url}login_complete{$suffix}?email=$email&mode=jUhYg7Hu2hY12HuKiUhY2bhYhY6h&q=$regid_custom&mode2=kIjYhY786gThUjvFdXsAe57G' style='color: #1AB1D1;'>Click here to confirm your Email</a><br><br>
					// Link not working for you? Copy the url below into your browser.<br>
					// <a href='{$base_url}login_complete{$suffix}?email=$email&mode=jUhYg7Hu2hY12HuKiUhY2bhYhY6h&q=$regid_custom&mode2=kIjYhY786gThUjvFdXsAe57G' style='color: #1AB1D1;'>{$base_url}forgot-password-complete{$suffix}?email=$email&mode=jUhYg7Hu2hY12HuKiUhY2bhYhY6h&q=$regid_custom&mode2=kIjYhY786gThUjvFdXsAe57G</a><br><br>
					// Thanks and Regards<br>Grocery Master
					// <br><br>This is an automated email, please do not reply.";
		
		// $mail->sendmail(array($email), $subject, $message);
	// }
	
	if($userid == "")
	{
		$userid = 0;
	}
	
	$memberCountResult1 = $db->view('membership_id,sponsor_id,members,status,regid,createdate,createtime,username,rewardid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$membership_id'", 'regid asc');
	if($memberCountResult1['num_rows'] >= 1)
	{
		foreach($memberCountResult1['result'] as $memberCountRow1)
		{
			$updated_members1 = $memberCountRow1['members']+1;
			$createtime_member1 = $memberCountRow1['createtime'];
			$createdate_member1 = $memberCountRow1['createdate'];
			$regid1 = $memberCountRow1['regid'];
			$membership_id1 = $memberCountRow1['membership_id'];
			$username1 = $memberCountRow1['username'];
			$memberrewardid1 = $memberCountRow1['rewardid'];
			
			$membership_id_history1 = $memberCountRow1['membership_id'];
			$sponsor_id_history1 = $memberCountRow1['sponsor_id'];
			$fields4 = array('userid'=>$userid, 'regid'=>$regid1, 'membership_id'=>$membership_id_history1, 'sponsor_id'=>$sponsor_id_history1, 'member'=>'1', 'total_members'=>$updated_members1, 'description'=>'', 'status'=>'active', 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
			$registrationHistoryResult1 = $db->insert("mlm_registrations_history", $fields4);
			if(!$registrationHistoryResult1)
			{
				echo "Members History is not updated! Consult Administrator";
				exit();
			}
			$challengeResult1 = $db->view('challengeid,time_period,members,reward', 'mlm_challenges', 'challengeid', "and status='active' and planid='$planid' and members='$updated_members1'", "time_period desc", "1");
			if($challengeResult1['num_rows'] >= 1)
			{
				$challengeRow1 = $challengeResult1['result'][0];
				$challengeid = $challengeRow1['challengeid'];
				$time_period = $challengeRow1['time_period'];
				$members1 = $challengeRow1['members'];
				$reward = $challengeRow1['reward'];
				$description = "Reward for completing challenge of {$members1} members in {$time_period} days";
				$status = "achieved";
				$refno1 = substr(md5(rand(1, 99999)),0,22);
				
				$reghistoryResult1 = $db->view('total_members', 'mlm_registrations_history', 'historyid', "and status='active' and createdate >= DATE_SUB(CURDATE(), INTERVAL {$time_period} DAY) and regid='$regid1'", "historyid desc");
				if($reghistoryResult1['num_rows'] == $members1)
				{
					$fields3 = array('userid'=>$userid, 'regid'=>$regid1, 'challengeid'=>$challengeid, 'membership_id'=>$membership_id1, 'username'=>$username1, 'refno'=>$refno1, 'time_period'=>$time_period, 'members'=>$members1, 'reward'=>$reward, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$challengeHistoryResult = $db->insert("mlm_challenges_history", $fields3);
				}
			}
			$countUpdateResult1 = $db->custom("update mlm_registrations set members = members+1 {$query1} where membership_id='{$membership_id}'");
			if(!$countUpdateResult1)
			{
				echo "Member Count is not updated! Consult Administrator";
				exit();
			}
			// end of loop
			
			$sponsor_id2 = $memberCountRow1['sponsor_id'];
			$memberCountResult2 = $db->view('membership_id,sponsor_id,members,status,regid,createdate,createtime,username,rewardid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$sponsor_id2'", 'regid asc');
			if($memberCountResult2['num_rows'] >= 1)
			{
				foreach($memberCountResult2['result'] as $memberCountRow2)
				{
					$updated_members2 = $memberCountRow2['members']+1;
					$createtime_member2 = $memberCountRow2['createtime'];
					$createdate_member2 = $memberCountRow2['createdate'];
					$regid2 = $memberCountRow2['regid'];
					$membership_id2 = $memberCountRow2['membership_id'];
					$username2 = $memberCountRow2['username'];
					$memberrewardid2 = $memberCountRow2['rewardid'];
					
					$membership_id_history2 = $memberCountRow2['membership_id'];
					$sponsor_id_history2 = $memberCountRow2['sponsor_id'];
					$fields4 = array('userid'=>$userid, 'regid'=>$regid2, 'membership_id'=>$membership_id_history2, 'sponsor_id'=>$sponsor_id_history2, 'member'=>'1', 'total_members'=>$updated_members2, 'description'=>'', 'status'=>'active', 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$registrationHistoryResult2 = $db->insert("mlm_registrations_history", $fields4);
					if(!$registrationHistoryResult2)
					{
						echo "Members History is not updated! Consult Administrator";
						exit();
					}
					$challengeResult2 = $db->view('challengeid,time_period,members,reward', 'mlm_challenges', 'challengeid', "and status='active' and planid='$planid' and members='$updated_members2'", "time_period desc", "1");
					if($challengeResult2['num_rows'] >= 1)
					{
						$challengeRow2 = $challengeResult2['result'][0];
						$challengeid = $challengeRow2['challengeid'];
						$time_period = $challengeRow2['time_period'];
						$members2 = $challengeRow2['members'];
						$reward = $challengeRow2['reward'];
						$description = "Reward for completing challenge of {$members2} members in {$time_period} days";
						$status = "achieved";
						$refno2 = substr(md5(rand(1, 99999)),0,22);
						
						$reghistoryResult2 = $db->view('total_members', 'mlm_registrations_history', 'historyid', "and status='active' and createdate >= DATE_SUB(CURDATE(), INTERVAL {$time_period} DAY) and regid='$regid2'", "historyid desc");
						if($reghistoryResult2['num_rows'] == $members2)
						{
							$fields3 = array('userid'=>$userid, 'regid'=>$regid2, 'challengeid'=>$challengeid, 'membership_id'=>$membership_id2, 'username'=>$username2, 'refno'=>$refno2, 'time_period'=>$time_period, 'members'=>$members2, 'reward'=>$reward, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
							$challengeHistoryResult = $db->insert("mlm_challenges_history", $fields3);
						}
					}
					$countUpdateResult2 = $db->custom("update mlm_registrations set members = members+1 {$query2} where membership_id='{$sponsor_id2}'");
					if(!$countUpdateResult2)
					{
						echo "Member Count is not updated! Consult Administrator";
						exit();
					}
					// end of loop
					
					$sponsor_id3 = $memberCountRow2['sponsor_id'];
					$memberCountResult3 = $db->view('membership_id,sponsor_id,members,status,regid,createdate,createtime,username,rewardid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$sponsor_id3'", 'regid asc');
					if($memberCountResult3['num_rows'] >= 1)
					{
						foreach($memberCountResult3['result'] as $memberCountRow3)
						{
							$updated_members3 = $memberCountRow3['members']+1;
							$createtime_member3 = $memberCountRow3['createtime'];
							$createdate_member3 = $memberCountRow3['createdate'];
							$regid3 = $memberCountRow3['regid'];
							$membership_id3 = $memberCountRow3['membership_id'];
							$username3 = $memberCountRow3['username'];
							$memberrewardid3 = $memberCountRow3['rewardid'];
							
							$membership_id_history3 = $memberCountRow3['membership_id'];
							$sponsor_id_history3 = $memberCountRow3['sponsor_id'];
							$fields4 = array('userid'=>$userid, 'regid'=>$regid3, 'membership_id'=>$membership_id_history3, 'sponsor_id'=>$sponsor_id_history3, 'member'=>'1', 'total_members'=>$updated_members3, 'description'=>'', 'status'=>'active', 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
							$registrationHistoryResult3 = $db->insert("mlm_registrations_history", $fields4);
							if(!$registrationHistoryResult3)
							{
								echo "Members History is not updated! Consult Administrator";
								exit();
							}
							$challengeResult3 = $db->view('challengeid,time_period,members,reward', 'mlm_challenges', 'challengeid', "and status='active' and planid='$planid' and members='$updated_members3'", "time_period desc", "1");
							if($challengeResult3['num_rows'] >= 1)
							{
								$challengeRow3 = $challengeResult3['result'][0];
								$challengeid = $challengeRow3['challengeid'];
								$time_period = $challengeRow3['time_period'];
								$members3 = $challengeRow3['members'];
								$reward = $challengeRow3['reward'];
								$description = "Reward for completing challenge of {$members3} members in {$time_period} days";
								$status = "achieved";
								$refno3 = substr(md5(rand(1, 99999)),0,22);
								
								$reghistoryResult3 = $db->view('total_members', 'mlm_registrations_history', 'historyid', "and status='active' and createdate >= DATE_SUB(CURDATE(), INTERVAL {$time_period} DAY) and regid='$regid3'", "historyid desc");
								if($reghistoryResult3['num_rows'] == $members3)
								{
									$fields3 = array('userid'=>$userid, 'regid'=>$regid3, 'challengeid'=>$challengeid, 'membership_id'=>$membership_id3, 'username'=>$username3, 'refno'=>$refno3, 'time_period'=>$time_period, 'members'=>$members3, 'reward'=>$reward, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
									$challengeHistoryResult = $db->insert("mlm_challenges_history", $fields3);
								}
							}
							$countUpdateResult3 = $db->custom("update mlm_registrations set members = members+1 {$query3} where membership_id='{$sponsor_id3}'");
							if(!$countUpdateResult3)
							{
								echo "Member Count is not updated! Consult Administrator";
								exit();
							}
							// end of loop
							
							$sponsor_id4 = $memberCountRow3['sponsor_id'];
							$memberCountResult4 = $db->view('membership_id,sponsor_id,members,status,regid,createdate,createtime,username,rewardid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$sponsor_id4'", 'regid asc');
							if($memberCountResult4['num_rows'] >= 1)
							{
								foreach($memberCountResult4['result'] as $memberCountRow4)
								{
									$updated_members4 = $memberCountRow4['members']+1;
									$createtime_member4 = $memberCountRow4['createtime'];
									$createdate_member4 = $memberCountRow4['createdate'];
									$regid4 = $memberCountRow4['regid'];
									$membership_id4 = $memberCountRow4['membership_id'];
									$username4 = $memberCountRow4['username'];
									$memberrewardid4 = $memberCountRow4['rewardid'];
									
									$membership_id_history4 = $memberCountRow4['membership_id'];
									$sponsor_id_history4 = $memberCountRow4['sponsor_id'];
									$fields4 = array('userid'=>$userid, 'regid'=>$regid4, 'membership_id'=>$membership_id_history4, 'sponsor_id'=>$sponsor_id_history4, 'member'=>'1', 'total_members'=>$updated_members4, 'description'=>'', 'status'=>'active', 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
									$registrationHistoryResult4 = $db->insert("mlm_registrations_history", $fields4);
									if(!$registrationHistoryResult4)
									{
										echo "Members History is not updated! Consult Administrator";
										exit();
									}
									$challengeResult4 = $db->view('challengeid,time_period,members,reward', 'mlm_challenges', 'challengeid', "and status='active' and planid='$planid' and members='$updated_members4'", "time_period desc", "1");
									if($challengeResult4['num_rows'] >= 1)
									{
										$challengeRow4 = $challengeResult4['result'][0];
										$challengeid = $challengeRow4['challengeid'];
										$time_period = $challengeRow4['time_period'];
										$members4 = $challengeRow4['members'];
										$reward = $challengeRow4['reward'];
										$description = "Reward for completing challenge of {$members4} members in {$time_period} days";
										$status = "achieved";
										$refno4 = substr(md5(rand(1, 99999)),0,22);
										
										$reghistoryResult4 = $db->view('total_members', 'mlm_registrations_history', 'historyid', "and status='active' and createdate >= DATE_SUB(CURDATE(), INTERVAL {$time_period} DAY) and regid='$regid4'", "historyid desc");
										if($reghistoryResult4['num_rows'] == $members4)
										{
											$fields3 = array('userid'=>$userid, 'regid'=>$regid4, 'challengeid'=>$challengeid, 'membership_id'=>$membership_id4, 'username'=>$username4, 'refno'=>$refno4, 'time_period'=>$time_period, 'members'=>$members4, 'reward'=>$reward, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
											$challengeHistoryResult = $db->insert("mlm_challenges_history", $fields3);
										}
									}
									$countUpdateResult4 = $db->custom("update mlm_registrations set members = members+1 {$query4} where membership_id='{$sponsor_id4}'");
									if(!$countUpdateResult4)
									{
										echo "Member Count is not updated! Consult Administrator";
										exit();
									}
									// end of loop
									
									$sponsor_id5 = $memberCountRow4['sponsor_id'];
									$memberCountResult5 = $db->view('membership_id,sponsor_id,members,status,regid,createdate,createtime,username,rewardid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$sponsor_id5'", 'regid asc');
									if($memberCountResult5['num_rows'] >= 1)
									{
										foreach($memberCountResult5['result'] as $memberCountRow5)
										{
											$updated_members5 = $memberCountRow5['members']+1;
											$createtime_member5 = $memberCountRow5['createtime'];
											$createdate_member5 = $memberCountRow5['createdate'];
											$regid5 = $memberCountRow5['regid'];
											$membership_id5 = $memberCountRow5['membership_id'];
											$username5 = $memberCountRow5['username'];
											$memberrewardid5 = $memberCountRow5['rewardid'];
											
											$membership_id_history5 = $memberCountRow5['membership_id'];
											$sponsor_id_history5 = $memberCountRow5['sponsor_id'];
											$fields4 = array('userid'=>$userid, 'regid'=>$regid5, 'membership_id'=>$membership_id_history5, 'sponsor_id'=>$sponsor_id_history5, 'member'=>'1', 'total_members'=>$updated_members5, 'description'=>'', 'status'=>'active', 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
											$registrationHistoryResult5 = $db->insert("mlm_registrations_history", $fields4);
											if(!$registrationHistoryResult5)
											{
												echo "Members History is not updated! Consult Administrator";
												exit();
											}
											$challengeResult5 = $db->view('challengeid,time_period,members,reward', 'mlm_challenges', 'challengeid', "and status='active' and planid='$planid' and members='$updated_members5'", "time_period desc", "1");
											if($challengeResult5['num_rows'] >= 1)
											{
												$challengeRow5 = $challengeResult5['result'][0];
												$challengeid = $challengeRow5['challengeid'];
												$time_period = $challengeRow5['time_period'];
												$members5 = $challengeRow5['members'];
												$reward = $challengeRow5['reward'];
												$description = "Reward for completing challenge of {$members5} members in {$time_period} days";
												$status = "achieved";
												$refno5 = substr(md5(rand(1, 99999)),0,22);
												
												$reghistoryResult5 = $db->view('total_members', 'mlm_registrations_history', 'historyid', "and status='active' and createdate >= DATE_SUB(CURDATE(), INTERVAL {$time_period} DAY) and regid='$regid5'", "historyid desc");
												if($reghistoryResult5['num_rows'] == $members5)
												{
													$fields3 = array('userid'=>$userid, 'regid'=>$regid5, 'challengeid'=>$challengeid, 'membership_id'=>$membership_id5, 'username'=>$username5, 'refno'=>$refno5, 'time_period'=>$time_period, 'members'=>$members5, 'reward'=>$reward, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
													$challengeHistoryResult = $db->insert("mlm_challenges_history", $fields3);
												}
											}
											$countUpdateResult5 = $db->custom("update mlm_registrations set members = members+1 {$query5} where membership_id='{$sponsor_id5}'");
											if(!$countUpdateResult5)
											{
												echo "Member Count is not updated! Consult Administrator";
												exit();
											}
											// end of loop
											
											$sponsor_id6 = $memberCountRow5['sponsor_id'];
											$memberCountResult6 = $db->view('membership_id,sponsor_id,members,status,regid,createdate,createtime,username,rewardid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$sponsor_id6'", 'regid asc');
											if($memberCountResult6['num_rows'] >= 1)
											{
												foreach($memberCountResult6['result'] as $memberCountRow6)
												{
													$updated_members6 = $memberCountRow6['members']+1;
													$createtime_member6 = $memberCountRow6['createtime'];
													$createdate_member6 = $memberCountRow6['createdate'];
													$regid6 = $memberCountRow6['regid'];
													$membership_id6 = $memberCountRow6['membership_id'];
													$username6 = $memberCountRow6['username'];
													$memberrewardid6 = $memberCountRow6['rewardid'];
													
													$membership_id_history6 = $memberCountRow6['membership_id'];
													$sponsor_id_history6 = $memberCountRow6['sponsor_id'];
													$fields4 = array('userid'=>$userid, 'regid'=>$regid6, 'membership_id'=>$membership_id_history6, 'sponsor_id'=>$sponsor_id_history6, 'member'=>'1', 'total_members'=>$updated_members6, 'description'=>'', 'status'=>'active', 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
													$registrationHistoryResult6 = $db->insert("mlm_registrations_history", $fields4);
													if(!$registrationHistoryResult6)
													{
														echo "Members History is not updated! Consult Administrator";
														exit();
													}
													$challengeResult6 = $db->view('challengeid,time_period,members,reward', 'mlm_challenges', 'challengeid', "and status='active' and planid='$planid' and members='$updated_members6'", "time_period desc", "1");
													if($challengeResult6['num_rows'] >= 1)
													{
														$challengeRow6 = $challengeResult6['result'][0];
														$challengeid = $challengeRow6['challengeid'];
														$time_period = $challengeRow6['time_period'];
														$members6 = $challengeRow6['members'];
														$reward = $challengeRow6['reward'];
														$description = "Reward for completing challenge of {$members6} members in {$time_period} days";
														$status = "achieved";
														$refno6 = substr(md5(rand(1, 99999)),0,22);
														
														$reghistoryResult6 = $db->view('total_members', 'mlm_registrations_history', 'historyid', "and status='active' and createdate >= DATE_SUB(CURDATE(), INTERVAL {$time_period} DAY) and regid='$regid6'", "historyid desc");
														if($reghistoryResult6['num_rows'] == $members6)
														{
															$fields3 = array('userid'=>$userid, 'regid'=>$regid6, 'challengeid'=>$challengeid, 'membership_id'=>$membership_id6, 'username'=>$username6, 'refno'=>$refno6, 'time_period'=>$time_period, 'members'=>$members6, 'reward'=>$reward, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
															$challengeHistoryResult = $db->insert("mlm_challenges_history", $fields3);
														}
													}
													$countUpdateResult6 = $db->custom("update mlm_registrations set members = members+1 {$query6} where membership_id='{$sponsor_id6}'");
													if(!$countUpdateResult6)
													{
														echo "Member Count is not updated! Consult Administrator";
														exit();
													}
													// end of loop
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	$_SESSION['success_msg'] = "Your account has been successfully created. Your membership ID is {$membership_id}. Thank You!";
	header("Location: {$base_url}");
	exit();
}
else
{
	$_SESSION['error_msg'] = "Error Occurred! Please try again.";
	header("Location: {$base_url}register{$suffix}");
	exit();
}
?>