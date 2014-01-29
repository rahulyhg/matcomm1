<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-08-13
# Project	  : MatrimonyProduct
# Filename	  : profiledetail.php
#=====================================================================================================================================
# Description : It is common for all profile. It is queying all profile information from Database.
#=====================================================================================================================================
//FILE INCLUDES
include_once($varRootBasePath.'/conf/cityarray.cil14');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//OBJECT DECLARATION
$objCommon			= new clsCommon;

//VARIABLE DECLARATION
$varBasicStr		= '';
$varPhysicalStatusStr='';
$varBeliefsStr		= '';
$varCareerStr_EduLong= '';
$varCareerStr		= '';
$varLocationStr		= '';
$varHabitsStr		= '';
$varFavouriteStr	= '';
$varFamilyTypeStr	= '';
$varParenstOccStr	= '';
$varSiblingsStr		= '';
$varPartnerBasicStr	= '';
$varPartnerBeliefs	= '';
$varPartnerCareerStr= '';
$varPartnerLocStr	= '';
$varPartnerHabits	= '';

//Get feature
if($objDomain->useMaritalStatus()) {
	$arrRetMSOption	= $objDomain->getMaritalStatusOption();
	$varSizeMSArray	= sizeof($arrRetMSOption);
}
if($objDomain->useMotherTongue()) {
	$arrRetMTOption	= $objDomain->getMotherTongueOption();
	$varSizeMTArray	= sizeof($arrRetMTOption);
}
if($objDomain->useReligion()) {
	$arrRetRelOption	= $objDomain->getReligionOption();
	$varSizeRelArray	= sizeof($arrRetRelOption);
}

$varDenomLabel		= $objDomain->getDenominationLabel();
if($objDomain->useDenomination()) {
	$arrRetDenomOption	= $objDomain->getDenominationOption();
	$varSizeDenomArray	= sizeof($arrRetDenomOption);
}

$varCasteLabel		= $objDomain->getCasteLabel();
if($objDomain->useCaste()) {
	$arrRetCasteOption	= $objDomain->getCasteOption();
	$varSizeCasteArray	= sizeof($arrRetCasteOption);
}

$varSubcasteLabel		= $objDomain->getSubcasteLabel();
if($objDomain->useSubcaste()) {
	$arrRetSubcasteOption	= $objDomain->getSubcasteOption();
	$varSizeSubcasteArray	= sizeof($arrRetSubcasteOption);
}

if($objDomain->useStar()) {
	$arrRetStarOption	= $objDomain->getStarOption();
	$varSizeStarArray	= sizeof($arrRetStarOption);
}

if($objDomain->useRaasi()) {
	$arrRetRaasiOption	= $objDomain->getRaasiOption();
	$varSizeRaasiArray	= sizeof($arrRetRaasiOption);
}

if($objDomain->useGothram()) {
	$arrRetGothramOption	= $objDomain->getGothramOption();
	$varSizeGothramArray	= sizeof($arrRetGothramOption);
}

if($objDomain->useDosham()) {
	$arrRetDoshamOption	= $objDomain->getDoshamOption();
	$varSizeDoshamArray	= sizeof($arrRetDoshamOption);
}

$arrRetReligiousOption	= array();
if($objDomain->useReligiousValues()) {
	$arrRetReligiousOption	= $objDomain->getReligiousValuesOption();
}
$arrRetEthnicityOption	= array();
if($objDomain->useEthnicity()) {
	$arrRetEthnicityOption	= $objDomain->getEthnicityOption();
}

$arrRetEmployedInOption	= array();
if($objDomain->useEmployedIn()) {
	$arrRetEmployedInOption	= $objDomain->getEmployedInOption();
	$varSizeEmployedIn		= sizeof($arrRetEmployedInOption);
}

$arrNotSpecified	= array(7,9997,9998,9999,423,519,611,668);
$varNotSpecifiedStr	= ' Not Specified';

if($varMatriId == '') {
	$varMatriId 	= $sessMatriId;
	//echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" onload="javascript:window.location.href=\''.$confValues['SERVERURL'].'\'"/>';
}


//GET VIEW PROFILE DETAIL
$argFields					= $arrMEMBERINFOfields;
$argMemCondition			= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND ".$varWhereClause;
$argCondition				= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
$varMemberInfo				= $objProfileDetail->select($varTable['MEMBERINFO'],$argFields,$argMemCondition,0,$varOppositeProfileMCKey);

//$varPublish					= $varMemberInfo['Publish'];
//$varPaid_status				= $varMemberInfo['Paid_Status'];
$varSpecialPriv				= $varMemberInfo['Special_Priv'];
//$varPhotoStatus				= $varMemberInfo['Photo_Set_Status'];
//$varProtectPhotoStatus		= $varMemberInfo['Protect_Photo_Set_Status'];
//$varPhoneVerified			= $varMemberInfo['Phone_Verified'];
//$varPhoneProtected			= $varMemberInfo['Phone_Protected'];
$varVoiceAvailable			= $varMemberInfo['Voice_Available'];
$varVideoSetStatus			= $varMemberInfo['Video_Set_Status'];
$varVideoProtected			= $varMemberInfo['Video_Protected'];
$varReferenceSetStatus		= $varMemberInfo['Reference_Set_Status'];
$varFilterSetStatus			= $varMemberInfo['Filter_Set_Status'];
//$varHoroAvailable			= $varMemberInfo['Horoscope_Available'];
//$varHoroProtected			= $varMemberInfo['Horoscope_Protected'];
//$varFamilySetStatus			= $varMemberInfo['Family_Set_Status'];
//$varInterestSetStatus		= $varMemberInfo['Interest_Set_Status'];
//$varPartnerSetStatus		= $varMemberInfo['Partner_Set_Status'];
$varCitizenshipId			= $varMemberInfo['Citizenship'];
$varAppearance				= $varMemberInfo['Appearance'];
$varReligiousValues			= $arrRetReligiousOption[$varMemberInfo['Religious_Values']];
$varEthnicity				= $arrRetEthnicityOption[$varMemberInfo['Ethnicity']];

$varUserName				= stripslashes(trim($varMemberInfo['User_Name']));
$varAboutmySelf				= stripslashes(trim($varMemberInfo['About_Myself']));
$varName					= stripslashes(trim($varMemberInfo['Name']));
$varNickName				= stripslashes(trim($varMemberInfo['Nick_Name']));
$varDisplayName				= ($varNickName!='')?$varNickName:$varName;
$varAge						= $varMemberInfo['Age'];


// Newely Added for Online status checking
$varCondition	   = " WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
$varFields         = array('Publish','Paid_Status','Photo_Set_Status','Protect_Photo_Set_Status','Phone_Verified','Phone_Protected','Horoscope_Available','Horoscope_Protected','Family_Set_Status','Interest_Set_Status','Partner_Set_Status','Last_Login','Date_Created','PowerPackStatus');
$varMemberDetail       = $objProfileDetail->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);

$varPublish			   = $varMemberDetail[0]['Publish'];
$varPaid_status		   = $varMemberDetail[0]['Paid_Status'];
$varPhotoStatus		   = $varMemberDetail[0]['Photo_Set_Status'];
$varProtectPhotoStatus = $varMemberDetail[0]['Protect_Photo_Set_Status'];
$varPhoneVerified	   = $varMemberDetail[0]['Phone_Verified'];
$varPhoneProtected	   = $varMemberDetail[0]['Phone_Protected'];
$varHoroAvailable	   = $varMemberDetail[0]['Horoscope_Available'];
$varHoroProtected	   = $varMemberDetail[0]['Horoscope_Protected'];
$varFamilySetStatus	   = $varMemberDetail[0]['Family_Set_Status'];
$varInterestSetStatus  = $varMemberDetail[0]['Interest_Set_Status'];
$varPartnerSetStatus   = $varMemberDetail[0]['Partner_Set_Status'];
$varMemberStatus       = $varMemberDetail[0]['PowerPackStatus'];


if($varMemberStatus ==1) { 
	$varLastLogin = 'NOW'; 
}else {
	$varLastLogin = $objCommon->getLastLoginInfoCommon($varMemberDetail[0]['Last_Login'],$varMemberDetail[0]['Date_Created'],$varMatriId);
	$varLastLogin = 'Within last '.$varLastLogin; 
}


$varGenderCode		= $varMemberInfo['Gender'];
if($varGenderCode==1){$varGender = 'Male';}else{$varGender = 'Female';}
if(in_array($varMemberInfo['Profile_Created_By'], $arrNotSpecified)) {
	$varProfileCreatedBy= $varNotSpecifiedStr;
} else {
	$varProfileCreatedBy= $arrProfileCreatedByList[$varMemberInfo['Profile_Created_By']];
}


if($varMemberInfo['BM_MatriId'] != '' && $varMemberInfo['Horoscope_Match'] == 0) {
	$varHoroscopeMatch	= '';
} else {
	$varHoroscopeMatch	= $arrHoroscopeList[$varMemberInfo['Horoscope_Match']];
}

if($varMemberInfo['Height'] != '0.00') {
	$varAbsHeight = $varMemberInfo['Height'];
	$arrHt = explode(".",$varAbsHeight);
	if($arrHt[1] == '00') {
		$varAbsHeight	= str_replace(".00","",$varAbsHeight);
		$varHeight		= $arrHeightFeetList[$arrParHeightList[$varAbsHeight]];
	} else {
		$varHeight		= $arrHeightFeetList[$varAbsHeight];
	}
}

if($varMemberInfo['Weight'] != '0.00') {
	$varAbsWeight = str_replace(".00","",$varMemberInfo['Weight']);
	if($varAbsWeight==0) {
		$varWeight		= '';
	} else {
		if($varMemberInfo['Weight_Unit'] == 'lbs')
		{
			$varWeight	= round(($varMemberInfo['Weight'])/2.2);
		}
		else
		{
			$varWeight	= round($varMemberInfo['Weight']);
		}
	}
} else {
	$varWeight		= '';
}


if($varSizeMSArray > 1) {
	$varMaritalStatus = $arrRetMSOption[$varMemberInfo['Marital_Status']];
}



//Getting Value for index in coresponding array
if($varMemberInfo['Body_Type']==0)
{$varBodyType = '';}else{$varBodyType = 'Body Type - '.$arrBodyTypeList[$varMemberInfo['Body_Type']];}

if($varMemberInfo['Complexion']==0)
{$varComplexion = '';}else{$varComplexion = 'Complexion - '.$arrComplexionList[$varMemberInfo['Complexion']];}

if($varGender!='')  { $varBasicStr	= $varGender.', '; }
if($varMaritalStatus!='') { $varBasicStr	.= $varMaritalStatus.', '; }
if($varMemberInfo['No_Of_Children'] != 0) { 
	$varBasicStr	.= 'No of children - '.$varMemberInfo['No_Of_Children'].', '; 
	$varBasicStr	.= ($varMemberInfo['Children_Living_Status']==1)?'Not living with me, ':'Living with me, ';
}

$varBasicStr	.= $varAge.' yrs, ';
$varBasicStr	.= $varHeight.', ';
if($varWeight != '') {$varBasicStr	.= $varWeight.' Kgs, ';}

if($varBodyType!='' && $varComplexion!='') {
	$varBasicStr .= $varBodyType.' & '.$varComplexion.', ';
} else if($varBodyType!='') {
	$varBasicStr .= $varBodyType.', ';
} else if($varComplexion!='') {
	$varBasicStr .= $varComplexion.', ';
}
if($varMemberInfo['Blood_Group']==0)
{$varBloodGroup = '';}else{$varBloodGroup = $arrBloodGroupList[$varMemberInfo['Blood_Group']];}
if($varBloodGroup!='') { $varBasicStr .= 'Blood group - '.$varBloodGroup.', '; }

if($varSizeMTArray > 1) {
	if((in_array($varMemberInfo['Mother_TongueId'], $arrNotSpecified)) && trim($varMemberInfo['Mother_TongueText'])=='') {
		$varMotherTongue = $varNotSpecifiedStr;
	} else {
		$varMotherTongue = ($varMemberInfo['Mother_TongueId']==9997)?$varMemberInfo['Mother_TongueText']:$arrRetMTOption[$varMemberInfo['Mother_TongueId']];
	}
} else if ($varSizeMTArray === 0) {
	$varMotherTongue = $varMemberInfo['Mother_TongueText'];
}

if($varMotherTongue != '') {$varBasicStr .= 'Mother tongue-'.$varMotherTongue.', ';}
$varBasicStr		= trim($varBasicStr,', ');

$varPhysicalStatusVal		= $varMemberInfo['Physical_Status'];
$varDisabilityCause			= $arrDisabilityCause[$varMemberInfo['Disability_Cause']];
$varDisabilityType			= $varMemberInfo['Disability_Type'];
$varDisability_Severity		= $arrDisabilitySeverity[$varMemberInfo['Disability_Severity']];
$varDisabilityProductUsed	= $varMemberInfo['Disability_Product_Used'];
$varSignLanguage			= $varMemberInfo['Sign_Language'];
$varPhysicalStatus			= $arrPhysicalStatusList[$varMemberInfo['Physical_Status']];

if($varPhysicalStatus!=''){
	$varPhysicalStatusStr	.= 'Physical Status - '.$varPhysicalStatus.', ';
}
if($varDisabilityCause!=''){
	$varPhysicalStatusStr	.= 'Cause of disability- '.$varDisabilityCause.', ';
}
if($varDisabilityType!='' && $varDisabilityType!=0) {
	$varDisabilityTypeStr = $objCommon->getArrayFromString($varDisabilityType,$arrDisabilityType);
	$varPhysicalStatusStr .= 'Disability type - '.$varDisabilityTypeStr.', ';
}
if($varDisability_Severity!=''){
	$varPhysicalStatusStr	.= 'Disability severity - '.$varDisability_Severity.', ';
}
if($varDisabilityProductUsed!='' && $varDisabilityProductUsed!=0) {
	$varDisabilityProductsStr	= $objCommon->getArrayFromString($varDisabilityProductUsed,$arrDisabilityProducts);
	$varPhysicalStatusStr		.= 'Disability products used - '.$varDisabilityProductsStr.', ';
}
if($varSignLanguage==1 && $varPhysicalStatusVal==1) {
	$varPhysicalStatusStr	.= 'Sign Language - Yes, ';
}elseif($varSignLanguage==2 && $varPhysicalStatusVal==1) {
	$varPhysicalStatusStr	.= 'Sign Language - No, ';
}
$varPhysicalStatusStr		= trim($varPhysicalStatusStr,', ');
//Socio-Religious Background Information
if($varSizeRelArray > 1) {
	$varReligion = $arrRetRelOption[$varMemberInfo['Religion']];
}

if($objDomain->useDenomination()) {
	if(($varMemberInfo['Denomination']==0 || $varMemberInfo['Denomination']==9997) && trim($varMemberInfo['DenominationText'])!='') {
		$varDenomination		= $varDenomLabel.' -'.$varMemberInfo['DenominationText'];
	} else if($varSizeDenomArray > 1) {
		if((in_array($varMemberInfo['Denomination'], $arrNotSpecified)) && trim($varMemberInfo['DenominationText'])=='') {
			$varDenomination	= $varDenomLabel.' -'.$varNotSpecifiedStr;
		} else if(in_array($varMemberInfo['Denomination'], $arrNotSpecified) && $varMemberInfo['Denomination']!=9997) {
			$varDenomination	= $varDenomLabel.' -'.$varNotSpecifiedStr;
		} else {
			$varDenomination	= $arrRetDenomOption[$varMemberInfo['Denomination']];
		}
	}
}

if($objDomain->useCaste()) {
	if(($varMemberInfo['CasteId']==0 || $varMemberInfo['CasteId']==9997) && trim($varMemberInfo['CasteText'])!='') {
		$varCaste		= $varCasteLabel.' -'.$varMemberInfo['CasteText'];
	} else if($varSizeCasteArray > 1) {
		if ((in_array($varMemberInfo['CasteId'], $arrNotSpecified)) && trim($varMemberInfo['CasteText'])==""){
			$varCaste	= $varCasteLabel.' -'.$varNotSpecifiedStr;
		} else if(in_array($varMemberInfo['CasteId'], $arrNotSpecified) && $varMemberInfo['CasteId']!=9997) {
			$varCaste	= $varCasteLabel.' -'.$varNotSpecifiedStr;
		} else{
			$varCaste	= $arrRetCasteOption[$varMemberInfo['CasteId']];
		}
	}
}
if($varMemberInfo['Caste_Nobar']==1) { $varCaste = $varCaste.' ('.$varCasteLabel.' NoBar)'; }

if($objDomain->useSubcaste()) {
	if(($varMemberInfo['SubcasteId']==0 || $varMemberInfo['SubcasteId']==9997) && trim($varMemberInfo['SubcasteText'])!='') {
		$varSubCaste		= $varSubcasteLabel.' -'.$varMemberInfo['SubcasteText'];
	} else if($varSizeSubcasteArray > 1) {
		if ((in_array($varMemberInfo['SubcasteId'], $arrNotSpecified)) && trim($varMemberInfo['SubcasteText'])==""){
			$varSubCaste = $varSubcasteLabel.' -'.$varNotSpecifiedStr;
		} else if(in_array($varMemberInfo['SubcasteId'], $arrNotSpecified) && $varMemberInfo['SubcasteId']!=9997) {
			$varSubCaste	= $varSubcasteLabel.' -'.$varNotSpecifiedStr;
		} else{
			$varSubCaste = $arrRetSubcasteOption[$varMemberInfo['SubcasteId']];
		}
	}
}
if($varMemberInfo['Subcaste_Nobar']==1) { $varSubCaste = $varSubCaste.' ('.$varSubcasteLabel.' NoBar)'; }

if($varReligion != '') {
	$varBeliefsStr	= $varReligion.', ';
	$varRelSubcaste	= $varReligion.', ';
}

if($varDenomination != '') {
	$varBeliefsStr	.= $varDenomination.', ';
	$varRelSubcaste	.= $varDenomination.', ';
}
if($varCaste != '') {
	$varBeliefsStr	.= $varCaste.', ';
	$varRelSubcaste	.= $varCaste.', ';
}
if($varSubCaste!='') {
		$varBeliefsStr	.= $varSubCaste.', ';
		$varRelSubcaste	.= $varSubCaste.', ';
}
$varRelSubcaste	= trim($varRelSubcaste,', ');


if($varSizeStarArray > 1) {
	$varStar	= $arrRetStarOption[$varMemberInfo['Star']];
}
if($varStar!='') { $varBeliefsStr	.= $varStar.', ';}

if($varSizeRaasiArray > 1) {
	$varRaasi = $arrRetRaasiOption[$varMemberInfo['Raasi']];
}
if($varRaasi!='') { $varBeliefsStr	.= $varRaasi.', ';}

if($objDomain->useGothram()) {
	if(($varMemberInfo['GothramId']==0 || $varMemberInfo['GothramId']==9997) && trim($varMemberInfo['GothramText'])!='') {
		$varGothram		= $varMemberInfo['GothramText'];
	} else if($varSizeGothramArray > 1) {
		if ((in_array($varMemberInfo['GothramId'], $arrNotSpecified)) && trim($varMemberInfo['GothramText'])==""){
			$varGothram	= trim($varNotSpecifiedStr);
		} else if(in_array($varMemberInfo['GothramId'], $arrNotSpecified) && $varMemberInfo['GothramId']!=9997) {
			$varGothram	= trim($varNotSpecifiedStr);
		} else{
			$varGothram = $arrRetGothramOption[$varMemberInfo['GothramId']];
		}
	}
}

if($varGothram!='') { $varBeliefsStr	.= 'Gothram - '.$varGothram.', ';}

if($varSizeDoshamArray>1) {
	if($varMemberInfo['Chevvai_Dosham']==0)
	{$varDosham = '';}else{$varDosham = $arrRetDoshamOption[$varMemberInfo['Chevvai_Dosham']];}
}
if($varDosham!='') { $varBeliefsStr	.= 'Chevvai Dosham/Manglik - '.$varDosham.', ';}
if($varHoroscopeMatch!='') { $varBeliefsStr	.= 'Horoscope match - '.$varHoroscopeMatch.', ';}

$varBeliefsStr	= trim($varBeliefsStr,', ');

if($varMemberInfo['Eating_Habits']==0)
{$varEatHabits = '';}else{$varEatHabits = $arrEatingHabitsList[$varMemberInfo['Eating_Habits']];}
if($varEatHabits!=''){$varHabitsStr=$varEatHabits;}

if($varMemberInfo['Smoke']==0)
{$varSmokeHabits = '';}else{$varSmokeHabits = $arrSmokeList[$varMemberInfo['Smoke']];}
if($varSmokeHabits!=''){$varHabitsStr.=', '.$varSmokeHabits;}

if($varMemberInfo['Drink']==0)
{$varDrinkHabits = '';}else{$varDrinkHabits = $arrDrinkList[$varMemberInfo['Drink']];}
if($varDrinkHabits!=''){$varHabitsStr.=', '.$varDrinkHabits;}

//Location Information
$varCountryname		= $arrCountryList[$varMemberInfo['Country']]; 
$varCitizenship		= $arrCountryList[$varMemberInfo['Citizenship']];
$varResidentStatus	= $arrResidentStatusList[$varMemberInfo['Resident_Status']];
$varLocationStr		= $varCountryname;

if(($varMemberInfo['Residing_State'] != '0' && $varMemberInfo['Residing_State'] != '') || $varMemberInfo['Residing_Area'] != '') {
	if ($varMemberInfo['Country']==98)	{ $varResidingState = $arrResidingStateList[$varMemberInfo['Residing_State']];} //if
	elseif ($varMemberInfo['Country']==222){ $varResidingState = $arrUSAStateList[$varMemberInfo['Residing_State']];}//elseif
	else {$varResidingState = $varMemberInfo['Residing_Area'];} 
} else {
	$varResidingState = '';
}

if($varMemberInfo['Residing_City'] != '' || $varMemberInfo['Residing_District'] != 0) {
	if ($varMemberInfo['Country']==98) {
		$varResidingCity = ${$residingCityStateMappingList[$varMemberInfo['Residing_State']]}[$varMemberInfo['Residing_District']];
	} else {
		$varResidingCity = $varMemberInfo['Residing_City'];
	}
} else {
	$varResidingCity = '';
}

if($varResidingState!='') {$varLocationStr	.= ', '.$varResidingState;}
if($varResidingCity!='') {$varLocationStr	.= ', residing in '.$varResidingCity;}
if($varCitizenship!='') {$varLocationStr	.= ', citizenship - '.$varCitizenship;}
if($varResidentStatus!='') {$varLocationStr	.= ', resident status - '.$varResidentStatus;}


//Education & Personal Information
if($varMemberInfo['Education_Subcategory'] == 0) {
	if($varMemberInfo['Education_Category'] == 0) {
		$varEducation_Long = '';
	} else {
		$varEducation_Long = $arrEducationList[$varMemberInfo['Education_Category']];
	}
} else {
	$varEducation_Long	= $arrEducationSubList[$varMemberInfo['Education_Subcategory']];
}

if($varMemberInfo['Education_Category'] == 0) {
	$varEducation	= '';
} else {
	$varEducation	= $arrEducationDisplay[$varMemberInfo['Education_Category']];
}

if($varEducation_Long!='') {
	$varCareerStr_EduLong = $varEducation_Long;
}

if($varMemberInfo['Education_Detail']=='')
{$varDetailEducation = '';}else{$varDetailEducation = 'Education Detail - '.$varMemberInfo['Education_Detail'];}

if($varDetailEducation!='') {$varCareerStr_EduLong .= ', '.$varDetailEducation;}

if($varSizeEmployedIn>1) {
	$varEmployedIn	= $arrRetEmployedInOption[$varMemberInfo['Employed_In']];
	if($varEmployedIn!='') {
		$varCareerStr_EduLong .= ', '.$varEmployedIn;
	}
}

if($varMemberInfo['Occupation'] == 0) {
	$Occupation		= '';
} else {
	if(in_array($varMemberInfo['Occupation'], $arrNotSpecified)) {
		$Occupation = 'Occupation -'.$varNotSpecifiedStr;
	} else {
		$Occupation	= $arrTotalOccupationList[$varMemberInfo['Occupation']];
	}
	
}
if($Occupation!='') {
	$varCareerStr_EduLong .= ', '.$Occupation;
}

if($varMemberInfo['Occupation_Detail']=='')
{$varDetailOccupation = '';}else{$varDetailOccupation = 'Occupation Detail - '.$varMemberInfo['Occupation_Detail'];}
if($varDetailOccupation!='') {$varCareerStr_EduLong .= ', '.$varDetailOccupation;}


$varAbsAnnualIncome = str_replace(".00","",$varMemberInfo['Annual_Income']);
if($varAbsAnnualIncome == 0) {
	$varAnnualIncome = '';
} else {
	$varSplitCurrecy	= split('-',$arrSelectCurrencyList[$varMemberInfo['Income_Currency']]);
	$varAnnualIncome	= $varSplitCurrecy[1].' '.$varAbsAnnualIncome;}

if($varAnnualIncome!='') {
	$varCareerStr_EduLong .= ', Annual Income - '.$varAnnualIncome.' per annum';
}

//Getting family information for the selected profile
if($varFamilySetStatus == 1) {
	$argFields				= array('Family_Value','Family_Type','Family_Status','Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family');
	$argCondition			= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
	$varFamilyInfoResultSet	= $objProfileDetail->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
	$varFamilyInfo			= mysql_fetch_array($varFamilyInfoResultSet);
	
	if($varFamilyInfo['Family_Value'] == 0)
	{$varFamilyValue = '';}else{$varFamilyValue = $arrFamilyValuesList[$varFamilyInfo['Family_Value']];}

	if($varFamilyInfo['Family_Type'] == 0)
	{$varFamilyType = '';}else{$varFamilyType = $arrFamilyType[$varFamilyInfo['Family_Type']];}
	
	if($varFamilyInfo['Family_Status']==0)
	{$varFamilyStatus = '';}else{$varFamilyStatus = $arrFamilyStatus[$varFamilyInfo['Family_Status']];}

	if($varFamilyValue!='') {$varFamilyTypeStr=$varFamilyValue;}
	if($varFamilyType!='') {$varFamilyTypeStr.=', '.$varFamilyType;}
	if($varFamilyStatus!='') {$varFamilyTypeStr.=', '.$varFamilyStatus;}

	if($varFamilyInfo['Father_Occupation']=='')
	{$varFatherOccupation = '';}else{$varFatherOccupation = $varFamilyInfo['Father_Occupation'];}

	if($varFamilyInfo['Mother_Occupation']=='')
	{$varMotherOccupation = '';}else{$varMotherOccupation = $varFamilyInfo['Mother_Occupation'];}

	if($varFatherOccupation!='' && $varMotherOccupation!='') {
		$varParenstOccStr	= "Father - ".$varFatherOccupation." & Mother - ".$varMotherOccupation;
	} else if($varFatherOccupation!='') {
		$varParenstOccStr	= "Father - ".$varFatherOccupation;
	} else if($varMotherOccupation!='') {
		$varParenstOccStr	= "Mother - ".$varMotherOccupation;
	}

	if($varFamilyInfo['Family_Origin']=='')
	{$varFamilyOrigin = '';}else{$varFamilyOrigin = $varFamilyInfo['Family_Origin'];}

	if($varFamilyInfo['Brothers_Married']==0 || $varFamilyInfo['Brothers_Married']==99)
	{$varBrothersMarried = '';}else{$varBrothersMarried = $varFamilyInfo['Brothers_Married'];}

	if($varFamilyInfo['Brothers']==0 || $varFamilyInfo['Brothers']==99)
	{$varBrothers = '';} else {
		$varBrothers = $varFamilyInfo['Brothers']-$varBrothersMarried;
		$varBrothers = ($varBrothers>0)?$varBrothers:'';
		$varNoOfSiblings=$varFamilyInfo['Brothers'];
	}

	if($varFamilyInfo['Sisters_Married']==0 || $varFamilyInfo['Sisters_Married']==99)
	{$varSistersMarried = '';}else{$varSistersMarried = $varFamilyInfo['Sisters_Married'];}

	if($varFamilyInfo['Sisters']==0 || $varFamilyInfo['Sisters']==99)
	{$varSisters = '';} else {
		$varSisters = $varFamilyInfo['Sisters']-$varSistersMarried;
		$varSisters = ($varSisters>0)?$varSisters:'';
		$varNoOfSiblings=$varNoOfSiblings+$varFamilyInfo['Sisters'];
	}

	if($varBrothersMarried!='') {$varSiblingsStr=$varBrothersMarried.' married brother';if($varBrothersMarried>1){$varSiblingsStr.='s';}}
	if($varSistersMarried!='') {$varSiblingsStr.=', '.$varSistersMarried.' married sister';if($varSistersMarried>1){$varSiblingsStr.='s';}}
	if($varBrothers!='') {$varSiblingsStr.=', '.$varBrothers.' unmarried brother';if($varBrothers>1){$varSiblingsStr.='s';}}
	if($varSisters!='') {$varSiblingsStr.=', '.$varSisters.' unmarried sister';if($varSisters>1){$varSiblingsStr.='s';}}

	if($varFamilyInfo['About_Family']=='')
	{$varAboutFamily = '';}else{$varAboutFamily = $varFamilyInfo['About_Family'];}

	if($varNoOfSiblings == 0){$varNoOfSiblings = '';}
} else {
	$varFamilyValue			= '';
	$varFamilyType			= '';
	$varFamilyStatus		= '';
	$varFatherOccupation	= '';
	$varMotherOccupation	= '';
	$varFamilyOrigin		= '';
	$varBrothers			= '';
	$varBrothersMarried		= '';
	$varSisters				= '';
	$varSistersMarried		= '';
	$varNoOfSiblings		= '';
	$varAboutFamily			= '';
}

//Getting interest information for the selected profile
if($varInterestSetStatus == 1) {
	$argFields					= array('Hobbies_Selected','Hobbies_Others','Interests_Selected','Interests_Others','Music_Selected','Music_Others','Books_Selected','Books_Others','Movies_Selected','Movies_Others','Sports_Selected','Sports_Others','Food_Selected','Food_Others','Dress_Style_Selected','Dress_Style_Others','Languages_Selected','Languages_Others','Date_Updated');
	$argCondition				= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
	$varInterestInfoResultSet	= $objProfileDetail->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
	$varHobbiesInfo				= mysql_fetch_array($varInterestInfoResultSet);

	if($varHobbiesInfo['Hobbies_Selected'] == '' && $varHobbiesInfo['Hobbies_Others'] == '') {
		$varHobbies = '';
	} else {
		if($varHobbiesInfo['Hobbies_Selected'] != '') {
			$varHobbies = $objCommon->getArrayFromString($varHobbiesInfo['Hobbies_Selected'],$arrHobbiesList);
		}
		if($varHobbiesInfo['Hobbies_Others'] != '') {
			if($varHobbies != '') {
				$varHobbies = $varHobbies.', '.$varHobbiesInfo['Hobbies_Others'];
			} else {
				$varHobbies = $varHobbiesInfo['Hobbies_Others'];
			}
		}
	}

	if($varHobbiesInfo['Interests_Selected'] == '' && $varHobbiesInfo['Interests_Others'] == '') {
		$varInterest = '';
	} else {
		if($varHobbiesInfo['Interests_Selected'] != '') {
			$varInterest = $objCommon->getArrayFromString($varHobbiesInfo['Interests_Selected'],$arrInterestList);
		}
		if($varHobbiesInfo['Interests_Others'] != '') {
			if($varInterest != '') {
				$varInterest = $varInterest.', '.$varHobbiesInfo['Interests_Others'];
			} else {
				$varInterest = $varHobbiesInfo['Interests_Others'];
			}
		}
	}

	if($varHobbiesInfo['Music_Selected'] == '' && $varHobbiesInfo['Music_Others'] == '') {
		$varMusics = '';
	} else {
		if($varHobbiesInfo['Music_Selected'] != '') {
			$varMusics = $objCommon->getArrayFromString($varHobbiesInfo['Music_Selected'],$arrMusicList);
		}
		if($varHobbiesInfo['Music_Others'] != '') {
			if($varMusics != '') {
				$varMusics = $varMusics.', '.$varHobbiesInfo['Music_Others'];
			} else {
				$varMusics = $varHobbiesInfo['Music_Others'];
			}
		}
	}

	

	if($varHobbiesInfo['Sports_Selected'] == '' && $varHobbiesInfo['Sports_Others'] == '') {
		$varSports = '';
	} else {
		if($varHobbiesInfo['Sports_Selected'] != '') {
			$varSports = $objCommon->getArrayFromString($varHobbiesInfo['Sports_Selected'],$arrSportsList);
		}
		if($varHobbiesInfo['Sports_Others'] != '') {
			if($varSports != '') {
				$varSports = $varSports.', '.$varHobbiesInfo['Sports_Others'];
			} else {
				$varSports = $varHobbiesInfo['Sports_Others'];
			}
		}
	}

	if($varHobbiesInfo['Food_Selected'] == '' && $varHobbiesInfo['Food_Others'] == '') {
		$varFood = '';
	} else {
		if($varHobbiesInfo['Food_Selected'] != '') {
			$varFood = $objCommon->getArrayFromString($varHobbiesInfo['Food_Selected'],$arrFoodList);
		}
		if($varHobbiesInfo['Food_Others'] != '') {
			if($varFood != '') {
				$varFood = $varFood.', '.$varHobbiesInfo['Food_Others'];
			} else {
				$varFood = $varHobbiesInfo['Food_Others'];
			}
		}
	}

	if($varHobbiesInfo['Languages_Selected'] == '' && $varHobbiesInfo['Languages_Others'] == '') {
		$varLanguage = '';
	} else {
		if($varHobbiesInfo['Languages_Selected'] != '') {
			$varLanguage = $objCommon->getArrayFromString($varHobbiesInfo['Languages_Selected'],$arrSpokenLangList);
		}
		if($varHobbiesInfo['Languages_Others'] != '') {
			if($varLanguage != '') {
				$varLanguage = $varLanguage.', '.$varHobbiesInfo['Languages_Others'];
			} else {
				$varLanguage = $varHobbiesInfo['Languages_Others'];
			}
		}
	}

	if($varMusics!='') {$varFavouriteStr='Musics - '.$varMusics.'<br> ';}
	if($varSports!='') {$varFavouriteStr.='Sports - '.$varSports.'<br> ';}
	if($varFood!='') {$varFavouriteStr.='Food - '.$varFood;}

	/*if($varHobbiesInfo['Books_Selected'] == '' && $varHobbiesInfo['Books_Others'] == '') {
		$varBooks = '';
	} else {
		if($varHobbiesInfo['Books_Selected'] != '') {
			$varBooks = $objCommon->getArrayFromString($varHobbiesInfo['Books_Selected'],$arrReadList);
		}
		if($varHobbiesInfo['Books_Others'] != '') {
			if($varBooks != '') {
				$varBooks = $varBooks.', '.$varHobbiesInfo['Books_Others'];
			} else {
				$varBooks = $varHobbiesInfo['Books_Others'];
			}
		}
	}

	if($varHobbiesInfo['Movies_Selected'] == '' && $varHobbiesInfo['Movies_Others'] == '') {
		$varMovies = '';
	} else {
		if($varHobbiesInfo['Movies_Selected'] != '') {
			$varMovies = $objCommon->getArrayFromString($varHobbiesInfo['Movies_Selected'],$arrMoviesList);
		}
		if($varHobbiesInfo['Movies_Others'] != '') {
			if($varMovies != '') {
				$varMovies = $varMovies.', '.$varHobbiesInfo['Movies_Others'];
			} else {
				$varMovies = $varHobbiesInfo['Movies_Others'];
			}
		}
	}

	if($varHobbiesInfo['Dress_Style_Selected'] == '' && $varHobbiesInfo['Dress_Style_Others'] == '') {
		$varDress = '';
	} else {
		if($varHobbiesInfo['Dress_Style_Selected'] != '') {
			$varDress = $objCommon->getArrayFromString($varHobbiesInfo['Dress_Style_Selected'],$arrDressList);
		}
		if($varHobbiesInfo['Dress_Style_Others'] != '') {
			if($varDress != '') {
				$varDress = $varDress.', '.$varHobbiesInfo['Dress_Style_Others'];
			} else {
				$varDress = $varHobbiesInfo['Dress_Style_Others'];
			}
		}
	}

	*/
} else {
	$varHobbies		= '';
	$varInterest	= '';
	$varMusics		= '';
	$varBooks		= '';
	$varMovies		= '';
	$varSports		= '';
	$varFood		= '';
	$varDress		= '';
	$varLanguage	= '';
}

if($varLanguage != '') {$varBasicStr .= 'Language known-'.$varLanguage.', ';}
$varBasicStr		= trim($varBasicStr,', ');

//Getting partner preference information for the selected profile
if($varPartnerSetStatus == 1) {
	$varMaxSelFields			= 5;
	$argFields					= array('MatriId','Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Height_Unit','Physical_Status','Education','Employed_In','Occupation','Religion','Denomination','CasteId','SubcasteId','GothramId','Star','Raasi','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_USA_State','Resident_District','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Date_Updated');
	$argCondition				= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
	$varPartnerInfoResultSet	= $objProfileDetail->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
	$varPartnerInfo				= mysql_fetch_array($varPartnerInfoResultSet);
	
	$varPartnerDefaultStatus	= $varPartnerInfo['Status'];
	$varAgeFrom		= $varPartnerInfo['Age_From'];
	$varAgeTo		= $varPartnerInfo['Age_To'];
	if($varPartnerInfo['Age_From'] != 0 && $varPartnerInfo['Age_To'] != 0)
	{$varPartnerAge = $varAgeFrom.' - '.$varAgeTo.' Yrs';}else{$varPartnerAge = '';}

	$varAbsHeightFrom = round(str_replace(".00","",$varPartnerInfo['Height_From']));
	$varAbsHeightTo = round(str_replace(".00","",$varPartnerInfo['Height_To']));
	$varHeightCms	= $varAbsHeightFrom.' Cm to '.$varAbsHeightTo.' Cm';

	$varAbsHeightFrom = $varPartnerInfo['Height_From'];
	$arrHtFrom = explode(".",$varAbsHeight);
	if($arrHtFrom[1] == '00') {
		$varAbsHeightFrom = str_replace(".00","",$varAbsHeightFrom);
		$varHeightFrom = $arrHeightFeetList[$arrParHeightList[$varAbsHeightFrom]];
	} else {
		$varHeightFrom = $arrHeightFeetList[$varAbsHeightFrom];
	}

	$varAbsHeightTo	= $varPartnerInfo['Height_To'];
	$arrHtTo = explode(".",$varAbsHeight);
	if($arrHtTo[1] == '00') {
		$varAbsHeightTo = str_replace(".00","",$varAbsHeightTo);
		$varHeightTo = $arrHeightFeetList[$arrParHeightList[$varAbsHeightTo]];
	} else {
		$varHeightTo = $arrHeightFeetList[$varAbsHeightTo];
	}
	$varHeightFt = $varHeightFrom.' - '.$varHeightTo;
	
	if($varSizeMSArray>1) {
		if($varPartnerInfo['Looking_Status'] == 0) {
			$varPartnerLookingStatus = 'All';
		} else {
			$varPartnerLookingStatus = $objCommon->getArrayFromString(trim($varPartnerInfo['Looking_Status'],'~'),$arrRetMSOption);
		}
	}
	
	$varPartnerPhysicalStatus	= $arrPhysicalStatusList[$varPartnerInfo['Physical_Status']];
	
	if($varSizeMTArray>1) {
		if($varPartnerInfo['Mother_Tongue'] == 0) {
			$varPartnerMotherTongue = 'All';
		} else {
			$arrCountMotTongue = split('~+',trim($varPartnerInfo['Mother_Tongue'],'~'));
			$countMotTongue = sizeof($arrCountMotTongue);
			if($countMotTongue > $varMaxSelFields) {
				$varPartnerMotherTongue = 'All';
			} else {
				$arrRetMTOption	= $objCommon->changingArray($arrRetMTOption);
				$varMotTongStr = join('~',$arrCountMotTongue);
				$varPartnerMotherTongue = $objCommon->getArrayFromString($varMotTongStr,$arrRetMTOption);
			}
		}
	}

	if($varPartnerLookingStatus!='All') { $varPartnerBasicStr .= $varPartnerLookingStatus.', ';}
	if($varPartnerAge!='') { $varPartnerBasicStr .= $varPartnerAge.', ';}
	if($varHeightFt!='') { $varPartnerBasicStr .= $varHeightFt.', ';}
	if($varPartnerMotherTongue!='All') { $varPartnerBasicStr .= ' Mother Tongue - '.$varPartnerMotherTongue.', ';}
	if($varPartnerPhysicalStatus!='') { $varPartnerBasicStr .= ' Physical Status - '.$varPartnerPhysicalStatus.', ';}

	if($varPartnerInfo['Education'] == 0) {
		$varPartnerEducation = 'Any';
	} else {
		$arrCountEdu = split('~+',trim($varPartnerInfo['Education'],'~'));
		$countEdu = sizeof($arrCountEdu);
		if($countEdu > $varMaxSelFields) {
			$varPartnerEducation = 'Any';
		} else {
			$varEduStr = join('~',$arrCountEdu);
			$varPartnerEducation = $objCommon->getArrayFromString($varEduStr,$arrEducationList);
		}
	}
	

	if($varPartnerInfo['Occupation'] == 0) {
		$varPartnerOccupation = 'Any';
	} else {
		$arrCountOccIn = split('~+',trim($varPartnerInfo['Occupation'],'~'));
		$countOccIn = sizeof($arrCountOccIn);
		if($countOccIn > $varMaxSelFields) {
			$varPartnerOccupation = 'Any';
		} else {
			$varOccStr = join('~',$arrCountOccIn);
			$varPartnerOccupation = $objCommon->getArrayFromString($varOccStr,$arrTotalOccupationList);
		}
	}

	$varPartnerCareerStr = 'Education - '.$varPartnerEducation.', ';
	if($varSizeEmployedIn>1) {
		if($varPartnerInfo['Employed_In'] == 0) {
			$varPartnerEmployedIn = 'Any';
		} else {
			$arrCountEmpIn = split('~+',trim($varPartnerInfo['Employed_In'],'~'));
			$countEmpIn = sizeof($arrCountEmpIn);
			if($countEmpIn > $varMaxSelFields) {
				$varPartnerEmployedIn = 'Any';
			} else {
				$varEmpInStr = join('~',$arrCountEmpIn);
				$varPartnerEmployedIn = $objCommon->getArrayFromString($varEmpInStr,$arrRetEmployedInOption);
			}
		}
		$varPartnerCareerStr .= 'Employed In - '.$varPartnerEmployedIn.', ';
	}
	$varPartnerCareerStr .= 'Occupation - '.$varPartnerOccupation.', ';
	$varPartnerCareerStr = trim($varPartnerCareerStr,', ');

	if($varPartnerInfo['Citizenship'] == 0) {
		$varPartnerCitizenship = 'All';
	} else {
		$arrCountCitizen = split('~+',trim($varPartnerInfo['Citizenship'],'~'));
		$countCitizen = sizeof($arrCountCitizen);
		if($countCitizen > $varMaxSelFields) {
			$varPartnerCitizenship = 'All';
		} else {
			$varCitizenshipStr = join('~',$arrCountCitizen);
			$varPartnerCitizenship = $objCommon->getArrayFromString($varCitizenshipStr,$arrCountryList);
		}
	}
	
	if($varPartnerInfo['Country'] == 0) {
		$varPartnerCountry = 'All';
	} else {
		$arrCountCountry = split('~+',trim($varPartnerInfo['Country'],'~'));
		$countCountry = sizeof($arrCountCountry);
		if($countCountry > $varMaxSelFields) {
			$varPartnerCountry = 'All';
		} else {
			$varCountryStr = join('~',$arrCountCountry);
			$varPartnerCountry = $objCommon->getArrayFromString($varCountryStr,$arrCountryList);
		}
	}

	if($varPartnerInfo['Resident_India_State'] == 0) {
		$varPartnerResidentIndiaState = '';
	} else {
		$arrCountIndiaState = split('~+',trim($varPartnerInfo['Resident_India_State'],'~'));
		$countIndiaState = sizeof($arrCountIndiaState);
		if($countIndiaState > $varMaxSelFields) {
			$varPartnerResidentIndiaState = '';
		} else {
			$varIndiaStateStr = join('~',$arrCountIndiaState);
			$varPartnerResidentIndiaState = $objCommon->getArrayFromString($varIndiaStateStr,$arrResidingStateList);
		}

		//join state array into common array
		if($varPartnerInfo['Resident_District'] == 0 || $varPartnerInfo['Resident_District'] == '') {
			$varPartnerCity = 'Any';
		} else {
			$arrPartnerCity = split('~+',trim($varPartnerInfo['Resident_District'],'~'));
			$countPartnerCity = sizeof($arrPartnerCity);
			if($countPartnerCity > $varMaxSelFields) {
				$varPartnerCity = 'Any';
			} else {
				$arrCommonDistrict = array();
				for($mk=0; $mk<$countIndiaState; $mk++) {
					$arrTempDistrict = $residingCityStateMappingList{$arrCountIndiaState[$mk]};
					$arrCommonDistrict += $$arrTempDistrict;
				}

				$varPartnerCityStr = join('~',$arrPartnerCity);
				$varPartnerCity = $objCommon->getArrayFromString($varPartnerCityStr,$arrCommonDistrict);
			}
		}
	}

	if($varPartnerInfo['Resident_USA_State'] == 0) {
		$varPartnerResidentUSAState = '';
	} else {
		$arrCountUSAState = split('~+',trim($varPartnerInfo['Resident_USA_State'],'~'));
		$countUSAState = sizeof($arrCountUSAState);
		if($countUSAState > $varMaxSelFields) {
			$varPartnerResidentUSAState = '';
		} else {
			$varUSAStateStr = join('~',$arrCountUSAState);
			$varPartnerResidentUSAState = $objCommon->getArrayFromString($varUSAStateStr,$arrUSAStateList);
		}
	}

	if($varPartnerResidentIndiaState == '' && $varPartnerResidentUSAState == '') 
	{ $varPartnerResidentState = 'Any'; }
	else if(($countIndiaState + $countUSAState) > $varMaxSelFields)
	{ $varPartnerResidentState = 'Any'; }
	else {
		if($varPartnerResidentIndiaState != '')
		{ $varPartnerResidentState = 'India : '.$varPartnerResidentIndiaState; }
		if($varPartnerResidentUSAState != '')
		{ 
			$varPartnerResidentState .= ($varPartnerResidentState!='')?'<BR>':'';
			$varPartnerResidentState = $varPartnerResidentState.'USA : '.$varPartnerResidentUSAState; 
		}
	}
	$varPartnerResidentState = trim($varPartnerResidentState,',');

	if($varPartnerInfo['Resident_Status'] == 0) {
		$varPartnerResidentStatus = 'All';
	} else {
		$arrCountResidentStatus = split('~+',trim($varPartnerInfo['Resident_Status'],'~'));
		$countResidentStatus = sizeof($arrCountResidentStatus);
		if($countResidentStatus > $varMaxSelFields) {
			$varPartnerResidentStatus = 'All';
		} else {
			$varResiStatusStr = join('~',$arrCountResidentStatus);
			$varPartnerResidentStatus = $objCommon->getArrayFromString($varResiStatusStr,$arrResidentStatusList);
		}
	}

	if($varPartnerCountry!='') {$varPartnerLocStr='Country - '.$varPartnerCountry.', ';}
	if($varPartnerResidentState!='') {$varPartnerLocStr.='State - '.$varPartnerResidentState.', ';}
	if($varPartnerCity!='') {$varPartnerLocStr.='City - '.$varPartnerCity.', ';}
	if($varPartnerCitizenship!='') {$varPartnerLocStr.='Citizenship - '.$varPartnerCitizenship.', ';}
	if($varPartnerResidentStatus!='') {$varPartnerLocStr.='Resident status - '.$varPartnerResidentStatus.', ';}
	$varPartnerLocStr = trim($varPartnerLocStr,', ');

	if($varPartnerInfo['Partner_Description'] == '') {
		$varPartnerDescription = '';
	} else {
		$varPartnerDescription = $varPartnerInfo['Partner_Description'];
	}

	if($varSizeRelArray>1) {
		if($varPartnerInfo['Religion'] == 0) {
			$varPartnerReligion = 'All';
		} else {
			$varPartnerReligion = $objCommon->getArrayFromString($varPartnerInfo['Religion'],$arrRetRelOption);
		}
	}

	if($varSizeDenomArray>1) {
		if($varPartnerInfo['Denomination'] == 0) {
			$varPartnerDenomination = 'All';
		} else {
			$varPartnerDenomination = $objCommon->getArrayFromString($varPartnerInfo['Denomination'],$arrRetDenomOption);
		}
	}

	if($varSizeCasteArray>1) {
		if($varPartnerInfo['CasteId'] == 0) {
			$varPartnerCasteOrDivision = 'All';
		} else {
			$arrCountCaste = split('~+',trim($varPartnerInfo['CasteId'],'~'));
			$countCaste = sizeof($arrCountCaste);
			if($countCaste > $varMaxSelFields) {
				$varPartnerCasteOrDivision = 'All';
			} else {
				$arrTempCasteList	= $objCommon->changingArray($arrRetCasteOption);
				$varCasteStr = join('~',$arrCountCaste);
				$varPartnerCasteOrDivision = $objCommon->getArrayFromString($varCasteStr,$arrTempCasteList);
			}
		}
	}

	if($varSizeSubcasteArray>1) {
		if($varPartnerInfo['SubcasteId'] == 0) {
			$varPartnerSubCaste = 'All';
		} else {
			$arrSubCountCaste = split('~+',trim($varPartnerInfo['SubcasteId'],'~'));
			$countSubCaste = sizeof($arrSubCountCaste);
			if($countSubCaste > $varMaxSelFields) {
				$varPartnerSubCaste = 'All';
			} else {
				$arrTempSubcasteList	= $objCommon->changingArray($arrRetSubcasteOption);
				$varSubCasteStr = join('~',$arrSubCountCaste);
				$varPartnerSubCaste = $objCommon->getArrayFromString($varSubCasteStr,$arrTempSubcasteList);
			}
		}
	}

	if($varSizeStarArray>1) {
		if($varPartnerInfo['Star'] == 0) {
			$varPartnerStar = 'All';
		} else {
			$arrStarCount = split('~+',trim($varPartnerInfo['Star'],'~'));
			$countStar = sizeof($arrStarCount);
			if($countStar > $varMaxSelFields) {
				$varPartnerStar = 'All';
			} else {
				$arrTempStarList	= $objCommon->changingArray($arrRetStarOption);
				$varStarStr = join('~',$arrStarCount);
				$varPartnerStar = $objCommon->getArrayFromString($varStarStr,$arrTempStarList);
			}
		}
	}

	if($varSizeRaasiArray>1) {
		if($varPartnerInfo['Raasi'] == 0) {
			$varPartnerRaasi = 'All';
		} else {
			$arrRaasiCount = split('~+',trim($varPartnerInfo['Raasi'],'~'));
			$countRaasi = sizeof($arrRaasiCount);
			if($countRaasi > $varMaxSelFields) {
				$varPartnerRaasi = 'All';
			} else {
				$arrTempRaasiList	= $objCommon->changingArray($arrRetRaasiOption);
				$varRaasiStr = join('~',$arrRaasiCount);
				$varPartnerRaasi = $objCommon->getArrayFromString($varRaasiStr,$arrTempRaasiList);
			}
		}
	}

	if($varSizeGothramArray>1) {
		if($varPartnerInfo['GothramId'] == 0) {
			$varPartnerGothram = 'All';
		} else {
			$arrGothramCount = split('~+',trim($varPartnerInfo['GothramId'],'~'));
			$countGothram = sizeof($arrGothramCount);
			if($countGothram > $varMaxSelFields) {
				$varPartnerGothram = 'All';
			} else {
				$arrTempGothramList	= $objCommon->changingArray($arrRetGothramOption);
				$varGothramStr = join('~',$arrGothramCount);
				$varPartnerGothram = $objCommon->getArrayFromString($varGothramStr,$arrTempGothramList);
			}
		}
	}


	$cs = "";
	if($varPartnerReligion!='All' && $varSizeRelArray>1) {
		$varPartnerBeliefs=$varPartnerReligion;
		$cs = ", ";
	}
	if($varPartnerDenomination!='All' && $varSizeDenomArray>1) {
		$varPartnerBeliefs=$varPartnerDenomination;
		$cs = ", ";
	}
	if($varPartnerCasteOrDivision!='All' && $varSizeCasteArray>1){
		$varPartnerBeliefs.=$cs.$varPartnerCasteOrDivision;
		$cs = ", ";
	}
	if($varPartnerSubCaste!='All' && $varSizeSubcasteArray>1) {
		$varPartnerBeliefs.=$cs.$varPartnerSubCaste;
	}
	if($varPartnerStar!='All' && $varSizeStarArray>1) {
		$varPartnerBeliefs.=$cs.$varPartnerStar;
	}
	if($varPartnerRaasi!='All' && $varSizeRaasiArray>1) {
		$varPartnerBeliefs.=$cs.$varPartnerRaasi;
	}
	if($varPartnerGothram!='All' && $varSizeGothramArray>1) {
		$varPartnerBeliefs.=$cs.$varPartnerGothram;
	}
	if($varSizeDoshamArray>1) {
		if($varPartnerInfo['Chevvai_Dosham']==0)
		{$varPartnerDosham = 'Doesn\'t matter';}else{$varPartnerDosham = $arrRetDoshamOption[$varPartnerInfo['Chevvai_Dosham']];}
		$varPartnerBeliefs.= $cs.' Dosham - '.$varPartnerDosham;
	}



	if($varPartnerInfo['Eating_Habits'] == 0){
		$varPartnerEatingHabits = "Doesn't matter";
	} else {
		$varPartnerEatingHabits = $arrEatingHabitsList[$varPartnerInfo['Eating_Habits']];
		$varPartnerHabits		= $varPartnerEatingHabits.', ';
	}

	
	if($varPartnerInfo['Drinking_Habits'] == 0)
	{
		$varPartnerDrinkingHabits = "Doesn't matter";
	} else {
		$varPartnerDrinkingHabits = $arrDrinkList[$varPartnerInfo['Drinking_Habits']];
		$varPartnerHabits		 .= $varPartnerDrinkingHabits.', ';
	}

	if($varPartnerInfo['Smoking_Habits'] == 0)
	{
		$varPartnerSmokingHabits= "Doesn't matter";
	} else {
		$varPartnerSmokingHabits= $arrSmokeList[$varPartnerInfo['Smoking_Habits']];
		$varPartnerHabits		.= $varPartnerSmokingHabits.', ';
	}

}//if


//get value for first photo and horoscope for checking photo under validation and horoscope under validation
$varPhHoroCondition	= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
$varPhHoroCount		= $objProfileDetail->numOfRecords($varTable['MEMBERPHOTOINFO'],'MatriId',$varPhHoroCondition);

if($varPhHoroCount>0) {
	$varPhHoroFields	= array('Normal_Photo1','HoroscopeURL');
	$varPhHoroResultSet	= $objProfileDetail->select($varTable['MEMBERPHOTOINFO'],$varPhHoroFields,$varPhHoroCondition,0);
	$varPhoneHorosope	= mysql_fetch_array($varPhHoroResultSet);

	if($varPhoneHorosope['HoroscopeURL']!='') {
		if($varMatriId == $sessMatriId) {
			if($varHoroAvailable==0) {
				$varFileExt = strtolower(substr(strrchr($varPhoneHorosope['HoroscopeURL'], '.'), 1 ));
				if($varFileExt=='html' || $varFileExt=='htm') {
					$varUploadMsg	= '';
					$varSameUser	= 1;
				} else {
					$varUploadMsg	= 'You have uploaded a scanned horoscope.';
				}
			} else if($varHoroAvailable==1) {
				$varUploadMsg	= 'You have uploaded a scanned horoscope.';
			}
		}
	}
}


if($varHoroAvailable==3 || $varSameUser==1) {
	$argFields				= array('MatriId','BirthYear','BirthMonth','BirthDay','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','BirthLongitude','BirthLatitude','BirthCity','BirthState','BirthCountry');
	$argCondition			= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
	$varHoroInfoResultSet	= $objProfileDetail->select($varTable['HORODETAILS'],$argFields,$argCondition,0);
	$varHoroInfo			= mysql_fetch_array($varHoroInfoResultSet);
	
	$varHoroBirthYear		= $varHoroInfo['BirthYear'];
	$varHoroBirthMonth		= $varHoroInfo['BirthMonth'];
	$varHoroBirthDay		= $varHoroInfo['BirthDay'];
	$varHoroBirthHour		= $varHoroInfo['BirthHour'];
	$varHoroBirthMinute		= $varHoroInfo['BirthMinute'];
	$varHoroBirthSeconds	= $varHoroInfo['BirthSeconds'];
	$varHoroBirthMeridian	= $varHoroInfo['BirthMeridian'];
	$varHoroBirthLongitude	= $varHoroInfo['BirthLongitude'];
	$varHoroBirthLatitude	= $varHoroInfo['BirthLatitude'];
	$varHoroBirthCity		= $varHoroInfo['BirthCity'];
	$varHoroBirthState		= $varHoroInfo['BirthState'];
	$varHoroBirthCountry	= $varHoroInfo['BirthCountry'];

	if($varHoroBirthCountry == 87) { //country is india
		$argCityFields			= array('Timezone');
		$argCityCondition		= "WHERE StateId='".$varHoroBirthState."' AND District='".$varHoroBirthCity."'";
		$varCityInfoResultSet	= $objProfileDetail->select($varTable['HORODISTRICT'],$argCityFields,$argCityCondition,0);
		$varCityHoroInfo		= mysql_fetch_array($varCityInfoResultSet);
		$varTimeZone			= $varCityHoroInfo['Timezone'];
		$varCityName			= $varHoroInfo['BirthCity'];
	} else {
		$argCityFields			= array('City_Name','Timezone');
		$argCityCondition		= "WHERE City_Id='".$varHoroBirthCity."'";
		$varCityInfoResultSet	= $objProfileDetail->select($varTable['HOROCITIES'],$argCityFields,$argCityCondition,0);
		$varCityHoroInfo		= mysql_fetch_array($varCityInfoResultSet);
		$varTimeZone			= $varCityHoroInfo['Timezone'];
		$varCityName			= $varCityHoroInfo['City_Name'];
	}

	$varHoroBirthTime		= $varHoroBirthHour.':'.$varHoroBirthMinute.':'.$varHoroBirthSeconds;
	$varHoroBirthDate		= $varHoroBirthYear.'-'.$varHoroBirthMonth.'-'.$varHoroBirthDay.' '.$varHoroBirthTime;
	$varHoroBirthDateStr	= date('d F Y, l',strtotime($varHoroBirthDate));
	$varHoroBirthTimeStr	= $varHoroBirthHour.':'.$varHoroBirthMinute.' '.$varHoroBirthMeridian;
}
?>
