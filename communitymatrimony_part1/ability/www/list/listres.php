<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 21 Aug 2008
# End Date		: 21 Aug 2008
# Project		: MatrimonyProduct
# Module		: Lists - Result
#=============================================================================================================
//Base Path
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

// Include the files
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//Variable Declaration
$varSessionId	= $varGetCookieInfo['MATRIID'];
$varSessGender	= $varGetCookieInfo['GENDER'];
$varSessValStat	= $varGetCookieInfo['PUBLISH'];
$varSessPdStat	= $varGetCookieInfo['PAIDSTATUS'];
$varDisplayMsg	= "";

//Object Declaration
$objDb			= new DB();
$objDb1			= new DB();
$objDb->dbConnect('S', $varDbInfo['DATABASE']);
$objDb1->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varMemberId	= $_REQUEST["id"];
$varCurrentDate	= date('Y-m-d H:i:s');
$varPurpose		= $_REQUEST["purp"];
$varUserName	= $_REQUEST['oppUser'];
$varComments	= $_REQUEST["Comments"];
$varMemName		= $_REQUEST['oppNam'];
$varDispMessage = "";
$varMemActTab	= $varTable['MEMBERACTIONINFO'];
$varListTab		= ($varPurpose=='shortlist')?$varTable['BOOKMARKINFO']:(($varPurpose=='block')?$varTable['BLOCKINFO']:$varTable['IGNOREINFO']);
$varAdd			= 0;
$varCond		= " MatriId=".$objDb1->doEscapeString($varSessionId,$objDb1)." AND Opposite_MatriId='".$varMemberId."'";
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
//CONTROL STATEMENT
if ($_REQUEST["delc"]==1)
{
	$varTableList = ($varPurpose=='shortlist')?'Shortlist.':(($varPurpose=='block')?'Blocked List.':'Ignore List.');
	$varDispMessage	= 'Are you sure you want to delete this member from '.$varTableList;
}
if ($_REQUEST["but"]=="del")
{
	//DELETE FROM ignoreinfo
	$varTableList = ($varPurpose=='shortlist')?'Shortlist.':(($varPurpose=='block')?'Blocked List.':'Ignore List.');
	$objDb1->delete($varListTab,$varCond);

	//UPDATE INTO memberactioninfo
	$varUnsetField		= ($varPurpose=='shortlist')?'Bookmarked':(($varPurpose=='block')?'Blocked':'Ignored');
	$varSetFields			= array($varUnsetField);
	$varSetFieldsVal	= array(0);
	$objDb1->update($varMemActTab, $varSetFields, $varSetFieldsVal, $varCond);
	$varDispMessage	= '<b>'.$varMemName.'</b> &nbsp;('.$varUserName.')&nbsp;has been successfully deleted from your '.$varTableList ;$varAdd=0;
}
if ($_REQUEST["bkedit"]=="yes")
{
	//UPDATE INTO memberactioninfo
	$varSetFields			= array('Comments','Date_Updated');
	$varSetFieldsVal	= array("'".addslashes($varComments)."'","'".$varCurrentDate."'");
	$objDb1->update($varListTab, $varSetFields, $varSetFieldsVal, $varCond);
	$varDispMessage	= '<b>'.$varMemName.'</b> &nbsp;('.$varUserName.')&nbsp;has been successfully updated.';$varAdd=1;
}
if ($_REQUEST["action"]=="delete")
{
	//DELETE FROM ignoreinfo
	$varDelTab			= ($varPurpose=='shortlist')?$varTable['IGNOREINFO']:$varTable['BOOKMARKINFO'];
	$objDb1->delete($varDelTab,$varCond);

	//UPDATE INTO memberactioninfo
	$varSetFields			= array('Ignored','Bookmarked');
	if($varPurpose=='shortlist') { $varSetFieldsVal	= array(0,1); } else { $varSetFieldsVal	= array(1,0); }
	$objDb1->update($varMemActTab, $varSetFields, $varSetFieldsVal, $varCond);
	$varCnt = countList();
	if($varCnt !='') { $varDispMessage = $varCnt;$varAdd=0; } else { $varDispMessage = executeQry();$varAdd=1; }
}
if($_REQUEST["bksub"] == "yes")
{
	if($varPurpose!='block') {
		$varActFields		= array('Bookmarked','Ignored');
		$varActCondtn		= " WHERE MatriId=".$objDb1->doEscapeString($varSessionId,$objDb1)." AND Opposite_MatriId='".$varMemberId."'";
		$varActInf			= $objDb->select($varMemActTab,$varActFields,$varActCondtn,1);
		if($varActInf[0]['Ignored']==1) {
			if($varPurpose=='shortlist') {
			$varDispMessage = 'Sorry, to shortlist this member you must first remove member from your Ignore List. <a href="javascript:void(0);" onClick="delList()" class="clr1">Click here</a> to delete from the Ignore List and add into Shortlist.'; $varAdd=0;
			} else { $varDispMessage = '<b>'.$varUserName.'</b> is already available in Ignore List.';$varAdd=0; }
		}
		elseif($varActInf[0]['Bookmarked']==1) {
			if($varPurpose=='shortlist') { $varDispMessage = '<b>'.$varUserName.'</b> is already available in Shortlist.';$varAdd=0; }
			else { $varDispMessage = 'Sorry, to ignore this member you must first remove member from your shortlist. <a href="javascript:void(0);" onClick="delList()" class="clr1">Click here</a> to delete from the Shortlist and add into Ignore List.';$varAdd=0; }
		}
		else { $varCnt = countList();if($varCnt !='') { $varDispMessage = $varCnt;$varAdd=0; } else { $varDispMessage = executeQry();$varAdd=1; } }
	} else { $varCnt = countList();if($varCnt !='') { $varDispMessage = $varCnt;$varAdd=0; } else { $varDispMessage = executeQry();$varAdd=1; } }
}//if
function countList() {
	global $objDb,$varSessionId,$varMemberId,$varListTab,$varPurpose,$varSessPdStat;
	$varReturn = '';
	$varCntCond		= " WHERE MatriId=".$objDb1->doEscapeString($varSessionId,$objDb1);
	$varListCnt		= $objDb->numOfRecords($varListTab,'MatriId',$varCntCond);
	if($varPurpose=='shortlist' && $varSessPdStat==0 && $varListCnt >=50) {
		$varReturn = 'Sorry, as a free member you can shortlist a maximum of 50 profiles only. To shortlist more profiles, become a paid member right away.<a href="../payment" target="_blank" class="clr1">Click here </a> to upgrade to paid membership.';
	} elseif($varPurpose=='shortlist' && $varSessPdStat==1 && $varListCnt >=1000) {
		$varReturn = 'You have exceeded the number of members you can shortlist.';
	} elseif($varPurpose=='ignore' && $varSessPdStat==0 && $varListCnt >=50) {
		$varReturn = 'Sorry, as a free member you can ignore a maximum of 50 profiles only. To ignore more profiles, become a paid member right away.<a href="../payment" target="_blank" class="clr1">Click here </a> to upgrade to paid membership.';
	} elseif($varPurpose=='ignore' && $varSessPdStat==1 && $varListCnt >=1000) {
		$varReturn = 'You have exceeded the number of members you can ignore.';
	} elseif($varPurpose=='block' && $varSessPdStat==1 && $varListCnt >=1000) {
		$varReturn = 'You have exceeded the number of members you can block.';
	}
	return $varReturn;
}
function executeQry() {
	global $objDb1,$varPurpose,$varTable,$varSessionId,$varMemberId,$varCurrentDate,$varComments,$varUserName,$varMemActTab,$varListTab,$varMemName;
	$varResult				= '';
	$varPurposeField	= ($varPurpose=='shortlist')?'Bookmarked':(($varPurpose=='block')?'Blocked':'Ignored');
	$varListFields 		= array('MatriId','Opposite_MatriId',$varPurposeField,'Comments','Date_Updated');
	$varMemActFlds	= array('MatriId','Opposite_MatriId',$varPurposeField,'Date_Updated');
	$varListFieldsVal	= array($objDb1->doEscapeString($varSessionId,$objDb1),"'".$varMemberId."'",1,"'".addslashes($varComments)."'","'".$varCurrentDate."'");
	$objDb1->insert($varListTab,$varListFields,$varListFieldsVal);

	$varMemActVals	= array($objDb1->doEscapeString($varSessionId,$objDb1),"'".$varMemberId."'",1,"'".$varCurrentDate."'");
	$objDb1->insertOnDuplicate($varMemActTab, $varMemActFlds, $varMemActVals, 'MatriId');
	$varResult				= '<b>'.$varMemName.'</b> &nbsp;('.$varUserName.')&nbsp;has been successfully added to your  ';
	if($varPurpose=='shortlist') { $varResult.= 'Shortlist.'; }elseif($varPurpose=='block') { $varResult.= 'Blocked List.'; } else { $varResult.= 'Ignore List.'; }
	return $varResult;
}

$objDb->dbClose();
$objDb1->dbClose();
unset($objDb);
unset($objDb1);

$varHeading		= ($varPurpose=='shortlist')?'Shortlisted':(($varPurpose=='block')?'Blocked':'Ignored');
if($_REQUEST["delc"]!=1) {
?>
<div id="useracticons"><div id="useracticonsimgs">
	<div class='mediumtxt boldtxt clr3'><div style="width:115px;float:left">Member <?=$varHeading?></div> <div style="float:left" class="useracticonsimgs <?=$varPurpose?>"></div></div><br clear="all">
	<div style="width:392px !important;width:384px;"><div style="padding:10px;" class="divborder"><?=$varDispMessage?></div><div style="padding:10px 0px 0px 0px;float:right;"><input type="button" name="Button" value="Close" class="button" onClick="parent.closeIframe('iframeicon','icondiv');if(<?=$varAdd?>==1) { showicon('<?=$varMemberId?>','<?=$varPurpose?>'); } else { hideicon('<?=$varMemberId?>','<?=$varPurpose?>'); }"></div></div>
</div></div>
<? } else { ?>
<div>
	<div class='mediumtxt boldtxt clr3'>Delete <?=$varMemName?> (<?=$varUserName?>) from <?=$varTableList?></div><br clear="all">
	<div style="border: 1px solid #ccc;width:392px"><div style="padding:5px;"><?=$varDispMessage?></div></div><div style="padding:10px 0px 0px 0px;float:right;"><input type="button" name="Button" value="Yes" class="button" onClick="deleteList('<?=$varMemberId?>','<?=$varPurpose?>','<?=$varMemName?>','<?=$varUserName?>');">&nbsp;<input type="button" name="Button" value="No" class="button" onClick="parent.closeIframe('iframeicon','icondiv');"></div>
</div>

<? } ?>