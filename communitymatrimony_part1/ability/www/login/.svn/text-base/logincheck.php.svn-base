<?php
#=============================================================================================================
# Author   : S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date : 2006-06-19
# End Date  : 2006-06-21
# Project  : MatrimonyProduct
# Module  : Registration - Basic
#=============================================================================================================
if($_REQUEST["frmLoginSubmit"]=="yes")
{
 //FILE INCLUDES
 include_once($varRootBasePath."/conf/dbinfo.cil14");
 include_once($varRootBasePath."/conf/memcache.cil14");
 
 include_once($varRootBasePath."/conf/basefunctions.cil14");
 include_once($varRootBasePath."/lib/clsDB.php");
 include_once($varRootBasePath."/lib/clsInactive.php");
 //include_once($varRootBasePath."/lib/clsMemcacheDB.php");
 include_once($varRootBasePath."/lib/clsLogin.php");
 
 //OBJECT DECLARTION
 $objMasterDB = new Login;
 $objSlaveDB  = new Login;
 $objInactive = new Inactive;

  //DB CONNECTION
 $objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
 $objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);
 
 //VARIABLE DECLARATIONS
 $varCurrentDate	= date('Y-m-d H:i:s');
 $varUsername		= trim($_REQUEST["idEmail"]);
 $varPassword		= trim($_REQUEST["password"]);
 $varCheckLogin		= 0;
 $varDomainName		= $confValues["DOMAINNAME"];
 $varRedirect		= trim($_REQUEST['redirect']);
 $varRedirect		= $varRedirect ? $varRedirect.'&auto=1' : $confValues['SERVERURL'].'/profiledetail/';
 $varCountryCode	= trim($_REQUEST['countryCode']);
 $varOpenIp			= $varChat['OPENFIRE'];
 
 //PRIMARY VALUES
 if ($_POST['chooseLogin']=='yes') { 
	 $argCondition = ' WHERE '.$varWhereClause." AND MatriId=".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB);
 }
 else {
  if (strpos($varUsername, '@')) {  $varPrimary = 'Email'; } else { $varPrimary = 'MatriId'; }//else
  $argCondition = ' WHERE '.$varWhereClause.' AND '.$varPrimary."=".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB)." AND Password=".$objSlaveDB->doEscapeString($varPassword,$objSlaveDB);
 }
 $varCheckLogin = $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], 'MatriId', $argCondition);
 
	

 // INACTIVE ENABLED CODE // 
 if($varCheckLogin == 0) {

	$varCheckLogin = $objSlaveDB->numOfRecords($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERLOGININFO'], 'MatriId', $argCondition);
	
   if($varCheckLogin > 0) {

		if ($varPrimary == 'Email') {

		$argFields   = array('MatriId');
		$varExecute   = $objSlaveDB->select($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERLOGININFO'], $argFields, $argCondition,0);
		$varSelectInactiveInfo= mysql_fetch_assoc($varExecute);
		$varMatriId   = $varSelectInactiveInfo["MatriId"];

		} else { $varMatriId = $varUsername; }
		$objInactive->moveFromInactiveToActive($varWhereClause,$varMatriId,$objMasterDB);
   }
 }
 // END INACTIVE CODE//

 //IF MULTIPLE LOGIN COMES USING EMAIL WITH SAME PASSWORD
 if ($varCheckLogin > 1) { $varAct   = 'chooselogin'; }
 else if ($varCheckLogin==1) {  //USERNAME && MATRIID NOT AVAILABLE IN DB (*ND 20060926)
  //SELECT MatriId
  $argFields   = array('MatriId');
  $varExecute   = $objSlaveDB->select($varTable['MEMBERLOGININFO'], $argFields, $argCondition,0);
  $varSelectLoginInfo1= mysql_fetch_assoc($varExecute);
  $varMatriId   = $varSelectLoginInfo1["MatriId"];
 

  $argFields   = array('User_Name','MatriId','BM_MatriId','Name','Nick_Name','Paid_Status','Gender','Last_Login','Status','Publish',' TO_DAYS(NOW())-TO_DAYS(Date_Created) as CreatedWithin','Date_Created','Religion','CasteId','Marital_Status','Age','Photo_Set_Status','Partner_Set_Status','Video_Set_Status','Horoscope_Available','UNIX_TIMESTAMP(Last_Login) as LastLoginTimeStamp','Country','Web_Notification','Family_Set_Status','Reference_Set_Status','Special_Priv','Education_Category','Residing_State','Residing_Area','Residing_City','Profile_Created_By','Default_View','Activity_Rank','Profile_Verified','Interest_Set_Status','Voice_Available','Phone_Verified','OfferAvailable','Physical_Status');
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $varExecute   = $objSlaveDB->select($varTable['MEMBERINFO'], $argFields, $argCondition,0);
  $varSelectLoginInfo = mysql_fetch_assoc($varExecute);
 
  //FOR mem cache integration
  //$objSlaveMemcache->clearLogData();
  //$varSelectLoginInfo = $objSlaveMemcache->select($varTable['MEMBERINFO'], $argFields, $argCondition, 0, Login_MemberInfo);
  //echo $objSlaveMemcache->getLogData();
 
  $varMatriId			= $varSelectLoginInfo["MatriId"];
  $varName				= $varSelectLoginInfo["Name"];
  $varNickName			= $varSelectLoginInfo["Nick_Name"];
  $varUsername			= $varSelectLoginInfo["User_Name"];
  $varPaidStatus		= $varSelectLoginInfo['Paid_Status'];
  $varGender			= $varSelectLoginInfo['Gender'];
  $varLastLogin			= $varSelectLoginInfo['Last_Login'];
  $varStatus			= $varSelectLoginInfo['Status'];
  $varPublish			= $varSelectLoginInfo["Publish"];
  $varCreatedWithin		= $varSelectLoginInfo['CreatedWithin'];
  $varDateCreated		= $varSelectLoginInfo['Date_Created'];
  $varReligion			= $varSelectLoginInfo['Religion'];
  $varCasteOrDivision	= $varSelectLoginInfo['CasteId'];
  $varMaritalStatus		= $varSelectLoginInfo['Marital_Status'];
  $varAge				= $varSelectLoginInfo['Age'];
  $varActivityRank		= $varSelectLoginInfo['Activity_Rank'];
  $varBMMatriId			= $varSelectLoginInfo['BM_MatriId'];
 
 
 
  $varPartnerSetStatus	= $varSelectLoginInfo['Partner_Set_Status'];
  $varVideoSetStatus	= $varSelectLoginInfo['Video_Set_Status'];
  $varHoroscopeAvailable= $varSelectLoginInfo['Horoscope_Available'];

  $varLastLoginTimeStamp= $varSelectLoginInfo['LastLoginTimeStamp'];
  $varCountry			= $varSelectLoginInfo['Country'];
  $varWebNotification	= $varSelectLoginInfo['Web_Notification'];
 

  $varFamilySetStatus	= $varSelectLoginInfo['Family_Set_Status'];
  $varHobbiesAvailable	= $varSelectLoginInfo['Interest_Set_Status'];
  $varPartnerSetStatus	= $varSelectLoginInfo['Partner_Set_Status'];
  $varPhotoSetStatus	= $varSelectLoginInfo['Photo_Set_Status'];
  $varVideoSetStatus	= $varSelectLoginInfo['Video_Set_Status'];
  $varVoiceAvailable	= $varSelectLoginInfo['Voice_Available'];
  $varReferenceSetStatus= $varSelectLoginInfo['Reference_Set_Status'];
  $varPhoneVerified		= $varSelectLoginInfo['Phone_Verified'];
  $varOfferAvailable	= $varSelectLoginInfo['OfferAvailable'];
  $varPhysicalStatus	= $varSelectLoginInfo['Physical_Status'];
 
 
 
  //LOGIN INFO DETAILS
  if ($varPublish==3){ echo '<script language="javascript">document.location.href="index.php?act=suspendprofile&sid='.$varMatriId.'"</script>';exit; }//if
 
  $varProductId = 0;
 
  //UPDATE LAST LOGIN INTO memberinfo TABLE
  if($_COOKIE['partialflag']==0 || !$_COOKIE['partialflag']){
  $argFields  = array('Last_Login');
  $argFieldsValue = array("'".$varCurrentDate."'");
  $argCondition = " MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
  $objMasterDB->update($varTable['MEMBERINFO'], $argFields, $argFieldsValue, $argCondition);
  }
 
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $argFields   = array('Normal_Photo1','Photo_Status1');
  $varExecute   = $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $argFields, $argCondition,0);
  $varPhotoInfo  = mysql_fetch_assoc($varExecute);
  $varPhotoName  = $varPhotoInfo["Normal_Photo1"].'~'.$varPhotoInfo["Photo_Status1"];
 
  //SET COOKIE
  $varCryptSalt    = crypt($varMatriId,$varSalt);
  $varDefaultView   = 0;
  $profile_completeval = 'PC';
  $varEducation   = 'EDU';
  $varState    = 'STATE';
  $varCity    = 'CITY';
  $messagecookievalue  = 'MSG';
  $profilecompleteness = 0;
  $profcreatedwithin  = 1;
  $profilematchcookvalue = 1;
  $caste     = 1;
 
  //SELECT LIST COUNT
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $varBookMarkCnt  = $objSlaveDB->numOfRecords($varTable['BOOKMARKINFO'], 'MatriId', $argCondition);
 
  //SELECT PHONE COUNT
  $argCondition = " WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $varPhoneCnt  = $objSlaveDB->numOfRecords($varTable['PHONEVIEWLIST'], 'MatriId', $argCondition);
 

  $varCookieValue = $varMatriId.'^|'.$varGender.'^|'.$varStatus.'^|'.$varLastLogin.'^|'.$varPublish.'^|'.$varCryptSalt.'^|'.$varPaidStatus.'^|^|'.$varDefaultView.'^|'.$varActivityRank.'^|'.$varName.'^|'.$varNickName.'^|'.$profile_completeval.'^|'.$varPhotoName.'^|'.$varEducation.'^|'.$varState.'^|'.$varCity.'^|'.$messagecookievalue.'^|'.$profilecompleteness.'^|'.$varReligion.'^|^|'.$varDateCreated.'^|'.$varCreatedWithin.'^|'.$profcreatedwithin.'^|'.$messagecookievalue.'^|'.$profilematchcookvalue.'^|'.$caste.'^|'.$varOfferAvailable;
  header("set-cookie:loginInfo=$varCookieValue;path=/;domain=$varDomainName");
 
  //UPDATE LIST COOKIE
  $varProfileValue = $varPublish.'^|'.$varPaidStatus.'^|^|'.urlencode($varPhotoName).'^|'.$varFamilySetStatus.'^|'.$varHobbiesAvailable.'^|'.$varPartnerSetStatus.'^|'.$varPhotoSetStatus.'^|'.$varVideoSetStatus.'^|'.$varVoiceAvailable.'^|'.$varReferenceSetStatus.'^|'.$varBookMarkCnt.'^|'.$varPhoneCnt.'^|'.$varPhoneVerified.'^|'.$varProductId.'^|^|^|^|'.$varHoroscopeAvailable.'^|'.$varPhysicalStatus;
  setrawcookie("profileInfo","$varProfileValue", "0", "/",$confValues['DOMAINNAME']);
 
 
 
  //CHECK PARTNER PREFERENCE COOKIES
 
  $argFields  = array('Email_Type','Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Height_Unit','Weight_From','Weight_To','Physical_Status','Education','Religion','CasteId','SubcasteId','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_USA_State','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits');
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $varExecute  = $objSlaveDB->select($varTable['MEMBERPARTNERINFO'], $argFields, $argCondition,0);
  $varPartnerInfo = mysql_fetch_assoc($varExecute);
  $varPartnerDetails=$varPartnerInfo['Age_From'].'~'.$varPartnerInfo['Age_To'].'^|'.$varPartnerInfo['Height_From'].'~'.$varPartnerInfo['Height_To'].'^|'.$varPartnerInfo['Looking_Status'].'^|'.$varPartnerInfo['Physical_Status'].'^|'.$varPartnerInfo['Mother_Tongue'].'^|'.$varPartnerInfo['Religion'].'^|'.$varPartnerInfo['CasteId'].'^|'.$varPartnerInfo['Eating_Habits'].'^|'.$varPartnerInfo['Education'].'^|'.$varPartnerInfo['Citizenship'].'^|'.$varPartnerInfo['Country'].'^|'.$varPartnerInfo['Resident_India_State'].'^|'.$varPartnerInfo['Resident_USA_State'].'^|'.$varPartnerInfo['Resident_Status'].'^|'.$varPartnerInfo['Smoking_Habits'].'^|'.$varPartnerInfo['Drinking_Habits'].'^|'.$varPartnerInfo['SubcasteId'];
  setrawcookie("partnerInfo","$varPartnerDetails", "0", "/",$confValues['DOMAINNAME']);
 
  //UPDATE COOKIE
  $sessMatriId = $varMatriId;
  include_once($varRootBasePath."/www/login/updatemessagescookie.php");
  include_once($varRootBasePath."/www/login/updatelistrequestcookie.php");
  setRequestReceivedCookie($sessMatriId,$objSlaveDB);
  setRequestSentCookie($sessMatriId,$objSlaveDB);
 
  //SELECT SAVED SEARCH DETAILS
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB)." ORDER BY Date_Updated DESC";
  $varNoOfRecord = $objSlaveDB->numOfRecords($varTable['SEARCHSAVEDINFO'], 'Search_Id', $argCondition);
  if ($varNoOfRecord > 0){
   $argFields     = array('Search_Id', 'Search_Name', 'Search_Type');
   $varResSelSavedSearchInfo = $objSlaveDB->select($varTable['SEARCHSAVEDINFO'], $argFields, $argCondition, 0);
   $varSavedSearchInfo   = '';
   while($row=mysql_fetch_assoc($varResSelSavedSearchInfo)){
    $varSavedSearchInfo .= $row['Search_Id'].'|'.$row['Search_Type'].'|'.$row['Search_Name'].'~';
   }//for
   $varSavedSearchInfo = trim($varSavedSearchInfo,'~');
   setcookie("savedSearchInfo",$varSavedSearchInfo, "0", "/",$confValues['DOMAINNAME']);
  }//if
  
  //WRITE LOG FILE
  $varClientIP = getenv('REMOTE_ADDR');
  $varServerIP = getenv('SERVER_ADDR');
  $argFields  = array('MatriId','Logged_In_At','Client_IP','Server_IP');
  $argFieldsValue = array($objMasterDB->doEscapeString($varMatriId,$objMasterDB),"'".$varCurrentDate."'","'".$varClientIP."'","'".$varServerIP."'");
  $objMasterDB->insert($varTable['MEMBERLOGINLOG'], $argFields, $argFieldsValue);
 
  $objMasterDB->dbClose();
  $objSlaveDB->dbClose();
 
  UNSET($objMasterDB);
  UNSET($objSlaveDB);
 
  $varRedirect = preg_replace('/~/', '&', $varRedirect);
 
  if(trim($varMatriId)!='' && trim($varGender)!='') {
 
   $varCasteId = $confValues['DOMAINCASTEID'];
   $varGender = $varGender==1 ? 'M' : 'F';
   
   $varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
   escapeexec("php memlogin_curl.php $varCasteId $varMatriId $varGender $varOpenIp",$varlogFile);
    
  }
 
  if($varPublish=='5') { $varRedirect = $confValues['SERVERURL'].'/register/?act=cbsregister'; }
 
  if ($varCountryCode !="") { header("Location: ".$varRedirect.'&matriId='.$varMatriId); exit; }
  else { header("Location: ".$varRedirect); exit; }
 
 }//if
 else {
  $varAct    = 'login';
  $varErrorMessage = 'Invalid Username / E-mail OR Incorrect Password';
 }//else
}//if
?>