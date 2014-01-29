<?php

//include_once "/home/product/community/conf/domainlist.cil14";
function getOfferDetails($matId,$currencyFlag) {
global $arrFolderNames,$arrAstroPackage,$arrRate,$arrPrdPackages;
$varMatriId				= (trim($matId)!=''?trim($matId):'');
$varCurrencyFlag			= (trim($currencyFlag)!=''?trim($currencyFlag):'');
$varHoroDetails			= '';
$varGetPackage			= '';
$varGetFolder			= '';
$varGetPrefix			= '';
$varOfflineCurrency		= array('98'=>'RS.','US$'=>'222','AED'=>'220','GBP'=>'221','EUR'=>'21');
$varOfflineCurrencyId	= $varOfflineCurrency[trim(strtoupper(strtolower($varCurrencyFlag)))];
$varOfflineCurrencyId	= $varOfflineCurrencyId ? $varOfflineCurrencyId : '98';

if ($varOfflineCurrencyId=='98'){ $varPrivilege1Month = '6999'; }
else if ($varOfflineCurrencyId=='222'){ $varPrivilege1Month = '175'; }
else { $varPrivilege1Month=''; }

// Identifying is MatriId belongs to CBS or Product and Gets the Folder Name //
$varGetPrefix = strtoupper(substr(trim($varMatriId),0,3));
if (array_key_exists($varGetPrefix, $arrFolderNames)) {
	$varGetFolder = $arrFolderNames[$varGetPrefix];
	$varGetPackage = 'CBS';
}
// INCLUDES //
include_once "/home/product/community/domainslist/$varGetFolder/conf.cil14";
//include_once('/home/product/community/conf/payment.cil14');


$horoArray=array(0=>0,$arrAstroPackage[110]=>$arrRate[$varOfflineCurrencyId][110],$arrAstroPackage[111]=>$arrRate[$varOfflineCurrencyId][111],$arrAstroPackage[112]=>$arrRate[$varOfflineCurrencyId][112]);

// Returning XML Output of Package details to CBS-TM Interface //

$packageCost[1]=$arrRate[$varOfflineCurrencyId][1];
$packageCost[2]=$arrRate[$varOfflineCurrencyId][2];
$packageCost[3]=$arrRate[$varOfflineCurrencyId][3];
$packageCost[4]=$arrRate[$varOfflineCurrencyId][4];
$packageCost[5]=$arrRate[$varOfflineCurrencyId][5];
$packageCost[6]=$arrRate[$varOfflineCurrencyId][6];
$packageCost[7]=$arrRate[$varOfflineCurrencyId][7];
$packageCost[8]=$arrRate[$varOfflineCurrencyId][8];
$packageCost[9]=$arrRate[$varOfflineCurrencyId][9];
$packageCost[48]=$arrRate[$varOfflineCurrencyId][48];

$packageName[1]=$arrPrdPackages[1];
$packageName[2]=$arrPrdPackages[2];
$packageName[3]=$arrPrdPackages[3];
$packageName[4]=$arrPrdPackages[4];
$packageName[5]=$arrPrdPackages[5];
$packageName[6]=$arrPrdPackages[6];
$packageName[7]=$arrPrdPackages[7];
$packageName[8]=$arrPrdPackages[8];
$packageName[9]=$arrPrdPackages[9];
$packageName[48]=$arrPrdPackages[48];


$returnPackDetails[0]=$packageName;
$returnPackDetails[1]=$packageCost;
$returnPackDetails[2]=$horoArray;
return $returnPackDetails;
}

?>