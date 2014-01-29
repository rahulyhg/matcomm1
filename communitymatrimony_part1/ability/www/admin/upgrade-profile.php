<?php
#================================================================================================================
# Author 		: N. Dhanapal
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================
//CHECK ALREADY LOGGED USER
if($sessFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=associates-login"</script>'; exit; }//if

//FILE INCLUDES
include_once('includes/clsAffiliates.php');

//OBJECT DECLARATION
$objAffiliates = new Affiliates;

//VARIABLES DECLARATIONS
$varResults		= 'no';

//CONTROL 
	if ($_POST["frmAddPaymentSubmit"]=="yes" && $sessFranchiseeId !="")
	{
		$varPaymentMode					= $_REQUEST["paymentMode"];
		$varCategory					= $_REQUEST["category"];
		$varUsername					= $_REQUEST["username"];
		$varComments					= $_REQUEST["comments"];
		$varCurrentDate					= date("Y-m-d H:i:s");
		$varSplitCategory				= explode("~",$varCategory);
		$varValidDays					= $varSplitCategory[0];
		$varAmount						= $varSplitCategory[1];
		$varCurrency					= $varSplitCategory[2];

		//CHECK FRANCHISEEPAYMENTS
		$objAffiliates->clsTable		= 'franchisee';
		$objAffiliates->clsCountField	= 'Franchisee_Id';
		$objAffiliates->clsPrimary		= array('Franchisee_Id');
		$objAffiliates->clsPrimaryValue	= array($sessFranchiseeId);
		$objAffiliates->clsFields		= array('Credit_Balance');
		$objAffiliates->clsPrimarySymbol= array('=');
		$varSelectFranchiseePaymentInfo	= $objAffiliates->selectAffiliates();
		$varCreditBalance				= $varSelectFranchiseePaymentInfo["Credit_Balance"];

		// CHECK CREDIT BALANCE
		if ($varCreditBalance >= $varAmount)
		{
			//$varCalculateCommission		= (30/100 * $varAmount);
			//$varBalanceAmount				= ($varAmount - $varCalculateCommission);
			//$varRemainingCreditBalance	= ($varCreditBalance - $varBalanceAmount);
			$varRemainingCreditBalance		= ($varCreditBalance - $varAmount);
			$objAffiliates->clsTable		= 'memberlogininfo';
			$objAffiliates->clsCountField	= 'MatriId';
			$objAffiliates->clsPrimary		= array('User_Name');
			$objAffiliates->clsPrimaryValue	= array($varUsername);
			$objAffiliates->clsPrimarySymbol= array('=');
			$varNoOfRecords					= $objAffiliates->numOfResults();
			if ($varNoOfRecords==1)
			{
				//SELECT PAYMMENT INFO
				$objAffiliates->clsFields	= array('MatriId','Date_Paid','Valid_Days');
				$varSelectPaymentInfo	= $objAffiliates->selectAffiliates();
				$varPaidDate			= $varSelectPaymentInfo["Date_Paid"];
				$varMatriId				= $varSelectPaymentInfo["MatriId"];
				$varOldValidDays		= $varSelectPaymentInfo["Valid_Days"];
				$varExplodeDays			= explode("~",$varCategory);
				$varNewValidDays		= $varExplodeDays[0];
				if ($varOldValidDays > 0)
				{
					//echo 'IF';
					$varTodayDate		= date('m-d-Y');
					$varPaidDate		= date('m-d-Y',strtotime($varPaidDate));
					$varNumOfDays		= $objAffiliates->dateDiff("-",$varTodayDate,$varPaidDate);
					$varRemainingDays	= $varOldValidDays - $varNumOfDays;
					$varTotalNumDays	= ($varNewValidDays + $varRemainingDays);
				}//if
				else { $varTotalNumDays	= $varNewValidDays; }

				//echo $varTotalNumDays;
				//INSERT LOGIN TABLE
				$objAffiliates->clsFields		= array('Paid_Status','Date_Paid','Valid_Days');
				$objAffiliates->clsFieldsValues	= array('1',$varCurrentDate,$varTotalNumDays);
				$objAffiliates->updateAffiliates();

				$varOrderId				= $varMatriId."-".time();
				$objAffiliates->clsTable	= 'paymenthistoryinfo';
				$objAffiliates->clsFields		= array('OrderId','Franchisee_Id','MatriId','Amount_Paid','Currency','Payment_Type','Payment_Mode','Comments','Date_Paid');
				$objAffiliates->clsFieldsValues	= array($varOrderId,$sessFranchiseeId,$varMatriId,$varAmount,$varCurrency,'100',$varPaymentMode,$varComments,$varCurrentDate);
				$objAffiliates->addAffiliates();

				$objAffiliates->clsTable		= 'franchisee';
				$objAffiliates->clsPrimary		= array('Franchisee_Id');
				$objAffiliates->clsPrimaryValue	= array($sessFranchiseeId);
				$objAffiliates->clsFields		= array('Credit_Balance');
				$objAffiliates->clsFieldsValues	= array($varRemainingCreditBalance);
				$objAffiliates->updateAffiliates();

				$varResults	= 'yes';

			}	
		}//if
		else { $varFracnchiseeBalance	= 'no'; }

	}//if
?>

<script language="javascript" src="includes/affiliates.js" type="text/javascript"></script>

<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr><td valign="middle" class="heading">Upgrade A Member's Profile</td></tr>
	<tr><td height="10"></td></tr>
	<tr><td class="smalltxt"><div style="padding-left:5px;padding-bottom:15px !important;padding-bottom:10px">You can introduce a new profile or upgrade an existing one.</div></td></tr>
</table>
<?php include_once('includes/top-menu.php'); ?><br>

<table border="0" cellpadding="0" cellspacing="0" width="600">
	<?php if ($_POST["frmAddPaymentSubmit"]=="yes") { ?>
	<tr><td class="smalltxt" align="center">
	<?php 
	if ($varFracnchiseeBalance	== 'no')
	{ echo '<b><font color="red">Check your credit balance.</font> You have only '.$varCreditBalance.'$</b>'; }
	else if ($varNoOfRecords==0) { echo '<font color="red"><b>This Username is not available. Please check</b></font>'; }//if
	else
	{
		echo '<font class="errorMsg"><b>You have successfully made a payment for: '.$varUsername.'. Track your balance.</b> </font>';
	}//else
	echo '</td></tr>';
	if ($varResults=='yes')
	{
	?>
		<tr><td height="10"></td></tr>
		<tr>
			<td colspan="2">
				<table border="0" cellpadding="3" cellspacing="2" width="250" align="center" class="mailbxstalbg">
					<tr><td class="smalltxt" height="10">Cost of profile upgrade</td><td class="smalltxt"><b><?=$varCurrency.' '.$varAmount;?></b></td></tr>
<!-- 					<tr><td class="smalltxt" height="10">Your Commission</td><td class="smalltxt"><b><?=$varCurrency.' '.$varCalculateCommission;?></b></td></tr> -->
					<tr><td class="smalltxt" height="10">Your previous balance</td><td class="smalltxt"><b><?=$varCurrency.' '.$varCreditBalance;?></b></td></tr>
					<tr><td class="smalltxt" height="10">Amount deducted</td><td class="smalltxt"><b><?=$varCurrency.' '.$varAmount;?></b></td></tr>
					<tr><td class="smalltxt" height="10">Your current balance</td><td class="smalltxt"><b><?=$varCurrency.' '.$varRemainingCreditBalance;?></b></td></tr>
				</table>
			</td>
		</tr>
	<?php } }//if?>
</table>

<?php if ($varResults=='no') { ?>
<form name="frmAddPayment" method="post" onSubmit="return funUpgradeProfile();">
<input type="hidden" name="frmAddPaymentSubmit" value="yes">
<table border="0" cellpadding="0" cellspacing="0" width="600" align="left">
	<tr>
		
		<td>
			<table border="0" cellpadding="6" cellspacing="6" class="serboxtitle2" width="600">
				<tr><td>
					<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="100%">
						<tr><td class="mailbxstalbg" colspan="3"><IMG height="1" src="../images/mm_trans.gif"></td></tr>	
						<tr height="28" valign="middle">
							<td class="textsmallbolda" valign=middle style="padding-left:5px;" align=left>Username</td>
							<td class="smalltxt"><input type="text" name="username" size="20" maxlength="25" value="<?=$varUsername;?>" class="normaltxt1"></td>
						</tr>
						<tr><td class="mailbxstalbg" colspan="3"><IMG height="1" src="../images/mm_trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="textsmallbolda" valign=middle style="padding-left:5px;" align=left>Payment Mode</td>
							<td>
								<select name="paymentMode" class="comboBox">
								<option value="">- Select Category -</option>
								<option value="2" <?=$varPaymentMode==2 ? "selected" : "";?>>Check</option>
								<option value="3" <?=$varPaymentMode==3 ? "selected" : "";?>>Demand Draft</option>
								<option value="4" <?=$varPaymentMode==4 ? "selected" : "";?>>Cash Payment</option>
								</select>
							</td>
						</tr>
						<tr><td class="mailbxstalbg" colspan="3"><IMG height="1" src="../images/mm_trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="textsmallbolda" valign=middle style="padding-left:5px;" align=left>Category</td>
							<td class="smalltxt">
								<select name="category" class="comboBox">
									<option value="">- Select Category -</option>
<!--<option value="90~1590~Rs." <?=$varCategory=="90~1590~Rs." ? "selected" : "";?>>3 Months (Rs. 1590)</option>
<option value="180~2690~Rs." <?=$varCategory=="180~2690~Rs." ? "selected" : "";?>>6 Months (Rs. 2690)</option>
<option value="270~3440~Rs." <?=$varCategory=="270~3440~Rs." ? "selected" : "";?>>9 Months (Rs. 3440)</option>-->
<option value="90~54~USD" <?=$varCategory=="90~54~USD" ? "selected" : "";?>>3 Months (US Dollar 54)</option>
<option value="180~92~USD" <?=$varCategory=="180~92~USD" ? "selected" : "";?>>6 Months (US Dollar 92)</option>
<option value="270~118~USD" <?=$varCategory=="270~118~USD" ? "selected" : "";?>>9 Months (US Dollar 118)</option>
<option value="90~57~USD" <?=$varCategory=="90~57~USD" ? "selected" : "";?>>3 Months (Malaysia Ringgit 190 - $57)</option>
<option value="180~97~USD" <?=$varCategory=="180~97~USD" ? "selected" : "";?>>6 Months (Malaysia Ringgit 325 - $97)</option>
<option value="270~119~USD" <?=$varCategory=="270~119~USD" ? "selected" : "";?>>9 Months (Malaysia Ringgit 400 - $119)</option>
<option value="90~52~USD" <?=$varCategory=="90~52~USD" ? "selected" : "";?>>3 Months (UK Pound  25 - $52)</option>
<option value="180~94~USD" <?=$varCategory=="180~94~USD" ? "selected" : "";?>>6 Months (UK Pound  45 - $94)</option>
<option value="270~115~USD" <?=$varCategory=="270~115~USD" ? "selected" : "";?>>9 Months (UK Pound  55 - $115)</option>
<option value="90~44~USD" <?=$varCategory=="90~44~USD" ? "selected" : "";?>>3 Months (Indonesia Rupiah 400,000 - $44)</option>
<option value="180~77~USD" <?=$varCategory=="180~77~USD" ? "selected" : "";?>>6 Months (Indonesia Rupiah 700,000 - $77)</option>
<option value="270~110~USD" <?=$varCategory=="270~110~USD" ? "selected" : "";?>>9 Months (Indonesia Rupiah 1000,000 - $110)</option>
<option value="90~54~USD" <?=$varCategory=="90~54~USD" ? "selected" : "";?>>3 Months (AED 200 - $54)</option>
<option value="180~89~USD" <?=$varCategory=="180~89~USD" ? "selected" : "";?>>6 Months (AED 325 - $89)</option>
<option value="270~116~USD" <?=$varCategory=="270~116~USD" ? "selected" : "";?>>9 Months (AED 425 - $116)</option>


								</select>
							</td>
						</tr>
						<tr><td class="mailbxstalbg" colspan="3"><IMG height="1" src="../images/mm_trans.gif"></td></tr>
										
						<tr height="28" valign="middle">
							<td class="textsmallbolda" valign=middle style="padding-left:5px;" align=left>Comments</td>
							<td class="smalltxt"><textarea cols="40" rows="6" name="comments"><?=$varComments;?></textarea>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" class="lastnull"><img src="../images/mm_trans.gif" width="438" height="5"></td>
						</tr>
					<!--form ends here-->
				</table>				
			   </td></tr>
			</table>
		</td>
	</tr>
	<tr><td height="11"></td></tr>
	<tr>
		<td align="center"><img src="../images/mm_trans.gif" width="28" height="5"><input type='image' src="../images/submit.gif" border="0" align="top" ><img src="../images/mm_trans.gif" width="18" height="5"><input type="image" src="../images/reset.gif" border="0" align="top" onClick="document.frmAddPayment.reset();return false;" ></td>
	</tr>
	<tr>
		<td class="lastnull"><img src="../images/mm_trans.gif"  height="12"></td>
	</tr>
	</form>
</table>
<?php }//if ?>
<br>