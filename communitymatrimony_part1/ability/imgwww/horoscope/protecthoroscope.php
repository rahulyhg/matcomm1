<?
#================================================================================================================
# Author 	: Dhanapal
# Date		: 27-Jan-2010
# Project	: MatrimonyProduct
# Filename	: protecthoroscope.php
#================================================================================================================
//FILE INCLUDES

$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLE
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

$objMasterDB	= new MemcacheDB;
$objSlaveDB		= new MemcacheDB;

//CONNECTION DECLARATION
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE DECLARATIONS
$varProtectPassword = trim($_REQUEST["password"]);

if ($_POST["Submit"]=='yes' && $sessMatriId!='') {

	$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
	$varFields		= array('Password');
	$varLoginInfo	= $objSlaveDB->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,1);
	$varPassword	=  trim($varLoginInfo[0]['Password']);

	$varFields		= array('Horoscope_Protected_Password');
	$varHoroscopeInfo	= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition);
	$varHoroscopePassword=  trim($varHoroscopeInfo[0]['Horoscope_Protected_Password']);


	if ($varPassword===$varProtectPassword) {

		$varMessage = 'Your Horoscope-Password can\'t be same as your Profile Password. Please choose a different Horoscope-Password.';

	} else 	if ($varHoroscopePassword===$varProtectPassword) {

		$varMessage = 'Your Horoscope-Password can\'t be same as your Photo Password. Please choose a different Horoscope-Password.';

	} else {

		$varMessage		= 'Your horoscope protect password has been updated successfully.';
		$varCondition	= " MatriId= ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varFields		= array('Horoscope_Protected','Horoscope_Protected_Password');
		$varFiledvalues	= array('1', $objMasterDB->doEscapeString($varProtectPassword,$objMasterDB));
		$objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledvalues, $varCondition);

		//UPDATE MEMBERINFO	
		$varFields		= array('Horoscope_Protected');
		$varFiledvalues	= array('1');
		$objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFiledvalues,$varCondition,$varOwnProfileMCKey);

}

}//if

#========================================== UN PROTECT HOROSCOPE

if ($_POST["Submit"]=='protect' && $sessMatriId!='') {

	$varMessage		= 'Your horoscope protect password has been unprotect successfully.';
	$varCondition	= " MatriId= ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFields		= array('Horoscope_Protected','Horoscope_Protected_Password');
	$varFiledvalues	= array('0','\'\'');
	$objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledvalues, $varCondition);

	//UPDATE MEMBERINFO	
	$varFields		= array('Horoscope_Protected');
	$varFiledvalues	= array('0');
	$objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFiledvalues,$varCondition,$varOwnProfileMCKey);

}
	echo $varMessage;

//CONNECTION DECLARATION
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
UNSET($objSlaveDB);
UNSET($objMasterDB);


?>