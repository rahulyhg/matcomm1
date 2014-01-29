<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================

//FILE INCLUDES
$varRootBasePathh = '/home/product/community';
include_once($varRootBasePathh.'/conf/vars.cil14');
include_once($varRootBasePathh.'/conf/payment.cil14');
include_once($varRootBasePathh.'/conf/config.cil14');
include_once($varRootBasePathh."/conf/cityarray.cil14");
include_once($varRootBasePathh."/conf/domainlist.cil14");
include_once($varRootBasePath.'/conf/tblfields.cil14');
include_once($varRootBasePathh.'/lib/clsMailManager.php');
include_once($varRootBasePathh.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePathh.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsPhoneSupport.php');
include_once($varRootBasePathh.'/www/payment/getcountry.php');

//GET MEMBERSTATUS
$varActStatus = $_REQUEST['actstatus'];  // If yes - active members ,no - inactive members

$arrPrdPackages[56] = 'Privilege 1 Month'; // Added privilege 1 month temp., here

//Variable Declaration
$varLastPaidDate = '-';

//OBJECT DECLARTION
$objDBSlave	        = new MemcacheDB;
$objCommon			= new clsCommon;
$objProfileDetail	= new ProfileDetail;
$objMailManager		= new MailManager;
$objSlave			= new PhoneSupport;

//DB CONNECTION
if( $varActStatus =='no') {  // CONNECTION FOR INACTIVE DB
	$objProfileDetail->dbConnect('S',$varInactiveDbInfo['DATABASE']);
	$objDBSlave->dbConnect('S',$varInactiveDbInfo['DATABASE']);
	$varTitle = 'View Inactive Profile';
} else if( $varActStatus =='yes') {  // CONNECTION FOR ACTIVE DB
	$objProfileDetail->dbConnect('S',$varDbInfo['DATABASE']);
	$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
	$varTitle = 'View Profile';
}

function viewPermit($adminUserName='',$objDBSlave) {
	global $varDbInfo, $varTable;
	$varCondition		= " WHERE User_Name='".$adminUserName."'";
	$varFields			= array('View_Counter');
	$varSelProfileId	= $objDBSlave->select($varTable['ADMINLOGININFO'],$varFields,$varCondition,1);
	$varViewCount		=  $varSelProfileId[0]['View_Counter'];
	return $varViewCount;
}

//LIMIT PROVIDED ONLY FOR ACTIVE MEMBERS
if ( $varActStatus=='yes') {
	$varProfileViewPermit = viewPermit($adminUserName,$objDBSlave);
	if ($varProfileViewPermit==0) {
		echo 'You were exceeded the limit to view the profile today. Please get contact your TeamHead to permit same.';
		exit;
	}
}


// function to assign value 0 if its null
function assignValue($varTemp) {
	if($varTemp == '') {
		$varTemp=0;
	}
	return "<b>".$varTemp."</b>";
}

/* Functions to get member statistics details */
function getMemberStats($objDBSlave='',$varMatriId='') {
	global $varTable;
	$argCondition		= "WHERE MatriId='".$varMatriId."'";
	$varFields=array('Mail_Read_Received','Mail_UnRead_Received','Mail_Replied_Received','Mail_Declined_Received','Mail_Read_Sent','Mail_UnRead_Sent','Mail_Replied_Sent','Mail_Declined_Sent','Interest_Pending_Received','Interest_Accept_Received','Interest_Declined_Received','Interest_Pending_Sent','Interest_Accept_Sent','Interest_Declined_Sent','Match_Watch_Email');
	$varExecute			= $objDBSlave->select($varDbInfo['DATABASE'].'.'.$varTable['MEMBERSTATISTICS'],$varFields,$argCondition,0);
    $varMemberStatsRes = mysql_fetch_assoc($varExecute);
	return $varMemberStatsRes;
}
	
/* Functions to get requestinfosent details */
function getRequestInfoSent($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE SenderId='".$varMatriId."' GROUP BY RequestFor";
	$varFields			= array('COUNT(RequestId) AS COUNT', 'RequestFor');
	$varExecute	= $objDBSlave->select($varDbInfo['DATABASE'].'.'.$varTable['REQUESTINFOSENT'],$varFields,$varCondition,0);
	while($varRow = mysql_fetch_array($varExecute)) {
       if($varRow[1] == 1) {
	     $varReqInfoSentRes['Photo'] = $varRow[0];
	   }
	   else if($varRow[1] == 3) {
	     $varReqInfoSentRes['Phone'] = $varRow[0];
	   }
	   else if($varRow[1] == 5) {
	     $varReqInfoSentRes['Horoscope'] = $varRow[0];
	   }
	}
	return $varReqInfoSentRes;
}
/* Functions to get requestinforeceived details */
function getRequestInfoReceived($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE ReceiverId='".$varMatriId."' GROUP BY RequestFor";
	$varFields			= array('COUNT(RequestId) AS COUNT', 'RequestFor');
	$varExecute     	= $objDBSlave->select($varDbInfo['DATABASE'].'.'.$varTable['REQUESTINFORECEIVED'],$varFields,$varCondition,0);
	while($varRow = mysql_fetch_array($varExecute)) {
       if($varRow[1] == 1) {
	     $varReqInfoReceivedRes['Photo'] = $varRow[0];
	   }
	   else if($varRow[1] == 3) {
	     $varReqInfoReceivedRes['Phone'] = $varRow[0];
	   }
	   else if($varRow[1] == 5) {
	     $varReqInfoReceivedRes['Horoscope'] = $varRow[0];
	   }
	}
	return $varReqInfoReceivedRes;
}

/* Functions to get bookmarkinfo details */
function getBookMarkInfo($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE matriid='".$varMatriId."'";
	$varFields			= array('COUNT(matriid) AS COUNT', 'matriId');
	$varExecute	        = $objDBSlave->select($varDbInfo['DATABASE'].'.'.$varTable['BOOKMARKINFO'],$varFields,$varCondition,0);
	$varBookMarkInfoRes=mysql_fetch_assoc($varExecute);
	return $varBookMarkInfoRes;
}
/* Functions to get blockinfo details */
function getBlockInfo($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE matriid='".$varMatriId."'";
	$varFields			= array('COUNT(matriid) AS COUNT', 'matriId');
	$varExecute     	= $objDBSlave->select($varDbInfo['DATABASE'].'.'.$varTable['BLOCKINFO'],$varFields,$varCondition,0);
	$varBlockInfoRes  =mysql_fetch_assoc($varExecute);
	return $varBlockInfoRes;
}
/* Functions to get phoneviewlist details */
function getPhoneViewListInfo($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE matriid='".$varMatriId."'";
	$varFields			= array('COUNT(matriid) AS COUNT', 'matriId');
	$varExecute	        = $objDBSlave->select($varDbInfo['DATABASE'].'.'.$varTable['PHONEVIEWLIST'],$varFields,$varCondition,0);
	$varPhoneViewListInfoRes=mysql_fetch_assoc($varExecute);
	return $varPhoneViewListInfoRes;
}
/* Functions to get Viewed phone by member details */
function getViewedPhoneListByMember($objDBSlave='',$varMatriId='') {
	global $varTable;
	$varCondition		= " WHERE Opposite_MatriId='".$varMatriId."'";
	$varFields			= array('COUNT(matriid) AS COUNT', 'matriId');
	$varExecute	        = $objDBSlave->select($varDbInfo['DATABASE'].'.'.$varTable['PHONEVIEWLIST'],$varFields,$varCondition,0);
	$varViewedPhoneListByMemberRes=mysql_fetch_assoc($varExecute);
	return $varViewedPhoneListByMemberRes;
}

//Function to get DatePaid for Auto renewal status
function getPaymentHistory($objDBSlave,$varMatriId) {
	global $varTable;
	$varFields			= array('Date_Paid','Currency');
	$varCondition		= 'WHERE MatriId="'.$varMatriId.'" AND Product_Id<100 ORDER BY Date_Paid DESC Limit 1';
	$varExecute			= $objDBSlave->select($varTable['PAYMENTHISTORYINFO'],$varFields,$varCondition,0);
	$varPaidMemberInfo	= mysql_fetch_assoc($varExecute);
	return $varPaidMemberInfo;
}

//Function to get Currenct and autorenewal status
function getOnlinePaymentDetails($objDBSlave,$varMatriId) {
	global $varTable;
	$varFields			= array('Currency','Auto_Renew');
	$varCondition		= 'Where MatriId="'.$varMatriId.'"';
	$varExecute			= $objDBSlave->select($varTable['ONLINEPAYMENTDETAILS'],$varFields,$varCondition,0);
	$varPaymentDetails  = mysql_fetch_assoc($varExecute);
	return $varPaymentDetails;
}

if(($_POST['frmViewProfileSubmit'] == "yes") || ($_REQUEST["matrimonyId"]!="")) {
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" WIDTH="543">
	<tr><td height="15" colspan="2"></td></tr>
	<tr>
		<td class="heading"  style="padding-left:15px;"><?=$varTitle; ?></td>
		<td align="right"><a href="index.php?act=profile" class="formlink"><b>View other Profiles >></b></a>&nbsp;</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
</table>
<div style="clear:both"></div>
<?
	//VARIABLE DECLARATION
	 $varMatriId 		= trim(strtoupper($_REQUEST["matrimonyId"]));
	//$varCommunityId 	= trim(strtoupper($_REQUEST["communityid"]));
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

	// GET MAIL RECEIVED STATISTICS
	 $varCondition					= " WHERE MatriId='".$varMatriId."'";
	 $varMailReceivedCount			= $objProfileDetail->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=1";
	$varNotRepliedMsgRecievedCount	= $objProfileDetail->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=2";
	$varRepliedMsgRecievedCount		= $objProfileDetail->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=3";
	$varDeclineMsgRecievedCount		= $objProfileDetail->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);


	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=0";
	 $varNewMsgRecievedCount			= $objProfileDetail->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=6 OR Status=7 OR Status=8 OR Status=9)";
	$varMailRecievedDeleteCount		= $objProfileDetail->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	// GET MAIL SENT STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";
	$varMailSentCount				= $objProfileDetail->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=5";
	$varMailSentDeleteCount			= $objProfileDetail->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=1 OR Status=2 OR Status=7 OR Status=8)";
	$varMailSentReadCount			= $objProfileDetail->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=0 OR Status=6)";
	$varMailSentNotReadCount		= $objProfileDetail->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=3 OR Status=9)";
	$varMailSentDeclinedCount		= $objProfileDetail->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);


	// GET INTEREST RECEIVED STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";
	$varInterestReceivedCount		= $objProfileDetail->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	//Interest_Status 0=>Pending, 1=>Accepted, 2=>Declined
	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=0";
	$varNoOfPendingList				= $objProfileDetail->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=1";
	$varNoOfAcceptList				= $objProfileDetail->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=3";
	$varNoOfDeclineList				= $objProfileDetail->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=6 OR Status=7)";
	$varNoOfDeletedList				= $objProfileDetail->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);


	// GET INTEREST SENT STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";
	$varInterestSentCount			= $objProfileDetail->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=0";
	$varInterestSentPendingList		= $objProfileDetail->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=5";
	$varInterestSentDeleteList		= $objProfileDetail->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=1 OR Status=6)";
	$varInterestSentAcceptList		= $objProfileDetail->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=3 OR Status=7)";
	$varInterestSentDeclineList		= $objProfileDetail->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	// GET FAVORITES STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";

	$varFavoritesCount				= $objProfileDetail->numOfRecords($varTable['BOOKMARKINFO'],'MatriId',$varCondition);
	$varBlocksCount					= $objProfileDetail->numOfRecords($varTable['BLOCKINFO'],'MatriId',$varCondition);
	$varIgnoresCount				= $objProfileDetail->numOfRecords($varTable['IGNOREINFO'],'MatriId',$varCondition);


	if($varRecordsNumber > 0) {
		$varFolderName		= $objMailManager->getFolderName($varMatriId);
		$arrDomainDetails	=$objMailManager->getDomainDetails($varMatriId);
		$varSiteName		= $arrDomainDetails['PRODUCTNAME'].'Matrimony';
		include_once($varRootBasePath."/domainslist/".$varFolderName."/conf.cil14");

		$argFields 				= array('MatriId','Password','Email');
		$argCondition			= "WHERE MatriId='".$varMatriId."'";
		$varSelectUserNameRes	= $objProfileDetail->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectUserName		= mysql_fetch_assoc($varSelectUserNameRes);
		$varMatriId				= $varSelectUserName['MatriId'];
		$varPassword			= $varSelectUserName['Password'];
		$varEmail				= $varSelectUserName["Email"];

		//Getting Memcache detail
		$varOwnProfileMCKey		= 'ProfileInfo_'.$varMatriId;
		$argMCFields			= $arrMEMBERINFOfields;
		$argMCCondition			= "WHERE MatriId='".$varMatriId."'";
		$varMCMemberInfo		= $objDBSlave->select($varTable['MEMBERINFO'],$argMCFields,$argMCCondition,0,$varOwnProfileMCKey);

		#Getting member information for the selected profile
		$argCondition			= "WHERE MatriId='".$varMatriId."'";
		$argFields 				= array('BM_MatriId','Name','Nick_Name','Age','Dob','Gender','Height','Height_Unit','Weight','Weight_Unit','Body_Type','Complexion','Eye_Color','Hair_Color','Physical_Status','Blood_Group','Marital_Status','No_Of_Children','Children_Living_Status','Education_Subcategory','Education_Category','Chevvai_Dosham','Education_Detail','Employed_In','Occupation','Occupation_Detail','Income_Currency','Annual_Income','Religion','CasteId','SubcasteId','Mother_TongueId','Horoscope_Match','Religious_Values','Ethnicity','Resident_Status','Country','Citizenship','Residing_State','Residing_Area','Residing_City','Residing_District','Contact_Address','Contact_Phone','Contact_Mobile','About_Myself','Eating_Habits','Smoke','Drink','Profile_Viewed','Profile_Created_By','Profile_Referred_By','Publish','Last_Login','Photo_Set_Status','Protect_Photo_Set_Status','Filter_Set_Status','Video_Set_Status','Partner_Set_Status','Family_Set_Status','Interest_Set_Status','Date_Created','Date_Updated','IPAddress','Paid_Status','Last_Payment','Valid_Days','Expiry_Date','Number_Of_Payments','Support_Comments','Horoscope_Available','Horoscope_Protected','Phone_Verified','OfferAvailable',
		'Match_watch_Email');
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
		$varPhoneVerified			= $varMemberInfo[" Phone_Verified"];
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
		$varChevvaiDosham			= $varMemberInfo['Chevvai_Dosham'];
		$varOfferAvailable          = $varMemberInfo['OfferAvailable']; 
		$varMatchwatch              = $varMemberInfo['Match_watch_Email'];
		$varLastPayment				= $varPaidDate;  // to check for autorenewal
			if($varPublish==0){
				$varPublishValue="Inactive";
			}else if($varPublish==1){
				$varPublishValue="Open";
			}else if($varPublish==2){
				$varPublishValue="Hide";
			}else if($varPublish==3){
				$varPublishValue="Suspend";
			}else if($varPublish==4){
			    $varPublishValue="Reject";
			}
		

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
		if($InterestSetStatus == 1) {
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
		if($varPartnerSetStatus == 1) {
			$argFields 					= array('MatriId','Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Height_Unit','Physical_Status','Education','Religion','CasteId','SubcasteId','Citizenship','Country','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Date_Updated');
			$varPartnerInfoRes			= $objProfileDetail->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
			$varPartnerInfo				= mysql_fetch_assoc($varPartnerInfoRes);

			$varAgeFrom		= $varPartnerInfo["Age_From"];
			$varAgeTo		= $varPartnerInfo["Age_To"];

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
			$varFileName="funViewPhoto('".$varMatriId."','".$varActStatus."')";
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
		if($varPaidStatus==1) {
			$varPaidDate		= $varPaidDate;
			//Calculate Valid days for Paid members
			$varLastPaidDate	= date('d-M-Y H:i:s',strtotime($varPaidDate));
			$varTodayDate		= date('m-d-Y');
			$varPaidDate		= date('m-d-Y',strtotime($varPaidDate));
			$varNumOfDays		= $objCommon->dateDiff("-",$varTodayDate,$varPaidDate);
			$varRemainingValidDays	= $varValidDays- $varNumOfDays;

			if($varRemainingValidDays <= 0) {
				$varRemainingValidDays = 0;
			}
			$varrCondition		= "WHERE MatriId='".$varMatriId."' AND Product_Id IN (1,2,3,4,5,6,7,8,9,48,56) ORDER BY Date_Paid DESC LIMIT 1";
			$argFields 			= array('MatriId','OrderId','Product_Id');
			$varPaymentRes		= $objProfileDetail->select($varDbInfo['DATABASE'].'.'.$varTable['PAYMENTHISTORYINFO'],$argFields,$varrCondition,0);
			$varPaymentInfo		= mysql_fetch_assoc($varPaymentRes);
			$varPackageName		= $arrPrdPackages[$varPaymentInfo['Product_Id']];

		}

		// Profile publish status check
		$varStatus = '';
		$varProfileStatus = array('1'=>'Opened','2'=>'Hided','3'=>'Suspended','4'=>'Rejected','0'=>'Visible');
		$varStatus .= $varProfileStatus[$varPublish];
		// Filter Status
		if ($varFilterSetStatus==1) {
			$varStatus .= ' - (Filter Set)';
		}		

		//Getting MatchWatchcount for passed MatriId
		$argCondition				= "WHERE MatriId='".$varMatriId."' AND Matchwatch!=0";
		$varMatchWatchCnt			= $objProfileDetail->numOfRecords($varDbInfo['DATABASE'].'.'.$varTable['MAILMANAGERINFO'],'MatriId',$argCondition);
        $varMemberStatsRes          =    getMemberStats($objDBSlave, $varMatriId);
        $varTotalMailReceived=$varMemberStatsRes['Mail_Read_Received']+$varMemberStatsRes['Mail_UnRead_Received']+$varMemberStatsRes['Mail_Replied_Received']+$varMemberStatsRes['Mail_Declined_Received'];
		$varTotalMailSent=$varMemberStatsRes['Mail_Read_Sent']+$varMemberStatsRes['Mail_UnRead_Sent']+$varMemberStatsRes['Mail_Replied_Sent']+$varMemberStatsRes['Mail_Declined_Sent'];
		$varTotalInterestReceived=$varMemberStatsRes['Interest_Pending_Received']+$varMemberStatsRes['Interest_Accept_Received']+$varMemberStatsRes['Interest_Declined_Received'];
		$varTotalInterestSent=$varMemberStatsRes['Interest_Pending_Sent']+$varMemberStatsRes['Interest_Accept_Sent']+$varMemberStatsRes['Interest_Declined_Sent'];

        $varReqInfoSentRes        =    getRequestInfoSent($objDBSlave, $varMatriId);
        $varTotalReqInfoSent = $varReqInfoSentRes['Photo'] + $varReqInfoSentRes['Phone'] + $varReqInfoSentRes['Horoscope'];
		$varReqInfoReceivedRes    =	   getRequestInfoReceived($objDBSlave, $varMatriId);
		$varTotalReqInfoReceived  = $varReqInfoReceivedRes['Photo'] + $varReqInfoReceivedRes['Phone'] + $varReqInfoReceivedRes['Horoscope'];

        $varBookMarkInfoRes             = getBookMarkInfo($objDBSlave, $varMatriId);
		$varBlockInfoRes                = getBlockInfo($objDBSlave, $varMatriId);
		$varPhoneViewListInfoRes        = getPhoneViewListInfo($objDBSlave, $varMatriId);
		$varViewedPhoneListByMemberRes  = getViewedPhoneListByMember($objDBSlave, $varMatriId);

		 // done by barani //
         //$varDuplicateEmailCount = getDuplicateEmails($varNewProfileDetails[$i][MatriId],$varEmail);
	     $varDuplicateEmailCount = $objProfileDetail->getDuplicateEmails($varMatriId,$varEmail);
	     $varDuplicateEmailLink = ($varDuplicateEmailCount)? "<a href=# onClick=javascript:window.open('/admin/view-duplicate-emails.php?email=$varEmail&MatriId=$varMatriId','popup','width=500,height=620'); class='smalltxt boldtxt'>Duplicate Emails(".$varDuplicateEmailCount.")</a>" : '';
         // end //

		 $varGetCountry = getCountry($varMemberInfo['IPAddress']);
	     $varCountryLocation = (in_array($varGetCountry->country_short,$varSpecialCountries))?('<label class=smalltxt><b><font color="red">!!  '.$varGetCountry->country_long.'  !!</font></b></label>'):($varGetCountry->country_long);

		//code to calculate phone working status Begins
		$argCondition			= "WHERE Complaint_On='".$varMatriId."' AND Request_Closed=0 GROUP BY Complaint_Tag";
		$argFields 				= array('Complaint_On','Complaint_Tag');
		$varSelectMatriIdRes	= $objProfileDetail->select($varTable['PHONENOTWORK_LOG'],$argFields,$argCondition,0);	
		$varTotalCnt			= mysql_num_rows($varSelectMatriIdRes);
		//code to calculate phone working status Ends
		?>
		<script>
			var varConfArr=new Array(); varConfArr['domainimgs']="<?=$confValues['IMGSURL']?>"; varConfArr['domainweb'] = "<?=$confValues['SERVERURL']?>";varConfArr['domainname'] = "<?=$confValues['DOMAINNAME']?>"; varConfArr['domainimage'] = "<?=$confValues['IMAGEURL']?>";varConfArr['webimgs']="<?=$confValues['PHOTOURL']?>"; varConfArr['domainimg'] = "<?=$confValues['IMGURL']?>"; varConfArr['productname'] = "<?=$confValues['PRODUCTNAME']?>";
		</script>
		<style type="text/css">

		</style>		
		<table border="0" cellpadding="0" cellspacing="0" WIDTH="537" style="padding-left:5px;">
		<tr><td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" WIDTH="528" >
			<tr>
				<td valign="top" width="155" bgcolor="#FFFFFF" align="left" style="padding-top:5px;padding-left:5px;padding-right:1px;padding-bottom:5px;">
					<!-- Thumbnail Photo Display starts here -->
					<table border="0" cellpadding="0" cellspacing="0" WIDTH="520" class="formborder">
						<tr height="160" >
							<td valign="top" align="center" width="150" style="padding-top:1px;padding-left:5px;padding-right:1px;">
								<div class="formborderclr">
									<a href="javascript: <?=$varFileName;?>" GALLERYIMG="no" oncontextmenu="return false"><span id="id<?=$varMatriId;?>"><img border="0"			src="<?=$varPhotoName;?>"  width="150" height="150" vspace="2" hspace="2"></span></a>
								</div>
								<div style="padding-top:3px;padding-left:10px;">
										<?php if ($varMemberInfo['Photo_Set_Status']==1) { ?>
											<div class="viewbgclr"><A href="javascript: funViewPhoto('<?=$varMatriId?>','<?=$varActStatus?>')" class='formlink'>Enlarge photo</a></div>
										<?php }else{?>
											<div class="viewbgclr" style="padding-bottom:3px;"><A href="javascript: funAddPhoto('<?=$varMatriId?>')" class='formlink'>Add photo</a></div>
										<?php }//if ?>
								</div>
								<div id="imagecontainer">
								<?  if($varPhotoSetStatus == 1) {
										$varPhotoDetail = $objProfileDetail->photoDisplay(1,$varMatriId,$varInactiveDbInfo['DATABASE'],$varTable);
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
								<table border="0" width="100%">
									<tr>
										<td class="smalltxt boldtxt" width="40%">
										Sitename</td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?php echo $varSiteName;?>
										</td>
									</tr>
									<tr>
										<td class="smalltxt boldtxt">
										MatriId	</td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?php echo $varMatriId;?>
										</td>
									</tr>
									<tr>
										<td class="smalltxt boldtxt">
										 Is BM Copied</td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?=(($varMemberInfo["BM_MatriId"]!='')?'Yes ('.$varMemberInfo["BM_MatriId"].')':'No (Direct)')?>
										</td>
									</tr>
									<tr>
										<td class="smalltxt boldtxt">
										Gender</td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?=$varMemberInfo['Gender']==1 ? "Male" : "Female"?> 
										</td>
									</tr>
									<tr>
										<td class="smalltxt boldtxt">
										Martial Status</td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?=$arrMaritalList[$varMemberInfo['Marital_Status']];?>
										</td>
									</tr>
									<tr>
										<td class="smalltxt boldtxt">
										Profile created by</td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?= $arrProfileCreatedByList[$varMemberInfo['Profile_Created_By']]!=''?$arrProfileCreatedByList[$varMemberInfo['Profile_Created_By']]:'-';?> 
										</td>
									</tr>
									<tr>
										<td class="smalltxt boldtxt">
										 Profile referred by  </td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?= $arrProfileReferredList[$varMemberInfo['Profile_Referred_By']]!=''?$arrProfileReferredList[$varMemberInfo['Profile_Referred_By']]:'-';?> 
										</td>
									</tr>
									<tr>
										<td class="smalltxt boldtxt">
										 Last Login	</td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?= $varLastLogin!=''?$varLastLogin:'-'; ?>
										</td>
									</tr>									
									<tr>
										<td class="smalltxt boldtxt">
										 Registered from IP </td> <td width="5%">:
										</td>
										<td class="smalltxt">
										<?=$varCountryLocation?>
										</td>
									</tr>
									<tr>
										<td class="smalltxt" colspan="2">
										 <? if ($sessUserType=='3') { ?><a onclick="window.open('sendemail.php?eid=<?=base64_encode($varEmail)?>', '','height=600, width=480');" ><b>Send Email</b></a><? } ?>
										</td>										
									</tr>
									<tr>										
										<td class="smalltxt" colspan="2">
										<?=$varDuplicateEmailLink?>
										</td>
									</tr>
								</table>
							</td>
							<!-- <td valign="top" width="10"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="1"></td> -->
						</tr>
					</table>
					<!-- Thumbnail Photo Display starts here -->
				</td>
			</tr>
		</table><br>
		<!-- Basic Details Starts Here-->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Basic Details</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Horoscope Details :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<? if ($varPhotoInfo['HoroscopeURL']!='' && ($varHoroSetStatus == 1 || $varHoroSetStatus == 3)) { ?>Available ---- To View<a href="adminhoroshow.php?mid=<?=$varMatriId?>&type=<?=$varHoroSetStatus?>&horo=<?=urlencode($varHoroName)?>" target='_blank'> <b>Click Here</b></a><? } else { ?> Not Available ---- To Add  <a onclick="javascript:funHoroscopeProfile('<?=$varMatriId?>')" > <b>Click Here</b><? } ?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Phone :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">To View
				<a onclick="window.open('adminviewphone.php?Mid=<?=$varMatriId?>&status=<?=$varPhoneVerified?>', '','height=300, width=380');" ><b> Click Here</b></a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<?php if ($sessUserType !='3') {?>		
			
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Phone Number(Status)  :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?= $varPhoneVerified==0?'Not Verified':'Verified'; ?> ----To Change 
				<a onclick="javascript:funPhoneStatusProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Phone Count :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				To View <a 
				onclick="javascript:funPhoneCountProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>	
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Phone Not Working :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%"><?= $varTotalCnt==0?'Complaint Not Available':'Complaint Available'; ?> ----
				To View <a 
				onclick="javascript:funPhoneWorkingProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>				
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Hide/Delete Profile :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%"><?php echo $varPublishValue; ?>----
				To Change <a 
				onclick="javascript:funHideDeleteProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<!--<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Filter Settings :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				To View <a 
				onclick="javascript:funViewFilterProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>-->	
			<?php }?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Payment Details  :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?= $varPaidStatus==0?'Free Member':'Paid Member'; ?> ----To View Before Record <a 
				onclick="javascript:funPaymentProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<?php if ($sessUserType !='3') {?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Offer Details  :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?= $varOfferAvailable== 0 ?'Not Available':'Available'; ?> ----To View Offers <a 
				onclick="javascript:funOffersProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Modify / Edit Profile  :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				To Edit
				<a 	onclick="javascript:funModifyProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Photo Protected Info :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				To View
				<a 	onclick="javascript:funPhotoprotectedProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Phone no /Mobile no details :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				To View
				<a 	onclick="javascript:funPhoneNoVerifiedProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</td>
			</tr>
			<? if(($varLastPayment !='0000-00-00 00:00:00')) {
				$varPaymentFields			= array('Date_Paid','Currency');
				$varPaymentCondition		= 'WHERE MatriId="'.$varMatriId.'" AND Product_Id<100 ORDER BY Date_Paid DESC Limit 1';
				$varPaidMemberInfo			= $objDBSlave->select($varTable['PAYMENTHISTORYINFO'],$varPaymentFields,$varPaymentCondition,1);
				echo $varPaidMemberInfo[0]['Currency'];
				echo $varDatePaid	    = date("Y-m-d",strtotime($varPaidMemberInfo[0]['Date_Paid']));
				if( (($varLastPayment >= $varDatePaid.' 00:00:00') && ($varLastPayment <= $varDatePaid.' 23:59:59')) && ($varPaidMemberInfo['Currency'] !='') && ($varPaidMemberInfo['Currency'] !='Rs') && ($varPaidMemberInfo['Currency'] !='Rs.') ) {
				$varPaymentDetails  = getOnlinePaymentDetails($objDBSlave,$varMatriId);
			?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%"> Auto renewal :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?= $varPaymentDetails['Auto_Renew']==1?'On' : 'Off'; ?> ----To Change <a 
				onclick="javascript:funAutoRenewal('<?=$varMatriId?>','<?=date("d-M-Y",strtotime($varExpiryDate))?>')" ><b>Click Here</b></a>
				</a>
				</td>
			</tr>
			<? }
			  }
			}
			?>
		<!--<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Validate Twitter Message :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				To Validate
				<a 	onclick="javascript:funTwitterProfile('<?=$varMatriId?>')" ><b>Click Here</b></a>
				</td>
			</tr>-->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
		 </table><br>
		<!-- Basic Other Details  Ends here-->
		
		<? if ($sessUserType=='2') { ?>
		<!-- General Details starts here-->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">General Details</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Partner preference <br>status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varPartnerSetStatus==0?'OFF':'ON'; ?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Match watch <br> Email status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMatchWatchCnt!=0?'ON':'OFF'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Time created :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $DateCreated!=''?$DateCreated:'-'; ?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Time modified :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $DateUpdated!=''?$DateUpdated:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Email :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varEmail!=''?$varEmail:'-'; ?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Referred by :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMemberInfo['Profile_Referred_By']!='0'?$arrProfileReferredList[$varMemberInfo['Profile_Referred_By']]:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Telephone :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varTelephone ?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Last login :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varLastLogin!=''?$varLastLogin:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Added by :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMemberInfo['Profile_Created_By']!=''?$arrProfileCreatedByList[$varMemberInfo['Profile_Created_By']]:'-'; ?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Authorized :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">True</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Validated :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?
					$varPublish = $varMemberInfo["Publish"];
					if (($varPublish=="0") || ($varPublish=="4")) { echo 'False';}
					else  { echo 'True';}
					?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varStatus; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Host :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varMemberInfo['IPAddress']!=''?$varMemberInfo['IPAddress']:'-'; ?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Phone Verified :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?=(($varPhoneVerified==1)?'Yes':'No')?></td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Comments :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><?= $varMemberInfo['Support_Comments']!=''?$varMemberInfo['Support_Comments']:'-'; ?>
				</td>
			</tr>

			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
		 </table><br>
		<!-- General Details starts here-->
		<? } ?>

		<!--Membership details starts here -->
		<!--<table border="0" cellpadding="0" cellspacing="0" class="formborder" WIDTH="532">
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
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varRemainingValidDays!=0?$varExpiryDate:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Package Valid days :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varValidDays!=0?$varValidDays:'-'; ?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="29%">Remaining Valid days :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><?= $varRemainingValidDays!=0?$varRemainingValidDays:'-'; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Number of Payments :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">&nbsp;<?=$varNumberOfPayment; ?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
		</table><br>-->
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
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Caste :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?	if(array_key_exists($varMemberInfo['CasteId'],$arrCasteList))
						{
							print $arrCasteList[$varMemberInfo['CasteId']];
						}else{
							echo "-";
						}
					?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Subcaste :</td>
				<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?
						if(array_key_exists($varMemberInfo['SubcasteId'],$arrSubcasteList)) {
							print $arrSubcasteList[$varMemberInfo['SubcasteId']];
						} else {
							echo"-";
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
				<td valign="top"  class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Manglik / Chevvai Dosham</td>
				<td valign="top"  class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?
						//echo 'Chev='.$varMemberInfo['Chevvai_Dosham'].'=='.$varChevvaiDosham;
				if ($varMemberInfo['Chevvai_Dosham'] !="0"){
						echo $arrManglikList[$varChevvaiDosham]; }
				else { echo '-'; }
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
				<?=($varMemberInfo['Education_Subcategory']!=0)?$arrEducationList[$varMemberInfo['Education_Subcategory']]:$arrGroupEducationList[$varMemberInfo['Education_Category']];?>
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
				<td valign="top" width="25%" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Family values :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
				<?=$arrFamilyValuesList[$varFamilyInfo['Family_Value']]? $arrFamilyValuesList[$varFamilyInfo['Family_Value']] : "-";?></td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Native language :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=($varMemberInfo['Mother_TongueId']!="0")? $arrMotherTongueList[$varMemberInfo['Mother_TongueId']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing state :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varResidingState; ?>
				</td>
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing city/district :</td>
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
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Value :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Value'] ? $arrFamilyValuesList[$varFamilyInfo['Family_Value']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Type :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Type'] ? $arrFamilyType[$varFamilyInfo['Family_Type']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Status'] ? $arrFamilyStatus[$varFamilyInfo['Family_Status']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Father's Occupation :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Father_Occupation'] ? $varFamilyInfo['Father_Occupation'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Mother's Occupation :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Mother_Occupation'] ? $varFamilyInfo['Mother_Occupation'] : "-";?>
				</td>
			</tr>
			<tr <tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Family Origin :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFamilyInfo['Family_Origin'] ? $varFamilyInfo['Family_Origin'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Brothers :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<!--<?php if($varFamilyInfo['Brothers']!=99){

				//$varFamilyInfo['Brothers'] ?  echo $varFamilyInfo['Brothers'] :  echo "-";
				}else{
					echo "Not Selected";
				}?>-->
				<?=($varFamilyInfo['Brothers']!=99) ? $varFamilyInfo['Brothers'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Married Brothers :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=($varFamilyInfo['Brothers_Married']!=99) ? $varFamilyInfo['Brothers_Married'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">sisters :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=($varFamilyInfo['Sisters']!=99) ? $varFamilyInfo['Sisters'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Married Sisters :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=($varFamilyInfo['Sisters_Married']!=99) ? $varFamilyInfo['Sisters_Married'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">About Family :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=($varFamilyInfo['About_Family']!=99) ? $varFamilyInfo['About_Family'] : "-";?>
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
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Hobbies :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varHobbies != ''? $varHobbies : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Interests :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varInterest != ''? $varInterest : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Musics :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varMusics != ''? $varMusics : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Books :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varBooks != ''? $varBooks : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Movies :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varMovies != ''? $varMovies : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Sports :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varSports != ''? $varSports : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Cuisine :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varFood != ''? $varFood : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Dess Style Brothers :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varDress != ''? $varDress : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="532" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Languages :</td>
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
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Input By : </td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?= $varPartnerSetStatus==0?'SYSTEM':'USER';?>
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Looking for :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varPartnerInfo['Looking_Status'] ? $objCommon->getArrayFromString($varPartnerInfo['Looking_Status'],$arrMaritalList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Age :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					Between <?=$varAgeFrom ? $varAgeFrom : "-";?> and <?=$varAgeTo ? $varAgeTo : "-";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?= $varPartnerHeightFt;?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Physical status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Physical_Status'] ? $arrPhysicalStatusList[$varPartnerInfo['Physical_Status']] : "-";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Native language :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Mother_Tongue'] ? $objCommon->getArrayFromString($varPartnerInfo['Mother_Tongue'],$arrMotherTongueList) : "Any";
				?>
				</td>
			</tr>
			<!-- End of Primary Preference -->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of Socio-Religious Preference -->
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Sect :</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
			<?=$varPartnerInfo['Religion'] ? $objCommon->getArrayFromString($varPartnerInfo['Religion'],$arrReligionList) : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Sub sect :</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
			<?=$varPartnerInfo['CasteId'] ? $objCommon->getArrayFromString($varPartnerInfo['CasteId'],$arrCasteDivisionList) : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Caste :</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
			<?=$varPartnerInfo['SubcasteId'] ? $objCommon->getArrayFromString($varPartnerInfo['SubcasteId'],$arrSubcasteList) : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Eating_Habits']!="")? $arrEatingHabitsList[$varPartnerInfo['Eating_Habits']] : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Drinking_Habits']!="")? $arrDrinkList[$varPartnerInfo['Drinking_Habits']] : "-";?>
			</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Smoking_Habits']!="")? $arrSmokeList[$varPartnerInfo['Smoking_Habits']] : "-";?>
			</td>
			</tr>
			<!-- End of Socio-Religious Preference -->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of Educational Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Education'] ? $objCommon->getArrayFromString($varPartnerInfo['Education'],$arrEducationList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- End of Educational Preference -->
			<!-- Start of Location Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Citizenship:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Citizenship'] ? $objCommon->getArrayFromString($varPartnerInfo['Citizenship'],$arrCountryList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Country living in :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Country'] ? $objCommon->getArrayFromString($varPartnerInfo['Country'],$arrCountryList) : "Any";?>
				</td>
			</tr>
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr class="viewbgclr"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Resident status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Resident_Status'] ? $objCommon->getArrayFromString($varPartnerInfo['Resident_Status'],$arrResidentStatusList) : "Any";?>
				</td>
			</tr>
			<!-- End of Location Preference -->
			<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of About my partner -->
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt bold" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">About my partner :</td>
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
		<td align="center"><a href="index.php?act=profile" class="grtxt"><b><u><font class="smalltxt boldtxt" color="red">View other Profiles >></font></u></b></a>&nbsp;</td>
		</tr>
		</table><br>
	<?
	} else { //else
		echo '<br><table width="532" border="0" cellspacing="0" cellpadding="0" align="center" class="viewpgborderclr" valign="top"><tr><td class="errorMsg" height="40" valign="middle" align="center">No members match with your selected criteria. <a href="index.php?act=profile" class="formlink"><b>Click here to try again</b></a></td></tr><tr><td height="10"></td></tr><tr><td></td></tr></table>';
	}
	$objProfileDetail->dbClose();
}//if
else {
?>
	<table border="0" cellpadding="0" cellspacing="0" align="left" WIDTH="542">
		<tr><td height="15" colspan="3"></td></tr>
		<tr><td valign="middle" class="heading" colspan="3"  style="padding-left:15px;_padding-left:15px;"><?=$varTitle;?></td></tr>
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
function funViewProfileId() {
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
function funShowPhoto(argMatriId,argPhotoName) {
	argPlaceHolderId="id" + argMatriId;
	document.getElementById(argPlaceHolderId).innerHTML = "<img src="+varConfArr['webimgs']+"/"+argPhotoName+"' style='padding:2px;width:150px;height:150px;' align='center' border=0>";
}//showPhoto

function funViewPhoto(argMatrId,varActStatus) {
	//img_url+"/photo/viewphoto.php?ID="+matid+"&PNO="+ph_no;
	var funUrl = varConfArr['domainweb']+"/admin/adminshowphoto.php?MATRIID=" + argMatrId+"&actstatus="+varActStatus;
	window.open(funUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=660,height=600,status=no,scrollbars=yes,titlebar=no;");
}//funViewPhoto

function funAddPhoto(argMatrId) {
	//img_url+"/photo/viewphoto.php?ID="+matid+"&PNO="+ph_no;
	var funAddUrl = varConfArr['domainimg']+"/admin/photovalidation/adminmanagephoto.php?MATRIID="+ argMatrId;
	window.open(funAddUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funPaymentProfile(argMatrId) {
	//img_url+"/photo/viewphoto.php?ID="+matid+"&PNO="+ph_no;
	//admin/index.php?act=paymenthistory&username=BRH102122&tvprofile=yes
	var funPaymentUrl = varConfArr['domainweb']+"/admin/index.php?act=paymenthistory&username="+ argMatrId+"&tvprofile=yes";
	window.open(funPaymentUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,status=no,scrollbars=yes,titlebar=no;");
}

function funHideDeleteProfile(argMatrId) {
	var funHideUrl = varConfArr['domainweb']+"/admin/index.php?act=hide-profile&username="+ argMatrId+"&primary=MatriId&tvprofile=yes";
	window.open(funHideUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funViewFilterProfile(argMatrId) {
	var funHideUrl = varConfArr['domainweb']+"/admin/index.php?act=view-filter-settings&username="+ argMatrId+"&primary=MatriId&tvprofile=yes";
	window.open(funHideUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funPhoneCountProfile(argMatrId) {
	var funPhoneUrl = varConfArr['domainweb']+"/admin/index.php?act=phone-count&username="+ argMatrId+"&primary=MatriId&tvprofile=yes";
	window.open(funPhoneUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funPhoneWorkingProfile(argMatrId) {
	var funPhoneWorkingUrl = varConfArr['domainweb']+"/admin/index.php?act=phonesupportres&matriid="+ argMatrId+"&tvprofile=yes";
	window.open(funPhoneWorkingUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funAutoRenewal(argMatrId,expDate) {
	var funAutoRenewalUrl = varConfArr['domainweb']+"/admin/index.php?act=autorenewal&id="+ argMatrId+"&expdate="+expDate+"&tvprofile=yes";
	window.open(funAutoRenewalUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funOffersProfile(argMatrId) {	
	var funPaymentUrl = varConfArr['domainweb']+"/admin/index.php?act=offeravailable&username="+ argMatrId+"&tvprofile=yes";
	window.open(funPaymentUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funModifyProfile(argMatrId) {	
	var funModifyUrl = varConfArr['domainweb']+"/admin/index.php?act=edit-profile&MatriId="+ argMatrId+"&tvprofile=yes";
	window.open(funModifyUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}
function funPhoneStatusProfile(argMatrId) {	
	var funStatusUrl = varConfArr['domainweb']+"/admin/index.php?act=phoneverify&matriId="+ argMatrId+"&tvprofile=yes&frmPhoneVerifySubmit=yes";
	window.open(funStatusUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}
function funHoroscopeProfile(argMatrId) {
	var funHoroscopeUrl = varConfArr['domainimage']+"/admin/horoscopevalidation/adminmanagehoroscope.php?MATRIID="+ argMatrId;
	window.open(funHoroscopeUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}
function funPhotoprotectedProfile(argMatrId) {
	var funPhotoprotectedUrl = varConfArr['domainweb']+"/admin/index.php?act=unprotectpassword&matrid="+ argMatrId+"&tvprofile=yes";
	window.open(funPhotoprotectedUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}

function funPhoneNoVerifiedProfile(argMatrId) {
	var funPhoneNoVerifiedProfile = varConfArr['domainweb']+"/admin/index.php?act=matriid-through-phone&matriid="+ argMatrId+"&tvprofile=yes";
	window.open(funPhoneNoVerifiedProfile, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}
function funTwitterProfile(argMatrId) {
	var funTwitterUrl = varConfArr['domainweb']+"/admin/index.php?act=get_twitter_msg&matriid="+ argMatrId+"&tvprofile=yes&msgformatriid=yes";
	window.open(funTwitterUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=750,height=500,status=no,scrollbars=yes,titlebar=no;");
}
</script>