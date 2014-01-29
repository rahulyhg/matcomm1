<?php
#=============================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/vars.inc");
include_once($varRootBasePath."/conf/payment.inc");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/lib/clsCCAvenue.php");

//SESSION VARIABLE
/*$varCookieInfo	= $_COOKIE["FranchiseeId"];
if (isset($varCookieInfo)) {
	$varCookieInfo		= split("=",str_replace("&","=",$varCookieInfo));
	$varFranchiseeId	= $varCookieInfo[1];
}//if*/
$Order_Id_arr=explode('-',$_REQUEST["Order_Id"]);
$varFranchiseeId=$Order_Id_arr[0];


//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="http://offlinecbspayment.matchintl.com/creditbalance.php"</script>'; exit; }//if

//OBJECT DECLARATION
$objDB		= new DB;
$objCCAvenue= new CCAvenue;

//DB CONNECTION
//$objDB->dbConnect('M',$varDbInfo['DATABASE']);
$objDB->dbConnect('ODB4',$varOfflineCbsDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varFields					= array('Name','Email','Country');
$varCondition				= " WHERE FranchiseeId='".$varFranchiseeId."'";
$varSelectFranchiseeInfo	= $objDB->select($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varCondition,0);
$varAmount					= $_REQUEST["Amount"];
$varOrderId					= $_REQUEST["Order_Id"];
$varAuthDesc				= $_REQUEST["AuthDesc"];
$varCheckSum1				= $_REQUEST["Checksum"];
$varName					= $varSelectFranchiseeInfo["Name"];
$varEmail					= $varSelectFranchiseeInfo["Email"];
$varCountry					= $varSelectFranchiseeInfo["Country"];
$varMerchantParam			= $_REQUEST["Merchant_Param"];
$varSplit					= split("-",$varMerchantParam);
$varCategory				= $varSplit[1];
$varUSDAmount	 = $varAssociatesUSAmount[$varCategory];
$varIndianAmount = round(preg_replace('/\,/','',($varAssociatesUSAmount[$varCategory]*$varCurrUsdToInr)));
$varCheckSum	= $objCCAvenue->verifychecksum($varMerchantId,$varOrderId,$varAmount,$varAuthDesc,$varCheckSum1,$varWorkingKey);

$varCondition	= " WHERE Comments='".$varOrderId."'";
$varRecord		= $objDB->numOfRecords($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEEPAYMENTS'],'Comments',$varCondition);

$varCheckSum	= true;########
$varAuthDesc	= 'Y';########

if ($varRecord==0) {

//echo '<br>'.$varCheckSum.'===='.$varAuthDesc;

	if(($varCheckSum == "true" && $varAuthDesc == "Y") ||  ($varCheckSum == "true" && $varAuthDesc == "B"))
	{

		$varFields		= array('Comments','FranchiseeID','AmountPaid','PaymentInfo','PaymentDate');
		$varFieldsValue	= array("'".$varOrderId."'","'".$varFranchiseeId."'","'".$varIndianAmount."'",'\'INR Online Payment\'','NOW()');
		$objDB->insert($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEEPAYMENTS'], $varFields, $varFieldsValue);

		$varUpgradeCreditBalance	=	($varUSDAmount + (30/100 * $varUSDAmount));

		$varFields		= array('CreditBalance','LastCreditBoughtTime');
		$varFieldsValue	= array("(CreditBalance + ".$varUpgradeCreditBalance.")",'NOW()');
		$varCondition	= " FranchiseeId='".$varFranchiseeId."'";
		$objDB->update($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varFieldsValue,$varCondition);

		$varDisplayContent="Thank you. Your payment has been accepted. You have got a Credit Balance of USD $varUpgradeCreditBalance";

	}//if
	else if($Checksum == "true" && $AuthDesc == "N")
	{ $varDisplayContent	= "Your transaction was not successful. Please try again."; }
	else { $varDisplayContent	= "Your transaction was not successful. Please try again."; }

}
else { $varDisplayContent	= "You have made payment."; }
$objDB->dbClose();
unset($objDB);
unset($objCCAvenue);

include_once($varRootBasePath.'/www/template/paymentheader.php');
?>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="700" bgcolor=#FFFFFF>
	<tr>
		<td valign="top" width="700" bgcolor="#FFFFFF"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="bigtxt clr3">Payment Confirmation</font></div>
			<table border="0" width="650" cellpadding="5" cellspacing="0">
				<tr>
					<td valign="top" width="20"></td>
					<td valign="middle" class="smalltxt"><?=$varDisplayContent;?><br><br></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td align="center" style="padding-bottom:10px;"><a href="http://offlinecbspayment.matchintl.com/creditbalance.php" style="text-decoration: none;" class="smalltxt clr1">Back to My Home</a></td></tr>
 </table>
<?php include_once($varRootBasePath.'/www/template/paymentfooter.php'); ?>
