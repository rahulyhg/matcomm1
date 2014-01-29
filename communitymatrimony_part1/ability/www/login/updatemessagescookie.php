<?php

//FILE INCLUDES
$varRootBasePath = '/home/product/community/ability';
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//If login information is available or not
if($sessMatriId == '') {
	include_once($varRootBasePath."/conf/cookieconfig.cil14");
	$sessMatriId	= $varGetCookieInfo["MATRIID"];
}

//OBJECT DECLARTION
$objUpdateMasterDB	= new DB;

//DB CONNECTION
$objUpdateMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

$argCondition	= " WHERE MatriId=".$objUpdateMasterDB->doEscapeString($sessMatriId,$objUpdateMasterDB);
$varNoOfRecord	= $objUpdateMasterDB->numOfRecords($varTable['MEMBERSTATISTICS'], 'MatriId', $argCondition);

if ($varNoOfRecord==1) {

	//FOR MESSAGES AND INTEREST
	$argFields		= array('Interest_Pending_Received','Interest_Accept_Received','Interest_Declined_Received','Interest_Pending_Sent','Interest_Accept_Sent', 'Interest_Declined_Sent','Mail_Read_Received','Mail_UnRead_Received','Mail_Replied_Received','Mail_Declined_Received','Mail_Read_Sent','Mail_UnRead_Sent','Mail_Replied_Sent','Mail_Declined_Sent');
	$varExecute		= $objUpdateMasterDB->select($varTable['MEMBERSTATISTICS'], $argFields, $argCondition,0);
	$varStatInfo	= mysql_fetch_assoc($varExecute);

	$varTotalRequest	= 0;
	$varMessagesInfo	= $varStatInfo['Mail_UnRead_Received'].'^|'.$varStatInfo['Mail_Read_Received'].'^|'.$varStatInfo['Mail_Replied_Received'].'^|'.$varStatInfo['Mail_Declined_Received'].'^|'.$varStatInfo['Mail_UnRead_Sent'].'^|'.$varStatInfo['Mail_Read_Sent'].'^|'.$varStatInfo['Mail_Replied_Sent'].'^|'.$varStatInfo['Mail_Declined_Sent'].'^|'.$varStatInfo['Interest_Pending_Received'].'^|'.$varStatInfo['Interest_Accept_Received'].'^|'.$varStatInfo['Interest_Declined_Received'].'^|'.$varStatInfo['Interest_Pending_Sent'].'^|'.$varStatInfo['Interest_Accept_Sent'].'^|'.$varStatInfo['Interest_Declined_Sent'].'^|'.$varTotalRequest;


} else {

	$argFields		= array('MatriId');
	$argFieldsValue	= array($objUpdateMasterDB->doEscapeString($sessMatriId,$objUpdateMasterDB));
	$objUpdateMasterDB->insert($varTable['MEMBERSTATISTICS'], $argFields, $argFieldsValue);
	$varMessagesInfo	= '0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0';
}//else
setrawcookie("messagesInfo",$varMessagesInfo, "0", "/",$confValues['DOMAINNAME']);

//$objUpdateMasterDB->dbClose();
//UNSET($objUpdateMasterDB);
?>