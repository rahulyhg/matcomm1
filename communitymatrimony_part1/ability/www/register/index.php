<?php
#====================================================================================================
# File			: index.php
# Author		: JeyaKumar
# Date			: 15-July-2008
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#********************************************************************************************************/
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES

include_once($varRootBasePath."/lib/clsDomain.php");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessUsername	= $varGetCookieInfo["USERNAME"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//CHECK AUTHETICATION
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == 'logout'){ clearCookie(); }//if
if($varAct == 'addedbasic'){ include_once('addedbasic.php'); }//if
if($_POST['intRegister'] == 'yes') { include_once('intermediateregister.php'); }//if

$varLogoName	= $arrDomainInfo[$varDomain][2];
$varLogoName	= $varLogoName ? $varLogoName : $varDomain;

?>
<html>
<head>
<title><?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - <?=ucfirst($arrDomainInfo[$varDomain][2])?> Brides & Grooms - Free Registration</title>
	<meta name="description" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - Free <?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimonial & Matrimonials - Add your profile now & get <?=ucfirst($arrDomainInfo[$varDomain][2])?> matches. <?=ucfirst($arrDomainInfo[$varDomain][2])?> Bride / Groom - Free Registration!">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" type="text/css" href="<?=$confValues['CSSPATH']?>/spellchecker.css">
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language=javascript src="<?=$confValues["JSPATH"];?>/common.js"></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language=javascript src="<?=$confValues["JSPATH"];?>/register.js"></script>
	<script language=javascript src="<?=$confValues["JSPATH"];?>/ability.js"></script>
	<script language=javascript src="<?=$confValues["JSPATH"];?>/ajax.js"></script>
	<script src="<?=$confValues["SERVERURL"];?>/spellchecker/cpaint/cpaint2.cil14.compressed.js" type="text/javascript"></script>
	<script src="<?=$confValues['JSPATH']?>/spell_checker_compressed.js" type="text/javascript"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/fontvar.js" ></script>
	<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/small.css" title="smf" />
	<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/medium.css" title="mdf" />
	<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/large.css" title="lrg" />

</head>
<body>
<center>

<div id="maincontainer">
	<div id="container">
		<div class="main">
			<div class="fleft logodiv" style="padding:10px 0px 10px 15px;"><a href="<?=$confValues['SERVERURL']?>" ><img src="<?=$confValues['IMGSURL']?>/logo/<?=$varLogoName?>_logo.gif" alt="communitymatrimony" border="0"/></a></div>
			<br clear="all" />
			<div class="linesep"><img src="images/trans.gif" height="1" width="1" /></div>
			
			<!-- <div class="fright padt5 clr2" style="height:30px;">
				<form name="fontvariant" action="GET">
					<div style="width:15px;height:20px;padding-top:3px;" class="fleft">
						<div style="width:15px;height:17px;" class="brdr tlcenter"><a id="small" href="javascript:;" class="clr1" onclick="smallfont();fontchg('sm');" value="smf" style="font-size:11px;">A</a></div>
					</div><div class="fleft" style="width:4px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="4" /></div>
					<div style="width:18px;height:20px;padding-top:2px;" class="fleft">
						<div style="width:17px;height:18px;" class="brdr tlcenter"><a id="med" href="javascript:;" class="clr1" onclick="medfont();fontchg('md');" value="mdf" style="font-size:14px;">A</a></div>
					</div><div class="fleft" style="width:4px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="4" /></div>
					<div style="width:20px;height:20px;" class="fleft">
						<div style="width:20px;height:18px !important;height:20px;padding-top:2px;" class="brdr tlcenter"><a id="large" href="javascript:;" class="clr1" onclick="larfont(); fontchg('lg');" value="lrg" style="font-size:17px;">A</a></div>
					</div>
				</form>
			</div> --><br clear="all">

		   <!-- Google Landing Header Starts-->
		   <? if (trim($_GET['source'])=='inorganic') { ?>
		   <div class="brdr fleft main">
			<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/googlelandimg.jpg"></div>
			<div class="fleft clr3 padl25"><br><br><font style="font:30px georgia,times new roman,arial;">Find a <?=$varUcDomain?> Life Partner<br><font class="clr" style="font-size:25px;">Register FREE & Receive FREE Matches</font></font>
			</div>
		   </div><div class="cleard"></div><br clear="all">
		   <? } ?>
		   <!-- Google Landing Header Ends -->
			<div class="innerdiv">
			<?php
				if ($varAct != "congrats") { include_once('../template/leftpanel.php'); }
			if($varAct != "")
			{
				$varAct	= preg_replace("'\.\./'", '', $varAct);
				if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
				else{ include_once('addbasic.php'); }
			}else{ include_once('addbasic.php'); }
			?><br clear="all">
			</div>
			<div class="linesep"><img src="images/trans.gif" height="1" width="1" /></div><br clear="all">
			<div class="footdiv">
				<center><div style="width:770px;"><font class="smalltxt clr"><?=$confPageValues["COPYRIGHT"]?></font></div></center>
			</div>
		</div>
	</div>
</div>
</center>

<? if(!empty($_SERVER['HTTP_REFERER'])) { $varOrgAct = $_REQUEST['act'] ? '/'.$_REQUEST['act'].'.php' : '';  ?>
	<iframe src="http://www.communitymatrimony.com/googlecamp/seo/seoorganictrack.php?ref=<?=urlencode($_SERVER['HTTP_REFERER'])?>&ip=<?=urlencode($_SERVER['REMOTE_ADDR'])?>&page=<?=$_SERVER['PHP_SELF'].$varOrgAct?>&matriid=<?=trim($varGetCookieInfo['MATRIID'])?>" width="0" height="0" frameborder="0"></iframe>

<?	} ?>

</body>
</html>
