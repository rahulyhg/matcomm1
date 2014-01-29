function $(obj) {
   if(document.getElementById) {
        if(document.getElementById(obj)!=null) {
            return document.getElementById(obj)
        } else {
           return "";
       }
    } else if(document.all) {
        if(document.all[obj]!=null) {
            return document.all[obj]
        } else  {
          return "";
       }
    }
} 
function $BN(dn,s) { var d=$(dn); (s=="b") ? ss="block" : ss="none"; if(d!='') { d.style.display=ss; } }

function showscore(c)
{
	var c;var x=$('ardown');
	var x1=$('scoreshowdown');
	var y=$('arup');
	var y1=$('scoreshowup');
	y1.style.display=="none";
	if(c.length<1){return;}if($(c).style.display=="none"){$(c).style.display="block";x.style.display="none";x1.style.display="none";y.style.display="block";y1.style.display="block";}else{$(c).style.display="none";x.style.display="block";x1.style.display="block";y.style.display="none";y1.style.display="none";}
}

function openWin(url,w,h) {
	window.open(url,'','directories=no,width='+w+',height='+h+',menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');
}
function openmsgr()
{
	window.open('../messenger/Mainview26.html','newWin','width=262,height=380,top=10,left=60,scrollbars=no');
}//openindex

function selectedids(chrt,frm,idname) { 
var cval='';
for(i=0;i<eval("window.parent.document."+frm+".length");i++) { 
	if(eval("window.parent.document."+frm+".elements["+i+"].type=='checkbox'") && eval("window.parent.document."+frm+".elements["+i+"].name!='"+idname+"'") && eval("window.parent.document."+frm+".elements["+i+"].name!='"+idname+"1'")) { 
		if(eval("window.parent.document."+frm+".elements["+i+"].checked")) {
			cval+=eval("window.parent.document."+frm+".elements["+i+"].value")+chrt;
		} 
	} 
} 
if(cval.length>0) {
	cval=cval.substring(0,cval.length-1);
} return cval; 
}
function chkbox_check(frmname,name,idname) { 
	var chk_type=$(name); 	
	var formname = frmname;
	var chkchk = chk_chkall(formname);
	if(chkchk ==false) { 
		$(idname).checked=false;
		$(idname+'1').checked=false;
	} else { 
		$(idname).checked=true;
		$(idname+'1').checked=true;
	}
}
function selectall(frmname,idname) {
	var formname = frmname;
	if($(idname).checked) { mult_chk(formname); }
	else { mult_unchk(formname); }
}
function chk_chkall(formname) { 
	var p=formname; var cchk=0;
	for (i=1;i<p.length-1;i++) { 
		if(p.elements[i].type=="checkbox" && p.elements[i].checked==true) { cchk++; }
		else { return false; break; }
	}
	return true;
}
function getRadioValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

			
function mult_unchk(formname) { var p=formname; for (i=0;i<p.length;i++) { if(p.elements[i].type=="checkbox") { p.elements[i].checked=false; } } }
function mult_chk(formname) { var p=formname; for (i=0;i<p.length;i++) { if(p.elements[i].type=="checkbox") { p.elements[i].checked=true; } } }

function show_box(e,divname)
{
	previnnerdiv = divname;
	var posi = new Array();
	posi=trackClick(e);
	$(divname).style.visibility="visible";
}

function hide_box_div(divname)
{
	previnnerdiv = '';
	$(divname).style.visibility="hidden";
}

function trackClick(e) {
	var posi = new Array();
	if (document.layers)
	{
		posi[0]=e.pageX;
		posi[1]=e.pageY;
	}
	else
	{
		posi[0]=e.clientX+document.body.scrollLeft;
		posi[1]=e.clientY+document.body.scrollTop;
	}
	return posi;
}

var bt_timeout = 8;
var bt_text_finished = '';
var bt_text_prefix = '';

function hidediv(d) {  
if(d.length < 1) { return; } document.getElementById(d).style.display = "none"; }  
function showdiv(d) {  
if(d.length < 1) { return; } document.getElementById(d).style.display = "block"; }  
function showhidediv(d) {  
if(d.length < 1) { return; }  
if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }  
else { document.getElementById(d).style.display = "none"; }  
}  


function chntxt()
{
	if(document.getElementById('linktxt').innerHTML == 'More')
		document.getElementById('linktxt').innerHTML='Less';
	else
		document.getElementById('linktxt').innerHTML='More';
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
}