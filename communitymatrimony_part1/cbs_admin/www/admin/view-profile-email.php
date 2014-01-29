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
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');

//OBJECT DECLARTION
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

function getDateMonthYear($argFormat,$argDateTime)
{
	if (trim($argDateTime) !="0000-00-00 00:00:00")
	{ $retDateValue = date($argFormat,strtotime($argDateTime)); }//if
	else $retDateValue="";
	return $retDateValue;
}//getDateMothYear

//CONTROL STATEMENT
if ($_POST["frmViewEmailProfileSubmit"]=="yes")
{
	$varEmail 					= trim($_REQUEST["email"]);
	
	if($varEmail!='') {
		$argCondition				= "WHERE ml.MatriId = mi.MatriId AND ml.Email=".$objSlave->doEscapeString($varEmail,$objSlave);
		$varCombinedTables			= $varTable['MEMBERLOGININFO'].' as ml,'.$varTable['MEMBERINFO'].' as mi';
		$argFields 					= array('mi.MatriId','mi.Date_Created','mi.Paid_Status','mi.Last_Payment','mi.Valid_Days');
		$varProfileRes				= $objSlave->select($varCombinedTables,$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	}
} else if ($_POST["frmViewBMIdProfileSubmit"]=="yes") {
	$varBMMatriId				= addslashes(strip_tags(trim($_REQUEST["bmid"])));
	if($varBMMatriId!='') {
		$argCondition				= "WHERE BM_MatriId=".$objSlave->doEscapeString($varBMMatriId,$objSlave);
		$argFields 					= array('MatriId','Date_Created','Paid_Status','Last_Payment','Valid_Days');
		$varProfileRes				= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	}
} else if ($_POST["frmViewPhoneProfileSubmit"]=="yes") {
	$varCountryCode				= addslashes(strip_tags(trim($_REQUEST["ccode"])));
	$varAreaCode				= addslashes(strip_tags(trim($_REQUEST["acode"])));
	$varLandline				= addslashes(strip_tags(trim($_REQUEST["landline"])));
	$varMobile					= addslashes(strip_tags(trim($_REQUEST["mobile"])));

	if($varMobile!='') {
		$varPhoneNo				= $varCountryCode.'~'.$varMobile;
		$argPhoneCondition		= "WHERE Contact_Mobile=".$objSlave->doEscapeString($varPhoneNo,$objSlave);
	} else if($varLandline!='') {
		$varPhoneNo				= $varCountryCode.'~'.$varAreaCode.'~'.$varLandline;
		$argPhoneCondition		= "WHERE Contact_Phone=".$objSlave->doEscapeString($varPhoneNo,$objSlave);
	}

	if($argPhoneCondition!='') {
		$argFields 					= array('MatriId','Date_Created','Paid_Status','Last_Payment','Valid_Days');
		$varProfileRes				= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argPhoneCondition,0);
		//$varQuery = "SELECT MatriId,Date_Created,Paid_Status,Last_Payment,Valid_Days FROM memberinfo ".$argCondition;
		//$varProfileRes = mysql_query($varQuery,$objSlave->clsDBLink) or die("Error");
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	}

}//if
//'Publish','Last_Login','Date_Created'

$objSlave->dbClose();

?>
<form name="frmViewEmailProfile" target="_blank" method="post">
<input type="hidden" name="frmViewEmailProfileSubmit" value="">
<input type="hidden" name="frmViewBMIdProfileSubmit" value="">
<input type="hidden" name="frmViewPhoneProfileSubmit" value="">
<input type="hidden" name="MatriId" value="">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">
	<tr><td height="10"></td></tr>
	<tr><td valign="middle" class="heading" style="padding-left:15px;">MatriId From E-mail</td></tr>
	<tr><td height="10"></td></tr>
	<?php if ($_POST["frmViewEmailProfileSubmit"]=="yes" && $varNumOfRecords==0) { ?>
	<tr><td align="center" class="errorMsg">No Records found</td></tr><tr><td height="10" ></td></tr>
	<?php }//if ?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Enter Email</b>&nbsp;<input type=text name="email" value="<?=$varEmail;?>" size="35" class="inputtext">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Search1" class="button" onClick="return funViewProfileId();"></td>
	</tr>
	<tr><td height="20"></td></tr>

	<tr><td height="10"></td></tr>
	<tr><td valign="middle" class="heading" style="padding-left:15px;">MatriId From BM_MatriId</td></tr>
	<tr><td height="10"></td></tr>
	<?php if ($_POST["frmViewBMIdProfileSubmit"]=="yes" && $varNumOfRecords==0) { ?>
	<tr><td align="center" class="errorMsg">No Records found</td></tr><tr><td height="10" ></td></tr>
	<?php }//if ?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Enter BM-MatriId</b>&nbsp;<input type=text name="bmid" value="<?=$varBM_MatriId;?>" size="35" class="inputtext">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Search2" class="button" onClick="return funViewProfileByBMMatriId();"></td>
	</tr>
	<tr><td height="20"></td></tr>

	<tr><td height="10"></td></tr>
	<tr><td valign="middle" class="heading" style="padding-left:15px;">MatriId From Phone</td></tr>
	<tr><td height="10"></td></tr>
	<?php if ($_POST["frmViewPhoneProfileSubmit"]=="yes" && $varNumOfRecords==0) { ?>
	<tr><td align="center" class="errorMsg">No Records found</td></tr><tr><td height="10" ></td></tr>
	<?php }//if ?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;">
			<table border="0">
				<tr>
					<td align='center'>Country Code</td>
					<td align='center'>Area Code</td>
					<td align='center' colspan=3>Landline (or) Mobile</td>
				</tr>
				<tr>
					<td><input type=text name="ccode" value="<?=$varBM_MatriId;?>" size="5" class="inputtext"></td>
					<td><input type=text name="acode" value="<?=$varBM_MatriId;?>" size="10" class="inputtext"> -</td>
					<td><input type=text name="landline" value="<?=$varBM_MatriId;?>" size="15" class="inputtext"> (or)</td>
					<td><input type=text name="mobile" value="<?=$varBM_MatriId;?>" size="15" class="inputtext"></td>
					<td><input type="button" value="Search" class="button" onClick="return funViewProfileByPhoneNo();"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="20"></td></tr>

</table>
</form><br><br>
<?php if ($varNumOfRecords > 0) { ?>
<table border="0" class="formborderclr"  cellpadding="0" cellspacing="1" align="left" width="545">
	<tr>
		<td valign="top" width="545" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
			<tr height="25">
				<td class="mailerEditTop" width="25%">MatriId</td>
				<td class="mailerEditTop" width="25%">Profile Type</td>
				<td class="mailerEditTop" width="25%">Date Created</td>
			</tr>
			<?php
			 while($varSelectEmailProfile = mysql_fetch_assoc($varProfileRes)) {
			 
			 $varMatriId			= $varSelectEmailProfile["MatriId"];
			 $varMatriIdPrefix		= substr($varMatriId,0,3);
			 $arrMatriIdPreReverse	= array_flip($arrMatriIdPre);
			 $varCommunityId		= $arrMatriIdPreReverse[$varMatriIdPrefix];
			 $varProfileType		= $varSelectEmailProfile["Paid_Status"];
			 $varCreatedDate		= getDateMonthYear('d-M-Y',$varSelectEmailProfile["Date_Created"]);
			?>
			<tr>
				<td class="smalltxt" style="padding-left:10px"><a href="#" onClick="javascript:window.open('<?=$confValues['SERVERURL']?>/admin/index.php?act=view-profile1&actstatus=yes&matrimonyId=<?=$varMatriId?>&communityid=<?=$varCommunityId?>');"><?=$varMatriId?></a></td>
				<td class="smalltxt" style="padding-left:30px"><?=$varProfileType==1 ? "Paid" : "Free"; ?></td>
				<td class="smalltxt" style="padding-left:15px"><?=$varCreatedDate ? $varCreatedDate : "-";?></td>
			</tr>
			<tr><td height="7"></td></tr>
			<?}//if?>
			</table>
		</td>
	</tr>
</table>
<?php }//if ?>		
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmViewEmailProfile;
	if (frmName.email.value=="")
	{
		alert("Please enter  E-Mail");
		frmName.email.focus();
		return false;
	}
	frmName.frmViewEmailProfileSubmit.value='yes';
	frmName.submit();
	return true;
}//funViewProfileId
function funViewProfileByBMMatriId()
{
	var frmName = document.frmViewEmailProfile;
	if (frmName.bmid.value=="")
	{
		alert("Please enter BM-MatriId");
		frmName.bmid.focus();
		return false;
	}
	frmName.frmViewBMIdProfileSubmit.value='yes';
	frmName.submit();
	return true;
}//funViewProfileId

function funViewProfileByPhoneNo() {
	var frmName = document.frmViewEmailProfile;

	if (frmName.ccode.value=="")
	{
		alert("Please enter country code");
		frmName.ccode.focus();
		return false;
	}//if

	if (frmName.landline.value=="" && frmName.mobile.value=="")
	{
		alert("Please enter landline or mobile no");
		frmName.mobile.focus();
		return false;
	}//if

	if (frmName.landline.value!="" && frmName.acode.value=="")
	{
		alert("Please enter area code");
		frmName.acode.focus();
		return false;
	}//if

	frmName.frmViewPhoneProfileSubmit.value='yes';
	frmName.submit();
	return true;
}
</script>

