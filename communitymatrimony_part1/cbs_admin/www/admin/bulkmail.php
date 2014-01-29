<?php
#=============================================================================================================
# Author 		: Baranidharan
# Date	        : 2010-05-13
# Project		: Community Matrimony Product
# Module		: Admin Support Interface
# Description   : Sending mail to bulk ids
#=============================================================================================================

$varReportRootBasePath	= '/home/product/community';

//FILE INCLUDES
include_once($varReportRootBasePath.'/conf/config.cil14');
include_once($varReportRootBasePath.'/conf/dbinfo.cil14');
include_once($varReportRootBasePath.'/lib/clsDB.php');
include_once($varReportRootBasePath.'/lib/clsReport.php');
  
//OBJECT DECLARATION
$objReport	        = new Report;
$objDB              = new DB;

//DB CONNECTION
$objDB->dbConnect('S',$varDbInfo['DATABASE']);
?>
<html>
<head>
<title>
Sending bulk mail through php script
</title>
<link rel=stylesheet href="<?=$confValues["CSSPATH"]?>/global-style.css">
<script src="<?=$confValues["JSPATH"]?>/jquery.js" type="text/javascript"></script>
<script src="<?=$confValues["JSPATH"]?>/jquery-validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#frmSendMail").validate();
});
</script>
<style type="text/css">
#frmSendMail label.error
{
	color:red;
	display:block;
	width:130px;
}
</style>
</head>
<?php
if(isset($_REQUEST['submit'])) {
  
   $argFrom = trim($_REQUEST['fromAddress']);
   $argFromEmailAddress = trim($_REQUEST['fromAddress']);
   $argTo = trim($_REQUEST['toAddress']);
   $argToEmailAddress = trim($_REQUEST['toAddress']); 
   $argSubject = trim($_REQUEST['subject']);
   $varMessage = trim(nl2br($_REQUEST['message']));
   $argReplyToEmailAddress = trim($_REQUEST['fromAddress']);

  $argToEmailAddress = explode(',',$argToEmailAddress);
  foreach($argToEmailAddress as $key => $value) {
	   echo $value = trim($value);
       $argToEmailAddress[$key] = "'".$value."'";
  }
  $argCondition			= "WHERE MatriId in (".join(',', $argToEmailAddress).")";
  $argFields 				= array('Email');
  $varEmailRes	= $objDB->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
  $varCount = 0;
  while($varRow = mysql_fetch_assoc($varEmailRes)) {
    $argToEmailAddress = $varRow['Email'];
	$varMailSend			= $objReport->sendEmail($argFrom,$argFromEmailAddress,$argToEmailAddress,$argToEmailAddress,$argSubject,$varMessage,$argReplyToEmailAddress);
	if ($varMailSend == 'yes') {
       $varCount = $varCount + 1;
	}
  }
  echo "<br clear='all'><label class=smalltxt><b>Email has been Sent Successfully to ".$varCount. " Emails</label></b>";
}

?>

<body>

<form name="frmSendMail" id="frmSendMail" method="post">

<table boder=1 valign="middle" align="center" cellpadding=8 cellspacing=8>
<caption><label class="heading"><b>Mailing Interface</b></label></caption>
<tr class="smalltxt">
<td><label>From Address</label></td><td><input type="text" name="fromAddress" class="inputtext required email"  size="40"></td>
</tr>

<tr class="smalltxt">
<td><label>To Address<br>(Separate Email ids by commas)</label></td><td><input type="text" name="toAddress" class="inputtext required"  size=40></td>
</tr>

<tr class="smalltxt">
<td><label>Subject</label></td><td><input type="text" name="subject" class="inputtext required"  size=40></td>
</tr>

<tr class="smalltxt">
<td><label>Message</label></td><td><textarea type="text" class="inputtext required" name="message" rows=5 cols=50></textarea></td>
</tr>

<tr class="smalltxt"><td colspan=2 align="center"><input type="submit" name="submit" value="send" class="button"></td></tr>

</table>

</form>

</body>
</html>