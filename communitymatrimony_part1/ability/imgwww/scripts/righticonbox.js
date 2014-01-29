function icon_show_aux(parent, child){
  var horizontaloffset = 13;
  var verticaloffset=12
  var par = $(parent);
  var cld = $(child );
  var left=findPosX(par)-168+par.offsetWidth+horizontaloffset;
  var top=findPosY(par)-verticaloffset;
  cld.style.position   = "absolute";
  cld.style.top        = top +'px';
  cld.style.left       = left+'px';
  if(top>0 && left>0){cld.style.visibility= 'visible';}
}

function icon_show(){
  var par = $(this["phone_parent"]);
  var cld = $(this["phone_child" ]);
  icon_show_aux(par.id, cld.id);
}

function icon_hide(){
  var par = $(this["phone_parent"]);
  var cld = $(this["phone_child" ]);
  $(cld.id).style.visibility = 'hidden';
}

function findPosX(obj)
{
    var curleft = 0;
    if(obj.offsetParent)
        while(1) 
        {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
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
	{
        while(1)
        {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
	}
    else if(obj.y)
	{
        curtop += obj.y;
	}
    return curtop;
}

function iconview(parent,child,phoneVal,voiceVal,matrirefVal,videoVal,contVal,horoVal,sessId,matid,phlock,vidlock,holock){
if(wload==1){
var p = $(parent);
var idiv = document.createElement('div');
var icname;
idiv.setAttribute("id",child);
idiv.className="iconclass";
idiv.style.width="168px";
idiv.style.visibility="hidden";
document.body.appendChild(idiv);

var c = $(child);
p["phone_parent"]     = p.id;
c["phone_parent"]     = p.id;
p["phone_child"]      = c.id;
c["phone_child"]      = c.id;
p["phone_position"]   = "x";
c["phone_position"]   = "x";
		  
var hrefurl="javascript:;";

var purl   = '',vurl = '',murl = '',vicurl ='',viurl='',conurl='', hourl='';
var pclass = '',vclass = '',mclass = '',viclass ='',hoclass='',conclass ='',ph_txt='',vi_txt='',ho_txt='';
var reg_lnk= ser_url+'/register/index.php?act=addbasic&';

//req=ph&oid=C100024

if(phoneVal=="1"){
	if(cook_id != ''){
	phref = "href='"+hrefurl+"' onClick=\"funIframeURL('phone/phoneview.php?id="+matid+"','500','285','iframeicon','icondiv')\"";
	}else{
	phref = "href='"+reg_lnk+'req=vph&oid='+matid+"'";
	}

	if(phlock == 1){
	ph_txt = '<img src="'+imgs_url+'/protect-icon.gif" hspace="5">';
	}

	purl = '<div style="padding-top:0px;"><a '+phref+' class="clr1">'+ph_txt+'View Phone Number</a></div>';
	pclass = '<div style="padding-top:1px;"><div class="useracticonsimgs phone"></div></div>';
} else if (sessId != matid) {
	if(cook_id != ''){
	phref = "href='"+hrefurl+"' onClick=\"funIframeURL('request/request.php?id="+matid+"&rid=3','500','230','iframeicon','icondiv')\"";
	}else{
	phref = "href='"+reg_lnk+'req=ph&oid='+matid+"'";
	}
	purl = '<div style="padding-top:0px;"><a '+phref+' class="clr1">Request Phone Number</a></div>';
	pclass = '<div style="padding-top:1px;"><div class="useracticonsimgs pphone"></div></div>';
}

if(voiceVal=="1"){
	if(cook_id != ''){
	vhref = "href='"+hrefurl+"' onClick=\"funIframeTools('voice/voiceshow.php?ID="+matid+"','525','570','iframeicon','icondiv')\"";
	}else{
	vhref = "href='"+reg_lnk+'req=vvo&oid='+matid+"'";
	}
	vurl = '<div style="padding-top:2px;"><a '+vhref+' class="clr1">Listen to Voice Profile</a></div>';
	vclass = '<div style="padding-top:2px;"><div class="useracticonsimgs voice"></div></div>';
} else if (sessId != matid) {
	if(cook_id != ''){
	vhref = "href='"+hrefurl+"' onClick=\"funIframeURL('request/request.php?id="+matid+"&rid=4','500','260','iframeicon','icondiv')\"";
	}else{
	vhref = "href='"+reg_lnk+'req=vo&oid='+matid+"'";
	}
	vurl = '<div style="padding-top:2px;"><a '+vhref+' class="clr1">Request Voice Profile</a></div>';
	vclass = '<div style="padding-top:2px;"><div class="useracticonsimgs pvoice"></div></div>';
}

if(matrirefVal=="1"){
	if(cook_id != ''){
	mhref = "href='"+hrefurl+"' onClick=\"funIframeTools('reference/referenceview.php?id="+matid+"','500','550','iframeicon','icondiv')\"";
	}else{
	mhref = "href='"+reg_lnk+'req=vref&oid='+matid+"'";
	}
	murl = '<div style="padding-top:2px;"><a '+mhref+' class="clr1">View Reference</a></div>';
	mclass = '<div style="padding:2px 0px 0px 2px;"><div class="useracticonsimgs matriref"></div></div>';
} else if (sessId != matid) {
	if(cook_id != ''){
	mhref = "href='"+hrefurl+"' onClick=\"funIframeURL('request/request.php?id="+matid+"&rid=2','500','310','iframeicon','icondiv')\"";
	}else{
	mhref = "href='"+reg_lnk+'req=ref&oid='+matid+"'";
	}
	murl = '<div style="padding-top:2px;"><a '+mhref+' class="clr1">Request Reference</a></div>';
	mclass = '<div style="padding:2px 0px 0px 2px;"><div class="useracticonsimgs pmatriref"></div></div>';
}

if(videoVal=="1"){
	if(cook_id != ''){
	vihref = "href='"+hrefurl+"' onClick=\"funIframeURL('video/videoverifyview.php?ID="+matid+"','525','222','iframeicon','icondiv')\"";
	}else{
	vihref = "href='"+reg_lnk+'req=vve&oid='+matid+"'";
	}

	if(vidlock == 1){
	vi_txt = '<img src="'+imgs_url+'/protect-icon.gif" hspace="5">';
	}

	viurl = '<div style="padding-top:2px;"><a '+vihref+' class="clr1">'+vi_txt+'View Video</a></div>';
	viclass = '<div style="padding-top:4px;"><div class="useracticonsimgs video"></div></div>';
} else { viurl='';viclass=''; }

if(horoVal=="1"){
	hohref = "href='"+hrefurl+"' onClick=\"openWin('"+img_url+'/horoscope/viewhoroscope.php?ID='+matid+"','626','600')\"";

	if(holock == 1){
	ho_txt = '<img src="'+imgs_url+'/protect-icon.gif" title="horoscope protected" hspace="5">';
	}

	hourl = '<div style="padding-top:2px;"><a '+hohref+' class="clr1">'+ho_txt+'View Horoscope</a></div>';
	hoclass = '<div style="padding-top:2px;"><div class="useracticonsimgs horo"></div></div>';
} else if(sessId != matid){ 
	if(cook_id != ''){
	hohref = "href='"+hrefurl+"' onClick=\"funIframeURL('request/request.php?id="+matid+"&rid=5','500','245','iframeicon','icondiv')\"";
	}else{
	hohref = "href='"+reg_lnk+'req=hor&oid='+matid+"'";
	}
	hourl = '<div style="padding-top:4px;"><a '+hohref+' class="clr1">Request Horoscope</a></div>';
	hoclass = '<div style="padding-top:2px;"><div class="useracticonsimgs phoro"></div></div>';
}

if(contVal != ''){
	conhref = "href='"+hrefurl+"' onClick=\"funIframeURL('mymessages/contacthistory.php?ID="+matid+"','525','350','iframeicon','icondiv')\"";
	conurl = '<div style="padding-top:4px;"><a '+conhref+' class="clr1">View Contact History</a></div>';
	conclass = '<div style="padding-top:4px;"><div class="useracticonsimgs '+contVal+'"></div></div>';
} else { conurl='';conclass=''; }

c.innerHTML='<div class="icon-menu1"><div class="icon-menu2 fleft"><div style="width:130px;text-align:right;" class="fleft"><div style="padding: 2px 0px 8px 5px;" class="smalltxt">'+purl+''+vurl+''+murl+''+viurl+''+hourl+''+conurl+'</div></div><div class="fleft" style="padding: 1px 0px 8px 5px;"><div id="useracticons"><div id="useracticonsimgs" style="float:left;text-align: middle;">'+pclass+''+vclass+''+mclass+''+viclass+''+hoclass+''+conclass+'</div></div></div></div></div>';
p.onmouseover = icon_show;
p.onmouseout  = icon_hide;
c.onmouseover = icon_show;
c.onmouseout  = icon_hide;
}
}