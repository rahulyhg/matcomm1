var param="";var objAjax1 = null;
function setCookieSaveSrch(argSrchId,argSrchType,argSrchName,argdomainName) 
{
	var SrchId					=	argSrchId+"|"+argSrchType+"|"+argSrchName;
	var SearchVal			=	getCookie('savedSearchInfo');
	var SrchCookie 			= SearchVal.split('~');
	var SrchEdit				= 0;
	var CookieLength		= SrchCookie.length;
	var SearchNewVal	= '';
	for(var i=0;i<CookieLength;i++) {
		var SrchCookInfo	= SrchCookie[i].split('|');
		if(SrchCookInfo[0] == argSrchId) { 
			var str = SrchCookie[i];
			var repVal	 = argSrchName;
			var exsVal	= SrchCookInfo[2];
			SrchCookie[i] = str.replace(exsVal, repVal);
			SrchEdit = 1;
		} 
		SearchNewVal = SearchNewVal+'~'+SrchCookie[i];
	}
	if(SrchEdit==1) {
		savSrchCook	= SearchNewVal.substr(1);
		setCookie('savedSearchInfo',savSrchCook,argdomainName);
	} else {
		if(SearchVal != '')	{ AppendSrchId = SrchId + "~" + SearchVal; } 
		else { AppendSrchId = SrchId; }
		setCookie('savedSearchInfo',AppendSrchId,argdomainName);
	}
}

function chkAllTxt(){
	document.buttonfrm.chk_all.checked = true;
	selectall(document.buttonfrm, 'chk_all');
}

function chkNoneTxt(){
	document.buttonfrm.chk_all.checked = false;
	selectall(document.buttonfrm, 'chk_all');
}