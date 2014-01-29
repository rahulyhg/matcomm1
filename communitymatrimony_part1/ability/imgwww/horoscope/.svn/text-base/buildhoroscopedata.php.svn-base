<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: generateHoroscope.php
#================================================================================================================

if (isset($_REQUEST['generateHoroscopeSubmit'])) {

	$varTimeCorrection = $_POST['M_TIMECORRECTION'];//To be Checked
	$varProcess		= 'yes';
	$varMonth		= trim($_REQUEST['month']);
	$varDate		= trim($_REQUEST['date']);
	$varYear		= trim($_REQUEST['year']);
	$varHours		= trim($_REQUEST['hours']);
	$varMins		= trim($_REQUEST['mins']);
	$varMeridiem	= trim($_REQUEST['meridiem']);
	$varCountry		= trim($_REQUEST['country']);
	$varState		= trim($_REQUEST['state']);
	$varCity		= trim($_REQUEST['city']);
	$varchartstyle  = trim($_REQUEST['chartStyle']);
	$varDOB			= "$varYear-$varMonth-$varDate";
	$varCountryName	= stripslashes(trim($_REQUEST['countryName'])); //hidden
	$varStateName	= stripslashes(trim($_REQUEST['stateName'])); //hidden

	if ($varCountry !=87) { $varCityName	= stripslashes(trim($_REQUEST['cityName'])); } //hidden 
	if (($varDate>'0') && ($varMonth>'0') && ($varYear > '0')) { 
	
	$varFields	= array('(TO_DAYS(CURRENT_DATE())-TO_DAYS(\''.$varDOB.'\')) AS DOB');
	$varExecute	= $objSlaveDB->select($varTable['HORODISTRICT'], $varFields, '',0);
	$varResults	= mysql_fetch_array($varExecute);
	$varAge		= $varResults['DOB'];
	//$varAge	= $objHoroscope->horoscopeDOB($varDOB);
	$varAge = $varAge/365;
	$varAge	= (int)$varAge;

	if(($sessGender == '1') && ($varAge<'21')) { $varProcess = 'no'; $varGenerateHoroMsg = 'The minimum allowed age is 21.'; }
	elseif(($sessGender == '2') && ($varAge<'18')) { $varProcess = 'no'; $varGenerateHoroMsg = 'The minimum allowed age is 18.'; }
	elseif($varAge > '70') { $varProcess = 'no'; $varGenerateHoroMsg = 'The maximum allowed age is 70.'; }

##################
//error occured

	if($varProcess=='yes') {
		$varFields	= array('Longitude','Latitude');

		if($varCountry == '87') { // For India
			$varTableName		= $varTable['HORODISTRICT'];
			$varCondition	= " WHERE District=  ".$objSlaveDB->doEscapeString($varCity,$objSlaveDB);
		} else {
			$varTableName		= $varTable['HOROCITIES'];
			$varCondition	= " WHERE City_Id= ".$objSlaveDB->doEscapeString($varCity,$objSlaveDB);
		}
		$varExecute		= $objSlaveDB->select($varTableName, $varFields, $varCondition,0);
		$varResults		= mysql_fetch_array($varExecute);
		$varLongitude	= $varResults["Longitude"];
		$varLatitude	= $varResults["Latitude"];


		//CHECK NO OF RECORDS
		$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		$varNumRecords	= $objSlaveDB->numOfRecords($varTable['HORODETAILS'], 'MatriId', $varCondition);

	if ($varNumRecords=='0') {
		$varFields	= array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthMeridian','MatriId','BirthCity','BirthState','BirthCountry','BirthLongitude','BirthLatitude','Language','RequestDateTime','TimeCorrection','ChartStyle');
		$varFieldsValues	= array($objMasterDB->doEscapeString($varDate,$objMasterDB),$objMasterDB->doEscapeString($varMonth,$objMasterDB),$objMasterDB->doEscapeString($varYear,$objMasterDB),$objMasterDB->doEscapeString($varHours,$objMasterDB),$objMasterDB->doEscapeString($varMins,$objMasterDB),$objMasterDB->doEscapeString($varMeridiem,$objMasterDB),$objMasterDB->doEscapeString($sessMatriId,$objMasterDB),$objMasterDB->doEscapeString($varCity,$objMasterDB),$objMasterDB->doEscapeString($varState,$objMasterDB),$objMasterDB->doEscapeString($varCountry,$objMasterDB),$objMasterDB->doEscapeString($varLongitude,$objMasterDB),$objMasterDB->doEscapeString($varLatitude,$objMasterDB),$objMasterDB->doEscapeString($varLanguage,$objMasterDB),'NOW()',$objMasterDB->doEscapeString($varTimeCorrection,$objMasterDB),$objMasterDB->doEscapeString($varchartstyle,$objMasterDB));
		$objMasterDB->insert($varTable['HORODETAILS'],$varFields,$varFieldsValues);
	} else {

		//update($argTblName, $argFields, $argFieldsValue, $argCondition)
		$varCondition	= " MatriId= ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varFields	= array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthMeridian','BirthCity','BirthState','BirthCountry','BirthLongitude','BirthLatitude','Language','RequestDateTime','TimeCorrection','ChartStyle');
		$varFieldsValues	= array($objMasterDB->doEscapeString($varDate,$objMasterDB),$objMasterDB->doEscapeString($varMonth,$objMasterDB),$objMasterDB->doEscapeString($varYear,$objMasterDB),$objMasterDB->doEscapeString($varHours,$objMasterDB),$objMasterDB->doEscapeString($varMins,$objMasterDB),$objMasterDB->doEscapeString($varMeridiem,$objMasterDB),$objMasterDB->doEscapeString($varCity,$objMasterDB),$objMasterDB->doEscapeString($varState,$objMasterDB),$objMasterDB->doEscapeString($varCountry,$objMasterDB),$objMasterDB->doEscapeString($varLongitude,$objMasterDB),$objMasterDB->doEscapeString($varLatitude,$objMasterDB),$objMasterDB->doEscapeString($varLanguage,$objMasterDB),'NOW()',$objMasterDB->doEscapeString($varTimeCorrection,$objMasterDB),$objMasterDB->doEscapeString($varchartstyle,$objMasterDB));
		$objMasterDB->update($varTable['HORODETAILS'],$varFields,$varFieldsValues,$varCondition);


	}
		$varAstroURL = $objHoroscope->generateHoroscope($sessMatriId,$varLanguage,$objSlaveDB);

	}

	}
}
?>