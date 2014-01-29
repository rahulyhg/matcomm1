<?php
#====================================================================================================
# Author 		: Senthilnathan.M
# Start Date	: 21 Jul 2008
# End Date		: 21 Jul 2008
# Project		: MatrimonyProduct
# Module		: Search  Results
#====================================================================================================
$varListType	= ($_REQUEST['listtype']=='')?'SL':$_REQUEST['listtype'];

$varDeleteLink	= ($varListType=='SL')? 'Remove from favourites' : 'Unblock';
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhomeresult.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
<div class="rpanel fleft">
	<center>
			<div class="normtxt1 clr2 padb5 fleft padl"><font class="clr bld">Lists</font>  
			<!-- <a class="clr1 normtxt" href="<?=$confValues['SERVERURL']?>/search/">[Modify]</a> --></div><br clear="all">
			<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
			<div class="smalltxt clr2 padt5 padl"><div class="fleft"><font class="clr">Show : </font><a id="msgsl" class="clr1" href="<?=$confValues['SERVERURL']?>/list/">Favourites</a> &nbsp;|&nbsp; <a id="msgbk" class="clr1" href="<?=$confValues['SERVERURL']?>/list/index.php?listtype=BK">Blocked</a></div><div id="del_div" class="fright"><a id="listrequests" class="clr1" onclick="funListDeleteConfirm();"><div id='showLink'><?=$varDeleteLink;?></div></a></div></div><br clear="all">

			<form method="post" name="buttonfrm">
			<input type="hidden" id="purp" name="purp" value="<?=$varListType?>">
			<div id="errorDivConfirm" style="display:none;background-color:#ffffff;width:540px;">
				Are you sure you want to delete these members from your List?
				<input type="button" class="button" value="Yes" onClick="funListDelete();">
				<input type="button" class="button" value="No" onClick="document.getElementById('errorDiv').style.display='none'">
			</div><br clear="all">
			
			<center><div id="errorDiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:500px;">
			</div></center><br clear="all">
			
			<div id="msgResults">
				<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="funListMain('<?=$varListType?>');"/>
			</div>
			</form>
			<div id="prevnext" class="padtb10">
			</div>
	</center>
</div>
<br clear="all" />