<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/dbainfo.inc');
include_once($varBaseRoot.'/conf/domainlist.inc');
include_once($varBaseRoot.'/lib/clsDataConversion.php');

//Object Decleration
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

for($JJ=0; $JJ<1; $JJ++){
//GET DATAS FROM TEXT FILE - ('horoscope-info.txt')
$varFileContent		= file($varRootPath.'/data-conversion/horoscope-info'.$JJ.'.txt');
$varNoOfLines		= count($varFileContent);

for($i=0; $i<$varNoOfLines; $i++)
{
	$varHoroInfo	= split('~',trim($varFileContent[$i], "\n"));
	$varNewMatriId	= $varHoroInfo[0];
	$varOldMatriId	= $varHoroInfo[1];
	$varHoroUrl		= $varHoroInfo[2];
	$varHoroPasswd	= $varHoroInfo[3];
	$varHoroDesc	= addslashes($varHoroInfo[4]);
	$varDateUpdated = $varHoroInfo[5];
	$varHoroProStat = $varHoroInfo[6]=='Y'?1:0;
	
	$varHoroPath	= $varRootPath.'/data-conversion/BMphotos/'.$varLangArray[$varOldMatriId{0}].'/www/photos/'.$varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';
	$varHoroPath2	= $varRootPath.'/data-conversion/BMphotos/'.$varLangArray[$varOldMatriId{0}].'/www/horoscopegen/'. $varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';

	$varMatriIdPrefix	= substr($varNewMatriId, 0, 3);
	$varCommunityFolder	= $arrFolderNames[$varMatriIdPrefix];

	$varPath		= $varRootPath.'/membershoroscope/'.$varCommunityFolder.'/'.$varNewMatriId{3}.'/'.$varNewMatriId{4}.'/';
	$varFileType	= split('\.', $varHoroUrl);
	$varOldLocation	= $varHoroPath.$varHoroUrl;
	$varOldLocation2= $varHoroPath2.$varHoroUrl;
	$varRandValue	= $objDC->genRandValue();
	$varNewHoroName = $varNewMatriId.'_'.$varRandValue.'_HR.'.$varFileType[1];
	$varNewLocation = $varPath.$varNewHoroName;
	
	//COPY Horoscope BM TO Product
	$varResult		= '';
	$varHoroStatus	= 0;
	if(file_exists($varOldLocation))
	{
		$varResult = @copy($varOldLocation,$varNewLocation);
		$varHoroUrl= $varNewHoroName;
		$varHoroStatus	= 1;
	}else if(file_exists($varOldLocation2)){
		$varResult = @copy($varOldLocation2,$varNewLocation);
		$varHoroUrl= $varNewHoroName;
		$varHoroStatus	= 3;
	}
	

	if($varResult == 1){
	$varHoroPasswd			= ($varHoroProStat==1 && $varHoroPasswd!='')?$varHoroPasswd: '';
	$varHoroProtectStatus	= ($varHoroProStat==1 && $varHoroPasswd!='') ? 1 : 0;

	$varProTable	= $varDbaInfo['DATABASE'].'.comm_memberphotoinfo';
	$varCond		= "WHERE MatriId='".$varNewMatriId."'";
	$varUpdateCond	= "MatriId='".$varNewMatriId."'";
	$varRows		= $objDC->numOfRecords($varProTable, 'Photo_Id', $varCond);
	
	if($varRows == 0)
	{
		$varFields			= array('MatriId','HoroscopeURL','HoroscopeDescription','HoroscopeStatus','Horoscope_Protected', 'Horoscope_Protected_Password', 'Horoscope_Date_Updated');
		$varFieldsValues	= array("'".$varNewMatriId."'","'".$varHoroUrl."'","'".$varHoroDesc."'",$varHoroStatus,$varHoroProStat,"'".$varHoroPasswd."'","'".$varDateUpdated."'");
		$objDC->insert($varProTable, $varFields, $varFieldsValues);
		
	}
	elseif($varRows == 1)
	{
		$varFields			= array('HoroscopeURL','HoroscopeDescription','HoroscopeStatus','Horoscope_Protected', 'Horoscope_Protected_Password', 'Horoscope_Date_Updated');
		$varFieldsValues	= array("'".$varHoroUrl."'","'".$varHoroDesc."'",$varHoroStatus,$varHoroProStat,"'".$varHoroPasswd."'","'".$varDateUpdated."'");
		$objDC->update($varProTable, $varFields, $varFieldsValues, $varUpdateCond);
	}
	$varCommTable		= $varDbaInfo['DATABASE'].'.comm_memberinfo';
	$varFields			= array('Horoscope_Available','Horoscope_Protected');
	$varFieldsValues	= array($varHoroStatus,$varHoroProtectStatus);
	$objDC->update($varCommTable, $varFields, $varFieldsValues, $varUpdateCond);
	}//if
}
}//for
//UNSET OBJECT
$objDC->dbClose();
unset($objDC);
?>