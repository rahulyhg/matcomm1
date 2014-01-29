<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar 
/* Date	        : 28 Aug 2009
/* Project		: Community Product Matrimony 
/* Filename		: baniya/conf.inc 
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : baniya domain 
/* ______________________________________________________________________________________________________________________*/

/* Segment & Discount */ 
$casteTag	= 'B';
$DiscountTag = 20; // Discount in %

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
$arrCasteList	= array(15=>'Baniya');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1670=>"Agarwal",1671=>"Agrahari",1672=>"Asathi",1673=>"Barnwals",1674=>"Choudharys",1675=>"Dosar/Dusra",1676=>"Gahoi",1677=>"Gandha Vanika",1678=>"Guptas",1679=>"Jaiswals",1680=>"Kalwars",1681=>"Kasaundhan",1682=>"Keshris (Kesarwani)",1683=>"Khandelwal",1684=>"Komti /Arya Vaishya",1685=>"Lad",1686=>"Madhesiya/Kanu/Halwai",1687=>"Mahajan",1688=>"Maheshwari/Meshri",1689=>"Mahuri",1690=>"Modi",1691=>"Nema",1692=>"Oswal",1693=>"Padmavati Porwal",1694=>"Patwa",1695=>"Porwal / Porwar",1696=>"Rastogi",1697=>"Rathi",1698=>"Rauniars",1699=>"Shaw / Sahu/Teli",1700=>"Ummar /Umre/Bagaria",1701=>"Vaishnav",1702=>"Vani/Vaishya",1703=>"Varshneys (Barahseni)",1704=>"Vijayvargia",9997=>"Others");
$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don't wish to specify",9999=>"Don't know my sub-caste"); // e.g. for registration usage
$arrDomainSubCaste[9998] = 'Not Specified';//Don't wish to specify
unset($arrDomainSubCaste[9999]);//Don't know my sub-caste
unset($arrDomainSubCaste[9997]);//Others
$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();
$arrMTDisplayOrder = array(17=>"Hindi",41=>"Punjabi",5=>"Bhojpuri",14=>"Gujarati",7=>"Bihari",34=>"Marwari",4=>"Bengali",30=>"Maithili",39=>"Nepali",15=>"Haryanvi",42=>"Rajasthani",40=>"Oriya");
if(!is_array($arrMotherTongueList)) {
  $arrMotherTongueList = array();
}
$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

?>