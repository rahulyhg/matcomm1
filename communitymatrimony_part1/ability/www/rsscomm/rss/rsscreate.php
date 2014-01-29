<?php
#================================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-02-19
# End Date		: 2009-02-19
# Project		: MatrimonyProduct
# Module		: Search - RSS Feed Search
#================================================================================================================
//ROOT DIR
$varServerRoot		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsRSS.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

//OBJECT DECLARATION
$objDB = new DB;
$objDomainInfo	= new domainInfo;

//Connect DB
$objDB->dbConnect('S2', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varCategory		= $_REQUEST['cat'];
$varReplace			= array(' ','/',"'");
$varFind			= array('^','~','_');
$varTitle			= str_replace ($varFind,$varReplace,$_REQUEST['title']);
$varSubCategory		= $varTitle;
$varGender			= $_REQUEST['gen'];
$varGenderVal		= ($varGender=='Bride')?2:1;
$filepath			= $_SERVER[REQUEST_URI];


$arrReligion		= $objDomainInfo->getReligionOption();
$arrDenomination	= $objDomainInfo->getDenominationOption();
$arrCaste			= $objDomainInfo->getCasteOption();
$arrSubcaste		= $objDomainInfo->getSubcasteOption();

//CONDITIONAL STATEMENTS
switch($varCategory)
{
	case 'Religion':
		$varPrimary		= 'Religion';
		$arrValue		= $arrReligion;
		$varTitle		= $objDomainInfo->getReligionLabel();
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'Denomination':
		$varPrimary		= 'Denomination';
		$arrValue		= $arrDenomination;
		$varTitle		= $objDomainInfo->getDenominationLabel();
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'Caste':
		$varPrimary		= 'CasteId';
		$arrValue		= $arrCaste;
		$varTitle		= $objDomainInfo->getCasteLabel();
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'Subcaste':
		$varPrimary		= 'SubcasteId';
		$arrValue		= $arrSubcaste;
		$varTitle		= $objDomainInfo->getSubcasteLabel();
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'MaritalStatus':
		$varPrimary		= 'Marital_Status';
		$arrValue		= $objDomainInfo->getMaritalStatusOption();
		$varTitle		= $objDomainInfo->getMaritalStatusLabel();
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'MotherTongue':
		$varPrimary		= 'Mother_TongueId';
		$arrValue		= $objDomainInfo->getMotherTongueOption();
		$varTitle		= $objDomainInfo->getMotherTongueLabel();
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'Country':
		$varPrimary		= 'Country';
		$arrValue		= $arrCountryList;
		$varTitle		= 'Country';
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;
	
	case 'Occupation':
		$varPrimary		= 'Occupation';
		$arrValue		= $arrOccupationList;
		$varTitle		= 'Occupation';
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;
	
	case 'Education':
		$varPrimary		= 'Education_Category';
		$arrValue		= $arrEducationList;
		$varTitle		= 'Education';
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'Star':
		$varPrimary		= 'Star';
		$arrValue		= $arrStarList;
		$varTitle		= 'Star';
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'Raasi':
		$varPrimary		= 'Raasi';
		$arrValue		= $arrRaasiList;
		$varTitle		= 'Raasi';
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;

	case 'Habits':
		$varPrimary		= 'Eating_Habits';
		$arrValue		= $arrEatingHabitsList;
		$varTitle		= 'Eating Habits';
		$varSelValue	= array_keys($arrValue, $varSubCategory);
		break;
}

$varFields		= Array('MatriId', 'Age', 'Gender', 'Height', 'Height_Unit', 'Religion', 'Denomination', 'CasteId', 'CasteText', 'SubcasteId', 'SubcasteText', 'Mother_TongueId', 'Education_Category', 'Education_Detail', 'Occupation', 'Occupation_Detail', 'About_Myself', 'Date_Created');

if($varPrimary !='' && $varSelValue[0]!=''){
	$varWhereCond	= 'WHERE '.$varWhereClause.' AND '.$varPrimary.'='.$objDB->doEscapeString($varSelValue[0],$objDB).' AND Gender='.$objDB->doEscapeString($varGenderVal,$objDB).' AND Publish=1 ORDER BY Date_Created DESC LIMIT 20';
}else{
	$varWhereCond	= 'WHERE '.$varWhereClause.' AND Gender='.$objDB->doEscapeString($varGenderVal,$objDB).' AND Publish=1 ORDER BY Date_Created DESC LIMIT 20';
}

//print $varWhereCond;exit;
$varResults		=	$objDB->select($varTable['MEMBERINFO'], $varFields, $varWhereCond, 1);
$varResultCnt	=   count($varResults);

if($varResultCnt==0) 
{
	die("<br><br><font style='font-weight:bold;font-family:verdana;font-size:12px;'>RSS Feed display error due to low Internet Speed or Database Connectivity or No Records. Please try again later.</font><br>");
}
else 
{
	header( "Content-Type: text/xml" );
	$varObjRss = new rss('utf-8');
	$filename  = '';
	$varProductName = $confValues['PRODUCTNAME'];
	$varRsstitle = $varProductName." - ".$varTitle." - ".$varSubCategory." - ".$varGender." - RSS Feed";

	$varObjRss->channel($varRsstitle, 'http://www.'.$varProductName.'matrimonial.com', $varProductName.' Matrimonial Profiles');

	$varRss_filepath = $filepath;
	$varObjRss->startRSS($varRss_filepath,$filename);
	for($i=0;$i<$varResultCnt;$i++)
	{
		$varResultGender	= $varResults[$i]['Gender']==2?'Female':'Male';
		$varResultGen		= $varResults[$i]['Gender']==2?'Bride':'Groom';
		$varResultOppGen	= $varResults[$i]['Gender']==2?'Groom':'Bride';
		$varHeightfeetInchs = ($varResults[$i]['Height_Unit']!='cm') ? $arrHeightFeetList[$varResults[$i]['Height']] : $arrHeightFeetList[$arrParHeightList[round($varResults[$i]['Height'])]];
		$varHeightfeets	= explode(' ',$varHeightfeetInchs);
		$varHeightFeetRep	= str_replace('ft',"'",$varHeightfeets[0]);
		$varHeightinchRep	= $varHeightfeets[1]!='/'?str_replace('in','"',$varHeightfeets[1]):'';
		$varHeightfeet		= $varHeightFeetRep.$varHeightinchRep;

		$varReligion		= $arrReligion[$varResults[$i]['Religion']];
		$varDenomination	= $arrDenomination[$varResults[$i]['Denomination']];
		$varResultCaste		= $arrCaste[$varResults[$i]['CasteId']]!=''? $arrCaste[$varResults[$i]['CasteId']] : $varResults[$i]['CasteText'];
		$varResultSubcaste	= $arrSubcaste[$varResults[$i]['SubcasteId']]!=''? $arrSubcaste[$varResults[$i]['SubcasteId']] : $varResults[$i]['SubcasteText'];
		
		$varWholeRELInfo	= ($varReligion != '') ? ($varDenomination!='' ? $varReligion.', '.$varDenomination : $varReligion) : $varDenomination; 
		$varWholeRELInfo	= ($varWholeRELInfo != '') ? ($varResultCaste!='' ? $varWholeRELInfo.', '.$varResultCaste : $varWholeRELInfo) : $varResultCaste; 
		$varWholeRELInfo	= ($varWholeRELInfo != '') ? ($varResultSubcaste!='' ? $varWholeRELInfo.', '.$varResultSubcaste : $varWholeRELInfo) : $varResultSubcaste; 

		$varResultEduc		= $arrEducationDisplay[$varResults[$i]['Education_Category']] ? $arrEducationDisplay[$varResults[$i]['Education_Category']] : $varResults[$i]['Education_Detail'];

		$varResultOccu		= $arrOccupationList[$varResults[$i]['Occupation']] ? $arrOccupationList[$varResults[$i]['Occupation']] : $varResults[$i]['Occupation_Detail'];

		$varResultLanguage  = $arrMotherTongueList[$varResults[$i]['Mother_Tongue']];
		$ProfileDescription	= $varResults[$i]['About_Myself'];

		$varTitleValue = $varResults[$i]['Age'].' Yrs , '.$varResultGender.' , '.$varHeightfeet.' , '.$varWholeRELInfo;
		$varTitleValue = "<![CDATA[".$varTitleValue."]]>";
		$varProfileLink = $confValues['SERVERURL']."/member/".$varResults[$i]['MatriId']."/";

		$ProfileDesc = $varResultLanguage." speaking ".$varResultGen." seeks ".$varResultOppGen.".";
		$ProfileDesc .= " Education: ".$varResultEduc.".";
		$ProfileDesc .= " Occupation: ".$varResultOccu.".";
			
		$ProfileDescription = trim($ProfileDescription);
		$ProfileDescription = nl2br($ProfileDescription);
		$profile_array = str_word_count($ProfileDescription, 1);
		for($y=0;$y<=150;$y++) {
			$ProfileDesc .= " ".$profile_array[$y];
		}
		$ProfileDesc .= " ...";
		$ProfileDesc = "<![CDATA[".$ProfileDesc."]]>";
		$varObjRss->itemTitle($varTitleValue);
		$varObjRss->itemLink($varProfileLink);
		$varObjRss->itemDescription($ProfileDesc);
		$varObjRss->itemGuid($varProfileLink);
		$varObjRss->addItem();
		
	}//for
	$data = $varObjRss->RSSdone();
	$varObjRss->clearRSS();
	
	print $data;
}//else

//UNSET OBJ
$objDB->dbClose();
unset($objDB);
unset($objDomainInfo);
?>
