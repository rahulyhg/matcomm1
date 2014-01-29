<?php
#================================================================================================================
# Author 		: M Baranidharan
# Start Date	: 2010-09-27
# End Date		: 2010-09-27
# Project		: MatrimonyProduct
# Module		: Admin	-	Add payment
#================================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/www/admin/includes/userLoginCheck.php');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
	$objDB	= new DB;

//DB CONNECTION
	$objDB->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varFromDate	= trim($_REQUEST['fromDate']);
$varToDate		= trim($_REQUEST['toDate']);
$varSubmit		= trim($_REQUEST['paymentSubmit']);

if ($varFromDate !="" && $varToDate !="") { $varCondition = " DATE(Date_Captured) >=".$objDB->doEscapeString($varFromDate,$objDB)." AND DATE(Date_Captured)<=
".$objDB->doEscapeString($varToDate,$objDB)$."";  }
elseif ($varFromDate !="") { $varCondition	= " DATE(Date_Captured)=".$objDB->doEscapeString($varFromDate,$objDB)."";  }
if($varCondition) {
 $varCondition = " AND ".$varCondition." ";
}


if ($varSubmit=='yes') {
	$varQuery	="SELECT OrderId,MatriId,VPC_TransactionNo,Product_Id,Amount_Paid,Date_Captured,Score,Currency FROM maxmindpaymentcapture WHERE Status=0 AND VPC_TransactionNo<>'' AND MatriId NOT IN ('YDV100377') ".$varCondition." ORDER BY Date_Captured ASC";
	$varExecute	= mysql_query($varQuery);
	$varRecords	= mysql_num_rows($varExecute);
	$varRecords	= $varRecords ? $varRecords : 0;
}
?>
<link rel="stylesheet" type="text/css" href="<?=$confValues['CSSPATH']?>/global-style.css" />
<link rel="stylesheet" href="includes/calender.css">
<script language="javascript" src="includes/calenderJS.js"></script>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="748">
	<tr>
		<td valign="top" bgcolor="#FFFFFF" width="748">
			<table border="0" cellpadding="0" cellspacing="0" width="744">
				<tr>
					<td valign="middle"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Payment Tracking</font></div>
					</td>
				</tr>
				<tr>
					<td valign="top" bgcolor="#FFFFFF" width="748">
						<table border="0" cellpadding="0" cellspacing="0" width="700">
							<form name="paymentTracking" method="post">
							<input type="hidden" name="paymentSubmit" value='yes'>
							<tr>
								<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">&nbsp;&nbsp;From Date&nbsp;&nbsp;<input type='text' class='inputtext' name='fromDate' /><a href="javascript:displayDatePicker('fromDate', false, 'ymd', '-');">&nbsp;<img src="<?=$confValues['IMGSURL']?>/calbtn.gif" align="absmiddle" border="0"></a>&nbsp;<b>(YYYY-MM-DD)</b></td>

								<td class="smalltxt boldtxt frmlftpad">&nbsp;&nbsp;to Date&nbsp;&nbsp;<input type="text" class="inputtext" name="toDate"/><a href="javascript:displayDatePicker('toDate', false, 'ymd', '-');">&nbsp;<img src="<?=$confValues['IMGSURL']?>/calbtn.gif" align="absMiddle" border="0"></a>&nbsp;<b></b></td>
								<td><input type="submit" class="button" value="Submit"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="5"><input type="reset" class="button" name="clear" value="Clear"></td>
							</tr>
							</form>
						</table>
					</td>
				</tr>
				<? if ($varSubmit=='yes') { ?>
				
				<tr><td><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="5"></td></tr>
				<tr><td class="smalltxt boldtxt frmlftpad"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="10"><? if ($varRecords==0) { echo 'No records found'; } else { echo 'Total Count : '.$varRecords; } ?></td></tr>
				<? if ($varRecords >0) { ?>
				<tr>
					<td width="100%" style="padding-left:3px;">
						<table border="0" cellpadding="0" cellspacing="0" align="center" width="99%" class="formborder">
							<tr class="adminformheader" height="25">
								<td class="smalltxt" align="center" width="26%">Order Id</td>
								<td class="smalltxt" align="center" width="20%">Matrimony Id</td>
								<td class="smalltxt" align="center" width="16%">Membership</td>
								<td class="smalltxt" align="center" width="10%">Amount</td>
								<td class="smalltxt" align="center" width="14%">Payment Time</td>
								<td class="smalltxt" align="center" width="14%">Capture / Refund</td>
							</tr>
							<? while($varResults = mysql_fetch_array($varExecute)) { ?>
							<tr>
								<td class="smalltxt" align="left" style="padding-left:5px;"><?=$varResults['OrderId'];?></td>
								<td class="smalltxt clr3" align="center"><a href="index.php?act=view-profile1&actstatus=yes&matrimonyId=<?=$varResults['MatriId'];?>" class="smalltxt clr1" target="_blank"><?=$varResults['MatriId'];?></a></td>
								<td class="smalltxt" align="left"><?=$arrPrdPackages[$varResults['Product_Id']];?></td>
								<td class="smalltxt" align="center"><?=$varResults['Currency'];?> <?=$varResults['Amount_Paid'];?></td>
								<td class="smalltxt" align="center"><?=date('d-M-y',strtotime($varResults['Date_Captured']));?></td>
								<td class="smalltxt" align="center"><a target="_blank"  href="../payment/capture/vpc_maxmindcapture.php?orderId=<?=base64_encode($varResults['OrderId'])?>&transactionId=<?=base64_encode($varResults['VPC_TransactionNo'])?>&currency=<?=base64_encode($varResults['Currency'])?>&amount=<?=base64_encode($varResults['Amount_Paid'])?>">capture</a> / <a target="_blank" onclick="javascript:if(confirm('Are you sure to refund??')){return true} else{return false;};" href="maxmindmail.php?orderId=<?=base64_encode($varResults['OrderId'])?>&matriId=<?=base64_encode($varResults['MatriId'])?>&currency=<?=base64_encode($varResults['Currency'])?>&amount=<?=base64_encode($varResults['Amount_Paid'])?>">refund</a></td>
							</tr>
							<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="6"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
							<? } ?>
						</table>
					</td>
				</tr>
				<? }  } ?>
			</table>
		</td>
	</tr>
</table>