function getCookie(cookieName){
	if (document.cookie.length>0) {
		  cookieStart	=	document.cookie.indexOf(cookieName + "=")
		  if (cookieStart!=-1) { 
			cookieStart		=	cookieStart + cookieName.length+1 
			cookieEnd		=	document.cookie.indexOf(";",cookieStart)
			if (cookieEnd==-1) 
				cookieEnd=document.cookie.length
			return unescape(document.cookie.substring(cookieStart,cookieEnd))
		  } 
	  }
	return ""
}
function setCookie(name, value, domain)	{ document.cookie = name + "=" + escape(value)+";DOMAIN="+domain+";PATH=/" }	