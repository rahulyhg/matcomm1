<?
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-04
# Project	  : MatrimonyProduct
# Filename	  : phoneauthendicate.php
#=====================================================================================================================================
# Description : this file called from IVRS
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
//include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/lib/clsAdminValMailer.php");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsDB.php');

//GETTING VARIABLE FROM IVRS
$varPinNo	= trim($_REQUEST['PIN']);
$varPhoneNo	= urldecode($_REQUEST['PHONE']);
//$varPinNo	= '100002';
//$varPhoneNo	= '22478978';

//OBJECT DECLARTION
$objDBSlave		= new DB;
$objDBMaster	= new MemcacheDB;
$objAdminMailer	= new AdminValid;

//VARIABLE DECLARATION
$varDateTime	= date("Y-m-d H:i:s");

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

function showXMLOutput($dispMsg) {
	return "<?xml version='1.0' encoding='UTF-8'?><pinphonevalidation><response>".$dispMsg."</response></pinphonevalidation>";
}

if (!empty($_REQUEST['PHONE'])) {  # check if GET or POST
 $varPinNo		= trim($_REQUEST['PIN']);
 $varPhoneNo	= urldecode($_REQUEST['PHONE']);
 
 # Need to strip quotes in the phone number
 $matchPattern	= '/[\"|\'][0-9]+[\"|\']/'; # regexp to match phone numbers inside double or single quotes
 $isMatched		= preg_match($matchPattern, $varPhoneNo, $matches);
 if($isMatched>0) {  # if the phone number contains quotes
  $varPhoneNo		= $matches[0];
  $pattern[0]		= '/\"/';
  $replacement[0]	= '';
  $pattern[1]		= '/\'/';
  $replacement[1]	= '';
  $varPhoneNo		= preg_replace($pattern, $replacement, $varPhoneNo); # remove the quotes
 }
 
 $varPhoneNo	= ltrim($varPhoneNo, "0");  # Remove if first character is 0
 $varSubStrPhNo = substr($varPhoneNo,-6,6);
}

//CHECK DB HAS CONNECT OR NOT
if($objDBSlave->clsErrorCode != '') {
	echo showXMLOutput('FAILURE');
	exit;
}

//CHECK Pin & Phone no has come thru IVRS
if($varPinNo == '' || $varPhoneNo == '') {
	 echo showXMLOutput('FAILURE');
	 exit;
}


//CHECK PHONE NO IS CORRECT OR NOT
$argCondition	= "WHERE PhoneNo1 LIKE '%".$varSubStrPhNo."'";
$argFields		= array('PinNo','MatriId','PhoneNo1');
//echo $varTable['ASSUREDCONTACTBEFOREVALIDATION'].'-----'.$argCondition.'<br>';
//print_r($argFields);
$varPhoneInfoResultSet= $objDBSlave->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argCondition,1);

$chkPin			= false;
foreach($varPhoneInfoResultSet as $k=>$v) {
	
	if($varPhoneInfoResultSet[$k]['PinNo']==$varPinNo) {
		$varMatriId	= $varPhoneInfoResultSet[$k]['MatriId'];
		$chkPin		= true;
		break;
	}
}

//if($varContactInfoResultSet[0]['MatriId'] == '') {
if(sizeof($varPhoneInfoResultSet) == 0) {
	echo showXMLOutput('FAILURE');
	exit;
} else {
	if(!$chkPin) {
		echo showXMLOutput('PIN FAILURE');
		exit;
	} else {
		//CONNECT DATABASE
		$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

		//CHECK DB HAS CONNECT OR NOT
		if($objDBMaster->clsErrorCode != '') {
			echo showXMLOutput('FAILURE');
			exit;
		}

		//GET VALUES FROM BEFOREVALIDATION TABLE
		$argFields				= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','ContactPerson1','Relationship1','Timetocall1','Description','VerificationSource','ThruRegistration');
		//$argCondition			= "WHERE PinNo='".$varPinNo."' AND PhoneNo1='".$varPhoneNo."'";
		$argCondition			= "WHERE MatriId=".$objDBSlave->doEscapeString($varMatriId,$objDBSlave);
		$varContactInfoResultSet= $objDBSlave->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argCondition,0);
		$varContactInfoResult	= mysql_fetch_assoc($varContactInfoResultSet);

		$varTimeGenerated		= $varContactInfoResult['TimeGenerated'];
		$varCountryCode			= $varContactInfoResult['CountryCode'];
		$varAreaCode			= $varContactInfoResult['AreaCode'];
		$varPhoneNo				= $varContactInfoResult['PhoneNo'];
		$varMobileNo			= $varContactInfoResult['MobileNo'];
		$varSelectedPhoneNo		= $varContactInfoResult['PhoneNo1'];
		$varPhoneStatus			= 1;
		$varContactPerson		= $varContactInfoResult['ContactPerson1'];
		$varRelationship		= $varContactInfoResult['Relationship1'];
		$varTimetocall			= $varContactInfoResult['Timetocall1'];
		$varDescription			= $varContactInfoResult['Description'];
		$varThruRegistration	= $varContactInfoResult['ThruRegistration'];
		$varVerificationSource	= 1; //thru IVRS
		

		//CHECK MASTER TABLE ENTRY IS THERE OR NOT
		$argCondition	= "WHERE MatriId=".$objDBSlave->doEscapeString($varMatriId,$objDBSlave);
		$varRecordAvail	= $objDBSlave->numOfRecords($varTable['ASSUREDCONTACT'],'MatriId',$argCondition);

		if($varRecordAvail == 1) {
			//UPDATE INTO MASTER TABLE
			$argFields 			= array('PinNo','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ContactPerson1','Relationship1','Timetocall1','DateConfirmed','Description','VerificationSource','ThruRegistration');
			$argFieldsValues	= array($objDBMaster->doEscapeString($varPinNo,$objDBMaster),"'".$varTimeGenerated."'","'".$varCountryCode."'","'".$varAreaCode."'",$objDBMaster->doEscapeString($varPhoneNo,$objDBMaster),"'".$varMobileNo."'","'".$varSelectedPhoneNo."'","'".$varPhoneStatus."'","'".$varContactPerson."'","'".$varRelationship."'","'".$varTimetocall."'","'".$varDateTime."'","'".$varDescription."'","'".$varVerificationSource."'","'".$varThruRegistration."'");
			$argCondition		= " MatriId = ".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varInsertId		= $objDBMaster->update($varTable['ASSUREDCONTACT'],$argFields,$argFieldsValues,$argCondition);
		} else {
			//INSERT INTO MASTER TABLE
			$argFields			= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ContactPerson1','Relationship1','Timetocall1','DateConfirmed','VerifiedFlag','Description','VerificationSource','ThruRegistration');
			$argFieldsValues	= array($objDBMaster->doEscapeString($varPinNo,$objDBMaster),$objDBMaster->doEscapeString($varMatriId,$objDBMaster),"'".$varTimeGenerated."'","'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'".$varSelectedPhoneNo."'","'".$varPhoneStatus."'","'".$varContactPerson."'","'".$varRelationship."'","'".$varTimetocall."'","'".$varDateTime."'","'".$varVerifiedFlag."'","'".$varDescription."'","'".$varVerificationSource."'","'".$varThruRegistration."'");
			$varInsertId		= $objDBMaster->insert($varTable['ASSUREDCONTACT'],$argFields,$argFieldsValues);
		}

		if($varInsertId >= 0) {
			echo showXMLOutput('SUCCESS');

			//DELETE FROM Temporary table (assuredcontactbeforevalidation)
			$argCondition	= "MatriId=".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varDeleteId	= $objDBMaster->delete($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argCondition);

			//UPDATE UsedStatus=0 IN assuredcontactpinnoseries table
			if($varDeleteId > 0) {
				$argFields 		= array('UsedStatus');
				$argFieldsValues= array(0);
				$argCondition	= "PinNo=".$objDBMaster->doEscapeString($varPinNo,$objDBMaster);
				$varUpdateId	= $objDBMaster->update($varTable['ASSUREDCONTACTPINNOSERIES'],$argFields,$argFieldsValues,$argCondition);
			}

			
			//SETING MEMCACHE KEY
			$varOwnProfileMCKey		= 'ProfileInfo_'.$varMatriId;

			//UPDATE INTO memberinfo table
			$argFields 		= array('Phone_Verified','Date_Updated');
			$argFieldsValues= array(1,"NOW()");
			$argCondition	= "MatriId=".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			
			//Request added intimation to user
			$objAdminMailer->dbConnect('M', $varDbInfo['DATABASE']);
			$objAdminMailer->requestAdded($varMatriId,3);

			//verified phone stored in text file for ability matrimony
			$varMatriIdPrefix	= strtoupper(substr($varMatriId, 0, 3));
			if($varMatriIdPrefix=='ABL') {
				//INSERT INTO MASTER TABLE
				$argFields			= array('MatriId','PhoneNo1','DateConfirmed');
				$argFieldsValues	= array($objDBMaster->doEscapeString($varMatriId,$objDBMaster),"'".$varSelectedPhoneNo."'","'".$varDateTime."'");
				$varInsertId		= $objDBMaster->insert($varTable['PHONEVERIFIED_DETAILS'],$argFields,$argFieldsValues);
			}
		} else {
			echo showXMLOutput('FAILURE');
			exit;
		}
	}
}

?>