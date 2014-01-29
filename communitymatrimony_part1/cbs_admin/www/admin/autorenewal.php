<?php
$varRootBasePath	= '/home/product/community';
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php"); 

$varMatriId    = $_REQUEST['id'];
$varExpiryDate =$_REQUEST['expdate'];

$objMasterDB   = new DB;
$objSlaveDB    = new DB;
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);

if($_POST['frmAfterSubmit'] == 'yes') {
  $varFields		= array('Auto_Renew');
  $varFieldsVal	    = array($objMasterDB->doEscapeString($_POST['autoRenewal'],$objMasterDB));
  $varWhereCond	    = " MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB)."";
  $objMasterDB->update($varTable['ONLINEPAYMENTDETAILS'],$varFields,$varFieldsVal,$varWhereCond);
}

$varFields		      = array('Auto_Renew','Currency','Date_Captured');
$varWhereCond	      = "WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
$varOnlinePaymentInfo = $objSlaveDB->select($varTable['ONLINEPAYMENTDETAILS'],$varFields,$varWhereCond,1);
$varAutoRenewalStatus = $varOnlinePaymentInfo[0]['Auto_Renew'];

if($varAutoRenewalStatus == 1) {
  $varOnChecked = "checked";
  $varOffChecked = "";
}else {
  $varOnChecked = "";
  $varOffChecked = "checked";
}

?>
<html>
<head>
	<title>Auto renewal</title>
</head>
<body>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="542" align="left">
	<tr><th class="heading">Member Details </th></tr>		
	<tr>
	<form name="frmAutoRenewalControl" method="post">
		<input type="hidden" name="frmAfterSubmit" value="yes"/>
		<table width="520" cellspacing="0" cellpadding="0" align="center">
		<?php if (isset($_REQUEST['frmAfterSubmit'])) {?>
		<tr><td width="150" class="bld normtxt" height="40" align="center">Auto Renewal updated successfully.</td></tr>
		<tr><td width="150" class="bld normtxt" height="40" align="center"><input type="Button" class="button" name="Close" value="Close" onclick="javascrip : window.close()"/></td></tr>
		<?php } else {?>
			<tr><td width="150" class="mediumtxt" height="40">Matrimony ID :</td>
				<td width="350" class="normtxt"><?=$varMatriId?></td>
			</tr>
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td width="150" class="mediumtxt" height="40">Date of expiry :</td>
				<td width="350" class="normtxt"><?=$varExpiryDate?></td>
			</tr>
			<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<tr><td width="150" class="mediumtxt" height="40">Auto renewal status :</td>
				<td width="350" class="normtxt"><input type="radio" name="autoRenewal" <?=$varOnChecked?> value="1"/> ON &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="autoRenewal" <?=$varOffChecked?> value="0"/> OFF &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="Save" /></td>
			</tr>
			<?php }?>
		</table>		
	</form>
</tr>
	
	
</table>

</body>
</html>