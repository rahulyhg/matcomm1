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
if($varServerRoot == ''){ $varServerRoot  = '/home/product/community/ability/www'; }
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsMailManager.php');

class InboxMailer extends MailManager
{
	// MAIL RECEIVED NOTIFICATION MAIL
	function mymessagesMailer($argMatriId,$argReceiverMatriId,$argMessageId,$argPurpose,$argDt)
	{
		$arrEmailsList		= $this->getDomainEmailList($argMatriId);
		$arrDoaminDet		= $this->getDomainDetails($argMatriId);
		$funFolderName		= $this->getFolderName($argMatriId);
			
		$funImgsURL			= $arrDoaminDet['MAILERIMGURL'];
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
		$funLinkURL			= $funServerURL.'/login/index.php?redirect='.$funServerURL.'/mymessages/?';
				
		if($argPurpose=='NewMail') {
			$funSubject		= 'You have received a message from '.$funName.' ('.$argMatriId.'). View NOW!';
			$funMsgHeading	= 'New Message';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'Login to view message and send a reply. At '.$arrDoaminDet['PRODUCTNAME'].' Matrimony, it’s free to reply.';
			$funLinkName	= 'Click here to login';
			$funLinkURL	   .= 'part=RMUNREAD';
		} else if($argPurpose=='NewInterest') {
			$funSubject		= 'You have received a message from '.$funName.' ('.$argMatriId.'). View NOW!';
			$funMsgHeading	= 'New Message';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'Login to view message and send a reply. At '.$arrDoaminDet['PRODUCTNAME'].' Matrimony, it’s free to reply.';
			$funLinkName	= 'Click here to login';
			$funLinkURL	   .= 'part=RIPENDING';
		} else if($argPurpose=='Decline') {
			$funSubject		= $funName.' ('.$argMatriId.') has declined your Message.';
			$funMsgHeading	= 'Message Declined';
			$funByFromTxt	= 'by';
			$funContentTxt	= 'Thousands of other profiles are waiting to be contacted.<br clear="all">One of them could be a better match for you.';
			$funLinkName	= 'Click here to login';
			$funDateTxt		= 'Date declined';
			$funLinkURL	   .= 'part=SMALL';
		} else if($argPurpose=='MsgReminder') {
			$funSubject		= "Reminder from ".$funName.' ('.$argMatriId.'). Reply soon.';
			$funMsgHeading	= 'Reminder';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'Please reply to member\'s message. It\'s better to reply than to keep member in anticipation.';
			$funLinkName	= 'Login to reply';
		} else if($argPurpose=='Reminder') {
			$funSubject		= "Reminder from ".$funName.' ('.$argMatriId.'). Reply soon.';
			$funMsgHeading	= 'Reminder';
			$funByFromTxt	= 'From';
			$funContentTxt	= 'Please reply to member\'s message. It\'s better to reply than to keep member in anticipation.';
			$funLinkName	= 'Login to reply';
			$funLinkURL	   .= 'part=RIALL';
		} else if($argPurpose=='InterestDecline') {
			$funSubject		= $funName.' ('.$argMatriId.') has declined your Message.';
			$funMsgHeading	= 'Message Declined';
			$funByFromTxt	= 'by';
			$funContentTxt	= 'Thousands of other profiles are waiting to be contacted.<br clear="all">One of them could be a better match for you.';
			$funLinkName	= 'Click here to login';
			$funDateTxt		= 'Date declined';
			$funLinkURL	   .= 'part=SIALL';
		} else if($argPurpose=='InterestAccept') {
			$funSubject		= $funName.' ('.$argMatriId.') has accepted your message';
			$funMsgHeading	= 'Message Accepted';
			$funByFromTxt	= 'by';
			$funContentTxt	= 'Take initiative and contact member directly';
			$funLinkName	= 'Click here to login';
			$funDateTxt		= 'Date accepted';
			$funLinkURL	   .= 'part=SIACCEPTED';
		}

		$varTemplateFileName	= $funTplURL.'messagemails.tpl';
		$funMessageCont	= $this->getContentFromFile($varTemplateFileName);
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
	
		$funToEmail	= $this->getEmail($argReceiverMatriId);
		$this->sendEmail($funFrom,$funFromEmail,'',$funToEmail,$funSubject,$funMessageCont,$funReplyToEmail);
	}//mymessagesMailer
}
?>