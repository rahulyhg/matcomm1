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
$varFranchiseeId	= trim($_REQUEST['FRID']);
$varPayType		    = trim($_REQUEST["PAYTYPE"]);
$varAmount		    = trim($_REQUEST["AMOUNT"]);
$varDispMsg		    = '';


//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=my-page"</script>'; exit; }//if

//OBJECT DECLARATION
$objDB	= new DB;
$objCCAvenue= new CCAvenue;

//DB CONNECTION
$objDB->dbConnect('ODB4',$varOfflineCbsDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varFields					= array('Name','Email','Country','State','City','Address','Tel','ZipCode','LastCreditBoughtTime','Status');
$varCondition				= " WHERE FranchiseeId='".$varFranchiseeId."'";
$varSelectFranchiseeInfo					= $objDB->select($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varCondition,1);


$varName						= $varSelectFranchiseeInfo[0]["Name"];
$varEmail						= $varSelectFranchiseeInfo[0]["Email"];
$varCountry	                    = "India";
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

        if($varPayType == "D" && (($varStatus == 0)||($varPayTime > '0000-00-00 00:00:00')))
		$varDispMsg .= 'You have already remitted your deposit amount.';
		$varCountry	= "India";
		if($varPayType == "D")
			$varAmount=$FRANCHISEE_INR_TOTALPAYMENT;
		else
		{
			if($varAmount == 0)
				$varDispMsg .= 'Could not get Amount.';
		}

		

$varCheckSum	= $objCCAvenue->getCheckSum($varMerchantId,$varAmount,$varOrderId,$varAssociateFranchiseeRedirectURL,$varWorkingKey);
$objDB->dbClose();
unset($objDB);
unset($objCCAvenue);


$varOnLoad	= 'onLoad="document.frmRedirection.submit()"';
include_once($varRootBasePath.'/www/template/paymentheader.php');
?>
<?php if($varDispMsg =="") { ?>
<form name='frmRedirection' method="post" action="https://www.ccavenue.com/shopzone/cc_details.jsp">

<input type="hidden" name="STATE" value="<?=$varState?>">
<input type="hidden" name="NAME" value="<?=$varName;?>">
<input type="hidden" name="COUNTRY" value="<?$varCountry;?>">
<input type="hidden" name="ADDR" value="<?=$varAddress;?>">
<input type="hidden" name="FranchiseeId" value="<?=$varFranchiseeId?>">

<input type="hidden" name="Merchant_Id" value="<?=$varMerchantId?>">
<input type="hidden" name="Amount" value="<?=$varAmount;?>">
<input type="hidden" name="Order_Id" value="<?=$varOrderId?>">
<input type="hidden" name="Redirect_Url" value="<?=$varAssociateFranchiseeRedirectURL?>">
<input type="hidden" name="Checksum" value="<?=$varCheckSum?>">
<input type="hidden" name="billing_cust_name" value="<?=$varName?>">
<input type="hidden" name="billing_cust_city" value="<?=$varCity?>">
<input type="hidden" name="billing_cust_state" value="<?=$varState?>">
<input type="hidden" name="billing_cust_address" value="<?=$varAddress?>">
<input type="hidden" name="billing_cust_country" value="<?=$varCountry?>">
<input type="hidden" name="billing_zip_code" value="<?=$varZipCode?>">

<input type="hidden" name="billing_cust_tel" value="<?=$varTel?>">
<input type="hidden" name="billing_cust_email" value="<?=$varEmail?>">
<input type="hidden" name="delivery_cust_name" value="<?=$varName?>">
<input type="hidden" name="delivery_cust_address" value="<?=$varAddress?>">
<input type="hidden" name="delivery_cust_tel" value="<?=$varTel?>">
<input type="hidden" name="billing_cust_notes" value="">
<input type="hidden" name="Merchant_Param" value="<?=$varMerchantParam?>">

<table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td valign="middle" class="textsmallbold">
						<table border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF">
							<tr>
								<td>&nbsp;</td><td class="smalltxt" style="line-height:18px;">
							
									<table border="0" cellspacing="0" cellpadding="0" width="693" class="brdr" align="center">
										<tr>
											<td valign="top" style="padding-top:40px;padding-left:25px;line-height:15px;">
												<table border="0" cellspacing="0" cellpadding="0" width="500">
													<tr>
														<td valign="top" class="brdr">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr> 
																	<td valign="top" class="bigtxt clr5"  style="padding-left:12px;padding-top:6px;padding-bottom:5px;"><b><?=$confValues["PRODUCTNAME"]?>.Com</b></td>
																	<td valign="top" style="padding-top:8px;font:normal 11px verdana,arial;">&nbsp;Redirecting to payment gateway....</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
											<td></td>
										</tr>
										<tr>
										<td valign="top" colspan="2" style="padding-top:30px;padding-left:25px;font:normal 11px verdana,arial;line-height:15px;"><IMG SRC="<?=$confValues["IMGSURL"];?>/hp-arrow.gif" WIDTH="5" HEIGHT="6" BORDER="0" ALT="">&nbsp;&nbsp;You shall be taken to the payment gateway page to make payment in Indian Rupees.</td>
										</tr>
										<tr>
											<td valign="top" colspan="2" style="padding-top:5px;padding-bottom:25px;padding-left:25px;font:normal 11px verdana,arial;line-height:15px;"><IMG SRC="<?=$confValues["IMGSURL"];?>/hp-arrow.gif" WIDTH="5" HEIGHT="6" BORDER="0" ALT="">&nbsp;&nbsp;If you are unable to connect to the payment gateway page, please <input type="button" class="button" value="Click" onClick="document.frmRedirection.submit()"> here.</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	  </tr>
	</table>
</form>
<?php } else { ?>
			<table cellspacing="0" cellpadding="0">
				<tr>
				<td valign="top" class="mediumtxt"  style="padding:10px"><?=$varDispMsg;?></td>
				</tr>
			</table>
			<?php } ?>
<? include_once($varRootBasePath.'/www/template/paymentfooter.php'); ?>