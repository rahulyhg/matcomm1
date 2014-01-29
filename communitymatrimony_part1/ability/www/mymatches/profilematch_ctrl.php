<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/lib/clsProfileMatch.php');

//Variable Decleration
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPP			= $_COOKIE["partnerInfo"];
$varProOption	= $_REQUEST['tabId']!='' ? $_REQUEST['tabId'] : 'PMI';

//Basic view variables
$varViews		= $_REQUEST['view']!='' ? $_REQUEST['view'] : 1;
$varPageNo		= $_REQUEST['Page'] != '' ? $_REQUEST['Page'] : 1;
$varNoOfRec		= 10;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;

//Object Decleration
$objProfileMatch	= new ProfileMatch();

//Connect DB
$objProfileMatch->dbConnect('S', $varDbInfo['DATABASE']);
$objProfileMatch->clsSessPartnerPref	= $sessPP;
$objProfileMatch->clsSessMatriId		= $sessMatriId;
$objProfileMatch->clsGender				= $sessGender==1 ? 2 : 1;

//Get ProfileMatch Related Info
$varFields		= array('MatriId');
$varOrderBy		= 'Date_Created';
$varTableName	= $varTable['PROFILEMATCHINFO'];

switch($varProOption)
{
	case 'PMI':
			$varMsgCont	= '<p>Displayed below are members whose profile matches with your partner preference.</p>';
			break;

	
	case 'PML':
			$varMsgCont	= '<p>Displayed below are members whose partner preference matches with your profile.</p>';
			break;

	case 'PMM':
			$varMsgCont	= '<p>Displayed below are members whose profile and partner preference matches with your profile and partner preference.</p>';
			break;
}

$varTotalRecs	= $objProfileMatch->SelectProDetails($varTableName, $varFields, $varProOption, $varStartRec, $varNoOfRec);

//Paging Calculation starts here
$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

if($varTotalRecs > 0){
	$varOppIds		= $objProfileMatch->arrProIdsDet;
	$varNoOfOppIds	= count($varOppIds);

	//Basic View Related Functionality Starts Here
	$varMatriIds	= "'".join("', '", $varOppIds)."'";
	$varWhereCond	= 'WHERE MatriId IN('.$varMatriIds.')';
	$varCondition['CNT']	= $varWhereCond;
	$varCondition['LIMIT']	= $varWhereCond;
	
	//Get Records
	$arrResult		= $objProfileMatch->selectDetails($varCondition, '');
	$arrBVResult	= array();
	if($varNoOfOppIds > $arrResult['TOT_CNT'])
	{
		unset($arrResult['TOT_CNT']);
		$varTotMissedIdsDet = array();
		$varMissedIds = array_diff($varOppIds, $objProfileMatch->clsBVMatriIds);
		$varDelIds	  = "'".join("', '", $varMissedIds)."'";
		$varDelIdsDet = $objProfileMatch->getDeletedIdsDet($varDelIds);
		
		if(count($varMissedIds) > count($objProfileMatch->clsDelMatriIds))
		{
			$varTotMissedIds	= array_diff($varMissedIds, $objProfileMatch->clsDelMatriIds);
						
			foreach($varTotMissedIds as $singVal)
			{
				$varTotMissedIdsDet[$singVal]['ID'] = "$singVal";
				$varTotMissedIdsDet[$singVal]['PU'] = 'TD';
				$varTotMissedIdsDet[$singVal]['UN'] = '';
				$varTotMissedIdsDet[$singVal]['G']  = '';
			}
		}
		
		$arrMergedIds1 = array_merge($varDelIdsDet, $varTotMissedIdsDet);
		$arrMergedIds2 = array_merge($arrMergedIds1, $arrResult);
		foreach($arrMergedIds2 as $arrSinVal)
		{
			$arrBVResult[] = $arrSinVal;
		}
	}
	else
	{
		unset($arrResult['TOT_CNT']);
		$arrBVResult = $arrResult;
	}

	//Unset Object
	$objProfileMatch->dbClose();
	unset($objProfileMatch);

	print $varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/mymatches/profilematch_ctrl.php#^~^#'. json_encode($arrBVResult).'#^~^#'.$varProOption;
}
else
{
	print '1#^~^#0#^~^#0#^~^#1#^~^#/mymatches/profilematch_ctrl.php#^~^##^~^#';
}
?>