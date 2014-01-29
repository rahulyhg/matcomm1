<?php
#=============================================================================================================
# Author 		: Senthilnathan
# Start Date	: 31 DEC 2009
# End Date		: 31 DEC 2009
# Project		: MatrimonyProduct
# Module		: Messages - Delete
#=============================================================================================================
//Base Path //
$varRootPath	 =$_SERVER['DOCUMENT_ROOT'];
$varRootBasePath = dirname($varRootPath);

// Include the files //
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once $varRootBasePath."/lib/clsDB.php";

//Variable Declaration
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$varDisplayMsg	= "";

// Object Declaration //
$objDb		= new DB();
$objDb->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varMsgIds		= $_POST["mids"];
$varMsgOpt		= $_POST["msgOpt"];
$varCurrentDate	= date('Y-m-d H:i:s');

$varProfIdField	= 'MatriId';
$varStatusField	= 'Status';
$varDelFields	= 'Status';

$arrStatus			= array();
$arrUpStatFields	= array(); 
$arrDelStatus		= array();

$arrMailStatus		= array(0=>'Unread', 1=>'Read', 2=>'Replied', 3=>'Declined');
$arrIntStatus		= array(0=>'Pending', 1=>'Accepted', 3=>'Declined');
$arrReqStatus		= array(1=>'Photo', 3=>'Phone', 5=>'Horoscope');

$arrDelRecMailStatus	= array(0=>4, 1=>5, 2=>6, 3=>7);
$arrDelRecIntStatus		= array(0=>4, 1=>6, 3=>7);
$arrDelSentMailStatus	= array(0=>5, 1=>5, 2=>5, 3=>5);
$arrDelSentIntStatus	= array(0=>5, 1=>5, 3=>5);
$arrDelReqStatus		= array(0=>1);


switch($varMsgOpt){
	case 'RM':
		$varTableName	= $varTable['MAILRECEIVEDINFO'];
		$varPrimayKey	= 'Mail_Id';
		$arrStatus		= $arrMailStatus;
		$arrDelStatus	= $arrDelRecMailStatus;
		$arrUpStatFields= array(0=>'Mail_UnRead_Received', 1=>'Mail_Read_Received', 2=>'Mail_Replied_Received', 3=>'Mail_Declined_Received');
		break;
	case 'RI':
		$varTableName	= $varTable['INTERESTRECEIVEDINFO'];
		$varPrimayKey	= 'Interest_Id';
		$arrStatus		= $arrIntStatus;
		$arrDelStatus	= $arrDelRecIntStatus;
		$arrUpStatFields= array(0=>'Interest_Pending_Received', 1=>'Interest_Accept_Received', 3=>'Interest_Declined_Received');
		break;
	case 'RR':
		$varTableName	= $varTable['REQUESTINFORECEIVED'];
		$varPrimayKey	= 'RequestId';
		$varProfIdField = 'ReceiverId';
		$varStatusField = 'RequestFor';
		$varDelFields	= 'Delete_Status';
		$arrStatus		= array(0=>'Req');
		$arrDelStatus	= $arrDelReqStatus;
		break;
	case 'SM':
		$varTableName	= $varTable['MAILSENTINFO'];
		$varPrimayKey	= 'Mail_Id';
		$arrStatus		= $arrMailStatus;
		$arrDelStatus	= $arrDelSentMailStatus;
		$arrUpStatFields= array(0=>'Mail_UnRead_Sent', 1=>'Mail_Read_Sent', 2=>'Mail_Replied_Sent', 3=>'Mail_Declined_Sent');
		break;
	case 'SI':
		$varTableName	= $varTable['INTERESTSENTINFO'];
		$varPrimayKey	= 'Interest_Id';
		$arrStatus		= $arrIntStatus;
		$arrDelStatus	= $arrDelSentIntStatus;
		$arrUpStatFields= array(0=>'Interest_Pending_Sent', 1=>'Interest_Accept_Sent', 3=>'Interest_Declined_Sent');
		break;
	case 'SR':
		$varTableName	= $varTable['REQUESTINFOSENT'];
		$varPrimayKey	= 'RequestId';
		$varProfIdField = 'SenderId';
		$varStatusField = 'RequestFor';
		$varDelFields	= 'Delete_Status';
		$arrStatus		= array(0=>'Req');
		$arrDelStatus	= $arrDelReqStatus;
		break;
}

$varFields		= array($varPrimayKey, $varStatusField);
$varWhereCond	= 'WHERE '.$varPrimayKey.' IN('.$varMsgIds.') AND '.$varProfIdField."=".$objDb->doEscapeString($sessMatriId,$objDb);
$varMsgIdsRes	= $objDb->select($varTableName,$varFields,$varWhereCond,0);

if($varMsgOpt{1} == 'M'){
	$arrUnread	= array();
	$arrRead	= array();
	$arrReplied	= array();
	$arrDeclined= array();
	$varMsgTxt	= 'Message';
	while($row = mysql_fetch_assoc($varMsgIdsRes)){
		if($row[$varStatusField] == 0)
			$arrUnread[]	= $row[$varPrimayKey];
		else if($row[$varStatusField] == 1)
			$arrRead[]		= $row[$varPrimayKey];
		else if($row[$varStatusField] == 2)
			$arrReplied[]	= $row[$varPrimayKey];
		else if($row[$varStatusField] == 3)
			$arrDeclined[]	= $row[$varPrimayKey];
	}
}else if($varMsgOpt{1} == 'I'){
	$arrPending	= array();
	$arrAccepted= array();
	$arrDeclined= array();
	$varMsgTxt	= 'Interest';
	while($row = mysql_fetch_assoc($varMsgIdsRes)){
		if($row[$varStatusField] == 0)
			$arrPending[]	= $row[$varPrimayKey];
		else if($row[$varStatusField] == 1)
			$arrAccepted[]	= $row[$varPrimayKey];
		else if($row[$varStatusField] == 3)
			$arrDeclined[]	= $row[$varPrimayKey];
	}
}else if($varMsgOpt{1} == 'R'){
	$varMsgTxt	= 'Request';
	while($row = mysql_fetch_assoc($varMsgIdsRes)){
		$arrReq[] = $row[$varPrimayKey];
	}
}

$arrStatFields		= array();
$arrStatFieldsVal	= array();
$varStatInfo		= '';

foreach($arrStatus as $varKey=>$varVal){
	$varStringVal	= 'arr'.$varVal;
	$arrCurrentVal	= $$varStringVal;
	if(count($arrCurrentVal)>0){
		$arrFields		= array($varDelFields);
		$arrFieldsVal	= array($arrDelStatus[$varKey]);
		$varUpdateCond	= $varPrimayKey.' IN('.join(',', $arrCurrentVal).') AND '.$varProfIdField."=".$objDb->doEscapeString($sessMatriId,$objDb);
		$varAffectedRows= $objDb->update($varTableName, $arrFields, $arrFieldsVal, $varUpdateCond);
		
		if($varAffectedRows!='' && $varAffectedRows>0 && ($varMsgOpt{1} == 'M' || $varMsgOpt{1} == 'I')){
			//MESSAGE & INTEREST COUNT RESET - (COOKIE & DB)
			if(!is_array($varStatInfo)){
			$varWhereCond	= "WHERE MatriId=".$objDb->doEscapeString($sessMatriId,$objDb);
			$argFields		= array('Interest_Pending_Received','Interest_Accept_Received','Interest_Declined_Received','Interest_Pending_Sent','Interest_Accept_Sent', 'Interest_Declined_Sent','Mail_Read_Received','Mail_UnRead_Received','Mail_Replied_Received','Mail_Declined_Received','Mail_Read_Sent','Mail_UnRead_Sent','Mail_Replied_Sent','Mail_Declined_Sent');
			$varStatRes		= $objDb->select($varTable['MEMBERSTATISTICS'], $argFields, $varWhereCond, 0);
			$varStatInfo	= mysql_fetch_assoc($varStatRes);
			}

			$varUpdateCnt		= ($varStatInfo[$arrUpStatFields[$varKey]]-$varAffectedRows);
			$varUpdateCnt		= ($varUpdateCnt > 0) ? $varUpdateCnt : 0;
			$arrStatFields[]	= $arrUpStatFields[$varKey];
			$arrStatFieldsVal[] = $varUpdateCnt;

			$varStatInfo[$arrUpStatFields[$varKey]] = $varUpdateCnt;
		}
	}
}

if(count($arrStatFields)!=0 && count($arrStatFields)==count($arrStatFieldsVal)){
			
	$varStatUpdateCond	= "MatriId=".$objDb->doEscapeString($sessMatriId,$objDb);
	$varStaAffectedRows	= $objDb->update($varTable['MEMBERSTATISTICS'], $arrStatFields, $arrStatFieldsVal, $varStatUpdateCond);
	
	$varMessagesInfo	= $varStatInfo['Mail_UnRead_Received'].'^|'.$varStatInfo['Mail_Read_Received'].'^|'.$varStatInfo['Mail_Replied_Received'].'^|'.$varStatInfo['Mail_Declined_Received'].'^|'.$varStatInfo['Mail_UnRead_Sent'].'^|'.$varStatInfo['Mail_Read_Sent'].'^|'.$varStatInfo['Mail_Replied_Sent'].'^|'.$varStatInfo['Mail_Declined_Sent'].'^|'.$varStatInfo['Interest_Pending_Received'].'^|'.$varStatInfo['Interest_Accept_Received'].'^|'.$varStatInfo['Interest_Declined_Received'].'^|'.$varStatInfo['Interest_Pending_Sent'].'^|'.$varStatInfo['Interest_Accept_Sent'].'^|'.$varStatInfo['Interest_Declined_Sent'].'^|0';

	setrawcookie("messagesInfo",$varMessagesInfo, "0", "/",$confValues['DOMAINNAME']);
}
print '<div style="width: 440px;" class="fleft tlcenter">'.$varMsgTxt.' has been successfully deleted from this folder.</div><div class="fright tlright"><img onclick="emptyDiv(\'deldiv\')" class="pntr" src="'.$confValues['IMGSURL'].'/close.gif"/></div>';

//UNSET OBJECT
$objDb->dbClose();
?>