<?php

// ************  DB config includes ***************** //
	include "/home/cbsmailmanager/config/config.php";
	include "/home/cbsmailmanager/config/arrhash.cil14.php";
	include "/home/cbsmailmanager/bmlib/clsCryptDetail.php";  // For Auto login
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
	$sendtype     = trim($_SERVER['argv'][7]);//sendtype
	$membertype	  = trim($_SERVER['argv'][8]); //Membertype(CBS or BM)
	$argcount = trim($_SERVER['argc']);  // Count of arguments catched as input
	
 // ************* Ends - Assigning the input argument(parameter) values to variables *****************//
if($argnew==1) {	
	if (strlen($arg2) != 0) {		
		 $maillist_filename = "/home/cbsmailmanager/mlistfiles/".$arg2.'.txt';
		 $cat_hash=explode("_SPT_",$arg2);
		 $category = trim($cat_hash[0]);		 
	} else {
		$maillist_filename = '';
		$category = '';
	}
} else if($argnew==0) {
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
if ($argcount != 9) {
	$argcount = '';
}

// *********** Starts - Newsletter mail sending process ************************************* //
if ( ($maillist_filename != '') && ($category != '') && ($type != '') && ($datesubmiton != '') && ($argcount == 9) ) {

	$templsql = "select EmailFrom,ReplyTo,Subject,BodyContent,ValidFlag from ".$tbl['mailer']." where Category = '$category' ";

	$templres = mysql_query ($templsql);
	$templrow = mysql_fetch_array ($templres);
	$emailfrom = $templrow['EmailFrom'];		// From email id
	$replyto = $templrow['ReplyTo'];		    // ReplyTo Email Id
	$emailsubject = $templrow['Subject'];		// Subject of newsletter
	$emailtemplate = trim($templrow['BodyContent']);  // Content of newsletter
	$emailvalid = $templrow['ValidFlag'];       // Content of newsletter

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

	$lines = file($maillist_filename);			
	
	if($type == 'live') {
			
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
		
		$trackingid = $mailconfig[56];

		//mysql_close ($dblink); 
		foreach ($lines as $line_num => $line) {
			$profileinfo	  = explode (",", $line);
			$caste1			  = trim($profileinfo[8]);
			$matriid		  = trim($profileinfo[3]);  //MatriId
			$country		  = trim($profileinfo[9]);  // Country
			$varMatriIdPrefix = substr($matriid,0,3); 
		    
			$domain_array     = getDomainInfo(1,$matriid);
		    $caste		      = $domain_array['domainnameshort'];  //E.g: mudaliyar
		    $domainname	      = $domain_array['domainnamelong'];   // E.g: mudaliyarmatrimony.com
		    $domainurl	      = $domain_array['domainnameweb'];    // E.g: www.mudaliyarmatrimony.com
     	    $varDomainFolder  = $domain_array['domainnamefolder']; // E.g: mudaliyar
			$varDomain		  = str_replace('matrimony.com','',ucwords($domainname)); //E.g: Mudaliyar

		
			$dynamiccontent ='';

			// FOR F2P MAILERS
			//********************************* F2P MEMBER DECLARATIONS *******************************************//
			
			$varAutoLogin	  = CryptDetail::mclink($matriid,'f2p');  // For autologin
			
			$paymenturl  = "http://$domainurl/payment/index.php?act=payment&pamid=".$matriid."&palead=11&trackid=$trackingid&formfeed=y";

			$offerpaymenturl = 'http://'.$domainurl.'/login/intermediatelogin.php?'.$varAutoLogin.'&redirect=http://'.$domainurl.'/payment/index.php?act=payment&pamid='.$matriid.'&palead=11&trackid='.$trackingid.'&formfeed=y';
			
			$varProlilePayment = 'http://'.$domainurl.'/login/intermediatelogin.php?'.$varAutoLogin.'&redirect=http://'.$domainurl.'/payment/index.php?act=profilehightlight&pamid='.$matriid.'&palead=11&trackid='.$trackingid.'&formfeed=y';
			
			$domain_logo = 'http://imgs.'.$domainname.'/images/logo/'.$varDomainFolder.'_logo.gif';
			
			$varSuccessStory = 'http://image.'.$domainname.'/successstory/index.php?act=success';

			$varcallno  = 'http://'.$domainurl.'/site/index.php?act=LiveHelp';

			$loginlink = 'http://'.$domainurl.'/login/index.php?&palead=11&trackid=004200000079&formfeed=y';

			$domainurllink = 'http://'.$domainurl;
			
			$doorsteppayment = 'http://'.$domainurl.'/payment/index.php?act=doorstep&trackid=004200000057&formfeed=y&src=f2p';

			$doorstepmail ='mailto:doorstep@'.$domainname.'?subject='.$matriid.' interested in Doorstep Payment';
			
			$unsubscibeLink = 'http://'.$domainurl.'/login/index.php?redirect=http://'.$domainurl.'/profiledetail/index.php?act=mailsetting';

			$dynamiccontent.=dynamicload($country,$doorsteppayment,$doorstepmail,$domainname);
			
			if($country ==98){
				$varTollFreeNo = '<tr><td width="550" background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/img_prfhgt_290311/prf-img5.gif" height="40" valign="middle"><table width="550" border="0" cellpadding="0" cellspacing="0"><tr><td align="center" valign="middle" style="font:bold 16px arial;color:#FED900">Call 1800-3000-2222 for payment assistance</td></tr></table></td></tr>';
			} else {
				$varTollFreeNo='';			
			}
			
			if($country ==98){
				$varAmount = 'Rs.1200';
			} else if($country==220){
				$varAmount = 'AED 125';
			} else if($country==221){
				$varAmount = 'GBP 26';
			} else if($country==21){
				$varAmount = 'EUR 38';
			} else {
				$varAmount = 'USD 40';
			}

			//********************************* END OF F2P DECLERATION ***********************************************//

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
			$templ = str_replace ("<<CASTE>>", ucfirst($caste), $templ);     //E.g: Mudaliyar
			$templ = str_replace ("<<MEMBERTYPE>>", $membertype, $templ);
			$templ = str_replace ("<<DOMAIN>>", $domainname, $templ);       // E.g: mudaliyarmatrimony.com
			$templ = str_replace ("<<LOGINLINK>>", $loginlink, $templ);
			$templ = str_replace ("<<DOMAINNAME>>", $domainname, $templ);       // E.g: Mudaliyar
			$templ = str_replace ("<<DOMAINTITLE>>", str_replace('matrimony.com','Matrimony',ucwords($domainname)), $templ);
			$templ = str_replace ("<<PAYMENTLINK>>", $paymenturl, $templ);
			$templ = str_replace ("<<OFFERPAYMENTLINK>>", $offerpaymenturl, $templ);
			$templ = str_replace ("<<PROFILEPAYMENT>>", $varProlilePayment, $templ);
			$templ = str_replace ("<<DOMAINLOGO>>", $domain_logo, $templ);
			$templ = str_replace ("<<CALLNO>>", $varcallno, $templ);
			$templ = str_replace ("<<DOMAINURL>>", $domainurllink, $templ);
			$templ = str_replace ("<<DOMAINURLNAME>>", ucwords($domainname), $templ);
			$templ = str_replace ("<<UNSUBSCRIBE>>", $unsubscibeLink, $templ);
			$templ = str_replace ("<<DYNAMICCONTENT>>", $dynamiccontent, $templ);
			$templ = str_replace ("<<SUCCESSSTORY>>", $varSuccessStory, $templ);
			$templ = str_replace ("<<TOLLFREENO>>", $varTollFreeNo, $templ);
			$templ = str_replace ("<<AMOUNT>>", $varAmount, $templ);


			// HEADERS
			$varHeaderEmaifrom = $emailfrom.'@'.$domainname;
			$varHeaderReplyto  = $replyto.'@'.$domainname;
			$argFrom           = ucfirst($domainname);
			$argFrom           = str_replace("matrimony.com"," Matrimony.Com",$argFrom);
			
			//$varHeaderEmaifrom = $emailfrom.'@communitymatrimony.com';
			//$varHeaderReplyto  = $replyto.'@communitymatrimony.com';
			//$argFrom		   = 'Community Matrimony';	
			
			// REPORT HEADER
			$mailheaders = "MIME-Version: 1.0\n";
			$mailheaders .= "Content-type: text/html\n";
			$mailheaders .= "From: $argFrom<$varHeaderEmaifrom>\n";
			$mailheaders .= "Sender: Communitymatrimony.com<info@communitymatrimony.com> \n";
			$mailheaders .= "X-Mailer: PHP\n"; // mailer
			$mailheaders .= "Return-Path: <noreply@bounces.communitymatrimony.com> \n";
			$mailheaders .= "Reply-To: ".$varHeaderReplyto."\n";
			
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
		$processendsubject="Mail Server performance [Mailer Interface]";
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
	}//end for live bracket
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
		$mailreport .= "From: info@communitymatrimony.com\n";
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
	}

	$DOMAINARRAY['domainid'] = $domainid;  // eg 1
	$DOMAINARRAY['domainnameshort'] = $domainname; // eg mudaliyar
	$DOMAINARRAY['domainnamelong'] = $domainpath; // eg mudaliyarmatrimony.com
	$DOMAINARRAY['domainnamefolder'] = $foldername; // eg mudaliyar
	$DOMAINARRAY['domainnamebmser'] = 'bmser.'.$domainpath; // eg bmser.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameweb'] = 'www.'.$domainpath; // eg www.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimg'] = 'img.'.$domainpath; // eg img.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimgs'] = 'imgs.'.$domainpath; // eg imgs.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimage'] = 'image.'.$domainpath; // eg image.mudaliyarmatrimony.com

	return $DOMAINARRAY;
}

function dynamicload($country,$doorsteppayment,$doorstepmail,$domainname) {
	
	if($country ==98) {
		$replace='<table width="550" border="0" cellpadding="0" cellspacing="0">
    <tr><td align="left" valign="top" background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images//dtp-img1.gif" height="134" width="550">
    <table cellpadding="0" cellspacing="0" border="0" width="550">
        <tr><td height="10"></td></tr>
        <tr><td align="left" valign="top" style="padding-left:16px;font:bold 19px arial;color:#4D4D4D">Pay at Doorstep</td></tr>
        <tr><td align="left" valign="top">
          <table cellpadding="0" cellspacing="0" border="0" width="550">
            <tr>
            <td align="left" valign="top" width="20" style="padding-top:20px;padding-left:16px;font:bold 50px arial;color:#5B5A5A">1</td>
            <td align="left" valign="top" width="147" style="padding-top:25px;font:11px arial;color:#5B5A5A"><a href="<<DOORSTEPPAYMENT>>" style="font:bold 11px arial;color:#FE7313;text-decoration:none;">Click here</a> to give us your name and phone number. We will call you to collect payment at your convenient time.</td>
            <td width="33">&nbsp;</td>
            <td align="left" valign="top" width="30" style="padding-top:20px;font:bold 50px arial;color:#5B5A5A">2</td>
            <td align="left" valign="top" width="291" style="padding-left:5px;padding-top:30px;font:11px arial;color:#5B5A5A;">Or e-mail your address, phone number & convenient time<br />for payment collection to<br /><a href="<<DOORSTEPMAIL>>" style="font:bold 11px arial;color:#FE7313;text-decoration:none;">doorstep@<<DOMAIN>>.</a></td>
            </tr>
          </table>
        </td></tr>
    </table>
    </td></tr>
    <tr><td align="left" valign="top" background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images//dtp-img2.gif" height="73" width="550">
    <table cellpadding="0" cellspacing="0" border="0" width="550">
            <tr>
            <td align="left" valign="top" width="20" style="padding-left:20px;font:bold 50px arial;color:#5B5A5A">3</td>
            <td align="left" valign="top" width="510" style="padding-left:10px;padding-top:15px;font:bold 12px arial;color:#5B5B5B">Call any of the numbers below for<br />doorstep payment.</td>
            </tr>
     </table>
    </td></tr>
    <tr><td align="left" valign="top" style="padding-left:20px;" background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images//dtp-img3.gif" height="134" width="550">
    <table border="0" cellpadding="0" cellspacing="0" width="520" valign="top" style="font: normal 11px arial,verdana;color:#666666;">

    	<tr>
    		<td valign="top" width="140" style="padding:1px 3px 1px 0px;">Ahmedabad - 32457475</td>
    		<td valign="top" width="120" style="padding:1px 3px 1px 3px;">Allapuzha -  3297327</td>
    		<td valign="top" width="113" style="padding:1px 3px 1px 7px;">Bangalore - 32557941</td>
    		<td valign="top" width="106" style="padding:1px 3px 1px 7px;">Belgaum - 3246684</td>
    	</tr>
    	<tr>

    		<td valign="top" style="padding:1px 3px 1px 0px;">Bhimavaram - 322523</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Bhubaneswar - 3274911</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Calicut - 3106095</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Chandigarh - 3262256</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Chennai - 30134200</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Coimbatore - 3221347</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Cochin - 3235900</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Dehradun - 3277457</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Rajahmundry - 3244706</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Erode - 3249792</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Indore - 3228603</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Delhi - 32311103</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Guntur - 3243561</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Hyderabad - 31002025</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Kakinada - 3206647</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Jaipur - 3158281</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Jamnagar - 3211712</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Kadapa - 329235</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Kanpur - 3230483</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Kannur - 3241149</td>
    	</tr>

    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Kancheepuram - 37213799</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Gandhidham - 36313027</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Kurnool - 316489</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Kollam - 3224791</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Kolkata - 4060 5515</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Kottayam - 3231890</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Malapuram - 3213766</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Ludhiana - 3232160</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Lucknow - 3223621</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Madurai - 3277689</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Nagercoil - 314456</td>
    		<td valign="top" style="padding:1px 3px 1px 7px; ">Mumbai - 31928891</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Mysore - 60603333</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Nagpur - 3223950</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Pune - 32319975</td>
    		<td valign="top" style="padding:1px 3px 1px 7px; ">Palakkad - 3267245</td>
    	</tr>

    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Pathanamthitta - 3206585</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Pondicherry - 3248996</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Surat - 3111032</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Rajkot - 60603333</td>
    	</tr>
    	<tr>

    		<td valign="top" style="padding:1px 3px 1px 0px;">Rourkela - 3203367</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Salem - 3257271</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Tirupathi - 3245864</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Trichy - 3253139</td>
    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Nizamabad - 312645</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Trivandrum - 3273379</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Vadodara - 3264304</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Tirunelveli - 3240059</td>

    	</tr>
    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Thrissur - 3108946</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Udaipur - 3209650</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Vijayawada - 3244392</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Vellore - 3268379</td>
    	</tr>

    	<tr>
    		<td valign="top" style="padding:1px 3px 1px 0px;">Vishakhapatnam - 3260659</td>
    		<td valign="top" style="padding:1px 3px 1px 3px;">Vadakara - 3224138</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;">Warangal - 3195544</td>
    		<td valign="top" style="padding:1px 3px 1px 7px;"></td>
    	</tr>
    </table>
    </td></tr>
    <tr><td align="left" valign="top" background="http://imgs.communitymatrimony.com/images/mailers/freetopaid/images//dtp-img4.gif" height="28" width="550"></td></tr>
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
