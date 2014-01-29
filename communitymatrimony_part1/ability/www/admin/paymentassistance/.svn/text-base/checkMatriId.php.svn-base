<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 08 Oct 2009
# End Date		: 20 Aug 2008
# Module		: Payment Assistance
#====================================================================================================

//BASE PATH
$varRootBasePath = '/home/product/community/ability';

//FILE INCLUDES
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/config.inc');
//include_once($varRootBasePath.'/conf/payment.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
//include_once($varRootBasePath.'/conf/domainlist.inc');
//include_once($varRootBasePath.'/conf/vars.inc');

/* Global Vars */
global $adminUserName;

$objSlave = new DB;
global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];
$objSlave -> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);

$uname      = $adminUserName;
$checkMatriIdCond = " WHERE MatriId = '".$_REQUEST[mtid]."'";
$matriid = mysql_real_escape_string($_REQUEST[mtid]);
$curdate = date("Y-m-d")." 00:00:00";
$checkMatriIdCond = "where ((EntryType='1' and PaymentDate='0000-00-00 00:00:00') or (EntryType='0' or EntryType='')) and MatriId='".$matriid."' and ((SupportUserName <> '$uname' and (FollowupStatus in (2,3,6,8,0) or (DateUpdated <= '$curdate' )) ) or (SupportUserName = '$uname' ))";

$checkNum = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$checkMatriIdCond);
if($objSlave -> clsErrorCode == "CNT_ERR")
	$returnValue = "Error";
else
	$returnValue = $checkNum;
echo $returnValue;
//$_REQUEST[mtid]
?>