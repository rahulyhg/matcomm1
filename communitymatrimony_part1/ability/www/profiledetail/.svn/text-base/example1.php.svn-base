<?php
$url = "http://192.168.2.200/twitterv2/";
$postValues = array("action"=>"settwitteraccountid", "matriid" => "AGR102299", "twitterid" => "testTwitterAccount");
$con = curl_init($url);
curl_setopt ($con, CURLOPT_POST, true);
curl_setopt ($con, CURLOPT_POSTFIELDS, $postValues);
$response = curl_exec($con);
curl_close($con);

echo $response;
echo "Updated Successfully..";
?> 