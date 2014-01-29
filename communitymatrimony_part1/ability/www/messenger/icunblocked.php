<?php
#================================================================================================================
# Author 		: S Rohini
# Start Date	: 27-Sep-2008
# End Date	: 27-Sep-2008
# Project		: MatrimonyProduct
# Module		: Messenger - UnBlock Friend
#================================================================================================================
$varRootBasePath	 = dirname($_SERVER['DOCUMENT_ROOT']);
//File Includes
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");


//Session Variable
$sessMatriId			= $varGetCookieInfo['MATRIID'];
$varUserName		= $varGetCookieInfo['NAME'];
$sessGender			= $varGetCookieInfo['GENDER'];
$varCommunityId		= $confValues["DOMAINCASTEID"];
$varGender			= ($sessGender=='1') ? 'M' : 'F';

//Variable Declaration
$varCurrentDate		= date('Y-m-d H:i:s');
$BID				= $_REQUEST['BID'];
//Object Declaration
$objDb				= new DB;
$objDb1				= clone $objDb;
//Database Connection
$objDb->dbConnect('S', $varDbInfo['DATABASE']);
$objDb1->dbConnect('M', $varDbInfo['DATABASE']);


$varBudExsCond	= " WHERE MatriId='".$sessMatriId."' AND BlockedId='".$BID."'";
$varBudExist	= $objDb->numOfRecords($varTable['ICBLOCKED'],'BlockedId',$varBudExsCond);
if($varBudExist==0){echo "&RESULT=110";}
else{
	$varDelCond		= " MatriId='".$sessMatriId."' AND BlockedId='".$BID."'";
	$varDelBuddy	= $objDb1->delete($varTable['ICBLOCKED'],$varDelCond);

}

// OPEN FIRE CALLING STARTS HERE

$POSTURL= "http://messenger.communitymatrimony.com/plugins/multipledomainmessenger/mdinterface?";
$POSTVARS="type=unblock&domainname=".$varCommunityId."&from=".$sessMatriId."&buddyid=".$BID."&gender=".$varGender;

$ch="";
$ch = curl_init($POSTURL);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTVARS);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
$unblock = curl_exec($ch);
// Open fire calling ends here

$objDb->dbClose();
$objDb1->dbClose();
?>