<?php
#================================================================================================================
# Author 		: N. Dhanapal
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Admin	-	Add payment
#================================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/conf/payment.inc');
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath.'/www/payment/paymentprocess.php');

//OBJECT DECLARTION
$objMasterDB = new MemcacheDB;
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLERATION
$varCurrentValidDays= 0;
$varMatriID			= 0;
$varCheckLogin		= 0;
$varOrderProcess	= 'no';
$varDuplicatPayment	= 'no';
$varSubmit			= $_POST["frmAddPaymentSubmit"];
$arrCurrenyList		= array();
$arrCurrencyList	= array ('IN'=>98,'US'=>222,'UK'=>221,'AED'=>220,'EURO'=>21);


if ($varOfferAvailable==1) { $arrCurrenyList = $arrOffRate; } else { $arrCurrenyList = $arrRate; }

//CONTROL 
if ($varSubmit== "yes") {
	$varCurrentDate				= date("Y-m-d H:i:s");
	$varLoginUserName			= trim($_POST["userName"]);
	$varLoginPassword			= trim($_POST["password"]);
	$varPaymentMode				= trim($_POST["paymentMode"]);
	$varChequeDDNumber			= trim($_POST["chequeDDNumber"]);
	$varChequeDate				= trim($_POST["chequeDate"]);
	$varBankName				= trim($_POST["bankName"]);
	$varCurrencyMode			= trim($_POST["currencyMode"]);
	$varSplit1					= split('~',$varCurrencyMode);
	$varCurrency				= trim($varSplit1[0]);

	$varCategory				= trim($_POST["category"]);
	$varSplit					= split('~',$varCategory);
	$varCountryCode				= trim($varSplit[0]);

	$varCategory				= trim($varSplit[1]);
	$varNewDays					= $arrPkgValidDays[$varCategory]; ///New Valid days
	$varPaymentType				= trim($_POST["paymentType"]);
	$varAmountPaid				= trim($_POST["amountReceived"]);
	$varActualAmount			= trim($_POST["actualAmount"]);
	$varDiscountPercentage		= trim($_POST["discountPercent"]);
	$varPaymentPoint			= trim($_POST['paymentPoint']);
	$varDirectDeposit			= trim($_POST['directDeposit']);
	$varReceiptNumber			= trim($_POST["receiptNumber"]);
	$varReceiptDate				= trim($_POST["receiptDate"]);
	$varUsernameMatriID			= trim($_POST["userNameMatriId"]);
	$varComments				= trim($_POST["comments"]);
	$varPrimary					= trim($_POST["primary"]);
	$varSpecialPrev				= ($varCategory >=4 && $varCategory<=6)? 1 : ($varCategory >=7 && $varCategory <=9)? 2 : 0;

	//SUPERADMIN VALIDATION
	$varCondition	= " WHERE User_Name='".$varLoginUserName."' AND Password='".md5($varLoginPassword)."' AND User_Type<>2";
	$varCheckLogin	= $objMasterDB->numOfRecords($varTable['ADMINLOGININFO'], 'User_Name', $varCondition);

	if ($varCheckLogin == 1) {

		//USERNAME / MATRIID VALIDATION
		$varCondition			= " WHERE ".$varPrimary."='".$varUsernameMatriID."'";
		$varCheckUserLogin		= $objMasterDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varCondition);

		if ($varCheckUserLogin	> 0) {
			$varFields			= array('MatriId','User_Name','Valid_Days','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as CurrentValidDays');
			$varExecute			= $objMasterDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
			$varMemberInfo		= mysql_fetch_assoc($varExecute);
			$varPaymentMatriId	= $varMemberInfo["MatriId"];
			$varPaymentUsername	= $varMemberInfo["User_Name"];
			$varValidDays		= $varMemberInfo["Valid_Days"];
			$varCurrentValidDays= $varMemberInfo["CurrentValidDays"];
			$varCurrentValidDays= ($varCurrentValidDays>0) ? $varCurrentValidDays : 0;	 
			$varTotalDays = ($varCurrentValidDays + $varNewDays);
			$varMatriID			=	1;
			$varOrderId			= $varPaymentMatriId.'-'.date('Y').date('m').date('d').'-'.$varPaymentUsername;
		}

		//CHECK DUPLICATE ORDER ID.
		$varCondition	= " WHERE OrderId ='".$varOrderId."'";
		$varNoOfRecords = $objMasterDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], 'OrderId', $varCondition);
		if ($varNoOfRecords==1) { 
			$varDisplayMessage = "Duplicate Order Id <b>".$varOrderId.'</b>';
			$varOrderProcess = 'yes'; 
		}//if


		//ADD NEW RECORDS
		if ($varMatriID	!=	0 && $varOrderProcess == 'no') {

			$varCondition	= " MatriId ='".$varPaymentMatriId."'";
			//SETING MEMCACHE KEY
			$varProfileMCKey= 'ProfileInfo_'.$varPaymentMatriId;

			$varFields		= array('Last_Payment','Valid_Days','Paid_Status','Phone_Verified','Publish','Number_Of_Payments','Expiry_Date','Date_Updated','Special_Priv');
			$varFieldsValue	= array("'".$varCurrentDate."'",$varTotalDays,'1','1','1','Number_Of_Payments+1','DATE_ADD(\''.$varCurrentDate.'\',INTERVAL '.$varTotalDays.' DAY)','NOW()',$varSpecialPrev);
			$objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValue, $varCondition,$varProfileMCKey);

#payment Mode	=> Check DD
#paymentType		=> Online, Chennai....
			//INSERT PAYMENT TABLE
			$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Offer_Product_Id','Branch_Id','Amount_Paid','Discount','Package_Cost','Currency','Payment_Category','Payment_Type','Payment_Mode','Cheque_DD_No','Cheque_DD_Date','Bank_Name','Payment_Point','Payment_Received','Receipt_No','Receipt_Date','Comments','Date_Paid');
			$argFieldsValue	= array("'".$varOrderId."'","'".$varPaymentMatriId."'","'".$varPaymentUsername."'","'".$varCategory."'","'".$varOfferProductId."'",'\'\'',"'".$varAmountPaid."'","'".$varDiscountPercentage."'","'".$varActualAmount."'","'".$varCurrency."'",'\'\'',"'".$varPaymentType."'","'".$varPaymentMode."'","'".$varChequeDDNumber."'","'".$varChequeDate."'","'".$varBankName."'","'".$varPaymentPoint."'","'".$varDirectDeposit."'","'".$varReceiptNumber."'","'".$varReceiptDate."'","'".$varComments."'","'".$varCurrentDate."'");
			$objMasterDB->insert($varTable['PAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

			//INSERT PHONE NUMBER 
			$varFields			= array('MatriId','TotalPhoneNos','NumbersLeft');
			$varFieldsValues	= array("'".$varPaymentMatriId."'","TotalPhoneNos+".$arrPhonePackage[$varCategory],"NumbersLeft+".$arrPhonePackage[$varCategory]);
			$objMasterDB->insertOnDuplicate($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsValues, 'MatriId');
			$varDisplayMessage = 'Payment is added successfully.';

		}//else
	} //if
} else {

	$varCategoryList	= '';
	foreach($arrCurrencyList as $varKey => $varValue) {
		$varCurrencyCode	= $varKey;
		$varCountryCode		= $varValue;
		$arrLocalCurrency	= $arrCurrenyList[$varValue];

		foreach($arrLocalCurrency	as $varKey1 => $varValue1) {
			$varCategoryList	.= '<option value="'.$varCountryCode.'~'.$varKey1.'">'.$arrPrdPackages[$varKey1].' '.$varCurrencyCode.' '.$varValue1.'</option>';

		}
	}//foreach


	unset($arrCurrencyList['IN']);
	$arrIndia			= array('Rs'=>98);
	$arrMerge			= array_merge($arrIndia,$arrCurrencyList);
	$varCurrenctMode	= '';
	foreach($arrMerge as $varKey =>$varValue) { $varCurrenctMode .= '<option value="'.$varKey.'~'.$varValue.'">'.$varKey.'</option>'; }

}

?>
<!-- Datepicker javascript file -->
<link rel="stylesheet" href="includes/calender.css">
<script language="javascript" src="includes/calenderJS.js"></script>
<script language="JavaScript" src="<?=$confValues['JSPATH']?>/ajax.js" type="text/javascript"></script>
<script language="javascript">
function funValidatePayment() {
	var funFormName	= document.frmAddPayment;
	var payMode	= funFormName.paymentMode.options[funFormName.paymentMode.selectedIndex].value; 
	if (IsEmpty(funFormName.userName,'text'))
	{
		alert("Please enter superadmin username");
		funFormName.userName.focus();
		return false;
	}//if
	if (IsEmpty(funFormName.password,'text'))
	{
		alert("Please enter superadmin password");
		funFormName.password.focus();
		return false;
	}//if
	if (payMode == 0)
	{
		alert("Please select payment mode");
		funFormName.paymentMode.focus();
		return false;
	}//if
	if (payMode <=3 && IsEmpty(funFormName.chequeDDNumber,'text') && (payMode !=1))
	{
		alert('Please enter cheque or DD number');
		funFormName.chequeDDNumber.focus();
		return false;
	}
	if (payMode <=3 && IsEmpty(funFormName.chequeDate,'text') && (payMode !=1))
	{
		alert('Please enter cheque or DD  date');
		funFormName.chequeDate.focus();
		return false;
	}
	if (payMode <=3 && IsEmpty(funFormName.bankName,'text') && (payMode !=1))
	{
		alert('Please enter bank name');
		funFormName.bankName.focus();
		return false;
	}
	if (funFormName.currencyMode.selectedIndex==0)
	{
		alert("Please select currency mode");
		funFormName.currencyMode.focus();
		return false;
	}
	if (document.frmAddPayment.category.options[document.frmAddPayment.category.selectedIndex].value==0)
	{
		alert("Please select category");
		funFormName.category.focus();
		return false;
	}//if
	

	if (funFormName.paymentType.options[funFormName.paymentType.selectedIndex].value==0)
	{
		alert("Please payable at");
		funFormName.paymentType.focus();
		return false;
	}//if
	if (IsEmpty(funFormName.amountReceived,"text"))
	{
		alert("Please enter amount received");
		funFormName.amountReceived.focus();
		return false;
	}//if
	if (!(ValidateNo(funFormName.amountReceived.value,"0123456789")))
	{
		alert("Not valid entry, please make valid amount");
		funFormName.amountReceived.value ='';
		funFormName.amountReceived.focus();
		return false;
	}//IF
	if (IsEmpty(funFormName.actualAmount,"text"))
	{
		alert("Please enter actual amount ");
		funFormName.actualAmount.focus();
		return false;
	}//IF
	if (!(ValidateNo(funFormName.actualAmount.value,"0123456789")))
	{
		alert("Not valid entry, please make valid amount");
		funFormName.actualAmount.value ='';
		funFormName.actualAmount.focus();
		return false;
	}//IF
	if (payMode <=3 && funFormName.paymentPoint.value == 0 && payMode !=1)
	{
		alert('Please select payment point');
		funFormName.paymentPoint.focus();
		return false;
	} //if

	if (payMode ==5 && funFormName.directDeposit.value == 0)
	{
		alert('Please select direct payment at');
		funFormName.directDeposit.focus();
		return false;
	} //if



	if (payMode ==4 && IsEmpty(funFormName.receiptNumber,"text"))
	{
		alert("Please enter receipt amount");
		funFormName.receiptNumber.focus();
		return false;
	}//if
	if (payMode ==4 && IsEmpty(funFormName.receiptDate,"text"))
	{
		alert("Please enter receipt date");
		funFormName.receiptDate.focus();
		return false;
	}//if
	if (  funFormName.userNameMatriId.value=="")
	{
		alert("Please enter login name");
		funFormName.userNameMatriId.focus();
		return false;
	}//if
	if (!(funFormName.primary[0].checked==true || funFormName.primary[1].checked==true))
	{
		alert("Please select username / matrimony Id");
		funFormName.primary[0].focus();
		return false;
	}//if
	if (funFormName.comments.value=="")
	{
		alert("Please enter comments");
		funFormName.comments.focus();
		return false;
	}//if

	return true;
}//funValidatePayment

function paymentMethod() {
var payMode	= document.frmAddPayment.paymentMode.options[document.frmAddPayment.paymentMode.selectedIndex].value;
	document.frmAddPayment.paymentType.disabled=false;
	document.frmAddPayment.paymentType.value = '';
if (payMode==1) { // Online
	document.getElementById('paymentPointId').style.display="none";
	document.getElementById('chequeDetailsId').style.display="none";
	document.getElementById('bankListId').style.display="none";
	document.getElementById('receiptDetailsId').style.display="none";

	document.frmAddPayment.paymentType.value = 1;
	document.frmAddPayment.paymentType.disabled=true;

} else if (payMode==2 || payMode==3) { // Cheque && Demand Draft

	document.getElementById('paymentPointId').style.display="block";
	document.getElementById('chequeDetailsId').style.display="block";
	document.getElementById('bankListId').style.display="none";
	document.getElementById('receiptDetailsId').style.display="none";

}  else if (payMode==4) { //Cash

	document.getElementById('paymentPointId').style.display="none";
	document.getElementById('chequeDetailsId').style.display="none";
	document.getElementById('bankListId').style.display="none";
	document.getElementById('receiptDetailsId').style.display="block";

} else if (payMode==5) { //Direct Deposit.....

	document.getElementById('paymentPointId').style.display="none";
	document.getElementById('chequeDetailsId').style.display="none";
	document.getElementById('bankListId').style.display="block";
	document.getElementById('receiptDetailsId').style.display="none";

}

}


/* valiadte forms filed is empty or not */
	function IsEmpty(obj, obj_type)
	{
		if (obj_type == "text" ||  obj_type == "textarea" )
		{
			var objValue;
			objValue = obj.value.replace(/\s+$/,"");

			if (objValue.length == 0)
			{ return true; }
			else { return false; }
		}
	}
/* Validate a number */	
	function ValidateNo(NumStr, String)
	{
		for( var Idx = 0; Idx < NumStr.length; Idx ++ )
		{
			var Char = NumStr.charAt( Idx );
			var Match = false;
			for( var Idx1 = 0; Idx1 < String.length; Idx1 ++)
			{
				if( Char == String.charAt( Idx1 ) )
				Match = true;
			}
			if ( !Match )
			return false;
		}
		return true;
	}
/* Discount paercentage calculation */
	function percentCalc()
	{
		var funFormName	= document.frmAddPayment;
		if (funFormName.amountReceived.value > 0 &&	funFormName.actualAmount.value > 0) {
		
			var percent	=	100 - (funFormName.amountReceived.value/funFormName.actualAmount.value)*100;
			funFormName.discountPercent.value	=	percent;
		} 
		else
		{
			funFormName.discountPercent.value	=	0;
		}
	}

</script>

<script language="javascript">
var objCasteAjax = '';
function funChangeCategory()
{
	objCasteAjax	= AjaxCall();
	var mode		= document.frmAddPayment.currencyMode.options[document.frmAddPayment.currencyMode.selectedIndex].value;
	var varSplit	= mode.split('~');
	var param		= 'countryCode=' + varSplit[1] +'&currency=' + varSplit[0];
	AjaxPostReq('loadcurrency.php?',param,funCasteList,objCasteAjax);
}//funChangeCaste

function funCasteList() {
	if(objCasteAjax.readyState == 4) {
		emptyDropDown();
		var currencyList	= objCasteAjax.responseText;
		var splitCurrency	= currencyList.split('|^');
		var varCurrCcount	= (splitCurrency.length-1);
		var splitkeyvalue	= '';
		var addOption		= '';

		for (i=0; i<varCurrCcount; i++) { 
			splitkeyvalue	= splitCurrency[i].split('#');

			addOption		= document.createElement('option');
			addOption.value	= splitkeyvalue[0];
			addOption.text	= splitkeyvalue[1];
			try { document.frmAddPayment.category.options.add(addOption,null); }// standards compliant
			catch(ex) { document.frmAddPayment.category.options.add(addOption); }// IE only

		}//for
	}

}

function emptyDropDown()
{
	var addOption	= '';
	var categoryLen = document.getElementById('category');
	if (categoryLen.length>0)
	{
		for(i=categoryLen.length;i>=0;i--)
		{
			categoryLen.remove(i);
		}
	}
	var addOption	= document.createElement('option');
	addOption.value	= '0';
	addOption.text	= 'Select Category';

	try { document.frmAddPayment.category.options.add(addOption,null); }
	catch(ex) { document.frmAddPayment.category.options.add(addOption); }
}

</script>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="543">
<tr>
<td valign="top" bgcolor="#FFFFFF" width="450">
<table border="0" cellpadding="0" cellspacing="0" width="445">
	<tr>
		<td valign="middle"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Add Payment</font></div></td>
	</tr>

<?php 

if ($varSubmit== "yes") {
	if ($varCheckLogin == 0) {  $varDisplayMessage	= 'Username / password  mismatch'; }
	else if ($varCheckLogin == 1 && $varMatriID == 0) { $varDisplayMessage = 'Username / MatriID not found.'; }
}//if 
?>
	<tr><td align='center' height='15' valign='middle' class="smalltxt"><b><?=$varDisplayMessage?></td></tr>
</table>
</td></tr></table>
</td></tr></table>

<? if ($varSubmit!= "yes") { ?>
<table border="0" cellpadding="0" cellspacing="0" width="543" align="left">
	<form method="post" name="frmAddPayment" onSubmit="return funValidatePayment();">
	<input type="hidden" name="frmAddPaymentSubmit" value="yes">
	<tr>
		<td style="padding-left:5px;">
			<table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #FFE9D8;" width="535">
				<tr><td>
					<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="100%">
						<tr>
							<td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt frmlftpad" width="150px">Username</td>
							<td colspan="3" align="left"><input type="text" class="inputtext" name="userName"></td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr>
							<td class="smalltxt boldtxt frmlftpad">Password</td>
							<td colspan="3" align="left"><input type="password" class="inputtext" name="password"></td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr>
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Payment Mode</td>
							<td class="smalltxt" align="left">
								<select name="paymentMode" class="smalltxt" style="width: 130px;" onChange="paymentMethod();">
								<option value="0" selected >Select Payment Mode</option>
								<option value="2">Cheque</option>
								<option value="3">Demand Draft</option>
								<option value="4">Cash Payment</option>
								<option value="1">Online</option>
								<option value="5">Direct Deposit</option>
								</select>
							</td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr>
							<td colspan='4'>
								<div id='chequeDetailsId' style="display:block;border:solid #000 0px;" height='200px'>
									<table border="0" cellpadding='0' cellspacing='0' width='100%'>	
									<tr>
										<td class="smalltxt boldtxt frmlftpad" width="150px;">Cheque DD Number </td>
										<td class="smalltxt" colspan='3' align="left"><input type="text" class="inputtext" name="chequeDDNumber"></td>
									</tr>
									<tr><td colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
									<tr>
										<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Cheque Date</td>
										<td align='left' class="smalltxt"><input type='text' class='inputtext' name='chequeDate' /><a  										href="javascript:displayDatePicker('chequeDate', false, 'ymd', '-');"><img src="<?=$confValues['IMGSURL']?>/calbtn.gif" align="absMiddle" 
										border="0"></a>&nbsp;<b>(YYYY-MM-DD)</b></td>
									</tr>
									<tr><td colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
										<tr>
											<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Bank Name</td>
											<td class="smalltxt" align="left"><input type='text' class='inputtext' name='bankName'></td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr>
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Currency Mode</td>
							<td colspan='3' class="smalltxt" align="left">
							<select name='currencyMode' class="smalltxt" style="width: 130px;" onChange="funChangeCategory();">
								<option value="0" selected>Select Currency</option>
								<?=$varCurrenctMode?>
							</select>
							</td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Category</td>
							<td class="smalltxt">
							<span id="currecyList">
							<select name="category" id="category" class="smalltxt" style="width: 190px;"></select>
							</span>
							</td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Payable At</td>
							<td>
								<select name="paymentType" class="smalltxt" style="width: 130px;">
									<?php if ($sessUserType!=4 && $sessUserType!=5 ) { ?>

										<option value="0" selected>Select Place</option>
										<option value="1">Online</option>
										<option value="2">Chennai</option>

									<? } else if ($sessUserType!=4) { ?>

										<option value="4">US</option>

									<? }else if ($sessUserType!=5) { ?>

										<option value="3">Dubai</option>

									<? } ?>
								</select>
							</td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Amount Received</td>
							<td class="smalltxt"><input type="text" class="inputtext" name="amountReceived" onBlur="percentCalc();"></td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="5"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Actual Amount</td>
							<td class="smalltxt"><input type="text" class="inputtext" name="actualAmount" onBlur = "percentCalc();"></td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="5"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Discount Percentage(%)</td>
							<td class="smalltxt"><input type="text" class="inputtext" name="discountPercent"></td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
							<tr>
							<td colspan='4' >
							<div id='paymentPointId' style="display:block;border:solid #000 0px;">
								<table border="0" cellpadding='0' cellspacing='0' width='100%'>	
								<tr>
									<td class="smalltxt boldtxt frmlftpad" width="150px" style="padding-left:5px;">Payment Point</td>
									<td class="smalltxt" align="left">
										<select name="paymentPoint" class="smalltxt" style="width: 250px;">
												<option value="0">Select Payment Point</option>
												<option value="1">Door step collection - Easy Payment Request</option>
												<option value="2">Door step collection - Telemarketing lead</option>
												<option value="3">Door step collection - Incoming calls</option>
												<option value="4">Walk in</option>
												<option value="5">By Post / Courier</option>
												<option value="6">Others </option>
										</select>
									 </td>
								 </tr>
								 <tr><td colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
								 </table>				
							</div>
							</td>
						</tr>
						<tr valign="middle">
						<td colspan='4' >
							<div id='bankListId' style='display:block;border:solid #000 0px;' >
								<table border="0" cellpadding='1' cellspacing='1' width='100%'>	
									<tr>
										<td class="smalltxt boldtxt frmlftpad" width="147px" style="padding-left:5px;">Direct Payment At</td>
										<td class="smalltxt" colspan='3'>
											<select name="directDeposit" class="smalltxt" style="width: 140px;">
												<option value="0" selected>Select Payment Point</option>
												<option value="7">IDBI Bank</option>
												<option value="8">Federal Bank</option>
												<option value="9">Dhanalakshmi Bank</option>
												<option value="10">South Indian Bank</option>
												<option value="11">Eseva</option>
												<option value="12">Akshaya Entrepreneur</option>
												<option value="6">others</option>
											</select>
										 </td>
									 </tr>
									 <tr><td colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
								 </table>
							</div>
						</td>
					</tr>
					
					<tr>
						<td colspan='4'>
							<div id='receiptDetailsId' name='ReceiptDetails' style="display:block;border:solid #000 0px;" height='200px'>
								<table border="0" cellpadding='0' cellspacing='0' width='100%'>	
								<tr>
									<td class="smalltxt boldtxt frmlftpad"  width="149px" style="padding-left:5px;">Receipt Number </td>
									<td class="smalltxt"><input type="text" class="inputtext" name="receiptNumber" value=""></td>
								</tr>
								<tr><td colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
								<tr>
										<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Receipt Date </td>
										<td class="smalltxt"><input type="text" class="inputtext" name="receiptDate" value="" />
										<a href="javascript:displayDatePicker('receiptDate', false, 'ymd', '-');"><img src="<?=$confValues['IMGSURL']?>/calbtn.gif" align="absMiddle" border="0"></a>&nbsp;<b>(YYYY-MM-DD)</b></td>
								</tr>
								<tr><td colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
								</table>
							 </div>
						 </td>
						
						<tr height="28" valign="middle">
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">User Name / Matrimony Id</td>
							<td class="smalltxt" colspan='3'>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="text" name="userNameMatriId" size="20" class="inputtext"></td>
										<td><input type="radio" name="primary" value="User_Name"></td>
										<td class="smalltxt" >Username</td>
										<td><input type="radio" name="primary" value="MatriId"></td>
										<td class="smalltxt">Matrimony Id</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
						<tr height="28" valign="middle">
							<td class="smalltxt boldtxt frmlftpad" style="padding-left:5px;">Comments</td>
							<td class="smalltxt" colspan='3'><textarea cols="30" rows="6" name="comments" class="inputtext"></textarea>&nbsp;</td>
						</tr>
						<tr><td colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="10"></td></tr>
				</table>				
			   </td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="11"></td>
	</tr>
	<tr>
		<td align="center">
			<input type="submit" class="button" value="Submit">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="5">
			<input type="reset" class="button" name="clear" value="Clear"></td>
	</tr>
	<tr>
		<td class="lastnull"><img src="<?=$confValues['IMGSURL']?>/trans.gif"  height="12"></td>
	</tr>
	</form>
</table>
</td></tr></table>
<?php }//if?>
</body>
<? if ($varSubmit!= "yes") { ?><script language='javascript'>document.frmAddPayment.userName.focus();</script> <? } ?>
