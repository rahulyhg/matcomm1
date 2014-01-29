<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 19  Sep 2008
# End Date	: 19  Sep 2008
# Project		: MatrimonyProduct
# Module		: Success Story Index
#====================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");

//VARIABLE DECLARATIONS
$varAct			= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$sessMatriId	= $varGetCookieInfo['MATRIID'];
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
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
</head>
<body>
<center>
<!-- main body starts here -->
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div style="width: 772px;">
		<?php include_once($varRootBasePath.'/www/template/header.php'); ?>
		<div id="horodiv">
		<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
		<div class="fleft middiv" style="padding: 0px 0px 0px 0px;">
		<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
		<div class="middiv-pad">
<?php
	if($varAct != "")
	{
		$varAct	= preg_replace("'\.\./'", '', $varAct);
		if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
		else{ include_once('success.php'); }
	}else{ include_once('success.php'); }
?>
</div><b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b></div>
</div>
</div><?php include_once($varRootBasePath.'/www/template/rightpanel.php'); ?></div>

</div>
<br clear="all">
<?php include_once($varRootBasePath.'/www/template/footer.php'); ?>
</div>
</div>
</div>
</center>
</body>
</html>