<?php
#===============================================================================================================
# Author 		: Senthilnathan
# Project		: MatrimonyProduct
#===============================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");

$varMatriId			= $varGetCookieInfo['MATRIID'];
$varErrorType		= $_REQUEST['errortype'];
$varErrorMsg		= '';
if ($varMatriId != '' && $varErrorType != '') {
	switch ($varErrorType) {
		case 'horoscopesize' :
							$varErrorMsg	= "<font class=\"smalltxt\">Sorry, your file size should not be more than 300KB.</font>";
							break;
		case 'horoscopeerror' :
							$varErrorMsg	= 'Sorry, unable to upload horoscope file.Please try again';
							break;
		case 'horoscopeext' :
							$varErrorMsg	= "Please upload your horoscope in gif, jpg or jpeg format only.";
							break;
		case 'videodelete' :
							$varErrorMsg	= "Your photo has been successfully deleted";
							break;
		case 'videopwderr' :
							$varErrorMsg	= "Please Enter correct password";
							break;
		default	 :
							$varErrorMsg	= '';
							break;
	}
}
?>
<script>
function loc_chg(){
	window.location.href= "<?=$confValues['IMAGEURL']?>/horoscope/";
}
</script>
<div class="fleft">
	<div class="tabcurbg fleft">
		<div class="fleft">
			<div class="fleft tabclrleft"></div>
			<div class="fleft tabclrrtsw">
				<div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Add Horoscope</font></div>
			</div>
		</div>
	</div>
	<div class="fleft tr-3"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="41" /></div>
</div>
<!-- Content Area -->
<br>
<div class="middiv1">
	<div class="bl">
		<div class="br">
			<div class="middiv-pad1" id="middlediv">
			<!--Content-->
				<div style="padding: 5px 20px 30px 25px;" class="smalltxt" height="300" width="440px">
					<div class="mediumtxt boldtxt clr3">Horoscope Upload Error</div><br clear="all"/>
					<?=$varErrorMsg;?>
					<div style="padding:10px 2px 5px 0px;" class="fright"><input type="button" value="Back" class="button" onclick="loc_chg();"/></div>
				</div>
			<!--Content-->
			</div>	
		</div>
	</div>
</div>