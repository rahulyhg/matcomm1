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


function getValidateMatriIdFromQ($objMasDB,$objSlave,$argAdminUserName) {
	global $varTable;
	$arrReportDet = array();

	//insert into support_validationq table
	//check paid profile avaialble or not
	$varDateTime			= date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')-1,date('Y')));
	$argCondition			= "WHERE Publish=1 AND Paid_Status=1 AND Date_Created>='".$varDateTime."' AND Support_Comments = ''";
	$varPaidCont			= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);

	//first getting paid profile
	if($varPaidCont>0) {
		$varQuery	= "INSERT IGNORE INTO ".$varTable['SUPPORT_VALIDATIONQ']." (MatriId,Paid_Status,Date_Created) SELECT MatriId,Paid_Status,Date_Created FROM  ".$varTable['MEMBERINFO']." WHERE Publish=1 AND Paid_Status=1 AND Date_Created>='".$varDateTime."' AND Support_Comments = ''";
		$objMasDB->ExecuteQryResult($varQuery);
	}

	//delete validated profile
	$varDateTime			= date('Y-m-d H:i:s',mktime(date('H'),date('i')-30,date('s'),date('m'),date('d'),date('Y')));
	$argCondition			= " Validation_Status=1 AND Date_Added<='".$varDateTime."'";
	$objMasDB->delete($varTable['SUPPORT_VALIDATIONQ'],$argCondition);

	//check this matriid is available or not in supportvalidationq table
	$argCondition		= " WHERE Validation_Status=0";
	$varAvailableId		= $objMasDB->numOfRecords($varTable['SUPPORT_VALIDATIONQ'],'MatriId',$argCondition);

	if($varAvailableId<100) {

		//get 100 profiles which are pending in memberinfo table (publish=0)
		 $varDateTime			= date('Y-m-d H:i:s',mktime(date('H'),date('i')-15,date('s'),date('m'),date('d'),date('Y')));
		$argCondition			= "WHERE Publish=0 AND Date_Created<='".$varDateTime."' ORDER BY Date_Created";
		$varFreeCont			= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);
		if($varFreeCont>0) {
			$varQuery	= "INSERT IGNORE INTO ".$varTable['SUPPORT_VALIDATIONQ']." (MatriId,Paid_Status,Date_Created) SELECT MatriId,Paid_Status,Date_Created FROM  ".$varTable['MEMBERINFO']." WHERE Publish=0 AND Date_Created<='".$varDateTime."' ORDER BY Date_Created";
			$objMasDB->ExecuteQryResult($varQuery);
		}
	}


	//get first matriid from supportvalidationq table
	$arrMatriIddet		= array();
	$argFields 			= array('MatriId');
	$argCondition		= " WHERE Validation_Status=0 AND Paid_Status=1 ORDER BY Date_Created LIMIT 0,1";
	$varPaidAvailableRes= $objMasDB->select($varTable['SUPPORT_VALIDATIONQ'],$argFields,$argCondition,0);
	$varPaidAvailableId	= mysql_num_rows($varPaidAvailableRes);

	if($varPaidAvailableId>0) {
		$arrMatriIddet		= mysql_fetch_assoc($varPaidAvailableRes);

		//update support_validationq
		$argFields 		= array('Validation_Status','Date_Added');
		$argFieldsValues= array(1,"NOW()");
		$argCondition	= " MatriId='".$arrMatriIddet['MatriId']."'";
		$varUpdateId	= $objMasDB->update($varTable['SUPPORT_VALIDATIONQ'],$argFields,$argFieldsValues,$argCondition);

		//inert into support validation report table
		$argFields			= array('matriid','userid','downloadeddate','reporttype');
		$argFieldsValues	= array("'".$arrMatriIddet['MatriId']."'","'".$argAdminUserName."'","NOW()",1);
		$varSupportInsertId	= $objMasDB->insert($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues);
	} else {
		//get first matriid from supportvalidationq table
		$argFields 			= array('MatriId');
		$argCondition		= " WHERE Validation_Status=0 ORDER BY Date_Created LIMIT 0,1";
		$varFreeAvailableRes= $objMasDB->select($varTable['SUPPORT_VALIDATIONQ'],$argFields,$argCondition,0);
		$varFreeAvailableId	= mysql_num_rows($varFreeAvailableRes);

		if($varFreeAvailableId>0) {
			$arrMatriIddet		= mysql_fetch_assoc($varFreeAvailableRes);

			//update support_validationq
			$argFields 		= array('Validation_Status','Date_Added');
			$argFieldsValues= array(1,"NOW()");
			$argCondition	= " MatriId='".$arrMatriIddet['MatriId']."'";
			$varUpdateId	= $objMasDB->update($varTable['SUPPORT_VALIDATIONQ'],$argFields,$argFieldsValues,$argCondition);

			//inert into support validation report table
			$argFields			= array('matriid','userid','downloadeddate','reporttype');
			$argFieldsValues	= array("'".$arrMatriIddet['MatriId']."'","'".$argAdminUserName."'","NOW()",1);
			$varSupportInsertId	= $objMasDB->insert($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues);
		}
	}

	if($varSupportInsertId>0 && sizeof($arrMatriIddet)>0) {
		$arrReportDet[]	= $arrMatriIddet['MatriId'];
		$arrReportDet[]	= $varSupportInsertId;

		return $arrReportDet;
	} else {
		return $arrReportDet;
	}
}

 $arrReportDetail		= getValidateMatriIdFromQ($objMaster,$objAdminMailer,$adminUserName);

echo '<script language="javascript">document.location.href =
"index.php?act=profile_validation&page=shuffled&tvprofile=yes&MatriId='.$arrReportDetail[0].'&reportid='.$arrReportDetail[1].'"; </script>';
?>