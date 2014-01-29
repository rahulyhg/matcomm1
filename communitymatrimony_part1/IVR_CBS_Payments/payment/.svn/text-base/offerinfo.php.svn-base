<?php

$varOfferProductId		= 0;
$varExtraHoroscope		= 0;
$varExtraPhone			= 0;
$varCheckOffer			= 'no';
$varCheckNextLevelOffer = 'no';
$varCheckHoroscopeOffer = 'no';
$varExtraHoroCnt		= '';

//DEFAULT PRIVILEGE
if (($varCategory==48) || ($varCategory==56)) { $varSpecialPrev = 4; }
else if ($varCategory >=4 && $varCategory<=6) { $varSpecialPrev = 1; }
else if ($varCategory >=7 && $varCategory<=9) { $varSpecialPrev = 2; }
else { $varSpecialPrev = 0; }


$varFields		= array('(TO_DAYS(NOW()) - TO_DAYS(Last_Payment)) as NumOfDays','Last_Payment','User_Name','Number_Of_Payments','Mother_TongueId','CommunityId','Religion','Profile_Created_By','OfferAvailable');
$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
$varSelect				= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
$varMemberInfo			= mysql_fetch_array($varSelect);
$varPaidDays			= $varMemberInfo['NumOfDays'];
$varDatePaid			= $varMemberInfo['Last_Payment'];
$varUserName			= $varMemberInfo['User_Name'];
$varNumberOfPayments	= $varMemberInfo['Number_Of_Payments'];
$varMotherTongueId		= $varMemberInfo['Mother_TongueId'];
$varCommunityId			= $varMemberInfo['CommunityId'];
$varReligion			= $varMemberInfo['Religion'];
$varProfileCreatedBy	= $varMemberInfo['Profile_Created_By'];
$varOfferAvailable		= $varMemberInfo['OfferAvailable'];


//CHECK OFFER FROM OFFERINFO TABLE
if ($varOfferAvailable=='1'){
	
	$varOfferFields		= array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberExtraHoroscope','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberNextLevelOffer','MemberExtraDays');
	$varSelectOffer	= $objDB->select($varTable['OFFERCODEINFO'], $varOfferFields, $varCondition, 0);
	$varOfferInfo	= mysql_fetch_array($varSelectOffer);
	 
	//CHECK NEXT LEVEL OFFER
	if ($varOfferInfo["MemberNextLevelOffer"] !="") { $varCheckNextLevelOffer = 'nextlevel'; }
	if ($varOfferInfo["MemberExtraPhoneNumbers"] !="") { $varCheckOffer = 'extraphone'; }
	if ($varOfferInfo["MemberExtraHoroscope"] !="") { $varCheckHoroscopeOffer = 'extrahoroscope'; }


}//if


/*
$arrOfferAvailMTs = array(17, 19, 23, 33, 40, 41, 47, 48, 50, 2, 4, 12, 14, 32, 34, 46);
if (($varReligion=='2') || ($varReligion=='10') || ($varReligion=='11') || ($varCommunityId=='2503') || ($varCommunityId=='122')) { $varCheckOffer = 'yes'; }
else if($varReligion==1 && in_array($varMotherTongueId, $arrOfferAvailMTs)){ $varCheckOffer = 'yes';}
*/

if ($varCheckNextLevelOffer=='nextlevel'){
if (($varCategory==48) || ($varCategory==56)) { $varSpecialPrev = 4; }
else if ($varCategory >=4 && $varCategory<=6) { $varSpecialPrev = 2; $varOfferProductId = ($varCategory + 3);  }
else if ($varCategory >=7 && $varCategory<=9) { $varSpecialPrev = 2; $varOfferProductId = $varCategory; }
else { $varSpecialPrev = 1; $varOfferProductId = ($varCategory + 3); }


   $arrMemberExtraPhone	= array();
   $varExplode			= explode("|",$varOfferInfo["MemberExtraPhoneNumbers"]);

	foreach($varExplode as $varKey => $varValue) {

		$varExplode2	= '';
		$varExplode2	= explode("~",$varValue);
		$arrMemberExtraPhone[$varExplode2[0]] = $varExplode2[1];

	}//foreach

	$varExtraPhone = $arrMemberExtraPhone[$varCategory];
	$varExtraPhone	= $varExtraPhone ? $varExtraPhone : 0;

		/*
		if ($varCategory==7){ $varExtraPhone = 15;  }
		else if ($varCategory==8){ $varExtraPhone = 20;  }
		else if ($varCategory==9){ $varExtraPhone = 25;  }*/

} if ($varCheckOffer=='extraphone'){ 

   $arrMemberExtraPhone	= array();
   $varExplode			= explode("|",$varOfferInfo["MemberExtraPhoneNumbers"]);

	foreach($varExplode as $varKey => $varValue) {

		$varExplode2	= '';
		$varExplode2	= explode("~",$varValue);
		$arrMemberExtraPhone[$varExplode2[0]] = $varExplode2[1];

	}//foreach

	$varExtraPhone = $arrMemberExtraPhone[$varCategory];
	$varExtraPhone	= $varExtraPhone ? $varExtraPhone : 0;

} 
if ($varCheckHoroscopeOffer=='extrahoroscope'){ 

   $arrMemberExtraHoroscope	= array();
   $varExplode			= explode("|",$varOfferInfo["MemberExtraHoroscope"]);

	foreach($varExplode as $varKey => $varValue) {

		$varExplode2	= '';
		$varExplode2	= explode("~",$varValue);
		$arrMemberExtraHoroscope[$varExplode2[0]] = $varExplode2[1];
	}//foreach

	$varExtraHoroscope = $arrMemberExtraHoroscope[$varCategory];
	$varExtraHoroscope	= $varExtraHoroscope ? $varExtraHoroscope : 0;

	$varExtraHoroCnt	= '<br><br><b>Astro Count :</b> '.$varExtraHoroscope;

}//extrahoroscope

if ($varOfferProductId > 0) { $varDisPlayId = $varOfferProductId; } else {
	$varDisPlayId = $varCategory; }

?>