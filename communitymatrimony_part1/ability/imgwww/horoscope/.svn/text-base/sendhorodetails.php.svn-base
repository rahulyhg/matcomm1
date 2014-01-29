<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: generateHoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/horoscope.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessGender		= $varGetCookieInfo["GENDER"];

//Object initialization
$objSlaveDB		= new DB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

$varCondition			= " WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varFields				= array('Horoscope_Available');
$varExecute				= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
$varResult	 			= mysql_fetch_assoc($varExecute);
$varHoroscopeAvailable	= $varResult['Horoscope_Available'];

$varAstrovisionURL	= 'http://www.astrovisiononline.com/BharathMatrimony';

$objSlaveDB->dbClose();
UNSET($objSlaveDB);
?>
<html>
	<title></title>
	<head>
			<script language="javascript">
			/////////
			//To alert user on page close
			/////////
			window.onbeforeunload = function (event) {
				var flagHid = document.getElementById('isPageLoaded');
				if(flagHid.value != "1") {
					//WHITE SPACE SPACE IS ADDED FOR ALIGNING THE TEXT IN CENTER
					var alert_text = "            Your horoscope is being generated.";
					var browser=navigator.appName;
					var bAgt = navigator.userAgent.toLowerCase();
					var is_opr = (bAgt.indexOf("opera") != -1);
					var is_msie = (bAgt.indexOf("msie") != -1) && document.all && !is_opr;
					var is_msie5 = (bAgt.indexOf("msie 5") != -1) && document.all && !is_opr;

					if(is_msie || is_msie5 ||!event) { event=window.event; }
					if(event) {
						if(is_msie || is_msie5) { event.returnValue=alert_text; }
						return alert_text;
					}
				}
			}
			/////

			function cleardis() {
				document.getElementById('dis').innerHTML="<font size=1><font face=Verdana, Arial, Helvetica, sans-serif><b>Disclaimer:</b> All astrological calculations are based purely on scientific equations and not on any specific published almanac.  Therefore we shall not be responsible for decisions that may be taken by anyone based on this report.</font>";
				window.print();
			}
			function hidediv() {
				var d = document.getElementById('mydiv');	
				d.style.display = "none";
				//Update page loaded status
				var flagHid = document.getElementById('isPageLoaded');
				flagHid.value = "1";
			}
			</script>
	</head>
<body>

<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<div class="fleft logodiv"><img src="<?=$confValues['IMGSURL']?>/logo/<?=$arrDomainInfo[$varDomain][2]?>_logo.gif" alt="<?=$confValues['PRODUCTNAME']?>" border="0"/></div><br clear="all">
<table border="0" cellpadding="0" cellspacing="0" width="610" bgcolor="#FFFFFF" height="100%">
	<tr><td>
	<?php
	//CHECK FOR COOKIE
	if((isset($sessMatriId))) { $varXMLData = trim($_GET["xdata"]); ?>

		<div id='mydiv'><center><br/><br/><img src='http://imgs.bharatmatrimony.com/bmimages/loading-icon.gif'><br/>

<? if($varHoroscopeAvailable==1 || $varHoroscopeAvailable==3){ ?>
	<font class='smalltxt'><b>Modified Horoscope</b><br/><br/>Your horoscope has been successfully modified. </font>

<? } else { ?>

	<font class='smalltxt'><b>Generate Horoscope</b><br/><br/>Your horoscope has been successfully created. It will be added to your profile in a few minutes.</font>

<? } ?><br/></center></div>
	<!------Hidden flag to hold the status of page load----->
	<input type="hidden" id="isPageLoaded" value="0"> 
	<iframe src="<?=$varAstrovisionURL?>/inserttolsdb.php?data=<?=urlencode($varXMLData)?>"   width='720' height='100%' frameborder=0 marginheight=0px marginwidth=0px scrolling=yes onLoad="javascript:hidediv();"></iframe>

<? } else { echo "<div class='smalltxt'>You are either logged off or your session timed out. <a href='http://".$confValues['SERVERURL']."/login/' target='_blank'>Click here</a> to login.</div>"; }
?>
</td>
</tr>
</table>
</body>
<script>
window.onbeforeunload = function (evt) {
  var message = 'Are you sure you want to leave?';
  if (typeof evt == 'undefined') { evt = window.event; }
  if (evt) {
	  window.opener.document.location.href='/horoscope/?act=addhoroscope';
	  window.close();
    //evt.returnValue = message;
  }

}
</script>
</html>
