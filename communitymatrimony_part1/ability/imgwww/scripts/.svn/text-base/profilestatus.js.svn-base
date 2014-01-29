var getuserobj;

function chkProfileStatus(){
	var hideProfileFrm=document.hideprof;
	if(!(hideProfileFrm.statustype[0].checked) && !(hideProfileFrm.statustype[1].checked)) {
		$('profilestatusspan').innerHTML="please select the option for Hide/Delete profile.";
		hideProfileFrm.statustype[0].focus();
		return false;
	} else {
		$('profilestatusspan').innerHTML="";
	}

	if(hideProfileFrm.statustype[0].checked == true) {
		hideProfileFrm.action.value="index.php";
		hideProfileFrm.submit();
	}

	if(hideProfileFrm.statustype[1].checked == true) {
		if(hideProfileFrm.reason.selectedIndex == '') {
			$('profilespan').innerHTML="Please select the reason for deleting your profile.";
			hideProfileFrm.reason.focus();
			return false;
		}
			
		showdiv('confirm');
	}
}

function dispDelReason(optval) {
	if(optval==2) {
		$('deloption').className="disblk";
	} else {
		$('deloption').className="disnon";
	}
	$('profilespan').innerHTML="";
}

function dispOtherSite() {
	var hideProfileFrm=document.hideprof;
	if(hideProfileFrm.reason.value==2) {
		$('othersitename').className="disblk";		
	}else{
		$('othersitename').className="disnon";
	}
}

function afterDelconfirm(matid){
	var hideProfileFrm=document.hideprof;
	url		= ser_url+"/profiledetail/deleteconfirmation.php?rno="+Math.random();
	param	= 'reason='+hideProfileFrm.reason.value+'&othersite='+hideProfileFrm.othersite.value+'&updatestatus='+hideProfileFrm.updatestatus.value;
	getuserobj = AjaxCall();
	AjaxPostReq(url,param,deleteResponse,getuserobj);
}

function deleteResponse() {
	if(getuserobj.readyState == 4){
		$('confirm').className = "disblk";
		$('confirm').innerHTML = getuserobj.responseText;
	}else{
		$("phonediv").innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function redirectLogin(reson_id) {
	if(reson_id == 1) {
		window.location=img_url+'/successstory/index.php?act=success';
	} else {
		window.location=ser_url+'/login/index.php';
	}
}