<?php
include_once("../inc_config.php");
include_once("../login_user_check.php");

@$requestid = $validation->input_validate($_GET['id']);
$requestResult = $db->view('*', 'mlm_ewallet_requests', 'requestid', "and requestid = '$requestid'");
$requestRow = $requestResult['result'][0];

if($requestRow['status'] != "pending")
{
	$_SESSION['error_msg'] = "Please select a valid Request and Try Again!";
	header("Location: ../ewallet_request_view.php");
	exit();
}

$bank_name = strtolower($requestRow['bank_name']);
$account_number = $requestRow['account_number'];
$ifsc_code = $requestRow['ifsc_code'];
$account_name = $requestRow['account_name'];
$amount = $requestRow['amount'];
$regid = $requestRow['regid'];
$name = $requestRow['account_name'];
$status = 'fulfilled';

// $registerQueryResult = $db->view('*', 'mlm_registrations', 'regid', "and regid = '$regid'");
// $registerRow = $registerQueryResult['result'][0];
// $name = $registerRow['first_name'].' '.$registerRow['last_name'];

if($bank_name == "" || $account_number == "" || $ifsc_code == "" || $account_name == "" || $amount == "0")
{
	$_SESSION['error_msg'] = "There is a problem. Please Try Again!";
	header("Location: ../ewallet_request_view.php");
	exit();
}

if($bank_name == "icici" || $bank_name == "icici bank" || $bank_name == "icicibank")
{
	$txntype = "TPA";
}
else
{
	$txntype = "IFS";
}

$apiname = 'Transaction';
$guid = 'GUID'.date('YmdHis');

$params = [
	"CORPID"    =>  "ARIHANTT30122017",
	"USERID"    =>  "ARIHANTJ",
	"AGGRNAME"  =>  "ARIHANT",
	"AGGRID"    =>  "OTOE0052",
	"URN"       =>  "SR192922492",
	"DEBITACC"  =>  "349005000264",
	"CREDITACC" =>  $account_number,
	"IFSC"      =>  $ifsc_code,
	"AMOUNT"    =>  $amount,
	"CURRENCY"  =>  "INR",
	"TXNTYPE"   =>  $txntype,  // TPA or IFS
	"PAYEENAME" =>  $name,
	"REMARKS"   =>  "production",
	"UNIQUEID"  =>  date('YmdHis'),
];

$source = json_encode($params);
print_r($source);
$fp=fopen("ICICI_PUBLIC_CERT_PROD.txt","r");
$pub_key_string=fread($fp,8192);
fclose($fp);
openssl_get_publickey($pub_key_string);
openssl_public_encrypt($source,$crypttext,$pub_key_string);

$request = base64_encode($crypttext);
//print_r($request);
$header = [
"Content-type: text/plain",
"apikey:0786f0cb20cd4e42b3d169fb9e5a13be"
];
//print_r($header);
$httpUrl = 'https://apibankingone.icicibank.com/api/Corporate/CIB/v1/Transaction';

//print_r($httpUrl);
$file = 'logs/'.$apiname.'.txt';

$log = "\n\n".'GUID - '.$guid."================================================================\n";
$log .= 'URL - '.$httpUrl."\n\n";
$log .= 'HEADER - '.json_encode($header)."\n\n";
$log .= 'REQUEST - '.json_encode($params)."\n\n";
$log .= 'REQUEST ENCRYPTED - '.json_encode($request)."\n\n";

file_put_contents($file, $log, FILE_APPEND | LOCK_EX);


$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_PORT => "8443",
	CURLOPT_URL => $httpUrl,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 60,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => $request,
	CURLOPT_HTTPHEADER => $header,
));

$response = curl_exec($curl);

$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

$fp= fopen("arihant_priv.pem","r");
$priv_key=fread($fp,8192);
fclose($fp);
$res = openssl_get_privatekey($priv_key, "");

openssl_private_decrypt(base64_decode($response), $newsource, $res);

$log = "\n\n".'GUID - '.$guid."================================================================ \n";
$log .= 'URL - '.$httpUrl."\n\n";
$log .= 'RESPONSE - '.json_encode($response)."\n\n";
$log .= 'REQUEST DECRYPTED - '.$newsource."\n\n";
//echo $log;
file_put_contents($file, $log, FILE_APPEND | LOCK_EX);

echo '<pre>';
print_r(json_decode($newsource, TRUE));
echo '</pre>';

$output = json_decode($newsource, TRUE);
$output_response = strtolower($output['RESPONSE']);		// failure or success
//run the code

if($output_response == "success")
{
	$fields = array('status'=>$status);
	$ewalletrequestResult = $db->update("mlm_ewallet_requests", $fields, array('requestid'=>$requestid));
	if(!$ewalletrequestResult)
	{
		echo mysqli_error($connect);
		exit();
	}
	
	$_SESSION['success_msg'] = "Amount Initiated Successfully!";
	header("Location: ../ewallet_request_view.php");
	exit();
}
else
{
	$_SESSION['error_msg'] = "There is a problem with this Transaction. Please Try Again or Consult Administrator!";
	header("Location: ../ewallet_request_view.php");
	exit();
}
?>