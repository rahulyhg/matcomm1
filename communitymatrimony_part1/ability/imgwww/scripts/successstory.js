function successvalidate(){
	var sucfrm = document.frmSuccess;
	if(IsEmpty(sucfrm.bride,"text")) {
	$('bridenamespan').innerHTML="Enter bride name";sucfrm.bride.focus();return false;
	} else { $('bridenamespan').innerHTML=""; }

	if(IsEmpty(sucfrm.groom,"text")) {
	$('groomnamespan').innerHTML="Enter groom name";sucfrm.groom.focus();return false;
	} else { $('groomnamespan').innerHTML=""; }

	if(IsEmpty(sucfrm.matriid,"text")) {
	$('matidspan').innerHTML="Enter matrimony id";sucfrm.matriid.focus();return false;
	} else { 
		var matid_format = new RegExp("^[a-zA-Z]{3}[0-9]{6,8}$");
		if(matid_format.test(sucfrm.matriid.value)) {
			$('matidspan').innerHTML="";			
		} else {
			$('matidspan').innerHTML="Enter correct matrimony id";sucfrm.matriid.focus();
			return false;
		}
	}

	if(IsEmpty(sucfrm.email,"text")){
	$('matEmailspan').innerHTML="Enter your email id";sucfrm.email.focus();return false;
	} else { $('matEmailspan').innerHTML=""; }

	if(!ValidateEmail(sucfrm.email.value)) {
		$('matEmailspan').innerHTML="Invalid email-id";sucfrm.email.focus();return false;
	} else { $('matEmailspan').innerHTML="&nbsp"; }
	
	if(sucfrm.photo.value!='') {
		var varFrm = sucfrm;
		var extPos = varFrm.photo.value.lastIndexOf( "." );
		if (extPos == - 1) {
			$('upPhotoSpan').innerHTML="Only gif or jpg files can be added";varFrm.photo.focus();return false;
		} else {
			var extn =  varFrm.photo.value.substring(extPos + 1, varFrm.photo.value.length);
			if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" ) {
				$('upPhotoSpan').innerHTML="Only gif or jpg files can be added";
				varFrm.photo.value= "";
				varFrm.photo.focus();
				return false; }
		}
	} 

	if(IsEmpty(sucfrm.phone,"text")) {
	$('succtelspan').innerHTML="Enter your telephone number ";sucfrm.phone.focus();return false;
	} else if(!ValidateNo(sucfrm.phone.value,"0123456789")) {
	$('succtelspan').innerHTML="Invalid telephone number ";sucfrm.phone.value='';sucfrm.phone.focus();return false;
	} else { $('succtelspan').innerHTML=""; }

	if(IsEmpty(sucfrm.successstory,"textarea")) {
	$('succStoryspan').innerHTML="Enter your success story";sucfrm.successstory.focus();return false;
	} else { $('succStoryspan').innerHTML=""; }
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
	} 
	
	if(!IsEmpty(frmmailfwd.frndname3,"text") || !IsEmpty(frmmailfwd.frndemail3,"text")){
		if(IsEmpty(frmmailfwd.frndname3,"text")){
			$('emailerrmsgnam3').innerHTML="Enter friend name";frmmailfwd.frndname3.focus();return false;
		} else{$('emailerrmsgnam3').innerHTML="&nbsp"; }
		if(IsEmpty(frmmailfwd.frndemail3,"text")){
			$('emailerrmsgemail3').innerHTML="Enter friend's email id";frmmailfwd.frndemail3.focus();return false;
		} else if(!ValidateEmail(frmmailfwd.frndemail3.value)){
			$('emailerrmsgemail3').innerHTML="Invalid email id";frmmailfwd.frndemail3.focus();return false;
		} else{ $('emailerrmsgemail3').innerHTML="&nbsp"; }
	}
	
	if(!IsEmpty(frmmailfwd.frndname4,"text") || !IsEmpty(frmmailfwd.frndemail4,"text")) {
		if(IsEmpty(frmmailfwd.frndname4,"text")) {
			$('emailerrmsgnam4').innerHTML="Enter friend name";frmmailfwd.frndname4.focus();return false;
		} else{$('emailerrmsgnam4').innerHTML="&nbsp"; }
		if(IsEmpty(frmmailfwd.frndemail4,"text")) {
			$('emailerrmsgemail4').innerHTML="Enter friend's email id";frmmailfwd.frndemail4.focus();return false;
		} else if(!ValidateEmail(frmmailfwd.frndemail4.value)) {
			$('emailerrmsgemail4').innerHTML="Invalid email id.";frmmailfwd.frndemail4.focus();return false;
		} else{ $('emailerrmsgemail4').innerHTML="&nbsp"; }
	}
	
	if(!IsEmpty(frmmailfwd.frndname5,"text") || !IsEmpty(frmmailfwd.frndemail5,"text")) {
		if(IsEmpty(frmmailfwd.frndname5,"text")) {
			$('emailerrmsgnam5').innerHTML="Enter friend name";frmmailfwd.frndname5.focus();return false;
		} else{$('emailerrmsgnam5').innerHTML="&nbsp"; }
		if(IsEmpty(frmmailfwd.frndemail5,"text")){
			$('emailerrmsgemail5').innerHTML="Enter friend's email id";frmmailfwd.frndemail5.focus();return false;
		} else if(!ValidateEmail(frmmailfwd.frndemail5.value)){
			$('emailerrmsgemail5').innerHTML="Invalid email id";frmmailfwd.frndemail5.focus();return false;
		} else{ $('emailerrmsgemail5').innerHTML="&nbsp"; }
	}
	
	return true;
}

function photouploadval() {
	var varFrm = document.frmSuccess;var extPos = varFrm.photo.value.lastIndexOf( "." );
	if (extPos == - 1) {
		//$('upPhotoSpan').innerHTML="Only gif or jpg files can be added into your success story";varFrm.photo.focus();return false;
	} else {
		var extn =  varFrm.photo.value.substring(extPos + 1, varFrm.photo.value.length);
		if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" )
		{
			$('upPhotoSpan').innerHTML="Only gif or jpg files can be added into your success story";
			varFrm.photo.value= "";
			varFrm.photo.focus();
			return false; }
	} return true;
}


