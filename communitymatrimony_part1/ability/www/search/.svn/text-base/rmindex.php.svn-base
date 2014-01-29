<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 14 Jul 2008
# End Date	: 17 Jul 2008
# Project		: MatrimonyProduct
# Module		: Search  Index
#====================================================================================================

error_reporting(E_ALL);
ini_set('dispaly_errors','1');

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/srchcontent.cil14");
include_once($varRootBasePath."/conf/privilege.cil14");
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == "logout"){ clearCookie(); }//if

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$varResultsURL	= '/search/'.$varPrivilegeIndex;

?>
<html>
<head>
	<title><?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - Find <?=ucfirst($arrDomainInfo[$varDomain][2])?> Brides & Grooms</title>
	<meta name="description" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony, the Perfect Place to search for a  <?=ucfirst($arrDomainInfo[$varDomain][2])?> partner. View 1000s of profiles from <?=ucfirst($arrDomainInfo[$varDomain][2])?> community. Register Now for Free!">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<script language="javascript">
	//<!--
	var cook_id = '<?=$sessMatriId?>', cook_publish='<?=$sessPublish?>',cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';
	//-->
	</script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
</head>
<body onselectstart="return false" ondragstart="return false" oncontextmenu="return false">
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<div class="innerdiv">
				<?php
					if($varAct != "")
						{
							$varAct	= preg_replace("'\.\./'", '', $varAct);
							if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
							else{ include_once('search.php'); }
						}else{ include_once('search.php'); }
				?>
				<br clear="all" />
			</div>
		</div>
	</div>
</div>
</center>
</body>
</html>