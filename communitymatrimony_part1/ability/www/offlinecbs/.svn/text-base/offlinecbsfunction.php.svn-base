<?php

function format_MemberAssuredGift($cnt) {
	global $rslt_offer,$jsonRslt, $OFFERGIFTARRAY;
	if($rslt_offer['MemberAssuredGift'] && is_array($OFFERGIFTARRAY) && sizeof($OFFERGIFTARRAY)>0) {
		$jsonRslt['Result'][$cnt]['AssuredGift'] = $rslt_offer['MemberAssuredGift'];
	}
	else {
		$jsonRslt['Result'][$cnt]['AssuredGift'] = '';
	}
}

function checkOffer($matriid,$objdbclass,$productid='',$curid='',$myhomepage='') {
	
	global $varTable,$objdbclass,$varCurrGbpToUsd,$varCurrAedToUsd,$varCurrEurToUsd,$varCurrUsdToInr,$varCurrAedToInr,$varCurrInrToUsd,$varCurrInrToGbp,$varCurrInrToAed,$varCurrInrToEur,$varCurrUsdToGbp,$varCurrUsdToAed,$varCurrUsdToEur,$varCurrAedToGbp,$varCurrAedToEur;
	$flatrate_enabled=1;
	$offervalues=array();
  
	$currencyArrayValues =array('gbptousd' => $varCurrGbpToUsd,'aedtousd' => $varCurrAedToUsd,'eurotousd' => $varCurrEurToUsd,'usdtoinr' => $varCurrUsdToInr,'aedtoinr' => $varCurrAedToInr,'inrtousd' => $varCurrInrToUsd,'inrtogbp' => $varCurrInrToGbp,'inrtoaed' => $varCurrInrToAed,'inrtoeur' => $varCurrInrToEur,'usdtogbp' => $varCurrUsdToGbp,'usdtoaed' => $varCurrUsdToAed,'usdtoeur' => $varCurrUsdToEur,'aedtogbp' => $varCurrAedToGbp,'aedtoeur' => $varCurrAedToEur);

	$Varfields = array("MatriId","OfferCategoryId","OfferCode","OfferStartDate","OfferEndDate","OfferAvailedStatus","OfferAvailedOn","OfferSource","MemberDiscountPercentage","MemberDiscountINRFlatRate","MemberDiscountUSDFlatRate","MemberDiscountEUROFlatRate","MemberDiscountAEDFlatRate","MemberDiscountGBPFlatRate","MemberAssuredGift","MemberNextLevelOffer","OmmParticipation","DateUpdated","MemberExtraPhoneNumbers");
	$varActCondtn	= " WHERE MatriId='".$matriid."' and OfferAvailedStatus=0 and date(OfferStartDate) <= CURDATE() and (date(OfferEndDate) >= CURDATE())";

	$recrowstotal		= $objdbclass->select($varTable['OFFERCODEINFO'],$Varfields,$varActCondtn,1);	
	
	if(count($recrowstotal) > 0) {
		$recrows = $recrowstotal[0];
		if($productid!='') { 
				if(getsplitvalues($recrows,'MemberDiscountPercentage',$productid)!='') {
					$offervalues['MemberDiscountPercentage']=getsplitvalues($recrows,'MemberDiscountPercentage',$productid);
				}
				if(getsplitvalues($recrows,'MemberAssuredGift',$productid)!='') {				
					$offervalues['MemberAssuredGift']=getsplitvalues($recrows,'MemberAssuredGift',$productid);
				}
				if(getsplitvalues($recrows,'MemberNextLevelOffer',$productid)!='') {
					$offervalues['MemberNextLevelOffer']=getsplitvalues($recrows,'MemberNextLevelOffer',$productid);
				}
				if(getsplitvalues($recrows,'OmmParticipation',$productid)!='') {
					$offervalues['OmmParticipation']=getsplitvalues($recrows,'OmmParticipation',$productid);
				}
				if(getsplitvalues($recrows,'MemberExtraPhoneNumbers',$productid)!='') {
					$offervalues['ExtraPhoneNumbers']=getsplitvalues($recrows,'MemberExtraPhoneNumbers',$productid);
				}
				if(getsplitvalues($recrows,'MemberDiscountINRFlatRate',$productid)!='') {//New
						$offervalues['MemberDiscountINRFlatRate']=getsplitvalues($recrows,'MemberDiscountINRFlatRate',$productid);
					}
				 /*NEW*/ 
					 if($offervalues['MemberDiscountPercentage']=='' && $offervalues['MemberDiscountINRFlatRate']!='') { 
						$flatrate_enabled=1;
						
						//$currencyArrayValues = json_decode(curlFetchCurrencyValue($http_url),1);
						//extract($currencyArrayValues); 
						if($curid=='GBP'){ 
							if(getsplitvalues($recrows,'MemberDiscountGBPFlatRate',$productid)!='') {
								$offervalues['MemberDiscountGBPFlatRate']=getsplitvalues($recrows,'MemberDiscountGBPFlatRate',$productid);
							}
							else {
								$offervalues['MemberDiscountGBPFlatRate']=$offervalues['MemberDiscountINRFlatRate']*$currencyArrayValues['inrtogbp'];
							}
						}elseif($curid=='AED') {
							if(getsplitvalues($recrows,'MemberDiscountAEDFlatRate',$productid)!='') {
								$offervalues['MemberDiscountAEDFlatRate']=getsplitvalues($recrows,'MemberDiscountAEDFlatRate',$productid);
							}
							else {
							   $offervalues['MemberDiscountAEDFlatRate']=$offervalues['MemberDiscountINRFlatRate']*$currencyArrayValues['inrtoaed'];
							}
						}elseif($curid=='Rs.') { 
							 $offervalues['MemberDiscountINRFlatRate']=$offervalues['MemberDiscountINRFlatRate'];
						       //No conversion Here. Because of taking the INR rate as default FLAT Rate.
						}elseif($curid=='US$') {
							if(getsplitvalues($recrows,'MemberDiscountUSDFlatRate',$productid)!='') {
								$offervalues['MemberDiscountUSDFlatRate']=getsplitvalues($recrows,'MemberDiscountUSDFlatRate',$productid);
							}
							else {
						         $offervalues['MemberDiscountUSDFlatRate']=$offervalues['MemberDiscountINRFlatRate']*$currencyArrayValues['inrtousd'];
							}
					   }elseif($curid=='EUR') {
							if(getsplitvalues($recrows,'MemberDiscountEUROFlatRate',$productid)!='') {
								$offervalues['MemberDiscountEUROFlatRate']=getsplitvalues($recrows,'MemberDiscountEUROFlatRate',$productid);
							}
							else {
						         $offervalues['MemberDiscountEUROFlatRate']=$offervalues['MemberDiscountINRFlatRate']*$currencyArrayValues['inrtoeur'];
							}
					    }
					 }else{
						$flatrate_enabled=0;
					 }
					 /*NEW END*/
		} else{			
			if($recrows['MemberDiscountPercentage']!='') {
				$offervalues['MemberDiscountPercentage']=$recrows['MemberDiscountPercentage'];
			}
			if($recrows['MemberAssuredGift']!='') {
				$offervalues['MemberAssuredGift']=$recrows['MemberAssuredGift'];
			}
			if($recrows['MemberNextLevelOffer']!='') {
				$offervalues['MemberNextLevelOffer']=$recrows['MemberNextLevelOffer'];
			}
			if($recrows['MemberExtraPhoneNumbers']!='') {
				$offervalues['ExtraPhoneNumbers']=$recrows['MemberExtraPhoneNumbers'];
			}
		}
		if($recrows['OfferCategoryId']!='') {
			$offervalues['OfferCategoryId']=$recrows['OfferCategoryId'];
		}
		if($recrows['OfferCode']!='') {
			$offervalues['OfferCode']=$recrows['OfferCode'];
		}
		if($recrows['OfferEndDate']!='') {
			$offervalues['OfferEndDate']=$recrows['OfferEndDate'];
		}
		if($recrows['OmmParticipation']==1) {
			$offervalues['OmmParticipation']=$recrows['OmmParticipation'];
		}

		$offercategoryid=$recrows['OfferCategoryId'];
		//Offer found for the passed MatriId
		
		$CategoryVarfields = array("OfferCategoryId","OfferPromoImg","OfferPromoTxt","RightPanelText","MatchWatchText","MyhomeSystemPopup","PaymentOptionHeader","MailerTemplate","OfferOfflineMaxDiscount","NextLevelOffer","ExtraDays","ExtraPhoneNumbers","DiscountPercentage","DiscountINRFlatRate","DiscountUSDFlatRate","DiscountEUROFlatRate","DiscountAEDFlatRate","DiscountGBPFlatRate","AssuredGift","Override","DateUpdated");

		$CategoryvarActCondtn	= " WHERE OfferCategoryId='".$offercategoryid."'";

		$categorytot		        = $objdbclass->select($varTable['OFFERCATEGORYINFO'],$CategoryVarfields,$CategoryvarActCondtn,1);

		if(count($categorytot)>0) {
			$category = $categorytot[0];
			//Offer category id found in offercategoryinfo table
			if($productid=='' && $myhomepage=='') {
				//Combine offervalues array with category array
				$offercombinations = array_merge($offervalues, $category);
				return $offercombinations;				
			}
			if($category['OfferPromoImg']!='') {
				$offervalues['OfferPromoImg']=$category['OfferPromoImg'];
			}
			if($category['OfferPromoTxt']!='') {
				$offervalues['OfferPromoTxt']=$category['OfferPromoTxt'];
			}			
			if(getsplitvalues($category,'DiscountPercentage',$productid)!='') {
				$offervalues['DiscountPercentage']=getsplitvalues($category,'DiscountPercentage',$productid);
			}
			if(getsplitvalues($category,'OfferOfflineMaxDiscount',$productid)!='') {				
				$offervalues['OfferOfflineMaxDiscount']=getsplitvalues($category,'OfferOfflineMaxDiscount',$productid);
			}
			if(getsplitvalues($category,'NextLevelOffer',$productid)!='') {
				$offervalues['NextLevelOffer']=getsplitvalues($category,'NextLevelOffer',$productid);
			}
			if(getsplitvalues($category,'ExtraDays',$productid)!='') {
				$offervalues['ExtraDays']=getsplitvalues($category,'ExtraDays',$productid);
			}
			/*if(getsplitvalues($category,'ExtraPhoneNumbers',$productid)!='') {
				$offervalues['ExtraPhoneNumbers']=getsplitvalues($category,'ExtraPhoneNumbers',$productid);
			}*/
			if(getsplitvalues($category,'DiscountPercentage',$productid)!='') {
				$offervalues['DiscountPercentage']=getsplitvalues($category,'DiscountPercentage',$productid);
			}
			if(getsplitvalues($category,'DiscountINRFlatRate',$productid)!='') {
				$offervalues['DiscountINRFlatRate']=getsplitvalues($category,'DiscountINRFlatRate',$productid);
			}
			if(getsplitvalues($category,'DiscountUSDFlatRate',$productid)!='') {
				$offervalues['DiscountUSDFlatRate']=getsplitvalues($category,'DiscountUSDFlatRate',$productid);
			}
			if(getsplitvalues($category,'DiscountEUROFlatRate',$productid)!='') {
				$offervalues['DiscountEUROFlatRate']=getsplitvalues($category,'DiscountEUROFlatRate',$productid);
			}
			if(getsplitvalues($category,'DiscountAEDFlatRate',$productid)!='') {
				$offervalues['DiscountAEDFlatRate']=getsplitvalues($category,'DiscountAEDFlatRate',$productid);
			}
			if(getsplitvalues($category,'DiscountGBPFlatRate',$productid)!='') {
				$offervalues['DiscountGBPFlatRate']=getsplitvalues($category,'DiscountGBPFlatRate',$productid);
			}
			if(getsplitvalues($category,'AssuredGift',$productid)!='') {
				$offervalues['AssuredGift']=getsplitvalues($category,'AssuredGift',$productid);
			}
			if(getsplitvalues($category,'Override',$productid)!='') {
				$offervalues['Override']=getsplitvalues($category,'Override',$productid);
			}
		}
	}
	return $offervalues;		
}


function getsplitvalues($category,$arrkey,$productid) {
	if($category[$arrkey]!="") {
				$temparr=explode("|", $category[$arrkey]);
				foreach ($temparr as $value) {
					$tempvalarr=explode("~",$value);
					if($tempvalarr[0]==$productid) {
						$offervalue=$tempvalarr[1];
						break;
					}
				}
			}else{
				$offervalue='';
			}

	return $offervalue;
}
?>