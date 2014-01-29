<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: deleteconfirmation.php
#================================================================================================================
   # Description	: display delete confirmation message
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
//SESSION VARIABLES
$varMatriId			= $_REQUEST['ID'];
if ($varMatriId != '' && $_REQUEST['PNO'] != ''){
	//$varStr	= "window.parent.document.getElementById('voicedemo').src='photodelete.php?action=delete&PNO=".$_REQUEST["PNO"].";";
?>
<script language="javascript"  src="<?=$confValues['SERVERURL'];?>/template/commonjs.php" ></script>
<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>
<script language="javascript"  src="<?=$confValues['JSPATH'];?>/adminphotoadd.js" ></script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<div id="block">
	<form name="frmDeleteConfirmation" method="post" >
	<input type = "hidden" name="frmDeleteVideoSubmit" value="yes">
		<div style="padding-left:10px;width:400px;">
			<div ><font class="mediumtxt boldtxt clr3">Delete Photo</font></div>
				<div class="divborder fleft" style="width:400px;">
					<div>
						<div class="fleft" style="padding-top:15px;padding-left:15px;"><font class="smalltxt">Are You Sure Want To Delete This Photo ?</font>&nbsp;&nbsp;&nbsp;
							<input type="button" name="Yes" value="Yes" onclick="javascript:funDeletePhoto(<?=$_REQUEST['PNO'];?>,'<?=$_REQUEST['ID'];?>');"  class="button">
							<input type="button" name="No" value="No" onclick="window.parent.document.getElementById('divphotodelete').style.display='none';" class="button" >
						</div><br clear="all">
						<div class="bheight"></div>
					</div>
				</div>
			</div>
		 </div>
	</form>
</div>
<?
}
?>