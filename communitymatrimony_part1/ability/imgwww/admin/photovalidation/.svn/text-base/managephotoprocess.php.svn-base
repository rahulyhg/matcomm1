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
//ini_set('display_errors',1);
include_once($varRootBasePath."/conf/config.inc");// This includes error reporting functionalities
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsCropping.php");
$objCrop				= new Cropping;
$sessMatriId			= $_REQUEST['ID'];
$varImageName 			= $_GET['imageName'];
$varAction 				= $_GET['action'];
$varImg75				= $_GET['photo75'];
$varImg150				= $_GET['photo150'];

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varDomainPHPath		= $varRootBasePath."/www/membersphoto/".$varFolderName;
$varOriginalPath		= $varDomainPHPath."/backup/";
$varPhotoCrop800		= $varDomainPHPath."/crop800/";
$varPhotoCrop450		= $varDomainPHPath."/crop450/";
$varPhotoCrop150		= $varDomainPHPath."/crop150/";
$varPhotoCrop75			= $varDomainPHPath."/crop75/";
$varPhotoBupPath		=  $varPhotoCrop450;
$varImageArray			= explode(".",$varImageName);
$varFileExt 			= strtolower($varImageArray[1]);
//$varWatermark150 		= $varRootBasePath."/www/images/watermark.png";
$varWatermark150 		= $varRootBasePath."/www/images/watermark/".$varFolderName."_wm.png";
list($varPhotoWidth,$varPhotoHeight)	=	getimagesize($varOriginalPath.$varImageName);

switch($varAction){

	case 'crop': // additional required params: x, y, w, h
				$x = $_GET['x'];
				$y = $_GET['y'];
				$w = $_GET['w'];
				$h = $_GET['h'];
				
				
				if($varFileExt =="jpeg" || $varFileExt =="jpg") 
					$in = imagecreatefromjpeg($varPhotoBupPath.$varImageName);
				elseif($varFileExt=="gif")
					$in = imagecreatefromgif($varPhotoBupPath.$varImageName);
				elseif($varFileExt=="png")
					$in = imagecreatefrompng($varPhotoBupPath.$varImageName);
				
				$out = imagecreatetruecolor(75,75);
				imagecopyresampled($out, $in, 0, 0, $x, $y, 75, 75, $w, $h);
				
				if($varFileExt =="jpeg" || $varFileExt =="jpg")
					imagejpeg($out, $varPhotoCrop75.$varImg75, 75);
				elseif($varFileExt=="gif")
					imagegif($out, $varPhotoCrop75.$varImg75, 75);
				elseif($varFileExt=="png")
					$in = imagepng($out,$varPhotoCrop75.$varImg75);
				
				imagedestroy($in);
				imagedestroy($out);

				if (!is_numeric($x) || !is_numeric($y) || !is_numeric($w) || !is_numeric($h)) { exit; }
				
				if($varFileExt =="jpeg" || $varFileExt =="jpg") 
					$in = imagecreatefromjpeg($varPhotoBupPath.$varImageName);
				elseif($varFileExt=="gif")
					$in = imagecreatefromgif($varPhotoBupPath.$varImageName);
				elseif($varFileExt=="png")
					$in = imagecreatefrompng($varPhotoBupPath.$varImageName);
				
				$out = imagecreatetruecolor(150,150);
				imagecopyresampled($out, $in, 0, 0, $x, $y, 150, 150, $w, $h);
				
				if($varFileExt =="jpeg" || $varFileExt =="jpg") 
					imagejpeg($out,$varPhotoCrop150.$varImg150, 75);
				elseif($varFileExt=="gif")
					imagegif($out, $varPhotoCrop150.$varImg150, 75);
				elseif($varFileExt=="png")
					$in = imagepng($out,$varPhotoCrop150.$varImg150);
								
				imagedestroy($in);
				imagedestroy($out);
				$rand = rand(0,1000);	
				if(file_exists($varDestinationPath.$varImageName) && file_exists($varDestinationPath.$varImageName)) 
					echo "photo cropped successfully";
				else 
					echo "Cropping Falied";
				break;
		default : break;
}
?>
