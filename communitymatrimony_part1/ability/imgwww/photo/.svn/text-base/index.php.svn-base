<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: index.php
#================================================================================================================
   # Description	: PhotoManagement -  Photo index
#================================================================================================================

$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");

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
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/photoadd.js" ></script>
	<!-- <script language="javascript" src="<?=$confValues['JSPATH'];?>/tools.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/menutabber.js"></script> -->
<?if($act=='photoadd'){?>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/cropfunction.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/prototype.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/scriptaculous.js?load=builder,dragdrop"></script>
	<script language="javascript" src="<?=$confValues['JSPATH'];?>/cropper.js"></script>
	<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/cropper.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/ImageEditor.css">
<?}?>
</head>
<body <?if($act=='photoadd'){?>onload="funLoadCropTool();gotop()"<?}?>>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<?php include_once("../template/header.php"); ?>
			<div class="innerdiv">
				<?php include_once('../template/leftpanel.php'); ?>
				<?php
					if($act == "logout"){ clearCookie(); }//if
					if($act != "")
					{
						$act	= preg_replace("'\.\./'", '', $act);
						if(file_exists($act.'.php')){include_once($act.'.php'); }//if
						else{ 
							include_once('addphoto.php'); }//else
					}//if
					else{ include_once('addphoto.php'); }//else
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