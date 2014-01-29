<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/conf/productvars.cil14');
include_once($varBaseRoot.'/lib/clsRequest.php');

//Variable Decleration
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessPP				= $_COOKIE["partnerInfo"];

if($sessMatriId != ''){
$varRequestOption	= $_REQUEST['tabId']!='' ? $_REQUEST['tabId'] : 'RR';

//OBJECT DECLERATION
$objRequest	= new Request();

//CONNECT DB
$objRequest->dbConnect('S', $varDbInfo['DATABASE']);

$objRequest->clsSessMatriId		= $sessMatriId;
$objRequest->clsSessPartnerPref	= $sessPP;

//Get Request Related Info
$varRecMsg  = '';
$varSentMsg = '';
switch($varRequestOption)
{
	case 'RR': //Request Received
			$varFields		= array('RequestFor','COUNT(RequestId) AS CNT');
			$varWhere		= "WHERE ReceiverId=".$objRequest->doEscapeString($sessMatriId,$objRequest)." AND Delete_Status=0"; 
			$varOrderBy		= 'RequestFor';
			$varTabId		= $arrRequestReceivedTab;
			$varTableName	= $varTable['REQUESTINFORECEIVED'];
			$varTitle		= 'All the requests you have received are displayed below. This is a sign that members are interested in your profile and want to know you better.';
			$varRecMsg		= ' members have requested you to add';break;
	
	case 'RS': //Request Sent
			$varFields		= array('RequestFor','COUNT(RequestId) AS CNT');
			$varWhere		= "WHERE SenderId=".$objRequest->doEscapeString($sessMatriId,$objRequest)." AND Delete_Status=0"; 
			$varOrderBy		= 'RequestFor';
			$varTabId		= $arrRequestSentTab;
			$varTableName	= $varTable['REQUESTINFOSENT'];
			$varTitle		= 'All the requests you have sent are displayed below. You will be intimated through e-mail when members add the details you have requested.';
			$varSentMsg		= ' Requests';break;
}
$varTotalRecs	= $objRequest->numOfRecords($varTableName, 'RequestId', $varWhere);
$varMessage = '<div style="float: left; width: 508px; display: block;" id="sectab_content_1"><div style="padding: 15px 15px 0px; float: left;" id="overalldiv">';
if ($varTotalRecs >0) {
	$varWhere		.= " GROUP BY RequestFor ORDER BY RequestFor ASC";
	$varRequestExecute	= $objRequest->select($varTableName, $varFields, $varWhere, 0);


	$arrMemberInfoFlag		= array(1=>$varGetCookieInfo["PHOTOSTATUS"],2=>$varGetCookieInfo["REFERENCESTATUS"],3=>$varGetCookieInfo["PHONEVERIFIED"],4=>$varGetCookieInfo["VOICESTATUS"],5=>$varGetCookieInfo["HOROSCOPE"],6=>$varGetCookieInfo["VIDEOSTATUS"]);

	while($varRequestInfo	= mysql_fetch_array($varRequestExecute)) {
		$varRequestFor		= $varRequestInfo['RequestFor'];
		$varRequestName		= $arrRequestList[$varRequestFor];
		$varRequestCount	= $varRequestInfo['CNT'];
		$varTab				= $varTabId[$varRequestFor];

		$varMessage .= '<div class="smalltxt" style="float: left; width: 478px;" id="'.$varRequestName.'"><div style="padding: 5px 10px 5px 0pt; float: left;"><b>'.$varRequestCount.'</b>'.$varRecMsg.'<b> '.$varRequestName.'</b>'.$varSentMsg.'. <a href="'.$confValues['SERVERURL'].'/mymessages/index.php?act=msgshowall&A=Y&tabId='.$varTab.'" class="smalltxt clr1">More &gt;&gt;</a></div>';
		
		if($varRequestOption == 'RR'){
		if ($arrMemberInfoFlag[$varRequestFor]==0) {
			if($varRequestName == 'Phone'){
			$varMessage .= "<div style=\"padding: 5px; float: right;\"><a href=\"".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=contactedit&inview=2\" class=\"smalltxt clr1\">Add ".$varRequestName."</a></div>";
			}else{
			$varMessage .= "<div style=\"padding: 5px; float: right;\"><a href=\"".$confValues['SERVERURL']."/tools/index.php?add=".strtolower($varRequestName)."\" class=\"smalltxt clr1\">Add ".$varRequestName."</a></div>";
			}
		} else {
			$varMessage .= "<div style=\"padding: 5px 5px 5px 0px; float: right;\"><img src=\"".$confValues["IMGSURL"]."/yes.gif\" onmouseover=\"showhint('".$varRequestName." already added',this,event,'170');\" onmouseout=\"hidetip();\" height=\"12\" width=\"15\"></div>";
		}//else
		}//if

		$varMessage .= '<div class="vdotline1" style="width: 478px;"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1" width="1"></div></div>';

	}//while

} else { $varMessage .= '<div><div class="smalltxt" style="float: left; width: 470px;"><font class="boldtxt">Currently you have no requests.</font></div></div>'; }
$varMessage .= '</div></div>';


//SUB TAB STARTS HERE - Request Received
$varTabCont	= '<div id="requestdiv"><div class="innertabbr1 fleft"></div><div class="fleft innertabbg"><div class="vc-padl fleft">';
if($varRequestOption{1} == 'R') {
	$varTabCont .= '<div style="float: left;">
					<div class="innermtabbg1 fleft"></div>
					<div class="innermtabbg2 fleft">
						<div style="padding: 5px 10px 0px 5px;" class="mediumtxt" onmouseover="showhint'."('Display all requests you \'ve received',this,event,'170');".'" onmouseout="hidetip();">Requests Received</div>
						<div style="margin-top: 5px; padding-left: 48px;"><img src="'.$confValues['IMGSURL'].'/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div>
					</div>						
					</div>';

} else {
	$varTabCont .= '<div style="float: left;">				
						<div style="padding: 5px 10px 0px;" class="mediumtxt">
							<a href="javascript:hidetip();" onmouseover="showhint'."('Display all requests you \'ve received',this,event,'170')".';" onmouseout="hidetip();" onclick="MyHomeReqCall(\'RR\');hidetip();">Requests Received</a>
						</div>
					</div>';
}

if($varRequestOption{1} == 'S') {
	$varTabCont .= '<div style="float: left;">
					<div class="innermtabbg1 fleft"></div>
					<div class="innermtabbg2 fleft">
						<div style="padding: 5px 10px 0px 5px;" class="mediumtxt" onmouseover="showhint'."('Display all requests you \'ve sent',this,event,'170');".'" onmouseout="hidetip();">Requests Sent</div>
						<div style="margin-top: 5px; padding-left: 39px;"><img src="'.$confValues['IMGSURL'].'/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div>
					</div>						
					</div>';
} else {
	$varTabCont .= '<div style="float: left;">				
						<div style="padding: 5px 10px 0px;" class="mediumtxt">
							<a href="javascript:hidetip();" onmouseover="showhint'."('Display all requests you \'ve sent',this,event,'170')".';" onmouseout="hidetip();" onclick="MyHomeReqCall(\'RS\');hidetip();">Requests Sent</a>
						</div>
					</div>';
}
$varTabCont .= '</div>
			</div>
			<div class="fleft innertabbr1"></div>
		</div>';
$varTabCont .='<div style="width: 508px;">
	<div class="fleft inntabbr2"></div>
				<div class="fleft" style="width: 506px;"><div style="padding: 0px 15px; float: left;">
			<div class="smalltxt" style="float: left; width: 470px;">'.$varTitle.'</div>
		</div>
	</div>
	<div class="fleft inntabbr2"></div></div>';


$varTabCont .= $varMessage;

$varTabCont .='<br clear="all">
<div class="fleft vc1 smalltxt" id="viewsidepart">

	<div style="float: left; width: 506px;">
		<div class="mediumtxt" style="padding: 10px 0px 0px;" id="msgtab">
		</div>
	</div>
</div>
<br clear="all">';

print $varTabCont;
}else{ print '0';}

unset($objRequest);
?>