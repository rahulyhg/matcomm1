<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/domainlist.inc');
include_once($varBaseRoot."/lib/clsCropping.php");

ini_set('display_errors', 0);

//OBJECT DECLERATION
$objCrop	= new Cropping;

for($j=0; $j<1; $j++){
	$varFileName		= $varBaseRoot.'/www/data-conversion/FinalPhotosList'.$j.'.txt';
	$arrFileContents	= file($varFileName);
	$varPhotosCnt		= count($arrFileContents);

	for($i=0; $i<$varPhotosCnt; $i++){
		$varPhotoName		= trim($arrFileContents[$i],"\n");
		$arrPhotoinfo		= split('\.', $varPhotoName);
		$varMatriIdPrefix	= substr($varPhotoName, 0, 3);
		$varFolderName		= $arrFolderNames[$varMatriIdPrefix];

		$varWatermark 		= '';
		$varSourcePath		= '';
		$varWatermark 		= $varBaseRoot."/www/images/watermark/".$varFolderName."_wm.png";
		$varSourcePath		= $varBaseRoot.'/www/membersphoto/'.$varFolderName.'/'.$varPhotoName{3}.'/'.$varPhotoName{4}.'/'.$varPhotoName;
		
		if($varPhotoName!='' && file_exists($varSourcePath) && file_exists($varWatermark)){
			list($varPhotoWidth,$varPhotoHeight)	= getimagesize($varSourcePath);

			if($varPhotoWidth>=150 & $varPhotoHeight>=150 && ($arrPhotoinfo[1]=='jpg'|| $arrPhotoinfo[1]=='jpeg' || $arrPhotoinfo[1]=='gif' || $arrPhotoinfo[1]=='png')){
				$objCrop->funWaterImg($varSourcePath,$varWatermark,$varSourcePath,$arrPhotoinfo[1]);
			}
		}
	}

	//Move Files
	$varDate		= date("dmY");
	$varDateTime	= date("dmYHis");
	$varSourceDir	= $varRootPath.'/data-conversion';
	$varDesDir		= $varRootPath.'/data-conversion/backupfiles/firstTxtfiles1/old-'.$varDate;

	mkdir($varDesDir);
	copy($varSourceDir.'/pro-user-info'.$j.'.txt', $varDesDir.'/pro-user-info'.$j.'_'.$varDateTime.'.txt');	

	$varDesDir		= $varRootPath.'/data-conversion/backupfiles/watermark-finalphotos/'.$varDate;
	mkdir($varDesDir);
	copy($varSourceDir.'/FinalPhotosList'.$j.'.txt', $varDesDir.'/FinalPhotosList'.$j.'_'.$varDateTime.'.txt');
}

//UNSET OBJ
unset($objCrop);
?>