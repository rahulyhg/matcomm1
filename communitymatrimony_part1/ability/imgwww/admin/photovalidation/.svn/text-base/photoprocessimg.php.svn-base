<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photoprocessimg.php
#================================================================================================================
   # Description	: photo processing
#================================================================================================================
$DOCROOTPATH 		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath 	= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");// This includes error reporting functionalities
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsCropping.php");

$objCrop			= new Cropping;

$varMatriId			= $_GET['id'];
//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varDomainPHPath	= $varRootBasePath.'/www/membersphoto/'.$varFolderName;
$varPhotoBupPath	= $varDomainPHPath."/backup/";
$varPhotoCrop800	= $varDomainPHPath."/crop800/";
$varPhotoCrop450	= $varDomainPHPath."/crop450/";
$varPhotoCrop150	= $varDomainPHPath."/crop150/";
$varPhotoCrop75		= $varDomainPHPath."/crop75/";
$varImageName 		= $_GET['ph'];
$varImageName150	= $_GET['ph2'];
$varImageName75		= $_GET['ph3'];
$varImageArray		= explode(".",$varImageName);
$varFileExt 		= strtolower($varImageArray[1]);

$x = $_GET['x'];
$y = $_GET['y'];
$w = $_GET['w'];
$h = $_GET['h'];

if (!is_numeric($x) || !is_numeric($y) || !is_numeric($w) || !is_numeric($h)) { exit; }

if(file_exists($varPhotoCrop800.$varImageName)){
	$varSourcePhoto = $varPhotoCrop800.$varImageName;
} else {
	$varSourcePhoto = $varPhotoCrop450.$varImageName;
}
//Get 75*75
if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	$in = imagecreatefromjpeg($varSourcePhoto);
elseif($varFileExt=="gif")
	$in = imagecreatefromgif($varSourcePhoto);
elseif($varFileExt=="png")
	$in = imagecreatefrompng($varSourcePhoto);

$out = imagecreatetruecolor(75,75);
imagecopyresampled($out, $in, 0, 0, $x, $y, 75, 75, $w, $h);

if($varFileExt =="jpeg" || $varFileExt =="jpg")
	imagejpeg($out, $varPhotoCrop75.$varImageName75, 75);
elseif($varFileExt=="gif")
	imagegif($out, $varPhotoCrop75.$varImageName75, 75);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCrop75.$varImageName75);

imagedestroy($in);
imagedestroy($out);

//Get 150*150
if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	$in = imagecreatefromjpeg($varSourcePhoto);
elseif($varFileExt=="gif")
	$in = imagecreatefromgif($varSourcePhoto);
elseif($varFileExt=="png")
	$in = imagecreatefrompng($varSourcePhoto);

$out = imagecreatetruecolor(150,150);
imagecopyresampled($out, $in, 0, 0, $x, $y, 150, 150, $w, $h);

if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	imagejpeg($out,$varPhotoCrop150.$varImageName150, 150);
elseif($varFileExt=="gif")
	imagegif($out, $varPhotoCrop150.$varImageName150, 150);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCrop150.$varImageName150);
				
imagedestroy($in);
imagedestroy($out);
?>