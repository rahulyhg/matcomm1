var objHoroscope = AjaxCall();
function funProtectedPassword(){
	 var frmName = document.frmProtectedPassword;
	 if((frmName.password.value).replace('/\s+/','')==''){
		 document.getElementById('protecterror').innerHTML='Enter Password';
		 frmName.password.value='';
		 frmName.password.focus();
		 return false;
	}else{
		document.getElementById('protecterror').innerHTML="&nbsp";
		var arguments	='password='+frmName.password.value+'&frmPasswordSubmit='+frmName.frmProtectedPasswordSubmit.value+'&ID='+frmName.ID.value;
		var URL			= 'horoscopeverifypassword.php';
		//alert(URL+arguments);
		objHoroscope = MakePostRequest(URL,arguments);
		return true;
	}
}

function MakePostRequest(url,parameters,functionname){
 var objHoroscope = AjaxCall();
 objHoroscope.onreadystatechange = funPwdCheck;
 objHoroscope.open('POST', url, true);
 objHoroscope.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 objHoroscope.setRequestHeader("Content-length", parameters.length);
 objHoroscope.setRequestHeader("Connection", "close");
 objHoroscope.send(parameters);
 return objHoroscope;
}

function funPwdCheck(){
	 if(objHoroscope.readyState==4){
		 if(objHoroscope.status==200){
			 var str	= new Array();
			 str		= objHoroscope.responseText.split('~');
			 if (str[0] == 1) {
				window.location= varConfArr['domainimage']+"/horoscope/viewhoroscope.php?ID="+str[1]+"&PID="+str[2];
			 } else {
				document.getElementById('protecterror').innerHTML="Photo Password did not match.";
				var frmName=document.frmProtectedPassword;
				frmName.password.value='';
				frmName.password.focus();
			 }
		 }else
			alert('There was a problem with the request.');
	 }
}