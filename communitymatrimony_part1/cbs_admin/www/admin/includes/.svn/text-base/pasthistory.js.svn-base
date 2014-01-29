//DHTML Window script- Copyright Dynamic Drive (http://www.dynamicdrive.com)
//For full source code, documentation, and terms of usage,
//Visit http://www.dynamicdrive.com/dynamicindex9/dhtmlwindow.htm

var dragapproved=false
var minrestore=0
var initialwidth,initialheight
var ie5=document.all&&document.getElementById
var ns6=document.getElementById&&!document.all

function iecompattestfollow(){
return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function drag_drophistory(e){
	if (ie5&&dragapproved&&event.button==1){
	document.getElementById("dwindowhistory").style.left=tempx+event.clientX-offsetx+"px"
	document.getElementById("dwindowhistory").style.top=tempy+event.clientY-offsety+"px"
	}
	else if (ns6&&dragapproved){
	document.getElementById("dwindowhistory").style.left=tempx+e.clientX-offsetx+"px"
	document.getElementById("dwindowhistory").style.top=tempy+e.clientY-offsety+"px"
	}
}
function drag_droppayment(e){
	if (ie5&&dragapproved&&event.button==1){
	document.getElementById("dwindowpayment").style.left=tempx+event.clientX-offsetx+"px"
	document.getElementById("dwindowpayment").style.top=tempy+event.clientY-offsety+"px"
	}
	else if (ns6&&dragapproved){
	document.getElementById("dwindowpayment").style.left=tempx+e.clientX-offsetx+"px"
	document.getElementById("dwindowpayment").style.top=tempy+e.clientY-offsety+"px"
	}
}
function initializedraghistory(e){
	offsetx=ie5? event.clientX : e.clientX
	offsety=ie5? event.clientY : e.clientY
	document.getElementById("dwindowcontenthistory").style.display="none" //extra
	tempx=parseInt(document.getElementById("dwindowhistory").style.left)
	tempy=parseInt(document.getElementById("dwindowhistory").style.top)

	dragapproved=true
	document.getElementById("dwindowhistory").onmousemove=drag_drophistory
}
function initializedragpayment(e){
	offsetx=ie5? event.clientX : e.clientX
	offsety=ie5? event.clientY : e.clientY
	document.getElementById("dwindowcontentpayment").style.display="none" //extra
	tempx=parseInt(document.getElementById("dwindowpayment").style.left)
	tempy=parseInt(document.getElementById("dwindowpayment").style.top)

	dragapproved=true
	document.getElementById("dwindowpayment").onmousemove=drag_droppayment
}
function loadwindowhistory(url,width1,height1){

if (!ie5&&!ns6)
	window.open(url,"PastHistory","width=width1,height=height1,scrollbars=1")
	else{
		document.getElementById("dwindowhistory").style.display=''
		document.getElementById("dwindowhistory").style.width=width1+"px"
		document.getElementById("dwindowhistory").style.height=height1+"px"
		document.getElementById("dwindowhistory").style.left="40px"
		document.getElementById("dwindowhistory").style.top="-100px"
		document.getElementById("cframehistory").src=url
	}
}

function loadwindowpayment(url,width1,height1){
if (!ie5&&!ns6)
	window.open(url,"Payment","width=width1,height=height1,scrollbars=1")
	else{
		document.getElementById("dwindowpayment").style.display=''
		document.getElementById("dwindowpayment").style.width=width1+"px"
		document.getElementById("dwindowpayment").style.height=height1+"px"
		document.getElementById("dwindowpayment").style.left="320px"
		document.getElementById("dwindowpayment").style.top="330px"
		document.getElementById("cframepayment").src=url
	}
}


function closeithistory(){
	document.getElementById("dwindowhistory").style.display="none"
}
function closeitpayment(){
	document.getElementById("dwindowpayment").style.display="none"
}
function stopdraghistory(){
dragapproved=false;
document.getElementById("dwindowhistory").onmousemove=null;
document.getElementById("dwindowcontenthistory").style.display="" //extra
}

function stopdragpayment(){
dragapproved=false;
document.getElementById("dwindowpayment").onmousemove=null;
document.getElementById("dwindowcontentpayment").style.display="" //extra
}