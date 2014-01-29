<?php
# Author	:	A.Kirubasankar
# Date		:	30/03/2010
# Desc		:	this cron is used to send the total sms sent in the previous week .
# Filename	:	sendmailandsms.php


$varRootBasePath = '/home/product/community/ability';

/* Includes */
include_once($varRootBasePath.'/conf/dbinfo.inc');
//include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/lvars.php');

/* DB Object Declaration */
$objCommSlave	= new DB;

/* Connection vars for communitymatrimony DB */
$varDBUserName	= $varDbInfo['USERNAME'];
$varDBPassword	= $varDbInfo['PASSWORD'];


/* Connecting communitymatrimony db */
$objCommSlave -> dbConnect('S',$varDbInfo['DATABASE']);



//VARIABLE DECLARATION
$Sevendaysbefore = date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")));
$fromDate = $Sevendaysbefore;
$curdate = date('Y-m-d');
$i=0;

$smsArgs = array('SentOn','count(MatriId)');
$smsCond = "  where SentOn >='".$fromDate."' and SentOn <'".$curdate."' group by SentOn ";
$varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSSMSTRACK'];
$smsResult = $objCommSlave -> select($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSSMSTRACK'],$smsArgs,$smsCond,0);
if($objCommSlave -> clsErrorCode == "")
{
	$total = $objCommSlave -> numOfRecords($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSSMSTRACK'],'MatriId',$smsCond);
	if($total > 0)
	{
		$msg = "<table  cellspacing='3' cellpadding='2' style='border:1px solid #336600;' align='left' width='200'>";
		$msg .= "<tr><th style='FONT: bold 12px verdana; COLOR: rgb(51,255,51); font-size-adjust: none; font-stretch: normal' 
    align=middle bgColor=#336633>Sent On</th><th style='FONT: bold 12px verdana; COLOR: rgb(51,255,51); font-size-adjust: none; font-stretch: normal' 
    align=middle bgColor=#336633>SMS Counts</th></tr>";
		while($smsRow = mysql_fetch_assoc($smsResult))
		{
			if($i%2==0)	$bgcolor = ' bgcolor="#FDF8D7"';
			else $bgcolor = ' bgcolor="#FEFCE9"';	
			$i++;
			$dateFormat = explode("-",$smsRow['SentOn']);
			$repFormat = date('d-M-Y',mktime(0, 0, 0, $dateFormat[1],$dateFormat[2],$dateFormat[0]));
			$msg .= "<tr $bgcolor><td>".$repFormat."</td><td align='center'>&nbsp;".$smsRow['count(MatriId)']."</td></tr>";
			$gtotal = $gtotal + $smsRow['count(MatriId)'];
		}
		$msg .= "<tr> <td align='center' bgcolor='#336633' style='font:bold 12px verdana;color:#33FF33;'>Total</td> <td  align='center' bgcolor='#336633' style='font:bold 12px verdana;color:#33FF33;'>".$gtotal."</td> </tr>";
		$msg .= "</table>";

		$htm = "<html> <head> <title>counts</title> </head> <body><h3> Weekly Report of Total Sms Count for Payment Expiry [CBS Telemarketing]  </h3> ".$msg." </body> </html>";

		//send mail
		$HEADERS  = "MIME-Version: 1.0\n";
		$HEADERS .= "Content-type: text/html; charset=iso-8859-1\n";
		$HEADERS .= "From: BharatMatrimony.com <info@bharatmatrimony.com>\n";	
		//$HEADERS .= "Cc: suresh.a@bharatmatrimony.com, jshree@bharatmatrimony.com, saichitra@bharatmatrimony.com\n";
		$HEADERS .= "Cc: kirubasankar.a@bharatmatrimony.com\n";
		$Subject='Weekly Sms Count Report-CBS Telemarketing';
		//$to='jmuruga@consim.com';
		$to='suresh.a@bharatmatrimony.com';
		if(mail($to,$Subject,$htm,$HEADERS))
		{
			echo 'mail sent Succesfully';
		}
	}
	else{
	$msg = 'Query count is zero in cbs smstrack database for the dates from '.$fromDate.' till '.$Sevendaysbefore;
	$Subject='Weekly Sms Count Report-CBS Telemarketing[smsweeklyreport.php]';
	mail('suresh.a@bharatmatrimony.com',$Subject,$msg);
}
}
echo $htm;
?>
