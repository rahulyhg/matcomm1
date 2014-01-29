<?php
//CONFIG VALUES
$confDomainName	= $confValues["DomainName"];
if ($confUserType=='' && $varAct!='login') { header("Location: index.php?act=login");}

$varCookieInfo		= $_COOKIE["adminLoginInfo"];
$varLoginPrivilege	= $_COOKIE["loginPrivilege"];
if (isset($varCookieInfo))
{
	$varCookieInfo	= split("=",str_replace("&","=",$varCookieInfo));
	$confUserType	= $varCookieInfo[1];
	$sessUserType	= $confUserType;
	$varPrivilegeInfo= array();

	$varPrivilegeInfo	= explode("^|", $varLoginPrivilege);

	$varCookieInfo['USERTYPE']		= trim($varPrivilegeInfo[0]);
	$varCookieInfo['USERNAME']		= trim($varPrivilegeInfo[1]);
	$varCookieInfo['VIEWCOUNTER']	= trim($varPrivilegeInfo[2]);
	$varCookieInfo['PHONEVIEW']		= trim($varPrivilegeInfo[3]);
	$varCookieInfo['PHOTOVIEW']		= trim($varPrivilegeInfo[4]);
	$varCookieInfo['HOROSCOPEVIEW']	= trim($varPrivilegeInfo[5]);
	$varCookieInfo['SENDMAIL']		= trim($varPrivilegeInfo[6]);
	$varCookieInfo['BRANCHID']		= trim($varPrivilegeInfo[7]);

} else { $confUserType = '';  }//else
//IF USER LOGOUT CLEAR THE COOKIE VALUES
if ($varAct=='Logout' || $varAct=='') {
	setcookie("adminLoginInfo",'', '0', '/',$confDomainName);
	$confUserType="";
	$confValues['sessUserType']	= '';
	$sessUserType				= '';
	$confUserType				= '';
}
?>
<!-- main header starts here -->
<!-- Header Top Level  -->
<div class="fleft" style="width:200px;padding-bottom:12px;" id="logo"><img src="<?=$confValues['IMGSURL']?>/logo/community_logo.gif" alt="Community Matrimony" border="0"></div>
<br clear="all">
<!-- Header Top Level  -->
<!-- Header First Level Menu Strip -->
<div class="topmenucurleft"></div>
<div style="float: left;">
<div id="topmenu"><?php include_once('home/top-menu.php'); ?></div></div>
<div class="topmenucurright"></div>
<!-- Header First Level Menu Strip -->
<div style="clear: both;padding-bottom:10px;"></div>
<!-- main header ends here -->
<!-- main table body starts here -->
<!-- left menu starts here -->
<?
if ($sessUserType !="") {
	$varAct = explode("-", $_REQUEST['act']);
		if($varAct[0] != "" && $varAct[0] != "Logout" && $varAct[0] != "login" && $varAct[0] != "forgotpassword" && $varAct[0] != "validate" && $varAct[0] != "paymenttracking")
		{ ?>
				
				<?  $varPaymentThroughViewProfile = $_REQUEST['tvprofile'];
				    if(!isset($varPaymentThroughViewProfile)){
						include('home/left-menu.php');
					}?>
				<div class="fleft middiv">
				<div class="fleft middiv">
				<div class="middiv-pad">
				<div class="fleft" style="background:#FFFFFF;border:4px solid #dbdbdb;">
		<? }	 else { ?>
				<div class="fleft" style="width:770px;">
				<div class="fleft" style="width:770px;">
				<div class="middiv-pad">
				<div class="fleft" style="background:#FFFFFF;border:4px solid #dbdbdb;">
<?
		}
}
?>
<!-- main body starts here -->
