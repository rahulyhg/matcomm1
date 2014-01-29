<?
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/basefunctions.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/lib/clsAdminValMailer.php");
include_once($varRootBasePath."/lib/clsCropping.php");
//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new DB;
$objMasterDB		= new MemcacheDB;
$objCrop			= new Cropping;
$objAdminMailer		= new AdminValid;
$varSlaveConn		= $objSlaveDB->dbConnect('M', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
//print $varSlaveConn;
$arrAddPhoto		= array();
$arrDeletePhoto		= array();

$varAddCount			= 0;
$varDeleteCount			= 0;
$varAddPhotoList		= '';
$varDeletePhotoList		= '';
$varAddCount			= 0;
$varDelCount			= 0;

for ($i=1;$i<=50;$i++){
	if ($_POST['photoadddelete_'.$i] != ''){
		$arrPhotoDetail		= explode("_",$_POST['photoadddelete_'.$i]);
		$varPhotoDescStr	= $arrPhotoDetail[0].'_desc_'.$arrPhotoDetail[1];
		$varPhotoDescStr	= $_POST[$varPhotoDescStr];

		//SETING MEMCACHE KEY
		$varOwnProfileMCKey= 'ProfileInfo_'.$arrPhotoDetail[0];

		
		//get folder name
		$varFolderName			= $objAdminMailer->getFolderName($arrPhotoDetail[0]);
		$arrDomainDtls			= $objAdminMailer->getDomainDetails($arrPhotoDetail[0]);

		$varDomainPHPath		= $varRootBasePath."/www/membersphoto/".$varFolderName;	
		$varPhotoBupPath		= $varDomainPHPath."/backup/";
		$varPhotoCrop800		= $varDomainPHPath."/crop800/";
		$varPhotoCrop450		= $varDomainPHPath."/crop450/";
		$varPhotoCrop150		= $varDomainPHPath."/crop150/";
		$varPhotoCrop75			= $varDomainPHPath."/crop75/";
		//$varWatermark150 		= $varRootBasePath."/www/images/watermark150.png";
		//$varWatermark 			= $varRootBasePath."/www/images/watermark.png";
		$varWatermark150 		= $varRootBasePath."/www/images/watermark/".$varFolderName."_wm.png";
		$varWatermark 			= $varRootBasePath."/www/images/watermark/".$varFolderName."_wm.png";

		$varFields			= array('*');
		$varCondition		= "WHERE MatriId = '".$arrPhotoDetail[0]."'";
		$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
		$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
		if  ($arrPhotoDetail[2]=='add')  {
			$varPhotoUserPath	= $varDomainPHPath."/".$arrPhotoDetail[0]{3}."/".$arrPhotoDetail[0]{4}."/";
			$varPhotoBackupPath	= $varRootBasePath."/www/newphoto-backup/".$varFolderName.'/'.$arrPhotoDetail[0]{3}."/".$arrPhotoDetail[0]{4}."/";
			$varUnderValidation	= 0;
			$varValidation		= 0;
			$varPhotoNo			= 0;
			$varFileExt			= '';
			for ($k=1;$k<=10;$k++){
				if (($arrSelectPhotoInfo['Photo_Status'.$k] == 0 || $arrSelectPhotoInfo['Photo_Status'.$k]==2) && $arrSelectPhotoInfo['Thumb_Big_Photo'.$k] != '')
					$varUnderValidation++;
				elseif ($arrSelectPhotoInfo['Photo_Status'.$k] == 1)
					$varValidation++;
				if ($_REQUEST['imagename'.$i]== $arrSelectPhotoInfo['Thumb_Big_Photo'.$k]){
					$varPhotoNo		= $k;
					$varPhotoInfo	= split('\.', $arrSelectPhotoInfo['Thumb_Big_Photo'.$k]);
					$varFileExt		= $varPhotoInfo[1];
				}
			}
			
			if($varPhotoNo!=0 && $varFileExt!=''){	
			copy($varPhotoCrop75.$arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo], $varPhotoBackupPath.$arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo]);
			copy($varPhotoCrop150.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo],$varPhotoBackupPath.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo]);
			copy($varPhotoCrop450.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo],$varPhotoBackupPath.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo]);
						
			if(file_exists($varWatermark150)){
				$objCrop->funWaterImg($varPhotoCrop150.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo],$varWatermark150,$varPhotoCrop150.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo],$varFileExt);
			}
			
			if(file_exists($varWatermark)){
				$objCrop->funWaterImg($varPhotoCrop450.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo],$varWatermark,$varPhotoCrop450.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo],$varFileExt);
			}
			copy($varPhotoCrop75.$arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo],$varPhotoUserPath.$arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo]);
			copy($varPhotoCrop150.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo],$varPhotoUserPath.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo]);
			copy($varPhotoCrop450.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo],$varPhotoUserPath.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo]);
			
			unlink($varPhotoCrop75.$arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo]);
			unlink($varPhotoCrop150.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo]);
			unlink($varPhotoCrop450.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo]);
			@unlink($varPhotoCrop800.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo]);
			
			$varCondition		= " MatriId = '".$arrPhotoDetail[0]."'";
			$varFields			= array('Photo_Status'.$varPhotoNo, 'Description'.$varPhotoNo);
			$varFieldValues		= array(1,"'".addslashes($varPhotoDescStr)."'");
			$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);
			$varPending			= ($varUnderValidation > 1)? 1 : 0;
			$varValidationStatus	= ($varValidation >=1)? 1 : 0;
			$varFields			= array('Pending_Photo_Validation','Photo_Set_Status');
			$varFieldValues		= array($varPending,1);
			$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition, $varOwnProfileMCKey);	
			$varAddPhotoList	.= "<tr><td>".$arrPhotoDetail[0]."</td><td>".$arrPhotoDetail[1]."</td></tr>";

			//Request added intimation to user
			$objAdminMailer->dbConnect('M', $varDbInfo['DATABASE']);
			$objAdminMailer->requestAdded($arrPhotoDetail[0],1);

			$varAddCount++;
			}
		} elseif  ($arrPhotoDetail[2]=='del')  {

			for($j=1;$j<=10;$j++){
				if (trim($_REQUEST['imagename'.$i]) == trim($arrSelectPhotoInfo['Thumb_Big_Photo'.$j])){
					$varDelPhotoNo		= $j;
					break;
				}
			}

			$varDelThumbImg75	= $arrSelectPhotoInfo['Normal_Photo'.$varDelPhotoNo];
			$varDelThumbImg150	= $arrSelectPhotoInfo['Thumb_Small_Photo'.$varDelPhotoNo];
			$varDelOriginal450	= $arrSelectPhotoInfo['Thumb_Big_Photo'.$varDelPhotoNo];

			if (file_exists($varPhotoCrop800.$varDelOriginal450))
				unlink($varPhotoCrop800.$varDelOriginal450);
			if (file_exists($varPhotoCrop450.$varDelOriginal450))
				unlink($varPhotoCrop450.$varDelOriginal450);
			if (file_exists($varPhotoCrop150.$varDelThumbImg150))
				unlink($varPhotoCrop150.$varDelThumbImg150);
			if (file_exists($varPhotoCrop75.$varDelThumbImg75))
				unlink($varPhotoCrop75.$varDelThumbImg75);
			$varFields			= array();
			$varFiledValues		= array();
			$varThumbImg75 		= "Normal_Photo";
			$varDescription		= "Description";
			$varStatus 			= "Photo_Status";
			$varThumbImg150		= "Thumb_Small_Photo";
			$varOriginalImg450 = "Thumb_Big_Photo";
			for ($l=$varDelPhotoNo;$l<10;$l++){
				$varFields[] = $varThumbImg75.$l;
				$varFields[] = $varDescription.$l;
				$varFields[] = $varStatus.$l;
				$varFields[] = $varThumbImg150.$l;
				$varFields[] = $varOriginalImg450.$l;
				$varFiledValues[] = "'".$arrSelectPhotoInfo[$varThumbImg75.($l+1)]."'";
				$varFiledValues[] = "'".$arrSelectPhotoInfo[$varDescription.($l+1)]."'";
				$varFiledValues[] = "'".$arrSelectPhotoInfo[$varStatus.($l+1)]."'";
				$varFiledValues[] = "'".$arrSelectPhotoInfo[$varThumbImg150.($l+1)]."'";
				$varFiledValues[] = "'".$arrSelectPhotoInfo[$varOriginalImg450.($l+1)]."'";
			}
			$varFields[] = $varThumbImg75.'10';
			$varFields[] = $varDescription.'10';
			$varFields[] = $varStatus.'10';
			$varFields[] = $varThumbImg150.'10';
			$varFields[] = $varOriginalImg450.'10';
			$varFiledValues[] = "''";
			$varFiledValues[] = "''";
			$varFiledValues[] = 0;
			$varFiledValues[] = "''";
			$varFiledValues[] = "''";
			
				
			$varCondition		= " MatriId = '".$arrPhotoDetail[0]."'";
			$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);
			$varPhotoPending	= 0;
			$varMemPhotoStatus	= 0;
					
			for ($m=0;$m<=10;$m++){
				if($m!=$varDelPhotoNo && trim($arrSelectPhotoInfo['Thumb_Big_Photo'.$m])!= ''){
					if($arrSelectPhotoInfo['Photo_Status'.$m] == 0 || $arrSelectPhotoInfo['Photo_Status'.$m]==2){
						$varPhotoPending	= 1; 
					}elseif($arrSelectPhotoInfo['Photo_Status'.$m]==1 ||$arrSelectPhotoInfo['Photo_Status'.$m]==2){
					$varMemPhotoStatus	= 1;
					}
				}
			}
			
			$varFields			= array('Pending_Photo_Validation','Photo_Set_Status');
			$varFiledValues		= array($varPhotoPending,$varMemPhotoStatus);
			$varFormResult		= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFiledValues, $varCondition,$varOwnProfileMCKey);
			$varDeletePhotoList	.= "<tr><td>".$arrPhotoDetail[0]."</td><td>".$arrPhotoDetail[1]."</td></tr>";
			$varMailedCount		= $varMailedCount + 1;
			$varToEmail			= $objSlaveDB->getEmail($arrPhotoDetail[0]);
			$argSubject			= 'Your photo has been deleted from '.$arrDomainDtls['FROMADDRESS'];
			$argMessage			= $varDelReason;
			$varMailValue		= $objAdminMailer->sendNotifyEmail($varToEmail,$_POST['reason_'.$i],$argSubject,$arrPhotoDetail[0]);
			$varDelCount++;
		}
	}
}
include_once("adminheader.php"); 
?>
<style type="text/css">@import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<?
if ($varAddPhotoList != ''){
	echo '<font class="mediumtxt boldtxt clr3">Added Photos</font><br><table border=0  class="smalltxt" width="60%"><tr><td colspan="2"> <div class="vdotline1" style="float: left; width: 480px; margin-top: 5px;"></div></td></tr><tr class="mediumtxt boldtxt"><td> MatriId</td><td>Photo  Number</td></tr>'.$varAddPhotoList.'<tr  class="smalltxt boldtxt errortxt"><td>Total Added Photos</td><td>'.$varAddCount.'</td></tr></table><div class="vdotline1" style="float: left; width: 480px; margin-top: 5px;"></div><br clear=all>';
}
if ($varDeletePhotoList != '')
	echo '<font class="mediumtxt boldtxt clr3">Deleted Photos</font><br><table border=0  class="smalltxt"  width="60%"><tr><td colspan="2"> <div class="vdotline1" style="float: left; width: 480px; margin-top: 5px;"></div></td></tr><tr class="mediumtxt boldtxt" ><td> MatriId</td><td>Photo  Number</td></tr>'.$varDeletePhotoList.'<tr  class="smalltxt boldtxt errortxt"><td>Total Deleted Photos</td><td>'.$varDelCount.'</td></tr></table>';
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
unset($objCrop);
unset($objAdminMailer);
unset($objSlaveDB);
unset($objMasterDB);
?>