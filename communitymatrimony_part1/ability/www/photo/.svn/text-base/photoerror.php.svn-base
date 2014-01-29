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
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION VARIABLES
$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varErrorType		= $_REQUEST['errortype'];
$varErrorMsg		= '';
$divsize			= '120';
if ($sessMatriId != '' && $varErrorType != '') {
	switch ($varErrorType) {
		case 'imagesize' :
							
							$varErrorMsg	= 'If you face difficulties in adding a photograph, please send the image to <a class="clr1" href=mailto:'.$arrEmailsList['PHOTOMAIL'].'>'.$arrEmailsList['PHOTOMAIL'].'</a> with your matrimony ID and we will add it for you.';
							$divsize	= '160';
							break;
		
		case 'imageerror' : 
							$varErrorMsg	= 'Photo has not been received, please send the image of your photo along with the Matrimony ID & Password to <a class="clr1" href=mailto:'.$arrEmailsList['PHOTOMAIL'].'>'.$arrEmailsList['PHOTOMAIL'].'</a>';
							break;
		
		case 'imageext' :
							$varErrorMsg	= "Please add photos in jpg or gif formats.";
							break;
		
		case 'imagelength' :
							$varErrorMsg	= "Please add photos height and width are more than 75px.";
							break;
		
		default	 :
							$varErrorMsg	= '';
							break;
	}
}
?>
<script>
function loc_chg(){
	window.location.href= "<?=$confValues['IMAGEURL']?>/photo/";
}
</script>

<div class="rpanel fleft">
	<div class="clr3 brdr smalltxt bld pad10" style="background-color:#efefef;">Photo Upload Error</div><br clear="all"/>
	<?=$varErrorMsg;?>
	<div style="padding:10px 2px 5px 0px;" class="fright"><input type="button" value="Back" class="button" onclick="loc_chg();"/></div>
</div>
				