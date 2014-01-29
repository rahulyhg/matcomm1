function setlastViewCookie(argMatriId,argdomainName) 
{
	var viewVal				=	getCookie('lastViewProfile');
	var viewCookie 		=  viewVal.split('~');
	var viewExists			= 0;
	var viewCookieLen	= viewCookie.length;
	for(var i=0;i<viewCookieLen;i++) {
		var viewCookInfo	= viewCookie[i].split('|');
		if(viewCookInfo[0] == argMatriId) { 
			viewExists = 1;
		}
	}
	if(viewExists == 0) {
		if(viewVal != '')	{ AppendviewId = argMatriId + "~" + viewVal; } 
		else { AppendviewId = argMatriId; }
		setCookie('lastViewProfile',AppendviewId,argdomainName);
	}
}