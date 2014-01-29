<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsBasicview.php');

Class Message extends BasicView
{
	function getDaysTextInfo($argDate) 
	{
		$lst = split('[- :]',$argDate);
		$funCurrenttime = time();
		$funDifftime	= $funCurrenttime - strtotime(date("d-M-Y", mktime(0,0,0,$lst[1],$lst[2],$lst[0])));
		$funDays		= $funDifftime/(24*3600);

		if($funDays > 0 && $funDays <= 7) {
			return $funDaysTxtVal = (floor($funDays) <= 1 && date("d")==$lst[2]) ? "Today" : floor($funDays)." days ago";
		}else if($funDays > 7 && $funDays <= 30) {
			return $funDaysTxtVal = (floor($funDays/7) <= 1) ? "1 week ago" : floor($funDays/7)." weeks ago";
		}else if($funDays > 30 && $funDays <= 365) {
			return $funDaysTxtVal = (floor($funDays/30) <=1) ? "1 month ago" : floor($funDays/30)." months ago";
		}else if($funDays > 365) {
			return $funDaysTxtVal = (floor($funDays/365) <=1) ? "1 year ago" : floor($funDays/365)." years ago";
		}

	}//getDaysTextInfo

	function abusivewordsOccurance($argMessage)
	{
		global $arrCompetitorList,$arrBadwordsList,$arrFraudwordsList;
		$funSpamFlag = 0;
		while (list($key,$valu) = each($arrCompetitorList)) {
			if(preg_match("/\b$valu\b/i", $argMessage)) { $funSpamFlag=1; return $funSpamFlag;}
		}
		while (list($key,$valu) = each($arrBadwordsList)) {
			if(preg_match("/\b$valu\b/i", $argMessage)) { $funSpamFlag=1; return $funSpamFlag;}
		}
		while (list($key,$valu) = each($arrFraudwordsList)) {
			if(preg_match("/\b$valu\b/i", $argMessage)) { $funSpamFlag=1; return $funSpamFlag;}
		}
		return $funSpamFlag;
	}//abusivewordsOccurance

	function fixScriptTag($msg){
		$searcharray = array("/javascript:/si", "/about:/si", "/vbscript:/si","/<script>.*<\/script>/si");
		$replacearray = array("java, not allowed, script:", "about :", "vb, not allowed, script :", "normal, not allowed, script :");
		$msg = preg_replace($searcharray, $replacearray, $msg);
		 return $msg;
	}//fixStuff

	function cross($msg){
		 $searcharray = array("/(\[)(url)(=)(['\"]?)([^\"']*)(\\4])(.*)(\[\/url\])/esiU","/(\[)(url)(])([^\"]*)(\[\/url\])/esiU");
		 $replacearray = array("checkurl('\\5', '\\7')","checkurl('\\4')");
		$msg = preg_replace($searcharray, $replacearray, $msg);
		return $msg;
	}//cross
}
?>