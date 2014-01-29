<?php
#================================================================================================================
# Author 		: N. Dhanapal,A.Baskaran
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Admin	-	Add payment
#================================================================================================================
//FILE INCLUDES

$varRootBasePath = '/home/product/community/ability';	
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/payment.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

//VARIABLE DECLARATION
$varSubmit		= trim($_REQUEST['followupsSubmit']);
$varUsernames	= trim($_REQUEST['userNames']);
$varFromDate	= trim($_REQUEST['fromDate']);
$varToDate		= trim($_REQUEST['toDate']);

if ($varSubmit=='yes') {

	if ($varUsernames !="") {
		$varUsernames	= preg_replace("/[,\s]+/",",",trim($varUsernames));
		$varUsernames	= "'".preg_replace("/(,|\s)+/","','",trim($varUsernames, ','))."'";
	}

	$arrPaymentMode	= array(2=>'Cheque',3=>'Demand Draft',4=>'Cash Payment',1=>'Online',5=>'Direct Deposit');

	if ($varFromDate !="" && $varToDate !="") { $varCondition = " AND DATE(B.Date_Captured) >='".$varFromDate."' AND DATE(B.Date_Captured)<='".$varToDate."'";  }
	elseif ($varFromDate !="") { $varCondition	= " AND DATE(B.Date_Captured)='".$varFromDate."'";  }

	//OBJECT DECLARTION
	$objDB	= new DB;

	//DB CONNECTION
	$objDB->dbConnect('S',$varDbInfo['DATABASE']);
	$varQuery	='SELECT A.MatriId,A.Paid_Status,B.Date_Captured,B.PhoneNo,B.3dSecureFailure,B.Date_Captured FROM memberinfo A, onlinepaymentfailures B WHERE A.MatriId=B.MatriId ';

	if ($varUsernames !="") { 
		$varQuery	.='	AND A.MatriId IN ('.$varUsernames.') '; }
	
	$varQuery	.= $varCondition.' ORDER BY A.MatriId,B.Date_Captured DESC';

	$varExecute	= mysql_query($varQuery);
	$varRecords	= mysql_num_rows($varExecute);
	$varRecords	= $varRecords ? $varRecords : 0;

	$objDB->dbClose();

$varUsernames	= preg_replace("/'/",' ',$varUsernames);
}
?>
<link rel="stylesheet" type="text/css" href="<?=$confValues['CSSPATH']?>/global-style.css" />
<link rel="stylesheet" href="includes/calender.css">
<script language="javascript" src="includes/calenderJS.js"></script>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="748">
	<tr>
		<td valign="top" bgcolor="#FFFFFF" width="748">
			<table border="0" cellpadding="2" cellspacing="0" width="744">
				<tr>
					<td valign="middle" colspan="3"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Online Payment Failure</font></div>
					</td>
				</tr>
				<tr><td colspan="3"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="15"></td></tr>

				<form name="followups" method="post">
				<input type="hidden" name="followupsSubmit" value="yes">
				<tr height="25">
					<td valign="top" bgcolor="#FFFFFF" colspan="3">
						<table border="0" cellpadding="0" cellspacing="0" width="700">
							<tr>
								<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">&nbsp;&nbsp;From Date&nbsp;&nbsp;<input type='text' class='inputtext' name='fromDate' value="<?=$varFromDate?>"/><a href="javascript:displayDatePicker('fromDate', false, 'ymd', '-');">&nbsp;<img src="<?=$confValues['IMGSURL']?>/calbtn.gif" align="absmiddle" border="0"></a>&nbsp;<b>(YYYY-MM-DD)</b></td>

								<td class="smalltxt boldtxt frmlftpad">&nbsp;&nbsp;to Date&nbsp;&nbsp;<input type="text" class="inputtext" name="toDate" value="<?=$varToDate?>"/><a href="javascript:displayDatePicker('toDate', false, 'ymd', '-');">&nbsp;<img src="<?=$confValues['IMGSURL']?>/calbtn.gif" align="absMiddle" border="0"></a>&nbsp;<b></b></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr height="25">
					<td class="smalltxt" align="left" width="159" valign="top">Username / MatriId (s)<br><b>(Enter comma separate)</b></td>
					<td class="smalltxt" align="left" width="355"><textarea name="userNames" cols="40" rows="7"><?=$varUsernames?></textarea></td>
					<td class="smalltxt" align="left" valign="bottom" width="330">
						<input type="submit" value="Submit" class="button">&nbsp;&nbsp;
						<input type="reset" value="Clear" class="button">
					</td>
				</tr>
				</form>

				<? if ($varSubmit=='yes') { ?>
				
				<tr><td colspan="3"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="5"></td></tr>
				<tr><td colspan="3" class="smalltxt boldtxt frmlftpad"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="10"><? if ($varRecords==0) { echo 'No records found'; } else { echo 'Total Count : '.$varRecords; } ?></td></tr>
				<tr>
					<td  colspan="3" width="100%" style="padding-left:3px;">
						<table border="0" cellpadding="0" cellspacing="0" align="center" width="99%" class="formborder">
							<tr class="adminformheader" height="25">
								<td class="smalltxt" align="left" width="25%">&nbsp;&nbsp;MatriId</td>
								<td class="smalltxt" align="left" width="25%">PhoneNo</td>
								<td class="smalltxt" align="left" width="25%">3dSecure Failure</td>
								<td class="smalltxt" align="left" width="25%">Date Captured</td>

							</tr>
							<? while($varResults = mysql_fetch_array($varExecute)) { ?>
							<tr>
								<td class="smalltxt clr3" align="left">&nbsp;&nbsp;<a href="index.php?act=view-profile&matrimonyId=<?=$varResults['MatriId'];?>" class="smalltxt clr1" target="_blank"><?=$varResults['MatriId'];?></a></td>

								<td class="smalltxt" align="left"><?=$varResults['PhoneNo'];?></td>
								<td class="smalltxt" align="left"><?=($varResults['3dSecureFailure']==1) ? 'Yes' : '-';?></td>
								<td class="smalltxt" align="left"><?=$varResults['Date_Captured'];?></td>
							</tr>
							<tr><td width="10" valign="top" height="2" colspan="5"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
							<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="5"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
							<tr><td width="10" valign="top" height="2" colspan="5"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
							<? } } ?>

						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>