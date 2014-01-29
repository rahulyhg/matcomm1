<?php
//FILE INCLUDES
include_once($varRootBasePath."/lib/clsDB.php");
class Photo extends DB {
	function funResizePhoto($argTempDir,$argImageName,$argHeight,$argWidth) {
		global $GETDOMAININFO;
		$varImgName 	= explode(".",$argImageName);
		$varExtension 	= strtolower($varImgName[1]);
		chmod($argTempDir.$argImageName,0777);
		if (!is_numeric($argWidth) || $argWidth < 1 || $argWidth > 2000 || !is_numeric($argHeight) || $argHeight < 1 || $argHeight > 2000) {
			exit; }
		list($varWidth, $varHeight) = getimagesize($argTempDir.$argImageName);
		//echo ini_get('memory_limit');
		//ini_set("memory_limit","20M");
		if($varExtension =="jpeg" || $varExtension =="jpg") {
			$varInputImage = imagecreatefromjpeg($argTempDir.$argImageName);
		} elseif($varExtension =="gif") {
			$varInputImage = imagecreatefromgif($argTempDir.$argImageName);
		}		
		$varImgName = explode(".",$argImageName);
		if($varWidth > $argWidth) {
			if($varWidth > $varHeight) {
				$varNewWidth = $varWidth/$argWidth;
				$varNewHeight = $varHeight/$varNewWidth;
				$varNewWidth = $argWidth;
			} else { 
				$varNewHeight = $varHeight/$argHeight; 
				$varNewWidth = $varWidth/$varNewHeight;
				$varNewHeight =$argHeight;
			}		
		}
		if($varWidth < $argHeight && $varHeight > $argHeight) {
				$varNewHeight = $varHeight/$argHeight; 
				$varNewWidth  = $varWidth/$varNewHeight;
				$varNewHeight =$argHeight;
				if($varNewHeight > $argHeight){
					$varNewHeight = $varHeight/$argHeight; 
					$varNewWidth = $varWidth/$varNewHeight;
					$varNewHeight =$argHeight;
				}	
		}
		$varOutputImage = imagecreatetruecolor($varNewWidth, $varNewHeight);
		if(imagecopyresampled($varOutputImage, $varInputImage, 0, 0, 0, 0, $varNewWidth, $varNewHeight, $varWidth, $varHeight)) {
		} else {
		}
		if($varExtension =="jpeg" || $varExtension =="jpg") {
			imagejpeg($varOutputImage, $argTempDir.$argImageName, 95);
		} elseif($varExtension =="gif") {
			imagegif($varOutputImage, $argTempDir.$argImageName, 95);		
		}
		imagedestroy($varInputImage);
		imagedestroy($varOutputImage);
	}

	function createPhotoName($argMatriId) {
		$arrLower = range('a','z');
		$arrUpper = range('A','Z');
		$arrStr = array_merge($arrLower,$arrUpper);
		srand();
		$varRandomTxt="";
		for ($i=0;$i<3;$i++) { // To generate the randomtext1
				$rand = rand (0,count($arrStr));		
				@$varRandomTxt.= $arrStr[$rand];
				array_splice($arrStr,$rand,1);	
		}
		$arrNumber = range(0,9);
		srand();
		$varRandNo="";
		for ($i=0;$i<3;$i++) { // To generate the randomnumbers1
			$rand = rand(0,count($arrNumber));		
			@$varRandNo.= $arrNumber[$rand];
			array_splice($arrNumber,$rand,1);	
		}
		return $argMatriId."_".$varRandomTxt."".$varRandNo;
	}
}