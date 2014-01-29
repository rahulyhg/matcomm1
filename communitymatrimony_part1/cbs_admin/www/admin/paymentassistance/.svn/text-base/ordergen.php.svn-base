<?php
/* **************************************************************************************************
FILENAME        :supporcheckstatus.php
AUTHOR			:A. Kirubasankar
PROJECT			:Payment Assistance
DESCRIPTION     :TO generate Order Id for IVR Payment
************************************************************************************************* */

//BASE PATH
//$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

//include_once("header.php");
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

$objMasterMatri		= new DB;
$objMasterMatri->dbConnect('M',$varDbInfo['DATABASE']);

$objDB = new DB;
$objDB->dbConnection($varDbIP['ODB4_offlinecbs'],$arrDBInfo["OfflineCbsUsername"],$arrDBInfo["OfflineCbsPassword"],$varOfflineCbsDbInfo['DATABASE']);

//$objDB->dbConnect('ODB4_offlinecbs',$varOfflineCbsDbInfo['DATABASE']);
$TABLE['GENERATEORDERIDS'] = "cm_generateorderids";

$maID=$_REQUEST['mid'];
$paymentCat=$_REQUEST['paycat'];
$countryCode=$_REQUEST['ccode'];
       
$countryarray=array("INR"=>"Rs","AED"=>"AED","USD"=>"USD","GBP"=>"GBP","EURO"=>"EUR");
$countryDisplay=$countryarray[$countryCode];

$argTblName = $varOfflineCbsDbInfo['DATABASE'].".".$TABLE['GENERATEORDERIDS'];
$argFields = array("Status");
$argFieldsValue = array("0");
$ord = $objDB->insert($argTblName,$argFields,$argFieldsValue);

//$ord = generateOrderId($objDB);

/*
$varOrderId	= microtime();
$ord=1;
$ord=substr($varOrderId,-5);
$tot=strlen($ord);
*/
if($ord != "" && $ord != "0"){
	$argFields = array("OrderId","MatriId","Product_Id","Payment_Mode","Display_Currency");
	$argValues = array($objMasterMatri->doEscapeString($ord,$objMasterMatri),$objMasterMatri->doEscapeString($maID,$objMasterMatri),$objMasterMatri->doEscapeString($paymentCat,$objMasterMatri),1,$objMasterMatri->doEscapeString($countryDisplay,$objMasterMatri));

	$objMasterMatri -> insert($varDbInfo['DATABASE'].".".$varTable['PREPAYMENTHISTORYINFO'],$argFields,$argValues);
	if($objMasterMatri -> clsErrorCode == "INSERT_ERR"){
		echo "Try again ...";
	}
	else{
		if(mysql_affected_rows() == 1) echo $ord;
		else echo "Try again ...";
	} 
}
else{
	echo "Try Again ...";
}

$objMasterMatri -> dbClose();
$objDB -> dbClose();


function generateOrderId($objDB){
	global $DBNAME, $TABLE, $varOfflineCbsDbInfo;
	$argTblName = $varOfflineCbsDbInfo['DATABASE'].".".$TABLE['GENERATEORDERIDS'];
	$argFields = array('Status');
	$argFieldsValue = array("'0'");
	$result = $objDB->insert($argTblName, $argFields, $argFieldsValue);
	return $result;
}
?>