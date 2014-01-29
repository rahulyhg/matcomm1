<?php
#=============================================================================================================
# Author 		: M Baranidharan
# Start Date	: 2010-12-23
# End Date		: 2010-12-23
# Project		: MatrimonyProduct
# Module		: CBS AUTO RENEWAL FLOW
#=============================================================================================================

//INCLUDE FILES
include_once('/home/product/community/conf/config.cil14');
include_once('/home/product/community/conf/emailsconfig.cil14');
include_once('/home/product/community/conf/domainlist.cil14');
include_once('/home/product/community/conf/vars.cil14');
include_once('/home/product/community/lib/clsMailManager.php');

Class AutoRenewal extends MailManager {

	public $clsFilePath		= '/home/product/community/bin/autorenewal';
	public $clsDeclineFile	= '';
	public $clsSuccessFile	= '';

	function checkCreditCard ($cardnumber, $cardname, $errornumber, $errortext) {
	  
	  $cards = array (  array ('name' => 'American Express', 
							  'length' => '15', 
							  'prefixes' => '34,37',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Diners Club Carte Blanche', 
							  'length' => '14', 
							  'prefixes' => '300,301,302,303,304,305',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Diners Club', 
							  'length' => '14,16',
							  'prefixes' => '305,36,38,54,55',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Discover', 
							  'length' => '16', 
							  'prefixes' => '6011,622,64,65',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Diners Club Enroute', 
							  'length' => '15', 
							  'prefixes' => '2014,2149',
							  'checkdigit' => true
							 ),
					   array ('name' => 'JCB', 
							  'length' => '16', 
							  'prefixes' => '35',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Maestro', 
							  'length' => '12,13,14,15,16,18,19', 
							  'prefixes' => '5018,5020,5038,6304,6759,6761',
							  'checkdigit' => true
							 ),
					   array ('name' => 'MasterCard', 
							  'length' => '16', 
							  'prefixes' => '51,52,53,54,55',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Solo', 
							  'length' => '16,18,19', 
							  'prefixes' => '6334,6767',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Switch', 
							  'length' => '16,18,19', 
							  'prefixes' => '4903,4905,4911,4936,564182,633110,6333,6759',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Visa', 
							  'length' => '13,16', 
							  'prefixes' => '4',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Visa Electron', 
							  'length' => '16', 
							  'prefixes' => '417500,4917,4913,4508,4844',
							  'checkdigit' => true
							 ),
					   array ('name' => 'LaserCard', 
							  'length' => '16,17,18,19', 
							  'prefixes' => '6304,6706,6771,6709',
							  'checkdigit' => true
							 )
					);

	  $ccErrorNo = 0;
	  $ccErrors [0] = "Unknown card type";
	  $ccErrors [1] = "No card number provided";
	  $ccErrors [2] = "Credit card number has invalid format";
	  $ccErrors [3] = "Credit card number is invalid";
	  $ccErrors [4] = "Credit card number is wrong length";
				   
	  // Establish card type
	  $cardType = -1;
	  for ($i=0; $i<sizeof($cards); $i++) {
		// See if it is this card (ignoring the case of the string)
		if (strtolower($cardname) == strtolower($cards[$i]['name'])) {
		  $cardType = $i;
		  break;
		}
	  }
	  
	  // If card type not found, report an error
	  if ($cardType == -1) {
		 $errornumber = 0;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
	   
	  // Ensure that the user has provided a credit card number
	  if (strlen($cardnumber) == 0)  {
		 $errornumber = 1;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
	  
	  // Remove any spaces from the credit card number
	  $cardNo = str_replace (' ', '', $cardnumber);  
	   
	  // Check that the number is numeric and of the right sort of length.
	  if (!eregi('^[0-9]{13,19}$',$cardNo))  {
		 $errornumber = 2;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
		   
	  // Now check the modulus 10 check digit - if required
	  if ($cards[$cardType]['checkdigit']) {
		$checksum = 0;                                  // running checksum total
		$mychar = "";                                   // next char to process
		$j = 1;                                         // takes value of 1 or 2
	  
		// Process each digit one by one starting at the right
		for ($i = strlen($cardNo) - 1; $i >= 0; $i--) {
		
		  // Extract the next digit and multiply by 1 or 2 on alternative digits.      
		  $calc = $cardNo{$i} * $j;
		
		  // If the result is in two digits add 1 to the checksum total
		  if ($calc > 9) {
			$checksum = $checksum + 1;
			$calc = $calc - 10;
		  }
		
		  // Add the units element to the checksum total
		  $checksum = $checksum + $calc;
		
		  // Switch the value of j
		  if ($j ==1) {$j = 2;} else {$j = 1;};
		} 
	  
		// All done - if checksum is divisible by 10, it is a valid modulus 10.
		// If not, report an error.
		if ($checksum % 10 != 0) {
		 $errornumber = 3;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
		}
	  }
	  // The following are the card-specific checks we undertake.

	  // Load an array with the valid prefixes for this card
	  $prefix = split(',',$cards[$cardType]['prefixes']);
		  
	  // Now see if any of them match what we have in the card number  
	  $PrefixValid = false; 
	  for ($i=0; $i<sizeof($prefix); $i++) {
		$exp = '^' . $prefix[$i];
		if (ereg($exp,$cardNo)) {
		  $PrefixValid = true;
		  break;
		}
	  }
		  
	  // If it isn't a valid prefix there's no point at looking at the length
	  if (!$PrefixValid) {
		 $errornumber = 3;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
		
	  // See if the length is valid for this card
	  $LengthValid = false;
	  $lengths = split(',',$cards[$cardType]['length']);
	  for ($j=0; $j<sizeof($lengths); $j++) {
		if (strlen($cardNo) == $lengths[$j]) {
		  $LengthValid = true;
		  break;
		}
	  }
	  
	  // See if all is OK by seeing if the length was valid. 
	  if (!$LengthValid) {
		 $errornumber = 4;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  };   
	  
	  // The credit card is in the required format.
	  return true;
	}

    //Create CSV file
	function writeCSV($argFileName,$argCardDetails) {
		if($varFileOpen	= fopen($argFileName,'a')) {
			if(fwrite($varFileOpen,$argCardDetails)==TRUE){ return true; }
			fclose($varFileOpen);			
		}//if
	}//writeCSV

	
	//Auto renewal Email
	function autoRenewalEmail($argMatriId,$argName,$argEmail,$argOrderId,$argAmount,$argCategoryName,$argProductId) {
        global $confValues;
		
		$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/autorenewal_success.tpl"; //do change (template file)
		$this->clsViewTemplate	= $this->getContentFromFile($varTemplateFileName);
		$arrGetProductInfo		= $this->getDomainDetails($argMatriId);
		$arrGetEmailInfo		= $this->getDomainEmailList($argMatriId);
		$varDuration			= 15;

		if ($argOfferProductId >0 ) { $argProductId = $argOfferProductId;  }
		if ($argProductId==1) { $varDuration = 15; }
		elseif ($argProductId==4) { $varDuration = 20; }
		elseif ($argProductId==7) { $varDuration = 25; }

		$funFrom				= $arrGetProductInfo['FROMADDRESS'];
		$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
		$funReplyToEmail		= str_replace('info','payment',$funFromEmail);
		$funServerUrl			= $arrGetProductInfo['SERVERURL'];
		$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];
		$funIMGSPath			= $arrGetProductInfo['IMGURL'];
		$funFolderName			= $this->getFolderName($argMatriId);
		$funProductName			= $arrGetProductInfo['PRODUCTNAME'];
		$funBranch				= '';	
        $funSubject				= "Your account has been Auto-renewed with FREE Profile Highlighter!";
        $loginUrl = $funServerUrl.'/login/index.php?redirect='.$funServerUrl.'/payment/?act=cbscanceloptimalonlinepayment~orderId='.base64_encode($argOrderId);

		$funPlaceHolder			= "<--LOGO-->";
		$funReplaceValue		= $funIMGSPath.'/logo/'.$funFolderName;
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funReplaceValue,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MAILERIMGPATH-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funMailerImagePath,$this->clsViewTemplate);

		$funPlaceHolder			= "<--SERVER_URL-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$funServerUrl,$this->clsViewTemplate);

		$funPlaceHolder			= "<--NAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argName,$this->clsViewTemplate);

		$funPlaceHolder			= "<--MATRIID-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argMatriId,$this->clsViewTemplate);

		$funPlaceHolder			= "<--AMOUNT-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argAmount,$this->clsViewTemplate);

		$funPlaceHolder			= "<--CATEGORYNAME-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argCategoryName,$this->clsViewTemplate);

		$funPlaceHolder			= "<--DURATION-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$varDuration,$this->clsViewTemplate);		

		$funPlaceHolder			= "<--ORDERID-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$argOrderId,$this->clsViewTemplate);

		$funPlaceHolder			= "<--LOGINURL-->";
		$this->clsViewTemplate	= str_replace($funPlaceHolder,$loginUrl,$this->clsViewTemplate);

		$this->clsViewTemplate	=  str_replace("<--PRODUCT_NAME-->",$funProductName,$this->clsViewTemplate);

		$funToEmail				= $argEmail;//$this->getEmail($argMatriId);
		$funMessage				= stripslashes($this->clsViewTemplate);
		
		$retResult = $this->sendEmail($funFrom,$funFromEmail,$funTo,$funToEmail,$funSubject,$funMessage,$funReplyToEmail);

		return $retResult;

	}//Auto renewal Email


}//AutoRenwal
?>