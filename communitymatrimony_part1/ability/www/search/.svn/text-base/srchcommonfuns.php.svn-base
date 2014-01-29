<?php
$arrSaveResStateList = array();
$arrSaveResCityList = array();
function genCountryBasedStates() {
	global $arrUSAStateList,$arrResidingStateList,$arrSaveResStateList;
	echo "states=new Array();";
	echo "cities=new Array();";
	$india_states = "states[98]=[";
	foreach($arrResidingStateList as $k=>$v) {
		$arrSaveResStateList["98".$k] = $v; 
		$india_states .= "'".$v."|98".$k."',";
		echo genStateBasedCities("98",$k);
	}
	echo trim($india_states, ',')."];";
	$usa_states = "states[222]=[";
	foreach($arrUSAStateList  as $k=>$v) {
		$arrSaveResStateList["222".$k] = $v; 
		$usa_states .= "'".$v."|222".$k."',";
	}
	echo trim($usa_states, ',')."];";
}

function genStateBasedCities($countryid,$stateid) {
	global $residingCityStateMappingList, ${$residingCityStateMappingList[$stateid]};

	$citites	= "cities['".$countryid.$stateid."']=[";
	$spc_state	= ${$residingCityStateMappingList[$stateid]};
	asort($spc_state);
	foreach($spc_state as $k=>$v) {
		$citites .= "'".$v."|".$k."',";
	} 
	echo trim($citites, ',')."];";
}

function getTotalSavedCity($argStateList){
	global $residingCityStateMappingList, $arrSaveResCityList;
	$arrState	= split('~', $argStateList);
	foreach($arrState as $varSinState){
		if(substr($varSinState, 0, 2)==98){
			$varStateVal = $residingCityStateMappingList[ltrim($varSinState, 98)];
			global $$varStateVal;
			$arrCurrState = $$varStateVal;
			$arrSaveResCityList = $arrSaveResCityList+$arrCurrState;
		}
	}
}

function getValues($argCurrVal, $argSourceArray, $argField=''){
	$varRetVal	= '';
	if(preg_match("/~/", trim($argCurrVal,'~'))){
		$arrVal = split('~', trim($argCurrVal));
		if(count($arrVal)>0){
			$xy=0;
			foreach($arrVal as $varSinVal){
				if($argSourceArray[$varSinVal]!=''){
					if($xy==0){	$varRetVal = '&nbsp;<font class="clr2">|</font>&nbsp;';}
					$varRetVal .= $argSourceArray[$varSinVal]=='' ? '' : $argSourceArray[$varSinVal].', ';
					$xy++;
				}
			}
			$varRetVal = rtrim($varRetVal, ', ');
		}
	}else if($argField == '' && $argSourceArray[$argCurrVal]!=''){
		$varRetVal = '&nbsp;<font class="clr2">|</font>&nbsp;'. $argSourceArray[$argCurrVal];
	}else{ $varRetVal = $argSourceArray[$argCurrVal];}
	return $varRetVal;
}

function savedSearchDetail($argSrchArray){
	global $arrHeightFeetList, $arrMaritalList, $arrReligionList, $arrMotherTongueList;
	$varSrchType = ($argSrchArray['Search_Type']==2) ? 'Advanced' : 'Basic';
	$varEditLink = ($argSrchArray['Search_Type']==2) ? $argSrchArray['Search_Id'].'&act=advsearch' : $argSrchArray['Search_Id'];
	
	$varRetVal   = '<div class="normtxt clr lh20 padtb5" id="'.$argSrchArray['Search_Id'].'"><div class="fleft"><b>'.$argSrchArray['Search_Name'].'</b> ('.$varSrchType.'	Search)</div><div class="fright clr2 smalltxt"><a class="clr1" href="'.$confValues['SERVERURL'].'/search/index.php?srchId='.$varEditLink.'">Edit</a> &nbsp;|&nbsp; <a class="clr1" href="javascript:;" onclick="srchDel('.$argSrchArray['Search_Id'].',\''.$argSrchArray['Search_Name'].'\',\'N\');">Delete</a> &nbsp;|&nbsp; <a class="clr1" href="'.$confValues['SERVERURL'].'/search/index.php?act=srchresult&srchId='.$argSrchArray['Search_Id'].'">Search</a></div><br clear="all"><div class="fleft">'.$argSrchArray['Age_From'].' to '.$argSrchArray['Age_To'].' yrs &nbsp;<font class="clr2">|</font>&nbsp; '.getValues($argSrchArray['Height_From'],$arrHeightFeetList, 'no').' to '.getValues($argSrchArray['Height_To'],$arrHeightFeetList, 'no'). getValues($argSrchArray['Marital_Status'],$arrMaritalList). getValues($argSrchArray['Religion'].'~ ',$arrReligionList). getValues($argSrchArray['Mother_Tongue'],$arrMotherTongueList).' ...</div><br clear="all"><br clear="all"><div class="linesep"><img width="1" height="1" src="'.$confValues['IMGSURL'].'/trans.gif"/></div></div>';
	return $varRetVal;
}

$arrSelSavedSrchInfo	= array();
if($sessMatriId != ''){
	if(is_numeric($varSrchId)){
	$objSearch->dbConnect('S', $varDbInfo['DATABASE']);
	//$varWhereCond	= "WHERE Search_Id=".$varSrchId." AND MatriId='".$sessMatriId."' AND Search_Type=".$varSrchType;
	$varWhereCond	= "WHERE Search_Id=".$objSearch->doEscapeString($varSrchId,$objSearch)." AND MatriId=".$objSearch->doEscapeString($sessMatriId,$objSearch)." AND Search_Type=".$objSearch->doEscapeString($varSrchType,$objSearch);
	$varFields		= array('Search_Id','MatriId','Search_Name','Gender','Marital_Status','Children','Age_From','Age_To','Height_From','Height_To','Physical_Status','Mother_Tongue','Religion','Caste_Or_Division','Subcaste','Gothram','Eating_Habits','Drinking','Smoking','Education','Occupation_Category','Occupation','Citizenship','Country','Residing_District','Resident_Status','Posted_After','Search_By','Show_Photo_Horoscope','Show_Ignore_AlreadyContact','Display_Format','Search_Type','Days','Date_Updated','Residing_State','Chevvai_Dosham', 'Annual_Income','Star','Raasi','Denomination');
	$arrResSavedSrchInfo = $objSearch->select($varTable['SEARCHSAVEDINFO'], $varFields, $varWhereCond, 0);
	$arrSelSavedSrchInfo = mysql_fetch_assoc($arrResSavedSrchInfo);
	$objSearch->dbClose();
	}
	else{
		$arrPPAge	= split('~', $varGetCookieInfo['PPAGE']);
		$arrPPHt	= split('~', $varGetCookieInfo['PPHEIGHT']);
		$arrSelSavedSrchInfo['Age_From']	= $arrPPAge[0]>0 ? $arrPPAge[0] : '';
		$arrSelSavedSrchInfo['Age_To']		= $arrPPAge[1]>0 ? $arrPPAge[1] : '';
		$arrSelSavedSrchInfo['Height_From']	= $arrPPHt[0]>0 ? $arrPPHt[0] : '';
		$arrSelSavedSrchInfo['Height_To']	= $arrPPHt[1]>0 ? $arrPPHt[1] : '';
		$arrSelSavedSrchInfo['Marital_Status']	= $varGetCookieInfo['PPLOOKINGFOR'];
		$arrSelSavedSrchInfo['Physical_Status']	= $varGetCookieInfo['PPPHYSICALSTATUS'];
		$arrSelSavedSrchInfo['Mother_Tongue']	= $varGetCookieInfo['PPMOTHERTONGUE'];
		$arrSelSavedSrchInfo['Religion']		= $varGetCookieInfo['PPRELIGION'];
		$arrSelSavedSrchInfo['Caste_Or_Division']= $varGetCookieInfo['PPCASTE'];
		$arrSelSavedSrchInfo['Eating_Habits']	= $varGetCookieInfo['PPEATHABITS'];
		$arrSelSavedSrchInfo['Education']		= $varGetCookieInfo['PPEDUCATION'];
		$arrSelSavedSrchInfo['Citizenship']		= $varGetCookieInfo['PPCITIZENSHIP'];
		$arrSelSavedSrchInfo['Country']			= $varGetCookieInfo['PPCOUNTRY'];
		$arrSelSavedSrchInfo['Resident_Status']	= $varGetCookieInfo['PPRESIDENTSTATUS'];
		$arrSelSavedSrchInfo['Smoking']			= $varGetCookieInfo['PPSMOKEHABITS'];
		$arrSelSavedSrchInfo['Drinking']		= $varGetCookieInfo['PPDRINKHABITS'];
		$arrSelSavedSrchInfo['Subcaste']		= $varGetCookieInfo['PPSUBCASTE'];
		$arrSelSavedSrchInfo['Denomination']	= $varGetCookieInfo['PPDENOMINATION'];
		
	}
}
$varSaveSrchName = ($arrSelSavedSrchInfo['Search_Name'] == '') ? 'Enter search name' : stripslashes($arrSelSavedSrchInfo['Search_Name']);