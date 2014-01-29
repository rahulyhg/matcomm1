<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2008-09-28
# End Date		: 2008-09-28
# Project		: Weekly Mailer - Cron
#=============================================================================================================
//FILE INCLUDES
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');


//OBJECT DECLARTION

$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$microlastsunday = strtotime("last Sunday");
$lastsunday = date("Y-m-d H:i:s",$microlastsunday);

$microlastsaturday = strtotime("last saturday");
$lastsaturday = date("Y-m-d");
$lastsaturday .= " 11:59:59";

if($microlastsunday > $microlastsaturday)
{
	//$argCondition			= "WHERE SentOn BETWEEN '$lastsunday' and '$lastsaturday' group by Count";
	//$argCondition			= "WHERE SentOn BETWEEN '2009-09-10 00:00:00' and '2009-09-20 00:00:00' group by MailerType";
	$argCondition			= "WHERE SentOn BETWEEN '2009-09-10 00:00:00' and '2009-09-20 00:00:00'";
	//$argCondition			= "WHERE SentOn BETWEEN '$lastsunday' and '$lastsaturday'";
	$argFields = array('MailerType','Count','SentOn');


	if($varSelectSuccessForCron	= $objSlave -> select('cbsmailer_report',$argFields,$argCondition,0))
	{
		$varSelectSuccessForCronTable .= "<table cellpadding='3' cellspacing='0' align='center' width='50%'>";
		$varSelectSuccessForCronTable .= "<tr><th bgcolor='#666666'>Mailer Type</th><th bgcolor='#666666'>Count</th><th bgcolor='#666666'>Sent On</th></tr>";
		while($varSelectSuccessForCronRow = mysql_fetch_assoc($varSelectSuccessForCron))
		{
			$varSelectSuccessForCronTable .= "<tr><td bgcolor='#CCCCCC'>$varSelectSuccessForCronRow[MailerType]</td><td bgcolor='#CCCCCC'>$varSelectSuccessForCronRow[Count]</td><td bgcolor='#CCCCCC'>$varSelectSuccessForCronRow[SentOn]</td></tr>";
		}
		$varSelectSuccessForCronTable .= "</table>";
	}
$varSelectSuccessForCronTable;
}
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "From: webmaster@example.com";
$to = "kircyclone@gmail.com";
$lastsunday1 = explode(" ",$lastsunday);
$lastsaturday1 = explode(" ",$lastsaturday);
$subject = "CBS - Weekly Mailer Report $lastsunday1[0] to $lastsaturday1[0]";
$body = "Dear All, <br>$subject<br><br>".$varSelectSuccessForCronTable;
mail($to,$subject,$body,$headers);	
?>