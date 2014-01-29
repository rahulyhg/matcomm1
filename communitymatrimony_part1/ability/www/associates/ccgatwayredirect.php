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

$varFranchiseeId	= $_REQUEST["frid"];

//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=my-page"</script>'; exit; }//if

//OBJECT DECLARATION
$objDB	= new DB;
$objCCAvenue= new CCAvenue;

//DB CONNECTION
//$objDB->dbConnect('S',$varDbInfo['DATABASE']);
$objDB->dbConnect('ODB4',$varOfflineCbsDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varFields					= array('Name','Email','Country','State','City','Address','Tel','ZipCode','LastCreditBoughtTime','Status');
$varCondition				= " WHERE FranchiseeId='".$varFranchiseeId."'";
$varExecute					= $objDB->select($varOfflineCbsDbInfo['DATABASE'].".".$varTable['CBSFRANCHISEE'],$varFields,$varCondition,0);
$varSelectFranchiseeInfo	= mysql_fetch_array($varExecute);

$varPayType                     ='C';
$varCategory					= $_REQUEST["category"];
$varAmount	= round(preg_replace('/\,/','',($varAssociatesUSAmount[$varCategory]*$varCurrUsdToInr)));
$varName						= $varSelectFranchiseeInfo["Name"];
$varEmail						= $varSelectFranchiseeInfo["Email"];
$varCountry						= $varArrCountryList[$varSelectFranchiseeInfo["Country"]];
$varState						= $varSelectFranchiseeInfo["State"];
$varCity						= $varSelectFranchiseeInfo["City"];
$varAddress						= $varSelectFranchiseeInfo["Address"];
$varOrderId						= $varFranchiseeId.'-'.$varPayType.'-'.time();
$varMerchantParam				= $varFranchiseeId.'-'.$varCategory;
$varPhone						= $varSelectFranchiseeInfo["Tel"];
$varTel							= $varPhone ? $varPhone : $varSelectFranchiseeInfo["Tel"];
$varCheckSum	= $objCCAvenue->getCheckSum($varMerchantId,$varAmount,$varOrderId,$varAssociateRedirectURL,$varWorkingKey);
$objDB->dbClose();
unset($objDB);
unset($objCCAvenue);

$varOnLoad	= 'onLoad="document.frmRedirection.submit()"';
include_once($varRootBasePath.'/www/template/paymentheader.php');
?>
<form name='frmRedirection' method="post" action="https://www.ccavenue.com/shopzone/cc_details.jsp">

<input type="hidden" name="STATE" value="<?=$varState?>">
<input type="hidden" name="NAME" value="<?=$varName;?>">
<input type="hidden" name="COUNTRY" value="<?$varCountry;?>">
<input type="hidden" name="ADDR" value="<?=$varAddress;?>">
<input type="hidden" name="FranchiseeId" value="<?=$varFranchiseeId?>">

<input type="hidden" name="Merchant_Id" value="<?=$varMerchantId?>">
<input type="hidden" name="Amount" value="<?=$varAmount;?>">
<input type="hidden" name="Order_Id" value="<?=$varOrderId?>">
<input type="hidden" name="Redirect_Url" value="<?=$varAssociateRedirectURL?>">
<input type="hidden" name="Checksum" value="<?=$varCheckSum?>">
<input type="hidden" name="billing_cust_name" value="<?=$varName?>">
<input type="hidden" name="billing_cust_address" value="<?=$varState?>">
<input type="hidden" name="billing_cust_country" value="<?=$varCountry?>">
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

<? include_once($varRootBasePath.'/www/template/paymentfooter.php'); ?>