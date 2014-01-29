<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 19  Sep 2008
# End Date	: 19  Sep 2008
# Project		: MatrimonyProduct
# Module		: Success Story Popup
#====================================================================================================
$varRootPath		= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath		= $_SERVER['DOCUMENT_ROOT'];
//FILE INCLUDES
include_once($varRootPath."/conf/config.cil14");
//VARIABLE DECLARATIONS
$varAct					= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$sessMatriId				= $varGetCookieInfo['MATRIID'];

$varFileNo				= $_GET['fileno'];
$varFileName			= $varFileNo.".txt";

$varMyFile				= $varRootBasePath.'/success/stories/'.$varFileName;
if (file_exists($varMyFile)) 
{
	$varFp					= fopen($varMyFile, 'r');
	//if(!$fh) die ("Unable to open");
	$varData				= fread($varFp, filesize($varMyFile));
	fclose($varFp);
} 
else 
{
    $varMyFile			=  $varRootBasePath.'/success/stories/1.txt';
	$varFp					= fopen($varMyFile, 'r');
	//if(!$fh) die ("Unable to open");
	$varData = fread($varFp, filesize($varMyFile));
	fclose($varFp);
}

$varMyFile1				= $varRootBasePath.'/success/stories/count.txt';
$varFp1					= fopen($varMyFile1, 'r') or die ("Unable to open");
$varData1					= fread($varFp1, filesize($varMyFile1));
fclose($varFp1);
if($varFileNo<$varData1)
{
	$varPrev				= $varFileNo-1;
	if($varPrev==0)
	{$varPrev				= $varData1;}

	$varNext				= $varFileNo+1;
}
else
{
	if($varFileNo==$varData1)
	{$varPrev				= $varData1-1;$varNext	=	1;}
	else if($varFileNo==1)
	{$varPrev				= $varData1;$varNext	=	$varFileNo+1;}
	else{
	$varPrev				= $varFileNo-1;$varNext	=	$varFileNo+1;
	}
}
$varArr						= explode("|",$varData);
$varImgPath				= trim($varArr[0]).".jpg";
$varImgPath1			= $confValues['SERVERURL']."/success/bigimages/".$varImgPath;
$varSuccStory			= (trim($varArr[3])=='')?trim($varArr[4]):trim($varArr[3]);
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
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<?php //include_once($varRootBasePath."/www/template/commonjs.php"); ?>
</head>
<body>
<div id="dispcontent">
<div class="winpopborder"> 
<div class="winpoppad"> 
<div style="padding: 0px 0px 10px 25px;"><div style="width:540px;text-align:left;">
	<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/logo.gif"></div>
	<div class="fright" style="padding-top:60px;" id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
		<?if($varFileNo!=1) { ?>
		<div style="float:left;padding-top:2px;display:none;"><a href="javascript:void(0);" onclick="successstorynxt('<?=$varPrev?>');"><div class="useracticonsimgs prfnavlftoff fleft" style="margin: 3px 4px 0px 0px;"></div><div class="fleft smalltxt">Previous</div></a></div>
		<div style="float:left;padding-top:2px;"><a href="javascript:void(0);" onclick="successstorynxt('<?=$varPrev?>');"><div class="useracticonsimgs prfnavlfton fleft" style="margin: 3px 3px 0px 0px;"></div><div class="fleft smalltxt">Previous</div></a></div>
		<? } if($varFileNo!= $varData1) { ?>
		<div style="float:left;padding:2px 2px 2px 10px;display:none;"><a href="javascript:void(0);" onclick="javascript:successstorynxt('<?=$varNext?>');"><div class="useracticonsimgs prfnavlfton" style="margin: 3px 0px 0px 3px;"></div></a></div>
		<div style="float:left;padding:2px 0px 0px 10px;"><a href="javascript:void(0);" onclick="javascript:successstorynxt('<?=$varNext?>');"><div class="fleft smalltxt">Next</div><div class="useracticonsimgs prfnavrigon fleft" style="margin: 3px 0px 0px 3px;"></div></a></div>
		<? } ?>
	</div></div><br clear="all">
	<div class="borderline" style="height:1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="540"></div><br clear="all">

	<div class="fleft" style="width:260px;">
		<div style="padding: 0px 0px 10px 0px;"><b>Username</b><br>MU-<?= $varArr[0];?></div>
		<div class="vdotline1" style="width:240px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="240"></div>
		<div style="padding: 10px 0px 10px 0px;"><b>Bride</b><br><?= $varArr[1];?></div>
		<div class="vdotline1" style="width:240px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="240"></div>
		<div style="padding: 10px 0px 10px 0px;"><b>Groom</b><br><?= $varArr[2];?></div>
		<div class="vdotline1" style="width:240px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="240"></div>
	</div>
	<div class="fleft" style="width:270px;"><img src="<?= $varImgPath1;?>" style="border: 1px solid #A0A0A0;" border="1" height="200" width="270"></div><br clear="all">

	<div class="smalltxt content" style="padding: 10px 0px 0px 0px;"><?= stripslashes($varSuccStory);?> </div><br clear="all">
    <div class="fright" id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
	<?if($varFileNo!=1) { ?>
		<div style="float:left;padding-top:2px;display:none;"><a href="javascript:void(0);" onclick="successstorynxt('<?=$varPrev?>');"><div class="useracticonsimgs prfnavlftoff fleft" style="margin: 3px 4px 0px 0px;"></div><div class="fleft smalltxt">Previous</div></a></div>
		<div style="float:left;padding-top:2px;"><a href="javascript:void(0);" onclick="successstorynxt('<?=$varPrev?>');"><div class="useracticonsimgs prfnavlfton fleft" style="margin: 3px 3px 0px 0px;"></div><div class="fleft smalltxt">Previous</div></a></div>
		<? } if($varFileNo!= $varData1) { ?>
		<div style="float:left;padding:2px 2px 2px 10px;display:none;"><a href="javascript:void(0);" onclick="javascript:successstorynxt('<?=$varNext?>');"><div class="useracticonsimgs prfnavlfton" style="margin: 3px 0px 0px 3px;"></div></a></div>
		<div style="float:left;padding:2px 0px 0px 10px;"><a href="javascript:void(0);" onclick="javascript:successstorynxt('<?=$varNext?>');"><div class="fleft smalltxt">Next</div><div class="useracticonsimgs prfnavrigon fleft" style="margin: 3px 0px 0px 3px;"></div></a></div>
		<? } ?>
	</div></div><br clear="all">
	</div></div>
	</div>
  </div></div>
  </body>
  </html>