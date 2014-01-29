<?php
/* ********************************************************************** */
/* Author	       : Ashok Kumar - Tech Team							  */
/* Filename	       : sendmail.php										  */
/* FileDescription : This file get executed in command as external program*/
/* ********************************************************************** */
# Modification History
#Modified By		: Anish.G
#Description		:Invoked the split file for the mail count exceeding '2' lakh
#Date				:16-Mar-2009
/* ********************************************************************** */
// ************  DB config includes ***************** //
	include "/home/cbsmailmanager/config/config.php";
	require("smtp.php");
	ini_set("memory_limit","512M");


// ************* Starts - Assigning the input argument(parameter) values to variables ***************//
	$arg1     = trim($_SERVER['argv'][0]); // php filename itself
	$arg2     = trim($_SERVER['argv'][1]); // Email Concept Category
	$arg3     = trim($_SERVER['argv'][2]); // Email type [ test or live ]
	$argnew	  = trim($_SERVER['argv'][3]);
	$arg4     = trim($_SERVER['argv'][4]); // Email Concept submit date
	$arg5     = trim($_SERVER['argv'][5]); // Mail priority
	$arg6     = trim($_SERVER['argv'][6]); // mailer type
	$argcount = trim($_SERVER['argc']);    // Count of arguments catched as input
	$argcount1 = $argcount;
 // ************* Ends - Assigning the input argument(parameter) values to variables *****************//
	

// *********** Start - validating the catched input parameters *********************************//
/*For split file the name will be diffrent and wont have the context name as categormail.txt*/
	if($argnew==1){	
	if (strlen($arg2) != 0) {		
		 $maillist_filename = "/home/cbsmailmanager/mlistfiles/".$arg2.'.txt';
		 $cat_hash=explode("_SPT_",$arg2);
		  $category = trim($cat_hash[0]);
		 
	} else {
		$maillist_filename = '';
		$category = '';
	}
	}
	else if($argnew==0){
	
	if (strlen($arg2) != 0) {
		 $maillist_filename = "/home/cbsmailmanager/mlistfiles/".$arg2.'mail.txt';
		$category = $arg2;
	} else {
		$maillist_filename = '';
		$category = '';
	}	
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
	if (strlen($arg6) != 0) {
		$mailertype = $arg6;
	} else {
		$mailertype = '';
	}
	if ($argcount != 7) {
		$argcount = '';
	}
// *********** End - validating the catched input parameters *********************************//


// *********** Starts - Newsletter mail sending process ************************** //
if ( ($maillist_filename != '') && ($category != '') && ($type != '') && ($datesubmiton != '') && ($argcount == 7) ) {


	// ********** Starts - Fetching the Email Template from database ******************** //
		$templsql = "select * from ".$tbl['mailer']." where Category = '$category' ";
		$templres = mysql_query ($templsql);
		$templrow = mysql_fetch_array ($templres);
 		$emailfrom = $templrow['EmailFrom'];		// From email id
		$replyto = $templrow['ReplyTo'];		    // ReplyTo Email Id
		$emailsubject = $templrow['Subject'];		// Subject of newsletter
		$emailtemplate = $templrow['BodyContent'];  // Content of newsletter
		$emailvalid = $templrow['ValidFlag'];       // Content of newsletter

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
		
		if($type == 'live'){

		// Return Path setting...
		putenv("MAILUSER=noreply");
		putenv("MAILHOST=mail1.communitymatrimony.com");

		$mailheaders  = "MIME-Version: 1.0\n";
		$mailheaders .= "From: $emailfrom\n";
		$mailheaders .= "Content-type: text/html\n";
		$mailheaders .= "Reply-To: $replyto\n";
		$mailheaders .= "X-Priority: 2\n";
		$mailheaders .= "X-Mailer: PHP mailer\n";
		if($argnew==1){
		$countlog = 'countlog/'.$arg2.'.txt';
		}else{
		$countlog = 'countlog/'.$category.'.txt';		
		}
		
		$mailedcount = 0; // number of mails sent...
		$totalmailcount = count($lines); // Total number of mails...
		
		//ADDED BY ANISH TO TRIGGER THE MAIL TO SEDBM TEAM TO KNOW THE MAIL PROCESS TIME 
		 $date1=date("Y-m-d G:i:s");
		$startmailid="sedbm@consim.com,saichithra@bharatmatrimony.com,jshree@bharatmatrimony.com,iyyappan.n@bharatmatrimony.com";
		
		/***********************Mail process Ends********************************************/	
		$blockedEmailsSupport = blockedemaillist_return('3'); // manual array entry changed  -  array will get from mailer_blocked list table.
		mysql_close ($dblink); 
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
			$templ = str_replace ("<<MTYPE>>", $mailertype, $templ);
			if (trim($profileinfo[3]) != '') {
				$mid = substr(trim($profileinfo[3]),0,1);
				$domainval = $domainhash[$mid];
				$templ = str_replace ("<<DOMAIN>>", $domainval, $templ);
			}
			
			if (in_array($profileinfo[1],$blockedEmails) or in_array($profileinfo[1],$blockedEmailsSupport)) {
					$dat=date('d-F-y h:i:s');
					$msgtest="The below mail id is blocked.As it occured in the mail which sent on ".$dat." ,using mailer interface and the file path is /home/mailmanager/ ".$maillist_filename."<br>The email id is ".$profileinfo[1];					
			}
			else{
					
					##### Below commented lines are sending the mail through smtp and not through php mail function######
					$smtp=new smtp_class;				
					$smtp->host_name="172.28.0.236";
					$smtp->host_port=587;
					$smtp->ssl=0;
					$smtp->localhost="localhost";
					$smtp->timeout=10;
					$priority = '3';
				if($smtp->SendMessage("noreply@mail1.communitymatrimony.com", array($profileinfo[1]), array("From: $emailfrom", "Reply-to: $replyto", "Sender: info@communitymatrimony.com", "MIME-Version: 1.0", "Content-type: text/html", "X-Priority: ".$priority, "X-Mailer: PHP mailer", "To: ".$profileinfo[1], "Subject: $emailsubject", "Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")), stripslashes($templ))){
				
					$mailedcount = $mailedcount + 1;
					$logit = " mail count delivered=".$mailedcount.",line number from text file".$profileinfo[0]."\n";
					logit ($countlog,'w',$logit);
					echo " mail sent success...";				
				}
			}			
		}
		//added by anish to find the process time and to send the msg to linux team-18 FEB
		$date2=date("Y-m-d G:i:s");		
		function getDifference($endDate,$startDate) 
		{ 
			list($date,$time) = explode(' ',$endDate); 
			$startdate = explode("-",$date); 
			$starttime = explode(":",$time); 
			list($date,$time) = explode(' ',$startDate); 
			$enddate = explode("-",$date); 
			$endtime = explode(":",$time); 
			$secondsDifference = mktime($endtime[0],$endtime[1],$endtime[2], 
			$enddate[1],$enddate[2],$enddate[0]) - mktime($starttime[0], 
			$starttime[1],$starttime[2],$startdate[1],$startdate[2],$startdate[0]);
			$seconds=floor($secondsDifference);
			$minutes=floor($secondsDifference/60); 
			$hours=floor($secondsDifference/60/60); 
			$days=floor($secondsDifference/60/60/24); 
			if($hours >0){
			$tot=". The Process taken to complete the entire mailer is ".$hours." Hrs";
			}
			else if($minutes >0){
			$tot=". The Process taken to complete the entire mailer is ".$minutes." Minutes";
			}
			else {
			$tot=". The Process taken to complete the entire mailer is ".$seconds." seconds";
			}

		   return $tot;                 
		}

		$diffrence_execution=getDifference($date1,$date2);
		$processendsubject="Mail Server performance [Mailer Interface]";
		$processendmsg= " The Entire Mail got delivered Successfully for the file ".$maillist_filename.". The total Count of the mailer is ".$mailedcount.". The start time of the mailer is :".$date1.". The end time of the mailer is: ".$date2.$diffrence_execution;
		mail($startmailid, $processendsubject,$processendmsg);
		
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
}//end for live bracket
elseif($type == 'test'){
	
// Return Path setting...
		putenv("MAILUSER=noreply");
		putenv("MAILHOST=mail1.communitymatrimony.com");

		$mailheaders  = "MIME-Version: 1.0\n";
		$mailheaders .= "From: $emailfrom\n";
		$mailheaders .= "Content-type: text/html\n";
		$mailheaders .= "Reply-To: $replyto\n";
		$mailheaders .= "X-Priority: 2\n";
		$mailheaders .= "X-Mailer: PHP mailer\n";

		$countlog = 'countlog/'.$category.'.txt';
		
		$mailedcount = 0; // number of mails sent...
		$totalmailcount = count($lines); // Total number of mails...
		$sleepfor = 1000; // Sleep of mail execution for every 1000 th mail sent and to start next set...
		$sleepat = $sleepfor; // every 1000 th counting... ( 1000, 2000, etc )
		$smtp=new smtp_class;
		$smtp->host_name="172.20.100.90";       
		$smtp->host_port=25;
		$priority = '2';
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
			$templ = str_replace ("<<MTYPE>>", $mailertype, $templ);

			if (trim($profileinfo[3]) != '') {
				$mid = substr(trim($profileinfo[3]),0,1);
				$domainval = $domainhash[$mid];
				$templ = str_replace ("<<DOMAIN>>", $domainval, $templ);
				
			}
			
			$smtp->SendMessage("noreply@mail1.communitymatrimony.com", array($profileinfo[1]), array("From: $emailfrom", "Reply-to: $replyto", "Sender: info@communitymatrimony.com", "MIME-Version: 1.0", "Content-type: text/html", "X-Priority: ".$priority, "X-Mailer: PHP mailer", "To: ".$profileinfo[1], "Subject: $emailsubject", "Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")), stripslashes($templ));

}
}//end for test
}//main if

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

?>
