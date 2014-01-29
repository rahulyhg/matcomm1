<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2009-07-15
# End Date		: 2009-07-15
# Project		: CommunityMatrimony
# Module		: Admin - Phone Verification
#=============================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//OBJECT DECLARTION
$objDB	= new MemcacheDB;

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varCurrentDate		= date('Y-m-d H:i:s');
$varMatriId			= $_REQUEST["matriId"];
$varCountryCode		= trim($_REQUEST["countryCode"]);
$varAreaCode		= trim($_REQUEST["areaCode"]);
$varPhoneNo			= trim($_REQUEST["phoneNo"]);
$varMobileNo		= trim($_REQUEST["mobileNo"]);
$varPhoneVerify		= trim($_REQUEST["phoneVerify"]);

//SETING MEMCACHE KEY
$varProfileMCKey= 'ProfileInfo_'.$varMatriId;

function getPinNo($objMasterDBConn,$phonePinTable) {

	$funQuery	= "LOCK TABLES ".$phonePinTable." WRITE";
	mysql_query($funQuery);

	$argFields			= array('PinNo');
	$argCondition		= "WHERE UsedStatus=0 LIMIT 0,1";
	$varPinInfoResultSet= $objMasterDBConn->select($phonePinTable,$argFields,$argCondition,0);
	$varPinInfoResult	= mysql_fetch_assoc($varPinInfoResultSet);

	$varPhonePinNo		= $varPinInfoResult["PinNo"];

	$argFields 			= array('UsedStatus');
	$argFieldsValues	= array(1);
	$argCondition		= " PinNo=".$varPhonePinNo;
	$varUpdateId		= $objMasterDBConn->update($phonePinTable,$argFields,$argFieldsValues,$argCondition);

	$funQuery	= "UNLOCK TABLES";
	mysql_query($funQuery);

	return $varPhonePinNo;
}


//CONTROL STATEMENT
if ($varMatriId != "" && $_POST['frmPhoneVerifySubmit']=='yes') {

	if($varAreaCode != '') { 
		$varPhoneNumber = $varCountryCode.'~'.$varAreaCode.'~'.$varPhoneNo; 
		$varPhoneNumber1 = $varPhoneNumber; 
	}

	if ($varMobileNo !='') { 
		$varMobileNumber = $varCountryCode.'~'.$varMobileNo; 
		$varPhoneNumber1 = $varMobileNumber; 
	}

	$varUpCondition		= " MatriId='".$varMatriId."'";
	$varFields			= array('Contact_Phone','Contact_Mobile','Phone_Verified');
	$varFieldsValues	= array("'".$varPhoneNumber."'","'".$varMobileNumber."'","'".$varPhoneVerify."'");
	$objDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varUpCondition,$varProfileMCKey);


	if ($varPhoneVerify==1) {
		
		//check record already available or not
		$varCondition			= " WHERE MatriId='".$varMatriId."'";
		$varCheckProfileCnt		= $objDB->numOfRecords($varTable['ASSUREDCONTACT'],'MatriId',$varCondition);

		if($varCheckProfileCnt > 0) {
			$varFields		= array('CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','DateConfirmed','VerifiedFlag','VerificationSource');
			$varFieldsValues= array("'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'".$varPhoneNumber1."'",$varPhoneVerify,"'".$varCurrentDate."'",1,2);
			$objDB->update($varTable['ASSUREDCONTACT'], $varFields, $varFieldsValues, $varUpCondition);
		} else {
			$varFields		= array('MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','DateConfirmed','VerifiedFlag','VerificationSource');
			$varFieldsValues= array("'".$varMatriId."'","'".$varCurrentDate."'","'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'".$varPhoneNumber1."'",$varPhoneVerify,"'".$varCurrentDate."'",1,2);
			$objDB->insert($varTable['ASSUREDCONTACT'],$varFields,$varFieldsValues);
		}
		
		//check record already available or not
		$varCondition	= " WHERE MatriId='".$varMatriId."'";
		$varCheckCnt	= $objDB->numOfRecords($varTable['ASSUREDCONTACTBEFOREVALIDATION'],'MatriId',$varCondition);
	
		if($varCheckCnt==1) {
			//DELETE BEFORE VALIDATION TBALE
			$objDB->delete($varTable['ASSUREDCONTACTBEFOREVALIDATION'], $varUpCondition);
		}

		//verified phone stored in text file for ability matrimony
		$varMatriIdPrefix	= strtoupper(substr($varMatriId, 0, 3));
		if($varMatriIdPrefix=='ABL') {
			//INSERT INTO MASTER TABLE
			$argFields			= array('MatriId','PhoneNo1','DateConfirmed');
			$argFieldsValues	= array("'".$varMatriId."'","'".$varPhoneNumber1."'","'".$varCurrentDate."'");
			$varInsertId		= $objDB->insert($varTable['PHONEVERIFIED_DETAILS'],$argFields,$argFieldsValues);
		}
	} else if ($varPhoneVerify==0) {
		//check record already available or not
		$varCondition			= " WHERE MatriId='".$varMatriId."'";
		$varCheckProfileCnt		= $objDB->numOfRecords($varTable['ASSUREDCONTACTBEFOREVALIDATION'],'MatriId',$varCondition);

		if($varCheckProfileCnt > 0) {
			$varFields		= array('CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','DateConfirmed','VerifiedFlag','VerificationSource');
			$varFieldsValues= array("'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'".$varPhoneNumber1."'",$varPhoneVerify,"''",0,0);
			$objDB->update($varTable['ASSUREDCONTACTBEFOREVALIDATION'], $varFields, $varFieldsValues, $varUpCondition);
		} else {
			$varPinNo		= getPinNo($objDB,$varTable['ASSUREDCONTACTPINNOSERIES']);

			$varFields		= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','DateConfirmed','VerifiedFlag','VerificationSource');
			$varFieldsValues= array("'".$varPinNo."'","'".$varMatriId."'","'".$varCurrentDate."'","'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'".$varPhoneNumber1."'",$varPhoneVerify,"''",0,0);
			$objDB->insert($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varFields,$varFieldsValues);
		}
	}

}//if

//UNSET OBJECT
$objDB->dbClose();
unset($objDB);
?>
<table border='0' cellpadding='0' cellspacing='0' width="540" align="left">
	<tr><td class="heading">Phone Verification</td></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' class="formborderclr" width="540">
				<tr><td height="10" class="smalltxt">&nbsp;&nbsp;&nbsp;Phone number has been updated successfully.</td></tr>
				<tr><td height="10" colspan='5'></td></tr>
			</table>
		</td>
	</tr>
</table>