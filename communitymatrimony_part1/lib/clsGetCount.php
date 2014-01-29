<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsDB.php');

Class GetCount extends DB
{
	function ProfileIamLooking($argCommunityId,$argMatriId)
	{
		global $varTable,$varDbInfo;
		$argTblName		= $varTable['PROFILEMATCHINFO'];

		//COMPATIBILTY BAR ARRAY VALUES
		$argCondition	= "WHERE CommunityId = ".$argCommunityId." AND MatriId=".$this->doEscapeString($argMatriId,$this);

		$funFields			= array('MatriId', 'Gender', 'Age_From', 'Age_To', 'Looking_Status', 'Height_From', 'Height_To', 'MatchPhysical_Status', 'MatchEducation', 'MatchReligion', 'MatchDenomination', 'MatchCaste', 'MatchSubcasteId', 'MatchCitizenship', 'MatchCountry', 'MatchIndianStates', 'MatchUSStates', 'MatchResidentStatus', 'MatchMotherTongue',  'Eating_HabitsPref', 'Drinking_HabitsPref', 'Smoking_HabitsPref', 'Date_Updated');
		$funarrPPDetResSet	= $this->select($argTblName, $funFields, $argCondition, 0);
		$funarrPPDet		= mysql_fetch_assoc($funarrPPDetResSet);

		$funStAge		= $funarrPPDet['Age_From'];
		$funEndAge		= $funarrPPDet['Age_To'];
		$funStHeight	= $funarrPPDet['Height_From'];
		$funEndHeight	= $funarrPPDet['Height_To'];
		$funLookingfor	= $funarrPPDet['Looking_Status'];
		$funPhStatus	= $funarrPPDet['MatchPhysical_Status'];
		$funMotherTongue= $funarrPPDet['MatchMotherTongue'];
		$funReligion	= $funarrPPDet['MatchReligion'];
		$funDenomination= $funarrPPDet['MatchDenomination'];
		$funCaste		= $funarrPPDet['MatchCaste'];
		$funSubcaste	= $funarrPPDet['MatchSubcasteId'];
		$funEatingHabit	= $funarrPPDet['Eating_HabitsPref'];
		$funEducation	= $funarrPPDet['MatchEducation'];
		$funCitizenship	= $funarrPPDet['MatchCitizenship'];
		$funCountry		= $funarrPPDet['MatchCountry'];
		$funIndiaState	= $funarrPPDet['MatchIndianStates'];
		$funUSAState	= $funarrPPDet['MatchUSStates'];
		//$funResidentSt	= $funarrPPDet['MatchResidentStatus'];
		$funSmokingHabit= $funarrPPDet['Smoking_HabitsPref'];
		$funDrinkHabit	= $funarrPPDet['Drinking_HabitsPref'];

		$varGender		= $funarrPPDet['Gender']==2?'1':'2';

		$funQuery	= 'WHERE CommunityId='.$argCommunityId;
		$funQuery  .= " AND Gender=".$varGender." AND Age >=".floor($funStAge)." AND Age <=".ceil($funEndAge)." AND Height >=".floor($funStHeight)." AND Height <=".ceil($funEndHeight);
		
		if($funPhStatus != 0) { $funQuery	.= ' AND SpecialCase = '.$funPhStatus;	 }//if 
		if($funEatingHabit != 0) { $funQuery	.= ' AND Eating_Habits = '.$funEatingHabit;	 }//if
		if($funSmokingHabit != 0) { $funQuery	.= ' AND Smoking_Habits = '.$funSmokingHabit;	 }//if
		if($funDrinkHabit != 0) { $funQuery	.= ' AND Drinking_Habits = '.$funDrinkHabit;	 }//if

		if($funLookingfor != '' && $funLookingfor !=0)
		{ $funQuery	.= ' AND Marital_Status IN('.preg_replace('/(~)+/', ',', trim($funLookingfor,'~')).')'; }//if

		if($funMotherTongue != "" && $funMotherTongue !=0)
		{ $funQuery	.= ' AND Mother_Tongue IN('.preg_replace('/(~)+/', ',', trim($funMotherTongue,'~')).')';	 }//if

		if($funReligion != "" && $funReligion !=0)
		{ $funQuery	.= ' AND Religion IN('.preg_replace('/(~)+/', ',', trim($funReligion,'~')).')';	 }//if

		if($funCaste != "" && $funCaste !=0)
		{ $funQuery	.= ' AND CasteId IN('.preg_replace('/(~)+/', ',', trim($funCaste,'~')).')';	 }//if

		if($funSubcaste != "" && $funSubcaste !=0)
		{ $funQuery	.= ' AND SubcasteId IN('.preg_replace('/(~)+/', ',', trim($funSubcaste,'~')).')';	 }//if

		if($funEducation != "" && $funEducation !=0)
		{ $funQuery	.= ' AND Education_Category IN('.preg_replace('/(~)+/', ',', trim($funEducation,'~')).')';	 }//if

		if($funCitizenship != "" && $funCitizenship !=0)
		{ $funQuery	.= ' AND Citizenship IN('.preg_replace('/(~)+/', ',', trim($funCitizenship,'~')).')';	 }//if

		
		if($funCountry != "" && $funCountry !=0) { 
			$funQuery	.= $this->getStateCond($funIndiaState, $funUSAState, $funCountry);
		}
				
		/*if($funResidentSt != "" && $funResidentSt !=0)
		{ $funQuery	.= ' AND Resident_Status IN('.preg_replace('/(~)+/', ',', trim($funResidentSt,'~')).')';	 }//if*/

		$funNoOfRecs	= $this->numOfRecords($argTblName, 'MatriId', $funQuery);	

		return $funNoOfRecs;
	}


	function getStateCond($argResidingIndState, $argResidingUSAState, $argCountry)
	{
		$funIndiaStates = $argResidingIndState;
		$funUSAStates	= $argResidingUSAState;
		$arrCountries	= split(',',preg_replace("/~+/",',',$argCountry));
		
		$funIndiaStates = preg_replace("/~+/",',',trim($funIndiaStates,'~'));
		$funUSAStates	= preg_replace("/~+/",',',trim($funUSAStates,'~'));
		
		$varIndiaQuery	= '';
		$varUSAQuery	= '';
		$varOtherQuery	= '';
		$varTotalQuery  = '';

		
		if($funIndiaStates != '' && $funIndiaStates != 0 &&in_array(98,$arrCountries)){
			$varIndiaQuery	= '(Country=98 AND Residing_State IN ('.$funIndiaStates.')) ';
			if($funKey = array_search('98',$arrCountries))
			unset($arrCountries[$funKey]);

			if($funKey==0 && $arrCountries[$funKey]==98)
			unset($arrCountries[$funKey]);
			
		}
		if($funUSAStates != '' && $funUSAStates != 0 && in_array(222,$arrCountries)){
			if($varIndiaQuery != ''){$varIndiaQuery .= ' OR ';}
			$varUSAQuery	= '(Country=222 AND Residing_State IN ('.$funUSAStates.'))';
			if($funKey = array_search('222',$arrCountries))
			unset($arrCountries[$funKey]);

			if($funKey==0 && $arrCountries[$funKey]==222)
			unset($arrCountries[$funKey]);
		}
		
		if(count($arrCountries)>0){
			$varCounrty		= join(',', $arrCountries);
			if($varUSAQuery != '' || $varIndiaQuery != ''){	$varOtherQuery	.= ' OR ';}
			$varOtherQuery	.= 'Country IN ('.$varCounrty.')';
		}

		if($varIndiaQuery != ''){
			$varTotalQuery = ' AND ('.$varIndiaQuery.$varUSAQuery.$varOtherQuery.')';
		}else if($varUSAQuery != ''){
			$varTotalQuery = ' AND ('.$varUSAQuery.$varOtherQuery.')';
		}else if($varOtherQuery != ''){
			$varTotalQuery = ' AND '.$varOtherQuery;
		}
		return $varTotalQuery;

	}
}
?>