<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');
include_once($varBaseRoot.'/lib/clsPhone.php');
include_once($varBaseRoot.'/lib/clsBasicview.php');

//Object Decleration
$objPhone	  = new Phone();
$objBasicView = new BasicView();

//DB Connection
$objPhone->dbConnect('S', $varDbInfo['DATABASE']);
$objBasicView->dbConnect('S', $varDbInfo['DATABASE']);

//Variable Decleration
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPP			= $_COOKIE['partnerInfo'];

$varViews		= $_POST['view']!='' ? $_POST['view'] : 1;
$varPageNo		= ($_POST['Page'] != '' && $_POST['Page']>0) ? $_POST['Page'] : 1;
$varNoOfRec		= $varViews*10;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;

$varWhereQuery	= '';
$varTotalRecs	= 0;
if($sessMatriId != ''){
	$varTotalRecs	= $objPhone->viewedMyPhoneNo($sessMatriId, $varStartRec, $varNoOfRec);
}

//Paging Calculation starts here
$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

if($varTotalRecs > 0){
	$varOppIds		= $objPhone->arrViewedMyPhoneNo;
	$varNoOfOppIds	= count($varOppIds);

	//Basic View Related Functionality Starts Here
	$varMatriIds	= "'".join("', '", $varOppIds)."'";
	$varWhereCond	= 'WHERE MatriId IN('.$varMatriIds.')';
	$varCondition['CNT']	= $varWhereCond;
	$varCondition['LIMIT']	= $varWhereCond;
	
	//Get Records
	$arrResult		= $objBasicView->selectDetails($varCondition, 'Y');

	if($varNoOfOppIds > $arrResult['TOT_CNT'])
	{
		unset($arrResult['TOT_CNT']);
		$varTotMissedIdsDet = array();
		$varMissedIds = array_diff($varOppIds, $objBasicView->clsBVMatriIds);
		$varDelIds	  = "'".join("', '", $varMissedIds)."'";
		$varDelIdsDet = $objBasicView->getDeletedIdsDet($varDelIds);
		
		if(count($varMissedIds) > count($objBasicView->clsDelMatriIds))
		{
			$varTotMissedIds	= array_diff($varMissedIds, $objBasicView->clsDelMatriIds);
						
			foreach($varTotMissedIds as $singVal)
			{
				$varTotMissedIdsDet[$singVal]['PU'] = 'TD';
				$varTotMissedIdsDet[$singVal]['UN'] = '';
				$varTotMissedIdsDet[$singVal]['G']  = '';
			}
		}
		$arrMergedIds1 = array_merge($varDelIdsDet, $varTotMissedIdsDet);
		$arrMergedIds2 = array_merge($arrMergedIds1, $arrResult);
		$arrBVResult = $arrMergedIds2;
	}
	else
	{
		unset($arrResult['TOT_CNT']);
		$arrBVResult = $arrResult;
	}

	$arrFinalBVRes = array();
	foreach($varOppIds as $varSingleId){
		$arrFinalBVRes[] = $arrBVResult[$varSingleId];
	}
	//Unset Object
	$objPhone->dbClose();
	$objBasicView->dbClose();
	unset($objPhone);
	unset($objBasicView);

	print $varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/phone/whoviewedphone_ctrl.php#^~^#'. json_encode($arrFinalBVRes).'#^~^#MPHV';
}else{
	print '1#^~^#0#^~^#0#^~^#1#^~^#/phone/whoviewedphone_ctrl.php#^~^##^~^#MPHV';
}
?>