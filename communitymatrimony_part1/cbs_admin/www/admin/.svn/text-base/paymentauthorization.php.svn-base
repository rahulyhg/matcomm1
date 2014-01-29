<?php
#================================================================================================================
# Author 		: N. Dhanapal,A.Baskaran
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Admin	-	Add payment
#================================================================================================================
//FILE INCLUDES

$varRootBasePath = '/home/product/community';	
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objDB	= new DB;

//DB CONNECTION
$objDB->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varOrderTraceNumber= trim($_REQUEST['orderTraceNumber']);
$varRecords			= 0;
$varCondition		= '';

$arrPaymentMode	= array(2=>'Cheque',3=>'Demand Draft',4=>'Cash Payment',1=>'Online',5=>'Direct Deposit');
$arrStatus		= array(0=>'Pending',1=>'Approved',3=>'Suspend');
$arrBankName	= array(1=>'CCAvenue',2=>'Citi',3=>'ICICI',4=>'IVRS',5=>'Optimal');

	if ($varOrderTraceNumber!="") { 

	$varCondition	.= " (OrderId=".$objDB->doEscapeString($varOrderTraceNumber,$objDB)." OR MatriId=".$objDB->doEscapeString($varOrderTraceNumber,$objDB).") ";  

	
	$varQuery	='SELECT OrderId,Gateway,MatriId,Product_Id,Currency,Amount_Paid,Date_Paid FROM prepaymenthistoryinfo WHERE ';
	$varQuery	.= $varCondition.' ORDER BY Date_Paid DESC LIMIT 100';
	//echo '<br>'.$varQuery;
	$varExecute	= mysql_query($varQuery);
	$varRecords	= mysql_num_rows($varExecute);

	} 
?>
<html>
<head>
	<title>Community Matrimony, Matrimony, Indian Matrimony</title>
	<meta name="description" content="Matrimony, Matrimony, Indian Matrimony. Searching For Your Life Partner? Join Free!">
	<meta name="keywords" content="Matrimony, Matrimony, Indian Matrimony">
	<meta name="abstract" content="Matrimony, Matrimony, Indian Matrimony">
	<meta name="Author" content="Matrimony, Matrimony, Indian Matrimony">
	<meta name="copyright" content="Copyright &copy; 2010 Consim Info Pvt Ltd. All rights reserved.">
	<meta name="Distribution" content="Matrimony, Matrimony, Indian Matrimony">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/global-style.css">
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="600">
	<tr>
		<td valign="top" bgcolor="#FFFFFF" width="600">
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr>
					<td valign="middle" colspan="3"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Community Payment Tracking</font></div>
					</td>
				</tr>
				<tr><td colspan="3"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="7"></td></tr>

				<form name="followups" method="post">
				<tr height="25">
					<td valign="top" bgcolor="#FFFFFF" colspan="3">
						<table border="0" cellpadding="0" cellspacing="0" width="400">
							<tr>
								<td class="smalltxt boldtxt frmlftpad" align="left">OrderId / MatriId</td>
								<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">
									<input type="text" class="smalltxt" name="orderTraceNumber" value="" size="25"> &nbsp;<input type="submit" align="absmiddle" name="send" value="Submit"></td>
							</tr>
							<tr><td width="10" valign="top" height="10" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="10"></td></tr>
						</table>
					</td>
				</form>

				<? if ($varRecords >0) { ?>

				<form name="paymentApproval" method="post">
				<input type="hidden" name="paymentApprovalSubmit" value="yes">
				<tr><td><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="15"></td></tr>
				<tr><td class="smalltxt boldtxt frmlftpad"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="0">Total Payments : <?=$varRecords;?></td></tr>
				<tr><td class="smalltxt boldtxt frmlftpad"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="0">Payment Status :	<? $varResultsMatriId = mysql_result($varExecute,0,"MatriId"); 
				$varPaidStatus			= "Free";
				if($varResultsMatriId!=''){
					$varQueryPaidStatus		= "SELECT Paid_Status FROM memberinfo WHERE MatriId='".$varResultsMatriId."'";
					$varExecutePaidStatus	= mysql_query($varQueryPaidStatus);
					$varResultsPaidStatus	= mysql_fetch_assoc($varExecutePaidStatus);
					if($varResultsPaidStatus['Paid_Status']){ $varPaidStatus = "Paid"; }
				}
				echo $varPaidStatus;
				?></td></tr>
				<tr>
					<td  colspan="3" width="500" style="padding-left:3px;">
						<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" class="formborder">
							<tr class="adminformheader" height="25">
								<td class="smalltxt" align="left">&nbsp;&nbsp;Order Number</td>
								<td class="smalltxt" align="left">Gateway</td>
								<td class="smalltxt" align="left">MatriId</td>
								<td class="smalltxt" align="left">Amount</td>
								<td class="smalltxt" align="left">Track Date</td>
							</tr>
							<tr><td colspan="5"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="15"></td></tr>
						<? 
						$i=1;
						mysql_data_seek($varExecute, 0);
						while($varResults = mysql_fetch_array($varExecute)) {
						$varGatwayName	= '';
						$varGatwayName	= $arrBankName[$varResults['Gateway']] ? $arrBankName[$varResults['Gateway']] : 'Others';
						?>
							<tr>
								<td class="smalltxt clr3" align="left">&nbsp;&nbsp;<?=$varResults['OrderId'];?></td>
								<?
									$varOptimalCurrency = ''; $varOptimalAmountPaid = '';
									if($varResults['Gateway']=='3' && $varResults['Currency']!='Rs'){
									$varQueryOptimal = "SELECT Currency,Amount_Paid FROM preoptimalpaymenthistoryinfo WHERE OrderId='".$varResults['OrderId']."'";
									$varExecuteOptimal		= mysql_query($varQueryOptimal);
									$varResultsOptimalCount	= mysql_num_rows($varExecuteOptimal);
									if($varResultsOptimalCount>0){ 
										$varGatwayName .= " / ".$arrBankName[5];
										$varResultsOptimal		= mysql_fetch_assoc($varExecuteOptimal);
										$varOptimalCurrency	.= " / ".$varResultsOptimal['Currency']; 
										$varOptimalAmountPaid	= $varResultsOptimal['Amount_Paid'];
									}
								}
								?>
								<td class="smalltxt" align="left"><?=$varGatwayName;?></td>
								<td class="smalltxt" align="left"><?=$varResults['MatriId'];?></td>							
								<td class="smalltxt" align="left"><?=$varResults['Currency'].' '.$varResults['Amount_Paid'].''.$varOptimalCurrency.' '.$varOptimalAmountPaid;?></td>
								<td class="smalltxt" align="left"><?=date('Y-m-d',strtotime($varResults['Date_Paid']));?></td>
							</tr>
							<tr><td width="10" valign="top" height="2" colspan="7"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="10"></td></tr>

							<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="7"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

							<tr><td width="10" valign="top" height="2" colspan="7"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="10"></td></tr>

						<? $i++; }  ?>

						<tr><td width="10" valign="top" height="10" colspan="7"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="10"></td></tr>
						</form>
							<? } else { ?>

							<tr><td><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="25"></td></tr>
							<tr><td class="smalltxt boldtxt frmlftpad" align="center"><font color="red"><? 
								
							if ($varRecords=='0'&& $_REQUEST["send"]!="") { echo 'There is no records found!!!'; } 
							?></font></td></tr>

							<? } ?>

						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
<? $objDB->dbClose();
	UNSET($objDB);
?>