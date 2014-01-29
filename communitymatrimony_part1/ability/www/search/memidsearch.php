<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 31 Jul 2008
# End Date	: 31 Jul 2008
# Project		: MatrimonyProduct
# Module		: MemberId Search  
#====================================================================================================
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
	<div class="rpanel fleft">
		<div class="normtxt1 clr2 padb5 padl"><font class="clr bld">Search Options</font></div>
		<div class="linesep fright" style="width:550px;"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
		<div class="smalltxt clr2 padt5 padl"><a href="<?=$confValues['SERVERURL']?>/search/" class="clr1">Basic</a> &nbsp;|&nbsp; <a href="index.php?act=advsearch" class="clr1">Advanced</a> &nbsp;|&nbsp; <font class="clr bld">By Member ID</font></div><br clear="all">

		<!-- Member-Id -->
		<div class="pfdivlt smalltxt fleft tlright">Member-Id</div> 
		<div class="smalltxt fleft pad5">
			<input id="mIdInput" type="text" size="10" class="inputtext" name="matrimonyId"/>
		</div> 

		<div class="fleft" style="padding-left:18px;padding-bottom:5px;padding-top:5px;">
			<input type="button" class="button" value="View Profile" onclick="showProfile();">
		</div>
		<br clear="all">

		<div class="pfdivlt smalltxt fleft tlright">&nbsp;</div> 
		<div class="pfdivlt smalltxt fleft">
			<div id="errorMsg" class="errortxt fleft" style="display:none;"></div>
		</div>
		<br clear="all">

		<form name="buttonfrm">
		<div id="viewpro1"></div>
		<div id="cont1"></div>
		</form>
	</div>
	<? if($_REQUEST['id'] != '') { echo '<img width="1" height="1" src="'.$confValues['IMGSURL'].'/trans.gif" onLoad="getViewProfile(\''.strtoupper($_REQUEST['id']).'\', \'1\', \'\', \'\', \'\');"/>'; }?>
<!--
</form>
-->

<script>
function showProfile() {
	$("errorMsg").style.display = "none";
	var mIdInput = document.getElementById("mIdInput");
	var matriId  = mIdInput.value;
	var matriId1 = matriId.toUpperCase();
	if (matriId1 == null || matriId1 == "") {
		$("errorMsg").innerHTML = "Please enter a Member-Id";
		$("errorMsg").style.display = "block";
		return;
	}
	$("viewpro1").innerHTML='';
	getViewProfile(matriId1, "1", "", "", "");
}
</script>
<? unset($objCommon); ?>
