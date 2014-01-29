<?php
#================================================================================================================
   # Author 		: Senthilnathan
   # Date			: 17-Apr-2009
   # Project		: MatrimonyProduct
   # Filename		: photodelete.php
#================================================================================================================
   # Description  : Delete the user photos
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDE FILES
include_once($varRootBasePath."/conf/config.cill4");
include_once($varRootBasePath."/conf/cookieconfig.cill4");

$varName		= $varGetCookieInfo["NAME"];
$varUserName	= $varGetCookieInfo["USERNAME"];
$varImageName	= $_GET['ph'];
$varImageName150= $_GET['ph2'];
$varImageName75	= $_GET['ph3'];
$varImageArray	= explode(".",$varImageName);
$varFileExt		= $varImageArray[1];
$varDomainPHPath= $varRootBasePath.'/www/membersphoto/'.$arrDomainInfo[$varDomain][2];
$varPhotoCrop450= $varDomainPHPath."/crop450/";
$varPhotoCrop150= $varDomainPHPath."/crop150/";
$varPhotoCrop75 = $varDomainPHPath."/crop75/";

$x = $_GET['x'];
$y = $_GET['y'];
$w = $_GET['w'];
$h = $_GET['h'];

$varError = '';
if(file_exists($varPhotoCrop450.$varImageName)){
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
	imagegif($out,$varPhotoCrop150.$varImageName150, 75);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCrop150.$varImageName150);

$out = imagecreatetruecolor(75,75);
imagecopyresampled($out, $in, 0, 0, $x, $y, 75, 75, $w, $h);

if($varFileExt =="jpeg" || $varFileExt =="jpg") 
	imagejpeg($out,$varPhotoCrop75.$varImageName75, 75);
elseif($varFileExt=="gif")
	imagegif($out,$varPhotoCrop75.$varImageName75, 75);
elseif($varFileExt=="png")
	imagepng($out,$varPhotoCrop75.$varImageName75);

imagedestroy($in);
imagedestroy($out);
}else{$varError	= 'Preview not available because this photo is deleted.';}
?>
<html>
<head>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
</head>
<script>
function save_ph(){
window.opener.savePhoto();
window.close();
}
</script>
<body>
<div>
	<div><img src="<?=$confValues['IMGSURL'];?>/logo.gif" width="200" height="80"></div><br clear="all">
	<div class="vdotline1" style="width: 370px; height: 1px; margin-top: 5px;"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" alt="" width="1" height="1"></div>
	<div class="fleft" style="margin: 10px 0px 0px 10px; width: 400px;">
		<div class="smalltxt"><b><?=$varName;?> - <font class="clr1"><?=$varUserName;?></font></b></div>
		<div style="padding-left: 100px;">
		<?php
			if($varError != '')
			echo '<span class="errortxt">'.$varError.'</span>';
			else
			echo '<img src="'.$confValues['PHOTOURL'].'/crop150/'.$varImageName150.'">';
		?>
		<br>
		</div>
		<div style="padding:10px 0px 0px 200px;"><input id="savebutton" value="Save" class="button" onclick="save_ph();" type="submit"></div>
	</div><br clear="all">
</div>
<br clear="all">
</body>
</html>