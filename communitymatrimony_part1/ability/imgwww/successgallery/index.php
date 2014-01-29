<?php
#====================================================================================================
# Author 		: Prakash N
# Start Date	: 22 Sep 2009
# End Date		: 
# Project		: MatrimonyProduct
# Module		: Site - Static pages Index
#====================================================================================================
//ini_set("display_errors","1");
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/srchcontent.cil14");
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == "logout"){ clearCookie(); }//if

$titletag = ucfirst($arrDomainInfo[$varDomain][2])." Matrimony - Exclusive Matrimony Portal for " .ucfirst($arrDomainInfo[$varDomain][2])." Brides & Grooms";
		$metadesc = ucfirst($arrDomainInfo[$varDomain][2])." Matrimony -  No.1 ".ucfirst($arrDomainInfo[$varDomain][2])." Matrimony Portal. View 1000s of ".ucfirst($arrDomainInfo[$varDomain][2])." Brides & Grooms. Register Now for Free! & get ".ucfirst($arrDomainInfo[$varDomain][2])." matches";
?>
<html>
<head>
	<title><?=$titletag?></title>
	<meta name="description" content="<?=$metadesc?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js"></script>
	<script language="JavaScript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/successgallery.js" ></script>
	
</head>
<body>

<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<?php include_once("../template/header.php"); ?>
			<div class="innerdiv">
				<?php include_once('../template/leftpanel.php'); ?>
				<?php
					if($varAct != "")
						{
							$varAct	= preg_replace("'\.\./'", '', $varAct);
							if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
							else{ include_once('success_gallery.php'); }
						}else{ include_once('success_gallery.php'); }
				?>
				<br clear="all" />
			</div>
			<?php include_once('../template/footer.php'); ?>
		</div>
	</div>
</div>
</center>
</body>
</html>