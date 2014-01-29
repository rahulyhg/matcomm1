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
// /home/product/community/ability
$varRootBasePath        = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/payment.inc");

/*$varOption1	= $varAssociatesUSAmount[1];
$varOption2	= $varAssociatesUSAmount[2];
$varOption3	= $varAssociatesUSAmount[3];*/

//Get Frid
if($_REQUEST['FRID']){
$varFranchiseeId=$_REQUEST['FRID'];
}
$currency=$_REQUEST['currency'];
/*$varGatWayAmount1	= round(preg_replace('/\,/','',($varOption1*$varCurrUsdToInr)));
$varGatWayAmount2	= round(preg_replace('/\,/','',($varOption2*$varCurrUsdToInr)));
$varGatWayAmount3	= round(preg_replace('/\,/','',($varOption3*$varCurrUsdToInr)));*/

if($bmnp_currencywise_deposit_amount_arr[1][0]==$currency){
	$varOption1=$bmnp_currencywise_deposit_amount_arr[1][1];
    $varOption2=$bmnp_currencywise_deposit_amount_arr[1][2];
    $varOption3=$bmnp_currencywise_deposit_amount_arr[1][3];
}
if($bmnp_currencywise_deposit_amount_arr[2][0]==$currency){
	$varOption1=$bmnp_currencywise_deposit_amount_arr[2][1];
    $varOption2=$bmnp_currencywise_deposit_amount_arr[2][2];
    $varOption3=$bmnp_currencywise_deposit_amount_arr[2][3];
}
if($bmnp_currencywise_deposit_amount_arr[3][0]==$currency){
	$varOption1=$bmnp_currencywise_deposit_amount_arr[3][1];
    $varOption2=$bmnp_currencywise_deposit_amount_arr[3][2];
    $varOption3=$bmnp_currencywise_deposit_amount_arr[3][3];
}
if($bmnp_currencywise_deposit_amount_arr[4][0]==$currency){
	$varOption1=$bmnp_currencywise_deposit_amount_arr[4][1];
    $varOption2=$bmnp_currencywise_deposit_amount_arr[4][2];
    $varOption3=$bmnp_currencywise_deposit_amount_arr[4][3];
}
if($bmnp_currencywise_deposit_amount_arr[5][0]==$currency){
	$varOption1=$bmnp_currencywise_deposit_amount_arr[5][1];
    $varOption2=$bmnp_currencywise_deposit_amount_arr[5][2];
    $varOption3=$bmnp_currencywise_deposit_amount_arr[5][3];
}

//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=associates-login"</script>'; exit; }//if

?>
<script language='javascript'>
function funValidatePayment()
{
	var frmPaymentOption = document.frmPaymentOption;
	if(!(frmPaymentOption.category[0].checked) && !(frmPaymentOption.category[1].checked) && !(frmPaymentOption.category[2].checked))
	{
		alert("Please select the membership package.");
		frmPaymentOption.category[0].focus();
		return false;
	}//if
	if(!(frmPaymentOption.ctype.checked))
	{
		alert("Please select your payment mode.");
		frmPaymentOption.ctype.focus();
		return false;
	}//if
	/*if(!(frmPaymentOption.ctype[0].checked) && !(frmPaymentOption.ctype[1].checked))
	{
		alert("Please select your payment mode.");
		frmPaymentOption.ctype[0].focus();
		return false;
	}//if*/
	
	if((frmPaymentOption.ctype.checked))
	{
		
        frmPaymentOption.action='http://www.communitymatrimony.com/associates/icgatewayredirect_VBV.php';
	    frmPaymentOption.submit();
		
	}//if
	
	
	return true;
}//funValidatePayment
</script>


<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr><td colspan="2" class="normtxt bld clr padtb10">Payment Options</td></tr>
	<tr>
		<td valign="top" width="10"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="10" height="1"></td>
		<td valign="top" width="750">
			
			<table border="0" cellpadding="0" cellspacing="0" width="530">
				<tr>
					<td valign="top" width="530">
						<form method="POST" name="frmPaymentOption" action="ccgatwayredirect.php" onSubmit="return funValidatePayment();" style="padding-0px;margin:0px;">
						<input type="hidden" name="frid" id="frid" value="<?=$varFranchiseeId;?>">
						<table border="0" cellpadding="0" cellspacing="0" width="500">
							<tr>
								<td valign="top" style="width:220;height:18;" class="smalltxt bld"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="2"><br>Select Payment Package</td></tr>
								<tr><td height="10"></td></tr>
						</table>
						<table border="0" cellpadding="0" cellspacing="0" style="width:660px;">
							<tr>
								<td valign="top">
									<table border="0" cellpadding="0" cellspacing="0" style="width:658px;">
										<tr>
											<td colspan="3">
												<table border="0" cellpadding="0" cellspacing="0">
												    <?php if($currency=='US$'){ ?>
													<tr>
														<td valign="top" width="5"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="5" height="1"></td>
														<td valign="middle" class="smalltxt"><input type="radio" name="category" value="<?=$varOption1?>"> <b>US$ <?=$varOption1?></b><input type="radio" name="category" value="<?=$varOption2?>"> <b>US$ <?=$varOption2?></b><input type="radio" name="category" value="<?=$varOption3?>"> <b>US$ <?=$varOption3?></b></td>
													</tr>
													<?php }elseif($currency=='AED'){ ?>
													    <tr>
														<td valign="top" width="5"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="5" height="1"></td>
														<td valign="middle" class="smalltxt"><input type="radio" name="category" value="<?=$varOption1?>"> <b>AED <?=$varOption1?></b><input type="radio" name="category" value="<?=$varOption2?>"> <b>AED <?=$varOption2?></b><input type="radio" name="category" value="<?=$varOption3?>"> <b>AED <?=$varOption3?></b></td>
													</tr>
													<?php }elseif($currency=='EUR'){ ?>
													    <tr>
														<td valign="top" width="5"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="5" height="1"></td>
														<td valign="middle" class="smalltxt"><input type="radio" name="category" value="<?=$varOption1?>"> <b>EUR <?=$varOption1?></b><input type="radio" name="category" value="<?=$varOption2?>"> <b>EUR <?=$varOption2?></b><input type="radio" name="category" value="<?=$varOption3;?>"> <b>EUR <?=$varOption3?></b></td>
														</tr>
                                                    <?php }elseif($currency=='GBP'){ ?>
<tr>
														<td valign="top" width="5"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="5" height="1"></td>
														<td valign="middle" class="smalltxt"><input type="radio" name="category" value="<?=$varOption1?>"> <b>GBP <?=$varOption1?></b><input type="radio" name="category" value="<?=$varOption2?>"> <b>GBP <?=$varOption2?></b><input type="radio" name="category" value="<?=$varOption3;?>"> <b>GBP <?=$varOption3?></b></td>
														</tr>
                                                     <?php } ?>  

												</table>
											</td>
										</tr>
										<tr><td valign="top" colspan="3"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="15"></td></tr>
										<tr><td valign="top" colspan="3" bgcolor="#dbdbdb"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="1"></td></tr>
										<tr><td valign="top" colspan="3"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="15"></td></tr>
										<tr>
										<td valign="top" style="width:220;height:25px;" colspan="3" class="smalltxt bld"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="2"><br>Select Payment Mode</b></td></tr>
										<tr><td colspan="3" height="25" class="smalltxt">&nbsp;<b>Visa / MasterCard Credit Card</b></td></tr>
										<tr><td valign="top" width="5"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="5" height="1"></td><td valign="top" width="20"><input type=radio name="ctype" value="1" <?=$varMode==1 ? "checked" : ""; ?>></td><td valign="top" height="30"><img src="<?=$confValues["IMGSURL"];?>/visa-card.gif" width="38" height="25" border="0" alt="" hspace="5"><img src="<?=$confValues["IMGSURL"];?>/master-card.gif" width="38" height="25" border="0" alt=""  hspace="5"></td></tr>
										<tr><td valign="top" colspan="3"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="15"></td></tr>
										<!--tr><td colspan="3" height="25" class="smalltxt">&nbsp;<b>Other Credit Cards / Netbanking Accounts</b></td></tr>
										<tr><td valign="top" width="5"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="5" height="1"></td><td valign="top" width="20"><input type=radio name="ctype" value="2" <?=$varMode==2 ? "checked" : ""; ?>></td><td valign="middle" class="smalltxt">&nbsp;HDFC Online Banking, Citi bank NRI Account Holders, Citi bank Current &nbsp;&nbsp;Account Holders, Citi bank Suvidha Account Holders, ICICI Infinity Net banking &nbsp;&nbsp;Account Holders, IDBI iNET banking Account Holders, UTI iConnect Net banking &nbsp;&nbsp;Account Holders, Centurion Bank</font><br></td></tr-->
										<tr><td valign="top" colspan="3"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="15"></td></tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="25" height="7"></td></tr>
				<tr>
					<td valign="top" height="25" align="right"><input type="submit" name="payment" value="Pay Now" class="button"></td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>
