<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 25 Aug 2008
# End Date	: 25 Aug 2008
# Project		: MatrimonyProduct
# Module		: Requests - add
#=============================================================================================================
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
// Include the files //
include_once $varRootBasePath."/conf/config.cil14"; // This includes error reporting functionalities
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once $varRootBasePath."/lib/clsDB.php";
include_once($varRootBasePath."/lib/clsReqMailer.php");

//Variable Declaration
$varSessionId		= $varGetCookieInfo['MATRIID'];
$varSessGender		= $varGetCookieInfo['GENDER'];
$varSessValStat		= $varGetCookieInfo['PUBLISH'];
$varSessPdStat		= $varGetCookieInfo['PAIDSTATUS'];
$varMatriId			= $_REQUEST['id'];
$varReqId			= $_REQUEST['rid'];
$varReqComeFrom		= $_REQUEST['reqCF'];

$varCurrentDate		= date('Y-m-d H:i:s');
$varDispMessage		= "";

// Object Declaration //
$objDb		= new RequestMailer;
$objMaster	= new DB;
$objMaster->dbConnect('M', $varDbInfo['DATABASE']);
$objDb->dbConnect('S', $varDbInfo['DATABASE']);

if($varSessionId!='' && $varMatriId!='' && $varReqId!='') {
	
	$varNumCond		= " WHERE SenderId=".$objDb->doEscapeString($varSessionId,$objDb)." AND ReceiverId=".$objDb->doEscapeString($varMatriId,$objDb)." AND RequestFor=".$objDb->doEscapeString($varReqId,$objDb);
	$varNumOfRecds	= $objDb->numOfRecords($varTable['REQUESTINFOSENT'],'SenderId',$varNumCond);

	if($varNumOfRecds==0) {
		$varReqEmail		= $objDb->getEmail($varMatriId);

		switch($varReqId) {
			case 1://Photo Request
				$varHeading	= 'Photo';
				$retValue	= $objDb->sendRequestMail($varSessionId,$varMatriId,$varReqEmail,1);
				break;
			case 3://Phone Request
				$varHeading	= 'Phone number';
				$retValue	= $objDb->sendRequestMail($varSessionId,$varMatriId,$varReqEmail,3);
				break;
			case 5://Horoscope Request
				$varHeading	= 'Horoscope';
				$retValue	= $objDb->sendRequestMail($varSessionId,$varMatriId,$varReqEmail,5);
				break;
		}
	}
}

if ($varSessionId == "") { 
	$varDispMessage = 'You must be a registered member to request the '.$varHeading.'.If you\'re already a member <a href="'.$confValues['SERVERURL'].'/login/" class="clr1" target="_blank">click here</a> to login or click on the register link below to become a member.<br><a class="smalltxt clr1" target="_blank" href="'.$confValues['SERVERURL'].'/register/">Register FREE</a>.';
} elseif($varSessValStat==0 || $varSessValStat=="") { 
	$varDispMessage = 'Sorry, as your profile is under validation, you will not be able to use this feature. It may take 24 hours for validating your profile. However if you become a paid member right away you can use this feature.'; 
} elseif($varMatriId=="") { 
	$varDispMessage = 'Sorry, <b>Matrimony Id</b>&nbsp; is missing.'; 
} elseif($varReqId==0 || $varReqId=='') { 
	$varDispMessage = 'Sorry, your purpose for requesting is not satisfied.'; 
} else {
	$varMemFields	= array('Nick_Name','Gender','Name');
	$varMemCond		= " WHERE MatriId=".$objDb->doEscapeString($varMatriId,$objDb)." AND Publish=1";
	$varMemInfo		= $objDb->select($varTable['MEMBERINFO'],$varMemFields,$varMemCond,1);

	$varBlockCond	= " WHERE MatriId=".$objDb->doEscapeString($varMatriId,$objDb)." AND Opposite_MatriId=".$objDb->doEscapeString($varSessionId,$objDb)." AND Blocked=1";
	$varBlockCondnum= $objDb->numOfRecords($varTable['BLOCKINFO'],'MatriId',$varBlockCond);

	if($varBlockCondnum > 0) {
		$varDispMessage = "Sorry, <b>".$varMatriId."</b> has been blocked you. You cannot request to the member.";
	} else {
		if($varNumOfRecds>0) { 
			$varDispMessage	= "You have already sent a ".$varHeading." request to this member"; 
		} else if($varSessGender==$varMemInfo[0]['Gender']) { 
			$varDispMessage = 'Sorry, you can send a request only to the opposite gender.'; 
		} else {
			//insert record without anonymous
			$varShowId		= 1;
			$varInsField	= array('SenderId','ReceiverId','RequestFor','RequestDate','DisclosedMatriId');
			$varInsFdVal	= array($objDb->doEscapeString($varSessionId,$objDb),$objMaster->doEscapeString($varMatriId,$objMaster),$objMaster->doEscapeString($varReqId,$objMaster),"'".$varCurrentDate."'",$varShowId);
			$varInsRecd		= $objMaster->insert($varTable['REQUESTINFORECEIVED'],$varInsField,$varInsFdVal);
			$varInsSent		= $objMaster->insert($varTable['REQUESTINFOSENT'],$varInsField,$varInsFdVal);
			
			$varDispMessage = "Your request has been sent successfully to  ".$varMatriId.". We will intimate you through e-mail as soon as the member has added  the ".strtolower($varHeading)."."; 

			/*$varSessFields		= array('Photo_Set_Status','Reference_Set_Status','Phone_Verified','Voice_Available');
			$varSessCond		= " WHERE MatriId=".$objDb->doEscapeString($varSessionId,$objDb)." AND Publish=1";
			$varSessInfo			= $objDb->select($varTable['MEMBERINFO'],$varSessFields,$varSessCond,1);
			
			if($varSessInfo[0]['Photo_Set_Status']==0 && $varReqId==1) { 
				$varDispMessage	= "To request a photo you must have your own photo added. <a href=\"javascript:;\" onclick=\"parent.window.location='".$confValues['SERVERURL']."/tools/index.php?add=photo';\" class=\"smalltxt clr1\">Click here to add</a>"; 
			}
			
			if($varSessInfo[0]['Phone_Verified']==0 && $varReqId==3) { 
				$varDispMessage	= "To request a phone you must have your own phone added. <a href=\"javascript:;\" onclick=\"parent.window.location='".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=contactedit&inview=2';\" class=\"smalltxt clr1\">Click here to add</a>"; 
			}*/
		}
	}
}

if($varReqComeFrom == 1) {
	echo '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box();" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varDispMessage.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box();"/></div>';
} else {
	echo $varDispMessage;
}
?>