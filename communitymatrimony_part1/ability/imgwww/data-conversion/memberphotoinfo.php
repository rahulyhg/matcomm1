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
include_once($varBaseRoot.'/conf/domainlist.inc');
include_once($varBaseRoot.'/lib/clsDataConversion.php');

//Object Decleration
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

for($JJ=0; $JJ<1; $JJ++){
//GET DATAS FROM TEXT FILE - ('product-photos-list.txt')
$varFileContent		= file($varRootPath.'/data-conversion/photo-lists/product-photos-list'.$JJ.'.txt');

//Delete photo based txt files
$varUncopiedFile	= $varRootPath.'/data-conversion/photo-lists/Uncopied_photos'.$JJ.'.txt';
$varCopiedFile		= $varRootPath.'/data-conversion/photo-lists/Copied_photos'.$JJ.'.txt';

@unlink($varUncopiedFile);
@unlink($varCopiedFile);

//Create File
$varUncopiedHandler	= fopen($varUncopiedFile,'a');
$varCopiedHandler	= fopen($varCopiedFile,'a');

//BM Languages List
$varOldRandomValues = array();
$varUnCopiedPhotos	= array();
$varCopiedPhotos	= array();
$varNoOfRecs		= count($varFileContent);

for($i=0; $i<$varNoOfRecs; $i++)
{
	//Initializng variables
	$varNewPhotoName= '';
	$varFieldName1	= '';
	$varFieldName2	= '';
	$varFieldName3	= '';
	$varRandValue	= '';
	$varCurrDateTime= date('Y-m-d H:i:s');

	//Get single photo information from txt file 
	$varPhotoDatas	= split('~', trim($varFileContent[$i],"\n"));

	$varOldPhotoName	= $varPhotoDatas[0];
	$varMatriId			= $varPhotoDatas[1];
	$varPhotoType		= $varPhotoDatas[2];
	$varPhotoOrder		= $varPhotoDatas[3];
	$varPhotoStatus		= $varPhotoDatas[4];
	$varPhotoDesc		= addslashes($varPhotoDatas[5]);
	$varFileType		= split('\.', $varOldPhotoName);
	$varOldMatriIdInfo	= split('_',$varOldPhotoName);
	$varOldMatriId		= trim($varOldMatriIdInfo[0]);

	$varMatriIdPrefix	= substr($varMatriId, 0, 3);
	$varCommunityFolder	= $arrFolderNames[$varMatriIdPrefix];
	//Communitymatrimony photo path
	$varPath			= $varRootPath.'/membersphoto/'.$varCommunityFolder.'/'.$varMatriId{3}.'/'.$varMatriId{4}.'/';
	//Bharat matrimony validated photos path
	$varSourcePath		= $varRootPath.'/data-conversion/BMphotos/'.$varLangArray[strtoupper($varOldMatriId{0})].'/www/photosorg/'.$varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';
	$varSourcePath2		= $varRootPath.'/data-conversion/BMphotos/'.$varLangArray[$varOldMatriId{0}].'/www/photosorg/';
	$varNLSourcePath	= $varRootPath.'/data-conversion/BMphotos/'.$varLangArray[strtoupper($varOldMatriId{0})].'/www/photos/'.$varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';
		
	if($varOldRandomValues[$varMatriId][$varPhotoOrder] == '')
	{
		$varRandValue	= $objDC->genRandValue();	
		$varOldRandomValues[$varMatriId][$varPhotoOrder] = $varRandValue;
	}
	else
	{
		$varRandValue	= $varOldRandomValues[$varMatriId][$varPhotoOrder];
	}
	
	switch($varPhotoType)
	{
		case 'NL': 
			$varNewPhotoName = $varMatriId.'_'.$varRandValue.'_NL_'.$varPhotoOrder.'.'.$varFileType[1];
			$varFieldName1   = 'Normal_Photo'.$varPhotoOrder;
			break;
		case 'TS': 
			$varNewPhotoName = $varMatriId.'_'.$varRandValue.'_TS_'.$varPhotoOrder.'.'.$varFileType[1];
			$varFieldName1   = 'Thumb_Small_Photo'.$varPhotoOrder;
			break;
		case 'TB': 
			$varNewPhotoName = $varMatriId.'_'.$varRandValue.'_TB_'.$varPhotoOrder.'.'.$varFileType[1];
			$varFieldName1   = 'Thumb_Big_Photo'.$varPhotoOrder;
			break;
	}//switch
	$varFieldName2	= 'Photo_Status'.$varPhotoOrder;
	$varFieldName3	= 'Description'.$varPhotoOrder;
	$varNewLocation	= $varPath.$varNewPhotoName;
	$varOldLocation	= $varSourcePath.$varOldPhotoName;
	$varOldLocation2= $varSourcePath2.$varOldPhotoName;
	$varNLLocation	= $varNLSourcePath.$varOldPhotoName;

	//COPY PHOTO BM TO COMMUNITY
	$varResult = 0;
	if($varPhotoType =='NL' && file_exists($varNLLocation)){
		$varResult  = @copy($varNLLocation,$varNewLocation);
	}else if(($varPhotoType =='TS' || $varPhotoType =='TB') && file_exists($varOldLocation)){
		$varResult  = @copy($varOldLocation,$varNewLocation);
	}else if(($varPhotoType =='TS' || $varPhotoType =='TB') && file_exists($varOldLocation2)){
		$varResult  = @copy($varOldLocation2,$varNewLocation);
	}

	if($varResult==1)
	{
		$varCMTableName	= $varDbaInfo['DATABASE'].'.comm_memberphotoinfo';
		$varCond		= "WHERE MatriId='".$varMatriId."'";
		$varUpdateCond	= "MatriId='".$varMatriId."'";
		$varRows		= $objDC->numOfRecords($varCMTableName, 'Photo_Id', $varCond);

		if($varRows == 0)
		{
			$varFields			= array('MatriId',$varFieldName1,$varFieldName2,$varFieldName3,'Photo_Date_Updated');
			$varFieldsValues	= array("'".$varMatriId."'","'".$varNewPhotoName."'",$varPhotoStatus,"'".$varPhotoDesc."'",												"'".$varCurrDateTime."'");
			$objDC->insert($varCMTableName, $varFields, $varFieldsValues);	
		}//if
		elseif($varRows == 1)
		{
			$varFields			= array($varFieldName1,$varFieldName2,$varFieldName3);
			$varFieldsValues	= array("'".$varNewPhotoName."'",$varPhotoStatus,"'".$varPhotoDesc."'");
			$objDC->update($varCMTableName, $varFields, $varFieldsValues, $varUpdateCond);
		}
		$varCopiedPhotos[] = $varNewLocation;
	}//if
	else
	{
		$varUnCopiedPhotos[] = $varOldLocation;
	}//else
}//for

//Write Uncopied photos info
if(count($varUnCopiedPhotos)>0){
$varUncopiedDatas	= @join("\n",$varUnCopiedPhotos);
fwrite($varUncopiedHandler,$varUncopiedDatas);
}

if(count($varCopiedPhotos)>0){
$varCopiedDatas	= @join("\n",$varCopiedPhotos);
fwrite($varCopiedHandler,$varCopiedDatas);
}

fclose($varUncopiedHandler);
fclose($varCopiedHandler);
}
//UNSET OBJECT
unset($objDC);
?>
