var viewrec,objAjax1,prev_divno='',previnnerdiv='',curroppid='', curinnerno='';

function intDecCall(vmsgid, currvno, decfl){
	curinnerno = currvno;
	url		= ser_url+'/mymessages/interestdecline.php?rno='+Math.random();
	param	= 'iid='+vmsgid+'&currno='+currvno;
	param += '&declineopt=1&frmDecSubmit=yes';
	/*if(decfl=='1'){
	decopt = getRadioValue(document.frmDec.declinedopt);
	param += '&declineopt='+decopt+'&frmDecSubmit=yes';
	}*/
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,msgCallRes,objAjax1);
	txtdivname = 'msgdispdiv'+viewrec;
	$(txtdivname).style.display="none";
}

function gotomsgrec(){
	window.location.href	= ser_url+'/mymessages/';
}

function intAccCall(vmsgid, currvno){
	curinnerno = currvno;
	url		= ser_url+'/mymessages/interestaccept.php?rno='+Math.random();
	param	= 'iid='+vmsgid+'&currno='+currvno;
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,msgCallRes,objAjax1);
	txtdivname = 'msgdispdiv'+viewrec;
	$(txtdivname).style.display="none";
}

function sendreminder(msgfl, vmsgid, currvno){
	curinnerno = currvno;
	url		= ser_url+'/mymessages/sendreminder.php?rno='+Math.random();
	param	= 'msgfl='+msgfl+'&msgid='+vmsgid+'&currno='+currvno;
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,msgCallRes,objAjax1);
}

function msgCallRes()
{
	innerresdiv = 'msgactpart'+curinnerno;
	if(objAjax1.readyState == 4){
	$(innerresdiv).innerHTML = objAjax1.responseText;
	replyDiv = 'replyDiv'+curinnerno;
	$(replyDiv).style.display = 'none';
	}else{
	$(innerresdiv).innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function reloadMsg(){
}

function getViewProfile(viewid, viewrecno, msgfl, msgid, msgty)
{
	if(prev_divno==''){
		prev_divno = viewrecno;
	}else{
		prevcont_div = 'cont'+prev_divno;
		prevviewpro_div = 'viewpro'+prev_divno;
		$(prevcont_div).style.display="block";
		$(prevviewpro_div).style.display="none";
		prev_divno = viewrecno;
	}

	//for inner div like interst decline pg
	if(previnnerdiv!=''){hide_box_div(previnnerdiv);};

	cont_div	= 'cont'+viewrecno;
	viewpro_div = 'viewpro'+viewrecno;
	viewrec     = viewrecno;
	if(viewid!='' && cook_id!=''){
	curroppid = viewid;
	if($(viewpro_div).innerHTML!=''){
		$(cont_div).style.display="none";
		$(viewpro_div).style.display="block";
		$(viewrecno+'vtab1').onclick();
	}else{
	url		= ser_url+'/profiledetail/viewprofile.php?rno='+Math.random();
	param	= 'id='+viewid+'&msgid='+msgid+'&msgfl='+msgfl+'&cpno='+viewrecno+'&msgty='+msgty;
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,srchViewDisp,objAjax1);
	}
	}else{
	if(cook_id==''){
		$(viewpro_div).innerHTML = '<div class="brdr pad10 rpanelinner" style="width:"><div class="fright"><img src="'+imgs_url+'/close.gif" onclick="hide_alert();" href="javascript:;" class="pntr" /></div><br clear="all"/>Register free to view full profile details and to contact this member.<br clear="all"><a href="'+ser_url+'/register/" class="clr1">Click here to Register</a> or <a href="'+ser_url+'/login/" class="clr1">Login NOW.</a><div class="padt10">&nbsp;</div></div>';
	}else if(viewid==''){
		$(viewpro_div).innerHTML = '<div class="brdr pad10 rpanelinner" style="width:"><div class="fright"><img src="'+imgs_url+'/close.gif" onclick="hide_alert();" href="javascript:;" class="pntr" /></div><br clear="all"/>Profile is not available.<div class="padt10">&nbsp;</div></div>';
	}
	$(cont_div).style.display="none";
	$(viewpro_div).style.display="block";
	}
}

function hide_alert(){
	cont_div = 'cont'+viewrec;
	viewpro_div = 'viewpro'+viewrec;
	$(cont_div).style.display="block";
	$(viewpro_div).style.display="none"
}
function srchViewDisp()
{
	cont_div = 'cont'+viewrec;
	viewpro_div = 'viewpro'+viewrec;
	if(objAjax1.readyState == 4){
	$(viewpro_div).innerHTML = objAjax1.responseText;
	$(cont_div).style.display="none";
	$(viewpro_div).style.display="block";
	} else {
		$(viewpro_div).innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function closeViewDisp(currrecno)
{
	cont_div = 'cont'+currrecno;
	viewpro_div = 'viewpro'+currrecno;
	$(cont_div).style.display="block";
	$(viewpro_div).style.display="none";
}