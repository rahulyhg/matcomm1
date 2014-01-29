<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 07 Oct 2008
# End Date	: 07 Oct 2008
# Project		: MatrimonyProduct
# Module		: Request - MailManager
#=============================================================================================================

//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

if($varRootBasePath == ''){ $varRootBasePath = '/home/product/community/www'; }

//INCLUDE FILES
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath."/lib/clsCryptDetail.php");	//For MatriId Encryption

class RequestMailer extends MailManager
{
	//REQUEST PHOTO MAIL
	function sendRequestMail($argMatriId,$varMemberId,$argReceiverEmail,$argRequestId)
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
		$funMailerImgsURL		= $arrGetProductInfo['SERVERURL'].'/mailer/images';

		$funReceiverDate		= date("d-m-y");
		$funReceiverName		= $this->displayName($varMemberId);
		$funSenderName			= $this->displayName($argMatriId);
		$funTo					= $funReceiverName;
		
		//For CBS-Autologin	--> GOKILAVANAN.R(FEB-10-2011)
		$varAutoLogin	  = CryptDetail::mclink($varMemberId,'reqM');  // For autologin
		
		switch($argRequestId) {
			case 1: 
				$funRequestType = "Photo";
				$funSubject		= "A photo request from ".$funProductName."Matrimony.com.";
				$varAddLink		= $funServerUrl."/login/intermediatelogin.php?redirect=".$funIMGServerPath.'/photo/index.php?act=addphoto';
				$funReqContent	= "This member is interested in knowing more<br />about you and therefore wants to view your<br />photo.<br /><br />Profiles with photos get the best response.";
				$varRecGender	= $this->getGender($varMemberId);

				if($varRecGender == 1) {
					$varPhotoImg = "request-photo-male.gif";
				} else {
					$varPhotoImg = "request-photo.gif";
				}
				$funReqImage	= $funMailerImagePath."/".$varPhotoImg;
				$funUrlCaption	=	"Add Photo";
				break;

			case 3: 
				$funRequestType = "Phone";
				$funSubject		= "A phone request from ".$funProductName."Matrimony.com.";
				$varAddLink		= $funServerUrl."/login/intermediatelogin.php?redirect=".$funServerUrl.'/profiledetail/index.php?act=primaryinfo';
				$funReqImage	= $funMailerImagePath."/request-phone.gif";
				$funReqContent	= "This member is interested in contacting you<br /> and therefore wants to view your phone<br /> number.<br /><br />Verify your phone number today.<br />By verifying your phone number, members<br />interested in you can contact you directly.";
				$funUrlCaption	=	"Verify Your Phone Number";
				break;

			case 5: 
				$funRequestType = "Horoscope";
				$funSubject		= "A horoscope request from ".$funProductName."Matrimony.com.";
				$varAddLink		= $funServerUrl."/login/intermediatelogin.php?redirect=".$funIMGServerPath.'/horoscope/index.php?act=addhoroscope';
				$funReqImage	= $funMailerImagePath."/request-horoscope.gif";
				$funReqContent	= "This member is interested in knowing more<br />about you and therefore wants to view your<br />horoscope.<br />By adding horoscope, you can view your<br /> horoscope compatibility score with other<br />members.";
				$funUrlCaption	=	"Add Horoscope";
				break;
		}

		//For CBS-Autologin	--> GOKILAVANAN.R(FEB-10-2011)
		$varAddLink		.=	'&'.$varAutoLogin;
		
		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/request.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->clsViewTemplate	= str_replace('<--MAILERIMGSPATH-->',$funMailerImgsURL,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--DATE_RECEIVED-->',$funReceiverDate,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SENDER_NAME-->',$funSenderName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SENDER_ID-->',$argMatriId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REQ_TYPE-->',$funRequestType,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REQ_IMAGE-->',$funReqImage,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--ADD_LINK-->',$varAddLink,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REQ_CONTENT-->',$funReqContent,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RECEIVER_ID-->',$varMemberId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--URL_CAPTION-->',$funUrlCaption,$this->clsViewTemplate);

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
	}//sendRequestPhotoMail
}
?>