<?php
#================================================================================================================
# Author 		: S.Rohini
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================
//FILE INCLUDES
include_once('includes/clsCommon.php');

//OBJECT DECLARTION
$objCommon = new Common;

//CONTROL 
if ($_POST["frmAddPhotoSubmit"]=="yes")
{

	//VARIABLE DECLARATION
	$varUserName 				= $_REQUEST["matrimonyId"];
	$vartype					= $_REQUEST["type"];
	
	$objCommon->clsTable		= "memberlogininfo";
	$objCommon->clsFields 		= array('MatriId','Email');
	
	if($vartype==2) 
	{
		$objCommon->clsPrimary      = array('User_Name');
		$objCommon->clsPrimaryValue = array($varUserName);
		$varSelectUserName			= $objCommon->selectinfo();
		$varMatriId = $varSelectUserName['MatriId'];
	}
	else
	{
		$objCommon->clsPrimary      = array('MatriId');
		$objCommon->clsPrimaryValue = array($varUserName);
		$varSelectUserName			= $objCommon->selectinfo();
		$varMatriId = $varUserName;
	}

	$objCommon->clsCountField	= 'User_Name';
	$varRecordsNumber			= $objCommon->numOfResults();

	if($varRecordsNumber==0)
	{
		$varDisplayMsg = '<tr><td valign="middle" class="heading">Add Photo</td></tr><tr><td height="10" ></td></tr><tr><td><table width="745" border="0" cellspacing="0" cellpadding="0" align="left" class="formborderclr" valign="top"><tr><td class="errorMsg" height="40" valign="middle" align="center">No members match with your selected criteria. <a href="javascript:history.back();" class="formlink"><b>Click here to try again</b></a></td></tr><tr><td height="10"></td></tr></table></td></tr>';

	}
	/*else 
	{
		include_once('view.php');
	}*/
}
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="745">
	<?php if ($_POST["frmAddPhotoSubmit"]!="yes") { ?>
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">Add Photo</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
	<? } if ($_POST["frmAddPhotoSubmit"]!="yes") { ?>
	<form name="frmAddPhoto" method="post" onSubmit="return funViewProfileId();">
	<input type="hidden" name="frmAddPhotoSubmit" value="yes">
	<input type="hidden" name="MatriId" value="">
	<tr>
		<td class="smalltxt" width="30%" style="padding-left:15px;"><b>MatrimonyId/UserName</b>&nbsp;</td>
		<td width="70%" class="smalltxt"><input type=text name="matrimonyId" size="15" class="inputtext">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button"></td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
	<?php 
	} 
	if(($_POST["frmAddPhotoSubmit"]=="yes") && ($varRecordsNumber==0)) { echo $varDisplayMsg; }
	if(($_POST["frmAddPhotoSubmit"]=="yes") && ($varRecordsNumber!=0)) { 
	//$varMatriId = $objCommon->getUserId($_REQUEST["matrimonyId"]);
		if($vartype==2) {$varMatriId = $objCommon->getUserId($varUserName);}
		else{ $varMatriId= $varUserName; }
		
	echo '<script language="javascript">document.location.href="index.php?act=view&MatriId='.$varMatriId.'"</script>';
	}
	?>
</table>
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmAddPhoto;
	if (frmName.matrimonyId.value=="")
	{
		alert("Please enter  Username / Matrimony Id");
		frmName.matrimonyId.focus();
		return false;
	}//if
	if (!(frmName.type[0].checked==true || frmName.type[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		frmName.type[0].focus();
		return false;
	}//if

	return true;
}//funViewProfileId
</script>