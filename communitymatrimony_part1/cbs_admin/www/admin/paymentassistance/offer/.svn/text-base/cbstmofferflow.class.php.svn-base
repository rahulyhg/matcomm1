<?php
###########################################################################################################
#FileName		: tmofferflow.class.php
#Created		: On:2009-May-18
#Author		    : A.Anbalagan
#Description	: this file used to show the offers
###########################################################################################################

class offershow {

	private $matriId;
	private $offerMax=array();
	private $offer1=array();
	private $offer2=array();
	private $offer3=array();
	private $offer4=array();
	private $offer5=array();
	private $offerMax6=array();
	private $offerMin6=array();
	private $packOverride=array();
	private $assredGiftValue;
	private $precentageValue;
	private $amountValue;
	private $nextValue;
	private $extraPhoneValue;
	private $extraHoroscopeValue;
	private $splictValue;
	private $tmCateOfferMax;
	private $returnofferMax;
	private $catgTYpeRate=array();
	private $incVal=array();
	private $dboffer1;
	private $dboffer2;
	private $dboffer3;
	private $dboffer4;
	private $dboffer5;
	private $dbofferMax6;
	private $dbofferMin6;
	private $dboffer7;
	private $memberSlave;
	private $rates;
	private $maxOfferRate;
	private $horoscopeOfferRate;


	#CHECK OFFER AVAILABLE FOR USER
	function checkofferavailable($offlineCateType,$offerAvl,$dbCategoryId,$matriId,$memberSlave){
		
		global $DBNAME,$TABLE,$Offer1StartDateTime,$Offer1EndDateTime,$checkOfferCatId;
		
		$this->memberSlave=$memberSlave;
		$this->matriId=$matriId;

		/*if($offlineCateType=='CBSSU' || $offlineCateType=='CBSST' || $offlineCateType=='CBSSA') {
		
			if($offerAvl==1 && ($dbCategoryId==$checkOfferCatId[$offlineCateType] || $dbCategoryId==$checkOfferCatId['SU']) && ($offlineCateType=='ST' || $offlineCateType=='SA')) {
			$offerAvl=0;
			} 
		}*/

		if($offerAvl==0)  {
			#check the offer end date from global variables.
			$curdatetime=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
			if($Offer1StartDateTime<=$curdatetime and $Offer1EndDateTime>=$curdatetime) {
				$offerInfo['error']="";
			}
			else { $offerInfo['error']="Offer not available"; }
			
		} 
		else {
		$argCondition="where MatriId='".$this->matriId."' and OfferAvailedStatus=0 and (OfferStartDate <= NOW() and (OfferEndDate >= NOW() OR OfferEndDate='0000-00-00 00:00:00')) and OfferSource=0";

		$argFields = array('OfferCategoryId','OfferCode');
		$profileInfo=$this->memberSlave->select('offercodeinfo',$argFields,$argCondition,1);

		$checkCount = $this->memberSlave->numOfRecords($varTable['OFFERCODEINFO'],'OfferCategoryId',$argCondition);
		
			if($checkCount==0){
				$offerInfo['error']="Offer already used";
			}
		}
		if(empty($offerInfo['error'])) {

			if($offerAvl=='1'){
				
				$offerInfo[1]=$profileInfo[0]['OfferCategoryId'];
				$offerInfo[2]=$profileInfo[0]['OfferCode'];
				
				$oMasterArg = array('OfferEndDate');
				$oMasteCondition="where OfferCategoryId=".$profileInfo[0]['OfferCategoryId']."";

				$getOfferEndDate=$this->memberSlave->select('communitymatrimony.offermaster',$oMasterArg,$oMasteCondition,1);
				$offerExpDate=explode(' ',$getOfferEndDate[0]['OfferEndDate']);
				$offerInfo[3]=$offerExpDate[0];
				
			} else {
				$offerCodeValue=$this->getOfferCode($checkOfferCatId[$offlineCateType]);
				$offerInfo[1]=$checkOfferCatId[$offlineCateType];
				$offerInfo[2]=$offerCodeValue;

				$oMasterArg = array('OfferEndDate');
				$oMasteCondition="where OfferCategoryId=".$checkOfferCatId['CBSTMSUPPORT']."";

				$getOfferEndDate=$this->memberSlave->select('communitymatrimony.offermaster',$oMasterArg,$oMasteCondition,1);
				$offerExpDate=explode(' ',$getOfferEndDate[0]['OfferEndDate']);
				$offerInfo[3]=$offerExpDate[0];
			}
			
		}
		return	$offerInfo;	
	}
		#GET OFFERSOURCECODE
		function getOfferCode($offerCatId) {
			global  $arrDomainInfo;
			$len = strlen($offerCatId);  
			$maxOfferCodeLen = 4;		
			if($len<$maxOfferCodeLen)
			$paddedCode = str_pad($offerCatId, $maxOfferCodeLen, "0", STR_PAD_LEFT);
			$strMatriid=substr($this->matriId,0,3);
			foreach($arrDomainInfo as $key=>$val){
				if($val[1]==$strMatriid){
					$keyValId=$val[0];
				}
			}
			$newMatriId = str_replace($strMatriid,$keyValId,$this->matriId);
			return $paddedCode.$newMatriId;
		}
		#SHOW OFFER ONE BY ONE
		public function showofferdetails($cateId,$tmCateOfferMax=0,$currShow,$returnCateType='',$memberSlave='',$matriId='') {
			
			
			if($currShow=='INR') $currShowNew='RS';
			else $currShowNew=$currShow;

			$this->matriId=$matriId;
			$catgTYpeRate="finalCategoryRate".$currShowNew.$returnCateType;
			global $$catgTYpeRate,$maxOfferInc,$staretOfferInc;
			if(is_object($memberSlave)) { $this->memberSlave=$memberSlave; }

			$$dbRateType="Discount".$currShow."FlatRate";
			$finalFlateRate=$$dbRateType;	

			$offerArg = array('OfferOfflineMaxDiscount','DiscountPercentage','NextLevelOffer','ExtraPhoneNumbers','AssuredGift',$finalFlateRate,'DiscountINRFlatRate','DiscountAEDFlatRate','Override','OfferOfflineMaxHoroscope','OfferOfflineMinHoroscope');
			$offerCondition="where OfferCategoryId=$cateId";


			$offerData=$this->memberSlave->select('offercategoryinfo',$offerArg,$offerCondition,1);		
		
			if($offerData[0]['Override']!='') $packOverride=$this->getofferarray($offerData[0]['Override']); 
			if($offerData[0]['AssuredGift']!='') $offer1=$this->getofferarray($offerData[0]['AssuredGift']); 
			if($offerData[0]['DiscountPercentage']!='') 	$offer2=$this->getofferarray($offerData[0]['DiscountPercentage']);	if($offerData[0]['OfferOfflineMaxDiscount']!='') 	$offerMax=$this->getofferarray($offerData[0]['OfferOfflineMaxDiscount']);
			if($offerData[0]['NextLevelOffer']!='')  $offer3=$this->getofferarray($offerData[0]['NextLevelOffer']);
			if($offerData[0]['ExtraPhoneNumbers']!='') $offer4=$this->getofferarray($offerData[0]['ExtraPhoneNumbers']);
			if($offerData[0]['OfferOfflineMaxHoroscope']!='') $offerMax6=$this->getofferarray($offerData[0]['OfferOfflineMaxHoroscope']);	
			if($offerData[0]['OfferOfflineMinHoroscope']!='') $offerMin6=$this->getofferarray($offerData[0]['OfferOfflineMinHoroscope']);

			if($offerData[0][$finalFlateRate]!='') { 
				$offer5=$this->getofferarray($offerData[0][$finalFlateRate]);
				$offerRateDb=$offerData[0][$finalFlateRate];
				$this->catgTYpeRate=$$catgTYpeRate;
				$this->incVal[0]=$maxOfferInc[$currShow];
				$this->incVal[1]=$currShow;
				$this->incVal[2]=$staretOfferInc[$currShow];
			}
			$this->dboffer1=$offerData[0]['AssuredGift'];	
			$this->dboffer2=$offerData[0]['DiscountPercentage'];	
			$this->dboffer3=$offerData[0]['NextLevelOffer'];	
			$this->dboffer4=$offerData[0]['ExtraPhoneNumbers'];
			$this->dboffer5=$offerRateDb;
			$this->dbofferMax6=$offerData[0]['OfferOfflineMaxHoroscope'];	
			$this->dbofferMin6=$offerData[0]['OfferOfflineMinHoroscope'];

			$this->offer1=$offer1;
			$this->offer2=$offer2;
			$this->offer3=$offer3;
			$this->offer4=$offer4;
			$this->offer5=$offer5;
			$this->offerMax6=$offerMax6;
			$this->offerMin6=$offerMin6;
			$this->offerMax=$offerMax;
			$this->returnofferMax=$offerMax;
			$this->tmCateOfferMax=$tmCateOfferMax;
			$this->packOverride=$packOverride;
			$displayOffer=$this->displyoffer(); # this function used to display the offers
			return $displayOffer;
		}

		public function getmaxofferonly(){
			$retuenMaxStr='';
			if($this->returnofferMax[1]>0) {
				$retuenMax[0]="<div class='fright smalltxt' style='padding: 0px 10px 0px 0px;'><B>Max Discount :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->returnofferMax[1]."</FONT></div>";

				$retuenMaxStr.="<div class='fright smalltxt' style='padding: 0px 10px 0px 0px;'><B>Max Discount :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->returnofferMax[1]."</FONT>";
				if($this->tmCateOfferMax>0 ) {
				$retuenMaxStr.="&nbsp;<b>|<b>&nbsp;<B>Extreme Discount :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->tmCateOfferMax."</FONT>";
				}
				$retuenMaxStr.="</div>";
				$retuenMax[1]=$retuenMaxStr;
			}
			return $retuenMax;
		}

		public function getmaxAmountofferonly(){
			if($this->catgTYpeRate[1]>0 && $this->catgTYpeRate[4]>0 &&  $this->catgTYpeRate[7]>0) {
				$retuenMaxAmount="<div class='fright smalltxt' style='padding: 0px 10px 0px 0px;'><B>Gold :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->catgTYpeRate[1]." ".$this->incVal[1]."</FONT><B>Super Gold  :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->catgTYpeRate[4]." ".$this->incVal[1]."</FONT><B>Platinum :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->catgTYpeRate[7]." ".$this->incVal[1]."</FONT></div>";
			}
			return $retuenMaxAmount;
		}
		function getofferarray($offerType){

			$offerFlow=explode("|",$offerType); # divied the tilte char
					
			foreach($offerFlow as $packKey=>$pakValue) {
				$diffPackExp=explode("~",$pakValue);
				#search patten
				$patterns[0] = '/\+/';
				$patterns[1] = '/-/';
				$patterns[2] = '/&/';
				$patterns[3] = '/#/';
				#replace array
				$replace[0] = ',+,';
				$replace[1] = ',-,';
				$replace[2] = ',&,';
				$replace[3] = ',#,';
				$splictEachChar = preg_replace($patterns,$replace,$diffPackExp[1]);
				$packArray[$diffPackExp[0]]=$splictEachChar;
			}
			return $packArray;

		}


		function displyoffer(){

				global $OfferSavingShow,$noOfOffersSaving,$OfferSavingShowforJS,$flatPackDepe,$NextPackDepe;
				global $packType,$addOn101,$addOn54,$keyMatch,$varOfflineCurrency;

				$flag=$varOfflineCurrency[$this->incVal[1]];
				$packBaseRate=getOfferDetails($this->matriId,$flag);
				$packNames=$packBaseRate[0];
				$packRates=$packBaseRate[1];
				$this->horoscopeOfferRate=$packBaseRate[2];
				foreach($this->horoscopeOfferRate as $horKey=>$horoValue) {
				$horkeys.=$horKey."-";
				$hororates.=$horoValue."-";
				}
				$horkeysjs=substr($horkeys,0,-1);
				$horratejs=substr($hororates,0,-1);


				foreach($packRates as $packKey=>$packValue) {
					$rates.=$packRates[$packKey]."-";
					$packNamesAll.=$packNames[$packKey]."-";
					$countPack.=$packKey.",";
				}
				$countPack=substr($countPack,0,-1);
				$rates=substr($rates,0,-1);
				$this->rates=$rates;
				$packNamesAll=substr($packNamesAll,0,-1);

				$maxOfferRate=implode("-",$this->catgTYpeRate);
				$this->maxOfferRate=$maxOfferRate;
	
				foreach($packNames as $packKey=>$packValue) {

					$this->assredGiftValue=0;
					$this->precentageValue=0;
					$this->nextValue=0;
					$this->extraPhoneValue=0;
					$this->splictValue=0;
					$this->amountValue=0;
					$this->extraHoroscopeValue=0;
					$this->extraDaysValue=0;
					$this->extraprofileHighlighter=0;
					$this->extraMatrimonyBooster=0;
					$showOffers='';
					$seperateOffers=explode(",",$this->packOverride[$packKey]);
				
					foreach($seperateOffers as $singleOfferKey=>$singleOfferValues) {
						$savepackageName=str_replace('Month package','', $packNames[$packKey]);
						$packageName=trim($savepackageName);
						if($singleOfferValues=="&" || $singleOfferValues=="#" || $singleOfferValues=="+" || $singleOfferValues=="-") {
						$this->splictValue=$this->splictValue+1;
						$newSet=$packKey.$this->splictValue;	
						 $showOffers.="<input type=hidden name='PACKAGEDIVED$newSet' id='PACKAGEDIVED$newSet' value='$singleOfferValues'>";
						 $showOffers.="<span style='bgcolor:#c9c9c9' class='smalltxt'><b>".$keyMatch[$singleOfferValues]."</b></span>";
						}
						else {
						$showOffers.=$this->getalloffers($singleOfferValues,$packKey,$packNames);
						}	
					}
					#offer details display process
					$flinalShow='';
					$reset='';
					$savingShow=explode(",",$OfferSavingShow[$packKey]);
					$noOfSave=count($savingShow);

					if($noOfSave>0 && $OfferSavingShow[$packKey]!='') {
						
						$flinalShow.="<table border='0' cellpadding='2' cellspacing='1' align='left' class='smalltxt' bgcolor='#c9c9c9' style='font: normal 11px arial;' width='280'>";
						$savepackageName=str_replace('Month package','', $packNames[$packKey]);
						$packName='';
						$newPrice='';
						$oldPrice='';
						$newPriceFirstApp='';
						$i=0;
						foreach($savingShow as $savKey=>$saveVal) {
							if($noOfOffersSaving[$saveVal]!='') {
								if($noOfOffersSaving[$saveVal]!='NextLevel') {
									$packName.="<td><span class='smalltxt'>".$noOfOffersSaving[$saveVal]."</span></td>";
									$oldPrice.="<td><span id='BASE$packKey$saveVal' class='smalltxt'>0</span></td>";
								}
							if(!in_array('3',$savingShow)) {
							$newPriceFirstApp="<td><span id='SAVE$packKey3' class='smalltxt'>0</span></td>";	
							}
							$newPrice.="<td><span id='SAVE$packKey$saveVal' class='smalltxt'>0</span></td>";
							$i++;
							}
						}
							$sapntd=$i+3;
							$flinalShow.="<tr class='smalltxt' bgcolor='#ffffff'><td align='right' colspan=".$sapntd.">New Price:-&nbsp;&nbsp;</B><span id='NEWPRICE$packKey' class='boldtxt'>".$packRates[$packKey]."</span></td></tr>";
							
							$flinalShow.="<tr class='smalltxt' bgcolor='#ffffff' >
							<td align='left'><B>Offer :-</B></td><td align='left'><span id='PACKNAME$packKey'>".$savepackageName."</span></td>".$packName."<td align='left'>Total</td></tr>";
							
							$flinalShow.="<tr class='smalltxt' bgcolor='#ffffff'><td align='left'><B>Base :-</B></td><td align='left'><span id='PACKRATES$packKey'>".$packRates[$packKey]."</span></td>".$oldPrice."<td><span id='BASETOTAL$packKey' class='smalltxt'>0</span><input type='hidden'  name='EPROFFERPRICE$packKey' id='EPROFFERPRICE$packKey' value='".$packRates[$packKey]."'></td></tr>";
							
							$flinalShow.="<tr class='smalltxt' bgcolor='#ffffff'>
							<td align='left'><B>Savings :-</B></td>".$newPriceFirstApp.$newPrice."<td><span id='SAVINGSTOTAL$packKey' class='smalltxt'>0</span></td></tr>";
						
						if($packKey==1) {
						$flinalShow.="<input type='hidden' value='$keyOff' id='OFFICE' name='OFFICE'>
						<input type='hidden' value='$packNamesAll' id='SAVEPACKNAMES' name='SAVEPACKNAMES'>
						<input type='hidden' value='$rates' id='SAVEOVERALLRATES' name='SAVEOVERALLRATES'>
						<input type='hidden' value='$maxOfferRate' id='SAVEMAXOFFERRATE' name='SAVEMAXOFFERRATE'>
						<input type='hidden' value='$horkeysjs' id='HOROKEYSONLY' name='HOROKEYSONLY'>
						<input type='hidden' value='$horratejs' id='HORORATEONLY' name='HORORATEONLY'>
						<input type='hidden' value='$countPack' id='TOTALPACKAGE' name='TOTALPACKAGE'>
						<input type='hidden' value='".$addOn101[$this->incVal[1]]."' id='PROFILEHIGHLIGHT' name='PROFILEHIGHLIGHT'>
						<input type='hidden' value='".$addOn54[$this->incVal[1]]."'  id='RESPONSEBOOSTER' name='RESPONSEBOOSTER'>";
						}

						$flinalShow.="<input type='hidden' value='$NextPackDepe[$packKey]' id='SAVENEXTLEVEL$packKey' name='SAVENEXTLEVEL$packKey'>
						<input type='hidden' value='$flatPackDepe[$packKey]' id='SAVEFLAT$packKey' name='SAVEFLAT$packKey'>
						<input type='hidden' value='$HoroscopeDep[$packKey]' id='SAVEHOROSCOPEDEP$packKey' name='SAVEHOROSCOPEDEP$packKey'>
						<input type='hidden' value='$OfferSavingShowforJS[$packKey]' id='SHOWPACKVALUE$packKey' name='SHOWPACKVALUE$packKey'>
						<input type='hidden' id='SAVINGSNEXT$packKey' name='SAVINGSNEXT$packKey' value=0>
						<input type='hidden' id='SAVINGSAMOUNT$packKey' name='SAVINGSAMOUNT$packKey' value=0>
						<input type='hidden' id='SAVINGSHOROSCOPE$packKey' name='SAVINGSHOROSCOPE$packKey' value=0>
						<input type='hidden' id='BASAMOUNT$packKey' name='BASAMOUNT$packKey' value=".$packRates[$packKey].">
						<input type='hidden' id='ADDON$packKey' name='ADDON$packKey' value='0'>
						<input type='hidden' id='ADDONOFFER$packKey' name='ADDONOFFER$packKey'  value='0'>
						<input type='hidden' id='SAVINGADDONOFFER$packKey' name='SAVINGADDONOFFER$packKey' value='0'>
						</table><br clear='all'>&nbsp;";
						$reset="resetshows('".$packKey."');";
					}

					$frmPge=$packKey;
					$packagesForm[$packKey]="<DIV name='FRMOFFER$frmPge' id='FRMOFFER$frmPge'><input type='radio' name='PACKAGESELECT' id='PACKAGESELECT'  value='".$packKey."' onclick=offerenable('".$packKey."');callBack();$reset> 
					<font class='clr3 boldtxt'>".$packageName."</font><div name='PACKAGEDIV$packKey' id='PACKAGEDIV$packKey' style='padding: 10px;display:none;'>".$showOffers."&nbsp;<a href='javascript:;' onclick=resetval();$reset style='text-decoration:none;' class='clr1'>Reset</a></div></DIV>".$flinalShow;
				}
				return $packagesForm;
		}#close the function
		

		function getalloffers($singleOfferValues,$packKey,$packNames) {
			global $OFFERGIFTARRAY,$maxOfferInc,$OfferSavingShow,$NextPackDepe;
			$offerReturn='';
			#Assured Offer
			if($singleOfferValues==1) {
			$this->assredGiftValue=$this->assredGiftValue+1;
			$newSet1=$packKey.$this->assredGiftValue;
			$assuredGift=explode(",",$this->offer1[$packKey]);
			
				$offerReturn.="<font class='smalltxt'><B>Assured Gift</B>:</font> ";
				if(in_array("#",$assuredGift)) {
					foreach($assuredGift as $assuredKey=>$assuredValue) {						
						if($assuredValue!='#') {
						$assNew=$assuredValue;
						$offerReturn.="<INPUT TYPE='radio' value='$assuredValue' name='ASSURED$newSet1' id='ASSURED$newSet1' onclick=checkfun(this.name);>".$OFFERGIFTARRAY[$assNew];
						}
					}
					#$offerReturn.="<INPUT TYPE='hidden' value='#' name='OFFER".$packKey."1'>";
				}
				else if(in_array("&",$assuredGift)) {
					$i=1;
					foreach($assuredGift as $assuredKey=>$assuredValue) {
						if($assuredValue!='&') {
						$assNew=$assuredValue;
						$offerReturn.="<INPUT TYPE='checkbox' value='$assNew' name='ASSURED".$newSet1.$i."' id='ASSURED".$newSet1.$i."' onclick=checkfun(this.name);>".$OFFERGIFTARRAY[$assNew];
						}
						$i++;
					}
					#$offerReturn.="<INPUT TYPE='hidden' value='&' name='OFFER".$packKey."1'>";
				}
				$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer1."' name='OFFERALL1'>";
			}
			#precentage 
			if($singleOfferValues==2) {
	
			$this->precentageValue=$this->precentageValue+1;
			$newSet2=$packKey.$this->precentageValue;
			$offerReturn.="<font class='smalltxt'><B>Discount Percentage</B> :</font>";
			$offerReturn.="<select name='PRECNTAGE$newSet2' id='PRECNTAGE$newSet2' onChange='checkfun(this.name);' style='font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;border: 1px solid #D7E5F2;'>";
			$offerReturn.="<option key='0' style='font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;'  selected>0</option>";
				if($this->tmCateOfferMax > 0) {
					$this->offerMax[$packKey]=$this->tmCateOfferMax;
				}
				for($i=$this->offer2[$packKey];$i<=$this->offerMax[$packKey];$i++) {
					
					if($this->returnofferMax[$packKey]<$i && $this->tmCateOfferMax>0) {
					$offerReturn.="<option value='$i' style='font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;color:red;border: 1px solid #D7E5F2;font-weight:bold'>$i</option>";
					} else {
					$offerReturn.="<option value='$i' style='font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;color:green;font-weight:bold;border: 1px solid #D7E5F2;'>$i</option>";
					}
				}
			$offerReturn.="</select>";
			$offerReturn.="<INPUT TYPE='hidden' value='2' name='OFFER".$packKey."2'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer2."' name='OFFERALL2'>";
			}
			#next levwl offer
			if($singleOfferValues==3) {						

			if(array_key_exists($packKey,$OfferSavingShow)) {
			$jsLoad="showSavings('3',this,'$packKey');";
			} else { $jsLoad=''; }
			$newPackageId=$NextPackDepe[$packKey];
			$packageName=str_replace('package', '',$packNames[$newPackageId]); 
			$this->nextValue=$this->nextValue+1;
			$newSet3=$packKey.$this->nextValue;
			$offerReturn.="<font class='smalltxt'><B>Next Level </B>:</font><input type='checkbox' name='NEXTLEVEL$newSet3'  id='NEXTLEVEL$newSet3' value='".$this->offer3[$packKey]."' onclick=checkfun(this.name);$jsLoad>".$packageName;
			$offerReturn.="<INPUT TYPE='hidden' value='3' name='OFFER".$packKey."3'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer3."' name='OFFERALL3'>";
			}
			#extra phone number
			if($singleOfferValues==4) {
			$this->extraPhoneValue=$this->extraPhoneValue+1;
			$newSet4=$packKey.$this->extraPhoneValue;
			$offerReturn.="<font class='smalltxt'><B>Phone Number </B>:</font><input type='checkbox' name='EXTRAPHONE$newSet4' id='EXTRAPHONE$newSet4' value='".$this->offer4[$packKey]."' onclick=checkfun(this.name);> ".$this->offer4[$packKey]." Extra Phone Number";
			$offerReturn.="<INPUT TYPE='hidden' value='4' name='OFFER".$packKey."4'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer4."' name='OFFERALL4'>";
			}
			#Amount offer
			if($singleOfferValues==5) {

			if(array_key_exists($packKey,$OfferSavingShow)) {
			$jsLoad="showSavings('5',this,'$packKey');";
			} else { $jsLoad=''; }
			$this->amountValue=$this->amountValue+1;
			$newSet5=$packKey.$this->amountValue;
			$offerReturn.="<font class='smalltxt'><B>Discount (".$this->incVal[1].")</B> :</font>";
			$offerReturn.="<select name='RATE$newSet5' id='RATE$newSet5' onChange=checkfun(this.name);$jsLoad class='inputtext'>";

			$offerReturn.="<option value='0' selected>0</option>";
				for($i=$this->incVal[2];$i<=$this->catgTYpeRate[$packKey];$i=$i+$this->incVal[2]) {
					$offerReturn.="<option value='$i'>$i</option>";
				}
			$offerReturn.="</select>";
			$offerReturn.="<INPUT TYPE='hidden' value='5' name='OFFER".$packKey."5'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer5."' name='OFFERALL5'>";
			}

			#extra Horoscope number
			if($singleOfferValues==6) {

			if(array_key_exists($packKey,$OfferSavingShow)) {
			$jsLoad="showSavings('6',this,'$packKey');";
			} else { $jsLoad=''; }
			$this->extraHoroscopeValue=$this->extraHoroscopeValue+1;
			$newSet6=$packKey.$this->extraHoroscopeValue;
			$offerReturn.="<font class='smalltxt'><B>Horoscope </B> :</font>";
			$offerReturn.="<select name='EXTRAHOROSCOPE$newSet6' id='EXTRAHOROSCOPE$newSet6' onChange=checkfun(this.name);$jsLoad class='inputtext'>";
	
			foreach($this->horoscopeOfferRate as $offerHororK=>$offerHororV) {
			$offerReturn.="<option value='$offerHororK'>$offerHororK</option>";
			}
			$offerReturn.="</select>";
			$offerReturn.="<INPUT TYPE='hidden' value='6' name='OFFER".$packKey."6'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dbofferMax6."' name='OFFERALLMAX6'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dbofferMin6."' name='OFFERALLMIN6'>";
			}
			#extra days
			if($singleOfferValues==7) {

			$this->extraDaysValue=$this->extraDaysValue+1;
			$newSet7=$packKey.$this->extraDaysValue;
			$offerReturn.="<font class='smalltxt'><B>Extra Days </B>:</font><input type='checkbox' name='EXTRADAYS$newSet7' id='EXTRADAYS$newSet7' value='".$this->offer7[$packKey]."' onclick=checkfun(this.name);>  Extra ".$this->offer7[$packKey]." Days";
			$offerReturn.="<INPUT TYPE='hidden' value='7' name='OFFER".$packKey."7'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer7."' name='OFFERALL7'>";
			}
			#extra Profile Highlighter
			if($singleOfferValues==8) {
			
			if(array_key_exists($packKey,$OfferSavingShow)) {
			$jsLoad="showSavings('8',this,'$packKey');";
			} else { $jsLoad=''; }
			$currAddOnType1= $this->incVal[1];
			$addOnPack1=$addOnOffer101[$currAddOnType1];
			$this->extraprofileHighlighter=$this->extraprofileHighlighter+1;
			$newSet8=$packKey.$this->extraprofileHighlighter;
			$offerReturn.="<font class='smalltxt'><B>Add On </B>:</font><input type='checkbox' name='EXTRAHIGHLIGHTER$newSet8' id='EXTRAHIGHLIGHTER$newSet8' value='".$addOnPack1."' onclick=checkfun(this.name);$jsLoad>  Profile Highlighter";
			$offerReturn.="<INPUT TYPE='hidden' value='8' name='OFFER".$packKey."8'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer8."' name='OFFERALL8'>";
			}
			#extra Matrimony Booster
			if($singleOfferValues==9) {
			
			if(array_key_exists($packKey,$OfferSavingShow)) {
			$jsLoad="showSavings('9',this,'$packKey');";
			} else { $jsLoad=''; }
			$currAddOnType2= $this->incVal[1];
			$addOnPack2=$addOnOffer54[$currAddOnType2];
			$this->extraMatrimonyBooster=$this->extraMatrimonyBooster+1;
			$newSet9=$packKey.$this->extraMatrimonyBooster;
			$offerReturn.="<font class='smalltxt'><B>Add On </B>:</font><input type='checkbox' name='EXTRABOOSTE$newSet9' id='EXTRABOOSTE$newSet9' value='".$addOnPack2."' onclick=checkfun(this.name);$jsLoad> Matrimony Booster ";
			$offerReturn.="<INPUT TYPE='hidden' value='9' name='OFFER".$packKey."9'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer9."' name='OFFERALL9'>";
			}
		
			return $offerReturn;
		}
	public function offerdateforupdate($offerAll,$offerSelected,$packageSelected,$offerCondition){
					
					$inkey=$packageSelected.'~'.$offerSelected;
					$sepInKey=explode('~',$inkey);
					$sepPackageKey=explode('|',$offerAll);
					$lengthPackage=count($sepPackageKey);
					for($m=0;$m<$lengthPackage;$m++){
								$sepRemainVal=explode('~',$sepPackageKey[$m]);
								if($sepRemainVal[0]==$sepInKey[0]){
									if($offerCondition=='3'){$sepFindValue=$sepPackageKey[$m].'|';	}
									elseif($offerCondition=='1' || $offerCondition=='2'){$sepFindValue=$inkey.'|';	}
								}
								else{	
										if($offerCondition=='2'){
										$remainValue .=$sepPackageKey[$m].'|';
										}
										elseif($offerCondition=='1'){$remainValue .=$sepRemainVal[0].'~'.$sepInKey[1].'|';	}
										elseif($offerCondition=='3'){	$remainValue .=$sepPackageKey[$m].'|';		}
								}
					}
					$varLength=strlen($remainValue);
					$findString=substr($remainValue,($varLength-1),$varLength);
					if($findString=='|'){
						$remainValueRes=substr($remainValue,0,($varLength-1));
					}
					return $returnOk=$sepFindValue.$remainValueRes;
						
		}


			public function offerdateforupdateaddon($offerAll,$addOnPack,$packageSelected,$offerCondition){
					$dbupdateStr="";
					$sepPackageKey=explode('|',$offerAll);
					foreach($sepPackageKey as $addOnKey=>$addOnValue) {
						$sepAddOnPack=explode(":",$addOnValue);
						$maxCount=count($sepAddOnPack);
						$i=0;
						foreach($sepAddOnPack as $sepAddOnKey=>$sepAddOnValue) {
								
								$finalAddonValue=explode("~",$sepAddOnValue);
								if($finalAddonValue[0]==$packageSelected) {
									if($addOnPack[$finalAddonValue[1]]!="") { 
									$offerVal=$addOnPack[$finalAddonValue[1]];
									$setFirst.=$finalAddonValue[0]."~".$finalAddonValue[1]."~".$offerVal.":";
									}
									$i++;
									if($i==$maxCount) $setFirst=$setFirst."|";
								} else {
								if($addOnPack[$finalAddonValue[1]]!="") { 
								$setNext.=$finalAddonValue[0]."~".$finalAddonValue[1]."~".$finalAddonValue[2].":";
								}
								$i++;
								if($i==$maxCount) $setNext=$setNext."|";
								}
						}
				}
					$dbupdateStr=$setFirst.$setNext;
					if($dbupdateStr!="") {
						$remainValue=str_replace(":|","|",$dbupdateStr);
						$varLength=strlen($remainValue);
						$findString=substr($remainValue,($varLength-1),$varLength);
						if($findString=='|'){
							$remainValueRes=substr($remainValue,0,($varLength-1));
						}
					}
					return $remainValueRes;
			}
}//class close
?>