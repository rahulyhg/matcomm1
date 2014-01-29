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
include_once($varRootBasePath.'/lib/clsDomain.php');

//OBJECT DECLARATION
$objDB = new DB;
$objDomainInfo	= new domainInfo;

//Connect DB
$objDB->dbConnect('S2', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varCategory		= $_REQUEST['cat'];
$varLinkTxt			= $_REQUEST['title'];

$varReplace			= array(' ', '/', "'");
$varFind			= array('^', '~', '_');
$varSubCategory		= str_replace($varFind, $varReplace, $varLinkTxt);

$arrReligion		= $objDomainInfo->getReligionOption();
$arrDenomination	= $objDomainInfo->getDenominationOption();
$arrCaste			= $objDomainInfo->getCasteOption();
$arrSubcaste		= $objDomainInfo->getSubcasteOption();

//CONDITIONAL STATEMENTS
if($varCategory !=''){
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
}//switch
}//if

$varFields	= array('MatriId', 'Age', 'Gender', 'Height', 'Height_Unit', 'Religion', 'Denomination', 'CasteId', 'CasteText', 'SubcasteId', 'SubcasteText', 'Mother_TongueId', 'Education_Category', 'Education_Detail', 'Occupation', 'Occupation_Detail', 'About_Myself', 'Date_Created');
?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
</head>
<body>

<table width="99%" align="center" border="0" cellpadding="5" cellspacing="1">
<tr> 
	<td colspan='2'>
		<table width="100%" cellspacing=0 cellpadding=0 style="border-bottom:1px solid #CBCBCB;">
		<tr>
			<td align='left'>
			<a href="<?=$confValues['SERVERURL']?>" alt=""><img src="<?=$confValues['IMGSURL']?>/logo/<?=$arrDomainInfo[$varDomain][2]?>_logo.gif"  border=0></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr align='center' bgcolor='#efefef'>
	<td colspan='2' class="clr normtxt1 bld"><a href="<?=$confValues['SERVERURL']?>" target="_blank" class="clr1"><?=$confValues['PRODUCTNAME']?></a> RSS Feeds</td>
</tr>
<tr><td height="10"></td></tr>
<tr valign='top'>
		<td width='49%' valign=top style='border-right:1px solid #CBCBCB;'><a href="<?=$confValues['SERVERURL']?>/feeds/<?echo $varCategory;echo $varSubCategory!=''?'/'.$varLinkTxt:'' ?>.html" target='_blank' style='text-decoration:none;'><font class="clr1 normtxt1 bld"><?=$confValues['PRODUCTNAME']?> <?= $varSubCategory!=''?$varSubCategory:$varLinkTxt ?> Bride</font></a><font class="clr normtxt1 bld"> - RSS Feed</font><br><br>
		<?php
		if($varSubCategory!='' && $varSelValue[0]!='')
			$varWhereCond	= 'WHERE '.$varWhereClause.' AND '.$varPrimary.'='.$objDB->doEscapeString($varSelValue[0],$objDB).' AND Gender=2 AND Publish=1 ORDER BY Date_Created DESC LIMIT 20';
		else
			$varWhereCond	= 'WHERE '.$varWhereClause.' AND Gender=2 AND Publish=1 ORDER BY Date_Created DESC LIMIT 20'; 
		
		$varResultsBride	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varWhereCond, 1);
		$varResultBrideCnt	= count($varResultsBride);
		if ($varResultBrideCnt == 0) {
		die("<br><br><font style='font-weight:bold;font-family:verdana;font-size:12px;'>RSS Feed display error due to low Internet Speed or Database Connectivity or No Records. Please try again later.</font><br>");		
		} else {

		$varResultGender	= 'Female';
		$varResultGen		= 'Bride';
		$varResultOppGen	= 'Groom';
		for($i=0;$i<$varResultBrideCnt;$i++)
		{
			$varHeightfeetInchs = ($varResultsBride[$i]['Height_Unit']!='cm') ? $arrHeightFeetList[$varResultsBride[$i]['Height']] : $arrHeightFeetList[$arrParHeightList[round($varResultsBride[$i]['Height'])]];
			$varHeightfeets	    = explode(' ',$varHeightfeetInchs);
			$varHeightFeetRep	= str_replace('ft',"'",$varHeightfeets[0]);
			$varHeightinchRep	= $varHeightfeets[1]!='/'?str_replace('in','"',$varHeightfeets[1]):'';
			$varHeightfeet		= $varHeightFeetRep.$varHeightinchRep;

			$varReligion		= $arrReligion[$varResultsBride[$i]['Religion']];
			$varDenomination	= $arrDenomination[$varResultsBride[$i]['Denomination']];
			$varResultCaste		= $arrCaste[$varResultsBride[$i]['CasteId']]!=''? $arrCaste[$varResultsBride[$i]['CasteId']] : $varResultsBride[$i]['CasteText'];
			$varResultSubcaste	= $arrSubcaste[$varResultsBride[$i]['SubcasteId']]!=''? $arrSubcaste[$varResultsBride[$i]['SubcasteId']] : $varResultsBride[$i]['SubcasteText'];
		
			$varWholeRELInfo	= ($varReligion != '') ? ($varDenomination!='' ? $varReligion.', '.$varDenomination : $varReligion) : $varDenomination; 
			$varWholeRELInfo	= ($varWholeRELInfo != '') ? ($varResultCaste!='' ? $varWholeRELInfo.', '.$varResultCaste : $varWholeRELInfo) : $varResultCaste; 
			$varWholeRELInfo	= ($varWholeRELInfo != '') ? ($varResultSubcaste!='' ? $varWholeRELInfo.', '.$varResultSubcaste : $varWholeRELInfo) : $varResultSubcaste; 

			$varResultEduc		= $arrEducationDisplay[$varResultsBride[$i]['Education_Category']] ? $arrEducationDisplay[$varResultsBride[$i]['Education_Category']] : $varResultsBride[$i]['Education_Detail'];

			$varResultOccu		= $arrOccupationList[$varResultsBride[$i]['Occupation']] ? $arrOccupationList[$varResultsBride[$i]['Occupation']] : $varResultsBride[$i]['Occupation_Detail'];

			$varResultLanguage  = $arrMotherTongueList[$varResultsBride[$i]['Mother_Tongue']];
			$ProfileDescription	= $varResultsBride[$i]['About_Myself'];

			$profile_array		= str_word_count($ProfileDescription, 1);
			$ProfileDesc = '';
			for($y=0;$y<=50;$y++){
				$ProfileDesc .= " ".$profile_array[$y];
			}
			$ProfileDesc .= " ...";

			echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
			echo "<tr><td><a href='".$confValues['SERVERURL']."/member/".$varResultsBride[$i]['MatriId']."/' target='_blank' class='clr1 normtxt'>";
			echo $varResultsBride[$i]['Age'].' Yrs , '.$varResultGender.' , '.$varHeightfeet.' , '.$varWholeRELInfo;
			echo "</a></td></tr>";
			echo "<tr><td class='normtxt'>".$varResultLanguage." speaking ".$varResultGen." seeks ".$varResultOppGen.". Education: - ".$varResultEduc.". Occupation: ".$varResultOccu.".".$ProfileDesc."</td></tr><tr><td height='10'></td></tr><tr><td class='dotsep' height='1'><img src='".$confValues['IMGSURL']."'/trans.gif' width='1' height='1' /></td></tr></table><br>";
		}
		}//else
		?>
		</td>
		<td width='49%' valign=top><a href="<?=$confValues['SERVERURL']?>/feeds/<?=$varCategory?><?= $varSubCategory!=''?'/'.$varLinkTxt:'' ?>.html" target='_blank' style='text-decoration:none;'><font class="clr1 normtxt1 bld"><?=$confValues['PRODUCTNAME']?> <?= $varSubCategory!=''?$varSubCategory:$varLinkTxt ?> Groom</font></a><font class="clr normtxt1 bld"> - RSS Feed</font><br><br>
				
		<?php
		if($varSubCategory!='' && $varSelValue[0]!='')
			$varWhereCond	= 'WHERE '.$varWhereClause.' AND '.$varPrimary.'='.$objDB->doEscapeString($varSelValue[0],$objDB).' AND Gender=1 AND Publish=1 ORDER BY Date_Created DESC LIMIT 20';
		else
			$varWhereCond	= 'WHERE '.$varWhereClause.' AND Gender=1 AND Publish=1 ORDER BY Date_Created DESC LIMIT 20'; 
		
		$varResultsGroom	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varWhereCond, 1);
		$varResultGroomCnt	=   count($varResultsGroom);
		if ($varResultGroomCnt == 0) {
		die("<br><br><font style='font-weight:bold;font-family:verdana;font-size:12px;'>RSS Feed display error due to low Internet Speed or Database Connectivity or No Records. Please try again later.</font><br>");		
		} else {

		$varResultGender	= 'Male';
		$varResultGen		= 'Groom';
		$varResultOppGen	= 'Bride';

		for($i=0;$i<$varResultGroomCnt;$i++)
		{
			$varHeightfeetInchs = ($varResultsGroom[$i]['Height_Unit']!='cm') ? $arrHeightFeetList[$varResultsGroom[$i]['Height']] : $arrHeightFeetList[$arrParHeightList[round($varResultsGroom[$i]['Height'])]];
			$varHeightfeets  	= explode(' ',$varHeightfeetInchs);
			$varHeightFeetRep	= str_replace('ft',"'",$varHeightfeets[0]);
			$varHeightinchRep	= $varHeightfeets[1]!='/'?str_replace('in','"',$varHeightfeets[1]):'';
			$varHeightfeet		= $varHeightFeetRep.$varHeightinchRep;

			$varReligion		= $arrReligion[$varResultsGroom[$i]['Religion']];
			$varDenomination	= $arrDenomination[$varResultsGroom[$i]['Denomination']];
			$varResultCaste		= $arrCaste[$varResultsGroom[$i]['CasteId']]!=''? $arrCaste[$varResultsGroom[$i]['CasteId']] : $varResultsGroom[$i]['CasteText'];
			$varResultSubcaste	= $arrSubcaste[$varResultsGroom[$i]['SubcasteId']]!=''? $arrSubcaste[$varResultsGroom[$i]['SubcasteId']] : $varResultsGroom[$i]['SubcasteText'];
		
			$varWholeRELInfo	= ($varReligion != '') ? ($varDenomination!='' ? $varReligion.', '.$varDenomination : $varReligion) : $varDenomination; 
			$varWholeRELInfo	= ($varWholeRELInfo != '') ? ($varResultCaste!='' ? $varWholeRELInfo.', '.$varResultCaste : $varWholeRELInfo) : $varResultCaste; 
			$varWholeRELInfo	= ($varWholeRELInfo != '') ? ($varResultSubcaste!='' ? $varWholeRELInfo.', '.$varResultSubcaste : $varWholeRELInfo) : $varResultSubcaste; 
		
			$varResultEduc		= $arrEducationDisplay[$varResultsGroom[$i]['Education_Category']] ? $arrEducationDisplay[$varResultsGroom[$i]['Education_Category']] : $varResultsGroom[$i]['Education_Detail'];

			$varResultOccu		= $arrOccupationList[$varResultsGroom[$i]['Occupation']] ? $arrOccupationList[$varResultsGroom[$i]['Occupation']] : $varResultsGroom[$i]['Occupation_Detail'];

			$varResultLanguage = $arrMotherTongueList[$varResultsGroom[$i]['Mother_Tongue']];
			$ProfileDescription	= $varResultsGroom[$i]['About_Myself'];

			$profile_array	= str_word_count($ProfileDescription, 1);
			$ProfileDesc	= '';
			for($y=0;$y<=50;$y++){
				$ProfileDesc .= " ".$profile_array[$y];
			}
			$ProfileDesc .= " ...";

			echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
			echo "<tr><td><a href='".$confValues['SERVERURL']."/member/".$varResultsGroom[$i]['MatriId']."/' target='_blank' class='clr1 normtxt'>";
			echo $varResultsGroom[$i]['Age'].' Yrs , '.$varResultGender.' , '.$varHeightfeet.' , '.$varWholeRELInfo;
			echo "</a></td></tr>";
			echo "<tr><td class='normtxt'>".$varResultLanguage." speaking ".$varResultGen." seeks ".$varResultOppGen.". Education: - ".$varResultEduc.". Occupation: ".$varResultOccu.".".$ProfileDesc."</td></tr><tr><td height='10'></td></tr><tr><td class='dotsep' height='1'><img src='".$confValues['IMGSURL']."'/trans.gif' width='1' height='1' /></td></tr></table><br>";
		}//for
		}//else
		?>
	</td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#cbcbcb" style="padding:0px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
<tr><td colspan="2"><div align='center'><font class='smalltxt'><?=$confPageValues['COPYRIGHT'];?></font></div></td></tr>
</table>
<div align="right" class="smalltxt clr">* <a href="<?=$confValues['SERVERURL']?>/feeds/<?=$varPrimary?><?= $varSubCategory!=''?'/'.$varLinkTxt:'' ?>.html" class="clr1" title="<?= $varSubCategory!=''?$varSubCategory:$varPrimary;?> Feeds"><?=$confValues['PRODUCTNAME']?> <?= $varSubCategory!=''?$varSubCategory:$varLinkTxt;?></a> Feeds - Preview</font>&nbsp;&nbsp;&nbsp;</div>
<center><font class='smalltxt'>The above display is a preview of how our RSS feeds will look when added in your Website. <br>All content in the feeds are property of <?=$confValues['PRODUCTNAME']?>.com - <a href="<?=$confValues['SERVERURL']?>" target="_blank" title="Matrimonial Services" style="text-decoration:none;" class="smalltxt clr1">Matrimonial Services</a> Provider.</font></center>
</body>
</html>
<?
//UNSET OBJ
$objDB->dbClose();
unset($objDB);
unset($objDomainInfo);
?>