<?php
$varRootBasePath	= '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/payment.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/lib/clsDB.php"); 

if($varGetCookieInfo['PAIDSTATUS'] == 1) {

$objMasterDB = new DB;
$objSlaveDB = new DB;
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);

$varRightClickDisable = 'onselectstart="return false" ondragstart="return false" oncontextmenu="return false"';
$sessMatriId = $varGetCookieInfo['MATRIID'];

if($_POST['frmAutoRenewalControl'] == 1) {
  $varFields	 = array('Auto_Renew');
  $varFieldsVal	 = array($objMasterDB->doEscapeString($_POST['autoRenewal'],$objMasterDB));
  $varWhereCond	 = "MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB)."";
  $objMasterDB->update($varTable['ONLINEPAYMENTDETAILS'],$varFields,$varFieldsVal,$varWhereCond);
}

$varMemberSince = '';
$varPaidMemberSince = '';
$varPaidExpire = '';
if (trim($varGetCookieInfo['TIMECREATED']) != '') {
	$varMemberSince = date("F Y",strtotime($varGetCookieInfo['TIMECREATED']));
}
if (trim($varGetCookieInfo['LASTPAYMENT']) != '') {
	$varPaidMemberSince = date("jS F Y",strtotime($varGetCookieInfo['LASTPAYMENT']));
}
if (trim($varGetCookieInfo['EXPIRYDATE']) != '') {
	$varPaidExpire = date("jS F Y",strtotime($varGetCookieInfo['EXPIRYDATE']));
}
$varPrdPackageName = substr($arrPrdPackages[$varGetCookieInfo['PRODUCTID']],0,-8);
$varPrdPackageDuration = trim(str_replace($varPrdPackageName,'',$arrPrdPackages[$varGetCookieInfo['PRODUCTID']]));
$varWhereCond	= "WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB)."";
$varFields		= array('Auto_Renew');
$varOnlinePaymentInfo		= $objSlaveDB->select($varTable['ONLINEPAYMENTDETAILS'],$varFields,$varWhereCond,1);
$varAutoRenewalStatus = $varOnlinePaymentInfo[0]['Auto_Renew'];

if($varAutoRenewalStatus == 1) {
  $varOnChecked = "checked";
  $varOffChecked = "";
}
else {
  $varOnChecked = "";
  $varOffChecked = "checked";
}

?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<? if (in_array($confValues['DOMAINCASTEID'],$arrCSSFolder)) { ?>
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<? } ?>
</head>
<body <?=$varRightClickDisable;?>>
<center>

<div class="rpanel bgclr2 padb10">
	<div class="pad10" style="height:16px !important;height:30px;">
		<div class="normtxt fnt17 clr bld fleft">Membership Details</div>
	</div>
	<center>
	<div class="bgclr5" style="width:540px;">
		<div style="width:520px;">
		  <form name="frmAutoRenewalControl" method="post">
			<table width="520" cellspacing="0" cellpadding="0" border="0" align="center">
			<tr><td width="160" class="bld normtxt" height="40">Matrimony ID :</td>
				<td width="360" class="normtxt"><?=$sessMatriId?></td>
			</tr>
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td width="160" class="bld normtxt" height="40">Type of membership :</td>
				<td width="360" class="normtxt"><?=$varPrdPackageName?> - <?=$varPrdPackageDuration?></td>
			</tr>
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td width="160" class="bld normtxt" height="40">Validity period :</td>
				<td width="360" class="normtxt"><?=$varGetCookieInfo['VALIDDAYSLEFT']?> Days</td>
			</tr>
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td width="160" class="bld normtxt" height="40">Date of expiry :</td>
				<td width="360" class="normtxt"><?=$varPaidExpire?></td>
			</tr>
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td width="160" class="bld normtxt" height="40">Last renewed :</td>
				<td width="360" class="normtxt"><?=$varPaidMemberSince?></td>
			</tr>

			<?php if($varGetCookieInfo['PAYMENTCURRENCY'] != '' && $varGetCookieInfo['PAYMENTCURRENCY'] != 'Rs') { ?>
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td width="160" class="bld normtxt" height="40">Auto renewal status :</td>
				<td width="360" class="normtxt"><input type="radio" name="autoRenewal" <?=$varOnChecked?> value="1"/> Auto renewal ON &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="autoRenewal" <?=$varOffChecked?> value="0"/> Auto renewal OFF &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="Save" /></td>
			</tr>
			
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td class="normtxt padtb10 lh16 tljust" colspan="2" style="padding-left:2px;"><b>What you gain through auto renewal :</b><br>By setting your auto renewal status ON, your current membership package will be automatically renewed for a period of 3 months from the date of expiry. You will also get special 10% discount.</td>
			</tr>
			<?php } ?>

			</table>
			<input type="hidden" name="frmAutoRenewalControl" value="1"/>
		 </form>
		</div>
		<div style="height:10px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="10" /></div>
	</div>
	</center>
</div>
</center>
</body>
</html>
<?php } ?>