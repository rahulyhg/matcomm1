<?php
$keyMatch=array("#"=>"&nbsp;&nbsp;OR&nbsp;&nbsp;","&"=>"&nbsp;&nbsp;AND&nbsp;&nbsp;","+"=>"&nbsp;&nbsp;AND&nbsp;&nbsp;","-"=>"<br>&nbsp;&nbsp;OR&nbsp;&nbsp;<br>");
$checkOfferCatId='1';

$OFFERGIFTARRAY=array(1=>"NokiaMobile",2=>"Sony Tv");

$Offer1StartDateStr='2009-01-12 00:00:00';
$Offer1EndDateStr='2010-12-31 23:59:59';
$Offer1StartDateTime=mktime(0, 0, 0, 03, 12, 2009);
$Offer1EndDateTime=mktime(23, 59, 59, 12, 31, 2010);

$cateArray=array("A","B","C","D");#category for castwise
$ovarAllCategory=array(0=>"1");#1=>"ON",2=>"OFF"
$finalCategory=array("A"=>"20","B"=>"25","C"=>"30","D"=>"30","A1"=>"20","B1"=>"25","C1"=>"30","D1"=>"30");#final offer for Category wise


#caetgory A for INR
$finalCategoryRateMinRSA=array(1=>"200",2=>"300",3=>"400",4=>"300",5=>"500",6=>"600",7=>"300",8=>"500",9=>"800");
$finalCategoryRateRSA=array(1=>"400",2=>"600",3=>"800",4=>"500",5=>"800",6=>"1000",7=>"500",8=>"800",9=>"1200");
#caetgory B for INR
$finalCategoryRateMinRSB=array(1=>"200",2=>"300",3=>"400",4=>"300",5=>"500",6=>"600",7=>"300",8=>"500",9=>"800");
$finalCategoryRateRSB=array(1=>"400",2=>"600",3=>"800",4=>"500",5=>"800",6=>"1000",7=>"500",8=>"800",9=>"1200");
#caetgory C for INR
$finalCategoryRateMinRSC=array(1=>"200",2=>"300",3=>"400",4=>"300",5=>"500",6=>"600",7=>"300",8=>"500",9=>"800");
$finalCategoryRateRSC=array(1=>"400",2=>"600",3=>"800",4=>"500",5=>"800",6=>"1000",7=>"500",8=>"800",9=>"1200");
#caetgory D for INR
$finalCategoryRateMinRSD=array(1=>"200",2=>"300",3=>"400",4=>"300",5=>"500",6=>"600",7=>"300",8=>"500",9=>"800");
$finalCategoryRateRSD=array(1=>"400",2=>"600",3=>"800",4=>"500",5=>"800",6=>"1000",7=>"500",8=>"800",9=>"1200");
#Defualt for INR
$finalCategoryRateMinRS=array(1=>"200",2=>"300",3=>"400",4=>"300",5=>"500",6=>"600",7=>"300",8=>"500",9=>"800");
$finalCategoryRateRS=array(1=>"400",2=>"600",3=>"800",4=>"500",5=>"800",6=>"1000",7=>"500",8=>"800",9=>"1200");

#caetgory A for UAE
$finalCategoryRateMinAEDA=array(1=>"10",2=>"15",3=>"20",4=>"15",5=>"20",6=>"30",7=>"15",8=>"25",9=>"35");
$finalCategoryRateAEDA=array(1=>"40",2=>"50",3=>"60",4=>"60",5=>"80",6=>"90",7=>"70",8=>"90",9=>"125");
#caetgory B for UAE
$finalCategoryRateMinAEDB=array(1=>"10",2=>"15",3=>"20",4=>"15",5=>"20",6=>"30",7=>"15",8=>"25",9=>"35");
$finalCategoryRateAEDB=array(1=>"40",2=>"50",3=>"60",4=>"60",5=>"80",6=>"90",7=>"70",8=>"90",9=>"125");
#caetgory C for UAE
$finalCategoryRateMinAEDC=array(1=>"10",2=>"15",3=>"20",4=>"15",5=>"20",6=>"30",7=>"15",8=>"25",9=>"35");
$finalCategoryRateAEDC=array(1=>"40",2=>"50",3=>"60",4=>"60",5=>"80",6=>"90",7=>"70",8=>"90",9=>"125");
#caetgory D for UAE
$finalCategoryRateMinAEDD=array(1=>"10",2=>"15",3=>"20",4=>"15",5=>"20",6=>"30",7=>"15",8=>"25",9=>"35");
$finalCategoryRateAEDD=array(1=>"40",2=>"50",3=>"60",4=>"60",5=>"80",6=>"90",7=>"70",8=>"90",9=>"125");
#Defualt for UAE 
$finalCategoryRateMinAED=array(1=>"10",2=>"15",3=>"20",4=>"15",5=>"20",6=>"30",7=>"15",8=>"25",9=>"35");
$finalCategoryRateAED=array(1=>"40",2=>"50",3=>"60",4=>"60",5=>"80",6=>"90",7=>"70",8=>"90",9=>"125");

$maxOfferInc=array("RS"=>"50","AED"=>"5");

$checkOfferCatId=array("CBSTMSUPPORT"=>"1");

$currenceArray=array("gbptousd"=>"GBP TO USD","aedtousd"=>"AED TO USD","eurotousd"=>"EUR OT USD","usdtoinr"=>"USD TO INR","aedtoinr"=>"AED TO INR","inrtousd"=>"INR TO USD",
"inrtogbp"=>"INR TO GBP","inrtoaed"=>"INR TO AED","inrtoeur"=>"INR TO EUR","usdtogbp"=>"USD TO GBP","usdtoaed"=>"USD TO AED","usdtoeur"=>"USD TO EUR","aedtogbp"=>"AED TO GBP","aedtoeur"=>"AED TO EUR");
?>
