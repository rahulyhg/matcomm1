<?php
/***************************************************************************************************** 
	File Name : onlinepaymentfailerupdate.php(cron file)
	Location : supportinterface
	Author : A.Anbalagan
	Created on : 09-12-2008
	rework on :02-04-2009
	Description : Used to update the support db by domainwise eveey 11 minites
****************************************************************************************************/
/*
include_once("/home/office/bmconf/bminit.inc");
include_once("/home/office/bmconf/bmip.inc");
include_once("/home/office/bmconf/bmdbinfo.inc");
include_once("/home/office/bmconf/bmvars.inc");
include_once("/home/office/bmlib/bmsqlclass.inc");
include_once("/home/office/support/www/includes/bmsupportdbinfo.inc");
include_once("/home/office/support/www/includes/common_vars.php");
include_once("/home/office/telemarketing/www/bmfunctions/telemarkinc.php");
include_once("/home/office/support/cron/supportrenewal.php");
//$fms= date("h:i",time());
//mail("suresh.a@bharatmatrimony.com","onlinepaymentfailerupdate.php-starts",$fms);
*/

//BASE PATH
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/payment.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/conf/vars.inc');

//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new DB;
$objSlaveMatri = new DB;

//Connecting communitymatrimony db
$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);

global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];

//Conecting cbssupportiface db
$objSlave -> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
$masterconn = $objMaster -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);

$varTable['ONLINEPAYMENTFAILURES'] = "onlinepaymentfailures";


$curTime = strtotime(date("Y-m-d H:i:s")) -(5*60);
$datetime = date("Y-m-d H:i:s", $curTime);

/*
$dbmaster14 = new db();
$dbmaster14->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['SUPPORTINTERFACE']);
$IPVARS=$DBCONIP['DB6'].":3307";

$dbslave = new db();
$dbslave->connect($IPVARS,$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['BMPAYMENT']);

if(!$dbslave->ping()) {
$msg="onlinepaymentfailerupdate.php";
mail("anbalagan@bharatmatrimony.com","DB Connection Error",$msg);
}
*/

$args = array('PhoneNo','PaymentGateway','PaymentSource','3dSecureFailure','Date_Captured','MatriId');
$argCondition = " where Date_Captured >= '".$datetime."'";

$failResult = $objSlaveMatri -> select($varTable['ONLINEPAYMENTFAILURES'],$args,$argCondition,0);
if($objSlaveMatri ->  clsErrorCode == "SELECT_ERR")	echo "error";
else
{

	while($failRow = mysql_fetch_assoc($failResult))
	{
		//echo "<br> Matriid - ".$failRow['MatriId'];
		if(matriidcheck($failRow['MatriId']))
		{
			if($failRow['3dSecureFailure'] == 1)
				$newLeadSource = 11;
			else
				$newLeadSource = 4;

		//	CountryCode,PhoneCountryCode,AreaCode,PhoneNo,MobileNo
		//		CountrySelected,EntryType,LastPayment,Language,ExpiryDate
			
			$args = array('Residing_Area','Contact_Phone','Contact_Mobile','Last_Payment','Expiry_Date');
			//'EntryType',
			$argCondition = " where matriId = '".$failRow['MatriId']."'";
//'CountryCode','PhoneCountryCode','CountrySelected',,'Language'

			$failResult1 = $objSlaveMatri -> select($varTable['MEMBERINFO'],$args,$argCondition,0);
			if($objSlaveMatri ->  clsErrorCode == "SELECT_ERR")	echo "error";
			else
			{
				$failRow1 = mysql_fetch_assoc($failResult1);
				//$args = array('CountryCode','PhoneCountryCode','CountrySelected','Language','EntryType');
				$args = array('CountryCode','PhoneCountryCode','Language','EntryType');
				//'EntryType',
				$argCondition = " where matriId = '".$failRow['MatriId']."'";

				$failResultDetailsQuery = $objSlave -> select($varTable['PAYMENTOPTIONS'],$args,$argCondition,0);
			
				if($objSlave ->  clsErrorCode == "SELECT_ERR")	echo "error";
				else
				{
					$failResultDetails = mysql_fetch_assoc($failResultDetailsQuery);

					$insetdomain = "insert into ".$varTable['PAYMENTOPTIONS']." (MatriId,CountryCode,PhoneCountryCode,AreaCode,PhoneNo,MobileNo,DateSelected,LeadSource,Language,PaymentFailurePhoneNo,PaymentFailureFlag) values ('".$failRow['MatriId']."','".$failResultDetails['CountryCode']."','".$failResultDetails['PhoneCountryCode']."','".$failRow1['Residing_Area']."','".$failRow1['Contact_Phone']."','".$failRow1['Contact_Mobile']."','".$failRow['Date_Captured']."','".$newLeadSource."','".$failResultDetails['Language']."','".$failRow1['Contact_Phone']."',1) ON DUPLICATE KEY UPDATE Country='".$failResultDetails['CountryCode']."',CountryCode='".$failResultDetails['CountryCode']."',PhoneCountryCode='".$failResultDetails['PhoneCountryCode']."',AreaCode='".$failRow1['Residing_Area']."',PhoneNo='".$failRow1['Contact_Phone']."',MobileNo='".$failRow1['Contact_Mobile']."',LeadSource='".$newLeadSource."',PaymentVisit=(PaymentVisit+1),PaymentDate='0000-00-00 00:00:00',DateSelected=now(),LockTime='0000-00-00 00:00:00',DateUpdated='0000-00-00 00:00:00',SupportUserName='',Comments='',FollowupDate='0000-00-00 00:00:00',FollowupStatus=0,PaymentFailurePhoneNo='".$failRow1['Contact_Phone']."',PaymentFailureFlag=1";

					mysql_query($insetdomain);

				}
			}
		}
		else
			echo "In-Valid id";
	}
}
//renwalupdate($row['MatriId'],$countyRow['EntryType'],$countyRow['ExpiryDate'],$newLeadSource,$dbmaster14);
renwalupdate($failRow['MatriId'],$countyRow['EntryType'],$failRow['Expiry_Date'],$newLeadSource);

/*
$dbquery="select * from ".$DBNAME['BMPAYMENT'].".".$TABLE['ONLINEPAYMENTFAILURES']." where DateCaptured>='".$datetime."'"; 
$rowcount=$dbslave->select($dbquery);
*/
/*
if($rowcount>0) {
$getres=$dbslave->getResultArray();


foreach($getres as $row){
if(matriidcheck($row['MatriId'])) {


if($row['3dSecureFailure']==1){
$newLeadSource=11;
} else {
$newLeadSource=4;
}

#contact info datas
$dbslave = new db();
$dbslave->dbConnById(2,$row['MatriId'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
$contactQuery="select CountryCode,PhoneCountryCode,AreaCode,PhoneNo,MobileNo from ".$DBNAME['MATRIMONYMS'].".".$TABLE['CONTACTINFO']." where MatriId='".$row['MatriId']."'";
$dbslave->select($contactQuery);
$contactRow=$dbslave->fetchArray();

#Country code datas
$countrysel="select CountrySelected,EntryType,LastPayment,Language,ExpiryDate from ".$DBNAME['MATRIMONYMS'].".".$TABLE['MATRIMONYPROFILE']." where MatriId='".$row['MatriId']."'";

$dbmaster14->select($countrysel);
$countyRow=$dbmaster14->fetchArray();

$insetdomain="insert into ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTION']." (MatriId,Country,CountryCode,PhoneCountryCode,AreaCode,PhoneNo,MobileNo,DateSelected,LeadSource,Language,PaymentFailurePhoneNo,PaymentFailureFlag) values ('".$row['MatriId']."','".$countyRow['CountrySelected']."','".$contactRow['CountryCode']."','".$contactRow['PhoneCountryCode']."','".$contactRow['AreaCode']."','".$contactRow['PhoneNo']."','".$contactRow['MobileNo']."','".$row['DateCaptured']."','".$newLeadSource."','".$countyRow['Language']."','".$row['PhoneNo']."',1) ON DUPLICATE KEY UPDATE Country='".$countyRow['CountrySelected']."',CountryCode='".$contactRow['CountryCode']."',PhoneCountryCode='".$contactRow['PhoneCountryCode']."',AreaCode='".$contactRow['AreaCode']."',PhoneNo='".$contactRow['PhoneNo']."',MobileNo='".$contactRow['MobileNo']."',LeadSource='".$newLeadSource."',PaymentVisit=(PaymentVisit+1),PaymentDate='0000-00-00 00:00:00',DateSelected=now(),LockTime='0000-00-00 00:00:00',DateUpdated='0000-00-00 00:00:00',SupportUserId='',SupportUserName='',Comments='',FollowupDate='0000-00-00 00:00:00',FollowupStatus=0,PaymentFailurePhoneNo='".$row['PhoneNo']."',PaymentFailureFlag=1";

$dbmaster14->insert($insetdomain);
//mail("asureshmca@gmail.com","onlinepaymentfailerupdate.php",$insetdomain);
renwalupdate($row['MatriId'],$countyRow['EntryType'],$countyRow['ExpiryDate'],$newLeadSource,$dbmaster14);		
	}

}
}
*/
#check matriid(Valid or In Valid)--------------------------------
function matriidcheck($mid)
{
	global $arrMatriIdPre;
	if($mid != "")
	{
		$first3 = substr($mid,0,3);
		$afterfist3 = substr($mid, 3);
		if (in_array($first3, $arrMatriIdPre))
		{
			if(is_numeric($afterfist3))
				return true;
			else
				return false; 
		}
		else { return false;  }
	}
	else
		return false;
}
#------------------------------------------
function renwalupdate($upMatriId,$entryType,$expiryDate,$leadSource,$db)
{
	global $DBNAME,$TABLE;
	#insert the data to log table
	$TABLE['PAYMENTOPTIONLOG']="paymentoptionslog";
	$logInsert="insert into ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTIONLOG']." (MatriId,LeadSource,DateUpdated) values('".$upMatriId."','".$leadSource."',now())";
	$db->insert($logInsert);

	$curTime = date("Y-m-d H:i:s");
	$days = (strtotime($expiryDate) - strtotime($curTime)) / (60 * 60 * 24);
	if($entryType=='F' or ($entryType='R' and $days<=15)) {
	$updatePayDate="update ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTION']."  set PaymentDate='0000-00-00 00:00:00' where MatriId='".$upMatriId."'";
	//mail("asureshmca@gmail.com","supportrenewal.php",$updatePayDate);
	$db->update($updatePayDate);
	}
}
// $sms= date("h:i",time());
//mail("suresh.a@bharatmatrimony.com","onlinepaymentfailerupdate.php-ends",$sms);

?>
