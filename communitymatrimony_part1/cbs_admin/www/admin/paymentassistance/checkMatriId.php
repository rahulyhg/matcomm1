<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 08 Oct 2009
# End Date		: 20 Aug 2008
# Module		: Payment Assistance
#====================================================================================================

//BASE PATH
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
//include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
//include_once($varRootBasePath.'/conf/domainlist.cil14');
//include_once($varRootBasePath.'/conf/vars.cil14');

/* Global Vars */
global $adminUserName;

$objSlave = new DB;
global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];
$objSlave -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);

$uname      = $adminUserName;
$checkMatriIdCond = " WHERE MatriId = ".$objSlave->doEscapeString($_REQUEST['mtid'],$objSlave)."";
//$matriid = mysql_real_escape_string($_REQUEST[mtid]);
$curdate = date("Y-m-d")." 00:00:00";
if($uname != "prabhur" and $uname != "Assistance")
	$checkMatriIdCond = "where ((EntryType='1' and PaymentDate='0000-00-00 00:00:00') or (EntryType='0' or EntryType='')) and MatriId=".$objSlave->doEscapeString($_REQUEST['mtid'],$objSlave)." and ((SupportUserName <> ".$objSlave->doEscapeString($uname,$objSlave)."  and (FollowupStatus in (2,3,6,8,0) or (DateUpdated <= '$curdate' )) ) or (SupportUserName = ".$objSlave->doEscapeString($uname,$objSlave)." ))";
else
	$checkMatriIdCond = " where MatriId=".$objSlave->doEscapeString($matriid,$objSlave)." and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or EntryType=0)";

$checkNum = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$checkMatriIdCond);

if($objSlave -> clsErrorCode == "CNT_ERR")
	$returnValue = "Error";
else
	$returnValue = $checkNum;
echo $returnValue;
//$_REQUEST[mtid]

$objSlave->dbClose();
?>