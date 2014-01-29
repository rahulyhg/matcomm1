 var objPhoto = AjaxCall();
function ph(phname){
	document.getElementById("large").src =  varConfArr['webimgs']+"/loading-icon.gif";
	document.getElementById("large").src=phname	
}

function showloader(){
	document.getElementById('myloader').style.display="block";	
}
function hideloader(){
	document.getElementById('myloader').style.display="none";
}
function showcomment(desc){
	if(desc!=''){
		document.getElementById('descript').style.display='block';
		document.getElementById('descript').innerHTML=desc;
	}else{
		document.getElementById('descript').style.display='none';
		document.getElementById('descript').innerHTML="";
	}
	
}
function funProtectedPassword(){
	 var frmName = document.frmProtectedPassword;
	 if((frmName.password.value).replace('/\s+/','')==''){
		 document.getElementById('protecterror').innerHTML='Enter Password';
		 frmName.password.value='';
		 frmName.password.focus();
		 return false;
	}else{
		document.getElementById('protecterror').innerHTML="&nbsp";
	}
		var arguments	='password='+encodeURI(frmName.password.value)+'&frmPasswordSubmit='+frmName.frmProtectedPasswordSubmit.value+'&ID='+frmName.ID.value;
		var URL			= 'photoverifypassword.php';
		objPhoto = MakePostRequest(URL,arguments);
		return true;
}

function funPwdCheck(){
	 if(objPhoto.readyState==4){
		 if(objPhoto.status==200){
			 var str	= new Array();
			 str		= objPhoto.responseText.split('~');
			 if (str[0] == 1) {
				window.location= varConfArr['domainimage']+"/photo/viewphoto.php?ID="+str[1]+"&PID="+str[2];
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
function MakePostRequest(url,parameters,functionname){
 //var objPhoto=false;
 var objPhoto = AjaxCall();
 objPhoto.onreadystatechange = funPwdCheck;
 objPhoto.open('POST', url, true);
 objPhoto.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 objPhoto.setRequestHeader("Content-length", parameters.length);
 objPhoto.setRequestHeader("Connection", "close");
 objPhoto.send(parameters);
 return objPhoto;
}
function undervalidation(msg){
	document.getElementById('validation').innerHTML= msg;
}
