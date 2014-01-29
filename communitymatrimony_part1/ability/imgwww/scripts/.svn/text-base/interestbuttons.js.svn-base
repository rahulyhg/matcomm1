function int_getBot(msg_arr, mod_name,publ)
{
	var IntMsgArr  = new Array("Interested in your profile. Accept my interest if you are interested too.", "I feel we have lot in common. Like to know your opinion?", "You're someone special I wish to know. Contact me at the earliest.", "We found your profile to be a good match. Contact us to proceed further.", "You're just the person we were searching for. Send us your contact details.","Our children's profiles seem to match. Please 'Accept' if you want us to contact you further.");
	var IntMsg	= parseInt(msg_arr['IntOp'])-1;
	var IntMsg	= IntMsgArr[IntMsg];
	var IntMsg	= IntMsg.substr(0, 30)+'... ';
	var MsgDate	= '';
	var AccBut	= '';
	var DecBut  = '';
	var SRBut	= '';
	var MsgAction = '';
	var MoreLnk = '<a href="javascript:void(0);" onClick="funIframeTools(\'mymessages/interestmore.php?iid='+msg_arr['IntID']+'&tabId='+mod_name+'\',\'500\',\'300\',\'iframeicon\',\'icondiv\');" class="clr1">More</a></div><div class="smalltxt" style="float:right;margin:5px;">';


	if(mod_name == 'IRN')
	{
		MsgAction = 'recd';
		MsgDate	= Decode_it(msg_arr['DR']);
		if(publ != 'D' && publ != 'TD'){
		AccBut	= "<input type='button' value='Accept' class='button' onClick=\"javascript:funIframeTools('mymessages/interestaccept.php?iid="+msg_arr["IntID"]+"','500','350','iframeicon','icondiv');\">&nbsp;&nbsp;";
		DecBut	= "<input type='button' value='Decline' class='button' onClick=\"javascript:funIframeTools('mymessages/interestdecline.php?iid="+msg_arr["IntID"]+"','500','350','iframeicon','icondiv');\">&nbsp;&nbsp;";
		}
	}
	else if(mod_name == 'IRA')
	{
		MsgAction = 'recd';
		MsgDate	= Decode_it(msg_arr['DA']);
	}
	else if(mod_name == 'IRD')
	{
		MsgAction = 'recd';
		MsgDate	= Decode_it(msg_arr['DA']);
		if(publ != 'D' && publ != 'TD'){
		AccBut	= "<input type='button' value='Accept' class='button' onClick=\"javascript:funIframeTools('mymessages/interestaccept.php?iid="+msg_arr["IntID"]+"&act=dec','500','350','iframeicon','icondiv');\">";
		}
	}
	else if(mod_name == 'ISN')
	{
		MsgAction = 'sent';
		MsgDate	= Decode_it(msg_arr['DS']);
		if(publ != 'D' && publ != 'TD'){
		SRBut	= '<input type="button" value="Send Reminder" class="button" onclick="javascript:funIframeTools(\'mymessages/sendreminder.php?iid='+msg_arr['IntID']+'\',\'500\',\'300\',\'iframeicon\',\'icondiv\');">';
		}
	}
	else if(mod_name == 'ISA' || mod_name == 'ISD')
	{
		MsgAction = 'sent';
		MsgDate	= Decode_it(msg_arr['DA']);
	}
	var BotCont	= '<div class="vdotline"><div class="smalltxt" style="float:left; padding: 8px 0px 0px 10px;"><b>Msg '+MsgAction+'</b>:';	

	BotCont += ' '+MsgDate + '. ' + IntMsg+MoreLnk + AccBut + DecBut + SRBut+'</div></div><br clear="all">';

	return BotCont;
}
function funDelete(opp_id,intid,mod_name) {
	if(mod_name.substr(0,1) =='M')
		funIframeURL('mymessages/msgdelete.php?id='+intid+'&purp='+mod_name,'480','130','iframeicon','icondiv');
	else if(mod_name.substr(0,2)=='RR')
		funIframeURL('request/reqdelete.php?id='+intid+'&purp=R','480','130','iframeicon','icondiv');
	else if(mod_name.substr(0,2)=='RS')
		funIframeURL('request/reqdelete.php?id='+intid+'&purp=S','480','130','iframeicon','icondiv');
	else if(mod_name =='LIF')
		funIframeURL('list/listdelete.php?id='+opp_id+'&purp=shrt','480','130','iframeicon','icondiv');
	else if(mod_name =='LII')
		funIframeURL('list/listdelete.php?id='+opp_id+'&purp=ig','480','130','iframeicon','icondiv');
	else if(mod_name =='LIB')
		funIframeURL('list/listdelete.php?id='+opp_id+'&purp=block','480','130','iframeicon','icondiv');
	//alert(mod_name);
}
function int_getTop(intid, opp_id, i,opp_gen,mod_name,publ){
	top_cont = '';
	top_cont += '<div class="fleft middiv2" id="'+i+'"><div class="fleft">';
	
	if(showall_fl == 'Y'){ 
	id_val = (mod_name.substr(0,1)=='L') ? opp_id : intid;
	top_cont += '<input type="checkbox" id="SRC'+i+'" name="SRID[]" value="'+id_val+'" onclick="chkbox_check(document.forms[0],\'SRC'+i+'\',\'sel_all_chk\');"/></div><div class="fleft vc6pd-top smalltxt1">Select this profile';
	}
	top_cont += '</div>';
	
	top_cont += '<div class="fright"><div class="smalltxt">';

	if(mod_name != 'IRN' && showall_fl == 'Y'){
	top_cont += '<a href="javascript:void(0);" onClick="funDelete(\''+opp_id+'\',\''+intid+'\',\''+mod_name+'\');" class="clr1">Delete</a>&nbsp;&nbsp;&nbsp;';
	}

	if(publ != 'D' && publ != 'TD'){
	top_cont += '<a href="/search/index.php?act=srchresult&ID='+opp_id+'&srchType=5&gender='+opp_gen+'" class="clr1" target="_blank">Similar Profiles</a>'
	}

	top_cont +='</div></div></div>';
	return top_cont+'<br clear="all">';
}

function int_sel_all(pg_opt){

	//alert('pg_opt=='+pg_opt);
	var sel_but_cont = '';
	if(pg_opt == 'IRN')
	{
		sel_but_cont = '<input type="button" onclick="javascript:funIframeTools(\'mymessages/interestacceptall.php\',\'500\',\'350\',\'iframeicon\',\'icondiv\');" class="button" value="Accept"/><input type="button" onclick="javascript:funIframeTools(\'mymessages/interestdeclineall.php\',\'500\',\'350\',\'iframeicon\',\'icondiv\');" class="button" value="Decline"/>'; 
		sel_but_cont1= sel_but_cont;
	}
	else if(pg_opt == 'IRA')
	{
		sel_but_cont = '<a class="clr1" href="javascript:delInt('+pg_opt+')">Delete all</a>';
		sel_but_cont1= sel_but_cont;
	}
	else if(pg_opt == 'IRD')
	{
		sel_but_cont = '<a class="clr1" href="javascript:accInt('+pg_opt+')">Accept all</a><a class="clr1" href="javascript:delInt('+pg_opt+')">Delete all</a>'; 
		sel_but_cont1= sel_but_cont;
	}
	else {
		sel_but_cont = '<a href="javascript:void(0);" onClick="deleteall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\');">Delete</a>';
		sel_but_cont1 = '<a href="javascript:void(0);" onClick="deleteall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk1\');">Delete</a>';
	}
	$('sel_butt').innerHTML = sel_but_cont;
	$('sel_butt1').innerHTML = sel_but_cont1;
}