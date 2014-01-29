<?php
#=========================================================================================================================
# Author 		: Ashok kumar
# Date	        : 01 June 2009
# Project		: Community Matrimony Product
# Filename		: cbstmpackagedetail.php
#=========================================================================================================================
# Description   : It retrives Package details and output to CBS-TM
#=========================================================================================================================

// Error Reporting ON | OFF //
error_reporting(0);

// Default Includes //
include_once "/home/product/community/ability/conf/domainlist.inc";

$varMatriId				= (trim($_GET['matriid'])!=''?trim($_GET['matriid']):'');
$varDomainId			= (trim($_GET['domain'])!=''?trim($_GET['domain']):'');
$varGetPackage			= '';
$varGetFolder			= '';
$varGetPrefix			= '';
$varOfflineCurrency		= array('98'=>'RS.','US$'=>'222','AED'=>'220','GBP'=>'221','EUR'=>'21');
$varOfflineCurrencyId	= $varOfflineCurrency[trim(strtoupper(strtolower($_REQUEST["currency"])))];
$varOfflineCurrencyId	= $varOfflineCurrencyId ? $varOfflineCurrencyId : '98';

if ($varOfflineCurrencyId=='98'){ $varPrivilege1Month = '6999'; }
else if ($varOfflineCurrencyId=='222'){ $varPrivilege1Month = '175'; }
else { $varPrivilege1Month=''; }

// Identifying is MatriId belongs to CBS or Product and Gets the Folder Name //
$varGetPrefix = strtoupper(substr($varMatriId,0,3));
if (array_key_exists($varGetPrefix, $arrFolderNames)) {
	$varGetFolder = $arrFolderNames[$varGetPrefix];
	$varGetPackage = 'CBS';
}

// INCLUDES //
include_once "/home/product/community/ability/domainslist/$varGetFolder/conf.inc";
include_once "/home/product/community/ability/conf/payment.inc";

if ($varOfferStatus	== 1) { $varPriceArray = $arrTagDiscount[$casteTag]; } else { $varPriceArray = 0; }

// Returning XML Output of Package details to CBS-TM Interface //
echo "<PACKDATA>
<P1>
<COST>".$arrRate[$varOfflineCurrencyId][1]."</COST>
<PNAME>".$arrPrdPackages[1]."</PNAME>
</P1>
<P2>
<COST>".$arrRate[$varOfflineCurrencyId][2]."</COST>
<PNAME>".$arrPrdPackages[2]."</PNAME>
</P2>
<P3>
<COST>".$arrRate[$varOfflineCurrencyId][3]."</COST>
<PNAME>".$arrPrdPackages[3]."</PNAME>
</P3>
<P4>
<COST>".$arrRate[$varOfflineCurrencyId][4]."</COST>
<PNAME>".$arrPrdPackages[4]."</PNAME>
</P4>
<P5>
<COST>".$arrRate[$varOfflineCurrencyId][5]."</COST>
<PNAME>".$arrPrdPackages[5]."</PNAME>
</P5>
<P6>
<COST>".$arrRate[$varOfflineCurrencyId][6]."</COST>
<PNAME>".$arrPrdPackages[6]."</PNAME>
</P6>
<P7>
<COST>".$arrRate[$varOfflineCurrencyId][7]."</COST>
<PNAME>".$arrPrdPackages[7]."</PNAME>
</P7>
<P8>
<COST>".$arrRate[$varOfflineCurrencyId][8]."</COST>
<PNAME>".$arrPrdPackages[8]."</PNAME>
</P8>
<P9>
<COST>".$arrRate[$varOfflineCurrencyId][9]."</COST>
<PNAME>".$arrPrdPackages[9]."</PNAME>
</P9>

<P48>
<COST>".$arrRate[$varOfflineCurrencyId][48]."</COST>
<PNAME>".$arrPrdPackages[48]."</PNAME>
</P48>

<P56>
<COST>".$varPrivilege1Month."</COST>
<PNAME>Privilege 1 Month</PNAME>
</P56>

<P10><CATEGORY>".$casteTag."</CATEGORY></P10>
</PACKDATA>";

?>