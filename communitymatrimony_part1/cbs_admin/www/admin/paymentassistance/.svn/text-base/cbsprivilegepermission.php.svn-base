<?
#====================================================================================================
# Author   : J.P.Senthil Kumar
# Start Date : 09 Feb 2011
# End Date  : 17 Feb 2011
# Module  : Payment Assistance
# Description : This file allows the admin user of CBS INTERFACE to allocate particular user or users by assigning domain wise and leadsource wise to search for MatriIds with the stipulated time period for the support users to access with the above-mentioned criteria.
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
 
if(($uname == 'sureshtme') || ($uname == 'admin') || ($uname == 'prabhur')) { 

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
$varTable['SUPPORTLEADSASSIGNLOG'] = 'supportleadsassignlog';
global $leadsource,$paymentoption_followup_status;
$OtherISD = $DubaiISDcode+$IndaiISDcode+$UsaISDcode+$AustraliaISDcode+$SingaporeISDcode+$MalaysiaISDcode+$UKISDcode+$CanadaISDcode;

extract($_REQUEST);
if($_REQUEST[privilegeSubmit] == "Submit") {		
	$privilegedomain = implode("&",$privilegedomain);
	if($privilegedomain == 'all') {
		$privilegedomain = 'all';
	}
	$privilegeleadsource = implode("&",$privilegeleadsource);
	if($privilegeleadsource == 'all') {
		$privilegeleadsource = 'all';
	}
	$addedtime=mktime(date("H")+$privilegevalidtime,date("i"),date("s"),date("m"),date("d"),date("Y"));
	echo $privilegevalidtime = date("Y-m-d H:i:s",$addedtime);

	foreach($userid as $one_id) {

		$argField = array('PrivilegeLanguage','PrivilegeLeadSource','PrivilegeValidTime');
		$argValue = array($objMaster->doEscapeString($privilegedomain,$objMaster),$objMaster->doEscapeString($privilegeleadsource,$objMaster),$objMaster->doEscapeString($privilegevalidtime,$objMaster));
		$argConditions = " User_Name='".$one_id."' and User_Type=6 and Publish=1 ";
		$updatequery=$objMaster->update($varDbInfo['DATABASE'].".".$varTable['ADMINLOGININFO'],$argField,$argValue,$argConditions);				
		
		/*$forceFields=array('User_Name','LogOutTime');
		$forceValues=array("'".$one_id."'","'0000-00-00 00:00:00'");

		$updatequery1=$objMaster->insert($varDbInfo['DATABASE'].".".$varTable['ADMINLOGINTRACK'], $forceFields, $forceValues);*/	
		$assignLogFields=array('LeadsAssignTo','LeadsAssignBy','PrivilegeLanguage','PrivilegeLeadSource','PrivilegeValidTime','AssignedTime');
		$assignLogValues=array($objMaster->doEscapeString($one_id,$objMaster),$objMaster->doEscapeString($uname,$objMaster),$objMaster->doEscapeString($privilegedomain,$objMaster),$objMaster->doEscapeString($privilegeleadsource,$objMaster),$objMaster->doEscapeString($privilegevalidtime,$objMaster),"now()"); 

		$objMaster->insert($varTable['SUPPORTLEADSASSIGNLOG'], $assignLogFields, $assignLogValues);			
	}
		if($updatequery) {						
			$msg = base64_encode("Data has been updated successfully");
			header("location:cbsprivilegepermission.php?msg=$msg");
			exit;
		}
		else
		{
			$msg = base64_encode("Data is not updated due to some errors");
			header("location:cbsprivilegepermission.php?msg=$msg");
			exit;
		}
}

if($_REQUEST[deactivesubmit] == "Deactivate") {
	 
	$argField = array('PrivilegeLanguage','PrivilegeLeadSource','PrivilegeValidTime');
	$argValue = array("''","''","'0000-00-00 00:00:00'");
	$argConditions = " User_Name=".$objMaster->doEscapeString($active_users,$objMaster)." and User_Type=6 and Publish=1 ";
	$updatequery=$objMaster->update($varDbInfo['DATABASE'].".".$varTable['ADMINLOGININFO'],$argField,$argValue,$argConditions);		
		
		/*$forceFields=array('User_Name','LogOutTime');
		$forceValues=array("'".$one_id."'","'0000-00-00 00:00:00'");

		$updatequery1=$objMaster->insert($varDbInfo['DATABASE'].".".$varTable['ADMINLOGINTRACK'], $forceFields, $forceValues);*/

		if($updatequery) {						
			$msg = base64_encode("Data has been updated successfully");
			header("location:cbsprivilegepermission.php?msg=$msg");
			exit;
		}
		else
		{
			$msg = base64_encode("Data is not updated due to some errors");
			header("location:cbsprivilegepermission.php?msg=$msg");
			exit;
		}	
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
<script type="text/javascript">
function cur_active_users(field) {
	with(field) {		
		if((active_users.value == '') || (active_users.value == 'null')){
			alert("Please select the user");
			return false;
		}
		return true;
	}
}

function privilege_func(field) {
	with(field) {
		if((userid.value == '') || (userid.value == "null")) {
			alert("Please select the users");
			return false;
		}
		if((privilegedomain.value == '') || (privilegedomain.value == "null")) {
			alert("Please select the language name");
			return false;
		}
		if((privilegeleadsource.value == '') || (privilegeleadsource.value == "null")) {
			alert("Please select the lead source");
			return false;
		}
		if((privilegevalidtime.value == '') || (privilegevalidtime.value == "null")) {
			alert("Please select the valid hours");
			return false;
		}
	return true;
	}
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
    <td height=30 align=center  class="adminformheader">&nbsp;<a href='index.php'><b>Home</a></td>
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

<div id="privilege_Permission" style="<?=$outstyle?>">
<? $args = array('User_Name','PrivilegeLeadSource','PrivilegeLanguage','PrivilegeValidTime');
$argCondition = "where User_Type=6 and Publish=1";
//$argCondition = "where (User_Type=2 or User_Type=3) and Publish=1";
 $checkResult = $objSlave -> select($varDbInfo['DATABASE'].".".$varTable['ADMINLOGININFO'],$args,$argCondition,0); 
			
					
			$nonactiveusers = array();
			$activeusers = array(); $r=0; while($users_list1 = mysql_fetch_assoc($checkResult)) { 			
			$now_time = strtotime(date("Y-m-d H:i:s"));
			if($active_users == $users_list1[User_Name]) {				
				if($users_list1[PrivilegeLanguage] == 'all') {					
					$active_domain = 'all';
				}
				else {
					$active_domain = explode("&",$users_list1[PrivilegeLanguage]);				
				}
				if($users_list1[PrivilegeLeadSource] == 'all') {					
					$active_leadsource = 'all';
				}
				else {
					$active_leadsource = explode("&",$users_list1[PrivilegeLeadSource]);
				}
				$d1 = strtotime($users_list1[PrivilegeValidTime]);
				$d2=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));	
				$remainingHours = ceil(($d1-$d2)/3600);
			}
			if(strtotime($users_list1[PrivilegeValidTime]) > $now_time) {
				$activeusers[$r] = array($users_list1[User_Name],$users_list1[User_Name],$users_list1[User_Name]);
				$nonactiveusers[$r] = array($users_list1[User_Name],$users_list1[name],$users_list1[User_Name]);
			}
			else {				
				$nonactiveusers[$r] = array($users_list1[User_Name],$users_list1[User_Name],$users_list1[User_Name]);
			}					
			$r++; } 
			?>
<table width="100%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1" style="border:solid 1px #d1d1d1;">

<tr class="rowlightbrown normaltxt1"><td colspan=4 align="center"><b>Privilege Permission for Support Users</b></td></tr>

<!-- <tr>
		<td colspan="3" align="center"><h3>Privilege Permission for Support Users<h3></td>
</tr> -->
<tr>
	<td colspan="2" align="center"><h4><? echo base64_decode($_REQUEST[msg]); ?><h4></td>
</tr>
	<tr>
	 <td>

<div id="innerblock" >
<form name="permission_form" action="" method="post" onsubmit="return privilege_func(this);">

<table width="41%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1" >			
	<tr style="height:100px;">
		<td nowrap="nowrap"><b>Support Users</b></td>
		<td>:</td>
		<td><select name="userid[]" id="userid" multiple style="width:175px; height:75px; font-size:11px; font-family:Arial;">
			<option value="">Select Support Users</option>
			<? for($w=0; $w<count($nonactiveusers); $w++) { ?>
			<option value="<? echo $nonactiveusers[$w][0]; ?>" <? if($active_users == $nonactiveusers[$w][0]) { ?> selected <? } ?>><? echo ucfirst($nonactiveusers[$w][0]); ?>&nbsp;&nbsp;</option>
			<? } ?>
			</select>
		</td>		
		<td><b>Languages</b></td>
		<td>:</td>
		<td><select name="privilegedomain[]" id="privilegedomain" multiple style="height:75px; font-size:11px; font-family:Arial;">
			<option value="">Select Language</option>
			<option value="all" <? if($active_domain == 'all') { ?> selected <? } ?>>All</option>
			<? foreach($paLanguageKeys as $domainkey=>$domainvalue) { ?>
			<option value="<? echo $domainkey; ?>" <? foreach($active_domain as $domain_value) { if($domain_value == $domainkey) { ?> selected <? }  } ?>><? echo ucfirst($domainvalue); ?></option>
			<? } ?>
			</select>
		</td>
	</tr>
	<tr style="height:100px;">
		<td nowrap="nowrap" ><b>Lead Source</b></td>
		<td>:</td>
		<td><select name="privilegeleadsource[]" id="privilegeleadsource" multiple style="height:75px; font-size:11px; font-family:Arial;">
			<option value="">Select Lead Source</option>
			<option value="all" <? if($active_leadsource == 'all') { ?> selected <? } ?>>All</option>
			<? foreach($leadsource as $leadkey=>$leadvalue) { 
				if(($leadkey != 15) && ($leadkey != 1)) {?>
			<option value="<? echo $leadkey; ?>" <? foreach($active_leadsource as $leadsource_value) { if($leadsource_value == $leadkey) { ?> selected <? } } ?>><? echo $leadvalue; ?></option>
			<? } } ?>
			</select>
		</td>
		<td nowrap="nowrap"><b>Valid Hours</b></td>
		<td>:</td>
		<td><select name="privilegevalidtime" id="privilegevalidtime" style="width:93px; font-size:11px; font-family:Arial;">			
			<option value="">Select Time</option>
			<? for($i=1; $i <=10; $i++) { ?>
			<option value="<? echo $i; ?>" <? if($remainingHours == $i) { ?> selected <? } ?>><? echo $i."&nbsp;"; if($i==1) { echo "hour"; } else { echo "hours"; } ?></option>
			<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="6" align="center"><input type="submit" name="privilegeSubmit" value="Submit" /></td>
	</tr>
</table>
</form>
</div>

<table border=0>
<tr><td colspan=6><hr style="width:600px;" /></td></tr>
</table>

<form name="active_users" action="cbsprivilegepermission.php" method="post" onsubmit="return cur_active_users(this);">
<table style="padding:20px;" width="41%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1" >
<tr><td nowrap="nowrap" align="center"><b>Active Users</b></td>
	<td>
	<select name="active_users" id="active_users" style="font-size:11px; font-family:Arial;">
	<option value="">Select User</option>
	<? print_r($activeusers); if(count($activeusers) == 0) { ?>
		<option value="">No Active Users</option>
		<? } else {foreach($activeusers as $au) { ?>
	<option value="<? echo $au[0]; ?>" <? if($active_users == $au[0]) { ?> selected <? } ?>><? echo ucfirst($au[1]); ?></option>
	<? } }?>
	</select>
	</td>
</tr>
<tr>
	<td align="center"><input type="submit" name="activesubmit" value="Edit" /></td><td align="center"><input type="submit" name="deactivesubmit" value="Deactivate" /></td>
</tr>
</table>
	</td>
   </tr>
  </table>
</form>
</div>



<? //$objSlaveMatri->dbClose();
$objSlave->dbClose();
$objMaster->dbClose();
 
//UNSET($objSlaveMatri);
UNSET($objSlave);
UNSET($objMaster); 
}
else {
	header("Location:http://www.communitymatrimony.com/admin/paymentassistance/index.php");
}


?>