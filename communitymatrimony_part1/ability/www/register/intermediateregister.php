<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-07-18
# End Date		: 2008-07-18
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsRegister.php');

//OBJECT DECLARTION
$objRegister	= new clsRegister;
$objCommon		= new clsCommon;
$objDomainInfo	= new domainInfo;

$varUseReligion		= $objDomainInfo->useReligion();
$varUseDenomination	= $objDomainInfo->useDenomination();
$varUseCaste		= $objDomainInfo->useCaste();
$varUseSubcaste		= $objDomainInfo->useSubcaste();
$varIsCasteMandatory	= $objDomainInfo->isCasteMandatory();
$varIsSubcasteMandatory	= $objDomainInfo->isSubcasteMandatory();
$varUseMotherTongue	= $objDomainInfo->useMotherTongue();
$varMaleStartAge	= $objDomainInfo->getMStartAge();
$varFemaleStartAge	= $objDomainInfo->getFStartAge();
$varUseMaritalStatus= $objDomainInfo->useMaritalStatus();
$varUseRaasi		= $objDomainInfo->useRaasi();
$varUseHoroscope	= $objDomainInfo->useHoroscope();
$varUseDosham		= $objDomainInfo->useDosham();

//CONNECT DATABASE
$objRegister->dbConnect('M',$varDbInfo['DATABASE']);

//FOR INTER MEDIATE PAGE
$varCategory	= trim($_REQUEST['category']);
$varReqTemplate	= trim($_REQUEST['req']);
$varOppId		= trim($_REQUEST['oppositeId']);

//VARIABLE DECLARATION
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPPAge		= $varGetCookieInfo['PPAGE'];
$sessPPHeight	= $varGetCookieInfo['PPHEIGHT'];
$sessGender     = $varGetCookieInfo['GENDER'];
if($sessGender == 1) {
  $varPartnerStartAge = $varFemaleStartAge; 
}
else {
  $varPartnerStartAge = $varMaleStartAge;
}
$varPartnerAge	= split('~', $sessPPAge);
$varPartnerHt	= split('~', $sessPPHeight);
$varPartnerLookingStatus	= $varGetCookieInfo['PPLOOKINGFOR'];
$varPartnerMotherTongue		= $varGetCookieInfo['PPMOTHERTONGUE'];
$varPartnerReligion			= $varGetCookieInfo['PPRELIGION'];
$varPartnerDenomination		= $varGetCookieInfo['PPDENOMINATION'];
$varPartnerCaste			= $varGetCookieInfo['PPCASTE'];
$varPartnerSubcaste			= $varGetCookieInfo['PPSUBCASTE'];
$varPartnerCountry			= $varGetCookieInfo['PPCOUNTRY'];
$varPartnerFoodChoice		= $varGetCookieInfo['PPEATHABITS'];
$varEducation				= $varGetCookieInfo['PPEDUCATION'];

$varCurrentDate	= date('Y-m-d H:i:s');
$varWeightUnit	= 'kg';
$varChkformAvail= 0;
$varTabIndex = 1;

if ($_POST['intRegister']=='yes') {

	//UPDATE 
	$varCondition	= " MatriId=".$objRegister->doEscapeString($sessMatriId,$objRegister);
	$varFields = array('Weight','Weight_Unit','Body_Type','Complexion','Blood_Group','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Eating_Habits','Smoke','Drink');
	$varFieldsValues = array($objRegister->doEscapeString(trim($_REQUEST['weightKgs']),$objRegister),$objRegister->doEscapeString(trim($varWeightUnit),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['bodyType']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['complexion']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['bloodGroup']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['raasi']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['horoscopeMatch']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['chevvaiDosham']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['educationDetail']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['occupationDetail']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['eatingHabits']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['smokingHabits']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['drinkingHabits']),$objRegister));

	$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);

	$varFields = array('Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family','Date_Updated');

	$varFieldsValues = array($objRegister->doEscapeString(trim($_REQUEST['fatherOccupation']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['motherOccupation']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['familyOrgin']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['numOfBrothers']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['brothersMarried']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['numOfSisters']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['sistersMarried']),$objRegister),$objRegister->doEscapeString(trim($_REQUEST['aboutFamily']),$objRegister),"'".$varCurrentDate."'");

	$objRegister->update($varTable['MEMBERFAMILYINFO'],$varFields,$varFieldsValues,$varCondition);

	//PARTNER DETAILS
	$varFromAge					= $_REQUEST['fromAge'];
	$varToAge					= $_REQUEST['toAge'];
	$varHeightFrom				= $_REQUEST['heightFrom'];
	$varHeightTo				= $_REQUEST['heightTo'];
	$varPartnerLookingStatus	= ($_REQUEST['lookingStatus']!='')?join('~',$_REQUEST['lookingStatus']):'';
	$varPartnerMotherTongue		= ($_REQUEST['motherTongue']!='')?join('~',$_REQUEST['motherTongue']):'';
	$varPartnerReligion			= ($_REQUEST['partnerReligion']!='')?join('~',$_REQUEST['partnerReligion']):'';
	$varPartnerDenomination		= ($_REQUEST['partnerDenomination']!='')?join('~',$_REQUEST['partnerDenomination']):'';
	$varCheckCaste				= $_REQUEST['checkCaste'];
	$varPartnerCaste			= ($_REQUEST['partnerCaste']!='')?join('~',$_REQUEST['partnerCaste']):'';
	$varPartnerSubcaste			= ($_REQUEST['partnerSubcaste']!='')?join('~',$_REQUEST['partnerSubcaste']):'';
	$varPartnerCountry			= ($_REQUEST['countryLivingIn']!='')?join('~',$_REQUEST['countryLivingIn']):'';
	$varResidingIndia			= ($_REQUEST['residingIndia']!='')?join('~',$_REQUEST['residingIndia']):'';
	$varResidingUSA				= ($_REQUEST['residingUSA']!='')?join('~',$_REQUEST['residingUSA']):'';
	$varResidentStatus			= ($_REQUEST['residentStatus']!='')?join('~',$_REQUEST['residentStatus']):'';
	$varPartnerFoodChoice		= $_REQUEST['partnerFoodChoice'];
	$varEducation				= ($_REQUEST['education']!='')?join('~',$_REQUEST['education']):'';
    $varOccupation				= ($_REQUEST['occupation']!='')?join('~',$_REQUEST['occupation']):'';

	$varFields		 = array('Age_From','Age_To','Looking_Status','Height_From','Height_To','Mother_Tongue','Religion','Denomination','CasteId','SubcasteId','Chevvai_Dosham','Eating_Habits','Education','Occupation','Country','Resident_India_State','Resident_USA_State','Resident_Status','Date_Updated');
	$varFieldsValues = array($objRegister->doEscapeString($varFromAge,$objRegister),$objRegister->doEscapeString($varToAge,$objRegister),$objRegister->doEscapeString($varPartnerLookingStatus,$objRegister),$objRegister->doEscapeString($varHeightFrom,$objRegister),$objRegister->doEscapeString($varHeightTo,$objRegister),$objRegister->doEscapeString($varPartnerMotherTongue,$objRegister),$objRegister->doEscapeString($varPartnerReligion,$objRegister),$objRegister->doEscapeString($varPartnerDenomination,$objRegister),$objRegister->doEscapeString($varPartnerCaste,$objRegister),$objRegister->doEscapeString($varPartnerSubcaste,$objRegister),$objRegister->doEscapeString(trim($_REQUEST['partnerDhosam']),$objRegister),$objRegister->doEscapeString($varPartnerFoodChoice,$objRegister),$objRegister->doEscapeString($varEducation,$objRegister),$objRegister->doEscapeString($varOccupation,$objRegister),$objRegister->doEscapeString($varPartnerCountry,$objRegister),$objRegister->doEscapeString($varResidingIndia,$objRegister),$objRegister->doEscapeString($varResidingUSA,$objRegister),$objRegister->doEscapeString($varResidentStatus,$objRegister),"'".$varCurrentDate."'");

	$objRegister->update($varTable['MEMBERPARTNERINFO'],$varFields,$varFieldsValues,$varCondition);

	$varFields 			= array('Partner_Set_Status');
	$varFieldsValues	= array(1);
	$varCondition		= "MatriId = ".$objRegister->doEscapeString($sessMatriId,$objRegister);
	$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);

	// INSERT MEMBERHOBBIESINFO
	$varSpokenLanguages	= ($_REQUEST['spokenLanguages']!='')?join('~',$_REQUEST['spokenLanguages']):'';
	$varInterests		= ($_REQUEST['interests']!='')?join('~',$_REQUEST['interests']):'';
	$varHobbies			= ($_REQUEST['hobbies']!='')?join('~',$_REQUEST['hobbies']):'';
	$varFavourites		= ($_REQUEST['favourites']!='')?join('~',$_REQUEST['favourites']):'';
	$varSports			= ($_REQUEST['sports']!='')?join('~',$_REQUEST['sports']):'';
	$varFood			= ($_REQUEST['food']!='')?join('~',$_REQUEST['food']):'';

	if($varSpokenLanguages != '' || $varInterests != '' || $varHobbies != '' || $varFavourites != '' || $varSports != '' || $varFood != '') {
		$varFields			= array('MatriId','Hobbies_Selected','Interests_Selected','Music_Selected','Sports_Selected','Food_Selected','Languages_Selected','Date_Updated');
		$varFieldsValues	= array($objRegister->doEscapeString($sessMatriId,$objRegister),$objRegister->doEscapeString($varHobbies,$objRegister),$objRegister->doEscapeString($varInterests,$objRegister),$objRegister->doEscapeString($varFavourites,$objRegister),$objRegister->doEscapeString($varSports,$objRegister),$objRegister->doEscapeString($varFood,$objRegister),$objRegister->doEscapeString($varSpokenLanguages,$objRegister),'NOW()');
		$objRegister->insertIgnore($varTable['MEMBERHOBBIESINFO'],$varFields,$varFieldsValues);

		$varFields 			= array('Interest_Set_Status');
		$varFieldsValues	= array(1);
		$varCondition		= "MatriId = ".$objRegister->doEscapeString($sessMatriId,$objRegister);
		$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);
	}


	$varPartnerDetails	= $varFromAge.'~'.$varToAge.'^|'.$varHeightFrom.'~'.$varHeightTo.'^|'.$varPartnerLookingStatus.'^|'.$varPhysicalStatus.'^|'.$varPartnerMotherTongue.'^|'.$varPartnerReligion.'^|'.$varPartnerCaste.'^|'.$varPartnerFoodChoice.'^|'.$varEducation.'^|'.$varCitizenship.'^|'.$varPartnerCountry.'^|'.$varResidingIndia.'^|'.$varResidingUSA.'^|'.$varResidentStatus.'^|'.$varPartnerSmokeChoice.'^|'.$varPartnerDrinkChoice.'^|'.$varPartnerSubcaste.'^|'.$varPartnerDenomination;
	setrawcookie("partnerInfo","$varPartnerDetails", "0", "/",$confValues['DOMAINNAME']);

	header("Location: ".$confValues['SERVERURL'].'/profiledetail/');exit;

}

if($varCompleteNow == 1) {
	echo "<script>window.location=".$confValues['SERVERURL'].'/profiledetail/'."</script>";
} else {
	//get gender
	$argCondition			= "WHERE MatriId = ".$objRegister->doEscapeString($sessMatriId,$objRegister);
	$argFields 				= array('Gender');
	$varSelectGenderInfo	= $objRegister->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varSelectGenderInfoRes	= mysql_fetch_assoc($varSelectGenderInfo);
	?>
	<style>
	select.inputtext {width:215px;}
	select.select1 {width:80px;}
	</style>
	<!--<script>var starmtage=<?=$varMaleStartAge?>,starfmtage=<?=$varFemaleStartAge?></script>-->
    <script>var partnerage=<?=$varPartnerStartAge?></script>

	<script language=javascript src="<?=$confValues["JSPATH"];?>/interregs.js"></script>
	<form name="frmRegister" method="POST" style="padding:0px;margin:0px;" onSubmit="return interValidate();">	
	<input type="hidden" name="intRegister" value="yes">
	<input type="hidden" name="category" value="<?=$varCategory?>">
	<input type="hidden" name="req" value="<?=$varReqTemplate?>">
	<input type="hidden" name="oppositeId" value="<?=$varOppId?>">
	<?if($varFromPage==1){?>
		<input type="hidden" name="useRaasi" value="<?=$varUseRaasi?>">
		<input type="hidden" name="useDosham" value="<?=$varUseDosham?>">
		<input type="hidden" name="useHoroscope" value="<?=$varUseHoroscope?>">
		<input type="hidden" name="useMotherTongue" value="<?=$varUseMotherTongue?>">
		<input type="hidden" name="useReligion" value="<?=$varUseReligion?>">
		<input type="hidden" name="useDenomination" value="<?=$varUseDenomination?>">
		<input type="hidden" name="useCaste" value="<?=$varUseCaste?>">
		<input type="hidden" name="useSubcaste" value="<?=$varUseSubcaste?>">
		<input type="hidden" name="oldEduDet" value="<?=$varEducationDetail?>">
		<input type="hidden" name="oldOccDet" value="<?=$varOccupationDetail?>">
		<input type="hidden" name="oldFatOcc" value="<?=$varFatherOccupation?>">
		<input type="hidden" name="oldMotOcc" value="<?=$varMotherOccupation?>">
		<input type="hidden" name="oldFamOri" value="<?=$varFamilyOrigin?>">
		<input type="hidden" name="OldAboutFamily" value="<?=$varAboutFamily?>">
	<?}?>
	<div class="rpanel fleft">
	<div class="fleft normtxt1 clr bld padb5">Just a few more details and your profile will be just perfect.</div>
	<div class="fright tlright"><a href="/profiledetail/" class="clr1 bld">Skip this page</a></div>
	<br clear="all" />	
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
		<br clear="all" />
			<div class="padb10">
				
				<?if($varWeightKgs==0 || $varBodyType==0 || $varComplexion==0 || $varBloodGroup==0 || $varLanguagesSelected=='' || ($varUseRaasi==1 && $varRaasi==0) || ($varUseHoroscope==1 && $varHoroscopeMatch==0) || ($varUseDosham==1 && $varChevvaiDosham==0) || $varEducationDetail=='' || $varOccupationDetail=='' || $varEatingHabits==0 || $varSmokeHabits==0 || $varDrinkHabits==0 || $varInterestsSelected=='' || $varHobbiesSelected=='' || $varMusicSelected=='' || $varSportsSelected=='' || $varFoodSelected=='') { $varChkformAvail=1;?>
				<div class="bld clr">More about you</div>
				<?}?>
				<?if($varWeightKgs==0) {?>
				<div class="pfdivlt smalltxt fleft tlright">Weight</div>
				<div class="pfdivrt smalltxt fleft" id="stateList">
					<select name="weightKgs" tabindex="<?=$varTabIndex++?>" class="select1"><?=$objCommon->getValuesFromArray($arrWeightKgsList, "--Kgs--", "0", "");?></select><br><span id="weightspan" class="errortxt"></span>
				</div><br clear="all"/>
				<?}else{?>
					<input type="hidden" name="weightKgs" value="<?=$varWeightKgs?>">
				<?}?>

				<?if($varBodyType==0) {?>
				<div class="pfdivlt smalltxt fleft tlright">Body Type</div>
				<div class="pfdivrt smalltxt fleft">
					<?=$objCommon->displayRadioOptions($arrBodyTypeList, "bodyType", $varBodyType, "smalltxt",'',$varTabIndex++);?>
				<? $varTabIndex =  (count($arrBodyTypeList)+$varTabIndex-1); ?>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="bodyType" value="<?=$varBodyType?>">
				<?}?>

				<?if($varComplexion==0) {?>
				<div class="pfdivlt smalltxt fleft tlright">Complexion</div>
				<div class="pfdivrt smalltxt fleft">
					<?=$objCommon->displayRadioOptions($arrComplexionList, "complexion", $varComplexion, "smalltxt",'',$varTabIndex++);?>
				<? $varTabIndex =  (count($arrComplexionList)+$varTabIndex-1);?>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="complexion" value="<?=$varComplexion?>">
				<?}?>

				<?if($varBloodGroup==0) {?>
				<div class="pfdivlt smalltxt fleft tlright">Blood Group</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="bloodGroup" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrBloodGroupList, "--- Select Blood Group --- ", "0", "");?></select>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="bloodGroup" value="<?=$varBloodGroup?>">
				<?}?>

				<?if($varLanguagesSelected=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Spoken Languages</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="spokenLanguages[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrSpokenLangList, '--- Select Languages ---', '', '');?></select>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="spokenLanguages[]" value="<?=$varLanguagesSelected?>">
				<?}?>

				<? if($varUseRaasi==1) { 
					if($varRaasi==0) {?>
					<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getRaasiLabel()?></div>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="raasi" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($objDomainInfo->getRaasiOption(), "--- Select Raasi/Moon Sign ---", "0", $varRaasi);?></select>
					</div>
					<br clear="all"/>
					<?}else{?>
						<input type="hidden" name="raasi" value="<?=$varRaasi?>">
					<?}?>
				<? } ?>

				<?if($varUseHoroscope==1) { 
					if($varHoroscopeMatch==0) {?>
					<div class="pfdivlt smalltxt fleft tlright">Want Horoscope Match?</div>
					<div class="pfdivrt smalltxt fleft">
						<?=$objCommon->displayRadioOptions($objDomainInfo->getHoroscopeOption(), "horoscopeMatch", "Required", "smalltxt",'',$varTabIndex++);?>	
					</div>
					<? $varTabIndex =  (count($objDomainInfo->getHoroscopeOption())+$varTabIndex-1);?>
					<br clear="all"/>
					<?}else{?>
						<input type="hidden" name="horoscopeMatch" value="<?=$varHoroscopeMatch?>">
					<?}?>
				<? } ?>

				<?if($varUseDosham==1) { 
					$arrDoshamOption	= $objDomainInfo->getDoshamOption();
					$varSizeDosham		= sizeof($arrDoshamOption);
					?>
					<input type="hidden" name="doshamOption" value="<?=$varSizeDosham?>">
					<? if($varSizeDosham==1) { ?>
					<input type="hidden" name="chevvaiDosham" value="<?=key($arrDoshamOption)?>">
					<?} else {
						if($varChevvaiDosham==0 && $varSizeDosham>1) {?>
						<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getDoshamLabel()?></div>
						<div class="pfdivrt smalltxt fleft">
							<?=$objCommon->displayRadioOptions($arrDoshamOption, "chevvaiDosham", 'No', 'smalltxt','','');?>	
						</div>
						<br clear="all"/>
						<?}else{?>
							<input type="hidden" name="chevvaiDosham" value="<?=$varChevvaiDosham?>">
						<?}
					}?>
				<? } ?>

				<?if($varEducationDetail=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Education in Detail</div>
				<div class="pfdivrt smalltxt fleft">
					<input type="text" name="educationDetail" size="37" class="inputtext" tabindex="<?=$varTabIndex++?>" value=""/>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="educationDetail" value="<?=$varEducationDetail?>">
				<?}?>
                

				<?if($varOccupationDetail=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Occupation in Detail</div>
				<div class="pfdivrt smalltxt fleft">
					<input type="text" name="occupationDetail" size="37" class="inputtext" tabindex="<?=$varTabIndex++?>" value=""/>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="occupationDetail" value="<?=$varOccupationDetail?>">
				<?}?>
				
				<?if($varEatingHabits==0 || $varSmokeHabits==0 || $varDrinkHabits==0) {?>
					<div class="pfdivlt smalltxt fleft tlright">Habits</div>
					
					<?if($varEatingHabits==0){?>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="eatingHabits" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrEatingHabitsList, "--- Select Eating Habits ---", "0", "");?></select>
					</div>
					<br>
					<div class="pfdivlt smalltxt fleft tlright"></div>
					<?}else{?>
						<input type="hidden" name="eatingHabits" value="<?=$varEatingHabits?>">
					<?}?>
					
					<?if($varDrinkHabits==0){?>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="drinkingHabits" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrDrinkList, "--- Select Drinking Habits ---", "0", "");?></select>
					</div>
					<BR>
					<div class="pfdivlt smalltxt fleft tlright"></div>
					<?}else{?>
						<input type="hidden" name="drinkingHabits" value="<?=$varDrinkHabits?>">
					<?}?>
					
					<?if($varSmokeHabits==0){?>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="smokingHabits" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrSmokeList, "--- Select Smoking Habits ---", "0", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="smokingHabits" value="<?=$varSmokeHabits?>">
					<?}?>
					<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="eatingHabits" value="<?=$varEatingHabits?>">
					<input type="hidden" name="drinkingHabits" value="<?=$varDrinkHabits?>">
					<input type="hidden" name="smokingHabits" value="<?=$varSmokeHabits?>">
				<?}?>
				
				<?if($varInterestsSelected=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Interests</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="interests[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrInterestList, "--- Select Interests ---", "", "");?></select>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="interests[]" value="<?=$varInterestsSelected?>">
				<?}?>

				<?if($varHobbiesSelected=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Hobbies</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="hobbies[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrHobbiesList, "--- Select Hobbies ---", "", "");?></select>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="hobbies[]" value="<?=$varHobbiesSelected?>">
				<?}?>

				<?if($varMusicSelected=='' || $varSportsSelected=='' || $varFoodSelected==''){?>
					<div class="pfdivlt smalltxt fleft tlright">Favourites</div>
					<?if($varMusicSelected=='') {?>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="favourites[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrMusicList, "--- Select Favourites Music ---", "", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="favourites[]" value="<?=$varMusicSelected?>">
					<?}?>
					
					<?if($varSportsSelected=='') {?>
					<br clear="all">
					<div class="pfdivlt smalltxt fleft tlright">&nbsp;</div>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="sports[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrSportsList, "--- Select Favourites Sports ---", "", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="sports[]" value="<?=$varSportsSelected?>">
					<?}?>

					<?if($varFoodSelected=='') {?>
					<br clear="all"> 
					<div class="pfdivlt smalltxt fleft tlright">&nbsp;</div>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="food[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrFoodList, "--- Select Favourites Food ---", "", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="food[]" value="<?=$varFoodSelected?>">
					<?}?>

					<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="favourites[]" value="<?=$varMusicSelected?>">
					<input type="hidden" name="sports[]" value="<?=$varSportsSelected?>">
					<input type="hidden" name="food[]" value="<?=$varFoodSelected?>">
				<?}?>
				
				
				<?if($varFamilyOrigin=='' || $varMotherOccupation=='' || $varFatherOccupation=='' || ($varBrothers==0 && $varBrothersMarried==0) || ($varSisters==0 && $varSistersMarried==0) || $varAboutFamily=='') { $varChkformAvail=1;?>
				<div class="bld clr">More about your family</div>
				<?}?>
				<?if($varFamilyOrigin=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Ancestral Family Origin</div>
				<div class="pfdivrt smalltxt fleft">
					<input type="text" name="familyOrgin" size="38" class="inputtext" tabindex="<?=$varTabIndex++?>"/>
					<br><span id="nicknamespan" class="errortxt clr1"></span>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="familyOrgin" value="<?=$varFamilyOrigin?>">
				<?}?>

				<?if($varMotherOccupation=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Mother's Occupation</div>
				<div class="pfdivrt smalltxt fleft">
					<input type="inputtext" tabindex="<?=$varTabIndex++?>" name="motherOccupation" class="inputtext" size="38">
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="motherOccupation" value="<?=$varMotherOccupation?>">
				<?}?>

				<?if($varFatherOccupation=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Father's Occupation</div>
				<div class="pfdivrt smalltxt fleft">
					<input type="inputtext" tabindex="<?=$varTabIndex++?>" name="fatherOccupation" class="inputtext" size="38">
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="fatherOccupation" value="<?=$varFatherOccupation?>">
				<?}?>

				<?if($varBrothers==0 && $varBrothersMarried==0) {?>
				<div class="pfdivlt smalltxt fleft tlright">No. of Brothers</div>
				<div class="pfdivrt smalltxt fleft">
					<select name="numOfBrothers" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidate();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select No. of Brothers ---", "0", "");?></select>
				</div>
				<br clear="all"/>

				<div class="pfdivlt smalltxt fleft tlright">Brothers Married</div>
				<div class="pfdivrt smalltxt fleft">
					<select name="brothersMarried" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidate();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select Brothers Married ---", "0", "");?></select><br><span id="marriedbrothersspan" class="errortxt clr1"></span>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="numOfBrothers" value="<?=$varBrothers?>">
					<input type="hidden" name="brothersMarried" value="<?=$varBrothersMarried?>">
				<?}?>

				<?if($varSisters==0 && $varSistersMarried==0) {?>
				<div class="pfdivlt smalltxt fleft tlright">No. of Sisters</div>
				<div class="pfdivrt smalltxt fleft">
					<select name="numOfSisters" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidate();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select No. of Sisters ---", "", "");?></select>
				</div>
				<br clear="all"/>

				<div class="pfdivlt smalltxt fleft tlright">Sisters Married</div>
				<div class="pfdivrt smalltxt fleft">
					<select name="sistersMarried" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidate();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select Sisters Married ---", "", "");?></select><br><span id="marriedsistersspan" class="errortxt clr1"></span>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="numOfSisters" value="<?=$varSisters?>">
					<input type="hidden" name="sistersMarried" value="<?=$varSistersMarried?>">
				<?}?>

				<?if($varAboutFamily=='') {?>
				<div class="pfdivlt smalltxt fleft tlright">Few lines about your family</div>
				<div class="pfdivrt smalltxt fleft">
					<textarea name="aboutFamily" rows="4" tabindex="<?=$varTabIndex++?>" class="srchselect"></textarea>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="aboutFamily" value="<?=$varAboutFamily?>">
				<?}?>

				<?
				if($varUseCaste==1) {
					$arrGetCasteOption = $objDomainInfo->getCasteOption();
					$varSizeCaste	= sizeof($arrGetCasteOption);
					echo '<input type="hidden" name="castesize" value="'.$varSizeCaste.'">';
				}
				
				if($varUseSubcaste==1) { 
					$arrGetSubcasteOption = $objDomainInfo->getSubcasteOption();
					$varSizeSubcaste	= sizeof($arrGetSubcasteOption);
					echo '<input type="hidden" name="subcastesize" value="'.$varSizeSubcaste.'">';
				}
				if($varPPStatus!=1) { ?>
				<div class="bld clr">More about your partner</div>
				
				<div class="pfdivlt smalltxt fleft tlright">Age</div>
				<div class="pfdivrt smalltxt fleft">
					From: <input type="text" name="fromAge" size="2" tabindex="<?=$varTabIndex++?>" maxlength=2 class="inputtext" value="<?=$varPartnerAge[0]?>">
					To: <input type="text" name="toAge" size="2" tabindex="<?=$varTabIndex++?>" maxlength=2 class="inputtext" value="<?=$varPartnerAge[1]?>"><br><span id="stage" class="errortxt"></span>
				</div>
				<br clear="all"/>
				
				<div class="pfdivlt smalltxt fleft tlright">Height</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="select1" name="heightFrom" tabindex="<?=$varTabIndex++?>" size="1"><?=$objCommon->getValuesFromArray($arrHeightList, "", "",  $varPartnerHt[0]);?></select>&nbsp;<font class="mediumtxt"> &nbsp;to&nbsp; </font>
					<select style="width:110px" class="select1" name="heightTo" tabindex="<?=$varTabIndex++?>" size="1"><?=$objCommon->getValuesFromArray($arrHeightList, "", "", $varPartnerHt[1]);?></select><br><span id="stheight" class="errortxt"></span>
				</div><br clear="all"/>
				

				<? if($varUseMaritalStatus==1) { 
					$arrRetMaritalStatus	= $objDomainInfo->getMaritalStatusOption();
                    if($varSelectGenderInfoRes['Gender'] == 1 && $confValues["DOMAINCASTEID"]==2503) {
		            unset($arrRetMaritalStatus[5]);
	                } else if($varSelectGenderInfoRes['Gender'] == 2 && $confValues["DOMAINCASTEID"]==2006) {
		            unset($arrRetMaritalStatus[6]);
	                }
					?>
					<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getMaritalStatusLabel()?></div>
					<div class="pfdivrt smalltxt fleft">
						<select class="inputtext" name="lookingStatus[]" size="3" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrRetMaritalStatus, "Doesn't Matter", "0", "");?></select>
					</div>
					<br clear="all"/>
				<? } ?>

				<div class="pfdivlt smalltxt fleft tlright">Mother Tongue</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="motherTongue[]" size="3" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrMotherTongueList, "Doesn't Matter", "0", "");?></select>
				</div>
				<br clear="all"/>
				
				<? if($varUseReligion) { 
					$arrGetReligionOption = $objDomainInfo->getReligionOption();
					if (sizeof($arrGetReligionOption)>1) {
						?>
						<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getReligionLabel()?></div>
						<div class="pfdivrt smalltxt fleft">
							<select class="inputtext" name="partnerReligion[]" size="3" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrGetReligionOption, "Doesn't Matter", "0", "");?></select>
						</div><br clear="all"/>
					<? } else { 
						echo '<input type="hidden" name="partnerReligion[]" value="'.key($arrGetReligionOption).'">'; 
					}
				} ?>

				<? if($varUseDenomination) { 
					$arrGetDenominationOption = $objDomainInfo->getDenominationOption();
					if (sizeof($arrGetDenominationOption)>1) {
						?>
						<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getDenominationLabel()?></div>
						<div class="pfdivrt smalltxt fleft">
							<select class="inputtext" name="partnerDenomination[]" size="3" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrGetDenominationOption, "Doesn't Matter", "0", "");?></select>
						</div><br clear="all"/>
				<? } else { 
						echo '<input type="hidden" name="partnerDenomination[]" value="'.key($arrGetDenominationOption).'">'; 
					}
				} ?>

				<? if($varUseCaste && $varIsCasteMandatory == 1) {
					$arrGetCasteOption = $objDomainInfo->getCasteOption();
					if (sizeof($arrGetCasteOption)>1) {
						?>
						<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getCasteLabel();?></div>
						<div class="pfdivrt smalltxt fleft">
							<select class="inputtext" size="3" tabindex="<?=$varTabIndex++?>" multiple name="partnerCaste[]"> <?=$objCommon->getValuesFromArray($arrGetCasteOption, "Doesn't Matter", "0", "");?> </select>
						</div><br clear="all"/>						
					<? } else { ?>
						<input type="hidden" name="partnerCaste[]" value="<?=key($arrGetCasteOption)?>">
					<? }
				}?>

				<? if($varUseSubcaste && $varIsSubcasteMandatory==1) { 
					$arrGetSubcasteOption = $objDomainInfo->getSubcasteOption();
					if (sizeof($arrGetSubcasteOption)>1) {
						?>
						<div class="pfdivlt smalltxt fleft tlright">Sub caste</div>
						<div class="pfdivrt smalltxt fleft">
							<select class="inputtext" size="3" tabindex="<?=$varTabIndex++?>" multiple name="partnerSubcaste[]"> <?=$objCommon->getValuesFromArray($arrGetSubcasteOption, "Doesn't Matter", "0", "");?> </select>
						</div><br clear="all"/>
				<? } else {
					echo '<input type="hidden" name="partnerSubcaste[]" value="'.key($arrGetSubcasteOption).'">'; 
					}
				}?>

				<? if($_FeatureDosham == 1) {
					$arrTmpDoshamList	= $objDomainInfo->getDoshamOption();
					unset($arrRetDosham['3']);
					$varPartnerSizeDosham= sizeof($arrTmpDoshamList);
					
					if($varPartnerSizeDosham == 1) {?>
						<input type="hidden" name="partnerDhosam" value="<?=key($arrTmpDoshamList)?>">
					<?} else {
						if($varPartnerChevvaiDosham==0 && $varPartnerSizeDosham>1) {?>
						<div class="pfdivlt smalltxt fleft tlright">Chevvai Dosham</div>
						<div class="pfdivrt smalltxt fleft">
							<?=$objCommon->displayRadioOptions($arrTmpDoshamList, "partnerDhosam", "No", "smalltxt",'','');?>	
							<input type=radio name=partnerDhosam value='0' checked><font class='smalltxt'>Doesn't matter&nbsp;</font>
						</div>
						<br clear="all"/>
						<?}else{?>
							<input type="hidden" name="partnerDhosam" value="<?=$varPartnerChevvaiDosham?>">
						<?}
					}?>
				<? } ?>

				<div class="pfdivlt smalltxt fleft tlright">Food</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="partnerFoodChoice" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrEatingHabitsList, "Doesn't Matter", "0", "");?></select>
				</div>
				<br clear="all"/>

				<div class="pfdivlt smalltxt fleft tlright">Education</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="education[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrEducationList, "Doesn't Matter", "0", "");?></select>
				</div>
				<br clear="all"/>

				<? if($confValues["DOMAINCASTEID"] == 2006 && $sessGender==1) {
					$arrTotalOccupationList = $arrFemaleDefenceOccupationList;
				} else if($confValues["DOMAINCASTEID"] == 2006 && $sessGender==2) {
					$arrTotalOccupationList = $arrDefenceOccupationList;
				}?>
				<div class="pfdivlt smalltxt fleft tlright">Occupation</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="occupation[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrTotalOccupationList, "Doesn't Matter", "0", "");?></select>
				</div>
				<br clear="all"/>
                
				<? if($confValues["DOMAINCASTEID"] == 2006) { ?>
				<select class='srchselect' name='countryLivingIn[]' id='countryLivingIn[]' multiple size='5' Onchange="displayCityState();" style="display:none">
			          <option value="98" selected>India</option>
				</select>
                <? } else { ?> 
				<div class="pfdivlt smalltxt fleft tlright">Country Living In</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="countryLivingIn[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrCountryList, "Doesn't Matter", "0", "");?></select>
				</div>
				<br clear="all"/>
               <? } ?>

				<div class="pfdivlt smalltxt fleft tlright">Residing India State</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="residingIndia[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrResidingStateList, "Select residing India state", "0", "");?></select>
				</div>
				<br clear="all"/>
                
				<? if($confValues["DOMAINCASTEID"] != 2006) { ?>
				<div class="pfdivlt smalltxt fleft tlright">Residing USA State</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="residingUSA[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrUSAStateList, "Select residing USA state", "0", "");?></select>
				</div>
				<br clear="all"/>
				<? } ?>
	<!-- 
				<div class="pfdivlt smalltxt fleft tlright">Residing City</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="partnerCity" size="1" tabindex="5"><?=$objCommon->getValuesFromArray($arrCityList, "Doesn't Matter", "0", "");?></select>
				</div>
				<br clear="all"/> -->

	<!-- 			<div class="pfdivlt smalltxt fleft tlright">Citizenship</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="partnerCitizen" size="1" tabindex="5"><?=$objCommon->getValuesFromArray($arrCountryList, "", "", "");?></select>
				</div>
				<br clear="all"/> -->
		        
				<? if($confValues["DOMAINCASTEID"] == 2006) { ?>
				   <select class="inputtext" name="residentStatus[]" size="4" multiple tabindex="<?=$varTabIndex++?>" style="display:none">
					<option value=1>citizen</option></select>
				<? } else { ?>
				<div class="pfdivlt smalltxt fleft tlright">Residing Status</div>
				<div class="pfdivrt smalltxt fleft">
					<select class="inputtext" name="residentStatus[]" size="4" multiple tabindex="<?=$varTabIndex++?>">
					<?=$objCommon->getValuesFromArray($arrResidentStatusList, "Residing Status", "0", "");?></select>
				</div>
				<br clear="all"/>
                <? } ?>

				<? } ?>

				<?if($varChkformAvail==1) {?>
				<div class="tlright"><input type="submit" tabindex="<?=$varTabIndex++?>" class="button" value="Submit" /></div>
				<?}else{
					echo "<script>window.location=".$confValues['SERVERURL'].'/profiledetail/'."</script>";
				}?>
				<br clear="all"/>
			</div>
	</div>
	<br clear="all"/>
	</form>
	<script language="javascript">document.frmRegister.weightKgs.focus();</script>
<?}?>