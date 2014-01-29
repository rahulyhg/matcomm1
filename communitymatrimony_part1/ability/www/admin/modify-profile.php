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

//CONTROL STATEMENT
if ($_POST["frmModifyProfileSubmit"]=="yes")
{
	$varUsername 				= $_REQUEST["username"];
	$varPrimary					= $_REQUEST["primary"];

	
	//DB CONNECTION
	$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
	
	//IF USERNAME COMES GET MatriId
	if ($varPrimary=="User_Name")
	{
		$argCondition		= "WHERE User_Name='".$varUsername."'";
		$varNoOfResults		= $objSlave->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$argCondition);

		if ($varNoOfResults > 0)
		{
			$argFields 				= array('MatriId');
			$varSelectPrimaryRes	= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$varSelectPrimary		= mysql_fetch_assoc($varSelectPrimaryRes);
			$varMatriId			= $varSelectPrimary["MatriId"];
		}//if
	}//if
	else
	{
		$varMatriId			= $varUsername;
		$argCondition		= "WHERE MatriId='".$varMatriId."'";
		$varNoOfResults		= $objSlave->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$argCondition);
	}

	$objSlave->dbClose();

	if ($varNoOfResults=='1')
	{
		echo "<script language=\"javascript\">document.location.href='index.php?act=edit-profile&MatriId=".$varMatriId."'</script>";
	}//if
}//if
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">
	<tr><td height="15"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">Modify / Edit profile</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
	<?php if ($_POST["frmModifyProfileSubmit"]=="yes" && $varNoOfResults==0) { ?>
	<tr><td align="center" class="errorMsg" colspan="2">No Records found</td></tr><tr><td height="10" colspan="2"></td></tr>
	<?php }//if ?>
	<tr>
		<form name="frmModifyProfile" method="post" onSubmit="return funViewProfileId();" style="padding:0px;margin:0px;">
		<input type="hidden" name="frmModifyProfileSubmit" value="yes">
		<input type="hidden" name="MatriId" value="">
		<td height="30%" class="smalltxt"  width="20%" style="padding-left:15px;"><b>MatrimonyId/UserName</b>&nbsp;</td>
		<td width="70%" class="smalltxt">
			<input type=text name="username" value="<?=$varUsername;?>" size="15" class="inputtext" value="">&nbsp;
			<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>> Matrimony Id
			<input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>> Username&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Search" class="button">
		</td>
		</form>
	</tr>
<tr><td height="15" colspan="2"></td></tr>
</table>
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmModifyProfile;
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
}//funViewProfileId
</script>

