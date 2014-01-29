<?php
#============================================================================================================
# Author 		: N.Dhanapal
# Start Date	: 10 Jul 2008
# End Date		: 10 Jul 2008
# Project		: MatrimonialProduct
# Module		: Register Class
#============================================================================================================
//FILE INCLUDES
$varRootBasePath = '/home/product/community/ability';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");

class Horoscope
{

	function generateHoroscope($sessMatriId,$varLanguage,$objSlaveDB) {

	global $varTable,$arrFolderNames,$varDomain;

		$varDomainId	= $confValues['DOMAINCASTEID'];

		//GET THE DETAILS FROM MEMBERINFO
		$varFields		= array('Name','Gender');
		$varCondition	= " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		$varExecute		= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
		$varResults		= mysql_fetch_array($varExecute);
		$varName		= str_replace(",","",trim($varResults["Name"]));
		$varGender		= trim($varResults["Gender"]);

		if(trim($varGender) == '1') { $varSex = "MALE"; }
		else if(trim($varGender) == '2') { $varSex = "FEMALE"; }

		//GET THE DETAILS FROM HORODETAILS
		$varFields		= array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthMeridian','BirthCity','BirthState','BirthLongitude','BirthLatitude','Language','RequestDateTime','Charttype','BirthCountry','TimeCorrection','ChartStyle');
		$varExecute			= $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
		$varHoroDetail		= mysql_fetch_array($varExecute);

		$varBirthDay		= trim($varHoroDetail["BirthDay"]);
		$varBirthMonth		= trim($varHoroDetail["BirthMonth"]);
		$varBirthYear		= trim($varHoroDetail["BirthYear"]);
		$varBirthHour		= trim($varHoroDetail["BirthHour"]);
		$varBirthMinute		= trim($varHoroDetail["BirthMinute"]);
		$varChartStyle		= trim($varHoroDetail["ChartStyle"]);
		if ($varBirthMinute < 10 ) { $varBirthMinute = '0'.$varBirthMinute; }

		$varBirthSeconds	= trim($varHoroDetail["BirthSeconds"]);
		if ($varBirthSeconds < 10 ) { $varBirthSeconds = '0'.$varBirthSeconds; }

		$varBirthMeridian	= trim($varHoroDetail["BirthMeridian"]);

		$varBirthCity		= trim($varHoroDetail["BirthCity"]);
		$varBirthState		= trim($varHoroDetail["BirthState"]);

		//24hr conversion
		 //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
		if(trim($varHoroDetail["BirthMeridian"]) != "") {

			if(trim($varHoroDetail["BirthMeridian"]) == "PM") {

				//SINCE ITS IN PM ADD 12 HRS TO THE EXISTING HR.
				$varBirthHour = $varBirthHour + 12;
				if(trim($varBirthHour) == 24) {
					 //since its comes to 24 use 12 itself. otherwise use the calculated time(hr +12)
					$varBirthHour = trim($varHoroDetail["BirthHour"]);
				}
			}
		}

		//CONVERTING 12 HRS SYSTEM TO 24 HRS BY ADDING 12 HR TO EXISTING HR.
		if(trim($varHoroDetail["BirthMeridian"]) != "") {
			if(trim($varHoroDetail["BirthMeridian"]) == "AM") {
				//SINCE ITS 12 AM it has to be changed to 0 hrs.
				if(trim($varBirthHour) == 12)
					$varBirthHour = 0;
			}
		}
		if($varBirthHour < 10) { $varBirthHour = "0".$varBirthHour; }
		//END 24HR CONVERSION

		$varExplodeLongi	= explode(".",$varHoroDetail["BirthLongitude"]);
		$varLongitudeDeg	= $varExplodeLongi[0];
		$varLongitudeMin	= substr($varExplodeLongi[1],0,2);
		$varLongitudeDir	= substr($varExplodeLongi[1],2,1);

		$varExplodeLati		= explode(".",$varHoroDetail["BirthLatitude"]);
		$varLatitudeDeg		= $varExplodeLati[0];
		$varLatitudeMin		= substr($varExplodeLati[1],0,2);

		 //BCWZ 60 MINUTES = 1 DEGREE (THE VALUE RANGE FOR MINUTE IS 0 - 59)..SASHISH
		if(trim($varLatitudeMin) == 60) { $varLatitudeMin = "00"; }
		$varLatitudeDir = substr($varExplodeLati[1],2,1);


		if(is_numeric($varBirthCity)) {

			//if $varBirthCity value is numeric then this member has generated his/her horoscope using our new db tables. So get the Timezone details from horo_cities table (new)
			if((trim($varHoroDetail["TimeCorrection"]) == 0) || (trim($varHoroDetail["BirthCountry"]) == "India")) {

			//GET THE DETAILS FROM HORODISTRICT

			$varFields		= array('Timezone');
			$varCondition	= " WHERE City_Id='".$varBirthCity."'";
			$varExecute		= $objSlaveDB->select($varTable['HOROCITIES'], $varFields, $varCondition,0);
			$varResults		= mysql_fetch_array($varExecute);

			$varTimeZone	= substr(trim($varResults["Timezone"]),0,5);
			$varTimeZoneDir	= substr(trim($varResults["Timezone"]),5,1);

			//IF TZONE IS EMPTY THEN <TZONEDIR>W</TZONEDIR> 
			if(trim($varTimeZoneDir) == "") { $varTimeZoneDir = "W"; }

			//LONGITUDE IN <LONG>004.28</LONG> FORMAT..     3 SEGMENT DOT 2 SEGMENT
			if(strlen($varLongitudeDeg) == 1) { $varLongitudeDeg = '00'.$varLongitudeDeg; }
			else if(strlen($varLongitudeDeg) == 2) { $varLongitudeDeg = '0'.$varLongitudeDeg; }

			//TIMEZONE SHD BE IN <TZONE>00.00</TZONE> FORMAT
			if(trim($varTimeZone) == 0) { $varTimeZone = "00:00"; }

			} else {

				//other countries
				//GET THE DETAILS FROM HORODISTRICTOTHERS

				$varFields		= array('Timezone');
				$varCondition	= " WHERE City_Id='".$varBirthCity."'";
				$varExecute		= $this->select($varTable['HOROCITIES'], $varFields, $varCondition,0);
				$varResults		= mysql_fetch_array($varExecute);
				$varTimeZone = substr(trim($varResults["Timezone"]),0,5);
				$varTimeZoneDir = substr(trim($varResults["Timezone"]),5,1);

				//IF TZONE IS EMPTY THEN <TZONEDIR>W</TZONEDIR> 
				if(trim($varTimeZoneDir) == "") { $varTimeZoneDir = "W"; }

				//longitude in <LONG>004.28</LONG> format..     3 segment dot 2 segment
				if(strlen($varLongitudeDeg) == 1) { $varLongitudeDeg = '00'.$varLongitudeDeg; }
				else if(strlen($varLongitudeDeg) == 2) { $varLongitudeDeg = '0'.$varLongitudeDeg; }

				//TIMEZONE SHD BE IN <TZONE>00.00</TZONE> FORMAT
				if(trim($varTimeZone) == 0) { $varTimeZone = "00:00"; }
			}
		}
		else
		{
			//if $varBirthCity value is string then this member has generated his/her horoscope using our old db tables. So get the Timezone details from horodistrict table (old)
			//echo "<br>Indian member";
			if((trim($varHoroDetail["TimeCorrection"]) == 0) || (trim($varHoroDetail["BirthCountry"]) == "India")) //means india
			{
				//GET THE DETAILS FROM HORODISTRICT

				$varFields		= array('Timezone');
				$varCondition	= " WHERE District='".$varBirthCity."'";
				$varExecute		= $objSlaveDB->select($varTable['HORODISTRICT'], $varFields, $varCondition,0);
				$varResults		= mysql_fetch_array($varExecute);
				$varTimeZone = substr(trim($varResults["Timezone"]),0,5);
				$varTimeZoneDir = substr(trim($varResults["Timezone"]),5,1);
 
			} else {
				//other countries
				//Get the details from horodistrictothers

				$varFields		= array('city,Timezone');
				$varCondition	= " WHERE District='".$varBirthCity."'";
				$varExecute		= $objSlaveDB->select($varTable['HOROALLCOUNTRIESCITIES'], $varFields, $varCondition,0);
				$varResults		= mysql_fetch_array($varExecute);
				$varTimeZone = substr(trim($varResults["Timezone"]),0,5);
				$varTimeZoneDir = substr(trim($varResults["Timezone"]),5,1);

				//IF TZONE IS EMPTY THEN <TZONEDIR>W</TZONEDIR> 
				if(trim($varTimeZoneDir) == "") { $varTimeZoneDir = "W"; }

				//LONGITUDE IN <LONG>004.28</LONG> FORMAT..     3 SEGMENT DOT 2 SEGMENT
				if(strlen($varLongitudeDeg) == 1) { $varLongitudeDeg = '00'.$varLongitudeDeg; }
				else if(strlen($varLongitudeDeg) == 2) { $varLongitudeDeg = '0'.$varLongitudeDeg; }

				//TIMEZONE SHD BE IN <TZONE>00.00</TZONE> FORMAT
				if(trim($varTimeZone) == 0) { $varTimeZone = "00:00"; } 
			}
		}

		//<CORR>1</CORR> default setting in horopage.php
		$varTimeCorrection = 1;
		//$REPORT_CHART_FORMAT = 0;
		//Report Type default value LS-SP = LifeSign Single Page. Future it might change(chat with Sashish 31 Oct 06
/*
echo 'MatriId='.$sessMatriId;
echo '<br>';
echo 'varSex='.$varSex;
echo '<br>';
echo 'varName='.$varName;
echo '<br>';
echo 'varBirthDay='.$varBirthDay;
echo '<br>';
echo 'varBirthMonth='.$varBirthMonth;
echo '<br>';
echo 'varBirthYear='.$varBirthYear;
echo '<br>';
echo 'varBirthHour='.$varBirthHour;
echo '<br>';
echo 'varBirthMinute='.$varBirthMinute;
echo '<br>';
echo 'varBirthSeconds='.$varBirthSeconds;
echo '<br>';
echo 'varTimeCorrection='.$varTimeCorrection;
echo '<br>';
echo 'varBirthCity='.$varBirthCity;
echo '<br>';
echo 'varLongitudeDeg='.$varLongitudeDeg;
echo '<br>';
echo 'varLongitudeMin='.$varLongitudeMin;
echo '<br>';

echo 'varLatitudeDeg='.$varLatitudeDeg;
echo '<br>';
echo 'varLatitudeMin='.$varLatitudeMin;

echo '<br>';
echo 'varLongitudeDir='.$varLongitudeDir;
echo '<br>';
echo 'varLatitudeDir='.$varLatitudeDir;
echo '<br>';
echo 'varTimeZone='.$varTimeZone;
echo '<br>';
echo 'varTimeZoneDir='.$varTimeZoneDir;
echo '<br>';
echo 'varChartStyle='.$varChartStyle;
echo '<br>';
echo 'varLanguage='.$varLanguage;
echo '<br>';
echo 'ss=-'.$arrDomainInfo[$varDomain][2];
exit;*/

//HORO URL
$varDomainPrefix	= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varDomainPrefix];

$varHoroURL	= 'http://image.communitymatrimony.com/membershoroscope/'.$varFolderName.'/'.$sessMatriId{3}.'/'.$sessMatriId{4}.'/';
//echo ''.$varHoroURL;


		$retDate = "<DATA><BIRTHDATA><CUSTID>$sessMatriId</CUSTID><SEX>$varSex</SEX><NAME>$varName</NAME><DAY>$varBirthDay</DAY><MONTH>$varBirthMonth</MONTH><YEAR>$varBirthYear</YEAR><TIME24HR>$varBirthHour.$varBirthMinute.$varBirthSeconds</TIME24HR><CORR>$varTimeCorrection</CORR><PLACE>$varBirthCity</PLACE><LONG>$varLongitudeDeg.$varLongitudeMin</LONG><LAT>$varLatitudeDeg.$varLatitudeMin</LAT><LONGDIR>$varLongitudeDir</LONGDIR><LATDIR>$varLatitudeDir</LATDIR><TZONE>$varTimeZone</TZONE><TZONEDIR>$varTimeZoneDir</TZONEDIR></BIRTHDATA><OPTIONS><CHARTSTYLE>$varChartStyle</CHARTSTYLE><LANGUAGE>".$varLanguage."</LANGUAGE><REPTYPE>LS-SP</REPTYPE><REPDMN>community</REPDMN><HOROURL>".$varHoroURL."</HOROURL><HSETTINGS><AYANAMSA>1</AYANAMSA><DASASYSTEM>1</DASASYSTEM><GULIKATYPE>1</GULIKATYPE><PARYANTHARSTART>0</PARYANTHARSTART><PARYANTHAREND>25</PARYANTHAREND><FAVMARPERIOD>50</FAVMARPERIOD><BHAVABALAMETHOD>1</BHAVABALAMETHOD><ADVANCEDOPTION1>0</ADVANCEDOPTION1><ADVANCEDOPTION2>0</ADVANCEDOPTION2><ADVANCEDOPTION3>0</ADVANCEDOPTION3><ADVANCEDOPTION4>0</ADVANCEDOPTION4></HSETTINGS></OPTIONS></DATA>";

/*
- <DATA>
- <BIRTHDATA>
  <CUSTID>1234</CUSTID> 
  <SEX>MALE</SEX> 
  <NAME>Santhosh Siddharth BV</NAME> 
  <DAY>2</DAY> 
  <MONTH>1</MONTH> 
  <YEAR>1980</YEAR> 
  <TIME24HR>04.15.00</TIME24HR> 
  <CORR>1</CORR> 
  <PLACE>Chennai (madras)</PLACE> 
  <LONG>080.15</LONG> 
  <LAT>13.04</LAT> 
  <LONGDIR>E</LONGDIR> 
  <LATDIR>N</LATDIR> 
  <TZONE>05.30</TZONE> 
  <TZONEDIR>E</TZONEDIR> 
  </BIRTHDATA>
- <OPTIONS>
  <CHARTSTYLE>0</CHARTSTYLE> 
  <LANGUAGE>TAM</LANGUAGE> 
  <REPTYPE>LS-SP</REPTYPE> 
  <REPDMN>tamil</REPDMN> 
  <HOROURL /> 
- <HSETTINGS>
  <AYANAMSA>1</AYANAMSA> 
  <DASASYSTEM>1</DASASYSTEM> 
  <GULIKATYPE>1</GULIKATYPE> 
  <PARYANTHARSTART>0</PARYANTHARSTART> 
  <PARYANTHAREND>25</PARYANTHAREND> 
  <FAVMARPERIOD>50</FAVMARPERIOD> 
  <BHAVABALAMETHOD>1</BHAVABALAMETHOD> 
  <ADVANCEDOPTION1>0</ADVANCEDOPTION1> 
  <ADVANCEDOPTION2>0</ADVANCEDOPTION2> 
  <ADVANCEDOPTION3>0</ADVANCEDOPTION3> 
  <ADVANCEDOPTION4>0</ADVANCEDOPTION4> 
  </HSETTINGS>
  </OPTIONS>
  </DATA>*/


		return $retDate;


	}


	function horoscopeArrayList($arrList, $argSelectedValue) { 		print_r($arrList);
		foreach($arrList as $funIndex => $funValues) {
			//$funSelectedItem = ($argSelectedValue!='' && $argSelectedValue==$funIndex) ? "selected" : "";
			$funOptions .= '<option value="'.$funIndex.'">'.$funValues.'</option>';
		}//for
		echo $funOptions;

	}//getValuesFromArray

}
?>