<?
class Cropping {	
	function funImgWithAlpha( &$argSRC, &$argOvr, $argOvrX, $argOvrY, $argOvrW = false, $argOvrH = false){
    if( $argOvrW && $argOvrH )
        $argOvr = $this->funImgResizeAlpha( $argOvr, $argOvrW, $argOvrH ); 
    /* Noew compose the 2 images */
    imagecopy($argSRC, $argOvr, $argOvrX, $argOvrY, 0, 0, imagesx($argOvr), imagesy($argOvr) );    
    //imagecopymerge($argSRC, $argOvr, $argOvrX, $argOvrY, 0, 0, imagesx($argOvr), imagesy($argOvr) );    
	}
 
	function funImgResizeAlpha(&$argSRC, $argWidth, $argHeight)
	{
			/* create a new image with the new width and height */
			$varTempImg = imagecreatetruecolor($argWidth, $argHeight); 
			
			/* making the new image transparent */
			$background = imagecolorallocate($varTempImg, 0, 0, 0);
			ImageColorTransparent($varTempImg, $background); // make the new temp image all transparent
			imagealphablending($varTempImg, false); // turn off the alpha blending to keep the alpha channel
			
			/* Resize the PNG file */
			/* use imagecopyresized to gain some performance but loose some quality */
			//imagecopyresized($varTempImg, $argSRC, 0, 0, 0, 0, $argWidth, $argHeight, imagesx($argSRC), imagesy($argSRC));
			/* use imagecopyresampled if you concern more about the quality */
			imagecopyresampled($varTempImg, $argSRC, 0, 0, 0, 0, $argWidth, $argHeight, imagesx($argSRC), imagesy($argSRC));
			return $varTempImg;
	}
	 
	function funWaterImg($argImgSrc,$argImgWater,$argDesig,$varFileExt){
		if($varFileExt =="jpeg" || $varFileExt =="jpg") {
			@$photoImage = ImageCreateFromJPEG($argImgSrc);
		}elseif($varFileExt =="gif"){
			@$photoImage = ImageCreateFromGIF($argImgSrc);
		} elseif($varFileExt=="png") {
			@$photoImage = ImageCreateFrompng($argImgSrc);
		}	 	
		$varWatermark = imagecreatefrompng($argImgWater);
		$this->funImgWithAlpha($photoImage, $varWatermark, 10, 2,ceil(imagesy($photoImage)/10), imagesy($photoImage) ); 
		Imagejpeg($photoImage,$argDesig,75); 
		ImageDestroy($photoImage);
		ImageDestroy($varWatermark);
	}
}