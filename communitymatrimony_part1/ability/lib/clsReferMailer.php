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

if($varRootBasePath == ''){ $varRootBasePath = '/home/product/community/ability/www'; }

//INCLUDE FILES
include_once($varRootBasePath.'/lib/clsMailManager.php');

class ReferenceMailer extends MailManager
{
		//REFERENCE REJECTED MAIL
	function referenceRejectedMail($argRefId,$argRefereeName,$argMemberName,$argRejectComments,$argUserEmailId)
	{
		global $confValues;
		$funFrom					= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "Sorry! Your referee contact information has failed.";
		$funServerUrl			= $confValues['SERVERURL'];
		//$funSubject				= "Trouble with your Matrimony Reference information";
		$varAddRefLink		= $funServerUrl.'/login/index.php?redirect=reference/referenceedit.php?rid='.base64_encode($argRefId);
		$funTo						= $argRefereeName;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/reference-rejected.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);
		$this->mailCommonLinks($funServerUrl);

		$this->clsViewTemplate	= str_replace('<--SERVER_LINK-->',$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--ADD_REF_LINK-->',$varAddRefLink,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REFEREE_NAME-->',$funTo,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--USER_NAME-->',$argMemberName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--COMMENTS-->',$argRejectComments,$this->clsViewTemplate);

		$funToEmail				= $argUserEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}//referenceRejectedMail
	#------------------------------------------------------------------------------------------------------------
	//REFERENCE MODIFY MAIL
	function referenceModifyMail($argRefId,$argMemberName,$argRefereeName,$argRejectComments,$argRefereeEmailId,$varRelationship)
	{
		global $confValues;
		$funFrom					= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "Please modify your Matrimony Reference for ".$argMemberName;
		$funServerUrl			= $confValues['SERVERURL'];
		//$funSubject				= "Your ".$argRelationship." ".$argMemberName." has sent you a Matrimony Reference request";
		$varAddRefLink		= $funServerUrl.'/reference/refmailadd.php?rej=yes&rid='.base64_encode($argRefId);
		$funTo						= $argRefereeName;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/reference-modify.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->clsViewTemplate	= str_replace('<--SERVER_LINK-->',$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--ADD_REF_LINK-->',$varAddRefLink,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REFEREE_NAME-->',$funTo,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--MEMBER_NAME-->',$argMemberName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RELATIONSHIP-->',$varRelationship,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--COMMENTS-->',$argRejectComments,$this->clsViewTemplate);

		$funToEmail				= $argRefereeEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}//referenceModifyMail
	#------------------------------------------------------------------------------------------------------------
	function referenceIntimationMail($argRefereeName,$argRefereeEmailId,$argMemberName,$varRelationship)
	{
		global $confValues;
		$funFrom					= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		//$funSubject				= "Request for Matrimony Reference.";
		$funSubject				= ucFirst($argMemberName)." added you as a Matrimony Referee";
		$funServerUrl			= $confValues['SERVERURL'];
		$funTo						= $argRefereeName;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/reference-intimation.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);
		$this->mailCommonLinks($funServerUrl);

		$this->clsViewTemplate	= str_replace('<--SERVER_LINK-->',$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RECEIVER_NAME-->',$funTo,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RELATIONSHIP-->',$varRelationship,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SENDER_NAME-->',$argMemberName,$this->clsViewTemplate);

		$funToEmail				= $argRefereeEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retResult;
	}//referenceModifyMail
	#------------------------------------------------------------------------------------------------------------
 	function referenceAddedAfterReqMail($argMatriId,$varMemberId,$argReceiverEmailId,$argPaidStatus)
	{
		global $confValues;
		$funSenderName			= $this->displayName($argMatriId);
		$funFrom				= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funServerUrl			= $confValues['SERVERURL'];
		$funSubject				= $funSenderName." has added Matrimony Reference on your request.";
		//$funSubject			= "Your ".$argRelationship." ".$argMemberName." has sent you a Matrimony Reference request";
		$varPaymentLink			= $funServerUrl.'/login/index.php?redirect=payment';
		$varProfileViewLink		= $funServerUrl.'/login/index.php?redirect=profiledetail/index.php?act=viewprofile~id='.$argMatriId;
		$funReceiverName		= $this->displayName($varMemberId);
		$funTo					= $funReceiverName;

		if($argPaidStatus==1)
			$varTemplateFileName= $confValues['MAILTEMPLATEPATH']."/ref-added-intimat-paid.tpl"; //do change (template file)
		else
			$varTemplateFileName= $confValues['MAILTEMPLATEPATH']."/ref-added-intimat-free.tpl"; //do change (template file)


		$funDispBasic			= $this->mailBasicDetails($argMatriId,$funServerUrl,1);
		$funDispInbox			= $this->inboxstatistics($varMemberId,'Added');
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);
		$this->mailCommonLinks($funServerUrl);
		$this->profileCompleteAlgor($varMemberId);

		$this->clsViewTemplate	= str_replace('<--BASIC-PROFILE-->',$funDispBasic,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--INBOX-MSG-->',$funDispInbox,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SERVER_LINK-->',$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--LOGIN_REF_LINK-->',$varProfileViewLink,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--PAYMENT_LINK-->',$varPaymentLink,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RECEIVER_NAME-->',$funReceiverName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SENDER_NAME-->',$funSenderName,$this->clsViewTemplate);

		$funToEmail				= $argReceiverEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}//referenceModifyMail
	#------------------------------------------------------------------------------------------------------------
	//REFERENCE ADDED MAIL
	function referenceAddedMail($argRefereeName,$argMemberName,$argMemberComments,$argUserEmailId,$argRelationship)
	{
		global $confValues;
		$funFrom					= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= $argRefereeName." has added Matrimony Reference to your profile.";
		$funServerUrl			= $confValues['SERVERURL'];
		//$funSubject				= "Matrimony Reference added to your profile by your ".$argRelationship." ".$argMemberName;
		$varAddRefLink		= $funServerUrl.'/login/index.php?redirect=tools/index.php?add=reference';
		$funTo						= $argRefereeName;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/reference-added.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolderUrl		= "<--SERVER_LINK-->";
		$funReplaceValueUrl		= $funServerUrl;
		$this->clsViewTemplate	= str_replace($funPlaceHolderUrl,$funReplaceValueUrl,$this->clsViewTemplate);

		$funAddRefUrl			= "<--ADD_REF_LINK-->";
		$funReplaceAddRefUrl	= $varAddRefLink;
		$this->clsViewTemplate	= str_replace($funAddRefUrl,$funReplaceAddRefUrl,$this->clsViewTemplate);

		$funPlaceHolder			= "<--REFEREE_NAME-->";
		$funReplaceValue		= $funTo;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolderMember	= "<--USER_NAME-->";
		$funReplaceValueMember	= $argMemberName;
		$this->clsViewTemplate	= str_replace($funPlaceHolderMember,$funReplaceValueMember,$this->clsViewTemplate);

		$funPlaceHolderComts	= "<--COMMENTS-->";
		$funReplaceValueComts	= $argMemberComments;
		$this->clsViewTemplate	= str_replace($funPlaceHolderComts,$funReplaceValueComts,$this->clsViewTemplate);

		$funToEmail				= $argUserEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}//referenceAddedMail
	#------------------------------------------------------------------------------------------------------------
	//REFERENCE APPROVED MAIL
	function referenceApprovedMail($argMemberName,$argRefereeName,$argRefereeEmailId,$argRelationship)
	{
		global $confValues;
		$funFrom					= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSubject				= "Your Matrimony Reference has been posted.";
		$funServerUrl			= $confValues['SERVERURL'];
		//$funSubject				= "Thank you for your Matrimony Reference for your ".$argRelationship." ".$argMemberName;
		$varAddRefLink		= $funServerUrl.'/login/index.php?redirect=tools/index.php?add=reference';
		$funTo						= $argRefereeName;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/reference-approved.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->clsViewTemplate	= str_replace('<--SERVER_LINK-->',$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--REFEREE_NAME-->',$funTo,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--MEMBER_NAME-->',$argMemberName,$this->clsViewTemplate);

		$funToEmail				= $argRefereeEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}//referenceApprovedMail
		#------------------------------------------------------------------------------------------------------------
	//INVITE REFERENCE MAIL
	function inviteReferenceMail($argRefId,$argRefereeName,$argRelationship,$argMemberId,$argMemberComments,$argRefereeEmailId)
	{
		global $confValues;
		$funFrom					= $confValues['FROMMAIL'];
		$funFromEmail			= $confValues['INFOEMAIL'];
		$funReplyToEmail		= $confValues['HELPEMAIL'];
		$funSenderName		= $this->displayName($argMemberId);
		$funSubject				= "Request for Matrimony Reference from ".$funSenderName;
		$funServerUrl			= $confValues['SERVERURL'];
		//$funSubject				= "Your ".$argRelationship." ".$argMemberName." has sent you a Matrimony Reference request";
		$varAddRefLink		= $funServerUrl.'/reference/refmailadd.php?rid='.base64_encode($argRefId);
		$funTo						= $argRefereeName;

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/reference-invite.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$this->clsViewTemplate	= str_replace('<--SERVER_LINK-->',$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--ADD_REF_LINK-->',$varAddRefLink,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RECEIVER_NAME-->',$funTo,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--RELATIONSHIP-->',$argRelationship,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--SENDER_NAME-->',$funSenderName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace('<--COMMENTS-->',$argMemberComments,$this->clsViewTemplate);

		$funToEmail				= $argRefereeEmailId;
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}//inviteReferenceMail
	#------------------------------------------------------------------------------------------------------------
}
?>