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
class AdminValid extends MailManager
{
	function sendAddedMail($argMatriId,$varMemberId,$argReceiverEmail,$argPaidStatus,$argFlag)
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
		$funIMGServerPath		= $arrGetProductInfo['IMGSERVERURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];

		$funReceiverDate		= date("d-m-y");
		$funReceiverName		= $this->displayName($varMemberId);
		$funSenderName			= $this->displayName($argMatriId);
		$funTo					= $funReceiverName;

		switch($argFlag) {
			case 1: 
				$funRequestType = "photo";
				$funSubject		= $funSenderName.' has added photo in '.$funProductName.'Matrimony.com';
				$varViewLink	= '<A HREF="'.$funServerUrl.'/login/index.php?redirect='.$funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$argMatriId.'" style="font:normal 12px arial;color:#D11014;text-decoration:none;">Login to view photo.</A>';
				$varExtraTopCont= "";
				$varRecGender	= $this->getGender($argMatriId);

				if($varRecGender == 1) {
					$varPhotoImg = "request-photo-male.gif";
				} else {
					$varPhotoImg = "request-photo.gif";
				}
				$funReqImage	= $funMailerImagePath."/".$varPhotoImg;
				$varBottomCont	= '';
				break;

			case 3: 
				$funRequestType = "phone number";
				$funSubject		= $funSenderName.' has added phone in '.$funProductName.'Matrimony.com';
				
				$funReqImage	= $funMailerImagePath."/request-phone.gif";
				$varBottomCont	= "";
				$varViewLink	= '<A HREF="'.$funServerUrl.'/login/index.php?redirect='.$funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$argMatriId.'" style="font:normal 12px arial;color:#D11014;text-decoration:none;">Login to view phone number.</A>';
				$varExtraTopCont= "<br> Now you can contact member directly.";
				break;

			case 5: 
				$funRequestType = "horoscope";
				$funSubject		= $funSenderName.' has added horoscope in '.$funProductName.'Matrimony.com';
				$varViewLink	= '<A HREF="'.$funServerUrl.'/login/index.php?redirect='.$funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$argMatriId.'" style="font:normal 12px arial;color:#D11014;text-decoration:none;">Login to view horoscope.</A>';
				$funReqImage	= $funMailerImagePath."/request-horoscope.gif";
				$varExtraTopCont= "";
				$varBottomCont	= "";
				break;
		}

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/requestadded.tpl"; //do change (template file)

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
			$varUpdate			= $this->update($varTable['REQUESTINFORECEIVED'], $varFields, $varFieldValues, $varCondition);	
			$varUpdate			= $this->update($varTable['REQUESTINFOSENT'], $varFields, $varFieldValues, $varCondition);
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
		
		$funSubject				= "Congrats! Your profile is validated.";

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/profileValidation.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);
		
		$funPlaceHolder			= "<--MATRIID-->";
		$funReplaceValue		= $argMatriId;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--NAME-->";
		$funReplaceValue		= ucfirst($argReceiverName);
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MAILERIMGSPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);

		$funPlaceHolder			= "<--LOGIN-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funServerUrl,$this->clsViewTemplate);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";

		if($argPhoneVerify!=1) {
			$funPlaceHolder			= "<--PHONEVERIFY-->";
			$funReplaceValue		= "<B>To verify your phone number using our automated verification system:</B><br />Call toll free ";
			$funReplaceValue		.= "<font color='#FF8e33'>1-800-3000-2222</font> from the phone number you have provided during registration.  Press 2 on your phone. You will be asked to enter your PIN - <span style='color:#FF8e33;'>".$argPinNo."</span> to complete your verification.<br /><br />";
			$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);
		}

		$funPlaceHolder			= "<--PRODUCTNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funProductName,$this->clsViewTemplate);

		$funPlaceHolder			= "<--UNSUBSCRIBE_LINK-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$unsubscibeLink,$this->clsViewTemplate);
		
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retvalue = $this->sendEmail($funFrom,$funFromEmail,$argReceiverName,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retvalue;
	}

	function sendProfileModificationMail($argMatriId,$argReceiverName,$argReceiverEmail)
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
		
		$funSubject				= "Your profile on ".$funProductName." Matrimony has been successfully modified.";

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/profileModification.tpl"; //do change (template file)
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

		$funPlaceHolder			= "<--PAYNOW-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funServerUrl,$this->clsViewTemplate);

		$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";

		$funPlaceHolder			= "<--PRODUCTNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funProductName,$this->clsViewTemplate);

		$funPlaceHolder			= "<--UNSUBSCRIBE_LINK-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$unsubscibeLink,$this->clsViewTemplate);
		
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
		
		$funSubject				= "Your profile has been modified by ".$funProductName." Matrimony";

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/profileAdminModify.tpl"; //do change (template file)
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

		$funPlaceHolder			= "<--USER-CONTENT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argUserContent,$this->clsViewTemplate);

		$funPlaceHolder			= "<--ADMIN-CONTENT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argAdminContent,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MAILERIMGSPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);

		$LoginRedirectLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=primaryinfo";
		$funPlaceHolder			= "<--LOGIN_REDIRECT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$LoginRedirectLink,$this->clsViewTemplate);

		$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";

		$funPlaceHolder			= "<--PRODUCTNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funProductName,$this->clsViewTemplate);

		$funPlaceHolder			= "<--UNSUBSCRIBE_LINK-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$unsubscibeLink,$this->clsViewTemplate);
		
		$funMessage				= stripslashes($this->clsViewTemplate);

		$retvalue = $this->sendEmail($funFrom,$funFromEmail,$argReceiverName,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retvalue;
	}

	function sendTroubleWithUrProfileMail($argMatriId,$argReceiverName,$argReceiverEmail,$argRecjectComment)
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
		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/troublewithUrProfile.tpl"; //do change (template file)
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