var checkRequestThanks='';
function fnphonecomplaint(){
  var frmName=document.frmphonecomplaint;
  if (frmName.complaint.selectedIndex==0)
  {
	$('error').innerHTML="Select the reason<br>";
	return false;
  }else {
	parameters='problemid='+frmName.problemid.value+'&phonedetail='+frmName.phonedetail.value+'&senderid='+frmName.senderid.value+'&complaint='+frmName.complaint.value+'&index='+frmName.complaint.selectedIndex;
	var argUrl= varConfArr['domainweb']+'/phone/phonethanks.php';
	checkRequestThanks=MakePostRequest(argUrl,parameters,'ajaxComplaintCallBack');
  }
 }

function ajaxComplaintCallBack(){
	if(checkRequestThanks.readyState==4){if(checkRequestThanks.status==200){$('phonecomplaindiv').style.display="none";$('phonethanks').style.display="";$('phonethanks').innerHTML=checkRequestThanks.responseText;}else alert('There was a problem with the request.');}}

function MakePostRequest(url,parameters,functionname){
 //var objPhone=false;
 var objPhone = AjaxCall();
 eval("objPhone.onreadystatechange = "+functionname+";");
 objPhone.open('POST', url, true);
 objPhone.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 objPhone.setRequestHeader("Content-length", parameters.length);
 objPhone.setRequestHeader("Connection", "close");
 objPhone.send(parameters);
 return objPhone;
}