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
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//OBJECT DECLARTION
$objSlave	= new MemcacheDB;

//VARIABLE DECLERATION
$varUsernameId	= $_REQUEST['username'];
$varPrimary		= $_REQUEST['primary'];

if ($_REQUEST["profileStatusSubmit"]=="yes")
{
	//DB CONNECTION
	$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name='".$varUsernameId."'";
		$argFields 				= array('MatriId','Publish');
		$varSelectMatriIdRes	= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
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
		$varSelectMatriId	= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);
		$varStatus				= $varSelectMatriId["Publish"];
		$varMatriId				= $varUsernameId;
	}//
	
	$argCondition		= "WHERE MatriId='".$varMatriId."'";
	$varNoOfRecords		= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);

	if ($varNoOfRecords==0)	{ $varResult = 'This '.str_replace("_"," ",$varPrimary).' doesn\'t exist.';	}//if

	$objSlave->dbClose();

}//if
?>
<script language="javascript">
function funValidate()
{
	var frmName = document.frmViewProfile;
	if (frmName.username.value=="")
	{
		alert("Please enter  Username / Matrimony Id");
		frmName.username.focus();
		return false;
	}//if
	if (!(frmName.primary[0].checked==true || frmName.primary[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		frmName.primary[0].focus();
		return false;
	}//if
	return true;
}//funValidate
</script>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="542">
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">Hide / Open / Suspend profiles</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
	<?php if ($_REQUEST["profileStatusSubmit"]=="yes") { echo'<tr><td class="errorMsg" colspan="2">'.$varResult.'</td></tr><tr><td height="5" colspan="2"></td></tr>'; } ?>
	<form name="profileStatus" action="index.php" method="post" onSubmit=" return funValidate();">
	<input type="hidden" name="profileStatusSubmit" value="yes">
	<input type="hidden" name="act" value="profile-status">
	<input type="hidden" name="status" value="<?=$varStatus?>">
	<tr>
		<td class="smalltxt" width="30%" style="padding-left:15px;"><b>MatrimonyId/UserName</b>&nbsp;</td>
		<td width="70%" class="smalltxt"><input type=text name="username" value="<?=$varUsernameId;?>" size="15" class="inputtext">&nbsp;<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>>&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>>&nbsp;UserName&nbsp;&nbsp;&nbsp;&nbsp;<input type="Submit" Value="Submit" class="button"></td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
</table>
<?php if ($varNoOfRecords==1) { ?>
	<script language="javascript">
		document.profileStatus.act.value="hide-profile";
		document.profileStatus.submit();
	</script>
<?; }//if ?>
<br>