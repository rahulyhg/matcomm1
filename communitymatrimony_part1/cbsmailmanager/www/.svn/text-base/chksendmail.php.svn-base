<?php
/* ********************************************************************** */
/* Author	       : Ashok Kumar - Tech Team							  */
/* Filename	       : sendmail.php										  */
/* FileDescription : This file get executed in command as external program*/
/* ********************************************************************** */

// ************  DB config includes ***************** //
	include "/home/cbsmailmanager/config/config.php";
	ini_set("memory_limit","512M");

// ************* Starts - Assigning the input argument(parameter) values to variables ***************//
	$arg1     = trim($_SERVER['argv'][0]); // php filename itself
	$arg2     = trim($_SERVER['argv'][1]); // Email Concept Category
	$arg3     = trim($_SERVER['argv'][2]); // Email type [ test or live ]
	$arg4     = trim($_SERVER['argv'][3]); // Email Concept submit date 
	//$arg5     = trim($_SERVER['argv'][4]); // file write log name - tail 
	$argcount = trim($_SERVER['argc']);    // Count of arguments catched as input 
// ************* Ends - Assigning the input argument(parameter) values to variables *****************//


// *********** Start - validating the catched input parameters *********************************//
	if (strlen($arg2) != 0) {
		$maillist_filename = "/home/cbsmailmanager/mlistfiles/".$arg2.'mail.txt';
		$category = $arg2;
	} else {
		$maillist_filename = '';
		$category = '';
	}

	if (strlen($arg3) != 0) {
		$type = $arg3;
	} else {
		$type = '';
	}

	if (strlen($arg4) != 0) {
		$datesubmiton = $arg4;
	} else {
		$datesubmiton = '';
	}

	if ($argcount != 4) {
		$argcount = '';
	}
// *********** End - validating the catched input parameters *********************************//


// ********** Starts - Newsletter mail sending process ************************************** //

if ( ($maillist_filename != '') && ($category != '') && ($type != '') && ($datesubmiton != '') && ($argcount == 4) ) {

	// ********** Starts - Fetching the Email Template from database ******************** //
		$templsql = "select EmailFrom, Subject, BodyContent, ValidFlag from ".$tbl['mailer']." where Category = '$category' ";
		$templres = mysql_query ($templsql);
		$templrow = mysql_fetch_array ($templres);

		$emailfrom = $templrow['EmailFrom'];		// From email id
		$emailsubject = $templrow['Subject'];		// Subject of newsletter
		$emailtemplate = $templrow['BodyContent'];  // Content of newsletter
		$emailvalid = $templrow['ValidFlag'];       // Content of newsletter

		mysql_close ($dblink);
	// ********** Ends - Fetching the Email Template from database ******************** //


	// Checking wethere this email concept is Activated or Deactivated //
		if ($emailvalid != 1) {
			echo "Sorry, This email concept is in Deactivate Mode...!";
			exit;
		}

	// ********** Fetching the datas from mail concept file ************************** //
		$catgfile = "/home/cbsmailmanager/mfiles/".$category.".txt";
		$catgfp = fopen($catgfile, "r");
		$catgcont = fread($catgfp, filesize($catgfile));
		fclose($catgfp);
		$mailconfig = explode ("::", $catgcont);

		if ($type == 'test') {
			// ********** Sending newsletter mails to given test email id's ****************** //
			$maillist_filename = '/home/cbsmailmanager/mlistfiles/testmaillist.txt';
			$lines = file($maillist_filename);
		} elseif ($type == 'live') {
			// ********** Sending newsletter mails to real/live data email id's ************** //
			$lines = file($maillist_filename);
		}

		// Return Path setting...
		putenv("MAILUSER=webmaster"); 
		putenv("MAILHOST=mser1.communitymatrimony.com"); 

		$mailheaders  = "MIME-Version: 1.0\n";
		$mailheaders .= "From: $emailfrom\n";
		$mailheaders .= "Content-type: text/html\n"; 
		//$mailheaders .= "Reply-To: webmaster@bharatmatrimony.com\r\n";
		//$mailheaders .= "X-Mailer: PHP mailer\r\n";

		$countlog = 'countlog/'.$category.'.txt';
		
		$mailedcount = 0; // number of mails sent...
		$totalmailcount = count($lines); // Total number of mails...
		$sleepfor = 1000;
		$sleepat = $sleepfor; 

		foreach ($lines as $line_num => $line) {
		   
			$profileinfo = explode (",", $line);
			
			// *********** Place Holder Replacement happening here ************* //
			$templ = str_replace ("<<NAME>>", trim($profileinfo[2]), $emailtemplate);
			$templ = str_replace ("<<EMAIL>>", trim($profileinfo[1]), $templ);
			$templ = str_replace ("<<MATRIID>>", trim($profileinfo[3]), $templ);
			$templ = str_replace ("<<AGE>>", trim($profileinfo[4]), $templ);
			$templ = str_replace ("<<GENDER>>", trim($profileinfo[5]), $templ);
			$templ = str_replace ("<<PASSWORD>>", trim($profileinfo[6]), $templ);
			$templ = str_replace ("<<LANGUAGE>>", trim($profileinfo[7]), $templ);

			if (trim($profileinfo[3]) != '') {
				$mid = substr(trim($profileinfo[3]),0,1);
				$domainval = $domainhash[$mid];
				$templ = str_replace ("<<DOMAIN>>", $domainval, $templ);
			}

			if ($profileinfo[1] != '') {
				$mailedcount = $mailedcount + 1;
				$logit = $mailedcount.",".$profileinfo[0]."\n";
				logit ($countlog,'w',$logit);
			}

			if ($line_num == $sleepat ) {
				$sleepat = $sleepat + $sleepfor;
				if ($line_num != $totalmailcount) {
					sleep(30);
				}
			}
		
		}

		$maillog = date('Y-m-d H:i:s')."::".$category."::".($line_num+1)."::".$mailedcount."::".$mailconfig[1]."::".$mailconfig[2]."::".$mailconfig[3]."::".$mailconfig[4]."::".$mailconfig[5]."::".$mailconfig[6]."::".$mailconfig[7]."::".$mailconfig[8]."::".$mailconfig[9]."::".$mailconfig[10]."::".$mailconfig[11]."::".$mailconfig[12]."::".$mailconfig[13]."::".$mailconfig[14]."::".$mailconfig[15]."::".$mailconfig[16]."::".$mailconfig[17]."::".$mailconfig[18]."::".$mailconfig[19]."\n";
		$maillogfname = 'maillog/maillog.txt';

		// File open handler ....
		if (!$maillogfp = fopen($maillogfname, 'a+')) {
			echo "File open error...";
			exit;
		}
		if (fwrite($maillogfp, $maillog) === FALSE) {
		   echo "File write error...";
		   exit;
		}
		fclose($maillogfp);
}

function logit ($filename,$method,$logit) {
	if (!$fp = fopen($filename, $method)) {
	}
	if (flock($fp, LOCK_EX)) { // do an exclusive lock
	   fwrite($fp, $logit);
	   flock($fp, LOCK_UN); // release the lock
	} else {
	  // echo "Couldn't lock the file !";
	}	
	fclose($fp);
}

// ******** Ends - Newsletter mail sending process **************************** //

?>