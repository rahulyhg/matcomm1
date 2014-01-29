<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRoot = dirname($varRootPath);

//FILE INCLUDES
include_once($varBaseRoot."/conf/domainlist.inc");
include_once($varBaseRoot."/lib/clsMailManager.php");
include_once($varRootPath."/data-conversion/migrated-details-tmpl.php");

//OBJECT DECLARATION
$objMailManager = new MailManager;

for($i=0; $i<1; $i++){
	
	//CONTROL STATEMENT
	$varAllDetails	= file($varRootPath.'/data-conversion/pro-user-info'.$i.'.txt');
	$varSleepCount  = 0;
	foreach($varAllDetails as $varSingleDetail)
	{
		$varNewMatriId	= '';
		$varToEmail		= '';
		$varPassword	= '';
		$varMessage		= '';
		$varImgsUrl		= '';
		$varServerUrl	= '';
		$varSubject		= '';
		$varFrom		= '';
		$varFromEmail	= '';
		$varContent		= '';
		$varReplyToEmail= '';

		$varUserInfo	= split('~',trim($varSingleDetail, "\n"));
		$varNewMatriId	= $varUserInfo[1];
		$varPassword	= $varUserInfo[3];
		$varToEmail		= $varUserInfo[4];

		//VARIABLE DECLARATION
		$varFrom		= "AbilityMatriMony.com";
		$varFromEmail	= "info@abilitymatrimony.com";
		$varImgsUrl		= 'http://www.abilitymatrimony.com/mailer/images/';
		$varServerUrl	= 'http://www.abilitymatrimony.com';
		
		$varContent		= stripslashes($varTemplate);
		$varMessage1	= str_replace('<--IMGSURL-->',$varImgsUrl,$varContent);
		$varMessage2	= str_replace('<--SERVERURL-->',$varServerUrl,$varMessage1);
		$varMessage3	= str_replace('<--COMMUNITYID-->',$varNewMatriId,$varMessage2);
		$varMessage4	= str_replace('<--PASSWORD-->',$varPassword,$varMessage3);
		
		$varSubject		= 'Your login information on Ability Matrimony.com';
		$varReplyToEmail= 'helpdesk@abilitymatrimony.com';

		$objMailManager->sendEmail($varFrom,$varFromEmail,$varNewMatriId,$varToEmail,$varSubject,$varMessage4,$varReplyToEmail);	
		if ($varSleepCount==1000) { sleep('5'); $varSleepCount=0;}//if
		$varSleepCount++;
	}//foreach
}

//UNSET OBJECT
UNSET($objMailManager);
?>