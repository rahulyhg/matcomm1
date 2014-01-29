<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 08 Oct 2009
# End Date		: 20 Aug 2008
# Module		: Payment Assistance
#====================================================================================================

//include_once("header.php");
//login_checker();

//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
//include_once($varRootBasePath."/www/admin/includes/clsCommon.php");

global $adminUserName;
if($adminUserName == "")
	header("Location: ../index.php?act=login");


//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new DB;
$objSlaveMatri = new DB;

//DB CONNECTION
$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);


global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];

$objSlave -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);
$objMaster -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);


$uid        = $COOKIE['userid'];
$name        = $adminUserName;

?>
<html> 
<head>
<script language="javascript" src="../includes/supportcheckstatus.js"></script>

	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/usericons-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/messages.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">

</head>
<body>
<table>
<tr><td><br/><br/><br/></td></tr>
</table>
<table align=center border="0" cellpadding="0" cellspacing="0"  width="780"  style='border: 1px solid #d1d1d1;'>

<tr><td>
<?php
//include("../home/header.php");
?>
</td></tr>
<tr align="right" class="adminformheader" height="25"><td>TeleCallerId [<?=$name;?>] &nbsp;<!-- <a href='index.php' class='textsmallnormal'><B>Home</B> --></a> 
<!--- | <A HREF="../index.php?act=logout" class='textsmallnormal'><B>Logout</B></A> --->
&nbsp;</td></tr>
<tr><td style='border-top: 1px solid #d1d1d1;padding-left:10px;'>
<?php
$today = date("Y-m-d");
$htm="<BR>
<b>Today's report : $today</b><BR>
<BR><table border=0 cellpadding=4 cellspacing=0 width=99% style='border:solid 1px #d1d1d1;'><tr>";

$cnt=1;
$totcount=0;
//Query to select the unique userid's and username
foreach($paymentoption_followup_status as $key=>$value)
{
	$htm1.="<td style='border:solid 1px #d1d1d1;' class='smalltxt'>".$value."</td>";
	/*
		$sel_query="select count(MatriId) as cnt from paymentoptions where FollowupStatus=".$key." and DateUpdated >='".$today." 00:00:00' and DateUpdated <='".$today." 23:59:59' and SupportUserId=".$uid."";
		$numofrows=$dbsupport14->select($sel_query);
		$rowcount=$dbsupport14->fetchArray();
	*/
	//$argCondition = " WHERE FollowupStatus=".$key." and DateUpdated >= '".$today." 00:00:00' and DateUpdated <='".$today." 23:59:59' and SupportUserId='".$uid."'";
	
	//$argCondition = " WHERE FollowupStatus=".$key." and DateUpdated >= '".$today." 00:00:00' and DateUpdated <='".$today." 23:59:59' and SupportUserName='".$adminUserName."'";
	 
	$argCondition = " WHERE FollowupStatus=".$key." and DateUpdated >= '".$today." 00:00:00' and DateUpdated <='".$today." 23:59:59' and SupportUserName=".$objSlave->doEscapeString($adminUserName,$objSlave)." ";

	$rowcountcnt = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONSFOLLOWUPDETAILS'], 'distinct(MatriId)', $argCondition);
	
	 
	if($objSlave -> clsErrorCode == "CNT_ERR")
	{
		echo "Database error";
	}
	//$htm2.="<td style='border:solid 1px #d1d1d1;' align=center>".$rowcount['cnt']."</td>";
	$htm2.="<td style='border:solid 1px #d1d1d1;' class='smalltxt' align=center>".$rowcountcnt."</td>";
	$totcount = $rowcountcnt + $totcount;
}

$htm1.="<td style='border:solid 1px #d1d1d1;' class='smalltxt'>Totals calls today</td>";
$htm2.="<td style='border:solid 1px #d1d1d1;' class='smalltxt' align=center>".$totcount."</td>";
/*
$payquery="select count(MatriId) as paycnt from paymentoptions where FollowupStatus!=0 and PaymentDate >='".$today." 00:00:00' and  PaymentDate <='".$today." 23:59:59' and SupportUserId=".$uid."";
$dbsupport14->select($payquery);
$paycount=$dbsupport14->fetchArray();
*/
$yesterdaystr = strtotime("Yesterday");
$yesterday = date("Y-m-d",$yesterdaystr)." 00:00:00";
$yesterdayevening = date("Y-m-d",$yesterdaystr)." 23:59:59";

//$yesterday = date("Y-m-d")." 00:00:00";
//$yesterdayevening = date("Y-m-d")." 23:59:59";

//$argCondition = " where FollowupStatus!=0 and PaymentDate >='".$yesterday."' and  PaymentDate <='".$yesterdayevening." ' and SupportUserId='".$uid."'";
$argCondition = " where FollowupStatus<>0 and DateUpdated >='".$yesterday."' and  DateUpdated <='".$yesterdayevening." ' and SupportUserName=".$objSlave->doEscapeString($adminUserName,$objSlave)." ";



$paycnt = $objSlave -> numOfRecords($varTable['PAYMENTOPTIONSFOLLOWUPDETAILS'], 'distinct(MatriId)', $argCondition);
if($objSlave -> clsErrorCode == "CNT_ERR")
{
	echo "Database error";
}
$htm1.="<td style='border:solid 1px #d1d1d1;' class='smalltxt'>Yesterday Conversion</td>";
//$htm2.="<td style='border:solid 1px #d1d1d1;' align=center>".$paycount['paycnt']."</td>";
$htm2.="<td style='border:solid 1px #d1d1d1;' align=center  class='smalltxt'>".$paycnt."</td>";

$htm1.="</tr>";
$htm2.="</tr>";
echo $htm.$htm1.$htm2;
echo "</table>";
echo "<br>";
?>
&nbsp;</td></tr>
</table>
</body>
</html>
<?php 
//include ("footer.php");
?>
<?php
$objSlaveMatri -> dbClose();
$objSlave -> dbClose();
$objMaster -> dbClose();
?>