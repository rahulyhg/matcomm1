<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar 
/* Date	        : 28 Aug 2009
/* Project		: Community Product Matrimony 
/* Filename		: gupta/conf.inc 
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : gupta domain 
/* ______________________________________________________________________________________________________________________*/

/* Segment & Discount */ 
$casteTag	= 'B1';
$DiscountTag = 35; // Discount in %

/* Male Age Setting */ 

/* Female Age Setting */ 

/* Features Setting */ 
$_FeatureMaritalStatus	= 1;
$_FeatureReligion	= 1;
$_FeatureReligionTxt= 0;
$_FeatureCaste		= 1;
$_FeatureCasteTxt	= 0;
$_FeatureSubcaste	= 1;
$_FeatureSubcasteTxt= 0;
$_FeatureGothram	= 1;
$_FeatureGothramTxt	= 1;
$_FeatureStar		= 1;
$_FeatureRaasi		= 1;
$_FeatureHoroscope	= 1;
$_FeatureDosham		= 1;

/* Right Panel Feature */
$_RPSuccessStory	= 0;
$_RPZedoPanel		= 0;
$_RPGoogleAdsense	= 0;

/* Label Name Settings */
$_LabelMaritalStatus	= 'Marital Status';
$_LabelReligion	= 'Religion';
$_LabelCaste		= 'Caste';
$_LabelSubcaste	= 'Subcaste';
$_LabelGothram	= 'Gothra';
$_LabelMotherTongue		= 'Mother Tongue';
$_LabelStar		= 'Star';
$_LabelRaasi		= 'Raasi';
$_LabelHoroscope	= 'Horoscope';
$_LabelDosham		= 'Dosham';

/* Arrays */

/* Religion Array */
$arrReligionList	= array(1=>'Hindu');

/* Caste Array */
$arrCasteList	= array(62=>'Gupta');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1706=>"Agarwal",1707=>"Agrahari",1708=>"Asathi",1709=>"Ayodhyavasi",1710=>"Baniya",1711=>"Barnwals",1712=>"Chaturth",1713=>"Dosar/Dusra",1714=>"Gahoi",1715=>"Gulahre",1716=>"Guptas",1717=>"Jaiswals",1718=>"Kalwars",1719=>"Kanykubj",1720=>"Kasaundhan",1721=>"Keshris (Kesarwani)",1722=>"Khandelwal",1723=>"Madhesiya/Kanu/Halwai",1724=>"Mahajan",1725=>"Maheshwari/Meshri",1726=>"Mahor",1727=>"Mahuri",1728=>"Mathur",1729=>"Nema",1730=>"Patwa",1731=>"Porwal/Porwar",1732=>"Rastogi",1733=>"Rauniars",1734=>"Shaw / Sahu/Teli",1735=>"Ummar /Umre/Bagaria",1736=>"Vaishnav",1737=>"Vani/Vaishya",1738=>"Varshneys (Barahseni)",1739=>"Vijayvargia",9997=>"Others");
$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don't wish to specify",9999=>"Don't know my sub-caste"); // e.g. for registration usage
$arrDomainSubCaste[9998] = 'Not Specified';//Don't wish to specify
unset($arrDomainSubCaste[9999]);//Don't know my sub-caste
unset($arrDomainSubCaste[9997]);//Others
$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();
$arrMTDisplayOrder = array(17=>"Hindi");
if(!is_array($arrMotherTongueList)) {
  $arrMotherTongueList = array();
}
$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

?>