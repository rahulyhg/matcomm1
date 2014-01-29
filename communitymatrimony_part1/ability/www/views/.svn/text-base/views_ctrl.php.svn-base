<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/lib/clsViews.php');

//Variable Decleration
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPP			= $_COOKIE['partnerInfo'];

if($sessMatriId != ''){
$varViewsOption	= $_REQUEST['tabId']!='' ? $_REQUEST['tabId'] : 'PHV';
//Basic view variables
$varRightIcon	= 'Y';
$varViews		= $_REQUEST['view']!='' ? $_REQUEST['view'] : 1;
$varPageNo		= $_REQUEST['Page'] != '' ? $_REQUEST['Page'] : 1;
$varShowRecs	= $_REQUEST['A'] == 'Y' ? 10 : 1;
$varJsFlag		= $_REQUEST['A'] == 'Y' ? 1 : '';
$varNoOfRec		= $varViews*$varShowRecs;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;

//Object Decleration
$objViews	= new Views();

//Connect DB
$objViews->dbConnect('S', $varDbInfo['DATABASE']);

$objViews->clsSessMatriId		= $sessMatriId;
$objViews->clsSessPartnerPref	= $sessPP;


//Get Views Related Info
switch($varViewsOption)
{
	case 'PHV': //Phone Views
			$varFields		= array('Opposite_MatriId','Date_Viewed');
			$varOrderBy		= 'Date_Viewed';
			$varTableName	= $varTable['PHONEVIEWLIST'];
			$varMsgCont		= '<p></p>';
			break;

	
	case 'PRV': //Profile Views
			$varTab			= 'R';
			$varFields		= array('Profile_Viewed');
			$varOrderBy		= 'Date_Created';
			$varTableName	= $varTable['MEMBERINFO'];
			$varMsgCont		= '<p></p>';
			break;

}
//SUB TAB STARTS HERE - Phone Views
$varTabCont	= '<div id="t1div1" style="float:left;"  onmouseout="hidetip();">';
if($varViewsOption{1} == 'H')
{
	$varTabCont .= '<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 5px; height: 26px;"></div>
	<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg2.gif) no-repeat scroll right top; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 26px;">';
	$varTabCont .= "<div style='padding: 5px 10px 0pt 5px;' class='mediumtxt' onmouseover=\"showhint('Displays all the members who have viewed your phone number' ,this,event,'170');\" onmouseout='hidetip();'>Phone Views</div>";
	$varTabCont .= '<div style="margin-top: 5px; padding-left: 35px;"><img src="'.$confValues["IMGSURL"].'/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div></div>';

}
else
{
	$varTabCont .= "<div style='padding: 5px 10px 0pt;' class='mediumtxt'><a href=\"javascript:funMyHome('/views/views_ctrl.php','PHV', '','".$varJsFlag."');hidetip();\" onmouseover=\"showhint('Displays all the members who have viewed your phone number' ,this,event,'170');\" onmouseout='hidetip();'>Phone Views</a></div>";
}

$varTabCont .= '</div>';							

$varTabCont	.= '<div id="t1div2" style="float:left;"  onmouseout="hidetip();">';
if($varViewsOption{1} == 'R') {

	$varTabCont .= '<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 5px; height: 26px;"></div>
	<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg2.gif) no-repeat scroll right top; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 26px;">';
	$varTabCont .= "<div style='padding: 5px 10px 0pt 5px;' class='mediumtxt' onmouseover=\"showhint('Displays all the members who have viewed your profile' ,this,event,'170');\" onmouseout='hidetip();'>Profile Views</div>";
	$varTabCont .= '<div style="margin-top: 5px; padding-left: 35px;"><img src="'.$confValues["IMGSURL"].'/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div></div>';

} else {
	$varTabCont .= "<div style='padding: 5px 10px 0px;' class='mediumtxt'><a href=\"javascript:funMyHome('/views/views_ctrl.php','PRV', '','".$varJsFlag."');hidetip();\" onmouseover=\"showhint('Displays all the members who have viewed your profile' ,this,event,'170');\" onmouseout='hidetip();'>Profile Views</a></div>";
}
$varTabCont .= '</div>';
//SUB TAB ENDS HERE - Views


$varWhere		= "WHERE MatriId='".$sessMatriId."'";

if ($varViewsOption=='PRV') {
		$varExecute			= $objViews->select($varTableName, $varFields, $varWhere, 0);
		$varResult			= mysql_fetch_array($varExecute);
		$varProfileViewd	= $varResult['Profile_Viewed'];
		echo '<div style="width:506px;" class="smalltxt boldtxt">&nbsp;&nbsp;Your profile has been viewed by '.$varProfileViewd.' people.</div>#^~^#'.$varTabCont;
}
else {
	$varTotalRecs	= $objViews->numOfRecords($varTableName, 'MatriId', $varWhere);

	//Paging Calculation starts here
	$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
	$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

	if($varTotalRecs > 0)
	{
		$varWhere	   .= ' ORDER BY Date_Viewed DESC LIMIT '.$varStartRec.', '.$varNoOfRec;
		$varArrViewsDet	= $objViews->SelectViewsDetails($varTableName, $varFields, $varWhere, $varViewsOption);
		$varOppIds		= array_unique($objViews->arrViewsDet);
		$varNoOfOppIds	= count($varOppIds);

		//Basic View Related Functionality Starts Here
		$varMatriIds	= "'".join("', '", $varOppIds)."'";
		$varWhereCond	= 'WHERE MatriId IN('.$varMatriIds.')';
		$varCondition['CNT']	= $varWhereCond;
		$varCondition['LIMIT']	= $varWhereCond;

		//Get Records
		$arrResult		= $objViews->selectDetails($varCondition, 'Y');

		if($varNoOfOppIds > $arrResult['TOT_CNT'])
		{
			unset($arrResult['TOT_CNT']);
			$varTotMissedIdsDet = array();
			$varMissedIds = array_diff($varOppIds, $objViews->clsBVMatriIds);
			$varDelIds	  = "'".join("', '", $varMissedIds)."'";
			$varDelIdsDet = $objViews->getDeletedIdsDet($varDelIds);
			
			if(count($varMissedIds) > count($objViews->clsDelMatriIds))
			{
				$varTotMissedIds	= array_diff($varMissedIds, $objViews->clsDelMatriIds);
							
				foreach($varTotMissedIds as $singVal)
				{
					$varTotMissedIdsDet[$singVal]['PU'] = 'TD';
					$varTotMissedIdsDet[$singVal]['UN'] = '';
					$varTotMissedIdsDet[$singVal]['G']  = '';
				}
			}
			$arrMergedIds1 = array_merge($varDelIdsDet, $varTotMissedIdsDet);
			$arrMergedIds2 = array_merge($arrMergedIds1, $arrResult);
			$arrBVResult[0] = $arrMergedIds2;
		}
		else
		{
			unset($arrResult['TOT_CNT']);
			$arrBVResult[0] = $arrResult;
		}
				
		//JSON Results
		$varJsonMsg	  = json_encode($varArrViewsDet);
		$varJsonBview =	json_encode($arrBVResult);
				
		//Unset Object
		$objViews->dbClose();
		unset($objViews);

		print $varViewsOption.'#^~^#'.$varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/views/views_ctrl.php#^~^#'.$varJsonBview.'#^~^#'.$varJsonMsg.'#^~^#'.$varTabCont.'#^~^##^~^#'.$varMsgCont;
	}
	else
	{
		print $varViewsOption.'#^~^#1#^~^#0#^~^#0#^~^#0#^~^#/views/views_ctrl.php#^~^##^~^##^~^#'.$varTabCont.'#^~^##^~^#';
	}
}
} else{ print '0';}
?>