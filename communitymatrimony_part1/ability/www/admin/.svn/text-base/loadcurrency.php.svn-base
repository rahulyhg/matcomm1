<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2008-07-18
# End Date		: 2008-07-18
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath.'/conf/payment.inc');

//VARIABLE DECLARATION
$varCountryCode		= $_REQUEST['countryCode'];
$varCurrencySymbol	= $_REQUEST['currency'];

//FILE INCLUDES
include_once($varRootBasePath.'/www/payment/paymentprocess.php');

$arrCurrenyList		= array();
$varCurrencyList	= '';

//if ($varOfferAvailable==1) { $arrCurrenyList = $arrOffRate[$varCountryCode]; } else { $arrCurrenyList = $arrRate[$varCountryCode]; }

$arrCurrenyList = $arrPricing[0][$varCountryCode];
//echo '<pre>';
//print_r($arrCurrenyList);
//echo '</pre>';

foreach($arrCurrenyList	as $varKey1 => $varValue1) {
$varCurrencyList	.= $varCountryCode.'~'.$varKey1.'#'.$arrPrdPackages[$varKey1].' '.$varCurrencySymbol.' '.$varValue1.'|^';

}
echo $varCurrencyList;
?>




<tr>
	<td width="30%" height="45" class="normtxt tlright clr1 padr10" valign="bottom"><?=$arrPackageName[$row]?></td>
	<? for ($ix=($row-1)*3+1;$ix<($row-1)*3+4;$ix++) { ?>
	<td width="25%" class="normtxt clr" valign="bottom">
			<? if ($varDiscountAmount != 0) {  ?>
				<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="20" height="1">
				<font class="clr1"><?=$varCurrencyCode?> <?=$localCurrOfferRate[$ix]?></font><br>
				<input type="radio" name="category" value="<?=$ix?>"><del style="text-decoration:strikethru;color:#ff0000;"><font class="clr"><?=$varCurrencyCode?> <?=$localCurrOriginalRate[$ix]?></font></del>
			<? } else { // if no offer available ?>
				<input type="radio" name="category" value="<?=$ix?>">
				<?=$varCurrencyCode?> <?=$localCurrOriginalRate[$ix]?>
			<? } //if offer ?>
	</td>
	<? } //for ix ?>