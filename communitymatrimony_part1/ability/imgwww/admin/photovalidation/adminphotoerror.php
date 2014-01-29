<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photoerror.php
#================================================================================================================
   # Description	: show the photo error
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");

//SESSION VARIABLES
$sessMatriId		= $_REQUEST['MATRIID'];
$varErrorType		= $_REQUEST['errortype'];
$varErrorMsg		= '';
$divsize			= '120';
if ($sessMatriId != '' && $varErrorType != '') {
	switch ($varErrorType) {
		case 'imagesize' :
							
							$varErrorMsg	= "<font class=\"smalltxt\">Please note that the size of the image you are adding is <b> ".$_REQUEST['imagesize']." </b> KB. The maximum image size allowed is ".(($confValues['PHOTOMAXSIZE'])/1024)." KB. Please reduce the image size and add again.</font>";
							$divsize	= '160';
							break;
		
		case 'imageerror' :
							$varErrorMsg	= 'Photo has not been received, please send the image of your photo along with the Matrimony ID & Password to <a href=\"mailto:photo@jainmatrimony.com\">photo@jainmatrimony.com</a>';
							break;
		
		case 'imageext' :
							$varErrorMsg	= "Please add photos in jpg or gif formats.";
							break;
		
		case 'imagelength' :
							$varErrorMsg	= "Please add photos height and width are more than 75px.";
							break;
		
		case 'imagedelete' :
							$varErrorMsg	= "Your photo has been successfully deleted";
							break;
		default	 :
							$varErrorMsg	= '';
							break;
	}
?>
	<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
	<style type="text/css">
	</style>
	<div width="440px" height="180" class="smalltxt" style="padding-left:25px;padding-top:5px;padding-bottom:30px;padding-right:20px;">
	<div class="mediumtxt boldtxt clr3">Add Photo</div><br clear="all">
	<div class="divborder"  style="padding: 10px 0px 10px 10px;">
	<?=$varErrorMsg; ?>
	<div class="fright" style="padding-right:2px;padding-top:2px;padding-bottom:5px;display:block" ><input type="button" class="button" name="addphotos"  value="Manage Photos"onClick="javascript:window.location='adminmanagephoto.php?MATRIID=<?=$sessMatriId;?>';">
	</div><br clear="all">
	</div>
	<div class="fright">
	</div></div>
<?
}
?>