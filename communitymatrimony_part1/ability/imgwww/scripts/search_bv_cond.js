function sr_getTop(opp_id, i, shl_fl, opp_gen){

	var shl_disp = 'block', top_cont = '';
	if(shl_fl == '1'){ shl_disp = 'none';}

	top_cont += '<div class="fleft middiv2" id="'+i+'"><div class="fleft">';
	top_cont += '<input type="checkbox" id="SRC'+i+'" name="SRID[]" value="'+opp_id+'" onclick="chkbox_checksrch(\'\');"/></div>';
	top_cont += '<div class="fleft vc6pd-top smalltxt1" onclick="chkbox_checksrch(\'SRC'+i+'\');">Select this profile';
	top_cont += '</div>';

	if(cook_id == ''  || opp_gen ==cook_gender){
	top_cont += '<div class="fright"><a href="/search/index.php?act=srchresult&ID='+opp_id+'&srchType=5&gender='+opp_gen+'" target="_blank" class="clr1">Similar Profiles</a></div></div></div>';
	}else {
	top_cont += '<div class="fright"><div class="smalltxt"><div style="display:'+shl_disp+';" id="shl_lnk'+opp_id+'" class="fleft">';
	top_cont += '<a href="javascript:void(0)" onClick="javascript:funIframeURL(\'list/listadd.php?id='+opp_id+'&purp=shortlist\',\'420\',\'193\',\'iframeicon\',\'icondiv\');" class="clr1">Shortlist</a>&nbsp;&nbsp;|&nbsp;&nbsp;</div>';
	top_cont += '<a href="/search/index.php?act=srchresult&ID='+opp_id+'&srchType=5&gender='+opp_gen+'" target="_blank" class="clr1">Similar Profiles</a></div></div></div>';
	}
	return top_cont+'<br clear="all">';
}

function goReg(opp_id){
	window.location = ser_url+'/register/index.php?act=addbasic&req=vp&oid='+opp_id;
}

function sr_getBot(opp_id, i, opp_gen){
	var bot_cont = '';
	bot_cont += '<div class="vdotline"><div class="smalltxt phnextpadding fleft"> ';
	if(cook_paid == '1' && cook_id!='' && opp_gen !=cook_gender){
	bot_cont += '<a onclick="javascript:funIframeURL(\'mymessages/sendpermsg.php?id='+opp_id+'\',\'520\',\'410\',\'iframeicon\',\'icondiv\');" href="javascript:void(0)">';
	bot_cont += '<div class="pntr">Type your message</div></a></div><div class="smalltxt fright" style="padding: 7px;">';
	bot_cont += '<input type="button" value="Send Mail" class="button button-border" onclick="javascript:funIframeURL(\'mymessages/sendpermsg.php?id='+opp_id+'\',\'520\',\'410\',\'iframeicon\',\'icondiv\');"/>';
	}else if(cook_paid == '0' && cook_id!='' && opp_gen !=cook_gender){
	bot_cont += '<a onclick=" javascript:funIframeURL(\'mymessages/interestadd.php?id='+opp_id+'\',\'480\',\'380\',\'iframeicon\',\'icondiv\');" href="javascript:void(0)">';
	bot_cont += '<div class="fleft" style="padding-top:3px;"><div class="fleft pntr">Select your message</div><div class="exp_downarrow_icon fleft pntr"></div></div></a></div><div class="smalltxt fright" style="padding: 7px;">';
	bot_cont += '<input type="button" value="Express Interest" class="button button-border" onclick="javascript:funIframeURL(\'mymessages/interestadd.php?id='+opp_id+'\',\'480\',\'380\',\'iframeicon\',\'icondiv\');"/>';
	}
	else if(cook_id!='' && opp_gen == cook_gender){
		bot_cont += '</div><div class="smalltxt fright" style="padding:7px;">';
		bot_cont += '<input type="button" value="Forward" class="button button-border" onclick="javascript:funIframeURL(\'search/forwardprofile.php?id='+opp_id+'\',\'550\',\'460\',\'iframeicon\',\'icondiv\');"/" target="_blank">';
	}
	else if(cook_id == ''){
	bot_cont += '</div><div class="smalltxt fright" style="padding:7px;">';
	bot_cont += '<input type="button" value="Register FREE to contact this member" class="button button-border" onclick="goReg(\''+opp_id+'\')" target="_blank">';
	}
	bot_cont += '</div></div><br clear="all">';
	return bot_cont;
}