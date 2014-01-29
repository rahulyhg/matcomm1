<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 10 August 2009
/* Project		: Community Product Matrimony
/* Filename		: clsDomain.php
/* ______________________________________________________________________________________________________________________*/
/* Description   :

	This file has class methods, which says Is Feature Yes or No, Is Multiple option value Yes or No,
	return Array Values & Label for the below prominent Attributes

	Religion
		Religion/Level1 Label : Religion | Denomination
	Caste
		Caste/Level2 Label : Caste | Division | Sect
	Subcaste
		Subcaste/Level3 Label : Subcaste | SubDivision | Subsect
	Gothram
		Gothram/Level4 Label : Gothram | Gothra
	MotherTongue
		MotherTongue Label : Mother Tongue
	Dosham
		Dosham Label : Dosham | Chevvai Dosham | Manglink
	Star
		Star Label : Star | Natchatra
	Raasi
		Raasi Label : Raasi

	MaritalStatus
	Horoscope
	Domain Segment
	Domain Discount
	Age Difference
/* ______________________________________________________________________________________________________________________*/

/* Doc Path Setting */
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

/* Includes */
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");

class domainInfo {

	/*______________________________________________________________________________________*/
	/* Marital Status */

	function useMaritalStatus() {
		global $_FeatureMaritalStatus;
		return 1; // returns Yes(1) | No(0)
	}

	function getMaritalStatusOption() {
		global $arrMaritalList;
		return $arrMaritalList;
	}

	function getMaritalStatusLabel() {
		global $_LabelMaritalStatus;
		return ((trim($_LabelMaritalStatus)!='')? trim($_LabelMaritalStatus):'Marital status');
	}

	/*______________________________________________________________________________________*/
    /* Religion */

	function useReligion() {
		global $_FeatureReligion;
		return 1; // returns Yes(1) | No(0)
	}

	function getReligionOption() {
		global $arrReligionList;
		return $arrReligionList;
	}

	function getReligionLabel() {
		global $_LabelReligion;
		return ((trim($_LabelReligion)!='')? trim($_LabelReligion):'Religion');
	}

	/*______________________________________________________________________________________*/
   	/* Caste */

	function useCaste() {
		global $_FeatureCaste;
		return $_FeatureCaste; // // returns Yes(1) | No(0)
	}

	function isCasteMandatory() {
		global $_IsCasteMandatory;
		return $_IsCasteMandatory; // // returns Yes(1) | No(0)
	}

	function getCasteOption() {
		global $arrCasteList;
		return $arrCasteList;
	}

	function getCasteLabel() {
		global $_LabelCaste;
		return ((trim($_LabelCaste)!='')? trim($_LabelCaste):'Caste');
	}

	function getCasteOptionsForReligion($argReligionId='') {
		global $arrReligionCasteMap;
		if ( $argReligionId!='' ) {
			return $arrReligionCasteMap[$argReligionId];
		} else {
			return '';
		}
	}

	function isCasteNoBarCheck() {
		global $_IsCasteNoBarCheck;
		return $_IsCasteNoBarCheck; // // returns Yes(1) | No(0)
	}

	/*______________________________________________________________________________________*/
    /* Subcaste  */

	function useSubcaste() {
		global $_FeatureSubcaste;
		return $_FeatureSubcaste;
	}

	function isSubcasteMandatory() {
		global $_IsSubcasteMandatory;
		return $_IsSubcasteMandatory; // // returns Yes(1) | No(0)
	}

	function getSubcasteOption() {
		global $arrSubcasteList;
		return $arrSubcasteList;
	}

	function getSubcasteLabel() {
		global $_LabelSubcaste;
		return ((trim($_LabelSubcaste)!='')? trim($_LabelSubcaste):'Subcaste');
	}

	function getSubcasteOptionsForCaste($argCasteId='') {
		global $arrCasteSubcasteMap;
		if ( $argCasteId!='' ) {
			return $arrCasteSubcasteMap[$argCasteId];
		} else {
			return '';
		}
	}

	/*______________________________________________________________________________________*/
	/* Gothram */

	function useGothram() {
		global $_FeatureGothram;
		return $_FeatureGothram; // returns 1/0
	}

	function getGothramOption() {
		global $arrGothramList;
		return $arrGothramList;
	}

	function getGothramLabel() {
		global $_LabelGothram;
		return ((trim($_LabelGothram)!='')? trim($_LabelGothram):'Gothram');
	}

	function getGothramOptionsForCaste($argCasteId='') {
		global $arrCasteGothramMap, $arrGothramList;
		if ( $argCasteId!='' && in_array($argCasteId, $arrCasteGothramMap) ) {
			return $arrGothramList;
		} else {
			return array();
		}
	}

	/*______________________________________________________________________________________*/
	/* Mother Tongue */

	function useMotherTongue() {
		return 1;
	}

	function getMotherTongueOption() {
		global $arrMotherTongueList;
		return $arrMotherTongueList;
	}

	function getMotherTongueLabel() {
		global $_LabelMotherTongue;
		return ((trim($_LabelMotherTongue)!='')? trim($_LabelMotherTongue):'Mother Tongue');
	}

	/*______________________________________________________________________________________*/
	/* Star */

	function useStar() {
		global $_FeatureStar;
		return $_FeatureStar; // returns 1/0
	}

	function getStarOption() {
		global $arrCommStarList;
		return $arrCommStarList;
	}

	function getStarLabel() {
		global $_LabelStar;
		return ((trim($_LabelStar)!='')? trim($_LabelStar):'Star');
	}

	/*______________________________________________________________________________________*/
    /* Raasi */

	function useRaasi() {
		global $_FeatureRaasi;
		return $_FeatureRaasi; // returns 1/0
	}

	function getRaasiOption() {
		global $arrRaasiList;
		return $arrRaasiList;
	}

	function getRaasiLabel() {
		global $_LabelRaasi;
		return ((trim($_LabelRaasi)!='')? trim($_LabelRaasi):'Raasi');
	}

	/*______________________________________________________________________________________*/
	/* Horoscope */

	function useHoroscope() {
		global $_FeatureHoroscope;
		return $_FeatureHoroscope; // returns 1/0
	}

	function getHoroscopeOption() {
		global $arrHoroscopeList;
		return $arrHoroscopeList;
	}

	function getHoroscopeLabel() {
		global $_LabelHoroscope;
		return ((trim($_LabelHoroscope)!='')? trim($_LabelHoroscope):'Horoscope Match');
	}

	/*______________________________________________________________________________________*/
    /* Dosham */

	function useDosham() {
		global $_FeatureDosham;
		return $_FeatureDosham; // returns 1/0
	}

	function getDoshamOption() {
		global $arrDhosamList;
		return $arrDhosamList;
	}

	function getDoshamLabel() {
		global $_LabelDosham;
		return ((trim($_LabelDosham)!='')? trim($_LabelDosham):'Dosham');
	}

	/*______________________________________________________________________________________*/
    /* Denomination */

	function useDenomination() {
		global $_FeatureDenomination;
		return $_FeatureDenomination; // returns 1/0
	}

	function getDenominationOption() {
		global $arrDenominationList;
		return $arrDenominationList;
	}

	function getDenominationLabel() {
		global $_LabelDenomination;
		return ((trim($_LabelDenomination)!='')? trim($_LabelDenomination):'Denomination');
	}

	function getCasteOptionsForDenomination($argDenominationId='') {
		global $arrDenominationCasteMap;
		if ( $argDenominationId!='' ) {
			return $arrDenominationCasteMap[$argDenominationId];
		} else {
			return '';
		}
	}

	/*______________________________________________________________________________________*/
    /* Religious Values */

	function useReligiousValues() {
		global $_FeatureReligious;
		return $_FeatureReligious; // returns 1/0
	}

	function getReligiousValuesOption() {
		global $arrReligiousList;
		return $arrReligiousList;
	}

	function getReligiousValuesLabel() {
		global $_LabelReligious;
		return ((trim($_LabelReligious)!='')? trim($_LabelReligious):'Religious Values');
	}

	/*______________________________________________________________________________________*/
    /* Ethnicity */

	function useEthnicity() {
		global $_FeatureEthnicity;
		return $_FeatureEthnicity; // returns 1/0
	}

	function getEthnicityOption() {
		global $arrEthnicityList;
		return $arrEthnicityList;
	}

	function getEthnicityLabel() {
		global $_LabelEthnicity;
		return ((trim($_LabelEthnicity)!='')? trim($_LabelEthnicity):'Ethnicity');
	}

	/*______________________________________________________________________________________*/
    /* Appearance */

	function useAppearance() {
		global $_FeatureAppearance;
		return $_FeatureAppearance; // returns 1/0
	}

	function getAppearanceOption() {
		global $arrAppearanceList;
		return $arrAppearanceList;
	}

	function getAppearanceLabel() {
		global $_LabelAppearance;
		return ((trim($_LabelAppearance)!='')? trim($_LabelAppearance):'Appearance');
	}

	/*______________________________________________________________________________________*/
    /* Domain Segment */

	function getSegment() {
		global $casteTag;
		return $casteTag;
	}

	/*______________________________________________________________________________________*/
    /* Domain Discount */

	function getDiscount() {
		global $DiscountTag;
		return $DiscountTag;
	}

	/*______________________________________________________________________________________*/
    /* Male & Female Start - End Age */

	function getMStartAge() {
		global $varMStartAge;
		return $varMStartAge;
	}
	function getFStartAge() {
		global $varFStartAge;
		return $varFStartAge;
	}
	function getMEndAge() {
		global $varMEndAge;
		return $varMEndAge;
	}
	function getFEndAge() {
		global $varFEndAge;
		return $varFEndAge;
	}

	/*______________________________________________________________________________________*/
    /* Employed In */

	function useEmployedIn() {
		global $_FeatureEmployedIn;
		return 1; // returns Yes(1) | No(0)
	}

	function getEmployedInOption() {
		global $arrEmployedInList;
		return $arrEmployedInList;
	}

	function getEmployedInLabel() {
		global $_LabelEmployedIn;
		return ((trim($_LabelEmployedIn)!='')? trim($_LabelEmployedIn):'Employed in');
	}
	
	/*______________________________________________________________________________________*/
	/* Life style habits */

	function getFoodHabits() {
		global $arrEatingHabitsList;
		return $arrEatingHabitsList;
	}

	/*______________________________________________________________________________________*/

}

?>