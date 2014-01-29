<?php
###########################################################################################################
#FileName		: offerpost.php
#Created		: On:2009-May-04
#Authour		: A.Anbalagan
#Description	: get the offerpostvalues
###########################################################################################################
#ini_set('display_errors','on');
#error_reporting(E_ALL ^ E_NOTICE);

include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferarray.php");
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferflow.class.php");
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferupdate.class.php");

	$offerId=$_REQUEST['OFFERID'];
	$offerCode=$_REQUEST['OFFERCODE'];
	$offerAll1=$_REQUEST['OFFERALL1'];
	$offerAll2=$_REQUEST['OFFERALL2'];
	$offerAll3=$_REQUEST['OFFERALL3'];
	$offerAll4=$_REQUEST['OFFERALL4'];
	$offerAll5=$_REQUEST['OFFERALL5'];
	$offerExpDate=$_REQUEST['FDATEEXP'];
	
	
	#get the assured key
	$$assuredRequest="ASSURED".$_REQUEST['PACKAGESELECT'];
	$assuredFinal=$$assuredRequest;
	#offer precentage
	$$preRequest="PRECNTAGE".$_REQUEST['PACKAGESELECT'];
	$preFinal=$$preRequest;
	#offer next level
	$$nextLevelRequest="NEXTLEVEL".$_REQUEST['PACKAGESELECT'];
	$nextFinal=$$nextLevelRequest;
	#offer extra phone number
	$$extraPhoneRequest="EXTRAPHONE".$_REQUEST['PACKAGESELECT'];
	$extraFinal=$$extraPhoneRequest;
	$$rateRequest="RATE".$_REQUEST['PACKAGESELECT'];
	$rateFinal=$$rateRequest;
	unset($offerEntry);
	#get the psot values with selected offers only
	@extract($_REQUEST);
	$offerRateFinal=0;
	$precentage=0;
	$nextOffer='';
	$extraPhone='';
	foreach($_REQUEST as $postKey=>$postValue) {

			if(ereg($assuredFinal,$postKey)) { ##assured gift offer find

				$assuredGift.=$postValue.",";
				$offerGift=1;
				$offerEntry[]=1;
			}
			if(ereg($preFinal,$postKey)) { ##precentage offer find
				$precentage=$postValue;
				$offerPrec=2;
				$offerEntry[]="2~".$precentage;
			}
			if(ereg($nextFinal,$postKey)) { ##next level offer find
				$nextOffer=$postValue;
				$offerNext=3;
				$offerEntry[]="3~".$nextOffer;
			}
			if(ereg($extraFinal,$postKey)) { ##extra phone number offer find
				$extraPhone=$postValue;
				$offerPhone=4;
				$offerEntry[]="4~".$extraPhone;
			}
			if(ereg($rateFinal,$postKey)) { ##Amount offer find
				$offerRateFinal=$postValue;
				$offerRate=5;
				$offerEntry[]="5~".$offerRateFinal;
			}
	}
	$offerMail=0;
	##offer rearrange this function

	if((!empty($packageSelected)) && ($precentage > 0 || $offerRateFinal > 0 || $nextOffer!='' || $extraPhone!='')){
		$easyPayQryString="";
		$arrangeOffer= new offershow();
			if($offerGift=="1"){ 
				$assuredGift=$arrangeOffer->offerdateforupdate($offerAll1,$assuredGift,$packageSelected,'3'); 
				$sepAssuredGift=explode('|',$assuredGift);
				$sepAssuredGiftRes=explode('~',$sepAssuredGift[0]);
				$easyPayQryString.="disPercnt=".$sepOfferPresentageRes[1].'&';
			}
			if($offerPrec=="2") { 
				$offerPresentage=$arrangeOffer->offerdateforupdate($offerAll2,$precentage,$packageSelected,'1');
				$sepOfferPresentage=explode('|',$offerPresentage);
				$sepOfferPresentageRes=explode('~',$sepOfferPresentage[0]);
				$easyPayQryString.="assuredGift=".$sepAssuredGiftRes[1].'&';
			}
			if($offerNext=="3"){
				$nextLevelOffer=$arrangeOffer->offerdateforupdate($offerAll3,$nextOffer,$packageSelected,'2');
				$sepNextLevelOffer=explode('|',$nextLevelOffer);
				$sepNextLevelOfferRes=explode('~',$sepNextLevelOffer[0]);
				$easyPayQryString.="nextLevel=".$sepNextLevelOfferRes[1].'&';
			}
			if($offerPhone=="4") {
				$phoneOffer=$arrangeOffer->offerdateforupdate($offerAll4,$extraPhone,$packageSelected,'1'); 
				$sepPhoneOffer=explode('|',$phoneOffer);
				$sepPhoneOfferRes=explode('~',$sepPhoneOffer[0]);
				$easyPayQryString.="extraPhone=".$sepPhoneOfferRes[1].'&';
			}
			if($offerRate=="5") {
				$amountOffer=$arrangeOffer->offerdateforupdate($offerAll5,$offerRateFinal,$packageSelected,'2'); 
				if($_REQUEST['OFFICEID']=='28') { 
				$amu="AED"; 
				$amountOfferAed=$amountOffer;
				$amountOfferRs='';
				} 
				else { 
				$amu="Rs."; 
				$amountOfferAed='';
				$amountOfferRs=$amountOffer;
				} 
				$sepAmountOffer=explode('|',$amountOffer);
				$sepAmountOfferRes=explode('~',$sepAmountOffer[0]);
				$easyPayQryString.="DiscountAmount=".$sepAmountOfferRes[1]." ".$amu;
			}
			#mail("anbalagan@bharatmatrimony.com","Offer update-Query",$getExecutedQuery);
			$offerMail=1;
	}

?>