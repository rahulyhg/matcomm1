<?php
#=============================================================================================================
# Author 		: M Baranidharan
# Start Date	: 2010-08-27
# End Date		: 2010-08-28
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
?>
<script language=javascript src="<?=$confValues["JSPATH"];?>/home.js"></script>
<div style="background:url(<?=$confValues['IMGSURL']?>/<?=($confValues["DOMAINCASTEID"]!= "")?'pagenotfoundbg.gif':'pagenotfound.gif'?>) no-repeat;height:<?= ($confValues["DOMAINCASTEID"]!= "")?'199px':'117px'?>;"> 
 <div style="padding-top:140px;display:<?=($confValues["DOMAINCASTEID"]!= "")?'inline':'none'?>" class="fleft smalltxt">
  <form class="marg0" action="/search/index.php" method="post" name="RSearchForm">
   <div style="padding-top: 20px; padding-left: 22px;" class="fleft">Looking for</div>
   <div style="padding-top: 20px ! important;padding-top:18px;" class="fleft">
    <div class="fleft form-field"><label for="Bride"><input type="radio" checked="checked" onclick="javascript:chkgender('f');" value="2" name="gender" id="Bride"/>&nbsp;Bride</label></div>
    <div class="fleft form-field"><label for="Groom"><input type="radio" onclick="javascript:chkgender('m');" value="1" name="gender" id="Groom"/>Groom</label></div>
   </div><div style="padding-top: 20px !important;padding-top:18px;padding-left:10px;" class="fleft">in the age group&nbsp;&nbsp;<input type="text" value="<?=$varFStartAge?>" onfocus="if ((this.value == '<?=$varFStartAge?>')|| (this.value == '<?=$varMStartAge?>')) { this.value = ''; }" onclick="if ((this.value == '<?=$varFStartAge?>') || (this.value == '<?=$varMStartAge?>')) { this.value = ''; }" size="2" class="inputtext hpagetxtbox" id="ageFrom" name="ageFrom"/> to <input type="text" value="<?=$varFStartAge+12?>" onfocus="if ((this.value == '<?=$varFStartAge+12?>') ||(this.value == '<?=$varMStartAge+12?>')) { this.value = ''; }" onclick="if ((this.value == '<?=$varFStartAge+12?>') ||(this.value == '<?=$varMStartAge+12?>')) { this.value = ''; }" size="2" class="inputtext hpagetxtbox" id="ageTo" name="ageTo"/></div><div style="padding-left: 15px; padding-top: 20px ! important;" class="fleft"><a href="/search/index.php?act=advsearch" class="smalltxt clr1">Advanced Search</a></div>
   <div style="padding-left: 10px; padding-top: 17px ! important;" class="fleft"><input type="hidden" name="photoOpt" value="1"/><input type="hidden" value="srchresult" name="act"/><input type="submit" value="Search" class="button" /></div>
  </form>
 </div>
</div><br clear="all">
<? if($confValues["DOMAINCASTEID"] == 2000) { ?>
<script language="javascript" type="text/javascript">
function chkgender(g)
{ 
if (g=="f")   { document.RSearchForm.ageFrom.value="35"; document.RSearchForm.ageTo.value="47"; }
if (g=="m") {  document.RSearchForm.ageFrom.value="40"; document.RSearchForm.ageTo.value="52"; }
}

function setagegroup()
{ if (document.RSearchForm.GENDER[0].checked==true)
{ document.RSearchForm.ageFrom.value="35"; document.RSearchForm.ageTo.value="47"; }
else
{ document.RSearchForm.ageFrom.value="40"; document.RSearchForm.ageTo.value="52"; }	
}
</script>
<?
}
?>