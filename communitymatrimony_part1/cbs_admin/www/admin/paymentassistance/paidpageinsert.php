<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 08 Oct 2009
# End Date		: 20 Aug 2008
# Project		: Payment Assistance
# Module		: Admin  Index
#====================================================================================================

//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/config.cil14');

global $adminUserName;

//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new DB;
$objSlaveMatri = new DB;

//DB CONNECTION

$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);

global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];

$objSlave -> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
$objMaster -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);
$matriId = $_COOKIE['loginInfo'];


//$countries = array("91"=>"India","01"=>"USA","02"=>"UAE","04"=>"Australia","05"=>"Singapore","06"=>"Malaysia","07"=>"UK", "08"=>"Canada","03"=>"Others");
//$countriesCode = array("98"=>"India","222"=>"USA","220"=>"UAE","13"=>"Australia","189"=>"Singapore","129"=>"Malaysia","221"=>"UK", "39"=>"Canada","03"=>"Others");


$countryFields = array('Country');
$countryCondition = " WHERE matriId = '".$matriId."'";
$countryResult = $objSlaveMatri -> select($varTable['MEMBERINFO'],$countryFields,$countryCondition,0);
$countryRow = mysql_fetch_assoc($countryResult);
$country = $countryRow['Country'];
$countryCode1 = $countriesCode[$country];
$countries1 = array_flip($countries);
$countryCode = $countries1[$countryCode1];


$first3 = substr($matriId,0,3);
$arrMatriIdPre1 = array_flip($arrMatriIdPre);
$language = $arrMatriIdPre1[$first3];
$leadSourcetxt = 12;
$curdatetime = date("Y-m-d H:i:s");
//// Check matrimony if already exists in paymentoptions table.
$args = array('MatriId');
$argCondition = " WHERE MatriId = '".$matriId."'";
$checkNum = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition);
if($checkNum > 0)
{
	//// Update Query
	//$argFields = array('DateSelected','Country','PaymentVisit','LeadSource','QueueId','CallerId','SupportUserName','Language','CountryCode');
	//$argFieldsValues = array("'".$curdatetime."'","'".$country."'","PaymentVisit+1","'".$leadSourcetxt."'","'".$queueId."'","'".$callerId."'","'".$adminUserName."'","'".$language."'","'".$countryyycode."'");
	$argFields = array('DateSelected','Country','PaymentVisit','LeadSource','Language','CountryCode');
	$argFieldsValues = array("'".$curdatetime."'","'".$country."'","PaymentVisit+1","'".$leadSourcetxt."'","'".$language."'","'".$countryCode."'");
	$argCondition = " MatriId = '".$matriId."'";
	print_r($argFieldsValues);
	$objMaster -> update($varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition);
}
else
{
	//// Insert Query
	/*
	$argFields = array('MatriId','DateSelected','Country','PaymentVisit','LeadSource','QueueId','CallerId','SupportUserName','Language','CountryCode');
	$argFieldsValue = array("'".$matriId."'","'".$curdatetime."'","'".$country."'","'PaymentVisit+1'","'".$leadSourcetxt."'","'".$queueId."'","'".$callerId."'","'".$adminUserName."'","'".$language."'","'".$countryyycode."'");
	*/
	$argFields = array('MatriId','DateSelected','Country','PaymentVisit','LeadSource','Language','CountryCode');
	$argFieldsValue = array("'".$matriId."'","'".$curdatetime."'","'".$country."'","'PaymentVisit+1'","'".$leadSourcetxt."'","'".$adminUserName."'","'".$language."'","'".$countryCode."'");
	$objMaster -> insert($varTable['PAYMENTOPTIONS'], $argFields, $argFieldsValue);
}
?>