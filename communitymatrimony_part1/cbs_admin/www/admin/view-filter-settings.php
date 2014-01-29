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
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/productvars.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/lib/clsCommon.php');

//OBJECT DECLARTION
$objSlave	= new clsRegister;
$objCommon	= new clsCommon;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLERATION
 $varThroughViewProfile	= $_REQUEST['tvprofile'];

//CONTROL STATEMENT
if (($_POST["frmViewFiltersSubmit"]=="yes")||($varThroughViewProfile=="yes"))
{
	$varUsername 				= $_REQUEST["username"];
	$varPrimary					= $_REQUEST["primary"];
	$varSelectFilter			= "yes";
	
	//IF USERNAME COMES GET MatriId
	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name=".$objSlave->doEscapeString($varUsername,$objSlave);
		$argFields 				= array('MatriId');
		$varSelectMatriIdRes	= $objSlave->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];
	}//if
	else
	{
		$varMatriId				= $varUsername;
	}//

	$argCondition				= "WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave);
	$varNoOfResults				= $objSlave->numOfRecords($varTable['MEMBERFILTERINFO'],'MatriId',$argCondition);
	
	if ($varNoOfResults==0){ $varSelectFilter = "no"; }//if
	if ($varNoOfResults > 0) { $varSelectFilter		= "yes"; }//if

	if ($varSelectFilter=="yes")
	{
		$argFields 				= array('MatriId','Marital_Status','Age_Above','Age_Below','Country','Date_Updated', 'Mother_Tongue', 'Caste', 'Religion');
		$varSelectFilterInfoRes	= $objSlave->select($varTable['MEMBERFILTERINFO'],$argFields,$argCondition,0);
		$varSelectFilterInfo	= mysql_fetch_assoc($varSelectFilterInfoRes);
	}//if
}//if
//$varSelectFilter
$objSlave->dbClose();
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="543">
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">View Filter Settings</td></tr>
	<tr><td height="15" colspan="2"></td></tr>
	<?php if(isset($varThroughViewProfile)){?>
	<tr>
		<td width="30%" class="smalltxt" style="padding-left:15px;" align="center"><b>Matrimony Id :</b></td>
		<td width="70%" class="smalltxt">
			<?php echo $varMatriId?>
		</td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	<?php }?>
	<?php if (($_POST["frmViewFiltersSubmit"]=="yes" && $varNoOfResults==0)|| ($varThroughViewProfile=="yes" && $varNoOfResults==0)) { ?>
	<tr><td align="center" class="errortxt" colspan="2">No Records found</td></tr><tr><td height="10" colspan="2"></td></tr>
	<?php }//if ?>
	<form name="frmViewFilters" target="_blank" method="post" onSubmit="return funViewProfileId();">
	<input type="hidden" name="frmViewFiltersSubmit" value="yes">
	<input type="hidden" name="MatriId" value="">	
	<?php if(!isset($varThroughViewProfile)){?>
	<tr>
		<td width="30%" class="smalltxt" style="padding-left:15px;"><b>Username / Matrimony Id</b></td>
		<td width="70%" class="smalltxt">
			<input type=text name="username" value="<?=$varUsername;?>" size="15" class="inputtext" value="">&nbsp;<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>> Matrimony Id
			<input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>> Username&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button">
		</td>
	</tr>
	<?php }?>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
</table><br><br clear="all">

<?php if ($varNoOfResults > 0 && $varSelectFilter=="yes" ) { ?>
<table border="0" class="formborder"  cellpadding="0" cellspacing="1" align="center" width="525">
	<tr height="25" class="adminformheader">
		<td class="mediumtxt boldtxt" colspan="2" style="padding-left:5px;">&nbsp;Filter Settings</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Religion : </td>
		<td class="smalltxt" width="80%"><?=$varSelectFilterInfo['Religion'] != ''? $objCommon->getArrayFromString($varSelectFilterInfo['Religion'],$arrReligionList) : "Any";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Division : </td>
		<td class="smalltxt" width="80%"><?=$varSelectFilterInfo['Caste'] != ''? $objCommon->getArrayFromString($varSelectFilterInfo['Caste'],$arrCasteDivisionList) : "Any";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Marital Status : </td>
		<td class="smalltxt" width="80%"><?=$varSelectFilterInfo['Marital_Status'] != ''? $objCommon->getArrayFromString($varSelectFilterInfo['Marital_Status'],$arrMaritalList) : "Any";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Mother Tongue : </td>
		<td class="smalltxt" width="80%"><?=$varSelectFilterInfo['Mother_Tongue'] != ''? $objCommon->getArrayFromString($varSelectFilterInfo['Mother_Tongue'],$arrMotherTongueList) : "Any";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Age Above : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Age_Above"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Age Below : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Age_Below"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" valign="top" style="padding-left:5px;">&nbsp;Country : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo['Country'] != '' ? $objCommon->getArrayFromString($varSelectFilterInfo['Country'],$arrCountryList) : "Any";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Date : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Date_Updated"];?></td>
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

