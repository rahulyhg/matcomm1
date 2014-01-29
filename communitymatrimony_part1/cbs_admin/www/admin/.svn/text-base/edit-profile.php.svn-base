<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
# Decription    : Profile edit detail show here.
#=============================================================================================================
//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath."/conf/cityarray.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsAdminValMailer.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//OBJECT DECLARATION
$objMaster		= new MemcacheDB;
$objCommon		= new clsCommon;
$objMailManager = new AdminValid;
$objDomain		= new domainInfo;

//DB CONNECTION
$objMailManager->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varSepartePage					= $_REQUEST["spage"]=="yes";
$varMatriId 					= strtoupper($_REQUEST["MatriId"]);
$varReqFromPage					= $_REQUEST["reqFromPg"];
$varSuppId						= $_REQUEST["suppid"];
$varCurrentDate					= date('Y-m-d H:i:s');

$varFolderName	= $objMailManager->getFolderName($varMatriId);
include_once($varRootBasePath."/domainslist/".$varFolderName."/conf.cil14");

//Domain Related information
$varDenominationFeature		= $objDomain->useDenomination();
$varCasteFeature			= $objDomain->useCaste();
$varSubcasteFeature			= $objDomain->useSubcaste();
$varMatritalStatusFeature	= $objDomain->useMaritalStatus();
$varMotherTongueFeature		= $objDomain->useMotherTongue();
$varReligionFeature			= $objDomain->useReligion();
$varGothramFeature			= $objDomain->useGothram();
$varStarFeature				= $objDomain->useStar();
$varRaasiFeature			= $objDomain->useRaasi();
$varHoroscopeFeature		= $objDomain->useHoroscope();
$varDoshamFeature			= $objDomain->useDosham();

function getMultipleValuesFromArray($argArrName, $argNullOptionName, $argNullOptionValue, $argSelectedValue, $argUpdate = "")
{
	$funOptions	= "";
	if($argUpdate == "update"){ $funArrSelectedValue = explode("~", $argSelectedValue); }//if
	if($funArrSelectedValue == "" || $argSelectedValue == ""){ $funSelect = 'selected'; }else{ $funSelect = ''; }//else

	if($argSelectedValue==$argNullOptionValue) { $funSelect = 'selected'; }

	$funOptions .= '<option value="'.$argNullOptionValue.'" '.$funSelect.'>'.$argNullOptionName.'</option>';

	foreach($argArrName as $funIndex => $funValues)
	{
		if($argUpdate == "update")
		{ $funCheckSelectedValue = in_array($funIndex, $funArrSelectedValue) ? "selected"  : ""; }//if
		else
		{ $funCheckSelectedValue = $argSelectedValue == $funIndex ? "selected" : ""; }//else

		$funOptions .= '<option value="'.$funIndex.'" '.$funCheckSelectedValue.'>'.$funValues.'</option>';

	}//for
	echo $funOptions;
}//getValuesFromArray

//GET THE INR CURRENCY VALUES
function getInrValue($dbslave, $iCurrencyCode, $income){
  global $DBNAME,$varTable;
  $argFields		= array('ConvertedINRvalue');
  $argCondition	    = "where BaseCurrency='".$iCurrencyCode."'";
  $iInrCnt          = $dbslave->select($varTable['CURRENCYCONVERSIONRATES'],$argFields,$argCondition,0);
  $datInr	        = mysql_fetch_assoc($iInrCnt);

  if(!empty($datInr)){
    if($income)
      $iInrIncome = $income* $datInr['ConvertedINRvalue'];
    if(empty($iInrIncome))
      $iInrIncome = 0;
  }else{
    $iInrIncome = 0;
  }
  return $iInrIncome;
}

if ($_POST["frmEditSubmitProfile"]=="yes")//(*ND 20060925)
{
	$varMatriId 			= $_REQUEST["MatriId"];
	$argCondition			= "WHERE MatriId='".$varMatriId."'";

	//SETING MEMCACHE KEY
	$varProfileMCKey		= 'ProfileInfo_'.$varMatriId;

	$argFields 				= array('Date_Updated');
	$varDateUpdatedInfoRes	= $objMailManager->select($varTable['MEMBERUPDATEDINFO'],$argFields,$argCondition,0);
	$varDateUpdatedInfo		= mysql_fetch_assoc($varDateUpdatedInfoRes);
	$varDateUpdated			= $varDateUpdatedInfo['Date_Updated'];

	#UPDATE memberinfo TABLE

	$varEditedName			= addslashes(strip_tags(trim($_REQUEST["name"])));
	$varEditedNickName		= addslashes(strip_tags(trim($_REQUEST["nickName"])));
	$varEditedGender		= $_REQUEST["gender"];
	$varEditedMaritalStatus	= $_REQUEST["maritalStatus"];
	$varEditedReligion		= $_REQUEST["religion"];
	$varEditedDenomination	= $_REQUEST["denomination"];
    $varEditedDenominationTxt		= addslashes(strip_tags(trim($_REQUEST['othDenomination'])));
	$varEditedCaste			= $_REQUEST["caste"];
	$varEditedCasteTxt		= addslashes(strip_tags(trim($_REQUEST['othCaste'])));
	$varEditedSubcasteId	= $_REQUEST["subCaste"];
	$varEditedSubcasteTxt	= addslashes(strip_tags(trim($_REQUEST["othsubCaste"])));
	$varEditedCitizenship	= $_REQUEST["citizenship"];
	$varEditedCountry		= $_REQUEST["country"];
	$varEditedResidentStatus= $_REQUEST["residentStatus"];
	$varEditedNoOfChildren	= $_REQUEST["noOfChildren"];
	$varEditedChildLivWithMe= $_REQUEST["childrenLivingWithMe"];
	$varEditedGothramId		= $_REQUEST["gothram"];
	$varEditedGothramTxt	= addslashes(strip_tags(trim($_REQUEST["gothramTxt"])));
	$varEditedStar			= $_REQUEST["star"];
	$varEditedRaasi			= $_REQUEST["raasi"];
	$varEditedHoroscope		= $_REQUEST["horoscope"];
	$varEditedDosham		= $_REQUEST["dosham"];
	$varEditedProfileCreatedby= $_REQUEST["profilecreatedby"];
	$varEditedAboutMe		= addslashes(strip_tags(trim($_REQUEST["aboutMyself"])));
	$varEditedAboutMyPartner= addslashes(strip_tags(trim($_REQUEST["aboutMyPartner"])));
	$varEditedComplexion	= $_REQUEST["complexion"];
	$varEditedPhysicalStatus= $_REQUEST["physicalStatus"];
	$varEditedBodyType		= $_REQUEST["bodyType"];
	$varEditedBloodGroup	= $_REQUEST["bloodGroup"];
	$varEditedEducationCategory= $_REQUEST["educationCategory"];
	$varEditedEduDetail		= addslashes(strip_tags(trim($_REQUEST["educationInDetail"])));
	$varEditedEmployedIn	= $_REQUEST["employedIn"];
	$varEditedOccupation	= $_REQUEST["occupation"];
	$varEditedOccDetail		= addslashes(strip_tags(trim($_REQUEST["occupationInDetail"])));
	$varEditedIncomeCurrency= $_REQUEST["annualIncomeCurrency"];
	$varEditedAnnualIncome	= $_REQUEST["annualIncome"];
	$varEditedEatingHabits	= $_REQUEST["eatingHabits"];
	$varEditedDrink			= $_REQUEST["drink"];
	$varEditedSmoke			= $_REQUEST["smoke"];
	$varEditedResidingState	= addslashes(strip_tags(trim($_REQUEST["residingState"])));
	$varEditedResidingCity	= addslashes(strip_tags(trim($_REQUEST["residingCity"])));
	$varEditedMotherTongue	= $_REQUEST["motherTongue"];
	$varEditedMotherTongueTxt= addslashes(strip_tags(trim($_REQUEST["motherTongueTxt"])));

	$varEditedWhenMarry		= $_REQUEST["whenmarry"];
	$varEditedContactAddress= $_REQUEST["contactAddress"];
	$varEditedEthnicity		= $_REQUEST["ethnicity"];
	$varEditedProfileRefferedby= $_REQUEST["profilerefferedby"];
	$varEditedReligiousValues= $_REQUEST["religiousValues"];

	$varEditedAge			= addslashes(strip_tags(trim($_REQUEST["age"])));
	$varEditedDobYear		= $_REQUEST["dobYear"];
	$varEditedDobMonth		= $_REQUEST["dobMonth"];
	$varEditedDobDay		= $_REQUEST["dobDay"];
	$varEditedDob			= $varEditedDobYear."-".$varEditedDobMonth."-".$varEditedDobDay;
	if ($varEditedAge !="" && $varEditedDob!='--') {  $varEditedAge = $varEditedAge;}
	else if ($varEditedAge !="" && $varEditedDob=='--') {  $varEditedAge = $varEditedAge; $varEditedDob="";}
	else { $varEditedAge = $objCommon->ageCalculate($varEditedDobYear, $varEditedDobMonth, $varEditedDobDay); }
	//echo $varEditedAge.'hai---hai'.$varEditedDob;
	if ($_REQUEST["heightFeet"] != 0)
	{
		$varHeight		= trim($_REQUEST["heightFeet"]);
		$varHeightUnit	= "feet-inches";
	}//if
	elseif($_REQUEST["heightCms"] != 0)
	{
		$varHeight		= trim($_REQUEST["heightCms"]);
		$varHeightUnit	= "cm";
	}//else
	if ($_REQUEST["weightKgs"] != 0)
	{
		$varWeight		= trim($_REQUEST["weightKgs"]);
		$varWeightUnit	= "kg";
	}//if
	elseif ($_REQUEST["weightLbs"] != 0)
	{
		$varWeight		= trim($_REQUEST["weightLbs"]);
		$varWeightUnit	= "lbs";
	}//if

	if($varEditedIncomeCurrency!=98) {
			$income_inr = round(getInrValue($objMaster, $varEditedIncomeCurrency, $varEditedAnnualIncome));
	} else {
			$income_inr=$varEditedAnnualIncome;
	}

	$argCondition				= "MatriId='".$varMatriId."'";
	$argFields 						= array('GothramId','GothramText','Star','Raasi','Chevvai_Dosham','When_Marry');
	$argFields 					= array('Name','Nick_Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Denomination','DenominationText','Country','Resident_Status','Citizenship','Employed_In','Mother_TongueId','Mother_TongueText','Horoscope_Match','CasteId','CasteText','SubcasteId','SubcasteText','GothramId','GothramText','Star','Raasi','Chevvai_Dosham','When_Marry','About_Myself','About_MyPartner','Profile_Created_By','Religious_Values','Height','Height_Unit','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Education_Category', 'Education_Detail', 'Occupation', 'Occupation_Detail', 'Income_Currency', 'Annual_Income', 'Eating_Habits','Drink','Smoke','Date_Updated','Temp_Annual_Income');
	$argFieldsValues			= array("'".$varEditedName."'","'".$varEditedNickName."'","'".$varEditedAge."'","'".$varEditedDob."'","'".$varEditedGender."'","'".$varEditedMaritalStatus."'","'".$varEditedNoOfChildren."'","'".$varEditedChildLivWithMe."'","'".$varEditedReligion."'","'".$varEditedDenomination."'","'".$varEditedDenominationTxt."'","'".$varEditedCountry."'","'".$varEditedResidentStatus."'","'".$varEditedCitizenship."'","'".$varEditedEmployedIn."'","'".$varEditedMotherTongue."'","'".$varEditedMotherTongueTxt."'","'".$varEditedHoroscope."'","'".$varEditedCaste."'","'".$varEditedCasteTxt."'","'".$varEditedSubcasteId."'","'".$varEditedSubcasteTxt."'","'".$varEditedGothramId."'","'".$varEditedGothramTxt."'","'".$varEditedStar."'","'".$varEditedRaasi."'","'".$varEditedDosham."'","'".$varEditedWhenMarry."'","'".$varEditedAboutMe."'","'".$varEditedAboutMyPartner."'","'".$varEditedProfileCreatedby."'","'".$varEditedReligiousValues."'","'".$varHeight."'","'".$varHeightUnit."'","'".$varWeight."'","'".$varWeightUnit."'","'".$varEditedBodyType."'","'".$varEditedComplexion."'","'".$varEditedPhysicalStatus."'","'".$varEditedBloodGroup."'","'".$varEditedEducationCategory."'","'".$varEditedEduDetail."'","'".$varEditedOccupation."'","'".$varEditedOccDetail."'","'".$varEditedIncomeCurrency."'","'".$varEditedAnnualIncome."'","'".$varEditedEatingHabits."'","'".$varEditedDrink."'","'".$varEditedSmoke."'","'".$varDateUpdated."'","'".$income_inr."'");

	if($varReqFromPage!='profileval') {
		array_push($argFields,'Publish');
		array_push($argFieldsValues,"1");
	}

	if($_REQUEST['country'] == '98' || $_REQUEST['country'] == '222' ) {
		array_push($argFields,'Residing_State');
		array_push($argFieldsValues,"'".$varEditedResidingState."'");
		array_push($argFields,'Residing_Area');
		array_push($argFieldsValues,"''");
	} else {
		array_push($argFields,'Residing_State');
		array_push($argFieldsValues,"''");
		array_push($argFields,'Residing_Area');
		array_push($argFieldsValues,"'".$varEditedResidingState."'");
	}

	if($_REQUEST['country'] == '98' ) {
		array_push($argFields,'Residing_District');
		array_push($argFieldsValues,"'".$varEditedResidingCity."'");
		array_push($argFields,'Residing_City');
		array_push($argFieldsValues,"''");
	} else {
		array_push($argFields,'Residing_District');
		array_push($argFieldsValues,"''");
		array_push($argFields,'Residing_City');
		array_push($argFieldsValues,"'".$_REQUEST["residingCity"]."'");
	}

	if($_REQUEST['publish']	== 0) {
		array_push($argFields,'Profile_Published_On');
		array_push($argFieldsValues,"'".$varCurrentDate."'");
	}

	$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

	#--------------------------------------------------------------------------------------------------------------
	#UPDATE memberfamilyinfo TABLE
	$varEditedFamilyValue	= $_REQUEST["familyValue"];
	$varEditedFamilyType	= $_REQUEST["familyType"];
	$varEditedFamilyStatus	= $_REQUEST["familyStatus"];
	$varEditedBrothers		= $_REQUEST["brothers"];
	$varEditedMarriedBrother= $_REQUEST["marriedBrothers"];
	$varEditedSisters		= $_REQUEST["sisters"];
	$varEditedMarriedSisters= $_REQUEST["marriedSisters"];
	$varEditedFatOccupation	= addslashes(strip_tags(trim($_REQUEST["fatherOccupation"])));
	$varEditedMotOccupation	= addslashes(strip_tags(trim($_REQUEST["motherOccupation"])));
	$varEditedFamilyOrigin	= addslashes(strip_tags(trim($_REQUEST["ancestralOrigin"])));
	$varEditedFamilyDesc	= addslashes(strip_tags(trim($_REQUEST["familyDescription"])));

	$argFields 				= array('Family_Value','Family_Type','Family_Status','Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family','Date_Updated');
	$argFieldsValues		= array("'".$varEditedFamilyValue."'","'".$varEditedFamilyType."'","'".$varEditedFamilyStatus."'","'".$varEditedFatOccupation."'","'".$varEditedMotOccupation."'","'".$varEditedFamilyOrigin."'","'".$varEditedBrothers."'","'".$varEditedMarriedBrother."'","'".$varEditedSisters."'","'".$varEditedMarriedSisters."'","'".$varEditedFamilyDesc."'","'".$varDateUpdated."'");
	$varUpdateId			= $objMaster->update($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues,$argCondition);


	#--------------------------------------------------------------------------------------------------------------
	#UPDATE memberhobbiesinfo TABLE
	$varHobbies		= ($_REQUEST['hobbies']!='')?join('~',$_REQUEST['hobbies']):'';
	$varHobbiesDesc	= addslashes(strip_tags(trim($_REQUEST['hobbiesDesc'])));
	$varInterest	= ($_REQUEST['interest']!='')?join('~',$_REQUEST['interest']):'';
	$varInterestDesc= addslashes(strip_tags(trim($_REQUEST['interestDesc'])));
	$varMusic  		= ($_REQUEST['music']!='')?join('~',$_REQUEST['music']):'';
	$varMusicDesc	= addslashes(strip_tags(trim($_REQUEST['musicDesc'])));
	//$varRead		= ($_REQUEST['read']!='')?join('~',$_REQUEST['read']):'';
	//$varReadDesc	= addslashes(strip_tags(trim($_REQUEST['readDesc'])));
	//$varMovie		= ($_REQUEST['movie']!='')?join('~',$_REQUEST['movie']):'';
	//$varMovieDesc	= addslashes(strip_tags(trim($_REQUEST['movieDesc'])));
	$varSports		= ($_REQUEST['sports']!='')?join('~',$_REQUEST['sports']):'';
	$varSportsDesc	= addslashes(strip_tags(trim($_REQUEST['sportsDesc'])));
	$varFood		= ($_REQUEST['food']!='')?join('~',$_REQUEST['food']):'';
	$varFoodDesc	= addslashes(strip_tags(trim($_REQUEST['foodDesc'])));
	//$varDress		= ($_REQUEST['dress']!='')?join('~',$_REQUEST['dress']):'';
	//$varDressDesc	= addslashes(strip_tags(trim($_REQUEST['dressDesc'])));
	//$varSpokenLang	= ($_REQUEST['spokenLang']!='')?join('~',$_REQUEST['spokenLang']):'';
	//$varSpokenLangDesc= addslashes(strip_tags(trim($_REQUEST['spokenLangDesc'])));

	$argFields 				= array('Hobbies_Selected','Hobbies_Others','Interests_Selected','Interests_Others','Music_Selected','Music_Others','Books_Selected','Books_Others','Movies_Selected','Movies_Others','Sports_Selected','Sports_Others','Food_Selected','Food_Others','Dress_Style_Selected','Dress_Style_Others','Languages_Selected','Languages_Others','Date_Updated');
	$argFieldsValues		= array("'".$varHobbies."'","'".$varHobbiesDesc."'","'".$varInterest."'","'".$varInterestDesc."'","'".$varMusic."'","'".$varMusicDesc."'","'".$varRead."'","'".$varReadDesc."'","'".$varMovie."'","'".$varMovieDesc."'","'".$varSports."'","'".$varSportsDesc."'","'".$varFood."'","'".$varFoodDesc."'","'".$varDress."'","'".$varDressDesc."'","'".$varSpokenLang."'","'".$varSpokenLangDesc."'","'".$varCurrentDate."'");
	$varUpdateId			= $objMaster->update($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues,$argCondition);

	#--------------------------------------------------------------------------------------------------------------
	#UPDATE memberpartnerbasicinfo TABLE
	$lookingStatusValue			= ($_REQUEST['lookingStatus']!='')?join('~',$_REQUEST['lookingStatus']):'';
	$varPartnerMotherTongue		= ($_REQUEST['partnerMotherTongue']!='')?join('~',$_REQUEST['partnerMotherTongue']):'';
	$varPartnerEducation		= ($_REQUEST['education']!='')?join('~',$_REQUEST['education']):'';
	$varPartnerDenomination		= ($_REQUEST['partnerDenomination']!='')?join('~',$_REQUEST['partnerDenomination']):'';
	$varPartnerReligion			= ($_REQUEST['partnerReligion']!='')?join('~',$_REQUEST['partnerReligion']):'';
	$varPartnerCasteDivision	= ($_REQUEST['partnerCasteDivision']!='')?join('~',$_REQUEST['partnerCasteDivision']):'';
	$varPartnerSubCasteDivision	= ($_REQUEST['partnerSubCasteDivision']!='')?join('~',$_REQUEST['partnerSubCasteDivision']):'';
	$varPartnerCitizenship		= ($_REQUEST['partnerCitizenship']!='')?join('~',$_REQUEST['partnerCitizenship']):'';
	$varPartnerCountry			= ($_REQUEST['countryLivingIn']!='')?join('~',$_REQUEST['countryLivingIn']):'';
	$varPartnerResidentStatus	= ($_REQUEST['partnerResidentStatus']!='')?join('~',$_REQUEST['partnerResidentStatus']):'';
	$varPartnerIndiaState		= ($_REQUEST['residingIndia']!='')?join('~',$_REQUEST['residingIndia']):'';
	$varPartnerUSAState			= ($_REQUEST['residingUSA']!='')?join('~',$_REQUEST['residingUSA']):'';
	$varPartnerDesc				= addslashes(strip_tags(trim($_REQUEST["partnerDescription"])));

	$argFields 					= array('Age_From','Age_To','Looking_Status','Height_From','Height_To','Physical_Status','Education','Religion','Denomination','CasteId','SubcasteId','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_USA_State','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Date_Updated');
	$argFieldsValues			= array("'".$_REQUEST["fromAge"]."'","'".$_REQUEST["toAge"]."'","'".$lookingStatusValue."'","'".$_REQUEST["heightFrom"]."'","'".$_REQUEST["heightTo"]."'","'".$_REQUEST["partnerPhysicalStatus"]."'","'".$varPartnerEducation."'","'".$varPartnerReligion."'","'".$varPartnerDenomination."'","'".$varPartnerCasteDivision."'","'".$varPartnerSubCasteDivision."'","'".$_REQUEST["partnerManglik"]."'","'".$varPartnerCitizenship."'","'".$varPartnerCountry."'","'".$varPartnerIndiaState."'","'".$varPartnerUSAState."'","'".$varPartnerResidentStatus."'","'".$varPartnerMotherTongue."'","'".$varPartnerDesc."'","'".$_REQUEST["partnerEatingHabits"]."'","'".$_REQUEST["drinkingHabits"]."'","'".$_REQUEST["smokingHabits"]."'","'".$varCurrentDate."'");
	$varUpdateId				= $objMaster->update($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues,$argCondition);

	$argCondition				= "WHERE MatriId='".$varMatriId."'";

	if($_REQUEST['customerNotify']=='on' && $varReqFromPage!='profileval')
	{
		//check admin has modifieded the user detail or not
		$varUserModCont	= '';
		$varAdminModCont= '';
		if($varEditedName!=addslashes(strip_tags(trim($_REQUEST['oldname'])))) {
			$varLabel		= 'Name : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldname'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedName.'<BR>';
		}
		if($varEditedNickName!=addslashes(strip_tags(trim($_REQUEST['oldnickname'])))) {
			$varLabel		= 'Nick Name : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldnickname'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedNickName.'<BR>';
		}

        if($varEditedDenominationTxt!=addslashes(strip_tags(trim($_REQUEST['oldothdenomination'])))) {
			$varDenominationLabel	= $objDomain->getDenominationLabel();
			$varLabel		= $varDenominationLabel.' : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothdenomination'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedDenominationTxt.'<BR>';
		}

		if($varEditedCasteTxt!=addslashes(strip_tags(trim($_REQUEST['oldothcaste'])))) {
			$varCasteLabel	= $objDomain->getCasteLabel();
			$varLabel		= $varCasteLabel.' : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothcaste'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedCasteTxt.'<BR>';
		}
		if($varEditedSubcasteTxt!=addslashes(strip_tags(trim($_REQUEST['oldothsubcaste'])))) {
			$varSubcasteLabel= $objDomain->getSubcasteLabel();
			$varLabel		 = $varSubcasteLabel.' : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothsubcaste'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedSubcasteTxt.'<BR>';
		}
		if($varEditedMotherTongueTxt!=addslashes(strip_tags(trim($_REQUEST['oldothmothertongue'])))) {
			$varLabel		= 'Mother Tongue : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothmothertongue'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedMotherTongueTxt.'<BR>';
		}
		if($varEditedGothramTxt!=addslashes(strip_tags(trim($_REQUEST['oldothgothram'])))) {
			$varLabel		= 'Gothram : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothgothram'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedGothramTxt.'<BR>';
		}
		if($varEditedAboutMyPartner!=addslashes(strip_tags(trim($_REQUEST['oldaboutmypartner'])))) {
			$varLabel		= 'About My Parter : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldaboutmypartner'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedAboutMyPartner.'<BR>';
		}
		if($varEditedAboutMe!=addslashes(strip_tags(trim($_REQUEST['oldaboutme'])))) {
			$varLabel		= 'About Myself : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldaboutme'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedAboutMe.'<BR>';
		}
		if($varEditedAnnualIncome!=addslashes(strip_tags(trim($_REQUEST['oldannualincome'])))) {
			$varLabel		= 'Annual Income : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldannualincome'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedAnnualIncome.'<BR>';
		}
		if($varEditedEduDetail!=addslashes(strip_tags(trim($_REQUEST['oldedudetail'])))) {
			$varLabel		= 'Education Detail : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldedudetail'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedEduDetail.'<BR>';
		}
		if($varEditedOccDetail!=addslashes(strip_tags(trim($_REQUEST['oldoccdetail'])))) {
			$varLabel		= 'Occupation Detail : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldoccdetail'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedOccDetail.'<BR>';
		}
		if($varEditedFatOccupation!=addslashes(strip_tags(trim($_REQUEST['oldfatocc'])))) {
			$varLabel		= 'Father Occupation : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldfatocc'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedFatOccupation.'<BR>';
		}
		if($varEditedMotOccupation!=addslashes(strip_tags(trim($_REQUEST['oldmotocc'])))) {
			$varLabel		= 'Mother Occupation : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldmotocc'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedMotOccupation.'<BR>';
		}
		if($varEditedFamilyOrigin!=addslashes(strip_tags(trim($_REQUEST['oldfamilyori'])))) {
			$varLabel		= 'Family origin : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldfamilyori'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedFamilyOrigin.'<BR>';
		}
		if($varEditedFamilyDesc!=addslashes(strip_tags(trim($_REQUEST['oldaboutfamily'])))) {
			$varLabel		= 'About my family : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldaboutfamily'].'<BR>';
			$varAdminModCont.= $varLabel.$varEditedFamilyDesc.'<BR>';
		}
		if($varHobbiesDesc!=addslashes(strip_tags(trim($_REQUEST['oldothhobiies'])))) {
			$varLabel		= 'Hobbies : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothhobiies'].'<BR>';
			$varAdminModCont.= $varLabel.$varHobbiesDesc.'<BR>';
		}
		if($varInterestDesc!=addslashes(strip_tags(trim($_REQUEST['oldothinterest'])))) {
			$varLabel		= 'Interests : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothinterest'].'<BR>';
			$varAdminModCont.= $varLabel.$varInterestDesc.'<BR>';
		}
		if($varMusicDesc!=addslashes(strip_tags(trim($_REQUEST['oldothmusic'])))) {
			$varLabel		= 'Musics : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothmusic'].'<BR>';
			$varAdminModCont.= $varLabel.$varMusicDesc.'<BR>';
		}
		if($varSportsDesc!=addslashes(strip_tags(trim($_REQUEST['oldothsports'])))) {
			$varLabel		= 'Sports : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothsports'].'<BR>';
			$varAdminModCont.= $varLabel.$varSportsDesc.'<BR>';
		}
		if($varFoodDesc!=addslashes(strip_tags(trim($_REQUEST['oldothfood'])))) {
			$varLabel		= 'Food : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldothfood'].'<BR>';
			$varAdminModCont.= $varLabel.$varFoodDesc.'<BR>';
		}
		if($varPartnerDesc!=addslashes(strip_tags(trim($_REQUEST['oldpartnerdesc'])))) {
			$varLabel		= 'Partner Description : ';
			$varUserModCont	.= $varLabel.$_REQUEST['oldpartnerdesc'].'<BR>';
			$varAdminModCont.= $varLabel.$varPartnerDesc.'<BR>';
		}

		$argFields 				= array('Email');
		$varEmailInfoRes		= $objMailManager->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varEmailInfo			= mysql_fetch_assoc($varEmailInfoRes);
		$argTo					= $varEmailInfo['Email'];
		//$argSubject				= 'Your profile has been modified by '.$confValues['SERVERNAME'];
		if($varUserModCont!='') {
		$retValue				= $objMailManager->sendProfileModificationByAdminMail($varMatriId,$varEditedName,$argTo,$varUserModCont,$varAdminModCont);
		}
	}

	if($varReqFromPage!='profileval') {
		$varCommentwithAdmin	= '--'.date('y-m-d H:i:s').'--'.$_REQUEST['supportname'].'--'.$_REQUEST['adminComment'];

		$argFields 				= array('Support_Comments');
		$varadminCommentsRes	= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varadminComments		= mysql_fetch_assoc($varadminCommentsRes);
		$varComment				= addslashes(strip_tags(trim($varadminComments['Support_Comments'].$varCommentwithAdmin)));

		$argFields 				= array('Support_Comments');
		$argFieldsValues		= array("'".$varComment."'");
		$argCondition			= "MatriId='".$varMatriId."'";
		$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);
	}

	//DELETE memberupdatedinfo
	$argCondition			= "MatriId='".$varMatriId."'";
	$objMaster->delete($varTable['MEMBERUPDATEDINFO'],$argCondition);

	$objMaster->dbClose();

	if($varReqFromPage!='profileval') {
		echo '<div style="padding-top:5px;padding-bottom:5px;padding-left:10px;"><font class="heading">Edit Profile</font></div>';
		echo '<div style="padding-top:15px;padding-bottom:15px;padding-left:10px;"><font class="smalltxt"><b>Profile Updated Successfully</b></font></div>';
	} else {
		/*$varRedirectPage = "index.php?act=profile_validation&suppid=".$varSuppId."&reqFromPg=".$varReqFromPage."&id=".$varMatriId;
		echo '<div style="padding-top:15px;padding-bottom:15px;padding-left:10px;"><font class="smalltxt"><b>Profile Updated Successfully</b></font></div>';
		echo '<div><font class="smalltxt">&nbsp;<a href="'.$varRedirectPage.'">Back</a></font></div>';*/
		header("Location: index.php?act=profile_validation&suppid=".$varSuppId."&reqFromPg=".$varReqFromPage."&id=".$varMatriId);
	}

} else {

	if($varReqFromPage=='profileval') {
		$varActionVal	= "edit-profile.php";
	} else {
		$varActionVal	= "index.php?act=edit-profile";
	}
//SETING MEMCACHE KEY
$varProfileMCKey				= 'ProfileInfo_'.$varMatriId;
$argCondition					= "WHERE MatriId='".$varMatriId."'";

#Getting basic information for the selected profile
//$argFields 						= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
$argFields = $arrMEMBERINFOfields;
$varBasicInfo					= $objMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);

$varChildrenStatus				= $varBasicInfo["Children_Living_Status"];
$varNoOfChildren				= $varBasicInfo['No_Of_Children'];
$varPublish						= $varBasicInfo['Publish'];

if ($varNoOfChildren !="0") { $varSelectedChild = 'yes';}//if

$argFields 						= array('MatriId','Name','Nick_Name','Age','Denomination','DenominationText','CasteId','CasteText','SubcasteId','SubcasteText','Mother_TongueId','Mother_TongueText','About_Myself','Country','Citizenship','Resident_Status','Residing_State','Residing_City','Email','GothramId','GothramText','Contact_Address','Contact_Phone','Contact_Mobile','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Father_Occupation','Mother_Occupation','Family_Origin','About_Family','Other_Hobbies','Other_Interest','Other_Music','Other_Reads','Other_Movies','Other_Fitness','Other_Cuisine','Other_Dress','Other_Languages','Partner_Description');
$varUpdatedBasicInfoRes			= $objMailManager->select($varTable['MEMBERUPDATEDINFO'],$argFields,$argCondition,0);
$varUpdatedBasicInfo			= mysql_fetch_assoc($varUpdatedBasicInfoRes);

if ($varBasicInfo["Age"] !="0"){ $varAge=$varBasicInfo["Age"]; }//if
$varDOB=explode("-",$varBasicInfo["Dob"]);
$varYear	=	$varDOB[0];
$varMonth	=	$varDOB[1];
$varDay		=	$varDOB[2];


#Getting family information for the selected profile
if($varBasicInfo['Family_Set_Status']==1) {
$argFields 				= array('MatriId','Family_Value','Family_Type','Family_Status','Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family','Date_Updated');
$varCheckFamilyInfoRes	= $objMailManager->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
$varCheckFamilyInfo		= mysql_fetch_assoc($varCheckFamilyInfoRes);
$varCheckFamilyValue	= $varCheckFamilyInfo['Family_Value'];
$varCheckFamilyType		= $varCheckFamilyInfo['Family_Type'];
$varCheckFamilyStatus	= $varCheckFamilyInfo['Family_Status'];
$varSelectBrothers		= $varCheckFamilyInfo['Brothers'];
$varSelectBrothersMarried	= $varCheckFamilyInfo['Brothers_Married'];
$varSelectSisters		= $varCheckFamilyInfo['Sisters'];
$varSelectSistersMarried	= $varCheckFamilyInfo['Sisters_Married'];
//echo '<pre>'; print_r($varCheckFamilyInfo); echo '</pre>';
}

#Getting Hobbies information for the selected profile
if($varBasicInfo['Interest_Set_Status']==1) {
$argFields 				= array('MatriId','Hobbies_Selected','Hobbies_Others','Interests_Selected','Interests_Others','Music_Selected','Music_Others','Books_Selected','Books_Others','Movies_Selected','Movies_Others','Sports_Selected','Sports_Others','Food_Selected','Food_Others','Dress_Style_Selected','Dress_Style_Others','Languages_Selected','Languages_Others','Date_Updated');
$varCheckHobbiesInfoRes	= $objMailManager->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
$varCheckHobbiesInfo		= mysql_fetch_assoc($varCheckHobbiesInfoRes);

$arrHobbiesChecked = explode("~",$varCheckHobbiesInfo["Hobbies_Selected"]);
$arrInterestChecked = explode("~",$varCheckHobbiesInfo["Interests_Selected"]);
$arrMusicChecked = explode("~",$varCheckHobbiesInfo["Music_Selected"]);
$arrBooksChecked = explode("~",$varCheckHobbiesInfo["Books_Selected"]);
$arrMoviesChecked = explode("~",$varCheckHobbiesInfo["Movies_Selected"]);
$arrSportsChecked = explode("~",$varCheckHobbiesInfo["Sports_Selected"]);
$arrFoodChecked = explode("~",$varCheckHobbiesInfo["Food_Selected"]);
$arrDressChecked = explode("~",$varCheckHobbiesInfo["Dress_Style_Selected"]);
$arrLanguageChecked = explode("~",$varCheckHobbiesInfo["Languages_Selected"]);
}

#Getting basic partner preference information for the selected profile
if($varBasicInfo['Partner_Set_Status']==1) {
	$argFields 				= array('Age_From', 'Age_To', 'Looking_Status', 'Height_From', 'Height_To', 'Height_Unit', 'Physical_Status', 'Mother_Tongue', 'Partner_Description', 'Education','Religion', 'CasteId','CommunityId','SubcasteId', 'Chevvai_Dosham', 'Eating_Habits', 'Citizenship', 'Country', 'Resident_India_State', 'Resident_USA_State', 'Resident_Status','Drinking_Habits','Smoking_Habits');
	$varPartnerInfoRes		= $objMailManager->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
	$varPartnerInfo			= mysql_fetch_assoc($varPartnerInfoRes);

	$varLookingStatus		= explode("~",trim($varPartnerInfo['Looking_Status']));
}

$varState					= $varBasicInfo["Residing_State"];
$varCoutryId				= ($varUpdatedBasicInfo['Country']!='0' && $varUpdatedBasicInfo['Country']!='')?$varUpdatedBasicInfo['Country']:$varBasicInfo['Country'];
$varCitizenshipId			= ($varUpdatedBasicInfo['Citizenship']!='0' && $varUpdatedBasicInfo['Citizenship']!='')?$varUpdatedBasicInfo['Citizenship']:$varBasicInfo['Citizenship'];
$varLoadState				= "no";

if ($varCoutryId == 98)
{
	$varArrayList	= $arrResidingStateList;
	$varCountyCode	= 91;
	$varStateId		= ($varUpdatedBasicInfo['Residing_State']!='0' && $varUpdatedBasicInfo['Residing_State'] != '')?$varUpdatedBasicInfo['Residing_State']:$varBasicInfo['Residing_State'];
	$varLoadState	= "yes";
}//if
else if ($varCoutryId == 222)
{
	$varArrayList	= $arrUSAStateList;
	$varCountyCode	= 1;
	$varStateId		= ($varUpdatedBasicInfo['Residing_State']!='0' && $varUpdatedBasicInfo['Residing_State'] != '')?$varUpdatedBasicInfo['Residing_State']:$varBasicInfo['Residing_State'];
	$varLoadState	= "yes";
}//else if
else
{
	$varState		= ($varUpdatedBasicInfo['Residing_State']!='0' && $varUpdatedBasicInfo['Residing_State'] != '')?$varUpdatedBasicInfo['Residing_State']:$varBasicInfo['Residing_Area'];
}

/* Ashok code check */
/*print '<pre>';
echo $varCoutryId; echo '<br>';
print_r ($varArrayList); echo '<br>';
echo $varStateId; echo '<br>';
echo $varLoadState; echo '<br>';
echo $objCommon->getValuesFromArray($varArrayList, "- Select - ", "0", $varStateId);
print '</pre>';*/

if($varBasicInfo['Filter_Set_Status']==1) {
	$argFields 				= array('Marital_Status', 'Age_Above', 'Age_Below', 'Country','Date_Updated');
	$varArrFilterValuesRes		= $objMailManager->select($varTable['MEMBERFILTERINFO'],$argFields,$argCondition,0);
	$varArrFilterValues			= mysql_fetch_assoc($varArrFilterValuesRes);
	$varFilterMaritalStatus	= split("~", $varArrFilterValues["Marital_Status"]);
}


//find Phone no for corresponding test box
if($varBasicInfo["Contact_Phone"] != '') {
	$arrPhone		= explode('~',$varBasicInfo["Contact_Phone"]);
	$varCountryCode = $arrPhone[0];
	$varAreaCode	= $arrPhone[1];
	$varPhoneCode	= $arrPhone[2];
} if($varBasicInfo['Contact_Mobile'] != '') {
	$arrPhone		= explode('~',$varBasicInfo['Contact_Mobile']);
	$varCountryCode = $arrPhone[0];
	$varMobileCode	= $arrPhone[1];
}
#================================================================================================================
?>

<!-- <script language="javascript" src="../registration/includes/add-physical.js" type="text/javascript"></script>
<script language="javascript" src="../search/includes/profile-view.js" type="text/javascript"></script> -->
<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/modify.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<!-- 1st Table starts here-->
<?
	$varFrmName				= ($varUpdatedBasicInfo['Name']!='')?$varUpdatedBasicInfo['Name']:$varBasicInfo['Name'];
	$varFrmNickName			= ($varUpdatedBasicInfo['Nick_Name']!='')?$varUpdatedBasicInfo['Nick_Name']:$varBasicInfo['Nick_Name'];
	$varFrmAge				= ($varUpdatedBasicInfo['Age']!=0)?$varUpdatedBasicInfo['Age']:$varBasicInfo['Age'];
	$varFrmDenominationId	= ($varUpdatedBasicInfo['Denomination']!=0)?$varUpdatedBasicInfo['Denomination']:$varBasicInfo['Denomination'];
	$varFrmDenominationText		= ($varUpdatedBasicInfo['DenominationText']!='')?$varUpdatedBasicInfo['DenominationText']:$varBasicInfo['DenominationText'];
	$varFrmCasteId			= ($varUpdatedBasicInfo['CasteId']!=0)?$varUpdatedBasicInfo['CasteId']:$varBasicInfo['CasteId'];
	$varFrmCasteText		= ($varUpdatedBasicInfo['CasteText']!='')?$varUpdatedBasicInfo['CasteText']:$varBasicInfo['CasteText'];
	$varFrmSubcasteId		= ($varUpdatedBasicInfo['SubcasteId']!=0)?$varUpdatedBasicInfo['SubcasteId']:$varBasicInfo['SubcasteId'];
	$varFrmSubcasteText		= ($varUpdatedBasicInfo['SubcasteText']!='')?$varUpdatedBasicInfo['SubcasteText']:$varBasicInfo['SubcasteText'];
	$varFrmMotherTongueId	= ($varUpdatedBasicInfo['Mother_TongueId']!=0)?$varUpdatedBasicInfo['Mother_TongueId']:$varBasicInfo['Mother_TongueId'];
	$varFrmMotherTongueText	= ($varUpdatedBasicInfo['Mother_TongueText']!='')?$varUpdatedBasicInfo['Mother_TongueText']:$varBasicInfo['Mother_TongueText'];
	$varFrmAboutMe			= ($varUpdatedBasicInfo['About_Myself']!='')?$varUpdatedBasicInfo['About_Myself']:$varBasicInfo['About_Myself'];
	$varFrmAboutMyPartner	= $varBasicInfo['About_MyPartner'];
	$varFrmCountry			= (($varUpdatedBasicInfo['Country']!='0' && $varUpdatedBasicInfo['Country']!=0)?$varUpdatedBasicInfo['Country']:$varBasicInfo['Country']);
	$varFrmCitizenship		= (($varUpdatedBasicInfo['Citizenship']!='0' && $varUpdatedBasicInfo['Citizenship']!=0)?$varUpdatedBasicInfo['Citizenship']:$varBasicInfo['Citizenship']);
	$varFrmGothramId		= ($varUpdatedBasicInfo['GothramId']!=0)?$varUpdatedBasicInfo['GothramId']:$varBasicInfo['GothramId'];
	$varFrmGothramText		= ($varUpdatedBasicInfo['GothramText']!='')?$varUpdatedBasicInfo['GothramText']:$varBasicInfo['GothramText'];
	$varEducationDet		= ($varUpdatedBasicInfo['Education_Detail']!='')?$varUpdatedBasicInfo['Education_Detail']:$varBasicInfo['Education_Detail'];
	$varOccupationDet		= ($varUpdatedBasicInfo['Occupation_Detail']!='')?$varUpdatedBasicInfo['Occupation_Detail']:$varBasicInfo['Occupation_Detail'];
	$varFrmAnnualIncomeCurrency		= $varUpdatedBasicInfo['Income_Currency']!=0?$varUpdatedBasicInfo['Income_Currency']:$varBasicInfo['Income_Currency'];
	$varFrmAnnualIncome		= $varUpdatedBasicInfo['Annual_Income']!=0?$varUpdatedBasicInfo['Annual_Income']:$varBasicInfo['Annual_Income'];
	$varFrmFatherOcc		= ($varUpdatedBasicInfo['Father_Occupation']!='')?$varUpdatedBasicInfo['Father_Occupation']:$varCheckFamilyInfo['Father_Occupation'];
	$varFrmMotherOcc		= ($varUpdatedBasicInfo['Mother_Occupation']!='')?$varUpdatedBasicInfo['Mother_Occupation']:$varCheckFamilyInfo['Mother_Occupation'];
	$varFrmFamilyOrigin		= ($varUpdatedBasicInfo['Family_Origin']!='')?$varUpdatedBasicInfo['Family_Origin']:$varCheckFamilyInfo['Family_Origin'];
	$varFrmAboutMyFamily	= ($varUpdatedBasicInfo['About_Family']!='')?$varUpdatedBasicInfo['About_Family']:$varCheckFamilyInfo['About_Family'];
	$varFrmHobbiesOthers	= ($varUpdatedBasicInfo['Other_Hobbies']!='')?$varUpdatedBasicInfo['Other_Hobbies']:$varCheckHobbiesInfo['Hobbies_Others'];
	$varFrmInterestOthers	= ($varUpdatedBasicInfo['Other_Interest']!='')?$varUpdatedBasicInfo['Other_Interest']:$varCheckHobbiesInfo['Interests_Others'];
	$varFrmMusicOthers		= ($varUpdatedBasicInfo['Other_Music']!='')?$varUpdatedBasicInfo['Other_Music']:$varCheckHobbiesInfo['Music_Others'];
	$varFrmSportsOthers		= ($varUpdatedBasicInfo['Other_Fitness']!='')?$varUpdatedBasicInfo['Other_Fitness']:$varCheckHobbiesInfo['Sports_Others'];
	$varFrmFoodOthers		= ($varUpdatedBasicInfo['Other_Cuisine']!='')?$varUpdatedBasicInfo['Other_Cuisine']:$varCheckHobbiesInfo['Food_Others'];
	$varFrmPartnerDesc		= ($varUpdatedBasicInfo['Partner_Description']!='')?$varUpdatedBasicInfo['Partner_Description']:$varPartnerInfo['Partner_Description'];
?>
<form name="frmEditProfile" method="post" action=<?=$varActionVal?> onSubmit="return funProfileValidate();">
<input type="hidden" name="frmEditSubmitProfile" value="yes">
<input type="hidden" name="MatriId" value="<?=$varBasicInfo['MatriId']?>">
<input type="hidden" name="oldname" value="<?=$varFrmName?>">
<input type="hidden" name="oldnickname" value="<?=$varFrmNickName?>">
<input type="hidden" name="oldothcaste" value="<?=$varFrmCasteText?>">
<input type="hidden" name="oldothdenomination" value="<?=$varFrmDenominationText?>">
<input type="hidden" name="oldothsubcaste" value="<?=$varFrmSubcasteText?>">
<input type="hidden" name="oldothmothertongue" value="<?=$varFrmMotherTongueText?>">
<input type="hidden" name="oldothgothram" value="<?=$varFrmGothramText?>">
<input type="hidden" name="oldaboutme" value="<?=$varFrmAboutMe?>">
<input type="hidden" name="oldaboutmypartner" value="<?=$varFrmAboutMyPartner?>">
<input type="hidden" name="oldannualincome" value="<?=$varFrmAnnualIncome?>">
<input type="hidden" name="oldedudetail" value="<?=$varEducationDet?>">
<input type="hidden" name="oldoccdetail" value="<?=$varOccupationDet?>">
<input type="hidden" name="oldfatocc" value="<?=$varFrmFatherOcc?>">
<input type="hidden" name="oldmotocc" value="<?=$varFrmMotherOcc?>">
<input type="hidden" name="oldfamilyori" value="<?=$varFrmFamilyOrigin?>">
<input type="hidden" name="oldaboutfamily" value="<?=$varFrmAboutMyFamily?>">
<input type="hidden" name="oldothhobiies" value="<?=$varFrmHobbiesOthers?>">
<input type="hidden" name="oldothinterest" value="<?=$varFrmInterestOthers?>">
<input type="hidden" name="oldothmusic" value="<?=$varFrmMusicOthers?>">
<input type="hidden" name="oldothsports" value="<?=$varFrmSportsOthers?>">
<input type="hidden" name="oldothfood" value="<?=$varFrmFoodOthers?>">
<input type="hidden" name="oldpartnerdesc" value="<?=$varFrmPartnerDesc?>">
<input type="hidden" name="reqFromPg" value="<?=$varReqFromPage?>">
<input type="hidden" name="suppid" value="<?=$varSuppId?>">
<input type="hidden" name="publish" value="<?=$varPublish?>">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="542">
	<tr><td align="left" class="heading" style="padding-left:10px;padding-top:10px;">Edit Profile</td></tr>
	<tr><td height="10"></td></tr>
	<tr><td valign="top">
			<!-- Basic Information starts here-->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader">
					<td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">Basic Information</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Name:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><input type="text" class="smalltxt" maxLength="20" size="20" name="name" value="<?=$varFrmName?>">
					</td>
				</tr>


				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Display Name:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><input type="text" class="smalltxt" maxLength="20" size="20" name="nickName" value="<?=$varFrmNickName?>">
					</td>
				</tr>


				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">

					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Age:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><input type="text" class="smalltxt" maxLength="2" size="2" name="age" value="<?=$varFrmAge;?>">
					&nbsp;Years&nbsp;&nbsp;&nbsp;<font color=#000000>or</font>&nbsp;&nbsp;&nbsp; <select class="combobox"	 onchange="agesel();updateDay('month','frmEditProfile','dobYear','dobMonth','dobDay');" size="1" name="dobMonth">
							<option value="0">-Month-</option>
						<?=$objCommon->monthDropdown($varMonth)?>
						</select>
						<select class="combobox" onchange=agesel(); name="dobDay">
							<option value="1">-Date-</option>
							<option value="1" <?=$varDay==1 ? "selected" : "";?>>1</option>
							<option value="2" <?=$varDay==2 ? "selected" : "";?>>2</option>
							<option value="3" <?=$varDay==3 ? "selected" : "";?>>3</option>
							<option value="4" <?=$varDay==4 ? "selected" : "";?>>4</option>
							<option value="5" <?=$varDay==5 ? "selected" : "";?>>5</option>
							<option value="6" <?=$varDay==6 ? "selected" : "";?>>6</option>
							<option value="7" <?=$varDay==7 ? "selected" : "";?>>7</option>
							<option value="8" <?=$varDay==8 ? "selected" : "";?>>8</option>
							<option value="9" <?=$varDay==9 ? "selected" : "";?>>9</option>
							<option value="10" <?=$varDay==10 ? "selected" : "";?>>10</option>
							<option value="11" <?=$varDay==11 ? "selected" : "";?>>11</option>
							<option value="12" <?=$varDay==12 ? "selected" : "";?>>12</option>
							<option value="13" <?=$varDay==13 ? "selected" : "";?>>13</option>
							<option value="14" <?=$varDay==14 ? "selected" : "";?>>14</option>
							<option value="15" <?=$varDay==15 ? "selected" : "";?>>15</option>
							<option value="16" <?=$varDay==16 ? "selected" : "";?>>16</option>
							<option value="17" <?=$varDay==17 ? "selected" : "";?>>17</option>
							<option value="18" <?=$varDay==18 ? "selected" : "";?>>18</option>
							<option value="19" <?=$varDay==19 ? "selected" : "";?>>19</option>
							<option value="20" <?=$varDay==20 ? "selected" : "";?>>20</option>
							<option value="21" <?=$varDay==21 ? "selected" : "";?>>21</option>
							<option value="22" <?=$varDay==22 ? "selected" : "";?>>22</option>
							<option value="23" <?=$varDay==23 ? "selected" : "";?>>23</option>
							<option value="24" <?=$varDay==24 ? "selected" : "";?>>24</option>
							<option value="25" <?=$varDay==25 ? "selected" : "";?>>25</option>
							<option value="26" <?=$varDay==26 ? "selected" : "";?>>26</option>
							<option value="27" <?=$varDay==27 ? "selected" : "";?>>27</option>
							<option value="28" <?=$varDay==28 ? "selected" : "";?>>28</option>
							<option value="29" <?=$varDay==29 ? "selected" : "";?>>29</option>
							<option value="30" <?=$varDay==30 ? "selected" : "";?>>30</option>
							<option value="31" <?=$varDay==31 ? "selected" : "";?>>31</option>
						</select>
						<select class="combobox"onchange="agesel();updateDay('year','frmAddRegistrationBasic','dobYear','dobMonth','dobDay');" name="dobYear">
							<option value="0">-Year-</option>
							<?=$objCommon->getYears($varYear);?>
						</select>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" >Gender :</td>
					<td valign="top" width="165" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<input type="radio" value="1" name="gender" <?=$varBasicInfo["Gender"]==1 ? "checked" : "";?>>Male&nbsp;<input type="radio" value="2" name="gender" <?=$varBasicInfo["Gender"]==2 ? "checked" : "";?>>Female
						</select>
					</td>
				</tr>
				<tr class="viewbgclr">
					<td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<? if($varMatritalStatusFeature==1) {
					$arrRetMaritalStatus	= $objDomain->getMaritalStatusOption();
					$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);
					if($varSizeMaritalStatus==1) {?>
						<input type="hidden" name="maritalStatus" value="<?=key($arrRetMaritalStatus)?>">
					<?} else {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"> <?=$objDomain->getMaritalStatusLabel()?> :</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
							<input type="radio" name="maritalStatus" value="1" id="maristat1" <?=$varBasicInfo["Marital_Status"]==1 ? "checked" : "";?>><font class="smalltxt">Unmarried</font>
							<input type="radio" name="maritalStatus" value="4" id="maristat2" <?=$varBasicInfo["Marital_Status"]==4 ? "checked" : "";?>><font class="smalltxt">Separated</font>
							<input type="radio" name="maritalStatus" value="2" id="maristat3" <?=$varBasicInfo["Marital_Status"]==2 ? "checked" : "";?>><font class="smalltxt">Widow/Widower</font>
							<input type=radio name="maritalStatus" value="3" id="maristat4" <?=$varBasicInfo["Marital_Status"]==3 ? "checked" : "";?>><font class="smalltxt">Divorced</font>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
					<? }
				} ?>
				<?if($varReligionFeature==1) {
					$arrRetReligion	= $objDomain->getReligionOption();
					$varSizeReligion= sizeof($arrRetReligion);

					if($varSizeReligion==1) {?>
						<input type="hidden" name="religion" value="<?=key($arrRetReligion)?>">
					<?} else {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Religion:</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
							<select class="combobox" size="1" name="religion" id="religion">
								<?=$objCommon->getValuesFromArray($arrRetReligion, "- Select - ", "0", $varBasicInfo['Religion']);?>
							</select>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
					<? }
				 } ?>

				 <?if($varDenominationFeature==1) {
					$arrRetDenomination	= $objDomain->getDenominationOption();
					$varSizeDenomination= sizeof($arrRetDenomination);

					if($varSizeDenomination==1) {?>
						<input type="hidden" name="denomination" value="<?=key($arrRetDenomination)?>">
					<?} else {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getDenominationLabel()?>:</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
							<select class="combobox" size="1" name="denomination" id="denomination">
								<?=$objCommon->getValuesFromArray($arrRetDenomination, "- Select - ", "0", $varFrmDenominationId);?>
							</select>
							<? if($varFrmDenominationId == 9997) { ?>
							&nbsp;<input type="text" name="othDenomination" value="<?=$varFrmDenominationText;?>" size="15" tabindex="<?=$varTabIndex++?>"> <? } ?>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
					<? }
				 } ?>

				 <?if($varCasteFeature==1) {
					$arrRetReligion	= $objDomain->getReligionOption();
					$arrRetCaste	= $objDomain->getCasteOption();
					if(sizeof($arrRetReligion)>1 && sizeof($arrRetCaste)>1) {
						$arrRetCaste= $objDomain->getCasteOptionsForReligion($varBasicInfo['Religion']);
					} else if($varSizeDenomination>1 && sizeof($arrRetCaste)>1) {
						$arrRetCaste= $objDomain->getCasteOptionsForDenomination($varFrmDenominationId);
					} else {
						$arrRetCaste= $objDomain->getCasteOption();
					}
					$varSizeCaste	= sizeof($arrRetCaste);

					if($varSizeCaste==1) {?>
						<input type="hidden" name="caste" value="<?=key($arrRetCaste)?>">
					<?} else {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getCasteLabel()?>:</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
							<? if($varSizeCaste>1){?>
							<select class="combobox" size="1" name="caste" id="caste">
								<?=$objCommon->getValuesFromArray($arrRetCaste, "- Select - ", "0", $varFrmCasteId);?>
							</select>
							<div class="fleft" id="othcastediv" style="display:none;padding-left:10px"><input type=text name=othCaste value="<?=$varFrmCasteText?>" size=15 class="inputtext" id="othCaste" <?=($varFrmCasteId != 9997)?'disabled':'';?>></div>
							<? } else { ?>
							<input type=text name=othCaste value="<?=$varFrmCasteText?>" size=30 class="smalltxt">
							<? } ?>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
					<? }
				 } ?>

				 <?if($varSubcasteFeature==1) {
					$arrRetSubcaste	= $objDomain->getSubcasteOption();
					$varSizeSubcaste= sizeof($arrRetSubcaste);

					if($varSizeSubcaste==1) {?>
						<input type="hidden" name="subCaste" value="<?=key($arrRetCaste)?>">
					<?} else {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getSubcasteLabel()?>:</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
							<? if($varSizeSubcaste>1){?>
							<select class="combobox" size="1" name="subCaste" id="subCaste">
								<?=$objCommon->getValuesFromArray($arrRetSubcaste, "- Select - ", "0", $varFrmSubcasteId);?>
							</select>
							<div class="fleft" id="othsubcastediv" style="display:none;padding-left:10px"><input type=text name=othsubCaste value="<?=$varFrmSubcasteText?>" size=15 class="inputtext" id="othsubCaste" <?=($varFrmSubcasteId != 9997)?'disabled':'';?>></div>
							<? } else { ?>
							<input type=text name=othsubCaste value="<?=$varFrmSubcasteText?>" size=30 class="smalltxt">
							<? } ?>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
					<? }
				 } ?>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" >Citizenship :</td>
					<td valign="top" width="165" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<select class="combobox" name="citizenship">
						<?=$objCommon->getValuesFromArray($arrCountryList, "- Select - ", "0", $varFrmCitizenship);
						?>
						</select>
					</td>
				</tr>
				<tr class="viewbgclr">
					<td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" >Country Living in :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<span id="loccountry"></span>
						<select name="country" size="1" class="combobox" onChange='countryChk();'>
						<?=$objCommon->getValuesFromArray($arrCountryList, "- Select - ", "0", $varFrmCountry);?>
						</select>
					</td>
				</tr>
				<tr class="viewbgclr">
					<td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top"  class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Resident Status :</td>
					<td valign="top"  class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<table border="0" cellpadding="0" cellspacing="0">
								<?
								$varTmpResidentStatus = ($varUpdatedBasicInfo['Resident_Status']!='0' && $varUpdatedBasicInfo['Resident_Status']!='')?$varUpdatedBasicInfo['Resident_Status']:$varBasicInfo['Resident_Status'];
								?>
								<tr>
									<td>
									<input type="radio" value="1" name="residentStatus" <?=$varTmpResidentStatus==1 ? "CHECKED" : "";?>><font class="smalltxt">Citizen</font>
									<input type="radio" value="2" name="residentStatus" <?=$varTmpResidentStatus==2 ? "CHECKED" : "";?>><font class="smalltxt">Permanent resident</font>
									<input type="radio" value="4" name="residentStatus" <?=$varTmpResidentStatus==4 ? "CHECKED" : "";?>><font class="smalltxt">Student visa</font>
									</td>
								</tr>
								<tr>
									<td>
									<input type="radio" value="5" name="residentStatus" <?=$varTmpResidentStatus==5 ? "CHECKED" : "";?>><font class="smalltxt">Temporary visa</font>
									<input type="radio" value="3" name="residentStatus" <?=$varTmpResidentStatus==3 ? "CHECKED" : "";?>><font class="smalltxt">Work permit</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</td>
								</tr>
							</table>
						</td>
				</tr>
				<tr class="viewbgclr">
					<td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">

					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">No. of children:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<select name="noOfChildren" class="combobox" size=1>
							<option value="0" <?php if ($varNoOfChildren==0 && $varSelectedChild=="yes") { echo "selected";}?>>None</option>
							<option value="1" <?=$varNoOfChildren==1 ? "selected" : "";?>>1</option>
							<option value="2" <?=$varNoOfChildren==2 ? "selected" : "";?>>2</option>
							<option value="3" <?=$varNoOfChildren==3 ? "selected" : "";?>>3+</option>
						</select></font>
					</td>

				</tr>
				<tr class="viewbgclr">
					<td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Children living status:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<input type="radio" value="0" name="childrenLivingWithMe" <?php if ($varChildrenStatus==0 && $varSelectedChild=="yes" && $varNoOfChildren!=0) { echo "checked"; }//if?>>Living with me &nbsp; <input type="radio" value="1" name="childrenLivingWithMe" <?=($varChildrenStatus==1 || $varNoOfChildren==0)? "checked" : "";?>>Not living with me</font>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<?if($varGothramFeature == 1) {
					$arrRetGothram	= $objDomain->getGothramOption();
					$varSizeGothram	= sizeof($arrRetGothram);
					if($varSizeGothram==1) {?>
						<input type="hidden" name="gothram" value="<?=key($arrRetGothram)?>">
					<?} else {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getGothramLabel()?> :</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
							<? if($varSizeGothram>1){?>
							<select name='gothram' id='gothram' class='combobox'>
								<?=$objCommon->getValuesFromArray($arrRetGothram, "- Select -", "0", $varFrmGothramId);?>
							</select>
							<? } else { ?>
							<input type=text name=gothramTxt value="<?=$varFrmGothramText?>" size=34 class="smalltxt">
							<? } ?>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
					<? }
				} ?>

				<?if($varStarFeature == 1) {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getStarLabel();?> :</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
							<select class='combobox' name='star' size='1'>
								<?=$objCommon->getValuesFromArray($objDomain->getStarOption(), "- Select - ", "", $varBasicInfo['Star']);?>
							</select>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } ?>

				<?if($varRaasiFeature == 1) {?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getRaasiLabel()?> :</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
							<select class='combobox' name='raasi' size='1'>
								<?=$objCommon->getValuesFromArray($objDomain->getRaasiOption(), "- Select - ", "", $varBasicInfo['Raasi']);?>
							</select>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } ?>

				<?if($varHoroscopeFeature == 1) {?>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" ><?=$objDomain->getHoroscopeLabel()?> :</td>
					<td valign="top" width="165" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<input type="radio" value="1" name="horoscope" <?=$varBasicInfo["Horoscope_Match"]==1 ? "checked" : "";?>>Required&nbsp;<input type="radio" value="2" name="horoscope" <?=$varBasicInfo["Horoscope_Match"]==2 ? "checked" : "";?>>Not Required
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } ?>

				<?if($varDoshamFeature == 1) {
					$arrRetDosham	= $objDomain->getDoshamOption();?>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" ><?=$objDomain->getDoshamLabel()?> :</td>
					<td valign="top" width="165" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<? foreach($arrRetDosham as $key=>$value){
							$varChecked = ($key == $varBasicInfo["Chevvai_Dosham"])?'checked':'';
							echo '<input type="radio" name=dosham value="'.$key.'"  id="dosham'.$key.'" '.$varChecked.'>'.$value.'&nbsp;';
						}?>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } ?>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Profile created by:</td>
					<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<select class="combobox" size="1" name="profilecreatedby"">
							<?=$objCommon->getValuesFromArray($arrProfileCreatedByList, "- Select - ", "0", $varBasicInfo['Profile_Created_By']);?>
						</select>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr ><td  height="10" colspan="4"></td></tr>
				<!---->
			</table><br>
			<!-- Basic Information starts here-->
			<!-- About myself Information starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader"><td valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;text-align:left;" class="viewheading">Short Partner Description</td></tr>
				<tr bgcolor="#FFFFFF">
				   <td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;text-align:justify;" align="center"><textarea name="aboutMyPartner" id="aboutMyPartner" rows=3 cols=68 class="smalltxt" style="padding:5px;text-align:justify;"><?=$varFrmAboutMyPartner;?>
				   </textarea></td>
				</tr>
			</table><br>
			<!-- About myself Information ends here -->

			<!-- About myself Information starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader"><td valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;text-align:left;" class="viewheading">About Myself</td></tr>
				<tr bgcolor="#FFFFFF">
				   <td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;text-align:justify;" align="center"><textarea name="aboutMyself" id="aboutMyself" rows=3 cols=68 class="smalltxt" style="padding:5px;text-align:justify;"><?=$varFrmAboutMe;?>
				   </textarea></td>
				</tr>
			</table><br>
			<!-- About myself Information ends here -->

			<!-- My Appearence starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader">
					<td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">My Appearence</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Complexion:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">
							<font face="MS Sans serif, verdana" size="1" color="#303030">
							<input type="radio" name="complexion" value="4" <?=$varBasicInfo["Complexion"]==4 ? "checked" : "";?> class="smalltxt"><span  class="smalltxt">Wheatish brown</span> &nbsp;
							<input type="radio" name="complexion" value="1" <?=$varBasicInfo["Complexion"]==1 ? "checked" : "";?> class="smalltxt"><span  class="smalltxt">Very fair</span> &nbsp;
							<input type="radio" name="complexion" value="3" <?=$varBasicInfo["Complexion"]==3 ? "checked" : "";?> class="smalltxt"><span  class="smalltxt">Wheatish</span> &nbsp;
							<input type="radio" name="complexion" value="2" <?=$varBasicInfo["Complexion"]==2 ? "checked" : "";?> class="smalltxt"><span  class="smalltxt">Fair</span> &nbsp;
							<input type="radio" name="complexion" value="5" <?=$varBasicInfo["Complexion"]==5 ? "checked" : "";?> class="smalltxt"><span  class="smalltxt">Dark</span> &nbsp;
							</font>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>


				<tr bgcolor="#FFFFFF">

					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Physical status:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">
						<font face="MS Sans serif, verdana" size="1" color="#303030">
						<input type="radio" name="physicalStatus" value="0" <?=$varBasicInfo["Physical_Status"]==0 ? "checked" : "";?>><span  class="smalltxt">Normal</span> &nbsp;
						<input type="radio" name="physicalStatus" value="1" <?=$varBasicInfo["Physical_Status"]==1 ? "checked" : "";?>><span  class="smalltxt">Physically challenged</span>
						</font>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>


				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
								<select class="combobox" name="heightFeet" size="1">
											<?
											if($varBasicInfo["Height_Unit"]=="feet-inches")
											{
												$objCommon->getValuesFromArray($arrHeightFeetList, "-- Feet/Inches --", "0", $varBasicInfo["Height"]);
											}
											else
											{
												$objCommon->getValuesFromArray($arrHeightFeetList, "-- Feet/Inches --", "0");
											}
											?>
										</select>&nbsp;&nbsp;or&nbsp;&nbsp;

										<select class="combobox" name="heightCms" size="1">
											<?
											if($varBasicInfo["Height_Unit"]=="cm")
											{
												$objCommon->getValuesFromArray($arrHeightCmsList, "-- Cms -- ", "0", $varBasicInfo["Height"]);
											}
											else
											{
												$objCommon->getValuesFromArray($arrHeightCmsList, "-- Cms -- ", "0");
											}
											?>
										</select>
					</td>
					</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Weight :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
										<select class="combobox" name="weightKgs" size="1">
											<?
												if($varBasicInfo["Weight_Unit"] == "kg")
												{
													print $objCommon->getValuesFromArray($arrWeightKgsList, "--Kgs-- ", "0", $varBasicInfo["Weight"]);
												}
												else
												{
													print $objCommon->getValuesFromArray($arrWeightKgsList, "--Kgs-- ", "0");
												}
											?>
										</select>&nbsp;&nbsp;or&nbsp;&nbsp;
										<select class="combobox" name="weightLbs" size="1">
											<?
												if($varBasicInfo["Weight_Unit"] == "lbs")
												{
													print $objCommon->getValuesFromArray($arrWeightLbsList, "--Lbs-- ", "0", $varBasicInfo["Weight"]);
												}
												else
												{
													print $objCommon->getValuesFromArray($arrWeightLbsList, "--Lbs-- ", "0");
												}
											?>
										</select>
				</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Body type :</span></td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<font face="MS Sans serif, verdana" size="1" color="#303030">
						<input type="radio" name="bodyType" value="4" <?=$varBasicInfo["Body_Type"]==4 ? "checked" : "";?>><span  class="smalltxt">Heavy </span>&nbsp;
						<input type="radio" name="bodyType" value="1" <?=$varBasicInfo["Body_Type"]==1 ? "checked" : "";?>><span  class="smalltxt">Average</span> &nbsp;
						<input type="radio" name="bodyType" value="3" <?=$varBasicInfo["Body_Type"]==3 ? "checked" : "";?>><span  class="smalltxt">Slim</span> &nbsp;
						<input type="radio" name="bodyType" value="2" <?=$varBasicInfo["Body_Type"]==2 ? "checked" : "";?>><span  class="smalltxt">Athletic </span>&nbsp;
						</font></td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Blood group :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;"
					colspan="3">
						<select name="bloodGroup" size="1" class="combobox">
						<?=$objCommon->getValuesFromArray($arrBloodGroupList, "- Select - ", "", $varBasicInfo["Blood_Group"]);?>
						</select>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr ><td  height="10" colspan="4"></td></tr>
			</table><br>
			<!-- My Appearence ends here -->

			<!-- My LifeStyle starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">My LifeStyle </td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Education :</td>
					<td valign="top" class="smalltxt" width="75%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<select class="combobox" name="educationCategory" size="1">
						<?=$objCommon->getValuesFromArray($arrEducationList, "- Select - ", "0", $varBasicInfo['Education_Category']);?>
						</select>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" width="25%" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education in detail :</td>
					<td valign="top" class="smalltxt" width="75%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<input type="text" class="smalltxt" maxLength="20" size="20" name="educationInDetail" value="<?=$varEducationDet;?>"></td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Employed in :</td>
					<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;"  colspan="3">
					<select class="combobox" name="employedIn" size="1">
						<?=$objCommon->getValuesFromArray($arrEmployedInList, "- Select - ", "0", $varBasicInfo['Employed_In']);?>
					</select>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;"  colspan="3">
					<select class="combobox" name="occupation" size="1">
						<?=$objCommon->getValuesFromArray($arrOccupationList, "- Select - ", "0", $varBasicInfo['Occupation']);?>
					</select>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation in detail :</td>
					<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<input type="text" class="smalltxt" maxLength="20" size="20" name="occupationInDetail" value="<?=$varOccupationDet;?>"></td>
				</tr>
				<?php //echo "<pre>"; print_r($varBasicInfo); echo "</pre>"; ?>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Annual income :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" name="annualIncomeCurrency" size="1">
						<?=$objCommon->getValuesFromArray($arrSelectCurrencyList, "- Select currency -", "", $varFrmAnnualIncomeCurrency);?>
						</select>&nbsp;
						<font class="textsmallbolda"><input type="text" size=15 maxlength=25 name="annualIncome" value="<?=$varFrmAnnualIncome;?>" class="smalltxt"><br>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<font color="#303030">
						<input type="radio" name="eatingHabits" value="1" <?=$varBasicInfo["Eating_Habits"]==1 ? "checked" : "";?>><span  class="smalltxt">Vegetarian</span> &nbsp;
						<input type="radio" name="eatingHabits" value="2" <?=$varBasicInfo["Eating_Habits"]==2 ? "checked" : "";?>><span  class="smalltxt">Non vegetarian</span> &nbsp;
						<input type="radio" name="eatingHabits" value="3" <?=$varBasicInfo["Eating_Habits"]==3 ? "checked" : "";?>><span  class="smalltxt">Eggetarian</span>
						</font>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;"
					colspan="3">
						<font color="#303030">
						<input type="radio" name="drink" value="1" <?=$varBasicInfo["Drink"]==1 ? "checked" : "";?>><span  class="smalltxt">Non-drinker</span> &nbsp;
						<input type="radio" name=drink value="3" <?=$varBasicInfo["Drink"]==3 ? "checked" : "";?>><span  class="smalltxt">Regular drinker</span> &nbsp;
						<input type="radio" name=drink value="2" <?=$varBasicInfo["Drink"]==2 ? "checked" : "";?>><span  class="smalltxt">Light / Social drinker</span> &nbsp;
						</font>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<font color="#303030">
						<input type="radio" name="smoke" value="1" <?=$varBasicInfo["Smoke"]==1 ? "checked" : "";?>><span  class="smalltxt">Non-smoker</span> &nbsp;
						<input type="radio" name="smoke" value="3" <?=$varBasicInfo["Smoke"]==3 ? "checked" : "";?>><span  class="smalltxt">Regular smoker</span> &nbsp;
						<input type="radio" name="smoke" value="2" <?=$varBasicInfo["Smoke"]==2 ? "checked" : "";?>><span  class="smalltxt">Light / Social smoker</span> &nbsp;
						</font>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr ><td  height="10" colspan="4"></td></tr>
			</table><br>
			<!-- My LifeStyle ends here -->

			<!-- Home Truths starts here -->

			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">Home Truths </td></tr>


				<tr bgcolor="#FFFFFF">
					<td colspan=4><div id="statecitydiv"><table><tr>
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing state :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
						<span id='locresidingstate' class='errortxt'></span>
						<?php
						if ($varArrayList !="")
						{
						?>
							<select class='combobox' name="residingState" size="1" <?if($varFrmCountry==98){ echo "onChange='cityrequest(this.value);'";}?>>
							<?=$objCommon->getValuesFromArray($varArrayList, "- Select - ", "0", $varStateId);?>
							</select>
						<?
						}//if
						else
						{
						?>
							<input type="text" name="residingState" size="20" maxlength="20" class="smalltxt" value="<?=$varState;?>">
						<?
						}//else
						?>
					</td>
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing city / district:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
						<span id='locresidingcity' class='errortxt'></span>
						<?php
						if ($varArrayList !="" && $varCoutryId ==98)
						{
						?>
							<select class='combobox' name="residingCity" id="residingCity" size="1">
								<?=$objCommon->getValuesFromArray(${$residingCityStateMappingList[$varStateId]}, "- Select - ", "0", $varUpdatedBasicInfo['Residing_City']!="" ? $varUpdatedBasicInfo['Residing_City'] : $varBasicInfo['Residing_District']);?>
							</select>
						<?
						}//if
						else
						{
						?>
							<input type="text" name="residingCity" id="residingCity" size="20" maxlength="20" class="smalltxt" value="<?=$varUpdatedBasicInfo['Residing_City']!="" ? $varUpdatedBasicInfo['Residing_City'] : $varBasicInfo['Residing_City'];?>">
						<?
						}//else
						?>
					</td>
					</tr></table></div></td>
				</tr>

				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<?if($varMotherTongueFeature==1) {
					$arrRetMotherTongue	= $objDomain->getMotherTongueOption();
					$varSizeMotherTongue= sizeof($arrRetMotherTongue);

					if($varSizeMotherTongue==1) {?>
						<input type="hidden" name="motherTongue" value="<?=key($arrRetMotherTongue)?>">
					<?} else {?>
						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"><?=$objDomain->getMotherTongueLabel()?>:</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
								<? if($varSizeMotherTongue>1){?>
								<select class="combobox" name="motherTongue" size="1">
								<?=$objCommon->getValuesFromArray($arrRetMotherTongue, "- Select - ", "0", $varFrmMotherTongueId);?>
								</select>
								<? } else { ?>
								<input type="text" name="motherTongueTxt" value="<?=$varFrmMotherTongueText?>" size="30">
								<? } ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
					<? }
				} ?>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact phone:</td>
					<td valign="middle" class="textsmallnormal" width="75%" colspan="3">
						<font class="smalltxt">Country code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Area code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile number</B></font><br>
						<input type="text" name="countryCode" size="14" maxlength="18" class="smalltxt" value="<?=$varCountryCode;?>">
						<input type="text" size="10" maxlength="18" class="smalltxt" name="areaCode" value="<?=$varAreaCode;?>">
						<input type="text" size="10" maxlength="18" class="smalltxt" name="phoneNumber" value="<?=$varPhoneCode;?>">&nbsp;&nbsp;&nbsp;&nbsp;or&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" size="10" maxlength="18" class="smalltxt" name="mobileNumber" value="<?=$varMobileCode;?>">
					</td>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr ><td  height="10" colspan="4"></td></tr>
			</table>
			<!--Home Truths ends here-->

			<!-- Family Details Start Here-->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">Family Details </td></tr>
 				<? if($varBasicInfo['Family_Set_Status']==0) { ?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">Family Details are not given by the member</td>
					</tr>
				<br>
				<? } else { ?>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Family values :</td>
					<td valign="top" class="smalltxt" width="55%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="4">
					<input type="radio" name="familyValue" value="1" <?=($varCheckFamilyValue==1 ? "checked" : "");?>>Orthodox
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="familyValue" value="2" <?=($varCheckFamilyValue==2 ? " checked" : "");?>>Traditional
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="familyValue" value="3" <?=($varCheckFamilyValue==3 ? "checked" : "");?>>Moderate
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="familyValue" value="4" <?=($varCheckFamilyValue==4 ? " checked" : "");?>>Liberal
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Family Type :</td>
					<td valign="top" class="smalltxt" width="75%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<input type="radio" name="familyType" value="1" <?=($varCheckFamilyType==1 ? "checked" : "");?>>Joint family
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="familyType" value="2" <?=($varCheckFamilyType==2 ? "checked" : "");?>>Nuclear family
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Family Status :</td>
					<td valign="top" class="smalltxt" width="75%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<input type="radio" name="familyStatus" value="1" <?=($varCheckFamilyStatus==1 ? "checked" : "");?>>Middle class
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="familyStatus" value="2" <?=($varCheckFamilyStatus==2 ? "checked" : "");?>>Upper middle class
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="familyStatus" value="4" <?=($varCheckFamilyStatus==4 ? "checked" : "");?>>Rich / Affluent
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Father's Occupation :</td>
					<td valign="top" class="smalltxt" width="75%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<input type="text" class="smalltxt" size="40" name="fatherOccupation" value="<?=$varFrmFatherOcc;?>">
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Mother's Occupation :</td>
					<td valign="top" class="smalltxt" width="75%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<input type="text" class="smalltxt" size="40" name="motherOccupation" value="<?=$varFrmMotherOcc;?>">
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Ancestral family origin :</td>
					<td valign="top" class="smalltxt" width="75%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<input type="text" class="smalltxt" size="40" name="ancestralOrigin" value="<?=$varFrmFamilyOrigin;?>">
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">No Of Brothers :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" name="brothers">
							<option value="0" <?=($varSelectBrothers==0 ? "selected" : "");?>>- Select -</option>
							<option value=1 <?=($varSelectBrothers==1 ? "selected" : "");?>>1</option>
							<option value=2 <?=($varSelectBrothers==2 ? "selected" : "");?>>2</option>
							<option value=3 <?=($varSelectBrothers==3 ? "selected" : "");?>>3</option>
							<option value=4 <?=($varSelectBrothers==4 ? "selected" : "");?>>4</option>
							<option value=5 <?=($varSelectBrothers==5 ? "selected" : "");?>>5</option>
							<option value=6 <?=($varSelectBrothers==6 ? "selected" : "");?>>5+</option>
						</select>
					</td>
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Brothers Married:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" name="marriedBrothers">
							<option value="0" <?=($varSelectBrothersMarried==0 ? "selected" : "");?>>- Select -</option>
							<option value=1 <?=($varSelectBrothersMarried==1 ? "selected" : "");?>>1</option>
							<option value=2 <?=($varSelectBrothersMarried==2 ? "selected" : "");?>>2</option>
							<option value=3 <?=($varSelectBrothersMarried==3 ? "selected" : "");?>>3</option>
							<option value=4 <?=($varSelectBrothersMarried==4 ? "selected" : "");?>>4</option>
							<option value=5 <?=($varSelectBrothersMarried==5 ? "selected" : "");?>>5</option>
							<option value=6 <?=($varSelectBrothersMarried==6 ? "selected" : "");?>>5+</option>
						</select> &nbsp;&nbsp;
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">No Of Sisters :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" name="sisters">
							<option value="0" <?=($varSelectSisters==0 ? "selected" : "");?>>- Select -</option>
							<option value=1 <?=($varSelectSisters==1 ? "selected" : "");?>>1</option>
							<option value=2 <?=($varSelectSisters==2 ? "selected" : "");?>>2</option>
							<option value=3 <?=($varSelectSisters==3 ? "selected" : "");?>>3</option>
							<option value=4 <?=($varSelectSisters==4 ? "selected" : "");?>>4</option>
							<option value=5 <?=($varSelectSisters==5 ? "selected" : "");?>>5</option>
							<option value=6 <?=($varSelectSisters==6 ? "selected" : "");?>>5+</option>
						</select>
					</td>
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Sisters Married:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" name="marriedSisters">
							<option value="0" <?=($varSelectSistersMarried==0 ? "selected" : "");?>>- Select -</option>
							<option value=1 <?=($varSelectSistersMarried==1 ? "selected" : "");?>>1</option>
							<option value=2 <?=($varSelectSistersMarried==2 ? "selected" : "");?>>2</option>
							<option value=3 <?=($varSelectSistersMarried==3 ? "selected" : "");?>>3</option>
							<option value=4 <?=($varSelectSistersMarried==4 ? "selected" : "");?>>4</option>
							<option value=5 <?=($varSelectSistersMarried==5 ? "selected" : "");?>>5</option>
							<option value=6 <?=($varSelectSistersMarried==6 ? "selected" : "");?>>5+</option>
						</select> &nbsp;&nbsp;
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">About My Family :</td>
					<td  colspan="3" valign="top" class="smalltxt"  style="padding-top:5px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">
						<textarea name="familyDescription"  id="familyDescription" rows=3 cols=38><?=$varFrmAboutMyFamily;?>
					</textarea></td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr ><td  height="10" colspan="4"></td></tr>
				<br>
				<? } ?>
			</table>
			<!-- Family Details End Here-->

			<!-- Interest Details Start Here-->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">Hobbies & Interests </td></tr>
				<? if($varBasicInfo['Interest_Set_Status']==0) { ?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">Interest Details are not given by the member</td>
					</tr>
				<br>
				<? } else { ?>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="100%" colspan='4'>
						<div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='hexpd' style='float:left; display:block;'><a href='javascript:divswitch("hobbies", "hclps", "hexpd");chkiframe("minus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
								<div id='hclps' style='float:left; display:none;'><a href='javascript:divswitch("hobbies", "hclps", "hexpd");chkiframe("plus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:;' onclick='divswitch("hobbies", "hclps", "hexpd");chkiframetext("hobbies",200);'>Hobbies</a></div>
						</div>
						<div id='hobbies' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:block;'>
							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("hobbies", "hclps", "hexpd");chkiframe("minus",200);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrHobbiesList as $hobbieval=>$hobbiename) {
									$ended=0;
									if($hobbieval!=0) {
										$varChecked = in_array($hobbieval,$arrHobbiesChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=hobbies[] value='".$hobbieval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$hobbiename."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>

							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='hobothertxt' onclick='javascript:othrtxt("hobothertxt", "hobbiesDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'>
									<input type=text name='hobbiesDesc' size='20' maxlength='40' class='inputtext' value='<?=$varFrmHobbiesOthers?>'>
								</div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='hobbiesDescspan'></span></div>
							</div>
						</div>

						<!-- Interests - Starts -->
						<div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='intclps' style='float:left; display:block;'><a href='javascript:divswitch("ints", "intclps", "intexpd");chkiframe("plus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='intexpd' style='float:left; display:none;'><a href='javascript:divswitch("ints", "intclps", "intexpd");chkiframe("minus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("ints", "intclps", "intexpd");chkiframetext("ints",200);'>Interests</a></div>
						</div>

						<div id='ints' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("ints", "intclps", "intexpd");chkiframe("minus",200);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrInterestList as $interestval=>$interestname) {
									$ended=0;
									if ($interestval!=0) {
										$varChecked = in_array($interestval,$arrInterestChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=interest[] value='".$interestval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$interestname."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>"; ?>


							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='intothertxt' onclick='javascript:othrtxt("intothertxt", "interestDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='interestDesc' size='20' maxlength='40' class='inputtext' value='<?=$varFrmInterestOthers?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='interestDescspan'></span></div>
							</div>
						</div>

						<!-- Favourite music - Starts -->
						<div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='fmcclps' style='float:left; display:block;'><a href='javascript:divswitch("fmc", "fmcclps", "fmcexpd");chkiframe("plus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='fmcexpd' style='float:left; display:none;'><a href='javascript:divswitch("fmc", "fmcclps", "fmcexpd");chkiframe("minus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("fmc", "fmcclps", "fmcexpd");chkiframetext("fmc",200);'>Favourite music</a></div>
						</div>

						<div id='fmc' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("fmc", "fmcclps", "fmcexpd");chkiframe("minus",200);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrMusicList as $musicval=>$musicname) {
									$ended=0;
									if ($musicval!=0) {
										$varChecked = in_array($musicval,$arrMusicChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=music[] value='".$musicval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$musicname."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>


							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='mscothertxt' onclick='javascript:othrtxt("mscothertxt", "musicDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='musicDesc' size='20' maxlength='40' class='inputtext' value='<?=$varFrmMusicOthers?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='musicDescspan'></span></div>
							</div>
						</div>

						<!-- Favourite reads - Starts -->
						<!-- <div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='frdclps' style='float:left; display:block;'><a href='javascript:divswitch("frd", "frdclps", "frdexpd");chkiframe("plus",190);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='frdexpd' style='float:left; display:none;'><a href='javascript:divswitch("frd", "frdclps", "frdexpd");chkiframe("minus",190);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("frd", "frdclps", "frdexpd");chkiframetext("frd",190);'>Favourite reads</a></div>
						</div>

						<div id='frd' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("frd", "frdclps", "frdexpd");chkiframe("minus",190);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrReadList as $readval=>$readname) {
									$ended=0;
									if ($readval!=0) {
										$varChecked = in_array($readval,$arrBooksChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=read[] value='".$readval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$readname."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>

							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='frdothertxt' onclick='javascript:othrtxt("frdothertxt", "readDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='readDesc' size='20' maxlength='40' disabled class='inputtext' value='<?=$varCheckHobbiesInfo['Books_Others']?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='readDescspan'></span></div>
							</div>
						</div>

						<!-- Preferred movies - Starts -->
						<!-- <div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='fmvclps' style='float:left; display:block;'><a href='javascript:divswitch("fmv", "fmvclps", "fmvexpd");chkiframe("plus",180);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='fmvexpd' style='float:left; display:none;'><a href='javascript:divswitch("fmv", "fmvclps", "fmvexpd");chkiframe("minus",180);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("fmv", "fmvclps", "fmvexpd");chkiframetext("fmv",180);'>Preferred movies</a></div>
						</div>

						<div id='fmv' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("fmv", "fmvclps", "fmvexpd");chkiframe("minus",180);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrMoviesList as $movieval=>$moviename) {
									$ended=0;
									if ($movieval!=0) {
										$varChecked = in_array($movieval,$arrMoviesChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=movie[] value='".$movieval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$moviename."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>

							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='mvothertxt' onclick='javascript:othrtxt("mvothertxt", "movieDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='movieDesc' size='20' maxlength='40' disabled class='inputtext' value='<?=$varCheckHobbiesInfo['Movies_Others']?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='movieDescspan'></span></div>
							</div>
						</div> -->

						<!-- Sports/Fitness activities - Starts -->
						<div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='sfaclps' style='float:left; display:block;'><a href='javascript:divswitch("sfa", "sfaclps", "sfaexpd");chkiframe("plus",210);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='sfaexpd' style='float:left; display:none;'><a href='javascript:divswitch("sfa", "sfaclps", "sfaexpd");chkiframe("minus",210);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("sfa", "sfaclps", "sfaexpd");chkiframetext("sfa",210);'>Sports/Fitness activities</a></div>
						</div>

						<div id='sfa' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("sfa", "sfaclps", "sfaexpd");chkiframe("minus",210);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrSportsList as $sportval=>$sportname) {
									$ended=0;
									if ($sportval!=0) {
										$varChecked = in_array($sportval,$arrSportsChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=sports[] value='".$sportval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$sportname."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>

							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='sftothertxt' onclick='javascript:othrtxt("sftothertxt", "sportsDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='sportsDesc' size='20' maxlength='40' class='inputtext' value='<?=$varFrmSportsOthers?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='sportsDescspan'></span></div>
							</div>
						</div>

						<!-- Favourite cuisine - Starts -->
						<div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='fcclps' style='float:left; display:block;'><a href='javascript:divswitch("fc", "fcclps", "fcexpd");chkiframe("plus",180);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='fcexpd' style='float:left; display:none;'><a href='javascript:divswitch("fc", "fcclps", "fcexpd");chkiframe("minus",180);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("fc", "fcclps", "fcexpd");chkiframetext("fc",180);'>Favourite cuisine</a></div>
						</div>

						<div id='fc' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("fc", "fcclps", "fcexpd");chkiframe("minus",180);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrFoodList as $foodval=>$foodname) {
									$ended=0;
									if ($foodval!=0) {
										$varChecked = in_array($foodval,$arrFoodChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=food[] value='".$foodval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$foodname."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>

							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='fcsnothertxt' onclick='javascript:othrtxt("fcsnothertxt", "foodDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='foodDesc' size='20' maxlength='40' class='inputtext' value='<?=$varFrmFoodOthers?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='foodDescspan'></span></div>
							</div>
						</div>

						<!-- Preferred dress style - Starts -->
						<!-- <div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='pdsclps' style='float:left; display:block;'><a href='javascript:divswitch("pds", "pdsclps", "pdsexpd");chkiframe("plus",100);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='pdsexpd' style='float:left; display:none;'><a href='javascript:divswitch("pds", "pdsclps", "pdsexpd");chkiframe("minus",100);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("pds", "pdsclps", "pdsexpd");chkiframetext("pds",100);'>Preferred dress style</a></div>
						</div>

						<div id='pds' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("pds", "pdsclps", "pdsexpd");chkiframe("minus",100);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrDressList as $dressval=>$dressname) {
									$ended=0;
									if ($dressval!=0) {
										$varChecked = in_array($dressval,$arrDressChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=dress[] value='".$dressval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$dressname."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>

							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='pdsothertxt' onclick='javascript:othrtxt("pdsothertxt", "dressDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='dressDesc' size='20' maxlength='40' disabled class='inputtext' value='<?=$varCheckHobbiesInfo['Dress_Style_Others']?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='dressDescspan'></span></div>
							</div>
						</div> -->

						<!-- Spoken languages - Starts -->
						<!-- <div class='fleft' style='width:475px; padding:5px;'>
							<div class='fleft' style='padding-top:2px;'>
								<div id='slangclps' style='float:left; display:block;'><a href='javascript:divswitch("slang", "slangclps", "slangexpd");chkiframe("plus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-plus-icon.gif' width='12' height='12'></a></div>
								<div id='slangexpd' style='float:left; display:none;'><a href='javascript:divswitch("slang", "slangclps", "slangexpd");chkiframe("minus",200);'><img src='<?=$confValues['IMGSURL']?>/hob-minus-icon.gif' width='12' height='12'></a></div>
							</div>
							<div class='fleft smalltxt boldtxt' style='padding-left:10px;'><a href='javascript:divswitch("slang", "slangclps", "slangexpd");chkiframetext("slang",200);'>Spoken languages</a></div>
						</div>

						<div id='slang' class='fleft' style='margin-bottom:5px; width:472px; border:1px solid #CCCCCC; padding:5px; display:none;'>

							<div class='fleft' style='width:472px;'>
								<div class='fright smalltxt'>
									<div id='useracticons'><div id='useracticonsimgs'><a href='javascript:divswitch("slang", "slangclps", "slangexpd");chkiframe("minus",200);'><div class='useracticonsimgs close pntr'></div></a></div></div>
								</div>
							</div>
							<? $i=0;
								foreach ($arrSpokenLangList as $spokenlangval=>$spokenlangname) {
									$ended=0;
									if ($spokenlangval!=0) {
										$varChecked = in_array($spokenlangval,$arrLanguageChecked)?' checked':'';
										if($i%3==0)
											echo "<div class='fleft' style='width:472px;'>";
											echo "<div class='fleft smalltxt'><input type=checkbox name=spokenLang[] value='".$spokenlangval."'
											".$varChecked."></div><div class='fleft smalltxt' style='width:135px; padding-top:2px;'>".$spokenlangname."</div>";
										if ($i%3==2) {
											echo "</div>";
											$ended = 1;
										}
										$i++;
									}
								}
								if($ended != 1)
									echo "</div>";
							?>

							<div class='fleft' style='width:472px; padding-top:10px;'>
								<div class='fleft smalltxt'><input type='checkbox' name='slangothertxt' onclick='javascript:othrtxt("slangothertxt", "spokenLangDesc");'></div>
								<div class='fleft smalltxt' style='width:40px; padding-top:2px;'>Others</div>
								<div class='fleft smalltxt'><input type=text name='spokenLangDesc' size='20' maxlength='40' disabled class='inputtext' value='<?=$varCheckHobbiesInfo['Languages_Others']?>'></div>
								<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='spokenLangDescspan'></span></div>
							</div>
						</div> -->
					</td>

				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } ?>
				<tr ><td  height="10" colspan="4"></td></tr>
			</table>
			<!-- Interest Details End Here-->

			<!-- Partner Preference Specifications starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" width="522">
				<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">My Partner Preference</td></tr>



			<? if ($varBasicInfo['Partner_Set_Status']==0) { ?>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">Partner Preference not set by the member</td>
				</tr>
			<br>
			<? } else { ?>
			<br>
			<!-- Start of Primary Preference -->
			<? if($varMotherTongueFeature==1) {
				$arrRetMaritalStatus	= $objDomain->getMaritalStatusOption();
				$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);
				if($varSizeMaritalStatus>1) { ?>
					<tr bgcolor="#FFFFFF">
						<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"><?=$objDomain->getMaritalStatusLabel()?> :</td>
						<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%">
							<input type="checkbox" name="lookingStatus" <?if ($varPartnerInfo['Looking_Status']==0) {echo "checked"; }?> value="">&nbsp;<label for="martial1">Any</label>
							<? $i=1; foreach($arrRetMaritalStatus as $key=>$value){
								$varChecked = (in_array($key,$varLookingStatus))?'checked':'';
								echo '<input type="checkbox" name="lookingStatus[]" value="'.$key.'"  id="lookingStatus'.$key.'" '.$varChecked.'>&nbsp;<label for="lookingStatus'.$key.'">'.$value.'</label>';
								if($i==3) {echo "<BR>";}
								$i++;
							}?>
						</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } else { ?>
					<input type="hidden" name="lookingStatus[]" value="<?=key($arrRetMaritalStatus)?>">
				<? }
			} ?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Age :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					From&nbsp;<input type="text" name="fromAge" maxLength="2" size="2" value="<?=$varPartnerInfo["Age_From"] ? $varPartnerInfo["Age_From"] : "23";?>" class="smalltxt">&nbsp; to &nbsp; <input type="text" name="toAge" maxLength="2" size="2" value="<?=$varPartnerInfo["Age_To"] ? $varPartnerInfo["Age_To"] : "30";?>" class="smalltxt">
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					From <select class="combobox" name="heightFrom">
					<?=$objCommon->getValuesFromArray($arrHeightFeetList, "4ft", "121.92", $varPartnerInfo["Height_From"], "update");?>
					</select> &nbsp;&nbsp; To
					<select class="combobox" name="heightTo">
					<?=$objCommon->getValuesFromArray($arrHeightFeetList,"7ft 11in","241.30", $varPartnerInfo["Height_To"], "update");?>
					</select>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Physical status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<input type="radio" value="0"name="partnerPhysicalStatus" <?=$varPartnerInfo["Physical_Status"]==0? "CHECKED" : "";?>>Normal &nbsp;
					<input type="radio" value="1" name="partnerPhysicalStatus" <?=$varPartnerInfo["Physical_Status"]==1? "CHECKED" : "";?>>Disabled &nbsp;
					<input type="radio" value="2" name="partnerPhysicalStatus" <?=$varPartnerInfo["Physical_Status"]==2? "CHECKED" : "";?>>Doesn't matter
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<?if($varMotherTongueFeature==1) {
				$arrRetMotherTongue	= $objDomain->getMotherTongueOption();
				$varSizeMotherTongue= sizeof($arrRetMotherTongue);
				if($varSizeMotherTongue>1) {
					$arrRetMotherTongue	= $objCommon->changingArray($arrRetMotherTongue);
				?>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getMotherTongueLabel()?>:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" multiple size="5" name="partnerMotherTongue[]">
						<?getMultipleValuesFromArray($arrRetMotherTongue, "Any", "0", $varPartnerInfo['Mother_Tongue'], "update");?>
						</select>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } else { ?>
					<input type="hidden" name="partnerMotherTongue[]" value="<?=key($arrRetMotherTongue)?>">
				<? }
			} ?>

			<!-- Start of Socio-Religious Preference -->
			<?if($varReligionFeature == 1) {
				$arrRetReligion	= $objDomain->getReligionOption();
				$varSizeReligion= sizeof($arrRetReligion);
				if($varSizeReligion>1) { ?>
					<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getReligionLabel()?> :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" multiple size="7" name="partnerReligion[]">
						<?=getMultipleValuesFromArray($arrRetReligion, "Any", "0", $varPartnerInfo['Religion'], "update");?>
						</select>
					</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } else { ?>
					<input type="hidden" name="partnerReligion[]" value="<?=key($arrRetReligion)?>">
				<? }
			} ?>

			<?if($varDenominationFeature == 1) {
				$arrRetDenomination	= $objDomain->getDenominationOption();
				$varSizeDenomination= sizeof($arrRetDenomination);
				if($varSizeDenomination>1) { ?>
					<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getDenominationLabel()?> :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" multiple size="7" name="partnerDenomination[]">
						<?=getMultipleValuesFromArray($arrRetDenomination, "Any", "0", $varPartnerInfo['Denomination'], "update");?>
						</select>
					</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } else { ?>
					<input type="hidden" name="partnerDenomination[]" value="<?=key($arrRetDenomination)?>">
				<? }
			} ?>

			<?if($varCasteFeature == 1) {
				$arrRetCaste	= $objDomain->getCasteOption();
				$varSizeCaste	= sizeof($arrRetCaste);
				if($varSizeCaste>1) {
					$arrRetCaste= $objCommon->changingArray($arrRetCaste); ?>
					<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getCasteLabel()?> :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" multiple size="7" name="partnerCasteDivision[]">
						<?=getMultipleValuesFromArray($arrRetCaste, "Any", "0", $varPartnerInfo['CasteId'], "update");?>
						</select>
					</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } else { ?>
					<input type="hidden" name="partnerCasteDivision[]" value="<?=key($arrRetCaste)?>">
				<? }
			} ?>

			<?if($varSubcasteFeature == 1) {
				$arrRetSubcaste	= $objDomain->getSubcasteOption();
				$varSizeSubcaste= sizeof($arrRetSubcaste);
				if($varSizeSubcaste>1) {
					$arrRetSubcaste	= $objCommon->changingArray($arrRetSubcaste);?>
					<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getSubcasteLabel()?> :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<select class="combobox" multiple size="7" name="partnerSubCasteDivision[]">
						<?=getMultipleValuesFromArray($arrRetSubcaste, "Any", "0", $varPartnerInfo['SubcasteId'], "update");?>
						</select>
					</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? } else { ?>
					<input type="hidden" name="partnerSubCasteDivision[]" value="<?=key($arrRetCaste)?>">
				<? }
			} ?>

			<? if($varDoshamFeature == 1) {
				$arrRetDosham	= $objDomain->getDoshamOption();
				unset($arrRetDosham['3']);
				$varSizeDosham	= sizeof($arrRetDosham);
				if($varSizeDosham>1) { ?>
					<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;"><?=$objDomain->getDoshamLabel()?> :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<input type="radio" name="partnerManglik" value="0" <?=$varPartnerInfo["Chevvai_Dosham"]==0 ? "CHECKED" : "";?>>Doesn't matter&nbsp;
						<? foreach($arrRetDosham as $key=>$value){
							$varChecked = ($key == $varPartnerInfo["Chevvai_Dosham"])?'checked':'';
							echo '<input type="radio" name="partnerManglik" value="'.$key.'"  id="partnermanglik'.$key.'" '.$varChecked.'>'.$value.'&nbsp;';
						}?>
					</td>
					</tr>
					<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<? }
			} ?>

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<input type="radio" name="partnerEatingHabits" value="0" <?=$varPartnerInfo["Eating_Habits"]==0 ? "CHECKED" : "";?>>Doesn't matter&nbsp;
				<input type="radio" name="partnerEatingHabits" value="1" <?=$varPartnerInfo["Eating_Habits"]==1 ? "CHECKED" : "";?>>Veg &nbsp;
				<input type="radio" name="partnerEatingHabits" value="2" <?=$varPartnerInfo["Eating_Habits"]==2 ? "CHECKED" : "";?>>Non vegetarian
				<input type="radio" name="partnerEatingHabits" value="3" <?=$varPartnerInfo["Eating_Habits"]==3 ? "CHECKED" : "";?>>Eggetarian
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<input type="radio" name="drinkingHabits" value="0" <?=$varPartnerInfo["Drinking_Habits"]==0 ? "CHECKED" : "";?>>Doesn't matter&nbsp;
				<input type="radio" name="drinkingHabits" value="1" <?=$varPartnerInfo["Drinking_Habits"]==1 ? "CHECKED" : "";?>>Non - drinker &nbsp;
				<input type="radio" name="drinkingHabits" value="2" <?=$varPartnerInfo["Drinking_Habits"]==2 ? "CHECKED" : "";?>>Light/ Social drinker<br>
				<input type="radio" name="drinkingHabits" value="3" <?=$varPartnerInfo["Drinking_Habits"]==3 ? "CHECKED" : "";?>>Regular drinker
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<input type="radio" name="smokingHabits" value="0" <?=$varPartnerInfo["Smoking_Habits"]==0 ? "CHECKED" : "";?>>Doesn't matter&nbsp;
				<input type="radio" name="smokingHabits" value="1" <?=$varPartnerInfo["Smoking_Habits"]==1 ? "CHECKED" : "";?>>Non - smoker &nbsp;
				<input type="radio" name="smokingHabits" value="2" <?=$varPartnerInfo["Smoking_Habits"]==2 ? "CHECKED" : "";?>>Light / Social smoker<br>
				<input type="radio" name="smokingHabits" value="3" <?=$varPartnerInfo["Smoking_Habits"]==3 ? "CHECKED" : "";?>>Regular smoker
			</td>
			</tr>

			<!-- End of Socio-Religious Preference -->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of Educational Preference -->

			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<select class="combobox" name="education[]" size="7" multiple>
					<?=getMultipleValuesFromArray($arrEducationList, "Any", "0", $varPartnerInfo['Education'], "update");?>
					</select>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- End of Educational Preference -->

			<!-- Start of Location Preference -->

			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Citizenship:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<select class="combobox" multiple size="7" name="partnerCitizenship[]">
					<?=getMultipleValuesFromArray($arrCountryList, "Any", "0", $varPartnerInfo['Citizenship'], "update");?>
					</select>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Country living in :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<select class="combobox" multiple size="7" name="countryLivingIn[]">
					<?=getMultipleValuesFromArray($arrCountryList, "Any", "0", $varPartnerInfo['Country'], "update");?>
					</select>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Resident status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<select class="combobox" multiple size="5" name="partnerResidentStatus[]">
					<?=getMultipleValuesFromArray($arrResidentStatusList, "Any", "0", $varPartnerInfo['Resident_Status'], "update");?>
					</select>
				</td>
			</tr>

			<!-- End of Location Preference -->

			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of About my partner -->

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">About My Partner :</td>
			<td valign="top" class="smalltxt"  style="padding-top:5px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">
				<textarea name="partnerDescription"  id="partnerDescription" rows=3 cols=38><?=$varFrmPartnerDesc;?>
			</textarea></td>
			</tr>
			<!-- End of About my partner -->

			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing state in India :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<select class="combobox" multiple size="5" name="residingIndia[]">
					<?=getMultipleValuesFromArray($arrResidingStateList, "Any", "0", $varPartnerInfo['Resident_India_State'], "update");?>
					</select>
				</td>
			</tr>

			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing state in USA :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<select class="combobox" multiple size="5" name="residingUSA[]">
					<?=getMultipleValuesFromArray($arrUSAStateList, "Any", "0", $varPartnerInfo['Resident_USA_State'], "update");?>
					</select>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<? }//else ?>
			<tr ><td  height="10" colspan="2"></td></tr>
			</table><br>

			<!-- Admin Comments Starts here -->
			<table border="0" cellpadding="0" cellspacing="0" align="center" class="formborder" width="522">
				<tr class="adminformheader">
					<td valign="top" colspan="4" style="padding-left:10px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">Admin comments </td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td width="10" valign="top" height="5" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Comments :</td>
					<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3" width="75%">
						<textarea rows="5" cols="40" name="adminComment"></textarea>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td width="10" valign="top" height="5" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Name of the person doing the change:</td>
					<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<input type="text" class="smalltxt" name="supportname">
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td width="10" valign="top" height="5" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Notify customer :</td>
					<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<input type="checkbox" checked id="customerNotify" name="customerNotify">
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="5"></td>
				</tr>
			</table>
			<!-- Admin Comments Ends here -->
		</td>
	</tr>
	<tr>
		<td valign=middle align="center" colspan="2" height="11"></td>
	</tr>
	<!-- Partner Preference Specifications ends here -->
	<tr>
		<td valign=middle align="center" colspan="2">
			<input type=submit  align="absmiddle" value="Submit" class="button">&nbsp;<input type="reset" value="Reset" align="absmiddle" class="button">
	</tr>
	<tr ><td  height="10" colspan="2"></td></tr>
</form>

</table>
<!-- 1st Table ends here-->
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
<script language="javascript">
function funProfileValidate()
{
	var frmLoginDetails=document.frmEditProfile;
	if(frmLoginDetails.country.value == "" || frmLoginDetails.country.value == "0")
	{
		alert("Please select Country");
		frmLoginDetails.country.focus();
		return false;
	}
	if(frmLoginDetails.residingState.value == "" || frmLoginDetails.residingState.value == "0")
	{
		alert("Please give state value");
		frmLoginDetails.residingState.focus();
		return false;
	}
	if(frmLoginDetails.residingCity.value == "" || frmLoginDetails.residingCity.value == "0")
	{
		alert("Please give city value");
		frmLoginDetails.residingCity.focus();
		return false;
	}
	if(frmLoginDetails.adminComment.value == "")
	{
		alert("Please enter Comment");
		frmLoginDetails.adminComment.focus();
		return false;
	}
	if(frmLoginDetails.supportname.value == "")
	{
		alert("Please enter support name");
		frmLoginDetails.supportname.focus();
		return false;
	}
return (true);
}

function countryChk() {
	var frmProfile = document.frmEditProfile;
	if ( parseInt( frmProfile.country.options[frmProfile.country.selectedIndex].value ) == 0 || frmProfile.country.options[frmProfile.country.selectedIndex].value=="" ) {
		$('loccountry').innerHTML="Please select the country of living of the prospect";
		return;
	} else {
		$('loccountry').innerHTML="";
		modifystate(frmProfile.country.value);
	}
}

var state_request = false;
function modifystate(cval) {
	if(cval>0 && cval!=null) {
		state_request = AjaxCall();
		var url="getstates.php?countryid="+cval;
		state_request.onreadystatechange = processResponseState;
		state_request.open('GET', url, true);
		state_request.send(null);
	} else {}
}

function processResponseState() {
	if (state_request.readyState == 4) {
		if (state_request.status == 200) {
			$("statecitydiv").innerHTML = '';
			$("statecitydiv").innerHTML = state_request.responseText;
		}
	}
}

var ccode_request = false;
function cityrequest(cvalue,cntryval) {
	if(cvalue>0 && cvalue!=null) {
		ccode_request = AjaxCall();
		var url="../admin/getcities.php?countryid="+cntryval+"&stateid="+cvalue; //Mano
		ccode_request.onreadystatechange = processResponsenew;
		ccode_request.open('GET', url, true);
		ccode_request.send(null);
	} else {
		emptyCitySel();
	}
}

function emptyCitySel() {
	var citysel = $('residingCity');
	if (citysel.length>0) {
		for(i=citysel.length;i>=0;i--) {
			citysel.remove(i);
		}
	}
	var y=document.createElement('option');
	y.value='0';
	y.text='-Select-';
	try {
		citysel.add(y,null); // standards compliant
	} catch(ex) {
		citysel.add(y); // IE only
	}
}

function processResponsenew() {
	if (ccode_request.readyState == 4) {
		if (ccode_request.status == 200) {
			var citysel = $('residingCity');
			var listValues = ccode_request.responseText;
			listValueArray = listValues.split('~');
			var y;
			for(i=0;i<listValueArray.length;i=i+2) {
			  y=document.createElement('option');
			  y.value=listValueArray[i];
			  y.text=listValueArray[i+1];
			  try {
				citysel.add(y,null); // standards compliant
			  } catch(ex) {
				citysel.add(y); // IE only
			  }
			}
		}
	}
	else
	{
		emptyCitySel();
	}
}
</script>
</body>
</html>
<? } $objMailManager->dbClose(); ?>