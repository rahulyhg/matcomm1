<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');
include_once($varBaseRoot.'/lib/clsBasicview.php');
include_once($varBaseRoot.'/lib/clsBasicviewCommon.php');

//Object Decleration
$objBasicView = new BasicView();
$objBasicComm = new BasicviewCommon();

//Variable Decleration
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPP			= $_COOKIE['partnerInfo'];

$varNeedCount	= $_POST['cn'];
$varWhereCond	= $objBasicComm->decryptData($_POST['wc']);

$varViews		= $_POST['view']!='' ? $_POST['view'] : 1;
$varPageNo		= ($_POST['Page'] != '' && $_POST['Page']>0) ? $_POST['Page'] : 1;
$varNoOfRec		= $varViews*10;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;

if($_POST['srchId']!='' && is_numeric($_POST['srchId'])){
	$varSavedSearchInfo = trim($_COOKIE['savedSearchInfo'].'~'.$_POST['srchId'].'|'.$_POST['srchType'].'|'.$_POST['srchName'], '~');
	setcookie("savedSearchInfo",$varSavedSearchInfo, "0", "/",$confValues['DOMAINNAME']);
}

//if($varPageNo>5 && $sessMatriId ==''){header("Location:".$confValues['SERVERURL'].'/register/');}

if($varWhereCond != ''){

if($varNeedCount == 'S')
{
	$arrCNTQuery			= split('ORDER', $varWhereCond);
	$varCondition['CNT']	= $arrCNTQuery[0];
	$varCondition['LIMIT']	= $varWhereCond." LIMIT ".$varStartRec.",".$varNoOfRec;
}
else
{
	$varCondition['CNT']	= '';
	$varCondition['LIMIT']	= $varWhereCond;
}

//Connect DB
$objBasicView->dbConnect('S', $varDbInfo['DATABASE']);
$objBasicView->clsSessMatriId		= $sessMatriId;
$objBasicView->clsSessPartnerPref	= $sessPP;

//Get Records
$arrResult	  = $objBasicView->selectDetails($varCondition, 'N');
$varTotalRecs = $arrResult['TOT_CNT']=='' ? 0 : $arrResult['TOT_CNT'];

$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

unset($arrResult['TOT_CNT']);

//Close DB
$objBasicView->dbClose();

//Unset Object
unset($objBasicView);
unset($objBasicComm);

print $varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/basicview/bv_ctrl.php#^~^#'. json_encode($arrResult);
}
?>