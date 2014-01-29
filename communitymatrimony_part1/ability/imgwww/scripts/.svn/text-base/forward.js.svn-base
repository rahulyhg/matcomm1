function foremailnum(field){
	var rtest=$("Rname1").value.split(',');var rtest2=$("Rmail1").value.split(',');
	if(trim(rtest2[rtest2.length-1])!=""){
		if(rtest.length==rtest2.length){
			for(var s=0;s<rtest2.length;s++){
				if(!ValidateEmail(rtest2[s])){$("Rmail").innerHTML='One or more e-mail IDs entered are invalid.';return false;}
			}
		}
		else{$("Rmail").innerHTML="The number of e-mail IDs doesn't match the number of recipient names.";return false;}
	}
	else{$("Rmail").innerHTML="Please enter a valid e-mail ID(s).";return false;}return true;}function clear_all(val){$(val).innerHTML='';
}
function textCounter(field,countfield,maxlimit){
	if(field.value.length>=maxlimit){
		field.value=field.value.substring(0,maxlimit);
		$("Comment").innerHTML='Please keep your message very brief. You have exceeded the word limit.';return false;
	}else {countfield.value=maxlimit-field.length;}
}
function trim(Val){
	while(''+Val.charAt(0)==' ')Val=Val.substring(1,Val.length);return Val;
}
function IsValid(Val,Label){if(trim(Val)==""){$("Rmail1").innerHTML="Please enter "+Label;return false}return true;}
function frmvalidate1(){
	var ForwFriendForm=this.document.ForwFriendForm;
	var Email1=$("Umail1").value;
	var Email=$("Rmail1").value;
	if($("Uname1").value==""){
		$("Uname").innerHTML="Please enter your name.";document.ForwFriendForm.yourName.focus();return false;
	}
	if($("Umail1").value==""){
		$("Uname").innerHTML='';$("Umail").innerHTML="Please enter your e-mail address.";document.ForwFriendForm.yourEmail.focus();return false;
	}
	if(!ValidateEmail(Email1)){
		$("Umail").innerHTML='';$("Umail").innerHTML="Please enter a valid e-mail ID.";document.ForwFriendForm.yourEmail.focus();return false;
	}
	if($("Rname1").value==""){
		$("Umail").innerHTML='';$("Rname").innerHTML="Please enter recipients name.";document.ForwFriendForm.recipientName.focus();return false;
	}
	if($("Rmail1").value==""){
		$("Rname").innerHTML='';$("Rmail").innerHTML="Please enter recipients e-mail ID.";document.ForwFriendForm.recipientEmail.focus();return false;
	}
	if(!foremailnum($("Rmail1").value)){document.ForwFriendForm.recipientEmail.focus();return false;}
	if(ForwFriendForm.comments.value==''){
		$("Rmail").innerHTML='';$("Comment").innerHTML=" Please add a message/comments.";document.ForwFriendForm.comments.focus();return false;
	}
	$("Comment").innerHTML='';
}
function forward_validate(){
	var ForwFriendForm=this.document.ForwFriendForm;
	var Email1=$("Umail1").value;
	var Email=$("Rmail1").value;
	if($("Uname1").value==""){$("Uname").innerHTML="Please enter your name.";document.ForwFriendForm.yourName.focus();return false;}
	if($("Umail1").value==""){$("Uname").innerHTML='';$("Umail").innerHTML="Please enter your e-mail address.";document.ForwFriendForm.yourEmail.focus();return false;}
	if(!ValidateEmail(Email1)){$("Umail").innerHTML='';$("Umail").innerHTML="Please enter a valid e-mail ID.";document.ForwFriendForm.yourEmail.focus();return false;}
	if($("Rname1").value==""){$("Umail").innerHTML='';$("Rname").innerHTML="Please enter recipients name.";document.ForwFriendForm.recipientName.focus();return false;}
	if($("Rmail1").value==""){$("Rname").innerHTML='';$("Rmail").innerHTML="Please enter recipients e-mail ID.";document.ForwFriendForm.recipientEmail.focus();return false;}
	if(!foremailnum($("Rmail1").value)){document.ForwFriendForm.recipientEmail.focus();return false;}
	if(ForwFriendForm.comments.value==''){$("Rmail").innerHTML='';$("Comment").innerHTML="Please add a message/comments.";document.ForwFriendForm.comments.focus();return false;}
	$("Comment").innerHTML='';
}