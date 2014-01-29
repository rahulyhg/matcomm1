var objAjax1=null;
function showReferee(argMatriId,argRefid,argDomain){
	var argUrl = argDomain+'/reference/referenceview.php?id='+argMatriId+'&refid='+argRefid;
	objAjax1 = AjaxCall();
	AjaxGetReq(argUrl,viewReferee,objAjax1);
}
function viewReferee(){
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('showreferee').style.display = "block";
		 $('showreferee').innerHTML = objAjax1.responseText;
	 } else alert('There was a problem with the request.'); }
}
function funReferencePwdChk() {
	var funFormName = document.frmRefPwdChk;
	if (funFormName.refpassword.value == "" ) {
		$('errorMsg').innerHTML = 'Please enter Reference Password';
		funFormName.refpassword.focus( );
		return false;
	}
	return true;	
}
function funRefMsgChk() {
	var funRefMsg = document.frmRefCheck;
	if (funRefMsg.msgtoreferee.value == "" ) {
		$('msgcomment').innerHTML = 'Please enter Reference Message';
		funRefMsg.msgtoreferee.focus( );
		return false;
	}
	return true;	
}
function grantrefcall() {
	if(funReferencePwdChk()) {
	var refpwdOrg	= document.frmRefPwdChk.refpwd.value;
	var refPwdPost	= document.frmRefPwdChk.refpassword.value;
	if(refpwdOrg!=refPwdPost) {
		document.frmRefPwdChk.refpassword.value = "";
		$('errorMsg').innerHTML = 'You have provided an incorrect Matrimony Reference Password';
	} else {
		$('protect').style.display = "none";
		$('showDet').style.display = "block"; }
	}
}
function reqRegFrm() { $('sendMsgs').style.display = "block"; }
function mailRefSend(argDomain) {
	if(funRefMsgChk()) {
	var formName = document.frmRefCheck;
	argUrl = argDomain+'/reference/refsendmail.php';
	parameters = 'matid='+formName.matriid.value+'&refid='+formName.refid.value+'&msgtoreferee='+formName.msgtoreferee.value;
	objAjax1 = AjaxCall();
	AjaxPostReq(argUrl,parameters,mailDiv1,objAjax1);
	}
}
function mailDiv1() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('innerfade').style.display='block';
		 $('mailcont').style.display='block';
		 innerll('mailcont');
		 $('mailsentcont').style.display = "block";
		 $('mailsentcont').innerHTML = objAjax1.responseText;
	 } else 
		 alert('There was a problem with the request.'); }
}