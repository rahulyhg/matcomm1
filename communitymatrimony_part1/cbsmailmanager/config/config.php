<?php
//******************************************************************
// AUTHOR		: ASHOK KUMAR
// FILENAME		: CONFIG.PHP
// PROJECT		: CAMPAIGN ADMIN CONTROL MANAGEMENT
// DATE			: 21-06-2005
// DISCRIPTION	: Contains DB connection, Table, and general details
//******************************************************************

ob_start();

error_reporting(0);

//Default path settings...
$include_path = dirname(__FILE__);
//$doc_root = $_SERVER['DOCUMENT_ROOT'];
$MAILMANAGER_ROOTPATH = "/home/cbsmailmanager/";
include_once $MAILMANAGER_ROOTPATH."/bmconf/bmip.inc";
include_once $MAILMANAGER_ROOTPATH."/bmconf/bmdbinfo.inc";
include_once $MAILMANAGER_ROOTPATH."/bmconf/bmvars.inc";
include_once $MAILMANAGER_ROOTPATH."/bmconf/bminit.inc";
include_once $MAILMANAGER_ROOTPATH."/bmlib/bmsqlclass.inc";


//ini_set("display_errors","on");
//error_reporting(E_ALL);

//$dblink = new db();
//$dblink->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MAILSYSTEM']);

//print_r($dblink);
$dblink = new db();
$dblink->connect($DBCONIP['DB15'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['CBSMAILSYSTEM']);
//print_r($dblink);


// CBSMAILMANAGER TABLES ...
$tbl['adminuser']	 = "admininfo"; 
$tbl['mailer']		 = "emailtemplate";  // Templates
$tbl['mailunsubscribe'] = "mailunsubscribe";   // For Unsubscribe

//CBS MEMBERS TABLES...
$tbl['profile']		 = "mailerprofile";				// cbs members
$tbl['prcase1']		 = "mailerprcase1";				// cbs prcase 1 members
$tbl['prcase2']		 = "communitymatrimony.memberpartlyinfo";				// cbs prcase 2 members
$tbl['profiledel']	 = "communitymatrimony.memberdeletedinfo";		// cbs past members db - > matrimony
$tbl['inactive']	 = "matrimonymsinactive.tbl_inactive_mailer";

// BM MEMBERS TABLE... 
$tbl['bmprofile'] = "mailerprofile";				// members
$tbl['bmprcase1'] = "mailerprcase1";				// prcase 1 members
$tbl['bmprcase2'] = "mailerprcase2";				// prcase 2 members
$tbl['bmprofiledel'] = "matrimony.matrimonyprofiledel";		// past members db - > matrimony
$tbl['bminactive']="matrimonymsinactive.tbl_inactive_mailer";
$tbl['bmunsubscribe'] = "mailsubscribe";  // Unsubscribe mailers

// Months Details ...
$MON['01'] = "January";
$MON['02'] = "Feburary";
$MON['03'] = "March";
$MON['04'] = "April";
$MON['05'] = "May";
$MON['06'] = "June";
$MON['07'] = "July";
$MON['08'] = "August";
$MON['09'] = "September";
$MON['10'] = "October";
$MON['11'] = "November";
$MON['12'] = "Decemeber";

//array declaration...
include "/home/cbsmailmanager/config/arrhash.inc.php";

//common includes...
include_once "/home/cbsmailmanager/www/lib/functions.php";

/* $email_template_config_mailid= "sathish.prabu@bharatmatrimony.com,vijayakanth@bharatmatrimony.com,iyyappan.n@bharatmatrimony.com,prathap@bharatmatrimony.com,balajis@bharatmatrimony.com,arvind@bharatmatrimony.com,kalanithi@bharatmatrimony.com,sathishk@bharatmatrimony.com"; */
$email_template_config_mailid = "iyyappan.n@bharatmatrimony.com";
$ReportEmailids = "iyyappan.n@bharatmatrimony.com";

?>