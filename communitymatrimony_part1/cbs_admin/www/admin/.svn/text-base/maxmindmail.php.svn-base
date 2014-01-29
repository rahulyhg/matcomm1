<?php
/*******************************************************************************************************************
File    : maxindmail.php
Author  : Baranidharan. S.
Date    : 30-Sept-2010
********************************************************************************************************/
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//file includes
include_once($varRootBasePath.'/www/admin/incldues/userLoginCheck.php');
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/lib/clsReport.php');
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARTION
$objReport	    = new Report;
$objMasterDB= new DB;

$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

$varMatriid = base64_decode($_REQUEST['matriId']);
$varOrderid = base64_decode($_REQUEST['orderId']);
$varCurrency = base64_decode($_REQUEST['currency']);
$varAmount = base64_decode($_REQUEST['amount']);

$argFrom = $varUcDomain." Matrimony";
$varDomain = $varDomain."matrimony.com";
$argFromEmailAddress  	= "info@$varDomain";
$argTo					= "Community Matrimony";

	$argToEmailAddress 		= "dhanapal@bharatmatrimony.com";
	$argSubject		   		= "Refund - Fraud Payment";
$argReplyToEmailAddress = $argFromEmailAddress;
$varMessage= "Dear Team <br><br>";
     $varMessage.="The following matriId made fraud payment. Kindly refund this OrderId.<br><br>"; 
     $varMessage.=" <b>Matriid : $varMatriid  <br>\n Order Id : $varOrderid <br>\n Amount : $varAmount ($varCurrency) </b><br><br>\n Community Matrimony Team</br>";
$varMailSend			= $objReport->sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$varMessage,$argReplyToEmailAddress);
if($varMailSend == 'yes') {
 echo "fraud id has been sent";
 $varFields = array('Status');
 $varFieldsValues = array(2);
 $varCondition		= "MatriId = ".$objMasterDB->doEscapeString($varMatriid,$objMasterDB);
 $varUpdateId	=$objMasterDB->update($varTable['MAXMINDPAYMENTCAPTURE'],$varFields,$varFieldsValues,$varCondition);
}
else {
 echo "fraud id has not been sent";
}
?>