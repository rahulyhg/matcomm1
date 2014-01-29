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
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/lib/clsMailManager.php');

//OBJECT DECLARTION
$objSlave	= new MailManager;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//CONTROL STATEMENT
if ($_POST["frmViewFiltersSubmit"]=="yes")
{
	$varUsername 				= $_REQUEST["username"];
	$varPrimary					= $_REQUEST["primary"];
	$varSelectFilter			= "yes";

	//IF USERNAME COMES GET MatriId
	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name='".$varUsername."'";
		$argFields 				= array('MatriId');
		$varSelectMatriIdRes	= $objSlave->select($varTable['MEMBERDELETEDINFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];

	} else { $varMatriId		= $varUsername; }//

	$arrDomainDetails	= $objSlave->getDomainDetails($varMatriId);
	$varSiteName		= $arrDomainDetails['PRODUCTNAME'].'Matrimony';

	$argCondition				= "WHERE MatriId='".$varMatriId."'";
	$varNoOfResults				= $objSlave->numOfRecords($varTable['MEMBERDELETEDINFO'],'MatriId',$argCondition);
	
	if ($varNoOfResults==0){ $varSelectFilter = "no"; }//if
	if ($varNoOfResults > 0) { $varSelectFilter		= "yes"; }//if

	if ($varSelectFilter=="yes")
	{
		$argFields 				= array('MatriId','Name','User_Name','Gender','Age','Country','Email','Deleted_Reason','Deleted_Comments','Date_Created','Date_Deleted');
		$varSelectFilterInfoRes	= $objSlave->select($varTable['MEMBERDELETEDINFO'],$argFields,$argCondition,0);
		$varSelectFilterInfo	= mysql_fetch_assoc($varSelectFilterInfoRes);

	}//if
}//if
//$varSelectFilter
$objSlave->dbClose();
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="543">
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">View Deleted Profile</td></tr>
	<tr><td height="15" colspan="2"></td></tr>
	<?php if ($_POST["frmViewFiltersSubmit"]=="yes" && $varNoOfResults==0) { ?>
	<tr><td align="center" class="errorMsg" colspan="2">No Records found</td></tr><tr><td height="10" colspan="2"></td></tr>
	<?php }//if ?>
	<form name="frmViewFilters" target="_blank" method="post" onSubmit="return funViewProfileId();">
	<input type="hidden" name="frmViewFiltersSubmit" value="yes">
	<input type="hidden" name="MatriId" value="">	
	<tr>
		<td width="30%" class="smalltxt" style="padding-left:15px;"><b>Username / Matrimony Id</b></td>
		<td width="70%" class="smalltxt">
			<input type=text name="username" value="<?=$varUsername;?>" size="15" class="inputtext" value="">&nbsp;<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>> Matrimony Id
			<input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>> Username&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button">
		</td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
</table><br><br clear="all">
<?php if ($varNoOfResults > 0 && $varSelectFilter=="yes" ) { ?>
<table border="0" class="formborder"  cellpadding="0" cellspacing="1" align="center" width="523">
	<tr height="25" class="adminformheader">
		<td class="mediumtxt boldtxt" colspan="2" style="padding-left:5px;">&nbsp;Profile Details</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Sitename : </td>
		<td class="smalltxt" width="80%"><?=$varSiteName;?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Matrimony Id : </td>
		<td class="smalltxt" width="80%"><?=$varSelectFilterInfo['MatriId'];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Username : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo['User_Name'];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Gender : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo['Gender']==1 ? "Male" :"Female";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" valign="top" style="padding-left:5px;">&nbsp;Age : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Age"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Name : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Name"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" valign="top" style="padding-left:5px;">&nbsp;Country : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo['Country'] ? $arrCountryList[$varSelectFilterInfo['Country']] : "-";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Email : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Email"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Date Created : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Date_Created"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Deleted Date : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Date_Deleted"] ? $varSelectFilterInfo["Date_Deleted"] : "-";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Deleted Reason : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Deleted_Reason"] ? $arrDeleteProfileReason[$varSelectFilterInfo["Deleted_Reason"]] : "-";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Comments : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Deleted_Comments"] ? $varSelectFilterInfo["Deleted_Comments"] : "-";?></td>
	</tr>
	<tr><td height="7" colspan="2"></td></tr>
</table>
<?php }//if ?>	
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmViewFilters;
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

