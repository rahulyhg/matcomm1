<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPaidStatus	 	= $varGetCookieInfo["PAIDSTATUS"];
$sessPublish	 	= $varGetCookieInfo["PUBLISH"];

//Redirecting page if session is empty
if(trim($sessMatriId)=="") { header('Location:'.$confValues['SERVERURL']);}

$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
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
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/bubble-tooltip.css">
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/bubble-tooltip.js"></script>
	<script language="javascript">
	var cook_id = '<?=$sessMatriId?>',cook_un = '<?=$sessUserName?>', cook_paid = '<?=$sessPaidStatus?>', cook_publish='<?=$sessPublish?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url = '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url = '<?=$confValues["SERVERURL"]?>';
	</script>
</head>

<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<?php include_once("../template/header.php"); ?>
			<div class="innerdiv">
				<div class="fleft"><br><br>
				<?php
					if($varAct != "")
						{
							$varAct	= preg_replace("'\.\./'", '', $varAct);
							if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
							else{ include_once('msgshowall.php'); }
						}else{ include_once('msgshowall.php'); }
				?>
				</div>
				<?php include_once('../template/leftpanel.php'); ?>
				<br clear="all" />
			</div>
			<?php include_once('../template/footer.php'); ?>
		</div>
	</div>
</div>
</center>
</body>
</html>