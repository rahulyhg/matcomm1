 var objAx = null;
 var objVideo=AjaxCall(); wload=0;

function $(obj) {
    if (document.getElementById) {
        if (document.getElementById(obj) != null) 
            return document.getElementById(obj);
        else 
            return "";
    } else if (document.all) {
        if (document.all[obj] != null) 
            return document.all[obj];
        else 
            return "";
    }
}

function funValidPassword(){
	var frmName=document.frmProtectPassword;
	if((frmName.password.value).replace(' /\s+/','')==''){
		$('protectspan1').innerHTML='';
		$('protectspan').innerHTML='Please enter a password';
		frmName.password.value='';return false;
	}
	if((frmName.confirmpassword.value).replace(' /\s+/','')==''){
		$('protectspan1').innerHTML='';
		$('protectspan').innerHTML='Please confirmation password';
		return false;
	}
	if((frmName.password.value).replace(' /\s+/','')!=frmName.confirmpassword.value){
		$('protectspan').innerHTML='';
		$('protectspan1').innerHTML='Sorry, both the passwords you have entered do not seem to match.';
		frmName.password.value='';
		frmName.confirmpassword.value='';
		return false;}else{$('protectspan').innerHTML='&nbsp';
	}return true;
}


function funValidateVideo(){
	var frmName=document.frmVideoUpload;$('videouploadspan').innerHTML='';
	if((frmName.videoupload.value).replace(' /\s+/','')==""){
		$('videouploadspan').innerHTML='Please select video file';
		frmName.videoupload.focus();
		return false;
	}else
		$('videouploadspan').innerHTML='';
	var file=frmName.videoupload.value.split(".");var fileext=(file.length>1)?(file[1].toLowerCase()).replace(' /\s+/',''):'';if((file.length>1)&&(fileext=="mpeg"||fileext=='avi'||fileext=='mpg')){$('videouploadspan').innerHTML='';}else{$('videouploadspan').innerHTML='Please upload your video in MPEG or AVI format only.';frmName.videoupload.focus();return false;}frmName.submit();return true;}
 

function funProtectedPassword(){
	 var frmName=document.frmProtectedPassword;
	 if((frmName.password.value).replace(' /\s+/','')==''){
		 $('protecterror').innerHTML='Enter Password';
		 frmName.password.value='';
		 frmName.password.focus();
		 return false;
	}else{
		$('protecterror').innerHTML='&nbsp';
	}
	var arguments='password='+frmName.password.value+'&frmPasswordSubmit='+frmName.frmProtectedPasswordSubmit.value+'&ID='+frmName.ID.value;
	var URL= 'videoverifypassword.php';
	objVideo = MakePostRequest(URL,arguments,'funPwdCheck');
	return true;
}
 

function funPwdCheck(){
	 if(objVideo.readyState==4){
		 if(objVideo.status==200){
			 var str	= new Array();
			 str		= objVideo.responseText.split('~');
			 if (str[0] == 1) {
				// alert("page   :"+"videoverifyview.php?ID="+str[1]+"&password="+str[2]);
				window.location="videoverifyview.php?tools=1&ID="+str[1]+"&password="+str[2];
			 } else {
				$('protecterror').innerHTML="Video Password did not match.";
				var frmName=document.frmProtectedPassword;
				frmName.password.value='';
				frmName.password.focus();
			 }
		 }else
			alert('There was a problem with the request.');
	 }
}
 



 
function funVideoSpeed(speed,oppositematriId,width,height,password,name){
	window.open(varConfArr['domainweb']+"/video/videoshow.php?videospeed="+speed+"&ID="+oppositematriId+"&pwd="+encodeURI(password)+"&name="+name+"","myWindow","status = 1, height ="+height+", width = "+width+", resizable = 0")}
 
function funChangePassword(){$('unprotect').style.display="block";$('passworddiv').style.display="block";}
 
function funDisplayPwdDiv(videoavailable,VideoProtected){var frmName=document.frmVideoUpload;if(videoavailable==0&&(VideoProtected=='N'||VideoProtected=='')&&frmName.videoupload.value.replace(' /\s+/','')!=""){$('protectpassword').style.display="block";}else if(videoavailable==0&&(VideoProtected=='Y'||VideoProtected=='')&&frmName.videoupload.value.replace(' /\s+/','')!=""){$('unprotect').style.display="block";}}
 

function IsFile(){var frmName=document.frmVideoUpload;if(frmName.videoupload.value.replace(' /\s+/','')==""){$('videouploadspan').innerHTML='Please select video file';frmName.videoupload.focus();return false;}else{$('videouploadspan').innerHTML='&nbsp';}return true;}
 


function funPasswordValid(str){frmName=document.frmProtectPassword;if((frmName.password.value).replace(' /\s+/','')==''&&str=='p'){$('protectspan').innerHTML='Please enter a password';$('protectspan1').innerHTML='';frmName.password.value='';return false;}else if((frmName.confirmpassword.value).replace(' /\s+/','')==''&&str=='c'){$('protectspan').innerHTML='Please confirmation password';$('protectspan1').innerHTML='';return false;}$('protectspan1').innerHTML='';$('protectspan').innerHTML='&nbsp';return true;}
 



function validate(frm){
	var videoProtectForm = this.document.frmvideoProtect;  		
		if ( videoProtectForm.videopwd.value == "" )
		{
			//alert(videoProtectForm.videopwd.value);
			//alert( "Please enter video password" );
			document.getElementById('result').innerHTML = "Please enter the video password";
			videoProtectForm.videopwd.focus();
			return false;
		}

		if ( videoProtectForm.videoprotectpwd.value == "" )
		{
			//alert(videoProtectForm.videoprotectpwd.value);
			//alert( "Please confirm video password" );
			document.getElementById('result').innerHTML = "Please enter the confirm video password";
			videoProtectForm.videoprotectpwd.focus();
			return false;
		}

		if ( videoProtectForm.videopwd.value
				!= videoProtectForm.videoprotectpwd.value )
		{
			//alert( "video password did not match" );
			document.getElementById('result').innerHTML = "The video password and confirm password did not match";
			videoProtectForm.videopwd.focus();
			return false;
		}
	FunProtectPassword(videoProtectForm.videopwd.value,videoProtectForm.videoprotectpwd.value);
	return true;
}


function FunProtectPassword(pwd,repwd) {
	url= "videoprotect.php";		
	var poststr = "password=" + encodeURI(pwd) + "&repassword=" + encodeURI(repwd)+"&option=add";	
	//alert(url+'?'+poststr);
	MakePostRequest(url,poststr,alertContentsPass);
}


function funRemovePwd() {
	url= "videoprotect.php";		
	var poststr = "option=remove";	
	//alert(url+'?'+poststr);
	MakePostRequest(url,poststr,alertContentsPass);
}


function funChangePwd() {

	var videoProtectForm = this.document.frmChangePwd;  		
	if ( videoProtectForm.videopwd.value == "" )	{
		//alert( "Please enter video password" );
		document.getElementById('cngerror').innerHTML = "Please enter the video password";
		videoProtectForm.pass.focus( );
		return false;
	}

	if ( videoProtectForm.videoprotectpwd.value == "" )	{
		//alert( "Please confirm video password" );
		document.getElementById('cngerror').innerHTML = "Please enter the confirm video password";
		videoProtectForm.repass.focus( );
		return false;
	}

	if ( videoProtectForm.videopwd.value != videoProtectForm.videoprotectpwd.value )	{
		//alert( "video password did not match" );
		document.getElementById('cngerror').innerHTML = "The video password and confirm password did not match";
		videoProtectForm.pass.focus( );
		return false;
	}  
	url= "videoprotect.php";		
	pass = videoProtectForm.videopwd.value;
	repass = videoProtectForm.videoprotectpwd.value;
	var poststr = "password=" + encodeURI(pass) + "&repassword=" + encodeURI(repass)+"&option=change";			
	MakePostRequest(url,poststr,alertChangePass);
}

function alertChangePass () {
	if (objVideo.readyState == 4) {
		if (objVideo.status == 200) {
			document.getElementById('cngerror').innerHTML='';	
			//alert(objVideo.responseText);
				strArray		=  (objVideo.responseText).split("~");
				//alert('addpass '+document.getElementById('addpass').style.display);
				//alert('unprotectpass '+document.getElementById('unprotectpass').style.display);
			if(strArray[0] == 1){
				responseText = "Your video password has been successfully modified.";
					document.getElementById('addpass').style.display		="none";
					document.getElementById('unprotectpass').style.display	="block";
					document.getElementById('changepwd').style.display		="none";
			}else {
				document.getElementById('addpass').style.display="none";
				responseText = strArray[1];
			}
			document.getElementById('cngerror').innerHTML=responseText;							
		} else 
			alert('There was a problem with the request.');
	}
}

function MakePostRequest(url,parameters,functionname){
 //var objVideo=false;
	 var objVideo = AjaxCall();
	 eval("objVideo.onreadystatechange = "+functionname+";");
	 objVideo.open('POST', url, true);
	 objVideo.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 objVideo.setRequestHeader("Content-length", parameters.length);
	 objVideo.setRequestHeader("Connection", "close");
	 objVideo.send(parameters);
	 return objVideo;
}
function alertContentsPass() {
	if (objVideo.readyState == 4) {
		if (objVideo.status == 200) {	
				document.getElementById('result').innerHTML='';	
				var strArray	= new Array();
				strArray		=  (objVideo.responseText).split("~");
			if(strArray[0] ==1){
				document.getElementById('addpass').style.display		="none";
				document.getElementById('unprotectpass').style.display	="block";
				document.getElementById('changepwd').style.display		="none";
			}
			else if(strArray[0] == 2){
				document.getElementById('addpass').style.display		= "block";
				document.getElementById('unprotectpass').style.display	= "none";
				document.getElementById('changepwd').style.display		= "none";
			}
			else  {
				document.getElementById('result').innerHTML				= strArray[1];
			}
		} else 
			alert('There was a problem with the request.'); 
  }
}

function funVideoDelete(){
	window.location = "videodelete.php?frmDeleteVideoSubmit=yes";
	parent.document.getElementById('iframetools').height	= "100px";
}