<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];

//OBJECT INITIALIZATION
$objSlaveDB	= new DB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varCountry	= trim($_REQUEST['country']);
$varState	= trim($_REQUEST['state']);

//EDIT PURPOSE
//HORODETAILS
$varCondition		= " WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varFields			= array('BirthCity','BirthState','BirthCountry');
$varExecute			= $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
$varHoroDetails		= mysql_fetch_array($varExecute);
$varBirthCountry	= $varHoroDetails["BirthCountry"];
$varBirthState		= $varHoroDetails["BirthState"];
$varBirthCity		= $varHoroDetails["BirthCity"];

//STATE LIST
if ($varCountry) {
		$varJsFunction	= "onChange=\"generateCityList();\"";
		$varContent		= '<select size="1" name="state" class="smalltxt select1" '.$varJsFunction.' style="width:230px;" onBlur="funGenerateHoroChk();">';
		$varContent		.= '<option value="0">--- Select state ---</option>';

	if ($varCountry==87) {

		$varFields		= array('StateId','StateName');
		$varExecute		= $objSlaveDB->select($varTable['HOROINDIANSTATES'], $varFields, '',0);

		while($varStateinfo	= mysql_fetch_array($varExecute)) {
		$varStateSelected	= '';
		$varStateId			= $varStateinfo['StateId'];
		if($varStateId==$varBirthState) { $varStateSelected = ' SELECTED'; }

		$varContent	.= "<option value='".$varStateId."'".$varStateSelected.">".$varStateinfo['StateName']."</option>";

		}//while

	} else {
		$varCondition	= " WHERE Country_Id= ".$objSlaveDB->doEscapeString($varCountry,$objSlaveDB);
		$varFields		= array('State_Id','State_Name');
		$varExecute		= $objSlaveDB->select($varTable['HORONRISTATES'], $varFields, $varCondition,0);
		while($varStateinfo	= mysql_fetch_array($varExecute)) {
		$varStateSelected	= '';
		$varStateId			= $varStateinfo['State_Id'];
		if($varStateId==$varBirthState) { $varStateSelected = ' SELECTED'; }

		$varContent	.= "<option value='".$varStateId."'".$varStateSelected.">".$varStateinfo['State_Name']."</option>";
		}//while

	}
		$varContent	.= '</select><br><span id="statespan" class="errortxt"></span>';
}

if ($varState >0 && $varCountry !='' ) {


	if ($varCountry==87) { 

		$varCondition	= " WHERE StateId= ".$objSlaveDB->doEscapeString($varState,$objSlaveDB);
		$varTableName	= $varTable['HORODISTRICT'];
		$varFields		= array('StateId AS State_Id','District AS City_Id','District AS City_Name','Longitude','Latitude','Timezone');

	} else {
		$varCondition	= " WHERE StateId= ".$objSlaveDB->doEscapeString($varState,$objSlaveDB);
		$varTableName	= $varTable['HOROCITIES'];
		$varFields		= array('State_Id','City_Id','City_Name','Longitude','Latitude','Timezone');
	}
	$varExecute		= $objSlaveDB->select($varTableName, $varFields, $varCondition,0);

	$varContent		= '<select size="1" name="city" class="smalltxt select1" style="width:230px;" onBlur="funGenerateHoroChk();"><option value="0">--- Select city ---</option>';

	while($varCitiinfo	= mysql_fetch_array($varExecute)) {

		$varCitySelected	= '';
		$varCityId			= $varCitiinfo['City_Id'];
		if($varBirthCity==$varCityId) { $varCitySelected = 'SELECTED'; }

		$varContent	.= '<option value="'.$varCityId.'" '.$varCitySelected.'>'.$varCitiinfo['City_Name'].'</option>';
	}//while
	$varContent		.= '</select><br><span id="cityspan" class="errortxt"></span>';
}
echo '&nbsp;&nbsp;'.$varContent;
?>