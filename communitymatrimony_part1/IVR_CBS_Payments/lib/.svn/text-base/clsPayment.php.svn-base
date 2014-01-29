<?php

//INCLUDE FILES
$_CBS_IncludeFolder	= '/var/home/bharatmatrimony/www/ivrspayment/cbs';
//$_CBS_IncludeFolder	= '/home/product/community/www/IVR_Cbs_Payment';
include_once($_CBS_IncludeFolder.'/conf/config.cil14');
include_once($_CBS_IncludeFolder.'/conf/emailsconfig.cil14');
include_once($_CBS_IncludeFolder.'/conf/domainlist.cil14');
include_once($_CBS_IncludeFolder.'/conf/vars.cil14');
include_once($_CBS_IncludeFolder.'/lib/clsMailManager.php');
	
class Payment extends MailManager {

	function paymentConfirmation($argMatriId,$argName,$argEmail,$argProductId,$argAmount,$argPaymentMode,$argPaymentType,$argExpires,$argIP,$argOfferProductId,$varTotalPhone='',$varProfileHighlighter='') {

		global $confValues,$arrPrdPackages,$arrPhonePackage,$arrPaymentType,$arrPaymentMode;
		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);

		if ($argOfferProductId >0 ) { $argProductId = $argOfferProductId;  }

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['HELPEMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];
		$funBranch				= '';	

		$funSubject				= "Profile has been upgraded on ".$funProductName." Matrimony";
		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/paymentConfirmation.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MAILERIMGPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);

		$funPlaceHolder			= "<--SERVER_URL-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funServerUrl,$this->clsViewTemplate);

		$funPlaceHolder			= "<--NAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argName,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MATRIID-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argMatriId,$this->clsViewTemplate);

		$funPlaceHolder			= "<--AMOUNT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argAmount,$this->clsViewTemplate);

		$funPlaceHolder			= "<--PACKAGENAME-->";
		if($varProfileHighlighter==1){
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$arrPrdPackages[$argProductId].' with Profile Highlighter Package',$this->clsViewTemplate);
		}else{
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$arrPrdPackages[$argProductId],$this->clsViewTemplate);
		}

		$funPlaceHolder			= "<--PHONECOUNT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$varTotalPhone,$this->clsViewTemplate);

		$funPlaceHolder			= "<--VALIDITYPERIOD-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argExpires,$this->clsViewTemplate);

		if ($argPaymentType >0) {

			$funBranch		= '<tr><td width="175" align="right" style="padding-right:15px;font:normal 12px arial;color:#333333;" height="25">Payment Made Through:</td><td width="310" align="left" style="font:normal 12px arial;color:#333333;font-weight:bold;">'.$arrPaymentType[$argPaymentType].'</td></tr>';
		}

		if ($argPaymentMode >0) {
			$funPaymentMode	= '<tr><td width="175" align="right" style="padding-right:15px;font:normal 12px arial;color:#333333;" height="25">Mode of payment:</td><td width="310" align="left" style="font:normal 12px arial;color:#333333;font-weight:bold;">'.$arrPaymentMode[$argPaymentMode].'</td></tr>';
		}

		$funPlaceHolder			= "<--BRANCH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funBranch,$this->clsViewTemplate);

		$funPlaceHolder			= "<--PAYMENTMODE-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funPaymentMode,$this->clsViewTemplate);

		$funPlaceHolder			= "<--HELP_EMAIL-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funHelpEmail,$this->clsViewTemplate);

		$this->clsViewTemplate	=  str_replace("<--PRODUCT_NAME-->",$funProductName,$this->clsViewTemplate);

	
		/*if ($argIp='IN') {

			$varMatrimonyDay='<tr><td valign="top" width="536" style="font:normal 12px arial;color:#333333;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:10px;"><img src="'.$funServerUrl.'/mailer/images/dot-line.gif"><br><a target="_blank" class="clr1" href="http://www.matrimonyday.org/homeindex.php?id='.$argMatriId.'" style="font:normal 12px arial;color:#E01D01;text-decoration:none;">Click here</a> to add your views on Matrimony Day and win a Titan Watch<br> or an Estelle Necklace Set.<br><br>We also have tons of offers and discounts from leading brands exclusively for you.<br><a class="clr1" target="_blank" href="'.$funServerUrl.'/site/index.php?act=matrimonyday-offers" style="font:normal 12px arial;color:#E01D01;text-decoration:none;">Click here to avail them.</a></td></tr>';

		} else { $varMatrimonyDay=''; }

		$this->clsViewTemplate	=  str_replace("<--MATRIMONY_DAY-->",$varMatrimonyDay,$this->clsViewTemplate);*/
		$this->clsViewTemplate	=  str_replace("<--MATRIMONY_DAY-->",'',$this->clsViewTemplate);


		$funToEmail				= $argEmail;//$this->getEmail($argMatriId);
		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;

	}//paymentConfirmation


	function privilegeMail($argMatriId,$argName,$argMail,$argDate) {

		global $confValues,$arrPrdPackages,$arrPhonePackage,$arrPaymentType,$arrPaymentMode;
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
		$funBranch				= '';

		  $funMessage = "<html><body><font face=Arial size=2>Dear Superadmin,</font><br><br>";
		  $funMessage .= "<font face=Arial size=2>This is to inform you that a member ($argMatriId) has opted for personalised service by paying for the privilege package. The details are as follows.</font><br><br>";
		  $funMessage .= "<font face=Arial size=2><b>Member Name:</b> $argName </font><br>";
		  $funMessage .= "<font face=Arial size=2><b>Member ID:</b> $argMatriId</font><br>";
		  $funMessage .= "<font face=Arial size=2><b>E-mail ID:</b> $argMail</font><br><br>";
		  $funMessage .= "<font face=Arial size=2><b>Date of Joining:</b> $argDate</font><br><br>";
		  $funMessage .= "<font face=Arial size=2>Best Regards,</font><br>";
		  $funMessage .= "<font face=Arial size=2>Team CommunityMatrimony.Com</font><br>";
		  $funMessage .= "</body></html>";

		$funTo		= 'Privilege Superadmin';
		$funToEmail	= 'privilegesuperadmin@bharatmatrimony.com';
		$funSubject	= "CBS Privilege Package - Member($argMatriId)";

		$this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

	}


}//payment

?>