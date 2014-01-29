<?php
#====================================================================================================
# File			: login.php
# Author		: Dhanapal N
# Date			: 28-Feb-2008
#*****************************************************************************************************
# Description	: 
#********************************************************************************************************/

$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');

$varRedirect		= trim($_REQUEST['redirect']);
$varCategory		= trim($_REQUEST['category']);
$varCommunitId		= $arrDomainInfo[$varDomain][2];
$varLoginFileName	= 'logincheck';
$varForgotPwdFileName= 'forgotpassword';
$varLoginLabel		= 'User ID / E-mail';
if ($varCommunitId	== "") 
{
	$varLoginFileName		= 'cbslogincheck'; 
	$varForgotPwdFileName	= 'cbsforgotpasswordcheck'; 
	$varLoginLabel			= 'User ID';
}

if ($varCategory !="") {

	include_once($varRootBasePath.'/conf/payment.cil14');
	
	$varGateWay				= trim($_REQUEST['gateWay']);
	$varCountryCode			= trim($_REQUEST['countryCode']);
	$varSubmit				= trim($_REQUEST['frmPaymentSubmit']);
	$varDomainFolder		= trim($_REQUEST['domainFolder']);
	$varRedirectRedirectUrl	= trim($_REQUEST['paymentMode']);

	if ($varCountryCode !="" && $varSubmit !="") {
		$varRedirect = $$varRedirectRedirectUrl.'?category='.$varCategory.'&countryCode='.$varCountryCode.'&gateWay='.$varGateWay.'&domainFolder='.$varDomainFolder;
	} else { $varRedirect = $varRedirect.$varCategory; }

}
?>

<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>

<?
if ($_REQUEST["page"]=='rsscomm') { $varSplitRedirect	= split('~',$varRedirect);
?>
<div class="normtxt padb5 brdr" style="background-color:#EEEEEE;padding:10px;padding-bottom:5px;">To view <b><?=$varSplitRedirect[1]?></b> member's full profile, <a href="<?=$confValues['SERVERURL']?>/register/" class="clr1">click here to register</a> or login below.</div>
<?
}
?>

<div class="logdivlt padt10 padb10">
	<center><div class="normtxt bld clr tlleft" style="padding-bottom:5px;width:380px;">Member Login</div>
	<div class="linesep" style="width:380px;"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" alt="" /></div></center>
	<br clear="all">
	<form name="frmLogin" method="post" onSubmit="return funLogin();">
		<input type="hidden" name="frmLoginSubmit" value="yes">
		<input type="hidden" name="act" value="<?=$varLoginFileName?>">
		<input type="hidden" name="redirect" value="<?=$varRedirect?>">
		<input type="hidden" name="countryCode" value="<?=$varCountryCode?>">
		<input type="hidden" name="gateWay" value="<?=$varGateWay?>">
		<input type="hidden" name="domainFolder" value="<?=$varDomainFolder?>">
		<input type="hidden" name="communityId" value="<?=$varCommunitId?>">
		<div class="logdivlta smalltxt"><?=$varLoginLabel?></div>
		<div class="logdivltb">
			<input type="text" name="idEmail" value="" class="inputtext" size="30">
		</div>

		<div class="logdivlta smalltxt">Password</div>
		<div class="logdivltb">
			<input type="password" name="password" value="" class="inputtext" size="30">
			<br><span id="error" class="errortxt"><?=$varErrorMessage;?></span>
		</div>
		<div class="logdivlta smalltxt">&nbsp;</div>
		<div class="logdivltb">
			<div class="fleft"><a class="clr1 smalltxt" onclick="showhidediv('forgotPassword');">Forgot Password?</a></div>
			<div class="fleft">
				<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="38" height="1" />
				<input type="submit" value="Login" class="button">
			</div>
		</div>
	</form>
	<br clear="all">
	<div id="forgotPassword" style="display:none">
		<center><div class="normtxt bld clr tlleft" style="padding-bottom:5px;width:380px;">Forgot Password</div>
		<div class="linesep" style="width:380px;"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" alt="" /></div></center>
		<br clear="all">
		<center><div class="smalltxt tlleft" style="width:380px;">Please enter your Matrimony ID. We will e-mail your password to the e-mail address provided by you at the time of registration.</div></center>
		<br clear="all">  
		<form name="frmforgetpwrequest" action="index.php?act=<?=$varForgotPwdFileName?>" method="post">
			<input type="hidden" name="communityId" value="<?=$varCommunitId?>">
			<input type="hidden" name="frmForgotPasswordSubmit" value="yes" >
			<div class="logdivlta smalltxt">Matrimony ID</div>
			<div class="logdivltb">
				<input type="text" name="fp_idEmail" id="fp_idEmail" value="" class="inputtext" size="30">
					<br><span id="fpError" class="errortxt"></span>
			</div>
			<div class="logdivlta smalltxt">&nbsp;</div>
			<div class="logdivltb">
				<div class="fleft">
					<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="63" height="1" />
					<input type="button" value="Forgot Password" class="button" onclick="javascript:forgotPasswordValidate();">
				</div>
			</div>
		</form>
	</div> <!-- forgotPassword -->
	<br clear="all"><br>
	<center><div class="linesep" style="width:380px;"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" alt="" /></div></center>
	<div class="logdivlta">&nbsp;</div>
	<div class="logdivltb smalltxt clr">Not a member yet? <a href="/register/index.php" class="clr1">Click here</a> to register.</div>
</div>	
<div class="logdivrt padt10">
<!-- begin ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 --><iframe src="http://c2.zedo.com/jsc/c2/ff2.html?n=570;c=2494;s=64;d=9;w=300;h=250" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=300 height=250></iframe><!-- end ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 --></div>

<SCRIPT LANGUAGE="JAVASCRIPT">document.frmLogin.idEmail.focus();</SCRIPT>
<script>
function forgotPasswordValidate(){
	var community	= '<?=$varCommunitId?>';
	var label		= ' / E-mail';
	if (community=='' || community==null) { label=''; }
	var frm = document.frmforgetpwrequest;
	if ((frm.fp_idEmail.value).replace(' /\s+/','')=='' ) {
		document.getElementById('fpError').innerHTML = "Please enter Matrimony ID" + label;
		return false;
	}else {
		frm.submit();
		return true;
	}
}
</script>
