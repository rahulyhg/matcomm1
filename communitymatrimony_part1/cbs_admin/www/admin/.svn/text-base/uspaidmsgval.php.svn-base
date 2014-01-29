<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

//OBJECT DECLARTION
$objCommon	= new clsCommon;
$objSlaveDB	= new DB;
$objMasterDB	= new DB;

//DB CONNECTION
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varCommunityCond	= "";
$varResult			= "";
$varActionValue		= $_REQUEST["actionvalue"];
$varActionType		= $_REQUEST["actiontype"];
$varUSPaidMsgVal	= $_REQUEST["uspaidmsgvalue"];
$varMatriId			= $_REQUEST["matriid"];
$varDomain			= $_REQUEST["domain"];
if($varDomain!='') {
	$arrRevMatriIdPre	= array_flip($arrMatriIdPre);
	$varCommunityId		= $arrRevMatriIdPre[$varDomain];
}


if($varActionValue == "yes") {
	if($varActionType == 1) {
		$argFields 				= array('Status');
		$argFieldsValues		= array(0);
		$argUpdCondition		= "Opposite_MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB)." AND Status=2";
		$varUpdateId			= $objMasterDB->update($varTable['MAILPENDINGINFO'],$argFields,$argFieldsValues,$argUpdCondition);

		//update in memberinfo
		$argFields 				= array('US_Paid_Validated');
		$argFieldsValues		= array(0);
		$argUpdCondition		= "MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		$varUpdateId			= $objMasterDB->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argUpdCondition);
	} else if($varActionType == 2) {
		//delete all messages
		$argDelCondition		= "Opposite_MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB)." AND Status=2";
		$varDeletedId			= $objMasterDB->delete($varTable['MAILPENDINGINFO'],$argDelCondition);

		//get count from mail sentinfo
		$argDelCondition		= "MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		$varDeletedId			= $objMasterDB->delete($varTable['MAILSENTINFO'],$argDelCondition);

		//update in memberstatistics
		$argFields 				= array('Mail_UnRead_Sent');
		$argFieldsValues		= array('Mail_UnRead_Sent-'.$varDeletedId);
		$argUpdCondition		= "MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		$varUpdateId			= $objMasterDB->update($varTable['MEMBERSTATISTICS'],$argFields,$argFieldsValues,$argUpdCondition);
	} 
}

if($varUSPaidMsgVal=="yes") {
	if($varCommunityId!='') {
		$varCommunityCond = "CommunityId=".$varCommunityId." AND";
	}
	$varCondition		= " WHERE ".$varCommunityCond." US_Paid_Validated=1 AND Number_Of_Payments=1";
	$varNoOfTimeRecords	= $objSlaveDB->numOfRecords($varTable["MEMBERINFO"], $varPrimary='MatriId', $varCondition);

	if($varNoOfTimeRecords>0) {
		//get all matriids
		$varCondition		= " WHERE ".$varCommunityCond." US_Paid_Validated=1 AND Number_Of_Payments=1";
		$varFields			= array('MatriId');
		$varSelMatriIdRes	= $objSlaveDB->select($varTable['MEMBERINFO'],$varFields,$varCondition,0);
		while($varSelMatriId= mysql_fetch_assoc($varSelMatriIdRes)) {
			$arrMatriIds[]	= $varSelMatriId['MatriId'];
		}

		//get no of pending msg 
		$varJoinedIds		= "'".implode($arrMatriIds,"','")."'";
		$varCondition		= " WHERE Opposite_MatriId IN (".$varJoinedIds.") AND Status=2";
		$varNoOfRecords		= $objSlaveDB->numOfRecords($varTable["MAILPENDINGINFO"], $varPrimary='MatriId', $varCondition);

		if($varNoOfRecords>0) {
			//get all pendinf messages
			$varCondition		= " WHERE Opposite_MatriId IN (".$varJoinedIds.") AND Status=2";
			$varFields			= array('Mail_Id','MatriId','Opposite_MatriId','Mail_Message','Date_Updated');
			$varSelAllPendngMsgs= $objSlaveDB->select($varTable['MAILPENDINGINFO'],$varFields,$varCondition,0);
			
		} else {
			$varResult			= "No pending messages available for this community";
		}

	} else {
		$varResult			= "No Records found for this community";
	}
}

$varTotCondition	= " WHERE Status=2";
$varTotNoOfRecords	= $objSlaveDB->numOfRecords($varTable["MAILPENDINGINFO"], $varPrimary='MatriId', $varTotCondition);
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title> new document </title>
<meta name="generator" content="editplus">
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="description" content="">
</head>

<body>
	<form method="post" name="uspaidmsg">
	<input type="hidden" name="act" value="uspaidmsgval">
	<input type="hidden" name="uspaidmsgvalue" value="">
	<input type="hidden" name="actionvalue" value="">
	<input type="hidden" name="actiontype" value="">
	<input type="hidden" name="matriid" value="">
	<table border=0 cellpadding=0 cellspacing=0 width="540">
		<tr><td class="heading" colspan="5" align="center">NRI Message Validation</td></tr>
		<tr><td colspan="5">&nbsp;</td></tr>
		<tr><td class="mediumtxt boldtxt" colspan="5" align="center">
				<a class="clr1" href="#" onClick="validateTotMsg();">Total messages sent</a> : <?=$varTotNoOfRecords?>
		</td></tr>
		<tr><td colspan="5">&nbsp;</td></tr>
		<tr><td class="mediumtxt boldtxt" colspan="5" align="center">
				select community <select name="domain">
				<?=$objCommon->getValuesFromArray($arrPrefixDomainList, "- Select -", "", $varDomain);?>
				</select>
				<input type="Submit" name="Submit" value="submit" onClick="USPaidMsgValSubmit();">
		</td></tr>
	</table>
	<table border=0 cellpadding=0 cellspacing=0 width="540">
		<tr><td colspan="5" align="center">&nbsp;</td></tr>
	</table>
	<table border=1 cellpadding=0 cellspacing=0 width="530" align="center">
		<? if($varResult=='') {?>
			<tr>
				<td class="adminformheader mediumtxt boldtxt" width="150">Message</td>
				<td class="adminformheader mediumtxt boldtxt" width="80">SenderId</td>
				<td class="adminformheader mediumtxt boldtxt" width="80">ReceiverId</td>
				<td class="adminformheader mediumtxt boldtxt" width="100">Date Sent</td>
				<td class="adminformheader mediumtxt boldtxt" width="130">Action</td>
			</tr>
			<?while($varSelPendingMsgs=mysql_fetch_assoc($varSelAllPendngMsgs)) { ?>
				<tr>
					<td class="mediumtxt boldtxt" height="30"><a class="clr1" href="javascript:;" onClick="expandDiv('msg<?=$varSelPendingMsgs["Mail_Id"]?>');"><?=substr($varSelPendingMsgs["Mail_Message"],0,20);?>	</a></td>
					<td class="mediumtxt">&nbsp;<?=$varSelPendingMsgs["Opposite_MatriId"]?></td>
					<td class="mediumtxt">&nbsp;<?=$varSelPendingMsgs["MatriId"]?></td>
					<td class="mediumtxt">&nbsp;<?=date('Y-m-d',strtotime($varSelPendingMsgs["Date_Updated"]));?></td>
					<td class="mediumtxt">&nbsp;<a href="#" onClick="validateMag('<?=$varSelPendingMsgs["Opposite_MatriId"]?>',1);">Approve</a> | <a href="#" onClick="validateMag('<?=$varSelPendingMsgs["Opposite_MatriId"]?>',2);">Reject</a></td>
				</tr>
				<tr>
					<td colspan="5" class="mediumtxt" style="background-color:#FFF0D3"><div id="msg<?=$varSelPendingMsgs["Mail_Id"]?>" style="display:none"><?=$varSelPendingMsgs["Mail_Message"];?></div></td>
				</tr>
			<?}
		} else {?>
		<tr><td colspan="5" class="mediumtxt"><?=$varResult?></td></tr>
		<? } ?>
	</table>
	</form>
</body>
</html>

<script language="javascript">
function USPaidMsgValSubmit() {
	var frmName = document.uspaidmsg;
	frmName.uspaidmsgvalue.value="yes";
}

function validateMag(matid, acttype) {
	var frmName = document.uspaidmsg;
	frmName.actionvalue.value="yes";
	frmName.actiontype.value=acttype;
	frmName.matriid.value=matid;
	frmName.uspaidmsgvalue.value="yes";
	frmName.action.value="index.php";
	frmName.submit();
}

function validateTotMsg() {
	var frmName = document.uspaidmsg;
	frmName.uspaidmsgvalue.value="yes";
	frmName.action.value="index.php";
	frmName.submit();
}

function expandDiv(divid) {
	var stval = $(divid).style.display=="none" ? "block":"none";
	$(divid).style.display=stval;
}
</script>
