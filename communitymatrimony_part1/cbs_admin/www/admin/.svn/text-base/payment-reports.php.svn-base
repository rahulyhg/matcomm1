<?php
#================================================================================================================
# Author 		: N.Dhanapal
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================
//ini_set('display_errors','On');
//FILE INCLUDES
include_once('../reports/includes/clsReport.php');

//OBJECT DECLARTION
$objReport	= new Report;

//CONTROL STATEMENT
if ($_POST["frmPaymentReportSubmit"]=="yes")
{
	//mm/dd/yyyy
	$varSplitSDate 				= explode("/",$_REQUEST["startDate"]);
	$varSplitEndDate 			= explode("/",$_REQUEST["endDate"]);
	$varStartDate 				= trim($varSplitSDate[2]."-".$varSplitSDate[0]."-".$varSplitSDate[1]).' 00:00:00';
	$varEndDate 				= trim($varSplitEndDate[2]."-".$varSplitEndDate[0]."-".$varSplitEndDate[1]).' 23:59:59';
	$objReport->clsTable		= "paymenthistoryinfo";
	$objReport->clsFields 		= array('MatriId','Amount_Paid','Currency','Comments','Date_Paid');
	$objReport->clsPrimary      = array('Date_Paid','Date_Paid');
	$objReport->clsPrimarySymbol= array('>=','<=');
	$objReport->clsPrimaryValue = array($varStartDate,$varEndDate);
	$objReport->clsPrimaryKey	= array('AND');
	$objReport->clsAllowedLimit	= "no";
	$varSelectPaymentInfo		= $objReport->multiSelectInfo();
	$varNumOfRecords			= count($varSelectPaymentInfo);


	//SELECT PAYMENT TOTAL
	$objReport->clsFields 		= array('Currency','Amount_Paid');
	$varSelectPaymentTotal		= $objReport->selectPaymentTotal($varStartDate,$varEndDate);
}//if
?>
<script language="javascript" src="includes/calender.js"></script>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="600">
	<tr>
		<td valign="top" bgcolor="#FFFFFF" width="600">
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="600">
				<tr><td valign="top" bgcolor="#FFFFFF" style="padding-bottom:10px;" class="heading">Payment Statistics</td></tr>
				<?php if ($_POST["frmPaymentReportSubmit"]=="yes" && $varNumOfRecords==0) { ?>
				<tr><td align="center" class="errorMsg" height="25"><font color="red">There are no payments available.</font></td></tr>
				<tr><td align="center" class="errorMsg" height="10"></td></tr>
				<?php }//if ?>
				<tr>
					<td colspan="2">
						<form name="frmPaymentReport" method="post" onSubmit="return funViewPaymentReports();">
						<input type="hidden" name="frmPaymentReportSubmit" value="yes">
						<table cellspacing="0" cellpadding="0" border="0" width="100%" align="center">
							<tr>
								<td width="12%" height="38px" valign="top" class="textsmallbolda">Start Date</td>
								<td width="25%" class="smalltxt"><input type="text" name="startDate" size="15" class="smalltxt" value="<?=$_REQUEST["startDate"];?>"> <a 
                                href="javascript:javascript:cal5.popup();"><img src="images/calbtn.gif" align="absMiddle" 
                                border="0"></a><br><b>(mm/dd/yyyy)</b></td>
								<td width="10%" height="38px" valign="top" class="textsmallbolda">End Date</td>
								<td width="25%" align="left" class="smalltxt"><input type="text" name="endDate" size="15" class="smalltxt" value="<?=$_REQUEST["endDate"];?>"> <a 
                                href="javascript:javascript:cal6.popup();"><img src="images/calbtn.gif" align="absMiddle" 
                                border="0"></a><br><b>(mm/dd/yyyy)</b></td>
								<td  width="18%" valign="top"> <input type="image" align="absmiddle" src="../images/search.gif"></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			<?php if ($varNumOfRecords > 0) { ?>
				<tr><td class="smalltxt" height="25"><b>Total Payments : <?=$varNumOfRecords;?></b></td></tr>
			<? }//if?>
			</table>
			<?php if ($varNumOfRecords > 0) { ?>

			<table border="0" class="myprofsubbg"  cellpadding="0" cellspacing="1" align="left" width="600">
				<tr>
					<td valign="top" width="600" bgcolor="#FFFFFF">
						<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
						<tr height="25">
							<td class="mailerEditTop" width="15%">UserId</td>
							<td class="mailerEditTop" width="25%">Amount</td>
							<td class="mailerEditTop" width="20%">Payment Date</td>
							<td class="mailerEditTop" width="40%">Comments</td>
						</tr>
						<?php
							for ($i=0;$i<$varNumOfRecords;$i++)
							{
								$varAmount		= $varSelectPaymentInfo[$i]["Amount_Paid"];
								$varCurrency	= $varSelectPaymentInfo[$i]["Currency"];
								 $varDate_Paid = $objReport->getDateMothYear('d-M-Y',$varSelectPaymentInfo[$i]["Date_Paid"]);
						?>
						<tr>
							<td class="smalltxt">&nbsp;<?=$varSelectPaymentInfo[$i]["MatriId"];?></td>
							<td class="smalltxt"><?=$varCurrency." ".$varAmount;?></td>
							<td class="smalltxt"><?=$varDate_Paid ? $varDate_Paid : "-";?></td>
							<td class="smalltxt"><?=$varSelectPaymentInfo[$i]["Comments"];?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<?}//if?>
						</table>
					</td>
				</tr>
			</table>
		<tr>
			<td valign="top">
			<table border="0" cellpadding="0" cellspacing="1" align="left" width="600">
				<tr><td height="20" class="smalltxt"><b>Total:</b></td></tr>
				<?php 
					//$varTotalAmount	= '0';
					for($i=0;$i<count($varSelectPaymentTotal);$i++){
					echo '<tr bgcolor="#FFFFFF" height="20"><td class="smalltxt" widht="25%" align="left">&nbsp&nbsp<b>';
					$varCurrency	= trim($varSelectPaymentTotal[$i]["Currency"]);
					$varAmount		= trim($varSelectPaymentTotal[$i]["Amount_Paid"]);
					echo $varCurrency." ".$varAmount;
					/*if (($varCurrency=='USD') || ($varCurrency=='US$'))
					{
						$varTotalAmount = ($varTotalAmount + $varAmount);
						echo $varCurrency." ".$varTotalAmount; 
					}//if
					else { echo $varCurrency." ".$varAmount; }//if*/
					echo '</b></td></tr>';

				} ?>
			</table>
		</td>
	</tr>
			<?php }//if ?>		
		</td>
	</tr>
	<tr><td height="25"></td></tr>
</table>

<?php
//UNSET OBJECT
unset($objReport);
?>
<script language="javascript">
function funViewPaymentReports()
{
	var frmName = document.frmPaymentReport;
	if (frmName.startDate.value=="")
	{
		alert("Please select start date");
		frmName.startDate.focus();
		return false;
	}//if
	if (frmName.endDate.value=="")
	{
		alert("Please select end date");
		frmName.endDate.focus();
		return false;
	}//if
	return true;
}//funViewPaymentReports
</script>
<script language="JavaScript">
	var cal5 = new calendar2(document.forms['frmPaymentReport'].elements['startDate']);
	cal5.year_scroll = true;
	cal5.time_comp = false;
	var cal6 = new calendar2(document.forms['frmPaymentReport'].elements['endDate']);
	cal6.year_scroll = false;
	cal6.time_comp = false;
</script>