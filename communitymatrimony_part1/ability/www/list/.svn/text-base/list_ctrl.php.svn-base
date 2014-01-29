<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/lib/clsLists.php');

//Variable Decleration
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPP			= $_COOKIE['partnerInfo'];

if($sessMatriId != ''){
$varListOption	= $_REQUEST['tabId']!='' ? $_REQUEST['tabId'] : 'SL';

//Basic view variables
$varRightIcon	= 'Y';
$varViews		= $_REQUEST['view']!='' ? $_REQUEST['view'] : 1;
$varPageNo		= $_REQUEST['Page'] != '' ? $_REQUEST['Page'] : 1;
$varNoOfRec		= $varViews*10;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;

//Object Decleration
$objLists	= new Lists();

//Connect DB
$objLists->dbConnect('S', $varDbInfo['DATABASE']);

$objLists->clsSessMatriId		= $sessMatriId;
$objLists->clsSessPartnerPref	= $sessPP;

//Get Interest Related Info
switch($varListOption)
{
	case 'SL':
		$varListTxt		= 'Favorites';
		$varTableName	= $varTable['BOOKMARKINFO'];
		break;
	case 'IG':
		$varListTxt		= 'Ignore';
		$varTableName	= $varTable['IGNOREINFO'];
		break;
	case 'BK':
		$varListTxt		= 'Block';
		$varTableName	= $varTable['BLOCKINFO'];
		break;
}


$varWhere		= "WHERE MatriId=".$objLists->doEscapeString($sessMatriId,$objLists);
$varTotalRecs	= $objLists->numOfRecords($varTableName, 'MatriId', $varWhere);

//Paging Calculation starts here
$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

if($varTotalRecs > 0)
{
	$varWhere	   .= ' ORDER BY Date_Updated DESC LIMIT '.$varStartRec.', '.$varNoOfRec;
	$varArrListDet	= $objLists->SelectListDetails($varTableName, $varWhere);
	$varOppIds		= array_unique($objLists->arrListIdsDet);
	$varNoOfOppIds	= count($varOppIds);
	
	//Basic View Related Functionality Starts Here
	$varMatriIds	= "'".join("', '", $varOppIds)."'";
	$varWhereCond	= 'WHERE MatriId IN('.$varMatriIds.')';
	$varCondition['CNT']	= $varWhereCond;
	$varCondition['LIMIT']	= $varWhereCond;

	//Get Records
	$arrBVResult	= $objLists->selectDetails($varCondition, 'Y');
	
	if($varNoOfOppIds > $arrBVResult['TOT_CNT'])
	{
		unset($arrBVResult['TOT_CNT']);
		$varTotMissedIdsDet = array();
		$varMissedIds = array_diff($varOppIds, $objLists->clsBVMatriIds);
		$varDelIds	  = "'".join("', '", $varMissedIds)."'";
		$varDelIdsDet = $objLists->getDeletedIdsDet($varDelIds);
		
		if(count($varMissedIds) > count($objLists->clsDelMatriIds))
		{
			$varTotMissedIds	= array_diff($varMissedIds, $objLists->clsDelMatriIds);
						
			foreach($varTotMissedIds as $singVal)
			{
				$varTotMissedIdsDet[$singVal]['PU'] = 'TD';
			}
		}
		$arrMergedIds1 = array_merge($varDelIdsDet, $varTotMissedIdsDet);
		$arrMergedIds2 = array_merge($arrMergedIds1, $arrBVResult);
		$arrBVResult   = $arrMergedIds2;
	}
	else{	unset($arrBVResult['TOT_CNT']); }

	//FRAMING BASIC VIEW
	$varBviewHTML	= '';
	$varListsCnt	= count($varArrListDet);
	for($i=0; $i<$varListsCnt; $i++)
	{
		$varCurrOppId	= $varArrListDet[$i]['OID'];
		$varCurrMsgDet	= $varArrListDet[$i]['Com'];
		$varCurrDtRecv	= $varArrListDet[$i]['DU'];
		$arrCurrBVDet	= $arrBVResult[$varCurrOppId];

		$varListMsg		= substr($varCurrMsgDet, 0, 67).' ...';
		
		if($arrCurrBVDet['PU'] == 1){
			//PROFILE DIV
			$arrProfDet		= split('\^~\^', urldecode($arrCurrBVDet['DE']));
			$varProfCity	= ($arrProfDet[12]=='') ? '' : '&nbsp;|&nbsp;'.$arrProfDet[12];
			$varProfSubcaste= ($arrProfDet[9]=='') ? '' : '&nbsp;|&nbsp;'.$arrProfDet[9];
			$varProfDiv		= '<div id="msgdiv" class="smalltxt clr fleft"><font class="bld">'.$varListTxt.' from</font> <font class="clr1 bld">'.$arrCurrBVDet['ID'].'</font> '.$arrProfDet[0].' yrs, '.$arrProfDet[1].$varProfSubcaste.$varProfCity.'</div>';

			//PHOTO DIV
			if($arrCurrBVDet['PH'] == ''){
				$varPhImgName	= ($arrCurrBVDet['G'] == 1) ? 'noimg50_m.gif' : 'noimg50_f.gif';
				$varPhotoURL	= $confValues['IMGSURL'].'/'.$varPhImgName;
			}else if($arrCurrBVDet['PH'] == 'P'){
				$varPhotoURL	= $confValues['IMGSURL'].'/img50_pro.gif';
			}else if($arrCurrBVDet['PH'] != ''){
				$varPhotosDet	= split('\^', $arrCurrBVDet['PH']);
				$varPhotoURL	= $confValues['PHOTOURL'].'/'.$varCurrOppId{3}.'/'.$varCurrOppId{4}.'/'.$varPhotosDet[0];
			}
		}else{
			if($arrCurrBVDet['PU'] == 2)
			$varProfDiv		= '<div id="msgdiv" class="smalltxt clr fleft"><font class="bld">'.$varListTxt.' from</font> <font class="clr1 bld">'.$arrCurrBVDet['ID'].'</font> '.$arrProfDet[0].' yrs, '.$arrProfDet[1].$varProfSubcaste.$varProfCity.'</div>';
			else if($arrCurrBVDet['PU'] == 'D')
			$varProfDiv		= '<div id="msgdiv" class="smalltxt clr fleft">This profile <font class="clr1 bld">'.$arrCurrBVDet['ID'].'</font> is currently deleted</div>';
			else if($arrCurrBVDet['PU'] == 'TD')
			$varProfDiv		= '<div id="msgdiv" class="smalltxt clr fleft">This profile is currently not available</div>';
		}

		$varCasNoCont	= ($arrProfDet[15] == 1)? '(CasteNoBar)' : '';
		$varSubCasNoCont= ($arrProfDet[17] == 1)? '(SubcasteNoBar)' : '';
		$varReliCont	= ($arrProfDet[7] !='') ? $arrProfDet[7] : '';
		$varCasteCont	= ($arrProfDet[8] !='') ? (($varReliCont !='') ? $varReliCont.', '.$arrProfDet[8].$varCasNoCont : $arrProfDet[8].$varCasNoCont) : $varReliCont;
		$varSubCont		= ($arrProfDet[9] !='') ? (($varCasteCont!='') ? $varCasteCont.', '.$arrProfDet[9].$varSubCasNoCont : $arrProfDet[9].$varSubCasNoCont) : $varCasteCont;
		$varSubCont		= ($varSubCont !='') ? '<font class="clr2">|</font>'.$varSubCont : '';
		
		//location related info
		$varCtry		= $arrProfDet[10];
		$varCtryStat	= ($varCtry != '' && $arrProfDet[11] !='' && $arrProfDet[11] !='0') ? $arrProfDet[11].', '.$varCtry : $varCtry;
		$varCityStatCity= ($varCtry != '' && $arrProfDet[12] !='' && $arrProfDet[12] !='0') ? $arrProfDet[12].', '.$varCtryStat : $varCtryStat;

		//edu & occu related info
		$varEduDet	  = ($arrProfDet[3]!='Others' && $arrProfDet[3]!='') ? '<font class="clr2">|</font> '.$arrProfDet[3] : (($arrProfDet[4] !='')? '<font class="clr2">|</font> '.$arrProfDet[4] : '');

		//print $arrProfDet[3];exit;

		$varOccuDet	  = ($arrProfDet[5]!='Others' && $arrProfDet[5]!='') ? '<font class="clr2">|</font> '.$arrProfDet[5] : (($arrProfDet[6] !='')? ' <font class="clr2">|</font> '.$arrProfDet[6] : '');
		$varStarVal	  = $arrProfDet[16]==''?'':$arrProfDet[16].', ';

		$varPhotoCont	= '<img height="50" width="50" alt="" src="'.$varPhotoURL.'"/>';
		$varProfCont	= $arrProfDet[0].' yrs, '.$arrProfDet[1].$varSubCont.'<font class="clr2">|</font>'.$varStarVal.$varCityStatCity.' '.$varEduDet.' '.$varOccuDet;

		$varBviewHTML  .= '
			<div class="normdiv">
				<div id="cont'.$i.'" onmouseover="this.className=\'hoverdiv\';" onmouseout="this.className=\'\';">
					<div class="fleft padtb15" id="checkdiv"><input type="checkbox" name="chk_li" value="'.$arrCurrBVDet['ID'].'"/></div>
					<div onclick="javascript:getViewProfile(\''.$arrCurrBVDet['ID'].'\', \''.$i.'\', \'\', \'\',\'\')" style="border-bottom: 1px solid rgb(203, 203, 203);" class="fleft padtb15" id="mesgdiv">
						<div class="fleft" id="vpdiv1">
							<div class="normtxt clr fleft bld padb10" id="vpdiv3">'.urldecode($arrCurrBVDet['N']).' ('.$arrCurrBVDet['ID'].')</div>
							<div class="smalltxt clr2 fleft" id="infdiv1">'.$objLists->getDaysTextInfo($varCurrDtRecv).'</div><br clear="all"/>
							<div class="normtxt clr lh16" id="vpdiv4">'.$varProfCont.'</div>
						</div>
						<div class="fleft" id="vpdiv2">
						<div id="smphdiv1">'.$varPhotoCont.'</div>
						</div>
					</div>
					<div class="cleard"></div>
				</div>
				<div id="viewpro'.$i.'"></div>
			</div><div class="cleard"></div>';
	}

	//Unset Object
	$objLists->dbClose();
	unset($objLists);

	print $varListOption.'#^~^#'.$varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/list/list_ctrl.php#^~^#'. $varBviewHTML.'#^~^#'.$varMsgCont;
}
else
{
	print $varListOption.'#^~^#1#^~^#0#^~^#0#^~^#0#^~^#/list/list_ctrl.php#^~^##^~^#';
}
} else { print '0';}
?>