<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 04-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: 
#================================================================================================================
   # Description	: This file used to add the cropped photo of the user.
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
$varDomainPHPath	= $varRootBasePath."/www/membersphoto/".$arrDomainInfo[$varDomain][2];
$varPhotoCrop150	= $varDomainPHPath."/crop150/";
$varPhotoCrop75		= $varDomainPHPath."/crop75/";
$varPhotoCrop450	= $varDomainPHPath."/crop450/";
$varMatriId			= trim($_GET['ID']);
$varImageName 		= trim($_GET['photo450']);
$varAction			= trim($_REQUEST["action"]);
$varPhotoNo			= trim($_REQUEST['PNO']);
if($varMatriId != '' && $varPhotoNo >= 1 && $varPhotoNo <= 10  && file_exists($varPhotoCrop450.$varImageName)) { 
	rename($varPhotoCrop75.$varImageName,$varPhotoCrop75.trim($_GET['photo75']));
	rename($varPhotoCrop150.$varImageName,$varPhotoCrop150.trim($_GET['photo150']));
}
?>