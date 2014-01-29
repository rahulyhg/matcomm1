<?php
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessGender 	= $varGetCookieInfo["GENDER"];

//OBJECT DECLARTION
$objRegisterSlave	= new clsRegister;
$objRegisterMaster	= new MemcacheDB;

$varWeightUnit		= 'kg';
$varFromPage		= 1;
$varCurrentDate		= date('Y-m-d H:i:s');
$varCompleteProfile	= 1;

if ($_POST['intRegister']=='yes') {

	//CONNECT DATABASE
	$objRegisterMaster->dbConnect('M',$varDbInfo['DATABASE']);

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;
    
	$varUseRaasi		= $_REQUEST['useRaasi'];
	$varUseDosham		= $_REQUEST['useDosham'];
	$varUseHoroscope	= $_REQUEST['useHoroscope'];
	$varUseMotherTongue	= $_REQUEST['useMotherTongue'];
	$varUseReligion		= $_REQUEST['useReligion'];
	$varUseDenomination	= $_REQUEST['useDenomination'];
	$varUseCaste		= $_REQUEST['useCaste'];
	$varSizeCaste		= $_REQUEST['castesize'];
	$varUseSubcaste		= $_REQUEST['useSubcaste'];
	$varSizeSubcaste	= $_REQUEST['subcastesize'];

	$varWeightKgs		= $_REQUEST['weightKgs'];
	$varBodyType		= $_REQUEST['bodyType'];
	$varComplexion		= $_REQUEST['complexion'];
	$varBloodGroup		= $_REQUEST['bloodGroup'];
	$varRaasi			= $_REQUEST['raasi'];
	$varHoroscopeMatch	= $_REQUEST['horoscopeMatch'];
	$varChevvaiDosham	= $_REQUEST['chevvaiDosham'];
	$varEducationDetail	= trim($_REQUEST['educationDetail']);
	$varOccupationDetail= trim($_REQUEST['occupationDetail']);
	$varEatingHabits	= $_REQUEST['eatingHabits'];
	$varSmokeHabits		= $_REQUEST['smokingHabits'];
	$varDrinkHabits		= $_REQUEST['drinkingHabits'];

	$varSpokenLanguages	= ($_REQUEST['spokenLanguages']!='')?join('~',$_REQUEST['spokenLanguages']):'';
	$varInterests		= ($_REQUEST['interests']!='')?join('~',$_REQUEST['interests']):'';
	$varHobbies			= ($_REQUEST['hobbies']!='')?join('~',$_REQUEST['hobbies']):'';
	$varFavourites		= ($_REQUEST['favourites']!='')?join('~',$_REQUEST['favourites']):'';
	$varSports			= ($_REQUEST['sports']!='')?join('~',$_REQUEST['sports']):'';
	$varFood			= ($_REQUEST['food']!='')?join('~',$_REQUEST['food']):'';

	$varNoOfBrothers	= $_REQUEST['numOfBrothers'];
	$varBrothersMarried	= $_REQUEST['brothersMarried'];
	$varNoOfSisters		= $_REQUEST['numOfSisters'];
	$varSistersMarried	= $_REQUEST['sistersMarried'];
	$varEditedFatherOcc	= trim($_REQUEST['fatherOccupation']);
	$varEditedMotherOcc	= trim($_REQUEST['motherOccupation']);
	$varEditedFamilyOri	= trim($_REQUEST['familyOrgin']);
	$varEditedAbtFamily	= trim($_REQUEST['aboutFamily']);

	/*$varFromAge					= $_REQUEST['fromAge'];
	$varToAge					= $_REQUEST['toAge'];
	$varHeightFrom				= $_REQUEST['heightFrom'];
	$varHeightTo				= $_REQUEST['heightTo'];
	$varPartnerLookingStatus	= ($_REQUEST['lookingStatus']!='')?join('~',$_REQUEST['lookingStatus']):'';
	$varPartnerMotherTongue		= ($_REQUEST['motherTongue']!='')?join('~',$_REQUEST['motherTongue']):'';
	$varPartnerReligion			= ($_REQUEST['partnerReligion']!='')?join('~',$_REQUEST['partnerReligion']):'';
	$varPartnerDenomination		= ($_REQUEST['partnerDenomination']!='')?join('~',$_REQUEST['partnerDenomination']):'';
	$varPartnerCaste			= ($_REQUEST['partnerCaste']!='')?join('~',$_REQUEST['partnerCaste']):'';
	$varPartnerSubcaste			= ($_REQUEST['partnerSubcaste']!='')?join('~',$_REQUEST['partnerSubcaste']):'';
	$varPartnerCountry			= ($_REQUEST['countryLivingIn']!='')?join('~',$_REQUEST['countryLivingIn']):'';
	$varResidingIndia			= ($_REQUEST['residingIndia']!='')?join('~',$_REQUEST['residingIndia']):'';
	$varResidingUSA				= ($_REQUEST['residingUSA']!='')?join('~',$_REQUEST['residingUSA']):'';
	$varResidentStatus			= ($_REQUEST['residentStatus']!='')?join('~',$_REQUEST['residentStatus']):'';
	$varPartnerFoodChoice		= $_REQUEST['partnerFoodChoice'];
	$varEducation				= ($_REQUEST['education']!='')?join('~',$_REQUEST['education']):'';*/

	//Update Member basic details
	$varCondition	= " MatriId=".$objRegisterMaster->doEscapeString($sessMatriId,$objRegisterMaster);
	$varFields = array('Weight','Weight_Unit','Body_Type','Complexion','Blood_Group','Raasi','Horoscope_Match','Chevvai_Dosham','Eating_Habits','Smoke','Drink','Date_Updated','Time_Posted');
	$varFieldsValues = array($objRegisterMaster->doEscapeString($varWeightKgs,$objRegisterMaster),$objRegisterMaster->doEscapeString($varWeightUnit,$objRegisterMaster),$objRegisterMaster->doEscapeString($varBodyType,$objRegisterMaster),$objRegisterMaster->doEscapeString($varComplexion,$objRegisterMaster),$objRegisterMaster->doEscapeString($varBloodGroup,$objRegisterMaster),$objRegisterMaster->doEscapeString($varRaasi,$objRegisterMaster),$objRegisterMaster->doEscapeString($varHoroscopeMatch,$objRegisterMaster),$objRegisterMaster->doEscapeString($varChevvaiDosham,$objRegisterMaster),$objRegisterMaster->doEscapeString($varEatingHabits,$objRegisterMaster),$objRegisterMaster->doEscapeString($varSmokeHabits,$objRegisterMaster),$objRegisterMaster->doEscapeString($varDrinkHabits,$objRegisterMaster),"'".$varCurrentDate."'","'".$varCurrentDate."'");
	$objRegisterMaster->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);


	//Update Member hobbies details
	if($varSpokenLanguages != '' || $varInterests != '' || $varHobbies != '' || $varFavourites != '' || $varSports != '' || $varFood != '') {
		$argFields 			= array('MatriId');
		$argFieldsValues	= array($objRegisterMaster->doEscapeString($sessMatriId,$objRegisterMaster));
		$varInsertedId		= $objRegisterMaster->insertIgnore($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues);

		$varFields			= array('Hobbies_Selected','Interests_Selected','Music_Selected','Sports_Selected','Food_Selected','Languages_Selected','Date_Updated');
		$varFieldsValues	= array($objRegisterMaster->doEscapeString($varHobbies,$objRegisterMaster),$objRegisterMaster->doEscapeString($varInterests,$objRegisterMaster),$objRegisterMaster->doEscapeString($varFavourites,$objRegisterMaster),$objRegisterMaster->doEscapeString($varSports,$objRegisterMaster),$objRegisterMaster->doEscapeString($varFood,$objRegisterMaster),$objRegisterMaster->doEscapeString($varSpokenLanguages,$objRegisterMaster),"'".$varCurrentDate."'");
		$objRegisterMaster->update($varTable['MEMBERHOBBIESINFO'],$varFields,$varFieldsValues,$varCondition);

		$varFields 			= array('Interest_Set_Status');
		$varFieldsValues	= array(1);
		$objRegisterMaster->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);

	}


	//Update Member family details
	if($varNoOfBrothers!='' || $varBrothersMarried != '' || $varNoOfSisters != '' || $varSistersMarried != '') {
		$argFields 			= array('MatriId');
		$argFieldsValues	= array($objRegisterMaster->doEscapeString($sessMatriId,$objRegisterMaster));
		$varInsertedId		= $objRegisterMaster->insertIgnore($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues);

		$varFields = array('Brothers','Brothers_Married','Sisters','Sisters_Married','Date_Updated');
		$varFieldsValues = array($objRegisterMaster->doEscapeString($varNoOfBrothers,$objRegisterMaster),$objRegisterMaster->doEscapeString($varBrothersMarried,$objRegisterMaster),$objRegisterMaster->doEscapeString($varNoOfSisters,$objRegisterMaster),$objRegisterMaster->doEscapeString($varSistersMarried,$objRegisterMaster),"'".$varCurrentDate."'");
		$objRegisterMaster->update($varTable['MEMBERFAMILYINFO'],$varFields,$varFieldsValues,$varCondition);

		$varFields 			= array('Family_Set_Status');
		$varFieldsValues	= array(1);
		$varCondition		= "MatriId = ".$objRegisterMaster->doEscapeString($sessMatriId,$objRegisterMaster);
		$objRegisterMaster->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);
	}

	if($sessPublish == 0 || $sessPublish == 4) {
		$argFields 			= array('Father_Occupation','Mother_Occupation','Family_Origin','About_Family');
		$argFieldsValues	= array($objRegisterMaster->doEscapeString($varEditedFatherOcc,$objRegisterMaster),$objRegisterMaster->doEscapeString($varEditedMotherOcc,$objRegisterMaster),$objRegisterMaster->doEscapeString($varEditedFamilyOri,$objRegisterMaster),$objRegisterMaster->doEscapeString($varEditedAbtFamily,$objRegisterMaster));
		$varUpdateId		= $objRegisterMaster->update($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues,$varCondition);

		$argFields 			= array('Education_Detail','Occupation_Detail');
		$argFieldsValues	= array($objRegisterMaster->doEscapeString($varEducationDetail,$objRegisterMaster),$objRegisterMaster->doEscapeString($varOccupationDetail,$objRegisterMaster));
		$varUpdateId		= $objRegisterMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$varCondition,$varOwnProfileMCKey);

		if($sessPublish == 4) {
			$argFields 			= array('Publish');
			$argFieldsValues	= array(0);
			$varUpdateId		= $objRegisterMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$varCondition,$varOwnProfileMCKey);
		}
	} else {
		if(trim($_REQUEST['oldEduDet']) != $varEducationDetail || trim($_REQUEST['oldOccDet']) != $varOccupationDetail || trim($_REQUEST['oldFatOcc']) != $varEditedFatherOcc || trim($_REQUEST['oldMotOcc']) != $varEditedMotherOcc || trim($_REQUEST['oldFamOri']) != $varEditedFamilyOri || trim($_REQUEST['OldAboutFamily']) != $varEditedAbtFamily) {

			$argFields 			= array('MatriId');
			$argFieldsValues	= array($objRegisterMaster->doEscapeString($sessMatriId,$objRegisterMaster));
			$varInsertedId		= $objRegisterMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

			$argFields 			= array('Date_Updated');
			$argFieldsValues	= array("'".$varCurrentDate."'");

			if(trim($_REQUEST['oldEduDet']) != $varEducationDetail) {
				array_push($argFields,'Education_Detail');
				array_push($argFieldsValues,$objRegisterMaster->doEscapeString($varEducationDetail,$objRegisterMaster));
			}

			if(trim($_REQUEST['oldOccDet']) != $varOccupationDetail) {
				array_push($argFields,'Occupation_Detail');
				array_push($argFieldsValues,$objRegisterMaster->doEscapeString($varOccupationDetail,$objRegisterMaster));
			}

			if(trim($_REQUEST['oldFatOcc']) != $varEditedFatherOcc) {
				array_push($argFields,'Father_Occupation');
				array_push($argFieldsValues,$objRegisterMaster->doEscapeString($varEditedFatherOcc,$objRegisterMaster));
			}

			if(trim($_REQUEST['oldMotOcc']) != $varEditedMotherOcc) {
				array_push($argFields,'Mother_Occupation');
				array_push($argFieldsValues,$objRegisterMaster->doEscapeString($varEditedMotherOcc,$objRegisterMaster));
			}

			if(trim($_REQUEST['oldFamOri']) != $varEditedFamilyOri) {
				array_push($argFields,'Family_Origin');
				array_push($argFieldsValues,$objRegisterMaster->doEscapeString($varEditedFamilyOri,$objRegisterMaster));
			}

			if(trim($_REQUEST['OldAboutFamily']) != $varEditedAbtFamily) {
				array_push($argFields,'About_Family');
				array_push($argFieldsValues,$objRegisterMaster->doEscapeString($varEditedAbtFamily,$objRegisterMaster));
			}

			$varUpdateId		= $objRegisterMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$varCondition);

			$argFields 			= array('Pending_Modify_Validation');
			$argFieldsValues	= array(1);
			$varUpdateId		= $objRegisterMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$varCondition,$varOwnProfileMCKey);
		}
	}

	//Update Member partner details
	/*$varFields		 = array('Age_From','Age_To','Looking_Status','Height_From','Height_To','Mother_Tongue','Religion','Denomination','CasteId','SubcasteId','Chevvai_Dosham','Eating_Habits','Education','Country','Resident_India_State','Resident_USA_State','Resident_Status','Date_Updated');
	$varFieldsValues = array("'".$varFromAge."'","'".$varToAge."'","'".$varPartnerLookingStatus."'","'".$varHeightFrom."'","'".$varHeightTo."'","'".$varPartnerMotherTongue."'","'".$varPartnerReligion."'","'".$varPartnerDenomination."'","'".$varPartnerCaste."'","'".$varPartnerSubcaste."'","'".$_REQUEST['partnerDhosam']."'","'".$varPartnerFoodChoice."'","'".$varEducation."'","'".$varPartnerCountry."'","'".$varResidingIndia."'","'".$varResidingUSA."'","'".$varResidentStatus."'","'".$varCurrentDate."'");

	$objRegisterMaster->update($varTable['MEMBERPARTNERINFO'],$varFields,$varFieldsValues,$varCondition);*/

	$varFields 			= array('Partner_Set_Status');
	$varFieldsValues	= array(1);
	$varCondition		= "MatriId = ".$objRegisterMaster->doEscapeString($sessMatriId,$objRegisterMaster);
	$objRegisterMaster->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);

    //$varPartnerLookingStatus!='' && &&  $varPartnerCountry!='' && ($varResidingIndia!='' || $varResidingUSA!='') && $varPartnerFoodChoice!='' && $varEducation!='' && $varFromAge!=0 && $varHeightFrom!=0
	if($varWeightKgs!=0 && $varBodyType!=0 && $varComplexion!=0 && $varBloodGroup!=0 && $varSpokenLanguages!='' && $varEducationDetail!='' && $varOccupationDetail!='' && $varEatingHabits!=0 && $varSmokeHabits!=0 && $varDrinkHabits!=0 && $varInterests!='' && $varHobbies!='' && $varFavourites!='' && $varSports!='' && $varFood!='' && $varEditedFamilyOri!='' && $varEditedMotherOcc!='' && $varEditedFatherOcc!='' && $varNoOfBrothers!=0 && $varNoOfSisters!=0 && $varEditedAbtFamily!='' ) {
		/*if($varUseRaasi==1 && $varRaasi==0){ 
			$varCompleteProfile = 0;
		}*/
		if($varCompleteProfile == 1 && $varUseHoroscope==1 && $varHoroscopeMatch==0){
			$varCompleteProfile = 0;
		}
		if($varCompleteProfile == 1 && $varUseDosham==1 && $varChevvaiDosham==0){
			$varCompleteProfile = 0;
		}
		/*if($varCompleteProfile == 1 && $varUseMotherTongue==1 && $varPartnerMotherTongue==''){
			$varCompleteProfile = 0;
		}
		if($varCompleteProfile == 1 && $varUseReligion==1 && $varPartnerReligion==''){
			$varCompleteProfile = 0;
		}
		if($varCompleteProfile == 1 && $varUseDenomination==1 && $varPartnerDenomination==''){
			$varCompleteProfile = 0;
		}
		if($varCompleteProfile == 1 && $varUseCaste==1 && $varSizeCaste>1 && $varPartnerCaste==''){
			$varCompleteProfile = 0;
		}
		if($varCompleteProfile == 1 && $varUseSubcaste==1 && $varSizeSubcaste>1 && $varPartnerSubcaste==''){
			$varCompleteProfile = 0;
		}*/
	} else {
		$varCompleteProfile = 0;
	}

	if($varCompleteProfile==1) {
		$varFields 			= array('Complete_Now');
		$varFieldsValues	= array(1);
		$varCondition		= "MatriId = ".$objRegisterMaster->doEscapeString($sessMatriId,$objRegisterMaster);
		$objRegisterMaster->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);
	}

	$varPartnerDetails	= $varFromAge.'~'.$varToAge.'^|'.$varHeightFrom.'~'.$varHeightTo.'^|'.$varPartnerLookingStatus.'^|'.$varPhysicalStatus.'^|'.$varPartnerMotherTongue.'^|'.$varPartnerReligion.'^|'.$varPartnerCaste.'^|'.$varPartnerFoodChoice.'^|'.$varEducation.'^|'.$varCitizenship.'^|'.$varPartnerCountry.'^|'.$varResidingIndia.'^|'.$varResidingUSA.'^|'.$varResidentStatus.'^|'.$varPartnerSmokeChoice.'^|'.$varPartnerDrinkChoice.'^|'.$varPartnerSubcaste.'^|'.$varPartnerDenomination;
	setrawcookie("partnerInfo","$varPartnerDetails", "0", "/",$confValues['DOMAINNAME']);
	?>
	<center>
	<div class="padt10">
		<div class='fleft' style='width:490px;'>
			Your information has been modified successfully.
			<br><br><font class='errortxt'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></font>
		</div>
	</div>
	</center>
	<?
} else {

	//CONNECT DATABASE
	$objRegisterSlave->dbConnect('S',$varDbInfo['DATABASE']);

	//get member basic detail
	$argCondition				= "WHERE MatriId=".$objRegisterSlave->doEscapeString($sessMatriId,$objRegisterSlave);
	$argFields 					= array('Weight','Weight_Unit','Body_Type','Complexion','Blood_Group','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Eating_Habits','Smoke','Drink','Complete_Now');
	$varMemberInfoBasicDtl		= $objRegisterSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varMemberInfoBasicDtlRes	= mysql_fetch_assoc($varMemberInfoBasicDtl);

	$varAbsWeight = str_replace(".00","",$varMemberInfoBasicDtlRes['Weight']);
	if($varAbsWeight!=0) {
		if($varMemberInfoBasicDtlRes['Weight_Unit'] == 'kg') {
			$varWeightKgs	= round($varMemberInfoBasicDtlRes['Weight']);
		}
	}
	$varCompleteNow		= $varMemberInfoBasicDtlRes['Complete_Now'];
	$varBodyType		= $varMemberInfoBasicDtlRes['Body_Type'];
	$varComplexion		= $varMemberInfoBasicDtlRes['Complexion'];
	$varBloodGroup		= $varMemberInfoBasicDtlRes['Blood_Group'];
	$varRaasi			= $varMemberInfoBasicDtlRes['Raasi'];
	$varHoroscopeMatch	= $varMemberInfoBasicDtlRes['Horoscope_Match'];
	$varChevvaiDosham	= $varMemberInfoBasicDtlRes['Chevvai_Dosham'];
	$varEducationDetail	= $varMemberInfoBasicDtlRes['Education_Detail'];
	$varOccupationDetail= $varMemberInfoBasicDtlRes['Occupation_Detail'];
	$varEatingHabits	= $varMemberInfoBasicDtlRes['Eating_Habits'];
	$varSmokeHabits		= $varMemberInfoBasicDtlRes['Smoke'];
	$varDrinkHabits		= $varMemberInfoBasicDtlRes['Drink'];

	//get member habits detail
	$argFields 					= array('Languages_Selected','Interests_Selected','Hobbies_Selected','Music_Selected','Sports_Selected','Food_Selected');
	$varMemberHobbiesInfoDtl	= $objRegisterSlave->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
	$varMemberHobbiesInfoDtlRes	= mysql_fetch_assoc($varMemberHobbiesInfoDtl);

	$varLanguagesSelected	= $varMemberHobbiesInfoDtlRes['Languages_Selected'];
	$varInterestsSelected	= $varMemberHobbiesInfoDtlRes['Interests_Selected'];
	$varHobbiesSelected		= $varMemberHobbiesInfoDtlRes['Hobbies_Selected'];
	$varMusicSelected		= $varMemberHobbiesInfoDtlRes['Music_Selected'];
	$varSportsSelected		= $varMemberHobbiesInfoDtlRes['Sports_Selected'];
	$varFoodSelected		= $varMemberHobbiesInfoDtlRes['Food_Selected'];

	//get member family detail
	$argFields 					= array('Family_Origin','Mother_Occupation','Father_Occupation','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family');
	$varMemberFamilyInfoDtl		= $objRegisterSlave->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
	$varMemberFamilyInfoDtlRes	= mysql_fetch_assoc($varMemberFamilyInfoDtl);

	$varFamilyOrigin	= $varMemberFamilyInfoDtlRes['Family_Origin'];
	$varMotherOccupation= $varMemberFamilyInfoDtlRes['Mother_Occupation'];
	$varFatherOccupation= $varMemberFamilyInfoDtlRes['Father_Occupation'];
	$varBrothers		= $varMemberFamilyInfoDtlRes['Brothers'];
	$varBrothersMarried	= $varMemberFamilyInfoDtlRes['Brothers_Married'];
	$varSisters			= $varMemberFamilyInfoDtlRes['Sisters'];
	$varSistersMarried	= $varMemberFamilyInfoDtlRes['Sisters_Married'];
	$varAboutFamily		= $varMemberFamilyInfoDtlRes['About_Family'];

	//get member partner detail
	$argFields 					= array('Age_From','Age_To','Height_From','Height_To','Looking_Status','Mother_Tongue','Religion','Denomination','CasteId','SubcasteId','Chevvai_Dosham','Eating_Habits','Education','Country','Resident_India_State','Resident_USA_State','Resident_Status');
	$varMemberPartnerInfoDtl	= $objRegisterSlave->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
	$varMemberPartnerInfoDtlRes	= mysql_fetch_assoc($varMemberPartnerInfoDtl);

	$varPartnerAgeFrom				= $varMemberPartnerInfoDtlRes['Age_From'];
	$varPartnerAgeTo				= $varMemberPartnerInfoDtlRes['Age_To'];
	$varPartnerHeightFrom			= $varMemberPartnerInfoDtlRes['Height_From'];
	$varPartnerHeightTo				= $varMemberPartnerInfoDtlRes['Height_To'];
	$varPartnerLookingStatus		= $varMemberPartnerInfoDtlRes['Looking_Status'];
	$varPartnerMotherTongue			= $varMemberPartnerInfoDtlRes['Mother_Tongue'];
	$varPartnerReligion				= $varMemberPartnerInfoDtlRes['Religion'];
	$varPartnerDenomination			= $varMemberPartnerInfoDtlRes['Denomination'];
	$varPartnerCasteId				= $varMemberPartnerInfoDtlRes['CasteId'];
	$varPartnerSubcasteId			= $varMemberPartnerInfoDtlRes['SubcasteId'];
	$varPartnerChevvaiDosham		= $varMemberPartnerInfoDtlRes['Chevvai_Dosham'];
	$varPartnerEatingHabits			= $varMemberPartnerInfoDtlRes['Eating_Habits'];
	$varPartnerEducation			= $varMemberPartnerInfoDtlRes['Education'];
	$varPartnerCountry				= $varMemberPartnerInfoDtlRes['Country'];
	$varPartnerResidentIndiaState	= $varMemberPartnerInfoDtlRes['Resident_India_State'];
	$varPartnerResidentUSAState		= $varMemberPartnerInfoDtlRes['Resident_USA_State'];
	$varPartnerResidentStatus		= $varMemberPartnerInfoDtlRes['Resident_Status'];

	/*echo "<pre>";
	print_r($varMemberInfoBasicDtlRes);
	echo "<BR>";
	print_r($varMemberHobbiesInfoDtlRes);
	echo "<BR>";
	print_r($varMemberFamilyInfoDtlRes);
	echo "<BR>";
	print_r($varMemberPartnerInfoDtlRes);*/
	?>
    <script language="javascript" src="<?=$confValues["JSPATH"];?>/common.js"></script>
    <?
	include_once($varRootBasePath."/www/register/intermediateregister.php");
}
?>