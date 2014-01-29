<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : partnerinfodesc.php
#=====================================================================================================================================
# Description : display information of partner info. It has partner info form and update function partner information.
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//SESSION OR COOKIE VALUES
$sessMatriId= $varGetCookieInfo["MATRIID"];
$sessPublish= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objDBMaster= new MemcacheDB;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['partnerinfosubmit'];

if($varUpdatePrimary == 'yes') {

	$varEditedFromAge			= $_REQUEST["fromAge"];
	$varEditedToAge				= $_REQUEST["toAge"];
	$varEditedLookingStatus		= $_REQUEST["lookingStatus"];
	$varEditedHaveChildren		= $_REQUEST["haveChildren"];
	$varEditedHeightFrom		= $_REQUEST["heightFrom"];
	$varEditedHeightTo			= $_REQUEST["heightTo"];
	$varEditedPhysicalStatus	= $_REQUEST["physicalStatus"];
	$varEditedMotherTongue		= ($_REQUEST['motherTongue']!='')?join('~',$_REQUEST['motherTongue']):'';
	$varEditedPartnerDescription= trim($_REQUEST["partnerDescription"]);
	$varEditedReligion			= ($_REQUEST['religion']!='')?join('~',$_REQUEST['religion']):'';
	$varEditedDenomination		= ($_REQUEST['denomination']!='')?join('~',$_REQUEST['denomination']):'';
	$varEditedCasteDivision		= ($_REQUEST['casteDivision']!='')?join('~',$_REQUEST['casteDivision']):'';
	$varEditedsubCaste			= ($_REQUEST['subCaste']!='')?join('~',$_REQUEST['subCaste']):'';
	$varEditedManglik			= $_REQUEST["manglik"];
	$varEditedEatingHabits		= $_REQUEST["eatingHabits"];
	$varEditedSmokingHabits		= $_REQUEST["smokingHabits"];
	$varEditedDrinkingHabits	= $_REQUEST["drinkingHabits"];
	$varEditedEducation			= ($_REQUEST['education']!='')?join('~',$_REQUEST['education']):'';
	$varEditedCitizenship		= ($_REQUEST['citizenship']!='')?join('~',$_REQUEST['citizenship']):'';
	$varEditedCountryLivingIn	= ($_REQUEST['countryLivingIn']!='')?join('~',$_REQUEST['countryLivingIn']):'';
	$varEditedResidingIndia		= ($_REQUEST['residingIndia']!='')?join('~',$_REQUEST['residingIndia']):'';
	$varEditedResidingUSA		= ($_REQUEST['residingUSA']!='')?join('~',$_REQUEST['residingUSA']):'';
	$varEditedResidentStatus	= ($_REQUEST['residentStatus']!='')?join('~',$_REQUEST['residentStatus']):'';
    
    $varEditedResidentDistrict	= ($_REQUEST['residingCity']!='')?join('~',$_REQUEST['residingCity']):'';
	$varEditedEmployedIn	= ($_REQUEST['employedIn']!='')?join('~',$_REQUEST['employedIn']):'';
	$varEditedOccupation	= ($_REQUEST['occupation']!='')?join('~',$_REQUEST['occupation']):'';
	$varEditedGothram	= ($_REQUEST['gothram']!='')?join('~',$_REQUEST['gothram']):'';
	$varEditedStar	= ($_REQUEST['star']!='')?join('~',$_REQUEST['star']):'';
	$varEditedRaasi	= ($_REQUEST['raasi']!='')?join('~',$_REQUEST['raasi']):'';


	//CONTROL STATEMENT
	$varEditedLookingStatusValue= join('~',$varEditedLookingStatus);	

	if($sessMatriId != '')
	{
		//find member has partner info or not
		$argFields				= array('MatriId');
		$argCondition			= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
		$varChkMemberResultSet	= $objDBSlave->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
		$varChkMemberInfo		= mysql_fetch_array($varChkMemberResultSet);

		if($varChkMemberInfo['MatriId'] == '') {
			$argFields 			= array('MatriId');
			$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster));
			$varInsertedId		= $objDBMaster->insert($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues);
		}

		//Direct updatation for array field
		$argFields 				= array('Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Physical_Status','Education','Religion','Denomination','CasteId','SubcasteId','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_USA_State','Resident_Status','Mother_Tongue','Eating_Habits','Drinking_Habits','Smoking_Habits','Date_Updated','Resident_District','Employed_In','Occupation','GothramId','Star','Raasi');
		$argFieldsValues		= array($objDBMaster->doEscapeString($varEditedFromAge,$objDBMaster),$objDBMaster->doEscapeString($varEditedToAge,$objDBMaster),$objDBMaster->doEscapeString($varEditedLookingStatusValue,$objDBMaster),$objDBMaster->doEscapeString($varEditedHaveChildren,$objDBMaster),$objDBMaster->doEscapeString($varEditedHeightFrom,$objDBMaster),$objDBMaster->doEscapeString($varEditedHeightTo,$objDBMaster),$objDBMaster->doEscapeString($varEditedPhysicalStatus,$objDBMaster),$objDBMaster->doEscapeString($varEditedEducation,$objDBMaster),$objDBMaster->doEscapeString($varEditedReligion,$objDBMaster),$objDBMaster->doEscapeString($varEditedDenomination,$objDBMaster),$objDBMaster->doEscapeString($varEditedCasteDivision,$objDBMaster),$objDBMaster->doEscapeString($varEditedsubCaste,$objDBMaster),$objDBMaster->doEscapeString($varEditedManglik,$objDBMaster),$objDBMaster->doEscapeString($varEditedCitizenship,$objDBMaster),$objDBMaster->doEscapeString($varEditedCountryLivingIn,$objDBMaster),$objDBMaster->doEscapeString($varEditedResidingIndia,$objDBMaster),$objDBMaster->doEscapeString($varEditedResidingUSA,$objDBMaster),$objDBMaster->doEscapeString($varEditedResidentStatus,$objDBMaster),$objDBMaster->doEscapeString($varEditedMotherTongue,$objDBMaster),$objDBMaster->doEscapeString($varEditedEatingHabits,$objDBMaster),$objDBMaster->doEscapeString($varEditedDrinkingHabits,$objDBMaster),$objDBMaster->doEscapeString($varEditedSmokingHabits,$objDBMaster),'NOW()',$objDBMaster->doEscapeString($varEditedResidentDistrict,$objDBMaster),$objDBMaster->doEscapeString($varEditedEmployedIn,$objDBMaster),$objDBMaster->doEscapeString($varEditedOccupation,$objDBMaster),$objDBMaster->doEscapeString($varEditedGothram,$objDBMaster),$objDBMaster->doEscapeString($varEditedStar,$objDBMaster),$objDBMaster->doEscapeString($varEditedRaasi,$objDBMaster));
		$argCondition			= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId			= $objDBMaster->update($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues,$argCondition);

		//Direct updatation for array field
		$argFields 			= array('Partner_Set_Status');
		$argFieldsValues	= array(1);
		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

		// NOT VALIDATED MEMBER COMMIT OTHER DETAILS DIRECTLY
		if($sessPublish == 0 || $sessPublish == 4) {
			$argFields 			= array('Partner_Description');
			$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedPartnerDescription,$objDBMaster));
			$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
			$varUpdateId		= $objDBMaster->update($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues,$argCondition);

			if($sessPublish == 4) {
				$argFields		= array('Publish');
				$argFieldsValues= array('0');
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
			}
		} else {	
			if(trim($_REQUEST['oldpartnerdesc']) != trim($varEditedPartnerDescription)) {
				$argFields 			= array('MatriId');
				$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster));
				$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

				$argFields 			= array('Partner_Description','Date_Updated');
				$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedPartnerDescription,$objDBMaster),'NOW()');
				$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$argCondition);

				$argFields 			= array('Pending_Modify_Validation','Partner_Set_Status');
				$argFieldsValues	= array(1,1);
				$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			}
		}

		$argFields 			= array('Date_Updated','Time_Posted');
		$argFieldsValues	= array('NOW()','NOW()');
		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
		
		$varPartnerDetails	= $varEditedFromAge.'~'.$varEditedToAge.'^|'.$varEditedHeightFrom.'~'.$varEditedHeightTo.'^|'.$varEditedLookingStatusValue.'^|'.$varEditedPhysicalStatus.'^|'.$varEditedMotherTongue.'^|'.$varEditedReligion.'^|'.$varEditedCasteDivision.'^|'.$varEditedEatingHabits.'^|'.$varEditedEducation.'^|'.$varEditedCitizenship.'^|'.$varEditedCountryLivingIn.'^|'.$varEditedResidingIndia.'^|'.$varEditedResidingUSA.'^|'.$varEditedResidentStatus.'^|'.$varEditedSmokingHabits.'^|'.$varEditedDrinkingHabits.'^|'.$varEditedsubCaste.'^|'.$varEditedDenomination;

		setrawcookie("partnerInfo",$varPartnerDetails, "0", "/",$confValues['DOMAINNAME']);
		
		header("Location: index.php?act=partnerinfodesc&editpartner=yes");
		exit;
	}
}
$objDBSlave->dbClose();
$objDBMaster->dbClose();
?>