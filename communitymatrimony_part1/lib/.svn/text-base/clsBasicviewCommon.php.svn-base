<?php
class BasicviewCommon
{
	function getPostValues($argVal){
		$arrValues = explode('#^#', trim($argVal,'#^#'));
		foreach($arrValues as $varSinVal){
			$arrVal  = split('=', $varSinVal);
			$_POST[$arrVal[0]] = $arrVal[1]; 
		}
	}

	function getTempPostValues($argVal){
		$arrValues = explode('#^#', trim($argVal,'#^#'));
		$arrOldVal = array();
		foreach($arrValues as $varSinVal){
			$arrVal  = split('=', $varSinVal);
			$arrOldVal[$arrVal[0]] = $arrVal[1]; 
		}
		return $arrOldVal;
	}

	function encryptData($argVal)
	{
		//Fields Encrypting
		$funVal = preg_replace("/gender/", 'G^', $argVal);
		$funVal = preg_replace("/ageFrom/", '@F^', $funVal);
		$funVal = preg_replace("/ageTo/", '@T^', $funVal);
		$funVal = preg_replace("/heightFrom/", '!F^', $funVal);
		$funVal = preg_replace("/heightTo/", '!T^', $funVal);
		$funVal = preg_replace("/maritalStatus/", 'MS^', $funVal);
		$funVal = preg_replace("/haveChildren/", 'CLS^', $funVal);
		$funVal = preg_replace("/motherTongue/", 'MT^', $funVal);
		$funVal = preg_replace("/religion/", 'RI^', $funVal);
		$funVal = preg_replace("/denomination/", 'DE^', $funVal);
		$funVal = preg_replace("/subcaste/", 'SID^', $funVal);
		$funVal = preg_replace("/caste/", 'CAID^', $funVal);
		$funVal = preg_replace("/gothram/", 'GID^', $funVal);
		$funVal = preg_replace("/physicalStatus/", 'PS^', $funVal);
		$funVal = preg_replace("/citizenship/", 'CI^', $funVal);
		$funVal = preg_replace("/country/", 'CO^', $funVal);
		$funVal = preg_replace("/residentStatus/", 'RS^', $funVal);
		$funVal = preg_replace("/education/", 'EC^', $funVal);
		$funVal = preg_replace("/occupation/", 'OC^', $funVal);
		$funVal = preg_replace("/occupationCat/", 'EI^', $funVal);
		$funVal = preg_replace("/eating/", 'EH^', $funVal);
		$funVal = preg_replace("/smoking/", 'SM^', $funVal);
		$funVal = preg_replace("/drinking/", 'DR^', $funVal);
		$funVal = preg_replace("/residingState/", 'RST^', $funVal);
		$funVal = preg_replace("/residingCity/", 'RD^', $funVal);
		$funVal = preg_replace("/star/", 'STR^', $funVal);
		$funVal = preg_replace("/raasi/", 'RAA^', $funVal);
		$funVal = preg_replace("/annualIncome/", 'TAI^', $funVal);
		$funVal = preg_replace("/manglik/", 'CD^', $funVal);
		$funVal = preg_replace("/active/", 'AT^', $funVal);
		$funVal = preg_replace("/bodyType/", 'BT^', $funVal);

		$funVal = preg_replace("/photoOpt/", 'PSS^', $funVal);
		$funVal = preg_replace("/horoscopeOpt/", 'HA^', $funVal);
		$funVal = preg_replace("/alreadyViewedOpt/", 'AV^', $funVal);
		$funVal = preg_replace("/alreadyContOpt/", 'AC^', $funVal);
		$funVal = preg_replace("/shortlistOpt/", 'SL^', $funVal);

		$funVal = preg_replace("/=/", '^~^', $funVal);
			
		return addslashes($funVal);
	}

	function decryptData($argVal)
	{
		$funVal = stripslashes($argVal);

		//Fields decrypting
		$funVal = preg_replace("/G\\^/", 'gender', $argVal);
		$funVal = preg_replace("/@F\\^/", 'ageFrom', $funVal);
		$funVal = preg_replace("/@T\\^/", 'ageTo', $funVal);
		$funVal = preg_replace("/!F\\^/", 'heightFrom', $funVal);
		$funVal = preg_replace("/!T\\^/", 'heightTo', $funVal);
		$funVal = preg_replace("/MS\\^/", 'maritalStatus', $funVal);
		$funVal = preg_replace("/CLS\\^/", 'haveChildren', $funVal);
		$funVal = preg_replace("/MT\\^/", 'motherTongue', $funVal);
		$funVal = preg_replace("/RI\\^/", 'religion', $funVal);
		$funVal = preg_replace("/DE\\^/", 'denomination', $funVal);
		$funVal = preg_replace("/CAID\\^/", 'caste', $funVal);
		$funVal = preg_replace("/SID\\^/", 'subcaste', $funVal);
		$funVal = preg_replace("/GID\\^/", 'gothram', $funVal);
		$funVal = preg_replace("/PS\\^/", 'physicalStatus', $funVal);
		$funVal = preg_replace("/CI\\^/", 'citizenship', $funVal);
		$funVal = preg_replace("/CO\\^/", 'country', $funVal);
		$funVal = preg_replace("/RS\\^/", 'residentStatus', $funVal);
		$funVal = preg_replace("/EC\\^/", 'education', $funVal);
		$funVal = preg_replace("/OC\\^/", 'occupation', $funVal);
		$funVal = preg_replace("/EI\\^/", 'occupationCat', $funVal);
		$funVal = preg_replace("/EH\\^/", 'eating', $funVal);
		$funVal = preg_replace("/SM\\^/", 'smoking', $funVal);
		$funVal = preg_replace("/DR\\^/", 'drinking', $funVal);
		$funVal = preg_replace("/RST\\^/", 'residingState', $funVal);
		$funVal = preg_replace("/RD\\^/", 'residingCity', $funVal);
		$funVal = preg_replace("/STR\\^/", 'star', $funVal);
		$funVal = preg_replace("/RAA\\^/", 'raasi', $funVal);
		$funVal = preg_replace("/TAI\\^/", 'annualIncome', $funVal);
		$funVal = preg_replace("/CD\\^/", 'manglik', $funVal);
		$funVal = preg_replace("/AT\\^/", 'active', $funVal);
		$funVal = preg_replace("/BT\\^/", 'bodyType', $funVal);

		$funVal = preg_replace("/PSS\\^/", 'photoOpt', $funVal);
		$funVal = preg_replace("/HA\\^/", 'horoscopeOpt', $funVal);
		$funVal = preg_replace("/AV\\^/", 'alreadyViewedOpt', $funVal);
		$funVal = preg_replace("/AC\\^/", 'alreadyContOpt', $funVal);
		$funVal = preg_replace("/SL\\^/", 'shortlistOpt', $funVal);

		$funVal = preg_replace("/\\^~\\^/", '=', $funVal);
		return $funVal;
	}
}
?>