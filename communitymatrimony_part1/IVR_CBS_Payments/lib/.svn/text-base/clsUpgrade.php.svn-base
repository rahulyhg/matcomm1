<?php

Class UpgradeProfile {

function CBS_UpgradeProfile($argMatriId,$argOrderId,$argCategory,$argAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment,$varIPLocation,$argPrePaymentTable) {
		global $arrPhonePackage,$varTable,$arrPrdPackages,$varDomainName,$arrAstroPackage,$arrPrefixDomainList,$varReebokOfferCatIds,$varReebokOffer,$_CBS_IncludeFolder;
		$sessMatriId	= $argMatriId;
		$varOrderId		= $argOrderId;
		$varCategory	= $argCategory;
		$varAmount		= $argAmount;
		$varProcess		= 'yes';

		## SETING MEMCACHE KEY
		$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

		## CHECK OFFER
		include($_CBS_IncludeFolder."/payment/offerinfo.php");


		if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varCategory !='120') {

		if(($varPaidDays < 10) && (strlen($varPaidDays) > 0) && $varDatePaid !='0000-00-00 00:00:00') {
		$varProcess = 'no';
		$varDisplayMessage	= "You have made a payment recently on ".$varDatePaid;
		}## if

		}

		if ($varProcess == 'yes') {
		## CHECK DUPLICATE ORDER ID.
		$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$varNoOfRecords = $objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
		$varDisplayMessage		= "Duplicate Order Id <b>".$varOrderId.'</b>';
		if ($varNoOfRecords==1) { $varProcess		= 'no'; }
		}

		if ($varProcess == 'yes') {
		## CHECK DUPLICATE ORDER ID.
		$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$varNoOfRecords = $objDB->numOfRecords($varTable['ADDONPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
		$varDisplayMessage		= "Duplicate Order Id <b>".$varOrderId.'</b>';
		if ($varNoOfRecords==1) { $varProcess		= 'no'; }
		}


	if ($varNoOfRecords == 0 && $varProcess == 'yes') {

	if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varCategory !='120') {

	## CALCULATE CURRENT TOTAL VALID DAYS
	$varFields		= array('Valid_Days','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as CurrentValidDays');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varValidInfo	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varDaysInfo	= mysql_fetch_array($varValidInfo);
	$varCurrentValidDays	= $varDaysInfo['CurrentValidDays'];
	if (($varCurrentValidDays >0) && ($varCurrentValidDays !="")) { $varTotalDays = ($varCurrentValidDays + $varTotalDays); }## if

	$varUSPaidFlag = '0';
	if ($varIPLocation!='IN' && $varNumberOfPayments=='0' && $varDatePaid=='0000-00-00 00:00:00'){
		$varUSPaidFlag = '1';
	}

	## UPDATE VALID DAYS
	$varCondition	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varFields		= array('OfferAvailable','Last_Payment','Valid_Days','Paid_Status','Publish','Number_Of_Payments','Expiry_Date','Date_Updated','Special_Priv','US_Paid_Validated');
	$varFieldsValue	= array('0','NOW()',$varTotalDays,'1','1','Number_Of_Payments+1','DATE_ADD(NOW(),INTERVAL '.$varTotalDays.' DAY)','NOW()',$varSpecialPrev,$varUSPaidFlag);
	$objDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValue, $varCondition, $varOwnProfileMCKey);

	}

	## SELECT Package_Cost and Gateway FROM prepaymenthistoryinfo, optimalpayment and recurring payment.
	## [$varTable['PREPAYMENTHISTORYINFO'], ]
	$varPrepaymentFields	= array('Package_Cost','Discount','Gateway','DiscountFlatRate','Display_Currency','Display_Amount_Paid','Display_Package_Cost','Product_Id');
	$varOrderIdCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varPrepaymentTrackinfo	= $objDB->select($argPrePaymentTable, $varPrepaymentFields, $varOrderIdCondition, 0);
	$varPaymentTrackInfo	= mysql_fetch_array($varPrepaymentTrackinfo);
	$varProductId	      	= $varPaymentTrackInfo["Product_Id"];
	$varGatewayPackageCost	= $varPaymentTrackInfo["Package_Cost"];
	$varGateway				= $varPaymentTrackInfo["Gateway"];
	$varDiscount			= $varPaymentTrackInfo["Discount"];
	$varDiscountFlatRate	= $varPaymentTrackInfo["DiscountFlatRate"];
	$varDisplayCurrency		= $varPaymentTrackInfo["Display_Currency"];
	$varDisplayAmountPaid	= $varPaymentTrackInfo["Display_Amount_Paid"];
	$varDisplayPackageCost	= $varPaymentTrackInfo["Display_Package_Cost"];


	## INSERT PAYMENT TABLE
	if($varProductId!=120){
	$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Offer_Product_Id','Discount','DiscountFlatRate','Amount_Paid','Package_Cost','Currency','Payment_Type','Payment_Mode','Date_Paid','Payment_Gateway','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
	$argFieldsValue	= array($objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($sessMatriId,$objDB),"'".$varUserName."'","'".$varCategory."'","'".$varOfferProductId."'","'".$varDiscount."'","'".$varDiscountFlatRate."'","'".$varAmount."'","'".$varGatewayPackageCost."'","'".$varCurrency."'",'1','1','NOW()',"'".$varGateway."'","'".$varDisplayCurrency."'","'".$varDisplayAmountPaid."'","'".$varDisplayPackageCost."'");
	$objDB->insert($varTable['PAYMENTHISTORYINFO'], $varFields, $argFieldsValue);
	}


	$varCondition		 = " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varAddonNoOfRecords = $objDB->numOfRecords($varTable['ADDONPREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

	$varMatriIdPrefix	= substr($sessMatriId,0,3);
	$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];
    
	## -------------------- Profile Highlighter Part Start-------------------------------------##
	## ADDON PACKAGE(PROFILE HIGHLIGHTER) DETAILS UPDATED IN DB
	$varAddonAmountPaid = '';
	if($varAddonNoOfRecords>0){

    $varPrepaymentFields	= array('Amount_Paid','Package_Cost','Product_Id','Gateway','Display_Currency','Display_Amount_Paid','Display_Package_Cost','Currency');
	$varOrderIdCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varPrepaymentTrackinfo	= $objDB->select($varTable['ADDONPREPAYMENTHISTORYINFO'], $varPrepaymentFields, $varOrderIdCondition, 0);
	$varPaymentTrackInfo		= mysql_fetch_array($varPrepaymentTrackinfo);
	$varAddonProductId			= $varPaymentTrackInfo["Product_Id"];
	$varAddonCurrency			= $varPaymentTrackInfo["Currency"];
	$varAddonAmountPaid			= $varPaymentTrackInfo["Amount_Paid"];
	$varAddonGatewayPackageCost	= $varPaymentTrackInfo["Package_Cost"];
	$varAddonGateway			= $varPaymentTrackInfo["Gateway"];
	$varAddonDisplayCurrency	= $varPaymentTrackInfo["Display_Currency"];
	$varAddonDisplayAmountPaid	= $varPaymentTrackInfo["Display_Amount_Paid"];
	$varAddonDisplayPackageCost	= $varPaymentTrackInfo["Display_Package_Cost"];

	$varFields		= array('Gender','Photo_Set_Status','Protect_Photo_Set_Status');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varValidInfo	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varDaysInfo	= mysql_fetch_array($varValidInfo);

	## INSERT ADDON PAYMENT TABLE
	$varFields		= array('OrderId','MatriId','Product_Id','Amount_Paid','Package_Cost','Currency','Payment_Type','Payment_Mode','Date_Paid','Payment_Gateway','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
	$argFieldsValue	= array($objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($sessMatriId,$objDB),"'".$varAddonProductId."'","'".$varAddonAmountPaid."'","'".$varAddonGatewayPackageCost."'","'".$varAddonCurrency."'",'1','1','NOW()',"'".$varGateway."'","'".$varAddonDisplayCurrency."'","'".$varAddonDisplayAmountPaid."'","'".$varAddonDisplayPackageCost."'");
	$objDB->insert($varTable['ADDONPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);
    
	## Check Package Already Purchased
	$varFields			 = array('Expiry_Date');
	$varCondition		 = " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varAddonPacRecord   = $objDB->select($varTable['PROFILEHIGHLIGHTDET'], $varFields, $varCondition,1);
	
	## INSERT ADDON PACKAGE DETAILS TABLE
	$varHighlightStatus = 0;
	$varFields		    = array('MatriId','Gender','Date_Paid','Expiry_Date','Highlight_Status','Date_Updated');
		if($varDaysInfo['Photo_Set_Status'] == 1 ){
			
			if(!empty($varAddonPacRecord)){
				$varAddonValidDays = 'DATE_ADD("'.$varAddonPacRecord[0]['Expiry_Date'].'",INTERVAL 60 DAY)';
			}else{
				$varAddonValidDays = 'DATE_ADD(NOW(),INTERVAL 60 DAY)';
			}
			if($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 0){
				$varHighlightStatus = 1;
			}elseif($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 1){
				$varHighlightStatus = 0;
			}

		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',$varAddonValidDays,$varHighlightStatus,'NOW()');
		}else{ ## Put mail to customer care team for follow customer to upload photo
		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',"'0000-00-00 00:00:00'",$varHighlightStatus,'NOW()');
		}
	$objDB->insertOnDuplicate($varTable['PROFILEHIGHLIGHTDET'], $varFields, $argFieldsValue,'MatriId');
	if($varHighlightStatus==0){
		$this->sendProfileHighlighterRemaindermail($sessMatriId,$varCBSDomainName,$varDaysInfo['Protect_Photo_Set_Status']);
	}

    }elseif($varCategory == 48 || ($varCategory>=7 && $varCategory<=9)){
        ## Privilege Packages and Platinum has default profile highlighter package
        
		$varFields		= array('Gender','Photo_Set_Status','Protect_Photo_Set_Status');
		$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$varValidInfo	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
		$varDaysInfo	= mysql_fetch_array($varValidInfo);

		## Check Package Already Purchased
		$varFields			 = array('Expiry_Date');
		$varCondition		 = " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$varAddonPacRecord   = $objDB->select($varTable['PROFILEHIGHLIGHTDET'], $varFields, $varCondition,1);

		if(!empty($varAddonPacRecord)){
			$varValiddays='"'.$varAddonPacRecord[0]['Expiry_Date'].'"';
		}else{$varValiddays='NOW()';}

        $varHighlightStatus  = 0;
		if($varCategory>=7 && $varCategory<=9){
				$varAddonValidDays = 'DATE_ADD('.$varValiddays.',INTERVAL 2 WEEK)';
		}else{
				$varAddonValidDays = 'DATE_ADD('.$varValiddays.',INTERVAL 60 DAY)';
		}
        ## INSERT ADDON PACKAGE DETAILS TABLE
		$varFields		= array('MatriId','Gender','Date_Paid','Expiry_Date','Highlight_Status','Date_Updated');
		if($varDaysInfo['Photo_Set_Status'] == 1 ){
			
			if($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 0){
				$varHighlightStatus = 1;
			}elseif($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 1){
				$varHighlightStatus = 0;
			}

		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',$varAddonValidDays,$varHighlightStatus,'NOW()');
		}else{ ## Put mail to customer care team for follow customer to upload photo
		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',"'0000-00-00 00:00:00'",$varHighlightStatus,'NOW()');
		}
		$objDB->insertOnDuplicate($varTable['PROFILEHIGHLIGHTDET'], $varFields, $argFieldsValue,'MatriId');
		
		if($varHighlightStatus==0){
		$this->sendProfileHighlighterRemaindermail($sessMatriId,$varCBSDomainName,$varDaysInfo['Protect_Photo_Set_Status']);
	    }
	
	}
	## -------------------- Profile Highlighter Part End-------------------------------------##

	## INSERT paymentauthorization TABLE
	$varFields			= array('Gateway','OrderNumber','MatriId','User_Name','Product_Id','Amount_Paid','Date_Paid');
	$varFieldsValue	= array('1',$objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($sessMatriId,$objDB),"'".$varUserName."'","'".$varCategory."'","'".$varAmount."'",'NOW()');
	$objDB->insert($varTable['PAYMENTAUTHORIZATION'], $varFields, $varFieldsValue);

	if ($varCategory !='110' && $varCategory !='111' && $varCategory !='112') {

	$varActualPhone		= $arrPhonePackage[$varDisPlayId];
	$varActualPhoneCnt	= $varActualPhone ? $varActualPhone : 0;
	$varTotalPhoneCnt	= ($varActualPhoneCnt + $varExtraPhone);

	## INSERT PHONE NUMBER
	$varFields			= array('MatriId','TotalPhoneNos','NumbersLeft');
	$varFieldsValues	= array("'".$sessMatriId."'","TotalPhoneNos+".$varTotalPhoneCnt,"NumbersLeft+".$varTotalPhoneCnt);
	$objDB->insertOnDuplicate($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsValues, 'MatriId');

	}

	if (($varCategory =='110') || ($varCategory =='111') || ($varCategory =='112') || ($varCheckHoroscopeOffer=='extrahoroscope')) {

	$varActualHoro		= $arrAstroPackage[$varCategory];
	$varActualCount		= $varActualHoro ? $varActualHoro : 0;
	$varTotalHoroCnt	= ($varActualHoro + $varExtraHoroscope);

	## INSERT PHONE NUMBER
	$varFields			= array('MatriId','TotalMatchNos','NumbersLeft');
	$varFieldsValues	= array("'".$sessMatriId."'","TotalMatchNos+".$varTotalHoroCnt,"NumbersLeft+".$varTotalHoroCnt);
	$objDB->insertOnDuplicate($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varFieldsValues, 'MatriId');

	}

	if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varCategory !='120') {

	$varFields		= array('Email');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varExecute		= $objDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition, 0);
	$varEmailInfo	= mysql_fetch_array($varExecute);
	$varEmail	= $varEmailInfo['Email'];


	## CHECK LAST PAYMENT TIME
	$varFields		= array('Last_Payment','Name','Nick_Name','Expiry_Date');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varSelect		= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varMemberInfo	= mysql_fetch_array($varSelect);
	$varLastPayment	= $varMemberInfo['Last_Payment'];
	$varName		= $varMemberInfo['Name'];
	$varNickName	= $varMemberInfo['Nick_Name'];
	$varName		= $varNickName ? $varNickName : $varName;
	$varSplitExpiry	= split(" ",trim($varMemberInfo['Expiry_Date']));

	$varOfferContent = '';	
	$varIPLocation	 = getIptoLocation();
	if(in_array($varCategory,$varReebokOfferCatIds) && $varIPLocation=='IN' && $varReebokOffer==1) {
 
		$varMatriIdPrefix	= substr($sessMatriId,0,3);
		$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];
		$varOfferContent	= '<tr><td align="left" class="fleft smalltxt">Please provide your <a href="http://www.'.$varDomainName.'/site/index.php?act=paymentgift" target="_blank" class="clr5">Postal Address</a>, we will deliver your Reebok Watch within 7 days. In case you have any questions or queries, please contact our Customer care at 1-800-3000-2222.</td></tr>';
	}


	$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varDisPlayId];
	if($varAddonNoOfRecords>0){
		$varDisplayMessage		.=' with '.$arrPrdPackages[120];
		$varProfileHighlighter   = 1;
	}
	$varDisplayMessage		.="<br><br><b>Validity period :</b> ".$varTotalDays." days".$varExtraHoroCnt."<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr>".$varOfferContent."</table>";

	if($varAddonAmountPaid>0){
			$varAmount = $varAmount + $varAddonAmountPaid;
	}

	    

		$varPaymentMode		= 0;
		$varPaymentType		= 1;
		$varAmountWithCurr	= $varCurrency.' '.$varAmount;
		$varExpiryDate		= 'From '.date('Y-m-d').' To '.$varSplitExpiry[0];
		## $varTotalPhone		= ($arrPhonePackage[$varDisPlayId]+$varExtraPhone);

		$varActualPhone1	= $arrPhonePackage[$varDisPlayId];
		$varActualPhoneCnt1	= $varActualPhone1 ? $varActualPhone1 : 0;
		$varTotalPhone	    = ($varActualPhoneCnt1 + $varExtraPhone);

		$objPayment->paymentConfirmation($sessMatriId,$varName,$varEmail,$varCategory,$varAmountWithCurr,$varPaymentMode,$varPaymentType,$varExpiryDate,$varIPLocation,$varOfferProductId,$varTotalPhone,$varProfileHighlighter);
	}

	if ($varCategory =='100') {

		$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varCategory]."<br><br><b>Phone Count :</b> ".$arrPhonePackage[$varCategory]."<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr></table>";
	}

	if (($varCategory =='110') || ($varCategory =='111') || ($varCategory =='112')) {

		$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varCategory]."<br><br><b>Astro Count :</b> ".($arrAstroPackage[$varCategory]+$varExtraHoroscope)."<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr></table>";
	}
	if (($varCategory =='120')) {

		$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varCategory]."<br><br><b>Validity period :</b> ".$varTotalDays." days<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr>".$varOfferContent."</table>";
	}

		## PRIVILEGE MAIL
		if ($varCategory=='48'){

		## INSERT RMMEMBERINFO TABLE
		$varPrivilege1			= array('MatriId','MemberName','ProductId','ValidDays','ExpiryDate','PrivStatus','PaidStatus','TimeCreated');
		$varPrivilegeValues1	= array($objDB->doEscapeString($sessMatriId,$objDB),"'".$varName."'","'".$varCategory."'","'".$varTotalDays."'",'DATE_ADD(NOW(),INTERVAL '.$varTotalDays.' DAY)','2','1','NOW()');
		$objDB->insertOnDuplicate('cbsrminterface.rmmemberinfo', $varPrivilege1, $varPrivilegeValues1, 'MatriId');

		$objPayment->privilegeMail($sessMatriId,$varName,$varEmail,date('Y-m-d'));

		}## if

		}

		return $varDisplayMessage;

	}## upgradeProfile

## Prifile Downgrade function Start
function downgradeProfile($sessMatriId,$varProductId,$varRefundRequestId,$varSpecialPriv,$objDB,$objSlaveRM,$objDBOffline){
        global $arrPhonePackage,$varTable,$TABLE,$varCbsRminterfaceDbInfo; 
        
		##Update onlinepaymentdetails TABLE
		$varFields				= array('Auto_Renew');
		$varFieldsValues		= array("0");
		$varOrderIdCondition	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->update('onlinepaymentdetails', $varFields, $varFieldsValues, $varOrderIdCondition);
		
		##Reset Memeberinfo table
		$varFields				= array('Valid_Days','Paid_Status','PowerPackOpted','Number_Of_Payments','Expiry_Date');
		$varFieldsValues		= array("0","0","0","Number_Of_Payments-1","DATE_SUB(Expiry_Date,interval Valid_Days DAY)");
		$varMemCondition	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValues, $varMemCondition);
		        
		##Reset MEMBERSTATISTICS table
		$varFields				= array('TotalMessagesSentLeft','DateUpdated');
		$varFieldsValues		= array("0","NOW()");
		$varStatisCondition	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->update($varTable['MEMBERSTATISTICS'], $varFields, $varFieldsValues, $varStatisCondition);
		
		##SELECT phone number count...
		$varPhonenos			= $arrPhonePackage[$varProductId];
		$varFields				= array('TotalPhoneNos','NumbersLeft');
		$varCondition			= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$varPhoneDets			= $objDB->select($varTable['PHONEPACKAGEDET'], $varFields, $varCondition, 1);
        
		## Check Previous Phone Count
		if($varPhoneDets[0]['TotalPhoneNos']<$varPhonenos){
			$varPhonenos = 0;
		}

        ##Reduce phone number count
		$varFields				= array('TotalPhoneNos','NumbersLeft');
		$varFieldsValues		= array("TotalPhoneNos-$varPhonenos","NumbersLeft-$varPhonenos");
		$varPhoneCondition	    = " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->update($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsValues, $varPhoneCondition);
		
		##Update paymentdetails tables
		$today                  = date('d-m-Y h:i:s');
		$varFields				= array('Comments');
		$varFieldsValues		= array("'ONLINE PAYENT REFUNDED on $today'");
		$varStatisCondition	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB)." AND Payment_Type=1 AND Payment_Mode=1 AND Payment_Gateway=5";
		$objDB->update($varTable['PAYMENTHISTORYINFO'], $varFields, $varFieldsValues, $varStatisCondition);
		
		##Update Refund status as accepted in Offline DB
		$varFields				= array('Status');
		$varFieldsValues		= array("1");
		$varOrderIdCondition	= " MatriId =".$objDBOffline->doEscapeString($sessMatriId,$objDBOffline)." AND RefundRequestId='".$varRefundRequestId."'";
		$objDBOffline->update($varTable['CBSPAYMENTSREFUND'], $varFields, $varFieldsValues, $varOrderIdCondition);
        
		## Product 48 or 56 then reset the details in RM INTERFACE
		## Downgrade RM details start here
		if($varProductId == 48 || $varProductId == 56){

			##SELECT Online Payment Details...
			$varRmFields	    = array('PrivStatus');
			$varCondition		= " WHERE MatriId =".$objSlaveRM->doEscapeString($sessMatriId,$objSlaveRM);
			$varRmDets			= $objSlaveRM->select($TABLE['RMMEMBERINFO'], $varRmFields, $varCondition, 1);
			             
            ## Check whether it is converted to Full accesse in RM interface
            if($varSpecialPriv == 3 && $varRmDets[0]['PrivStatus']==1){

            ##Get Member contact details from RM DB      
			$varActFields	= array("MatriId","PhoneNo1","ContactPerson1","Relationship1","Timetocall1","PhoneVerified","Email","CountryCode","AreaCode","PhoneNo","MobileNo");
			$varActCondtn	= " where MatriId IN(".$objSlaveRM->doEscapeString($sessMatriId,$objSlaveRM).")";
			$varContactInfo = $objSlaveRM->select($TABLE['MEMBERCONTACTINFOBKUP'],$varActFields,$varActCondtn,1);

			$varPhoneNo1			= $varContactInfo[0]['PhoneNo1'];
			$varContactPerson1		= $varContactInfo[0]['ContactPerson1'];
			$varRelationship1		= $varContactInfo[0]['Relationship1'];
			$varTimetocall1			= $varContactInfo[0]['Timetocall1'];
			$varPhoneVerified		= $varContactInfo[0]['PhoneVerified'];
			$varEmail				= $varContactInfo[0]['Email'];
			$varCountryCode			= $varContactInfo[0]['CountryCode'];
			$varAreaCode			= $varContactInfo[0]['AreaCode'];
			$varPhoneNo				= $varContactInfo[0]['PhoneNo'];
			$varMobileNo			= $varContactInfo[0]['MobileNo'];

			##Revert the member email id from RM DB to Memberlogininfo
			if($varEmail!=''){
			$varUpdateFields	= array("Email","Date_Updated");
			$varUpdateVal	    = array($objDB->doEscapeString($varEmail,$objDB),"NOW()");
			$varUpdateCondtn	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
			$updateid = $objDB->update($varTable['MEMBERLOGININFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
			}
            
			##Update memberinfo for reverting BM privilege status to normal package status
			$varUpdateFields	= array("Special_Priv","Phone_Verified","Date_Updated");
			$varUpdateVal	    = array("2","'".$varPhoneVerified."'","NOW()");
			$varUpdateCondtn	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
			$updateid = $objDB->update($varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
			            
			##Update member Assured Contact Details which is priviously updated as RM details
			if($varPhoneVerified == 1 || $varPhoneVerified == 3){
				$varUpdateFields	= array("PhoneNo1","ContactPerson1","Relationship1","Timetocall1","CountryCode","AreaCode","PhoneNo","MobileNo");
				$varUpdateVal	= array("'".$varPhoneNo1."'","'".$varContactPerson1."'","'".$varRelationship1."'","'".$varTimetocall1."'","'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'");
				$varUpdateCondtn	= " MatriId=".$objDB->doEscapeString($sessMatriId,$objDB);
				$updateid = $objDB->update($varTable['ASSUREDCONTACT'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
			}elseif(($varPhoneVerified == 0) || ($varPhoneVerified == "")){
				$varUpdateCondtn  = " MatriId=".$objDB->doEscapeString($sessMatriId,$objDB);
				$updateid         = $objDB->delete($varTable['ASSUREDCONTACT'],$varUpdateCondtn);
				##Delete contact details of RM
			}

		   }else{
			##Update memberinfo for reverting BM privilege status to normal package status
			$varUpdateFields	= array("Special_Priv","Date_Updated");
			$varUpdateVal	    = array("2","NOW()");
			$varUpdateCondtn	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
			$updateid = $objDB->update($varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
		   }
            
			##Take backup of member details into RM MEMBERINFO Backup table
			$insertquery = "insert into ".$varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFOBKUP']." select * from ".$varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO']." where MatriId=".$objDB->doEscapeString($sessMatriId,$objDB);
			$objDB->ExecuteQryResult($insertquery,0);
            
			##Delete member details from RM memberinfo
			$varUpdateCondtn = " MatriId=".$objDB->doEscapeString($sessMatriId,$objDB);
			$updateid		 = $objDB->delete($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varUpdateCondtn);

		} ## Downgrade RM details end here.

		$varDisplayMessage = "Your Paid Membership auto renewal has been cancelled successfully. You are now a free member on our site.";

		return $varDisplayMessage;
	}##Prifile Downgrade function End

	function sendProfileHighlighterRemaindermail($sessMatriId,$varDomainName,$varProtectedStatus){ 
	$subject = "Profile Highlighter Package Member Folloup Mail";
	$message = "Hi Team,<br><br>\n\n";
	if($varProtectedStatus==0){
	$message.= "The member($sessMatriId) bought profile highlighter package but photo is not uploaded so kindly contact and make them to uploade the photo.";
	}else{
    $message.= "The member($sessMatriId) bought profile highlighter package but photo protected status is ON so kindly contact and make them to set photo protected status OFF.";
	}
	$message.= "<br><br>Thanks,<br>\n";
	$message.= ucwords($varDomainName)." Team";	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: info@".$varDomainName." <info@".$varDomainName.">\n";	

	$mail3 = mail('nazir@bharatmatrimony.com', $subject, $message, $headers);
   }

}## UpgradeProfile

?>