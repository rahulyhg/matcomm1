<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-08-08
# End Date		: 2008-08-08
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//PATH INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsRegister.php");

//OBJECT DECLARTION
$objRegister	= new clsRegister;
$objRegister->dbConnect('M',$varDbInfo['DATABASE']);

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];

$varEmail		= $_REQUEST['varemail'];
$varSelectedDomain	= $_REQUEST['varSelectedDomain'];
$varGender		= $_REQUEST['vargender'];

if(($varSelectedDomain != "0") && ($varSelectedDomain != 'undefined')) {
  $varDomainPrefix = array_search($varSelectedDomain,$arrPrefixDomainList);
  $varCommunityId = array_search($varDomainPrefix,$arrMatriIdPre);
}
if($confValues['DOMAINCASTEID'] == 0) {
  $varWhereClause = "CommunityId=".$varCommunityId;
}

$varNoOfTimeOccurs	= 0;
$varBlockedEmail	= 'no';

//CHECK ALREADY REGISTERED PROFILES WITH EMAIL AND GENDER (ALLOW 2 TIMES)
//$varBlockedEmail	= $objRegister->blockedEmail($varEmail,$confValues['GETBLOCKEDEMAILSDIR']);

if ($varBlockedEmail=='no')
{
	$argTblName			= $varTable['MEMBERLOGININFO'].' mli,'. $varTable['MEMBERINFO'] .' mi';
	$argCondition		= " WHERE mli.".$varWhereClause." AND mli.Email=".$objRegister->doEscapeString($varEmail,$objRegister)." AND mli.MatriId = mi.MatriId ";
	if ($sessMatriId !='') { $argCondition .= " AND mi.MatriId!=".$objRegister->doEscapeString($sessMatriId,$objRegister); }
	$varNoOfTimeOccurs	= $objRegister->numOfRecords($argTblName, $argPrimary='mli.MatriId', $argCondition);

}//if

if($varBlockedEmail == 'yes')
{
	echo $varBlockedEmail.'^'.$varEmail;
}
else if($varNoOfTimeOccurs > 0)
{
	echo $varNoOfTimeOccurs.'^'.$varEmail;
}
else
{}
?>
