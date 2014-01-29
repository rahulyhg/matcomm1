function AjaxCall()
{
	var objAx = null;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
           objAx = new XMLHttpRequest();            
    } 
	else if (window.ActiveXObject) { // IE
		try { objAx = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) 
		{
			try { objAx = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}
        }
    }
	else
	{
		if (objAx==null)
		{alert("Your browser doesn't support AJAX.");}
		return false;
	}
	return  objAx;
}
function AjaxPostReq(url,param,fctnname,userobj)
{
	if(fctnname!=null && fctnname!="")
	{userobj.onreadystatechange = eval(fctnname);}
	userobj.open('POST', url, true);
	userobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	userobj.setRequestHeader("Content-length", param.length);
	userobj.setRequestHeader("Connection", "close");
	userobj.send(param);
}
function AjaxGetReq(url,fctnname,getuserobj)
{
	if(fctnname!=null && fctnname!="")
	{getuserobj.onreadystatechange=eval(fctnname);}
	getuserobj.open('GET', url, true);
	getuserobj.send(null);
}
function genNumbers() {
	var d=new Date();
	var rand_flag = "sr"+d.getSeconds()+"we";
	return rand_flag;
}

/*Get cookie value*/
function GetCookie(name)
{
var cname = name + "=";
var dc = document.cookie;
	if (dc.length > 0)
	{ 
		begin = parseInt(dc.indexOf(cname));
		if (begin >= 0)
		{
			begin += cname.length;
			end = dc.indexOf(";", begin);
			if (end == -1) end = dc.length;
			return unescape(dc.substring(begin, end));
		}
	}
return null;
}

/*position find*/
function findPosX(obj)
{
 var curleft = 0;
 if(obj.offsetParent)
 while(1) 
 {
  curleft += obj.offsetLeft;
  if(!obj.offsetParent)break;
  obj = obj.offsetParent;
  }
  else if(obj.x)
  curleft += obj.x;
  return curleft;
}

function findPosY(obj)
{
 var curtop = 0;
 if(obj.offsetParent)
 while(1)
 {
	curtop += obj.offsetTop;
    if(!obj.offsetParent)break;
    obj = obj.offsetParent;
  }
  else if(obj.y)curtop += obj.y;
  return curtop;
}
var t_msgn;