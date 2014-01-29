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
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

$sessMatriId		= $_GET['ID'];
//object declaration
$objSlaveDB			= new DB;
$objMasterDB		= new DB;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
$arrChoice			= array(1,2,3,4,5,6,7,8,9,10);

if(isset($_REQUEST["CHOICE"]))
	$varChoice = $_REQUEST["CHOICE"];
 else 
	$varChoice = 0;
//$sessMatriId=$gender=$status=$validated=$entry_type="";
if( trim($_REQUEST['action']) != '' && $_REQUEST['action'] == 'change' && $varChoice > 0 && $varChoice <= 10) { // Displaying confirmation message starts.
		$varThumb75				= "Normal_Photo".$varChoice;
		$varDescription			= "Description".$varChoice;
		$varStatus 				= "Photo_Status".$varChoice;
		$varThumb150 			= "Thumb_Small_Photo".$varChoice;
		$varOriginal450			= "Thumb_Big_Photo".$varChoice;
		$arrSelectPhotoInfo		= array();
		$varFields				= array('*');
		$varCondition			= " WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
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
		
		if($error != TRUE && strlen($varChoice) > 0 && in_array($varChoice,$arrChoice))
			
		if(strlen($varThumbImg75) > 0 ){			
				$varFields			= array('Normal_Photo1','Description1','Photo_Status1','Thumb_Small_Photo1','Thumb_Big_Photo1',$varThumb75,$varDescription,$varStatus,$varThumb150,$varOriginal450);
				$varFiledValues		= array("'".$varCngThumbImg75."'","'".$varCngDescription."'","'".$varChangeStatus."'","'".$varCngThumb150."'","'".$varCngOriginalImg450."'","'".$varThumbImg75."'","'".$varDescrption1."'","'".$varPhotoStatus1."'","'".$varThumbImg150."'","'".$varOriginalImg450."'");
				$varCondition		= " MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
				$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);
				//$varString	= @gethostbyname($confValues['SERVERURL']."/login/updateprofilecookie.php?photo=1");
		}			
}
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
// Body Content Starts Here //
if ($varFormResult)
	echo "1~".$sessMatriId;
 else 
	echo 0;
?>