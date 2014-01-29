
<style type="text/css">
@import url("http://imgs.bharatmatrimony.com/bmstyles/global-style.css");
</style>
<SCRIPT LANGUAGE="JavaScript" src="offer/cbstmoffershow.js"></SCRIPT>
<?php

include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferarray.php");
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferflow.class.php");

$offerEndDate=mktime(0,0,0,date("m"),date("d")+3,date("Y"));

$CateType="CBSTMSUPPORT";
$offerAvl=$recdgen['OfferAvailable'];
#$offerAvl=0;
$showError='';
$objOffer=new offershow();

$userOfferArray=$objOffer->checkofferavailable($CateType,$offerAvl,$recdgen['OfferCategoryId'],$recdgen['MatriId'],$objSlaveMatri);



$showError=$userOfferArray['error'];
if(empty($showError)){
	$offerId=$userOfferArray[1]; 
	$offerCode=$userOfferArray[2]; 
	
	if(!empty($userOfferArray[3])){
	$offerExpiryDate=$userOfferArray[3];
	}else{
	$offerExpiryDate='0000-00-00';
	}
	$OfficeId='5';
	#DYNAMIC CHANGE ONLINE OFFER
	$offerArray=$objOffer->showofferdetails($offerId,$tmCateOfferMax,$OfficeId,$returnCateType);
	if($offerId==$checkOfferCatId[$CateType]) {
	$offerType="Offline Offer Available";
	} else {
	$offerType="Online Offer Available";
	}
	$retuenMax=$objOffer->getmaxofferonly();
	$retuenMaxAmount=$objOffer->getmaxAmountofferonly();
}
echo "<table border='0' cellpadding='0' cellspacing='0' id='offerframe'><tr><td>&nbsp;</td></tr><tr><td>";
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/showoffer.php");
echo "</td></tr><tr><td>&nbsp;</td></tr></table>";
?>
<input type="hidden" name="PROMATRIID" value="<?=$recdgen['Matriid']?>">
<input type="hidden" name="OFFERID" value="<?=$offerId?>">
<input type="hidden" name="OFFERCODE" value="<?=$offerCode?>">
<input type="hidden" name="USERTYPE" value="<?=$CateType?>">
<input type='hidden' name='DBOFFERENDDATE' id='DBOFFERENDDATE' value='<?=$offerExpiryDate?>'>