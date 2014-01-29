<?php
$_CBS_IncludeFolder	= '/var/home/bharatmatrimony/www/ivrspayment/cbs';
//$_CBS_IncludeFolder	= '/home/product/community/www/IVR_Cbs_Payment';

//INCLUDE FILES
include_once($_CBS_IncludeFolder."/conf/config.cil14");
include_once($_CBS_IncludeFolder.'/conf/emailsconfig.cil14');
include_once($_CBS_IncludeFolder.'/conf/domainlist.cil14');
include_once($_CBS_IncludeFolder.'/conf/dbinfo.cil14');
include_once($_CBS_IncludeFolder.'/conf/vars.cil14');
include_once($_CBS_IncludeFolder.'/lib/clsDB.php');

class MailManager extends DB
{
	public $clsViewTemplate	= "";

	function getDomainDetails($argMatriId){
		global $arrPrefixDomainList,$arrMailerTplFolder;

		$arrDomainDetail	= array();
		$varPrefix			= substr($argMatriId,0,3);
		$varDomainName		= $arrPrefixDomainList[$varPrefix];
		$varMailerTplPath	= $arrMailerTplFolder[$varPrefix];
		$arrDomainDetail['PRODUCTNAME']	= ucfirst(str_replace('matrimony.com','',$varDomainName));
		$arrDomainDetail['FROMADDRESS']	= $arrDomainDetail['PRODUCTNAME'].' Matrimony.Com';
		$arrDomainDetail['SERVERURL']	= 'http://www.'.$varDomainName;
		$arrDomainDetail['MAILERIMGURL']= 'http://www.'.$varDomainName.'/mailer/images';
		$arrDomainDetail['IMGURL']		= 'http://img.'.$varDomainName.'/images';
		$arrDomainDetail['IMGSERVERURL']= 'http://img.'.$varDomainName;
		$arrDomainDetail['IMAGEURL']= 'http://image.'.$varDomainName;
		$varMailerTplPath				= ($varMailerTplPath!='')?$varMailerTplPath.'/':'';
		$arrDomainDetail['MAILERTPLPATH']= '/var/home/bharatmatrimony/www/ivrspayment/cbs/mailer/templates/'.$varMailerTplPath;
		return $arrDomainDetail;
	}

	function getDomainEmailList($argMatriId){
		global $arrEmailsList,$arrPrefixDomainList;
		$varPrefix			= substr($argMatriId,0,3);
		$varDomainName		= $arrPrefixDomainList[$varPrefix];
		
		$arrDomainEmails	= array();
		foreach($arrEmailsList as $funKey=>$funVal){
			$arrEmailDet	= explode('@',$funVal);
			$arrDomainEmails[$funKey]	= $arrEmailDet[0].'@'.$varDomainName;
		}
		return $arrDomainEmails;
	}

	function getFolderName($argMatriId) {
		global $arrFolderNames;
		$varPrefix			= substr($argMatriId,0,3);
		$funFolderName		= $arrFolderNames[$varPrefix];
		return $funFolderName;
	}

	function getContentFromFile($argFileName){
		if(!file_exists($argFileName))
			echo 'Error: This file does not exist.';
		else
			return trim(file_get_contents($argFileName));
	}
	
	function sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress)
	{
		$funValue				= '';
		$funheaders				= '';
		$argFrom				= preg_replace("/\n/", "", $argFrom);
		$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
		$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
		$funheaders				.= "MIME-Version: 1.0\n";
		$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
		$funheaders				.= "Reply-To: ".$argFrom."<".$argReplyToEmailAddress.">\n";
		$funheaders				.= "Return-Path: <noreply@bounces.communitymatrimony.com>\n";
		$funheaders				.= "Sender:".$argFrom."<".$argFromEmailAddress.">\n";
		$argheaders				= $funheaders;
		$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);

		if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if

		return $funValue;
	}
	
	function sendMigrationEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress)
	{
		$funValue				= '';
		$funheaders				= '';
		$argFrom				= preg_replace("/\n/", "", $argFrom);
		$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
		$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
		$funheaders				.= "MIME-Version: 1.0\n";
		$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
		$funheaders				.= "Reply-To: ".$argReplyToEmailAddress."\n";
		$funheaders				.= "Return-Path: <noreply@bounces.communitymatrimony.com>\n";
		$funheaders				.= "Sender:".$argFrom."<".$argFromEmailAddress.">\n";
		$argheaders				= $funheaders;
		$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);

		if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
		
		return $funValue;
	}

	function displayName($argMatriId){
		global $varTable;
		$funMemFlds	= array('Nick_Name','Name');
		$funCond	= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
		$funMemInf  = $this->select($varTable['MEMBERINFO'],$funMemFlds,$funCond,1);
		$funName	= ($funMemInf[0]['Nick_Name']!='') ? $funMemInf[0]['Nick_Name'] : $funMemInf[0]['Name'];
		return ucfirst($funName);
	}
	
	function getHeightInFeet($argHeightInCms){
		$funConvertFeet		= floor($argHeightInCms /(12*2.54));
		$funConvertInchs	= floor(($argHeightInCms - ($funConvertFeet*12*2.54))/2.54);
		$funConvertInchs	= ($funConvertInchs > 0)? $funConvertInchs.'in':'';
		$retHeightInFeet    = $funConvertFeet.'ft '.$funConvertInchs;
		$retHeightInFeet   .= " / ".round($argHeightInCms)."cm";
		return $retHeightInFeet;
	}
	
	function getDeleteName($argOppositeId){
		global $varTable;
		$funMemFlds	= array('Name');
		$funCond	= "WHERE MatriId=".$this->doEscapeString($argOppositeId,$this);
		$funMemInf  = $this->select($varTable['MEMBERDELETEDINFO'],$funMemFlds,$funCond,1);
		return $funMemInf[0]['User_Name'];
	}

	function getINDTollFree($argMatriId){
		global $varTable, $arrMailerLinkClr;
		$funCond	= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this)." AND Country=98";
		$funInf		= $this->numOfRecords($varTable['MEMBERINFO'],'MatriId',$funCond);
		$funCont	= '';
		if($funInf > 0){
		$funMatriIdPre = substr($argMatriId,0,3);
		$funLinkClr	   = array_key_exists($funMatriIdPre, $arrMailerLinkClr) ? $arrMailerLinkClr[$funMatriIdPre] : '#FF6000';
		$funCont	= '<tr><td width="536"><table border="0" cellspacing="0" cellpadding="0" width="477" align="center">
		   <tr><td background="<--MAILERIMGSPATH-->/tollfree.gif" height="61" style="padding-left:85px;font:normal 12px arial;color:#606060;">Need help? Call <font style="font-size:20px;font-weight:bold;">1800-3000-2222</font> (Toll Free)<br>or <a href="<--SERVERURL-->/site/index.php?act=LiveHelp" style="color:'.$funLinkClr.';text-decoration:none;">Chat Live</a> with a customer care person.</td></tr></table></td></tr><tr><td height="15"></td></tr>';
		}
		return $funCont;
	}

	//FORGOT PASSWORD MAIL
	function sendForgotPasswordMail($argMatriId,$argPassword,$argToEmail)
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
		
		$funSubject				= "Your login information from ".$funProductName."Matrimony.com";

		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/forgotPassword.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MATRIID-->";
		$funReplaceValue		= $argMatriId;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--PASSWORD-->";
		$funReplaceValue		= $argMatriId;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argPassword,$this->clsViewTemplate);

		$funPlaceHolder			= "<--LOGIN-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funServerUrl,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MAILERIMGSPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);

		$funPlaceHolder			= "<--SMALL_CASE_PRODUCT-->";
		$funReplaceValue		= strtolower($funProductName);
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--PRODUCTNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funProductName,$this->clsViewTemplate);
		
		$unsubscibeLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		$funPlaceHolder			= "<--UNSUBSCRIBE_LINK-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$unsubscibeLink,$this->clsViewTemplate);

		$funMessage				= stripslashes($this->clsViewTemplate);
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$argMatriId,$argToEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retResult;
	}
	
	function getPhoto($argOppositeId,$funPhotoSetStatus='',$funPhotoProtected='',$varBasicGender='')
	{
		global $varTable,$confValues;
		$funPhotoPath	= "";
		$funOppositeId	= $argOppositeId;

		if ($funPhotoSetStatus ==1){
			$funFirstFolder		= $funOppositeId{1};
			$funSecondFolder	= $funOppositeId{2};
			$funFields			= array('MatriId','Normal_Photo1','Thumb_Small_Photo1','Photo_Status1');
			$funCondition		= "WHERE MatriId =".$this->doEscapeString($argOppositeId,$this);
			$resPhotoIdsDet		= $this->select($varTable['MEMBERPHOTOINFO'], $funFields, $funCondition, 1);
			if ($funPhotoProtected==1)
			$funPhotoPath.=$confValues['SERVERURL'].'/mailer/images/photoprotect.gif'; // Display Protectd Photo.
			else				$funPhotoPath.=$confValues['PHOTOURL'].'/'.$funOppositeId{1}.'/'.$funOppositeId{2}.'/'.$resPhotoIdsDet[0]["Normal_Photo1"];
		}//if
		else { 
			if($varBasicGender==2) { $funReqMPhoto = 'reqphotof.gif'; } else { $funReqMPhoto = 'reqphotom.gif'; }
			$funPhotoPath	.= $confValues['SERVERURL'].'/mailer/images/'.$funReqMPhoto; 
		}//else
		$retfunPhotoPath = $funPhotoPath;
		return trim($retfunPhotoPath);
	}//getPhoto

	function listAwaitingMembers($argMatriId,$argServerUrl,$argAwaitingPurpose)
	{
		global $varTable;
		if($argAwaitingPurpose=='Salaam')
		{
			$funFields		= array('MatriId','Interest_Option');
			$funCondition	= "WHERE Opposite_MatriId=".$this->doEscapeString($argMatriId,$this)." AND Status=0 ORDER BY Date_Received DESC LIMIT 0,2";
			$resQuery		= $this->select($varTable['INTERESTRECEIVEDINFO'], $funFields, $funCondition, 0);
		}
		else if($argAwaitingPurpose=='Message')
		{
			$funFields		= array('MatriId','Mail_Message');
			$funCondition	= "WHERE Opposite_MatriId=".$this->doEscapeString($argMatriId,$this)." AND Status=1 ORDER BY Date_Received DESC";
			$resQuery		= $this->select($varTable['MAILRECEIVEDINFO'], $funFields, $funCondition, 0);
		}

		$funNumOfRows			= mysql_num_rows($resQuery);
		if($funNumOfRows > 0)
		{
			$funDispTemplate .= '<table cellpadding="0" cellspacing="0" width="100%">';
			$funFlag=0;
			while($row = mysql_fetch_array($resQuery))
			{
				$funDispTemp=$this->mailBasicDetails($row['MatriId'],$argServerUrl,1);

				if($funFlag%2==0) { $funDispTemplate  .= "<tr><td><div style='width:270px;padding:5px;' align='center' >".$funDispTemp."</div></td>"; }
				else {
					$funDispTemplate  .= "<td><div style='width:270px;padding:5px;' align='center'>".$funDispTemp."</div></td></tr>";
				}//else
				$funFlag++;
			}//while
			$funDispTemplate  .= '</table>';
		}//if
		$this->clsViewTemplate = $funDispTemplate;

		return $this->clsViewTemplate;
	}

	function listUnReadMessages($argMatriId,$argServerUrl)
	{
		global $varTable;

		$funFields		= array('MatriId','Mail_Message');
		$funCondition	= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this)." AND Status=0 ORDER BY Date_Received DESC";
		$resQuery		= $this->select($varTable['MAILRECEIVEDINFO'], $funFields, $funCondition, 0);
		$funNumOfRows	= mysql_num_rows($resQuery);

		if($funNumOfRows > 0)
		{
			while($row = mysql_fetch_array($resQuery))
			{
				$funDispBasic=$this->mailBasicDetails($row['MatriId'],$argServerUrl,1);
				$funDisplayBasicVal .= '<table cellpadding="0" cellspacing="0" width="100%"><tr><td><div style="padding:5px;" align="center" >'.$funDispBasic.'</div></td></tr></table>';
			}//while
		}//if

		return $funDisplayBasicVal;
	}
	
	function getEmail($argOppositeId){
		global $varTable;
		$funMemFlds	= array('Email');
		$funCond	= "WHERE MatriId=".$this->doEscapeString($argOppositeId,$this);
		$funMemInf  = $this->select($varTable['MEMBERLOGININFO'],$funMemFlds,$funCond,1);
		return $funMemInf[0]['Email'];
	}
	
	function getMobileNo($argMatriId='') {
		global $varTable;
		$varMobileNo = '';
		if ($argMatriId!='') {
			$funMemFlds = array('Contact_Mobile','Phone_verified');
			$funCond	= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
			$funMemInf  = $this->select($varTable['MEMBERINFO'],$funMemFlds,$funCond,1);
			$varPhoneVerified = $funMemInf[0]['Phone_verified'];
					   
			if(($varPhoneVerified==1) || ($varPhoneVerified==2) || ($varPhoneVerified==3)) {
				$MobileFields = array('MobileNo'); 
				$arrMobileNo  = $this->select($varTable['ASSUREDCONTACT'],$MobileFields,$funCond,1);
				$varMobileNo  = $arrMobileNo[0]['MobileNo'];
		    } else {
				$varPhoneNo   = preg_replace('/^(91~91|91-91|91~|91-)/', '',$funMemInf[0]['Contact_Mobile']);
				$varMobileNo  = preg_replace("/([^\d]+|^0)/s","",$varPhoneNo);
		    }
	    }
		return $varMobileNo;
	}
 
	function getPaidStatus($argMatriId){
		global $varTable;
		$funMemFlds	= array('Paid_Status');
		$funCond	= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
		$funMemInf  = $this->select($varTable['MEMBERINFO'],$funMemFlds,$funCond,1);
		return $funMemInf[0]['Paid_Status'];
	}

	function getGender($argMatriId) {
		global $varTable;
		$funMemFlds	= array('Gender');
		$funCond	= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
		$funMemInf  = $this->select($varTable['MEMBERINFO'],$funMemFlds,$funCond,1);
		return $funMemInf[0]['Gender'];
	}

	function sendProfileDeletedMail($argMatriId,$argReceiverName,$argServerUrl)
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

		$funSubject				= "Your profile has been successfully deleted from ".$funProductName." Matrimony";
		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/profileDeleted.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MAILERIMGSPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);

		$funPlaceHolder			= "<--RECEIVER_MATRIID-->";
		$funReplaceValue		= $argMatriId;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--RECEIVER_NAME-->";
		$funReplaceValue		= $argReceiverName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--SMALL_CASE_PRODUCT-->";
		$funReplaceValue		= strtolower($funProductName);
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--SERVER_URL-->";
		$funReplaceValue		= $funServerUrl;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$this->clsViewTemplate	=  str_replace("<--PRODUCT_NAME-->",$funProductName,$this->clsViewTemplate);

		$funToEmail				= $this->getEmail($argMatriId);
		$funMessage				= stripslashes($this->clsViewTemplate);

		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;
	}
	
	function dateDiff($argDateSeparator, $argCurrentDate, $argPaidDate){
		$funArrPaidDate		= explode($argDateSeparator, $argPaidDate);
		$funArrCurrentDate	= explode($argDateSeparator, $argCurrentDate);
		$funStartDate		= gregoriantojd($funArrPaidDate[0], $funArrPaidDate[1], $funArrPaidDate[2]);
		$funEndDate			= gregoriantojd($funArrCurrentDate[0], $funArrCurrentDate[1], $funArrCurrentDate[2]);
		return $funEndDate - $funStartDate;
	}
	
	function sendNotifyEmail($argTo,$argMessage,$argSubject,$argMatriId){
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

		$funValue		= "";
		if($argSubject!='') {
			$varSubject	= $argSubject;
		} else {
		$varSubject		= "Your profile has been modified by ".$funFrom;
		}
		$funheaders		= "MIME-Version: 1.0\n";
		$funheaders		.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders		.= "From: ".$funFrom." <".$funReplyToEmail.">\n";
		$argheaders		= $funheaders;
		if (mail($argTo, $varSubject, $argMessage, $argheaders)){$funValue = 'yes';}
		return $funValue;	
	}
	
	function sendRegistrationConfirmationMail($argName,$argMatriId,$argPassword,$argToEmail,$argServerUrl,$argTollFreeCont)
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

		$funSubject				= "Welcome to ".$funProductName."Matrimony.com";
		
		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/registrationConfirm.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$unsubscibeLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";

		$this->clsViewTemplate	= str_replace("<--TOLLFREE-->",$argTollFreeCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--SERVERURL-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--TOLLFREE-->",$funTollFreeCont,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MATRIID-->",$argMatriId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--PASSWORD-->",$argPassword,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--NAME-->",ucfirst($argName),$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGIN-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGO-->",$funIMGSPath.'/logo/'.$funFolderName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MAILERIMGSPATH-->",$funMailerImagePath,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--PRODUCTNAME-->",$funProductName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--HELPEMAIL-->",$funHelpEmail,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--UNSUBSCRIBE_LINK-->",$unsubscibeLink,$this->clsViewTemplate);
		$funMessage				= stripslashes($this->clsViewTemplate);

		$retResult = $this->sendEmail($funFrom,$funFromEmail,$argTo,$argToEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retResult;

	}//sendRegistrationConfirmationMail
	
    
	function sendMailAttach($argFrom, $argTo, $argCc, $argSubj, $argMsg, $argFileAttachPath,$argFile) {
		$funFrom	= $argFrom; // Who the email is from
		$funSubject = $argSubj; // The Subject of the email
		$funMsgTxt	= $argMsg; // Message that the email has in it

		$funTo		= $argTo; // Who the email is too
		$funCc		= $argCc;

		$funHeaders  = "From: ".$funFrom."\n";
		$funHeaders .= "Cc: ".$funCc."\n";

		$funSemiRand = md5(time());
		$funMimeBoundary = "==Multipart_Boundary_x{$funSemiRand}x";

		$funHeaders .= "MIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$funMimeBoundary}\"";
		$funMsg = "";

		$funMsg .= $funMsgTxt."\n\n";
		$funMsg .= "This is a multi-part message in MIME format.\n\n" .
		"--{$funMimeBoundary}\n" .
		"Content-Type:text/html; charset=\"iso-8859-1\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		$funMsg . "\n\n";
		if($argFileAttachPath!='') {
			$funFileAtt = $argFileAttachPath.$argFile;
			$funFiletype = "application/octet-stream"; // File Type
			$funFileName = $argFile; // Filename that will be used for the file as the attachment

			$funFile = fopen($funFileAtt,'rb');
			$funData = fread($funFile,filesize($funFileAtt));
			fclose($funFile);

			$funData = chunk_split(base64_encode($funData));

			$funMsg .= "--{$funMimeBoundary}\n" .
			"Content-Type: {$funFiletype};" .
			" name=\"{$funFileName}\"\n" .
			"Content-Transfer-Encoding: base64\n\n" .
			$funData . "\n\n";
		}
		$funMsg .="--{$funMimeBoundary}--\n\n";
		$funOk = @mail($funTo, $funSubject, $funMsg, $funHeaders);
		if($funOk) { $funValue = 'yes'; };
		$retValue = $funValue;
		return $retValue;
	}

	function sendEmailwithCC($argFromEmail,$argToEmail,$argSubject,$argMessage,$argReplyTo,$argCC,$argBcc) {
		$funValue				= "";
		$funheaders				= "";
		$argFromEmail			= preg_replace("/\n/", "", $argFromEmail);
		$argReplyTo				= preg_replace("/\n/", "", $argReplyTo);
		$funheaders				.= "MIME-Version: 1.0\n";
		$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders				.= "From:".$argFromEmail."<".$argFromEmail.">\n";
		if($argCC!='')
		{ $funheaders			.= "Cc:".$argCC."<".$argCC.">\n"; }
		if($argBcc!='')
		{ $funheaders			.= "Bcc:".$argBcc."<".$argBcc.">\n"; }
		$funheaders				.= "Reply-To: ".$argReplyTo."<".$argReplyTo.">\n";
		$funheaders				.= "Return-Path: <noreply@bounces.communitymatrimony.com>\n";
		$argheaders				= $funheaders;
		$argToEmail				= preg_replace("/\n/", "", $argToEmail);
		if (mail($argToEmail, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
		$retValue = $funValue;
		return $retValue;
	}

    

function sendInactiveMail($argTplFile,$argName,$argMatriId,$argPassword,$argToEmail,$argSubject)
	{
		global $confValues;
		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= $arrGetEmailInfo['NOREPLYMAIL'];
		$funHelpEmail			= $arrGetEmailInfo['HELPEMAIL'];
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funImageUrl			= $arrGetProductInfo['IMAGEURL'];

		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];

		//$funSubject			= "Welcome to ".$funProductName."Matrimony.com";
		//$funSubject			= "Login or your profile may be removed";
		$funSubject				= $argSubject;

		$varTemplateFileName	= $arrGetProductInfo['MAILERTPLPATH']."/$argTplFile";
		//$varTemplateFileName	= '/home/product/community/www/mailer/templates/'.$argTplFile;

		//do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

		$unsubscibeLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";

		$this->clsViewTemplate	= str_replace("<--SERVERURL-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--IMAGEURL-->",$funImageUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MATRIID-->",$argMatriId,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--PASSWORD-->",$argPassword,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--NAME-->",ucfirst($argName),$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--EMAIL-->",$argToEmail,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGIN-->",$funServerUrl,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--LOGO-->",$funIMGSPath.'/logo/'.$funFolderName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--MAILERIMGSPATH-->",$funMailerImagePath,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--PRODUCTNAME-->",$funProductName,$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--HELPDESK-->",$funHelpEmail,$this->clsViewTemplate);


		//$this->clsViewTemplate	= str_replace("<--COMMUNITY_HOME-->","http://www.communitymatrimony.com/",$this->clsViewTemplate);
		$this->clsViewTemplate	= str_replace("<--UNSUBSCRIBE_LINK-->",$unsubscibeLink,$this->clsViewTemplate);
		$funMessage				= stripslashes($this->clsViewTemplate);

		$retResult = $this->sendEmail($funFrom,$funFromEmail,$argTo,$argToEmail,$funSubject,$funMessage,$funReplyToEmail);
		return $retResult;

	}//send Inactive Mail

}
?>