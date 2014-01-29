<?php
#====================================================================================================
# Author 		: Senthilnathan
# Start Date	: 18sep2009
# End Date		: 18sep2009
# Project		: MatrimonyProduct
# Module		: Search  Results
#====================================================================================================
if($sessMatriId != ''){
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchresults.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/searchpaging.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchbasicview.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
<div class="rpanel fleft">
	<center>
		<div class="padt10">
			<div class="normtxt1 clr2 padb5 fleft"><font class="clr bld">Who viewed my phone number</font></div><br clear="all">
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
			<div class="smalltxt clr2 padt5 fleft" id="srtopbt">
				<?if($sessMatriId != ''){ ?>
				<font class="clr">Select : </font>
				<a class="clr1" href="javascript:;" onclick="chkAllTxt();">All</a> &nbsp|&nbsp; 
				<a class="clr1"  href="javascript:;" onclick="chkNoneTxt();">None</a> 
				<? } ?>
			</div><br clear="all"><br clear="all">
			<form method="post" name="buttonfrm">
			<div id="srinnertopbt">
				<?if($sessMatriId != ''){ ?>
				<div id="checkdiv" class="fleft" style="width:30px;">&nbsp;<div class="disnon"> <input type="checkbox" id="chk_all" name="chk_all" onclick="selectall(this.form, 'chk_all');"/> </div></div>
				<div id="mesgdiv" class="fleft">
					<div class="smalltxt clr2 padb5"><a class="clr1" onclick="sendListId('block','chk_all');">Block</a> &nbsp;|&nbsp; <a class="clr1" onclick="sendListId('shortlist','chk_all');">Favourites</a></div>
				</div><br clear="all">
				<div class="linesep rpanelinner"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
				<? } ?>
			</div>

			<!-- Error throw div -->
			<center>
			<div id="listalldiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:500px;">
			</div>
			</center>
			<!-- Error throw div -->

			<div id="serResArea">
				<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="getResult('MPHV');"/>
			</div><br clear="all"><br clear="all">
			</form>
			<div id="prevnext" class="padtb10">
			</div>
		</div>
	</center>
<br clear="all" />
</div>
<? }?>