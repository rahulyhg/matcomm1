<?php
#================================================================================================================
# Author 		: Rohini
# Date	        : 2008-07-15
# Project		: MatrimonyProduct
# Filename		: prepaymentprocess.php
#================================================================================================================
# Description   :
#================================================================================================================

$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);
include_once($varBaseRoot.'/www/payment/ip2location.php');


// VARIABLE DECLARATIONS //
$arrLocalCurrency	= array();
$arrConversionRate	= array();

//GET GEO IP LOCATION DETAILS eg. IN, US, UK etc
if ($varCountryCode == '') {
	$varIPLocation = getIptoLocation(); // Returns like IN, BD, UK, US etc
	if (array_key_exists($varIPLocation, $arrCountryCurrency)) {
		$varUseCountryCode = $arrCountryCurrency[$varIPLocation];
	} else { $varUseCountryCode = $arrDefaultCurrency; }
} else {
	$varUseCountryCode = $varCountryCode;
}

$varCurrencyCode	= $arrCurrCode[$varUseCountryCode]; // Displaying Currency Symbol [Ex. Rs. MYR USD etc..]

// Figure out the rates to offer to this user for their country code...
$varOfferStatus = 0;	// by default no offer....
$varDiscountAmount = $arrTagDiscount[$casteTag];
if ($varDiscountAmount != 0)
	$varOfferStatus = 1;

// The rack rates for the user's country
if ($varOfferStatus==1) { // OFFER PURPOSE.. 
	$arrLocalCurrency	= $arrRate[$varUseCountryCode];
	$arrConversionRate	= $arrOffRate[$varUseCountryCode];

} else { // Default Rate
	$arrLocalCurrency	= $arrRate[$varUseCountryCode];
	$arrConversionRate	= $arrRate[$varUseCountryCode];
}

echo "arrCurrToInr: ".$arrCurrToInr[$varUseCountryCode];
echo "arrCurrToInr: ".$arrCurrToUsd[$varUseCountryCode];
// Below used INR currency converion to CC-Avenue and Citi gateway for INR currency
$arrInrGatewayConver = array(
						1=> round(preg_replace('/\,/','',$arrConversionRate[1])*$arrCurrToInr[$varUseCountryCode]),
						2=> round(preg_replace('/\,/','',$arrConversionRate[2])*$arrCurrToInr[$varUseCountryCode]),
						3=> round(preg_replace('/\,/','',$arrConversionRate[3])*$arrCurrToInr[$varUseCountryCode]),
						4=> round(preg_replace('/\,/','',$arrConversionRate[4])*$arrCurrToInr[$varUseCountryCode]),
						5=> round(preg_replace('/\,/','',$arrConversionRate[5])*$arrCurrToInr[$varUseCountryCode]),
						6=> round(preg_replace('/\,/','',$arrConversionRate[6])*$arrCurrToInr[$varUseCountryCode]),
						7=> round(preg_replace('/\,/','',$arrConversionRate[7])*$arrCurrToInr[$varUseCountryCode]),
						8=> round(preg_replace('/\,/','',$arrConversionRate[8])*$arrCurrToInr[$varUseCountryCode]),
						9=> round(preg_replace('/\,/','',$arrConversionRate[9])*$arrCurrToInr[$varUseCountryCode]),
						48=> round(preg_replace('/\,/','',$arrConversionRate[48])*$arrCurrToInr[$varUseCountryCode]));

// Below used for USD currency conversion to USD Merchant Gateway (ICICI)
$arrUsdGatewayConver = array(
						1=> round(preg_replace('/\,/','',$arrConversionRate[1])*$arrCurrToUsd[$varUseCountryCode]),
						2=> round(preg_replace('/\,/','',$arrConversionRate[2])*$arrCurrToUsd[$varUseCountryCode]),
						3=> round(preg_replace('/\,/','',$arrConversionRate[3])*$arrCurrToUsd[$varUseCountryCode]),
						4=> round(preg_replace('/\,/','',$arrConversionRate[4])*$arrCurrToUsd[$varUseCountryCode]),
						5=> round(preg_replace('/\,/','',$arrConversionRate[5])*$arrCurrToUsd[$varUseCountryCode]),
						6=> round(preg_replace('/\,/','',$arrConversionRate[6])*$arrCurrToUsd[$varUseCountryCode]),
						7=> round(preg_replace('/\,/','',$arrConversionRate[7])*$arrCurrToUsd[$varUseCountryCode]),
						8=> round(preg_replace('/\,/','',$arrConversionRate[8])*$arrCurrToUsd[$varUseCountryCode]),
						9=> round(preg_replace('/\,/','',$arrConversionRate[9])*$arrCurrToUsd[$varUseCountryCode]),
						48=> round(preg_replace('/\,/','',$arrConversionRate[48])*$arrCurrToUsd[$varUseCountryCode]));


//GATEWAY CURRENCY CALCULATION.... AFTER SUBMIT OF PACKAGE CHOOSEN BY MEMBER - PROCESS
if (($varGateWay==1) || ($varGateWay==2)) {
	if ($varUseCountryCode==98) {
			if ($varOfferStatus==1) { 

				$varAmount	= $arrOffRate[$varCountryCode][$varCategory];
				//$varAmount	= $arrLocalCurrency[$varCategory];

			} else {
				$varAmount	= $arrRate[$varCountryCode][$varCategory];  
				//$varAmount	= $arrLocalCurrency[$varCategory];
			}
		
		} else {
				
				$varAmount = $arrInrGatewayConver[$varCategory]; 
				//$varAmount	= $arrLocalCurrency[$varCategory];
		}

} else {
	if (($varUseCountryCode==220) || ($varUseCountryCode==221) || ($varUseCountryCode==222) || ($varUseCountryCode==21)) {
		//$varAmount = $arrRate[$varCountryCode][$varCategory];

			if ($varOfferStatus==1) { 
				$varAmount	= $arrOffRate[$varCountryCode][$varCategory];
				//$varAmount	= $arrLocalCurrency[$varCategory];

			} else { 
				$varAmount	= $arrRate[$varCountryCode][$varCategory];  
				//$varAmount	= $arrLocalCurrency[$varCategory];
			}


	} else {
		//$varAmount	= $arrLocalCurrency[$varCategory];
		$varAmount = $arrUsdGatewayConver[$varCategory];
	}

}
?>