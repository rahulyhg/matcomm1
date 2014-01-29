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
	$varEmail 					= $_REQUEST["email"];

	$argCondition				= "WHERE ml.MatriId = mi.MatriId AND ml.Email='".$varEmail."'";
	$varCombinedTables			= $varTable['MEMBERLOGININFO'].' as ml,'.$varTable['MEMBERINFO'].' as mi';
	$argFields 					= array('ml.MatriId','ml.Date_Updated','ml.User_Name','mi.Paid_Status','mi.Last_Payment','mi.Valid_Days');
	$varSelectEmailProfileRes	= $objSlave->select($varCombinedTables,$argFields,$argCondition,0);
	$varNumOfRecords			= mysql_num_rows($varSelectEmailProfileRes);

}//if
//'Publish','Last_Login','Date_Created'

$objSlave->dbClose();

?>
<form name="frmViewEmailProfile" target="_blank" method="post" onSubmit="return funViewProfileId();">
<input type="hidden" name="frmViewEmailProfileSubmit" value="yes">
<input type="hidden" name="MatriId" value="">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">
	<tr><td height="10"></td></tr>
	<tr><td valign="middle" class="heading" style="padding-left:15px;">Username FROM E-mail</td></tr>
	<tr><td height="10"></td></tr>
	<?php if ($_POST["frmViewEmailProfileSubmit"]=="yes" && $varNumOfRecords==0) { ?>
	<tr><td align="center" class="errorMsg">No Records found</td></tr><tr><td height="10" ></td></tr>
	<?php }//if ?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Enter Email</b>&nbsp;<input type=text name="email" value="<?=$varEmail;?>" size="35" class="inputtext" value="">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button"></td>
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
				<td class="mailerEditTop" width="25%">Username</td>
				<td class="mailerEditTop" width="25%">Profile Type</td>
				<td class="mailerEditTop" width="25%">Date Created</td>
			</tr>
			<?php
			 while($varSelectEmailProfile = mysql_fetch_assoc($varSelectEmailProfileRes)) {

			 $varProfileType = $varSelectEmailProfile["Paid_Status"];
			 $varCreatedDate = getDateMonthYear('d-M-Y',$varSelectEmailProfile["Date_Updated"]);
			?>
			<tr>
				<td class="smalltxt" style="padding-left:10px"><?=$varSelectEmailProfile["MatriId"]?></td>
				<td class="smalltxt" style="padding-left:10px"><?=$varSelectEmailProfile["User_Name"]?></td>
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
	}//if
	return true;
}//funViewProfileId
</script>

