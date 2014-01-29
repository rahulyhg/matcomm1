<?php
#================================================================================================================
# Author 		: N. Dhanapal,A.Baskaran
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Admin	-	Add payment
#================================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
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

	if ($varFromDate !="" && $varToDate !="") { $varCondition = " AND DATE(B.Date_Paid) >='".$varFromDate."' AND DATE(B.Date_Paid)<='".$varToDate."'";  }
	elseif ($varFromDate !="") { $varCondition	= " AND DATE(B.Date_Paid)='".$varFromDate."'";  }

	//OBJECT DECLARTION
	$objDB	= new DB;

	//DB CONNECTION
	$objDB->dbConnect('S',$varDbInfo['DATABASE']);
	$varQuery	='SELECT A.MatriId,A.User_Name,A.Paid_Status,B.Amount_Paid,B.Payment_Type,B.Date_Paid,B.Currency FROM memberinfo A, paymenthistoryinfo B WHERE A.MatriId=B.MatriId ';

	if ($varUsernames !="") { 
		$varQuery	.='	AND (A.User_Name IN ('.$varUsernames.') OR A.MatriId IN ('.$varUsernames.')) '; }
	
	$varQuery	.='	AND B.Amount_Paid >0 '.$varCondition.' ORDER BY A.User_Name,B.Date_Paid DESC';

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
					<td valign="middle" colspan="3"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Payment Followups</font></div>
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
								<td class="smalltxt" align="left" width="25%">&nbsp;&nbsp;Username</td>
								<td class="smalltxt" align="left" width="15%">Category</td>
								<td class="smalltxt" align="left" width="20%">Amount</td>
								<td class="smalltxt" align="left" width="20%">Upgraded On</td>
								<td class="smalltxt" align="left" width="20%">Mode</td>
							</tr>
							<? while($varResults = mysql_fetch_array($varExecute)) { ?>
							<tr>
								<td class="smalltxt clr3" align="left">&nbsp;&nbsp;<a href="index.php?act=view-profile&matrimonyId=<?=$varResults['User_Name'];?>" class="smalltxt clr1" target="_blank"><?=$varResults['User_Name'];?></a></td>
								<td class="smalltxt" align="left"><?=$varResults['Paid_Status']==1 ? 'Paid' : 'Free';?></td>
								<td class="smalltxt" align="left"><?=$varResults['Currency'];?>. <?=$varResults['Amount_Paid'];?></td>
								<td class="smalltxt" align="left"><?=$varResults['Date_Paid'];?></td>								
								<td class="smalltxt" align="left"><?=$arrPaymentMode[$varResults['Payment_Type']];?></td>
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