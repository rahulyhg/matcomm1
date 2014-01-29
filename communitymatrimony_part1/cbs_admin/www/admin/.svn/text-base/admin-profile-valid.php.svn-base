<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');

//OBJECT DECLARTION
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);


//getting unvalidated profile im memberinfo
if($_REQUEST['ps'] == 'yes') {
  $varDate= date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')-2,date('Y')));
  $argCondition = "WHERE Paid_Status = 1 AND Date_Created >= '".$varDate."' AND Publish = 1 AND Support_Comments = ''";
  $varNoOfRecords		= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);
}
if($_REQUEST['pps'] == 'no') {
  $argCondition1				= "WHERE Publish = 0"; 
  $varNoOfRecords1			= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition1);
}


if(($_REQUEST['ps'] == 'yes')||($_REQUEST['pps'] == 'no')){
//getting unvalidated profile im memberinfo
$argCondition				= '';
$varUpdatedNoOfRecords		= $objSlave->numOfRecords($varTable['MEMBERUPDATEDINFO'],'MatriId',$argCondition);
}

if(($_REQUEST['ps'] == 'yes')||($_REQUEST['pps'] == 'no')){
//getting total matriids count for pending photo validation
$varBeforeOneMonthDate		= date( "Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"),date("m"),date("d")-30,date("Y")));
$argCondition				= "WHERE Photo_Date_Updated>='".$varBeforeOneMonthDate."' AND ((Normal_Photo1!='' AND Photo_Status1=0) OR (Normal_Photo2!='' AND Photo_Status2=0) OR (Normal_Photo3!='' AND Photo_Status3=0) OR (Normal_Photo4!='' AND Photo_Status4=0) OR (Normal_Photo5!='' AND Photo_Status5=0) OR (Normal_Photo6!='' AND Photo_Status6=0) OR (Normal_Photo7!='' AND Photo_Status7=0) OR (Normal_Photo8!='' AND Photo_Status8=0) OR (Normal_Photo9!='' AND Photo_Status9=0) OR (Normal_Photo10!='' AND Photo_Status10=0))";
$varTotalMatriIdsForPhotoVal= $objSlave->numOfRecords($varTable['MEMBERPHOTOINFO'],'MatriId',$argCondition);

//getting total count for pending photo validation

$varCountForPendingPhotos		= 0;
for($i=1; $i<=10; $i++) {
	$argCondition	= "WHERE Photo_Date_Updated>='".$varBeforeOneMonthDate."' AND Normal_Photo".$i."!='' AND Photo_Status".$i."=0";
	$varCountForPendingPhotos	+= $objSlave->numOfRecords($varTable['MEMBERPHOTOINFO'],'MatriId',$argCondition);
}
}

$objSlave->dbClose();
?>
<? if($_REQUEST['pps'] == 'no') { ?>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="15"></td></tr>
	<tr><td class="heading" style="padding-left:10px;">Current Profiles Count To Validate</td></tr>
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>New Profiles Pending Count : <?=$varNoOfRecords1?></b></td></tr>
	
	<tr><td class="mediumtxt" align="right"  style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>Modify Profiles Pending Count : <?=$varUpdatedNoOfRecords?></b></font></div></td></tr> 
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>Photo Pending Count : <?=$varCountForPendingPhotos?> (Total Ids : <?=$varTotalMatriIdsForPhotoVal?>)</b></td></tr>
</table>
<? } ?>

<? if($_REQUEST['ps'] == 'yes') { ?>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="15"></td></tr>
	<tr><td class="heading" style="padding-left:10px;">Current Paid Profiles Count To Validate</td></tr>
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>New Profiles Pending Count : <?=$varNoOfRecords?></b></td></tr>	
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>Photo Pending Count : <?=$varCountForPendingPhotos?> (Total Ids :<?=$varTotalMatriIdsForPhotoVal?>)</b></td></tr>
</table>
<? } ?>