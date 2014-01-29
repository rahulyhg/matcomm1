<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 04-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: addcropphoto.php
#================================================================================================================
   # Description	: This file used to add the cropped photo of the user.
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsCropping.php");

//OBJECT DECLARATION
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB;
$objCrop			= new Cropping;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//Variable Declaration
$sessMatriId		= $_REQUEST['ID'];

//SETING MEMCACHE KEY
$varOwnProfileMCKey = 'ProfileInfo_'.$sessMatriId;

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];
$varDomainPHPath	= $varRootBasePath."/www/membersphoto/".$varFolderName;	

$varPhotoBupPath	= $varDomainPHPath."/backup/";
$varPhotoCrop800	= $varDomainPHPath."/crop800/";
$varPhotoCrop450	= $varDomainPHPath."/crop450/";
$varPhotoCrop150	= $varDomainPHPath."/crop150/";
$varPhotoCrop75		= $varDomainPHPath."/crop75/";
$varDestinationPath	= $varDomainPHPath."/".$sessMatriId{3}."/".$sessMatriId{4}."/";
$varPhotoBackupPath	= $varRootBasePath."/www/newphoto-backup/".$varFolderName.'/'.$sessMatriId{3}."/".$sessMatriId{4}."/";
$varWatermark150 	= $varRootBasePath."/www/images/watermark/".$varFolderName."_wm.png";
$varWatermark 		= $varRootBasePath."/www/images/watermark/".$varFolderName."_wm.png";

$arrExt				= array();
$arrExt				= explode(".",$varImageName);
$varImgExt			= $arrExt[1];
$varNewName			= $arrExt[0];
$varError			= 0;
$varAction			= $_REQUEST["action"];
$varPhotoNo			= $_REQUEST['phnum'];
$userType			= $_REQUEST['usertype']; // added by iyyappan for branch users
$varImg75			= $_GET['photo75'];
$varImg150			= $_GET['photo150'];
$varImageName 		= $_GET['photo450'];

list($varPhotoWidth,$varPhotoHeight)	=	getimagesize($varPhotoBupPath.$varImageName);
if(isset($_REQUEST["photodesc"])){
	$varDescription = addslashes($_REQUEST["photodesc"]); 
	if(preg_match("/@/i",$varDescription))
		$varDescription = "";
} else 
$varDescription = "";

//Getting file extension type
$varPhotoInfo	= split('\.', $varImageName);
$varFileExt		= $varPhotoInfo[1];

//Moving to new photo back up directiory
if($userType ==3) {  // Added by iyyappan for branch admin users
	//copy($varImg75,$varPhotoCrop75.$varImg75);
	//copy($varImg150,$varPhotoCrop150.$varImg150);
	//copy($varImageName,$varPhotoCrop450.$varImageName);
	try { 
		copy ($varImageName,$varPhotoCrop450.$varImageName);
	} catch (Exception $varError){
		$varErrorMode	= 1;
	}

	if ($varPhotoWidth > 800 || $varPhotoHeight > 600) {
		try { 
			copy ($varImageName,$varPhotoCrop800.$varImageName);
		} catch (Exception $varError){
			$varErrorMode	= 1;
		}
	}
	try { 
		copy ($varImg75,$varPhotoCrop75.$varImg75);
	} catch (Exception $varError){
		$varErrorMode	= 1;
	}
	try { 
		copy ($varImg150,$varPhotoCrop150.$varImg150);
	} catch (Exception $varError){
		$varErrorMode	= 1;
	} 
} else {  // For support use
	//making watermark to 150,450 photos
	$objCrop->funWaterImg($varPhotoCrop150.$varImg150,$varWatermark150,$varPhotoCrop150.$varImg150,$varFileExt);
	$objCrop->funWaterImg($varPhotoCrop450.$varImageName,$varWatermark,$varPhotoCrop450.$varImageName,$varFileExt);

	copy($varPhotoCrop75.$varImg75,$varPhotoBackupPath.$varImg75);
	copy($varPhotoCrop150.$varImg150,$varPhotoBackupPath.$varImg150);
	copy($varPhotoCrop450.$varImageName,$varPhotoBackupPath.$varImageName);
	
	try { 
		copy ($varPhotoCrop450.$varImageName,$varDestinationPath.$varImageName);
		//$varAkamaiSync	= $varAkamaiPath."/".$varImageName;
		//system("perl /home/product/jain/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $varAkamaiSync");
		unlink($varPhotoCrop450.$varImageName);
	} catch (Exception $varError){
		$varErrorMode	= 1;
	}
	if ($varPhotoWidth > 800 || $varPhotoHeight > 600) {
		try { 
			copy ($varPhotoCrop800.$varImageName,$varDestinationPath.$varImageName);
			//$varAkamaiSync	= $varAkamaiPath."/".$varImageName;
			//system("perl /home/product/jain/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $varAkamaiSync");
			unlink($varPhotoCrop800.$varImageName);
		} catch (Exception $varError){
			$varErrorMode	= 1;
		}
	}
	try { 
		copy ($varPhotoCrop75.$varImg75,$varDestinationPath.$varImg75);
		//$varAkamaiSync	= $varAkamaiPath."/".$varImg75;
		//system("perl /home/product/jain/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $varAkamaiSync");
		unlink($varPhotoCrop75.$varImg75);
	} catch (Exception $varError){
			$varErrorMode	= 1;
	}
	try { 
		copy ($varPhotoCrop150.$varImg150,$varDestinationPath.$varImg150);
		//$varAkamaiSync	= $varAkamaiPath."/".$varImg150;
		//system("perl /home/product/jain/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $varAkamaiSync");
		unlink($varPhotoCrop150.$varImg150);
	} catch (Exception $varError){
			$varErrorMode	= 1;
	}
} 

if($userType==3) {  //For branch members
	$varFields			= array('Description'.$varPhotoNo,'Photo_Status'.$varPhotoNo,'Normal_Photo'.$varPhotoNo,'Thumb_Small_Photo'.$varPhotoNo,'Thumb_Big_Photo'.$varPhotoNo);
	$varFieldValues		= array("'".$varDescription."'",0,"'".$varImg75."'","'".$varImg150."'","'".$varImageName."'");
	$varCondition		= " MatriId =". $objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);
	if ($varFormResult && ($varAction =='add' || $varAction =='change' )){
		$varFields			= array('Pending_Photo_Validation','Photo_Set_Status');
		$varFieldValues		= array(0,0);
		$varFormResult		= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition, $varOwnProfileMCKey);
	}

	//MEMBERTOOL LOGIN
	$varMatriId = $sessMatriId;
	$varType  = 2;
	$varField = 0;
	$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
	$varnewCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';	escapeexec($varnewCmd,$varlogFile);	
			
} else {
	$varFields			= array('Description'.$varPhotoNo,'Photo_Status'.$varPhotoNo,'Normal_Photo'.$varPhotoNo,'Thumb_Small_Photo'.$varPhotoNo,'Thumb_Big_Photo'.$varPhotoNo);
	$varFieldValues		= array("'".$varDescription."'",1,"'".$varImg75."'","'".$varImg150."'","'".$varImageName."'");
	$varCondition		= " MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);
	if ($varFormResult && ($varAction =='add' || $varAction =='change' )){
		$varFields			= array('Pending_Photo_Validation','Photo_Set_Status');
		$varFieldValues		= array(0,1);
		$varFormResult		= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition, $varOwnProfileMCKey);
	
		//MEMBERTOOL LOGIN
		$varMatriId = $sessMatriId;
		$varType  = 2;
		$varField = 1;
		$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
		$varnewCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';	escapeexec($varnewCmd,$varlogFile);	
	
	
	}
}
$objMasterDB->dbClose();
$objSlaveDB->dbClose();
unset($objSlaveDB);
unset($objMasterDB);
?>