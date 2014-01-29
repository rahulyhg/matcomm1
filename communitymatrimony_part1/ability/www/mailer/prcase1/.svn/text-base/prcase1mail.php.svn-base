<?php
//FILE INCLUDES
//include_once('/home/mailmanager/cbsmailer/ip.inc');
include_once('/home/product/community/ability/conf/ip.inc');
include_once('prcase1content.php');

//CONNECT MYSQL
$mysql_connection	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

function sendFreeToPaidEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress) {
	$funValue				= '';
	$funheaders				= '';
	$argFrom				= preg_replace("/\n/", "", $argFrom);
	$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
	$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
	$argMessage				= preg_replace("/<--TO_EMAIL-->/", $argToEmailAddress, $argMessage);
	$funheaders				.= "MIME-Version: 1.0\n";
	$funheaders				.= "X-Mailer: PHP mailer\n";
	$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
	$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
	$funheaders				.= "Reply-To: ".$argFrom."<".$argReplyToEmailAddress.">\n";
	$funheaders				.= "Return-Path:<noreply@bounces.communitymatrimony.com>\n";
	$funheaders				.= "Sender:".$argFrom."<".$argFromEmailAddress.">\n";
	$argheaders				= $funheaders;
	$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);

	if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if

	return $funValue;
}

//VARIABLE DECLARATION
$varCurrentDate		= date('Ymd');
$varCurrentDateTime	= date('Y-m-d H:i:s');
$varFileName		= file($varCurrentDate.'.txt');
$varSubject			= "Exclusive matrimony portal for your community. Click here to Register Free";
$varFrom			= 'CommunityMatrimony.Com';
$varFromEmail		= 'info@communitymatrimony.com';
$varReplyToEmail	= 'noreply@communitymatrimony.com';

$i = 0;
foreach($varFileName as $varFileInfo) {
	$varToEmailAddress	= '';
	$varFileArray		= split('~', $varFileInfo);
	$varToEmailAddress	= trim($varFileArray[0]);
	$varMessage			= stripslashes($varTemplate);
	sendFreeToPaidEmail($varFrom,$varFromEmail,$varTo,$varToEmailAddress,$varSubject,$varMessage,$varReplyToEmail);
	$i++;
}

//Update into cbsmailer report table
$varInsertQuery	= "INSERT INTO cbsmailer_report (MailerType,Count,SentOn) VALUES ('PR Case1',".$i.",'".$varCurrentDateTime."')";
$varInsertId	= mysql_query($varInsertQuery) or die('insert_error');

mysql_close($mysql_connection) or die('error');
?>