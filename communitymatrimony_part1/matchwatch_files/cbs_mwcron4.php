<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-11-19
# End Date		: 2008-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
#=============================================================================================================

//FILE INCLUDES
$varServerBasePath	= '/home/product/community';
include_once($varServerBasePath.'/conf/dbinfo.inc');
include_once($varServerBasePath.'/conf/config.inc');
include_once($varServerBasePath.'/conf/cityarray.inc');
include_once($varServerBasePath.'/conf/emailsconfig.inc');
include_once($varServerBasePath.'/conf/domainlist.inc');
include_once($varServerBasePath.'/conf/mwdomainlist.inc');
include_once($varServerBasePath.'/lib/clsNewMailerMatchwatch.php');

//OBJECT DECLARATION
$objMailerMatchWatch = new NewMailerMatchWatch;

//CONNECT DB
$objMailerMatchWatch->dbConnect('S2',$varMatchwatchDbInfo['DATABASE']);
$objMailerMatchWatch->checkConnection();

while(1) {
	$funFields			= array('CommunityId','MatriId','Name','Email','Paid_Status','ActualMatches','MatchwatchDate');
	$funCondition		= " WHERE Status=0 ORDER BY DateSent LIMIT 0,1000";
	$varMatchwatchMailTbl= 'cbsmatchwatch.matchwatchmail_4';
	$arrMatriIdsDetRes	= $objMailerMatchWatch->select($varMatchwatchMailTbl, $funFields, $funCondition, 0); 
	$objMailerMatchWatch->checkConnection();

	while ($arrMatriIdsDet = mysql_fetch_assoc($arrMatriIdsDetRes)) {
		$varCommunityId			= $arrMatriIdsDet['CommunityId'];
		$varMatriId				= $arrMatriIdsDet['MatriId'];
		$varName				= $arrMatriIdsDet['Name'];
		$varEmail				= $arrMatriIdsDet['Email'];
		$varPaidStatus			= $arrMatriIdsDet['Paid_Status'];
		$varProfileMatchId		= $arrMatriIdsDet['ActualMatches'];
		$arrProfileMatchId		= explode(",",$varProfileMatchId);
		$varMatchwatchSentDate	= $arrMatriIdsDet['MatchwatchDate'];
		$varDomianPrefix		= $arrMatriIdPreSet4[$varCommunityId];
		$varPurpose				= 'match';

		$objMailerMatchWatch->getCommunityWiseDtls($varDomianPrefix);

		//get Partner details for memberid
		$funFields			= array('CommunityId','MatriId','Gender','Age','Partner_Set_Status','Age_From','Age_To','Denomination','MatchDenomination','CasteId','MatchCasteId','SubcasteId','MatchSubcasteId','MatchCountry','Country');
		$funCondition		= " WHERE MatriId='".$varMatriId."'";
		$varDailymatchwatchTbl= 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_4'];
		$arrPartMatriIdsDetRes	= $objMailerMatchWatch->select($varDailymatchwatchTbl, $funFields, $funCondition, 0); 
		$objMailerMatchWatch->checkConnection();
		$arrPartMatriIdsDet		= mysql_fetch_assoc($arrPartMatriIdsDetRes);
		
		$varMemberCountry		= $arrPartMatriIdsDet['Country'];
		$varPartnerAgeFrom		= $arrPartMatriIdsDet['Age_From'];
		$varPartnerAgeTo		= $arrPartMatriIdsDet['Age_To'];
		$varrGender				= $arrPartMatriIdsDet['Gender']; // sess member detail
		$varrAge				= $arrPartMatriIdsDet['Age']; // sess member detail

		if(!($varPartnerAgeFrom>0 && $varPartnerAgeTo>0)) {
			if($varrGender==1) {
				$funStartAge			= ($varrAge - 7);
				$varPartnerAgeFrom		= ($funStartAge > 17) ? $funStartAge : 18;
				$varPartnerAgeTo		= $varrAge;
			} else {
				$varPartnerAgeFrom		= $varrAge;
				$varPartnerAgeFrom		= ($varPartnerAgeFrom > 21) ? $varPartnerAgeFrom : 21;
				$varPartnerAgeTo		= ($varrAge + 7);
			}
		}
		
		$varPartnerSetStatus	= $arrPartMatriIdsDet['Partner_Set_Status'];
		$objMailerMatchWatch->arrPartnerDetails['Age_From'] = $varPartnerAgeFrom;
		$objMailerMatchWatch->arrPartnerDetails['Age_To'] = $varPartnerAgeTo;
		$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteLabel'] = 'Subcaste';
		$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
		$objMailerMatchWatch->arrPartnerDetails['Country'] = 'Any';

		if($arrPartMatriIdsDet['Partner_Set_Status'] == 1) {

			//denomination detail
			if($objMailerMatchWatch->funDenomArrayFeature>0) {
				if($objMailerMatchWatch->funDenomArrayFeature>1) {
					if($arrPartMatriIdsDet['MatchDenomination'] != "" && $arrPartMatriIdsDet['MatchDenomination'] !=0) { 
						$arrDenominationId	= explode('~',$arrPartMatriIdsDet['MatchDenomination']);
						if(sizeof($arrDenominationId) > 5) {
							$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
						} else {
							$strDenominationName	= '';
							for($i = 0; $i < sizeof($arrDenominationId); $i++) {
								$strDenominationName .= $objMailerMatchWatch->arrMWDenomList[$arrDenominationId[$i]].',';
							}
							$strDenominationName = rtrim($strDenominationName,',');
							$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = $strDenominationName;
						}
					}//if
					else {
						$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
					}

					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteLabel'] = $objMailerMatchWatch->funDenomLabel;
				}
			} else if($objMailerMatchWatch->funCasteArrayFeature>0) { //caste detail
				if($objMailerMatchWatch->funCasteArrayFeature>1) {
					if($arrPartMatriIdsDet['MatchCasteId'] != "" && $arrPartMatriIdsDet['MatchCasteId'] !=0) { 
						$arrCasteId		= explode('~',$arrPartMatriIdsDet['MatchCasteId']);
						if(sizeof($arrCasteId) > 5) {
							$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
						} else {
							$strCasteName	= '';
							for($i = 0; $i < sizeof($arrCasteId); $i++) {
								$strCasteName .= $objMailerMatchWatch->arrMWCasteList[$arrCasteId[$i]].',';
							}
							$strCasteName = rtrim($strCasteName,',');
							$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = $strCasteName;
						}
					}//if
					else {
						$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
					}

					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteLabel'] = $objMailerMatchWatch->funCasteLabel;
				}
			} else {
			
			//subcaste detail
			if($objMailerMatchWatch->funSubcasteArrayFeature>0) {
				if($objMailerMatchWatch->funSubcasteArrayFeature>1) {
					if($arrPartMatriIdsDet['MatchSubcasteId'] != "" && $arrPartMatriIdsDet['MatchSubcasteId'] !=0) { 
						$arrSubcasteId		= explode('~',$arrPartMatriIdsDet['MatchSubcasteId']);
						if(sizeof($arrSubcasteId) > 5) {
							$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
						} else {
							$strSubcasteName	= '';
							for($i = 0; $i < sizeof($arrSubcasteId); $i++) {
								$strSubcasteName .= $objMailerMatchWatch->arrMWSubcasteList[$arrSubcasteId[$i]].',';
							}
							$strSubcasteName = rtrim($strSubcasteName,',');
							$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = $strSubcasteName;
						}						
					}//if
					else {
						$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
					}
					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteLabel'] = $objMailerMatchWatch->funSubcasteLabel;
				}
			}
			}

			//country detail
			$arrCountry = array();
			if($arrPartMatriIdsDet['MatchCountry'] != "" && $arrPartMatriIdsDet['MatchCountry'] !=0)
			{ 
				$arrCountry	= Split('~',$arrPartMatriIdsDet['MatchCountry']);
				if(sizeof($arrCountry) > 5) {
					$objMailerMatchWatch->arrPartnerDetails['Country'] = 'Any';
				} else {
					$strCountryName	= '';
					for($i = 0; $i < sizeof($arrCountry); $i++) {
						$strCountryName .= $arrCountryList[$arrCountry[$i]].',';
					}
					$strCountryName = rtrim($strCountryName,',');
					$objMailerMatchWatch->arrPartnerDetails['Country'] = $strCountryName;
				}
			}//if
			else
			{
				$objMailerMatchWatch->arrPartnerDetails['Country'] = 'Any';
			}
		} else {
			$objMailerMatchWatch->arrPartnerDetails['Country']= 'Any';
			if($objMailerMatchWatch->funDenomArrayFeature>1) {
				if($arrPartMatriIdsDet['Denomination']!=0 && $arrPartMatriIdsDet['Denomination']!='') {
					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = $objMailerMatchWatch->arrMWDenomList[$arrPartMatriIdsDet['Denomination']];
				} else {
					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
				}
				$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteLabel'] = $objMailerMatchWatch->funDenomLabel;
			} else if($objMailerMatchWatch->funCasteArrayFeature>1) {
				if($arrPartMatriIdsDet['CasteId']!=0 && $arrPartMatriIdsDet['CasteId']!='') {
					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = $objMailerMatchWatch->arrMWCasteList[$arrPartMatriIdsDet['CasteId']];
				} else {
					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
				}
				$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteLabel'] = $objMailerMatchWatch->funCasteLabel;
			} else if($objMailerMatchWatch->funSubcasteArrayFeature>1) {
				if($arrPartMatriIdsDet['SubcasteId']!=0 && $arrPartMatriIdsDet['SubcasteId']!='') {
					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = $objMailerMatchWatch->arrMWSubcasteList[$arrPartMatriIdsDet['SubcasteId']];
				} else {
					$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteId'] = 'Any';
				}
				$objMailerMatchWatch->arrPartnerDetails['CasteOrSubcasteLabel'] = $objMailerMatchWatch->funSubcasteLabel;
			}
		}
		
		$varReturnVal = '';
		$varReturnVal = $objMailerMatchWatch->sendMatchWatchMail($varCommunityId,$varMatriId,$varName,$varEmail,$varPaidStatus,$varPartnerSetStatus,$arrProfileMatchId,$varPurpose,$varMatchwatchSentDate,$varMemberCountry);

		if($varReturnVal=='yes') {
			$varMatchCount		= count($arrProfileMatchId);
			$argFields 			= array('Status','TotalMatches');
			$argFieldsValues	= array(1,'TotalMatches+'.$varMatchCount);
			$argCondition		= "MatriId = '".$varMatriId."'";
			$varUpdateId		= $objMailerMatchWatch->update($varMatchwatchMailTbl,$argFields,$argFieldsValues,$argCondition);
			$objMailerMatchWatch->checkConnection();
		}
	}
}
?>