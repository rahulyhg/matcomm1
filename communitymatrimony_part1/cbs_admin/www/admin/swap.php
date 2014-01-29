<?php
#================================================================================================================
# Author 		: Senthilnathan M
# Start Date	: 2007-03-16
# End Date		: 2007-03-16
# Project		: MatrimonyProduct
# Module		: PhotoManagement 
#================================================================================================================
//FILE INCLUDES
include_once('../includes/config.php');
include_once('../includes/dbConn.php');
include_once('includes/clsPhotoManagement.php');

//SESSION VARIABLES
$varMatriId	= $_REQUEST['MatriId'];

//OBJECT DECLARTION
$objPhotoManagement = new PhotoManagement;

//VARIABLE DECLARATION
$varChoice			= $_REQUEST['choice'];
$varSelectPhotoInfo	= array();

//SELECT PHOTO FIELDS --- STARTS HERE
$varArrPhoto1	= array('Normal_Photo1','Thumb_Small_Photo1','Thumb_Big_Photo1','Photo_Status1','Description1');
$varArrPhoto2	= array('Normal_Photo2','Thumb_Small_Photo2','Thumb_Big_Photo2','Photo_Status2','Description2');
$varArrPhoto3	= array('Normal_Photo3','Thumb_Small_Photo3','Thumb_Big_Photo3','Photo_Status3','Description3');

//COMBINE TWO ARRAYS FOR SELECT RECORDS
$varChangeFields	= $varChoice==2 ? array_merge($varArrPhoto1,$varArrPhoto2) : 																		array_merge($varArrPhoto1,$varArrPhoto3); 
$objPhotoManagement->clsPrimary			= array('MatriId');
$objPhotoManagement->clsPrimaryValue 	= array($varMatriId);
$objPhotoManagement->clsFields			= $varChangeFields;
$varSelectPhotoInfo	= $objPhotoManagement->selectPhoto();

//UPDATE PHOTO FIELDS --- STARTS HERE
$varArrPhotoFields1	= array($varSelectPhotoInfo['Normal_Photo1'], $varSelectPhotoInfo['Thumb_Small_Photo1'], 								$varSelectPhotoInfo['Thumb_Big_Photo1'], $varSelectPhotoInfo['Photo_Status1'], 									$varSelectPhotoInfo['Description1']);
$varArrPhotoFields2	= array($varSelectPhotoInfo['Normal_Photo2'], $varSelectPhotoInfo['Thumb_Small_Photo2'], 								$varSelectPhotoInfo['Thumb_Big_Photo2'], $varSelectPhotoInfo['Photo_Status2'], 									$varSelectPhotoInfo['Description2']);
$varArrPhotoFields3	= array($varSelectPhotoInfo['Normal_Photo3'], $varSelectPhotoInfo['Thumb_Small_Photo3'], 								$varSelectPhotoInfo['Thumb_Big_Photo3'], $varSelectPhotoInfo['Photo_Status3'], 									$varSelectPhotoInfo['Description3']);
//COMBINE TWO ARRAYS FOR UPDATE RECORDS
$varChangeFieldsValues	= $varChoice==2 ? array_merge($varArrPhotoFields2,$varArrPhotoFields1) : 																	array_merge($varArrPhotoFields3,$varArrPhotoFields1); 
$objPhotoManagement->clsFieldsValues	= $varChangeFieldsValues;
$varPhotoidold=$objPhotoManagement->updatePhoto();

//UNSET OBJECT
unset($objPhotoManagement);

#Redirect To View Page
?>
<script language="javascript"> document.location.href = "index.php?act=view&MatriId=<?=$varMatriId?>"; </script>
