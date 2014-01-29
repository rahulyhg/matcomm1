<?php
#====================================================================================================
# Author   : A.Kirubasankar
# Start Date : 08 Oct 2009
# End Date  : 20 Aug 2008
# Module  : Payment Assistance
#====================================================================================================
include_once ("/home/product/community/www/admin/paymentassistance/cbseasypayarrays.php");
$i=0;
foreach($autoSuggestArray as $value) {
$a[$i]=$value;
$i++;
} 
$q=$_GET["q"];
if (strlen($q) > 0) {
$ret="";
for($i=0; $i<count($a); $i++) {
if (strtolower($q)==strtolower(substr($a[$i],0,strlen($q)))) {
if ($ret=="") {
$ret="<a href=\"javascript:void(0);\" onClick=\"getname('".$a[$i]."');\" >".$a[$i]."</a>";
}
	  else  {
	 $ret=$ret."</br>"."<a href=\"javascript:void(0);\" onClick=\"getname('".$a[$i]."');\" >".$a[$i]."</a>";
	  }
	}
  }
}
if ($ret == "") {
$response=0;
}
else {
$response=$ret;
}
echo $response;
?>         