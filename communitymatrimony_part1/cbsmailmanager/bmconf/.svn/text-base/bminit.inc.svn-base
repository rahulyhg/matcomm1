<?php
/* ************************************************************************************************** */
/* File		: bminit.inc
/* Author	: Ashok kumar 
/* Date		: 10-Dec-2007
/* ************************************************************************************************** */
/* Description	: 
/*     This inc file is the initial include file at top of all the php files.
/*     It controls Error mode On/Off, Application mode On/Off
/*     Retrival of all set of cookies which is available as default into $COOKIEINFO array variable
/*     $ln value substitution
/* ************************************************************************************************** */

//header("Cache-Control: no-cache, must-revalidate");

// Error Reporting [On/Off] //
error_reporting(E_ALL^E_NOTICE); // Swtiched of Notice error alone

include_once("error.php"); /* yuva for erro reporting  */

// Application Control [On/Off] //
$APPLICATIONCONTROL = 0;  // if 0 -> ON , if 1 -> OFF

//constant declaration
define("SALT","MA");
define("SALT1","YliU");
define("SALT2","SID");

// Language version scripts - starts //  
$LANGVERSION = array ('ta'=>"Tamil",'hi'=>"Hindi",'te'=>"Telugu",'mr'=>"Marathi",'kn'=>"Kannada",'gu'=>"Gurajati",'ml'=>"Malayalam",'bn'=>"Bengali");  // Language version - Allowed Language version captions 
$LANGVERSIONPAGES = array ('quicksearch.php','dosearch.php','viewprofile.php','viewprofile_html.php','printprofile.php','regularsearch.php','ajaxlangversionrelcaste.php','smartsearch.php','smartdynamic.php','smartadvancesearchforlang.php'); // Language version - Allowed pages 

// Evaluating Language version pages //
$ln = 'en';
$default_lang = 0;
$basename = basename($_SERVER['SCRIPT_FILENAME']);
if ( in_array($basename, $LANGVERSIONPAGES) ) {
	// Get Parameter of language version //
	if (trim($_REQUEST['ln'])!='' && array_key_exists(trim($_REQUEST['ln']),$LANGVERSION)) {
		$ln = $_REQUEST['ln'];
		$default_lang = 1;
	}
}

// Cookie Retrival //
$COOKIEINFO = array();
getCookieInfo(); // Cookie retrival function called

// Function definations //

function getCookieInfo () {

	global $COOKIEINFO;

	// LoginInfo Cookie Retrival //
	if (isset($_COOKIE['LoginInfo']) && ($_COOKIE['LoginInfo'])!="") {
		$cookval = explode("&", $_COOKIE['LoginInfo']);

		list($x,$COOKIEINFO['LOGININFO']['MEMBERID'])  = explode("=",$cookval[0]);
		list($y,$COOKIEINFO['LOGININFO']['LANGUAGE'])	 = explode("=",$cookval[4]);
		list($y,$COOKIEINFO['LOGININFO']['MEMBERSHIPENTRY']) = explode("=",$cookval[2]);
		list($x,$COOKIEINFO['LOGININFO']['GENDER'])	 = explode("=",$cookval[3]);
		list($x,$COOKIEINFO['LOGININFO']['STATUS']) = explode("=",$cookval[5]);
		list($x,$COOKIEINFO['LOGININFO']['LASTLOGINDETAIL'])	 = explode("=",$cookval[6]);
		list($x,$COOKIEINFO['LOGININFO']['VALIDATESTATUS']) = explode("=",$cookval[7]);
		list($x,$COOKIEINFO['LOGININFO']['SESSID'])	 = explode("=",$cookval[8]);
		list($x,$COOKIEINFO['LOGININFO']['EDUCATION']) = explode("=",$cookval[9]);
		list($x,$COOKIEINFO['LOGININFO']['STATE']) = explode("=",$cookval[10]);
		list($x,$COOKIEINFO['LOGININFO']['CITY']) = explode("=",$cookval[11]);

		$memberid_encrypt_1 = crypt($COOKIEINFO['LOGININFO']['MEMBERID'], SALT1);
		$memberid_encrypt_2 = crypt($memberid_encrypt_1, SALT2);
		if (trim($memberid_encrypt_2) != trim($COOKIEINFO['LOGININFO']['SESSID'])) {
			$COOKIEINFO['LOGININFO']['MEMBERID'] = '';
		}
	}

	// Webnotify Cookie Retrival //
	if (isset($_COOKIE['WEBNOTIFY']) && ($_COOKIE['WEBNOTIFY'])!="") {
		$COOKIEINFO['WEBNOTIFY']['WEBNOTIFY'] = $_COOKIE['WEBNOTIFY'];
	}

	// Promonotify Cookie Retrival //
	if (isset($_COOKIE['PROMONOTIFY']) && ($_COOKIE['PROMONOTIFY'])!="") {
		$COOKIEINFO['PROMONOTIFY']['PROMONOTIFY'] = $_COOKIE['PROMONOTIFY'];
	}

	// fbuzz Cookie Retrival //
	if (isset($_COOKIE['FBUZZ']) && ($_COOKIE['FBUZZ'])!="") {
		$COOKIEINFO['FBUZZ']['FBUZZ'] = $_COOKIE['FBUZZ'];
	}

	// Savesearch Cookie Retrival //
	if (isset($_COOKIE['SaveSearch']) && ($_COOKIE['SaveSearch'])!="") {
		$COOKIEINFO['SAVESEARCH']['SAVESEARCH'] = $_COOKIE['SaveSearch'];
	}

	// MessageStats Cookie Retrival //
	if (isset($_COOKIE['MessageStats']) && ($_COOKIE['MessageStats'])!="") {
		$cookval = explode("&", $_COOKIE['MessageStats']);

		list($x,$COOKIEINFO['MESSAGESTATS']['NEWMESSAGES'])  = explode("=",$cookval[0]);
		list($y,$COOKIEINFO['MESSAGESTATS']['TOTALMESSAGES'])	 = explode("=",$cookval[1]);
		list($y,$COOKIEINFO['MESSAGESTATS']['NEWINTEREST']) = explode("=",$cookval[2]);
		list($x,$COOKIEINFO['MESSAGESTATS']['TOTALINTEREST'])	 = explode("=",$cookval[3]);
	}
}

?>