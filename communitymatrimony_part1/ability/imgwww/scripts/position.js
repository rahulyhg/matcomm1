var lpos;var lpos1;
var browser=navigator.appName;

function ll(divid)
{
	lpos=document.body.clientWidth/2 - parseInt(document.getElementById(divid).style.width)/2;
	document.getElementById(divid).style.left=lpos+'px';
	document.getElementById(divid).style.top='50px';
	document.getElementById('fade').style.height=document.body.scrollHeight;
	if (browser=="Microsoft Internet Explorer")
	{document.getElementById('fade').style.width=document.body.offsetWidth-21;}
	else {document.getElementById('fade').style.width=document.body.offsetWidth;}
}

function innerll(divid)
{
	lpos1=document.body.clientWidth/2 - parseInt(document.getElementById(divid).style.width)/2;
	document.getElementById(divid).style.left=lpos1+'px';
	document.getElementById(divid).style.top='75px';
	document.getElementById('innerfade').style.height=document.body.scrollHeight;
	document.getElementById('innerfade').style.width=document.body.offsetWidth;
}
var ns = (navigator.appName.indexOf("Netscape") != -1);
var d = document;
function floatdiv(id, sx, sy)
{
	var st=document.getElementById(id).offsetHeight;
	if(screen.width>800)
	{	
	var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
	var px = document.layers ? "" : "px";
	window[id + "_obj"] = el;
	if(d.layers)el.style=el;
	el.cx = el.sx = sx;el.cy = el.sy = sy;
	el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};

	el.floatIt=function()
	{
		var pX, pY;
		pX = (this.sx >= 0) ? 0 : ns ? innerWidth : 
		document.documentElement && document.documentElement.clientWidth ? 
		document.documentElement.clientWidth : document.body.clientWidth;
		pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ? 
		document.documentElement.scrollTop : document.body.scrollTop;
		if(this.sy<0) 
		pY += ns ? innerHeight : document.documentElement && document.documentElement.clientHeight ? 
		document.documentElement.clientHeight : document.body.clientHeight;
		this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/8;
		this.sP(this.cx, this.cy);
		setTimeout(this.id + "_obj.floatIt()", 1);
	}
	return el;
	}
	else
	{ 
		if(parseInt(st)<325)
		{
			var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
			var px = document.layers ? "" : "px";
			window[id + "_obj"] = el;
			if(d.layers)el.style=el;
			el.cx = el.sx = sx;el.cy = el.sy = sy;
			el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};

			el.floatIt=function()
			{
				var pX, pY;
				pX = (this.sx >= 0) ? 0 : ns ? innerWidth : 
				document.documentElement && document.documentElement.clientWidth ? 
				document.documentElement.clientWidth : document.body.clientWidth;
				pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ? 
				document.documentElement.scrollTop : document.body.scrollTop;
				if(this.sy<0) 
				pY += ns ? innerHeight : document.documentElement && document.documentElement.clientHeight ? 
				document.documentElement.clientHeight : document.body.clientHeight;
				this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/8;
				this.sP(this.cx, this.cy);
				setTimeout(this.id + "_obj.floatIt()", 1);
			}
			return el;
		}
	}
}

function showSelectBoxes(){
	if(document.getElementsByTagName != 'undefined') {
			var selects = document.getElementsByTagName("select");
			for (i = 0; i != selects.length; i++) { selects[i].style.visibility = "visible"; }
	} else {
			 ele = document.forms.elements;
			for (e = 0; e < ele.length; e++) {
				if (ele[e].type == "select-one") { ele[e].style.visibility = "visible"; }
			}
		}
	if(document.getElementById('bannerdiv')){document.getElementById('bannerdiv').style.display="block";}
}
function hideSelectBoxes(form){
	if(document.getElementsByTagName != 'undefined') {
		var selects = document.getElementsByTagName("select");
		for (i = 0; i != selects.length; i++) { selects[i].style.visibility = "hidden"; }
	} else {
		ele = document.forms.elements;
		for (e = 0; e < ele.length; e++) {
			if (ele[e].type == "select-one") { ele[e].style.visibility = "hidden"; }
		}
	}
	if(document.getElementById('bannerdiv')){document.getElementById('bannerdiv').style.display="none";}
}