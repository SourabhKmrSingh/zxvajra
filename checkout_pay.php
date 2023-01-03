<h3>Your Payment is being processed!</h3>
<a href="javascript:history.back();">Back</a>
<?php
include_once("inc_config.php");
include_once('razorpay/config.php');
include_once('razorpay/razorpay-php/Razorpay.php');

if($_SESSION['regid'] == "")
{
	$_SESSION['error_msg_fe'] = "Login to continue!";
	header("Location: {$base_url}login{$suffix}");
	exit();
}

$payment_mode = $validation->input_validate($_POST['payment_mode']);

if($payment_mode == "online transfer")
{
	if(isset($_POST['token']) && $_POST['token'] === $_SESSION['csrf_token'])
	{
		if(isset($_POST['proceed']))
		{
			$order_id = $validation->input_validate($_POST['order_id']);
			$amount = $validation->input_validate($_POST['amount']);
			$currency = $validation->input_validate($_POST['currency']);
			$email = $validation->input_validate($_POST['email']);
			
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

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//

$orderData = [
    'receipt'         => 'ORD'.$order_id,
    'amount'          => $amount * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';

// if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
// {
    // $checkout = $_GET['checkout'];
// }

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "Grocery Master",
    "description"       => "Raashan Mangao, Rupaya Kamao, Ghar Baithe",
    "image"             => BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($configRow['logo']),
    "prefill"           => [
    "name"              => $billing_first_name.' '.$billing_last_name,
    "email"             => $email,
    "contact"           => $billing_mobile,
    ],
    "notes"             => [
    "address"           => "",
    "merchant_order_id" => "ORD".$order_id,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

//require("razorpay/checkout/{$checkout}.php");
?>
<meta name="viewport" content="width=device-width" />
<script src="<?php echo BASE_URL; ?>assets/js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
	$('.razorpay-payment-button').trigger('click');
	$('.razorpay-payment-button').hide();
});
</script>
<form action="<?php echo BASE_URL; ?>checkout_inter.php" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key']?>"
    data-amount="<?php echo $data['amount']?>"
    data-currency="INR"
    data-name="<?php echo $data['name']?>"
    data-image="<?php echo $data['image']?>"
    data-description="<?php echo $data['description']?>"
    data-prefill.name="<?php echo $data['prefill']['name']?>"
    data-prefill.email="<?php echo $data['prefill']['email']?>"
    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
    data-notes.shopping_order_id=""
    data-order_id="<?php echo $data['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
  >
  </script>
  
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="membership_id" value="<?php echo $membership_id; ?>" />
  <input type="hidden" name="sponsor_id" value="<?php echo $sponsor_id; ?>" />
  <input type="hidden" name="billing_first_name" value="<?php echo $billing_first_name; ?>" />
  <input type="hidden" name="billing_last_name" value="<?php echo $billing_last_name; ?>" />
  <input type="hidden" name="billing_mobile" value="<?php echo $billing_mobile; ?>" />
  <input type="hidden" name="billing_mobile_alter" value="<?php echo $billing_mobile_alter; ?>" />
  <input type="hidden" name="billing_address" value="<?php echo $billing_address; ?>" />
  <input type="hidden" name="billing_landmark" value="<?php echo $billing_landmark; ?>" />
  <input type="hidden" name="billing_city" value="<?php echo $billing_city; ?>" />
  <input type="hidden" name="billing_state" value="<?php echo $billing_state; ?>" />
  <input type="hidden" name="billing_country" value="<?php echo $billing_country; ?>" />
  <input type="hidden" name="billing_pincode" value="<?php echo $billing_pincode; ?>" />
  <input type="hidden" name="shipping_box" value="<?php echo $shipping_box; ?>" />
  <input type="hidden" name="shipping_first_name" value="<?php echo $shipping_first_name; ?>" />
  <input type="hidden" name="shipping_last_name" value="<?php echo $shipping_last_name; ?>" />
  <input type="hidden" name="shipping_mobile" value="<?php echo $shipping_mobile; ?>" />
  <input type="hidden" name="shipping_mobile_alter" value="<?php echo $shipping_mobile_alter; ?>" />
  <input type="hidden" name="shipping_address" value="<?php echo $shipping_address; ?>" />
  <input type="hidden" name="shipping_landmark" value="<?php echo $shipping_landmark; ?>" />
  <input type="hidden" name="shipping_city" value="<?php echo $shipping_city; ?>" />
  <input type="hidden" name="shipping_state" value="<?php echo $shipping_state; ?>" />
  <input type="hidden" name="shipping_country" value="<?php echo $shipping_country; ?>" />
  <input type="hidden" name="shipping_pincode" value="<?php echo $shipping_pincode; ?>" />
  <input type="hidden" name="note" value="<?php echo $note; ?>" />
  <input type="hidden" name="payment_mode" value="<?php echo $payment_mode; ?>" />
  <input type="hidden" name="cart_refno" value="<?php echo $cart_refno; ?>" />
</form>