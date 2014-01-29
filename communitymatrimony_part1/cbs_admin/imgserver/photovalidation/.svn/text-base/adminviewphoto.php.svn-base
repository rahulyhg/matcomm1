<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: contacthistory.php
#================================================================================================================
   # Description	: photo class use to resize photo and new photoname
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new DB;
$objMasterDB		= new DB;

$varSlaveConn		= $objSlaveDB->dbConnect('S', 
$varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
//print $varSlaveConn;
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/usericons-sprites.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/useractions-sprites.css">
<body align="center">
<?
include_once("adminheader.php"); 
$phno		= $_REQUEST["num"];
$divno		= $_REQUEST["divno"];
$varMatriId = $_REQUEST['id'];


$arrQuality = array(1=>'BelowAverage', 2=>'Average', 3=>'Good Looking', 4=>'Very Beautiful');

if($_REQUEST['frmPhotoRank'] == "submit") {
  $varRankVal= $_REQUEST['photoRank'] > 0 ? $_REQUEST['photoRank'] : 0;
  $varFields = array('Photo_Quality'.$phno);
  $varFieldsValues = array($varRankVal);
  $varCondition		= " MatriId =".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
  $varUpdateId		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'],$varFields,$varFieldsValues,$varCondition);

  $cookValue	= $_COOKIE['reportid'];
  $arrFields	= array('comments');
  $arrFieldVals	= array("CONCAT(comments, '-".$phno."_ranked')");
  $varWhereCond	= 'id='.$objMasterDB->doEscapeString($cookValue,$objMasterDB);
  $objMasterDB->update('support_validation_report', $arrFields, $arrFieldVals, $varWhereCond);
  $varRankTxt	= $arrQuality[$_REQUEST['photoRank']] == '' ? 'nil' : $arrQuality[$_REQUEST['photoRank']];
  print '<script>window.opener.getRank('.$divno.',"'.$varRankTxt.'");parent.window.close();</script>';exit;
}

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varFields			= array('Normal_Photo'.$phno,'Photo_Quality'.$phno,'Thumb_Small_Photo'.$phno,'Thumb_Big_Photo'.$phno,'Description'.$phno);
$varCondition		= "WHERE MatriId =".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$varSelectPhotoInfo = mysql_fetch_assoc($varResult);

$cookValue	= $_COOKIE['reportid'];
$arrFields	= array('comments');
$arrFieldVals	= array("CONCAT(comments, '-".$phno."_viewed')");
$varWhereCond	= 'id='.$objMasterDB->doEscapeString($cookValue,$objMasterDB);;
$objMasterDB->update('support_validation_report', $arrFields, $arrFieldVals, $varWhereCond);

$varPhotoCrop150	= $varRootBasePath.'/www/membersphoto/'.$varFolderName.'/crop150/';
$varPhotoCrop75		= $varRootBasePath.'/www/membersphoto/'.$varFolderName.'/crop75/';
$varImgPHURL		= $confValues['IMAGEURL'].'/membersphoto/'.$varFolderName;
$varPhotoRank		= $varSelectPhotoInfo['Photo_Quality'.$phno];
?>
<table border="0" cellpadding="2" cellspacing="2">
<form name="PhotoRank">			
	<input type="hidden" name="id" id="id" value="<?=$varMatriId?>">
	<input type="hidden" name="num" id="num" value="<?=$phno?>">
	<input type="hidden" name="divno" id="divno" value="<?=$divno?>">
	<tr><td class="boldtxt clr1"><span style="padding-left:60px;" class="mediumtxt bld clr1">Photo Looking</span></td></tr>
	<tr><td class='mediumtxt'><span style="padding-left:60px;"></span><input type="radio" <?=($varPhotoRank == 1)?"checked":''?> name="photoRank" value="1">&nbsp;BelowAverage 
	<input type="radio" <?=($varPhotoRank == 2)?"checked":''?> name="photoRank" value="2">&nbsp;Average
	<input type="radio" <?=($varPhotoRank == 3)?"checked":''?> name="photoRank" value="3">&nbsp;Good Looking
	<input type="radio" <?=($varPhotoRank == 4)?"checked":''?> name="photoRank" value="4">&nbsp;Very Beautiful</td></tr>
	<tr><td><span style="padding-left:60px;"></span><input type="submit" name="frmPhotoRank" value="submit" class="button pntr"></td></tr>
</form>
</table>
<br><br>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="700">
	<tr>
		<td style="padding-left:60px;">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="700">
			<tr><td class='mediumtxt'>
			<? if(file_exists($varPhotoCrop75.$varSelectPhotoInfo['Normal_Photo'.$phno]) && (trim($varSelectPhotoInfo['Normal_Photo'.$phno]) != '')){?>
				 <img src="<?=$varImgPHURL;?>/crop75/<?=$varSelectPhotoInfo['Normal_Photo'.$phno]?>"> 
			<? } else { 
				echo " Image 75 * 75 not yet cropped";
			 } ?>
			<br><br><br clear="all">
			<? if(file_exists($varPhotoCrop150.$varSelectPhotoInfo['Thumb_Small_Photo'.$phno]) && (trim($varSelectPhotoInfo['Thumb_Small_Photo'.$phno]) != '')){?>
				<img src="<?=$varImgPHURL;?>/crop150/<?=$varSelectPhotoInfo['Thumb_Small_Photo'.$phno]?>">
			<? } else { 
				echo " Image 150 * 150 not yet cropped";
			 } ?>
			</td>
			<td></td>
			<td>
			<img src="<?=$varImgPHURL;?>/crop450/<?=$varSelectPhotoInfo['Thumb_Big_Photo'.$phno]?>"> 
			</td></tr>
			</table>
		</td>
	</tr>
	<tr><td height="15"></td></tr>
</table>
</body>

