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
include_once($varRootBasePath.'/www/payment/paymentprocess.php');

//VARIABLE DECLERATION
$varUsernameId		= $_REQUEST['username'];
$varPrimary			= $_REQUEST['primary'];
$arrCurrenyList	= array();

if ($varOfferAvailable==1) { $arrCurrenyList = $arrOffRate; } else { $arrCurrenyList = $arrRate; }
//$arrUniqueCurrency	= array_unique($arrCountryCurrency);

$varCategoryList	= '';
foreach($arrCurrencyList as $varKey => $varValue) {
	$varCurrencyCode	= $varKey;
	$varCountryCode		= $varValue;
	$arrLocalCurrency	= $arrCurrenyList[$varValue];

	foreach($arrLocalCurrency	as $varKey1 => $varValue1) {
		$varCategoryList	.= '<option value="'.$varCountryCode.'~'.$varKey1.'">'.$arrPrdPackages[$varKey1].' '.$varCurrencyCode.' '.$varValue1.'</option>';

	}
}//foreach

//echo $varCategoryList;

?>
<script language="javascript">
function funMaxMind()
{
	var varError = 'no';

	var frmName = document.frmMaxMind;
	if (frmName.category.value=="")
	{
		alert("Please select category");
		frmName.category.focus();
		varError = 'yes';
		return false;
	}//if
	if (frmName.username.value=="")
	{
		alert("Please enter  Username / Matrimony Id");
		frmName.username.focus();
		varError = 'yes';
		return false;
	}//if
	if (!(frmName.primary[0].checked==true || frmName.primary[1].checked==true))
	{
		varError = 'yes';
		alert("Please select Username / Matrimony Id");
		frmName.primary[0].focus();
		return false;
	}//if
	if (varError == 'yes') { frmName.action='maxmind-upgrade'; }
	else { frmName.action='http://matchintl.com/payments/citioffline.php'; }

	return true;
}//funMaxMind
</script>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="542">
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">Upgrade Profile (Maxmind)</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
	<?php if ($_REQUEST["frmPaymentSubmit"]=="yes") { echo'<tr><td class="errorMsg" colspan="2">'.$varResult.'</td></tr><tr><td height="5" colspan="2"></td></tr>'; } ?>
	<form name="frmMaxMind" action="index.php" method="post" onSubmit=" return funMaxMind();">
	<input type="hidden" name="frmPaymentSubmit" value="yes">
	<input type="hidden" name="act" value="maxmind-upgrade">
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Category</b>&nbsp;</td>
		<td class="smalltxt">
			<select name="category" class="smalltxt">
					<option value="">Select Category</option>
					<?=$varCategoryList;?>
			<!-- <option value="98~3">3 Months (Rs. 990)</option>
			<option value="98~6">6 Months (Rs. 1590)</option>
			<option value="98~9">9 Months (Rs. 2190)</option>

			<option value="222~3">3 Months (US Dollar 34 - INR 1717)</option>
			<option value="222~6">6 Months (US Dollar 55 - INR 2778)</option>
			<option value="222~9">9 Months (US Dollar 70 - INR 3535)</option>
			
			<option value="221~3">3 Months (UK Pound  17 - INR 1279)</option>
			<option value="221~6">6 Months (UK Pound  28 - INR 2106)</option>
			<option value="221~9">9 Months (UK Pound  34 - INR 2557)</option> -->
			</select>
		</td>
	</tr>
	<tr>
		<td class="smalltxt" width="30%" style="padding-left:15px;"><b>MatrimonyId/UserName</b>&nbsp;</td>
		<td width="70%" class="smalltxt"><input type=text name="username" value="<?=$varUsernameId;?>" size="15" class="inputtext">&nbsp;<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>>&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>>&nbsp;UserName&nbsp;&nbsp;&nbsp;&nbsp;<input type="Submit" Value="Submit" class="button"></td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
</table>