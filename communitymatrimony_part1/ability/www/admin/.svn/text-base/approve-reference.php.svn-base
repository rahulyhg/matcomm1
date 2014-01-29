<?php
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
// Include the files //
include_once($varRootBasePath."/lib/clsMailManager.php");
include_once('includes/clsCommon.php');

//OBJECT DECLARTION
$objCommon		= new Common;
$objMailManager	= new MailManager;
$objCommon	->dbConnect('S', $varDbInfo['DATABASE']);

$objCommon->clsTable		= "addreference";
$objCommon->clsCountField	= "MatriId";
$objCommon->clsPrimary		= array('Validate_Status');
$objCommon->clsPrimaryValue	= array(0);
$varPendingCount			= $objCommon->getApprovalwaitingCount();
$objCommon->clsPrimaryValue	= array(3);
$varModifyPendingCount		= $objCommon->numOfResults();

//VARIABLE DECLARTION
if($_POST['addedReferenceSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-references&NumberProfile='.$_REQUEST[norec].'&startFrom='.$_REQUEST[startLimit].'&status=0&spage=yes"; </script>';
}
if($_POST['addedSingleReferenceSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-references&ID='.$_REQUEST[ID].'&type='.$_REQUEST[type].'&status=0&spage=yes"; </script>';
}
if($_POST['modifyReferenceSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-references&NumberProfile='.$_REQUEST[norec].'&startFrom='.$_REQUEST[startLimit].'&status=1&spage=yes"; </script>';
}
if($_POST['modifySingleReferenceSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-references&ID='.$_REQUEST[ID].'&type='.$_REQUEST[type].'&status=1&spage=yes"; </script>';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=$confPageValues['PAGETITLE']?></title>
<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
</head>
<body leftmargin="10" topmargin="0" marignright="10" marignbottom="0">
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="15"></td></tr>
	<tr>
		<td>
		<div style="padding-left:7px;padding-top:5px;padding-bottom:0px;"><font class="heading">Approve References</font></div>
		</td>
		<td class="mediumtxt"><div style="padding-left:7px;padding-top:5px;padding-bottom:0px;"><font color="red"><b>References waiting for approval count : <?php echo $varPendingCount;?></b></font></div></td>
		</tr>
</table>
<br>
<form method="post" name="frmReferences" target="_blank">
<input type="hidden"  name="nextPage" value="yes">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Validate Multiple References</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">
Enter Number of profiles to be display and click 'Validate' to approve the references available in for addition. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top" class="mediumtxt"><b>No.of references to be displayed: </b>&nbsp;
<input name="norec" size="4" value="" type="text" class="inputtext">
&nbsp;&nbsp;<b>Start From </b>&nbsp;<input name="startLimit" size="4" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="submit" name="addedReferenceSubmit" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>


<form method="post" name="frmSingleReference" target="_blank" onSubmit="return funValidateSingleReference();">
<input type="hidden"  name="nextPage" value="yes">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Single Reference Validation</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id/UserName :&nbsp;
<input name="ID" size="10" type="text" class="inputtext">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName
<input value="Validate" type="submit" name="addedSingleReferenceSubmit" class="button">
<input value="Clear" type="reset" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>

<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="525">
	<tr>
		<td class="mediumtxt"><div style="padding-left:210px;padding-top:5px;padding-bottom:0px;"><font color="red"><b>Modified References waiting for approval count : <?php echo $varModifyPendingCount;?></b></font></div></td>
		</tr>
</table>
<br>
<form method="post" name="frmModifyReferences" target="_blank">
<input type="hidden"  name="nextPage" value="yes">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Validate Modified Multiple References</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">
Enter Number of profiles to be display and click 'Validate' to approve the references available in for addition. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top" class="mediumtxt"><b>No.of references to be displayed: </b>&nbsp;
<input name="norec" size="4" value="" type="text" class="inputtext">
&nbsp;&nbsp;<b>Start From </b>&nbsp;<input name="startLimit" size="4" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="submit" name="modifyReferenceSubmit" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>


<form method="post" name="frmModifySingleReference" target="_blank" onSubmit="return funValidateModifySingleReference();">
<input type="hidden"  name="nextPage" value="yes">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" bgcolor="#FFFFFF" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Modify Single Reference Validation</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id/UserName :&nbsp;
<input name="ID" size="10" type="text" class="inputtext">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName
<input value="Validate" type="submit" name="modifySingleReferenceSubmit" class="button">
<input value="Clear" type="reset" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>
<script language="javascript">
function funcSubmit(argFormName) 
{
	argFormName.submit();
}

function funValidateSingleReference()
{
	var funFormName	= document.frmSingleReference;
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

function funValidateModifySingleReference()
{
	var funFormName	= document.frmModifySingleReference;
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
}//funValidateModifySingleReference

</script>

</table>
</body>
</html>