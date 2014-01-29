
<style type="text/css">
@import url("http://imgs.bharatmatrimony.com/bmstyles/global-style.css");
</style>
<SCRIPT LANGUAGE="JavaScript" src="offer/cbstmoffershow.js"></SCRIPT>
<?php

include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferarray.php");
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferflow.class.php");
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/supportgetpackagedetails.php");

$offerEndDate=mktime(0,0,0,date("m"),date("d")+3,date("Y"));

if($OfficeId==28) { $flage='220'; $defutShow='AED'; } else { $flage='0'; $defutShow='INR'; }

$CateType="CBSTMSUPPORT";
//$offerAvl=$recdgen['OfferAvailable'];

$offerAvl=0;
$showError='';
$objOffer=new offershow();


$userOfferArray=$objOffer->checkofferavailable($CateType,$offerAvl,$recdgen['OfferCategoryId'],$recdgen['MatriId'],$objSlaveMatri);
$tmCateOfferMax=20;
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
		$varMatriId	= (trim($recdgen['MatriId'])!=''?trim($recdgen['MatriId']):'');
		$varGetPrefix = strtoupper(substr(trim($varMatriId),0,3));
		if(array_key_exists($varGetPrefix, $arrFolderNames)) {
		$varGetFolder = $arrFolderNames[$varGetPrefix];
		include_once "/home/product/community/domainslist/$varGetFolder/conf.cil14";
		if(strlen($casteTag)>1)	$returnCateType=strtoupper(substr($casteTag,0,1));
		else $returnCateType=$casteTag;
		}
	$offerArray=$objOffer->showofferdetails($offerId,$tmCateOfferMax,$defutShow,$returnCateType,$memberempty,$recdgen['MatriId']);
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
<input type="hidden" name="PROMATRIID" value="<?=$recdgen['MatriId']?>">
<input type="hidden" name="OFFERID" value="<?=$offerId?>">
<input type="hidden" name="OFFERCODE" value="<?=$offerCode?>">
<input type="hidden" name="USERTYPE" value="<?=$CateType?>">
<input type='hidden' name='DBOFFERENDDATE' id='DBOFFERENDDATE' value='<?=$offerExpiryDate?>'>