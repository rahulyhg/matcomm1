var parameters="";var objAjax1=null;
function inviterefvalidate() {
	var invfrm = document.inviteRef;
	if(IsEmpty(invfrm.memberName,"text")) {
	$('memberNamespan').innerHTML="Enter your name";invfrm.memberName.value='';invfrm.memberName.focus();return false;
	} else { $('memberNamespan').innerHTML="&nbsp"; }
	if(IsEmpty(invfrm.refereename,"text")) {
	$('refereenamespan').innerHTML="Enter referee's name";invfrm.refereename.value='';invfrm.refereename.focus();return false;
	} else { $('refereenamespan').innerHTML="&nbsp"; }
	if(invfrm.relationship.selectedIndex == 0 ) {
	$('relationshipspan').innerHTML="Select your relationship";invfrm.relationship.focus();return false;
	} else { $('relationshipspan').innerHTML="&nbsp";}
	if(IsEmpty(invfrm.refereeemailid,"text")) {
	$('refereeemailidspan').innerHTML="Enter referee's email-id";invfrm.refereeemailid.value='';invfrm.refereeemailid.focus();return false;
	} else { $('refereeemailidspan').innerHTML="&nbsp"; } 
	if(!ValidateEmail(invfrm.refereeemailid.value)) {
		$('refereeemailidspan').innerHTML="Invalid email-id";
		invfrm.refereeemailid.focus();
		return false;
	} else { $('refereeemailidspan').innerHTML="&nbsp"; }
	if (IsEmpty(invfrm.membercomments,'textarea')) {
	$('membercommentsspan').innerHTML="Enter your comments";invfrm.membercomments.value='';invfrm.membercomments.focus();return false;
	} else { $('membercommentsspan').innerHTML="&nbsp"; }
	return true;
}
function emailvalid() {
	var invtfrm = document.inviteRef;
	if(IsEmpty(invtfrm.refereeemailid,"text")) {
		$('refereeemailidspan').innerHTML="Enter referee's email-id";return false;
	} else if(!ValidateEmail(invtfrm.refereeemailid.value)) {
		$('refereeemailidspan').innerHTML="Invalid email-id";
		return false;
	} else { $('refereeemailidspan').innerHTML="&nbsp"; }
}
function agevalid() {
	var addfrmref = document.addRef;
	if(IsEmpty(addfrmref.refereeage,"text")) {
	$('refereeagespan').innerHTML="Enter referee's age";return false;
	} else if(!ValidateNo(addfrmref.refereeage.value,"1234567890")) {
	$('refereeagespan').innerHTML="Invalid age";return false;
	} else if(addfrmref.refereeage.value<18) {
	$('refereeagespan').innerHTML="Invalid age";return false;
	} else{ $('refereeagespan').innerHTML="&nbsp"; }
}
function phoneemailvalid() {
	var phnaddr = document.addRef;
	if (IsEmpty(phnaddr.refereeemail,'text') && IsEmpty(phnaddr.refereephone,'text')) {
	$('refereeemailspan').innerHTML="Enter referee's email-id / phone no";return false; 
	} else if (!IsEmpty(phnaddr.refereeemail,'text') && !ValidateEmail(phnaddr.refereeemail.value)) {
	$('refereeemailspan').innerHTML="Invalid e-mail";return false;
	} else { $('refereeemailspan').innerHTML="&nbsp"; }
}
function addrefvalidate() {
	var addreffrm = document.addRef;
	if(IsEmpty(addreffrm.refName,"text")) {
	$('refNamespan').innerHTML="Enter referee's name";addreffrm.refName.value='';addreffrm.refName.focus();return false;
	} else { $('refNamespan').innerHTML="&nbsp"; }
	if(IsEmpty(addreffrm.refereeage,"text")) {
	$('refereeagespan').innerHTML="Enter referee's age";addreffrm.refereeage.value='';addreffrm.refereeage.focus();return false;
	} else if(!ValidateNo(addreffrm.refereeage.value,"1234567890")) {
	$('refereeagespan').innerHTML="Invalid age";addreffrm.refereeage.value='';addreffrm.refereeage.focus();return false;
	} else if(addreffrm.refereeage.value<18) {
	$('refereeagespan').innerHTML="Invalid age";addreffrm.refereeage.value='';addreffrm.refereeage.focus();return false;
	} else{ $('refereeagespan').innerHTML="&nbsp"; }
	if(addreffrm.refereeage.value<18) {
	$('refereeagespan').innerHTML="Invalid age";addreffrm.refereeage.value='';addreffrm.refereeage.focus();return false;
	} else { $('refereeagespan').innerHTML="&nbsp"; }
	if(!addreffrm.refereegender[0].checked && !addreffrm.refereegender[1].checked) {
	$('refereegenderspan').innerHTML="Select  gender";addreffrm.refereegender[0].value="";addreffrm.refereegender[0].focus();return false;
	} else { $('refereegenderspan').innerHTML="&nbsp"; }
	if(addreffrm.relations.selectedIndex == 0 ) {
	$('relationsspan').innerHTML="Select your relationship";addreffrm.relations.focus();return false;
	} else { $('relationsspan').innerHTML="&nbsp"; }
	if (IsEmpty(addreffrm.membercomment,'textarea')) {
	$('membercommentspan').innerHTML="Enter your comments";addreffrm.membercomment.value='';addreffrm.membercomment.focus();return false;
	} else { $('membercommentspan').innerHTML="&nbsp"; }
	if(addreffrm.duration.selectedIndex == 0 ) {
	$('durationspan').innerHTML="Select no of years";addreffrm.duration.focus();return false;
	} else { $('durationspan').innerHTML="&nbsp"; }
	if (IsEmpty(addreffrm.refereeemail,'text') && IsEmpty(addreffrm.refereephone,'text')) {
	$('refereeemailspan').innerHTML="Enter referee's email-id / phone no";addreffrm.refereeemail.value='';addreffrm.refereeemail.focus();return false;
	} else if (!IsEmpty(addreffrm.refereeemail,'text') && !ValidateEmail(addreffrm.refereeemail.value)) {
	$('refereeemailspan').innerHTML="Invalid e-mail";addreffrm.refereeemail.focus();return false;
	} else { $('refereeemailspan').innerHTML="&nbsp"; }
	if (!IsEmpty(addreffrm.refereephone,'text') && !ValidateNo(addreffrm.refereephone.value,"1234567890 -")) {
	$('refereephonespan').innerHTML="Invalid phone/mobile number";addreffrm.refereephone.focus();return false;
	} else { $('refereephonespan').innerHTML="&nbsp"; }
	return true;
}
function fadecall() {
	if(inviterefvalidate()) {
		frmInvite = document.inviteRef;
		var domainNam	= frmInvite.domain.value;
		parameters = 'memberName='+frmInvite.memberName.value+'&refereename='+frmInvite.refereename.value+'&relationship='+frmInvite.relationship.value+'&refereeemailid='+frmInvite.refereeemailid.value+'&membercomments='+frmInvite.membercomments.value+'&inviteRefSubmit='+frmInvite.inviteRefSubmit.value;
		window.parent.document.getElementById('refframe').height = 140;
		document.getElementById('mathome').style.height = '160px';
		window.parent.document.getElementById('referencedispdiv').style.height = '160px';
		objAjax1 = AjaxCall();
		var argUrl = '/reference/reference.php?rf='+genNumbers();
		AjaxPostReq(argUrl,parameters,replaceDiv,objAjax1); 
	}
}
function fadecalladd() {
	if(addrefvalidate()) {
		frmAdd = document.addRef;
		var domainNam	= frmAdd.domain.value;
		var postgen = (frmAdd.refereegender[0].checked==true)?'M':'F';
		parameters = 'refereename='+frmAdd.refName.value+'&refereegender='+postgen+'&refereeage='+frmAdd.refereeage.value+'&relationship='+frmAdd.relations.value+'&refereeemailid='+frmAdd.refereeemail.value+'&membercomments='+frmAdd.membercomment.value+'&duration='+frmAdd.duration.value+'&refereephone='+frmAdd.refereephone.value+'&addRefSubmit='+frmAdd.addRefSubmit.value;
		window.parent.document.getElementById('refframe').height = 170;
		document.getElementById('mathome').style.height = '190px';
		window.parent.document.getElementById('referencedispdiv').style.height = '190px';
		objAjax1 = AjaxCall();
		var argUrl = '/reference/reference.php?rf='+genNumbers();
		AjaxPostReq(argUrl,parameters,replaceDiv,objAjax1); 
	}
}

function closecall(argPath,argP) {
	window.parent.document.getElementById('refframe').height = 715;
	window.parent.document.getElementById('referencedispdiv').style.height = '715px';
	objAjax1 = AjaxCall();
	if(argP==2) { var frmUrl = argPath+'/reference/reference.php?vt=2'; }
	else { var frmUrl = argPath+'/reference/reference.php?rf='+genNumbers(); }
	AjaxGetReq(frmUrl,replaceDiv,objAjax1);
}
function opendel(argPath,argMatriId,argRefId) {
	objAjax1 = AjaxCall();
	var frmUrl = argPath+'/reference/reference.php?vt=3&del=del&matid='+argMatriId+'&refid='+argRefId; 
	AjaxGetReq(frmUrl,replaceDiv,objAjax1);
}
function opendelpop(argPath,argMatriId,argRefId) {
	objAjax1 = AjaxCall();
	var frmUrl = argPath+'/reference/refdelete.php?matid='+argMatriId+'&refid='+argRefId; 
	AjaxGetReq(frmUrl,refDiv,objAjax1);
}
function openrefdet(argPath,argMatriId,argRefId) {
	objAjax1 = AjaxCall();
	var frmUrl = argPath+'/reference/refereedetails.php?matid='+argMatriId+'&refid='+argRefId; 
	AjaxGetReq(frmUrl,refDiv,objAjax1);
}
function setDiv() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('innerfade').style.display='block';
		 $('setcont').style.display='block';
		 innerll('setcont');
		 $('privSetShow').style.display = "block";
		 $('protectRef').style.display = "none";
		 $('privsetcont').style.display = "block";
		 $('privsetcont').innerHTML = "";
		 $('privsetcont').innerHTML = objAjax1.responseText;

	 } else 
		 alert('There was a problem with the request.');}
}
function refDiv() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('refcont').style.display = "block";
		 $('refcont').innerHTML = "";
		 $('refcont').innerHTML = objAjax1.responseText;

	 } else 
		 alert('There was a problem with the request.');}
}
function replaceDiv() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('mathome').style.display = "block";
		 $('mathome').innerHTML = "";
		 $('mathome').innerHTML = objAjax1.responseText;
	 } else 
	 alert('There was a problem with the request.');}else{
		 $('mathome').innerHTML = '<table border="0" cellpadding=0 cellspacing=0 align="center" width="100%" height="100%"><tr><td height="100%" align="center"><img src="http://img.jainmatrimony.com/images/loading-icon.gif" alt="" border="0" /></td></tr></table>';
	 }

}
function clickTab(tabNo,tabTotal,tabName)
{
	var cur_act	= tabName+"link"+tabNo+"_active";
	var cur_inact = tabName+"link"+tabNo+"_inactive";
	var cur_tab	= tabName+tabNo;
	var cur_cont = tabName+"_content_"+tabNo;
	document.getElementById(cur_act).style.display='block';
	document.getElementById(cur_inact).style.display='none';
	document.getElementById(cur_cont).style.display='block';
	for(i=1;i<=tabTotal;i++) {
		if(i != tabNo) {
			var oth_act = tabName+"link"+i+"_active";
			var oth_inact = tabName+"link"+i+"_inactive";
			var oth_cont = tabName+"_content_"+i;
			var oth_tab	= tabName+i;
			document.getElementById(oth_act).style.display='none';
			document.getElementById(oth_cont).style.display='none';
			document.getElementById(oth_inact).style.display='block';
			}
		}
}
function privsetcall(argPath){
	var argVal = 0;
	if(document.privSet.refsettype[0].checked==true) { argVal = 1; }
	else if(document.privSet.refsettype[1].checked==true) { argVal = 2; }
	else if(document.privSet.refsettype[2].checked==true) { argVal = 3; }
	$('errMsg').innerHTML = '';
	if(privsetvalidate(argVal)) {
		objAjax1 = AjaxCall();
		if(argVal==3) {
			if(passwordvalidate()) {
			var pass1 = document.frmRefProtect.refpassword.value;
			var frmUrl = argPath+'/reference/referencesettings.php?setid=3&gn='+genNumbers()+'&pwd='+pass1;  }
			else{ return false;}
		} else { var frmUrl = argPath+'/reference/referencesettings.php?setid='+argVal+'&gn='+genNumbers(); }
		AjaxGetReq(frmUrl,setDiv,objAjax1);
	}
}
function protectrefcall(argPath) {
	var pass1 = document.frmRefProtect.refpassword.value;
	//if(passwordvalidate()) {
	objAjax1 = AjaxCall();
	var frmUrl = argPath+'/reference/referencesettings.php?setid=3&gn='+genNumbers()+'&pwd='+pass1; 
	AjaxGetReq(frmUrl,setDiv,objAjax1); //}
}
function privsetvalidate(argVal){
	if (argVal==0){
		$('errMsg').innerHTML = 'Please set your privacy settings<br>';
		document.privSet.refsettype[0].focus();
		return false;
	}return true;
}
function passwordvalidate(){
	var p1=document.frmRefProtect.refpassword.value;
	if (IsEmpty(document.frmRefProtect.refpassword,"text"))
	{ $('refpasswordspan').innerHTML = 'Enter your password';document.frmRefProtect.refpassword.focus();return false;}
	else if (p1.length<4)
	{ $('refpasswordspan').innerHTML = 'Password should be minimum of 4 characters';document.frmRefProtect.refpassword.focus();return false;}
	else if (IsEmpty(document.frmRefProtect.confirmpassword,"text"))
	{ $('confirmpasswordspan').innerHTML = 'Confirm your password';document.frmRefProtect.confirmpassword.focus();return false;}
	else if (document.frmRefProtect.confirmpassword.value!=document.frmRefProtect.refpassword.value)
	{ $('confirmpasswordspan').innerHTML = 'Password varies';document.frmRefProtect.confirmpassword.focus();return false;}
	else { $('confirmpasswordspan').innerHTML = '';$('refpasswordspan').innerHTML = ''; return true;}
}