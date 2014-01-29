<?php

$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
?>
var varConfArr=new Array(); varConfArr['domainimgs']="<?=$confValues['IMGSURL']?>"; varConfArr['domainweb'] = "<?=$confValues['SERVERURL']?>";varConfArr['domainname'] = "<?=$confValues['DOMAINNAME']?>"; varConfArr['domainimage'] = "<?=$confValues['IMAGEURL']?>";varConfArr['webimgs']="<?=$confValues['PHOTOURL']?>"; varConfArr['domainimg'] = "<?=$confValues['IMGURL']?>"; varConfArr['productname'] = "<?=$confValues['PRODUCTNAME']?>";varConfArr['DOMAINCASTEID'] = "<?=$confValues['DOMAINCASTEID']?>"; 
var upimg="<?=$confValues['IMGSURL']?>/rp-arrow-up.gif"; 
var downimg="<?=$confValues['IMGSURL']?>/rp-arrow-down.gif";
var objAjax1='';
function successstorynxt(argNum){
	var argUrl=varConfArr['domainweb']+"/successstory/successstorypop.php?fileno="+argNum;
	objAjax1 = AjaxCall();
	AjaxGetReq(argUrl,succDiv,objAjax1);
}
function succDiv(){
	if(objAjax1.readyState==4){if(objAjax1.status==200){
		document.getElementById('dispcontent').style.display="block";
		document.getElementById('dispcontent').innerHTML=objAjax1.responseText;
	}else{alert('There was a problem with the request.');}}
}
function successstorypop(argNum){
	var url=varConfArr['domainweb']+"/successstory/successstorypop.php?fileno="+argNum;
	window.open(url,'successstory','top=250,left=525,bottom=0,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resize=0,width=600,height=450'); 
}

function launchIC(userID,destinationUserID) 
{
	var destinationUserID=destinationUserID.split('_');

	if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent))
	{ 
		var ffversion=new Number(RegExp.$1) // capture x.x portion and store as a number
		if (ffversion>=3)
		{winwidth="500";winheight="361";}
		else 
		{winwidth="500";winheight="361";}
	}
	else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent))
	{winwidth="500";winheight="361";}
	else
	{winwidth="500";winheight="361";}
	var wintitle=userID+"vs"+destinationUserID;
	var winurl=varConfArr['domainweb']+"/messenger/chatwindow.php?myid="+userID+"&recpid="+destinationUserID;
	var popupWindowTest=null;
	popupWindowTest=window.open(winurl,wintitle,"width="+winwidth+",height="+winheight+",toolbar=0,directories=0,menubar=0,status=0,location=0,scrollbars=0,resizable=0");
	if(popupWindowTest==null) 
	{
		var cl_win_id;
		if(GetCookie("closewin")==null || GetCookie("closewin")=="null"){setCookie("closewin",destinationUserID);}
		else{cl_win_id=GetCookie("closewin")+"~"+destinationUserID;setCookie("closewin",cl_win_id);}
		alert("Your popup blocker stopped an InstantCommunicator window from opening. Please disable it.");
	}

}


function launch_auto(userID,destinationUserID,firstmsg) 
{
	//alert("auto");
	var destinationUserID=destinationUserID.split('_');	
	if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent))
	{ 
		var ffversion=new Number(RegExp.$1) // capture x.x portion and store as a number
		if (ffversion>=3)
		{winwidth="500";winheight="361";}
		else 
		{winwidth="500";winheight="361";}
	}
	else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent))
	{winwidth="500";winheight="361";}
	else
	{winwidth="500";winheight="361";}
	var wintitle=userID+"vs"+destinationUserID;
	var winurl=varConfArr['domainweb']+"/messenger/chatwindow.php?myid="+userID+"&recpid="+destinationUserID+"&firstmsg="+firstmsg;
	var popupWindowTest=null;
	popupWindowTest=window.open(winurl,wintitle,"width="+winwidth+",height="+winheight+",toolbar=0,directories=0,menubar=0,status=0,location=0,scrollbars=0,resizable=0");
	if(popupWindowTest==null) 
	{
		var cl_win_id;
		if(GetCookie("closewin")==null || GetCookie("closewin")=="null"){setCookie("closewin",destinationUserID);}
		else{cl_win_id=GetCookie("closewin")+"~"+destinationUserID;setCookie("closewin",cl_win_id);}
		alert("Your popup blocker stopped an InstantCommunicator window from opening. Please disable it.");
	}
}