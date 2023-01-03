<?php
include_once("inc_config.php");

if($_SESSION['regid'] == "")
{
	$_SESSION['error_msg_fe'] = "Login to continue!";
	header("Location: {$base_url}login{$suffix}?url={$full_url}");
	exit();
}

$pageid = "checkout";
$pageResult = $db->view('*', 'rb_pages', 'pageid', "and title_id='$pageid'", '', '1');
if($pageResult['num_rows'] == 0)
{
	header("Location: {$base_url}error{$suffix}");
	exit();
}
$pageRow = $pageResult['result'][0];

$registerResult = $db->view("*", "rb_registrations", "regid", "and regid='{$regid}'");
$registerRow = $registerResult['result'][0];

$refno = $_SESSION['cart_refno'];

$cartResult = $db->view('*', 'rb_cart', 'cartid', "and regid = '$regid' and refno = '$refno' and status = 'active'", "cartid desc");

$purchasetempResult = $db->view('*', 'rb_purchases_temp', 'tempid', "and regid = '$regid' and refno = '$refno' and status = 'active'");
if($purchasetempResult['num_rows'] == 0)
{
	header("Location: {$base_url}cart{$suffix}");
	exit();
}
$purchasetempRow = $purchasetempResult['result'][0];

if($purchasetempRow['final_price'] == 0)
{
	header("Location: {$base_url}cart{$suffix}");
	exit();
}

$_SESSION['csrf_token'] = substr(sha1(rand(1, 99999)),0,32);
$csrf_token = $_SESSION['csrf_token'];

$coupon_success_msg_fe = "";
$coupon_error_msg_fe = "";
$coupon_code = "";
$coupon_discount = "";

$_SESSION['coupon_error_msg_fe'] = "";
$_SESSION['coupon_success_msg_fe'] = "";
$_SESSION['coupon_discount'] = "";
$_SESSION['coupon_code'] = "";

$price_detail = explode(",", $purchasetempRow['price_detail']);

$pincode = $_SESSION['pincode'];
$pincodeResult = $db->view('pincodeid,pincode', 'rb_pincodes', 'pincodeid', "and pincode = '$pincode' and status = 'active'");
if($pincodeResult['num_rows'] == 0)
{
	$_SESSION['error_msg_fe'] = "One of your selected product is maybe Out of Stock now!";
	header("Location: {$base_url}cart{$suffix}");
	exit();
}

// $walletResult = $db->view("SUM(amount) as total_wallet_amount", "mlm_ewallet", "regid", "and type='credit' and regid='{$regid}'");
// $walletRow = $walletResult['result'][0];
// $total_wallet_amount = $walletRow['total_wallet_amount'];

// $walletrequestsResult = $db->view("SUM(amount) as total_requests_amount", "mlm_ewallet_requests", "regid", "and status != 'declined' and regid='{$regid}'");
// $walletrequestsRow = $walletrequestsResult['result'][0];
// $total_requests_amount = $walletrequestsRow['total_requests_amount'];

$totalwalletResult = $db->view('wallet_total,wallet_money', 'mlm_registrations', 'regid', "and regid = '$regid' and status='active'");
$totalwalletRow = $totalwalletResult['result'][0];

$wallet_money = $totalwalletRow['wallet_money'];

if($wallet_money > $purchasetempRow['final_price'])
{
	$wallet_money = $purchasetempRow['final_price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php if($pageRow['meta_title'] != "") { ?>
<title><?php echo $validation->db_field_validate($pageRow['meta_title']); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($pageRow['meta_keywords']); ?>" />
<meta name="description" content="<?php echo $validation->db_field_validate($pageRow['meta_description']); ?>" />
<?php } else { ?>
<title><?php echo $validation->db_field_validate($pageRow['title'])." | "; include_once("inc_title.php"); ?></title>
<meta name="keywords" content="<?php echo $validation->db_field_validate($pageRow['title']); ?>" />
<?php } ?>
<?php include_once("inc_files.php"); ?>
</head>
<body>
<div id="preloder">
	<div class="loader"></div>
</div>
<?php include_once("inc_header.php"); ?>

<div class="breacrumb-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb-text">
					<a href="<?php echo BASE_URL; ?>"><i class="fa fa-home"></i> Home</a>
					<span><?php echo $validation->db_field_validate($pageRow['title']); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="checkout-section spad pt-0">
<div class="container-fluid">
<form class="checkout-form" id="checkout_form" action="<?php echo BASE_URL; ?>checkout_inter.php" method="post">
	<input type="hidden" name="token" value="<?php echo $csrf_token; ?>" />
	<input type="hidden" name="amount" id="amount" value="<?php echo $validation->db_field_validate($purchasetempRow['final_price']); ?>" />
	<input type="hidden" name="order_id" value="<?php echo $validation->db_field_validate($purchasetempRow['refno']); ?>"/>
	<input type="hidden" name="currency" value="INR"/>
	<input type="hidden" name="language" value="EN"/>
	<input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>" />
	<input type="hidden" name="wallet_money" id="wallet_money" value="0" />
	
	<div class="row">
		<div class="col-lg-12">
			<div class="blog-details-inner pb-4">
				<div class="blog-detail-title">
					<h2><?php echo $validation->db_field_validate($pageRow['title']); ?></h2>
					<h5><?php echo $validation->db_field_validate($pageRow['tagline']); ?></h5>
				</div>
			</div>
		</div>
	</div>
	<div class="row w-100">
		<div class="col-8 offset-2 w-100">
			<?php if($_SESSION['success_msg_fe'] != "") { ?>
				<div class="alert alert-success text-center mt-0 mb-4">
					<?php
					echo @$_SESSION['success_msg_fe'];
					@$_SESSION['success_msg_fe'] = "";
					?>
				</div>
			<?php } if($_SESSION['error_msg_fe'] != "") { ?>
				<div class="alert alert-danger text-center mt-0 mb-4">
					<?php
					echo @$_SESSION['error_msg_fe'];
					@$_SESSION['error_msg_fe'] = "";
					?>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="box">
				<!--<h4>Portal Details</h4>-->
				<div class="row">
					<div class="col-md-6">
						<label for="membership_id"><b>Your Referral ID *</b></label>
						<input name="membership_id" id="membership_id" type="text" value="<?php echo $validation->db_field_validate($registerRow['membership_id']); ?>" class="mb-0" <?php if($registerRow['membership_id'] != "") echo "readonly"; ?> required />
						<p style="display:none;" class="mt-1 mb-0 error_cls text-left"><font color="red">Please enter a valid Membership ID</font></p>
						<p style="display:none;" class="mt-1 mb-0 error_cls2 text-left"><font color="red">Please enter your own membership ID</font></p>
						<div style="color:green;" class="mt-1 mb-0 success_cls text-left"></div>
					</div>
					
					<!--<div class="col-md-6">
						<label for="sponsor_id">Referral ID *</label>
						<input name="sponsor_id" id="sponsor_id" type="text" value="<?php echo $validation->db_field_validate($registerRow['sponsor_id']); ?>"  class="mb-0" readonly required />
					</div>
					<div class="col-md-6 mt-2">
						Enter your membership ID (e.g. GM….) here.<br />If you have not filled the membership form yet, <a href="<?php echo BASE_URL.'mlm/register.php'; ?>" target="_blank" class="anchor-tag">click here</a>
					</div>-->
				</div>
				
				<input name="sponsor_id" id="sponsor_id" type="hidden" value="<?php echo $validation->db_field_validate($registerRow['sponsor_id']); ?>" />
				
				<h4 class="mt-4">Billing & Shipping Details</h4>
				<div class="row">
					<div class="col-md-6">
						<label for="billing_first_name">First Name *</label>
						<input name="billing_first_name" id="billing_first_name" type="text" value="<?php echo $validation->db_field_validate($registerRow['first_name']); ?>" required />
					</div>
					<div class="col-md-6">
						<label for="billing_last_name">Last Name</label>
						<input name="billing_last_name" id="billing_last_name" type="text" value="<?php echo $validation->db_field_validate($registerRow['last_name']); ?>" />
					</div>
					<div class="col-md-6">
						<label for="billing_mobile">Mobile No. *</label>
						<input name="billing_mobile" id="billing_mobile" type="text" value="<?php echo $validation->db_field_validate($registerRow['mobile']); ?>" required />
					</div>
					<div class="col-md-6">
						<label for="billing_mobile_alter">Mobile No. (Alternative)</label>
						<input name="billing_mobile_alter" id="billing_mobile_alter" type="text" value="<?php echo $validation->db_field_validate($registerRow['mobile_alter']); ?>" />
					</div>
					<div class="col-md-12">
						<label for="billing_address">Address *</label>
						<textarea class="form-control mb-2" name="billing_address" id="billing_address" required ><?php echo $validation->db_field_validate($registerRow['address']); ?></textarea>
					</div>
					<div class="col-md-12">
						<label for="billing_landmark">Landmark</label>
						<input name="billing_landmark" id="billing_landmark" type="text" value="<?php echo $validation->db_field_validate($registerRow['landmark']); ?>" />
					</div>
					<div class="col-md-6">
						<label for="billing_pincode">Pincode</label>
						<input name="billing_pincode" id="billing_pincode" type="number" class="mb-0" onBlur="fetch_pincode();" value="<?php echo $validation->db_field_validate($registerRow['pincode']); ?>" required />
						<span class="pincode_success" style="color:green;display:none;"><i class="fa fa-check"></i> Verified!</span>
						<span class="pincode_failure" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter a valid Pincode!</span>
					</div>
					<div class="col-md-6">
						<label for="billing_city">City *</label>
						<input name="billing_city" id="billing_city" type="text" value="<?php echo $validation->db_field_validate($registerRow['city']); ?>" required />
					</div>
					<div class="col-md-6">
						<label for="billing_state">State *</label>
						<input name="billing_state" id="billing_state" type="text" value="<?php echo $validation->db_field_validate($registerRow['state']); ?>" required />
					</div>
					<div class="col-md-6">
						<label for="billing_country">Country *</label>
						<input name="billing_country" id="billing_country" type="text" value="<?php echo $validation->db_field_validate($registerRow['country']); ?>" required />
					</div>
					<div class="col-md-12">
						<label for="note">Note</label>
						<textarea class="form-control mb-2" name="note" id="note"></textarea>
					</div>
					
					<!--<div class="col-md-12 mt-4">
						<h4 class="mb-4">Shipping Details</h4>
						
						<input type="checkbox" class="h-auto w-auto" name="shipping_box" id="shipping_box" onClick="shipping_details();" />&nbsp;
						<label for="shipping_box">Ship to a different address?</label>
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_first_name">First Name *</label>
						<input name="shipping_first_name" id="shipping_first_name" type="text" />
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_last_name">Last Name</label>
						<input name="shipping_last_name" id="shipping_last_name" type="text" />
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_mobile">Mobile No. *</label>
						<input name="shipping_mobile" id="shipping_mobile" type="text" />
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_mobile_alter">Mobile No. (Alternative)</label>
						<input name="shipping_mobile_alter" id="shipping_mobile_alter" type="text" />
					</div>
					<div class="col-md-12 shipping_row">
						<label for="shipping_address">Address *</label>
						<textarea class="form-control mb-2" name="shipping_address" id="shipping_address"></textarea>
					</div>
					<div class="col-md-12 shipping_row">
						<label for="shipping_landmark">Landmark</label>
						<input name="shipping_landmark" id="shipping_landmark" type="text" />
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_pincode">Pincode</label>
						<input name="shipping_pincode" id="shipping_pincode" type="number" onBlur="fetch_pincode2();" />
						<span class="pincode_success2" style="color:green;display:none;"><i class="fa fa-check"></i> Verified!</span>
						<span class="pincode_failure2" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter a valid Pincode!</span>
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_city">City *</label>
						<input name="shipping_city" id="shipping_city" type="text" />
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_state">State *</label>
						<input name="shipping_state" id="shipping_state" type="text" />
					</div>
					<div class="col-md-6 shipping_row">
						<label for="shipping_country">Country *</label>
						<input name="shipping_country" id="shipping_country" type="text" />
					</div>-->
					
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="box">
				<div class="place-order">
					<h4>Your Order</h4>
					<div class="order-total">
						<ul class="order-table">
							<li>Product <span>Total</span></li>
							<?php
							if($cartResult['num_rows'] >= 1)
							{
								$total_price = 0;
								$slr = 0;
								foreach($cartResult['result'] as $cartRow)
								{
									$productid = $cartRow['productid'];
									$productResult = $db->view("*", "rb_products", "productid", "and productid='{$productid}'");
									$productRow = $productResult['result'][0];
									
									$variantid = $cartRow['variantid'];
									$variantResult = $db->view('stock_quantity', 'rb_products_variants', 'variantid', "and productid = '$productid' and variantid='$variantid'", 'variantid asc');
									$variantRow = $variantResult['result'][0];
									$product_stock_quantity = $validation->db_field_validate($variantRow['stock_quantity']);
									
									if($cartRow['quantity'] > $product_stock_quantity)
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
							?>
								<li class="fw-normal"><?php echo $validation->getplaintext($productRow['title'], 20); ?> x <?php echo $validation->db_field_validate($cartRow['quantity']); ?> <span><?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($price_detail[$slr])); ?></span></li>
							<?php
									if($productRow['cod'] == "no")
									{
										$cod_available = $productRow['cod'];
									}
									$slr++;
								}
							}
							?>
							<li class="fw-normal">Subtotal <span><?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($purchasetempRow['total_price'])); ?></span></li>
							<?php if($purchasetempRow['coupon_code'] != "") { ?>
								<li class="fw-normal">Coupon Discount <span><?php echo "({$purchasetempRow['coupon_code']}) "; if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($purchasetempRow['coupon_discount'])); ?></span></li>
							<?php } ?>
							<?php if($purchasetempRow['shipping_total'] != "0") { ?>
								<li class="fw-normal">Shipping <span><?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($purchasetempRow['shipping_total'])); ?></span></li>
							<?php } ?>
							<?php if($purchasetempRow['taxamount_total'] != "0") { ?>
							<li class="fw-normal">Tax <span><?php echo $validation->db_field_validate($validation->price_format($purchasetempRow['taxamount_total'])); ?></span></li>
							<?php } ?>
							<li class="total-price">Total Price to Pay <span><?php if($productRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" aria-hidden="true"></i>'; else $validation->db_field_validate($productRow['currency_code']); ?>&nbsp;<span class="price_total"><?php echo $validation->price_format($purchasetempRow['final_price']); ?></span></span></li>
						</ul>
						<div class="payment-check">
							<?php if($wallet_money != "" and $wallet_money != "0") { ?>
								<div class="terms mt-3" onClick="return wallet('<?php echo $wallet_money; ?>');">
									<input type="checkbox" id="wallet_option" name="wallet_option" class="h-auto w-auto" />
									<label for="wallet_option">Use Wallet Money - <strong>&#8377;<?php echo $validation->price_format($wallet_money); ?></strong></label>
								</div>
							<?php } ?>
							<div class="radion_btn mt-1" onClick="return payment_mode_check('cod');">
								<input type="radio" id="payment_mode" name="payment_mode" onClick="return payment_mode_check('cod');" value="cod" <?php if($cod_available == "no") echo "disabled"; ?> class="h-auto w-auto payment_mode_cls" required />
								<label for="payment_mode" onClick="return payment_mode_check('cod');">COD (Cash On Delivery)</label>
								<?php if($cod_available == "no") { ?><p>Cash On Delivery is not available</p><?php } ?>
							</div>
							<div class="radion_btn online_area" onClick="return payment_mode_check('online');">
								<input type="radio" id="payment_mode2" name="payment_mode" onClick="return payment_mode_check('online');" class="h-auto w-auto payment_mode_cls align-top mt-1" value="online transfer" required />
								<label for="payment_mode2" class="align-top" onClick="return payment_mode_check('online');">
									Online Transfer
									<br />
									<img src="<?php echo BASE_URL.'images/payment-method.png'; ?>" class="img-responsive" />
								</label>
							</div>
							<div class="terms mt-3">
								<input type="checkbox" id="terms" name="terms" class="h-auto w-auto" required />
								<label for="terms">I’ve read and accept the </label>
								<a href="<?php echo BASE_URL.'page/terms-and-conditions/'; ?>" target="_blank" class="anchor-tag">terms & conditions</a> *
							</div>
						</div>
						<div class="order-btn">
							<button type="submit" name="proceed" id="proceed" class="site-btn place-btn">Place Order</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
</div>
</section>

<?php include_once("inc_footer.php"); ?>
<?php include_once("inc_files_bottom.php"); ?>
<script>
// $(document).ready(function(){
	// alert("Jquery is working!");
// });
function payment_mode_check(input)
{
	if (input == "cod")
	{
		$("#checkout_form").attr('action','<?php echo BASE_URL; ?>checkout_inter.php');
	}
	else if(input == "online")
	{
		$("#checkout_form").attr('action','<?php echo BASE_URL; ?>checkout_pay.php');
	}
}

function wallet(input)
{
	if ($('#wallet_option').is(':checked'))
	{
		$("#wallet_money").val(input);
		var price = parseInt("<?php echo $purchasetempRow['final_price']; ?>",10);
		var total_price = price-input;
		$(".price_total").html(total_price + ".00");
		$("#amount").val(total_price);
		
		if(total_price == '0')
		{
			$(".online_area").hide();
		}
		else
		{
			$(".online_area").show();
		}
	}
	else
	{
		$("#wallet_money").val("0");
		$(".price_total").html("<?php echo $purchasetempRow['final_price']; ?>");
		$("#amount").val("<?php echo $purchasetempRow['final_price']; ?>");
		$(".online_area").show();
	}
}

function fetch_member(field)
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>fetch_member.php',
		data:
		{
			membership_id: $("#"+field).val()
		},
		success: function (response)
		{
			if(response == "no")
			{
				$(".error_cls").show();
				$("#sponsor_id").val("");
				$("#sponsor_name").val("");
			}
			else
			{
				$("#sponsor_name").val(response);
				$(".error_cls").hide();
			}
		}
	});
}

function fetch_member(field)
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>fetch_member.php',
		data:
		{
			membership_id: $("#"+field).val(),
			mobile: <?php echo $_SESSION['mobile']; ?>
		},
		success: function (response)
		{
			if(response.substr(0, 8) == "usernono")
			{
				$(".error_cls").show();
				$("#sponsor_id").val("");
				$("#membership_id").val("");
				$(".success_cls").html('');
			}
			else if(response.substr(0, 6) == "userno")
			{
				$(".error_cls2").show();
				$("#sponsor_id").val("");
				$("#membership_id").val("");
				$(".success_cls").html('');
			}
			else if(response != "")
			{
				$(".success_cls").html('Verified!');
				$("#sponsor_id").val(response);
				$(".error_cls").hide();
				$(".error_cls2").hide();
			}
			else
			{
				$("#sponsor_id").val(response);
				$(".error_cls").hide();
				$(".error_cls2").hide();
				$(".success_cls").html('');
			}
		}
	});
}

function fetch_pincode()
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>fetch_pincode.php',
		data:
		{
			pincode: $("#billing_pincode").val()
		},
		success: function (response)
		{
			if(response == "no")
			{
				$(".pincode_failure").show();
				$(".pincode_success").hide();
				$("#proceed").prop('disabled', true);
			}
			else
			{
				var result = $.parseJSON(response);
				$("#billing_city").val(result[0]);
				$("#billing_state").val(result[1]);
				$("#billing_country").val(result[2]);
				$(".pincode_success").show();
				$(".pincode_failure").hide();
				$("#proceed").prop('disabled', false);
			}
		}
	});
}

function fetch_pincode2()
{
	$.ajax({
		type: 'post',
		url: '<?php echo BASE_URL; ?>fetch_pincode.php',
		data:
		{
			pincode: $("#shipping_pincode").val()
		},
		success: function (response)
		{
			if(response == "no")
			{
				$(".pincode_failure2").show();
				$(".pincode_success2").hide();
				$("#proceed").prop('disabled', true);
			}
			else
			{
				var result = $.parseJSON(response);
				$("#shipping_city").val(result[0]);
				$("#shipping_state").val(result[1]);
				$("#shipping_country").val(result[2]);
				$(".pincode_success2").show();
				$(".pincode_failure2").hide();
				$("#proceed").prop('disabled', false);
			}
		}
	});
}
</script>
</body>
</html>