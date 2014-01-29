<?php
#====================================================================================================
# File			: index.php
# Author		: Rohini
# Date			: 15-July-2008
#*****************************************************************************************************
# Description	:
#********************************************************************************************************/
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath."/conf/ip.cil14");

$varDomainName = $confValues['DOMAINNAME'];

if($varGetCookieInfo['MATRIID']!='') {
	$varOpenIp		= $varChat['OPENFIRE'];
	$varCasteId		= $confValues['DOMAINCASTEID'];
	$sessMatriId	= $varGetCookieInfo['MATRIID'];
	$sessGender		= $varGetCookieInfo['GENDER'];
	$sessGender		= $sessGender==1 ? 'M' : 'F';
	$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
	escapeexec("php logout_curl.php $varCasteId $sessMatriId $sessGender $varOpenIp",$varlogFile);

}//if

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

setrawcookie("browsertime",false,time() - 36, "/",$varDomainName);
setrawcookie("loginInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("profileInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("partnerInfo",false, time() - 36, "/",$varDomainName);
setrawcookie("messagesInfo",false, time() - 36, "/",$varDomainName);
setrawcookie("savedSearchInfo",false,time() - 36,"/",$varDomainName);
setrawcookie("lastViewProfile",false,time() - 36, "/",$varDomainName);
setrawcookie("requestReceivedInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("requestSentInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("listInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("viewsInfo",false,time() - 36, "/",$varDomainName);

$_COOKIE['loginInfo']			= '';
$_COOKIE['profileInfo']			= '';
$_COOKIE['partnerInfo']			= '';
$_COOKIE['messagesInfo']		= '';
$_COOKIE['savedSearchInfo']		= '';
$_COOKIE['lastViewProfile']		= '';
$_COOKIE['requestReceivedInfo']	= '';
$_COOKIE['requestSentInfo']		= '';
$_COOKIE['listInfo']			= '';
$_COOKIE['viewsInfo']			= '';
$varGetCookieInfo['MATRIID']	= '';

?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<script language="javascript" src="<?=$confValues['JSPATH']?>/login.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js"></script>
</head>
<body>
<center>
<!-- main body starts here -->
	<div id="container">
		<div style="width:772px;">
		<?php include_once($varRootBasePath.'/www/template/header.php'); ?>

<div class="logdivlt padt10 padb10 fleft">
	<div class="normtxt bld clr padl">Logged Out</div>
	<div class="smalltxt padtb10 padl">You have logged out from <?=$confValues['PRODUCTNAME']?>.com. Thank you for using our services!</div>
	<br clear="all">

	<center><div class="normtxt bld clr tlleft" style="padding-bottom:5px;width:380px;">Member Login</div>
	<div class="linesep" style="width:380px;"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" alt="" /></div></center>
	<br clear="all">

	<form name="frmLogin"  method="post" action="index.php">
		<input type="hidden" name="frmLoginSubmit" value="yes">
		<input type="hidden" name="act" value="logincheck">

		<div class="logdivlta smalltxt">User ID / E-mail</div>
		<div class="logdivltb">
			<input type="text" name="idEmail" id="idEmail" value="" 
				class="inputtext" tabindex="1" size="30" >
		</div>

		<div class="logdivlta smalltxt">Password</div>
		<div class="logdivltb">
			<input type="password" name="password" id="password" value="" class="inputtext" tabindex="2" onKeyUp="errorclear('password');" size="30"><br><span id="error" class="errortxt" style="padding: 0px 0px 0px 0px;display:block"><?=$varErrorMessage;?></span>
		</div>

		<div class="logdivlta">&nbsp;</div>
		<div class="logdivltb">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="128" height="1" />
			<input type="submit" value="Login" class="button" tabindex="3" onClick="return funLogin();">
		</div>
		<br clear="all">
	</form>
</div>

<div class="logdivrt padt10"><!-- <script language="javascript">ban = Math.round(Math.random() * total);document.write(banarr[ban]);</script> -->
<!-- begin ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 --><iframe src="http://c2.zedo.com/jsc/c2/ff2.html?n=570;c=2494;s=64;d=9;w=300;h=250" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=300 height=250></iframe><!-- end ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 --></div>

<div style="float:left;width:35px"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="35" height="1"></div><div style="float:left;width:425px" id='bannerdiv'></div>
<br clear="all">
<?php include_once($varRootBasePath.'/www/template/footer.php'); ?>
</div>
</div>
<!-- main body ends here -->
</center>
</body>
</html>
