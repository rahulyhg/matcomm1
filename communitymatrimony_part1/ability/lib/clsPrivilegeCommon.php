<?php
#============================================================================================================
# Author 		: S Rohini , A.Baskaran and N.Jeyakumar
# Start Date	: 10 Jul 2008
# End Date		: 10 Jul 2008
# Project		: MatrimonialProduct
# Module		: Common Class
#============================================================================================================
function doCrypt($matriid) {
	$level1 = crypt($matriid,"RPH");
	return crypt($level1,"BM");
}

function encrypt($string, $key) {
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}
	return base64_encode($result);
}

function decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}

// It limit number of words from a long text //
function limit_text($text, $limit) {
   $words = str_word_count($text, 2);
   $pos = array_keys($words);
   $limitval = sizeof($pos);
   if($limitval==1)
	 $text = $words[0]. '...';
   else {
	if($limitval < $limit)
	 $txtlimit = $pos[$limitval-1];
	else
	 $txtlimit = $pos[$limit];
	$text = substr($text, 0, $txtlimit) . '...';
   }
  return $text;
}

function removeAnySpecialChars($word) {
	$pattern=array(",",".","+","/","_",":","&",";","-");
	$word=str_replace($pattern, " ", $word);
	return preg_replace('/[^a-z0-9\ ]/is', '',$word);
}

// Checking Live Members //
function checklivemember($argument=''){
	return in_array($argument,$GLOBALS['IDLIST']);	
}

//Aded by Suresh Babu for generating random number
function genRandom() {
	$newName = time();
	$lower=0000; $upper=9999;
	$randnumber = rand($lower, $upper);
	$newName = $newName . $randnumber;
	return $newName;
}


// Telemarketing //
function boolVal($val){ // for telemarketing purpose
	if ($val == 1) return "Yes";
	else return "No";
}

// Get Browser Details //
function getBrowserDetails() {
	$js_br="";
	$br = $_SERVER['HTTP_USER_AGENT'];
	$br = strtolower($br);
	if (strpos(' '.strtolower($br),'safari')) {
		$js_br = "S";
	} elseif (strpos(' '.strtolower($br),'netscape')) {
		$js_br = "N";
	} elseif (strpos(' '.strtolower($br),'firefox')) {
		$js_br = "F";
	} elseif (strpos(' '.strtolower($br),'opera')) {
		$js_br = "O";
	} else {
		$js_br = "I";
	}
	return $js_br;
}

function dbSplCharsEncode($str) {
	return htmlentities($str);
}

function dbSplCharsDecode($str) {
	return htmlspecialchars(html_entity_decode($str));
}

function dbEscapeQuotes($value, $link) {
	global $ERROR_MSG;
	$value = dbSplCharsEncode($value);
	if(is_resource($link)) {
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if (!is_numeric($value)) {
			$value = mysql_real_escape_string($value, $link);
		}
		return $value;	
	}
	else {
		header ("Location: http://".$_SERVER['SERVER_NAME']."/cgi-bin/error_landing.php?main=err&err_msg=$ERROR_MSG");
		exit;
	}
}

function replaceAlignSearch ($torpl) {
	$torpl = str_replace(",",", ",$torpl);
	$torpl = str_replace(".",". ",$torpl);
	return str_replace(";","; ",$torpl);
}

function smartGetDomainPrefixName() {
	return preg_replace($GLOBALS['DOMAINPREFFIX'],"",strtolower($_SERVER['SERVER_NAME']));
}

function replaceComma($string) {
	global $str;
	$str = str_replace("~","','",$string);
	$commaseperatorvalue = "'".$str."'";
	return $commaseperatorvalue;
}

function readIt ($filename) {
	$fp = fopen($filename, "r");
	$count = fread($fp, 50000);
	fclose($fp);
	if ( $count > 0 ) {
		return $count;
	} else {
		$count = 0;
		return $count;
	}
}

function readTpl ($filename) {
	$fp = fopen($filename, "r");
	$count = fread($fp, filesize($filename));
	fclose($fp);
	return $count;
}

function logIt ($filename,$method,$logit) {
	if (!$fp = fopen($filename, $method)) {
	}
	//if (flock($fp, LOCK_EX)) { // do an exclusive lock
	   fwrite($fp, $logit);
	   //flock($fp, LOCK_UN); // release the lock
	//} else {
	  // echo "Couldn't lock the file !";
	//}
	fclose($fp);
}

// Format Date Function...
function dateTimeStamp($regdate) {
	$datetime=split(" ",$regdate);
	$date = split("-",$datetime[0]);
	$time = split(":",$datetime[1]);
	list($year,$month,$day)=$date;
	list($hr,$min,$sec)=$time;
	$dt = @date("d-F-Y H:i:s",mktime($hr,$min,$sec,$month,$day,$year));
	return $dt;
}


// Return difference between two given dates...
function dateDiff ($from,$to) {
	$dt_dif = DateTimeStamp($to) - DateTimeStamp($from);
	return $dt_dif+1;
}

// Fetching datas from inc arrays and puts into select options...
function selectArrayHash($arryhashname, $in='') {
	global $$arryhashname;
	$op='';$selected = '';
	foreach ($$arryhashname as $key => $value) {
		if ($in == $key) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		$op .= "<option value=\"$key\" $selected>$value</option>";
	}
	return $op;
}

function selectMultipleArrayHash($arryhashname, $in='') {
	global $$arryhashname;
	$op='';$selected = '';
	asort($$arryhashname);
	foreach ($$arryhashname as $key => $value) {
		if ( $in!='') {
			foreach ($in as $key1 => $value1) {
				if ($key == $value1) {
					$selected = 'Selected';
					break;
				} else {
					$selected = '';
				}
			}
		}
		$op .= "<option value=\"$key\" $selected>".ucfirst($value)."</option>";
	}	
	return $op;
}

function selectMultipleRightControl ($arryhashname, $in='') {
	global $$arryhashname;
	$op='';$selected = '';
	if(is_array($$arryhashname)) {
		foreach ($$arryhashname as $key => $value) {
			if (is_array($in) && in_array($key, $in)) {
				//$selected = 'Selected';
				$op .= "<option value=\"$key\" $selected>$value</option>";
			} else {
				$selected = '';
			}
		}
	}
	return $op;
}


function selectMultipleLeftControl ($arryhashname, $in='',$anyflag=true) {
	global $$arryhashname, $ln;
	$op='';$selected = '';
	if($anyflag==true && $ln=="en") {
		asort($$arryhashname);
	}
	if(is_array($$arryhashname)) {
		foreach ($$arryhashname as $key => $value) {
			if (is_array($in) && in_array($key, $in)) {
				//$selected = 'selected';
				$op .= "<option value=\"$key\" ".$selected.">$value</option>";
			} else {
				$op .= "<option value=\"$key\" >$value</option>";
			}
		}
	}
	return $op;
}

function multipleCheckArrayHash($arryhashname, $chkname, $in='', $onclick='') {
	global $$arryhashname;
	$op='';$selected = '';
	foreach ($$arryhashname as $key => $value) {
		if ( $in!='') {
			foreach ($in as $key1 => $value1) {
				if ($key == $value1) {
					$selected = 'Checked';
					break;
				} else {
					$selected = '';
				}
			}
		}
		if ($onclick != '') {
			$op .= '<input type="checkbox" name="'.$chkname.'[]" value="'.$key.'" id="'.$chkname.$key.'" '.$selected.' onclick="return '.$onclick.'()" > '.$value;
		} else {
			$op .= '<input type="checkbox" name="'.$chkname.'[]" value="'.$key.'" id="'.$chkname.$key.'" '.$selected.' > '.$value;
		}
	}
	return $op;
}

// Value Retrival from Array function //
function getFromArryHash ($arryhashname, $in='') {
	global $$arryhashname; 
	if (!is_array($$arryhashname)) {
		if ($_REQUEST['debug']==1 || $_REQUEST['Debug']=='debug') {
			echo $arryhashname;
		}
	}
	if (array_key_exists($in,$$arryhashname)) {
		$out = ${$arryhashname}[$in];
		return (($out != '')?$out:'-');
	} else {
		return '-';
	}
}

// Redirecting to Error landing page //
function errorLanding($errmsg='', $errpg='') {
	header("Location: http://".$_SERVER['SERVER_NAME']."/bmgen/errorlanding.php?errpg=$errpg&errmsg=$errmsg");
	exit;
}

// GET CONTENT FROM THE GIVEN FILE
function getContentFromFile($argFileName) {
	if(!$funFP = fopen($argFileName, "r"))
	{ echo 'Error: Please check file permission or file name.'; }//if
	
	if(filesize($argFileName) > 0)
	{
		if(!$funFileContent = fread($funFP, filesize($argFileName)))
		{ echo 'Error: Please check file permission or file name.'; }//if
	}//if
	else { echo "File doesn't contain any text"; }//else
	fclose($funFP);
	$retFileContent = trim($funFileContent);
	
	return $retFileContent;
}//getContentToFile

//PUT CONTENT TO THE GIVEN FILE
function putContentToFile($argFileName, $argFileContent, $argAction="")
{
	if(is_writeable($argFileName))
	{
		$funFP = fopen($argFileName, "w");
		$funFileContent = fwrite($funFP, $argFileContent);
		fclose($funFP);
		
		if($argAction == "add"){ $retFileContent = "<br>Sucessfully Added.<br><br>"; }//if
		else{ $retFileContent = "Sucessfully updated."; }//else
	}//if
	else { $retFileContent = "Permission Denied. Please change the file permission & update."; }//else
	
	return $retFileContent;
}//putContentToFile

//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
function sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress)
{
	$funValue				= "";
	$funheaders				= "";
	$argFrom				= preg_replace("/\n/", "", $argFrom);
	$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
	$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
	$funheaders				.= "MIME-Version: 1.0\n";
	$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
	$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
	$funheaders				.= "Reply-To: ".$argReplyToEmailAddress."<".$argReplyToEmailAddress.">\n";
	$funheaders				.= "Return-Path:".$argReplyToEmailAddress."<".$argReplyToEmailAddress.">\n";
	$argheaders				= $funheaders;
	$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress); 
	if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
	$retValue = $funValue;
	return $retValue;	
}//sendEmail



//freeTextWordCut function used to cut words from given string
function freeTextWordCut($srchtext, $freetext) {
	global $COMMONVARS;
	if(array_key_exists($freetext, $COMMONVARS['FREETEXT_WORDCOUNT'])) {
		$srchtextlen = strlen($srchtext);
		if($srchtextlen > $COMMONVARS['FREETEXT_WORDCOUNT'][$freetext]) {
			$checkchar = substr($srchtext, $COMMONVARS['FREETEXT_WORDCOUNT'][$freetext]+1,1);
			if($checkchar == " " || $checkchar == "," || $checkchar == ".") {
				return substr($srchtext, 0, $COMMONVARS['FREETEXT_WORDCOUNT'][$freetext])."...";
			}
			else {
				$newtext = substr($srchtext, 0, $COMMONVARS['FREETEXT_WORDCOUNT'][$freetext]);
				$newtextarr = explode(" ",$newtext);
				if(count($newtextarr) > 1) {
					$finaltextarr = array_pop($newtextarr);
				}
				if(is_array($newtextarr)) {
					return implode(" ",$newtextarr);
				}
				else {
					return $newtext;
				}
			}
		}
		else {
			return $srchtext;
		}
	}
	else {
		return $srchtext;
	}
}

// Send Mail With Attachment //
function sendMailAttach($fromId, $toId, $ccId, $subject, $message, $attachment_array,$argfilename) {
	global $script_path;
	$email_from = $fromId; // Who the email is from 
	$email_subject = $subject; // The Subject of the email 
	$email_txt = $message; // Message that the email has in it 

	$email_to = $toId; // Who the email is too 
	$email_cc = $ccId;

	$headers  = "From: ".$email_from."\n"; 
	$headers .= "Cc: ".$email_cc."\n"; 

	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

	$headers .= "MIME-Version: 1.0\n" . 
	"Content-Type: multipart/mixed;\n" . 
	" boundary=\"{$mime_boundary}\""; 
	$email_message = "";

	$email_message .= $email_txt."\n\n";
	$email_message .= "This is a multi-part message in MIME format.\n\n" . 
	"--{$mime_boundary}\n" . 
	"Content-Type:text/html; charset=\"iso-8859-1\"\n" . 
	"Content-Transfer-Encoding: 7bit\n\n" . 
	$email_message . "\n\n"; 
	if($attachment_array!='')
		{
		$fileatt = $attachment_array['tmp_name']; // Path to the file 
		$fileatt_type = "application/octet-stream"; // File Type 
		$fileatt_name = $argfilename; // Filename that will be used for the file as the attachment 

		$file = fopen($fileatt,'rb'); 
		$data = fread($file,filesize($fileatt)); 
		fclose($file); 

		$data = chunk_split(base64_encode($data)); 

		$email_message .= "--{$mime_boundary}\n" . 
		"Content-Type: {$fileatt_type};" . 
		" name=\"{$fileatt_name}\"\n" . 
		//"Content-Disposition: attachment;" . 
		//" filename=\"{$fileatt_name}\"\n\n" . 
		"Content-Transfer-Encoding: base64\n\n" . 
		$data . "\n\n";
		//."--{$mime_boundary}--\n\n"; 
		}
	$email_message .="--{$mime_boundary}--\n\n";
	$ok = @mail($email_to, $email_subject, $email_message, $headers); 
	if($ok) { $funValue = 'yes'; }; 
	$retValue = $funValue;
	return $retValue;	
}

// Send Mail with CC BCC //
function sendEmailwithCC($argFromEmail,$argToEmail,$argSubject,$argMessage,$argReplyTo,$argCC,$argBcc) {
	$funValue				= "";
	$funheaders				= "";
	$argFromEmail			= preg_replace("/\n/", "", $argFromEmail);
	$argReplyTo				= preg_replace("/\n/", "", $argReplyTo);
	$funheaders				.= "MIME-Version: 1.0\n";
	$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
	$funheaders				.= "From:".$argFromEmail."<".$argFromEmail.">\n";
	if($argCC!='')
	{ $funheaders				.= "Cc:".$argCC."<".$argCC.">\n"; }
	if($argBcc!='')
	{ $funheaders				.= "Bcc:".$argBcc."<".$argBcc.">\n"; }
	$funheaders				.= "Reply-To: ".$argReplyTo."<".$argReplyTo.">\n";
	$funheaders				.= "Return-Path:".$argToEmail."<".$argToEmail.">\n";
	$argheaders				= $funheaders;
	$argToEmail				= preg_replace("/\n/", "", $argToEmail); 
	if (mail($argToEmail, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
	$retValue = $funValue;
	return $retValue;	
}//sendEmail

function strToTitle($title) { 
	$smallwordsarray = array( 'of','a','the','and','an','or','nor','but','is','if','then','else','when', 'at','from','by','on','off','for','in','out','over','to','into','with','.'); 
	$title = str_replace(".",". ",$title);
	$words = explode(' ', strtolower($title)); 
	foreach ($words as $key => $word) { 
		if ($key == 0 or !in_array($word, $smallwordsarray)) {
			$words[$key] = ucwords($word); 
		}
	} 
	$newtitle = implode(' ', $words); 
	$newtitle = str_replace(". ",".",$newtitle);
	return $newtitle; 
}


function getActiveStatus($LastLogin,$TimeCreated){
	$within = "Within last ";

	if($LastLogin=="0000-00-00 00:00:00") {
		$lst = split('[- :]',$TimeCreated);
	} 
	else {
		$lst = split('[- :]',$LastLogin);
	}

	$currenttime = time();
	$difftime = $currenttime - strtotime(date("d-M-Y H:i", mktime($lst[3],$lst[4],0,$lst[1],$lst[2],$lst[0])));
	$days = $difftime/(24*3600);

	if($days <= 1) {
		$hours = $difftime/3600;
		if($hours < 1) {
			if(floor($difftime/60) <= 5) {
				return "Online Right NOW!";
			}
			else {
				return $within.floor($difftime/60)." minutes";
			}
		}
		else {
			if(floor($difftime/3600) <= 1) {
				return $within."1 hour";
			}
			else {
				return $within.floor($difftime/3600)." hours";
			}
		}
	}
	else if($days > 1 && $days <= 7) {
		if(floor($days) <= 1) {
			return $within.floor($days)." day";
		}
		else {
			return $within.floor($days)." days";
		}
	}
	else if($days > 7 && $days <= 30) {
		if(floor($days/7) <= 1) {
			return $within.floor($days/7)." week";
		}
		else {
			return floor($days/7)." weeks";
		}
	}
	else if($days > 30 && $days <= 90) {
		if(floor($days/30) <=1) {
			return $within.floor($days/30)." month";
		}
		else {
			return $within.floor($days/30)." months";
		}
	}
	else {
		return $within."3 months";
	}
}

function splitPartnerPreferenceCookieValues($mempartinfo){
	Global $COOKIEINFO;
	$ppValues							= split('\|', $mempartinfo);
    	$ageValues							= split('~', $ppValues[0]); 
	$htValues							= split('~', $ppValues[1]);

    $returnPpInfo['Gender']				= $COOKIEINFO['LOGININFO']['GENDER'];  
	$returnPpInfo['StAge']				= $ageValues[0];
	$returnPpInfo['EndAge']				= $ageValues[1]; 
	$returnPpInfo['StHeight']			  = $htValues[0];
	$returnPpInfo['EndHeight']			= $htValues[1];

	$returnPpInfo['MatchMaritalStatus'] = $ppValues[2];
	$returnPpInfo['PhysicalStatus']		= $ppValues[3];
	$returnPpInfo['MatchMotherTongue']     = $ppValues[4];
	$returnPpInfo['MatchReligion']		= $ppValues[5];
	$returnPpInfo['Manglik']			= $ppValues[6]; 
	$returnPpInfo['MatchCaste']			= $ppValues[7];
	$returnPpInfo['EatinghabitsPref']   = $ppValues[8];
	$returnPpInfo['MatchEducation']		= $ppValues[9];
	$returnPpInfo['MatchCountry']       = $ppValues[11];
	$returnPpInfo['ResidingIndiaState'] = $ppValues[12];
	$returnPpInfo['ResidingUsState']    = $ppValues[13];
	$returnPpInfo['MatchLanguage']      = $ppValues[15];
	$returnPpInfo['Gothra']		    = $ppValues[16];
	$returnPpInfo['StIncome']      = $ppValues[17];
	$returnPpInfo['EndIncome']      = $ppValues[18];

	return $returnPpInfo;
}





function calculateregage($DOB) {
	$bday = strtotime($DOB);
	$now = time();
	$diff = $now-$bday;
	$Age = floor($diff/(60*60*24*365));
	return $Age;
}
?>
