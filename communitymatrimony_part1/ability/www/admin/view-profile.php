<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================

//FILE INCLUDES
$varRootBasePathh = '/home/product/community/ability';
include_once($varRootBasePathh.'/conf/vars.inc');
include_once($varRootBasePathh.'/conf/payment.inc');
include_once($varRootBasePathh."/conf/cityarray.inc");
include_once($varRootBasePathh.'/lib/clsMailManager.php');
include_once($varRootBasePathh.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePathh.'/lib/clsCommon.php');

//OBJECT DECLARTION
$objDBSlave			= new MemcacheDB;
$objCommon			= new clsCommon;
$objProfileDetail	= new ProfileDetail;
$objMailManager		= new MailManager;

//DB CONNECTION
$objProfileDetail->dbConnect('S',$varDbInfo['DATABASE']);
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

function viewPermit($adminUserName='',$objDBSlave) {
	global $varDbInfo, $varTable;
	//DB CONNECTION
	//$objDBSlave = new DB;
	//$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
	$varCondition		= " WHERE User_Name='".$adminUserName."'";
	$varFields			= array('View_Counter');
	$varSelProfileId	= $objDBSlave->select($varTable['ADMINLOGININFO'],$varFields,$varCondition,1);
	$varViewCount		=  $varSelProfileId[0]['View_Counter'];
	return $varViewCount;
}

$varProfileViewPermit = viewPermit($adminUserName,$objDBSlave);
if ($varProfileViewPermit==0) {
	echo 'You were exceeded the limit to view the profile today. Please get contact your TeamHead to permit the same.';
	exit;
}


/* function to format the results set */
function formatResSet($varTempResSet)
{
   foreach($varTempResSet as $key=>$value)
    {
	  if(!$value)
	  $varTempResSet[$key]=0;
    }
	return $varTempResSet;
}
/* Functions to get member statistics details */
function getMemberStats($objDBSlave='',$varMatriId='') {
	global $varTable;
	$argCondition				= "WHERE MatriId='".$varMatriId."'";
	$varMemberStatsRes			= $objDBSlave->selectAll($varTable['MEMBERSTATISTICS'],$argCondition,1);
	$varMemberStatsRes=formatResSet($varMemberStatsRes);
	return $varMemberStatsRes;
}
/* Functions to get requestinfosent details */
function getRequestInfoSent($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE SenderId='".$varMatriId."' GROUP BY RequestFor";
	$varFields			= array('COUNT(RequestId) AS COUNT', 'RequestFor');
	$varExecute	= $objDBSlave->select($varTable['REQUESTINFOSENT'],$varFields,$varCondition,0);
	$varReqInfoSentRes=array();
	while($varRow = mysql_fetch_assoc($varExecute))
	{
       array_push($varReqInfoSentRes,$varRow);
	}
	if(empty($varReqInfoSentRes))
	{
		$varReqInfoSentRes[0]['COUNT']=0;
        $varReqInfoSentRes[1]['COUNT']=0;
		$varReqInfoSentRes[2]['COUNT']=0;
	}
	$varReqInfoSentRes=formatResSet($varReqInfoSentRes);
	return $varReqInfoSentRes;
}
/* Functions to get requestinforeceived details */
function getRequestInfoReceived($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE ReceiverId='".$varMatriId."' GROUP BY RequestFor";
	$varFields			= array('COUNT(RequestId) AS COUNT', 'RequestFor');
	$varExecute     	= $objDBSlave->select($varTable['REQUESTINFORECEIVED'],$varFields,$varCondition,0);
	$varReqInfoReceivedRes=array();
	while($varRow = mysql_fetch_assoc($varExecute))
	{
       array_push($varReqInfoReceivedRes,$varRow);
	}
	if(empty($varReqInfoReceivedRes))
	{
		$varReqInfoReceivedRes[0]['COUNT']=0;
        $varReqInfoReceivedRes[1]['COUNT']=0;
		$varReqInfoReceivedRes[2]['COUNT']=0;
	}
	$varReqInfoReceivedRes=formatResSet($varReqInfoReceivedRes);
	return $varReqInfoReceivedRes;
}
/* Functions to get bookmarkinfo details */
function getBookMarkInfo($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE matriid='".$varMatriId."'";
	$varFields			= array('COUNT(matriid) AS COUNT', 'matriId');
	$varExecute	        = $objDBSlave->select($varTable['BOOKMARKINFO'],$varFields,$varCondition,0);
	$varBookMarkInfoRes=mysql_fetch_assoc($varExecute);
	$varBookMarkInfoRes=formatResSet($varBookMarkInfoRes);
	return $varBookMarkInfoRes;
}
/* Functions to get blockinfo details */
function getBlockInfo($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE matriid='".$varMatriId."'";
	$varFields			= array('COUNT(matriid) AS COUNT', 'matriId');
	$varExecute     	= $objDBSlave->select($varTable['BLOCKINFO'],$varFields,$varCondition,0);
	$varBlockInfoRes  =mysql_fetch_assoc($varExecute);
	$varBlockInfoRes=formatResSet($varBlockInfoRes);
	return $varBlockInfoRes;
}
/* Functions to get phoneviewlist details */
function getPhoneViewListInfo($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE matriid='".$varMatriId."'";
	$varFields			= array('COUNT(matriid) AS COUNT', 'matriId');
	$varExecute	        = $objDBSlave->select($varTable['PHONEVIEWLIST'],$varFields,$varCondition,0);
	$varPhoneViewListInfoRes=mysql_fetch_assoc($varExecute);
	$varPhoneViewListInfoRes=formatResSet($varPhoneViewListInfoRes);
	return $varPhoneViewListInfoRes;
}
/*Function to get Total Request info received and sent count */
function getTotalReqInfoReceviedSent($varTempArray){ $varTotal=0;
  foreach($varTempArray as $value)
		{
	     foreach($value as $key=>$value1)
			{
              if($key == 'COUNT')
				{
                  $varTotal+=$value1;
				}
			}
		}
		return $varTotal;
}

if(($_POST['frmViewProfileSubmit'] == "yes") || ($_REQUEST["matrimonyId"]!=""))
{
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" WIDTH="543">
	<tr><td height="15" colspan="2"></td></tr>
	<tr>
		<td class="heading"  style="padding-left:15px;">View Profile</td>
		<td align="right"><a href="index.php?act=view-profile" class="formlink"><b>View other Profiles >></b></a>&nbsp;</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
</table>
<div style="clear:both"></div>
<?
	//VARIABLE DECLARATION
	$varMatriId 		= trim(strtoupper($_REQUEST["matrimonyId"]));
	$varCommunityId 	= trim(strtoupper($_REQUEST["communityid"]));

	$argCondition		= "WHERE MatriId='".$varMatriId."'";
	$varRecordsNumber	= $objProfileDetail->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$argCondition);

	if($varRecordsNumber==0 && $varCommunityId>0) {
		if($varCommunityId == '2503') {
			$varUserNameCond	= "CommunityId=2503 AND (User_Name='".$varMatriId."' OR User_Name='MUS-".$varMatriId."')";
		} else {
			$varUserNameCond	= "CommunityId=".$varCommunityId." AND User_Name='".$varMatriId."'";
		}
		$varCondition		= " WHERE ".$varUserNameCond;
		$varFields			= array('MatriId');
		$varSelProfileId	= $objProfileDetail->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);
		$varMatriId			=  $varSelProfileId[0]['MatriId'];
		$varMatriId != ''?$varRecordsNumber=1:$varRecordsNumber=0;
	}

	if($varRecordsNumber > 0) {

		$varFolderName		= $objMailManager->getFolderName($varMatriId);
		$arrDomainDetails	=$objMailManager->getDomainDetails($varMatriId);
		$varSiteName		= $arrDomainDetails['PRODUCTNAME'].'Matrimony';
		include_once($varRootBasePath."/domainslist/".$varFolderName."/conf.inc");

		$argFields 				= array('MatriId','Password','Email');
		$argCondition			= "WHERE MatriId='".$varMatriId."'";
		$varSelectUserNameRes	= $objProfileDetail->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectUserName		= mysql_fetch_assoc($varSelectUserNameRes);
		$varMatriId				= $varSelectUserName['MatriId'];
		$varPassword			= $varSelectUserName['Password'];
		$varEmail				= $varSelectUserName["Email"];


		//Getting Memcache detail
		$varOwnProfileMCKey		= 'ProfileInfo_'.$varMatriId;
		$argMCFields			= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
		$argMCCondition			= "WHERE MatriId='".$varMatriId."'";
		$varMCMemberInfo		= $objDBSlave->select($varTable['MEMBERINFO'],$argMCFields,$argMCCondition,0,$varOwnProfileMCKey);

		#Getting member information for the selected profile
		$argCondition				= "WHERE MatriId='".$varMatriId."'";
		$argFields 					= array('Name','Nick_Name','Age','Dob','Gender','Height','Height_Unit','Weight','Weight_Unit','Body_Type','Complexion','Eye_Color','Hair_Color','Physical_Status','Blood_Group','Marital_Status','No_Of_Children','Children_Living_Status','Education_Category','Education_Detail','Employed_In','Occupation','Occupation_Detail','Income_Currency','Annual_Income','Religion','CasteId','SubcasteId','Mother_TongueId','Horoscope_Match','Religious_Values','Ethnicity','Resident_Status','Country','Citizenship','Residing_State','Residing_Area','Residing_City','Residing_District','Contact_Address','Contact_Phone','Contact_Mobile','About_Myself','Eating_Habits','Smoke','Drink','Profile_Viewed','Profile_Created_By','Profile_Referred_By','Publish','Last_Login','Photo_Set_Status','Protect_Photo_Set_Status','Filter_Set_Status','Video_Set_Status','Partner_Set_Status','Family_Set_Status','Interest_Set_Status','Date_Created','Date_Updated','IPAddress','Paid_Status','Last_Payment','Valid_Days','Expiry_Date','Number_Of_Payments','Support_Comments','Horoscope_Available','Horoscope_Protected','Phone_Verified');
		$varMemberInfoRes			= $objProfileDetail->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varMemberInfo				= mysql_fetch_assoc($varMemberInfoRes);


		$varPaidDate				= $varMemberInfo["Last_Payment"];
		$varValidDays				= $varMemberInfo["Valid_Days"];
		$varExpiryDate				= $varMemberInfo["Expiry_Date"];
		$varExpiryDate				= date('d-M-Y H:i:s',strtotime($varExpiryDate));
		$varNumberOfPayment			= $varMemberInfo["Number_Of_Payments"];

		$varPaidStatus				= $varMemberInfo["Paid_Status"];
		$varPublish					= $varMemberInfo["Publish"];
		$varLastLogin				= $varMemberInfo["Last_Login"];
		$varLastLogin				= date('d-M-Y H:i:s',strtotime($varLastLogin));
		$varPhotoSetStatus			= $varMemberInfo["Photo_Set_Status"];
		$varProtectPhotoSetStatus	= $varMemberInfo["Protect_Photo_Set_Status"];
		$varHoroSetStatus			= $varMemberInfo["Horoscope_Available"];
		$varProtectHoroSetStatus	= $varMemberInfo["Horoscope_Protected"];
		$varFilterSetStatus			= $varMemberInfo["Filter_Set_Status"];
		$varVideoSetStatus			= $varMemberInfo["Video_Set_Status"];
		$varPartnerSetStatus		= $varMemberInfo["Partner_Set_Status"];
		$varFamilySetStatus			= $varMemberInfo["Family_Set_Status"];
		$InterestSetStatus			= $varMemberInfo["Interest_Set_Status"];
		$DateCreated				= $varMemberInfo["Date_Created"];
		$DateCreated				= date('d-M-Y H:i:s',strtotime($DateCreated));
		$DateUpdated				= $varMemberInfo["Date_Updated"];
		$DateUpdated				= date('d-M-Y H:i:s',strtotime($DateUpdated));
		$varCountry					= $varMemberInfo['Country'];
		$varResidingState			= $varMemberInfo['Residing_State'];
		$varPhoneVerified			= $varMemberInfo['Phone_Verified'];

		//get Phone from assured contact
		if($varPhoneVerified == 1) {
			$argFields						= array('CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1');
			$varAssuredContactInfoRes		= $objDBSlave->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
			$varAssuredContactInfo			= mysql_fetch_assoc($varAssuredContactInfoRes);
			if(($varAssuredContactInfo['PhoneNo']!='') && ($varAssuredContactInfo['MobileNo']!=''))
				$varTelephone = $varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['AreaCode'].'~'.$varAssuredContactInfo['PhoneNo'].'/'.$varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['MobileNo'];
			elseif(($varAssuredContactInfo['PhoneNo']!='') && ($varAssuredContactInfo['MobileNo']==''))
				$varTelephone = $varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['AreaCode'].'~'.$varAssuredContactInfo['PhoneNo'];
			elseif(($varAssuredContactInfo['PhoneNo']=='') && ($varAssuredContactInfo['MobileNo']!=''))
				$varTelephone = $varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['MobileNo'];
			else
				$varTelephone = '-';
		} else {
			if(($varMemberInfo['Contact_Phone']!='') && ($varMemberInfo['Contact_Mobile']!=''))
				$varTelephone = $varMemberInfo['Contact_Phone'].'/'.$varMemberInfo['Contact_Mobile'];
			elseif(($varMemberInfo['Contact_Phone']!='') && ($varMemberInfo['Contact_Mobile']==''))
				$varTelephone = $varMemberInfo['Contact_Phone'];
			elseif(($varMemberInfo['Contact_Phone']=='') && ($varMemberInfo['Contact_Mobile']!=''))
				$varTelephone = $varMemberInfo['Contact_Mobile'];
			else
				$varTelephone = '-';
		}

		//$varHeight					= $objCommon->getHeightUnit($varMemberInfo['Height'].'~'.$varMemberInfo['Height_Unit']);
		$varAbsHeight = $varMemberInfo['Height'];
		$arrHt = explode(".",$varAbsHeight);
		if($arrHt[1] == '00') {
			$varAbsHeight = str_replace(".00","",$varAbsHeight);
			$varHeight = $arrHeightFeetList[$arrParHeightList[$varAbsHeight]].' / '.round($varAbsHeight).' Cms';
		} else {
			if((trim($varAbsHeight)=='167.64') || (trim($varAbsHeight)=='167.74'))
			$varAbsHeight	= '167.74';
			$varHeight = $arrHeightFeetList[$varAbsHeight].' / '.round($varAbsHeight).' Cms';
		}

		$varAbsWeight = str_replace(".00","",$varMemberInfo['Weight']);
		if($varAbsWeight==0) {
			$varWeight = ' - ';
		} else {
			if($varMemberInfo['Weight_Unit'] == 'lbs') {
				$varWeight = round(($varMemberInfo['Weight'])/2.2).' Kgs / '.round($varMemberInfo['Weight']).' lbs';
			} else {
				$varWeight = round($varMemberInfo['Weight']).' Kgs / '.round($varMemberInfo['Weight']*2.2).' lbs';
			}
		}

		if(($varMemberInfo['Residing_State'] != '0' && $varMemberInfo['Residing_State'] != '') || $varMemberInfo['Residing_Area'] != '') {
			if ($varMemberInfo['Country']==98)	{ $varResidingState = $arrResidingStateList[$varMemberInfo['Residing_State']];} //if
			elseif ($varMemberInfo['Country']==222){ $varResidingState = $arrUSAStateList[$varMemberInfo['Residing_State']];}//elseif
			else {$varResidingState = $varMemberInfo['Residing_Area'];}
		} else {
			$varResidingState = '-';
		}

		if($varMemberInfo['Residing_City'] != '' || $varMemberInfo['Residing_District'] != 0) {
			if ($varMemberInfo['Country']==98) {
				$varResidingCity = ${$residingCityStateMappingList[$varMemberInfo['Residing_State']]}[$varMemberInfo['Residing_District']];
			} else {
				$varResidingCity = $varMemberInfo['Residing_City'];
			}
		} else {
			$varResidingCity = '-';
		}

		#Getting family information for the selected profile
		if($varFamilySetStatus == 1)
		{
			$argFields 					= array('Family_Value','Family_Type','Family_Status','Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family');
			$varFamilyInfoRes			= $objProfileDetail->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
			$varFamilyInfo				= mysql_fetch_assoc($varFamilyInfoRes);
		}

		#Getting hobbies & interest information for the selected profile
		if($InterestSetStatus == 1)
		{
			$argFields 					= array('Hobbies_Selected','Hobbies_Others','Interests_Selected','Interests_Others','Music_Selected','Music_Others','Books_Selected','Books_Others','Movies_Selected','Movies_Others','Sports_Selected','Sports_Others','Food_Selected','Food_Others','Dress_Style_Selected','Dress_Style_Others','Languages_Selected','Languages_Others');
			$varHobbiesInfoRes			= $objProfileDetail->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
			$varHobbiesInfo				= mysql_fetch_assoc($varHobbiesInfoRes);

			if($varHobbiesInfo['Hobbies_Selected'] != '') {
				$varHobbies = $objCommon->getArrayFromString($varHobbiesInfo['Hobbies_Selected'],$arrHobbiesList);
			}
			if($varHobbiesInfo['Hobbies_Others'] != '') {
				$varHobbies = $varHobbies.','.$varHobbiesInfo['Hobbies_Others'];
			}
			$varHobbies = trim($varHobbies,',');

			if($varHobbiesInfo['Interests_Selected'] != '') {
				$varInterest = $objCommon->getArrayFromString($varHobbiesInfo['Interests_Selected'],$arrInterestList);
			}
			if($varHobbiesInfo['Interests_Others'] != '') {
				$varInterest = $varInterest.','.$varHobbiesInfo['Interests_Others'];
			}
			$varInterest = trim($varInterest,',');

			if($varHobbiesInfo['Music_Selected'] != '') {
				$varMusics = $objCommon->getArrayFromString($varHobbiesInfo['Music_Selected'],$arrMusicList);
			}
			if($varHobbiesInfo['Music_Others'] != '') {
				$varMusics = $varMusics.','.$varHobbiesInfo['Music_Others'];
			}
			$varMusics = trim($varMusics,',');

			if($varHobbiesInfo['Books_Selected'] != '') {
				$varBooks = $objCommon->getArrayFromString($varHobbiesInfo['Books_Selected'],$arrReadList);
			}
			if($varHobbiesInfo['Books_Others'] != '') {
				$varBooks = $varBooks.','.$varHobbiesInfo['Books_Others'];
			}
			$varBooks = trim($varBooks,',');

			if($varHobbiesInfo['Movies_Selected'] != '') {
				$varMovies = $objCommon->getArrayFromString($varHobbiesInfo['Movies_Selected'],$arrMoviesList);
			}
			if($varHobbiesInfo['Movies_Others'] != '') {
				$varMovies = $varMovies.','.$varHobbiesInfo['Movies_Others'];
			}
			$varMovies = trim($varMovies,',');

			if($varHobbiesInfo['Sports_Selected'] != '') {
				$varSports = $objCommon->getArrayFromString($varHobbiesInfo['Sports_Selected'],$arrSportsList);
			}
			if($varHobbiesInfo['Sports_Others'] != '') {
				$varSports = $varSports.','.$varHobbiesInfo['Sports_Others'];
			}
			$varSports = trim($varSports,',');

			if($varHobbiesInfo['Food_Selected'] != '') {
				$varFood = $objCommon->getArrayFromString($varHobbiesInfo['Food_Selected'],$arrFoodList);
			}
			if($varHobbiesInfo['Food_Others'] != '') {
				$varFood = $varFood.','.$varHobbiesInfo['Food_Others'];
			}
			$varFood = trim($varFood,',');

			if($varHobbiesInfo['Dress_Style_Selected'] != '') {
				$varDress = $objCommon->getArrayFromString($varHobbiesInfo['Dress_Style_Selected'],$arrDressList);
			}
			if($varHobbiesInfo['Dress_Style_Others'] != '') {
				$varDress = $varDress.','.$varHobbiesInfo['Dress_Style_Others'];
			}
			$varDress = trim($varDress,',');

			if($varHobbiesInfo['Languages_Selected'] != '') {
				$varLanguage = $objCommon->getArrayFromString($varHobbiesInfo['Languages_Selected'],$arrSpokenLangList);
			}
			if($varHobbiesInfo['Languages_Others'] != '') {
				$varLanguage = $varLanguage.','.$varHobbiesInfo['Languages_Others'];
			}
			$varLanguage = trim($varLanguage,',');


		}

		#Getting partner preference information for the selected profile
		if($varPartnerSetStatus == 1)
		{
			$argFields 					= array('MatriId','Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Height_Unit','Physical_Status','Education','Religion','CasteId','SubcasteId','Citizenship','Country','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Date_Updated');
			$varPartnerInfoRes			= $objProfileDetail->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
			$varPartnerInfo				= mysql_fetch_assoc($varPartnerInfoRes);

			$varAgeFrom		= $varPartnerInfo["Age_From"];
			$varAgeTo		= $varPartnerInfo["Age_To"];
			//$varHeightFrom	= round($varPartnerInfo['Height_From']);
			//$varHeightTo	= round($varPartnerInfo['Height_To']);
			//$varPartnerHeightFrom = $objCommon->getHeightUnit($varPartnerInfo['Height_From'].'~'.$varPartnerInfo['Height_Unit']);
			//$varPartnerHeightTo	  = $objCommon->getHeightUnit($varPartnerInfo['Height_To'].'~'.$varPartnerInfo['Height_Unit']);

			$varAbsHeightFrom = $varPartnerInfo['Height_From'];
			$arrHtFrom = explode(".",$varAbsHeight);
			if($arrHtFrom[1] == '00') {
				$varAbsHeightFrom = str_replace(".00","",$varAbsHeightFrom);
				$varPartnerHeightFrom = $arrHeightFeetList[$arrParHeightList[$varAbsHeightFrom]];
			} else {
				$varPartnerHeightFrom = $arrHeightFeetList[$varAbsHeightFrom];
			}

			$varAbsHeightTo = $varPartnerInfo['Height_To'];
			$arrHtTo = explode(".",$varAbsHeight);
			if($arrHtTo[1] == '00') {
				$varAbsHeightTo = str_replace(".00","",$varAbsHeightTo);
				$varPartnerHeightTo = $arrHeightFeetList[$arrParHeightList[$varAbsHeightTo]];
			} else {
				$varPartnerHeightTo = $arrHeightFeetList[$varAbsHeightTo];
			}
			$varPartnerHeightFt = $varPartnerHeightFrom.'<b> to </b>'.$varPartnerHeightTo;

		}//if

		// Profile Photo details gathering - Starts
		#Getting protectedinfo for the selected profile
		if($varPhotoSetStatus == 1 || $varHoroSetStatus == 1 || $varHoroSetStatus == 3) {
			$argFields 					= array('MatriId', 'Normal_Photo1','Photo_Status1','Thumb_Small_Photo1', 'Photo_Protect_Password','Horoscope_Protected_Password','HoroscopeURL');
			$varPhotoInfoRes			= $objProfileDetail->select($varTable['MEMBERPHOTOINFO'],$argFields,$argCondition,0);
			$varPhotoInfo				= mysql_fetch_assoc($varPhotoInfoRes);

			$varIdPrefix		= substr($varMatriId,0,3);
			$funFirstFolder		= substr($varMatriId,3,1);
			$funSecondFolder	= substr($varMatriId,4,1);
			$varPhotoURL		= '/'.$funFirstFolder.'/'.$funSecondFolder.'/';
			$varPhotoName		= $confValues['IMGURL'].'/membersphoto/'.$arrFolderNames[$varIdPrefix].'/'.$funFirstFolder.'/'.$funSecondFolder.'/'.$varPhotoInfo['Thumb_Small_Photo1'];
			$varFileName="funViewPhoto('".$varMatriId."')";
			$varPhotoPassword = $varPhotoInfo['Photo_Protect_Password'];
			$varHoroPassword  = $varPhotoInfo['Horoscope_Protected_Password'];
			$varHoroName = $confValues['IMGURL'].'/membershoroscope/'.$arrFolderNames[$varIdPrefix].'/'.$funFirstFolder.'/'.$funSecondFolder.'/'.$varPhotoInfo['HoroscopeURL'];
		}

		if ($varPhotoSetStatus != 1) {
			//$varPhotoName	= 'images/viewphotonotfoundimg.gif';
			$varPhotoName	= $confValues['IMGSURL'].'/noimg50_m.gif';
			$varFileName	= '';
		}
		// Profile Photo details gathering - Ends

		// Membership Status
		if($varPaidStatus==1)
		{
			$varPaidDate		= $varPaidDate;
			//Calculate Valid days for Paid members
			$varLastPaidDate	= date('d-M-Y H:i:s',strtotime($varPaidDate));
			$varTodayDate		= date('m-d-Y');
			$varPaidDate		= date('m-d-Y',strtotime($varPaidDate));
			$varNumOfDays		= $objCommon->dateDiff("-",$varTodayDate,$varPaidDate);
			$varRemainingDays	= $varValidDays- $varNumOfDays;

			if($varRemainingDays <= 0) {
				$varRemainingDays = 0;
			}

			$argFields 			= array('MatriId','OrderId','Product_Id');
			$varPaymentRes		= $objProfileDetail->select($varTable['PAYMENTHISTORYINFO'],$argFields,$argCondition,0);
			$varPaymentInfo		= mysql_fetch_assoc($varPaymentRes);
			$varPackageName		= $arrPrdPackages[$varPaymentInfo['Product_Id']];

		}

		// Filter Status
		if(($varFilterSetStatus==1)&& ($varPublish!=2))
			$varStatus = 'Filter Set';
		elseif(($varFilterSetStatus==1) && ($varPublish==2))
			{	$varStatus = 'Filter Set and also Hidden'; }
		else
		{
			$varProfileStatus = array('1'=>'Opened','2'=>'Hided','3'=>'Suspended','4'=>'Rejected','0'=>'Visible');
			$varStatus = $varProfileStatus[$varPublish];
		}


		//Getting MatchWatchcount for passed MatriId
		$argCondition				= "WHERE MatriId='".$varMatriId."' AND Matchwatch!=0";
		$varMatchWatchCnt			= $objProfileDetail->numOfRecords($varTable['MAILMANAGERINFO'],'MatriId',$argCondition);

		$varMemberStatsRes        =    getMemberStats($objDBSlave, $varMatriId);
		$varTotalMailReceived=$varMemberStatsRes['Mail_Read_Received']+$varMemberStatsRes['Mail_UnRead_Received']+$varMemberStatsRes['Mail_Replied_Received']+$varMemberStatsRes['Mail_Declined_Received'];
		$varTotalMailSent=$varMemberStatsRes['Mail_Read_Sent']+$varMemberStatsRes['Mail_UnRead_Sent']+$varMemberStatsRes['Mail_Replied_Sent']+$varMemberStatsRes['Mail_Declined_Sent'];
		$varTotalInterestReceived=$varMemberStatsRes['Interest_Pending_Received']+$varMemberStatsRes['Interest_Accept_Received']+$varMemberStatsRes['Interest_Declined_Received'];
		$varTotalInterestSent=$varMemberStatsRes['Interest_Pending_Sent']+$varMemberStatsRes['Interest_Accept_Sent']+$varMemberStatsRes['Interest_Declined_Sent'];

		$varReqInfoSentRes        =    getRequestInfoSent($objDBSlave, $varMatriId);
		$varTotalReqInfoSent      =    getTotalReqInfoReceviedSent($varReqInfoSentRes);
        $varReqInfoReceivedRes    =	   getRequestInfoReceived($objDBSlave, $varMatriId);
		$varTotalReqInfoReceived  =    getTotalReqInfoReceviedSent($varReqInfoReceivedRes);
		$varBookMarkInfoRes       =	   getBookMarkInfo($objDBSlave, $varMatriId);
		$varBlockInfoRes          =	   getBlockInfo($objDBSlave, $varMatriId);
		$varPhoneViewListInfoRes  =    getPhoneViewListInfo($objDBSlave, $varMatriId);

		 // done by barani //
         //$varDuplicateEmailCount = getDuplicateEmails($varNewProfileDetails[$i][MatriId],$varEmail);
	     $varDuplicateEmailCount = $objProfileDetail->getDuplicateEmails($varMatriId,$varEmail);
	     $varDuplicateEmailLink = ($varDuplicateEmailCount)? "<a href=# onClick=javascript:window.open('/admin/view-duplicate-emails.php?email=$varEmail','popup','width=500,height=620'); class='smalltxt boldtxt'>Duplicate Emails(".$varDuplicateEmailCount.")</a><br><br>" : '';
         // end //
		?>
		<table border="0" cellpadding="0" cellspacing="0" WIDTH="537" style="padding-left:5px;">
		<tr><td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" WIDTH="532">
			<tr>
				<td valign="top" width="155" bgcolor="#FFFFFF" align="left" style="padding-top:5px;padding-left:5px;padding-right:1px;padding-bottom:5px;">
					<!-- Thumbnail Photo Display starts here -->
					<table border="0" cellpadding="0" cellspacing="0">
						<tr height="160">
							<td valign="top">

								<div class="formborderclr"><a href="javascript: <?=$varFileName;?>" GALLERYIMG="no" oncontextmenu="return false"><span id="id<?=$varMatriId;?>"><img border="0"
								src="<?=$varPhotoName;?>"  width="150" height="150" vspace="2" hspace="2"></span></a></div>
								<div style="padding-top:3px;padding-left:65px;">
								<?php if (isset($funPhotoPaging)) { ?></div>
								<div style="padding-left:40px;"><A href="javascript: funViewPhoto('<?=$varMatriId?>')" class='formlink'>Enlarge photo</a></font></div>
								<?php }//if ?></div>

								<div id="imagecontainer">
								<?  if($varPhotoSetStatus == 1) {
										$varPhotoDetail = $objProfileDetail->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
										$arrPhotoDetail = explode('~',$varPhotoDetail);

										// FOR FULL PROFILE OR MY PROFILE
										if($arrPhotoDetail[0] != '') {
											$varJsFunction	= "first_photo('".$arrPhotoDetail[0]."',1,'".$arrPhotoDetail[1]."',1,'".$varMatriId."','".$varViewTab."')";
											echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" alt="" border="0" height="0" width="0" onLoad="'.$varJsFunction.'">';
										}
									} else {
										?>
										<div id='useracticons'>
											<div id='useracticonsimgs' style='float: left;'>
												<div style='float: left;'>
													<!-- <a href='<?=$confValues['SERVERURL']?>/tools/index.php?act=tools&add=photo' style='cursor: pointer;'> -->
														<!-- <div class='useracticonsimgs <?=($varMemberInfo['Gender'] == 1) ? "photoaddmbig":"photoaddfbig"?>'></div> -->
													<!-- </a> -->
												</div>
											</div>
										</div>
										<?
									}?>
								 </div>
								 <div style="text-align: center;" id="undervalid"></div>
								 <div style="text-align: right;padding-left:30px;" id="backforthbuttons"></div>

							</td>
							<td valign="top" width="1"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1"></td>
							<td valign="top" bgcolor="#FFFFFF" class="smalltxt" STYLE="padding-top:5px;padding-left:5px;padding-right:0px;line-height:13px; font-style: normal; text-transform: none; color: #000000;" align="left" colspan=2>
								<div  class="viewbgclr" STYLE="padding-top:5px;padding-left:5px;padding-right:2px;line-height:13px; font-style: normal; text-transform: none; color: #000000;"><b><? echo "Sitename : ".$varSiteName?></b></div>
								<div  class="viewbgclr" STYLE="padding-top:5px;padding-left:5px;padding-right:2px;line-height:13px; font-style: normal; text-transform: none; color: #000000;"><b><? echo "MatriId : ".$varMatriId?></b></div>
								<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="7"><br>
								<div  class="viewbgclr" STYLE="padding-top:5px;padding-left:5px;padding-right:2px;line-height:13px; font-style: normal; text-transform: none; color: #000000;"><?=$varMemberInfo['Gender']==1 ? "Male" : "Female"?> - <?=$arrMaritalList[$varMemberInfo['Marital_Status']];?><br>
								<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="7"><br>
								Profile created by: <?=$arrProfileCreatedByList[$varMemberInfo['Profile_Created_By']];?> <br>
								<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="7"><br>
								Profile referred by: <?=$arrProfileReferredList[$varMemberInfo['Profile_Referred_By']];?> <br>
								<? if ($sessUserType=='2') { ?><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="7"><br>
								<b>Email: <?=$varEmail;?></b><br><? } ?>
								<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="7"><br>
								<!-- <? if ($varHoroSetStatus == 1 || $varHoroSetStatus == 3) { ?><a href='<?=$varHoroName?>' target='_blank'>View Horoscope</a><? } else { ?> View Horoscope [No Horoscope] <? } ?> -->
								<? if ($varPhotoInfo['HoroscopeURL']!='' && ($varHoroSetStatus == 1 || $varHoroSetStatus == 3)) { ?><a href="adminhoroshow.php?mid=<?=$varMatriId?>&type=<?=$varHoroSetStatus?>&horo=<?=urlencode($varHoroName)?>" target='_blank'>View Horoscope</a><? } else { ?> View Horoscope [No Horoscope] <? } ?>
								<!--<br><br>Phone :--> <?php //echo $varTelephone; ?>
								<br><br>Verified Phone : <? if ($varPhoneVerified == 1) { ?><a onclick="window.open('adminviewphone.php?Mid=<?=$varMatriId?>', '','height=600, width=480');" ><b>View Phone number</b></a> <? } else { ?> Wrong Phone number <? } ?>
								<br><? if ($sessUserType=='3') { ?><a onclick="window.open('sendemail.php?eid=<?=base64_encode($varEmail)?>', '','height=600, width=480');" ><b>Send Email</b></a><? } ?>
								<br><?=$varDuplicateEmailLink?>
								<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="15"><br>
							</td>
							<!-- <td valign="top" width="10"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="1"></td> -->
						</tr>
					</table>
					<!-- Thumbnail Photo Display starts here -->
				</td>
			</tr>
		</table><br>

		<? if ($sessUserType=='2') { ?>
		<!-- General Details starts here-->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">General Details</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Partner preference <br>status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varPartnerSetStatus==0?'OFF':'ON'; ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Match watch <br> Email status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMatchWatchCnt!=0?'ON':'OFF'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Time created :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $DateCreated!=''?$DateCreated:'-'; ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Time modified :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $DateUpdated!=''?$DateUpdated:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Email :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varEmail!=''?$varEmail:'-'; ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Referred by :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMemberInfo['Profile_Referred_By']!='0'?$arrProfileReferredList[$varMemberInfo['Profile_Referred_By']]:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Telephone :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varTelephone ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Last login :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varLastLogin!=''?$varLastLogin:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Added by :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMemberInfo['Profile_Created_By']!=''?$arrProfileCreatedByList[$varMemberInfo['Profile_Created_By']]:'-'; ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Authorized :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">True</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Validated :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?
					$varPublish = $varMemberInfo["Publish"];
					if (($varPublish=="0") || ($varPublish=="4")) { echo 'False';}
					else  { echo 'True';}
					?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varStatus; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Host :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMemberInfo['IPAddress']!=''?$varMemberInfo['IPAddress']:'-'; ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Phone Verified :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?=(($varPhoneVerified==1)?'Yes':'No')?></td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Comments :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><?= $varMemberInfo['Support_Comments']!=''?$varMemberInfo['Support_Comments']:'-'; ?>
				</td>
			</tr>

			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
		 </table><br>
		<!-- General Details starts here-->
		<? } ?>

		<!--Membership details starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Membership Details</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Membership Type :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varPaidStatus==0?'Free':'Paid'; ?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Package Name :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varPaidStatus==1?$varPackageName:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Last payment :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varPaidDate!=''?$varLastPaidDate:'-'; ?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Expiry Date :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varRemainingDays!=0?$varExpiryDate:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Package Valid days :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varValidDays!=0?$varValidDays:'-'; ?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="29%">Remaining Valid days :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varRemainingDays!=0?$varRemainingDays:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Number of Payments :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">&nbsp;<?=$varNumberOfPayment; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
		</table><br>
		<!--Membership details ends here -->

		<!--Profile password details starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Profile Password Details</td>
			</tr>
			<? if ($sessUserType=='2') { ?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Login Password:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varPassword?>
				</td>
			</tr>
			<? } ?>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Photo Protected:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varProtectPhotoSetStatus==1) ? 'Yes' : 'No';?></td>
				<? if ($sessUserType=='2') { ?>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Photo Password :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varProtectPhotoSetStatus==1) ? $varPhotoPassword : '~Not Available~';?>
				</td>
				<? } ?>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Horoscope Protected:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varProtectHoroSetStatus==1) ? 'Yes' : 'No';?></td>
				<? if ($sessUserType=='2') { ?>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Horoscope Password :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varProtectHoroSetStatus==1) ? $varHoroPassword : '~Not Available~';?>
				</td>
				<? } ?>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
		</table><br>
		<!--Profile password details ends here -->

		<!--Member Statistics details starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Member Statistics Details</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Messages Received(<?=$varTotalMailReceived?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">New Messages(<?=$varMemberStatsRes['Mail_UnRead_Received']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Awaiting my reply(<?=$varMemberStatsRes['Mail_Read_Received']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Replied messages(<?=$varMemberStatsRes['Mail_Replied_Received']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Messages I've declined(<?=$varMemberStatsRes['Mail_Declined_Received']?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Messages Sent(<?=$varTotalMailSent?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Replies Received(<?=$varMemberStatsRes['Mail_Replied_Sent']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Read by members(<?=$varMemberStatsRes['Mail_Read_Sent']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Unread messages(<?=$varMemberStatsRes['Mail_UnRead_Sent']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Declined by members(<?=$varMemberStatsRes['Mail_Declined_Sent']?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Interests Received(<?=$varTotalInterestReceived?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">New Interests(<?=$varMemberStatsRes['Interest_Pending_Received']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Interests accepted(<?=$varMemberStatsRes['Interest_Accept_Received']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Interests declined(<?=$varMemberStatsRes['Interest_Declined_Received']?>)</td>
				<!-- <td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Filtered Interests(0)</td> -->
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Interests Sent(<?=$varTotalInterestSent?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Accepted by members(<?=$varMemberStatsRes['Interest_Accept_Sent']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Reply pending from members(<?=$varMemberStatsRes['Interest_Pending_Sent']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Declined by members(<?=$varMemberStatsRes['Interest_Declined_Sent']?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Request Received(<?=$varTotalReqInfoReceived?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Photo(<?=$varReqInfoReceivedRes[0]['COUNT']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Phone Number(<?=$varReqInfoReceivedRes[1]['COUNT']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Horoscope(<?=$varReqInfoReceivedRes[2]['COUNT']?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Request Sent(<?=$varTotalReqInfoSent?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Photo(<?=$varReqInfoSentRes[0]['COUNT']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Phone Number(<?=$varReqInfoSentRes[1]['COUNT']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Horoscope(<?=$varReqInfoSentRes[2]['COUNT']?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Lists</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Members I have short-listed(<?=$varBookMarkInfoRes['COUNT']?>)</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">Members I have blocked(<?=$varBlockInfoRes['COUNT']?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Views</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Members who viewed my Phone No(<?=$varPhoneViewListInfoRes['COUNT']?>)</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Match Watch Email</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Match Watch Email(<?=$varMemberStatsRes['Match_Watch_Email']?>)</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
		</table><br>
		<!--Member Statistics details ends here -->

		<!-- BASIC INFORMATION STARTS HERE-->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Basic Information</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Name:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=($varMemberInfo['Name']!='')? $varMemberInfo['Name'] : '-';?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Display Name:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=($varMemberInfo['Nick_Name']!='') ? $varMemberInfo['Nick_Name'] : "-";?>
				</td>
			</tr>

			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Age:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varMemberInfo['Age'] ? $varMemberInfo['Age'] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Religion:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?	if(array_key_exists($varMemberInfo['Religion'],$arrReligionList))
						{
							print $arrReligionList[$varMemberInfo['Religion']];
						}
					?>
				</td>
			</tr>

			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<!-- <td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Caste :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?	if(array_key_exists($varMemberInfo['CasteId'],$arrCasteList))
						{
							print $arrCasteList[$varMemberInfo['CasteId']];
						}
					?>
				</td> -->
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Subcaste :</td>
				<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?
						if(array_key_exists($varMemberInfo['SubcasteId'],$arrSubcasteList)) {
							print $arrSubcasteList[$varMemberInfo['SubcasteId']];
						} else {
							print $varMemberInfo['SubcasteId'];
						}
					?>
				</td>
			</tr>

			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Horoscope Match :</td>
				<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?
						if(array_key_exists($varMemberInfo['Horoscope_Match'],$arrHoroscopeList)) {
							print $arrHoroscopeList[$varMemberInfo['Horoscope_Match']];
						}
					?>
				</td>
				<td valign="top"  class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Resident status :</td>
				<td valign="top"  class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Resident_Status'] ? $arrResidentStatusList[$varMemberInfo['Resident_Status']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Citizenship :</td>
				<td valign="top" width="165" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Citizenship'] ? $arrCountryList[$varMemberInfo['Citizenship']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Country living in :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varCountry ? $arrCountryList[$varCountry] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">No. of Children:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['No_Of_Children'] ? $varMemberInfo['No_Of_Children'] : "No";?>
				</td>
				<td valign="top"  class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Children living status :</td>
				<td valign="top"  class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?php
						if ($varMemberInfo['Children_Living_Status'] == 1) { echo "Not living with me"; }
						else{
							if ($varMemberInfo['No_Of_Children'] !="0"){ echo 'Living with me'; }//if
							else { echo '-'; };//else
							}
					?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
		</table><br>
		<!-- BASIC INFORMATION ENDS HERE-->

		<!-- About myself Information starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader"><td valign="top" style="padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;text-align:justify;">About myself</td></tr>
			<tr bgcolor="#FFFFFF">
			   <td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">
					<?=$varMemberInfo['About_Myself'] ? str_replace("''","'",$varMemberInfo['About_Myself']) : "-";?>
			   </td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
		</table><br>
		<!-- About myself Information ends here -->

		<!-- My Appearance starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">My Appearance</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Complexion:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varMemberInfo['Complexion']!="0" ? $arrComplexionList[$varMemberInfo['Complexion']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Physical status:</td>
				<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varMemberInfo['Physical_Status'] ? $arrPhysicalStatusList[$varMemberInfo['Physical_Status']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?= $varMemberInfo['Height']!='0.00'?$varHeight:'-'; ?></td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Weight :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Weight']!='0.00' ? $varWeight : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Body type :</span></td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Body_Type']!="0" ? $arrBodyTypeList[$varMemberInfo['Body_Type']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Blood group :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varMemberInfo['Blood_Group']!="0")? $arrBloodGroupList[$varMemberInfo['Blood_Group']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
		</table><br>
		<!-- My Appearance ends here -->

		<!-- My LifeStyle starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">My LifeStyle </td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Education :</td>
				<td valign="top" class="smalltxt" width="25%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varMemberInfo['Education_Category']!=10 ? $arrEducationList[$varMemberInfo['Education_Category']] : "Not specified";?>
				</td>
				<td valign="top" width="25%" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education in detail :</td>
				<td valign="top" class="smalltxt" width="25%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?
					if($varMemberInfo['Education_Detail']!='')
						echo wordwrap($varMemberInfo['Education_Detail'], 20, "<br>");
					else
					 echo "-";
				?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Employed in :</td>
				<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Employed_In'] ? $arrEmployedInList[$varMemberInfo['Employed_In']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varMemberInfo['Occupation']!="0" && $varMemberInfo['Occupation']!="60")? ltrim($arrOccupationList[$varMemberInfo['Occupation']],'&nbsp;&nbsp;') : "Not specified";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation in detail :</td>
				<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?
					if($varMemberInfo['Occupation_Detail']!='')
						echo wordwrap($varMemberInfo['Occupation_Detail'], 20, "<br>");
					else
					 echo "-";
				?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Annual income :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Annual_Income'] !="0.00" ? $arrSelectCurrencyList[$varMemberInfo['Income_Currency']].' '.$varMemberInfo['Annual_Income'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Eating_Habits'] ? $arrEatingHabitsList[$varMemberInfo['Eating_Habits']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Drink'] ? $arrDrinkListList[$varMemberInfo['Drink']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<?=$varMemberInfo['Smoke'] ? $arrSmokeListList[$varMemberInfo['Smoke']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
		</table><br>
		<!-- My LifeStyle ends here -->

		<!-- Home Truths starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Home Truths </td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" width="25%" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Family values :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
				<?=$arrFamilyValuesList[$varFamilyInfo['Family_Value']]? $arrFamilyValuesList[$varFamilyInfo['Family_Value']] : "-";?></td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Native language :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=($varMemberInfo['Mother_TongueId']!="0")? $arrMotherTongueList[$varMemberInfo['Mother_TongueId']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing state :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varResidingState; ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing city / district :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varResidingCity; ?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
		</table><br>
		<!--Home Truths ends here-->

		<!-- Family Details Starts Here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">My Family Details</td></tr>
			<?php if ($varFamilySetStatus == 0) { ?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">Family Details not set by the member</td>
			</tr>
			<br> <? } else { ?> <br>
			<!-- Start of Primary Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Value :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Value'] ? $arrFamilyValuesList[$varFamilyInfo['Family_Value']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Type :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Type'] ? $arrFamilyType[$varFamilyInfo['Family_Type']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Status'] ? $arrFamilyStatus[$varFamilyInfo['Family_Status']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Father's Occupation :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Father_Occupation'] ? $varFamilyInfo['Father_Occupation'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Mother's Occupation :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Mother_Occupation'] ? $varFamilyInfo['Mother_Occupation'] : "-";?>
				</td>
			</tr>
			<tr <tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Origin :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Origin'] ? $varFamilyInfo['Family_Origin'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Brothers :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Brothers'] ? $varFamilyInfo['Brothers'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Married Brothers :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Brothers_Married'] ? $varFamilyInfo['Brothers_Married'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">sisters :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Sisters'] ? $varFamilyInfo['Sisters'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Married Sisters :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Sisters_Married'] ? $varFamilyInfo['Sisters_Married'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">About Family :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['About_Family'] ? $varFamilyInfo['About_Family'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<? } ?>
		</table><br>
		<!-- Family Details End Here -->

		<!-- Hobbies & Interest Starts Here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Hobbies & Interest</td></tr>
			<?php if ($InterestSetStatus == 0) { ?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">Hobbies and Interest details not set by the member</td>
			</tr>
			<br> <? } else { ?> <br>
			<!-- Start of Primary Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Hobbies :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varHobbies != ''? $varHobbies : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Interests :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varInterest != ''? $varInterest : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Musics :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varMusics != ''? $varMusics : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Books :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varBooks != ''? $varBooks : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Movies :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varMovies != ''? $varMovies : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Sports :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varSports != ''? $varSports : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Cuisine :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFood != ''? $varFood : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Dess Style Brothers :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varDress != ''? $varDress : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Languages :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varLanguage != ''? $varLanguage : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<? } ?>
		</table><br>
		<!-- Hobbies & Interest End Here -->

		<!-- Partner Preference Specifications starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">My Partner Preference</td></tr>
			<?php if ($varPartnerSetStatus == 0) { ?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">Partner Preference not set by the member</td>
			</tr>
			<br> <? } else { ?> <br>
			<!-- Start of Primary Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Looking for :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varPartnerInfo['Looking_Status'] ? $objCommon->getArrayFromString($varPartnerInfo['Looking_Status'],$arrMaritalList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Age :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					Between <?=$varAgeFrom ? $varAgeFrom : "-";?> and <?=$varAgeTo ? $varAgeTo : "-";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?= $varPartnerHeightFt;?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Physical status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Physical_Status'] ? $arrPhysicalStatusList[$varPartnerInfo['Physical_Status']] : "-";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Native language :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Mother_Tongue'] ? $objCommon->getArrayFromString($varPartnerInfo['Mother_Tongue'],$arrMotherTongueList) : "Any";
				?>
				</td>
			</tr>
			<!-- End of Primary Preference -->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of Socio-Religious Preference -->
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Sect :</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
			<?=$varPartnerInfo['Religion'] ? $objCommon->getArrayFromString($varPartnerInfo['Religion'],$arrReligionList) : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Sub sect :</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
			<?=$varPartnerInfo['CasteId'] ? $objCommon->getArrayFromString($varPartnerInfo['CasteId'],$arrCasteDivisionList) : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Caste :</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
			<?=$varPartnerInfo['SubcasteId'] ? $objCommon->getArrayFromString($varPartnerInfo['SubcasteId'],$arrSubcasteList) : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Eating_Habits']!="")? $arrEatingHabitsList[$varPartnerInfo['Eating_Habits']] : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Drinking_Habits']!="")? $arrDrinkList[$varPartnerInfo['Drinking_Habits']] : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Smoking_Habits']!="")? $arrSmokeList[$varPartnerInfo['Smoking_Habits']] : "-";?>
			</td>
			</tr>
			<!-- End of Socio-Religious Preference -->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of Educational Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Education'] ? $objCommon->getArrayFromString($varPartnerInfo['Education'],$arrEducationList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- End of Educational Preference -->
			<!-- Start of Location Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Citizenship:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Citizenship'] ? $objCommon->getArrayFromString($varPartnerInfo['Citizenship'],$arrCountryList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Country living in :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Country'] ? $objCommon->getArrayFromString($varPartnerInfo['Country'],$arrCountryList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr class="viewbgclr"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Resident status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Resident_Status'] ? $objCommon->getArrayFromString($varPartnerInfo['Resident_Status'],$arrResidentStatusList) : "Any";?>
				</td>
			</tr>
			<!-- End of Location Preference -->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of About my partner -->
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">About my partner :</td>
			<td valign="top" class="smalltxt"  style="padding-top:5px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">
				<?=$varPartnerInfo['Partner_Description'] ? $varPartnerInfo['Partner_Description'] : "-";?>
			</td>
			</tr>
			<!-- End of About my partner -->
			<? } ?>
		</table><br>
		<!-- Partner Preference Specifications ends here -->

		</td></tr>
		<tr>
		<td align="center"><a href="index.php?act=view-profile" class="grtxt"><b><u><font class="smalltxt boldtxt" color="red">View other Profiles >></font></u></b></a>&nbsp;</td>
		</tr>
		</table><br>
	<?
	} else { //else
		echo '<br><table width="532" border="0" cellspacing="0" cellpadding="0" align="center" class="viewpgborderclr" valign="top"><tr><td class="errorMsg" height="40" valign="middle" align="center">No members match with your selected criteria. <a href="index.php?act=view-profile" class="formlink"><b>Click here to try again</b></a></td></tr><tr><td height="10"></td></tr><tr><td></td></tr></table>';
	}
	$objProfileDetail->dbClose();
}//if
else {
?>
	<table border="0" cellpadding="0" cellspacing="0" align="left" WIDTH="542">
		<tr><td height="15" colspan="3"></td></tr>
		<tr><td valign="middle" class="heading" colspan="3"  style="padding-left:15px;_padding-left:15px;">View Profile</td></tr>
		<tr><td height="10" colspan="3"></td></tr>
		<form name="frmViewProfile" method="post" onSubmit="return funViewProfileId();">
		<input type="hidden" name="frmViewProfileSubmit" value="yes">
		<tr>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>MatrimonyId / UserName</b>&nbsp;</td>
			<td class="smalltxt"><input type=text name="matrimonyId" size="15" class="normaltxt1">&nbsp;</td>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Community</b>&nbsp;</td>
			<td class="smalltxt">
				<select name="communityid">
					<option value="">Select</option>
					<option value="2503">MuslimMatrimony</option>
					<option value="2500">ChristianMatrimony</option>
					<option value="2502">SikhMatrimony</option>
					<option value="2501">JainMatrimony</option>
					<option value="2504">BuddishtMatrimony</option>
				</select>
			</td>
		</tr>
		<tr><td height="30" colspan="3"></td></tr>
		<tr><td height="30" colspan="3" align="center">
			<input type="Submit" Value="Submit" class="button">
		</td></tr>
		</form>
	</table>
<?
}
?>
<?
//UNSET OBJECT
unset($objProfileDetail);
unset($objCommon);
include_once "adminviewlog.php";
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmViewProfile;
	if (frmName.matrimonyId.value=="")
	{
		alert("Please enter  matrimony Id");
		frmName.matrimonyId.focus();
		return false;
	}//if
	return true;
}//funViewProfileId
var argPlaceHolderId;
function funShowPhoto(argMatriId,argPhotoName)
{
	argPlaceHolderId="id" + argMatriId;
	document.getElementById(argPlaceHolderId).innerHTML = "<img src="+varConfArr['webimgs']+"/"+argPhotoName+"' style='padding:2px;width:150px;height:150px;' align='center' border=0>";
}//showPhoto

function funViewPhoto(argMatrId)
{
	//img_url+"/photo/viewphoto.php?ID="+matid+"&PNO="+ph_no;
	var funUrl = "http://www.communitymatrimony.com/admin/adminshowphoto.php?MATRIID=" + argMatrId;
	window.open(funUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=660,height=600,status=no,scrollbars=no,titlebar=no;");
}//funViewPhoto
</script>