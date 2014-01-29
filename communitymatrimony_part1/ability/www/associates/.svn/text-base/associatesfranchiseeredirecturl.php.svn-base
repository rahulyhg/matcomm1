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
include_once($varRootBasePath."/lib/clsMailManager.php");


//SESSION VARIABLE
$varMerchantParam		= $_REQUEST["Merchant_Param"];
$varTransOrderid		= $varMerchantParam;
$varSplit				= explode("-",$varMerchantParam);
$varFranchiseeId		= $varSplit[0];
$varPayType				= $varSplit[1];



//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=my-page"</script>'; exit; }//if

//OBJECT DECLARATION
$objDB		= new DB;
$objCCAvenue= new CCAvenue;
$objMail    = new MailManager; 
//DB CONNECTION
$objDB->dbConnect('ODB4',$varOfflineCbsDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varDomain				= $_SERVER["SERVER_NAME"];
$varMerchantId			= $_REQUEST["Merchant_Id"];
$varOrderId				= $_REQUEST["Order_Id"];
$varAmount				= $_REQUEST["Amount"];
$AuthDesc				= $_REQUEST["AuthDesc"];
$varCheckSum1			= $_REQUEST["Checksum"];

$varCheckSum			= $objCCAvenue->verifychecksum($varMerchantId,$varOrderId,$varAmount,$AuthDesc,$varCheckSum1,$varWorkingKey);
$varBillingCustName		= $_REQUEST["billing_cust_name"];
$varBillingCustAddress	= $_REQUEST["billing_cust_address"];
$varBillingCustCountry	= $_REQUEST["billing_cust_country"];
$varBillingCustTel		= $_REQUEST["billing_cust_tel"];
$varBillingCustEmail	= $_REQUEST["billing_cust_email"];
$varDeliveryCustName	= $_REQUEST["delivery_cust_name"];
$varDeliveryCustAddress	= $_REQUEST["delivery_cust_address"];
$varDeliveryCustTel		= $_REQUEST["delivery_cust_tel"];
$varBillingCustNotes	= $_REQUEST["billing_cust_notes"];
$varMerchantParam		= $_REQUEST["Merchant_Param"];
$varTransOrderid		= $varMerchantParam;
$varSplit				= explode("-",$varMerchantParam);
$varFranId				= $varSplit[0];
$varPayType				= $varSplit[1];
$varLocale				= "en";
$varProcess				= 'yes';
if($varFranId=="")
	$varDisplayContent ='Could not get Franchisee Id.';


$varCheckSum = "true";
$AuthDesc = "Y";

if(!$objDB->error)
{
	if(($varCheckSum == "true" && $AuthDesc == "Y") ||  ($varCheckSum == "true" && $AuthDesc == "B"))
	{

        $varFields					= array('Status','LastCreditBoughtTime');
        $varCondition				= " WHERE FranchiseeId='".$varFranId."'";
        $varFranSel	= $objDB->select($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varCondition,0);

		
		if ($varFranSel==0)
		{ 
			$varDisplayContent = 'No such Franchisee ID found.';
			$varProcess	= 'no';
		}//if
		else
		{
			//$varFranPayTab		= $DBNAME['FRANCHISEE'].".".$TABLE['FRANCHISEPAYMENTS'];
			$varFranDet			= mysql_fetch_assoc($varFranSel);
            
			$varStatus			= $varFranDet['Status'];
			$varPayTime			= $varFranDet['LastCreditBoughtTime'];
			if($varPayType == "D" && (($varStatus == 0)||($varPayTime > '0000-00-00 00:00:00')))
			{
				$varDisplayContent = 'You have already remitted your deposit amount.';
				exit;
			}
			$varCountry	= "India";
			if($varPayType == "D")
			{
				$varDepositAmt	= $FRANCHISEE_INR_DEPOSIT+$FRANCHISEE_INR_REGFEE;
				$varCreditBal	= $FRANCHISEE_INR_CREDITBAL;
				$varCreditBal	= $varCreditBal+($varCreditBal *$FRANCHISEE_IND_COMMISSION);

                $varFields		= array('DepositAmount','DateCreated','CreditBalance','LastCreditBoughtTime','Comments');
		        $varFieldsValue	= array($varDepositAmt,'NOW()',$varCreditBal,'NOW()',$varTransOrderid);
		        $varCondition	= " FranchiseeId='".$varFranId."'";
		        $varFranUpd		=$objDB->update($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varFieldsValue,$varCondition);


                $varFields		= array('FranchiseeID','AmountPaid','PaymentDate','PaymentInfo','Comments');
		        $varFieldsValue	= array("'".$varFranId."'","'".$FRANCHISEE_INR_CREDITBAL."'",'NOW()','INR Online Payment',"'".$varTransOrderid."'");
		        $varFranIns		=$objDB->insert($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEEPAYMENTS'], $varFields, $varFieldsValue);

				
				/*$varFranIns		= $objFran->insert("insert into ".$varFranPayTab." values ('".$varFranId."',".$FRANCHISEE_INR_CREDITBAL.",NOW(),'INR Online Payment','".$varTransOrderid."')");*/

				if($varFranUpd == 1)
				{
					$varDisplayContent="Thank you. Your payment has been accepted. You have got a Credit Balance of Rs. ".$FRANCHISEE_INR_CREDITBAL;

					$varFrom	= "info\@bharatmatrimony.com";
					//$varTo		= "franchisee\@bharatmatrimony.com";
					//$varTo		= "srinivasan.c@bharatmatrimony.com";
					$varTo		= "csvaas@gmail.com";
					$varSubject	= $varFranId." signed up as franchisee - INR Online Payment";
					$varMsg		= "<font face=Arial size=2>Hi,<br><Br>Franchisee ID ".$varFranId." has signed up for our service by making INR Online Payment. <Br><Br>Please do the needful. Thank you.<br><br>Best Wishes,<br>Team Matrimony</font><br>";
					$objMail->sendEmail($varFrom,$varFrom,$varTo,$varTo,$varSubject,$varMsg,$varFrom);
				}
			}
			else
			{
				## Update credit balance alone
                //ini_set('display_errors',1);
                //error_reporting(E_ALL);

				$varFields					= array('FranchiseeId');
				$varCondition				= " WHERE Comments='".$varTransOrderid."'";
				$varOrderExists	= $objDB->select($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEEPAYMENTS'],$varFields,$varCondition,1);
		        
				if(!empty($varOrderExists))
					$varDisplayContent	= "Duplicate Order ID";
				else
				{
				$varCreditBal=$varAmount;
				//$varCreditBal=$varCreditBal+($varCreditBal * $FRANCHISEE_IND_COMMISSION);
                
				$varFields		= array('CreditBalance','LastCreditBoughtTime');
		        $varFieldsValue	= array("(CreditBalance + ".$varCreditBal.")",'NOW()');
		        $varCondition	= " FranchiseeId='".$varFranId."'";
		        $varFranUpd		= $objDB->update($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varFieldsValue,$varCondition);

				$varFields		= array('FranchiseeID','AmountPaid','PaymentDate','PaymentInfo','Comments');
		        $varFieldsValue	= array("'".$varFranId."'","'".$varAmount."'",'NOW()','"INR Online Payment"',"'".$varTransOrderid."'");
		        $varFranIns		=$objDB->insert($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEEPAYMENTS'], $varFields, $varFieldsValue);

				if($varFranUpd == 1)
				{
					$varFields			= array('CreditBalance');
				    $varCondition		= " WHERE FranchiseeId='".$varFranId."'";
				    $varFranCredit	    = $objDB->select($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varCondition,0);  
                    $varFranCreditDet	= mysql_fetch_assoc($varFranCredit);
            
					$varRemainCredit	= $varFranCreditDet['CreditBalance'];					
					$varDisplayContent	= "Thank you. Your payment has been accepted. You have got a Credit Balance of Rs. ".$varRemainCredit;

					$varFrom	= "info@bharatmatrimony.com";
					//$varTo		= "franchisee\@bharatmatrimony.com";
					//$varTo		= "srinivasan.c@bharatmatrimony.com";
					$varTo		= "csvaas@gmail.com,srinivasan.c@bharatmatrimony.com";
					$varSubject	= $varFranId." made INR Online Payment";
					$varMsg		= "<font face=Arial size=2>Hi,<br><Br>Franchisee ID ".$varFranId."  made a payment of ".$varAmount." (INR Online Payment). <Br><Br>Please do the needful. Thank you.<br><br>Best Wishes,<br>Team Matrimony</font><br>";
					$objMail->sendEmail($varFrom,$varFrom,$varTo,$varTo,$varSubject,$varMsg,$varFrom);
					
				}
				}//else
			}
		}
	}//if
	else if($varCheckSum == "true" && $AuthDesc == "N")
	{ $varDisplayContent	= "Your transaction was not successful. Please try again."; }
	else { $varDisplayContent	= "Your transaction was not successful. Please try again."; }
	
		 
}
else
{
	$varDisplayContent	= "Could not process your request at the moment. Please contact franchisee\@bharatmatrimony.com.";
}


$objDB->dbClose();
unset($objDB);
unset($objCCAvenue);
unset($objMail);
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
