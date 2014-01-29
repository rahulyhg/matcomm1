<?php
###########################################################################################################
#FileName		: cbstmofferflow.class.php
#Created		: On:2010-Jan-02
#Author		    : A.Kirubasankar
#Description	: this file used to show the offers
###########################################################################################################
#ini_set('display_errors','on');
#error_reporting(E_ALL ^ E_NOTICE);
class offershow {

	private $matriId;
	private $offerMax=array();
	private $offer1=array();
	private $offer2=array();
	private $offer3=array();
	private $offer4=array();
	private $offer5=array();
	private $packOverride=array();
	private $assredGiftValue;
	private $precentageValue;
	private $nextValue;
	private $extraPhoneValue;
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
	private $memberSlave;



	#CHECK OFFER AVAILABLE FOR USER
	function checkofferavailable($offlineCateType,$offerAvl,$dbCategoryId,$matriId,$memberSlave){
		
		global $varTable,$Offer1StartDateTime,$Offer1EndDateTime,$checkOfferCatId;
		
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
				$oMasteCondition="where OfferCategoryId=".$profileInfo[0]['OfferCategoryId']."";

				$getOfferEndDate=$this->memberSlave->select('communitymatrimony.offermaster',$oMasterArg,$oMasteCondition,1);
				$offerExpDate=explode(' ',$getOfferEndDate[0]['OfferEndDate']);
				$offerInfo[3]=$offerExpDate[0];
			}
			
		}
		return	$offerInfo;	
	}
		#GET OFFERSOURCECODE
		function getOfferCode($offerCatId) {
			global  $arrMatriIdPre;
			$len = strlen($offerCatId);  
			$maxOfferCodeLen = 4;		
			if($len<$maxOfferCodeLen)
			$paddedCode = str_pad($offerCatId, $maxOfferCodeLen, "0", STR_PAD_LEFT);

			$firstThree = substr($this->matriId,0,3);

			$newMatriId = str_replace($firstThree, array_search($firstThree,$arrMatriIdPre), $this->matriId);
			return $paddedCode.$newMatriId;
		}
		#SHOW OFFER ONE BY ONE
		public function showofferdetails($cateId,$tmCateOfferMax=0,$officeId=0,$returnCateType='') {
			
			
		
			$catgTYpeRateRS="finalCategoryRateRS".$returnCateType;
			$catgTYpeRateAED="finalCategoryRateAED".$returnCateType;

			global $$catgTYpeRateRS,$$catgTYpeRateAED,$varTable;

			$offerArg = array('OfferOfflineMaxDiscount','DiscountPercentage','NextLevelOffer','ExtraPhoneNumbers','AssuredGift', 'DiscountINRFlatRate','DiscountAEDFlatRate','Override');
			$offerCondition="where OfferCategoryId=$cateId";


			$offerData=$this->memberSlave->select('offercategoryinfo',$offerArg,$offerCondition,1);

	
			if($offerData[0]['Override']!='') {$packOverride=$this->getofferarray($offerData[0]['Override']); }
			if($offerData[0]['AssuredGift']!='') { $offer1=$this->getofferarray($offerData[0]['AssuredGift']); }
			if($offerData[0]['DiscountPercentage']!='') { 	$offer2=$this->getofferarray($offerData[0]['DiscountPercentage']); }	if($offerData[0]['OfferOfflineMaxDiscount']!='') {	$offerMax=$this->getofferarray($offerData[0]['OfferOfflineMaxDiscount']); 
			}
			if($offerData[0]['NextLevelOffer']!='') { $offer3=$this->getofferarray($offerData[0]['NextLevelOffer']); }
			if($offerData[0]['ExtraPhoneNumbers']!='') {$offer4=$this->getofferarray($offerData[0]['ExtraPhoneNumbers']);	}
			if($officeId=='28') {
				if($offerData[0]['DiscountAEDFlatRate']!='') { 
				$offer5=$this->getofferarray($offerData[0]['DiscountAEDFlatRate']); 
				$offerRateDb=$offerData[0]['DiscountAEDFlatRate'];
				$this->catgTYpeRate=$$catgTYpeRateAED;
				$this->incVal[0]=5;
				$this->incVal[1]="AED.";
				}
			} 
			else {
				if($offerData[0]['DiscountINRFlatRate']!='') { 
				$offer5=$this->getofferarray($offerData[0]['DiscountINRFlatRate']);
				$offerRateDb=$offerData[0]['DiscountINRFlatRate'];
				$this->catgTYpeRate=$$catgTYpeRateRS;
				$this->incVal[0]=100;
				$this->incVal[1]="Rs.";

				}
			}
			$this->dboffer1=$offerData[0]['AssuredGift'];	
			$this->dboffer2=$offerData[0]['DiscountPercentage'];	
			$this->dboffer3=$offerData[0]['NextLevelOffer'];	
			$this->dboffer4=$offerData[0]['ExtraPhoneNumbers'];
			$this->dboffer5=$offerRateDb;

			$this->offer1=$offer1;
			$this->offer2=$offer2;
			$this->offer3=$offer3;
			$this->offer4=$offer4;
			$this->offer5=$offer5;
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
				$retuenMaxAmount="<div class='fright smalltxt' style='padding: 0px 10px 0px 0px;'><B>Classic :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->catgTYpeRate[1]." ".$this->incVal[1]."</FONT><B>Classic Plus :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->catgTYpeRate[4]." ".$this->incVal[1]."</FONT><B>Classic super :</B> <FONT class='clr3 mediumtxt boldtxt'>".$this->catgTYpeRate[7]." ".$this->incVal[1]."</FONT></div>";
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
			$keyMatch=array("#"=>"&nbsp;&nbsp;OR&nbsp;&nbsp;","&"=>"&nbsp;&nbsp;AND&nbsp;&nbsp;","+"=>"&nbsp;&nbsp;AND&nbsp;&nbsp;","-"=>"<br>&nbsp;&nbsp;OR&nbsp;&nbsp;<br>");
	
			global $arrPrdPackages;
						foreach($arrPrdPackages as $packKey=>$packValue) {
					$this->assredGiftValue=0;
					$this->precentageValue=0;
					$this->nextValue=0;
					$this->extraPhoneValue=0;
					$this->splictValue=0;
					$showOffers='';
					$seperateOffers=explode(",",$this->packOverride[$packKey]);
			
					foreach($seperateOffers as $singleOfferKey=>$singleOfferValues) {
						$packageName=$packValue; 
						if($singleOfferValues=="&" || $singleOfferValues=="#" || $singleOfferValues=="+" || $singleOfferValues=="-") {
						$this->splictValue=$this->splictValue+1;
						$newSet=$packKey.$this->splictValue;	
							 
							 $showOffers.="<input type=hidden name='PACKAGEDIVED$newSet' id='PACKAGEDIVED$newSet' value='$singleOfferValues'>";
							 $showOffers.="<font style='color:#393939'><B>".$keyMatch[$singleOfferValues]."</B></br></font>";
						}	else {	$showOffers.=$this->getalloffers($singleOfferValues,$packKey);	}	
					}
					$frmPge=$packKey;
					$packagesForm[$packKey]="<DIV name='FRMOFFER$frmPge' id='FRMOFFER$frmPge'><input type='radio' name='PACKAGESELECT' id='PACKAGESELECT'  value='".$packKey."' onclick=offerenable('".$packKey."');callBack();> <font class='mediumtxt'>".$packageName."</font></a>
					<div name='PACKAGEDIV$packKey' id='PACKAGEDIV$packKey' style='padding: 10px;display:none;'>".$showOffers."<br><a href='javascript:;' onclick=resetval(); style='text-decoration:none;' class='clr1'>Reset Offers</a></div></DIV>";
			}#package close
			return $packagesForm;
		}#close the function
		

		function getalloffers($singleOfferValues,$packKey) {
			global $package98,$OFFERGIFTARRAY,$maxOfferInc,$arrPrdPackages;
			$offerReturn='';
			//$OFFERGIFTARRAY=array(1=>"watch",2=>"book");

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
					$offerReturn.="<option key='$i' style='font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;color:red;border: 1px solid #D7E5F2;font-weight:bold'>$i</option>";
					} else {
					$offerReturn.="<option key='$i' style='font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;color:green;font-weight:bold;border: 1px solid #D7E5F2;'>$i</option>";
					}
				}
			$offerReturn.="</select>";
			$offerReturn.="<INPUT TYPE='hidden' value='2' name='OFFER".$packKey."2'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer2."' name='OFFERALL2'>";
			}
			#next levwl offer
			if($singleOfferValues==3) {
			$this->nextValue=$this->nextValue+1;
			$newSet3=$packKey.$this->nextValue;
			$packKey1 = $packKey + 1;
			$offerReturn.="<font class='smalltxt'><B>Next Level </B>:</font><input type='checkbox' name='NEXTLEVEL$newSet3'  id='NEXTLEVEL$newSet3' value='".$packKey1."' onclick=checkfun(this.name);>".$arrPrdPackages[$packKey1];
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
			
			$this->precentageValue=$this->precentageValue+1;
			$newSet5=$packKey.$this->precentageValue;
			$offerReturn.="<font class='smalltxt'><B>Discount Amount(".$this->incVal[1].")</B> :</font>";
			$offerReturn.="<select name='RATE$newSet5' id='RATE$newSet5' onChange='checkfun(this.name);' class='inputtext'>";

			$offerReturn.="<option key='0' selected>0</option>";
				for($i=$this->incVal[0];$i<=$this->catgTYpeRate[$packKey];$i=$i+$this->incVal[0]) {
					$offerReturn.="<option key='$i'>$i</option>";
				}
			$offerReturn.="</select>";
			$offerReturn.="<INPUT TYPE='hidden' value='5' name='OFFER".$packKey."5'>";
			$offerReturn.="<INPUT TYPE='hidden' value='".$this->dboffer5."' name='OFFERALL5'>";
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
									if($offerCondition=='3'){
										$sepFindValue=$sepPackageKey[$m].'|';
									}
									elseif($offerCondition=='1' || $offerCondition=='2'){
										$sepFindValue=$inkey.'|';
									}
								}
								else{
									if($offerCondition=='2'){
										$remainValue .=$sepPackageKey[$m].'|';
									}
									elseif($offerCondition=='1'){
										$remainValue .=$sepRemainVal[0].'~'.$sepInKey[1].'|';
									}
									elseif($offerCondition=='3'){
										$remainValue .=$sepPackageKey[$m].'|';
								
									}
								}
					}
					$varLength=strlen($remainValue);
					$findString=substr($remainValue,($varLength-1),$varLength);
						if($findString=='|'){
							$remainValueRes=substr($remainValue,0,($varLength-1));
						}
						return $returnOk=$sepFindValue.$remainValueRes;
						
	}
}//class close
?>