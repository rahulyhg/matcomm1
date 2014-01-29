<?
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================
//FILE INCLUDES
$varRootBasePath	= '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/horoscope.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsHoroscope.php");
include_once($varRootBasePath."/www/profiledetail/settingsheader.php");

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

//OBJECT INITIALIZATION
$objHoroscope	= new Horoscope;
$objSlaveDB		= new MemcacheDB;
$objMasterDB	= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varEdit	= $_REQUEST['edit'];

//ADDED HOROSCOPE FILE INCLUDE
include_once($varRootBasePath."/www/horoscope/addedhoroscope.php");


//HOROSCOPE TABLES
$varCondition		= " WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varFields			= array('HoroscopeURL','HoroscopeStatus');
$varExecute			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
$varMemberPhotoinfo	= mysql_fetch_assoc($varExecute);
$varHoroscopeURL	= $varMemberPhotoinfo['HoroscopeURL'];
$varHoroscopeStatus	= $varMemberPhotoinfo['HoroscopeStatus'];

//HORODETAILS
$varFields		= array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','MatriId','BirthCity','BirthState','BirthLongitude','BirthLatitude','Language','RequestDateTime','Charttype','BirthCountry','TimeCorrection','ChartStyle','PlanetPositions','StarCheck','KujaCheck','DasaCheck','PapaCheck','StarValue','RasiValue','KujaDosha','RahuDosha');
$varExecute		= $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
$varHoroDetails	= mysql_fetch_array($varExecute);

print_r($varHoroDetails);

	$varBirthDay		= $varHoroDetails["BirthDay"];
	$varBirthMonth		= $varHoroDetails["BirthMonth"];
	$varBirthYear		= $varHoroDetails["BirthYear"];
	$varBirthHour		= $varHoroDetails["BirthHour"];
	$varBirthMinute		= $varHoroDetails["BirthMinute"];
	$varBirthSeconds	= $varHoroDetails["BirthSeconds"];
	$varBirthMeridian	= $varHoroDetails["BirthMeridian"];
	$varBirthCountry	= $varHoroDetails["BirthCountry"];
	$varBirthState		= $varHoroDetails["BirthState"];
	$varBirthCity		= $varHoroDetails["BirthCity"];
	$varChartStyle		= $varHoroDetails["ChartStyle"];

//SELECT COUNTRY NAME
$varCondition	= " WHERE Country_Id='".$varBirthCountry."'";
$varFields		= array('Country_Name');
$varExecute		= $objSlaveDB->select($varTable['HOROCOUNTRIES'], $varFields, $varCondition,0);
$varCountryName = mysql_fetch_array($varExecute);
$varCountry		= $varCountryName["Country_Name"];

$varCityFields	= array('City_Name');

if($varCountry == 87) { // For India

	$varStateFields	= array('StateName');

	$varStateTableName		= $varTable['HOROINDIANSTATES'];
	$varCityTableName		= $varTable['HORODISTRICT'];

	$varStateCondition	= " WHERE StateId='".$varBirthState."'";	
	$varCityCondition	= " WHERE District='".$varBirthCity."'";

} else {

	$varStateFields	= array('State_Name');

	$varCityTableName		= $varTable['HOROCITIES'];
	$varStateTableName		= $varTable['HORONRISTATES'];

	$varStateCondition	= " WHERE Country_Id='".$varBirthCountry."' AND State_Id='".$varBirthState."'";	
	$varCityCondition	= " WHERE City_Id='".$varBirthCity."'";
}

$varExecute		= $objSlaveDB->select($varCityTableName, $varCityFields, $varCityCondition,0);
$varResults		= mysql_fetch_array($varExecute);
$varCityName	= $varResults["City_Name"];


$varExecute1	= $objSlaveDB->select($varStateTableName, $varStateFields, $varStateCondition,0);
$varResults1	= mysql_fetch_array($varExecute1);
$varStateName	= $varResults1["State_Name"];
$varStateName	= $varStateName ? $varStateName : $varResults1["StateName"];

echo '<br clear="all">';
include_once($varRootBasePath."/www/horoscope/generatehoroscopeform.php");
include_once($varRootBasePath."/www/horoscope/uploadhoroscopeform.php");
include_once($varRootBasePath."/www/horoscope/protecthoroscopeform.php");

$objSlaveDB->dbClose();
UNSET($objSlaveDB);

?>
<br><br>
<center><a href="<?=$confValues['SERVERURL']?>/payment/?act=additionalpayment&astro=1" target="_blank"><img src="<?=$confValues['IMGSURL']?>/astroimg.gif" /></a></center><br>