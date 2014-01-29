<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.inc');

if($adminUserName != '') {
?>
<img src="<?=$confValues['IMGSURL']?>/trans.gif" onLoad="showTwitterMsgCnt();">
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="15"></td></tr>
	<tr><td class="heading" style="padding-left:10px;">Validate Twitter Messages</td></tr>
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:45px;padding-bottom:0px;color:red"><b>New Messages Pending Count : <span id="twitmsgcnt"></span></b></td></tr>
</table>
<br>
<div>
<form method="post" name="frmAddTwitter">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Add </td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10" height="25"></td>
<td align="left" class="smalltxt">
Enter Number of Messages to be display and click 'Validate' to validate the messages available in for addition. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top" class="mediumtxt"><b>No.of messages to be displayed: </b>&nbsp;
<input name="norec" size="4" value="" type="text" class="inputtext">
&nbsp;&nbsp;<b>Start From </b>&nbsp;<input name="startLimit" size="4" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="button" name="addedTwitterSubmit" class="button" onClick="return funShowTwitterMessage();">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>
<br>

<form method="post" name="TwitterMsgForMatriId">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Single TwitterId's Message Validation</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10"></td>
<td align="left" class="smalltxt">Matrimony Id :&nbsp;
<input name="ID" size="10" type="text" class="inputtext">
&nbsp;<input value="Validate" type="button" name="addedSingleTwitterMsgSubmit"  onClick="return showTwitterMsgForMatriId();" class="button">
<input value="Clear" type="reset" class="button">
</td></tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>
</div>

<form name="twittervalidate" method="post">
<input type="hidden" name="verifiedby" value="<?=$adminUserName?>">
<div id="alltwittermsg">
</div>
</form>

<script language="javascript">
var ajaxobj=false;

function showTwitterMsgCnt() {
	var argurl="get_twitter_msg.php";
	ajaxobj=AjaxCall();
	postval = '';
	AjaxPostReq(argurl,postval,populateGetTwitterTotalMsg,ajaxobj);
}

function populateGetTwitterTotalMsg() {
	if (ajaxobj.readyState == 4 && ajaxobj.status == 200) {
		eval("respTxt="+ajaxobj.responseText);
		var msgsize = respTxt['messages']['totalMessages'];
		if(msgsize > 0) {
			document.getElementById('twitmsgcnt').innerHTML	= msgsize;
		} else {
			document.getElementById('twitmsgcnt').innerHTML	= "0";
		}
	}
}

function showTwitterMsgForMatriId()
{
	var funFormName	= document.TwitterMsgForMatriId;
	if (funFormName.ID.value=="")
	{
		alert("please enter Matrimony Id");
		funFormName.ID.focus();
		return false;
	}//if

	var argurl="/admin/get_twitter_msg.php";
	ajaxobj=AjaxCall();
	postval = 'msgformatriid=yes&msgtype=0&matriid='+funFormName.ID.value;
	AjaxPostReq(argurl,postval,populateTwitterTotalMsg,ajaxobj);

}//showTwitterMsgForMatriId


function funShowTwitterMessage() {
	var funFormName	= document.frmAddTwitter;

	var argurl="/admin/get_twitter_msg.php";
	ajaxobj=AjaxCall();
	postval = 'msgall=yes&msgtype=0&startlt='+funFormName.startLimit.value+'&endlt='+funFormName.norec.value;
	AjaxPostReq(argurl,postval,populateTwitterTotalMsg,ajaxobj);
}

function populateTwitterTotalMsg() {
	if (ajaxobj.readyState == 4 && ajaxobj.status == 200) {
		if(ajaxobj.responseText != '0') {
			eval("respTxt="+ajaxobj.responseText);
			var msgsize = respTxt['numberOfMessages'];
			if(msgsize > 0) {
				var respMsg = '';
				var respMsgArray = respTxt['messages'];
				for(i=0; i<msgsize; i++) {
					respMsg += '&nbsp;&nbsp;<input type="checkbox" name="twitmsg[]" value="'+respMsgArray[i]['id']+'" checked>'+respMsgArray[i]['msg']+'<br><div class=\'dotsep\'><img src=\'images/trans.gif\' width=\'1\' height=\'1\' /></div><br>';
				}
				//respMsg += 'Validated By <input type="text" name="verifiedby" value="">';
				respMsg += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="twitvalidate" value="Submit" onClick="SubmitTwitterMsg();">';
				document.getElementById('alltwittermsg').innerHTML	= respMsg;
			} else {
				document.getElementById('alltwittermsg').innerHTML	= "&nbsp;&nbsp;&nbsp;No messages";
			}
		} else {
			document.getElementById('alltwittermsg').innerHTML	= "&nbsp;&nbsp;&nbsp;Due to server problem unable to respond";
		}
	}
}

function selectedids(frm) { 
	var checkedId='';
	var unCheckedId='';
	for(i=0;i<frm.length;i++) { 
		if(frm.elements[i].type=='checkbox') {
			if(frm.elements[i].checked) {
				checkedId+=frm.elements[i].value+',';
			} else {
				unCheckedId+=frm.elements[i].value+',';
			}
		} 
	} 
	if(checkedId.length>0) {
		checkedId=checkedId.substring(0,checkedId.length-1);
	}
	if(unCheckedId.length>0) {
		unCheckedId=unCheckedId.substring(0,unCheckedId.length-1);
	}
	return checkedId+'~'+unCheckedId; 
}

function SubmitTwitterMsg() {
	var funFormName	= document.twittervalidate;

	var TwittetIds = selectedids(funFormName);

	var arrTwittetIds	= TwittetIds.split('~');

	var argurl="/admin/get_twitter_msg.php";
	ajaxobj=AjaxCall();
	postval = 'msgvalidate=yes&chkmsgid='+arrTwittetIds[0]+'&unchkmsgid='+arrTwittetIds[1]+'&verifiedby='+funFormName.verifiedby.value;
	AjaxPostReq(argurl,postval,validateTwitterTotalMsg,ajaxobj);
}

function validateTwitterTotalMsg() {
	if (ajaxobj.readyState == 4 && ajaxobj.status == 200) {
		if(ajaxobj.responseText != '0') {
			eval("respTxt="+ajaxobj.responseText);
			if(respTxt['status']==true) {
				document.getElementById('alltwittermsg').innerHTML	= "&nbsp;&nbsp;&nbsp;Messages approved successfully";
			} else {
				document.getElementById('alltwittermsg').innerHTML	= "&nbsp;&nbsp;&nbsp;<font color='red'>Messages not approved</font>";
			}
		} else {
			document.getElementById('alltwittermsg').innerHTML	= "&nbsp;&nbsp;&nbsp;Due to server problem unable to respond";
		}
	}
}

</script>
<?
} else {
	echo "Your session has expired";
}
?>
