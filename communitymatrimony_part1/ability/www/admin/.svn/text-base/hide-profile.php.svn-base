<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//OBJECT DECLARTION
$objMaster		= new MemcacheDB;
$objMailManager = new MailManager;

//DB CONNECTION
$objMailManager->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLERATION
$varUsernameId	= $_REQUEST['username'];
$varPrimary		= $_REQUEST['primary'];
$varCurrentDate = date('y-m-d H:i:s');

$varProfileStatus = array('1'=>'Opened','2'=>'Hided','3'=>'Suspended','4'=>'Rejected','Delete'=>'Deleted');

if ($_REQUEST["profileStatusSubmit"]=="yes")
{
	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name='".$varUsernameId."'";
		$argFields 				= array('MatriId','Publish');
		$varSelectMatriIdRes	= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];
		$varStatus				= $varSelectMatriId["Publish"];
	}//if
	else
	{
		//SETING MEMCACHE KEY
		$varProfileMCKey		= 'ProfileInfo_'.$varUsernameId;

		$argCondition			= "WHERE MatriId='".$varUsernameId."'";

		$argFields 				= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
		$varSelectMatriId		= $objMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);
		$varStatus				= $varSelectMatriId["Publish"];
		$varMatriId				= $varUsernameId;
	}//

}//if

if($_REQUEST["hideProfileSubmit"] == "yes")
{
	$varnotifyCustomer			= $_REQUEST["notifyCustomer"];
	$varStatus					= $_REQUEST['status'];

	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name='".$varUsernameId."'";
		$argFields 				= array('MatriId');
		$varSelectMatriIdRes	= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];
	}//if
	else
	{
		$varMatriId				= $varUsernameId;
	}//

	//SETING MEMCACHE KEY
	$varProfileMCKey		= 'ProfileInfo_'.$varMatriId;

	//get folder name
	$varFolderName			= $objMailManager->getFolderName($varMatriId);
	$arrDomainDtls			= $objMailManager->getDomainDetails($varMatriId);

	$argCondition				= "WHERE MatriId='".$varMatriId."'";

	//SELECT EMAIL
	if ($varnotifyCustomer=="yes")
	{
		$argFields 				= array('User_Name','Email');
		$varSelectUserNameRes	= $objMailManager->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectUserName		= mysql_fetch_assoc($varSelectUserNameRes);
		$varUserName			= $varSelectUserName['User_Name'];
		$varEmail				= $varSelectUserName['Email'];
	}//if
	
	$varNoOfRecords				= $objMailManager->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);

	if($varNoOfRecords == 1)
	{
		$varCommentwithAdmin		= '--'.$varCurrentDate.'--'.$_REQUEST['adminLogin'].'--'.addslashes(strip_tags(trim($_REQUEST['comments'])));	
		
		//SELECT E-Mail to Notify customer
		if ($varnotifyCustomer=="yes")
		{
			if($varStatus == 0 || $varStatus == '') {
				$varSubject				= "Your Profile has been inactivated From ".$arrDomainDtls['PRODUCTNAME']." Matrimony"; 
			} else {
				$varSubject				= "Your Profile has been ".$varProfileStatus[$varStatus]." From ".$arrDomainDtls['PRODUCTNAME']." Matrimony"; 
			}
			$varComments	= 'Dear <b>'.$varMatriId.'</b>,<br><br>';
			$varComments	.= "Your Profile has been inactivated From ".$arrDomainDtls['PRODUCTNAME']."Matrimony.Com<br><br>";
			$varComments	.= '<b>Admin comments</b> :';
			$varComments	.= $_REQUEST["comments"];
			$varComments	.= '<br><br>Thanking you, <br>Team - '.$arrDomainDtls['PRODUCTNAME'].'Matrimony.Com';
			$retValue		= $objMailManager->sendNotifyEmail($varEmail,$varComments,$varSubject,$varMatriId);
		}//if

		if($varStatus != "Delete")
		{
			$argCondition			= "MatriId='".$varMatriId."'";
			$argFields				= array("Publish");
			$argFieldsValues		= array("'".$varStatus."'");
			$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

			$varResult				= "Status updated to ".$varProfileStatus[$varStatus];

			//INSERT SUPPORT COMMENTS HERE
			$argCondition			= "WHERE MatriId='".$varMatriId."'";
			$argFields 				= array('Support_Comments');
			$varadminCommentsRes	= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$varadminComments		= mysql_fetch_assoc($varadminCommentsRes);
			$varComment				= $varadminComments['Support_Comments'].$varCommentwithAdmin;
			$argFieldsValues		= array("'".$varComment."'");
			$argCondition			= "MatriId='".$varMatriId."'";
			$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);
		}
		else
		{
			#-------------------------------------------------------------------------------------------------
			//SELECT MEMBERLOGIN INFO
			$argFields 				= array('Email','Password','User_Name');
			$varSelectLoginInfoRes	= $objMailManager->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
			$varSelectLoginInfo		= mysql_fetch_assoc($varSelectLoginInfoRes);

			#--------------------------------------------------------------------------------------------------
			//SELECT MEMBERBASIC INFO
			$argFields 				= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
			$varSelectBasicInfo	= $objMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);

			if ($varSelectBasicInfo['Country']==98 || $varSelectBasicInfo['Country']==222) { $varResidingState = $varSelectBasicInfo['Residing_State'];} //if
			else {$varResidingState = $varSelectBasicInfo['Residing_Area'];} 

			if($varSelectBasicInfo["Country"] == 98) { $varCityValue = $varSelectBasicInfo["Residing_District"]; } else { $varCityValue = $varSelectBasicInfo["Residing_City"]; }

			#---------------------------------------------------------------------------------------------------
			//SELECT FAMILY INFO
			$argFields 				= array('Family_Value','Family_Type','Family_Status');
			$varSelectFamilyInfoRes	= $objMailManager->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
			$varSelectFamilyInfo	= mysql_fetch_assoc($varSelectFamilyInfoRes);
			
			#--------------------------------------------------------------------------------------------------
			//INSERT ALL SELECTED TO memberdeletedinfo TABLE
			$argFields 				= array('MatriId','Email','Password','Date_Created','Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_Tongue','Residing_State','Residing_City','About_Myself','Profile_Created_By','Family_Value','Family_Type','Family_Status','Deleted_Reason','Deleted_Comments','Date_Deleted','User_Name');
			$argFieldsValues		= array("'".$varMatriId."'","'".$varSelectLoginInfo["Email"]."'","'".$varSelectLoginInfo["Password"]."'","'".$varSelectBasicInfo["Date_Created"]."'","'".$varSelectBasicInfo["Name"]."'","'".$varSelectBasicInfo["Age"]."'","'".$varSelectBasicInfo["Dob"]."'","'".$varSelectBasicInfo["Gender"]."'","'".$varSelectBasicInfo["Marital_Status"]."'","'".$varSelectBasicInfo["No_Of_Children"]."'","'".$varSelectBasicInfo["Children_Living_Status"]."'","'".$varSelectBasicInfo["Religion"]."'","'".$varSelectBasicInfo["Country"]."'","'".$varSelectBasicInfo["Resident_Status"]."'","'".$varSelectBasicInfo["Citizenship"]."'","'".$varSelectBasicInfo["Employed_In"]."'","'".$varSelectBasicInfo["Height"]."'","'".$varSelectBasicInfo["Height_Unit"]."'","'".$varSelectBasicInfo["Physical_Status"]."'","'".$varSelectBasicInfo["Education_Category"]."'","'".$varSelectBasicInfo["Education_Detail"]."'","'".$varSelectBasicInfo["Occupation"]."'","'".$varSelectBasicInfo["Occupation_Detail"]."'","'".$varSelectBasicInfo["Mother_TongueId"]."'","'".$varResidingState."'","'".$varCityValue."'","'".$varSelectBasicInfo["About_Myself"]."'","'".$varSelectBasicInfo["Profile_Created_By"]."'","'".$varSelectFamilyInfo["Family_Value"]."'","'".$varSelectFamilyInfo["Family_Type"]."'","'".$varSelectFamilyInfo["Family_Status"]."'","'".$_REQUEST["reason"]."'","'".$varAllComments."'","'".$varCurrentDate."'","'".$varSelectLoginInfo["User_Name"]."'");
			$varInsertId			= $objMaster->insert($varTable['MEMBERDELETEDINFO'],$argFields,$argFieldsValues);

			#------------------------------------------------------------------------------------------------
			$argCondition			= "MatriId='".$varMatriId."'";
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
			$argCondition			= "SenderId='".$varMatriId."'";
			$objMaster->delete($varTable['REQUESTINFOSENT'],$argCondition);

			//DELETE requestinforeceived INFO
			$argCondition			= "ReceiverId='".$varMatriId."'";
			$objMaster->delete($varTable['REQUESTINFORECEIVED'],$argCondition);

			$varFormResult="You have successfully deleted your profile. Thank you for being a member of ".$arrDomainDtls['PRODUCTNAME']." Matrimony. We wish you all the best.";
		}
	}
	else
	{
		$varResult = 'This '.str_replace("_"," ",$varPrimary).' doesn\'t exist.';
	}
	$objMaster->dbClose();
}

$objMailManager->dbClose();
?>
<script language="javascript">
function funValidate()
{
	var frmName = document.hideProfile;
	if(frmName.username.value == "")
	{
		alert("Please enter Username / Matrimony Id");
		frmName.username.focus();
		return false;
	}//if

	if (!(frmName.primary[0].checked==true || frmName.primary[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		frmName.primary[0].focus();
		return false;
	}//if

	if(frmName.status.value == "")
	{
		alert("Please select status");
		frmName.status.focus();
		return false;
	}

	if(frmName.status.value == 4)
	{
		alert("Please enter comments for reject profile");
		frmName.comments.focus();
		return false;
	}

	if(frmName.status.value == "Delete")
	{
		result = confirm("Do you want to delete this profile");
		if(result == "true")
		{
			//frmName.submit();
			return true;
		}
	}//if
	return true;

}//funValidate
</script>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="542" align="left">
	<tr><td class="heading" style="padding-left:10px;padding-top:10px;">Hide / Open / Suspend profiles</td></tr>
	<tr><td height="10"></td></tr>
	<?php if ($_REQUEST["hideProfileSubmit"]=="yes")
	{ echo'<tr><td class="errorMsg">&nbsp;'.$varResult.'</td></tr><tr><td height="10"></td></tr>'; } ?>
	<tr><td>
	<table border="0" cellspacing="0" cellpadding="0" width="522" align="center">
	<form name="hideProfile" action="index.php?act=hide-profile" method="post" onSubmit=" return funValidate();">
	<input type="hidden" name="hideProfileSubmit" value="yes">
	<tr><td height="10" colspan="3"></td></tr>
	<tr class="tabpadding">
		<td width="30%" class="textsmallbolda">Username *</td>
		<td width="25%"><input class="smalltxt" type="text" name="username" size="20" value="<?=$varUsernameId;?>"></td>
		<td width="45%" class="smalltxt" align="left"><input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>> Username<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>> Matrimony Id</td>
	</tr>
	<tr class="tabpadding">
		<td class="textsmallbolda">Status *</td>
		<td colspan="2">
		<select name="status" class="combobox" style="width:136px;font-family: Verdana, arial, sans-serif;font-size : 8pt">
		<option value="">- Select status -</option>
		<option value="1" <?=$varStatus==1 ? "selected" : "";?>>Open</option>
		<option value="2" <?=$varStatus==2 ? "selected" : "";?>>Hide</option>
		<option value="3" <?=$varStatus==3 ? "selected" : "";?>>Suspend</option>
		<option value="4" <?=$varStatus==4 ? "selected" : "";?>>Reject</option>
		<option value="0" <?if ($varStatus=="0" ) { echo "selected";}//if ?>>Inactive</option>
		<option value="Delete">Ignore</option>
		</select>
		</td>
	</tr>
	<tr class="tabpadding">
		<td class="textsmallbolda">Comments</td>
		<td colspan="2"><textarea cols="30" rows="6" name="comments"></textarea>
		</td>
	</tr>
	<tr class="tabpadding">
		<td class="textsmallbolda">Name of the Person doing the change</td>
		<td colspan="2"><input type="text" name="adminLogin" value="">
		</td>
	</tr>
	<tr class="tabpadding">
		<td></td>
		<td colspan="2" class="smalltxt"><input type="checkbox" name="notifyCustomer" class="smalltxt" value="yes" align="absmiddle"> <b>Notify customer</b> <input type="submit" value="Submit" class="button" align="absmiddle"></td>
	</tr>
	<tr><td height="10" colspan="3"></td></tr>
	</form>
	</table>
	</td></tr>
	<tr><td height="10"></td></tr>
</table>
<br>