<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 25 Aug 2008
# End Date		: 25 Aug 2008
# Project		: MatrimonyProduct
# Module		: Request - Result 
#=============================================================================================================
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
// Include the files //
include_once($varRootBasePath."/conf/config.cil14"); // This includes error reporting functionalities
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/lib/clsReqMailer.php");

//Variable Declaration
$varSessionId		= $varGetCookieInfo['MATRIID'];
$varSessName		= $varGetCookieInfo['NAME'];
$varSessGender		= $varGetCookieInfo['GENDER'];
$varSessValStat		= $varGetCookieInfo['PUBLISH'];
$varSessPdStat		= $varGetCookieInfo['PAIDSTATUS'];
$varSessPhotoStat	= $varGetCookieInfo['PHOTOSTATUS'];
$varSessPhStat		= $varGetCookieInfo['PHONEVERIFIED'];
$varDisplayMsg		= "";

// Object Declaration //
$objDb				= new DB;
$objReqMailer		= new RequestMailer;

$objReqMailer->dbConnect('S', $varDbInfo['DATABASE']);
$objDb->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varMemberId		= $_REQUEST["memid"];
//$varName			= $_REQUEST['memname'];
$varPurpose			= $_REQUEST["requestfor"];
$varShowId			= $_REQUEST["wid"];
$varRelative		= ($_REQUEST["chkrel"]==1)?1:0;
$varFriend			= ($_REQUEST["chkfrnd"]==2)?2:0;
$varColleague		= ($_REQUEST["chkcoll"]==3)?3:0;
$varRelation		= $varRelative.'~'.$varFriend.'~'.$varColleague;
$varReqRecvInfo		= $varTable['REQUESTINFORECEIVED'];
$varReqSentInfo		= $varTable['REQUESTINFOSENT'];
$varCurrentDate		= date('Y-m-d H:i:s');
$varDispMessage		= "";
$varDispAdd			= 'no';
$varReqEmail		= $objReqMailer->getEmail($varMemberId);
$varNumCond			= " WHERE SenderId=".$objReqMailer->doEscapeString($varSessionId,$objReqMailer)." AND ReceiverId=".$objReqMailer->doEscapeString($varMemberId,$objReqMailer)." AND RequestFor=".$objReqMailer->doEscapeString($varPurpose,$objReqMailer);
$varNumOfRecds		= $objReqMailer->numOfRecords($varReqSentInfo,'SenderId',$varNumCond);

switch($varPurpose) {
	case 1://Photo Request
		$varRequest	= 'photo';
		$varPath		= 'photo';
		$varIcon		= 'ph-pop-icon';
		if($varSessPhotoStat==0) $varDispAdd = 'yes';
		$retValue		= $objReqMailer->sendRequestPhotoMail($varSessionId,$varMemberId,$varReqEmail,$varShowId);
		break;
	case 2://Reference Request
		$varRequest	= 'reference';
		$varPath		= 'reference';
		$varIcon		= 'matriref';
		if($varSessRefStat==0) $varDispAdd = 'yes';
		$retValue		= $objReqMailer->sendRequestReferenceMail($varSessionId,$varMemberId,$varReqEmail,$varRelation,$varShowId);
		break;
	case 3://Phone Request
		$varRequest	= 'phone number';
		$varPath		= 'phone';
		$varIcon		= 'phone';
		if($varSessPhStat==0) $varDispAdd = 'yes';
		$retValue		= $objReqMailer->sendRequestPhoneMail($varSessionId,$varMemberId,$varReqEmail,$varShowId);
		break;
	case 4://Voice Request
		$varRequest	= 'voice profile';
		$varPath		= 'voice';
		$varIcon		= 'voice';
		if($varSessVoStat==0) $varDispAdd = 'yes';
		$retValue		= $objReqMailer->sendRequestVoiceMail($varSessionId,$varMemberId,$varReqEmail,$varShowId);
		break;
	case 5://Voice Request
		$varRequest	= 'horoscope';
		$varPath		= 'horoscope';
		$varIcon		= 'horoscope';
		if($varSessVoStat==0) $varDispAdd = 'yes';
		$retValue		= $objReqMailer->sendRequestHoroscopeMail($varSessionId,$varMemberId,$varReqEmail,$varShowId);
		break;
}

$varSuccessMsg = "<div class='smalltxt'>Your request has been sent successfully to  ".$varName.". We will intimate you through e-mail as soon as the member has added  the ".$varRequest.".</div>";

$varClickMsg	  = "<div id='useracticons'><div id='useracticonsimgs'><div class='smalltxt' style='padding-top:10px;'><a href='javascript:void(0)' onClick=''><div class='useracticonsimgs ".$varIcon." fleft' style='padding-right:5px'></div></a><div style='float:left:width:350px'><img src='".$confValues['IMGSURL']."/trans.gif' height='1'>Just as you would like to view another member's ".$varRequest.", they would like to view yours too! <a href='".$confValues['SERVERURL']."/tools/index.php?add=".$varPath."' class='clr1' target='blank'> Click here to add ".$varRequest." </a></div></div></div></div>";

$varAlrdyExsts	= "You have already sent a ".$varRequest." request to this member";

if($varNumOfRecds>0) { 
	$varDispMessage = $varAlrdyExsts; 
} else { 
	if($varSessionId!='' && $varMemberId!='' && $varPurpose!='' && $varShowId!=''){
		$varInsField	= array('SenderId','ReceiverId','RequestFor','ReferenceRelationship','RequestDate','DisclosedMatriId');
		$varInsFdVal	= array($objDb->doEscapeString($varSessionId,$objDb),$objDb->doEscapeString($varMemberId,$objDb),$objDb->doEscapeString($varPurpose,$objDb),$objDb->doEscapeString($varRelation,$objDb),"'".$varCurrentDate."'",$objDb->doEscapeString($varShowId,$objDb));
		$varInsSent		= $objDb->insert($varReqRecvInfo,$varInsField,$varInsFdVal);
		$varInsRecd		= $objDb->insert($varReqSentInfo,$varInsField,$varInsFdVal);
		
	}
	$varDispMessage = $varSuccessMsg; 
	if($varPurpose!=3 && $varPurpose!=1 && $varDispAdd == 'yes') { 
		$varDispMessage .= $varClickMsg; 
	} 
}
$objDb->dbClose();
$objReqMailer->dbClose();
unset($objDb);
unset($objReqMailer);
?>
<div id="useracticons"><div id="useracticonsimgs">
	<div class="mediumtxt boldtxt clr3" style="float:left;padding:0px 0px 3px 0px;"><?=ucfirst($varRequest)?> Request  Sent</div><br clear="all">
	<div style="border:1px solid #CCCCCC;padding:5px 0px 5px 5px;"><?=$varDispMessage?></div><div  class="fright" style="padding-top:5px;"><input type="button" value="Close" class="button" onClick="closeIframe('iframeicon','icondiv');" style="cursor:hand;"></div>
</div></div>