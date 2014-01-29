<?php
// INCLUDES //
$varRootBasePath = '/home/product/community/ability';
include_once($varRootBasePath.'/lib/clsMailManager.php');

// Assigning the input argument(parameter) values to variables //
$arg1              = trim($_SERVER['argv'][0]); // php filename itself
$varMailerListFile = trim($_SERVER['argv'][1]); // Mailer List File name
$varTemplateName   = trim($_SERVER['argv'][2]); // Email template source name
$varMailSubject    = trim($_SERVER['argv'][3]); // Email template source name
$argcount = trim($_SERVER['argc']);    // Count of arguments catched as input

// VARIABLE DECLARATION //
$varSubject		= '';
$varFileName	= '';
$varCurrentDate = date('Y-m-d');
if (trim($varMailSubject)=='pongal') {
	$varSubject		= "Warmest wishes for a Happy Pongal!";
} elseif (trim($varMailSubject)=='nonpongal') {
	$varSubject		= "One decision could change your life for the better!";
} elseif (trim($varMailSubject)=='makar') {
	$varSubject		= "Warmest wishes for a Happy Makar Sankranti!";
} else {
	$varSubject		= "One decision could change your life for the better!";
}

if (trim($varMailerListFile)!='') {
	$varFileName	= file($varMailerListFile);
} else {
	$varFileName	= file('members_test.txt');
}


//FILE NAME
$varSendFilename= date('Ymd').'_'.date('H:i:s').'_MailSent.txt';

//OBJECT DECLARATION //
$objMailManager	= new MailManager;

$i = 1;
foreach($varFileName as $varFileInfo) {

	//NULL PREVIOUS VALUES....
	$varTemplate		= '';
	$varMessage			= '';
	$varTemplateMessage	= '';
	$varToEmailAddress	= '';
	$varMatriId			= '';//NEED
	$varDoorStepContent	= '';
	$varName			= '';
	$varFrom			= '';
	$varFromEmail		= '';
	$varReplyToEmail	= '';
	$varCountry			= '';
	$varDomainDetails	= '';
	$varDomainFolder	= '';
	$varDomainName		= '';
	$varDomainDetails	= array();
	$varSegment			= '';
	$varPrefix			= '';
	$varDomainEmail		= '';

	$varFileArray		= split('~', $varFileInfo);
	$varToEmailAddress	= trim($varFileArray[0]);
	$varCountry			= trim($varFileArray[1]);
	$varMatriId			= trim($varFileArray[2]);
	$varName			= ucwords(strtolower(trim(stripslashes($varFileArray[3]))));
	$varName			= $varName ? $varName : 'Member';

	$varPrefix			= substr($varMatriId,0,3);

	//GET DOMAIN DETAILS
	$varDomainDetails	= $objMailManager->getDomainDetails($varMatriId);
	$varDomainFolder	= $objMailManager->getFolderName($varMatriId);

	$varServerURL		= $varDomainDetails['SERVERURL'];
	$varDomainName		= $varDomainDetails['PRODUCTNAME'];
	$varFrom			= $varDomainDetails['FROMADDRESS'];
	$varDomainEmail		= strtolower(str_replace(" ","",$varFrom));
	$varFromEmail		= 'info@'.$varDomainEmail;
	$varReplyToEmail	= 'payment@communitymatrimony.com';
	$varLogo			= $varDomainDetails['IMGURL'].'/logo/'.$varDomainFolder.'_logo.gif';

	if (trim($varTemplateName)!='') {
		include($varTemplateName);
	} else {
		include('allcountries.php');
	}
	$varTemplateMessage	= stripslashes($varTemplate);
	$varMessage			= $varTemplateMessage;
	$varTo				= '';

	echo sendFreeToPaidEmail($varDomainDetails['FROMADDRESS'],$varFromEmail,$varTo,$varToEmailAddress,$varSubject,$varMessage, $varReplyToEmail);
	//if ($i <=100) { print $i.'~'.$varToEmailAddress."\n"; }
	//print $i.'~'.$varToEmailAddress."\n";
	//CREATE FILE
	$varSendHandler	= fopen($varSendFilename,"w+");
	fwrite($varSendHandler,$i);
	fclose($varSendHandler);
	$i++;
}





print $i.'~'.$varToEmailAddress."\n";

UNSET($objMailManager); //UNSET OBJECT

function sendFreeToPaidEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress) {

	$funValue				= '';
	$funheaders				= '';
	$argFrom				= preg_replace("/\n/", "", $argFrom);
	$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
	$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
	$funheaders				.= "MIME-Version: 1.0\n";
	$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
	$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
	$funheaders				.= "Reply-To: ".$argFrom."<".$argReplyToEmailAddress.">\n";
	$funheaders				.= "Return-Path:<noreply@bounces.communitymatrimony.com>\n";
	$funheaders				.= "Sender:".$argFrom."<".$argFromEmailAddress.">\n";
	$argheaders				= $funheaders;
	$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);

	//if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
	//return $funValue;
}

?>