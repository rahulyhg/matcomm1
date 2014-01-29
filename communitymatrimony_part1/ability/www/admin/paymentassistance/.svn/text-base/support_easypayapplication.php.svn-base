<?
/* **************************************************************************************************
FILENAME        :support_easypayapplication.php
AUTHOR			:A.Kirubasankar
PROJECT			:Payment Assistance
Start Date		: 15 Oct 2009
End Date		: 26 Aug 2008
DESCRIPTION : to insert  payment ok epr into collection interface
************************************************************************************************* */

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community/ability';

include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/ip.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/conf/domainrates.inc');
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/payment.inc');
include_once($varRootBasePath.'/conf/vars.inc');
include_once("../includes/date_functions.php");
include_once("easypay_arrays.php");


//OBJECT DECLARTION

$objSlaveMatri	= new DB;
$objEPR			= new DB;

//DB Connection
$objEPR -> dbConnect('ODB4',$varDbInfo['EPRDATABASE']);
$objSlaveMatri->dbConnect('S',$varDbInfo['DATABASE']);

$domainInfo = new domainInfo;

$name        = $adminUserName;
$varOfflineCurrency		= array('98'=>'RS.','USD'=>'222','AED'=>'220');

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
$argCondition = " WHERE MatriId = '".db_escape_quotes($_REQUEST['MatriId'])."'";
$getNameRes = $objSlaveMatri -> select($varTable['MEMBERINFO'],$argFields,$argCondition,1);

$Gender = $getNameRes[0]['Gender'];
$Age = $getNameRes[0]['Age'];
$communityId = $getNameRes[0]['CommunityId'];
$tablejoin = "";
//print_r($getNameRes);
if($getNameRes[0]['Phone_Verified'] == 1)
{
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

/*
$varOfflineCurrency		= array('98'=>'RS.','US$'=>'222','AED'=>'220');
$varOfflineCurrencyId	= $varOfflineCurrency[trim(strtoupper(strtolower($_REQUEST["currency"])))];
$varOfflineCurrencyId	= $varOfflineCurrencyId ? $varOfflineCurrencyId : '98';

*/
$varGetPrefix = strtoupper(substr($_REQUEST['MatriId'],0,3));
if (array_key_exists($varGetPrefix, $arrFolderNames)) {
	$varGetFolder = $arrFolderNames[$varGetPrefix];
	$varGetPackage = 'CBS';
}



// INCLUDES //
include_once "/home/product/community/ability/domainslist/$varGetFolder/conf.inc";

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

for($i=1;$i<=9;$i++)
{
	$paymentCategoryValue = $arrCurrCode[$ccode].$arrSegment[$ccode][$i]."-$arrPrdPackages[$i],$i";
	$PaymentCategorynewexp = explode(",",$PaymentCategorynew);
	$paymentCategoryValueexp = explode(",",$paymentCategoryValue);

	if($paymentCategoryValueexp[1] == $PaymentCategorynewexp[1])
	{
		$selected = " SELECTED";
	}
	$PaymentCategory = $PaymentCategory."<option value='$paymentCategoryValue' $selected>$arrCurrCode[$ccode]".$arrSegment[$ccode][$i]."-$arrPrdPackages[$i]</option>";
	$selected = "";
}
//----------------------------------------------------------------------------------------------------



$handingovertocol_exe="";
foreach ($handingover as $key => $value)  {
	$handingovertocol_exe=$handingovertocol_exe."<option value='$key'>$value</option>";
}
$ModeOfPayment="";
foreach ($paymentmode as $key => $value) {
	$ModeOfPayment=$ModeOfPayment."<option value='$key'>$value</option>";
}
$coverage_city="";
/*
asort($city);

foreach ($city as $key => $value) {
	$coverage_city.="<option value='$key'>$value</option>";
}
*/
$coverage_othersate="";
/*
asort($state); 
foreach ($state as $skey => $svalue) {
	$coverage_othersate=$coverage_othersate."<option value='$skey'>$svalue</option>";
}
*/
//variable
$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
$date_show=show_date('F',$today);
$date_show=ereg_replace("name=Fmon>","name=Fmon onChange='appdate(document.frm.Fday.value,document.frm.Fmon.value,document.frm.Fyear.value);'>",$date_show);
$date_show=ereg_replace("name=Fday>","name=Fday onChange='appdate(document.frm.Fday.value,document.frm.Fmon.value,document.frm.Fyear.value);'>",$date_show);
$date_show=ereg_replace("name=Fyear>","name=Fyear onChange='appdate(document.frm.Fday.value,document.frm.Fmon.value,document.frm.Fyear.value);'>",$date_show);
$todate = date("Y-m-d H:i:s");
//show the offer-----------------------------------------------------------------------
		$offer='';
		if(db_escape_quotes($_REQUEST['PaymentCategorynew']) != '') {
	
		if((db_escape_quotes($_REQUEST['disPre']) != '')  && (db_escape_quotes($_REQUEST['disPre']) != 0)){
		 $offer.="DisCount Offer: ".$_REQUEST['disPre']."%\n";
		}
		if(db_escape_quotes($_REQUEST['nextOffer']) != '' && is_array(db_escape_quotes($_REQUEST['nextOffer']))) {
		$offer.="NextLevel Offer: ".$package[$_POST['nextOffer']]['name']."\n";
		}
		/*
		if(is_array($_REQUEST['assured'])) {
		$assnew=$_REQUEST['assured'];
		$offer.="Assured Gift: ";		
		foreach($assnew as $keyass=>$valueass) {
			$offer.=$OFFERGIFTARRAY[$valueass].",";
			}	
		}
	
		else if($_REQUEST['assured']!=''){
		$assnew=db_escape_quotes($_REQUEST['assured']);
		if(count($OFFERGIFTARRAY[$assnew])>4)
		$offer.="Assured Gift: ".$OFFERGIFTARRAY[$assnew];
		}
		else 
		*/	
		if(db_escape_quotes($_REQUEST['ExtPhone']) != '') {
		$offer.="Phone Number:Extra Phone Number";
		}

}
}

//show the offer-----------------------------------------------------------------------	
if(isset($_POST['easySumbit'])) { 

  $redirect = db_escape_quotes($_POST['httpref']);

// from hidden variable fupcomments phoneverify matriid
	$dt=date("Y-m-d");
	$City = db_escape_quotes($_POST['City']);
	$MatriId = db_escape_quotes($_POST['MatriId']);
	$paycat = db_escape_quotes($_POST['PaymentCategory']);
	$Payment_Category1= explode(",",$paycat);
	$Payment_Category = $Payment_Category1[1];

	$Payment_Category = $_REQUEST['PaymentCategory'];
	
	//$packagerate = $package[$Payment_Category][rate];
	$packagerate1 = explode("-",$paycat);
	$packagerate = substr($packagerate1[0],3);
	$AdditionalPackage = db_escape_quotes($_POST['AdditionalPackage']);
	$addonpackagerate = $addonpackage[$AdditionalPackage][rate];
	$discount="Discount offer:" . db_escape_quotes($_POST['discountvalue'])."%,".db_escape_quotes($_POST['discount']);
	$ProfileName=db_escape_quotes($_POST['ProfileName']);
	$ContactName=db_escape_quotes($_POST['ContactName']);
	$ContactDate = db_escape_quotes($_POST['Fyear']) . "-" . db_escape_quotes($_POST['Fmon']) . "-" . db_escape_quotes($_POST['Fday']);
	$dat=date("Y-m-d");
	
	$ContactTime=db_escape_quotes($_POST['ContactTime']) . $_POST['am'];

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
	//Get the domain value
	$domainletter = substr($MatriId,0,1);
		foreach($idstartletterhash as $key => $val){
			if(ucfirst($domainletter) == $val)
				$domainvalue = $key;
		}
		$EntryFrom = 11;



$matriId = db_escape_quotes($_REQUEST['MatriId']);

//$packagerate = db_escape_quotes($_REQUEST['finalAmount']);

$argFields = array('MatriId','PreferredPackage','ProfileName','Gender','Age','ProfileType','ContactName','AppointmentDate','ContactPhone','Address','EMail','Comments','ExecutiveId','BranchId','DocumentToBeCollected','EntryFrom','ContactStatus','ModeofPayment','PrefferedPackageAmount','AssignedDate','OtherCity','AppointmentTime','RequestDate','Domain','RequestedBy','ResidingDistrict');
$currentDate = date("Y-m-d");
$argFieldsValue = array("'".$MatriId."'","'".$Payment_Category."'","'".$ProfileName."'","'".$Gender."'","'".$Age."'","'2'","'".$ContactName."'","'".$ContactDate."'","'".$ContactPhone."'","'".$Address."'","'".$EMail."'","'".$Comments."'","'".$ExecutiveId."'","'".$ExecutiveBranch."'","'".$HandingOver."'","'".$EntryFrom."'","'5'","'".$ModeofPayment."'","$packagerate","'".$todate."'","'".$OtherCity."'","'".$ContactTime."'","'".$currentDate."'","'".$communityId."'","'".$Requestby."'","'".$City."'");

//print_r($argFieldsValue);

$insertvalue = $objEPR -> insert($varTable['EASYPAYINFO'], $argFields, $argFieldsValue);

if($objEPR -> clsErrorCode == "INSERT_ERR")
{
	echo "Database error";
	exit;
}

	if($insertvalue != "")
	{
		echo "<br><br><br><br><table align=center><tr><td>";
		////echo "EPR RequestNo:".$lastReferenceId."<br>";
		echo "EPR RequestNo:".$insertvalue."<br>";
		echo "<a href='$redirect'>Click Here to Move to another Profile</a>";
		echo "</td></tr></table>";
		#header("Location:$redirect");
		exit;
	}
	else
	{
				$qry = "Your last Easy Payment entry for matrimony id <b>[$MatriId]</b>, got failed. ";
				//mail('suresh.a@bharatmatrimony.com','Process failure',$qry);
				//mail('kirubasankar.a@bharatmatrimony.com','Process failure for [$MatriId]',$qry);
				echo "Process Failure"; 
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
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->

a{font-family:Verdana; font-weight:normal;  font-size:12	;text-decoration:none}
</style>
<link href="bmstyle.css" rel="stylesheet" type="text/css" />
<script src="../js/autosuggest.js"></script> 

<script language='javascript'>
function enableprocess(getval){

	if(getval == 1){
		document.getElementById('visiblestate').disabled=true;
		document.getElementById('visiblefreetxt').disabled=true;
		document.getElementById('visibleselect').disabled=false;
		document.getElementById('ViewResult').style.visibility="hidden";
		document.getElementById('headother').style.visibility="hidden";
		document.getElementById('visiblefreetxt').value="";
	}
	else if(getval == 2){
		document.getElementById('visiblestate').disabled=false;
		document.getElementById('visibleselect').disabled=true;
		document.getElementById('visiblefreetxt').disabled=false;
		
	}
 }
 
 function hiddeviewresult() {
document.getElementById('ViewResult').style.visibility="hidden";
document.getElementById('headother').style.visibility="hidden";
document.getElementById('validatedata').style.display = "none";
}
 function getname(n){

document.getElementById('visiblefreetxt').value=n;
document.getElementById('ViewResult').style.visibility="hidden";
document.getElementById('headother').style.visibility="hidden";

}
function validate(){
//For Residing district
 if(document.frm.City.value == 0 && document.getElementById('visibleoption').checked == true){
	alert("select the Residing District");
	document.frm.City.focus();
	return false;
}
if(document.getElementById('visibleoption1').checked == true){
	if(document.frm.otherstxt.value == ""){
	alert("Enter the City Name");
	document.frm.otherstxt.focus();
	return false;
}
	if(document.frm.otehrstate.value==0){
	alert("Enter the State Name");
	document.frm.otehrstate.focus();
	return false;
}
}
//For payment category
if(document.frm.PaymentCategory.value == 0){
	alert("Select the payment category");
	document.frm.PaymentCategory.focus();
	return false;
}
//For contact name
if(document.frm.ContactName.value == ""){
	alert("Enter the contact name");
	document.frm.ContactName.focus();
	return false;
}
	var maxDiff = 3;
	var myDate = new Date;
	var month = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	var selmon = document.frm.Fmon.options[document.frm.Fmon.selectedIndex].text;
	for(var i=0;i<12;i++){		
		if(selmon == month[i])
		var j = i;			
	}
	myDate.setDate(document.frm.Fday.options[document.frm.Fday.selectedIndex].text);
	myDate.setMonth(j); 	
	myDate.setFullYear(document.frm.Fyear.options[document.frm.Fyear.selectedIndex].text); 
	var today = new Date;
	
	today.setHours(0);
	today.setMinutes(0);
	today.setSeconds(0);

	myDate.setHours(0);
	myDate.setMinutes(0);
	myDate.setSeconds(0);

	var mydatenew = myDate.getTime();
	var todaynew = today.getTime();

	var oneday = 60 * 60 * 24;

	todaynew = parseInt(todaynew/(1000 * oneday));
	mydatenew = parseInt(mydatenew/(1000 * oneday));
	maxDiff = maxDiff - 1;

	var realDiff = mydatenew - todaynew;
	if(realDiff < 0 || realDiff > maxDiff)
	{	
		alert('Appointment date should be equal or greater than current date and not exist max of 3 days from today');
		return false;
	}
	/*
return false;
	if(mydatenew < todaynew || threedaysnow < mydatenew){	
		alert('Appointment date should be equal to current date or greater than current date');
		return false;
	}
	*/
//Time validation
if(document.frm.ContactTime.value==""){
	alert("Enter the Time");
	document.frm.ContactTime.focus();
	return false;
}
//For address
if(document.frm.Address.value==""){
	alert("Enter the address");
	document.frm.Address.focus();
	return false;
}
//For modeofpayment
if(document.frm.ModeofPayment.value=="0"){
	alert("Enter the Modeofpayment");
	document.frm.ModeofPayment.focus();
	return false;
}
}
function IsEmpty(obj, obj_type)
{
	if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			return true;
		}
	}
}
</script>
</head>
<body onload="hiddeviewresult()">
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
$curlUrl = "http://wcc.matchintl.com/getdetailsbmtm.php?para=pm";
//$curlUrl = "http://www.communitymatrimony.com/admin/paymentassistance/getdetailsbmtm.php?para=pm";
$modeOfPaymentInfo1 = cbscurl($curlUrl);
$modeOfPaymentInfo2 = explode(":&npn&:",$modeOfPaymentInfo1);

$mop1 = $modeOfPaymentInfo2[1];
$handover1 = $modeOfPaymentInfo2[2];
$resdist1 =  $modeOfPaymentInfo2[3];
$state1 =  $modeOfPaymentInfo2[4];

$mop = json_decode($mop1,true);
$handover = json_decode($handover1,true);
$city =  json_decode($resdist1,true);
$state =  json_decode($state1,true);

$coverage_city = "";
asort($city);
foreach ($city as $key => $value) {
	$coverage_city .=" <option value='$key'>$value</option>";
}
asort($state); 
foreach ($state as $skey => $svalue) {
	$coverage_othersate=$coverage_othersate."<option value='$skey'>$svalue</option>";
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
<INPUT TYPE="text" NAME="otherstxt" id="visiblefreetxt" disabled=true onkeyup="GetResult(this.value)" value="<?=$_POST['otherstxt']?>" class="inputtext"><br>
<div style="LEFT:740px; FLOAT:left;VISIBILITY: visible;POSITION:absolute; TOP: 55px;background-color:#710000;border:1px solid #a0a0a0; width=200px"id="headother"><FONT SIZE="" COLOR="#FFFFFF">Other City List</FONT></div>
<div style="LEFT:740px; FLOAT:left;VISIBILITY: visible;POSITION:absolute; TOP: 75px;background-color:#FFCCCC;border:1px solid #a0a0a0; width=200px" id="ViewResult"></div>
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
<INPUT TYPE="text" NAME="MatriId" class="inputtext" id="MatriId" value="<?=db_escape_quotes($_REQUEST['MatriId'])?>"><!--  <INPUT TYPE="submit" class="txtbx" name="Sumbit" Value="Sumbit"> --> </Div></td>
</tr>
<tr>
<td class="mediumtxt" align="right" >Preferred Package</td><td class="smalltxt">

<SELECT NAME="PaymentCategory" class="select">
<OPTION VALUE="0">Select Preferred Package</option><?=$PaymentCategory?></SELECT>

<?php 

/*
$PaymentCategorynewValue = explode(",",$_REQUEST[PaymentCategorynew]);
echo $PaymentCategorynewValue[0]; 
$PaymentCategorynewValueAmount1 = explode("-",$PaymentCategorynewValue[0]);

$currency1 = substr($PaymentCategorynewValueAmount1[0],0,3);
$preferedAmount = str_replace($currency1,"",$PaymentCategorynewValueAmount1[0]);
*/
//echo "<br> Final anmount - ".$PaymentCategorynewValueAmount1[0];


?>
<input type='hidden' name='finalAmount' value='<?php echo $preferedAmount; ?>'>
<!---<input type='hidden' name='PaymentCategory' value='<?php echo $PaymentCategorynewValue[1]; ?>'> -->

</td>

</tr>
<!---
<tr>
<td class="textsmallnormal">Preferred Addon Package</td><td class="textsmallnormal"><SELECT NAME="AdditionalPackage" class="textsmallnormal" >

<OPTION VALUE="0" SELECTED>Select Addon Pack</option>
<?//$AdditionalPaymentCategory?>
</SELECT></td>

</tr>
--->
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
<td class="mediumtxt" align="right" >Appointment Date & Time(For Payment Collection)</td><td class="mediumtxt"><? echo $date_show;?><BR><br>Time&nbsp;&nbsp;<INPUT TYPE="text" NAME="ContactTime" id="ContactTime"  class="inputtext" size="10" value="<?=$_POST['ContactTime']?>">
<select name="am" class="select" style="width:50px;">
<option value="AM" <?if($_POST['am']=="AM") ECHO "selected";?>>AM</option><option value="PM" <?if($_POST['am']=="PM") ECHO "selected";?>>PM</option></select></td>

</tr>	
<tr>
<td class="mediumtxt" align="right" >Address </td><td><TEXTAREA NAME="Address"  ROWS="3" class="inputtext"><?=$_POST['Address']?></TEXTAREA></td>

</tr>	
<tr>
<td class="mediumtxt" align="right" >E-Mail </td><td><INPUT TYPE="text" NAME="Email"  value="" class="inputtext" value='<?php echo $_REQUEST[Email]; ?>'></td>

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
	$handingovertocol_exe .= "<option value='$handKey'>$handValue</option>";
}
$handingovertocol_exe .= "</select>";
?>
<tr>
<td class="mediumtxt" align="right" >Handing over </td><td>

<!---
<SELECT NAME="HandingOver" class="select" value="<?=$_POST['HandingOver']?>">
<OPTION VALUE="0" SELECTED>Select</OPTION>
--->
<?=$handingovertocol_exe?>
<!---
</SELECT>
--->
</td>

</tr>	
<tr>
<td class="mediumtxt" align="right"  >Mode of Payment</td><td>
<!--
<SELECT NAME="ModeofPayment" class="select">

<OPTION VALUE="0" SELECTED>Select</OPTION>
--->
<?//$ModeOfPayment?>
<?php
$ModeofPaymentCurl .= "<select name='ModeofPayment' class='select'>";
$ModeofPaymentCurl .= "<option value='0' SELECTED>Select</option>";
foreach($mop as $kkey => $vvalue)
{
	$ModeofPaymentCurl .= "<option value='$kkey'>$vvalue</option>";
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
function cbscurl($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
?>