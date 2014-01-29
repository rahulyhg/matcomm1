<?php

// ************  DB config includes ***************** //
	include "/home/cbsmailmanager/config/config.php";
	include "/home/cbsmailmanager/config/arrhash.cil14.php";
	require("smtp.php");
	ini_set("memory_limit","512M");

// ************* Starts - Assigning the input argument(parameter) values to variables ***************//
	$arg1     = trim($_SERVER['argv'][0]); // php filename itself
	$arg2     = trim($_SERVER['argv'][1]); // Email Concept Category
	echo $arg3     = trim($_SERVER['argv'][2]); // Email type [ test or live ]
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


// *********** Starts - Newsletter mail sending process ************************************* //
if ( ($category != '') && ($type != '') && ($datesubmiton != '')) {

	$templsql = "select EmailFrom,ReplyTo,Subject,BodyContent,ValidFlag from ".$tbl['mailer']." where Category = '$category' ";

	$templres = mysql_query ($templsql);
	$templrow = mysql_fetch_array ($templres);
	$emailfrom = $templrow['EmailFrom'];		// From email id
	$replyto = $templrow['ReplyTo'];		    // ReplyTo Email Id
	$emailsubject = $templrow['Subject'];		// Subject of newsletter
	$emailtemplate = trim($templrow['BodyContent']);  // Content of newsletter
	$emailvalid = $templrow['ValidFlag'];       // Content of newsletter

	// ********** Fetching the datas from mail concept file ************************** //
	$catgfile = "/home/cbsmailmanager/mfiles/".$category.".txt";
	$catgfp = fopen($catgfile, "r");
	$catgcont = fread($catgfp, filesize($catgfile));
	fclose($catgfp);
	$mailconfig = explode ("::", $catgcont);

	$maillist_filename = '/home/cbsmailmanager/mlistfiles/testmaillist.txt';
	$lines = file($maillist_filename);

		if($argnew==1) {
			$countlog = 'countlog/'.$arg2.'.txt';
		}else {
			$countlog = 'countlog/'.$category.'.txt';
		}

		$mailedcount = 0; // number of mails sent...
		$totalmailcount = count($lines); // Total number of mails...

		//ADDED BY ANISH TO TRIGGER THE MAIL TO SEDBM TEAM TO KNOW THE MAIL PROCESS TIME
		$date1=date("Y-m-d G:i:s");
		$startmailid="iyyappan.n@bharatmatrimony.com";

		//mysql_close ($dblink);
		foreach ($lines as $line_num => $line) {
			$profileinfo	= explode (",", $line);
			$caste1			= trim($profileinfo[8]);
			$matriid		= trim($profileinfo[3]);
			$country		= trim($profileinfo[9]);
			$varMatriIdPrefix	= substr($matriid,0,3);

		    $domain_array   = getDomainInfo(1,$matriid);
		    $caste		   = $domain_array['domainnameshort']; //E.g: mudaliyar
		    $domainname	   = $domain_array['domainnamelong']; // E.g: mudaliyarmatrimony
		    $domainurl	   = $domain_array['domainnameweb'];  // E.g: www.mudaliyarmatrimony.com

			$dynamiccontent ='';

			// FOR F2P MAILERS
			$paymenturl  = "http://www.$domainname.com/payment/index.php?act=payment&pamid=$matriid";

			$domain_logo = 'http://img.'.$domainname.'.com/images/logo/'.$arrFolderNames[$varMatriIdPrefix].'_logo.gif';
			$varcallno  = "http://www.$domainname.com/site/index.php?act=LiveHelp";

			$doorsteppayment = 'http://www.'.$domainname.'.com/payment/index.php?act=doorstep';

			$doorstepmail ='mailto:doorstep@'.$domainname.'.com?subject='.$matriid.' interested in Doorstep Payment';

			$unsubscibeLink = $domainurl.'/login/index.php?redirect='.$domainurl.'/profiledetail/index.php?act=mailsetting';

			$dynamiccontent.=dynamicload($country,$doorsteppayment,$doorstepmail,$domainname);

			// *********** Place Holder Replacement happening here ************* //
			$templ = str_replace ("<<NAME>>", ucfirst(trim($profileinfo[2])), $emailtemplate);
			$templ = str_replace ("<<EMAIL>>", trim($profileinfo[1]), $templ);
			$templ = str_replace ("<<MATRIID>>", trim($profileinfo[3]), $templ);
			$templ = str_replace ("<<ENCRYPTID>>", base64_encode(trim($profileinfo[3])), $templ);
			$templ = str_replace ("<<AGE>>", trim($profileinfo[4]), $templ);
			$templ = str_replace ("<<GENDER>>", trim($profileinfo[5]), $templ);
			$templ = str_replace ("<<PASSWORD>>", trim($profileinfo[6]), $templ);
			$templ = str_replace ("<<LANGUAGE>>", trim($profileinfo[7]), $templ);
			$templ = str_replace ("<<MAILSENTDATE>>", trim($profileinfo[9]), $templ);
			$templ = str_replace ("<<MTYPE>>", $mailertype, $templ);
			$templ = str_replace ("<<CASTE>>", ucfirst($caste), $templ);  // E.g : Mudaliyar
			$templ = str_replace ("<<MEMBERTYPE>>", $membertype, $templ);
			$templ = str_replace ("<<DOMAIN>>", $domainname, $templ);
			$templ = str_replace ("<<DOMAINTITLE>>", str_replace('matrimony','Matrimony',ucwords($domainname)), $templ);
			$templ = str_replace ("<<PAYMENTLINK>>", $paymenturl, $templ);
			$templ = str_replace ("<<DOMAINLOGO>>", $domain_logo, $templ);
			$templ = str_replace ("<<CALLNO>>", $varcallno, $templ);
			$templ = str_replace ("<<DOMAINURL>>", $domainurl, $templ);
			$templ = str_replace ("<<UNSUBSCRIBE>>", $unsubscibeLink, $templ);
			$templ = str_replace ("<<DYNAMICCONTENT>>", $dynamiccontent, $templ);

			$varHeaderReplyto = $replyto.'@'.$domainname.'.com';
			$varHeaderEmaifrom = $emailfrom.'@'.$domainname.'.com';

			$argFrom      = ucfirst($domainname);
			$argFrom      = str_replace("matrimony"," Matrimony",$argFrom);

			// Return Path setting...
			/*$mailheaders  = "MIME-Version: 1.0\n";
			$mailheaders .= "Content-type: text/html\n";
			$mailheaders .= "From: $argFrom<$varHeaderEmaifrom>\n";
			$mailheaders .= "Sender: info@communitymatrimony.com\n";
			$mailheaders .= "X-Mailer: PHP\n";
			$mailheaders .= "Return-Path: noreply@bounces.communitymatrimony.com \n";
			$mailheaders .= "Reply-To: $argFrom<$varHeaderReplyto>\n";
			$mailheaders .= "X-Priority: 2\n";*/
			
		$mailheaders  = "MIME-Version: 1.0\n";
        $mailheaders .= "Content-type: text/html\n";
        $mailheaders .= "From: $argFrom <$varHeaderEmaifrom>\n";
        $mailheaders .= "Sender: info@communitymatrimony.com\n";
        $mailheaders .= "X-Mailer: PHP\n"; // mailer
        $mailheaders .= "Return-Path: <noreply@bounces.communitymatrimony.com> \n";
        $mailheaders .= "Reply-To: $argFrom<$varHeaderReplyto> \n";


			//MAIL THROUGH MAIL FUNCTION
			if (mail($profileinfo[1],$emailsubject,trim($templ),$mailheaders)) {
				$mailedcount = $mailedcount + 1;
				$logit = "Date :".$date1.", Mail count delivered=".$mailedcount.",line number from text file".$profileinfo[0]."\n";
				logit1 ($countlog,'w',$logit);
			}

		}
		//added by anish to find the process time and to send the msg to linux team-18 FEB
		$date2=date("Y-m-d G:i:s");


		$diffrence_execution=getDifference($date1,$date2);
		$reporthead=reportheader();
		$processendsubject="Test Mail Triggerd[Mailer Interface]";
		$processendmsg= " The Entire Mail got delivered Successfully for the file ".$maillist_filename.". The total Count of the mailer is ".$mailedcount.". The start time of the mailer is :".$date1.". The end time of the mailer is: ".$date2.$diffrence_execution;
		mail($startmailid, $processendsubject,$processendmsg,$reporthead);

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

}//main if
else {
	echo "Error in argument";
}

function logit1 ($filename,$method,$logit) {
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

function getDifference($endDate,$startDate) {
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
	} else if($minutes >0){
		$tot=". The Process taken to complete the entire mailer is ".$minutes." Minutes";
	} else {
		$tot=". The Process taken to complete the entire mailer is ".$seconds." seconds";
	}
   return $tot;
}

function reportheader() {
		$mailreport  = "";
		$mailreport .= "MIME-Version: 1.0\n";
		$mailreport .= "From: noreply@communitymatrimony.com\n";
		$mailreport .= "Content-type: text/html\n";
		$mailreport .= "Sender: Communitymatrimony.com<info@communitymatrimony.com>\n";
		$mailreport .= "Reply-To:noreply@communitymatrimony.com\n";
		$mailreport .= "X-Priority: 2\n";
		$mailreport .= "X-Mailer: PHP mailer\n";
		return $mailreport;
}

function getDomainInfo($type='', $val='') {
	$DOMAINARRAY = array();
	if(trim($type)==1) { // $val is matriid	FOR CBS MEMBERS
		$domainletter = strtoupper(substr($val,0,3));
	    $domainid = array_search($domainletter,$GLOBALS['arrMatriIdPre']);
		$domainname = $GLOBALS['arrFolderNames'][$domainletter];
		$domainpath = $GLOBALS['arrPrefixDomainList'][$domainletter];
		$foldername = $GLOBALS['arrFolderNames'][$domainletter];
	} elseif ($type==2) { // $val is domain id as int, FOR BM MEMBERS
	    $domainid = $val;
		$domainletter =  $GLOBALS['arrMatriIdPre'][$domainid];
		$domainname = $GLOBALS['arrFolderNames'][$domainletter];
		$domainpath = $GLOBALS['arrPrefixDomainList'][$domainletter];
		$foldername = $GLOBALS['arrFolderNames'][$domainletter];
	}

	$DOMAINARRAY['domainid'] = $domainid;  // eg 1
	$DOMAINARRAY['domainnameshort'] = $domainname; // eg mudaliyar
	$DOMAINARRAY['domainnamelong'] = $domainname.'matrimony'; // eg mudaliyarmatrimony.com
	$DOMAINARRAY['domainnamefolder'] = $foldername; // eg mudaliyar
	$DOMAINARRAY['domainnamebmser'] = 'bmser.'.$domainname.'matrimony.com'; // eg bmser.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameweb'] = 'www.'.$domainname.'matrimony.com'; // eg www.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimg'] = 'img.'.$domainname.'matrimony.com'; // eg img.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimgs'] = 'imgs.'.$domainname.'matrimony.com'; // eg imgs.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimage'] = 'image.'.$domainname.'matrimony.com'; // eg image.mudaliyarmatrimony.com

	return $DOMAINARRAY;
}

function dynamicload($country,$doorsteppayment,$doorstepmail,$domainname) {

	if($country ==98) {
		$replace='<table width="550" border="0" cellpadding="0" cellspacing="0" background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images/cbsbg.gif" style="border-bottom:1px solid #8D1A12;">
	<tr><td align="center" height="92" width="550"><img src="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images/tollfree.gif"></td></tr>
	<tr valign="top"><td width="550" style="font: bold 18px arial;color:#666666;padding-top:15px; padding-left:15px;padding-bottom:15px;">Pay at Doorstep</td></tr>
	<tr>
  <td align="center">
  <table border="0" cellpadding="0" cellspacing="0" width="534">
	<tr><td align="left" background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images/f2p-border-bg.gif" width="534" height="56" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="500">
	<tr><td align="left" style="padding-left:20px;padding-top:15px;"><img src="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images/f2p-one.gif" width="27" height="27" border="0" alt=""></td><td align="left" valign="top" style="padding-left:20px;padding-top:15px;font: bold 12px arial;color:#666666;"><a href="<<DOORSTEPPAYMENT>>" style="color:#D11014;text-decoration:none;">Click here</a> to give us your name and phone number. We will call you to collect payment at your convenient time.</td></tr>
	</table></td>
	</tr>
  </table>
  </td>
  </tr>

	<tr>
	<td align="center">
	<table border="0" cellpadding="0" cellspacing="0" width="534">
	<tr><td  background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images/f2p-border-bg.gif" width="534" height="56" valign="top">
		<table border="0" cellpadding="0" cellspacing="0" width="500">
			<tr><td valign="top" style="padding-left:20px;padding-top:15px;"><img src="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images/f2p-two.gif" width="27" height="27" border="0" alt=""></td><td align="left" valign="top" style="padding-left:20px;padding-top:15px;padding-right:20px;font: bold 12px arial;color:#666666;">Or e-mail your address, phone number & convenient time for payment collection  to <a href="<<DOORSTEPMAIL>>" style="color:#D11014;text-decoration:none;">doorstep@<<DOMAIN>>.</a></td></tr>
		</table>
	</td></tr>
	<tr><td  height="7" valign="top"><img src="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images/trans.gif" width="534" height="7"></td></tr>
	</table>
	</td>
</table>';
	}

	$replace =str_replace ("<<DOORSTEPPAYMENT>>", $doorsteppayment, $replace);
	$replace =str_replace ("<<DOORSTEPMAIL>>", $doorstepmail, $replace);
	//$replace =str_replace ("<<DOMAINURL>>", $domainurl, $replace);
	$replace =str_replace ("<<DOMAIN>>", $domainname, $replace);



	return $replace;
}

// ********* Ends - Newsletter mail sending process ************************** //

?>

