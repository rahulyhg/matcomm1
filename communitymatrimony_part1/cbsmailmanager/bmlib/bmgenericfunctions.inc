<?php
/* ************************************************************************************************** */
/* File		: bmgenericfunctions.inc
/* Author	: Ashok kumar, Mano, Kumaran, Saravanan
/* Date		: 12-Dec-2007
/* ************************************************************************************************** */
/* Description	: 
/*     This inc file holds commonly used functions.
/* ************************************************************************************************** */

// DoCrypt //
function doCrypt($matriid) {
	$level1 = crypt($matriid,"RPH");
	return crypt($level1,"BM");
}

// Get Domain Info //
function getDomainInfo($type='', $val='') {

	$DOMAINARRAY = array();

	if(trim($type)==1) { // $val is matriid	
		$domainletter = strtoupper(substr($val,0,3));
	    $domainid = array_search($domainletter,$GLOBALS['arrMatriIdPre']);
		$domainname = $GLOBALS['arrFolderNames'][$domainletter];
		$domainpath = $GLOBALS['arrPrefixDomainList'][$domainletter];
		$foldername = $GLOBALS['arrFolderNames'][$domainletter];
	} elseif ($type==2) { // $val is domain id as int
	    $domainid = $val;
		$domainletter =  $GLOBALS['arrMatriIdPre'][$domainid];
		$domainname = $GLOBALS['arrFolderNames'][$domainletter];
		$domainpath = $GLOBALS['arrPrefixDomainList'][$domainletter];
		$foldername = $GLOBALS['arrFolderNames'][$domainletter];
	}  

	$DOMAINARRAY['domainid'] = $domainid;  // eg 1
	$DOMAINARRAY['domainnameshort'] = $domainname; // eg mudaliyar
	$DOMAINARRAY['domainnamelong'] = $domainpath; // eg mudaliyarmatrimony.com
	$DOMAINARRAY['domainnamefolder'] = $foldername; // eg mudaliyar
	$DOMAINARRAY['domainnamebmser'] = 'bmser.'.$domainname.'matrimony.com'; // eg bmser.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameweb'] = 'www.'.$domainname.'matrimony.com'; // eg www.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimg'] = 'img.'.$domainname.'matrimony.com'; // eg img.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimgs'] = 'imgs.'.$domainname.'matrimony.com'; // eg imgs.mudaliyarmatrimony.com
	$DOMAINARRAY['domainnameimage'] = 'image.'.$domainname.'matrimony.com'; // eg image.mudaliyarmatrimony.com

	return $DOMAINARRAY;
}

// Host Convert //
function hostConvert($type='', $convert='') {
	if ($type=='' or $convert=='') {
		return $_SERVER['SERVER_NAME'];
	} else {
		// $type actual domain module eg. $type=www
		// $convert  domain module to be converted eg. $convert=bmser
		// eg www.tamilmatrimony.com convert as bmser.tamilmatrimony.com
		return str_replace ($type,$convert,$_SERVER['SERVER_NAME']); 
	}
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
				$selected = 'Selected';
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
				$selected = 'selected';
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

?>