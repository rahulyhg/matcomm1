<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 28 Aug 2009
/* Project		: Community Product Matrimony
/* Filename		: rajput/conf.inc
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : rajput domain
/* ______________________________________________________________________________________________________________________*/

/* Segment & Discount */
$casteTag	= 'A';
$DiscountTag = 25; // Discount in %

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
$arrReligionList	= array(1=>'Hindu',2=>'Muslim',4=>'Sikh');

/* Caste Array */
$arrCasteList	= array(165=>'Rajput');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(2102=>"Baghel",2103=>"Bais",2104=>"Bankawat",2105=>"Bargujar",2106=>"Bhadauria",2107=>"Bhatti",2108=>"Bhriguvansha",2109=>"Bisen",2110=>"Bisht",2111=>"Chandel",2112=>"Chandravanshi",2113=>"Chandrawat",2114=>"Chauhan",2115=>"Chib",2116=>"Chundawat",2117=>"Dhakare",2118=>"Dixit",2119=>"Doad",2120=>"Dogra",2121=>"Durgavanshi",2122=>"Gaharwal",2123=>"Gahlot",2124=>"Gaud (Gaur)",2125=>"Gautam",2126=>"Gogawat",2127=>"Gohil",2128=>"Jadeja",2129=>"Jadon",2130=>"Jamwal",2131=>"Janjua",2132=>"Jasrotia",2133=>"Jaswal",2134=>"Jhala",2135=>"Kalyanot",2136=>"Katoch",2137=>"Kaushik",2138=>"Khangarot",2139=>"Khati",2140=>"Kirar",2141=>"Kumaoni",2142=>"Kuruvanshi",2143=>"Kushwaha",2144=>"Lodhi Rajput",2145=>"Madad",2146=>"Mahthan",2147=>"Mair Rajput Swarnkar",2148=>"Manhas (Minhas)",2149=>"Nagvanshi",2150=>"Naruka",2151=>"Nathawat",2152=>"Negi",2153=>"Parihar",2154=>"Parmar(Pawar)",2155=>"Pathania",2156=>"Pratihar",2157=>"Pundir",2158=>"Raghuvanshi",2159=>"Rajawat",2160=>"Rana",2161=>"Rathore",2162=>"Rawat",2163=>"Rohilla",2164=>"Sarangdevot",2165=>"Sengar",2166=>"Shekhawat",2167=>"Sikarwar",2168=>"Singh",2169=>"Sisodia",2170=>"Solanki",2171=>"Somvansha",2172=>"Suryavanshi",2173=>"Tanwar",2174=>"Thakur",2175=>"Tomar/Tuar",2176=>"Ujjain",2177=>"Vaishya",2178=>"Verma",9997=>"Others");
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