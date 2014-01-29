var fimgpath=DOMAINARRAY['domainnameimgs'];var over;var overdiv;var dheight=0;

var ie4=document.all
var ns6=document.getElementById&&!document.all

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function fadewin(maindiv,fdivname,dispdiv,dispdivw,dispdivh,frmname,bcontent)
{
try{
if(wload==1){
		hideSelectBoxes();
		if($('bannerdiv')){$('bannerdiv').style.display="none";}
		if($('logoutbannerdiv')){$('logoutbannerdiv').style.display="none";}
		var newdiv= document.createElement('div');
		 newdiv.setAttribute("id",'fadedivwin');
		 newdiv.className="fadediv";
		 newdiv.style.display='block';
		
		 if( document.body && ( document.body.scrollWidth || document.body.scrollHeight ) ) 
		{newdiv_width = document.body.scrollWidth+'px';newdiv_height = document.body.scrollHeight+'px';}
		 else if( document.body.offsetWidth ) 
		{
		 newdiv_width = document.body.offsetWidth+'px';
		 newdiv_height= document.body.offsetHeight+'px';    
		 } else 
		{newdiv_width='100%';newdiv_height='100%';}

		newdiv.style.width=newdiv_width;
		newdiv.style.height=newdiv_height;

		document.body.appendChild(newdiv)       

		newdiv.style.top=document.body.offsetTop;
		newdiv.style.left=document.body.offsetLeft

	fadewin1(dispdiv,dispdivw,dispdivh,frmname,bcontent);
  }
}
	catch(e) { alert(e); }
}

function fadewin1(dispdiv,dispdivw,dheight,frmname,bcontent)
{
	var over=over=$('fadedivwin');
	var overdiv= document.createElement('div');
	var content="<div id='dispcontent' style='background-color:white;overflow:auto;height:"+dheight+"px;width:"+(parseInt(dispdivw)-25)+"' class='smalltxt'><div style='padding:0 20 20 20'>"+bcontent+"</div></div>";
	overdiv.setAttribute("id",dispdiv);
	overdiv.className="dispdiv";
	overdiv.style.width=dispdivw+"px";

	document.body.appendChild(overdiv);
	//var topmsg="<table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr><td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></td><td valign='top' background='http://"+fimgpath+"/bmimages/pop-top-tile.gif' width='100%' height='11'></td><td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+fimgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+fimgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:fadewinclosediv('fadedivwin','"+dispdiv+"','"+frmname+"')\" style='cursor:pointer'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'>";

	//var botmsg="</td><td valign='top' width='11' background='http://"+fimgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+fimgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr>		<td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+fimgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>		<td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";

	//overdiv.innerHTML=topmsg+content+botmsg;
	overdiv.innerHTML="<table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr><td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></td><td valign='top' background='http://"+fimgpath+"/bmimages/pop-top-tile.gif' width='100%' height='11'></td><td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+fimgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+fimgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:fadewinclosediv('fadedivwin','"+dispdiv+"','"+frmname+"')\" style='cursor:pointer'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'>"+content+"</td><td valign='top' width='11' background='http://"+fimgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+fimgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr>		<td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+fimgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>		<td valign='top'><img src='http://"+fimgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";
	
	
	var winh=window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset

	overdiv.style.left=(document.body.offsetWidth-dispdivw)/2+"px";
	overdiv.style.top=topedge+parseInt(winh/4)+"px";

	overdiv.style.display='block';
}

function fadewinclosediv(divname,dispdiv,frmname)
{
	var d3=document.getElementById(dispdiv);
	document.body.removeChild(d3);
	removeDiv(divname);
	if($('bannerdiv')){$('bannerdiv').style.display="block";}
	if($('logoutbannerdiv')){$('logoutbannerdiv').style.display="block";}
	showSelectBoxes(frmname);
}

