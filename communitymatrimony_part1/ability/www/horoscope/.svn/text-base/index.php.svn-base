<?php
#================================================================================================================
   # Author 		: Senthilnathan
   # Project		: MatrimonyProduct
   # Filename		: index.php
#================================================================================================================
   # Description	: Horoscope Management
#================================================================================================================

$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

$sessMatriId	= $varGetCookieInfo['MATRIID'];
if($sessMatriId == ''){	header('Location:'.$confValues['SERVERURL']);exit;}

$act= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
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
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/horoscope.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/tools.js" ></script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div style="width: 772px;">
		<?php include_once("../template/header.php"); ?>
		<div id="horodiv">
		<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
		<div class="fleft middiv" style="padding: 0px 0px 0px 0px;">
		<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
		<div class="middiv-pad">
<?php
if($act != "")
{
	$act	= preg_replace("'\.\./'", '', $act);
	if(file_exists($act.'.php')){
		include_once($act.'.php');
	}
}//if
?>
</div><b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b></div>
</div>	
</div></div>
<?php include_once('../template/rightpanel.php'); ?>
</div>
<br clear="all">
<?php include_once('../template/footer.php'); ?>
</center>
</body>
</html>