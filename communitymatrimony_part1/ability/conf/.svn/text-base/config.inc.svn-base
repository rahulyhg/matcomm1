<?php
#================================================================================================================
# Author 		: Ashok kumar, Dhanapal
# Date	        : 01 June 2009
# Project		: Community Matrimony Product
# Filename		: config.inc
#================================================================================================================
# Description   : Global and Configuration Variables
#================================================================================================================

// ERROR REPORTING ON | OFF
ini_set('display_errors','0');
error_reporting(0);

// DOC PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

// INCLUDE FILES
include_once($varRootBasePath.'/conf/domainlist.inc');

// DOMAIN FEATURES
$_FeatureMaritalStatus=1;
$_FeatureReligion	= 1;
$_FeatureReligionTxt= 0;
$_FeatureCaste		= 0;
$_FeatureCasteTxt	= 0;
$_FeatureSubcaste	= 0;
$_FeatureSubcasteTxt= 0;
$_FeatureGothram	= 0;
$_FeatureGothramTxt	= 0;
$_FeatureStar		= 0;
$_FeatureRaasi		= 0;
$_FeatureHoroscope	= 0;
$_FeatureDosham		= 0;
$_FeatureDenomination=0;
$_FeatureReligious  = 0;
$_FeatureEthnicity  = 0;
$_FeatureAppearance = 0;
$_FeatureEmployedIn = 1;
$_IsCasteMandatory  = 1;
$_IsSubcasteMandatory = 1;
$_IsCasteNoBarCheck = 0;

// RIGHT PANEL
$_RightPanel		= 1;
$_RPToolsPromo		= 1;
$_RPSuccessStory	= 0;
$_RPZedoPanel		= 0;
$_RPGoogleAdsense	= 0;

// Label Name
$_LabelMaritalStatus= 'Marital status';
$_LabelReligion     = 'Religion';
$_LabelCaste        = 'Caste';
$_LabelSubcaste     = 'Subcaste';
$_LabelGothram      = 'Gothra';
$_LabelMotherTongue = 'Mother tongue';
$_LabelStar         = 'Star';
$_LabelRaasi        = 'Raasi';
$_LabelHoroscope    = 'Horoscope match';
$_LabelDosham       = 'Chevvai dosham';
$_LabelDenomination = 'Denomination';
$_LabelReligious    = 'Religious values';
$_LabelEthnicity	= 'Ethnicity';
$_LabelAppearance   = 'Appearance';
$_LabelEmployedIn   = 'Employed in';

// SERVER VARIABLE DECLARTION
$varServerHost	= $_SERVER["HTTP_HOST"];
$varServerRoot	= $_SERVER["DOCUMENT_ROOT"];
$varServerRoot	= $varServerRoot ? $varServerRoot : '/home/product/community/www';
$varScriptName	= explode('/',$_SERVER['SCRIPT_NAME']); // For Top Search Menu
$varTopMenu		= trim($varScriptName[1]);

// GET DOMAIN DETAIL
$varSplitDomain	= split('\.',$varServerHost);
$varCntSplit	= count($varSplitDomain);

##www./img./image. - CASTEmatrimony.com
if (($varSplitDomain[0]=='www' || $varSplitDomain[0]=='img' || $varSplitDomain[0]=='image') && $varCntSplit==3) {
	$varDomainPart1	= 'www';
	$varDomainPart2	= $varSplitDomain[1];##agarwalmatrimony
	$varDomain		= substr($varDomainPart2,0,-9);
	$varDomainName	= $varDomainPart2;##agarwalmatrimony
} else if($varCntSplit==3) {
	$varDomainPart1	= $varSplitDomain[0];##agarwal
	$varDomainPart2	= $varSplitDomain[1];##communitymatrimony
	$varDomain		= $varSplitDomain[0];##CASTE.communitymatrimony.com [subdomain]
	$varDomainName	= $varDomainPart1.'.'.$varDomainPart2;##agarwal.communitymatrimony
} else  {
	$varDomainPart1	= $varSplitDomain[1];##agarwal
	$varDomainPart2	= $varSplitDomain[2];##communitymatrimony
	$varDomain		= $varSplitDomain[1];##IMAGESERVER.CASTE.communitymatrimony.com [subdomain with image server]
	$varDomainName	= $varDomainPart1.'.'.$varDomainPart2;##agarwal.communitymatrimony
}
$varUcDomain= ucfirst($varDomain);

$varIncludeFolder = '';
$varTemplates = '';
if (trim($arrDomainInfo[$varDomain][2])!='' && is_dir($varServerRoot.'/mailer/templates/'.trim($arrDomainInfo[$varDomain][2]))){
	$varIncludeFolder = '/'.trim($arrDomainInfo[$varDomain][2]);
	$varTemplates = '/'.trim($arrDomainInfo[$varDomain][2]);
}

$confValues = array(
	'SERVERNAME'			=> $varDomainPart1.'.'.$varDomainPart2.'.com',
	'SERVERURL'				=> 'http://'.$varDomainPart1.'.'.$varDomainPart2.'.com',
	'IMGURL'				=> 'http://img.'.$varDomainName.'.com',
	'IMGSURL'				=> 'http://img.'.$varDomainName.'.com/images',
	'MAILTEMPLATEPATH'		=> $varServerRoot.'/mailer/templates'.$varIncludeFolder,
	'HEADERTEMPLATEPATH'	=> $varServerRoot.'/template'.$varTemplates,
	'MAILERIMGSPATH'		=> 'http://'.$varDomainPart1.'.'.$varDomainPart2.'.com/mailer/images',
	'PHOTOURL'				=> 'http://img.'.$varDomainName.'.com/membersphoto/'.$arrDomainInfo[$varDomain][2],
	'HOROSCOPEURL'			=> 'http://img.'.$varDomainName.'.com/membershoroscope/'.$arrDomainInfo[$varDomain][2],
	'IMAGEURL'				=> 'http://image.'.$varDomainName.'.com',
	'JSPATH'				=> 'http://img.'.$varDomainName.'.com/scripts',
	'CSSPATH'				=> 'http://img.'.$varDomainName.'.com/styles',
	'DOMAINCSSPATH'			=> 'http://img.'.$varDomainName.'.com/styles/'.$arrDomainInfo[$varDomain][2],
	'DOMAINNAME'			=> '.'.$varDomainName.'.com',
	'REDIRECTURL'			=> 'http://'.$varDomainPart1.'.'.$varDomainPart2.'.com/site/errorlanding.php',
	'EXPINTSENTCOUNT'		=> 100,
	'MESSAGESENTCOUNT'		=> 250,
	'TIMEINTERVALALLOWED'	=> 43200,
	'EXPALERTCOUNT'			=> 50,
	'MESSAGEALERTCOUNT'		=> 50,
	'PHOTOMAXSIZE'			=> 2097152,
	'HOROSCOPEMAXSIZE'		=> 307200,
	'FMPHOTOCNT'			=> 1,
	'FMSHORTLISTCNT'		=> 3,
	'PMSHORTLISTCNT'		=> 1000,
	'FMBLOCKLISTCNT'		=> 1,
	'PMBLOCKLISTCNT'		=> 1000,
	'PRODUCTNAME'			=> $varUcDomain.'Matrimony',
	'DOMAINCONFFOLDER'		=> 'domainslist/'.$arrDomainInfo[$varDomain][2],
	'DOMAINCASTEID'			=> $arrDomainInfo[$varDomain][0],
	'TWITTERSERVERNAME'		=> 'http://www.communitymatrimony.com/twitter/',
	'TWITTERPORTALID'		=> '1');
//print $varServerRoot;
// META TAG VALUES
$confPageValues	=	array(
	'PAGETITLE'		=> $varUcDomain." Matrimony, Matrimony, Indian Matrimony",
	'PAGEDESC'		=> "Matrimony, Matrimony, Indian Matrimony. Searching For Your Life Partner? Join Free!",
	'KEYWORDS'		=> "Matrimony, Matrimony, Indian Matrimony",
	'ABSTRACT'		=> "Matrimony, Matrimony, Indian Matrimony",
	'AUTHOR'		=> "Matrimony, Matrimony, Indian Matrimony",
	'COPYRIGHT'		=> "Copyright &copy; ".date('Y')." Consim Info Pvt Ltd. All rights reserved.",
	'DISTRIBUTION'	=> "Matrimony, Matrimony, Indian Matrimony");

// CASTE WHERE CLAUSE CONDITION FOR TABLE BASED
$varWhereClause	= "CommunityId=".$arrDomainInfo[$varDomain][0];

// PROFILE COMPLETENESS ARRAY VARIABLES
$arrProfileCompleteScore = array('DEFAULT'=>45,'PHOTO'=>10,'PARTPREF'=>10,'FAMILY'=>10,'HOBBIES'=>5, 'HOROSCOPE'=>10,'PHONE'=>10);
?>