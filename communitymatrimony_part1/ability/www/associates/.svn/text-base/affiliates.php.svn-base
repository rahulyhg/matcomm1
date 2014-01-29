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
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARATION
$objDB	= new DB;

if ($_POST["frmAffiliatesSubmit"]=="yes") {

	//VARIABLLE DECLARATIONS
	$varUsername	= $_REQUEST["username"];
	$varPassword	= trim($_REQUEST["password"]);
	$varName		= $_REQUEST["name"];
	$varEmail		= trim($_REQUEST["email"]);
	$varCountry		= $_REQUEST["country"];
	$varState		= $_REQUEST["state"];
	$varCity		= $_REQUEST["city"];
	$varAddress		= $_REQUEST["address"];
	$varPhoneNumber	= $_REQUEST["phoneNumber"];
	$varMobileNumber= $_REQUEST["mobileNumber"];
	$varFaxNumber	= $_REQUEST["faxNumber"];
	$varZipCode		= $_REQUEST["zipCode"];
	$varResults		= 'no';
	
	$varCondition		= " WHERE User_Name='".$varUsername."'";
	$varNoOfRecords		= $objDB->numOfRecords($varTable['FRANCHISEE'],'Franchisee_Id',$varCondition);

	if ($varCheckAffiliates=='0'){
		$varResults = 'yes';
		$varAction	= 'index.php?act=register';
	} else { $varResults = 'exist';}

}//if
$objDB->dbClose();
unset($objDB);
?>


<div class="fleft padtb10">
	<font class="normtxt bld">Payment Associates</font><br><br>
	This is a wonderful business proposition you wouldn't want to miss. Become a MuslimMatrimonial.com Payment Associate and be associated with a multi-faceted international brand. To make good profits all you need is a computer, a phone, an Internet connection and the enthusiasm to interact with people.<br><br>

	<?php if ($sessFranchiseeId=="") { ?>
		<table cellpadding="0" cellspacing="0" align="center" class="brdr">
			<form name="frmAssociatesLogin" method="post" onSubmit="return Validate();">
			<input type="hidden" name="frmAssociatesLoginSubmit" value="yes">
			<input type="hidden" name="act" value="associates-login">
			<tr>
				<td style="padding-right:15px;padding-left:15px;" class="smalltxt clr"><b>Are you already an Associate?</b></td>
				<td>
					<table cellpadding="1" cellspacing="0" width="300" height="30">
						<tr>
							<td style="padding-left:10px;" class="smalltxt clr">Username</td>
							<td><input type="text" name="username" size="8" class="inputtext"></td>
							<td style="padding-left:10px;" class="smalltxt clr">Password</td>
							<td style="padding-right:10px;"><input type="password" name="password" size="8" class="inputtext"></td>
						</tr>
					</table>
				</td>
				<td style="padding:0px 10px 0px 10px;"> &nbsp;&nbsp;<input type="submit" value="Login" class="button pntr" ></td>
			</tr>
			</form>
		</table>
		<?php }//if ?>

		<table border="0" cellpadding="0" cellspacing="0" width="700" align="center">
		<tr>
			<td>
				<table border="0" cellpadding="2" cellspacing="2" width="660" align="center">
					<tr><td height="20px"></td></tr>
					<tr><td class="smalltxt clr2"><a href="#associates" class="smalltxt clr1">Become a Payment Associate?</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="index.php?act=faq" target="_blank" class="smalltxt clr1">Payment Associates FAQ's</a></td></tr>
					<tr><td height="15px"></td></tr>
					<a name="aff1"></a>
					<tr><td class="normtxt bld">Why Become A Payment Associate? Check Out The Benefits</td></tr>
					<tr><td class="smalltxt" height="10"><img src="<?=$confValues["IMGSURL"];?>/hp-arrow.gif" align="absmiddle"> &nbsp;Earn attractive commission on every profile you introduce or upgrade.</td></tr>

					<tr><td class="smalltxt" height="10"><img src="<?=$confValues["IMGSURL"];?>/hp-arrow.gif" align="absmiddle"> &nbsp;An opportunity to expand your business with a world-renowned brand.</td></tr>

					<tr><td class="smalltxt" height="10"><img src="<?=$confValues["IMGSURL"];?>/hp-arrow.gif" align="absmiddle"> &nbsp;Great visibility in mass media.</td></tr>
					<tr><td class="smalltxt" height="10"><img src="<?=$confValues["IMGSURL"];?>/hp-arrow.gif" align="absmiddle"> &nbsp;An increase in your customer volumes.</td></tr>
					<tr><td class="smalltxt" height="10"><img src="<?=$confValues["IMGSURL"];?>/hp-arrow.gif" align="absmiddle"> &nbsp;An assured return on investment within a short period.</td></tr>
					<tr><td height="15px"></td></tr>
					<tr><td style="height:5px !important;height:5px"></td></tr>
					<tr><td class="smalltxt" height="10"><b>Current Payment Associate opportunities are available in the following countries:</td></tr>
					<tr><td style="height:3px !important;height:3px"></td></tr>
					<tr>
						<td class="smalltxt" height="25">Malaysia, Indonesia, Pakistan, Bangladesh, Israel, Saudi Arabia,  UAE, Jordan, Qatar, Bahrain, Yemen, Oman, Kuwait</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><br><br>

	<a name="associates"></a>

	<table border="0" cellpadding="0" cellspacing="0" width="700" align="center">
	<form name="frmAffiliates" method="post" onSubmit="return funAffiliatesValidate();">
	<input type="hidden" name="frmAffiliatesSubmit" value="yes">
	<input type="hidden" name="act" value="register">

		<tr><td align="right" class="opttxt" height="20" style="padding-right:50px;" >Note: All fields marked <font class="clr1">*</font> are mandatory</td></tr>
		<tr>
			<td>
				<table border="0" cellpadding="6" cellspacing="6"  class="brdr" width="594" align="center">
					<tr><td>
						<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="569" align="center">

							<!-- Username starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Username *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="25" size="25" name="username" value="<?=$varUsername;?>"> <a href="javascript:checkUser()" title="Check username availability" class="smalltxt clr1">Check availability?</a></td>
							</tr>
							<!-- Username ends here -->

							<!-- Password starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Password *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="password" class="inputtext" maxLength="25" size="25" name="password" value=""></td>
							</tr>
							<!-- Password ends here -->

							<!-- Confirm Password starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Confirm Password *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="password" class="inputtext" maxLength="25" size="25" name="confirmPassword" value=""></td>
							</tr>
							<!-- Confirm Password ends here -->

							<!-- Name starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Name *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="50" size="25" name="name" value="<?=$varName;?>"></td>
							</tr>
							<!-- Name ends here -->

							<!-- Email starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Email *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="50" size="25" name="email" value="<?=$varEmail;?>"></td>
							</tr>
							<!-- Email ends here -->

							<!-- Country starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Country *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle>
								<select name="country" class="inputtext" style="width:153px;">
									<option value="0">-- Select Country--</option>
									<option value="13" <?=$varCountry==13 ? ' selected' : '';?>>Australia</option>
									<option value="17" <?=$varCountry==17 ? ' selected' : '';?>>Bahrain</option>
									<option value="18" <?=$varCountry==18 ? ' selected' : '';?>>Bangladesh</option>
									<option value="99" <?=$varCountry==99 ? ' selected' : '';?>>Indonesia</option>
									<option value="103" <?=$varCountry==103 ? ' selected' : '';?>>Israel</option>
									<option value="108" <?=$varCountry==108 ? ' selected' : '';?>>Jordan</option>
									<option value="114" <?=$varCountry==114 ? ' selected' : '';?>>Kuwait</option>
									<option value="129" <?=$varCountry==129 ? ' selected' : '';?>>Malaysia</option>
									<option value="161" <?=$varCountry==161 ? ' selected' : '';?>>Oman</option>
									<option value="173" <?=$varCountry==173 ? ' selected' : '';?>>Qatar</option>
									<option value="162" <?=$varCountry==162 ? ' selected' : '';?>>Pakistan</option>
									<option value="185" <?=$varCountry==185 ? ' selected' : '';?>>Saudi Arabia</option>
									<option value="220" <?=$varCountry==220 ? ' selected' : '';?>>United Arab Emirates</option>
									<option value="232" <?=$varCountry==232 ? ' selected' : '';?>>Yemen</option>
								</select>
								</td>
							</tr>
							<!-- Country ends here -->

							<!-- State starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">State *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="50" size="25" name="state" value="<?=$varState;?>"></td>
							</tr>
							<!-- State ends here -->

							<!-- City starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">City *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="50" size="25" name="city" value="<?=$varCity;?>"></td>
							</tr>
							<!-- City ends here -->

							<!-- Address starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Address *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><textarea class="inputtext" name="address" cols="25" rows="5" style="width:154px;"><?=$varAddress;?></textarea></td>
							</tr>
							<!-- Address ends here -->

							<!-- Phone Number starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Phone Number *</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="25" size="25" name="phoneNumber" value="<?=$varPhoneNumber;?>"></td>
							</tr>
							<!-- Phone Number ends here -->

							<!-- Mobile Number starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Mobile Number</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="20" size="25" name="mobileNumber" value="<?=$varMobileNumber;?>"></td>
							</tr>
							<!-- Mobile Number ends here -->

							<!-- Fax Number starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Fax Number</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="25" size="25" name="faxNumber" value="<?=$varFaxNumber;?>"></td>
							</tr>
							<!-- Fax Number ends here -->

							<!-- ZipCode starts here -->
							<tr height="28" valign="middle">
								<td class="smalltxt clr" valign=middle style="padding-left:5px;">Zip Code</td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td valign=middle><input type="text" class="inputtext" maxLength="20" size="25" name="zipCode"  value="<?=$varZipCode;?>"></td>
							</tr>
							<!-- ZipCode ends here -->
							
							<tr>
								<td class="smalltxt clr" valign=middle style="padding-left:5px;"></td>
								<td width=2><img height=1 src="<?=$confValues["IMGSURL"];?>/trans.gif" width=2></td>
								<td class="smalltxt">
									<input type="checkbox" checked name="terms" value="1">I accept the <a href="index.php?act=terms-and-conditions" target="_blank" class="smalltxt2"><font class="normaltxt clr1" style="cursor: pointer;"> Terms & Conditions</font></a>
								</td>
							</tr>
							<tr><td colspan="3" height="5"></td></tr>
						</table>
					</td></tr>
				</table>
			</td>
		</tr>
		<tr><td height="5"></td></tr>
		<tr><td align="center" colspan="2" height="35"><input type="submit" class="button" value="Submit"></td></tr>
	</form>
	</table>
</div>

<? if ($sessFranchiseeId=='') { ?>
	<script language="javascript">document.frmAssociatesLogin.username.focus();</script>
<? }//if
?>
