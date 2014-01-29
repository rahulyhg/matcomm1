<?php
###########################################################################################################
#FileName		: tmofferupdate.class.php
#Created		: On:2009-May-18
#Author		    : A.Anbalagan
#Description	: this file used to show the offers
###########################################################################################################
#ini_set('display_errors','on');
#error_reporting(E_ALL ^ E_NOTICE);

############################################ Include file #################################################
//include_once "/home/office/cbstm/www/tmiface/config/wsmemcacheclient.php"; 
include_once('/home/product/community/www/admin/includes/config.php');

class tmofferupdate {
	
	#set the private values
	private $matriId;
	private $offerDomain;
	private $offerDataAppend;
	private $matrimonyDomain;
	private $offerCatId;
	private $offerCode;
	private $assuredGift;
	private $offerPresentage;
	private $nextLevelOffer;
	private $phoneOffer;
	private $amountOfferRs;
	private $amountOfferAed;
	private $amountOfferUsd;
	private $amountOfferGbp;
	private $amountOfferEuro;
	private $HoroscopeOffer;
	private $amountAddOnDiscountPrg;
	private $captureOfferCurrency;
	private $offerExpDate;
	private $msMaster;
	private $offerArchiveDomain;
	private $offerSource;
	private $offerMaster;
	private $offerCateType;			
	#Assign the Values
	public function getiniciate($offerCateType,$matriId,$offerCatId,$offerCode,$assuredGift='',$offerPresentage='',$nextLevelOffer='',$phoneOffer='',$convertAEDtoINR,$amountOfferINR='',$amountOfferAED='',$amountOfferUSD='',$amountOfferGBP='',$amountOfferEURO='',$HoroscopeOffer='',$extraDaysCount='',$captureOfferCurrency,$offerExpDate,$offerSource,$msMaster){
	global $DOMAINTABLE,$DBNAME,$checkOfferCatId;

		#Set The Offer Fields For Update
		$this->matriId=$matriId;
		$this->offerCateType=$offerCateType;
		$this->offerCatId=$offerCatId;
		$this->assuredGift=$assuredGift;
		$this->offerPresentage=$offerPresentage;
		$this->nextLevelOffer=$nextLevelOffer;
		$this->phoneOffer=$phoneOffer;
		$this->amountOfferRs=$amountOfferINR;
		$this->amountOfferAed=$amountOfferAED;
		$this->amountOfferUsd=$amountOfferUSD;
		$this->amountOfferGbp=$amountOfferGBP;
		$this->amountOfferEuro=$amountOfferEURO;
		$this->HoroscopeOffer=$HoroscopeOffer;
		$this->extraDaysCount=$extraDaysCount;
		$this->amountAddOnDiscountPrg=$amountAddOnDiscountPrg;
		$this->captureOfferCurrency=$captureOfferCurrency;

		$this->msMaster=$msMaster;
		$this->offerExpDate=$offerExpDate." 23:59:59";
		$this->offerSource=$offerSource;
		$this->offerCode=$offerCode;
		#Language Wise MatrimonyProfile Connect 
		if($offerCatId==$checkOfferCatId['CBSTMSUPPORT']){  
			$queryms=$this->updatemsdb();
			$queryoffline=$this->domainwiseofflineofferupdate();
			$retVal="\nMatrimonyms Update:\n".$queryms."\nOffline Update:\n".$queryoffline."\n";
			return $retVal;
		}
	}	
		
	#update the new offer to offertable
	public function domainwiseofflineofferupdate(){
		global $DOMAINTABLE,$DBNAME,$TABLE,$varTable;		
		$argCondition = "where MatriId='".$this->matriId."'";
	

		$MatriIdchk=$this->msMaster -> numOfRecords($varTable['OFFERCODEINFO'],'MatriId',$argCondition);
		if($MatriIdchk > 0 ) {																	
			$argFields=array('OfferCategoryId','OfferAvailedStatus','OfferAvailedOn','OfferCode','OfferStartDate','OfferEndDate','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','DateUpdated','OmmParticipation','MemberExtraHoroscope','MemberExtraDays','OfflineCurrencyType');
			
			$argValues=array($this->msMaster->doEscapeString($this->offerCatId,$this->msMaster),"'0'","'0000-00-00 00:00:00'",$this->msMaster->doEscapeString($this->offerCode,$this->msMaster),"now()",$this->msMaster->doEscapeString($this->offerExpDate,$this->msMaster),$this->msMaster->doEscapeString($this->offerSource,$this->msMaster),$this->msMaster->doEscapeString($this->phoneOffer,$this->msMaster),$this->msMaster->doEscapeString($this->offerPresentage,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferRs,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferUsd,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferEuro,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferAed,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferGbp,$this->msMaster),$this->msMaster->doEscapeString($this->assuredGift,$this->msMaster),"''",$this->msMaster->doEscapeString($this->nextLevelOffer,$this->msMaster),"now()","'0'",$this->msMaster->doEscapeString($this->HoroscopeOffer,$this->msMaster),$this->msMaster->doEscapeString($this->extraDaysCount,$this->msMaster),$this->msMaster->doEscapeString($this->captureOfferCurrency,$this->msMaster));
			
			$argCondition = " MatriId='".$this->matriId."'";
			
			$updatechk=$this->msMaster -> update('offercodeinfo',$argFields,$argValues,$argCondition);		
		}
		else {			
			$argFields=array('MatriId','OfferCategoryId','OfferAvailedStatus','OfferAvailedOn','OfferCode','OfferStartDate','OfferEndDate','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','DateUpdated','OmmParticipation','MemberExtraHoroscope','MemberExtraDays','OfflineCurrencyType');
			
			$argValues=array($this->msMaster->doEscapeString($this->matriId,$this->msMaster),$this->msMaster->doEscapeString($this->offerCatId,$this->msMaster),"'0'","'0000-00-00 00:00:00'",$this->msMaster->doEscapeString($this->offerCode,$this->msMaster),"now()",$this->msMaster->doEscapeString($this->offerExpDate,$this->msMaster),$this->msMaster->doEscapeString($this->offerSource,$this->msMaster),$this->msMaster->doEscapeString($this->phoneOffer,$this->msMaster),$this->msMaster->doEscapeString($this->offerPresentage,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferRs,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferUsd,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferEuro,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferAed,$this->msMaster),$this->msMaster->doEscapeString($this->amountOfferGbp,$this->msMaster),$this->msMaster->doEscapeString($this->assuredGift,$this->msMaster),"''",$this->msMaster->doEscapeString($this->nextLevelOffer,$this->msMaster),"now()","'0'",$this->msMaster->doEscapeString($this->HoroscopeOffer,$this->msMaster),$this->msMaster->doEscapeString($this->extraDaysCount,$this->msMaster),$this->msMaster->doEscapeString($this->captureOfferCurrency,$this->msMaster));

			$insertchk=$this->msMaster -> insert('offercodeinfo', $argFields, $argValues);	
		}			
	}		

	#update the new offer to matimonprofile for offline only
	public function updatemsdb(){#offline
		global $DOMAINTABLE,$DBNAME,$TABLE,$checkOfferCatId;
		
		$argFields = array('OfferAvailable','OfferCategoryId','Date_Updated');
		$argValues = array("'1'","'".$checkOfferCatId['CBSTMSUPPORT']."'","now()");
		$argCondition = " MatriId=".$this->msMaster->doEscapeString($this->matriId,$this->msMaster)." ";
		$updatechk=$this->msMaster -> update('memberinfo',$argFields,$argValues,$argCondition);			

		if($updatechk){
			$cacheMatriId = $this->matriId;
			$wsmemClient = new WSMemcacheClient();
			$memberinfoTable = $TABLE['MEMBERINFO'];
			$wsmemClient->processRequest($cacheMatriId, $memberinfoTable);
		}
		return $updateMs;	
	}						
}
?>
