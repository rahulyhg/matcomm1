function smallfont(opt) {
  active = getActiveStyleSheet();
  setActiveStyleSheet('smf');
}

function medfont() {
  active = getActiveStyleSheet();
  setActiveStyleSheet('mdf');
}
function larfont() {
  active = getActiveStyleSheet();
  setActiveStyleSheet('lrg');
}

function fontchg(opt)
{
	if(opt=='sm'){$('small').className='clr bld';}else{$('small').className='clr1';}
	if(opt=='md'){$('med').className='clr bld';}else{$('med').className='clr1';}
	if(opt=='lg'){$('large').className='clr bld';}else{$('large').className='clr1';}
}

function setActiveStyleSheet(title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
}

function getActiveStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled) return a.getAttribute("title");
  }
  return null;
}

function getPreferredStyleSheet() {
  return ('smf');
}


function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

window.onload = function(e) {
  var cookie = readCookie("style");
  var title = cookie ? cookie : getPreferredStyleSheet();
  setActiveStyleSheet(title);
	
	if(title=='smf'){$('small').className='clr bld';}else{$('small').className='clr1';}
	if(title=='mdf'){$('med').className='clr bld';}else{$('med').className='clr1';}
	if(title=='lrg'){$('large').className='clr bld';}else{$('large').className='clr1';}
}

window.onunload = function(e) {
  var title = getActiveStyleSheet();
  createCookie("style", title, 365);
}

var cookie = readCookie("style");
var title = cookie ? cookie : getPreferredStyleSheet();
if (title == 'null') {
  title = getPreferredStyleSheet();
}

setActiveStyleSheet(title);