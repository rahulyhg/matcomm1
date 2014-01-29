<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 15 Dec 2009
# Module		: Payment Assistance
# Description   : Payment Assistance Update via Chat - To be used through cURL from CBS CRM.

#1 id does not exist
#2 Sucessfully inserted
#3 already in exist in db
#4 payment Already Done
#====================================================================================================

//BASE PATH
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/conf/vars.inc');



//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new DB;

//Conecting cbssupportiface db
$objSlave-> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
$objMaster-> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);

function decrypt($string, $key)
{
	$result = '';
	$string = base64_decode($string);

	for($i=0; $i<strlen($string); $i++)
	{
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}
function db_spl_chars_encode($str)
{
	return htmlentities($str);
}
function db_escape_quotes($value)
{
	$value = db_spl_chars_encode($value);
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	if (!is_numeric($value))
	{
		$value = mysql_real_escape_string($value);
	}
return trim($value); 
}

//$ipArrays = array("61.16.161.93","192.168.10.25","192.168.1.15","192.168.1.19");

$matriid		= db_escape_quotes(decrypt($_REQUEST['matriid'],2));
$operator		= db_escape_quotes(decrypt($_REQUEST['operator'],2));
$leadsource		= db_escape_quotes(decrypt($_REQUEST['leadsource'],2));
$sdate			= db_escape_quotes(decrypt($_REQUEST['startdate'],2));
$edate			= db_escape_quotes(decrypt($_REQUEST['enddate'],2));
$reasonforchat  = db_escape_quotes(decrypt($_REQUEST['reasonforchat'],2));
$bugid		    = db_escape_quotes(decrypt($_REQUEST['bugid'],2));

$ip = $_GET['ip'];

if($_REQUEST['queueid']!='')
	$queueid=db_escape_quotes(decrypt($_REQUEST['queueid'],2));
else
	$queueid=0;
if($_REQUEST['callerid']!='')
	$callerid=db_escape_quotes(decrypt($_REQUEST['callerid'],2));
else
	$callerid='';


/*
$matriid = db_escape_quotes($_REQUEST['matriid']);
$operator = db_escape_quotes($_REQUEST['operator']);
$leadsource = db_escape_quotes($_REQUEST['leadsource']);
$sdate = db_escape_quotes($_REQUEST['startdate']);
$edate = db_escape_quotes($_REQUEST['enddate']);
$reasonforchat = db_escape_quotes($_REQUEST['reasonforchat']);
$bugid = db_escape_quotes($_REQUEST['bugid']);

if($_REQUEST['queueid']!='')
	$queueid = db_escape_quotes($_REQUEST['queueid']);
else
	$queueid=0;
if($_REQUEST['callerid']!='')
	$callerid = db_escape_quotes($_REQUEST['callerid']);
else
	$callerid='';
*/
//http://www.communitymatrimony.com/admin/paymentassistance/paupdatecrmchat.php?matriid=AGR100235&operator=1234&leadsource=6&startdate=2009-12-15&enddate=2009-12-18&reasonforchat=Checking&bugid=112

//http://www.communitymatrimony.com/admin/paymentassistance/paupdatecrmchat.php?matriid=c3mEY2JiZGVn&operator=k5afm6Cbpaakk6ahpA==&leadsource=ZA==&startdate=ZGJia19iaF9ka1JjZGxkaGxiag==&enddate=ZGJia19iaF9ka1JjZGxkaGxiag==&reasonforchat=ZWY=&bugid=Y2M=



	$argMatriDetails = array('Paid_Status','Country','Last_Payment','Country','Contact_Phone','Contact_Mobile','Expiry_Date');
	$argCondition = " where MatriId = '$matriid'";
	$matriNum = $objSlave -> numOfRecords($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'], 'MatriId', $argCondition);
	if($objSlave -> clsErrorCode == "CNT_ERR")
	{
		mail("suresh.a@bharatmatrimony.com","Count Error - /admin/paymentasssitance/paupdatecrmchat.php - CNT_ERR","Line no : 113");
		exit;
	}
	$idOk = "0";
	if($matriNum > 0)
	{
		$newLeadSource = $leadsource;
		$idOk = "1";
		$argsPA = array('MatriId','FollowupStatus','LeadSource','FreshlyAddedOn');
		$argCondition = " where MatriId = '$matriid'";
		$paEntryCount = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition);
		if($objSlave -> clsErrorCode == "CNT_ERR")
		{
			mail("suresh.a@bharatmatrimony.com","Count Error - /admin/paymentasssitance/paupdatecrmchat.php - CNT_ERR","Line no : 123");
			exit;
		}
		$memDetailsResult = $objSlave -> select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$argMatriDetails,$argCondition,0);
		if($objSlave -> clsErrorCode != "SELECT_ERR")
		{
			$memDetailsRow = mysql_fetch_assoc($memDetailsResult);
		}
		else
		{
			mail("suresh.a@bharatmatrimony.com","Select Error - /admin/paymentasssitance/paupdatecrmchat.php - SELECT_ERR","Line no : 136");
			exit;
		}
		if($paEntryCount == 0 && $memDetailsRow['Paid_Status'] == 0)
		{
			$exPhone = explode("~",$memDetailsRow['Contact_Phone']);
			$countryCode = $exPhone[0];
			$areaCode = $exPhone[1];
			$communityId = commIdfromMatId($matriid);

			$argColsPA = array('Matriid','CommunityId','OperatorName','LeadSource','StartDate','EndDate','ReasonForChat','BugId','Country','CountryCode','AreaCode','PhoneNo','MobileNo','FreshlyAddedOn','QueueId','CallerId','EntryType','DateUpdated');

			$argValuesPA = array("'".$matriid."'","'".$communityId."'","'".$operator."'","'".$leadsource."'","'".$sdate."'","'".$edate."'","'".$reasonforchat."'","'".$bugid."'","'".$memDetailsRow['Country']."'","'".$countryCode."'","'".$areaCode."'","'".$memDetailsRow['Contact_Phone']."'","'".$memDetailsRow['Contact_Mobile']."'","now()","'".$queueid."'","'".$callerid."'","'".$memDetailsRow['Paid_Status']."'","now()");
			
			$numInserted = $objMaster -> insert($varTable['PAYMENTOPTIONS'], $argColsPA, $argValuesPA);
			insert($varTable['PAYMENTOPTIONS'], $argColsPA, $argValuesPA);
			if($objMaster -> clsErrorCode == "INSERT_ERR")
			{
				mail("suresh.a@bharatmatrimony.com","Insert Error - /admin/paymentasssitance/paupdatecrmchat.php - INSERT_ERR","Line no : 154");
				exit;
			}
			echo "2";
		}
		else if($paEntryCount != 0 && $memDetailsRow['Paid_Status'] == 1)
		{
			$argFields = array('PaymentDate','PaymentVisit','DateUpdated');
			$argFieldsValues = array("'".$memDetailsRow["Last_Payment"]."'","PaymentVisit+1","now()");
			$argCondition = " MatriId = '".$matriid."'";

			$objMaster -> update($varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition);
			if($objMaster -> clsErrorCode == "UPDATE_ERR")
			{
				mail("suresh.a@bharatmatrimony.com","Update Error - /admin/paymentasssitance/paupdatecrmchat.php - UPDATE_ERR","Line no : 168");
				exit;
			}
			echo "3";
		}
		else
		{
			$argCondition = " where MatriId = '$matriid'";
			$paDetailsResult = $objSlave -> select($varTable['PAYMENTOPTIONS'],$argsPA,$argCondition,0);
			if($objMaster -> clsErrorCode == "SELECT_ERR")
			{
				mail("suresh.a@bharatmatrimony.com","Select Error - /admin/paymentasssitance/paupdatecrmchat.php - SELECT_ERR","Line no : 179");
				exit;
			}
			else
			{
				$paDetailsRow = mysql_fetch_assoc($paDetailsResult);
			}
			$expdate   = explode(" ",$paDetailsRow['FreshlyAddedOn']);
			$curdb     = explode("-",$expdate[0]);
			$curdbdate = mktime(0,0,0,$curdb[1],$curdb[2],$curdb[0]);
			$currdate  = mktime(0,0,0,date('m'),date('d'),date('Y'));

			if(($paDetailsRow['LeadSource']=='2') && ($curdbdate==$currdate))
			{
				$leadsource='2';
			}
			else 
			{
				$leadsource=$leadsource;
			}
			
			$argFields = array('LeadSource','PaymentVisit','PaymentDate');
			$argFieldsValues = array("'".$leadsource."'","PaymentVisit+1","'0000-00-00 00:00:00'");

			$argCondition = " MatriId = '".$matriid."'";
			$objMaster -> update($varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition);
			if($objMaster -> clsErrorCode == "UPDATE_ERR")
			{
				mail("suresh.a@bharatmatrimony.com","Update Error - /admin/paymentasssitance/paupdatecrmchat.php - UPDATE_ERR","Line no : 207");
				exit;
			}
			echo "4";
		}
	}
	else
	{
		echo "1";
	}
	if($idOk = "1")
	{
		renwalupdate($matriid,$memDetailsRow['Paid_Status'],$memDetailsRow['Expiry_Date'],$newLeadSource);
	}


$varTable['PAYMENTOPTIONSLOG'] = 'paymentoptionslog';
function commIdfromMatId($matriId)
{
	global $arrMatriIdPre;
	$arrMatriIdPre1 = array_flip($arrMatriIdPre);
	$firstThreeLetter = substr($matriId,0,3);
return $arrMatriIdPre1[$firstThreeLetter];
}
function renwalupdate($upMatriId,$entryType,$expiryDate,$leadSource) {
	global $varTable,$objMaster;
	#insert the data to log table
	$argColsPAL = array('MatriId','LeadSource','DateUpdated');
	$argValuesPAL = array("'".$upMatriId."'","'".$leadSource."'","now()");
	
	$numInserted = $objMaster -> insert($varTable['PAYMENTOPTIONSLOG'], $argColsPAL, $argValuesPAL);
	if($objMaster -> clsErrorCode == "INSERT_ERR")
	{
		mail("suresh.a@bharatmatrimony.com","insert Error - /admin/paymentasssitance/paupdatecrmchat.php","Line no : 241");
		exit;
	}

	$curTime = date("Y-m-d H:i:s");
	$days = (strtotime($expiryDate) - strtotime($curTime)) / (60 * 60 * 24);
	if($entryType=='0' or ($entryType='1' and $days<=15))
	{
		$argFields = array('PaymentDate');
		$argFieldsValues = array("'0000-00-00 00:00:00'");

		$argCondition = " MatriId = '".$upMatriId."'";
		$objMaster -> update($varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition);
		if($objMaster -> clsErrorCode == "UPDATE_ERR")
		{
			mail("suresh.a@bharatmatrimony.com","Update Error - /admin/paymentasssitance/paupdatecrmchat.php","Line no : 256");
			exit;
		}
	}
}
?>