<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 23 Jan 2011
/* Project		: Community Product Matrimony
/* Filename		: pakistani/conf.inc
/* ______________________________________________________________________________________________________________________*/
/* Description  : Manual generated config file of pakistani domain
/* ______________________________________________________________________________________________________________________*/

/* Segment & Discount */
$casteTag	= 'A'; // Segement
$DiscountTag = 10; // 25%

/* Male Age Setting */

/* Female Age Setting */

/* Folder Include Flag */
$_IncludeFolder = 'country/';

/* Features Setting */
$_FeatureMaritalStatus=1;
$_FeatureReligion	= 1;
$_FeatureReligionTxt= 0;
$_FeatureCaste		= 1;
$_FeatureCasteTxt	= 1;
$_FeatureSubcaste	= 0;
$_FeatureSubcasteTxt= 0;
$_FeatureGothram	= 0;
$_FeatureGothramTxt	= 0;
$_FeatureStar		= 0;
$_FeatureRaasi		= 0;
$_FeatureHoroscope	= 0;
$_FeatureDosham		= 0;
$_FeatureDenomination=0;
$_FeatureReligious  = 1;
$_FeatureEthnicity  = 1;
$_FeatureClan		= 1;
$_IsCasteMandatory  = 0;

/* Right Panel Feature */
$_RPSuccessStory	= 0;
$_RPZedoPanel		= 0;
$_RPGoogleAdsense	= 0;

/* Label Name */
$_LabelMaritalStatus= 'Marital Status';
$_LabelReligion     = 'Religion';
$_LabelCaste        = 'Division';
$_LabelSubcaste     = 'Subcaste';
$_LabelGothram      = 'Gothram';
$_LabelMotherTongue = 'Mother Tongue';
$_LabelStar         = 'Star';
$_LabelRaasi        = 'Raasi';
$_LabelHoroscope    = 'Horoscope Match';
$_LabelDosham       = 'Manglik';
$_LabelDenomination = 'Sect';
$_LabelReligious    = 'Religious Values';
$_LabelEthnicity	= 'Ethnicity';


/* Arrays */

/* Marital Status Array */
if(!is_array($arrMaritalList)) {
  $arrMaritalList = array();
}
$arrMaritalList = $arrMaritalList + array(5=>"Married");

/* Religion Array */
$arrReligionList = array(10=>"Muslim - Shia",11=>"Muslim - Sunnis",20=>"Muslim - Braihis",21=>"Muslim - Deobandi",22=>"Muslim - Wahabi",23=>"Muslim - Others",1=>"Hindu",3=>"Christian",6=>"Parsi");

/* Clan Array */
//$arrClanList = array(1=>"Aheer", 2=>"Arain", 3=>"Awan", 4=>"Baloch", 5=>"Dogar", 6=>"Gakhars", 7=>"Gondal", 8=>"Gujjars", 9=>"Jat", 10=>"Kamboh", 11=>"Khateek", 12=>"Khattar", 13=>"Khokhar", 14=>"Maliar", 15=>"Mughal", 16=>"Paracha", 17=>"Pashtuns", 18=>"Rajputs", 19=>"Rawns", 20=>"Rehmanis and the Maliks", 21=>"Sheikh", 22=>"Syeds");

/* Caste Array */
$arrCasteList	= array(2100=>"Aheer", 2101=>"Arain", 2102=>"Awan", 2103=>"Baloch", 2104=>"Dogar", 2105=>"Gakhars", 2106=>"Gondal", 2107=>"Gujjars", 2108=>"Jat", 2109=>"Kamboh", 2110=>"Khateek", 2111=>"Khattar", 2112=>"Khokhar", 2113=>"Maliar", 2114=>"Mughal", 2115=>"Paracha", 2116=>"Pashtuns", 2117=>"Rajputs", 2118=>"Rawns", 2119=>"Rehmanis and the Maliks", 2120=>"Sheikh", 2121=>"Syeds");

/* Religious List Array */
$arrReligiousList      = array(1=>"Islam is truth",2=>"Very Islamic ",3=>"Pray 5 times a day",4=>"Go to Jummah Namaz",5=>"Average Muslim",99=>"Not given it a thought");

/* Ethnicity Array */
$arrEthnicityList		= array(25=>"Punjabi", 26=>"Sindhi", 27=>"Balochi", 28=>"Urdu", 29=>"Pashtun", 30=>"Kashmiri");

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();  // Mother Tongue Display Order Array
$arrMotherTongueList	= array(20=>"Kashmiri",41=>"Punjabi",45=>"Sindhi",51=>"Urdu",113=>"Pashtu",116=>"Balochi",9997=>"Others");
//$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

$arrMuslimCasteArray	= $arrCasteList;

// Religion Wise Caste Arrays //
$arrReligionCasteMap = array(
	//Hindu
	//1=>array(1=>"Ad Dharmi",2=>"Adi Dravida",3=>"Agarwal",9997=>"Others"),
	//Muslim (2) | Muslim - Shia (10) | Muslim - Sunni (11)
	10=>$arrMuslimCasteArray, 11=>$arrMuslimCasteArray, 20=>$arrMuslimCasteArray, 21=>$arrMuslimCasteArray, 22=>$arrMuslimCasteArray,
	//Christian
	//3=>$arrChristianCasteArray,
	//Sikh
	//4=>array(651=>"Sikh - Ahluwalia",652=>"Sikh - Arora",653=>"Sikh - Bhatia",654=>"Sikh - Ghumar",655=>"Sikh - Intercaste",656=>"Sikh - Jat",657=>"Sikh - Kamboj",658=>"Sikh - Khatri",659=>"Sikh - Kshatriya",660=>"Sikh - Lubana",661=>"Sikh - Majabi",662=>"Sikh - No Bar",664=>"Sikh - Rajput",665=>"Sikh - Ramdasia",666=>"Sikh - Ramgharia",667=>"Sikh - Saini",669=>"Sikh - Ravidasia",670=>"Sikh - Bhatra",671=>"Sikh - Tonk Kshatriya",668=>"Sikh - Unspecified",9997=>"Others"),
	//Jain
	//5=>$arrJainCasteArray, 15=>$arrJainCasteArray, 16=>$arrJainCasteArray,
	//Buddhist
	//7=>array(0=>"Any",998=>"Caste no bar"),
	//7=>array(38=>"Mahayana",39=>"Nichiren Buddhism",40=>"Pure Land Buddhism"),
	//Parsi
	//6=>array(64=>"Irani",154=>"Parsi",63=>"Intercaste",9997=>"Others")
);

/* Caste Wise Subcaste Arrays */

?>