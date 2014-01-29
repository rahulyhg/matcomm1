<?php
function reSizePhoto($tempdirectory,$imageName,$inputheight,$inputwidth) {	
	$out_w = $inputwidth;
	$out_h = $inputheight;
	$img_name = explode(".",$imageName);
	$ext = strtolower($img_name[1]);
	chmod($tempdirectory.$imageName,0777);


	if (!is_numeric($out_w) || $out_w < 1 || $out_w > 2000 || !is_numeric($out_h) || $out_h < 1 || $out_h > 2000) {
		exit; }
	list($in_w, $in_h) = getimagesize($tempdirectory.$imageName);

	if($ext =="jpeg" || $ext =="jpg") {
		$in = imagecreatefromjpeg($tempdirectory.$imageName);
	} elseif($ext =="gif") {
		$in = imagecreatefromgif($tempdirectory.$imageName);
	}		
	if($in_w >= $inputwidth) {
		if($in_w > $in_h) {
			$width = $in_w/$inputwidth;
			$height = $in_h/$width;
			$width = $inputwidth;
		} else { 
			$height = $in_h/$inputheight; 
			$width = $in_w/$height;
			$height =$inputheight;
		}		
	}
	if($in_w <= $inputheight && $in_h >= $inputheight) {
			$height = $in_h/$inputheight; 
			$width = $in_w/$height;
			$height =$inputheight;
			if($height > $inputheight){
				$height = $in_h/$inputheight; 
				$width = $in_w/$height;
				$height =$inputheight;
			}	
	}
	$out = imagecreatetruecolor($width, $height);
	if(imagecopyresampled($out, $in, 0, 0, 0, 0, $width, $height, $in_w, $in_h)) {
	} else {
	}
	if($ext =="jpeg" || $ext =="jpg") {
		imagejpeg($out, $tempdirectory.$imageName,100);
	} elseif($ext =="gif") {
		imagegif($out, $tempdirectory.$imageName);		
	}
	imagedestroy($in);
	imagedestroy($out);
} 
?>