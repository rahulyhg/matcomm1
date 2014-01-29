<?php
#=============================================================================================================
# Author 		: N Dhanapal ,Srinivasan
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES

include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath."/conf/cookieconfig.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/payment.inc");
include_once($varRootBasePath."/conf/vars.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//VARIABLLE DECLARATIONS
$varCategory		= $_REQUEST['category'];
$varAmount          = $varCategory;
/*if($varCategory==1){
$varCategory=122;
}
elseif($varCategory==2){
$varCategory=121;
}else{
$varCategory=120;
}*/
$varFranchiseeId    = $_REQUEST['frid'];
$varGateWay			= $_REQUEST['gateWay'];
$varGateWay			= $varGateWay ? $varGateWay : '3';//DEFAULT US

//DB CONNECTION
$objDB	= new DB;
$objDB->dbConnect('ODB4',$varOfflineCbsDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varFields					= array('Name','Email','Country','State','City','Address','Tel','ZipCode','LastCreditBoughtTime','Status','Currency');
$varCondition				= " WHERE FranchiseeId='".$varFranchiseeId."'";
$varSelectFranchiseeInfo	= $objDB->select($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varCondition,1);
$varPayType='C';
$varProcess	= 'yes';
	if(empty($varSelectFranchiseeInfo)){
		    $varProcess	= 'no';
			$varMessage = 'No such Franchisee ID found.';
	}
	elseif($varPayType == ""){
		$varProcess	= 'no';
		$varMessage = 'Payment type not found.';
	}
	else {
		
		$varStatus  = $varSelectFranchiseeInfo[0]['Status'];
		$varPayTime	= $varSelectFranchiseeInfo[0]['LastCreditBoughtTime'];
		if($varPayType == "D" && (($varStatus == 0)||($varPayTime > '0000-00-00 00:00:00'))){
			$varProcess	= 'no';
			$varMessage = 'You have already remitted your deposit amount.';
		}
	}

$varName						= $varSelectFranchiseeInfo[0]["Name"];
$varEmail						= $varSelectFranchiseeInfo[0]["Email"];
$varCountryCode	                = 222;//$varSelectFranchiseeInfo[0]["Country"];
$varCurrency	                = $varSelectFranchiseeInfo[0]["Currency"];
$varState						= $varSelectFranchiseeInfo[0]["State"];
$varCity						= $varSelectFranchiseeInfo[0]["City"];
$varAddress						= $varSelectFranchiseeInfo[0]["Address"];
$varZipCode						= $varSelectFranchiseeInfo[0]["ZipCode"];
$varCurrtentTime                = time();
$varOrderId		                = $varFranchiseeId."-".$varPayType."-".$varCurrtentTime;
$varMerchantParam				= $varOrderId;
$varPhone						= $varSelectFranchiseeInfo[0]["Tel"];
$varTel							= $varPhone ? $varPhone : '';
$varPayTime	                    = $varSelectFranchiseeInfo[0]['LastCreditBoughtTime'];
$varStatus                      = $varSelectFranchiseeInfo[0]['Status'];

//CHECK USER LOGGED OR NOT
if($varFranchiseeId =='') { header ("Location:".$confValues['SERVERURL']."/login/"); exit; }//if

//include_once($varRootBasePath."/www/payment/paymentprocess.php");

if ($varFranchiseeId !="") {

//OBJECT DECLARATION



$varOnLoad	= '';

/*if ($varCountryCode==98) {
	$varAccessCode	= '12C3C3D5';
	$varMerchantId	= '00100182';
	$varCurrency	= 'Rs';
	$varActualAmount= $varAmount;

} else if ($varCountryCode==21) {
	$varAccessCode	= '9066BB69';
	$varMerchantId	= '00100184';
	$varCurrency	= 'EURO';
	$varActualAmount= $varAmount;

} else if ($varCountryCode==220) {
	$varAccessCode	= '959A16F6';
	$varMerchantId	= '00100185';
	$varCurrency	= 'AED';
	$varActualAmount= $varAmount;
} else if ($varCountryCode==221) {
	$varAccessCode	= 'CAEAEEA8';
	$varMerchantId	= '00100195';
	$varCurrency	= 'GBP';
	$varActualAmount= $varAmount;
} else {
	$varAccessCode	= 'A68FB320';
	$varMerchantId	= '00100183';
	$varCurrency	= 'USD';
	$varActualAmount= $varAmount;
}*/

if ($varCurrency=='Rs.') {
	$varAccessCode	= '12C3C3D5';
	$varMerchantId	= '00100182';
	$varCurrency	= 'Rs';
	$varActualAmount= $varAmount;

} else if ($varCurrency=='EUR') {
	$varAccessCode	= '9066BB69';
	$varMerchantId	= '00100184';
	$varCurrency	= 'EURO';
	$varActualAmount= $varAmount;

} else if ($varCurrency=='AED') {
	$varAccessCode	= '959A16F6';
	$varMerchantId	= '00100185';
	$varCurrency	= 'AED';
	$varActualAmount= $varAmount;
} else if ($varCurrency=='GBP') {
	$varAccessCode	= 'CAEAEEA8';
	$varMerchantId	= '00100195';
	$varCurrency	= 'GBP';
	$varActualAmount= $varAmount;
} else {
	$varAccessCode	= 'A68FB320';
	$varMerchantId	= '00100183';
	$varCurrency	= 'USD';
	$varActualAmount= $varAmount;
}

	$varFields		= array('OrderId','FranchiseeID','Name','AmountPaid','Currency','PaymentGatewayId','PaymentDate');
	$argFieldsValue	= array("'".$varOrderId."'","'".$varFranchiseeId."'","'".$varName."'","'".$varActualAmount."'","'".$varCurrency."'",'\'3\'','NOW()');
	$objDB->insert($varTable['CBSPREFRANCHISEEPAYMENTS'], $varFields, $argFieldsValue);

include_once($varRootBasePath.'/www/template/paymentfranchiseeheader.php');

?>

<SCRIPT LANGUAGE="JAVASCRIPT">
function validateCreditcard() {

	var frmCreditCard=this.document.frmCreditCard;
	var n=document.getElementById('vpc_CardNum').value;
	var n1;var n2;var n3;
	n1=n.substring(0,1);
	n2=n.substring(1);
	n3=n.substring(0,4);

	if(IsEmpty(document.frmCreditCard.cardHolderName,'text')) {
		alert("Please enter name of the card holder");
		frmCreditCard.cardHolderName.focus();
		return false;
	}

	if(!document.frmCreditCard.vpc_card[0].checked && !document.frmCreditCard.vpc_card[1].checked) {
		alert("Please select card type");
		frmCreditCard.vpc_card[0].focus();
		return false;
	}

	if (IsEmpty(document.frmCreditCard.vpc_CardNum,'text')) {
		alert("Please enter credit card number");
		frmCreditCard.vpc_CardNum.focus();
		return false;
	}

	if (!ValidateNo(document.frmCreditCard.vpc_CardNum.value, "0123456789 " )) {
		alert("Invalid credit card Number "+frmCreditCard.vpc_CardNum.value);
		frmCreditCard.vpc_CardNum.focus();
		return false;
	}
	if(n1==3) {
		if(n2.length < 13) {
			alert("Your credit card number must contain 14 digits");
			frmCreditCard.vpc_CardNum.focus();
			return false;
		}
	}

	if(n1==4 || n1==5) {
		if(n2.length < 15) {
			alert("Your credit card number must contain 16 digits");
			frmCreditCard.vpc_CardNum.focus();
			return false;
		}
	}

	if(n3==5081) {
		alert("Invalid credit card number");
		frmCreditCard.vpc_CardNum.focus();
		return false;
	}
	if((frmCreditCard.cardExpiryMonth.value == "")&&(frmCreditCard.cardExpiryYear.value == "")) {
		alert("Please select card expiry date");
		frmCreditCard.cardExpiryMonth.focus();
		return false;
	}

	if (frmCreditCard.cardExpiryMonth.value=="") {
		alert("Please select month and year of expiry");
		frmCreditCard.cardExpiryMonth.focus();
		return false;
	}
			
	if (frmCreditCard.cardExpiryYear.value=="") {
		alert("Please select month and year of expiry");
		frmCreditCard.cardExpiryYear.focus();
		return false;
	}
	if (IsEmpty(document.frmCreditCard.vpc_CardSecurityCode,'text')) {
		alert ("Please enter card verification number");
		frmCreditCard.vpc_CardSecurityCode.focus();
		return false;
	}

	if (IsEmpty(document.frmCreditCard.phoneNumber,'text')) {
		alert ("Please enter phone number");
		frmCreditCard.phoneNumber.focus();
		return false;
	}


return true;
}//validateCreditcard

function IsEmpty(obj, obj_type) {
	if (obj_type == "text")	{
		var objValue;
		objValue = obj.value.replace(/\s+\$/,"");
		if (objValue.length == 0) {
			obj.focus();
			return true;
		} else {
			return false;
		}
	} else if (obj_type == "select") {
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) {
				if(obj.options[i].value == "") {
					obj.focus();
					return true;
				} else {
					return false;
				}
			}
		}
		return true;	
	} else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				obj.focus();
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			obj[0].focus();
			return true;
		}
	} else {
		return false;
	}
}
function ValidateNo( NumStr, String ) {
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


</SCRIPT>

<form name="frmCreditCard" method="POST" action="http://www.communitymatrimony.com/associates/vpc_php_authenticate_and_pay_merchanthost_do.php" onSubmit="return validateCreditcard();">
<!--input type="hidden" name="domainFolder" value="<?=$_REQUEST['domainFolder'];?>"-->
<input type="hidden" name="franchiseeId" value="<?=$varFranchiseeId?>">
<input type="hidden" name="category" value="<?=$varCategory?>">
<input type="hidden" name="countryCode" value="<?=$varCountryCode?>">
<input type="hidden" name="gateWay" value="<?=$varGateWay?>">
<input type="hidden" name="userName" value="<?=$varName?>">
<input type="hidden" name="currency" value="<?=$varCurrency?>">

<!--------- FOR ICICI MIGS Payment Gateway Purpose ---------------->
<input type="hidden" name="Title" value="PHP VPC 2.5-Party">
<input type="hidden" name="vpc_Version" value="1" size="20" maxlength="8">
<input type="hidden" name="vpc_Command" value="pay" size="20" maxlength="16">
<input type="hidden" name="vpc_AccessCode" value="<?=$varAccessCode?>" size="20" maxlength="8">
<input type="hidden" name="vpc_MerchTxnRef" value="<?=$varOrderId?>" size="20" maxlength="40">
<input type="hidden" name="vpc_Merchant" value="<?=$varMerchantId?>" size="20" maxlength="16">
<input type="hidden" name="vpc_OrderInfo" value="<?=$varOrderId?>" size="20" maxlength="34">
<input type="hidden" name="vpc_Amount" value="<?=round($varActualAmount*100)?>" size="20" maxlength="10">
<input type="hidden" name="actualAmount" value="<?=$varActualAmount?>">
<!--------- FOR ICICI MIGS Payment Gateway Purpose ---------------->

<!--------- VBV PURPOSE ---------------->
<input type="hidden" value="https://migs.mastercard.com.au/vpcpay" name="virtualPaymentClientURL"/>
<input type="hidden" value="http://www.communitymatrimony.com/associates/vpc_php_authenticate_and_pay_merchanthost_dr.php" name="vpc_ReturnURL"/>
<input type="hidden" value="en" name="vpc_Locale"/>
<input type="hidden" value="ssl" name="vpc_gateway"/>
<input type="hidden" name="vpc_CardExp" value="1"/>
<input type="hidden" name="vpc_TicketNo" maxlength="15" value="">
<!--------- VBV PURPOSE ---------------->


<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>    
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF">
        <table border="0"  cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding-left:10px;" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<? if ($varProcess	== 'no') { echo '<td class="smalltxt">'.$varMessage.'<br><br><center><a href="'.$confValues['SERVERURL'].'/profiledetail/" style="text-decoration: none;" class="smalltxt clr1">Back to My Home</a></center></td>'; } else { ?>

							<td class="smalltxt">Thank you for choosing to become a paid member. You have opted for:</td>
							<td class="smalltxt" align="right"><div><img src="<?=$confValues['IMGSURL']?>/paycc_verisignicon.gif"  height="28" border="0" alt="" align="absbottom"> <br><font class="smalltxt1">Secured Online Payment</font></div></td>
						</tr>
						</table>
					</td>

				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="10">
						<tr><!--td  height="25" style="padding:0px 10px 0px 10px;" class="brdr" align="center"><font class="smalltxt">
						<font class="normtxt bld">Package  : </font><font class="smalltxt">  <?=$arrPrdPackages[$varCategory];?>   </font><font class="smalltxt"></font></td--> <td  height="25" style="padding:0px 10px 0px 10px;" class="brdr" align="center"><font class="normtxt bld">Amount  : </font><font class="smalltxt"><?=$arrCurrCode[$varCountryCode];?> <?=$varActualAmount?> <?=$varUSDLabel?></font></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding-left:10px;">
					<table border="0" cellpadding="0" cellspacing="0" class="brdr">
					<tr>
						<td colspan="3" height="22" style="padding-left:15px;"><font class="normtxt1 bld">Credit Card Details</font></td>
					</tr>
					<tr>
						<td height="40" width="30%" style="padding-left:15px;border-top:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;"><font class="smalltxt">Card holder name</font></td>
						<td style="border-top:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;border-right: 1px solid #cbcbcb;padding-left:39px;" width="70%"><input type="text" size="19" value="" name="cardHolderName" id="cardHolderName"  class="inputtext"></td>
						<td rowspan="7" valign="top" style="padding-top:39px;_padding-top:38px;"><img src="<?=$confValues['IMGSURL']?>/verification_num.jpg"  height="175" border="0" alt=""></td>
					</tr>
					<tr>
						<td height="40" style="padding-left:15px;border-bottom:1px solid #cbcbcb;"><font class="smalltxt">Card type</font></td>
						<td valign="middle" style="border-right: 1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;padding-left:34px;">
						<div>
							<div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="Visa"></div><div style="width:50px;float:left;"><IMG SRC="<?=$confValues['IMGSURL']?>/pay-visa.gif" ></div><div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="Mastercard"></div><div style="width:50px;float:left;"><IMG SRC="<?=$confValues['IMGSURL']?>/pay-master.gif"></div></td>
					</tr>
					<tr>
						<td height="47" style="padding-left:15px;border-bottom: 1px solid #cbcbcb;"><font class="smalltxt">Credit card number</font></td>

						<td style="border-bottom: 1px solid #cbcbcb;border-right: 1px solid #cbcbcb;padding-left:39px;"><input type="text" size="19" value="" name="vpc_CardNum" id="vpc_CardNum" class="inputtext"></td>
					</tr>
					<tr>
						<td height="47" style="padding-left:15px;border-bottom: 1px solid #cbcbcb;"><font class="smalltxt">Card expiry date</font></td>
						<td style="border-bottom: 1px solid #cbcbcb;border-right: 1px solid #cbcbcb;padding-left:39px;"><SELECT class="smalltxt" NAME="cardExpiryMonth" size="1" >
				<OPTION value="">-Month-</OPTION> 
				<option value = "01">1</option>
				<option value = "02">2</option>

				<option value = "03">3</option>
				<option value = "04">4</option>
				<option value = "05">5</option>
				<option value = "06">6</option>
				<option value = "07">7</option>
				<option value = "08">8</option>

				<option value = "09">9</option>
				<option value = "10">10</option>
				<option value = "11">11</option>
				<option value = "12">12</option>
							</SELECT>
							<SELECT name="cardExpiryYear" class="smalltxt" >
				<OPTION value="">-Year-</OPTION> 
				<option value="09">2009</option>
				<option value="10">2010</option>
				<option value="11">2011</option>
				<option value="12">2012</option>
				<option value="13">2013</option>
				<option value="14">2014</option>
				<option value="15">2015</option>
				<option value="16">2016</option>
				<option value="17">2017</option>
				<option value="18">2018</option>
				<option value="19">2019</option>
				<option value="20">2020</option>
				<option value="21">2021</option>
				<option value="22">2022</option>
				<option value="23">2023</option>
				<option value="24">2024</option>
				<option value="25">2025</option>
				<option value="26">2026</option>
				<option value="27">2027</option>
				<option value="28">2028</option>
				<option value="29">2029</option>
				<option value="30">2030</option>
				<option value="31">2031</option>
				<option value="32">2032</option>
				<option value="33">2033</option>
				<option value="34">2034</option>
				<option value="35">2035</option>
				<option value="36">2036</option>
				<option value="37">2037</option>
				<option value="38">2038</option>
				<option value="39">2039</option>
				<option value="40">2040</option>
</SELECT>

						</td>
					</tr>
					<tr>
						<td colspan="2" height="47" style="padding-left:15px;border-bottom: 1px solid #cbcbcb;">
						
							<div>
								<div style="float:left;padding-top:6px;"><font class="smalltxt">Card verification number</font></div>
								<div style="width:70px;float:left;padding-top:6px;padding-left:25px;"><input type="password" size="8" maxlength="3" value="" name="vpc_CardSecurityCode" class="inputtext"></div ><div style="float:right"><img src="<?=$confValues['IMGSURL']?>/payccline.gif"  height="35" border="0" alt=""></div>
							</div></td>
					</tr>

					<tr>

						<td style="border-bottom: 1px solid rgb(203, 203, 203); padding-left: 15px;" height="47"><font class="smalltxt">Phone number </font></td>

						<td style="border-right: 1px solid rgb(203, 203, 203); border-bottom: 1px solid rgb(203, 203, 203); padding-left: 39px;"><input size="19" value="" name="phoneNumber" id="phoneNumber" class="inputtext" type="text"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="75"><input type="submit" name="SubButL" class="button pntr" value="Pay Now!"><br><font class="smalltxt">(Click only once.)</font></td>
						<td style="border-top: 1px solid #cbcbcb;">&nbsp;</td>
					<? } ?>
					</tr>
					</table>
					</td>
				</tr>
				<? if ($varProcess	== 'yes') { ?>
				<tr>
					<td class="smalltxt" style="padding:10px 0px 0px 10px;"><B>Note:</B> Your credit card information will go through the Verisign secured server and may take a few seconds for authorization. So kindly wait for confirmation.</td>
				</tr>
				<? } ?>
				</table>
				<!-- CONTENT ENDS HERE -->
            </td>
			</tr>
		</table>
    </td>
    <td valign="top" class="borderclr" ><img src="<?=$confValues['IMGSURL']?>/trans.gif"  height="1"></td>
  </tr>

</table>
			
				</form><br clear="all">
				<!-- CONTENT ENDS HERE -->
<?php 
	//$objMasterDB->dbClose();
	//UNSET($objMasterDB);
	include_once($varRootBasePath.'/www/template/paymentfooter.php');
}//if 
?>