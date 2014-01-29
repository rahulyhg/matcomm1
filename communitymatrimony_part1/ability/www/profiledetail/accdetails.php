<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : accountdtls.php
#=====================================================================================================================================
# Description : Display account detail information.
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDE FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/payment.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessUsername	= $varGetCookieInfo["USERNAME"];
$sessValidDays	= $varGetCookieInfo["VALIDDAYSLEFT"];
$sessExpDate	= $varGetCookieInfo["EXPIRYDATE"];
$sessLastPayment= $varGetCookieInfo["LASTPAYMENT"];
$sessProductId	= $varGetCookieInfo["PRODUCTID"];
$varMemshipType	= $arrPrdPackages[$sessProductId];

//For temporary purpose
//INCLUDE FILES
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARATION
$objAccountMaster	= new DB;

$objAccountMaster->dbConnect('M',$varDbInfo['DATABASE']);
$argFields			= array('Offer_Product_Id','Product_Id');
$argCondition		= "WHERE MatriId=".$objAccountMaster->doEscapeString($sessMatriId,$objAccountMaster)." ORDER BY Date_Paid DESC LIMIT 0,1";
$varOfferId			= $objAccountMaster->select($varTable['PAYMENTHISTORYINFO'],$argFields,$argCondition,0);
$varOfferIdRes		= mysql_fetch_assoc($varOfferId);
$objAccountMaster->dbClose();
if($varOfferIdRes['Offer_Product_Id'] > 0) {
	$varMemshipType	= $arrPrdPackages[$varOfferIdRes['Offer_Product_Id']];
} else if($varOfferIdRes['Product_Id'] > 0) {
	$varMemshipType	= $arrPrdPackages[$varOfferIdRes['Product_Id']];
} else {
	$varMemshipType	= $arrPrdPackages[$sessProductId];
}//For temporary purpose

/*if($_REQUEST['frmAccountUpdate'] == 'yes') {
	//INCLUDE FILES
	include_once($varRootBasePath."/conf/dbinfo.cil14");
	include_once($varRootBasePath.'/lib/clsDB.php');

	//OBJECT DECLARATION
	$objAccountMaster	= new DB;

	//VARIABLE DECLARATION
	$varRenewal	= $_REQUEST['renewalOpt'];

	$objAccountMaster->dbConnect('M',$varDbInfo['DATABASE']);
	$argFields				= array('Auto_Renewal_Status');
	$argFieldsValues		= array($varRenewal);
	$argCondition			= "MatriId='".$sessMatriId."'";
	$varUpdateId			= $objAccountMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
	$objAccountMaster->dbClose();
}*/
?>
			<div class="fleft">
				<div class="tabcurbg fleft">
		<!--{ tab button none -->
					<div class="fleft">
						<div class="fleft tabclrleft"></div>
						<div class="fleft tabclrrtsw">
							<div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Account Details</font></div>
						</div>
					</div>
		<!-- tab button none }-->
				</div>
				<div class="fleft tr-3"></div>
			</div>
			<!-- Content Area -->
			<div class="middiv1">
				<div class="bl">
					<div class="br">
						<div id="middlediv" class="middiv-pad1">

							<div style="width: 510px;">

								<div class="mediumtxt boldtxt">Your membership details</div>
								<div class="dottedline" style="background: transparent url(<?=$confValues["IMGSURL"]?>/dot.gif) repeat-x scroll 0px 7px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><br></div>
								<div class="fleft smalltxt boldtxt" style="width: 160px;">User Name :</div>
								<div class="fleft smalltxt"><?=$sessUsername;?></div>
								<br clear="all"><div class="dottedline" style="background: transparent url(<?=$confValues["IMGSURL"]?>/dot.gif) repeat-x scroll 0px 7px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><br></div>

								<? if($varOfferIdRes['Offer_Product_Id'] > 0 || $varOfferIdRes['Product_Id'] > 0 || $sessProductId > 0) { ?>
								<div class="fleft smalltxt boldtxt" style="width: 160px;">Type of membership :</div>

								<div class="fleft smalltxt"><?=$varMemshipType?></div>
								<br clear="all"><div class="dottedline" style="background: transparent url(<?=$confValues["IMGSURL"]?>/dot.gif) repeat-x scroll 0px 7px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><br></div>
								<? } ?>

								<div class="fleft smalltxt boldtxt" style="width: 160px;">Validity period :</div>
								<div class="fleft smalltxt"><?=$sessValidDays?> Days</div>
								<br clear="all"><div class="dottedline" style="background: transparent url(<?=$confValues["IMGSURL"]?>/dot.gif) repeat-x scroll 0px 7px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><br></div>

								<? if($sessExpDate != '0000-00-00 00:00:00') { ?>
								<div class="fleft smalltxt boldtxt" style="width: 160px;">Date of expiry :</div>

								<div class="fleft smalltxt"><? echo date('jS F Y',strtotime($sessExpDate));?></div>
								<br clear="all"><div class="dottedline" style="background: transparent url(<?=$confValues["IMGSURL"]?>/dot.gif) repeat-x scroll 0px 7px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><br></div> 
								<? } ?>

								<div class="fleft smalltxt boldtxt" style="width: 160px;">Last renewed :</div>
								<div class="fleft smalltxt"><? echo date('jS F Y',strtotime($sessLastPayment));?></div>
								<br clear="all"> 
								<!-- <div class="dottedline" style="background: transparent url(<?=$confValues["IMGSURL"]?>/dot.gif) repeat-x scroll 0px 7px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><br></div>
																<form name="email_bounce" method="post" action="updateonlinerenwal.php">

                                <div class="fleft smalltxt boldtxt" style="width: 160px;">Auto renewal status :</div>
								<div class="fleft smalltxt"><input name="renewal_opt" value="Y" checked="checked" style="vertical-align: middle;" type="radio">Auto renewal ON&nbsp;&nbsp;&nbsp;
								<input name="renewal_opt" value="N" style="vertical-align: middle;" type="radio">Auto renewal OFF&nbsp;&nbsp;&nbsp;</div><div class="divbutton"><input name="membership" value="Classic" type="hidden"><input name="expiry" value="2nd March 2009" type="hidden"><input name="last_renewal" value="4th September 2008" type="hidden">
								<input class="button pntr" name="submit" value="Save" type="submit"></div>
								<br clear="all"><div class="dottedline" style="background: transparent url(<?=$confValues["IMGSURL"]?>/dot.gif) repeat-x scroll 0px 7px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><br></div>
								</form>
								<div class="smalltxt boldtxt">What you gain through auto renewal:</div>

								<div class="content" style="padding-top: 10px;">By setting your auto renewal status ON, your current membership package will be automatically renewed for a period of 3 months from the date of expiry. You will also get  special 10% discount.</div> -->

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Content Area -->
