<?php
/* **************************************************************************************************
FILENAME        :supporcheckstatus.php
AUTHOR			:A. Kirubasankar
PROJECT			:Payment Assistance
DESCRIPTION     :to dispaly the matriids details for making the followupstatus
************************************************************************************************* */

//BASE PATH
//$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

//include_once("header.php");
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/domainrates.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/www/admin/paymentassistance/clsPaging.php');
include_once("../includes/date_functions.php");
include_once("easypay_arrays.php");
include_once($varRootBasePath.'/www/admin/paymentassistance/lvars.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/pavar.php');

if($adminUserName == "")
	header("Location: ../index.php?act=login");

$paging = new clsPaging;
//VARS
global $adminUserName,$paymentoption_followup_status;
$varTable['CBSTMMATCHINGCOUNT'] = "cbstmmatchingcount";
$OtherISD = $DubaiISDcode+$IndaiISDcode+$UsaISDcode+$AustraliaISDcode+$SingaporeISDcode+$MalaysiaISDcode+$UKISDcode+$CanadaISDcode;
$domainInfo = new domainInfo;

$objSlaveMatri		= new DB;
$objPaysAssMaster	= new DB;
$objEPR				= new DB;

//DB Connection
$objEPR -> dbConnect('ODB4',$varDbInfo['EPRDATABASE']);
$objSlaveMatri->dbConnect('S',$varDbInfo['DATABASE']);
$objPaysAssMaster->dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);

//$objSlavecbstmiface -> dbConnect('S',$varCbstminterfaceDbInfo['DATABASE']);

$matriid = mysql_real_escape_string($_REQUEST['mtid']);



$uid        =$COOKIE['userid'];
$uname      = $adminUserName;
$offset = mysql_real_escape_string($_REQUEST[offset]);
if($offset == "")
	$offset = 0;


$time10diff = mktime(date("H"),date("i")-15,date("s"),date(m),date(d),date(Y));
$date10diff1=date("Y-m-d H:i:s",$time10diff);


function lockingid($matriid,$objPaysAssMaster)
{
	global $adminUserName,$uname,$varTable;

	$fid = $_REQUEST['fmatriid'];

	if(mysql_real_escape_string($_REQUEST['fmatriid']) != "")
		$fid = mysql_real_escape_string($_REQUEST['fmatriid']);

	$argFields = array('SupportUserName');
 	$argCondition = " where SupportUserName='$adminUserName' and FollowupStatus=0 and MatriId='".$fid."'";

	$lockcount	= $objPaysAssMaster -> numOfRecords($varTable['PAYMENTOPTIONS'], 'MatriId', $argCondition);
	$lockcountresult	= $objPaysAssMaster->select($varTable['PAYMENTOPTIONS'],$argFields,$argCondition,0);
	$row_lock = mysql_fetch_assoc($lockcountresult);

	if($row_lock['SupportUserName'] == $uname && $lockcount != 0 && $fid != "")
	{
		
		$argField = array('Locktime','SupportUserName');
		$argValue = array("'0000-00-00 00:00:00'","''");
		$argConditions = " MatriId='".$fid."' and (FollowupStatus=0)";
		$updatings = $objPaysAssMaster->update($varTable['PAYMENTOPTIONS'],$argField,$argValue,$argConditions);
	}

	$nowTime = date("Y-m-d H:i:s");
	$argFields = array('Locktime','SupportUserName');
	$argValues = array("'".$nowTime."'","'".$uname."'");
	$argCondition = " MatriId='".$matriid."'  and (SupportUserName = '' or SupportUserName='".$uname."')";
	$updating = $objPaysAssMaster->update($varTable['PAYMENTOPTIONS'],$argFields,$argValues,$argCondition);
}
#view by id locking system
function lockViewById($matriid)
{
	global $adminUserName,$uname,$varTable,$objPaysAssMaster;
	$nowTime = date("Y-m-d H:i:s");

	$argCondition = " MatriId='".$matriid."'";
	$argField = array('SupportUserName','LockTime');
	$argValue = array("'".$uname."'","'".$nowTime."'");
	
	$count = $objPaysAssMaster -> update($varTable['PAYMENTOPTIONS'],$argField,$argValue,$argCondition);
return $count;
}


$args=array('MatriId','Name','Gender','Last_Login','Validated_By','Country','Expiry_Date','Paid_Status','Time_Posted','Last_Payment','Number_Of_Payments','Valid_Days','OfferAvailable','Partner_Set_Status','Horoscope_Available','Hobbies_Available','Phone_Verified','OfferCategoryId','CasteId','Family_Set_Status');
$argCondition = " where MatriId='".$row['MatriId']."'";
$checkResult = $objSlaveMatri->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$args,$argCondition,0);
$recdgen = mysql_fetch_assoc($checkResult);

$args = array('PrivilegeLeadSource','PrivilegeLanguage','PrivilegeValidTime');
$argCondition = "where User_Name='$uname' and PrivilegeValidTime!='0000-00-00 00:00:00'";
$checkResult=$objSlaveMatri->select($varDbInfo['DATABASE'].".".$varTable['ADMINLOGININFO'],$args,$argCondition,0); 
$resultValue = mysql_fetch_assoc($checkResult);
$PrivilegeValidTime = strtotime($resultValue[PrivilegeValidTime]);
$PrivilegeLanguage = $resultValue[PrivilegeLanguage];
$PrivilegeLeadSource = $resultValue[PrivilegeLeadSource];
$now_time = strtotime(date("Y-m-d H:i:s"));

$category = mysql_real_escape_string($_REQUEST['category']);
$fdate = mysql_real_escape_string($_REQUEST['fdate']);
$tdate = mysql_real_escape_string($_REQUEST['tdate']);

if($PrivilegeValidTime < $now_time) {
	$language=explode("~",$_REQUEST['language']);
}
else {
	if(ucwords($PrivilegeLanguage) == 'All') { 
		$language=ucwords($PrivilegeLanguage);
	}	
}

$ts=$_REQUEST['ts'];

if($PrivilegeValidTime < $now_time) {
	$leadsources=explode("~",$_REQUEST['leso']);
}
else {		
	if(ucwords($PrivilegeLeadSource) != 'All') {
		$leadsources=explode("&",$PrivilegeLeadSource);
	}
	else {
		$leadsources='All';
	}

}


$countrycode=explode("~",$_REQUEST['country']);


$applang='';

#language filter--------------------------------------------------------
if(is_array($language)) {
	$langCount = 0;
	if(!in_array("All",$language)) {
		$applang.= " AND (";
		foreach($language as $k => $v) {
			if($v != "")
			{
				if($k!=0)
					$applang.= " OR ";
				$applang.= " CommunityId = ".$v."";
				$langCount++;
			}
		}
		$applang.= ")";
	}
	if($langCount == 0)
		$applang = "";
}
$topFiftyDomains = $_REQUEST['topFiftyDomains'];

if($PrivilegeValidTime < $now_time) {
	$commlangArr = explode("~",$_REQUEST[commlang]);
}
else {
	if(ucwords($PrivilegeLanguage) != 'All') {
		$commlangArr = explode("&",$PrivilegeLanguage);
	}
}

if(($_REQUEST[commlang] != "") || ($PrivilegeLanguage != "" && ucwords($PrivilegeLanguage) != 'All'))
{
	$commLangCond = " and (";
	foreach($commlangArr as $clKey => $clValue)
	{
		$commLangCond .= " MotherTongueGrouping = $clValue or ";
	}
$commLangCond = substr($commLangCond,0,strlen($commLangCond)-4);
$commLangCond .= ")";
}

//else if($topFiftyDomains != "")
else if(($_REQUEST[topFiftySwitch] == "topFiftySwitch" && !is_array($_REQUEST[commlang])) || ($_REQUEST[topFiftySwitch1] == "topFiftySwitch1" && !is_array($_REQUEST[commlang])))
{
	$applang.= " AND (";
	$applang.= "TopFiftyGrouping = 1";
	/*foreach($top50DomainsArr as $kk => $vv)
	{
		if($kk != 0 && $top50count != 0)
			$applang.= " OR ";
		$applang.= "CommunityId = ".$kk."";
		$top50count++;
	}*/
	$applang.= ")";
}
if(is_array($leadsources)) {
	if(!in_array("All",$leadsources)) {
		$applang.= " AND (";
		foreach($leadsources as $kl => $vl) {
			if($kl!=0)
				$applang.= " OR ";
			$applang.= "LeadSource=".$vl."";
		}
		$applang.= ")";
	}
} else if($leadsources !='All') {
	$applang.= " AND LeadSource=".$leadsources."";
}
#language filter--------------------------------------------------------


#Country Code filter----------------------------------------------------

if(is_array($countrycode) && $_REQUEST['country'] != '') {
	if(in_array('03',$countrycode)) {
		$code=implode(",",$OtherISD);
		if($code != "")
			$applang.=" AND CountryCode NOT in(".$code.")";
	} else if(!in_array('0',$countrycode)) {
		$comma = "";
		if(in_array('91',$countrycode)) {
				$code = implode(",",$IndaiISDcode);
				$comma = ",";
			}
			if(in_array('01',$countrycode)){
				$code .= $comma.implode(",",$UsaISDcode);
				$comma = ",";
			}
			if(in_array('02',$countrycode)){
				$code .= $comma.implode(",",$DubaiISDcode);
				$comma = ",";
			}
			if(in_array('04',$countrycode)){
				$code .= $comma.implode(",",$AustraliaISDcode);
				$comma = ",";
			}
			if(in_array('05',$countrycode)){
				$code .= $comma.implode(",",$SingaporeISDcode);
				$comma = ",";
			}
			if(in_array('06',$countrycode)){
				$code .= $comma.implode(",",$MalaysiaISDcode);
				$comma = ",";
			}
			if(in_array('07',$countrycode)){
				$code .= $comma.implode(",",$UKISDcode);
				$comma = ",";
			}
			if(in_array('08',$countrycode)){
				$code .= $comma.implode(",",$CanadaISDcode);
			}
			//$code=implode(",",$$ISDCodeArrName);
			$applang.=" AND CountryCode in(".$code.")";
	}
} elseif($_REQUEST['country'] != '') {
	if($countrycode=='03'){
	$code=implode(",",$OtherISD);
	if($code != "")
		$applang.=" AND CountryCode NOT in(".$code.")";
	} else if(($countrycode!="0")&&($countrycode!="")){
		if($countrycode=='91') {
			$ISDCodeArrName = "IndaiISDcode";
		} else if($countrycode=='01'){
			$ISDCodeArrName = "UsaISDcode";
		} else if($countrycode=='02'){
			$ISDCodeArrName = "DubaiISDcode";
		} else if($countrycode=='04'){
			$ISDCodeArrName = "AustraliaISDcode";
		} else if($countrycode=='05'){
			$ISDCodeArrName = "SingaporeISDcode";
		} else if($countrycode=='06'){
			$ISDCodeArrName = "MalaysiaISDcode";
		} else if($countrycode=='07'){
			$ISDCodeArrName = "UKISDcode";
		} else if($countrycode=='08'){
			$ISDCodeArrName = "CanadaISDcode";
		}
		$code=implode(",",$$ISDCodeArrName);
		$applang.=" AND CountryCode in(".$code.")";
	}
}
#Country Code filter----------------------------------------------------



$new=$_REQUEST['regt'];
$validated = $_REQUEST['validated'];

if($new=="CBS")
	{
		 $commReg = " and BM_MatriId='' ";
	}
    if($new=="BM")
	{
		 $commReg = " and BM_MatriId <> ''";
	}

    if($new=="any")
	{
		 $commReg = "";
	}
if($validated == "0")
{
	$validatedQuery = " and Publish = 0";
	$validatedRedirect = "&validated=0";
}
if($validated == "1")
{
	$validatedQuery = " and Publish = 1";
	$validatedRedirect = "&validated=1";
}

#category wise 1
if($category == "1")
{
	if($fdate != "" && $tdate!="")
	{
		$qurydate= "FreshlyAddedOn >= '".$fdate." 00:00:00' and FreshlyAddedOn <= '".$tdate." 23:59:59'";
	}
	else { $qurydate= "";}

 $argCondition = " where ".$qurydate." and (SupportUserName='".$uname."' or SupportUserName = '' ) and FollowupStatus=0  and LockTime < '".$date10diff1."' and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or EntryType=0) ". $applang."".$commLangCond.$commReg." ".$validatedQuery;

	$totalcount = $objPaysAssMaster -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition);
	$argFields = array('MatriId','LeadSource','Language','Comments','FollowupStatus','FollowupDate','FreshlyAddedOn','PaymentVisit','CountryCode','AreaCode','PhoneNo','MobileNo','PackageSelected','OptionSelected','Country','CallerId','PaymentFailurePhoneNo','AssuredPhoneNumber');

	if($totalcount <= $offset)
		$offset = $totalcount - 1;
	if($offset < 0)
		$offset = 0;
	
	$argConditionsel = $argCondition." order by FreshlyAddedOn desc limit ".$offset.",1";
	$totalQuery	= $objPaysAssMaster -> select($varTable['PAYMENTOPTIONS'],$argFields,$argConditionsel,0);
}
#category wise 2
if($category == "2")
{
	if($fdate != "" && $tdate!="")
	{
		$qurydate= " FollowupDate >= '".$fdate."' and FollowupDate <= '".$tdate."'";
	}
	else {$qurydate= "";}

	if($ts != "")
		$followupStatusQuery = " and FollowupStatus = ".$ts;

	$argCondition = " where ".$qurydate." and SupportUserName ='".$uname."'  $followupStatusQuery ". $applang." ".$commLangCond.$commReg." ".$validatedQuery;
	$totalcount = $objPaysAssMaster -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition);
	
	$argFields = array('MatriId','LeadSource','Language','Comments','FollowupStatus','FollowupDate','FreshlyAddedOn','PaymentVisit','CountryCode','AreaCode','PhoneNo','MobileNo','PackageSelected','OptionSelected','Country','CallerId','PaymentFailurePhoneNo','AssuredPhoneNumber');

	if($totalcount <= $offset)
		$offset = $totalcount - 1;
	if($offset < 0)
		$offset = 0;

	$argCondition = " where ".$qurydate." and SupportUserName='".$uname."' $followupStatusQuery ". $applang." and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or EntryType=0) $commLangCond $validatedQuery order by DateUpdated asc limit ".$offset.",1";

	$totalQuery	= $objPaysAssMaster -> select($varTable['PAYMENTOPTIONS'],$argFields,$argCondition,0);
}

#view by matriid wise 3
if($category=="3")
{
	$curdate = date("Y-m-d")." 00:00:00";
	if($uname != "prabhur" and $uname != "Assistance")
		$argCondition = "where ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or EntryType=0) and MatriId='".$matriid."' and ((SupportUserName <> '$uname' and (FollowupStatus in (2,3,6,8,0) or (DateUpdated <= '$curdate' )) ) or (SupportUserName = '$uname' ))";
	else
		$argCondition = "where MatriId='".$matriid."' and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or EntryType=0)";
	$totalcount = $objPaysAssMaster -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition);

	$argFields = array('MatriId','LeadSource','Language','Comments','FollowupStatus','FollowupDate','FreshlyAddedOn','PaymentVisit','CountryCode','AreaCode','PhoneNo','MobileNo','PackageSelected','OptionSelected','Country','CallerId','PaymentFailurePhoneNo','AssuredPhoneNumber');

	$curdate = date("Y-m-d");

	$totalQuery	= $objPaysAssMaster -> select($varTable['PAYMENTOPTIONS'],$argFields,$argCondition,0);
}
//For Pending profiles:
if($category=="4")
{
	$argFields = array('MatriId','LeadSource','Language','Comments','FollowupStatus','FollowupDate','FreshlyAddedOn','PaymentVisit','CountryCode','AreaCode','PhoneNo','MobileNo','PackageSelected','OptionSelected','Country','CallerId','PaymentFailurePhoneNo','AssuredPhoneNumber');
	
	$argCondition = "where PaymentDate='0000-00-00 00:00:00' and (FollowupStatus = 0) and LockTime < '".$date10diff1."' and (SupportUserName = '' or SupportUserName='".$uname."')";
	
	$totalcount = $objPaysAssMaster -> numOfRecords($varTable['PAYMENTOPTIONS'], 'MatriId', $argCondition);
	if($totalcount <= $offset)
		$offset = $totalcount - 1;
	if($offset < 0)
		$offset = 0;
	
	$argCondition1 = $argCondition." order by FollowupDate desc limit $offset , 1";
	$totalQuery	= $objPaysAssMaster -> select($varTable['PAYMENTOPTIONS'],$argFields,$argCondition1,0);
}
if($_REQUEST[fix] == "1")
	echo $argCondition;
//$selqry = "select * from paymentoptions";
//$totalcount=2;
if($totalcount==0) {
?>
<html>
<head>

	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">

	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/usericons-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/messages.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">



</head>
<table align=center border="0" cellpadding="0" cellspacing="0" width="80%">
<tr><td  width="1px" align="left" height="40">
<?php
	include("../home/header.php");
?>
</td></tr>
</table>

<table align=center border="0" cellpadding="0" cellspacing="0"  width="780"  style='border: 1px solid #d1d1d1;'>
<tr align="right"  class='adminformheader'><td>TeleCallerId [<?=$uname;?>] &nbsp;<a href='index.php' class='textsmallnormal'><B>Home</B></a> | <A HREF="logout.php" class='textsmallnormal'><B>Logout</B></A></td></tr>
<?php
	if($_REQUEST[category] == "1")
		$meses = "No Fresh Profiles found.";
	if($_REQUEST[category] == "2")
		$meses = "No Profiles for Followup found.";
	if($_REQUEST[category] == "3")
		$meses = "No Valid Profile found.";
	if($_REQUEST[category] == "4")
		$meses = "No Pending Profiles found.";
echo "<tr   class='textsmallnormal'><td  width='183'   style='border: 1px solid #d1d1d1;' align='center'>
&nbsp;&nbsp;$meses</td></tr>";
?>
</table>
</body>
</html>
<?php
exit;
}
$row = mysql_fetch_array($totalQuery);

if($category == 1)
{
	$freelock="fmatriid=".$row['MatriId'];
	lockingid($row['MatriId'],$objPaysAssMaster);
}
if($category == 3)
{
	$lvbmset = lockViewById($row['MatriId']);
	
	if($lvbmset == 0 || $lvbmset == '')
	{
		echo "Unable to lock the leads Right now"; exit;
	}
	
}
if($category == 4)
{
	$freelock="fmatriid=".$row['MatriId'];
	lockingid($row['MatriId'],$objPaysAssMaster);
}
if($row['Comments']!='')
{
	$spec_char="#".chr(250);
	$text=ereg_replace($spec_char,"\n-------Last Followup Message---------------\n\n",$row['Comments']);
}

////Domain package details start

$varOfflineCurrency		= array('98'=>'RS.','US$'=>'222','AED'=>'220');
$varOfflineCurrencyId	= $varOfflineCurrency[trim(strtoupper(strtolower($_REQUEST["currency"])))];
$varOfflineCurrencyId	= $varOfflineCurrencyId ? $varOfflineCurrencyId : '98';
$varGetPrefix = strtoupper(substr($row['MatriId'],0,3));
if (array_key_exists($varGetPrefix, $arrFolderNames)) {
	$varGetFolder = $arrFolderNames[$varGetPrefix];
	$varGetPackage = 'CBS';
}

// INCLUDES //
include_once "/home/product/community/domainslist/$varGetFolder/conf.cil14";

$domainSegment = $domainInfo ->getSegment();
$domainSegment = substr($domainSegment,0,1);
switch($domainSegment)
{
	case "A":
		$arrSegment = $arrSegmentActualA;
		break;
	case "B":
		$arrSegment = $arrSegmentActualB;
		break;
	case "C":
		$arrSegment = $arrSegmentActualC;
		break;
	case "D":
		$arrSegment = $arrSegmentActualD;
		break;
	default :
		$arrSegment = $arrSegmentActualA;
		break;
}

////Domain Package details end

$commlang = implode("~",$_REQUEST[commlang]);

$callerid=$row['CallerId'];

$args = array('MatriId','Name','Gender','Last_Login','Validated_By','Country','Expiry_Date','Paid_Status','Time_Posted','Last_Payment','Number_Of_Payments','Valid_Days','OfferAvailable','Partner_Set_Status','Horoscope_Available','Hobbies_Available','Phone_Verified','OfferCategoryId','CasteId','Family_Set_Status');
$argCondition = " where MatriId='".$row['MatriId']."'";
$checkResult = $objSlaveMatri->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$args,$argCondition,0);
$recdgen = mysql_fetch_assoc($checkResult);

if($recdgen['Gender'] != "") {
	if( $recdgen['Gender'] == "1"){ $gender ="Male";}
	elseif( $recdgen['Gender'] == "2"){ $gender ="FeMale";}
}

if($recdgen['Validated'] != ""){
if($recdgen['Validated'] == 1){$recdgen['Validated'] ="Yes";}
if($recdgen['Validated'] == 0){$recdgen['Validated'] ="No";}
}
if($recdgen['Paid_Status'] != "")
{
	if( $recdgen['Paid_Status'] == "0"){ $entry ="Free";}
	elseif( $recdgen['Paid_Status'] == "1"){ $entry ="Paid";}
}
if($recdgen['Family_Set_Status'] == 1){$FD="Yes";}	else{$FD="No";}
if($recdgen['Partner_Set_Status'] == 1) { $PP="Yes"; }
else { $PP="No"; }

if($recdgen['Horoscope_Available'] > 0) 	{ $HA="Yes"; }
else {$HA="No"; }

if($recdgen['Hobbies_Available'] == 1) { $HOP="Yes"; }
else { $HOP="No"; }

$ccode = $recdgen['Country'];

for($i=1;$i<=9;$i++)
{
	$PaymentCategory=$PaymentCategory."<option value='$arrCurrCode[$ccode]".$arrSegment[$ccode][$i]."-$arrPrdPackages[$i],$i'>$arrCurrCode[$ccode]".$arrSegment[$ccode][$i]."-$arrPrdPackages[$i]</option>";
}

$paymentDetailsColumns = array('Product_Id','Payment_Mode','Payment_Type','Branch_Id');
$paymentCondition = " WHERE matriId = '".$row['MatriId']."'";
$paymentResult = $objSlaveMatri -> select($varDbInfo['DATABASE'].".".$varTable['PAYMENTHISTORYINFO'],$paymentDetailsColumns,$paymentCondition,0);

$pay = mysql_fetch_assoc($paymentResult);

$phonenumberassured = $row['AssuredPhoneNumber'];
$phonenumbercont = $row['PhoneNo'];
$mobilenumbercont = $row['MobileNo'];

$fpdate=$row['FollowupDate'];
if($fpdate and $fpdate!='0000-00-00')
{
	list($year,$mon,$day1)=explode("-",$fpdate);
	$today=mktime(0,0,0,date($mon),date($day1),date($year));
}
else
{
	$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
}
#message detailes

if($matriid == "")
	$matriid = $row['MatriId'];
$argFields = array('Total_Interest_Sent','Interest_Accept_Received','Interest_Pending_Received','Total_Interest_Received','MessageUnReadFilteredReceived','TotalMessagesSentLeft','MutualMatch','ViewedByMember','ViewedByVisitor');
$argCondition = " where MatriId = '".$matriid."'";
$memberStatisticsQuery	= $objSlaveMatri -> select($varDbInfo['DATABASE'].".".$varTable['MEMBERSTATISTICS'],$argFields,$argCondition,0);
$memberStatistics = mysql_fetch_assoc($memberStatisticsQuery);


?>
<html>
<head>
<script language="javascript" src="../includes/supportcheckstatus.js"></script>
<script language="javascript" src="../includes/pasthistory.js"></script>
<script language="javascript" src="../includes/changeajax.js"></script>


	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/usericons-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/messages.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">

</head>
<body onload="enableField();">
<table align=center border="0" cellpadding="0" cellspacing="0"  width="780" style='border: 1px solid #d1d1d1;'>
     <tr><td  width="1px">
	<?php
include("../home/header.php");
?>
	 </td></tr>
</table>

<table align=center border='0' cellpadding='0' cellspacing='0'  width='780' style='border: 1px solid #d1d1d1;'>
    <tr><td class="adminformheader"><b>Support Interface</b></td><td colspan="2" align="right" class="adminformheader"><a href='index_test.php'><b>Home</b></a>&nbsp;&nbsp;
	<!-- |&nbsp;&nbsp;<a href="../index.php?act=logout"><b>Logoff</b></a>&nbsp;&nbsp; -->
	</td>
    </tr>
	<tr colspan=3>
	<td style="padding-top:5px;">
	<input type="hidden" name="newmatriid"  id="newmatriid" size="8" value="<?=$row['MatriId']?>">
<table align=center border='0' cellpadding='3' cellspacing='3'  width='250' style='border: 1px solid #d1d1d1;'>
<tr border=0  ><td height=20 colspan=2 class="adminformheader" ><b>General Information</td>
</tr>
 <? if($recdgen['MatriId'] != ""){?><tr bgcolor=white><td height=20 class="smalltxt" >&nbsp;&nbsp;<b>Matriid</b></td><td height=20 class="smalltxt" ><b><?=$recdgen['MatriId']?></b></td></tr><? } else { ?><tr bgcolor=white><td height=20 class="smalltxt" >&nbsp;&nbsp;Matriid</td><td height=20 class="smalltxt" >N/A</td></tr><?}?>
<?	if($recdgen['Name'] != ""){?>
<tr bgcolor=white><td  width="50%" class="smalltxt" >&nbsp;&nbsp;Name</td><td width="50%" class="smalltxt" ><?=$recdgen['Name']?></td>
</tr> <? }else{ ?><tr bgcolor=white class="smalltxt" ><td height=20 >&nbsp;&nbsp;Name</td><td height=20 class="smalltxt" >N/A</td><? }?>
<? if($gender !=""){ ?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;Gender</td><td width="50%" class="smalltxt"><?=$gender?></td>
</tr><? } else{?><tr bgcolor=white><td height=20 class="smalltxt" >&nbsp;&nbsp;Gender</td><td height=20 class="smalltxt">N/A</td></tr><? } ?>
<? if($recdgen['Last_Login'] != ""){?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;LastLogin</td><td width="50%" class="smalltxt"><?=$recdgen['Last_Login']?></td>
</tr> <?}else{?><tr bgcolor=white class="smalltxt"><td height=20 class="smalltxt" >&nbsp;&nbsp;LastLogin</td><td height=20 class="smalltxt" >N/A</td></tr><?}?>

<? if($recdgen['Validated'] != ""){?>
</tr><tr bgcolor=white ><td width="50%" class="smalltxt">&nbsp;&nbsp;Validated</td><td width="50%" class="smalltxt"><?=$recdgen['Validated']?></td>
</tr><? } else{ ?><tr bgcolor=white ><td height=20 class="smalltxt" >&nbsp;&nbsp;Validated</td><td height=20 class="smalltxt">N/A</td></tr><? } ?>
<? if($entry != ""){?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;<b>EntryType</b></td><td width="50%" class="smalltxt"><b><?=$entry?></b></td>
</tr><? } else{ ?><tr bgcolor=white class="smalltxt"><td height=20 >&nbsp;&nbsp;EntryType</td><td height=20 class="smalltxt">N/A</td></tr><?}?>
<? if($row['FreshlyAddedOn'] != ""){?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;Profile Entry Date</td><td width="50%" class="smalltxt"><?=$row['FreshlyAddedOn']?> </td>
</tr><?}else{?><tr bgcolor=white><td height=20 class="smalltxt">&nbsp;&nbsp;Profile Entry Date</td><td height=20 class="smalltxt">N/A</td></tr><?}?>
<? if($recdgen['Time_Posted'] != ""){?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;TimePosted</td><td width="50%" class="smalltxt"><?=$recdgen['Time_Posted']?></td>
</tr><?}else{?><tr bgcolor=white><td height=20 class="smalltxt">&nbsp;&nbsp;TimePosted</td><td height=20 class="smalltxt">N/A</td></tr><?}?>

<? if($row['LeadSource'] != ""){?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;<b>Lead Source</b></td><td width="50%" class="smalltxt"><b><?=$leadsource[$row[LeadSource]]?></b></td>
</tr><?}else{?><tr bgcolor=white><td height=20 class="smalltxt">&nbsp;&nbsp;<b>Lead Source</b></td><td height=20 class="smalltxt">N/A</td></tr><?}?>

<?php
if($callerid){?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;Caller Id</td><td width="50%" class="smalltxt">
<?=$callerid?></td>
<?}


if($row['PhoneNo'] != "") {
?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;Contact Number</td><td width="50%" class="smalltxt">
<?=$row['PhoneNo']?></td>
</tr>
<?
}

?>

<?php
if($row['PackageSelected'] != "")
{
?>
</tr><tr bgcolor=white ><td width="50%" class="smalltxt">&nbsp;&nbsp;Package Selected</td><td width="50%" class="smalltxt"><?=$package[$row['PackageSelected']]['name']?></td>
</tr>
<?
}
else
{
?><tr bgcolor=white ><td height=20 class="smalltxt" >&nbsp;&nbsp;Package Selected</td><td height=20 class="smalltxt">N/A</td></tr>
<?
}
if($row['OptionSelected'] != "")
{
	$arrValue=$arrCountryDetails[$row['Country']];
	if($arrValue!='')
	{
		$countrysel=$arrCountryDetails[$row['Country']];
	}
	else
	{
		$countrysel="222";
	}
?>
</tr><tr bgcolor=white ><td width="50%" class="smalltxt">&nbsp;&nbsp;Payment Selected</td><td width="50%" class="smalltxt"><?=$optionselected[$countrysel][$row['OptionSelected']]?></td>
</tr>
<?
}
else
{
?>
	<tr bgcolor=white ><td height=20 class="smalltxt" >&nbsp;&nbsp;Payment Selected</td><td height=20 class="smalltxt">N/A</td></tr>
<?
	}
//}
?>
<tr height=18><td class="smalltxt">&nbsp;&nbsp;Horoscope Available</td><td class="smalltxt"><?=$HA;?></td></tr>
</tr>
<tr height=18><td class="smalltxt">&nbsp;&nbsp;Partner Preference</td><td class="smalltxt"><?=$PP;?></td></tr>
<tr height=18><td class="smalltxt">&nbsp;&nbsp;Family Details</td><td class="smalltxt"><?=$FD;?></td></tr>
<tr height=18><td class="smalltxt">&nbsp;&nbsp;Hobbies & Interest</td><td class="smalltxt"><?=$HOP;?></td></tr>
</table>
<br>
<table align=center border='0' cellpadding='3' cellspacing='3'  width='250' style='border: 1px solid #d1d1d1;'>
<tr><td height=20 colspan=2 class="adminformheader" ><b>Contact Information</td></tr>
<?php
if($row['PaymentFailurePhoneNo'] != "") {
?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;Failure Phone Number</td><td width="50%" class="smalltxt">
<?=$row['PaymentFailurePhoneNo']?></td>
</tr>
<?
}
else {
?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;AssuredContact</td><td width="50%" class="smalltxt">
<?php
	if($phonenumberassured != "")
		echo $phonenumberassured;
	else
		echo "N/A";
?></td>
</tr>
<?php
if($phonenumbercont != "") { ?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;Land Line</td><td width="50%" class="smalltxt">
<?=$phonenumbercont?></td>
</tr><? } else { ?><tr bgcolor=white><td height=20 class="smalltxt">&nbsp;&nbsp;Land Line</td><td height=20 class="smalltxt">N/A</td></tr>
<? }
if($mobilenumbercont != "") { ?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;MobileNumber</td><td width="50%" class="smalltxt">
<?=$mobilenumbercont?></td>
</tr><? } else { ?><tr bgcolor=white><td height=20 class="smalltxt">&nbsp;&nbsp;MobileNumber</td><td height=20 class="smalltxt">N/A</td></tr><?  }
}
?>

</table>
<br>
<table align=center border='0' cellpadding='3' cellspacing='3'  width='250' style='border: 1px solid #d1d1d1;' class="smalltxt">
<tr border=0><td height=20 colspan=2  class="adminformheader"><b>Payment Information</td>
</tr>
<? if($recdgen['Last_Payment'] != ""){?>
<tr bgcolor=white><td  width="50%" class="smalltxt">&nbsp;&nbsp;LastPayment&nbsp; </td><td width="50%" class="smalltxt"><?=$recdgen['Last_Payment']?></td>
</tr><? } else { ?><tr bgcolor=white><td height=20 class="smalltxt" >&nbsp;LastPayment&nbsp;&nbsp; </td><td height=20 class="smalltxt">N/A</td></tr><? } ?>

<? if($recdgen['Number_Of_Payments'] != "") { ?>
<tr bgcolor=white><td width="50%" class="smalltxt">&nbsp;&nbsp;NumberOfPayments</td><td width="50%" class="smalltxt"><?=$recdgen['Number_Of_Payments']?></td>
</tr><?}else{?><tr bgcolor=white class="smalltxt"><td height=20 >&nbsp;&nbsp;NumberOfPayments</td><td height=20 class="smalltxt">N/A</td></tr><? } ?>

<? if($pay['Product_Id'] != ""){
	//$packagefinal = $package[$pay['Product_Id']]['name'];
	$packagefinal = $arrPrdPackages[$pay['Product_Id']];
?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;ProductId</td><td width="50%" class="smalltxt"><?=$packagefinal?></td>
</tr><? } else {?><tr bgcolor=white><td height=20 >&nbsp;&nbsp;ProductId</td><td height=20 class="smalltxt" >N/A</td></tr><?}?>
<? if($pay['Payment_Mode'] != ""){ ?>
<tr bgcolor=white><td width="50%" class="smalltxt" >&nbsp;&nbsp;PaymentMode</td><td width="50%" class="smalltxt"><?=$arrPaymentMode[$pay['Payment_Mode']]?></td>
</tr><? } else{ ?><tr bgcolor=white><td height=20 class="smalltxt">&nbsp;&nbsp;PaymentMode</td><td height=20 class="smalltxt">N/A </td></tr><?}?>
<? if($recdgen['Valid_Days'] != ""){?>
<tr bgcolor=white><td width="50%" class="smalltxt">&nbsp;&nbsp;ValidDays</td><td width="50%" ><?=$recdgen['Valid_Days']?></td>
</tr><?}else{?><tr bgcolor=white class="smalltxt"><td height=20 class="smalltxt" >&nbsp;&nbsp;ValidDays</td><td height=20 class="smalltxt">N/A</td></tr><?}?>
<? if($recdgen['Expiry_Date'] != ""){?>
<tr bgcolor=white><td width="50%" >&nbsp;&nbsp;ExpiryDate</td><td width="50%" ><?=$recdgen['Expiry_Date']?></td></tr>
<? } else{ ?><tr bgcolor=white><td height=20 >&nbsp;&nbsp;ExpiryDate</td><td height=20 >N/A</td></tr><?}?>
<? if($pay['Branch_Id'] != ""){?>
<tr bgcolor=white><td width="50%" >&nbsp;&nbsp;BranchName</td><td width="50%" ><?=$pay['Branch_Id']?></td></tr>
<? } else{ ?><tr bgcolor=white><td height=20 >&nbsp;&nbsp;BranchName</td><td height=20 >N/A</td></tr><?}?>
</table>
<br>

<table  align=center border='0' cellpadding='3' cellspacing='3'  width='250' style='border: 1px solid #d1d1d1;'>
<tr border=0  ><td height=20 colspan=2 class="adminformheader"><b>Interest / Contact Services</td>
<tr height=18><td class="smalltxt" width="50%">&nbsp;&nbsp;No.of Interest Sent</td><td class="smalltxt" width="50%">&nbsp;<?=$memberStatistics['Total_Interest_Sent']?$memberStatistics['Total_Interest_Sent']:"0"?></td></tr>
<tr height=18><td class="smalltxt" width="50%">&nbsp;&nbsp;Interest Accepted</td><td class="smalltxt" width="50%">&nbsp;<?=$memberStatistics['Interest_Accept_Received']?$memberStatistics['Interest_Accept_Received']:"0"?></td></tr>
<tr height=18><td class="smalltxt" width="50%">&nbsp;&nbsp;Interest Pending</td><td class="smalltxt" width="50%">&nbsp;<?=$memberStatistics['Interest_Pending_Received']?$memberStatistics['Interest_Pending_Received']:"0"?></td></tr>
<tr height=18><td class="smalltxt" width="50%">&nbsp;&nbsp;No.of Unread Message</td><td class="smalltxt" width="50%">&nbsp;<?=$memberStatistics['MessageUnReadFilteredReceived']?$memberStatistics['MessageUnReadFilteredReceived']:"0"?></td></tr>
<tr height=18><td class="smalltxt" width="50%">&nbsp;&nbsp;No.of Read Message</td><td class="smalltxt" width="50%">&nbsp;
<?php
	echo $readmessages = $memberStatistics['TotalMessagesSentLeft'] - $memberStatistics['MessageUnReadFilteredReceived'];
?>
<?//$pt_row['MessageReadReceived']?$pt_row['MessageReadReceived']:"0"?></td></tr>
<tr height=18><td class="smalltxt" width="50%">&nbsp;&nbsp;Matching Count</td><td class="smalltxt" width="50%">

<?
//	if($msgnum==0){
?>
<!---&nbsp;<span id="msgcountdiv"><a href="javascript:;" onClick="matchingcount('<?=$row['MatriId']?>')">Clickhere</a></span> -->
<? 
/*
} else{
echo "&nbsp;".$disp = $msg_row['MatchingCount'];
} 
*/
$matchCount = matchingcount($row['MatriId']);
if($matchCount == "0" || $matchCount == "")
{
	echo '<span id="msgcountdiv"><a href="javascript:;" onClick="matchingcount(\''.$row['MatriId'].'\')">Clickhere</a></span>';
}
else
{
	echo $matchCount;
}
?>
</td></tr>
<?php
//Login Count
$argCondition = " where MatriId='".$row['MatriId']."'";
$memberlogincount	= $objSlaveMatri -> numOfRecords($varTable['MEMBERLOGINLOG'], 'MatriId', $argCondition);
?>
<tr height=18><td class="smalltxt" width="50%">&nbsp;&nbsp;Login Count</td><td class="smalltxt" width="50%">&nbsp;<?=$memberlogincount?$memberlogincount:"0"; ?></td></tr>
<tr bgcolor=white><td  class="smalltxt" width="50%">&nbsp;&nbsp;MessagesLeft</td><td  class="smalltxt" width="50%">&nbsp;<?=$memberStatistics['TotalMessagesSentLeft']?$memberStatistics['TotalMessagesSentLeft']:"0"?>
</td></tr>
<tr bgcolor=white><td  class="smalltxt" width="50%">&nbsp;&nbsp;Visited Count</td><td  class="smalltxt" width="50%">&nbsp;<?=$row['PaymentVisit']?$row['PaymentVisit']:"0"?>
</td></tr>
</table>
<br>
</td>
<td colspan=3 align="center" valign="top">
<table align=center border='0' cellpadding='0' cellspacing='0'  width='450'><tr><td class="smalltxt clr5" height="25">
<?php
// $pageLink = "supportcheckstatus.php?Total=".$totalcount."&fdate=".$fdate."&tdate=".$tdate."&language=".mysql_real_escape_string($_REQUEST['language'])."&category=".$category."&".$freelock."&ts=".$ts."&leso=".$_REQUEST['leso']."&country=".$_REQUEST['country']."&commlang=".$_REQUEST['commlang']."&regt=".$new."&topFiftyDomains=".$_REQUEST['topFiftyDomains'];

$pageLink = "supportcheckstatus_test.php?Total=".$totalcount."&fdate=".$fdate."&tdate=".$tdate."&language=".mysql_real_escape_string($_REQUEST['language'])."&category=".$category."&".$freelock."&ts=".$ts."&leso=".$_REQUEST['leso']."&country=".$_REQUEST['country']."&commlang=".$_REQUEST['commlang']."&regt=".$new."&topFiftySwitch=".$_REQUEST['topFiftySwitch']."&topFiftySwitch1=".$_REQUEST['topFiftySwitch1'].$validatedRedirect;

echo "<br><font class='clr'>Page : </font>".$paging -> displayPaging($totalcount,$pageLink,1,5);
?>

</td>
<td>&nbsp; <input type=hidden name=MatriId size=5 value="<?=mysql_real_escape_string($_REQUEST['MatriId'])?>"> </td>
	    <td><input type=hidden name=domain size=5 value="<?=$row['Language']?>"></td>
		<td><input type=hidden name=Comments size=5 value="<?=$row['Comments']?>"></td>
</tr>
</table>
<!-- History Add-->
	<div id="dwindowhistory" style="position:absolute;z-index:1;cursor:hand;display:none;margin:290px 0px 0px 80px;" onMousedown="initializedraghistory(event)" onMouseup="stopdraghistory()" onSelectStart="return false">
	<div style="background-color:#007A64; width:550px;border:1px solid #f7f7f7;007A64-bottom:0px;">
	<div class="fleft" style="float:left;padding: 1px 10px;"><B>TeleCaller Past History</B></div><div style="float:right;padding:3px;"><img src="close.gif" onClick="closeithistory()" ></div><br clear="all" />
	</div><div id="dwindowcontenthistory" style="width:550px;background-color:#FFF;border:1px solid #c2c2c2;"><iframe id="cframehistory" width="550" height="300" border="0" frame="0" frameborder="0"></iframe></div>
	<br clear="all">
	</div>
<!-- History Close-->

<table align=center border='0' cellpadding='0' cellspacing='0'  width='500' style='border: 1px solid #d1d1d1;' class="normaltxt1">
<tr><td height=20 class="adminformheader">&nbsp;&nbsp;<b>Follow Up Services</b></font> &nbsp; &nbsp; &nbsp; 
<a onclick="loadwindowhistory('tmpasthistory.php?COMMATRIID=<?php echo $recdgen['MatriId']; ?>&amp;dbinfo=tminterface.tmfollowupdetails&amp;interface=5',900,300);" >Past History</a>
</td></tr>
<tr><td colspan=2>

	<form name='PROFILEUPDATE' method="POST"  action="support_insert.php" onSubmit="return validatethis();">
	<table border=0 cellpadding=0 cellspacing=0 width=95% align=center>
	<input type="hidden" name=httpreferrer value='1'>
	<input type="hidden" name="matriidpost" value="<?=$recdgen['MatriId']?>">
	<input type="hidden" name="cate" value="<?=$category?>">
	<input type="hidden" name="userid" value="<?=$uid?>">
	<input type="hidden" name="username" value="<?=$uname?>">
	<input type="hidden" name="customername" value="<?=$recdgen['Name']?>">
	<input type="hidden" name="easypayhide" value="support_easypayapplication.php?MatriId=<?=$recdgen['MatriId']?>&Uid=<?= $uid?>&Name=<?=$uname?>&httpreferrer=1&lsource=<?=$row['LeadSource']?>">
	<?php
	$reqDa2 = mktime(0,0,0,date('m'),date('d')-3,date('Y'));
	$currDate = date("Y-m-d",$reqDa2);


	$eprStatusArr = array('ExecutiveId','RequestDate','ContactStatus','BranchId','AppointmentDate');
	//$eprStatusCondSelect = " where (EntryFrom=9 or EntryFrom=10 or EntryFrom=11) and AppointmentDate >= '$currDate' and MatriId = '$matriid' order by  AppointmentDate desc limit 1";

	$eprStatusCondSelect = " where ((AppointmentDate<>'0000-00-00' and AppointmentDate >= '$currDate') or (AppointmentDate='0000-00-00' and RequestDate>='$currDate 00:00:00')) and (ContactStatus<>3 and ContactStatus<>4) and MatriId = '".$matriid."' order by  AppointmentDate desc limit 1";
	
	$eprResult	= $objEPR -> select($varTable['EASYPAYINFO'],$eprStatusArr,$eprStatusCondSelect,1);

	$epCount = count($eprResult);
	if($epCount >= 1)
	{

		// Fetching Contact Status Array
		$curlUrl = "http://wcc.matchintl.com/getdetailsbmtm.php?para=status";
		//$curlUrl = "http://www.communitymatrimony.com/admin/paymentassistance/getdetailsbmtm.php?para=status";
		$branchContactInfo1 = cbscurl($curlUrl);

		$branchContactInfo2 = explode(":&npn&:",$branchContactInfo1);
		$branchContactInfo3 = $branchContactInfo2[1];
		$branchContactInfo = json_decode($branchContactInfo3,true);
		$status = $branchContactInfo[$eprResult[0]['ContactStatus']];
		$branchName = branchName($eprResult[0]['BranchId']);
		
		$reqDate1 = explode("-",$eprResult[0]['RequestDate']);
		$reqDate2 = mktime(0,0,0,$reqDate1[1],$reqDate1[2],$reqDate1[0]);
		$reqDate = date("d-M-Y",$reqDate2);

		$appDate1 = explode("-",$eprResult[0]['AppointmentDate']);
		$appDate2 = mktime(0,0,0,$appDate1[1],$appDate1[2],$appDate1[0]);
		$appDate = date("d-M-Y",$appDate2);

		$eprMessage = "<br> &nbsp; Already EPR Request exists <br><br> &nbsp; Raised by &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : ".$eprResult[0]['ExecutiveId']." <br> &nbsp; Branch Name  &nbsp;  &nbsp;: ".$branchName." <br> &nbsp; Request Date  &nbsp; &nbsp;: ".$reqDate." <br> &nbsp; Current Status  &nbsp; : ".$status." <br> &nbsp; Appointment Date : ".$appDate;
	}

	function cbscurl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	$displayDiv = "display:none;";
	if($epCount >= 1)
	{
		$displayDiv = "display:block;";
	}
	?>
	<div id="eprClose" style="<?php echo $displayDiv; ?>position:absolute;padding-top: 5px; width: 220px;top:31;left:670;z-index:1000;" align="right"><a href="#" onclick="srch_overlayclose('eprdiv'); closeMe(); return false;" class="smalltxt clr1"><img src="offer/close-icon.gif" alt="" border="0" height="12" width="12"></a></div>

	<div id="eprdiv" style="<?php echo $displayDiv; ?>position:absolute;top:30;left:670; background-image: url('offer/hp-vbyidbg.gif');width:225px;height:172px;z-index:101;"><?php echo $eprMessage; ?></div>
	<tr><td class="smalltxt" width="25%">Status</td>
	<td class="smalltxt" colspan="2"><br>
	<?
	//status($eprMessage);?>
	<?php
	$sel .= '<select style="width:180px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt" name=tstatus id=tstatus    onchange="enableField()';

	$sel .= ';">';
	$sel .= '<option value="">--- select ---</option>';
	foreach($paymentoption_followup_status as $key=>$value)
	{
		if(!($epCount >= 1 && $key == 1))
		{
			if ($key == mysql_real_escape_string($_REQUEST['tstatus']))
				$selected = " selected='selected'";
			$sel .='<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
		$selected = "";
	}
	$sel .= '</select>';
	echo $sel;
	
	?>

	</td>
	</tr>
	<tr><td class="smalltxt">&nbsp;</td></tr>
	<tr><td class="smalltxt">Followupdate&nbsp;</td>
	<td class="smalltxt" colspan=4>
	<?
	$date_show=show_date('F',$today);
	$date_show=ereg_replace("name=Fmon>","name=Fmon disabled>",$date_show);
	$date_show=ereg_replace("name=Fday>","name=Fday disabled>",$date_show);
	$date_show=ereg_replace("name=Fyear>","name=Fyear disabled>",$date_show);
	echo $date_show;
	?>
	</td>
	</tr>
   <tr><td>&nbsp;</td><td colspan='2' align='left'>
	<?  include("supportofferPacakage.php"); ?>
   </td></tr>
	<!-- IVR folow starts --->
	<tr><td class="smalltxt" colspan=5 align="right">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" id="view"  style='border: 0px solid #4A84AD;display:none'>
	<?php if ($msg!="") { ?>
	<tr><td align="left" class="smalltxt">&nbsp;Preferred Package</td><td align="left">
	<SELECT NAME="PaymentCategory" class="smalltxt" id="PaymentCategory">
	<OPTION VALUE="0" SELECTED>&nbsp;Select Preferred Package</option>
	<?=$PaymentCategory?>
	</SELECT>
	<?php } ?>
	<INPUT TYPE="hidden" NAME="Countryselected" class="smalltxt" id="Countryselected" value="<?=$ccode?>" >
	<INPUT TYPE="hidden" NAME="ProID" class="smalltxt" id="ProID">
	</td></tr>
	<tr><td align="left" class="smalltxt" width="105">Order-ID</td><td align="left"><input type="text" name="orderId"  ID="orderId"  ReadOnly> 
	<? if($ccode != 98) { ?>
	<!---<INPUT TYPE="checkbox" NAME="CountryselectedNew" value='98' id="CountryselectedNew"> Generate INR Order Id --->
	<?php } ?>
	
	<div id="ordehide" align="left"><a href="javascript:;"
	onClick="orderidAjax('<?=$recdgen['MatriId']?>',document.getElementById('PaymentCategory'),document.getElementById('Countryselected'),document.getElementById('CountryselectedNew'));">Generate Order-ID</a></div></td></tr>
	</table>
	</td></tr>
	<!-- IVR folow ends --->

	<?	if($text != ""){?>
	<tr><td class="smalltxt">Previous Comments</td>
	<td class="smalltxt" colspan=2><textarea cols=50 rows=4 name=prefdesc class="inputtext" readonly><?=$text?>
	</textarea>
	</td></tr><? } ?>
	<tr><td class="smalltxt" colspan=3>&nbsp;</td></tr>
	<tr><td class="smalltxt">Comments</td>
	<td class="smalltxt" colspan=2>
	<textarea cols=50 rows=4 name=fdesc class="inputtext"></textarea></td>
	<input type=hidden value='' name=mail_phone>
	</tr>
	<tr>
	<td align="center" colspan=2 height="35"><input type="submit"  name='Submit' class="button" value="update"></td>
	</tr>
	</table>
	</form>
<?php
	if($_REQUEST[retmess] != "" && $_REQUEST[category] != "1")
	{
		if($_REQUEST[category] == "4" || $_REQUEST[category] == "2")
		{
			if($matriid != $_REQUEST[mtid])
			{
				$cururl = $_SERVER[REQUEST_URI];
				$curpos = strpos($cururl, "&retmess");
				$curlink = substr($cururl, 0, $curpos);
			}
			else
			{
				$backpage = $PAGES[1];
				if($backpage == "")
				{
					$cururl = $_SERVER[REQUEST_URI];
					$curpos = strpos($cururl, "&mtid");
					$curlink = substr($cururl, 0, $curpos);
					$backpage = "<a href='$curlink'>Next</a>";
				}
				else
					$backpage = $PAGES[1];
			}
		}
	}
?>
</td></tr>
</table>
<br>
</td>
</tr>
</table>
<br>
<?php  //} ?>
	<script type="text/javascript" src="../includes/calender.js"></script>
	<script type="text/javascript" src="../includes/calenderJS.js"></script>
	<script type="text/javascript" language="javascript">
	function closeMe()
	{
		document.getElementById('eprClose').style.display = "none";
	}
	</script>
</body>
</html>
<?php
$objSlaveMatri->dbClose();
$objPaysAssMaster->dbClose();

function branchName($branchId)
{
	global $objEPR,$varTable;
	$branchNameArr = array('BranchName');
	$branchCondition = " where BranchId = '".$branchId."'";

	$branchNameRes = $objEPR -> select($varTable['EASYBRANCHDETAILS'],$branchNameArr,$branchCondition,1);

return $branchNameRes[0]['BranchName'];
}
function matchingcount($matriId)
{
	global $objSlaveMatri,$varCbstminterfaceDbInfo,$varTable;
	//$matchQuery = "select MatchingCount from ".$DBNAME['CBSTMINTERFACE'].".".$TABLE['CBSTMMATCHINGCOUNT']." where MatriId='".$matriId."' and DateUpdatedOn >= (curdate()- Interval 3 day)";
	$threeDaysBack = date("Y-m-d",strtotime("-3 days"));
	//$argCondition = " where MatriId='".$matriId."' and DateUpdatedOn >= (curdate()- Interval 3 day)";
	$argCondition = " where MatriId='".$matriId."' and DateUpdatedOn >= '$threeDaysBack'";
	$colArr = array("MatchingCount");
	$matchingCount	= $objSlaveMatri -> select($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMMATCHINGCOUNT'], $colArr, $argCondition,1);


return $matchingCount[0]["MatchingCount"];
}
UNSET($domainInfo);
UNSET($objPaysAssMaster);
UNSET($objSlaveMatri);
?>