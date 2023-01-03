<?php
include_once("inc_config.php");
include_once('razorpay/config.php');
include_once('razorpay/razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

if($_SESSION['regid'] == "")
{
	$_SESSION['error_msg_fe'] = "Login to continue!";
	header("Location: {$base_url}login{$suffix}");
	exit();
}

$payment_mode = $validation->input_validate($_POST['payment_mode']);

if($payment_mode == "cod")
{
	if(isset($_POST['token']) && $_POST['token'] === $_SESSION['csrf_token'])
	{
		if(isset($_POST['proceed']))
		{
			$membership_id = $validation->input_validate($_POST['membership_id']);
			$sponsor_id = $validation->input_validate($_POST['sponsor_id']);
			$wallet_money = $validation->input_validate($_POST['wallet_money']);
			
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
			
			if(isset($_POST['shipping_box']))
			{
				$shipping_box = "yes";
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
			}
			else
			{
				$shipping_box = "no";
				$shipping_first_name = $billing_first_name;
				$shipping_last_name = $billing_last_name;
				$shipping_mobile = $billing_mobile;
				$shipping_mobile_alter = $billing_mobile_alter;
				$shipping_address = $billing_address;
				$shipping_landmark = $billing_landmark;
				$shipping_city = $billing_city;
				$shipping_state = $billing_state;
				$shipping_country = $billing_country;
				$shipping_pincode = $billing_pincode;
			}
			
			$note = $validation->input_validate($_POST['note']);
			$cart_refno = $_SESSION['cart_refno'];
		}
	}
	else
	{
		$_SESSION['error_msg_fe'] = "Error Occurred! Please try again.";
		header("Location: {$base_url}checkout{$suffix}");
		exit();
	}
}
else
{
	$success = true;
	$error = "Payment Failed";
	
	if (empty($_POST['razorpay_payment_id']) === false)
	{
		$api = new Api($keyId, $keySecret);

		try
		{
			// Please note that the razorpay order ID must
			// come from a trusted source (session here, but
			// could be database or something else)
			$attributes = array(
				'razorpay_order_id' => $_SESSION['razorpay_order_id'],
				'razorpay_payment_id' => $_POST['razorpay_payment_id'],
				'razorpay_signature' => $_POST['razorpay_signature']
			);

			$api->utility->verifyPaymentSignature($attributes);
		}
		catch(SignatureVerificationError $e)
		{
			$success = false;
			$error = 'Razorpay Error : ' . $e->getMessage();
		}
	}
	
	if ($success === true)
	{
		echo "<p>Your payment was successful</p><p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
	}
	else
	{
		echo "<p>Your payment failed</p><p>{$error}</p>";
		header("Location: {$base_url}page/payment-failed/");
		exit();
	}
	
	$membership_id = $validation->input_validate($_POST['membership_id']);
	$sponsor_id = $validation->input_validate($_POST['sponsor_id']);
	$wallet_money = $validation->input_validate($_POST['wallet_money']);
	
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
	
	if(isset($_POST['shipping_box']))
	{
		$shipping_box = "yes";
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
	}
	else
	{
		$shipping_box = "no";
		$shipping_first_name = $billing_first_name;
		$shipping_last_name = $billing_last_name;
		$shipping_mobile = $billing_mobile;
		$shipping_mobile_alter = $billing_mobile_alter;
		$shipping_address = $billing_address;
		$shipping_landmark = $billing_landmark;
		$shipping_city = $billing_city;
		$shipping_state = $billing_state;
		$shipping_country = $billing_country;
		$shipping_pincode = $billing_pincode;
	}
	
	$note = $validation->input_validate($_POST['note']);
	$payment_mode = $validation->input_validate($_POST['payment_mode']);
	$cart_refno = $_SESSION['cart_refno'];
	
	$razorpay_order_id = $_SESSION['razorpay_order_id'];
	$razorpay_payment_id = $_POST['razorpay_payment_id'];
	$razorpay_signature = $_POST['razorpay_signature'];
}

if($payment_mode == "online transfer" and $razorpay_order_id == "")
{
	$_SESSION['error_msg_fe'] = "Please select a valid payment method!";
	header("Location: {$base_url}checkout{$suffix}");
	exit();
}

if($wallet_money == "")
{
	$wallet_money = "0";
}

if($membership_id == "" || $sponsor_id == "" || $billing_first_name == "" || $billing_mobile == "" || $billing_address == "" || $billing_city == "" || $billing_state == "" || $billing_country == "" || $billing_pincode == "" || $shipping_first_name == "" || $shipping_mobile == "" || $shipping_address == "" || $shipping_city == "" || $shipping_state == "" || $shipping_country == "" || $shipping_pincode == "" || $payment_mode == "")
{
	$_SESSION['error_msg_fe'] = "Please select valid parameters to continue!";
	header("Location: {$base_url}checkout{$suffix}");
	exit();
}

$pincode = $_SESSION['pincode'];
$pincodeResult = $db->view('pincodeid,pincode', 'rb_pincodes', 'pincodeid', "and pincode = '$pincode' and status = 'active'");
if($pincodeResult['num_rows'] == 0)
{
	$_SESSION['error_msg_fe'] = "One of your selected product is maybe Out of Stock now!";
	header("Location: {$base_url}cart{$suffix}");
	exit();
}

$fields2 = array('membership_id'=>$membership_id, 'sponsor_id'=>$sponsor_id, 'user_ip'=>$user_ip);
$fields2['modifytime'] = $createtime;
$fields2['modifydate'] = $createdate;
$profileResult = $db->update("rb_registrations", $fields2, array('regid'=>$regid));
if(!$profileResult)
{
	echo mysqli_error($connect);
	exit();
}

$purchasetempResult = $db->view('*', 'rb_purchases_temp', 'tempid', "and regid = '$regid' and refno = '$cart_refno' and status = 'active'", "tempid desc");
$cartResult = $db->view('*', 'rb_cart', 'cartid', "and regid = '$regid' and refno = '$cart_refno' and status = 'active'", "cartid desc");

if($purchasetempResult['num_rows'] >= 1 and $cartResult['num_rows'] >= 1)
{
	$purchasetempRow = $purchasetempResult['result'][0];
	$total_price = $validation->input_validate($purchasetempRow['total_price']);
	$coupon_code = $validation->input_validate($purchasetempRow['coupon_code']);
	$coupon_discount_total = $validation->input_validate($purchasetempRow['coupon_discount']);
	$shipping_total = $validation->input_validate($purchasetempRow['shipping_total']);
	$taxamount_total = $validation->input_validate($purchasetempRow['taxamount_total']);
	$final_price = $validation->input_validate($purchasetempRow['final_price']);
	$price_detail = explode(",", $purchasetempRow['price_detail']);
	$shipping_detail = explode(",", $purchasetempRow['shipping_detail']);
	$taxamount_detail = explode(",", $purchasetempRow['taxamount_detail']);
	$tax_detail = explode(",", $purchasetempRow['tax_detail']);
	$taxinformation_detail = explode(",", $purchasetempRow['taxinformation_detail']);
	$taxtype_detail = explode(",", $purchasetempRow['taxtype_detail']);
	$count = count($price_detail);
	$coupon_discount = $coupon_discount_total / $count;
	
	if($final_price == 0)
	{
		header("Location: {$base_url}cart{$suffix}");
		exit();
	}
	
	if($final_price < $configRow['minimum_cart'])
	{
		$_SESSION['error_msg_fe'] = "Minimum cart value should be &#8377;{$configRow['minimum_cart']}";
		header("Location: {$base_url}cart{$suffix}");
		exit();
	}
	
	$refno_custom = "";
	$current_year = date('Y');
	$updated_year = date('y');
	$refResult = $db->view("MAX(refno_custom_value) as max_refno_custom_value", "rb_purchases", "purchaseid", "and YEAR(createdate) = '$current_year'");
	$refRow = $refResult['result'][0];
	$max_refno_custom_value = $refRow['max_refno_custom_value'];
	$refno_custom_value = $max_refno_custom_value+1;
	$refno_custom_value = sprintf("%02d", $refno_custom_value);
	$refno_custom = "GM-".$updated_year."-".$refno_custom_value;
	
	$slr = 0;
	foreach($cartResult['result'] as $cartRow)
	{
		$productid = $validation->input_validate($cartRow['productid']);
		$quantity = $validation->input_validate($cartRow['quantity']);
		$product_price = $validation->input_validate($cartRow['price']);
		
		$variantid = $cartRow['variantid'];
		$variantResult = $db->view('stock_quantity,variant', 'rb_products_variants', 'variantid', "and productid = '$productid' and variantid='$variantid'", 'variantid asc');
		$variantRow = $variantResult['result'][0];
		$product_variant = $validation->input_validate($variantRow['variant']);
		$product_stock_quantity = $validation->input_validate($variantRow['stock_quantity']);
		
		$price = $price_detail[$slr];
		$shipping = $shipping_detail[$slr];
		$tax = $tax_detail[$slr];
		$taxamount = $taxamount_detail[$slr];
		$tax_information = $taxinformation_detail[$slr];
		$tax_type = $taxtype_detail[$slr];
		
		$productResult = $db->view("*", "rb_products", "productid", "and productid='{$productid}'");
		$productRow = $productResult['result'][0];
		$product_imgName = explode(" | ", $productRow['imgName']);
		$product_imgName = $product_imgName[0];
		$product_title = $validation->input_validate($productRow['title']);
		$product_title_id = $validation->input_validate($productRow['title_id']);
		$product_currency_code = $validation->input_validate($productRow['currency_code']);
		$stock_quantity = $validation->input_validate($product_stock_quantity);
		if($quantity > $stock_quantity)
		{
			$fields = array('quantity'=>$product_stock_quantity, 'user_ip'=>$user_ip);
			$fields['modifytime'] = $createtime;
			$fields['modifydate'] = $createdate;
			
			$cartupdateResult = $db->update("rb_cart", $fields, array('regid'=>$regid, 'productid'=>$productid, 'status'=>'active'));
			if(!$cartupdateResult)
			{
				echo mysqli_error($connect);
				exit();
			}
			
			$_SESSION['error_msg_fe'] = "One of your selected product is maybe Out of Stock now!";
			header("Location: {$base_url}cart{$suffix}");
			exit();
		}
		
		$refno = "";
		$current_year = date('Y');
		$updated_year = date('y');
		$refResult = $db->view("MAX(refno_value) as max_refno_value", "rb_purchases", "purchaseid", "and YEAR(createdate) = '$current_year'");
		$refRow = $refResult['result'][0];
		$max_refno_value = $refRow['max_refno_value'];
		$refno_value = $max_refno_value+1;
		$refno_value = sprintf("%02d", $refno_value);
		$refno = "GM-".$updated_year."-".$refno_value;
		
		$fields = array('regid'=>$regid, 'refno'=>$refno, 'refno_value'=>$refno_value, 'refno_custom'=>$refno_custom, 'refno_custom_value'=>$refno_custom_value, 'cart_refno'=>$cart_refno, 'razorpay_order_id'=>$razorpay_order_id, 'razorpay_payment_id'=>$razorpay_payment_id, 'razorpay_signature'=>$razorpay_signature, 'membership_id'=>$membership_id, 'sponsor_id'=>$sponsor_id, 'billing_first_name'=>$billing_first_name, 'billing_last_name'=>$billing_last_name, 'billing_mobile'=>$billing_mobile, 'billing_mobile_alter'=>$billing_mobile_alter, 'billing_address'=>$billing_address, 'billing_landmark'=>$billing_landmark, 'billing_city'=>$billing_city, 'billing_state'=>$billing_state, 'billing_country'=>$billing_country, 'billing_pincode'=>$billing_pincode, 'shipping_box'=>$shipping_box, 'shipping_first_name'=>$shipping_first_name, 'shipping_last_name'=>$shipping_last_name, 'shipping_mobile'=>$shipping_mobile, 'shipping_mobile_alter'=>$shipping_mobile_alter, 'shipping_address'=>$shipping_address, 'shipping_landmark'=>$shipping_landmark, 'shipping_city'=>$shipping_city, 'shipping_state'=>$shipping_state, 'shipping_country'=>$shipping_country, 'shipping_pincode'=>$shipping_pincode, 'note'=>$note, 'payment_mode'=>$payment_mode, 'productid'=>$productid, 'variantid'=>$variantid, 'quantity'=>$quantity, 'product_price'=>$product_price, 'product_imgName'=>$product_imgName, 'product_title'=>$product_title, 'product_title_id'=>$product_title_id, 'product_variant'=>$product_variant, 'product_currency_code'=>$product_currency_code, 'price'=>$price, 'shipping'=>$shipping, 'tax'=>$tax, 'taxamount'=>$taxamount, 'tax_information'=>$tax_information, 'tax_type'=>$tax_type, 'total_price'=>$total_price, 'coupon_code'=>$coupon_code, 'coupon_discount'=>$coupon_discount, 'coupon_discount_total'=>$coupon_discount_total, 'shipping_total'=>$shipping_total, 'taxamount_total'=>$taxamount_total, 'wallet_money'=>$wallet_money, 'final_price'=>$final_price, 'user_ip'=>$user_ip);
		$fields['createtime'] = $createtime;
		$fields['createdate'] = $createdate;
		
		$purchaseResult = $db->insert("rb_purchases", $fields);
		if(!$purchaseResult)
		{
			echo "Order is not placed! Consult Administrator";
			exit();
		}
		
		$stockResult = $db->custom("update rb_products set stock_quantity = stock_quantity-{$quantity} where productid='{$productid}'");
		if(!$stockResult)
		{
			echo "Stock is not updated! Consult Administrator";
			exit();
		}
		$stockResult2 = $db->custom("update rb_products_variants set stock_quantity = stock_quantity-{$quantity} where productid='{$productid}' and variantid='{$variantid}'");
		if(!$stockResult2)
		{
			echo "Stock is not updated! Consult Administrator";
			exit();
		}
		
		$slr++;
	}
	
	if($wallet_money != "" and $wallet_money != "0")
	{
		$registerQueryResult = $db->view('*', 'mlm_registrations', 'regid', "and regid = '$regid'");
		$registerRow = $registerQueryResult['result'][0];
		
		// $walletResult = $db->view("SUM(amount) as total_wallet_amount", "mlm_ewallet", "regid", "and type='credit' and regid='{$regid}'");
		// $walletRow = $walletResult['result'][0];
		// $total_wallet_amount = $walletRow['total_wallet_amount'];

		// $walletrequestsResult = $db->view("SUM(amount) as total_requests_amount", "mlm_ewallet_requests", "regid", "and status != 'declined' and regid='{$regid}'");
		// $walletrequestsRow = $walletrequestsResult['result'][0];
		// $total_requests_amount = $walletrequestsRow['total_requests_amount'];
		
		$totalwalletResult = $db->view('wallet_total,wallet_money', 'mlm_registrations', 'regid', "and regid = '$regid' and status='active'");
		$totalwalletRow = $totalwalletResult['result'][0];
		
		$balance = $totalwalletRow['wallet_money']-$wallet_money;

		$refno = substr(md5(rand(1, 99999)),0,22);
		$remarks = "Deduction on Product Purchasing";
		
		$fields3 = array('regid'=>$regid, 'purchaseid'=>$purchaseResult, 'membership_id'=>$membership_id, 'refno'=>$refno, 'mobile'=>$registerRow['mobile'], 'bank_name'=>$registerRow['bank_name'], 'account_number'=>$registerRow['account_number'], 'ifsc_code'=>$registerRow['ifsc_code'], 'account_name'=>$registerRow['account_name'], 'amount'=>$wallet_money, 'balance'=>$balance, 'remarks'=>$remarks, 'status'=>"fulfilled", 'user_ip'=>$user_ip);
		$fields3['createtime'] = $createtime;
		$fields3['createdate'] = $createdate;

		$ewalletrequestResult = $db->insert("mlm_ewallet_requests", $fields3);
		if(!$ewalletrequestResult)
		{
			echo mysqli_error($connect);
			exit();
		}
		
		$registerwalletResult = $db->custom("update mlm_registrations set wallet_money = wallet_money-{$wallet_money} where regid='{$regid}'");
		if(!$registerwalletResult)
		{
			echo "Member Wallet is not added! Consult Administrator";
			exit();
		}
	}
	
	$deletepurchasetempResult = $db->delete("rb_purchases_temp", array('regid'=>$regid));
	if(!$deletepurchasetempResult)
	{
		echo "Temporary purchase list is not removed! Consult Administrator";
		exit();
	}
	
	$deletecartResult = $db->delete("rb_cart", array('regid'=>$regid, 'refno'=>$cart_refno));
	if(!$deletecartResult)
	{
		echo "Cart list is not removed! Consult Administrator";
		exit();
	}
}
else
{
	$_SESSION['error_msg_fe'] = "Error Occurred! Please try again.";
	header("Location: {$base_url}checkout{$suffix}");
	exit();
}

$_SESSION['coupon_error_msg_fe'] = "";
$_SESSION['coupon_success_msg_fe'] = "";
$_SESSION['coupon_discount'] = "";
$_SESSION['coupon_code'] = "";
$_SESSION['cart_refno'] = "";
//$_SESSION['success_msg_fe'] = "Your order has been successfully placed!";
header("Location: {$base_url}success{$suffix}");
exit();
?>