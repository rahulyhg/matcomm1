<?php
#====================================================================================================
# File			: index.php
# Author		: Rohini
# Date			: 15-July-2008
#*****************************************************************************************************
# Description	: 
#********************************************************************************************************/
//ini_set("display_errors","1");
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

$varAct			= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$varCommunitId	= $arrDomainInfo[$varDomain][2];

if($varCommunitId == '' && $varAct == 'cbslogincheck'){ include_once('cbslogincheck.php'); }//if
if($varAct == 'logincheck'){ include_once('logincheck.php'); }//if
if($varAct == 'logout'){ clearCookie(); }//if


//CHECK COOKIE IF COOKIE IS AVAILABLE REDIRECT TO MY HOME OR RESPECTIVE PAGE..
$sessMatriId	= $varGetCookieInfo['MATRIID'];

if ($sessMatriId !="") {
	$varRedirect	= trim($_REQUEST['redirect']);
	$varRedirect	= $varRedirect ? $varRedirect : $confValues['SERVERURL'].'/profiledetail/';
	$varRedirect	= preg_replace('/~/', '&', $varRedirect);
	header("Location: ".$varRedirect);exit;
}

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
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div style="width: 772px;">
		<?php include_once($varRootBasePath.'/www/template/header.php'); ?>
		<?php
			if($varAct != "")
			{
				$varAct	= preg_replace("'\.\./'", '', $varAct);
				if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
				else{ include_once('login.php'); }
			}else{ include_once('login.php'); }
		?>
		<br clear="all">
<?php include_once($varRootBasePath.'/www/template/footer.php'); ?>
		</div>
	</div>
</div>
</center>
</body>
</html>