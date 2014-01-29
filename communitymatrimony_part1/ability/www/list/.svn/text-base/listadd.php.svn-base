<?php
//Base Path
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

// Include the files
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once $varRootBasePath."/conf/dbinfo.cil14";
include_once $varRootBasePath."/lib/clsDB.php";
include_once($varRootBasePath.'/lib/clsCommon.php');

//Variable Declaration
$varSessionId	= $varGetCookieInfo['MATRIID'];
$varSessGender	= $varGetCookieInfo['GENDER'];
$varSessValStat	= $varGetCookieInfo['PUBLISH'];
$varSessPdStat	= $varGetCookieInfo['PAIDSTATUS'];

$sessPhotoStatus = $varGetCookieInfo['PHOTOSTATUS'];
$sessPhoneStatus = $varGetCookieInfo['PHONEVERIFIED'];

/*$varAlertMsg	= '';
if($sessPhoneStatus == 0){
	$varAlertMsg = 'verify your phone number';
}
if($sessPhotoStatus == 0){
	$varInnCont	  = $varAlertMsg=='' ? '' : ' and  ';
	$varAlertMsg .= $varInnCont.'upload your photograph';
}*/

//Object Declaration
$objSlaveDb		= new DB;
$objMasterDb	= new DB;
$objCommon		= new clsCommon;
$objMasterDb->dbConnect('M', $varDbInfo['DATABASE']);
$objSlaveDb->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varMemberId	= $_REQUEST["id"];
$varPurpose		= $_REQUEST["purp"];
$varDivNo		= $_REQUEST["divno"];
$varThruSrch	= $_REQUEST['thrusearch'];
$arrMemberId	= split('~+',trim($varMemberId,'~'));
$varAllMemberIds= "'".join($arrMemberId,"','")."'";
$varMemTable	= $varTable['MEMBERINFO'];
$varDispMsg		= '';
$varAlertMsg=$objCommon->getPhoneNumberValidationStatus($sessPhoneStatus,$sessPaidStatus);
function countList($varTotCnt) {
	global $varPurpose,$varSessPdStat,$confValues,$varAlertMsg;
	$varReturn	= '';	

	if($varPurpose=='shortlist' && $varSessPdStat==0 && $varTotCnt > $confValues['FMSHORTLISTCNT']) {
		$varReturn = 'Sorry1! You can add a maximum of '.$confValues['FMSHORTLISTCNT'].' profiles to your favourite list. To add more profiles, '.$varAlertMsg.' to your profile. <a href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=primaryinfo" target="_blank" class="clr1">Click here to add details</a>';
	} elseif($varPurpose=='shortlist' && $varSessPdStat==1 && $varTotCnt > $confValues['PMSHORTLISTCNT']) {
		$varReturn = 'You have exceeded the number of members you can favorite.';
	} elseif($varPurpose=='block' && $varSessPdStat==0 && $varTotCnt > $confValues['FMBLOCKLISTCNT']) {
		$varReturn = 'Sorry! You can block a maximum of '.$confValues['FMBLOCKLISTCNT'].' profile only. To block more profiles, '.$varAlertMsg.' to your profile. <a href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=primaryinfo" target="_blank" class="clr1">Click here to add details</a>';
	} elseif($varPurpose=='block' && $varSessPdStat==1 && $varTotCnt > $confValues['PMBLOCKLISTCNT']) {
		$varReturn = 'You have exceeded the number of members you can block.';
	}
	return $varReturn;
}

//CONTROL STATEMENT
if ($varSessionId == "") { $varDispMsg = 'Your session has expired or you have logged out. <br>Please <a href="'.$confValues['SERVERURL'].'/login/"  class="clr1">Click here</a> to login again.'; }//if
elseif($varSessValStat==0 || $varSessValStat=="") { $varDispMsg = 'Sorry, as your profile is under validation, you will not be able to use this feature. It may take 24 hours for validating your profile. However if you become a paid member right away you can use this feature.'; }
elseif($varSessValStat==3 || $varSessValStat==4) { $varDispTxt = ($varSessValStat==3)? 'suspended': 'rejected';$varDispMsg = 'Sorry, as your profile is '.$varDispTxt.', you will not be able to use this feature.'; }
else {
	$varMemFields	= array('Nick_Name','Gender','Name');
	$varMemCondtn	= " WHERE MatriId IN($varAllMemberIds)";
	$varMemInf		= $objSlaveDb->select($varMemTable,$varMemFields,$varMemCondtn,1);
	$varOppGender	= $varMemInf[0]['Gender'];
	$varMemName		= $varMemInf[0]['Nick_Name'] ? $varMemInf[0]['Nick_Name'] : $varMemInf[0]['Name'];
	if($varSessGender==$varOppGender) { $varDispMsg = 'Sorry, you can '.$varPurpose.' profiles of the opposite gender only.'; }
	elseif($varMemName==""){ $varDispMsg = 'Sorry, <b>this profile </b>&nbsp; cannot be found.'; }
}

if($varDispMsg==""){ 
	switch($varPurpose){
		case 'shortlist':
			$varFields		= array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Date_Updated');
			$varTblName		= $varTable['BOOKMARKINFO'];$varListField='Bookmarked';break;
		case 'ignore':
			$varFields		= array('MatriId', 'Opposite_MatriId', 'Ignored', 'Date_Updated');
			$varTblName		= $varTable['IGNOREINFO'];break;
		case 'block':
			$varFields		= array('MatriId', 'Opposite_MatriId', 'Blocked', 'Date_Updated');
			$varTblName		= $varTable['BLOCKINFO'];$varListField='Blocked';break;
	}

	//$varAlreadyCondition	= " WHERE MatriId='".$varSessionId."' AND Opposite_MatriId IN (".$varAllMemberIds.") AND ".$varListField."=1";
	$varAlreadyCondition	= " WHERE MatriId=".$objSlaveDb->doEscapeString($varSessionId,$objSlaveDb)." AND ".$varListField."=1";
	$varAlreadyFields		= array('Opposite_MatriId');
	$varSelAlreadyProfile	= $objSlaveDb->select($varTblName,$varAlreadyFields,$varAlreadyCondition,1);
	$arrAlreadyListed		= array();
	foreach($varSelAlreadyProfile as $key=>$res) {
		$arrAlreadyListed[$key]=$varSelAlreadyProfile[$key]['Opposite_MatriId'];
	}

	//print_r($arrMemberId);
	//print_r($arrAlreadyListed);
	$arrToBeList	= array_diff($arrMemberId,$arrAlreadyListed);
	$varTotalListCnt= sizeof($arrAlreadyListed) + sizeof($arrToBeList);

	//checking alloted count exit or ot
	$varDispMsg = countList($varTotalListCnt);

	if($varDispMsg =='' ) {
		foreach($arrToBeList as $varSingleId) {
			if($varSingleId != '') {
				$varFieldsVal	= array($objMasterDb->doEscapeString($varSessionId,$objMasterDb), "'".$varSingleId."'", 1, 'NOW()');
				if($_COOKIE['rmusername']){
					$AppendRmuser = array('RM_UserId');
					$AppendRmuserVal = array("'".$_COOKIE['rmusername']."'");
					$FinalvarUpdateFields = array_merge($varFields,$AppendRmuser);
					$FinalvarUpdateVal    = array_merge($varFieldsVal,$AppendRmuserVal);
					$objMasterDb->insert($varTblName, $FinalvarUpdateFields, $FinalvarUpdateVal);
			    }else{
					$objMasterDb->insert($varTblName, $varFields, $varFieldsVal);
				}
				$objMasterDb->insertOnDuplicate($varTable['MEMBERACTIONINFO'], $varFields, $varFieldsVal,"");
			}
		}

		$varAlreadyListStr	= join(array_diff($arrMemberId,$arrToBeList),", ");
		$varAddedListedStr	= join($arrToBeList,", ");
		
		if($varAlreadyListStr != '') {
			$varDispMsg	.= "<b>".$varAlreadyListStr."</b> already in ".$varPurpose." list";
		}
		if($varAddedListedStr != '') {
			$varListedMsg	= "<b>".$varAddedListedStr."</b> added to ".$varPurpose." list";
			$varDispMsg	   .= ($varDispMsg=='')?$varListedMsg:'<BR><BR>'.$varListedMsg;
		}
		$varDispMsg	.= '^yes^';
	}
}

if($varThruSrch == 1) {
	echo "<div class='fright tlright'><img src='".$confValues['IMGSURL']."/close.gif' class='pntr' onclick='hidediv(\"listalldiv\")'/></div><br clear='all'>".$varDispMsg."<br clear='all'><div class='fright'><input type='button' class='button' value='Close' onClick='hidediv(\"listalldiv\")'></div>";
} else {
	echo "<div class='fright tlright'><img src='".$confValues['IMGSURL']."/close.gif' class='pntr' onclick='hide_box_div(\"div_box$varDivNo\");'/></div><br clear='all'>".$varDispMsg."<br clear='all'><div class='fright'><input type='button' class='button' value='Close' onClick='hide_box_div(\"div_box$varDivNo\");'></div>";
}
//echo $varDispMsg;

//UNSET OBJECT
$objMasterDb->dbClose();
$objSlaveDb->dbClose();
unset($objMasterDb);
unset($objSlaveDb);
?>