<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 19  Sep 2008
# End Date	: 19  Sep 2008
# Project		: MatrimonyProduct
# Module		: Success Story In Registration page
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
$varSuccStory			= $objCommon->limitText($varSuccStory, 8);
$varSuccStory			= stripslashes($varSuccStory);
//$shortstory=substr($shortstory,0,50);
$varImage					= $confValues['SERVERURL']."/success/smallimages/".trim($varId)."i.jpg";
$varText					= "$varBrideName & $varGroomName";

?>
<div class="fleft" style="padding:5px;">
	<div class="fleft"><img src="<?=$varImage?>" width="121" height="81" border="0" alt=""></div>
	<div class="fleft smalltxt" style="margin-left:5px; padding-top:5px; width:315px; text-align:center;">
		<div class="rigpanel mediumtxt boldtxt clr3"><?=$varText;?></div> 
		<div>"<?=$varSuccStory;?>"</div>
		<div style="padding-top:3px;" class="smalltxt boldtxt clr3"><!-- Record Number of Marriages - Limca Book Of Records --></div>
	</div>
</div>