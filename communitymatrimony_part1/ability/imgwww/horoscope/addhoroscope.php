<?
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================
//FILE INCLUDES
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
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
$sessGender		= $varGetCookieInfo["GENDER"];

//OBJECT INITIALIZATION
$objHoroscope	= new Horoscope;
$objSlaveDB		= new MemcacheDB;
$objMasterDB	= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
//$objHoroscope->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varEdit		= $_REQUEST['edit'];
$varCondition	= " WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);


//HOROSCOPE TABLES
$varFields			= array('HoroscopeURL','HoroscopeStatus','Horoscope_Protected','Horoscope_Protected_Password');
$varExecute			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
$varMemberPhotoinfo	= mysql_fetch_assoc($varExecute);

$varHoroscopeURL	= $varMemberPhotoinfo['HoroscopeURL'];
$varHoroscopeStatus	= $varMemberPhotoinfo['HoroscopeStatus'];

$varHoroscopeProtected			= $varMemberPhotoinfo['Horoscope_Protected'];
$varHoroscopeProtectedPassword	= $varMemberPhotoinfo['Horoscope_Protected_Password'];

//ADDED HOROSCOPE FILE INCLUDE
include_once($varRootBasePath."/www/horoscope/deletehoroscope.php");
include_once($varRootBasePath."/www/horoscope/addedhoroscope.php");
include_once($varRootBasePath."/www/horoscope/buildhoroscopedata.php");

//HORODETAILS
$varCondition	= " WHERE MatriId =  ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varFields		= array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','MatriId','BirthCity','BirthState','BirthLongitude','BirthLatitude','Language','RequestDateTime','Charttype','BirthCountry','TimeCorrection','ChartStyle','PlanetPositions','StarCheck','KujaCheck','DasaCheck','PapaCheck','StarValue','RasiValue','KujaDosha','RahuDosha');
$varExecute		= $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
$varHoroDetails	= mysql_fetch_array($varExecute);

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

if($varBirthCountry == 87) { // For India

	$varStateFields	= array('StateName');
	$varCityFields	= array('District');

	$varStateTableName		= $varTable['HOROINDIANSTATES'];
	$varCityTableName		= $varTable['HORODISTRICT'];

	$varStateCondition	= " WHERE StateId='".$varBirthState."'";	
	$varCityCondition	= " WHERE District='".$varBirthCity."'";

} else {

	$varStateFields	= array('State_Name');
	$varCityFields	= array('City_Name');

	$varCityTableName		= $varTable['HOROCITIES'];
	$varStateTableName		= $varTable['HORONRISTATES'];

	$varStateCondition	= " WHERE Country_Id='".$varBirthCountry."' AND State_Id='".$varBirthState."'";	
	$varCityCondition	= " WHERE City_Id='".$varBirthCity."'";
}

$varExecute		= $objSlaveDB->select($varCityTableName, $varCityFields, $varCityCondition,0);
$varResults		= mysql_fetch_array($varExecute);
$varCityName	= $varResults["City_Name"];
$varCityName	= $varCityName ? $varCityName : $varResults["District"];


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
<!-- <br><br>
<center><a href="<?=$confValues['SERVERURL']?>/payment/?act=additionalpayment&astro=1" target="_blank"><img src="<?=$confValues['IMGSURL']?>/astroimg.gif" /></a></center><br> -->
<?
if ($varAstroURL !='') {
	echo '<script> var astrourl="'.$confValues["IMAGEURL"].'/horoscope/sendhorodetails.php?xdata='.$varAstroURL.'";';
	echo 'function detectPopupBlocker() {';
	echo 'var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0,location=no");';
	echo 'if (!myTest) {';
	echo 'alert("A popup blocker was detected.");';
	echo '} else {';
	echo 'myTest.close();';
	echo '} }';
	echo 'detectPopupBlocker();';
	echo " var mywin002=window.open(astrourl,'mywindow1','location=0,status=0,scrollbars=0,toolbar=0,menubar=0,resizable=0,width=720,height=600'); ";
	echo " mywin002.moveTo(200,200); </script".">";
}
?>