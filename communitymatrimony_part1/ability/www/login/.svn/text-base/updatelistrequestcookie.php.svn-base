<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 19 Jan 2010
# Project	  : Community Matrimony Product
# Filename	  : updatelistrequestcookie.php
#=====================================================================================================================================
# Description : reset list and requested related cookie value
#=====================================================================================================================================

function setRequestReceivedCookie($varMatriId,$objName) {
	global $varTable,$confValues;
	$varDomainName	= $confValues["DOMAINNAME"];

	//SELECT RECV REQUEST COUNT
	$varFields		= array('RequestFor', 'COUNT(ReceiverId) AS CNT');
	$argCondition	= " WHERE ReceiverId=".$objName->doEscapeString($varMatriId,$objName)." AND Delete_Status=0 GROUP BY RequestFor";
	$varReqRecvRes	= $objName->select($varTable['REQUESTINFORECEIVED'], $varFields, $argCondition, 0);

	$varPhotoCnt=0; $varPhoneNoCnt=0; $varRefCnt=0; $varVoiceCnt=0; $varHoroCnt=0;
	while($varRow = mysql_fetch_assoc($varReqRecvRes))
	{
		switch($varRow['RequestFor'])
		{
			case 1: $varPhotoCnt	= $varRow['CNT'];break;
			//case 2: $varRefCnt		= $varRow['CNT'];break;
			case 3: $varPhoneNoCnt	= $varRow['CNT'];break;
			//case 4: $varVoiceCnt	= $varRow['CNT'];break;
			case 5: $varHoroCnt		= $varRow['CNT'];break;
		}
	}

	$varRequestReceivedValue	= $varPhotoCnt.'^|'.$varPhoneNoCnt.'^|'.$varHoroCnt;
	setrawcookie("requestReceivedInfo",$varRequestReceivedValue, "0", "/",$varDomainName);
}

function setRequestSentCookie($varMatriId,$objName) {
	global $varTable,$confValues;
	$varDomainName	= $confValues["DOMAINNAME"];

	//SELECT SENT REQUEST COUNT
	$varFields		= array('RequestFor', 'COUNT(SenderId) AS CNT');
	$argCondition	= " WHERE SenderId=".$objName->doEscapeString($varMatriId,$objName)." AND Delete_Status=0 GROUP BY RequestFor";
	$varReqSentRes	= $objName->select($varTable['REQUESTINFOSENT'], $varFields, $argCondition, 0);

	$varPhotoCnt=0; $varPhoneNoCnt=0; $varRefCnt=0; $varVoiceCnt=0; $varHoroCnt=0;
	while($varRow = mysql_fetch_assoc($varReqSentRes))
	{
		switch($varRow['RequestFor'])
		{
			case 1: $varPhotoCnt	= $varRow['CNT'];break;
			//case 2: $varRefCnt		= $varRow['CNT'];break;
			case 3: $varPhoneNoCnt	= $varRow['CNT'];break;
			//case 4: $varVoiceCnt	= $varRow['CNT'];break;
			case 5: $varHoroCnt		= $varRow['CNT'];break;
		}
	}

	$varRequestSentValue	= $varPhotoCnt.'^|'.$varPhoneNoCnt.'^|'.$varHoroCnt;
	setrawcookie("requestSentInfo",$varRequestSentValue, "0", "/",$varDomainName);
}

/*function setRequestReceivedCookie($varMatriId,$objName) {
	global $varTable,$varDbInfo,$confValues;
	$varDomainName	= $confValues["DOMAINNAME"];

	//SELECT PHOTO REQUEST COUNT
	$argCondition	= " WHERE ReceiverId='".$varMatriId."' AND RequestFor=1 AND Delete_Status=0";
	$varPhotoCnt	= $objName->numOfRecords($varTable['REQUESTINFORECEIVED'], 'ReceiverId', $argCondition);

	//SELECT PHONENO REQUEST COUNT
	$argCondition	= " WHERE ReceiverId='".$varMatriId."' AND RequestFor=3 AND Delete_Status=0";
	$varPhoneNoCnt	= $objName->numOfRecords($varTable['REQUESTINFORECEIVED'], 'ReceiverId', $argCondition);

	//SELECT HOROSCOPE REQUEST COUNT
	$argCondition	= " WHERE ReceiverId='".$varMatriId."' AND RequestFor=5 AND Delete_Status=0";
	$varHoroCnt		= $objName->numOfRecords($varTable['REQUESTINFORECEIVED'], 'ReceiverId', $argCondition);

	//SELECT VOICE REQUEST COUNT
	//$argCondition	= " WHERE ReceiverId='".$varMatriId."' AND RequestFor=4 AND Delete_Status=0";
	//$varVoiceCnt	= $objName->numOfRecords($varTable['REQUESTINFORECEIVED'], 'ReceiverId', $argCondition);

	$varRequestReceivedValue	= $varPhotoCnt.'^|'.$varPhoneNoCnt.'^|'.$varHoroCnt;
	setrawcookie("requestReceivedInfo",$varRequestReceivedValue, "0", "/",$varDomainName);
}

function setRequestSentCookie($varMatriId,$objName) {
	global $varTable,$varDbInfo,$confValues;

	$varDomainName	= $confValues["DOMAINNAME"];

	//SELECT PHOTO REQUEST COUNT
	$argCondition	= " WHERE SenderId='".$varMatriId."' AND RequestFor=1 AND Delete_Status=0";
	$varPhotoCnt	= $objName->numOfRecords($varTable['REQUESTINFOSENT'], 'SenderId', $argCondition);

	//SELECT PHONENO REQUEST COUNT
	$argCondition	= " WHERE SenderId='".$varMatriId."' AND RequestFor=3 AND Delete_Status=0";
	$varPhoneNoCnt	= $objName->numOfRecords($varTable['REQUESTINFOSENT'], 'SenderId', $argCondition);

	//SELECT REFERENCE REQUEST COUNT
	$argCondition	= " WHERE SenderId='".$varMatriId."' AND RequestFor=5 AND Delete_Status=0";
	$varHoroCnt		= $objName->numOfRecords($varTable['REQUESTINFOSENT'], 'SenderId', $argCondition);

	//SELECT VOICE REQUEST COUNT
	//$argCondition	= " WHERE SenderId='".$varMatriId."' AND RequestFor=4 AND Delete_Status=0";
	//$varVoiceCnt	= $objName->numOfRecords($varTable['REQUESTINFOSENT'], 'SenderId', $argCondition);

	$varRequestSentValue	= $varPhotoCnt.'^|'.$varPhoneNoCnt.'^|'.$varHoroCnt;
	setrawcookie("requestSentInfo",$varRequestSentValue, "0", "/",$varDomainName);
}

function setListInfoCookie($varMatriId,$objName) {
	global $varTable,$varDbInfo,$confValues; //listInfo

	$varDomainName	= $confValues["DOMAINNAME"];
	$argCondition	= " WHERE MatriId='".$varMatriId."'";

	//SELECT SHORTLIST COUNT
	$varBookMarkCnt	= $objName->numOfRecords($varTable['BOOKMARKINFO'], 'MatriId', $argCondition);

	//SELECT IGNORE COUNT
	$varIgnoreCnt	= $objName->numOfRecords($varTable['IGNOREINFO'], 'MatriId', $argCondition);

	//SELECT BLOCK COUNT
	$varBlockCnt	= $objName->numOfRecords($varTable['BLOCKINFO'], 'MatriId', $argCondition);

	$varListValue	= $varBookMarkCnt.'^|'.$varIgnoreCnt.'^|'.$varBlockCnt;
	setrawcookie("listInfo",$varListValue, "0", "/",$varDomainName);
}

function setViewsInfoCookie($varMatriId,$objName) {
	global $varTable,$varDbInfo,$confValues; //viewsInfo

	$varDomainName	= $confValues["DOMAINNAME"];

	//GET PHONE NUMBER VIEWED BY ME
	$argCondition		= "WHERE Opposite_MatriId='".$varMatriId."'";
	$varPhoneByMeCnt	= $objName->numOfRecords($varTable['PHONEVIEWLIST'], 'Opposite_MatriId', $argCondition);

	//GET PHONE NUMBER VIEWED BY OTHER
	$argCondition		= "WHERE MatriId='".$varMatriId."'";
	$varPhoneByOtherCnt	= $objName->numOfRecords($varTable['PHONEVIEWLIST'], 'MatriId', $argCondition);


	//GET PROFILE VIEWED COUNT
	$argCondition		= "WHERE MatriId='".$varMatriId."'";
	$varFields			= array('Profile_Viewed');
	$varProfileInfoRes	= $objName->select($varTable['MEMBERINFO'], $varFields, $argCondition, 0);
	$varProfileInfo		= mysql_fetch_assoc($varProfileInfoRes);
	$varProfileViewedCnt= $varProfileInfo['Profile_Viewed'];

	$varViewsValue	= $varPhoneByMeCnt.'^|'.$varPhoneByOtherCnt.'^|'.$varProfileViewedCnt;
	setrawcookie("viewsInfo",$varViewsValue, "0", "/",$varDomainName);
} */

?>