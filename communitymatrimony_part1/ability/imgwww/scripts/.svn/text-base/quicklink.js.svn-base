function quicklinkdisp()
{
	if (document.getElementById){
		if(document.getElementById('bannerdiv')){document.getElementById('bannerdiv').style.display="none";}
	var curobj=document.getElementById('quicklinkdisp');
	var srch_saveobj=document.getElementById('quicklinkdis');
	srch_saveobj.style.left=srch_getposOffset(curobj, "left")+"px";
	srch_saveobj.style.top=srch_getposOffset(curobj, "top")+29+"px";
	srch_saveobj.style.display="block";
	showquick();
	}
}
function showquick()
{
  var p = document.getElementById('quicklinkdisp');
  var c = document.getElementById('quicklinkdis');
  p["phone_parent"]     = p.id;
  c["phone_parent"]     = p.id;
  p["phone_child"]      = c.id;
  c["phone_child"]      = c.id;
  p["phone_position"]   = "y";
  c["phone_position"]   = "y";
  c.style.position   = "absolute";
  c.style.visibility = "visible";
  showtype="click";
  cursor="default";
  if (cursor != undefined) p.style.cursor = cursor;
   p.onclick     = quicklinkdisp;
   p.onmouseout  = quicklinkout;
   c.onmouseover = quicklinkdisp;
   c.onmouseout  = quicklinkout;
}
function quicklinkout()
{
	document.getElementById('quicklinkdis').style.visibility="hidden";
	if(document.getElementById('bannerdiv')){document.getElementById('bannerdiv').style.display="block";}
}