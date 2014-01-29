<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photoprocessimg.php
#================================================================================================================
   # Description	: photo processing
#================================================================================================================
$varRootBasePath 	= dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath."/conf/config.cill4");
include_once($varRootBasePath."/conf/cookieconfig.cill4");
include_once($varRootBasePath."/lib/clsCropping.php");
include_once($varRootBasePath."/conf/dbinfo.cill4");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARATION
$objMasterDB	= new DB;

//CONNECTION DECLARATION
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//Variable Declaration
$varMatriId		= $varGetCookieInfo['MATRIID'];
$varPhotoNo		= $_GET['phnum'];
$varPhDesc		= $_GET['photodesc'];

if($varPhotoNo>0 && $varMatriId!=''){
$varPhDesc		= preg_match("/[^@]/", $varPhDesc) ? $varPhDesc : '';
$varFields		= array('Description'.$varPhotoNo);
$varFieldValues	= array("'".mysql_escape_string($varPhDesc)."'");
$varCondition	= " MatriId = ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);
}

//UNSET OBJ
$objMasterDB->dbClose();
unset($objMasterDB);

//CROPPING AREA
$objCrop				= new Cropping;
$varDomainPHPath		= $varRootBasePath.'/www/membersphoto/'.$arrDomainInfo[$varDomain][2];
$varPhotoBupPath		= $varDomainPHPath."/backup/";
$varPhotoOriPath		= $varDomainPHPath."/original/";
$varPhotoCrop800		= $varDomainPHPath."/crop800/";
$varPhotoCrop450		= $varDomainPHPath."/crop450/";
$varPhotoCrop150		= $varDomainPHPath."/crop150/";
$varPhotoCrop75			= $varDomainPHPath."/crop75/";
$varImageName 			= $_GET['ph'];
$varImageName150		= $_GET['ph2'];
$varImageName75			= $_GET['ph3'];
$varImageArray			= explode(".",$varImageName);
$varFileExt 			= strtolower($varImageArray[1]);
$varWatermark150 		= $varRootBasePath."/www/images/watermark.png";
list($varPhotoWidth,$varPhotoHeight)	=	getimagesize($varPhotoBupPath.$varImageName);
if(file_exists($varPhotoBupPath.$varImageName)) {
	if ($varPhotoWidth > 800 || $varPhotoHeight > 600){
		if(!file_exists($varPhotoCrop800.$varImageName)) 
			copy($varPhotoBupPath.$varImageName,$varPhotoCrop800.$varImageName);
	}
	if(!file_exists($varPhotoCrop450.$varImageName)) 
		copy($varPhotoBupPath.$varImageName,$varPhotoCrop450.$varImageName);
} 
$x = $_GET['x'];
$y = $_GET['y'];
$w = $_GET['w'];
$h = $_GET['h'];


if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	$in = imagecreatefromjpeg($varPhotoCrop450.$varImageName);
elseif($varFileExt=="gif")
	$in = imagecreatefromgif($varPhotoCrop450.$varImageName);
elseif($varFileExt=="png")
	$in = imagecreatefrompng($varPhotoCrop450.$varImageName);

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

if (!is_numeric($x) || !is_numeric($y) || !is_numeric($w) || !is_numeric($h)) { exit; }

if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	$in = imagecreatefromjpeg($varPhotoCrop450.$varImageName);
elseif($varFileExt=="gif")
	$in = imagecreatefromgif($varPhotoCrop450.$varImageName);
elseif($varFileExt=="png")
	$in = imagecreatefrompng($varPhotoCrop450.$varImageName);

$out = imagecreatetruecolor(150,150);
imagecopyresampled($out, $in, 0, 0, $x, $y, 150, 150, $w, $h);

if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	imagejpeg($out,$varPhotoCrop150.$varImageName150, 75);
elseif($varFileExt=="gif")
	imagegif($out, $varPhotoCrop150.$varImageName150, 75);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCrop150.$varImageName150);

imagedestroy($in);
imagedestroy($out);
//UNSET OBJ
unset($objCrop);
?>