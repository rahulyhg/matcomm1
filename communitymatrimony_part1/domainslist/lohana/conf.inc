<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 28 Aug 2009
/* Project		: Community Product Matrimony
/* Filename		: lohana/conf.inc
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : lohana domain
/* ______________________________________________________________________________________________________________________*/

/* Segment & Discount */
$casteTag	= 'A';
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
$arrCasteList	= array(107=>'Lohana');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1505=>"Ghoghari",1506=>"Halai",1507=>"Kutchi",1508=>"Vaishnav",9997=>"Others");
$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don't wish to specify",9999=>"Don't know my sub-caste"); // e.g. for registration usage
$arrDomainSubCaste[9998] = 'Not Specified';//Don't wish to specify
unset($arrDomainSubCaste[9999]);//Don't know my sub-caste
unset($arrDomainSubCaste[9997]);//Others
$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();
$arrMTDisplayOrder = array(14=>"Gujarati");
if(!is_array($arrMotherTongueList)) {
  $arrMotherTongueList = array();
}
$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

?>