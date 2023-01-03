<?php

    $apiname = 'TransactionInquiry';
    $guid = 'GUID'.date('YmdHis');

    $params = [
        "CORPID"    =>  "ARIHANTT30122017",
        "USERID"    =>  "ARIHANTJ",
        "AGGRID"    =>  "OTOE0052",
        "URN"       =>  "SR192922492",
        "UNIQUEID" => '20201207140336'
    ];

    $source = json_encode($params);

    $fp=fopen("ICICI_PUBLIC_CERT_PROD.txt","r");
    $pub_key_string=fread($fp,8192);
    fclose($fp);
    openssl_get_publickey($pub_key_string);
    openssl_public_encrypt($source,$crypttext,$pub_key_string);
    
    $request = base64_encode($crypttext);

    $header = [
        'apikey:0786f0cb20cd4e42b3d169fb9e5a13be',
        'Content-type:text/plain'
    ];

    $httpUrl = 'https://apibankingone.icicibank.com/api/Corporate/CIB/v1/TransactionInquiry';


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
        CURLOPT_HTTPHEADER => $header
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
    
    file_put_contents($file, $log, FILE_APPEND | LOCK_EX);
    
    echo '<pre>';
    print_r(json_decode($newsource, TRUE));
    echo '</pre>';
?>