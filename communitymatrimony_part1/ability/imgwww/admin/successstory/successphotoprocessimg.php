<?php
#================================================================================================================
   # Author 		: A.Kirubasankar
   # Start - Date	: 29-Sep-2008
   # End - Date		: 
   # Project		: CommunityMatrimony
   # Module			: Successstory - Story Gallery
   # Filename		: photoprocessimg.php
#================================================================================================================
   # Description	: photo processing
#================================================================================================================
$DOCROOTPATH 		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath 	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");// This includes error reporting functionalities
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath."/lib/clsCropping.php");
include_once($varRootBasePath.'/www/admin/includes/config.php');

if($_COOKIE['adminLoginInfo']==''){
	$urllogin = $confValues['ServerURL'];
    header("location:$urllogin/admin/index.php?act=login");
}

//OBJECT DECLARTION
$objCrop	= new Cropping;
$objMaster	= new DB;
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

$objSlave	= new DB;
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

$varMatriId			= $_GET['id'];
$varSuccessId = $_REQUEST['sucid'];
//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varFields			= array('CommunityId');
$varCondition		= "WHERE Success_Id = ".$varSuccessId;
$varResult			= $objSlave->select($varTable['SUCCESSSTORYINFO'], $varFields, $varCondition, 0);
$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);

$domainName = str_replace("image.","",$_SERVER[SERVER_NAME]);
$arrPrefixDomainList1 = array_flip($arrPrefixDomainList);
$domainPrefix = $arrPrefixDomainList1[$domainName];
$arrMatriIdPre1 = array_flip($arrMatriIdPre);
$domainId = $arrMatriIdPre1[$domainPrefix];
$folderName = $arrFolderNames[$domainPrefix];
if(!$folderName){
$CommunityId=$arrSelectPhotoInfo['CommunityId'];
$folderNameId=$arrMatriIdPre[$CommunityId];
$folderName=$arrFolderNames[$folderNameId];
}

$varDomainPHPath	= $varRootBasePath.'/www/success/'.$folderName;

$varPhotoCropsmall	= $varDomainPHPath."/smallphotos/";
$varPhotoCropbig	= $varDomainPHPath."/bigphotos/";
$varPhotoCrophome	= $varDomainPHPath."/homephotos/";

$varImageName 		= $_GET['ph'];
$varImageName150	= $_GET['ph2'];
$varImageName75		= $_GET['ph3'];
$varImageArray		= explode(".",$varImageName);
$varImageNameArray = explode("/",$varImageName);
$varImageNameOnly = $varImageNameArray[5];
$varFileExt 		= strtolower($varImageArray[5]);

$x = $_GET['x'];
$y = $_GET['y'];
$w = $_GET['w'];
$h = $_GET['h'];


if (!is_numeric($x) || !is_numeric($y) || !is_numeric($w) || !is_numeric($h)) { exit; }
/*
if(file_exists($varPhotoCrop800.$varImageName)){
	$varSourcePhoto = $varPhotoCrop800.$varImageName;
} else {
	$varSourcePhoto = $varPhotoCrop450.$varImageName;
}
*/
if(file_exists($varImageName))
	$varSourcePhoto = $varImageName;
else
{
	exit;
}
//Get 60*60 - for home photos
if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	$in = imagecreatefromjpeg($varSourcePhoto);
elseif($varFileExt=="gif")
	$in = imagecreatefromgif($varSourcePhoto);
elseif($varFileExt=="png")
	$in = imagecreatefrompng($varSourcePhoto);

$out = imagecreatetruecolor(60,60);
imagecopyresampled($out, $in, 0, 0, $x, $y, 60, 60, $w, $h);

$varPhotoCrophomePath = $varPhotoCrophome.$varMatriId."_h.";
if($varFileExt =="jpeg" || $varFileExt =="jpg")
	imagejpeg($out, $varPhotoCrophomePath."jpg", 60);
elseif($varFileExt=="gif")
	imagegif($out, $varPhotoCrophomePath."gif", 60);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCrophomePath."png");

imagedestroy($in);
imagedestroy($out);


//Get Small photos 120*80
if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	$in = imagecreatefromjpeg($varSourcePhoto);
elseif($varFileExt=="gif")
	$in = imagecreatefromgif($varSourcePhoto);
elseif($varFileExt=="png")
	$in = imagecreatefrompng($varSourcePhoto);

$out = imagecreatetruecolor(120,80);
imagecopyresampled($out, $in, 0, 0, $x, $y, 120, 80, $w, $h);

$varPhotoCropsmallPath = $varPhotoCropsmall.$varMatriId."_s.";
if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	imagejpeg($out,$varPhotoCropsmallPath."jpg", 120);
elseif($varFileExt=="gif")
	imagegif($out, $varPhotoCropsmallPath."gif", 120);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCropsmallPath."png");
				
imagedestroy($in);
imagedestroy($out);


//Get Big photos 300*200
if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	$in = imagecreatefromjpeg($varSourcePhoto);
elseif($varFileExt=="gif")
	$in = imagecreatefromgif($varSourcePhoto);
elseif($varFileExt=="png")
	$in = imagecreatefrompng($varSourcePhoto);

$out = imagecreatetruecolor(300,200);
imagecopyresampled($out, $in, 0, 0, $x, $y, 300, 200, $w, $h);

$varPhotoCropbigPath = $varPhotoCropbig.$varMatriId."_b.";
if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	imagejpeg($out,$varPhotoCropbigPath."jpg", 300);
elseif($varFileExt=="gif")
	imagegif($out, $varPhotoCropbigPath."gif", 300);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCropbigPath."png");
				
imagedestroy($in);
imagedestroy($out);

$varImageNamePhoto = $varMatriId."_b.".$varFileExt;

	$argFields 				= array('Photo','Photo_Set_Status');
	$argFieldsValues		= array("'".$varImageNamePhoto."'",1);
	$argCondition			= "Success_Id='".$varSuccessId."'";
	$varUpdateId			= $objMaster->update($varTable['SUCCESSSTORYINFO'],$argFields,$argFieldsValues,$argCondition);
?>