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
	<?php //include_once($varRootBasePath."/www/template/commonjs.php"); ?>
</head>
<body>
<div class="fleft" style="text-align:center;">
	<div class="fleft" style="padding:20px 10px 0px 10px;"><a href="<?=$confValues['SERVERURL']?>/successstory/success.php"><img src="<?=$varImage	?>" width="121" height="81" border="0" alt="Our Success Stories" class="divborder"></a></div>
	<div class="fleft smalltxt" style="width:290px;padding-left:10px; padding-top:25px;">
		<!-- <div class="mediumtxt boldtxt clr3">One of our record number of success stories.</div>  -->
		<div class="rigpanel mediumtxt boldtxt"><?= $varText?></div>
		<div style="padding-top:5px;" class="mediumtxt"><i>"<?=$varSuccStory;?>"</i> <a href="<?=$confValues['SERVERURL']?>/successstory/success.php" class="clr1">>></a></div>			
		<div style="padding-top:5px;" class="smalltxt boldtxt clr3">Record Number Of Success Stories <br> - Limca Book of Records</div>
	</div> 
</div>