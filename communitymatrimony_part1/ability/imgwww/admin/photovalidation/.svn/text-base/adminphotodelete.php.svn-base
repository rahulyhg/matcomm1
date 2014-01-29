<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 04-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photodelete.php
#================================================================================================================
   # Description  : Delete the user photos
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

// OBJECT DECLARATION
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('M', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//Variables
//$varCookieLoginInfo	= funCookieInfo();
//$varMatriId		= 'C100003';
$varMatriId			= $_REQUEST['ID'];
$varDelPhotoNo		= $_REQUEST['DELPH'];

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];


if( trim($_REQUEST['action']) != '' && $_REQUEST['action'] == 'delete' && $varDelPhotoNo > 0 && $varDelPhotoNo <= 10) { // Displaying confirmation message starts.					
	$varCondition		= " WHERE MatriId = '".$varMatriId."'";
	$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);
	
	//$varTotRecords  =1;
	if ($varTotRecords == 1) {
		$varDelPhotoFile 	= "Thumb_Big_Photo".$varDelPhotoNo;
		$arrDeletePhotoInfo	= array();
		$varFields			= array("'".$varDelPhotoFile."'");
		$varDelResult		= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
		$arrDeletePhotoInfo = mysql_fetch_assoc($varDelResult);
		
		if (trim($arrDeletePhotoInfo[$varDelPhotoFile]) != '') {
			$varThumbImg75 	= "Normal_Photo";
			$varDescription = "Description";
			$varStatus 		= "Photo_Status";
			$varThumbImg150 = "Thumb_Small_Photo";
			$varOriginalImg450 = "Thumb_Big_Photo";
			//$varFields			= array("Normal_Photo".$varDelPhotoNo,"Description".$varDelPhotoNo,"Photo_Status".$varDelPhotoNo,"Thumb_Small_Photo".$varDelPhotoNo,"Thumb_Big_Photo".$varDelPhotoNo);
			//$varFiledValues		= array("''","''",'0',"''","''");
			//$varCondition		= " MatriId = '".$varMatriId."'";
			//$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);		
		}
		
		$arrPhotoInfo		= array();
		$varFields			= array('*');
		$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
		$arrPhotoInfo 		= mysql_fetch_assoc($varResult);
		$varDelThumbImg75	= $arrPhotoInfo['Normal_Photo'.$varDelPhotoNo];
		$varDelThumbImg150	= $arrPhotoInfo['Thumb_Small_Photo'.$varDelPhotoNo];
		$varDelOriginal450	= $arrPhotoInfo['Thumb_Big_Photo'.$varDelPhotoNo];
		$varDelOriginalStatus	= $arrPhotoInfo['Photo_Status'.$varDelPhotoNo];
		$varFields			= array();
		$varFiledValues		= array();		
		for ($i=$varDelPhotoNo;$i<=10;$i++){
			if ($i < 10 && $i != 10 ) {
				//print "<br>".$varThumbImg75.$i;
				array_push($varFields,$varThumbImg75.$i);
				array_push($varFields,$varDescription.$i);
				array_push($varFields,$varStatus.$i);
				array_push($varFields,$varThumbImg150.$i);
				array_push($varFields,$varOriginalImg450.$i);
				array_push($varFiledValues,"'".$arrPhotoInfo[$varThumbImg75.($i+1)]."'");
				array_push($varFiledValues,"'".$arrPhotoInfo[$varDescription.($i+1)]."'");
				array_push($varFiledValues,"'".$arrPhotoInfo[$varStatus.($i+1)]."'");
				array_push($varFiledValues,"'".$arrPhotoInfo[$varThumbImg150.($i+1)]."'");
				array_push($varFiledValues,"'".$arrPhotoInfo[$varOriginalImg450.($i+1)]."'");
			} else if ($i == 10) {
				//print "<br>".$varThumbImg75.$i;
				array_push($varFields,$varThumbImg75.'10');
				array_push($varFields,$varDescription.'10');
				array_push($varFields,$varStatus.'10');
				array_push($varFields,$varThumbImg150.'10');
				array_push($varFields,$varOriginalImg450.'10');
				array_push($varFiledValues,"''");
				array_push($varFiledValues,"''");
				array_push($varFiledValues,0);
				array_push($varFiledValues,"''");
				array_push($varFiledValues,"''");
			}
		}		
		$varCondition		= " MatriId = '".$varMatriId."'";
		$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);
		$varDomainPHPath	= $varRootBasePath.'/www/membersphoto/'.$varFolderName; 
		if ($varDelOriginalStatus == 0 || $varDelOriginalStatus == 2) {
			if (file_exists($varDomainPHPath."/crop800/".$varDelOriginal450))
				unlink($varDomainPHPath."/crop800/".$varDelOriginal450);
			if (file_exists($varDomainPHPath."/crop450/".$varDelOriginal450))
				unlink($varDomainPHPath."/crop450/".$varDelOriginal450);
			if (file_exists($varDomainPHPath."/crop150/".$varDelThumbImg150))
				unlink($varDomainPHPath."/crop150/".$varDelThumbImg150);
			if (file_exists($varDomainPHPath."/crop75/".$varDelThumbImg75))
				unlink($varDomainPHPath."/crop75/".$varDelThumbImg75);
		}elseif ($varDelOriginalStatus == 1){
			if (file_exists($varDomainPHPath."/".$varMatriId{3}."/".$varMatriId{4}."/".$varDelOriginal450))
				unlink($varDomainPHPath."/".$varMatriId{3}."/".$varMatriId{4}."/".$varDelOriginal450);
			if (file_exists($varDomainPHPath."/".$varMatriId{3}."/".$varMatriId{4}."/".$varDelThumbImg150))
				unlink($varDomainPHPath."/".$varMatriId{3}."/".$varMatriId{4}."/".$varDelThumbImg150);
			if (file_exists($varDomainPHPath."/".$varMatriId{3}."/".$varMatriId{4}."/".$varDelThumbImg75))
				unlink($varDomainPHPath."/".$varMatriId{3}."/".$varMatriId{4}."/".$varDelThumbImg75);
		}
		$varPhotoPending	= 0;
		$varMemPhotoStatus	= 0;
		$varPhotoCount		= 0;
		$varCondition		= " WHERE MatriId = '".$varMatriId."'";
		$varFields			= array('*');
		$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
		$arrPhotoInfo 		= mysql_fetch_assoc($varResult);
		for ($i=0;$i<=10;$i++){
			if (trim($arrPhotoInfo['Thumb_Big_Photo'.$i])!= '' && $arrPhotoInfo['Photo_Status'.$i] == 0){
				$varPhotoPending	= 1;
				$varPhotoCount++;
			}elseif (trim($arrPhotoInfo['Thumb_Big_Photo'.$i]) != '' && $arrPhotoInfo['Photo_Status'.$i] == 1){
				$varMemPhotoStatus	= 1;
				$varPhotoCount++;
			}
		}
		$varFields			= array('Pending_Photo_Validation','Photo_Set_Status');
		$varFiledValues		= array($varPhotoPending,$varMemPhotoStatus);
		$varCondition		= " MatriId = '".$varMatriId."'";
		$varFormResult2		= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFiledValues, $varCondition, $varOwnProfileMCKey);
	}	
}	
if ($varFormResult)
	echo 1;
else
	echo 0;	
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
unset($objSlaveDB);
unset($objMasterDB);
?>