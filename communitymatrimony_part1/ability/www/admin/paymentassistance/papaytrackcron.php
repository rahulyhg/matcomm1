<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date		: 22 Feb 2010
# Module		: Payment Assistance
#====================================================================================================
//BASE PATH
$varRootBasePath = '/home/product/community/ability';

include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/vars.inc');

$objMaster	= new DB;
$objSlave	= new DB;

global $varDBUserName, $varDBPassword;

$objSlave  -> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
$objMaster -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);

$yesdate=date("Y-m-d", mktime(0, 0, 0, date(m),date(d)-1,date(Y)));



$sqloffQuery="select a.Matriid as mid,b.ProductId as pid,b.AmountPaid  as amountpaid,b.Discount as discount,b.PaymentTime as paydate,b.Comments as paycomments,a.Comments as colcomments from  where a.Matriid=b.Matriid and b.PaymentTime>='".$yesdate." 00:00:00' and b.PaymentTime<='".$yesdate." 23:59:59'";


//$arrPACol = array('a.Matriid','a.ProductId','a.AmountPaid');
$arrPACol = array('distinct(a.MatriId)','a.EntryType','b.Date_Paid','b.Product_Id','b.Amount_Paid','User_Name');
echo $arrPACond = " where a.MatriId = b.MatriId and b.Date_Paid >= '".$yesdate." 00:00:00' and b.Date_Paid <= '".$yesdate." 23:59:59' and group by a.MatriId order by b.Date_Paid desc ";
$arrPARes = $objSlave -> select($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS']." as a , ".$varDbInfo['DATABASE'].".".$varTable['PAYMENTHISTORYINFO']." as b",$arrPACol,$arrPACond,0);

//exit;

while($arrPARow = mysql_fetch_assoc($arrPARes))
{
	echo "<br>".$arrPARow['MatriId']. " : ".$arrPARow['EntryType']. " : ".$arrPARow['Date_Paid'];
	
	$argFields = array('EntryType','AmountPaid','PaymentDate');
	$argFieldsValues = array("'1'","'".$arrPARow['Amount_Paid']."'","'".$arrPARow['Date_Paid']."'");
	$argCondition = " MatriId = '$arrPARow[MatriId]'";
	$updateCount = $objMaster -> update($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],$argFields,$argFieldsValues,$argCondition);
	echo "<br> Count - ".$updateCount1++;
//echo "<br> error - ".$objMaster -> clsErrorCode;
}
echo "<br><br> GT -  ".$updateCount1;
/*

$arrPACol = array('MatriId');
$arrPACond = " where EntryType = 0";
$arrPARes = $objSlave -> select($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],$arrPACol,$arrPACond,0);
while($arrPARow = mysql_fetch_assoc($arrPARes))
{
	$paymentDate = payDateMem($arrPARow['MatriId']);
	$paymentDate1 = explode(" ",$paymentDate);
	$paymentDate2 = explode("-",$paymentDate1[0]);
	
	$paymentDateMKTIME = mktime(0,0,0,$paymentDate2[1],$paymentDate2[2],$paymentDate2[0]);
	$currDATE1 = date("Y-m-d");
	$currDATE = explode("-",$currDATE1);
	$currTime = mktime(0,0,0,$currDATE[1],$currDATE[2],$currDATE[0]);
	$oneDayBefore = mktime(0,0,0,$currDATE[1],$currDATE[2]-1,$currDATE[0]);
	echo "<br>MatriId - ".$arrPARow['MatriId']." : Date Diff - ".$dateDiff = $paymentDateMKTIME - $oneDayBefore;

}


function payDateMem($matriId)
{
	global $objSlave,$varDbInfo,$varTable;
	$payDateCol = array('Date_Paid');

	$yesdate=date("Y-m-d", mktime(0, 0, 0, date(m),date(d)-1,date(Y)));

	$payDateCond = "where MatriId = '$matriId' and Date_Paid >=  '' ";
	$payDateRow = $objSlave -> select($varDbInfo['DATABASE'].".".$varTable['PAYMENTHISTORYINFO'],$payDateCol,$payDateCond,1);
	if($objSlave -> clsErrorCode != "")
	{
		echo "<br> Error - ".$objSlave -> clsErrorCode;
		exit;
	}
return $payDateRow[0]['Date_Paid'];
}
*/
?>