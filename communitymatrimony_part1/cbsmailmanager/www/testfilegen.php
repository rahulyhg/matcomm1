<?php

error_reporting(0);

//FILE INCLUDES

include_once('/home/cbsmailmanager/bmlib/inputarguments.cil14');

$selectValue =$_REQUEST['id'];
$selCategory = $_REQUEST['category'];
$filepath = '/home/cbsmailmanager/mlistfiles/';
$recordvmm='';
$varTotal=1;

//print_r($varEmailId);

foreach( $varEmailId as $key => $value) {  //For testing Email ids 
	if( $varTotal&1) {
		$recordvmm.=$key.",".$value.",TestCBS,".$selectValue.",26,M,test,3,3,98,".date("Y-m-d H:i:s")."\n";
	} else {
		$recordvmm.=$key.",".$value.",TestCBS,".$selectValue.",26,F,test,3,3,102,".date("Y-m-d H:i:s")."\n";
	}	
}
$varTotal++;

$filename = $selCategory.'mail.txt';
	
//$file = fopen($filepath1.$filename,"w+");
if(!$file = fopen($filepath.$filename,"w+") ) {
	echo "File cannot able to open. check the File path \n";
	exit;
} else if (fwrite($file,$recordvmm) === FALSE) {
	echo "Cannot write to file ...\n";
	exit;
} 

echo "Test File successfully generated";

?>