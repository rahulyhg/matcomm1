<?php

//FILE INCLUDES
//include_once('/home/mailmanager/cbsmailer/ip.inc');
include_once('/home/product/community/ability/conf/ip.inc');
include_once('/home/product/community/ability/conf/dbinfo.inc');
include_once('/home/product/community/ability/conf/config.inc');
include_once('/home/product/community/ability/conf/domainlist.inc');
include_once('/home/product/community/ability/lib/clsMailManager.php');
include_once('/home/product/community/ability/lib/clsMailerMatchWatch.php');

//OBJECT DECLARATION
$objMailManager			= new MailManager;
$objMailerMatchWatch	= new MailerMatchWatch;

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

$varCurrentDateTime	= date('Y-m-d H:i:s');
$varCurrentDate	= date('Ymd');
$varSubject			= "Express Interest Reminder! Don't let proposals wait for you.";
$varTrackDtls		= "trackid=00410000006&type=internal&formfeed=y";

$varContentFile	= 'ExpInt_Pending';
$varMailerType	= 'ExpInt_Pending';
$varFileName	= '';
$argPurpose		= 'inbox_ei';
if($argv[1]!='') {
	$varFileName	= '/home/product/community/ability/remindermailer/expintpending/'.$argv[1];
}else{
	echo "please give input text file name";
}

//CONNECT MYSQL
$objMailerMatchWatch->dbConnect('S',$varDbInfo['DATABASE']);

// Counter Log file
$varSendFilename= '/home/product/community/ability/remindermailer/expintpending/'.date('dmY').'_'.$varContentFile.'_'.date('H:i:s').'_MailSent.txt';

$varFileName		= file($varFileName);
$i = 1;
foreach($varFileName as $varFileInfo) {
	$varMatriId			= '';
	$varToEmailAddress	= '';
	$varLastLogin		= '';
	$varPendingCnt		= '';
	$varOppMatriId		= '';
	$varInterestOption	= '';
	$varDateReceived	= '';
	$varMessage			= '';
	$varFrom			= '';
	$emailfrom			= '';
	$replyto			= '';
	$varTo				= '';
	$varDomaiId			= '';
	$varDomainDetails	= array();
	$varDomainFolder	= array();

	$varFileArray		= split('~', $varFileInfo);
	$varSerialNo		= trim($varFileArray[0]);
	$varMatriId			= trim($varFileArray[1]);
	$varToEmailAddress	= trim($varFileArray[2]);
	$varLastLogin		= trim($varFileArray[3]);
	$varPendingCnt		= trim($varFileArray[4]);
	$varOppMatriId		= trim($varFileArray[5]);
	$varDomaiId			= trim($varFileArray[6]);
	$varName			= trim($varFileArray[7]);
	$varPaidstatus		= trim($varFileArray[8]);
	$varMsgId			= trim($varFileArray[9]);
	$varTo				= $varMatriId;

	//GET DOMAIN DETAILS
	$varDomainDetails	= $objMailManager->getDomainDetails($varMatriId);
	$varDomainFolder	= $objMailManager->getFolderName($varMatriId);

	$varDomaiPrefix		= trim($arrMatriIdPre[$varDomaiId]);
	$varDomainName		= trim($arrPrefixDomainList[$varDomaiPrefix]);
	$varShortName		= ucwords(str_replace("matrimony.com","",$varDomainName));

	if ($varDomainName !='') {
		include('expint_pending_tpl.php');
		$varMessage		= stripslashes($varTemplate);

		$varLogoPath	= $varDomainDetails['IMGURL'].'/logo/'.$arrFolderNames[$varDomaiPrefix];
		$varServerUrl	= $varDomainDetails['SERVERURL'];
		$varMailerImgPath= $varDomainDetails['MAILERIMGURL'];
		$varImgServerPath= $varDomainDetails['IMGSERVERURL'];
		$varProductName	= $varShortName.'Matrimony';
		$varReplyLink	= $varServerUrl.'/login/index.php?'.$varTrackDtls.'&redirect='.$varServerUrl.'/mymessages/?part=RIALL';
		$unsubscibeLink	= $varServerUrl."/login/index.php?redirect=".$varServerUrl."/profiledetail/index.php?act=mailsetting";
		$varPendingDtl	= '';
		
		//get community wise details
		$objMailerMatchWatch->getCommunityWiseDtls($varDomaiPrefix);
		$varProfileBasicResultSet = $objMailerMatchWatch->selectDetails(array(0=>"'".$varOppMatriId."'"));
		$varProfileBasicView= $objMailerMatchWatch->getMatchWatchRegularDetails($argPurpose,$varProfileBasicResultSet,$varPaidstatus,$varMailerType,$varTrackDtls,$varMsgId);

		$varMessage		= str_replace('<--LOGO-->',$varLogoPath,$varMessage);
		$varMessage		= str_replace('<--SESSMATRIID-->',$varMatriId,$varMessage);
		$varMessage		= str_replace('<--SESSNAME-->',$varName,$varMessage);
		$varMessage		= str_replace('<--TRACK_DETAIL-->',$varTrackDtls,$varMessage);
		$varMessage		= str_replace('<--PENDING_CNT-->',$varPendingCnt,$varMessage);
		$varMessage		= str_replace('<--REPLY-->',$varReplyLink,$varMessage);
		$varMessage		= str_replace('<--BASIC-PROFILE-->',$varProfileBasicView,$varMessage);
		$varMessage		= str_replace('<--MAILERIMGSPATH-->',$varMailerImgPath,$varMessage);
		$varMessage		= str_replace('<--PRODUCT_NAME-->',$varProductName,$varMessage);
		$varMessage		= str_replace('<--UNSUBSCRIBE_LINK-->',$unsubscibeLink,$varMessage);
		$varMessage		= str_replace('<--SERVERURL-->',$varServerUrl,$varMessage);

		$varFrom		= $varShortName.'Matrimony.Com';
		$emailfrom		= strtolower('info@'.$varShortName.'matrimony.com');
		$replyto		= strtolower('noreply@'.$varShortName.'matrimony.com');

		if(sendFreeToPaidEmail($varFrom,$emailfrom,$varTo,$varToEmailAddress,$varSubject,$varMessage,$replyto)){
			$varTrackDetails	= $i.'~'.$varSerialNo.'~'.$varToEmailAddress;
			$varSendHandler		= fopen($varSendFilename,"w+");
			fwrite($varSendHandler,$varTrackDetails);
			fclose($varSendHandler);
			$i++;
		}
	}
}

//CONNECT MYSQL
$objMailerMatchWatch->dbClose();

//CONNECT MYSQL
$mysql_connection	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

//Update into cbsmailer report table
$varInsertQuery	= "INSERT INTO cbsmailer_report (MailerType,Count,SentOn) VALUES ('".$varContentFile."',".$i.",'".$varCurrentDateTime."')";
$varInsertId	= mysql_query($varInsertQuery) or die('insert_error');


$varFrom			= 'CommunityMatrimony';
$varFromEmail		= 'CommunityMatrimony.Com';
$emailfrom			= 'info@communitymatrimony.com';
$replyto			= 'noreply@communitymatrimony.com';
$varSubject			= $varContentFile.' Completed';
$varMessage			= 'Total Count ='.$i;
//$varToEmailAddress	= 'ashokkumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com, jeyakumar@bharatmatrimony.com';
$varToEmailAddress	= 'greennjk@gmail.com';

if(sendFreeToPaidEmail($varFrom,$emailfrom,$varTo,$varToEmailAddress,$varSubject,$varMessage,$replyto)){
			echo "Express Interest Pending mails sent successfully";
		}

mysql_close($mysql_connection) or die('error');
?>