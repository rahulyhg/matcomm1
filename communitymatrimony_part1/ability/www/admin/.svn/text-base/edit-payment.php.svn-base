<?php
#================================================================================================================
# Author 		: N. Dhanapal
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/www/payment/paymentprocess.php');

//OBJECT DECLARTION
$objSlaveDB		= new DB;
$objMasterDB	= new MemcacheDB;

//DB CONNECTION
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varSelectPayment	= 'yes';
$arrCurrenyList		= array();
$varCurrencyList	= '';


if ($varOfferAvailable==1) { $arrCurrenyList = $arrOffRate; } else { $arrCurrenyList = $arrRate; }
$varCategoryList	= '';
foreach($arrCurrencyList as $varKey => $varValue) {
	$varCurrencyCode	= $varKey;
	$varCountryCode		= $varValue;
	$arrLocalCurrency	= $arrCurrenyList[$varValue];

	foreach($arrLocalCurrency	as $varKey1 => $varValue1) {
		$varCategoryList	.= '<option value="'.$varKey1.'">'.$arrPrdPackages[$varKey1].' '.$varCurrencyCode.' '.$varValue1.'</option>';

	}
}//foreach


if($_POST["edit"]=="true" && $_POST["frmAddPaymentSubmit"] !="yes") {

	$varUsername	= $_REQUEST["username"];
	$varPrimary		= $_REQUEST["primary"];//////


	$varCondition	= " WHERE (OrderId='".$varUsername."' OR MatriId='".$varUsername."' OR User_Name='".$varUsername."') ORDER BY Date_Paid DESC LIMIT 1 ";
	$varNoOfRecords	= $objSlaveDB->numOfRecords($varTable['PAYMENTHISTORYINFO'],'OrderId',$varCondition);

	if ($varNoOfRecords > 0) {
		$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Offer_Product_Id','Franchisee_Id','Branch_Id','Amount_Paid','Discount','Package_Cost','Currency','Payment_Category','Payment_Type','Payment_Mode','Cheque_DD_No','Cheque_DD_Date','Bank_Name','Payment_Point','Payment_Received','Voucher_Code','Receipt_No','Receipt_Date','Offer_Given','Comments','Date_Paid');
		$varExecute		= $objSlaveDB->select($varTable['PAYMENTHISTORYINFO'],$varFields,$varCondition,0);
		$varPaymentInfo	= mysql_fetch_assoc($varExecute);
		$varMatriId		= $varPaymentInfo["MatriId"];
		$varOrderId		= $varPaymentInfo["OrderId"];
		$varPaymentType	= $varPaymentInfo["Payment_Type"];
		$varPaymentMode	= $varPaymentInfo["Payment_Mode"];
		$varCurrency	= $varPaymentInfo["Currency"];
		$varProductId	= $varPaymentInfo["Product_Id"];
		$varAmount		= str_replace('.00','',$varPaymentInfo["Amount_Paid"]);
		$varComments	= $varPaymentInfo["Comments"];
		$varCategory	= $varValidDays."~".$varAmount."~".$varPaymentInfo["Currency"];
	}

	$varCondition	= " WHERE MatriId='".$varMatriId."'";
	$varNoOfRecords	= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varCondition);
	if ($varNoOfRecords > 0) {
		$varFields		= array('MatriId','User_Name','Valid_Days','Number_Of_Payments');
		$varExecute		= $objSlaveDB->select($varTable['MEMBERINFO'],$varFields,$varCondition,0);
		$varMemberInfo	= mysql_fetch_assoc($varExecute);
		$varMatriId		= $varMemberInfo["MatriId"];
		$varUsername	= $varMemberInfo["User_Name"];
		$varValidDays	= $varMemberInfo["Valid_Days"];
		$varNoOfPayments= ($varMemberInfo["Number_Of_Payments"]-1);
		if ($varNoOfPayments < 0) { $varNoOfPayments=0; }
		
	}
	if ($varNoOfRecords==0){ $varSelectPayment = "no";}//if

}//if

//UPDATE  HERE 
if ($_POST["frmAddPaymentSubmit"]=="yes") {
	
	$varMatriId			= $_REQUEST["matriId"];
	$varOrderId			= $_REQUEST["OrderId"];
	$varPaymentMode		= $_REQUEST["paymentMode"];
	$varCategory		= $_REQUEST["category"];
	$varPaymentType		= $_REQUEST["paymentType"];
	$varAmount			= $varCategory=='Cancel' ? '' : $_REQUEST["amountReceived"];
	$varComments		= $_REQUEST["comments"];
	$varCurrentDate		= date("Y-m-d H:i:s");
	$varSplitCategory	= explode("~",$varCategory);
	$varValidDays		= $varSplitCategory[0];
	$varActualAmount	= $varSplitCategory[1];
	$varCurrency		= $varSplitCategory[2];

	$varCondition	= " OrderId ='".$varOrderId."'";
	$varFields		= array('Amount_Paid','Package_Cost','Discount','Currency','Voucher_Code','Comments');
	$varFieldsValue	= array('\'\'','\'\'','\'\'','\'\'','\'\'',"'".$varComments."'");
	$objMasterDB->update($varTable['PAYMENTHISTORYINFO'], $varFields, $varFieldsValue, $varCondition);

	if ($varCategory=='Cancel') {
		//SETING MEMCACHE KEY
		$varProfileMCKey= 'ProfileInfo_'.$varMatriId;

//echo $varCategory;
		$varCondition	= " MatriId ='".$varMatriId."'";
		$varFields		= array('TotalPhoneNos','NumbersLeft');
		$varFieldsValue	= array('0','0');
		$objMasterDB->update($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsValue, $varCondition);

		$varFields		= array('Valid_Days','Last_Payment','Expiry_Date','Special_Priv','Paid_Status','Number_Of_Payments');
		$varFieldsValue	= array('0','\'0000-00-00 00:00:00\'','\'0000-00-00 00:00:00\'','0','0',"'".$varNoOfPayments."'");
		$objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValue, $varCondition, $varProfileMCKey);
	}
	$varResults=1;
}//if

?>


<script language="javascript">
function funValidatePayment()
{
	var funFormName	= document.frmAddPayment;
	if (funFormName.paymentMode.value=="") {
		alert("please select payment mode");
		funFormName.paymentMode.focus();
		return false;
	}//if
	if (funFormName.category.value=="") {
		alert("please select Category");
		funFormName.category.focus();
		return false;
	}//if
	if (funFormName.paymentType.value=="") {
		alert("please payable at");
		funFormName.paymentType.focus();
		return false;
	}//if
	if (funFormName.amountReceived.value=="") {
		alert("please enter amount");
		funFormName.amountReceived.focus();
		return false;
	}//if
	if (funFormName.username.value=="") {
		alert("please enter Login Name");
		funFormName.username.focus();
		return false;
	}//if
	if (!(funFormName.primary[0].checked==true || funFormName.primary[1].checked==true || funFormName.primary[2].checked==true)) {
		alert("Please select Username / Matrimony Id / Order Id");
		funFormName.primary[0].focus();
		return false;
	}//if
	if (funFormName.comments.value=="") {
		alert("please enter comments");
		funFormName.comments.focus();
		return false;
	}//if

	return true;
}//funValidatePayment
</script>

<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr><td valign="middle" class="heading">Edit Payment</td></tr>
<?php if ($varSelectPayment=='yes') { ?>
	<tr><td height="15"></td></tr>
	<tr><td class="smalltxt"><b>&nbsp;OrderId</b> : <font color="red"><b><?=$varOrderId;?></b></font></td></tr>
	<tr><td height="10"></td></tr>
	<?php if ($_POST["frmAddPaymentSubmit"]=="yes") { ?>
	<tr><td class="smalltxt" align="center">
	<?php if ($varNoOfRecords==0 && $varResults!=1)
	{
		echo '<font color="red"><b>This '.str_replace("_"," ",$varPrimary).' is not available. Please check</b></font>';
	}//if
	if ($varResults==1)
	{
		echo '<font class="smalltxt"><b>Payment updated successfully for this Order Id <font color="red">'.$varOrderId.'</b></font>';
	}//else
	echo '</td></tr>';
	}//if?>
<tr><td height="10"></td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="600" align="left">
	<form method="post" name="frmAddPayment" onSubmit="return funValidatePayment();">
	<input type="hidden" name="frmAddPaymentSubmit" value="yes">
	<input type="hidden" name="OrderId" value="<?=$varOrderId;?>">
	<input type="hidden" name="productId" value="<?=$varProductId;?>">
	<input type="hidden" name="matriId" value="<?=$varMatriId;?>">
	<tr>
		<td>
			<table border="0" cellpadding="6" cellspacing="6" width="600">
				<tr><td>
					<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="100%">
						<tr><td class="smalltxt" colspan="3"><IMG height="1" src="<?=$confValues["IMGSURL"];?>/trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Payment Mode</td>
							<td>
								<select name="paymentMode" class="smalltxt">
								<option value="">- Select Category -</option>
								<option value="2" <?=$varPaymentMode==2 ? "selected" : "";?>>Check</option>
								<option value="3" <?=$varPaymentMode==3 ? "selected" : "";?>>Demand Draft</option>
								<option value="4" <?=$varPaymentMode==4 ? "selected" : "";?>>Cash Payment</option>
								<option value="1" <?=$varPaymentMode==1 ? "selected" : "";?>>Online</option>
								<option value="5" <?=$varPaymentMode==5 ? "selected" : "";?>>Direct Deposit</option>
								</select>
							</td>
						</tr>
						<tr><td class="smalltxt" colspan="3"><IMG height="1" src="<?=$confValues["IMGSURL"];?>/trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Category</td>
							<td class="smalltxt">
								<select name="category" class="smalltxt">
									<option value="">- Select Category -</option>
									<option value="Cancel">Cancel</option>
									<?=$varCategoryList?>
								</select>
							</td>
						</tr>
						<tr><td class="smalltxt" colspan="3"><IMG height="1" src="<?=$confValues["IMGSURL"];?>/trans.gif"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Payable At</td>
							<td>
								<select name="paymentType" class="smalltxt">
									<option value="">- Select Place -</option>
									<option value="2" <?=$varPaymentType=="2" ? "selected" : "";?>>Chennai</option>
									<option value="1" <?=$varPaymentType=="1" ? "selected" : "";?>>Online</option>
									<option value="3" <?=$varPaymentType=="3" ? "selected" : "";?>>Dubai</option>
									<option value="4" <?=$varPaymentType=="4" ? "selected" : "";?>>US</option>
								</select>
							</td>
						</tr>
						<tr><td class="smalltxt" colspan="3"><IMG height="1" src="<?=$confValues["IMGSURL"];?>/trans.gif"></td></tr>	
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align="left">Amount Received</td>
							<td class="smalltxt"><input type="text" name="amountReceived" value="<?=$varCurrency.' '.$varAmount;?>"></td>
						</tr>

						<tr><td class="smalltxt" colspan="3"><IMG height="1" src="<?=$confValues["IMGSURL"];?>/trans.gif"></td></tr>
											
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left>Comments</td>
							<td class="smalltxt"><textarea cols="45" rows="6" name="comments"><?=$varComments;?></textarea>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" class="smalltxt"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="438" height="5"></td>
						</tr>
					<!--form ends here-->
				</table>				
			   </td></tr>
			</table>
		</td>
	</tr>
	<tr><td height="11"></td></tr>
	<tr>
		<td align="center"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="28" height="5"><input type='submit' class="button" value="Submit"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="18" height="5"><input type="reset" class="button" class="button" onClick="document.frmAddPayment.reset();return false;"></td>
	</tr>
	<tr>
		<td class="smalltxt"><img src="<?=$confValues["IMGSURL"];?>/trans.gif"  height="12"></td>
	</tr>
	</form>
<?php } else { ?>
	<tr><td class="smalltxt" align="center"><font color="red"><b>Sorry no records found</b></font></td></tr>
	<tr><td class="smalltxt" align="center" height="20"></td></tr>
<?php } ?>
</table>