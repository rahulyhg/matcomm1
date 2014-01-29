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

class PhoneSupport extends MailManager {
	public $funLinkColor	= '';
	public $funMailerTplPath= '';

	//REQUEST PHOTO MAIL
	function sendPhoneSupportMail($argComplaintOn,$argComplaintByTot,$argComplaintTag,$agrValidRequest) {
		global $confValues,$arrMailerLinkClr,$arrMailerTplFolder;

		$arrGetProductInfo		= $this->getDomainDetails($argComplaintOn);
		$arrGetEmailInfo		= $this->getDomainEmailList($argComplaintOn);
		$argDomainPrefix		= substr($argComplaintOn,0,3);

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['NOREPLYMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argComplaintOn);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];
		$varMailerTplPath		= ($arrMailerTplFolder[$argDomainPrefix]!='')?('/'.$arrMailerTplFolder[$argDomainPrefix]):'';
		$this->funMailerTplPath	= '/home/product/community/www/mailer/templates'.$varMailerTplPath;

		$arrComplaintBy			= explode('~',$argComplaintByTot);

		if($agrValidRequest==1) {
			switch($argComplaintTag) {
				case 1 : //Phone no is not working
					$funSubject		= "The member's phone number is not working ";
					$funTplHeading	= "The member's phone number is not working ";
					$funTplBody		= "<tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:30px;padding-left:10px;padding-right:10px;'>Dear <--RECEIVER_NAME-->,<br /><br />Thank you for bringing to our notice that the phone number of ".$argComplaintOn." is not working. We called and confirmed that the number is not in use anymore. However, note that you will get an additional phone number in place of this number!</td></tr> <tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:20px;padding-left:10px;padding-right:10px;padding-bottom:20px;'>Continue to call prospects on phone to find your life partner sooner!</td></tr> ";
					break;
				case 2 : //Phone no has changed
					$funSubject		= "The member's phone number is changed";
					$funTplHeading	= "The member's phone number is changed";
					$funTplBody		= "<tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:30px;padding-left:10px;padding-right:10px;'>Dear <--RECEIVER_NAME-->,<br /><br />Thank you for bringing to our notice that the phone number of ".$argComplaintOn." is changed. We called and confirmed that the number is not in use anymore. However, note that you will get an additional phone number in place of this number!</td></tr> <tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:20px;padding-left:10px;padding-right:10px;padding-bottom:20px;'>Continue to call prospects on phone to find your life partner sooner!</td></tr>";
					break;
				case 3 : //married
					$funSubject		= "The member has got married";
					$funTplHeading	= "The member has got married";
					$funTplBody		= "<tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:30px;padding-left:10px;padding-right:10px;'>Dear <--RECEIVER_NAME-->,<br /><br />Thank you for bringing to our notice that ".$argComplaintOn."  has already got married. We called and confirmed with the member. This  member's profile will soon be removed from our database.</td></tr> <tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:20px;padding-left:10px;padding-right:10px;padding-bottom:20px;'>Note that you will get an additional phone number in place of this number!</td></tr> ";
					break;
			}
		} else if($agrValidRequest==2){

			switch($argComplaintTag) {
				case 1 : //Phone no is working
					$funSubject		= "The member's phone number is working!";
					$funTplHeading	= "The member's phone number is working!";
					$funTplBody		= "<tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:30px;padding-left:10px;padding-right:10px;'>Dear <--RECEIVER_NAME-->,<br /><br />This is to inform you that the phone number of ".$argComplaintOn." is working. We called to confirm with the member and also came to know that the member is not married yet!</td></tr> <tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:20px;padding-left:10px;padding-right:10px;padding-bottom:20px;'>We advise you to try and reach this member once more as ".$argComplaintOn." might be a potential prospect for you!</td></tr> ";
					break;
				case 2 : //Phone no has not changed
					$funSubject		= "The member's phone number is not changed!";
					$funTplHeading	= "The member's phone number is not changed!";
					$funTplBody		= "<tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:30px;padding-left:10px;padding-right:10px;'>Dear <--RECEIVER_NAME-->,<br /><br />This is to inform you that the phone number of ".$argComplaintOn." has not been changed and is working. We called to confirm with the member and also came to know that the member is not married yet!</td></tr><tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:20px;padding-left:10px;padding-right:10px;padding-bottom:20px;'>We advise you to try and reach this member once more as ".$argComplaintOn." might be a potential prospect for you! </td></tr>";
					break;
				case 3 : //not married
					$funSubject		= "The member ".$argComplaintOn." is not married!";
					$funTplHeading	= "The member ".$argComplaintOn." is not married!";
					$funTplBody		= "<tr><td valign='top' width='496' style='font:normal 12px arial;color:#333333;text-align:justify;padding-top:30px;padding-left:10px;padding-right:10px;padding-bottom:20px;'>Dear <--RECEIVER_NAME-->,<br /><br />We wish to bring to your notice that the member ".$argComplaintOn." is not married yet. We called and confirmed with the member.  We advise you to try and reach this member once again as ".$argComplaintOn." might be a potential prospect for you!</td></tr>";
					break;
			}
		}
		
		$varTemplateFileName	= $this->funMailerTplPath."/phone_support.tpl";
		$this->clsViewTemplate	= '';
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);
		$funPlaceHolder			= "<--MAILER-IMAGE-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);
		$funPlaceHolder			= "<--TPL_HEADING-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funTplHeading,$this->clsViewTemplate);
		$funPlaceHolder			= "<--TPL_BODY-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funTplBody,$this->clsViewTemplate);
		$funPlaceHolder			= "<--TPL_HELP_EMAIL-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funHelpEmail,$this->clsViewTemplate);
		$funPlaceHolder			= "<--SERVERURL-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funServerUrl,$this->clsViewTemplate);
		$funPlaceHolder			= "<--PRODUCTNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funProductName,$this->clsViewTemplate);
		$unsubscibeLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		$funPlaceHolder			= "<--UNSUBSCRIBE_LINK-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$unsubscibeLink,$this->clsViewTemplate);

		foreach($arrComplaintBy as $key=>$varComplaintById) {
			$funReceiverName		= $this->displayName($varComplaintById);
			$funTo					= $funReceiverName;
			$argReceiverEmail		= $this->getEmail($varComplaintById);

			$funPlaceHolder			= "<--RECEIVER_NAME-->";
			$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReceiverName,$this->clsViewTemplate);

			$funMessage				= stripslashes($this->clsViewTemplate);
			$funMessage;
			$this->sendEmail($funFrom,$funFromEmail,$funTo,$argReceiverEmail,$funSubject,$funMessage,$funReplyToEmail);
		}
	}//sendRequestPhotoMail
}
?>