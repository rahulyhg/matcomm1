<?php
/*******************************************************************************************************************
File    : communityregisterphoneedit.php
Author  : Thavaprakash. S.
Date    : 07-June-2010
********************************************************************************************************************
Description:
This page contains the record insertion in assured contact temp table in registration edit.
********************************************************************************************************/
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//file includes
/*
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
*/
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/com_phonefunction.cil14');
//OBJECT DECLARTION
$objRegister	= new clsRegister;

//CONNECT DATABASE
$objRegister->dbConnect('M',$varDbInfo['DATABASE']);


$outputcontent = "";

$memberid		= trim($_POST["memid"]);
$iCountry		= trim($_POST["assuredcountry"]);
$iCountry		= trim($arrIsdCountryCode[$iCountry]); //converting isd code
$iArea			= trim($_POST["area"]);
$iPhoneNo		= trim($_POST["phoneno"]);
$iMobile		= trim($_POST["MOBILENO"]);
$varAge			= trim($_POST["age"]);
$varGender		= trim($_POST["gender"]);
$varCommunityId	= trim($_POST["langid"]);


if ($iArea == '0'){
  $iArea = "";
  $displaythisonscreen="Please enter valid Area code.";
}elseif($iPhoneNo == '0'){
  $iPhoneNo = "";
  $displaythisonscreen="Please enter valid Phone Number.";
}elseif($iMobile == '0'){
  $iMobile = "";
  $displaythisonscreen="Please enter valid Mobile number.";
}else{
  if(($iArea != "")&&($iPhoneNo != "")&&($iMobile != "")){
    $displaythisonscreen="Please enter either Phone No. or Mobile No.";
  }if(($iCountry == "")||($iCountry == 0)){
    $displaythisonscreen="Please select Country.";
  }
}
if(!$displaythisonscreen){

	
	if($iMobile!=''){
		$iPhoneNumber = "$iCountry~$iMobile";
		$iPhoneNo = '';
		$iAutoCall = $iMobile;
		$iMobileNumber=$iAutoCall;// for update mobile number
		if($iCountry!=91){
		  if($iArea != ''){
			$iAutoCall = $iArea.$iMobile;
			$iMobileNumber = $iAutoCall;// for update mobile number
			$iPhoneNumber = "$iCountry~$iArea~$iMobile";
		  }else{
			$iArea = '';
		  }
		}else{
		  $iArea = '';
		  if(substr($iMobile,0,1)!='0')
			$iAutoCall = '0'.$iMobile;
		}
	}else{
		$iMobile='';
		$iAutoCall = $iArea.$iPhoneNo;
		$iPhoneNumber = "$iCountry~$iArea~$iPhoneNo";
	}

	$iCallNumber = $iAutoCall; 
	if($iCountry!=91)
	$iAutoCall = "00".$iCountry.$iAutoCall;
	$iAutoCall = preg_replace('/\D/','',$iAutoCall);



	$varCondition	= " WHERE MatriId=".$objRegister->doEscapeString($memberid,$objRegister);
	$varFields		= array('PinNo');
	$varPhResults	= $objRegister->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varFields,$varCondition,1);
	$varPhonePin	= $varPhResults[0]['PinNo'];

	if($varPhonePin==""){
		$varPhonePin=getPhonePinNo($objRegister,$varTable['ASSUREDCONTACTPINNOSERIES']);
	}


	$varFields		= array('PinNo','MatriId','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ThruRegistration','VerificationSource','TimeGenerated');
	$varFieldsValues = array($objRegister->doEscapeString($varPhonePin,$objRegister),$objRegister->doEscapeString($memberid,$objRegister),$objRegister->doEscapeString($iCountry,$objRegister),$objRegister->doEscapeString($iArea,$objRegister),$objRegister->doEscapeString($iPhoneNo,$objRegister),$objRegister->doEscapeString($iMobile,$objRegister),$objRegister->doEscapeString($iPhoneNumber,$objRegister),'0','1','7','NOW()');
	
	$res=$objRegister->insertOnDuplicate($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varFields,$varFieldsValues,$memberid);
	$res=fnInsertAutoClickToLog($objRegister,$memberid,$iCallNumber,$iAutoCall,$iCountry,$varAge,$varGender,$varCommunityId,$varPhonePin);
	$iTollFree = fnGetIvrNo($iCountry);
	$outputcontent = 'Y';
	if($iMobile != ""){
		$iDispNumber=$iMobile;
		$sPhonetxt='mobile';
	}else{
		$iDispNumber="$iCountry-$iArea-$iPhoneNo";
		$sPhonetxt='phone';
	}
}

if($iCountry!='44')
  $sTollCont = 'Toll Free';
else
  $sTollCont = '';


echo $outputcontent.'|~|'.$iDispNumber.'|~|'.$sPhonetxt.'|~|'.$iTollFree.'|~|'.$sTollCont .'|~|'.$varPhonePin;

?>