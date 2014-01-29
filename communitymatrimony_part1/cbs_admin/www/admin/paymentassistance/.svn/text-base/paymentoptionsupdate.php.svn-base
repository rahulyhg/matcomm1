<?php
/***************************************************************************************************** 
	File Name	: paymentoptionupdatee.php(cron file)
	Location	: Payment Assistance
	Author		: A.Kirubasankar
	Created on	: 1-11-2009
	Description : Used to update the support db by domainwise eveey 6 minites
****************************************************************************************************/
/*
include_once("/home/office/bmconf/bminit.inc");
include_once("/home/office/bmconf/bmip.inc");
include_once("/home/office/bmconf/bmdbinfo.inc");
include_once("/home/office/bmconf/bmvars.inc");
include_once("/home/office/bmlib/bmsqlclass.inc");
include_once("/home/office/support/www/includes/bmsupportdbinfo.inc");
include_once("/home/office/support/www/includes/common_vars.php");
include_once("/home/office/support/cron/supportrenewal.php");
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


$dateChk=date('G:i');
if(($dateChk>='2:00') &&($dateChk <='2:07'))
	$curTime = strtotime(date("Y-m-d H:i:s")) - (1*60*60);
else if(($dateChk>='5:00') &&( $dateChk <='5:07'))
	$curTime = strtotime(date("Y-m-d H:i:s")) - (3*60*60);
else
	$curTime = strtotime(date("Y-m-d H:i:s")) - (6*60);

$datetime = date("Y-m-d H:i:s", $curTime);


/*
$dbmaster14 = new db();
foreach($GLOBALS['DOMAINNAME'] as $domain=>$domainlang) {
*/
/*
#support interface connection 
if(!$dbmaster14->ping()) {
$dbmaster14->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['SUPPORTINTERFACE']);
} else {
$dbmaster14->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['SUPPORTINTERFACE']);
}

#domain wise conncetion
$dbslave = new db();
$dbslave->dbConnById(1,$domain,"S",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);

*/
$args = array('MatriId','Country','LeadSource','OptionSelected','PackageSelected','ProductId','DateSelected','PaymentDate','FollowupStatus','LeadSource','PhoneCountryCode','CountryCode','AreaCode','PhoneNo','MobileNo','EntryType');

$argCondition = " WHERE DateSelected >= '".$datetime."' or PaymentDate >= '".$datetime."'";

$payoptNum = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition);
if($objSlave ->  clsErrorCode == "CNT_ERR") exit;
if($payoptNum > 0)
{
	$payoptResult = $objSlave -> select($varTable['PAYMENTOPTIONS'],$args,$argCondition,0);
	if($objSlaveMatri ->  clsErrorCode == "SELECT_ERR")	exit;

	while($payoptRow = mysql_fetch_assoc($payoptResult))
	{
		$leadsource = '';
		if(matriidcheck($payoptRow['MatriId']))
		{
			//echo "<br>".$payoptRow['MatriId']." : ".$payoptRow['FollowupStatus']." : ".$payoptRow['LeadSource']." : ".$payoptRow['EntryType'];
			
			$args = array('MatriId','Contact_Mobile','Contact_Phone','Residing_Area','Last_Payment');

			$argCondition = " WHERE MatriId='".$payoptRow['MatriId']."'";

			if($memdetailsResult = $objSlaveMatri -> select($varTable['MEMBERINFO'],$args,$argCondition,0))
			{
				$memdetailsRow = mysql_fetch_assoc($memdetailsResult);
				//print_r($memdetailsRow);
			}

			$deteUpdate = '';
			$expdate = explode(" ",$payoptRow['DateSelected']);
			$curdb = explode("-",$expdate[0]);
			$curhdb = explode(":",$expdate[1]);
			$curdbdate = mktime($curhdb[0],$curhdb[1],$curhdb[2],$curdb[1],$curdb[2],$curdb[0]);
			$plus24hour = mktime($curhdb[0],$curhdb[1],$curhdb[2],$curdb[1]+1,$curdb[2],$curdb[0]);
			$currdate = mktime(0,0,0,date('m'),date('d'),date('Y'));

			if(($payoptRow['LeadSource']=='4') && ($currdate >= $curdbdate) && ($currdate <= $plus24hour))
			{
				$leadsource = '4';
			} 
			else if(($payoptRow['LeadSource']=='11') && ($currdate >= $curdbdate) && ($currdate <= $plus24hour))
			{
				$leadsource = '11';
			}
			else
			{
				$leadsource = $payoptRow['LeadSource'];
			}
			if($leadsource == "" or $leadsource == "0")
			{
				if($row['OptionSelected'] == 0 && $row['PackageSelected'] == 0)
				{
					$leadsource=5;
				}
			}
//			echo " Lead source - ".$leadsource;
			//echo " - Entry - ".$row['EntryType'];
			if($payoptRow['EntryType'] == '0')
			{
				//inserting here
				//$insetdomain="insert into ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTION']." (MatriId,Country,PhoneCountryCode,CountryCode,AreaCode,PhoneNo,MobileNo,OptionSelected,PackageSelected,PowerPack,DateSelected,ProductId,PaymentDate,RenewalFlag,LeadSource,Language) values ('".$row['MatriId']."','".$row['Country']."','".$contactRow['PhoneCountryCode']."','".$contactRow['CountryCode']."','".$contactRow['AreaCode']."','".$contactRow['PhoneNo']."','".$contactRow['MobileNo']."','".$row['OptionSelected']."','".$row['PackageSelected']."','".$row['PowerPack']."','".$row['DateSelected']."','".$row['ProductId']."','".$row['PaymentDate']."','".$row['RenewalFlag']."','".$leadsource."','".$domain."') ON DUPLICATE KEY UPDATE Country='".$row['Country']."',CountryCode='".$contactRow['CountryCode']."',PhoneCountryCode='".$contactRow['PhoneCountryCode']."',AreaCode='".$contactRow['AreaCode']."',PhoneNo='".$contactRow['PhoneNo']."',MobileNo='".$contactRow['MobileNo']."',OptionSelected='".$row['OptionSelected']."',PackageSelected='".$row['PackageSelected']."',PowerPack='".$row['PowerPack']."',ProductId='".$row['ProductId']."',PaymentDate='".$row['PaymentDate']."',RenewalFlag='".$row['RenewalFlag']."',LeadSource='".$leadsource."',PaymentVisit=(PaymentVisit+1)".$deteUpdate."";
				
				$insertdomain = "insert into ".$varTable['PAYMENTOPTIONS']." (MatriId,Country,PhoneCountryCode,CountryCode,AreaCode,PhoneNo,MobileNo,OptionSelected,PackageSelected,DateSelected,ProductId,PaymentDate,LeadSource) values ('".$payoptRow['MatriId']."','".$payoptRow['Country']."','".$payoptRow['PhoneCountryCode']."','".$payoptRow['CountryCode']."','".$memdetailsRow['Residing_Area']."','".$memdetailsRow['Contact_Phone']."','".$memdetailsRow['Contact_Mobile']."','".$payoptRow['OptionSelected']."','".$payoptRow['PackageSelected']."','".$payoptRow['DateSelected']."','".$payoptRow['ProductId']."','".$payoptRow['PaymentDate']."','".$leadsource."') ON DUPLICATE KEY UPDATE MatriId = '".$payoptRow['MatriId']."', Country='".$payoptRow['Country']."',CountryCode='".$payoptRow['CountryCode']."',PhoneCountryCode='".$payoptRow['PhoneCountryCode']."',AreaCode='".$memdetailsRow['Residing_Area']."',PhoneNo='".$memdetailsRow['Contact_Phone']."',MobileNo='".$memdetailsRow['Contact_Mobile']."',OptionSelected='".$payoptRow['OptionSelected']."',PackageSelected='".$payoptRow['PackageSelected']."',ProductId='".$payoptRow['ProductId']."',PaymentDate='".$payoptRow['PaymentDate']."',LeadSource='".$leadsource."',PaymentVisit=(PaymentVisit+1)".$deteUpdate."";
				mysql_query($insertdomain);				

				/*
				$argFields = array('MatriId','Country','PhoneCountryCode','CountryCode','AreaCode','PhoneNo','MobileNo','OptionSelected','PackageSelected','DateSelected','ProductId','PaymentDate','LeadSource');
				$argFieldsValue = array("'".$row['MatriId']."'","'".$row['Country']."'","'".$contactRow['PhoneCountryCode']."'","'".$contactRow['CountryCode']."'","'".$contactRow['AreaCode']."'","'".$contactRow['PhoneNo']."'","'".$contactRow['MobileNo']."'","'".$row['OptionSelected']."'","'".$row['PackageSelected']."'","'".$row['DateSelected']."'","'".$row['ProductId']."'","'".$row['PaymentDate']."'","'".$leadsource."'");

				$objMaster -> insertOnDuplicate($varTable['PAYMENTOPTIONS'], $argFields, $argFieldsValue, 'MatriId');
				*/

			}
			else
			{
				//$updateent="update ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTION']." set PaymentDate='".$rowms['LastPayment']."',PaymentVisit=PaymentVisit+1 where MatriId='".$row['MatriId']."'";

				$argFields = array('PaymentDate','PaymentVisit');
				$argFieldsValue = array("'".$memdetailsRow['Last_Payment']."'","'PaymentVisit+1'");

				$argCondition = " MatriId = '".$row['MatriId']."'";
				if(!$objMaster -> update($varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition))
					echo "Error ";
				else
					echo "ok";

			}
		}
	}
}
/*
$dbquery="select * from ".$DBNAME['MATRIMONY'].".".$domainlang.$TABLE['PAYMENTOPTION']." where (DateSelected>='".$datetime."' or PaymentDate>='".$datetime."')"; 
$rowcount=$dbslave->select($dbquery);
#$msg.=$domainlang."=".$rowcount."\n";
if($rowcount>0) {
$getres=$dbslave->getResultArray();

foreach($getres as $row){
if(matriidcheck($row['MatriId'])) {
$leadsource='';

#check telecaller status
$selectCheck="select MatriId,FollowupStatus,LeadSource,DateSelected from ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTION']." where MatriId='".$row['MatriId']."'";
$rowpayCheck=$dbmaster14->select($selectCheck);
if($rowpayCheck=='1') {

$telCheck=$dbmaster14->fetchArray();
if($telCheck['FollowupStatus']=='2'  || $telCheck['FollowupStatus']=='3' || $telCheck['FollowupStatus']=='6') {
#$deteUpdate="DateSelected=now(),";
$deteUpdate='';
} else { $deteUpdate=''; }

$expdate=explode(" ",$telCheck['DateSelected']);
$curdb=explode("-",$expdate[0]);
$curhdb=explode(":",$expdate[1]);
$curdbdate=mktime($curhdb[0],$curhdb[1],$curhdb[2],$curdb[1],$curdb[2],$curdb[0]);
$plus24hour=mktime($curhdb[0],$curhdb[1],$curhdb[2],$curdb[1]+1,$curdb[2],$curdb[0]);
$currdate=mktime(0,0,0,date('m'),date('d'),date('Y'));

if(($telCheck['LeadSource']=='4') && ($currdate>=$curdbdate) && ($currdate<=$plus24hour)) {
$leadsource='4';
} 
else if(($telCheck['LeadSource']=='11') && ($currdate>=$curdbdate) && ($currdate<=$plus24hour)) {
$leadsource='11';
}
else {
$leadsource=$row['LeadSource'];
}
}
#update leadsource when optionselected and paymentselected was null or zero
if($leadsource=="" or $leadsource=="0") {
if($row['OptionSelected']==0 && $row['PackageSelected']==0) {
	$leadsource=5;
}
}

#get contact info details
$contactQuery="select PhoneCountryCode,CountryCode,AreaCode,PhoneNo,MobileNo from ".$DBNAME['MATRIMONYMS'].".".$TABLE['CONTACTINFO']." where MatriId='".$row['MatriId']."'";
$dbslave->select($contactQuery);
$contactRow=$dbslave->fetchArray();

#get entry type and last payment
$selectms="select Language,EntryType,CountrySelected,LastPayment,ExpiryDate from ".$DBNAME['MATRIMONYMS'].".".$TABLE['MATRIMONYPROFILE']." where MatriId='".$row['MatriId']."'";
$rowcount=$dbmaster14->select($selectms);
$rowms=$dbmaster14->fetchArray();

if($rowms['EntryType']=='F') {

$insetdomain="insert into ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTION']." (MatriId,Country,PhoneCountryCode,CountryCode,AreaCode,PhoneNo,MobileNo,OptionSelected,PackageSelected,PowerPack,DateSelected,ProductId,PaymentDate,RenewalFlag,LeadSource,Language) values ('".$row['MatriId']."','".$row['Country']."','".$contactRow['PhoneCountryCode']."','".$contactRow['CountryCode']."','".$contactRow['AreaCode']."','".$contactRow['PhoneNo']."','".$contactRow['MobileNo']."','".$row['OptionSelected']."','".$row['PackageSelected']."','".$row['PowerPack']."','".$row['DateSelected']."','".$row['ProductId']."','".$row['PaymentDate']."','".$row['RenewalFlag']."','".$leadsource."','".$domain."') ON DUPLICATE KEY UPDATE Country='".$row['Country']."',CountryCode='".$contactRow['CountryCode']."',PhoneCountryCode='".$contactRow['PhoneCountryCode']."',AreaCode='".$contactRow['AreaCode']."',PhoneNo='".$contactRow['PhoneNo']."',MobileNo='".$contactRow['MobileNo']."',OptionSelected='".$row['OptionSelected']."',PackageSelected='".$row['PackageSelected']."',PowerPack='".$row['PowerPack']."',ProductId='".$row['ProductId']."',PaymentDate='".$row['PaymentDate']."',RenewalFlag='".$row['RenewalFlag']."',LeadSource='".$leadsource."',PaymentVisit=(PaymentVisit+1)".$deteUpdate."";
$dbmaster14->insert($insetdomain);
// mail("asureshmca@gmail.com","paymentoptionsupdate.php",$insetdomain);
} else {
$updateent="update ".$DBNAME['SUPPORTINTERFACE'].".".$TABLE['PAYMENTOPTION']." set PaymentDate='".$rowms['LastPayment']."',PaymentVisit=PaymentVisit+1 where MatriId='".$row['MatriId']."'";
$dbmaster14->update($updateent);
}
renwalupdate($row['MatriId'],$rowms['EntryType'],$rowms['ExpiryDate'],$row['LeadSource'],$dbmaster14);
			}
		}
	}
}
*/
#echo $msg;
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

?>
