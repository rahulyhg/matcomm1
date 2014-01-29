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

$varAct= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
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
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/horoscope.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/tools.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/menutabber.js"></script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<?php include_once("../template/header.php"); ?>
			<div class="innerdiv">
				<?php include_once('../template/leftpanel.php');
				echo '<div class="rpanel fleft">';
					if($varAct != "")
						{
							$varAct	= preg_replace("'\.\./'", '', $varAct);
							if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
							else{ include_once('addhoroscope.php'); }
						}else{ include_once('addhoroscope.php'); }
				?>
				</div>
				<br clear="all" />
			</div>
			<?php include_once('../template/footer.php'); ?>
		</div>
	</div>
</div>
</center>
</body>
</html>