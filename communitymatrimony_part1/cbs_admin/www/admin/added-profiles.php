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
//include_once($varRootBasePath.'/conf/config.cil14');
//include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath.'/conf/emailsconfig.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsAdminValMailer.php');
include_once($varRootBasePath.'/www/payment/getcountry.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//OBJECT DECLARTION
$objAdminMailer = new AdminValid;
$objMaster		= new MemcacheDB;
$objProfileDetail	= new ProfileDetail;
$objDomain		= new domainInfo;

//DB CONNECTION
$objAdminMailer->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

//FOR SEPRATE PROFILE VALIDATIONS
$varSepartePage = $_REQUEST["spage"];
if ($varSepartePage=="yes")
{
	$varModifyUrl	= 'edit-profile.php?spage=yes&MatriId=';
}
else { $varModifyUrl	= 'index.php?act=edit-profile&MatriId='; }//else

$NoOfRecords	= $_REQUEST['NumberProfile'];
$NameType		= $_REQUEST['type'];
$UserId			= $_REQUEST['ID'];
$varStartLimit	= $_REQUEST['startFrom'];
$varProfilePaidStatus = $_REQUEST['profilePaidStatus'];

$varRejectCount=0;
$varAddCount=0;
$varIgnoreCount=0;

function emailValidation($argEmail)
{
	if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $argEmail)) { return FALSE; }//if
	list($Username, $Domain) = split("@",$argEmail);
	if(getmxrr($Domain, $MXHost)) { return TRUE; }
	else {
			//if(fsockopen($Domain, 25, $errno, $errstr, 30)) { return TRUE; }//else
			//else { return FALSE; }//else
	}//else
}//emailValidation
/*
if($_POST['frmAddedProfileSubmit']=='yes')
{
	//VARIABLE DECLARATIONS
	$varCurrentDate				= date('Y-m-d H:i:s');
	$varUsername				= $_REQUEST["suplogin"];

	//CONTROL STATEMENTS
	//getting admin login detail in adminlogininfo
	$argCondition				= "WHERE User_Name='".$varUsername."'";
	$varCheckUserName			= $objAdminMailer->numOfRecords($varTable['ADMINLOGININFO'],'User_Name',$argCondition);

	#Check Username (*ND 20061006)
	if ($varCheckUserName=="1")
	{
		$argFields 				= array('Password','User_Type');
		$varSelectBasicInfoRes	= $objAdminMailer->select($varTable['ADMINLOGININFO'],$argFields,$argCondition,0);
		$varSelectBasicInfo		= mysql_fetch_assoc($varSelectBasicInfoRes);
		$varDBPassword			= $varSelectBasicInfo["Password"];
		$varUserType			= $varSelectBasicInfo["User_Type"];
	}//if

	if ($varDBPassword===md5($_REQUEST["suppswd"]))
	{
		$varCheckPassword		='yes';
		$argFields 				= array('Last_Login');
		$argFieldsValues		= array("'".$varCurrentDate."'");
		$argCondition			= "User_Name='".$varUsername."'";
		$varUpdateId			= $objMaster->update($varTable['ADMINLOGININFO'],$argFields,$argFieldsValues,$argCondition);
	}

	if($varCheckPassword!='yes')
	{
		echo "<div class='errorMsg' width='500' align='center'>Invalid UserName and Password ,Enter valid UserName and Password</div>";
	}//if
}//if*/

if($UserId!='')
	$varNoOfRecords= 1;
else
{
	if($varProfilePaidStatus == 'yes') {
      $varDate= date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')-2,date('Y')));
      $argCondition = "WHERE Paid_Status = 1 AND Date_Created >= '".$varDate."' AND Publish = 1 AND Support_Comments = ''";
    }
	else {
	  $argCondition				= "WHERE Publish=0";
	}
	$varTotalNumRec				= $objAdminMailer->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);
	$varNoOfRecords				= $NoOfRecords?$NoOfRecords:($varTotalNumRec>10?10:$varTotalNumRec);
}
$varCurrentDate			= date('Y-m-d H:i:s');
$varCommentwithAdmin	= '--'.date('y-m-d H:i:s').'--'.$varCookieInfo['USERNAME'].'--';
//Check the MatriId value and Action Value
//if(($_POST['frmAddedProfileSubmit']=='yes') && ($varCheckPassword=='yes'))
if($_POST['frmAddedProfileSubmit']=='yes')
{   
	for($i=0;$i<$varNoOfRecords;$i++)
	{
		$action					= $_REQUEST['action'.$i];
		$matriId				= $_REQUEST['matriId'.$i];
		$varCommunityId			= $_REQUEST['communityid'.$i];
		$adminComment			= addslashes(strip_tags(trim($_REQUEST['adminComment'.$i])));
		$varPublishFlag			= '';

		//SETING MEMCACHE KEY
		$varProfileMCKey= 'ProfileInfo_'.$matriId;

		$argCondition			= "WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
		$argFields 				= array('User_Name','Email');
		$varSelectUserNameRes	= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectUserName		= mysql_fetch_assoc($varSelectUserNameRes);

		if($action!= "")
		{
			$argFields 				= array('Support_Comments','Publish','Nick_Name','Name');
			$varadminCommentsRes	= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$varadminComments		= mysql_fetch_assoc($varadminCommentsRes);
         if($varProfilePaidStatus == 'no') {
			if($varadminComments['Publish'] == 1)
			{
				$varPublishFlag = 'Validated';
				echo "<br><div class='errorMsg' width='500' align='center'>Already ".$varSelectUserName['User_Name']." profile Validated.</div>";
			}
			else
			{
				$varComment			= $varadminComments['Support_Comments'].$varCommentwithAdmin.$adminComment;
				$argFieldsValues	= array($objMaster->doEscapeString($varComment,$objMaster)); 
				$argCondition		= "MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
				$varUpdateId		= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);
			}
		 }

			$varDisplayName	= ($varadminComments['Nick_Name']!='')?$varadminComments['Nick_Name']:$varadminComments['Name'];
		}

		//Reject new profile with Error And SendingMail
		if( $action == "reject" && $varPublishFlag == '')
		{
			$varRejectCount = $varRejectCount + 1;
			$argFields 			= array('Publish');
			$argFieldsValues	= array(4);
			$argCondition		= "MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			$varUpdateId		= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

			$retValue = $objAdminMailer->sendTroubleWithUrProfileMail($matriId,$varDisplayName,$varSelectUserName['Email'],$adminComment);
		}

		//Accept new profile
		if( $action == "add" && $varPublishFlag == '')
		{
			$varAddCount =$varAddCount+1;
			$varAddComment=$varCommentwithAdmin.$adminComment;
			$argCondition			= "WHERE MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			$argFields				= array('CommunityId','MatriId','Matchwatch','SpecialFeatures','Promotions','ThirdParty','Date_Updated');
			$argFieldsValues		= array($objMaster->doEscapeString($varCommunityId,$objMaster),$objMaster->doEscapeString($matriId,$objMaster),1,1,1,1,"'".$varCurrentDate."'");
			$varInsertId			= $objMaster->insertOnDuplicate($varTable['MAILMANAGERINFO'],$argFields,$argFieldsValues,'MatriId');

			$argFields 				= array('Publish','Support_Comments','Profile_Published_On');
			$argFieldsValues		= array(1,$objMaster->doEscapeString($varAddComment,$objMaster),"'".$varCurrentDate."'");
			
			$argCondition			= "MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

			//Get Name & Pinno for corresponding matriid
			$argCondition			= "WHERE MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			//$argFields 				= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
			$argFields 	= $arrMEMBERINFOfields;
			$varSelectName		= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);

			if($varSelectName['Phone_Verified'] != 1) {
				$argFields 				= array('PINNO');
				$varSelectPinNoRes		= $objAdminMailer->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argCondition,0);
				$varSelectPinNo			= mysql_fetch_assoc($varSelectPinNoRes);
				$varPinNo				= $varSelectPinNo['PINNO'];
			} else {
				$varPinNo	= '';
			}

			$retValue = $objAdminMailer->sendProfileValidationMail($matriId,$varSelectName["Name"],$varSelectUserName['Email'],$varSelectName["Phone_Verified"],$varPinNo);
			#UPDATE online status
			$argFields				= array('MatriId','Status','LastActivityTime');
			$argFieldsValues		=  array($objMaster->doEscapeString($matriId,$objMaster),0,"'".$varCurrentDate."'");
			//$varInsertId			= $objMaster->insertIgnore($varTable['ICSTATUS'],$argFields,$argFieldsValues);


			//UPDATE interestpendinginfo status IF ANY NEW MENBERS SEND MESSAGE
			$argFields 				= array('Status');
			$argFieldsValues		= array(0);
			$argCondition			= "Opposite_MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
			$varUpdateId			= $objMaster->update($varTable['INTERESTPENDINGINFO'],$argFields,$argFieldsValues,$argCondition);

			$argCondition			= "WHERE MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
		}
		//Delete new profile
		if( $action == "ignore" && $varPublishFlag == '')
		{

			$varIgnoreCount = $varIgnoreCount +1;
			$argCondition			= "MatriId=".$objMaster->doEscapeString($matriId,$objMaster);
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
			$argCondition			= "SenderId=".$objMaster->doEscapeString($matriId,$objMaster);
			$objMaster->delete($varTable['REQUESTINFOSENT'],$argCondition);

			//DELETE requestinforeceived INFO
			$argCondition		= "ReceiverId=".$objMaster->doEscapeString($matriId,$objMaster);
			$objMaster->delete($varTable['REQUESTINFORECEIVED'],$argCondition);
		}

	}
	echo "<div class='smalltxtadmin' width='500' align='center'>Rejected Profiles Count --> ".$varRejectCount."<br>Added Profiles Count --> ".$varAddCount."<br>Ignored Profiles Count -->".$varIgnoreCount."<br>Profiles has been added Successfully</div>";
}

$argFields	= array('User_Name','MatriId','Country','Name','Nick_Name','Age','Gender','Religion','Annual_Income','Income_Currency','Residing_Area','Residing_City','Contact_Address','Marital_Status','Date_Created','About_Myself','Education_Detail','Occupation_Detail','CommunityId','Denomination','DenominationText','CasteId','CasteText','SubcasteId','SubcasteText','GothramId','GothramText','Mother_TongueId','Mother_TongueText','Contact_Phone','Contact_Mobile','About_MyPartner','Paid_Status');


if($UserId!='') {
	if($NameType==1) {
		if($varProfilePaidStatus == 'yes') {
		   $varDate= date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')-2,date('Y')));
           $argCondition = "WHERE Paid_Status = 1 AND Date_Created >= '".$varDate."' AND Publish = 1 AND Support_Comments = '' AND MatriId=".$objMaster->doEscapeString($UserId,$objMaster);
	    }
		else {
		  $argCondition			= "WHERE Publish=0 AND MatriId=".$objMaster->doEscapeString($UserId,$objMaster);
		}
	}
	if($NameType==2) {
        if($varProfilePaidStatus == 'yes') {
		   $varDate= date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')-2,date('Y')));
           $argCondition = "WHERE Paid_Status = 1 AND Date_Created >= '".$varDate."' AND Publish = 1 AND Support_Comments = '' AND User_Name=".$objMaster->doEscapeString($UserId,$objMaster);
	    }
		else {
		$argCondition			= "WHERE Publish=0 AND User_Name=".$objMaster->doEscapeString($UserId,$objMaster);
	    }
	}
} else {
	$varStart				= $varStartLimit?$varStartLimit:0;
	$varLimit				= $NoOfRecords?$NoOfRecords:10;
	if($varProfilePaidStatus == 'yes') {
      $varDate= date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')-2,date('Y')));
      $argCondition = "WHERE Paid_Status = 1 AND Date_Created >= '".$varDate."' AND Publish = 1 AND Support_Comments = '' ORDER BY Date_Created LIMIT ".$varStart.",".$varLimit;
	}
	else {
	  $argCondition			= "WHERE Publish=0 ORDER BY Date_Created LIMIT ".$varStart.",".$varLimit;
	}
}
$varNewProfileDetails	= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,1);
$varTotalRow				= count($varNewProfileDetails);
$varTotalTable				= "";
$varTotalTable				.= '<form name="frmAddedProfile" method="post" onsubmit="return radio_button_checker('.$varTotalRow.')">';
$varTotalTable				.= '<input type="hidden" name="frmAddedProfileSubmit" value="yes">';
if($UserId=='')
{
	$varTotalNumRec = $varTotalNumRec - ($varRejectCount + $varAddCount + $varIgnoreCount);
	$varTotalTable .= '<tr><td class="smalltxt" align="right" style="padding-right:10px;"><font color="red"><b>New Profiles Pending Count :'.$varTotalNumRec.'</b></font></td></tr>';
}

for($i=0;$i<$varTotalRow;$i++)
{
	$argCondition				= "WHERE MatriId =".	$objMaster->doEscapeString($varNewProfileDetails[$i][MatriId],$objMaster);
	$argFields					= array('Support_Comments');
	$varadminCommentsRes		= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varadminComments			= mysql_fetch_assoc($varadminCommentsRes);

	$argFields					= array('Father_Occupation','Mother_Occupation','Family_Origin','About_Family');
	$argCondition				= "WHERE MatriId=".$objMaster->doEscapeString($varNewProfileDetails[$i][MatriId],$objMaster)." ORDER BY Date_Updated";
	$varFamilyInfoRes			= $objAdminMailer->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
	$varFamilyInfo				= mysql_fetch_assoc($varFamilyInfoRes);

	$argFields					= array('Hobbies_Others','Interests_Others','Music_Others','Books_Others','Movies_Others','Sports_Others','Food_Others','Dress_Style_Others','Languages_Others');
	$argCondition				= "WHERE MatriId=".$objMaster->doEscapeString($varNewProfileDetails[$i][MatriId],$objMaster)." ORDER BY Date_Updated";
	$varHobbiesInfoRes			= $objAdminMailer->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
	$varHobbiesInfo				= mysql_fetch_assoc($varHobbiesInfoRes);

	$argFields					= array('Partner_Description');
	$argCondition				= "WHERE MatriId=".$objMaster->doEscapeString($varNewProfileDetails[$i][MatriId],$objMaster)." ORDER BY Date_Updated";
	$varPartnerDescriptionRes	= $objAdminMailer->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
	$varPartnerDescription		= mysql_fetch_assoc($varPartnerDescriptionRes);
	//echo '<pre>'; print_r($varPartnerDescription); echo '</pre>';

   // Done by barani //
       $Ipaddress= $objProfileDetail->getProfileIpAddress($varNewProfileDetails[$i][MatriId]);
	   $varGetCountry = getCountry($Ipaddress);
	   $varCountryLocation = (in_array($varGetCountry->country_short,$varSpecialCountries))?('<label class=smalltxt><font color="red">'.$varGetCountry->country_long.'</font></label>'):($varGetCountry->country_long);
	// end //
	
    if($varNewProfileDetails[$i]['Paid_Status'] == 1)
      $varNewProfileDetails[$i]['Paid_Status'] = 'Paid';
	else
	  $varNewProfileDetails[$i]['Paid_Status'] = 'Free';

	$varTotalTable .= '<tr><td><table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="542" align="center"><tr><td valign="top" class="smalltxt boldtxt" colspan="4" style="padding-left:10px;">MatriId : <a href="'.$confValues['SERVERURL'].'/admin/index.php?act=view-profile1&actstatus=yes&matrimonyId='.$varNewProfileDetails[$i]['MatriId'].'" class="smalltxt boldtxt heading" target="_blank">'.$varNewProfileDetails[$i]['MatriId'].'</a>&nbsp;&nbsp;&nbsp;Registered from IP :'.$varCountryLocation.'</td></tr>';
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Display Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3">'.$varNewProfileDetails[$i]['Nick_Name'].'</td></tr>';
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Paid Status :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3">'.$varNewProfileDetails[$i]['Paid_Status'].'</td></tr>';
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Name:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Name']!=""? $varNewProfileDetails[$i]['Name'] : "-";
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Age:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Age'] ? $varNewProfileDetails[$i]['Age'] :  "-";
	$varTotalTable .= '</td></tr>';

	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Email:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';

	//get email for particular matri id
	$argFields				= array('Email');
	$argCondition			= "WHERE MatriId=".$objMaster->doEscapeString($varNewProfileDetails[$i][MatriId],$objMaster);
	$varMemberEmailRes		= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	$varMemberEmail			= mysql_fetch_assoc($varMemberEmailRes);

	$varEmail				= $varMemberEmail['Email'];
	$varValidateEmail		= emailValidation($varEmail);

	$varTotalTable .= '<b><font color="blue">'.$varEmail."</font></b>&nbsp;&nbsp;";
	$varTotalTable .= $varValidateEmail ? "<font color='green'><b>Valid</b></font>" : "<font color='red'><b>Invalid</b></font>";
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Gender:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]["Gender"]==2 ? "Female" : "Male";

	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	if($varNewProfileDetails[$i]['About_Myself']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">About Myself:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['About_Myself']!=""? $varNewProfileDetails[$i]['About_Myself'] : "-";
	$varTotalTable .= '</td></tr>';
	}

	
    if(($varNewProfileDetails[$i]['DenominationText']!=""))
	{
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Denomination:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['DenominationText']!=''? $varNewProfileDetails[$i]['DenominationText'] : "-";
	$varTotalTable .= '</td>';
	}


	if(($varNewProfileDetails[$i]['CasteText']!="") || ($varNewProfileDetails[$i]['SubcasteText']!=""))
	{
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Caste:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['CasteText']!=''? $varNewProfileDetails[$i]['CasteText'] : "-";
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Subcaste:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['SubcasteText'] !='' ? $varNewProfileDetails[$i]['SubcasteText'] :  "-";
	$varTotalTable .= '</td></tr>';
	}

	if(($varNewProfileDetails[$i]['GothramText']!="") || ($varNewProfileDetails[$i]['Mother_TongueText']!=""))
	{
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Gothram:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['GothramText']!=''? $varNewProfileDetails[$i]['GothramText'] : "-";
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Mother Tongue:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Mother_TongueText'] !='' ? $varNewProfileDetails[$i]['Mother_TongueText'] :  "-";
	$varTotalTable .= '</td></tr>';
	}
	if($varNewProfileDetails[$i]['Annual_Income']!=0)
	{
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Annual Income:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['Annual_Income'].'&nbsp;&nbsp;'.$arrSelectCurrencyList[$varNewProfileDetails[$i]['Income_Currency']];
	$varTotalTable .= '</td></tr>';
	}
	if(($varNewProfileDetails[$i]['Education_Detail']!="") || ($varNewProfileDetails[$i]['Occupation_Detail'])) {
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Education In Detail:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Education_Detail']!=""? $varNewProfileDetails[$i]['Education_Detail'] : "-";
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Occupation In Detail:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Occupation_Detail'] ? $varNewProfileDetails[$i]['Occupation_Detail'] :  "-";
	$varTotalTable .= '</td></tr>';
	}
	if(($varNewProfileDetails[$i]['Contact_Phone']!="") || ($varNewProfileDetails[$i]['Contact_Mobile'])) {
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Phone:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Contact_Phone']!=""? $varNewProfileDetails[$i]['Contact_Phone'] : "-";
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Mobile:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Contact_Mobile'] !='' ? $varNewProfileDetails[$i]['Contact_Mobile'] :  "-";
	$varTotalTable .= '</td></tr>';
	}

	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF">';
	if($varNewProfileDetails[$i]['Country']!= 222 && $varNewProfileDetails[$i]['Country']!= 98) {
	$varTotalTable .= '<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing State:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Residing_Area']!=""? $varNewProfileDetails[$i]['Residing_Area'] : "-";
	$varTotalTable .= '</td>';
	}
	if($varNewProfileDetails[$i]['Country']!= 98) {
	$varTotalTable .= '<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing City:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Residing_City'] ? $varNewProfileDetails[$i]['Residing_City'] :  "-";
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
	$varTotalTable .= $arrMaritalList[$varNewProfileDetails[$i]['Marital_Status']];
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Created Date:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Date_Created'] ? $varNewProfileDetails[$i]['Date_Created'] :  "-";
	$varTotalTable .= '</td></tr>';

	if($varNewProfileDetails[$i]['About_MyPartner']!="") {
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Short Partner Description:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['About_MyPartner']!=""? $varNewProfileDetails[$i]['About_MyPartner'] : "-";
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

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Comments:</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><textarea name="adminComment'.$i.'"  rows=3 cols=38>';
	$varTotalTable .= '</textarea></td></tr><tr><td colspan="4" height="10"></td></tr>';

    // done by barani //
    //$varDuplicateEmailCount = getDuplicateEmails($varNewProfileDetails[$i][MatriId],$varEmail);
	$varDuplicateEmailCount = $objProfileDetail->getDuplicateEmails($varNewProfileDetails[$i][MatriId],$varEmail);
	$varMatriId = $varNewProfileDetails[$i][MatriId];
	$varDuplicateEmailLink = ($varDuplicateEmailCount)? "<a href=# onClick=javascript:window.open('/admin/view-duplicate-emails.php?email=$varEmail&MatriId=$varMatriId','popup','width=500,height=620'); class='smalltxt boldtxt heading'>Duplicate Emails(".$varDuplicateEmailCount.")</a>&nbsp;&nbsp;|&nbsp;&nbsp;" : '';
    // end //

	$varTotalTable .= '<tr class="memonlsbg4"><td class=smalltxt colspan=4 style="padding:5px 5px 5px 5px" colspan="3"><input name="matriId'.$i.'" value="'.$varNewProfileDetails[$i]['MatriId'].'" type="hidden"><input name="communityid'.$i.'" value="'.$varNewProfileDetails[$i]['CommunityId'].'" type="hidden"><input name="action'.$i.'" value="add" type="radio">&nbsp;&nbsp;<font class="text"><b>Add</b></font>';
	if($_REQUEST['profilePaidStatus'] == 'no') { 
	$varTotalTable .= '&nbsp;&nbsp;<input name="action'.$i.'" value="ignore" type="radio"><font class="text"><b>Ignore</b></font>&nbsp;&nbsp;<input name="action'.$i.'" value="reject" type="radio"><font class="text"><b>Reject</b></font>';
	}
	$varTotalTable .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="text"><label class=formlink1 align=left>'.$varDuplicateEmailLink.'<a href="'.$varModifyUrl.$varNewProfileDetails[$i]['MatriId'].'" class="smalltxt boldtxt heading" target="_blank">Modify Profile</a></label></tr>';

	$varTotalTable .= '</table></td></tr><tr><td height="10" width="100%"  class="vdotline1"><HR></td></tr>';
}
$varTotalTable .= '<tr><td style="padding-left:7px;"><table border="0" cellpadding="3" cellspacing="0" width="530" class="formborder">';

//$varTotalTable .= '<tr><td class="adminformheader">Please enter your login details :</td></tr><tr><td><table border="0" cellpadding="3" cellspacing="3" width="230"><tbody><tr><td><font class="smalltxt boldtxt"><b>Username : </b></font></td><td><input name="suplogin" class="inputtxt" size="15" type="text" value=""></td></tr><tr><td><font class="smalltxt boldtxt"><b>Password : </b></font></td><td><input name="suppswd" size="15" type="password" value=""></td></tr></tbody></table></td></tr>';

$varTotalTable .= '</table><br><br></td></tr><tr><td><center><input type="submit" class="button" value="Submit"><input type="hidden" name="spage" class="smalltxt" value="'.$varSepartePage.'"></center></td></tr></form>';

$objAdminMailer->dbClose();
$objMaster->dbClose();
?>
<style type="text/css">@import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="10"></td></tr>
	<tr>
		<td class="heading" style="padding-left:10px;">New Profiles</td>
	</tr>
	<tr><td height="10"></td></tr>
	<?php if($varTotalRow==0 && $UserId!='') { ?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;">This profile doesnot exist or not in queue for validation.</td>
	</tr>
	<?php } elseif($varTotalRow==0 && $UserId=='') { ?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;">Sorry! No New Records Found.</td>
	</tr>
	<?php } else { ?>
	<?= $varTotalTable; ?>
	<?php } ?>
</table>
<script language="JavaScript">
<!--
	function radio_button_checker(rc)
	{
		var rcc=rc;
		var radio_choice = false;
		var frmLoginDetails=document.frmAddedProfile;
			/*if(frmLoginDetails.suplogin.value == "")
			{
				alert("Please enter Username");
				frmLoginDetails.suplogin.focus();
				return false;
			}
			if(frmLoginDetails.suppswd.value == "")
			{
				alert("Please enter Password");
				frmLoginDetails.suppswd.focus();
				return false;
			}*/

			for(i=0;i<rcc;i++)
			{
				var temp1="document.frmAddedProfile.action"+i+"[0]";
				var temp2="document.frmAddedProfile.action"+i+"[1]";
				var temp3="document.frmAddedProfile.action"+i+"[2]";
				var temp4="document.frmAddedProfile.adminComment"+i;
				var j = i + 1;

				if (!(eval(temp1).checked) && !(eval(temp2).checked) && !(eval(temp3).checked))
				{
					alert("Please select add or ignore or reject for profile "+j);
					eval(temp1).focus();
					return false;
				}


				if ((eval(temp3).checked)&&(eval(temp4).value == "") )
				{
					alert("Please enter the reason for rejecting Profile "+j);
					eval(temp4).focus();
					return false;
				}
			}
		return true;
	}
//-->
</script>