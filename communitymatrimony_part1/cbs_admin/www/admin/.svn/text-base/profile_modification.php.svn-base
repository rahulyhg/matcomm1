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
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsAdminValMailer.php');
include_once($varRootBasePath.'/www/payment/getcountry.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//OBJECT DECLARTION
$objMaster		    = new MemcacheDB;
$objAdminMailer     = new AdminValid;
$objProfileDetail	= new ProfileDetail;
$objDomain		    = new domainInfo;


//DB CONNECTION
$objAdminMailer->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

$varRequestMatriId	= $_REQUEST['id'];
$varMatriID = $_REQUEST['MatriId'];
$varUserId  = $_REQUEST['reportid'];
$varNoOfRecords	 = 1;
$varCommentwithAdmin	= '--'.date('y-m-d H:i:s').'--'.$varCookieInfo['USERNAME'].'--';
$varModifyUrl	= 'index.php?act=edit-profile&MatriId=';

$varGivenTime		= 300;
// $today = date("H:i:s");

if($_REQUEST['elpasetime']=='yes') {
	$varStatus			= 'Z';
	$matriId			= $_REQUEST['matid'];

	//update validation report
	$argFields 			= array('profilestatus');
	$argFieldsValues	= array($objMaster->doEscapeString($varStatus,$objMaster));
	$argCondition		= " id=".$objMaster->doEscapeString($varUserId,$objMaster)." AND matriid=".$objMaster->doEscapeString($matriId,$objMaster)." AND userid=".$objMaster->doEscapeString($adminUserName,$objMaster);
	$varUpdateId		= $objMaster->update($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues,$argCondition);

	//insert into validation timeout report
	$argFields			= array('MatriId','User_Name','TimeoutDate','Status');
	$argFieldsValues	= array($objMaster->doEscapeString($matriId,$objMaster),$objMaster->doEscapeString($adminUserName,$objMaster),"NOW()",1);	
	$varTimeoutInsertId	= $objMaster->insert($varTable['TIMEOUTREPORT'],$argFields,$argFieldsValues);
	//header("Location: index.php?act=logout");exit;
	echo '<script language="javascript">document.location.href ="index.php?act=logout"; </script>';exit;

}if($_POST['frmUpdateSubmit']=='yes') {
	
	for($i=0;$i<$varNoOfRecords;$i++)
	{
		$action			= $_REQUEST['action'.$i];
		$matriId		= $_REQUEST['matriId'.$i];
		$name			= trim($_REQUEST['name'.$i]);
		$nickname		= trim($_REQUEST['nickname'.$i]);
		$age			= $_REQUEST['age'.$i];
		$aboutme		= trim($_REQUEST['aboutme'.$i]);
		$resstate		= trim($_REQUEST['resstate'.$i]);
		$rescity		= trim($_REQUEST['rescity'.$i]);
		$conaddr		= $_REQUEST['conaddr'.$i];
		$conphone		= $_REQUEST['conphone'.$i];
		$conmob			= $_REQUEST['conmob'.$i];
		$emailid		= $_REQUEST['emailid'.$i];
		$gothramid		= $_REQUEST['gothramid'.$i];
		$gothramtxt		= trim($_REQUEST['gothramtxt'.$i]);
		$mothertongueid	= $_REQUEST['mothertongueid'.$i];
		$mothertonguetxt= trim($_REQUEST['mothertonguetxt'.$i]);
		$edudet			= trim($_REQUEST['edudet'.$i]);
		$occdet			= trim($_REQUEST['occdet'.$i]);
		$incomecurrency	= $_REQUEST['incomecurrency'.$i];
		$income			= trim($_REQUEST['income'.$i]);
		$denominationid	= $_REQUEST['denominationid'.$i];
		$denominationtxt= trim($_REQUEST['denominationtxt'.$i]);
		$casteid		= $_REQUEST['casteid'.$i];
		$castetxt		= trim($_REQUEST['castetxt'.$i]);
		$subcasteid		= $_REQUEST['subcasteid'.$i];
		$subcastetxt	= trim($_REQUEST['subcastetxt'.$i]);
		$pardesc		= trim($_REQUEST['pardesc'.$i]);
		$country		= $_REQUEST['country'.$i];
		$citizenship	= $_REQUEST['citizenship'.$i];
		$residentStatus	= $_REQUEST['residentStatus'.$i];
		$fatOcc			= trim($_REQUEST['fatOcc'.$i]);
		$motOcc			= trim($_REQUEST['motOcc'.$i]);
		$familyOrigin	= trim($_REQUEST['familyOrigin'.$i]);
		$abtFamily		= trim($_REQUEST['abtFamily'.$i]);
		$othHob			= trim($_REQUEST['othHob'.$i]);
		$othInt			= trim($_REQUEST['othInt'.$i]);
		$othMus			= trim($_REQUEST['othMus'.$i]);
		$othRead		= trim($_REQUEST['othRead'.$i]);
		$othmovie		= trim($_REQUEST['othmovie'.$i]);
		$othSport		= trim($_REQUEST['othSport'.$i]);
		$othCuisine		= trim($_REQUEST['othCuisine'.$i]);
		$othDress		= trim($_REQUEST['othDress'.$i]);
		$othLang		= trim($_REQUEST['othLang'.$i]);
		$adminComment	= trim($_REQUEST['adminComment'.$i]);

		//SETING MEMCACHE KEY
		$varProfileMCKey= 'ProfileInfo_'.$matriId;
		$varTimeTaken			= $varGivenTime-$_REQUEST['counttime'];

		$argCondition			= "WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);

		$argFields 				= array('Date_Updated');
		$varDateUpdatedInfoRes	= $objAdminMailer->select($varTable['MEMBERUPDATEDINFO'],$argFields,$argCondition,0);
		$varDateUpdatedInfo		= mysql_fetch_assoc($varDateUpdatedInfoRes);
		$varDateUpdated			= $varDateUpdatedInfo['Date_Updated'];

		//Common for reject and Add
		$argFields				= array('Email');
		$argCondition			= "WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
		$varMemberEmailRes		= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varMemberEmail			= mysql_fetch_assoc($varMemberEmailRes);
		$varToEmail				= $varMemberEmail['Email'];

		//Get name for particular Username
		//$argFields				= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
		$argFields = $arrMEMBERINFOfields;
		$varNameRes			= $objAdminMailer->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);
		$varToName			= ($varNameRes['Nick_Name']!='')?$varNameRes['Nick_Name']:$varNameRes['Name'];

		//Reject updated profile with Error And SendingMail
		if( $action == "reject")
		{
			$varRejectCount		= $varRejectCount + 1;
			$argCondition		= "MatriId='".$matriId."'";
			$varStatus			= "R";
			$valFrom            = "modify";
			//DELETE memberupdatedinfo INFO
			$objMaster->delete($varTable['MEMBERUPDATEDINFO'],$argCondition);
			$retValue = $objAdminMailer->sendTroubleWithUrProfileMail($matriId,$varToName,$varToEmail,$adminComment,$valFrom);
		}

		$argCondition		= "MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
		//Accept updated profile
		if($action == "add")
		{
			$varAddCount		= $varAddCount+1;
			$varStatus			= "A";
			$argFields			= array();
			$argFieldsValues	= array();

			if($name!='') {
				$argFields[]		= 'Name';
				$argFieldsValues[]	= $objMaster->doEscapeString($name,$objMaster);
			}
			if($nickname!='') {
				$argFields[]		= 'Nick_Name';
				$argFieldsValues[]	= $objMaster->doEscapeString($nickname,$objMaster);
			}
			if($age!=0) {
				$argFields[]		= 'Age';
				$argFieldsValues[]	= $objMaster->doEscapeString($age,$objMaster);
			}
			if($aboutme!='') {
				$argFields[]		= 'About_Myself';
				$argFieldsValues[]	= $objMaster->doEscapeString($aboutme,$objMaster);
			}
			if($conaddr!='') {
				$argFields[]		= 'Contact_Address';
				$argFieldsValues[]	= $objMaster->doEscapeString($conaddr,$objMaster);
			}
			if($conphone!='') {
				$argFields[]		= 'Contact_Phone';
				$argFieldsValues[]	= $objMaster->doEscapeString($conphone,$objMaster);
			}
			if($conmob!='') {
				$argFields[]		= 'Contact_Mobile';
				$argFieldsValues[]	= $objMaster->doEscapeString($conmob,$objMaster);
			}
			if($edudet!='') {
				$argFields[]		= 'Education_Detail';
				$argFieldsValues[]	= $objMaster->doEscapeString($edudet,$objMaster);
			}
			if($occdet!='') {
				$argFields[]		= 'Occupation_Detail';
				$argFieldsValues[]	= $objMaster->doEscapeString($occdet,$objMaster);
			}
			if($income!='0.00') {
				$argFields[]		= 'Annual_Income';
				$argFieldsValues[]	= $objMaster->doEscapeString($income,$objMaster);
				$argFields[]		= 'Income_Currency';
				$argFieldsValues[]	= $objMaster->doEscapeString($incomecurrency,$objMaster);
			}
			if($castetxt!='') {
				/*if($denominationid == '9997') {
					$argFields[]		= 'Denomination';
					$argFieldsValues[]	= $objMaster->doEscapeString($denominationid,$objMaster);
				}*/

				$argFields[]		= 'CasteId';
				if($casteid == '9997') {
					$argFieldsValues[]	= $objMaster->doEscapeString($casteid,$objMaster);
				} else {
					$argFieldsValues[]	= "''";
				}
				$argFields[]		= 'CasteText';
				$argFieldsValues[]	= $objMaster->doEscapeString($castetxt,$objMaster);
			}
						
			if($denominationtxt!='') {
				$argFields[]		= 'Denomination';
				if($denominationid == '9997') {
					$argFieldsValues[]	= $objMaster->doEscapeString($denominationid,$objMaster);
				} else {
					$argFieldsValues[]	= "''";
				}
				$argFields[]		= 'DenominationText';
				$argFieldsValues[]	= $objMaster->doEscapeString($denominationtxt,$objMaster);
			}

			if($subcastetxt!='') {
				$argFields[]		= 'SubcasteId';
				if($subcasteid == '9997') {
					$argFieldsValues[]	= $objMaster->doEscapeString($subcasteid,$objMaster);
				} else {
					$argFieldsValues[]	= "''";
				}
				$argFields[]		= 'SubcasteText';
				$argFieldsValues[]	= $objMaster->doEscapeString($subcastetxt,$objMaster);
			}
			if($mothertonguetxt!='') {
				$argFields[]		= 'Mother_TongueId';
				if($mothertongueid == '9997') {
					$argFieldsValues[]	= $objMaster->doEscapeString($mothertongueid,$objMaster);
				} else {
					$argFieldsValues[]	= "''";
				}
				$argFields[]		= 'Mother_TongueText';
				$argFieldsValues[]	= $objMaster->doEscapeString($mothertonguetxt,$objMaster);
			}
			if($gothramtxt!='') {
				$argFields[]		= 'GothramId';
				if($gothramid == '9997') {
					$argFieldsValues[]	= $objMaster->doEscapeString($gothramid,$objMaster);
				} else {
					$argFieldsValues[]	= "''";
				}
				$argFields[]		= 'GothramText';
				$argFieldsValues[]	= $objMaster->doEscapeString($gothramtxt,$objMaster);
			}
			if($country!='0') {
				$argFields[]		= 'Country';
				$argFieldsValues[]	= $objMaster->doEscapeString($country,$objMaster);
			}
			if($citizenship!='0') {
				$argFields[]		= 'Citizenship';
				$argFieldsValues[]	= $objMaster->doEscapeString($citizenship,$objMaster);
			}
			if($resstate!='' && $resstate!='0') {
				if($country == 222) {
					$argFields[]	='Residing_State';
					$argFieldsValues[]=$objMaster->doEscapeString($resstate,$objMaster);
					$argFields[]	= 'Residing_Area';
					$argFieldsValues[]="''";
				} else {
					$argFields[]	='Residing_State';
					$argFieldsValues[]="''";
					$argFields[]	='Residing_Area';
					$argFieldsValues[]=$objMaster->doEscapeString($resstate,$objMaster);
				}
			}
			if($rescity!='') {
				$argFields[]		= 'Residing_City';
				$argFieldsValues[]	= $objMaster->doEscapeString($rescity,$objMaster);
				$argFields[]		= 'Residing_District';
				$argFieldsValues[]	= "''";
			}
			if($residentStatus!='0') {
				$argFields[]		= 'Resident_Status';
				$argFieldsValues[]	= $objMaster->doEscapeString($residentStatus,$objMaster);
			}
			$argSupportFields				= array('Support_Comments');
			$argSupportCondition			= "WHERE MatriId=".$objAdminMailer->doEscapeString($matriId,$objAdminMailer);
			$varMemberCommentsRes	= $objAdminMailer->select($varTable['MEMBERINFO'],$argSupportFields,$argSupportCondition,0);
			$varMemberSupportComments = mysql_fetch_assoc($varMemberCommentsRes);
			$varToSupportComments	= $varMemberSupportComments['Support_Comments'];

            if($adminComment!='0') {
			    $adminComment		= $varToSupportComments.$varCommentwithAdmin.$adminComment;
				$argFields[]		= 'Support_Comments';
				$argFieldsValues[]	= $objMaster->doEscapeString($adminComment,$objMaster);
			}

			if(sizeof($argFields)!='0')
			{
				$argFields[]		= 'Publish';
				$argFieldsValues[]	= 1;
				$argFields[]		= 'Date_Updated';
				$argFieldsValues[]	= "'".$varDateUpdated."'";
				$varUpdateId		= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);
			}

			$argFields				= array();
			$argFieldsValues		= array();
			if($emailid !='') {
				array_push($argFields,'Email');
				array_push($argFieldsValues,$objMaster->doEscapeString($emailid,$objMaster));
			}
			if(sizeof($argFields)!='0') {
				array_push($argFields,'Date_Updated');
				array_push($argFieldsValues,"'".$varDateUpdated."'");
				$varUpdateId		= $objMaster->update($varTable['MEMBERLOGININFO'],$argFields,$argFieldsValues,$argCondition);
			}

			$argFields				= array();
			$argFieldsValues		= array();
			if($fatOcc !='') {
				array_push($argFields,'Father_Occupation');
				array_push($argFieldsValues,$objMaster->doEscapeString($fatOcc,$objMaster));
			}
			if($motOcc !='') {
				array_push($argFields,'Mother_Occupation');
				array_push($argFieldsValues,$objMaster->doEscapeString($motOcc,$objMaster));
			}
			if($familyOrigin !='') {
				array_push($argFields,'Family_Origin');
				array_push($argFieldsValues,$objMaster->doEscapeString($familyOrigin,$objMaster));
			}
			if($abtFamily !='') {
				array_push($argFields,'About_Family');
				array_push($argFieldsValues,$objMaster->doEscapeString($abtFamily,$objMaster));
			}
			if(sizeof($argFields)!='0') {
				array_push($argFields,'Date_Updated');
				array_push($argFieldsValues,"'".$varDateUpdated."'");
				$varUpdateId		= $objMaster->update($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues,$argCondition);
			}


			$argFields				= array();
			$argFieldsValues		= array();
			if($othHob !='') {
				array_push($argFields,'Hobbies_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othHob,$objMaster));
			}
			if($othInt !='') {
				array_push($argFields,'Interests_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othInt,$objMaster));
			}
			if($othMus !='') {
				array_push($argFields,'Music_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othMus,$objMaster));
			}
			if($othRead !='') {
				array_push($argFields,'Books_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othRead,$objMaster));
			}
			if($othmovie !='') {
				array_push($argFields,'Movies_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othmovie,$objMaster));
			}
			if($othSport !='') {
				array_push($argFields,'Sports_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othSport,$objMaster));
			}
			if($othCuisine !='') {
				array_push($argFields,'Food_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othCuisine,$objMaster));
			}
			if($othDress !='') {
				array_push($argFields,'Dress_Style_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othDress,$objMaster));
			}
			if($othLang !='') {
				array_push($argFields,'Languages_Others');
				array_push($argFieldsValues,$objMaster->doEscapeString($othLang,$objMaster));
			}
			if(sizeof($argFields)!='0') {
				array_push($argFields,'Date_Updated');
				array_push($argFieldsValues,"'".$varDateUpdated."'");
				$varUpdateId		= $objMaster->update($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues,$argCondition);
			}

			if($pardesc !='')
			{
				$argFields				= array('Partner_Description','Date_Updated');
				$argFieldsValues		= array($objMaster->doEscapeString($pardesc,$objMaster),"'".$varDateUpdated."'");
				$varUpdateId		= $objMaster->update($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues,$argCondition);
			}

			$objMaster->delete($varTable['MEMBERUPDATEDINFO'],$argCondition);

			$retValue = $objAdminMailer->sendProfileModificationMail($matriId,$varToName,$varToEmail);
		}

		//Update Pending_Modify_Validation in memberinfo table
		$argFields 				= array('Pending_Modify_Validation');
		$argFieldsValues		= array(0);
		$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

		//update validation report
		$argFields 			= array('comments','profilestatus','timetaken','validateddate');
		$argFieldsValues	= array($objMaster->doEscapeString($adminComment,$objMaster),$objMaster->doEscapeString($varStatus,$objMaster),$varTimeTaken,"NOW()");
		$argCondition	= " id=".$objMaster->doEscapeString($varUserId,$objMaster)." AND MatriId=
		".$objMaster->doEscapeString($varMatriID,$objMaster)." AND userid=".$objMaster->doEscapeString($adminUserName,$objMaster);
		$varUpdateId		= $objMaster->update($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues,$argCondition);

	}
	if((!isset($_REQUEST['stopprofile']))&&(!isset($_REQUEST['id']))){
	echo '<script language="javascript">document.location.href ="index.php?act=shuffled_profile_modification"; </script>';exit;
	}
}
if($varRequestMatriId!=''){
		$argFields 			= array('Pending_Modify_Validation');
		$argCondition		= " WHERE MatriId=".$objMaster->doEscapeString($varRequestMatriId,$objMaster);
		$varMemberInfoResult= $objMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varMemberInfoResCnt= mysql_num_rows($varMemberInfoResult);

		if($varMemberInfoResCnt>0) {
			 $varMemberInfoRes = mysql_fetch_assoc($varMemberInfoResult);
			 $varMemberInfoRes['Pending_Modify_Validation'];
			if($varMemberInfoRes['Pending_Modify_Validation']==0) {
				$varErrorMessage	= "The Profile Has been Modified";
			} else {
				$varQuery	= "INSERT IGNORE INTO profilemodificationpending SELECT MatriId,2,Date_Updated FROM ".$varTable['MEMBERINFO']." WHERE MatriId=".$objMaster->doEscapeString($varRequestMatriId,$objMaster)." AND Pending_Modify_Validation=1";
				$objMaster->ExecuteQryResult($varQuery);

				//update support_validationq
				$argFields 		= array('Validation_Status','Date_Added');
				$argFieldsValues= array(3,"NOW()");
				$argCondition	= " MatriId=".$objMaster->doEscapeString($varRequestMatriId,$objMaster);
				$varUpdateId	= $objMaster->update($varTable['SUPPORT_VALIDATIONQ'],$argFields,$argFieldsValues,$argCondition);

				//inert into support validation report table
				$argFields			= array('matriid','userid','downloadeddate','reporttype');
				$argFieldsValues	= array($objMaster->doEscapeString($varRequestMatriId,$objMaster),$objMaster->doEscapeString($adminUserName,$objMaster),"NOW()",6);
				$varSupportInsertId	= $objMaster->insert($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues);


				 $varMatriID		= $varRequestMatriId;
				 $varUserId	    = $varSupportInsertId;
			}
		} else {
			$varErrorMessage	= "This MatriId is not available";
		}

}

if(($varMatriID!='')||($varRequestMatriId!=''))
{
	$argCondition	= "WHERE MatriId=".$objAdminMailer->doEscapeString($varMatriID,$objAdminMailer);
	$argFields  				= array('MatriId','User_Name','Name','Nick_Name','Age','Denomination','DenominationText','CasteId','CasteText','SubcasteId','SubcasteText','Mother_TongueId','Mother_TongueText','About_Myself','Country','Citizenship','Resident_Status','Residing_State','Residing_City','Contact_Address','Contact_Phone','Contact_Mobile','Email','GothramId','GothramText','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Father_Occupation','Mother_Occupation','Family_Origin','About_Family','Other_Hobbies','Other_Interest','Other_Music','Other_Reads','Other_Movies','Other_Fitness','Other_Cuisine','Other_Dress','Other_Languages','Partner_Description');

	$varNewProfileDetails		= $objAdminMailer->select($varTable['MEMBERUPDATEDINFO'],$argFields,$argCondition,1);
	$varTotalRow				= count($varNewProfileDetails);

}else{
	$varErrorMessage	= "Data not available for Modification";
}
if($varTotalRow>0){
	$varTotalTable .= '<form name="frmUpdateProfile" method="post" onsubmit="return radio_button_checker('.$varTotalRow.')">';
	$varTotalTable .= '<input type="hidden" name="frmUpdateSubmit" value="yes">';
	$varTotalTable .= '<input type="hidden" name="matriId" value="'.$varMatriID.'">';
	$varTotalTable .= '<input type="hidden" name="reportid" value="'.$varUserId.'">';
	$varTotalTable .= '<input type="hidden" name="elapsedtime" value="">';
	for($i=0;$i<$varTotalRow;$i++)
	{
	$varProfileMatriId = $varNewProfileDetails[$i]['MatriId'];
	//get Username for particular MatriId
	$argCondition			= "WHERE MatriId=".$objAdminMailer->doEscapeString($varProfileMatriId,$objAdminMailer);
	$argFields				= array('MatriId');
	$varMemberUnameRes		= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	$varMemberUname			= mysql_fetch_assoc($varMemberUnameRes);
	$varProfileUserName		= $varMemberUname['MatriId'];

   // Done by barani //
       $Ipaddress= $objProfileDetail->getProfileIpAddress($varNewProfileDetails[$i][MatriId]);
	   $varGetCountry = getCountry($Ipaddress);
	   $varCountryLocation = (in_array($varGetCountry->country_short,$varSpecialCountries))?('<label class=smalltxt><font color="red">'.$varGetCountry->country_long.'</font></label>'):($varGetCountry->country_long);
	// end //

	$varTotalTable .= '<input type="hidden" name="MatriId" value="'.$varProfileMatriId.'">';
	$varTotalTable .= '<tr><td><table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="595"><tr><td valign="top" class="mailerEditTop" colspan="4">MatriId :'.$varProfileUserName.'&nbsp;&nbsp;&nbsp;Registered from IP : '.$varCountryLocation.'</td></tr>';
	$varTotalTable .= '<tr><td valign="top" class="mailerEditTop" colspan="4" align="right">Time limit <input type="text" size="5" name="counttime" value="" readonly=true></td></tr>';
	if($varNewProfileDetails[$i]['Nick_Name']!='') {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Display name:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['Nick_Name']!=""?stripslashes(htmlentities($varNewProfileDetails[$i]['Nick_Name'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Name']!='' || $varNewProfileDetails[$i]['Age']!=0) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Name:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Name']!=""? stripslashes(htmlentities($varNewProfileDetails[$i]['Name'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Age:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Age'] ? $varNewProfileDetails[$i]['Age'] :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Email']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Email:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Email']!=""? stripslashes(htmlentities($varNewProfileDetails[$i]['Email'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"></td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"></td></tr>';
	//$varTotalTable .= $varNewProfileDetails[$i]["Gender"]==2 ? "Female" : "Male";
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['About_Myself']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">About Myself:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['About_Myself']!=""? stripslashes(htmlentities($varNewProfileDetails[$i]['About_Myself'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}	
	
	if($varNewProfileDetails[$i]['DenominationText']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Denomination:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['DenominationText']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['DenominationText'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td>';
	}

	if($varNewProfileDetails[$i]['CasteText']!="" || $varNewProfileDetails[$i]['SubcasteText']!='') {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Caste:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['CasteText']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['CasteText'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Subcaste:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['SubcasteText']!='' ? stripslashes(htmlentities($varNewProfileDetails[$i]['SubcasteText'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['GothramText']!="" || $varNewProfileDetails[$i]['Mother_TongueText']!='') {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Gothram:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['GothramText']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['GothramText'] ,ENT_QUOTES)): "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Mother Tongue:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Mother_TongueText']!='' ? stripslashes(htmlentities($varNewProfileDetails[$i]['Mother_TongueText'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Annual_Income']!=0)
	{
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Annual Income:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= stripslashes(htmlentities($varNewProfileDetails[$i]['Annual_Income'],ENT_QUOTES)).'&nbsp;&nbsp;'.$arrSelectCurrencyList[$varNewProfileDetails[$i]['Income_Currency']];
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if(($varNewProfileDetails[$i]['Education_Detail']!="") || ($varNewProfileDetails[$i]['Occupation_Detail'])) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Education In Detail:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Education_Detail']!=""? stripslashes(htmlentities($varNewProfileDetails[$i]['Education_Detail'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Occupation In Detail:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Occupation_Detail'] ? stripslashes(htmlentities($varNewProfileDetails[$i]['Occupation_Detail'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Country']!='0' || $varNewProfileDetails[$i]['Citizenship']!='0') {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Country:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Country']!='0'? $arrCountryList[$varNewProfileDetails[$i]['Country']] : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Citizenship:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Citizenship']!='0' ? $arrCountryList[$varNewProfileDetails[$i]['Citizenship']] :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Residing_State']!="" || $varNewProfileDetails[$i]['Residing_City']!='') {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing State:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Residing_State']!=""?($varNewProfileDetails[$i]['Country']=='222'?$arrUSAStateList[$varNewProfileDetails[$i]['Residing_State']]:stripslashes(htmlentities($varNewProfileDetails[$i]['Residing_State'],ENT_QUOTES))) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Residing City:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Residing_City'] ? stripslashes(htmlentities($varNewProfileDetails[$i]['Residing_City'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Resident_Status']!='0') {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Resident Status:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['Resident_Status']!='0'? $arrResidentStatusList[$varNewProfileDetails[$i]['Resident_Status']] : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Contact_Address']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Address:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['Contact_Address']!=""? $varNewProfileDetails[$i]['Contact_Address'] : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if(($varNewProfileDetails[$i]['Contact_Phone']!="") || ($varNewProfileDetails[$i]['Contact_Mobile']!="")) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Phone:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Contact_Phone']!=""? stripslashes(htmlentities($varNewProfileDetails[$i]['Contact_Phone'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Mobile:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Contact_Mobile'] ? stripslashes(htmlentities($varNewProfileDetails[$i]['Contact_Mobile'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if(($varNewProfileDetails[$i]['Father_Occupation']!="") || ($varNewProfileDetails[$i]['Mother_Occupation']!="")) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Father Occupation:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Father_Occupation']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['Father_Occupation'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Mother Occupation:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Mother_Occupation'] !=''? stripslashes(htmlentities($varNewProfileDetails[$i]['Mother_Occupation'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Family_Origin']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Family Origin:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['Family_Origin']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['Family_Origin'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['About_Family']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">About My Family:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['About_Family']!=""? stripslashes(htmlentities($varNewProfileDetails[$i]['About_Family'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if(($varNewProfileDetails[$i]['Other_Hobbies']!="") || ($varNewProfileDetails[$i]['Other_Interest']!="")) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Hobbies:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Hobbies']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['Other_Hobbies'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Interest:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Interest']!='' ? stripslashes(htmlentities($varNewProfileDetails[$i]['Other_Interest'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if(($varNewProfileDetails[$i]['Other_Music']!="") || ($varNewProfileDetails[$i]['Other_Reads']!="")) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Musics:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Music']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['Other_Music'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Books:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Reads']!='' ? $varNewProfileDetails[$i]['Other_Reads'] :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if(($varNewProfileDetails[$i]['Other_Movies']!="") || ($varNewProfileDetails[$i]['Other_Fitness']!="")) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Movies:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Movies']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['Other_Movies'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Sports:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Fitness']!='' ? stripslashes(htmlentities($varNewProfileDetails[$i]['Other_Fitness'],ENT_QUOTES)) :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if(($varNewProfileDetails[$i]['Other_Cuisine']!="") || ($varNewProfileDetails[$i]['Other_Dress']!="")) {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Foods:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Cuisine']!=''? $varNewProfileDetails[$i]['Other_Cuisine'] : "-";
	$varTotalTable .= '</td><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Dresses:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Dress']!='' ? $varNewProfileDetails[$i]['Other_Dress'] :  "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Other_Languages']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Other Languages:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['Other_Languages']!=''? stripslashes(htmlentities($varNewProfileDetails[$i]['Other_Languages'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varNewProfileDetails[$i]['Partner_Description']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Partner Description:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= $varNewProfileDetails[$i]['Partner_Description']!=""? stripslashes(htmlentities($varNewProfileDetails[$i]['Partner_Description'],ENT_QUOTES)) : "-";
	$varTotalTable .= '</td></tr>';
	$varTotalTable .= '<tr><td class="mailbxstalbg" width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="admintxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Comments:</td><td valign="top" class="smalltxtadmin" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><textarea name="adminComment'.$i.'"  rows=3 cols=38>';
	$varTotalTable .= '</textarea></td></tr><tr><td colspan="4" height="10"></td></tr>';
	//Hidden Values Starts Here
	$varTotalTable .= '<tr class="memonlsbg4" style="display:none"><td class=smalltxtadmin style="padding:5px 5px 5px 5px" colspan="4"><input name="name'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Name"],ENT_QUOTES).'" type="hidden"><input name="nickname'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]['Nick_Name'],ENT_QUOTES).'" type="hidden"><input name="age'.$i.'" value="'.$varNewProfileDetails[$i]["Age"].'" type="hidden"><input name="aboutme'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["About_Myself"],ENT_QUOTES).'" type="hidden"><input name="resstate'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Residing_State"],ENT_QUOTES).'" type="hidden"><input name="rescity'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Residing_City"],ENT_QUOTES).'" type="hidden"><input name="conaddr'.$i.'" value="'.$varNewProfileDetails[$i]["Contact_Address"].'" type="hidden"><input name="conphone'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Contact_Phone"],ENT_QUOTES).'" type="hidden"><input name="conmob'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]['Contact_Mobile'],ENT_QUOTES).'" type="hidden"><input name="emailid'.$i.'" value="'.$varNewProfileDetails[$i]["Email"].'" type="hidden"><input name="mothertongueid'.$i.'" value="'.$varNewProfileDetails[$i]["Mother_TongueId"].'" type="hidden"><input name="mothertonguetxt'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Mother_TongueText"],ENT_QUOTES).'" type="hidden"><input name="gothramid'.$i.'" value="'.$varNewProfileDetails[$i]["GothramId"].'" type="hidden"><input name="gothramtxt'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["GothramText"],ENT_QUOTES).'" type="hidden"><input name="edudet'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Education_Detail"],ENT_QUOTES).'" type="hidden"><input name="occdet'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Occupation_Detail"],ENT_QUOTES).'" type="hidden"><input name="incomecurrency'.$i.'" value="'.$varNewProfileDetails[$i]["Income_Currency"].'" type="hidden"><input name="income'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Annual_Income"],ENT_QUOTES).'" type="hidden">	
	<input name="denominationid'.$i.'" value="'.$varNewProfileDetails[$i]["Denomination"].'" type="hidden">
	<input name="denominationtxt'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["DenominationText"],ENT_QUOTES).'" type="hidden">
	<input name="casteid'.$i.'" value="'.$varNewProfileDetails[$i]["CasteId"].'" type="hidden"><input name="castetxt'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["CasteText"],ENT_QUOTES).'" type="hidden"><input name="subcasteid'.$i.'" value="'.$varNewProfileDetails[$i]["SubcasteId"].'" type="hidden"><input name="subcastetxt'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["SubcasteText"],ENT_QUOTES).'" type="hidden"><input name="pardesc'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]['Partner_Description'],ENT_QUOTES).'" type="hidden"><input name="country'.$i.'" value="'.$varNewProfileDetails[$i]["Country"].'" type="hidden"><input name="citizenship'.$i.'" value="'.$varNewProfileDetails[$i]["Citizenship"].'" type="hidden"><input name="residentStatus'.$i.'" value="'.$varNewProfileDetails[$i]["Resident_Status"].'" type="hidden"><input name="fatOcc'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Father_Occupation"],ENT_QUOTES).'" type="hidden"><input name="motOcc'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Mother_Occupation"],ENT_QUOTES).'" type="hidden"><input name="familyOrigin'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Family_Origin"],ENT_QUOTES).'" type="hidden"><input name="abtFamily'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["About_Family"],ENT_QUOTES).'" type="hidden"><input name="othHob'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Hobbies"],ENT_QUOTES).'" type="hidden"><input name="othInt'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Interest"],ENT_QUOTES).'" type="hidden"><input name="othMus'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Music"],ENT_QUOTES).'" type="hidden"><input name="othRead'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Reads"],ENT_QUOTES).'" type="hidden"><input name="othmovie'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Movies"],ENT_QUOTES).'" type="hidden"><input name="othSport'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Fitness"],ENT_QUOTES).'" type="hidden"><input name="othCuisine'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Cuisine"],ENT_QUOTES).'" type="hidden"><input name="othDress'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Dress"],ENT_QUOTES).'" type="hidden"><input name="othLang'.$i.'" value="'.htmlentities($varNewProfileDetails[$i]["Other_Languages"],ENT_QUOTES).'" type="hidden"></td></tr>';
	//Hidden Values Ends Here

	 // done by barani //
	 //get email for particular matri id
	  $argFields				= array('Email');
	  $argCondition			= "WHERE MatriId='".$varNewProfileDetails[$i][MatriId]."'";
	  $varMatriId =$varNewProfileDetails[$i][MatriId];
	  $varMemberEmailRes		= $objAdminMailer->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	  $varMemberEmail			= mysql_fetch_assoc($varMemberEmailRes);
	  $varEmail				= $varMemberEmail['Email'];
      $varDuplicateEmailCount = $objProfileDetail->getDuplicateEmails($varNewProfileDetails[$i][MatriId],$varEmail);
	  $varDuplicateEmailLink = ($varDuplicateEmailCount)? "<a href=# onClick=javascript:window.open('/admin/view-duplicate-emails.php?email=$varEmail&MatriId=$varMatriId','popup','width=500,height=620'); class='smalltxt boldtxt heading'>Duplicate Emails(".$varDuplicateEmailCount.")</a>&nbsp;&nbsp | &nbsp;&nbsp;" : '';
    // end //

	$varTotalTable .= '<tr class="memonlsbg4"><td class=smalltxt admintxt coslspan=4 style="padding:5px 5px 5px 5px;width:50%;" colspan="3"><input name="matriId'.$i.'" value="'.$varProfileMatriId.'" type="hidden"><input name="action'.$i.'" value="add" type="radio">&nbsp;&nbsp;<font class="text"><b>Add</b></font>&nbsp;&nbsp;<input name="action'.$i.'" value="reject" type="radio"><font class="text"><b>Reject</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="text"><label class=formlink1 align="left">'.$varDuplicateEmailLink.'<a href="'.$varModifyUrl.$varProfileMatriId.'" class="heading" target="_blank">Modify Profile</a></td></tr>';

	$varTotalTable .= '</table></td></tr><tr><td height="10"></td></tr>';
}
$varTotalTable .= '<tr><td><table border="0" cellpadding="3" cellspacing="3" width="400"><tbody><tr><td colspan="2"><br><input type="hidden" name="EditFrm" value="1"></td></tr></tbody></table><br><br></td></tr><tr><td><center><input type="submit" name="getnewprofile" class="button" value="Update this get new profile">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="stopprofile" class="button" value="Update and Stop"></center></td></tr></form>';


}?>
<html>
<head>
	<title><?=$confValues['PRODUCT']?> Matrimony - Matrimonies - Wedding - Matrimony Network</title>
	<link rel="stylesheet" href="<?=$confValues['ServerURL']?>/stylesheet/style.css">
	<script language="javascript" src="includes/admin.js"></script>
</head>
<body leftmargin="10" topmargin="0" marignright="10" marignbottom="0">
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="580">
<tr><td height="10"></td></tr>
	<tr>
		<td class="heading" style="padding-left:10px;">Modify Profile</td>
	</tr>
	<?php if($_REQUEST['tvprofile']=="yes"){?>
	<tr><td height="10"></td></tr>
	<tr >
		<td  align="right" class="mediumtxt" style="padding-right:15px;"><a href="<?=$confValues['SERVERURL']?>/admin/index.php?act=manage-users">Home</a></td>
	</tr>
	<?php }?>
	<tr><td height="10"></td></tr>	
<?php if((isset($_REQUEST['stopprofile'])) && (!isset($_REQUEST['id'])) ){?>
	<tr>
			<td class="smalltxt" style="padding-left:15px;">You have stopped the process to continue <a href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=shuffled_profile_modification">click here</a> or to home page <a href="<?=$confValues['ServerURL']?>/admin/index.php?act=manage-users">click here</a></td>
		</tr>
<?php }if($varErrorMessage!='') {?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><?=$varErrorMessage;?>.</td>
	</tr>
<?php }if(($varTotalRow==0)&&(!isset($_REQUEST['stopprofile']))&&($varRequestMatriId=='')){?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;">Profile Is Not In Queue For Modification To Go Home Page <a href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=manage-users">click here</a> </td>
	</tr>
<?}else{
	 echo $varTotalTable; 
}?>
</table>
</body>
<script language="JavaScript">

var milisec=0;
var seconds='<?=$varGivenTime?>';
document.frmUpdateProfile.counttime.value='<?=$varGivenTime?>';

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

	document.frmUpdateProfile.counttime.value=seconds;
	if(document.frmUpdateProfile.counttime.value == "0.0" || document.frmUpdateProfile.counttime.value == "0") {

		document.frmUpdateProfile.elapsedtime.value = 'yes';
		document.frmUpdateProfile.action="index.php?act=profile_modification&reddirect=yes&matid="+document.frmUpdateProfile.matriId.value+"&elpasetime="+document.frmUpdateProfile.elapsedtime.value+"&reportid="+document.frmUpdateProfile.reportid.value;
		document.frmUpdateProfile.submit();
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

//<!--
	function radio_button_checker(rc)
	{
		var rcc=rc;
		var radio_choice = false;
		var frmLoginDetails=document.frmUpdateProfile;

			for(i=0;i<rcc;i++)
			{
				var temp1="document.frmUpdateProfile.action"+i+"[0]";
				var temp2="document.frmUpdateProfile.action"+i+"[1]";
				var temp3="document.frmUpdateProfile.adminComment"+i;
				var j = i + 1;

				if (!(eval(temp1).checked) && !(eval(temp2).checked) )
				{
					alert("Please select add or reject for profile "+j);
					eval(temp1).focus();
					return false;
				}

				if ((eval(temp2).checked)&&(eval(temp3).value == "") )
				{
					alert("Please enter the reason for rejecting Profile "+j);
					eval(temp3).focus();
					return false;
				}
			}
return true;
}
//-->
</script>
</html>