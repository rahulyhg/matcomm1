<?php
//FILE INCLUDES
include_once('includes/clsCommon.php');	
include_once('../mailer/includes/clsMailManager.php');
include_once('../registration/includes/registration-array-values.php');

//OBJECT DECLARTION
$objCommon		= new Common;
$objMailManager	= new MailManager;

if($_POST['addedProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-exisiting-profiles&NumberProfile='.$_REQUEST[norec].'&startFrom='.$_REQUEST[startLimit].'"; </script>';
}
/*if($_POST['modifyProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=update-profile&NumberProfile='.$_REQUEST[norec].'&startFrom='.$_REQUEST[startLimit].'"; </script>';
}*/
if($_POST['addedSingleProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-exisiting-profiles&ID='.$_REQUEST[ID].'&type='.$_REQUEST[type].'"; </script>';
}
/*if($_POST['modifySingleProfileSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=update-profile&ID='.$_REQUEST[ID].'&type='.$_REQUEST[type].'"; </script>';
}*/

?>

<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="580">
	<tr>
		<td><div style="padding-left:7px;padding-top:5px;padding-bottom:0px;"><font class="heading">Exisiting Validate Profiles</font></div></td>
		<td class="smalltxt"><div style="padding-left:7px;padding-top:5px;padding-bottom:0px;"><font color="red"><b>Existing Profiles Pending Count : <?=$objCommon->numOfOldProfilePending();?></b></font></div></td>
		</tr>
</table>
<br>
<form method="post" name="frmAddProfiles" target="_blank" onSubmit="return funValidateAddProfiles();">
<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="580">
<tr class="myprofsubbg"><td valign="top" colspan="2" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="grtxtbold2">Add </td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">
Enter Number of profiles to be display and click 'Validate' to validate the profiles available in for addition. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top">
<font face="Arial" size="2"><b>No.of profiles to be displayed: </b></font>&nbsp;
<input name="norec" size="4" value="" type="text" class="smalltxt">
&nbsp;&nbsp;<font face="Arial" size="2"><b>Start From </b></font>&nbsp;<input name="startLimit" size="4" type="text" class="smalltxt">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="submit" name="addedProfileSubmit" class="smalltxt">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>


<!-- <form method="post" name="frmModifyProfiles" target="_blank" onSubmit="return funValidateModifyProfiles();">
<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="580">
<tr class="myprofsubbg"><td valign="top" colspan="2" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="grtxtbold2">Modify </td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">
Enter Number of profiles to be display and click 'Validate' to validate the profiles available in  for modification. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top">
<font face="Arial" size="2"><b>No.of profiles to be displayed: </b></font>&nbsp;

<input name="norec" size="4" type="text" class="smalltxt">
&nbsp;&nbsp;&nbsp;<font face="Arial" size="2"><b>Start From </b></font>&nbsp;<input name="startLimit" size="4" type="text" class="smalltxt">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="submit" name="modifyProfileSubmit" class="smalltxt">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form> -->

<form method="post" name="frmSingleProfile" target="_blank" onSubmit="return funValidateSingleProfile();">
<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="580">
<tr class="myprofsubbg"><td valign="top" colspan="2" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="grtxtbold2">Single Profile Validation</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id/UserName :&nbsp;
<input name="ID" size="10" type="text" class="smalltxt">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName
<input value="Validate" type="submit" name="addedSingleProfileSubmit" class="smalltxt">
<input value="Clear" type="reset" class="smalltxt">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>

<!-- <br>
<form method="post" name="frmModifySingleProfile" target="_blank" onSubmit="return funValidateModifySingleProfile();">
<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="580">
<tr class="myprofsubbg"><td valign="top" colspan="2" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="grtxtbold2">Single Profile Modification</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id/UserName :&nbsp;
<input name="ID" size="10" type="text" class="smalltxt">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName
<input value="Validate" type="submit" name="modifySingleProfileSubmit" class="smalltxt">
<input value="Clear" type="reset" class="smalltxt">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form> -->
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
