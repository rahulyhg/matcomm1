<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2010-05-11
# End Date		: 2010-05-21
# Project		: Community
# Module		: Payment - IVRS integration
#=============================================================================================================

$varRootBasePath	= '/home/product/community';
$varBaseRoot		= $varRootBasePath;

//VARIABLLE DECLARATIONS
$varCountryCode		= '98';
$varMatriId			= trim($_REQUEST['matriid']);
$varPrefixMatriId	= substr($varMatriId,0,3);
$varOrderId			= trim($_REQUEST['orderId']);
$varGateWay			= '1';

//FILE INCLUDES
include_once($varRootBasePath.'/conf/domainlist.cil14');
$_SERVER["HTTP_HOST"]='www.'.$arrPrefixDomainList[$varPrefixMatriId];
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARATION
$objMasterDB= new DB;

$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//CHECK IF MEMBER HAS ALREADY PAID OR NOT
$varFields		= array('OrderId','MatriId','Product_Id','Currency');
$varCondition	= " WHERE OrderId=".$objMasterDB->doEscapeString($varOrderId,$objMasterDB);
$varExecute		= $objMasterDB->select($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
$varPaidInfo	= mysql_fetch_array($varExecute);
$varOrderId		= $varPaidInfo["OrderId"];
$varMatriId		= $varPaidInfo["MatriId"];
$varCategory	= $varPaidInfo["Product_Id"];

include_once($varRootBasePath."/www/payment/paymentprocess.php");

if ($varOrderId!="" && $varMatriId!="") {


	//SELECT OFFERCODEINFO//
	$varCondition	= " WHERE MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	$varFields		= array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','DateUpdated','OmmParticipation');
	$varExecute		= $objMasterDB->select($varTable['OFFERCODEINFO'], $varFields, $varCondition,0);
	$varMemberInfo	= mysql_fetch_array($varExecute);

	$varMemberDiscountINRFlatRate = trim($varMemberInfo["MemberDiscountINRFlatRate"]);
	$varMemberDiscountAEDFlatRate = trim($varMemberInfo["MemberDiscountAEDFlatRate"]);

	if ($varMemberDiscountINRFlatRate !="") {

		$varSplitFlatDiscount	= split('\|',$varMemberDiscountINRFlatRate);
		$varDiscountAvail		= '98';

	} else if ($varMemberDiscountAEDFlatRate !="") {

		$varSplitFlatDiscount	= split('\|',$varMemberDiscountAEDFlatRate);
		$varDiscountAvail		= '220';

	}

	$arrSplitDiscount	= array();
	for($i=0;$i<count($varSplitFlatDiscount);$i++) {

		$varSplitDiscount			= split('~',trim($varSplitFlatDiscount[$i]));
		$varKey						= trim($varSplitDiscount[0]);

		if ($varDiscountAvail==$varUseCountryCode && $varDiscountAvail=='98') {
			$varValue			= trim($varSplitDiscount[1]);
		} else {

				$varDiscountAvailCurrency	= $arrCurrCode[$varDiscountAvail];
				if ($varDiscountAvailCurrency=='Rs.'){ $varDiscountAvailCurrency ='Inr'; }

				$varDiscountConvertCurrency	= $arrCurrCode[$varUseCountryCode];
				if ($varDiscountConvertCurrency=='Rs.'){ $varDiscountConvertCurrency ='Inr'; }

				$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

				if ($varDiscountAvail=='98'){

					$varValue1	= round(($varSplitDiscount[1]*$$varGetDiscount));
					$varConver	= 'varCurr'.ucwords(strtolower($arrCurrCode[$varUseCountryCode])).'ToInr';
					$varValue	= round($varValue1*$$varConver);

				} elseif ($varDiscountAvail=='220'){

					$varCurrencyName	= ucwords(strtolower($arrCurrCode[$varUseCountryCode]));
					if ($varCurrencyName=='Rs.'){ $varCurrencyName ='Inr'; }

					if ($varUseCountryCode=='98') {
						$varValue	= round(($varSplitDiscount[1]*$$varGetDiscount));
					} else {

						if ($varUseCountryCode=='220') {
							$varAed220Discount = 'varCurr'.$varCurrencyName.'ToInr';
							$varValue			= round(($varSplitDiscount[1]*$$varAed220Discount));
					}  else if($varUseCountryCode=='221'){

						$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

						$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
						$varGBPToInr	= 'varCurrGbpToInr';
						$varValue = round(($varValue1*$$varGBPToInr));

					}  else if($varUseCountryCode=='21'){

						$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

						$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
						$varEurToInr	= 'varCurrEurToInr';
						$varValue = round(($varValue1*$$varEurToInr));

					}  else if($varUseCountryCode=='222'){

						$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

						$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
						$varUsdToInr	= 'varCurrUsdToInr';
						$varValue = round(($varValue1*$$varUsdToInr));

					}

					else {


						//$varAed220Discount = 'varCurr'.$varCurrencyName.'ToInr';
						//$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

						//echo $varValue	= round(($varSplitDiscount[1]/$$varGetDiscount));



		$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

		$varValue = round(($varSplitDiscount[1]*$$varGetDiscount));



					}


					}

$localCurrOriginalRate	= $arrRate[$varUseCountryCode];

				}

			}
			$arrSplitDiscount[$varKey]	= $varValue;
		}
		ksort($arrSplitDiscount);

$varInrDiscountAmount	= round($arrSplitDiscount[$varCategory]);
if ($varInrDiscountAmount > 0) {
	$varAmount				= ($varAmount - $varInrDiscountAmount);
}

//PREPAYMENT TRACKING PURPOSE....
$varCondition	  = " OrderId=".$objMasterDB->doEscapeString($varOrderId,$objMasterDB);
$varFields		  = array('Amount_Paid','Currency','Gateway','Payment_Mode','Date_Paid');
$varFieldsValues  = array($objMasterDB->doEscapeString($varAmount,$objMasterDB),'\'Rs\'','\'4\'','\'1\'','NOW()');
$objMasterDB->update($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varFieldsValues,$varCondition);


}//if



$objMasterDB->dbClose();
UNSET($objMasterDB);
?>