var objAjax1=null;var parameters="";
function requestadd() {
	if(reqvalidate()) {
	frmreq = document.requestform;
	objAjax1 = AjaxCall();
	var domainNam = frmreq.domain.value;
	var reqid = frmreq.requestfor.value;
	var withoid = (frmreq.wid[0].checked==true)?1:((frmreq.wid[1].checked==true)?0:2);
	parameters = 'memid='+frmreq.memid.value+'&memuname='+frmreq.memuname.value+'&memname='+frmreq.memname.value+'&requestfor='+frmreq.requestfor.value+'&wid='+withoid+'&reqsub=yes';
	if(reqid==2) { parameters = parameters+'&chkrel='+frmreq.chkrelative.value+'&chkfrnd='+frmreq.chkfriend.value+'&chkcoll='+frmreq.chkcolleague.value; }
	var argUrl = domainNam+'/request/reqres.php?rq='+genNumbers();
	AjaxPostReq(argUrl,parameters,reqresDiv,objAjax1); 
	}
}
function reqresDiv() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('request').innerHTML = "";
		 $('request').style.display = "block";
		 $('request').innerHTML = objAjax1.responseText;
		window.parent.document.getElementById('icondiv').style.height = document.getElementById('request').offsetHeight+40+'px' ;
		window.parent.document.getElementById('iframeicon').height = document.getElementById('request').offsetHeight+40;
	 } else 
		 alert('There was a problem with the request.');}
}
function reqvalidate() {
	var reqFrm = document.requestform;
	var reqFor = reqFrm.requestfor.value;
	if(reqFor==2 && reqFrm.chkrelative.checked==false && reqFrm.chkfriend.checked==false && reqFrm.chkcolleague.checked==false) {
		$('thruerror2').innerHTML="Please choose whose reference you would like to view.";reqFrm.chkrelative.focus();return false;
	} else {
		$('thruerror2').innerHTML="";
	}
	if(reqFrm.wid[0].checked==false && reqFrm.wid[1].checked==false) {
		$('thruerror').innerHTML="Please choose the type of request you would like to send.";reqFrm.wid[0].focus();return false;
	} else {
		$('thruerror').innerHTML="";
	}
	return true;

}
