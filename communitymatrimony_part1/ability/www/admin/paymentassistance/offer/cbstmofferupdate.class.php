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
	private $offerExpDate;
	private $msMaster;
	private $offerSource;


	#Assign the Values
		public function getiniciate($matriId,$offerCatId,$offerCode,$assuredGift='',$offerPresentage='',$nextLevelOffer='',$phoneOffer='',$uaeToInr,$amountOfferAed='',$amountOfferRs='',$offerExpDate,$offerSource,$msMaster){
			global $DOMAINTABLE,$DBNAME,$checkOfferCatId;

			$this->matriId=$matriId;

			#Set The Offer Fields For Update
			$this->offerCatId=$offerCatId;
			$this->assuredGift=$assuredGift;
			$this->offerPresentage=$offerPresentage;
			$this->nextLevelOffer=$nextLevelOffer;
			$this->phoneOffer=$phoneOffer;
			$this->msMaster=$msMaster;
			$this->offerExpDate=$offerExpDate." 23:59:59";
			$this->offerSource=$offerSource;
			if($this->offerCatId==$checkOfferCatId['CBSTMSUPPORT']){
				$this->offerCode=$offerCode;
			}
			$this->amountOfferAed=$amountOfferAed;
			$this->amountOfferRs=$amountOfferRs;
			 $checkOfferCatId[$offerCatId];
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
		
			$offerCodeInsert="insert into ".$varTable['OFFERCODEINFO']."   (MatriId,OfferCategoryId,OfferAvailedStatus,OfferAvailedOn,OfferCode,OfferStartDate,OfferEndDate,OfferSource,MemberExtraPhoneNumbers,MemberDiscountPercentage,MemberDiscountINRFlatRate,MemberDiscountUSDFlatRate,MemberDiscountEUROFlatRate,MemberDiscountAEDFlatRate,MemberDiscountGBPFlatRate,MemberAssuredGift,AssuredGiftSelected,MemberNextLevelOffer,DateUpdated,OmmParticipation) value('".$this->matriId."','".$this->offerCatId."',0,'0000-00-00  00:00:00','".$this->offerCode."',now(),'".$this->offerExpDate."','".$this->offerSource."','".$this->phoneOffer."','".$this->offerPresentage."','".$this->amountOfferRs."','','','".$this->amountOfferAed."','','".$this->assuredGift."','','".$this->nextLevelOffer."',now(),0) ON DUPLICATE KEY UPDATE  OfferCategoryId='".$this->offerCatId."',OfferAvailedStatus=0,OfferAvailedOn='0000-00-00 00:00:00',OfferCode='".$this->offerCode."',OfferStartDate=now(),OfferEndDate='".$this->offerExpDate."',OfferSource='".$this->offerSource."',MemberExtraPhoneNumbers='".$this->phoneOffer."',MemberDiscountPercentage='".$this->offerPresentage."',MemberDiscountINRFlatRate='".$this->amountOfferRs."',MemberDiscountUSDFlatRate='',MemberDiscountEUROFlatRate='',MemberDiscountAEDFlatRate='".$this->amountOfferAed."',MemberDiscountGBPFlatRate='',MemberAssuredGift='".$this->assuredGift."',AssuredGiftSelected='',MemberNextLevelOffer='".$this->nextLevelOffer."',DateUpdated=now(),OmmParticipation=0";
			//$this->msMaster->insert($offerCodeInsert);

			mysql_query($offerCodeInsert);

			return $offerCodeInsert;
		}

		#update the new offer to matimonprofile for offline only
		public function updatemsdb(){#offline
			global $DOMAINTABLE,$DBNAME,$TABLE,$checkOfferCatId;
			
			$argFields = array('OfferAvailable','OfferCategoryId','Date_Updated');
			$argValues = array("'1'","'".$checkOfferCatId['CBSTMSUPPORT']."'","now()");
			$argCondition = " matriid='".$this->matriId."'";
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
