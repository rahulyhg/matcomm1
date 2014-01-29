<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/dbainfo.inc');
include_once($varBaseRoot.'/conf/dbinfo.inc');

//CONNECT DB
$varConn = mysql_connect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD']);
mysql_select_db($varDbaInfo['DATABASE'], $varConn);

//CONTACT DETAILS UPDATE
$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_memberinfo a, '.$varDbaInfo['DATABASE'].".bm_contactinfo b SET a.Contact_Phone=CONCAT(b.PhoneCountryCode,'~',b.AreaCode,'~',b.PhoneNo) WHERE a.BM_MatriId=b.MatriId AND b.PhoneNo<>''";
mysql_query($varQuery);

$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_memberinfo a, '.$varDbaInfo['DATABASE'].".bm_contactinfo b SET  a.Contact_Mobile=CONCAT(b.CountryCode,'~',b.MobileNo) WHERE a.BM_MatriId=b.MatriId AND b.MobileNo<>''";
mysql_query($varQuery);


//ASSURED CONTACT INSERT
$varQuery	= 'INSERT IGNORE INTO '.$varDbaInfo['DATABASE'].'.comm_assuredcontact (SELECT b.PinNo, a.MatriId, b.TimeGenerated, b.CountryCode, b.AreaCode, b.PhoneNo, b.MobileNo, b.PhoneNo1, b.PhoneStatus1, b.ContactPerson1, b.Relationship1, b.Timetocall1, b.DateConfirmed, b.VerifiedFlag, b.Description, b.VerificationSource, b.ThruRegistration FROM '.$varDbaInfo['DATABASE'].'.comm_memberinfo a, '.$varDbaInfo['DATABASE'].'.bm_assuredcontact b WHERE a.BM_MatriId=b.MatriId)';
mysql_query($varQuery); 

//$varQuery	= 'INSERT IGNORE INTO '.$varDbaInfo['DATABASE'].'.comm_assuredcontact (SELECT * FROM '.$varDbaInfo['DATABASE'].'.bm_assuredcontact)';
//mysql_query($varQuery); 

//$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_assuredcontact a,'.$varDbaInfo['DATABASE'].'.comm_memberinfo b SET a.MatriId=b.MatriId WHERE a.MatriId=b.BM_MatriId';
//mysql_query($varQuery); 

//$varQuery	= 'DELETE FROM '.$varDbaInfo['DATABASE'].'.comm_assuredcontact WHERE MatriId NOT IN(SELECT MatriId FROM '.$varDbaInfo['DATABASE'].'.comm_memberlogininfo)';
//mysql_query($varQuery); 

//HORODETAILS INSERT
$varQuery	= 'INSERT IGNORE INTO '.$varDbaInfo['DATABASE'].'.comm_horodetails (SELECT * FROM '.$varDbaInfo['DATABASE'].'.bm_horodetails)';
mysql_query($varQuery); 

$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_horodetails a,'.$varDbaInfo['DATABASE'].'.comm_memberinfo b SET a.MatriId=b.MatriId WHERE a.MatriId=b.BM_MatriId';
mysql_query($varQuery); 

$varQuery	= 'DELETE FROM '.$varDbaInfo['DATABASE'].'.comm_horodetails WHERE MatriId NOT IN(SELECT MatriId FROM '.$varDbaInfo['DATABASE'].'.comm_memberlogininfo)';
mysql_query($varQuery); 

//UPDATE FILTER STATUS
$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_memberinfo SET Filter_Set_Status=1 WHERE MatriId IN(SELECT MatriId FROM '.$varDbaInfo['DATABASE'].'.comm_memberfilterinfo)';
mysql_query($varQuery);

//UPDATE FILTER STATUS
$varQuery	= 'DELETE FROM '.$varDbaInfo['DATABASE'].".comm_memberphotoinfo WHERE Normal_Photo1='' AND HoroscopeURL=''";
mysql_query($varQuery);

//UPDATE PHOTO STATUS
$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_memberinfo SET Photo_Set_Status=1 WHERE MatriId IN(SELECT MatriId FROM '.$varDbaInfo['DATABASE'].'.comm_memberphotoinfo WHERE (Photo_Status1=1 OR Photo_Status1=2 OR Photo_Status2=1 OR Photo_Status2=2 OR Photo_Status3=1 OR Photo_Status3=2 OR Photo_Status4=1 OR Photo_Status4=2 OR Photo_Status5=1 OR Photo_Status5=2 OR Photo_Status6=1 OR Photo_Status6=2 OR Photo_Status7=1 OR Photo_Status7=2 OR Photo_Status8=1 OR Photo_Status8=2 OR Photo_Status9=1 OR Photo_Status9=2 OR Photo_Status10=1 OR Photo_Status10=2))';
mysql_query($varQuery);

//UPDATE FAMILY STATUS
$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_memberinfo SET Family_Set_Status=1 WHERE MatriId IN(SELECT MatriId FROM '.$varDbaInfo['DATABASE'].'.comm_memberfamilyinfo)';
mysql_query($varQuery);

//UPDATE INTEREST & HOBBIES STATUS
$varQuery	= 'UPDATE '.$varDbaInfo['DATABASE'].'.comm_memberinfo SET Interest_Set_Status=1 WHERE MatriId IN(SELECT MatriId FROM '.$varDbaInfo['DATABASE'].'.comm_memberhobbiesinfo)';
mysql_query($varQuery);


//1. INSERT memberfamilyinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberfamilyinfo (SELECT * FROM '.$varDbaInfo['DATABASE'].'.comm_memberfamilyinfo)';
mysql_query($varQuery);

//2. INSERT memberfilterinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberfilterinfo (SELECT * FROM '.$varDbaInfo['DATABASE'].'.comm_memberfilterinfo)';
mysql_query($varQuery);

//3. INSERT memberhobbiesinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberhobbiesinfo (SELECT * FROM '.$varDbaInfo['DATABASE'].'.comm_memberhobbiesinfo)';
mysql_query($varQuery);

//4. INSERT memberinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberinfo (MatriId, User_Name, CommunityId, BM_MatriId, BM_Paid_Status, Name, Nick_Name, Age, Dob, Gender, Height, Height_Unit, Weight, Weight_Unit, Body_Type, Appearance, Complexion, Eye_Color, Hair_Color, Physical_Status, Blood_Group, Marital_Status, Divorce_Details, No_Of_Children, Children_Living_Status, Education_Category, Education_Detail, Employed_In, Occupation, Occupation_Detail, Income_Currency, Annual_Income, Religion, Denomination, CasteId, CasteText, Caste_Nobar, SubcasteId, SubcasteText, Subcaste_Nobar, Mother_TongueId, Mother_TongueText, GothramId, GothramText, Star, Raasi, Horoscope_Match, Chevvai_Dosham, Religious_Values, Ethnicity, Resident_Status, Country, Citizenship, Residing_State, Residing_Area, Residing_District, Residing_City, Contact_Address, Contact_Phone, Contact_Mobile, About_Myself, About_MyPartner, Eating_Habits, Smoke, Drink, Profile_Viewed, IPAddress, Profile_Created_By, Profile_Referred_By, When_Marry, Publish, Status, Paid_Status, Special_Priv, Last_Login, Profile_Verified, Email_Verified, Phone_Verified, Phone_Protected, Hobbies_Available, Mobile_Alerts_Available, Horoscope_Available, Horoscope_Protected, Birth_Details_Available, Video_Protected, Voice_Available, Health_Profile_Available, Health_Profile_Protected, Privacy_Setting, Match_Watch_Email, Photo_Set_Status, Protect_Photo_Set_Status, Filter_Set_Status, Video_Set_Status, Partner_Set_Status, Family_Set_Status, Interest_Set_Status, Reference_Set_Status, Web_Notification, Feature_Buzz, Date_Created, Time_Posted, Date_Updated, Number_Of_Payments, Last_Payment, Valid_Days, Expiry_Date, Auto_Renewal_Status, Last_Payment_By_Auto_Renewal, US_Paid_Validated, Receive_Email, Profile_Published_On, Internal_Referred_By, Web_Notify_Disable_View, Default_View, Activity_Rank, Pending_Modify_Validation, Pending_Photo_Validation, Support_Comments, Date_Validated, Validated_By, LastPaymentThruOnline, LastOnlinePaymentProductId, OfferAvailable, OfferCategoryId, PowerPackOpted, PowerPackStatus) (SELECT MatriId, User_Name, CommunityId, BM_MatriId, BM_Paid_Status, Name, Nick_Name, Age, Dob, Gender, Height, Height_Unit, Weight, Weight_Unit, Body_Type, Appearance, Complexion, Eye_Color, Hair_Color, Physical_Status, Blood_Group, Marital_Status, Divorce_Details, No_Of_Children, Children_Living_Status, Education_Category, Education_Detail, Employed_In, Occupation, Occupation_Detail, Income_Currency, Annual_Income, Religion, Denomination, CasteId, CasteText, Caste_Nobar, SubcasteId, SubcasteText, Subcaste_Nobar, Mother_TongueId, Mother_TongueText, GothramId, GothramText, Star, Raasi, Horoscope_Match, Chevvai_Dosham, Religious_Values, Ethnicity, Resident_Status, Country, Citizenship, Residing_State, Residing_Area, Residing_District, Residing_City, Contact_Address, Contact_Phone, Contact_Mobile, About_Myself, About_MyPartner, Eating_Habits, Smoke, Drink, Profile_Viewed, IPAddress, Profile_Created_By, Profile_Referred_By, When_Marry, Publish, Status, Paid_Status, Special_Priv, Last_Login, Profile_Verified, Email_Verified, Phone_Verified, Phone_Protected, Hobbies_Available, Mobile_Alerts_Available, Horoscope_Available, Horoscope_Protected, Birth_Details_Available, Video_Protected, Voice_Available, Health_Profile_Available, Health_Profile_Protected, Privacy_Setting, Match_Watch_Email, Photo_Set_Status, Protect_Photo_Set_Status, Filter_Set_Status, Video_Set_Status, Partner_Set_Status, Family_Set_Status, Interest_Set_Status, Reference_Set_Status, Web_Notification, Feature_Buzz, Date_Created, Time_Posted, Date_Updated, Number_Of_Payments, Last_Payment, Valid_Days, Expiry_Date, Auto_Renewal_Status, Last_Payment_By_Auto_Renewal, US_Paid_Validated, Receive_Email, Profile_Published_On, Internal_Referred_By, Web_Notify_Disable_View, Default_View, Activity_Rank, Pending_Modify_Validation, Pending_Photo_Validation, Support_Comments, Date_Validated, Validated_By, LastPaymentThruOnline, LastOnlinePaymentProductId, OfferAvailable, OfferCategoryId, PowerPackOpted, PowerPackStatus FROM '.$varDbaInfo['DATABASE'].'.comm_memberinfo)';
mysql_query($varQuery);

//5. INSERT bmtocbsinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.bmtocbsinfo (SELECT MatriId, BM_MatriId, Date_Created FROM '.$varDbaInfo['DATABASE'].'.comm_memberinfo)';
mysql_query($varQuery);

//6. INSERT memberlogininfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberlogininfo (MatriId, Email, Password, User_Name, Email_Status, Date_Updated, CommunityId)(SELECT MatriId, Email, Password, User_Name, Email_Status, Date_Updated, CommunityId FROM '.$varDbaInfo['DATABASE'].'.comm_memberlogininfo)';
mysql_query($varQuery);

//7. INSERT memberpartnerinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberpartnerinfo (SELECT * FROM '.$varDbaInfo['DATABASE'].'.comm_memberpartnerinfo)';
mysql_query($varQuery);

//8. INSERT memberphotoinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberphotoinfo (MatriId, Normal_Photo1, Description1, Thumb_Small_Photo1, Thumb_Big_Photo1, Photo_Status1, Normal_Photo2, Description2, Thumb_Small_Photo2, Thumb_Big_Photo2, Photo_Status2, Normal_Photo3, Description3, Thumb_Small_Photo3, Thumb_Big_Photo3, Photo_Status3, Normal_Photo4, Description4, Thumb_Small_Photo4, Thumb_Big_Photo4, Photo_Status4, Normal_Photo5, Description5, Thumb_Small_Photo5, Thumb_Big_Photo5, Photo_Status5, Normal_Photo6, Description6, Thumb_Small_Photo6, Thumb_Big_Photo6, Photo_Status6, Normal_Photo7, Description7, Thumb_Small_Photo7, Thumb_Big_Photo7, Photo_Status7, Normal_Photo8, Description8, Thumb_Small_Photo8, Thumb_Big_Photo8, Photo_Status8, Normal_Photo9, Description9, Thumb_Small_Photo9, Thumb_Big_Photo9, Photo_Status9, Normal_Photo10, Description10, Thumb_Small_Photo10, Thumb_Big_Photo10, Photo_Status10, Photo_Protected, Photo_Protect_Password, Photo_Date_Updated, Video_URL, Video_Description, Video_Status, Video_Protect, Video_Protect_Password, Video_Date_Updated, HoroscopeURL, HoroscopeDescription, HoroscopeStatus, VoiceURL, VoiceDescription, HealthProfileURL, HealthProfileAddedOn, HealthProfileStatus, Health_Profile_Protected, Health_Profile_Protected_Password, Voice_Protected, Voice_Protected_Password, Horoscope_Protected, Horoscope_Protected_Password, Horoscope_Date_Updated) (SELECT MatriId, Normal_Photo1, Description1, Thumb_Small_Photo1, Thumb_Big_Photo1, Photo_Status1, Normal_Photo2, Description2, Thumb_Small_Photo2, Thumb_Big_Photo2, Photo_Status2, Normal_Photo3, Description3, Thumb_Small_Photo3, Thumb_Big_Photo3, Photo_Status3, Normal_Photo4, Description4, Thumb_Small_Photo4, Thumb_Big_Photo4, Photo_Status4, Normal_Photo5, Description5, Thumb_Small_Photo5, Thumb_Big_Photo5, Photo_Status5, Normal_Photo6, Description6, Thumb_Small_Photo6, Thumb_Big_Photo6, Photo_Status6, Normal_Photo7, Description7, Thumb_Small_Photo7, Thumb_Big_Photo7, Photo_Status7, Normal_Photo8, Description8, Thumb_Small_Photo8, Thumb_Big_Photo8, Photo_Status8, Normal_Photo9, Description9, Thumb_Small_Photo9, Thumb_Big_Photo9, Photo_Status9, Normal_Photo10, Description10, Thumb_Small_Photo10, Thumb_Big_Photo10, Photo_Status10, Photo_Protected, Photo_Protect_Password, Photo_Date_Updated, Video_URL, Video_Description, Video_Status, Video_Protect, Video_Protect_Password, Video_Date_Updated, HoroscopeURL, HoroscopeDescription, HoroscopeStatus, VoiceURL, VoiceDescription, HealthProfileURL, HealthProfileAddedOn, HealthProfileStatus, Health_Profile_Protected, Health_Profile_Protected_Password, Voice_Protected, Voice_Protected_Password, Horoscope_Protected, Horoscope_Protected_Password, Horoscope_Date_Updated FROM '.$varDbaInfo['DATABASE'].'.comm_memberphotoinfo)';
mysql_query($varQuery);

//9. INSERT mobilealerts
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.mobilealerts (SELECT * FROM '.$varDbaInfo['DATABASE'].'.comm_mobilealerts)';
mysql_query($varQuery);

//10. INSERT assuredcontact 
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.assuredcontact (SELECT * FROM '.$varDbaInfo['DATABASE'].'.comm_assuredcontact)';
mysql_query($varQuery); 

//11. INSERT horodetails 
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.horodetails (SELECT * FROM '.$varDbaInfo['DATABASE'].'.comm_horodetails)';
mysql_query($varQuery); 

//12. INSERT memberstatistics
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.memberstatistics(MatriId) (SELECT MatriId FROM '.$varDbaInfo['DATABASE'].'.comm_memberlogininfo)';
mysql_query($varQuery); 

//13. INSERT mailmanagerinfo
$varQuery	= 'INSERT IGNORE INTO '.$varDbInfo['DATABASE'].'.mailmanagerinfo(CommunityId, MatriId, Matchwatch, SpecialFeatures, Promotions, ThirdParty, Date_Updated) (SELECT CommunityId, MatriId, 1, 1, 1, 1, NOW() FROM '.$varDbaInfo['DATABASE'].'.comm_memberlogininfo)';
mysql_query($varQuery); 

//Close Conn
mysql_close($varConn);
?>
