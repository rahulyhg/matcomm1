<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photoswap.php
#================================================================================================================
   # Description	: swap the photos
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];
$varGender			= $varGetCookieInfo["GENDER"];
$varMemberStatus 	= $varGetCookieInfo['STATUS'];

//object declaration
$objSlaveDB			= new DB;
$objMasterDB		= new DB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varChoice = $_REQUEST["CHOICE"];

if( trim($_REQUEST['actionval']) != '' && $_REQUEST['actionval'] == 'change' && $varChoice > 0 && $varChoice <= 10) { 
		$varThumb75				= "Normal_Photo".$varChoice;
		$varDescription			= "Description".$varChoice;
		$varStatus 				= "Photo_Status".$varChoice;
		$varThumb150 			= "Thumb_Small_Photo".$varChoice;
		$varOriginal450			= "Thumb_Big_Photo".$varChoice;
		$arrSelectPhotoInfo		= array();
		$varFields				= array('*');
		$varCondition			= " WHERE MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varResult				= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
		$arrSelectPhotoInfo 	= mysql_fetch_assoc($varResult);		
		
		$varCngThumbImg75		= $arrSelectPhotoInfo[$varThumb75];
		$varCngDescription		= $arrSelectPhotoInfo[$varDescription];
		$varChangeStatus   		= $arrSelectPhotoInfo[$varStatus];
		$varCngThumb150  		= $arrSelectPhotoInfo[$varThumb150];
		$varCngOriginalImg450	= $arrSelectPhotoInfo[$varOriginal450];
		$varThumbImg75			= $arrSelectPhotoInfo['Normal_Photo1'];
		$varDescrption1			= $arrSelectPhotoInfo['Description1'];
		$varPhotoStatus1 		= $arrSelectPhotoInfo['Photo_Status1'];
		$varThumbImg150 		= $arrSelectPhotoInfo['Thumb_Small_Photo1'];
		$varOriginalImg450		= $arrSelectPhotoInfo['Thumb_Big_Photo1'];
		
		if(strlen($varThumbImg75) == 0)	{
			$error_type = "find_photo";
			$error = TRUE;								
		}	
		
		if(strlen($varThumbImg75) > 0 ){			
				$varFields			= array('Normal_Photo1','Description1','Photo_Status1','Thumb_Small_Photo1','Thumb_Big_Photo1',$varThumb75,$varDescription,$varStatus,$varThumb150,$varOriginal450);
				$varFiledValues		= array("'".$varCngThumbImg75."'",$objMasterDB->doEscapeString($varCngDescription,$objMasterDB),"'".$varChangeStatus."'","'".$varCngThumb150."'","'".$varCngOriginalImg450."'","'".$varThumbImg75."'",$objMasterDB->doEscapeString($varDescrption1,$objMasterDB),"'".$varPhotoStatus1."'","'".$varThumbImg150."'","'".$varOriginalImg450."'");
				$varCondition		= " MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
				$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);
		}			
}

//UNSET OBJ
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
unset($objSlaveDB);
unset($objMasterDB);
?>