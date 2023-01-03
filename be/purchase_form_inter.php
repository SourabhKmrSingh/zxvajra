<?php
include_once("inc_config.php");
include_once("login_user_check.php");

$_SESSION['active_menu'] = "purchase";

if(isset($_GET['mode']))
{
	$mode = $validation->urlstring_validate($_GET['mode']);
}
else
{
	$_SESSION['error_msg'] = "There is a problem. Please Try Again!";
	header("Location: purchase_view.php");
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
	if(isset($_GET['purchaseid']))
	{
		$purchaseid = $validation->urlstring_validate($_GET['purchaseid']);
		if($_SESSION['search_filter'] != "")
		{
			$search_filter = "?".$_SESSION['search_filter'];
		}
	}
	else
	{
		$_SESSION['error_msg'] = "There is a problem. Please Try Again!";
		header("Location: purchase_view.php");
		exit();
	}
}

$configQueryResult2 = $db->view('*', 'mlm_config', 'configid', "", "configid desc");
if(!$configQueryResult2)
{
	echo mysqli_error($connect);
	exit();
}
$configRow2 = $configQueryResult2['result'][0];

$regid = $validation->input_validate($_POST['regid']);
$refno_custom = $validation->input_validate($_POST['refno_custom']);
$membership_id = $validation->input_validate($_POST['membership_id']);
$sponsor_id = $validation->input_validate($_POST['sponsor_id']);
$billing_first_name = $validation->input_validate($_POST['billing_first_name']);
$billing_last_name = $validation->input_validate($_POST['billing_last_name']);
$billing_mobile = $validation->input_validate($_POST['billing_mobile']);
$billing_mobile_alter = $validation->input_validate($_POST['billing_mobile_alter']);
$billing_address = $validation->input_validate($_POST['billing_address']);
$billing_landmark = $validation->input_validate($_POST['billing_landmark']);
$billing_city = $validation->input_validate($_POST['billing_city']);
$billing_state = $validation->input_validate($_POST['billing_state']);
$billing_country = $validation->input_validate($_POST['billing_country']);
$billing_pincode = $validation->input_validate($_POST['billing_pincode']);
$shipping_first_name = $validation->input_validate($_POST['shipping_first_name']);
$shipping_last_name = $validation->input_validate($_POST['shipping_last_name']);
$shipping_mobile = $validation->input_validate($_POST['shipping_mobile']);
$shipping_mobile_alter = $validation->input_validate($_POST['shipping_mobile_alter']);
$shipping_address = $validation->input_validate($_POST['shipping_address']);
$shipping_landmark = $validation->input_validate($_POST['shipping_landmark']);
$shipping_city = $validation->input_validate($_POST['shipping_city']);
$shipping_state = $validation->input_validate($_POST['shipping_state']);
$shipping_country = $validation->input_validate($_POST['shipping_country']);
$shipping_pincode = $validation->input_validate($_POST['shipping_pincode']);
$note = $validation->input_validate($_POST['note']);
$tracking_status = $validation->input_validate($_POST['tracking_status']);
$old_invoicedate = $validation->input_validate($_POST['old_invoicedate']);
$status = $validation->input_validate($_POST['status']);

$user_ip_array = ($_POST['user_ip']!='') ? explode(", ", $validation->input_validate($_POST['user_ip'])) : array();
array_push($user_ip_array, $user_ip);
$user_ip_array = array_unique($user_ip_array);
$user_ip = implode(", ", $user_ip_array);

$fields = array('billing_first_name'=>$billing_first_name, 'billing_last_name'=>$billing_last_name, 'billing_mobile'=>$billing_mobile, 'billing_mobile_alter'=>$billing_mobile_alter, 'billing_address'=>$billing_address, 'billing_landmark'=>$billing_landmark, 'billing_city'=>$billing_city, 'billing_state'=>$billing_state, 'billing_country'=>$billing_country, 'billing_pincode'=>$billing_pincode, 'shipping_first_name'=>$shipping_first_name, 'shipping_last_name'=>$shipping_last_name, 'shipping_mobile'=>$shipping_mobile, 'shipping_mobile_alter'=>$shipping_mobile_alter, 'shipping_address'=>$shipping_address, 'shipping_landmark'=>$shipping_landmark, 'shipping_city'=>$shipping_city, 'shipping_state'=>$shipping_state, 'shipping_country'=>$shipping_country, 'shipping_pincode'=>$shipping_pincode, 'note'=>$note, 'tracking_status'=>$tracking_status, 'status'=>$status, 'user_ip'=>$user_ip);

if($mode == "insert")
{
	$fields['userid'] = $userid;
	$fields['createtime'] = $createtime;
	$fields['createdate'] = $createdate;
	
	$purchaseQueryResult = $db->insert("rb_purchases", $fields);
	if(!$purchaseQueryResult)
	{
		echo mysqli_error($connect);
		exit();
	}
	
	$_SESSION['success_msg'] = "Record Added!";
	header("Location: purchase_view.php");
	exit();
}
else if($mode == "edit")
{
	if($old_invoicedate == "" and $tracking_status == "delivered")
	{
		$fields['invoicedate'] = $createdate;
	}
	$fields['userid_updt'] = $userid;
	$fields['modifytime'] = $createtime;
	$fields['modifydate'] = $createdate;
	
	$purchaseQueryResult = $db->update("rb_purchases", $fields, array('refno_custom'=>$refno_custom));
	if(!$purchaseQueryResult)
	{
		echo mysqli_error($connect);
		exit();
	}
	
	if($tracking_status == "cancelled")
	{
		$checkPurchaseResult = $db->view("refno_custom,wallet_money", "rb_purchases", "purchaseid", "and purchaseid='{$purchaseid}'", 'purchaseid desc');
		$checkPurchaseRow = $checkPurchaseResult['result'][0];
		$refno_custom = $checkPurchaseRow['refno_custom'];
		$wallet_money = $checkPurchaseRow['wallet_money'];
		
		$productPurchaseResult = $db->view("productid,variantid,quantity", "rb_purchases", "purchaseid", "and refno_custom='{$refno_custom}'", 'purchaseid desc');
		if($productPurchaseResult['num_rows'] >= 1)
		{
			foreach($productPurchaseResult['result'] as $productPurchaseRow)
			{
				$productid = $productPurchaseRow['productid'];
				$variantid = $productPurchaseRow['variantid'];
				$quantity = $productPurchaseRow['quantity'];
				
				$stockResult = $db->custom("update rb_products set stock_quantity = stock_quantity+{$quantity} where productid='{$productid}'");
				if(!$stockResult)
				{
					echo "Stock is not updated! Consult Administrator";
					exit();
				}
				$stockResult2 = $db->custom("update rb_products_variants set stock_quantity = stock_quantity+{$quantity} where productid='{$productid}' and variantid='{$variantid}'");
				if(!$stockResult2)
				{
					echo "Stock is not updated! Consult Administrator";
					exit();
				}
			}
		}
		
		if($wallet_money != "" and $wallet_money != "0" and $wallet_money != "0.00")
		{
			$fields3 = array('status'=>"declined", 'remarks'=>'Product Cancelled');
			$fields3['modifytime'] = $createtime;
			$fields3['modifydate'] = $createdate;
			
			$ewalletrequestResult = $db->update("mlm_ewallet_requests", $fields3, array('purchaseid'=>$purchaseid));
			if(!$ewalletrequestResult)
			{
				echo mysqli_error($connect);
				exit();
			}
			
			$registerwalletResult = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$wallet_money} where regid='{$regid}'");
			if(!$registerwalletResult)
			{
				echo "Member Wallet is not added! Consult Administrator";
				exit();
			}
		}
	}
	
	if($old_invoicedate == "" and $tracking_status == "delivered" and $sponsor_id != "")
	{
		$purchaseQueryResult = $db->view('tracking_status,final_price,price,shipping,coupon_discount,taxamount', 'rb_purchases', 'purchaseid', "and purchaseid = '$purchaseid'");
		$purchaseRow = $purchaseQueryResult['result'][0];
		$total_amount = $validation->db_field_validate($purchaseRow['final_price']);
		$discounted_amount = $validation->calculate_discounted_price('1', $total_amount);
		
		$checkpurchaseResult = $db->view('purchaseid', 'rb_purchases', 'purchaseid', "and membership_id = '$membership_id' and tracking_status != 'cancelled'", '', '', 'refno_custom');
		if($checkpurchaseResult['num_rows'] == 1)
		{
			$mlmregisterResult = $db->view('planid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$membership_id'", 'regid desc', '1');
			$mlmregisterRow = $mlmregisterResult['result'][0];
			$planid = $mlmregisterRow['planid'];
			
			$planResult = $db->view('planid,title,amount', 'mlm_plans', 'planid', "and planid='$planid' and status='active'");
			if($planResult['num_rows'] >= 1)
			{
				$planRow = $planResult['result'][0];
				$amount = $purchaseRow['final_price'];
				$title = $planRow['title'];
				$refno = substr(md5(rand(1, 99999)),0,10);
				$reason = "Joining";
				$description = "Joining on purchasing of &#8377; {$amount}";
				$status = "fulfilled";
				$fields = array('userid'=>$userid, 'regid'=>$regid, 'membership_id'=>$membership_id, 'username'=>$username, 'refno'=>$refno, 'amount'=>$amount, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
				$transactionResult = $db->insert("mlm_transactions", $fields);
				if(!$transactionResult)
				{
					echo "Transaction History is not updated! Consult Administrator";
					exit();
				}
				
				$fields2 = array('userid'=>$userid, 'regid'=>$regid, 'membership_id'=>$membership_id, 'username'=>$username, 'refno'=>$refno, 'amount'=>$amount, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
				$ewalletResult = $db->insert("mlm_ewallet", $fields2);
				if(!$ewalletResult)
				{
					echo "E-Wallet History is not updated! Consult Administrator";
					exit();
				}
				
				$registerwalletResult = $db->custom("update mlm_registrations set total_debit = total_debit+{$amount} where regid='{$regid}'");
				if(!$registerwalletResult)
				{
					echo "Member Wallet is not added! Consult Administrator";
					exit();
				}
			}
			
			if($configRow2['referral_amount'] != '0' and $configRow2['referral_amount'] != '0.00')
			{
				$sponsorResult = $db->view('membership_id,sponsor_id,regid,status,username', 'mlm_registrations', 'regid', "and status='active' and membership_id='$sponsor_id'", 'regid desc', '1');
				if($sponsorResult['num_rows'] >= 1)
				{
					$sponsorRow = $sponsorResult['result'][0];
					$sponsor_regid = $sponsorRow['regid'];
					$sponsor_username = $sponsorRow['username'];
					$amount = $configRow2['referral_amount'];
					$refno = substr(md5(rand(1, 99999)),0,10);
					$reason = "Referral Bonus";
					$description = "Referral Bonus of {$membership_id}";
					$status = "pending";
					$fields = array('userid'=>$userid, 'regid'=>$sponsor_regid, 'membership_id'=>$sponsor_id, 'username'=>$sponsor_username, 'refno'=>$refno, 'amount'=>$amount, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$transactionResult = $db->insert("mlm_transactions", $fields);
					if(!$transactionResult)
					{
						echo "Transaction History is not updated! Consult Administrator";
						exit();
					}
					
					$fields2 = array('userid'=>$userid, 'regid'=>$sponsor_regid, 'membership_id'=>$sponsor_id, 'username'=>$sponsor_username, 'refno'=>$refno, 'amount'=>$amount, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$ewalletResult = $db->insert("mlm_ewallet", $fields2);
					if(!$ewalletResult)
					{
						echo "E-Wallet History is not updated! Consult Administrator";
						exit();
					}
					
					$registerwalletResult = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$amount}, wallet_total = wallet_total+{$amount} where regid='{$sponsor_regid}'");
					if(!$registerwalletResult)
					{
						echo "Member Wallet is not added! Consult Administrator";
						exit();
					}
				}
			}
		}
		else
		{
			$mlmregisterResult = $db->view('planid', 'mlm_registrations', 'regid', "and status='active' and membership_id='$membership_id'", 'regid desc', '1');
			$mlmregisterRow = $mlmregisterResult['result'][0];
			$planid = $mlmregisterRow['planid'];
			
			$planResult = $db->view('planid,title,amount', 'mlm_plans', 'planid', "and planid='$planid' and status='active'");
			if($planResult['num_rows'] >= 1)
			{
				$planRow = $planResult['result'][0];
				$amount = $purchaseRow['final_price'];
				$title = $planRow['title'];
				$refno = substr(md5(rand(1, 99999)),0,10);
				$reason = "Purchasing";
				$description = "Purchasing of &#8377; {$amount}";
				$status = "fulfilled";
				$fields = array('userid'=>$userid, 'regid'=>$regid, 'membership_id'=>$membership_id, 'username'=>$username, 'refno'=>$refno, 'amount'=>$amount, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
				$transactionResult = $db->insert("mlm_transactions", $fields);
				if(!$transactionResult)
				{
					echo "Transaction History is not updated! Consult Administrator";
					exit();
				}
				
				$fields2 = array('userid'=>$userid, 'regid'=>$regid, 'membership_id'=>$membership_id, 'username'=>$username, 'refno'=>$refno, 'amount'=>$amount, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
				$ewalletResult = $db->insert("mlm_ewallet", $fields2);
				if(!$ewalletResult)
				{
					echo "E-Wallet History is not updated! Consult Administrator";
					exit();
				}
				
				$registerwalletResult = $db->custom("update mlm_registrations set total_debit = total_debit+{$amount} where regid='{$regid}'");
				if(!$registerwalletResult)
				{
					echo "Member Wallet is not added! Consult Administrator";
					exit();
				}
			}
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
				
				if($discounted_amount != "" and $discounted_amount != "0")
				{
					$refno1 = substr(md5(rand(1, 99999)),0,10);
					$discounted_amount1 = $discounted_amount;
					$total_amount1 = $validation->price_format($total_amount);
					$reason = "Earnings";
					$description = "Earnings for puchasing of &#8377;{$total_amount1} by {$membership_id}";
					$status = "pending";
					$fields4 = array('userid'=>$userid, 'regid'=>$regid1, 'membership_id'=>$membership_id1, 'username'=>$username1, 'refno'=>$refno1, 'amount'=>$discounted_amount1, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$transactionResult = $db->insert("mlm_transactions", $fields4);
					
					$fields5 = array('userid'=>$userid, 'regid'=>$regid1, 'membership_id'=>$membership_id1, 'username'=>$username1, 'refno'=>$refno1, 'amount'=>$discounted_amount1, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$ewalletResult = $db->insert("mlm_ewallet", $fields5);
					
					$registerwalletResult1 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$discounted_amount1}, wallet_total = wallet_total+{$discounted_amount1} where regid='{$regid1}'");
					if(!$registerwalletResult1)
					{
						echo "Member Wallet is not added! Consult Administrator";
						exit();
					}
				}
				
				
				$registerResult2 = $db->view("wallet_total", "mlm_registrations", "regid", "and regid='{$regid1}'");
				$registerRow2 = $registerResult2['result'][0];
				$total_credit_amount = $registerRow2['wallet_total'];
				
				$memberRewardResult1 = $db->view('members,rewardid,amount,earnings,title', 'mlm_rewards', 'rewardid', "and status='active' and planid='$planid' and earnings <= '$total_credit_amount' and rewardid > '$memberrewardid1'", 'rewardid asc', '1');
				if($memberRewardResult1['num_rows'] >= 1)
				{
					$memberRewardRow1 = $memberRewardResult1['result'][0];
					$title1 = $memberRewardRow1['title'];
					$rewardid1 = $memberRewardRow1['rewardid'];
					$amount1 = $memberRewardRow1['amount'];
					$members1 = $memberRewardRow1['members'];
					$earnings1 = $validation->price_format($memberRewardRow1['earnings']);
					$query1 = ", rewardid='{$rewardid1}'";
					
					$refno1 = substr(md5(rand(1, 99999)),0,10);
					$reason = "Reward";
					$description = "Reward for completing the earning of &#8377;{$earnings1} ({$title1})";
					$status = "pending";
					$fields = array('userid'=>$userid, 'regid'=>$regid1, 'membership_id'=>$membership_id1, 'username'=>$username1, 'refno'=>$refno1, 'amount'=>$amount1, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$transactionResult = $db->insert("mlm_transactions", $fields);
					
					$fields2 = array('userid'=>$userid, 'regid'=>$regid1, 'membership_id'=>$membership_id1, 'username'=>$username1, 'refno'=>$refno1, 'amount'=>$amount1, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
					$ewalletResult = $db->insert("mlm_ewallet", $fields2);
					
					$fields3 = $db->update("mlm_registrations", array('rewardid'=>$rewardid1), array('regid'=>$regid1));
					
					$registerwalletResult1 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$amount1}, wallet_total = wallet_total+{$amount1} where regid='{$regid1}'");
					if(!$registerwalletResult1)
					{
						echo "Member Wallet is not added! Consult Administrator";
						exit();
					}
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
						
						if($discounted_amount != "" and $discounted_amount != "0")
						{
							$refno2 = substr(md5(rand(1, 99999)),0,10);
							$discounted_amount2 = $discounted_amount;
							$total_amount2 = $validation->price_format($total_amount);
							$reason = "Earnings";
							$description = "Earnings for puchasing of &#8377;{$total_amount2} by {$membership_id}";
							$status = "pending";
							$fields4 = array('userid'=>$userid, 'regid'=>$regid2, 'membership_id'=>$membership_id2, 'username'=>$username2, 'refno'=>$refno2, 'amount'=>$discounted_amount2, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
							$transactionResult = $db->insert("mlm_transactions", $fields4);
							
							$fields5 = array('userid'=>$userid, 'regid'=>$regid2, 'membership_id'=>$membership_id2, 'username'=>$username2, 'refno'=>$refno2, 'amount'=>$discounted_amount2, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
							$ewalletResult = $db->insert("mlm_ewallet", $fields5);
							
							$registerwalletResult2 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$discounted_amount2}, wallet_total = wallet_total+{$discounted_amount2} where regid='{$regid2}'");
							if(!$registerwalletResult2)
							{
								echo "Member Wallet is not added! Consult Administrator";
								exit();
							}
						}
						
						$registerResult2 = $db->view("wallet_total", "mlm_registrations", "regid", "and regid='{$regid2}'");
						$registerRow2 = $registerResult2['result'][0];
						$total_credit_amount = $registerRow2['wallet_total'];
						
						$memberRewardResult2 = $db->view('members,rewardid,amount,earnings,title', 'mlm_rewards', 'rewardid', "and status='active' and planid='$planid' and earnings <= '$total_credit_amount' and rewardid > '$memberrewardid2'", 'rewardid asc', '1');
						if($memberRewardResult2['num_rows'] >= 1)
						{
							$memberRewardRow2 = $memberRewardResult2['result'][0];
							$title2 = $memberRewardRow2['title'];
							$rewardid2 = $memberRewardRow2['rewardid'];
							$amount2 = $memberRewardRow2['amount'];
							$members2 = $memberRewardRow2['members'];
							$earnings2 = $validation->price_format($memberRewardRow2['earnings']);
							$query2 = ", rewardid='{$rewardid2}'";
							
							$refno2 = substr(md5(rand(1, 99999)),0,10);
							$reason = "Reward";
							$description = "Reward for completing the earning of &#8377;{$earnings2} ({$title2})";
							$status = "pending";
							$fields = array('userid'=>$userid, 'regid'=>$regid2, 'membership_id'=>$membership_id2, 'username'=>$username2, 'refno'=>$refno2, 'amount'=>$amount2, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
							$transactionResult = $db->insert("mlm_transactions", $fields);
							
							$fields2 = array('userid'=>$userid, 'regid'=>$regid2, 'membership_id'=>$membership_id2, 'username'=>$username2, 'refno'=>$refno2, 'amount'=>$amount2, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
							$ewalletResult = $db->insert("mlm_ewallet", $fields2);
							
							$fields3 = $db->update("mlm_registrations", array('rewardid'=>$rewardid2), array('regid'=>$regid2));
							
							$registerwalletResult2 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$amount2}, wallet_total = wallet_total+{$amount2} where regid='{$regid2}'");
							if(!$registerwalletResult2)
							{
								echo "Member Wallet is not added! Consult Administrator";
								exit();
							}
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
								
								if($discounted_amount != "" and $discounted_amount != "0")
								{
									$refno3 = substr(md5(rand(1, 99999)),0,10);
									$discounted_amount3 = $discounted_amount;
									$total_amount3 = $validation->price_format($total_amount);
									$reason = "Earnings";
									$description = "Earnings for puchasing of &#8377;{$total_amount3} by {$membership_id}";
									$status = "pending";
									$fields4 = array('userid'=>$userid, 'regid'=>$regid3, 'membership_id'=>$membership_id3, 'username'=>$username3, 'refno'=>$refno3, 'amount'=>$discounted_amount3, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
									$transactionResult = $db->insert("mlm_transactions", $fields4);
									
									$fields5 = array('userid'=>$userid, 'regid'=>$regid3, 'membership_id'=>$membership_id3, 'username'=>$username3, 'refno'=>$refno3, 'amount'=>$discounted_amount3, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
									$ewalletResult = $db->insert("mlm_ewallet", $fields5);
									
									$registerwalletResult3 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$discounted_amount3}, wallet_total = wallet_total+{$discounted_amount3} where regid='{$regid3}'");
									if(!$registerwalletResult3)
									{
										echo "Member Wallet is not added! Consult Administrator";
										exit();
									}
								}
								
								$registerResult2 = $db->view("wallet_total", "mlm_registrations", "regid", "and regid='{$regid3}'");
								$registerRow2 = $registerResult2['result'][0];
								$total_credit_amount = $registerRow2['wallet_total'];
								
								$memberRewardResult3 = $db->view('members,rewardid,amount,earnings,title', 'mlm_rewards', 'rewardid', "and status='active' and planid='$planid' and earnings <= '$total_credit_amount' and rewardid > '$memberrewardid3'", 'rewardid asc', '1');
								if($memberRewardResult3['num_rows'] >= 1)
								{
									$memberRewardRow3 = $memberRewardResult3['result'][0];
									$title3 = $memberRewardRow3['title'];
									$rewardid3 = $memberRewardRow3['rewardid'];
									$amount3 = $memberRewardRow3['amount'];
									$members3 = $memberRewardRow3['members'];
									$earnings3 = $validation->price_format($memberRewardRow3['earnings']);
									$query3 = ", rewardid='{$rewardid3}'";
									
									$refno3 = substr(md5(rand(1, 99999)),0,10);
									$reason = "Reward";
									$description = "Reward for completing the earning of &#8377;{$earnings3} ({$title3})";
									$status = "pending";
									$fields = array('userid'=>$userid, 'regid'=>$regid3, 'membership_id'=>$membership_id3, 'username'=>$username3, 'refno'=>$refno3, 'amount'=>$amount3, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
									$transactionResult = $db->insert("mlm_transactions", $fields);
									
									$fields2 = array('userid'=>$userid, 'regid'=>$regid3, 'membership_id'=>$membership_id3, 'username'=>$username3, 'refno'=>$refno3, 'amount'=>$amount3, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
									$ewalletResult = $db->insert("mlm_ewallet", $fields2);
									
									$fields3 = $db->update("mlm_registrations", array('rewardid'=>$rewardid3), array('regid'=>$regid3));
									
									$registerwalletResult3 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$amount3}, wallet_total = wallet_total+{$amount3} where regid='{$regid3}'");
									if(!$registerwalletResult3)
									{
										echo "Member Wallet is not added! Consult Administrator";
										exit();
									}
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
										
										if($discounted_amount != "" and $discounted_amount != "0")
										{
											$refno4 = substr(md5(rand(1, 99999)),0,10);
											$discounted_amount4 = $discounted_amount;
											$total_amount4 = $validation->price_format($total_amount);
											$reason = "Earnings";
											$description = "Earnings for puchasing of &#8377;{$total_amount4} by {$membership_id}";
											$status = "pending";
											$fields4 = array('userid'=>$userid, 'regid'=>$regid4, 'membership_id'=>$membership_id4, 'username'=>$username4, 'refno'=>$refno4, 'amount'=>$discounted_amount4, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
											$transactionResult = $db->insert("mlm_transactions", $fields4);
											
											$fields5 = array('userid'=>$userid, 'regid'=>$regid4, 'membership_id'=>$membership_id4, 'username'=>$username4, 'refno'=>$refno4, 'amount'=>$discounted_amount4, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
											$ewalletResult = $db->insert("mlm_ewallet", $fields5);
											
											$registerwalletResult4 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$discounted_amount4}, wallet_total = wallet_total+{$discounted_amount4} where regid='{$regid4}'");
											if(!$registerwalletResult4)
											{
												echo "Member Wallet is not added! Consult Administrator";
												exit();
											}
										}
										
										$registerResult2 = $db->view("wallet_total", "mlm_registrations", "regid", "and regid='{$regid4}'");
										$registerRow2 = $registerResult2['result'][0];
										$total_credit_amount = $registerRow2['wallet_total'];
										
										$memberRewardResult4 = $db->view('members,rewardid,amount,earnings,title', 'mlm_rewards', 'rewardid', "and status='active' and planid='$planid' and earnings <= '$total_credit_amount' and rewardid > '$memberrewardid4'", 'rewardid asc', '1');
										if($memberRewardResult4['num_rows'] >= 1)
										{
											$memberRewardRow4 = $memberRewardResult4['result'][0];
											$title4 = $memberRewardRow4['title'];
											$rewardid4 = $memberRewardRow4['rewardid'];
											$amount4 = $memberRewardRow4['amount'];
											$members4 = $memberRewardRow4['members'];
											$earnings4 = $validation->price_format($memberRewardRow4['earnings']);
											$query4 = ", rewardid='{$rewardid4}'";
											
											$refno4 = substr(md5(rand(1, 99999)),0,10);
											$reason = "Reward";
											$description = "Reward for completing the earning of &#8377;{$earnings4} ({$title4})";
											$status = "pending";
											$fields = array('userid'=>$userid, 'regid'=>$regid4, 'membership_id'=>$membership_id4, 'username'=>$username4, 'refno'=>$refno4, 'amount'=>$amount4, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
											$transactionResult = $db->insert("mlm_transactions", $fields);
											
											$fields2 = array('userid'=>$userid, 'regid'=>$regid4, 'membership_id'=>$membership_id4, 'username'=>$username4, 'refno'=>$refno4, 'amount'=>$amount4, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
											$ewalletResult = $db->insert("mlm_ewallet", $fields2);
											
											$fields3 = $db->update("mlm_registrations", array('rewardid'=>$rewardid4), array('regid'=>$regid4));
											
											$registerwalletResult4 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$amount4}, wallet_total = wallet_total+{$amount4} where regid='{$regid4}'");
											if(!$registerwalletResult4)
											{
												echo "Member Wallet is not added! Consult Administrator";
												exit();
											}
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
												
												if($discounted_amount != "" and $discounted_amount != "0")
												{
													$refno5 = substr(md5(rand(1, 99999)),0,10);
													$discounted_amount5 = $discounted_amount;
													$total_amount5 = $validation->price_format($total_amount);
													$reason = "Earnings";
													$description = "Earnings for puchasing of &#8377;{$total_amount5} by {$membership_id}";
													$status = "pending";
													$fields4 = array('userid'=>$userid, 'regid'=>$regid5, 'membership_id'=>$membership_id5, 'username'=>$username5, 'refno'=>$refno5, 'amount'=>$discounted_amount5, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
													$transactionResult = $db->insert("mlm_transactions", $fields4);
													
													$fields5 = array('userid'=>$userid, 'regid'=>$regid5, 'membership_id'=>$membership_id5, 'username'=>$username5, 'refno'=>$refno5, 'amount'=>$discounted_amount5, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
													$ewalletResult = $db->insert("mlm_ewallet", $fields5);
													
													$registerwalletResult5 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$discounted_amount5}, wallet_total = wallet_total+{$discounted_amount5} where regid='{$regid5}'");
													if(!$registerwalletResult5)
													{
														echo "Member Wallet is not added! Consult Administrator";
														exit();
													}
												}
												
												$registerResult2 = $db->view("wallet_total", "mlm_registrations", "regid", "and regid='{$regid5}'");
												$registerRow2 = $registerResult2['result'][0];
												$total_credit_amount = $registerRow2['wallet_total'];
												
												$memberRewardResult5 = $db->view('members,rewardid,amount,earnings,title', 'mlm_rewards', 'rewardid', "and status='active' and planid='$planid' and earnings <= '$total_credit_amount' and rewardid > '$memberrewardid5'", 'rewardid asc', '1');
												if($memberRewardResult5['num_rows'] >= 1)
												{
													$memberRewardRow5 = $memberRewardResult5['result'][0];
													$title5 = $memberRewardRow5['title'];
													$rewardid5 = $memberRewardRow5['rewardid'];
													$amount5 = $memberRewardRow5['amount'];
													$members5 = $memberRewardRow5['members'];
													$earnings5 = $validation->price_format($memberRewardRow5['earnings']);
													$query5 = ", rewardid='{$rewardid5}'";
													
													$refno5 = substr(md5(rand(1, 99999)),0,10);
													$reason = "Reward";
													$description = "Reward for completing the earning of &#8377;{$earnings5} ({$title5})";
													$status = "pending";
													$fields = array('userid'=>$userid, 'regid'=>$regid5, 'membership_id'=>$membership_id5, 'username'=>$username5, 'refno'=>$refno5, 'amount'=>$amount5, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
													$transactionResult = $db->insert("mlm_transactions", $fields);
													
													$fields2 = array('userid'=>$userid, 'regid'=>$regid5, 'membership_id'=>$membership_id5, 'username'=>$username5, 'refno'=>$refno5, 'amount'=>$amount5, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
													$ewalletResult = $db->insert("mlm_ewallet", $fields2);
													
													$fields3 = $db->update("mlm_registrations", array('rewardid'=>$rewardid5), array('regid'=>$regid5));
													
													$registerwalletResult5 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$amount5}, wallet_total = wallet_total+{$amount5} where regid='{$regid5}'");
													if(!$registerwalletResult5)
													{
														echo "Member Wallet is not added! Consult Administrator";
														exit();
													}
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
														
														if($discounted_amount != "" and $discounted_amount != "0")
														{
															$refno6 = substr(md5(rand(1, 99999)),0,10);
															$discounted_amount6 = $discounted_amount;
															$total_amount6 = $validation->price_format($total_amount);
															$reason = "Earnings";
															$description = "Earnings for puchasing of &#8377;{$total_amount6} by {$membership_id}";
															$status = "pending";
															$fields4 = array('userid'=>$userid, 'regid'=>$regid6, 'membership_id'=>$membership_id6, 'username'=>$username6, 'refno'=>$refno6, 'amount'=>$discounted_amount6, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
															$transactionResult = $db->insert("mlm_transactions", $fields4);
															
															$fields6 = array('userid'=>$userid, 'regid'=>$regid6, 'membership_id'=>$membership_id6, 'username'=>$username6, 'refno'=>$refno6, 'amount'=>$discounted_amount6, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
															$ewalletResult = $db->insert("mlm_ewallet", $fields6);
															
															$registerwalletResult6 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$discounted_amount6}, wallet_total = wallet_total+{$discounted_amount6} where regid='{$regid6}'");
															if(!$registerwalletResult6)
															{
																echo "Member Wallet is not added! Consult Administrator";
																exit();
															}
														}
														
														$registerResult2 = $db->view("wallet_total", "mlm_registrations", "regid", "and regid='{$regid6}'");
														$registerRow2 = $registerResult2['result'][0];
														$total_credit_amount = $registerRow2['wallet_total'];
														
														$memberRewardResult6 = $db->view('members,rewardid,amount,earnings,title', 'mlm_rewards', 'rewardid', "and status='active' and planid='$planid' and earnings <= '$total_credit_amount' and rewardid > '$memberrewardid6'", 'rewardid asc', '1');
														if($memberRewardResult6['num_rows'] >= 1)
														{
															$memberRewardRow6 = $memberRewardResult6['result'][0];
															$title6 = $memberRewardRow6['title'];
															$rewardid6 = $memberRewardRow6['rewardid'];
															$amount6 = $memberRewardRow6['amount'];
															$members6 = $memberRewardRow6['members'];
															$earnings6 = $validation->price_format($memberRewardRow6['earnings']);
															$query6 = ", rewardid='{$rewardid6}'";
															
															$refno6 = substr(md5(rand(1, 99999)),0,10);
															$reason = "Reward";
															$description = "Reward for completing the earning of &#8377;{$earnings6} ({$title6})";
															$status = "pending";
															$fields = array('userid'=>$userid, 'regid'=>$regid6, 'membership_id'=>$membership_id6, 'username'=>$username6, 'refno'=>$refno6, 'amount'=>$amount6, 'type'=>'debit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
															$transactionResult = $db->insert("mlm_transactions", $fields);
															
															$fields2 = array('userid'=>$userid, 'regid'=>$regid6, 'membership_id'=>$membership_id6, 'username'=>$username6, 'refno'=>$refno6, 'amount'=>$amount6, 'type'=>'credit', 'reason'=>$reason, 'description'=>$description, 'status'=>$status, 'user_ip'=>$user_ip, 'createtime'=>$createtime, 'createdate'=>$createdate);
															$ewalletResult = $db->insert("mlm_ewallet", $fields2);
															
															$fields3 = $db->update("mlm_registrations", array('rewardid'=>$rewardid6), array('regid'=>$regid6));
															
															$registerwalletResult6 = $db->custom("update mlm_registrations set wallet_money = wallet_money+{$amount6}, wallet_total = wallet_total+{$amount6} where regid='{$regid6}'");
															if(!$registerwalletResult6)
															{
																echo "Member Wallet is not added! Consult Administrator";
																exit();
															}
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
	}
	
	$_SESSION['success_msg'] = "Record Updated!";
	header("Location: purchase_view.php$search_filter");
	exit();
}
?>