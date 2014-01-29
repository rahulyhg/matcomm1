<?php
#====================================================================================================
# Author 		: N Dhanapal
# Start Date	: 09 Sep 2008
# End Date		: 09 Sep 2008
# Project		: MatrimonyProduct
# Module		: Express Interest Add 
#====================================================================================================
//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDE FILES //
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once $varRootBasePath."/conf/dbinfo.cil14";
include_once $varRootBasePath."/lib/clsDB.php";
include_once $varRootBasePath.'/lib/clsInboxMailer.php';

//OBJECT DECLARATION
$objInboxMailer = new InboxMailer;

//DB CONNECTION
$objInboxMailer->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE DECLERATION
$varMsgId		= $_REQUEST['msgid'];
$varMsgFlag		= $_REQUEST['msgfl'];
$varCurrDivNo	= $_REQUEST['currno'];
$varCurrentDate	= date('Y-m-d H:i:s');

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPublish	= $varGetCookieInfo['PUBLISH'];
$varErrorMsg	= '';
$varMessage		= '';

if($sessMatriId == "") {
	$varErrorMsg	= "You are either logged off or your session timed out. <a href='javascript:;' onclick=\"window.location.href='".$confValues['SERVERURL']."'/login/\" class=\"smalltxt clr1\">Click here </a> to login.";
}else if($sessPublish==0) {
	$varErrorMsg	= 'Sorry, you can send a reminder only when your profile has been validated.';
}else if($sessPublish==3) {
	$varErrorMsg	= 'Sorry, currently your profile is suspended.';
}else if($sessPublish==4) {
	$varErrorMsg	= 'Sorry, currently your profile is rejected.';
}


if ($varMsgId!='' && ($varMsgFlag==1 || $varMsgFlag==2) && $varErrorMsg=='')
{
	
	$varFields		= array('Opposite_MatriId');
	if($varMsgFlag == 1){
		$varTableName	= $varTable['MAILSENTINFO'];
		$varCondition	= 'WHERE Mail_Id='.$objInboxMailer->doEscapeString($varMsgId,$objInboxMailer)." AND MatriId=".$objInboxMailer->doEscapeString($sessMatriId,$objInboxMailer);
		$varReminderFlag= 'MsgReminder';
	}else if($varMsgFlag == 2){
		$varTableName	= $varTable['INTERESTSENTINFO'];
		$varCondition	= 'WHERE Interest_Id='.$objInboxMailer->doEscapeString($varMsgId,$objInboxMailer)." AND MatriId=".$objInboxMailer->doEscapeString($sessMatriId,$objInboxMailer);
		$varReminderFlag= 'Reminder';
	}
	
	$varSentInfo	= $objInboxMailer->select($varTableName, $varFields, $varCondition, 1);
	$varOppMatriId	= $varSentInfo[0]['Opposite_MatriId'];
	
	if ($varOppMatriId!='') {
		$varMessage	= 'Your reminder has been successfully sent to the member.';
		$objInboxMailer->mymessagesMailer($sessMatriId, $varOppMatriId, $varMsgId, $varReminderFlag, $varCurrentDate);
	} else {
		$varMessage	= 'Message is not available';
	}

}else if($varErrorMsg !=''){
	$varMessage = $varErrorMsg;
}
echo '<div class="fright">'.$varMessage.'<img src="'.$confValues['IMGSURL'].'/close.gif"/></div>';
exit;
$varCont = '<div class="fright">
			<img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');" href="javascript:;" class="pntr" /></div><br clear="all"/><div class="fleft" style="padding-left:0px !important;padding-left:10px;">'.$varMessage.'</div><div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');"/></div>';

include($varRootBasePath."/www/login/updatemessagescookie.php");
setMessagesCookie($sessMatriId,$objInboxMailer);


echo $varCont;

//UNSET OBJ
$objInboxMailer->dbClose();
unset($objInboxMailer);
?>