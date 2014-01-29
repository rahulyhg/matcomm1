<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 01 Sep 2009
/* Project		: Community Product Matrimony
/* Filename		: lingayath/conf.inc
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : lingayath domain
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
$arrCasteList	= array(106=>'Lingayath');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1415=>"Agasa",1416=>"Akkasali",1417=>"Aradhya",1418=>"Balegala",1419=>"Banagar",1420=>"Banajiga",1421=>"Bhandari",1422=>"Bilijedaru",1423=>"Bilimagga",1424=>"Chaturtha",1425=>"Dikshwant",1426=>"Ganiga",1427=>"Gowda (Gowdike)",1428=>"Gowli",1429=>"Gurav",1430=>"Hadapada",1431=>"Hatgar",1432=>"Hugar/Hoogara",1433=>"Jadaru",1434=>"Jangama",1435=>"Kudu Vokkaliga",1436=>"Kumbar/Kumbara",1437=>"Kumbhar",1438=>"Kuruhina Setty",1439=>"Lolagonda",1440=>"Madivala",1441=>"Malgar",1442=>"Mali",1443=>"Neelagar",1444=>"Neygi",1445=>"Nolamba",1446=>"Panchamasali",1448=>"Pattasali",1449=>"Reddy/Reddi",1450=>"Sadar",1451=>"Sajjan/ Sajjanaganigar",1452=>"Setty",1453=>"Shilwant",1454=>"Shiva Simpi",1455=>"Vani",9997=>"Others");
$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don't wish to specify",9999=>"Don't know my sub-caste"); // e.g. for registration usage
$arrDomainSubCaste[9998] = 'Not Specified';//Don't wish to specify
unset($arrDomainSubCaste[9999]);//Don't know my sub-caste
unset($arrDomainSubCaste[9997]);//Others
$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();
$arrMTDisplayOrder = array(19=>"Kannada",48=>"Telugu",33=>"Marathi",17=>"Hindi",47=>"Tamil");
if(!is_array($arrMotherTongueList)) {
  $arrMotherTongueList = array();
}
$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

?>