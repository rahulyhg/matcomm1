<?
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/lib/clsAdminValMailer.php");
include_once($varRootBasePath."/lib/clsCropping.php");
//SESSION VARIABLES
$varCookieInfo			= $_COOKIE["adminLoginInfo"];
if (isset($varCookieInfo))
{
	$varCookieInfo	= split("=",str_replace("&","=",$varCookieInfo));
	$confUserType	= $varCookieInfo[1];
	$adminUserName	= $varCookieInfo[2];
}//if

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

$varDeleteCount			= 0;
$varAddPhotoList		= '';
$varDeletePhotoList		= '';
$varAddCount			= 0;
$varDelCount			= 0;

$varDelDet	= '';
$varAddDet	= '';
for ($i=1;$i<=10;$i++){
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
		$varCondition		= "WHERE MatriId =".$objSlaveDB->doEscapeString($arrPhotoDetail[0],$objSlaveDB);
		$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
		$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
		if  ($arrPhotoDetail[2]=='add') {
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

				/*$varAkamaiPath	= $confValues['IMGURL']."/membersphoto/".$varFolderName.'/'.$arrPhotoDetail[0]{3}."/".$arrPhotoDetail[0]{4};
				$varAkamaiSync	= $varAkamaiPath."/".$arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo];
				system("perl /home/product/jain/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $varAkamaiSync");
				$varAkamaiSync	= $varAkamaiPath."/".$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo];
				system("perl /home/product/jain/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $varAkamaiSync");
				$varAkamaiSync	= $varAkamaiPath."/".$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
				system("perl /home/product/jain/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $varAkamaiSync");*/

				unlink($varPhotoCrop75.$arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo]);
				unlink($varPhotoCrop150.$arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo]);
				unlink($varPhotoCrop450.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo]);
				@unlink($varPhotoCrop800.$arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo]);

				$varPending	= ($varUnderValidation > 1)? 1 : 0;
				$varValidationStatus = ($varValidation >=1)? 1 : 0;
				if($confUserType==3) {
					$varPending	= 1;
					$varValidationStatus = 1;
				}
				$varCondition		= " MatriId = ".$objMasterDB->doEscapeString($arrPhotoDetail[0],$objMasterDB);
				$varFields			= array('Photo_Status'.$varPhotoNo, 'Description'.$varPhotoNo);
				$varFieldValues		= array(1,$objMasterDB->doEscapeString($varPhotoDescStr,$objMasterDB));
				$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);
				$varFields			= array('Pending_Photo_Validation','Photo_Set_Status');
				$varFieldValues		= array($varPending,1);
				$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition, $varOwnProfileMCKey);
				$varAddPhotoList	.= "<tr><td>".$arrPhotoDetail[0]."</td><td>".$arrPhotoDetail[1]."</td></tr>";

				//MEMBERTOOL LOGIN
				$varMatriId = $arrPhotoDetail[0];
				$varType  = 2;
				$varField = 1;
				$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
				$varnewCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';	escapeexec($varnewCmd,$varlogFile,1);

				if($confUserType!=3) {
					//Request added intimation to user
					$objAdminMailer->dbConnect('M', $varDbInfo['DATABASE']);
					$objAdminMailer->requestAdded($arrPhotoDetail[0],1);
				}
				$varAddCount++;
			}
			$varAddDet .= $varPhotoNo.',';
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


			$varCondition		= " MatriId = ".$objMasterDB->doEscapeString($arrPhotoDetail[0],$objMasterDB);
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
			
			//MEMBERTOOL LOGIN
			$varMatriId = $arrPhotoDetail[0];
			$varType  = 2;
			$varField = $varMemPhotoStatus;
			echo system('php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField) ); 
			
			
			$varMailedCount		= $varMailedCount + 1;
			$varToEmail			= $objSlaveDB->getEmail($arrPhotoDetail[0]);
			$argSubject			= 'Your photo has been deleted from '.$arrDomainDtls['FROMADDRESS'];
			$argMessage			= $varDelReason;
			$varMailValue		= $objAdminMailer->sendNotifyEmail($varToEmail,$_POST['reason_'.$i],$argSubject,$arrPhotoDetail[0]);
			$varDelCount++;

			$varDelDet .= $varDelPhotoNo.'_'.addslashes($_POST['reason_'.$i]).',';
		}
	}
}

$varTotCont		= '';
$varTotCont		= (trim($varAddDet, ',')!='') ? 'Added-'.trim($varAddDet, ',') : '';
$varTotCont		.= (trim($varDelDet, ',')!='') ? '&Deleted-'.trim($varDelDet, ',') : '';
$cookValue		= $_COOKIE['reportid'];
$arrFields		= array('comments', 'validateddate','profilestatus','notifycustomer');
$arrFieldVals	= array("CONCAT(comments, '-validated(".$varTotCont.")')", 'NOW()', "'".$varAddCount."'", "'".$varDelCount."'");
$varWhereCond	= 'id='.$cookValue;
$objMasterDB->update('support_validation_report', $arrFields, $arrFieldVals, $varWhereCond);

$objSlaveDB->dbClose();
$objMasterDB->dbClose();
unset($objCrop);
unset($objAdminMailer);
unset($objSlaveDB);
unset($objMasterDB);

if($_POST['bymatriid']!=''){
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<body >
<?include_once("adminheader.php");?>
<a name="top"></a>
<div style="padding-left:20px;"><div style="padding-bottom:10px;"><font class="mediumtxt boldtxt clr3">Photo Validated</font></div>
<div style="float:left; width:492px;border:1px solid #D3D3D3;" class="smalltxt">	
	<div style="padding: 20px;">
	<div style="text-align:left;" class="smalltxt">
		Congrats! You have successfully validated.<br></div>	
		<div class="fright"><input type="button" class="button" name="addphotos"  value="Close" onClick="javascript:parent.window.close();">
</div><br clear="all">
</div>
<?
exit;
}else{
	header("Location:".$confValues['IMAGEURL'].'/admin1/photovalidation/shuffled_photovalidation.php');exit;
}
?>