<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar 
/* Date	        : 28 Aug 2009
/* Project		: Community Product Matrimony 
/* Filename		: kayastha/conf.inc 
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : kayastha domain 
/* ______________________________________________________________________________________________________________________*/

/* Segment & Discount */ 
$casteTag	= 'A';
$DiscountTag = 10; // Discount in %

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
$arrCasteList	= array(82=>'Kayastha');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1589=>"Ambashtha",1590=>"Asthana",1591=>"Barujibi",1592=>"Basu",1593=>"Bhatnagar",1594=>"Bose",1595=>"Chanda",1596=>"Dass",1597=>"Dey",1598=>"Dhar",1599=>"Dutta",1600=>"Ghosh",1918=>"Gour",1601=>"Guha",1919=>"Johri",1602=>"Karna",1603=>"Kars",1604=>"Kulashreshtha",1605=>"Kulin",1606=>"Mathur",1607=>"Mitra",1608=>"Nag",1609=>"Nandi",1610=>"Nigam",1611=>"Palit",1612=>"Paul",1613=>"Rakshit",1614=>"Roy",1615=>"Saxena",1616=>"Sen",1617=>"Sil",1618=>"Sinha",1619=>"Srivastava",9997=>"Others");
$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don't wish to specify",9999=>"Don't know my sub-caste"); // e.g. for registration usage
$arrDomainSubCaste[9998] = 'Not Specified';//Don't wish to specify
unset($arrDomainSubCaste[9999]);//Don't know my sub-caste
unset($arrDomainSubCaste[9997]);//Others
$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();
$arrMTDisplayOrder = array(4=>"Bengali",17=>"Hindi",2=>"Assamese",40=>"Oriya",30=>"Maithili",5=>"Bhojpuri",33=>"Marathi",7=>"Bihari",41=>"Punjabi",14=>"Gujarati",10=>"English",39=>"Nepali");
if(!is_array($arrMotherTongueList)) {
  $arrMotherTongueList = array();
}
$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

?>