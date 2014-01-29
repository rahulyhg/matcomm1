<div class="fleft" style="width:320px;" ><b>							
<? if($showError!='') { echo "Offer Status&nbsp;:&nbsp;".$showError; } 
else { ?>	
<div class='fleft'>Offer Info&nbsp;:-&nbsp;&nbsp;</div><div class='fright'>
<? //include_once ($varRootBasePath."/www/admin/paymentassistance/offer/currenceConversion.php"); 

if($defutShow=='AED') { $disp1='block';$disp2='none'; }
else { $disp1='none';$disp2='block'; }
?></div><br clear='all'>

<span id='CURRENCY'><div id='currtab1' class='fleft'><div id='currtablink1_inactive' class='fleft' style='display:<?=$disp1?>;'><a href='javascript:void(0)' onclick="clickTabNew(1,5,'currtab');getnewoffertype('INR');" class='mediumtxt1 boldtxt clr1'>INR</a></div><div id='currtablink1_active' class='fleft boldtxt' style='display:<?=$disp2?>;'>INR</div>&nbsp;|&nbsp;</div> 

<div id='currtab2' class='fleft'><div id='currtablink2_inactive' class='fleft' style='display:<?=$disp2?>;'><a href='javascript:void(0)' onclick="clickTabNew(2,5,'currtab');getnewoffertype('AED');" class='mediumtxt1 boldtxt clr1'>AED</a></div><div id='currtablink2_active' class='fleft boldtxt' style='display:<?=$disp1?>;'>AED</div>&nbsp;|&nbsp;</div>

<div id='currtab3' class='fleft'><div id='currtablink3_inactive' class='fleft' style='display:block;'><a href='javascript:void(0)' onclick="clickTabNew(3,5,'currtab');getnewoffertype('USD');" class='mediumtxt1 boldtxt clr1'>USD</a></div><div id='currtablink3_active' class='fleft boldtxt' style='display:none;'>USD</div>&nbsp;|&nbsp;</div>

<div id='currtab4' class='fleft'><div id='currtablink4_inactive' class='fleft' style='display:block;'><a href='javascript:void(0)' onclick="clickTabNew(4,5,'currtab');getnewoffertype('GBP');" class='mediumtxt1 boldtxt clr1'>GBP</a></div><div id='currtablink4_active' class='fleft boldtxt' style='display:none;'>GBP</div>&nbsp;|&nbsp;</div>

<div id='currtab5' class='fleft'><div id='currtablink5_inactive' class='fleft' style='display:block;'><a href='javascript:void(0)' onclick="clickTabNew(5,5,'currtab');getnewoffertype('EURO');" class='mediumtxt1 boldtxt clr1'>EURO</a></div><div id='currtablink5_active' class='fleft boldtxt' style='display:none;'>EURO</div></div><br clear="all"></span></b>

<!-- <div id='currtab6' class='fleft'><div id='currtablink6_inactive' class='fleft' style='display:block;'><a href='javascript:void(0)' onclick="clickTabNew(6,6,'currtab');getnewoffertype('MYR');" class='mediumtxt1 boldtxt clr1'>MYR</a></div><div id='currtablink6_active' class='fleft boldtxt' style='display:none;'>MYR</div></div><br clear="all"></span></b> -->
<? }
if(empty($showError)){?>
<div  id="HIDEOFFERINFO">
<div align="left" style="overflow: auto; height: 283px !important;height: 290px; width: 322px;border: 1px solid #C0C0C0;"  valign="middle">
<table cellspacing="0" cellpadding="0" border="0" >
<tr><td class="smalltxt" style="padding: 15px 0px 0px 15px;">
<div id="HIDEOFFERINFOSHOW">
<?
$expDateShow=count($offerArray);
foreach($offerArray as $offerKey=>$offerValue){
echo $offerValue;
if($offerKey%3=='0'){
?>
<br clear='all'><div style="width:280px;" class="vdotline1"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div><br clear='all'>
<? 
}
}
?>
</div>
<td></tr></table></div>
<div style="width: 324px;background:#DBDBDB;" class="smalltxt">
<div class="fleft smalltxt" style="padding-top:1px;">&nbsp;&nbsp;End Date:</div>
<div class="fleft" style="padding-top:1px;">
<input type="text" name="FDATEEXP"  id="FDATEEXP"  value="<? echo date("Y-m-d",$offerEndDate);?>" readonly style="width:120px;" class=inputtext onclick="displayDatePicker('FDATEEXP', '', 'ymd', '-');"  HIDEFOCUS>

<!-- <input type="text" readonly="" value="<? echo date("Y-m-d",$offerEndDate);?>" name="FDATEEXP" class="inputtext" id="FDATEEXP" style="width: 65px; "/><a href="#"  onclick="return showCalendar('FDATEEXP', '%Y-%m-%d');" class="smalltxt"> <img border="0" valign="middle" src="http://wcc.matchintl.com/images/calendar/calc.gif"/>
</a> -->
<input type="hidden" value="<?=$CALLINGVIA?>" id="CALLINGVIA" name="CALLINGVIA"/>
<input type="hidden" id="OFFEROK" name="OFFEROK"  value="1"/></div><br clear="all" />
</div></div>
<span id="OFFERDATEDIV" onblur="clearfollowup('OFFERDATEDIV');" class="errortxt"></span>
<?
} 
else { 
$noOffer="<div align='left' style='overflow: auto; height: 283px !important;height: 290px; width: 312px;border: 1px solid #C0C0C0;'  valign='middle'  id='HIDENOOFFERINFO'>
<table cellspacing='0' cellpadding='0' border='0' >
<tr><td class='smalltxt' style='padding: 15px 0px 0px 15px;'>";

foreach($package98 as $packKey=>$packValue) {
$packageName=str_replace('package', '', 

$package98[$packKey]['name']); 
$noOffer.="<input type='radio' name='PACKAGESELECT' id='PACKAGESELECT'  value='".$packKey."'  class='smalltxt'> ".$packageName."<br>";
if($packKey%3=='0'){

$noOffer.="<br clear='all'><div style='width:275px;' class='vdotline1'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='1'></div><br clear='all'>";
}
}
$noOffer.="<input type='hidden' name='OFFEROK' id='OFFEROK' value='2'>";
$noOffer.="<input type='hidden' value='$CALLINGVIA' id='CALLINGVIA' name='CALLINGVIA'/><br/></td>
</tr>
</table>		
</div><br clear='all'>
<span id='OFFERDATEDIV' onblur=clearfollowup('OFFERDATEDIV'); class='errortxt'></span>";
echo $noOffer;
}
?>	
<input type='hidden' name='SELECTEDCURRENCY' id='SELECTEDCURRENCY' value="<?=$defutShow?>">
<input type='hidden' name='OFFERMAX' id='OFFERMAX' value="<?=$tmCateOfferMax?>">
<input type='hidden' name='OFFERCATETYPE' id='OFFERCATETYPE' value="<?=$returnCateType?>">
<input type='hidden' name='OFFERMATRIID' id='OFFERMATRIID' value="<?=$recdgen['MatriId']?>">
<input type='hidden' name='OFFERID' id='OFFERID' value="<?=$checkOfferCatId['CBSTMSUPPORT']?>">
<input type="hidden" name="OFFERCODE" id='OFFERCODE' value="<?=$offerCode?>">

