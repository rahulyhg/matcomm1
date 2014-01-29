<?
/* **************************************************************************************************
FILENAME        :support_easypayapplication.php
AUTHOR			:A.Kirubasankar
PROJECT			:Payment Assistance
Start Date		: 15 Oct 2009
End Date		: 26 Aug 2008
DESCRIPTION : to insert  payment ok epr into collection interface
************************************************************************************************* */
#ini_set('display_errors','on');
#error_reporting(E_ALL ^ E_NOTICE);

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';
 
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/ip.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/domainrates.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once("../includes/date_functions.php");
include_once("easypay_arrays.php");

//OBJECT DECLARTION

$objSlaveMatri	= new DB;
$objEPR		= new DB;


//DB Connection
$objEPR -> dbConnect('ODB4',$varDbInfo['EPRDATABASE']);
//print_r($objEPR);
$objSlaveMatri->dbConnect('S',$varDbInfo['DATABASE']);
//print_r($objSlaveMatri);

$domainInfo = new domainInfo;

$name        = $adminUserName;
$varOfflineCurrency		= array('98'=>'RS.','USD'=>'222','AED'=>'220');

$timeRangeFromAndToKey=array("07 AM"=>"07:00:00","08 AM"=>"08:00:00","09 AM"=>"09:00:00","10 AM"=>"10:00:00","11 AM"=>"11:00:00","12 PM"=>"12:00:00","01 PM"=>"13:00:00","02 PM"=>"14:00:00","03 PM"=>"15:00:00","04 PM"=>"16:00:00","05 PM"=>"17:00:00","06 PM"=>"18:00:00","07 PM"=>"19:00:00","08 PM"=>"20:00:00","09 PM"=>"21:00:00","10 PM"=>"22:00:00");

function db_spl_chars_encode($str) 	{
	return htmlentities($str);
}
function db_escape_quotes($value) 	{
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
if(db_escape_quotes($_REQUEST[httpreferrer]) == 1){
if(db_escape_quotes($_REQUEST['Uid']) != "" && db_escape_quotes($_REQUEST['Name']) != ""){
	$uid = trim($_REQUEST['Uid']);
	$uname = trim($_REQUEST['Name']);

}

$argFields = array('Name','Gender','Age','Phone_Verified','Country','CommunityId');
$argCondition = " WHERE MatriId =".$objSlaveMatri->doEscapeString($_REQUEST['MatriId'],$objSlaveMatri)." ";
$getNameRes = $objSlaveMatri -> select($varTable['MEMBERINFO'],$argFields,$argCondition,1);

$Gender = $getNameRes[0]['Gender'];
$Age = $getNameRes[0]['Age'];
$communityId = $getNameRes[0]['CommunityId'];
$tablejoin = "";
//print_r($getNameRes);
if($getNameRes[0]['Phone_Verified'] == 1){
	$assurephoneno = explode('~',$phonenumber);
	$length = count($assurephoneno);
	$assurecon = $assurephoneno[$length-1];
	if($assurecon == ""){
		$assurecon ="NA";
	}
	$tablejoin = '<tr><td class="mediumtxt" align="right" >Assured Contact No </td><td class=textsmallnormal><INPUT TYPE=text NAME=assuredcontact class=textsmallnormal value='.$assurecon.' readonly></td></tr>';
}
elseif($phonenumber != '' && $getNameRes[0]['MobileNo'] != ''){
	$tablejoin = '<tr><td class="mediumtxt" align="right" >Contact Phoned </td><td class=textsmallnormal><INPUT TYPE=text NAME=ContactPhone class=textsmallnormal value='.$phonenumber.' readonly></td></tr><tr><td class="mediumtxt" align="right" >Contact Mobile </td><td class=textsmallnormal><INPUT TYPE=text NAME=ContactMobile class=textsmallnormal value='.$getNameRes[0]['MobileNo'].' readonly></td></tr>';
}
elseif($phonenumber != ''){
	$tablejoin = '<tr><td class="mediumtxt" align="right" >Contact Phone </td><td class=textsmallnormal><INPUT TYPE=text NAME=ContactPhone class=textsmallnormal value='.$phonenumber.' readonly></td></tr>';
}
elseif($getNameRes[0]['MobileNo'] != ''){
	$tablejoin = '<tr><td class="mediumtxt" align="right" >Contact Mobile </td><td class=textsmallnormal><INPUT TYPE=text NAME=ContactMobile class=textsmallnormal value='.$getNameRes[0]['MobileNo'].' readonly></td></tr>';
}

//----------------------------------------------------------------------------------------------------------
$ccode=$getNameRes[0]['Country'];
$PaymentCategory = "";
$PaymentCategorynew = db_escape_quotes($_REQUEST['PaymentCategorynew']);

$varGetPrefix = strtoupper(substr($_REQUEST['MatriId'],0,3));
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

if($arrCurrCode[$ccode] == "" || $arrSegment[$ccode] == "")
	$ccode = 98;

for($i=1;$i<=9;$i++){
	$paymentCategoryValue = $arrCurrCode[$ccode].$arrSegment[$ccode][$i]."-$arrPrdPackages[$i],$i";
	$PaymentCategorynewexp = explode(",",$PaymentCategorynew);
	$paymentCategoryValueexp = explode(",",$paymentCategoryValue);

	//if($paymentCategoryValueexp[1] == $PaymentCategorynewexp[1])
	$expppp = db_escape_quotes($_REQUEST['PaymentCategorynew']);
	if($paymentCategoryValueexp[1] == $expppp)
	{
		$selected = " SELECTED";
	}
	$PaymentCategory = $PaymentCategory."<option value='$paymentCategoryValue' $selected>$arrCurrCode[$ccode]".$arrSegment[$ccode][$i]."-$arrPrdPackages[$i]</option>";
	$selected = "";
}

$handingovertocol_exe="";
foreach ($handingover as $key => $value)  {
	$handingovertocol_exe=$handingovertocol_exe."<option value='$key'>$value</option>";
}
$ModeOfPayment="";
foreach ($paymentmode as $key => $value) {
	$ModeOfPayment=$ModeOfPayment."<option value='$key'>$value</option>";
}
$coverage_city="";
$coverage_othersate="";

//show the offer-----------------------------------------------------------------------
		$offer='';
		if(db_escape_quotes($_REQUEST['PaymentCategorynew']) != '') {

			if((db_escape_quotes($_REQUEST['disPercnt']) != '')  && (db_escape_quotes($_REQUEST['disPercnt']) != 0)){
			 $offer.="DisCount Offer: ".$_REQUEST['disPercnt']."%\n";
			}
			if(db_escape_quotes($_REQUEST['nextLevel']) != '' && is_array(db_escape_quotes($_REQUEST['nextLevel']))) {
			$offer.="NextLevel Offer\n";
			}
			if(db_escape_quotes($_REQUEST['extraPhone']) != '') {
			$offer.="Phone Number:Extra Phone Number\n";
			}
			if(db_escape_quotes($_REQUEST['DiscountAmount'])!= '') {
			$offer.="DiscountAmount :".$_REQUEST['DiscountAmount']."\n";
			}
		}
}



//show the offer-----------------------------------------------------------------------
if(isset($_POST['easySumbit'])) {

	$redirect = db_escape_quotes($_POST['httpref']);
	$eprErrorAlert="";
	$appDatefor=mktime(0,0,0,date(m),date(d)+7,date(Y));
	$selecteAppDateStr=strtotime($_POST['APPTDATE']);
	$dateNow=mktime(0,0,0,date(m),date(d),date(Y));
	$currServerTime=strtotime($_POST['timeOnly']);


	$strfromtime = strtotime(db_escape_quotes($_POST['appfromtime']));
	$strtotime = strtotime(db_escape_quotes($_POST['apptotime']));
	$MatriId =db_escape_quotes(trim($_POST['MatriId']));

	if($_POST['APPTDATE']=="") $eprErrorAlert="Please give valid Appointment time";
	elseif($selecteAppDateStr<$dateNow)	$eprErrorAlert="Please give appointment date from today";
	elseif(($dateNow==$selecteAppDateStr) && ($strfromtime <= $currServerTime)) 
	$eprErrorAlert="The Appointment time must be greater than the current time...";
	elseif($strfromtime > $strtotime)  $eprErrorAlert="Please select a 'to time' that comes after the 'from time' on the same day.";
	elseif($appDatefor<$selecteAppDateStr)	$eprErrorAlert="Max of 7 days can be given for Appointment days";

if($eprErrorAlert=="") {

$eprStatusCondSelect = " where AutoClose=0 and MatriId =".$objEPR->doEscapeString($MatriId,$objEPR)." order by  RequestDate desc limit 1";

$epCount = $objEPR->numOfRecords($varTable['EASYPAYINFO'], 'MatriId', $eprStatusCondSelect);

if($epCount==0) {

	$ContactDate=db_escape_quotes($_POST['APPTDATE'])." ".$_POST['appfromtime'];
	$ContactTime = date("h A",strtotime(db_escape_quotes($_POST['appfromtime']))) . " to " . date("h A",strtotime(db_escape_quotes($_POST['apptotime'])));

	$dt=date("Y-m-d");
	$City = db_escape_quotes($_POST['City']);
	$paycat = db_escape_quotes($_POST['PaymentCategory']);
	$Payment_Category1= explode(",",$paycat);
	$Payment_CategoryID = $Payment_Category1[1];

	$Payment_Category = $_REQUEST['PaymentCategory'];
	$packagerate1 = explode("-",$paycat);
	$packagerate = substr($packagerate1[0],3);
	$AdditionalPackage = db_escape_quotes($_POST['AdditionalPackage']);
	$addonpackagerate = $addonpackage[$AdditionalPackage][rate];
	$discount="Discount offer:" . db_escape_quotes($_POST['discountvalue'])."%,".db_escape_quotes($_POST['discount']);
	$ProfileName=db_escape_quotes($_POST['ProfileName']);
	$ContactName=db_escape_quotes($_POST['ContactName']);


		if($_POST['collectioncont'] != ''){
			$ContactPhone = db_escape_quotes(trim($_POST['collectioncont']));
		}

		if($_POST['assuredcontact'] != ''){
			$ContactMobile=db_escape_quotes(trim($_POST['assuredcontact']));
		}
		elseif($_POST['ContactPhone'] != '') {
			$ContactMobile= db_escape_quotes(trim($_POST['ContactPhone']));
		}
		else if($_POST['ContactMobile'] != '') {
			$ContactMobile= db_escape_quotes(trim($_POST['ContactMobile']));
		}
		else if($_POST['ContactPhone'] != '' &&  $_POST['ContactMobile'] != '') {
			$ContactMobile= db_escape_quotes(trim($_POST['ContactPhone']));
		}

		$Address=db_escape_quotes($_POST['Address']);
		$EMail=db_escape_quotes($_POST['Email']);
		$Requestby = db_escape_quotes($_POST['requestby']);
		//----------------------------------------------------------
		$Commentsnew=db_escape_quotes($_REQUEST['prefdesc']);
		$Commentsoffer=db_escape_quotes($_POST['offerdetails']);
		$Comments=$Commentsoffer."----Tc----".$Commentsnew;
		//---------------------------------------------------------
		$ExecutiveId = db_escape_quotes($_POST['TelecallerId']);
		$ExecutiveName = db_escape_quotes($_POST['TelecallerName']);
		$ExecutiveBranch=5;
		$HandingOver = db_escape_quotes($_POST['HandingOver']);
		$ModeofPayment = db_escape_quotes($_POST['ModeofPayment']);
		if($_POST['City'] == "")  {
		$OtherCity =db_escape_quotes($_POST['otherstxt']);

		$OtherState = db_escape_quotes($_POST['otehrstate']);
		foreach($state_othercity_map as $key=>$value){
			foreach($value as $new_value) {
				if($new_value==$OtherState){
				$City=$key;
					}
				}
			}
		}
		else {
		foreach($cityarraycheck as $key=>$value){
			foreach($value as $newvalue){
			if($newvalue==$City)
			$City=$key;
			}
		}
	}

	 $vararr = $package[$Payment_Category];
	 $vararr1 = $addonpackage[$AdditionalPackage];
		$domainletter = substr($MatriId,0,1);
			foreach($idstartletterhash as $key => $val){
				if(ucfirst($domainletter) == $val)
					$domainvalue = $key;
			}
			$EntryFrom = 11;

	$argFields = array('MatriId','PreferredPackage','ProfileName','Gender','Age','ProfileType','ContactName','AppointmentDate','ContactPhone','Address','EMail','Comments','ExecutiveId','BranchId','DocumentToBeCollected','EntryFrom','ContactStatus','ModeofPayment','PrefferedPackageAmount','AssignedDate','OtherCity','AppointmentTime','RequestDate','Domain','RequestedBy','ResidingDistrict');
	$currentDate = date("Y-m-d H:i:s");
	$argFieldsValue = array($objEPR->doEscapeString($MatriId,$objEPR),$objEPR->doEscapeString($Payment_CategoryID,$objEPR),$objEPR->doEscapeString($ProfileName,$objEPR),$objEPR->doEscapeString($Gender,$objEPR),$objEPR->doEscapeString($Age,$objEPR),"'2'",$objEPR->doEscapeString($ContactName,$objEPR),$objEPR->doEscapeString($ContactDate,$objEPR),$objEPR->doEscapeString($ContactPhone,$objEPR),$objEPR->doEscapeString($Address,$objEPR),$objEPR->doEscapeString($EMail,$objEPR),$objEPR->doEscapeString($Comments,$objEPR),$objEPR->doEscapeString($ExecutiveId,$objEPR),$objEPR->doEscapeString($ExecutiveBranch,$objEPR),$objEPR->doEscapeString($HandingOver,$objEPR),$objEPR->doEscapeString($EntryFrom,$objEPR),"'5'",$objEPR->doEscapeString($ModeofPayment,$objEPR),$objEPR->doEscapeString($packagerate,$objEPR),$objEPR->doEscapeString($todate,$objEPR),$objEPR->doEscapeString($OtherCity,$objEPR),$objEPR->doEscapeString($ContactTime,$objEPR),$objEPR->doEscapeString($currentDate,$objEPR),$objEPR->doEscapeString($communityId,$objEPR),$objEPR->doEscapeString($Requestby,$objEPR),$objEPR->doEscapeString($City,$objEPR));
	$insertvalue = $objEPR ->insert($varTable['EASYPAYINFO'], $argFields, $argFieldsValue);

	 

	if($objEPR -> clsErrorCode == "INSERT_ERR")
	{
		echo "Database error";
		exit;
	}
		 
		$showmsg='';
		if($insertvalue != ""){
				$showmsg = "<tr><td>";
				$showmsg .= "<b>EPR RequestNo:".$insertvalue;
				$showmsg .= "</b></td><td><a href='$redirect'>Click Here to Move to another Profile</a>";
				$showmsg .= "</td></tr>";
		}
		else{
				$showmsg ="<tr><td>";
				$showmsg .= "<b>Your last Easy Payment entry for matrimony id <b>[$MatriId]</b>, got failed. ";
				$showmsg .= "</b></td><td>Process Failure";
				$showmsg .= "</td></tr>";
		}
	} else {
				$showmsg ="<tr><td><b>Already EPR Request exists</b>";
				$showmsg .="</td><td><a href='$redirect'>Click Here to Move to another Profile</a>";
				$showmsg .="</td></tr>";
	}
}
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

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
<title>.:: Easy Payments ::.</title>

<script>
function closefinal(){
window.close();
}
</script>

<style type="text/css">
a{font-family:Verdana; font-weight:normal;  font-size:12	;text-decoration:none}
</style>
<link href="bmstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript"> 
var servDateArray ='<? print date("Y/m/d/H/i/s", time())?>'.split('/');
var currenttime = '<? print date("F d, Y H:i:s", time())?>'
var servyear      = servDateArray[0];
var servmonth     = servDateArray[1];
var servdate      = servDateArray[2];
var servhour      = servDateArray[3];
var nextweekservDateArray ='<? print date("Y/m/d/H/i/s", strtotime("+1 week"))?>'.split('/');
var nextweekservyear      = nextweekservDateArray[0];
var nextweekservmonth     = nextweekservDateArray[1];
var nextweekservdate      = nextweekservDateArray[2];
var nextweekservhour      = nextweekservDateArray[3];
</script>
<script src="http://<?=$communitypath;?>/admin/paymentassistance/js/appcalender.js?ran=12345"></script>
<script src="http://<?=$communitypath;?>/admin/paymentassistance/js/support_easypayapplication.js?ran=12345"></script>
<script src="../includes/autosuggest.js"></script>
<script language="javascript">var imgs_url= 'http://<?php echo $communitypath;?>/admin/paymentassistance';</script>


</head>
<body onload="hiddeviewresult()">
<?if($showmsg!=''){?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<table align='center'><tr><td><table bgcolor='#f7f7f7' border=0 cellpadding=4 cellspacing=4 width=620 align=center style='border:solid 1px #CCCCCC;-moz-border-radius-bottomright: 10px;border-bottom-right-radius: 10px;-moz-border-radius-bottomleft: 10px;border-bottom-left-radius: 10px;-moz-border-radius-topright: 10px;border-top-right-radius: 10px;-moz-border-radius-topright: 10px;border-top-right-radius: 10px;-moz-border-radius-topleft: 10px;border-top-left-radius: 10px;-moz-border-radius: 5px;border-radius: 5px;-moz-box-shadow: 5px 5px 5px #666666;-webkit-box-shadow: 5px 5px 5px #666666;box-shadow: 5px 5px 5px #666666;'>
<?php echo $showmsg;?>
</td></tr></table>
<?php exit; }?>

<table align=center border="0" cellpadding="0" cellspacing="0"  width="780"  style='border: 1px solid #D1D1D1;'>
<tr><td>
<?php
	include("../home/header.php");
?>
</td></tr>
<tr align="right"  class="adminformheader" height="30"><td>TeleCallerId [<?=$name;?>] &nbsp;<a href='index.php' class='textsmallnormal'><B>Home</B></a> &nbsp;&nbsp;</td></tr>
</table>
<?if($rowres['RequestNo'] == ""){?>
<form method="post"  name="frm" onsubmit="return validate();">
<table width=102% border=0 cellspacing=2 bgcolor=#FFFFFF valign=top>
<tr>
<td valign=top>
<input type="hidden" name ="TelecallerId" value="<?=$adminUserName?>">
<input type="hidden" name ="TelecallerName" value="<?=$adminUserName?>">
<table width=100% height=100% border=0 cellspacing=0>
<tr><td valign="top">
<table width="100%"  border="0" cellpadding="2" cellspacing="0">
<tr><td valign="top">
<table width="78%"  border="0" cellpadding="0" cellspacing="2" align="center" bgcolor="#d1d1d1">
<tr><td valign="top">
<div id="colexe"></div>
<table width="100%"  border="0" cellpadding="3" cellspacing="1"  bgcolor="#FFFFFF" >
<tr class="adminformheader"><!-- //#8A0000 -->
<td colspan="2" ><b>Easy Payment</b></font></td>
</tr>
<?php

#curl function on/off call start
	include_once('/home/product/community/www/admin/paymentassistance/support_easypayapplication_curl.php');
#curl function on/off call end

$coverage_city = "";
asort($city);
$coverage_city .=" <optgroup label='- India EPR Citys -'>";
foreach ($city as $key => $value) {
	if($City == $key) $selected = " selected";
	$coverage_city .=" <option value='$key' $selected>$value</option>";
	$selected = "";
}
$coverage_city .=" <optgroup>";
$coverage_city .=" <optgroup label='-OtherCountry  EPR-'>";
foreach($othercountrycity as $key => $value)
{
	if($City == $key) $selected = " selected";
	$coverage_city .=" <option value='$key' $selected>$value</option>";
	$selected = "";
}
$coverage_city .=" <optgroup>";
asort($state);
foreach ($state as $skey => $svalue) {
	if($OtherState == $skey) $selected = " selected";
	$coverage_othersate=$coverage_othersate."<option value='$skey' $selected>$svalue</option>";
	$selected = "";
}
?>
<tr>

<td class="mediumtxt" align="right" width="45%">Residing District
</td>
<td class="mediumtxt" width="55%"><INPUT TYPE="radio" NAME="others" id="visibleoption" onclick="javascript:enableprocess(1)" checked=true>
<!--<SELECT NAME="City" class="select" id="visibleselect" value="<?=$_POST['City']?>"> -->
<SELECT NAME="City" class="select" id="visibleselect">
<!-- <OPTION VALUE=0 SELECTED >Select City for Payment</OPTION> -->
<?=$coverage_city?>
</SELECT>
</td>
</tr>
<tr><td class="mediumtxt" align="right" >Residing District Others</td>
<td><INPUT TYPE="radio" NAME="others" id="visibleoption1" onclick="javascript:enableprocess(2)">
<!-- onkeyup="GetResult(this.value)"  -->
<INPUT TYPE="text" NAME="otherstxt" id="visiblefreetxt" disabled=true onkeyup="GetResult(this.value)" value="<?=$_POST['otherstxt']?>" class="inputtext"><br>
<div style="left:640px; float:left;visibility: visible;position:absolute; top:210px;background-color:#f7f7f7;border:1px solid #a0a0a0; width=200px"id="headother"><FONT SIZE="" COLOR="black">Other City List</FONT></div>
<div style="left:640px; float:left;visibility: visible;position:absolute; top:210px;background-color:#f7f7f7;border:1px solid #a0a0a0; width=220px;" id="ViewResult"></div>
</td></tr>
<tr>
  <td class="mediumtxt" align="right">States for Other City </td>
  <td>
  <SELECT NAME="otehrstate" class="select" id="visiblestate" disabled=true value="<?=$_POST['otehrstate']?>">
<OPTION VALUE=0 SELECTED >Select State for Payment</OPTION>
<?=$coverage_othersate?>
</SELECT>
  </tr>
<tr><td class="mediumtxt" align="right" > Matrimony ID :</td>
<td>
<INPUT TYPE="text" NAME="MatriId" ID='MatriId' class="inputtext" value="<?=trim($_REQUEST['MatriId'])?>" readonly><!--  <INPUT TYPE="submit" class="txtbx" name="Sumbit" Value="Sumbit"> --> </Div></td>
</tr>
<tr>
<td class="mediumtxt" align="right" >Preferred Package</td><td class="smalltxt">

<SELECT NAME="PaymentCategory" class="select">
<OPTION VALUE="0">Select Preferred Package</option><?=$PaymentCategory?></SELECT>
<input type='hidden' name='finalAmount' value='<?php echo $preferedAmount; ?>'>
</td>
</tr>
<tr>
<td class="mediumtxt" align="right" >Profile Name</td><td><INPUT TYPE="text" NAME="ProfileName" value="<?=$getNameRes[0][Name];?>" class="inputtext"></td>
</tr>
<tr>
<td class="mediumtxt" align="right" >Contact Name </td><td><INPUT TYPE="text" NAME="ContactName" class="inputtext" value="<?=$_POST['ContactName']?>"></td>

</tr>
<?php echo $tablejoin;?>
<tr>
<td class="mediumtxt" align="right" >Contact Number for collection </td><td><INPUT TYPE="text" NAME="collectioncont" class="inputtext" value="<?=$_POST['collectioncont']?>"></td>

</tr>
<tr>
<td class="mediumtxt" align="right" >Appointment Date</td><td class="mediumtxt">
<INPUT TYPE='text' NAME='APPTDATE' id="APPTDATE" maxlength='10' style="width:190px;"  value='<?=$_POST['APPTDATE']?>' class='inputtext' readonly='readonly'>
<a href="javascript:NewCssCal('APPTDATE','yyyymmdd');">&nbsp;&nbsp;<img src='http://<?=$communitypath?>/admin/paymentassistance/cal.gif' valign='middle' border='0'></a>
&nbsp; <b>From</b> 
<select name='appfromtime' id='appfromtime' class='inputtext'>
<?php
foreach($timeRangeFromAndToKey as $key=>$value){
if($_POST['appfromtime']==$value) $selected="selected";
else $selected="";
echo "<option value=$value $selected>$key</option>";
}
?>
</select>
&nbsp; <b>to</b>
<select name='apptotime' id='apptotime' class='inputtext'>
<?php
foreach($timeRangeFromAndToKey as $key=>$value){
if($_POST['apptotime']==$value) $selected="selected";
else $selected="";
echo "<option value=$value $selected>$key</option>";
}
?>
</select>
<INPUT TYPE='hidden' NAME='timeOnly' id="timeOnly" value='<? echo date("H").":00:00"; ?>'>
<?php
if($eprErrorAlert !="")
echo "<center><font class='errortxt'>".$eprErrorAlert."</font></center>";
?>
</td>

</tr>
<tr>
<td class="mediumtxt" align="right" >Address </td><td>
<TEXTAREA NAME="Address"  ROWS="3" class="inputtext"><?=$_POST['Address']?></TEXTAREA>
</td>

</tr>
<tr>
<td class="mediumtxt" align="right" >E-Mail </td><td><INPUT TYPE="text" NAME="Email"  value="<?php echo $_REQUEST[Email]; ?>" class="inputtext"></td>

</tr>
<tr>
<td class="mediumtxt" align="right" >Requested By </td><td><INPUT TYPE="text" NAME="requestby" class="inputtext" value="<?=db_escape_quotes($_POST['requestby']);?>" ></td>

</tr>
<tr>
<td class="mediumtxt" align="right" >Offer Details </td><td>
<TEXTAREA NAME="offerdetails" cols="30"  ROWS="3" id="offerdetails" readonly class="inputtext"><?php echo $offer;?></TEXTAREA></td>
</tr>
<tr>
<td class="mediumtxt" align="right" >Comments</td><td class="textsmallnormal"><TEXTAREA NAME="Comments"  ROWS="3" class="inputtext"><?=db_escape_quotes($_REQUEST['prefdesc']);?></TEXTAREA></td>

</tr>

<?php

$handingovertocol_exe = "<select name='HandingOver' class='select'>";
$handingovertocol_exe .= "<option value='0' SELECTED>Select</option>";
foreach($handover as $handKey => $handValue)
{
	if($HandingOver == $handKey) $selected = " selected";
	$handingovertocol_exe .= "<option value='$handKey' $selected>$handValue</option>";
	$selected = "";
}
$handingovertocol_exe .= "</select>";
?>
<tr>
<td class="mediumtxt" align="right" >Handing over </td><td>
<?=$handingovertocol_exe?>
</td>

</tr>
<tr>
<td class="mediumtxt" align="right"  >Mode of Payment</td><td>

<?php
$ModeofPaymentCurl .= "<select name='ModeofPayment' class='select'>";
$ModeofPaymentCurl .= "<option value='0' SELECTED>Select</option>";
foreach($mop as $kkey => $vvalue)
{
	if($ModeofPayment == $kkey) $selected = " selected";
	$ModeofPaymentCurl .= "<option value='$kkey' $selected>$vvalue</option>";
	$selected = "";
}
$ModeofPaymentCurl .= "</select>";
echo $ModeofPaymentCurl;
?>
<!--
</SELECT>
-->
</td><td></td>
<td>
</td></tr>
</tr>
<tr>
<td class="right" colspan="2" align="center" height="45">
<INPUT TYPE="submit" class="button" name="easySumbit" Value="Submit">&nbsp;<INPUT TYPE="reset" class="button" name="Cancel" Value="Cancel"></td>
<td><input type="hidden" name="httpref" value="<?=$_SERVER['HTTP_REFERER']?>"></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<?if(db_escape_quotes($_REQUEST['reqfrom']) == 'nri' && db_escape_quotes($_REQUEST['EntryFrom']) == '8' ){ // adding for NRI?>
<input type="hidden" name="reqfrom" value="<?=db_escape_quotes($_REQUEST['reqfrom']);?>">
<input type="hidden" name="EntryFrom" value="<?=db_escape_quotes($_REQUEST['EntryFrom']);?>">

<?}//adding for NRI
}?>
</FORM>
</body>
</html>
<?php

$objSlaveMatri->dbClose();
$objEPR->dbClose();

function cbscurl($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
?>
