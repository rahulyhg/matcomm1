<?php
//FILE INCLUDES
//include_once('/home/mailmanager/cbsmailer/ip.inc');
include_once('/home/product/community/ability/conf/ip.inc');
include_once('/home/product/community/ability/conf/domainlist.inc');
require("smtp.php");

$varSourceType	= strtolower(trim($_REQUEST["sourcetype"]));
$varContentFile	= array('prcase1'=>'0','prcase2'=>'1','deleted'=>'2','classified'=>'3','inactive'=>'4');
$arrTrackIdList	= array('prcase1'=>'00510001002','prcase2'=>'00410000003','deleted'=>'00410000002','classified'=>'00410000001','inactive'=>'00410000004');

$arrSubject	= array('prcase1'=>'Exclusive matrimony portal for your community. Click here to Register Free','prcase2'=>'Still Searching For A Partner?','deleted'=>'2','classified'=>'3','inactive'=>'4');

$varTrackId			= $arrTrackIdList[$varSourceType];
$varSubject			= $arrSubject[$varSourceType];
$varSendFilename	= date('Ymd').'_'.$varSourceType.'_'.date('H:i:s').'_MailSent.txt';

if ($varContentFile[$varSourceType] !='') {

$smtp=new smtp_class;

function sendFreeToPaidEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress,$smtp) {
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

    /* SMTP variables and handling */
	$smtp->host_name="172.28.0.236";       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
	$smtp->host_port=587;                /* Change this variable to the port of the SMTP server to use, like 465 */
	$smtp->ssl=0;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
	$smtp->localhost="localhost";       /* Your computer address */
	$smtp->timeout=10;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
	$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server. Set to 0 to use the same defined in the timeout variable */
	$priority = 1;

	/*if($smtp->SendMessage("noreply@bounces.communitymatrimony.com", array($argToEmailAddress), array("From: $argFromEmailAddress", "Reply-to: $argReplyToEmailAddress", "Sender: $argFromEmailAddress", "MIME-Version: 1.0", "Content-type: text/html", "X-Priority: ".$priority, "X-Mailer: PHP mailer", "To: ".$argToEmailAddress, "Subject: $argSubject", "Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")), stripslashes($argMessage))) {
		$funValue = 'yes';
	}*/

	if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if

	return $funValue;
}

//VARIABLE DECLARATION
$varCurrentDate		= date('Ymd');
$varCurrentDateTime	= date('Y-m-d H:i:s');

//$varFileName		= 'prcase2file_20100212.txt';//$varCurrentDate.'.txt'; //FILE NAMEE
//chmod($varFileName, 0777);

//$varFileName		= '/home/product/community/ability/mailer/members_test.txt';
$varFileName		= file('/home/product/community/ability/mailer/members_test.txt');
$varFrom			= 'CommunityMatrimony.Com';
$varFromEmail		= 'info@communitymatrimony.com';
$varReplyToEmail	= 'noreply@communitymatrimony.com';

$i = 0;
foreach($varFileName as $varFileInfo) {

	$varToEmailAddress	= '';
	$varDomaiId			= '';
	$varMessage			= '';
	$varTo			= '';

	$varFileArray		= split('~', $varFileInfo);
	$varToEmailAddress	= trim($varFileArray[0]);
	$varDomaiId			= trim($varFileArray[1]);

	$varDomaiPrefix		= trim($arrMatriIdPre[$varDomaiId]);
	$varDomainName		= trim($arrPrefixDomainList[$varDomaiPrefix]);
	$varShortName		= ucwords(str_replace("matrimony.com","",$varDomainName));
	if ($varDomainName !='') {
	include($varSourceType.'.php');
	$varMessage			= stripslashes($varTemplate);
	echo '<br><br>'.$varMessage;
	sendFreeToPaidEmail($varFrom,$varFromEmail,$varTo,$varToEmailAddress,$varSubject,$varMessage,$varReplyToEmail,$smtp);
	$i++;

	}

	$varTrackDetails	= $i.'~'.$varToEmailAddress;
	$varSendHandler		= fopen($varSendFilename,"w+");
	fwrite($varSendHandler,$varTrackDetails);
	fclose($varSendHandler);

}

$varFrom			= 'CommunityMatrimony';
$varFromEmail		= 'CommunityMatrimony.Com';
$varSubject			= $varSourceType.' Completed';
$varMessage			= 'Total Count ='.$i;
//$varToEmailAddress	= 'ashokkumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com';
//$varToEmailAddress	= 'dhanapal.n@gmail.com';
//sendFreeToPaidEmail($varFrom,$varFromEmail,$varTo,$varToEmailAddress,$varSubject,$varMessage,$varReplyToEmail,$smtp);

//CONNECT MYSQL
$mysql_connection	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

//Update into cbsmailer report table
$varInsertQuery	= "INSERT INTO cbsmailer_report (MailerType,Count,SentOn) VALUES ('".$varSourceType."',".$i.",'".$varCurrentDateTime."')";
//$varInsertId	= mysql_query($varInsertQuery) or die('insert_error');
mysql_close($mysql_connection) or die('error');

} else {
	echo 'Please specify the mail type';
}

?>
