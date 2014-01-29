<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar 
/* Date	        : 28 Aug 2009
/* Project		: Community Product Matrimony 
/* Filename		: vaishnav/conf.inc 
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : vaishnav domain 
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
$arrCasteList	= array(218=>'Vaishnav');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1514=>"Dasa Disawal",1515=>"Dasa Kapol",1516=>"Dasa Khadaita",1517=>"Dasa Lod",1518=>"Dasa Modh",1519=>"Dasa Porwadh",1520=>"Dasa Shrimali",1521=>"Dasa Sorathia",1522=>"Dishaval",1523=>"Kapol",1524=>"Khadyata",1525=>"Lad",1526=>"Modh",1527=>"Porvad",1528=>"Shrimali",1529=>"Sorathaiya",1530=>"Vaishnav Vania",1531=>"Visa Disawal",1532=>"Visa Khadaita",1533=>"Visa Lod",1534=>"Visa Modh",1535=>"Visa Porwadh",1536=>"Visa Shrimali",1537=>"Visa Sorathia",9997=>"Others");
$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don't wish to specify",9999=>"Don't know my sub-caste"); // e.g. for registration usage
$arrDomainSubCaste[9998] = 'Not Specified';//Don't wish to specify
unset($arrDomainSubCaste[9999]);//Don't know my sub-caste
unset($arrDomainSubCaste[9997]);//Others
$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();
if(!is_array($arrMotherTongueList)) {
  $arrMotherTongueList = array();
}
$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

?>