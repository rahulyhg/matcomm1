<?php
#================================================================================================================
# Author 		: Ashok kumar, Dhanapal
# Date	        : 15-Dec-2008
# Project		: MatrimonyProduct
# Filename		: payment.inc
#================================================================================================================
# Description   : Payment module array and variable declaration
#================================================================================================================

// INCLUDES //
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
include_once $varRootBasePath.'/conf/domainrates.inc';
include_once $varRootBasePath.'/conf/currconvrate.inc';


// CC-AVENUE PAYMENT GATEWAY DETAILS //
$varMerchantId			= "M_musmatri_2323";
$varCCAvenueGatewayUrl	= 'http://'.$_SERVER['HTTP_HOST'].'/payment/ccpaymentprocess.php';
$varCCAvenueRedirectUrl	= 'http://'.$_SERVER['HTTP_HOST'].'/payment/ccgatwayredirect.php';
$varWorkingKey			= "p8045i4ia3end3tkuusrvaby9fh88qpu";

// ICICI PAYMENT GATEWAY DETAILS //
$varUSDMerchantId		= '00003406';
$varGBPMerchantId		= '00003407';
$varAEDMerchantId		= '00003408';
$varIciciGatewayUrl		= 'https://communitymatrimony.com/payment/icgatewayredirect.php';
$varIciciGatewayUrl_VBV = 'https://communitymatrimony.com/payment/icgatewayredirect_VBV.php';

// $varOfferAvailable		= 0; //0=> OFF, 1=> ON
$varOfferStatus	= 1;
$varOfferAvailable[1] = 1;
$varOfferAvailable[2] = 1;
$varOfferAvailable[3] = 1;
$varOfferAvailable[4] = 1;
$varOfferAvailable[5] = 1;
$varOfferAvailable[6] = 1;
$varOfferAvailable[7] = 1;
$varOfferAvailable[8] = 1;
$varOfferAvailable[9] = 1;
$varOfferAvailable[48] = 1; // Privilege

$varBDayOfferAvailable	= 0; //0=> OFF, 1=> ON
$varUsdGateWayAvailable	= 0; //0=> OFF, 1=> ON
$varInrGateWayAvailable	= 1; //0=> OFF, 1=> ON
//$arrSourceFrom			= array(0=>'Home Page',1=>'CCAvenue',2=>'Citi',3=>'ICICI');
$arrSourceFrom			= array(1,2,3,4);

// Product Packages Names //
// Classic Packages
$arrPackageName[1] = 'Gold';
$arrPackageName[2] = 'Super Gold';
$arrPackageName[3] = 'Platinum';

$arrPrdPackages[1] = 'Gold 3 Months';
$arrPrdPackages[2] = 'Gold 6 Months';
$arrPrdPackages[3] = 'Gold 9 Months';
// Classic Plus Packages

$arrPrdPackages[4] = 'Super Gold 3 Months';
$arrPrdPackages[5] = 'Super Gold 6 Months';
$arrPrdPackages[6] = 'Super Gold 9 Months';
// Classic Super Packages
$arrPrdPackages[7] = 'Platinum 3 Months';
$arrPrdPackages[8] = 'Platinum 6 Months';
$arrPrdPackages[9] = 'Platinum 9 Months';
$arrPrdPackages[48] = 'Privilege 3 Months';

$arrPrdPackages[100] = 'Phone Package';
$arrPrdPackages[110] = 'Astro Package';


// Product Time Periods - used in conjunction with arrPrdPackages
$arrPrdTime[1] = '3 Months';
$arrPrdTime[2] = '6 Months';
$arrPrdTime[3] = '9 Months';

// Product Packages Valid Days Count //
// Classic Packages
$arrPkgValidDays[1] = 90;  // 3 month
$arrPkgValidDays[2] = 180; // 6 month
$arrPkgValidDays[3] = 270; // 9 month
// Classic Plus Packages
$arrPkgValidDays[4] = 90;  // 3 month
$arrPkgValidDays[5] = 180; // 6 month
$arrPkgValidDays[6] = 270; // 9 month
// Classic Super Packages
$arrPkgValidDays[7] = 90;  // 3 month
$arrPkgValidDays[8] = 180; // 6 month
$arrPkgValidDays[9] = 270; // 9 month

$arrPkgValidDays[48] = 90; // CBS Privilege 3 month

// Offer Valid Days Count
$arrOfferValidDays = 0;

// Product Packages - Phone Count //
// Classic Packages
$arrPhonePackage[1] = 40;  // 3 month
$arrPhonePackage[2] = 55; // 6 month
$arrPhonePackage[3] = 70; // 9 month
// Classic Plus Packages
$arrPhonePackage[4] = 50; //80;  // 3 month   Next Level Offer 18th March
$arrPhonePackage[5] = 70; //110; // 6 month
$arrPhonePackage[6] = 90; //140; // 9 month
// Classic Super Packages
$arrPhonePackage[7] = 80;  // 3 month
$arrPhonePackage[8] = 110;  // 6 month
$arrPhonePackage[9] = 140;  // 9 month
$arrPhonePackage[48] = 200;  // 9 month
$arrPhonePackage[100] = 25;  // Phone package

// Offer Phone Package Count
$arrOfferPhoneCount = 0;

// SWITCH - FOR GEO LOCATE BASED RATE/CURRENCY SHOW - RESPECTIVE OF DOMAINS //
$arrCountryCurrency = array ('IN'=>98,'PK'=>162, 'US'=>222, 'UK'=>221, 'BH'=>220,'CY'=>220,'EG'=>220,'IR'=>220,'IQ'=>220,'IL'=>220,'JO'=>220,'KW'=>220,'LB'=>220,'OM'=>220,'QA'=>220,'SY'=>220,'TR'=>220,'AE'=>220,'YE'=>220,'AL'=>21,'AD'=>21,'AT'=>21,'BY'=>21,'BE'=>21,'BA'=>21,'BG'=>21,'HR'=>21,'CZ'=>21,'DK'=>21,'EE'=>21,'FI'=>21,'FR'=>21,'DE'=>21,'GR'=>21,'HU'=>21,'IS'=>21,'IE'=>21,'IT'=>21,'LV'=>21,'LI'=>21,'LU'=>21,'MO'=>21,'MT'=>21,'MD'=>21,'MC'=>21,'NL'=>21,'PL'=>21,'PT'=>21,'RO'=>21,'RU'=>21,'SM'=>21,'SK'=>21,'SI'=>21,'ES'=>21,'SE'=>21,'CH'=>21,'TR'=>21,'UA'=>21);
$arrDefaultCurrency = 222; // USD Currency Rate

$arrCurrencyList	= array ('IN'=>98,'PKR'=>162,'US'=>222,'UK'=>221,'AED'=>220,'EURO'=>21);
// COUNTRY WISE PACKAGE RATES ARRAY DETAILS //


// IN - INR [ INDIA 98 ]
$arrRate[98]	  = $arrDomainSegmentRates[98];
$arrOffRate[98]   = $arrDomainSegmentDisRates[98];
$arrCurrCode[98]  = 'Rs.';
$arrCurrToInr[98] = $varCurrInrToInr;
$arrCurrToUsd[98] = $varCurrInrToUsd;


// PK - PKR [ PAKISTAN 162 ]
$arrRate[162]		= $arrDomainSegmentRates[162];
$arrOffRate[162]	= $arrDomainSegmentDisRates[162];
$arrCurrCode[162]  = 'PKR';
$arrCurrToInr[162] = $varCurrPkrToInr;
$arrCurrToUsd[162] = $varCurrPkrToUsd;


// US - USD [ UNITED STATES OF AMERICA 222 ]
$arrRate[222]	   = $arrDomainSegmentRates[222];
$arrOffRate[222]   = $arrDomainSegmentDisRates[222];
$arrCurrCode[222]  = 'USD';
$arrCurrToInr[222] = $varCurrUsdToInr;
$arrCurrToUsd[222] = $varCurrUsdToUsd;

// UK - GBP [ UNITED KINGDOM 221 ]
$arrRate[221]	   = $arrDomainSegmentRates[221];
$arrOffRate[221]   = $arrDomainSegmentDisRates[221];
$arrCurrCode[221]  = 'GBP';
$arrCurrToInr[221] = $varCurrGbpToInr;
$arrCurrToUsd[221] = $varCurrGbpToUsd;

// UAE - AED [ UNITED ARAB EMIRATES 220 ]
$arrRate[220]	   = $arrDomainSegmentRates[220];
$arrOffRate[220]   = $arrDomainSegmentDisRates[220];
$arrCurrCode[220]  = 'AED';
$arrCurrToInr[220] = $varCurrAedToInr;
$arrCurrToUsd[220] = $varCurrAedToUsd;

// EURO - EUR [ EUROPE COUNTRIES 21 ]
$arrRate[21]	   = $arrDomainSegmentRates[21];
$arrOffRate[21]	   = $arrDomainSegmentDisRates[21];
$arrCurrCode[21]   = 'EUR';
$arrCurrToInr[21]  = $varCurrEurToInr;
$arrCurrToUsd[21]  = $varCurrEurToUsd;


$varAssociateRedirectURL	= 'http://'.$_SERVER['HTTP_HOST'].'/associates/associatesredirecturl.php';
$varAssociatesUSAmount		= array(1=>"500",2=>"200",3=>"100");
$varAssociatesIndianAmount	= array(1=>"20000",2=>"8000",3=>"4000");



// PAYMENT ATTEMPT FAILURE MESSAGE //
$varFailureMsg = "<font class=smalltxt>Thank you for your interest in making payment. Sorry, your payment has failed due to one of the following reasons: <ul><li>Incorrect credit card details</li><li>Credit card expired</li><li>Insufficient funds</li></ul><br><a href=\"".$confValues["SERVERURL"]."/payment/\" class=\"clr1\">Click here</a> if you wish to try again.<br><br>For any queries you can contact our <a href=\"".$confValues["SERVERURL"]."/site/index.php?act=livehelp/\" class=\"clr1\" target=\"_blank\">24x7 customer support</a> team.";

?>