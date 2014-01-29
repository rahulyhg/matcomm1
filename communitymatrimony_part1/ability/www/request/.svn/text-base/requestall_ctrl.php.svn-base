<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/lib/clsRequest.php');

//Variable Decleration
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPP			= $_COOKIE["partnerInfo"];

//Connect DB
$objRequest->dbConnect('S', $varDbInfo['DATABASE']);

$objRequest->clsSessMatriId		= $sessMatriId;
$objRequest->clsSessPartnerPref	= $sessPP;

if($sessMatriId != ''){
$varReqOption	= $_REQUEST['tabId']!='' ? $_REQUEST['tabId'] : 'RRPO';

//Basic view variables
$varViews		= $_REQUEST['view']!= '' ? $_REQUEST['view'] : 1;
$varPageNo		= $_REQUEST['Page']!= '' ? $_REQUEST['Page'] : 1;
$varShowRecs	= 10;
$varNoOfRec		= $varViews*$varShowRecs;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;
$varModule		= '';
$varFields		= array();
$varOption	= substr($varReqOption, 0 , 2);
if($varOption== 'RR')
{
	$varModule		= 'RR';
	$varFields		= array('RequestId','SenderId', 'RequestDate');
	$varTableName	= $varTable['REQUESTINFORECEIVED'];
	$varWhere		= "WHERE ReceiverId=".$objRequest->doEscapeString($sessMatriId,$objRequest);
}
else
{
	$varModule		= 'RS';
	$varFields		= array('RequestId','ReceiverId', 'RequestDate');
	$varTableName	= $varTable['REQUESTINFOSENT'];
	$varWhere		= "WHERE SenderId=".$objRequest->doEscapeString($sessMatriId,$objRequest);
}

//Object Decleration
$objRequest	= new Request();


//SUB TAB STARTS HERE - Interest Received / Interest Sent
$varTabCont	= '<div id="t1div1" style="float:left;"  onmouseout="hidetip();">';
if($varModule == 'RR')
{
	$varTabCont .= '<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 5px; height: 26px;"></div>
	<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg2.gif) no-repeat scroll right top; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 26px;">';
	$varTabCont .= "<div style='padding: 5px 10px 0pt 5px;' class='mediumtxt' onmouseover=\"showhint('Displays all the requests you\'ve received' ,this,event,'170');\" onmouseout='hidetip();'>Requests Received</div>";
	$varTabCont .= '<div style="margin-top: 6px; padding-left: 45px;"><img src="'.$confValues["IMGSURL"].'/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div></div>';
}
else
{
	$varTabCont .= "<div style='padding: 5px 10px 0pt;' class='mediumtxt'><a href=\"javascript:MyHomeReqCall('RR-A');hidetip();\" onmouseover=\"showhint('Displays all the requests you\'ve received' ,this,event,'170');\" onmouseout='hidetip();'>Requests Received</a></div>";
}
$varTabCont .= '</div>';

$varTabCont	.= '<div id="t1div2" style="float:left;"  onmouseout="hidetip();">';
if($varModule == 'RS')
{
	$varTabCont .= '<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 5px; height: 26px;"></div>
	<div style="background: transparent url('.$confValues["IMGSURL"].'/inner-mtab-bg2.gif) no-repeat scroll right top; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 26px;">';
	$varTabCont .= "<div style='padding: 5px 10px 0pt 5px;' class='mediumtxt' onmouseover=\"showhint('Displays all the requests you\'ve sent' ,this,event,'170');\" onmouseout='hidetip();'>Requests Sent</div>";
	$varTabCont .= '<div style="margin-top: 6px; padding-left: 45px;"><img src="'.$confValues["IMGSURL"].'/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div></div>';

	
}
else
{
	$varTabCont .= "<div style='padding: 5px 10px 0pt;' class='mediumtxt'><a href=\"javascript:MyHomeReqCall('RS-A');hidetip();\" onmouseover=\"showhint('Displays all the requests you\'ve sent' ,this,event,'170');\" onmouseout='hidetip();'>Requests Sent</a></div>";
}
$varTabCont .= '</div>';
//SUB TAB ENDS HERE -



//Inner Tab content starts here
$varSubtitle = '';
$varButton	 = '';
switch ($varReqOption)
{
	case 'RRPO': //Request PhotO received
		$varSubtitle	= 'Photo';
		$varStatus		= '1';
		$varMsgCont		= '<p>Displayed here are all the members from whom you have received Photo requests.</p>';
		if($varGetCookieInfo['PHOTOSTATUS']==0){
			$varButton	= '<div class="smalltxt fright button-padd" style="padding-top:3px;"><a href="javascript:;" onclick="window.location=\''.$confValues["SERVERURL"].'/tools/index.php?add=photo\';"><input type="button" class="button button-border" value="Add Photo"/></a></div>';
		}
		break;
	case 'RRRE': //Request REference received
		$varSubtitle	= 'Reference';
		$varStatus		= '2';
		$varMsgCont		= '<p>Displayed here are all the members from whom you have received Reference requests.</p>';
		if($varGetCookieInfo['REFERENCESTATUS']==0){
			$varButton	= '<div class="smalltxt fright button-padd" style="padding-top:3px;"><a href="javascript:;" onclick="window.location=\''.$confValues["SERVERURL"].'/tools/index.php?add=reference\';"><input type="button" class="button button-border" value="Add Reference"/></a></div>';
		}
		break;
	case 'RRPH': //Request PHone received
		$varSubtitle	= 'Phone';
		$varStatus		= '3';
		$varMsgCont		= '<p>Displayed here are all the members from whom you have received Phone requests.</p>';
		if($varGetCookieInfo['PHONEVERIFIED']==0){
			$varButton	= '<div class="smalltxt fright button-padd" style="padding-top:3px;"><a href="javascript:;" onclick="window.location=\''.$confValues["SERVERURL"].'/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=contactedit&inview=2\';"><input type="button" class="button button-border" value="Add Phone"/></a></div>';
		}
		break;
	case 'RRVO': //Request VOice received
		$varSubtitle	= 'Voice';
		$varStatus		= '4';
		$varMsgCont		= '<p>Displayed here are all the members from whom you have received Voice requests.</p>';
		if($varGetCookieInfo['VOICESTATUS']==0){
			$varButton	= '<div class="smalltxt fright button-padd" style="padding-top:3px;"><a href="javascript:;" onclick="window.location=\''.$confValues["SERVERURL"].'/tools/index.php?add=voice\';"><input type="button" class="button button-border" value="Add Voice"/></a></div>';
		}
		break;
	case 'RRHO': //Request HOroscope received
		$varSubtitle	= 'Horoscope';
		$varStatus		= '5';
		$varMsgCon		= '<p>Displayed here are all the members from whom you have received Horoscope requests.</p>';
		if($varGetCookieInfo['HOROSCOPESTATUS']==0){
			$varButton	= '<div class="smalltxt fright button-padd" style="padding-top:3px;"><a href="javascript:;" onclick="window.location=\''.$confValues["SERVERURL"].'/tools/index.php?add=horoscope\';"><input type="button" class="button button-border" value="Add Horoscope"/></a></div>';
		}
		break;
	case 'RSPO': //Request PhotO sent
		$varSubtitle	= 'Photo';
		$varStatus		= '1';
		$varMsgCont		= '<p>Displayed here are all the members to whom you have sent photo requests</p>';
		break;
	case 'RSRE': //Request REference sent
		$varSubtitle	= 'Reference';
		$varStatus		= '2';
		$varMsgCont		= '<p>Displayed here are all the members to whom you have sent reference requests</p>';
		break;
	case 'RSPH': //Request PHone sent
		$varSubtitle	= 'Phone';
		$varStatus		= '3';
		$varMsgCont		= '<p>Displayed here are all the members to whom you have sent phone requests</p>';
		break;
	case 'RSVO': //Request VOice sent
		$varSubtitle	= 'Voice';
		$varStatus		= '4';
		$varMsgCont		= '<p>Displayed here are all the members to whom you have sent voice requests</p>';
		break;
	case 'RSHO': //Request HOroscope sent
		$varSubtitle	= 'Horoscope';
		$varStatus		= '5';
		$varMsgCont		= '<p>Displayed here are all the members to whom you have sent horoscope requests</p>';
		break;

}
$varInnerTabCont= '<div style="padding: 10px 0px 0px 15px;" class="mediumtxt boldtxt clr3">'.$varSubtitle.' Request</div>';

$varWhere	   .= " AND Delete_Status=0 AND RequestFor=".$varStatus; 
$varTotalRecs	= $objRequest->numOfRecords($varTableName, 'RequestId', $varWhere);

//Get Anonymous count
$varAnonyWhere  = $varWhere." AND DisclosedMatriId=0";
$varAnTotalRecs	= $objRequest->numOfRecords($varTableName, 'RequestId', $varAnonyWhere);

//Get Viewed profiles count
if($varAnTotalRecs > 0){
$varBVCount		= ($varOption == 'RR')?($varTotalRecs-$varAnTotalRecs) : $varTotalRecs;
$varAnonyMsg	= ' (<font class="boldtxt">'.$varAnTotalRecs.'</font> anonymous  request ) ';
}else{
$varBVCount		= $varTotalRecs;
$varAnonyMsg	= '';
}

//Paging Calculation starts here
$varTotalPgs	= ($varBVCount > 0) ? ceil($varBVCount / $varNoOfRec) : 0;
$varPageNo		= ($varBVCount > 0) ? $varPageNo : 0;
if($varTotalRecs > 0){
	if($varBVCount > 0){
	if($varOption == 'RR'){
	$varWhere	   .= ' AND DisclosedMatriId=1 ORDER BY RequestDate DESC LIMIT '.$varStartRec.', '.$varNoOfRec;
	}else {
	$varWhere	   .= ' ORDER BY RequestDate DESC LIMIT '.$varStartRec.', '.$varNoOfRec;
	}
	$varArrReqDet	= $objRequest->SelectReqDetails($varTableName, $varFields, $varWhere, $varOption);
	$varOppIds		= array_unique($objRequest->arrReqIdsDet);
	$varNoOfOppIds	= count($varOppIds);

	//Basic View Related Functionality Starts Here
	$varMatriIds	= "'".join("', '", $varOppIds)."'";
	$varWhereCond	= 'WHERE MatriId IN('.$varMatriIds.')';
	$varCondition['CNT']	= $varWhereCond;
	$varCondition['LIMIT']	= $varWhereCond;

	//Get Records
	$arrResult		= $objRequest->selectDetails($varCondition, 'Y');
	
	if($varNoOfOppIds > $arrResult['TOT_CNT'])
	{
		unset($arrResult['TOT_CNT']);
		$varTotMissedIdsDet = array();
		$varMissedIds = array_diff($varOppIds, $objRequest->clsBVMatriIds);
		$varDelIds	  = "'".join("', '", $varMissedIds)."'";
		$varDelIdsDet = $objRequest->getDeletedIdsDet($varDelIds);
		
		if(count($varMissedIds) > count($objRequest->clsDelMatriIds))
		{
			$varTotMissedIds	= array_diff($varMissedIds, $objRequest->clsDelMatriIds);
						
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

	$varMsgCont .= '<br clear="all"><div class="vdotline"><div style="padding: 8px 0px 0px 15px;" class="smalltxt fleft">
	<div class="biggertxt fleft">'.$varTotalRecs.'</div><div style="padding-left: 10px;" class="smalltxt fleft">'.$varSubtitle.' requests'.$varAnonyMsg.'</div></div>'.$varButton.'</div>';

	//JSON Results
	$varJsonReq	  = json_encode($varArrReqDet);
	$varJsonBview =	json_encode($arrBVResult);
	
	//Unset Object
	$objRequest->dbClose();
	unset($objRequest);

	print $varReqOption.'#^~^#'.$varViews.'#^~^#'.$varBVCount.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/request/requestall_ctrl.php#^~^#'. $varJsonBview.'#^~^#'.$varJsonReq.'#^~^#'.$varTabCont.'#^~^#'.$varInnerTabCont.'#^~^#'.$varMsgCont;
	}else{
	$varMsgCont .= '<br clear="all"><div class="vdotline"><div style="padding: 8px 0px 0px 15px;" class="smalltxt fleft">
	<div class="biggertxt fleft">'.$varTotalRecs.'</div><div style="padding-left: 10px;" class="smalltxt fleft">'.$varSubtitle.' requests'.$varAnonyMsg.'</div></div>'.$varButton.'</div>';
	print $varReqOption.'#^~^#1#^~^#0#^~^#0#^~^#0#^~^#/request/requestall_ctrl.php#^~^##^~^##^~^#'.$varTabCont.'#^~^#'. $varInnerTabCont.'#^~^#'.$varMsgCont;
	}
}
else
{
	$varMsgCont = '<font class="boldtxt">&nbsp;&nbsp;&nbsp;Currently there are no requests in this folder.</font>';
	print $varReqOption.'#^~^#1#^~^#0#^~^#0#^~^#0#^~^#/request/requestall_ctrl.php#^~^##^~^##^~^#'.$varTabCont.'#^~^#'. $varInnerTabCont.'#^~^#'.$varMsgCont;
}
} else{ print '0';}
?>