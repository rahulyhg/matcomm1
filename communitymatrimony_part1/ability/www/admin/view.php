<?php
#===============================================================================================================
# Author 		: Senthilnathan M
# Start Date	: 2007-03-15
# End Date		: 2007-03-15
# Project		: MatrimonyProduct
# Module		: PhotoManagement - View Photo
#===============================================================================================================
//SESSION VARIABLES
$varMatriId	= $_REQUEST['MatriId'];
$sessPaidStatus	= $confValues["sessPaidStatus"];
//FILE INCLUDES
include_once('includes/clsPhotoManagement.php');

//OBJECT DECLARTION
$objPhotoManagement = new PhotoManagement;

//VARIABLE DECLARATION
$varTemplateFileName					= "templates/view.tpl"; //do change (template file)
$objPhotoManagement->clsPrimary			= array('MatriId');
$objPhotoManagement->clsPrimaryValue 	= array($varMatriId);

$varTemplateContent	= $objPhotoManagement->getContentFromFile($varTemplateFileName);
$varNoOfRows		= $objPhotoManagement->numOfResults();
if($varNoOfRows == 1)
{
	$objPhotoManagement->clsFields	= array('MatriId', 'Normal_Photo1', 'Photo_Status1', 'Normal_Photo2', 'Photo_Status2', 'Normal_Photo3', 'Photo_Status3', 'Photo_Date_Updated');
	$varPhotoInfoDetails	= $objPhotoManagement->selectPhoto();
	$varFolderName1			= substr($varMatriId,1,1);
	$varFolderName2			= substr($varMatriId,2,1);
	$varValidatedImagePath	= '../../membersphoto/'.$varFolderName1."/".$varFolderName2."/";
	$varValidatedPhotos		= 'no';
	$varValidatedPhotosCount= 0;
}
for($i=1;$i<=3;$i++)
{
	$varContentFrom1	= "<--Normal_Photo_".$i."-->";
	$varContentFrom2	= "<--Add_Edit_Link_".$i."-->";
	$varContentFrom3	= "<--Add_Edit_TEXT_".$i."-->";
	$varContentFrom4	= "<--Delete_".$i."-->";
	$varContentFrom5 	= "<--Photo_Status_".$i."-->";
	$varProtect			= "<--Protect-->";
	$varContentFrom6    = "<--MatriId-->";
	$ProfileId			= $varMatriId;
	if($varNoOfRows == 1)
	{
		$varFieldName1		= 'Normal_Photo'.$i;
		$varFieldName2		= 'Photo_Status'.$i;
		$varImageFile		= $varPhotoInfoDetails[$varFieldName1];
		$varPhotoStatus		= $varPhotoInfoDetails[$varFieldName2];
		if($varImageFile != '')
		{
			$varImagePath	= ($varPhotoStatus == 1)? $varValidatedImagePath : '../../pending-photos/';
			$varImage		= $varImagePath.$varImageFile;
			$varPageLink	= 'edit';
			$varLinkTxt		= 'Change Photo';
			$varDelLink		= 'index.php?act=delete&MatriId='.$varMatriId.'&choice='.$i;
			$varDelLink		= '<a href="'.$varDelLink.'" class="formlink1">Delete</a>';
			$varStatusText	= '';
			if($varPhotoStatus == 1)
			{
				$varValidatedPhotos = 'yes';
				$varValidatedPhotosCount++;
				if($i>1 && $varValidatedPhotosCount>1){
				$varStatusText		= '<a href="index.php?act=swap&MatriId='.$varMatriId.'&choice='.$i.'"><font class="formlink1">Make This Main 						Photo</font</a>';
				}
			}
			else
			{
				$varStatusText = 'Validation in process'; 
			}
		}
		else
		{
			$varImage		= '../../membersphoto/noimage.gif';
			$varPageLink	= 'add';
			$varLinkTxt		= 'Add Photo';
			$varDelLink		= '';
			$varStatusText	= '';
		}
	}				
	else
	{
		$varImage		= '../../membersphoto/noimage.gif';
		$varPageLink	= 'add';
		$varLinkTxt		= 'Add Photo';
		$varDelLink		= '';
		$varStatusText	= '';
	}
	
	$varTemplateContent	= str_replace($varContentFrom1,$varImage,$varTemplateContent);
	$varTemplateContent	= str_replace($varContentFrom2,$varPageLink,$varTemplateContent);
	$varTemplateContent	= str_replace($varContentFrom3,$varLinkTxt,$varTemplateContent);
	$varTemplateContent	= str_replace($varContentFrom4,$varDelLink,$varTemplateContent);
	$varTemplateContent	= str_replace($varContentFrom5,$varStatusText,$varTemplateContent);
	$varTemplateContent	= str_replace($varContentFrom6,$ProfileId,$varTemplateContent);

}//for

if($sessPaidStatus == 1 && $varValidatedPhotos == 'yes')
{
	$varProtectHtml	= '<table border="0" cellspacing="0" cellpadding="0" align="left">
						<tr><td height="17"><img src="images/trans.gif" width="4" height="1"><font class="registhead"><a href="protect.php" class="registhead" style=text-decoration:none;>Protect Photo</a></font></td><td align="right" valign="top"><img src="images/curve2.gif" alt="" width="27" height="17" border="0"></td></tr></table>';
}//if
else
{
	$varProtectHtml = '';
}
$varTemplateContent	= str_replace($varProtect,$varProtectHtml,$varTemplateContent);
echo $varTemplateContent;
?><br>