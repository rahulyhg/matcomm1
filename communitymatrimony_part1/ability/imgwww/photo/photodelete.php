<?php
#================================================================================================================
   # Author 		: Senthilnathan
   # Date			: 17-Apr-2009
   # Project		: MatrimonyProduct
   # Filename		: photodelete.php
#================================================================================================================
   # Description  : Delete the user photos
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

$varSubmit		= $_REQUEST['frmDeleteSubmit'];
$varMatriId		= $varGetCookieInfo['MATRIID'];
$varDelPhotoNo	= $_POST['PNO'];
$varCancel		= $_POST['cancel'];

if($varDelPhotoNo > 0 && $varDelPhotoNo <= 10 && $varSubmit == 'yes') {
	//OBJECT DECLARATION
	$objMasterDB		= new MemcacheDB;

	//CONNECTION DECLARATION
	$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;

	//VARIABLE DECLERAION
	
	$varPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];
	$varGender			= $varGetCookieInfo["GENDER"];
	$varMemberStatus 	= $varGetCookieInfo['STATUS'];
		
	$varCondition		= " WHERE MatriId = ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	$varTotRecords		= $objMasterDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varCondition);
	if ($varTotRecords == 1) {

		$varThumbImg75 		= "Normal_Photo";
		$varDescription		= "Description";
		$varStatus 			= "Photo_Status";
		$varThumbImg150		= "Thumb_Small_Photo";
		$varOriginalImg450	= "Thumb_Big_Photo";
				
		$varFields			= array('*');
		$varResult			= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
		$arrPhotoInfo 		= mysql_fetch_assoc($varResult);
		$varDelThumbImg75	= $arrPhotoInfo['Normal_Photo'.$varDelPhotoNo];
		$varDelThumbImg150	= $arrPhotoInfo['Thumb_Small_Photo'.$varDelPhotoNo];
		$varDelOriginal450	= $arrPhotoInfo['Thumb_Big_Photo'.$varDelPhotoNo];
		$varDelPhotoStatus	= $arrPhotoInfo['Photo_Status'.$varDelPhotoNo];
		
		$varFields			= array();
		$varFiledValues		= array();
		
		for ($i=$varDelPhotoNo;$i<10;$i++){
			$varFields[] = $varThumbImg75.$i;
			$varFields[] = $varDescription.$i;
			$varFields[] = $varStatus.$i;
			$varFields[] = $varThumbImg150.$i;
			$varFields[] = $varOriginalImg450.$i;
			$varFiledValues[] = "'".$arrPhotoInfo[$varThumbImg75.($i+1)]."'";
			$varFiledValues[] = "'".$arrPhotoInfo[$varDescription.($i+1)]."'";
			$varFiledValues[] = "'".$arrPhotoInfo[$varStatus.($i+1)]."'";
			$varFiledValues[] = "'".$arrPhotoInfo[$varThumbImg150.($i+1)]."'";
			$varFiledValues[] = "'".$arrPhotoInfo[$varOriginalImg450.($i+1)]."'";
		}
		
		$varFields[] = $varThumbImg75.'10';
		$varFields[] = $varDescription.'10';
		$varFields[] = $varStatus.'10';
		$varFields[] = $varThumbImg150.'10';
		$varFields[] = $varOriginalImg450.'10';
		$varFiledValues[]	= "''";
		$varFiledValues[]	= "''";
		$varFiledValues[]	= 0;
		$varFiledValues[]	= "''";
		$varFiledValues[]	= "''";
		
		$varCondition		= " MatriId = ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);
		
		$varDomainPHPath	= $varRootBasePath.'/www/membersphoto/'.$arrDomainInfo[$varDomain][2];
		if($varDelPhotoStatus == 0 || $varDelPhotoStatus == 2){
		if (file_exists($varDomainPHPath."/crop800/".$varDelOriginal450))
			unlink($varDomainPHPath."/crop800/".$varDelOriginal450);
		if (file_exists($varDomainPHPath."/crop450/".$varDelOriginal450))
			unlink($varDomainPHPath."/crop450/".$varDelOriginal450);
		if (file_exists($varDomainPHPath."/crop150/".$varDelThumbImg150))
			unlink($varDomainPHPath."/crop150/".$varDelThumbImg150);
		if (file_exists($varDomainPHPath."/crop75/".$varDelThumbImg75))
			unlink($varDomainPHPath."/crop75/".$varDelThumbImg75);
		if (file_exists($varDomainPHPath."/backup/".$varDelOriginal450) && $varCancel == 'yes')
			unlink($varDomainPHPath."/backup/".$varDelOriginal450);
		}

		if($varDelPhotoStatus==1 || $varDelPhotoStatus == 2){
			$varPhotoPath	= $varRootBasePath.'/www/membersphoto/'.$arrDomainInfo[$varDomain][2].'/'. $varMatriId{3}.'/'.$varMatriId{4}.'/';
			if (file_exists($varDomainPHPath."/crop800/".$varDelOriginal450))
				unlink($varDomainPHPath."/crop800/".$varDelOriginal450);
			if (file_exists($varDomainPHPath."/backup/".$varDelOriginal450))
				unlink($varDomainPHPath."/backup/".$varDelOriginal450);

			if (file_exists($varPhotoPath.$varDelOriginal450))
				unlink($varPhotoPath.$varDelOriginal450);
			if (file_exists($varPhotoPath.$varDelThumbImg150))
				unlink($varPhotoPath.$varDelThumbImg150);
			if (file_exists($varPhotoPath.$varDelThumbImg75))
				unlink($varPhotoPath.$varDelThumbImg75);
		}
		
		$varPhotoPending	= 0;
		$varMemPhotoStatus	= 0;
		for ($i=1;$i<=10;$i++){
			if($i!=$varDelPhotoNo && trim($arrPhotoInfo['Thumb_Big_Photo'.$i])!= ''){
				if($arrPhotoInfo['Photo_Status'.$i] == 0 || $arrPhotoInfo['Photo_Status'.$i]==2){
					$varPhotoPending	= 1; 
				}elseif($arrPhotoInfo['Photo_Status'.$i]==1 || $arrPhotoInfo['Photo_Status'.$i]==2){
				$varMemPhotoStatus	= 1;
				}
			}
		}

		$varFields			= array('Pending_Photo_Validation','Photo_Set_Status');
		$varFiledValues		= array($varPhotoPending,$varMemPhotoStatus);
		$varCondition		= " MatriId = ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		$varFormResult2		= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFiledValues, $varCondition, $varOwnProfileMCKey);
	}	

	if($varCancel == ''){
	$varDisplayMessage	= 'Photo deleted from profile successfully';
	//echo '<img src="'.$confValues['SERVERURL'].'/login/updateprofilecookie.php?photo=1" height="1" width="1">';

	echo $varDisplayMessage;
	}

	//UNSET OBJ
	$objMasterDB->dbClose();
	unset($objMasterDB);
}?>