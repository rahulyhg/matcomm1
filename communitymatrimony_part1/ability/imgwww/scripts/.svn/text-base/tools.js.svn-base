function funIframeCng(furl,w,h,fid,dvid){
	$(fid).src=varConfArr['domainweb']+"/loading.html";
	var randNo	= Math.floor(Math.random()*11);
	var argUrl	= varConfArr['domainweb']+'/'+furl+'&rand='+genNumbers();
	if($(fid).contentWindow.document.body!=null){
	$(fid).contentWindow.document.body.innerHTML = '';
	}
	$(fid).src = argUrl;
	if($(fid).contentWindow.document.body!=null){
	$(fid).contentWindow.document.body.innerHTML ='<table border="0" cellpadding=0 cellspacing=0 align="center" width="100%" height="100%"><tr><td height="100%" align="center"><img src="'+varConfArr["domainimgs"]+'/loading-icon.gif" alt="" border="0" /></td></tr></table>';
	}
	$(fid).width = w+'px';
	$(fid).height = h+'px';
	$(dvid).style.width = w+'px';
	$(dvid).style.height = h+'px';
	$('fade').style.display='block';
	$(dvid).style.display='block';
	ll(dvid);
	hideSelectBoxes();
	return true;
}
function funIframeIMGS(furl,w,h,fid,dvid){
	$(fid).src=varConfArr['domainweb']+"/loading.html";
	var randNo	= Math.floor(Math.random()*11);
	var argUrl	= varConfArr['domainimage']+'/'+furl+'&rand='+randNo;
	if($(fid).contentWindow.document.body!=null){
	$(fid).contentWindow.document.body.innerHTML = '';
	}
	$(fid).src = argUrl;
	if($(fid).contentWindow.document.body!=null){
	$(fid).contentWindow.document.body.innerHTML ='<table border="0" cellpadding=0 cellspacing=0 align="center" width="100%" height="100%"><tr><td height="100%" align="center"><img src="'+varConfArr["domainimgs"]+'/loading-icon.gif" alt="" border="0" /></td></tr></table>';
	}
	$(fid).width = w+'px';
	$(fid).height = h+'px';
	$(dvid).style.width = w+'px';
	$(dvid).style.height = (h)+'px';
	$(dvid).style.display='block';
	$('fade').style.display='block';
	ll(dvid);
	return true;
}