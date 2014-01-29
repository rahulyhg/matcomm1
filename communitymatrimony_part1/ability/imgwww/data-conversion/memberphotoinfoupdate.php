<?php
ini_set("memory_limit","1024M");
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.inc');
include_once($varBaseRoot.'/conf/dbainfo.inc');
include_once($varBaseRoot.'/lib/clsDataConversion.php');

//Object Decleration
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

for($JJ=0; $JJ<1; $JJ++){
$varRecsCnt= 70000;
$varStartLimit  = $JJ*$varRecsCnt;

#SELECT DATAS FROM matrimonyprofile
$varCommTable		= $varDbaInfo['DATABASE'].'.comm_memberphotoinfo';
$varFields		= array('Photo_Id', 'MatriId', 'Normal_Photo1', 'Description1', 'Thumb_Small_Photo1', 'Thumb_Big_Photo1', 'Photo_Status1', 'Normal_Photo2', 'Description2', 'Thumb_Small_Photo2', 'Thumb_Big_Photo2', 'Photo_Status2', 'Normal_Photo3', 'Description3', 'Thumb_Small_Photo3', 'Thumb_Big_Photo3', 'Photo_Status3', 'Normal_Photo4', 'Description4', 'Thumb_Small_Photo4', 'Thumb_Big_Photo4', 'Photo_Status4', 'Normal_Photo5', 'Description5', 'Thumb_Small_Photo5', 'Thumb_Big_Photo5', 'Photo_Status5', 'Normal_Photo6', 'Description6', 'Thumb_Small_Photo6', 'Thumb_Big_Photo6', 'Photo_Status6', 'Normal_Photo7', 'Description7', 'Thumb_Small_Photo7', 'Thumb_Big_Photo7', 'Photo_Status7', 'Normal_Photo8', 'Description8', 'Thumb_Small_Photo8', 'Thumb_Big_Photo8', 'Photo_Status8', 'Normal_Photo9', 'Description9', 'Thumb_Small_Photo9', 'Thumb_Big_Photo9', 'Photo_Status9', 'Normal_Photo10', 'Description10', 'Thumb_Small_Photo10', 'Thumb_Big_Photo10', 'Photo_Status10', 'Photo_Protected', 'Photo_Protect_Password', 'Photo_Date_Updated', 'HoroscopeURL', 'HoroscopeDescription', 'HoroscopeStatus', 'Horoscope_Date_Updated', 'Horoscope_Protected', 'Horoscope_Protected_Password');
$varCond		= ' ORDER BY Photo_Id ASC LIMIT '.$varStartLimit.', '.$varRecsCnt;
$varPhotoDet	= $objDC->select($varCommTable, $varFields, $varCond, 1);

$varNoOfRecs	= count($varPhotoDet);

//File Creation
$varFileName = 'FinalPhotosList'.$JJ.'.txt';
@unlink($varFileName);
$varFileHand = fopen($varFileName, 'a');

for($i=0; $i<$varNoOfRecs; $i++)
{
	$arrFinalValues = array();
	$arrCopiedPhotos= array();
	$kk =0;
	for($k=1; $k<=10; $k++){
		$varNLField	= 'Normal_Photo'.$k;
		$varTSField	= 'Thumb_Small_Photo'.$k;
		$varTBField	= 'Thumb_Big_Photo'.$k;
		$varStField	= 'Photo_Status'.$k;
		$varDecField= 'Description'.$k;

		$varFiledVal1= $varPhotoDet[$i][$varNLField];
		$varFiledVal2= $varPhotoDet[$i][$varTSField];
		$varFiledVal3= $varPhotoDet[$i][$varTBField];
		$varFiledVal4= $varPhotoDet[$i][$varStField];
		$varFiledVal5= $varPhotoDet[$i][$varDecField];

		if($varFiledVal1!='' && $varFiledVal2!='' && $varFiledVal3!='' && $varFiledVal4 ==1){
			$arrFinalValues[$kk]['Normal_Photo']		= $varFiledVal1;
			$arrFinalValues[$kk]['Thumb_Small_Photo']	= $varFiledVal2;
			$arrFinalValues[$kk]['Thumb_Big_Photo']		= $varFiledVal3;
			$arrFinalValues[$kk]['Photo_Status']		= 1;
			$arrFinalValues[$kk]['Description']			= addslashes($varFiledVal5);
			$kk++;

			$arrCopiedPhotos[] = $varFiledVal1;
			$arrCopiedPhotos[] = $varFiledVal2;
			$arrCopiedPhotos[] = $varFiledVal3;
		}
	}

	$varUpdateCond	= 'Photo_Id='.$varPhotoDet[$i]['Photo_Id']." AND MatriId='".$varPhotoDet[$i]['MatriId']."'";
		
	$varFieldsVal	= array($varPhotoDet[$i]['Photo_Id'], "'".$varPhotoDet[$i]['MatriId']."'", "'".$arrFinalValues[0]['Normal_Photo']."'", "'".$arrFinalValues[0]['Description']."'", "'".$arrFinalValues[0]['Thumb_Small_Photo']."'", "'".$arrFinalValues[0]['Thumb_Big_Photo']."'", "'".$arrFinalValues[0]['Photo_Status']."'",  "'".$arrFinalValues[1]['Normal_Photo']."'", "'".$arrFinalValues[1]['Description']."'", "'".$arrFinalValues[1]['Thumb_Small_Photo']."'", "'".$arrFinalValues[1]['Thumb_Big_Photo']."'", "'".$arrFinalValues[1]['Photo_Status']."'", "'".$arrFinalValues[2]['Normal_Photo']."'", "'".$arrFinalValues[2]['Description']."'", "'".$arrFinalValues[2]['Thumb_Small_Photo']."'", "'".$arrFinalValues[2]['Thumb_Big_Photo']."'", "'".$arrFinalValues[2]['Photo_Status']."'", "'".$arrFinalValues[3]['Normal_Photo']."'", "'".$arrFinalValues[3]['Description']."'", "'".$arrFinalValues[3]['Thumb_Small_Photo']."'", "'".$arrFinalValues[3]['Thumb_Big_Photo']."'", "'".$arrFinalValues[3]['Photo_Status']."'", "'".$arrFinalValues[4]['Normal_Photo']."'", "'".$arrFinalValues[4]['Description']."'", "'".$arrFinalValues[4]['Thumb_Small_Photo']."'", "'".$arrFinalValues[4]['Thumb_Big_Photo']."'", "'".$arrFinalValues[4]['Photo_Status']."'", "'".$arrFinalValues[5]['Normal_Photo']."'", "'".$arrFinalValues[5]['Description']."'", "'".$arrFinalValues[5]['Thumb_Small_Photo']."'", "'".$arrFinalValues[5]['Thumb_Big_Photo']."'", "'".$arrFinalValues[5]['Photo_Status']."'", "'".$arrFinalValues[6]['Normal_Photo']."'", "'".$arrFinalValues[6]['Description']."'", "'".$arrFinalValues[6]['Thumb_Small_Photo']."'", "'".$arrFinalValues[6]['Thumb_Big_Photo']."'", "'".$arrFinalValues[6]['Photo_Status']."'", "'".$arrFinalValues[7]['Normal_Photo']."'", "'".$arrFinalValues[7]['Description']."'", "'".$arrFinalValues[7]['Thumb_Small_Photo']."'", "'".$arrFinalValues[7]['Thumb_Big_Photo']."'", "'".$arrFinalValues[7]['Photo_Status']."'", "'".$arrFinalValues[8]['Normal_Photo']."'", "'".$arrFinalValues[8]['Description']."'", "'".$arrFinalValues[8]['Thumb_Small_Photo']."'", "'".$arrFinalValues[8]['Thumb_Big_Photo']."'", "'".$arrFinalValues[8]['Photo_Status']."'", "'".$arrFinalValues[9]['Normal_Photo']."'", "'".$arrFinalValues[9]['Description']."'", "'".$arrFinalValues[9]['Thumb_Small_Photo']."'", "'".$arrFinalValues[9]['Thumb_Big_Photo']."'", "'".$arrFinalValues[9]['Photo_Status']."'", "'".$varPhotoDet[$i]['Photo_Protected']."'", "'".$varPhotoDet[$i]['Photo_Protect_Password']."'", "'".$varPhotoDet[$i]['Photo_Date_Updated']."'", "'".$varPhotoDet[$i]['HoroscopeURL']."'", "'".addslashes($varPhotoDet[$i]['HoroscopeDescription'])."'", "'".$varPhotoDet[$i]['HoroscopeStatus']."'", "'".$varPhotoDet[$i]['Horoscope_Date_Updated']."'", "'".$varPhotoDet[$i]['Horoscope_Protected']."'", "'".$varPhotoDet[$i]['Horoscope_Protected_Password']."'");
	
	$objDC->update($varCommTable, $varFields, $varFieldsVal, $varUpdateCond);
	fwrite($varFileHand, join("\n", $arrCopiedPhotos)."\n");
}
	fclose($varFileHand);
}
//UNSET OBJECT
unset($objDC);
?>