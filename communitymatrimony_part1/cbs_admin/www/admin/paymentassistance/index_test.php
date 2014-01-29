<?php
#====================================================================================================
# Author   : A.Kirubasankar
# Start Date : 08 Oct 2009
# End Date  : 20 Aug 2008
# Module  : Payment Assistance
#====================================================================================================
//BASE PATH
$varRootBasePath = '/home/product/community';
 
//FILE INCLUDES
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/www/admin/paymentassistance/lvars.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/pavar.php');
 
global $adminUserName;
if($adminUserName == "")
 header("Location: ../index.php?act=login");
 
$uname      = $adminUserName;

//OBJECT DECLARTION
$objMaster = new DB;
$objSlave = new DB;
//$objSlaveMatri = new DB;
 
//Connecting communitymatrimony db
//$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);
 
global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];
 
//Conecting cbssupportiface db
$objSlave-> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
$objMaster-> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);
 

//// Vars
global $leadsource,$paymentoption_followup_status;
$OtherISD = $DubaiISDcode+$IndaiISDcode+$UsaISDcode+$AustraliaISDcode+$SingaporeISDcode+$MalaysiaISDcode+$UKISDcode+$CanadaISDcode;
 

//// Supporting Functions
function validchecking($matriid) //return values if matriid is valid.
{
 global $objSlave,$varTable,$varDbInfo;
 
 $args = array('MatriId','Country','Expiry_Date','Paid_Status','CommunityId');
 $argCondition = "WHERE MatriId='".$matriid."'";
// $checkResult = $objSlaveMatri -> select($varTable['MEMBERINFO'],$args,$argCondition,0);
 $checkResult = $objSlave -> select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$args,$argCondition,0);
 
 if($objSlave -> clsErrorCode != "SELECT_ERR")
 {
  $rsltArr = mysql_fetch_assoc($checkResult);
 
  if ($rsltArr[MatriId]=='')  return "0";
  else
    return $returnvariables=$rsltArr[Country]."~".$rsltArr[Paid_Status]."~".$rsltArr[Expiry_Date]."~".$rsltArr[CommunityId];
 }
 else
  return "error";
}
$countSD = count($_REQUEST[domain]);
$countCL = count($_REQUEST[commlang]);
function showDomains()
{
 global $arrPrefixDomainList, $arrMatriIdPre,$countSD,$countCL;
 $arrMatriIdPre1 = array_flip($arrMatriIdPre);
 

 if($countSD <= 0 && $countCL >= 1)
  $disableShowDomain = " disabled='false'";
 else
  $disableShowDomain = " disabled='true'";
// if(count($_REQUEST[domain]) <= 0)
 

 $showDomains .= "<select id='domain' name='domain[]' size='3' multiple class='select' $disableShowDomain>";
 $showDomains .= "<option value='All'";
 if(is_array($_REQUEST[domain]))
 {
  if(in_array("All",$_REQUEST[domain]))
   $showDomains .= " selected ";
 }
 else
 {
  if($key == db_escape_quotes($_REQUEST[domain]))
   $showDomains .= " selected ";
 }
 $showDomains .= "> --- All ---    </option>";
 foreach($arrPrefixDomainList as $key => $value)
 {
  $numKey = $arrMatriIdPre1[$key];
  $showDomains .= "<option value='".$numKey."'";
  if(is_array($_REQUEST[domain]))
  {
   if(in_array($numKey,$_REQUEST[domain]))
    $showDomains .= " selected ";
  }
  else
  {
   if($key == db_escape_quotes($_REQUEST[domain]))
    $showDomains .= " selected ";
  }
  $showDomains .= ">$value</option>";
 }
 $showDomains .= "</select>";
return $showDomains;
}
 
function showCommLang($value)
{ 
 global $paLanguageKeys;
 if($value==1) {
	$commlangName="name='commlang'";
 }
 else {
	$commlangName="name='commlang[]'";
 }
 $countCL = count($_REQUEST[commlang]);
 if($countCL <= 0)
  $disableCommLang = " disabled='true'";
 $showCommLang .= "<select id='commlang' $commlangName size='3' style='width:200px;' multiple class='select' style='width:80px;' $disableCommLang>";
 foreach($paLanguageKeys as $key => $value)
 {
  if(in_array($key,$_REQUEST[commlang]))
   $selected = " selected='selected'";
  $showCommLang .= "<option value='$key' $selected>$value</option>";
  $selected = "";
 }
 $showCommLang .= "</select>";
return $showCommLang;
}
function fromdate_todate_payment($formname)
{
 if($formname == "failureoption")
 {
  $fromDateValue = db_escape_quotes($_REQUEST['fromdate3']);
  if($fromDateValue == "")
   $fromDateValue = date("Y-m-d",time());
  $toDateValue = db_escape_quotes($_REQUEST['todate3']);
  if($toDateValue == "")
   $toDateValue = date("Y-m-d",time());
  $fromdate_todate_payment = '<td align="center" class="smalltxt">From Date:</td><td><input type="text" name="fromdate3"  value="'.$fromDateValue.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'fromdate3\', \'\', \'ymd\', \'-\');"  HIDEFOCUS></td><td nowrap="nowrap" class="smalltxt">To Date:</td><td>';
  $fromdate_todate_payment .= '<input type="text" name="todate3"  value="'.$toDateValue.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'todate3\', \'\', \'ymd\', \'-\');"  HIDEFOCUS>';
  $fromdate_todate_payment .= '</td>';
 }
 if($formname == "form2")
 {
  $fromDateValue = db_escape_quotes($_REQUEST['fromdate']);
  if($fromDateValue == "")
   $fromDateValue = date("Y-m-d",time());
  $toDateValue = db_escape_quotes($_REQUEST['todate']);
  if($toDateValue == "")
   $toDateValue = date("Y-m-d",time());
  $fromdate_todate_payment = '<td align="center" class="smalltxt">From Date:</td><td><input type="text" name="fromdate"  value="'.$fromDateValue.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'fromdate\', \'\', \'ymd\', \'-\');"  HIDEFOCUS></td><td class="smalltxt"  nowrap="nowrap">To Date:</td><td>';
  $fromdate_todate_payment .= '<input type="text" name="todate"  nowrap="nowrap" value="'.$toDateValue.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'todate\', \'\', \'ymd\', \'-\');"  HIDEFOCUS>';
  $fromdate_todate_payment .= '</td>';
 }
 if($formname == "form3")
 {
  $fromDateValue1 = db_escape_quotes($_REQUEST['fromdate1']);
  if($fromDateValue1 == "")
   $fromDateValue1 = date("Y-m-d",time());
  $toDateValue1 = db_escape_quotes($_REQUEST['todate1']);
  if($toDateValue1 == "")
   $toDateValue1 = date("Y-m-d",time());
  $fromdate_todate_payment = '<td align="right" class="smalltxt">From Date:</td><td>';
  $fromdate_todate_payment .= '<input type="text" name="fromdate1"  value="'.$fromDateValue1.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'fromdate1\', \'\', \'ymd\', \'-\');"  HIDEFOCUS></td><td nowrap="nowrap">To Date:</td><td><input type="text" name="todate1"  value="'.$toDateValue1.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'todate1\', \'\', \'ymd\', \'-\');"  HIDEFOCUS>';
  $fromdate_todate_payment .= '</td>';
 }
 if($formname == "form4")
 {
  $fromDateValues = date("Y-m-d");
  $fromdate_todate_payment = '<td align="right" class="smalltxt">From Date:<br><br>To Date:</td><td>';
  $fromdate_todate_payment .= '<input type="text" name="fromdate2" id="fromdate2"  value="'.$fromDateValues.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'fromdate2\', \'\', \'ymd\', \'-\');"  HIDEFOCUS><br><br><input type="text" name="todate2" id="todate2" value="'.$fromDateValues.'" readonly style="width:120px;" class=\'inputtext\' onclick="displayDatePicker(\'todate2\', \'\', \'ymd\', \'-\');"  HIDEFOCUS>';
  $fromdate_todate_payment .= '</td>';
 }
echo $fromdate_todate_payment;
}
function status()
{
 global $paymentoption_followup_status;
 $sel .= '<select style="width:260px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt" name=tstatus id=tstatus>';
 $sel .= '<option value="">--- select ---</option>';
 foreach($paymentoption_followup_status as $key=>$value)
 {
  if ($key == db_escape_quotes($_REQUEST['tstatus']))
   $selected = " selected='selected'";
  $sel .='<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
  $selected = "";
 }
 $sel .= '</select>';
return $sel;
}
 
function getLead()
{
 global $leadsource;
 $leadtype .="<option value=''>Select</option>";
 while(list($key, $val) = each($leadsource))
 {
  if($key > 3)
  {
   $leadtype .="<option value=".$key.">".$val."</option>";
  }
 }
return $leadtype;
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
 
function db_spl_chars_encode($str)
{
 return htmlentities($str);
}
 
function getDateDiff($dformat,$endDate, $beginDate)
{
 $date_parts1=explode($dformat, $beginDate);
 $date_parts2=explode($dformat, $endDate);
 $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
 $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
 return $end_date - $start_date;
}
 
if(($_REQUEST['submit2']) || ($_REQUEST['submit3']) || ($_REQUEST['failuresubmit']) )
{
 $category = $_REQUEST['linkstat'];
 $domain = $_REQUEST['domain'];
 $validated = $_REQUEST['validated'];
// $topFiftyDomains = explode(",",$_REQUEST['topFiftyDomains']);
 
 if($_REQUEST['submit2'] != "")
  $fdate = $_REQUEST['fromdate'];
 if($_REQUEST['submit3'] != "")
  $fdate = $_REQUEST['fromdate1'];
 if($_REQUEST['failuresubmit'] != "") {
  $fdate = $_REQUEST['fromdate3'];
  $tdate =   $_REQUEST['todate3'];
 }
 
 if($_REQUEST['submit2'] != "")
  $tdate =   $_REQUEST['todate'];
 if($_REQUEST['submit3'] != "")
  $tdate =   $_REQUEST['todate1'];   
 
 $ts = $_REQUEST['tstatus'];
 $leadsources = $_REQUEST['lesource'];
 $countycode = $_REQUEST['countycode'];
 $registered=$_REQUEST['registered'];
 
 $applang='';
 if(is_array($domain))
 {
  if(!in_array("All",$domain))
  {
   $applang.= " AND (";
   foreach($domain as $k => $v)
   {
    if($k!=0)
     $applang.= " OR ";
    $applang.= "CommunityId = ".$v."";
   }
   $applang.= ")";
  }
 }
 
 if($_REQUEST[commlang] != "")
 {
  $commLangCond = " and (";
  $commLangArr=$_REQUEST[commlang];
echo $commLangArr;
  if(!is_array($_REQUEST[commlang])) {
	  $commLangArr=explode('&',$_REQUEST[commlang]);
  }
  
  foreach($commLangArr as $clKey => $clValue)
  {
   $commLangCond .= " MotherTongueGrouping = $clValue or ";
  }
  $commLangCond = substr($commLangCond,0,strlen($commLangCond)-4);
  $commLangCond .= ")";
 }

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
 
 $arrayAddNew=array(1,15);
 if(is_array($leadsources))
 {
  if(in_array(2,$leadsources)) $leadsources=array_merge($leadsources,$arrayAddNew);
 
  if(!in_array("All",$leadsources)) 
  {
   $applang.= " AND (";
   foreach($leadsources as $kl => $vl)
   {
    if($kl!=0)
     $applang.= " OR ";
    $applang.= "LeadSource='".$vl."'";
   }
   $applang.= ")";
  }
 }
else if(!is_array($leadsources) && $leadsources != 'All')
 {
	$leadsources=explode('&',$leadsources);

  if(in_array(2,$leadsources)) $leadsources=array_merge($leadsources,$arrayAddNew);
 
  if(!in_array("All",$leadsources)) 
  {
   $applang.= " AND (";
   foreach($leadsources as $kl => $vl)
   {
    if($kl!=0)
     $applang.= " OR ";
    $applang.= "LeadSource='".$vl."'";
   }
   $applang.= ")";
  }
 }
 else if($leadsources!='All')
 {
  $applang.= " AND LeadSource=".$leadsources."";
 }

#Country Code filter----------------------------------------------------
 if(is_array($countycode))
 {
  if(in_array('03',$countycode))
  {
   $code=implode(",",$OtherISD);
   $applang.=" AND CountryCode NOT in(".$code.")";
  }
  else if(!in_array('0',$countycode))
  {
   $comma = "";
   if(in_array('91',$countycode)) {
    $code = implode(",",$IndaiISDcode);
    $comma = ",";
   }
   if(in_array('01',$countycode)){
    $code .= $comma.implode(",",$UsaISDcode);
    $comma = ",";
   }
   if(in_array('02',$countycode)){
    $code .= $comma.implode(",",$DubaiISDcode);
    $comma = ",";
   }
   if(in_array('04',$countycode)){
    $code .= $comma.implode(",",$AustraliaISDcode);
    $comma = ",";
   }
   if(in_array('05',$countycode)){
    $code .= $comma.implode(",",$SingaporeISDcode);
    $comma = ",";
   }
   if(in_array('06',$countycode)){
    $code .= $comma.implode(",",$MalaysiaISDcode);
    $comma = ",";
   }
   if(in_array('07',$countycode)){
    $code .= $comma.implode(",",$UKISDcode);
    $comma = ",";
   }
   if(in_array('08',$countycode)){
    $code .= $comma.implode(",",$CanadaISDcode);
   }
   $applang.=" AND CountryCode in(".$code.")";
  }
 }
 else
 {
  if($countycode=='03')
  {
   $code=implode(",",$OtherISD);
   $applang.=" AND CountryCode NOT in(".$code.")";
  }
  else if(($countycode!="0") && ($countycode!=""))
  {
   if($countycode=='91') {
    $ISDCodeArrName = "IndaiISDcode";
   } else if($countycode=='01'){
    $ISDCodeArrName = "UsaISDcode";
   } else if($countycode=='02'){
    $ISDCodeArrName = "DubaiISDcode";
   } else if($countycode=='04'){
    $ISDCodeArrName = "AustraliaISDcode";
   } else if($countycode=='05'){
    $ISDCodeArrName = "SingaporeISDcode";
   } else if($countycode=='06'){
    $ISDCodeArrName = "MalaysiaISDcode";
   } else if($countycode=='07'){
    $ISDCodeArrName = "UKISDcode";
   } else if($countycode=='08'){
    $ISDCodeArrName = "CanadaISDcode";
   }
   $code=implode(",",$$ISDCodeArrName);
   $applang.=" AND CountryCode in(".$code.")";
  }
 }
 
    switch($registered)
 {
  case "CBS":
   $commReg = " and BM_MatriId = '' ";
   break;
  case "BM";
   $commReg = " and BM_MatriId <> '' ";
   break;
  default:
   $commReg = "";
   break;
 }
 if($validated != "")
 {
  $validatedQuery = " and Publish = 1";
  $validatedRedirect = "&validated=1";
 }
 else
 {
  $validatedQuery = " and Publish = 0";
  $validatedRedirect = "&validated=0";
 }
 if($category=="1")
 {
  if($fdate != "" && $tdate!=""){$qurydate= " and  FreshlyAddedOn>='".$fdate." 00:00:00' and FreshlyAddedOn<='".$tdate." 23:59:59' ";}
  else { $qurydate= "";}
  $lable =	"Total FreshProfiles:";
  $argFields = array('MatriId as cnt');
 
$time10diff = mktime(date("H"),date("i")-15,date("s"),date(m),date(d),date(Y));
$date10diff1=date("Y-m-d H:i:s",$time10diff);
//// After Suresh recommendations
 echo $argCondition = " where (SupportUserName='' or SupportUserName='".$adminUserName."')  and Followupstatus=0 and LockTime < '".$date10diff1."' and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or (EntryType=0)) ".$qurydate." ".$applang." ".$commLangCond." ".$commReg;
 //exit;
 }
 if($category == "2")
 {
  if($fdate != "" && $tdate!="")
  {
   $qurydate= " and FollowupDate>='".$fdate."' and FollowupDate<='".$tdate."'";
   }
  else { $qurydate= "";}
  $lable ="Total Followupprofiles:";
  $argFields = array('MatriId as cnt');
  
 
 ////After Suresh recommendation
 if($ts != "")
  $followupStatusQ = " and FollowupStatus=$ts ";
  $argCondition = " where SupportUserName='".$adminUserName."' $followupStatusQ ". $applang." and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or (EntryType=0))".$qurydate." ".$commLangCond." ".$commReg;
 
 }
 $argCondition = $argCondition." ".$validatedQuery;
 
 //echo "Query - ".$argCondition;
 $trec = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'], 'MatriId', $argCondition);
 if($objSlave -> clsErrorCode != "CNT_ERR")
 {
	 //$trec=2;
  if($trec>0)
  {
   $countycode = implode("~",$countycode);
   if($_REQUEST[domain] == 'All') {
	} else {
		$domain = implode("~",$domain);
	}
   
   if(!is_array($_REQUEST[lesource])) {
	if($_REQUEST[lesource] == 'All') {
	} else {		
		$leadsources = str_replace('&','~',$_REQUEST[lesource]);
	}
   }
   else {
	$leadsources = implode("~",$leadsources);
   }
   
   if(!is_array($_REQUEST[commlang])) {
		$commlang = str_replace('&','~',$_REQUEST[commlang]);
   }
   else {
	$commlang = implode("~",$_REQUEST[commlang]);
   }
   
//   $topFiftyDomains = implode("~",$_REQUEST['topFiftyDomains']);
 
   //$countdisp ="<a href='supportcheckstatus.php?category=".$category."&fdate=".$fdate."&tdate=".$tdate."&language=".$domain."&ts=".$ts."&leso=".$leadsources."&country=".$countycode."&commlang=$commlang' style='text-decoration:underline;'><b>".$trec."</b></a>";
   //$countdisp = "supportcheckstatus.php?category=".$category."&fdate=".$fdate."&tdate=".$tdate."&language=".$domain."&ts=".$ts."&leso=".$leadsources."&country=".$countycode."&commlang=$commlang&regt=".$registered."&topFiftyDomains=".$topFiftyDomains;
   //$countdisp = "supportcheckstatus.php?category=".$category."&fdate=".$fdate."&tdate=".$tdate."&language=".$domain."&ts=".$ts."&leso=".$leadsources."&country=".$countycode."&commlang=$commlang&regt=".$registered."&topFiftySwitch=".$_REQUEST['topFiftySwitch']."&topFiftySwitch1=".$_REQUEST['topFiftySwitch1'];
   
   if($_REQUEST['failuresubmit'] != "") {
   $countdisp = "supportcheckstatus_test.php?category=".$category."&fdate=".$fdate."&tdate=".$tdate."&leso=".$leadsources;
   }
   else {
    $countdisp = "supportcheckstatus_test.php?category=".$category."&fdate=".$fdate."&tdate=".$tdate."&language=".$domain."&ts=".$ts."&leso=".$leadsources."&country=".$countycode."&commlang=$commlang&regt=".$registered."&topFiftySwitch=".$_REQUEST['topFiftySwitch']."&topFiftySwitch1=".$_REQUEST['topFiftySwitch1'].$validatedRedirect;
   }
   header("Location: $countdisp");
  }
  else
  {
   $countdisp = 0;
  }
 }
 else
  $countdisp =  "DB Error.";
 
 $html = '<div id="countdisp"><table width="100%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1" style="border:solid 1px #d1d1d1;">
 <tr class="rowlightbrown normaltxt1"><td colspan=2 align="right" width="50%"><b>'.$lable.'</b></td><td colspan=2 align="left"><b>'.$countdisp.'</b></td>
 </tr></table></div>';
}
 
if($_REQUEST['submit1'] == "submit")
{
 #GET VALUES#
 $matriId = db_escape_quotes($_REQUEST['id']);
 $leadSourcetxt = db_escape_quotes($_REQUEST['source']);
 $queueId = db_escape_quotes($_REQUEST['queueid']);
 $callerId = db_escape_quotes($_REQUEST['callerid']);
 $returnvalid = validchecking($matriId);
 if($returnvalid == "error")
 {
  $showmsg = "Error - ".mysql_error();
 }
 else if($returnvalid != 0)
 {
  $explodeReturn=explode("~",$returnvalid);
  $country = $explodeReturn[0];
  $communityId = $explodeReturn[3];
////Country codes has to be take n from assusredcontact or assuredcontactbeforevalidation tables.
 
   $countryyycode =  $arrIsdCountryCode[$country];
  
   $argPhoneField = array('CountryCode','PhoneNo','MobileNo','PhoneNo1','AreaCode');
   $argPhoneCondition = " WHERE MatriId = '$matriId'";
   //$phoneResult = $objSlaveMatri -> select($varTable['ASSUREDCONTACT'],$argPhoneField,$argPhoneCondition,1);
   $phoneResult = $objSlave -> select($varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'],$argPhoneField,$argPhoneCondition,1);
 
   if($objSlave ->  clsErrorCode != "SELECT_ERR")
   {
    if($phoneNo == "")
     $phoneNo = $phoneResult[0]['PhoneNo'];
    if($mobileNo == "")
     $mobileNo = $phoneResult[0]['MobileNo'];
    if($assuredNo == "")
     $assuredNo = $phoneResult[0]['PhoneNo1'];
    if($areaCode == "")
    {
     $areaCode = $phoneResult[0]['AreaCode'];
     if($areaCode == "")
     {
      $assuredNo1 = explode("~",$assuredNo);
      if(count($assuredNo1) == 3)
      {
       $areaCode = $assuredNo1[1];
      }
     }
    }
    if($countryyycode == "")
    {
     $countryyycode = $phoneResult[0]['CountryCode'];
    }
   }
   else
   {
    echo "Database Error - ";
    exit;
   }
  
  
   $argPhoneField = array('CountryCode','PhoneNo','MobileNo','PhoneNo1','AreaCode');
   $argPhoneCondition = " WHERE MatriId = '$matriId'";
   $phoneResult = $objSlave -> select($varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argPhoneField,$argPhoneCondition,1);
 
   if($objSlave ->  clsErrorCode != "SELECT_ERR")
   {
    if($phoneNo == "")
     $phoneNo = $phoneResult[0]['PhoneNo'];
    if($mobileNo == "")
     $mobileNo = $phoneResult[0]['MobileNo'];
    if($assuredNo == "")
     $assuredNo = $phoneResult[0]['PhoneNo1'];
    if($areaCode == "")
    {
     $areaCode = $phoneResult[0]['AreaCode'];
     if($areaCode == "")
     {
      $assuredNo1 = explode("~",$assuredNo);
      if(count($assuredNo1) == 3)
      {
       $areaCode = $assuredNo1[1];
      }
     }
    }
    if($countryyycode == "")
    {
     $countryyycode = $phoneResult[0]['CountryCode'];
    }
   }
   else
   {
    echo "Database Error - ";
    exit;
   }
 
  if($countryyycode == "")
  {
   //$countryyycode =  $arrIsdCountryCode[$country];
   /*
   $argCounty = array('Country');
   $argCountryCondition = " WHERE MatriId = '$matriId'";
   $countryResult = $objSlaveMatri -> select($varTable['MEMBERINFO'],$argCounty,$argCountryCondition,1);
   $countryyycode =  $arrIsdCountryCode[$countryResult[0][Country]];
   */
  }
  $Paid_Status = $explodeReturn[1];
  $expiryDateTime = $explodeReturn[2];
  $expiryExp=explode(" ",$expiryDateTime);
  $expiryDate=$expiryExp[0];
  $curDate = date("Y-m-d");
  $curTime = date("H:i:s");
  $curdatetime = $curDate." ".$curTime;
  $dateDff = getDateDiff("-",$expiryDate,$curDate);
 
  $firstThree = substr($matriId,0,3);
  $arrMatriIdPre1 = array_flip($arrMatriIdPre);
  $communityId = $arrMatriIdPre1[$firstThree];
 
  if(($Paid_Status == 1 && ($dateDff >=0 && $dateDff <=10)) || ($Paid_Status == '0'))
  {
   // Setting domain id in Language column of cbssupportiface.paymentoptions table
   $first3 = substr($matriId,0,3);
   $arrMatriIdPre1 = array_flip($arrMatriIdPre);
   $language = $arrMatriIdPre1[$first3];
 
   //// Check matrimony if already exists in paymentoptions table.
   $args = array('MatriId');
   $argCondition = " WHERE MatriId = '".$matriId."'";
   $checkNum = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition);
 
   //if($checkNum = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONS'],'MatriId',$argCondition))
   if($objSlave -> clsErrorCode != "CNT_ERR")
   {
    if($checkNum > 0)
    {
     //// Update Query
     //$argFields = array('DateUpdated','Country','LeadSource','QueueId','CallerId','SupportUserName','Language','CountryCode','PaymentDate','FollowupStatus');
     //$argFieldsValues = array("'".$curdatetime."'","'".$country."'","'".$leadSourcetxt."'","'".$queueId."'","'".$callerId."'","'".$adminUserName."'","'".$language."'","'".$countryyycode."'","'0000-00-00 00:00:00'",'0');
 
     /*
      $argFields = array('DateUpdated','Country','LeadSource','QueueId','CallerId','SupportUserName','CountryCode','PaymentDate','FollowupStatus','PhoneNo','MobileNo','CommunityId','AreaCode');
      $argFieldsValues = array("'".$curdatetime."'","'".$country."'","'".$leadSourcetxt."'","'".$queueId."'","'".$callerId."'","'".$adminUserName."'","'".$countryyycode."'","'0000-00-00 00:00:00'",'0',"'".$phoneNo."'","'".$mobileNo."'","'".$communityId."'","'".$areaCode."'");
 
      $argCondition = " MatriId = '".$matriId."'";
     
      if($numUpdated = $objMaster->update($varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition))
      {
       if($numUpdated >= 1)
        $showmsg = 1;
       else
        $showmsg = "No rows affected while updating for Matrimony Id <b>[$matriId]</b>.";
      }
      else
       $showmsg = "Error - ".$objMaster -> clsErrorCode;
     */
     $suppUserNameArr = array('SupportUserName');
     $suppUserNameCond = " where MatriId = '$matriId'";
     $suppUserName = $objSlave -> select($varTable['PAYMENTOPTIONS'],$suppUserNameArr,$suppUserNameCond,1);
     if($objSlave -> clsErrorCode == "SELECT_ERR")
      $showmsg = "Error Retrieving Support username";
     else
     {
      $showmsg = "Profile already exists <b>[$matriId]</b>";
      if($suppUserName[0]['SupportUserName'] != "")
      {
       $showmsg .= " under  <b>".ucfirst($suppUserName[0]['SupportUserName'])."</b>";
      }
     }
    }
    else
    {
     //// Insert Query
     //$argFields = array('MatriId','DateSelected','Country','LeadSource','QueueId','CallerId','SupportUserName','Language','CountryCode');
     //$argFieldsValue = array("'".$matriId."'","'".$curdatetime."'","'".$country."'","'".$leadSourcetxt."'","'".$queueId."'","'".$callerId."'","'".$adminUserName."'","'".$language."'","'".$countryyycode."'");
	 
	$MotherTongueGrouping = 0;
	foreach($paCommLanguage as $paCommLanguageKey=>$paCommLanguageValue) {
		foreach($paCommLanguageValue as $motherIdKey=>$motherIdValue) {							
			if($motherIdValue == $communityId) {								
				foreach($paLanguageKeys as $LanguageKey => $LanguageValue) {					
						if($LanguageValue == $paCommLanguageKey) {
						$MotherTongueGrouping = $LanguageKey;
					}
				}
			}
		}
	}
	 	
	foreach($top50DomainsArr as $top50IdKey=>$top50IdValue) {
		if($top50IdKey == $communityId) {
			$TopFiftyGrouping = 1;
		}
	}

     $argFields = array('MatriId','FreshlyAddedOn','Country','LeadSource','QueueId','CallerId','SupportUserName','CountryCode','DateUpdated','PhoneNo','MobileNo','CommunityId','AreaCode','TopFiftyGrouping','MotherTongueGrouping');
     $argFieldsValue = array("'".$matriId."'","'".$curdatetime."'","'".$country."'","'".$leadSourcetxt."'","'".$queueId."'","'".$callerId."'","'".$adminUserName."'","'".$countryyycode."'","'0000-00-00 00:00:00'","'".$phoneNo."'","'".$mobileNo."'","'".$communityId."'","'".$areaCode."'","'".$TopFiftyGrouping."'","'".$MotherTongueGrouping."'");
 
     $numInserted = $objMaster -> insert($varTable['PAYMENTOPTIONS'], $argFields, $argFieldsValue);
     if($objMaster -> clsErrorCode != "INSERT_ERR")
     {
       $showmsg = 2;
     }
     else
     {
      $showmsg = "Error - ".$objMaster -> clsErrorCode;
     }
    }
   }
   else
    $showmsg = "Error - ".$objSlave -> clsErrorCode;
  }
  else
   $showmsg = 4;
 }
 else
  $showmsg = 3;
 $leadsourceValue = $leadsource[$leadSourcetxt];
 switch($showmsg)
 {
  case 1:
   $displayMsg = "<font color='148E22'>Lead <b>[$leadsourceValue]</b> successfully updated for Matrimony Id <b>[$matriId]</b>.  </font>";
   break;
  case 2:
   $displayMsg = "<font color='148E22'>Lead <b>[$leadsourceValue]</b> successfully entered for Matrimony Id <b>[$matriId]</b>.  </font>";
   break;
  case 3:
   $displayMsg = "<font color='E01427'>Matrimony Id <b>[$matriId]</b> is In-Valid.</font>";
   break;
  case 4:
   $displayMsg = "<font color='E01427'>Matrimony Id <b>[$matriId]</b> is a paid member. Cant update Leads again.</font>";
   break;
  case CNT_ERR:
   $displayMsg = "<font color='E01427'>Database Error .</font>";
   break;
  case INSERT_ERR:
   $displayMsg = "<font color='E01427'>Database Error - while inserting for Matrimony Id <b>[$matriId]</b>.</font>";
   break;
  case UPDATE_ERR:
   $displayMsg = "<font color='E01427'>Database Error - while updating for Matrimony Id <b>[$matriId]</b>.</font>";
   break;
  default:
   $displayMsg = "$showmsg .";
 }
 //$headerPara = 'location: successleadmsg.php?task='.$showmsg.'&mid='.$matriId;
 //header($headerPara);
}
 
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
<title>Payment</title>
<SCRIPT type="text/javascript" src="../includes/calender.js"></script>
<SCRIPT language="javascript" type="text/javascript">
function failure_func()
{
 var failval = document.getElementById('lesource');
 if(!failval.checked) {
  alert("Please select the option");
  return false;
 }
}
</script>
<SCRIPT type="text/javascript" src="../includes/calenderJS.js"></script>
 
<script language="javascript" type="text/javascript">
 

function createRequestObject(){
 var request_o; //declare the variable to hold the object.
 var browser = navigator.appName; //find the browser name
 if(browser == "Microsoft Internet Explorer"){
  /* Create the object using MSIE's method */
  request_o = new ActiveXObject("Microsoft.XMLHTTP");
 }else{
  /* Create the object using other browser's method */
  request_o = new XMLHttpRequest();
 }
 return request_o; //return the object
}
 

var http = createRequestObject();
 
 
 

function hidephone(leadstat)
{
 if(leadstat=='4')
 {
  document.getElementById("showcaller").style.display = "inline";
  document.getElementById("showqueue").style.display = "inline";
 }
 else if(leadstat=='5')
 {
  document.getElementById("showcaller").style.display = "inline";
  document.getElementById("showqueue").style.display = "none";
 }
 else
 {
  document.getElementById("showcaller").style.display = "none";
  document.getElementById("showqueue").style.display = "none";
 }
}
function freshprofile(linkvalue,count)
{
 if(linkvalue == 1)
 {
  document.getElementById('freshprofile').style.display="";
  document.getElementById('followup').style.display="none";
  document.getElementById('eprdiv').style.display = "none";
  document.getElementById("eprResult").style.display = "none";
  //document.getElementById(count).style.display="none";
 }
 if(linkvalue == 2)
 {
  document.getElementById('freshprofile').style.display="none";
  document.getElementById('followup').style.display="";
  document.getElementById('eprdiv').style.display = "none";
  document.getElementById("eprResult").style.display = "none";
  //document.getElementById(count).style.display="none";
 }
}
 function validate_required(field,alerttxt){
     with (field){
      if (value==null||value=="") {alert(alerttxt);return false;
   }else {return true;
   }
     }
   }
function validate_form(thisform)
{
   with (thisform)
   {
  if (name=="form1")
  {
   if (validate_required(id,"Matrimony id field must be filled!")==false)
   {
    id.focus();
    return false;
   }
   else if(validate_required(source,"Lead Source field must be Selected !")==false)
   {
    source.focus();
    return false;
   }
   if(document.getElementById('showqueue').style.display != "none")
   {
    if(isNaN(document.getElementById('queueid').value) == true || document.getElementById('queueid').value.length > 6)
    {
     alert("In-Valid Queue Id !!");
     document.getElementById('queueid').focus();
     return false;
    }
   }
   if(document.getElementById('showcaller').style.display != "none")
   {
    if(isNaN(document.getElementById('callerid').value) == true || document.getElementById('callerid').value.length > 20)
    {
     alert("In-Valid Caller Id !!");
     document.getElementById('callerid').focus();
     return false;
    }
   }
  }
 }
}
function viewbyid()
{
 document.getElementById("vubymatidid").innerHTML = "";
 var matid = document.getElementById('mtid').value;
 if (matid == "")
 {
  document.getElementById("vubymatidid").innerHTML = "<center><font color='red' class='smalltxt'>Please Enter a Matrimony Id</font></center>";
 return false;
 }
 else
 {
  rnd = Math.random();
  http.open('get','checkMatriId.php?mtid='+matid+'&rnd='+rnd,true);
 
  http.onreadystatechange = function(){
   if(http.readyState == 1){document.getElementById("vubymatidid").innerHTML = "<center><font color='#000000' class='smalltxt'>Checking Matrimony Id ...</font></center>";}
   if(http.readyState == 4){
    if (http.status == 200) {
    var response = http.responseText;
    //alert(response);
     if(response == 0 || response == "") {
      document.getElementById("vubymatidid").innerHTML = "<font color='red' class='smalltxt'>In-Valid Matrimony Id or not viewable</font>";
      return false;
     }
     else if(response == "Error") {
      document.getElementById("vubymatidid").innerHTML = "<font color='red' class='smalltxt'>Error , please submit again...</font>";
      return false;
     }
     else {
     //document.getElementById("vubymatidid").innerHTML = " "+response;
     //return false;
     document.getElementById("vubymatidid").innerHTML = "<center><font color='red' class='smalltxt'>Redirecting ...</font></center>";
     document.viewbyidfrm.action="supportcheckstatus_test.php?category="+document.getElementById('category').value+"&mtid="+document.getElementById('mtid').value;
     document.viewbyidfrm.submit();
     }
    }
   }
  }
  http.send(null);
  //document.viewbyidfrm.submit();
 }
 return true;
}
 
function openCenteredWindow(url) {
    var width = 800;
    var height = 350;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
    myWindow = window.open(url, "todayreport", windowFeatures);
 return false;
}
</script>
 
</head>
<body>
<table align=center border='0' cellpadding='0' cellspacing='0'  width='800' style='border: 1px solid #d1d1d1;'>
<tr><td height="50">
<?php
include("../home/header.php");
?>
</td></tr>
    <tr>
 <td height=30  class="adminformheader">&nbsp;&nbsp;<b>Support Interface</td>
    <td height=30 align=center  class="adminformheader">&nbsp;<a href='index_test.php'><b>Home</a></td>
 <!-- <td height=30 align=center  class="adminformheader"><a href="../index.php?act=logout"><b>Logoff</a></td> -->
    </tr>
 </table>
 
<table cellpadding="0" cellspacing="0" align="center" width="80%">
<tr><td colspan="2">
<?php
// include_once("../home/header.php");
?>
</td></tr>
<tr>
<td width="25%" valign="top">
<?php
$sessUserType = $varCookieInfo[1];
 include_once("../home/left-menu.php");
?>
</td>
<td valign="top">
<center class="adminformheader">PAYMENT ASSISTANCE</center>
 
 <table width="100%" align=center valign="top" border="0" cellpadding=0 cellspacing=0 class="normaltxt1" style="border-left:solid 1px #d1d1d1;border-right:solid 1px #d1d1d1;">
 <tr ><td class="normaltxt1 clr6" colspan="4" align="center"><?php echo $displayMsg; ?></td></tr>
<tr><td valign="top" width="50%" style="border-right:solid 1px #d1d1d1;">
 <form method="POST" name="form1" action="" onsubmit="return validate_form(this)">
 <input name="" type="t" value="" style="display:none">
 <table width="100%" align=center valign="top" border="0" cellpadding=4 cellspacing=0 class="normaltxt1">
  <tr class="rowlightbrown normaltxt1">
  <td align="center" colspan="2"><b>Submit Lead Source</b></td>
 </tr>
 <tr>
  <td align="right" width="37%" class="smalltxt">Matrimony Id:</td><td width="63%"><input type="text" name="id" maxlength="12" class="inputtext"></td>
 </tr>
 <tr>
  <td align="right" class="smalltxt">Lead  Source:</td><td>
  <select name="source" size="1" onchange='hidephone(this.value);' class="select">
   <?echo getLead();?>
  </select>
  </td>
 </tr>
 
 <tr>
  <td colspan='2' align="center" width="100%">
     <!--<div id="showqueue" style="display:none;padding-left:2px;"> -->
    <table align='center' width="100%" border='0' id="showqueue" style="display:none;">
     <tr align="right">
      <td width="28%" class="smalltxt">Queue&nbsp;Id&nbsp;:&nbsp;&nbsp;</td>
      <td width="72%" align="left">&nbsp;<input type="text" name="queueid" id="queueid" maxlength='6' class="inputtext"></td>
     </tr>
    </table>
    </div>
    <!--<div id="showcaller" style="display:none;padding-left:2px;"> -->
    <table align='center' width="100%" border='0' id="showcaller" style="display:none;">
     <tr align="right" >
      <td width="28%" class="smalltxt">Caller&nbsp;Id&nbsp;:&nbsp;&nbsp;</td>
      <td width="72%" align="left"><input type="text" name="callerid" id="callerid" maxlength='20' class="inputtext"></td>
     </tr>
    </table>
    </div>
  </td>
 </tr>
 <tr><td colspan=2 align="center"><input type="submit" name="submit1" class="button" value="submit"></td>
 </tr>
 <tr><td><div id="submitsta1"></div></td></tr>
 </table>
 </form>
</td><td valign="top" width="50%">
<script type="text/javascript">
function allowClick(e){
var unicode=e.charCode? e.charCode : e.keyCode
 if (unicode == 13){
  alert("Click the submit buton to Submit..");
  return false;
 }
}
function abledisableDomainLanguage()
{
 if(document.getElementById('freshprofile').style.display != "none")
 {
  if(document.form2.commlang.disabled == false)
  {
 
   document.form2.commlang.disabled = true;
   //document.getElementById('commlang').selectedIndex = -1;
   document.form2.commlang.selectedIndex = -1;
   if(document.form2.topFiftySwitch.checked == false)
   {
    document.form2.domain.disabled = false;
   }
   document.form2.topFiftySwitch.disabled = false;
  }
  else
  {
   document.form2.commlang.disabled = false;
   //document.getElementById('commlang').selectedIndex = 0;
   document.form2.commlang.selectedIndex = 0;
   document.form2.domain.disabled = true;
   document.form2.topFiftySwitch.disabled = true;
  }
 }
 else
 {
  if(document.form3.commlang.disabled == false)
  {
   document.form3.commlang.disabled = true;
   //document.getElementById('commlang').selectedIndex = -1;
   document.form3.commlang.selectedIndex = -1;
   if(document.form3.topFiftySwitch1.checked == false)
   {
    document.form3.domain.disabled = false;
   }
   document.form3.topFiftySwitch1.disabled = false;
  }
  else
  {
   document.form3.commlang.disabled = false;
   //document.getElementById('commlang').selectedIndex = 0;
   document.form3.commlang.selectedIndex = 0;
   document.form3.domain.disabled = true;
   document.form3.topFiftySwitch1.disabled = true;
  }
  
 }
}
</script>
 <form method="GET" name="viewbyidfrm" action="">
  <table width="100%" align=center valign="top" border="0" cellpadding=4 cellspacing=1 class="normaltxt1">
   <tr class="rowlightbrown normaltxt1">
  <td colspan=4 align="center" valign="top"><b>View By MatriId</b></td>
 </tr>
 <tr>
  <td colspan=4 align="center" valign="top" id="vubymatidid" class="normaltxt1 clr6"></td>
 </tr>
 <tr>
  <td colspan=4 align="center" width="100%" class="smalltxt" valign="top">View by MatriId <input type="hidden" name="category" id="category" value=3><input type="text" name="mtid" id="mtid" class="inputtext" onkeypress="return allowClick(event);">&nbsp;&nbsp;<input type="button" name="vibyid" value="submit" class="button" onClick="viewbyid();"></td>
 </tr>
 <tr><td></td></tr>
 </table>
 </form>
</td></tr>
 
 </table>
 
<table width="100%" align=center valign="top" border=0 cellpadding=4 cellspacing=1  class="adminformheader" style="border:solid 1px #d1d1d1;">
 <tr class="rowlightbrown normaltxt1">
  <td align="center" width="14%" nowrap="nowrap"><a href="javascript:freshprofile(1,'countdisp');" >FreshProfile</a></td>
  <td align="center" width="14%" nowrap="nowrap"><a href="javascript:freshprofile(2,'countdisp');">FollowupStatus</a></td>
  <td align="center" width="14%" nowrap="nowrap"><a href="supportgetreport.php" onClick="openCenteredWindow(this.href);return false;">Today Report</a></td>
  <td align="center" width="14%" nowrap="nowrap"><a href="supportcheckstatus_test.php?category=4" target="_self">Pending Profiles</a></td>
  <td align="center" width="14%" nowrap="nowrap"><a onClick='return showEPR();'>EPR Status</a></td>
  <? if($uname == 'vijay.anand') { ?> 
  <td align="center" width="15%" nowrap="nowrap"><a href="cbsprivilegepermission.php" >Privilege Permission</a></td>
  <td align="center" width="15%" nowrap="nowrap"><a href="cbssupportdailyreceivedcount.php" >Privilege Permission</a></td>
  <? } ?>
 </tr>
</table>
<script language="javascript" type="text/javascript">
function showEprStatusForm(fromform)
{
 document.getElementById('freshprofile').style.display = "none";
 document.getElementById('followup').style.display = "none";
 
 var fromdate = document.getElementById('fromdate2').value;
 var todate = document.getElementById('todate2').value;
 if(fromform == "1")
 {
  if(document.getElementById('epr'))
  {
   var epr = document.getElementById('epr').value;
   if(epr == "")
   {
    alert("Enter EPR Number");
    document.getElementById('epr').focus();
    return false;
   }
  }
  else
  {
   epr = "";
  }
 }
 if(fromform == "2")
 {
  var fromDateSplit = fromdate.split("-");
  var fromDateObj = new Date(fromDateSplit[0],fromDateSplit[1],fromDateSplit[2]);
 
  var toDateSplit = todate.split("-");
  var toDateObj = new Date(toDateSplit[0],toDateSplit[1],toDateSplit[2]);
 
  var timeDiff = toDateObj.getTime() - fromDateObj.getTime();
  if(timeDiff > 345600000 || timeDiff < 0)
  {
   alert("Date Difference should not exceed five days.");
   return false;
  }
  //alert(fromdate+" : "+todate+" : "+timeDiff + " : " + fromDateObj.getTime() + " : " + toDateObj.getTime());
 }
 rnd = Math.random();
 http.open('get','eprstatus.php?epr='+epr+'&fromform='+fromform+'&fromdate='+fromdate+'&todate='+todate+'&rnd='+rnd,true);
 
 http.onreadystatechange = function()
 {
  if(http.readyState == 1){document.getElementById("eprResult").innerHTML = "<font color='#000000' class='smalltxt'>Checking EPR Status ...</font>";}
  document.getElementById('eprdiv').style.display="";
  if(http.readyState == 4)
  {
   if (http.status == 200)
   {
    var response = http.responseText;
    document.getElementById("eprResult").style.display = "block";
    document.getElementById("eprResult").innerHTML = ""+response+"<br/><br/>";
   }
  }
 }
 http.send(null);  
 //document.getElementById('epr').focus();
return false;
}
</script>
<script language="javascript" type="text/javascript">
function showEPR()
{
 document.getElementById('freshprofile').style.display="none";
 document.getElementById('followup').style.display="none";
 document.getElementById('eprdiv').style.display = "block";
 document.getElementById("eprResult").style.display = "block";
 document.getElementById("countdisp").style.display = "none";
 document.getElementById('epr').focus();
}
</script>
<div id='eprdiv' style='display:none;'>
 <table width="100%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1" style="border:solid 1px #d1d1d1;">
 <tr class="rowlightbrown normaltxt1"><td colspan=4 align="center"><b>EPR Status</b></td></tr>
 <tr>
 <td width='50%'>
  <table cellpadding='3' cellspacing='0' align='center' width='100%' border='0'>
  <tr><td><? fromdate_todate_payment('form4');?></td></tr>
  <tr><td align='center' colspan='3'><input type='button' name='submit' value='Submit' onClick='return showEprStatusForm("2");' class='button'></td></tr>
  </table>
 </td>
 <td class='smalltxt'>EPR Number : <input type='text' name='epr' id='epr' value='' class='inputtext'> &nbsp; &nbsp; <input type='button' name='submit' value='Submit' onClick='return showEprStatusForm("1");' class='button'></td></tr>
 </table>
<br><br>
 
</div>
<div id='eprResult'></div>
<? if($_REQUEST['submit2']){$outstyle = ""; }else{$outstyle = "display:none;";}?>
<div id="freshprofile" style="<?=$outstyle?>">
 
<? $args = array('PrivilegeLeadSource','PrivilegeLanguage','PrivilegeValidTime');
$argCondition = "where User_Name='$uname' and PrivilegeValidTime!='0000-00-00 00:00:00'";
 $checkResult = $objSlave -> select($varDbInfo['DATABASE'].".".$varTable['ADMINLOGININFO'],$args,$argCondition,0); 
$resultValue = mysql_fetch_assoc($checkResult);
$PrivilegeValidTime = strtotime($resultValue[PrivilegeValidTime]);
$PrivilegeLanguage = $resultValue[PrivilegeLanguage];
$PrivilegeLeadSource = $resultValue[PrivilegeLeadSource];
$now_time = strtotime(date("Y-m-d H:i:s"));
?>

<table width="100%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1" style="border:solid 1px #d1d1d1;">
 <tr class="rowlightbrown normaltxt1"><td colspan=4 align="center"><b>Show Payment Option Details</b></td></tr>
 
<? if($PrivilegeValidTime < $now_time) { ?>
 <tr>
  <td colspan=4>
  <table border=0>
  <form name="failureoption" id="failureoption" action="index_test.php" method="post">
  <tr>
   <td align="right" class="smalltxt">Lead Source:</td>
   <td nowrap="nowrap"><input type='radio' id='lesource' name='lesource[]' value='2'><label class="smalltxt">Payment Failure</label></td>
   <input type="hidden" name="linkstat" value="1"><input type="hidden" name="countycode[]" value="0">
  </tr> 
  <tr>
   <? fromdate_todate_payment('failureoption');?>
  
   <td colspan=2 style="padding-left:60px;"></td>
   <td align="center" colspan=4>&nbsp; <input type='submit' id='failuresubmit' name='failuresubmit' onclick="return failure_func();" value='Show Data' class="button"> &nbsp; <br>
   </td>
  </tr>
  </form>
  </table>  
  </td>
 </tr>
 <? } ?>


 <tr>
  <td colspan=4><hr/></td>
 </tr>
 <form method="post" name="form2" action="index_test.php" onsubmit="return validate_form(this)">
 <? if($PrivilegeValidTime < $now_time) { ?>
 <tr>    
  <td align="center" width="100px" nowrap="nowrap" class="smalltxt">Select Domain:</td><td width="250px" style="padding-right:60px;" >
  <?php
   if($countSD <= 0 && $countCL >= 1)
   {
    $disableShow50Domain = " disabled='false'";
   }
   if(count($_REQUEST[domain]) <= 0)
    $topFiftySwitchChecked = "checked";
  ?>
  <input type='checkbox' id='topFiftySwitch' name='topFiftySwitch' value='topFiftySwitch' onClick="ableDomain();" <?php echo $disableShow50Domain." ".$topFiftySwitchChecked; ?>>Use Top 50 Domains <br>
  <? 
   echo showDomains(); 
  ?>
  
  </td>
 <td class="smalltxt">Language:</td> 
 <td colspan=2 width="150px" class='smalltxt' align='left' valign='middle'>
 <!--<td align="left" width="100px">-->
   &nbsp; <input type='checkbox' id='abledisable' name='abledisable' value='abledisable' onClick='abledisableDomainLanguage()'> Use Top Languages &nbsp; <br>
 <?php
  if($PrivilegeValidTime > $now_time) {
	$PrivilegeValidTimeExist=1;
   }
  echo showCommLang($PrivilegeValidTimeExist);
 ?>
 </td>
 </tr>
 <? } else { if(ucwords($PrivilegeLanguage) == "All") { $PrLangName = "id='domain' name='domain'"; } else { $PrLangName = "id='commlang' name='commlang'";  } ?> <input type='hidden' <? echo $PrLangName; ?> value='<? echo ucwords($PrivilegeLanguage); ?>' >
				<input type='hidden' id='lesource' name='lesource' value='<? echo ucwords($PrivilegeLeadSource); ?>' ><?  } ?>
 <tr>

 <? if($PrivilegeValidTime < $now_time) { ?>
 <td align="center" width="20%" nowrap="nowrap" class="smalltxt">Lead Source:</td><td width="30%">
  <?php
  $lsource="<select id=lesource name=lesource[] size=3 multiple style='width:200px;' class='select'>";
  $lsource.="<option value='All'";
  if(is_array($_REQUEST['lesource'])) {
   if (in_array("All",$_REQUEST['lesource'])){
    $lsource .=' selected ';
   }
  } else {
   if (($_REQUEST['lesource']=="All")||($_REQUEST['lesource']=="")){
    $lsource .=' selected ';
   }
  }
  $lsource.=">All</option>";
  foreach($leadsource as $lkey=>$lvalue) {
   if($lkey!=15 && $lkey!=1) {
   $lsource.="<option value='$lkey' ";
   if(is_array($_POST['lesource']))
    if(in_array($lkey,$_POST['lesource'])) {
     $lsource.="selected ";
    }
   else if($lkey==$_POST['lesource']) {
     $lsource.="selected ";
    }
   $lsource.=">$lvalue</option>";
   }
  }
  $lsource.="</select>";
  echo $lsource;
  ?>
  </td>
<? } ?>
  <td  <? if($PrivilegeValidTime > $now_time) { ?> width="40%" align="center" <? } ?> class='smalltxt'>Country:</td>
  <td align="left" <? if($PrivilegeValidTime > $now_time) { ?> width="60%"  <? } ?> class="smalltxt"> 
  <?php
  $county="<select id=countycode name=countycode[] size=3 style='width:200px;' multiple class='select'>";
  $county.="<option value='0'";
  if(is_array($_REQUEST['countycode'])) {
   if (in_array("0",$_REQUEST['countycode'])){
    $county .=' selected ';
   }
  } else {
   if (($_REQUEST['countycode']=="0")||($_REQUEST['countycode']=="")){
    $county .=' selected ';
   }
  }
  $county.=">All</option>";
  foreach($countries as $ckey=>$cvalue) {
   $county.="<option value='$ckey' ";
   if(is_array($_POST['countycode']))
    if(in_array($ckey,$_POST['countycode'])) {
     $county.="selected ";
    }
   else if($ckey==$_POST['countycode']) {
     $county.="selected ";
    }
   $county.=">$cvalue</option>";
  }
  $county.="</select>";
  echo $county;
  ?>
  </td>
 </tr>
 <tr>
  <? fromdate_todate_payment('form2');?>
 </tr>
 <tr>
 <td colspan="4" class="smalltxt">
 <input type="radio" name="registered" id="registered" value="any" checked <?if($registered=='any'){?>checked<?}?>>Any &nbsp; &nbsp; &nbsp; &nbsp;
 <input type="radio" name="registered" id="registered" value="CBS" <?if($registered=='CBS'){?>checked<?}?>>Directly registered in CBS &nbsp; &nbsp; &nbsp; &nbsp;
 <input type="radio" name="registered" id="registered" value="BM" <?if($registered=='BM'){?>checked<?}?>>Replicated from BM</td>
 </tr>
 <tr><td colspan="4" align="left">
   &nbsp;
   <?php
    if($validated == "" && $_REQUEST['submit2'] != "")
     $validatedChecked2 = "";
    else
     $validatedChecked2 = " checked";
   ?>
   Show Validated Member Only<input type="checkbox" name="validated" value="1" <?php echo $validatedChecked2; ?>>
 </td></tr>
 <tr><input type="hidden" name="linkstat" value="1">
  <td colspan="4" align="center">
  <input type="submit" name="submit2" value="Show Data" class="button"> &nbsp; <input type="button" value="Clear" class="button" onClick="window.location.href='<?php echo $_SERVER[PHP_SELF]; ?>'">
  </td>
 </tr>
</table>
</form>
</div>
<?
 if($_REQUEST['submit3']){$outstyle = ""; }else{ $outstyle = "display:none;";}
?>
 <div id="followup" style="<?=$outstyle?>">
      <form method="post" name="form3" action="index_test.php" onsubmit="return validate_form(this)">
   <table width="100%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1" style="border:solid 1px #d1d1d1;">
   <tr class="rowlightbrown normaltxt1">
  <td colspan=4 align="center"><b>Show Payment Option Details</b></td></tr>
 <tr><td width="20%" align="right" class="smalltxt">Select Domain:</td><td width="30%" class="smalltxt">
 <?php
  if($countSD <= 0 && $countCL >= 1)
  {
   $disableShow50Domain = " disabled='false'";
  }
//  if($_REQUEST[topFiftySwitch1] == "topFiftySwitch1")
//   $topFiftySwitchChecked1 = " checked";
  if(count($_REQUEST[domain]) <= 0)
   $topFiftySwitchChecked1 = " checked";
 ?>
 <input type='checkbox' id='topFiftySwitch1' name='topFiftySwitch1' value='topFiftySwitch1' <?php echo $disableShow50Domain." ".$topFiftySwitchChecked1; ?> onClick='ableDomain1();'>Use Top 50 Domains<br>
 
 <?//showrecords();?><?=showDomains(); ?>
 
 </td>
 <td class='smalltxt' align='center'><input type='checkbox' id='abledisable' onClick='abledisableDomainLanguage()'></td>
 <td>
  <?php
   echo showCommLang();
  ?>
 </td>
 </tr>
 <tr>
 <td width="20%" align="right" class="smalltxt">Lead Source:</td><td width="30%">
  <?php
  $lsource="<select id=lesource name=lesource[] size=3 multiple class='select'>";
  $lsource.="<option value='All'";
  if(is_array($_REQUEST['lesource'])) {
   if (in_array("All",$_REQUEST['lesource'])){
    $lsource .=' selected ';
   }
  } else {
   if (($_REQUEST['lesource']=="All")||($_REQUEST['lesource']=="")){
    $lsource .=' selected ';
   }
  }
  $lsource.=">All</option>";
  foreach($leadsource as $lkey=>$lvalue) {
  if($lkey!=15 && $lkey!=1) {
  $lsource.="<option value='$lkey' ";
  if(is_array($_POST['lesource']))
   if(in_array($lkey,$_POST['lesource'])) {
    $lsource.="selected ";
   }
  else if($lkey==$_POST['lesource']) {
    $lsource.="selected ";
   }
  $lsource.=">$lvalue</option>";
  }
  }
  $lsource.="</select>";
  echo $lsource;
  ?>
  </td> 
 
<td align="right" class="smalltxt">Country:</td><td>
 <?php
  $county="<select id=countycode name=countycode[] size=3 multiple class='select'>";
  $county.="<option value='0'";
  if(is_array($_REQUEST['countycode'])) {
   if (in_array("0",$_REQUEST['countycode'])){
    $county .=' selected ';
   }
  } else {
   if (($_REQUEST['countycode']=="0")||($_REQUEST['countycode']=="")){
    $county .=' selected ';
   }
  }
  $county.=">All</option>";
  foreach($countries as $ckey=>$cvalue) {
   $county.="<option value='$ckey' ";
   if(is_array($_POST['countycode']))
    if(in_array($ckey,$_POST['countycode'])) {
     $county.="selected ";
    }
   else if($ckey==$_POST['countycode']) {
     $county.="selected ";
    }
   $county.=">$cvalue</option>";
  }
  $county.="</select>";
  echo $county;
 ?>
 </td>
 

 </tr>
 <tr>
 <? fromdate_todate_payment('form3'); ?>
 </tr>
 
    <tr>
  <td colspan=4  align="center" class="smalltxt">View By Followup Status:&nbsp;&nbsp;&nbsp;<?=status();?></td></tr>
 
 <tr>
 <td class="smalltxt" colspan="4">
 <input type="radio" name="registered" id="registered" value="any" checked <?if($registered=='any'){?>checked<?}?>>Any &nbsp; &nbsp; &nbsp; &nbsp;
 <input type="radio" name="registered" id="registered" value="CBS" <?if($registered=='CBS'){?>checked<?}?>>Directly registered in CBS &nbsp; &nbsp; &nbsp; &nbsp;
 <input type="radio" name="registered" id="registered" value="BM"<?if($registered=='BM'){?>checked<?}?>>Replicated from BM</td>
 </tr>
 <tr><td colspan="4">
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <?php
    if($validated == "" && $_REQUEST['submit3'] != "")
     $validatedChecked3 = "";
    else
     $validatedChecked3 = " checked";
   ?>
   Show Validated Member Only<input type="checkbox" name="validated" value="1" <?php echo $validatedChecked3; ?>>
 </td></tr>
 <tr><input type="hidden" name="linkstat" value="2">
  <td colspan=4 align="center">
  <input type="submit" name="submit3" value="Show Data" class="button"> &nbsp; <input type="button" value="Clear" class="button" onClick="window.location.href='<?php echo $_SERVER[PHP_SELF]; ?>'">
  </td>
 </tr>
</table>
</form>
</div>
<?php
 echo $html;
?>
</td></tr>
</table>
</body>
</html>
<?php
//$objSlaveMatri->dbClose();
$objSlave->dbClose();
$objMaster->dbClose();
 
//UNSET($objSlaveMatri);
UNSET($objSlave);
UNSET($objMaster);
?>
<script language="javascript">
 
function ableDomain()
{
 //topFiftySwitch
 if(document.getElementById('topFiftySwitch').checked == true)
  document.form2.domain.disabled = true;
 else
  document.form2.domain.disabled = false;
}
function ableDomain1()
{
 if(document.getElementById('topFiftySwitch1').checked == true)
  document.form3.domain.disabled = true;
 else
  document.form3.domain.disabled = false;
}
</script>