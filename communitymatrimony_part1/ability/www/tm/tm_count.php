<?
#=====================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-01
# Project	  : MatrimonyProduct
# Filename	  : .php
#=====================================================================================================================
# Description : 
#=====================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsGetCount.php');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/domainlist.inc');

//REQUEST VARIABLES
$varMatriId	= strtoupper($_REQUEST['id']);

//Variable Declaration
$arrFlippedMatriIdPre	= array_flip($arrMatriIdPre);
$varPrefix				= substr($varMatriId,0,3);
$varCommunityId			= $arrFlippedMatriIdPre[$varPrefix];

//OBJECT DECLARATION
$objDomain	= new domainInfo;
$objCount	= new GetCount;

$objCount->dbConnect('S',$varDbInfo['DATABASE']);

function showXMLOutput($dispMsg) {
	return "<?xml version='1.0' encoding='UTF-8'?><COUNTS>".$dispMsg."</COUNTS>";
}

echo $varCommunityId.",".$varMatriId."<BR>";
//Profilematch Count
$varProfileMatchCount	= $objCount->ProfileIamLooking($varCommunityId,$varMatriId);

echo showXMLOutput($varProfileMatchCount);
?>