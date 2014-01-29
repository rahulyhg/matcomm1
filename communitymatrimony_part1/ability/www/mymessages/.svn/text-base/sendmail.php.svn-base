<?php
//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDED FILES
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once $varRootBasePath."/conf/dbinfo.cil14";
include_once $varRootBasePath."/lib/clsMessage.php";


//VARIABLE DECLERATION
$varMessageId	= $_REQUEST['msgid'];
$varCurrPgNo	= $_GET['currrec'];
$varJSClearFun	= ($_GET['type']=='mul') ? 'mulClearTextArea()' : 'clearTextArea()';

$varCurrentDate = date('Y-m-d H:i:s');
$varErrorMsg	= '';

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo['PAIDSTATUS'];
$sessPublish	= $varGetCookieInfo['PUBLISH'];

//OBJECT DECLARTION
$objMessage		= new Message;
$objMessage->dbConnect('M', $varDbInfo['DATABASE']);

if($sessMatriId!='' && $sessPublish==1){
	if($varMessageId !=''){
		$varMsgRecCond		= ' WHERE Mail_Id='.$objMessage->doEscapeString($varMessageId,$objMessage);
		$varMsgRecFields	= array('Opposite_MatriId','Mail_Message','Status','Delete_Status');
		$varMsgInfo			= $objMessage->select($varTable['MAILRECEIVEDINFO'],$varMsgRecFields,$varMsgRecCond,1);
		$varPrevStatus		= $varMsgInfo[0]['Status'];
		$varPrevMessage		= stripslashes($varMsgInfo[0]['Mail_Message']);
		$varOppMatriId		= $varMsgInfo[0]['Opposite_MatriId'];
		$varSenderDelStatus	= $varMsgInfo[0]['Delete_Status'];

		if($varOppMatriId != ''){
			
			if($varPrevStatus == 0){
				include_once $varRootBasePath."/www/mymessages/msgstatus.php";
			}

			$varMsgTxt = "Type Message Here..\n ----- Original Message ----- \nFrom: ". 
			$varOppMatriId."\nTo: ". $sessMatriId."\n\n".strip_tags(preg_replace("/<BR>/", "\n",$varPrevMessage));
		}else{
			$varErrorMsg	= 'Previous Message is not available';
		}
	}else{
		$varTimeIntervalAllowed	= $confValues['TIMEINTERVALALLOWED'];
		$varMsgLimit			= $confValues['MESSAGESENTCOUNT'];

		$varWhereCond		= " WHERE MatriId=".$objMessage->doEscapeString($varSessionId,$objMessage);
		$varMsgTrkFields	= array('Total_Count','First_Time','(UNIX_TIMESTAMP(NOW())-First_Time)');
		$varMsgTrkInfo		= $objMessage->select($varTable['MAILSENTTRACKINFO'],$varMsgTrkFields,$varWhereCond,1);

		$varMsgTrkCnt		= count($varMsgTrkInfo);
		$varTimediff		= $varMsgTrkInfo[0]['(UNIX_TIMESTAMP(NOW())-First_Time)'];

		if($varMsgTrkCnt == 1 && $varTimediff < $varTimeIntervalAllowed && $varMsgTrkInfo[0]['Total_Count'] >= $varMsgLimit) {
		$varTimeDiffNew		= $varTimeIntervalAllowed-$varTimediff;
		$varTotalHrs		= $varTimeDiffNew/3600;
		$varTotalMins		= $varTimeDiffNew%3600;
		$varTotalMins		= $varTotalMins/60;
		$varTotalSecs		= $varTotalMins%60;
		$varTotalHrs		= sprintf("%2d",$varTotalHrs);	
		$varTotalMins		= sprintf("%2d",$varTotalMins);
		$varTotalSecs		= sprintf("%2d",$varTotalSecs);
		$varTimeSlot		= "$varTotalHrs hour(s) $varTotalMins minute(s) $varTotalSecs second(s)";
		$varErrorMsg		= "You have Sent Messages to more profiles than permissible in the last ".($varTimeIntervalAllowed/3600)."	hours. Please continue sending Messages after ".$varTimeSlot.". Sorry for the inconvenience.";
		}else{ $varMsgTxt	= 'Type Message Here..';}
	}
}else{
	
	switch ($sessPublish){
		case 0:	$varErrorMsg	= "Currently your profile is not authorized. To send message, your profile must be validated.";break;

		case 2:	$varErrorMsg	= "Currently your profile is hidden. To send message, you must unhide your profile.";break;

		case 3:	$varErrorMsg	= "Sorry, you will not be able to send message as your profile is currently suspended. Please contact <font class='clr1'>".$confValues['HELPEMAIL']."</font>";break;

		case 4: $varErrorMsg	= "Sorry, you will not be able to send message as your profile is currently rejected. Please contact <font class='clr1'>".$confValues['HELPEMAIL']."</font>";break;
	}

	if($sessMatriId == '')
		$varErrorMsg	= "Session is expired. Kindly login again.";
}
?>
<html>
<head>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/msgcompose.css">
<style>
body {
	background: #D2EDF4;
	margin: 0px;
	padding: 0px;
}
</style>
</head>
<body>
<div style="width:225px;">
	<form name="contactform" method="post" style="margin:0px;padding:0px">
	<div id="errdiv" class="errortxt"></div>
	<div class="smalltxt" id="richedit" style="padding-left:1px;width:100%;">
	<?
		if($varErrorMsg == ''){
			echo '<textarea rows="2" border="0" cols="5" id="msgtxtarea'.$varCurrPgNo.'" name="msgtxtarea'.$varCurrPgNo.'" onclick="parent.'.$varJSClearFun.';" style="width:220px;height:130px;">'.$varMsgTxt.'</textarea>';
		}else{ 
			echo $varErrorMsg;
		} 
	?>
	</div>
	<input type="hidden" name="Format" id="Format" value="html">
	<input type="hidden" name="repmsgid" id="repmsgid" value="<?=$varMessageId?>">
	</form>
</div>
<body>
</html>
<? 
//Unset Obj
$objMessage->dbClose();
unset($objMessage);
?>