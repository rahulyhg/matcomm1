<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 01 Sep 2009
/* Project		: Community Product Matrimony
/* Filename		: konguvelalagounder/conf.inc
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : konguvelalagounder domain
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
$arrCasteList	= array(87=>'Kongu Vellala Gounder');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1038=>"Aadai",1039=>"Aadhi",1040=>"Aanthai",1041=>"Aavan",1042=>"Alagan",1043=>"Andai",1044=>"Andhuvan",1045=>"Cheran",1046=>"Devendran",1047=>"Eenjan",1048=>"Ennai",1049=>"Kaadai",1050=>"Kaari",1051=>"Kanakkan",1052=>"Kannan",1053=>"Kannandhai",1054=>"Keeran",1055=>"Koorai",1056=>"Koventhar",1057=>"Kuzhlaayan",1058=>"Maadai",1059=>"Maniyan",1060=>"Medhi",1061=>"Muthan",1062=>"Muzhlukkadhan",1063=>"Nattu Gounder",1064=>"Odhaalar",1065=>"Paandian",1066=>"Padaithalaiyan",1067=>"Panaiyan",1068=>"Panangadai",1069=>"Pannai",1070=>"Pannan",1071=>"Pavalan",1072=>"Payiran",1073=>"Periyan",1080=>"Perizhanthan",1074=>"Perunkudi",1075=>"Pillan",1076=>"Podiyan",1077=>"Ponnan",1078=>"Poochadhai Poodhiyan",1079=>"Poosan",1081=>"Sathandhai",1082=>"Sedan",1083=>"Sellan",1084=>"Sempoothan",1085=>"Sengannan",1086=>"Sengunni",1087=>"Seralan",1088=>"Sevadi",1089=>"Thodai",1090=>"Thooran",1091=>"Vannakkan",1092=>"Veliyan",1093=>"Vellamban",1094=>"Venduvan",1095=>"Viliyan",1096=>"Villi",9997=>"Others");
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