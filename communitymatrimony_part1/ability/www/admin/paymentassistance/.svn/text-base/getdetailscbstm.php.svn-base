<?php
###########################################################################################################
#FileName		: getdetailscbstm.php	
#Created		: On:2010-Jan-03
#Author			: A.Kirubasankar
#Description	: this file used to pass values from CBS server to CBSTM server.
###########################################################################################################

//BASE PATH
$varRootBasePath = '/home/product/community/ability';

if($_REQUEST[para] == "payment")
{
	include($varRootBasePath."/conf/payment.inc");
	echo "<br>:&npn&:";
	$var = json_encode($arrPrdPackages);
}
print($var);
?>