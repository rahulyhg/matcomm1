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
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new DB;
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
//print $varSlaveConn;
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/usericons-sprites.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/useractions-sprites.css">
<?
include_once("adminheader.php"); 
if(isset($_REQUEST["num"])){
	$phno = $_REQUEST["num"];
} 
$varMatriId = $_GET['id'];

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varFields			= array('Normal_Photo'.$phno,'Thumb_Small_Photo'.$phno,'Thumb_Big_Photo'.$phno,'Description'.$phno);
$varCondition		= "WHERE MatriId = '".$varMatriId."'";
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$varSelectPhotoInfo = mysql_fetch_assoc($varResult);

$varPhotoCrop150	= $varRootBasePath.'/www/membersphoto/'.$varFolderName.'/crop150/';
$varPhotoCrop75		= $varRootBasePath.'/www/membersphoto/'.$varFolderName.'/crop75/';
$varImgPHURL		= $confValues['IMGURL'].'/membersphoto/'.$varFolderName;
?>
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

