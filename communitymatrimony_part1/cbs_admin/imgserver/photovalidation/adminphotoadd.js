var objPhoto;var wload=0;var checkdelete = 0;
function showFocus() {
	document.getElementById('htxt').focus();
	document.getElementById('txtdiv').style.display="none";
}
function validateFile(){
		var PhotoForm = this.document.addphoto;
		if ( PhotoForm.newphoto.value == "" )		{
			document.getElementById('errdiv').style.display = 'block';
			document.getElementById('errdiv').innerHTML=  "Please select the Photo";			
			PhotoForm.newphoto.focus( );
			return false;
		}
		var extPos = PhotoForm.newphoto.value.lastIndexOf( "." );
		if ( extPos == - 1){
			document.getElementById('errdiv').innerHTML="Only gif or jpg files can be added into your profile";
			PhotoForm.newphoto.focus( );
			return false;
		}
		else{
			var extn =  PhotoForm.newphoto.value.substring(
				extPos + 1, PhotoForm.newphoto.value.length );
			if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" ) {
				document.getElementById('errdiv').innerHTML="Only gif or jpg files can be added into your profile";
				//alert( "Only gif or jpg or png files can be added into your profile" );
				PhotoForm.newphoto.focus( );
				return false;
			}
		}
		window.scrollTo(0,0);
		return true;
}

function hideFormNew(){ 
	var frm = document.PhotoProtectForm;
	frm.PHOTO_PASSWORD1.value		= "";
	frm.PHOTO_PASSWORD1.readOnly	= true;
	frm.PHOTO_PASSWORD2.value		= "";
	frm.PHOTO_PASSWORD2.readOnly	= true;	
}	
function validate(frm){
	var PhotoProtectForm = this.document.frmPhotoProtect;  		
	if ( PhotoProtectForm.photopwd.value == "" )
	{
		document.getElementById('result').innerHTML = "Please enter the photo password";
		PhotoProtectForm.photopwd.focus();
		return false;
	}
	if ( PhotoProtectForm.photoprotectpwd.value == "" )	{
		document.getElementById('result').innerHTML = "Please enter the confirm photo password";
		PhotoProtectForm.photoprotectpwd.focus();
		return false;
	}

	if ( PhotoProtectForm.photopwd.value!= PhotoProtectForm.photoprotectpwd.value )	{
		document.getElementById('result').innerHTML = "The photo password and confirm password did not match";
		PhotoProtectForm.photopwd.focus();
		return false;
	}
	FunProtectPassword(PhotoProtectForm.photopwd.value,PhotoProtectForm.photoprotectpwd.value);
	return true;
}		
function showFormNew()	{ 
	var frm = document.PhotoProtectForm;
	frm.PHOTO_PASSWORD1.value="";
	frm.PHOTO_PASSWORD2.value="";
	frm.PHOTO_PASSWORD1.readOnly=false;
	frm.PHOTO_PASSWORD2.readOnly=false;					
}
function funPhotoSwap(choice,id){		
	url= "adminphotoswap.php?action=change&CHOICE="+choice+"&ID="+id;	
	makeRequest(url);
}
function makeRequest(url,id) {
	objRequest = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		objPhoto = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
		try {
			objPhoto = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				objPhoto = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}

	if (!objPhoto) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
	objPhoto.onreadystatechange = alertContents;
	objPhoto.open('GET', url, true);
	objPhoto.send(null);
}
function alertContents(id) {
	if (objPhoto.readyState == 4) {
		if (objPhoto.status == 200) {	
			var str	= objPhoto.responseText.split('~');
			if(str[0]==1)
				window.location="adminmanagephoto.php?MATRIID="+str[1];
			else 
				document.getElementById('').innerHTML=objPhoto.responseText;
		} else 
			alert('There was a problem with the request.');
	}
}

function funDeletePhoto(photonum,id){		
	if(photonum > 0) {
		url="adminphotodelete.php";			
		var poststr = "action=delete&DELPH=" + encodeURI(photonum)+'&ID='+id;	
		//alert(url+'?'+poststr)
		MakePostRequest(url,poststr,alertContentsDelete);
	} else 
		window.location="adminmanagephoto.php";
}

function MakePostRequest(url,parameters,functionname){
 //var objPhoto=false;
 var objPhoto = AjaxCall();
 eval("objPhoto.onreadystatechange = "+functionname+";");
 objPhoto.open('POST', url, true);
 objPhoto.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 objPhoto.setRequestHeader("Content-length", parameters.length);
 objPhoto.setRequestHeader("Connection", "close");
 objPhoto.send(parameters);
 return objPhoto;
}
function alertContentsDelete() {
        if (objPhoto.readyState == 4) {
            if (objPhoto.status == 200) {		
				if(objPhoto.responseText==1){
					//alert('delete'+objPhoto.responseText);
					window.location="adminphotodeletemsg.php";
				}			
            } else 
                alert('There was a problem with the request.');
        }
}

function photoUpload(divid,num,action){	
	document.getElementById('action').value=action;
	document.getElementById('photono').value=num;
	if (parseInt(navigator.appVersion)>3) {
		 if (navigator.appName=="Netscape") {
			  winH = window.outerWidth;	
			  winW = window.outerHeight;
		 }
		 if (navigator.appName.indexOf("Microsoft")!=-1) {
			  winW = screen.availHeight;
			  winH = screen.availWidth;
		 }
	}
	if(divid=='uploadDIV') {
		document.getElementById('uploadDIV').style.display="block";
	if (winH <= 810)
		focusdiv();
	document.getElementById('newphoto').focus();
	}	
}
function divclose(divid){	
	document.getElementById(divid).style.display="none";
}
function focusdiv(){
	if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
		window.location.href="#"+"addphoto";		
	}else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)){ 				
		window.location.href="#"+"addphoto";
	}else{				
		window.location.href="#"+"addphoto";
	}
}