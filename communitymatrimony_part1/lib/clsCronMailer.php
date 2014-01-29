<?php
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

if($varRootBasePath == ''){ $varRootBasePath = '/home/product/community/www'; }


//INCLUDE FILES
include_once($varRootBasePath.'/lib/clsMailManager.php');

class cronMailer extends MailManager
{
	function birthDayList()
	{
		global $varTable;
		$funMonth	= Date(m);
		$funDay		= Date(d);
		$funFields	= array('User_Name', 'MatriId', 'Dob', 'Age');
		$funCond	= 'WHERE month(Dob)='.$funMonth.' AND day(Dob)='.$funDay;
		$retDisplay	= $this->select($varTable['MEMBERINFO'], $funFields, $funCond, 1);
		return $retDisplay;
	}

	function updateAge()
	{
		global $varTable;
		$funQuery 	= "";
		$funMonth	= Date(m);
		$funDay		= Date(d);
		$funFields		= array('Age');
		$funFieldsVal	= array('Age+1');
		$funCond		= 'month(Dob)='.$funMonth.' AND day(Dob)='.$funDay;
		$retDisplay		= $this->update($varTable['MEMBERINFO'], $funFields, $funFieldsVal, $funCond);
		return $retDisplay;
	}

	function getPaymentExpireDate($argPaidDate,$argValidDays)
	{
		$year = substr($argPaidDate, 6,4);
		$month = substr($argPaidDate, 0, 2);
		$day = substr($argPaidDate, 3, 2);
		$funExpireDate	= mktime(0, 0, 0, $month, $day + $argValidDays, $year);
		$retValidDate	= date("jS F Y",$funExpireDate);
		return $retValidDate;
	}

	function sendBirthdayMail($argUsername,$argMatriId,$argServerUrl,$argAge)
	{
		global $confValues;
		$funFrom				= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= $confValues['PRODUCTNAME'].".com wishes you a very Happy Birthday";
		$varLoginLink			= $argServerUrl.'/login/';
		$funServerUrl			= $argServerUrl;
		$funTo					= $argUsername;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/birthday.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolder			= "<--RECEIVER_NAME-->";
		$funReplaceValue		= $funTo;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$varContentFrom1		= "<--SERVER_LINK-->";
		$varContentTo1			= $funServerUrl;
		$this->clsViewTemplate	= str_replace($varContentFrom1,$varContentTo1,$this->clsViewTemplate);

		$funContentLoginButton	= "<--LOGIN_LINK-->";
		$funContentToLoginButton= $varLoginLink;
		$this->clsViewTemplate	= str_replace($funContentLoginButton,$funContentToLoginButton,$this->clsViewTemplate);

		$funToEmail				= $this->getEmail($argMatriId);
		$funMessage				= stripslashes($this->clsViewTemplate);
		
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}
	
	function sendNotLoggedInMail($argUsername,$argToEmail,$argServerUrl,$argUnReadMessagesCnt,$argUnPendingInterestCnt)
	{
		global $confValues;
		$funFrom				= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "A login reminder from ".$confValues['PRODUCTNAME'].".com";
		$funServerUrl			= $argServerUrl;
		$varMyPageLink			= $argServerUrl.'/login/index.php?redirect=registration/index.php?act=my-matrimony';

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/notLoggedIn.tpl";
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->mailCommonLinks($funServerUrl);

		$funPlaceHolder			= "<--RECEIVER_NAME-->";
		$funReplaceValue		= $argUsername;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$varReceiverPaidStatus	= $this->getPaidStatus($argUsername);
		if($varReceiverPaidStatus==1)
		{
			$funPaidMsg = '<p style="margin:0px;padding-top:15px;color:#AC0000">Being a paid member you must make the best use of your paid membership by continuously logging in and contacting matching profiles. You have the advantage of making better choices and finding your partner much faster.</p>';
		}
		else
			$funPaidMsg = '';

		$this->clsViewTemplate	= str_replace('<--PAID_MSG-->',$funPaidMsg,$this->clsViewTemplate);

		if(($argUnPendingInterestCnt>0) ||($argUnReadMessagesCnt>0))
		{
			$argUnPendingMsg = '<table border="0" cellpadding="0" cellspacing="0" width="488" bgcolor="#EFFFE9" style="border: 1px solid #19A66B;font: normal 11px verdana;padding-top:12px;padding-left:15px;padding-bottom:12px;"><tr><td   valign="top"><b>PENDING - WAITING FOR YOUR REPLY</b></p>';
			if($argUnPendingInterestCnt>0)
				$argUnPendingMsg .= '<br><img src="'.$argServerUrl.'/mailer/images/mailer-bullet.gif" width="3" height="5" border="0" alt="" vspace="2" hspace="5">'.$argUnPendingInterestCnt .' members have sent you Interest.<br><img src="'.$argServerUrl.'/mailer/images/trans.gif" width="1" height="3" border="0" alt="">';
			if($argUnReadMessagesCnt>0)
				$argUnPendingMsg .= '<br><img src="'.$argServerUrl.'/mailer/images/mailer-bullet.gif" width="3" height="5" border="0" alt="" vspace="2" hspace="5">'.$argUnReadMessagesCnt .' members have sent you Personalised Messages.<br><img src="'.$argServerUrl.'/mailer/images/trans.gif" width="1" height="6" border="0" alt="">';
			$argUnPendingMsg .= '<br><img src="'.$argServerUrl.'/mailer/images/trans.gif" width="3" height="5" border="0" alt="" vspace="2" hspace="5">Please don\'t keep them waiting. Reply today.</td></tr></table>';
		}
		else $argUnPendingMsg	= '<img src="'.$argServerUrl.'/mailer/images/trans.gif" width="3" height="5" border="0" alt="">';

		$funPlaceHolder			= "<--PENDING_MSG-->";
		$funReplaceValue		= $argUnPendingMsg;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);
		$funMessage				= stripslashes($this->clsViewTemplate);

		$retResult = $this->sendEmail($funFrom,$funFromEmail,$argTo,$argToEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retResult;
	}
	
	function NotLoggedIn()
	{
		global $varTable;
		$funFields	= array('mli.User_Name', 'mli.Email','mli.MatriId');
		$funFields1	= array('User_Name', 'Email','MatriId');
		$funTable	= $varTable['MEMBERLOGININFO'].' mli, '.$varTable['MEMBERINFO'].' mi';
		$funCond	= 'WHERE mli.MatriId=mi.MatriId AND Paid_Status=1 AND (DATEDIFF(CURDATE(),Last_Login))>15';
		$funResult	= $this->select($funTable, $funFields, $funCond, 0);

		$j=0;
		$funArrResult = array();
		while($row = mysql_fetch_array($funResult))
		{
			for($i=0;$i<count($funFields1);$i++)
			{ $funArrResult[$j][$funFields1[$i]] = trim($row[$funFields1[$i]]); }//for
			$j++;
		}

		return $funArrResult;
	}
		
	function sendPaymentExpireMail($argTo,$argValidDays,$argToEmail,$argServerUrl,$argExpiryDate,$argNumOfDays)
	{
		global $confValues;
		$funFrom				= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "10% Discount on Renewals. Avail today!";
		$funServerUrl			= $argServerUrl;
		$funPaymentLink			= $argServerUrl.'/payment/';
		if($argNumOfDays==7)
			$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/payment-reminder-7days.tpl"; //do change (template file)
		elseif($argNumOfDays==10)
			$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/payment-reminder-10days.tpl"; //do change (template file)
		else
			$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/payment-reminder-today.tpl"; //do change (template file)


		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->mailCommonLinks($funServerUrl);

		$funPlaceHolder1		= "<--RECEIVER_NAME-->";
		$funReplaceValue1		= $argTo;
		$this->clsViewTemplate	= str_replace($funPlaceHolder1,$funReplaceValue1,$this->clsViewTemplate);
		$funPlaceHolder2		= "<--VALID_DAYS-->";
		$funReplaceValue2		= $argValidDays;
		$this->clsViewTemplate	= str_replace($funPlaceHolder2,$funReplaceValue2,$this->clsViewTemplate);
		$funPlaceHolder3		= "<--EXPIRE_DATE-->";
		$funReplaceValue3		= $argExpiryDate;
		$this->clsViewTemplate	= str_replace($funPlaceHolder3,$funReplaceValue3,$this->clsViewTemplate);
		$funPlaceHolder4		= "<--PAYMENT_LINK-->";
		$funReplaceValue4		= $funPaymentLink;
		$this->clsViewTemplate	= str_replace($funPlaceHolder4,$funReplaceValue4,$this->clsViewTemplate);
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$argTo,$argToEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retResult;
	}
	
	function PaymentExpire()
	{
		global $varTable;

		$funFields	= array('mli.User_Name', 'Valid_Days', 'mli.Email', 'Last_Payment');
		$funFields1	= array('User_Name', 'Valid_Days', 'Email', 'Last_Payment');
		$funTable	= $varTable['MEMBERLOGININFO'].' mli, '.$varTable['MEMBERINFO'].' mi';
		$funCond	= 'WHERE mli.MatriId=mi.MatriId AND Paid_Status=1';
		$funResult	= $this->select($funTable, $funFields,$funCond, 0);
		$funNoField = count($funFields1);

		$j=0;
		$funArrResult	= array();
		while($row = mysql_fetch_assoc($funResult))
		{
			for($i=0;$i<$funNoField;$i++)
			{ $funArrResult[$j][$funFields1[$i]] = trim($row[$funFields1[$i]]); }//for
			$j++;
		}
		return $funArrResult;
	}
	
	function sendaddUrPhotoMail($argUsername,$argMemberId,$argServerUrl)
	{
		global $confValues;
		$funFrom				= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "A photo adding reminder from ".$confValues['PRODUCTNAME'].".com";
		$funToEmail				= $this->getEmail($argMemberId);
		$funServerUrl			= $argServerUrl;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/addUrPhoto.tpl";
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolder			= "<--RECEIVER_NAME-->";
		$funReplaceValue		= $argUsername;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--SERVER_LINK-->";
		$funReplaceValue		= $argServerUrl;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funMessage				= $this->clsViewTemplate;
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$argUsername,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retResult;
	}
	
	function addUrPhoto()
	{
		global $varTable;
		$funFields	= array('User_Name', 'MatriId');
		$funCond	= 'WHERE Photo_Set_Status=0';
		$funResult	= $this->select($varTable['MEMBERINFO'], $funFields,$funCond, 1);
		return $funResult;
	}
		
	function sendUnreadMessagesMail($argMatriId,$argUsername,$argServerUrl,$argUnReadMessagesCnt)
	{
		global $confValues;
		$funFrom				= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "Reply to your unread messages";
		$funServerUrl			= $argServerUrl;
		$funTo					= $argUsername;
		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/unreadMessages.tpl"; //do change (template file)
		$varUnReadMessagesCnt	= $argUnReadMessagesCnt;
		$varProfileBasicView	= $this->listUnReadMessages($argMatriId,$funServerUrl);
		$funProfileTemplateView	= $this->listAwaitingMembers($argMatriId,$funServerUrl,'Message');
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->mailCommonLinks($funServerUrl);

		if($funProfileTemplateView!='')
		{
			$varAwaitingMsg='<p style="margin:0px;font: bold 11px verdana,tahoma;padding-left:10px;padding-top:10px;color:#71A638;">More members awaiting your response</p><p style="margin:0px;font: normal 11px verdana,tahoma;padding-left:10px;padding-top:10px;">Listed below are a few other members who have sent you a personalized message earlier and awaiting your reply. Don\'t keep them waiting, go ahead and send them a reply.</p>';
		}//if
		else { $varAwaitingMsg=" "; }//else

		$varContentAwaitingMsg		= "<--AWAITING_MESSAGE-->";
		$varContentToAwaitingMsg	= $varAwaitingMsg;
		$this->clsViewTemplate		= str_replace($varContentAwaitingMsg,$varContentToAwaitingMsg,$this->clsViewTemplate);

		$varContentFromProfile		= "<--BASIC-PROFILE-->";
		$varContentToProfile		= $varProfileBasicView;
		$this->clsViewTemplate		= str_replace($varContentFromProfile,$varContentToProfile,$this->clsViewTemplate);


		$funContentFromProfileTemp	= "<--TEMPLATE-PROFILE-->";
		$funContentToProfileTemp	= $funProfileTemplateView;
		$this->clsViewTemplate		= str_replace($funContentFromProfileTemp,$funContentToProfileTemp,$this->clsViewTemplate);
		$varContentFrom9			= "<--RECEIVER_NAME-->";
		$varContentTo9				= $argUsername;
		$this->clsViewTemplate		= str_replace($varContentFrom9,$varContentTo9,$this->clsViewTemplate);

		$varContentFromCnt			= "<--COUNT-->";
		$varContentToCnt			= $varUnReadMessagesCnt;
		$this->clsViewTemplate		= str_replace($varContentFromCnt,$varContentToCnt,$this->clsViewTemplate);

		$funToEmail					= $this->getEmail($argMatriId);
		 $retvalue=$this->sendNotificationMail($argMatriId,$funTo,$funToEmail,$funServerUrl,$funSubject,$funFrom,$funFromEmail,$funReplyToEmail);

		return $retvalue;
	}
}
?>