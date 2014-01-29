var objAjax1 = null;
function successPost() {
	objAjax1 = AjaxCall();
	var argUrl = '/successstory/successpost.php'; 
	AjaxGetReq(argUrl,successPostDiv,objAjax1); 
}
function successPostDiv() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('success_content_2').style.display = "block";$('success_content_1').style.display = "none";$('success_content_2').innerHTML = objAjax1.responseText;
	 } else alert('There was a problem with the request.'); }
}
var parameters="";var successFctn="";var successPostFctn="";
function successvalidate(){
	var sucfrm = document.frmSuccess;
	if(IsEmpty(sucfrm.bridename,"text")) {
	$('bridenamespan').innerHTML="Enter bride name";sucfrm.bridename.focus();return false;
	} else { $('bridenamespan').innerHTML="&nbsp"; }
	if(IsEmpty(sucfrm.groomname,"text")) {
	$('groomnamespan').innerHTML="Enter groom name";sucfrm.groomname.focus();return false;
	} else { $('groomnamespan').innerHTML="&nbsp"; }
	if(IsEmpty(sucfrm.matid,"text")) {
	$('matidspan').innerHTML="Enter matrimony id";sucfrm.matid.focus();return false;
	} else { $('matidspan').innerHTML="&nbsp";}
	if(IsEmpty(sucfrm.matEmail,"text")){
	$('matEmailspan').innerHTML="Enter your email id";sucfrm.matEmail.focus();return false;
	} else { $('matEmailspan').innerHTML="&nbsp"; }
	if(!ValidateEmail(sucfrm.matEmail.value)) {
		$('matEmailspan').innerHTML="Invalid email-id";sucfrm.matEmail.focus();return false;
	} else { $('matEmailspan').innerHTML="&nbsp"; }
	
	if(sucfrm.succphoto.value!='') {
		var varFrm = sucfrm;var extPos = varFrm.succphoto.value.lastIndexOf( "." );
		if (extPos == - 1) {
			$('upPhotoSpan').innerHTML="Only gif or jpg files can be added";varFrm.succphoto.focus();return false;
		} else {
			var extn =  varFrm.succphoto.value.substring(extPos + 1, varFrm.succphoto.value.length);
			if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" ) {
				$('upPhotoSpan').innerHTML="Only gif or jpg files can be added";
				varFrm.succphoto.value= "";
				varFrm.succphoto.focus();
				return false; }
		}
	} 
	if(IsEmpty(sucfrm.succtel,"text")) {
	$('succtelspan').innerHTML="Enter your telephone number ";sucfrm.succtel.focus();return false;
	} else if(!ValidateNo(sucfrm.succtel.value,"0123456789")) {
	$('succtelspan').innerHTML="Invalid telephone number ";sucfrm.succtel.value='';sucfrm.succtel.focus();return false;
	} else { $('succtelspan').innerHTML="&nbsp"; }
	if(IsEmpty(sucfrm.succStory,"textarea")) {
	$('succStoryspan').innerHTML="Enter your success story";sucfrm.succStory.focus();return false;
	} else { $('succStoryspan').innerHTML="&nbsp"; }
	return true;
}
function emailFwdvalidate() {
	var frmmailfwd = document.frmEmailFwd;
	if(IsEmpty(frmmailfwd.frndname1,"text")) {
		$('emailerrmsgnam1').innerHTML="Enter friend name";frmmailfwd.frndname1.focus();return false;
	} else{$('emailerrmsgnam1').innerHTML="&nbsp"; }
	if(IsEmpty(frmmailfwd.frndemail1,"text")){
		$('emailerrmsgemail1').innerHTML="Enter friend's email id";frmmailfwd.frndemail1.focus();return false;
	} else if(!ValidateEmail(frmmailfwd.frndemail1.value)){
		$('emailerrmsgemail1').innerHTML="Invalid email id";frmmailfwd.frndemail1.focus();return false;
	} else{ $('emailerrmsgemail1').innerHTML="&nbsp"; }
	if(!IsEmpty(frmmailfwd.frndname2,"text") || !IsEmpty(frmmailfwd.frndemail2,"text")){
		if(IsEmpty(frmmailfwd.frndname2,"text")){
			$('emailerrmsgnam2').innerHTML="Enter friend name";frmmailfwd.frndname2.focus();return false;
		} else{$('emailerrmsgnam2').innerHTML="&nbsp"; }
		if(IsEmpty(frmmailfwd.frndemail2,"text")){
			$('emailerrmsgemail2').innerHTML="Enter friend's email id";frmmailfwd.frndemail2.focus();return false;
		} else if(!ValidateEmail(frmmailfwd.frndemail2.value)){
			$('emailerrmsgemail2').innerHTML="Invalid email id";frmmailfwd.frndemail2.focus();return false;
		} else{ $('emailerrmsgemail2').innerHTML="&nbsp"; }
	} if(!IsEmpty(frmmailfwd.frndname3,"text") || !IsEmpty(frmmailfwd.frndemail3,"text")){
		if(IsEmpty(frmmailfwd.frndname3,"text")){
			$('emailerrmsgnam3').innerHTML="Enter friend name";frmmailfwd.frndname3.focus();return false;
		} else{$('emailerrmsgnam3').innerHTML="&nbsp"; }
		if(IsEmpty(frmmailfwd.frndemail3,"text")){
			$('emailerrmsgemail3').innerHTML="Enter friend's email id";frmmailfwd.frndemail3.focus();return false;
		} else if(!ValidateEmail(frmmailfwd.frndemail3.value)){
			$('emailerrmsgemail3').innerHTML="Invalid email id";frmmailfwd.frndemail3.focus();return false;
		} else{ $('emailerrmsgemail3').innerHTML="&nbsp"; }
	} if(!IsEmpty(frmmailfwd.frndname4,"text") || !IsEmpty(frmmailfwd.frndemail4,"text")) {
		if(IsEmpty(frmmailfwd.frndname4,"text")) {
			$('emailerrmsgnam4').innerHTML="Enter friend name";frmmailfwd.frndname4.focus();return false;
		} else{$('emailerrmsgnam4').innerHTML="&nbsp"; }
		if(IsEmpty(frmmailfwd.frndemail4,"text")) {
			$('emailerrmsgemail4').innerHTML="Enter friend's email id";frmmailfwd.frndemail4.focus();return false;
		} else if(!ValidateEmail(frmmailfwd.frndemail4.value)) {
			$('emailerrmsgemail4').innerHTML="Invalid email id.";frmmailfwd.frndemail4.focus();return false;
		} else{ $('emailerrmsgemail4').innerHTML="&nbsp"; }
	} if(!IsEmpty(frmmailfwd.frndname5,"text") || !IsEmpty(frmmailfwd.frndemail5,"text")) {
		if(IsEmpty(frmmailfwd.frndname5,"text")) {
			$('emailerrmsgnam5').innerHTML="Enter friend name";frmmailfwd.frndname5.focus();return false;
		} else{$('emailerrmsgnam5').innerHTML="&nbsp"; }
		if(IsEmpty(frmmailfwd.frndemail5,"text")){
			$('emailerrmsgemail5').innerHTML="Enter friend's email id";frmmailfwd.frndemail5.focus();return false;
		} else if(!ValidateEmail(frmmailfwd.frndemail5.value)){
			$('emailerrmsgemail5').innerHTML="Invalid email id";frmmailfwd.frndemail5.focus();return false;
		} else{ $('emailerrmsgemail5').innerHTML="&nbsp"; }
	} return true;
}
function addrvalidate() {
	var succaddfrm = document.successAddrForm;
	if(IsEmpty(succaddfrm.succaddress,"textarea")) {
	$('succaddressspan').innerHTML="Enter your contact address ";succaddfrm.succaddress.focus();return false;
	} else { $('succaddressspan').innerHTML="&nbsp"; }	
	if(IsEmpty(succaddfrm.succtel,"text")) {
	$('succtelspan').innerHTML="Enter your telephone number ";succaddfrm.succtel.focus();return false;
	} else if(!ValidateNo(succaddfrm.succtel.value,"0123456789")) {
	$('succtelspan').innerHTML="Invalid telephone number ";succaddfrm.succtel.focus();return false;
	} else { $('succtelspan').innerHTML="&nbsp"; }
	return true;
}
function photouploadval() {
	var varFrm = document.frmSuccess;var extPos = varFrm.succphoto.value.lastIndexOf( "." );
	if (extPos == - 1) {
		$('upPhotoSpan').innerHTML="Only gif or jpg files can be added into your success story";varFrm.succphoto.focus();return false;
	} else {
		var extn =  varFrm.succphoto.value.substring(extPos + 1, varFrm.succphoto.value.length);
		if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" )
		{
			$('upPhotoSpan').innerHTML="Only gif or jpg files can be added into your success story";
			varFrm.succphoto.value= "";
			varFrm.succphoto.focus();
			return false; }
	} return true;
}
function showImg(e,argMatriId)
{
	var posi = new Array();
	posi=trackClick(e);
	var enlargeshowId = 'imgdiv'+argMatriId;
	document.getElementById(enlargeshowId).style.display='block';
	document.getElementById(enlargeshowId).style.position='absolute';
	document.getElementById(enlargeshowId).style.left=(posi[0]+20)+"px";	
	document.getElementById(enlargeshowId).style.top=posi[1]+"px";
	document.getElementById(enlargeshowId).style.padding="5px";
	document.getElementById(enlargeshowId).style.background="#FFFFFF";
	document.getElementById(enlargeshowId).style.border="solid 1px #CCCCCC";
}
function hideImg(argMatriId) { 
	var enlargeHideId = "imgdiv"+argMatriId;
	document.getElementById(enlargeHideId).style.display='none';  
}
function trackClick(e) {
	var posi = new Array();
	if (arguments.length == 0) e = event;
	if (document.layers)
	{
		posi[0]=e.pageX;
		posi[1]=e.pageY;
	}
	else
	{
		posi[0]=e.clientX+document.body.scrollLeft;
		posi[1]=e.clientY+document.body.scrollTop;
	}
	return posi;
}
var argPage=1;
function succprev()
{
	argPage--;
	var pagePrev = argPage;
	var dispPage = (pagePrev<=1)?1:pagePrev;
	objAjax1 = AjaxCall();
	if(dispPage==1) {
		$('nxtoff').style.display = 'none';$('nxton').style.display = 'block';$('prevoff').style.display = 'block';$('prevon').style.display = 'none';
		$('nxtoff1').style.display = 'none';$('nxton1').style.display = 'block';$('prevoff1').style.display = 'block';$('prevon1').style.display = 'none';
	} else {
		$('nxtoff').style.display = 'none';$('nxton').style.display = 'block';$('prevoff').style.display = 'none';$('prevon').style.display = 'block';
		$('nxtoff1').style.display = 'none';$('nxton1').style.display = 'block';$('prevoff1').style.display = 'none';$('prevon1').style.display = 'block';
	}
	var argUrl = '/successstory/success'+dispPage+'.php'; 
	AjaxGetReq(argUrl,successStor,objAjax1); 
}
function succnxt()
{
	argPage++;
	var pageNxt = argPage;
	var dispNxt = (pageNxt>=5)?4:pageNxt;
	objAjax1 = AjaxCall();
	if(dispNxt==4) {
		$('nxtoff').style.display = 'block';$('nxton').style.display = 'none';$('prevoff').style.display = 'none';$('prevon').style.display = 'block';
		$('nxtoff1').style.display = 'block';$('nxton1').style.display = 'none';$('prevoff1').style.display = 'none';$('prevon1').style.display = 'block';
	} else {
		$('nxtoff').style.display = 'none';$('nxton').style.display = 'block';$('prevoff').style.display = 'none';$('prevon').style.display = 'block';
		$('nxtoff1').style.display = 'none';$('nxton1').style.display = 'block';$('prevoff1').style.display = 'none';$('prevon1').style.display = 'block';
	}
	var argUrl = '/successstory/success'+dispNxt+'.php'; 
	AjaxGetReq(argUrl,successStor,objAjax1); 
}//hideImg
function successStor() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('success_content_2').style.display = "none";$('success_content_1').style.display = "block";
		$('syeartab_content_1').style.display = "block";
		 $('successstories').innerHTML = objAjax1.responseText;
	 } else alert('There was a problem with the request.'); }
}

