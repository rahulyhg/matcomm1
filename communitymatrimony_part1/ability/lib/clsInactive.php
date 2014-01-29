<?php
#=============================================================================================================
# Author 		: M Baranidharan
# Start Date	: 2010-06-18
# End Date		: 2010-06-18
# Project		: MatrimonyProduct
# Module		: CBS INACTIVE FLOW
#=============================================================================================================
//FILE INCLUDES
class Inactive {	

	// Move Members info from cbsinactive to communitymatrimony Database// 
	function moveFromInactiveToActive($varWhereClause,$varMatriId,$objMasterDB) {
       global $varInactiveDbInfo,$varDbInfo,$varTable,$confValues;
 
		// INSERT CBSINACTIVE TABLES FROM COMMUNITYMATRIMONY  //
		$varCondition = " WHERE ".$varWhereClause." AND MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
     
		//memberinfo
		$varMemberinfoFields = 'MatriId,User_Name,CommunityId,BM_MatriId,BM_Paid_Status,Name,Nick_Name,Age,Dob,Gender,Height,Height_Unit,Weight,Weight_Unit,Body_Type,Appearance,Complexion,Eye_Color,Hair_Color,Physical_Status,Disability_Cause,Disability_Type,Disability_Severity,Disability_Product_Used,Sign_Language,Blood_Group,Marital_Status,Divorce_Details,No_Of_Children,Children_Living_Status,Education_Category,Education_Subcategory,Education_Detail,Employed_In,Occupation,Occupation_Detail,Income_Currency,Annual_Income,Religion,Denomination,DenominationText,CasteId,CasteText,Caste_Nobar,Subcaste_Nobar,SubcasteId,SubcasteText,Mother_TongueId,Mother_TongueText,GothramId,GothramText,Star,Raasi,Horoscope_Match,Chevvai_Dosham,Religious_Values,Ethnicity,Resident_Status,Country,Citizenship,Residing_State,Residing_Area,Residing_District,Residing_City,Contact_Address,Contact_Phone,Contact_Mobile,About_Myself,About_MyPartner,Eating_Habits,Smoke,Drink,Profile_Viewed,IPAddress,Profile_Created_By,Profile_Referred_By,When_Marry,Publish,Status,Paid_Status,Special_Priv,Last_Login,Profile_Verified,Email_Verified,Phone_Verified,Phone_Protected,Hobbies_Available,Mobile_Alerts_Available,Horoscope_Available,Horoscope_Protected,Birth_Details_Available,Video_Protected,Voice_Available,Health_Profile_Available,Health_Profile_Protected,Privacy_Setting,Match_Watch_Email,Photo_Set_Status,Photo_Rank,Protect_Photo_Set_Status,Filter_Set_Status,Video_Set_Status,Partner_Set_Status,Family_Set_Status,Interest_Set_Status,Reference_Set_Status,Physical_Set_Status,Complete_Now,Web_Notification,Feature_Buzz,Date_Created,Time_Posted,Date_Updated,Number_Of_Payments,Last_Payment,Valid_Days,Expiry_Date,Auto_Renewal_Status,Last_Payment_By_Auto_Renewal,US_Paid_Validated,Receive_Email,Profile_Published_On,Internal_Referred_By,Web_Notify_Disable_View,Default_View,Activity_Rank,Pending_Modify_Validation,Pending_Photo_Validation,Support_Comments,Date_Validated,Validated_By,LastPaymentThruOnline,LastOnlinePaymentProductId,OfferAvailable,OfferCategoryId,PowerPackOpted,PowerPackStatus,Temp_Annual_Income';

		$varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['MEMBERINFO'] .'('.$varMemberinfoFields.') SELECT '.$varMemberinfoFields. ' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERINFO'].$varCondition;
		//echo '\n\n'.$varInsertQry;
		mysql_query($varInsertQry,$objMasterDB->clsDBLink);


		//MEMBERLOGININFO
		$varMLogininfoFields = 'MatriId,Email,Password,User_Name,Email_Status,Date_Updated,CommunityId';

		$varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['MEMBERLOGININFO'].'('.$varMLogininfoFields.') SELECT '.$varMLogininfoFields.' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERLOGININFO'].$varCondition;
		//echo '\n\n'.$varInsertQry;
		mysql_query($varInsertQry,$objMasterDB->clsDBLink);
     
	 // memberpartnerinfo table //
	 $varMemberPartnerFields = 'CommunityId,MatriId,Email_Type,Age_From,Age_To,Looking_Status,Have_Children,Height_From,Height_To,Height_Unit,Weight_From,Weight_To,Physical_Status,Education,Employed_In,Occupation,Religion,Denomination,CasteId,SubcasteId,GothramId,Star,Raasi,Chevvai_Dosham,Citizenship,Country,Resident_India_State,Resident_USA_State,Resident_District,Resident_Status,Mother_Tongue,Partner_Description,Eating_Habits,Drinking_Habits,Smoking_Habits,Status,Date_Updated';
	  $varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['MEMBERPARTNERINFO'].'('.$varMemberPartnerFields.') SELECT '.$varMemberPartnerFields.' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERPARTNERINFO'].$varCondition;
		//echo '\n\n'.$varInsertQry;
	  mysql_query($varInsertQry,$objMasterDB->clsDBLink);
	 
	 
	 $varCondition = " WHERE MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	 // memberfamily table //
	 $varMemberFamilyFields ='MatriId,Family_Value,Family_Type,Family_Status,Father_Occupation,Mother_Occupation,Family_Origin,Brothers,Brothers_Married,Sisters,Sisters_Married,About_Family,Date_Updated';
	  $varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['MEMBERFAMILYINFO'].'('.$varMemberFamilyFields.') SELECT '.$varMemberFamilyFields.' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERFAMILYINFO'].$varCondition;
		//echo '\n\n'.$varInsertQry;
	  mysql_query($varInsertQry,$objMasterDB->clsDBLink);


	 // memberhobbiesinfo table //
	 $varHobbiesFields = 'MatriId,Hobbies_Selected,Hobbies_Others,Interests_Selected,Interests_Others,Music_Selected,Music_Others,Books_Selected,Books_Others,Movies_Selected,Movies_Others,Sports_Selected,Sports_Others,Food_Selected,Food_Others,Dress_Style_Selected,Dress_Style_Others,Languages_Selected,Languages_Others,Date_Updated';
	  $varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['MEMBERHOBBIESINFO'].'('.$varHobbiesFields.') SELECT '.$varHobbiesFields.' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERHOBBIESINFO'].$varCondition;
		//echo '\n\n'.$varInsertQry;
	  mysql_query($varInsertQry,$objMasterDB->clsDBLink);


	 // assuredcontactbeforevalidation table //
	 $varMemberAssuredBeforeValidationFields ='PinNo,MatriId,TimeGenerated,CountryCode,AreaCode,PhoneNo,MobileNo,PhoneNo1,PhoneStatus1,ContactPerson1,Relationship1,Timetocall1,DateConfirmed,VerifiedFlag,Description,VerificationSource,ThruRegistration';
	  $varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['ASSUREDCONTACTBEFOREVALIDATION'].'('.$varMemberAssuredBeforeValidationFields.') SELECT '.$varMemberAssuredBeforeValidationFields.' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['ASSUREDCONTACTBEFOREVALIDATION'].$varCondition;
		//echo '\n\n'.$varInsertQry;
	  mysql_query($varInsertQry,$objMasterDB->clsDBLink);


	 // assuredcontact table //
	 $varMemberAssuredFields = 'PinNo,MatriId,TimeGenerated,CountryCode,AreaCode,PhoneNo,MobileNo,PhoneNo1,PhoneStatus1,ContactPerson1,Relationship1,Timetocall1,DateConfirmed,VerifiedFlag,Description,VerificationSource,ThruRegistration';
	  $varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['ASSUREDCONTACT'].'('.$varMemberAssuredFields.' ) SELECT '.$varMemberAssuredFields.' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['ASSUREDCONTACT'].$varCondition;
		//echo '\n\n'.$varInsertQry;
	  mysql_query($varInsertQry,$objMasterDB->clsDBLink);

     
	 // memberphotoinfo table //
	 $varMemberPhotoFields = 'Photo_Id,MatriId,Normal_Photo1,Description1,Thumb_Small_Photo1,Thumb_Big_Photo1,Photo_Status1,Photo_Quality1,Normal_Photo2,Description2,Thumb_Small_Photo2,Thumb_Big_Photo2,Photo_Status2,Photo_Quality2,Normal_Photo3,Description3,Thumb_Small_Photo3,Thumb_Big_Photo3,Photo_Status3,Photo_Quality3,Normal_Photo4,Description4,Thumb_Small_Photo4,Thumb_Big_Photo4,Photo_Status4,Photo_Quality4,Normal_Photo5,Description5,Thumb_Small_Photo5,Thumb_Big_Photo5,Photo_Status5,Photo_Quality5,Normal_Photo6,Description6,Thumb_Small_Photo6,Thumb_Big_Photo6,Photo_Status6,Photo_Quality6,Normal_Photo7,Description7,Thumb_Small_Photo7,Thumb_Big_Photo7,Photo_Status7,Photo_Quality7,Normal_Photo8,Description8,Thumb_Small_Photo8,Thumb_Big_Photo8,Photo_Status8,Photo_Quality8,Normal_Photo9,Description9,Thumb_Small_Photo9,Thumb_Big_Photo9,Photo_Status9,Photo_Quality9,Normal_Photo10,Description10,Thumb_Small_Photo10,Thumb_Big_Photo10,Photo_Status10,Photo_Quality10,Photo_Protected,Photo_Protect_Password,Photo_Date_Updated,Video_URL,Video_Description,Video_Status,Video_Protect,Video_Protect_Password,Video_Date_Updated,HoroscopeURL,HoroscopeDescription,HoroscopeStatus,Horoscope_Date_Updated,VoiceURL,VoiceDescription,HealthProfileURL,HealthProfileAddedOn,HealthProfileStatus,Health_Profile_Protected,Health_Profile_Protected_Password,Voice_Protected,Voice_Protected_Password,Horoscope_Protected,Horoscope_Protected_Password';
	  $varInsertQry = 'INSERT INTO '.$varDbInfo['DATABASE'].'.'.$varTable['MEMBERPHOTOINFO'].'('.$varMemberPhotoFields.') SELECT '.$varMemberPhotoFields.' FROM '.$varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERPHOTOINFO'].$varCondition;
		//echo '\n\n'.$varInsertQry;
	  mysql_query($varInsertQry,$objMasterDB->clsDBLink);

	  $varInsertQry = "INSERT IGNORE INTO ".$varDbInfo['DATABASE'].".".$varTable['MAILMANAGERINFO']."(CommunityId,MatriId,Matchwatch,SpecialFeatures,Promotions,ThirdParty,Date_Updated) VALUES ('".$confValues["DOMAINCASTEID"]."','".$varMatriId."','1','1','1','1',NOW())";
		//echo '\n\n'.$varInsertQry;
	  mysql_query($varInsertQry,$objMasterDB->clsDBLink);

	//DELETE memberfamilyinfo INFO
	$varCondition = " MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERFAMILYINFO'],$varCondition);

	//DELETE memberhobbiesinfo INFO
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERHOBBIESINFO'],$varCondition);

	//DELETE memberinfo INFO
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERINFO'],$varCondition,$varOwnProfileMCKey);

	//DELETE memberlogininfo INFO
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERLOGININFO'],$varCondition);

	//DELETE memberpartnerinfo INFO
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERPARTNERINFO'],$varCondition);

	//DELETE assuredcontact INFO
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['ASSUREDCONTACT'],$varCondition);

	//DELETE assuredcontactbeforevalidation INFO
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varCondition);

	//DELETE memberphotoinfo INFO
	$objMasterDB->delete($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERPHOTOINFO'],$varCondition);

   }
}

?>