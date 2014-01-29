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
$varLoginLabel		= 'Matrimony ID / E-mail';
if ($varCommunitId	== "") 
{
	$varLoginFileName		= 'cbslogincheck'; 
	$varForgotPwdFileName	= 'cbsforgotpasswordcheck'; 
	$varLoginLabel			= 'Matrimony ID';
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
if (($confValues["DOMAINCASTEID"]=='2500') || ($confValues["DOMAINCASTEID"]=='2503')) {
?>
<div class="alerttxt padb5 brdr" style="background-color:#EEEEEE;padding:10px;height:60px !important;height:80px;padding-bottom:5px;"><div class="fleft"><img src="<?=$confValues['IMGSURL']?>/info_img.gif" align="left" /></div><div class="fleft tljust" style="width:665px;padding-left:10px;"><?=$confValues['PRODUCTNAME']?>.com has recently upgraded its site design and functionality. As a result we have reset all the members Login ID and Password.<br>
Your New ID and Password has already been e-mailed to you at the e-mail address you had provided at the time of registration. Please check your e-mail for the login details.</div></div>
<?
}
?>

<div class="logdivlt padt10 padb10">
	<div id="forgotPassword" style="display:block;">
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
</div>	
<div class="logdivrt padt10">
<!-- begin ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 --><iframe src="http://c2.zedo.com/jsc/c2/ff2.html?n=570;c=2494;s=64;d=9;w=300;h=250" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=300 height=250></iframe><!-- end ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 --></div><br clear="all">

<SCRIPT LANGUAGE="JAVASCRIPT">document.frmforgetpwrequest.fp_idEmail.focus();</SCRIPT>
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
