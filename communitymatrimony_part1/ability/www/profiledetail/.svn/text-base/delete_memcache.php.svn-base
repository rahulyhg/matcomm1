<?
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$vaStartTime = microtime(true);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
//include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessGender 	= $varGetCookieInfo["GENDER"];

//OBJECT DECLARTION
//$objDBSlave	= new DB;
$objDBSlave	= new MemcacheDB;
$objDomain	= new domainInfo;


$key = $_REQUEST['key'];


if(Cache::deleteData($key)) {
	echo "deleted key=".$key;
} else {
	echo "not deleted key=".$key;
}
?>