var parameters="";var objAjax1=null;
function agevalidate(){
	var mailfrm = document.addRefMail;
	if(IsEmpty(mailfrm.age,"text")){
	$('agespan').innerHTML="Enter referee's age";return false;
	} else if(!ValidateNo(mailfrm.age.value,"1234567890")){
	$('agespan').innerHTML="Invalid age";return false;
	}else if(mailfrm.age.value<18){
	$('agespan').innerHTML="Invalid age";return false;
	}else{$('agespan').innerHTML="&nbsp";}
}
function phoneemailvalidate(){
	var addfrmmail = document.addRefMail;
	if (IsEmpty(addfrmmail.email,'text') && IsEmpty(addfrmmail.phone,'text')){
	$('emailspan').innerHTML="Enter your email-id / phone no";return false;
	}else if (!IsEmpty(addfrmmail.email,'text') && !ValidateEmail(addfrmmail.email.value)){
	$('emailspan').innerHTML="Invalid e-mail";return false;
	}else{$('emailspan').innerHTML="&nbsp";}
}
function mailrefvalidate(){
	var addfrmref =document.addRefMail;
	if(IsEmpty(addfrmref.Name,"text")){
	$('namespan').innerHTML="Enter your name";addfrmref.Name.value='';addfrmref.Name.focus();return false;
	}else{$('namespan').innerHTML="&nbsp";}
	if(IsEmpty(addfrmref.age,"text")){
	$('agespan').innerHTML="Enter referee's age";addfrmref.age.value='';addfrmref.age.focus();return false;
	} else if(!ValidateNo(addfrmref.age.value,"1234567890")){
	$('agespan').innerHTML="Invalid age";addfrmref.age.value='';addfrmref.age.focus();return false;
	}else if(addfrmref.age.value<18){
	$('agespan').innerHTML="Invalid age";addfrmref.age.value='';addfrmref.age.focus();return false;
	}else{$('agespan').innerHTML="&nbsp";}
	if(!addfrmref.gender[0].checked && !addfrmref.gender[1].checked){
	$('genderspan').innerHTML="Select  gender";addfrmref.gender[0].value="";addfrmref.gender[0].focus();return false;
	}else{$('genderspan').innerHTML="&nbsp";}
	if(addfrmref.duration.selectedIndex == 0 ){
	$('durationspan').innerHTML="Select no of years";addfrmref.duration.focus();return false;
	}else{$('durationspan').innerHTML="&nbsp";}
	if (IsEmpty(addfrmref.email,'text') && IsEmpty(addfrmref.phone,'text')){
	$('emailspan').innerHTML="Enter your email-id / phone no";addfrmref.email.value='';addfrmref.email.focus();return false;
	}else if (!IsEmpty(addfrmref.email,'text') && !ValidateEmail(addfrmref.email.value)){
	$('emailspan').innerHTML="Invalid e-mail";addfrmref.email.focus();return false;
	}else{$('emailspan').innerHTML="&nbsp";}
	if (!IsEmpty(addfrmref.phone,'text') && !ValidateNo(addfrmref.phone.value,"1234567890 -")){
	$('phonespan').innerHTML="Invalid phone/mobile number";addfrmref.phone.value="";addfrmref.phone.focus();return false;
	}else{$('phonespan').innerHTML="&nbsp";}
	if (IsEmpty(addfrmref.comments,'textarea')){
	$('commentsspan').innerHTML="Enter your comments";addfrmref.comments.value='';addfrmref.comments.focus();return false;
	}else{$('commentsspan').innerHTML="&nbsp";}
	addfrmref.postgender.value = addfrmref.gender[0].checked?'M':'F';
	return true;
}
function ajaxcall(){
	frmMailAdd = document.addRefMail;
	if(mailrefvalidate()){
		var gen = frmMailAdd.postgender.value;
		parameters = 'memName='+frmMailAdd.memName.value+'&Name='+frmMailAdd.Name.value+'&age='+frmMailAdd.age.value+'&refgender='+gen+'&email='+frmMailAdd.email.value+'&relations='+frmMailAdd.relationship.value+'&comments='+frmMailAdd.comments.value+'&duration='+frmMailAdd.duration.value+'&phone='+frmMailAdd.phone.value+'&addRefMailSubmit='+frmMailAdd.addRefMailSubmit.value+'&matriId='+frmMailAdd.matriId.value+'&refid='+frmMailAdd.refid.value+'&rej='+frmMailAdd.rej.value;
		var argUrl = frmMailAdd.domain.value+'/reference/referencemail.php';
		objAjax1 = AjaxCall();
		AjaxPostReq(argUrl,parameters,outputDiv,objAjax1);} 
}
function editcall(){
	frmMailAdd = document.editRef;
	if(editrefvalidate()){
		var refgen = frmMailAdd.refgender[0].checked?'M':'F';
		parameters = 'Name='+frmMailAdd.refName.value+'&age='+frmMailAdd.refereeage.value+'&refgender='+refgen+'&email='+frmMailAdd.refereeemail.value+'&relations='+frmMailAdd.relations.value+'&comments='+frmMailAdd.membercomment.value+'&duration='+frmMailAdd.duration.value+'&phone='+frmMailAdd.refereephone.value+'&addRefMailSubmit='+frmMailAdd.editRefSubmit.value+'&refid='+frmMailAdd.refid.value;
		var argUrl = frmMailAdd.domain.value+'/reference/referencemail.php';
		objAjax1 = AjaxCall();
		AjaxPostReq(argUrl,parameters,resDiv,objAjax1);} 
}
function viewcall(){$('addRefRes').style.display = "none";$('viewRef').style.display = "block";}
function editRef(){$('viewRef').style.display = "none";$('addRefRes').style.display = "block";}
function resDiv(){
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200){
		 $('editcontent').innerHTML = objAjax1.responseText;
		 $('editcontent').style.display = "block";
	 }else alert('There was a problem with the request.');}
}
function editDiv(){$('viewcontent').style.display = "none";$('editcontent').style.display = "block";}
function outputDiv(){
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200){
		 $('viewRef').style.display = "none";
		 $('addRefRes').innerHTML = objAjax1.responseText;
		 $('addRefRes').style.display = "block";
	 }else  alert('There was a problem with the request.');}
}
function editrefvalidate(){
	var frmedt = document.editRef;
	if(IsEmpty(frmedt.refName,"text")){
	$('refNamespan').innerHTML="Enter referee's name";frmedt.refName.value='';frmedt.refName.focus();return false;
	}else{$('refNamespan').innerHTML="&nbsp";}
	if(IsEmpty(frmedt.refereeage,"text")){
	$('refereeagespan').innerHTML="Enter referee's age";frmedt.refereeage.value='';frmedt.refereeage.focus();return false;
	}else{$('refereeagespan').innerHTML="&nbsp";}
	if(!ValidateNo(frmedt.refereeage.value,"1234567890")){
	$('refereeagespan').innerHTML="Invalid age";frmedt.refereeage.value='';frmedt.refereeage.focus();return false;
	}else{$('refereeagespan').innerHTML="&nbsp";}
	if(frmedt.refereeage.value<18){
	$('refereeagespan').innerHTML="Invalid age";frmedt.refereeage.value='';frmedt.refereeage.focus();return false;
	}else{$('refereeagespan').innerHTML="&nbsp";}
	if(!frmedt.refgender[0].checked && !frmedt.refgender[1].checked){
	$('refereegenderspan').innerHTML="Select  gender";frmedt.refgender[0].value="";frmedt.refgender[0].focus();return false;
	}else{$('refereegenderspan').innerHTML="&nbsp";}
	if(frmedt.relations.selectedIndex == 0 ){
	$('relationsspan').innerHTML="Select your relationship";frmedt.relations.focus();return false;
	}else{$('relationsspan').innerHTML="&nbsp";}
	if (IsEmpty(frmedt.membercomment,'textarea')){
	$('membercommentspan').innerHTML="Enter your comments";frmedt.membercomment.value='';frmedt.membercomment.focus();return false;
	}else{$('membercommentspan').innerHTML="&nbsp";}
	if(frmedt.duration.selectedIndex == 0 ){
	$('durationspan').innerHTML="Select no of years";frmedt.duration.focus();return false;
	}else{$('durationspan').innerHTML="&nbsp";}
	if (IsEmpty(frmedt.refereeemail,'text') && IsEmpty(frmedt.refereephone,'text')){
	$('refereeemailspan').innerHTML="Enter referee's email-id / phone no";frmedt.refereeemail.value='';frmedt.refereeemail.focus();return false;
	}else{$('refereeemailspan').innerHTML="&nbsp";}
	if (!IsEmpty(frmedt.refereeemail,'text') && !ValidateEmail(frmedt.refereeemail.value)){
	$('refereeemailspan').innerHTML="Invalid e-mail";frmedt.refereeemail.value="";frmedt.refereeemail.focus();return false;
	}else{$('refereeemailspan').innerHTML="&nbsp";}
	if (!IsEmpty(frmedt.refereephone,'text') && !ValidateNo(frmedt.refereephone.value,"1234567890 -")){
	$('refereephonespan').innerHTML="Invalid phone/mobile number";frmedt.refereephone.value="";frmedt.refereephone.focus();return false;
	}else{$('refereephonespan').innerHTML="&nbsp";}
	return true;
}