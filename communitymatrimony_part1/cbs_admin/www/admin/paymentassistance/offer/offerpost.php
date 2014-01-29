<?php
###########################################################################################################
#FileName		: offerpost.php
#Created		: On:2009-May-04
#Authour		: A.Anbalagan
#Description	: get the offerpostvalues
###########################################################################################################
/*ini_set('display_errors','on');
error_reporting(E_ALL ^ E_NOTICE);*/

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
	$offerAll6=$_REQUEST['OFFERALLMAX6'];
	$offerAll7=$_REQUEST['OFFERALL7'];
	$offerAll8=$_REQUEST['OFFERALL8'];
	$offerAll9=$_REQUEST['OFFERALL9'];

	$offerExpDate=$_REQUEST['FDATEEXP'];
	$seleCurrency=$_REQUEST['SELECTEDCURRENCY'];
	$captureOfferCurrency=$packType[$seleCurrency];
	
	#epr final amount
	$eprOfferNewPrice="";
	if($seleCurrency=='INR') $showCurrForEpr='Rs.';
	else $showCurrForEpr=$seleCurrency;
	$eprOfferPrice="EPROFFERPRICE".$_REQUEST['PACKAGESELECT'];
	$eprOfferNewPrice=$showCurrForEpr." ".$_REQUEST[$eprOfferPrice];	

	#get the assured key
	$$assuredRequest="ASSURED".$_REQUEST['PACKAGESELECT']."1";
	$assuredFinal=$$assuredRequest;
	#offer precentage
	$$preRequest="PRECNTAGE".$_REQUEST['PACKAGESELECT']."1";
	$preFinal=$$preRequest;
	#offer next level
	$$nextLevelRequest1="NEXTLEVEL".$_REQUEST['PACKAGESELECT']."1";
	$nextFinal1=$$nextLevelRequest1;

	$$nextLevelRequest2="NEXTLEVEL".$_REQUEST['PACKAGESELECT']."2";
	$nextFinal2=$$nextLevelRequest2;

	#offer extra phone number
	$$extraPhoneRequest="EXTRAPHONE".$_REQUEST['PACKAGESELECT']."1";
	$extraFinal=$$extraPhoneRequest;
	$$rateRequest="RATE".$_REQUEST['PACKAGESELECT']."1";
	$rateFinal=$$rateRequest;

	#offer for horo 
	$$extraHoroscopeRequest="EXTRAHOROSCOPE".$_REQUEST['PACKAGESELECT']."1";
	$extraHoroscope=$$extraHoroscopeRequest;

	#offer for horo 
	$$extraDaysRequest="EXTRADAYS".$_REQUEST['PACKAGESELECT']."1";
	$extraDays=$$extraDaysRequest;

	#add on 1
	$$extraHighlighterRequest="EXTRAHIGHLIGHTER".$_REQUEST['PACKAGESELECT']."1";
	$extraHighlighter=$$extraHighlighterRequest;

	#add on 2
	$$extraBoosterRequest="EXTRABOOSTE".$_REQUEST['PACKAGESELECT']."1";
	$extraBooster=$$extraBoosterRequest;


	$arrangeOffer= new offershow();
	unset($offerEntry);
	#get the psot values with selected offers only
	@extract($_REQUEST);
	$offerRateFinal=0;
	$precentage=0;
	$nextOffer='';
	$extraPhone='';
	$extraHoroscopeCount=0;
	$extraDaysCount=0;
	$extraHighlighterAmt="";
	$extraBoosterAmt="";
	
	$amountOfferINR='';
	$amountOfferAED='';
	$amountOfferUSD='';
	$amountOfferGBP='';
	$amountOfferEURO='';
	
	$amountAddOnDiscountPrg="";
	$amountAddOnOfferINR="";	
	$amountAddOnOfferAED="";
	$amountAddOnOfferUSD="";
	$amountAddOnOfferGBP="";
	$amountAddOnOfferEURO="";	

	foreach($_REQUEST as $postKey=>$postValue) {

			if(preg_match("/".$assuredFinal."/",$postKey)) { ##assured gift offer find
			$assuredGift.=$postValue.",";
			$offerGift=1;
			}
			if(preg_match("/".$preFinal."/",$postKey)) { ##precentage offer find
			$precentage=$postValue;
			$offerPrec=2;
			}
			if(preg_match("/".$nextFinal1."/",$postKey)) { ##next level offer find-1
			$nextOffer=$postValue;
			$offerNext=3;
			}
			if(preg_match("/".$nextFinal2."/",$postKey)) { ##next level offer find-2
			$nextOffer=$postValue;
			$offerNext=3;
			}

			if(preg_match("/".$extraFinal."/",$postKey)) { ##extra phone number offer find
			$extraPhone=$postValue;
			$offerPhone=4;
			}
			if(preg_match("/".$rateFinal."/",$postKey)) { ##Amount offer find
			$offerRateFinal=$postValue;
			$offerRate=5;
			}
			if(preg_match("/".$extraHoroscope."/",$postKey)) { ##HoroscopeCount offer find
				$extraHoroscopeCount=$postValue;
				$offerHoro=6;
			}
			if(preg_match("/".$extraDays."/",$postKey)) { ##extra days offer find
				$extraDaysCount=$postValue;
				$offerExtraDays=7;
			}

			if(preg_match("/".$extraHighlighter."/",$postKey)) { ##extra days offer find
				$extraHighlighterAmt=$postValue;
				$offerHighlighter=8;
			}

			if(preg_match("/".$extraBooster."/",$postKey)) { ##extra days offer find
				$extraBoosterAmt=$postValue;
				$offerBooster=9;
			}

	}
	$offerMail=0;
	$allotoAccess=0;

	##offer rearrange this function
	if((!empty($packageSelected)) && ($precentage > 0 || $offerRateFinal > 0 || $nextOffer!='' || $extraPhone!=''  || $extraHoroscopeCount > 0 || $extraDaysCount>0)){
		$easyPayQryString="";
			if($offerGift=="1"){ 
				$assuredGift=$arrangeOffer->offerdateforupdate($offerAll1,$assuredGift,$packageSelected,'3'); 
				$sepAssuredGift=explode('|',$assuredGift);
				$sepAssuredGiftRes=explode('~',$sepAssuredGift[0]);
				$easyPayQryString.="assuredGift=".$sepAssuredGiftRes[1].'&';
				$offerEntry[]=1;
			}
			if($offerPrec=="2" && $precentage>0) { 
				$offerPresentage=$arrangeOffer->offerdateforupdate($offerAll2,$precentage,$packageSelected,'1');
				$sepOfferPresentage=explode('|',$offerPresentage);
				$sepOfferPresentageRes=explode('~',$sepOfferPresentage[0]);
				$easyPayQryString.="disPercnt=".$sepOfferPresentageRes[1].'&';
				$offerEntry[]="2~".$precentage;
				
			}
			if($offerNext=="3" && $nextOffer!=''){
				$nextLevelOffer=$arrangeOffer->offerdateforupdate($offerAll3,$nextOffer,$packageSelected,'2');
				$sepNextLevelOffer=explode('|',$nextLevelOffer);
				$sepNextLevelOfferRes=explode('~',$sepNextLevelOffer[0]);
				$easyPayQryString.="nextLevel=".$sepNextLevelOfferRes[1].'&';
				$offerEntry[]="3~".$nextOffer;
			}
			if($offerPhone=="4" && $extraPhone!='') {
				$phoneOffer=$arrangeOffer->offerdateforupdate($offerAll4,$extraPhone,$packageSelected,'1'); 
				$sepPhoneOffer=explode('|',$phoneOffer);
				$sepPhoneOfferRes=explode('~',$sepPhoneOffer[0]);
				$easyPayQryString.="extraPhone=".$sepPhoneOfferRes[1].'&';
				$offerEntry[]="4~".$extraPhone;
			}
			if($offerRate=="5" && $offerRateFinal>0) {

				$amountOffer=$arrangeOffer->offerdateforupdate($offerAll5,$offerRateFinal,$packageSelected,'2'); 
				if($seleCurrency=='INR') 	$amountOfferINR=$amountOffer;	
				elseif($seleCurrency=='AED') 	$amountOfferAED=$amountOffer;
				elseif($seleCurrency=='USD') 	$amountOfferUSD=$amountOffer;
				elseif($seleCurrency=='GBP') $amountOfferGBP=$amountOffer;
				elseif($seleCurrency=='EURO') $amountOfferEURO=$amountOffer;

				$sepAmountOffer=explode('|',$amountOffer);
				$sepAmountOfferRes=explode('~',$sepAmountOffer[0]);
				$easyPayQryString.="DiscountAmount=".$sepAmountOfferRes[1]." ".$seleCurrency.'&';
				$offerEntry[]="5~".$offerRateFinal;
			}
			if($offerHoro=="6" && $extraHoroscopeCount > 0) {
				$HoroscopeOffer=$arrangeOffer->offerdateforupdate($offerAll6,$extraHoroscopeCount,$packageSelected,'2'); 
				$sepHoroscopeOffer=explode('|',$HoroscopeOffer);
				$sepPhoneOfferRes=explode('~',$sepHoroscopeOffer[0]);
				$easyPayQryString.="HoroscopeOffer=".$sepPhoneOfferRes[1]."&";
				$offerEntry[]="6~".$extraHoroscopeCount;
			}

			if($offerExtraDays=="7" && $extraDaysCount>0) {
				$extraDaysOffer=$arrangeOffer->offerdateforupdate($offerAll7,$extraDaysCount,$packageSelected,'1'); 
				$sepDaysOffer=explode('|',$extraDaysOffer);
				$sepExtraDaysOfferRes=explode('~',$sepDaysOffer[0]);
				$easyPayQryString.="extraDays=".$sepExtraDaysOfferRes[1];
				$offerEntry[]="7~".$extraDaysCount;
			}

			if(($offerHighlighter=="8" || $offerBooster=="9") && ($extraHighlighterAmt!="" || $extraBoosterAmt!="")) {
				if($offerAll8!="")  $addOfferAll=$offerAll8; 
				elseif($offerAll9!="")  $addOfferAll=$offerAll9;
				if($extraHighlighterAmt!="") {
					$addOnArray[101]=$extraHighlighterAmt;
					$offerEntry[]="8~".$extraHighlighterAmt; 
					$easyPayQryString.="profileHig=".$extraHighlighterAmt."&";
				}
				if($extraBoosterAmt!="")  {
					$addOnArray[54]=$extraBoosterAmt;
					$offerEntry[]="9~".$extraBoosterAmt;  
					$easyPayQryString.="matriBooster=".$extraBoosterAmt."&";
				}
						
				$extraAddOnpackUpdateValue=$arrangeOffer->offerdateforupdateaddon($addOfferAll,$addOnArray,$packageSelected,'4'); 

				if($seleCurrency=='INR')$amountAddOnOfferINR=$extraAddOnpackUpdateValue;	
				elseif($seleCurrency=='AED')$amountAddOnOfferAED=$extraAddOnpackUpdateValue;
				elseif($seleCurrency=='USD')$amountAddOnOfferUSD=$extraAddOnpackUpdateValue;
				elseif($seleCurrency=='GBP')$amountAddOnOfferGBP=$extraAddOnpackUpdateValue;
				elseif($seleCurrency=='EURO')$amountAddOnOfferEURO=$extraAddOnpackUpdateValue;
			}
			$easyPayQryString.="eprnewprice=".$eprOfferNewPrice;
		
			$offerUpdate =new tmofferupdate();						
			$getExecutedQuery=$offerUpdate->getiniciate($offerCateType,$_REQUEST['OFFERMATRIID'],$offerId,$offerCode,$assuredGift,$offerPresentage,$nextLevelOffer,$phoneOffer,$_REQUEST['UAETOINDIACURRENCE'],	$amountOfferINR,$amountOfferAED,$amountOfferUSD,$amountOfferGBP,$amountOfferEURO,$HoroscopeOffer,$extraDaysOffer,$captureOfferCurrency,$offerExpDate,$offerSource,$objMasterMatri);
			//mail("anbalagan@bharatmatrimony.com","Offer update-Query for CBS Local",$getExecutedQuery);
			$offerMail=1;

	}
?>
