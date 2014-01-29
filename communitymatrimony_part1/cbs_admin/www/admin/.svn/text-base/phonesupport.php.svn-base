<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//FILE INCLUDES
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
// Include the files //
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath.'/lib/clsPhoneSupport.php');

//OBJECT DECLARTION
$objSlave		= new PhoneSupport;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//GET Count of complaint on matriid
$argCondition		= " WHERE Request_Closed=0";
$varTotalRequest	= $objSlave->numOfRecords($varTable['PHONENOTWORK_LOG'], 'Id', $argCondition);

//UNSET OBJECTS
$objSlave->dbClose();
unset($objSlave);
?>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="15"></td></tr>
	<tr><td class="heading" style="padding-left:10px;"><?=$pageTitle?></td></tr>
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>Phone Not Working Count : <?=$varTotalRequest?></b></td></tr>
</table>
<br>
<form method="post" name="frmPhoneSupport" onSubmit="return multipleProfilePhoneSupport();">
<input type="hidden" name="multipleProfilePhoneSubmit" value="">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Phone Support</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr>
<td width="10"></td>
<td valign="top" class="mediumtxt"><b>No.of profiles to be displayed: </b>&nbsp;
<input name="norec" size="4" value="" type="text" class="inputtext">
&nbsp;&nbsp;<b>Start From </b>&nbsp;<input name="startLimit" size="4" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;
<input value="Submit" type="submit" name="phoneNotWorking" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>

<form method="post" name="frmSingleProfilePhoneSupport" onSubmit="return singleProfilePhoneSupport();">
<input type="hidden" name="singleProfilePhoneSubmit" value="">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Single Profile Phone Support</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id:&nbsp;
<input name="matriid" size="10" type="text" class="inputtext">&nbsp;
<input value="Submit" name="singphonesupport" type="submit" class="button">
</td></tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>

<form method="post" name="frmPhoneComplaintReq" onSubmit="return phoneComplaintRequest();">
<input type="hidden" name="phoneComplaintSubmit" value="">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Phone not working Request</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Complaint On:&nbsp;
<input name="complainton" size="10" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Complaint by:&nbsp;<input name="complaintby" size="10" type="text" class="inputtext">&nbsp;<br><br>
Reason:&nbsp;<select name="complaint_tag" class="inputtext">
	<option value=''>Select</option>
	<option value='1'>Phone number is not working</option>
	<option value='2'>Phone number has changed</option>
	<option value='3'>Member has got married</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input value="Submit" name="phonecomplaint" type="submit" class="button">
</td></tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>

<script language="javascript">
function multipleProfilePhoneSupport() {
	var funFormName	= document.frmPhoneSupport;
	if (funFormName.norec.value=="") {
		alert("please enter No.of profiles to be displayed");
		funFormName.norec.focus();
		return false;
	} else if (funFormName.startLimit.value=="") {
		alert("please enter Start From");
		funFormName.startLimit.focus();
		return false;
	} else {
		funFormName.action="index.php?act=phonesupportres";
		funFormName.multipleProfilePhoneSubmit.value="yes";
		funFormName.submit();
	}
}

function singleProfilePhoneSupport() {
	var funFormName	= document.frmSingleProfilePhoneSupport;
	if (funFormName.matriid.value=="") {
		alert("please enter Matrimony Id");
		funFormName.matriid.focus();
		return false;
	} else {
		funFormName.action="index.php?act=phonesupportres";
		funFormName.singleProfilePhoneSubmit.value="yes";
		funFormName.submit();
	}
}

function phoneComplaintRequest() {
	var funFormName	= document.frmPhoneComplaintReq;
	if (funFormName.complainton.value=="") {
		alert("please enter Complaint On");
		funFormName.complainton.focus();
		return false;
	} else if (funFormName.complaintby.value=="") {
		alert("please enter Complaint By");
		funFormName.complaintby.focus();
		return false;
	} else if (funFormName.complaint_tag.value=="") {
		alert("please select Reason");
		funFormName.complaint_tag.focus();
		return false;
	} else {
		funFormName.action="index.php?act=phonesupportres";
		funFormName.phoneComplaintSubmit.value="yes";
		funFormName.submit();
	}
}
</script>