<?php
#=============================================================================================================
# Author 		: Ashok kumar
# Date	        : 16-Feb-2010
# Project		: Community Matrimony Product - Admin Support Interface
# Filename		: adminviewlog.php
# Description   : When admin user view the profile's this file will log the same as archive in db.
#=============================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/lib/clsDB.php');

$varTable['ADMINVIEWLOG'] = 'adminviewlog';

if (!isset($varPhotoView)) {
	$varPhotoView = 0;
}
if (!isset($varHoroscopeView)) {
	$varHoroscopeView = 0;
}

if ($adminUserName!='' && $varMatriId!='') {
	//DB CONNECTION
	$objDBMaster = new DB;
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varInsPhotoView = '00-00-00 00:00:00';
	if ($varPhotoView == 1) {
		$varInsPhotoView = date('Y-m-d H:i:s');
	}

	$varInsHoroView = '00-00-00 00:00:00';
	if ($varHoroscopeView == 1) {
		$varInsHoroView = date('Y-m-d H:i:s');
	}

	// Inserting the log of viewed by admin user
	//$varFields = array('User_Name','MatriId','Date_Viewed');
	//$varFieldsValues = array("'".$adminUserName."'","'".$varMatriId."'","NOW()");
	$varFields = array('User_Name','MatriId','Date_Viewed','Date_Photo_Viewed','Date_Horoscope_Viewed');
	$varFieldsValues = array($objDBMaster->doEscapeString($adminUserName,$objDBMaster),$objDBMaster->doEscapeString($varMatriId,$objDBMaster),"NOW()",$objDBMaster->doEscapeString($varInsPhotoView,$objDBMaster),$objDBMaster->doEscapeString($varInsHoroView,$objDBMaster));	
	$varPartlyId = $objDBMaster->insert($varTable['ADMINVIEWLOG'],$varFields,$varFieldsValues);

	if ($varPhotoView != 1 && $varHoroscopeView != 1) {
	//UPDATE View counter log for the admin user
	$varCondition	= " User_Name =".$objDBMaster->doEscapeString($adminUserName,$objDBMaster)." AND View_Counter>0 ";
	$varFields		= array('View_Counter');
	$varFieldsValue	= array('View_Counter-1');
	$objDBMaster->update($varTable['ADMINLOGININFO'], $varFields, $varFieldsValue, $varCondition);
	}

	$objDBMaster->dbClose();
}

?>