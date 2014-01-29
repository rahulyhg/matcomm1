<?php
class BasicviewCommon
{
	function encryptData($argVal)
	{
		//Fields Encrypting
		$funVal = preg_replace("/Gender/", 'G^', $argVal);
		$funVal = preg_replace("/Age/", '@^', $funVal);
		$funVal = preg_replace("/Height/", '!^', $funVal);
		$funVal = preg_replace("/Marital_Status/", 'MS^', $funVal);
		$funVal = preg_replace("/Children_Living_Status/", 'CLS^', $funVal);
		$funVal = preg_replace("/No_Of_Children/", 'NOC^', $funVal);
		$funVal = preg_replace("/Mother_TongueId/", 'MT^', $funVal);
		$funVal = preg_replace("/Mother_TongueText/", 'MTXT^', $funVal);
		$funVal = preg_replace("/Religion/", 'RI^', $funVal);
		$funVal = preg_replace("/Denomination/", 'DE^', $funVal);
		$funVal = preg_replace("/CasteId/", 'CAID^', $funVal);
		$funVal = preg_replace("/CasteText/", 'CTXT^', $funVal);
		$funVal = preg_replace("/CommunityId/", 'CID^', $funVal);
		$funVal = preg_replace("/SubcasteId/", 'SID^', $funVal);
		$funVal = preg_replace("/SubcasteText/", 'STXT^', $funVal);
		$funVal = preg_replace("/GothramId/", 'GID^', $funVal);
		$funVal = preg_replace("/GothramText/", 'GTXT^', $funVal);
		$funVal = preg_replace("/Physical_Status/", 'PS^', $funVal);
		$funVal = preg_replace("/Citizenship/", 'CI^', $funVal);
		$funVal = preg_replace("/Country/", 'CO^', $funVal);
		$funVal = preg_replace("/Resident_Status/", 'RS^', $funVal);
		$funVal = preg_replace("/Education_Category/", 'EC^', $funVal);
		$funVal = preg_replace("/Occupation/", 'OC^', $funVal);
		$funVal = preg_replace("/Employed_In/", 'EI^', $funVal);
		$funVal = preg_replace("/Eating_Habits/", 'EH^', $funVal);
		$funVal = preg_replace("/Smoke/", 'SM^', $funVal);
		$funVal = preg_replace("/Drink/", 'DR^', $funVal);
		$funVal = preg_replace("/Photo_Set_Status/", 'PSS^', $funVal);
		$funVal = preg_replace("/Horoscope_Available/", 'HA^', $funVal);
		$funVal = preg_replace("/Publish/", 'P^', $funVal);
		$funVal = preg_replace("/Date_Created/", 'DC^', $funVal);
		$funVal = preg_replace("/Residing_State/", 'RST^', $funVal);
		$funVal = preg_replace("/Residing_District/", 'RD^', $funVal);
		$funVal = preg_replace("/MatriId/", 'MD^', $funVal);
		$funVal = preg_replace("/Last_Login/", 'LL^', $funVal);
		$funVal = preg_replace("/Star/", 'STR^', $funVal);
		$funVal = preg_replace("/Raasi/", 'RAA^', $funVal);
		$funVal = preg_replace("/Temp_Annual_Income/", 'TAI^', $funVal);
		$funVal = preg_replace("/Chevvai_Dosham/", 'CD^', $funVal);
		//for membersonline
		$funVal = preg_replace("/icstatus/", 'IC^', $funVal);
		$funVal = preg_replace("/SELECT/", 'SE^', $funVal);
		$funVal = preg_replace("/Status/", 'ST^', $funVal);
		$funVal = preg_replace("/FROM/", 'FR^', $funVal);


		//WHERE, =, AND , OR ,-encrypting
		$funVal = preg_replace("/WHERE\s/", '@@', $funVal);
		$funVal = preg_replace("/IN\s/", 'I@', $funVal);
		$funVal = preg_replace("/LIKE '%/", 'LKF', $funVal);
		$funVal = preg_replace("/%'/", 'LKL', $funVal);
		$funVal = preg_replace('/=/', '^~^', $funVal);
		$funVal = preg_replace("/\sAND\s/", '$', $funVal);
		$funVal = preg_replace("/\sOR\s/", '#', $funVal);
		$funVal = preg_replace('/\sORDER\sBY\s/', 'OB@', $funVal);
		$funVal = preg_replace('/DESC/', 'DE@', $funVal);
		$funVal = preg_replace('/ASC/', 'AS@', $funVal);

		$funVal = addslashes($funVal);
		return $funVal;
	}

	function decryptData($argVal)
	{
		$funVal = stripslashes($argVal);

		//Fields decrypting
		$funVal = preg_replace("/G\\^/", 'Gender', $funVal);
		$funVal = preg_replace("/@\\^/", 'Age', $funVal);
		$funVal = preg_replace("/!\\^/", 'Height', $funVal);
		$funVal = preg_replace("/MS\\^/", 'Marital_Status', $funVal);
		$funVal = preg_replace("/CLS\\^/", 'Children_Living_Status', $funVal);
		$funVal = preg_replace("/NOC\\^/", 'No_Of_Children', $funVal);
		$funVal = preg_replace("/MT\\^/", 'Mother_TongueId', $funVal);
		$funVal = preg_replace("/MTXT\\^/", 'Mother_TongueText', $funVal);
		$funVal = preg_replace("/RI\\^/", 'Religion', $funVal);
		$funVal = preg_replace("/DE\\^/", 'Denomination', $funVal);
		$funVal = preg_replace("/CAID\\^/", 'CasteId', $funVal);
		$funVal = preg_replace("/CTXT\\^/", 'CasteText', $funVal);
		$funVal = preg_replace("/CID\\^/", 'CommunityId', $funVal);
		$funVal = preg_replace("/SID\\^/", 'SubcasteId', $funVal);
		$funVal = preg_replace("/STXT\\^/", 'SubcasteText', $funVal);
		$funVal = preg_replace("/GID\\^/", 'GothramId', $funVal);
		$funVal = preg_replace("/GTXT\\^/", 'GothramText', $funVal);
		$funVal = preg_replace("/PS\\^/", 'Physical_Status', $funVal);
		$funVal = preg_replace("/CI\\^/", 'Citizenship', $funVal);
		$funVal = preg_replace("/CO\\^/", 'Country', $funVal);
		$funVal = preg_replace("/RS\\^/", 'Resident_Status', $funVal);
		$funVal = preg_replace("/EC\\^/", 'Education_Category', $funVal);
		$funVal = preg_replace("/OC\\^/", 'Occupation', $funVal);
		$funVal = preg_replace("/EI\\^/", 'Employed_In', $funVal);
		$funVal = preg_replace("/EH\\^/", 'Eating_Habits', $funVal);
		$funVal = preg_replace("/SM\\^/", 'Smoke', $funVal);
		$funVal = preg_replace("/DR\\^/", 'Drink', $funVal);
		$funVal = preg_replace("/PSS\\^/", 'Photo_Set_Status', $funVal);
		$funVal = preg_replace("/HA\\^/", 'Horoscope_Available', $funVal);
		$funVal = preg_replace("/P\\^/", 'Publish', $funVal);
		$funVal = preg_replace("/DC\\^/", 'Date_Created', $funVal);
		$funVal = preg_replace("/RST\\^/", 'Residing_State', $funVal);
		$funVal = preg_replace("/RD\\^/", 'Residing_District', $funVal);
		$funVal = preg_replace("/MD\\^/", 'MatriId', $funVal);
		$funVal = preg_replace("/LL\\^/", 'Last_Login', $funVal);
		$funVal = preg_replace("/STR\\^/", 'Star', $funVal);
		$funVal = preg_replace("/RAA\\^/", 'Raasi', $funVal);
		$funVal = preg_replace("/TAI\\^/", 'Temp_Annual_Income', $funVal);
		$funVal = preg_replace("/CD\\^/", 'Chevvai_Dosham', $funVal);

		//for membersonline
		$funVal = preg_replace("/IC\\^/", 'icstatus', $funVal);
		$funVal = preg_replace("/SE\\^/", 'SELECT', $funVal);
		$funVal = preg_replace("/ST\\^/", 'Status', $funVal);
		$funVal = preg_replace("/FR\\^/", 'FROM', $funVal);
		
		//WHERE, =, AND , OR ,-decrypting
		$funVal = preg_replace('/@@/', 'WHERE ', $funVal);
		$funVal = preg_replace("/I@/", 'IN ', $funVal);
		$funVal = preg_replace('/LKF/', "LIKE '%", $funVal);
		$funVal = preg_replace('/LKL/', "%'", $funVal);
		$funVal = preg_replace('/\^~\^/', '=', $funVal);
		$funVal = preg_replace("/\\$/", ' AND ', $funVal);
		$funVal = preg_replace("/#/", ' OR ', $funVal);
		$funVal = preg_replace('/OB@/', ' ORDER BY ', $funVal);
		$funVal = preg_replace('/DE@/', 'DESC', $funVal);
		$funVal = preg_replace('/AS@/', 'ASC', $funVal);

		return $funVal;
	}
}
?>