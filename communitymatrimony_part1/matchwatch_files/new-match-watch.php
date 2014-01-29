<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2010-11-19
# End Date		: 2010-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
#=============================================================================================================

//FILE INCLUDES
$varServerBasePath	= '/home/product/community';
include_once($varServerBasePath.'/conf/dbinfo.inc');
include_once($varServerBasePath.'/conf/config.inc');
include_once($varServerBasePath.'/conf/mwdomainlist.inc');
include_once($varServerBasePath.'/lib/clsDB.php');
//ini_set('memory_limit','256M');

## Getting command line arguments
$varArgs = $_SERVER['argv'];
$varNumArgs = sizeof( $varArgs )-1;

## Getting domain, days 
$varDaysBefore = 1;
if ($varNumArgs == 3) {
 	$varType = strtoupper($varArgs[1]);
 	$varDaysBefore = $varDaysBefore + $varArgs[2];
	$varSkipCnt = $varArgs[3];
} elseif ($varNumArgs == 2) {
	$varType = strtoupper($varArgs[1]);
	$varDaysBefore = $varDaysBefore + $varArgs[2];
	$varSkipCnt = 0;
} elseif ($varNumArgs == 1) {
	$varType = strtoupper($varArgs[1]);
	$varDaysBefore = $varDaysBefore;
	$varSkipCnt = 0;
} else {
	echo( "Argument is Missing <br>" );
	exit(1);	
}

if($varType==1) {
	$varTableName	= 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_1'];
	$varMWMailTbl	= 'cbsmatchwatch.matchwatchmail_1';
	$arrCommunitySet= $arrMatriIdPreSet1;
	$varMWSentDet	= "MWSentDetail1_";
} else if($varType==2) {
	$varTableName	= 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_2'];
	$varMWMailTbl	= 'cbsmatchwatch.matchwatchmail_2';
	$arrCommunitySet= $arrMatriIdPreSet2;
	$varMWSentDet	= "MWSentDetail2_";
} else if($varType==3) {
	$varTableName	= 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_3'];
	$varMWMailTbl	= 'cbsmatchwatch.matchwatchmail_3';
	$arrCommunitySet= $arrMatriIdPreSet3;
	$varMWSentDet	= "MWSentDetail3_";
} else if($varType==4) {
	$varTableName	= 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_4'];
	$varMWMailTbl	= 'cbsmatchwatch.matchwatchmail_4';
	$arrCommunitySet= $arrMatriIdPreSet4;
	$varMWSentDet	= "MWSentDetail4_";
}


if ($varDaysBefore > 7 || $varDaysBefore < 0) { 
	echo( "Days should be between 0 to 7 <br>" );
	exit(1);
}

//OBJECT DECLARATION
$objDB = new DB;

//CONNECT DB
$objDB->dbConnect('S2',$varMatchwatchDbInfo['DATABASE']);
if($objDB->clsErrorCode!='') {
	echo $objDB->clsErrorCode;
	exit;
}

//GETTING CURRENT DATE, DAY AND DATE BEFORE SOME X DAYS
$select = "select date_sub(Current_date,interval '$varDaysBefore' day),Current_date,DATE_FORMAT(CURRENT_TIMESTAMP, '%a'),DATE_FORMAT(date_sub(Current_date,interval '$varDaysBefore' day), '%D %M %Y')";
if(!$funExecute	= mysql_query($select,$objDB->clsDBLink)) {
	echo mysql_error($objDB->clsDBLink);
	exit;
} else {
	$varRes = mysql_fetch_array($funExecute);
	$varDate	= $varRes[0];
	$varCurrdate= $varRes[1];
	$varCurrDay	= $varRes[2];
	$varMWDate	= addslashes(strip_tags(trim($varRes[3])));
}

//MATCHWATCH DATE
$varMWStTime = $varDate." 00:00:00";
$varMWEndTime= $varDate." 23:59:59";

$arrRestrictedCommId	= array(2005);
foreach($arrCommunitySet as $varCommunityId=>$varCommunityPrefix) {
	if(!in_array($varCommunityId,$arrRestrictedCommId)) {

	//get total profiles for partiicular community
	$funCondition		= " WHERE CommunityId = ".$varCommunityId." AND Matchwatch=1";
	$varTotalNoOfProf	= $objDB->numOfRecords($varTableName, 'MatriId', $funCondition);	

	//all records for particular community in newly added profile table
	$funFields			= array('CommunityId','MatriId','Gender','Age','Height','Physical_Status','Eating_Habits','Smoke','Drink','Marital_Status','Mother_TongueId','Religion','Denomination','CasteId','Caste_Nobar','SubcasteId','Subcaste_Nobar','Education_Category','Citizenship','Country','Residing_State','GothramId','Photo_Set_Status','Chevvai_Dosham','Residing_City','Residing_District','No_Of_Children','Star','Occupation','Temp_Annual_Income');
	$funCondition		= "WHERE CommunityId = ".$varCommunityId." AND Publish=1 AND Profile_Published_On >= '".$varMWStTime."' AND Profile_Published_On <= '".$varMWEndTime."'";
	$varMWMemberInfoTbl	= 'cbsmatchwatch.'.$varTable['MEMBERINFO'];
	$arrNewMatriIdsDet	= $objDB->select($varMWMemberInfoTbl, $funFields, $funCondition, 1); 
	$varTotalNewProfile	= count($arrNewMatriIdsDet);

	if($varTotalNewProfile!=0) { //checking whether new profile added for this community
		$varEmailCount = 0;
		$varSno = $varSkipCnt + 1;

		## Open the txt file to write status
		$filename = $varMWSentDet.str_replace('-','',$varCurrdate);
		$logfile_s = "/home/product/community/bin/tmp/".$filename.".txt"; //for support team
		$handle_log_s = fopen( $logfile_s, "a+" );

		//all records for particular community in whole profile set
		$funFields			= array('CommunityId','MatriId','Nick_Name','Name','Password','Age','Gender','Height','Physical_Status','Paid_Status','Disability_Cause','Disability_Type','Disability_Severity','Disability_Product_Used','Sign_Language','Religion','Denomination','CasteId','SubcasteId','Country','Email','Age_From','Age_To','Height_From','Height_To','MatchMarital_Status','Have_Children','MatchPhysical_Status','MatchMotherTongue','MatchReligion','MatchDenomination','MatchCasteId','MatchSubcasteId','MatchGothramId','Match_Chevvai_Dosham','Eating_HabitsPref','Drinking_HabitsPref','Smoking_HabitsPref','MatchEducation','MatchOccupation','MatchCitizenship','MatchCountry','MatchIndianStates','MatchUSStates','MatchResidentStatus','Matchwatch','Partner_Set_Status','Last_Login','Photo_Set_Status','Horoscope_Available','Phone_Verified','Reference_Set_Status','Family_Set_Status','Interest_Set_Status','Profile_Verified','Video_Set_Status','Voice_Available','Publish','Last_Payment','Valid_Days','Employed_In','Occupation','Occupation_Detail','Activity_Rank','Citizenship','Resident_Status','Residing_State','Residing_Area','Residing_District','Residing_City','MemberGothramId','Date_Updated','IncludeOtherReligions','MatchIndianCity','MatchStarId','MatchGothramId','Income_From','Income_To');
		$funCondition		= " WHERE CommunityId = ".$varCommunityId." AND Publish=1 AND Matchwatch=1 ORDER BY Date_Updated DESC LIMIT ".$varSkipCnt.",".$varTotalNoOfProf;
		$arrOldMatriIdsDetRes= $objDB->select($varTableName, $funFields, $funCondition, 0); 
 
		$i=0;
		while($arrOldMatriIdsDet = mysql_fetch_assoc($arrOldMatriIdsDetRes)) {

			$varMatchMatriId				= $arrOldMatriIdsDet['MatriId'];
			$varMatchCommunityId			= $arrOldMatriIdsDet['CommunityId'];
			$varMatchGender					= $arrOldMatriIdsDet['Gender'];
			$varMatchAge					= $arrOldMatriIdsDet['Age'];
			$varMatchHeight					= $arrOldMatriIdsDet['Height'];
			$varMatchNickName				= addslashes(strip_tags(trim($arrOldMatriIdsDet['Nick_Name'])));
			$varMatchName					= addslashes(strip_tags(trim($arrOldMatriIdsDet['Name'])));
			$varMatchPassword				= addslashes(strip_tags(trim($arrOldMatriIdsDet['Password'])));
			$varMatchPhysicalStatus			= $arrOldMatriIdsDet['Physical_Status'];
			$varMatchDisabilityCause		= $arrOldMatriIdsDet['Disability_Cause'];
			$varMatchDisabilityType			= addslashes(strip_tags(trim($arrOldMatriIdsDet['Disability_Type'])));
			$varMatchDisabilitySeverity		= $arrOldMatriIdsDet['Disability_Severity'];
			$varMatchDisabilityProductUsed	= addslashes(strip_tags(trim($arrOldMatriIdsDet['Disability_Product_Used'])));
			$varMatchSignLanguage			= $arrOldMatriIdsDet['Sign_Language'];
			$varMatchPublish				= $arrOldMatriIdsDet['Publish'];
			$varMatchEmployedIn				= $arrOldMatriIdsDet['Employed_In'];
			$varMatchOccupation				= $arrOldMatriIdsDet['Occupation'];
			$varMatchOccupationDetail		= addslashes(strip_tags(trim($arrOldMatriIdsDet['Occupation_Detail'])));
			$varMatchReligion				= $arrOldMatriIdsDet['Religion'];    //member religion
			$varMatchDenomination			= $arrOldMatriIdsDet['Denomination'];
			$varMatchCasteId				= $arrOldMatriIdsDet['CasteId'];
			$varMatchSubcasteId				= $arrOldMatriIdsDet['SubcasteId'];
			$varMatchCitizenship			= $arrOldMatriIdsDet['Citizenship'];
			$varMatchCountry				= $arrOldMatriIdsDet['Country'];
			$varMatchResidentStatus			= $arrOldMatriIdsDet['Resident_Status'];
			$varMatchResidingState			= $arrOldMatriIdsDet['Residing_State'];
			$varMatchResidingArea			= addslashes(strip_tags(trim($arrOldMatriIdsDet['Residing_Area'])));
			$varMatchResidingDistrict		= $arrOldMatriIdsDet['Residing_District'];
			$varMatchResidingCity			= addslashes(strip_tags(trim($arrOldMatriIdsDet['Residing_City'])));
			$varMatchPaidStatus				= $arrOldMatriIdsDet['Paid_Status'];
			$varMatchPartnerSetStatus		= $arrOldMatriIdsDet['Partner_Set_Status'];
			$varMatchEmail					= addslashes(strip_tags(trim($arrOldMatriIdsDet['Email'])));
			$varMatchwatchEnable			= $arrOldMatriIdsDet['Matchwatch'];
			$varSessMemberReligion			= $varMatchReligion;

			//partner preference detail
			$varStAge					= $arrOldMatriIdsDet['Age_From'];
			$varToAge					= $arrOldMatriIdsDet['Age_To'];
			$varStHeight				= floor($arrOldMatriIdsDet['Height_From']);
			$varToHeight				= ceil($arrOldMatriIdsDet['Height_To']);
			$varPartMaritalStatus		= $arrOldMatriIdsDet['MatchMarital_Status'];
			$varPartPhysicalStatus		= $arrOldMatriIdsDet['MatchPhysical_Status'];
			$varPartMotherTongue		= $arrOldMatriIdsDet['MatchMotherTongue'];
			$varPartReligion			= $arrOldMatriIdsDet['MatchReligion'];
			$varPartDenomination		= $arrOldMatriIdsDet['MatchDenomination'];
			$varPartCasteId				= $arrOldMatriIdsDet['MatchCasteId'];
			$varPartSubcasteId			= $arrOldMatriIdsDet['MatchSubcasteId'];
			$varPartEatingHabitsPref	= $arrOldMatriIdsDet['Eating_HabitsPref'];
			$varPartDrinkingHabitsPref	= $arrOldMatriIdsDet['Drinking_HabitsPref'];
			$varPartSmokingHabitsPref	= $arrOldMatriIdsDet['Smoking_HabitsPref'];
			$varPartEducation			= $arrOldMatriIdsDet['MatchEducation'];
			$varPartCitizenship			= $arrOldMatriIdsDet['MatchCitizenship'];
			$varPartCountry				= $arrOldMatriIdsDet['MatchCountry'];
			$varPartMatchIndianStates	= $arrOldMatriIdsDet['MatchIndianStates'];
			$varPartMatchUSStates		= $arrOldMatriIdsDet['MatchUSStates'];
			$varIncludeOtherReligions	= $arrOldMatriIdsDet['IncludeOtherReligions'];
			$varHaveChildren	        = $arrOldMatriIdsDet['Have_Children'];
			$varMatchChevvaiDosham	    = $arrOldMatriIdsDet['Match_Chevvai_Dosham'];
			$varMatchResidentStatus	    = $arrOldMatriIdsDet['MatchResidentStatus'];
			$varResidingStateStatus     = $varPartMatchIndianStates.'|'.$varPartMatchUSStates;
			
           
			if(!($varStAge>0 && $varToAge>0)) {
				if($varMatchGender==1) {
					$funStartAge			= ($varMatchAge - 7);
					$varStAge				= ($funStartAge > 17) ? $funStartAge : 18;
					$varToAge				= $varMatchAge;
				} else {
					$varStAge				= $varMatchAge;
					$varStAge				= ($varStAge > 21) ? $varStAge : 21;
					$varToAge				= ($varMatchAge + 7);
				}
			}

			if(!($varStHeight>0 && $varToHeight>0)) {
				if($varMatchGender==1) {
					$funStartHeight			= ($varMatchHeight - 15.24);
					$varStHeight			= ($funStartHeight > 121.91) ? $funStartHeight	: 121.92;
					$varToHeight			= $varMatchHeight;
				} else {
					$varStHeight			= $varMatchHeight;
					$varToHeight			= ($varMatchHeight + 30.48);
				}
			}
           
			$arrMatchCond = array('MWCommunityId'=>$arrOldMatriIdsDet['CommunityId'],'MWGender'=>$arrOldMatriIdsDet['Gender'],'MWAgeFrom'=>$varStAge,'MWAgeTo'=>$varToAge,'MWHeightFrom'=>$varStHeight,'MWHeightTo'=>$varToHeight,'MWMatchMaritalStatus'=>$arrOldMatriIdsDet['MatchMarital_Status'],'MWMatchPhysicalStatus'=>$arrOldMatriIdsDet['MatchPhysical_Status'],'MWMatchMotherTongue'=>$arrOldMatriIdsDet['MatchMotherTongue'],'MWMatchReligion'=>$arrOldMatriIdsDet['MatchReligion'],'MWMatchDenomination'=>$arrOldMatriIdsDet['MatchDenomination'],'MWMatchCasteId'=>$arrOldMatriIdsDet['MatchCasteId'],'MWMatchSubcasteId'=>$arrOldMatriIdsDet['MatchSubcasteId'],'MWMemberGothramId'=>$arrOldMatriIdsDet['MemberGothramId'],'MWEatingHabitsPref'=>$arrOldMatriIdsDet['Eating_HabitsPref'],'MWDrinkingHabitsPref'=>$arrOldMatriIdsDet['Drinking_HabitsPref'],'MWSmokingHabitsPref'=>$arrOldMatriIdsDet['Smoking_HabitsPref'],'MWMatchEducation'=>$arrOldMatriIdsDet['MatchEducation'],'MWMatchCitizenship'=>$arrOldMatriIdsDet['MatchCitizenship'],'MWMatchCountry'=>$arrOldMatriIdsDet['MatchCountry'],'MWMatchIndianStates'=>$arrOldMatriIdsDet['MatchIndianStates'],'MWMatchUSStates'=>$arrOldMatriIdsDet['MatchUSStates'],'MWPhotoSetStatus'=>$arrOldMatriIdsDet['Photo_Set_Status'],'MWPaidStatus'=>$arrOldMatriIdsDet['Paid_Status'],'MWMemberReligion'=>$varSessMemberReligion,'MWIncludeOtherReligions'=>$arrOldMatriIdsDet['IncludeOtherReligions'],'MWMatch_Chevvai_Dosham'=>$arrOldMatriIdsDet['Match_Chevvai_Dosham'],'MWMatchIndianCity'=>$arrOldMatriIdsDet['MatchIndianCity'],'MWHave_Children'=>$arrOldMatriIdsDet['Have_Children'],'MWMatchStarId'=>$arrOldMatriIdsDet['MatchStarId'],'MWMatchOccupation'=>$arrOldMatriIdsDet['MatchOccupation'],'MWMatchGothramId'=>$arrOldMatriIdsDet['MatchGothramId'],'MWIncome_From'=>$arrOldMatriIdsDet['Income_From'],'MWIncome_To'=>$arrOldMatriIdsDet['Income_To'],'MWMemberCasteId'=>$arrOldMatriIdsDet['CasteId'],'MWMemberReligion'=>$arrOldMatriIdsDet['Religion']);

			if($varMatchwatchEnable==1) {
                 $arrMatchIds    = array(); 
				 $idealMatchIds	 = array();
				
				if($varMatchPartnerSetStatus ==1){
					$idealMatchIds_I = "";
					$idealMatchIds	 = getMatches($arrNewMatriIdsDet,$arrMatchCond,1); //Third Parameter - 1 for ideal match
					$varTotalNoOfMatches = count($idealMatchIds);
				}else{
					$actMatchIds_I  = "";
					$arrMatchIds	= getMatches($arrNewMatriIdsDet,$arrMatchCond,0);
					$varTotalNoOfMatches = count($arrMatchIds);
				}
                
				if((count($arrMatchIds) <= 0) && (count($idealMatchIds) > 0)) {
				    $arrMatchIds = $idealMatchIds;
			    }
               
				if($varTotalNoOfMatches>0) {

					//Getting partner preference detail
					$varPartnerPref = "CommunityId:".$varMatchCommunityId."|^Age:".$varStAge." to ".$varToAge."|^Height:".$varStHeight." to  ".$varToHeight."|^Looking_for:".$varPartMaritalStatus."|^Physical_status:".$varPartPhysicalStatus."|^Mothertongue:".$varPartMotherTongue."|^Religion:".$varPartReligion."|^Denomination:".$varPartDenomination."|^Caste:".$varPartCasteId."|^Subcaste:".$varPartSubcasteId."|^Eating_Habits:".$varPartEatingHabitsPref."|^Smoking_Habits:".$varPartSmokingHabitsPref."|^Drinking_Habits:".$varPartDrinkingHabitsPref."|^Education:".$varPartEducation."|^Citizenship:".$varPartCitizenship."|^PartnerCountry:".$varPartCountry."|^Residing_state:".$varResidingStateStatus."|^Country:".$varMatchCountry."|^PaidStatus:".$varMatchPaidStatus."|^Have_children:".$varHaveChildren."|^Manglik:".$varMatchChevvaiDosham."|^Resident_status:".$varMatchResidentStatus;

    				$varActMatchIds      = addslashes(strip_tags(trim(implode(",",$arrMatchIds[0]))));
					$varActIdealMatchIds = addslashes(strip_tags(trim(implode(",",$idealMatchIds[1]))));
					$arrFields		= array('MatriId','CommunityId','Nick_Name','Name','Password','ActualMatches','IdealMatches','Status','DateSent','Email','MatchwatchDate','PartnerSettings','Physical_Status','Disability_Cause','Disability_Type','Disability_Severity','Disability_Product_Used','Sign_Language','Publish','Paid_Status','Partner_Set_Status','Employed_In','Occupation','Occupation_Detail','Religion','Denomination','CasteId','SubcasteId','Citizenship','Country','Resident_Status','Residing_State','Residing_Area','Residing_District','Residing_City','MatchwatchSentDate');
					$arrFieldsValues= array("'".$varMatchMatriId."'","'".$varMatchCommunityId."'","'".$varMatchNickName."'","'".$varMatchName."'","'".$varMatchPassword."'","'".$varActMatchIds."'","'".$varActIdealMatchIds."'",0,'NOW()',"'".$varMatchEmail."'","'".$varMWDate."'","'".addslashes(strip_tags(trim($varPartnerPref)))."'","'".$varMatchPhysicalStatus."'","'".$varMatchDisabilityCause."'","'".$varMatchDisabilityType."'","'".$varMatchDisabilitySeverity."'","'".$varMatchDisabilityProductUsed."'","'".$varMatchSignLanguage."'","'".$varMatchPublish."'","'".$varMatchPaidStatus."'","'".$varMatchPartnerSetStatus."'","'".$varMatchEmployedIn."'","'".$varMatchOccupation."'","'".$varMatchOccupationDetail."'","'".$varMatchReligion."'","'".$varMatchDenomination."'","'".$varMatchCasteId."'","'".$varMatchSubcasteId."'","'".$varMatchCitizenship."'","'".$varMatchCountry."'","'".$varMatchResidentStatus."'","'".$varMatchResidingState."'","'".$varMatchResidingArea."'","'".$varMatchResidingDistrict."'","'".$varMatchResidingCity."'","'".$varDate."'");

					$objDB->insertIgnore($varMWMailTbl, $arrFields, $arrFieldsValues);


					//Mail sent time
					$timesent_each = date("h:i:s");
					if ($varSno % 1000 == 0) {
						//echo( "$Sno Mails Sent ... Time sent $timesent_each ... \n" );	 
						fwrite( $handle_log_s, $content );
						$content = "";	 
					}
					$content .= "$varSno  Id: $varMatchMatriId    Total Match : $varTotalNoOfMatches  Time Sent : $timesent_each \n\n";
					$varSno++;
					$varEmailCount++;
				} else {
					$filenameMWnotsent = "/home/product/community/bin/tmp/matchwatchmailnotsent".'-'.date('dMy').".txt";
					$handle = fopen($filenameMWnotsent, "a");
					fwrite($handle,$varMatchMatriId."\n");
					fclose($handle);
				}
			}

		}
		fwrite( $handle_log_s, $content );
		$edtime = date("h:i:s");
		fwrite( $handle_log_s, "Date : $varCurrdate MatchWatch Date : $varDate \n\nCommunityId : $varCommunityId  Total Profiles : $varTotalNoOfProf  New Profiles : $varTotalNewProfile Total Mails Sent : $varEmailCount \n\n" );
		chmod( $logfile_s, 0777 );
		fclose( $handle_log_s );
	} else {
		echo $varErrorMsg	= "There is no new profile for CommunityId : ".$varCommunityId;
	}
}	
}

function insertIgnore1($argTblName, $argFields, $argFieldsValue)
	{
		if(count($argFields) == count($argFieldsValue))
		{
			$funQuery  = 'INSERT IGNORE INTO '.$argTblName.'('.join(',', $argFields).') VALUES ('.join(',', $argFieldsValue).')';
			print "<br>".$funQuery;
			
		}
	}
function getMatches($arrNewMatriIdsDet,$arrMatchCond,$varMatchType){
global $ANNUALINCOMEINRHASH,$ANNUALINCOMEINRVALUEHASH,$ANNUALINCOMEDOLLARHASH,$ANNUALINCOMEDOLLARVALUEHASH;
			$varNoOfMatches		= 0;
			$varNewProfCnt		= count($arrNewMatriIdsDet);
			$varSendMatchesLimit= 0;
			$varSendMatchesLimit= ($arrMatchCond['MWPaidStatus']==1)?50:10;

			for($j=0; $j<$varNewProfCnt; $j++) {
                				
				## Gender Condition
				//if ($arrMatchCond['MWGender'] != $arrNewMatriIdsDet[$j]['Gender']) {
				if ($arrMatchCond['MWGender']!=$arrNewMatriIdsDet[$j]['Gender'] && $arrMatchCond['MWGender']>0 && $arrNewMatriIdsDet[$j]['Gender']>0) {
					$varFlag = 0;
                    
					##Check community condition
					if ($arrMatchCond['MWCommunityId'] == $arrNewMatriIdsDet[$j]['CommunityId']) {
						$varFlag = 0;
					} else {
						$varFlag = 1;
						continue;
					}
					                    
					## Matching age condition
					if($arrNewMatriIdsDet[$j]['Age'] >= $arrMatchCond['MWAgeFrom'] && $arrNewMatriIdsDet[$j]['Age'] <= $arrMatchCond['MWAgeTo']){
						$varFlag = 0;
					}
					else {
						$varFlag = 1;
						continue;
					}
		
					## Matching height condition
					if($arrNewMatriIdsDet[$j]['Height'] >= floor($arrMatchCond['MWHeightFrom']) && $arrNewMatriIdsDet[$j]['Height'] <= ceil($arrMatchCond['MWHeightTo'])){
						$varFlag = 0;	
					}
					else {
						$varFlag = 1;
						continue;
					}
					
                    
					## Matching mothertongue condition
					$Mothertoungearr = explode( "~", $arrMatchCond['MWMatchMotherTongue']);
					if (trim($arrMatchCond['MWMatchMotherTongue']) != '' && in_array(0,$Mothertoungearr) == FALSE) {	
						//print_r($Mothertoungearr);
						$mothertongue = $arrNewMatriIdsDet[$j]['Mother_TongueId'];
						$match = in_array($mothertongue, $Mothertoungearr);
						if (!$match) {
							$varFlag = 1;
							continue;
						}
					}
                   
				   $varCastearr = explode( "~", $arrMatchCond['MWMatchCasteId']);
				   if($arrMatchCond['MWIncludeOtherReligions'] == 1 && !in_array("0",$varCastearr) && trim($arrMatchCond['MWMatchReligion']) != '' && trim($arrMatchCond['MWMatchCasteId']) != '') 
					{
					    //Check Other Religion Matching Profile
						$varIdealCasteArray= mwOtherReligionCasteMapping($arrMatchCond['MWMemberCasteId'],$arrMatchCond['MWMemberReligion']);
						
						if(!in_array($arrNewMatriIdsDet[$j]['CasteId'],$varIdealCasteArray['CASTE'])) {
							$varFlag = 1;
							continue;
						}

						if(!in_array($arrNewMatriIdsDet[$j]['Religion'],$varIdealCasteArray['RELIGION'])) {
							$varFlag = 1;
							continue;
						}
                        
					}else{ 
					
					## Matching religion condition
					$Religionarr = explode( "~", $arrMatchCond['MWMatchReligion'] );
					if (trim($arrMatchCond['MWMatchReligion']) != '' && in_array(0,$Religionarr)  == FALSE && in_array(9,$Religionarr)  == FALSE) {
						if($arrMatchCond['MWCommunityId']==2006 || $arrMatchCond['MWCommunityId']==2004 || $arrMatchCond['MWCommunityId']==2002 || $arrMatchCond['MWCommunityId']==2001 || $arrMatchCond['MWCommunityId']==2000) {
							if(in_array(2,$Religionarr)) {			//Muslim
								$Religionarr[] = 10;
								$Religionarr[] = 11;
							} else if(in_array(3,$Religionarr)) { 	//Christian
								$Religionarr[] = 12;
								$Religionarr[] = 13;
								$Religionarr[] = 14;
							} else if(in_array(5,$Religionarr)) {		//Jain
								$Religionarr[] = 15;
								$Religionarr[] = 16;
							}
						} else if($arrMatchCond['MWCommunityId']==2003) {
							if(in_array(5,$Religionarr)) {		//Jain
								$Religionarr[] = 15;
								$Religionarr[] = 16;
							}
						}

						$Religion = $arrNewMatriIdsDet[$j]['Religion'];				
						$match = in_array( $Religion, $Religionarr);
						if (!$match) {
							$varFlag = 1;
							continue;
						}
					} else {
						$varSessMemberReligion	= $arrMatchCond['MWMemberReligion'];
						$Religionarr			= array();

						if($varSessMemberReligion!=0 && $varSessMemberReligion!='') {
							if(($arrMatchCond['MWCommunityId']==2006 || $arrMatchCond['MWCommunityId']==2004 || $arrMatchCond['MWCommunityId']==2002 || $arrMatchCond['MWCommunityId']==2001 || $arrMatchCond['MWCommunityId']==2000) && $varSessMemberReligion!=9) { 		//anycaste, ability and divorcee matrimony
								$Religionarr[]		= $varSessMemberReligion;

								if($varSessMemberReligion==2) {
									$Religionarr[] = 10;
									$Religionarr[] = 11;
								} else if($varSessMemberReligion==3) { 	//Christian
									$Religionarr[] = 12;
									$Religionarr[] = 13;
									$Religionarr[] = 14;
								} else if($varSessMemberReligion==5) {		//Jain
									$Religionarr[] = 15;
									$Religionarr[] = 16;
								}
								$Religion = $arrNewMatriIdsDet[$j]['Religion'];				
								$match = in_array( $Religion, $Religionarr);
								if (!$match) {
									$varFlag = 1;
									continue;
								}

							} else if($arrMatchCond['MWCommunityId']==2003 && $varSessMemberReligion!=9) { //manglik matrimony
								$Religionarr[]		= $varSessMemberReligion;
								
								if($varSessMemberReligion==5) {		//Jain
									$Religionarr[] = 15;
									$Religionarr[] = 16;
								}

								$Religion = $arrNewMatriIdsDet[$j]['Religion'];				
								$match = in_array( $Religion, $Religionarr);
								if (!$match) {
									$varFlag = 1;
									continue;
								}
							}
						} else {
							$varFlag = 1;
							continue;
						}
					}
                     
					## Matching caste condition - no test
					$varCastearr = explode( "~", $arrMatchCond['MWMatchCasteId']);
					if(trim($arrMatchCond['MWMatchCasteId']) != '' && in_array(0,$varCastearr) == FALSE)
					{
						$Caste      = $arrNewMatriIdsDet[$j]['CasteId'];
						$CasteNoBar = $arrNewMatriIdsDet[$j]['Caste_Nobar'];
						$match      = in_array($Caste, $varCastearr);
                        
						//default value for castnobar 998 
						if (in_array('998', $varCastearr) && $CasteNoBar != 1 && $Caste != 0 && in_array($Caste, $varCastearr) == FALSE) {
								//If member pref has casteNoBar. Then match caste = 0 OR casteNoBar = 1;
								//If member has any caste selected, then check if member pref matches it.
								$varFlag = 1;
								continue;
						}
						if (!$match) {
							$varFlag = 1;
							continue;
						}
					}

					}
                    
					## Matching denomination condition - no test
					$varDenominationarr = explode( "~", $arrMatchCond['MWMatchDenomination'] );
					if (trim($arrMatchCond['MWMatchDenomination']) != '' && in_array(0,$varDenominationarr)  == FALSE) {
						$varDenomination = $arrNewMatriIdsDet[$j]['Denomination'];				
						$match = in_array( $varDenomination, $varDenominationarr);
						if (!$match) {
							$varFlag = 1;
							continue;
						}
					}

                    
					## Matching Gothra condition
					if($arrMatchCond['MWMemberGothramId'] != "" && $arrMatchCond['MWMemberGothramId'] !=0 && $arrMatchCond['MWMemberGothramId'] !=999 && $arrMatchCond['MWMemberGothramId'] !=9997 && $arrMatchCond['MWMemberGothramId'] !=9998 && $arrMatchCond['MWMemberGothramId'] !=9999) { 
						
						if ($arrMatchCond['MWMemberGothramId'] == $arrNewMatriIdsDet[$j]['GothramId']){
							$varFlag = 1;
							continue;
						}

						$varGothraarr = explode("~",$arrMatchCond['MWMatchGothramId']);
						if(in_array(0,$varGothraarr) == FALSE)
						{   
							//default value for All (Except your gothra) 998
							if(in_array(998,$varGothraarr) && $arrMatchCond["MWMemberGothramId"] > 0 && ($arrMatchCond["MWMemberGothramId"] == $arrNewMatriIdsDet[$j]['GothramId'])){
								$varFlag = 1;
								continue;
							} 
							else if(in_array(998,$varGothraarr) == FALSE){
								$gothra = $arrNewMatriIdsDet[$j]['GothramId'];
								$match = in_array($gothra, $varGothraarr);
								if (!$match) {
									$varFlag = 1;
									continue;
								}
							}
						}
					}
                   
				    ## Matching manglik condition
					$varManglikarr = explode("~", $arrMatchCond['MWMatch_Chevvai_Dosham']);
					if(trim($arrMatchCond['MWMatch_Chevvai_Dosham']) != '' && in_array(0, $varManglikarr) == FALSE && $arrNewMatriIdsDet[$j]['Chevvai_Dosham'] !=3) //If Manglik is not selected in Member Preference, then the value will be 0; If member profile has dosham 3 then do not check manglik condition.
					{
						/*In Reg - Matrimonyprofile
						"1" - Yes; "2" - No; "3" - Don't know; 0 - Not Selected any value
											
						Matchwatch Pref - Dosham/Manglik
						1 - Yes; 2 - No; 3 - Not given; 0 - Not Selected [Any]

						If memberpref is  YES, then match YES 1 => 1,3
						If memberpref is NO, then match No, Don't know, Not Selected. 2 => 2, 3, 0	 
						If memberoref is NotGiven, then match Don't know and Not Selected. 3 => 3,0
						*/		
						
						if(!(in_array(1, $varManglikarr)  && in_array(2, $varManglikarr) )) //If member pref has YES, NO then all the profile match.
						{	
							$varManglik = $arrNewMatriIdsDet[$j]['Chevvai_Dosham'];
							if(in_array(1, $varManglikarr)  && in_array(3, $varManglikarr)  && $varManglik == 2) //If member pref is YES &  NOT GIVEN, then Manglik NO is not a match
							{
							    $varFlag = 1;
								continue;
							}
							else if(in_array(2, $varManglikarr)  && in_array(3, $varManglikarr)  && $varManglik == 1) //If member pref is NO &  NOT GIVEN, then Manglik YES is not a match
							{
								$varFlag = 1;
								continue;
							}
							else if(in_array(1, $varManglikarr) == TRUE && in_array(2, $varManglikarr) == FALSE && in_array(3, $varManglikarr) == FALSE && ($varManglik  == 2 || $varManglik  == 0)) {								
								$varFlag = 1;
								continue;
							}						
							else if(in_array(2, $varManglikarr) == TRUE && in_array(1, $varManglikarr) == FALSE && in_array(3, $varManglikarr) == FALSE && $varManglik == 1) {
								
								$varFlag = 1;
								continue;	
							}
							else if(in_array(3, $varManglikarr) == TRUE && in_array(1, $varManglikarr) == FALSE && in_array(2, $varManglikarr) == FALSE && ($varManglik == 1 || $varManglik == 2)){
								
								$varFlag = 1;
								continue;	
							}
							
						}
						
                         

					}
										                    
					## Matching maritalstatus condition
					$varMaritalstatusarr = explode("~",$arrMatchCond['MWMatchMaritalStatus']);
					if (trim($arrMatchCond['MWMatchMaritalStatus']) != '' && in_array(0,$varMaritalstatusarr) == FALSE ) {	
						$varMaritalStatus = $arrNewMatriIdsDet[$j]['Marital_Status'];
						$match = in_array( $varMaritalStatus, $varMaritalstatusarr );
						if (!$match) {
							$varFlag = 1;
							continue;
						}
					}
					
					## Matching physical status condition
					/* Matchwatch Preference Values
					0 - Normal; 1 - Disabled; 2 - Doesn't matter
					*/
					if(trim($arrMatchCond['MWMatchPhysicalStatus']) != '' && ($arrMatchCond['MWMatchPhysicalStatus'] == 0 || $arrMatchCond['MWMatchPhysicalStatus'] == 1)) {	
						if($arrMatchCond['MWMatchPhysicalStatus'] != $arrNewMatriIdsDet[$j]['Physical_Status']){
							$varFlag = 1;
							continue;
						}
					}		
					
                    ## Matching eating habits condition
					/*1-Vegetarian; 2- Non Vegetarian; 3- Eggetarian 
					Eating Habits	Mapping	
					Veg			1 - 1,3		Veg+Egg.	
					Egg			3 - 1,2,3	Veg+Egg+Non-Veg 	
					Non veg	    2 - 2,3		Non-Veg+Egg.*/
                    
					$varEatinghabitsarr = explode("~", $arrMatchCond['MWEatingHabitsPref']);
					if (trim($arrMatchCond['MWEatingHabitsPref']) != '' && in_array(0,$varEatinghabitsarr) == FALSE  && $arrNewMatriIdsDet[$j]['Eating_Habits'] != 3  && $arrNewMatriIdsDet[$j]['Eating_Habits'] != 0) {		
							$varEatinghabits = $arrNewMatriIdsDet[$j]['Eating_Habits'];
							if(in_array(2, $varEatinghabitsarr) == TRUE && in_array(1, $varEatinghabitsarr) == FALSE && in_array(3, $varEatinghabitsarr) == FALSE && $varEatinghabits == 1){
								$varFlag = 1;
								continue;
							}
							if(in_array(1, $varEatinghabitsarr) == TRUE && in_array(2, $varEatinghabitsarr) == FALSE && in_array(3, $varEatinghabitsarr) == FALSE && $varEatinghabits == 2){
								$varFlag = 1;
								continue;
							}
					}
                    
					## Matching education condition
					$varEducationarr = explode("~",$arrMatchCond['MWMatchEducation']);
					if (trim($arrMatchCond['MWMatchEducation']) != '' && in_array(0,$varEducationarr) == FALSE) {
						$varEducation = $arrNewMatriIdsDet[$j]['Education_Category'];
						$match = in_array($varEducation, $varEducationarr);
						if (!$match) {
							$varFlag = 1;
							continue;
						}				
					}
					
					## Matching citizenship condition
					$varCitizenshiparr = explode( "~", $arrMatchCond['MWMatchCitizenship'] );
					if(trim($arrMatchCond['MWMatchCitizenship']) != '' && in_array(0,$varCitizenshiparr) == FALSE){
						$varCitizenship = $arrNewMatriIdsDet[$j]['Citizenship'];
						$match = in_array( $varCitizenship, $varCitizenshiparr );
						if (!$match) {
							$varFlag = 1;
							continue;
						}
					}
                    
					## Matching country condition
					$varCountryarr = explode( "~", $arrMatchCond['MWMatchCountry']);
					if (trim($arrMatchCond['MWMatchCountry']) != '' && in_array(0,$varCountryarr) == FALSE) {
						$varCountrysel = $arrNewMatriIdsDet[$j]['Country'];
						$match = in_array($varCountrysel, $varCountryarr);
						if (!$match) {
							$varFlag = 1;
							continue;
						}
					}
                    
					## Matching states condition when country selected India					
					if ($arrNewMatriIdsDet[$j]['Country'] == 98) {
						$varMatchIndianarr = explode("~",$arrMatchCond['MWMatchIndianStates']);
						if (trim($arrMatchCond['MWMatchIndianStates']) != '' && in_array(0,$varMatchIndianarr) == FALSE) {
							$varResidingState = $arrNewMatriIdsDet[$j]['Residing_State'];
							$match = in_array( $varResidingState, $varMatchIndianarr);
							if (!$match) {
								$varFlag = 1;
								continue;
							}							
						}
					}

					
					## Matching states condition when country selected USA
					if ($arrNewMatriIdsDet[$j]['Country'] == 222) {
						$varMatchUSarr = explode("~",$arrMatchCond['MWMatchUSStates'] );
						if (trim($arrMatchCond['MWMatchUSStates']) != '' && in_array(0,$varMatchUSarr) == FALSE) {
							$varResidingState = $arrNewMatriIdsDet[$j]['Residing_State'];
							$match = in_array($varResidingState,$varMatchUSarr);
							if (!$match) {
								$varFlag = 1;
								continue;
							}
						}
   					}
					
                    
					#################### IDEAL MATCH START ####################
					if($varMatchType == 1)	//Check Ideal Match
					{
						$isIdealMatchflag = 0;
						## Matching City Condition when country selected India and indian states are selected
						//Country is 98; If $matchcond['IndianStates'] is > 0 then City has to be checked for ideal match.
						if(trim($arrMatchCond['MWMatchIndianStates'])!=''&&($arrMatchCond['MWMatchIndianStates']!=0)&&($arrNewMatriIdsDet[$j]['Country']==98 || $arrNewMatriIdsDet[$j]['Country']==0)) {

							$varMatchIndianarr = explode( "~", $arrMatchCond['MWMatchIndianStates'] );
							$varResidingState = $arrNewMatriIdsDet[$j]['Residing_State'];
                            if(in_array($varResidingState, $varMatchIndianarr)&& trim($arrMatchCond['MWMatchIndianCity']) != ''){		
								$varCityarr = explode("~",$arrMatchCond['MWMatchIndianCity']);
								$varCity    = $arrNewMatriIdsDet[$j]['Residing_District'];						

								if(in_array(0, $varCityarr)){
									$isIdealMatchflag = 1;	
								}
								else{						
									if (in_array($varCity, $varCityarr)) {
										$isIdealMatchflag = 1;
									}
									else
										$isIdealMatchflag = 0;
								}
							}
							else
								$isIdealMatchflag = 1;
						}
						else 
							$isIdealMatchflag = 1;
                        
						
						## Matching HaveChildren condition
						/*
						If member preference has only unamarried, Have children will not be considered for ideal match
						values of $matchcond['MaritalStatus']	
						0 - Doesn't matter
						2 - Yes. living together
						3 - Yes. not living together
						1 - No
						*/
						if($isIdealMatchflag == 1 && trim($arrMatchCond['MWHave_Children'])!='')
						{
							$varHavechildrenarr = explode("~",$arrMatchCond['MWHave_Children']);
							$varMaritalstatusarr = explode("~",$arrMatchCond['MWMatchMaritalStatus']);
							if(in_array(0,$varHavechildrenarr)) //If havechildren is doesn't Matter then Ideal Match
							{
								$isIdealMatchflag = 1;
							}
							else if(count($varMaritalstatusarr) == 1 && $varMaritalstatusarr[0] == 1){
								$isIdealMatchflag = 1;
							}
							else
							{
								if($arrNewMatriIdsDet[$j]['Marital_Status'] == 1){
									//If member[new matching profile] is unmarried, don't need to check Have Children
									$isIdealMatchflag = 1;
								}
								else{//If new matching profile is not unmarried
									if($arrNewMatriIdsDet[$j]['No_Of_Children'] == 0 && in_array(1,$varHavechildrenarr)){
										//members preference has No , then value is  [1]; new matching profile has No , then value is [0]
										$isIdealMatchflag = 1;
									}								
									else if($arrNewMatriIdsDet[$j]['No_Of_Children'] == 1 && in_array( 2, $varHavechildrenarr )){
										//members preference has Yes, Living together , then value is  [2]; new matching profile has Yes, Living togethe , then value is [1]
										$isIdealMatchflag = 1;
									}								
									else if($arrNewMatriIdsDet[$j]['No_Of_Children'] == 2 && in_array( 3, $varHavechildrenarr )){
										//members preference has Yes, Not Living together , then value is  [3]; new matching profile has Yes, Not Living togethe , then value is [2]
										$isIdealMatchflag = 1;
									}
									else
										$isIdealMatchflag == 0;
								}
							}
						}
						else if($isIdealMatchflag == 1)
							$isIdealMatchflag = 1;
                        
						
					    ## Matching Star condition
						//Star will be considered only when member belong to Hindu or Christian religion.
						if(trim($arrMatchCond['MWMatchStarId']) != '' && in_array($arrNewMatriIdsDet[$j]['Religion'],array(1,12,13,14,3))  && $isIdealMatchflag == 1)
						{
							$vasStararr = explode( "~", $arrMatchCond['MWMatchStarId'] );
							if(in_array(0,$vasStararr)){
								$isIdealMatchflag = 1;
							}
							else if(in_array($arrNewMatriIdsDet[$j]['Star'], $vasStararr )){
								$isIdealMatchflag = 1;
							}
							else
								$isIdealMatchflag = 0;
						}
						else if($isIdealMatchflag == 1)
							$isIdealMatchflag = 1;

						                       
						## Matching Occupation condition 
						##Occupation,Occupation_Detail,MatchOccupation (dailymatchwatch_1)
						##Occupation,Occupation_Detail (memberinfo)
						if(trim($arrMatchCond['MWMatchOccupation']) != '' && $isIdealMatchflag == 1)
						{
							$varOccupationarr = explode("~",$arrMatchCond['MWMatchOccupation']);
							if(in_array(0,$varOccupationarr)){
								$isIdealMatchflag = 1;
							}
							else
							{
								$varOccupationSelected     = $arrNewMatriIdsDet[$j]['Occupation'];
								if($arrNewMatriIdsDet[$j]['Employed_In'] == 4)
									$varOccupationSelected = 101; //Business
								else if($arrNewMatriIdsDet[$j]['Employed_In'] == 5)
									$varOccupationSelected = 102; //Not Working
								
								if(in_array($arrNewMatriIdsDet[$j]['Occupation'],$varOccupationarr)){
									$isIdealMatchflag = 1;
								}
								else
									$isIdealMatchflag = 0;
							}

						}else if($isIdealMatchflag == 1)
							$isIdealMatchflag = 1;
                        
						## Matching drinking habits condition
						/*1-Non drinker; 2- Light / Social drinker; 3- Regular drinker 
						Drinking Habits	Mapping	
						Non drinker			1 - 1		
						Light drinker		2 - 1,2 	
						Regular drinker		3 - 1,2,3	*/

						## Matching Drinking condition
						if(trim($arrMatchCond['MWDrinkingHabitsPref']) != '' && $isIdealMatchflag == 1)
						{
							$varDrinkingarr = explode( "~", $arrMatchCond['MWDrinkingHabitsPref'] );	
							if(in_array(0,$varDrinkingarr)){
								$isIdealMatchflag = 1;
							}
							else if(in_array($arrNewMatriIdsDet[$j]['Drink'], $varDrinkingarr )) {
								$isIdealMatchflag = 1;								
							}				
							else
								$isIdealMatchflag = 0;
						}
						else if($isIdealMatchflag == 1)
							$isIdealMatchflag = 1; 

						
						## Matching smoking habits condition
						/*1-Non smoker; 2- Light / Social smoker; 3- Regular smoker 
						Smoking Habits	Mapping	
						Non smoker			1 - 1		
						Light smoker		2 - 1,2 	
						Regular smoker 		3 - 1,2,3	*/

						if(trim($arrMatchCond['MWSmokingHabitsPref']) != '' && $isIdealMatchflag == 1)
						{
							$varSmokingarr = explode( "~", $arrMatchCond['MWSmokingHabitsPref'] );
							if(in_array(0,$varSmokingarr)){
								$isIdealMatchflag = 1;
							}
							else if(in_array($arrNewMatriIdsDet[$j]['Smoke'], $varSmokingarr )){					$isIdealMatchflag = 1;								
							}
							else
								$isIdealMatchflag = 0;
						}
						else if($isIdealMatchflag == 1)
							$isIdealMatchflag = 1;

                       				
					  	## Matching Subcaste condition
						if(trim($arrMatchCond['MWMatchSubcasteId']) != '' && $isIdealMatchflag == 1)
						{
							$varSubcastearr = explode("~",$arrMatchCond['MWMatchSubcasteId']);
							if(in_array(0,$varSubcastearr)){
								$isIdealMatchflag = 1;
							}
							else if(in_array($arrNewMatriIdsDet[$j]['SubcasteId'], $varSubcastearr)){
								$isIdealMatchflag = 1;								
							}
							else
								$isIdealMatchflag = 0;
						}
						else if($isIdealMatchflag == 1)
							$isIdealMatchflag = 1;

                      
						if ($arrMatchCond['MWIncome_From'] != 0 && trim($arrMatchCond['MWIncome_To']) != '' && (in_array(98,$varCountryarr) || in_array(0, $varCountryarr) || trim($arrMatchCond['Country']) != '') && $isIdealMatchflag == 1)
						{
							if($arrMatchCond['MWIncome_From'] == 1)	//If member select Less than 50000
							{
								if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= 1 && $arrNewMatriIdsDet[$j]['Temp_Annual_Income'] <= $ANNUALINCOMEINRVALUEHASH[1])
								{
									$isIdealMatchflag = 1;	
								}
								else
									$isIdealMatchflag = 0;
							}
							else if($arrMatchCond['MWIncome_From'] == 29)
							{
								if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= $ANNUALINCOMEINRVALUEHASH[29])
								{
									$isIdealMatchflag = 1;	
								}
								else
									$isIdealMatchflag = 0;
							}
							else if($arrMatchCond['MWIncome_From'] >= 2 && $arrMatchCond['MWIncome_To'] <= 28)
							{
								if($arrMatchCond['MWIncome_From'] >= 2 && $arrMatchCond['MWIncome_To'] == 0)	//If member select a value in first dropdown and ANY in second dropdown
								{
									if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= $ANNUALINCOMEINRVALUEHASH[$arrMatchCond['MWIncome_From']])
									{
										$isIdealMatchflag = 1;	
									}	
									else
										$isIdealMatchflag = 0;
								}					
								else
								{
									if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= $ANNUALINCOMEINRVALUEHASH[$arrMatchCond['MWIncome_From']] && $arrNewMatriIdsDet[$j]['Temp_Annual_Income'] <= $ANNUALINCOMEINRVALUEHASH[$arrMatchCond['MWIncome_To']])
									{
										$isIdealMatchflag = 1;	
									}	
									else
										$isIdealMatchflag = 0;	
								}
							}
							else
								$isIdealMatchflag = 0;
						}
						else if($arrMatchCond['MWIncome_From'] != 0 && trim($arrMatchCond['MWIncome_From']) != '' && $isIdealMatchflag == 1)//If member pref dont have Any/India in country
						{							
							if($arrMatchCond['MWIncome_From'] == 1)	//If member select Less than 50000
							{
								//Start value is 1, B'coz 0 is not specified.
								if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= 1 && $arrNewMatriIdsDet[$j]['Temp_Annual_Income'] <= $ANNUALINCOMEDOLLARVALUEHASH[1]*$USD4CONVERSION)
								{
									$isIdealMatchflag = 1;	
								}
								else
									$isIdealMatchflag = 0;
							}
							else if($arrMatchCond['MWIncome_From'] == 16)
							{
								if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= $ANNUALINCOMEDOLLARVALUEHASH[16]*$USD4CONVERSION)
								{
									$isIdealMatchflag = 1;	
								}
								else
									$isIdealMatchflag = 0;
							}
							else if($arrMatchCond['MWIncome_From'] >= 2 && $arrMatchCond['MWIncome_From'] <= 15)
							{
								if($arrMatchCond['MWIncome_From'] >= 2 && $arrMatchCond['MWIncome_To'] == 0)	//If member select a value in first dropdown and ANY in second dropdown
								{
									if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= $ANNUALINCOMEDOLLARVALUEHASH[$arrMatchCond['MWIncome_From']]*$USD4CONVERSION)
									{
										$isIdealMatchflag = 1;	
									}
									else
										$isIdealMatchflag = 0;
								}					
								else
								{
									if($arrNewMatriIdsDet[$j]['Temp_Annual_Income'] >= $ANNUALINCOMEDOLLARVALUEHASH[$arrMatchCond['MWIncome_From']]*$USD4CONVERSION && $arrNewMatriIdsDet[$j]['Temp_Annual_Income'] <= $ANNUALINCOMEDOLLARVALUEHASH[$arrMatchCond['MWIncome_To']]*$USD4CONVERSION)
									{
										$isIdealMatchflag = 1;	
									}	
									else
										$isIdealMatchflag = 0;
								}
							}
						}
						else if($isIdealMatchflag == 1)
							$isIdealMatchflag = 1;
					}
					else 
						$isIdealMatchflag = 0;

					#################### IDEAL MATCH END ####################
                    

					if ($varFlag == 0) {	
	   					## Count and store the no of matches
						if ($varNoOfMatches < $varSendMatchesLimit) {
							$arrMatchIds[0][]     = $arrNewMatriIdsDet[$j]['MatriId'];
							$varNoOfMatches += 1;

							if($isIdealMatchflag == 1){
								$arrMatchIds[1][] = $arrNewMatriIdsDet[$j]['MatriId']; 							
							}
						} else {
							return $arrMatchIds;
						}
					}
	   			   						
				}//gender condition end
   			}
			
	return $arrMatchIds;
}

function mwOtherReligionCasteMapping($PPcaste,$PPreligion) {
   global $PARTNERPREFOTHERRELIGION;  
   $showother=array();

   $castearr   = explode("~",$PPcaste);
   $religionarr= explode("~",$PPreligion);
   
	for($i=0;$i<count($castearr);$i++)
	{
		for($j=0;$j<count($religionarr);$j++)
		{
			$otherprofilebox=$castearr[$i]."~".$religionarr[$j];
			$findkey=array_key_exists($otherprofilebox,$PARTNERPREFOTHERRELIGION);
            
			if($findkey>=1) 
			{
				$showother=$PARTNERPREFOTHERRELIGION[$otherprofilebox]; //print_r($showother);
				for($k=0;$k<count($showother);$k++) 
				{
					$otherarr = explode("~",$showother[$k]);
					$OTHERMAPPING['CASTE'][] = $otherarr[0];
					$OTHERMAPPING['RELIGION'][] = $otherarr[1];
				}
			}
			else
			{
				$OTHERMAPPING['CASTE'][] = $castearr[$i];
				$OTHERMAPPING['RELIGION'][] = $religionarr[$j];
			}
		}
	} 
	return $OTHERMAPPING;
}
?>