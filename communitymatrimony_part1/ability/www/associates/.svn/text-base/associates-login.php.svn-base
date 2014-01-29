<?php
#=============================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
?>

<div class="padtb10">
	<div class="normtxt1 bld clr">Payment Associates</div>
	<br clear="all">
<form name="frmAssociatesLogin" method="post" onSubmit="return Validate();" style="padding:0px;margin:0px;">
<input type="hidden" name="frmAssociatesLoginSubmit" value="yes">
<input type="hidden" name="act" value="associates-login">
<? if ($_POST["frmAssociatesLoginSubmit"]=="yes" && $varCheckPassword!="yes") { ?>
		<center>
			<div class="brdr alerttxt tlleft pad10" style="width:650px;background-color:#ebebeb;">
				Invalid username or incorrect password. Make sure that the "Caps Lock" or "A" light is switched off on your keyboard before trying again.
			</div>
		</center><br clear="all">
			<? }//if?>

		<div class="logdivlta smalltxt">Username</div>
		<div class="logdivltb">
			<input type="text" name="username" class="inputtext"><br><span id="errorname" class="errortxt"></span>
		</div>
		<br clear="all">
		<div class="logdivlta smalltxt">Password</div>
		<div class="logdivltb">
			<input type="password" name="password" class="inputtext">
			<br><span id="errorpwd" class="errortxt"></span>
		</div><br clear="all">
		<div class="logdivlta smalltxt">&nbsp;</div>
		<div class="logdivltb">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="78" height="1" />
			<input type="submit" value="Login" class="button">
		</div>
	</form>
	<br clear="all"><br clear="all">
	<div class="smalltxt clr tlleft" style="padding-left:145px;">Login problems? <a href="<?=$confValues['ServerURL']?>/site/index.php?act=feedback" class="clr1">Click here</a> to contact Support.</div>
</div>	