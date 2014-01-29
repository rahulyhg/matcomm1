<?php
#====================================================================================================
# Author 		: N Dhanapal
# Start Date		: 13 Feb 2008
# Project		: MatrimonyProduct
# Module		: Associates
#====================================================================================================
// /home/product/community/ability
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");

$varAct			= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$varLoginSubmit	= $_POST["frmAssociatesLoginSubmit"];
$varCookieInfo	= $_COOKIE["FranchiseeId"];
$varTopMenu		= 'yes';

if (isset($varCookieInfo)) {
	$varCookieInfo		= split("=",str_replace("&","=",$varCookieInfo));
	$varFranchiseeId	= $varCookieInfo[1];
}//if

if($varAct == "associates-logout" || $varAct == "register" || $varAct == "") { 
	$varFranchiseeId = ''; $varTopMenu='no'; 
	setrawcookie("FranchiseeId",false,time() - 36, "/",$confValues['DOMAINNAME']);
	$_COOKIE['FranchiseeId'] = '';

}

if ($varAct=='associates-login' && $varLoginSubmit =="yes") { include_once('login-check.php'); }//if

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
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/affiliates.js"></script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div style="width: 772px;">
		<?php 
			include_once($varRootBasePath.'/www/template/header.php'); 

			if ($varFranchiseeId !='' && $varTopMenu=='yes') {
				include_once($varRootBasePath.'/www/associates/top-menu.php'); 
			}
		
		?>
<?php
	if($varAct != "")
	{
		$varAct	= preg_replace("'\.\./'", '', $varAct);
		if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
		else{ include_once('affiliates.php'); }
	}else{ include_once('affiliates.php'); }
?>
<br clear="all">
<?php include_once($varRootBasePath.'/www/template/footer.php'); ?>
</div>
</div>
</div>
</center>
</body>


</html>
