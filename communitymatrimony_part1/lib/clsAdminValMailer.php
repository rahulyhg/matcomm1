<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 07 Oct 2008
# End Date	: 07 Oct 2008
# Project		: MatrimonyProduct
# Module		: Admin Validation - MailManager
#=============================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDE FILES
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath.'/conf/emailsconfig.cil14');
include_once($varRootBasePath."/lib/clsCryptDetail.php");

class AdminValid extends MailManager
{
	function sendAddedMail($argMatriId,$varMemberId,$argReceiverEmail,$argPaidStatus,$argFlag)
	{
		global $confValues, $arrMailerLinkClr;


		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['NOREPLYMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGServerPath		= $arrGetProductInfo['IMGSERVERURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];

		$funReceiverDate		= date("d-m-y");
		$funReceiverName		= $this->displayName($varMemberId);
		$funSenderName			= $this->displayName($argMatriId);
		$funTo					= $funReceiverName;

		//For CBS-Autologin	--> GOKILAVANAN.R(FEB-10-2011)
		$varAutoLogin	  = CryptDetail::mclink($varMemberId,'admVa');  // For autologin

		$funMatriIdPre = substr($argMatriId,0,3);
		$funLinkClr	   = array_key_exists($funMatriIdPre, $arrMailerLinkClr) ? $arrMailerLinkClr[$funMatriIdPre] : '#D11014';

		switch($argFlag) {
			case 1:
				$funRequestType = "photo";
				$funSubject		= $funSenderName.' has added photo in '.$funProductName.'Matrimony.com';
				$varViewLink	= '<A HREF="'.$funServerUrl.'/login/intermediatelogin.php?redirect='.$funServerUrl.'/profiledetail/index.php?act=fullprofilenew~id='.$argMatriId.'&'.$varAutoLogin.'" style="font:normal 12px arial;color:'.$funLinkClr.';text-decoration:none;">Click to View Photo.</A>';
				$varExtraTopCont= "";
				$varRecGender	= $this->getGender($argMatriId);

				if($varRecGender == 1) {
					$varPhotoImg = "request-photo-male.gif";
				} else {
					$varPhotoImg = "request-photo.gif";
				}
				$funReqImage	= $funMailerImagePath."/".$varPhotoImg;

				if($argPaidStatus == 1) {
					$varBottomCont	= "";
				} else {
					$varBottomCont	= '<br> Want to contact this member on phone, e-mail & chat? <A HREF="'.$funServerUrl.'/payment/" style="font:normal 11px arial;color:'.$funLinkClr.';text-decoration:none;font-weight:bold;">PAY NOW</A> to enjoy all benefits.';
				}
				break;

			case 3:
				$funRequestType = "phone number";
				$funSubject		= $funSenderName.' has added phone in '.$funProductName.'Matrimony.com';

				$funReqImage	= $funMailerImagePath."/request-phone.gif";
				$varBottomCont	= "";
				if($argPaidStatus == 1) {
					$varViewLink	= '<A HREF="'.$funServerUrl.'/login/intermediatelogin.php?redirect='.$funServerUrl.'/profiledetail/index.php?act=fullprofilenew~id='.$argMatriId.'&'.$varAutoLogin.'" style="font:normal 12px arial;color:'.$funLinkClr.';text-decoration:none;">Click to view phone number.</A>';
					$varExtraTopCont= "<br> Now you can contact member directly.";
				} else {
					$varViewLink	= '<A HREF="'.$funServerUrl.'/payment/" style="font:normal 12px arial;color:'.$funLinkClr.';text-decoration:none;">Click here to PAY NOW.</A>';
					$varExtraTopCont= "<br> Become a premium member to access member's phone numbers.";
				}
				break;

			case 5:
				$funRequestType = "horoscope";
				$funSubject		= $funSenderName.' has added horoscope in '.$funProductName.'Matrimony.com';
				$varViewLink	= '<A HREF="'.$funServerUrl.'/login/intermediatelogin.php?redirect='.$funServerUrl.'/profiledetail/index.php?act=fullprofilenew~id='.$argMatriId.'&'.$varAutoLogin.'" style="font:normal 12px arial;color:'.$funLinkClr.';text-decoration:none;">Click to view horoscope.</A>';
				$funReqImage	= $funMailerImagePath."/request-horoscope.gif";
				$varExtraTopCont= "";
				if($argPaidStatus == 1) {
					$varBottomCont	= "";
				} else {
					$varBottomCont	= '<br> Want to contact this member on phone, e-mail & chat? <A HREF="'.$funServerUrl.'/payment/" style="font:normal 11px arial;color:'.$funLinkClr.';text-decoration:none;font-weight:bold;">PAY NOW</A> to enjoy all benefits.';
				}
				break;
		}

		$varTemplateFileName	= $arrGetProductInfo['MAILERTPLPATH']."/requestadded.tpl"; //do change (template file)

		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->clsViewTemplate	= str_replace('<--DATE_RECEIVED-->',$funReceiverDate,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SENDER_NAME-->',$funSenderName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SENDER_ID-->',$argMatriId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RECEIVER_NAME-->',$funReceiverName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RECEIVER_ID-->',$varMemberId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REQ_TYPE-->',$funRequestType,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REQ_IMAGE-->',$funReqImage,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--EXTRA_TOP_CONTENT-->',$varExtraTopCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--BOTTOM_CONTENT-->',$varBottomCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--VIEW_LINK-->',$varViewLink,$this->clsViewTemplate);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);
		$funPlaceHolder			= "<--MAILER-IMAGE-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);
		$funPlaceHolder			= "<--MAILERIMGSPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);
		$funPlaceHolder			= "<--PRODUCTNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funProductName,$this->clsViewTemplate);
		$unsubscibeLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		$funPlaceHolder			= "<--UNSUBSCRIBE_LINK-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$unsubscibeLink,$this->clsViewTemplate);

		$funMessage				= stripslashes($this->clsViewTemplate);
		$this->sendEmail($funFrom,$funFromEmail,$funTo,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);

	}

	function requestAdded($varMatriId,$varRequestFlag) {
		global $varTable;

		$varFields			= array('SenderId');
		$varCondition		= "WHERE ReceiverId = '".$varMatriId."' AND RequestMet = 0 AND RequestFor = ".$varRequestFlag;
		$varResult			= $this->select($varTable['REQUESTINFORECEIVED'], $varFields, $varCondition, 0);
		while ($varGetRow		= mysql_fetch_assoc($varResult)) {
			$varSenderId		= $varGetRow['SenderId'];
			$varToEmail			= $this->getEmail($varSenderId);
			$varGetPaidStatus	= $this->getPaidStatus($varSenderId);
			$varMailStatus		= $this->sendAddedMail($varMatriId,$varSenderId,$varToEmail,$varGetPaidStatus,$varRequestFlag);
			$varFields			= array('RequestMetOn','RequestMet');
			$varFieldValues		= array( "NOW()",1);
			$varCondition		= "ReceiverId=".$this->doEscapeString($varMatriId,$this)." AND SenderId=".$this->doEscapeString($varSenderId,$this)." AND RequestFor=".$this->doEscapeString($varRequestFlag,$this); 
			$this->update($varTable['REQUESTINFORECEIVED'], $varFields, $varFieldValues, $varCondition);
			$this->update($varTable['REQUESTINFOSENT'], $varFields, $varFieldValues, $varCondition);
		}
	}

	function sendProfileValidationMail($argMatriId,$argReceiverName,$argReceiverEmail,$argPhoneVerify,$argPinNo)
	{
		global $confValues;

		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['NOREPLYMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];
		$funTollFreeCont		= $this->getINDTollFree($argMatriId);

		$funSubject				= "Congrats! Your profile is validated.";


		$varTemplateFileName	= $arrGetProductInfo['MAILERTPLPATH']."/profileValidation.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->clsViewTemplate	= str_replace("<--TOLLFREE-->",$funTollFreeCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--SERVERURL-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MATRIID-->",$argMatriId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--NAME-->",ucfirst($argReceiverName),$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MAILERIMGSPATH-->",$funMailerImagePath,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGIN-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGO-->",$funIMGSPath.'/logo/'.$funFolderName,$this->clsViewTemplate);

		$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		if($argPhoneVerify!=1) {
			$funPlaceHolder			= "<--PHONEVERIFY-->";
			$funReplaceValue		= "<B>To verify your phone number using our automated verification system:</B><br />Call toll free ";
			$funReplaceValue		.= "<font style='color:#777777;'>1-800-3000-2222</font> from the phone number you have provided during registration.  Press 2 on your phone. You will be asked to enter your PIN - <span style='color:#777777;'>".$argPinNo."</span> to complete your verification.<br /><br />";
			$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);
		}
		$this->clsViewTemplate	= str_replace("<--PRODUCTNAME-->",$funProductName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--UNSUBSCRIBE_LINK-->",$unsubscibeLink,$this->clsViewTemplate);
		$funMessage				= stripslashes($this->clsViewTemplate);

		$retvalue = $this->sendEmail($funFrom,$funFromEmail,$argReceiverName,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retvalue;
	}

	function sendProfileModificationMail($argMatriId,$argReceiverName,$argReceiverEmail)
	{
		global $confValues, $arrMailerLinkClr;

		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['NOREPLYMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];
		$funPaidStatus			= $this->getPaidStatus($argMatriId);
		$funTollFreeCont		= $this->getINDTollFree($argMatriId);

		$funMatriIdPre = substr($argMatriId,0,3);
		$funLinkClr	   = array_key_exists($funMatriIdPre, $arrMailerLinkClr) ? $arrMailerLinkClr[$funMatriIdPre] : '#D11014';
		$varFreememberCont		= ($funPaidStatus==1) ? '' : '<tr><td valign="top" colspan="2" align="center" width="536" style="padding-top:5px;font:normal 11px arial;color:#606060;">Explore all the benefits of <--PRODUCTNAME--> Matrimony with a Premium Membership. <A HREF="<--PAYNOW-->/payment/" style="font:normal 12px arial;color:'.$funLinkClr.';text-decoration:none;">PAY NOW </A></td></tr>';

		$funSubject				= "Your profile on ".$funProductName." Matrimony has been successfully modified.";

		$varTemplateFileName	= $arrGetProductInfo['MAILERTPLPATH']."/profileModification.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->clsViewTemplate	= str_replace("<--TOLLFREE-->",$funTollFreeCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--SERVERURL-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--FREEMEMBER-->",$varFreememberCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGO-->",$funIMGSPath.'/logo/'.$funFolderName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MATRIID-->",$argMatriId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--NAME-->",ucfirst($argReceiverName),$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MAILERIMGSPATH-->",$funMailerImagePath,$this->clsViewTemplate);
		$LoginRedirectLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=primaryinfo";
		$this->clsViewTemplate	= str_replace("<--LOGIN_REDIRECT-->",$LoginRedirectLink,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--PAYNOW-->",$funServerUrl,$this->clsViewTemplate);
		$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		$this->clsViewTemplate	= str_replace("<--PRODUCTNAME-->",$funProductName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--UNSUBSCRIBE_LINK-->",$unsubscibeLink,$this->clsViewTemplate);
		$funMessage				= stripslashes($this->clsViewTemplate);

		$retvalue = $this->sendEmail($funFrom,$funFromEmail,$argReceiverName,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retvalue;
	}

	function sendProfileModificationByAdminMail($argMatriId,$argReceiverName,$argReceiverEmail,$argUserContent,$argAdminContent)
	{
		global $confValues;

		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['NOREPLYMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];
		$funTollFreeCont		= $this->getINDTollFree($argMatriId);

		$funSubject				= "Your profile has been modified by ".$funProductName." Matrimony";

		$varTemplateFileName	= $arrGetProductInfo['MAILERTPLPATH']."/profileAdminModify.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);
		$this->clsViewTemplate	= str_replace("<--TOLLFREE-->",$funTollFreeCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--SERVERURL-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGO-->",$funIMGSPath.'/logo/'.$funFolderName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MATRIID-->",$argMatriId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--NAME-->",ucfirst($argReceiverName),$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--USER-CONTENT-->",$argUserContent,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--ADMIN-CONTENT-->",$argAdminContent,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MAILERIMGSPATH-->",$funMailerImagePath,$this->clsViewTemplate);
		$LoginRedirectLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=primaryinfo";
		$this->clsViewTemplate	= str_replace("<--LOGIN_REDIRECT-->",$LoginRedirectLink,$this->clsViewTemplate);
		$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		$this->clsViewTemplate	= str_replace("<--PRODUCTNAME-->",$funProductName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--UNSUBSCRIBE_LINK-->",$unsubscibeLink,$this->clsViewTemplate);

		$funMessage				= stripslashes($this->clsViewTemplate);

		$retvalue = $this->sendEmail($funFrom,$funFromEmail,$argReceiverName,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retvalue;
	}

	function sendTroubleWithUrProfileMail($argMatriId,$argReceiverName,$argReceiverEmail,$argRecjectComment,$argVarFrom)
	{
		global $confValues;

		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['HELPEMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];

		$funSubject				= "Modify your profile today and get better results!";
		if($argVarFrom=="validate"){
		$varTemplateFileName	= $arrGetProductInfo['MAILERTPLPATH']."/troublewithUrProfile.tpl"; //do change (template file) validation reject
		}else if($argVarFrom=="modify"){
		$varTemplateFileName	= $arrGetProductInfo['MAILERTPLPATH']."/modify_reject_request.tpl"; //do change (template file) modification reject
		}
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MATRIID-->";
		$funReplaceValue		= $argMatriId;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--NAME-->";
		$funReplaceValue		= ucfirst($argReceiverName);
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MAILERIMGSPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);

		$LoginRedirectLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=primaryinfo";
		$funPlaceHolder			= "<--LOGIN_REDIRECT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$LoginRedirectLink,$this->clsViewTemplate);

		$funPlaceHolder			= "<--REJECT-COMMENT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argRecjectComment,$this->clsViewTemplate);

		$funPlaceHolder			= "<--PRODUCTNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funProductName,$this->clsViewTemplate);

		$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		$funPlaceHolder			= "<--UNSUBSCRIBE_LINK-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$unsubscibeLink,$this->clsViewTemplate);

		$funMessage				= stripslashes($this->clsViewTemplate);
		$retvalue = $this->sendEmail($funFrom,$funFromEmail,$argReceiverName,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retvalue;
	}
}
?>