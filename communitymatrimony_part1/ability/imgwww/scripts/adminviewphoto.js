 var objAx = AjaxCall();
function ph(phname){
	document.getElementById("large").src =  varConfArr['domainimgs']+"/loading-icon.gif";
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
		document.getElementById('protecterror').innerHTML='&nbsp';
	}
	var arguments	='password='+encodeURI(frmName.password.value)+'&frmPasswordSubmit='+frmName.frmProtectedPasswordSubmit.value+'&ID='+frmName.ID.value;
	var URL			= 'photoverifypassword.php';
	objAx = MakePostRequest(URL,arguments,'funPwdCheck');
	return true;
}

function funPwdCheck(){
	 if(objAx.readyState==4){
		 if(objAx.status==200){
			 var str	= new Array();
			 str		= objAx.responseText.split('~');
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
 //var objAx=false;
// var objAx = AjaxCall();
 eval("objAx.onreadystatechange = "+functionname+";");
 objAx.open('POST', url, true);
 objAx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 objAx.setRequestHeader("Content-length", parameters.length);
 objAx.setRequestHeader("Connection", "close");
 objAx.send(parameters);
 return objAx;
}
function undervalidation(msg){
	document.getElementById('validation').innerHTML= msg;
}
