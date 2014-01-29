function msg_getBot(msg_arr, mod_name, publ)
{
	var MoreLnk = '';
	var MsgDate	= '';
	var RepBut	= '';
	var DecBut  = '';
	var MsgMsg	= Decode_it(msg_arr['MSG']);
	var MsgAction = '';
	if (MsgMsg.length > 30) { 
		MsgMsg = MsgMsg.substr(0, 30)+'...'; 
		MoreLnk = "<a href='javascript:void(0);' onClick=\"funIframeURL('mymessages/msgmore.php?msgId="+msg_arr["MailID"]+"&tabId="+mod_name+"','500','350','iframeicon','icondiv');\" class='clr1'>More</a>";
	}
	if(mod_name.substring(0,2) =='MS') { MsgDate = Decode_it(msg_arr['DS']);MsgAction = 'sent'; }
	else if(mod_name.substring(0,2) =='MR'&& publ != 'D' && publ!='TD')
	{
		MsgDate	= Decode_it(msg_arr['DR']);
		RepBut	= "<input type=\"button\" value=\"Reply\" class=\"button\" onClick=\"javascript:funIframeURL('mymessages/messagereply.php?msgId="+msg_arr["MailID"]+"','500','350','iframeicon','icondiv');\">";

		MsgAction = 'recd';
	
		if(mod_name != 'MRD') {
			DecBut	= "&nbsp;<input type=\"button\" value=\"Decline\" class=\"button\" onclick=\"javascript:funIframeURL('mymessages/msgdecline.php?msgId="+msg_arr["MailID"]+"','450','200','iframeicon','icondiv');\">"
		}
	}

	var BotCont	= '<div class="vdotline"><div class="smalltxt" style="float:left; padding: 8px 0px 0px 10px;"><b>Msg '+MsgAction+'</b>:';
	BotCont += MsgDate + '.' + MsgMsg+MoreLnk + '</div><div class="smalltxt" style="float:right;margin:5px;">' + RepBut + DecBut + '</div></div><br clear="all">';
	return BotCont;
}		