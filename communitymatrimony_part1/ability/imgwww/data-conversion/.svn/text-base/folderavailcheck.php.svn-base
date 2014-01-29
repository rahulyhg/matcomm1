<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/domainlist.inc');

print "----------------------------------------------------------------------------------------------<BR>Photo Related Missing Folders:<br><br>";
foreach($arrFolderNames	as $k=>$v){
	
	$varFolderName = '/home/product/community/ability/www/membersphoto/'.$arrFolderNames[$k].'/crop800';
	if(!is_dir($varFolderName)){ print $varFolderName."<BR>"; }
	$varFolderName = '/home/product/community/ability/www/membersphoto/'.$arrFolderNames[$k].'/crop450';
	if(!is_dir($varFolderName)){ print $varFolderName."<BR>"; }
	$varFolderName = '/home/product/community/ability/www/membersphoto/'.$arrFolderNames[$k].'/crop150';
	if(!is_dir($varFolderName)){ print $varFolderName."<BR>"; }
	$varFolderName = '/home/product/community/ability/www/membersphoto/'.$arrFolderNames[$k].'/crop75';
	if(!is_dir($varFolderName)){ print $varFolderName."<BR>"; }

	
	for($i=0; $i<=9; $i++){
		for($j=0; $j<=9; $j++){
			$varFolderName = '/home/product/community/ability/www/membersphoto/'.$arrFolderNames[$k].'/'.$i.'/'.$j;
			 if(!is_dir($varFolderName)){
				 print $varFolderName."<BR>";
			 }
		}
	}
}

print "----------------------------------------------------------------------------------------------<BR>Backup Photo Related Missing Folders:<br><br>";
foreach($arrFolderNames	as $k=>$v){
	for($i=0; $i<=9; $i++){
		for($j=0; $j<=9; $j++){
			$varFolderName = '/home/product/community/ability/www/newphoto-backup/'.$arrFolderNames[$k].'/'.$i.'/'.$j;
			 if(!is_dir($varFolderName)){
				 print $varFolderName."<BR>";
			 }
		}
	}
}



print "----------------------------------------------------------------------------------------------<BR>Horoscope Related Missing Folders:<br><br>";
foreach($arrFolderNames	as $k=>$v){

	for($i=0; $i<=9; $i++){
		for($j=0; $j<=9; $j++){
			$varFolderName = '/home/product/community/ability/www/membershoroscope/'.$arrFolderNames[$k].'/'.$i.'/'.$j;
			 if(!is_dir($varFolderName)){
				 print $varFolderName."<BR>";
			 }
		}
	}
}


print "----------------------------------------------------------------------------------------------<BR>Pending Horoscope Related Missing Folders:<br><br>";
foreach($arrFolderNames	as $k=>$v){
	$varFolderName = '/home/product/community/ability/www/pending-horoscopes/'.$arrFolderNames[$k];
	 if(!is_dir($varFolderName)){
		 print $varFolderName."<BR>";
	 }
}

print "----------------------------------------------------------------------------------------------<BR>Missing Logos:<br><br>";
foreach($arrFolderNames	as $k=>$v){
	$varLogo	= '/home/product/community/ability/www/images/logo/'.$arrFolderNames[$k].'_logo.gif';
	if(!file_exists($varLogo)){ print $varLogo.'<BR>';}
}

print "----------------------------------------------------------------------------------------------<BR>Missing Watermarks:<br><br>";
foreach($arrFolderNames	as $k=>$v){
	$varWaterMark	= '/home/product/community/ability/www/images/watermark/'.$arrFolderNames[$k].'_wm.png';
	if(!file_exists($varWaterMark)){ print $varWaterMark.'<BR>';}
}
?>