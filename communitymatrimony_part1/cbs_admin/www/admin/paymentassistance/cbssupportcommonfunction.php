<?php
#====================================================================================================
# Author   : Suresh
# Start Date :4/4/2011
# Description : cbssupport common function 
# file : cbssupportcommonfunction.php
#====================================================================================================
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/www/admin/includes/config.php');

function encrypt($string, $key) {
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
	$char = substr($string, $i, 1);
	$keychar = substr($key, ($i % strlen($key))-1, 1);
	$char = chr(ord($char)+ord($keychar));
	$result.=$char;
	}
	return base64_encode($result);
}

?>