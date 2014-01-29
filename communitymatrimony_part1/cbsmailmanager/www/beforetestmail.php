<?php
/* ********************************************************************** */
/* Author	       : Ashok Kumar - Tech Team							  */
/* Filename	       : sendmail.php										  */
/* FileDescription : This file get executed in command as external program*/
/* ********************************************************************** */

// ************  DB config includes ***************** //
	include "/home/cbsmailmanager/config/config.php";
	require("smtp.php");
	ini_set("memory_limit","512M");

// ************* Starts - Assigning the input argument(parameter) values to variables ***************//
	$arg1     = trim($_SERVER['argv'][0]); // php filename itself
	$arg2     = trim($_SERVER['argv'][1]); // Email Concept Category
	$arg3     = trim($_SERVER['argv'][2]); // Email type [ test or live ]
	$arg4     = trim($_SERVER['argv'][3]); // Email Concept submit date
	$arg5     = trim($_SERVER['argv'][4]); // Mail priority
	$argcount = trim($_SERVER['argc']);    // Count of arguments catched as input
 // ************* Ends - Assigning the input argument(parameter) values to variables *****************//


// *********** Start - validating the catched input parameters *********************************//
	if (strlen($arg2) != 0) {
 		$category = $arg2;
	} else {
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
	if (strlen($arg5) != 0) {
		$priority = $arg5;
	} else {
		$priority = '';
	}
	if ($argcount != 5) {
		$argcount = '';
	}
// *********** End - validating the catched input parameters *********************************//


// ************* Starts - Newsletter mail sending process *********************************** //
		 
if (($category != '') && ($type != '') && ($datesubmiton != '') ) {

	// ********** Starts - Fetching the Email Template from database ******************** //
		$templsql = "select EmailFrom,ReplyTo,Subject,BodyContent,ValidFlag from ".$tbl['mailer']." where Category = '$category' ";
		$templres = mysql_query ($templsql);
		$templrow = mysql_fetch_array ($templres);
 		$emailfrom = $templrow['EmailFrom'];		// From email id
		$replyto = $templrow['ReplyTo'];		    // ReplyTo Email Id
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

		if ($type == 'beforetest') {
			// ********** Sending newsletter mails to given test email id's ****************** //
			$maillist_filename = '/home/cbsmailmanager/mlistfiles/beforetestmaillist.txt';
			$lines = file($maillist_filename);
		} elseif ($type =='aftertest'){
			$maillist_filename = '/home/cbsmailmanager/mlistfiles/creativeteam.txt';
			$lines = file($maillist_filename);
        } elseif ($type == 'othertest'){
			$maillist_filename = "/home/cbsmailmanager/mlistfiles/otherstest_".date('dMy').".txt";
			$lines = file($maillist_filename);
		}

		// Return Path setting...
		$emailexp=stripos($emailfrom, 'communitymatrimony.com');		
		//if(!empty($emailexp) || $emailexp!=''){
			putenv("MAILUSER=noreply");
			putenv("MAILHOST=bounces.communitymatrimony.com");
			$sender = "info@communitymatrimony.com";
			$mailertyp="smtpmtd";
		//}
		/* else{
			putenv("MAILUSER=noreply");
			putenv("MAILHOST=bounces.bharatmatrimony.com");
			$sender = "Bharatmatrimony.com<info@bharatmatrimony.com>";
			$mailertyp="mailmtd";
		} */

		$mailheaders  = "MIME-Version: 1.0\n";
		$mailheaders .= "From: $emailfrom\n";
		$mailheaders .= "Content-type: text/html\n";
		$mailheaders .= "Sender: $sender\n";
		$mailheaders .= "Reply-To: $replyto\n";
		$mailheaders .= "X-Priority: 2\n";
		$mailheaders .= "X-Mailer: PHP mailer\n";

		$countlog = 'countlog/'.$category.'.txt'; 

		$mailedcount = 0; // number of mails sent...
		$totalmailcount = count($lines); // Total number of mails...
		$sleepfor = 1000; // Sleep of mail execution for every 1000 th mail sent and to start next set...
		$sleepat = $sleepfor; // every 1000 th counting... ( 1000, 2000, etc )
if ($type == 'beforetest') {
	//emailtempconfig($category,$emailfrom,$replyto,$emailsubject);
	foreach ($lines as $line_num => $line) {
			$profileinfo = explode (",", $line);
			// *********** Place Holder Replacement happening here ************* //
			$templ = str_replace ("<<NAME>>", trim($profileinfo[2]), $emailtemplate);
			$templ = str_replace ("<<EMAIL>>", trim($profileinfo[1]), $templ);
			$templ = str_replace ("<<MATRIID>>", trim($profileinfo[3]), $templ);
			$templ = str_replace ("<<ENCRYPTID>>", base64_encode(trim($profileinfo[3])), $templ);
			$templ = str_replace ("<<AGE>>", trim($profileinfo[4]), $templ);
			$templ = str_replace ("<<GENDER>>", trim($profileinfo[5]), $templ);
			$templ = str_replace ("<<PASSWORD>>", trim($profileinfo[6]), $templ);
			$templ = str_replace ("<<LANGUAGE>>", trim($profileinfo[7]), $templ);
			$templ = str_replace ("<<MAILSENTDATE>>", trim($profileinfo[8]), $templ);
			$templ = str_replace ("<<MTYPE>>", 1, $templ);

			if (trim($profileinfo[3]) != '') {
				$mid = substr(trim($profileinfo[3]),0,1);
				$domainval = $domainhash[$mid];
				$templ = str_replace ("<<DOMAIN>>", $domainval, $templ);
			}
		
			if($mailertyp=='mailmtd'){
				if (mail($profileinfo[1],stripslashes($emailsubject),stripslashes($templ),$mailheaders)) {
					$mailedcount = $mailedcount + 1;
					echo 'mail sent success...';		
				} else {
					echo 'mail sent failure ...';
				}
			}
			else{				
					if (mail($profileinfo[1],stripslashes($emailsubject),stripslashes($templ),$mailheaders)) {
						$mailedcount = $mailedcount + 1;
						echo 'mail sent success...';
					}
					else {
						echo 'mail sent failure ...';
					}
			}
	}
}
elseif($type == 'aftertest'){
	emailtempconfig($category,$emailfrom,$replyto,$emailsubject);
		foreach ($lines as $line_num => $line) {
			$profileinfo = explode (",", $line);
			// *********** Place Holder Replacement happening here ************* //
			$templ = str_replace ("<<NAME>>", trim($profileinfo[2]), $emailtemplate);
			$templ = str_replace ("<<EMAIL>>", trim($profileinfo[1]), $templ);
			$templ = str_replace ("<<MATRIID>>", trim($profileinfo[3]), $templ);
			$templ = str_replace ("<<ENCRYPTID>>", base64_encode(trim($profileinfo[3])), $templ);
			$templ = str_replace ("<<AGE>>", trim($profileinfo[4]), $templ);
			$templ = str_replace ("<<GENDER>>", trim($profileinfo[5]), $templ);
			$templ = str_replace ("<<PASSWORD>>", trim($profileinfo[6]), $templ);
			$templ = str_replace ("<<LANGUAGE>>", trim($profileinfo[7]), $templ);
			$templ = str_replace ("<<MAILSENTDATE>>", trim($profileinfo[8]), $templ);
			$templ = str_replace ("<<MTYPE>>", 1, $templ);

			if (trim($profileinfo[3]) != '') {
				$mid = substr(trim($profileinfo[3]),0,1);
				$domainval = $domainhash[$mid];
				$templ = str_replace ("<<DOMAIN>>", $domainval, $templ);
			}
			
			echo $profileinfo[1]."\n";
			if($mailertyp=='mailmtd'){
				if (mail($profileinfo[1],stripslashes($emailsubject),stripslashes($templ),$mailheaders)) {
					$mailedcount = $mailedcount + 1;
					//echo 'mail sent success...';				
				} else {
					//echo 'mail sent failure ...';
				}
			}
			else{				
					if (mail($profileinfo[1],stripslashes($emailsubject),stripslashes($templ),$mailheaders)) {
						$mailedcount = $mailedcount + 1;
						//echo 'mail sent success...';
					}
					else {
						//echo 'mail sent failure ...';
					}
			}

			if ($line_num == $sleepat ) {
				$sleepat = $sleepat + $sleepfor;
				if ($line_num != $totalmailcount) {
					sleep(30);
				}
			}

		}
}
elseif($type == 'othertest'){
	emailtempconfig($category,$emailfrom,$replyto,$emailsubject);
		foreach ($lines as $line_num => $line) {
			$profileinfo = explode (",", $line);
			// *********** Place Holder Replacement happening here ************* //
			$templ = str_replace ("<<NAME>>", trim($profileinfo[2]), $emailtemplate);
			$templ = str_replace ("<<EMAIL>>", trim($profileinfo[1]), $templ);
			$templ = str_replace ("<<MATRIID>>", trim($profileinfo[3]), $templ);
			$templ = str_replace ("<<ENCRYPTID>>", base64_encode(trim($profileinfo[3])), $templ);
			$templ = str_replace ("<<AGE>>", trim($profileinfo[4]), $templ);
			$templ = str_replace ("<<GENDER>>", trim($profileinfo[5]), $templ);
			$templ = str_replace ("<<PASSWORD>>", trim($profileinfo[6]), $templ);
			$templ = str_replace ("<<LANGUAGE>>", trim($profileinfo[7]), $templ);
			$templ = str_replace ("<<MAILSENTDATE>>", trim($profileinfo[8]), $templ);
			$templ = str_replace ("<<MTYPE>>", 1, $templ);

			if (trim($profileinfo[3]) != '') {
				$mid = substr(trim($profileinfo[3]),0,1);
				$domainval = $domainhash[$mid];
				$templ = str_replace ("<<DOMAIN>>", $domainval, $templ);
			}
		
			echo $profileinfo[1]."\n";
			if($mailertyp=='mailmtd'){
				if (mail($profileinfo[1],stripslashes($emailsubject),stripslashes($templ),$mailheaders)) {
					$mailedcount = $mailedcount + 1;
					//echo 'mail sent success...';
				} else {
					//echo 'mail sent failure ...';
				}
			}
			else{				
					if (mail($profileinfo[1],stripslashes($emailsubject),stripslashes($templ),$mailheaders)) {
						$mailedcount = $mailedcount + 1;
						//echo 'mail sent success...';
					}
					else {
						//echo 'mail sent failure ...';
					}
			}

			if ($line_num == $sleepat ) {
				$sleepat = $sleepat + $sleepfor;
				if ($line_num != $totalmailcount) {
					sleep(30);
				}
			}

		}
}


		//fclose($fp);

		$maillog = date('Y-m-d H:i:s')."::".$category."::".($line_num+1)."::".$mailedcount."::".$mailconfig[1]."::".$mailconfig[2]."::".$mailconfig[3]."::".$mailconfig[4]."::".$mailconfig[5]."::".$mailconfig[6]."::".$mailconfig[7]."::".$mailconfig[8]."::".$mailconfig[9]."::".$mailconfig[10]."::".$mailconfig[11]."::".$mailconfig[12]."::".$mailconfig[13]."::".$mailconfig[14]."::".$mailconfig[15]."::".$mailconfig[16]."::".$mailconfig[17]."::".$mailconfig[18]."::".$mailconfig[19]."\n";
		$maillogfname = '/home/cbsmailmanager/maillog/maillog.txt';

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
function emailtempconfig($CategoryName,$EmailFrom,$ReplyTo,$Subject) {
	global $email_template_config_mailid;
	$message='<span style="font:bold 14px arial;">Dear Team</span><br /><br /><span style="font:bold 14px arial;">Kindly Confirm and approve</span><br /><br /><table align="center" cellpadding="3" cellspacing="3" border="1" style="border:solid 1px #5A97CD;" width="100%"><tr><td bgcolor=#DADADA style="font:bold 12px arial;border:solid 1px #5A97CD;">CategoryName</td><td style="font:bold 12px arial;border:solid 1px #5A97CD;">'.$CategoryName.'</td></tr>	<tr><td bgcolor=#DADADA style="font:bold 12px arial;border:solid 1px #5A97CD;">From-ID</td><td style="font:bold 12px arial;border:solid 1px #5A97CD;">'.htmlentities($EmailFrom).'</td></tr><tr><td bgcolor=#DADADA style="font:bold 12px arial;border:solid 1px #5A97CD;">Reply-ID</td><td style="font:bold 12px arial;border:solid 1px #5A97CD;">'.$ReplyTo.'</td></tr><tr><td bgcolor=#DADADA style="font:bold 12px arial;border:solid 1px #5A97CD;">Subject</td><td style="font:bold 12px arial;border:solid 1px #5A97CD;">'.htmlentities($Subject).'</td></tr></table><br /><br /><span style="font:bold 14px arial;">Regards<br /><br />HTML Team</span>';
	$from_id='HTMLconfig<HTMLconfig@communitymatrimony.com>';
	//$to_id='sathish.prabu@bharatmatrimony.com';
	$header=get_MailerHeader($from_id,$email_template_config_mailid);
	mail($email_template_config_mailid,'Email template configuration report - '.$Subject,$message,$header);
}
function get_MailerHeader($FromId,$ReplyId)	{
	$header = '';
	$header .= "From: ".$FromId."\n";
	$header .= "X-Mailer: PHP mailer\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\n";
	$header .= "Sender: Communitymatrimony.com<info@communitymatrimony.com>\n";
	$header .= "Reply-To: ".$ReplyId."\n";
	return $header;
} 
//***** ******************** Ends - Newsletter mail sending process ********************************************** //

?>
