<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-11-19
# End Date		: 2008-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
#=============================================================================================================

//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

if($varRootBasePath == ''){ $varRootBasePath = '/home/product/community'; }

//INCLUDE FILES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsCryptDetail.php');
include_once($varRootBasePath.'/lib/clsNewMailerBasicView.php');

class NewMailerMatchWatch extends NewMailerBasicView {

	public $clsViewTemplate		= "";
	public $varMatchWatchDate	= "";
	public $arrPartnerDetails	= array();
	public $funSiteName			= "";
	public $funServerUrl		= "";
	public $funProductName		= "";
	public $funMailerImgPath	= "";
	public $funReligionFeature	= "";
	public $funReligionArrayFeature= "";
	public $arrMWReligionList	= array();
	public $funDenomLabel		= "";
	public $funDenomFeature		= "";
	public $funDenomArrayFeature= "";
	public $arrMWDenomList		= array();
	public $funCasteLabel		= "";
	public $funCasteFeature		= "";
	public $funCasteArrayFeature= "";
	public $arrMWCasteList		= array();
	public $funSubcasteLabel	= "";
	public $funSubcasteFeature	= "";
	public $funSubcasteArrayFeature= "";
	public $arrMWSubcasteList	= array();
	public $varAutoLoginLink	= '';

	//TO GET SUBCASTE DETAIL
	function getCommunityWiseDtls($argDomainPrefix) {
		global $arrFolderNames,$arrPrefixDomainList,$arrMailerTplFolder,$arrMailerLinkClr,$arrMailerButtonName;
		
		$this->funSiteName			= '';
		$this->funServerUrl			= '';
		$this->funProductName		= '';
		$this->funMailerImgPath		= '';
		$this->funMailerTplPath		= '';
		$this->funReligionFeature	= "";
		$this->funReligionArrayFeature= "";
		$this->arrMWReligionList	= array();
		$this->funDenomLabel		= "";
		$this->funDenomFeature		= "";
		$this->funDenomArrayFeature	= "";
		$this->arrMWDenomList		= array();
		$this->funCasteLabel		= "";
		$this->funCasteFeature		= "";
		$this->funCasteArrayFeature	= "";
		$this->arrMWCasteList		= array();
		$this->funSubcasteLabel		= '';
		$this->funSubcasteFeature	= '';
		$this->funSubcasteArrayFeature= '';
		$this->arrMWSubcasteList	= array();
		$this->arrPartnerDetails	= array();
		$this->funPayNowImgName		= '';
		$this->funLinkColor			= '';

		$this->funSiteName		= $arrPrefixDomainList[$argDomainPrefix];
		$this->funFolderName	= $arrFolderNames[$argDomainPrefix];
		$this->funServerUrl		= 'http://www.'.$this->funSiteName;
		$this->funProductName	= ucfirst(str_replace('matrimony.com','',$this->funSiteName)).'Matrimony';
		$this->funMailerImgPath	= 'http://www.'.$this->funSiteName.'/mailer/images';
		$this->funImgsServerPath= 'http://img.'.$this->funSiteName;
		$this->funLogoPath		= 'http://img.'.$this->funSiteName.'/images/logo/'.$this->funFolderName;
		$varMailerTplPath		= ($arrMailerTplFolder[$argDomainPrefix]!='')?('/'.$arrMailerTplFolder[$argDomainPrefix]):'';
		$this->funMailerTplPath	= '/home/product/community/www/mailer/templates'.$varMailerTplPath;

		$this->funPayNowImgName	= array_key_exists($argDomainPrefix, $arrMailerButtonName) ? $arrMailerButtonName[$argDomainPrefix] : "paynowbutton.gif";
		$this->funLinkColor		= array_key_exists($argDomainPrefix, $arrMailerLinkClr) ?  $arrMailerLinkClr[$argDomainPrefix] : "#FC4700";

		$varRootBasePath		= '/home/product/community';
		include($varRootBasePath."/domainslist/".$this->funFolderName."/conf.cil14");

		$this->funReligionFeature	= $_FeatureReligion;
		$this->arrMWReligionList	= $arrReligionList;
		if($this->funReligionFeature == 1) {
			$this->funReligionArrayFeature=sizeof($this->arrMWReligionList);
		}
		
		$this->funDenomLabel		= $_LabelDenomination;
		$this->funDenomFeature		= $_FeatureDenomination;
		$this->arrMWDenomList		= $arrDenominationList;
		if($this->funDenomFeature == 1) {
			$this->funDenomArrayFeature=sizeof($this->arrMWDenomList);
		}

		$this->funCasteLabel		= $_LabelCaste;
		$this->funCasteFeature		= $_FeatureCaste;
		$this->arrMWCasteList		= $arrCasteList;
		if($this->funCasteFeature == 1) {
			$this->funCasteArrayFeature=sizeof($this->arrMWCasteList);
		}

		$this->funSubcasteLabel		= $_LabelSubcaste;
		$this->funSubcasteFeature	= $_FeatureSubcaste;
		$this->arrMWSubcasteList	= $arrSubcasteList;
		if($this->funSubcasteFeature == 1) {
			$this->funSubcasteArrayFeature=sizeof($this->arrMWSubcasteList);
		}
	}

	//Check DB Connection
	function checkConnection() {
		if($this->clsErrorCode!='') {
			echo $this->clsErrorCode;
			exit;
		}
	}

	//GET CONTENT FROM THE GIVEN FILE
	function getContentFromFile($argFileName)
	{
		if(file_exists($argFileName)) {
			return file_get_contents($argFileName);
		} else {
			echo "File Not available";
		}
	}//getContentToFile
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function sendEmail($argFrom,$argFromEmailAddress,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress)
	{
		$funValue				= "";
		$funheaders				= "";
		$argFrom				= preg_replace("/\n/", "", $argFrom);
		$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
		$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
		$funheaders				.= "MIME-Version: 1.0\n";
		$funheaders				.= "Content-type: text/html\n";
		$funheaders				.= "From: ".$argFrom."<".$argFromEmailAddress."> \n";
		$funheaders				.= "Sender: info@communitymatrimony.com \n";
		$funheaders				.= "X-Mailer: PHP\n"; 
		$funheaders				.= "Return-Path: noreply@bounces.communitymatrimony.com \n"; 
		$funheaders				.= "Reply-To: ".$argReplyToEmailAddress." \n";
		$argheaders				= $funheaders;
		$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);
		$argToEmailAddress	= "kselvakumarcs@gmail.com,k.selvakumarcs@gmail.com,mail2selvak@yahoo.com,check4selva@yahoo.in";
		if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
		//echo $argMessage;
		$retValue = $funValue;

		return $retValue;
	}//sendEmail

	
	#------------------------------------------------------------------------------------------------------------
	function sendMatchWatchMail($argCommunityId,$argMatriId,$argName,$argToEmail,$argPaidStatus,$argPartnerSet,$arrProfileMatchId,$argPurpose,$argMatchSentDate,$argMemberCountry)
	{
		$funFrom			= $this->funProductName.'.Com';
		$funFromEmail		= 'info@'.$this->funSiteName;
		$funReplyToEmail	= 'noreply@'.$this->funSiteName;
		$funMatchProfileCnt	= sizeof($arrProfileMatchId);
		$funDateDisplay		= $argMatchSentDate;
		$varImgPayNow		= $this->funPayNowImgName;
		$varLinkClr			= $this->funLinkColor;

		$this->varAutoLoginLink	= CryptDetail::mclink($argMatriId,'mw');

		if($argPurpose=='match') {
			$funSubject			= "Match Watch on ".$funDateDisplay." from ".$this->funProductName.".com";
			$funHeading			= "Daily Best Matches";
		} elseif($argPurpose=='photo') {
			$funSubject			= "Photo Match Watch on ".$funDateDisplay." from ".$this->funProductName.".com";
			$funHeading			= "Best Photo Matches";
		}

		$varProfileBasicResultSet = $this->selectDetails($arrProfileMatchId,$argPurpose);

		$varProfileBasicView= $this->getMatchWatchRegularDetails($argPurpose,$varProfileBasicResultSet,$argPaidStatus);
		
		if($varProfileBasicView != '')
		{
			$varTemplateFileName	= $this->funMailerTplPath."/dailymatchwatch.tpl";
			$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);

			//Partner Info detail
			$partnerAgeFrom	= $this->arrPartnerDetails['Age_From'];
			$partnerAgeTo	= $this->arrPartnerDetails['Age_To'];
			$partnerSubcaste= $this->arrPartnerDetails['CasteOrSubcasteId'];
			$partnerCasteLabel= $this->arrPartnerDetails['CasteOrSubcasteLabel'];
			$partnerCountry	= $this->arrPartnerDetails['Country'];
			
			if($argPartnerSet==1)
			{
				$partnerLink	= "<a href='".$this->funServerUrl."/login/intermediatelogin.php?".$this->varAutoLoginLink."&redirect=".$this->funServerUrl."/profiledetail/index.php?act=partnerinfodesc' style='font:normal 11px arial; color:".$varLinkClr."; text-decoration:none;'><b>Edit partner preference</b></a>";
				$partnerContent	= 'Want better results? ';
				$partnerHeadingContent	= 'Partner preference set by you';
			}//if
			else
			{
				$partnerLink	= "<a href='".$this->funServerUrl."/login/intermediatelogin.php?".$this->varAutoLoginLink."&redirect=".$this->funServerUrl."/profiledetail/index.php?act=partnerinfodesc' style='font:normal 11px arial; color:".$varLinkClr."; text-decoration:none;'><b>Set partner preference</b></a>";
				$partnerContent	= 'Want more relevant results? ';
				$partnerHeadingContent	= 'Recommended partner preference based on your profile information:';
			}//else
			
			$varMembershipDetail='';
			if($argCommunityId!=2002) {
				if($argPaidStatus == 1) {
					$varMembershipDetail	= '';
				} else {
					$varMembershipDetail	= "<tr><td height='10'></td></tr><tr><td valign='top' width='536'><table border='0' cellpadding='0' cellspacing='0' width='500' style='border:1px solid #8b8b8b;' align='center'><tr><td width='249' style='font:normal 11px arial;color:#606060;padding-left:20px;padding-top:10px;padding-bottom:10px;padding-right:15px;text-align:justify;line-height:14px;'>We have exclusively chosen<br><b>".$funMatchProfileCnt." Best Matches for YOU!</b><br></td><td><img src='<--MAILERIMGSPATH-->/sepdot.gif'></td><td width='250' style='font:normal 11px arial;color:#606060;padding-left:20px;padding-top:10px;padding-bottom:10px;padding-right:15px;text-align:justify;line-height:14px;'><a style='text-decoration:none;color:".$varLinkClr.";' href='".$this->funServerUrl."/payment/?pamid=".$argMatriId."&palead=10'><img src='<--MAILERIMGSPATH-->/".$varImgPayNow."' border='0'></a><br>to become a premium member<br> and receive more matches.</td></tr></table></td></tr>";
					 
				}
			}			

			$unsubscibeLink = $this->funServerUrl."/login/intermediatelogin.php?".$this->varAutoLoginLink."&redirect=".$this->funServerUrl."/profiledetail/index.php?act=mailsetting";
			$varLiveHelp	= $this->funServerUrl."/site/index.php?act=LiveHelp";

			if($argMemberCountry==98 && $argCommunityId!=2002) {
				$varTollFree	= '<tr><td><table border="0" cellspacing="0" cellpadding="0" style="border-top:1px solid #cbcbcb;" width="536" align="left"><tr><td width="536"><table width="485" align="center"><tr><td height="15"></td></tr>
					<tr><td background="'.$this->funMailerImgPath.'/tollfree.gif" height="61" style="padding-left:85px;font:normal 12px arial;color:#606060;background-repeat:no-repeat;">Need help? Call <font style="font-size:20px;font-weight:bold;">1800-3000-2222</font> (Toll Free)<br>or <a href="'.$varLiveHelp.'" style="color:'.$varLinkClr.';text-decoration:none;">Chat Live</a> with a customer care person.</td></tr><tr><td height="15"></td></tr></table></td></tr></table></td></tr>';

				$varDoorStep	= '<tr><td><table border="0" cellpadding="0" cellspacing="0" width="536">
					<tr valign="top"><td bgcolor="#ffffff" style="font: bold 18px arial;color:#666666;padding-top:15px; padding-left:15px;padding-bottom:15px;">Pay at Doorstep</td></tr>
					<tr bgcolor="#ffffff"><td  background="'.$this->funMailerImgPath.'/f2p-border-bg.gif" width="536" height="56" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" >
							<tr><td style="padding-left:30px;padding-top:15px;"><img src="'.$this->funMailerImgPath.'/f2p-one.gif" width="27" height="27" border="0" alt=""></td><td valign="top" style="padding-left:20px;padding-top:15px;font: bold 12px arial;color:#666666;"><a href="'.$this->funServerUrl.'/payment/index.php?act=doorstep" style="color:'.$varLinkClr.';text-decoration:none;">Click here</a> to give us your name and phone number. We will call you to collect payment at your convenient time.</td></tr>
						</table>
					</td></tr>
					<tr bgcolor="#ffffff"><td  height="7" valign="top"><img src="'.$this->funMailerImgPath.'/trans.gif" width="536" height="7"></td></tr>
					<tr bgcolor="#ffffff"><td  background="'.$this->funMailerImgPath.'/f2p-border-bg.gif" width="536" height="56" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" >
							<tr><td valign="top" style="padding-left:30px;padding-top:15px;"><img src="'.$this->funMailerImgPath.'/f2p-two.gif" width="27" height="27" border="0" alt=""></td><td valign="top" style="padding-left:20px;padding-top:15px;padding-right:20px;font: bold 12px arial;color:#666666;">Or e-mail your address, phone number & convenient time for payment collection  to <a href="mailto:doorstep@'.strtolower($this->funSiteName).'?subject='.$argMatriId.' interested in Doorstep Payment" style="color:'.$varLinkClr.';text-decoration:none;">doorstep@'.strtolower($this->funSiteName).'.</a></td></tr>
						</table>
						</td></tr>
						<tr><td bgcolor="#ffffff" height="7" valign="top"><img src="'.$this->funMailerImgPath.'/trans.gif" width="536" height="7"></td></tr>
					</table></td></tr>';
			} else {
				$varTollFree	= '';
				$varDoorStep	= '';
			}

			$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--CURRENT_DATE-->',$funDateDisplay,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--HEADING-->',$funHeading,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--LOGO-->',$this->funLogoPath,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_LINK-->',$partnerLink,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_AGE_FROM-->',$partnerAgeFrom,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_AGE_TO-->',$partnerAgeTo,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_SUBCASTE-->',$partnerSubcaste,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_CASTELABEL-->',$partnerCasteLabel,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_COUNTRY-->',$partnerCountry,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_CONTENT-->',$partnerContent,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PARTNER_CONTENT_HEADING-->',$partnerHeadingContent,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--RECEIVER_NAME-->',ucfirst($argName),$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--RECEIVER_MATRIID-->',$argMatriId,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--MATCH_PROFILE_CNT-->',$funMatchProfileCnt,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--BASIC-PROFILE-->',$varProfileBasicView,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--MEMBERSHIP_DETAILS-->',$varMembershipDetail,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--UNSUBSCRIBE_LINK-->',$unsubscibeLink,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--TOLL_FREE-->',$varTollFree,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--DOOR_STEP-->',$varDoorStep,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--MAILERIMGSPATH-->',$this->funMailerImgPath,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--PRODUCT_NAME-->',$this->funProductName,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--SERVER_URL-->',$this->funServerUrl,$this->clsViewTemplate);
			
			$funMessage				= stripslashes($this->clsViewTemplate);
			$funToEmail				= $argToEmail;
			 
			$retvalue=$this->sendEmail($funFrom,$funFromEmail,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

			 return $retvalue;
		}//if
	}//sendMatchWatchMail

	#------------------------------------------------------------------------------------------------------------
	//TO GET MATCH WATCH DETAILS
	function getMatchWatchRegularDetails($argPurpose,$varProfileBasicResultSet,$argPaidStatus,$argMailerName='',$varTrackDtls='',$argMsgId='')
	{
		for($i = 0; $i < sizeof($varProfileBasicResultSet); $i++)
		{
			$funDispBasic=$this->mailMatchWatchBasicDetails($argPurpose,$varProfileBasicResultSet[$i],$argPaidStatus,$argMailerName,$varTrackDtls,$argMsgId);
			$funDisplayBasicVal .= $funDispBasic; 
		}//while
		return $funDisplayBasicVal;		
	}//getMatchWatchRegularDetails
	#------------------------------------------------------------------------------------------------------------
}

?>