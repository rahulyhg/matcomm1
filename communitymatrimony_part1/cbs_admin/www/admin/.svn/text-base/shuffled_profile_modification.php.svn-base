<?php
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsAdminValMailer.php');

$objAdminMailer		= new AdminValid;
$objMaster			= new DB;

//DB CONNECTION
$objAdminMailer->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

$cookValue		= split('&', $_COOKIE['adminLoginInfo']);

$varTableName	= 'profilemodificationpending';
$varWhereCond	= 'WHERE Validation_Status=2';
$varNumOfRows	= $objAdminMailer->numOfRecords($varTableName, 'MatriId', $varWhereCond);

if($varNumOfRows<100){
	//Populate Records in  profilemodificationpending table
	$varDateCond = date( "Y-m-d H:i:s", mktime(date("H"), date("i")-15, date("s"),date("m"),date("d"),date("Y")));
	$varQuery	 = "INSERT IGNORE INTO profilemodificationpending SELECT MatriId,2,Date_Updated FROM ".$varTable['MEMBERINFO']." WHERE Pending_Modify_Validation =1 AND Date_Updated<='".$varDateCond."'";
	$objMaster->ExecuteQryResult($varQuery,0);

	$varWhereCond	= 'WHERE Validation_Status=3';
	$varNumOfRows	= $objAdminMailer->numOfRecords($varTableName, 'MatriId', $varWhereCond);
	
	if($varNumOfRows > 0){
		$varWhereCond	= 'Validation_Status=3 ORDER BY Date_Updated ASC';
		$objMaster->delete($varTableName, $varWhereCond);
	}
}


	//get first matriid from queue table
	$arrMatriIddet		= array();
	$argFields 			= array('MatriId');
	$argCondition		= "WHERE Validation_Status=2 ORDER BY Date_Updated DESC LIMIT 0,1";
	$varAvailableRes	= $objAdminMailer->select($varTableName,$argFields,$argCondition,0);	
	$varAvailableId	    = mysql_num_rows($varAvailableRes);

	if($varAvailableId>0) {
		$arrMatriIddet	 = mysql_fetch_assoc($varAvailableRes);	
		//update profilemodificationpending
		$argFields 		 = array('Validation_Status','Date_Updated');
		$argFieldsValues = array(3,"NOW()");
		$argCondition	 = " MatriId=".$objMaster->doEscapeString($arrMatriIddet['MatriId'],$objMaster);
		$varUpdateId	 = $objMaster->update($varTableName,$argFields,$argFieldsValues,$argCondition);
  
		//inert into support validation report table
		$argFields			= array('matriid','userid','downloadeddate','reporttype');
		$argFieldsValues	= array($objMaster->doEscapeString($arrMatriIddet['MatriId'],$objMaster),$objMaster->doEscapeString($cookValue[1],$objMaster),"NOW()",6);
		$varSupportInsertId	= $objMaster->insert($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues);
	} 
	if($varSupportInsertId>0 && sizeof($arrMatriIddet)>0) {
		$varMatriId	= $arrMatriIddet['MatriId'];
		$varUserid	= $varSupportInsertId;
		
	} 


 //$arrReportDetail		= getValidateMatriIdFromQ($objMaster,$objAdminMailer,$adminUserName);

echo '<script language="javascript">document.location.href =
"index.php?act=profile_modification&page=shuffled&tvprofile=yes&MatriId='.$varMatriId.'&reportid='.$varUserid.'"; </script>';
?>