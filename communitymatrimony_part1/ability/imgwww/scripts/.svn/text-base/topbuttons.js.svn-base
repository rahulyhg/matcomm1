//Message related button
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
		MoreLnk = "<a href='javascript:void(0);' onClick=\"funIframeURL('mymessages/msgmore.php?msgId="+msg_arr["MailID"]+"&tabname="+mod_name+"','500','350','iframeicon','icondiv');\" class='clr1'>More</a>";
	}
	if(mod_name.substring(0,2) =='MS') { MsgDate = Decode_it(msg_arr['DS']);MsgAction = 'sent'; }
	else if(mod_name.substring(0,2) =='MR'&& publ != 'D' && publ!='TD')
	{
		MsgDate	= Decode_it(msg_arr['DR']);
		RepBut	= "<input type=\"button\" value=\"Reply\" class=\"button\" onClick=\"javascript:funIframeURL('mymessages/messagereply.php?msgId="+msg_arr["MailID"]+"&tabname="+mod_name+"','500','365','iframeicon','icondiv');\">";

		MsgAction = 'recd';
	
		if(mod_name != 'MRD') {
			DecBut	= "&nbsp;<input type=\"button\" value=\"Decline\" class=\"button\" onclick=\"javascript:funIframeURL('mymessages/msgdecline.php?msgId="+msg_arr["MailID"]+"&tabname="+mod_name+"','450','170','iframeicon','icondiv');\">"
		}
	}

	var BotCont	= '<div class="vdotline"><div class="smalltxt" style="float:left; padding: 8px 0px 0px 10px;"><b>Msg '+MsgAction+'</b>:';
	BotCont += MsgDate + '.' + MsgMsg+MoreLnk + '</div><div class="smalltxt" style="float:right;margin:5px;">' + RepBut + DecBut + '</div></div><br clear="all">';
	return BotCont;
}

//Interest related button
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
	var IntMoreHig= '300';

	if(mod_name == 'IRN'){
		MsgAction = 'recd';
		MsgDate	= Decode_it(msg_arr['DR']);
		if(publ != 'D' && publ != 'TD'){
		acc_wid	= (cook_paid==1)?510:500;
		acc_hei = (cook_paid==1)?400:150;


		AccBut	= "<input type='button' value='Accept' class='button' onClick=\"javascript:funIframeURL('mymessages/interestaccept.php?iid="+msg_arr["IntID"]+"','"+acc_wid+"','"+acc_hei+"','iframeicon','icondiv');\">&nbsp;&nbsp;";
		DecBut	= "<input type='button' value='Decline' class='button' onClick=\"javascript:funIframeURL('mymessages/interestdecline.php?iid="+msg_arr["IntID"]+"','500','310','iframeicon','icondiv');\">&nbsp;&nbsp;";
		}
	}else if(mod_name == 'IRA'){
		MsgAction = 'recd';
		MsgDate	= Decode_it(msg_arr['DA']);
	}else if(mod_name == 'IRD'){
		IntMoreHig	= '340';
		MsgAction = 'recd';
		MsgDate	= Decode_it(msg_arr['DA']);
		if(publ != 'D' && publ != 'TD'){
		acc_wid	= (cook_paid==1)?510:500;
		acc_hei = (cook_paid==1)?400:150;
		AccBut	= "<input type='button' value='Accept' class='button' onClick=\"javascript:funIframeURL('mymessages/interestaccept.php?iid="+msg_arr["IntID"]+"&act=dec','"+acc_wid+"','"+acc_hei+"','iframeicon','icondiv');\">";
		}
	}else if(mod_name == 'ISN'){
		MsgAction = 'sent';
		MsgDate	= Decode_it(msg_arr['DS']);
		if(publ != 'D' && publ != 'TD'){
		SRBut	= '<input type="button" value="Send Reminder" class="button" onclick="javascript:funIframeURL(\'mymessages/sendreminder.php?iid='+msg_arr['IntID']+'\',\'450\',\'125\',\'iframeicon\',\'icondiv\');">';
		}
	}else if(mod_name == 'ISA' || mod_name == 'ISD'){
		IntMoreHig	= '260';
		MsgAction	= 'sent';
		MsgDate	= Decode_it(msg_arr['DA']);
	}

	var MoreLnk = '<a href="javascript:void(0);" onClick="funIframeURL(\'mymessages/interestmore.php?iid='+msg_arr['IntID']+'&tabId='+mod_name+'\',\'500\',\''+IntMoreHig+'\',\'iframeicon\',\'icondiv\');" class="clr1">More</a></div><div class="smalltxt" style="float:right;margin:5px;">';


	var BotCont	= '<div class="vdotline"><div class="smalltxt" style="float:left; padding: 8px 0px 0px 10px;"><b>Msg '+MsgAction+'</b>:';	
	BotCont += ' '+MsgDate + '. ' + IntMsg+MoreLnk + AccBut + DecBut + SRBut+'</div></div><br clear="all">';
	return BotCont;
}

function funDelete(opp_id,intid,mod_name){
	if(mod_name.substr(0,1) =='M'){
		funIframeURL('mymessages/msgdelete.php?id='+intid+'&purp='+mod_name,'480','130','iframeicon','icondiv');
	}else if(mod_name.substr(0,2)=='RR'){
		funIframeURL('request/reqdelete.php?id='+intid+'&purp='+mod_name,'480','130','iframeicon','icondiv');
	}else if(mod_name.substr(0,2)=='RS'){
		funIframeURL('request/reqdelete.php?id='+intid+'&purp='+mod_name,'480','130','iframeicon','icondiv');
	}else if(mod_name =='LIF'){
		funIframeURL('list/listdelete.php?id='+opp_id+'&purp=shrt','480','130','iframeicon','icondiv');
	}else if(mod_name =='LII'){
		funIframeURL('list/listdelete.php?id='+opp_id+'&purp=ig','480','130','iframeicon','icondiv');
	}else if(mod_name =='LIB'){
		funIframeURL('list/listdelete.php?id='+opp_id+'&purp=block','480','130','iframeicon','icondiv');
	}
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
	 if((mod_name.substr(0,1) =='M' || mod_name.substr(0,1)=='R'  || mod_name.substr(0,1)=='L') && showall_fl == 'Y'){
		top_cont += '<a href="javascript:void(0);" onClick="funDelete(\''+opp_id+'\',\''+intid+'\',\''+mod_name+'\');" class="clr1">Delete</a>';
	}
	else if(mod_name != 'IRN' && showall_fl == 'Y'){
	top_cont += '<a href="javascript:void(0);" onClick="deleteall(\''+opp_id+'\',\''+mod_name+'\',\''+intid+'\',\'0\');" class="clr1">Delete</a>';
	}
	else if((mod_name == 'IRN' && (publ == 'D' || publ == 'TD')) && showall_fl == 'Y'){
	top_cont += '<a href="javascript:void(0);" onClick="deleteall(\''+opp_id+'\',\''+mod_name+'\',\''+intid+'\',\'0\');" class="clr1">Delete</a>';
	}

	if(publ != 'D' && publ != 'TD'){
	top_cont += '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/search/index.php?act=srchresult&ID='+opp_id+'&srchType=5&gender='+opp_gen+'" class="clr1" target="_blank">Similar Profiles</a>'
	}

	top_cont +='</div></div></div>';
	return top_cont+'<br clear="all">';
}

function int_sel_all(pg_opt){
	var sel_but_cont = '',sel_but_cont1='';
	if(pg_opt == 'IRN')
	{
		sel_but_cont = '<input type="button" onclick="javascript:acceptall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\',\'1\');" class="button" value="Accept"/>&nbsp;<input type="button" onclick="javascript:declineall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\',\'1\');" class="button" value="Decline"/>'; 
		sel_but_cont1= sel_but_cont;
	}
	else if(pg_opt == 'IRA')
	{
		sel_but_cont = '<a class="clr1" href="javascript:deleteall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\',\'1\')">Delete all</a>';
		sel_but_cont1= sel_but_cont;
	}
	else if(pg_opt == 'IRD')
	{
		sel_but_cont = '<a class="clr1" href="javascript:acceptall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\',\'1\')">Accept all</a>&nbsp;&nbsp;<a class="clr1" href="javascript:deleteall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\',\'1\')">Delete all</a>'; 
		sel_but_cont1= sel_but_cont;
	}
	else {
		if(pg_opt == 'ISN'){
			sel_but_cont = '<a class="clr1" href="javascript:void(0);" onClick="reminderall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\',\'1\');">Send Reminder all</a>&nbsp;&nbsp;';
			sel_but_cont1= sel_but_cont;
		}
		sel_but_cont += '<a class="clr1" href="javascript:void(0);" onClick="deleteall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk\',\'1\');">Delete all</a>';
		sel_but_cont1 += '<a class="clr1" href="javascript:void(0);" onClick="deleteall(\'navigatefrm\',\''+pg_opt+'\',\'sel_all_chk1\',\'1\');">Delete all</a>';
	}
	$('sel_butt').innerHTML = sel_but_cont;
	$('sel_butt1').innerHTML = sel_but_cont1;
}

//List related button
function list_getBot(msg_arr, mod_name)
{
	var MoreLnk = '', purpt='';
	var LiMsg	= Decode_it(msg_arr['Com']);
	if(mod_name == 'LIF'){purpt='shortlist';}else if(mod_name == 'LII'){purpt='ignore';}else{purpt='block';}
	if (LiMsg.length > 30) { 
		LiMsg = LiMsg.substr(0, 30)+'...'; 
		MoreLnk = "<a href='javascript:void(0);' onClick=\"funIframeURL('list/listadd.php?id="+msg_arr["OID"]+"&ed=ed&purp="+purpt+"&notemplate=yes','420','193','iframeicon','icondiv');\" class='clr1'>More</a>";
	}
	var BotCont	 = '<div class="vdotline"><div class="smalltxt" style="float:left; padding: 8px 0px 0px 10px;"><b>Comments</b>: ';
	BotCont += LiMsg+MoreLnk + '</div><div class="smalltxt" style="float:right;margin:5px;"></div></div><br clear="all">';
	return BotCont;
}

//View related button
function view_getBot(vi_dt)
{
	var ViDt	= Decode_it(vi_dt);
	var BotCont	= '<div class="vdotline"><div class="smalltxt" style="float:left; padding: 8px 0px 0px 10px;"><b>Date viewed on</b>: ';
	BotCont += ViDt + '</div><div class="smalltxt" style="float:right;margin:5px;"></div></div><br clear="all">';
	return BotCont;
}

function acceptall(f,tabid,idname,delid) {
	var a=selectedids('~',f,idname);
	$('errdiv').innerHTML = '';
	acc_wid	= (cook_paid==1)?510:480;
	acc_hei = (cook_paid==1)?400:130;
	var url= 'mymessages/interestaccept.php?iid='+a+'&purp='+tabid+'&delid='+delid;
	if(a=='' || a=="null" || a==null) {
			$('errdiv').innerHTML = 'Please select atleast one profile for accept';
	} else {
		$('errdiv').innerHTML = '';
		funIframeURL(url,acc_wid,acc_hei,'iframeicon','icondiv');
	}
}

function declineall(f,tabid,idname,delid) {
	var a=selectedids('~',f,idname);
	$('errdiv').innerHTML = '';
	var url= 'mymessages/interestdecline.php?iid='+a+'&purp='+tabid+'&delid='+delid;
	if(a=='' || a=="null" || a==null) {
			$('errdiv').innerHTML = 'Please select atleast one profile for decline';
	} else {
		$('errdiv').innerHTML = '';
		funIframeURL(url,'500','350','iframeicon','icondiv');
	}
}


function reminderall(f,tabid,idname,delid) {
	var a=selectedids('~',f,idname);
	$('errdiv').innerHTML = '';
	var url= 'mymessages/sendreminder.php?iid='+a+'&purp='+tabid+'&delid='+delid;
	if(a=='' || a=="null" || a==null) {
			$('errdiv').innerHTML = 'To send reminder, please select the profile(s)';
			
	} else {
		$('errdiv').innerHTML = '';
		funIframeURL(url,'450','125','iframeicon','icondiv');
	}
}