<?php
//FILE INCLUDES
$varServerRoot	 = $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath = dirname($varServerRoot);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION VARIABLES
$varMatriId		 = $varGetCookieInfo['MATRIID'];
$varFile		 = $_GET['file'];
$varRequestFile	 = $varServerRoot.'/membershoroscope/'.$arrDomainInfo[$varDomain][2].'/'.$varMatriId{3}.'/'.$varMatriId{4}.'/'.$varFile;

if(file_exists($varRequestFile)) 
{
	$arrFileinfo	= split('\.', $varFile);
	header("Content-Type: ". $arrFileinfo[1]);
	header("Content-Length: ". filesize($varRequestFile));
	header("Content-Disposition: attachment; filename=\"horoscope.".$arrFileinfo[1]."\"");
	readfile($varRequestFile);
}else{	echo 'Not allowed to download.';}
?>