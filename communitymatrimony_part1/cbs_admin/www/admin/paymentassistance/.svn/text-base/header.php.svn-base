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
<center>
<div style="padding-top: 2px;" >
	<!-- Header Top Level  -->
	<?php
	$varGetFolderLogo = "community";
	if($varGetFolder != "")
		$varGetFolderLogo = $varGetFolder;
	?>
		<div class="fleft" style="width:380px;" id="logo"><a href="<?php echo "http://www.".$varGetFolder."matrimony.com"; ?>" target="_blank"><img src="<?=$confValues['IMGSURL']?>/logo/<?=$varGetFolderLogo;?>_logo.gif" alt="Community Matrimony" border="0" height="40" width="380"></a></div>
		<div class="fright">
			<div class="fleft" style="padding-top: 30px;" id="login"></div>
				<div class="fleft" style="padding-top:61px;">
					<div class="fleft" style="padding-top:2px;padding-left:5px;padding-right:3px;"> <a href="<?=$confValues['SERVERURL']?>/admin/index.php?act=logout"  class="mediumtxt">Logout</a></div>
					<div class="fleft" style=";width:15;height:18px;"></div>
					<div class="fleft" style="padding-left:5px;"></div>
				</div>
		</div></div>
	<br clear="all">
	<!-- Header Top Level  -->
<div style="clear: both;padding-bottom:10px;border-top: 1px solid rgb(255, 255, 255);"></div>