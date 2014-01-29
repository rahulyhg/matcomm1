<?php

//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
if($varServerRoot == ''){ $varServerRoot  = '/home/product/community/ability/www'; }
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsCronMailer.php');

//OBJECT DECLARATION
$objCronMailer = new cronMailer;

//Connect DB
$objCronMailer->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varTodayDate		= date('m-d-Y');
$varSelectMatriId	= $objMailManager->PaymentExpire();
$varNumOfRows		= count($varSelectMatriId);

for($i=0;$i<$varNumOfRows;$i++)
{
	$varUsername		= $varSelectMatriId[$i]['User_Name'];
	$varEmail			= $varSelectMatriId[$i]['Email'];
	$varOrgPaidDate		= $varSelectMatriId[$i]['Date_Paid'];
	$varValidDays		= $varSelectMatriId[$i]['Valid_Days'];
	
	$varPaidDate		= date('m-d-Y',strtotime($varOrgPaidDate));
	$varNumOfDays		= $objMailManager->dateDiff('-',$varTodayDate,$varPaidDate);
	$varRemainingDays	= $varValidDays - $varNumOfDays;

	if($varRemainingDays==10 || $varRemainingDays==7 || $varRemainingDays==0){
	$varPaidDate	= date('jS M Y',strtotime($varOrgPaidDate));
	$objMailManager->sendPaymentExpireMail($varUsername,$varValidDays,$varEmail,$confValues['ServerURL'],$varPaidDate,$varRemainingDays);
	}
}//for

//Unset object
$objCronMailer->dbClose();
unset($objCronMailer);
?>