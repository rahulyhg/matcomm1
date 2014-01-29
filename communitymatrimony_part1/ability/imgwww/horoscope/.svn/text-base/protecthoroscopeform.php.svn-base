<? 

$varProtectPwd = 'no';
if ($varHoroscopeProtected=='1' && $varHoroscopeProtectedPassword !='') { $varProtectPwd = 'yes'; }

?>

<br clear="all"><div class="smalltxt bld fleft" style="padding-left:30px;">Protect Horoscope</div><br clear="all">
<?
	// if ($sessPaidStatus=='1') { 
	if ($varGetCookieInfo["PHOTOSTATUS"]=='1' && $varGetCookieInfo["PHONEVERIFIED"]=='1') {
	?>
<div class="smalltxt" style="padding:10px 30px; padding-bottom:0px;">If you do not want to show your horoscope to all members, you can protect it with a password. Only members with whom you share your password can view your horoscope.</div>
 	<form name="protectHoroscope" method="post" action="index.php">
		<input type="hidden" name="protectHoroscopeSubmit" value="yes" /><br>
		<input type="hidden" name="horoscopeAvailable" value="<?=$varHoroscopeStatus?>" />

		<center><div id="hormsgdiv" class="brdr pad10" style="width:450px;display:none;"><span id="horoconmsg" class="alerttxt"></span></div></center>

		<? if ($varProtectPwd!='yes') { ?>
		<div class="pfdivlt smalltxt fleft tlright">Enter <br>horoscope password</div>
		<div class="pfdivrt fleft tlleft" style="padding-top:10px;"><input type="password" size="25" class="inputtext" onblur="funProtectPwdChk();" name="horoscopepwd" value="" /><br><span id="horopwdspan" class="errortxt"></span></div><br clear="all">
		<div class="pfdivlt smalltxt fleft tlright">Confirm <br>horoscope password</div>
		<div class="pfdivrt fleft tlleft" style="padding-top:10px;"><input type="password" size="25" class="inputtext" onblur="funProtectConfPwdChk();" name="horoscopeconfpwd" value="" /><br><span id="horoconpwdspan" class="errortxt"></span></div><br clear="all">
		<center><div class="smalltxt clr2 tlleft tljust" style="width:500px;">Note: Your horoscope must be different from your profile and photo password.</div></center><? } ?><br clear="all">
		<div class="fright" style="padding-right:30px;"><input type="button" class="button" value="<?=$varProtectPwd=='yes' ? 'Un' : ''?>Protect"  onClick="<?=($varProtectPwd=='yes') ? 'funUnProtectHoroscope();' : 'funProtectHoroscope();';?>"/></div>
	</form>

<? } else { ?>

	<center><div class="smalltxt lh16" style="background:url(<?=$confValues['IMGSURL']?>/protecthoros.gif) no-repeat;width:500px;height:122px !important;height:152px;padding-top:30px;"><font class="normtxt bld">Only members who have added their photo and verified their phone number can use the protect horoscope feature<br><a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo" target="_blank" class="clr1">Click here to complete details</a></font></div></center>

<? } ?>