<?php
class api
{
	public function sendSMS($senderID='', $recipient_no, $message)
	{
		$content = array(
			'username' => 'ARIHANTOTP842265',
			'password' => '25264',
			'sender' => 'GROMAS',
			'to' => $recipient_no,
			'message' => $message,
			'priority' => 1,
			'dnd' => 1,
			'unicode' => 0
		);
		
		$apiUrl = "https://www.kit19.com/ComposeSMS.aspx?";
		foreach($content as $key => $val)
		{
			$apiUrl .= $key.'='.urlencode($val).'&';
		}
		$apiUrl = rtrim($apiUrl, "&");
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
}

$api = new api;
?>