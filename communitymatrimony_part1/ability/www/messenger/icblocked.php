<?php
#================================================================================================================
# Author 		: S Rohini
# Start Date	: 27-Sep-2008
# End Date	: 27-Sep-2008
# Project		: MatrimonyProduct
# Module		: Messenger - Blocked Frnd
#================================================================================================================
$varRootBasePath	 = dirname($_SERVER['DOCUMENT_ROOT']);
//File Includes

include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
//Session Variable
$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varUserName		= $varGetCookieInfo['NAME'];
$sessGender			= $varGetCookieInfo['GENDER'];
$varCommunityId		= $confValues["DOMAINCASTEID"];
$varGender			= ($sessGender=='1') ? 'M' : 'F';

//VARIABLE DECLARATION
$varCurrentDate	= date('Y-m-d H:i:s');
$BID			= $_REQUEST['BID'];

//OBJECT DECLARATION
$objDb				= new DB;
$objDb1				= clone $objDb;

//DATABASE CONNECTION
$objDb->dbConnect('S', $varDbInfo['DATABASE']);
$objDb1->dbConnect('M', $varDbInfo['DATABASE']);

//Friend Info
//$varFrndFields		= array('MatriId','Gender');
//$varFrndCond		= "  WHERE User_Name ='".$BID."'";
//$varFrndInfo		= $objDb->select($varTable['MEMBERINFO'],$varFrndFields,$varFrndCond,1);
//$varFrndExists		= count($varFrndInfo);


$varBudExsCond	= " WHERE MatriId='".$sessMatriId."' AND BlockedId='".$BID."'";
$varBudExist			= $objDb->numOfRecords($varTable['ICBLOCKED'],'BlockedId',$varBudExsCond);
if($varBudExist>0){echo "&RESULT=201";}
else{
	$varInsBudFld		= array('MatriId','BlockedId','CommunityId','CasteId','TimeBlocked');
	$varInsBudFldVal	= array("'".$sessMatriId."'", "'".$BID."'","'".$varCommunityId."'","'".$varCommunityId."'","'".$varCurrentDate."'");
	$varInsBuddy		= $objDb1->insert($varTable['ICBLOCKED'],$varInsBudFld,$varInsBudFldVal);
}


//Openfire calling
$POSTURL= "http://messenger.communitymatrimony.com/plugins/multipledomainmessenger/mdinterface?";
$POSTVARS="type=block&domainname=".$varCommunityId."&from=".$sessMatriId."&buddyid=".$BID."&gender=".$varGender;


$ch="";
$ch = curl_init($POSTURL);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTVARS);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
$curl_block = curl_exec($ch);
// open fire ended print result

$objDb->dbClose();
$objDb1->dbClose();

?>
