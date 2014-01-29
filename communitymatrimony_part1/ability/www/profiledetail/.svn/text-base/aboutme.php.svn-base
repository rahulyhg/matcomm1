<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : primaryinfodesc.php
#=====================================================================================================================================
# Description : display information of primary info. It has primary info form and update function primary information.
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/cityarray.cil14');
include_once($varRootBasePath.'/conf/ppinfo.cil14');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessGender 	= $varGetCookieInfo["GENDER"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;
$objDomain	= new domainInfo;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['aboutmesubmit'];

//Domain Related information
$varAppearanceFeature		= $objDomain->useAppearance();
$varMatritalStatusFeature	= $objDomain->useMaritalStatus();
$varMotherTongueFeature		= $objDomain->useMotherTongue();
$varReligionFeature			= $objDomain->useReligion();
$varGothramFeature			= $objDomain->useGothram();

// newly added features
$varUseDenomination		= $objDomain->useDenomination();
$varCasteFeature		= $objDomain->useCaste();
$varIsCasteMandatory	= $objDomain->isCasteMandatory();
$varIsSubcasteMandatory	= $objDomain->isSubcasteMandatory();
$varSubcasteFeature		= $objDomain->useSubcaste();
$varStarFeature			= $objDomain->useStar();
$varUseEmployedIn		= $objDomain->useEmployedIn();

// Assign religion values for which subcaste is not mandatory in javascript array
if($varReligionFeature) {
 $arrGetReligionOption = $objDomain->getReligionOption();
 if (sizeof($arrGetReligionOption) > 1 ) {
   $objCommon->getReligionWithSubcasteOptional($arrReligionListWithSubcasteOptional);
 }
}

//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
function displaySelectedValuesFromArray($argArrName,$argSelectedValue) {
	$funArrSelectedValue	= explode("~", $argSelectedValue);
	foreach($argArrName as $funIndex => $funValues)
	{
		if (in_array($funIndex, $funArrSelectedValue))
		{ $funOptions .= '<option value="'.$funIndex.'"  selected>'.$funValues.'</option>';}
		else
		{ $funOptions .= '<option value="'.$funIndex.'">'.$funValues.'</option>';}
	}//for
	return $funOptions;

}//displaySelectedValuesFromArray

if($varUpdatePrimary == 'yes') {

	//ONJECT CREATION & CONNECT DATABASE
	$objDBMaster = new MemcacheDB;
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varEditedMaritalStatus			= $_REQUEST["maritalStatus"];
	$varEditedNoOfChildren			= $_REQUEST["noOfChildren"];
	$varEditedChildrenLivingStatus	= $_REQUEST["childLivingWithMe"];
	$varEditedWeightKgs				= $_REQUEST["weightKgs"];
	$varEditedWeightLbs				= $_REQUEST["weightLbs"];
	$varEditedHeightFeet		    = $_REQUEST["heightFeet"];
	$varEditedHeightCms			    = $_REQUEST["heightCms"];
	$varEditedBodyType				= $_REQUEST["bodyType"];
	$varEditedComplexion			= $_REQUEST["complexion"];
    $varEditedBloodGroup			= $_REQUEST["bloodGroup"];
	$varEditedAppearance			= $_REQUEST["appearance"];
	$varEditedMotherTongueId		= $_REQUEST["motherTongue"];
	if(is_array($_REQUEST["spokenLanguages"])) {
		$varEditedSpokenLanguages =  join('~',$_REQUEST["spokenLanguages"]);
	}

	$varEditedMotherTongueText		= trim($_REQUEST["motherTongueTxt"]);
	$varEditedReligion				= $_REQUEST["religion"];
	$varEditedGothramTxt			= trim($_REQUEST["gothramOthers"]);

    $varEditedDenomination		= $_REQUEST["denomination"];
	$varEditedDenominationTxt			= trim($_REQUEST["denominationText"]);

	if(isset($_REQUEST["casteOthers"]) && $_REQUEST["casteOthers"] != '' ) {
	 $varEditedCasteTxt			= trim($_REQUEST["casteOthers"]);
	}
	else {
	 $varEditedCasteTxt			= trim($_REQUEST["casteText"]);
	}
	$varEditedCasteId			= $_REQUEST["caste"];
	$varEditedCasteNoBar		= $_REQUEST["casteNoBar"];

	if(isset($_REQUEST["subCasteOthers"]) && $_REQUEST["subCasteOthers"] != '') {
	  $varEditedSubcasteTxt		= trim($_REQUEST["subCasteOthers"]);
	}
	else {
	  $varEditedSubcasteTxt		= trim($_REQUEST["subCasteText"]);
	}

	$varEditedSubcasteId		= $_REQUEST["subCaste"];
	$varEditedSubcasteNoBar		= $_REQUEST["subCasteNoBar"];
	$varEditedStar				= $_REQUEST["star"];


	$varEditedGothramId				= $_REQUEST["gothram"];
	$varEditedRaasi					= $_REQUEST["raasi"];
	$varEditedHoroscope				= $_REQUEST["horoscope"];
	$varEditedDosham				= $_REQUEST["dosham"];

    $varEducationSubcategory	    = $_REQUEST['educationCategory'];
	$varEducationCategory	        = $arrEducationMapping[$varEducationSubcategory];
	$varEmployedIn			        = $_REQUEST['employmentCategory'];
	$varOccupation			        = $_REQUEST['occupation'];

	$varEditedEducationInDetail		= trim($_REQUEST["educationInDetail"]);
	$varEditedOccupationInDetail	= trim($_REQUEST["occupationInDetail"]);
	$varEditedIncomeCurrency		= $_REQUEST["annualIncomeCurrency"];
	//$varEditedAnnualIncome			= addslashes(strip_tags(trim($_REQUEST["annualIncome"])));
	$varEditedAnnualIncome		= str_replace(',','',trim($_REQUEST['annualIncome']));

    $varEditedCountry			= $_REQUEST["country"];
	$varEditedResidingState		= trim($_REQUEST["residingState"]);
	$varEditedResidingCity		= trim($_REQUEST["residingCity"]);
	$varOtherState				= $_REQUEST["otherState"];
	$varOtherCity				= $_REQUEST["otherCity"];
    if($varEditedCountry == 98) {
	  $varEditedCitizenship	 = 98; }
	else {
 	  $varEditedCitizenship			= $_REQUEST["citizenship"]; }
	if($confValues["DOMAINCASTEID"] == 2006) {$varEditedResidentStatus = 1; }
	else {$varEditedResidentStatus	= $_REQUEST["residentStatus"];}
	$varEditedAboutMySelf			= trim($_REQUEST["DESCDET"]);

	if ($varEditedWeightKgs != 0 && $varEditedWeightKgs != '') {
		$varEditedWeight		= $varEditedWeightKgs;
		$varEditedWeightUnit	= 'kg';
	} elseif ($varEditedWeightLbs != 0 && $varEditedWeightLbs != '') {
		$varEditedWeight		= $varEditedWeightLbs;
		$varEditedWeightUnit	= 'lbs';
	}//if

    if($varEditedHeightFeet != 0 && $varEditedHeightFeet != '') {
		$varEditedHeight  		= $varEditedHeightFeet;
		$varEditedHeightUnit	= 'feet-inches';
	} elseif($varEditedHeightCms != 0) {
		$varEditedHeight		= $varEditedHeightCms;
		$varEditedHeightUnit	= 'cm';
	}

	if($sessMatriId != '') {
		//Direct updatation for array field
		$argFields 			= array('Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Height','Height_Unit','Body_Type','Complexion','Blood_Group','Appearance','Religion','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Category','Education_Subcategory','Employed_In','Occupation','Caste_Nobar','Subcaste_Nobar','Star','Citizenship','Resident_Status','Date_Updated');
		$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedMaritalStatus,$objDBMaster),$objDBMaster->doEscapeString($varEditedNoOfChildren,$objDBMaster),$objDBMaster->doEscapeString($varEditedChildrenLivingStatus,$objDBMaster),$objDBMaster->doEscapeString($varEditedWeight,$objDBMaster),$objDBMaster->doEscapeString($varEditedWeightUnit,$objDBMaster),$objDBMaster->doEscapeString($varEditedHeight,$objDBMaster),$objDBMaster->doEscapeString($varEditedHeightUnit,$objDBMaster),$objDBMaster->doEscapeString($varEditedBodyType,$objDBMaster),$objDBMaster->doEscapeString($varEditedComplexion,$objDBMaster),$objDBMaster->doEscapeString($varEditedBloodGroup,$objDBMaster),$objDBMaster->doEscapeString($varEditedAppearance,$objDBMaster),$objDBMaster->doEscapeString($varEditedReligion,$objDBMaster),$objDBMaster->doEscapeString($varEditedRaasi,$objDBMaster),$objDBMaster->doEscapeString($varEditedHoroscope,$objDBMaster),$objDBMaster->doEscapeString($varEditedDosham,$objDBMaster),$objDBMaster->doEscapeString($varEducationCategory,$objDBMaster),$objDBMaster->doEscapeString($varEducationSubcategory,$objDBMaster),$objDBMaster->doEscapeString($varEmployedIn,$objDBMaster),$objDBMaster->doEscapeString($varOccupation,$objDBMaster),$objDBMaster->doEscapeString($varEditedCasteNoBar,$objDBMaster),$objDBMaster->doEscapeString($varEditedSubcasteNoBar,$objDBMaster),$objDBMaster->doEscapeString($varEditedStar,$objDBMaster),$objDBMaster->doEscapeString($varEditedCitizenship,$objDBMaster),$objDBMaster->doEscapeString($varEditedResidentStatus,$objDBMaster),'NOW()');


		if($varCasteFeature==1 && $varEditedCasteId!=9997) {
			//drop down value and selected value should not "others"

			if ($varEditedCasteId > 0){
			array_push($argFields,'CasteId');
			array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedCasteId,$objDBMaster));
			}
			array_push($argFields,'CasteText');
			array_push($argFieldsValues,"''");
		}

		if($varUseDenomination==1 && $varEditedDenomination!=9997) {
			//drop down value and selected value should not "others"

			if ($varEditedDenomination > 0){
			array_push($argFields,'Denomination');
			array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedDenomination,$objDBMaster));
			}
			array_push($argFields,'DenominationText');
			array_push($argFieldsValues,"''");
		}

		/*if($varEditedDenomination!=9997 && $varEditedCasteId!=9997) {
			array_push($argFields,'CasteText');
			array_push($argFieldsValues,"''");
		}*/

		if($varSubcasteFeature==1 && $varEditedSubcasteId!=9997) {
			//drop down value and selected value should not "others"

			if ($varEditedSubcasteId > 0){
			array_push($argFields,'SubcasteId');
			array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedSubcasteId,$objDBMaster));
			}
			array_push($argFields,'SubcasteText');
			array_push($argFieldsValues,"''");
		}

		if($varMotherTongueFeature==1 && $varEditedMotherTongueId!=9997) {
			//drop down value and selected value should not "others"

			if ($varEditedMotherTongueId > 0){
			array_push($argFields,'Mother_TongueId');
			array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedMotherTongueId,$objDBMaster));
			}
			array_push($argFields,'Mother_TongueText');
			array_push($argFieldsValues,"''");
		}

		if($varGothramFeature == 1 && $varEditedGothramId != 9997) {

			if ($varEditedGothramId > 0){
			array_push($argFields,'GothramId');
			array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedGothramId,$objDBMaster));
			}
			array_push($argFields,'GothramText');
			array_push($argFieldsValues,"''");
		}

        if($varEditedCountry == 98) {
				array_push($argFields,'Country');
				array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedCountry,$objDBMaster));
				array_push($argFields,'Residing_State');
				array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedResidingState,$objDBMaster));
				array_push($argFields,'Residing_District');
				array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedResidingCity,$objDBMaster));
				array_push($argFields,'Residing_Area');
				array_push($argFieldsValues,"''");
				array_push($argFields,'Residing_City');
				array_push($argFieldsValues,"''");
		}



		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

        $argFields 			= array('Matriid','Languages_Selected');
		$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster),$objDBMaster->doEscapeString($varEditedSpokenLanguages,$objDBMaster));
        $objDBMaster->insertOnDuplicate($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues,'MatriId');

		// NOT VALIDATED MEMBER COMMIT OTHER DETAILS DIRECTLY
		if($sessPublish == 0 || $sessPublish == 4) {
			$argFields 			= array('Mother_TongueId','Mother_TongueText','Denomination','DenominationText','CasteId','CasteText','SubcasteId','SubcasteText','GothramId','GothramText','Education_Detail','Occupation_Detail','Annual_Income','Income_Currency','About_Myself');
			$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedMotherTongueId,$objDBMaster),$objDBMaster->doEscapeString($varEditedMotherTongueText,$objDBMaster),$objDBMaster->doEscapeString($varEditedDenomination,$objDBMaster),$objDBMaster->doEscapeString($varEditedDenominationTxt,$objDBMaster),$objDBMaster->doEscapeString($varEditedCasteId,$objDBMaster),$objDBMaster->doEscapeString($varEditedCasteTxt,$objDBMaster),$objDBMaster->doEscapeString($varEditedSubcasteId,$objDBMaster),$objDBMaster->doEscapeString($varEditedSubcasteTxt,$objDBMaster),$objDBMaster->doEscapeString($varEditedGothramId,$objDBMaster),$objDBMaster->doEscapeString($varEditedGothramTxt,$objDBMaster),$objDBMaster->doEscapeString($varEditedEducationInDetail,$objDBMaster),$objDBMaster->doEscapeString($varEditedOccupationInDetail,$objDBMaster),$objDBMaster->doEscapeString($varEditedAnnualIncome,$objDBMaster),$objDBMaster->doEscapeString($varEditedIncomeCurrency,$objDBMaster),$objDBMaster->doEscapeString($varEditedAboutMySelf,$objDBMaster));

			if($sessPublish == 4) {
				array_push($argFields,'Publish');
				array_push($argFieldsValues,'0');
			}

            if($varEditedCountry == 98) { }
				else {
					if($varEditedCountry == 222) {
						array_push($argFields,'Residing_State');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedResidingState,$objDBMaster));
						array_push($argFields,'Residing_Area');
						array_push($argFieldsValues,"''");
					} else {
						array_push($argFields,'Residing_State');
						array_push($argFieldsValues,"''");
						array_push($argFields,'Residing_Area');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedResidingState,$objDBMaster));
					}
					array_push($argFields,'Country');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedCountry,$objDBMaster));
					array_push($argFields,'Residing_District');
					array_push($argFieldsValues,"''");
					array_push($argFields,'Residing_City');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedResidingCity,$objDBMaster));
			}

			$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
			$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
		}
		else {
			if(trim($_REQUEST['oldedudet']) != trim($varEditedEducationInDetail) || trim($_REQUEST['oldoccdet']) != trim($varEditedOccupationInDetail) || trim($_REQUEST['oldincome']) != trim($varEditedAnnualIncome) || trim($_REQUEST['oldcurrency']) != trim($varEditedIncomeCurrency) || trim($_REQUEST['oldaboutme']) != trim($varEditedAboutMySelf) || ($varMotherTongueFeature==1 && (trim($_REQUEST['oldmothertongueTxt']) != $varEditedMotherTongueText)) || ($varGothramFeature==1 && (trim($_REQUEST['oldgothramTxt']) != $varEditedGothramTxt)) || ($varCasteFeature==1 && (trim($_REQUEST['oldothCaste']) != $varEditedCasteTxt)) || ($varUseDenomination==1 && (trim($_REQUEST['oldothDenomination']) != $varEditedDenominationTxt)) || ($varSubcasteFeature==1 && (trim($_REQUEST['oldothsubCaste']) != $varEditedSubcasteTxt)) || ($varOtherState == 1 && trim($_REQUEST['oldstate']) != trim($varEditedResidingState) && trim($_REQUEST['oldstatearea']) != trim($varEditedResidingState)) || ($varOtherCity == 1 && trim($_REQUEST['oldcity']) != trim($varEditedResidingCity))) {
				$argFields 			= array('MatriId');
				$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster));
				$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

				$argFields 			= array('Date_Updated');
				$argFieldsValues	= array('NOW()');

                if(trim($_REQUEST['oldedudet']) != $varEditedEducationInDetail) {
					array_push($argFields,'Education_Detail');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedEducationInDetail,$objDBMaster));
				}

				if(trim($_REQUEST['oldoccdet']) != $varEditedOccupationInDetail) {
					array_push($argFields,'Occupation_Detail');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedOccupationInDetail,$objDBMaster));
				}

				if((trim($_REQUEST['oldincome']) != $varEditedAnnualIncome) || (trim($_REQUEST['oldcurrency']) != trim($varEditedIncomeCurrency))) {
					array_push($argFields,'Annual_Income');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedAnnualIncome,$objDBMaster));
					array_push($argFields,'Income_Currency');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedIncomeCurrency,$objDBMaster));
				}

				if(trim($_REQUEST['oldaboutme']) != trim($varEditedAboutMySelf)) {
					array_push($argFields,'About_Myself');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedAboutMySelf,$objDBMaster));
				}

				if($varGothramFeature==1 && (trim($_REQUEST['oldgothramTxt']) != $varEditedGothramTxt)) {
					if($varEditedGothramId==9997) {
						array_push($argFields,'GothramId');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedGothramId,$objDBMaster));
					}
					array_push($argFields,'GothramText');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedGothramTxt,$objDBMaster));
				}

				if($varMotherTongueFeature==1 && (trim($_REQUEST['oldmothertongueTxt']) != $varEditedMotherTongueText)) {
					if($varEditedCasteId==9997) {
						array_push($argFields,'Mother_TongueId');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedMotherTongueId,$objDBMaster));
					}
					array_push($argFields,'Mother_TongueText');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedMotherTongueText,$objDBMaster));
				}

				if($varCasteFeature==1 && (trim($_REQUEST['oldothCaste']) != $varEditedCasteTxt)) {
						if(($varEditedCasteId==9997) || ($varEditedDenomination == 9997)) {
							array_push($argFields,'CasteId');
							array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedCasteId,$objDBMaster));
						}
						array_push($argFields,'CasteText');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedCasteTxt,$objDBMaster));
				}

			   if($varUseDenomination==1 && (trim($_REQUEST['oldothDenomination']) != $varEditedDenominationTxt)) {
					if($varEditedDenomination==9997) {
					  array_push($argFields,'Denomination');
					  array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedDenomination,$objDBMaster));
					}
					array_push($argFields,'DenominationText');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedDenominationTxt,$objDBMaster));
			   }

			  if($varSubcasteFeature==1 && (trim($_REQUEST['oldothsubCaste']) != $varEditedSubcasteTxt)) {
				if($varEditedSubcasteId==9997) {
					array_push($argFields,'SubcasteId');
					array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedSubcasteId,$objDBMaster));
		 		}
				array_push($argFields,'SubcasteText');
				array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedSubcasteTxt,$objDBMaster));
		      }


               if(($varOtherState == 1 && trim($_REQUEST['oldstate']) != trim($varEditedResidingState) && trim($_REQUEST['oldstatearea']) != trim($varEditedResidingState)) || ($varOtherCity == 1 && trim($_REQUEST['oldcity']) != trim($varEditedResidingCity))) {
						array_push($argFields,'Country');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedCountry,$objDBMaster));
						array_push($argFields,'Residing_State');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedResidingState,$objDBMaster));
						array_push($argFields,'Residing_City');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedResidingCity,$objDBMaster));
			    }

				$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$argCondition);

				$argFields 			= array('Pending_Modify_Validation');
				$argFieldsValues	= array(1);
				$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			}
		}

		$argFields 			= array('Date_Updated','Time_Posted');
		$argFieldsValues	= array('NOW()','NOW()');
		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

		$objDBMaster->dbClose();
	}

} else {
	$argFields			= $arrMEMBERINFOfields;
	$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave)." AND ".$varWhereClause;
	$varMemberInfo		= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varOwnProfileMCKey);
	$argFields				= array('Languages_Selected');
	$argCondition			= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varHobbiesInfo			= $objDBSlave->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,1);

	$varAbsWeight = str_replace(".00","",$varMemberInfo['Weight']);
	if($varAbsWeight!=0) {
		if($varMemberInfo['Weight_Unit'] == 'kg') {
			$varWeightKgPass	= round($varMemberInfo['Weight']);
			$varWeightLbsPass	= '';
		} else {
			$varWeightLbsPass	= round($varMemberInfo['Weight']);
			$varWeightKgPass	= '';
		}
	}

    $varAbsHeight			= $varMemberInfo['Height'];
	$arrHt					= explode(".",$varAbsHeight);
	if($varMemberInfo['Height_Unit'] == 'feet-inches') {
		if($arrHt[1] == '00') {
			$varAbsHeight	= str_replace(".00","",$varAbsHeight);
			$varHeightPass	= $arrParHeightList[$varAbsHeight];
		} else {
			$varHeightPass	= $varAbsHeight;
		}
		$varHeightPassCm	= '';
	} else {
		$varHeightPassCm	= (int)(round($varAbsHeight));
		$varHeightPass		= '';
	}

	$varCommunityId				= $varMemberInfo['CommunityId'];
	$varGender					= $varMemberInfo['Gender'];
	$varCasteId					= $varMemberInfo['CasteId'];
	$varMaritalStatus			= $varMemberInfo['Marital_Status'];
	$varNoOfChildren			= $varMemberInfo['No_Of_Children'];
	$varChildrenLivingStatus	= $varMemberInfo['Children_Living_Status'];
	$varBodyType				= $varMemberInfo['Body_Type'];
	$varComplexion				= $varMemberInfo['Complexion'];
	$varBloodGroup              = $varMemberInfo['Blood_Group'];
	$varAppearance				= $varMemberInfo['Appearance'];
	$varMotherTongueId			= $varMemberInfo['Mother_TongueId'];
	$varMotherTongueText		= stripslashes(trim($varMemberInfo['Mother_TongueText']));
	$varReligion				= $varMemberInfo['Religion'];
	$varGothramId				= $varMemberInfo['GothramId'];
	$varGothramText				= stripslashes(trim($varMemberInfo['GothramText']));
	$varRaasiId					= $varMemberInfo['Raasi'];
	$varHoroscopeMatch			= $varMemberInfo['Horoscope_Match'];
	$varDhosham					= $varMemberInfo['Chevvai_Dosham'];
	$varEducationSubcategory	= $varMemberInfo['Education_Subcategory'];
	$varEducationDetail			= stripslashes(trim($varMemberInfo['Education_Detail']));
	$varEmployedIn			    = $varMemberInfo['Employed_In'];
	$varOccupation			    = $varMemberInfo['Occupation'];
	$varOccupationDtl			= stripslashes(trim($varMemberInfo['Occupation_Detail']));
	$varIncomeCurrency			= $varMemberInfo['Income_Currency'];
	$varAbsAnnualIncome = str_replace(".00","",$varMemberInfo['Annual_Income']);
	if($varAbsAnnualIncome != '0') {
		$varCurrencyVal = $varAbsAnnualIncome;
	} else {
		$varCurrencyVal = '';
	}
	echo "<script>var gender=$varGender</script>";

	$varCountry					= $varMemberInfo['Country'];
	$varCitizenship				= $varMemberInfo['Citizenship'];
	$varResident_Status			= $varMemberInfo['Resident_Status'];
	$varAboutMyself				= stripslashes(trim($varMemberInfo['About_Myself']));

	$varReligionId				= $varMemberInfo['Religion'];
	$varDenomination			= $varMemberInfo['Denomination'];
	$varDenominationText		= stripslashes(trim($varMemberInfo['DenominationText']));
	$varCasteNoBar				= $varMemberInfo['Caste_Nobar'];
	$varCasteId					= $varMemberInfo['CasteId'];
	$varCasteText				= stripslashes(trim($varMemberInfo['CasteText']));
	$varSubcasteId				= $varMemberInfo['SubcasteId'];
	$varSubcasteText			= stripslashes(trim($varMemberInfo['SubcasteText']));
	$varSubcasteNoBar			= $varMemberInfo['Subcaste_Nobar'];
	$varStar					= $varMemberInfo['Star'];

	$varSpokenLanguagesString    = $varHobbiesInfo[0]['Languages_Selected'];
}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/aboutme.js" ></script>
<link rel="stylesheet" type="text/css" href="<?=$confValues['CSSPATH']?>/spellchecker.css">

		<? include_once('settingsheader.php');?>
		<center>
			<div class="padt10">
				<?if($varUpdatePrimary == 'yes') { ?>
				<div class='fleft' style='width:490px;'>
					Your about me information has been modified successfully.
					<br><br><font class='errortxt'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></font>
				</div>
				<? } else { ?>
				<form method='post' name='frmProfile' onSubmit='return aboutmeValidate();' style="padding:0px; margin:0px;">
				<input type="hidden" name="communityId" value="<?=$varCommunityId?>">
				<input type='hidden' value='aboutme' name='act'>
				<input type='hidden' value='yes' name='aboutmesubmit'>
				<input type="hidden" name="oldgothramTxt" value="<?=htmlentities($varGothramText,ENT_QUOTES);?>">
				<input type="hidden" name="oldmothertongueTxt" value="<?=htmlentities($varMotherTongueText,ENT_QUOTES);?>">
				<input type="hidden" name="appearanceFeature" value="<?=$varAppearanceFeature?>">
				<input type="hidden" name="maritalstatusfeature" value="<?=$varMatritalStatusFeature?>">
				<input type="hidden" name="mothertonguefeature" value="<?=$varMotherTongueFeature?>">
				<input type="hidden" name="religionfeature" value="<?=$varReligionFeature?>">
				<input type="hidden" name="gothramfeature" value="<?=$varGothramFeature?>">
				<input type="hidden" name="empinfeature" value="<?=$varUseEmployedIn?>">
				<input type='hidden' name='oldedudet' value="<?=htmlentities($varEducationDetail,ENT_QUOTES);?>">
				<input type='hidden' name='oldoccdet' value="<?=htmlentities($varOccupationDtl,ENT_QUOTES);?>">
				<input type='hidden' name='oldincome' value="<?=htmlentities($varMemberInfo['Annual_Income'],ENT_QUOTES);?>">
				<input type='hidden' name='oldcurrency' value="<?=htmlentities($varIncomeCurrency,ENT_QUOTES);?>">
				<input type='hidden' name='oldaboutme' value="<?=htmlentities($varAboutMyself,ENT_QUOTES);?>">
				<input type='hidden' name='countryid' value="<?=$varCountry?>">

                <input type='hidden' name='oldstate' value='<?=htmlentities($varMemberInfo['Residing_State'],ENT_QUOTES);?>'>
			    <input type='hidden' name='oldstatearea' value='<?=htmlentities($varMemberInfo['Residing_Area'],ENT_QUOTES);?>'>
		    	<input type='hidden' name='oldcity' value='<?=htmlentities($varOldCityValue,ENT_QUOTES);?>'>
			    <input type='hidden' name='emaildup' value=''>

				<input type='hidden' name='occupationid' value="<?=$varOccupation?>">
				<input type="hidden" name="denominationfeature" value="<?=$varUseDenomination?>">
				<input type="hidden" name="castefeature" value="<?=$varCasteFeature?>">
			    <input type="hidden" name="castemandatory" value="<?=$varIsCasteMandatory?>">
			    <input type="hidden" name="oldothCaste" value="<?=htmlentities($varCasteText,ENT_QUOTES);?>">
				<input type="hidden" name="oldothDenomination" value="<?=htmlentities($varDenominationText,ENT_QUOTES);?>">
			    <input type="hidden" name="subcastefeature" value="<?=$varSubcasteFeature?>">
			    <input type="hidden" name="subcastemandatory" value="<?=$varIsSubcasteMandatory?>">
			    <input type="hidden" name="oldothsubCaste" value="<?=htmlentities($varSubcasteText,ENT_QUOTES);?>">
				<div class="fright opttxt"><span class="clr3">*</span> Mandatory</div><br clear="all">
				<div class="normtxt clr bld fleft padl25">Basic Information</div><br clear="all"/>

				<?if($varMatritalStatusFeature) {
					$arrRetMaritalStatus	= $objDomain->getMaritalStatusOption();
					if($varCommunityId==2503 && $varGender == 2) {
						unset($arrRetMaritalStatus[5]);
					} else if($varCommunityId==2006 && $varGender==1) {
						unset($arrRetMaritalStatus[6]);
					}
					$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);
					?>
					<input type="hidden" name="maritaltxtfeature" value="<?=$varSizeMaritalStatus;?>">
					<?
					if($varSizeMaritalStatus==1) {?>
						<input type="hidden" name="maritalStatus" value="<?=key($arrRetMaritalStatus)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getMaritalStatusLabel()?><span class="clr3">*</span></div>
						<div class="fleft pfdivrt tlleft">
							<select class='srchselect' NAME='maritalStatus' size='1' onChange='return HaveChildnp(this)' onblur='ChkEmpty(document.frmProfile.maritalStatus, "select", "mstatus","Please select the marital status of the prospect");'>
								<?=$objCommon->getValuesFromArray($arrRetMaritalStatus, "- Select -", "0", $varMaritalStatus);?>
							</select>
							<br><span id="mstatus" class="errortxt"></span>
						</div><br clear="all"/>

						<!--Have to work-->
						<div class="pfdivlt fleft">&nbsp;</div>
						<div class="fleft pfdivrt tlleft">
						<div class='smalltxt'>No. of Children&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Children living status</font> <br>
							<select class='inputtext' NAME='noOfChildren' size='1' onChange='return HaveChildnp(this)'>
							<?if($varMaritalStatus > 1) {?>
							<?=$objCommon->getValuesFromArray($arrNoOfChildrenList, "- Select -", "", $varNoOfChildren);?>
							</select>

							<?if($varNoOfChildren >= 1) {?>
								<input type=radio name='childLivingWithMe' value='0' <?if($varChildrenLivingStatus==0) { echo 'checked';}?> id='childLivingWithMe'><font class='smalltxt'>Living with me</font>&nbsp;
								<input type=radio name='childLivingWithMe' value='1' onFocus='if(disabled)blur();' <?if($varChildrenLivingStatus==1){ echo 'checked';}?> id='childLivingWithMe'><font class='smalltxt'>Not living with me</font>
							<?} else { ?>
								<input type=radio name='childLivingWithMe' value='0'><font class='smalltxt' id='childLivingWithMe'>Living with me</font>&nbsp; <input type=radio name='childLivingWithMe' value='1' onFocus='if(disabled)blur();'><font class='smalltxt' id='childLivingWithMe'>Not living with me</font>
							<?}
							} else {?>
							<?=$objCommon->getValuesFromArray($arrNoOfChildrenList, "- Select -", "", $varNoOfChildren);?>
							</select>
							&nbsp;
							<input type=radio name='childLivingWithMe' value='0'><font class='smalltxt'>Living with me</font>&nbsp; <input type=radio name='childLivingWithMe' value='1' onFocus='if(disabled)blur();' id='childLivingWithMe'><font class='smalltxt'>Not living with me</font>
							<?}?>
						</div></div><br clear="all"/>
						<!--Have to work-->
					<? }
				} ?>

				<div class="smalltxt fleft tlright pfdivlt" >Weight</div>
				<div class="fleft pfdivrt tlleft"><select class='inputtext' NAME='weightKgs' size='1' onChange='return onKGS()'>
						<?=$objCommon->getValuesFromArray($arrWeightKgsList, "--Kgs-- ", "0", $varWeightKgPass);?>
					</select>
					&nbsp;&nbsp;or&nbsp;&nbsp;<!-- <font class='mediumtxt mediumtxt boldtxt'></font> -->
					<select class='inputtext' NAME='weightLbs' size='1' onChange='return onLBS()'>
						<?=$objCommon->getValuesFromArray($arrWeightLbsList, "--Lbs-- ", "0", $varWeightLbsPass);?>
					</select>
				</div><br clear="all"/>


			    <div class="smalltxt fleft tlright pfdivlt">Height<span class="clr3">*</span></div>
			    <div class="fleft pfdivrt tlleft"><select class='inputtext' NAME='heightFeet' size='1' onChange='return onFEET();' onblur='heightChk();'>
					<?=$objCommon->getValuesFromArray($arrHeightFeetList, "-- Feet/Inches --", "0", $varHeightPass);?>
				</select>
				<!-- or <b>Cms</b> -->
				<select class='inputtext' NAME='heightCms' size='1' onChange='return onCMS()' onblur='heightChk();'>
					<option value=0>- Select -</option>
					<?for($i = 121; $i <= 241; $i++) {
						if($i == $varHeightPassCm)
							echo "'<option value=$i selected>$i cm</option>'";
						else
							echo "'<option value=$i>$i cm</option>'";
					}?>
				</select><br><span id="height" class="errortxt"></span>
			  </div><br clear="all"/>



				<div class="smalltxt fleft tlright pfdivlt" >Body Type</div>
				<div class="fleft pfdivrt tlleft">
					<? foreach($arrBodyTypeList as $key=>$value){
						$varChecked = ($key == $varBodyType)?'checked':'';
						echo '<input type="radio" name=bodyType value="'.$key.'"  id="bodyType'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt" >Complexion</div>
				<div class="fleft pfdivrt tlleft">
					<? foreach($arrComplexionList as $key=>$value){
						$varChecked = ($key == $varComplexion)?'checked':'';
						echo '<input type="radio" name=complexion value="'.$key.'"  id="complexion'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>


				<div class="pfdivlt smalltxt fleft tlright">Blood Group</div>
				<div class="fleft pfdivrt tlleft">
					<select class="inputtext" name="bloodGroup" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrBloodGroupList, "--- Select Blood Group --- ", "0",$varBloodGroup);?></select>
				</div>
				<br clear="all"/>

				<?if($varAppearanceFeature) {
					$arrRetAppearance	= $objDomain->getAppearanceOption();
					$varSizeAppearance	= sizeof($arrRetAppearance);
					?>
					<input type="hidden" name="appearancetxtfeature" value="<?=$varSizeAppearance;?>">
					<?
					if($varSizeAppearance==1) {?>
						<input type="hidden" name="appearance" value="<?=key($arrRetAppearance)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getAppearanceLabel()?><span class="clr3">*</span></div>
						<div class="fleft pfdivrt tlleft">
							<? if($varSizeAppearance>1){
								foreach($arrRetAppearance as $key=>$value){
									$varChecked = ($key == $varAppearance)?'checked':'';
									echo '<input type="radio" class="frmelements" name=appearance value="'.$key.'"  id="appearance'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
								}
							} ?><br><span id="spanappearance" class="errortxt"></span>
						</div><br clear="all"/>
					<? }
				} ?>

				<? if($varMotherTongueFeature) {
					$arrRetMotherTongue	= $objDomain->getMotherTongueOption();
					$varSizeMotherTongue= sizeof($arrRetMotherTongue);
					?>
					<input type="hidden" name="mothertonguetxtfeature" value="<?=$varSizeMotherTongue;?>">
					<?
					if($varSizeMotherTongue==1) {?>
						<input type="hidden" name="motherTongue" value="<?=key($arrRetMotherTongue)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getMotherTongueLabel()?><span class="clr3">*</span></div>
						<div class="fleft pfdivrt tlleft">
							<? if($varSizeMotherTongue>1){?>
							<select class='srchselect' NAME='motherTongue' size='1' onblur='ChkEmpty(document.frmProfile.motherTongue, "select", "mothertong","Please select the mother tongue of the prospect");'>
								<?=$objCommon->getValuesFromArray($arrRetMotherTongue, "- Select -", "0", $varMotherTongueId);?>
							</select>
							<? } else { ?>
							<input type="text" name="motherTongueTxt" value="<?=$varMotherTongueText?>" size="30" maxlength="60" class="inputtext" onblur='ChkEmpty(document.frmProfile.motherTongueTxt, "text", "mothertong","Please enter the mother tongue of the prospect");'>
							<? } ?><br><span id="mothertong" class="errortxt"></span>
						</div><br clear="all"/>
					<? }
				}
			    ?>


				<div class="pfdivlt smalltxt fleft tlright">Spoken Languages</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' NAME='spokenLanguages[]' size='5' MULTIPLE >
				<?=displaySelectedValuesFromArray($arrSpokenLangList, $varSpokenLanguagesString);?>
				</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				<br clear="all"/>


				<? //if($varCommunityId != '2504') {?>
				<div class="normtxt clr bld fleft padl25 padt10">Cultural background</div><br clear="all"/>
				<? //} ?>


			    <? if($varReligionFeature) {
				  $arrGetReligionOption = $objDomain->getReligionOption();
				  echo '<input type="hidden" name="religionOption" value="'.sizeof($arrGetReligionOption).'">';
				  if (sizeof($arrGetReligionOption)==1) { //For Hidden

					 echo '<input type="hidden" name="religion" value="'.key($arrGetReligionOption).'">';

				  } else { ?>
					<div class="pfdivlt smalltxt fleft tlright"><?=$objDomain->getReligionLabel()?><font class="clr3">*</font></div>
					<div class="pfdivrt smalltxt fleft tlleft">

					<? if (sizeof($arrGetReligionOption)>1) { ?>
					<select name="religion" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect fleft" onChange="funReligion();" onblur="religionChk();">
					<?=$objCommon->getValuesFromArray($arrGetReligionOption, "--- Select ---", "0", $varReligionId);?>
					</select>
					<? } else { ?><input type="text" name="religionText" tabindex="<?=$varTabIndex++?>" value=""><? } ?><br clear="all"><span id="religionspan" class="errortxt"></span></div><br clear="all"/>

			    <? } } ?>

				<!-- Denomination -->
				<?
                if($varUseDenomination) {
				$arrGetDenominationOption = $objDomain->getDenominationOption();
				$varDenominationLabel	= $objDomain->getDenominationLabel();
				$varSizeDenomination	= sizeof($arrGetDenominationOption);

				echo '<input type="hidden" name="denominationOption" value="'.sizeof($arrGetDenominationOption).'">';
				if (sizeof($arrGetDenominationOption)==1) { //For Hidden

					echo '<input type="hidden" name="denomination" value="'.key($arrGetDenominationOption).'">';

				} else {
					$varDenominationLabel	= $objDomain->getDenominationLabel();
				    $arrGetDenominationOption		= $objDomain->getDenominationOption();
					echo '<input type="hidden" name="denominationlabel" value="'.strtolower($varDenominationLabel).'">';
					?>
					<div class="pfdivlt smalltxt fleft tlright"><?=$varDenominationLabel?><font class="clr3">*</font></div>
					<div class="pfdivrt smalltxt fleft tlleft">

					<? if (sizeof($arrGetDenominationOption)>1) { ?>
					<select name="denomination" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onChange="funDenomination();" onblur="denominationChk();">
					<?=$objCommon->getValuesFromArray($arrGetDenominationOption, "--- Select ---", "0", $varDenomination);?>
					</select><!--start barani -->
					&nbsp;<input type="text" name="denominationText" value="<?=htmlentities($varDenominationText,ENT_QUOTES);?>" onblur="denominationChk();" size="15" class="inputtext" tabindex="<?=$varTabIndex++?>" <? if($varDenomination != 9997) { ?>style="visibility:hidden;" <? } ?> >
					<!--end barani -->
					<? }?><br><span id="denominationspan" class="errortxt"></span></div>
					<br clear="all"/>
			    <? } } ?>


               <?
               if($varCasteFeature) {
                $arrRetReligion	= $objDomain->getReligionOption();
				$arrGetCasteOption	= $objDomain->getCasteOption();
				if(sizeof($arrRetReligion)>1 && sizeof($arrGetCasteOption)>1) {
					$arrGetCasteOption= $objDomain->getCasteOptionsForReligion($varReligionId);
				} else if($varSizeDenomination>1 && sizeof($arrGetCasteOption)>1) {
					$arrGetCasteOption= $objDomain->getCasteOptionsForDenomination($varDenomination);
				} else {
					$arrGetCasteOption= $objDomain->getCasteOption();
				}
				$varSizeCaste	= sizeof($arrGetCasteOption);
				echo '<input type="hidden" name="casteOption" value="'.$varSizeCaste.'">';

				if ($varSizeCaste==1) { //For Hidden

				echo '<input type="hidden" class="inputtext" size="35" name="caste" value="'.key($arrGetCasteOption).'" tabindex="'.$varTabIndex++.'">';

				} else {
				$varCasteLabel	= $objDomain->getCasteLabel();
				echo '<input type="hidden" name="castelabel" value="'.strtolower($varCasteLabel).'">';?>
				<div class="pfdivlt smalltxt fleft tlright">
					<? echo '<span id="branchDiv">'.$varCasteLabel.'</span>'; if($varIsCasteMandatory==1){echo '<font class="clr3">*</font>'; $varCasteOnBlur='onBlur="casteChk();"';}?>
				</div>
				<div class="pfdivrt smalltxt fleft tlleft">
				<? if ($varSizeCaste>1) { ?>
				<div class="fleft" id="casteDivId"><select class="srchselect" tabindex="<?=$varTabIndex++?>" name="caste" <?=$varCasteOnBlur?> onChange="funCaste('');casteOthersChk();">
				<?=$objCommon->getValuesFromArray($arrGetCasteOption, "--- Select ---", "0", $varCasteId);?>
				</select></div><div class="fleft disnon" id="casteDivText" style="display:<?=($varCasteId=='9997')?'block':'none'?>;padding-left:10px;"><input type="text" name="casteOthers" size="16" class="inputtext" value="<?=htmlentities($varCasteText,ENT_QUOTES)?>" tabindex="<?=$varTabIndex++?>" /></div><br clear="all">
				<? } else { ?> <div class="fleft" id="casteDivId"><input type="text" name="casteText" class="inputtext" size="35" value="<?=$varCasteText?>" tabindex="<?=$varTabIndex++?>" style="display:<?=(($varReligionId>0) || ($varDenomination=='9997'))?'block':'none'?>"></div><div class="fleft disnon" id="casteDivText" style="display:none;padding-left:10px;"><input type="text" name="casteOthers" size="16" class="inputtext" value="" tabindex="<?=$varTabIndex++?>" /></div><br clear="all"> <? } ?><span id="castespan" class="errortxt"></span>

				<!-- start barani
				&nbsp;&nbsp;&nbsp;<input type="text" name="casteText1" value="<?=$varCasteText1;?>" size="35" class="inputtext" tabindex="<?=$varTabIndex++?>" style="display:none">
                <!-- end barani -->

				<br clear="all"/><input type="checkbox" tabindex="<?=$varTabIndex++?>" name="casteNoBar" class="fleft" value="1"<?=($varCasteNoBar==1)?"checked=checked":''?>><?=ucwords($varCasteLabel);?> doesn't matter<br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br><font class="opttxt" style="line-height:11px;">Select '<?=ucwords($varCasteLabel);?> doesn't matter' if you would like to receive alliances from other <?=ucwords($varCasteLabel);?></font></div><br clear="all"/>

			<? }  }else{echo '<input type="hidden" name="casteOption" value=""><div class="fleft" id="casteDivId"></div>';}


 			if($varSubcasteFeature) {
                $arrRetSubcaste	= $objDomain->getSubcasteOptionsForCaste($varCasteId);
				$varSizeSubcaste= sizeof($arrRetSubcaste);
				$arrGetSubcasteOption = $arrRetSubcaste;
				echo '<input type="hidden" name="subCasteOption" value="'.sizeof($arrGetSubcasteOption).'">';
				if (sizeof($arrGetSubcasteOption)==1) { //For Hidden
					echo '<input type="text" name="subCaste" value="'.key($arrGetSubcasteOption).'">';
				} else {
					$varSubcasteLabel	= $objDomain->getSubcasteLabel();
					echo '<input type="hidden" name="subcastelabel" value="'.strtolower($varSubcasteLabel).'">';?>
				<div class="pfdivlt smalltxt fleft tlright">
					<?echo $varSubcasteLabel;if($varIsSubcasteMandatory==1){echo '<font class="clr3"><span  id="subcasteMandatorySymbol">*</span></font>'; $varSubcasteOnBlur='onBlur="subcasteChk();" ';}
				if($varIsSubcasteMandatory == 0) {
				   $varSubcasteOnChange=' onChange="subCasteOthersChk();"';}
				?>
				</div>
				<div class="pfdivrt smalltxt fleft tlleft">
				<? if (sizeof($arrGetSubcasteOption)>1) { ?>
				<div class="fleft" id="subCasteDivId"><select class="srchselect" tabindex="<?=$varTabIndex++?>" name="subCaste" <?=$varSubcasteOnBlur?> <?=$varSubcasteOnChange?>>
				<?=$objCommon->getValuesFromArray($arrGetSubcasteOption, "--- Select ---", "0", $varSubcasteId);?>
				</select></div>
				<? } else { ?><div class="fleft" id="subCasteDivId"><input type="text" tabindex="<?=$varTabIndex++?>" class="inputtext" size="35" name="subCasteText" value="<?=htmlentities($varSubcasteText,ENT_QUOTES)?>" <?=$varSubcasteOnBlur?>></div> <? } ?><div class="fleft disnon" id="subCasteDivText" style="display:<?=($varSubcasteId=='9997')?'block':'none'?>;padding-left:10px;"><input type="text" name="subCasteOthers" onBlur="othsubcasteChk()" size="16" class="inputtext" value="<?=htmlentities($varSubcasteText,ENT_QUOTES)?>" tabindex="<?=$varTabIndex++?>" /></div><br clear="all"><span id="subcastespan" class="errortxt"></span>
				<? if (sizeof($arrGetCasteOption)==1) { ?><br clear="all"/><input type="checkbox" tabindex="<?=$varTabIndex++?>" name="subCasteNoBar" class="fleft" value="1" <?=($varSubcasteNoBar==1)?"checked=checked":''?>><?=ucwords($varSubcasteLabel);?> doesn't matter<br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br><font class="opttxt" style="line-height:11px;">Select '<?=ucwords($varSubcasteLabel);?> doesn't matter' if you would like to receive alliances from other subcaste</font>
				<? } ?>
				</div><br clear="all"/>

			<? }  }else{echo '<input type="hidden" name="subCasteOption" value=""><div class="fleft" id="subCasteDivId"><span id="subcastespan" class="errortxt"></span><br clear="all"/></div>';}  ?>


			<? if($objDomain->useStar() == 1) {
				$arrGetStarOption = $objDomain->getStarOption();

				?>
				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomain->getStarLabel();?></div>
				<div class="pfdivrt smalltxt fleft tlleft">
				<? if(sizeof($arrGetStarOption)>1) {?>
					<select name="star" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect fleft">
					<?=$objCommon->getValuesFromArray($arrGetStarOption, "--- Select ---", "0", $varStar);?>
					</select>
				<? } else { ?>
					<input type="text" name="starText" tabindex="<?=$varTabIndex++?>" class="inputtext" value="<?=$varStar?>">
				<? } ?>
				</div>
				<br clear="all"/>
			<? } ?>


			<? if($varGothramFeature == 1) {
				$arrGetGothramOption	= $objDomain->getGothramOption();
				if($varCasteId) {
				  $arrGetGothramOption	= $objDomain->getGothramOptionsForCaste($varCasteId);
				}
				$varGothramCount		= sizeof($arrGetGothramOption);
				$varGotharamMan			= ($varGothramCount > 1) ? '*' : '';
				if($confValues["DOMAINCASTEID"] == 2004) {
				  $varGotharamMan = '';
				}
				echo '<input type="hidden" name="gothramOption" value="'.$varGothramCount.'">';
			?>
				<div id="gothramCommonDivId">
				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomain->getGothramLabel();?><font class="clr3"><span id="gothramMandatorySymbol"><?=$varGotharamMan?></span></font></div>
				<div class="pfdivrt smalltxt fleft tlleft" id="gothramMainDivId">
				<? if($varGothramCount>1) {
                     if($confValues["DOMAINCASTEID"] == 2004) {
				       $varGothramCheck = 'onChange="anycastegothramChk();"';
					 }
					 else {
					   $varGothramCheck = 'onChange="gothramChk();" onBlur="gothramChk()";';
					 }
				?>
					<div class="fleft" id="gothramDivId"><select name="gothram" size="1" tabindex="<?=$varTabIndex++?>" <?=$varGothramCheck?>  class="srchselect">
					<?=$objCommon->getValuesFromArray($arrGetGothramOption, "--- Select ---", "0", $varGothramId);?>
					</select></div><div class="fleft disnon" id="gothramDivText" style="padding-left:10px;"><input type="text" name="gothramOthers" size="16" class="inputtext" onBlur="othgothramChk();" value="<?=$varGothramText?>" tabindex="<?=$varTabIndex++?>" /></div><br clear="all"><span id="gothraspan" class="errortxt"></span>
				<? } else { ?>
					<input type="text" name="gothramOthers" size="35" tabindex="<?=$varTabIndex++?>" class="inputtext fleft" value="<?=htmlentities($varGothramText,ENT_QUOTES)?>">
				<? } ?>
				</div>
				<br clear="all"/>
				</div>
			<? } ?>

                <? if($objDomain->useHoroscope()) {
					$arrRetHoroscope	= $objDomain->getHoroscopeOption(); ?>
					<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getHoroscopeLabel()?></div>
					<div class="fleft pfdivrt tlleft">
						<? foreach($arrRetHoroscope as $key=>$value){
							$varChecked = ($key == $varHoroscopeMatch)?'checked':'';
							echo '<input type="radio" name=horoscope value="'.$key.'"  id="horoscope'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
						}?>
					</div><br clear="all"/>
				<? } ?>

				<? if($objDomain->useDosham()) {
					$arrRetDosham	= $objDomain->getDoshamOption();
					$varSizeDosham	= sizeof($arrRetDosham);
					?>
					<input type="hidden" name="doshamtxtfeature" value="<?=$varSizeDosham;?>">
					<?
					if($varSizeDosham==1) {?>
						<input type="hidden" name="dosham" value="<?=key($arrRetDosham)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getDoshamLabel()?></div>
						<div class="fleft pfdivrt tlleft">
							<?	foreach($arrRetDosham as $key=>$value){
									$varChecked = ($key == $varDhosham)?'checked':'';
									echo '<input type="radio" name=dosham value="'.$key.'"  id="dosham'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
							} ?>
						</div><br clear="all"/>
					<? }
				} ?>

				<div class="normtxt clr bld fleft padl25 padt10">Career</div><br clear="all"/>

                <div class="pfdivlt smalltxt fleft tlright">Education<font class="clr3">*</font></div>
			    <div class="pfdivrt smalltxt fleft tlleft">
				 <select name="educationCategory" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(educationCategory, 'select','educationcategoryspan','Please select the education category of the prospect');">
				   <option value="0">--- Select ---</option>
				<?
				foreach($arrEducationList as $key1 => $value1) {
	             echo "<optgroup label='".$value1."'>";
                 foreach( $arrEducationMapping as $key2 => $value2 ) {
                  if($value2 == $key1 ) {
	                if($key2 == $varEducationSubcategory) {
		              echo "<option value=$key2 selected>".$arrEducationSubList[$key2]."</option>";
		            }
	                else {
		              echo "<option value=$key2>".$arrEducationSubList[$key2]."</option>";
		            }
		          }
	             }
	             echo "</optgroup>";
                } ?>
				 </select><br><span id="educationcategoryspan" class="errortxt"></span>
			    </div><br clear="all">

				<div class="smalltxt fleft tlright pfdivlt"  >Education in Detail</div>
				<div class="fleft pfdivrt tlleft" ><input type=text name=educationInDetail size=32 maxlength=80 tabindex="<?=$varTabIndex++?>" value='<?=htmlentities($varEducationDetail,ENT_QUOTES)?>' class='inputtext'>
				</div><br clear="all"/>

			    <?php
				if($confValues["DOMAINCASTEID"] == 2006) {
				  if($varGender == 1) {
                     $arrGroupOccupationList = $arrMaleGroupOccupationList;
                     $arrTotalOccupationList = $arrMaleDefenceOccupationList;
                  }
				  else {
					 $arrGroupOccupationList = $arrFemaleGroupOccupationList;
                     $arrTotalOccupationList = $arrFemaleDefenceOccupationList;
				  }
				}
				unset($arrGroupOccupationList['u']);unset($arrGroupOccupationList['v']);unset($arrGroupOccupationList['w']);
				?>
                <div class="smalltxt fleft tlright pfdivlt">Occupation<font class="clr3">*</font></div>
			    <div class="fleft pfdivrt tlleft"><div id='occdiv'>
					<select class='srchselect' NAME='occupation' size='1'  tabindex="<?=$varTabIndex++?>" onblur="ChkEmpty(occupation, 'select','occupationspan','Please select the occupation of the prospect');" onchange="selectOccupation(this.value);"> <option value="0">--- Select ---</option>
					  <?
					  foreach($arrGroupOccupationList as $key => $value) {
                        $Tmp_arrOccupationMapping = $arrOccupationMapping[$key];
	                    if($confValues["DOMAINCASTEID"] != 2006 || ($confValues["DOMAINCASTEID"] == 2006 && $varGender ==2) ) { echo "<optgroup label='".$value."'>"; }
                        foreach( $Tmp_arrOccupationMapping as $value ) {
	                     if($value == $varOccupation) {
	                     	echo "<option value=$value selected>".$arrTotalOccupationList[$value]."</option>";
	                     }
		                 else {
		                    echo "<option value=$value>".$arrTotalOccupationList[$value]."</option>";
		                 }
	                    }
	                    echo "</optgroup>";
                     }?>
					</select><br><span id="occupationspan" class="errortxt"></span>
				</div>
			    </div>


				<div class="smalltxt fleft tlright pfdivlt"  >Occupation in Detail</div>
				<div class="fleft pfdivrt tlleft" ><input type=text name='occupationInDetail' size=32 maxlength=80 value='<?=htmlentities($varOccupationDtl,ENT_QUOTES);?>' class='inputtext' tabindex="<?=$varTabIndex++?>">
				</div><br clear="all"/>


				<? if($varUseEmployedIn) {
					$arrRetEmployedIn	= $objDomain->getEmployedInOption();
					$varSizeEmployedIn	= sizeof($arrRetEmployedIn);
					?>
					<input type="hidden" name="employedinOption" value="<?=$varSizeEmployedIn;?>">
					<?
					if($varSizeEmployedIn==1) {?>
						<input type="hidden" name="employmentCategory" value="<?=key($arrRetEmployedIn)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getEmployedInLabel()?><font class="clr3">*</font></div>
						<div class="fleft smalltxt pfdivrt tlleft">
							<?	foreach($arrRetEmployedIn as $key=>$value){
									$varChecked = ($key == $varEmployedIn)?'checked':'';
									echo '<input type="radio" name=employmentCategory value="'.$key.'" id="employmentCategory'.$key.'" '.$varChecked.' onBlur="checkEmployment();" onClick="checkEmployment();"   onKeyPress="checkEmployment();" tabindex='.$varTabIndex++.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>&nbsp;&nbsp;&nbsp;';
							} ?>
							<br><span id="employmentCategoryspan" class="errortxt"></span>
						</div><br clear="all"/>
					<? }
				} ?>
               <!-- <div class="pfdivlt smalltxt fleft tlright">Employed in<font class="clr3">*</font></div>
			    <div class="pfdivrt smalltxt fleft tlleft">
				<?=$objCommon->displayRadioOptionsForEmployedIn($arrEmployedInList, 'employmentCategory', $varEmployedIn,'smalltxt', "onBlur=checkEmployment(); onClick=checkEmployment();   onKeyPress=checkEmployment();",$varTabIndex++);?><br><span id="employmentCategoryspan" class="errortxt"></span>
			    </div><br clear="all">-->


				<div class="pfdivlt smalltxt fleft tlright">Annual income<font class="clr3">*</font></div>
			    <div class="pfdivrt smalltxt fleft tlleft">
				<select name="annualIncomeCurrency" size="1" tabindex="<?=$varTabIndex++?>" class="select1" onBlur="occupationChk();" style="width:180px;">
				<?=$objCommon->getValuesFromArray($arrSelectCurrencyList, "- Select - ", "0", $varIncomeCurrency);?>
				</select>&nbsp; &nbsp;&nbsp;<input type="text" tabindex="<?=$varTabIndex++?>" name="annualIncome" value="<?=$varCurrencyVal?>" size="20" class="inputtext" onBlur="amountChk();"><br><span id="annualincomespan" class="errortxt"></span><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="112" height="1" /><span id="amountspan" class="errortxt"></span>
			    </div><br clear="all"/>
				<div class="smalltxt clr2 tlleft">Please add your income as it is considered one of the deciding factors for marriage. Please add digits only. You can use commas as separators. For Eg: 6,00,000 or 600000.</div><br clear="all"/>



			  <div class="normtxt clr bld fleft padl25 padt10" >Location</div><br clear="all"/>


			   <div class="smalltxt fleft tlright pfdivlt">Country Living in<span class="clr3">*</span></div>
			   <div class="fleft pfdivrt tlleft"><select name='country' class='srchselect' onChange='countryChk();'>
					<? if($confValues["DOMAINCASTEID"] == 2006) { ?>
			          <option value="98">India</option>
                    <? } else {
					 echo $objCommon->getValuesFromArray($arrCountryList, '- Select - ', '0', $varMemberInfo['Country']);
					 } ?>
				</select><br><span id="loccountry" class="errortxt"></span>
			   </div><br clear="all"/>

			   <div id='statecitydiv' class="fleft">
			   <div class="smalltxt fleft tlright pfdivlt">Residing state<span class="clr3">*</span></div>
			   <div class="fleft pfdivrt tlleft"><?if($varMemberInfo['Country'] == 98) { ?>
					<select name='residingState' id='residingState' class='srchselect' onChange='modrequestnew(this.value);' onblur='ChkEmpty(document.frmProfile.residingState, "select", "locresidingstate","Please select the resident state of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrResidingStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);?>
					</select>
				<? } else if($varMemberInfo['Country'] == 222) { ?>
					<select name='residingState' id='residingState' class='srchselect' onblur='ChkEmpty(document.frmProfile.residingState, "select", "locresidingstate","Please select the resident state of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrUSAStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);?>
					</select>
				<? } else { ?>
					<input type=hidden name='otherState' value='1'>
					<input type=text name='residingState' size=32 maxlength=40 id='residingState' class='inputtext' value='<?=htmlentities($varMemberInfo['Residing_Area'],ENT_QUOTES)?>' onblur='ChkEmpty(document.frmProfile.residingState, "text", "locresidingstate","Please enter the resident state of the prospect");'>
				<? } ?><br><span id="locresidingstate" class="errortxt"></span>
			</div><br clear="all"/>

			<? if($varMemberInfo['Country'] == 98) { $varLable='Residing City/District'; } else {$varLable='Residing City';}?>
			<div class="smalltxt fleft tlright pfdivlt"><?=$varLable?><span class="clr3">*</span></div>
			<div class="fleft pfdivrt tlleft"><?if($varMemberInfo['Country'] == 98) { $varTmpState = ${$residingCityStateMappingList[$varMemberInfo['Residing_State']]}; ?>
					<select name='residingCity' id='residingCity' class='srchselect'  onblur='ChkEmpty(document.frmProfile.residingCity, "select", "locresidingcity","Please select the residing city of the prospect");'>
						<?=$objCommon->getValuesFromArray($varTmpState, '- Select - ', '0', $varMemberInfo['Residing_District']);?>
					</select>

				<? } else { ?>
				 <input type=hidden name='otherCity' value='1'>
				 <input type=text name='residingCity' id='residingCity' size=32 maxlength=40 class='inputtext' value='<?=htmlentities($varMemberInfo['Residing_City'],ENT_QUOTES)?>' onblur='ChkEmpty(document.frmProfile.residingCity, "text", "locresidingcity","Please enter the residing city of the prospect");'>

				<? } ?>
			    <br><span id="locresidingcity" class="errortxt"></span></div><br clear="all"/>
			    </div>


                <div id="showCitizenship" style="display:<?echo ($varMemberInfo['Country'] != 98)?'block;':'none;' ?>">
                <div class="smalltxt fleft tlright pfdivlt" >Citizenship<span class="clr3">*</span></div>
				<div class="fleft pfdivrt tlleft" ><select name='citizenship' class='srchselect' onblur='ChkEmpty(document.frmProfile.citizenship, "select", "loccitizenship","Please select the citizenship of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrCountryList, '- Select - ', '0', $varCitizenship);?>
					</select><br><span id="loccitizenship" class="errortxt"></span>
				</div><br clear="all"/>
				</div>

                <div id="showResidentStatus" style="display:<?echo ($confValues["DOMAINCASTEID"] != 2006)?'block;':'none;' ?>">
				<div class="smalltxt fleft tlright pfdivlt">Resident status<span class="clr3">*</span></div>
				<div class="fleft pfdivrt tlleft">
					<select name='residentStatus' class='srchselect' onblur='ChkEmpty(document.frmProfile.residentStatus, "select", "locresident","Please select the resident status of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrResidentStatusList, '- Select - ', '0', $varResident_Status);?>
					</select><br><span id="locresident" class="errortxt"></span>
				</div><br clear="all"/>
				</div>

				<div class="smalltxt fleft tlright pfdivlt bld">A few lines about me</div>
				<div class="fleft pfdivrt tlleft">
						<!-- <font class="smalltxt tlleft"> Check Spelling &amp preview</font><br /> -->
						<textarea title='spellcheck' accesskey='<?=$confValues['SERVERURL']?>/spellchecker/spellchecker.php' id='description1' name='DESCDET' class='clr tareareg smalltxt' onfocus="alen=this.value;document.getElementById('desccount').innerHTML=alen.length;" onkeyup='alen=this.value;document.getElementById("desccount").innerHTML=alen.length;' onblur="ChkEmpty(document.frmProfile.DESCDET, 'textarea', 'aboutmyselfspan','Please enter your description.');alen=this.value;document.getElementById('desccount').innerHTML=alen.length;" /><?=htmlentities($varAboutMyself,ENT_QUOTES)?></textarea><span class="opttxt">Min. 50 characters</span><span id="desccount" style="padding-left:30px;" class="opttxt">0</span><span class="opttxt"> Characters typed</span><br><span id='aboutmyselfspan' class='errortxt'></span>
				</div><br clear="all"/>

				<img src='<?=$confValues['IMGSURL']?>/trans.gif' width='1' height='1' onload='HaveChildnp(this);'>
				<div class="tlright padr20 padt10"><input type="submit" name='sbutton' value='Save' class='button'> &nbsp;
					<input type="reset" class="button" value="Reset">
				</div>
				</form><br>
				<? } ?>
				<?
				  if($varReligionFeature) {
					 if (sizeof($arrGetReligionOption)>1) {
					     echo '<script>funEditReligion();</script>';
					 }
				  }
				  /*if($varUseDenomination) {
					  if(sizeof($arrGetDenominationOption)>1) {
				        echo '<script>funDenomination();</script>';
					  }
				  }*/

				  /*if($varCasteFeature) {
					  if($varSizeCaste > 1) {
				       echo '<script>casteOthersChk();</script>';
				      }
				  }

				  if($varSubcasteFeature) {
					  if (sizeof($arrGetSubcasteOption)>1) {
				        echo '<script>subCasteOthersChk();</script>';
					  }
				  }*/
				  if($varGothramFeature) {
					 if($varGothramCount>1) {
					    if($confValues["DOMAINCASTEID"] == 2004) {
				          echo '<script>anycastegothramChk();</script>';
					    }
					    else {
					      echo '<script>gothramChk();</script>';
					    }
					 }
				  }
				  if($varOccupation) {
					 echo '<script>selectOccupation(document.frmProfile.occupation.value);</script>';
				  }
				?>
			</div>
			<div style="display: none;">
				<font class="smalltxt">
				<script src="<?=$confValues['SERVERURL'];?>/spellchecker/cpaint/cpaint2.cil14.compressed.js" type="text/javascript"></script>
				<script src="<?=$confValues['JSPATH']?>/spell_checker_compressed.js" type="text/javascript"></script>
				</font>
			</div>
		</center>
