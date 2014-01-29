<?php 
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2011-01-24
# End Date		: 2011-01-24
# Project		: Community
# Module		: Payment - IVRS integration
#=============================================================================================================

//error_reporting(E_ALL);
//ini_set('display_errors','1');
$_CBS_IncludeFolder	= '/var/home/bharatmatrimony/www/ivrspayment/cbs';
//$_CBS_IncludeFolder		= '/home/product/community';

## FILE INCLUDES
include_once($_CBS_IncludeFolder."/conf/config.cil14");
include_once($_CBS_IncludeFolder.'/conf/payment.cil14');
include_once($_CBS_IncludeFolder."/conf/dbinfo.cil14");
include_once($_CBS_IncludeFolder."/lib/clsMemcacheDB.php");
include_once($_CBS_IncludeFolder."/lib/clsPayment.php");
include_once($_CBS_IncludeFolder."/lib/clsUpgrade.php");

## INPUT FROM IVRS
$varOrderId				= trim($_REQUEST["orderId"]);

## OBJECT DECLARATION
$objDB					= new MemcacheDB;
$objPayment				= new Payment;
$objUpgradeProfile		= new UpgradeProfile;

## CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

$varCondition	 = " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
$varCheckOrderId = $objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

if($varCheckOrderId>0){
echo 'FAILED - Payment already made for this OrderId-'.$varOrderId;

## DELETE ONLINETOIVRCONVERSIONPAYMENTDETAILS TBALE
$varCondition12		= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
$objDB->delete($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varCondition12);

exit;	
}

if(isset($_REQUEST['submitotp']))
 {
    	
	$varFields		= array('MatriId','OrderId','Product_Id','Amount_Paid','Currency','AES_DECRYPT(Card_Number,"password") As Card_Number','AES_DECRYPT(CVV,"password") As CVV','Expiry_Month','Expiry_Year','Request_Id','Response_Id');
	$varExecute		= $objDB->select($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varFields, $varCondition, 0);

	$varPaymentInfo	        = mysql_fetch_array($varExecute);
    $varMobilePassword		= trim($_REQUEST['otp']);
	$varCreditcardNumber	= trim($varPaymentInfo["Card_Number"]);
	$varExpMonth			= trim($varPaymentInfo["Expiry_Month"]);
	$varExpYear				= trim($varPaymentInfo["Expiry_Year"]);
	$varExpYear             = "20".$varExpYear;
	$varCVV					= trim($varPaymentInfo["CVV"]);
	$varCardType            = checkCreditCardType($varCreditcardNumber);
	$varRequestId           = $varPaymentInfo['Request_Id'];
	$varResponseId          = $varPaymentInfo['Response_Id'];
	$varCardFirstDigit		= substr($varCreditcardNumber,0,1);
	$varStrMerchantId		= "00005182"; //?
	
	$sessMatriId			= $varPaymentInfo['MatriId'];
	$varCategory			= $varPaymentInfo['Product_Id'];
	$varAmount				= floor($varPaymentInfo['Amount_Paid']);
	$varCurrency			= $varPaymentInfo['Currency'];
	$varValidDays			= $arrPkgValidDays[$varCategory];
	$varTotalDays			= $arrPkgValidDays[$varCategory];
	$varMessage				= '';
	$varSubject				= '';
	$varIPLocation			= '';

	$varCondition		 = " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varAddonNoOfRecords = $objDB->numOfRecords($varTable['ADDONPREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
    if($varAddonNoOfRecords>0){
	$varPrepaymentFields	= array('Amount_Paid','Product_Id');
	$varOrderIdCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varPrepaymentTrackinfo	= $objDB->select($varTable['ADDONPREPAYMENTHISTORYINFO'], $varPrepaymentFields, $varOrderIdCondition, 0);
	$varPaymentTrackInfo	= mysql_fetch_array($varPrepaymentTrackinfo);
	$varAddonAmountPaid		= $varPaymentTrackInfo["Amount_Paid"];

	$varAmount              = $varAmount + $varAddonAmountPaid;
	}

	# Validate card number starts here =============== 	

	if(strlen($varCategory) == 0){
		echo 'FAILED - Category Not Found';	
		exit;}

	if(strlen($varCreditcardNumber) == 0){
		echo 'FAILED - CardNO Not Found';	
		exit;}

	if(($varCardFirstDigit != 3)&&($varCardFirstDigit != 4)&&($varCardFirstDigit != 5)){
		echo 'FAILED - Cardno Error1';	
		exit;}   

	if(($varCardFirstDigit == 3)&&(strlen($varCreditcardNumber) != 14)){
		echo 'FAILED - Cardno Error2';	
		exit;}

	if((($varCardFirstDigit == 4) || ($varCardFirstDigit == 5)) && (strlen($varCreditcardNumber) != 16)){
		echo 'FAILED - Cardno Error3';	
		exit;}

	if(substr($varCreditcardNumber,0,4) == '5081'){
		echo 'FAILED - Cardno Error4';	
		exit;}

	if(strlen($varExpMonth) == 0){
		echo 'FAILED - ExpMonth Error';	
		exit;}

	if(strlen($varExpYear) == 0){
		echo 'FAILED - ExpYear Error';	
		exit;}

	if(strlen($varCVV) == 0){
		echo 'FAILED - CVV Error1';	
		exit;}

	if(strlen($varCVV) != 3){
		echo 'FAILED - CVV Error2';		
		exit;}	

	if(strlen($varMobilePassword) == 0){
		echo 'FAILED - OTP';	
		exit;}
    
	if(strlen($varRequestId) == 0){
		echo 'FAILED - Request ID';	
		exit;}

	if(strlen($varResponseId) == 0){
		echo 'FAILED - Response ID';	
		exit;}

	if(trim($varCardType) == 'NONE'){
	   echo 'FAILED - CardType Error';
	   exit;}
	
	# Validate card number ends here =============== 

	## IVRS Components include
	$varIncludePath="/home/bharatmatrimony/www/ivrspayment/";
	//$varIncludePath="/home/product/community/www/payment/ivrspayment/";
	include($varIncludePath."Sfa/BillToAddress.php");
	include($varIncludePath."Sfa/CardInfo.php");
	include($varIncludePath."Sfa/Merchant.php");
	include($varIncludePath."Sfa/MPIData.php");
	include($varIncludePath."Sfa/ShipToAddress.php");
	include($varIncludePath."Sfa/PGResponse.php");
	include($varIncludePath."Sfa/PostLibPHP.php");
	include($varIncludePath."Sfa/PGReserveData.php");
	include($varIncludePath."Sfa/Address.php");
	include($varIncludePath."Sfa/SessionDetail.php");
	include($varIncludePath."Sfa/CustomerDetails.php");
	include($varIncludePath."Sfa/MerchanDise.php");
	include($varIncludePath."Sfa/AirLineTransaction.php");

	$oMPI 		            = 	new MPIData();
	$oCI		            =	new	CardInfo();
	$oPostLibphp            =	new	PostLibPHP();
	$oMerchant	            =	new	Merchant();
	$oBTA		            =	new	BillToAddress();	
	$oSTA		            =	new	ShipToAddress();
	$oPGResp	            =	new	PGResponse();
	$oPGReserveData         =   new PGReserveData();

    ## Bharosa Object

	$oSessionDetails   		=  new SessionDetail();
	$oCustomerDetails   	=  new CustomerDetails();
	$oOfficeAddress      	=  new Address();
	$oHomeAddress    		=  new Address();
	$oMerchanDise       	=  new MerchanDise();
	$oAirLineTransaction 	=  new AirLineTransaction();
    
    $varSendRequestURL		= "https://3dsecure.payseal.com/MPIXMLService/authenticate";
	ob_start();
    $varCurl				= curl_init();
    $varSendRequestPostDetails="xmlData=<req-auth>
									<request-id>".$varRequestId."</request-id>
									<response-id>".$varResponseId."</response-id>
									<req-type>1002</req-type>
									<auth-data>
									     <field name='OTP2' value='".$varMobilePassword."' />
									</auth-data>
							  </req-auth>";
    
	curl_setopt ($varCurl, CURLOPT_URL, $varSendRequestURL);
	curl_setopt ($varCurl, CURLOPT_POST, 1);
	curl_setopt ($varCurl, CURLOPT_POSTFIELDS, $varSendRequestPostDetails);
	curl_exec ($varCurl);
	curl_close ($varCurl);
	$varSendRequestResult = ob_get_contents();
	ob_end_clean();
	
	$varGetXMLResponce  = simplexml_load_string($varSendRequestResult);
	$varECI				= $varGetXMLResponce->xpath('/res-auth/auth-result/eci');
	$varXID				= $varGetXMLResponce->xpath('/res-auth/auth-result/xid');
	$varCavv			= $varGetXMLResponce->xpath('/res-auth/auth-result/cavv');
	$varErrorCodes		= $varGetXMLResponce->xpath('/res-auth/auth-result/error-code');

	if((($varCardType =='VISA' && $varECI[0]=='05') || ($varCardType =='MC' && $varECI[0]=='02')) && $varErrorCodes[0] == '0') {

    	$oMerchant->setMerchantDetails($varStrMerchantId,"","",$_SERVER['REMOTE_ADDR'],$varOrderId,"","","POST","INR","","req.Sale",$varAmount,"","","","","","");
	    $oCI->setCardDetails($varCardType,$varCreditcardNumber,$varCVV,$varExpYear,$varExpMonth,"","CREDI");
	    $oMPI->setMPIResponseDetails(trim($varECI[0]),trim($varXID[0]), "Y",trim($varCavv[0]),"",$varAmount,"356");
	}else{
        ## DELETE ONLINETOIVRCONVERSIONPAYMENTDETAILS TBALE
		$varCondition12		= " OrderId ='".$varOrderId."'";
		$objDB->delete($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varCondition12);

		echo 'FAILED - SECOND LEVEL AUTHENTICATION FAILED';
		exit;
	}

	
	$oBTA				= null;
	$oSTA				= null;	
	$oPGReserveData		= null;
	$oCustomerDetails	= null;
	$oSessionDetails	= null;
	$oAirLineTransaction= null;
	$oMerchanDise		= null;
    
 	$oPGResp=$oPostLibphp->postMOTO($oBTA,$oSTA,$oMerchant,$oMPI,$oCI,$oPGReserveData,$oCustomerDetails,$oSessionDetails,$oAirLineTransaction,$oMerchanDise);

	
	/*echo "<br>varMotoRespCode:".$varMotoRespCode		= java_values($oPGResp->getRespCode());
	echo "<br>varMotoRespMessage:".$varMotoRespMessage 	= java_values($oPGResp->getRespMessage());
	echo "<br>varMotoTxnId:".$varMotoTxnId			= java_values($oPGResp->getTxnId());
	echo "<br>varMotoEpgTxnId:".$varMotoEpgTxnId		= java_values($oPGResp->getEpgTxnId());
	echo "<br>varMotoAuthIdCode:".$varMotoAuthIdCode		= java_values($oPGResp->getAuthIdCode());
	echo "<br>varMotoRRN:".$varMotoRRN				= java_values($oPGResp->getRRN());
	echo "<br>varMotoCVRespCode:".$varMotoCVRespCode		= java_values($oPGResp->getCVRespCode());
    echo "<br>varMotoFDMSScore:".$varMotoFDMSScore		= java_values($oPGResp->getFDMSScore());
	echo "<br>varMotoFDMSResult:".$varMotoFDMSResult		= java_values($oPGResp->getFDMSResult());   
	echo "<br>varMotoCookie:".$varMotoCookie			= java_values($oPGResp->getCookie());*/

    
	$varMotoRespCode		= java_values($oPGResp->getRespCode());
	$varMotoRespMessage 	= java_values($oPGResp->getRespMessage());
	$varMotoTxnId			= java_values($oPGResp->getTxnId());
	$varMotoEpgTxnId		= java_values($oPGResp->getEpgTxnId());
	$varMotoAuthIdCode		= java_values($oPGResp->getAuthIdCode());
	$varMotoRRN				= java_values($oPGResp->getRRN());
	$varMotoCVRespCode		= java_values($oPGResp->getCVRespCode());
    $varMotoFDMSScore		= java_values($oPGResp->getFDMSScore());
	$varMotoFDMSResult		= java_values($oPGResp->getFDMSResult());   
	$varMotoCookie			= java_values($oPGResp->getCookie());

    if($varMotoRespCode=='0'){
        		
		echo  "PAYMENT CHARGING PROCESS SUCCESS AND UPGRADING PROFILE";
		$varDisplayMessage	= $objUpgradeProfile->CBS_upgradeProfile($sessMatriId,$varOrderId,$varCategory,$varAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment,$varIPLocation,$varTable['PREPAYMENTHISTORYINFO']);

		## DELETE BEFORE VALIDATION TBALE
		$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->delete('onlinepaymentfailures', $varCondition12);

		## DELETE ONLINETOIVRCONVERSIONPAYMENTDETAILS TBALE
		$varCondition12		= " OrderId ='".$objDB->doEscapeString($varOrderId,$objDB);
		$objDB->delete($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varCondition12);
	}
	else{
        echo 'PAYMENT CHARGING PROCESS FAILED';
		## UPDATE SECURE FAILURE
		$varFields12		= array('3dSecureFailure');
		$varFieldsValue12	= array('1');
		$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->update('onlinepaymentfailures', $varFields12, $varFieldsValue12, $varCondition12);
	}	
 }
 else if($varOrderId){

?>
 <body>
 <form name="frmOTP" id="frmOTP" method="POST" action="https://bharatmatrimony.com/ivrspayment/cbs/payment/cbs_support_ivr_upgradation.php" onSubmit="return validateotp();" style="margin:0px;" >
 <!--form name="frmOTP" id="frmOTP" method="POST" action="http://communitymatrimony.com/payment/cbs_support_ivr_upgradation.php" onSubmit="return validateotp();" style="margin:0px;" -->
 <input type="hidden" value="<?=$varOrderId?>" name="orderId" id="orderId" >

 <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #EBC4B0;" align="center">
		<tr>
			<td colspan="3" height="22" bgcolor="#EBC4B0"  style="padding-left:15px;" align="center"><font class="mediumtxt boldtxt">One Time Password (OTP) Details-<?=$varOrderId?></font></td>
		</tr>

		
		<tr>
			<td height="47" style="padding-left:15px;border-bottom: 1px solid #EBC4B0;"><font class="mediumtxt boldtxt"><B>Enter One Time Password (OTP)</B></font></td>
			<td style="border-bottom: 1px solid #EBC4B0;padding-left:5px;">
			<input type="text" size="19" value="" name="otp" id="otp" class="inputtext">
            </td>
		</tr>
		
		<tr>
			<td colspan="2" align="center" height="75" style="border-top: 1px solid #EBC4B0;"><input type="submit" name="submitotp" id="submitotp" class="button pntr" value="Submit"></td>
			<td style="border-top: 1px solid #EBC4B0;">&nbsp;</td>
		</tr>
		

		</table>
		</td>
	</tr>
				
</table>
</form>  
</body>
</html>
<?
}







function checkCreditCardType($cardnumber) {
   
  $checksum = 0;                                  
  $mychar = "";                                  
  $j = 1;                         
  for ($i = strlen($cardnumber) - 1; $i >= 0; $i--) {           
    $calc = $cardnumber{$i} * $j;      
    if ($calc > 9) {
   $checksum = $checksum + 1;
   $calc = $calc - 10;
    }      
    $checksum = $checksum + $calc;
    if ($j ==1) {$j = 2;} else {$j = 1;};
  }
  
  $errornumber = 0;
  if ($checksum % 10 != 0) {
    $errornumber = 1; 
  }
   
  if(preg_match('/^[0-9]{1,}/', $cardnumber) && strlen($cardnumber)=='16' && (substr($cardnumber,0,2)=='51' || substr($cardnumber,0,2)=='52' || substr($cardnumber,0,2)=='53' || substr($cardnumber,0,2)=='54' || substr($cardnumber,0,2)=='55') && $errornumber!=1){
   return 'MC';
  }
  elseif(preg_match('/^[0-9]{1,}/', $cardnumber) && (strlen($cardnumber)=='13' || strlen($cardnumber)=='16') && substr($cardnumber,0,1)=='4' && $errornumber!=1){
   return 'VISA';
  }
  else{
   return 'NONE';
  }
 
 }


function getResponseDescription($responseCode) {
  switch ($responseCode) {
   case "0"  : $result = "Success"; break;
   case "1"  : $result = "Request Field Invalid"; break;
   case "2"  : $result = "System Under Maintenance"; break;
   case "3"  : $result = "Internal Server Error"; break;
   case "4"  : $result = "Database Server Error"; break;
   case "5"  : $result = "Protocol Error"; break;
   case "6"  : $result = "Does not have Permission"; break;
   case "7"  : $result = "Card Not Part of 3DS Range"; break;
   case "8"  : $result = "Invalid Auth Data"; break;
   case "9"  : $result = "Invalid Request Type"; break;
   case "10" : $result = "Invalid Request XML format"; break;
   case "11" : $result = "Hash Check Failed"; break;
   case "12" : $result = "Invalid Merchant Id"; break;
   case "13" : $result = "ITP Validation failed"; break;
   case "14" : $result = "Timed out"; break;
   case "15" : $result = "Unable to process request"; break;
   default   : $result = "Unable to be determined"; 
  }
  return $result;
}


?>