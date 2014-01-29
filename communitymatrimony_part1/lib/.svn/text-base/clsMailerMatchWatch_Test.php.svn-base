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
include_once($varRootBasePath.'/lib/clsMailerBasicView_Test.php');

class MailerMatchWatch extends MailerBasicView {

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
	public $funDenomFeature		= "";
	public $funDenomArrayFeature= "";
	public $arrMWDenomList		= array();
	public $funCasteFeature		= "";
	public $funCasteArrayFeature= "";
	public $arrMWCasteList		= array();
	public $funSubcasteFeature	= "";
	public $funSubcasteArrayFeature= "";
	public $arrMWSubcasteList	= array();

	//SUBTRACT 2 DAYS FROM CURRENT DATE
	function getSubtractDate($varDays,$varMatchSentDateOnly) {
		$varCurrentDate	= strtotime($varMatchSentDateOnly);
	    $varMWTimeStamp	= $varCurrentDate - ($varDays * 86400); 
		$varMWDate		= date("Y-m-d",$varMWTimeStamp);
		return $varMWDate;
	}

	//TO GET SUBCASTE DETAIL
	function getCommunityWiseDtls($argDomainPrefix) {
		global $arrFolderNames,$arrPrefixDomainList;

		$this->funSiteName			= '';
		$this->funServerUrl			= '';
		$this->funProductName		= '';
		$this->funMailerImgPath		= '';
		$this->funMailerTplPath		= '';
		$this->funReligionFeature	= "";
		$this->funReligionArrayFeature= "";
		$this->arrMWReligionList	= array();
		$this->funDenomFeature		= "";
		$this->funDenomArrayFeature	= "";
		$this->arrMWDenomList		= array();
		$this->funCasteFeature		= "";
		$this->funCasteArrayFeature	= "";
		$this->arrMWCasteList		= array();
		$this->funSubcasteFeature	= '';
		$this->funSubcasteArrayFeature= '';
		$this->arrMWSubcasteList	= array();
		$this->arrPartnerDetails	= array();
		$this->funFolderName		= $arrFolderNames[$argDomainPrefix];

		$this->funSiteName		= $arrPrefixDomainList[$argDomainPrefix];
		$this->funFolderName	= $arrFolderNames[$argDomainPrefix];
		$this->funServerUrl		= 'http://www.'.$this->funSiteName;
		$this->funProductName	= ucfirst(str_replace('matrimony.com','',$this->funSiteName)).'Matrimony';
		$this->funMailerImgPath	= 'http://www.'.$this->funSiteName.'/mailer/images';
		$this->funImgsServerPath= 'http://img.'.$this->funSiteName;
		$this->funLogoPath		= 'http://img.'.$this->funSiteName.'/images/logo/'.$this->funFolderName;
		$this->funMailerTplPath	= '/home/product/community/www/mailer/templates';

		$varRootBasePath		= '/home/product/community';
		include($varRootBasePath."/domainslist/".$this->funFolderName."/conf.cil14");

		$this->funReligionFeature	= $_FeatureReligion;
		$this->arrMWReligionList	= $arrReligionList;
		if($this->funReligionFeature == 1) {
			$this->funReligionArrayFeature=sizeof($this->arrMWReligionList);
		}
		
		$this->funDenomFeature		= $_FeatureDenomination;
		$this->arrMWDenomList		= $arrDenominationList;
		if($this->funDenomFeature == 1) {
			$this->funDenomArrayFeature=sizeof($this->arrMWDenomList);
		}

		$this->funCasteFeature		= $_FeatureCaste;
		$this->arrMWCasteList		= $arrCasteList;
		if($this->funCasteFeature == 1) {
			$this->funCasteArrayFeature=sizeof($this->arrMWCasteList);
		}

		$this->funSubcasteFeature	= $_FeatureSubcaste;
		$this->arrMWSubcasteList	= $arrSubcasteList;
		if($this->funSubcasteFeature == 1) {
			$this->funSubcasteArrayFeature=sizeof($this->arrMWSubcasteList);
		}

	}

	//Match sent by mail has to updates in matchwatchsentdetails
	function updateMWSentDtls($argMatriId,$argCommunityId,$argMatchCount,$argMWType,$argMatchSentDate) {
		global $varTable,$varDbInfo;

		$argFields 		= array('MatriId','CommunityId','Profiles_Sent_Count','MatchWatch_Type','Date_Sent');
		$argFieldsValues= array("'".$argMatriId."'","'".$argCommunityId."'","'".$argMatchCount."'","'".$argMWType."'","'".$argMatchSentDate."'");
		$varUpdateId	= $this->insertOnDuplicate($varTable['MATCHWATCHSENTDETAILS'],$argFields,$argFieldsValues,'MatriId');

		return $varUpdateId;
	}

	//getMatchWatchMatriIds
	function getLimitedMWMatriIds($argDomainId,$argStLt,$argEndLt)
	{
		global $varTable;		

		$funFields			= array('MatriId');
		$funCondition		= "WHERE CommunityId = ".$argDomainId." AND Matchwatch=1 ORDER BY Date_Updated LIMIT ".$argStLt.",".$argEndLt;
		//$funCondition		= "WHERE CommunityId = ".$argDomainId." AND Matchwatch=1 AND MatriId IN ('AGR100156','BRH100025','BRH101953')";
		//echo $funCondition.'<BR>';
		$arrLtdMatriIdsRes	= $this->select($varTable['MAILMANAGERINFO'], $funFields, $funCondition, 0);
		while($arrLtdMatriIds = mysql_fetch_assoc($arrLtdMatriIdsRes)) {
			$arrLimitedMatriIds[] = $arrLtdMatriIds['MatriId'];
		}

		return $arrLimitedMatriIds;
	}//getMatchWatchMatriIds

	//TO GET MATRIIDS
	function getMatchWatchMatriIds($varDomainId,$argDomainPrefix,$arrMWMatriIds)
	{
		global $varTable;

		//get community wise details
		$this->getCommunityWiseDtls($argDomainPrefix);

		$funFields			= array('mi.Name','mi.Partner_Set_Status','mi.CommunityId','mi.CasteId','mi.SubcasteId', 'mi.Paid_Status', 'mi.Last_Payment', 'mi.Valid_Days', 'mi.Expiry_Date', 'mi.Gender', 'mli.MatriId', 'mli.Email');
		//$combinedFunTables	= $varTable['MEMBERINFO'].' as mi,'.$varTable['MEMBERLOGININFO'].' as mli';
		$combinedFunTables	= 'memberinfo_mw as mi, memberlogininfo_mw as mli';
		$funCondition		= "WHERE mi.CommunityId = ".$varDomainId." AND mi.MatriId IN ('".join($arrMWMatriIds,"','")."') AND mli.MatriId=mi.MatriId AND mi.Publish=1";
		//echo $funCondition."<BR>";
		$arrMatriIdsDet		= $this->select($combinedFunTables, $funFields, $funCondition, 0);

		return $arrMatriIdsDet;
	}//TO GET MATRIIDS
	#---------------------------------------------------------------------------------------------------
	//CALCULATE DATE DIFFERENCE
	function dateDiff($argDateSeparator, $argCurrentDate, $argPaidDate)
	{
		$funArrPaidDate		= explode($argDateSeparator, $argPaidDate);
		$funArrCurrentDate	= explode($argDateSeparator, $argCurrentDate);
		$funStartDate		= gregoriantojd($funArrPaidDate[0], $funArrPaidDate[1], $funArrPaidDate[2]);
		$funEndDate			= gregoriantojd($funArrCurrentDate[0], $funArrCurrentDate[1], $funArrCurrentDate[2]);

		return $funEndDate - $funStartDate;
	}//dateDiff
	#------------------------------------------------------------------------------------------------------------
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
		$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
		$funheaders				.= "Reply-To: ".$argFrom."<".$argReplyToEmailAddress.">\n";
		$funheaders				.= "Return-Path:".$argFrom."<".$argReplyToEmailAddress.">\n";
		$funheaders				.= "Sender:".$argFrom."<".$argFromEmailAddress.">\n";
		$argheaders				= $funheaders;
		$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);
		//$argToEmailAddress	= "jeyakumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com,dhanapal.n@gmail.com,greennjk@gmail.com";

		if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
		//echo $argMessage;
		$retValue = $funValue;

		return $retValue;
	}//sendEmail

	#---------------------------------------------------------------------------------------------------

	function ProfileIamLooking($varCommunityId,$varMatriId,$varGender,$varPartnerSet,$varPurpose,$varCasteOrDivision,$varSubcaste,$varPaidStatus,$varMatchSentDateOnly)
	{
		global $varTable,$varDbInfo,$arrCountryList,$arrMWDomainInfo;

		$varMatchWatchTable	= $varTable['PROFILEMATCHINFO'];
		$arrProIdsDet		= array();

		$varFetchRecCnt	= 5;
		if($varPaidStatus == 1) {
			$varFetchRecCnt	= 50;
		}

		if($varPurpose == 'photo') {
			$varMatchingDaysSt = 8;
		} else {
			$varMatchingDaysSt = 2;
		}
		$varMatchingDaysEnd = 2;

		$varMWDateFromTime	= $this->getSubtractDate($varMatchingDaysSt,$varMatchSentDateOnly).' 00:00:00';
		$varMWDateEndTime	= $this->getSubtractDate($varMatchingDaysEnd,$varMatchSentDateOnly).' 23:59:59';

		//$varMWDateFromTime	= '2009-07-02 00:00:00';
		//$varMWDateEndTime	= '2009-07-28 23:59:59';

		//COMPATIBILTY BAR ARRAY VALUES
		$argCondition		= "WHERE CommunityId = ".$varCommunityId." AND MatriId='".$varMatriId."'";

		$funFields			= array('MatriId', 'Age_From', 'Age_To', 'Looking_Status', 'Height_From', 'Height_To', 'MatchPhysical_Status', 'MatchEducation', 'MatchReligion', 'MatchDenomination', 'MatchCaste', 'MatchSubcasteId', 'MatchCitizenship', 'MatchCountry', 'MatchIndianStates', 'MatchUSStates', 'MatchResidentStatus', 'MatchMotherTongue',  'Eating_HabitsPref', 'Drinking_HabitsPref', 'Smoking_HabitsPref', 'Date_Updated','GothramId');
		$funarrPPDetResSet	= $this->select($varMatchWatchTable, $funFields, $argCondition, 0);
		$funarrPPDet		= mysql_fetch_assoc($funarrPPDetResSet);

		$funStAge		= $funarrPPDet['Age_From'];
		$funEndAge		= $funarrPPDet['Age_To'];
		$funStHeight	= $funarrPPDet['Height_From'];
		$funEndHeight	= $funarrPPDet['Height_To'];
		$funLookingfor	= $funarrPPDet['Looking_Status'];
		$funPhStatus	= $funarrPPDet['MatchPhysical_Status'];
		$funMotherTongue= $funarrPPDet['MatchMotherTongue'];
		$funReligion	= $funarrPPDet['MatchReligion'];
		$funDenomination= $funarrPPDet['MatchDenomination'];
		$funCasteId		= $funarrPPDet['MatchCaste'];
		$funSubcasteId	= $funarrPPDet['MatchSubcasteId'];
		$funEatingHabit	= $funarrPPDet['Eating_HabitsPref'];
		$funEducation	= $funarrPPDet['MatchEducation'];
		$funCitizenship	= $funarrPPDet['MatchCitizenship'];
		$funCountry		= $funarrPPDet['MatchCountry'];
		$funIndiaState	= $funarrPPDet['MatchIndianStates'];
		$funUSAState	= $funarrPPDet['MatchUSStates'];
		//$funResidentSt	= $funarrPPDet['MatchResidentStatus'];
		$funSmokingHabit= $funarrPPDet['Smoking_HabitsPref'];
		$funDrinkHabit	= $funarrPPDet['Drinking_HabitsPref'];
		$funGothramId	= $funarrPPDet['GothramId'];

		if($funStAge != 0) {
			$funQuery		= " WHERE CommunityId = ".$varCommunityId." AND ";
			if($varPartnerSet == 1) {

				$this->arrPartnerDetails['Age_From']	= $funStAge;
				$this->arrPartnerDetails['Age_To']	= $funEndAge;

				$funQuery		.= " Gender=".$varGender." AND Age >=".$funStAge." AND Age <=".$funEndAge." AND Height >=".floor($funStHeight)." AND Height <=".ceil($funEndHeight);
				
				if($funPhStatus != 0) { $funQuery	.= ' AND SpecialCase = '.$funPhStatus;	 }//if 
				if($funEatingHabit != 0) { $funQuery	.= ' AND Eating_Habits = '.$funEatingHabit;	 }//if
				if($funSmokingHabit != 0) { $funQuery	.= ' AND Smoking_Habits = '.$funSmokingHabit;	 }//if
				if($funDrinkHabit != 0) { $funQuery	.= ' AND Drinking_Habits = '.$funDrinkHabit;	 }//if

				if($funLookingfor != '' && $funLookingfor !=0)
				{ $funQuery	.= ' AND Marital_Status IN('.preg_replace('/(~)+/', ',', trim($funLookingfor,'~')).')'; }//if

				if($funMotherTongue != "" && $funMotherTongue !=0)
				{ $funQuery	.= ' AND Mother_Tongue IN('.preg_replace('/(~)+/', ',', trim($funMotherTongue,'~')).')';	 }//if

				if($funReligion != "" && $funReligion !=0)
				{ $funQuery	.= ' AND Religion IN('.preg_replace('/(~)+/', ',', trim($funReligion,'~')).')';	 }//if

				if($funDenomination != "" && $funDenomination !=0)
				{ $funQuery	.= ' AND Denomination IN('.preg_replace('/(~)+/', ',', trim($funDenomination,'~')).')';	 }//if

				if($this->funCasteArrayFeature>0) {
					if($this->funCasteArrayFeature>1) {
						if($funCasteId != "" && $funCasteId !=0) { 
							$arrCasteId		= explode('~',$funCasteId);
							if(sizeof($arrCasteId) > 5) {
								$this->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
							} else {
								$strCasteName	= '';
								for($i = 0; $i < sizeof($arrCasteId); $i++) {
									$strCasteName .= $this->arrMWCasteList[$arrCasteId[$i]].',';
								}
								$strCasteName = rtrim($strCasteName,',');
								$this->arrPartnerDetails['CasteOrSubcasteId'] = $strCasteName;
							}
						}//if
						else {
							$this->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
						}

						$this->arrPartnerDetails['CasteOrSubcasteLabel'] = 'Caste';
					}
					if($funCasteId != "" && $funCasteId !=0) { 
						$funQuery	.= ' AND CasteId IN('.preg_replace('/(~)+/', ',', trim($funCasteId,'~')).')';
					}
				}

				if($this->funSubcasteArrayFeature>0) {
					if($this->funSubcasteArrayFeature>1) {
						if($funSubcasteId != "" && $funSubcasteId !=0) { 
							$arrSubcasteId		= explode('~',$funSubcasteId);
							if(sizeof($arrSubcasteId) > 5) {
								$this->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
							} else {
								$strSubcasteName	= '';
								for($i = 0; $i < sizeof($arrSubcasteId); $i++) {
									$strSubcasteName .= $this->arrMWSubcasteList[$arrSubcasteId[$i]].',';
								}
								$strSubcasteName = rtrim($strSubcasteName,',');
								$this->arrPartnerDetails['CasteOrSubcasteId'] = $strSubcasteName;
							}						
						}//if
						else {
							$this->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
						}
						$this->arrPartnerDetails['CasteOrSubcasteLabel'] = 'Subcaste';
					}
					if($funSubcasteId != "" && $funSubcasteId !=0) { 
						$funQuery	.= ' AND SubcasteId IN('.preg_replace('/(~)+/', ',', trim($funSubcasteId,'~')).')';	 
					}
				}

				if($funEducation != "" && $funEducation !=0)
				{ $funQuery	.= ' AND Education_Category IN('.preg_replace('/(~)+/', ',', trim($funEducation,'~')).')';	 }//if

				if($funCitizenship != "" && $funCitizenship !=0)
				{ $funQuery	.= ' AND Citizenship IN('.preg_replace('/(~)+/', ',', trim($funCitizenship,'~')).')';	 }//if

				$arrCountry = array();
				if($funCountry != "" && $funCountry !=0)
				{ 
					$arrCountry	= Split('~',$funCountry);
					if(sizeof($arrCountry) > 5) {
						$this->arrPartnerDetails['Country'] = 'Any';
					} else {
						$strCountryName	= '';
						for($i = 0; $i < sizeof($arrCountry); $i++) {
							$strCountryName .= $arrCountryList[$arrCountry[$i]].',';
						}
						$strCountryName = rtrim($strCountryName,',');
						$this->arrPartnerDetails['Country'] = $strCountryName;
					}
					$funQuery	.= ' AND Country IN('.preg_replace('/(~)+/', ',', trim($funCountry,'~')).')';
				}//if
				else
				{
					$this->arrPartnerDetails['Country'] = 'Any';
				}

				if($funIndiaState != "" && $funIndiaState !=0)
				{
					if (count($arrCountry) >0 && in_array(98,$arrCountry))
					{ $funQuery	.= ' AND Residing_State IN('.preg_replace('/(~)+/', ',', trim($funIndiaState,'~')).')';	 }//if
				}

				if($funUSAState != "" && $funUSAState !=0)
				{
					if (count($arrCountry) >0 && in_array(222,$arrCountry))
					{ $funQuery	.= ' AND Residing_State IN('.preg_replace('/(~)+/', ',', trim($funUSAState,'~')).')';	 }//if
				}
				
			}
			else
			{
				//Displaying mailer right content
				$this->arrPartnerDetails['Age_From']	= $funStAge;
				$this->arrPartnerDetails['Age_To']		= $funEndAge;
				$this->arrPartnerDetails['Country']		= 'Any';
				if($this->funCasteArrayFeature>1) {
					if($varCasteOrDivision!=0) {
						$this->arrPartnerDetails['CasteOrSubcasteId'] = $this->arrMWCasteList[$varCasteOrDivision];
					} else {
						$this->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
					}
					$this->arrPartnerDetails['CasteOrSubcasteLabel'] = 'Caste';
				} else if($this->funSubcasteArrayFeature>1) {
					if($varSubcaste!=0) {
						$this->arrPartnerDetails['CasteOrSubcasteId'] = $this->arrMWSubcasteList[$varSubcaste];
					} else {
						$this->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
					}
					$this->arrPartnerDetails['CasteOrSubcasteLabel'] = 'Subcaste';
				}

				$funQuery		.= " Gender=".$varGender." AND Age >=".$funStAge." AND Age <=".$funEndAge." AND Height >=".floor($funStHeight)." AND Height <=".ceil($funEndHeight);
			}

			if($funGothramId != "" && $funGothramId !=0 && $funGothramId !=999 && $funGothramId !=9997 && $funGothramId !=9998 && $funGothramId !=9999)
				{ $funQuery	.= ' AND GothramId != '.$funGothramId;	 }//if

			if($varPurpose == 'photo') {
				$funQuery	.= ' AND Photo_Set_Status = 1';
			}

			$funQuery	.= " AND Date_Created >= '".$varMWDateFromTime."' AND  Date_Created <= '".$varMWDateEndTime."'";
			//echo $funQuery."<BR>";
			$funNoOfRecs	= $this->numOfRecords('newprofilematchinfo', 'MatriId', $funQuery);	

			if ($funNoOfRecs > 0)
			{
				$funQuery	.= ' ORDER BY Date_Created DESC LIMIT 0,'.$varFetchRecCnt;
				$funFields	= array('MatriId');


				$funReultSet = $this->select('newprofilematchinfo', $funFields, $funQuery, 0);

				$i = 0;
				while($row = mysql_fetch_assoc($funReultSet)) {
					$arrProIdsDet[$i]	= "'".$row['MatriId']."'";
					$i++;
				}
			} else {
				$arrProIdsDet = array();
			}
		} else {
			$arrProIdsDet = array();
		}
		
		return $arrProIdsDet;
	}

	#------------------------------------------------------------------------------------------------------------
	function sendMatchWatchMail($argMatriId,$argName,$argToEmail,$argPaidStatus,$argPartnerSet,$argPaidDate,$argValidDays,$argRemainingDays,$varExpiryDate,$arrProfileMatchId,$argCasteOrDivision,$argPurpose,$argMatchSentDate)
	{
		global $arrEmailsList,$confValues,$arrMWDomainInfo;
		$funFrom			= $this->funProductName.'.Com';
		$funFromEmail		= 'info@'.$this->funSiteName;
		$funReplyToEmail	= 'noreply@'.$this->funSiteName;
		$funMatchProfileCnt	= sizeof($arrProfileMatchId);
		$funDateDisplay		= date('jS F Y',strtotime($argMatchSentDate));

		if($argPurpose=='match') {
			$funSubject			= "Match Watch on ".$funDateDisplay." from ".$this->funProductName.".com";
			$funHeading			= "Daily Best Matches";
		} elseif($argPurpose=='photo') {
			$funSubject			= "Photo Match Watch on ".$funDateDisplay." from ".$this->funProductName.".com";
			$funHeading			= "Best Photo Matches";
		}

		//$newContactsNum = $this->getNewContacts($argMatriId);

		$varProfileBasicResultSet = $this->selectDetails($arrProfileMatchId);

		$varProfileBasicView= $this->getMatchWatchRegularDetails($argPurpose,$varProfileBasicResultSet,$argPaidStatus);
		
		if($varProfileBasicView != '')
		{
			//if($argPurpose=='match') {
				$varTemplateFileName	= $this->funMailerTplPath."/dailymatchwatch.tpl";
			/*} else if($argPurpose=='photo') {
				$varTemplateFileName	= $this->funMailerTplPath."/photomatchwatch.tpl";
			}*/
			
			$this->clsViewTemplate		= $this->getContentFromFile($varTemplateFileName);

			//Partner Info detail
			$partnerAgeFrom	= $this->arrPartnerDetails['Age_From'];
			$partnerAgeTo	= $this->arrPartnerDetails['Age_To'];
			$partnerSubcaste= $this->arrPartnerDetails['CasteOrSubcasteId'];
			$partnerCasteLabel= $this->arrPartnerDetails['CasteOrSubcasteLabel'];
			$partnerCountry	= $this->arrPartnerDetails['Country'];
			
			if($argPartnerSet==1)
			{
				$partnerLink	= "<a href='".$this->funServerUrl."/login/index.php?redirect=".$this->funServerUrl."/profiledetail/index.php?act=partnerinfodesc' style='font:normal 11px arial; color:#FC4700; text-decoration:none;'>Edit preference</a>";
				$partnerContent	= 'Your Partner Preference set by you.';
			}//if
			else
			{
				$partnerLink	= "<a href='".$this->funServerUrl."/login/index.php?redirect=".$this->funServerUrl."/profiledetail/index.php?act=partnerinfodesc' style='font:normal 11px arial; color:#FC4700; text-decoration:none;'>Add preference</a>";
				$partnerContent	= 'Your Partner Preference set by us.';
			}//else

			if($argPaidStatus == 1) {
				$varMembershipDetail	= '';
			} else {
				$varMembershipDetail	= "<tr><td valign='top' width='536'><table border='0' cellpadding='0' cellspacing='0' width='500' style='border:1px solid #8b8b8b;' align='center'><tr><td width='249' style='font:normal 11px arial;color:#606060;padding-left:20px;padding-top:10px;padding-bottom:10px;padding-right:15px;text-align:justify;line-height:14px;'>We have exclusively chosen<br><b>".$funMatchProfileCnt." Best Matches for YOU!</b><br><br>Premium members are entitled to receive<br><b> upto 50 matches</b>.</td><td><img src='<--MAILERIMGSPATH-->/sepdot.gif'></td><td width='250' style='font:normal 11px arial;color:#606060;padding-left:20px;padding-top:10px;padding-bottom:10px;padding-right:15px;text-align:justify;line-height:14px;'><a style='text-decoration:none;color:#FC4700;' href='".$this->funServerUrl."/payment/?pamid=".$argMatriId."&palead=10'><img src='<--MAILERIMGSPATH-->/paynowbutton.gif' border='0'></a><br>to become a premium member<br> and receive more matches.</td></tr></table></td></tr>";
			}

			$unsubscibeLink = $this->funServerUrl."/login/index.php?redirect=".$this->funServerUrl."/profiledetail/index.php?act=mailsetting";
			$varLiveHelp	= $this->funServerUrl."/site/index.php?act=LiveHelp";

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
			$this->clsViewTemplate	= str_replace('<--RECEIVER_NAME-->',ucfirst($argName),$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--RECEIVER_MATRIID-->',$argMatriId,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--MATCH_PROFILE_CNT-->',$funMatchProfileCnt,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--BASIC-PROFILE-->',$varProfileBasicView,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--MEMBERSHIP_DETAILS-->',$varMembershipDetail,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--UNSUBSCRIBE_LINK-->',$unsubscibeLink,$this->clsViewTemplate);
			$this->clsViewTemplate	= str_replace('<--LIVE_HELP-->',$varLiveHelp,$this->clsViewTemplate);
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
	//$argMailerName => message pending, express interest pending
	//$varTrackDtls come from message pending, express interest pending mailer related files
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