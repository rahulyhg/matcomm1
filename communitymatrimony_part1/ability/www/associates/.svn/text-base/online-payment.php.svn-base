<?php
#================================================================================================================
# Author 		: S Anand, N. Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Search - Whos Online
#================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsCommon.php');

//OBJECT DECLARATION
$objCommon		= new clsCommon;

?>
<script language=javascript src="includes/creditcard.js"></script>

<div class="fleft" style="width:772px;padding: 0px 0px 0px 0px;">
	<div id="rndcorner" class="fleft" style="width:772px;">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
		<div class="middiv-pad">
			<div class="fleft">
				<div class="tabcurbg fleft" style="width:739px;">
					<div class="fleft">
						<div class="fleft tabclrleft"></div>
						<div class="fleft tabclrrtsw">
							<div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Payment Associates - Online</font></div>
						</div>
					</div>
				</div>
				<div class="fleft tr-3"></div>
			</div>
			<br clear="all">
<!-- Content Area -->
			<div style="width:749px;padding: 0px 0px 0px 0px;">
				<div class="bl">
					<div class="br">
						<div class="middiv-pad1" id="middlediv">
							<div style=" width:716px">
								<div class="fleft" style="width:706px;;padding:5px 0px 0px 10px;">

							<table border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF" width="690">
								<tr><td>&nbsp;</td><td><font class=smalltxt>Fill out the credit card details below to upgrade/renew to paid membership. The credit card information goes through the <b>verisign</b> secured server. </font></td></tr>
							</table>


							<form method="POST" name="frmPaymentOption" action="https://matchintl.com/cgi-bin/makeassociatespayment.cgi?ID=<?=$sessFranchiseeId;?>" onSubmit="return ValidateCreditcard();" style="padding:0px;margin:0px;">
							<input type="hidden" name="frmPaymentOptionSubmit" value="yes">

							<table cellspacing=1 cellpadding=1 border=0 width="690">
								<tr>
									<td align = "left" valign = "top">
										<table border = 0 cellpadding = 2 cellspacing = 2 width = "100%">
											<tr>
												<td align = "left" valign = "middle" class=tdbgcgi>
													<font class=smalltxt><B>Amount </B></font>
												</td>
												<td align = "left" valign = "middle" class=smalltxt>
													<input type="radio" name="AMOUNT" value="100">US$ 100
													<input type="radio" name="AMOUNT" value="200">US$ 200
													<input type="radio" name="AMOUNT" value="500">US$ 500

												</td>
											</tr>
											<tr>
												<td align = "left" valign = "middle" class=tdbgcgi><font class=smalltxt><B>Name on Card</B></font></td>
												<td align = "left" valign = "middle"><font class=smalltxt><input type = "text" NAME = "CREDITCARDNAME" size=40 class="inputtext" value = ""></font></td>
											</tr>

											<tr>
												<td align = "left" valign = "middle" ><font class=smalltxt><B>Card Type</B></font></td>
												<td align = "left" valign = "middle" class="smalltxt"><input type="radio" NAME="CREDITCARDTYPE" value="MasterCard"><img alt=MasterCard height=20 src="http://img.muslimmatrimony.com/images/ccard2.gif" width=38 height=25><input type="radio" NAME="CREDITCARDTYPE" value="Visa"><img alt=Visa height=20 src="http://img.muslimmatrimony.com/images/ccard1.gif" width=38 height=25><input type="radio" NAME="CREDITCARDTYPE" value="Discover"><img alt=Discover height=20 src="http://img.muslimmatrimony.com/images/ccard18.gif" width=38 height=25><input type="radio" NAME="CREDITCARDTYPE" value="Amex"><img alt=Amex height=20 src="http://img.muslimmatrimony.com/images/ccard19.gif" width=38 height=25></td>
											</tr>
											<tr>
												<td align = "left" valign = "middle" class=tdbgcgi><font class=smalltxt><B>Card Number</B></font></td>
												<td align = "left" valign = "middle"><font class=smalltxt><input type = "text" NAME = "CREDITCARDNUMBER" size = 20 class="smalltxt" value = ""></font></td>
											</tr>
											<tr>
												<td nowrap align = "left" valign = "middle" class=tdbgcgi><font class=smalltxt><B>Expiration Date</B></font></td><td align = "left" valign = "middle">
													<font class=smalltxt>
														<select NAME = "EXPMON" class="smalltxt">
															<option value = "">Select Month</option>
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
														</select> / 
														<select NAME = "EXPYEAR" class="smalltxt">
															<option value = "">Select Year</option>
															<option value = "06">2006</option>
															<option value = "07">2007</option>
															<option value = "08">2008</option>
															<option value = "09">2009</option>
															<option value = "10">2010</option>
															<option value = "11">2011</option>
															<option value = "12">2012</option>
															<option value = "13">2013</option>
															<option value = "14">2014</option>
															<option value = "15">2015</option>
														</select>
													</font>
												</td></tr>
												<tr><td align = "left" valign = "middle" class=tdbgcgi><font class=smalltxt><B>Address</B></font></td><td align = "left" valign = "middle"><font class=smalltxt><input type = "text" NAME = "CREDITCARDADDRESS" class="smalltxt" size = 25 value = ""></font>
											</td></tr>
											<tr>
												<td align = "left" valign = "middle" class=tdbgcgi><font class=smalltxt><B>City</B></font></td><td align = "left" valign = "middle"><font class=smalltxt>
												<input type = "text" class="smalltxt" NAME = "CREDITCARDCITY" size = 25 value = ""></font></td>
											</tr>
											<tr>
												<td align=left >&nbsp;</td>
												<td><font class=smalltxt>If you reside in US, select the State from the list below. Else, enter your State in the "Other State" field.</font></td>
											</tr>
											<tr>
												<td align = "left" valign = "middle"><font class=smalltxt><B>State</B></font></td><td align = "left" valign = "middle"><font class=smalltxt>
												<select NAME = "USSTATE" onChange="statechange();" class="smalltxt">
												<?=$objCommon->getValuesFromArray($varArrResidingUSAStateList, "- Select US State - ", "", '');?>
												</select></font>
												&nbsp;<font class=smalltxt><B>Other State</B></font>
												&nbsp;<font class=smalltxt><input type = "text" NAME = "OTHERSTATE" size = 25 value = "" Onblur="statechange1();" class="smalltxt"></font></td>
											</tr>

											<tr><td nowrap align = "left" valign = "middle" class=tdbgcgi><font class=smalltxt><B>Zip/Postal Code</B></font>
												</td><td align = "left" valign = "middle"><font class=smalltxt>
													<input type = "text" NAME = "CREDITCARDZIP" class="smalltxt" size = 15 value = ""></font> &nbsp; <font class=smalltxt>* Optional</font>
												</td></tr>
											<tr><td align = "left" valign = "middle" class=tdbgcgi><font class=smalltxt><B>Country</B></font></td><td align = "left" valign = "middle"><font class=smalltxt>
											
											<select NAME = "CREDITCARDCOUNTRY" class="smalltxt">
												<?=$objCommon->getValuesFromArray($varArrCountryList, "- Select US State - ", "", '');?>
											</select>
											</font></td></tr>

											<tr><td align = "left" valign = "middle">&nbsp;</td><td><font class=smalltxt><font color=#ff000>Press only once. It may take few seconds for the authorization.</font></font></TD></TR>
							<tr><td align = "left" valign = "middle">&nbsp;</td>
							<td align = "left" valign = "middle"> <input type=submit class="button" value="Upgrade Profile"> &nbsp;<input type="reset" value="Clear" class="button"> </td>
							</tr>

							</table>
							</form>
							</td></tr>
							</table>
							</div>
							</div>
							<br clear="all">
					  	</div>
						<br clear="all">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
<!-- CONTENT ENDS HERE -->
<?php
//UNSET OBJECT
unset($objCommon);
?>