<?php
#====================================================================================================
# Author 			: A.Kirubasankar
# Date				: 18 Oct 2009
# Module			: Payment Assistance
# Filename			: pacron.php
# Cron Running time : Every 20 minutes
#-------------------------------------------------------------------------------------------------------
# Description :
#  This file fetches the matriids for 3D Secure Failure,Payment Failure,Payment Page Attempt and inserts
#  in the cbssupportiface.paymentoptions table.
#
#=======================================================================================================


/* Doc Base Path */
$varRootBasePath = '/home/product/community';

/* Includes */
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

/* Variable Declaration */
$varContactPhone = '';
$varContactMobile = '';
$varAreaCode = '';
$varCountryCode = '';
$domainId = 0;
$varPaymentPageResultin = '';
$varCombDetailsCond = '';
$arrCombMembersRow = array();

/* TABLE Vars*/
$varTable['ONLINEPAYMENTFAILURES'] = "onlinepaymentfailures";
$varTable['PAYMENTOPTIONSLOG'] = "paymentoptionslog";

/* DB Object Declaration */
$objPAMaster 	= new DB;
$objCommSlave	= new DB;

/* Connection vars for communitymatrimony DB */
$varDBUserName	= $varDbInfo['USERNAME'];
$varDBPassword	= $varDbInfo['PASSWORD'];

/* Connecting cbssupportiface db */
$objPAMaster	->	dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);

/* Connecting communitymatrimony db */
$objCommSlave	->	dbConnect('S',$varDbInfo['DATABASE']);

/* Domain array flip */
$arrMatriIdPre1 = array_flip($arrMatriIdPre);

threeDfailures("1");  // 3D Secure Failure Part - lead source - 1
onlinePaymentFailure("2");  // Online payment failures part - lead source - 2
paymentPageHit();  //  Payment Page hit Part - lead source - 3

function onlinePaymentFailure($leadSourceValue) {
	global $objPAMaster , $objCommSlave,$varTable,$arrMatriIdPre1;
	$PaymentFailureArgs = array("distinct(pphi.MatriId)");
	$PaymentFailureCondition1 = " AND pphi.Date_Paid >= DATE_SUB(NOW(),INTERVAL 21 MINUTE)";
	$PaymentFailureCondition = " WHERE pphi.OrderId != phi.OrderId $PaymentFailureCondition1";
	$paymentPageResult = $objCommSlave -> select("$varTable[PAYMENTHISTORYINFO] as phi , $varTable[PREPAYMENTHISTORYINFO] as  pphi",$PaymentFailureArgs,$PaymentFailureCondition,0);

	cronFetchAndUpdate($paymentPageResult,$leadSourceValue);
}

function paymentPageHit() {

	global $objPAMaster , $objCommSlave,$varTable,$arrMatriIdPre1;

	$paymentPageArgs = array('distinct(MatriId)','Source_From');
	//Lead source 3 is equivalent to Source_From 2
	$paymentPageCond = " WHERE Date_Captured >= DATE_SUB(NOW(),INTERVAL 21 MINUTE) and Source_From IN (12,11,10,9,8,7,2)";
	$paymentPageResult = $objCommSlave -> select($varTable['PREPAYMENTTRACKINFO'],$paymentPageArgs,$paymentPageCond,0);

	cronFetchAndUpdate($paymentPageResult);
}

function threeDfailures($leadSourceValue) {
	global $objPAMaster , $objCommSlave,$varTable,$arrMatriIdPre1;
	$threeDArgs = array('MatriId');
	$threeDCond = " WHERE Date_Captured >= DATE_SUB(NOW(),INTERVAL 21 MINUTE)";
	$threeDResult = $objCommSlave -> select($varTable['ONLINEPAYMENTFAILURES'],$threeDArgs,$threeDCond,0);
	cronFetchAndUpdate($threeDResult,$leadSourceValue);
}
/* Processing Function */
function cronFetchAndUpdate($paymentPageResult,$leadSourceValue="") {

	global $objPAMaster , $objCommSlave,$varTable,$arrMatriIdPre1,$arrIsdCountryCode;
	$passedLS = $leadSourceValue;

	while($paymentPageRow = mysql_fetch_assoc($paymentPageResult))	{

		$matriIdDetails = matriIdCheck($paymentPageRow['MatriId']);

		$domainId = $matriIdDetails[0]['CommunityId'];

		$varContactPhone = $matriIdDetails[0]['Contact_Phone'];
		$varContactMobile = $matriIdDetails[0]['Contact_Mobile'];

		$varAreaCode1 = explode("~",$varContactPhone);
		$varAreaCode = $varAreaCode1[1];
		if($matriIdDetails[0]['Phone_Verified'] == "1")
		{
			$assuredDetails = getAssuCont($paymentPageRow['MatriId']);
			$assuredNumber = $assuredDetails[0]['PhoneNo1'];

			if($varAreaCode == "" || $assuredDetails[0]['AreaCode'] != "") $varAreaCode = $assuredDetails[0]['AreaCode'];
			$varCountryCode = $assuredDetails[0]['CountryCode'];
		}
		if($varCountryCode == "" && strpos($varContactPhone,"~") != "")
		{
			$varContactPhone1 = explode("~",$varContactPhone);
			$varCountryCode = $varContactPhone[0];
		}
		if($varCountryCode == "" && strpos($varContactMobile,"~") != "")
		{
			$varCountryCode1 = explode("~",$varContactMobile);
			$varCountryCode = $varCountryCode1[0];
		}
		if($varCountryCode == "")
			$varCountryCode = $arrIsdCountryCode[$matriIdDetails[0]['Country']];
		if($varContactMobile != "" || $varContactPhone != "" || $assuredDetails[0]['PhoneNo1'] != "") {
			if($leadSourceValue == "")
			{
				$leadSourceValue = $paymentPageRow[Source_From];
				if($paymentPageRow[Source_From] == 2) # changing for leads 
					$leadSourceValue = 3;
			}
			$lsForLog = $leadSourceValue;
			
			$expDateDB1 = $matriIdDetails[0][Expiry_Date];
			$expDateDB2 = explode(" ",$expDateDB1); 
			$expDateDBy = explode("-",$expDateDB2[0]);
			$expDateDBh = explode(":",$expDateDB2[1]);

			$expDate = mktime($expDateDBh[0],$expDateDBh[1],$expDateDBh[2],$expDateDBy[1],$expDateDBy[2],$expDateDBy[0]);
			//$expDatePlus20Days = mktime($expDateDBh[0],$expDateDBh[1],$expDateDBh[2],$expDateDBy[1]+20,$expDateDBy[2],$expDateDBy[0])
			$currdate = mktime(date("H"),date("i"),date("s"),date('m'),date('d'),date('Y'));
			$plus20Days = mktime(date("H"),date("i"),date("s"),date('m'),date('d')+20,date('Y'));
			if($matriIdDetails[0][Paid_Status] == "0" || ($matriIdDetails[0][Paid_Status] == "1" && $currdate < $expDate && $expDate < $plus20Days))
			{
				$FAT = freshAddedTime($paymentPageRow['MatriId']);
				if($FAT != "")
				{
					$expdate=explode(" ",$FAT);

					$curdb=explode("-",$expdate[0]);
					$curhdb=explode(":",$expdate[1]);
					$curdbdate = mktime($curhdb[0],$curhdb[1],$curhdb[2],$curdb[1],$curdb[2],$curdb[0]);
					$plus24hour = mktime($curhdb[0],$curhdb[1],$curhdb[2],$curdb[1],$curdb[2]+1,$curdb[0]);

					$paLs = getLeadSource($paymentPageRow['MatriId']);
				
					if(($paLs == 1) && ($curdbdate <= $currdate) && ($currdate <= $plus24hour))
					{
						$leadSourceValue = 1;
					}
					else if(($paLs == 2) && ($curdbdate <= $currdate) && ($currdate <= $plus24hour))
					{
						$leadSourceValue = 2;
					}
					else
					{
						$leadSourceValue = $leadSourceValue;
					}

					$argFields = array('LeadSource','PaymentVisit','FreshlyAddedOn','DateUpdated');
					$argFieldsValues = array("'".$leadSourceValue."'","PaymentVisit+1","now()","now()");

					$argCondition = " MatriId = '".$paymentPageRow['MatriId']."'";
				
					$numUpdated = $objPAMaster->update($varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition);
				}
				else
				{
					$paymentPageinsertArgs = array('MatriId','CommunityId','Country','FreshlyAddedOn','LeadSource','DateUpdated','AreaCode','PhoneNo','MobileNo','CountryCode','AssuredPhoneNumber');
					$paymentPageinsertValue = array("'".$paymentPageRow['MatriId']."'","'".$domainId."'","'".$matriIdDetails[0][Country]."'","now()","$leadSourceValue","now()","'".$varAreaCode."'","'".$varContactPhone."'","'".$varContactMobile."'","'".$varCountryCode."'","'".$assuredNumber."'");

					$objPAMaster -> insert($varTable['PAYMENTOPTIONS'], $paymentPageinsertArgs, $paymentPageinsertValue);
					if(!$objPAMaster ->  clsErrorCode == "INSERT_ERR" && $objPAMaster ->  clsErrorCode == "") {
						$count++;
					}
				}
			}
		}
		if($lsForLog == "")
		{
			$subject = "Error Code = ".$objPAMaster ->  clsErrorCode." : MatriId = ".$paymentPageRow['MatriId']." : Time - ".$currdate;
			$body = $subject." : DB Lead Source - $paLs - PA lead source - $leadSourceValue";
			mail("suresh.a@bharatmatrimony.com",$subject,$body);
		}
// Paymentoptionslog entry 
$poLogArgs = array('MatriId','LeadSource','DateUpdated');
$poLogValue = array("'".$paymentPageRow['MatriId']."'","$lsForLog","now()");
$objPAMaster -> insert($varTable['PAYMENTOPTIONSLOG'], $poLogArgs, $poLogValue);

		$varContactPhone = '';
		$varContactMobile = '';
		$varAreaCode = '';
		$varCountryCode = '';
		$domainId = 0;
		if($passedLS == "") $passedLS = 0;
			$leadSourceValue = $passedLS;
		$assuredNumber = '';
	}
}

/* MatriId Checking in memberinfo */
function matriIdCheck($matriId)
{
	global $varTable,$objCommSlave;
	$args = array('Paid_Status','Country','Contact_Phone','Contact_Mobile','MatriId','CommunityId','Phone_Verified','Expiry_Date');
	$argCondition = " WHERE MatriId='$matriId'";
	//echo "<br> m num - ".$matriIdNum = $objCommSlave -> numOfRecords($varTable['MEMBERINFO'], 'MatriId', $argCondition);
	$matriIdRow = $objCommSlave -> select($varTable['MEMBERINFO'], $args, $argCondition,1);
//	echo "<br><br>Error - ".$objCommSlave -> clsErrorCode."<br><br>";
return $matriIdRow;
}

/* FreshlyAddedOn time */
function freshAddedTime($matriId)
{
	global $objCommSlave,$varTable,$varPaymentAssistanceDbInfo;
	$args = array('FreshlyAddedOn');
	$fatCond = " where matriId = '$matriId'";
	$checkResult = $objCommSlave -> select($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],$args,$fatCond,1);
return $checkResult[0][FreshlyAddedOn];
}

function getLeadSource($matriId)
{
	global $objCommSlave,$varTable,$varPaymentAssistanceDbInfo;
	$args = array('LeadSource');
	$lsCond = " where matriId = '$matriId'";
	$checkResult = $objCommSlave -> select($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],$args,$lsCond,1);
return $checkResult[0]['LeadSource'];
}
function getAssuCont($matriId)
{
	global $varTable,$objCommSlave;
	//$arrAssArgs = array('AreaCode','PhoneNo','MobileNo','CountryCode');
	$arrAssArgs = array('AreaCode','PhoneNo1','CountryCode');
	$arrAssCond = " where MatriId = '$matriId'";
	$assuRes = $objCommSlave -> select($varTable['ASSUREDCONTACT'],$arrAssArgs,$arrAssCond,1);
return $assuRes;
}
/* Log Function */



?>