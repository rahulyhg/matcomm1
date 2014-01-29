function list_getBot(msg_arr, mod_name)
{
	var MoreLnk = '';
	var LiMsg	= Decode_it(msg_arr['Com']);
	var BotCont = '';
	if (LiMsg.length > 30) { 
		LiMsg = LiMsg.substr(0, 30)+'...'; 
		MoreLnk = "<a href='javascript:void(0);' onClick=\"funIframeURL('list/listmore.php?id="+msg_arr["OID"]+"&tabId="+mod_name+"','500','350','iframeicon','icondiv');\" class='clr1'>More</a>";
	}
	var BotCont	= '<div class="vdotline"><div class="smalltxt" style="float:left; padding: 8px 0px 0px 10px;"><b>Comments</b>: ';
	BotCont += LiMsg+MoreLnk + '</div><div class="smalltxt" style="float:right;margin:5px;"></div></div><br clear="all">';
	return BotCont;
}		