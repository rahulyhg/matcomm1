<?php
#================================================================================================================
# Author 		: N. Dhanapal
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================

//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=associates-login"</script>'; exit; }//if

//FILE INCLUDES
// /home/product/community/ability
$varRootBasePath        = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/payment.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//include_once($varRootBasePath.'/www/payment/paymentprocess.php');

//OBJECT DECLARTION
$objDB	= new DB;

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLES DECLARATIONS
$varResults		= 'no';
$arrCurrenyList		= array();
$varCondition		= " WHERE Franchisee_Id='".$varFranchiseeId."'";
$varFields			= array('Country');
$varExecute			= $objDB->select($varTable['FRANCHISEE'], $varFields, $varCondition, 0);
$varSelectCountry	= mysql_fetch_array($varExecute);
$varCountry			= $varSelectCountry["Country"];
$varCountryCode		= $varCountry;
include_once($varRootBasePath.'/www/payment/paymentprocess.php');

$varConverRate		= '';
$arrCurrenyList		= $arrRate[$varCountry];
if (count($arrCurrenyList)==0) { $arrCurrenyList = $arrRate["222"];$varCountry="222"; }

$varCurrencyCode1	= $arrCurrCode[$varCountry];


//CONTROL
	if ($_POST["frmAddPaymentSubmit"]=="yes" && $varFranchiseeId !="") {

		$varPaymentMode		= $_REQUEST["paymentMode"];
		$varCategory		= $_REQUEST["category"];
		$varMatriId			= $_REQUEST["matriId"];
		$varComments		= $_REQUEST["comments"];
		$varCurrentDate		= date("Y-m-d H:i:s");
		$varTotalNumDays	= $arrPkgValidDays[$varCategory];

		if ($varCountry!=98 && $varCountry!=222) { $varAmount = $arrUsdGatewayConver[$varCategory];  }
		else { $varAmount = $arrCurrenyList[$varCategory]; }

		$varCurrency = $varCurrencyCode1;

		if ($varCategory >=4 && $varCategory<=6) { $varSpecialPrev = 1; }
		else if ($varCategory >=7 && $varCategory<=9) { $varSpecialPrev = 2; }
		else { $varSpecialPrev = 0;}

		//OFFER PRODUCT ID
		$varOfferProductId	= 0;


		//CHECK FRANCHISEEPAYMENTS
		$varCondition			= " WHERE Franchisee_Id='".$varFranchiseeId."'";
		$varFields				= array('Credit_Balance');
		$varExecute				= $objDB->select($varTable['FRANCHISEE'], $varFields, $varCondition, 0);
		$varSelectCreditBalance	= mysql_fetch_array($varExecute);
		$varCreditBalance		= $varSelectCreditBalance["Credit_Balance"];

		// CHECK CREDIT BALANCE
		if (($varCreditBalance >= $varAmount) && $varAmount >0)
		{
			$varRemainingCreditBalance	= ($varCreditBalance - $varAmount);
			$varCondition				= " WHERE MatriId='".$varMatriId."'";
			$varNoOfRecords				= $objDB->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varCondition);

			if ($varNoOfRecords==1)
			{
				//SELECT PAYMMENT INFO
				$varFields			= array('MatriId','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as CurrentValidDays');
				$varExecute				= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
				$varSelectPaymentInfo	= mysql_fetch_array($varExecute);
				$varMatriId				= $varSelectPaymentInfo["MatriId"];
				$varOldValidDays		= $varSelectPaymentInfo["CurrentValidDays"];
				if (($varOldValidDays >0) && ($varOldValidDays !="")) { $varTotalNumDays = ($varOldValidDays + $varTotalNumDays); }//if

				//UPDATE MEMBERINFO TABLE
				$varCondition	= " MatriId ='".$varMatriId."'";
				$varFields		= array('Last_Payment','Valid_Days','Paid_Status','Phone_Verified','Publish','Number_Of_Payments','Expiry_Date','Date_Updated','Special_Priv');
				$varFieldsValue	= array('NOW()',$varTotalNumDays,'1','1','1','Number_Of_Payments+1','DATE_ADD(NOW(),INTERVAL '.$varTotalNumDays.' DAY)','NOW()',$varSpecialPrev);
				$objDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValue, $varCondition);
				$varOrderId	= $varMatriId."-".time();

				//INSERT PAYMENT TABLE
				$varFields	= array('OrderId','Franchisee_Id','MatriId','Product_Id','Offer_Product_Id','Amount_Paid','Package_Cost','Currency','Payment_Type','Payment_Mode','Comments','Date_Paid');
				$argFieldsValue	= array("'".$varOrderId."'",$varFranchiseeId,"'".$varMatriId."'","'".$varCategory."'","'".$varOfferProductId."'","'".$varAmount."'","'".$varAmount."'","'USD'",'100',"'".$varPaymentMode."'","'".$varComments."'",'NOW()');
				$objDB->insert($varTable['PAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

				//INSERT PHONE NUMBER 
				$varFields			= array('MatriId','TotalPhoneNos','NumbersLeft');
				$varFieldsValues	= array("'".$varMatriId."'","(TotalPhoneNos+".$arrPhonePackage[$varCategory].")","(NumbersLeft+".$arrPhonePackage[$varCategory].")");
				$objDB->insertOnDuplicate($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsValues, 'MatriId'); 

				//UPDATE MEMBERINFO TABLE
				$varCondition	= " Franchisee_Id ='".$varFranchiseeId."'";
				$varFields		= array('Credit_Balance');
				$varFieldsValue	= array($varRemainingCreditBalance);
				$objDB->update($varTable['FRANCHISEE'], $varFields, $varFieldsValue, $varCondition);
				$varResults	= 'yes';

			}
		} else { $varFracnchiseeBalance	= 'no'; }

	}//if

$varPaymentDetails	= '';

foreach($arrCurrenyList as $varKey=>$varValue){
	$varSelected = '';
	if($varCategory==$varKey) { $varSelected = ' selected '; } 

	if ($varCountry!='98' && $varCountry!='222')
	{ $varConverRate=' - <b>USD</b> '.$arrUsdGatewayConver[$varKey]; }

	$varPaymentDetails	.= '<option value="'.$varKey.'"'.$varSelected.'>'.$arrPrdPackages[$varKey].' '.$varCurrencyCode1.' '.$varValue.' '.$varConverRate.'</option>';

}//foreach

//UNSET OBJECT
$objDB->dbClose();
unset($objDB);

?>


<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr><td valign="middle" class="normtxt bld padt10">Upgrade A Member's Profile</td></tr>
	<tr><td class="smalltxt padtb10">You can introduce a new profile or upgrade an existing one.</td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="600">
	<?php if ($_POST["frmAddPaymentSubmit"]=="yes") { ?>
	<tr><td class="smalltxt" align="center">
	<?php
	if ($varFracnchiseeBalance	== 'no')
	{ echo '<b><font class="clr3">Check your credit balance.</font> You have only '.$varCreditBalance.'$</b>'; }
	else if ($varNoOfRecords==0) { echo '<font class="clr3"><b>This Matrimony Id is not available. Please check</b></font>'; }//if
	else
	{
		echo '<font class="clr3"><b>You have successfully made a payment for: '.$varMatriId.'. Track your balance.</b> </font>';
	}//else
	echo '</td></tr>';
	if ($varResults=='yes')
	{
	?>
		<tr><td height="10"></td></tr>
		<tr>
			<td colspan="2">
				<table border="0" cellpadding="3" cellspacing="2" width="250" align="center" >
					<tr><td class="smalltxt" height="10">Cost of profile upgrade</td><td class="smalltxt"><b>USD <?=$varAmount;?></b></td></tr>
					<tr><td class="smalltxt" height="10">Your previous balance</td><td class="smalltxt"><b>USD <?=$varCreditBalance;?></b></td></tr>
					<tr><td class="smalltxt" height="10">Amount deducted</td><td class="smalltxt"><b>USD <?=$varAmount;?></b></td></tr>
					<tr><td class="smalltxt" height="10">Your current balance</td><td class="smalltxt"><b>USD <?=$varRemainingCreditBalance;?></b></td></tr>
				</table>
			</td>
		</tr>
	<?php } }//if?>
</table>

<?php if ($varResults=='no') { ?>
<form name="frmAddPayment" method="post" onSubmit="return funUpgradeProfile();" style="padding:0px;margin:0px;">
<input type="hidden" name="frmAddPaymentSubmit" value="yes">
<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr>
		<td>
			<table border="0" cellpadding="6" cellspacing="6" width="594">
				<tr><td>
					<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="569">
						<tr><td colspan="3"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Matrimony Id</td>
							<td class="smalltxt"><input type="text" name="matriId" size="20" maxlength="25" value="<?=$varMatriId;?>" class="inputtext"></td>
						</tr>
						<tr><td colspan="3"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Payment Mode</td>
							<td>
								<select name="paymentMode" class="inputtext" style="width:130px;">
								<option value="">- Select Category -</option>
								<option value="2" <?=$varPaymentMode==2 ? "selected" : "";?>>Cheque</option>
								<option value="3" <?=$varPaymentMode==3 ? "selected" : "";?>>Demand Draft</option>
								<option value="4" <?=$varPaymentMode==4 ? "selected" : "";?>>Cash Payment</option>
								</select>
							</td>
						</tr>
						<tr><td colspan="3"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Category</td>
							<td class="smalltxt">
								<select name="category" class="inputtext" style="width:250px;">
									<option value="">- Select Category -</option>
									<?=$varPaymentDetails?>
								</select>
							</td>
						</tr>
						<tr><td colspan="3"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>

						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Comments</td>
							<td class="smalltxt"><textarea class="inputtext" rows="6" name="comments" style="width:250px;"><?=$varComments;?></textarea>&nbsp;</td>
						</tr>
					<!--form ends here-->
				</table>
			   </td></tr>
			</table>
		</td>
	</tr>
	<tr><td height="11"></td></tr>
	<tr>
		<td height="35" align="center"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="28" height="1"><input type="submit" class="button" value="Submit"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="18" height="1"><input type="reset" class="button" value="Clear"></td>
	</tr>
	</form>
</table>
<?php }//if ?>
