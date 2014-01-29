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
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlaveDB	= new DB;
$objMasterDB= new DB;

//DB CONNECTION
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varResult		= "";
$varFrmSubmit	= $_POST["frmSubmit"];

if($_POST["frmSubmit"] == "Submit") {
	unset($_POST['act']);unset($_POST['frmSubmit']);
	$arrSpamIds		= array();
	$arrnonSpamIds	= array();
	foreach($_POST as $varKey=>$varVal){
		if($varVal==1){
			$arrSpamIds[] = substr($varKey, 3);
		}else if($varVal==2){
			$arrnonSpamIds[] = substr($varKey, 3);
		}
	}

	$argFields 		= array('ValidationStatus');
	if($arrSpamIds > 0){
		$argFieldsValues	= array(1);
		$argUpdCondition	= "MessageId IN(".join(",",$arrSpamIds).") AND ValidationStatus=0";
		$varUpdateId		= $objMasterDB->update($varTable['SPAMMSG'],$argFields,$argFieldsValues,$argUpdCondition);
	}

	if($arrnonSpamIds > 0){
		$argFieldsValues	= array(2);
		$argUpdCondition	= "MessageId IN(".join(",",$arrnonSpamIds).") AND ValidationStatus=0";
		$varUpdateId		= $objMasterDB->update($varTable['SPAMMSG'],$argFields,$argFieldsValues,$argUpdCondition);
	}
}

$varCondition	= " WHERE ValidationStatus=0";
$varNoOfRecords	= $objSlaveDB->numOfRecords($varTable["SPAMMSG"], 'MessageId', $varCondition);
if($varNoOfRecords>0) {
	$varCondition  .= ' ORDER BY AlertDate ASC LIMIT 10';
	$varFields		= array('MessageId','ReceiverId','SenderId','Message','RepliedMessage','AlertDate');
	$varSelSpamMsgs	= $objSlaveDB->select($varTable['SPAMMSG'],$varFields,$varCondition,0);
} else {
	$varResult		= "No spam messages available.";
}
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head><title>Spam Message Validation</title></head>
<body>
	<form method="post" name="uspaidmsg">
	<input type="hidden" name="act" value="spammsgval">
	<table border=0 cellpadding=0 cellspacing=0 width="540">
		<tr><td class="heading" colspan="5" align="center">Spam Message Validation</td></tr>
		<tr><td colspan="5">&nbsp;</td></tr>
		<tr><td class="mediumtxt boldtxt" colspan="5" align="center">
				<a class="clr1" href="#" onClick="validateTotMsg();">Total messages sent</a> : <?=$varNoOfRecords?>
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
				<td class="adminformheader mediumtxt boldtxt" width="100">Alert Date</td>
				<td class="adminformheader mediumtxt boldtxt" width="60">Add</td>
				<td class="adminformheader mediumtxt boldtxt" width="60">Reject</td>
			</tr>
			<?while($varSingleMsgs=mysql_fetch_assoc($varSelSpamMsgs)) { ?>
				<tr>
					<td class="mediumtxt boldtxt" height="30"><a class="clr1" href="javascript:;" onClick="expandDiv('msg<?=$varSingleMsgs["MessageId"]?>');"><?=substr($varSingleMsgs["Message"],0,20);?></a></td>
					<td class="mediumtxt">&nbsp;<?=$varSingleMsgs["SenderId"]?></td>
					<td class="mediumtxt">&nbsp;<?=$varSingleMsgs["ReceiverId"]?></td>
					<td class="mediumtxt">&nbsp;<?=date('Y-m-d',strtotime($varSingleMsgs["AlertDate"]));?></td>
					<td class="mediumtxt">&nbsp;<input type="radio" name="sid<?=$varSingleMsgs["MessageId"]?>" value="1"></td>
					<td class="mediumtxt">&nbsp;<input type="radio" name="sid<?=$varSingleMsgs["MessageId"]?>" value="2"></td>
				</tr>
				<tr>
					<td colspan="6" class="mediumtxt" style="background-color:#FFF0D3"><div id="msg<?=$varSingleMsgs["MessageId"]?>" style="display:none"><?=$varSingleMsgs["Message"];?></div></td>
				</tr>
			<?}?>
			<tr><td colspan="6" class="mediumtxt" align="right"><input type="submit" class="button" name="frmSubmit" value="Submit"></td>
			</tr>
		<?
		} else {?>
		<tr><td colspan="6" class="mediumtxt"><?=$varResult?></td></tr>
		<? } ?>
	</table>
	</form>
</body>
</html>

<script language="javascript">
function expandDiv(divid) {
	var stval = $(divid).style.display=="none" ? "block":"none";
	$(divid).style.display=stval;
}
</script>
