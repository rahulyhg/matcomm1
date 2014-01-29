<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 07 Oct 2008
# End Date	: 07 Oct 2008
# Project		: MatrimonyProduct
# Module		: Reference - MailManager
#=============================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath.'/lib/clsMailManager.php');

class SuccessMailer extends MailManager
{
	//REFER FRIENDS TO VISIT THIS MATRIMONY
	function referFriendMail($argBride,$argGroom,$argFrndEmailId,$argFrndName)
	{
		global $confValues;
		$funFrom					= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "Someone's interested in you finding a life partner! find out who it is!";
		$funServerUrl			= $confValues['SERVERURL'];
		//$funSubject				= "Trouble with your Matrimony Reference information";
		$funTo						= $argFrndName;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/success-stories-newsletter.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);
		$this->mailCommonLinks($funServerUrl);

		$this->clsViewTemplate	= str_replace('<--SERVER_LINK-->',$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--BRIDE-->',$argBride,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--GROOM-->',$argGroom,$this->clsViewTemplate);

		$funToEmail				= $argFrndEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}//referFriendMail
	#------------------------------------------------------------------------------------------------------------
}
?>