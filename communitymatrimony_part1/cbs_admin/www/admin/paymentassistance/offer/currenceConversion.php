<?php
###########################################################################################################
#FileName		: currenceConversion.php
#Created		: On:11-12-2009
#Author		    : A.Anbalagan
#Description	: Get Currence Conversion 
###########################################################################################################
//ini_set('display_errors','on');
//error_reporting(E_ALL ^ E_NOTICE);
include($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferarray.php");
include($varRootBasePath."/conf/currconvrate.php");

$curStr = "
<option value='$varCurrUsdToInr'>USD TO INR</option>
<option value='$varCurrUsdToGbp'>USD TO GBP</option>
<option value='$varCurrUsdToAed'>USD TO AED</option>
<option value='$varCurrUsdToEur'>USD TO EUR</option>

<option value='$varCurrInrToUsd'>INR TO USD</option>
<option value='$varCurrInrToGbp'>INR TO GBP</option>
<option value='$varCurrInrToAed'>INR TO AED</option>
<option value='$varCurrInrToEur'>INR TO EUR</option>

<option value='$varCurrGbpToUsd'>GBP TO USD</option>
<option value='$varCurrGbpToInr'>GBP TO INR</option>
<option value='$varCurrGbpToAed'>GBP TO AED</option>
<option value='$varCurrGbpToEur'>GBP TO EUR</option>

<option value='$varCurrAedToUsd'>AED TO USD</option>
<option value='$varCurrAedToInr'>AED TO INR</option>
<option value='$varCurrAedToGbp'>AED TO GBP</option>
<option value='$varCurrAedToEur'>AED TO EUR</option>

<option value='$varCurrEurToUsd'>EUR TO USD</option>
<option value='$varCurrEurToInr'>EUR TO INR</option>
<option value='$varCurrEurToAed'>EUR TO AED</option>
<option value='$varCurrEurToGbp'>EUR TO GBP</option>




";

/*
function curlFetchCurrencyValue($url) {
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $output = curl_exec($ch);
 curl_close($ch);
 return $output;
}
$url = "http://profile.bharatmatrimony.com/payments/getcurrencydetails1.php";
#$url = "www.bharatmatrimony.com/payments/getcurrencydetails.php";
$url = $url."?type=currencyconvarray";
$resultRecord = json_decode(curlFetchCurrencyValue($url),1);

$curStr="<option value='0' selected>-Currence Type-</option>";
foreach($currenceArray as $cukey=>$cuValue) {
	$curStr.="<option value='".$resultRecord[$cukey]."'>$cuValue</option>";
}
*/
?>
<!--<SCRIPT LANGUAGE="JavaScript" src="http://telemarketing.matchintl.com/tmiface/js/hp-viewprofile.js"></SCRIPT> -->
<div class="fright" style="padding: 0px 0px 10px 0px; "><a class="smalltxt clr1" onclick="return srch_overlay(this, 'srch_savecontent1');" href="javascript:;"><B>Currency Conversion</B> <img height="7" width="4" border="0" alt="" src="offer/hp-orng-arrow.gif"/></a></div><div style="clear:both;"></div>
<!--vbyid-->
<div id="srch_savecontent1" style="position:absolute; display:none;background-image: url('offer/hp-vbyidbg.gif');width:225px;height:172px;z-index:101;">
<div align="right" style="padding-top:5px;width:220px"><a href="#" onclick="srch_overlayclose('srch_savecontent1'); return false" class="smalltxt clr1"><img src="offer/close-icon.gif" width="12" height="12" border="0" alt="" /></a></div>
<div style="width: 215px !important; width: 215px; margin: 0px; position:relative;  z-index:100;">
<div style="padding: 10px 10px 0px 10px; position:relative;  z-index:99;">
<div style="line-height:12px;padding-bottom:10px; position:relative;  z-index:98;"><font class="smalltxt">Enter the Offer Amount</font><input name="AMOUNT" id="AMOUNT" size="35" maxlength="10" value="" class="inputtext" type="text" /></div>
<div style="padding-bottom:5px;width: 203px !important; width: 203px;">
<div class="smalltxt" style="margin: 7px 0pt 0pt 0px;">Conversion Type<br /><select name="CURRENCETYPE" id="CURRENCETYPE" style="width:140px;" class="inputtext" onChange="currenceCalculate(this);"><?=$curStr?></select>&nbsp;&nbsp;
<span id='RETAMT'></span></div></div></div></div></div>
<INPUT type='hidden' name='UAETOINDIACURRENCE'  id='UAETOINDIACURRENCE' value="<?=$resultRecord['aedtoinr']?>">
