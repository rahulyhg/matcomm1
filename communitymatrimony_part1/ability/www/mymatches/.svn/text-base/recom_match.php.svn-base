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
$varNoOfRec		= 3;
$varStartRec	= 0;

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

	//Unset Object
	$objProfileMatch->dbClose();
	unset($objProfileMatch);

	$varCont = '<div class="normtxt clr bld padt20 tlleft rpanelinner">Recommended Matches</div>
	<div class="smalltxt clr padt5 tlleft rpanelinner">
		Looking for relevant matches? <a class="clr1" href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=partnerinfodesc">Edit partner preference.</a>
	</div><center><div class="rpanelinner">';

	foreach($arrBVResult as $singleProfile){
	$varMatriId		= $singleProfile['ID'];
	if($singleProfile['PH'] == ''){
		$varDivPhoto	= ($singleProfile['G']==1) ? 'noimg50_m' : 'noimg50_f';
		$varPhotoCont	= '<div class="imagepad">
						<img height="50" border="0" width="50" alt="" src="'.$confValues['IMGSURL'].'/'.$varDivPhoto.'.gif"/></div>';
	}else if($singleProfile['PH'] == 'P') {	
		$varOnClick		= "funVP('".$varMatriId."','".$varMatriId."photos');";
		$varPhotoCont	= '<div class="imagepad">
						<a href="javascript:;" onclick="'.$varOnClick.'"><img height="50" border="0" width="50" alt="" src="'.$confValues['IMGSURL'].'/img50_pro.gif"/></a></div>';
	}else {
		$varPhoto		= split('\^', $singleProfile['PH']);
		$varOnClick		= "window.open('".$confValues['IMAGEURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
		$varPhotoCont	= '<div class="imagepad">
						<a href="javascript:;" onclick="'.$varOnClick.'"><img height="50" border="0" width="50" alt="" src="'.$confValues['PHOTOURL'].'/'.$varMatriId{3}.'/'.$varMatriId{4}.'/'.$varPhoto[0].'"/></a></div>';
	}

	$varDetails = split('\^~\^', urldecode($singleProfile['DE']));
	$varHeight	= split('/', $varDetails[1]);
	$varCont .= '<div class="fullimg fleft tlleft">';
	$varCont .= $varPhotoCont;	
	$varCont .= '<div class="address"><a href="javascript:;" class="address">'.$varMatriId.'</a><br/>'.$varDetails[0].' yrs, '.$varHeight[0].',<br/>'.$varDetails[10].'<br/><a href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=viewprofile&id='.$varMatriId.'" class="smalltxt clr1">View Profile >></a></div></div>';
	}
	$varCont .= '</div>';
	$varCont .= '<div class="rpanelinner"><div class="smalltxt clr padt20 fleft">&nbsp;</div><div class="smalltxt padt20 fright"><a class="clr1" href="'.$confValues['SERVERURL'].'/mymatches/">More >></a></div></div></center><br clear="all"/>';
	print $varCont;
}
?>