<?php
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");

$action = $_REQUEST["act"];
$degree = $_REQUEST["degree"];
$imagename = $_REQUEST['imagename'];

$destpath = $varRootBasePath.'/www/membersphoto/tmp/'.$imagename;
if(!file_exists($destpath)) {
$sourcefile = $varRootBasePath.'/www/brightness_backup/'.$imagename;
}else{
$sourcefile = $destpath;
}

if($_REQUEST['act'] == "tmp" && file_exists($sourcefile)) {
		$imageinfo=getimagesize($sourcefile);
		switch($imageinfo['mime']) {     
			case "image/jpg": 
			case "image/jpeg":
			case "image/pjpeg": //for IE
				$src_img = imagecreatefromjpeg($sourcefile);
				break;	
			case "image/gif":
				$src_img = imagecreatefromgif($sourcefile);
				break; 
			case "image/png": 
			case "image/x-png": //for IE
				$src_img = imagecreatefrompng($sourcefile);
				break;
		}	
		$src_img = imagerotate($src_img,$degree,0);
		if($imageinfo['mime'] == "image/jpg" || $imageinfo['mime'] == "image/jpeg" || $imageinfo['mime'] == "image/pjpeg")
			imagejpeg($src_img,$destpath);
		elseif($imageinfo['mime'] == "image/gif")
			imagegif($src_img,$destpath);
		elseif($imageinfo['mime'] == "image/png" || $imageinfo['mime'] == "image/x-png")
			imagepng($src_img,$destpath);
		chmod($destpath,0777);
}else if($_REQUEST['act'] == "save") { 
	$destpath = $varRootBasePath.'/www/brightness_backup/'.$imagename;
	copy($sourcefile,$destpath);
	chmod($destpath,0777);
	unlink($sourcefile);
}
?>