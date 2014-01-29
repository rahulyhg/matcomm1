<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 19  Sep 2008
# End Date	: 19  Sep 2008
# Project		: MatrimonyProduct
# Module		: Success Story In Rightpanel
#====================================================================================================
$varRootPath			= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath		= $_SERVER['DOCUMENT_ROOT'];
//FILE INCLUDES
include_once($varRootPath."/conf/config.cil14");
include_once($varRootPath."/lib/clsCommon.php");
//Object Declaration
$objCommon = new clsCommon;
//VARIABLE DECLARATIONS
$varAct					= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$sessMatriId				= $varGetCookieInfo['MATRIID'];

$varCntFile				= $varRootBasePath."/success/stories/count.txt";
$varFp						= fopen($varCntFile,"r");
$varFileTxt				= fread($varFp,filesize($varCntFile));
$varCnt						= explode("\n",$varFileTxt);
$varUpper					= $varCnt[0]-1;
fclose($varFp);
$varLower				= 1;
$varRandNum			= rand($varLower,$varUpper);
$varFile						= $varRootBasePath."/success/stories/".$varRandNum.".txt";
if(!(file_exists($varFile))) 
{
	$varFile					= $varRootBasePath."/success/stories/1.txt";
	$varRandNum		= 2;
}
$varFp						= fopen($varFile,"r");
$varFileTxt				= fread($varFp,filesize($varFile));
$varArr						= explode("\n",$varFileTxt);
$varLine					= $varArr[0];
$varArr2					= explode("|",$varLine);
$varId						= $varArr2[0];
$varId						= trim($varId);
$varBrideName			= ucfirst($varArr2[1]);
$varGroomName		= ucfirst($varArr2[2]);
$varSuccStory			= (trim($varArr2[3])=='')?trim($varArr2[4]):trim($varArr2[3]);
$varSuccStory			= $objCommon->limitText($varSuccStory, 10);
$varSuccStory			= stripslashes($varSuccStory);
//$shortstory=substr($shortstory,0,50);
$varImage					= $confValues['SERVERURL']."/success/smallimages/".trim($varId)."i.jpg";
$varText					= "$varBrideName & $varGroomName";
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
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
</head>
<body>
<div id="successrightdiv">
<div style="padding-top:3px; text-align:center;">
	<div class="smalltxt"><b><?=$varText;?></b></div>
	<div style="margin-top:10px;"><a href="javascript:void(0);"><img src="<?=$varImage?>" onclick="successstorypop('<?=$varRandNum?>');" width="121" height="81" alt="Our Success Stories"></a></div>
	<div class="smalltxt" style="margin-top:10px;">"<?=$varSuccStory;?>" <a href="<?=$confValues['SERVERURL']?>/successstory/index.php?act=success" class="clr1" target="_blank">>></a> </div>
</div>
</div>
<!-- <div style="width:150px;padding:10px 0px 0px 10px;"><div class="vdotline1"  style="text-align:center;"></div></div>
<div style="padding:5px 0px 15px 0px; text-align:center;"><a href="<?=$confValues['SERVERURL']?>/successstory/index.php?act=success&postpg=1" target="_blank" class="smalltxt boldtxt" style="text-decoration:none;line-height:12px;">Share your Success Story<br>& Get an Attractive Gift!</a></div> -->
</body>
</html>