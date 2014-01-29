<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRoot = dirname($varRootPath);

//FILE INCLUDES
include_once($varBaseRoot."/conf/domainlist.inc");
include_once($varBaseRoot."/lib/clsMailManager.php");
include_once($varRootPath."/data-conversion/migrated-GRUCOR-tmpl.php");

//OBJECT DECLARATION
$objMailManager = new MailManager;

for($i=0; $i<1; $i++){
	
	//CONTROL STATEMENT
	//$varAllDetails	= file($varRootPath.'/data-conversion/firstTxtfiles/migrated-userinfo/pro-user-info'.$i.'.txt');
	$varAllDetails	= file($varRootPath.'/data-conversion/GUR_COR_userinfo.txt');
	$varSleepCount  = 0;

	foreach($varAllDetails as $varSingleDetail)
	{
		$varNewMatriId	= '';
		$varToEmail		= '';
		$varPassword	= '';
		$varMessage		= '';
		$varImgsUrl		= '';
		$varServerUrl	= '';
		$varLogoUrl		= '';
		$varCasteTxt	= '';
		$varSubject		= '';
		$varDomain		= '';
		$varFrom		= '';
		$varFromEmail	= '';
		$varContent		= '';
		$varReplyToEmail= '';

		$varUserInfo	= split('~',trim($varSingleDetail, "\n"));
		$varNewMatriId	= $varUserInfo[1];
		$varPassword	= $varUserInfo[3];
		$varToEmail		= $varUserInfo[4];
		$varMatriIdPref	= substr($varNewMatriId, 0, 3);

		//VARIABLE DECLARATION
		$varDomain		= $arrPrefixDomainList[$varMatriIdPref];;
		$varFrom		= ucfirst($varDomain);
		$varFromEmail	= "info@".$varDomain;
		$varImgsUrl		= 'http://www.'.$varDomain.'/mailer/images/';
		$varServerUrl	= 'http://www.'.$varDomain;
		$varLogoUrl		= 'http://img.'.$varDomain.'/images/logo/'.$arrFolderNames[$varMatriIdPref].'_logo.gif';
		$varCasteTxt	= ucfirst(substr($arrPrefixDomainList[$varMatriIdPref],0,-13));
		
		$varContent		= stripslashes($varTemplate);
		$varMessage		= str_replace('<--LOGO-->',$varLogoUrl,$varContent);
		$varMessage1	= str_replace('<--IMGSURL-->',$varImgsUrl,$varMessage);
		$varMessage2	= str_replace('<--SERVERURL-->',$varServerUrl,$varMessage1);
		$varMessage3	= str_replace('<--COMMUNITYTXT-->',$varCasteTxt,$varMessage2);
		$varMessage4	= str_replace('<--COMMUNITYID-->',$varNewMatriId,$varMessage3);
		$varMessage5	= str_replace('<--PASSWORD-->',$varPassword,$varMessage4);
		
		$varSubject		= 'Your login information on '.$varCasteTxt.' Matrimony.com';
		$varReplyToEmail= 'helpdesk@'.$varDomain;
		print $varToEmail.'----'.$varMatriIdPref.'----'.$varReplyToEmail."\n";

		$objMailManager->sendEmail($varFrom,$varFromEmail,$varNewMatriId,$varToEmail,$varSubject,$varMessage5,$varReplyToEmail);	
		if ($varSleepCount==1000) { sleep('5'); $varSleepCount=0;}//if
		$varSleepCount++;
	}//foreach
}

//UNSET OBJECT
UNSET($objMailManager);
?>