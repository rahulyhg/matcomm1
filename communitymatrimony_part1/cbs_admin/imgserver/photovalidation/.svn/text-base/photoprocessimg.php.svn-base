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
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");// This includes error reporting functionalities
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsCropping.php");
include_once("photoresizefun.php");

$objCrop			= new Cropping;

$varMatriId			= $_GET['id'];
//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varDomainPHPath	= $varRootBasePath.'/www/membersphoto/'.$varFolderName;
$varPhotoBriBkpPath	= $varRootBasePath.'/www/brightness_backup/';
$varPhotoBupPath	= $varDomainPHPath."/backup/";
$varPhotoCrop800	= $varDomainPHPath."/crop800/";
$varPhotoCrop450	= $varDomainPHPath."/crop450/";
$varPhotoCrop150	= $varDomainPHPath."/crop150/";
$varPhotoCrop75		= $varDomainPHPath."/crop75/";
$varAction	 		= $_GET['act'];
$varImageName 		= $_GET['ph'];
$varImageName150	= $_GET['ph2'];
$varImageName75		= $_GET['ph3'];
$varImageArray		= explode(".",$varImageName);
$varFileExt 		= strtolower($varImageArray[1]);

$x = $_GET['x'];
$y = $_GET['y'];
$w = $_GET['w'];
$h = $_GET['h'];

if($varAction == 'actualcrop') {

	if (!is_numeric($x) || !is_numeric($y) || !is_numeric($w) || !is_numeric($h)) { exit; }

	$varSourcePhoto = $varPhotoBupPath.$varImageName;

	if($varFileExt =="jpeg" || $varFileExt =="jpg")
		$in = imagecreatefromjpeg($varPhotoBupPath.$varImageName);
	elseif($varFileExt=="gif")
		$in = imagecreatefromgif($varPhotoBupPath.$varImageName);
	elseif($varFileExt=="png")
		$in = imagecreatefrompng($varPhotoBupPath.$varImageName);

	$out = imagecreatetruecolor($w,$h);
	imagecopyresampled($out, $in, 0, 0, $x, $y, $w, $h, $w, $h);


	@unlink($varPhotoCrop450.$varImageName);

	if($varFileExt =="jpeg" || $varFileExt =="jpg")
		imagejpeg($out, $varPhotoCrop450.$varImageName, 100);
	elseif($varFileExt=="gif")
		imagegif($out, $varPhotoCrop450.$varImageName, 100);
	elseif($varFileExt=="png")
		imagepng($out,$varPhotoCrop450.$varImageName);

	imagedestroy($in);
	imagedestroy($out);

	reSizePhoto($varPhotoCrop450,$varImageName,450,450);

	copy($varPhotoCrop450.$varImageName, $varPhotoBriBkpPath.$varImageName);

	chmod($varPhotoCrop450.$varImageName, 0777);
	chmod($varPhotoBriBkpPath.$varImageName, 0777);
}
?>