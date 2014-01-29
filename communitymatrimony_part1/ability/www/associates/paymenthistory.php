<?php
#================================================================================================================
# Author 		: S Anand, N. Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Search - Whos Online
#================================================================================================================

//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=associates-login"</script>'; exit; }//if

//FILE INCLUDES
// /home/product/community/ability
$varRootBasePath        = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/vars.inc");
include_once($varRootBasePath."/lib/clsDB.php");


//OBJECT DECLARTION
$objDB	= new DB;

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

$varFields	= array('Name','Email','Country','Residing_State','Residing_City','Contact_Address','ZipCode','Contact_Phone','Contact_Mobile','Fax','Deposit_Amount','Currency','Credit_Balance','Date_LastCredit_Bought','Comments','Date_Created');
$varCondition		= " WHERE Franchisee_Id='".$varFranchiseeId."'";
$varExecute			= $objDB->select($varTable['FRANCHISEE'], $varFields, $varCondition, 0);
$varFranchiseeInfo	= mysql_fetch_array($varExecute);

$varName			= $varFranchiseeInfo["Name"];
$varEmail			= $varFranchiseeInfo["Email"];
$varCountry			= $varFranchiseeInfo["Country"];
$varCountry			= $varCountry ? $arrCountryList[$varCountry].',' : '';
$varState			= $varFranchiseeInfo["Residing_State"];
$varState			= $varState ? $varState.',' : '';
$varCity			= $varFranchiseeInfo["Residing_City"];
$varCity			= $varCity ? $varCity.',' : '';
$varAddress			= $varFranchiseeInfo["Contact_Address"];
$varAddress			= $varAddress ? $varAddress.',' : '';
$varZipcode			= $varFranchiseeInfo["ZipCode"];
$varZipcode			= $varZipcode ? 'Pin. '.$varZipcode : '';
$varPhone			= $varFranchiseeInfo["Contact_Phone"];
$varMobile			= $varFranchiseeInfo["Contact_Mobile"];
$varFax				= $varFranchiseeInfo["Fax"];
$varCBCurrency		= $varFranchiseeInfo["Currency"];
$varCreditBalance	= $varFranchiseeInfo["Credit_Balance"];
$varLastCreditDate	= $varFranchiseeInfo["Date_LastCredit_Bought"];
$varComments		= $varFranchiseeInfo["Comments"];
$vardDateCreate		= $varFranchiseeInfo["Date_Created"];



$varFields			= array('Amount_Paid','Currency','Payment_Details','Comments','Date_Paid');
$varExecute			= $objDB->select($varTable['FRANCHISEEPAYMENTS'], $varFields, $varCondition, 0);
$varDisplayResults	= '';
$varPaymentCount	= count($varExecute);
while($varFranchiseePaymentsInfo = mysql_fetch_array($varExecute)) {

	$varAmount			= $varFranchiseePaymentsInfo["Amount_Paid"];
	$varCurrency		= $varFranchiseePaymentsInfo["Currency"];
	$varPaymentDetails	= $varFranchiseePaymentsInfo["Payment_Details"];
	$varComments		= $varFranchiseePaymentsInfo["Comments"];
	$varDatePaid		= $varFranchiseePaymentsInfo["Date_Paid"];

	$varDisplayResults	.= '<tr>';
	$varDisplayResults	.= '<td class="tcol1" align=center><font class="smalltxt">'.($i+1).'</font></td>';
	$varDisplayResults	.= '<td class="tcol1" align=center><font class="smalltxt">'.$varCurrency.' '.$varAmount.'</font></td>';
	$varDisplayResults	.= '<td class="tcol1" align=center><font class="smalltxt">'.$varDatePaid.'</font></td>';
	$varDisplayResults	.= '</tr>';

}//for

//UNSET OBJECT
$objDB->dbClose();
unset($objDB);
?>


<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr><td valign="middle" class="normtxt bld clr padt10">Check Your Balance</td></tr>
	<tr><td class="smalltxt padtb10">Keep track of your payment history and credit balance for future reference.</td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
	<tr>
		<td>
			<table border=0 width=440 cellspacing=2 cellpadding=4 align="left" class="brdr">
				<tr>
					<td align=left width=120 class="smalltxt"><b> &nbsp; Associate Id</b></td>
					<td class="smalltxt"> &nbsp; <?=$varFranchiseeId;?></td>
				</tr>
				<tr>
					<td align=left class="smalltxt"><b> &nbsp; Name</b></td>
					<td class="smalltxt"> &nbsp; <?=$varName;?></td>
				</tr>
				<tr>
					<td align=left class="smalltxt"><b> &nbsp; Email</b></td>
					<td class="smalltxt"> &nbsp; <?=$varEmail;?></td>
				</tr>
				<tr>
					<td align=left class="smalltxt"><b> &nbsp; Address</b></td>
					<td style="padding-left:7px" class="smalltxt"><?=$varAddress;?> <?=$varCity;?> <?=$varState;?> <?=$varCountry?> <?=$varZipcode;?> </td>
				</tr>
				<tr>
					<td align=left class="smalltxt"><b> &nbsp; Phone Number</b></td>
					<td class="smalltxt"> &nbsp; <?=$varPhone;?></td>
				</tr>
				<tr>
					<td align=left class="smalltxt"><b> &nbsp; Mobile Number</b></td>
					<td class="smalltxt"> &nbsp; <?=$varMobile;?></td>
				</tr>
				<tr>
					<td align=left class="smalltxt"><b> &nbsp; Last Credit on</b></td>
					<td align=left class="smalltxt">&nbsp; <?=$varLastCreditDate;?> &nbsp;</td>
				</tr>
				<tr>
					<td align=left class="smalltxt"><b> &nbsp; Credit Balance </b></td>
					<td align=left class="smalltxt"> &nbsp;<b> <?=$varCBCurrency;?> <?=$varCreditBalance;?></b></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="25"></td></tr>
	<tr>
		<td>
			<table border=0 width=440 cellspacing=0 cellpadding=3 align="left" class="brdr">
				<tr>
					<td colspan=3 align=left style="padding-left:15px;border-bottom:1px solid #cbcbcb;" class="smalltxt"><b>Payment History</b></td>
				</tr>
				<tr>
					<td align=center class="smalltxt"><b>S.No</b></td>
					<td align=center class="smalltxt"><b>Amount Paid</b></td>
					<td  align=center class="smalltxt"><b>Date Paid</b></td>
				</tr>
				<?php if ($varPaymentCount > 0) { echo $varDisplayResults; }else { ?>
				<tr><td align=center colspan="3" class="smalltxt">No Payments</td></tr>
				<?php }//else?>
			</table>
		</td>
	</tr>
</table>
								