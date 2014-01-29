<?php
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsPhoto.php");
include_once("photoresizefun.php");

$dblang	= strtoupper($GETDOMAININFO['domainnameshort']);
$lang	= strtolower($dblang);

$action			= $_REQUEST["action"];
$imagename		= $_REQUEST['imagename'];
$reload			= $_REQUEST['reload'];
$save			= $_REQUEST['save'];
$phnum			= $_REQUEST['phnum'];
$uid			= $_REQUEST['uid'];
$sessMatriId	= $_REQUEST['matid'];
$property		= $_REQUEST["property"];
$divno			= $_REQUEST["divno"];

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$imageextnarr		= explode(".",$imagename);
$fileextn 			= strtolower($imageextnarr[1]);

$varDomainPHPath	= $varRootBasePath."/www/membersphoto/".$varFolderName;	
$varBriBkpPath		= $varRootBasePath."/www/brightness_backup/"; //brightness changing backup
$varPhotoBkpPath	= $varDomainPHPath.'/backup/'; //original backup
$varCrop75Path		= $varDomainPHPath.'/crop75/';
$varCrop150Path		= $varDomainPHPath.'/crop150/';
$varCrop450Path		= $varDomainPHPath.'/crop450/';
$varHeight			= 450;

if($reload == 1) {
    copy($varCrop450Path.$imagename,$varBriBkpPath.$imagename);
}else if($save == 1){
	copy($varBriBkpPath.$imagename, $varCrop450Path.$imagename);

	$x = $_REQUEST['x'];
	$y = $_REQUEST['y'];
	$w = $_REQUEST['w'];
	$h = $_REQUEST['h'];
	if($x>=0 && $y>=0 && $w>0 && $h>0){
		
		if($fileextn =="jpeg" || $fileextn =="jpg") 
			$in = imagecreatefromjpeg($varBriBkpPath.$imagename);
		elseif($fileextn=="gif")
			$in = imagecreatefromgif($varBriBkpPath.$imagename);
		elseif($fileextn=="png")
			$in = imagecreatefrompng($varBriBkpPath.$imagename);

		$out = imagecreatetruecolor($w,$h);
		imagecopyresampled($out, $in, 0, 0, $x, $y, $w, $h, $w, $h);
		
		//Creating temp image for new 75 & 150 size photos
		$varTmp75ImgName	= $sessMatriId.'_TMP75_'.$phnum.'.'.$fileextn;
		$varTmp150ImgName	= $sessMatriId.'_TMP150_'.$phnum.'.'.$fileextn;
		
		@unlink($varBriBkpPath.$varTmp75ImgName);
		@unlink($varBriBkpPath.$varTmp150ImgName);

		if($fileextn =="jpeg" || $fileextn =="jpg")
			imagejpeg($out, $varBriBkpPath.$varTmp75ImgName, 100);
		elseif($fileextn=="gif")
			imagegif($out, $varBriBkpPath.$varTmp75ImgName, 100);
		elseif($fileextn=="png")
			imagepng($out,$varBriBkpPath.$varTmp75ImgName);

		imagedestroy($in);
		imagedestroy($out);

		//Copying temp image for 150
		copy($varBriBkpPath.$varTmp75ImgName, $varBriBkpPath.$varTmp150ImgName);

		//resizing, renaming and moving 75, 150 temp images
		$arrImageName = split('_', $imagename);
		
		$varImg75Name = $arrImageName[0].'_'.$arrImageName[1].'_NL_'.$arrImageName[3];
		$varImg150Name = $arrImageName[0].'_'.$arrImageName[1].'_TS_'.$arrImageName[3];
		
		reSizePhoto($varBriBkpPath,$varTmp75ImgName,75,75);
		reSizePhoto($varBriBkpPath,$varTmp150ImgName,150,150);
		
		copy($varBriBkpPath.$varTmp75ImgName, $varCrop75Path.$varImg75Name);
		copy($varBriBkpPath.$varTmp150ImgName, $varCrop150Path.$varImg150Name);

		@unlink($varBriBkpPath.$varTmp75ImgName);
		@unlink($varBriBkpPath.$varTmp150ImgName);
	}
	exit;

}else {
	if(file_exists($varBriBkpPath.$imagename)) {	
		$brightChagePath = $varBriBkpPath.$imagename;
	} 

	if($action =='add') {
		if($fileextn =="jpeg" || $fileextn =="jpg") 
			$in = imagecreatefromjpeg($brightChagePath);
		elseif($fileextn=="gif")
			$in = imagecreatefromgif($brightChagePath);
		elseif($fileextn=="png")
			$in = imagecreatefrompng($brightChagePath);		
		
		if($property =='brightadd') {
		  imagefilter($in, IMG_FILTER_BRIGHTNESS, 20);
		} else {
          imagefilter($in, IMG_FILTER_CONTRAST, 10);
		}

		if($fileextn =="jpeg" || $fileextn =="jpg") 
			imagejpeg($in,$brightChagePath);
		elseif($fileextn=="gif")
			imagegif($in, $brightChagePath);
		elseif($fileextn=="png")
			$in = imagepng($in,$brightChagePath);
	} else {
		if($fileextn =="jpeg" || $fileextn =="jpg") 
			$in = imagecreatefromjpeg($brightChagePath);
		elseif($fileextn=="gif")
			$in = imagecreatefromgif($brightChagePath);
		elseif($fileextn=="png")
			$in = imagecreatefrompng($brightChagePath);		
		
		if($property =='brightsub') {
			imagefilter($in, IMG_FILTER_BRIGHTNESS, -20);
		} else {
			imagefilter($in, IMG_FILTER_CONTRAST, -10);
		}

		if($fileextn =="jpeg" || $fileextn =="jpg") 
			imagejpeg($in,$brightChagePath);
		elseif($fileextn=="gif")
			imagegif($in, $brightChagePath);
		elseif($fileextn=="png")
			$in = imagepng($in,$brightChagePath);
	}
}
$viewpath = $confValues['IMAGEURL']."/admin1/photovalidation/adminphotobrightness.php?id=$sessMatriId&num=$phnum&divno=$divno&userid=$uid&rand=".time();

header("Cache-Control: no-cache, must-revalidate");
header("Expires: -1");
header("Location: $viewpath"); exit;
?>
