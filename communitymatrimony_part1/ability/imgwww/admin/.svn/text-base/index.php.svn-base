<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 20 Aug 2008
# End Date	: 20 Aug 2008
# Project		: MatrimonyProduct
# Module		: Admin  Index
#====================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/www/admin/includes/config.php");
include_once($varRootBasePath."/www/admin/includes/clsCommon.php");

//VARIABLE DECLARITION
$varAct	= $_REQUEST["act"];
if ($varAct=='login') { include_once('login-check.php'); }//if
ini_set('display_errors',1);

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
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/usericons-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/messages.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript">var imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';</script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js"></script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div style="width: 772px;">
		<?php
		include_once('header.php');
		$varAct = $_REQUEST['act'];
		if($varAct != "")
		{
			$varAct	= preg_replace("'\.\./'", '', $varAct);
			if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
			else{ include_once('login.php'); }
		}else{ include_once('login.php'); }
	?>
<br clear="all">
<?php include_once('footer.php'); ?>
</div>
</div>
</div>
</center>
</body>
</html>