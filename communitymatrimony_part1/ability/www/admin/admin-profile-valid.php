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
include_once($varRootBasePath.'/lib/clsRegister.php');

//OBJECT DECLARTION
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//getting unvalidated profile im memberinfo
$argCondition				= "WHERE Publish=0";
$varNoOfRecords				= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);

//getting unvalidated profile im memberinfo
$argCondition				= '';
$varUpdatedNoOfRecords		= $objSlave->numOfRecords($varTable['MEMBERUPDATEDINFO'],'MatriId',$argCondition);

$objSlave->dbClose();


if($_POST['addedProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-profiles&NumberProfile='.$_REQUEST[norec].'&startFrom='.$_REQUEST[startLimit].'"; </script>';
}
if($_POST['modifyProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=update-profile&NumberProfile='.$_REQUEST[norec].'&startFrom='.$_REQUEST[startLimit].'"; </script>';
}
if($_POST['addedSingleProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-profiles&ID='.$_REQUEST[ID].'&type='.$_REQUEST[type].'"; </script>';
}
if($_POST['modifySingleProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=update-profile&ID='.$_REQUEST[ID].'&type='.$_REQUEST[type].'"; </script>';
}
?>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="15"></td></tr>
	<tr><td class="heading" style="padding-left:10px;">Current Validate Profiles</td></tr>
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>New Profiles Pending Count : <?=$varNoOfRecords?></b></td></tr>
	<tr><td class="mediumtxt" align="right"  style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>Modify Profiles Pending Count : <?=$varUpdatedNoOfRecords?></b></font></div></td></tr>
</table>
<br>
<form method="post" name="frmAddProfiles" target="_blank">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Add </td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10" height="25"></td>
<td align="left" class="smalltxt">
Enter Number of profiles to be display and click 'Validate' to validate the profiles available in for addition. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top" class="mediumtxt"><b>No.of profiles to be displayed: </b>&nbsp;
<input name="norec" size="4" value="" type="text" class="inputtext">
&nbsp;&nbsp;<b>Start From </b>&nbsp;<input name="startLimit" size="4" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="submit" name="addedProfileSubmit" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>


<form method="post" name="frmModifyProfiles" target="_blank">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Modify </td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10" height="25"></td>
<td align="left" class="smalltxt">
Enter Number of profiles to be display and click 'Validate' to validate the profiles available in  for modification. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top" class="mediumtxt"><b>No.of profiles to be displayed: </b>&nbsp;
<input name="norec" size="4" type="text" class="inputtext">
&nbsp;&nbsp;&nbsp;<b>Start From </b>&nbsp;<input name="startLimit" size="4" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="submit" name="modifyProfileSubmit" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>

<form method="post" name="frmSingleProfile" target="_blank" onSubmit="return funValidateSingleProfile();">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Single Profile Validation</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id/UserName :&nbsp;
<input name="ID" size="10" type="text" class="inputtext">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName
&nbsp;<input value="Validate" type="submit" name="addedSingleProfileSubmit" class="button">
<input value="Clear" type="reset" class="button">
</td></tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>

<br>
<form method="post" name="frmModifySingleProfile" target="_blank" onSubmit="return funValidateModifySingleProfile();" style="padding:0px;margin:0px;">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Single Profile Modification</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id/UserName :&nbsp;
<input name="ID" size="10" type="text" class="inputtext">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName
&nbsp;<input value="Validate" type="submit" name="modifySingleProfileSubmit" class="button">
<input value="Clear" type="reset" class="button">
</td></tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>
<script language="javascript">
function funcSubmit(argFormName) 
{
	argFormName.submit();
}
function funValidateModifySingleProfile()
{
	var funFormName	= document.frmModifySingleProfile;
	if (funFormName.ID.value=="")
	{
		alert("please enter Username / Matrimony Id");
		funFormName.ID.focus();
		return false;
	}//if
	if (!(funFormName.type[0].checked==true || funFormName.type[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		funFormName.type[0].focus();
		return false;
	}//if
	return true;
}//funValidateModifySingleProfile

function funValidateSingleProfile()
{
	var funFormName	= document.frmSingleProfile;
	if (funFormName.ID.value=="")
	{
		alert("please enter Username / Matrimony Id");
		funFormName.ID.focus();
		return false;
	}//if
	if (!(funFormName.type[0].checked==true || funFormName.type[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		funFormName.type[0].focus();
		return false;
	}//if
	return true;
}//funValidateSingleProfile
</script>
