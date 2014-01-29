<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-08-13
# Project	  : MatrimonyProduct
# Filename	  : createimage.php
#=====================================================================================================================================
# Description : create text to image file. This file is creating text name to image name.
#=====================================================================================================================================
// Create the image
$text		= $_GET["text"];
$namedisp	= $_GET["namedisp"];

$len		= strlen($text);
$wid		= $len * 7.5;
if($wid >= 230){
	$wid = 230;
}
if($namedisp == 1){
	$wid = 100;
}
$im = imagecreate($wid, 15);

// Create some colors
$white	= imagecolorallocate($im, 255, 255, 255);
//$grey = imagecolorallocate($im, 128, 128, 128);
//$grey = imagecolorallocate($im, 255,255,255);
//$black = imagecolorallocate($im, 0, 0, 0);
$black	= imagecolorallocate($im, 0, 0, 0);


//$font = 'arial.ttf';
//$font = '../sitedata/verdana.ttf';
// need to be changed beofre live 
$font	= 'verdana.ttf';

// Add some shadow to the text
//imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

// Add the text
imagettftext($im, 8, 0, 0, 11, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
?> 