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
include_once($varRootBasePath."/conf/emailsconfig.inc");


//SESSION VARIABLES
$sessMatriId		= $_REQUEST['MATRIID'];
$varErrorType		= $_REQUEST['errortype'];
$varErrorMsg		= '';
$divsize			= '120';
if ($sessMatriId != '' && $varErrorType != '') {
	switch ($varErrorType) {
		case 'imagesize' :
							
							$varErrorMsg	= "<font class=\"smalltxt\">Please note that the size of the horoscope you are adding is <b> ".$_REQUEST['imagesize']." </b> KB. The maximum image size allowed is ".(($confValues['HOROSCOPEMAXSIZE'])/1024)." KB. Please reduce the image size and add again.</font>";
							$divsize	= '160';
							break;
		
		case 'imageerror' :
							$varErrorMsg	= 'Horoscope has not been received, please send the image of your horoscope along with the Matrimony ID & Password to <a href=\"mailto:'.$arrEmailsList["HOROSCOPEMAIL"].'\">'.$arrEmailsList["HOROSCOPEMAIL"].'</a>';
							break;
		
		case 'imageext' :
							$varErrorMsg	= "Please add horoscope in jpg or gif formats.";
							break;
		
		case 'imagedelete' :
							$varErrorMsg	= "Your horoscope has been successfully deleted";
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
	<div class="mediumtxt boldtxt clr3">Add Horoscope</div><br clear="all">
	<div class="divborder"  style="padding: 10px 0px 10px 10px;">
	<?=$varErrorMsg; ?>
	<div class="fright" style="padding-right:2px;padding-top:2px;padding-bottom:5px;display:block" ><input type="button" class="button" name="addphotos"  value="Manage Horoscope"onClick="javascript:window.location='adminmanagehoroscope.php?MATRIID=<?=$sessMatriId;?>';">
	</div><br clear="all">
	</div>
	<div class="fright">
	</div></div>
<?
}
?>