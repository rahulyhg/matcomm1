var clickedIt = false;var clickedIt1 = false;var clickedIt2 = false;
var textmsg="";var textmsg1="";var textmsg2=""; var VPRefresh="";
function clearTextArea() {
		parentIfr   = 'parentrte'+viewrec;
		txtareaname = 'msgtxtarea'+viewrec;
		oRTE	= $(parentIfr);
		textmsg = oRTE.contentWindow.document.getElementById(txtareaname).value;
		textmsg = textmsg.replace("Type Message Here..","");

	if(oRTE.contentWindow.document.getElementById(txtareaname).value=="Type Message Here.."){
		oRTE.contentWindow.document.getElementById(txtareaname).value = textmsg;
	}
	//setcursor(oRTE.contentWindow.document.getElementById(txtareaname),0,0);
}

function sendInterest(rid){
	intval = getRadioValue(eval('document.buttonfrm.intopt'+rid));
	url		= ser_url+'/mymessages/interestadd.php?rno='+Math.random();
	param	= 'intval='+intval+'&intSubmit=yes&oppids='+curroppid;
	objAjax1 = AjaxCall();
	curinnerno = viewrec;
	AjaxPostReq(url,param,msgCallRes,objAjax1);
}

function markasSpam(spamid, conf){
	spamdiv = 'spam'+viewrec;
	if(conf == 'S'){
	url		= ser_url+'/mymessages/markasspam.php?rno='+Math.random();
	param	= 'msgid='+spamid;
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,spamCallRes,objAjax1);
	$(spamdiv).innerHTML = '';
	}else{
	al_div= 'msgactpart'+viewrec;
	$(al_div).innerHTML = "<div class='fright'><img src='"+imgs_url+"/close.gif' onclick='hide_box_msg();' class='pntr'></div><br clear='all'><div class='fleft'>Are you sure you want to mark this mail as spam?</div><div class='fright padt10'><input class='button' value='Yes' onclick='markasSpam(\""+spamid+"\", \"S\")' type='button'> &nbsp;<input class='button' value='No' onclick='hide_box_msg()' type='button'>&nbsp;&nbsp;</div>";
	}
}

function spamCallRes(){
	hide_box_msg();
}

function mulClearTextArea(){
	txtareaname = 'msgtxtarea99';
	oRTE	= $('parentrte99');
	textmsg = oRTE.contentWindow.document.getElementById(txtareaname).value;
	textmsg = textmsg.replace("Type Message Here..","");
	oRTE.contentWindow.document.getElementById(txtareaname).value = textmsg;
	if(textmsg == ''){
	setcursor(oRTE.contentWindow.document.getElementById(txtareaname),0,0);
	}
}

function chkMsgSelIds(){
	oppmatids = checkBoxIds('~',document.buttonfrm,'chk_all');
	if(oppmatids==''){
	$('listalldiv').style.display="block";
	mulAltMsg = 'Please select atleast one profile';
	$('listalldiv').innerHTML = "<div class='fleft tlcenter' style='width:440px;'>"+mulAltMsg+"</div><div class='fright tlright'><img src='"+imgs_url+"/close.gif' class='pntr' onclick='hidediv(\"listalldiv\")'/></div>";
	}else{
	showdiv('contalldiv');stylechange(0);
	}
}

function sendMulMsg(){
	msgtyval = getRadioValue(document.buttonfrm.msgtype99);
	oppmatids = checkBoxIds('~',document.buttonfrm,'chk_all');
	if(msgtyval>0 && oppmatids!=''){
		if(msgtyval==1){
			oRTE	= $('parentrte99');
			txtareaname = 'msgtxtarea99';
			mulMsgVal = oRTE.contentWindow.document.getElementById(txtareaname).value;
			if(mulMsgVal == 'Type Message Here..' || mulMsgVal == ''){
				hidediv('contalldiv');$('listalldiv').style.display="block";
				$('listalldiv').innerHTML = "<div class='fleft tlcenter' style='width:440px;'>Please type your message...</div><div class='fright tlright'><img src='"+imgs_url+"/close.gif' class='pntr' onclick='hidediv(\"listalldiv\")'/></div>";
			}else{
			mulMsgVal = trim(mulMsgVal);
			mulMsgVal = mulMsgVal.replace(/\s+$/,"");
			mulMsgVal = mulMsgVal.replace(/&/,"~^~");
			mulMsgVal = trim(mulMsgVal, "\\n");
			mulMsgVal = trim(mulMsgVal, "\r\n");
			mulMsgVal = trim(mulMsgVal, "<BR>");
			url		= ser_url+'/mymessages/sendmailsubmit.php?rno='+Math.random();
			param	= 'msgTxt='+mulMsgVal+'&msgSubmit=yes&type=mul&oppids='+oppmatids;
			oRTE.contentWindow.document.getElementById(txtareaname).value = 'Type Message Here..';
			objAjax1 = AjaxCall();
			AjaxPostReq(url,param,msgMulRes,objAjax1);
			}
		}else if(msgtyval==2){
			intval = getRadioValue(eval('document.buttonfrm.intopt99'));
			url	   = ser_url+'/mymessages/interestadd.php?rno='+Math.random();
			param  = 'intval='+intval+'&intSubmit=yes&oppids='+oppmatids+'&type=mul';
			objAjax1 = AjaxCall();
			curinnerno = viewrec;
			AjaxPostReq(url,param,msgMulRes,objAjax1)
		}
	}else{
		hidediv('contalldiv');
		$('listalldiv').style.display="block";
		mulAltMsg = '';
		if(msgtyval!=1 && msgtyval!=2){
			mulAltMsg = 'Please select the type of message';
		}else{
			mulAltMsg = 'Please select atleast one profile';
		}
		$('listalldiv').innerHTML = "<div class='fleft tlcenter' style='width:440px;'>"+mulAltMsg+"</div><div class='fright tlright'><img src='"+imgs_url+"/close.gif' class='pntr' onclick='hidediv(\"listalldiv\")'/></div>";
	}
}

function msgMulRes(){
	hidediv('contalldiv');
	$('listalldiv').style.display="block";
	if(objAjax1.readyState == 4){
	$('listalldiv').innerHTML = objAjax1.responseText;
	}else{
	$('listalldiv').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function hideDecDiv(){
	hide_box_div('div_box'+viewrec);
}

function delMsg(subFl){
	buttonForm = this.document.buttonfrm;
	mids	= checkBoxIds(',', buttonForm, 'mids');
	msgOpt	= $('msgtype').value;
	param	= 'msgOpt='+msgOpt+'&mids='+mids;
	if(subFl == 'yes'){
		url		= ser_url+'/mymessages/msgdelete.php?rno='+Math.random();
		objAjax1 = AjaxCall();
		AjaxPostReq(url,param,msgDelRes,objAjax1);
	}else{
		$('deldiv').style.backgroundColor = '#EEEEEE';
		$('deldiv').className = "brdr tlleft pad10";
		msgOptTxt ='';
		if(msgOpt.substring(1,2)=='M'){
			msgOptTxt = 'message';
		}else if(msgOpt.substring(1,2)=='I'){
			msgOptTxt = 'interest';
		}else if(msgOpt.substring(1,2)=='R'){
			msgOptTxt = 'request';
		}
		if(mids == ''){
			$('deldiv').innerHTML = '<div style="width: 440px;" class="fleft tlcenter">Please select atleast one '+msgOptTxt+' to delete</div><div class="fright tlright"><img onclick="emptyDiv(\'deldiv\')" class="pntr" src="'+imgs_url+'/close.gif"/></div>';
		}else{
			$('deldiv').innerHTML = 'Are you sure you want to delete these '+msgOptTxt+'s from this folder?&nbsp;<input type="button" onclick="delMsg(\'yes\');emptyDiv(\'deldiv\');" value="Yes" class="button">&nbsp;<input type="button" onclick="emptyDiv(\'deldiv\')" value="No" class="button">';
		}
	}
}

function emptyDiv(divName){	
	$(divName).innerHTML = '';
	$(divName).style.backgroundColor = '#FFFFFF';
	$(divName).className = "";
}

function msgDelRes(){
	if(objAjax1.readyState==4 && objAjax1.status==200){
		$('deldiv').style.backgroundColor = '#EEEEEE';
		$('deldiv').className = "brdr tlleft pad10";
		$('deldiv').innerHTML = objAjax1.responseText;
		msg_loadprofiles(myhome_cur_pg);
	}else{
		$('deldiv').innerHTML = '<img src="'+imgs_url+'/small-loading.gif" height="25" width="80">';
	}
}

function showDecDiv(decmsgid, subfl){
	curinnerno = viewrec;
	url		= ser_url+'/mymessages/msgdecline.php?rno='+Math.random();
	param	= 'msgid='+decmsgid;
	if(subfl == 'S'){
		param	+= '&decSubmit=yes';
	}
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,msgCallRes,objAjax1);
}

function hide_box_msg(){
hide_box_div('div_box'+viewrec);
}


function showRlyDiv(){
txtdivname = 'msgdispdiv'+viewrec; 
replyDiv = 'replyDiv'+viewrec;
$(replyDiv).style.display="block";
$(txtdivname).style.display="none";
}


function msgalertRes()
{
	innerresdiv = 'msgactpart'+curinnerno;
	$(innerresdiv).innerHTML = '<div class="fright"><img src="'+imgs_url+'/close.gif" onclick="hide_box_msg();" href="javascript:;" class="pntr" /></div><br clear="all"/>Please type your message...<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box_msg();"/></div>';
}


function RTESubmit(replyfl) {
	parentIfr   = 'parentrte'+viewrec;
	txtareaname = 'msgtxtarea'+viewrec;
	var oRTE = $(parentIfr);
	TempTextArr = new Array();
	TempText    = oRTE.contentWindow.document.getElementById(txtareaname).value;
	if(replyfl == ''){
		TempTextArr[0] = TempText;
	}else{
	TempTextArr = TempText.split("----- Original Message -----");
	}
	
	TempTextArr[0] = trim(TempTextArr[0]);
	TempTextArr[0] = TempTextArr[0].replace(/\s+$/,"");
	TempTextArr[0] = TempTextArr[0].replace(/[&]/g,"~^~");
	TempTextArr[0] = trim(TempTextArr[0], "\\n");
	TempTextArr[0] = trim(TempTextArr[0], "\r\n");
	TempTextArr[0] = trim(TempTextArr[0], "<BR>");

	if(TempTextArr[0] == "" || TempTextArr[0] == "Type Message Here..") {
		if(replyfl == ''){
			oRTE.contentWindow.document.getElementById(txtareaname).value = 'Type Message Here..';
		}else{
			oldTxtAreavalue = 'Type Message Here..'+"\n";
			for(i=1;i<TempTextArr.length;i++){
				oldTxtAreavalue += "----- Original Message -----"+TempTextArr[i];
			}
			oRTE.contentWindow.document.getElementById(txtareaname).value = oldTxtAreavalue;
		}
		curinnerno = viewrec;
		msgalertRes();
	}else {
		url		= ser_url+'/mymessages/sendmailsubmit.php?rno='+Math.random();
		rpmsgid = oRTE.contentWindow.document.contactform.repmsgid.value;
		param	= 'msgTxt='+TempTextArr[0]+'&msgSubmit=yes&msgid='+rpmsgid+'&oppids='+curroppid;
		objAjax1 = AjaxCall();
		curinnerno = viewrec;
		AjaxPostReq(url,param,msgCallRes,objAjax1);

		//hide sendmail reichtext & interest option
		replyDiv = 'replyDiv'+viewrec;
		if(VPRefresh==''){
		$(replyDiv).style.display = 'none';
		}

		oRTE.contentWindow.document.getElementById(txtareaname).value = 'Type Message Here..';
	}
}

function RTESubmitold(replyfl) {
	parentIfr = 'parentrte'+viewrec;
	var oRTE = $(parentIfr);
	rteName  = 'rte'+viewrec; 
	TempTextArr = new Array();
	TempText = oRTE.contentWindow.frames[rteName].document.body.innerHTML;
	oRTE.contentWindow.frames[rteName].document.body.innerHTML = "Type Message Here.."
	if(replyfl == ''){
		TempTextArr[0] = TempText;
	}else{
	TempTextArr = TempText.split("----- Original Message -----");
	}
	
	TempTextArr[0] = trim(TempTextArr[0]);
	TempTextArr[0] = trim(TempTextArr[0], '\r\n');
	TempTextArr[0] = trim(TempTextArr[0], '<BR>');
	

	if(TempTextArr[0] == "" || TempTextArr[0] == "Type Message Here..") {
		err = 'msgactpart'+viewrec;
		$(err).innerHTML = '<div class="fright"><img src="'+imgs_url+'/close.gif" onclick="hide_box_msg();" href="javascript:;" class="pntr" /></div><br clear="all"/>Please type your message<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box_msg();"/></div>';
	}else {
		url		= ser_url+'/mymessages/sendmailsubmit.php?rno='+Math.random();
		rpmsgid = oRTE.contentWindow.document.contactform.repmsgid.value;
		param	= 'msgTxt='+TempTextArr[0]+'&msgSubmit=yes&msgid='+rpmsgid+'&oppids='+curroppid;
		objAjax1 = AjaxCall();
		curinnerno = viewrec;
		AjaxPostReq(url,param,msgCallRes,objAjax1);

		//hide sendmail reichtext & interest option
		replyDiv = 'replyDiv'+viewrec;
		$(replyDiv).style.display = 'none';
	}
}

function focus(){ 
	if($("rte") != null){
		if (navigator.appName != 'Microsoft Internet Explorer') { document.contactform.rte.focus(); } 
	}	
} 
function setcursor(el,st,end) {		
	try{
		if(el.setSelectionRange) { 
			el.focus();
			el.setSelectionRange(st,end);
		}
		else {
			if(el.createTextRange) {
			range=el.createTextRange();
			range.collapse(true);
			range.moveEnd('character',end);
			range.moveStart('character',st);
			range.select();
			}
		}
	}catch(e){ }
}