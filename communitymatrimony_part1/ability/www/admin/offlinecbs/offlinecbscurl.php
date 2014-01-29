<?php
/*************************************************************************** 
* AUTHOR       :  Sathish prabu N	
* Description  :  Calling this file from offlinecbspayment, it will return JSON values
* Create Date  : 23-Jun-2009
*******************************************/ 

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/currconvrate.inc');
include_once($varRootBasePath.'/lib/clsDBtest.php');
include_once($varRootBasePath.'/conf/wsconf.inc');                                    
include_once($varRootBasePath.'/lib/clsWSMemcacheClient.php');

$wsmemClient = new WSMemcacheClient;
$objdbclass	= new DB;
//CONNECT DATABASE
$objdbclass->dbConnect('S',$varDbInfo['DATABASE']);

$masterobjdbclass	= new DB;
$masterobjdbclass->dbConnect('M',$varDbInfo['DATABASE']);


// TABLES
$varTable['OFFERCODEINFO']		= 'offercodeinfo';
$varTable['OFFERCATEGORYINFO']	= 'offercategoryinfo';
$varTable['OFFERMASTER']	= 'offermaster';
$varTable['PAYMENTOPTIONS']		= 'paymentoptions';


if($_REQUEST['type'] == 'membername') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId","Name");
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	echo $varActInf[0]['Name'];
}

if($_REQUEST['type'] == 'profileentrytype') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId","Paid_Status");
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	if($varActInf[0]['Paid_Status'] == 1)
		echo "R";
	else
		echo "F";
}

if($_REQUEST['type'] == 'chk_lastpay_made') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("Amount_Paid");
	$varActCondtn	= " WHERE MatriId='".$matriid."' order by Date_Paid desc limit 0,1";
	$payresult = $objdbclass->select($varTable['PAYMENTHISTORYINFO'],$varActFields,$varActCondtn,1);
	$paymentRslt = $payresult[0];

	$varActProfileFields	= array("MatriId","Valid_Days","Paid_Status","Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))");
	$varActProfileCondtn	= " WHERE MatriId='".$matriid."'";
	$result = $objdbclass->select($varTable['MEMBERINFO'],$varActProfileFields,$varActProfileCondtn,1);
	$profileRslt = $result[0];

	$nodays = $profileRslt['Valid_Days']- $profileRslt['Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))'];
	if($nodays < 10 && $profileRslt['Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))']>30 && $profileRslt['Paid_Status'] == 1 && $paymentRslt['Amount_Paid']!="0.00" && $paymentRslt['Amount_Paid'] != "") {
		echo "Y";
	} else {
		echo "N";
	}
}

if($_REQUEST['type'] == 'profilecheck') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId");
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	if(count($varActInf) > 0) 
		echo "Y";
	else
		echo "N";
}

if($_REQUEST['type'] == 'paymentdetails') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId","Product_Id","Currency","Payment_Type","Offer_Given","Amount_Paid");
	$varActCondtn	= " WHERE MatriId='".$matriid."' AND Date_Paid>=date_sub(CURDATE(), interval 30 day) order by Date_Paid desc limit 0,1";
	$varActInf		= $objdbclass->select($varTable['PAYMENTHISTORYINFO'],$varActFields,$varActCondtn,1);
	$paymentarr['MatriId'] = $varActInf[0]["MatriId"];
	$paymentarr['ProductId'] = $varActInf[0]["Product_Id"];
	$paymentarr['Currency'] = $varActInf[0]["Currency"];
	$paymentarr['PaymentType'] = $varActInf[0]["Payment_Type"];
	$paymentarr['OfferGiven'] = $varActInf[0]["Offer_Given"];
	$paymentarr['AmountPaid'] = $varActInf[0]["Amount_Paid"];
	$paymentdetailjson = json_encode($paymentarr);
	echo $paymentdetailjson;	
}

if($_REQUEST['type'] == 'lastpaymentdetails') {
	$matriid		= $_REQUEST['matriid'];

	$varActProfileFields	= array("MatriId","Valid_Days","Paid_Status","Last_Payment","Name","Publish AS Status","Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) AS daysleft","Number_Of_Payments","DATE_FORMAT(CURDATE(),'%D %M %Y') AS upgradedate","Date_Created AS TimeCreated","Expiry_Date");
	$varActProfileCondtn	= " WHERE MatriId='".$matriid."'";
	$profileexecute = $objdbclass->select($varTable['MEMBERINFO'],$varActProfileFields,$varActProfileCondtn,0);
	$profile_rslt = mysql_fetch_array($profileexecute);	
	
	$profile['rc1'][0] = $profile_rslt[0];
	$profile['rc1']['MatriId'] = $profile_rslt[0];
	$profile['rc1'][1] = $profile_rslt[1];
	$profile['rc1']['ValidDays'] = $profile_rslt[1];
	if($profile_rslt[2] == 1) {
		$profile['rc1']['EntryType'] = "R";
		$profile['rc1'][2] = "R";
	} else {
		$profile['rc1']['EntryType'] = "F";
		$profile['rc1'][2] = "F";
	}
	$profile['rc1'][3] = $profile_rslt[3];
	$profile['rc1']['LastPayment'] = $profile_rslt[3];
	$profile['rc1'][4] = $profile_rslt[4];
	$profile['rc1']['Name'] = $profile_rslt[4];
	$profile['rc1'][5] = $profile_rslt[5];
	$profile['rc1']['Status'] = $profile_rslt[5];
	$profile['rc1'][6] = $profile_rslt[6];
	$profile['rc1']['daysleft'] = $profile_rslt[6];
	$profile['rc1'][7] = $profile_rslt[7];
	$profile['rc1']['NumberOfPayments'] = $profile_rslt[7];
	$profile['rc1'][8] = $profile_rslt[8];
	$profile['rc1']['upgradedate'] = $profile_rslt[8];
	$profile['rc1'][9] = $profile_rslt[9];
	$profile['rc1']['TimeCreated'] = $profile_rslt[9];
	$profile['rc1'][10] = $profile_rslt[10];
	$profile['rc1']['ExpiryDate'] = $profile_rslt[10];

	$profile['rc1cnt'] =  $objdbclass->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varActProfileCondtn);

	$varActLoginFields	= array('Email');
	$varActLoginCondtn	= " WHERE MatriId='".$matriid."'";
	$logindet = $objdbclass->select($varTable['MEMBERLOGININFO'],$varActLoginFields,$varActLoginCondtn,1);
	$profile['lrc1'][0] = $logindet[0]['Email'];
	$profile['lrc1']['Email'] = $logindet[0]['Email'];

	$profile['lrc1cnt'] =  $objdbclass->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$varActLoginCondtn);

	$varActFields	= array('Amount_Paid');
	$varActCondtn	= " WHERE MatriId='".$matriid."' order by Date_Paid desc limit 0,1";
	$profileres = $objdbclass->select($varTable['PAYMENTHISTORYINFO'],$varActFields,$varActCondtn,1);
	$profile['paymentrslt']['AmountPaid'] = $profileres[0]['Amount_Paid'];
	$paymentdetailjson = json_encode($profile);
	echo $paymentdetailjson;	
}

if($_REQUEST['type'] == 'paymentinsert'  && $_REQUEST['format'] == 'json') {
	$InsertValArr = json_decode($_POST['jsondata'],1);

	$varInsertFields	= array("MatriId","Product_Id","OrderId","Date_Paid","Amount_Paid","Currency","Payment_Type","Payment_Mode","Cheque_DD_No","Cheque_DD_Date","Bank_Name","Payment_Point","Receipt_No","Receipt_Date","Package_Cost","Discount","Offer_Given","Offer_Product_Id","Comments","Franchisee_Id");

	$varInsertVal	= array("'".$InsertValArr['MatriId']."'",$InsertValArr['ProductId'],"'".$InsertValArr['OrderId']."'","Now()",$InsertValArr['AmountPaid'],"'".$InsertValArr['Currency']."'",$InsertValArr['PaymentType'],$InsertValArr['PaymentMode'],"'".$InsertValArr['ChequeDDNo']."'","'".$InsertValArr['ChequeDDDate']."'","'".$InsertValArr['BankName']."'","'".$InsertValArr['PaymentPoint']."'","'".$InsertValArr['ReceiptNo']."'","'".$InsertValArr['ReceiptDate']."'",$InsertValArr['PackageCost'],$InsertValArr['Discount'],$InsertValArr['OfferGiven'],$InsertValArr['OfferId'],"CONCAT_WS('|',Comments,'".$InsertValArr['Comments']."')","'".$InsertValArr['Franchiseeid']."'");

	$insertedid = $masterobjdbclass->insertIgnore($varTable['PAYMENTHISTORYINFO'], $varInsertFields, $varInsertVal);

	echo "1";
}	

if($_REQUEST['type'] == 'profileupdate' && $_REQUEST['format'] == 'json') {
	$UpdateValArr = json_decode($_POST['jsondata'],1);
	$varUpdateFields	= array("Paid_Status","Valid_Days","Number_Of_Payments","Support_Comments","Expiry_Date","PowerPackOpted","PowerPackStatus");
	$varUpdateVal	= array($UpdateValArr['EntryType'],$UpdateValArr['Validdays'],"Number_Of_Payments+1","CONCAT_WS('|',Support_Comments,'".$UpdateValArr['Comments']."')","'".$UpdateValArr['ExpiryDate']."'",$UpdateValArr['PowerPackOpted'],$UpdateValArr['PowerPackStatus']);
	$varUpdateCondtn	= " MatriId='".$UpdateValArr['MatriId']."'";
	echo $updateid = $masterobjdbclass->update($varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
	$rs = $wsmemClient->processRequest($UpdateValArr['MatriId'],"memberinfo");

	$varUpdateFields	=array("EntryType","ValidDays");
	$varUpdateVal	= array($UpdateValArr['EntryType'],$UpdateValArr['Validdays']);
	$varUpdateCondtn	= " MatriId='".$UpdateValArr['MatriId']."'";
	$masterobjdbclass->update($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['PROFILEDETAILS'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

	
}

if($_REQUEST['type'] == 'updatephonemsg' && $_REQUEST['format'] == 'json') {
	$JsonValArr = json_decode($_POST['jsondata'],1);

	$varUpdateCondtn	= " MatriId='".$JsonValArr['MatriId']."'";

	$varProfileUpdateFields	= array("Special_Priv");
	$varProfileUpdateVal		= array($JsonValArr['SpecialPriv']);
	$masterobjdbclass->update($varTable['MEMBERINFO'], $varProfileUpdateFields, $varProfileUpdateVal, $varUpdateCondtn);
	$rs = $wsmemClient->processRequest($JsonValArr['MatriId'],"memberinfo");

	$varUpdateFields	= array("Product_Id","Payment_Date","Renewal_Flag");
	$varUpdateVal		= array($JsonValArr['ProductId'],"NOW()",$JsonValArr['RenewalFlag']);
	$masterobjdbclass->update($varTable['PAYMENTOPTIONS'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
	
	$varPrimaryVal = array("MatriId");

	$varInsertFields	= array("MatriId","TotalMessagesSentLeft","CumulativeAcceptSentInterest","CumulativeAcceptReceivedInterest","DateUpdated");
	$varInsertVal	= array("'".$JsonValArr['MatriId']."'","TotalMessagesSentLeft+".$JsonValArr['TotalMessagesSentLeft'],$JsonValArr['CumulativeAcceptedSentInterest'],$JsonValArr['CumulativeAcceptedReceivedInterest'],"NOW()");
	$masterobjdbclass->insertOnDuplicate($varTable['MEMBERSTATISTICS'], $varInsertFields, $varInsertVal, $varPrimaryVal);

	$varPhoneInsertFields	= array("MatriId","TotalPhoneNos","NumbersLeft");
	$varPhoneInsertVal	= array("'".$JsonValArr['MatriId']."'","TotalPhoneNos+".$JsonValArr['TotalPhoneNos'],"NumbersLeft+".$JsonValArr['NumbersLeft']);
	echo $masterobjdbclass->insertOnDuplicate($varTable['PHONEPACKAGEDET'], $varPhoneInsertFields, $varPhoneInsertVal, $varPrimaryVal);
}

if($_REQUEST['type'] == 'updateofferdetails' && $_REQUEST['format'] == 'json') {
	$AppendArray1 = $AppendArray1Val = array();
	$Appendoffer = $AppendofferVal = array();
	$JsonValArr = json_decode($_POST['jsondata'],1);

	$varProfileUpdateFields	= array("Last_Payment","Date_Updated","LastPaymentThruOnline","LastOnlinePaymentProductId");
	$varProfileUpdateVal		= array("Now()","Now()",$JsonValArr['LastPaymentThruOnline'],$JsonValArr['LastOnlinePaymentProductId']);
	
	if(isset($JsonValArr['OfferAvailable'])) {
		$Appendoffer[] = "OfferAvailable";
		$AppendofferVal[] = $JsonValArr['OfferAvailable'];
	}
	if(count($Appendoffer) > 0) {
		$profileFinalvarUpdateFields = array_merge($varProfileUpdateFields,$Appendoffer);
		$profileFinalvarUpdateVal    = array_merge($varProfileUpdateVal,$AppendofferVal);
	} else {
		$profileFinalvarUpdateFields = $varProfileUpdateFields;
		$profileFinalvarUpdateVal = $varProfileUpdateVal;
	}

	$varProfileUpdateCondtn	= " MatriId='".$JsonValArr['MatriId']."'";
	echo $masterobjdbclass->update($varTable['MEMBERINFO'], $profileFinalvarUpdateFields, $profileFinalvarUpdateVal, $varProfileUpdateCondtn);
	$rs = $wsmemClient->processRequest($JsonValArr['MatriId'],"memberinfo");

	$varUpdateFields	=array("LastPayment");
	$varUpdateVal	= array("Now()");
	$varUpdateCondtn	= " MatriId='".$JsonValArr['MatriId']."'";
	$masterobjdbclass->update($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['PROFILEDETAILS'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

	if(isset($JsonValArr['OfferCategoryId']) && $JsonValArr['OfferCategoryId'] !='') {
		$varUpdateFields	= array("OfferAvailedStatus","OfferAvailedOn","AssuredGiftSelected","DateUpdated");
		$varUpdateVal		= array("1","NOW()","'".$JsonValArr['AssuredGiftSelected']."'","NOW()");
		if(isset($JsonValArr['MemberAssuredGift'])) {
			$AppendArray1[] = "MemberAssuredGift";
			$AppendArray1Val[] = "''";
		}
		if(isset($JsonValArr['MemberDiscountPercentage'])) {
			$AppendArray1[] = "MemberDiscountPercentage";
			$AppendArray1Val[] = "''";
		}
		if(isset($JsonValArr['OfferSource'])) {
			$AppendArray1[] = "OfferSource";
			$AppendArray1Val[] = $JsonValArr['OfferSource'];
		}
		if(count($AppendArray1) > 0) {
			$FinalvarUpdateFields = array_merge($varUpdateFields,$AppendArray1);
			$FinalvarUpdateVal    = array_merge($varUpdateVal,$AppendArray1Val);
		} else {
			$FinalvarUpdateFields = $varUpdateFields;
			$FinalvarUpdateVal = $varUpdateVal;
		}	
		$varUpdateCondtn	= " OfferCategoryId='".$JsonValArr['OfferCategoryId']."'";
		$masterobjdbclass->update($varTable['OFFERCODEINFO'], $FinalvarUpdateFields, $FinalvarUpdateVal, $varUpdateCondtn);
	}
}

if($_REQUEST['type'] == 'offer') {
	$matriid = $_REQUEST['matriid'];
	$productid =  $_REQUEST['productId'];
	$currency =  $_REQUEST['currency'];
	
	include_once "offlinecbsfunction.php";
	$rslt_offer = checkOffer($matriid, $objdbclass, $productid,$currency);
	$cnt = 0;
	if(is_numeric($rslt_offer['OfferCategoryId'])) {
		$Override = $rslt_offer['Override']!='' ? $rslt_offer['Override']:0;
		$jsonRslt['Result'][$cnt]['Override'] = $Override;

		$jsonRslt['Result'][$cnt]['DiscountPercentage'] = $rslt_offer['MemberDiscountPercentage']!=''?$rslt_offer['MemberDiscountPercentage']:0;
		format_MemberAssuredGift($cnt);

		/*default next level for all*/
		$jsonRslt['Result'][$cnt]['NextLevelOffer'] = $rslt_offer['MemberNextLevelOffer']!=''?$rslt_offer['MemberNextLevelOffer']:0;

		/*$jsonRslt['Result'][$cnt]['ExtraDays'] = $rslt_offer['ExtraDays']!=''?$rslt_offer['ExtraDays']:0;
		$jsonRslt['Result'][$cnt]['ExtraPhoneNumbers'] = $rslt_offer['ExtraPhoneNumbers']!=''?$rslt_offer['ExtraPhoneNumbers']:0;
		$jsonRslt['Result'][$cnt]['DiscountINRFlatRate'] = $rslt_offer['DiscountINRFlatRate']!=''?$rslt_offer['DiscountINRFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountUSDFlatRate'] = $rslt_offer['DiscountUSDFlatRate']!=''?$rslt_offer['DiscountUSDFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountEUROFlatRate'] = $rslt_offer['DiscountEUROFlatRate']!=''?$rslt_offer['DiscountEUROFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountAEDFlatRate'] = $rslt_offer['DiscountAEDFlatRate']!=''?$rslt_offer['DiscountAEDFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountGBPFlatRate'] = $rslt_offer['DiscountGBPFlatRate']!=''?$rslt_offer['DiscountGBPFlatRate']:0;
		$jsonRslt['Result'][$cnt]['OfferCategoryId'] = $rslt_offer['OfferCategoryId'];*/

		$jsonRslt['Result'][$cnt]['ExtraDays'] = $rslt_offer['ExtraDays']!=''?$rslt_offer['ExtraDays']:0;
		$jsonRslt['Result'][$cnt]['ExtraPhoneNumbers'] = $rslt_offer['ExtraPhoneNumbers']!=''?$rslt_offer['ExtraPhoneNumbers']:0;
		$jsonRslt['Result'][$cnt]['DiscountINRFlatRate'] = $rslt_offer['MemberDiscountINRFlatRate']!=''?$rslt_offer['MemberDiscountINRFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountUSDFlatRate'] = $rslt_offer['MemberDiscountUSDFlatRate']!=''?$rslt_offer['MemberDiscountUSDFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountEUROFlatRate'] = $rslt_offer['MemberDiscountEUROFlatRate']!=''?$rslt_offer['MemberDiscountEUROFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountAEDFlatRate'] = $rslt_offer['MemberDiscountAEDFlatRate']!=''?$rslt_offer['MemberDiscountAEDFlatRate']:0;
		$jsonRslt['Result'][$cnt]['DiscountGBPFlatRate'] = $rslt_offer['MemberDiscountGBPFlatRate']!=''?$rslt_offer['MemberDiscountGBPFlatRate']:0;
		$jsonRslt['Result'][$cnt]['OfferCategoryId'] = $rslt_offer['OfferCategoryId'];
		$jsonRslt['Result'][$cnt]['curid'] = $rslt_offer['curid'];


	}
	$json = json_encode($jsonRslt);
	echo $json;
}
if($_REQUEST['type'] == 'editpaymentupdate' && $_REQUEST['format'] == 'json') {
	$UpdateValArr = json_decode($_POST['jsondata'],1);

	if(isset($UpdateValArr['PaymentMode'])) {
		$varUpdateFields[] = "Payment_Mode";
		$varUpdateVal[] = $UpdateValArr['PaymentMode'];
	}
	if(isset($UpdateValArr['PaymentType'])) {
		$varUpdateFields[] = "Payment_Type";
		$varUpdateVal[] = $UpdateValArr['PaymentType'];
	}
	if(isset($UpdateValArr['ChequeDDNo'])) {
		$varUpdateFields[] = "Cheque_DD_No";
		$varUpdateVal[] = "'".$UpdateValArr['ChequeDDNo']."'";
	}
	if(isset($UpdateValArr['ChequeDDDate'])) {
		$varUpdateFields[] = "Cheque_DD_Date";
		$varUpdateVal[] = "'".$UpdateValArr['ChequeDDDate']."'";
	}
	if(isset($UpdateValArr['BankName'])) {
		$varUpdateFields[] = "Bank_Name";
		$varUpdateVal[] = "'".$UpdateValArr['BankName']."'";
	}
	if(isset($UpdateValArr['Comments'])) {
		$varUpdateFields[] = "Comments";
		$varUpdateVal[] = "CONCAT_WS('|',Comments,'".$UpdateValArr['Comments']."')";
	}

	$varUpdateCondtn	= " MatriId='".$UpdateValArr['MatriId']."' AND OrderId='".$UpdateValArr['OrderId']."'";
	$updateid = $masterobjdbclass->update($varTable['PAYMENTHISTORYINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
	echo "1";
}
if($_REQUEST['type'] == 'fetchphonemsg') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId","TotalPhoneNos","NumbersLeft");
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varPhone		= $objdbclass->select($varTable['PHONEPACKAGEDET'],$varActFields,$varActCondtn,1);

	$varActFields	= array("MatriId","TotalMessagesSentLeft");
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varMessage		= $objdbclass->select($varTable['MEMBERSTATISTICS'],$varActFields,$varActCondtn,1);
	$json['MatriId'] = $varPhone[0]["MatriId"];
	$json['TotalPhoneNos'] = $varPhone[0]["TotalPhoneNos"];
	$json['NumbersLeft'] = $varPhone[0]["NumbersLeft"];
	$json['TotalMessagesSentLeft'] = $varMessage[0]["TotalMessagesSentLeft"];
	echo json_encode($json);
}
if($_REQUEST['type'] == 'managephonemsgvaliddays' && $_REQUEST['format'] == 'json') {
	$JsonValArr = json_decode($_POST['jsondata'],1);

	$varUpdateCondtn	= " MatriId='".$JsonValArr['MatriId']."'";
	
	if($JsonValArr['TotalMessagesSentLeft']){
	$varInsertMsgFields	= array("TotalMessagesSentLeft","DateUpdated");
    $varInsertMsgVal	= array($JsonValArr['TotalMessagesSentLeft'],"NOW()");
	$masterobjdbclass->update($varTable['MEMBERSTATISTICS'], $varInsertMsgFields, $varInsertMsgVal, $varUpdateCondtn);
	}

    if($JsonValArr['TotalPhoneNos'] && $JsonValArr['NumbersLeft']){
	$varPhoneupdateFields	= array("TotalPhoneNos","NumbersLeft");
	$varPhoneupdateVal	= array($JsonValArr['TotalPhoneNos'],$JsonValArr['NumbersLeft']);
	$masterobjdbclass->update($varTable['PHONEPACKAGEDET'], $varPhoneupdateFields, $varPhoneupdateVal, $varUpdateCondtn);
	}
    
	if($JsonValArr['ValidDays'] && $JsonValArr['ExpiryDate']){
	$varInsertValiddaysFields	= array("Valid_Days","Expiry_Date","Date_Updated");
	$varInsertValiddaysVal	= array($JsonValArr['ValidDays'],"'".$JsonValArr['ExpiryDate']."'","NOW()");
	echo $masterobjdbclass->update($varTable['MEMBERINFO'], $varInsertValiddaysFields, $varInsertValiddaysVal, $varUpdateCondtn);
	$rs = $wsmemClient->processRequest($JsonValArr['MatriId'],"memberinfo");
	}
}
if($_REQUEST['type'] == 'checkstatusmemberinfo') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId","Valid_Days","Paid_Status","Special_Priv","Gender","Last_Payment","Name","Publish","Last_Login","Time_Posted","Number_Of_Payments","Expiry_Date","Support_Comments");
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	$profilearr['MatriId'] = $varActInf[0]["MatriId"];
	$profilearr['ValidDays'] = $varActInf[0]["Valid_Days"];
	$profilearr['EntryType'] = $varActInf[0]["Paid_Status"]?'R':'F';
	$profilearr['SpecialPriv'] = $varActInf[0]["Special_Priv"];
	$profilearr['Name'] = $varActInf[0]["Name"];
	$profilearr['LastPayment'] = $varActInf[0]["Last_Payment"];
	$profilearr['Gender'] = $varActInf[0]["Gender"]==1?'M':'F';
	$profilearr['Publish'] = $varActInf[0]["Publish"];
	$profilearr['LastLogin'] = $varActInf[0]["Last_Login"];
	$profilearr['TimePosted'] = $varActInf[0]["Time_Posted"];
	$profilearr['NumberOfPayments'] = $varActInf[0]["Number_Of_Payments"];
	$profilearr['ExpiryDate'] = $varActInf[0]["Expiry_Date"];
	$profilearr['Comments'] = $varActInf[0]["Support_Comments"];
	$paymentdetailjson = json_encode($profilearr);
	echo $paymentdetailjson;	
}
if($_REQUEST['type'] == 'getoffermaster') {
	$offercategoryid = $_REQUEST['offercategoryid'];
	$varActFields	= array("OfferCategoryId","OfferName");
	$varActCondtn	= " WHERE OfferCategoryId='".$offercategoryid."'";
	$varActInf		= $objdbclass->select($varTable['OFFERMASTER'],$varActFields,$varActCondtn,1);
	$offerarr['OfferCategoryId'] = $varActInf['OfferCategoryId'];
	$offerarr['OfferName'] = $varActInf['OfferName'];
	echo json_encode($offerarr);
}
if($_REQUEST['type'] == 'checkstatusallpayment' && $_REQUEST['format'] == 'json') {
	$JsonValArr = json_decode($_POST['jsondata'],1);
	$matriid = $JsonValArr['matriid'];

	$varActFields	= array("MatriId","OrderId","Date_Paid","Package_Cost","Currency","Payment_Type","Payment_Mode","Cheque_DD_No", "Cheque_DD_Date","Bank_Name","Receipt_No","Receipt_Date","Comments");
	$varActCondtn	= " WHERE MatriId='".$matriid."' AND OrderId  NOT IN (".$JsonValArr['orderid'].")";
	$varActInf		= $objdbclass->select($varTable['PAYMENTHISTORYINFO'],$varActFields,$varActCondtn,1);
	foreach($varActInf as $key => $val) {
		$paymentarr[$key]['MatriId'] = $val['MatriId'];
		$paymentarr[$key]['OrderId'] = $val['OrderId'];
		$paymentarr[$key]['PaymentTime'] = $val['Date_Paid'];
		$paymentarr[$key]['PackageCost'] = $val['Package_Cost'];
		$paymentarr[$key]['Currency'] = $val['Currency'];
		$paymentarr[$key]['PaymentType'] = $val['Payment_Type'];
		$paymentarr[$key]['PaymentMode'] = $val['Payment_Mode'];
		$paymentarr[$key]['ChequeDDNo'] = $val['Cheque_DD_No'];
		$paymentarr[$key]['ChequeDDDate'] = $val['Cheque_DD_Date'];
		$paymentarr[$key]['BankName'] = $val['Bank_Name'];
		$paymentarr[$key]['ReceiptNo'] = $val['Receipt_No'];
		$paymentarr[$key]['ReceiptDate'] = $val['Receipt_Date'];
		$paymentarr[$key]['Comments'] = $val['Comments'];
	}
	$paymentdetailjson = json_encode($paymentarr);
	echo $paymentdetailjson;
}
if($_REQUEST['type'] == 'profilerenewal') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId");
	$varActCondtn	= " WHERE MatriId='".$matriid."' AND Number_Of_Payments<=0";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	if(count($varActInf) > 0) 
		echo "Y";
	else
		echo "N";
}
if($_REQUEST['type'] == 'profilephysicalstatus') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId");
	$varActCondtn	= " WHERE MatriId='".$matriid."' AND Physical_Status!=1";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	if(count($varActInf) > 0) 
		echo "Y";
	else
		echo "N";
}

if($_REQUEST['type'] == 'lastpaymentdetailspaid' || $_REQUEST['type'] == 'getEntryTypeForMatriId') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId","Paid_Status","Last_Payment");
	$varActCondtn	= " WHERE MatriId='".$matriid."' AND Paid_Status !=0 AND  datediff(NOW(),Last_Payment)<=180";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	$profilearr['MatriId'] = $varActInf[0]["MatriId"];
	$profilearr['EntryType'] = $varActInf[0]["Paid_Status"]?'R':'F';
	$profilearr['LastPayment'] = $varActInf[0]["Last_Payment"];
	$paymentdetailjson = json_encode($profilearr);
	echo $paymentdetailjson;	
}
if($_REQUEST['type'] == 'PrevPaidAmount' || $_REQUEST['type'] == 'FindCbspayment' || $_REQUEST['type'] == 'PaymentInfoForMatriId') {
	$matriid = $_REQUEST['matriid'];
	$LastPaymentDate = $_REQUEST['date'];
    $product= $_REQUEST['product'];
	$orderid= $_REQUEST['orderid'];


	$varActFields	= array("MatriId","Product_Id","Amount_Paid","Date_Paid","OrderId","Payment_Type","Receipt_No","Package_Cost","Offer_Given","Comments","Currency","DATEDIFF(Date_Paid,CURDATE())","Discount");
    
	switch ($_REQUEST['chkcondition']) {
    case 1: //get Previous Paid Amount details for that matriid
        $varActCondtn	= " WHERE MatriId='".$matriid."' ORDER BY Date_Paid DESC limit 1,1";
        break;
    case 2: //get last payment details for particular matriid
        $varActCondtn	= " WHERE MatriId='".$matriid."' AND date(Date_Paid)='".$LastPaymentDate."' ORDER BY Date_Paid DESC";
        break;
    case 3://get last payment details for particular matriid with product id
        $varActCondtn	= " WHERE MatriId='".$matriid."' AND date(Date_Paid) >= '".$LastPaymentDate."' AND Product_Id=".$product." ORDER BY Date_Paid DESC";
        break;
    case 4://get payment details for particular matriid
        $varActCondtn	= " WHERE OrderId='".$orderid."' AND MatriId='".$matriid."'";
        break;
    case 5://get last payment details for particular matriid with OrderId
        $varActCondtn	= " WHERE OrderId='".$orderid."' AND MatriId='".$matriid."' ORDER BY Date_Paid DESC";
        break;
    case 6://get last payment details for particular matriid
        $varActCondtn	= " WHERE MatriId='".$matriid."' ORDER BY Date_Paid DESC";
        break;
    case 7://get member package details for particular matriid
        $varActCondtn	= " WHERE MatriId='".$matriid."' and date(Date_Paid)='".$LastPaymentDate."'";
        break;
    case 8://get member package details for particular matriid and orderid
        $varActCondtn	= " WHERE MatriId='".$matriid."' AND date(Date_Paid)='".$LastPaymentDate."' AND OrderId='".$orderid."'";
        break;
    
    }

    
	
	$varActInf		= $objdbclass->select($varTable['PAYMENTHISTORYINFO'],$varActFields,$varActCondtn,1);
	$profilearr['MatriId'] = $varActInf[0]["MatriId"];
	$profilearr['ProductId'] = $varActInf[0]["Product_Id"];
	$profilearr['AmountPaid'] = $varActInf[0]["Amount_Paid"];
	$profilearr['PaymentTime'] = $varActInf[0]["Date_Paid"];
	$profilearr['OrderId'] = $varActInf[0]["OrderId"];
	$profilearr['PaymentType'] = $varActInf[0]["Payment_Type"];
	$profilearr['ReceiptNo'] = $varActInf[0]["Receipt_No"];
	$profilearr['PackageCost'] = $varActInf[0]["Package_Cost"];
	$profilearr['OfferGiven'] = $varActInf[0]["Offer_Given"];
	$profilearr['Comments'] = $varActInf[0]["Comments"];
	$profilearr['Currency'] = $varActInf[0]["Currency"];
	$profilearr['Validdays'] = $varActInf[0]["DATEDIFF(Date_Paid,CURDATE())"];
	$profilearr['Discount'] = $varActInf[0]["Discount"];
	$paymentdetailjson = json_encode($profilearr);
	echo $paymentdetailjson;	
}
if($_REQUEST['type'] == 'memberId') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId");
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	echo $varActInf[0]['MatriId'];
}
if($_REQUEST['type'] == 'GetMemberInfo') {
	$matriid = $_REQUEST['matriid'];
	$varActFields	= array("MatriId","Paid_Status","Support_Comments","Special_Priv","Valid_Days","Expiry_Date","Last_Payment","Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))","Number_Of_Payments","Name");

	if($_REQUEST['chkcondition'] == 1){
	$varActCondtn	= " WHERE MatriId='".$matriid."' AND Paid_Status=1";
	}else{
    $varActCondtn	= " WHERE MatriId='".$matriid."'";
	}
	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	
	$profilearr['MatriId'] = $varActInf[0]['MatriId'];
	$profilearr['EntryType'] = $varActInf[0]["Paid_Status"]?'R':'F';
	$profilearr['Comments'] = $varActInf[0]['Support_Comments'];
	$profilearr['SpecialPriv'] = $varActInf[0]['Special_Priv'];
	$profilearr['ValidDays'] = $varActInf[0]['Valid_Days'];
	$profilearr['ExpiryDate'] = $varActInf[0]['Expiry_Date'];
	$profilearr['LastPayment'] = $varActInf[0]['Last_Payment'];
	$profilearr['leftdays'] = $varActInf[0]['Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))'];
	$profilearr['NumberOfPayments'] = $varActInf[0]['Number_Of_Payments'];
	$profilearr['Name'] = $varActInf[0]['Name'];
	$paymentdetailjson = json_encode($profilearr);
	echo $paymentdetailjson;	
}
if($_REQUEST['type'] == 'profileupdatedowngrade' && $_REQUEST['format'] == 'json') {
	
	$UpdateValArr = json_decode($_POST['jsondata'],1);

	  if($UpdateValArr['PowerPackOpted']==1){
         $colname4=array("PowerPackOpted");
		 $colvalue4=array("0");
	  }
	
      if($UpdateValArr['Valid_Days_val'] == ''){
		 
		  $colname1=array("Expiry_Date");
		  $colvalue1=array("NOW()");
	  }else{
		 
		  $colname1=array("Expiry_Date");
		  $colvalue1=array("DATE_SUB(Expiry_Date,interval ".$UpdateValArr['Valid_Days_val']." DAY)");
	  }
	 	      
	  if($UpdateValArr['nProfCmnts']){
		 $modified_date=date("d-m-Y");
		 $colname2=array("Support_Comments");
		 $msg="Downgraded on ".$modified_date." by User[UserId]   ".$UpdateValArr['LoginUser']." |OldComment: ".$UpdateValArr['nProfCmntsreplace']."\n";
		 $colvalue2=array('"'.$msg.'"');
	  }else{
         $colname2=array();
		 $colvalue2=array();
	  }
    	 
	  if($UpdateValArr['Valid_Days'] <= 0) {
		 
		 $colname3=array("Last_Payment");
		 $colvalue3=array('"'.$UpdateValArr['LastPayment'].'"');
	  }else{
		  $colname3=array();
		  $colvalue3=array();
	  }

      
      $varUpdateFields	= array("Number_Of_Payments","Paid_Status","Special_Priv","Date_Updated","LastPaymentThruOnline","LastOnlinePaymentProductId","Valid_Days");
      $varUpdateFields=array_merge($varUpdateFields,$colname1);
	  $varUpdateFields=array_merge($varUpdateFields,$colname2);
	  $varUpdateFields=array_merge($varUpdateFields,$colname3);

	  
      $varUpdateVal	= array("Number_Of_Payments-1",$UpdateValArr['Paid_Status'],$UpdateValArr['Special_Priv'],"NOW()",0,0,$UpdateValArr['Valid_Days']);
	  $varUpdateVal=array_merge($varUpdateVal,$colvalue1);
	  $varUpdateVal=array_merge($varUpdateVal,$colvalue2);
	  $varUpdateVal=array_merge($varUpdateVal,$colvalue3);
      if($UpdateValArr['PowerPackOpted']==1){
       $varUpdateFields=array_merge($varUpdateFields,$colname4); 
	   $varUpdateVal=array_merge($varUpdateVal,$colvalue4);
	  }

	 	      	
	$varUpdateCondtn	= " MatriId='".$UpdateValArr['MatriId']."'";
	echo $updateid = $masterobjdbclass->update($varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
	$rs = $wsmemClient->processRequest($UpdateValArr['MatriId'],"memberinfo");


	if($UpdateValArr['Valid_Days'] <= 0) {
	$varUpdateFields  = array("EntryType","ValidDays","LastPayment");
	$varUpdateVal	  = array($UpdateValArr['Paid_Status'],$UpdateValArr['Valid_Days'],'"'.$UpdateValArr['LastPayment'].'"');
    }else{
    $varUpdateFields  = array("EntryType","ValidDays");
	$varUpdateVal	  = array($UpdateValArr['Paid_Status'],$UpdateValArr['Valid_Days']);
	}
		
	$varUpdateCondtn  = " MatriId='".$UpdateValArr['MatriId']."'";
	$masterobjdbclass->update($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['PROFILEDETAILS'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
}
if($_REQUEST['type'] == 'updatepaymentcomments' && $_REQUEST['format'] == 'json') {
	$JsonValArr        = json_decode($_POST['jsondata'],1);

	$matriid           = $_REQUEST['matriid'];
    $orderid           = $_REQUEST['orderid'];
	$payCmnts          = $JsonValArr['Comments'];
	$modified_date     = @date("d-m-Y");
    $downgradeComments = $JsonValArr['DowngradeComments'];
    $reason_change     = $JsonValArr['reason_change'];
	
	$columnvalue = "'Downgraded By UserId ".$JsonValArr['LoginUser']." on ".$modified_date. ' | ' .$downgradeComments. " | OldComment : ".$payCmnts."\n'";

	if($_REQUEST['chkcondition'] == 1){
	    $varUpdateCondtn	= " MatriId='".$JsonValArr['MatriId']."' AND OrderId='".$orderid."'";
	}
	elseif($_REQUEST['chkcondition'] == 2){
   		$varUpdateCondtn	= " MatriId='".$matriid."'";
	}
	
	elseif($_REQUEST['chkcondition'] == 3){
    $columnvalue = "CONCAT_WS('|','".$reason_change."-date:".date('d-M-Y H:i:s')."',Comments)";
   		$varUpdateCondtn	= " MatriId='".$matriid."' and OrderId='".$orderid."' ORDER BY Date_Paid DESC limit 1";
	}
	elseif($_REQUEST['chkcondition'] == 4){
	$columnvalue="CONCAT_WS('|','".$payCmnts."',Comments)";
   		$varUpdateCondtn	= " MatriId='".$matriid."' and OrderId='".$orderid."' ORDER BY Date_Paid DESC";
	}
	$varProfileUpdateFields	= array("Comments");
	$varProfileUpdateVal	= array($columnvalue);
	$masterobjdbclass->update($varTable['PAYMENTHISTORYINFO'], $varProfileUpdateFields, $varProfileUpdateVal, $varUpdateCondtn);
		
}
if($_REQUEST['type'] == 'GetFullPaymentDetails') {
	$matriid = $_REQUEST['matriid'];
	$LastPaymentDate = $_REQUEST['date'];
    $product= $_REQUEST['product'];
	$orderid= $_REQUEST['orderid'];
	
	if($_REQUEST['chkcondition'] == 1){
    $varActCondtn	= " WHERE OrderId='".$orderid."' AND MatriId='".$matriid."' ORDER BY Date_Paid DESC";
	}else{
    $varActCondtn	= " WHERE OrderId='".$orderid."' AND MatriId='".$matriid."' AND Product_Id='".$product."' ORDER BY Date_Paid DESC";
	}

	//$varActCondtn	= " WHERE OrderId='123075'";
	
	$varActInf		= $objdbclass->selectAll($varTable['PAYMENTHISTORYINFO'],$varActCondtn,1);
	$paymentdetailjson = json_encode($varActInf);
	echo $paymentdetailjson;	
}
if($_REQUEST['type'] == 'profileupdateconvertion' && $_REQUEST['format'] == 'json') {
	
	$UpdateValArr = json_decode($_POST['jsondata'],1);

	  	
      if($UpdateValArr['Valid_Days_val'] == ''){
		 
		  $colname1=array("Expiry_Date");
		  $colvalue1=array("NOW()");
	  }else{
		 
		  $colname1=array("Expiry_Date");
		  $colvalue1=array("DATE_ADD(NOW(),interval ".$UpdateValArr['Valid_Days_val']." DAY)");
	  }
	 	      
	  if($UpdateValArr['nProfCmnts']){
		 $modified_date=date("d-m-Y");
		 $colname2=array("Support_Comments");
		 $colvalue2=array("CONCAT_WS('|',Support_Comments,'Any to any package convertion')");
	  }
    	 
	  if($UpdateValArr['Valid_Days']) {
		 $colname3=array("Last_Payment");
		 $colvalue3=array("NOW()");
	  }

      
      $varUpdateFields	= array("Paid_Status","Special_Priv","Date_Updated","LastPaymentThruOnline","LastOnlinePaymentProductId","Valid_Days");
      $varUpdateFields=array_merge($varUpdateFields,$colname1);
	  $varUpdateFields=array_merge($varUpdateFields,$colname2);
	  $varUpdateFields=array_merge($varUpdateFields,$colname3);

	  
      $varUpdateVal	= array($UpdateValArr['Paid_Status'],$UpdateValArr['Special_Priv'],"NOW()",0,0,$UpdateValArr['Valid_Days']);
	  $varUpdateVal=array_merge($varUpdateVal,$colvalue1);
	  $varUpdateVal=array_merge($varUpdateVal,$colvalue2);
	  $varUpdateVal=array_merge($varUpdateVal,$colvalue3);
      
	 	      	
	$varUpdateCondtn	= " MatriId='".$UpdateValArr['MatriId']."'";
	echo $updateid = $masterobjdbclass->update($varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
	$rs = $wsmemClient->processRequest($UpdateValArr['MatriId'],"memberinfo");

	if($UpdateValArr['Valid_Days']) {
	$varUpdateFields  = array("EntryType","ValidDays","LastPayment");
	$varUpdateVal	  = array($UpdateValArr['Paid_Status'],$UpdateValArr['Valid_Days'],"NOW()");
    }else{
    $varUpdateFields  = array("EntryType","ValidDays");
	$varUpdateVal	  = array($UpdateValArr['Paid_Status'],$UpdateValArr['Valid_Days']);
	}
	
	$varUpdateCondtn  = " MatriId='".$UpdateValArr['MatriId']."'";
	$masterobjdbclass->update($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['PROFILEDETAILS'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
}
if($_REQUEST['type'] == 'updateTotalMessageandPhoneCnt' && $_REQUEST['format'] == 'json') {
	$JsonValArr = json_decode($_POST['jsondata'],1);
    
	$varUpdateCondtn	= " MatriId='".$JsonValArr['MatriId']."'";
	
	$varInsertMsgFields	= array("TotalMessagesSentLeft","DateUpdated");
	$varInsertMsgVal	= array("TotalMessagesSentLeft+".$JsonValArr['TotalMessagesSentLeft'],"NOW()");
	$masterobjdbclass->update($varTable['MEMBERSTATISTICS'], $varInsertMsgFields, $varInsertMsgVal, $varUpdateCondtn);

	$varPhoneupdateFields	= array("TotalPhoneNos","NumbersLeft");
	$varPhoneupdateVal	= array("TotalPhoneNos+".$JsonValArr['TotalPhoneNos'],"NumbersLeft+".$JsonValArr['NumbersLeft']);
	$masterobjdbclass->update($varTable['PHONEPACKAGEDET'], $varPhoneupdateFields, $varPhoneupdateVal, $varUpdateCondtn);
	
}
if($_REQUEST['type'] == 'checkPaymentDetails') {
	$matriid = $_REQUEST['matriid'];
	$Date = $_REQUEST['date'];
    $product= $_REQUEST['productId'];
	
	$varActFields	= array("MatriId");
	$varActCondtn	= " WHERE MatriId='".$matriid."' AND Product_Id=".$product." and date(Date_Paid)='".$Date."'";
	$varActInf		= $objdbclass->select($varTable['PAYMENTHISTORYINFO'],$varActFields,$varActCondtn,1);
	$paymentdetailjson = json_encode($varActInf);
	echo $paymentdetailjson;	
}

if($_REQUEST['type'] == 'checkDeletedProfile') {
	$matriid = $_REQUEST['matriid'];
	$cond = $_REQUEST['condition'];
    
	if($cond)
	$varActFields	= array("MatriId","Paid_status","Last_Payment");
	else
	$varActFields	= array("MatriId","Paid_status");
	
	$varActCondtn	= " WHERE MatriId='".$matriid."'  ".($cond?" AND Paid_status !=0 AND  datediff(NOW(),Last_Payment)<=180 ":"")."";
	$varActInf		= $objdbclass->select($varTable['MEMBERDELETEDINFO'],$varActFields,$varActCondtn,1);
	
	$profilearr['MatriId'] = $varActInf[0]["MatriId"];
	$profilearr['EntryType'] = $varActInf[0]["Paid_status"]?'R':'F';
	$profilearr['LastPayment'] = $varActInf[0]["Last_Payment"];
	$paymentdetailjson = json_encode($profilearr);
	echo $paymentdetailjson;	
}

if($_REQUEST['type'] == 'checkDeletedProfileResult') {
	$matriid = $_REQUEST['matriid'];
	
	$varActFields	= array("MatriId","Paid_status","Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))","Valid_Days","Number_Of_Payments","Last_Payment");
		
	$varActCondtn	= " WHERE MatriId='".$matriid."'";
	$varActInf		= $objdbclass->select($varTable['MEMBERDELETEDINFO'],$varActFields,$varActCondtn,1);
	
	$profilearr['MatriId'] = $varActInf[0]["MatriId"];
	$profilearr['EntryType'] = $varActInf[0]["Paid_status"]?'R':'F';
	$profilearr['LastPayment'] = $varActInf[0]["Last_Payment"];
    $profilearr['ValidDays'] = $varActInf[0]['Valid_Days'];
	$profilearr['leftdays'] = $varActInf[0]['Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))'];
	$profilearr['NumberOfPayments'] = $varActInf[0]['Number_Of_Payments'];
	$paymentdetailjson = json_encode($profilearr);
	echo $paymentdetailjson;	
}
if($_REQUEST['type'] == 'updateDeletedInfoDowngrade') {
	$UpdateValArr = json_decode($_POST['jsondata'],1);
	$matriid = $_REQUEST['matriid'];

	$varUpdateFields	= array("Number_Of_Payments","Paid_Status");
    $varUpdateVal	    = array("Number_Of_Payments-1",$UpdateValArr['Paid_Status']);

	$varUpdateCondtn	= " MatriId='".$UpdateValArr['MatriId']."'";
	echo $updateid = $masterobjdbclass->update($varTable['MEMBERDELETEDINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

}
if($_REQUEST['type'] == 'checkDeletedInfoExist') {
	$matriid = $_REQUEST['matriid'];

	$varActFields	= array("MatriId","Paid_Status","Valid_Days","Last_Payment","Number_Of_Payments");
	$varActCondtn	= " WHERE MatriId='".$matriid."' and Paid_Status=0 and Valid_Days=0 and Number_Of_Payments=0 and Last_Payment='0000-00-00 00:00:00'";
	$varActInf		= $objdbclass->select($varTable['MEMBERDELETEDINFO'],$varActFields,$varActCondtn,1);
	
    if(empty($varActInf)){
		echo "0";
	}else{
		echo "1";
	}

}
if($_REQUEST['type'] == 'getDeletedProductInfo') {
	$matriid = $_REQUEST['matriid'];

	$varActFields	= array("MatriId","Product_Id","Date_Paid","Amount_Paid");
	$varActCondtn	= " WHERE MatriId='".$matriid."' and Amount_Paid>0 order by Date_Paid desc limit 1";

	$varActInf		= $objdbclass->select($varTable['PAYMENTHISTORYINFO'],$varActFields,$varActCondtn,1);
	$profilearr['MatriId'] = $varActInf[0]["MatriId"];
	$profilearr['ProductId'] = $varActInf[0]["Product_Id"];
    $profilearr['PaymentTime'] = $varActInf[0]['Date_Paid'];
	$paymentdetailjson = json_encode($profilearr);
	echo $paymentdetailjson;
	
}

if($_REQUEST['type'] == 'updateDeletedProfileInfo') {
	$UpdateValArr = json_decode($_POST['jsondata'],1);
	$matriid = $_REQUEST['matriid'];

	$varUpdateFields	= array("Number_Of_Payments","Paid_Status","Valid_Days","Last_Payment");
    $varUpdateVal	    = array("Number_Of_Payments+1",$UpdateValArr['Paid_Status'],$UpdateValArr['Valid_Days'],'"'.$UpdateValArr['Last_Payment'].'"');

	$varUpdateCondtn	= " MatriId='".$UpdateValArr['MatriId']."'";
	echo $updateid = $masterobjdbclass->update($varTable['MEMBERDELETEDINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

}
if($_REQUEST['type'] == 'getCBSmatriIdForBMID') {
    $bmmatriid = $_REQUEST['bmmatriid'];

	$varActFields	= array("MatriId","BM_MatriId");
	$varActCondtn	= " WHERE BM_MatriId='".$bmmatriid."'";

	$varActInf		= $objdbclass->select($varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	$profilearr['MatriId'] = $varActInf[0]["MatriId"];
	$profilearr['BM_MatriId'] = $varActInf[0]["BM_MatriId"];
	$detailjson = json_encode($profilearr);
	echo $detailjson;

}

	
if($_REQUEST['type'] == 'insertBMPrivilege' && $_REQUEST['format'] == 'json') {
    
	$UpdateValArr = json_decode($_POST['jsondata'],1);
	$matriid    = $UpdateValArr['MatriId'];
	$basicvdays = $UpdateValArr['Basicvdays'];
	$productid  = $UpdateValArr['Productid'];
	$validdays  = $UpdateValArr['Validdays'];
	$membername = $UpdateValArr['Membername'];

	$varActFields	= array("(TO_DAYS(ExpiryDate)-TO_DAYS(NOW()))");
	$varActCondtn	= " where MatriId='".$matriid."'";

	$rm_rslt		= $objdbclass->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);
   	
	if(!empty($rm_rslt)) {
		if($rm_rslt[0]['(TO_DAYS(ExpiryDate)-TO_DAYS(NOW()))'] >0)
			$basicvdays = $basicvdays+$rm_rslt[0]['(TO_DAYS(ExpiryDate)-TO_DAYS(NOW()))'];
	}
	$privilegevdays = $basicvdays>$validdays?$validdays:$basicvdays;


	$varPrimaryVal = array("MatriId");

	$varInsertFields	= array("MatriId","MemberName","ProductId","ValidDays","ExpiryDate","PrivStatus","PaidStatus","TimeCreated");
	$varInsertVal	= array("'".$matriid."'","'".$membername."'",$productid,$privilegevdays,"DATE_ADD(NOW(),interval ".$privilegevdays." DAY)","2","1","NOW()");
	echo $insertStatus=$masterobjdbclass->insertOnDuplicate($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'], $varInsertFields, $varInsertVal, $varPrimaryVal);
		   
	
	
}

?>