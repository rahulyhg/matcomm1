<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//OBJECT DECLARTION
$objSlave	= new MemcacheDB;
$objMaster	= new MemcacheDB;

//VARIABLE DECLERATION
$varUsernameId	= $_REQUEST['username'];
$varPrimary		= $_REQUEST['primary'];

if($_REQUEST["phoneStatusConfirm"]=="yes") {
	$varMatriId		= $_REQUEST['matriid'];
	
	//SETING MEMCACHE KEY
	$varProfileMCKey= 'ProfileInfo_'.$varMatriId;

	//DB CONNECTION
	$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

	//Update Phone_verified flag 
	$argCondition			= "MatriId=".$objMaster->doEscapeString($varMatriId,$objMaster);
	$argFields 				= array('Phone_Verified');
	$argFieldsValues		= array(0);
	$varSelectMatriIdRes	= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

	//MEMBERTOOL LOGIN
	$varType  = 1;
	$varField = 0;	
	$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
	$varphnworkCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';	escapeexec($varphnworkCmd,$varlogFile);
	
	//DB CLOSE
	$objMaster->dbClose();

	$varResult	= 'phone status reset successfully';

} else if ($_REQUEST["phoneStatusSubmit"]=="yes") {
	//DB CONNECTION
	$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name=".$objSlave->doEscapeString($varUsernameId,$objSlave);
		$argFields 				= array('MatriId','Phone_Verified','Contact_Phone','Contact_Mobile');
		$varSelectMatriIdRes	= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];
		$varStatus				= $varSelectMatriId["Phone_Verified"];
		$varContactPhone		= $varSelectMatriId["Contact_Phone"];
		$varMobilePhone			= $varSelectMatriId["Contact_Mobile"];
		$varUserName			= $varUsernameId;
	}//if
	else
	{
		$argCondition			= "WHERE MatriId="$objSlave->doEscapeString($varUsernameId,$objSlave);
		//SETING MEMCACHE KEY
		$varProfileMCKey= 'ProfileInfo_'.$varUsernameId;

		$argFields 				= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
		$varSelectMatriId		= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);
		$varStatus				= $varSelectMatriId["Phone_Verified"];
		$varContactPhone		= $varSelectMatriId["Contact_Phone"];
		$varMobilePhone			= $varSelectMatriId["Contact_Mobile"];
		$varMatriId				= $varUsernameId;
		$varUserName			= $varSelectMatriId["User_Name"];
	}//
	
	$argCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave);
	$varNoOfRecords		= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);

	if ($varNoOfRecords==0)	{ 
		$varResult	= 'This '.str_replace("_"," ",$varPrimary).' doesn\'t exist.';	
	} else {
		$varConfirm	= 1;
	}

	$objSlave->dbClose();

}//if

if($varConfirm == 1) { ?>
	<script language="javascript">
	function funConfirm()
	{
		document.phoneStatusConfirmFrm.action = 'index.php';
		document.phoneStatusConfirmFrm.submit();
		return true;
	}//funValidate
	</script>

	<table border="0" cellpadding="0" cellspacing="0" align="left" width="542">
		<tr><td height="10" colspan="2"></td></tr>
		<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">Phone Not Working</td></tr>
		<tr><td height="10" colspan="2"></td></tr>
		<tr>
			<td class="smalltxt" width="30%" style="padding-left:15px;"><b>UserName : </b>&nbsp;</td>
			<td width="70%" class="smalltxt"><?=$varUserName?></td>
		</tr>
		<tr><td height="5" colspan="2"></td></tr>
		<tr>
			<td class="smalltxt" width="30%" style="padding-left:15px;"><b>Matri Id : </b>&nbsp;</td>
			<td width="70%" class="smalltxt"><?=$varMatriId?></td>
		</tr>
		<?if($varContactPhone != '') {?>
		<tr><td height="5" colspan="2"></td></tr>
		<tr>
			<td class="smalltxt" width="30%" style="padding-left:15px;"><b>Phone No : </b>&nbsp;</td>
			<td width="70%" class="smalltxt"><?=$varContactPhone?></td>
		</tr>
		<? } if($varMobilePhone != '') {?>
		<tr><td height="5" colspan="2"></td></tr>
		<tr>
			<td class="smalltxt" width="30%" style="padding-left:15px;"><b>Mobile No : </b>&nbsp;</td>
			<td width="70%" class="smalltxt"><?=$varMobilePhone?></td>
		</tr>
		<? } ?>
		<tr><td height="20" colspan="2"></td></tr>
		<form name="phoneStatusConfirmFrm" method="post">
		<input type="hidden" name="matriid" value="<?=$varMatriId?>">
		<input type="hidden" name="phoneStatusConfirm" value="yes">
		<input type="hidden" name="act" value="phonenotwork">
		<tr><td colspan="2" class="smalltxt" style="padding-left:15px;">Are you sure to reset phone number? <a href="#" onClick="funConfirm();"><font color="#FF0000">Click Here</font></a></form></td></tr>
		<tr><td height="20" colspan="2"></td></tr>
	</table>
	
<? } else { ?>
<script language="javascript">
function funValidate()
{
	var frmName = document.phoneStatus;
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
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">Phone Not Working</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
	<?php if ($_REQUEST["phoneStatusSubmit"]=="yes" || $_REQUEST["phoneStatusConfirm"]=="yes") { echo'<tr><td  style="padding-left:15px;" class="smalltxt" class="errorMsg" colspan="2">'.$varResult.'</td></tr><tr><td height="5" colspan="2"></td></tr>'; } ?>
	<form name="phoneStatus" action="index.php" method="post" onSubmit=" return funValidate();">
	<input type="hidden" name="phoneStatusSubmit" value="yes">
	<input type="hidden" name="act" value="phonenotwork">
	<tr>
		<td class="smalltxt" width="30%" style="padding-left:15px;"><b>MatrimonyId/UserName</b>&nbsp;</td>
		<td width="70%" class="smalltxt"><input type=text name="username" value="<?=$varUsernameId;?>" size="15" class="inputtext">&nbsp;<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>>&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>>&nbsp;UserName&nbsp;&nbsp;&nbsp;&nbsp;<input type="Submit" Value="Submit" class="button"></td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
</table>
<br>
<? } ?>