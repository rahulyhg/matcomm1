<?php
#================================================================================================================
# Author 		: N. Dhanapal
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================

//FILE INCLUDES
include_once('includes/clsCommon.php');


//OBJECT DECLARTION
$objCommon = new Common;
$objCommon->clsTable			= 'photoinfo';

//Pagination codes here
$objCommon->clsCountField = "Photo_Id";
$objCommon->clsPrimary	  = array('Photo_Status');
$objCommon->clsPrimaryValue = array('0');
$varNoOfRecords = $objCommon->numOfResults();		
$varNoOfPages	= ceil($varNoOfRecords/$objCommon->clsLimit);
$varCurrentPage	= isset($_REQUEST['page'])?$_REQUEST['page']:1;
$objCommon->clsStart = ($varCurrentPage-1)*$objCommon->clsLimit;


#-------------------------------------------------------------------------------------------------------------------
#DELETE SELECTED PHOTOS
if ($_POST["frmAddedPhotoSubmit"]=="yes" && $_POST["action"]=="delete")
{
	$varphotoId					= $_REQUEST["photoId"];
	$varphotoName				= $_REQUEST["photoName"];
	$varGetMatriId				= split("_",$varphotoName);
	$varDeleteMatriId			= $varGetMatriId[0];
	$objCommon->clsPrimary		= array('Photo_Id');
	$objCommon->clsCountField	= 'Photo_Id';
	$objCommon->clsPrimaryValue	= array($varphotoId);
	$varFirstFolder				= substr($varDeleteMatriId,0,1);
	$varSecondFolder			= substr($varDeleteMatriId,1,1);
	$vaUnLinkFileName			= "../photo/images/".$varFirstFolder."/".$varSecondFolder."/".$varphotoName;
	$varDisplay					= $objCommon->deleteInfo();
	if($varDisplay == 'yes' && file_exists($vaUnLinkFileName))
		unlink($vaUnLinkFileName);
		
}//if

#-------------------------------------------------------------------------------------------------------------------
//CHECK THE MATRIID VALUE AND ACTION VALUE
if($_REQUEST['PhotoName'] !="" && $_REQUEST['action'] !="")
{
	$varAction						= $_REQUEST['action'];
	$varPhotoName					= $_REQUEST['PhotoName'];

//PUBLISH NEW PHOTO
	if($varAction == "publish")
	{
		$varMatriId = $_REQUEST['MatriId'];
		$varFirstFolder			=	substr($varMatriId,1,1);
		$varSecondFolder		=	substr($varMatriId,2,1);
		$varRelativePath		=	$confValues['PhotoURL'].'/membersphoto/'.$varFirstFolder."/".$varSecondFolder;
		$varOriginalPath		=	$confValues['PhotoURL'].'/membersphoto/'.$varFirstFolder."/".$varSecondFolder."/";
		$filePath = $varOriginalPath.$varPhotoName;
		$imgname = stripslashes($filePath);
		$path_array				=	split("\/",$imgname);
		$slash_count			=	count($path_array);
		$originalImage			=	$path_array[$slash_count-1];

		//Calculate Temp Path
		$tp_temp				=	explode("_",$path_array[$slash_count-1]);
		$digit					=	explode(".",$tp_temp[count($tp_temp)-1]);
		$thumbFile				=	$tp_temp[0]."_Thumb_Normal_".$digit[0].".jpg";
		$profileFile			=	$tp_temp[0]."_Thumb_Small_".$digit[0].".jpg";
		$fullFile				=	$tp_temp[0]."_Thumb_Big_".$digit[0].".jpg";

		$orgpath				= $varOriginalPath.$originalImage;
		$thumbpath				= $varOriginalPath.$thumbFile;
		$profilepath			= $varOriginalPath.$profileFile;
		$fullpath				= $varOriginalPath.$fullFile;
		//echo $filePath;
		//echo $originalImage;

		list($thumbWidth)		= @getimagesize("$thumbpath");
		list($profileWidth)		= @getimagesize("$profilepath");
		list($fullWidth)		= @getimagesize("$fullpath");

		if ($profileWidth < 1)
		{
			echo "<br><div class='smalltxt' width='500' align='center'><font color='red'>Profile cropping should de done before publish</font></div>";
		}
		elseif($fullWidth < 1)
		{
			echo "<br><div class='smalltxt' width='500' align='center'><font color='red'>Full cropping should de done before publish</font></div>";
		} 
		elseif($thumbWidth < 1)
		{
			echo "<br><div class='smalltxt' width='500' align='center'><font color='red'>Thumb cropping should de done before publish</font></div>";
		} 
		else
		{
			$oldthumbpath = $_SERVER['DOCUMENT_ROOT']."/membersphoto/".$varFirstFolder."/".$varSecondFolder."/".$thumbFile;
			$newthumbpath = $_SERVER['DOCUMENT_ROOT']."/membersphoto/".$varFirstFolder."/".$varSecondFolder."/".$originalImage;
			$thumbNormal = rename( $oldthumbpath, $newthumbpath );
			//echo $thumbNormal;
			$objCommon->clsTable		= "photoinfo";
			$objCommon->clsFields 		= array('Photo_Status','Thumb_Small_photo','Thumb_Big_photo');
			$objCommon->clsFieldsValues	= array('1',$profileFile,$fullFile);
			$objCommon->clsCountField	= 'Normal_Photo';
			$objCommon->clsPrimary      = array('Normal_Photo');
			$objCommon->clsPrimaryValue = array($varPhotoName);
			$objCommon->updateInfo();
			//echo "Ready for publish";
			//echo '$filePath';
		}
		//die;


	}
	//if
}//if
#-------------------------------------------------------------------------------------------------------------------
#SELECT ADDED PHOTOS
$objCommon->clsFields			= array('Photo_Id','MatriId','Normal_Photo','Description','Featured','Thumb_Small_Photo','Thumb_Big_Photo','Photo_Order','Photo_Status','Date_Updated');
$objCommon->clsPrimary			= array('Photo_Status');
$objCommon->clsCountField		= 'Photo_Status';
$objCommon->clsPrimaryValue		= array('0');

$varSelectPhotosList			= $objCommon->multiSelectInfo();

$varDisplayAddedPhotos ='';
for ($i=0;$i<count($varSelectPhotosList);$i++)
{
	
	$varPhotoId					= $varSelectPhotosList[$i]["Photo_Id"];
	$varMatriId					= $varSelectPhotosList[$i]["MatriId"];
	$varNormalPhoto				= $varSelectPhotosList[$i]["Normal_Photo"];

	$objCommon->clsTable		= "memberlogininfo";
	$objCommon->clsFields 		= array('User_Name','Email');
	$objCommon->clsPrimary      = array('MatriId');
	$objCommon->clsCountField	= 'MatriId';
	$objCommon->clsPrimaryValue = array($varMatriId);
	$objCommon->clsStart		= 0;
	$objCommon->clsLimit		= 1;
	$varSelectUserName			= $objCommon->selectinfo();

	$objCommon->clsTable		= "memberbasicinfo";
	$objCommon->clsFields 		= array('Gender');
	$varSelectGender			= $objCommon->selectinfo();
	$varGender					= $varSelectGender["Gender"]==1 ? "Male" : "Female";



	$varFolderName1				= substr($varMatriId,1,1);
	$varFolderName2				= substr($varMatriId,2,1);
	$varDisplayAddedPhotos		.= '<tr><td class="smalltxt">'.$varSelectUserName['User_Name'].'</td>';
	$varDisplayAddedPhotos		.= '<td class="smalltxt">'.$varGender.'</td>';
	$varDisplayAddedPhotos		.= '<td class="smalltxt">'.$varNormalPhoto.'</td>';
	$varDisplayAddedPhotos		.= '<td class="smalltxt"><a href="javascript: funViewPhoto(\'view-photo.php?f1='.$varFolderName1.'&f2='.$varFolderName2.'&img='.$varNormalPhoto.'\');" class=formlink1>View</a></td>';
	$varDisplayAddedPhotos		.= '<td class="smalltxt"><a href="cropping/cropinterface.php?type=loadimage&MatriId='.$varMatriId.'&croptype=thumbfolder&imgname='.$varNormalPhoto.'"  target="_blank" class=formlink1>Thumb</a>&nbsp;&nbsp;&nbsp;<a href="cropping/cropinterface.php?type=loadimage&MatriId='.$varMatriId.'&croptype=profilefolder&imgname='.$varNormalPhoto.'"  target="_blank" class=formlink1>Profile</a>&nbsp;&nbsp;&nbsp;<a href="cropping/cropinterface.php?type=loadimage&MatriId='.$varMatriId.'&croptype=fullfolder&imgname='.$varNormalPhoto.'"  target="_blank" class=formlink1>Full</a></td>';
	$varDisplayAddedPhotos		.= '<td class=smalltxt><a href=index.php?act=added-photos&MatriId='.$varMatriId.'&PhotoName='.$varNormalPhoto.'&action=publish class=formlink1>Publish</a>&nbsp;&nbsp;';
	$varDisplayAddedPhotos		.= '<td class="smalltxt"><a href="javascript: funDeletePhotoConfirm(\''.$varPhotoId.'\',\''.$varNormalPhoto.'\');" class=formlink1>Delete</a></td>';
	$varDisplayAddedPhotos		.= '</tr>';
}//for
?>
<script language="javascript" src="includes/admin.js" type="text/javascript"></script>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="600">
	<tr>
		<td>
			<div style="padding-left:7px;padding-top:5px;padding-bottom:0px;"><font class="heading">View Photo</div></td>
			<?if($varNoOfPages > 1){?>
			<td align="right">
			<div style="padding-left:7px;padding-top:5px;padding-bottom:0px;">
			<form name="frmAdmin" method="post">
				<input type="hidden" name="page" value="<?=$varCurrentPage?>">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
					<td class="normaltxt1"><?=$objCommon->pageNavigation($varNoOfRecords, $varCurrentPage, $varNoOfPages)?></td>
					</tr>
				</table>
			</form>
			</div>
			</td>
			<?}?>
	</tr>
</table><br>
<form name="frmAddedPhoto" method="post">
<input type="hidden" name="frmAddedPhotoSubmit" value="yes">
<input type="hidden" name="action" value="">
<input type="hidden" name="photoId" value="">
<input type="hidden" name="photoName" value="">
<table bgcolor="#FFFFFF" border="0" cellspacing="2" cellpadding="2" width="600">
	<tr>
		<td class="grtxt"><b>UserName</b></td>
		<td class="grtxt"><b>Gender</b></td>
		<td class="grtxt"><b>PhotoName</b></td>
		<td class="grtxt"><b>View</b></td>
		<td class="grtxt"><b>Crop</b></td>
		<td class="grtxt"><b>Publish</b></td>
		<td class="grtxt"><b>Delete</b></td>
	</tr>
	<tr><td colspan="6" height="5"></td></tr>
	<?=$varDisplayAddedPhotos?>
</table>
</form>