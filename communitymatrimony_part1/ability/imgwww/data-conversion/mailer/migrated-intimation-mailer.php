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
include_once($varRootPath."/data-conversion/migrated-intimation-tmpl.php");

//OBJECT DECLARATION
$objMailManager = new MailManager;

//VARIABLE DECLARATION
$varFrom			= "BharatMatrimony.Com";
$varFromEmail		= "info@bharatmatrimony.com";
$varSubject			= "An exclusive matrimony portal for your community";

for($i=0; $i<1; $i++){
	
	//CONTROL STATEMENT
	$varAllDetails	= file($varRootPath.'/data-conversion/pro-user-info'.$i.'.txt');
	$varSleepCount  = 0;

	foreach($varAllDetails as $varSingleDetail)
	{
		
		$varOldMatriId	= '';
		$varNewMatriId	= '';
		$varToEmail		= '';
		$varUserInfo	= split('~',trim($varSingleDetail, "\n"));
		$varOldMatriId	= $varUserInfo[0];
		$varNewMatriId	= $varUserInfo[1];
		$varToEmail		= $varUserInfo[4];
		$varMatriIdPref	= substr($varNewMatriId, 0, 3);
		
		$varCasteTxt	= ucfirst(substr($arrPrefixDomainList[$varMatriIdPref],0,-13));
		$varContent		= stripslashes($varTemplate);
		$varMessage		= str_replace('<--CASTETXT-->',$varCasteTxt,$varContent);
		$varMessage1	= str_replace('<--EMAIL-->',$varToEmail,$varMessage);
		$varMessage2	= str_replace('<--OLDMATRIID-->',$varOldMatriId,$varMessage1);
		

		$varReplyToEmail	= "helpdesk@".$arrPrefixDomainList[$varMatriIdPref];
		print $varToEmail.'----'.$varMatriIdPref.'----'.$varReplyToEmail."\n";

		$objMailManager->sendMigrationEmail($varFrom,$varFromEmail,$varOldMatriId,$varToEmail,$varSubject,$varMessage2, $varReplyToEmail);	
		if ($varSleepCount==1000) { sleep('5'); $varSleepCount=0;}//if
		$varSleepCount++;
	}//foreach
}

//UNSET OBJECT
UNSET($objMailManager);
?>