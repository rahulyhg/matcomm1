<?php
$varRootPath = $_SERVER['DOCUMENT_ROOT'];
$varBasePath = dirname($varRootPath);

include_once($varBasePath.'/www/admin1/includes/userLoginCheck.php');
include_once($varBasePath.'/conf/config.cil14');
include_once($varBasePath.'/conf/domainlist.cil14');
include_once($varBasePath.'/conf/dbinfo.cil14');
include_once($varBasePath.'/lib/clsDB.php');

$cookValue	= split('&', $_COOKIE['adminLoginInfo']);

if($cookValue[1]==''){
	$varCont = '<div class="errortxt">Session is not available, Kindly login again.</div>';
}else{
$objMasterDB	= new DB;

$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varTableName	= 'photovalidationpending';

$varWhereCond	= 'WHERE Validation_Status=0';
$varNumOfRows	= $objMasterDB->numOfRecords($varTableName, 'MatriId', $varWhereCond);

if($varNumOfRows<50){
	//Populate Records in  photovalidationpending table
	$varDateCond= date( "Y-m-d H:i:s", mktime(date("H"), date("i")-15, date("s"),date("m"),date("d"),date("Y")));
	$varQuery	= "INSERT IGNORE INTO photovalidationpending (SELECT MatriId,0,Photo_Date_Updated FROM ".$varTable['MEMBERPHOTOINFO']." WHERE Photo_Date_Updated>='2010-08-01 00:00:00' AND Photo_Date_Updated<='".$varDateCond."' AND ((Normal_Photo1!='' AND Photo_Status1=0) OR (Normal_Photo2!='' AND Photo_Status2=0) OR (Normal_Photo3!='' AND Photo_Status3=0) OR (Normal_Photo4!='' AND Photo_Status4=0) OR (Normal_Photo5!='' AND Photo_Status5=0) OR (Normal_Photo6!='' AND Photo_Status6=0) OR (Normal_Photo7!='' AND Photo_Status7=0) OR (Normal_Photo8!='' AND Photo_Status8=0) OR (Normal_Photo9!='' AND Photo_Status9=0) OR (Normal_Photo10!='' AND Photo_Status10=0)))";
	$objMasterDB->ExecuteQryResult($varQuery,0);

	$varWhereCond	= 'WHERE Validation_Status=1';
	$varNumOfRows	= $objMasterDB->numOfRecords($varTableName, 'MatriId', $varWhereCond);
	if($varNumOfRows > 300){
		$varNumOfRows	= $varNumOfRows-100;
		$varWhereCond	= 'Validation_Status=1 ORDER BY Date_Updated ASC LIMIT '.$varNumOfRows;
		$objMasterDB->delete($varTableName, $varWhereCond);
	}
}

$arrFields		= array('MatriId', 'Date_Updated');
$varWhereCond	= 'WHERE Validation_Status=0 ORDER BY Date_Updated ASC LIMIT 1';
$varResultSet	= $objMasterDB->select($varTableName, $arrFields, $varWhereCond, 0);
$varPInfoDet	= mysql_fetch_assoc($varResultSet);
$varMatriId		= $varPInfoDet['MatriId'];

header("Location:".$confValues['IMAGEURL'].'/admin1/photovalidation/newphotovalidation.php?shuffid='.$varMatriId.'');exit;
}
?>