<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsBasicview.php');

Class Profilematch extends BasicView
{
	//MEMBER VARIABLES
	public $arrProIdsDet		= array();
	public $clsSessPartnerPref	= '';
	public $clsSessMatriId		= '';
	public $clsGender			= '';
	
	//Get Interest Details
	function SelectProDetails($argTblName, $argFields, $argProOption, $argStartRec, $argNoOfRec)
	{
		if($argProOption == 'PMI')
		{
			return $this->ProfileIamLooking($argTblName, $argFields, $argStartRec, $argNoOfRec);
		}
	}

	function ProfileIamLooking($argTblName, $argFields, $argStartRec, $argNoOfRec)
	{
		global $varWhereClause;
		//COMPATIBILTY BAR ARRAY VALUES
		$funarrPPDet	= split('\^\|', $this->clsSessPartnerPref);
		$funAge			= split('~', $funarrPPDet[0]);
		$funHeight		= split('~', $funarrPPDet[1]);
		$funLookingfor	= $funarrPPDet[2];
		$funPhStatus	= $funarrPPDet[3];
		$funMotherTongue= $funarrPPDet[4];
		$funReligion	= $funarrPPDet[5];
		$funCaste		= $funarrPPDet[6];
		$funEatingHabit	= $funarrPPDet[7];
		$funEducation	= $funarrPPDet[8];
		$funCitizenship	= $funarrPPDet[9];
		$funCountry		= $funarrPPDet[10];
		$funIndiaState	= $funarrPPDet[11];
		$funUSAState	= $funarrPPDet[12];
		//$funResidentSt	= $funarrPPDet[13];
		$funSmokingHabit= $funarrPPDet[14];
		$funDrinkHabit	= $funarrPPDet[15];
		$funSubcaste	= $funarrPPDet[16];

		if($this->clsGender == 1){
			$funAge[0]	= $funAge[0]>=21? $funAge[0] : 21;
			$funAge[1]	= $funAge[1]>=21? $funAge[1] : 21;
		}else{
			$funAge[0]	= $funAge[0]>=18? $funAge[0] : 18;
			$funAge[1]	= $funAge[1]>=18? $funAge[1] : 18;
		}

		$funQuery	= 'WHERE '.$varWhereClause;
		$funQuery  .= " AND Gender=".$this->clsGender." AND Age >=".$funAge[0]." AND Age <=".$funAge[1]." AND Height >=".floor($funHeight[0])." AND Height <=".ceil($funHeight[1]);
		
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
		
		if ($funNoOfRecs > 0)
		{
			$funQuery	.= ' ORDER BY Date_Created DESC LIMIT '.$argStartRec.', '.$argNoOfRec;
			$funReultSet = $this->select($argTblName, $argFields, $funQuery, 0);
			
			$i = 0;
			while($row = mysql_fetch_assoc($funReultSet)) {
				$this->arrProIdsDet[$i]			= $row['MatriId'];
				$i++;
			}
		}
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

		
		if($funIndiaStates != '' && in_array(98,$arrCountries)){
			$varIndiaQuery	= '(Country=98 AND Residing_State IN ('.$funIndiaStates.')) ';
			if($funKey = array_search('98',$arrCountries))
			unset($arrCountries[$funKey]);

			if($funKey==0 && $arrCountries[$funKey]==98)
			unset($arrCountries[$funKey]);
			
		}
		if($funUSAStates != '' && in_array(222,$arrCountries)){
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