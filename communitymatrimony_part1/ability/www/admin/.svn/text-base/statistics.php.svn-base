<?php

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once('../includes/config.php');
include_once('../includes/dbConn.php');
include_once('includes/clsCommon.php');

//OBJECT DECLERATION
$objCommon = new Common;

//VARIABLE DECLERATION
$varCurrentDate				 = date('Y-m-d H:i:s');
$varTodayDate				 = date("d-M-Y");
$objCommon->clsCountField	 = "MatriId";
$objCommon->clsTable		 = "memberdeletedinfo";
$varTotalDeletedProfiles	 = $objCommon->numOfResultsM1();

$objCommon->clsTable		 = "memberlogininfo";
$varTotalProfileCount		 = $objCommon->numOfResultsM1();
$objCommon->clsPrimary		 = array('Publish');
$objCommon->clsPrimaryValue	 = array('1');
$objCommon->clsPrimarySymbol = array('=');
$varTotalActiveprofiles			 = $objCommon->numOfResults();
$objCommon->clsPrimaryValue	 = array('2');
$varTotalHideProfiles			 = $objCommon->numOfResults();
$objCommon->clsPrimaryValue	 = array('3');
$varTotalSuspendProfiles	 = $objCommon->numOfResults();
$objCommon->clsPrimaryValue	 = array('4');
$varTotalRejectedProfiles	 = $objCommon->numOfResults();

$objCommon->clsPrimary		 = array('Date_Created');
$objCommon->clsPrimaryValue	 = array(date('Y-m-d')." 00:00:00");
$varRegisteredProfiles		 = $objCommon->numOfResults();

$objCommon->clsTable		 = "paymenthistoryinfo";
$objCommon->clsPrimary		 = array('Date_Paid');
$objCommon->clsPrimaryValue	 = array(date('Y-m-d')." 00:00:00");
$varPaidProfiles			 = $objCommon->numOfResults();


$objCommon->clsTable		 = "photoinfo";
$objCommon->clsPrimary		 = array('Photo_Status');
$objCommon->clsPrimaryValue	 = array('1');
$varActivePhotos			 = $objCommon->numOfResults();

$objCommon->clsPrimaryValue	 = array('0');
$varPendingPhotos			 = $objCommon->numOfResults();

//Paid_Status 


?>
<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
				<tr><td height="5" colspan="2"></td></tr>
				<tr height="25">
					<td class="smalltxt">Welcome to <?=$confValues['PRODUCTNAME']?>.com</td>
					<td class="smalltxt" align="right"><?=$varTodayDate;?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="1" cellpadding="0" cellspacing="0" width="500" align="center">
				<tr height="25">
					<td class="smalltxt" width="150">Total Profiles</td>
					<td class="smalltxt"><?=$varTotalProfileCount;?></td>
				</tr>
				<tr height="25">
					<td class="smalltxt">Active Profiles</td>
					<td class="smalltxt"><?=$varTotalActiveprofiles;?></td>
				</tr>
				<tr height="25">
					<td class="smalltxt">Hide Profiles</td>
					<td class="smalltxt"><?=$varTotalHideProfiles ? $varTotalHideProfiles : "-";?></td>
				</tr>
				<tr height="25">
					<td class="smalltxt">Suspend Profiles</td>
					<td class="smalltxt"><?=$varTotalSuspendProfiles ? $varTotalSuspendProfiles : "-";?></td>
				</tr>
				<tr height="25">
					<td class="smalltxt">Rejected Profiles</td>
					<td class="smalltxt"><?=$varTotalRejectedProfiles ? $varTotalRejectedProfiles : "-";?></td>
				</tr>




				<tr height="25">
					<td class="smalltxt">Active Photos</td>
					<td class="smalltxt"><?=$varActivePhotos ? $varActivePhotos : "-";?></td>
				</tr>
				<tr height="25">
					<td class="smalltxt">Pending Photos</td>
					<td class="smalltxt"><?=$varPendingPhotos ? $varPendingPhotos : "-";?></td>
				</tr>


















				<tr height="25">
					<td class="smalltxt">Deleted Profiles</td>
					<td class="smalltxt"><?=$varTotalDeletedProfiles ? $varTotalDeletedProfiles : "-";?></td>
				</tr>
				<tr height="25">
					<td class="smalltxt">Today's Profile</td>
					<td class="smalltxt"><?=$varRegisteredProfiles ? $varRegisteredProfiles : "-";?></td>
				</tr>
				<tr height="25">
					<td class="smalltxt">Today's Payment</td>
					<td class="smalltxt"><?=$varPaidProfiles ? $varPaidProfiles : "-";?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
//UNSET OBJECT
unset($objCommon);
?>