<?php

ini_set('display_errors','on');
error_reporting(E_ALL ^ E_NOTICE);

	$curlUrl = "http://profile.bharatmatrimony.com/payments/getcurrencydetails.php";///tmiface/c/getDetails.php ?para=branchcontact
 	$ch = curl_init(); 
  	curl_setopt($ch, CURLOPT_URL, $curlUrl);  
	curl_setopt($ch, CURLOPT_HEADER, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
	$dd= curl_exec($ch);
	curl_close($ch);
echo "dd=";print_r($dd);

?>
