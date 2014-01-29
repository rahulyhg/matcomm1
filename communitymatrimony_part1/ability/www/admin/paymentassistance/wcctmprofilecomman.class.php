<?php 
###########################################################################################################
#FileName		: wcctmprofilecomman.class.php
#Created		: On:2009-May-04
#Authour		: A.Anbalagan
#Description	: this file used to show the profile information and update the profle information
###########################################################################################################
#ini_set('display_errors','on');
#error_reporting(E_ALL ^ E_NOTICE);

class viewprofile extends db{

##variable declaration;

private $dbip;
private $dbuser;
private $dbpass;
private $dbname;
private $Telecallerid;
private $Officed;
private $day;
private $stratDate;
private $frmDate;
private $endDate;
private $sectortWhere;
private $profileDetails=array();

## clear all variables;
	public function clearlocalvariable(){
	$dbip='';
	$dbuser='';
	$dbpass='';
	$dbname='';
	$Telecallerid='';
	$Officed='';
	$day='';
	$stratDate='';
	$frmDate='';
	$endDate='';
	$profileDetails='';
	}
## get the db conncetion with master
	public function connctionmaster($dbip,$dbuser,$dbpass,$dbname) {

	$this->dbip=$dbip;
	$this->dbuser=$dbuser;
	$this->dbpass=$dbpass;
	$this->dbname=$dbname;
	db::connect($this->dbip,$this->dbuser,$this->dbpass,$this->dbname);
	}

## get the db conncetion with slave
	public function connctionslave($dbip,$dbuser,$dbpass,$dbname) {

	$this->dbip=$dbip;
	$this->dbuser=$dbuser;
	$this->dbpass=$dbpass;
	$this->dbname=$dbname;
	db::connect($this->dbip,$this->dbuser,$this->dbpass,$this->dbname);
	}
## get the db conncetion with slave
	public function assuredconnect($dbip,$dbuser,$dbpass,$dbname){

	$this->dbip=$dbip;
	$this->dbuser=$dbuser;
	$this->dbpass=$dbpass;
	$this->dbname=$dbname;
	db::connect($this->dbip,$this->dbuser,$this->dbpass,$this->dbname);

	}
## get the db details
	public function getdbdetails($sector){
		global $DBNAME,$TABLE,$fix;
		$this->sectortWhere=$sector;
		if($this->sectortWhere==1) {
		$dbs[0]=$DBNAME['TMINTERFACE'].".".$TABLE['TMPROFILEDETAILS'];
		$dbs[1]=$DBNAME['TMINTERFACE'].".".$TABLE['TMDAILYCALLSLOG'];
		$dbs[2]=$DBNAME['TMINTERFACE'].".".$TABLE['TMFOLLOWUPDETAILS'];	
		$dbs[3]="MatriId,DateCalled,PhoneCountryCode,CountryCode,AreaCode,PhoneNo,MobileNo,AssuredPhoneNumber,Category,TelecallerId,TelecallerFollowupStatus,DisplayPriority,LockTime,WhenYouMarry,AutoFollowPhoneRingingCnt,AutoFollowNotIntrestCnt,AssuredDateConfirmed,CallCount";
		}

		return $dbs;
	}
## get the telecaller daily call count.
	public function gettelecallerinfo($Telecallerid,$Officed){
		global $DBNAME,$TABLE,$fixQuery;
		$stratDate=date("Y-m-d");

		$this->Telecallerid=$Telecallerid;
		$this->Officed=$Officed;
		$getTeleCallerInfoQuery="select WelcomeCount,PRCase2Count,RenewalCount,FollowupTodayCount,PotentialFollowupCount,RenewalFollowupCount,AutoFollowupTodayCount,PendingFollwoupCount,PendingFreeCount,HotLeadsCount from ".$DBNAME['TMINTERFACE'].".".$TABLE['TMDAILYTELECOUNT']." where TeleCallerId='".$this->Telecallerid."' and OfficeId=".$this->Officed." and DateUpdated='".$stratDate."'";
		
		$fixQuery .="gettelecallerinfo[getTeleCallerInfoQuery]:".$getTeleCallerInfoQuery."<br/><br/>";
		
		$chekCount=db::select($getTeleCallerInfoQuery);
		if($chekCount>0) {
		$teleCallerToday=db::fetchArray();
		return $teleCallerToday;
		}
	}
	public function usercheck($Telecallerid,$officeId) {#use check for indai dialer
		global $DBNAME,$TABLE;
		$seelctCheck="select TelecallerName from ".$DBNAME['WELCOMEINTERFACE'].".".$TABLE['WCCLOGINDETAILS']." where TelecallerId=".$Telecallerid."";
		$checkVar=db::select($seelctCheck);
		if($checkVar>0) {
		$telValue=db::fetchArray();
		$teleName=$telValue[TelecallerName];
		return $teleName;
		} 
}

function settelecallerlock($matriId,$teleCallerId,$dbDetails,$objMaster,$tName,$cate){
global $DBNAME,$TABLE;

$appTime=date("Y-m-d H:i:s");
	if($cate==10 || $cate==12 ){
		$updateQueryLock="update  ".$dbDetails." set TelecallerId='".$teleCallerId."',TelecallerName='".$tName."',LockTime='".$appTime."' where MatriId='".$matriId."' and TelecallerFollowUpStatus=0 and DateCalled='0000-00-00 00:00:00'";
	}
	
	else if($cate<10) {
		$updateQueryLock="update  ".$dbDetails." set TelecallerId='".$teleCallerId."',TelecallerName='".$tName."',LockTime='".$appTime."' where MatriId='".$matriId."' 
		and TelecallerFollowUpStatus=0 and (TelecallerName is NULL or TelecallerName='')";
	} 
	else {
		$updateQueryLock="update ".$dbDetails." set LockTime='".$appTime."' where MatriId='".$matriId."'";
	}
	$objMaster->update($updateQueryLock);
}


## get getwccprofileinfo Infromation from welcome db #dialar use
public function getwccprofileinfo($matriId,$teleCallerId,$officeId,$dbDetails,$selectVal) {
		global $DBNAME,$TABLE,$fixQuery;

		$frmDate=mktime(0,0,0,date(m),date(d),date(Y));
		$todayDatee=date("Y-m-d",$frmDate);
		$endofWeak=date("w");
		$mk7DaysBefore=mktime(0,0,0,date(m),date(d)-$endofWeak,date(Y));#7 days befor;
		$mk7DaysFormat=date("Y-m-d",$mk7DaysBefore);
	
		#this is for tm interface query
	 	$getMainInfoQuery="select ".$selectVal." from ".$dbDetails." where MatriId='".$matriId."' and TelecallerId='".$teleCallerId."' and OfficeId=".$officeId." and LockTime>='".$mk7DaysFormat." 00:00:00' and LockTime<='".$todayDatee."  23:59:59'  and Status<>2";
		
		$fixQuery .="getwccprofileinfo[getMainInfoQuery]:".$getMainInfoQuery."<br/><br/>";
		
		$infoVar=db::select($getMainInfoQuery);
		if($infoVar>0) {
		$getMainInfo=db::fetchArray();
		$this->profileDetails=$getMainInfo; 
		return $getMainInfo;
		}
		else {
			header("location:recordsnotfound.php?itype=2");
		}
	}

	# get getwccprofileinfo Infromation from welcome db #dialar use
public function getwccprofileinfonotset($matriId,$teleCallerId,$officeId,$dbDetails,$selectVal,$categoryId,$objMaster,$tName){
		global $DBNAME,$TABLE,$fixQuery;

		if($categoryId==10 || $categoryId==11 ||  $categoryId==12 || $categoryId==13  || $categoryId==14   || $categoryId==15) {
			$this->settelecallerlock($matriId,$teleCallerId,$dbDetails,$objMaster,$tName,$categoryId);
		}

		$frmDate=mktime(0,0,0,date(m),date(d),date(Y));
		$todayDatee=date("Y-m-d",$frmDate);
		$endofWeak=date("w");
		$mk7DaysBefore=mktime(0,0,0,date(m),date(d)-$endofWeak,date(Y));#7 days befor;
		$mk7DaysFormat=date("Y-m-d",$mk7DaysBefore);
	
		#this is for tm interface query
	 	$getMainInfoQuery="select ".$selectVal." from ".$dbDetails." where MatriId='".$matriId."' and OfficeId=".$officeId." and Status<>2";
		
		$fixQuery .="getwccprofileinfo[getMainInfoQuery]:".$getMainInfoQuery."<br/><br/>";
		
		$infoVar=db::select($getMainInfoQuery);
		if($infoVar>0) {
		$getMainInfo=db::fetchArray();
		$this->profileDetails=$getMainInfo; 
		return $getMainInfo;
		}
		else {
			header("location:recordsnotfound.php?itype=2");
		}
	}


	## get getwccprofileinfo Infromation from welcome db #interface use
	public function getfollowuptodayprofile($matriId,$teleCallerId,$officeId,$dbDetails,$selectVal) {
		global $DBNAME,$TABLE,$fixQuery;
		$this->matriId=$matriId;
		$frmDate=mktime(0,0,0,date(m),date(d),date(Y));
		$todayDatee=date("Y-m-d",$frmDate);

		$endofWeak=date("w");
		$mk7DaysBefore=mktime(0,0,0,date(m),date(d)-$endofWeak,date(Y));#7 days befor;
		$mk7DaysFormat=date("Y-m-d",$mk7DaysBefore);

	 	$getMainInfoQuery="select ".$selectVal." from ".$dbDetails." where MatriId='".$matriId."' and TelecallerId='".$teleCallerId."' and OfficeId=".$officeId." and LockTime>='".$mk7DaysFormat." 00:00:00' and LockTime<='".$todayDatee." 23:59:59' and Status<>2 and DisplayPriority=1";
	
		$fixQuery .="getfollowuptodayprofile[getMainInfoQuery]:".$getMainInfoQuery."<br/><br/>";
		
		$infoVar=db::select($getMainInfoQuery);
		if($infoVar>0) {
		$getMainInfo=db::fetchArray();
		$this->profileDetails=$getMainInfo;
		return $getMainInfo;
		} else {
		header('location:recordsnotfound.php?itype=1&maid='.$this->matriId);
		}
	}

#####view by id
	public function getviewbyid($matriId,$teleCallerId,$officeId,$dbDetails,$selectVal) {
		global $DBNAME,$TABLE,$fixQuery;
		$searResult=0;
		 $getViewById="select ".$selectVal." from ".$dbDetails." where MatriId='".$matriId."' and OfficeId=".$officeId." and Status<>2";
	//TelecallerId='".$teleCallerId."' and DisplayPriority not in(13,10)  and
		$fixQuery .="getviewbyid[getMainInfoQuery]:".$getViewById."<br/><br/>";
		$infoVar=db::select($getViewById);

		if($infoVar>0) {
		$getMainInfo=db::fetchArray();
		#cond1: for common basket
		if ($getMainInfo[DisplayPriority]==13 || $getMainInfo[DisplayPriority]==10 || $getMainInfo[DisplayPriority]==15  || $getMainInfo[DisplayPriority]==11 ) { 
		if($teleCallerId<>$getMainInfo[TelecallerId]) {
			$searResult=1;
		} if($teleCallerId==$getMainInfo[TelecallerId]) {
			header('location:recordsnotfound.php?itype=4&maid='.$matriId);// move to common basket	
		} 
} 
		#cond2: for individual basket		
		   if($getMainInfo[DisplayPriority]<10 || $getMainInfo[DisplayPriority]==14 || $getMainInfo[DisplayPriority]==20){
			if($teleCallerId==$getMainInfo[TelecallerId]){
				$searResult=1;
			} else {
			header('location:recordsnotfound.php?itype=1&maid='.$matriId); 	// lock to other

			}
		}
		
		if($searResult==1) {
		$this->profileDetails=$getMainInfo;
		return $getMainInfo;
		} 
		
		} else {
		header('location:recordsnotfound.php?itype=1&maid='.$matriId);
		}
	}

	public function getwccprofileinfomove($teleCallerId,$officeId,$dbDetails,$selectField,$categoryType,$objMaster,$tName,$countryCode) {
		#interface use
		global $DBNAME,$TABLE,$fixQuery;

		$appTimebefor5min=mktime(date('H'),date('i')-5,date('s'),date('m'),date('d'),date('Y'));
		$appTime=date("Y-m-d H:i:s",$appTimebefor5min);

		$frmDate=mktime(0,0,0,date(m),date(d),date(Y));
		$todayDate=date("Y-m-d",$frmDate);

		$endofWeak=date("w");
		$mk7DaysBefore=mktime(0,0,0,date(m),date(d)-$endofWeak,date(Y));#7 days befor;
		$mk7DaysFormat=date("Y-m-d",$mk7DaysBefore);
		
		$last15days=mktime(0,0,0,date(m),date(d)-15,date(Y));
		$before15Days=date("Y-m-d",$last15days);

		$entryType="";
		$entryType="((((ValidDays - (TO_DAYS(NOW()) - TO_DAYS(LastPayment))<=15)) and EntryType='R') or (EntryType='F'))";
		#country code wise filter for dubai branch only
		if($officeId==28) {
			if($countryCode>1) 	
				$counterFilter=" and (CountryCode=".$countryCode." or PhoneCountryCode=".$countryCode.")";
			elseif($countryCode=="1")
				$counterFilter=" and (CountryCode not in(968,965,966,971,973,974) and PhoneCountryCode not in(968,965,966,971,973,974))";
		} else { $counterFilter=""; } 
		$newFollowUp=$categoryType;

		#category value is zero when the telecaller login first,
		if($categoryType==0) {
		$condition="TelecallerId='".$teleCallerId."' and OfficeId=".$officeId." and LockTime>='".$mk7DaysFormat." 00:00:00' and LockTime<='".$todayDate." 23:59:59' and  DisplayPriority > 2 and ".$entryType." and Status<>2 ".$counterFilter." order by LockTime desc  limit 1";
		}
		#this is for telecallerwise compagin
		else if(($categoryType>=3 && $categoryType<=8) || $categoryType==16 || $categoryType==17) {
	
		if($categoryType==3 || $categoryType==8 || $categoryType==16) { $entryType="EntryType='F'"; }

		#today follow up Direct and Renewal process
		$followLeads="";
		if($categoryType==5) {
			$followLeads=" and DirectReg=0 and RenewalFlag=0";
		}
		elseif($categoryType==16 || $categoryType==17) {

			if($categoryType==16) { 
			$followLeads=" and DirectReg=1 and RenewalFlag=0";
			}
			elseif($categoryType==17) {
			$followLeads=" and RenewalFlag=1 and (DirectReg=0 or DirectReg=1)";
			}
			$categoryType=5;
		}
		$condition="TelecallerId='".$teleCallerId."' and OfficeId=".$officeId." and LockTime>='".$mk7DaysFormat." 00:00:00' and LockTime<='".$todayDate." 23:59:59' and  DisplayPriority=".$categoryType." and ".$entryType." and Status<>2".$followLeads.$counterFilter." order by LockTime desc  limit 1";
		
		} 
		#this is for pending followup records
		else if($categoryType==9) {

		$followUpDate = mktime(0,0,0,date('m'),date('d')-38,date('Y'));
		$followUpFormat = strftime("%Y-%m-%d",$followUpDate); 
		$followUpFormatCur=date("Y-m-d");

		$pendingFollowUp="FollowUpDate>='".$followUpFormat." 00:00:00' and FollowUpDate<'".$mk7DaysFormat." 00:00:00'"; 
		$condition="Status<>2 and ".$entryType." and ".$pendingFollowUp." and TelecallerFollowupStatus in (1,4,5,7,14) and OfficeId=".$officeId." and TelecallerId='".$teleCallerId."' and  DisplayPriority=".$categoryType.$counterFilter." order by LastLogin desc limit 1";
		}
		
		#this is for free pending 
		else if($categoryType==10 || $categoryType==12) {

		$freshDateFrom = mktime(0,0,0,date('m')-1,date('d'),date('Y'));
		$freshDateFormatFrom = strftime("%Y-%m-%d",$freshDateFrom); 
		$freshDateFormatTo=date("Y-m-d");

		$freePendingFresh="FreshlyAddedOn>='".$freshDateFormat." 00:00:00' and FreshlyAddedOn<'".$freshDateFormatTo." 23:59:59'"; 

		$lastLoginFrm = mktime(0,0,0,date('m'),date('d')-7,date('Y'));
		$lastLogin = strftime("%Y-%m-%d",$lastLoginFrm); 
		$LastLoginTo=date("Y-m-d");


		if($categoryType==10) {
		$freePendingLastLogin="LastLogin>='".$lastLogin." 00:00:00' and LastLogin<='".$LastLoginTo." 23:59:59' and LockTime < '".$appTime."'";
		} 
		else if($categoryType==12) {
		$freePendingLastLogin="LastLogin<'".$lastLogin." 00:00:00' and LockTime < '".$appTime."'";
		$categoryType=10;
		}
	
		$condition="Status<>2  and EntryType='F' and DateCalled='0000-00-00 00:00:00' and TelecallerFollowupStatus=0  and ".$freePendingLastLogin."  and OfficeId=".$officeId." and  DisplayPriority=".$categoryType.$counterFilter." order by LastLogin desc limit 1";
		} 
		#this is for renewal not called once
		else if($categoryType==11) {
		$condition="Status<>2 and ((EntryType='R' and ((TO_DAYS(NOW()) - TO_DAYS(LastPayment))-ValidDays>=0)) or EntryType='F') and (TelecallerId is NULL or TelecallerId='') and (TelecallerName is NULL or TelecallerName='') and OfficeId=".$officeId."  and DisplayPriority=".$categoryType.$counterFilter." and LockTime < '".$appTime."' order by LastLogin  desc  limit 1";
		}
		#those are hot leads,direct and Hot renwals
		else if($categoryType==13 || $categoryType==14  || $categoryType==15) {

		if($categoryType=='13' || $categoryType=='14') {
		$entryType="EntryType='F'";
		}

		$cudate=date("Y-m-d");
		$condition="Status<>2 and ".$entryType." and DateCalled<'".$cudate." 00:00:00' and LockTime < '".$appTime."' and DisplayPriority=".$categoryType." and OfficeId=".$officeId.$counterFilter." order by LastLogin  desc  limit 1";

		}
		#hot renwal not called within the weak so admin can taken the leads
		else if($categoryType==20){
			$cudate=date("Y-m-d");
			$condition="TelecallerId='".$teleCallerId."' and Status<>2 and ".$entryType." and LockTime<='".$cudate." 23:59:59' and DisplayPriority=".$categoryType." and OfficeId=".$officeId.$counterFilter." order by LastLogin  desc  limit 1";		
		}
		$getMainInfoQuery="select ".$selectField." from ".$dbDetails." where ".$condition."";	
		
	
		if($_REQUEST['fix']=="q") { echo $getMainInfoQuery; } 
		
		$fixQuery .="getwccprofileinfomove[getMainInfoQuery]:".$getMainInfoQuery."<br/><br/>";
		
		$count=db::select($getMainInfoQuery);
		if($count>0){
			$getMainInfo=db::fetchArray();
			$this->profileDetails=$getMainInfo;
			return $getMainInfo;
		} else {
			
		header("location:recordsnotfound.php?sucess=1&catId=".$newFollowUp."");
		}
}
## get the slave updated datas. 
	public function getprofileinformation($matriId,$TeleCallerName,$memberSlave,$matrimonymsDomain,$tsetorId){
		global $DBNAME,$TABLE,$DOMAINTABLE,$fixQuery;
		$this->matriId=$matriId;
		$this->telecallerName=$TeleCallerName;
		
		 $getGeneralInfoQuery="select Name,Height,Religion,Gender,Age,EducationSelected,OccupationSelected,EntryType,ByWhom,TimeCreated,LastLogin,Raasi,Star,HoroscopeAvailable,PartnerPrefSet,FamilyDetailsAvailable,HobbiesAvailable,PhoneVerified,Caste,PhotoAvailable,AnnualIncome,IncomeCurrency,FiltersAvailable,DayOfBirth,MonOfBirth,YearOfBirth,LoginCount,NumberOfPayments,LastPayment,ExpiryDate,CountrySelected,Validated,Status,OfferAvailable,OfferCategoryId,AutoRenewalStatus from ".$DBNAME['MATRIMONYMS'].".".$matrimonymsDomain." where MatriId='".$this->matriId."'";
	
		#$getGeneralInfoQuery="select Name,Gender,EntryType,ByWhom,TimeCreated,LastLogin,Raasi,Star,HoroscopeAvailable,PartnerPrefSet,FamilyDetailsAvailable,HobbiesAvailable,PhoneVerified,Caste,PhotoAvailable,AnnualIncome,FiltersAvailable,DayOfBirth,MonOfBirth,YearOfBirth,LoginCount,NumberOfPayments,LastPayment,ExpiryDate,CountrySelected,Validated,Status,OfferAvailable,OfferCategoryId from ".$DBNAME['MATRIMONYMS'].".".$TABLE['MATRIMONYPROFILE']." where MatriId='".$this->matriId."'";
	

		$fixQuery .="getprofileinformation[getGeneralInfoQuery]:".$getGeneralInfoQuery."<br/><br/>";
	
		$profileCount=$memberSlave->select($getGeneralInfoQuery);
//echo $profileCount;
		#$profileCount=db::select($getGeneralInfoQuery);
		if($profileCount>0) {
		$profileInfo=$memberSlave->fetchArray(); 
		#$profileInfo=db::fetchArray(); 
		/*	if($tsetorId=='2'){
				$tipsArray=$this->getUserInfo($profileInfo,$TeleCallerName,$tsetorId);
				$returnProfileInfo[0]=$profileInfo;
				$returnProfileInfo[1]=$tipsArray;
				return $returnProfileInfo;
			}
			else {
				$tipsArray=$this->getUserInfo($profileInfo,$TeleCallerName,$tsetorId); 
				$returnProfileInfo=$profileInfo;
				$returnProfileInfo[1]=$tipsArray;
				return $returnProfileInfo;
			} */
			return $profileInfo;
			
		} else {
		mail("suresh.a@bharatmatrimony.com","MS not Connect",$getGeneralInfoQuery);
		header("location:recordsnotfound.php?itype=1&noid=".$this->matriId."&tna=".$this->telecallerName);
		}
	}

	public function getcontactemail($memberSlave,$loginDomain){
		global $DBNAME,$TABLE,$DOMAINTABLE;
		
		$getEmailQuery="select Email from ".$DBNAME['MATRIMONYMS'].".".$loginDomain." where MatriId='".$this->matriId."'";
	
		$emailCount=$memberSlave->select($getEmailQuery);
		#$profileCount=db::select($getGeneralInfoQuery);
		if($emailCount>0) {
		$emaiInfo=$memberSlave->fetchArray(); 
			return $emaiInfo;
		}

	}
	
	# check offer available for user
	public function checkofferavailable($offerAvl,$matriId,$memberSlave,$offerDomain,$bmOfferSlave){
		global $DBNAME,$TABLE,$DOMAINTABLE,$fixQuery,$Offer753StartDateTime,$Offer753EndDateTime,$checkOfferCatId;
		
		if($offerAvl==0)  {
			#check the offer end date from global variables.
			$curdatetime=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
			if($Offer753StartDateTime<=$curdatetime and $Offer753EndDateTime>=$curdatetime) {
				$offerInfo['error']="";
			}
			else { $offerInfo['error']="Offer not available"; }
			
		} 
		else {
		$getGeneralInfoQuery="select OfferCategoryId,OfferCode from ".$DBNAME['BMOFFER'].".".$offerDomain." where MatriId='".$matriId."' and OfferAvailedStatus=0 and (OfferStartDate <= NOW() and (OfferEndDate >= NOW() OR OfferEndDate='0000-00-00 00:00:00')) and OfferSource=0";
		$checkCount=$memberSlave->select($getGeneralInfoQuery);
		
			if($checkCount==0){
				$offerInfo['error']="Offer already used";
			}
		}
		if(empty($offerInfo['error'])) {

			if($offerAvl=='1'){
			
				$profileInfo=$memberSlave->fetchArray();
			 	$offerInfo[1]=$profileInfo['OfferCategoryId'];
				$offerInfo[2]=$profileInfo['OfferCode'];
				$getOfferEndDateQry="select OfferEndDate from ".$DBNAME['BMPAYMENT'].".offermaster where OfferCategoryId=".$profileInfo['OfferCategoryId']." ";
				$bmOfferSlave->select($getOfferEndDateQry);
				$getOfferEndDate=$bmOfferSlave->fetchArray();
				$offerExpDate=explode(' ',$getOfferEndDate['OfferEndDate']);
				$offerInfo[3]=$offerExpDate[0];
				
			} else {
				$offerCodeValue=$this->getOfferCode($checkOfferCatId,$matriId);
				$offerInfo[1]=$checkOfferCatId;
				$offerInfo[2]=$offerCodeValue;

				$getOfferEndDateQry="select OfferEndDate from ".$DBNAME['BMPAYMENT'].".offermaster where OfferCategoryId=".$checkOfferCatId." ";
				$bmOfferSlave->select($getOfferEndDateQry);

				$getOfferEndDate=$bmOfferSlave->fetchArray();
				$offerExpDate=explode(' ',$getOfferEndDate['OfferEndDate']);
				$offerInfo[3]=$offerExpDate[0];
			}
			
		}
		return	$offerInfo;	
	}
##show the tool tips message for telecaller

	public function matchingcount($matriId){
	global $DBNAME,$TABLE,$fixQuery;
## matching profile count added by padma
	$matchQuery = "select MatchingCount from ".$DBNAME['TELEMARKETING'].".".$TABLE['MATCHINGCOUNT']." where MatriId='".$matriId."' and DateUpdatedOn >= (curdate()- Interval 3 day)";
	
	$fixQuery .="matchingcount[matchQuery]:".$matchQuery."<br/><br/>";
	
	$countSpe=db::select($matchQuery);
	$viewMatching[0]=$countSpe;
	if($countSpe>0) {
	$getPrfoileMatching=db::fetchArray();
	$viewMatching[1]=$getPrfoileMatching['MatchingCount']; 
	}
	return $viewMatching;
	}
## get the comments from wccfollowupdetails
public function followupcomments($matriId,$dbDetails){
	global $DBNAME,$TABLE,$fixQuery;
	$getCommentsQuery = "select DateCalled,Comments from ".$dbDetails." where MatriId='".$matriId."' order by DateCalled desc";
	
	$fixQuery .="followupcomments[getCommentsQuery]:".$getCommentsQuery."<br/><br/>";
	
	$countCom=db::select($getCommentsQuery);
	$comments[0]=$countCom;
	if($countCom>0) {
	while($getComments=db::fetchArray()) {
		$userComments.=$getComments['DateCalled']." : ".$getComments['Comments']."<br>";
	 }
	}
	$comments[1]=$userComments;
	return $comments;
}
public function getpasthistoryinfo($matriId,$dbDetails,$interfaceType,$domainlang,$dbslave){
	global $DBNAME,$TABLE,$DOMAINTABLE,$fixQuery,$tmFollowupStatus,$collectstatus,$offerSourceArray;
	
	$this->domainOfferCodeInfo=$DOMAINTABLE[$domainlang]['OFFERCODEINFO']; 


	$getBranchNameQuery = "select BranchId,BranchName from ".$DBNAME['WELCOMEINTERFACE'].".".$TABLE['WCCBRANCHDETAILS']."";
	db::select($getBranchNameQuery);
	while($getBranchInfo=db::fetchArray()){
		$resultBranchInfo[$getBranchInfo['BranchId']]=$getBranchInfo['BranchName'];
	}
	$this->resultBranchInfo=$resultBranchInfo;

	if($interfaceType!=1){
	 
//		$getCommentsQuery = "select TelecallerId,TelecallerName,TelecallerFollowupStatus,FollowupDate,OfficeId,DateCalled,Comments from ".$dbDetails." where MatriId='".$matriId."' order by DateCalled desc limit 2";
		
		$fixQuery .="getpasthistoryinfo[getCommentsQuery]:".$getCommentsQuery."<br/><br/>";
//		$countCom=db::select($getCommentsQuery);

		$arrArgs = array('CallerId','FollowupStatus','FollowupDate','SupportUserName','DateUpdated','Comments');
		
		$varCondition = " WHERE MatriId = '$matriId'";
		echo "<br> NUm - ".$countCom	= $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'], 'MatriId', $varCondition);
		if($objSlave -> clsErrorCode == "CNT_ERR")
		{
			echo "DB Eror";
			exit;
		}
		if($countCom>0){
			$tmfollowupinfo='';
			$tmfollowupinfo="<table cellpadding='2' cellspacing='1' bgcolor='gray'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>New TM Interface Details Info:</td></tr><tr class='smalltxt boldtxt' align='center'bgcolor='#f7f7f7'><td>TelecallerId</td><td>TelecallerFollowupStatus</td><td>FollowupDate</td><td>Branch Name</td><td>Date Called On</td><td>Comments</td></tr>";
			$m='1';
		while($getComments=db::fetchArray()) {
				$followpstatus=$tmFollowupStatus[$getComments['TelecallerFollowupStatus']];
				$officeName=$resultBranchInfo[$getComments['OfficeId']];

				$followdateformat=$this->getdateformat($getComments['FollowupDate']);
				$dateupdateformat=$this->getdateformat($getComments['DateCalled']);
				$tmCmds=$getComments['Comments'];

				$tmfollowupinfo .="<form method='post' name='formtmcmd".$m."' action='tmprivilegecoments.php'><tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'>";

				$showComments="<a href=\"javascript:document.formtmcmd".$m.".submit();\" class='clr1 boldtxt'>ClickHere</a>";

				$tmfollowupinfo.="<td>".$getComments['TelecallerId']."</td><td>".$followpstatus."</td><td>".$followdateformat."</td><td>".$officeName."</td><td>".$dateupdateformat."</td><td>".$showComments."</td></tr><input type='hidden' name='tmcmds' value='$tmCmds'>";

				$tmfollowupinfo.="<input type='hidden' name='inttype' value='1'></form>";

				$m++;
		 }
		 $tmfollowupinfo.="</table><br/>";
		}// records not found 
		else{
			$tmfollowupinfo ="<br><FONT COLOR=#339966><B>New Telemarketing Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='300'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>No history found in new telemarketing interface </td></tr></table></br>";
		}
	}//tm interface close
	if($interfaceType!=2 ){
		 
		$getPrivilegeCommentsQuery = "select TelecallerId,OfficeId,FollowUpDate,DateUpdated,Comments from ".$DBNAME['PRIVILEGE'].".".$TABLE['PRIVILEGEDETAILS']." where MatriId='".$matriId."' and (DateUpdated !='0000-00-00 00:00:00' ) order by DateUpdated desc limit 1";
	
		$fixQuery .="getprivilegecommentsquery[getCommentsQuery]:".$getPrivilegeCommentsQuery."<br/>";

		$privilegeCountCom=db::select($getPrivilegeCommentsQuery);

		if($privilegeCountCom>0){
			
		$tmprivilegefollowupinfo='';
		$tmprivilegefollowupinfo="<form method='post' name='formSubmit' action='tmprivilegecoments.php'><table cellpadding='2' cellspacing='1' bgcolor='gray'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7'><td colspan='6'>Privilege Details Info:</td></tr><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' align='center' ><td>TelecallerId</td><td>FollowupDate</td><td>Branch Name</td><td>Date Called On</td><td>Comments</td></tr>";

		//$showComments="<a href='javascript:;' onclick=\"loadwindowprivilege('tmprivilegecoments.php?COMMATRIID=".$matriId."',470,100)\" class='clr1 boldtxt'>ClickHere</a>";
	
		$showComments="<a href=\"javascript:document.formSubmit.submit();\" class='clr1 boldtxt'>ClickHere</a>";
				
		$getPrivilegeComments=db::fetchArray();
		$privilegeOfficeName=$resultBranchInfo[$getPrivilegeComments['OfficeId']];
		$privilegeCmds=$getPrivilegeComments['Comments'];

	 	
		$followdateformat=$this->getdateformat($getPrivilegeComments['FollowUpDate']);
		$dateupdateformat=$this->getdateformat($getPrivilegeComments['DateUpdated']);
		 

		$tmprivilegefollowupinfo.="<tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'><td>".$getPrivilegeComments['TelecallerId']."</td><td>".$followdateformat."</td><td>".$privilegeOfficeName."</td><td>".$dateupdateformat."</td><td>".$showComments."</td></tr>";
		
		$tmprivilegefollowupinfo.="</table><input type='hidden' name='prevcmds' value='$privilegeCmds'><input type='hidden' name='inttype' value='2'></form><br/>";

		}//record not found
		else{
			$tmprivilegefollowupinfo ="<br><FONT COLOR=#339966><B>Privilege Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray' width='300' ><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>No history found in privilege interface </td></tr></table></br>";
		}
	}//privilege interface close
	if($interfaceType!='3' && $interfaceType!='1'){

		$getOldTmCommentsQuery = "select TelecallerId,TelecallerName,TelecallerStatus,OfficeId,FeedBackType,FollowUpDate,DateUpdated from ".$DBNAME['TELEMARKETING'].".".$TABLE['TELEMARKETING_FOLLOWUPDETAILS']." where MatriId='".$matriId."' order by DateUpdated desc limit 2";

		$fixQuery .="getprivilegecommentsquery[getCommentsQuery]:".$getOldTmCommentsQuery."<br/><br/>";
		$oldTmCount=db::select($getOldTmCommentsQuery);
		
		if($oldTmCount>0){ 
		$oldtmfollowupinfo='';
		$oldtmfollowupinfo="<table cellpadding='3' cellspacing='1' bgcolor='#f7f7f7'><tr><td><table cellpadding='2' cellspacing='1' bgcolor='gray'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7'  ><td colspan='6'>Old Telemarketing Details Info:</td></tr><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' align='center' ><td>TelecallerId</td><td>FollowupDate</td><td>Branch Name</td><td>Date Called On</td></tr>";
		
		
		while($getOldTmComments=db::fetchArray()){
			$oldTmOfficeName=$resultBranchInfo[$getOldTmComments['OfficeId']];

			$followdateformat=$this->getdateformat($getOldTmComments['FollowUpDate']);
			$dateupdateformat=$this->getdateformat($getOldTmComments['DateUpdated']);

			$oldtmfollowupinfo.="<tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'><td>".$getOldTmComments['TelecallerId']."</td><td>".$followdateformat."</td><td>".$oldTmOfficeName."</td><td>".$dateupdateformat."</td></tr>";
		
		}
			$oldtmfollowupinfo.="</table></td></tr></table><br/>";
		}//record not found 
		else{
			$oldtmfollowupinfo ="<br><FONT COLOR=#339966><B>Old Telemarketing Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='300'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>No history found in old telemarketing  interface </td></tr></table></br>";
		}
	}//old tm interface close

	if($interfaceType!=6){

		$supprtIfaceConnect=$DBNAME['SUPPORTIFACE'].".".$TABLE['PAYMENTOPTIONS'];

		$getCommentsQuery = "select SupportUserId,SupportUserName,FollowupStatus,FollowupDate,LeadSource,DateUpdated,Comments from ".$supprtIfaceConnect." where MatriId='".$matriId."' order by DateUpdated desc limit 1";
		
		$fixQuery .="getpasthistoryinfo[getCommentsQuery]:".$getCommentsQuery."<br/><br/>";
		$countCom=db::select($getCommentsQuery);
		if($countCom>0){
			$supportfollowupinfo='';
			$supportfollowupinfo="<table cellpadding='2' cellspacing='1' bgcolor='gray'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>Support Interface Details Info:</td></tr><tr class='smalltxt boldtxt' align='center'bgcolor='#f7f7f7'><td>Lead Source </td><td>TelecallerId</td><td>FollowupStatus</td><td>FollowupDate</td><td>Date Called On</td><td>Comments</td></tr>";
			$getComments=db::fetchArray();
			$followpstatus=$tmFollowupStatus[$getComments['FollowupStatus']];

				$leadSourceName=$offerSourceArray[$getComments['LeadSource']];
				
				$followdateformat=$this->getdateformat($getComments['FollowupDate']);
				$dateupdateformat=$this->getdateformat($getComments['DateUpdated']);
				$tmCmds=$getComments['Comments'];

				$supportfollowupinfo .="<form method='post' name='formtmcmdsupport' action='tmprivilegecoments.php'><tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'>";

				$showComments="<a href=\"javascript:document.formtmcmdsupport.submit();\" class='clr1 boldtxt'>ClickHere</a>";

				$supportfollowupinfo.="<td>".$leadSourceName."</td><td>".$getComments['SupportUserId']."</td><td>".$followpstatus."</td><td>".$followdateformat."</td><td>".$dateupdateformat."</td><td>".$showComments."</td></tr><input type='hidden' name='tmcmds' value='$tmCmds'>";

				$supportfollowupinfo.="<input type='hidden' name='inttype' value='1'></form>";

		 $supportfollowupinfo.="</table><br/>";
		}// records not found 
		else{
			$supportfollowupinfo ="<br><FONT COLOR=#339966><B>Support Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='300'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>No history found in support  interface </td></tr></table></br>";
		}
	}//support interface close

	$doorStepOfferInfo=$this->getDoorStepPayment($matriId);
	$offerCodeInfo=$this->getOfferInfo($matriId,$dbslave);

	$comments[1]=$tmfollowupinfo;
	$comments[2]=$tmprivilegefollowupinfo;
	$comments[3]=$oldtmfollowupinfo;
	$comments[4]=$doorStepOfferInfo;
	$comments[5]=$offerCodeInfo;
	$comments[6]=$supportfollowupinfo;


	return $comments;
}
## check offer gave to member
	public function getDoorStepPayment($matriId){
		global $DBNAME,$TABLE,$fixQuery,$paymentmode,$collectstatus,$package98;
		$resultBranchInfo=$this->resultBranchInfo;
		
		$getDoorStepQuery = "select RequestNo,RequestDate,BranchId,ExecutiveId,PaymentCollectedDate,Discount,ContactStatus,PreferredPackage,PrefferedPackageAmount,ModeofPayment from ".$DBNAME['COLLECTIONINTERFACE'].".".$TABLE['EASYPAY_INFO']." where MatriId='".$matriId."' order by RequestNo desc limit 1";
		 

		$fixQuery .="getdoorstepquery:".$getDoorStepQuery."<br/><br/>";

		$doorStepCount=db::select($getDoorStepQuery);
		
		if($doorStepCount>0){
			$getDoorStepOffer=db::fetchArray();
			$officeName=$resultBranchInfo[$getDoorStepOffer['BranchId']];
			$collectPaymentMode=$paymentmode[$getDoorStepOffer['ModeofPayment']];
			
			$selectedPackageName=$package98[$getDoorStepOffer['PreferredPackage']]['name'];
 
			$dateupdateformat=$this->getdateformat($getDoorStepOffer['PaymentCollectedDate']);
			$requestdateformat=$this->getdateformat($getDoorStepOffer['RequestDate']);


		$doorstepofferinfo='';
		$doorstepofferinfo ="<table cellpadding='2' cellspacing='1' bgcolor='gray'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='9'>Door Step Payment Offer:</td></tr><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' align='center' ><td>TelecallerId</td><td>Office</td><td>EPR No</td><td>Request Date</td><td>Payment Collected Date</td><td>Discount</td><td>Package</td><td>Mode of Payment</td><td>Status</td></tr>";

		$doorstepofferinfo.="<tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'><td>".$getDoorStepOffer['ExecutiveId']."</td><td>".$officeName."</td><td>".$getDoorStepOffer['RequestNo']."</td><td>".$requestdateformat."</td><td>".$dateupdateformat."</td><td>".$getDoorStepOffer['Discount']." %</td><td>".$selectedPackageName."</td><td>".$collectPaymentMode."</td><td>".$collectstatus[$getDoorStepOffer['ContactStatus']]."</td> </tr><br/>";
		
			$doorstepofferinfo.="</table><br/>";
	
		}else{
			
			$doorstepofferinfo ="<br><FONT COLOR=#339966><B>Door Step Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='300'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>No history found in door step payment </td></tr></table></br>";
		}
		return $doorstepofferinfo;
	}

##Check domain wise offercode info 
public function getOfferInfo($matriId,$dbslave){
		global $DBNAME,$TABLE,$fixQuery,$offerSourceArray,$package98,$OFFERGIFTARRAY;
		 
		$domainOfferCodeInfo=$this->domainOfferCodeInfo;

		$getOfferQuery = "select OfferSource,OfferEndDate,OfferAvailedStatus,DateUpdated,MemberExtraPhoneNumbers,MemberDiscountPercentage,MemberAssuredGift,AssuredGiftSelected,MemberNextLevelOffer from ".$DBNAME['BMOFFER'].".".$domainOfferCodeInfo." where MatriId='".$matriId."' limit 1";
		
		$fixQuery .="getofferquery:".$getOfferQuery."<br/><br/>";

		$offerCount=$dbslave->select($getOfferQuery);
	
		if($offerCount>0){
			$getOfferInfo=$dbslave->fetchArray();

			$offerEndDateformat=$this->getdateformat($getOfferInfo['OfferEndDate']);
			$dateUpdateFormat=$this->getdateformat($getOfferInfo['DateUpdated']);

			$offerstatus='No';
			if($getOfferInfo['OfferAvailedStatus']=='1'){
				$offerstatus='Yes';
			}

			$offerSource=$offerSourceArray[$getOfferInfo['OfferSource']];

			if($getOfferInfo['OfferSource']>0){

				$offerinfo='';
				$offerinfo ="<table cellpadding='2' cellspacing='1' bgcolor='gray'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7'><td colspan='9'>Offer Info:</td></tr><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' align='center' ><td>Offer Source</td><td>Offer Used</td><td>Package Name</td><td>Offer End Date</td><td>Offer Given Date</td></tr>";


				$memExtPhoneNumSep=explode('~',$getOfferInfo['MemberExtraPhoneNumbers']);
				$memDisPerSep=explode('~',$getOfferInfo['MemberDiscountPercentage']);
				$memAssGiftSep=explode('~',$getOfferInfo['MemberAssuredGift']);
				$assGiftSelectedSep=explode('~',$getOfferInfo['AssuredGiftSelected']);
				$memNextLelOfferSep=explode('~',$getOfferInfo['MemberNextLevelOffer']);
			
				if(!empty($memExtPhoneNumSep[0])){
					$productId=$memExtPhoneNumSep[0];
				}
				elseif(!empty($memDisPerSep[0])){
					$productId=$memDisPerSep[0];
				}
				elseif(!empty($memAssGiftSep[0])){
					$productId=$memAssGiftSep[0];
				}
				elseif(!empty($assGiftSelectedSep[0])){
					$productId=$assGiftSelectedSep[0];
				}
				elseif(!empty($memNextLelOfferSep[0])){
					$productId=$memNextLelOfferSep[0];
				}
				$selectedPackageName=$package98[$productId]['name'];
						
			if($this->getsplitvalues($getOfferInfo,'MemberDiscountPercentage',$productId)!='') {
					$offerMemberDiscountPercentage=$this->getsplitvalues($getOfferInfo,'MemberDiscountPercentage',$productId);
			}
			if($this->getsplitvalues($getOfferInfo,'MemberNextLevelOffer',$productId)!='') {
					$offerMemberNextLevelOffer=$this->getsplitvalues($getOfferInfo,'MemberNextLevelOffer',$productId);
			}
			if($this->getsplitvalues($getOfferInfo,'MemberExtraPhoneNumbers',$productId)!='') {
					$offerExtraPhoneNumbers=$this->getsplitvalues($getOfferInfo,'MemberExtraPhoneNumbers',$productId);
			}

			
			$offerinfo.="<tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'><td>".$offerSource."</td><td>".$offerstatus."</td><td>".$selectedPackageName."</td><td>".$offerEndDateformat."</td><td>".$dateUpdateFormat."</td></tr>";
		 
			$memExtPhoneNum=' --- ';
			$memDisPer=' --- ';
			$memNxtOff=' --- ';
			$memAssGift=' --- ';
			$userSelectedPackageName=' --- ';

			if(!empty($offerExtraPhoneNumbers)){
				$memExtPhoneNum=$offerExtraPhoneNumbers;
			}
			if(!empty($offerMemberDiscountPercentage)){
				$memDisPer=$offerMemberDiscountPercentage." %";
			}
			if(!empty($offerMemberNextLevelOffer)){
				$memNxtOff=$offerMemberNextLevelOffer;
				$userSelectedPackageName=$package98[$offerMemberNextLevelOffer]['name'];
			}

			$offerinfo.="<tr class='smalltxt bold' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='#f7f7f7'><td colspan='2'>Extra Phone Number</td><td>Discount Percentage</td><td colspan='2'>Next Level Offer</td></tr>";

			$offerinfo.="<tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'><td colspan='2'>".$memExtPhoneNum."</td><td>".$memDisPer." </td><td colspan='2'>".$userSelectedPackageName."
			</td></tr>";

			$offerinfo.="</tr></table></td></tr><br/>";
			$offerinfo.="</table><br/>";
			}
			else{
				$offerinfo.="<br><FONT COLOR=#339966><B>Offer Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='300'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'><b>No offer details was found  for this member</b></td></tr></table></br>";
			}

		}//recored not fount 
		else{
			$offerinfo ="<br><FONT COLOR=#339966><B>Offer Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='300'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'><b>No offer details was found  for this member</b></td></tr></table></br>";
		}

		return $offerinfo;

	}
## close offer info
## split offer values
public function getsplitvalues($category,$arrkey,$productid) {
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

## check offer from domainwise offer code info table end

## check the assured contact status
	public function assuredcontactstatuscheck($phoneVerified,$getMainInfo,$assuredPhoneNumebbrDb,$objSlave,$objMaster,$dbDetails) {
		global $DBNAME,$TABLE,$profileCreatedBy,$fixQuery;

		if($phoneVerified==0){
			$assuredBeforeQuery="select PhoneNo,MobileNo,PhoneNo1,ContactPerson1,Relationship1,Timetocall1,Description from ".$DBNAME['ASSUREDCONTACT'].".".$TABLE['ASSUREDCONTACTBEFOREVALIDATION']." where MatriId='".$getMainInfo['MatriId']."'";

			$fixQuery .="assuredcontactstatuscheck[assuredBeforeQuery]:".$assuredBeforeQuery."<br/><br/>";
			
			$countAssuredBefore=db::select($assuredBeforeQuery);
			## phone verifeid pending
			if($countAssuredBefore>0) {

			$pentAssured=db::fetchArray();
			$assuredDetails['verfied']="Pending";
			$assuredNumber=validateassurednumberonly($pentAssured['PhoneNo1'],$pentAssured['PhoneNo'],$pentAssured['MobileNo']);
	
				if($assuredNumber[0]!='') { 
				$assuredMobileNum=explode("-",$assuredNumber[0]);
					if(count($assuredMobileNum)==3 && $assuredMobileNum[0]!=91) {
					$assuredDetails['assuredCountryCode']=$assuredMobileNum[0];
					$assuredDetails['assuredAreaCode']=$assuredPhoneNum[1];
					$assuredDetails['assuredMobile']=$assuredMobileNum[2];
					} elseif(count($assuredMobileNum)==2) {
					$assuredDetails['assuredCountryCode']=$assuredMobileNum[0];
					$assuredDetails['assuredMobile']=$assuredMobileNum[1];
					}
				}
				else { 
					$assuredPhoneNum=explode("-",$assuredNumber[1]);
					$assuredDetails['assuredCountryCode']=$assuredPhoneNum[0];
					$assuredDetails['assuredAreaCode']=$assuredPhoneNum[1];
					$assuredDetails['assuredPhone']=$assuredPhoneNum[2]; 
					}
			$assuredDetails['contactPerson1']=$pentAssured['ContactPerson1'];
			$assuredDetails['relationship1']=$pentAssured['Relationship1'];
			$assuredDetails['timetocall1']=$pentAssured['Timetocall1'];
			$assuredDetails['description']=$pentAssured['Description'];
			}
			## phone verifeid No
			else {
			$assuredDetails['verfied']="No";
			$assuredDetails['assuredCountryCode']=$getMainInfo['CountryCode'];
			$assuredDetails['assuredAreaCode']=$getMainInfo['AreaCode'];
			$assuredDetails['assuredPhone']=$getMainInfo['PhoneNo'];
			$assuredDetails['assuredMobile']=$getMainInfo['MobileNo'];
			}
		}
		## phone verifeid yes
		else if($phoneVerified > 0){
		if($assuredPhoneNumebbrDb==''){

		$assuredContactQuery="select TimeGenerated,PhoneNo1,ContactPerson1,Relationship1,Timetocall1,DateConfirmed,VerifiedFlag,Description from ".$DBNAME['ASSUREDCONTACT'].".".$TABLE['ASSUREDCONTACT']." where MatriId='".$getMainInfo['MatriId']."'";

		$countAssured=db::select($assuredContactQuery);
		if($countAssured>0) {
			$updateAssuredRow=db::fetchArray();
			$updateAssuredtoWcc="update ".$dbDetails." set AssuredTimeGenerated='".$updateAssuredRow['TimeGenerated']."',AssuredPhoneNumber='".$updateAssuredRow['PhoneNo1']."',AssuredContactPerson='".$updateAssuredRow['ContactPerson1']."',AssuredRelationship='".$updateAssuredRow['Relationship1']."',AssuredTimetocall='".$updateAssuredRow['Timetocall1']."',AssuredDateConfirmed='".$updateAssuredRow['DateConfirmed']."',AssuredVerifiedFlag='".$updateAssuredRow['VerifiedFlag']."',AssuredDescription='".$updateAssuredRow['Description']."' where MatriId='".$getMainInfo['MatriId']."'";
			$objMaster->update($updateAssuredtoWcc);	
				}
		}
		
		$assuredQuery="select AssuredPhoneNumber,AssuredContactPerson,AssuredRelationship,AssuredTimetocall,AssuredDescription from ".$dbDetails." where MatriId='".$getMainInfo['MatriId']."'";
		
		$objMaster->select($assuredQuery);
		$yesAssured=$objMaster->fetchArray();

		$assuredDetails['verfied']="Yes";
		$assuredNumber=validateassurednumberonly($yesAssured['AssuredPhoneNumber'],$yesAssured['PhoneNo'],$yesAssured['MobileNo']);
	
			if($assuredNumber[0]!='') { 
			$assuredDetails['assuredNumber']=$assuredNumber[0];
			}
			else {	
			$assuredDetails['assuredNumber']=$assuredNumber[1]; 
			}
		$assuredDetails['contactPerson1']=$yesAssured['AssuredContactPerson'];
		$assuredDetails['relationship1']=$profileCreatedBy[$yesAssured['AssuredRelationship']];
		$assuredDetails['relationshipkey1']=$yesAssured['AssuredRelationship'];
		$assuredDetails['timetocall1']=$yesAssured['AssuredTimetocall'];
		$assuredDetails['Description']=$yesAssured['AssuredDescription'];
		}
		return $assuredDetails;
	}

## get the payment details from odb4
	public function getpaymentdetails($matriId,$expDate) {
		global $DBNAME,$TABLE,$paymentMode,$package98,$fixQuery;
		$paymentQuery="select PaymentTime,PaymentMode,Comments,ProductId,Currency,AmountPaid from ".$DBNAME['BMPAYMENT'].".".$TABLE['PAYMENTDETAILS']." where MatriId='".$matriId."' order by PaymentTime desc limit 1";
		
		$fixQuery .="getpaymentdetails[paymentQuery]:".$paymentQuery."<br/><br/>";
		
		$paymentInfoCount=db::select($paymentQuery);
		if($paymentInfoCount>0) {
		$profilePaymentInfo=db::fetchArray();
		$profilePaymentDetails['payMode']=$paymentMode[$profilePaymentInfo['PaymentMode']];
		$profilePaymentDetails['comments']=$profilePaymentInfo['Comments'];
		$profilePaymentDetails['Currency']=$profilePaymentInfo['Currency'];
		$profilePaymentDetails['AmountPaid']=$profilePaymentInfo['AmountPaid'];
		$profilePaymentDetails['proId']=$package98[$profilePaymentInfo['ProductId']]['name'];
		$dateOnly=explode(" ",$profilePaymentInfo['PaymentTime']);
		$dateUp=explode("-",$dateOnly[0]);
		$dateFrm=mktime(0,0,0,date($dateUp[1]),date($dateUp[2]),date($dateUp[0]));
		$profilePaymentDetails['paidTime']=date("d-M-Y",$dateFrm);

		$dbcurTime = strtotime(date($expDate));
		$curTime=strtotime(date("Y-m-d"));
		$leftDays=floor(($dbcurTime-$curTime ) / (3600 * 24));
		if($leftDays > 0) {
		$profilePaymentDetails['paidLeft']=$leftDays." days";
		} else {
		$profilePaymentDetails['paidLeft']="Membership Expired";
		}
		}
		return $profilePaymentDetails;
	}
## mail system information

	public function  mailsysteminfo($matriId) {
		global $DBNAME,$TABLE,$fixQuery;
		$mailSystemQuery="select TotalInterestSent,TotalInterestReceived,MessageReadReceived,MessageUnReadReceived,InterestAcceptedSent,InterestAcceptedReceived,InterestPendingReceived from ".$DBNAME['MAILSYSTEM'].".".$TABLE['LANGPROFILESTATS']." where MatriId='".$matriId."'";

		$fixQuery .="mailsysteminfo[mailSystemQuery]:".$mailSystemQuery."<br/><br/>";
		

		$mialInfoCount=db::select($mailSystemQuery);
		if($mialInfoCount>0) {
		$profileMailInfo=db::fetchArray();
		return $profileMailInfo;
		}
	}



## get payemnt details with package
	public function getcurrencytype($office){ 
			if($office==28){
				global $package220;
				$currencyVal[0]='AED.';
				$currencyVal[1]=$package220;
			}
			else{
				global $package98;
				$currencyVal[0]='Rs.';
				$currencyVal[1]=$package98;
			}
			return $currencyVal;
	}

	public function decrypt($string, $key){
		$result = '';
		$string = base64_decode($string);

		for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
		}
		return $result;
	}
	public function encrypt($string, $key) {
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
		}
		return base64_encode($result);
	}
	public function getOfferCode($offerCatId, $matriId) {
		global  $GLOBALS;
		# Generate 0 padded offer code #
		$len = strlen($offerCatId);  # get the length of category Id
		$maxOfferCodeLen = 4;		# set max length for padded category Id
		if($len<$maxOfferCodeLen)
		$paddedCode = str_pad($offerCatId, $maxOfferCodeLen, "0", STR_PAD_LEFT);

		$newMatriId = str_replace($matriId[0], array_search($matriId[0], $GLOBALS['IDSTARTLETTERHASH']), $matriId);
		return $paddedCode.$newMatriId;
	}

	
	public function getbirthdayinfo($matriId,$memberSlave){
		global $DBNAME,$TABLE,$DOMAINTABLE,$fixQuery;
		
		$selectBirthday="select BirthDay,BirthMonth from ".$DBNAME['MATRIMONY'].".".$TABLE['HORODETAILS']." where MatriID='".$matriId."'";
		$fixQuery .="birthday[show birthday]:".$selectBirthday."<br/><br/>";
		
		$birthCount=$memberSlave->select($selectBirthday);
		#$profileCount=db::select($getGeneralInfoQuery);
		if($birthCount>0) {
			$birthInfo=$memberSlave->fetchArray(); 
		}
		else 
			$birthCount=0;
		return $birthInfo;
	}
	
	public function  getExpInt($matriId) {
		global $DBNAME,$TABLE,$fixQuery;
		$expIntQuery="select MatriId from ".$DBNAME['TELEMARKETING'].".".$TABLE['EXPINTACCEPTEDLIMIT']." where MatriId='".$matriId."'";
		$fixQuery .="expintacceptedlimit[expIntQuery]:".$expIntQuery."<br/><br/>";
		$expInfoCount=db::select($expIntQuery);
		if($expInfoCount>0) {
			$profileExpInfo=1;
		}else{
			$profileExpInfo=0;	
		
		}		
		return $profileExpInfo;		
	}
	function calHeight($incms) {
		$qout = ($incms/30.48);
		list($ft,$decimal) = explode(".",$qout);
		$dec = ".".$decimal;
		$inchs = round(($dec*30.48)/2.54);
		$retheight['ft'] = $ft;
		$retheight['inchs'] = $inchs;
		return $retheight; // return in ft and inch...
	}
	#change date format 
	public function getdateformat($chkdate){

		if($chkdate !="0000-00-00 00:00:00" && $chkdate !="0000-00-00"){ 
				$expTime=explode(" ",$chkdate);
				$dateOnly=explode("-",$expTime[0]);
				$createdSer=mktime(0,0,0,date($dateOnly[1]),date($dateOnly[2]),date($dateOnly[0]));
				$resdateformat=date("d-M-Y",$createdSer);
		}
		else{
				$resdateformat=' --- ';
		}
		return $resdateformat;
	}
}// class close
?>
