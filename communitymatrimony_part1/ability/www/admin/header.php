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

	$varSplitPrivilege	= explode("^|", $varLoginPrivilege);

	$varPrivilegeInfo['USERTYPE']		= trim($varSplitPrivilege[0]);
	$varPrivilegeInfo['USERNAME']		= trim($varSplitPrivilege[1]);
	$varPrivilegeInfo['VIEWCOUNTER']	= trim($varSplitPrivilege[2]);
	$varPrivilegeInfo['PHONEVIEW']		= trim($varSplitPrivilege[3]);
	$varPrivilegeInfo['PHOTOVIEW']		= trim($varSplitPrivilege[4]);
	$varPrivilegeInfo['HOROSCOPEVIEW']	= trim($varSplitPrivilege[5]);
	$varPrivilegeInfo['SENDMAIL']		= trim($varSplitPrivilege[6]);
	$varPrivilegeInfo['BRANCHID']		= trim($varSplitPrivilege[7]);

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
<div class="fleft" style="width: 200px;" id="logo"><img src="<?=$confValues['IMGSURL']?>/logo/community_logo.gif" alt="Community Matrimony" border="0"></div>
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
				<? include('home/left-menu.php'); ?>
				<div class="fleft middiv">
				<div id="rndcorner" class="fleft middiv">
				<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
				<div class="middiv-pad">
				<div class="fleft" style="background:#FFFFFF">
		<? }	 else { ?>
				<div class="fleft" style="width:770px;">
				<div id="rndcorner" class="fleft" style="width:770px;">
				<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
				<div class="middiv-pad">
				<div class="fleft" style="background:#FFFFFF">
<?
		}
}
?>
<!-- main body starts here -->
