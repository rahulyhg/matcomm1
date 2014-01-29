<?php
#================================================================================================================
# Author 		: S Rohini
# Start Date	: 2006-07-03
# End Date	: 2006-07-03
# Project		: MatrimonyProduct
# Module		: Home - Header
#================================================================================================================
//CONFIG VALUES
$confDomainName	= $confValues["DomainName"];
///echo $act;exit;

if ($confUserType=='' && $act!='login') { header("Location: index.php?act=login"); exit; }

//IF USER LOGOUT CLEAR THE COOKIE VALUES
if ($act=='Logout' || $act=='')
{
	setcookie("adminLoginInfo",'', '0', '/',$confDomainName);
	$confUserType="";
	$_SESSION["UserType"]		= '';
	$confValues['sessUserType']	= '';
	$sessUserType				= '';
	$confUserType				= '';
}
?>
 <link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
 <link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/usericons-sprites.css">
 <link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
 <link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
 <link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/messages.css">
 <link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">
<center>
<div style="padding-top: 2px;" >
	<!-- Header Top Level  -->
	<?php
	$varGetFolderLogo = "community";
    $varGetFolder = "support.community";
	?>
		<div class="fleft" style="width:380px;" id="logo">
			<a href='<?=$confValues['SERVERURL']?>/admin/paymentassistance/index.php'><img src="<?=$confValues['IMGSURL']?>/logo/<?=$varGetFolderLogo;?>_logo.gif" alt="Community Matrimony" border="0" height="40" width="380"></a>
		</div>
		<div class="fright">
			<div class="fright" style="padding-top: 30px;" id="login"></div>
				<div class="fright" style="padding-top:61px;">
					<div class="fright" style="padding-top:2px;padding-left:0px;padding-right:10px;"> <a href="<?=$confValues['SERVERURL']?>/admin/index.php?act=logout" ><b><font color="#DD6B6D">Logout</b></a></div>
					<div class="fleft" style="background:url(<?=$confValues['IMGSURL']?>/topnav-logout-icon.gif);width:15;height:18px;"></div>
					<div class="fleft" style="padding-left:5px;"></div>
				</div>
		</div>
</div>
	<br clear="all">
	<!-- Header Top Level  -->
<div style="clear: both;padding-bottom:10px;border-top: 1px solid rgb(255, 255, 255);"></div>
</center>