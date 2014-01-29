function msg_getcookie(name){
	var cname = name + "=";
	var dc = document.cookie;
	if (dc.length > 0){ 
	 begin = parseInt(dc.indexOf(cname));
	 if (begin >= 0){
	 begin += cname.length;
	 end = dc.indexOf(";", begin);
	 if (end == -1) end = dc.length;
	 return unescape(dc.substring(begin, end));
	 }
	 }
 	return null;
}

var menu1=new Array();
var logck=msg_getcookie('loginInfo');
if((logck != null)&&(logck != "")){	var messenger_url='<div style="padding:2px 0px 1px 10px;border-bottom:1px solid #F0AF8F;"><a class="smalltxt clr1" href="javascript:;" onClick="openmsgr();">'; }
else{ var messenger_url='<div style="padding:2px 0px 1px 10px;border-bottom:1px solid #F0AF8F;"><a class="smalltxt clr1" href="http://www.communitymatrimony.com/messenger/">'; }
menu1[0]=messenger_url+"Launch Messenger</a></div>";
menu1[1]="<div style='padding:2px 0px 1px 10px;'><a class='smalltxt clr1' href='http://www.communitymatrimony.com/search/index.php?act=memonlinesearch'>Members Online</a></div>";
var menuwidth='115px';
var menubgcolor='#FFE9D8';
var hidemenu_onclick="no";
var disappeardelay=50
var ie4=document.all
var ns6=document.getElementById&&!document.all
if (ie4||ns6)
document.write('<div id="dropmenudiv" style="visibility:hidden;width:115px; background-color:'+menubgcolor+';position:absolute;border:1px solid #F0AF8F;line-height:20px;" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

function msg_getposOffset(what, offsettype){
	var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
	var parentEl=what.offsetParent;
	while (parentEl!=null){
	totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
	parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function msg_showhide(obj, e, visible, hidden, menuwidth){
	if (ie4||ns6)
	dropmenuobj.style.left=dropmenuobj.style.top="-500px"
	if (menuwidth!=""){
	dropmenuobj.widthobj=dropmenuobj.style
	dropmenuobj.widthobj.width=menuwidth
	}
	if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
	obj.visibility=visible
	else if (e.type=="click")
	obj.visibility=hidden
}

function msg_iemenutest(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function msg_clearmenuedge(obj, whichedge){
	var edgeoffset=0
	if (whichedge=="rightedge"){
	var windowedge=ie4 && !window.opera? msg_iemenutest().scrollLeft+msg_iemenutest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
	dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
	if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
	edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
	}
	else{
	var topedge=ie4 && !window.opera? msg_iemenutest().scrollTop : window.pageYOffset
	var windowedge=ie4 && !window.opera? msg_iemenutest().scrollTop+msg_iemenutest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
	dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
	if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
	edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
	if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either?
	edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge
	}
	}
	return edgeoffset
}

function populatemenu(what){
	if (ie4||ns6)
	dropmenuobj.innerHTML=what.join("")
}

function dropdownmenu(obj, e, menucontents, menuwidth){
	if (window.event) event.cancelBubble=true
	else if (e.stopPropagation) e.stopPropagation()
	clearhidemenu()
	dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
	populatemenu(menucontents)
	if (ie4||ns6){
	msg_showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)
	dropmenuobj.x=msg_getposOffset(obj, "left")
	dropmenuobj.y=msg_getposOffset(obj, "top")
	/*dropmenuobj.style.left=dropmenuobj.x-msg_clearmenuedge(obj, "rightedge")-100+"px"
	dropmenuobj.style.top=dropmenuobj.y-msg_clearmenuedge(obj, "bottomedge")+obj.offsetHeight+"px"*/
	dropmenuobj.style.left=dropmenuobj.x-55+"px"
	dropmenuobj.style.top=dropmenuobj.y+obj.offsetHeight+"px"
	}
	return clickreturnvalue()
}

function clickreturnvalue(){
	if (ie4||ns6) return false
	else return true
}

function contains_ns6(a, b) {
	while (b.parentNode)
	if ((b = b.parentNode) == a) return true;
	return false;
}

function dynamichide(e){
	if (ie4&&!dropmenuobj.contains(e.toElement))
	delayhidemenu()
	else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
	delayhidemenu()
}

function hidemenu(e){
	if (typeof dropmenuobj!="undefined"){
	if (ie4||ns6)
	dropmenuobj.style.visibility="hidden"
	}
}

function delayhidemenu(){
	if (ie4||ns6)
	delayhide=setTimeout("hidemenu()",disappeardelay)
}

function clearhidemenu(){
	if (typeof delayhide!="undefined")
	clearTimeout(delayhide)
}
if (hidemenu_onclick=="yes")
document.onclick=hidemenu