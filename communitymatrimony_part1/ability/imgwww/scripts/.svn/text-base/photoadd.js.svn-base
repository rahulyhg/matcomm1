var objPhoto;var wload=0;var checkdelete = 0;var commSpan='';
function validateFile(){
		var PhotoForm = this.document.addphoto;
		if ( PhotoForm.newphoto.value == "" )		{
			$('errdiv').style.display = 'block';
			$('errdiv').innerHTML=  "Please select the Photo";			
			PhotoForm.newphoto.focus( );
			return false;
		}
		var extPos = PhotoForm.newphoto.value.lastIndexOf( "." );
		if ( extPos == - 1){
			$('errdiv').innerHTML="Only gif or jpg or png files can be added into your profile";
			PhotoForm.newphoto.focus( );
			return false;
		}
		else{
			var extn =  PhotoForm.newphoto.value.substring(
				extPos + 1, PhotoForm.newphoto.value.length );
			if (extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" &&  extn != "png" &&  extn != "PNG" ) {
				$('errdiv').innerHTML="Only gif or jpg files can be added into your profile";
				PhotoForm.newphoto.focus( );
				return false;
			}
		}
		window.scrollTo(0,0);
		return true;
}

function afterDelconfirm(){
	var PhotoForm=document.addphoto;
	url		= "photodelete.php";
	param	= 'frmDeleteSubmit=yes&PNO='+PhotoForm.curphotono.value;;
	objPhoto = AjaxCall();
	AjaxPostReq(url,param,deleteResponse,objPhoto);
}

function deleteResponse() {
	if(objPhoto.readyState == 4){
		hidediv('confirm');
		$('cmsggout').style.display="block";
		$('confirmmsg').innerHTML = objPhoto.responseText;
	}else{
		//$("confirm").innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function phodelete(ph_no){
	var PhotoForm=document.addphoto;
	/*del_url = '/photo/photodelete.php?PNO='+ph_no;
	funIframeIMGS(del_url,'430','90','iframeicon','icondiv');
	floatdiv('icondiv',lpos,150).floatIt();*/
	PhotoForm.curphotono.value=ph_no;
	$('confirm').style.display="block";
	$('cmsggout').style.display="none";	
}

function reloadPage() {
	var PhotoForm=document.addphoto;
	$('cmsggout').style.display="none";
	window.location="index.php";
	/*PhotoForm.action.value="index.php";
	PhotoForm.submit();*/
}
	
function validate(frm, errres){
	commSpan	= errres;
	otherSpan	= (commSpan == 'result')? 'chgresult': 'result';
	$(otherSpan).innerHTML = '';
	if (frm.pass.value == "" ){
		$(commSpan).innerHTML = 'Please enter the photo password';
		frm.pass.focus();
		return false;
	}

	if (frm.pass.value.length < 4 ){
		$(commSpan).innerHTML = 'Your photo password must have a minimum of 4 characters';
		frm.pass.focus();frm.pass.value='';frm.repass.value='';
		return false;
	}
	if ( frm.repass.value == "" ){
		$(commSpan).innerHTML = 'Please enter the confirm photo password';
		frm.repass.focus();
		return false;
	}

	if ( frm.pass.value!= frm.repass.value ){
		$(commSpan).innerHTML = 'The photo password and confirm password did not match';
		frm.pass.focus();frm.pass.value='';frm.repass.value='';
		return false;
	}
	FunProtectPassword(frm.pass.value,frm.repass.value);
	showFormNew(frm);
	return true;
}		
function showFormNew(frm){ 
	frm.pass.value="";
	frm.repass.value="";
}
function funPhotoSwap(choice){		
	url= "photoswap.php?actionval=change&CHOICE="+choice;	
	makeRequest(url);
}
function makeRequest(url) {
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
function alertContents() {
	if (objPhoto.readyState == 4) {
		if (objPhoto.status == 200) {			
			window.location="index.php?act=addphoto";
		} else 
			alert('There was a problem with the request.');
	}
}

function MakePostRequest(url,parameters,functionname){
 var objPhoto = AjaxCall();
 eval("objPhoto.onreadystatechange = "+functionname+";");
 objPhoto.open('POST', url, true);
 objPhoto.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 objPhoto.setRequestHeader("Content-length", parameters.length);
 objPhoto.setRequestHeader("Connection", "close");
 objPhoto.send(parameters);
 return objPhoto;
}
function FunProtectPassword(pwd,repwd) {
	url= "photoprotect.php?randno="+Math.random();;		
	var poststr = "password=" + encodeURI(pwd) + "&repassword=" + encodeURI(repwd)+"&option=Y";	
	MakePostRequest(url,poststr,alertContentsPass);
}
function alertContentsPass() {
	if (objPhoto.readyState == 4) {
		if (objPhoto.status == 200) {	
			$(commSpan).innerHTML='';	
			var strArray	= new Array();
			strArray		=  (objPhoto.responseText).split("~");
			
			if(strArray[0] ==1){
				$(commSpan).innerHTML				= strArray[1];
				$('addpass').style.display			="none";
				$('unprotectpass').style.display	="block";
				$('changepwd').style.display		="none";
				$('contentdiv1').style.display		='none';
				$('contentdiv2').style.display		='block';
			}
			else if(strArray[0] == 2){
				$(commSpan).innerHTML				= strArray[1];
				$('addpass').style.display			= "block";
				$('unprotectpass').style.display	= "none";
				$('changepwd').style.display		= "none";
				$('contentdiv1').style.display		= 'block';
				$('contentdiv2').style.display		= 'none';
			}
			else 
				$(commSpan).innerHTML				= strArray[1];
		} else 
			alert('There was a problem with the request.');
	}else{
		$(commSpan).innerHTML='Processing...';
	}
}
function load_changediv(){
	$('result').innerHTML	= '';
	$('chgresult').innerHTML= '';
	$('addpass').style.display			="none";
	$('unprotectpass').style.display	="none";
	$('changepwd').style.display		="block";
	$('contentdiv1').style.display		='block';
	$('contentdiv2').style.display		='none';
}
function funRemovePwd() {
	commSpan = 'result';
	url= "photoprotect.php";		
	var poststr = "option=N";	
	MakePostRequest(url,poststr,alertContentsPass);
}