function getipphone(){
var ippd=document.getElementById("ipphonedis");
ippd.innerHTML="<div style='background: url(http://img.jainmatrimony.com/images/phone-bg.gif) repeat-y;width:165px;'><div style='background:#9A9A9A;margin-left:61px !important;margin-left:61px;width:98px;height:1px'><img src='http://img.jainmatrimony.com/images/trans.gif' width='98' height='1' border='0'></div><div style='margin-left:7px;margin-right:7px;'><img src='http://img.jainmatrimony.com/images/trans.gif' width='1' height='10' border='0'><br><font class='smalltxt'><b>24x7 round the clock</b><br><div style='padding:0px 0px 5px 0px '><div style='height:1px;background-color:#D5D5D5;width:145px;border-top:1px solid #ffffff;'><img src='http://img.jainmatrimony.com/images/trans.gif' width='145' height='1' border='0'></div></div>India&nbsp;&nbsp;: 91-44-32002433<br>USA&nbsp;&nbsp;: 1-866-502-2488<br>UK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0808-234-6488<br><img src='http://img.jainmatrimony.com/images/trans.gif' width='1' height='5' border='0'><br><b>Weekday Business Hours</b><br><div style='padding:0px 0px 5px 0px '><div style='height:1px;background-color:#D5D5D5;width:145px;border-top:1px solid #ffffff;'><img src='http://img.jainmatrimony.com/images/trans.gif' width='145' height='1' border='0'></div></div><div style='width:60px' class='fleft'>Mumbai</div><div class='fleft'>: 022-28399399</div><br clear='all'> <div style='width:60px' class='fleft'>Delhi</div><div class='fleft'>: 011-46572717</div><br clear='all'> <div style='width:60px' class='fleft'>Kolkata</div><div class='fleft'>: 033-22263908</div><br clear='all'>  <div style='width:60px' class='fleft'>Hyderabad</div><div class='fleft'>: 040-27630661</div><br clear='all'> <div style='width:60px' class='fleft'>Bangalore</div><div class='fleft'>: 080-25599288</div><br clear='all'> <div style='width:60px' class='fleft'>Chennai</div><div class='fleft'>: 044-42298700</div><br clear='all'> <div style='width:60px' class='fleft'>Cochin</div><div class='fleft'>: 484-2408850</div><br clear='all'><div style='width:60px' class='fleft'>UAE</div><div class='fleft'>: 971-4-3369989</div><br clear='all'></font><div style='padding:5px 0px 5px 0px '><div style='height:1px;background-color:#D5D5D5;width:145px;border-top:1px solid #ffffff;'><img src='http://img.jainmatrimony.com/images/trans.gif' width='145' height='1' border='0'></div></div><div style='text-align:right;padding: 0px 7px 3px 0px;'><a href='http://www.jainmatrimony.com/site/index.php?act=feedback' class='smalltxt clr1'>More >></a><br clear='all'></div></div></div>  <div style='background: url(http://img.jainmatrimony.com/images/phone-bg-bottom.gif) no-repeat;width:165px;height:7px;'><img src='http://img.jainmatrimony.com/images/trans.gif' width='165' height='1' border='0'></div>";
ippd.style.display="block";
showphone("ipphone", "ipphonedis", "click", "y", "none");
}

function pnodisp(){getipphone();}

function phone_show_aux(parent, child){
  var p = document.getElementById(parent);
  var c = document.getElementById(child );
  var top  = (c["phone_position"] == "y") ? p.offsetHeight : 0;
  var left = (c["phone_position"] == "x") ? p.offsetWidth : 0;
  for (; p; p = p.offsetParent){
    top  += p.offsetTop;
    left += p.offsetLeft;
  }
  c.style.position   = "absolute";
  c.style.top        = top +'px';
  c.style.left       = (left-1)+'px';
  c.style.visibility = "visible";
}
// ***** phone_show *****
function phone_show(){
	if(document.getElementById('bannerdiv')){document.getElementById('bannerdiv').style.display="none";}
  var p = document.getElementById(this["phone_parent"]);
  var c = document.getElementById(this["phone_child" ]);
  phone_show_aux(p.id, c.id);
  clearTimeout(c["phone_timeout"]);
}
// ***** phone_hide *****
function phone_hide(){
  var p = document.getElementById(this["phone_parent"]);
  var c = document.getElementById(this["phone_child" ]);
  c["phone_timeout"] = setTimeout("document.getElementById('"+c.id+"').style.visibility = 'hidden'", 333);
  if(document.getElementById('bannerdiv')){document.getElementById('bannerdiv').style.display="block";}
}
// ***** phone_click *****
function phone_click(){
	if(document.getElementById('bannerdiv')){document.getElementById('bannerdiv').style.display="none";}
  var p = document.getElementById(this["phone_parent"]);
  var c = document.getElementById(this["phone_child" ]);
  if (c.style.visibility != "visible") phone_show_aux(p.id, c.id); else c.style.visibility = "hidden";
  return false;
}
function showphone(parent, child, showtype, position, cursor){
  var p = document.getElementById(parent);
  var c = document.getElementById(child);
  p["phone_parent"]     = p.id;
  c["phone_parent"]     = p.id;
  p["phone_child"]      = c.id;
  c["phone_child"]      = c.id;
  p["phone_position"]   = position;
  c["phone_position"]   = position;
  c.style.position   = "absolute";
  c.style.visibility = "hidden";
  if (cursor != undefined) p.style.cursor = cursor;
  switch (showtype){
    case "click":
      p.onclick     = phone_click;
      p.onmouseout  = phone_hide;
      c.onmouseover = phone_show;
      c.onmouseout  = phone_hide;
      break;
    case "hover":
      p.onmouseover = phone_show;
      p.onmouseout  = phone_hide;
      c.onmouseover = phone_show;
      break;
  }
}