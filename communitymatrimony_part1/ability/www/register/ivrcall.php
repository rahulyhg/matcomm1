<?php
/****************************************************************************************************
File  : ivrcall.php
Author  : ThavaPrakash
Date  : 04-Jun-2010
*****************************************************************************************************
Description : 
 This file executes the auto call.
********************************************************************************************************/
$iPhoneNumber = trim($_SERVER['argv'][1]);
$iCountry = trim($_SERVER['argv'][2]);
$iID = trim($_SERVER['argv'][3]);
$matriid = trim($_SERVER['argv'][4]);
$sPinNo = trim($_SERVER['argv'][5]);
if($iPhoneNumber!='' && $iCountry!='' && $iID!=''){
  ini_set('default_socket_timeout', 15);
  $sIvrUrl = file_get_contents("http://ivrs.bharatmatrimony.com/click2call.php?visitor=$iPhoneNumber&customer=9007&id=$iID&bu=16&duration=360000");
  $sIvrUrl = trim(strip_tags($sIvrUrl));
  $file_name = "/home/product/community/www/register/ivrlog".date('d-m-Y')."_pvivrscalllog.txt";
  $fp = fopen($file_name,"a");
  $file_content="$iID-$iPhoneNumber-9007-16-360000-IVRS-$sIvrUrl \n";
  @fwrite($fp, $file_content);
  if(strtolower(trim($sIvrUrl))!='y'){
    $sIvrUrl = file_get_contents("http://pv.bharatmatrimony.com/click2call.php?visitor=$iPhoneNumber&customer=9007&id=$iID&bu=16&duration=360000");
    $sIvrUrl = trim(strip_tags($sIvrUrl));
    $file_content="$iID-$iPhoneNumber-9007-16-360000-PV-$sIvrUrl \n";
    @fwrite($fp, $file_content);
  }
  fclose($fp);
}
echo $sIvrUrl;
?>