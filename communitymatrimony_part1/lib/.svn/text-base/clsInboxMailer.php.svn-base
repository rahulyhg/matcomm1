<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 07 Oct 2008
# End Date	: 07 Oct 2008
# Project		: MatrimonyProduct
# Module		: Inbox - MailManager
#=============================================================================================================
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
if($varServerRoot == ''){ $varServerRoot  = '/home/product/community/www'; }
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/conf/smscontent.cil14');
include_once($varBaseRoot.'/lib/clsMailManager.php');
include_once($varRootBasePath."/lib/clsCryptDetail.php");

class InboxMailer extends MailManager
{
	// MAIL RECEIVED NOTIFICATION MAIL
	function mymessagesMailer($argMatriId,$argReceiverMatriId,$argMessageId,$argPurpose,$argDt)
	{
		$arrEmailsList		= $this->getDomainEmailList($argMatriId);
		$arrDoaminDet		= $this->getDomainDetails($argMatriId);
		$funFolderName		= $this->getFolderName($argMatriId);
			
		$funImgsURL			= $arrDoaminDet['MAILERIMGURL'];
		$funMailerImgsURL	= $arrDoaminDet['SERVERURL'].'/mailer/images';
		$funTplURL			= $arrDoaminDet['MAILERTPLPATH'];
		$funLogo			= $arrDoaminDet['IMGURL'].'/logo/'.$funFolderName.'_logo.gif';
		$funDateTxt			= 'Date received';
		$funDate			= date('d m y',strtotime($argDt));
		$funName			= $this->displayName($argMatriId);
		$funServerURL		= $arrDoaminDet['SERVERURL'];
		$funFrom			= $arrDoaminDet['FROMADDRESS'];
		$funCommunityTxt	= $arrDoaminDet['PRODUCTNAME'];
		$funFromEmail		= $arrEmailsList['INFOEMAIL'];
		$funReplyToEmail	= $arrEmailsList['NOREPLYMAIL'];
		
		//For CBS-Autologin	--> GOKILAVANAN.R(FEB-10-2011)
		$varAutoLogin	  = CryptDetail::mclink($argReceiverMatriId,'inbM');  // For autologin
		$funLinkURL			= $funServerURL.'/login/intermediatelogin.php?redirect='.$funServerURL.'/mymessages/?';
				
		if($argPurpose=='NewMail') {
			$funSubject		= 'You have received a message from '.$funName.' ('.$argMatriId.'). View NOW!';
			$funMsgHeading	= 'New Message';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'View message and send a reply. At '.$arrDoaminDet['PRODUCTNAME'].' Matrimony, it’s free to reply.';
			$funLinkName	= 'Click here to Reply';
			$funLinkURL	   .= 'part=RMUNREAD';
		} else if($argPurpose=='NewInterest') {
			$funSubject		= 'You have received a interest from '.$funName.' ('.$argMatriId.'). View NOW!';
			$funMsgHeading	= 'New Interest';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'View message and send a reply. At '.$arrDoaminDet['PRODUCTNAME'].' Matrimony, it’s free to reply.';
			$funLinkName	= 'Click here to Reply';
			$funLinkURL	   .= 'part=RIPENDING';
		} else if($argPurpose=='Decline') {
			$funSubject		= $funName.' ('.$argMatriId.') has declined your Message.';
			$funMsgHeading	= 'Message Declined';
			$funByFromTxt	= 'by';
			$funContentTxt	= 'Thousands of other profiles are waiting to be contacted.<br clear="all">One of them could be a better match for you.';
			$funLinkName	= 'Click here to View';
			$funDateTxt		= 'Date declined';
			$funLinkURL	   .= 'part=SMDECLINED';
		} else if($argPurpose=='MsgReminder') {
			$funSubject		= "Reminder from ".$funName.' ('.$argMatriId.'). Reply soon.';
			$funMsgHeading	= 'Reminder';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'Please reply to member\'s message. It\'s better to reply than to keep member in anticipation.';
			$funLinkName	= 'Reply Now';
		} else if($argPurpose=='Reminder') {
			$funSubject		= "Reminder from ".$funName.' ('.$argMatriId.'). Reply soon.';
			$funMsgHeading	= 'Reminder';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'Please reply to member\'s message. It\'s better to reply than to keep member in anticipation.';
			$funLinkName	= 'Reply Now';
			$funLinkURL	   .= 'part=RIPENDING';
		} else if($argPurpose=='InterestDecline') {
			$funSubject		= $funName.' ('.$argMatriId.') has declined your Message.';
			$funMsgHeading	= 'Message Declined';
			$funByFromTxt	= 'by';
			$funContentTxt	= 'Thousands of other profiles are waiting to be contacted.<br clear="all">One of them could be a better match for you.';
			$funLinkName	= 'Click here to View';
			$funDateTxt		= 'Date declined';
			$funLinkURL	   .= 'part=SIDECLINED';
		} else if($argPurpose=='InterestAccept') {
			$funSubject		= $funName.' ('.$argMatriId.') has accepted your message';
			$funMsgHeading	= 'Message Accepted';
			$funByFromTxt	= 'by';
			$funContentTxt	= 'Take initiative and contact member directly';
			$funLinkName	= 'Click here to View';
			$funDateTxt		= 'Date accepted';
			$funLinkURL	   .= 'part=SIACCEPTED';
		}
		//For CBS-Autologin	--> GOKILAVANAN.R(FEB-10-2011)
		$funLinkURL	   .=	'&'.$varAutoLogin;

		$varTemplateFileName	= $funTplURL.'messagemails.tpl';
		$funMessageCont	= $this->getContentFromFile($varTemplateFileName);
		$funMessageCont	= str_replace('<--MAILERIMGSPATH-->',$funMailerImgsURL,$funMessageCont);
		$funMessageCont	= str_replace('<--LOGO-->',$funLogo,$funMessageCont);
		$funMessageCont	= str_replace('<--DATETXT-->',$funDateTxt,$funMessageCont);
		$funMessageCont	= str_replace('<--DATE-->',$funDate,$funMessageCont);
		$funMessageCont	= str_replace('<--IMGSURL-->',$funImgsURL,$funMessageCont);
		$funMessageCont	= str_replace('<--MSG_HEADING-->',$funMsgHeading,$funMessageCont);
		$funMessageCont	= str_replace('<--BY_FROMTXT-->',$funByFromTxt,$funMessageCont);
		$funMessageCont	= str_replace('<--NAME-->',$funName,$funMessageCont);
		$funMessageCont	= str_replace('<--MATRIID-->',$argMatriId,$funMessageCont);
		$funMessageCont	= str_replace('<--CONTENTTXT-->',$funContentTxt,$funMessageCont);
		$funMessageCont	= str_replace('<--LINKURL-->',$funLinkURL,$funMessageCont);
		$funMessageCont	= str_replace('<--LINKNAME-->',$funLinkName,$funMessageCont);
		$funMessageCont	= str_replace('<--COMMUNITYTXT-->',$funCommunityTxt,$funMessageCont);
		$funMessageCont	= str_replace('<--SERVERURL-->',$funServerURL,$funMessageCont);
		$funMessageCont	= str_replace('<--RECEIVER_ID-->',$argReceiverMatriId,$funMessageCont);

		$funToEmail	= $this->getEmail($argReceiverMatriId);
		$this->sendEmail($funFrom,$funFromEmail,'',$funToEmail,$funSubject,$funMessageCont,$funReplyToEmail);
	}//mymessagesMailer

	#Send SMS to Opposite Id
	function sendSMS($sessMatriId,$varOppMatriId,$sendType){
        global $varSMSContent,$varTable,$varUcDomain;
		
		$varFields				= array('VerifiedFlag','MobileNo');
		$varCondition			= 'WHERE MatriId='.$this->doEscapeString($varOppMatriId,$this);
		$varReceiverContact		= $this->select($varTable['ASSUREDCONTACT'], $varFields, $varCondition, 1);
		$varName			    = $this->displayName($sessMatriId);
		$arrDoaminDet		    = $this->getDomainDetails($sessMatriId);
		$varMessage             = str_replace('#DOMAINNAME',$arrDoaminDet['PRODUCTNAME'].'Matrimony',$varSMSContent[$sendType]);
        $varMessage             = str_replace('#MATRIID',$sessMatriId,$varMessage);
		$varMobileNo            = $varReceiverContact[0]['MobileNo'];
        switch($sendType){
		case 'AcceptInterest':
			if($varReceiverContact[0]['VerifiedFlag']==1 || $varReceiverContact[0]['VerifiedFlag']==2 || $varReceiverContact[0]['VerifiedFlag']==3){
			exec("php /home/product/community/bin/sms/cbssms.php ".$varMobileNo." ".urlencode($varMessage)." ".$varUcDomain);
			}
		break;
		case 'NewInterest':
			if($varReceiverContact[0]['VerifiedFlag']==1 || $varReceiverContact[0]['VerifiedFlag']==2 || $varReceiverContact[0]['VerifiedFlag']==3){
			exec("php /home/product/community/bin/sms/cbssms.php ".$varMobileNo." ".urlencode($varMessage)." ".$varUcDomain);
			}
        break;
		case 'NewMessage':
			if($varReceiverContact[0]['VerifiedFlag']==1 || $varReceiverContact[0]['VerifiedFlag']==2 || $varReceiverContact[0]['VerifiedFlag']==3){
			exec("php /home/product/community/bin/sms/cbssms.php ".$varMobileNo." ".urlencode($varMessage)." ".$varUcDomain);
			}
        break;
		}
	}
}
?>