function validateFeedback()
{ 
  var feedfrm = document.feedbackform;
  if(feedfrm.fbName.value == ""){
	 $("name").innerHTML = "Enter your name";
	 feedfrm.fbName.value = "";
	 feedfrm.fbName.focus();
     return false;
	}
	if(feedfrm.fbEmail.value == ""){
	 $("email").innerHTML = "Enter your e-mail ID";
	 feedfrm.fbEmail.value = "";
	 feedfrm.fbEmail.focus();
     return false;
	}
	if(!ValidateEmail(feedfrm.fbEmail.value)) {
		   $("email").innerHTML = "Invalid e-mail ID";
		   feedfrm.fbEmail.focus();
		   return false;
	}
    if(feedfrm.fbFeedback.value == "") {
	 $("feedback").innerHTML = "Enter your suggestions or feedback";
	 $("email").innerHTML = "";
	 feedfrm.fbFeedback.focus();
     return false;
	}
	return true;		
}
