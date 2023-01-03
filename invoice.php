<?php
include_once("inc_config.php");
include_once("be/classes/mpdf/mpdf.php");

$refno = $validation->urlstring_validate($_GET['ref']);
$purchaseResult = $db->view("*", "rb_purchases", "purchaseid", "and refno='{$refno}' and regid='{$regid}' and tracking_status='delivered' and status='active'", "purchaseid desc");
if($purchaseResult['num_rows'] == 0)
{
	header("Location: {$base_url}orders{$suffix}");
	exit();
}
$purchaseRow = $purchaseResult['result'][0];

$refno_custom = $validation->urlstring_validate($_GET['ref']);
$purchaseResult = $db->view("*", "rb_purchases", "purchaseid", "and refno_custom='{$refno_custom}' and regid='{$regid}' and tracking_status='delivered' and status='active'", "purchaseid desc", "1");
if($purchaseResult['num_rows'] == 0)
{
	$_SESSION['error_msg'] = "Error Occurred. Please try again!!!";
	header("Location: purchase_view.php");
	exit();
}
$purchaseRow = $purchaseResult['result'][0];

if($purchaseRow['product_currency_code'] == 'INR')
{
	$product_currency_code = '&#8377;';
}
else
{
	$product_currency_code = $validation->db_field_validate($purchaseRow['product_currency_code']);
}

$table = "";

$productPurchaseResult = $db->view("*", "rb_purchases", "purchaseid", "and refno_custom='{$refno_custom}' and status='active'", 'purchaseid desc');
if($productPurchaseResult['num_rows'] >= 1)
{
	$total_price = 0;
	$slr = 1;
	foreach($productPurchaseResult['result'] as $productPurchaseRow)
	{
		$table .= "<tr>";
		$table .= "<td valign='top' class='p-5'><p align='center'>{$slr}</p></td>";
		if($productPurchaseRow['product_variant'] != "")
		{
			$table .= "<td valign='top' class='p-5'>".$validation->db_field_validate($productPurchaseRow['product_title'])." (".$validation->db_field_validate($productPurchaseRow['product_variant']).")</td>";
		}
		else
		{
			$table .= "<td valign='top' class='p-5'>".$validation->db_field_validate($productPurchaseRow['product_title'])."</td>";
		}
		$table .= "<td valign='top' class='p-5' align='center'>".$validation->db_field_validate($productPurchaseRow['quantity'])."</td>";
		$table .= "<td valign='top' class='p-5'>".($productPurchaseRow['tax_information'] == 'included' ? $product_currency_code."".$validation->price_format($productPurchaseRow['price'] - $validation->calculate_discounted_price($productPurchaseRow['tax'], $productPurchaseRow['price'])) : $product_currency_code."".$validation->price_format($productPurchaseRow['price']))."</td>";
		$table .= "<td valign='top' class='p-5'>".$product_currency_code."".$validation->price_format($productPurchaseRow['coupon_discount'])."</td>";
		$table .= "<td valign='top' class='p-5'>".$product_currency_code."".$validation->price_format($productPurchaseRow['shipping'])."</td>";
		$table .= "<td valign='top' class='p-5'>".$validation->db_field_validate($productPurchaseRow['tax'])."%</td>";
		$table .= "<td valign='top' class='p-5'>".$validation->db_field_validate($productPurchaseRow['tax_type'])."</td>";
		$table .= "<td valign='top' class='p-5'>".($productPurchaseRow['tax_information'] == 'included' ? $product_currency_code."".$validation->price_format($validation->calculate_discounted_price($productPurchaseRow['tax'], $productPurchaseRow['price']+$productPurchaseRow['shipping']-$productPurchaseRow['coupon_discount'])) : $product_currency_code."".$validation->price_format($productPurchaseRow['taxamount']))."</td>";
		$table .= "<td valign='top' class='p-5'>".$product_currency_code."".$validation->db_field_validate($validation->price_format($productPurchaseRow['price']+$productPurchaseRow['shipping']-$productPurchaseRow['coupon_discount']+$productPurchaseRow['taxamount']))."</td>";
		$table .= "</tr>";
		
		$total_price += $productPurchaseRow['price'];
		$total_shipping += $productPurchaseRow['shipping'];
		$total_coupon_discount += $productPurchaseRow['coupon_discount'];
		$total_taxamount += $productPurchaseRow['taxamount'];
		
		$slr++;
	}
}

if($purchaseRow['invoicedate'] != "0000-00-00" and $purchaseRow['invoicedate'] != "")
{
	$invoicedate = "<strong>Invoice Date: </strong> ".$validation->db_field_validate($purchaseRow['invoicedate']).'<br />';
}

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tax Invoice/Bill - '.$validation->db_field_validate($purchaseRow['refno_custom']).'</title>
<style>
body
{
	font-size:12.5px;
}
.hind_text
{
	font-family: freeserif;
	font-weight:bold;
}
.footer
{
	position: absolute;
	bottom: 20px;
	text-align:center;
	width:100%;
	font-size:14px;
}
table
{
	width:100%;
}
table tr td table tr td
{
	padding:15px !important;
}
ol li
{
	font-size:14px;
}
.p-5
{
	padding:5px;
}
</style>
</head>
<body>

<div>
	<h4 align="center">Tax Invoice/Bill</h3>
	<br />
	<table>
		<tr>
			<td width="60%" align="left">
				<strong>Sold By: </strong>
				<br />
				Arihant Traders<br />
				1st Floor, 32/43, Street No. 9,<br />
				Bhikam Singh Colony, Vishwas Nagar,<br />
				Shahdara,<br />
				DELHI,<br />
				East Delhi,<br />
				110032
			</td>
			<td width="40%" align="right" valign="top">
				
			</td>
		</tr>
	</table>
	
	<br />
	
	<table>
		<tr>
			<td width="33.33%" align="left" valign="top">
				<strong>Order ID: </strong> '.$validation->db_field_validate($purchaseRow['refno_custom']).'
				<br />
				<strong>Order Date: </strong> '.$validation->db_field_validate($purchaseRow['createdate']).'
				<br />
				'.$invoicedate.'
				<strong>PAN: </strong> BNLPJ8556P
				<br />
				<strong>GST Registration No: </strong> 07BNLPJ8556P1Z1
			</td>
			<td width="33.33%" align="left" valign="top">
				<h5 style="font-size:13px;"><strong>Shipping Address</strong></h5>
				<br />
				'.$validation->db_field_validate($purchaseRow['shipping_first_name']." ".$purchaseRow['shipping_last_name']).'
				<br />
				'.$validation->db_field_validate($purchaseRow['shipping_mobile']).''.($purchaseRow['shipping_mobile_alter'] != "" ? ", ".$validation->db_field_validate($purchaseRow['shipping_mobile_alter']) : '').'
				<br />
				'.$validation->db_field_validate($purchaseRow['shipping_address']).',
				<br />
				'.($purchaseRow['shipping_landmark'] != "" ? $validation->db_field_validate($purchaseRow['shipping_landmark'])."<br />" : '').'
				'.$validation->db_field_validate($purchaseRow['shipping_city']).', '.$validation->db_field_validate($purchaseRow['shipping_state']).', '.$validation->db_field_validate($purchaseRow['shipping_pincode']).'
				<br />
				'.$validation->db_field_validate($purchaseRow['shipping_country']).'
			</td>
			<td width="33.33%" align="left" valign="top">
				<h5 style="font-size:13px;"><strong>Billing Address</strong></h5>
				<br />
				'.$validation->db_field_validate($purchaseRow['billing_first_name']." ".$purchaseRow['billing_last_name']).'
				<br />
				'.$validation->db_field_validate($purchaseRow['billing_mobile']).''.($purchaseRow['billing_mobile_alter'] != "" ? ", ".$validation->db_field_validate($purchaseRow['billing_mobile_alter']) : '').'
				<br />
				'.$validation->db_field_validate($purchaseRow['billing_address']).',
				<br />
				'.($purchaseRow['billing_landmark'] != "" ? $validation->db_field_validate($purchaseRow['billing_landmark'])."<br />" : '').'
				'.$validation->db_field_validate($purchaseRow['billing_city']).', '.$validation->db_field_validate($purchaseRow['billing_state']).', '.$validation->db_field_validate($purchaseRow['billing_pincode']).'
				<br />
				'.$validation->db_field_validate($purchaseRow['billing_country']).'
			</td>
		</tr>
	</table>
</div>

<br />

<table border="1" cellspacing="0" cellpadding="0">
	<tr>
		<td width="22" valign="top" class="p-5"><p><strong>Sl. No</strong></p></td>
		<td width="250" valign="top" class="p-5"><p><strong>Description</strong></p></td>
		<td width="23" valign="top" class="p-5"><p align="center"><strong>Qty</strong></p></td>
		<td width="55" valign="top" class="p-5"><p><strong>Net Amount</strong></p></td>
		<td width="54" valign="top" class="p-5"><p><strong>Discount</strong></p></td>
		<td width="54" valign="top" class="p-5"><p><strong>Shipping</strong></p></td>
		<td width="29" valign="top" class="p-5"><p><strong>Tax Rate</strong></p></td>
		<td width="29" valign="top" class="p-5"><p><strong>Tax Type</strong></p></td>
		<td width="49" valign="top" class="p-5"><p><strong>Tax Amount</strong></p></td>
		<td width="62" valign="top" class="p-5"><p><strong>Total Amount</strong></p></td>
	</tr>
	'.$table.'
	<tr>
		<td width="569" colspan="9" valign="top" class="p-5"><p><strong>TOTAL:</strong></p></td>
		<td width="62" valign="top" class="p-5"><p><strong>'.$product_currency_code.''.$validation->price_format($purchaseRow['final_price']).'</strong></p></td>
	</tr>
	<tr>
		<td width="681" colspan="10" valign="top" class="p-5">
			<p><strong>Amount in Words:</strong><br>
			<strong>'.$validation->AmountInWords($purchaseRow['final_price']).'</strong></p>
		</td>
	</tr>
	<tr>
	<td width="681" colspan="10" valign="top" align="right" class="p-5">
		<p align="right"><strong>For Grocery Master:</strong><br>
		<br>
		<strong>Authorized Signatory</strong></p></td>
	</tr>
</table>

<br />
<p style="font-size:13px;">Please note  that this invoice is not a demand for payment</p>

</body>
</html>
';

$mpdf = new mPDF('utf-8');

$mpdf->default_lineheight_correction = 1.2;
// LOAD a stylesheet
$stylesheet = file_get_contents('be/classes/mpdf/bootstrap_pdf.css');
$mpdf->WriteHTML($stylesheet,1);    // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->SetColumns(1,'J');
$mpdf->SetTitle('Invoice');
$mpdf->WriteHTML($html);

$mpdf->Output('invoice.pdf', 'I');
exit;
?>