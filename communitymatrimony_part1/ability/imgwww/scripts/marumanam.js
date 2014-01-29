function mform_validate(){
	var mform = this.document.mform;
	if(IsEmpty(mform.name,"text")){
		$('namespan').innerHTML="Please enter the name";mform.name.value="";mform.name.focus();return false;
	}
	else{
		$('namespan').innerHTML="&nbsp";
	}
	if (!(IsEmpty(mform.cno,'text'))){
		if (!ValidateNo(mform.cno.value,'1234567890')){
			$('cnospan').innerHTML="Please enter a valid phone number";mform.cno.focus();return false;
		}
		else{$('cnospan').innerHTML="";}
	}
	if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(mform.email.value)) && !(IsEmpty(mform.email,'text')))
	{
		$('emailspan').innerHTML="Please enter a valid E-mail address";mform.email.focus();return false;
	}
	else{
		$('emailspan').innerHTML="";
	}
	if ((IsEmpty(mform.cno,'text')) && (IsEmpty(mform.email,'text'))) {
		if (mform.cno.value == ''){
			$('cnospan').innerHTML="Please enter a phone number or email";mform.cno.focus();return false;
		}
		else{$('cnospan').innerHTML="";}
	}
	return true;
}