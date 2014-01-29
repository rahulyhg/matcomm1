<?php
#====================================================================================================
# Author   : Suresh
# Start Date : 3/23/2011
# Description : to check the tme pending epr in collection interface
#====================================================================================================
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/cbssupportcommonfunction.php');

if($adminUserName == "") 
	 header("Location: ../index.php?act=login");

if($adminUserName=="prabhur"){
	$encrypttelestatus=encrypt('3','3');//3=>manater
} else {
	$encrypttelestatus=encrypt('2','3');//2=>Executive
} 
$sdecryptTeleId=encrypt($adminUserName,'3');//3 is default value
$sdecryptEntryFrm=encrypt('11','3');//11=>"CommunitySupport

echo '<a href="http://wcc.matchintl.com/epr/pendingeprstatus.php?empId='.$sdecryptTeleId.'&entryFr='.$sdecryptEntryFrm.'&updatedfrom='.$encrypttelestatus.'" target="_blank">EPR Status</a>';
?>