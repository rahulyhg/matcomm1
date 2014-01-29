<div class="fleft" style="width:320px;" ><b>							
<? if($showError!='') { echo "Offer Status&nbsp;:&nbsp;".$showError; } else { echo $offerType; } ?></b>
<? include_once ($varRootBasePath."/www/admin/paymentassistance/offer/currenceConversion.php"); ?>
<?
$countryCodes = $ccode;
if($countryCodes == "" || $countryCodes == "0")	$countryCodes = $row['Country'];
if($countryCodes == "" || $countryCodes == "0") $countryCodes = 98;

if($arrCurrCode[$countryCodes] == "")
	$countryCodes = 98;

if(empty($showError)){?>
<div  id="HIDEOFFERINFO">
<div align="left" style="overflow: auto; height: 283px !important;height: 290px; width: 322px;border: 1px solid #C0C0C0;"  valign="middle">
<table cellspacing="0" cellpadding="0" border="0">
<tr><td class="smalltxt" style="padding: 15px 0px 0px 15px;">
<?

echo "<table cellpadding='0' cellspacing='0' align='center' border='0'>";
$expDateShow=count($offerArray);
foreach($offerArray as $offerKey=>$offerValue)
{
	echo "<tr><td width='150'>$offerValue</td><td class='smalltxt'> - ".$arrCurrCode[$countryCodes]." ".$arrSegment[$countryCodes][$offerKey]."</td></tr>";
	if($offerKey%3=='0'){
	echo "<tr><td colspan='2'>";
?>
<br clear='all'><div style="width:350px;" class="vdotline1"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div><br clear='all'>
<? 
	echo "</td></tr>";
	}
}
echo "</table>";
?>
<td></tr></table></div>
<div style="width: 324px;background:#DBDBDB;" class="smalltxt">
<div class="fleft smalltxt" style="padding-top:1px;">&nbsp;&nbsp;Expire Date:</div>
<div class="fleft" style="padding-top:1px;">
<input type="text" name="FDATEEXP"  id="FDATEEXP"  value="<? echo date("Y-m-d",$offerEndDate);?>" readonly style="width:120px;" class=inputtext onclick="displayDatePicker('FDATEEXP', '', 'ymd', '-');"  HIDEFOCUS>
<!---
<input type="text" readonly="" value="<? echo date("Y-m-d",$offerEndDate);?>" name="FDATEEXP" class="inputtext" id="FDATEEXP" style="width: 65px; "/><a href="#"  onclick="return showCalendar('FDATEEXP', '%Y-%m-%d');" class="smalltxt">
--->

<input type="hidden" value="<?=$CALLINGVIA?>" id="CALLINGVIA" name="CALLINGVIA"/>
<input type="hidden" id="OFFEROK" name="OFFEROK"  value="1"/></div><br clear="all" />
</div></div>
<span id="OFFERDATEDIV" onblur="clearfollowup('OFFERDATEDIV');" class="errortxt"></span>
<?
} 
else 
{ 
	$noOffer = "<div align='left' style='overflow: auto; height: 283px !important;height: 290px; width: 312px;border: 1px solid #C0C0C0;'  valign='middle'  id='HIDENOOFFERINFO'>
	<table cellspacing='0' cellpadding='0' border='0' >
	<tr><td class='smalltxt' style='padding: 15px 0px 0px 15px;'>";
	$noOffer .= "<table cellpadding='0' cellspacing='0' align='center' border='0'>";
	foreach($arrPrdPackages as $packKey=>$packValue)
	{

		//$packageName=str_replace('package', '', $package98[$packKey]['name']); 
		$packageName=str_replace('package', '', $packValue); 
		$noOffer.="<tr><td class='smalltxt' width='150'><input type='radio' name='PACKAGESELECT' id='PACKAGESELECT'  value='".$packKey."'  class='smalltxt'> "."&nbsp;".$packValue."</td><td class='smalltxt'>- ".$arrCurrCode[$countryCodes]." ".$arrSegment[$countryCodes][$packKey]."</td></tr>";
		if($packKey%3=='0')
		{
			$noOffer .= "<tr><td width='150' colspan='2'>";
			$noOffer.="<br clear='all'><div style='width:275px;' class='vdotline1'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='1'></div><br clear='all'>";
			$noOffer .= "</td></tr>";
		}
	}
	$noOffer .= "</table>";
	$noOffer.="<input type='hidden' name='OFFEROK' id='OFFEROK' value='2'>";
	$noOffer.="<input type='hidden' value='$CALLINGVIA' id='CALLINGVIA' name='CALLINGVIA'/><br/></td>
</tr>
</table>		
</div><br clear='all'>
<span id='OFFERDATEDIV' onblur=clearfollowup('OFFERDATEDIV'); class='errortxt'></span>";
echo $noOffer;
}

?>		