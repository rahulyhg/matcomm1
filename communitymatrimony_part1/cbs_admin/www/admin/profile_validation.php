<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/emailsconfig.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsAdminValMailer.php');
include_once($varRootBasePath.'/www/payment/getcountry.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//OBJECT DECLARTION
$objAdminMailer		= new AdminValid;
$objMaster			= new MemcacheDB;
$objProfileDetail	= new ProfileDetail;
$objCommon			= new clsCommon;
$objDomain			= new domainInfo;

//DB CONNECTION
$objAdminMailer->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

//REQUEST VARIABLE
$varRequestMatriId	= $_REQUEST['id'];
$varReportId		= $_REQUEST['reportid'];
$varCurrentDate		= date('Y-m-d H:i:s');
$varCommentwithAdmin= '--'.date('y-m-d H:i:s').'--'.$varCookieInfo['USERNAME'].'--';
$varModifyUrl		= 'index.php?act=edit-profile&MatriId=';
$varGivenTime		= 480;

function emailValidation($argEmail) {
	if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $argEmail)) { return FALSE; }//if
	list($Username, $Domain) = split("@",$argEmail);
	if(getmxrr($Domain, $MXHost)) { return TRUE; }
	else {
			//if(fsockopen($Domain, 25, $errno, $errstr, 30)) { return TRUE; }//else
			//else { return FALSE; }//else
	}//else
}

if($_REQUEST['elpasetime']=='yes') {
	$varStatus			= 'Z';
	$matriId			= $_REQUEST['matid'];

	//update validation report
	$argFields 			= array('profilestatus');
	$argFieldsValues	= array($objMaster->doEscapeString($varStatus,$objMaster));
	$argCondition		= " id=".$objMaster->doEscapeString($varReportId,$objMaster)." AND matriid=".$objMaster->doEscapeString($matriId,$objMaster)." AND userid=".$objMaster->doEscapeString($adminUserName,$objMaster);
	$varUpdateId		= $objMaster->update($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues,$argCondition);

	//insert into validation timeout report
	$argFields			= array('MatriId','User_Name','TimeoutDate');
	$argFieldsValues	= array($objMaster->doEscapeString($matriId,$objMaster),$objMaster->doEscapeString($adminUserName,$objMaster),"NOW()");
	$varTimeoutInsertId	= $objMaster->insert($varTable['TIMEOUTREPORT'],$argFields,$argFieldsValues);
	header("Location: index.php?act=logout");exit;

} else if($_POST['frmAddedProfileSubmit']=='yes'){
		$action					= $_REQUEST['action1'];
		$matriId				= $_REQUEST['matriId'];
		$varCommunityId			= $_REQUEST['communityid'];
		$adminComment			= addslashes(strip_tags(trim($_REQUEST['adminComment'])));
		$varPreDefinedComment	= addslashes(strip_tags(trim($_REQUEST['predefcomment'])));
		$varTimeTaken			= $varGivenTime-$_REQUEST['counttime'];
		$varProfilePaidStatus	= $_REQUEST['paidstatus'];
		$varStatus				= '';
		$varPublishFlag			= '';
		$varMessage				= '';

		//SETING MEMCACHE KEY
		$varProfileMCKey		= 'ProfileInfo_'.$matriId;

		$argCondition			= "WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);

		$argFields 				= array('User_Name','Email');
		$varSelectUserNameRes	= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectUserName		= mysql_fetch_assoc($varSelectUserNameRes);

		if($action!= "")
		{
			$argFields 				= array('Support_Comments','Publish','Nick_Name','Name','About_Myself');
			$varadminCommentsRes	= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$varadminComments		= mysql_fetch_assoc($varadminCommentsRes);
			$varComment				= addslashes(strip_tags(trim($varadminComments['Support_Comments']))).' '.$adminComment.' '.$varPreDefinedComment.' '.$varCommentwithAdmin;

			if($varProfilePaidStatus == 0 && $varadminComments['Publish'] == 1) {
				$varPublishFlag = 'Validated';
				echo "<br><div class='errorMsg' width='500' align='center'>Already ".$varSelectUserName['User_Name']." profile Validated.</div>";
			}

			$varDisplayName	= ($varadminComments['Nick_Name']!='')?$varadminComments['Nick_Name']:$varadminComments['Name'];
		}


		//Updation in memberinfo table
		if( $action == "reject" && $varPublishFlag == '') { //Reject new profile with Error And SendingMail

			$varStatus		= "R";
			$varMessage		= 'Profile ('.$matriId.') rejected successfully';
			$argFields 		= array('Publish','Support_Comments');
			$argFieldsValues= array(4,$objMaster->doEscapeString($varComment,$objMaster));
			$argCondition	= "MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			$varUpdateId	= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

			if($varPreDefinedComment==1 || $varPreDefinedComment==7) {
				$varMailComment	= $arrProfileReject[$varPreDefinedComment]."<BR><BR>".$varadminComments['About_Myself'];
			} else {
				$varMailComment	= $arrProfileReject[$varPreDefinedComment];
			}

			$valFrom            = "validate";
			$retValue		= $objAdminMailer->sendTroubleWithUrProfileMail($matriId,$varDisplayName,$varSelectUserName['Email'],$varMailComment,$valFrom);
		} else if( $action == "add" && $varPublishFlag == '') { //Accept new profile

			$varStatus		= "A";
			$varMessage		= 'Profile ('.$matriId.') added successfully';
			$argCondition	= "WHERE MatriId=".$objMaster->doEscapeString($matriId,$objMaster);

			$argFields		= array('CommunityId','MatriId','Matchwatch','SpecialFeatures','Promotions','ThirdParty','Date_Updated');
			$argFieldsValues= array($objMaster->doEscapeString($varCommunityId,$objMaster),$objMaster->doEscapeString($matriId,$objMaster),1,1,1,1,"'".$varCurrentDate."'");
			$varInsertId	= $objMaster->insertOnDuplicate($varTable['MAILMANAGERINFO'],$argFields,$argFieldsValues,'MatriId');

			$argFields 		= array('Publish','Support_Comments','Profile_Published_On');
			$argFieldsValues= array(1,$objMaster->doEscapeString($varComment,$objMaster),"'".$varCurrentDate."'");
			$argCondition	= "MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			$varUpdateId	= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

			//Get Name & Pinno for corresponding matriid
			$argCondition	= "WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$argFields 		= $arrMEMBERINFOfields;
			$varSelectName	= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);

			if($varSelectName['Phone_Verified'] != 1) {
				$argFields 			= array('PINNO');
				$varSelectPinNoRes	= $objAdminMailer->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argCondition,0);
				$varSelectPinNo		= mysql_fetch_assoc($varSelectPinNoRes);
				$varPinNo			= $varSelectPinNo['PINNO'];
			} else {
				$varPinNo			= '';
			}

			//UPDATE interestpendinginfo status IF ANY NEW MENBERS SEND MESSAGE
			$argFields 				= array('Status');
			$argFieldsValues		= array(0);
			$argCondition			= "Opposite_MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			$varUpdateId			= $objMaster->update($varTable['INTERESTPENDINGINFO'],$argFields,$argFieldsValues,$argCondition);

			$retValue				= $objAdminMailer->sendProfileValidationMail($matriId,$varSelectName["Name"],$varSelectUserName['Email'],$varSelectName["Phone_Verified"],$varPinNo);
			
		} else if( $action == "ignore" && $varPublishFlag == '') { //Delete new profile

			$varStatus		= "I";
			$varMessage		= 'Profile ('.$matriId.') ignored successfully';

			$argFields		= array('CommunityId','MatriId','Name','Nick_Name','Age','Gender','Height','Height_Unit','Weight','Weight_Unit','Body_Type','Appearance','Complexion','Physical_Status','Disability_Cause','Disability_Type','Disability_Severity','Disability_Product_Used','Sign_Language','Blood_Group','Marital_Status','No_Of_Children','Children_Living_Status','Education_Category','Education_Subcategory','Education_Detail','Employed_In','Occupation','Occupation_Detail','Income_Currency','Annual_Income','Religion','Denomination','DenominationText','CasteId','CasteText','Caste_Nobar','Subcaste_Nobar','SubcasteId','SubcasteText','Mother_TongueId','Mother_TongueText','GothramId','GothramText','Star','Raasi','Horoscope_Match','Chevvai_Dosham','Religious_Values','Ethnicity','Resident_Status','Country','Citizenship','Residing_State','Residing_Area','Residing_District','Residing_City','Contact_Phone','Contact_Mobile','About_Myself','Eating_Habits','Smoke','Drink','Profile_Created_By','Paid_Status','Special_Priv','Phone_Verified','Phone_Protected','Hobbies_Available','Horoscope_Available','Horoscope_Protected','Photo_Set_Status','Protect_Photo_Set_Status','Partner_Set_Status','Family_Set_Status','Interest_Set_Status','Physical_Set_Status','Date_Created','Time_Posted','Date_Updated','Last_Login','Validated_By','Support_Comments');
			$argCondition	= " WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$varSelectName	= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$varSelectNameRes			= mysql_fetch_assoc($varSelectName);

			$varCommunityId				= $varSelectNameRes['CommunityId'];
			$varMatriId					= $varSelectNameRes['MatriId'];
			$varName					= addslashes(strip_tags(trim($varSelectNameRes['Name'])));
			$varNickName				= addslashes(strip_tags(trim($varSelectNameRes['Nick_Name'])));
			$varAge						= $varSelectNameRes['Age'];
			$varGender					= $varSelectNameRes['Gender'];
			$varHeight					= $varSelectNameRes['Height'];
			$varHeightUnit				= $varSelectNameRes['Height_Unit'];
			$varWeight					= $varSelectNameRes['Weight'];
			$varWeightUnit				= $varSelectNameRes['Weight_Unit'];
			$varBodyType				= $varSelectNameRes['Body_Type'];
			$varAppearance				= $varSelectNameRes['Appearance'];
			$varComplexion				= $varSelectNameRes['Complexion'];
			$varPhyicalStatus			= $varSelectNameRes['Physical_Status'];
			$varDisabilityCause			= $varSelectNameRes['Disability_Cause'];
			$varDisabilityType			= addslashes(strip_tags(trim($varSelectNameRes['Disability_Type'])));
			$varDisabilitySeverity		= $varSelectNameRes['Disability_Severity'];
			$varDisabilityProductUsed	= addslashes(strip_tags(trim($varSelectNameRes['Disability_Product_Used'])));
			$varSignLanguage			= $varSelectNameRes['Sign_Language'];
			$varBloodGroup				= $varSelectNameRes['Blood_Group'];
			$varMaritalStatus			= $varSelectNameRes['Marital_Status'];
			$varNoOfChildren			= $varSelectNameRes['No_Of_Children'];
			$varChildrenLivingStatus	= $varSelectNameRes['Children_Living_Status'];
			$varEducationCategory		= $varSelectNameRes['Education_Category'];
			$varEducationSubcategory	= $varSelectNameRes['Education_Subcategory'];
			$varEducationDetail			= addslashes(strip_tags(trim($varSelectNameRes['Education_Detail'])));
			$varEmployedIn				= $varSelectNameRes['Employed_In'];
			$varOccupation				= $varSelectNameRes['Occupation'];
			$varOccupationDetail		= addslashes(strip_tags(trim($varSelectNameRes['Occupation_Detail'])));
			$varIncomeCurrency			= $varSelectNameRes['Income_Currency'];
			$varAnnualIncome			= $varSelectNameRes['Annual_Income'];
			$varReligion				= $varSelectNameRes['Religion'];
			$varDenomination			= $varSelectNameRes['Denomination'];
			$varDenominationTxt			= addslashes(strip_tags(trim($varSelectNameRes['DenominationText'])));
			$varCasteId					= $varSelectNameRes['CasteId'];
			$varCasteTxt				= addslashes(strip_tags(trim($varSelectNameRes['CasteText'])));
			$varCasteNoBar				= $varSelectNameRes['Caste_Nobar'];
			$varSubcasteNoBar			= $varSelectNameRes['Subcaste_Nobar'];
			$varSubcasteId				= $varSelectNameRes['SubcasteId'];
			$varSubcasteTxt				= addslashes(strip_tags(trim($varSelectNameRes['SubcasteText'])));
			$varMotherTongueId			= $varSelectNameRes['Mother_TongueId'];
			$varMotherTongueTxt			= addslashes(strip_tags(trim($varSelectNameRes['Mother_TongueText'])));
			$varGothramId				= $varSelectNameRes['GothramId'];
			$varGothramTxt				= addslashes(strip_tags(trim($varSelectNameRes['GothramText'])));
			$varStar					= $varSelectNameRes['Star'];
			$varRaasi					= $varSelectNameRes['Raasi'];
			$varhoroscopeMatch			= $varSelectNameRes['Horoscope_Match'];
			$varChevvaiDosham			= $varSelectNameRes['Chevvai_Dosham'];
			$varReligiousValues			= $varSelectNameRes['Religious_Values'];
			$varEthnicity				= $varSelectNameRes['Ethnicity'];
			$varResidentStatus			= $varSelectNameRes['Resident_Status'];
			$varCountry					= $varSelectNameRes['Country'];
			$varCitizenship				= $varSelectNameRes['Citizenship'];
			$varResidentState			= $varSelectNameRes['Residing_State'];
			$varResidingArea			= addslashes(strip_tags(trim($varSelectNameRes['Residing_Area'])));
			$varResidingDistrice		= $varSelectNameRes['Residing_District'];
			$varResidingCity			= addslashes(strip_tags(trim($varSelectNameRes['Residing_City'])));
			$varContactPhone			= addslashes(strip_tags(trim($varSelectNameRes['Contact_Phone'])));
			$varContactMobile			= addslashes(strip_tags(trim($varSelectNameRes['Contact_Mobile'])));
			$varAboutMySelf				= addslashes(strip_tags(trim($varSelectNameRes['About_Myself'])));
			$varEatingHabits			= $varSelectNameRes['Eating_Habits'];
			$varSmoke					= $varSelectNameRes['Smoke'];
			$varDrink					= $varSelectNameRes['Drink'];
			$varProfileCreatedBy		= $varSelectNameRes['Profile_Created_By'];
			$varPaidStatus				= $varSelectNameRes['Paid_Status'];
			$varSpecialPriv				= $varSelectNameRes['Special_Priv'];
			$varPhoneVerified			= $varSelectNameRes['Phone_Verified'];
			$varPhoneProtected			= $varSelectNameRes['Phone_Protected'];
			$varHobbiesAvailable		= $varSelectNameRes['Hobbies_Available'];
			$varHoroAvaialble			= $varSelectNameRes['Horoscope_Available'];
			$varHoroProtected			= $varSelectNameRes['Horoscope_Protected'];
			$varPhotoSetStatus			= $varSelectNameRes['Photo_Set_Status'];
			$varPhotoProtectStatus		= $varSelectNameRes['Protect_Photo_Set_Status'];
			$varPartnerSetStatus		= $varSelectNameRes['Partner_Set_Status'];
			$varFamilySetStatus			= $varSelectNameRes['Family_Set_Status'];
			$varInterestSetStatus		= $varSelectNameRes['Interest_Set_Status'];
			$varPhysicalSetStatus		= $varSelectNameRes['Physical_Set_Status'];
			$varDateCreated				= $varSelectNameRes['Date_Created'];
			$varTimePosted				= $varSelectNameRes['Time_Posted'];
			$varDateUpdated				= $varSelectNameRes['Date_Updated'];
			$varLastLogin				= $varSelectNameRes['Last_Login'];
			$varValidatedby				= addslashes(strip_tags(trim($varSelectNameRes['Validated_By'])));
			$varSupportComments			= addslashes(strip_tags(trim($varSelectNameRes['Support_Comments'])));

			//get login detail
			$argFields			= array('Email','Password');
			$argCondition		= " WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$varLoginDetail		= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
			$varLoginDetailRes	= mysql_fetch_assoc($varLoginDetail);

			$varEmail		= addslashes(strip_tags(trim($varLoginDetailRes['Email'])));
			$varPassword	= addslashes(strip_tags(trim($varLoginDetailRes['Password'])));

			//get family detail
			$argFields			= array('Family_Value','Family_Type','Family_Status','Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family');
			$argCondition		= " WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$varFamilyDetail	= $objAdminMailer->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
			$varFamilyDetailRes	= mysql_fetch_assoc($varFamilyDetail);

			$varFamilyValue			= $varFamilyDetailRes['Family_Value'];
			$varfamilyype			= $varFamilyDetailRes['Family_Type'];
			$varFamilystatus		= $varFamilyDetailRes['Family_Status'];
			$varFatherOccupation	= addslashes(strip_tags(trim($varFamilyDetailRes['Father_Occupation'])));
			$varMotherOccupation	= addslashes(strip_tags(trim($varFamilyDetailRes['Mother_Occupation'])));
			$varFamilyOrigin		= addslashes(strip_tags(trim($varFamilyDetailRes['Family_Origin'])));
			$varBrothers			= $varFamilyDetailRes['Brothers'];
			$varBrothersMarried		= $varFamilyDetailRes['Brothers_Married'];
			$varSisters				= $varFamilyDetailRes['Sisters'];
			$varSistersMarried		= $varFamilyDetailRes['Sisters_Married'];
			$varAboutMyFamily		= addslashes(strip_tags(trim($varFamilyDetailRes['About_Family'])));

			//get hobbies detail
			$argFields			= array('Hobbies_Selected','Hobbies_Others','Interests_Selected','Interests_Others','Music_Selected','Music_Others','Books_Selected','Books_Others','Movies_Selected','Movies_Others','Sports_Selected','Sports_Others','Food_Selected','Food_Others','Dress_Style_Selected','Dress_Style_Others','Languages_Selected','Languages_Others');
			$argCondition		= " WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$varHobbiesDetail	= $objAdminMailer->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
			$varHobbiesDetailRes= mysql_fetch_assoc($varHobbiesDetail);

			$varHobbiesSelect		= addslashes(strip_tags(trim($varHobbiesDetailRes['Hobbies_Selected'])));
			$varHobbiesOthers		= addslashes(strip_tags(trim($varHobbiesDetailRes['Hobbies_Others'])));
			$varInterestSelected	= addslashes(strip_tags(trim($varHobbiesDetailRes['Interests_Selected'])));
			$varInterestOthers		= addslashes(strip_tags(trim($varHobbiesDetailRes['Interests_Others'])));
			$varMusicselected		= addslashes(strip_tags(trim($varHobbiesDetailRes['Music_Selected'])));
			$varMusicOthers			= addslashes(strip_tags(trim($varHobbiesDetailRes['Music_Others'])));
			$varbooksSelected		= addslashes(strip_tags(trim($varHobbiesDetailRes['Books_Selected'])));
			$varBookOthers			= addslashes(strip_tags(trim($varHobbiesDetailRes['Books_Others'])));
			$varMoviesSelected		= addslashes(strip_tags(trim($varHobbiesDetailRes['Movies_Selected'])));
			$varMoviesOthers		= addslashes(strip_tags(trim($varHobbiesDetailRes['Movies_Others'])));
			$varSportsSelected		= addslashes(strip_tags(trim($varHobbiesDetailRes['Sports_Selected'])));
			$varSportsOthers		= addslashes(strip_tags(trim($varHobbiesDetailRes['Sports_Others'])));
			$varFoodSelected		= addslashes(strip_tags(trim($varHobbiesDetailRes['Food_Selected'])));
			$varFoodOthers			= addslashes(strip_tags(trim($varHobbiesDetailRes['Food_Others'])));
			$varDressStyleSelected	= addslashes(strip_tags(trim($varHobbiesDetailRes['Dress_Style_Selected'])));
			$varDressStyleOthers	= addslashes(strip_tags(trim($varHobbiesDetailRes['Dress_Style_Others'])));
			$varLanguageSelected	= addslashes(strip_tags(trim($varHobbiesDetailRes['Languages_Selected'])));
			$varLanguageOthers		= addslashes(strip_tags(trim($varHobbiesDetailRes['Languages_Others'])));

			//get partner detail
			$argFields			= array('Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Weight_From','Weight_To','Physical_Status','Education','Employed_In','Occupation','Religion','Denomination','CasteId','SubcasteId','GothramId','Star','Raasi','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_USA_State','Resident_District','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits');
			$argCondition		= " WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$varPartnerDetail	= $objAdminMailer->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
			$varPartnerDetailRes= mysql_fetch_assoc($varPartnerDetail);

			$varPartnerAge_From				= $varPartnerPartnerDetailRes['Age_From'];
			$varPartnerAge_To				= $varPartnerPartnerDetailRes['Age_To'];
			$varPartnerLooking_Status		= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Looking_Status'])));
			$varPartnerHave_Children		= $varPartnerPartnerDetailRes['Have_Children'];
			$varPartnerHeight_From			= $varPartnerPartnerDetailRes['Height_From'];
			$varPartnerHeight_To			= $varPartnerPartnerDetailRes['Height_To'];
			$varPartnerWeight_From			= $varPartnerPartnerDetailRes['Weight_From'];
			$varPartnerWeight_To			= $varPartnerPartnerDetailRes['Weight_To'];
			$varPartnerPhysical_Status		= $varPartnerPartnerDetailRes['Physical_Status'];
			$varPartnerEducation			= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Education'])));
			$varPartnerEmployed_In			= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Employed_In'])));
			$varPartnerOccupation			= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Occupation'])));
			$varPartnerReligion				= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Religion'])));
			$varPartnerDenomination			= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Denomination'])));
			$varPartnerCasteId				= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['CasteId'])));
			$varPartnerSubcasteId			= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['SubcasteId'])));
			$varPartnerGothramId			= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['GothramId'])));
			$varPartnerStar					= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Star'])));
			$varPartnerRaasi				= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Raasi'])));
			$varPartnerChevvai_Dosham		= $varPartnerPartnerDetailRes['Chevvai_Dosham'];
			$varPartnerCitizenship			= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Citizenship'])));
			$varPartnerCountry				= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Country'])));
			$varPartnerResident_India_State = addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Resident_India_State'])));
			$varPartnerResident_USA_State	= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Resident_USA_State'])));
			$varPartnerResident_District	= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Resident_District'])));
			$varPartnerResident_Status		= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Resident_Status'])));
			$varPartnerMother_Tongue		= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Mother_Tongue'])));
			$varPartnerDesDescription		= addslashes(strip_tags(trim($varPartnerPartnerDetailRes['Partner_Description'])));
			$varPartnerEating_Habits		= $varPartnerPartnerDetailRes['Eating_Habits'];
			$varPartnerDrinking_Habits		= $varPartnerPartnerDetailRes['Drinking_Habits'];
			$varPartnerSmoking_Habits		= $varPartnerPartnerDetailRes['Smoking_Habits'];

			//get photo & horo detail
			$argFields			= array('Normal_Photo1','Description1','Thumb_Small_Photo1','Thumb_Big_Photo1','Photo_Status1','Normal_Photo2','Description2','Thumb_Small_Photo2','Thumb_Big_Photo2','Photo_Status2','Normal_Photo3','Description3','Thumb_Small_Photo3','Thumb_Big_Photo3','Photo_Status3','Photo_Date_Updated','HoroscopeURL','HoroscopeDescription','HoroscopeStatus','Horoscope_Date_Updated');
			$argCondition		= " WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$varPhotoDetail	= $objAdminMailer->select($varTable['MEMBERPHOTOINFO'],$argFields,$argCondition,0);
			$varPhotoDetailRes= mysql_fetch_assoc($varPhotoDetail);

			$varPhNormal_Photo1				= addslashes(strip_tags(trim($varPhotoDetailRes['Normal_Photo1'])));
			$varPhDescription1				= addslashes(strip_tags(trim($varPhotoDetailRes['Description1'])));
			$varPhThumb_Small_Photo1		= addslashes(strip_tags(trim($varPhotoDetailRes['Thumb_Small_Photo1'])));
			$varPhThumb_Big_Photo1			= addslashes(strip_tags(trim($varPhotoDetailRes['Thumb_Big_Photo1'])));
			$varPhPhoto_Status1				= $varPhotoDetailRes['Photo_Status1'];
			$varPhNormal_Photo2				= addslashes(strip_tags(trim($varPhotoDetailRes['Normal_Photo2'])));
			$varPhDescription2				= addslashes(strip_tags(trim($varPhotoDetailRes['Description2'])));
			$varPhThumb_Small_Photo2		= addslashes(strip_tags(trim($varPhotoDetailRes['Thumb_Small_Photo2'])));
			$varPhThumb_Big_Photo2			= addslashes(strip_tags(trim($varPhotoDetailRes['Thumb_Big_Photo2'])));
			$varPhPhoto_Status2				= $varPhotoDetailRes['Photo_Status2'];
			$varPhNormal_Photo3				= addslashes(strip_tags(trim($varPhotoDetailRes['Normal_Photo3'])));
			$varPhDescription3				= addslashes(strip_tags(trim($varPhotoDetailRes['Description3'])));
			$varPhThumb_Small_Photo3		= addslashes(strip_tags(trim($varPhotoDetailRes['Thumb_Small_Photo3'])));
			$varPhThumb_Big_Photo3			= addslashes(strip_tags(trim($varPhotoDetailRes['Thumb_Big_Photo3'])));
			$varPhPhoto_Status3				= $varPhotoDetailRes['Photo_Status3'];
			$varPhPhoto_Date_Updated		= $varPhotoDetailRes['Photo_Date_Updated'];
			$varPhHoroscopeURL				= addslashes(strip_tags(trim($varPhotoDetailRes['HoroscopeURL'])));
			$varPhHoroscopeDescription		= addslashes(strip_tags(trim($varPhotoDetailRes['HoroscopeDescription'])));
			$varPhHoroscopeStatus			= $varPhotoDetailRes['HoroscopeStatus'];
			$varPhHoroscope_Date_Updated	= $varPhotoDetailRes['Horoscope_Date_Updated'];


			//INSERT INTO ignoreinfodetail
			$argFields 				= array('CommunityId','MatriId','Name','Nick_Name','Age','Email','Password','Gender','Height','Height_Unit','Weight','Weight_Unit','Body_Type','Appearance','Complexion','Physical_Status','Disability_Cause','Disability_Type','Disability_Severity','Disability_Product_Used','Sign_Language','Blood_Group','Marital_Status','No_Of_Children','Children_Living_Status','Education_Category','Education_Subcategory','Education_Detail','Employed_In','Occupation','Occupation_Detail','Income_Currency','Annual_Income','Religion','Denomination','DenominationText','CasteId','CasteText','Caste_Nobar','Subcaste_Nobar','SubcasteId','SubcasteText','Mother_TongueId','Mother_TongueText','GothramId','GothramText','Star','Raasi','Horoscope_Match','Chevvai_Dosham','Religious_Values','Ethnicity','Resident_Status','Country','Citizenship','Residing_State','Residing_Area','Residing_District','Residing_City','Contact_Phone','Contact_Mobile','About_Myself','Eating_Habits','Smoke','Drink','Profile_Created_By','Paid_Status','Special_Priv','Phone_Verified','Phone_Protected','Hobbies_Available','Horoscope_Available','Horoscope_Protected','Photo_Set_Status','Protect_Photo_Set_Status','Partner_Set_Status','Family_Set_Status','Interest_Set_Status','Physical_Set_Status','Date_Created','Time_Posted','Date_Updated','Last_Login','Validated_By','Family_Value','Family_Type','Family_Status','Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family','Hobbies_Selected','Hobbies_Others','Interests_Selected','Interests_Others','Music_Selected','Music_Others','Books_Selected','Books_Others','Movies_Selected','Movies_Others','Sports_Selected','Sports_Others','Food_Selected','Food_Others','Dress_Style_Selected','Dress_Style_Others','Languages_Selected','Languages_Others','Age_From','Age_To','Looking_Status','PartnerHave_Children','PartnerHeight_From','PartnerHeight_To','PartnerWeight_From','PartnerWeight_To','PartnerPhysical_Status','PartnerEducation','PartnerEmployed_In','PartnerOccupation','PartnerReligion','PartnerDenomination','PartnerCasteId','PartnerSubcasteId','PartnerGothramId','PartnerStar','PartnerRaasi','PartnerChevvai_Dosham','PartnerCitizenship','PartnerCountry','PartnerResident_India_State','PartnerResident_USA_State','PartnerResident_District','PartnerResident_Status','PartnerMother_Tongue','Partner_Description','PartnerEating_Habits','PartnerDrinking_Habits','PartnerSmoking_Habits','Normal_Photo1','Description1','Thumb_Small_Photo1','Thumb_Big_Photo1','Photo_Status1','Normal_Photo2','Description2','Thumb_Small_Photo2','Thumb_Big_Photo2','Photo_Status2','Normal_Photo3','Description3','Thumb_Small_Photo3','Thumb_Big_Photo3','Photo_Status3','Photo_Date_Updated','HoroscopeURL','HoroscopeDescription','HoroscopeStatus','Horoscope_Date_Updated','Support_Comments');
			$argFieldsValues		= array($objMaster->doEscapeString($varCommunityId,$objMaster),$objMaster->doEscapeString($varMatriId,$objMaster),$objMaster->doEscapeString($varName,$objMaster),$objMaster->doEscapeString($varNickName,$objMaster),$objMaster->doEscapeString($varAge,$objMaster),$objMaster->doEscapeString($varEmail,$objMaster),$objMaster->doEscapeString($varPassword,$objMaster),$objMaster->doEscapeString($varGender,$objMaster),$objMaster->doEscapeString($varHeight,$objMaster),$objMaster->doEscapeString($varHeightUnit,$objMaster),$objMaster->doEscapeString($varWeight,$objMaster),$objMaster->doEscapeString($varWeightUnit,$objMaster),$objMaster->doEscapeString($varBodyType,$objMaster),$objMaster->doEscapeString($varAppearance,$objMaster),$objMaster->doEscapeString($varComplexion,$objMaster),$objMaster->doEscapeString($varPhyicalStatus,$objMaster),$objMaster->doEscapeString($varDisabilityCause,$objMaster),$objMaster->doEscapeString($varDisabilityType,$objMaster),$objMaster->doEscapeString($varDisabilitySeverity,$objMaster),$objMaster->doEscapeString($varDisabilityProductUsed,$objMaster),$objMaster->doEscapeString($varSignLanguage,$objMaster),$objMaster->doEscapeString($varBloodGroup,$objMaster),$objMaster->doEscapeString($varMaritalStatus,$objMaster),$objMaster->doEscapeString($varNoOfChildren,$objMaster),$objMaster->doEscapeString($varChildrenLivingStatus,$objMaster),$objMaster->doEscapeString($varEducationCategory,$objMaster),$objMaster->doEscapeString($varEducationSubcategory,$objMaster),$objMaster->doEscapeString($varEducationDetail,$objMaster),$objMaster->doEscapeString($varEmployedIn,$objMaster),$objMaster->doEscapeString($varOccupation,$objMaster),$objMaster->doEscapeString($varOccupationDetail,$objMaster),$objMaster->doEscapeString($varIncomeCurrency,$objMaster),$objMaster->doEscapeString($varAnnualIncome,$objMaster),$objMaster->doEscapeString($varReligion,$objMaster),$objMaster->doEscapeString($varDenomination,$objMaster),$objMaster->doEscapeString($varDenominationTxt,$objMaster),$objMaster->doEscapeString($varCasteId,$objMaster),$objMaster->doEscapeString($varCasteTxt,$objMaster),$objMaster->doEscapeString($varCasteNoBar,$objMaster),$objMaster->doEscapeString($varSubcasteNoBar,$objMaster),$objMaster->doEscapeString($varSubcasteId,$objMaster),$objMaster->doEscapeString($varSubcasteTxt,$objMaster),$objMaster->doEscapeString($varMotherTongueId,$objMaster),$objMaster->doEscapeString($varMotherTongueTxt,$objMaster),$objMaster->doEscapeString($varGothramId,$objMaster),$objMaster->doEscapeString($varGothramTxt,$objMaster),$objMaster->doEscapeString($varStar,$objMaster),$objMaster->doEscapeString($varRaasi,$objMaster),$objMaster->doEscapeString($varhoroscopeMatch,$objMaster),$objMaster->doEscapeString($varChevvaiDosham,$objMaster),$objMaster->doEscapeString($varReligiousValues,$objMaster),$objMaster->doEscapeString($varEthnicity,$objMaster),$objMaster->doEscapeString($varResidentStatus,$objMaster),$objMaster->doEscapeString($varCountry,$objMaster),$objMaster->doEscapeString($varCitizenship,$objMaster),$objMaster->doEscapeString($varResidentState,$objMaster),$objMaster->doEscapeString($varResidingArea,$objMaster),$objMaster->doEscapeString($varResidingDistrice,$objMaster),$objMaster->doEscapeString($varResidingCity,$objMaster),$objMaster->doEscapeString($varContactPhone,$objMaster),$objMaster->doEscapeString($varContactMobile,$objMaster),$objMaster->doEscapeString($varAboutMySelf,$objMaster),$objMaster->doEscapeString($varEatingHabits,$objMaster),$objMaster->doEscapeString($varSmoke,$objMaster),$objMaster->doEscapeString($varDrink,$objMaster),$objMaster->doEscapeString($varProfileCreatedBy,$objMaster),$objMaster->doEscapeString($varPaidStatus,$objMaster),$objMaster->doEscapeString($varSpecialPriv,$objMaster),$objMaster->doEscapeString($varPhoneVerified,$objMaster),$objMaster->doEscapeString($varPhoneProtected,$objMaster),$objMaster->doEscapeString($varHobbiesAvailable,$objMaster),$objMaster->doEscapeString($varHoroAvaialble,$objMaster),$objMaster->doEscapeString($varHoroProtected,$objMaster),$objMaster->doEscapeString($varPhotoSetStatus,$objMaster),$objMaster->doEscapeString($varPhotoProtectStatus,$objMaster),$objMaster->doEscapeString($varPartnerSetStatus,$objMaster),$objMaster->doEscapeString($varFamilySetStatus,$objMaster),$objMaster->doEscapeString($varInterestSetStatus,$objMaster),$objMaster->doEscapeString($varPhysicalSetStatus,$objMaster),$objMaster->doEscapeString($varDateCreated,$objMaster),$objMaster->doEscapeString($varTimePosted,$objMaster),$objMaster->doEscapeString($varDateUpdated,$objMaster),$objMaster->doEscapeString($varLastLogin,$objMaster),$objMaster->doEscapeString($varValidatedby,$objMaster),$objMaster->doEscapeString($varFamilyValue,$objMaster),$objMaster->doEscapeString($varfamilyype,$objMaster),$objMaster->doEscapeString($varFamilystatus,$objMaster),$objMaster->doEscapeString($varFatherOccupation,$objMaster),$objMaster->doEscapeString($varMotherOccupation,$objMaster),$objMaster->doEscapeString($varFamilyOrigin,$objMaster),$objMaster->doEscapeString($varBrothers,$objMaster),$objMaster->doEscapeString($varBrothersMarried,$objMaster),$objMaster->doEscapeString($varSisters,$objMaster),$objMaster->doEscapeString($varSistersMarried,$objMaster),$objMaster->doEscapeString($varAboutMyFamily,$objMaster),$objMaster->doEscapeString($varHobbiesSelect,$objMaster),$objMaster->doEscapeString($varHobbiesOthers,$objMaster),$objMaster->doEscapeString($varInterestSelected,$objMaster),$objMaster->doEscapeString($varInterestOthers,$objMaster),$objMaster->doEscapeString($varMusicselected,$objMaster),$objMaster->doEscapeString($varMusicOthers,$objMaster),$objMaster->doEscapeString($varbooksSelected,$objMaster),$objMaster->doEscapeString($varBookOthers,$objMaster),$objMaster->doEscapeString($varMoviesSelected,$objMaster),$objMaster->doEscapeString($varMoviesOthers,$objMaster),$objMaster->doEscapeString($varSportsSelected,$objMaster),$objMaster->doEscapeString($varSportsOthers,$objMaster),$objMaster->doEscapeString($varFoodSelected,$objMaster),$objMaster->doEscapeString($varFoodOthers,$objMaster),$objMaster->doEscapeString($varDressStyleSelected,$objMaster),$objMaster->doEscapeString($varDressStyleOthers,$objMaster),$objMaster->doEscapeString($varLanguageSelected,$objMaster),$objMaster->doEscapeString($varLanguageOthers,$objMaster),$objMaster->doEscapeString($varPartnerAge_From,$objMaster),$objMaster->doEscapeString($varPartnerAge_To,$objMaster),$objMaster->doEscapeString($varPartnerLooking_Status,$objMaster),$objMaster->doEscapeString($varPartnerHave_Children,$objMaster),$objMaster->doEscapeString($varPartnerHeight_From,$objMaster),$objMaster->doEscapeString($varPartnerHeight_To,$objMaster),$objMaster->doEscapeString($varPartnerWeight_From,$objMaster),$objMaster->doEscapeString($varPartnerWeight_To,$objMaster),$objMaster->doEscapeString($varPartnerPhysical_Status,$objMaster),$objMaster->doEscapeString($varPartnerEducation,$objMaster),$objMaster->doEscapeString($varPartnerEmployed_In,$objMaster),$objMaster->doEscapeString($varPartnerOccupation,$objMaster),$objMaster->doEscapeString($varPartnerReligion,$objMaster),$objMaster->doEscapeString($varPartnerDenomination,$objMaster),$objMaster->doEscapeString($varPartnerCasteId,$objMaster),$objMaster->doEscapeString($varPartnerSubcasteId,$objMaster),$objMaster->doEscapeString($varPartnerGothramId,$objMaster),$objMaster->doEscapeString($varPartnerStar,$objMaster),$objMaster->doEscapeString($varPartnerRaasi,$objMaster),$objMaster->doEscapeString($varPartnerChevvai_Dosham,$objMaster),$objMaster->doEscapeString($varPartnerCitizenship,$objMaster),$objMaster->doEscapeString($varPartnerCountry,$objMaster),$objMaster->doEscapeString($varPartnerResident_India_State,$objMaster),$objMaster->doEscapeString($varPartnerResident_USA_State,$objMaster),$objMaster->doEscapeString($varPartnerResident_District,$objMaster),$objMaster->doEscapeString($varPartnerResident_Status,$objMaster),$objMaster->doEscapeString($varPartnerMother_Tongue,$objMaster),$objMaster->doEscapeString($varPartnerDesDescription,$objMaster),$objMaster->doEscapeString($varPartnerEating_Habits,$objMaster),$objMaster->doEscapeString($varPartnerDrinking_Habits,$objMaster),$objMaster->doEscapeString($varPartnerSmoking_Habits,$objMaster),$objMaster->doEscapeString($varPhNormal_Photo1,$objMaster),$objMaster->doEscapeString($varPhDescription1,$objMaster),$objMaster->doEscapeString($varPhThumb_Small_Photo1,$objMaster),$objMaster->doEscapeString($varPhThumb_Big_Photo1,$objMaster),$objMaster->doEscapeString($varPhPhoto_Status1,$objMaster),$objMaster->doEscapeString($varPhNormal_Photo2,$objMaster),$objMaster->doEscapeString($varPhDescription2,$objMaster),$objMaster->doEscapeString($varPhThumb_Small_Photo2,$objMaster),$objMaster->doEscapeString($varPhThumb_Big_Photo2,$objMaster),$objMaster->doEscapeString($varPhPhoto_Status2,$objMaster),$objMaster->doEscapeString($varPhNormal_Photo3,$objMaster),$objMaster->doEscapeString($varPhDescription3,$objMaster),$objMaster->doEscapeString($varPhThumb_Small_Photo3,$objMaster),$objMaster->doEscapeString($varPhThumb_Big_Photo3,$objMaster),$objMaster->doEscapeString($varPhPhoto_Status3,$objMaster),$objMaster->doEscapeString($varPhPhoto_Date_Updated,$objMaster),$objMaster->doEscapeString($varPhHoroscopeURL,$objMaster),$objMaster->doEscapeString($varPhHoroscopeDescription,$objMaster),$objMaster->doEscapeString($varPhHoroscopeStatus,$objMaster),$objMaster->doEscapeString($varPhHoroscope_Date_Updated,$objMaster),$objMaster->doEscapeString($varComment,$objMaster));
			$varIgnoreDetailInsertId	= $objMaster->insert($varTable['IGNOREINFODETAIL'],$argFields,$argFieldsValues);

			$argCondition	= "MatriId=".$objMaster->doEscapeString($varMatriId,$objMaster);
			//DELETE blockinfo INFO
			$objMaster->delete($varTable['BLOCKINFO'],$argCondition);

			//DELETE bookmarkinfo INFO
			$objMaster->delete($varTable['BOOKMARKINFO'],$argCondition);

			//DELETE ignoreinfo INFO
			$objMaster->delete($varTable['IGNOREINFO'],$argCondition);

			//DELETE interestsenttrackinfo INFO
			$objMaster->delete($varTable['INTERESTSENTTRACKINFO'],$argCondition);

			//DELETE maildraftinfo INFO
			$objMaster->delete($varTable['MAILDRAFTINFO'],$argCondition);

			//DELETE mailfolderinfo INFO
			$objMaster->delete($varTable['MAILFOLDERINFO'],$argCondition);

			//DELETE mailmanagerinfo INFO
			$objMaster->delete($varTable['MAILMANAGERINFO'],$argCondition);

			//DELETE mailsenttrackinfo INFO
			$objMaster->delete($varTable['MAILSENTTRACKINFO'],$argCondition);

			//DELETE memberactioninfo INFO
			$objMaster->delete($varTable['MEMBERACTIONINFO'],$argCondition);

			//DELETE memberfamilyinfo INFO
			$objMaster->delete($varTable['MEMBERFAMILYINFO'],$argCondition);

			//DELETE memberhobbiesinfo INFO
			$objMaster->delete($varTable['MEMBERHOBBIESINFO'],$argCondition);

			//DELETE memberfilterinfo INFO
			$objMaster->delete($varTable['MEMBERFILTERINFO'],$argCondition);

			//DELETE memberinfo INFO
			$objMaster->delete($varTable['MEMBERINFO'],$argCondition,$varProfileMCKey);

			//DELETE memberlogininfo INFO
			$objMaster->delete($varTable['MEMBERLOGININFO'],$argCondition);

			//DELETE memberpartnerinfo INFO
			$objMaster->delete($varTable['MEMBERPARTNERINFO'],$argCondition);

			//DELETE memberphotoinfo INFO
			$objMaster->delete($varTable['MEMBERPHOTOINFO'],$argCondition);

			//DELETE memberprofileviewedinfo INFO
			$objMaster->delete($varTable['MEMBERPROFILEVIEWEDINFO'],$argCondition);

			//DELETE memberstatistics INFO
			$objMaster->delete($varTable['MEMBERSTATISTICS'],$argCondition);

			//DELETE memberupdatedinfo INFO
			$objMaster->delete($varTable['MEMBERUPDATEDINFO'],$argCondition);

			//DELETE searchsavedinfo INFO
			$objMaster->delete($varTable['SEARCHSAVEDINFO'],$argCondition);

			//DELETE requestinfosent INFO
			$argCondition	= "SenderId='".$matriId."'";
			$objMaster->delete($varTable['REQUESTINFOSENT'],$argCondition);

			//DELETE requestinforeceived INFO
			$argCondition	= "ReceiverId='".$matriId."'";
			$objMaster->delete($varTable['REQUESTINFORECEIVED'],$argCondition);
			
			
		}

		//update validation report
		$argFields 			= array('comments','profilestatus','timetaken','validateddate');
		$argFieldsValues	= array($objMaster->doEscapeString($adminComment,$objMaster),$objMaster->doEscapeString($varStatus,$objMaster),$varTimeTaken,"NOW()");
		$argCondition	= " id=".$objMaster->doEscapeString($varReportId,$objMaster)." AND matriid=".$objMaster->doEscapeString($matriId,$objMaster)." AND userid=".$objMaster->doEscapeString($adminUserName,$objMaster);
		$varUpdateId		= $objMaster->update($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues,$argCondition);
		
		//echo "<div class='smalltxtadmin' width='500' align='center'>".$varMessage."</div>";
		if(((!isset($_REQUEST['stopprofile']))&&(!isset($_REQUEST['id']))) || ((!isset($_REQUEST['stopprofile']))&&(isset($_REQUEST['suppid']))))
		{				
			echo '<script language="javascript">document.location.href ="index.php?act=shuffled_profile_validation"; </script>';exit;
		}
}
/////////////////////////////////////////////////// After form submission end here /////////////////////////////////////////////

 if($_REQUEST['stopprofile']=='') {
	//check matriid is available or not this session user
	if($varRequestMatriId!='' && $_REQUEST['reqFromPg']=='profileval') {
		$varSingleId	= $varRequestMatriId;
		$varReportId	= $_REQUEST['suppid'];
	} else if($varRequestMatriId!='') {
		$argFields 			= array('Publish');
		$argCondition		= " WHERE MatriId=".$objMaster->doEscapeString($varRequestMatriId,$objMaster);
		$varMemberInfoResult= $objMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varMemberInfoResCnt= mysql_num_rows($varMemberInfoResult);

		if($varMemberInfoResCnt>0) {
			$varMemberInfoRes = mysql_fetch_assoc($varMemberInfoResult);
			if($varMemberInfoRes['Publish']!=0) {
				$varErrorMessage	= "The Profile Has been Validated";
			} else {
				$varQuery	= "INSERT IGNORE INTO ".$varTable['SUPPORT_VALIDATIONQ']." (MatriId,Paid_Status,Date_Created) SELECT MatriId,Paid_Status,Date_Created FROM  ".$varTable['MEMBERINFO']." WHERE MatriId=".$objMaster->doEscapeString($varRequestMatriId,$objMaster)." AND Publish=0";
				$objMaster->ExecuteQryResult($varQuery);

				//update support_validationq
				$argFields 		= array('Validation_Status','Date_Added');
				$argFieldsValues= array(1,"NOW()");
				$argCondition	= " MatriId='".$varRequestMatriId."'";
				$varUpdateId	= $objMaster->update($varTable['SUPPORT_VALIDATIONQ'],$argFields,$argFieldsValues,$argCondition);

				//inert into support validation report table
				$argFields			= array('matriid','userid','downloadeddate','reporttype');
				$argFieldsValues	= array($objMaster->doEscapeString($varRequestMatriId,$objMaster),$objMaster->doEscapeString($adminUserName,$objMaster),"NOW()",1);
				$varSupportInsertId	= $objMaster->insert($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues);


				$varSingleId		= $varRequestMatriId;
				$varReportId	    = $varSupportInsertId;
			}
		} else {
			$varErrorMessage	= "This MatriId is not available";
		}
	} 

if((($_REQUEST['MatriId']!='')&&(isset($_REQUEST['page'])))||($varRequestMatriId!='')) {
		if($varRequestMatriId!=''){
			$varDisplayMatriId	= $varRequestMatriId;
		}else{
			$varDisplayMatriId	= $_REQUEST['MatriId'];
		}

		$argFields		= array('User_Name','MatriId','Country','Name','Nick_Name','Age','Gender','Religion','Annual_Income','Income_Currency','Residing_Area','Residing_City','Contact_Address','Marital_Status','Date_Created','About_Myself','Education_Detail','Occupation_Detail','CommunityId','Denomination','DenominationText','CasteId','CasteText','SubcasteId','SubcasteText','GothramId','GothramText','Mother_TongueId','Mother_TongueText','Contact_Phone','Contact_Mobile','About_MyPartner','Paid_Status');
		$argCondition	= "WHERE MatriId=".$objAdminMailer->doEscapeString($varDisplayMatriId,$objAdminMailer);
		$varNewProfileDetailsRes	= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varTotalRow	= mysql_num_rows($varNewProfileDetailsRes);

		if($varTotalRow>0) {
			$varNewProfileDetails		= mysql_fetch_assoc($varNewProfileDetailsRes);

			$varTotalTable				= "";
			$varTotalTable				.= '<form name="frmAddedProfile" method="post"  onsubmit="return radio_button_checker()">';
			$varTotalTable				.= '<input type="hidden" name="frmAddedProfileSubmit" value="">';
			$varTotalTable				.= '<input type="hidden" name="elapsedtime" value="">';
			$varTotalTable				.= '<input type="hidden" name="reportid" value="'.$varReportId.'">';
			$varTotalTable				.= '<input type="hidden" name="paidstatus" value="'.$varNewProfileDetails['Paid_Status'].'">';

			$argCondition				= "WHERE MatriId=".$objAdminMailer->doEscapeString($varNewProfileDetails['MatriId'],$objAdminMailer);
			$argFields					= array('Support_Comments');
			$varadminCommentsRes		= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$varadminComments			= mysql_fetch_assoc($varadminCommentsRes);

			$argFields					= array('Father_Occupation','Mother_Occupation','Family_Origin','About_Family');
			$argCondition				= "WHERE MatriId=".$objAdminMailer->doEscapeString($varNewProfileDetails['MatriId'],$objAdminMailer)."ORDER BY Date_Updated";
			$varFamilyInfoRes			= $objAdminMailer->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
			$varFamilyInfo				= mysql_fetch_assoc($varFamilyInfoRes);

			$argFields					= array('Hobbies_Others','Interests_Others','Music_Others','Books_Others','Movies_Others','Sports_Others','Food_Others','Dress_Style_Others','Languages_Others');
			$argCondition				= "WHERE MatriId=".$objAdminMailer->doEscapeString($varNewProfileDetails['MatriId'],$objAdminMailer)." ORDER BY Date_Updated";
			$varHobbiesInfoRes			= $objAdminMailer->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
			$varHobbiesInfo				= mysql_fetch_assoc($varHobbiesInfoRes);

			$argFields					= array('Partner_Description');
			$argCondition				= "WHERE MatriId=".$objAdminMailer->doEscapeString($varNewProfileDetails['MatriId'],$objAdminMailer)." ORDER BY Date_Updated";
			$varPartnerDescriptionRes	= $objAdminMailer->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
			$varPartnerDescription		= mysql_fetch_assoc($varPartnerDescriptionRes);
			//echo '<pre>'; print_r($varPartnerDescription); echo '</pre>';

		   // Done by barani //
			   $Ipaddress= $objProfileDetail->getProfileIpAddress($varNewProfileDetails['MatriId']);
			   $varGetCountry = getCountry($Ipaddress);
			   $varCountryLocation = (in_array($varGetCountry->country_short,$varSpecialCountries))?('<label class=smalltxt><font color="red">'.$varGetCountry->country_long.'</font></label>'):($varGetCountry->country_long);
			// end //

			if($varNewProfileDetails['Paid_Status'] == 1)
			  $varPaidStatusval = 'Paid';
			else
			  $varPaidStatusval = 'Free';

			 $varTotalTable .= '<tr><td><table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="542" align="center"><tr><td valign="top" class="smalltxt boldtxt" colspan="4" style="padding-left:10px;">MatriId : <a href="'.$confValues['SERVERURL'].'/admin/index.php?act=view-profile1&actstatus=yes&matrimonyId='.$varNewProfileDetails['MatriId'].'" class="smalltxt boldtxt heading" target="_blank">'.$varNewProfileDetails['MatriId'].'</a>&nbsp;&nbsp;&nbsp;Registered from IP :'.$varCountryLocation.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time limit <input type="text" size="5" name="counttime" value="" readonly=true></td></tr>';
			 $varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Display Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3">'.$varNewProfileDetails['Nick_Name'].'</td></tr>';
			 $varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Paid Status :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3">'.$varPaidStatusval.'</td></tr>';
			 $varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Name:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			 $varTotalTable .= $varNewProfileDetails['Name']!=""? $varNewProfileDetails['Name'] : "-";
			 $varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Age:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Age'] ? $varNewProfileDetails['Age'] :  "-";
			$varTotalTable .= '</td></tr>';

			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Email:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';

			//get email for particular matri id
			$argFields				= array('Email');
			$argCondition			= "WHERE MatriId='".$varNewProfileDetails['MatriId']."'";
			$varMemberEmailRes		= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
			$varMemberEmail			= mysql_fetch_assoc($varMemberEmailRes);

			$varEmail				= $varMemberEmail['Email'];
			$varValidateEmail		= emailValidation($varEmail);

			$varTotalTable .= '<b><font color="blue">'.$varEmail."</font></b>&nbsp;&nbsp;";
			$varTotalTable .= $varValidateEmail ? "<font color='green'><b>Valid</b></font>" : "<font color='red'><b>Invalid</b></font>";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Gender:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails["Gender"]==2 ? "Female" : "Male";

			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			if($varNewProfileDetails['About_Myself']!="") {
			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">About Myself:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= $varNewProfileDetails['About_Myself']!=""? $varNewProfileDetails['About_Myself'] : "-";
			$varTotalTable .= '</td></tr>';
			}

			if(($varNewProfileDetails['DenominationText']!=""))
			{
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Denomination:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['DenominationText']!=''? $varNewProfileDetails['DenominationText'] : "-";
			$varTotalTable .= '</td>';
			}


			if(($varNewProfileDetails['CasteText']!="") || ($varNewProfileDetails['SubcasteText']!=""))
			{
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Caste:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['CasteText']!=''? $varNewProfileDetails['CasteText'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Subcaste:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['SubcasteText'] !='' ? $varNewProfileDetails['SubcasteText'] :  "-";
			$varTotalTable .= '</td></tr>';
			}

			if(($varNewProfileDetails['GothramText']!="") || ($varNewProfileDetails['Mother_TongueText']!=""))
			{
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Gothram:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['GothramText']!=''? $varNewProfileDetails['GothramText'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Mother Tongue:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Mother_TongueText'] !='' ? $varNewProfileDetails['Mother_TongueText'] :  "-";
			$varTotalTable .= '</td></tr>';
			}
			if($varNewProfileDetails['Annual_Income']!=0)
			{
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Annual Income:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= $varNewProfileDetails['Annual_Income'].'&nbsp;&nbsp;'.$arrSelectCurrencyList[$varNewProfileDetails['Income_Currency']];
			$varTotalTable .= '</td></tr>';
			}
			if(($varNewProfileDetails['Education_Detail']!="") || ($varNewProfileDetails['Occupation_Detail'])) {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Education In Detail:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Education_Detail']!=""? $varNewProfileDetails['Education_Detail'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Occupation In Detail:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Occupation_Detail'] ? $varNewProfileDetails['Occupation_Detail'] :  "-";
			$varTotalTable .= '</td></tr>';
			}
			if(($varNewProfileDetails['Contact_Phone']!="") || ($varNewProfileDetails['Contact_Mobile'])) {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Phone:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Contact_Phone']!=""? $varNewProfileDetails['Contact_Phone'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Mobile:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Contact_Mobile'] !='' ? $varNewProfileDetails['Contact_Mobile'] :  "-";
			$varTotalTable .= '</td></tr>';
			}

			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF">';
			if($varNewProfileDetails['Country']!= 222 && $varNewProfileDetails['Country']!= 98) {
			$varTotalTable .= '<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing State:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Residing_Area']!=""? $varNewProfileDetails['Residing_Area'] : "-";
			$varTotalTable .= '</td>';
			}
			if($varNewProfileDetails['Country']!= 98) {
			$varTotalTable .= '<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing City:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Residing_City'] ? $varNewProfileDetails['Residing_City'] :  "-";
			$varTotalTable .= '</td>';
			}
			$varTotalTable .= '</tr>';

			if(($varFamilyInfo['Father_Occupation']!="") || ($varFamilyInfo['Mother_Occupation'])) {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Father Occupation:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varFamilyInfo['Father_Occupation']!=""? $varFamilyInfo['Father_Occupation'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Mother Occupation:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varFamilyInfo['Mother_Occupation'] !='' ? $varFamilyInfo['Mother_Occupation'] :  "-";
			$varTotalTable .= '</td></tr>';
			}

			if($varFamilyInfo['Family_Origin']!="") {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Family Origin:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= $varFamilyInfo['Family_Origin']!=""? $varFamilyInfo['Family_Origin'] : "-";
			$varTotalTable .= '</td></tr>';
			}

			if($varFamilyInfo['About_Family']!="") {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Family Description:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= $varFamilyInfo['About_Family']!=""? $varFamilyInfo['About_Family'] : "-";
			$varTotalTable .= '</td></tr>';
			}

			if(($varHobbiesInfo['Hobbies_Others']!="") || ($varHobbiesInfo['Interests_Others'])) {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Hobbies:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Hobbies_Others']!=""? $varHobbiesInfo['Hobbies_Others'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Interests:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Interests_Others'] !='' ? $varHobbiesInfo['Interests_Others'] :  "-";
			$varTotalTable .= '</td></tr>';
			}

			if(($varHobbiesInfo['Music_Others']!="") || ($varHobbiesInfo['Books_Others'])) {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Musics:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Music_Others']!=""? $varHobbiesInfo['Music_Others'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Books:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Books_Others'] !='' ? $varHobbiesInfo['Books_Others'] :  "-";
			$varTotalTable .= '</td></tr>';
			}

			if(($varHobbiesInfo['Movies_Others']!="") || ($varHobbiesInfo['Sports_Others'])) {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Movies:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Movies_Others']!=""? $varHobbiesInfo['Movies_Others'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Sports:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Sports_Others'] !='' ? $varHobbiesInfo['Sports_Others'] :  "-";
			$varTotalTable .= '</td></tr>';
			}

			if(($varHobbiesInfo['Food_Others']!="") || ($varHobbiesInfo['Dress_Style_Others'])) {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Cuisines:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Food_Others']!=""? $varHobbiesInfo['Food_Others'] : "-";
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Dress Styles:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varHobbiesInfo['Dress_Style_Others'] !='' ? $varHobbiesInfo['Dress_Style_Others'] :  "-";
			$varTotalTable .= '</td></tr>';
			}

			if($varHobbiesInfo['Languages_Others']!="") {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Languages:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= $varHobbiesInfo['Languages_Others']!=""? $varHobbiesInfo['Languages_Others'] : "-";
			$varTotalTable .= '</td></tr>';
			}



			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Marital Status:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $arrMaritalList[$varNewProfileDetails['Marital_Status']];
			$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Created Date:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
			$varTotalTable .= $varNewProfileDetails['Date_Created'] ? $varNewProfileDetails['Date_Created'] :  "-";
			$varTotalTable .= '</td></tr>';

			if($varNewProfileDetails['About_MyPartner']!="") {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Short Partner Description:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= $varNewProfileDetails['About_MyPartner']!=""? $varNewProfileDetails['About_MyPartner'] : "-";
			$varTotalTable .= '</td></tr>';
			}
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			if($varPartnerDescription['Partner_Description']!="") {
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Partner Description:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= $varPartnerDescription['Partner_Description']!=""? $varPartnerDescription['Partner_Description'] : "-";
			$varTotalTable .= '</td></tr>';
			}
			$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Comments:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= '<textarea name="adminComment"  rows="3" cols="35"></textarea></td></tr><tr><td colspan="4" height="10"></td></tr>';

			$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Predefined Comments:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
			$varTotalTable .= '<select class="combobox" name="predefcomment" style="width:250px;">';
			$varTotalTable .= '<option value="">Select</option>';
			foreach($arrProfileReject as $key=>$value) {
				$varTotalTable .='<option value="'.$key.'">'.$value.'</option>';
			}
			$varTotalTable .= '</select>';
			$varTotalTable .= '</td></tr><tr><td colspan="4" height="10"></td></tr>';

			// done by barani //
			//$varDuplicateEmailCount = getDuplicateEmails($varNewProfileDetails[MatriId],$varEmail);
			$varDuplicateEmailCount = $objProfileDetail->getDuplicateEmails($varNewProfileDetails['MatriId'],$varEmail);
			$varMatriId = $varNewProfileDetails['MatriId'];
			$varDuplicateEmailLink = ($varDuplicateEmailCount)? "<a href=# onClick=javascript:window.open('/admin/view-duplicate-emails.php?email=$varEmail&MatriId=$varMatriId','popup','width=500,height=620'); class='smalltxt boldtxt heading'>Duplicate Emails(".$varDuplicateEmailCount.")</a>&nbsp;&nbsp;|&nbsp;&nbsp;" : '';
			// end //

			$varTotalTable .= '<tr class="memonlsbg4"><td class=smalltxt colspan=4 style="padding:5px 5px 5px 5px" colspan="3"><input name="matriId" value="'.$varNewProfileDetails['MatriId'].'" type="hidden"><input name="communityid" value="'.$varNewProfileDetails['CommunityId'].'" type="hidden"><input name="action1" value="add" type="radio">&nbsp;&nbsp;<font class="text"><b>Add</b></font>';

			if($varNewProfileDetails['Paid_Status'] == 0) {
				$varTotalTable .= '&nbsp;&nbsp;<input name="action1" value="ignore" type="radio"><font class="text"><b>Ignore</b></font>&nbsp;&nbsp;';
			}
			$varTotalTable .= '<input name="action1" value="reject" type="radio"><font class="text"><b>Reject</b></font>';

			$varTotalTable .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="text"><label class=formlink1 align=left>'.$varDuplicateEmailLink.'<a href="'.$varModifyUrl.$varNewProfileDetails['MatriId'].'&reqFromPg=profileval&suppid='.$varReportId.'" class="smalltxt boldtxt heading">Modify Profile</a></label></tr>';

			$varTotalTable .= '</table></td></tr><tr><td height="10" width="100%"  class="vdotline1"><HR></td></tr>';

			$varTotalTable .= '<tr><td style="padding-left:7px;"><table border="0" cellpadding="3" cellspacing="0" width="530" class="formborder">';

			$varTotalTable .= '</table><br><br></td></tr><tr><td><center><input type="submit" name="getnewprofile" class="button" value="Update this get new profile">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="stopprofile" class="button" value="Update and Stop"></center></td></tr></form>';
		}
	} else {
		$varErrorMessage = "Profile is not in queue for validation";
	}
}
?>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545" align="center">
	<tr><td height="10"></td></tr>
	<tr>
		<td class="heading" style="padding-left:10px;">New Profiles</td>
	</tr>
	<?php if($_REQUEST['tvprofile']=="yes"){?>
	<tr><td height="10"></td></tr>
	<tr >
		<td  align="right" class="mediumtxt" style="padding-right:15px;"><a href="<?=$confValues['SERVERURL']?>/admin/index.php?act=manage-users">Home</a></td>
	</tr>
	<?php }?>
	<tr><td height="10"></td></tr>	
	<?if($varErrorMessage!='') { ?>
		<tr>
			<td class="smalltxt" style="padding-left:15px;"><?=$varErrorMessage;?>.</td>
		</tr>
	<? } else if($varTotalRow==0 && $varDisplayMatriId!='') { ?>
		<tr>
			<td class="smalltxt" style="padding-left:15px;">This profile doesnot exist or not in queue for validation.To Go home Page <a href="<?=$confValues['ServerURL']?>/admin/index.php?act=manage-users">click here</a></td>
		</tr>
	<? } elseif($varTotalRow==0 && $varDisplayMatriId=='') { 
				if($varRequestMatriId==''){?>
		<tr>
			<td class="smalltxt" style="padding-left:15px;">You have stopped the process to continue <a href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=shuffled_profile_validation">click here</a> or to home page <a href="<?=$confValues['ServerURL']?>/admin/index.php?act=manage-users">click here</a></td>
		</tr>
		<?php } else{?>
		<tr>
			<td class="smalltxt" style="padding-left:15px;">Profile submitted Sucessfully</td>
		</tr>
			
	<? }} else { ?>
		<?=$varTotalTable; ?>
	<? } ?>
</table>

<script  type="text/javascript" language="JavaScript">
var milisec=0;
var seconds='<?=$varGivenTime?>';
document.frmAddedProfile.counttime.value='<?=$varGivenTime?>';

function display() {
	if (milisec<=0){
		milisec=9;
		seconds-=1;
	}

	if (seconds<=-1){
		milisec=0;
		seconds+=1;
	} else {
		milisec-=1;
	}

	document.frmAddedProfile.counttime.value=seconds;
	if(document.frmAddedProfile.counttime.value == "0.0" || document.frmAddedProfile.counttime.value == "0") {

		document.frmAddedProfile.elapsedtime.value = 'yes';
		document.frmAddedProfile.action="index.php?act=profile_validation&reddirect=yes&matid="+document.frmAddedProfile.matriId.value+"&elpasetime="+document.frmAddedProfile.elapsedtime.value+"&reportid="+document.frmAddedProfile.reportid.value;
		document.frmAddedProfile.submit();
		return;
	}
	setTimeout("display()",100);
}

display();

function controlrefresh() {
	document.onmousedown="if (event.button==2) return false";
	document.oncontextmenu=new Function("return false");
	document.onkeydown = showDown;
	function showDown(evt) {
	evt = (evt)? evt : ((event)? event : null);
		if (evt) {
			if (evt.keyCode == 116) {// When F5 is pressed
				cancelKey(evt);
			}			
		}
	}
	function cancelKey(evt) {
		if (evt.preventDefault) {
			evt.preventDefault();
			return false;
		}
		else {
			evt.keyCode = 0;
			evt.returnValue = false;
		}
	}
}
controlrefresh();

function radio_button_checker() {

	var radio_choice = false;
	var frmLoginDetails=document.frmAddedProfile;

	if(frmLoginDetails.paidstatus.value==1) {
		if (!(frmLoginDetails.action1[0].checked) && !(frmLoginDetails.action1[1].checked)) {
			alert("Please select add or reject for profile");
			frmLoginDetails.action1[0].focus();
			return false;
		}


		if ((frmLoginDetails.action1[1].checked) && (frmLoginDetails.predefcomment.value == "")) {
			alert("Please select the reason for rejecting Profile ");
			frmLoginDetails.predefcomment.focus();
			return false;
		}
	} else {
		if (!(frmLoginDetails.action1[0].checked) && !(frmLoginDetails.action1[1].checked) && !(frmLoginDetails.action1[2].checked)) {
			alert("Please select add or ignore or reject for profile");
			frmLoginDetails.action1[0].focus();
			return false;
		}


		if ((frmLoginDetails.action1[2].checked) && (frmLoginDetails.predefcomment.value == "")) {
			alert("Please select the reason for rejecting Profile ");
			frmLoginDetails.predefcomment.focus();
			return false;
		}
	}



	frmLoginDetails.frmAddedProfileSubmit.value = 'yes';
	return true;
}
</script>