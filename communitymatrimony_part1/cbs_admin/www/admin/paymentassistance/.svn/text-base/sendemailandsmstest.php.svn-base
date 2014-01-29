<?php

ini_set('display_errors','on');
error_reporting(E_ALL ^ E_NOTICE);

	//$curlUrl = "http://profile.bharatmatrimony.com/payments/getcurrencydetails.php?type=currecntyconvarray";///tmiface/c/getDetails.php ?para=branchcontact
	$curlUrl = "http://telemarketing.matchintl.com/tmiface/c/getdetails.php?p=c";//
 	$ch = curl_init(); 
  	curl_setopt($ch, CURLOPT_URL, $curlUrl);  
	curl_setopt($ch, CURLOPT_HEADER, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
echo	$dd= curl_exec($ch);
	curl_close($ch);

	$branchContactInfo2 = explode(":&npn&:",$dd);
	$branchContactInfo3 = $branchContactInfo2[1];
	$branchContactInfo = json_decode($branchContactInfo3,true);
print_r($branchContactInfo);


?>
